<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
require APPPATH . '/libraries/REST_Controller.php';
class Shop extends REST_Controller
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
        $this->load->model("shop_model");
    }

    public function getShopProfileById_get()
        {

            $shop_id = $_GET['shop_id'];
            $ShopDetailsById["profile"] = $this->shop_model->getSingleShopById($shop_id);
            $this->response($ShopDetailsById);
        }


    public function AddshopService_get() {

        $service_amount =   $_GET['service_amount'];
        $serviceid = $_GET['serviceid'];
        $shopid = $_GET['currentUserId'];

         $insertResponse = $this->shop_model->AddshopServiceInsert($service_amount,$serviceid,$shopid);
        $this->response($insertResponse);

    }


    public function UpdateshopService_get() {

        $service_amount =   $_GET['service_amount'];
        $serviceid = $_GET['serviceid'];
        $shopid = $_GET['currentUserId'];
        $modelid=$_GET['modelId'];

         $insertResponse = $this->shop_model->shopServiceUpdate($service_amount,$serviceid,$shopid,$modelid);
        $this->response($insertResponse);


    }
    public function AddShopdetails_post() {
        $json = file_get_contents('php://input');
    // Converts it into a PHP object
            $data = json_decode($json);
            $shop_id = $this->post('shop_id');
        // $currentDate = date('y-m-d');
        //     $note_data = {"lastupddt":"$currentDate"};


            $AddShopdetails = $this->shop_model->AddShopdetails($shop_id,$data);

            $this->response($AddShopdetails);
    }


    public function AddComboOfferDetails_get() {

        $services =   $_GET['services'];
        $combo_price = $_GET['combo_price'];
        $shop_id = $_GET['shop_id'];
        $offer_percent =   $_GET['offer_percent'];
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $model_id = $_GET['model_id'];
        $original_amount = $_GET['original_amount'];
        $offer_name = $_GET['offer_name'];

         $insertResponse = $this->shop_model->AddComboOfferDetailsInsert($services,$combo_price,$shop_id,$offer_percent,$start_date,$end_date,$model_id,$original_amount, $offer_name);
        $this->response($insertResponse);

    }

    public function getComboOffersByShopid_get()
    {
        $month = $_GET["month"];
        $monthArr = explode(',', $month);
         // sort($yearArr);

        $year=$_GET["year"];
        $yearArr = explode(',', $year);
        rsort($yearArr);
        $yearArr=array_unique($yearArr);
        $monthArr=array_unique($monthArr);
        $id=$_GET["id"];
        // foreach ($yearArr as $key => $value) {
        //     foreach ($monthArr as $key1 => $value1) {
      // $carShopservices = $this->shop_model->getComboOffersByShopid($monthArr,$yearArr,$id);
     $carShopservices = $this->shop_model->getComboOffersByShopid($monthArr,$yearArr,$id);
        //     }
        // }
       // $this->response($carShopservices);
       echo json_encode($carShopservices);
    }

    public function shopserviceByModelid_get()
{
    $currentUserId = $_GET["currentUserId"];
    $carShopservices['shopserviceByModelid'] = $this->shop_model->getshopserviceByModelid($currentUserId);
    $this->response($carShopservices);
}


public function combooffertblByModelid_get()
{
    $currentUserId = $_GET["currentUserId"];
    $model_id = $_GET["model_id"];
    $carShopservices['combooffertblByModelid'] = $this->shop_model->getcombooffertblByModelid($currentUserId,$model_id);
    $this->response($carShopservices);
}

public function dashboardShopList_get()
{
    $currentUserId = $_GET["cityid"];
    $carShopservices['dashboardShopList'] = $this->shop_model->getdashboardShopList($currentUserId);
    $this->response($carShopservices);
}
public function dashboardShopSearch_get()
{
    $shopname=$_GET["shopname"];
    $city_id=$_GET["cityid"];
    if(ctype_alpha($shopname[0]))
    {
        // $carShopservices['dashboardShopSearch'] = '';
       $this->response("hi");
    }
    else
    {
    $shopsearch['dashboardShopSearch'] = $this->shop_model->getdashboardShopSearch($shopname);
    $this->response($shopsearch);
    }

}
public function dashboardShopSearchOffer_get()
{
    $cityid = $_GET["cityid"];
    $shop_id=$_GET["shopname"];
    if(ctype_alpha($shop_id[0]))
    {
    //     $shopsearch['dashboardShopSearch'] = $this->shop_model->getdashboardServiceSearch($shopname,$city_id);
    //    $this->response($shopsearch);
    $carShopservices['dashboardShopDetailsByOffer'] = $this->shop_model->getdashboardServiceSearch($shop_id,$cityid);
    $this->response($carShopservices);


    }
    else{
    $carShopservices['dashboardShopDetailsByOffer'] = $this->shop_model->getdashboardShopSearchOffer($cityid,$shop_id);
    $this->response($carShopservices);
    }
}

