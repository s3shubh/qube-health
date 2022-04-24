<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("auth_model");
    }
    function index()
    {
        if ($this->session->userdata('user_login') && $this->session->userdata('role_id') == 1) {
            return redirect(site_url('admin'), 'refresh');
        } elseif ($this->session->userdata('user_login') && $this->session->userdata('role_id') == 2) {
            return redirect(site_url('user'), 'refresh');
        } else {
            return redirect(site_url('auth/login'), 'refresh');
        }
    }

    function profile()
    {
        $this->load->view('profile');
    }
    function login()
    {
        if ($this->input->post()) {

            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|min_length[10]|max_length[10]|numeric|required');
            if ($this->form_validation->run() == FALSE) {
                $data = ['errors' => validation_errors()];
                $this->session->set_flashdata('error_message', 'Invalid phone number');
                return redirect('auth/login', 'refresh');
            } else {
                $input_data = ['phone' => $this->input->post('phone')];
                $input_data = $this->security->xss_clean($input_data);
                $chech_user = $this->auth_model->get_user_by_phone($input_data);
                $otp = rand(1111, 9999);
                if ($chech_user) {
                    $set_otp = $this->auth_model->set_otp($input_data, $otp);
                    $is_otp_sent = $this->send_otp($otp, $this->input->post('phone'));
                    if ($set_otp && $is_otp_sent) {
                        $this->load->view('auth/verify_otp', $input_data);
                    } else {
                        $this->session->set_flashdata('error_message', 'Unable to send  otp try again later');
                        return redirect(site_url('auth/login'), 'refresh');
                    }
                } else {
                    $insert_data = [
                        'phone'         => $this->input->post('phone'),
                        'ip_address'    => $this->input->ip_address(),
                        'otp'           => $otp,
                        'role_id'       => 2,
                        'is_active'     => 1,
                        'is_deleted'    => 1,
                        'created_at'    => date('Y-m-d H:i:s')
                    ];
                    $insert_data = $this->security->xss_clean($insert_data);
                    $add_user = $this->auth_model->add_user($insert_data, $otp);
                    $is_otp_sent = $this->send_otp($otp, $this->input->post('phone'));
                    if ($add_user && $is_otp_sent) {
                        $this->load->view('auth/verify_otp', $input_data);
                    } else {
                        $this->session->set_flashdata('error_message', 'Unable to send  otp try again later');
                        return redirect(site_url('auth/login'), 'refresh');
                    }
                }
            }
        } else {
            $this->load->view('auth/login');
        }
    }

    function verify($otp = '')
    {
        if ($this->input->post()) {
            $user_opt = '';
            foreach ($this->input->post('otp') as $val) {
                $user_opt .= $val;
            }
            $input_data =  [
                'phone' => $this->input->post('phone'),
                'ip'    => $this->input->ip_address(),
                'otp'   => $user_opt
            ];
            $input_data = $this->security->xss_clean($input_data);
            $verify = $this->auth_model->verify($input_data);
            if ($verify) {
                if ($verify['is_active'] == 1 && $verify['is_deleted'] == 0) {
                    $user_data = [
                        'phone'     => $verify['phone'],
                        'role_id'   => $verify['role_id'],
                        'name'      => $verify['first_name'] . ' ' . $verify['last_name'],
                        'user_id'   => $verify['id'],
                        'user_login' => true
                    ];
                    $this->session->set_userdata($user_data);
                    if ($this->session->userdata('user_login')) {
                        $update_data = [
                            'otp'           => null,
                            'ip_address'    => $this->input->ip_address(),
                            'last_login_at' => date('Y-m-d H:i:s')
                        ];
                        $update_last_login = $this->auth_model->update_last_login($verify['id'], $update_data);
                        $this->session->set_flashdata('flash_message', 'Login Successful');
                        return redirect(site_url('user'), 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error_message', 'Your accound is deactivated please contact admin');
                    return redirect(site_url('auth/login'), 'refresh');
                }
            } else {
                $data = ['phone' => $this->input->post('phone')];
                $this->session->set_flashdata('error_message', 'invalid otp try again');
                $this->load->view('auth/verify_otp', $data);
            }
        } else {
            $this->load->view('auth/verify_otp');
        }
    }

    function send_otp($otp, $phone)
    {
        $fields = array(
            "variables_values" => "$otp",
            "route" => "otp",
            "numbers" => "$phone",
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => array(
                "authorization: RZDUaEK3NoqyLiXjMn6GtYBSC8wpAIFHVhe5kbdxJ0PQ9gmO1TtzAODY8CfSiWHry7UhL4eElag0FoVB",
                "accept: */*",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return false;
        } else {
            $data = json_decode($response);
            $sts = $data->return;
            if ($sts == false) {
                return false;
            } else {
                return true;
            }
        }
    }
    function logout()
    {
        //destroy sessions of specific userdata.
        $this->session->sess_destroy();
        return redirect(site_url('auth'), 'refresh');
    }
}