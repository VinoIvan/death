-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: localhost    Database: vcm_laser
-- ------------------------------------------------------
-- Server version	8.0.43

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
-- Table structure for table `appointment_statuses`
--

DROP TABLE IF EXISTS `appointment_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointment_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `appointment_statuses_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment_statuses`
--

LOCK TABLES `appointment_statuses` WRITE;
/*!40000 ALTER TABLE `appointment_statuses` DISABLE KEYS */;
INSERT INTO `appointment_statuses` VALUES (1,'ожидание','2026-02-23 12:31:50','2026-02-23 12:31:50'),(2,'принято','2026-02-23 12:31:50','2026-02-23 12:31:50'),(3,'в обработке','2026-02-23 12:31:50','2026-02-23 12:31:50'),(4,'отменено','2026-02-23 12:31:50','2026-02-23 12:31:50'),(5,'завершено','2026-02-23 12:31:50','2026-02-23 12:31:50');
/*!40000 ALTER TABLE `appointment_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `service_id` bigint unsigned NOT NULL,
  `schedule_id` bigint unsigned NOT NULL,
  `status_id` bigint unsigned NOT NULL DEFAULT '1',
  `client_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `booking_code` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `appointments_booking_code_unique` (`booking_code`),
  KEY `appointments_service_id_foreign` (`service_id`),
  KEY `appointments_user_id_index` (`user_id`),
  KEY `appointments_status_id_index` (`status_id`),
  KEY `appointments_schedule_id_index` (`schedule_id`),
  CONSTRAINT `appointments_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `appointments_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `appointments_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `appointment_statuses` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `appointments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
INSERT INTO `appointments` VALUES (3,NULL,5,2,5,'Виноградов Иван','+7 (960) 096-63-88','aamon160061@gmail.com',NULL,'TWu6NvGntMMEaxJFql8MYDGIU4WW12AI','2026-02-23 15:47:40','2026-02-23 18:05:49'),(4,NULL,1,1,5,'Виноградов Иван','+7 (999) 111-11-11','admin@vcm-laser.ru',NULL,'Qoahx50mN2nMIMtqDDe7hEqWFaMR6jig','2026-02-23 15:47:52','2026-02-23 18:05:45'),(5,NULL,4,3,5,'Виноградов Иван','+7 (999) 111-11-11','admin@vcm-laser.ru',NULL,'3nZmfIXPn1j1QufR5rTxDFK6HmxFUoax','2026-02-24 12:28:44','2026-02-24 12:28:44'),(6,NULL,2,6,1,'Виноградов Иван','+7 (999) 111-11-11','admin@vcm-laser.ru',NULL,'EiwiLlLOMJq5TlDiwSWRPDd7JjC2WTAa','2026-02-24 15:36:34','2026-02-24 15:36:34'),(7,6,2,7,5,'Виноградов Иван','+7 (960) 096-63-88','aamon160061@gmail.com',NULL,'XfzhnZwWiEXEdNJVBIZTfkGZvA0yABss','2026-02-28 12:42:42','2026-02-28 14:29:50'),(8,6,2,8,5,'Виноградов Иван','+7 (960) 096-63-88',NULL,NULL,'zJtxKsO1T8FYfEfyMo6yldxVuBEgbu8u','2026-02-28 12:50:02','2026-02-28 13:35:23'),(10,6,4,9,1,'Виноградов Иван','+7 (960) 096-63-88','aamon160061@gmail.com',NULL,'GOO2hx8Yd276ILQPel310YOhILajXGCw','2026-02-28 17:44:12','2026-02-28 17:44:12'),(11,6,3,10,1,'Виноградов Иван','+7 (960) 096-63-88','aamon160061@gmail.com',NULL,'P0SBkltyz9Iodxi6gCYrGyTYP6Xeefuy','2026-02-28 19:38:49','2026-02-28 19:38:49'),(12,6,2,11,1,'Виноградов Иван','+7 (960) 096-63-88','aamon160061@gmail.com',NULL,'PgWJ1AqsMuGO2WRoTCsqWHQ4NHQRTErt','2026-03-01 18:07:41','2026-03-01 18:07:41'),(13,6,4,12,1,'Виноградов Иван','+7 (960) 096-63-88','aamon160061@gmail.com',NULL,'mAl1eIzUrhqv3gfG9GiOm8zEeuspngiM','2026-03-02 15:00:38','2026-03-02 15:00:38'),(17,NULL,3,17,3,'Виноградов Иван','+7 (960) 096-63-88','aamon160061@gmail.com',NULL,'RXqyDuCg44CuBckGh1rTsdzVGDZlT7Cp','2026-03-04 12:58:21','2026-03-04 12:58:21'),(20,23,2,23,2,'Светлана Лебедева','+7 (999) 000-00-00','svetlana.lebedeva@test.com','Уже была у вас, очень понравилось','ea7c5f055b11ee4aa7ace7b3d639e86e','2026-02-22 17:16:02','2026-03-04 17:16:02'),(21,23,3,23,1,'Светлана Лебедева','+7 (999) 000-00-00','svetlana.lebedeva@test.com',NULL,'dd1f9cc838e737b87aee98ab4eb1f9ab','2026-02-20 17:16:02','2026-03-04 17:16:02'),(22,23,4,23,1,'Светлана Лебедева','+7 (999) 000-00-00','svetlana.lebedeva@test.com','Буду первый раз, немного волнуюсь','6fbed4c287a65353e308a96804fd984f','2026-02-28 17:16:02','2026-03-04 17:16:02'),(23,21,1,23,5,'Наталья Соколова','+7 (999) 888-88-88','natalia.sokolova@test.com',NULL,'63bc23222696dfa5b141f5b4112c8914','2026-02-10 17:16:02','2026-03-04 17:16:02'),(24,21,4,23,1,'Наталья Соколова','+7 (999) 888-88-88','natalia.sokolova@test.com',NULL,'2ed1eed35db168359374d424dc427225','2026-02-08 17:16:02','2026-03-04 17:16:02'),(25,20,3,23,2,'Татьяна Волкова','+7 (999) 777-77-77','tatiana.volkova@test.com','Уже была у вас, очень понравилось','42bfd0fddd04922cc0bbbda7b4a8e69b','2026-02-22 17:16:02','2026-03-04 17:16:02'),(26,18,2,23,2,'Елена Козлова','+7 (999) 555-55-55','elena.kozlova@test.com','Уже была у вас, очень понравилось','fc33870513a7218f5bdd91ff0c332312','2026-03-02 17:16:02','2026-03-04 17:16:02'),(27,18,4,23,2,'Елена Козлова','+7 (999) 555-55-55','elena.kozlova@test.com',NULL,'4f3fd9d5229e097ffe88c1686d25977b','2026-02-27 17:16:02','2026-03-04 17:16:02'),(28,17,2,23,1,'Дарья Сидорова','+7 (999) 444-44-44','daria.sidorova@test.com','Уже была у вас, очень понравилось','7eedb271767bb2fde53b0f024f087de8','2026-02-22 17:16:02','2026-03-04 17:16:02'),(29,16,1,23,5,'Мария Петрова','+7 (999) 333-33-33','maria.petrova@test.com','Буду первый раз, немного волнуюсь','d924cb4677a4e2c07b30b39df3f97baa','2026-02-11 17:16:02','2026-03-04 17:16:02'),(30,16,3,23,5,'Мария Петрова','+7 (999) 333-33-33','maria.petrova@test.com','Уже была у вас, очень понравилось','b7e11fe82071d28031bec680a1dcc434','2026-02-04 17:16:02','2026-03-04 17:16:02'),(31,14,1,23,1,'Анна Смирнова','+7 (999) 111-11-11','anna.smirnova@test.com','Буду первый раз, немного волнуюсь','9cffdf309d7c1f2ea60c0271053b3020','2026-02-05 17:16:02','2026-03-04 17:16:02'),(32,14,2,23,1,'Анна Смирнова','+7 (999) 111-11-11','anna.smirnova@test.com','Уже была у вас, очень понравилось','ef94ddc6526393639eaa19224856bb56','2026-02-08 17:16:02','2026-03-04 17:16:02'),(33,11,4,23,5,'Виноградов Иван','+7 (960) 096-63-88','aamon1600661@gmail.com','Буду первый раз, немного волнуюсь','39940d516e38e51e50ca77123a2f9789','2026-02-09 17:16:02','2026-03-04 17:16:02'),(34,8,4,23,1,'Елизавета Сергеевна','+7 (960) 096-63-88','lizakarpova5006@gmail.com','Уже была у вас, очень понравилось','5c4465221378d76ae96b1ffe45a2240c','2026-02-08 17:16:02','2026-03-04 17:16:02'),(35,8,5,23,5,'Елизавета Сергеевна','+7 (960) 096-63-88','lizakarpova5006@gmail.com','Буду первый раз, немного волнуюсь','35892248f2a21ec24adefa9a37c2f939','2026-02-19 17:16:02','2026-03-04 17:16:02'),(36,23,1,24,2,'Светлана Лебедева','+7 (999) 000-00-00','svetlana.lebedeva@test.com','Уже была у вас, очень понравилось','12684956bd3518f6fe62fe3cd0b58f44','2026-02-22 17:16:02','2026-03-04 17:16:02'),(37,23,4,24,4,'Светлана Лебедева','+7 (999) 000-00-00','svetlana.lebedeva@test.com','Уже была у вас, очень понравилось','a51e6216829cf4342bacb7455f881ce6','2026-02-11 17:16:02','2026-03-04 17:16:02'),(38,23,5,24,5,'Светлана Лебедева','+7 (999) 000-00-00','svetlana.lebedeva@test.com',NULL,'4c97bed82fe633b994a04c9096a89d87','2026-02-03 17:16:02','2026-03-04 17:16:02'),(39,21,4,24,5,'Наталья Соколова','+7 (999) 888-88-88','natalia.sokolova@test.com','Уже была у вас, очень понравилось','8bb5b0546d1dc727d39940d750c7c128','2026-02-28 17:16:02','2026-03-04 17:16:02'),(51,6,2,19,1,'Виноградов Иван','+7 (960) 096-63-88','aamon160061@gmail.com',NULL,'1RLoGqVphVgDiI2aWIEHvoBz28PecaFa','2026-03-05 13:26:29','2026-03-05 13:26:29'),(52,6,3,20,1,'Виноградов Иван','+7 (960) 096-63-88','aamon160061@gmail.com',NULL,'APbTa38pG0ATt6ox2OEtKTuYFW0AuYDZ','2026-03-05 14:06:22','2026-03-05 14:06:22'),(53,6,2,21,5,'Виноградов Иван','+7 (960) 096-63-88','aamon160061@gmail.com',NULL,'yTcG6k8nU9MhyJ1ZdYPpuKw6pj9JHSdH','2026-03-05 14:37:37','2026-03-05 14:39:20');
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_days_week` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_days_weekend` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_hours_week` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_hours_weekend` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (1,'phone',NULL,'+7 (999) 123-45-67','+7 (999) 765-43-21',NULL,NULL,NULL,NULL,'fas fa-phone',1,1,'2026-02-23 12:31:50','2026-02-23 12:31:50'),(2,'work_time',NULL,NULL,NULL,'Пн-Пт','Сб-Вс','10:00-21:00','11:00-19:00','fas fa-clock',1,2,'2026-02-23 12:31:50','2026-02-23 12:31:50'),(3,'email','info@vcm-laser.ru',NULL,NULL,NULL,NULL,NULL,NULL,'fas fa-envelope',1,3,'2026-02-23 12:31:50','2026-02-23 12:31:50'),(4,'address','г. Москва, ул. Лазерная, д. 10',NULL,NULL,NULL,NULL,NULL,NULL,'fas fa-map-marker-alt',1,4,'2026-02-23 12:31:50','2026-02-23 12:31:50');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2019_12_14_000001_create_personal_access_tokens_table',1),(2,'2026_02_12_104741_create_roles_table',1),(3,'2026_02_12_105609_create_users_table',1),(4,'2026_02_12_105625_create_password_resets_table',1),(5,'2026_02_12_105639_create_services_table',1),(6,'2026_02_12_105651_create_appointment_statuses_table',1),(7,'2026_02_12_105702_create_schedules_table',1),(8,'2026_02_12_105713_create_appointments_table',1),(9,'2026_02_12_105725_create_visit_history_table',1),(10,'2026_02_12_105736_create_reviews_table',1),(11,'2026_02_12_105749_create_contacts_table',1),(12,'2026_02_12_105758_create_settings_table',1),(13,'2026_02_12_105806_create_schedule_templates_table',1),(14,'2026_02_12_105827_create_schedule_exceptions_table',1),(15,'2026_02_12_141025_add_phone_to_users_table',1),(16,'2026_02_19_182328_add_contact_fields_to_contacts_table',1),(17,'2026_02_23_193746_remove_is_active_from_services',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `appointment_id` bigint unsigned DEFAULT NULL,
  `rating` tinyint unsigned NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_appointment_id_foreign` (`appointment_id`),
  KEY `reviews_is_approved_index` (`is_approved`),
  KEY `reviews_rating_index` (`rating`),
  CONSTRAINT `reviews_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (20,6,8,5,'все полный гуд',1,'2026-03-04 16:23:01','2026-03-04 16:23:01'),(22,21,23,4,'Хуже некуда. Грубый персонал, некачественная услуга.',1,'2026-03-17 21:00:00','2026-03-04 17:21:52'),(23,16,29,4,'Профессиональный подход, современное оборудование. Результат превзошел ожидания!',1,'2026-03-18 21:00:00','2026-03-04 17:21:52'),(24,16,30,3,'Профессиональный подход, современное оборудование. Результат превзошел ожидания!',1,'2026-03-11 21:00:00','2026-03-04 17:21:52'),(25,11,33,4,'Результат потрясающий! Кожа нежная и гладкая. Спасибо!',1,'2026-03-11 21:00:00','2026-03-04 17:21:52'),(26,8,35,4,'Кошмар! После процедуры ожог и сильное раздражение. Больше ни ногой!',1,'2026-03-14 21:00:00','2026-03-04 17:21:52'),(27,23,38,4,'Профессиональный подход, современное оборудование. Результат превзошел ожидания!',1,'2026-03-18 21:00:00','2026-03-04 17:21:52'),(28,21,39,3,'Кошмар! После процедуры ожог и сильное раздражение. Больше ни ногой!',1,'2026-03-13 21:00:00','2026-03-04 17:21:52'),(29,6,53,1,'так себе((',1,'2026-03-05 14:46:25','2026-03-05 14:46:25'),(30,6,7,2,'ну пойдет((',1,'2026-03-05 14:46:40','2026-03-05 14:46:40');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'guest','2026-02-23 12:31:50','2026-02-23 12:31:50'),(2,'registered','2026-02-23 12:31:50','2026-02-23 12:31:50'),(3,'admin','2026-02-23 12:31:50','2026-02-23 12:31:50');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_exceptions`
