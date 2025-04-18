-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 06:00 AM
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
-- Database: `travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_date` datetime DEFAULT current_timestamp(),
  `guide` varchar(100) DEFAULT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `fname`, `password`, `email`, `city`, `phone`, `dob`, `pincode`, `state`) VALUES
(18, 'Rajiv Gandhi', '$2y$10$DOA54hEl5HqW4JpNPdinJuvPcgSEjC.Z2OFGt8Bzc9YJjcZVKt21K', 'rajivsinghrajput146@gmail.com', 'Ramgarh', '9939389500', '2004-12-30', '829134', 'Jharkhand'),
(20, 'Siddharth', '$2y$10$NsrXqrRklX4OrvnlvCLbzuZWwvESFsZkYVhlzT6HCLssYMP0P.nRi', 'sharmasiddharth7373@gmail.com', 'Bareilly', '8256315656', '2025-04-14', '243123', 'Uttar Pradesh'),
(21, 'Snehashish Mandal', '$2y$10$.8J6ns3BFdFJ/mIp.uCJR.E9Y/iA36VKNhN3/MlYfEDOBX0dIc0Ki', 'snehasishconnect@gmail.com', 'Cooch Behar', '8865478966', '2025-04-15', '736101', 'West Bengal'),
(22, 'Vaibhav Verma', '$2y$10$ywqX3DxfpYQwz6OTCbD88u7XRlkguU0iRxKdumvqjJT7V5AQKY9gu', 'vvnotofficial5678@gmail.com', 'Thane', '7889546565', '2025-04-22', '401504', 'Maharashtra'),
(25, 'Ashutosh Mohanty', '$2y$10$8ungrtl/9Y9PMdJLNyhQK.I6TaOS5GYi3wywICmelfKHMJIDq4Qbe', 'ashutoshmohanty2004@gmail.com', 'Chandauli', '9897645642', '2025-04-14', '232101', 'Uttar Pradesh'),
(32, 'Ram arora', '$2y$10$dfx6fdOfuecRMQHjxCVAveVIcC1EhsWzuESCPKuj5YGCsUyh5MOwG', 'ramarora0075@gmail.com', 'Udham Singh Nagar', '8256315656', '2005-07-31', '263148', 'Uttarakhand');

-- --------------------------------------------------------

--
-- Table structure for table `custom_tours`
--

CREATE TABLE `custom_tours` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `destination` varchar(100) NOT NULL,
  `duration` int(11) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `services` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `guide_fname` varchar(100) DEFAULT NULL,
  `trip_name` varchar(100) DEFAULT NULL,
  `trip_destination` varchar(100) DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `accommodation_rating` varchar(20) DEFAULT NULL,
  `transport_rating` varchar(20) DEFAULT NULL,
  `food_rating` varchar(20) DEFAULT NULL,
  `places_rating` varchar(20) DEFAULT NULL,
  `professionalism_rating` varchar(20) DEFAULT NULL,
  `costs_rating` varchar(20) DEFAULT NULL,
  `communication_rating` varchar(20) DEFAULT NULL,
  `safety_rating` varchar(20) DEFAULT NULL,
  `driver_rating` varchar(20) DEFAULT NULL,
  `tour_guide_rating` varchar(20) DEFAULT NULL,
  `knowledge_rating` varchar(20) DEFAULT NULL,
  `registration_rating` varchar(20) DEFAULT NULL,
  `payment_rating` varchar(20) DEFAULT NULL,
  `overall_rating` float DEFAULT NULL,
  `places_enjoyed` text DEFAULT NULL,
  `places_not_enjoyed` text DEFAULT NULL,
  `places_next` text DEFAULT NULL,
  `heard_about_us` varchar(50) DEFAULT NULL,
  `additional_feedback` text DEFAULT NULL,
  `recommend` varchar(10) DEFAULT NULL,
  `promo_emails` varchar(10) DEFAULT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `guide_fname`, `trip_name`, `trip_destination`, `departure_date`, `accommodation_rating`, `transport_rating`, `food_rating`, `places_rating`, `professionalism_rating`, `costs_rating`, `communication_rating`, `safety_rating`, `driver_rating`, `tour_guide_rating`, `knowledge_rating`, `registration_rating`, `payment_rating`, `overall_rating`, `places_enjoyed`, `places_not_enjoyed`, `places_next`, `heard_about_us`, `additional_feedback`, `recommend`, `promo_emails`, `submission_time`) VALUES
