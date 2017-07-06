CREATE TABLE `Users` (
	`id` int NOT NULL AUTO_INCREMENT,
	`username` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	`email` varchar(255) NOT NULL,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
);

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
	`meta_value` varchar(50) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Images` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255),
	`link` varchar(255) NOT NULL,
	`description` varchar(255),
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
);

CREATE TABLE `Categories` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`icon_id` int NOT NULL,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
);

CREATE TABLE `Awards` (
	`id` int NOT NULL AUTO_INCREMENT,
	`icon_id` int NOT NULL,
	`currency_id` int NOT NULL,
	`amount` int NOT NULL,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
);

CREATE TABLE `Currency` (
	`id` int NOT NULL AUTO_INCREMENT,
	`unit` varchar(255),
	`symbol` varchar(50),
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
);

CREATE TABLE `Priority` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
);

CREATE TABLE `Theme` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar NOT NULL DEFAULT '255',
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
);

CREATE TABLE `Colors` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`hex_code` varchar(6) NOT NULL,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Theme_Colors` (
	`id` int NOT NULL AUTO_INCREMENT,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	`theme_id` int NOT NULL,
	`color_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Demographics` (
	`id` int NOT NULL AUTO_INCREMENT,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	`icon` int,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Demographic_Categories` (
	`id` int NOT NULL AUTO_INCREMENT,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	`category_id` int NOT NULL,
	`demographic_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Demographic_Awards` (
	`id` int NOT NULL AUTO_INCREMENT,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	`demographic_id` int NOT NULL,
	`award_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Demographic_Themes` (
	`id` int NOT NULL AUTO_INCREMENT,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	`demographic_id` int NOT NULL,
	`theme_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `User_Demographics` (
	`id` int NOT NULL AUTO_INCREMENT,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	`user_id` int NOT NULL,
	`demographic_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Admin_Users` (
	`id` int NOT NULL AUTO_INCREMENT,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	`parent_user_id` int NOT NULL,
	`child_user_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Tasks` (
	`id` int NOT NULL AUTO_INCREMENT,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	`name` varchar(255),
	`description` varchar(255),
	`icon_id` int,
	PRIMARY KEY (`id`)
);

CREATE TABLE `User_Tasks` (
	`id` int NOT NULL AUTO_INCREMENT,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	`task_id` int NOT NULL,
	`frequency_id` int NOT NULL,
	`user_id` int NOT NULL,
	`priority_id` int NOT NULL,
	`award_id` int NOT NULL,
	`task_start` DATETIME NOT NULL,
	`task_end` DATETIME NOT NULL,
	`complete` bool NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
);

CREATE TABLE `Demographic_Tasks` (
	`id` int NOT NULL AUTO_INCREMENT,
	`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`active` bool NOT NULL DEFAULT '1',
	`demographic_id` int NOT NULL,
	`task_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `Frequency_Meta` ADD CONSTRAINT `Frequency_Meta_fk0` FOREIGN KEY (`frequency_id`) REFERENCES `Frequency`(`id`);

ALTER TABLE `Categories` ADD CONSTRAINT `Categories_fk0` FOREIGN KEY (`icon_id`) REFERENCES `Images`(`id`);

ALTER TABLE `Awards` ADD CONSTRAINT `Awards_fk0` FOREIGN KEY (`icon_id`) REFERENCES `Images`(`id`);

ALTER TABLE `Awards` ADD CONSTRAINT `Awards_fk1` FOREIGN KEY (`currency_id`) REFERENCES `Currency`(`id`);

ALTER TABLE `Theme_Colors` ADD CONSTRAINT `Theme_Colors_fk0` FOREIGN KEY (`theme_id`) REFERENCES `Theme`(`id`);

ALTER TABLE `Theme_Colors` ADD CONSTRAINT `Theme_Colors_fk1` FOREIGN KEY (`color_id`) REFERENCES `Colors`(`id`);

ALTER TABLE `Demographics` ADD CONSTRAINT `Demographics_fk0` FOREIGN KEY (`icon`) REFERENCES `Images`(`id`);

ALTER TABLE `Demographic_Categories` ADD CONSTRAINT `Demographic_Categories_fk0` FOREIGN KEY (`category_id`) REFERENCES `Categories`(`id`);

ALTER TABLE `Demographic_Categories` ADD CONSTRAINT `Demographic_Categories_fk1` FOREIGN KEY (`demographic_id`) REFERENCES `Demographics`(`id`);

ALTER TABLE `Demographic_Awards` ADD CONSTRAINT `Demographic_Awards_fk0` FOREIGN KEY (`demographic_id`) REFERENCES `Demographics`(`id`);

ALTER TABLE `Demographic_Awards` ADD CONSTRAINT `Demographic_Awards_fk1` FOREIGN KEY (`award_id`) REFERENCES `Awards`(`id`);

ALTER TABLE `Demographic_Themes` ADD CONSTRAINT `Demographic_Themes_fk0` FOREIGN KEY (`demographic_id`) REFERENCES `Demographics`(`id`);

ALTER TABLE `Demographic_Themes` ADD CONSTRAINT `Demographic_Themes_fk1` FOREIGN KEY (`theme_id`) REFERENCES `Theme`(`id`);

ALTER TABLE `User_Demographics` ADD CONSTRAINT `User_Demographics_fk0` FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`);

ALTER TABLE `User_Demographics` ADD CONSTRAINT `User_Demographics_fk1` FOREIGN KEY (`demographic_id`) REFERENCES `Demographics`(`id`);

ALTER TABLE `Admin_Users` ADD CONSTRAINT `Admin_Users_fk0` FOREIGN KEY (`parent_user_id`) REFERENCES `Users`(`id`);

ALTER TABLE `Admin_Users` ADD CONSTRAINT `Admin_Users_fk1` FOREIGN KEY (`child_user_id`) REFERENCES `Users`(`id`);

ALTER TABLE `Tasks` ADD CONSTRAINT `Tasks_fk0` FOREIGN KEY (`icon_id`) REFERENCES `Images`(`id`);

ALTER TABLE `User_Tasks` ADD CONSTRAINT `User_Tasks_fk0` FOREIGN KEY (`task_id`) REFERENCES `Tasks`(`id`);

ALTER TABLE `User_Tasks` ADD CONSTRAINT `User_Tasks_fk1` FOREIGN KEY (`frequency_id`) REFERENCES `Frequency`(`id`);

ALTER TABLE `User_Tasks` ADD CONSTRAINT `User_Tasks_fk2` FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`);

ALTER TABLE `User_Tasks` ADD CONSTRAINT `User_Tasks_fk3` FOREIGN KEY (`priority_id`) REFERENCES `Priority`(`id`);

ALTER TABLE `User_Tasks` ADD CONSTRAINT `User_Tasks_fk4` FOREIGN KEY (`award_id`) REFERENCES `Awards`(`id`);

ALTER TABLE `Demographic_Tasks` ADD CONSTRAINT `Demographic_Tasks_fk0` FOREIGN KEY (`demographic_id`) REFERENCES `Demographics`(`id`);

ALTER TABLE `Demographic_Tasks` ADD CONSTRAINT `Demographic_Tasks_fk1` FOREIGN KEY (`task_id`) REFERENCES `Tasks`(`id`);

