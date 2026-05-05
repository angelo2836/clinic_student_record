-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2026 at 09:33 AM
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
-- Database: `clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `cridentials`
--

CREATE TABLE `cridentials` (
  `id` int(11) NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cridentials`
--

INSERT INTO `cridentials` (`id`, `username`, `password`, `type`) VALUES
(1, 'nurse', 'nurse123', 'NR');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `stud_id` varchar(250) DEFAULT NULL,
  `program` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `bdate` varchar(250) DEFAULT NULL,
  `age` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `diagnosis` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `stud_id`, `program`, `status`, `bdate`, `age`, `phone`, `diagnosis`) VALUES
(711, '3', '1', '5', '', '2', '4', '6', ''),
(712, '213', '123', '213', '', '123', '213', '123', ''),
(713, '3', '1', '5', '', '2', '4', '6', ''),
(714, '3', '1', '5', '', '2', '4', '6', ''),
(715, '213', '23', '13', '', '213', '2132', '123', ''),
(716, '3', '1', '6', '', '2', '5', '7', ''),
(717, '3', '1', '5', '', '22', '4', '5', ''),
(718, '3', '1', '5', 'active', '2', '4', '5', ''),
(719, 'e', 'q', 't', 'active', 'w', 'r', 'y', ''),
(720, '3', '1', '5', 'active', '2', '4', '5', ''),
(721, '3', '1', '5', 'active', '2', '4', '5', ''),
(722, '3', '1', '5', 'active', '2', '4', '5', ''),
(723, '222222222222', '222222222', '2', '', '222222222', '22', '2', ''),
(724, '213213', '123', '213', '', '213', '213213', '213123', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cridentials`
--
ALTER TABLE `cridentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cridentials`
--
ALTER TABLE `cridentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=725;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
