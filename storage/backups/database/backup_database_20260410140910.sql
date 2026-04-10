-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bolsa_de_proyectos
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `administradores`
--

DROP TABLE IF EXISTS `administradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administradores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `administradores_usuario_id_unique` (`usuario_id`),
  CONSTRAINT `fk_administradores_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administradores`
--

LOCK TABLES `administradores` WRITE;
/*!40000 ALTER TABLE `administradores` DISABLE KEYS */;
INSERT INTO `administradores` VALUES (1,1,'Admin','SENA',1,'2026-04-09 21:30:05','2026-04-09 21:30:05');
/*!40000 ALTER TABLE `administradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aprendices`
--

DROP TABLE IF EXISTS `aprendices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aprendices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `programa_formacion` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aprendices_usuario_id_unique` (`usuario_id`),
  CONSTRAINT `fk_aprendices_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aprendices`
--

LOCK TABLES `aprendices` WRITE;
/*!40000 ALTER TABLE `aprendices` DISABLE KEYS */;
INSERT INTO `aprendices` VALUES (1,4,'Aprendiz','Demo','Análisis y Desarrollo de Software',1,'2026-04-09 21:30:05','2026-04-09 21:30:05',NULL),(7,11,'Edwin Jose','Berdugo Muñoz','Adso - 10',1,'2026-04-10 17:46:05','2026-04-10 18:00:18',NULL);
/*!40000 ALTER TABLE `aprendices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `accion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modulo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tabla_afectada` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registro_id` bigint unsigned DEFAULT NULL,
  `datos_anteriores` json DEFAULT NULL,
  `datos_nuevos` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_modulo_index` (`user_id`,`modulo`),
  KEY `audit_logs_tabla_afectada_registro_id_index` (`tabla_afectada`,`registro_id`),
  KEY `audit_logs_created_at_index` (`created_at`),
  CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresas`
--

DROP TABLE IF EXISTS `empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned NOT NULL,
  `nit` bigint unsigned NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `representante` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo_contacto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ubicacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empresas_usuario_id_unique` (`usuario_id`),
  UNIQUE KEY `empresas_nit_unique` (`nit`),
  UNIQUE KEY `empresas_correo_contacto_unique` (`correo_contacto`),
  CONSTRAINT `fk_empresas_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresas`
--

LOCK TABLES `empresas` WRITE;
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` VALUES (1,2,12345475784,'Empresa Demo','Representante Legal','empresa@gmail.com',NULL,NULL,NULL,1,'2026-04-09 21:30:05','2026-04-09 21:30:05',NULL);
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entregas_etapa`
--

DROP TABLE IF EXISTS `entregas_etapa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entregas_etapa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `aprendiz_id` bigint unsigned NOT NULL,
  `etapa_id` bigint unsigned NOT NULL,
  `proyecto_id` bigint unsigned NOT NULL,
  `url_archivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `estado` enum('pendiente','aprobada','rechazada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_entregas_etapa_etapa_id` (`etapa_id`),
  KEY `fk_entregas_etapa_proyecto_id` (`proyecto_id`),
  KEY `idx_entregas_etapa_contexto` (`aprendiz_id`,`etapa_id`,`proyecto_id`),
  CONSTRAINT `fk_entregas_etapa_aprendiz_id` FOREIGN KEY (`aprendiz_id`) REFERENCES `aprendices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_entregas_etapa_etapa_id` FOREIGN KEY (`etapa_id`) REFERENCES `etapas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_entregas_etapa_proyecto_id` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entregas_etapa`
--

LOCK TABLES `entregas_etapa` WRITE;
/*!40000 ALTER TABLE `entregas_etapa` DISABLE KEYS */;
/*!40000 ALTER TABLE `entregas_etapa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etapas`
--

DROP TABLE IF EXISTS `etapas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etapas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `proyecto_id` bigint unsigned NOT NULL,
  `orden` tinyint unsigned NOT NULL,
  `nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `etapas_proyecto_id_index` (`proyecto_id`),
  CONSTRAINT `fk_etapas_proyecto_id` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etapas`
