/*
SQLyog Ultimate v12.5.0 (64 bit)
MySQL - 10.4.17-MariaDB : Database - farmer_connection
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`farmer_connection` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `farmer_connection`;

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(200) NOT NULL,
  `parent_category` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  KEY `parent_category` (`parent_category`),
  CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent_category`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `category` */

insert  into `category`(`category_id`,`category`,`parent_category`) values 
(1,'Rice',NULL),
(2,'Fruits',NULL),
(3,'Vegetables',NULL),
(4,'Basmati Rice',1),
(5,'Potatoes',3),
(6,'Lady Finger',3),
(7,'Brown Rice',1),
(8,'Mango',2),
(9,'Orange',2);

/*Table structure for table `category_assigned` */

DROP TABLE IF EXISTS `category_assigned`;

CREATE TABLE `category_assigned` (
  `category_assigned_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `post_type` enum('Discussion Forum','Knowledge Base','E-Commerce','Consultancy') DEFAULT NULL,
  PRIMARY KEY (`category_assigned_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `category_assigned_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `category_assigned` */

insert  into `category_assigned`(`category_assigned_id`,`category_id`,`post_type`) values 
(1,1,'Discussion Forum'),
(2,1,'Knowledge Base'),
(3,1,'E-Commerce'),
(4,4,'Discussion Forum'),
(5,4,'Consultancy'),
(6,4,'E-Commerce'),
(7,4,'Knowledge Base'),
(8,2,'Discussion Forum'),
(9,2,'Knowledge Base');

/*Table structure for table `city` */

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(200) NOT NULL,
  `state_id` int(11) NOT NULL,
  PRIMARY KEY (`city_id`),
  KEY `state_id` (`state_id`),
  CONSTRAINT `city_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `state` (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `city` */

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
  `country` varchar(200) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `country` */

/*Table structure for table `customer_order` */

DROP TABLE IF EXISTS `customer_order`;

CREATE TABLE `customer_order` (
  `customer_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_assigned_role_id` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_method` enum('Cash On Delivery','Jazz Cash','Easy Paisa','Payza','Skrill') NOT NULL,
  `billing_address` longtext NOT NULL,
  `shipping_address` longtext NOT NULL,
  `status` enum('New Order','On The Way','Delivered','Cancel') NOT NULL DEFAULT 'New Order',
  `delivered_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`customer_order_id`),
  KEY `user_assigned_role_id` (`user_assigned_role_id`),
  CONSTRAINT `customer_order_ibfk_1` FOREIGN KEY (`user_assigned_role_id`) REFERENCES `user_assigned_role` (`user_assigned_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `customer_order` */

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
  CONSTRAINT `customer_order_detail_ibfk_1` FOREIGN KEY (`customer_order_id`) REFERENCES `customer_order` (`customer_order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customer_order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `customer_order_detail` */

/*Table structure for table `post` */

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `post_title` varchar(1000) NOT NULL,
  `post_summary` longtext NOT NULL,
  `post_description` longtext DEFAULT NULL,
  `post_type` enum('Knowledge Base','Discussion Forum') NOT NULL,
  `user_assigned_role_id` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_on` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `tag` enum('Success Story','Farmer Experience') DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  KEY `category_id` (`category_id`),
  KEY `user_assigned_role_id` (`user_assigned_role_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`user_assigned_role_id`) REFERENCES `user_assigned_role` (`user_assigned_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `post` */

/*Table structure for table `post_attachment` */

DROP TABLE IF EXISTS `post_attachment`;

CREATE TABLE `post_attachment` (
  `post_attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `attachment_type` enum('Image','Audio','Video','Document') NOT NULL,
  `attachment_file` longtext NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`post_attachment_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `post_attachment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `post_attachment` */

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
  CONSTRAINT `post_like_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_like_ibfk_2` FOREIGN KEY (`user_assigned_role_id`) REFERENCES `user_assigned_role` (`user_assigned_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `post_like` */

/*Table structure for table `post_reply` */

DROP TABLE IF EXISTS `post_reply`;

CREATE TABLE `post_reply` (
  `post_reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `message` longtext NOT NULL,
  `user_assigned_role_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`post_reply_id`),
  KEY `post_id` (`post_id`),
  KEY `user_assigned_role_id` (`user_assigned_role_id`),
  CONSTRAINT `post_reply_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_reply_ibfk_2` FOREIGN KEY (`user_assigned_role_id`) REFERENCES `user_assigned_role` (`user_assigned_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `post_reply` */

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_title` varchar(800) NOT NULL,
  `product_description` longtext DEFAULT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `low_inventory` int(11) NOT NULL,
  `user_assigned_role_id` int(11) NOT NULL,
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
  KEY `user_assigned_role_id` (`user_assigned_role_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`user_assigned_role_id`) REFERENCES `user_assigned_role` (`user_assigned_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `product` */

/*Table structure for table `product_comment` */

DROP TABLE IF EXISTS `product_comment`;

CREATE TABLE `product_comment` (
  `product_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_assigned_role_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`product_comment_id`),
  KEY `product_id` (`product_id`),
  KEY `user_assigned_role_id` (`user_assigned_role_id`),
  CONSTRAINT `product_comment_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_comment_ibfk_2` FOREIGN KEY (`user_assigned_role_id`) REFERENCES `user_assigned_role` (`user_assigned_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `product_id` int(11) NOT NULL,
  `user_assigned_role_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`product_rating_id`),
  KEY `product_id` (`product_id`),
  KEY `user_assigned_role_id` (`user_assigned_role_id`),
  CONSTRAINT `product_rating_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_rating_ibfk_2` FOREIGN KEY (`user_assigned_role_id`) REFERENCES `user_assigned_role` (`user_assigned_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `product_rating` */

/*Table structure for table `state` */

DROP TABLE IF EXISTS `state`;

CREATE TABLE `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(200) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`state_id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `state_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `state` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(200) NOT NULL,
  `middle_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `phone_number` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city_id` int(11) NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `picture` varchar(600) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_on` timestamp NULL DEFAULT NULL,
  `about_user` longtext DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `user` */

/*Table structure for table `user_assigned_role` */

DROP TABLE IF EXISTS `user_assigned_role`;

CREATE TABLE `user_assigned_role` (
  `user_assigned_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `level` enum('Expert','Intermediate','Beginner') NOT NULL DEFAULT 'Beginner',
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_assigned_role_id`),
  KEY `user_role_id` (`user_role_id`),
  KEY `user_assigned_role_ibfk_1` (`user_id`),
  CONSTRAINT `user_assigned_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_assigned_role_ibfk_2` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`user_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_assigned_role` */

/*Table structure for table `user_role` */

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role` varchar(200) NOT NULL,
  PRIMARY KEY (`user_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_role` */

insert  into `user_role`(`user_role_id`,`user_role`) values 
(1,'Farmer'),
(2,'Consultant'),
(3,'Academic'),
(4,'Other'),
(5,'Admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
