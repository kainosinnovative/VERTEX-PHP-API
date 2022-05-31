<?php

/**
 * All common DB-connection functions will be written here
 *
 *
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class App_model extends CI_Model
{

    /**
     * Check owner function
     *
     * @param int $mobile
     * @return array owner details
     */
    public function checkDealer($mobile)
    {
        return $this->db->select('dealer_id')
            ->get_where('dealer', array('contact_no' => $mobile))
            ->row();
    }

    /**
     * Check owner function
     *
     * @param int $mobile
     * @return array owner details
     */
    public function getDealer($mobile)
    {
        return $this->db->select('*')
            ->get_where('dealer', array('contact_no' => $mobile))
            ->row_array();
    }

    /**
     * To Add dealer
     *
     * @param Array $data - dealer details
     * @return array dealer details
     */
    public function addDealer($data)
    {
        $dealerData = array('dealer_name' => $data['name'], 'dealers_name' => $data['dealership'], 'job_title' => $data['designation'], 'contact_no' => $data['number'], 'email_id' => $data['email'], 'address' => $data['address'], 'city' => $this->getCityFromAddress($data['address']), 'added_date' => getDateTime(), 'brand' => $data['brand']);
        $this->db->insert("dealer", $dealerData);
        $insert_id = $this->db->insert_id();
        $dealerLoginData = array('dealer_id' => $insert_id, 'sub_dealer_id' => $insert_id, 'email_id' => $data['email'], 'type' => 'dealer', 'added_date' => getDateTime(), 'status' => 1);
        $this->db->insert("dealer_login", $dealerLoginData);
        if (empty($this->checkOwner($data['number']))) {
            $ownerData = array('owner_full_name' => $data['name'], 'first_name' => $data['name'], 'owner_phone' => $data['number'], 'owner_email' => $data['email'], 'owner_address' => $data['address'], 'city' => $this->getCityFromAddress($data['address']), 'added_date' => getDateTime());
            $userData = array('firstname' => $data['name'], 'telephone' => $data['number'], 'email' => $data['email'], 'address' => $data['address'], 'city' => $this->getCityFromAddress($data['address']), 'date_added' => getDateTime());
            $this->db->insert("test_drive_car_owners", $ownerData);
            $this->db->insert("user", $userData);
        }
        return $this->db->select('*')
            ->get_where('dealer', array('dealer_id' => $insert_id))
            ->row_array();
    }

    /**
     * Check owner function
     *
     * @param int $mobile
     * @return array owner details
     */
    public function checkOwner($mobile)
    {
        return $this->db->select('owner_id,authtoken,owner_full_name,owner_email,name1,phn1')
            ->get_where('test_drive_car_owners', array('owner_phone' => $mobile))
            ->row_array();
    }

    /**
     * Get City from address
     *
     * @return string city
     */
    public function getCityFromAddress($address)
    {
        if (empty($address)) {
            return "";
        }
        $city = "";
        $all_cities = $this->db->select("name, name_alias")->from("city")->where("country_id", 252)->get()->result_array();
        foreach ($all_cities as $r) {
            if (preg_match("/" . $r['name'] . "/ims", $address)) {
                $city = $r['name'];
                break;
            } elseif (!empty($r['name_alias'])) {
                if (preg_match("/" . $r['name_alias'] . "/ims", $address)) {
                    $city = $r['name_alias'];
                }
                break;
            }
        }
        return $city;
    }

    /**
     * Get Brands
     *
     *
     * @return array brands
     */
    public function getBrands()
    {
        $this->db->select('DISTINCT(b.brand_name), b.brand_id');
        $this->db->join('model m', 'b.brand_id = m.brand_id and m.status = 1');
        return $this->db->order_by('b.brand_name')->get_where('brand b', array('b.status' => 1))->result_array();

    }
