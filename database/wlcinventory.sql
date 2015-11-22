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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (1,'Good Condition'),(2,'For Repair'),(3,'For Replace'),(4,'Deleted');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
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
  `dean_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4452 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'CICTE(Office)','Mrs. Cheryl M. Tarre, MST. DBA (cand.)'),(2,'HRM','Mr. Jose Randy R. Lupango, MMBM'),(4449,'Education','Mr. Ramon R. Romano'),(4451,'Law','Atty. Evergisto S. Escalon');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requisitions`
--

DROP TABLE IF EXISTS `requisitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requisitions` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `type` int(50) NOT NULL,
  `requester_id` varchar(50) NOT NULL,
  `provider_id` varchar(100) NOT NULL,
  `purpose` int(50) NOT NULL,
  `datetime_added` date NOT NULL,
  `datetime_provided` enum('Ongoing','Pending','Solved') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requisitions`
--

LOCK TABLES `requisitions` WRITE;
/*!40000 ALTER TABLE `requisitions` DISABLE KEYS */;
INSERT INTO `requisitions` VALUES (40,1,'212 ','Lab 4  ',1,'2015-09-22','Pending'),(39,1,'212 ','Lab 4  ',1,'2015-09-22','Pending'),(38,1,'212 ','Lab 4  ',1,'2015-09-22','Pending'),(37,1,'366 ','Lab 4 ',3,'2015-09-22','Pending'),(36,1,'366 ','Lab 4 ',1,'2015-09-22','Pending'),(34,1,'503 ','Physics Lab ',4,'2015-09-22','Pending'),(35,1,'12121 ','Physics Lab ',10,'2015-09-22','Pending'),(41,1,'12121 ','Physics Lab ',10,'2015-09-22','Pending'),(42,1,'366 ','Lab 4 ',2,'2015-09-22','Pending'),(43,1,'366 ','Lab 4 ',2,'2015-09-22','Pending'),(44,1,'212 ','Lab 4  ',1,'2015-09-22','Pending'),(45,1,'366 ','Lab 4 ',3,'2015-09-22','Pending'),(46,1,'366 ','Lab 4 ',4,'2015-09-22','Pending'),(47,1,'366 ','Lab 4 ',2,'2015-09-22','Pending'),(48,1,'366 ','Lab 4 ',1,'2015-09-22','Pending'),(49,1,'212 ','Lab 4  ',2,'2015-09-22','Pending'),(50,1,'366 ','Lab 4 ',4,'2015-09-22','Pending'),(51,1,'212 ','Lab 4  ',2,'2015-09-22','Pending'),(52,1,'366 ','Lab 4 ',2,'2015-09-22','Pending'),(53,1,'366 ','Lab 4 ',2,'2015-09-22','Pending');
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
  `status` varchar(30) NOT NULL,
  `area_id` int(100) NOT NULL,
  `datetime_added` datetime NOT NULL,
  `datetime_updated` datetime NOT NULL,
  `datetime_deleted` datetime NOT NULL,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1448121716 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES (366,'Lab 4','Eraser','Good Condition',1,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(369,'Lab 1','CCTV','Good Condition',2,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(377,'Chemistry Lab','Chairs','Good Condition',2,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(503,'Physics Lab','Table','Good Condition',1,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(9900,'Lab 4','CD','Good Condition',1,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(1,'Chemistry Lab','Testing','For Replace',1,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(12121,'Physics Lab','Tester','For Repair',1,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(212,'Lab 4 ','Floor wax','Good Condition',1,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(99001,'Lab 4','CD','Deleted',1,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(45454,'Llb3004','Chairs','Good Condition',4451,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(90000,'Room 107','White Board','Good Condition',4449,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(1448121146,'32','12','For Repair',2,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(1448121616,'21312','12312','For Repair',2,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(1448121696,'123','1','For Repair',2,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(1448121697,'1518558011233115','Testing','Good Condition',1,'2015-11-23 00:29:33','0000-00-00 00:00:00','0000-00-00 00:00:00','Material'),(1448121698,'1518558114502889','Testing','Good Condition',1,'2015-11-23 00:31:11','0000-00-00 00:00:00','0000-00-00 00:00:00','Material'),(1448121699,'1518558114520880','Testing','Good Condition',1,'2015-11-23 00:31:11','0000-00-00 00:00:00','0000-00-00 00:00:00','Material'),(1448121700,'1518559317836782','Tool Name','For Replace',1,'2015-11-23 00:50:19','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121701,'1518559317917582','Tool Name','For Replace',1,'2015-11-23 00:50:19','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121702,'1518559317918189','Tool Name','For Replace',1,'2015-11-23 00:50:19','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121703,'1518559317918863','Tool Name','For Replace',1,'2015-11-23 00:50:19','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121704,'1518559335916316','Tool Name','For Replace',1,'2015-11-23 00:50:36','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121705,'1518559335919421','Tool Name','For Replace',1,'2015-11-23 00:50:36','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121706,'1518559335923562','Tool Name','For Replace',1,'2015-11-23 00:50:36','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121707,'1518559335925015','Tool Name','For Replace',1,'2015-11-23 00:50:36','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121708,'1518559471639683','Testing Tool','For Replace',3,'2015-11-23 00:52:46','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121709,'1518559471640278','Testing Tool','For Replace',3,'2015-11-23 00:52:46','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121710,'1518559471640731','Testing Tool','For Replace',3,'2015-11-23 00:52:46','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121711,'1518559514506178','Kamaguchi','For Repair',4,'2015-11-23 00:53:26','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121712,'1518559514506790','Kamaguchi','For Repair',4,'2015-11-23 00:53:26','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121713,'1518559514508451','Kamaguchi','For Repair',4,'2015-11-23 00:53:26','0000-00-00 00:00:00','0000-00-00 00:00:00','Tools'),(1448121714,'1518559554696470','Testing','Good Condition',1,'2015-11-23 00:54:05','0000-00-00 00:00:00','0000-00-00 00:00:00','Material'),(1448121715,'1518559554697747','Testing','Good Condition',1,'2015-11-23 00:54:05','0000-00-00 00:00:00','0000-00-00 00:00:00','Material');
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`id`),
  UNIQUE KEY `user_id_2` (`id`),
  UNIQUE KEY `user_id_3` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10012 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (444,'mae','soria','Soria','Fatima Mae','Gonzales','Active','Inventory Officer','0000-00-00 00:00:00','',''),(10011,'admin','aaa','Inventory','WLC','admin','Deleted','Admin','0000-00-00 00:00:00','',''),(479,'pamii','labra','Labra','Famela','A','Active','Admin','0000-00-00 00:00:00','','');
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

-- Dump completed on 2015-11-23  1:20:18
