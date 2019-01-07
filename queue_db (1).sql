-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2019 at 03:31 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `queue_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `place`
--

CREATE TABLE `place` (
  `id_place` int(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `picture` varchar(200) NOT NULL,
  `id_user` int(50) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `place`
--

INSERT INTO `place` (`id_place`, `name`, `address`, `picture`, `id_user`, `status`) VALUES
(2, 'Bengkel', 'Jl. Anggrek', './place/1545967096.3073.jpg', 2, 'close'),
(3, 'Rumah Sakit Saiful Anwar', 'Jl. Jalanan Raya 200', './place/1546225419.4797.jpg', 49, 'open'),
(4, 'Kebun Binatang Tanjung Balai', 'Jl. Tanjung Balai', './place/1546225916.9767.jpg', 48, 'open');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id_place` int(50) NOT NULL,
  `id_user` int(50) NOT NULL,
  `queue_code` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `id_queue` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`id_place`, `id_user`, `queue_code`, `status`, `id_queue`) VALUES
(2, 49, 'A0001', 'waiting', 2),
(3, 49, 'A0001', 'done', 3),
(3, 50, 'A0002', 'waiting', 4),
(3, 48, 'A0003', 'waiting', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(12) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `photoprofile` varchar(100) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `name`, `email`, `password`, `photoprofile`, `level`) VALUES
(48, 'rama', 'rama@gmail.com', 'e04f28cc33cb20274dd3ff44e600a923', './profile/1545967024.6212.jpg', 'admin'),
(49, 'rafli', 'abcdefghijklmn', '0bef1939b3c02eea4b89f1a8247419cf', './profile/1546222924.2892.jpg', 'user'),
(50, 'wkwk', 'wlwlw', '0bef1939b3c02eea4b89f1a8247419cf', './profile/1546230061.8247.jpg', 'user'),
(52, 'hai', 'hoihoi', '89ccfac87d8d06db06bf3211cb2d69ed', './profile/1546484958.0591.png', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`id_place`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id_queue`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `place`
--
ALTER TABLE `place`
  MODIFY `id_place` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id_queue` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