--

DROP TABLE IF EXISTS `schedule_exceptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedule_exceptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `is_working_day` tinyint(1) NOT NULL DEFAULT '0',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `schedule_exceptions_date_unique` (`date`),
  KEY `schedule_exceptions_created_by_foreign` (`created_by`),
  CONSTRAINT `schedule_exceptions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_exceptions`
--

LOCK TABLES `schedule_exceptions` WRITE;
/*!40000 ALTER TABLE `schedule_exceptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `schedule_exceptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_templates`
--

DROP TABLE IF EXISTS `schedule_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedule_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day_of_week` tinyint unsigned NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `service_id` bigint unsigned DEFAULT NULL,
  `max_bookings` int unsigned NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule_templates_service_id_foreign` (`service_id`),
  KEY `schedule_templates_created_by_foreign` (`created_by`),
  KEY `schedule_templates_day_of_week_index` (`day_of_week`),
  CONSTRAINT `schedule_templates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `schedule_templates_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_templates`
--

LOCK TABLES `schedule_templates` WRITE;
/*!40000 ALTER TABLE `schedule_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `schedule_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `service_id` bigint unsigned DEFAULT NULL,
  `max_bookings` int unsigned NOT NULL DEFAULT '1',
  `current_bookings` int unsigned NOT NULL DEFAULT '0',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `schedules_date_start_time_service_id_unique` (`date`,`start_time`,`service_id`),
  KEY `schedules_service_id_foreign` (`service_id`),
  KEY `schedules_created_by_foreign` (`created_by`),
  KEY `schedules_date_is_available_index` (`date`,`is_available`),
  CONSTRAINT `schedules_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `schedules_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (1,'2026-02-24','10:00:00','11:00:00',NULL,1,1,1,6,'2026-02-23 13:03:58','2026-02-23 15:47:52'),(2,'2026-02-23','22:00:00','23:17:00',NULL,1,1,1,6,'2026-02-23 14:17:56','2026-02-23 15:47:40'),(3,'2026-02-25','10:00:00','11:00:00',NULL,1,1,1,6,'2026-02-23 17:50:27','2026-02-24 12:28:44'),(4,'2026-02-23','11:00:00','12:00:00',NULL,1,0,1,6,'2026-02-23 17:51:03','2026-02-23 17:51:03'),(5,'2026-02-23','14:00:00','15:00:00',5,1,0,1,6,'2026-02-23 18:04:06','2026-02-23 18:04:19'),(6,'2026-02-25','14:00:00','19:00:00',NULL,1,1,1,6,'2026-02-24 15:34:42','2026-02-24 15:36:34'),(7,'2026-02-28','14:00:00','15:00:00',NULL,1,1,1,6,'2026-02-28 11:08:13','2026-02-28 12:42:42'),(8,'2026-02-28','10:00:00','11:00:00',NULL,1,1,1,6,'2026-02-28 12:45:29','2026-02-28 12:50:02'),(9,'2026-02-28','16:00:00','18:00:00',NULL,1,1,1,6,'2026-02-28 17:42:33','2026-02-28 17:44:12'),(10,'2026-03-01','10:00:00','11:00:00',NULL,1,1,1,6,'2026-02-28 19:38:18','2026-02-28 19:38:49'),(11,'2026-03-01','11:00:00','12:00:00',NULL,1,1,1,6,'2026-03-01 18:07:27','2026-03-01 18:07:41'),(12,'2026-03-02','10:00:00','11:00:00',NULL,1,1,1,6,'2026-03-02 14:56:27','2026-03-02 15:00:38'),(13,'2026-03-02','12:00:00','13:00:00',NULL,1,0,1,6,'2026-03-02 16:19:31','2026-03-02 16:19:31'),(15,'2026-03-03','11:00:00','12:00:00',NULL,1,0,1,6,'2026-03-03 11:34:57','2026-03-03 11:34:57'),(16,'2026-03-03','10:00:00','11:00:00',NULL,1,0,1,6,'2026-03-03 11:35:06','2026-03-04 10:38:27'),(17,'2026-03-04','10:00:00','11:00:00',NULL,1,1,1,6,'2026-03-04 09:46:00','2026-03-04 12:58:21'),(18,'2026-03-04','11:00:00','12:00:00',NULL,1,0,1,6,'2026-03-04 09:59:50','2026-03-04 13:12:39'),(19,'2026-03-05','10:00:00','11:00:00',NULL,1,1,1,6,'2026-03-04 15:58:39','2026-03-05 13:26:29'),(20,'2026-03-06','10:00:00','11:00:00',NULL,1,1,1,6,'2026-03-04 15:58:46','2026-03-05 14:06:22'),(21,'2026-03-06','11:00:00','12:00:00',NULL,1,1,1,6,'2026-03-04 15:58:56','2026-03-05 14:37:37'),(22,'2026-03-06','13:00:00','14:00:00',NULL,1,0,1,6,'2026-03-04 15:59:18','2026-03-05 14:39:58'),(23,'2026-03-10','09:00:00','09:30:00',1,1,16,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(24,'2026-03-10','10:00:00','10:30:00',1,1,3,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(25,'2026-03-10','11:00:00','11:30:00',2,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(26,'2026-03-10','12:00:00','12:30:00',2,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(27,'2026-03-10','13:00:00','13:30:00',3,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(28,'2026-03-10','14:00:00','14:30:00',3,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(29,'2026-03-10','15:00:00','15:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(30,'2026-03-10','16:00:00','16:30:00',2,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(31,'2026-03-10','17:00:00','17:30:00',3,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(32,'2026-03-10','18:00:00','18:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(33,'2026-03-11','09:00:00','09:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(34,'2026-03-11','10:00:00','10:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(35,'2026-03-11','11:00:00','11:30:00',2,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(36,'2026-03-11','12:00:00','12:30:00',2,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(37,'2026-03-11','13:00:00','13:30:00',3,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(38,'2026-03-11','14:00:00','14:30:00',3,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(39,'2026-03-11','15:00:00','15:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(40,'2026-03-11','16:00:00','16:30:00',2,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(41,'2026-03-11','17:00:00','17:30:00',3,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(42,'2026-03-11','18:00:00','18:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(43,'2026-03-12','09:00:00','09:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(44,'2026-03-12','10:00:00','10:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(45,'2026-03-12','11:00:00','11:30:00',2,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(46,'2026-03-12','12:00:00','12:30:00',2,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(47,'2026-03-12','13:00:00','13:30:00',3,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(48,'2026-03-12','14:00:00','14:30:00',3,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(49,'2026-03-12','15:00:00','15:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(50,'2026-03-12','16:00:00','16:30:00',2,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(51,'2026-03-12','17:00:00','17:30:00',3,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(52,'2026-03-12','18:00:00','18:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(53,'2026-03-13','09:00:00','09:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(54,'2026-03-13','10:00:00','10:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(55,'2026-03-13','11:00:00','11:30:00',2,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(56,'2026-03-13','12:00:00','12:30:00',2,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(57,'2026-03-13','13:00:00','13:30:00',3,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(58,'2026-03-13','14:00:00','14:30:00',3,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(59,'2026-03-13','15:00:00','15:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(60,'2026-03-13','16:00:00','16:30:00',2,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(61,'2026-03-13','17:00:00','17:30:00',3,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02'),(62,'2026-03-13','18:00:00','18:30:00',1,1,0,1,1,'2026-03-04 17:16:02','2026-03-04 17:16:02');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `duration` int unsigned NOT NULL COMMENT 'Длительность в минутах',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Лазерная эпиляция верхней губы','Безболезненное удаление волос на верхней губе. Процедура занимает всего 15 минут.',1500.00,15,4,'2026-02-23 12:31:50','2026-02-23 16:42:16'),(2,'Лазерная эпиляция подмышек','Полное удаление волос в подмышечных впадинах. Результат после первой процедуры.',2500.00,20,2,'2026-02-23 12:31:50','2026-02-23 12:31:50'),(3,'Лазерная эпиляция бикини','Классическое бикини. Деликатная зона требует особого внимания.',3500.00,30,3,'2026-02-23 12:31:50','2026-02-23 12:31:50'),(4,'Лазерная эпиляция голеней','Полное удаление волос на голенях. Гладкая кожа без раздражения.',4500.00,40,4,'2026-02-23 12:31:50','2026-02-23 12:31:50'),(5,'Лазерная эпиляция бедер','Обработка бедер полностью. Идеально для подготовки к летнему сезону.',5000.00,50,3,'2026-02-23 12:31:50','2026-03-04 11:01:47');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_name_unique` (`key_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site_name','VCM Laser','text','2026-02-23 12:31:50','2026-02-23 12:31:50'),(2,'site_description','Салон лазерной эпиляции в Москве','text','2026-02-23 12:31:50','2026-02-23 12:31:50'),(3,'booking_interval','30','number','2026-02-23 12:31:50','2026-02-23 12:31:50'),(4,'advance_booking_days','14','number','2026-02-23 12:31:50','2026-02-23 12:31:50'),(5,'working_days','1,2,3,4,5,6','text','2026-02-23 12:31:50','2026-02-23 12:31:50'),(6,'working_hours_start','10:00','text','2026-02-23 12:31:50','2026-02-23 12:31:50'),(7,'working_hours_end','21:00','text','2026-02-23 12:31:50','2026-02-23 12:31:50');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL DEFAULT '2',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,3,'Администратор','admin@vcm-las.ru','+7 (999) 111-11-11','$2y$12$OQwgpWAPOEa7kpyLL6AeguSmexVvhZ4HVnuXF4jVNS31aDm307w.O','XVNo8IMmWPXPFSeYA9g3UEKGIy01xxKu55HGlwPsIb60DiAy2lkIPUzBZsI9','2026-02-23 12:31:50','2026-02-23 12:31:50'),(6,3,'Виноградов Иван','aamon160061@gmail.com','+7 (960) 096-63-88','$2y$12$krbEJIjBQByaqAEe1k36QOaNXr5CitFrb06yrJseC5OsghvFzSb4m','T3jUIJJ6oODBT1mE4JjotzDA1sjTPeW4D0dXSzV5TJifVYygJiPn6BQIyGMs','2026-02-23 12:59:40','2026-03-05 14:38:42'),(8,2,'Елизавета Сергеевна','lizakarpova5006@gmail.com','+7 (960) 096-63-88','$2y$12$wCtNN444Wl1TGrWGf40ngeQ6pfznBcADz.h26w3ZNWiqjPjujcsFe','VocXyNPHAL7IArGhyhEdronOOCrgjqqwM5n4z7moNzRlP88aOgOiNPQtnHz2','2026-02-24 13:14:30','2026-03-05 14:45:23'),(11,2,'Виноградов Иван','aamon1600661@gmail.com','+7 (960) 096-63-88','$2y$12$1fPC3bFs0y/3upJFop2Fgeon99x7k4M/Nm.U3FRT/bWwoc7/cMvQe',NULL,'2026-03-04 15:35:23','2026-03-04 15:35:23'),(14,2,'Анна Смирнова','anna.smirnova@test.com','+7 (999) 111-11-11','$2y$12$KxqX5X5X5X5X5X5X5X5X5OX5X5X5X5X5X5X5X5X5X5X5X5X5X5',NULL,'2026-03-04 17:11:10','2026-03-04 17:11:10'),(15,2,'Екатерина Иванова','ekaterina.ivanova@test.com','+7 (999) 222-22-22','$2y$12$KxqX5X5X5X5X5X5X5X5X5OX5X5X5X5X5X5X5X5X5X5X5X5X5X5',NULL,'2026-03-04 17:11:10','2026-03-04 17:11:10'),(16,2,'Мария Петрова','maria.petrova@test.com','+7 (999) 333-33-33','$2y$12$KxqX5X5X5X5X5X5X5X5X5OX5X5X5X5X5X5X5X5X5X5X5X5X5X5',NULL,'2026-03-04 17:11:10','2026-03-04 17:11:10'),(17,2,'Дарья Сидорова','daria.sidorova@test.com','+7 (999) 444-44-44','$2y$12$KxqX5X5X5X5X5X5X5X5X5OX5X5X5X5X5X5X5X5X5X5X5X5X5X5',NULL,'2026-03-04 17:11:10','2026-03-04 17:11:10'),(18,2,'Елена Козлова','elena.kozlova@test.com','+7 (999) 555-55-55','$2y$12$KxqX5X5X5X5X5X5X5X5X5OX5X5X5X5X5X5X5X5X5X5X5X5X5X5',NULL,'2026-03-04 17:11:10','2026-03-04 17:11:10'),(19,2,'Ольга Морозова','olga.morozova@test.com','+7 (999) 666-66-66','$2y$12$KxqX5X5X5X5X5X5X5X5X5OX5X5X5X5X5X5X5X5X5X5X5X5X5X5',NULL,'2026-03-04 17:11:10','2026-03-04 17:11:10'),(20,2,'Татьяна Волкова','tatiana.volkova@test.com','+7 (999) 777-77-77','$2y$12$KxqX5X5X5X5X5X5X5X5X5OX5X5X5X5X5X5X5X5X5X5X5X5X5X5',NULL,'2026-03-04 17:11:10','2026-03-04 17:11:10'),(21,2,'Наталья Соколова','natalia.sokolova@test.com','+7 (999) 888-88-88','$2y$12$KxqX5X5X5X5X5X5X5X5X5OX5X5X5X5X5X5X5X5X5X5X5X5X5X5',NULL,'2026-03-04 17:11:10','2026-03-04 17:11:10'),(22,2,'Ирина Новикова','irina.novikova@test.com','+7 (999) 999-99-99','$2y$12$KxqX5X5X5X5X5X5X5X5X5OX5X5X5X5X5X5X5X5X5X5X5X5X5X5',NULL,'2026-03-04 17:11:10','2026-03-04 17:11:10'),(23,2,'Светлана Лебедева','svetlana.lebedeva@test.com','+7 (999) 000-00-00','$2y$12$KxqX5X5X5X5X5X5X5X5X5OX5X5X5X5X5X5X5X5X5X5X5X5X5X5',NULL,'2026-03-04 17:11:10','2026-03-04 17:11:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visit_history`
--

DROP TABLE IF EXISTS `visit_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visit_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `appointment_id` bigint unsigned NOT NULL,
  `visit_date` date NOT NULL,
  `service_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `master_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Мастер',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visit_history_appointment_id_foreign` (`appointment_id`),
  KEY `visit_history_user_id_visit_date_index` (`user_id`,`visit_date`),
  CONSTRAINT `visit_history_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `visit_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit_history`
--

LOCK TABLES `visit_history` WRITE;
/*!40000 ALTER TABLE `visit_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `visit_history` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-05 19:00:23