--

LOCK TABLES `etapas` WRITE;
/*!40000 ALTER TABLE `etapas` DISABLE KEYS */;
/*!40000 ALTER TABLE `etapas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evidencias`
--

DROP TABLE IF EXISTS `evidencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evidencias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `aprendiz_id` bigint unsigned NOT NULL,
  `etapa_id` bigint unsigned NOT NULL,
  `proyecto_id` bigint unsigned NOT NULL,
  `ruta_archivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('pendiente','aprobada','rechazada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `comentario_instructor` text COLLATE utf8mb4_unicode_ci,
  `fecha_envio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_evidencias_aprendiz_proyecto` (`aprendiz_id`,`proyecto_id`),
  KEY `evidencias_estado_index` (`estado`),
  KEY `idx_evidencias_aprendiz_estado` (`aprendiz_id`,`estado`),
  KEY `idx_evidencias_etapa_estado` (`etapa_id`,`estado`),
  KEY `idx_evidencias_proyecto_estado` (`proyecto_id`,`estado`),
  KEY `idx_evidencias_fecha` (`fecha_envio`),
  CONSTRAINT `fk_evidencias_aprendiz_id` FOREIGN KEY (`aprendiz_id`) REFERENCES `aprendices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_evidencias_etapa_id` FOREIGN KEY (`etapa_id`) REFERENCES `etapas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_evidencias_proyecto_id` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evidencias`
--

LOCK TABLES `evidencias` WRITE;
/*!40000 ALTER TABLE `evidencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `evidencias` ENABLE KEYS */;
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
-- Table structure for table `instructores`
--

DROP TABLE IF EXISTS `instructores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `instructores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `especialidad` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `disponibilidad` enum('disponible','ocupado','no_disponible') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'disponible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `instructores_usuario_id_unique` (`usuario_id`),
  CONSTRAINT `fk_instructores_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructores`
--

