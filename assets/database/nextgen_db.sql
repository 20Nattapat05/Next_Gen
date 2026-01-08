-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2026 at 03:00 PM
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
(9, 'Event1', 12, '2026-01-08 00:05:27', '2026-01-08 00:05:27');

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
(8, 'ประเภทที่ 1', '2026-01-08 20:38:36', '2026-01-08 20:38:36');

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
(1, 'user1', '$2y$10$KoRKCM1a.ETV2au0W8GZvO1XYx3KhzwXOdkgdk/ogkOsYaK2zd9/m', 'สมชาย ใจดี', 'name@gmail.com', '0252525252', 'active', NULL, '2025-12-27 22:25:49', '2025-12-27 22:25:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tb`
--
ALTER TABLE `admin_tb`
  ADD PRIMARY KEY (`admin_id`);

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
-- AUTO_INCREMENT for table `event_tb`
--
ALTER TABLE `event_tb`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_tb`
--
ALTER TABLE `product_tb`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_type_tb`
--
ALTER TABLE `product_type_tb`
  MODIFY `product_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
