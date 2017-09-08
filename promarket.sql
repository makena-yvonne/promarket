-- noinspection SqlNoDataSourceInspectionForFile
-- noinspection SqlDialectInspectionForFile
CREATE TABLE `users`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fname` VARCHAR (60) DEFAULT NULL,
  `lname` VARCHAR (60) DEFAULT NULL,
  `email` VARCHAR (60) DEFAULT NULL,
  `username` VARCHAR (60) DEFAULT NULL UNIQUE,
  `password` VARCHAR(40) NOT NULL,
  `reg_no` VARCHAR (50) NOT NULL,
  `institution` VARCHAR (128) NOT NULL,
  `role` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `description` varchar(4096) NOT NULL,
  `icon_fname` VARCHAR(400) NOT NULL,
  `doc_fname` VARCHAR(400) NOT NULL,
  `match_percentage` FLOAT NOT NULL,
  `status` INT (11) NOT NULL,
  `updated_at` TIMESTAMP,
  `action_by` INT (11) DEFAULT NULL,
  `user_id` INT (11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
);

CREATE TABLE `pro_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` INT (11) NOT NULL,
  `comment` varchar(2048) DEFAULT NULL,
  `created_at` TIMESTAMP,
  `user_id` INT (11),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
);

CREATE TABLE `pro_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` INT (11) NOT NULL,
  `created_at` TIMESTAMP,
  `user_id` INT (11),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
);

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` INT (11) NOT NULL,
  `user_id` INT (11) ,
  `subject` varchar(60) DEFAULT NULL,
  `message` varchar(4096) DEFAULT NULL,
  `admin_read` int(4) NOT NULL DEFAULT 0,
  `student_read` int(4) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`project_id`) REFERENCES users(`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`)
);
