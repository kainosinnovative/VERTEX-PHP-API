<?php

/**
 * All common DB-connection functions will be written here
 *
 *
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Shop_model extends CI_Model
{

    public function getSingleShopById($shop_id)
    {
        $this->db->select('*');
        $this->db->from('shopinfo');
        $this->db->where('shop_id', $shop_id);
        return $this->db->get()->row_array();
    }
    public function AddshopServiceInsert($service_amount,$serviceid,$shopid){
        $currentDate = date('y-m-d');
        $sql = "INSERT INTO shop_service (shop_id,service_id,actual_amount,lastupddt)
        VALUES ('$shopid','$serviceid','$service_amount','$currentDate')";
        // echo($sql);


         $query = $this->db->query($sql);
         return $query;
        //  return $query->result_array();


    }

    public function shopServiceUpdate($service_amount,$serviceid,$shopid,$modelid){
        $currentDate = date('y-m-d');

        $sql = "UPDATE shop_service
        SET actual_amount = '$service_amount', lastupddt = '$currentDate'
        WHERE shop_id = $shopid and service_id = $serviceid and model_id=$modelid";


         $query = $this->db->query($sql);
         return $query;
        //  return $query->result_array();


    }
    public function updateProfileImg($shop_id,$target_path) {
        $sql = "UPDATE shopinfo
        SET shop_image = '$target_path'
        WHERE shop_id = $shop_id;";
        $this->db->query($sql);
        return $this->db->query($sql);
    }
    public function updateShopLogo($shop_id,$target_path) {
        $sql = "UPDATE shopinfo
        SET shop_logo = '$target_path'
        WHERE shop_id = $shop_id;";
       // echo($sql);
        $this->db->query($sql);
        return $this->db->query($sql);
    }
    public function AddShopdetails($shop_id,$data) {
        $this->db->where('shop_id', $shop_id);
        $this->db->update('shopinfo', $data);
        return 'updated';
    }

    public function AddComboOfferDetailsInsert($services,$combo_price,$shop_id,$offer_percent,$start_date,$end_date,$model_id,$original_amount,$offer_name){
        $currentDate = date('y-m-d');
        $sql = "INSERT INTO combo_offers (services,combo_price,shop_id,offer_percent,start_date,end_date,lastupddt,model_id,original_amount,offer_name)
        VALUES ('$services','$combo_price','$shop_id','$offer_percent','$start_date','$end_date','$currentDate','$model_id','$original_amount','$offer_name')";
        // echo($sql);


         $query = $this->db->query($sql);
         return $query;
        //  return $query->result_array();


    }

    public function getComboOffersByShopid($month,$year,$id)
    {   $i=0;
        $resultarray=array();
        $yearcount = count($year);
        $monthCount = count($month);
        // if($monthCount == 1 && $yearcount == 1) {
        //     $sql = "SELECT * FROM combo_offers where shop_id='$id' and YEAR(DATE(start_date))='$year[0]' and  MONTH(DATE(start_date)) = '$month[0]'";
        //     $query = $this->db->query($sql);

        //     $resultarray =  $query->result_array();
        //     // var_dump($sql);
        //     // return $query->result_array();
       
        // }
        // else {
        // var_dump($month);
        // var_dump($year);
        foreach ($year as $key => $value) {
          foreach ($month as $key1 => $value1) {
            $sql = "SELECT * FROM combo_offers where shop_id='$id' and YEAR(DATE(start_date))='$value' and  MONTH(DATE(start_date)) = '$value1' order by offer_id desc";
                $query = $this->db->query($sql);
                $rowcount = $query->num_rows();
                // var_dump($rowcount);
                if($rowcount != "0") {
                    array_push($resultarray,$query->result_array());
                    

            // $this->db->select('*');
            // $this->db->from('combo_offers');
            // $this->db->where('shop_id', $id);
            // $this->db->where('YEAR(DATE(start_date))',$value);
            // $this->db->where('MONTH(DATE(start_date))',$value1);
            // $resultarray[$i++]= $this->db->get()->row_array();
                }
        }
    }
    // var_dump($resultarray);
    
    
// }

return $resultarray;  
        

    }

    public function getshopserviceByModelid($shopid)
    {

        $sql = "SELECT distinct(s.model_id) , m.model_name FROM models m, shop_service s WHERE m.id=s.model_id and s.shop_id='".$shopid."'";
		$query = $this->db->query($sql);

        return $query->result_array();

    }

    public function getcombooffertblByModelid($shop_id,$model_id) {
        $this->db->select('DISTINCT(a.service_id),a.service_name,b.actual_amount,c.model_name,b.offer_percent,b.offer_price,b.model_id,b.shop_id');
        $this->db->join('services a','a.service_id=b.service_id');

        $this->db->join('models c','c.id= b.model_id');
        $this->db->join('shopinfo d','d.status=1');
        // $this->db->join('shopinfo d','d.status=1');
        return $this->db->order_by('a.service_id')->get_where('shop_service b',array('b.shop_id' => $shop_id,'b.model_id' => $model_id,'b.status'=>'1'))->result_array();
     }



     public function getdashboardShopList($cityid)
    {
        // $sql = "SELECT max(b.offer_percent),a.*,b.services,b.combo_price,b.model_id, c.model_name, d.city_name,b.shop_id,b.offer_percent,b.offer_id FROM shopinfo a, combo_offers b, models c, city_list d WHERE a.shop_id = b.shop_id and b.model_id= c.id and d.city_id=a.city and a.city='".$cityid."' and !(CURDATE() between a.leave_from_date and a.leave_to_date) and (CURDATE() between b.start_date and b.end_date) GROUP BY b.shop_id";
        // $sql = "SELECT max(b.offer_percent),a.*,b.services,b.combo_price,b.model_id, c.model_name, d.city_name,b.shop_id,b.offer_percent,b.offer_id FROM shopinfo a, combo_offers b, models c, city_list d WHERE a.shop_id = b.shop_id and b.model_id= c.id and d.city_id=a.city and a.city='".$cityid."' and  (CURDATE() between b.start_date and b.end_date) GROUP BY b.shop_id";
        $sql = "SELECT b.offer_percent,a.*,b.services,b.combo_price as comboprice ,b.original_amount,b.model_id, c.model_name, d.city_name,b.shop_id FROM shopinfo a, combo_offers b, models c, city_list d WHERE a.shop_id = b.shop_id and b.model_id= c.id and d.city_id=a.city and a.city='".$cityid."' and (CURDATE() between b.start_date and b.end_date) order by b.offer_percent desc";
		$query = $this->db->query($sql);

        return $query->result_array();


    }
    public function getdashboardServiceSearch($shopname,$city_id)
    {
        $service_id=array();
        $sql = "SELECT service_id FROM services WHERE search_id='$shopname'";
		$query = $this->db->query($sql);
        $service_id=$query->result_array();
       $ser= $service_id[0]['service_id'];

        $sql1 = "Select b.offer_percent,a.*,b.service_id,b.offer_price as offer1,b.actual_amount,b.model_id,c.model_name,d.city_name,b.shop_id From shopinfo a,shop_service b,models c ,city_list d where a.shop_id = b.shop_id and b.model_id= c.id and d.city_id=a.city and b.service_id ='$ser' and (CURDATE() between b.from_date and b.to_date) and b.shop_id in (Select shop_id from shopinfo where city='$city_id') order by b.offer_percent desc";
		$query1 = $this->db->query($sql1);

        return $query1->result_array();

    }
    public function getdashboardShopSearch($shopname)
    {
        $sql = "SELECT b.offer_percent,a.*,b.services,b.combo_price as comboprice ,b.original_amount,b.model_id, c.model_name, d.city_name,b.shop_id FROM shopinfo a, combo_offers b, models c, city_list d WHERE a.shop_id = b.shop_id and b.model_id= c.id and d.city_id=a.city and a.shop_id ='$shopname' and (CURDATE() between b.start_date and b.end_date) order by b.offer_percent desc";
		$query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getOnlineBookingShopDetails($shopid,$model)
    {
        $sql = "SELECT a.*,b.services,b.combo_price,b.offer_percent,b.model_id, c.model_name,b.original_amount,b.offer_id,b.offer_name FROM `shopinfo` a, combo_offers b, models c WHERE a.shop_id = b.shop_id and a.shop_id = '".$shopid."' and b.model_id = '$model' and b.model_id= c.id and (CURDATE() between b.start_date and b.end_date)  order BY b.offer_percent DESC;";
		$query = $this->db->query($sql);

        return $query->result_array();


    }


     public function AddShopOfferDetails($service_id,$model_id,$lastupddt,$offer_price,$shop_id,$offer_percent,$start_date,$end_date)
    {
        $sql = "UPDATE shop_service SET offer_percent='$offer_percent',from_date='$start_date',to_date='$end_date',offer_price='$offer_price',lastupddt='$lastupddt'
        WHERE service_id=$service_id AND model_id=$model_id AND shop_id=$shop_id";

         $query = $this->db->query($sql);
         return $query;
    }


    public function getdashboardShopDetailsByOffer($cityid)
    {
        $sql = "Select b.offer_percent,a.*,b.service_id,b.offer_price as offer1,b.actual_amount,b.model_id,c.model_name,d.city_name,b.shop_id From shopinfo a,shop_service b,models c ,city_list d where a.shop_id = b.shop_id and b.model_id= c.id and d.city_id=a.city and (CURDATE() between b.from_date and b.to_date) and b.shop_id in (Select shop_id from shopinfo where city='".$cityid."' ) order by b.offer_percent desc;";
		$query = $this->db->query($sql);

        return $query->result_array();


    }
    public function getdashboardShopSearchOffer($cityid,$shopid)
    {
        $sql = "Select b.offer_percent,a.*,b.service_id,b.offer_price as offer1,b.actual_amount,b.model_id,c.model_name,d.city_name,b.shop_id From shopinfo a,shop_service b,models c ,city_list d where a.shop_id = b.shop_id and b.model_id= c.id and d.city_id=a.city and (CURDATE() between b.from_date and b.to_date) and b.shop_id in (Select shop_id from shopinfo where city='".$cityid."' and shop_id='".$shopid."') order by b.offer_percent desc;";
		$query = $this->db->query($sql);

        return $query->result_array();
    }

    public function Addonlinebooking($data)
    {
        // var_dump($data);
      return $this->db->insert('onlinebooking', $data);
    }

    public function bookingstatusInsert($Booking_id)
    {

        $sql = "INSERT INTO booking_status (Booking_id,carwash_status)
        VALUES ('$Booking_id',1)";
        // echo($sql);


         $query = $this->db->query($sql);
         return $query;

    }

    public function AddShopserviceDetailsInsert($data)
    {

        // print_r($data[0]);
        // var_dump($data);
      return $this->db->insert('shop_service', $data);
    }

    public function getMaxServiceId()
    {
        $maxid = 0;
        $row = $this->db->query('SELECT MAX(service_id) AS `maxid` FROM `services`')->row();
        if ($row) {
            $maxid = $row->maxid;
            return $maxid;
        }
    }


    public function MasterServiceShopserviceInsert($model_id,$serviceid,$actual_amount,$shop_id)
    {
        //  return $this->db->insert('services', $data);
        $currentDate = date('y-m-d');
        $sql = "INSERT INTO shop_service (model_id,service_id,actual_amount,lastupddt,shop_id,status)
        VALUES ('$model_id','$serviceid','$actual_amount','$currentDate','$shop_id','1')";
        echo($sql);


         $query = $this->db->query($sql);
         return $query;

    }

    public function autoincrementFrom($maxServiceid1) {
        $sql = "ALTER TABLE services AUTO_INCREMENT = $maxServiceid1";
		$query = $this->db->query($sql);

        // return $query->result_array();
    }

    public function MasterServiceInsert($service_name,$shop_id)
    {
        //  return $this->db->insert('services', $data);
        $currentDate = date('y-m-d');
        $result = $this->db->query("SELECT count(*) as cnt from services")->row_array();
        $cnt = $result['cnt'];
        // return $cnt;
        if($cnt==0)
        {
            $search_id="S1";
        $sql = "INSERT INTO services (search_id,service_name,lastupddt,lastupdby)
        VALUES ('$search_id','$service_name','$currentDate','$shop_id')";
        echo($sql);

        $query = $this->db->query($sql);
        }
        else
        {
            $maxid = 0;
            $row = $this->db->query('SELECT MAX(service_id) AS `maxid` FROM `services`')->row();
            if ($row) {
                $maxid = $row->maxid;
                $maximumserviceid= "S".($maxid+1) ;
            }
            $sql = "INSERT INTO services (search_id,service_name,lastupddt,lastupdby)
            VALUES ('$maximumserviceid','$service_name','$currentDate','$shop_id')";
            echo($sql);

            $query = $this->db->query($sql);
        }


         return $query;

    }

    public function getMasterServiceAndShopService($currentUserId)
    {

        $sql = "SELECT * FROM services ";
		$query = $this->db->query($sql);

        return $query->result_array();

    }


    public function changeShopServiceStatusUpdate($status,$shopserviceid){
        $currentDate = date('y-m-d');
        if($status == 0){
            $status = 1;
        }
        else {
            $status = 0;
        }

        $sql = "UPDATE shop_service
        SET status = '$status', lastupddt = '$currentDate'
        WHERE id = $shopserviceid";


         $query = $this->db->query($sql);
         return $query;
        //  return $query->result_array();


    }
    public function getshoplist($city_id)
    {
        $this->db->select('name as name1,shop_id as id');
        $this->db->from('shopinfo');
        $this->db->where('city', $city_id);
        $query1=$this->db->get()->result_array();

        $this->db->select('service_name as name1,search_id as id');
        $this->db->from('services');
        $query2=$this->db->get()->result_array();

        $query = array_merge($query1, $query2);
        return $query;

    }
    public function getcustomerBookingForShop($currentUserId)
    {

        // $sql = "SELECT a.*,c.firstname,d.services as comboservices,e.* FROM onlinebooking a, customers c, combo_offers d, booking_status e WHERE a.Shop_id='$currentUserId'  and a.Customer_id=c.customer_id and a.combo_id=d.offer_id and a.Booking_id=e.Booking_id and e.booked_status=''";
		$sql = "SELECT a.*,c.firstname,e.* FROM onlinebooking a, customers c, booking_status e WHERE a.Shop_id='$currentUserId' and a.Customer_id=c.customer_id and a.Booking_id=e.Booking_id and (e.booked_status='' or e.booked_status='Rejected') ORDER BY a.bookingdate desc";
        $query = $this->db->query($sql);

        return $query->result_array();

    }

    public function getAcceptedBookingList($currentUserId)
    {

        // $sql = "SELECT a.*,c.firstname,d.services as comboservices,e.* FROM onlinebooking a, customers c, combo_offers d, booking_status e WHERE a.Shop_id='$currentUserId'  and a.Customer_id=c.customer_id and a.combo_id=d.offer_id and a.Booking_id=e.Booking_id and e.booked_status=''";
		$sql = "SELECT a.*,c.firstname,e.* FROM onlinebooking a, customers c, booking_status e WHERE a.Shop_id='$currentUserId' and a.Customer_id=c.customer_id and a.Booking_id=e.Booking_id and e.booked_status='Accepted' ORDER BY a.bookingdate desc";
        $query = $this->db->query($sql);

        return $query->result_array();

    }

    public function getmaster_pickdrop_status()
    {
        $this->db->select('*');
        $this->db->from('master_pickdrop_status');
        return $this->db->get()->result_array();
    }

    public function getmaster_carwash_status()
    {
        $this->db->select('*');
        $this->db->from('master_carwash_status');
        return $this->db->get()->result_array();
    }

    public function changeBookingStatusUpdate($booking_status,$Booking_id,$pickup_message){
        $currentDate = date('y-m-d');
        $sql = "UPDATE booking_status
        SET booked_status = '$booking_status', lastup_bookstatus_date = '$currentDate', pickedAndDrop_status = '$pickup_message'
        WHERE Booking_id = '$Booking_id'";
    // var_dump($sql);

         $query = $this->db->query($sql);
         return $query;
    }

    public function changeCarwashStatusUpdate($carwash_status,$Booking_id){
        $currentDate = date('y-m-d');
        $sql = "UPDATE booking_status
        SET  carwash_status = '$carwash_status' , lastup_carwashstatus_date = '$currentDate' WHERE Booking_id = '$Booking_id'";
    // var_dump($sql);

         $query = $this->db->query($sql);
         return $query;
    }


    public function getcurrentComboOffersByShopid($currentUserId)
    {
        $currentDate = date('y-m-d');
        $sql = "SELECT * FROM combo_offers a, models b where a.shop_id=$currentUserId and ('$currentDate' >= a.start_date and '$currentDate' <= a.end_date) and a.model_id = b.id";
        // $sql = "SELECT * FROM combo_offers a, models b where a.shop_id='$currentUserId' and CURRENT_DATE() >= a.start_date and CURRENT_DATE() <= a.end_date and a.model_id = b.id";
		$query = $this->db->query($sql);
        // var_dump($sql);
        return $query->result_array();

    }
    public function getcurrentComboOffersByShopiddashboard($currentUserId)
    {
        $sql = "SELECT offer_name as name ,offer_percent  as value FROM combo_offers where shop_id='$currentUserId' and (CURRENT_DATE() BETWEEN start_date and end_date) ";
		$query = $this->db->query($sql);
       // var_dump($sql);
        return $query->result_array();
    }


    public function getServiceDataOffersByCurdate($currentUserId)
    {
                        $sql = "SELECT * FROM shop_service a, models b, services c where a.shop_id='$currentUserId' and CURRENT_DATE() >=  a.from_date and CURRENT_DATE() <= a.to_date and a.model_id = b.id and a.service_id=c.service_id and a.status = 1";

                // $sql = "SELECT service_name as name, offer_percent as y FROM shop_service a, models b, services c where a.shop_id='$currentUserId' and CURRENT_DATE() >=  a.from_date and CURRENT_DATE() <= a.to_date and a.model_id = b.id and a.service_id=c.service_id and a.status = 1";
    
        //$sql = "SELECT * FROM shop_service a, models b, services c where a.shop_id='$currentUserId' and (CURRENT_DATE() BETWEEN a.from_date and a.to_date) and a.model_id = b.id and a.service_id=c.service_id and a.status = 1";
		$query = $this->db->query($sql);
        // var_dump($sql);
        return $query->result_array();

    }

    public function getBookingDetailsById($Booking_id)
    {

        $sql = "SELECT a.*,e.* FROM onlinebooking a, booking_status e WHERE a.Booking_id=e.Booking_id and a.Booking_id='$Booking_id'";
		$query = $this->db->query($sql);
        // var_dump($sql);
        return $query->result_array();

    }

    public function getloadmasterComboOffer()
    {
        $this->db->select('*');
        $this->db->from('combo_offers');
        return $this->db->get()->result_array();
    }

    //
    public function insertShopHolidays($currentUserId,$leave_date)
    {
        //  return $this->db->insert('services', $data);
        $currentDate = date('y-m-d');
        $sql = "INSERT INTO shop_holidays (shop_id,	leave_date,lastupddt)
        VALUES ('$currentUserId','$leave_date','$currentDate')";
        // echo($sql);


         $query = $this->db->query($sql);
         return $query;

    }

    public function checkHolidays($currentUserId,$value) {
        $result = $this->db->query("SELECT count(*) as cnt from shop_holidays where (shop_id='$currentUserId' and leave_date='$value')")->row_array();
           $cnt = $result['cnt'];
           return $cnt;
   }

   public function getShopHolidays($shop_id)
    {
        $this->db->select('*');
        $this->db->from('shop_holidays');
        $this->db->where('shop_id', $shop_id);
        return $this->db->get()->result_array();
    }

    public function DeleteHolidays($holidayid){

        $where = ['id ' => $holidayid];
        $this->db->where($where);
        $this->db->delete('shop_holidays');
        return "deleted";
    }

    public function getholidaysForAll()
    {
        $currentDate = date('y-m-d');
        $this->db->select('*');
        $this->db->from('shop_holidays');
        $this->db->where('leave_date', $currentDate);
        return $this->db->get()->result_array();
    }
    public function getservicebasedonmodel($currentUserId,$service_id)
    {
        $sql = "Select id,model_name from models where id not in (select model_id from shop_service where shop_id='$currentUserId' and service_id='$service_id') ";
        // echo($sql);


         $query = $this->db->query($sql);
         return $query->result_array();
    }
    public function RemoveMyComboOffer($offerid)
    {
        $where = ['offer_id ' => $offerid];
        $this->db->where($where);
        $this->db->delete('combo_offers');
        return "deleted";
    }

    public function updatepickupdrop($shop_id,$pickupdropstatus){
        $currentDate = date('y-m-d');
        if($pickupdropstatus == 0){
            $pickupdropstatus = 1;
        }
        else {
            $pickupdropstatus = 0;
        }

        $sql = "UPDATE shopinfo
        SET is_pickup_drop_avl = '$pickupdropstatus'
        WHERE shop_id = $shop_id";


         $query = $this->db->query($sql);
         return $query;
        //  return $query->result_array();


    }


    public function holidaytimeupdate($data)
    {
        // var_dump($data);
      return $this->db->insert('shop_holidays', $data);
    }
    public function chartcustomercombo($shop_id)
    {
        $month = date('m');
    //   $month = 3;
    //   $sql ="select COUNT(Customer_id) as count,combo_id,b.offer_name as offername,c.model_name as modelname from onlinebooking a,combo_offers b,models c where b.model_id=c.id and a.shop_id='$shop_id' and a.combo_id = b.offer_id  GROUP BY b.offer_id HAVING COUNT(b.offer_id) > 1;";

$sql ="select COUNT(Customer_id) as count,combo_id,b.offer_name as offername,c.model_name as modelname from onlinebooking a,combo_offers b,models c where b.model_id=c.id and a.shop_id='$shop_id' and a.combo_id = b.offer_id and MONTH(DATE(start_date)) = '$month' GROUP BY b.offer_id HAVING COUNT(b.offer_id) > 1;";
// var_dump($sql);       
  $query = $this->db->query($sql);
          return $query->result_array();
    }
}