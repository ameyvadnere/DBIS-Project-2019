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
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_id` (`item_id`),
  KEY `issuer_id` (`issuer_id`),
  CONSTRAINT `issuer_id` FOREIGN KEY (`issuer_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (1,'Oj','Redmi Note 4',NULL,NULL,'Available',10,100,100),(2,'PJ','Mattress',NULL,NULL,'Available',100,500,10),(3,'Oj','Sony headphone','headphone',NULL,'Available',12,120,12),(4,'Oj','Tupperware bottle','',NULL,'Available',10,10,10),(5,'Oj','Lenovo PowerBank','',NULL,'Not Available',123,124,1),(6,'Oj','Adidas shoes','NULL',NULL,'Available',123,1234,12),(7,'Oj','Puma Shoes','',NULL,'Available',12344,124,2),(8,'123','Patanjali Choorna','Health',NULL,'Available',54,334,33);
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
  `sec_dep_status` varchar(10) NOT NULL,
  `interest_status` varchar(10) NOT NULL,
  `packaging1_id` bigint(20) unsigned NOT NULL,
  `packaging2_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`transaction_id`),
  UNIQUE KEY `transaction_id` (`transaction_id`),
  KEY `item_id` (`item_id`),
  KEY `borrower_id` (`borrower_id`),
  KEY `packaging1_id` (`packaging1_id`),
  KEY `packaging2_id` (`packaging2_id`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`borrower_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`packaging1_id`) REFERENCES `delivery` (`packaging_id`),
  CONSTRAINT `transaction_ibfk_4` FOREIGN KEY (`packaging2_id`) REFERENCES `delivery` (`packaging_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
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
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('1','1','1','1212121212','123','NULL','NULL','NULL','NULL'),('123','123','123','123','123','NULL','NULL','NULL','NULL'),('1245','1234','21456','1234567890','oasdfj','sdf','NULL','NULL','NULL'),('Ameybhau','12345','Amey Vadnere','','amey','NULL','NULL','NULL','NULL'),('AmeyBhauVadnere','12345','Amey Vadnere','2222222222','amey619rocks@gmail.com','skflaj','1','Swiss Bank','5UCK1T'),('AmeyBhauVadnere2','12345','fas','1233422222','fdsaf','fsfg','ggs','s','44'),('Oj','qwer1234','Ojas Raundale','8692854808','170010004@iitdh.ac.in','hostel 3','NULL','NULL','NULL'),('PJ','dharwad','Prateek Jain','8279803383','170010007@iitdh.ac.in','Hostel 3','3456578901234','SBI','SBI78989078');
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

-- Dump completed on 2019-11-13 10:03:38
