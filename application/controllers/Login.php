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
        // $json = file_get_contents('php://input');
        //         // Converts it into a PHP object
                        // $request = json_decode($json);
                        // $loginForm = $request->loginForm;
                        // var_dump($loginForm);
                        // $UserId = $loginForm->UserId;
        $UserId = $this->post('UserId');
        $password = $this->post('Password');
        // echo $UserId;
        // $this->response($UserId);

            $cardential = ['EmployeeId' => $this->input->post('UserId'),
                        //    'password' => $this->input->post('password')
                          ];

                     $rowcountuser = $this->login_model->checkuser($UserId);
                    //  $this->response($rowcountuser);
                    if($rowcountuser != 0)
                    {
                    // //    echo "yes";
                       $userdetails = $this->login_model->get_user_credential($UserId);
                       $retpassword = $userdetails['UserPassword'];
                       $UserTypeId = $userdetails['UserTypeId'];
                       $UserStatusId = $userdetails['UserStatusId'];
                    //    $this->response($retpassword);
                        if($retpassword == $password &&  $UserStatusId == "A")
                        {
                            $tokenData['usertype'] = $UserTypeId;
                            $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
                            $jwtToken = $this->applib->generateToken($tokenData);

                            $dealerData['token'] = $jwtToken;
                            // $this->response(
                            //     array('details' => $dealerData),
                            //     200,

                            // );

                            $this->response('', 200, 'success', $dealerData);


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

