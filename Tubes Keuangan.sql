CREATE DATABASE  IF NOT EXISTS `keuangan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `keuangan`;
-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: keuangan
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) NOT NULL,
  `tipe` enum('pemasukan','pengeluaran') NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Gaji','pemasukan'),(2,'Bonus','pemasukan'),(3,'Investasi','pemasukan'),(4,'Makan','pengeluaran'),(5,'Transport','pengeluaran'),(6,'Belanja','pengeluaran'),(7,'Tagihan','pengeluaran');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_transaksi`
--

DROP TABLE IF EXISTS `log_transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_transaksi` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `keterangan_log` text,
  `waktu` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_transaksi`
--

LOCK TABLES `log_transaksi` WRITE;
/*!40000 ALTER TABLE `log_transaksi` DISABLE KEYS */;
INSERT INTO `log_transaksi` VALUES (5,'Transaksi baru ID: 16','2026-04-20 12:30:22');
/*!40000 ALTER TABLE `log_transaksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `id_kategori` int DEFAULT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `keterangan` text,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_transaksi`),
  KEY `id_user` (`id_user`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi`
--

LOCK TABLES `transaksi` WRITE;
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
INSERT INTO `transaksi` VALUES (1,1,1,5000000.00,'Gaji Bulanan','2026-04-01','2026-04-15 12:58:34'),(2,1,4,50000.00,'Makan siang','2026-04-02','2026-04-15 12:58:34'),(3,2,2,1000000.00,'Bonus proyek','2026-04-03','2026-04-15 12:58:34'),(4,2,5,200000.00,'Transport kerja','2026-04-03','2026-04-15 12:58:34'),(5,3,3,2000000.00,'Hasil investasi','2026-04-04','2026-04-15 12:58:34'),(6,3,6,150000.00,'Belanja kebutuhan','2026-04-04','2026-04-15 12:58:34'),(7,1,7,250000.00,'Bayar listrik','2026-04-05','2026-04-15 12:58:34'),(16,8,1,500000.00,'','2026-04-20','2026-04-20 12:30:22');
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','0192023a7bbd73250516f069df18b500','Admin Utama','admin','2026-04-15 12:57:43'),(2,'Lia','eae61f0edaeab4bc53da35d3458acd67','Lia User','user','2026-04-15 12:57:43'),(3,'Arif','d53d757c0f838ea49fb46e09cbcc3cb1','Arif User','user','2026-04-15 12:57:43'),(4,'Yuni','b7dfe9096cebb53152aa5ce78a1a61c9','Yuni User','user','2026-04-15 12:57:43'),(5,'Regina','b306c8ca795e4f57287d9b1d56cb9880','Regina User','user','2026-04-15 12:57:43'),(8,'Arip','bb83d246fb39192ad202b6b3168d4b95','Arip','user','2026-04-20 12:29:58');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `view_transaksi`
--

DROP TABLE IF EXISTS `view_transaksi`;
/*!50001 DROP VIEW IF EXISTS `view_transaksi`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_transaksi` AS SELECT 
 1 AS `id_transaksi`,
 1 AS `nama_user`,
 1 AS `kategori`,
 1 AS `tipe`,
 1 AS `jumlah`,
 1 AS `keterangan`,
 1 AS `tanggal`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_transaksi`
--

/*!50001 DROP VIEW IF EXISTS `view_transaksi`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_transaksi` AS select `t`.`id_transaksi` AS `id_transaksi`,`u`.`nama_lengkap` AS `nama_user`,`k`.`nama_kategori` AS `kategori`,`k`.`tipe` AS `tipe`,`t`.`jumlah` AS `jumlah`,`t`.`keterangan` AS `keterangan`,`t`.`tanggal` AS `tanggal` from ((`transaksi` `t` join `users` `u` on((`t`.`id_user` = `u`.`id_user`))) join `kategori` `k` on((`t`.`id_kategori` = `k`.`id_kategori`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-20 19:44:53
