-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 26, 2022 at 05:04 PM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `columbia_reports`
--

-- --------------------------------------------------------

--
-- Table structure for table `ccs_clubs`
--

CREATE TABLE `ccs_clubs` (
  `id` int(12) NOT NULL,
  `club` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ccs_clubs`
--

INSERT INTO `ccs_clubs` (`id`, `club`, `name`, `active`) VALUES
(1, 'CC01', 'Columbia Cascade Section', 1),
(2, 'CC02', 'Tri-County Gun Club', 1),
(3, 'CC03', 'Dundee Practical Shooters', 1),
(4, 'CC04', 'Non-affiliated Club ', 0),
(5, 'CC05', 'Albany Rifle & Pistol Club', 1),
(6, 'CC06', 'Cossa Practical Shooters', 1),
(7, 'CC07', 'Douglas Ridge Rifle Club', 0),
(8, 'CC08', 'Eugene Practical Shooters', 0),
(9, 'CC09', 'Clatskanie Rifle & Pistol Club', 0),
(10, 'CC10', 'Painted Hills Practical Shooters', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ccs_clubs`
--
ALTER TABLE `ccs_clubs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ccs_clubs`
--
ALTER TABLE `ccs_clubs`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
