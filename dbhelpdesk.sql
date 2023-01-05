-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.27-MariaDB


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema dbhelpdesk
--

CREATE DATABASE IF NOT EXISTS dbhelpdesk;
USE dbhelpdesk;

--
-- Definition of table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `descripcion` varchar(1024) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorias`
--

/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` (`id`,`name`,`descripcion`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1,'Pagina Web Institucional','Administración de la Pagina Web Institucional',1,0,NULL,'2023-01-04 17:17:42');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;


--
-- Definition of table `categorias_responsables`
--

DROP TABLE IF EXISTS `categorias_responsables`;
CREATE TABLE `categorias_responsables` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `categoria_id` bigint(20) unsigned NOT NULL,
  `responsable_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categorias_responsables_categorias1_idx` (`categoria_id`),
  KEY `fk_categorias_responsables_responsables1_idx` (`responsable_id`),
  CONSTRAINT `fk_categorias_responsables_categorias1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_categorias_responsables_responsables1` FOREIGN KEY (`responsable_id`) REFERENCES `responsables` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias_responsables`
--

/*!40000 ALTER TABLE `categorias_responsables` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorias_responsables` ENABLE KEYS */;


--
-- Definition of table `incidencias`
--

DROP TABLE IF EXISTS `incidencias`;
CREATE TABLE `incidencias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `motivo` text DEFAULT NULL,
  `detalle` text DEFAULT NULL,
  `fecincidencia` datetime DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  `prioridad` tinyint(4) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `categoria_id` bigint(20) unsigned NOT NULL,
  `oficina_id` bigint(20) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `incidencias_categoria_id_foreign` (`categoria_id`),
  KEY `incidencias_user_id_foreign` (`user_id`),
  KEY `fk_incidencias_oficinas1_idx` (`oficina_id`),
  CONSTRAINT `fk_incidencias_oficinas1` FOREIGN KEY (`oficina_id`) REFERENCES `oficinas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `incidencias_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `incidencias_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incidencias`
--

/*!40000 ALTER TABLE `incidencias` DISABLE KEYS */;
INSERT INTO `incidencias` (`id`,`motivo`,`detalle`,`fecincidencia`,`estado`,`prioridad`,`activo`,`borrado`,`categoria_id`,`oficina_id`,`user_id`,`created_at`,`updated_at`) VALUES 
 (2,'No tengo acceso al SISGEDO','Mi usuario es jramirezc','2023-01-04 19:11:44',1,1,1,0,1,1,1,'2023-01-04 19:11:44','2023-01-04 19:11:44'),
 (3,'Problemas con el mouse.','No sirve el mouse de la computadora.','2023-01-04 19:38:07',0,2,1,0,1,1,1,'2023-01-04 19:38:07','2023-01-04 19:38:07'),
 (4,'Mi pantalla no prende.','Mi monitor esta apagado y no prende.','2023-01-04 21:03:34',1,1,1,0,1,2,1,'2023-01-04 21:03:34','2023-01-04 21:19:23'),
 (5,'abc','casda','2023-01-04 21:27:41',0,1,1,0,1,1,1,'2023-01-04 21:27:41','2023-01-04 21:27:41'),
 (6,'12123','12313','2023-01-04 16:29:26',1,1,1,0,1,2,1,'2023-01-04 16:29:26','2023-01-04 16:29:53'),
 (7,'No puedo realizar publicaciones','No puedo realizar publicaciones en la web','2023-01-04 17:31:19',1,1,1,0,1,1,2,'2023-01-04 17:31:19','2023-01-04 17:31:45');
/*!40000 ALTER TABLE `incidencias` ENABLE KEYS */;


--
-- Definition of table `oficinas`
--

DROP TABLE IF EXISTS `oficinas`;
CREATE TABLE `oficinas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `oficina` varchar(512) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oficinas`
--

/*!40000 ALTER TABLE `oficinas` DISABLE KEYS */;
INSERT INTO `oficinas` (`id`,`oficina`,`descripcion`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1,'SECRETARIA GENERAL','ASD',1,0,NULL,NULL),
 (2,'GERENCIA REGIONAL','ASD',1,0,NULL,NULL);
/*!40000 ALTER TABLE `oficinas` ENABLE KEYS */;


--
-- Definition of table `responsables`
--

DROP TABLE IF EXISTS `responsables`;
CREATE TABLE `responsables` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `apellidos` varchar(128) NOT NULL,
  `nombres` varchar(128) NOT NULL,
  `cargo` varchar(45) DEFAULT NULL,
  `activo` tinyint(4) NOT NULL,
  `borrado` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responsables`