public function OnlineBookingShopDetails_get()
{
    $shopid = $_GET["shopid"];
    $model = $_GET["model"];
    $carShopservices['OnlineBookingShopDetails'] = $this->shop_model->getOnlineBookingShopDetails($shopid,$model);
    $this->response($carShopservices);
}

public function Updateshopoffer_get()
    {

        $service_id = $_GET['serviceid'];
        $shop_id = $_GET['currentUserId'];
        $offer_percent =   $_GET['offerpercent'];
        $start_date = $_GET['fromdate'];
        $end_date = $_GET['todate'];
        $model_id = $_GET['modelId'];
        $lastupddt= $_GET['lastupddt'];
        $offer_price= $_GET['offer_amount'];

         $insertResponse = $this->shop_model->AddShopOfferDetails($service_id,$model_id,$lastupddt,$offer_price,$shop_id,$offer_percent,$start_date,$end_date);
        $this->response($insertResponse);
    }


    public function dashboardShopDetailsByOffer_get()
{
    $currentUserId = $_GET["cityid"];
    $carShopservices['dashboardShopDetailsByOffer'] = $this->shop_model->getdashboardShopDetailsByOffer($currentUserId);
    $this->response($carShopservices);
}

public function addonlinebooking_post()
       {

            $json = file_get_contents('php://input');
        // Converts it into a PHP object
                $data = json_decode($json,true);

                $res1 = $this->shop_model->bookingstatusInsert($data["Booking_id"]);

                $res = $this->shop_model->Addonlinebooking($data);

                $this->response($res);

    }


    public function AddShopserviceDetails_post()
       {


            $json = file_get_contents('php://input');
        // Converts it into a PHP object
                $request = json_decode($json);
                $shopserviceForm = $request->shopserviceForm;
                // $hidden_service = $request->hidden_service;
                // var_dump($hidden_service);
                // if($hidden_service == "") {
                    $res = $this->shop_model->AddShopserviceDetailsInsert($shopserviceForm);
                // }
                // else {
                    // $maxServiceid = $this->shop_model->getMaxServiceId();
                    // var_dump($maxServiceid);
                    // $res = $this->shop_model->MasterServiceShopserviceInsert($shopserviceForm,$hidden_service,$maxServiceid);
                // }


                $this->response($res);



    }

    public function AddMasterservice_post()
       {

            $json = file_get_contents('php://input');
        // Converts it into a PHP object
                $request = json_decode($json);
                $MasterserviceForm = $request->MasterserviceForm;
                // var_dump($MasterserviceForm);
                $service_name = $MasterserviceForm->service_name;
              // var_dump($service_name);
              $shop_id=$MasterserviceForm->shop_id;
              $maxServiceid = $this->shop_model->getMaxServiceId();
              $maxServiceid1 = $maxServiceid + 1;
              $autoincrementFrom = $this->shop_model->autoincrementFrom($maxServiceid1);
                 $res = $this->shop_model->MasterServiceInsert($service_name,$shop_id);

                  //  $model_id = $MasterserviceForm->model_id;
                    // $actual_amount = $MasterserviceForm->actual_amount;
                    // $maxServiceid = $this->shop_model->getMaxServiceId();
                    // $shop_id = $MasterserviceForm->shop_id;
                    //var_dump($actual_amount);
                    // $res = $this->shop_model->MasterServiceShopserviceInsert($model_id,$maxServiceid,$actual_amount,$shop_id);


                $this->response($res);
              // $this->response($service_name);

    }

    public function MasterServiceAndShopService_get()
{
    $currentUserId = $_GET["currentUserId"];
    $Details['MasterServiceAndShopService'] = $this->shop_model->getMasterServiceAndShopService($currentUserId);
    $this->response($Details);
}
public function servicebasedonmodel_get()
{
    $currentUserId = $_GET["currentUserId"];
    $service_id = $_GET["service_id"];
    $Details['type'] = $this->shop_model->getservicebasedonmodel($currentUserId,$service_id);
    $this->response($Details);
}

public function changeShopServiceStatus_get() {

    $status =   $_GET['status'];
    $shopserviceid = $_GET['shopserviceid'];


     $insertResponse = $this->shop_model->changeShopServiceStatusUpdate($status,$shopserviceid);
    $this->response($insertResponse);

}
public function DisplayComboOfferDetails_get()
{
    $month=$_GET['month'];
    $year=$_GET['year'];
}
public function getallshoplist_get()
{
    $city_id=$_GET['city_id'];
    $shoplist=$this->shop_model->getshoplist($city_id);
   // print_r($shoplist);
   echo json_encode($shoplist);
  // $this->response($shoplist);
}

public function customerBookingForShop_get()
{
    $currentUserId = $_GET["currentUserId"];
    $Details = $this->shop_model->getcustomerBookingForShop($currentUserId);
    print json_encode($Details);
}

public function AcceptedBookingList_get()
{
    $currentUserId = $_GET["currentUserId"];
    $Details = $this->shop_model->getAcceptedBookingList($currentUserId);
    print json_encode($Details);
}

