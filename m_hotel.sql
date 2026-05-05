-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2025 at 08:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homework_std_ro_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `sr_no` int(11) NOT NULL,
  `admin_name` varchar(150) NOT NULL,
  `admin_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(1, 'shero', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`id`, `user_id`, `balance`, `last_updated`) VALUES
(4, 26, 43600.00, '2024-08-14 10:06:38'),
(7, 29, 18450.00, '2024-08-05 14:45:32'),
(17, 39, 0.00, '2024-08-13 17:41:18'),
(19, 41, 1850.00, '2024-08-13 17:49:11'),
(20, 42, 1100.00, '2024-08-13 17:54:22'),
(21, 43, 0.00, '2025-11-08 19:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `total_pay` int(11) NOT NULL,
  `room_no` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`sr_no`, `booking_id`, `room_name`, `price`, `total_pay`, `room_no`, `user_name`, `phonenum`, `address`) VALUES
(160, 224, 'Studio Suite', 150, 150, '4', 'malek', '0939271812', '4422 Armbrester Drive'),
(161, 226, 'Studio Suite', 300, 600, '4', 'diyar', '0939271813', '4422 Armbrester Drive'),
(162, 227, 'Deluxe Room', 200, 200, '2', 'diyar', '0939271813', '4422 Armbrester Drive'),
(163, 229, 'One-Bedroom Suite', 100, 100, '11', 'diyar', '0939271813', '4422 Armbrester Drive'),
(167, 233, 'Deluxe Room', 200, 200, NULL, 'yousef', '2222', 'lattakia1'),
(168, 234, 'Delux', 200, 200, NULL, 'yousef', '2222', 'lattakia1'),
(169, 235, 'Delux', 200, 200, NULL, 'yousef', '1111', 'lattakia1'),
(170, 236, 'Bedroom', 200, 400, NULL, 'yousef', '1111', 'lattakia1');

-- --------------------------------------------------------

--
-- Table structure for table `booking_order`
--

CREATE TABLE `booking_order` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `arrival` int(11) NOT NULL DEFAULT 0,
  `refund` int(11) DEFAULT NULL,
  `booking_status` varchar(100) NOT NULL DEFAULT 'booked',
  `order_id` varchar(150) NOT NULL,
  `trans_id` int(200) DEFAULT NULL,
  `trans_status` varchar(100) NOT NULL DEFAULT 'pending',
  `trans_resp_msg` varchar(200) DEFAULT NULL,
  `rate_review` int(11) DEFAULT NULL,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_order`
--