--

/*!40000 ALTER TABLE `responsables` DISABLE KEYS */;
INSERT INTO `responsables` (`id`,`apellidos`,`nombres`,`cargo`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1,'Mendoza Ramirez','Juan','Programador Web',1,0,'2023-01-05 08:22:35','2023-01-05 08:22:35');
/*!40000 ALTER TABLE `responsables` ENABLE KEYS */;


--
-- Definition of table `solucions`
--

DROP TABLE IF EXISTS `solucions`;
CREATE TABLE `solucions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `detalle` text NOT NULL,
  `fecsolucion` datetime NOT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `incidencia_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `solucions_incidencia_id_foreign` (`incidencia_id`),
  KEY `solucions_user_id_foreign` (`user_id`),
  CONSTRAINT `solucions_incidencia_id_foreign` FOREIGN KEY (`incidencia_id`) REFERENCES `incidencias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `solucions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `solucions`
--

/*!40000 ALTER TABLE `solucions` DISABLE KEYS */;
INSERT INTO `solucions` (`id`,`detalle`,`fecsolucion`,`activo`,`borrado`,`incidencia_id`,`user_id`,`created_at`,`updated_at`) VALUES 
 (1,'Se soluciono','0000-00-00 00:00:00',1,0,2,1,NULL,NULL),
 (2,'Se realizo la conexión del monitor.','2023-01-04 21:19:23',1,0,4,1,'2023-01-04 21:19:23','2023-01-04 21:19:23'),
 (3,'Se dio solucion.','2023-01-04 16:29:53',1,0,6,1,'2023-01-04 16:29:53','2023-01-04 16:29:53'),
 (4,'Se realizo una actualizacion de su pc.','2023-01-04 17:31:45',1,0,7,1,'2023-01-04 17:31:45','2023-01-04 17:31:45');
/*!40000 ALTER TABLE `solucions` ENABLE KEYS */;


--
-- Definition of table `tipousers`
--

DROP TABLE IF EXISTS `tipousers`;
CREATE TABLE `tipousers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `descripcion` text NOT NULL,
  `nivel` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`nombre`,`descripcion`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipousers`
--

/*!40000 ALTER TABLE `tipousers` DISABLE KEYS */;
INSERT INTO `tipousers` (`id`,`nombre`,`descripcion`,`nivel`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1,'Administrador','',1,1,0,NULL,NULL),
 (2,'Funcionario','',2,1,0,NULL,NULL);
/*!40000 ALTER TABLE `tipousers` ENABLE KEYS */;


--
-- Definition of table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombres` varchar(512) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipouser_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_tipo_users1_idx` (`tipouser_id`),
  CONSTRAINT `fk_users_tipo_users1` FOREIGN KEY (`tipouser_id`) REFERENCES `tipousers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`,`nombres`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`,`tipouser_id`) VALUES 
 (1,'admin','admin','admin@gmail.com','$2a$12$awr62x.CS3Q2Pwn5if2q5uV94MgizwpMNZJDgQZGGqpQewYIq3Jhy','$2a$12$awr62x.CS3Q2Pwn5if2q5uV94MgizwpMNZJDgQZGGqpQewYIq3Jhy',NULL,NULL,1),
 (2,'Juan Mendoza Ramos','jmendozar','jmendozar@gmail.com','$2a$12$awr62x.CS3Q2Pwn5if2q5uV94MgizwpMNZJDgQZGGqpQewYIq3Jhy','$2a$12$awr62x.CS3Q2Pwn5if2q5uV94MgizwpMNZJDgQZGGqpQewYIq3Jhy',NULL,NULL,2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
