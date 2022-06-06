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

    public function get_user_cardential($emailid)
        {
            $this->db->select('*');
            $this->db->from('tUser');
            $this->db->where('EmployeeId', $emailid);
            return $this->db->get()->row_array();
        }

    
        public function getroleDetails($UserTypeId)
        {
            $this->db->select('*');
            $this->db->from('tUserType');
            $this->db->where('UserTypeId', $UserTypeId);
            return $this->db->get()->row_array();
        }

        public function checkuser($EmployeeId){
//             $this->db->where('emailid', $emailid);
// $query = $this->db->get('users');
// echo $query->num_rows();
$result = $this->db->query("SELECT count(*) as cnt from tUser where (EmployeeId='$EmployeeId')")->row_array();
            $cnt = $result['cnt'];
            return $cnt;
          }

          public function generateToken($data)
    {
        $jwt = JWT::encode($data, $this->key);
        return $jwt;
    }
}