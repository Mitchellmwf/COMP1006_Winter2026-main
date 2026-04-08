CREATE DATABASE IF NOT EXISTS Mitchell200636138;
use Mitchell200636138;

drop table if exists task_users;

CREATE TABLE task_users (
  `user_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(255) NOT NULL unique,
  `username` varchar(50) NOT NULL unique,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `image_type` varchar(50) DEFAULT NULL
);