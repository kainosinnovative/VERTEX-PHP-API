<?php

/**
 * All common DB-connection functions will be written here
 *
 *
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login_model extends CI_Model
{

    public function get_user_credential($UserId)
        {
            $this->db->select('*');
            $this->db->from('tUser');
            $this->db->where('UserId', $UserId);
            return $this->db->get()->row_array();
        }


        public function getroleDetails($UserTypeId)
        {
            $this->db->select('*');
            $this->db->from('tUserType');
            $this->db->where('UserTypeId', $UserTypeId);
            return $this->db->get()->row_array();
        }

        public function checkuser($UserId){
        $result = $this->db->query("SELECT count(*) as cnt from tUser where (UserId='$UserId')")->row_array();
            $cnt = $result['cnt'];
            return $cnt;
          }

          public function generateToken($data)
    {
        $jwt = JWT::encode($data, $this->key);
        return $jwt;
    }
    public function getUserType()
    {
        $this->db->select('*');
            $this->db->from('tUserType');
            // $this->db->where('shop_id', $shop_id);
            return $this->db->get()->row_array();
    }
}