/**
 * Get Models by brand_id
 *
 * @brand
 * @return array Models
 */
    public function getModels($brand)
    {
        $this->db->select('model_id, model_name');
        //$this->db->from('model m');
        //$this->db->join('brand b', 'b.brand_id = m.brand_id and b.status = 1');
        $this->db->where('brand_id', $brand);
        $this->db->where('status', 1);
        $this->db->order_by('model_name', 'ASC');
        return $this->db->get('model')->result_array();
    }
    /**
     * Get Variant by brand id and model id
     *
     * @brand_id
     * @model_id
     * @return array Variants
     */

    public function getVariants($brand, $model)
    {
        $this->db->select('variant_id, variant, pro_name');
        $this->db->where('brand_id', $brand);
        $this->db->where('model_id', $model);
        $this->db->where('status', 1);
        $this->db->order_by('pro_name', 'ASC');
        return $this->db->get('variant')->result_array();
    }

    public function getManufactureYears()
    {
        $this->db->select('manufacturing_year_id, manufacturing_year');
        $this->db->where('status', 1);
        $this->db->order_by('manufacturing_year', 'DESC');
        return $this->db->get('manufacturing_year')->result_array();
    }

    /**
     * To get lead status based counts
     *
     * @param string $status - lead status
     * @param int $dealerId
     * @param int $month
     * @param int $year
     * @return array counts array
     */
    public function getLead($status, $dealerId, $month, $year, $endDate)
    {
        //$dealerId = 148;
        $this->db->select('COALESCE(SUM(id), 0) as count');
        if ($status !== 'All') {
            $this->db->where('status', $status);
        }
        $this->db->where('dealer_id', $dealerId);
        // $this->db->where('added_date >=', $endDate);
        $this->db->where('MONTH(added_date)', $month);
        $this->db->where('YEAR(added_date)', $year);
        //
        return $this->db->get("zoho_dealer_data_status")->row()->count;
    }

    public function getLeadPipeline($status, $dealerId, $month, $year, $user, $showroom, $rating, $byDate, $startDate, $endDate)
    {
        $dealerId = 148;

        $this->db->select('zl.full_name, zl.potential_car, zl.followup_date, zl.mobile, zd.verify_status');
        $this->db->from('zoho_dealer_data_status zd');
        $this->db->join('zoho_leads zl', 'zd.zoho_lead_id = zl.lead_id');
        $user ? $this->db->where('zl.full_name', $user) : '';
        $showroom ? $this->db->where('zl.showroom', $showroom) : '';
        $rating ? $this->db->where('', $rating) : '';
        $byDate ? $this->db->where('', $byDate) : '';
        $startDate ? $this->db->where('added_date >= ', $startDate) : '';
        $endDate ? $this->db->where('added_date <= ', $endDate) : '';
        if ($status !== 'All') {
            $this->db->where('status', $status);
        }
        $this->db->where('dealer_id', $dealerId);
        // $this->db->where('added_date >=', $endDate);
        $this->db->where('MONTH(added_date)', $month);
        $this->db->where('YEAR(added_date)', $year);
        //
        return $this->db->get()->result_array();
    }

    public function getOverview($dealer_id)
    {
        $this->db->select('d.dealer_name, b.brand_name, d.city, d.contact_no, d.email_id');
        $this->db->from('dealer d');
        $this->db->join('brand b', 'b.brand_id= d.brand and b.status = 1', 'left');
        $this->db->where('d.dealer_id', $dealer_id);
        $this->db->where('d.status', 1);
        return $this->db->get()->row_array();
    }

    /**  dealer profile
     *   return profile path
     */
    /*  public function getProfile($dealer_id) {
    $this->db->select();

    ->where()->get()->row_array()
    } */

    public function updateProfile($path, $dealer_id)
    {
        $this->db->where('dealer_id', $dealer_id);
        $this->db->update('dealer', array('profile' => $path));
        return "updated";
    }

    public function updateOverview($data, $dealer_id)
    {
        $this->db->where('dealer_id', $dealer_id);
        return $this->db->update('dealer', $data) ? 'updated' : 'fail';
    }


    public function signupcustomer($registerUserName,$registerEmailid,$registerMobileNo)
    {
        $sql = "INSERT INTO customers (customer_name,mobileno,emailid)
        VALUES ('$registerUserName','$registerMobileNo','$registerEmailid')";
        var_dump($sql);

        $query = $this->db->query($sql);
        return $query;
    }

    public function gettestimonialList()
    {
        $sql = " SELECT * FROM testimonial t, customers c where t.customer_id=c.customer_id ORDER BY t.user_rating desc,  t.review_date desc limit 0,3";
		$query = $this->db->query($sql);
        return $query->result_array();


    }

    public function checkCustomer($mobile) {
         $result = $this->db->query("SELECT count(*) as cnt from customers where (mobileno='$mobile')")->row_array();
            $cnt = $result['cnt'];
            return $cnt;
    }

    public function checkShopOwner($mobile) {
        $result = $this->db->query("SELECT count(*) as cnt from shopinfo where (mobileno='$mobile')")->row_array();
            $cnt = $result['cnt'];
            return $cnt;
    }


    public function getSingleCustomerDetails($mobile)
    {
        $sql = "SELECT * FROM customers where mobileno='".$mobile."'";
		$query = $this->db->query($sql);
        // var_dump($sql);
        return $query->result_array();

    }

    public function getSingleshopDetails($mobile)
    {
        $sql = "SELECT * FROM shopinfo where mobileno='".$mobile."'";
		$query = $this->db->query($sql);
        // var_dump($sql);
        return $query->result_array();

    }

    public function signupCustomerInsert($customer_name,$customer_mobileno,$customer_email){
        $sql = "INSERT INTO customers (firstname,mobileno,emailid)
        VALUES ('$customer_name','$customer_mobileno','$customer_email')";
        echo($sql);


         $query = $this->db->query($sql);
         return $query;
        //  return $query->result_array();


    }
    public function signupShopOwnerInsert($customer_name,$customer_mobileno,$customer_email){
        $currentDate = date('y-m-d');
        $sql = "INSERT INTO shopinfo (firstname,mobileno,emailid,status,lastupddt,is_pickup_drop_avl)
        VALUES ('$customer_name','$customer_mobileno','$customer_email','1','$currentDate','0')";
        echo($sql);


         $query = $this->db->query($sql);
         return $query;
        //  return $query->result_array();


    }


    public function AddTestimonial($data){

        // var_dump($Finaldata)
       return $this->db->insert('testimonial', $data);

    }

    public function AddCustomerdetails($customer_id,$data) {
        $this->db->where('customer_id', $customer_id);
        $this->db->update('customers', $data);
        return 'updated';
    }


    public function isCustomerReviewed($customer_id){
        $result = $this->db->query("SELECT count(*) as cnt from testimonial where (customer_id='$customer_id')")->row_array();
            $cnt = $result['cnt'];
            return $cnt;
    }

    public function getReviewCount($customer_id) {
             $result =   $this->db->select('*')->from('testimonial')->where('customer_id', $customer_id)->get()->row_array();

        // $result = $this->db->query("SELECT * from testimonial where (customer_id='$customer_id')")->row_array();
        // var_dump(">>>>$result);
            $review_count = $result['review_count'] + 1;
            return $review_count;
    }


    public function UpdateTestimonial($user_description,$user_rating,$customer_id,$review_count) {
        $currentDate = date('Y-m-d H:i:s');
        $sql = "UPDATE testimonial
        SET user_description = '$user_description', user_rating= '$user_rating', review_count = '$review_count',review_date = '$currentDate'
        WHERE customer_id = $customer_id;";
        echo($sql);
        $this->db->query($sql);
        return $this->db->query($sql);
    }


    public function updateProfileImg($customer_id,$target_path) {
        $sql = "UPDATE customers
        SET profile_img = '$target_path'
        WHERE customer_id = $customer_id;";
        echo($sql);
        $this->db->query($sql);
        return $this->db->query($sql);
    }



    public function getSingleCustomerById($customer_id){
        $sql = "SELECT * FROM customers where customer_id='".$customer_id."'";
		$query = $this->db->query($sql);
        // var_dump($sql);
        return $query->row_array();
    }
  public function AddContactUs($data)
  {
    return $this->db->insert('contact_us', $data);
  }

    public function getcartype()
    {
        $this->db->select('*');
        $this->db->from('car_type');
        return $this->db->get()->result_array();
    }
    public function getbrandtype()
    {
        $this->db->select('*');
        $this->db->from('brand');
        return $this->db->get()->result_array();
    }
    public function getmodel($car_type_id,$brand_id)
    {
        $this->db->select('id,model_name');
        $this->db->from('models');

        $this->db->where('car_type_id', $car_type_id);
        $this->db->where('brand_id', $brand_id);
        return $this->db->get()->result_array();

    }

    public function getcarservices()
    {
        $this->db->select('*');
        $this->db->from('services');
        return $this->db->get()->result_array();
    }

    public function getcarAndShopservice($shopid)
    {
        $this->db->select('DISTINCT(a.service_id),a.service_name,b.actual_amount,c.model_name,b.offer_percent,b.offer_price,b.model_id,b.shop_id,b.status,b.id,b.from_date,b.to_date');
        $this->db->join('services a','a.service_id=b.service_id');

        $this->db->join('models c','c.id= b.model_id');
        $this->db->join('shopinfo d','d.status=1');
        // $this->db->join('shopinfo d','d.status=1');
        $this->db->order_by('b.model_id','a.service_id');
        $this->db->where('b.shop_id',$shopid);
// $this->db->where('CURDATE() between b.from_date and b.to_date');
$this->db->from('shop_service b');
return $this->db->get()->result_array();


        // $sql = "select a.service_id,a.service_name,c.model_name,b.actual_amount,b.id,b.offer_percent,b.offer_price,b.model_id,b.shop_id	  from services a , shop_service b, models c WHERE a.service_id=b.service_id and b.shop_id = '1' and c.id= b.model_id ORDER BY a.service_id;";
        // $sql = "SELECT * FROM shopinfo where mobileno='".$mobile."'";
		// $query = $this->db->query($sql);

        // return $query->result_array();

    }

    public function getcitylist()
    {
        $this->db->select('*');
        $this->db->from('city_list');
        return $this->db->get()->result_array();
    }
    public function getstatelist()
    {
        $this->db->select('*');
        $this->db->from('state');
        return $this->db->get()->result_array();
    }

    public function CustomerCarDetailsInsert($customer_id,$data) {
        $this->db->where('customer_id', $customer_id);
        $this->db->insert('customer_carinfo', $data);
        return 'inserted';
    }


    public function getCarDetailsByCustomerId($customer_id)
    {

        $sql = "SELECT * FROM customer_carinfo a, car_type b, models c,brand d WHERE a.customer_id = '".$customer_id."' and a.cartype= b.id and a.model=c.id and a.brand=d.id and a.carinfo_status=1";
		$query = $this->db->query($sql);

        return $query->result_array();

    }


    public function RemoveMyCarInfoDelete($carinfo_id)
    {
        $this->db->where('carinfo_id', $carinfo_id);
        $this->db->update('customer_carinfo', array('carinfo_status' => 0));
        return "updated";
        // $where = ['carinfo_id ' => $carinfo_id];
        // $this->db->where($where);
        // $this->db->delete('customer_carinfo');
        // return "deleted";
    }


    public function Addwhislisttodb($whislist,$Customer_id,$date,$city_id)
    {
      // echo $whislist;

       $dbdata1 = array(
        "whislist" => $whislist,
        "lastupddt" => $date,
        "Customer_id" => $Customer_id,
        "city_id"=>$city_id
   );

            $this->db->insert("customer_whislist", $dbdata1);

         return 'Success';
    }
    public function Deletewhislisttodb($whislist,$Customer_id,$city_id)
    {
        $where = array("Customer_id "=>$Customer_id,"city_id"=>$city_id,"whislist"=>$whislist);
        $this->db->where($where);
        $this->db->delete('customer_whislist');
        return "deleted";

    }


    public function getallmodels()
    {
        $this->db->select('*');
        $this->db->from('models');
        return $this->db->get()->result_array();
    }
    public function getCustomerwhislist($Customer_id,$city_id)
    {
        $this->db->select('*');
        $this->db->from('customer_whislist');
        $this->db->where('Customer_id', $Customer_id);
        $this->db->where('city_id', $city_id);
        return $this->db->get()->result_array();
    }

    public function SelectCarinfomodels($vehicle_number)
    {

        $sql = "SELECT * FROM customer_carinfo a, models c WHERE a.vehicle_number = '".$vehicle_number."'  and a.model=c.id";
		$query = $this->db->query($sql);

        return $query->result_array();

    }

    public function getMybookingDetails($currentUserId)
    {

        $sql = "SELECT a.*,c.firstname,e.*,f.name as shopname, g.model as modelname FROM onlinebooking a, customers c, booking_status e, shopinfo f, customer_carinfo g WHERE DATE(bookingdate) >= DATE(NOW()) - INTERVAL 1 MONTH and g.vehicle_number = a.vehicle_number and  f.shop_id = a.Shop_id and a.Customer_id='$currentUserId' and a.Customer_id=c.customer_id and a.Booking_id=e.Booking_id order by a.bookingdate desc";
        $query = $this->db->query($sql);

        return $query->result_array();

    }
    public function getcustomerwhislistprofile($currentUserId)
    {
        $sql="SELECT a.name,c.city_name,a.shop_logo from shopinfo a ,customer_whislist b,city_list c WHERE a.city=b.city_id and c.city_id=b.city_id and a.shop_id=b.whislist and b.Customer_id='$currentUserId'";
          $query = $this->db->query($sql);

return $query->result_array();
    }

    public function getcarDetByModelId($customer_id,$model)
    {

        $sql = "SELECT * FROM customer_carinfo a, car_type b, models c,brand d WHERE a.customer_id = '".$customer_id."' and a.model='$model' and a.cartype= b.id and a.model=c.id and a.brand=d.id and a.carinfo_status = 1";
		$query = $this->db->query($sql);

        return $query->result_array();

    }

    public function getServiceDataOnlineBookingModel($shopid,$modelid)
    {
        $this->db->select('DISTINCT(a.service_id),a.service_name,b.actual_amount,c.model_name,b.offer_percent,b.offer_price,b.model_id,b.shop_id,b.status,b.id,b.from_date,b.to_date');
        $this->db->join('services a','a.service_id=b.service_id');

        $this->db->join('models c','c.id= b.model_id');
        $this->db->join('shopinfo d','d.status=1');
        
        $this->db->order_by('a.service_id');
        $this->db->where('b.shop_id',$shopid);
        $this->db->where('b.model_id',$modelid);
      $this->db->where('b.status',1);
// $this->db->where('CURDATE() between b.from_date and b.to_date');
$this->db->from('shop_service b');
//  $this->db->where('b.offer_percent1',1);
return $this->db->get()->result_array();


    }

    public function getcustomerByCityId($cityid)
    {

        $this->db->select('*');
        $this->db->from('customers');
       
        $this->db->where('city', $cityid);
        return $this->db->get()->result_array();

    }

    
    public function getCarDetailsByIdShopOnlineBooking($customer_id)
    {

        $sql = "SELECT DISTINCT(a.model),c.model_name FROM customer_carinfo a, car_type b, models c,brand d WHERE a.customer_id = '".$customer_id."' and a.cartype= b.id and a.model=c.id and a.brand=d.id";
		$query = $this->db->query($sql);

        return $query->result_array();

    }

    public function getcitynamebyCityid($city_id)
    {
        $this->db->select('*');
        $this->db->from('city_list');
        $this->db->where('city_id', $city_id);
        
        return $this->db->get()->result_array();
    }
}

