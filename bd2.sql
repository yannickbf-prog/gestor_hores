-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `bag_hours`;
CREATE TABLE `bag_hours` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `type_id` bigint unsigned NOT NULL,
  `hores_contractades` int NOT NULL,
  `hores_disponibles` int NOT NULL,
  `preu_total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bag_hours_project_id_foreign` (`project_id`),
  KEY `bag_hours_type_id_foreign` (`type_id`),
  CONSTRAINT `bag_hours_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `bag_hours_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `type_bag_hours` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int NOT NULL,
  `name` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_logo` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_sector` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` bigint DEFAULT NULL,
  `website` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_lang` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `company` (`id`, `name`, `img_logo`, `work_sector`, `description`, `email`, `phone`, `website`, `default_lang`, `date_format`, `currency`) VALUES
(1,	'aTotArreu',	'logo.png',	'computer_science',	'Lorem ipsum default company',	'example@example.com',	900200100,	'www.example.com',	'ca',	'd/m/Y',	'€');

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` bigint NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_name_unique` (`name`),
  UNIQUE KEY `customers_email_unique` (`email`),
  UNIQUE KEY `customers_phone_unique` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `failed_jobs`;
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


DROP TABLE IF EXISTS `hours_entry`;
CREATE TABLE `hours_entry` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_project_id` bigint unsigned NOT NULL,
  `bag_hours_id` bigint unsigned NOT NULL,
  `hours` int NOT NULL,
  `validate` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hours_entry_user_project_id_foreign` (`user_project_id`),
  KEY `hours_entry_bag_hours_id_foreign` (`bag_hours_id`),
  CONSTRAINT `hours_entry_bag_hours_id_foreign` FOREIGN KEY (`bag_hours_id`) REFERENCES `bag_hours` (`id`),
  CONSTRAINT `hours_entry_user_project_id_foreign` FOREIGN KEY (`user_project_id`) REFERENCES `users_projects` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(141,	'2021_04_23_171648_add_role_to_users_table',	1),
(162,	'2014_10_12_000000_create_users_table',	2),
(163,	'2014_10_12_100000_create_password_resets_table',	2),
(164,	'2019_08_19_000000_create_failed_jobs_table',	2),
(165,	'2021_04_01_125130_create_customers_table',	2),
(166,	'2021_04_01_131937_create_projects_table',	2),
(167,	'2021_04_01_140855_create_type_bag_hours_table',	2),
(168,	'2021_04_01_142217_create_bag_hours_table',	2),
(169,	'2021_04_01_155604_create_users_projects_table',	2),
(170,	'2021_04_01_160948_create_hours_entry_table',	2),
(171,	'2021_04_01_162628_create_company_table',	2);

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('yannickbf2@gmail.com',	'$2y$10$5v.0GkLT12tYqNKRmZVmn.hDK/PVDAr3fXkyC95gS.XHJ7zOKPVzy',	'2021-05-05 14:13:40');

DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_customer_id_foreign` (`customer_id`),
  CONSTRAINT `projects_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `type_bag_hours`;
