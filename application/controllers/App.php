<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
require APPPATH . '/libraries/REST_Controller.php';
class App extends REST_Controller
{
    public $device = "";
    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        header('Content-Type:  multipart/form-data');
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
    }

    /**
     * Generate OTP for the requested phone number
     */
    public function generateOtp_post()
    {
        $for = $this->input->get('for');
        $mobile = $this->checkEmptyParam($this->post('mobile'), 'Mobile');
        $validateMobile = $this->applib->checkMobile($mobile);
        if ($for === 'login' && empty($this->app_model->checkDealer($mobile))) {
            $this->response('', 404, 'fail', "Account doesn't exist . Please Signup");
        }
        if ($for === 'register' && !empty($this->app_model->checkDealer($mobile))) {
            $this->response('', 404, 'fail', "Mobile Number Exists");
        }
        if (!$validateMobile['status']) {
            $this->response('', 404, 'fail', $validateMobile['message']);
        }
        //$otp = $this->cache->memcached->get($mobile);
        if (!$otp) {
            $otp = mt_rand(1000, 9999);
          //  $this->cache->memcached->save($mobile, $otp, 18000);
        }
        $msg = "Your MYDEALER Platform OTP is " . $otp;
        $sendSms = $this->applib->sendSms($msg, $mobile);
        if ($sendSms['status']) {
            $this->response(
                '',
                200
            );
        } else {
            $this->response('', 404, 'fail', $sendSms['message']);
        }
    }

    /**
     * Verify OTP for the requested phone number function
     *
     */
    public function verifyOtp_post()
    {
        $for = $this->input->get('for');
        $otp = $this->checkEmptyParam($this->post('otp'), 'OTP');
        $mobile = $this->checkEmptyParam($this->post('mobile'), 'Mobile');
        $validateMobile = $this->applib->checkMobile($mobile);
        if (!is_numeric($otp)) {
            $this->response('', 404, 'fail', 'Only Numbers accepted');
        }
        if (!$validateMobile['status']) {
            $this->response('', 404, 'fail', $validateMobile['message']);
        }
        $savedOtp = $this->cache->memcached->get($mobile);
        if ($savedOtp && $savedOtp == $otp) {
            if ($for === 'login') {
                if (empty($this->app_model->checkDealer($mobile))) {
                    $this->response('', 404, 'fail', "Please register");
                }
                $dealerData = $this->app_model->getDealer($mobile);
                $tokenData['dealer_id'] = $dealerData['dealer_id'];
                $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
                $jwtToken = $this->applib->generateToken($tokenData);
                $dealerData['token'] = $jwtToken;
                $this->response(
                    array('details' => $dealerData),
                    200,
                    'pass',
                    'Dealer logged in Successfully'
                );
            } else {
                if (!empty($this->app_model->checkDealer($mobile))) {
                    $this->response('', 404, 'fail', "Mobile Number Exists");
                }
                $this->response(
                    'OTP Verified',
                    200
                );
            }
        } elseif ($savedOtp && $savedOtp != $otp) {
            $this->response('', 404, 'fail', "Invalid OTP");
        } else {
            $this->response('', 404, 'fail', 'OTP Expired');
        }
    }

    /**
     * Register Dealer
     */
    public function registration_post()
    {
        $name = $this->checkEmptyParam(trim($this->post('name')), 'Name');
        $dealership = $this->checkEmptyParam(trim($this->post('dealership')), 'Dealership');
        $designation = $this->checkEmptyParam(trim($this->post('designation')), 'Designation');
        $brand = $this->checkEmptyParam($this->post('brand'), 'Brand');
        $address = $this->checkEmptyParam(trim($this->post('address')), 'Address');
        $number = $this->checkEmptyParam($this->post('number'), 'Number');
        $email = $this->checkEmptyParam($this->post('email'), 'Email');
        $otp = $this->checkEmptyParam($this->post('otp'), 'OTP');
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $this->response('', 404, 'fail', 'Invalid Name');
        }
        $validateMobile = $this->applib->checkMobile($number);
        if (!is_numeric($otp)) {
            $this->response('', 404, 'fail', 'Only Numbers accepted');
        }
        if (!$validateMobile['status']) {
            $this->response('', 404, 'fail', $validateMobile['message']);
        }
        if (!preg_match("/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/", $email)) {
            $this->response('', 404, 'fail', "Email address is invalid.");
        }
        if (!empty($this->app_model->checkDealer($number))) {
            $this->response('', 404, 'fail', "Mobile Number Exists");
        }
        $savedOtp = $this->cache->memcached->get($number);
        if ($savedOtp && $savedOtp == $otp) {
            $data = array('name' => $name, 'dealership' => $dealership, 'designation' => $designation, 'brand' => $brand, 'address' => $address, 'number' => $number, 'email' => $email);
            $dealerData = $this->app_model->addDealer($data);
            $tokenData['dealer_id'] = $dealerData['dealer_id'];
            $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
            $jwtToken = $this->applib->GenerateToken($tokenData);
            $dealerData['token'] = $jwtToken;
            $this->response(
                array('details' => $dealerData),
                200,
                'pass',
                'Dealer registered Successfully'
            );
        } elseif ($savedOtp && $savedOtp != $otp) {
            $this->response('', 404, 'fail', "Invalid OTP");
        } else {
            $this->response('', 404, 'fail', 'OTP Expired');
        }
    }

    /**
     * Get Brands
     */
    public function getBrands_get()
    {
        $data = $this->app_model->getBrands();
        $this->response(array(
            'brands' => $data,
        ), 200);
    }

    /** get list of the Models based on brand id
     *
     * @brand_name
     */
    public function getModels_get()
    {
        $brand = $this->get('brand_id');
        $data['models'] = $this->app_model->getModels($brand);
        $this->response($data);
    }

    public function getManufactureYears_get()
    {
        $data['manufacture_year'] = $this->app_model->getManufactureYears();
        $this->response($data);
    }
    /** get list of the Variants based on brand name and model Name
     *
     * @brand_name
     * @model_name
     */
    public function getVariantList_get()
    {
        $model = $this->get('model_id');
        $brand = $this->get('brand_id');
        $data['variant_list'] = $this->app_model->getVariants($brand, $model);
        $this->response($data);
    }

    /**
     * Get Lead in for Dashboard
     */
    public function getLeadData_get()
    {
        $dealerId = $this->applib->verifyToken();
        $month = $this->get('month');
        $year = $this->get('year');
        $endDate = date('y-m-d', strtotime("-30 days"));

        $data['all'] = $this->app_model->getLead('All', $dealerId, $month, $year, $endDate);
        $data['open'] = $this->app_model->getLead('Open', $dealerId, $month, $year, $endDate);
        $data['junk'] = $this->app_model->getLead('Junk Lead', $dealerId, $month, $year, $endDate);
        $data['out_of_zone'] = $this->app_model->getLead('Out of Zone', $dealerId, $month, $year, $endDate);
        $data['lead_lost'] = $this->app_model->getLead('Lead Lost', $dealerId, $month, $year, $endDate);
        $data['call_back'] = $this->app_model->getLead('Call Back', $dealerId, $month, $year, $endDate);
        $data['booked'] = $this->app_model->getLead('Booked', $dealerId, $month, $year, $endDate);
        $data['cancelled'] = $this->app_model->getLead('Cancelled', $dealerId, $month, $year, $endDate);
        $data['delivered'] = $this->app_model->getLead('Delivered', $dealerId, $month, $year, $endDate);
        //$data['pipe_line'] = $this->app_model->getLeadPipeline('All', $dealerId, $month, $year, $endDate);
        $this->response(
            array('lead_info' => $data),
            200
        );
    }

    public function getDataBasedFilter_get()
    {
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
    }

    public function getOverview_get()
    {
        $dealer_id = $this->applib->verifyToken();
        $data['overview'] = $this->app_model->getOverview($dealer_id);
        $this->response($data);
    }

    public function getOverview_post()
    {
        $dealer_id = $this->applib->verifyToken();
        $dealer_data = array(
            'dealer_name' => $this->checkEmptyParam(trim($this->post('name')), 'Name'),
            'brand' => $this->checkEmptyParam($this->post('brand'), 'Brand'),
            'city' => $this->checkEmptyParam($this->post('city'), 'City'),
            'email_id' => $this->checkEmptyParam($this->post('email'), 'Email'),
        );
        $data['overview'] = $this->app_model->updateOverview($dealer_data, $dealer_id);
        $this->response($data);
    }

    public function getProfile_get()
    {
        $dealer_id = $this->applib->verifyToken();
        $data['profile'] = $this->app_model->getProfile($dealer_id);
        $this->response($data);
    }

    public function updateProfile_post()
    {
        $dealer_id = $this->applib->verifyToken();
        $config['upload_path'] = './uploads/profile';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = '5048';
        $config['max_height'] = '3648';
        $config['max_width'] = '6724';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('profile')) {
            $uploadData = $this->upload->data();
            $picture = $uploadData['file_name'];
            $path = '/uploads/profile/' . $picture; //base_url('/uploads/profile/'). $picture
            $data['update'] = $this->app_model->updateProfile($path, $dealer_id);
        } else {
            $this->response('', 404, 'fail', $this->upload->display_errors());
        }
        //$data['profile'] = $this->app_model->getProfile($dealer_id);
        $this->response($data);
    }

    // testimonial
    public function testimonial_get()
    {

        $data['testimonial'] = $this->app_model->gettestimonialList();
        $this->response($data);
    }

    public function sendOtp2_post() {

        $mobile = $this->checkEmptyParam($this->post('mobile'), 'Mobile');
        $validateMobile = $this->applib->checkMobile($mobile);
        // $this->response('', 404, 'pass', $this->app_model->checkDealer($mobile))
        $checkCustomer = $this->app_model->checkCustomer($mobile);
        // print_r($checkCustomer)
        // echo "hi";
        // echo "a>>>>>$checkCustomer";
        // if($checkCustomer === "0") {

        //     $this->response('', 404, 'fail', "Mobile Number does not Exists Please Signup");

        // }
        // else {

        if (!$otp) {
            $otp = mt_rand(1000, 9999);

        }
        $msg = "Your MYDEALER Platform OTP is " . $otp;
        $sendSms = $this->applib->sendSms($msg, $mobile);

        if ($sendSms['status']) {
            // $this->response(
            //     'success',
            //     200
            // );
            $this->response('', 200, 'pass', $otp);
        } else {
            $this->response('', 404, 'fail', $sendSms['message']);
        }
    // }

    }


    public function sendOtp1_post() {

        $mobile = $this->checkEmptyParam($this->post('mobile'), 'Mobile');
        $validateMobile = $this->applib->checkMobile($mobile);

        $loginFor = $this->post('loginfor');

        if($loginFor === "shopowner") {
            $checkCustomer = $this->app_model->checkShopOwner($mobile);
            // $this->response($loginFor);

        }
        if($loginFor === "customer") {
            $checkCustomer = $this->app_model->checkCustomer($mobile);
            // $this->response($loginFor);

        }

        if($checkCustomer === "0") {

            $this->response('', 404, 'fail', "Not a Registered ! Sign Up");

        }
        else {

        if (!$otp) {
            $otp = mt_rand(1000, 9999);

        }
        $msg = "Your MYDEALER Platform OTP is " . $otp;
        $sendSms = $this->applib->sendSms($msg, $mobile);


        if ($sendSms['status']) {

            $this->response('', 200, 'pass', $otp);
        } else {
            $this->response('', 404, 'fail', $sendSms['message']);
        }
    }






    }






    public function signupCustomer_get() {

        $customer_name =   $_GET['customer_name'];
        $customer_mobileno = $_GET['customer_mobileno'];
        $customer_email = $_GET['customer_email'];
            // $loginfor=$_GET['loginFor'];
            if($_GET['loginFor'] ==='shopownersignup')
            {
                $insertResponse = $this->app_model->signupShopOwnerInsert($customer_name,$customer_mobileno,$customer_email);
            }
        // $customer_name = "test";
        else{
        echo $customer_mobileno;
        echo $customer_name;
        echo $customer_email;
         $insertResponse = $this->app_model->signupCustomerInsert($customer_name,$customer_mobileno,$customer_email);
        }
        $this->response($insertResponse);

    }





    public function SingleCustomerDetails_get() {


        $mobile =   $_GET['customer_mobileno'];
        $loginfor = $_GET['loginfor'];


        if($_GET['loginfor'] === 'customer') {

        $data['SingleCustomerDetails'] = $this->app_model->getSingleCustomerDetails($mobile);
        $this->response($data);
        }
        if($_GET['loginfor'] === 'shopowner') {
        $data['SingleCustomerDetails'] = $this->app_model->getSingleshopDetails($mobile);
        $this->response($data);

        }



    }

    // public function SingleLoginTestimonial_get() {
    //     $customerid = $this->get('customerid');
    //     $data['SingleLoginTestimonialDetails'] = $this->app_model->getSingleLoginTestimonialDetails($customerid);
    //     $this->response($data);
    // }


    public function sendOtp3_post() {

        $mobile = $this->checkEmptyParam($this->post('registermobno'), 'Mobile');
        $validateMobile = $this->applib->checkMobile($mobile);
        $loginFor = $this->post('loginFor');
        // $this->response('', 404, 'pass', $this->app_model->checkDealer($mobile))
      //  $checkCustomer = $this->app_model->checkCustomer($mobile);
      if($loginFor === "shopownersignup") {
        $checkCustomer = $this->app_model->checkShopOwner($mobile);
        // $this->response($loginFor);

    }
    if($loginFor === "customersignup") {
        $checkCustomer = $this->app_model->checkCustomer($mobile);
        // $this->response($loginFor);

    }
        if($checkCustomer != "0") {

            $this->response('', 404, 'fail', "Mobile Number Already Exists! Login");
            // echo json_encode(array("message" => "Mobile Number does not Exists Please Signup"));
        }
        else {

        if (!$otp) {
            $otp = mt_rand(1000, 9999);

        }
        $msg = "Your MYDEALER Platform OTP is " . $otp;
        $sendSms = $this->applib->sendSms($msg, $mobile);

        if ($sendSms['status']) {
            // $this->response(
            //     'success',
            //     200
            // );
            $this->response('', 200, 'pass', $otp);
        } else {
            $this->response('', 404, 'fail', $sendSms['message']);
        }
    }

    }





    public function AddTestimonialInsert_post() {


        $json = file_get_contents('php://input');
// Converts it into a PHP object
        $data = json_decode($json);
        $customer_id = $this->post('customer_id');

        $isCustomerReviewed = $this->app_model->isCustomerReviewed($customer_id);


        if($isCustomerReviewed == "0") {
            $insertTestimonial = $this->app_model->AddTestimonial($data);

         $jsonen = json_encode($insertTestimonial);

        $this->response($jsonen);
        }
        else {
            // $ReviewCountOld = 0;
            $review_count = 0;
            $review_count = $this->app_model->getReviewCount($customer_id);
            $user_description = $this->post('user_description');
        $user_rating = $this->post('user_rating');
        $customer_id = $this->post('customer_id');
        $updateTestimonial = $this->app_model->UpdateTestimonial($user_description,$user_rating,$customer_id,$review_count);
        $this->response($updateTestimonial);

        }
    }
    public function AddCustomerInsert_post() {

        $firstname = $this->post('file');


//         $json = file_get_contents('php://input');
// // Converts it into a PHP object
//         $data = json_decode($json);
//         // $customer_id = $this->post('currentUserId');
//         // echo $customer_id;
//         $customer_id = 26;



$info=$_POST["file_data"];
$info=json_decode($info);
//get the file
$ori_fname=$_FILES['file']['name'];



        //get file extension
$ext = pathinfo($ori_fname, PATHINFO_EXTENSION);


//target folder
$target_path = "docs/";

//replace special chars in the file name
$actual_fname=$_FILES['file']['name'];
$actual_fname=preg_replace('/[^A-Za-z0-9\-]/', '', $actual_fname);

//set random unique name why because file name duplicate will replace
//the existing files
$modified_fname=uniqid(rand(10,200)).'-'.rand(1000,1000000).'-'.$actual_fname;

//set target file path
$target_path = $target_path . basename($modified_fname).".".$ext;
$usertype=$this->post('shopownersession');
$id = $this->post('currentUserId');
if($usertype=='shopowner')
{

    $updateProfileImg = $this->shop_model->updateProfileImg($id,$target_path);

}
else if($usertype=='shopownerlogo')
{
    $updateProfileImg = $this->shop_model->updateShopLogo($id,$target_path);
}
else{

$updateProfileImg = $this->app_model->updateProfileImg($id,$target_path);
}
$result=array();

//move the file to target folder
if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {

$result["status"]=1;
$result["message"]="Uploaded file successfully.";

}else{

$result["status"]=0;
$result["message"]="File upload failed. Please try again.";

}


        // echo $customer_id;

$this->response($id);

        }



