-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2022 at 01:09 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carwash`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_status`
--

CREATE TABLE `booking_status` (
  `id` int(10) NOT NULL,
  `Booking_id` varchar(20) NOT NULL,
  `booked_status` varchar(20) NOT NULL,
  `carwash_status` int(20) NOT NULL,
  `lastup_bookstatus_date` date DEFAULT NULL,
  `lastup_carwashstatus_date` date DEFAULT NULL,
  `pickedAndDrop_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_status`
--

INSERT INTO `booking_status` (`id`, `Booking_id`, `booked_status`, `carwash_status`, `lastup_bookstatus_date`, `lastup_carwashstatus_date`, `pickedAndDrop_status`) VALUES
(63, '359612-10', '', 1, NULL, NULL, NULL),
(64, '419074-10', 'Accepted', 1, '2022-03-30', NULL, 'Please drop your car'),
(65, '961412-10', '', 1, NULL, NULL, NULL),
(66, '214045-10', '', 1, NULL, NULL, NULL),
(67, '382056-10', '', 1, NULL, NULL, NULL),
(68, '815424-10', '', 1, NULL, NULL, NULL),
(69, '211995-10', '', 1, NULL, NULL, NULL),
(70, '469573-10', '', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand_name`) VALUES
(1, 'Toyota'),
(2, 'Datsun'),
(3, 'Honda'),
(4, 'Maruthi');

-- --------------------------------------------------------

--
-- Table structure for table `car_type`
--

CREATE TABLE `car_type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_type`
--

INSERT INTO `car_type` (`id`, `type_name`) VALUES
(1, 'SUV'),
(2, 'HatchBack'),
(3, 'Sedan');

-- --------------------------------------------------------

--
-- Table structure for table `city_list`
--

CREATE TABLE `city_list` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `city_list`
--

INSERT INTO `city_list` (`city_id`, `city_name`) VALUES
(1, 'Chennai'),
(2, 'Bangalore'),
(3, 'Arakkonam'),
(4, 'Chengalpattu'),
(5, 'Coimbatore'),
(6, 'Kanchipuram'),
(7, 'Tiruvallur'),
(8, 'Viluppuram'),
(12, 'Madurai'),
(13, 'Maduranthakam'),
(14, 'Cuddalore'),
(15, 'Puducherry'),
(24, 'ranipet'),
(25, 'namakkal');

-- --------------------------------------------------------

--
-- Table structure for table `combo_offers`
--

CREATE TABLE `combo_offers` (
  `offer_id` int(20) NOT NULL,
  `services` varchar(45) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `shop_id` int(10) NOT NULL,
  `combo_price` decimal(10,0) NOT NULL,
  `offer_percent` decimal(10,0) NOT NULL,
  `model_id` int(10) NOT NULL,
  `original_amount` varchar(10) NOT NULL,
  `lastupddt` date NOT NULL,
  `offer_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `combo_offers`
--

INSERT INTO `combo_offers` (`offer_id`, `services`, `start_date`, `end_date`, `shop_id`, `combo_price`, `offer_percent`, `model_id`, `original_amount`, `lastupddt`, `offer_name`) VALUES
(35, '1,2', '2022-03-16', '2022-04-02', 10, '1170', '10', 1, '1300', '2022-03-16', 'Basic'),
(36, '2,1', '2022-04-04', '2022-04-16', 10, '285', '5', 1, '300', '2022-03-16', 'Classic'),
(38, '3,1', '2022-04-17', '2022-04-19', 15, '270', '10', 1, '300', '2022-03-17', 'super'),
(39, '3,2', '2022-03-17', '2022-03-17', 15, '540', '10', 1, '600', '2022-03-17', 'Basic'),
(40, '3,2', '2022-03-17', '2022-03-17', 15, '480', '20', 1, '600', '2022-03-17', 'Delux'),
(41, '2,1', '2022-04-17', '2022-04-17', 10, '1105', '15', 1, '1300', '2022-03-17', 'super1'),
(42, '1,2', '2022-03-17', '2022-04-27', 10, '1040', '20', 1, '1300', '2022-03-17', 'Supreme'),
(43, '2,1', '2022-03-17', '2022-03-17', 10, '975', '25', 1, '1300', '2022-03-17', 'super2'),
(44, '1', '2022-03-17', '2022-03-17', 15, '88', '12', 2, '100', '2022-03-17', 'super5'),
(45, '1,2', '2022-03-18', '2022-03-27', 10, '1170', '10', 1, '1300', '2022-03-18', 'Basic'),
(46, '1,2', '2022-03-18', '2022-03-31', 10, '638', '15', 2, '750', '2022-03-18', 'Supreme'),
(48, '2,6', '2022-03-18', '2022-03-18', 11, '639', '20', 1, '799', '2022-03-18', 'Basic'),
(49, '1,2', '2022-03-18', '2022-03-25', 11, '678', '15', 2, '798', '2022-03-18', 'Super'),
(50, '1,2', '2022-03-01', '2022-03-31', 13, '285', '5', 1, '300', '2022-03-18', 'Basic'),
(51, '1,2', '2022-03-18', '2022-03-20', 15, '450', '10', 3, '500', '2022-03-21', 'Basic'),
(52, '2,3', '2022-03-21', '2022-03-31', 15, '498', '17', 3, '600', '2022-03-21', 'Basic'),
(53, '1,2', '2022-03-21', '2022-03-21', 15, '230', '8', 2, '250', '2022-03-21', 'Classic'),
(54, '1,2', '2022-03-21', '2022-03-21', 15, '445', '11', 1, '500', '2022-03-21', 'Supreme'),
(55, '3,1', '2022-03-21', '2022-03-21', 15, '285', '5', 1, '300', '2022-03-21', 'Delux'),
(56, '2,1', '2022-03-22', '2022-03-22', 14, '569', '5', 1, '599', '2022-03-22', 'Basic'),
(57, '3,1', '2022-03-22', '2022-03-22', 14, '643', '8', 1, '699', '2022-03-22', 'Basic'),
(58, '2,6', '2022-03-22', '2022-03-22', 13, '539', '10', 2, '599', '2022-03-22', 'Basic'),
(59, '1,2', '2022-03-23', '2022-03-23', 15, '225', '10', 2, '250', '2022-03-23', 'Basic'),
(60, '7,1', '2022-03-23', '2022-03-23', 15, '176', '12', 2, '200', '2022-03-23', 'Classic'),
(61, '1,2', '2022-03-25', '2022-03-25', 10, '660', '12', 2, '750', '2022-03-25', 'Basic'),
(62, '1,2', '2022-03-25', '2022-03-25', 10, '1170', '10', 1, '1300', '2022-03-25', 'Basic'),
(63, '2,1', '2022-03-29', '2022-03-31', 10, '675', '10', 2, '750', '2022-03-29', 'Basic');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `contact_id` int(10) NOT NULL,
  `name` varchar(45) NOT NULL,
  `emailid` varchar(10) NOT NULL,
  `mobileno` varchar(10) NOT NULL,
  `message` varchar(100) NOT NULL,
  `lastupddt` date NOT NULL,
  `user_role` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`contact_id`, `name`, `emailid`, `mobileno`, `message`, `lastupddt`, `user_role`) VALUES
(1, 'Ganesh', 'v@g.com', '7339528000', '0', '2022-03-17', 'shopOwnerSes'),
(3, 'kkk', 'k@g.com', '7339528035', 'testing', '2022-03-17', 'shopOwnerSes'),
(4, 'kkk', 'test@g.com', '7339528035', 'test march', '2022-03-24', 'shopOwnerSes');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(10) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `dob` date DEFAULT NULL,
  `mobileno` varchar(13) NOT NULL,
  `emailid` varchar(45) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `cartype` int(2) DEFAULT NULL,
  `brand` int(2) DEFAULT NULL,
  `model` int(2) DEFAULT NULL,
  `fueltype` varchar(10) NOT NULL,
  `color` varchar(25) NOT NULL,
  `doorno` varchar(25) NOT NULL,
  `street` varchar(100) NOT NULL,
  `city` int(3) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `zipcode` int(6) DEFAULT NULL,
  `profile_img` varchar(200) NOT NULL,
  `lastupddt` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `firstname`, `lastname`, `dob`, `mobileno`, `emailid`, `gender`, `cartype`, `brand`, `model`, `fueltype`, `color`, `doorno`, `street`, `city`, `state`, `zipcode`, `profile_img`, `lastupddt`) VALUES