CREATE TABLE `type_bag_hours` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hour_price` double(7,2) NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_bag_hours_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `type_bag_hours` (`id`, `name`, `hour_price`, `description`, `created_at`, `updated_at`) VALUES
(1,	'Diseny de web',	15.00,	NULL,	'2021-05-04 13:27:47',	'2021-05-04 13:27:47');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` bigint DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_nickname_unique` (`nickname`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `nickname`, `name`, `surname`, `email`, `phone`, `description`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2,	'yann9',	'yannick',	'baratte forner',	'yannickbf2@gmail.com',	672117858,	NULL,	'admin',	NULL,	'ordenador',	'8b7AaRkNwT1S9cNaiWnNuRLSb9Ka3HGvmYlOKUpisDdjk13QZ9gqEkNaG0Hr',	'2021-05-03 17:55:07',	'2021-05-05 15:57:21'),
(3,	'yann3',	'baratte forner',	'yannick',	'yannickbf3@gmail.com',	900100202,	NULL,	'admin',	NULL,	'$2y$10$TyT0Qy07EUm4YmUtTj7h8O/AB6SV8WuRUc6XBne8rFP8WcIz0fh6G',	'UllXx1BGmob2nOA9ZSRubp5ZVGOYZNSOrLTQTvTsKGqN3Wtggnt1yd6Th9AT',	'2021-05-05 13:17:57',	'2021-05-05 13:17:57'),
(4,	'yann4',	'baratte forner',	'yannick',	'yannickbf4@gmail.com',	900100203,	NULL,	'user',	NULL,	'$2y$10$SLoXkG6UcLnuwNK/3XZHf.XWqJ1bgdW60tlC35XAnqsThdu4geeCu',	NULL,	'2021-05-05 13:29:47',	'2021-05-05 13:29:47'),
(5,	'yann5',	'baratte forner',	'yannick',	'yannickbf5@gmail.com',	900100201,	NULL,	'user',	NULL,	'$2y$10$xx3PxXvvzUy1TvXH8eOCNu/w57C3t0lq5QOV6.Cv396jgZAJ.o/O.',	NULL,	'2021-05-05 13:36:20',	'2021-05-05 13:36:20'),
(6,	'yann7',	'yannick',	'yannick',	'yannickbf7@gmail.com',	900100207,	NULL,	'user',	NULL,	'$2y$10$UgtIiaKYVCiLnLaOlfcKTOxuPxGy9Lo4d5iTTkYQf3DVqXaI00p6a',	NULL,	'2021-05-05 14:07:34',	'2021-05-05 14:07:34'),
(7,	'yann8',	'yannick',	'yannick',	'yannickbf8@gmail.com',	900100208,	NULL,	'user',	NULL,	'$2y$10$IgBnm0zvdjPT4FPmrYqVPemKqP.WKen8S418.EXerg7NuYuUgzQNq',	NULL,	'2021-05-05 14:11:12',	'2021-05-05 14:11:12'),
(8,	'yann10',	'yannick',	'baratte',	'yannickbf9@gmail.com',	90000200,	NULL,	'user',	NULL,	'$2y$10$0a3YU0A/hvj0Gy8DUqm7TO2feP4q0lL3rXmOvGV0Kp7ya0TiBlauu',	NULL,	'2021-05-06 19:23:15',	'2021-05-06 19:23:15'),
(9,	'yann11',	'yannick',	'baratte forner',	'yannickbf10@gmail.com',	NULL,	NULL,	'user',	NULL,	'ordenador',	NULL,	'2021-05-06 21:24:07',	'2021-05-06 21:24:07'),
(10,	'yannick120',	'yannick',	'baratte forner',	'yannickbf120@gmail.com',	NULL,	NULL,	'user',	NULL,	'ordenador',	NULL,	'2021-05-06 22:00:36',	'2021-05-06 22:00:36'),
(11,	'yann121',	'yannick',	'baratte forner',	'yannickbf@121gmail.com',	NULL,	NULL,	'user',	NULL,	'ordenador',	NULL,	'2021-05-06 22:03:29',	'2021-05-06 22:03:29'),
(12,	'yann122',	'yannick',	'baratte forner',	'yannickbf122@gmail.com',	600100200,	NULL,	'user',	NULL,	'$2y$10$ZbdMyb0qe4rkOCN9CNFKyOBptNyMI6ZkxZZiWi7yaYkO3j5HO7HpS',	NULL,	'2021-05-07 13:47:53',	'2021-05-07 16:52:07'),
(13,	'yann20',	'yannick',	'baratte forner',	'yannickbf20@gmail.com',	NULL,	NULL,	'user',	NULL,	'$2y$10$wTLdphlccTf55xv/mR6J5u7l7dm0AnFUPZIRhMqLpfRQnQQP7utYO',	NULL,	'2021-05-07 14:18:33',	'2021-05-07 14:18:33'),
(14,	'yannick135',	'yannick',	'baratte forner',	'yannickbf@gmal.com',	NULL,	NULL,	'user',	NULL,	'$2y$10$DqtdY5gce5MV4x6wXYsK0eO6OGabRbT.MCZJsuD52dyRN1V0UMw4.',	NULL,	'2021-05-07 14:54:49',	'2021-05-07 14:54:49'),
(15,	'yann136',	'yannick',	'baratte forner',	'yannickbf36@gmail.com',	NULL,	NULL,	'user',	NULL,	'$2y$10$YW6eZaaujU/SVg78zTlJ0edsg7tW/bY6mjL4v3FFUDMvOb/Hg8sMW',	NULL,	'2021-05-07 14:56:51',	'2021-05-07 14:56:51');

DROP TABLE IF EXISTS `users_projects`;
CREATE TABLE `users_projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `project_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_projects_user_id_foreign` (`user_id`),
  KEY `users_projects_project_id_foreign` (`project_id`),
  CONSTRAINT `users_projects_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `users_projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2021-05-07 22:06:20
