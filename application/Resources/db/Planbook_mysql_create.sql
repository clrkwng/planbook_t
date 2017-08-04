CREATE SCHEMA `planbook_db1` ;

use planbook_db1;

CREATE TABLE `Account` (
	`id` int NOT NULL AUTO_INCREMENT,
	`password` varchar(255) NOT NULL,
	`name` varchar(255),
	`email` varchar(255),
	`phone_number` varchar(255),
	`verified` bit DEFAULT 0,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Theme` (
  `id` int NOT NULL,
  `color1` varchar(7) DEFAULT '',
  `color2` varchar(7) DEFAULT '',
  `user_id` int NOT NULL,
  `color3` varchar(7) DEFAULT '',
  `color4` varchar(7) DEFAULT '',
  `color5` varchar(7) DEFAULT '',
  `color6` varchar(7) DEFAULT '',
  `color7` varchar(7) DEFAULT '',
  `color8` varchar(7) DEFAULT ''
);

CREATE TABLE `User` (
	`id` int NOT NULL AUTO_INCREMENT,
	`account_id` int NOT NULL,
	`demographic_id` int,
	`theme_id` int,
	`username` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	`image_id` int NOT NULL,
	`type_id` int NOT NULL,
	`total_points` int DEFAULT '0',
	`current_points` int DEFAULT '0',
	`email` varchar(255) NOT NULL,
	`phone_number` varchar(255),
	`school` varchar(255),
	PRIMARY KEY (`id`)
);

CREATE TABLE `Demographics` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`theme_id` int NOT NULL,
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
	`unit` varchar(255) NOT NULL,
	`symbol` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Task` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255),
	`priority_id` int NOT NULL,
	`category_id` int NOT NULL,
	`image_id` int NOT NULL,
	`user_id` int NOT NULL,
	`description` varchar(255),
	`length` varchar(255),
	`repeat` bit(1) DEFAULT b'0',
	`start_time` varchar(8) NOT NULL,
	`end_time` varchar(8) DEFAULT '',
	PRIMARY KEY (`id`)
);

CREATE TABLE `Priority` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Date` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int,
  `date` varchar(10) DEFAULT '',
  PRIMARY KEY (`id`)
);

CREATE TABLE `Demographics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `theme_id` int NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `Frequency` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

CREATE TABLE `Frequency_Meta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `frequency_id` int NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` varchar(50) NOT NULL,
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
	`image_id` int,
	`color` varchar(255),
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

CREATE TABLE `Special_Done` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `special_goal_id` int NOT NULL,
  `period` varchar(255) NOT NULL,
  `total_listed` varchar(255) NOT NULL,
  `achieved` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`)
);

CREATE TABLE `Special_Goal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `award_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_id` int NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime,
  `repeat_on_list` bit(1) DEFAULT b'0',
  `description` varchar(255) NOT NULL,
  `result` varchar(255),
  `default_points` varchar(255),
  PRIMARY KEY (`id`)
);

CREATE TABLE `Special_Goal_List` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date_achieved` datetime,
  `description_ov` varchar(255),
  `reminder_time` datetime,
  PRIMARY KEY (`id`)
);


CREATE TABLE `Task_Done` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `period` varchar(255) NOT NULL,
  `completed_timestamp` DATETIME NOT NULL,
  `start_date` datetime NOT NULL,
  `total_task` varchar(255) NOT NULL,
  `completed` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`)
);

CREATE TABLE `Template` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_id` int NOT NULL,
  `category_id` int NOT NULL,
  `priority_id` int NOT NULL,
  `task_name` varchar(255) DEFAULT '',
  `start_time` varchar(8) DEFAULT '',
  `end_time` varchar(8) DEFAULT '',
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
);


CREATE TABLE `Daily_Task_List` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `priority_id` int NOT NULL,
  `user_id` int NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `length` varchar(255) NOT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `Status` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Type` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);


ALTER TABLE `Special_Goal` ADD CONSTRAINT `Special_Goal_fk0` FOREIGN KEY (`award_id`) REFERENCES `Awards`(`id`);