INSERT INTO `booking_order` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `arrival`, `refund`, `booking_status`, `order_id`, `trans_id`, `trans_status`, `trans_resp_msg`, `rate_review`, `datentime`) VALUES
(220, 26, 23, '2024-08-13', '2024-08-14', 1, NULL, 'booked', 'ORD26473864', NULL, 'success', NULL, 1, '2024-08-13 20:42:41'),
(221, 26, 23, '2024-08-13', '2024-08-14', 1, NULL, 'booked', 'ORD265435786', NULL, 'success', NULL, 1, '2024-08-13 20:42:58'),
(222, 26, 24, '2024-08-13', '2024-08-14', 1, NULL, 'booked', 'ORD264673279', NULL, 'success', NULL, 1, '2024-08-13 20:43:09'),
(223, 41, 23, '2024-08-14', '2024-08-15', 0, NULL, 'peding', 'ORD41820093', NULL, 'failed', NULL, NULL, '2024-08-13 20:48:50'),
(224, 41, 23, '2024-08-14', '2024-08-15', 1, NULL, 'booked', 'ORD412533410', NULL, 'success', NULL, 1, '2024-08-13 20:49:11'),
(225, 42, 23, '2024-08-14', '2024-08-15', 0, NULL, 'peding', 'ORD426851402', NULL, 'failed', NULL, NULL, '2024-08-13 20:50:55'),
(226, 42, 23, '2024-08-13', '2024-08-15', 1, NULL, 'booked', 'ORD425854041', NULL, 'success', NULL, 1, '2024-08-13 20:51:12'),
(227, 42, 21, '2024-08-13', '2024-08-14', 1, NULL, 'booked', 'ORD427867617', NULL, 'success', NULL, 1, '2024-08-13 20:53:28'),
(228, 42, 24, '2024-08-13', '2024-08-21', 0, NULL, 'peding', 'ORD425979294', NULL, 'failed', NULL, NULL, '2024-08-13 20:54:13'),
(229, 42, 24, '2024-08-13', '2024-08-14', 1, NULL, 'booked', 'ORD424182873', NULL, 'success', NULL, 1, '2024-08-13 20:54:22'),
(230, 26, 24, '2024-08-13', '2024-08-14', 1, NULL, 'booked', 'ORD266536561', NULL, 'success', NULL, 1, '2024-08-13 21:25:13'),
(231, 26, 21, '2024-08-13', '2024-08-14', 0, 1, 'cancelled', 'ORD263574360', NULL, 'success', NULL, NULL, '2024-08-13 23:20:43'),
(232, 26, 21, '2024-08-14', '2024-08-15', 0, 1, 'cancelled', 'ORD269009337', NULL, 'success', NULL, NULL, '2024-08-14 01:18:07'),
(233, 26, 21, '2024-08-14', '2024-08-15', 0, 1, 'cancelled', 'ORD269799806', NULL, 'success', NULL, NULL, '2024-08-14 11:38:27'),
(234, 26, 33, '2024-08-14', '2024-08-15', 0, NULL, 'booked', 'ORD267198327', NULL, 'success', NULL, NULL, '2024-08-14 11:39:53'),
(235, 26, 33, '2024-08-15', '2024-08-16', 0, 0, 'cancelled', 'ORD265960130', NULL, 'success', NULL, NULL, '2024-08-14 12:05:34'),
(236, 26, 32, '2024-08-20', '2024-08-22', 0, NULL, 'booked', 'ORD261270447', NULL, 'success', NULL, NULL, '2024-08-14 13:06:38');

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `sr_no` int(11) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`sr_no`, `image`) VALUES
(13, 'IMG_19327.png'),
(17, 'IMG_57805.png');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `sr_no` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `gmap` varchar(100) NOT NULL,
  `pn1` bigint(20) NOT NULL,
  `pn2` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `insta` varchar(100) NOT NULL,
  `tw` varchar(100) NOT NULL,
  `iframe` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`sr_no`, `address`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `insta`, `tw`, `iframe`) VALUES
(1, 'ERBIL', 'https://maps.app.goo.gl/Cjk46hd6ZtnJ2N2o8', 93954367373, 93394367657, 'shyrwsthhewhgwary444@gmail.com', 'www.facebook.com', 'shero', 'shero', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d103031.92458615714!2d44.00896305!3d36.19701874210335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x400722fe13443461:0x3e01d63391de79d1!2z2KfYsdio2YrZhCwgS3VyZGlzdGFuIFJlZ2lvbtiMINin2YTYudix2KfZgg!5e0!3m2!1sar!2s!4v1710944568233!5m2!1sar!2');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `icon`, `name`, `description`) VALUES
(22, 'IMG_15151.svg', 'spa', ''),
(24, 'IMG_45307.svg', 'Air conditioner', ''),
(28, 'IMG_88546.svg', 'Fitness Center', ''),
(29, 'IMG_89768.svg', 'Meeting and Event Spaces', ''),
(31, 'IMG_54631.svg', 'Complimentary Breakfast', ''),
(32, 'IMG_18593.svg', 'Concierge Services', ''),
(33, 'IMG_45039.svg', 'High-speed Wi-Fi', ''),
(34, 'IMG_83389.svg', 'Business Center', ''),
(36, 'IMG_61046.svg', 'spa', 'dxgf');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `name`) VALUES
(45, 'Spa'),
(46, 'kitchenettes'),
(47, 'Hour Room Service'),
(48, 'Balcony'),
(49, 'Kitchen'),
(50, 'bedroom'),
(52, 'wifi'),
(54, 'gh'),
(55, 'sd');

