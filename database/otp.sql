-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 06:55 AM
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
-- Database: `otp`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_appointments`
--

CREATE TABLE `add_appointments` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(50) NOT NULL,
  `patient_age` int(11) NOT NULL,
  `patient_bday` date NOT NULL,
  `patient_gender` varchar(50) NOT NULL,
  `patient_email` varchar(50) NOT NULL,
  `patient_address` varchar(50) NOT NULL,
  `patient_condition` varchar(50) NOT NULL,
  `patient_contact` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_appointments`
--

INSERT INTO `add_appointments` (`id`, `patient_name`, `patient_age`, `patient_bday`, `patient_gender`, `patient_email`, `patient_address`, `patient_condition`, `patient_contact`) VALUES
(24, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(25, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(26, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(27, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(28, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(29, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(30, 'Ryan Andrew Bulanadi', 22, '0000-00-00', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(31, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(32, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(33, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(34, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(35, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(36, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(37, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(38, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(39, 'Ryan Andrew Bulanadi', 22, '2024-12-11', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286'),
(40, 'Ryan Andrew Bulanadi', 22, '2024-12-13', 'Male', 'bulanadiryry@gmail.com', 'Mexico, Pampanga', 'Tooth Ache', '09350573286');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(400) DEFAULT NULL,
  `status` enum('active','not active') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `status`) VALUES
(1, 'admin', 'dentalcare057', 'not active');

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

CREATE TABLE `email_config` (
  `id` int(145) NOT NULL,
  `email` varchar(145) DEFAULT NULL,
  `password` varchar(145) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_config`
--

INSERT INTO `email_config` (`id`, `email`, `password`, `created_at`, `updated_at`) VALUES
(2, 'joshua010104@gmail.com', 'zdfc ttgm rnit apcc', '2024-09-24 14:23:13', '2024-09-25 03:00:27');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(400) DEFAULT NULL,
  `user_status` enum('not_active','active') NOT NULL DEFAULT 'not_active',
  `verify_status` enum('not_verified','verified','verifying') NOT NULL DEFAULT 'not_verified',
  `tokencode` varchar(400) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `email`, `username`, `password`, `user_status`, `verify_status`, `tokencode`, `created_at`, `reset_token`, `token_expiry`) VALUES
(2, 'Ryan Bulanadi', 'bulanadiryry@gmail.com', 'drew1', 'f0898af949a373e72a4f6a34b4de9090', 'not_active', 'verified', NULL, '2024-12-10 16:14:31', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_appointments`
--
ALTER TABLE `add_appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_appointments`
--
ALTER TABLE `add_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
