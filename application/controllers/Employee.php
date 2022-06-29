<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
require APPPATH . '/libraries/REST_Controller.php';
// require APPPATH . '/libraries/JWT.php';
class Employee extends REST_Controller
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
        $this->load->model("login_model");
        $this->load->model("employee_model");
    }

    public function employeedashboard_get()
    {
        // $datas = $this->obj->input->request_headers()['Authorization'];
        // var_dump("Datas>>>");
        $dealerId = $this->applib->verifyTokenNew();
        // var_dump($dealerId["UserId"]);
        // var_dump($dealerId["UserTypeId"]);
        // $dealerId = $this->applib->verifyToken();
        // $json = file_get_contents('php://input');

                       echo $dealerId;
                       $userdetails = $this->employee_model->get_employee_details();
                        $this->response($userdetails);


    }

    public function selectEmployeeType_get()
{
    $data['EmployeeDetails']=$this->employee_model->getAllEmpType();
    $this->response($data);
}

public function selectJobTitle_get()
{
    $data['JobTitle']=$this->employee_model->getJobTitle();
    $this->response($data);
}

public function AddUserEmployee($UserId,
    $LoginDate,
    $Password,
    $Successful,
    $IPAddress,
    $LoginDetail,
    $SessionId){
        $sp = "sAddUserLogin ?,?,?,?,?,?,?"; //No exec or call needed

            //No @ needed.  Codeigniter gets it right either way
            $params = array(
            'UserId' => $UserId,
            'LoginDate' => $LoginDate,
            'PasswordEntered' => $Password,
            'Successful' => $Successful,
            'IPAddress' => $IPAddress,
            'LoginDetail' => $LoginDetail,
            'SessionId' => $SessionId

            );

            $result = $this->db->query($sp,$params);


    }

}