public function readCustomerDataById_get() {

    $customer_id = $this->get('customer_id');
    $SingleCustomerdata["profile"] = $this->app_model->getSingleCustomerById($customer_id);
    $this->response($SingleCustomerdata);

    // echo $data;
    // echo json_encode($data);
}

public function AddCustomerdetails_post() {
    $json = file_get_contents('php://input');
// Converts it into a PHP object
        $data = json_decode($json);
        $customer_id = $this->post('customer_id');
    // $currentDate = date('y-m-d');
    //     $note_data = {"lastupddt":"$currentDate"};


        $AddCustomerdetails = $this->app_model->AddCustomerdetails($customer_id,$data);

        $this->response($AddCustomerdetails);
}
public function AddContactUs_post()
{
    $json = file_get_contents('php://input');
// Converts it into a PHP object
        $data = json_decode($json);
        $AddContactUs = $this->app_model->AddContactUs($data);

        $this->response($AddContactUs);
}
public function cartype_get()
{
    $cartype['type'] = $this->app_model->getcartype();
    $this->response($cartype);
}
public function brandtype_get()
{
    $brand['type'] = $this->app_model->getbrandtype();
    $this->response($brand);
}
public function model_get()
{
    $car_type_id =   $_GET['cartype'];
        $brand_id = $_GET['brand'];
    $model['type'] = $this->app_model->getmodel($car_type_id,$brand_id);
    $this->response($model);
}
public function carservices_get()
{
    $carservices['type'] = $this->app_model->getcarservices();
    $this->response($carservices);
}

