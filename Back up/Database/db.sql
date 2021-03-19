/*
SQLyog Ultimate v12.5.0 (64 bit)
MySQL - 10.4.17-MariaDB : Database - farmer
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`farmer` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `farmer`;

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(200) DEFAULT NULL,
  `parent_category` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  KEY `parent_category` (`parent_category`),
  CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent_category`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Data for the table `category` */

insert  into `category`(`category_id`,`category`,`parent_category`) values 
(1,'Rice',NULL),
(2,'Basmati',1),
(3,'Fruit',NULL),
(4,'Mango',3),
(5,'Banana',3),
(6,'Flour',NULL),
(7,'Vegetable',NULL),
(8,'Lady Finger',7),
(9,'Onion',7),
(10,'Tomato',7),
(11,'Potato',7),
(12,'Spanich',NULL);

/*Table structure for table `category_assign` */

DROP TABLE IF EXISTS `category_assign`;

CREATE TABLE `category_assign` (
  `assign_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `post_type` enum('Knowledge_Base','Discussion_Forum','E-Commerce','Consultancy') DEFAULT NULL,
  PRIMARY KEY (`assign_id`),
  KEY `category_id` (`category_id`),
  KEY `category_type_id` (`post_type`),
  CONSTRAINT `category_assign_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `category_assign` */

insert  into `category_assign`(`assign_id`,`category_id`,`post_type`) values 
(1,1,'Knowledge_Base'),
(2,1,'Discussion_Forum'),
(3,3,'Knowledge_Base'),
(4,2,'Knowledge_Base');

/*Table structure for table `city` */

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(200) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  KEY `state_id` (`state_id`),
  CONSTRAINT `city_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `state` (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

/*Data for the table `city` */

insert  into `city`(`city_id`,`city_name`,`state_id`) values 
(1,'Karachi',1),
(2,'Hyderabad',1),
(3,'Sukkur',1),
(4,'Larkana',1),
(5,'Lahore',2),
(6,'Rawalpindi',2),
(7,'Islamabad',2),
(8,'Sibi',3),
(9,'Sui',3),
(10,'Quetta',3),
(11,'Peshawar',4),
(12,'Mardan',4),
(13,'Kohat',4),
(14,'Dera Ismail khan',4),
(15,'Swat',4),
(16,'	Ming',5),
(17,'Qing',5),
(18,'Zhangmu',6),
(19,'Lokhla',6),
(20,'Andheri',7),
(21,'Goregaon',7),
(22,'Firozabad',8),
(23,'Siri',8),
(24,'Shergarh',8),
(25,'Jaipur',9),
(26,'Udaipur',9),
(27,'Jacksonville',10),
(28,'Tallahassee',11),
(29,'Miami',12);

/*Table structure for table `consultancy_service` */

DROP TABLE IF EXISTS `consultancy_service`;

CREATE TABLE `consultancy_service` (
  `consultancy_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `consultant` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `query` longtext NOT NULL,
  `discussion_start` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `discussion_end` timestamp NULL DEFAULT NULL,
  `status` enum('In-Process','Complete') DEFAULT 'In-Process',
  `rating` int(1) DEFAULT NULL,
  `feedback` longtext DEFAULT NULL,
  PRIMARY KEY (`consultancy_service_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `consultancy_service_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `consultancy_service` */

/*Table structure for table `consultancy_service_chat` */

DROP TABLE IF EXISTS `consultancy_service_chat`;

CREATE TABLE `consultancy_service_chat` (
  `consultancy_service_chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `consultancy_service_id` int(11) NOT NULL,
  `chat_message` longtext NOT NULL,
  `user_assigned_role_id` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`consultancy_service_chat_id`),
  KEY `consultancy_service_id` (`consultancy_service_id`),
  KEY `user_assigned_role_id` (`user_assigned_role_id`),
  CONSTRAINT `consultancy_service_chat_ibfk_1` FOREIGN KEY (`consultancy_service_id`) REFERENCES `consultancy_service` (`consultancy_service_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `consultancy_service_chat_ibfk_2` FOREIGN KEY (`user_assigned_role_id`) REFERENCES `user_assigned_role` (`user_assigned_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `consultancy_service_chat` */

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `country` */

insert  into `country`(`country_id`,`country_name`) values 
(1,'Pakistan'),
(2,'China'),
(3,'India'),
(4,'USA');

/*Table structure for table `customer_order` */

DROP TABLE IF EXISTS `customer_order`;

CREATE TABLE `customer_order` (
  `customer_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_assign_role_id` int(11) DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_method` enum('Cash On Delivery','Jazz Cash','Easy Paisa','Payza','Skrill') NOT NULL,
  `billing_address` longtext NOT NULL,
  `shipping_address` longtext NOT NULL,
  `status` enum('New Order','On The Way','Delivered','Cancel') NOT NULL DEFAULT 'New Order',
  `delivered_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`customer_order_id`),
  KEY `user_assign_role_id` (`user_assign_role_id`),
  CONSTRAINT `customer_order_ibfk_1` FOREIGN KEY (`user_assign_role_id`) REFERENCES `user_assign_role` (`user_assign_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `customer_order` */

insert  into `customer_order`(`customer_order_id`,`user_assign_role_id`,`added_on`,`payment_method`,`billing_address`,`shipping_address`,`status`,`delivered_on`) values 
(1,2,'2021-03-06 09:49:50','Cash On Delivery','Jamshoro','Hyderabad','New Order',NULL),
(2,2,'2021-03-06 09:49:27','Cash On Delivery','Jamshoro','Hyderabad','Delivered',NULL),
(3,1,'2021-03-06 15:21:35','Cash On Delivery','Jamshoro','Hyderabad','Cancel',NULL),
(4,1,'2021-03-06 15:21:38','Cash On Delivery','Jamshoro','Hyderabad','On The Way',NULL);

/*Table structure for table `customer_order_detail` */

DROP TABLE IF EXISTS `customer_order_detail`;

CREATE TABLE `customer_order_detail` (
  `customer_order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`customer_order_detail_id`),
  KEY `customer_order_id` (`customer_order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `customer_order_detail_ibfk_1` FOREIGN KEY (`customer_order_id`) REFERENCES `customer_order` (`customer_order_id`),
  CONSTRAINT `customer_order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `customer_order_detail` */

/*Table structure for table `post` */

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `user_assign_role_id` int(11) NOT NULL,
  `post_title` varchar(500) NOT NULL,
  `post_description` longtext NOT NULL,
  `post_summary` longtext DEFAULT NULL,
  `post_type` enum('Knowledge Base','Discussion Forum') DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_on` timestamp NULL DEFAULT NULL,
  `tag` enum('Success Story','Farmer Experience') DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_assign_role_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_assign_role_id`) REFERENCES `user_assign_role` (`user_assign_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `post` */

insert  into `post`(`post_id`,`category_id`,`user_assign_role_id`,`post_title`,`post_description`,`post_summary`,`post_type`,`is_active`,`added_on`,`updated_on`,`tag`) values 
(1,3,1,'What is Lorem Ipsum?','Lorem Ipsum is simply dummy text of the printing and typesetting industry.','Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.','Knowledge Base',0,'2021-03-05 18:23:58',NULL,NULL),
(2,2,2,'What is Lorem Ipsum?','Lorem Ipsum is simply dummy text of the printing and typesetting industry.','Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.','Knowledge Base',0,'2021-03-05 18:23:54',NULL,NULL),
(3,3,3,'What is Lorem Ipsum?','Lorem Ipsum is simply dummy text of the printing and typesetting industry.','Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.','Knowledge Base',0,'2021-03-05 18:23:52',NULL,NULL),
(4,1,4,'What is Lorem Ipsum?','Lorem Ipsum is simply dummy text of the printing and typesetting industry.','Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.','Knowledge Base',0,'2021-03-05 18:23:50',NULL,NULL),
(5,1,2,'What is Lorem Ipsum?','Lorem Ipsum is simply dummy text of the printing and typesetting industry.','Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.','Discussion Forum',0,'2021-03-03 17:52:08',NULL,NULL);

/*Table structure for table `post_attachment` */

DROP TABLE IF EXISTS `post_attachment`;

CREATE TABLE `post_attachment` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `file_name` longtext NOT NULL,
  `file_type` enum('picture','audio','video','document') NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`attachment_id`),
  KEY `blog_id` (`post_id`),
  CONSTRAINT `post_attachment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `post_attachment` */

insert  into `post_attachment`(`attachment_id`,`post_id`,`file_name`,`file_type`,`added_on`) values 
(1,1,'images/capture.png','picture','2021-03-03 18:41:29'),
(2,3,'images/Hydrangeas.jpg','picture','2021-03-03 18:41:56'),
(3,2,'images/Jellyfish.jpg','picture','2021-03-03 18:42:11'),
(4,4,'images/farmer1.jpg','picture','2021-03-03 18:22:07');

/*Table structure for table `post_like` */

DROP TABLE IF EXISTS `post_like`;

CREATE TABLE `post_like` (
  `post_like_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_assigned_role_id` int(11) NOT NULL,
  `is_like` tinyint(1) DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`post_like_id`),
  KEY `post_id` (`post_id`),
  KEY `user_assigned_role_id` (`user_assigned_role_id`),
  CONSTRAINT `post_like_ibfk_2` FOREIGN KEY (`user_assigned_role_id`) REFERENCES `user_assigned_role` (`user_assigned_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `post_like` */

/*Table structure for table `post_reply` */

DROP TABLE IF EXISTS `post_reply`;

CREATE TABLE `post_reply` (
  `post_reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `message` longtext NOT NULL,
  `user_assign_role_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`post_reply_id`),
  KEY `post_id` (`post_id`),
  KEY `user_assigned_role_id` (`user_assign_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `post_reply` */

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `user_assign_role_id` int(11) NOT NULL,
  `product_title` varchar(800) NOT NULL,
  `product_description` longtext DEFAULT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `low_inventory` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_on` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_free_shipping` tinyint(1) NOT NULL DEFAULT 1,
  `shipping_charges` int(11) DEFAULT NULL,
  `is_rating_allowed` tinyint(1) NOT NULL DEFAULT 1,
  `is_comment_allowed` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `product` */

/*Table structure for table `product_comment` */

DROP TABLE IF EXISTS `product_comment`;

CREATE TABLE `product_comment` (
  `product_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_assign_role_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`product_comment_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_comment_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `product_comment` */

/*Table structure for table `product_image` */

DROP TABLE IF EXISTS `product_image`;

CREATE TABLE `product_image` (
  `product_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image_path` longtext NOT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT 0,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`product_image_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `product_image` */

/*Table structure for table `product_rating` */

DROP TABLE IF EXISTS `product_rating`;

CREATE TABLE `product_rating` (
  `product_rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_assign_role_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`product_rating_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_rating_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `product_rating` */

/*Table structure for table `state` */

DROP TABLE IF EXISTS `state`;

CREATE TABLE `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(200) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`state_id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `state_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Data for the table `state` */

insert  into `state`(`state_id`,`state_name`,`country_id`) values 
(1,'Sindh',1),
(2,'Punjab',1),
(3,'Balochistan',1),
(4,'KPK',1),
(5,'Beijing',2),
(6,'Tibet',2),
(7,'Mumbai',3),
(8,'Delhi',3),
(9,'Rajastan',3),
(10,'Florida',4),
(11,'North Carolina',4),
(12,'Orlando',4);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_image` varchar(200) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `expert_level` enum('Expert','Intermediate','Beginner') DEFAULT NULL,
  `phone_number` varchar(200) DEFAULT NULL,
  `address` varchar(1000) DEFAULT NULL,
  `is_active` int(1) DEFAULT 1,
  `is_approved` int(1) DEFAULT 0,
  `added_on` int(11) DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user` */

insert  into `user`(`user_id`,`first_name`,`last_name`,`user_email`,`user_password`,`user_image`,`city_id`,`expert_level`,`phone_number`,`address`,`is_active`,`is_approved`,`added_on`,`updated_on`) values 
(1,'Ahmed','Shah','ahmed_ali@gmail.com','202cb962ac59075b964b07152d234b70','dist/img/avatar5.png',NULL,'Expert',NULL,NULL,1,1,NULL,NULL),
(2,'Aliya','Qureshi','aliya@gmail.com','202cb962ac59075b964b07152d234b70','dist/img/avatar2.png',NULL,'Intermediate',NULL,NULL,0,1,NULL,NULL),
(3,'Siraj','Baig','siraj@gmail.com','202cb962ac59075b964b07152d234b70','dist/img/avatar4.png',NULL,'Intermediate',NULL,NULL,1,0,NULL,NULL),
(5,'Nisar','Shah','nisar@gmail.com','202cb962ac59075b964b07152d234b70','dist/img/avatar4.png',NULL,'Beginner',NULL,NULL,0,1,NULL,NULL),
(6,'Abdullah','Shah','abdul@gmail.com','202cb962ac59075b964b07152d234b70','dist/img/avatar5.png',NULL,'Intermediate',NULL,NULL,1,0,NULL,NULL),
(10,'Noshad','Ali','noshad_ali@gmail.com','202cb962ac59075b964b07152d234b70','images/123.jpg',2,'Intermediate','0300-1231231','H# c-1 citizen colony',0,1,1614948707,NULL);

/*Table structure for table `user_assign_role` */

DROP TABLE IF EXISTS `user_assign_role`;

CREATE TABLE `user_assign_role` (
  `user_assign_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_assign_role_id`),
  KEY `user_role_id` (`user_role_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_assign_role_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`user_role_id`),
  CONSTRAINT `user_assign_role_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_assign_role` */

insert  into `user_assign_role`(`user_assign_role_id`,`user_id`,`user_role_id`) values 
(1,1,1),
(2,2,4),
(3,3,2),
(4,1,4),
(6,5,4),
(8,10,4);

/*Table structure for table `user_role` */

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`user_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_role` */

insert  into `user_role`(`user_role_id`,`user_role`) values 
(1,'Admin'),
(2,'Academic'),
(3,'Farmer'),
(4,'Consultant'),
(5,'Other');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
