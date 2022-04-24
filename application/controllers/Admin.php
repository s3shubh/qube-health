<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin_model");
        $this->load->model("user_model");
        $this->load->model("auth_model");
        if (!$this->session->userdata('user_login') || $this->session->userdata('role_id') != 1) {
            $this->session->set_flashdata('error_message', 'Access denied');
            return redirect(site_url('auth'), 'refresh');
        }
    }

    function index()
    {
        $page_data['page_name'] = 'list_users';
        $this->load->view('index', $page_data);
    }
    function fetchData()
    {
        $fetch_data = $this->admin_model->make_datatables();
        $data = array();
        $i = 0;
        foreach ($fetch_data as $row) {
            $sub_array   = array();
            $sub_array[] = $row["first_name"];
            $sub_array[] = $row["last_name"];
            $sub_array[] = $row["phone"];
            $sub_array[] = $row["last_login_at"];
            if ($row["role_id"] == '1') {
                $sub_array[] = 'Admin';
            } else {
                $sub_array[] = 'User';
            }
            if ($row["is_active"] == '1') {
                $check = 'checked';
            } else {
                $check = '';
            }
            $sub_array[] = '<div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customSwitch' . $row["id"] . '-' . $i . '" ' . $check . ' onClick="changeStatus(' . $row["id"] . ',' . $row["is_active"] . ')">
                      <label class="custom-control-label" for="customSwitch' . $row["id"] . '-' . $i . '"></label>
                    </div>
                  </div>';
            $confirmMessage = 'Are you sure u want to delete this User?';
            $sub_array[] = '<center><div class="btn-group">
                            	<a class="tip btn btn-primary btn-xs" title="Edit User" href="' . base_url() . 'admin/edit_user/' . $row["id"] . '"> <i class="fa fa-edit"></i> </a> &nbsp;&nbsp; <a class="tip btn btn-danger btn-xs"  href="' . base_url() . 'admin/delete_user/' . $row["id"] . '" onClick="return confirm(\'' . $confirmMessage . '\');">
                                <i class="fa fa-trash"></i>
                            </a></div></center>';
            $data[]       = $sub_array;
            $i++;
        }
        $output = array(
            "draw"             => intval($_POST["draw"]),
            "recordsTotal"     => $this->admin_model->get_all_data(),
            "recordsFiltered"  => $this->admin_model->get_filtered_data(),
            "data"             => $data
        );
        echo json_encode($output);
    }

    function activeInactive($id)
    {
        $active = $this->input->post('active');
        if ($active == '1') {
            $newActive = '0';
        } else {
            $newActive = '1';
        }

        $up = $this->db->set('is_active', $newActive)->where('id', $id)->update('users');
        echo $up;
    }

    function add_user()
    {
        if ($this->input->post()) {
            $input_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'phone'      => $this->input->post('phone'),
                'is_active'  => 0,
                'is_deleted' => 0,
                'role_id'    => 2,
                'created_at' => date('Y-M-d H:i:s')
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
                $user = $this->auth_model->add_user($input_data);
                $this->session->set_flashdata('flash_message', 'New user added successful');
                return redirect(site_url('admin'), 'refresh');
            } else {
                $this->session->set_flashdata('error_message', 'Unable to add new user try again.');
                return redirect(site_url('admin'), 'refresh');
            }
        } else {
            $page_data['page_name'] = 'add_user';
            $this->load->view('index', $page_data);
        }
    }

    function edit_user($id)
    {
        if ($this->input->post()) {
            $input_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'phone'      => $this->input->post('phone'),
                'is_deleted' => 0,
                'updated_at' => date('Y-M-d H:i:s')
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
                $user = $this->user_model->update_profile($id, $input_data);
                $this->session->set_flashdata('flash_message', 'User edited successful');
                return redirect(site_url('admin'), 'refresh');
            } else {
                $this->session->set_flashdata('error_message', 'Unable to update user try again.');
                return redirect(site_url('admin'), 'refresh');
            }
        } else {
            $page_data['user'] = $this->user_model->get_user_data_by_id($id);
            $page_data['user_id'] = $id;
            $page_data['page_name'] = 'edit_user';
            $this->load->view('index', $page_data);
        }
    }

    function delete_user($id)
    {
        $DeletetData = $this->admin_model->delete_user($id);
        if ($DeletetData) {
            $this->session->set_flashdata('flash_message', 'User deleted successfull');
            return redirect(base_url('admin'));
        } else {
            $this->session->set_flashdata('flash_error', 'Failed to delete user');
            return redirect(base_url('admin'));
        }
    }
}