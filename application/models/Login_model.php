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
    public function displayAllEmployee() {
		//$sql = "CALL selectallemployee()";
    //     $insert_user_stored_proc = "SelectAllCustomers";
    //   //  $data = array('name' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address);
    //     $result = $this->db->query($insert_user_stored_proc);
	// 	//$result = $this->db->query('CALL selectallemployee()');
    //     var_dump($result);
	// 	if ($result) {
	// 		return $this->db->get()->result_array();
	// 	}

	// 	return false;

    $query = $this->db->query("SelectAllCustomers");
        return $query->result();
	}

    function insert_user($VendorId,$LegalName, $TradeName, $AliasName, $Phone, $Email, $EIN_SSN, $VendorTypeId, $OutreachEmailOptIn
    //  $BusinessSize,$NAICSCodes,$CommodityCodes,  $BEClassificationId,$BusinessRegisteredInDistrict,$BusinessIsFranchisee,
    //  $Website,$CreatedDate,$UpdatedDate,$CreatedUserId,$UpdatedUserId,$BusinessRegisteredInSCC
     ) {
        $sp = "InsertInto ?, ?, ?, ?, ?, ?, ?, ? ,?, ?, ?,?,?,?,?,?,?,?,?,?,?";
       
        $data = array(
            'VendorId' => $VendorId,
            'LegalName' => $LegalName,
            'TradeName' => $TradeName,
            'AliasName' => $AliasName,
            'Phone' => $Phone,
            'Email' => $Email,
            'EIN_SSN' => $EIN_SSN,
            'VendorTypeId' => $VendorTypeId,
            'OutreachEmailOptIn' => $OutreachEmailOptIn,
            'BusinessSize' => '',
            'NAICSCodes' => '',
            'CommodityCodes' => '',
            'BEClassificationId' => '',
            'BusinessRegisteredInDistrict' => '',
            'BusinessIsFranchisee' => '',
            'Website' => '',
            'CreatedDate' => date('Y-m-d'),
            'UpdatedDate' => date('Y-m-d'),
            'CreatedUserId' => 'A0001',
            'UpdatedUserId' => 'A0001',
            'BusinessRegisteredInSCC' => '',
            
            
            );
            
            $result = $this->db->query($sp,$data);

		
	}
    
    // function insert_user1($CountryId, $CountryName) {
		// $sp_insert_user = "Execute InsertCountry(?, ?)";
        // $data = array('CountryId' => $CountryId, 'CountryName' => $CountryName);
        // $result = $this->db->query($sp_insert_user, $data);
        // if ($result) {
        //     return $result;
        // }
        // return NULL;
// }
        public function insert_user1($CountryId,$CountryName){
            $sp = "InsertCountry ?,? "; //No exec or call needed
            
            //No @ needed.  Codeigniter gets it right either way
            $params = array(
            'CountryId' => $CountryId,
            'CountryName' => $CountryName,
            );
            
            $result = $this->db->query($sp,$params);
        }

    public function AddCountry($data){

        // var_dump($data);
        // $this->db->set($data);
        $sp_insert_user = "CALL InsertCountry(?, ?)";
       return $this->db->query($sp_insert_user, $data);

    }

    public function getCountryView() {
		//$sql = "CALL selectallemployee()";
    //     $insert_user_stored_proc = "SelectAllCustomers";
    //   //  $data = array('name' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address);
    //     $result = $this->db->query($insert_user_stored_proc);
    $query = $this->db->get('CountryView');
return $query->result_array();
		// $result = $this->db->query('CALL CountryView');
        // var_dump($result);
	// 	if ($result) {
	// 		return $this->db->get()->result_array();
    }
}