public function carAndShopservice_get()
{
    $currentUserId = $_GET["currentUserId"];
    $carShopservices['carAndShopservice'] = $this->app_model->getcarAndShopservice($currentUserId);
    $this->response($carShopservices);
}

public function citylist_get()
{
    $citylist['list'] = $this->app_model->getcitylist();
    $this->response($citylist);
}


public function getcitynamebyCityid_get()
{   
    $cityid = $_GET["cityid"];
    $citylist['citylistbyid'] = $this->app_model->getcitynamebyCityid($cityid);
    $this->response($citylist);
}

public function state_get()
{
    $statelist['list'] = $this->app_model->getstatelist();
    $this->response($statelist);
}


public function CustomerCarDetailsInsert_post() {
    $json = file_get_contents('php://input');
// Converts it into a PHP object
        $data = json_decode($json);
        $customer_id = $this->post('customer_id');
    // $currentDate = date('y-m-d');
    //     $note_data = {"lastupddt":"$currentDate"};


        $AddCustomerCardetails = $this->app_model->CustomerCarDetailsInsert($customer_id,$data);

        $this->response($AddCustomerCardetails);
}


public function CarDetailsByCustomerId_get()
{
    $currentUserId = $_GET["customer_id"];
    $carDetails['CarDetailsByCustomerId'] = $this->app_model->getCarDetailsByCustomerId($currentUserId);
    $this->response($carDetails);
}
public function Addwhislist_get()
{
    $whislist=$_GET['shop_id'];
    $Customer_id=$_GET['Customer_id'];
    $date=$_GET['date'];
    $city_id=$_GET['city_id'];
    $queryresponse= $this->app_model->Addwhislisttodb($whislist,$Customer_id,$date,$city_id);
    $this->response($queryresponse);
}
public function Deletewhislist_get()
{
    $whislist=$_GET['shop_id'];
    $Customer_id=$_GET['Customer_id'];
    $city_id=$_GET['city_id'];
    $queryresponse= $this->app_model->Deletewhislisttodb($whislist,$Customer_id,$city_id);
    $this->response($queryresponse);
}
public function customerwhislist_get()
{

    $Customer_id=$_GET['currentUserId'];

    $city_id=$_GET['city_id'];
    $queryresponse= $this->app_model->getCustomerwhislist($Customer_id,$city_id);
    $this->response($queryresponse);
}

