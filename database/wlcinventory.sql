-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 28, 2015 at 02:16 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wlcinventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `area_dept`
--

CREATE TABLE IF NOT EXISTS `area_dept` (
  `area_id` int(11) NOT NULL auto_increment,
  `area_name` varchar(150) NOT NULL,
  `dept_dean` varchar(100) NOT NULL,
  `area_status` enum('Displayed','Deleted') NOT NULL,
  PRIMARY KEY  (`area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4452 ;

--
-- Dumping data for table `area_dept`
--

INSERT INTO `area_dept` (`area_id`, `area_name`, `dept_dean`, `area_status`) VALUES
(1, 'CICTE(Office)', 'Mrs. Cheryl M. Tarre, MST. DBA (cand.)', 'Displayed'),
(2, 'HRM', 'Mr. Jose Randy R. Lupango, MMBM', 'Displayed'),
(4449, 'Education', 'Mr. Ramon R. Romano', 'Displayed'),
(4451, 'Law', 'Atty. Evergisto S. Escalon', 'Displayed');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int(50) NOT NULL,
  `item_area` varchar(100) NOT NULL,
  `item_description` varchar(200) NOT NULL,
  `item_quantity` int(50) NOT NULL,
  `item_status` varchar(30) NOT NULL,
  `area_id` int(100) NOT NULL,
  PRIMARY KEY  (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_area`, `item_description`, `item_quantity`, `item_status`, `area_id`) VALUES
(366, 'Lab 4', 'Eraser', 5, 'Good Condition', 1),
(369, 'Lab 1', 'CCTV', 30, 'Good Condition', 2),
(377, 'Chemistry Lab', 'Chairs', 50, 'Good Condition', 2),
(503, 'Physics Lab', 'Table', 48, 'Good Condition', 1),
(9900, 'Lab 4', 'CD', 24, 'Good Condition', 1),
(1, 'Chemistry Lab', 'Testing', 12, 'For Replace', 1),
(12121, 'Physics Lab', 'Tester', 12, 'For Repair', 1),
(212, 'Lab 4 ', 'Floor wax', 3, 'Good Condition', 1),
(99001, 'Lab 4', 'CD', 24, 'Deleted', 1),
(45454, 'Llb3004', 'Chairs', 25, 'Good Condition', 4451),
(90000, 'Room 107', 'White Board', 2, 'Good Condition', 4449);

-- --------------------------------------------------------

--
-- Table structure for table `itemstatus`
--

CREATE TABLE IF NOT EXISTS `itemstatus` (
  `status_id` int(50) NOT NULL auto_increment,
  `item_status` varchar(100) NOT NULL,
  PRIMARY KEY  (`status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `itemstatus`
--

INSERT INTO `itemstatus` (`status_id`, `item_status`) VALUES
(1, 'Good Condition'),
(2, 'For Repair'),
(3, 'For Replace'),
(4, 'Deleted');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`user_id`, `date`, `time`) VALUES
(444, '2015-09-26', '13:56:25'),
(444, '2015-09-24', '10:35:25'),
(444, '2015-09-23', '08:43:46'),
(444, '2015-09-22', '21:04:45'),
(444, '2015-09-21', '21:03:10'),
(444, '2015-09-21', '14:26:07'),
(444, '2015-09-19', '15:42:09'),
(444, '2015-09-11', '08:53:45'),
(444, '2015-09-09', '15:23:01'),
(444, '2015-09-09', '14:47:51'),
(444, '2015-09-05', '14:05:25'),
(444, '2015-09-03', '21:28:36'),
(444, '2015-08-10', '14:40:48'),
(444, '2015-08-11', '23:54:49'),
(444, '2015-08-15', '21:17:27'),
(444, '2015-08-15', '23:24:21'),
(444, '2015-09-01', '22:27:32'),
(444, '2015-09-01', '23:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `repaired`
--

CREATE TABLE IF NOT EXISTS `repaired` (
  `repaired_id` int(100) NOT NULL,
  `requisition_id` int(100) NOT NULL,
  `repaired_date` date NOT NULL,
  PRIMARY KEY  (`repaired_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `repaired`
--


-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `report_id` int(100) NOT NULL auto_increment,
  `item_id` varchar(100) NOT NULL,
  `item_area` varchar(100) NOT NULL,
  `item_description` varchar(100) NOT NULL,
  `item_quantity` varchar(100) NOT NULL,
  `item_status` varchar(100) NOT NULL,
  `daterange_id` varchar(100) NOT NULL,
  `area_id` varchar(100) NOT NULL,
  PRIMARY KEY  (`report_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `report`
--


-- --------------------------------------------------------

--
-- Table structure for table `requisition`
--

CREATE TABLE IF NOT EXISTS `requisition` (
  `requisition_id` int(50) NOT NULL auto_increment,
  `area_id` int(50) NOT NULL,
  `item_id` varchar(50) NOT NULL,
  `item_area` varchar(100) NOT NULL,
  `item_quantity` int(50) NOT NULL,
  `item_status` varchar(100) NOT NULL,
  `requisition_date` date NOT NULL,
  `requisition_status` enum('Ongoing','Pending','Solved') NOT NULL,
  `item_purpose` varchar(200) NOT NULL,
  PRIMARY KEY  (`requisition_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `requisition`
--

INSERT INTO `requisition` (`requisition_id`, `area_id`, `item_id`, `item_area`, `item_quantity`, `item_status`, `requisition_date`, `requisition_status`, `item_purpose`) VALUES
(40, 1, '212 ', 'Lab 4  ', 1, 'For Repair', '2015-09-22', 'Pending', ' 3fsdfa'),
(39, 1, '212 ', 'Lab 4  ', 1, 'For Repair', '2015-09-22', 'Pending', ' asdfasd'),
(38, 1, '212 ', 'Lab 4  ', 1, 'For Repair', '2015-09-22', 'Pending', ' sfasdf'),
(37, 1, '366 ', 'Lab 4 ', 3, 'For Repair', '2015-09-22', 'Pending', 'asdfasdf'),
(36, 1, '366 ', 'Lab 4 ', 1, 'For Repair', '2015-09-22', 'Pending', ' '),
(34, 1, '503 ', 'Physics Lab ', 4, 'For Repair', '2015-09-22', 'Pending', 'Broken Legs'),
(35, 1, '12121 ', 'Physics Lab ', 10, 'For Repair', '2015-09-22', 'Pending', ' not working'),
(41, 1, '12121 ', 'Physics Lab ', 10, 'For Repair', '2015-09-22', 'Pending', ' asfasdf'),
(42, 1, '366 ', 'Lab 4 ', 2, 'For Repair', '2015-09-22', 'Pending', 'old stock'),
(43, 1, '366 ', 'Lab 4 ', 2, 'For Repair', '2015-09-22', 'Pending', ' ffffffffffffffffffffffff'),
(44, 1, '212 ', 'Lab 4  ', 1, 'For Repair', '2015-09-22', 'Pending', ' aaaaaaaaaaa'),
(45, 1, '366 ', 'Lab 4 ', 3, 'For Repair', '2015-09-22', 'Pending', 'fdsdf'),
(46, 1, '366 ', 'Lab 4 ', 4, 'For Repair', '2015-09-22', 'Pending', ' 444444'),
(47, 1, '366 ', 'Lab 4 ', 2, 'For Repair', '2015-09-22', 'Pending', ' asdfasdfasdfasd'),
(48, 1, '366 ', 'Lab 4 ', 1, 'For Repair', '2015-09-22', 'Pending', '11111111111111111111'),
(49, 1, '212 ', 'Lab 4  ', 2, 'For Repair', '2015-09-22', 'Pending', ' 2222222222222222222222'),
(50, 1, '366 ', 'Lab 4 ', 4, 'For Repair', '2015-09-22', 'Pending', ' sdfasdfasf1'),
(51, 1, '212 ', 'Lab 4  ', 2, 'For Repair', '2015-09-22', 'Pending', ' sfasdfdfds2'),
(52, 1, '366 ', 'Lab 4 ', 2, 'For Repair', '2015-09-22', 'Pending', ' sfasdfasdfasdfasdfasd'),
(53, 1, '366 ', 'Lab 4 ', 2, 'For Repair', '2015-09-22', 'Pending', ' sdASDASDas');

-- --------------------------------------------------------

--
-- Table structure for table `requisition_replace`
--

CREATE TABLE IF NOT EXISTS `requisition_replace` (
  `replace_id` int(50) NOT NULL auto_increment,
  `area_id` int(50) NOT NULL,
  `item_id` varchar(50) NOT NULL,
  `item_area` varchar(100) NOT NULL,
  `item_quantity` int(50) NOT NULL,
  `item_status` varchar(100) NOT NULL,
  `requisition_date` date NOT NULL,
  `requisition_status` enum('Ongoing','Pending','Solved') NOT NULL,
  PRIMARY KEY  (`replace_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `requisition_replace`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_pass` varchar(100) NOT NULL,
  `user_lastname` varchar(100) NOT NULL,
  `user_firstname` varchar(100) NOT NULL,
  `user_middle` varchar(50) NOT NULL,
  `user_status` enum('Active','Inactive','Deleted') NOT NULL,
  `user_type` varchar(30) NOT NULL,
  `user_logs` datetime NOT NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `user_id_2` (`user_id`),
  UNIQUE KEY `user_id_3` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_email`, `user_pass`, `user_lastname`, `user_firstname`, `user_middle`, `user_status`, `user_type`, `user_logs`) VALUES
(444, 'mae', 'soria', 'Soria', 'Fatima Mae', 'Gonzales', 'Active', 'Admin', '2015-09-26 13:56:25'),
(10011, 'admin', 'aaa', 'Inventory', 'WLC', 'admin', 'Deleted', 'Admin', '2015-06-30 21:32:30'),
(479, 'pamii', 'labra', 'Labra', 'Famela', 'A', 'Active', 'Admin', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `type_id` int(30) NOT NULL,
  `user_type` varchar(100) NOT NULL,
  PRIMARY KEY  (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`type_id`, `user_type`) VALUES
(1, 'Admin'),
(2, 'GSD Officer'),
(3, 'Inventory Officer'),
(4, 'President'),
(5, 'Dean');
