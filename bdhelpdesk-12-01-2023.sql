
--
-- Definition of table `responsables`
--

DROP TABLE IF EXISTS `responsables`;
CREATE TABLE `responsables` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(128) NOT NULL,
  `cargo` varchar(45) DEFAULT NULL,
  `activo` tinyint(4) NOT NULL,
  `borrado` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responsables`
--

/*!40000 ALTER TABLE `responsables` DISABLE KEYS */;
INSERT INTO `responsables` (`id`,`nombres`,`cargo`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1,'Juan Carlos Tipismana Marreros','Subgerencia de Tecnologias de la Informacion ',1,0,'2023-01-05 14:31:26','2023-01-05 14:31:26'),
 (2,'Jose Antonio Diaz Vera',NULL,1,0,'2023-01-05 14:31:26','2023-01-05 14:31:26'),
 (3,'Erick Antonio Alarcon Pinedo',NULL,1,0,'2023-01-05 14:31:26','2023-01-05 14:31:26'),
 (4,'Edwin Perez Macedo',NULL,1,0,'2023-01-05 14:31:26','2023-01-05 14:31:26'),
 (5,'Hans Cesar Davila Romero',NULL,1,0,'2023-01-05 14:31:26','2023-01-05 14:31:26'),
 (6,'Elias Rodriguez de Paz',NULL,1,0,'2023-01-05 14:31:26','2023-01-05 14:31:26');
/*!40000 ALTER TABLE `responsables` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorias`
--

/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;


--
-- Definition of table `categorias_responsables`
--

DROP TABLE IF EXISTS `categorias_responsables`;
CREATE TABLE `categorias_responsables` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `categoria_id` bigint(20) unsigned NOT NULL,
  `responsable_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categorias_responsables_categorias1_idx` (`categoria_id`),
  KEY `fk_categorias_responsables_responsables1_idx` (`responsable_id`),
  CONSTRAINT `fk_categorias_responsables_categorias1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_categorias_responsables_responsables1` FOREIGN KEY (`responsable_id`) REFERENCES `responsables` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias_responsables`
--

/*!40000 ALTER TABLE `categorias_responsables` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorias_responsables` ENABLE KEYS */;


--
-- Definition of table `tipousers`
--

DROP TABLE IF EXISTS `tipousers`;
CREATE TABLE `tipousers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`nombre`,`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipousers`
--

/*!40000 ALTER TABLE `tipousers` DISABLE KEYS */;
INSERT INTO `tipousers` (`id`,`nombre`,`descripcion`,`nivel`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1,'Administrador','',1,1,0,'2023-01-05 14:31:26','2023-01-05 14:31:26'),
 (2,'Mesa de Ayuda - Informatica','',2,1,0,'2023-01-05 14:31:26','2023-01-05 14:31:26'),
 (3,'Area Usuaria','',3,1,0,'2023-01-05 14:31:26','2023-01-05 14:31:26');
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
  `activo` tinyint(4) NOT NULL DEFAULT 1,
  `borrado` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_users_tipo_users1_idx` (`tipouser_id`),
  CONSTRAINT `fk_users_tipo_users1` FOREIGN KEY (`tipouser_id`) REFERENCES `tipousers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`,`nombres`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`,`tipouser_id`,`activo`,`borrado`) VALUES 
 (1,'admin','admin','admin@gmail.com','$2a$12$awr62x.CS3Q2Pwn5if2q5uV94MgizwpMNZJDgQZGGqpQewYIq3Jhy','YO84Jq65qilFdnE8rv26dHDJpOLEvik4IamosiMTgOQ35hYBj52Wqjs0S1hh','2023-01-05 14:31:26','2023-01-05 14:31:26',1,1,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


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
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `oficina` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `incidencias_categoria_id_foreign` (`categoria_id`),
  KEY `incidencias_user_id_foreign` (`user_id`),
  CONSTRAINT `incidencias_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `incidencias_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incidencias`
--

/*!40000 ALTER TABLE `incidencias` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `solucions`
--

/*!40000 ALTER TABLE `solucions` DISABLE KEYS */;
/*!40000 ALTER TABLE `solucions` ENABLE KEYS */;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
