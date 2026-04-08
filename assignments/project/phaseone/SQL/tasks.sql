CREATE DATABASE IF NOT EXISTS Mitchell200636138;
use Mitchell200636138;

drop table if exists active_tasks;

CREATE TABLE active_tasks (
  `task_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `task_name` varchar(22) DEFAULT NULL,
  `task_priority` varchar(7) DEFAULT 'LOW',
  `task_time` int(11) NOT NULL,
  `task_date` date NOT NULL
);