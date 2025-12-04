-- MariaDB dump 10.17  Distrib 10.4.11-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: uangku
-- ------------------------------------------------------
-- Server version	10.4.11-MariaDB

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
-- Table structure for table `wallet_transactions`
--

DROP TABLE IF EXISTS `wallet_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wallet_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_id` bigint(20) unsigned NOT NULL,
  `wallet_transaction_type_id` smallint(5) unsigned NOT NULL,
  `transaction_id` bigint(20) unsigned DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL,
  `before_balance` decimal(18,2) NOT NULL,
  `after_balance` decimal(18,2) NOT NULL,
  `transaction_date` date DEFAULT NULL,
  `transaction_note` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `from_wallet_id` (`wallet_id`),
  KEY `wallet_transaction_type_id` (`wallet_transaction_type_id`),
  CONSTRAINT `wallet_transactions_ibfk_1` FOREIGN KEY (`wallet_id`) REFERENCES `payments` (`id`),
  CONSTRAINT `wallet_transactions_ibfk_3` FOREIGN KEY (`wallet_transaction_type_id`) REFERENCES `payment_transaction_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_transactions`
--

LOCK TABLES `wallet_transactions` WRITE;
/*!40000 ALTER TABLE `wallet_transactions` DISABLE KEYS */;
INSERT INTO `wallet_transactions` VALUES (6,10,1,6,5000000.00,0.00,5000000.00,'2025-05-09','Gaji Bulan Mei','2025-05-09 15:22:36',NULL),(7,10,4,2,500000.00,4500000.00,4000000.00,'2025-05-09','Tarik dari ATM','2025-05-09 15:42:28',NULL),(8,2,3,2,500000.00,0.00,500000.00,'2025-05-09','Tarik dari ATM','2025-05-09 15:42:28',NULL),(10,2,2,3,250000.00,500000.00,250000.00,'2025-09-11',NULL,'2025-09-11 09:53:50',NULL),(14,4,2,NULL,154000.00,0.00,-154000.00,'2025-10-23','Youtube Premium','2025-10-23 16:39:04',NULL),(16,4,2,NULL,154000.00,0.00,-154000.00,'2025-10-23','Youtube Premium','2025-10-23 16:44:27',NULL),(18,13,1,NULL,1000000.00,500000.00,1500000.00,'2025-11-07','Test Gaji','2025-11-07 15:24:09',NULL),(20,10,2,NULL,4500000.00,4500000.00,0.00,'2025-11-18','Biaya AdminBCA','2025-11-18 15:21:10',NULL),(21,10,2,NULL,16000.00,4500000.00,4484000.00,'2025-11-18','Biaya Admin BCA','2025-11-18 15:30:00',NULL),(22,11,2,NULL,50000.00,19846000.00,19796000.00,'2025-11-20','TEST','2025-11-20 15:11:47',NULL),(23,10,2,NULL,16000.00,4500000.00,4484000.00,'2025-11-21','Biaya Admin BCA','2025-11-21 15:30:00',NULL),(24,10,2,NULL,16000.00,4484000.00,4468000.00,'2025-11-24','Biaya Admin BCA','2025-11-24 11:30:00',NULL),(25,10,2,NULL,16000.00,4468000.00,4452000.00,'2025-11-24','Biaya Admin BCA','2025-11-24 12:30:00',NULL),(26,17,2,NULL,11000.00,500000.00,489000.00,'2025-11-24','Biaya Admin BNI','2025-11-24 12:30:00',NULL),(27,17,2,19,10000.00,489000.00,479000.00,'2025-11-24',NULL,'2025-11-24 13:52:11',NULL);
/*!40000 ALTER TABLE `wallet_transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-04 10:15:30
