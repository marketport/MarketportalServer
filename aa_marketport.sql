-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2016 at 10:55 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aa_marketport`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_info`
--

CREATE TABLE `category_info` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `order_cat` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0-false,1-ture'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_info`
--

INSERT INTO `category_info` (`id`, `shop_id`, `category_name`, `short_description`, `image`, `order_cat`, `status`) VALUES
(1, 1, 'Clothing', 'clothing', '', 1, 1),
(2, 1, 'Food', 'Food', '', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_info`
--

CREATE TABLE `product_info` (
  `product_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1-active,0-inactive',
  `shop_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_picture_path` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `price_per_qty` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `minimum_unit` int(11) NOT NULL,
  `offer_date_start` datetime NOT NULL,
  `offer_date_end` datetime NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `session_info`
--

CREATE TABLE `session_info` (
  `session_id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `session_count` int(11) NOT NULL,
  `session_cookies` text NOT NULL,
  `device_token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shop_details`
--

CREATE TABLE `shop_details` (
  `shop_id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_logo_path` varchar(255) NOT NULL,
  `shop_contact_no` varchar(255) NOT NULL,
  `shop_street` varchar(255) NOT NULL,
  `shop_area` varchar(255) NOT NULL,
  `shop_city` varchar(255) NOT NULL,
  `shop_state` varchar(255) NOT NULL,
  `shop_country` varchar(255) NOT NULL,
  `shop_postcode` varchar(255) NOT NULL,
  `location_lat` decimal(10,2) NOT NULL,
  `location_long` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_details`
--

INSERT INTO `shop_details` (`shop_id`, `shop_name`, `user_id`, `shop_logo_path`, `shop_contact_no`, `shop_street`, `shop_area`, `shop_city`, `shop_state`, `shop_country`, `shop_postcode`, `location_lat`, `location_long`) VALUES
(1, 'mageshwaran coconut shop', 1, '', '9809417754', '163,R.H.Road,', 'mylapore', 'chennai', 'tamil nadu', 'india', '600004', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `users_basic_info`
--

CREATE TABLE `users_basic_info` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `verified_code` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `device_token` varchar(250) NOT NULL DEFAULT '0',
  `image` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_basic_info`
--

INSERT INTO `users_basic_info` (`id`, `name`, `mobile`, `email`, `verified_code`, `password`, `device_token`, `image`, `address`, `area`, `city`, `pincode`, `status`, `created_at`) VALUES
(43, 'Sathees2', '9840528485', 'othiyaa9478@gmail.com', '3103', 'sample', 'aabbccdd', NULL, '', '', '', '', 0, '2016-07-29 08:35:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_info`
--
ALTER TABLE `category_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_info`
--
ALTER TABLE `product_info`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `session_info`
--
ALTER TABLE `session_info`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `shop_details`
--
ALTER TABLE `shop_details`
  ADD PRIMARY KEY (`shop_id`);

--
-- Indexes for table `users_basic_info`
--
ALTER TABLE `users_basic_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_info`
--
ALTER TABLE `category_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `product_info`
--
ALTER TABLE `product_info`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `session_info`
--
ALTER TABLE `session_info`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shop_details`
--
ALTER TABLE `shop_details`
  MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users_basic_info`
--
ALTER TABLE `users_basic_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
