# **Project X**

###### **Author: Peter Kaufman**
## **Dependencies:**

* bootstrap
* jquery
* moment
* d3

## **After Installation:**

Open /application/config/database.php and edit with your database settings
On your database, open a SQL terminal paste this and execute:
```SQL
CREATE TABLE IF NOT EXISTS users (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL DEFAULT '',
  email varchar(255) NOT NULL DEFAULT '',
  password varchar(255) NOT NULL DEFAULT '',
  avatar varchar(255) DEFAULT 'default.jpg',
  created_at datetime NOT NULL,
  is_admin tinyint(1) unsigned NOT NULL DEFAULT '0',
  is_confirmed tinyint(1) unsigned NOT NULL DEFAULT '0',
  is_deleted tinyint(1) unsigned NOT NULL DEFAULT '0',
  last_login datetime DEFAULT NULL,
  num_logins int DEFAULT '0',
  PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS ci_sessions (
        id varchar(40) NOT NULL,
        ip_address varchar(45) NOT NULL,
        timestamp int(10) unsigned DEFAULT 0 NOT NULL,
        data blob NOT NULL,
        PRIMARY KEY (id),
        KEY ci_sessions_timestamp (timestamp)
);
CREATE TABLE IF NOT EXISTS logins(
id int(11) unsigned NOT NULL AUTO_INCREMENT,
username varchar(255) NOT NULL DEFAULT '',
datestamp date,
login datetime DEFAULT NULL,
logout datetime DEFAULT NULL,
PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS versions (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL DEFAULT '',
  version varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS config (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL DEFAULT '',
  value varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);
```
