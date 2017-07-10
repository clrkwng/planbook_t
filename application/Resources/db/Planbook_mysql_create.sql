CREATE TABLE `Frequency` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Frequency_Meta` (
	`id` int NOT NULL AUTO_INCREMENT,
	`frequency_id` int NOT NULL AUTO_INCREMENT,
	`meta_key` varchar(255) NOT NULL,
	`meta_value` varchar(50) NOT NULL,a
	PRIMARY KEY (`id`)
);

CREATE TABLE `Special_Goal` (
	`id` int NOT NULL AUTO_INCREMENT,
	`award_id` int NOT NULL,
	`title` varchar(255) NOT NULL,
	`icon` varchar(255) NOT NULL,
	`start_date` DATETIME NOT NULL,
	`end_date` DATETIME NOT NULL,
	`repeat_on_list` bit NOT NULL DEFAULT '0',
	`result` varchar(255),
	`default_points` varchar(255),
	PRIMARY KEY (`id`)
);

CREATE TABLE `Redeem` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`points` int NOT NULL,
	`reward` varchar(255) NOT NULL,
	`unit` varchar(50) NOT NULL,
	`symbol` varchar(50) NOT NULL,
	`redeem_date` DATE,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Account` (
	`id` int NOT NULL AUTO_INCREMENT,
	`password` varchar(255) NOT NULL,
	`email` varchar(255) NOT NULL,
	`phone_number` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Special_Goal_List` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`date_achieved` DATETIME,
	`reminder_time` DATETIME,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Theme` (
	`id` int NOT NULL,
	`name` varchar(255) NOT NULL,
	`image` varchar(255) NOT NULL,
	`color` varchar(255) NOT NULL
);

CREATE TABLE `User` (
	`id` int NOT NULL AUTO_INCREMENT,
	`account_id` int NOT NULL,
	`demographic_id` int NOT NULL,
	`theme_id` int NOT NULL,
	`username` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	`picture` varchar(255) NOT NULL,
	`type` varchar(255) NOT NULL,
	`total_points` int NOT NULL DEFAULT '0',
	`current_points` int NOT NULL DEFAULT '0',
	`email` varchar(255) NOT NULL,
	`phone_number` varchar(255) NOT NULL,
	`school` varchar(255),
	PRIMARY KEY (`id`)
);

CREATE TABLE `Demographics` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`theme_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Special_Done` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`special_goal_id` int NOT NULL,
	`period` varchar(255) NOT NULL,
	`total_listed` varchar(255) NOT NULL,
	`achieved` bit NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE `User_Awards` (
	`id` int NOT NULL AUTO_INCREMENT,
	`award_id` int NOT NULL,
	`user_id` int NOT NULL,
	`quantity` int NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE `Awards` (
	`id` bigint NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`icon` varchar(255) NOT NULL,
	`amount` int NOT NULL,
	`unit` varchar(255) NOT NULL,
	`symbol` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Task` (
	`id` int NOT NULL AUTO_INCREMENT,
	`priority_id` int NOT NULL,
	`category_id` int NOT NULL,
	`icon` varchar(255) NOT NULL,
	`description` varchar(255) NOT NULL,
	`length` varchar(255) NOT NULL,
	`repeat` bit NOT NULL DEFAULT '0',
	`start_time` DATETIME NOT NULL,
	`end_time` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Priority` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Common_Task_Goal` (
	`id` int NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL,
	`icon` varchar(255) NOT NULL,
	`category_id` int NOT NULL,
	`priority` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Category` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`icon` varchar(255) NOT NULL,
	`color` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Task_Done` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`period` varchar(255) NOT NULL,
	`start_date` DATETIME NOT NULL,
	`total_task` varchar(255) NOT NULL,
	`completed` bit NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE `Daily_Task_List` (
	`id` int NOT NULL AUTO_INCREMENT,
	`task_id` int NOT NULL,
	`priority_id` int NOT NULL,
	`user_id` int NOT NULL,
	`start_time` DATETIME NOT NULL,
	`end_time` DATETIME NOT NULL,
	`length` varchar(255) NOT NULL,
	`priority` varchar(255) NOT NULL,
	`status` varchar(255) NOT NULL,
	`total_task` varchar(255) NOT NULL,
	`task_completed` bit NOT NULL DEFAULT '0',
	`reminder_time` DATETIME,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Redeem` (
	`id` int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`)
);

ALTER TABLE `Special_Goal` ADD CONSTRAINT `Special_Goal_fk0` FOREIGN KEY (`award_id`) REFERENCES `Awards`(`id`);

ALTER TABLE `Redeem` ADD CONSTRAINT `Redeem_fk0` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Special_Goal_List` ADD CONSTRAINT `Special_Goal_List_fk0` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `User` ADD CONSTRAINT `User_fk0` FOREIGN KEY (`account_id`) REFERENCES `Account`(`id`);

ALTER TABLE `User` ADD CONSTRAINT `User_fk1` FOREIGN KEY (`demographic_id`) REFERENCES `Demographics`(`id`);

ALTER TABLE `User` ADD CONSTRAINT `User_fk2` FOREIGN KEY (`theme_id`) REFERENCES `Theme`(`id`);

ALTER TABLE `Demographics` ADD CONSTRAINT `Demographics_fk0` FOREIGN KEY (`theme_id`) REFERENCES `Theme`(`id`);

ALTER TABLE `Special_Done` ADD CONSTRAINT `Special_Done_fk0` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Special_Done` ADD CONSTRAINT `Special_Done_fk1` FOREIGN KEY (`special_goal_id`) REFERENCES `Special_Goal`(`id`);

ALTER TABLE `User_Awards` ADD CONSTRAINT `User_Awards_fk0` FOREIGN KEY (`award_id`) REFERENCES `Awards`(`id`);

ALTER TABLE `User_Awards` ADD CONSTRAINT `User_Awards_fk1` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Task` ADD CONSTRAINT `Task_fk0` FOREIGN KEY (`priority_id`) REFERENCES `Priority`(`id`);

ALTER TABLE `Task` ADD CONSTRAINT `Task_fk1` FOREIGN KEY (`category_id`) REFERENCES `Category`(`id`);

ALTER TABLE `Common_Task_Goal` ADD CONSTRAINT `Common_Task_Goal_fk0` FOREIGN KEY (`category_id`) REFERENCES `Category`(`id`);

ALTER TABLE `Task_Done` ADD CONSTRAINT `Task_Done_fk0` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

ALTER TABLE `Daily_Task_List` ADD CONSTRAINT `Daily_Task_List_fk0` FOREIGN KEY (`task_id`) REFERENCES `Task`(`id`);

ALTER TABLE `Daily_Task_List` ADD CONSTRAINT `Daily_Task_List_fk1` FOREIGN KEY (`priority_id`) REFERENCES `Priority`(`id`);

ALTER TABLE `Daily_Task_List` ADD CONSTRAINT `Daily_Task_List_fk2` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

