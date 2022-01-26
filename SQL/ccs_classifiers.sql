-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 26, 2022 at 03:51 PM
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
-- Table structure for table `ccs_classifiers`
--

DROP TABLE IF EXISTS `ccs_classifiers`;
CREATE TABLE `ccs_classifiers` (
  `id` varchar(3) NOT NULL,
  `classifier` varchar(10) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `scoring` varchar(10) DEFAULT NULL,
  `rounds` varchar(6) DEFAULT NULL,
  `reload` tinyint(1) DEFAULT '0',
  `barricade` tinyint(4) DEFAULT NULL,
  `table` tinyint(4) DEFAULT NULL,
  `prop` tinyint(4) DEFAULT NULL,
  `strings` varchar(7) DEFAULT NULL,
  `shoWho` tinyint(4) DEFAULT NULL,
  `movement` tinyint(4) DEFAULT NULL,
  `distance` varchar(8) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ccs_classifiers`
--

INSERT INTO `ccs_classifiers` (`id`, `classifier`, `name`, `scoring`, `rounds`, `reload`, `barricade`, `table`, `prop`, `strings`, `shoWho`, `movement`, `distance`, `status`) VALUES
('1', '09-14', 'Eye Of The Tiger', 'Virginia', '6', 0, 0, 0, 0, '', 0, 0, '21', 1),
('10', '03-14', 'Baseball Standards', 'Fixed Time', '24', 1, 0, 0, 0, '4', 1, 0, '75', 1),
('100', '99-36', 'After Work Blues', 'Comstock', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('101', '99-37', 'Steel One', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('102', '99-38', 'The Gauntlet II', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('103', '99-33', 'Raw Deal', 'Virginia', '12', 1, 0, 1, 0, '', 0, 0, '40', 1),
('104', '19-03', 'Hi\'er Love', 'Comstock', '12', 0, 0, 0, 0, '', 0, 1, '40', 1),
('105', '99-41', 'Works For Me', 'Comstock', '12', 1, 1, 0, 0, '', 0, 0, '37', 1),
('106', '99-43', 'Color Blind', 'Comstock', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('107', '99-44', 'Claim Yumpers of Ballard Creek', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('108', '99-45', 'Easy Street', 'Comstock', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('109', '99-42', 'Fast n Furious', 'Comstock', '12', 1, 0, 0, 0, '', 0, 0, '40', 1),
('11', '03-18', 'High Standards', 'Virginia', '14', 1, 0, 0, 0, '2', 1, 0, '45', 1),
('110', '99-46', 'Close Quarter Standards', 'Comstock', '24', 1, 0, 0, 0, '3', 1, 0, '30', 1),
('111', '03-03', 'Take em Down', 'Comstock', '11', 0, 1, 0, 0, '', 0, 1, '45', 1),
('112', '99-49', 'Speed-E-Standards', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('113', '99-50', 'Better Make Sure', 'Comstock', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('114', '99-48', 'Tight Squeeze', 'Virginia', '12', 1, 0, 0, 0, '', 0, 0, '36', 1),
('115', '99-52', 'Cash n Carry', 'Comstock', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('116', '19-02', 'Hi-Way Robbery', 'Comstock', '12', 0, 0, 0, 0, '', 0, 1, '46', 1),
('117', '99-54', 'Tuff Enough Standards', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('118', '99-53', 'Triple Play', 'Comstock', '12', 1, 1, 0, 1, '', 0, 0, '34', 1),
('119', '06-02', 'Big Barricade II', 'Comstock', '16', 0, 1, 0, 0, '1', 0, 1, '48', 1),
('12', '21-01', 'Trigger freeze', 'Comstock', '24', 0, 0, 0, 0, '1', 0, 1, '24', 1),
('120', '99-59', 'Lazy Man Standards', 'Virginia', '-', 1, 0, 0, 0, '4', 1, 0, '75', 0),
('121', '99-60', 'Cut and Run', 'Comstock', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('122', '09-04', 'Pucker Factor', 'Virginia', '8', 0, 0, 0, 0, '', 0, 0, '51', 1),
('123', '99-57', 'Bookouts Boogie', 'Comstock', '12', 0, 0, 0, 0, '', 0, 1, '57', 1),
('124', '99-51', 'Single Tap Standards', 'Virginia', '24', 0, 0, 0, 0, '4', 1, 0, '60', 1),
('125', '99-63', 'Merles Standards', 'Virginia', '24', 1, 0, 0, 0, '2', 1, 0, '105', 1),
('126', '99-63', 'Merles Standards', 'Virginia', '24', 1, 0, 0, 0, '2', 1, 0, '105', 1),
('13', '09-03', 'Oh No', 'Virginia', '12', 0, 0, 0, 0, '2', 0, 0, '29', 1),
('14', '06-03', 'Can You Count', 'Virginia', '20', 1, 0, 0, 0, '2', 0, 0, '10', 1),
('15', '09-07', 'It\'s Not Brain Surgery', 'Comstock', '6', 0, 0, 0, 0, '', 0, 0, '30', 1),
('16', '99-02', 'Night Moves', 'Virginia', '18', 0, 0, 0, 0, '3', 0, 0, '30', 1),
('17', '06-06', 'Golden Bullet Standards', 'Virginia', '24', 1, 0, 0, 0, '2', 1, 0, '30', 1),
('18', '06-07', 'Steely Speed IV', 'Comstock', '6', 1, 0, 0, 0, '', 0, 0, '', 0),
('19', '06-08', 'Steely Speed V', 'Comstock', '6', 1, 0, 0, 0, '', 0, 0, '', 0),
('2', '03-04', '3-V', 'Virginia', '14', 1, 1, 0, 0, '', 0, 0, '32', 1),
('20', '06-09', 'Steely Speed VI', 'Comstock', '6', 1, 0, 0, 0, '', 0, 0, '', 0),
('21', '06-04', 'Fluffy\'s Revenge 1', 'Comstock', '8', 0, 0, 0, 0, '', 0, 0, '33', 1),
('22', '08-01', '4 Bill Drill', 'Virginia', '24', 1, 0, 0, 0, '2', 1, 0, '105', 1),
('23', '08-02', 'Steeler Standards', 'Virginia', '20', 1, 0, 0, 0, '3', 1, 0, '30', 1),
('24', '06-05', 'Fluffy\'s Revenge 2', 'Comstock', '8', 0, 0, 0, 0, '', 0, 0, '33', 1),
('25', '08-04', 'Seven', 'Comstock', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('26', '08-05', 'Long Range Standards 2', 'Fixed Time', '18', 1, 0, 0, 0, '', 0, 0, '', 0),
('27', '08-06', 'Area 4 Standards', 'Fixed Time', '18', 1, 0, 0, 0, '', 0, 0, '', 0),
('28', '09-01', 'Six In Six Challenge', 'Fixed Time', '24', 1, 0, 0, 0, '3', 1, 0, '75', 1),
('29', '09-02', 'Diamond Cutter', 'Virginia', '8', 1, 0, 0, 0, '', 0, 0, '21', 1),
('3', '03-05', 'Paper Poppers', 'Comstock', '10', 1, 0, 0, 0, '', 0, 0, '33', 1),
('30', '99-07', 'Both Sides Now #1', 'Virginia', '18', 0, 1, 0, 0, '3', 0, 0, '35', 1),
('31', '08-03', 'Six', 'Comstock', '6', 0, 0, 0, 0, '', 0, 0, '36', 1),
('32', '09-05', 'Quad Standards', 'Fixed Time', '24', 1, 0, 0, 0, '', 0, 0, '', 0),
('33', '09-06', 'Quad Standards 2', 'Fixed Time', '24', 1, 0, 0, 0, '', 0, 0, '', 0),
('34', '13-02', 'Down The Middle', 'Virginia', '8', 0, 0, 0, 0, '', 0, 0, '36', 1),
('35', '13-07', 'Double Deal 2', 'Comstock', '8', 0, 0, 0, 0, '', 0, 0, '36', 1),
('36', '09-09', 'Lightning And Thunder', 'Fixed Time', '18', 1, 0, 0, 0, '3', 1, 0, '75', 1),
('37', '99-14', 'Hoser Heaven', 'Fixed Time', '18', 0, 0, 0, 0, '3', 1, 0, '36', 1),
('38', '09-11', 'Razor\'s Edge', 'Virginia', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('39', '09-12', 'Any Given Sunday', 'Comstock', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('4', '03-07', 'Riverdale Standards', 'Virginia', '20', 1, 0, 0, 0, '3', 1, 0, '30', 1),
('40', '99-56', 'On the Upper Pad II', 'Comstock', '12', 0, 0, 0, 1, '', 0, 1, '40', 1),
('41', '99-61', 'Sit Or Get Off The Shot', 'Virginia', '12', 0, 0, 1, 0, '3', 0, 0, '40', 1),
('42', '13-01', 'Disaster Factor', 'Virginia', '12', 1, 0, 0, 0, '', 0, 0, '31', 1),
('43', '03-12', 'Ironsides', 'Comstock', '12', 0, 0, 0, 1, '', 0, 1, '45', 1),
('44', '13-03', 'Short Sprint Standards', 'Virginia', '24', 1, 0, 0, 0, '2', 1, 1, '56', 1),
('45', '13-04', 'The Roscoe Rattle', 'Virginia', '18', 1, 0, 0, 0, '2', 0, 0, '27', 1),
('46', '13-05', 'Tick Tock', 'Virginia', '16', 1, 0, 1, 0, '', 0, 0, '21', 1),
('47', '13-06', 'Too Close For Comfort', 'Virginia', '10', 1, 0, 0, 0, '', 0, 0, '32', 1),
('48', '09-08', 'Crackerjack', 'Comstock', '12', 0, 0, 0, 0, '', 0, 1, '50', 1),
('49', '13-08', 'More Disaster Factor', 'Virginia', '12', 1, 0, 0, 0, '', 0, 0, '31', 1),
('5', '03-08', 'Maddness', 'Virginia', '14', 1, 0, 0, 0, '', 0, 0, '30', 1),
('50', '13-09', 'Window Pain', 'Comstock', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('51', '18-01', 'Of Course I Did', 'Virginia', '24', 1, 0, 0, 0, '', 0, 1, '45', 1),
('52', '18-02', 'What is With You People', 'Comstock', '12', 1, 0, 0, 0, '', 0, 0, '75', 1),
('53', '18-03', 'We Play Games', 'Virginia', '24', 1, 0, 0, 0, '', 0, 1, '30', 1),
('54', '18-04', 'Didn\'t You Send the Mailman', 'Virginia', '6', 1, 0, 0, 0, '', 0, 0, '45', 1),
('55', '18-05', 'No Need to Believe Either Side', 'Comstock', '16', 1, 0, 0, 0, '', 0, 0, '40', 1),
('56', '18-06', 'For the Day', 'Virginia', '18', 1, 0, 0, 0, '', 0, 0, '45', 1),
('57', '18-07', 'Someone is Always Willing to Pay', 'Comstock', '8', 1, 0, 0, 0, '', 0, 0, '36', 1),
('58', '18-08', 'The Condor', 'Virginia', '16', 1, 0, 0, 0, '', 0, 1, '39', 1),
('59', '18-09', 'I Miss That Kind of Clarity', 'Virginia', '24', 1, 0, 0, 0, '', 0, 1, '40', 1),
('6', '99-23', 'Front Sight', 'Virginia', '12', 0, 0, 0, 0, '2', 0, 0, '21', 1),
('60', '99-40', 'Partial People Eaters', 'Fixed Time', '24', 0, 0, 0, 0, '4', 1, 0, '60', 1),
('61', '09-10', 'Life\'s Little Problems', 'Comstock', '12', 0, 0, 0, 0, '', 0, 1, '11', 1),
('62', '20-02', 'déjà vu', 'Comstock', '12', 0, 0, 0, 0, '', 0, 1, '16', 1),
('63', '20-03', 'déjà vu All Over Again', 'Comstock', '12', 0, 0, 0, 0, '', 0, 1, '16', 1),
('64', '99-47', 'Triple Choice', 'Virginia', '15', 0, 0, 0, 0, '3', 0, 0, '25', 1),
('65', '03-09', 'On the Move', 'Virginia', '16', 0, 0, 0, 0, '2', 0, 1, '30', 1),
('66', '06-01', 'Big Barricade', 'Comstock', '14', 0, 1, 0, 0, '1', 0, 1, '33', 1),
('67', '99-01', 'Back to Basics Standards', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('68', '19-04', 'Ho Cost of Living', 'Comstock', '14', 0, 0, 0, 0, '', 0, 1, '34', 1),
('69', '99-03', 'Celeritas and Diligentia', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('7', '03-10', 'Area 5 Standards', 'Virginia', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('70', '99-04', 'American Standard', 'Comstock', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('71', '99-05', 'Mob Job', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('72', '99-06', 'Toe The Line', 'Virginia', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('73', '20-01', 'Wish You Were Here', 'Comstock', '12', 0, 0, 0, 0, '', 0, 1, '34', 1),
('74', '09-13', 'Table Stakes', 'Comstock', '7', 0, 0, 0, 0, '', 0, 0, '35', 1),
('75', '99-09', 'Long Range Standards', 'Virginia', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('76', '99-08', 'Melody Line', 'Virginia', '12', 1, 0, 0, 0, '', 0, 0, '30', 1),
('77', '06-10', 'Steely Speed VII', 'Comstock', '6', 0, 0, 0, 0, '', 0, 0, '36', 1),
('78', '99-11', 'El Presidente', 'Virginia', '12', 1, 0, 0, 0, '', 0, 0, '30', 1),
('79', '99-12', 'Take Your Choice', 'Comstock', '12', 1, 1, 0, 0, '', 0, 0, '40', 1),
('8', '03-11', 'El Strong & Weak Pres', 'Virginia', '24', 1, 0, 0, 0, '2', 0, 0, '30', 1),
('80', '99-13', 'Quicky II', 'Virginia', '24', 1, 0, 0, 0, '2', 1, 0, '30', 1),
('81', '99-15', 'Dilegentia and Celeritas', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('82', '99-10', 'Times Two', 'Comstock', '12', 0, 0, 0, 0, '', 0, 1, '36', 1),
('83', '99-17', 'Its All in the Upper Zone', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('84', '99-18', 'You Snooze, You Lose', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('85', '99-16', 'Both Sides Now #2', 'Comstock', '12', 1, 1, 0, 0, '', 0, 0, '35', 1),
('86', '99-20', 'Fish House Encounter', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('87', '99-19', 'Paynes Pain', 'Virginia', '12', 1, 0, 0, 0, '', 0, 0, '30', 1),
('88', '99-21', 'Mini Mart', 'Virginia', '12', 1, 0, 0, 1, '', 0, 0, '18', 1),
('89', '99-22', 'Nueve El Presidente', 'Virginia', '12', 1, 0, 0, 0, '', 0, 0, '30', 1),
('9', '99-24', 'Front Sight 2', 'Virginia', '12', 0, 0, 0, 0, '2', 0, 0, '21', 1),
('90', '99-62', 'Bang and Clang', 'Comstock', '6', 0, 0, 0, 0, '', 0, 0, '36', 1),
('91', '99-27', 'Leftys Revenge', 'Comstock', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('92', '19-01', 'Hi-Jinx', 'Comstock', '12', 0, 0, 0, 0, '', 0, 1, '37', 1),
('93', '99-29', 'Near to Far Standards', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('94', '99-30', 'Man Down', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('95', '99-31', 'Slow But Sure', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('96', '99-32', 'Indoor Rapid Fire Standards', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('97', '99-28', 'Hillbillton Drill', 'Comstock', '12', 1, 0, 0, 0, '', 0, 0, '41', 1),
('98', '99-34', 'Ported View', 'Comstock', '-', 1, 0, 0, 0, '', 0, 0, '', 0),
('99', '99-35', 'Xmas', '', '-', 1, 0, 0, 0, '', 0, 0, '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ccs_classifiers`
--
ALTER TABLE `ccs_classifiers`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
