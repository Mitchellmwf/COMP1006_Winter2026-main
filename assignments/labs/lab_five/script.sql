CREATE DATABASE IF NOT EXISTS Mitchell200636138;
use Mitchell200636138;

drop table if exists uploads;
create table uploads (
image_id int auto_increment primary key,
image_name varchar(100) ,
image_bin LONGBLOB,
mime_type varchar(10)
);
