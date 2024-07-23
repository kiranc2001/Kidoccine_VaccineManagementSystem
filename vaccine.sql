-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2024 at 11:28 AM
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
-- Database: `vaccine`
--

-- --------------------------------------------------------

--
-- Table structure for table `added_vaccines`
--

CREATE TABLE `added_vaccines` (
  `id` int(11) NOT NULL,
  `vaccine_name` varchar(255) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `vaccination_date` date DEFAULT NULL,
  `hospital_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `added_vaccines`
--

INSERT INTO `added_vaccines` (`id`, `vaccine_name`, `hospital_name`, `stock`, `price`, `vaccination_date`, `hospital_address`, `created_at`) VALUES
(5, 'COVAX', 'kiran', 42, 0.00, '2024-04-28', 'bengaluru', '2024-04-28 08:19:32'),
(6, 'COVAX', 'Columbia Asia', 60, 0.00, '2024-04-07', 'Yeshwanthpura, Bengaluru', '2024-04-28 06:42:10'),
(7, 'COVIN', 'kiran', 49, 0.00, '2024-04-07', 'bengaluru', '2024-04-28 06:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `email`, `password`) VALUES
(1, 'admin@vaccine.com', 'Kiran218');

-- --------------------------------------------------------

--
-- Table structure for table `booked_vaccines`
--

CREATE TABLE `booked_vaccines` (
  `id` int(11) NOT NULL,
  `vaccine_name` varchar(255) NOT NULL,
  `vaccine_price` decimal(10,2) DEFAULT NULL,
  `vaccination_date` date NOT NULL,
  `child_name` varchar(255) NOT NULL,
  `child_dob` date NOT NULL,
  `parent_name` varchar(255) NOT NULL,
  `parent_phone_number` varchar(15) NOT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `vaccination_status` enum('pending','completed','not_vaccinated') DEFAULT 'pending',
  `hospital` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `certificate_pdf` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hospital_credentials`
--

CREATE TABLE `hospital_credentials` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hospital_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_credentials`
--

INSERT INTO `hospital_credentials` (`id`, `email`, `password`, `hospital_name`, `address`) VALUES
(47, 'kirangowda0212@gmail.com', '269235933089', 'kiran', 'bengaluru'),
(49, 'kirankiki590@gmail.com', '432053990792', 'Columbia Asia', 'Yeshwanthpura, Bengaluru');

-- --------------------------------------------------------

--
-- Table structure for table `hospital_messages`
--

CREATE TABLE `hospital_messages` (
  `id` int(11) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `hospital_email` varchar(255) NOT NULL,
  `message` text DEFAULT 'vaccine added',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_messages`
--

INSERT INTO `hospital_messages` (`id`, `hospital_name`, `hospital_email`, `message`, `created_at`) VALUES
(3, 'kiran', 'kirankiki590@gmail.com', 'added', '2024-04-07 11:01:15'),
(4, 'kiran', 'kirangowda0212@gmail.com', 'COVIN ADDED', '2024-04-07 11:03:36'),
(5, 'Columbia Asia', 'kirankiki590@gmail.com', 'COVAX added', '2024-04-07 12:45:14'),
(6, 'Columbia Asia', 'kirankiki590@gmail.com', 'polio added', '2024-04-07 16:01:37'),
(7, 'kiran', 'kirangowda0212@gmail.com', 'Covax added', '2024-04-07 16:03:50'),
(8, 'kiran', 'kirangowda0212@gmail.com', 'Added', '2024-04-07 16:04:21');

-- --------------------------------------------------------

--
-- Table structure for table `hospital_requests`
--

CREATE TABLE `hospital_requests` (
  `id` int(11) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `certificate_path` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_requests`
--

INSERT INTO `hospital_requests` (`id`, `hospital_name`, `address`, `certificate_path`, `email`, `status`, `request_date`, `password`) VALUES
(25, 'kiran', 'bengaluru', 'uploads/All_weeks.pdf', 'kirankiki590@gmail.com', 'accept', '2024-01-23 12:33:45', NULL),
(26, 'kiran', 'bengaluru', 'uploads/All_weeks.pdf', 'kirangowda0212@gmail.com', 'accept', '2024-01-23 13:02:28', NULL),
(27, 'kiran', 'bengaluru', 'uploads/R19CS163_CN_Assn1.pdf', 'kirangowda0212@gmail.com', 'accept', '2024-01-28 08:56:51', NULL),
(28, 'kiran', 'bengaluru', 'uploads/CN certificate.pdf', 'kirangowda0212@gmail.com', 'accept', '2024-01-28 08:59:39', NULL),
(29, 'kiran', 'bengaluru', 'uploads/All_weeks.pdf', 'kirangowda0212@gmail.com', 'accept', '2024-01-31 10:10:38', NULL),
(30, 'kiran', 'bengaluru', 'uploads/COA_Unit-4_notes.pdf', 'kirangowda0212@gmail.com', 'accept', '2024-03-06 00:52:20', NULL),
(31, 'aiish', 'bengaluru', 'uploads/COMPUTER NETWORKS (1).pdf', 'kirankiki590@gmail.com', 'accept', '2024-03-06 00:57:44', NULL),
(33, 'kiran', 'bengaluru', 'uploads/All_weeks.pdf', 'kirancgowda02@gmail.com', 'accept', '2024-03-06 01:07:13', '6hDHl0dLs28P'),
(34, 'kiran', 'bengaluru', 'uploads/All_weeks.pdf', 'kirankiki590@gmail.com', 'reject', '2024-03-06 01:09:02', NULL),
(35, 'aiish', 'bengaluru', 'uploads/Mallikarjun_Gangammavar_v.pdf', 'kirankiki590@gmail.com', 'accept', '2024-04-06 13:01:14', '876512847174'),
(36, 'kiran', 'bengaluru', 'uploads/Mallikarjun_Gangammavar_v.pdf', 'kirangowda0212@gmail.com', 'accept', '2024-04-06 13:11:30', '269235933089'),
(37, 'kiran', 'bengaluru', 'uploads/Mallikarjun_Gangammavar_v.pdf', 'kirankiki590@gmail.com', 'accept', '2024-04-07 10:51:41', '092000517563'),
(38, 'Columbia Asia', 'Yeshwanthpura, Bengaluru', 'uploads/Mallikarjun_Gangammavar_v.pdf', 'kirankiki590@gmail.com', 'accept', '2024-04-07 12:43:00', '432053990792');

-- --------------------------------------------------------

--
-- Table structure for table `hospital_vaccines`
--

CREATE TABLE `hospital_vaccines` (
  `id` int(11) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `hospital_email` varchar(255) NOT NULL,
  `hospital_address` varchar(255) NOT NULL,
  `vaccine_name` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `vaccination_date` date NOT NULL,
  `price_type` enum('free','paid') NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_vaccines`
--

INSERT INTO `hospital_vaccines` (`id`, `hospital_name`, `hospital_email`, `hospital_address`, `vaccine_name`, `stock`, `vaccination_date`, `price_type`, `price`, `created_at`) VALUES
(25, 'kiran', 'kirangowda0212@gmail.com', 'bengaluru', 'COVIN', 50, '2024-04-07', 'free', 0.00, '2024-04-07 11:03:36'),
(26, 'Columbia Asia', 'kirankiki590@gmail.com', 'Yeshwanthpura, Bengaluru', 'COVAX', 60, '2024-04-07', 'free', 0.00, '2024-04-07 12:45:14'),
(27, 'Columbia Asia', 'kirankiki590@gmail.com', 'Yeshwanthpura, Bengaluru', 'POLIO', 1, '2024-04-07', 'free', 0.00, '2024-04-07 16:01:37'),
(28, 'kiran', 'kirangowda0212@gmail.com', 'bengaluru', 'COVAX', 40, '2024-04-07', 'free', 0.00, '2024-04-07 16:03:50'),
(29, 'kiran', 'kirangowda0212@gmail.com', 'bengaluru', 'COW', 2, '2024-04-07', 'paid', 200.00, '2024-04-07 16:04:21'),
(30, 'kiran', 'kirangowda0212@gmail.com', 'bengaluru', 'VOW', 2, '2024-04-07', 'paid', 1000.00, '2024-04-07 16:05:21'),
(31, 'kiran', 'kirangowda0212@gmail.com', 'bengaluru', 'AA', 10, '2024-04-29', 'free', 0.00, '2024-04-27 23:57:53');

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `recovery_question` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`id`, `name`, `phone`, `email`, `recovery_question`, `password`, `created_at`) VALUES
(11, 'kiran', '8073173710', NULL, '2024-04-06', '$2y$10$Bus2siQpU5va3', '2024-04-28 06:37:56'),
(15, 'aishwarya', '8861268383', NULL, '2024-04-24', '$2y$10$B5/9TSleuk6Ky', '2024-04-28 06:37:56'),
(17, 'Anagha', '9535976727', NULL, '2024-04-24', '$2y$10$Evxcrf5hsSYSSCt8t8.CueVtFlidtZWsFa8GP/JsMdpu5sslL4mpe', '2024-04-28 06:37:56'),
(18, 'Kiran', '8861307716', 'kirangowda0212@gmail.com', NULL, '$2y$10$5SHQ7kItQkMGojaFN56cD.aCQJVmti610tCSUM/HbDF1lKwdfNhH.', '2024-04-28 06:37:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `added_vaccines`
--
ALTER TABLE `added_vaccines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booked_vaccines`
--
ALTER TABLE `booked_vaccines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospital_credentials`
--
ALTER TABLE `hospital_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospital_messages`
--
ALTER TABLE `hospital_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospital_requests`
--
ALTER TABLE `hospital_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospital_vaccines`
--
ALTER TABLE `hospital_vaccines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `added_vaccines`
--
ALTER TABLE `added_vaccines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booked_vaccines`
--
ALTER TABLE `booked_vaccines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hospital_credentials`
--
ALTER TABLE `hospital_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `hospital_messages`
--
ALTER TABLE `hospital_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hospital_requests`
--
ALTER TABLE `hospital_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `hospital_vaccines`
--
ALTER TABLE `hospital_vaccines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
