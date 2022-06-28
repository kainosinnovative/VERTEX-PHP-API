<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
require APPPATH . '/libraries/REST_Controller.php';
// require APPPATH . '/libraries/JWT.php';
class Vendor extends REST_Controller
{
    public $device = "";
    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        header('Content-Type:  multipart/form-data');
        header('Authorization: token');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
        // header('Content-Type: application/json');
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
        header("HTTP/1.1 200 OK");
        die();
        }

        $this->load->library("applib", array("controller" => $this));
        $this->load->model("app_model");
        $this->load->model("shop_model");
        $this->load->model("dealer_model");
        $this->load->model("vendor_model");
        $this->load->model("login_model");
        $this->load->model("employee_model");
    }
    public function InsertNewVendor_post()
    {
        $vendorinsertsuccess = $this->vendor_model->InsertNewVendor();
        $this->response($vendorinsertsuccess);
    }

    public function InsertVendorContact_get()
{
    $ContactBusiness=$_GET['ContactBusiness'];
    $ContactBusinessArr = json_decode($ContactBusiness,true);
    // $ContactBusinessArr = (array) $ContactBusiness;
    // $ContactBusinessArr2 = (array) $ContactBusinessArr;
    var_dump($ContactBusinessArr);
    // $vendorid = "test";
    if($ContactBusinessArr["VendorContactPrimary"] == true) {
        $ContactBusinessArr["VendorContactPrimary"] = 1;
    }
    else {
        $ContactBusinessArr["VendorContactPrimary"] = 0;
    }

    if($ContactBusinessArr["VendorContactPrimary"] == true) {
        $ContactBusinessArr["VendorContactActive"] = 1;
    }
    else {
        $ContactBusinessArr["VendorContactActive"] = 0;
    }
    $result = $this->vendor_model->insert_vendorContact("10",
    $ContactBusinessArr["contact_name"],
    $ContactBusinessArr["business_phone"],
    $ContactBusinessArr["title"],
    $ContactBusinessArr["business_email"],
    $ContactBusinessArr["VendorContactPrimary"],
    $ContactBusinessArr["VendorContactActive"],
//     $ContactBusinessArr["contact_name"],
//     $ContactBusinessArr["contact_name"]
);
                $data['success'] = $result;
    // var_dump($ContactBusinessArr[0]);

    // $vendorMgmt=$_GET['vendorMgmt'];


    // $queryresponse= $this->app_model->Addwhislisttodb($whislist,$Customer_id,$date,$city_id);
    //$this->response($ContactBusiness);
}

public function GetVendorType_post()
{
   // $dealer_id = $this->applib->verifyToken();
    $data['vendortype'] = $this->vendor_model->getVendorType();
    $this->response($data);

}


