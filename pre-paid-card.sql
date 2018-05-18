# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.20)
# Database: lumen
# Generation Time: 2018-05-18 08:10:55 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table balance
# ------------------------------------------------------------

DROP TABLE IF EXISTS `balance`;

CREATE TABLE `balance` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `card_id` int(11) NOT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `blocked_amount` decimal(11,2) DEFAULT NULL,
  `refund` decimal(11,2) DEFAULT NULL,
  `refunded_by` int(11) DEFAULT NULL,
  `blocked_by` int(11) DEFAULT NULL,
  `top_up` decimal(11,2) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `balance` WRITE;
/*!40000 ALTER TABLE `balance` DISABLE KEYS */;

INSERT INTO `balance` (`id`, `card_id`, `amount`, `blocked_amount`, `refund`, `refunded_by`, `blocked_by`, `top_up`, `updated_at`, `created_at`)
VALUES
	(1,2,25.00,NULL,NULL,NULL,NULL,5.00,'2018-05-17 21:19:46',NULL),
	(4,2,27.00,NULL,NULL,NULL,NULL,2.00,NULL,'2018-05-17 21:31:49'),
	(6,2,27.00,NULL,NULL,NULL,NULL,2.00,NULL,NULL),
	(7,2,27.00,NULL,NULL,NULL,NULL,2.00,NULL,'2018-05-17 21:41:04'),
	(8,2,29.00,NULL,NULL,NULL,NULL,2.00,NULL,'2018-05-17 21:42:41'),
	(9,2,34.00,NULL,NULL,NULL,NULL,5.00,NULL,'2018-05-17 21:42:54'),
	(13,2,34.00,5.00,NULL,NULL,NULL,NULL,NULL,'2018-05-17 23:02:48'),
	(16,2,39.00,5.00,5.00,1,NULL,NULL,NULL,'2018-05-18 00:16:01'),
	(18,2,44.00,0.00,5.00,1,NULL,NULL,NULL,'2018-05-18 00:20:37');

/*!40000 ALTER TABLE `balance` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cards
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cards`;

CREATE TABLE `cards` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `cards` WRITE;
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;

INSERT INTO `cards` (`id`, `name`, `user_id`, `currency`, `updated_at`, `created_at`, `deleted_at`)
VALUES
	(2,'test',2,'GBP',NULL,NULL,NULL),
	(3,'test',2,'GBP',NULL,NULL,NULL),
	(4,'test',2,'GBP',NULL,NULL,NULL),
	(5,'test5',2,'GBP',NULL,NULL,NULL),
	(6,'test6',4,'GBP',NULL,NULL,NULL),
	(7,'test6',4,'GBP',NULL,NULL,NULL);

/*!40000 ALTER TABLE `cards` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table merchants
# ------------------------------------------------------------

DROP TABLE IF EXISTS `merchants`;

CREATE TABLE `merchants` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `merchants` WRITE;
/*!40000 ALTER TABLE `merchants` DISABLE KEYS */;

INSERT INTO `merchants` (`id`, `name`)
VALUES
	(1,'cafe nero');

/*!40000 ALTER TABLE `merchants` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `card_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `status` enum('pending','completed','paid','refund') NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;

INSERT INTO `transactions` (`id`, `card_id`, `merchant_id`, `amount`, `reference`, `status`, `created_at`, `updated_at`)
VALUES
	(2,2,1,5.00,'Cafe late','refund','2018-05-17 23:02:48','2018-05-18 00:20:37');

/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
