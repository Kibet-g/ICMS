-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 02:08 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icms_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(255) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `email`, `password`) VALUES
(45029029, 'Sondu_Admin', 'sondupolice@admin.com', '3<n8ut<h2P9v[(g5£');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `name` varchar(255) NOT NULL,
  `id_number` int(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `occurence_date` date NOT NULL,
  `occurence_time` time(6) NOT NULL,
  `id_upload` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `declined`
--

CREATE TABLE `declined` (
  `name` varchar(255) NOT NULL,
  `id_number` int(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `occurence_date` date NOT NULL,
  `occurence_time` time(6) NOT NULL,
  `id_upload` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `declined`
--

INSERT INTO `declined` (`name`, `id_number`, `mobile_no`, `location`, `occurence_date`, `occurence_time`, `id_upload`, `description`, `status`, `email`) VALUES
('Gilbert Kibet Korir', 39024059, '768312655', 'Ongata Rongai, KEN', '2024-05-13', '13:54:00.000000', 'case-uploads/WhatsApp Image 2024-04-24 at 20.16.48_d20f60a4.jpg', 'jkbvuhdsncoifhgeysjbdnciwahgfbwusgfbcuhj', 'Declined', 'kibetg4@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `police`
--

CREATE TABLE `police` (
  `police_id` int(255) NOT NULL,
  `police_email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `police`
--

INSERT INTO `police` (`police_id`, `police_email`, `password`) VALUES
(2801244, 'police1@gmail.com', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_number` int(255) NOT NULL,
  `idtype` varchar(255) NOT NULL,
  `mobile_no` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `email`, `id_number`, `idtype`, `mobile_no`, `password`, `confirmpassword`) VALUES
('PHILIP ESHENYI', 'philiprotich@gmail.com', 19324490, 'National ID', 713188313, 'b8XgHS2yo#[iNXe', 'b8XgHS2yo#[iNXe'),
('Gilbert Kibet Korir', 'kibetg4@gmail.com', 39024059, 'National ID', 768312655, 'b8XgHS2yo#[iNXe', 'b8XgHS2yo#[iNXe');

-- --------------------------------------------------------

--
-- Table structure for table `verified`
--

CREATE TABLE `verified` (
  `name` varchar(255) NOT NULL,
  `id_number` int(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `occurence_date` date NOT NULL,
  `occurence_time` time(6) NOT NULL,
  `id_upload` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verified`
--

INSERT INTO `verified` (`name`, `id_number`, `mobile_no`, `location`, `occurence_date`, `occurence_time`, `id_upload`, `description`, `status`, `email`) VALUES
('PHILIP ESHENYI', 19324490, '0713188313', 'Sondu', '2024-05-14', '11:28:00.000000', 'case-uploads/id front.jpg', 'gtydytuilkluyttyhjnuffi', 'verified', 'philiprotich@gmail.com'),
('PHILIP ESHENYI', 23374326, '0713188313', 'Ongata Rongai, KEN', '2024-05-13', '11:36:00.000000', 'case-uploads/Picture1.png', 'DNSKJNASKCJNASIDCNSDAIBCIUSADBCISUACBN', 'verified', 'philiprotich@gmail.com'),
('PHILIP ESHENYI', 19324490, '713188313', 'Sondu', '2024-05-13', '13:03:00.000000', 'case-uploads/Dev wallpaper.png', 'nqiowdjakj kxckjanx', 'verified', 'philiprotich@gmail.com'),
('PHILIP ESHENYI', 19324490, '713188313', 'Ongata Rongai, KEN', '2024-05-13', '13:18:00.000000', 'case-uploads/Dev wallpaper.png', ' bsjihfgos;ljfjdjhflhsz', 'verified', 'philiprotich@gmail.com'),
('Gilbert Kibet Korir', 39024059, '768312655', 'Ongata Rongai, KEN', '2024-05-14', '13:38:00.000000', 'case-uploads/asphalt walpaper.png', 'nbdvfiuesdmfwveausidnxasjz', 'verified', 'kibetg4@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
