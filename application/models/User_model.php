<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    function get_user_data_by_id($id)
    {
        $user = $this->db->where('id', $id)->get('users');
        if ($user->num_rows() > 0) {
            return $user->row_array();
        }
        return false;
    }

    function update_profile($user_id, $update_data)
    {
        return $this->db->where('id', $user_id)->update('users', $update_data);
    }
}