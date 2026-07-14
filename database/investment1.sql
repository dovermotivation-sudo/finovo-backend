-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: investment-management
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_09_13_135603_add_role_and_financial_columns_to_users_table',2),(6,'2025_09_13_135642_create_plans_table',3),(7,'2025_09_14_074634_create_otps_table',4),(8,'2025_09_14_090254_add_phone_number_to_users_table',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `otps`
--

DROP TABLE IF EXISTS `otps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `otps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `otps_user_id_index` (`user_id`),
  CONSTRAINT `otps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `otps`
--

LOCK TABLES `otps` WRITE;
/*!40000 ALTER TABLE `otps` DISABLE KEYS */;
INSERT INTO `otps` VALUES (13,13,'$2y$12$.aScEt79cpgydPSj/JX0Hert3czeIOCq0bYEUJMll3MSkGNAdJgwO','2025-09-14 03:28:09','2025-09-14 02:58:09','2025-09-14 02:58:09'),(16,15,'$2y$12$us/F2OFX82.vBr3UjfmBcOg.dtY9gsuVhCGz1PEVCk2OeYhgCuGIG','2025-09-14 03:32:18','2025-09-14 03:02:18','2025-09-14 03:02:18'),(19,1,'$2y$12$fpul2Wm0uTJXDrzVb58PY.0x78ASUVCe4N307rfZrE37lC144eXQO','2025-09-14 03:48:11','2025-09-14 03:18:12','2025-09-14 03:18:12');
/*!40000 ALTER TABLE `otps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `plan_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `roi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minimum_investment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `risk_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_frequency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_features` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plans_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (1,'Flexible Investment Packages','Starter Plan','Perfect for beginners','8-12%/Monthly','₹10,000','Low Risk Portfolio','Monthly Reports','Basic Support',NULL,'{\"features\": {\"Basic Support\": true, \"Monthly Reports\": true, \"Low Risk Portfolio\": true, \"Minimum Investment\": \"₹10,000\"}}','2025-09-13 09:21:37','2025-09-13 09:21:37'),(2,'Flexible Investment Packages','Most Popular','Growth Plan For serious investors','15-20%/Monthly','₹50,000','Balanced Risk Portfolio','Weekly Reports','Priority Support',NULL,'{\"features\": {\"Weekly Reports\": true, \"Priority Support\": true, \"Minimum Investment\": \"₹50,000\", \"Balanced Risk Portfolio\": true}}','2025-09-13 09:21:37','2025-09-13 09:21:37'),(3,'Flexible Investment Packages','Premium','For high net worth individuals','25-35%/Monthly','₹2,00,000','High Growth Portfolio','Daily Reports','Dedicated Manager',NULL,'{\"features\": {\"Daily Reports\": true, \"Dedicated Manager\": true, \"Minimum Investment\": \"₹2,00,000\", \"High Growth Portfolio\": true}}','2025-09-13 09:21:37','2025-09-13 09:21:37'),(4,'Smart Bot Packages','Crypto','','25% per month (Monthly Selling), 38% per month (If Holding Stock)','$1000','Systematic perilous','Monthly Reports','Dedicated account manager, 24/7 technical support','24 hr activation','{\"features\": {\"Price\": \"$499/ life time\", \"Minimum Deposit\": \"1000$\", \"24 hr activation\": true, \"ROI Holding Stock\": \"38%\", \"ROI Monthly Selling\": \"25%\", \"Systematic perilous\": true, \"24/7 technical support\": true, \"Dedicated account manager\": true}}','2025-09-13 09:21:37','2025-09-13 09:21:37'),(5,'Smart Bot Packages','Commodities','','30% per month (Monthly Selling), 42% per month (If Holding Stock)','$2000','Systematic perilous','Monthly Reports','Dedicated account manager, 24/7 technical support','6 hr activation','{\"features\": {\"Price\": \"$399/life time\", \"6 hr activation\": true, \"Minimum Deposit\": \"2000$\", \"Unlimited option\": true, \"ROI Holding Stock\": \"42%\", \"ROI Monthly Selling\": \"30%\", \"Systematic perilous\": true, \"24/7 technical support\": true, \"Dedicated account manager\": true}}','2025-09-13 09:21:37','2025-09-13 09:21:37'),(6,'Smart Bot Packages','Customize Software','','Customizable','Customized','Systematic perilous','Customizable Reports','Dedicated Manager, 24/7 technical support',NULL,'{\"features\": {\"Price\": \"$899/life time\", \"Customize risk\": true, \"Customize Deposit\": true, \"Dedicated Manager\": true, \"Systematic perilous\": true, \"Customize profit ROI\": true, \"24/7 technical support\": true, \"Unlimited trading symbols\": true}}','2025-09-13 09:21:37','2025-09-13 09:21:37');
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('5coml7PKTaypne3ErbMkpbw1qAng6gBXf0LIKnt5',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiU01XSjEwSG9qbWtTQjA4SktwVWkwUDJrM3JGNHdtQjVkMFgwSkx2QyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9pbnZlc3RtZW50LW1hbmFnZW1lbnQudGVzdC9yZWdpc3RlciI7fX0=',1757849613),('aG8C09GChIvAGAnLSzxOhcMnqh3Tkr72PZd6WLGc',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSEJZQlk2Y2N5dWhFT2RJTVBDWk5iRVNqTHlLQTdtbVpWc2Vqb2s3diI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly9pbnZlc3RtZW50LW1hbmFnZW1lbnQudGVzdC9zdXBlci1hZG1pbi91c2VycyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1757848503),('GUZE7sAoNM6Ee1qy4hne8OMFKdu2L6P8xqmhDzhA',17,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYlM4OUZrYlViUHlXQkp2V2xyZ0ZwMUgwMFo1SEpuNEpaUk96RGY3ZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly9pbnZlc3RtZW50LW1hbmFnZW1lbnQudGVzdC91c2VyL2Rhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE3O30=',1757842340);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `portfolio_value` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_returns` decimal(15,2) NOT NULL DEFAULT '0.00',
  `plan_id` int NOT NULL DEFAULT '0',
  `growth_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','superadmin@gmail.com',NULL,'2025-09-14 03:00:07','$2y$12$jhrmtcB4yNBYU74Zw6zZiO/OW1grLOIKep3oM3WNX75WJKD/UedkG',NULL,'2025-09-13 08:29:28','2025-09-13 08:29:28','super_admin',0.00,0.00,0,0.00),(13,'mk','nk501730@gmail.com','8598888888','2025-09-14 03:00:07','$2y$12$4mGA97pnBQxOKBk7SZscHOUBxvCC/yyB4FVzYzYcbpEA8yYj8X21S','ZeMP0O7KCv7rV8VgAbmI6nOqPhTK6FIEYpogHsF5r06fmg1jFZ5ZemLGy8Gg','2025-09-14 02:58:09','2025-09-14 03:39:32','user',0.00,0.00,1,0.00),(14,'mk','nk501730+1@gmail.com',NULL,'2025-09-14 03:00:07','$2y$12$zky1BLGC4Tkpuj.34ePSZev5zu2WZMStwxbNPxQvsA/cz1WL/y7SC',NULL,'2025-09-14 02:59:41','2025-09-14 03:00:07','user',0.00,0.00,1,0.00),(15,'nk','nk501730+23@gmail.com',NULL,'2025-09-14 03:03:56','$2y$12$4q0zSyaOnhSSqobMCgQwduBgo9F4VQ4Gdu67Sd/0e3WsI7IcCiKUS',NULL,'2025-09-14 03:01:57','2025-09-14 03:03:56','user',0.00,0.00,1,0.00),(16,'nk12','nk501730+34@gmail.com',NULL,'2025-09-14 03:09:07','$2y$12$y6mFrUz6b1cFe.lGTPcb1.2QfYDQjDztYaVvSWUqmftNplVSpJtYq',NULL,'2025-09-14 03:07:57','2025-09-14 03:17:40','user',0.00,0.00,2,0.00),(17,'nkk','nk501730+223@gmail.com','8979797977','2025-09-14 04:02:20','$2y$12$CzQ3AzLaS8HlzMmU7yJy.u3mV/H4fWTDJHJ3MN5ND3mCTjqw/b7Xu',NULL,'2025-09-14 04:01:53','2025-09-14 04:02:20','user',0.00,0.00,2,0.00),(18,'Ankit','ezoneprinting@gmail.com','9723490016','2025-09-14 05:43:21','$2y$12$gTYjIlJ/G783iH1Ntn69Ve3dd.mesiUcNSbmxGWPx8R0mMWC2dlQS',NULL,'2025-09-14 05:39:13','2025-09-14 05:45:03','user',40000.00,2000.00,2,2.00);
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

-- Dump completed on 2025-09-14 17:04:16
