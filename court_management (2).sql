-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2026 at 12:34 PM
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
-- Database: `court_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `accepted_bookings`
--

CREATE TABLE `accepted_bookings` (
  `accepted_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phonenumber` varchar(100) DEFAULT NULL,
  `court_type` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `time_slot` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Accepted',
  `users_id` int(11) DEFAULT NULL,
  `accepted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accepted_bookings`
--

INSERT INTO `accepted_bookings` (`accepted_id`, `reservation_id`, `username`, `fullname`, `email`, `phonenumber`, `court_type`, `date`, `time_slot`, `status`, `users_id`, `accepted_at`) VALUES
(1, 59, 'rics', 'rico ivan', 'rics@yahoo.com', '09123456789', 'Basketball', '2025-12-18', '9PM - 10PM', 'Accepted', 12, '2025-12-23 03:12:58'),
(2, 60, 'rics', 'rico ivan', 'rics@yahoo.com', '09123456789', 'Basketball', '2025-12-26', '5PM - 6PM', 'Accepted', 12, '2025-12-23 03:22:03'),
(3, 62, 'kwazawa', 'ala wa balo', 'r.abadies@yahoo.com', '09123456789', 'Basketball', '2026-01-09', '8PM - 9PM', 'Accepted', 17, '2026-01-07 13:02:18'),
(4, 64, 'kwazawa', 'ala wa balo', 'r.abadies@yahoo.com', '09123456789', 'Basketball', '2026-01-09', '6PM - 7PM', 'Accepted', 17, '2026-01-07 13:55:54'),
(5, 65, 'rics', 'rico ivan', 'rics@yahoo.com', '09123456789', 'Basketball', '2026-01-22', '8PM - 9PM', 'Accepted', 12, '2026-01-20 10:35:07');

-- --------------------------------------------------------

--
-- Table structure for table `cancelled_bookings`
--

CREATE TABLE `cancelled_bookings` (
  `cancelled_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phonenumber` varchar(100) DEFAULT NULL,
  `court_type` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `time_slot` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Cancelled',
  `users_id` int(11) DEFAULT NULL,
  `cancelled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cancelled_bookings`
--

INSERT INTO `cancelled_bookings` (`cancelled_id`, `reservation_id`, `username`, `fullname`, `email`, `phonenumber`, `court_type`, `date`, `time_slot`, `status`, `users_id`, `cancelled_at`) VALUES
(1, 61, 'rics', 'rico ivan', 'rics@yahoo.com', '09123456789', 'Basketball', '2026-01-09', '5PM - 6PM', 'Cancelled', 12, '2026-01-07 12:46:57');

-- --------------------------------------------------------

--
-- Table structure for table `denied_bookings`
--

CREATE TABLE `denied_bookings` (
  `denied_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phonenumber` varchar(100) DEFAULT NULL,
  `court_type` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `time_slot` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Denied',
  `users_id` int(11) DEFAULT NULL,
  `denied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `denied_bookings`
--

INSERT INTO `denied_bookings` (`denied_id`, `reservation_id`, `username`, `fullname`, `email`, `phonenumber`, `court_type`, `date`, `time_slot`, `status`, `users_id`, `denied_at`) VALUES
(1, 59, 'rics', 'rico ivan', 'rics@yahoo.com', '09123456789', 'Basketball', '2025-12-18', '9PM - 10PM', 'Denied', 12, '2025-12-23 03:29:25'),
(2, 63, 'kwazawa', 'ala wa balo', 'r.abadies@yahoo.com', '09123456789', 'Basketball', '2026-01-09', '7PM - 8PM', 'Denied', 17, '2026-01-07 13:10:56'),
(3, 66, 'rics', 'rico ivan', 'rics@yahoo.com', '09123456789', 'Basketball', '2026-01-22', '9PM - 10PM', 'Denied', 12, '2026-01-20 10:35:41');

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `logs_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `user_agent` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`logs_id`, `users_id`, `username`, `role`, `ip_address`, `user_agent`) VALUES
(1, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Sa'),
(2, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Sa'),
(3, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Sa'),
(4, 11, 'admintest', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(5, 11, 'admintest', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(6, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(10, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(11, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(12, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(13, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(14, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(15, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(16, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(17, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(18, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(19, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(20, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(21, 16, 'ricss', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(22, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(23, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(24, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(25, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(26, 16, 'ricss', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(27, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(28, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(29, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(30, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(31, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(32, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(33, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(34, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(35, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(36, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(37, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(38, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(39, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(40, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Sa'),
(41, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Sa'),
(42, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Sa'),
(43, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Sa'),
(44, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Sa'),
(45, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Sa'),
(46, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Sa'),
(47, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(48, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(49, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(50, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(51, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(52, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(53, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(54, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(55, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(56, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(57, 17, 'kwazawa', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(58, 17, 'kwazawa', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(59, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(60, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(61, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(62, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa'),
(63, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Sa');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phonenumber` varchar(100) DEFAULT NULL,
  `court_type` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `time_slot` varchar(10) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `status` varchar(20) NOT NULL,
  `users_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phonenumber` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('admin','user') NOT NULL,
  `profile_pic` varchar(255) DEFAULT 'assets/imgs/pfp.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `username`, `fullname`, `email`, `phonenumber`, `password`, `created_at`, `role`, `profile_pic`) VALUES
