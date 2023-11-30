-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2023 at 11:09 PM
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
-- Database: `aitech_payment`
--

-- --------------------------------------------------------

--
-- Table structure for table `fees_list`
--

CREATE TABLE `fees_list` (
  `fees_id` int(11) NOT NULL,
  `fees_title` text NOT NULL,
  `fees_description` text NOT NULL,
  `year_included` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees_list`
--

INSERT INTO `fees_list` (`fees_id`, `fees_title`, `fees_description`, `year_included`, `cost`, `deadline`) VALUES
(6, 'Club Fee 1', 'you', 5, 180, '2023-08-24'),
(25, 'Club Fee', 'asdas', 5, 500, '2023-08-21'),
(26, 'Science Club Fee', 'asdas', 5, 200, '2023-11-18'),
(27, 'English Club Fee', 'wala lang', 5, 25, '2023-12-08');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_email` text NOT NULL,
  `action` text NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_id`, `user_id`, `user_email`, `action`, `log_date`, `type`) VALUES
(1, 5, 'admin@access.com', 'Restore the database using backup-aitech_payment-20230915_115609.sql.gz', '2023-09-14 16:00:00', 2),
(2, 5, 'admin@access.com', 'Backup the database named backup-aitech_payment-20231116_101938.sql.gz', '2023-11-16 02:19:38', 1),
(3, 5, 'admin@access.com', 'Created new fees named Science Club Fee', '2023-11-16 05:38:07', 4),
(4, 5, 'admin@access.com', 'Backup the database named backup-aitech_payment-20231116_155204.sql.gz', '2023-11-16 07:52:04', 1),
(5, 5, 'admin@access.com', 'Backup the database named backup-aitech_payment-20231117_091015.sql.gz', '2023-11-17 01:10:15', 1),
(6, 17, 'jobert@access.com', 'Payed 50 for Club Fee 1  reference number: 5VS35799KV6856837', '2023-11-17 15:10:06', 3),
(7, 5, 'admin@access.com', 'Created new fees named English Club Fee', '2023-11-17 15:29:45', 4),
(8, 5, 'admin@access.com', 'Backup the database named backup-aitech_payment-20231117_233057.sql.gz', '2023-11-17 15:30:57', 1),
(9, 18, 'jobert.simbre14@gmail.com', 'Payed 50 for Club Fee 1  reference number: 6KJ05063C4293423L', '2023-11-28 02:22:14', 3),
(10, 18, 'jobert.simbre14@gmail.com', 'Payed 50 for Club Fee 1  reference number: 6SJ263284P318754W', '2023-11-28 02:27:08', 3),
(11, 18, 'jobert.simbre14@gmail.com', 'Payed 50 for Club Fee 1  reference number: 3X6861809U749254C', '2023-11-28 02:27:55', 3),
(12, 5, 'admin@access.com', 'Backup the database named backup-aitech_payment-20231128_103132.sql.gz', '2023-11-28 02:31:32', 1),
(13, 18, 'jobert.simbre14@gmail.com', 'Payed 30 for Club Fee 1  reference number: 7N071347GD5668226', '2023-11-28 08:32:21', 3),
(14, 5, 'admin@access.com', 'Backup the database named backup-aitech_payment-20231128_163502.sql.gz', '2023-11-28 08:35:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_list`
--

CREATE TABLE `payment_list` (
  `payment_id` int(11) NOT NULL,
  `fees_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `section` int(2) NOT NULL,
  `year_level` int(2) NOT NULL,
  `date` date NOT NULL,
  `status` int(1) NOT NULL,
  `cost` decimal(11,2) NOT NULL,
  `reference` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_list`
--

INSERT INTO `payment_list` (`payment_id`, `fees_id`, `student_id`, `fullname`, `section`, `year_level`, `date`, `status`, `cost`, `reference`) VALUES
(15, 25, 1, 'admin ', 1, 1, '2023-11-16', 1, '500.00', '5R718478G4923971X'),
(17, 6, 1, 'admin ', 1, 1, '2023-11-16', 2, '50.00', '62820184A09342632'),
(18, 6, 12, 'jobert gosuico simbre', 4, 4, '2023-11-17', 2, '50.00', '5VS35799KV6856837'),
(19, 6, 13, 'jobert gosuico simbre', 6, 4, '2023-11-28', 1, '180.00', '6KJ05063C4293423L');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `section_name` text NOT NULL,
  `year_group` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section_name`, `year_group`) VALUES
(1, 'A', 1),
(2, 'B', 3);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `firstname` text NOT NULL,
  `middlename` text NOT NULL,
  `lastname` text NOT NULL,
  `year_group` int(1) NOT NULL,
  `section` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `firstname`, `middlename`, `lastname`, `year_group`, `section`) VALUES
(1, 5, 'admin', '', '', 1, 1),
(12, 17, 'jobert', 'gosuico', 'simbre', 1, 4),
(13, 18, 'jobert', 'gosuico', 'simbre', 4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `privilege` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `created_at`, `updated_at`, `privilege`) VALUES
(5, 'admin@access.com', '$2y$10$HPTgcJcVQY6VOwmojTkirecrhY.lMctVUx/VCVAjgGkLbmZkJYF.G', '2023-08-09 03:27:20', '2023-08-09 03:27:20', '$2y$10$qnvd1wz5EZvhYSKJc0j3.uqURn59HnNN7FogenNYqt9yk8/0MsCJO'),
(17, 'jobert@access.com', '$2y$10$Dldw4/xY6XsPXBVRtpcbau5qnA91t9nxWv4/O3UTwej.xAz7BzuBK', '2023-11-17 01:20:10', '2023-11-17 01:20:10', '3'),
(18, 'jobert.simbre14@gmail.com', '$2y$10$y.15NC.htSr1ssoNEbjd6e10AIAvOP7ogofV5O7WRsQi2BePjDJ8O', '2023-11-27 18:22:03', '2023-11-27 18:22:03', '3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fees_list`
--
ALTER TABLE `fees_list`
  ADD PRIMARY KEY (`fees_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `payment_list`
--
ALTER TABLE `payment_list`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fees_list`
--
ALTER TABLE `fees_list`
  MODIFY `fees_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payment_list`
--
ALTER TABLE `payment_list`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
