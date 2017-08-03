# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: mysql.planbook.xyz (MySQL 5.6.34-log)
# Database: planbook_db1
# Generation Time: 2017-08-03 20:29:20 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Account`;

CREATE TABLE `Account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) NOT NULL DEFAULT '',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `phonenumber` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Awards
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Awards`;

CREATE TABLE `Awards` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Category`;

CREATE TABLE `Category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `color` varchar(255) DEFAULT '',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Daily_Task_List
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Daily_Task_List`;

CREATE TABLE `Daily_Task_List` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `length` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Date
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Date`;

CREATE TABLE `Date` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `date` varchar(10) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Demographics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Demographics`;

CREATE TABLE `Demographics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `theme_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Frequency
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Frequency`;

CREATE TABLE `Frequency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Frequency_Meta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Frequency_Meta`;

CREATE TABLE `Frequency_Meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frequency_id` int(11) NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Image
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Image`;

CREATE TABLE `Image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Priority
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Priority`;

CREATE TABLE `Priority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Redeem
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Redeem`;

CREATE TABLE `Redeem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `reward` varchar(255) NOT NULL,
  `redeem_date` datetime DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Special_Done
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Special_Done`;

CREATE TABLE `Special_Done` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `special_goal_id` int(11) NOT NULL,
  `period` varchar(255) NOT NULL,
  `total_listed` varchar(255) NOT NULL,
  `achieved` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Special_Goal
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Special_Goal`;

CREATE TABLE `Special_Goal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `award_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `repeat_on_list` bit(1) NOT NULL DEFAULT b'0',
  `description` varchar(255) NOT NULL,
  `result` varchar(255) DEFAULT NULL,
  `default_points` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Special_Goal_List
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Special_Goal_List`;

CREATE TABLE `Special_Goal_List` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_achieved` datetime DEFAULT NULL,
  `description_ov` varchar(255) DEFAULT NULL,
  `reminder_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Status`;

CREATE TABLE `Status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Task
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Task`;

CREATE TABLE `Task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority_id` int(11) NOT NULL DEFAULT '1',
  `category_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `task_name` varchar(255) NOT NULL DEFAULT '',
  `length` varchar(255) DEFAULT '',
  `repeat` bit(1) DEFAULT b'0',
  `start_time` varchar(8) NOT NULL DEFAULT '',
  `end_time` varchar(8) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Task_Done
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Task_Done`;

CREATE TABLE `Task_Done` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `period` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `total_task` varchar(255) NOT NULL,
  `completed` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Template
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Template`;

CREATE TABLE `Template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL DEFAULT '',
  `start_time` varchar(8) NOT NULL DEFAULT '',
  `end_time` varchar(8) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Theme
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Theme`;

CREATE TABLE `Theme` (
  `id` int(11) NOT NULL,
  `color1` varchar(7) NOT NULL DEFAULT '',
  `color2` varchar(7) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL,
  `color3` varchar(7) NOT NULL DEFAULT '',
  `color4` varchar(7) NOT NULL DEFAULT '',
  `color5` varchar(7) NOT NULL DEFAULT '',
  `color6` varchar(7) NOT NULL DEFAULT '',
  `color7` varchar(7) NOT NULL DEFAULT '',
  `color8` varchar(7) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table Type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Type`;

CREATE TABLE `Type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table User
# ------------------------------------------------------------

DROP TABLE IF EXISTS `User`;

CREATE TABLE `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `demographic_id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL DEFAULT '2',
  `total_points` int(11) NOT NULL DEFAULT '0',
  `current_points` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `school` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table User_Awards
# ------------------------------------------------------------

DROP TABLE IF EXISTS `User_Awards`;

CREATE TABLE `User_Awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `award_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
