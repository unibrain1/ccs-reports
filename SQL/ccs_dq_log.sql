-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 28, 2022 at 08:13 PM
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
-- Table structure for table `ccs_dq_log`
--

DROP TABLE IF EXISTS `ccs_dq_log`;
CREATE TABLE `ccs_dq_log` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `club` varchar(6) DEFAULT NULL,
  `fname` varchar(13) DEFAULT NULL,
  `lname` varchar(13) DEFAULT NULL,
  `number` varchar(8) DEFAULT NULL,
  `stage` varchar(35) DEFAULT NULL,
  `rule` varchar(7) DEFAULT NULL,
  `reason` varchar(38) DEFAULT NULL,
  `hash` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ccs_dq_log`
--

INSERT INTO `ccs_dq_log` (`id`, `date`, `club`, `fname`, `lname`, `number`, `stage`, `rule`, `reason`, `hash`) VALUES
(88, '2020-10-24', 'CC03', 'Tomas', 'Tapia', 'A99949', '2: - Bay 10-1', '10.4.3', 'AD while loading, reloading, unloading', '2020-10-24TomasTapiaA99949'),
(89, '2021-01-23', 'CC03', 'Dale', 'Daniels', 'A132462', '1: Bay 1', '10.5.2', '180', '2021-01-23DaleDanielsA132462'),
(90, '2021-03-27', 'CC03', 'Bill', 'Dixon', 'A124799', '1: Fan', '10.5.2', '180', '2021-03-27BillDixonA124799'),
(91, '2021-06-17', 'CC03', 'Alan', 'Villasenor', 'NONE', '2: Someone Is Always Willing To Pay', '', '', '2021-06-17AlanVillasenorNONE'),
(92, '2021-06-26', 'CC03', 'Boris', 'Kogan', 'A122026', '4: Cross Fire', '', '', '2021-06-26BorisKoganA122026'),
(93, '2021-06-26', 'CC03', 'tom', 'agosti', 'a133944', '4: Cross Fire', '', '', '2021-06-26tomagostia133944'),
(94, '2021-06-26', 'CC03', 'Randal', 'Lee', 'A134468', '5: Divertente', '', '', '2021-06-26RandalLeeA134468'),
(95, '2021-07-24', 'CC03', 'Dave', 'Lund', 'TY80327', '1: Stage  Flapper', '10.5.17', 'Shot at steel within 23 feet', '2021-07-24DaveLundTY80327'),
(96, '2021-07-24', 'CC03', 'David', 'Porter', 'FY133211', '1: Stage  Flapper', '10.5', 'Unsafe Gun Handling', '2021-07-24DavidPorterFY133211'),
(97, '2021-07-24', 'CC03', 'Del', 'Erlandson', 'A135291', '2: Blazing Trail', '10.5.2', '180', '2021-07-24DelErlandsonA135291'),
(98, '2021-10-23', 'CC03', 'Randal', 'Lee', 'A134468', '6: Angles', '', '', '2021-10-23RandalLeeA134468'),
(99, '2021-11-27', 'CC03', 'Nancy', 'Marrs', 'FY51479', '3: Bargaining', '10.5.3', 'Dropped gun', '2021-11-27NancyMarrsFY51479'),
(100, '2021-11-27', 'CC03', 'William(Bill)', 'Peters', 'A130161', '2: Guilt', '10.5.2', '180', '2021-11-27William(Bill)PetersA130161'),
(101, '2021-11-27', 'CC03', 'Jason', 'Stretch', 'NONE', '1: Anger', '', '', '2021-11-27JasonStretchNONE'),
(102, '2022-01-22', 'CC03', 'Michael', 'Smith', 'Fy87796', NULL, '10.4.3', 'AD while loading, reloading, unloading', '2022-01-22MichaelSmithFy87796'),
(103, '2020-12-12', 'CC05', 'phillip', 'oconnor', 'A125553', '3: - Quickie', '10.5.2', '180', '2020-12-12phillipoconnorA125553'),
(104, '2020-12-12', 'CC05', 'yinuo', 'zhang', 'TY126076', '2: - Rictus Grin', '10.5.2', '180', '2020-12-12yinuozhangTY126076'),
(105, '2021-01-09', 'CC05', 'Kaitlyn', 'Wright', 'A120843', '5: Do the Magic Hand Thing!', '10.4.6', 'AD, during movement', '2021-01-09KaitlynWrightA120843'),
(106, '2021-03-13', 'CC05', 'Lawrence', 'Mull', 'Ty45897', '6: Deja Vu', '10.5.3', 'Dropped gun', '2021-03-13LawrenceMullTy45897'),
(107, '2021-05-08', 'CC05', 'Gavin', 'Pestes', 'TY126478', '5: Table', '10.5.3', 'Dropped gun', '2021-05-08GavinPestesTY126478'),
(108, '2021-08-14', 'CC05', 'nathan', 'DeSpain', 'none', 'Stage 4', '10.5.2', '180', '2021-08-14nathanDeSpainnone'),
(109, '2021-09-11', 'CC05', 'Jacob', 'Penuel', 'A124418', 'Stage 6', '', '', '2021-09-11JacobPenuelA124418'),
(110, '2021-11-13', 'CC05', 'David', 'Arthurs', 'none', '2: The MHH', '10.5', 'Unsafe Gun Handling', '2021-11-13DavidArthursnone'),
(111, '2022-01-16', 'CC02', 'Tomas', 'Tapia', 'A99949', NULL, '10.4.7', 'AD, while retrieving firearm', '2022-01-16TomasTapiaA99949'),
(112, '2021-12-19', 'CC02', 'Sterling', 'Baune', '', 'STEEL SYMETRY', '10.5.13', 'Unauthorized loaded gun', '2021-12-19SterlingBaune'),
(113, '2021-11-21', 'CC02', 'Eric', 'Guthrie', 'A33687', 'Stage 3 Classifier', '10.5.2', '180', '2021-11-21EricGuthrieA33687'),
(114, '2021-09-19', 'CC02', 'James', 'Smith', '', 'Times Two', '10.4.4', 'AD, remedial action', '2021-09-19JamesSmith'),
(115, '2021-08-22', 'CC02', 'Daryl', 'Fitzpatrick', 'FY76099', 'Good Enough', '10.5.19', 'PCC - unsafe muzzle or sweeping', '2021-08-22DarylFitzpatrickFY76099'),
(116, '2021-08-22', 'CC02', 'Mark', 'Mitchell', '', 'Good Enough', '10.5.2', '180', '2021-08-22MarkMitchell'),
(117, '2021-06-20', 'CC02', 'daniel', 'nguyen', 'A113557', 'Bermuda', '10.3.6', 'Forbidden action', '2021-06-20danielnguyenA113557'),
(118, '2021-03-20', 'CC02', 'Mitchell', 'Phan', 'A98700', 'Stage 5 Bay 10', '10.4.6', 'AD, during movement', '2021-03-20MitchellPhanA98700'),
(119, '2021-03-20', 'CC02', 'Lisa', 'Stiers', '', 'Stage 3 Bay 8', '10.5.1', 'Unsupervised gun handling', '2021-03-20LisaStiers'),
(120, '2021-03-20', 'CC02', 'Tim', 'Austin', 'A101001', 'Stage 5 Bay 10', '10.5.3', 'Dropped gun', '2021-03-20TimAustinA101001'),
(121, '2021-04-18', 'CC02', 'Anderson', 'Tony', '', NULL, '10.3.6', 'Forbidden action', '2021-04-18AndersonTony'),
(122, '2021-04-03', 'CC06', 'Richard', 'Turner', '', '4: USA', '10.5', 'Unsafe Gun Handling', '2021-04-03RichardTurner'),
(123, '2021-06-05', 'CC06', 'Sami', 'Higgins', 'A129393', '3: Short Jaunt', '10.4.3', 'AD while loading, reloading, unloading', '2021-06-05SamiHigginsA129393'),
(124, '2020-08-01', 'CC06', 'Chris', 'Martin', '', '4: Shrug & Tug', '10.5.2', '180', '2020-08-01ChrisMartin'),
(125, '2020-09-05', 'CC06', 'Jack', 'Hartley', '', '4: Diamond Back', '10.5.2', '180', '2020-09-05JackHartley');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ccs_dq_log`
--
ALTER TABLE `ccs_dq_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ccs_dq_log`
--
ALTER TABLE `ccs_dq_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
