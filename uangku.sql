/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.11-MariaDB : Database - uangku
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `cache` */

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `credit_card_installments` */

CREATE TABLE `credit_card_installments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `credit_card_id` bigint(20) unsigned DEFAULT NULL,
  `total_amount` decimal(16,2) DEFAULT NULL,
  `installment_amount` decimal(16,2) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `installment_months` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `credit_card_id` (`credit_card_id`),
  CONSTRAINT `credit_card_installments_ibfk_1` FOREIGN KEY (`credit_card_id`) REFERENCES `credit_cards` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `credit_card_installments` */

/*Table structure for table `credit_cards` */

CREATE TABLE `credit_cards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `debt_id` bigint(20) unsigned NOT NULL,
  `billing_day` smallint(6) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallet_id` (`debt_id`),
  CONSTRAINT `credit_cards_ibfk_2` FOREIGN KEY (`debt_id`) REFERENCES `debts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `credit_cards` */

insert  into `credit_cards`(`id`,`debt_id`,`billing_day`,`is_active`) values 
(4,3,20,1),
(5,4,9,1),
(6,5,15,1);

/*Table structure for table `debt_statuses` */

CREATE TABLE `debt_statuses` (
  `id` char(1) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `debt_statuses` */

insert  into `debt_statuses`(`id`,`name`) values 
('A','Belum Dibayar'),
('P','Sebagian'),
('X','Lunas');

/*Table structure for table `debts` */

CREATE TABLE `debts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `total_amount` decimal(18,2) NOT NULL,
  `remaining_amount` decimal(18,2) NOT NULL,
  `start_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `debt_status_id` char(1) NOT NULL DEFAULT 'A',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallet_id` (`payment_id`),
  KEY `debt_status_id` (`debt_status_id`),
  CONSTRAINT `debts_ibfk_1` FOREIGN KEY (`debt_status_id`) REFERENCES `debt_statuses` (`id`),
  CONSTRAINT `debts_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `debts` */

insert  into `debts`(`id`,`payment_id`,`name`,`total_amount`,`remaining_amount`,`start_date`,`due_date`,`description`,`debt_status_id`,`is_active`,`created_at`,`updated_at`) values 
(2,8,'KUR',5000000.00,5000000.00,'2025-05-07',NULL,'Kredit Usaha Rakyat','A',1,'2025-05-07 10:34:14',NULL),
(3,11,'Kartu Kredit BCA',20000000.00,19896000.00,'2025-06-24',NULL,NULL,'A',1,'2025-06-24 16:16:20',NULL),
(4,12,'Kartu Kredit MNC',10000000.00,10000000.00,'2025-09-09',NULL,NULL,'A',1,'2025-09-09 16:45:44',NULL),
(5,15,'Kartu Kredit BNI',2000000.00,2000000.00,'2025-11-15',NULL,NULL,'A',1,'2025-11-07 11:20:27',NULL);

/*Table structure for table `expense_categories` */

CREATE TABLE `expense_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `expense_categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `expense_categories` */

insert  into `expense_categories`(`id`,`user_id`,`name`,`logo`,`created_at`) values 
(2,NULL,'Belanja','icon-badge-dollar-sign','2025-08-20 09:02:04'),
(3,NULL,'Makanan','icon-hamburger','2025-08-20 11:48:26'),
(4,NULL,'Motor','icon-bike','2025-08-20 11:48:34'),
(5,NULL,'Asuransi',NULL,'2025-08-20 11:49:00'),
(6,NULL,'Transportasi','icon-car-taxi-front','2025-08-20 11:49:21'),
(7,NULL,'Lainnya','icon-rectangle-ellipsis','2025-08-20 11:49:30'),
(8,NULL,'Hiburan','icon-ticket','2025-08-20 11:49:44'),
(9,NULL,'Biaya Admin','icon-dollar','2025-11-17 13:58:58');

/*Table structure for table `expense_subscriptions` */

CREATE TABLE `expense_subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint(20) unsigned NOT NULL,
  `expenses_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_id` (`subscription_id`),
  KEY `expenses_id` (`expenses_id`),
  CONSTRAINT `expense_subscriptions_ibfk_1` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`),
  CONSTRAINT `expense_subscriptions_ibfk_2` FOREIGN KEY (`expenses_id`) REFERENCES `expenses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `expense_subscriptions` */

/*Table structure for table `expenses` */

CREATE TABLE `expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `payment_id` bigint(20) unsigned NOT NULL,
  `expense_category_id` bigint(20) unsigned NOT NULL,
  `expense_title` varchar(100) DEFAULT NULL,
  `expense_amount` decimal(18,2) DEFAULT NULL,
  `expense_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_id` (`payment_id`),
  KEY `user_id` (`user_id`),
  KEY `expense_category_id` (`expense_category_id`),
  CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`),
  CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `expenses_ibfk_3` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `expenses` */

insert  into `expenses`(`id`,`user_id`,`payment_id`,`expense_category_id`,`expense_title`,`expense_amount`,`expense_date`,`description`,`created_at`,`updated_at`) values 
(3,5,2,2,'Beli Baju',250000.00,'2025-09-11',NULL,'2025-09-11 09:53:50',NULL),
(9,5,4,8,'Subscription: Youtube Premium',154000.00,'2025-10-23','Youtube Premium','2025-10-23 16:44:27',NULL),
(16,5,10,9,'Biaya Admin BCA',16000.00,'2025-11-24','Biaya Admin BCA','2025-11-24 12:30:00',NULL),
(17,5,17,9,'Biaya Admin BNI',11000.00,'2025-11-24','Biaya Admin BNI','2025-11-24 12:30:00',NULL),
(19,5,17,4,'PARKIR',10000.00,'2025-11-24',NULL,'2025-11-24 13:52:11',NULL);

/*Table structure for table `failed_jobs` */

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `income_categories` */

CREATE TABLE `income_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `income_categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `income_categories` */

insert  into `income_categories`(`id`,`user_id`,`name`,`created_at`) values 
(1,5,'Gaji','2025-05-09 13:46:02'),
(2,5,'Freelance','2025-08-20 15:12:55'),
(3,5,'Penjualan Saham','2025-08-20 15:13:20');

/*Table structure for table `incomes` */

CREATE TABLE `incomes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_id` bigint(20) unsigned NOT NULL,
  `income_category_id` bigint(20) unsigned NOT NULL,
  `income_amount` decimal(18,2) NOT NULL,
  `transaction_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallet_id` (`wallet_id`),
  KEY `income_category_id` (`income_category_id`),
  CONSTRAINT `incomes_ibfk_1` FOREIGN KEY (`wallet_id`) REFERENCES `payments` (`id`),
  CONSTRAINT `incomes_ibfk_2` FOREIGN KEY (`income_category_id`) REFERENCES `income_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `incomes` */