public function master_pickdrop_status_get()
{
    $details['master_pickdrop_status'] = $this->shop_model->getmaster_pickdrop_status();
    echo json_encode($details);
}

public function master_carwash_status_get()
{
    $details['master_carwash_status'] = $this->shop_model->getmaster_carwash_status();
    echo json_encode($details);
}

public function changeBookingStatus_get() {

    $booking_status =   $_GET['booking_status'];
    $Booking_id = $_GET['Booking_id'];
    $pickup_drop = $_GET['pickup_drop'];
    if($booking_status == "Accepted") {
        if($pickup_drop == 0) {
            $pickup_message = "Please drop your car";
        }
        else {
            $pickup_message = "Our employee will pickup your car at your door step";
        }

        $insertResponse = $this->shop_model->changeBookingStatusUpdate($booking_status,$Booking_id,$pickup_message);
        $this->response($insertResponse);
    }
    else {
        $pickup_message = "";
        $insertResponse = $this->shop_model->changeBookingStatusUpdate($booking_status,$Booking_id,$pickup_message);
        $this->response($insertResponse);

    }



}




public function changeCarwashStatus_get() {

    $carwash_status =   $_GET['carwash_status'];
    $Booking_id = $_GET['Booking_id'];


        $insertResponse = $this->shop_model->changeCarwashStatusUpdate($carwash_status,$Booking_id);
        $this->response($insertResponse);

}

public function getcurrentComboOffersByShopid_get()
    {
        $currentUserId = $_GET["currentUserId"];

        $carShopservices = $this->shop_model->getcurrentComboOffersByShopid($currentUserId);
        // $this->response($carShopservices);
        echo json_encode($carShopservices);
    }
public function getcurrentComboOffersByShopiddashboard_get()
{
    $currentUserId = $_GET["currentUserId"];

    $carShopservices = $this->shop_model->getcurrentComboOffersByShopiddashboard($currentUserId);
    // $this->response($carShopservices);
    echo json_encode($carShopservices);
}


    public function getServiceDataOffersByCurdate_get()
    {
        $currentUserId = $_GET["currentUserId"];

        // $carShopservices['getcurrentOffersByShopid'] = $this->shop_model->getServiceDataOffersByCurdate($currentUserId);
        // $this->response($carShopservices);
        $carShopservices = $this->shop_model->getServiceDataOffersByCurdate($currentUserId);
        echo json_encode($carShopservices);
    }


    public function getBookingDetailsById_get()
    {
        $Booking_id = $_GET["Booking_id"];

        $details = $this->shop_model->getBookingDetailsById($Booking_id);
        // $this->response($carShopservices);
        echo json_encode($details);
    }


    public function getloadmasterComboOffer_get()
{
    $details = $this->shop_model->getloadmasterComboOffer();
    echo json_encode($details);

}


public function insertShopHolidays_get() {

    $leave_date =   $_GET['leave_date'];
    $currentUserId = $_GET['currentUserId'];

    $leave_dateArr = explode(',', $leave_date);

    // $FinalArray = array();
    foreach ($leave_dateArr as $key => $value) {
        // echo "$value <br>";
        $checkHolidays = $this->shop_model->checkHolidays($currentUserId,$value);
// echo $checkHolidays;
if($checkHolidays == 0){
$insertResponse = $this->shop_model->insertShopHolidays($currentUserId,$value);

}
// else{
// $this->response('', 404, 'fail', "Already added");
// }


      }
      $this->response($insertResponse);
}

public function getShopHolidays_get()
        {

            $shop_id = $_GET['shop_id'];
            $details  = $this->shop_model->getShopHolidays($shop_id);
            echo json_encode($details);
        }

        public function DeleteHolidays_get() {

            $holidayid =   $_GET['holidayid'];



                $insertResponse = $this->shop_model->DeleteHolidays($holidayid);
                $this->response($insertResponse);

        }

        public function getholidaysForAll_get()
        {


            $details  = $this->shop_model->getholidaysForAll();
            echo json_encode($details);
        }
        public function RemoveMyComboOffer_get()
{
    $offerid = $_GET["offerid"];
    $data['message'] = $this->shop_model->RemoveMyComboOffer($offerid);
        $this->response($data);
    // $carDetails['RemoveMyCarInfo'] = $this->app_model->RemoveMyCarInfoDelete($customer_id);
    // $this->response($carDetails);
}
public function updatepickupdrop_get()
{
    $shop_id=$_GET['shop_id'];
    $pickupdropstatus=$_GET['pickupdropstatus'];
    $insertResponse = $this->shop_model->updatepickupdrop($shop_id,$pickupdropstatus);
    $this->response($insertResponse);

}


public function holidaytimeupdate_post()
       {

            $json = file_get_contents('php://input');
        // Converts it into a PHP object
                $data = json_decode($json);


                $res = $this->shop_model->holidaytimeupdate($data);

                $this->response($res);

     }
    public function chartcustomercombo_get()
    {
        $shop_id=$_GET['currentUserId'];
        $data = $this->shop_model->chartcustomercombo($shop_id);
        echo json_encode($data);
    }
    }
