CREATE SCHEMA `planbook_db1` ;
use planbook_db1;

CREATE TABLE `Account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) NOT NULL DEFAULT '',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `phonenumber` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;



CREATE TABLE `Awards` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;



CREATE TABLE `Category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;


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


CREATE TABLE `Date` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `date` varchar(10) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;


CREATE TABLE `Demographics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `theme_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `Frequency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `Frequency_Meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frequency_id` int(11) NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `Image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;



CREATE TABLE `Priority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;



CREATE TABLE `Redeem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `reward` varchar(255) NOT NULL,
  `redeem_date` datetime DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;



CREATE TABLE `Special_Done` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `special_goal_id` int(11) NOT NULL,
  `period` varchar(255) NOT NULL,
  `total_listed` varchar(255) NOT NULL,
  `achieved` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



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



CREATE TABLE `Special_Goal_List` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_achieved` datetime DEFAULT NULL,
  `description_ov` varchar(255) DEFAULT NULL,
  `reminder_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `Status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8;




CREATE TABLE `Task_Done` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `period` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `total_task` varchar(255) NOT NULL,
  `completed` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;



CREATE TABLE `Theme` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `color1` varchar(7) NOT NULL DEFAULT '',
  `color2` varchar(7) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL,
  `color3` varchar(7) NOT NULL DEFAULT '',
  `color4` varchar(7) NOT NULL DEFAULT '',
  `color5` varchar(7) NOT NULL DEFAULT '',
  `color6` varchar(7) NOT NULL DEFAULT '',
  `color7` varchar(7) NOT NULL DEFAULT '',
  `color8` varchar(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;



CREATE TABLE `Type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;



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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;



CREATE TABLE `User_Awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `award_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;


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
