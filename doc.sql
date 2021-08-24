-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: doc
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.17-MariaDB

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
-- Table structure for table `connote`
--

DROP TABLE IF EXISTS `connote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `connote` (
  `connote_id` varchar(255) NOT NULL,
  `connote_number` int(11) NOT NULL,
  `connote_sender_name` varchar(255) DEFAULT NULL,
  `connote_sender_phone` varchar(13) DEFAULT NULL,
  `connote_sender_email` varchar(255) DEFAULT NULL,
  `connote_sender_address` varchar(255) DEFAULT NULL,
  `connote_sender_zipcode` varchar(5) DEFAULT NULL,
  `connote_receiver_name` varchar(255) DEFAULT NULL,
  `connote_receiver_phone` varchar(255) DEFAULT NULL,
  `connote_receiver_email` varchar(255) DEFAULT NULL,
  `connote_receiver_address` varchar(255) DEFAULT NULL,
  `connote_receiver_address_detail` text DEFAULT NULL,
  `connote_receiver_zipcode` varchar(255) DEFAULT NULL,
  `connote_service` varchar(255) DEFAULT NULL,
  `connote_service_price` decimal(10,0) DEFAULT NULL,
  `connote_amount` decimal(10,0) DEFAULT NULL,
  `connote_code` varchar(255) DEFAULT NULL,
  `connote_booking_code` varchar(255) DEFAULT NULL,
  `connote_order` decimal(10,0) DEFAULT NULL,
  `connote_state` varchar(255) DEFAULT NULL,
  `connote_state_id` decimal(10,0) DEFAULT NULL,
  `zone_code_from` varchar(255) DEFAULT NULL,
  `zone_code_to` varchar(255) DEFAULT NULL,
  `surcharge_amount` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `actual_weight` decimal(10,0) DEFAULT NULL,
  `volume_weight` decimal(10,0) DEFAULT NULL,
  `chargeable_weight` decimal(10,0) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `organization_id` decimal(10,0) DEFAULT NULL,
  `location_id` varchar(255) DEFAULT NULL,
  `connote_total_package` decimal(10,0) DEFAULT NULL,
  `connote_surcharge_amount` decimal(10,0) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `location_type` varchar(255) DEFAULT NULL,
  `source_tariff_db` varchar(255) DEFAULT NULL,
  `id_source_tariff` decimal(10,0) DEFAULT NULL,
  `is_locked` decimal(10,0) DEFAULT NULL,
  `formula_name` varchar(255) DEFAULT NULL,
  `create_from` varchar(255) DEFAULT NULL,
  `bags` varchar(255) DEFAULT NULL,
  `connote_sla_date` datetime DEFAULT NULL,
  `total_discount` decimal(10,0) DEFAULT NULL,
  `connote_code_` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`connote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `connote`
--

