<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function get_client_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function curlRequest($url, $post = "", $header = "", $put = "", $source = "")
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //To ignore SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //To ignore SSL verification
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    if ($put && ($source == 'zoho')) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $put);
    } elseif ($put) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($put));
    }
    if ($header) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $result = curl_exec($ch);

    return $result;
}

/**
 * To get the date-time in required format
 *
 * @param String - $format - Format in which the date needs to be outputed
 * @return String - Date-time in Y-m-d H:i:s  
 */
function getDateTime($format = 'Y-m-d H:i:s')
{
    return date($format);
}

function getDevice()
{
    if ($this->agent->is_browser()) {
        $agent = $this->agent->browser() . ' ' . $this->agent->version();
    } elseif ($this->agent->is_robot()) {
        $agent = $this->agent->robot();
    } elseif ($this->agent->is_mobile()) {
        $agent = $this->agent->mobile();
    } else {
        $agent = 'Unidentified User Agent';
    }

    echo $agent;

    echo $this->agent->platform();
}

  /**
   * To get the city from lat and long of address(If city filed is blank from lat and long get city name)
   *
   * @param Int - $lat -> latitude of the address
   * @param Int - $lng -> longitude of the address
   * @return - city name
   */
  function getCityLatLang($lat, $lng) {
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&sensor=false&key=AIzaSyD4oiUvZOrPv7Hl6RsC1rKF6HLrc2LsbeQ';
    $json = @file_get_contents($url);
    
    $data = json_decode($json);
    
    $status = $data->status;
    if($status=="OK") {
        //Get address from json data
        for ($j=0;$j<count($data->results[0]->address_components);$j++) {
            $cn=array($data->results[0]->address_components[$j]->types[0]);
            if(in_array("locality", $cn)) {
                $city= $data->results[0]->address_components[$j]->long_name;
            }
        }
     } else{
       echo 'Location Not Found';
     }
     return $city;
  }