LOCK TABLES `instructores` WRITE;
/*!40000 ALTER TABLE `instructores` DISABLE KEYS */;
INSERT INTO `instructores` VALUES (1,3,'Instructor','Demo','Desarrollo de Software',1,'disponible','2026-04-09 21:30:05','2026-04-09 21:30:05');
/*!40000 ALTER TABLE `instructores` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_11_000000_create_roles_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2025_01_01_000001_create_usuarios_table',1),(6,'2025_01_01_000002_create_aprendices_table',1),(7,'2025_01_01_000003_create_instructores_table',1),(8,'2025_01_01_000004_create_administradores_table',1),(9,'2025_01_01_000005_create_empresas_table',1),(10,'2025_01_01_000006_create_proyectos_table',1),(11,'2025_01_01_000007_create_postulaciones_table',1),(12,'2025_01_01_000008_create_etapas_table',1),(13,'2025_01_01_000009_create_evidencias_table',1),(14,'2025_01_01_000010_create_entregas_etapa_table',1),(15,'2025_01_01_000100_create_audit_logs_table',1),(16,'2025_01_01_000101_add_email_verified_at_to_usuarios_table',1),(20,'2026_03_24_192914_create_notifications_table',2),(21,'2026_04_10_133257_add_expires_at_to_password_reset_tokens_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
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
  `expires_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`),
  KEY `password_reset_tokens_created_at_index` (`created_at`),
  KEY `password_reset_tokens_expires_at_index` (`expires_at`)
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
-- Table structure for table `postulaciones`
--

DROP TABLE IF EXISTS `postulaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `postulaciones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `aprendiz_id` bigint unsigned NOT NULL,
  `proyecto_id` bigint unsigned NOT NULL,
  `fecha_postulacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('pendiente','en_revision','aceptada','rechazada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_postulaciones_aprendiz_proyecto` (`aprendiz_id`,`proyecto_id`),
  KEY `postulaciones_estado_index` (`estado`),
  KEY `idx_postulaciones_aprendiz_estado` (`aprendiz_id`,`estado`),
  KEY `idx_postulaciones_proyecto_estado` (`proyecto_id`,`estado`),
  KEY `idx_postulaciones_fecha` (`fecha_postulacion`),
  CONSTRAINT `fk_postulaciones_aprendiz_id` FOREIGN KEY (`aprendiz_id`) REFERENCES `aprendices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_postulaciones_proyecto_id` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `postulaciones`
--

LOCK TABLES `postulaciones` WRITE;
/*!40000 ALTER TABLE `postulaciones` DISABLE KEYS */;
INSERT INTO `postulaciones` VALUES (1,1,1,'2026-04-09 19:45:06','aceptada','2026-04-09 19:45:06','2026-04-09 20:45:15'),(2,1,7,'2026-04-09 19:45:25','rechazada','2026-04-09 19:45:25','2026-04-09 19:47:22'),(4,1,2,'2026-04-09 20:30:28','aceptada','2026-04-09 20:30:28','2026-04-09 20:42:33'),(5,1,3,'2026-04-09 20:42:21','pendiente','2026-04-09 20:42:21','2026-04-09 20:42:21'),(6,7,16,'2026-04-10 18:01:32','aceptada','2026-04-10 18:01:32','2026-04-10 18:05:17'),(7,7,2,'2026-04-10 18:06:37','aceptada','2026-04-10 18:06:37','2026-04-10 18:07:56'),(8,7,10,'2026-04-10 18:07:11','aceptada','2026-04-10 18:07:11','2026-04-10 18:10:14');
/*!40000 ALTER TABLE `postulaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proyectos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `empresa_nit` bigint unsigned NOT NULL,
  `instructor_usuario_id` bigint unsigned DEFAULT NULL,
  `titulo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `requisitos_especificos` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `habilidades_requeridas` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_publicacion` date NOT NULL,
  `duracion_estimada_dias` smallint unsigned NOT NULL,
  `estado` enum('pendiente','aprobado','rechazado','en_progreso','completado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `imagen_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_postulantes` int unsigned NOT NULL DEFAULT '0',
  `ubicacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_proyectos_empresa_nit` (`empresa_nit`),
  KEY `fk_proyectos_instructor_usuario_id` (`instructor_usuario_id`),
  KEY `proyectos_estado_index` (`estado`),
  KEY `proyectos_categoria_index` (`categoria`),
  KEY `idx_proyectos_estado_fecha` (`estado`,`fecha_publicacion`),
  CONSTRAINT `fk_proyectos_empresa_nit` FOREIGN KEY (`empresa_nit`) REFERENCES `empresas` (`nit`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_proyectos_instructor_usuario_id` FOREIGN KEY (`instructor_usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos`
--

LOCK TABLES `proyectos` WRITE;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` VALUES (1,12345475784,3,'Sistema de Gestión de Inventarios Inteligente','Software','Desarrollo de una plataforma web para el control de stock en tiempo real utilizando Laravel y Vue.js. El sistema debe incluir alertas de bajo inventario y reportes predictivos.','Conocimientos en PHP, Laravel, y bases de datos relacionales.','Programación Web, SQL, Trabajo en equipo','2026-04-09',90,'aprobado','https://images.unsplash.com/photo-1586769852044-692d6e3703f0?q=80&w=800',0,NULL,NULL,NULL,'2026-04-09 17:40:10','2026-04-09 17:40:10',NULL),(2,12345475784,3,'Rediseño de Identidad Visual Corporativa','Diseño','Creación de un manual de identidad corporativa completo, incluyendo logo, paleta de colores, tipografía y aplicaciones en papelería.','Manejo avanzado de Adobe Illustrator y Photoshop.','Diseño Gráfico, Branding, Creatividad','2026-04-09',45,'aprobado','https://images.unsplash.com/photo-1572044162444-ad60f128b7fa?q=80&w=800',0,NULL,NULL,NULL,'2026-04-09 17:40:10','2026-04-09 17:40:10',NULL),(3,12345475784,3,'Campaña de Marketing Digital SENA 2026','Marketing','Diseño y ejecución de una estrategia de redes sociales para aumentar el engagement en Instagram y LinkedIn.','Certificación en Google Ads o Meta Blueprint preferible.','Copywriting, Analytics, Estrategia Digital','2026-04-09',60,'aprobado','https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800',0,NULL,NULL,NULL,'2026-04-09 17:40:10','2026-04-09 17:40:10',NULL),(7,12345475784,3,'Automatización de Procesos con Python','Software','Scripts para automatizar la extracción de datos de reportes Excel y su carga en CRM corporativo.','Dominio de Python (Pandas, Openpyxl).','Python, Automatización, Ciencia de Datos','2026-04-09',30,'aprobado','https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=800',0,NULL,NULL,NULL,'2026-04-09 17:40:10','2026-04-09 17:40:10',NULL),(9,12345475784,NULL,'d','Otro','dad','ds','da','2026-05-02',0,'pendiente','proyectos/4Gr6HRoaateItzmHL58DjCJJgVXIgJzqUJiRu9uh.jpg',0,NULL,NULL,NULL,'2026-04-09 20:17:26','2026-04-09 20:17:26',NULL),(10,12345475784,3,'Sistema de Gestión de Inventarios Inteligente','Software','Desarrollo de una plataforma web para el control de stock en tiempo real utilizando Laravel y Vue.js. El sistema debe incluir alertas de bajo inventario y reportes predictivos.','Conocimientos en PHP, Laravel, y bases de datos relacionales.','Programación Web, SQL, Trabajo en equipo','2026-04-09',90,'aprobado','https://images.unsplash.com/photo-1586769852044-692d6e3703f0?q=80&w=800',0,NULL,NULL,NULL,'2026-04-09 21:30:05','2026-04-09 21:30:05',NULL),(11,12345475784,3,'Rediseño de Identidad Visual Corporativa','Diseño','Creación de un manual de identidad corporativa completo, incluyendo logo, paleta de colores, tipografía y aplicaciones en papelería.','Manejo avanzado de Adobe Illustrator y Photoshop.','Diseño Gráfico, Branding, Creatividad','2026-04-09',45,'aprobado','https://images.unsplash.com/photo-1572044162444-ad60f128b7fa?q=80&w=800',0,NULL,NULL,NULL,'2026-04-09 21:30:05','2026-04-09 21:30:05',NULL),(12,12345475784,3,'Campaña de Marketing Digital SENA 2026','Marketing','Diseño y ejecución de una estrategia de redes sociales para aumentar el engagement en Instagram y LinkedIn.','Certificación en Google Ads o Meta Blueprint preferible.','Copywriting, Analytics, Estrategia Digital','2026-04-09',60,'aprobado','https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800',0,NULL,NULL,NULL,'2026-04-09 21:30:05','2026-04-09 21:30:05',NULL),(13,12345475784,3,'App Móvil para Control de Asistencia','Software','Creación de una aplicación móvil híbrida para registro de entrada y salida mediante geolocalización.','Experiencia previa con frameworks móviles.','Mobile Development, APIs REST, Firebase','2026-04-09',120,'pendiente','https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?q=80&w=800',0,NULL,NULL,NULL,'2026-04-09 21:30:05','2026-04-09 21:30:05',NULL),(14,12345475784,3,'Documental Institucional \"Talento de Oro\"','Media','Producción audiovisual de 15 minutos capturando historias de éxito de los aprendices SENA.','Conocimientos en edición de video (Premiere/DaVinci Resolve).','Edición de Video, Fotografía, Narrativa Audiovisual','2026-04-09',75,'aprobado','https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800',0,NULL,NULL,NULL,'2026-04-09 21:30:05','2026-04-09 21:30:05',NULL),(15,12345475784,3,'Plataforma E-commerce para Artesanos','Software','Tienda en línea para artesanos locales con implementación de pasarelas de pago nacionales.','Entendimiento de flujos de pago y seguridad web.','Web Development, UX/UI, Pasarelas de Pago','2026-04-09',100,'aprobado','https://images.unsplash.com/photo-1557821552-17105176677c?q=80&w=800',0,NULL,NULL,NULL,'2026-04-09 21:30:06','2026-04-09 21:30:06',NULL),(16,12345475784,3,'Automatización de Procesos con Python','Software','Scripts para automatizar la extracción de datos de reportes Excel y su carga en CRM corporativo.','Dominio de Python (Pandas, Openpyxl).','Python, Automatización, Ciencia de Datos','2026-04-09',30,'aprobado','https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=800',0,NULL,NULL,NULL,'2026-04-09 21:30:06','2026-04-09 21:30:06',NULL),(17,12345475784,3,'Modelado 3D para Planta Industrial','Diseño','Modelado tridimensional de una nueva ala de producción para simulaciones de seguridad y logística.','Conocimiento en AutoCAD o Blender.','Modelado 3D, Planimetría, Renderizado','2026-04-09',80,'pendiente','https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=800',0,NULL,NULL,NULL,'2026-04-09 21:30:06','2026-04-09 21:30:06',NULL);
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_visible` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'aprendiz','Aprendiz','2026-04-09 21:30:05','2026-04-09 21:30:05'),(2,'instructor','Instructor','2026-04-09 21:30:05','2026-04-09 21:30:05'),(3,'empresa','Empresa','2026-04-09 21:30:05','2026-04-09 21:30:05'),(4,'administrador','Administrador','2026-04-09 21:30:05','2026-04-09 21:30:05');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `numero_documento` bigint unsigned NOT NULL,
  `correo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrasena` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `rol_id` bigint unsigned NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuarios_numero_documento_unique` (`numero_documento`),
  UNIQUE KEY `usuarios_correo_unique` (`correo`),
  KEY `fk_usuarios_rol_id` (`rol_id`),
  CONSTRAINT `fk_usuarios_rol_id` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,1043178690,'admin@gmail.com','$2y$12$E3Tu255LbXmCPTzWfFT6oOLY02XSr7h.QUq/O4xaLI.RlTFpxVd0y','2026-04-09 17:42:29',4,NULL,'2026-04-09 17:40:09','2026-04-09 17:40:09'),(2,12345475784,'empresa@gmail.com','$2y$12$CWTEUeD1dDO3GMny.AVny.fRtFTM03.e/23AS8R7LsTNWwhbv4Dlu','2026-04-09 17:42:29',3,NULL,'2026-04-09 17:40:09','2026-04-09 17:40:09'),(3,20123,'instructor@gmail.com','$2y$12$z8vw2vHetj9AlPmfk835ouQvyHfF0lWkEZSsy49o4gAFgvdMgEDSy','2026-04-09 17:42:29',2,NULL,'2026-04-09 17:40:09','2026-04-09 17:40:09'),(4,1016555423,'aprendiz@gmail.com','$2y$12$HVLcW9/LEswHWr/y7qZdwe3GWfRSExIFvlAVTnhKz0avHU.aYLubC','2026-04-09 17:42:29',1,NULL,'2026-04-09 17:40:10','2026-04-09 17:40:10'),(11,1043134877,'munozberdugoedwin@gmail.com','$2y$12$9l7FX2I.hbim/6ZAzrHkj.NX/9nFIStAO/Cx4DoWUX/1NQuoJao7.','2026-04-10 17:47:01',1,NULL,'2026-04-10 17:46:05','2026-04-10 17:47:01');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-10  9:09:11
