<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    function get_user_by_phone($data)
    {
        $user = $this->db->where($data)->get('users');
        if ($user->num_rows() > 0) {
            return $user->row();
        }
        return false;
    }

    function set_otp($data, $otp)
    {
        $this->db->set('otp', $otp)->where($data)->update('users');
        $update_otp = $this->db->affected_rows();
        return $update_otp > 0 ? true :  false;
    }

    function add_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    function verify($data)
    {
        $user = $this->db->where(array('phone' => $data['phone'], 'otp' => $data['otp']))->get('users');
        if ($user->num_rows() > 0) {
            return $user->row_array();
        }
        return false;
    }

    function update_last_login($user_id, $update_data)
    {
        return $this->db->where('id', $user_id)->update('users', $update_data);
    }
}