(47, 'vj', 'sankar', '2022-03-05', '7339528035', 'vj@g.com', 'Male', NULL, NULL, NULL, '', '', '11', 'south st', 1, '1', 600089, 'docs/1926234583d59240-231910-users-vector-icon-png260862users-vector-icon-png260862users-vector-icon-png260862jpg.jpg', '2022-03-18'),
(48, 'Vijaya sankar', '', NULL, '9489840339', 'k@g.com', '', NULL, NULL, NULL, '', '', '', '', 3, NULL, NULL, '', '2022-03-16'),
(49, 'balu', 'b', NULL, '9043851560', 'b@g.com', '', NULL, NULL, NULL, '', '', '11', 'west st', 1, '1', 322245, '', '2022-03-25'),
(50, 'raja', 'r', NULL, '9940918725', 'r@g.com', '', NULL, NULL, NULL, '', '', '11', 'west st', 1, '1', 322332, '', '2022-03-25'),
(51, 'kesavan', 's', NULL, '7094540420', 'k@g.com', '', NULL, NULL, NULL, '', '', '67', 'raman street', 1, '1', 223456, '', '2022-03-25'),
(52, 'manimaran', 'm', NULL, '7339500000', 'm@g.com', '', NULL, NULL, NULL, '', '', '98', 'north st', 1, '1', 900067, '', '2022-03-25'),
(53, 'ganesh', 'g', NULL, '7339501234', 'g@g.com', '', NULL, NULL, NULL, '', '', '98', 'murugan street', 1, '1', 121234, '', '2022-03-25'),
(54, 'krish', '', NULL, '7339509098', 'k@g.com', '', NULL, NULL, NULL, '', '', '', '', NULL, NULL, NULL, '', '2022-03-25 11:40:54'),
(55, 'ram', 'r', NULL, '7339544444', 'r@g.com', '', NULL, NULL, NULL, '', '', '33', 'raja street', 4, '1', 878890, '', '2022-03-25'),
(56, 'guhan', 'g', NULL, '7339534434', 'g@g.com', '', NULL, NULL, NULL, '', '', '33', 'west st', 1, '1', 900087, '', '2022-03-25'),
(57, 'kumar', 'k', NULL, '7339510203', 'k@g.com', '', NULL, NULL, NULL, '', '', '23', 'north street', 1, '1', 989980, '', '2022-03-25');

