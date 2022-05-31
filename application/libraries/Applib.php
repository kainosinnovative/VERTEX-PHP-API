<?php

/**
 * This library will decide about the APP logics
 *
 *
 */
//error_reporting(-1);
//ini_set('display_errors', 'On');
require APPPATH . '/libraries/JWT.php';
class Applib
{

    public $obj;
    protected $country_id = "";
    /**
     * To set constructor of parent controller
     *
     * @param Object - $parent_controller -> Object of parent controller
     */
    public function __construct($parent_controller)
    {
        $this->obj = $parent_controller['controller'];
    }

    /**
     * To generate an access token
     * @param Array $data - params for generating token
     * @return String $jwt - access token
     */
    private $key = "MNCDEALERLOGIN";
    public function generateToken($data)
    {
        $jwt = JWT::encode($data, $this->key);
        return $jwt;
    }

    /**
     * To verify auth token and return dealerId
     *
     * @return Int - Dealer ID
     */
    public function verifyToken()
    {
        $datas = $this->obj->input->request_headers();
        $token = isset($datas['token']) ? $datas['token'] : '';
       
        if (empty($token)) {
            $this->obj->response('You must login to use this service', 401);
        }
        $tks = explode('.', $token);
        if (count($tks) != 3) {
            $this->obj->response('You must login to use this service', 401);
        }
        $decoded = JWT::decode($token, $this->key, array('HS256'));
        $decodedData = (array) $decoded;
        if (empty($decodedData['dealer_id'])) {
            $this->obj->response('You must login to use this service', 401);
        }
        return $decodedData['dealer_id'];
    }

    /**
     * Send Text Message
     *
     * @param array  $message
     * @param string $mobile
     * @return void
     */
    public function sendSms($message, $mobile)
    {
        if (!empty($message) || !empty($mobiles)) {
            $message = urlencode($message);
            $postData = array(
                'authkey' => IN_SMS_AUTH_KEY,
                'mobiles' => '91' . $mobile,
                'message' => $message,
                'sender' => IN_SMS_SOURCE,
                'country' => 0,
                'route' => 4,
            );
            $response = curlRequest(IN_SMS_URL, $postData);
            return $response != IN_SMS_SUCC_TEXT ? array(
                'status' => true,
                'message' => $response,
            ) : array(
                'status' => false,
                'message' => $response,
            );
            $data = array(
                'mobiles' => $mobile,
                'message' => $message,
                'sms_provider_status' => $response,
                'created_by' => $this->ownerId,
            );
            $this->obj->db->insert('new_send_sms', $data);
        } else {
            return array(
                'status' => false,
                'message' => 'Message/Mobile is empty',
            );
        }
    }

    public function sendSms1($message, $mobile)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://2factor.in/API/V1/{api_key}/SMS/{7339528035}/{123456}",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
    }

    /**
     * To check valid mobile number
     *
     * @param Int $mobile - Mobile Number
     * @return void
     */
    public function checkMobile($mobile)
    {
        $data = array('status' => false, 'message' => "Invalid Mobile Number");
        if (is_numeric($mobile) && strlen((string) $mobile) == 10) {
            $data = array('status' => true, 'message' => '');
        }
        return $data;
    }
}