(6, 'test', '', NULL, '09198154880', '$2y$10$7yt.ebR18WaP4Sf5cmphqexKxQyh8OLFQgv1z6vYhSyDRRFOswlCG', '2025-06-12 05:08:01', 'user', 'assets/imgs/pfp.jpg'),
(7, 'admin', '', NULL, NULL, '$2y$10$c2GZQKeFQ5HOa/mqoqtCLu5.YrW4duHGKONX1ZuM3PK', '2025-06-12 05:11:05', 'admin', 'assets/imgs/pfp.jpg'),
(8, 'admin2', '', NULL, NULL, '$2y$10$FxWzo/DV42UzLIiHDP3RquexW7uR/4DpAem4YLOZ7M0', '2025-06-12 05:11:05', 'admin', 'assets/imgs/pfp.jpg'),
(10, 'qwe', '', 'qwe@gmail.com', '09123456789', '$2y$10$UGFB722hsRSlXAgByRGr9e5Knw1xPafvNcGqf3y4EnNfVYUvDM62u', '2025-07-11 11:39:11', 'user', 'assets/imgs/pfp.jpg'),
(11, 'admintest', '', 'admin@yahoo.com', '09123456778', '$2y$10$qoJDzP2BnG7Rqc2HdZmX7esuPXvi5Qw6pAl4hV5t78GKOjHUOWFxi', '2025-07-11 13:26:29', 'admin', 'assets/imgs/pfp.jpg'),
(12, 'rics', 'rico ivan', 'rics@yahoo.com', '09123456789', '$2y$10$TbWRk22JSXhPFhwulURcIua6JjYhAQs7/HZ3.BeXf6h1KKv1FRNYS', '2025-08-21 15:48:39', 'user', 'assets/imgs/pfp.jpg'),
(13, 'papi', '', 'ninyo@gmail.com', '09123456789', '$2y$10$CTzwGiYIwC/0zZJU4JuPG.UqvYvJWd5EUf.EsBXgKNfoUko.fgbzq', '2025-07-19 05:51:05', 'user', 'assets/imgs/pfp.jpg'),
(14, 'kalbis', 'kristian dave kalbis', 'kalbis@gmail.com', '09123456789', '$2y$10$nDUbwiHPLGJcfnN54eT3SerRBhyziZ1Fkl8ULNn8hUk6kJ0UekVGO', '2025-07-19 06:30:29', 'user', 'assets/imgs/pfp.jpg'),
(15, 'admin123', 'rico', 'rico@gmail.com', '09112456789', '$2y$10$.gtX/wdCwv8luUH/WmlQVeserQVR/hA53XZ/ToW9SsEywhEHAn8m.', '2026-01-20 13:06:05', 'admin', 'admin123_1768914365.jpg'),
(16, 'ricss', 'ricooo', 'rio@gmail.com', '09123456789', '$2y$10$FF9O/pIfcoDhuCco9g7KVeT8AY5cuyqtrQRrxD0DihqNy8ugMBuIi', '2025-09-05 16:32:59', 'user', 'assets/imgs/pfp.jpg'),
(17, 'kwazawa', 'ala wa balo', 'r.abadies@yahoo.com', '09123456789', '$2y$10$5vflfBBrXcZc/9fiBDrQXuE9tVJaslDtKl6v/EnyYBT65fRqsJd8G', '2026-01-07 13:00:42', 'user', 'assets/imgs/pfp.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_bookings`
--
ALTER TABLE `accepted_bookings`
  ADD PRIMARY KEY (`accepted_id`);

--
-- Indexes for table `cancelled_bookings`
--
ALTER TABLE `cancelled_bookings`
  ADD PRIMARY KEY (`cancelled_id`);

--
-- Indexes for table `denied_bookings`
--
ALTER TABLE `denied_bookings`
  ADD PRIMARY KEY (`denied_id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`logs_id`),
  ADD KEY `fk_loginlogs_users` (`users_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `fk_reservations_users` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accepted_bookings`
--
ALTER TABLE `accepted_bookings`
  MODIFY `accepted_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cancelled_bookings`
--
ALTER TABLE `cancelled_bookings`
  MODIFY `cancelled_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `denied_bookings`
--
ALTER TABLE `denied_bookings`
  MODIFY `denied_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD CONSTRAINT `fk_loginlogs_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
