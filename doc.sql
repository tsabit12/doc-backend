-- MySQL dump 10.13  Distrib 8.0.26, for macos11.3 (x86_64)
--
-- Host: localhost    Database: doc
-- ------------------------------------------------------
-- Server version	8.0.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `doc`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `doc` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `doc`;

--
-- Table structure for table `keys`
--

DROP TABLE IF EXISTS `keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `keys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keys`
--

LOCK TABLES `keys` WRITE;
/*!40000 ALTER TABLE `keys` DISABLE KEYS */;
INSERT INTO `keys` VALUES (1,1,'897043a5530eb21821a556a93f85bfff',10,0,0,NULL,20210815);
/*!40000 ALTER TABLE `keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `office`
--

DROP TABLE IF EXISTS `office`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `office` (
  `officeid` varchar(8) NOT NULL,
  `officename` varchar(50) NOT NULL,
  `kprk` varchar(8) NOT NULL,
  `regionid` varchar(8) NOT NULL,
  `officetype` varchar(25) NOT NULL,
  PRIMARY KEY (`officeid`),
  KEY `regionid` (`regionid`),
  CONSTRAINT `office_ibfk_1` FOREIGN KEY (`regionid`) REFERENCES `region` (`regionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `office`
--

LOCK TABLES `office` WRITE;
/*!40000 ALTER TABLE `office` DISABLE KEYS */;
INSERT INTO `office` VALUES ('40000','BANDUNG','40000','40004','KPRK'),('40005','KANTOR PUSAT BANDUNG','40005','40005','KP'),('40114A','CIHAPIT','40000','40004','KPCDK'),('40115A','CILAKI','40000','40004','KPCDK'),('40115B','JUANDA','40000','40004','KPCDK'),('40116A','CICENDO','40000','40004','KPCDK'),('40116B','UNISBA','40000','40004','KPCDK'),('40117A','BANJAR SARI','40000','40004','KPCDK'),('40117B','BABAKAN CIAMIS','40000','40004','KPCDK'),('40122B','SUPRATMAN','40000','40004','KPCDK'),('40123A','SUKALUYU','40000','40004','KPCDK'),('40124A','CIKUTRA','40000','40004','KPCDK'),('40125A','CICADAS','40000','40004','KPCDK'),('40125B','CICAHEUM','40000','40004','KPCDK'),('40131A','CIHAMPELAS','40000','40004','KPCDK'),('40132B','UNPAD','40000','40004','KPCDK'),('40134A','SADANG SERANG','40000','40004','KPCDK'),('40135A','LIPI','40000','40004','KPCDK'),('40135B','DAGO','40000','40004','KPCDK'),('40141A','UNPAR','40000','40004','KPCDK'),('40151A','SARIJADI','40000','40004','KPCDK'),('40151B','PUSDIKLAT POS','40000','40004','KPCDK'),('40153A','GEGERKALONG','40000','40004','KPCDK'),('40154B','SETIABUDI','40000','40004','KPCDK'),('40161A','CIPAGANTI','40000','40004','KPCDK'),('40161B','PASTEUR','40000','40004','KPCDK'),('40162A','CIPEDES','40000','40004','KPCDK'),('40163A','MARANATHA','40000','40004','KPCDK'),('40172A','ARJUNA','40000','40004','KPCDK'),('40174A','HUSEIN','40000','40004','KPCDK'),('40183A','DUNGUSCARIANG','40000','40004','KPCDK'),('40184A','ANDIR','40000','40004','KPCDK'),('40222A','BABAKAN CIPARAY','40000','40004','KPCDK'),('40222B','SUMBER SARI INDAH','40000','40004','KPCDK'),('40223A','KOPO','40000','40004','KPCDK'),('40223B','CARINGIN','40000','40004','KPCDK'),('40225A','MARGAHAYU','40000','40004','KPCDK'),('40227A','SUKAMENAK','40000','40004','KPCDK'),('40229A','SULAEMAN','40000','40004','KPCDK'),('40232A','SITUSAEUR','40000','40004','KPCDK'),('40236A','CIBADUYUT','40000','40004','KPCDK'),('40242A','ASTANA ANYAR','40000','40004','KPCDK'),('40253A','CIGERELENG','40000','40004','KPCDK'),('40253B','TEGAL LEGA','40000','40004','KPCDK'),('40262A','KOSAMBI','40000','40004','KPCDK'),('40264A','TURANGGA DUA','40000','40004','KPCDK'),('40265A','CIJAGRA','40000','40004','KPCDK'),('40266A','BUAH BATU','40000','40004','KPCDK'),('40272A','KEBONWARU','40000','40004','KPCDK'),('40275A','TURANGGA','40000','40004','KPCDK'),('40284A','KIARACONDONG','40000','40004','KPCDK'),('40286D','CIWASTRA','40000','40004','KPCDK'),('40383','CIPAKU','40000','40004','KPCLK'),('40391','LEMBANG','40000','40004','KPCLK'),('40393','CILENYI','40000','40004','KPCLK'),('40394','RANCAEKEK','40000','40004','KPCLK'),('40395','CICALENGKA','40000','40004','KPCLK'),('40600','UJUNG BERUNG','40000','40004','KPCDK');
/*!40000 ALTER TABLE `office` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_role`
--

DROP TABLE IF EXISTS `ref_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ref_role` (
  `roleid` int NOT NULL AUTO_INCREMENT,
  `roledescription` varchar(25) NOT NULL,
  PRIMARY KEY (`roleid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_role`
--

LOCK TABLES `ref_role` WRITE;
/*!40000 ALTER TABLE `ref_role` DISABLE KEYS */;
INSERT INTO `ref_role` VALUES (1,'KPRK'),(2,'PUSAT'),(3,'KPC');
/*!40000 ALTER TABLE `ref_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `region` (
  `regionid` varchar(8) NOT NULL,
  `sortnumber` int NOT NULL,
  `regiondescription` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`regionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region`
--

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
INSERT INTO `region` VALUES ('10004',4,'REGIONAL JAKARTA'),('20004',1,'REGIONAL MEDAN'),('25004',2,'REGIONAL PADANG'),('30004',3,'REGIONAL PALEMBANG'),('40004',5,'REGIONAL BANDUNG'),('40005',12,'PUSAT'),('50004',6,'REGIONAL SEMARANG'),('60004',7,'REGIONAL SURABAYA'),('70704',9,'REGIONAL BANJARBARU'),('80004',8,'REGIONAL DENPASAR'),('90004',10,'REGIONAL MAKASAR'),('99004',11,'REGIONAL JAYAPURA');
/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `userid` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `roleid` int NOT NULL,
  `office` varchar(8) NOT NULL,
  `password` char(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `roleid` (`roleid`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `ref_role` (`roleid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'tsabit12','Tsabit Abdul Aziz','tsabit830@gmail.com',2,'40005','104ac35aeccd47c082e5677e242980a0','2021-08-15 17:04:00','2021-08-15 17:04:00',1);
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

-- Dump completed on 2021-08-22  0:48:08
