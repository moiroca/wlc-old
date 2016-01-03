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
  `item_id` int(100) NOT NULL
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
  `datetime_added` datetime NOT NULL,
  `status` varchar(45) NOT NULL,
  `control_identifier` varchar(45) NOT NULL,
  `area_id` int(11) NOT NULL,
  `datetime_approveddeclined_by_gsd_officer` datetime DEFAULT NULL,
  `datetime_approveddeclined_by_president` datetime DEFAULT NULL,
  `gsd_officer_id` int(50) DEFAULT NULL,
  `president_id` int(50) DEFAULT NULL,
  `department_head_id` int(50) DEFAULT NULL,
  `comptroller_id` int(50) DEFAULT NULL,
  `property_custodian_id` int(50) DEFAULT NULL,
  `treasurer_id` int(50) DEFAULT NULL,
  `datetime_approveddeclined_by_comptroller` datetime DEFAULT NULL,
  `datetime_approveddeclined_by_property_custodian` datetime DEFAULT NULL,
  `datetime_approveddeclined_by_department_head` datetime DEFAULT NULL,
  `datetime_approveddeclined_by_treasurer` datetime DEFAULT NULL,
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
  `stock_id` varchar(45) NOT NULL
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
  `status` enum('GOOD CONDITION','FOR REPLACE','FOR REPARIR','DELETED') NOT NULL DEFAULT 'GOOD CONDITION',
  `datetime_added` datetime NOT NULL,
  `datetime_updated` datetime NOT NULL,
  `datetime_deleted` datetime NOT NULL,
  `type` enum('Office Supply','Material and Equipment') NOT NULL,
  `price` float DEFAULT NULL,
  `isRequest` enum('TRUE','FALSE') NOT NULL DEFAULT 'TRUE',
  `area_id` int(50) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=10062 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10013,'mae','5f4dcc3b5aa765d61d8327deb882cf99','Soria','Mae','Gonzalez','Active','Inventory Officer','2015-11-29 15:34:21','','',2),(10018,'ella','5f4dcc3b5aa765d61d8327deb882cf99','Caranyagan','Tita Ella','Rosales','Active','GSD Officer','2015-12-07 21:24:02','','',1),(10019,'daniel','5f4dcc3b5aa765d61d8327deb882cf99','Roca','Daniel','Homeres','Active','President','2015-12-13 22:28:32','','',1),(10020,'nino','5f4dcc3b5aa765d61d8327deb882cf99','Siose','Nino','Mabihinhigan','Active','Property Custodian','2015-12-30 11:58:52','','',1),(10061,'comptroller','5f4dcc3b5aa765d61d8327deb882cf99','Comptroller','John','John','Active','Comptroller','2015-12-31 14:29:32','','',1),(10059,'testing','5f4dcc3b5aa765d61d8327deb882cf99','employs','ladis','employs','Active','Employee','2015-12-31 14:28:51','','',1),(10060,'temp','5f4dcc3b5aa765d61d8327deb882cf99','Department Head','New','testing','Active','Department Head','2015-12-31 14:29:32','','',1);
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

-- Dump completed on 2016-01-03 13:42:22
