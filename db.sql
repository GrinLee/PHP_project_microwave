DROP DATABASE IF EXISTS microwave;

CREATE DATABASE microwave CHARSET UTF8;

CREATE USER group7 identified by '!group7User';

grant all privileges on microwave.* to 'kunho'@'localhost' identified by '!group7User';
grant all privileges on microwave.* to 'kunho'@'127.0.0.1' identified by '!group7User';
grant all privileges on microwave.* to 'kunho'@'::1' identified by '!group7User';

USE microwave;

CREATE TABLE IF NOT EXISTS fileInfo (
  id int(11) NOT NULL AUTO_INCREMENT,
  file_name varchar(255) NOT NULL,
  store_file_name varchar(255) NOT NULL,
  file_uploaded datetime DEFAULT CURRENT_TIMESTAMP,
  file_size int(11) NOT NULL,
  file_type varchar(128) NOT NULL,
  PRIMARY KEY (id) );
