<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

class Test extends REST_Controller
{
    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->country_code = 'IN';
        $this->load->model("app_model");
        $this->load->library("applib", array("controller" => $this));

    }

    /**
     * get otp manually function
     *
     * @return int $otp
     */
    public function otp_post()
    {
        $mobile = $this->post('mobile');
        if ($this->cache->memcached->get($mobile)) {
            $otp = $this->cache->memcached->get($mobile);
            $this->response($otp, 200, 'pass', 'OTP for ' . $mobile);
        } else {
            $this->response('', 404, 'fail', 'Invalid Number');
        }
    }

    public function deleteDealer_get()
    {
        $mobile = $this->get('mobile');
        if(!empty($mobile)){
            $dealer = $this->app_model->checkDealer($mobile);
            if(!empty($dealer)){
                $this->db->delete('dealer', array('contact_no' => $mobile));
                $this->db->delete('dealer_login', array('dealer_id' => $dealer->dealer_id));
        
                $this->response('', 200, 'pass', 'Deleted');
            }
            $this->response('', 404, 'fail', 'No dealer Found');
        }

        $this->response('', 404, 'fail', 'Provide a phone number');


    }
}
