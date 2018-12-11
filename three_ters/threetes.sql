-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 06, 2018 at 12:13 PM
-- Server version: 5.7.17-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `threetes`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `tall` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `memberid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`tall`, `weight`, `speed`, `memberid`) VALUES
(160, 80, 3, 4),
(177, 76, 6, 5),
(184, 80, 10, 6),
(180, 80, 6, 7),
(180, 85, 10, 8);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `userid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `address` varchar(50) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`userid`, `username`, `password`, `phone`, `address`, `GroupID`) VALUES
(1, 'ahmed', '12345678', '0111234566', 'cairo', 1),
(2, 'mohamed', '12345678', '01123456767', 'cairo', 0),
(4, 'red6', '1234567', '0118898', 'cairo', 0),
(5, 'mahmoud', '123456', '011304050', 'cicrto', 0),
(6, 'mohamed', '12', '01123456767', 'cairo', 0),
(7, 'mohamed', 'ggg', '899090', 'cairo', 0),
(8, 'ALY', '123', '01123456767', 'cairo', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD KEY `jjjj` (`memberid`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `jjjj` FOREIGN KEY (`memberid`) REFERENCES `user_info` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