insert  into `incomes`(`id`,`wallet_id`,`income_category_id`,`income_amount`,`transaction_date`,`description`,`created_at`,`updated_at`) values 
(6,10,1,5000000.00,'2025-05-09','Gaji Bulan Mei','2025-05-09 15:22:36',NULL),
(8,13,2,1000000.00,'2025-11-07','Test Gaji','2025-11-07 15:24:09',NULL);

/*Table structure for table `invest_growths` */

CREATE TABLE `invest_growths` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invest_id` bigint(20) unsigned NOT NULL,
  `date` date DEFAULT NULL,
  `balance` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invest_id` (`invest_id`),
  CONSTRAINT `invest_growths_ibfk_1` FOREIGN KEY (`invest_id`) REFERENCES `invests` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `invest_growths` */

/*Table structure for table `invests` */

CREATE TABLE `invests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `balance` decimal(18,2) NOT NULL,
  `purchase_value` decimal(18,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invests_ibfk_1` (`wallet_id`),
  CONSTRAINT `invests_ibfk_1` FOREIGN KEY (`wallet_id`) REFERENCES `payments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `invests` */

/*Table structure for table `job_batches` */

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `migrations` */

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1);

/*Table structure for table `password_reset_tokens` */

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `payment_transaction_types` */

CREATE TABLE `payment_transaction_types` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `payment_transaction_types` */

insert  into `payment_transaction_types`(`id`,`name`) values 
(1,'Income'),
(2,'Expense'),
(3,'Transfer In'),
(4,'Transfer Out'),
(5,'Debt'),
(6,'Receivables'),
(7,'Invest'),
(8,'Payment Credit Card');

/*Table structure for table `payment_types` */

CREATE TABLE `payment_types` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `payment_types` */

insert  into `payment_types`(`id`,`name`) values 
(3,'Bank'),
(1,'Cash'),
(2,'E-Wallet'),
(6,'Hutang'),
(8,'Investasi'),
(7,'Piutang');

/*Table structure for table `payments` */

CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `payment_type_id` smallint(6) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `wallet_type_id` (`payment_type_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Data for the table `payments` */

