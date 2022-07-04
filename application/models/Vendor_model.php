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
}