<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
require APPPATH . '/libraries/REST_Controller.php';
class OnlineBooking extends REST_Controller
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
        $this->load->model("onlinebooking_model");
      
}

public function addonlinebooking_post()
       {
        
            $json = file_get_contents('php://input');
        // Converts it into a PHP object
                $data = json_decode($json);
                $res = $this->onlinebooking_model->Addonlinebooking($data);
                
                $this->response($res);
       
   

    }
}