CREATE SCHEMA `planbook_db1` ;

use planbook_db1;

CREATE TABLE `Account` (
	`id` int NOT NULL AUTO_INCREMENT,
	`password` varchar(255) NOT NULL,
	`name` varchar(255),
	`email` varchar(255),
	`phone_number` varchar(255),
	`verified` TINYINT(1) DEFAULT 0,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Theme` (
  `id` int NOT NULL AUTO_INCREMENT,
  `color1` varchar(7) DEFAULT '',
  `color2` varchar(7) DEFAULT '',
  `user_id` int NOT NULL,
  `color3` varchar(7) DEFAULT '',
  `color4` varchar(7) DEFAULT '',
  `color5` varchar(7) DEFAULT '',
  `color6` varchar(7) DEFAULT '',
  `color7` varchar(7) DEFAULT '',
  `color8` varchar(7) DEFAULT '',
  PRIMARY KEY (`id`)
);

CREATE TABLE `User` (
	`id` int NOT NULL AUTO_INCREMENT,
	`account_id` int NOT NULL,
	`theme_id` int,
	`username` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	`image_id` int NOT NULL,
	`type_id` int NOT NULL,
	`total_points` int DEFAULT '0',
	`current_points` int DEFAULT '0',
	`email` varchar(255) NOT NULL,
	`phone_number` varchar(255),
	PRIMARY KEY (`id`)
);

CREATE TABLE `User_Awards` (
	`id` int NOT NULL AUTO_INCREMENT,
	`award_id` int NOT NULL,
	`user_id` int NOT NULL,
	`quantity` int DEFAULT 0,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Awards` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`image_id` int NOT NULL,
	`amount` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Task` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255),
	`priority_id` int NOT NULL,
	`category_id` int NOT NULL,
	`user_id` int NOT NULL,
	`description` varchar(255),
	`start_time` varchar(8) NOT NULL,
	`end_time` varchar(8) DEFAULT '',
	`date` date NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Priority` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
  `points` int DEFAULT 5,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Date` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int,
  `date` varchar(10) DEFAULT '',
  PRIMARY KEY (`id`)
);

CREATE TABLE `Image` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`description` varchar(255),
	`link` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Common_Task_Goal` (
	`id` int NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL,
	`image_id` int NOT NULL,
	`category_id` int NOT NULL,
	`priority_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Category` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`user_id` int,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Redeem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `points` int NOT NULL,
  `reward` varchar(255) NOT NULL,
  `unit` varchar(50),
  `symbol` varchar(50),
  `redeem_date` DATE,
  `completed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
);

CREATE TABLE `Template` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `priority_id` int NOT NULL,
  `task_name` varchar(255) DEFAULT '',
  `start_time` varchar(8) DEFAULT '',
  `end_time` varchar(8) DEFAULT '',
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `Type` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);



ALTER TABLE `Redeem` ADD CONSTRAINT `Redeem_fk0` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `User` ADD CONSTRAINT `User_fk0` FOREIGN KEY (`account_id`) REFERENCES `Account`(`id`);

ALTER TABLE `User` ADD CONSTRAINT `User_fk3` FOREIGN KEY (`type_id`) REFERENCES `Type`(`id`);

ALTER TABLE `User` ADD CONSTRAINT `User_fk4` FOREIGN KEY (`image_id`) REFERENCES `Image`(`id`);

ALTER TABLE `User_Awards` ADD CONSTRAINT `User_Awards_fk0` FOREIGN KEY (`award_id`) REFERENCES `Awards`(`id`);

ALTER TABLE `User_Awards` ADD CONSTRAINT `User_Awards_fk1` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Awards` ADD CONSTRAINT `Awards_fk0` FOREIGN KEY (`image_id`) REFERENCES `Image`(`id`);

ALTER TABLE `Category` ADD CONSTRAINT `Category_fk1` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Task` ADD CONSTRAINT `Task_fk0` FOREIGN KEY (`priority_id`) REFERENCES `Priority`(`id`);

ALTER TABLE `Task` ADD CONSTRAINT `Task_fk1` FOREIGN KEY (`category_id`) REFERENCES `Category`(`id`);

ALTER TABLE `Task` ADD CONSTRAINT `Task_fk3` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Common_Task_Goal` ADD CONSTRAINT `Common_Task_Goal_fk0` FOREIGN KEY (`category_id`) REFERENCES `Category`(`id`);

ALTER TABLE `Common_Task_Goal` ADD CONSTRAINT `Common_Task_Goal_fk1` FOREIGN KEY (`priority_id`) REFERENCES `Priority`(`id`);

ALTER TABLE `Common_Task_Goal` ADD CONSTRAINT `Common_Task_Goal_fk2` FOREIGN KEY (`image_id`) REFERENCES `Image`(`id`);