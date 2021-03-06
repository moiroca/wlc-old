CREATE DATABASE  IF NOT EXISTS `wlcinventory` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `wlcinventory`;
-- MySQL dump 10.13  Distrib 5.6.19, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: wlcinventory
-- ------------------------------------------------------
-- Server version	5.6.19-1~exp1ubuntu2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `area_items`
--

DROP TABLE IF EXISTS `area_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_items` (
  `area_id` int(100) NOT NULL,
  `item_id` int(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `actor_id` int(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_items`
--

LOCK TABLES `area_items` WRITE;
/*!40000 ALTER TABLE `area_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `area_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department_areas`
--

DROP TABLE IF EXISTS `department_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department_areas` (
  `department_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department_areas`
--

LOCK TABLES `department_areas` WRITE;
/*!40000 ALTER TABLE `department_areas` DISABLE KEYS */;
/*!40000 ALTER TABLE `department_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department_heads`
--

DROP TABLE IF EXISTS `department_heads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department_heads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `datetime_added` datetime NOT NULL,
  `datetime_deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department_heads`
--

LOCK TABLES `department_heads` WRITE;
/*!40000 ALTER TABLE `department_heads` DISABLE KEYS */;
/*!40000 ALTER TABLE `department_heads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_replacement`
--

DROP TABLE IF EXISTS `item_replacement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_replacement` (
  `replaced_item_id` int(11) NOT NULL,
  `replacement_item_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_replacement`
--

LOCK TABLES `item_replacement` WRITE;
/*!40000 ALTER TABLE `item_replacement` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_replacement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg` varchar(255) NOT NULL,
  `viewed` enum('TRUE','FALSE') DEFAULT 'FALSE',
  `recepient_id` int(11) NOT NULL,
  `datetime_sent` datetime NOT NULL,
  `datetime_viewed` datetime NOT NULL,
  `sender_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requisition_comments`
--

DROP TABLE IF EXISTS `requisition_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requisition_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requisition_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `datetime_added` datetime NOT NULL,
  `datetime_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requisition_comments`
--

LOCK TABLES `requisition_comments` WRITE;
/*!40000 ALTER TABLE `requisition_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `requisition_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requisition_status`
--

DROP TABLE IF EXISTS `requisition_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requisition_status` (
  `requisition_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('Pending','Item Verified By President','Noted By Department Head','Declined By Department Head','Verified By Property Custodian','Declined By Property Custodian','Verified By GSD Officer','Declined By GSD Officer','Approved By Treasurer','Declined By Treasurer','Approved By Comptroller','Declined By Comptroller','Approved By President','Declined By President','Released By Property Custodian','Released By GSD Officer','Received By Requester') DEFAULT NULL,
  `datetime_added` datetime DEFAULT NULL,
  `datetime_deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requisition_status`
--

LOCK TABLES `requisition_status` WRITE;
/*!40000 ALTER TABLE `requisition_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `requisition_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requisitions`
--

DROP TABLE IF EXISTS `requisitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requisitions` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `requester_id` varchar(50) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `control_identifier` varchar(45) NOT NULL,
  `area_id` int(11) NOT NULL,
  `datetime_added` datetime NOT NULL,
  `datetime_deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requisitions`
--

LOCK TABLES `requisitions` WRITE;
/*!40000 ALTER TABLE `requisitions` DISABLE KEYS */;
/*!40000 ALTER TABLE `requisitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_requisitions`
--

DROP TABLE IF EXISTS `stock_requisitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_requisitions` (
  `requisition_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `changeTo` enum('Good Condition','New Condition','Fair Condition','Poor Condition','Obsolete') DEFAULT NULL,
  `fromStatus` enum('Good Condition','New Condition','Fair Condition','Poor Condition','Obsolete') DEFAULT NULL,
  `status` enum('For Receiving','Received','For Approval','Approved','For Repair','Repaired','Declined','Obsolete','For Replacement','Replaced') DEFAULT NULL COMMENT 'ENUM(''For Receiving'',''Repaired'',''For Approval'',''Approved'',''For Repair'',''Repaired'',''Declined'',''Obsolete'',''For Replacement'',''Replaced'')',
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_requisitions`
--

LOCK TABLES `stock_requisitions` WRITE;
/*!40000 ALTER TABLE `stock_requisitions` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_requisitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `control_number` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `datetime_added` datetime NOT NULL,
  `datetime_updated` datetime NOT NULL,
  `datetime_deleted` datetime NOT NULL,
  `type` enum('Office Supply','Material and Equipment') NOT NULL,
  `price` float DEFAULT NULL,
  `isRequest` enum('TRUE','FALSE') NOT NULL DEFAULT 'TRUE',
  `unit` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks_status`
--

DROP TABLE IF EXISTS `stocks_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks_status` (
  `stock_id` int(11) NOT NULL,
  `status` enum('Deleted','Good Condition','New Condition','Fair Condition','Poor Condition','Obsolete') DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `actor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks_status`
--

LOCK TABLES `stocks_status` WRITE;
/*!40000 ALTER TABLE `stocks_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `stocks_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_departments`
--

DROP TABLE IF EXISTS `user_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_departments` (
  `user_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_departments`
--

LOCK TABLES `user_departments` WRITE;
/*!40000 ALTER TABLE `user_departments` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `status` enum('Active','Inactive','Deleted') NOT NULL,
  `type` varchar(30) NOT NULL,
  `datetime_added` datetime NOT NULL,
  `datetime_updated` varchar(45) NOT NULL,
  `datetime_deleted` varchar(45) NOT NULL,
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`id`),
  UNIQUE KEY `user_id_2` (`id`),
  UNIQUE KEY `user_id_3` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10090 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10013,'mae','5f4dcc3b5aa765d61d8327deb882cf99','Soria','Mae','Gonzalez','Active','Inventory Officer','2015-11-29 15:34:21','','',2),(10086,'comptroller','5f4dcc3b5aa765d61d8327deb882cf99','Chu','Kim','Magalona','Deleted','Employee','2016-01-26 21:42:02','','2016-02-09 22:28:42',1),(10088,'employee','5f4dcc3b5aa765d61d8327deb882cf99','Zubiri','Diana ','Magalona','Deleted','Employee','2016-01-26 21:53:14','','2016-02-09 22:28:36',1),(10089,'employee2','5f4dcc3b5aa765d61d8327deb882cf99','Gibson','Mel','Franco','Deleted','Employee','2016-01-26 22:43:12','','2016-02-09 22:28:30',1),(10084,'department_head','5f4dcc3b5aa765d61d8327deb882cf99','Ramos','Rhean ','Magalona','Active','Department Head','2016-01-26 21:38:44','','',1),(10085,'president','5f4dcc3b5aa765d61d8327deb882cf99','Magalona','Maxin ','Magalona','Active','President','2016-01-26 21:41:13','','',1),(10083,'property_custodian','5f4dcc3b5aa765d61d8327deb882cf99','Alonzo','Bea','Magalona','Active','Property Custodian','2016-01-26 21:37:29','','',1),(10082,'gsd_officer','5f4dcc3b5aa765d61d8327deb882cf99','Locsin','Angel','Magalona','Active','GSD Officer','2016-01-26 21:36:35','','',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-22 23:50:44
