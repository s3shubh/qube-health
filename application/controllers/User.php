<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
        if (!$this->session->userdata('user_login') && $this->session->userdata('role_id') != 2) {
            $this->session->set_flashdata('error_message', 'User session expired please login again');
            return redirect(site_url('auth'), 'refresh');
        }
    }
    function index()
    {
        $page_data['page_name'] = 'profile';
        $this->load->view('index', $page_data);
    }

    function update_profile()
    {
        $error = '';
        $input_data = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $input_data = $this->security->xss_clean($input_data);
        $uploadPath = 'assets/images/profile/';

        if (!empty($_FILES["image"]["name"])) {
            $imageName = $_FILES['image']['name'];
            // File upload configuration 
            $img_file_name = str_replace(" ", "_", $imageName);
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = date('ymdHis') . '_' . $img_file_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $fileData = $this->upload->data();
                $input_data['profile_image'] = $fileData['file_name'];
            } else {
                $error = $this->upload->display_errors();
            }
        }
        if (empty($error)) {
            $user = $this->user_model->update_profile($this->session->userdata('user_id'), $input_data);
            $this->session->set_flashdata('flash_message', 'Profile updated Successful');
            return redirect(site_url('user'), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', 'Unable to update profile try again.');
            return redirect(site_url('user'), 'refresh');
        }
    }
}