(3, 'Siddharth', 'Goa', 'delhi', '2025-03-13', 'Excellent', 'Excellent', 'Excellent', 'Not Rated', 'Excellent', 'Not Rated', 'Excellent', 'Not Rated', 'Not Rated', 'Not Rated', 'Not Rated', 'Excellent', 'Not Rated', 4, 'hello', 'hii', 'kyaa', 'Social Media', 'haal', 'No', 'Yes', '2025-03-24 08:06:21'),
(4, 'hjdsbfjsffhgg', 'dfasdfdscfhgh', 'hgjghsshfgjkil', '2025-03-19', 'Satisfactory', 'Needs Improvement', 'Not Rated', 'Not Rated', 'Satisfactory', 'Not Rated', 'Needs Improvement', 'Not Rated', 'Excellent', 'Satisfactory', 'Needs Improvement', 'Satisfactory', 'Not Rated', 4.5, 'sadfghjkl;', 'slhkfjhghvn', 'fsgfdgjhglo;po', 'Friend Referral', 'sduhgiohoi', 'No', 'Yes', '2025-03-24 17:27:07'),
(5, 'Ashu', 'Tosh', 'Moihan', '2025-03-19', 'Not Rated', 'Not Rated', 'Satisfactory', 'Excellent', 'Satisfactory', 'Excellent', 'Not Rated', 'Satisfactory', 'Not Rated', 'Not Rated', 'Not Satisfied', 'Not Rated', 'Excellent', 3.5, 'kaisa', 'rha', 'trop', 'Advertisement', 'bc', 'No', 'Yes', '2025-03-25 05:36:02'),
(6, 'A', 'a', 'A', '2025-03-20', 'Satisfactory', 'Not Rated', 'Excellent', 'Not Rated', 'Satisfactory', 'Not Rated', 'Not Rated', 'Excellent', 'Not Satisfied', 'Not Rated', 'Needs Improvement', 'Not Rated', 'Satisfactory', 4, 'Hii', '', 'Kaise', 'Friend Referral', 'Ho', 'No', 'Yes', '2025-03-28 21:49:22'),
(7, 'Ram Arora', 'delhi', 'ladask', '2025-04-18', 'Not Rated', 'Satisfactory', 'Not Rated', 'Not Rated', 'Excellent', 'Not Rated', 'Not Rated', 'Not Rated', 'Not Rated', 'Excellent', 'Excellent', 'Not Rated', 'Not Rated', 4, 'sahdvghsagdjhsa', 'asdfghjkl;l', '4867869', NULL, '', 'No', 'Yes', '2025-04-01 05:32:37'),
(8, 'asdfghjkl', 'aSDFGHJKL', 'asdfghjkl', '2025-04-25', 'Satisfactory', 'Excellent', 'Satisfactory', 'Needs Improvement', 'Not Satisfied', 'Needs Improvement', 'Satisfactory', 'Satisfactory', 'Excellent', 'Needs Improvement', 'Excellent', 'Needs Improvement', 'Excellent', 4, 'asdfghjkl', 'qwertyuiop', 'qasdcfvbnmmmmmm,klpoikjhgvcxzasdfghjkl', 'social_media', 'qsdxcxzasertghjkloiuytrdsdfbnm,kjhgfdsdfghjk', 'Yes', 'Yes', '2025-04-17 18:16:52');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `date_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `user`, `pass`, `date_time`) VALUES
(38, 'snehasishconnect@gmail.com', '$2y$10$.8J6ns3BFdFJ/mIp.uCJR.E9Y/iA36VKNhN3/MlYfEDOBX0dIc0Ki', '2025-04-15 07:48:08'),
(39, 'vvnotofficial5678@gmail.com', '$2y$10$ywqX3DxfpYQwz6OTCbD88u7XRlkguU0iRxKdumvqjJT7V5AQKY9gu', '2025-04-16 20:35:06'),
(41, 'ashutoshmohanty2004@gmail.com', '$2y$10$8ungrtl/9Y9PMdJLNyhQK.I6TaOS5GYi3wywICmelfKHMJIDq4Qbe', '2025-04-16 23:50:51'),
(42, 'ashutoshmohanty2004@gmail.com', '$2y$10$8ungrtl/9Y9PMdJLNyhQK.I6TaOS5GYi3wywICmelfKHMJIDq4Qbe', '2025-04-17 00:55:43'),
(48, 'ramarora0075@gmail.com', '$2y$10$dfx6fdOfuecRMQHjxCVAveVIcC1EhsWzuESCPKuj5YGCsUyh5MOwG', '2025-04-17 10:54:25');

-- --------------------------------------------------------

--
-- Table structure for table `otp_verification`
--

CREATE TABLE `otp_verification` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `destination`, `price`, `duration`, `created_at`) VALUES
(6, 'Trip to Varanasi For Dev Diwali', 'Varanasi', 5000.00, 2, '2025-04-17 17:05:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `custom_tours`
--
ALTER TABLE `custom_tours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_verification`
--
ALTER TABLE `otp_verification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `custom_tours`
--
ALTER TABLE `custom_tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `otp_verification`
--
ALTER TABLE `otp_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `custom_tours`
--
ALTER TABLE `custom_tours`
  ADD CONSTRAINT `custom_tours_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
