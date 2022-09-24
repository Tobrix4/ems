-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2021 at 07:50 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bims_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `baptismal_details`
--

CREATE TABLE `baptismal_details` (
  `baptismal_id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `baptismal_details`
--

INSERT INTO `baptismal_details` (`baptismal_id`, `meta_field`, `meta_value`) VALUES
(3, 'place_of_baptism', 'Sample Address'),
(3, 'officient', 'Rev. Fr. John Daniels'),
(3, 'firstname', 'Samanth Jane'),
(3, 'middlename', 'B'),
(3, 'lastname', 'Smith'),
(3, 'gender', 'Female'),
(3, 'dob', '2021-10-14'),
(3, 'place_of_birth', 'There City'),
(3, 'father_name', 'John D Smith'),
(3, 'mother_name', 'Claire C Blake'),
(3, 'telephone', '09456687912 / 456 4668 9874'),
(3, 'address', 'Here Street, There City, Anywhere, 2306'),
(4, 'place_of_baptism', 'Sample Address 2'),
(4, 'officient', 'Rev. Fr. Dan Espanta'),
(4, 'firstname', 'Vince'),
(4, 'middlename', 'M'),
(4, 'lastname', 'Miller'),
(4, 'gender', 'Male'),
(4, 'dob', '2021-09-15'),
(4, 'place_of_birth', 'Here City'),
(4, 'father_name', 'Mark B Miller'),
(4, 'mother_name', 'Danielle T Lou'),
(4, 'telephone', '0912345689'),
(4, 'address', 'Our Homes, Here City, Overthere, 1014');

-- --------------------------------------------------------

--
-- Table structure for table `baptismal_list`
--

CREATE TABLE `baptismal_list` (
  `id` int(30) NOT NULL,
  `code` varchar(50) NOT NULL,
  `fullname` text NOT NULL,
  `date` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `baptismal_list`
--

INSERT INTO `baptismal_list` (`id`, `code`, `fullname`, `date`, `date_created`, `date_updated`) VALUES
(3, 'SQC-2021120001', 'Smith, Samanth Jane B', '2021-12-22', '2021-12-21 11:26:10', NULL),
(4, 'IPH-2021120001', 'Miller, Vince M', '2021-12-24', '2021-12-21 13:16:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message_list`
--

CREATE TABLE `message_list` (
  `id` int(30) NOT NULL,
  `fullname` text NOT NULL,
  `contact` text NOT NULL,
  `email` text NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_list`
--

INSERT INTO `message_list` (`id`, `fullname`, `contact`, `email`, `message`, `status`, `date_created`) VALUES
(1, 'John D Smith', '091236546798', 'jsmith@sample.com', 'This is a sample inquiry only.', 1, '2021-12-21 13:31:03');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Online Baptismal Information Management System - PHP'),
(6, 'short_name', 'BIMS - PHP'),
(11, 'logo', 'uploads/logo-1640050010.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1640050010.png'),
(15, 'content', 'Array'),
(16, 'email', 'info@christianchurch.com'),
(17, 'contact', '09854698789 / 78945632'),
(18, 'from_time', '11:00'),
(19, 'to_time', '21:30'),
(20, 'address', 'XYZ Street, There City, Here, 2306'),
(21, 'church_name', 'Sample Church Name'),
(22, 'religion', 'Roman Catholic');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', NULL, 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatar-1.png?v=1639468007', NULL, 1, 1, '2021-01-20 14:02:37', '2021-12-14 15:47:08'),
(3, 'Claire', NULL, 'Blake', 'cblake', '4744ddea876b11dcb1d169fadf494418', 'uploads/avatar-3.png?v=1639467985', NULL, 2, 1, '2021-12-14 15:46:25', '2021-12-14 15:46:25');

-- --------------------------------------------------------

--
-- Table structure for table `witness_list`
--

CREATE TABLE `witness_list` (
  `baptismal_id` int(30) NOT NULL,
  `fullname` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `witness_list`
--

INSERT INTO `witness_list` (`baptismal_id`, `fullname`, `address`) VALUES
(3, 'Mike Williams', 'Sample Address 1'),
(3, 'Ana Williams', 'Sample Address 1'),
(3, 'George Wilson', 'Sample Address 2'),
(3, 'Cynthia Wilson', 'Sample Address 2'),
(3, 'Mark Cooper', 'Sample Address 3'),
(3, 'Jenny Cooper', 'Sample Address 4'),
(4, 'John Smith', 'Sample address 23'),
(4, 'Michaela Chan', 'Sample Address 502'),
(4, 'Angeline Lee', 'Sample Address 404'),
(4, 'Jimmy Dela Cruz', 'Sample Address 302');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baptismal_details`
--
ALTER TABLE `baptismal_details`
  ADD KEY `baptismal_id` (`baptismal_id`);

--
-- Indexes for table `baptismal_list`
--
ALTER TABLE `baptismal_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_list`
--
ALTER TABLE `message_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `witness_list`
--
ALTER TABLE `witness_list`
  ADD KEY `baptismal_id` (`baptismal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baptismal_list`
--
ALTER TABLE `baptismal_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `message_list`
--
ALTER TABLE `message_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `baptismal_details`
--
ALTER TABLE `baptismal_details`
  ADD CONSTRAINT `baptismal_details_ibfk_1` FOREIGN KEY (`baptismal_id`) REFERENCES `baptismal_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `witness_list`
--
ALTER TABLE `witness_list`
  ADD CONSTRAINT `witness_list_ibfk_1` FOREIGN KEY (`baptismal_id`) REFERENCES `baptismal_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