LOCK TABLES `connote` WRITE;
/*!40000 ALTER TABLE `connote` DISABLE KEYS */;
INSERT INTO `connote` VALUES ('29b9d6d5-fa0d-4be6-9942-63a8e86f4ace',1,'RAYDI JULFANDIO','','','KUTAI BARAT','','BUPATI KUTAI BARAT','','','PO BOX KB 2021','KALIMANTAN TIMUR, KAB. KUTAI BARAT, Kec. Barong Tongkok, Ds. Engkuni Pasek','75711','PKH',8500,8500,'P2107200000146','',146,'DELIVERED',2,'75576','75576',NULL,'d3743a07-dc97-4dd6-9b15-d03fa28ba15b',1,0,1,'157810','2021-07-20 07:27:50','2021-07-21 16:02:00',30,'605c49e3f9cd5833b126f7e9',1,0,'KPCLK BARONG TONGKOK 75576','KPCLK','tariffs',100230290,1,'POS EXPRESS dan POS KILAT KHUSUS','New View',NULL,NULL,NULL,'P2107200000146');
/*!40000 ALTER TABLE `connote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `connote_customfield`
--

DROP TABLE IF EXISTS `connote_customfield`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `connote_customfield` (
  `connote_id` varchar(255) DEFAULT NULL,
  `statusRetur` varchar(255) DEFAULT NULL,
  `COD` varchar(255) DEFAULT NULL,
  `ID_Pelanggan_Korporat` varchar(255) DEFAULT NULL,
  `cod_value` varchar(255) DEFAULT NULL,
  `fee_value` varchar(255) DEFAULT NULL,
  `total_cod` decimal(10,0) DEFAULT NULL,
  `lumpsum_connote_amount` varchar(255) DEFAULT NULL,
  `expired_pks` varchar(255) DEFAULT NULL,
  `minimumweight` varchar(255) DEFAULT NULL,
  `pks_no` varchar(255) DEFAULT NULL,
  `rekening_no` varchar(255) DEFAULT NULL,
  `npwp_number` varchar(255) DEFAULT NULL,
  `tariff_field` varchar(255) DEFAULT NULL,
  `Jenis_Barang` varchar(255) DEFAULT NULL,
  `ref_no` varchar(255) DEFAULT NULL,
  `instruksi_pengiriman` varchar(255) DEFAULT NULL,
  `idUserSAP` decimal(10,0) DEFAULT NULL,
  `idKorporatConnote` varchar(255) DEFAULT NULL,
  `billingStatus` varchar(255) DEFAULT NULL,
  `nopen` decimal(10,0) DEFAULT NULL,
  `nokprk` decimal(10,0) DEFAULT NULL,
  `regional` decimal(10,0) DEFAULT NULL,
  `destination_reg` decimal(10,0) DEFAULT NULL,
  `destination_kprk` decimal(10,0) DEFAULT NULL,
  `destination_nopen` decimal(10,0) DEFAULT NULL,
  `location_id` varchar(255) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `final_swp` decimal(10,0) DEFAULT NULL,
  `virtual_account` varchar(255) DEFAULT NULL,
  `cod_collected` varchar(255) DEFAULT NULL,
  `timeArrived` datetime DEFAULT NULL,
  `timePredictionArrived` datetime DEFAULT NULL,
  `destination_location` varchar(255) DEFAULT NULL,
  `timeLate` decimal(10,0) DEFAULT NULL,
  `is_over_sla` decimal(10,0) DEFAULT NULL,
  `sla_duration` decimal(10,0) DEFAULT NULL,
  `sla_duration_minutes` decimal(10,0) DEFAULT NULL,
  `C_is_Late` decimal(10,0) DEFAULT NULL,
  `C_Delivery` varchar(255) DEFAULT NULL,
  `deliverySuccessTime` datetime DEFAULT NULL,
  `first_attempt_time` datetime DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  KEY `connote_id` (`connote_id`),
  CONSTRAINT `connote_customfield_ibfk_1` FOREIGN KEY (`connote_id`) REFERENCES `connote` (`connote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `connote_customfield`
--

LOCK TABLES `connote_customfield` WRITE;
/*!40000 ALTER TABLE `connote_customfield` DISABLE KEYS */;
INSERT INTO `connote_customfield` VALUES ('29b9d6d5-fa0d-4be6-9942-63a8e86f4ace',NULL,'NON-COD',NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Paket',NULL,NULL,550003443,NULL,'not_match',75576,75500,9,9,75500,75576,'605c49e3f9cd5833b126f7e9','KPCLK BARONG TONGKOK 75576',6,NULL,'0','2021-07-21 15:58:42','2021-07-22 07:27:50','KPCLK BARONG TONGKOK 75576',-33,0,32,1950,0,'KPCLK BARONG TONGKOK 75576','2021-07-21 16:02:00','2021-07-21 16:02:00','550003525-loket','Ahmad Abdul Rahman');
/*!40000 ALTER TABLE `connote_customfield` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keys`
--

DROP TABLE IF EXISTS `keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(11) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `office` (
  `officeid` varchar(8) NOT NULL,
  `officename` varchar(50) NOT NULL,
  `kprk` varchar(8) NOT NULL,
  `regionid` varchar(8) NOT NULL,
  `officetype` varchar(25) NOT NULL,
  PRIMARY KEY (`officeid`),
  KEY `regionid` (`regionid`),
  CONSTRAINT `office_ibfk_1` FOREIGN KEY (`regionid`) REFERENCES `region` (`regionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
-- Table structure for table `pod`
--

DROP TABLE IF EXISTS `pod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pod` (
  `connote_id` varchar(255) DEFAULT NULL,
  `pod_id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` text DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `timeReceive` datetime DEFAULT NULL,
  `receiver` varchar(255) DEFAULT NULL,
  `coordinate` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pod_id`),
  KEY `connote_id` (`connote_id`),
  CONSTRAINT `pod_ibfk_1` FOREIGN KEY (`connote_id`) REFERENCES `connote` (`connote_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pod`
--

LOCK TABLES `pod` WRITE;
/*!40000 ALTER TABLE `pod` DISABLE KEYS */;
INSERT INTO `pod` VALUES ('29b9d6d5-fa0d-4be6-9942-63a8e86f4ace',16,'https://firebasestorage.googleapis.com/v0/b/paketidv2.appspot.com/o/pos%2F2021%2F07%2F21%2Fcamera.photoDeliveryProcess.560003526.6f8ad28869ea7c480be9.1626857882572.jpg?alt=media','https://firebasestorage.googleapis.com/v0/b/paketidv2.appspot.com/o/pos%2F2021%2F07%2F21%2Fsignature.signatureDeliveryProcess.560003526.6f8ad28869ea7c480be9.1626857878402.jpg?alt=media','2021-07-21 15:58:42','po box (DITERIMA PENERIMA)','-0.2489678,115.7147587');
/*!40000 ALTER TABLE `pod` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_role`
--

DROP TABLE IF EXISTS `ref_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_role` (
  `roleid` int(11) NOT NULL AUTO_INCREMENT,
  `roledescription` varchar(25) NOT NULL,
  PRIMARY KEY (`roleid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region` (
  `regionid` varchar(8) NOT NULL,
  `sortnumber` int(11) NOT NULL,
  `regiondescription` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`regionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `roleid` int(11) NOT NULL,
  `office` varchar(8) NOT NULL,
  `password` char(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `roleid` (`roleid`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `ref_role` (`roleid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'tsabit12','Tsabit Abdul Aziz','tsabit830@gmail.com',2,'40005','104ac35aeccd47c082e5677e242980a0','2021-08-15 10:04:00','2021-08-15 10:04:00',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zone_destination_data`
--

DROP TABLE IF EXISTS `zone_destination_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zone_destination_data` (
  `connote_id` varchar(255) DEFAULT NULL,
  `zone_name` varchar(255) DEFAULT NULL,
  `zode_code` varchar(255) DEFAULT NULL,
  `zone_type_code` varchar(255) DEFAULT NULL,
  `cache` varchar(255) DEFAULT NULL,
  KEY `connote_id` (`connote_id`),
  CONSTRAINT `zone_destination_data_ibfk_1` FOREIGN KEY (`connote_id`) REFERENCES `connote` (`connote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zone_destination_data`
--

LOCK TABLES `zone_destination_data` WRITE;
/*!40000 ALTER TABLE `zone_destination_data` DISABLE KEYS */;
INSERT INTO `zone_destination_data` VALUES ('29b9d6d5-fa0d-4be6-9942-63a8e86f4ace','75576','75576','tariff',NULL),('29b9d6d5-fa0d-4be6-9942-63a8e86f4ace','TRG','shTRG','Singkatan_Hub',NULL),('29b9d6d5-fa0d-4be6-9942-63a8e86f4ace','9','Regional9','destination_reg',NULL),('29b9d6d5-fa0d-4be6-9942-63a8e86f4ace','75576','KPCLK_75576','KPCLK',NULL),('29b9d6d5-fa0d-4be6-9942-63a8e86f4ace','75576','NOPEN_DEST_75576','destination_nopen',NULL),('29b9d6d5-fa0d-4be6-9942-63a8e86f4ace','75500','KPRK_DEST_75500','destination_kprk',NULL);
/*!40000 ALTER TABLE `zone_destination_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'doc'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-08-24 17:10:01
