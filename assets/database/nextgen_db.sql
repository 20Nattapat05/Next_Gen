-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2026 at 07:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nextgen_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tb`
--

CREATE TABLE `admin_tb` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(70) NOT NULL,
  `admin_password` varchar(70) NOT NULL,
  `admin_email` varchar(70) NOT NULL,
  `admin_fname` varchar(30) NOT NULL,
  `admin_sname` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tb`
--

INSERT INTO `admin_tb` (`admin_id`, `admin_username`, `admin_password`, `admin_email`, `admin_fname`, `admin_sname`, `created_at`, `updated_at`) VALUES
(2, 'admin', '$2y$10$ywOiDF4pOC9DSvb9hpuTruc1iC4/OkKORt3kzYwg8p9p/dCBvN6EO', 'admin@gmail.com', 'somchai', 'madman', '2025-12-21 18:56:16', '2025-12-21 18:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `content_tb`
--

CREATE TABLE `content_tb` (
  `content_id` int(11) NOT NULL,
  `content_key` varchar(50) NOT NULL,
  `content_title` varchar(255) DEFAULT NULL,
  `content_description` text DEFAULT NULL,
  `content_image` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_tb`
--

INSERT INTO `content_tb` (`content_id`, `content_key`, `content_title`, `content_description`, `content_image`, `updated_at`) VALUES
(1, 'news_1', 'ข่าวที่ 1', 'บลา ๆ ๆๆ ๆๆ', 'content_6963de1e50d7e.png', '2026-01-11 17:44:54'),
(2, 'news_2', 'ข่าวที่ 2', 'ๆไำๆำฟดฟหกดฟหกเกหฟดเหกเ', 'content_6963def0cb50d.png', '2026-01-11 17:44:58'),
(3, 'news_3', 'ข่าวที่ 3', 'ฟหกดฟหกดฟหกด', 'content_6963e175b10d6.png', '2026-01-11 17:44:42'),
(4, 'banner_1', 'banner1111', 'asdfasdfwae4fw', 'content_6963e1ee8f7a0.png', '2026-01-11 17:46:22'),
(5, 'banner_2', 'baner2222', 'qwdfdfasdf', 'content_6963e1d9b19d3.jpg', '2026-01-11 17:46:01'),
(6, 'banner_3', 'banner3333', 'dasdfasdgfasdf', 'content_6963e1bcd6cfc.jpg', '2026-01-11 17:45:32');

-- --------------------------------------------------------

--
-- Table structure for table `event_tb`
--

CREATE TABLE `event_tb` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_discount` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_tb`
--

INSERT INTO `event_tb` (`event_id`, `event_name`, `event_discount`, `created_at`, `updated_at`) VALUES
(10, 'Event1', 3, '2026-01-10 20:37:11', '2026-01-10 20:37:11');

-- --------------------------------------------------------

--
-- Table structure for table `product_tb`
--

CREATE TABLE `product_tb` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_detail` text DEFAULT NULL,
  `product_picture` text NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `product_qty` float NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_tb`
--

INSERT INTO `product_tb` (`product_id`, `product_name`, `product_type_id`, `product_price`, `product_detail`, `product_picture`, `event_id`, `product_qty`, `created_at`, `updated_at`) VALUES
(5, 'สินค้าที่ 1', 8, 1290.00, 'บลา ๆ ๆ ๆ ๆ', 'prod_69625621da4d9_1768052257.png', 10, 12, '2026-01-10 20:37:37', '2026-01-10 20:37:37'),
(6, 'สินค้าที่ 2', 8, 1000.00, 'บลา ๆ ๆ ๆ ๆ', 'prod_69626d9524948_1768058261.png', NULL, 12, '2026-01-10 22:17:41', '2026-01-10 22:17:41'),
(7, 'สินค้าที่ 3', 9, 100.00, '121212', 'prod_69627c63e9e11_1768062051.png', 10, 1, '2026-01-10 23:20:51', '2026-01-10 23:20:51');

-- --------------------------------------------------------

--
-- Table structure for table `product_type_tb`
--

CREATE TABLE `product_type_tb` (
  `product_type_id` int(11) NOT NULL,
  `product_type_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_type_tb`
--

INSERT INTO `product_type_tb` (`product_type_id`, `product_type_name`, `created_at`, `updated_at`) VALUES
(8, 'ประเภทที่ 1', '2026-01-08 20:38:36', '2026-01-08 20:38:36'),
(9, 'ประเภทที่ 2', '2026-01-10 23:20:32', '2026-01-10 23:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_tb`
--

CREATE TABLE `user_tb` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(10) NOT NULL,
  `user_status` enum('active','unactive') NOT NULL,
  `user_address_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tb`
--

INSERT INTO `user_tb` (`user_id`, `user_username`, `user_password`, `user_fullname`, `user_email`, `user_phone`, `user_status`, `user_address_id`, `created_at`, `updated_at`) VALUES
(1, 'user1', '$2y$10$KoRKCM1a.ETV2au0W8GZvO1XYx3KhzwXOdkgdk/ogkOsYaK2zd9/m', 'สมชาย ใจดี', 'name@gmail.com', '0252525252', 'active', NULL, '2025-12-27 22:25:49', '2025-12-27 22:25:49'),
(2, 'user2', '$2y$10$PU9pK5TvrhcNlQK.noeOhupbqJsR0qKsq3KqJ7.RW5lwSiftiYEjS', 'สมชาย ใจร้าย', 'name2@gmail.com', '0325132658', 'active', NULL, '2026-01-10 23:59:22', '2026-01-10 23:59:22'),
(3, 'user3', '$2y$10$o/C5ZVDkSSHviKJIxsl92eMhuD4PEKkertRL4xHowrdR5TygEVvba', 'สมชาย ใจวาย', 'name3@gmail.com', '0215458754', 'active', NULL, '2026-01-11 00:00:05', '2026-01-11 14:07:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tb`
--
ALTER TABLE `admin_tb`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `content_tb`
--
ALTER TABLE `content_tb`
  ADD PRIMARY KEY (`content_id`),
  ADD UNIQUE KEY `content_key` (`content_key`);

--
-- Indexes for table `event_tb`
--
ALTER TABLE `event_tb`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `product_tb`
--
ALTER TABLE `product_tb`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `type and product` (`product_type_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `product_type_tb`
--
ALTER TABLE `product_type_tb`
  ADD PRIMARY KEY (`product_type_id`);

--
-- Indexes for table `user_tb`
--
ALTER TABLE `user_tb`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_tb`
--
ALTER TABLE `admin_tb`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `content_tb`
--
ALTER TABLE `content_tb`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event_tb`
--
ALTER TABLE `event_tb`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_tb`
--
ALTER TABLE `product_tb`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_type_tb`
--
ALTER TABLE `product_type_tb`
  MODIFY `product_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_tb`
--
ALTER TABLE `product_tb`
  ADD CONSTRAINT `product_tb_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event_tb` (`event_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `type and product` FOREIGN KEY (`product_type_id`) REFERENCES `product_type_tb` (`product_type_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