public function AdduserDetails_post()
{
    $data1=$this->employee_model->getNewID();
    $data=$data1["new_id"];
    $newid=$data;
    //  $this->response($data);

    echo  $_POST["UserTypeId"];
    if($_POST["UserTypeId"]=="EMPLOY")
    {
        $UserId = $this->input->post('UserId');
    $UserTypeId = $this->input->post('UserTypeId');
    $UserStatusId = $this->input->post('UserStatusId');
    $UserPassword = $this->input->post('UserPassword');
    $EmployeeId = NULL;
    $VendorId = NULL;
    $CreatedDate = date('Y-m-d');
    $CreatedUserId = $this->input->post('UserId');
    $UpdatedDate = date('Y-m-d');
    $UpdatedUserid = $this->input->post('UserId');
    $AdminUser = $this->input->post('AdminUser');

// employee tbl insert
$FirstName = $this->input->post('FirstName');
$LastName = $this->input->post('LastName');
$Phone = $this->input->post('Phone');
$EmploymentTypeId = $this->input->post('EmploymentTypeId');
    $JobTitleId = $this->input->post('JobTitleId');
    $StartDate = $this->input->post('StartDate');
    $CreatedDate = date('Y-m-d');
$CreatedUserId = $this->input->post('CreatedUserId');
$UpdatedDate = date('Y-m-d');
$UpdatedUserId = $this->input->post('UpdatedUserId');



    // insert into employee address
    $AddressTypeId = 'C';
    $AStartDate = $this->input->post('AStartDate');
    $enddate = $this->input->post('enddate');
    $Address1 = $this->input->post('Address1');
    $Address2 = $this->input->post('Address2');
    
    $DistrictId = $this->input->post('DistrictId');
    $CityId = $this->input->post('CityId');
    $StateId = $this->input->post('StateId');
    $Zipcode = $this->input->post('Zipcode');
    // $CountryId = $this->input->post('CountryId');

    $data = array('UserId' => $UserId, 'UserTypeId' => $UserTypeId, 'UserStatusId' => $UserStatusId,
    'UserPassword' => $UserPassword, 'EmployeeId' => $EmployeeId, 'VendorId' => $VendorId,'CreatedDate' => $CreatedDate,
    'CreatedUserId' => $CreatedUserId, 'UpdatedDate' => $UpdatedDate,
    'UpdatedUserid' => $UpdatedUserid, 'AdminUser' => $AdminUser);
    
    // @FirstName varchar(50),@LastName varchar(50),@Phone varchar(20),
	// @EmploymentTypeId char(1),@JobTitleId varchar(12),@StartDate datetime,@CreatedDate datetime,@CreatedUserId varchar(20),
	// @UpdatedDate datetime,@UpdatedUserId varchar(20),

	// @AddressTypeId char(1),@AStartDate datetime,@Address1 varchar(200),@StateId varchar(6),@Zipcode varchar(12)

    $data1=array('FirstName'=>$FirstName,'LastName'=>$LastName,'Phone'=>$Phone,'EmploymentTypeId'=>$EmploymentTypeId,'JobTitleId'=>$JobTitleId,
    'StartDate'=>$StartDate,'CreatedDate'=>$CreatedDate,'CreatedUserId'=>$CreatedUserId,'UpdatedDate'=>$UpdatedDate,'UpdatedUserId'=>$UpdatedUserId,
                 'AddressTypeId'=>$AddressTypeId,'AStartDate'=>$AStartDate,'Address1'=>$Address1,'StateId'=>$StateId,'Zipcode'=>$Zipcode
                );
    
                 $result = $this->employee_model->AdduserDetailsEmployee($data,$data1);
                        
                }
    else if($_POST["UserTypeId"]=="VENDOR") {
        $userid = $this->input->post('userid');
    $usertypeid = $this->input->post('usertypeid');
    $userstatus = $this->input->post('userstatus');
    $password = $this->input->post('password');
    $emloyeeid = '';
    $VendorId = $newid;
    $createdDate = date('Y-m-d');
    $Createduserid = $this->input->post('userid');
    $UpdatedDate = date('Y-m-d');
    $UpdatedUserid = $this->input->post('userid');
    }
    

    // // insert into vendor  
    // $vendorid = $jsonUID;
    // $vendortype = $this->input->post('vendortype');
    
    // $ssnnumber = $this->input->post('ssnnumber');
    // $OutreachEmailOptIn = $this->input->post('OutreachEmailOptIn');

    // // insert into vendor address
    // $vendorid = $jsonUID;
    // $addresstypeid = $this->input->post('addresstypeid');
    // $startdate = $this->input->post('startdate');
    // $enddate = $this->input->post('enddate');
    // $Address1 = $this->input->post('Address1');
    // $Address2 = $this->input->post('Address2');
    // $addresstypeid = $this->input->post('StateId');
    // $DistrictId = $this->input->post('DistrictId');
    // $CityId = $this->input->post('CityId');
    // $Zipcode = $this->input->post('Zipcode');
    // $CountryId = $this->input->post('CountryId');

}

}

