<?php

/**
 * All common DB-connection functions will be written here
 *
 *
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Vendor_model extends CI_Model
{





          public function generateToken($data)
    {
        $jwt = JWT::encode($data, $this->key);
        return $jwt;
    }

    function insert_vendorContact($VendorId, $ContactName,$Phone, $JobTitle, $Email, $VendorContactPrimary,$VendorContactActive
     ) {
        $sp = "InsertVendorContact ?, ?, ?, ?, ?, ?, ?";

        $data = array(
            'VendorId' => $VendorId,
            'ContactName' => $ContactName,
            'Phone' => $Phone,
            'JobTitle' => $JobTitle,
            'Phone' => $Phone,
            'Email' => $Email,
            'VendorContactPrimary' => $VendorContactPrimary,
            'VendorContactActive' => $VendorContactActive,



            );

            $result = $this->db->query($sp,$data);


	}

    // function getVendorType()
    // {
    //     var_dump("hi");
    //     $query = $this->db->get('vVendorType');
    //     return $query->result_array();
    // }

    public function GetVendorList()
{
    $query = $this->db->query("sGetAllVendors");
    return $query->result_array();

}

public function GetVendorById($VendorId)
{
    $query = $this->db->query("sGetVendorById @VendorId='$VendorId'");
    return $query->result_array();

} 

public function GetVendorAddressById($VendorId)
{
    $query = $this->db->query("sGetVendorAddressById @VendorId='$VendorId'");
    return $query->result_array();

}

public function updatevendorDetails($vendordata){
    // $this->db->trans_begin();
    
    
   
        //$sp = "sUpdateVendor ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?"; 
        $sp = "sUpdateVendor ?,?,?,?"; 
        $params =$vendordata;
            
            // print_r($params);

            $result = $this->db->query($sp,$params);
            // var_dump($this->db->trans_status());
            // if ($result) {

        
            // }


            //     if ($this->db->trans_status() === FALSE)
            // {
            //     $this->db->trans_rollback();
            // }
            // else
            // {
            //     $this->db->trans_commit();
            //     return TRUE;

            // }

    }

}