ALTER TABLE `Special_Goal` ADD CONSTRAINT `Special_Goal_fk1` FOREIGN KEY (`image_id`) REFERENCES `Image`(`id`);

ALTER TABLE `Redeem` ADD CONSTRAINT `Redeem_fk0` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Special_Goal_List` ADD CONSTRAINT `Special_Goal_List_fk0` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `User` ADD CONSTRAINT `User_fk0` FOREIGN KEY (`account_id`) REFERENCES `Account`(`id`);

ALTER TABLE `User` ADD CONSTRAINT `User_fk1` FOREIGN KEY (`demographic_id`) REFERENCES `Demographics`(`id`);

ALTER TABLE `User` ADD CONSTRAINT `User_fk2` FOREIGN KEY (`theme_id`) REFERENCES `Theme`(`id`);

ALTER TABLE `User` ADD CONSTRAINT `User_fk3` FOREIGN KEY (`type_id`) REFERENCES `Type`(`id`);

ALTER TABLE `User` ADD CONSTRAINT `User_fk4` FOREIGN KEY (`image_id`) REFERENCES `Image`(`id`);

ALTER TABLE `Demographics` ADD CONSTRAINT `Demographics_fk0` FOREIGN KEY (`theme_id`) REFERENCES `Theme`(`id`);

ALTER TABLE `Special_Done` ADD CONSTRAINT `Special_Done_fk0` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Special_Done` ADD CONSTRAINT `Special_Done_fk1` FOREIGN KEY (`special_goal_id`) REFERENCES `Special_Goal`(`id`);

ALTER TABLE `User_Awards` ADD CONSTRAINT `User_Awards_fk0` FOREIGN KEY (`award_id`) REFERENCES `Awards`(`id`);

ALTER TABLE `User_Awards` ADD CONSTRAINT `User_Awards_fk1` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Awards` ADD CONSTRAINT `Awards_fk0` FOREIGN KEY (`image_id`) REFERENCES `Image`(`id`);

ALTER TABLE `Category` ADD CONSTRAINT `Category_fk0` FOREIGN KEY (`image_id`) REFERENCES `Image`(`id`);

ALTER TABLE `Category` ADD CONSTRAINT `Category_fk1` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Task` ADD CONSTRAINT `Task_fk0` FOREIGN KEY (`priority_id`) REFERENCES `Priority`(`id`);

ALTER TABLE `Task` ADD CONSTRAINT `Task_fk1` FOREIGN KEY (`category_id`) REFERENCES `Category`(`id`);

ALTER TABLE `Task` ADD CONSTRAINT `Task_fk2` FOREIGN KEY (`image_id`) REFERENCES `Image`(`id`);

ALTER TABLE `Task` ADD CONSTRAINT `Task_fk3` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Common_Task_Goal` ADD CONSTRAINT `Common_Task_Goal_fk0` FOREIGN KEY (`category_id`) REFERENCES `Category`(`id`);

ALTER TABLE `Common_Task_Goal` ADD CONSTRAINT `Common_Task_Goal_fk1` FOREIGN KEY (`priority_id`) REFERENCES `Priority`(`id`);

ALTER TABLE `Common_Task_Goal` ADD CONSTRAINT `Common_Task_Goal_fk2` FOREIGN KEY (`image_id`) REFERENCES `Image`(`id`);

ALTER TABLE `Task_Done` ADD CONSTRAINT `Task_Done_fk0` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Daily_Task_List` ADD CONSTRAINT `Daily_Task_List_fk0` FOREIGN KEY (`task_id`) REFERENCES `Task`(`id`);

ALTER TABLE `Daily_Task_List` ADD CONSTRAINT `Daily_Task_List_fk1` FOREIGN KEY (`priority_id`) REFERENCES `Priority`(`id`);

ALTER TABLE `Daily_Task_List` ADD CONSTRAINT `Daily_Task_List_fk2` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Daily_Task_List` ADD CONSTRAINT `Daily_Task_List_fk3` FOREIGN KEY (`status_id`) REFERENCES `Status`(`id`);