-- --------------------------------------------------------

--
-- Table structure for table `rating_review`
--

CREATE TABLE `rating_review` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(200) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `datentime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating_review`
--

INSERT INTO `rating_review` (`sr_no`, `booking_id`, `room_id`, `user_id`, `rating`, `review`, `seen`, `datentime`) VALUES
(20, 221, 23, 26, 5, 'Amazing!', 0, '0000-00-00 00:00:00'),
(22, 224, 23, 41, 4, 'very good', 0, '0000-00-00 00:00:00'),
(23, 226, 23, 42, 1, 'bad!', 1, '0000-00-00 00:00:00'),
(24, 227, 21, 42, 5, 'Nice!', 1, '0000-00-00 00:00:00'),
(26, 230, 24, 26, 2, 'not bad!', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `area` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `description` varchar(350) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `removed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `status`, `removed`) VALUES
(2, 'shshs', 23, 2, 23, 23, 23, 'wqfwqdc', 1, 1),
(3, 'siple', 23, 23, 23, 23, 23, 'sqdfqw', 1, 1),
(4, '2323', 2323, 23, 23, 2332323, 2323, 'fqwewd', 1, 1),
(5, 'sheroooo', 322, 52, 3, 53, 353, 'djehfhefuef', 1, 1),
(6, 'www', 12, 12, 2, 12, 2, 'xscx', 1, 1),
(7, 'wwwwww', 1111, 11, 11, 11, 11, 'qwwqs', 0, 1),
(8, 'shero', 23, 2332, 23232, 2323, 2323, 'sdfdfsadsdaf', 1, 1),
(9, 'dwf', 13, 23, 23, 23, 23, 'DAF', 1, 1),
(10, 'vvvvv', 123, 23, 32, 23, 23, 'asfvqwdf', 1, 1),
(11, 'test', 2, 2, 2, 2, 2, 'asd', 1, 1),
(13, 'simple room', 22, 22, 22, 22, 22, 'qwd', 1, 1),
(14, 'shero', 35, 23, 23, 23, 23, 'sqfdqdfqwef', 1, 1),
(15, 'room2', 12, 12, 21, 12, 21, 'wwqfwf', 0, 1),
(16, 'dwf', 423, 24, 245, 45, 45, 'wqefwf', 0, 1),
(17, 'mo', 112, 1121, 12112, 12, 11, 'wefweqd', 1, 1),
(18, 'simple room', 23, 23, 23, 23, 23, 'shero agabri', 1, 1),
(19, 'simple rooms', 2132, 134, 134, 134, 134, 'sheri', 1, 1),
(20, 'weqfw', 232, 23, 23, 2323, 23, 'dsfwd', 1, 1),
(21, 'Deluxe Room', 20, 200, 10, 3, 4, 'Spacious room with modern decor, en-suite bathroom, and city/garden views.', 1, 0),
(22, 'Premium Deluxe Room', 40, 250, 3, 3, 3, 'Upgraded version of the Deluxe Room with additional living space and premium amenities', 1, 1),
(23, 'Studio Suite', 20, 150, 2, 2, 2, 'Open-plan suite with kitchenette, living area, and king-size bed.', 1, 0),
(24, 'One-Bedroom Suite', 30, 100, 3, 2, 3, 'Separate bedroom and living room, ideal for families or extended stays.', 1, 0),
(25, 'rqt', 23, 32, 32, 23, 32, 'wqrgfw', 1, 1),
(26, 'trh', 2345, 245, 25, 25, 25, 'erhtyh42u24', 1, 1),
(27, 'dd', 100, 200, 1, 2, 2, 'fgefgefgewg', 1, 1),
(28, 'del', 200, 300, 1, 6, 6, 'ur', 1, 1),
(29, 'fd', 23, 23, 2, 2, 2, 'sdf', 1, 1),
(30, 'ger', 10, 200, 2, 4, 4, 'tertg', 1, 1),
(31, 'delux', 20, 130, 1, 4, 3, 'w', 1, 1),
(32, 'Bedroom', 10, 100, 2, 2, 6, 'Separate bedroom and living room, ideal for families or extended stays.', 1, 0),
(33, 'Delux', 15, 200, 1, 3, 5, 'Separate bedroom and living room, ideal for families or extended stays.', 1, 0),
(34, 'e', 45, 34, 3, 1, 3, '3rwef', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_facilities`
--

CREATE TABLE `room_facilities` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `facilities_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_facilities`
--

INSERT INTO `room_facilities` (`sr_no`, `room_id`, `facilities_id`) VALUES
(43, 21, 22),
(44, 21, 24),
(47, 23, 24),
(48, 24, 24),
(73, 32, 24),
(74, 33, 24),
(75, 33, 28),
(76, 33, 32),
(77, 33, 33),
(78, 33, 36),
(79, 34, 24);

-- --------------------------------------------------------

--
-- Table structure for table `room_features`
--

CREATE TABLE `room_features` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `features_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_features`
--

INSERT INTO `room_features` (`sr_no`, `room_id`, `features_id`) VALUES
(18, 21, 45),
(19, 21, 46),
(20, 21, 47),
(21, 21, 49),
(25, 23, 46),
(26, 23, 48),
(27, 24, 46),
(28, 24, 49),
(29, 24, 50),
(51, 32, 45),
(52, 32, 46),
(53, 32, 49),
(54, 32, 50),
(55, 33, 47),
(56, 33, 48),
(57, 33, 52),
(58, 34, 46);

-- --------------------------------------------------------

--
-- Table structure for table `room_images`
--

CREATE TABLE `room_images` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `thumb` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_images`
--

INSERT INTO `room_images` (`sr_no`, `room_id`, `image`, `thumb`) VALUES
(22, 21, 'IMG_36840.png', 0),
(23, 21, 'IMG_44615.png', 0),
(26, 23, 'IMG_81645.png', 0),
(27, 23, 'IMG_46752.png', 1),
(28, 24, 'IMG_54129.jpg', 1),
(29, 24, 'IMG_31704.png', 0),
(38, 21, 'IMG_58588.png', 1),
(42, 33, 'IMG_94743.png', 1),
(44, 32, 'IMG_62925.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `sr_no` int(11) NOT NULL,
  `site_title` varchar(50) NOT NULL,
  `site_about` varchar(250) NOT NULL,
  `shutdown` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`sr_no`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'STAR HOTEL', 'Nestled in the heart of the vibrant city center, tyatt Regency Hotel offers a refined and sophisticated retreat for the modern traveler. Guests are greeted by a grand marble lobby adorned with sparkling chandeliers and plush furnishings, setting the', 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_detalis3`
--

CREATE TABLE `team_detalis3` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `picture` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_detalis3`
--

INSERT INTO `team_detalis3` (`sr_no`, `name`, `picture`) VALUES
(12, 'merna', 'IMG_35847.jpg'),
(13, 'narin', 'IMG_94008.webp'),
(14, 'malek', 'IMG_14806.webp'),
(15, 'diyar', 'IMG_95291.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_cred`
--

CREATE TABLE `user_cred` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(120) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `pincode` int(11) NOT NULL,
  `dob` date NOT NULL,
  `profile` int(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `token` varchar(200) DEFAULT NULL,
  `t_expire` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_cred`
--

INSERT INTO `user_cred` (`id`, `name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`, `is_verified`, `token`, `t_expire`, `status`, `datentime`) VALUES
(26, 'yousef', 'yousef12@gmail.com', 'lattakia1', '1111', 12, '2024-07-26', 0, '$2y$10$ch5F68YMXbmvTutE3v.O1./n8yfq/QTrjQWkPbuNO/M/dXj4gbvAW', 0, '1fdefc944a67beeac9c223a70426017d', NULL, 1, '2024-07-26 09:16:38'),
(29, 'sher12', 'sher12@gmail.com', 'asfas', '123123', 2, '2024-08-16', 0, '$2y$10$IhcwSw85qZWeBISjmCA0COQLFgmnerL/S7L1ob1rURtCuSd3NZHxq', 0, '8d67de72f2d3055ae81ddaae3b42ac50', NULL, 0, '2024-08-05 09:10:45'),
(39, 'shsh', 'shsh@gmail.com', 'ss', '123', 11, '2024-08-13', 0, '$2y$10$SL/RWx7aQu1F0U6L/fmETOj5fiTa59A.x.mo5ZzekiArxlFtMIude', 0, '45ac3fb946b72013ac84886928e18764', NULL, 0, '2024-08-13 20:41:18'),
(41, 'malek', 'mal@gmail.com', '4422 Armbrester Drive', '0939271812', 1, '2024-08-13', 0, '$2y$10$PlI5dQv.sFbyR/aTuk3ZvO9jqrpW5w9vHDW2Gn/nm6G39LkIkJU9G', 0, '083c40fe14e405194ab9735c98245199', NULL, 1, '2024-08-13 20:48:14'),
(42, 'diyar', 'di@gmail.com', '4422 Armbrester Drive', '0939271813', 2, '2024-08-13', 0, '$2y$10$Dew9hP/Xle4WFcErfeyG5ekdE8Tc02l.SFBTcKnoq5tXV66VvDRSO', 0, '98e769d34c4c52ab3abdd2bf592c3823', NULL, 1, '2024-08-13 20:50:27'),
(43, 'qq', 'qqq@gmail.com', 'dfdf', '9324343', 12, '2000-05-31', 0, '$2y$10$3xhvSQyoCxaGnXpeTtHUPuk6Ju929VBJsTJ5vFY.FhE8E634zQOxi', 0, 'fc100c21482f28db7fbfd891420a3803', NULL, 1, '2025-11-08 22:13:26');

--
-- Triggers `user_cred`
--
DELIMITER $$
CREATE TRIGGER `after_user_insert` AFTER INSERT ON `user_cred` FOR EACH ROW BEGIN
    INSERT INTO balances (user_id, balance) VALUES (NEW.id, 0.00);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `sr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_queries1`
--

CREATE TABLE `user_queries1` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `datentime` datetime NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_queries1`
--

INSERT INTO `user_queries1` (`sr_no`, `name`, `email`, `subject`, `message`, `datentime`, `seen`) VALUES
(62, 'shero', 'shyrwkabary444@gmail.com', 'smssms', 'yugfyu', '2024-08-14 11:41:30', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `facilities id` (`facilities_id`),
  ADD KEY `room id` (`room_id`);

--
-- Indexes for table `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `features id` (`features_id`),
  ADD KEY `rm id` (`room_id`);

--
-- Indexes for table `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `team_detalis3`
--
ALTER TABLE `team_detalis3`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `user_cred`
--
ALTER TABLE `user_cred`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_queries1`
--
ALTER TABLE `user_queries1`
  ADD PRIMARY KEY (`sr_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `booking_order`
--
ALTER TABLE `booking_order`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `rating_review`
--
ALTER TABLE `rating_review`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `room_features`
--
ALTER TABLE `room_features`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `room_images`
--
ALTER TABLE `room_images`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_detalis3`
--
ALTER TABLE `team_detalis3`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_cred`
--
ALTER TABLE `user_cred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user_queries1`
--
ALTER TABLE `user_queries1`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `balances`
--
ALTER TABLE `balances`
  ADD CONSTRAINT `balances_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD CONSTRAINT `booking_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`),
  ADD CONSTRAINT `booking_order_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD CONSTRAINT `rating_review_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`),
  ADD CONSTRAINT `rating_review_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `rating_review_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`);

--
-- Constraints for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD CONSTRAINT `facilities id` FOREIGN KEY (`facilities_id`) REFERENCES `facilities` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `room id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `room_features`
--
ALTER TABLE `room_features`
  ADD CONSTRAINT `features id` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `rm id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `room_images`
--
ALTER TABLE `room_images`
  ADD CONSTRAINT `room_images_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