insert  into `payments`(`id`,`user_id`,`payment_type_id`,`is_active`,`created_at`,`updated_at`) values 
(1,1,1,1,'2025-04-28 15:54:52','2025-04-28 15:54:52'),
(2,5,1,1,'2025-04-30 10:48:24','2025-04-30 10:48:24'),
(4,5,6,1,'2025-04-30 14:46:40','2025-04-30 14:46:40'),
(7,5,6,1,'2025-05-07 10:33:06','2025-05-07 10:33:06'),
(8,5,6,1,'2025-05-07 10:34:14','2025-05-07 10:34:14'),
(9,5,7,1,'2025-05-07 15:27:32','2025-05-07 15:27:32'),
(10,5,3,1,'2025-05-08 14:10:17','2025-05-08 14:10:17'),
(11,5,6,1,'2025-06-24 16:16:20','2025-06-24 16:16:20'),
(12,5,6,1,'2025-09-09 16:45:44','2025-09-09 16:45:44'),
(13,5,3,1,'2025-09-10 14:08:19','2025-09-10 14:08:19'),
(14,5,3,1,'2025-11-05 16:52:09','2025-11-05 16:52:09'),
(15,5,6,1,'2025-11-07 11:20:27','2025-11-07 11:20:27'),
(16,5,7,1,'2025-11-07 14:40:47','2025-11-07 14:40:47'),
(17,5,3,1,'2025-11-24 11:52:26','2025-11-24 11:52:26');

/*Table structure for table `receivable_statuses` */

