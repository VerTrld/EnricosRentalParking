-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2023 at 03:04 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `payment_update`
--

CREATE TABLE `payment_update` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_update`
--

INSERT INTO `payment_update` (`id`, `name`, `number`, `images`) VALUES
(2, 'Enrico Lucio', '09999999999', '645b6e3c979ea.png');

-- --------------------------------------------------------

--
-- Table structure for table `priceupdate`
--

CREATE TABLE `priceupdate` (
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `priceupdate`
--

INSERT INTO `priceupdate` (`price`) VALUES
(1700);

-- --------------------------------------------------------

--
-- Table structure for table `process`
--

CREATE TABLE `process` (
  `session_id` bigint(11) NOT NULL,
  `seat_id` varchar(255) NOT NULL,
  `user_id` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `selectedSlots` varchar(255) NOT NULL,
  `num_Slots` varchar(255) NOT NULL,
  `payment` varchar(255) NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests_slot`
--

CREATE TABLE `requests_slot` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `selectedSlots` varchar(255) NOT NULL,
  `num_Slots` varchar(255) NOT NULL,
  `payment` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `end_date` date NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `session_id` bigint(20) NOT NULL,
  `seat_id` varchar(16) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `qrcode` varchar(255) NOT NULL,
  `qrimage` varchar(255) NOT NULL,
  `qrlink` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` bigint(20) NOT NULL,
  `room_id` varchar(16) NOT NULL,
  `session_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `room_id`, `session_date`) VALUES
(1, 'ROOM-A', '2077-06-05 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `slots`
--

CREATE TABLE `slots` (
  `seat_id` int(11) NOT NULL,
  `room_id` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slots`
--

INSERT INTO `slots` (`seat_id`, `room_id`) VALUES
(1, 'ROOM-A'),
(2, 'ROOM-A'),
(3, 'ROOM-A'),
(4, 'ROOM-A'),
(5, 'ROOM-A'),
(6, 'ROOM-A'),
(7, 'ROOM-A'),
(8, 'ROOM-A'),
(9, 'ROOM-A'),
(10, 'ROOM-A'),
(11, 'ROOM-A'),
(12, 'ROOM-A'),
(13, 'ROOM-A'),
(14, 'ROOM-A'),
(15, 'ROOM-A'),
(16, 'ROOM-A'),
(17, 'ROOM-A'),
(18, 'ROOM-A'),
(19, 'ROOM-A'),
(20, 'ROOM-A'),
(21, 'ROOM-A'),
(22, 'ROOM-A'),
(23, 'ROOM-A'),
(24, 'ROOM-A'),
(25, 'ROOM-A'),
(26, 'ROOM-A'),
(27, 'ROOM-A'),
(28, 'ROOM-A'),
(29, 'ROOM-A'),
(30, 'ROOM-A'),
(31, 'ROOM-A'),
(32, 'ROOM-A'),
(33, 'ROOM-A'),
(34, 'ROOM-A'),
(35, 'ROOM-A'),
(36, 'ROOM-A'),
(37, 'ROOM-A'),
(38, 'ROOM-A'),
(39, 'ROOM-A'),
(40, 'ROOM-A'),
(41, 'ROOM-A'),
(42, 'ROOM-A'),
(43, 'ROOM-A'),
(44, 'ROOM-A'),
(45, 'ROOM-A'),
(46, 'ROOM-A'),
(47, 'ROOM-A'),
(48, 'ROOM-A'),
(49, 'ROOM-A'),
(50, 'ROOM-A'),
(51, 'ROOM-A'),
(52, 'ROOM-A'),
(53, 'ROOM-A'),
(54, 'ROOM-A'),
(55, 'ROOM-A'),
(56, 'ROOM-A'),
(57, 'ROOM-A'),
(58, 'ROOM-A'),
(59, 'ROOM-A'),
(60, 'ROOM-A'),
(61, 'ROOM-A'),
(62, 'ROOM-A');

-- --------------------------------------------------------

--
-- Table structure for table `slot_info`
--

CREATE TABLE `slot_info` (
  `slotsNumber` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `totalPrice` int(11) NOT NULL,
  `qrcode` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `start_duration` varchar(255) NOT NULL,
  `end_duration` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_attendance`
--

CREATE TABLE `table_attendance` (
  `ID` int(100) NOT NULL,
  `NAME` text NOT NULL,
  `TIMEIN` text NOT NULL,
  `TIMEOUT` varchar(250) NOT NULL,
  `LOGDATE` varchar(250) NOT NULL,
  `STATUS` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slotNo` varchar(255) NOT NULL,
  `noSlot` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `total` varchar(255) NOT NULL,
  `duration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(111) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` text NOT NULL,
  `otp` int(11) DEFAULT NULL,
  `otp_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `number`, `address`, `password`, `user_type`, `otp`, `otp_expiration`) VALUES
(1, 'admin', 'admin@gmail.com', '09999999999', 'marilao,bulacan', '21232f297a57a5a743894a0e4a801fc3', 'admin', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payment_update`
--
ALTER TABLE `payment_update`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `process`
--
ALTER TABLE `process`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests_slot`
--
ALTER TABLE `requests_slot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`session_id`,`seat_id`,`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `session_date` (`session_date`);

--
-- Indexes for table `slots`
--
ALTER TABLE `slots`
  ADD PRIMARY KEY (`seat_id`,`room_id`);

--
-- Indexes for table `slot_info`
--
ALTER TABLE `slot_info`
  ADD PRIMARY KEY (`slotsNumber`);

--
-- Indexes for table `table_attendance`
--
ALTER TABLE `table_attendance`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payment_update`
--
ALTER TABLE `payment_update`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `process`
--
ALTER TABLE `process`
  MODIFY `session_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=516;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `requests_slot`
--
ALTER TABLE `requests_slot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `session_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `slots`
--
ALTER TABLE `slots`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `slot_info`
--
ALTER TABLE `slot_info`
  MODIFY `slotsNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `table_attendance`
--
ALTER TABLE `table_attendance`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1115;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
