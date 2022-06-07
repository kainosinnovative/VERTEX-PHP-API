<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
require APPPATH . '/libraries/REST_Controller.php';
// require APPPATH . '/libraries/JWT.php';
class Login extends REST_Controller
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
    }

    public function loginauth_post()
    {

        $UserId = $this->post('UserId');
        $password = $this->post('Password');


            $cardential = ['EmployeeId' => $this->input->post('UserId'),
                        //    'password' => $this->input->post('password')
                          ];

                     $rowcountuser = $this->login_model->checkuser($UserId);
                    if($rowcountuser != 0)
                    {
                    //    echo "yes";
                       $userdetails = $this->login_model->get_user_credential($UserId);
                       $retpassword = $userdetails['UserPassword'];
                       $UserTypeId = $userdetails['UserTypeId'];
                       $UserStatusId = $userdetails['UserStatusId'];
                        if($retpassword == $password &&  $UserStatusId == "A")
                        {
                            $tokenData['rolename'] = $UserTypeId;
                            $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
                            $jwtToken = $this->applib->generateToken($tokenData);

                            $dealerData['token'] = $jwtToken;
                            $this->response(
                                array('details' => $dealerData),
                                200,

                            );


                        }
                        else
                        {
                            $this->response('', 111, 'fail', "Incorrect Credentials");
                        }
                    }
                    else
                    {
                            $this->response('', 111, 'fail', "Incorrect Credentials");
                    }




    }


}

