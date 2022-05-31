<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller'] = 'test';
$route['otp/send'] = 'app/generateOtp';
$route['otp/verify'] = 'app/verifyOtp';
$route['registration'] = 'app/registration';

$route['car/brands'] = 'app/getBrands';
$route['car/models'] = 'app/getModels';
$route['car/variants'] = 'app/getVariantList';
$route['car/years'] = 'app/getManufactureYears';

$route['dashboard/leads'] = 'app/getLeadData';
$route['profile'] = 'dealer/getProfileInfo';

$route['test/otp'] = 'test/otp';
$route['delete/dealer'] = 'test/deleteDealer';

$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

/* Profile */
$route['profile/edit'] = 'app/updateProfile';
$route['profile/overview'] = 'app/getOverview';
$route['profile/overview/save'] = 'app/getOverview';

// About Notes Routes
$route['lead/list'] = 'Dealer/leadList';
$route['lead/notes/create'] = 'Dealer/noteCreate';
$route['lead/notes/edit'] = 'Dealer/noteEdit';
$route['lead/notes/delete'] = 'Dealer/noteDelete';
$route['lead/notes/list'] = 'Dealer/note';

//Test Drive Car List
$route['drive/car/list'] = 'Dealer/getTestDriveCarList';
$route['drive/car/edit'] = 'Dealer/editTestDriveCar';
$route['drive/car/delete'] = 'Dealer/deleteTestDriveCar';
$route['drive/car/create'] = 'Dealer/createTestDriveCar';
$route['drive/car/status'] = 'Dealer/updateTestDriveStatus';

// About showroom data
$route['lead/showroom/create'] = 'Dealer/insertShowroom';
$route['lead/showroom/edit'] = 'Dealer/showroomEdit';
$route['lead/showroom/delete'] = 'Dealer/deleteShowroom';
$route['lead/showroom/list'] = 'Dealer/getShowRoomInformation';
$route['lead/showroom/status'] = 'Dealer/updateShowroomStatus';

// About Attachment data
$route['lead/attachment/create'] = 'Dealer/insertAttachments';
$route['lead/attachment/edit'] = 'Dealer/updateAttachments';
$route['lead/attachment/delete'] = 'Dealer/deleteAttachment';
$route['lead/attachment/list'] = 'Dealer/getAttachmentData';
$route['lead/attachment/download'] = 'Dealer/downloadAttachment';

// Account Information
$route['subdealer/account/create'] = 'Dealer/accountInformation';
$route['subdealer/account/get'] = 'Dealer/getAccountInformation';

// Management Information
$route['management/information/create'] = 'Dealer/insertManagementInformation';
$route['management/information/edit'] = 'Dealer/editManagementInformation';
$route['management/information/delete'] = 'Dealer/deleteManagementInformation';
$route['management/information/list'] = 'Dealer/getManagementInformation';
$route['management/information/status'] = 'Dealer/updateSManagementInformationStatus';

// testimonial
$route['app/testimonialList'] = 'app/testimonial';
$route['app/sendOtp1'] = 'app/sendOtp1';
$route['app/sendOtp2'] = 'app/sendOtp2';
// $route['app/signupCustomer'] = 'app/signupCustomer';
$route['app/SingleCustomerDetails'] = 'app/SingleCustomerDetails';
$route['app/sendOtp3'] = 'app/sendOtp3';
$route['app/signupcustomer'] = 'app/signupcustomer';
$route['app/AddTestimonial'] = 'app/AddTestimonialInsert';
$route['app/AddCustomer'] = 'app/AddCustomerInsert';
$route['app/AddCustomerdetails'] = 'app/AddCustomerdetails';
$route['app/Addwhislist']='app/Addwhislist';
$route['app/Deletewhislist']='app/Deletewhislist';
$route['app/customerwhislist']='app/customerwhislist';
$route['app/readCustomerDataById'] = 'app/readCustomerDataById';
$route['app/addcontactus']='app/AddContactUs';


//General
$route['app/cartype']='app/cartype';
$route['app/brandtype']='app/brandtype';
$route['app/model']='app/model';
$route['app/citylist']='app/citylist';
$route['app/getcitynamebyCityid']='app/getcitynamebyCityid';
$route['app/state']='app/state';
//Shop Services
$route['app/services']='app/carservices';
$routw['shop/getShopProfileById']='shop/getShopProfileById';

