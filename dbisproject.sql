-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: localhost    Database: dbisproject
-- ------------------------------------------------------
-- Server version	5.7.27-0ubuntu0.18.04.1

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `admin_id` varchar(30) DEFAULT NULL,
  `admin_password` varchar(20) DEFAULT NULL,
  `admin_wallet` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('admin','admin',0);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery`
--

DROP TABLE IF EXISTS `delivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery` (
  `packaging_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) unsigned NOT NULL,
  `isfree` bit(1) NOT NULL,
  `service_id` varchar(30) DEFAULT NULL,
  `service_name` varchar(30) DEFAULT NULL,
  `date_of_packaging` date DEFAULT NULL,
  `delivery_address` varchar(100) DEFAULT NULL,
  `pickup_address` varchar(100) DEFAULT NULL,
  `delivery_status` varchar(30) NOT NULL,
  `sent_status` bit(1) NOT NULL,
  `rec_status` bit(1) NOT NULL,
  `delivery_fees` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`packaging_id`),
  UNIQUE KEY `packaging_id` (`packaging_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery`
--

LOCK TABLES `delivery` WRITE;
/*!40000 ALTER TABLE `delivery` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `item_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `issuer_id` varchar(30) NOT NULL,
  `item_name` varchar(30) NOT NULL,
  `tag` varchar(20) DEFAULT NULL,
  `photo` blob,
  `status` varchar(20) NOT NULL,
  `interest` decimal(10,0) NOT NULL,
  `security_deposit` decimal(10,0) NOT NULL,
  `max_lend_days` int(11) NOT NULL,
  `image_name` varchar(50) DEFAULT 'default.jpeg',
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_id` (`item_id`),
  KEY `issuer_id` (`issuer_id`),
  CONSTRAINT `issuer_id` FOREIGN KEY (`issuer_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (9,'170010007@iitdh.ac.in','Mattress','Lifestyle',NULL,'Available',100,500,10,'matress.jpeg'),(10,'170010007@iitdh.ac.in','Life of Pie','Book',NULL,'Available',10,50,20,'Lifeofpie.jpeg'),(11,'170010007@iitdh.ac.in','Redmi Note 5','Mobile',NULL,'Available',500,3000,30,'redminote5.jpeg'),(12,'170010002@iitdh.ac.in','20 Chairs','Lifestyle',NULL,'Available',5,10,2,'extensionboards.jpeg'),(13,'170010002@iitdh.ac.in','20 Tables','Lifestyle',NULL,'Available',5,10,2,'cycle.jpeg'),(14,'170010002@iitdh.ac.in','30 Beds','Lifestyle',NULL,'Available',200,500,10,'almirah.jpeg'),(15,'170010004@iitdh.ac.in','10 Extension Boards','Electrical Equipment',NULL,'Available',50,100,15,'extensionboards.jpeg'),(16,'170010004@iitdh.ac.in','Cycle','Adventure Equipment',NULL,'Available',500,1000,20,'cycle.jpeg'),(17,'170010004@iitdh.ac.in','Almirah','Lifestyle',NULL,'Available',500,1000,200,'almirah.jpeg'),(18,'170010007@iitdh.ac.in','2 States','Book',NULL,'Available',30,70,20,'2states.jpeg'),(19,'170010002@iitdh.ac.in','Lenovo Ideapad 2020','Electronic',NULL,'Available',1000,5000,30,'default.jpeg');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `transaction_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) unsigned NOT NULL,
  `borrower_id` varchar(30) NOT NULL,
  `returning_date` date DEFAULT NULL,
  `borrowing_date` date DEFAULT NULL,
  `packaging1_id` bigint(20) unsigned NOT NULL,
  `packaging2_id` bigint(20) unsigned NOT NULL,
  `ongoing_status` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  UNIQUE KEY `transaction_id` (`transaction_id`),
  KEY `item_id` (`item_id`),
  KEY `borrower_id` (`borrower_id`),
  KEY `packaging1_id` (`packaging1_id`),
  KEY `packaging2_id` (`packaging2_id`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`borrower_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (39,12,'170010007@iitdh.ac.in','2019-11-17','2019-11-17',1234,1234,'completed'),(40,10,'170010002@iitdh.ac.in','2019-11-17','2019-11-17',1234,1234,'completed'),(41,10,'170010004@iitdh.ac.in','2019-11-17','2019-11-17',1234,1234,'completed'),(42,9,'170010004@iitdh.ac.in','2019-11-17','2019-11-17',1234,1234,'completed'),(43,10,'170010004@iitdh.ac.in','2019-11-18','2019-11-18',1234,1234,'completed'),(50,16,'170010002@iitdh.ac.in','2019-11-18','2019-11-18',1234,1234,'completed'),(51,19,'170010004@iitdh.ac.in','2019-11-18','2019-11-18',1234,1234,'completed'),(52,19,'170010004@iitdh.ac.in','2019-11-18','2019-11-18',1234,1234,'completed'),(53,9,'170010002@iitdh.ac.in','2019-11-18','2019-11-18',1234,1234,'completed'),(54,9,'170010002@iitdh.ac.in','2019-11-18','2019-11-18',1234,1234,'completed'),(55,17,'170010002@iitdh.ac.in','2019-11-18','2019-11-18',1234,1234,'completed');
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` varchar(30) NOT NULL,
  `user_password` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `email_id` varchar(30) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `account_num` varchar(30) DEFAULT NULL,
  `bank_name` varchar(30) DEFAULT NULL,
  `ifsc_code` varchar(30) DEFAULT NULL,
  `wallet` float DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('170010002@iitdh.ac.in','student2','Ameya Vadnere','9876543210','170010002@iitdh.ac.in','Hostel 3, Abheri','678954321234','Canara','CNB54325433',50835),('170010004@iitdh.ac.in','student3','Ojas Raundale','7896432156','170010004@iitdh.ac.in','Hostel 3, Abheri','678954321678','Bank of Baroda','BOB54685439',21260),('170010007@iitdh.ac.in','student1','Prateek Jain','8279803383','170010007@iitdh.ac.in','Hostel 3, Abheri','190823457632','SBI','SBI65432456',825);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-18  3:31:10