-- --------------------------------------------------------

--
-- Table structure for table `customer_carinfo`
--

CREATE TABLE `customer_carinfo` (
  `carinfo_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `cartype` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `model` int(10) NOT NULL,
  `fueltype` varchar(10) NOT NULL,
  `color` varchar(25) NOT NULL,
  `vehicle_number` varchar(20) NOT NULL,
  `carinfo_status` int(5) NOT NULL,
  `lastupddt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_carinfo`
--

INSERT INTO `customer_carinfo` (`carinfo_id`, `customer_id`, `cartype`, `brand`, `model`, `fueltype`, `color`, `vehicle_number`, `carinfo_status`, `lastupddt`) VALUES
(37, 47, 1, 1, 1, 'petrol', 'red', 'Tn 899876', 0, '2022-03-22'),
(39, 48, 1, 1, 2, 'diesel', 'red', 'Tn 009872', 1, '2022-03-22'),
(40, 49, 1, 1, 2, 'diesel', 'black', 'TN 69 090987', 1, '2022-03-25'),
(41, 50, 2, 1, 1, 'diesel', 'black', 'TN 69 343467', 1, '2022-03-25'),
(43, 50, 2, 2, 4, 'petrol', 'red', 'TN 69 771133', 1, '2022-03-25'),
(44, 51, 1, 1, 2, 'diesel', 'red', 'TN 69 900912', 1, '2022-03-25'),
(45, 52, 2, 1, 1, 'diesel', 'yellow', 'TN 090987', 1, '2022-03-25'),
(46, 53, 1, 1, 2, 'petrol', 'yellow', 'TN 69 656565', 1, '2022-03-25'),
(47, 55, 1, 1, 2, 'petrol', 'black', 'TN 90 545432', 1, '2022-03-25'),
(48, 56, 2, 1, 1, 'diesel', 'black', 'TN  899867', 1, '2022-03-25'),
(49, 57, 1, 1, 2, 'petrol', 'yellow', 'TN 69 987612', 1, '2022-03-25'),
(50, 47, 3, 1, 3, 'diesel', 'red', 'TN 69 989823', 0, '2022-03-28'),
(52, 47, 1, 1, 2, 'diesel', 'yellow', 'TN 907834', 1, '2022-03-30'),
(53, 47, 2, 2, 4, 'diesel', 'black', 'Tn 988998', 1, '2022-03-30'),
(54, 47, 1, 1, 2, 'diesel', 'yellow', 'TN 988111', 1, '2022-03-30'),
(55, 51, 1, 1, 2, 'diesel', 'black', 'TN 69 989845', 0, '2022-03-30'),
(56, 56, 1, 1, 2, 'petrol', 'black', 'TN 69 987654', 1, '2022-03-30'),
(57, 47, 2, 1, 1, 'petrol', 'yellow', 'Tn 69 12089', 1, '2022-03-30');

-- --------------------------------------------------------

--
-- Table structure for table `customer_whislist`
--

CREATE TABLE `customer_whislist` (
  `Customer_id` int(10) NOT NULL,
  `whislist` varchar(15) NOT NULL,
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `lastupddt` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_whislist`
--

INSERT INTO `customer_whislist` (`Customer_id`, `whislist`, `id`, `city_id`, `lastupddt`) VALUES
(48, '10', 119, 3, '2022-03-16');

-- --------------------------------------------------------

--
-- Table structure for table `master_carwash_status`
--

CREATE TABLE `master_carwash_status` (
  `id` int(10) NOT NULL,
  `carwash_status_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_carwash_status`
--

INSERT INTO `master_carwash_status` (`id`, `carwash_status_name`) VALUES
(1, '-'),
(2, 'In Progress'),
(3, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `master_pickdrop_status`
--

CREATE TABLE `master_pickdrop_status` (
  `id` int(10) NOT NULL,
  `status_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_pickdrop_status`
--

INSERT INTO `master_pickdrop_status` (`id`, `status_name`) VALUES
(1, 'Today, please drop your car'),
(2, 'Today, Our employee will pick your car at your door step');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `brand_id` int(3) NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `car_type_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `brand_id`, `model_name`, `car_type_id`) VALUES
(1, 1, 'Toyota Glanza', 2),
(2, 1, 'Toyota Fortuner', 1),
(3, 1, 'Toyota Camry', 3),
(4, 2, 'Datsun redi-GO', 2),
(5, 2, 'Datsun Go Plus', 1),
(6, 2, 'Datsun Go', 3),
(7, 3, 'Honda WR-V', 1),
(8, 3, 'Honda City', 3),
(9, 4, 'Maruti Baleno', 2),
(10, 4, 'edan-Maruti Dzire', 2),
(11, 4, 'Vitara Brezza', 2);

-- --------------------------------------------------------

--
-- Table structure for table `onlinebooking`
--

CREATE TABLE `onlinebooking` (
  `id` int(11) NOT NULL,
  `Booking_id` varchar(25) NOT NULL,
  `Customer_id` int(10) NOT NULL,
  `Shop_id` int(10) NOT NULL,
  `combo_id` varchar(10) DEFAULT NULL,
  `comboprice_total` decimal(10,0) DEFAULT NULL,
  `services` varchar(20) DEFAULT NULL,
  `serviceprice_total` decimal(10,0) DEFAULT NULL,
  `payable_amt` decimal(10,0) NOT NULL,
  `lastupddt` date DEFAULT NULL,
  `status` varchar(25) NOT NULL,
  `model_id` int(5) NOT NULL,
  `instructions` varchar(300) DEFAULT NULL,
  `vehicle_number` varchar(20) NOT NULL,
  `pickup_drop` varchar(10) NOT NULL,
  `bookingdate` date DEFAULT NULL,
  `pickup_date` date DEFAULT NULL,
  `pickup_time` varchar(20) DEFAULT NULL,
  `drop_date` date DEFAULT NULL,
  `drop_time` varchar(20) DEFAULT NULL,
  `payment_type` varchar(45) NOT NULL,
  `last_upd_by` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `onlinebooking`
--

INSERT INTO `onlinebooking` (`id`, `Booking_id`, `Customer_id`, `Shop_id`, `combo_id`, `comboprice_total`, `services`, `serviceprice_total`, `payable_amt`, `lastupddt`, `status`, `model_id`, `instructions`, `vehicle_number`, `pickup_drop`, `bookingdate`, `pickup_date`, `pickup_time`, `drop_date`, `drop_time`, `payment_type`, `last_upd_by`) VALUES
(100, '359612-10', 47, 10, NULL, NULL, '1', '300', '300', '2022-03-30', '', 0, 'please pick my car', 'TN 907834', '1', '2022-03-30', '2022-03-31', '10:00 am', '0000-00-00', '', 'Cash On Delivery', 'CustomerSes'),
(101, '419074-10', 47, 10, '46', '638', NULL, NULL, '638', '2022-03-30', '', 0, '', 'TN 907834', '0', '2022-03-30', '0000-00-00', '', '0000-00-00', '', 'Cash On Delivery', 'CustomerSes'),
(102, '961412-10', 51, 10, '46', '638', NULL, NULL, '638', '2022-03-30', '', 0, 'pick my car', 'TN 69 900912', '1', '2022-03-30', '2022-03-31', '10:00 am', '0000-00-00', '', 'Cash On Delivery', 'CustomerSes'),
(103, '214045-10', 56, 10, '42', '1040', '', '0', '1040', '2022-03-30', '', 0, NULL, 'TN  899867', '0', '2022-03-30', NULL, NULL, NULL, NULL, 'Cash On Delivery', 'CustomerSes'),
(104, '382056-10', 56, 10, '63', '675', NULL, NULL, '675', '2022-03-30', '', 0, NULL, 'TN 69 987654', '0', '2022-03-30', NULL, NULL, NULL, NULL, 'Cash On Delivery', 'CustomerSes'),
(105, '815424-10', 47, 10, '46', '638', NULL, NULL, '638', '2022-03-30', '', 0, NULL, 'TN 988111', '0', '2022-03-30', NULL, NULL, NULL, NULL, 'Cash On Delivery', 'CustomerSes'),
(106, '211995-10', 47, 10, '35', '1170', NULL, NULL, '1170', '2022-03-30', '', 0, NULL, 'Tn 69 12089', '0', '2022-03-30', NULL, NULL, NULL, NULL, 'Cash On Delivery', 'CustomerSes'),
(107, '469573-10', 47, 10, '42', '1040', NULL, NULL, '1040', '2022-03-30', '', 0, NULL, 'Tn 69 12089', '0', '2022-03-30', NULL, NULL, NULL, NULL, 'Cash On Delivery', 'CustomerSes');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(3) NOT NULL,
  `search_id` varchar(11) NOT NULL,
  `service_name` varchar(250) NOT NULL,
  `lastupddt` date DEFAULT NULL,
  `lastupdby` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `search_id`, `service_name`, `lastupddt`, `lastupdby`) VALUES
(1, 'S1', 'Inspecting & Changing Engine Oil.', '2022-03-17', 11),
(2, 'S2', 'Inspecting & Changing Air Filter.', '2022-03-17', 11),
(3, 'S3', 'Inspecting & Changing A/C Belt', '2022-03-17', 11),
(4, 'S4', 'Inspecting & Changing Spark Plugs', '2022-03-17', 11),
(5, 'S5', 'Inspecting & Changing Fuel Filter', '2022-03-17', 11),
(6, 'S6', 'Radiator Flushing/Cleaning', '2022-03-17', 11),
(7, 'S7', 'Suspension Check.', '2022-03-17', 11),
(8, 'S8', 'Inspecting & Changing Power Steering Oil', '2022-03-17', 11),
(9, 'S9', 'Axel/Drive Shaft Check', '2022-03-17', 11),
(10, 'S10', 'Clutch Adjustment.', '2022-03-17', 11),
(11, 'S11', 'Inspecting & Changing Oil Filter.', '2022-03-17', 11),
(12, 'S12', 'Interior Car Wash', '2022-03-17', 11),
(13, 'S13', 'Exterior Car Wash', '2022-03-17', 11),
(14, 'S14', 'Interior and Exterior Car wash', '2022-03-17', 11),
(15, 'S15', 'Inspecting & Changing Roof Light', '2022-03-18', 10),
(16, 'S16', 'test march25', '2022-03-25', 10),
(17, 'S17', 'test mar 26', '2022-03-25', 10);

-- --------------------------------------------------------

--
-- Table structure for table `shopinfo`
--

CREATE TABLE `shopinfo` (
  `shop_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `mobileno` varchar(15) NOT NULL,
  `emailid` varchar(45) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date DEFAULT NULL,
  `aadharno` varchar(15) DEFAULT NULL,
  `doorno` varchar(10) NOT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(15) DEFAULT NULL,
  `state` varchar(25) DEFAULT NULL,
  `zipcode` int(6) DEFAULT NULL,
  `shop_image` varchar(100) NOT NULL,
  `status` varchar(1) NOT NULL,
  `lastupddt` date NOT NULL,
  `shop_pic` varchar(100) NOT NULL,
  `shop_logo` varchar(100) NOT NULL,
  `shop_timing_from` varchar(10) NOT NULL,
  `shop_timing_to` varchar(10) NOT NULL,
  `leave_from_date` date NOT NULL,
  `leave_to_date` date DEFAULT NULL,
  `is_pickup_drop_avl` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shopinfo`
--

INSERT INTO `shopinfo` (`shop_id`, `name`, `firstname`, `lastname`, `mobileno`, `emailid`, `gender`, `dob`, `aadharno`, `doorno`, `street`, `city`, `state`, `zipcode`, `shop_image`, `status`, `lastupddt`, `shop_pic`, `shop_logo`, `shop_timing_from`, `shop_timing_to`, `leave_from_date`, `leave_to_date`, `is_pickup_drop_avl`) VALUES
(10, '4g Waterless Car Wash', 'kkk', '', '7339528035', 'k@g.com', '', NULL, NULL, '', '', '1', NULL, NULL, 'docs/1826231dd14bc4c3-362265-imagesjpg.jpg', '1', '0000-00-00', '', 'docs/1316231d8064e75e-941964-360F411200316B3Ed9tKuqUca8juyXY1hRp0rfKI4iFOkjpg.jpg', '', '', '0000-00-00', NULL, '1'),
(11, 'Happy Car Wash', 'xyz', '', '9489840339', 'xyz@g.com', '', NULL, NULL, '', '', '1', NULL, NULL, 'docs/1026231dec1b54bd-777812-t-55-1-home-box-shop-dcc7jpg.jpg', '1', '0000-00-00', '', 'docs/656231de55b7cf9-956099-istockphoto-1090457308-612x612jpg.jpg', '', '', '0000-00-00', NULL, '0'),
(12, 'Speed car wash', 'ramesh', '', '9994616327', 'r@g.com', '', NULL, NULL, '', '', '1', NULL, NULL, 'docs/206232bfd812f1b-672559-images1jpg.jpg', '1', '0000-00-00', '', 'docs/1576232bf65c7aaf-936593-attachment109365425jpg.jpg', '', '', '0000-00-00', NULL, ''),
(13, 'SS Water Service Centre', 'jegan', '', '7339528033', 'j@g.com', '', NULL, NULL, '', '', '3', NULL, NULL, 'docs/726232c1b73c312-464809-images2jpg.jpg', '1', '0000-00-00', '', 'docs/506232c09cdf77f-784922-previewjpg.jpg', '', '', '0000-00-00', NULL, '1'),
(14, 'Shanmitha Water Wash', 'guhan', '', '7339528034', 'guhan@g.com', '', NULL, NULL, '', '', '1', NULL, NULL, 'docs/1806232c3750aab0-10137-images3jpg.jpg', '1', '0000-00-00', '', 'docs/186232c3974c4eb-309687-52-523749car-wash-logo-png-transparent-pngpng.png', '', '', '0000-00-00', NULL, '1'),
(15, 'Dakshna water service', 'Ganesh', 'k', '7339528000', 'ganesh@g.com', 'Male', '2022-03-03', '9000 1245 5678', '56', 'Dr Thomas Rd, JJ Nagar, T. Nagar, Chennai, Tamil Nadu 600017', '3', '1', 600089, 'docs/138623470ad5ebd4-445751-djpg.jpg', '1', '2022-03-17', '', 'docs/83623470dd46231-699015-d1jpg.jpg', '10:00', '18:00', '0000-00-00', NULL, '1'),
(16, '', 'lll', '', '9043851560', 'l@g.com', '', NULL, NULL, '', '', NULL, NULL, NULL, '', '1', '2022-03-24', '', '', '', '', '0000-00-00', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `shop_holidays`
--

CREATE TABLE `shop_holidays` (
  `id` int(10) NOT NULL,
  `shop_id` int(10) NOT NULL,
  `leave_date` date NOT NULL,
  `leave_timing_from` varchar(10) NOT NULL,
  `leave_timing_to` varchar(10) NOT NULL,
  `lastupddt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shop_holidays`
--

INSERT INTO `shop_holidays` (`id`, `shop_id`, `leave_date`, `leave_timing_from`, `leave_timing_to`, `lastupddt`) VALUES
(90, 15, '2022-03-01', '10:00', '18:00', '2022-03-17'),
(91, 15, '2022-03-28', '12:00', '18:00', '2022-03-17'),
(92, 15, '2022-03-15', '10:00', '18:00', '2022-03-17'),
(98, 10, '2022-03-10', '09:00', '10:00', '0000-00-00'),
(99, 10, '2022-03-24', '09:00', '10:00', '0000-00-00'),
(101, 10, '2022-03-05', '09:00', '11:00', '2022-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `shop_service`
--

CREATE TABLE `shop_service` (
  `id` int(10) NOT NULL,
  `service_id` int(10) NOT NULL,
  `shop_id` int(10) NOT NULL,
  `actual_amount` varchar(10) NOT NULL,
  `offer_percent` decimal(10,0) NOT NULL,
  `offer_price` int(10) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `lastupddt` date NOT NULL,
  `model_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shop_service`
--

INSERT INTO `shop_service` (`id`, `service_id`, `shop_id`, `actual_amount`, `offer_percent`, `offer_price`, `from_date`, `to_date`, `status`, `lastupddt`, `model_id`) VALUES
(35, 1, 10, '1000', '15', 850, '2022-03-24', '2022-03-31', '1', '2022-03-25', 1),
(36, 2, 10, '300', '12', 264, '2022-03-30', '2022-04-28', '1', '2022-03-30', 1),
(37, 1, 12, '800', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-17', 1),
(38, 1, 15, '100', '0', 0, '2022-03-01', '2022-03-03', '1', '2022-03-17', 1),
(39, 2, 15, '400', '12', 352, '2022-03-17', '2022-03-17', '1', '2022-03-18', 1),
(40, 3, 15, '200', '10', 180, '2022-03-28', '2022-03-31', '1', '2022-03-28', 1),
(41, 1, 15, '100', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-17', 2),
(42, 2, 15, '150', '10', 135, '2022-03-18', '2022-03-25', '1', '2022-03-18', 2),
(43, 1, 10, '300', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-24', 2),
(44, 9, 10, '900', '11', 801, '2022-03-29', '2022-04-22', '1', '2022-03-30', 3),
(45, 2, 10, '450', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-24', 2),
(51, 7, 10, '100', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-24', 1),
(52, 1, 10, '900', '10', 810, '2022-03-24', '2022-03-25', '1', '2022-03-24', 3),
(53, 1, 10, '800', '10', 720, '2022-03-30', '2022-04-07', '1', '2022-03-30', 7),
(54, 10, 10, '599', '10', 539, '2022-02-28', '2022-03-27', '1', '2022-03-24', 4),
(55, 1, 10, '299', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-24', 4),
(56, 1, 11, '100', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-18', 10),
(57, 1, 11, '399', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-18', 9),
(58, 2, 11, '499', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-18', 1),
(59, 2, 11, '199', '15', 169, '2022-03-18', '2022-04-22', '1', '2022-03-18', 2),
(60, 1, 11, '599', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-18', 2),
(61, 6, 11, '300', '20', 240, '2022-03-17', '2022-03-31', '1', '2022-03-18', 1),
(62, 1, 13, '100', '1', 99, '2022-03-02', '2022-03-31', '1', '2022-03-22', 1),
(63, 2, 13, '200', '5', 190, '2022-03-18', '2022-03-26', '1', '2022-03-18', 2),
(64, 3, 13, '499', '10', 449, '2022-03-18', '2022-03-21', '1', '2022-03-18', 1),
(65, 6, 13, '399', '15', 339, '2022-03-18', '2022-03-20', '1', '2022-03-18', 2),
(66, 1, 13, '200', '7', 186, '2022-03-18', '2022-03-19', '1', '2022-03-18', 3),
(67, 1, 14, '100', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-22', 1),
(68, 1, 14, '300', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-22', 2),
(69, 3, 14, '399', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-22', 2),
(70, 2, 14, '499', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-22', 1),
(71, 3, 13, '249', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-22', 4),
(72, 7, 15, '100', '0', 0, '0000-00-00', '0000-00-00', '1', '2022-03-23', 2);

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `state_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`state_id`, `name`) VALUES
(1, 'TamilNadu'),
(2, 'Karnataka');

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `id` int(10) NOT NULL,
  `user_profile` varchar(100) NOT NULL,
  `user_title` varchar(100) NOT NULL,
  `user_description` varchar(250) NOT NULL,
  `user_rating` varchar(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `review_count` varchar(10) NOT NULL,
  `review_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`id`, `user_profile`, `user_title`, `user_description`, `user_rating`, `customer_id`, `review_count`, `review_date`) VALUES
(130, '', '', 'good app', '3', 47, '1', '2022-03-25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_status`
--
ALTER TABLE `booking_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_type`
--
ALTER TABLE `car_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_list`
--
ALTER TABLE `city_list`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `combo_offers`
--
ALTER TABLE `combo_offers`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_carinfo`
--
ALTER TABLE `customer_carinfo`
  ADD PRIMARY KEY (`carinfo_id`);

--
-- Indexes for table `customer_whislist`
--
ALTER TABLE `customer_whislist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_carwash_status`
--
ALTER TABLE `master_carwash_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_pickdrop_status`
--
ALTER TABLE `master_pickdrop_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `onlinebooking`
--
ALTER TABLE `onlinebooking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `shopinfo`
--
ALTER TABLE `shopinfo`
  ADD PRIMARY KEY (`shop_id`);

--
-- Indexes for table `shop_holidays`
--
ALTER TABLE `shop_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_service`
--
ALTER TABLE `shop_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_status`
--
ALTER TABLE `booking_status`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `car_type`
--
ALTER TABLE `car_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `city_list`
--
ALTER TABLE `city_list`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `combo_offers`
--
ALTER TABLE `combo_offers`
  MODIFY `offer_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `contact_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `customer_carinfo`
--
ALTER TABLE `customer_carinfo`
  MODIFY `carinfo_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `customer_whislist`
--
ALTER TABLE `customer_whislist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `master_carwash_status`
--
ALTER TABLE `master_carwash_status`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `master_pickdrop_status`
--
ALTER TABLE `master_pickdrop_status`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `onlinebooking`
--
ALTER TABLE `onlinebooking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `shopinfo`
--
ALTER TABLE `shopinfo`
  MODIFY `shop_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `shop_holidays`
--
ALTER TABLE `shop_holidays`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `shop_service`
--
ALTER TABLE `shop_service`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