$route['app/carAndShopservice']='app/carAndShopservice';

$route['shop/AddshopService']='shop/AddshopService';
$route['shop/UpdateshopService']='shop/UpdateshopService';
$route['shop/AddShopdetails']='shop/AddShopdetails';

$route['shop/AddComboOfferDetails']='shop/AddComboOfferDetails';

$route['shop/getComboOffersByShopid']='shop/getComboOffersByShopid';

$route['shop/shopserviceByModelid']='shop/shopserviceByModelid';

$route['shop/combooffertblByModelid']='shop/combooffertblByModelid';

$route['shop/dashboardShopList']='shop/dashboardShopList';
$route['shop/dashboardShopSearch']='shop/dashboardShopSearch';

$route['shop/OnlineBookingShopDetails']='shop/OnlineBookingShopDetails';

$route['shop/Updateshopoffer']='shop/Updateshopoffer';

$route['shop/dashboardShopDetailsByOffer']='shop/dashboardShopDetailsByOffer';

$route['shop/CustomerCarDetailsInsert']='shop/CustomerCarDetailsInsert';
$route['shop/getallshoplist']='shop/getallshoplist';
//
$route['app/CarDetailsByCustomerId']='app/CarDetailsByCustomerId';

$route['app/RemoveMyCarInfo']='app/RemoveMyCarInfo';
//onlinebooking
$route['onlinebooking/addonlinebooking']='onlinebooking/addonlinebooking';

$route['shop/addonlinebooking']='shop/addonlinebooking';

$route['app/allmodels']='app/allmodels';

$route['shop/AddShopserviceDetails']='shop/AddShopserviceDetails';

$route['shop/AddMasterservice']='shop/AddMasterservice';

$route['shop/MasterServiceAndShopService']='shop/MasterServiceAndShopService';

$route['shop/changeShopServiceStatus']='shop/changeShopServiceStatus';

$route['car/getCarinfomodels'] = 'app/getCarinfomodels';

$route['shop/customerBookingForShop'] = 'shop/customerBookingForShop';

$route['shop/master_pickdrop_status'] = 'shop/master_pickdrop_status';

$route['shop/changeBookingStatus']='shop/changeBookingStatus';

$route['shop/AcceptedBookingList'] = 'shop/AcceptedBookingList';

$route['shop/master_carwash_status'] = 'shop/master_carwash_status';

$route['shop/changeCarwashStatus']='shop/changeCarwashStatus';

$route['shop/getcurrentComboOffersByShopid']='shop/getcurrentComboOffersByShopid';

$route['shop/getServiceDataOffersByCurdate']='shop/getServiceDataOffersByCurdate';

$route['app/getMybookingDetails']='app/getMybookingDetails';
$route['shop/dashboardShopSearchOffer']='shop/dashboardShopSearchOffer';

$route['shop/getBookingDetailsById']='shop/getBookingDetailsById';

$route['shop/getloadmasterComboOffer']='shop/getloadmasterComboOffer';
$route['app/getcustomerwhislistprofile']='app/getcustomerwhislistprofile';
$route['shop/getcurrentComboOffersByShopiddashboard']='shop/getcurrentComboOffersByShopiddashboard';

$route['shop/insertShopHolidays']='shop/insertShopHolidays';
$route['shop/getShopHolidays']='shop/getShopHolidays';
$route['shop/DeleteHolidays']='shop/DeleteHolidays';
$route['shop/getholidaysForAll']='shop/getholidaysForAll';

$route['shop/servicebasedonmodel']='shop/servicebasedonmodel';
$route['shop/RemoveMyComboOffer']='shop/RemoveMyComboOffer';

$route['app/carDetByModelId']='app/carDetByModelId';

$route['app/getServiceDataOnlineBookingModel'] ='app/getServiceDataOnlineBookingModel';
$route['shop/updatepickupdrop']='shop/updatepickupdrop';

$route['app/getcustomerByCityId']='app/getcustomerByCityId';

// $route['app/getRegistrationNumberByModel']='app/getRegistrationNumberByModel';
$route['app/CarDetailsByIdShopOnlineBooking']='app/CarDetailsByIdShopOnlineBooking';

$route['shop/holidaytimeupdate']='shop/holidaytimeupdate';
$route['shop/chartcustomercombo']='shop/chartcustomercombo';