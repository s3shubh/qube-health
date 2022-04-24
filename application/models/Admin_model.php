<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function make_query()
    {
        // echo $_POST["search"]["value"];
        // die;
        $this->db->select('id,phone,first_name,last_name,role_id,is_active,last_login_at');
        $this->db->from('users');
        $this->db->where('is_deleted', 0);
        if ($_POST["is_date_search"] == "yes") {
            if ($_POST["start_date"]) {
                $start_date = $_POST["start_date"];
            } else {
                $start_date = NULL;
            }

            if ($_POST["end_date"]) {
                $end_date = $_POST["end_date"];
            } else {
                $end_date = NULL;
            }

            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
        }

        if (!empty($_POST["search"]["value"])) {
            $this->db->like("first_name", $_POST["search"]["value"]);
            $this->db->or_like("last_name", $_POST["search"]["value"]);
            $this->db->or_like("phone", $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $columns = array('phone', 'first_name', 'last_name', 'role_id', 'is_active', 'last_login_at');
            $this->db->order_by($columns[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    }

    function make_datatables()
    {

        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data()
    {
        $this->db->select("*");
        $this->db->from('users');
        return $this->db->count_all_results();
    }
    function delete_user($id)
    {
        $this->db->set('is_deleted', 1)->where('id', $id)->update('users');
        $update_otp = $this->db->affected_rows();
        return $update_otp > 0 ? true :  false;
    }
}