public function RemoveMyCarInfo_get()
{
    $carinfo_id = $_GET["carinfo_id"];
    $data = $this->app_model->RemoveMyCarInfoDelete($carinfo_id);
        $this->response($data);
    // $carDetails['RemoveMyCarInfo'] = $this->app_model->RemoveMyCarInfoDelete($customer_id);
    // $this->response($carDetails);
}

public function allmodels_get()
{
    $allmodels['list'] = $this->app_model->getallmodels();
    $this->response($allmodels);
}


public function getCarinfomodels_get()
{

    $vehicle_number=$_GET['vehicle_number'];


    $queryresponse= $this->app_model->SelectCarinfomodels($vehicle_number);
    $this->response($queryresponse);
}

public function getMybookingDetails_get()
    {
        $currentUserId = $_GET["currentUserId"];

        $res= $this->app_model->getMybookingDetails($currentUserId);
        print json_encode($res);

       // $this->response($jsonen);
    }
    public function getcustomerwhislistprofile_get()
    {
        $currentUserId=$_GET["currentUserId"];

        $res['getcustomerwhislist'] = $this->app_model->getcustomerwhislistprofile($currentUserId);
        $this->response($res);
    }

    public function carDetByModelId_get()
{
    $currentUserId = $_GET["currentUserId"];
    $model = $_GET["model"];
    $carDetails['carDetByModelId'] = $this->app_model->getcarDetByModelId($currentUserId,$model);
    $this->response($carDetails);
}

public function getServiceDataOnlineBookingModel_get()
{
    $shopid = $_GET["shopid"];
    $model_id = $_GET["model_id"];
    $carShopservices['getServiceDataOnlineBookingModel'] = $this->app_model->getServiceDataOnlineBookingModel($shopid,$model_id);
    $this->response($carShopservices);
}

public function getcustomerByCityId_get()
{
    $cityid = $_GET["cityid"]; 
    
    $Details['getcustomerByCityId'] = $this->app_model->getcustomerByCityId($cityid);
    $this->response($Details);
}

public function CarDetailsByIdShopOnlineBooking_get()
{
    $currentUserId = $_GET["customer_id"];
    $carDetails['CarDetailsByIdShopOnlineBooking'] = $this->app_model->getCarDetailsByIdShopOnlineBooking($currentUserId);
    $this->response($carDetails);
}
    }