CREATE TABLE `receivable_statuses` (
  `id` char(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `receivable_statuses` */

insert  into `receivable_statuses`(`id`,`name`) values 
('A','Belum Dibayar'),
('P','Sebagian'),
('X','Lunas');

/*Table structure for table `receivables` */

CREATE TABLE `receivables` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `total_amount` decimal(18,2) NOT NULL,
  `remaining_amount` decimal(18,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `receivable_status_id` char(1) DEFAULT 'A',
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallet_id` (`payment_id`),
  KEY `receivable_status_id` (`receivable_status_id`),
  CONSTRAINT `receivables_ibfk_2` FOREIGN KEY (`receivable_status_id`) REFERENCES `receivable_statuses` (`id`),
  CONSTRAINT `receivables_ibfk_3` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `receivables` */

insert  into `receivables`(`id`,`payment_id`,`name`,`total_amount`,`remaining_amount`,`start_date`,`due_date`,`receivable_status_id`,`description`,`created_at`,`updated_at`) values 
(1,9,'Piutang Ditta',1000000.00,1000000.00,'2025-05-07',NULL,'A','Piutang Ditta','2025-05-07 15:27:32',NULL),
(2,16,'Piutang Meigant',200000.00,200000.00,'2025-11-07',NULL,'A',NULL,'2025-11-07 14:40:47',NULL);

/*Table structure for table `sessions` */

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('90oqSw9U6bUyz4FwXzfDcnJeGCP1MI11LDumN7u1',5,'127.0.0.1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMHp1eXRNQndHUkpSYTBSSnA3SGRPanpxRXBacnhIYVY3cGxBcm8zQSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyOToiaHR0cDovL2xvY2FsaG9zdDo4MDg4L2luY29tZXMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MjoiaHR0cDovL2xvY2FsaG9zdDo4MDg4L3N1YnNjcmlwdGlvbnMvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9',1763713499),
('yMfLfhlHgGO13aHk4RYvKMI7VeVT6JAI202lRv88',5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoidnJvVTdzUzJiTmw0VXdCUnNxTG5xaVlLR3k4T3BDbXVJSUJZSGJoeiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNjoiaHR0cDovL2xvY2FsaG9zdDo4MDg4L2hvbWUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMDoiaHR0cDovL2xvY2FsaG9zdDo4MDg4L2V4cGVuc2VzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9',1763967132);

/*Table structure for table `subscription_expenses` */

CREATE TABLE `subscription_expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint(20) unsigned NOT NULL,
  `expense_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `subscription_expenses` */

insert  into `subscription_expenses`(`id`,`subscription_id`,`expense_id`,`created_at`,`updated_at`) values 
(2,15,7,'2025-10-23 16:39:04',NULL),
(4,17,9,'2025-10-23 16:44:27',NULL);

/*Table structure for table `subscription_types` */

CREATE TABLE `subscription_types` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `subscription_types` */

insert  into `subscription_types`(`id`,`name`) values 
(1,'Bulanan'),
(2,'Tahunan');

/*Table structure for table `subscriptions` */

CREATE TABLE `subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_description` varchar(200) NOT NULL,
  `subscription_date` date NOT NULL,
  `subscription_day` smallint(2) DEFAULT NULL,
  `subscription_month` smallint(2) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `credit_card_id` bigint(20) unsigned NOT NULL,
  `expense_category_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(16,2) NOT NULL,
  `subscription_type_id` smallint(5) unsigned NOT NULL,
  `subscription_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_type_id` (`subscription_type_id`),
  KEY `expense_category_id` (`expense_category_id`),
  KEY `user_id` (`user_id`),
  KEY `credit_cards_id` (`credit_card_id`),
  CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`subscription_type_id`) REFERENCES `subscription_types` (`id`),
  CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`),
  CONSTRAINT `subscriptions_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `subscriptions_ibfk_4` FOREIGN KEY (`credit_card_id`) REFERENCES `credit_cards` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Data for the table `subscriptions` */

insert  into `subscriptions`(`id`,`subscription_description`,`subscription_date`,`subscription_day`,`subscription_month`,`user_id`,`credit_card_id`,`expense_category_id`,`amount`,`subscription_type_id`,`subscription_status`,`created_at`,`updated_at`) values 
(17,'Youtube Premium','2025-10-23',23,10,5,4,8,154000.00,1,1,'2025-10-23 16:44:27',NULL);

/*Table structure for table `transfers` */

CREATE TABLE `transfers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `from_wallet_id` bigint(20) unsigned NOT NULL,
  `to_wallet_id` bigint(20) unsigned NOT NULL,
  `transfer_amount` decimal(18,2) NOT NULL,
  `description` text DEFAULT NULL,
  `transfer_date` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `from_wallet_id` (`from_wallet_id`),
  KEY `to_wallet_id` (`to_wallet_id`),
  CONSTRAINT `transfers_ibfk_1` FOREIGN KEY (`from_wallet_id`) REFERENCES `payments` (`id`),
  CONSTRAINT `transfers_ibfk_2` FOREIGN KEY (`to_wallet_id`) REFERENCES `payments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `transfers` */

insert  into `transfers`(`id`,`from_wallet_id`,`to_wallet_id`,`transfer_amount`,`description`,`transfer_date`,`created_at`) values 
(2,10,2,500000.00,'Tarik dari ATM','2025-05-09','2025-05-09 15:42:28');

/*Table structure for table `user_categories` */

CREATE TABLE `user_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_categories` */

insert  into `user_categories`(`id`,`name`) values 
(1,'Admin'),
(2,'User');

/*Table structure for table `users` */

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_category_id` bigint(20) unsigned DEFAULT 2,
  `status_user` tinyint(1) DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_link` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `user_category_id` (`user_category_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_category_id`) REFERENCES `user_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`user_category_id`,`status_user`,`remember_token`,`activation_link`,`created_at`,`updated_at`) values 
(1,'Febrari Supaldi','febrarisupaldi@gmail.com',NULL,'$argon2i$v=19$m=65536,t=4,p=1$VjZRRjBNMlhEQmliUVkvTQ$fIvRvoX4NUQxybyU7MsJeozF5qUXPo6XnG6VDPcGB2M',1,1,NULL,NULL,'2025-04-28 15:44:53',NULL),
(5,'Paldi','contoh@gmail.com','2025-04-29 04:47:54','$argon2i$v=19$m=65536,t=4,p=1$cUtHVDFycjVWVkNRSU5xSQ$sFfjvImdTv4eRmJYcajsqnj+t5iC4iNn55VwKQQEuCk',2,1,NULL,NULL,NULL,NULL),
(7,'Haha Hihi','haha@gmail.com','2025-10-01 02:55:42','$argon2i$v=19$m=65536,t=4,p=1$MnliLzFCaXNXMHZ3dHdtSg$Ca7irgoaHb7Td5LhSXLwtelqrfBUiKI1/B7ZKyD4UpU',2,1,NULL,NULL,NULL,NULL);

/*Table structure for table `wallet_transactions` */

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

/*Data for the table `wallet_transactions` */

insert  into `wallet_transactions`(`id`,`wallet_id`,`wallet_transaction_type_id`,`transaction_id`,`amount`,`before_balance`,`after_balance`,`transaction_date`,`transaction_note`,`created_at`,`updated_at`) values 
(6,10,1,6,5000000.00,0.00,5000000.00,'2025-05-09','Gaji Bulan Mei','2025-05-09 15:22:36',NULL),
(7,10,4,2,500000.00,4500000.00,4000000.00,'2025-05-09','Tarik dari ATM','2025-05-09 15:42:28',NULL),
(8,2,3,2,500000.00,0.00,500000.00,'2025-05-09','Tarik dari ATM','2025-05-09 15:42:28',NULL),
(10,2,2,3,250000.00,500000.00,250000.00,'2025-09-11',NULL,'2025-09-11 09:53:50',NULL),
(14,4,2,NULL,154000.00,0.00,-154000.00,'2025-10-23','Youtube Premium','2025-10-23 16:39:04',NULL),
(16,4,2,NULL,154000.00,0.00,-154000.00,'2025-10-23','Youtube Premium','2025-10-23 16:44:27',NULL),
(18,13,1,NULL,1000000.00,500000.00,1500000.00,'2025-11-07','Test Gaji','2025-11-07 15:24:09',NULL),
(20,10,2,NULL,4500000.00,4500000.00,0.00,'2025-11-18','Biaya AdminBCA','2025-11-18 15:21:10',NULL),
(21,10,2,NULL,16000.00,4500000.00,4484000.00,'2025-11-18','Biaya Admin BCA','2025-11-18 15:30:00',NULL),
(22,11,2,NULL,50000.00,19846000.00,19796000.00,'2025-11-20','TEST','2025-11-20 15:11:47',NULL),
(23,10,2,NULL,16000.00,4500000.00,4484000.00,'2025-11-21','Biaya Admin BCA','2025-11-21 15:30:00',NULL),
(24,10,2,NULL,16000.00,4484000.00,4468000.00,'2025-11-24','Biaya Admin BCA','2025-11-24 11:30:00',NULL),
(25,10,2,NULL,16000.00,4468000.00,4452000.00,'2025-11-24','Biaya Admin BCA','2025-11-24 12:30:00',NULL),
(26,17,2,NULL,11000.00,500000.00,489000.00,'2025-11-24','Biaya Admin BNI','2025-11-24 12:30:00',NULL),
(27,17,2,19,10000.00,489000.00,479000.00,'2025-11-24',NULL,'2025-11-24 13:52:11',NULL);

/*Table structure for table `wallets` */

CREATE TABLE `wallets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `balance` decimal(16,2) DEFAULT 0.00,
  `admin_fee` tinyint(1) DEFAULT NULL,
  `nominal_admin_fee` decimal(8,2) DEFAULT 0.00,
  `date_admin_fee` smallint(2) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallet_id` (`payment_id`),
  UNIQUE KEY `name` (`name`,`payment_id`),
  CONSTRAINT `wallets_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `wallets` */

insert  into `wallets`(`id`,`payment_id`,`name`,`balance`,`admin_fee`,`nominal_admin_fee`,`date_admin_fee`,`created_at`,`updated_at`) values 
(1,2,'Cash',250000.00,0,NULL,NULL,'2025-04-30 10:48:24',NULL),
(2,1,'Cash',0.00,0,NULL,NULL,'2025-04-30 11:10:00',NULL),
(3,10,'BCA',4452000.00,1,16000.00,24,'2025-05-08 14:10:17',NULL),
(4,13,'Seabank',1500000.00,0,0.00,1,'2025-09-10 14:08:19',NULL),
(5,14,'Krom',150000.00,NULL,NULL,NULL,'2025-11-05 16:52:09',NULL),
(6,17,'BNI',479000.00,1,11000.00,24,'2025-11-24 11:52:26',NULL);

/* Trigger structure for table `expenses` */

DELIMITER $$

/*!50003 CREATE */ /*!50003 TRIGGER `after_insert_expenses` AFTER INSERT ON `expenses` FOR EACH ROW BEGIN
	
	SELECT a.id, ifnull(b.`balance`,0), ifnull(c.`remaining_amount`,0) into @id, @walletBalance, @creditCardBalance FROM payments AS a
	LEFT JOIN wallets AS b ON a.`id` = b.`payment_id`
	LEFT JOIN debts AS c ON a.`id` = c.`payment_id`
	left join credit_cards as d on c.id = d.debt_id
	WHERE a.id = new.payment_id;
	
	if @walletBalance = 0 then
		INSERT INTO wallet_transactions (wallet_id, wallet_transaction_type_id, transaction_id, amount, before_balance, after_balance, transaction_date, transaction_note, created_at)
		VALUES(new.payment_id, 2, new.id, new.expense_amount, @creditCardBalance, @creditCardBalance - new.expense_amount, new.expense_date, new.description, NOW());
	ELSE
		INSERT INTO wallet_transactions (wallet_id, wallet_transaction_type_id, transaction_id, amount, before_balance, after_balance, transaction_date, transaction_note, created_at)
		VALUES(new.payment_id, 2, new.id, new.expense_amount, @walletBalance, @walletBalance - new.expense_amount, new.expense_date, new.description, NOW());
		
	END IF;
    END */$$


DELIMITER ;

/* Trigger structure for table `expenses` */

DELIMITER $$

/*!50003 CREATE */ /*!50003 TRIGGER `after_delete_expenses` AFTER DELETE ON `expenses` FOR EACH ROW BEGIN

    END */$$


DELIMITER ;

/* Trigger structure for table `incomes` */

DELIMITER $$

/*!50003 CREATE */ /*!50003 TRIGGER `after_insert_incomes` AFTER INSERT ON `incomes` FOR EACH ROW BEGIN
	SELECT balance INTO @balance FROM wallets WHERE payment_id = new.wallet_id;
    
	INSERT INTO wallet_transactions (wallet_id, wallet_transaction_type_id, transaction_id, amount, before_balance, after_balance, transaction_date, transaction_note, created_at)
	VALUES(new.wallet_id, 1, new.id, new.income_amount, @balance, @balance + new.income_amount, new.transaction_date, new.description, NOW());
    END */$$


DELIMITER ;

/* Trigger structure for table `incomes` */

DELIMITER $$

/*!50003 CREATE */ /*!50003 TRIGGER `after_delete_incomes` AFTER DELETE ON `incomes` FOR EACH ROW BEGIN
	SELECT balance INTO @balance FROM wallets WHERE payment_id = old.wallet_id;
    
	update wallets set balance = balance - old.income_amount where payment_id = old.wallet_id;
	
	INSERT INTO wallet_transactions (wallet_id, wallet_transaction_type_id, amount, before_balance, after_balance, transaction_date, transaction_note, created_at)
	VALUES(old.wallet_id, 1, old.income_amount - ( old.income_amount * 2), @balance, @balance + old.income_amount, old.transaction_date, 'Hapus Data Income', NOW());
    END */$$


DELIMITER ;

/* Trigger structure for table `transfers` */

DELIMITER $$

/*!50003 CREATE */ /*!50003 TRIGGER `after_insert_transfers` AFTER INSERT ON `transfers` FOR EACH ROW BEGIN
	select balance into @balance1 from wallets where payment_id = new.from_wallet_id;
	select balance into @balance2 from wallets where payment_id = new.to_wallet_id;
    
	insert into wallet_transactions (wallet_id, wallet_transaction_type_id, amount, before_balance, after_balance, transaction_date, transaction_note, created_at)
	values(new.from_wallet_id, 4, new.transfer_amount, @balance1, @balance1 - new.transfer_amount, new.transfer_date, new.description, now()),
	(new.to_wallet_id, 3, new.transfer_amount, @balance2, @balance2 + new.transfer_amount, new.transfer_date, new.description, NOW());
    END */$$


DELIMITER ;

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `check_monthly_admin_fee` */

DELIMITER $$

/*!50106 CREATE EVENT `check_monthly_admin_fee` ON SCHEDULE EVERY 1 DAY STARTS '2025-11-13 12:30:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Daily check Admin Fee' DO BEGIN
	
	INSERT INTO `uangku`.`expenses` (
	  `user_id`,
	  `payment_id`,
	  `expense_category_id`,
	  `expense_title`,
	  `expense_amount`,
	  `expense_date`,
	  `description`,
	  `created_at`
	)
	select payment.user_id, wallet.payment_id, 9, CONCAT('Biaya Admin ',wallet.name), wallet.`nominal_admin_fee`,CURRENT_DATE(), CONCAT('Biaya Admin ',wallet.name), NOW() from uangku.wallets as wallet 
	join uangku.payments as payment on wallet.payment_id = payment.id  
	where wallet.admin_fee = 1 and wallet.date_admin_fee = date_format(CURRENT_DATE(),'%d');
	
	 UPDATE uangku.wallets AS wallet
	    JOIN uangku.payments AS payment ON wallet.payment_id = payment.id
	    SET wallet.balance = wallet.balance - wallet.nominal_admin_fee
	    WHERE wallet.admin_fee = 1
	      AND wallet.date_admin_fee = DATE_FORMAT(CURRENT_DATE(), '%d');
  END */$$
DELIMITER ;

/* Event structure for event `check_monthly_subs` */

DELIMITER $$

/*!50106 CREATE EVENT `check_monthly_subs` ON SCHEDULE EVERY 1 DAY STARTS '2025-10-15 16:00:40' ON COMPLETION NOT PRESERVE DISABLE COMMENT 'Daily check subscription' DO BEGIN
	declare trans_type, hari, subs_id, last_id integer;
	    SELECT id, subscriptions_type_id  into subs_id,trans_type from uangku.`subscriptions` where subscription_days = DATE_FORMAT(CURRENT_DATE(), '%d');
	    if(trans_type = 1) then
		INSERT INTO `uangku`.`expenses` (
		  `user_id`,
		  `payment_id`,
		  `expense_category_id`,
		  `expense_title`,
		  `expense_amount`,
		  `expense_date`,
		  `description`
		)
		select
		user_id,
		credit_cards_id,
		expense_category_id,
		subscriptions_name,
		amount,
		current_date(),
		subscriptions_name
		from uangku.`subscriptions`
		where subscription_days = DATE_FORMAT(CURRENT_DATE(), '%d') and subscriptions_type_id = 1;
		
		select last_insert_id into last_id;
		
		insert into uangku.`expense_subscriptions`(
		subscriptions_id, expneses_id) values (subs_id, last_id);
	    end if;
	END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
