-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 24, 2021 at 11:12 PM
-- Server version: 8.0.23
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `outstanding_acoustics`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `cust_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` char(10) DEFAULT NULL,
  PRIMARY KEY (`cust_id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=257 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `emp_id`, `first_name`, `last_name`, `email`, `phone_number`) VALUES
(1, 1, 'Jacob', 'Florida', 'asd@gmai.com', '1232343456'),
(2, 1, 'Noah', 'Slim', 'dude@yahoo.com', '4049821928'),
(3, 3, 'Eli', 'Green', 'water@gmail.com', '7708228919'),
(4, 2, 'Olivia', 'Cool', 'asdf@gmail.com', '4049992888'),
(5, 1, 'Benjamin', 'Zipper', 'hot@yahoo.com', '1237828288'),
(6, 4, 'Lucas', 'Sky', 'cloud@gmail.com', '4563562777'),
(7, 6, 'Mason', 'Williams', 'cooool@gmail.com', '2748812999'),
(8, 1, 'Ethan', 'Ground', 'notcool@gmail.com', '6637728883'),
(9, 7, 'Charlotte', 'Cake', 'food@gmail.com', '6278293782'),
(10, 4, 'Henry', 'House', 'fhsjsdf@gmail.com', '8748398293');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `emp_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `gender` char(1) NOT NULL,
  `emp_pin` int NOT NULL,
  `address` varchar(75) NOT NULL,
  `city` varchar(50) NOT NULL,
  `hired_date` date NOT NULL,
  `is_manager` tinyint(1) NOT NULL,
  PRIMARY KEY (`emp_id`),
  UNIQUE KEY `emp_pin` (`emp_pin`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `first_name`, `last_name`, `gender`, `emp_pin`, `address`, `city`, `hired_date`, `is_manager`) VALUES
(1, 'Tom', 'Brown', 'M', 1234, '1674 Cool Street', 'Atlanta', '2000-02-10', 1),
(2, 'John', 'Green', 'M', 1367, '6482 Warm Street', 'Duluth', '2002-05-23', 0),
(3, 'Sarah', 'Wolf', 'F', 1873, '8903 Long Street', 'Duluth', '2002-10-15', 0),
(4, 'James', 'Schwartz', 'M', 1233, '1374 Daunting Boulevard', 'Atlanta', '2020-05-01', 0),
(5, 'Jenna', 'Blue', 'F', 48812, '1230 Treasure Street', 'Marrieta', '2015-06-17', 0),
(6, 'Brandy', 'Flower', 'F', 12372, '9932 Super Street', 'Duluth', '2010-11-14', 1),
(7, 'Gerald', 'Leaf', 'M', 12379, '1289 Dude Street', 'Decatur', '2018-01-07', 0),
(8, 'Josh', 'Sora', 'M', 58247, '8372 Smooth Boulevard', 'Buckhead', '2016-12-24', 0),
(9, 'Abi', 'Rock', 'F', 122892, '1822 Golden Street', 'Duluth', '2019-09-05', 0),
(10, 'Chad', 'Baker', 'M', 123334, '1772 Shoe Street', 'Brookhaven', '2017-04-20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `inv_id` int NOT NULL AUTO_INCREMENT,
  `shipment_id` int NOT NULL,
  `emp_id` int NOT NULL,
  `item_type` varchar(50) NOT NULL,
  `item_model` varchar(50) DEFAULT NULL,
  `item_company` varchar(50) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`inv_id`),
  KEY `shipment_id` (`shipment_id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inv_id`, `shipment_id`, `emp_id`, `item_type`, `item_model`, `item_company`, `price`) VALUES
(1, 4, 1, 'Guitar', 'SuperMetal', 'Fender', 550.32),
(2, 4, 1, 'Guitar', 'SuperMetal2', 'Fender', 700.32),
(3, 4, 1, 'Guitar', 'SuperMetal2', 'Fender', 700.32),
(4, 4, 1, 'Guitar', 'SuperMetal2', 'Fender', 700.32),
(5, 4, 1, 'Guitar', 'SuperMetal2', 'Fender', 700.32),
(6, 4, 1, 'Guitar', 'SuperMetal2', 'Fender', 700.32),
(7, 4, 1, 'Guitar', 'MellowVibe', 'Gibson', 1000),
(8, 4, 1, 'Guitar', 'MellowVibe', 'Gibson', 1000),
(9, 4, 1, 'Guitar', 'MellowVibe', 'Gibson', 1000),
(10, 4, 1, 'Guitar', 'MellowVibe', 'Gibson', 1000),
(11, 1, 3, 'Piano', 'Awesome', 'Yamaha', 2000),
(12, 1, 3, 'Piano', 'Awesome', 'Yamaha', 2000),
(13, 1, 3, 'Piano', 'Awesome', 'Yamaha', 2000),
(14, 1, 3, 'Piano', 'Thunder', 'Yamaha', 3000),
(15, 1, 3, 'Piano', 'Awesome', 'Yamaha', 2000),
(16, 1, 3, 'Piano', 'Thunder', 'Yamaha', 3000),
(17, 1, 3, 'Piano', 'Awesome', 'Yamaha', 2000),
(18, 1, 3, 'Piano', 'Thunder', 'Yamaha', 3000),
(19, 1, 3, 'Guitar', 'Metallic', 'Stellar', 300),
(20, 1, 3, 'Guitar', 'Metallic', 'Stellar', 300),
(21, 1, 3, 'Guitar', 'Blue', 'Stellar', 1000),
(22, 1, 3, 'Guitar', 'Metallic', 'Stellar', 300),
(23, 1, 3, 'Guitar', 'Blue', 'Stellar', 1000),
(24, 9, 8, 'Violin', 'Sweet', 'StringKing', 5000),
(25, 9, 8, 'Violin', 'Sweet', 'StringKing', 5000),
(26, 9, 8, 'Violin', 'Sweeter', 'StringKing', 1000),
(27, 9, 8, 'Violin', 'Sweetest', 'StringKing', 12000),
(28, 10, 9, 'Cello', 'Cool', 'StringKing', 2000),
(29, 10, 9, 'Cello', 'Cool', 'StringKing', 2000),
(30, 10, 9, 'Cello', 'Cool', 'StringKing', 2000),
(31, 10, 9, 'Trumpet', 'LoudOne', 'JazzMax', 350.3),
(32, 10, 9, 'Trumpet', 'LoudOne', 'JazzMax', 350.3),
(33, 10, 9, 'Cello', 'Cool', 'StringKing', 2000),
(34, 10, 9, 'Saxophone', 'Loudy', 'JazzMax', 3000),
(41, 15, 1, 'Guitar', 'SuperMetal2', 'Fender', 700.32),
(40, 15, 1, 'Guitar', 'SuperMetal', 'Fender', 550.32),
(42, 15, 1, 'Guitar', 'SuperMetal2', 'Fender', 700.32),
(43, 15, 1, 'Guitar', 'SuperMetal2', 'Fender', 700.32),
(44, 15, 1, 'Guitar', 'SuperMetal2', 'Fender', 700.32),
(45, 15, 1, 'Guitar', 'SuperMetal2', 'Fender', 700.32),
(46, 15, 1, 'Guitar', 'MellowVibe', 'Gibson', 1000),
(47, 15, 1, 'Guitar', 'MellowVibe', 'Gibson', 1000),
(48, 15, 1, 'Guitar', 'MellowVibe', 'Gibson', 1000),
(49, 15, 1, 'Guitar', 'MellowVibe', 'Gibson', 1000),
(50, 15, 3, 'Piano', 'Awesome', 'Yamaha', 2000),
(51, 15, 3, 'Piano', 'Awesome', 'Yamaha', 2000),
(52, 15, 3, 'Piano', 'Awesome', 'Yamaha', 2000),
(53, 15, 3, 'Piano', 'Thunder', 'Yamaha', 3000),
(54, 15, 3, 'Piano', 'Awesome', 'Yamaha', 2000),
(55, 15, 3, 'Piano', 'Thunder', 'Yamaha', 3000),
(56, 15, 3, 'Piano', 'Awesome', 'Yamaha', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

DROP TABLE IF EXISTS `lesson`;
CREATE TABLE IF NOT EXISTS `lesson` (
  `lesson_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `cust_id` int NOT NULL,
  `instrument` varchar(50) NOT NULL,
  `start_time` datetime NOT NULL,
  `duration` float NOT NULL,
  PRIMARY KEY (`lesson_id`),
  KEY `emp_id` (`emp_id`),
  KEY `cust_id` (`cust_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`lesson_id`, `emp_id`, `cust_id`, `instrument`, `start_time`, `duration`) VALUES
(1, 1, 3, 'Guitar', '2021-01-20 14:30:00', 1),
(2, 1, 2, 'Piano', '2021-01-05 12:30:00', 1.5),
(3, 4, 6, 'Piano', '2021-05-12 14:00:00', 2),
(4, 7, 2, 'Guitar', '2021-05-11 15:30:00', 0.5),
(5, 9, 2, 'Guitar', '2021-03-14 17:00:00', 1.5),
(6, 4, 1, 'Violin', '2020-04-21 17:30:00', 2),
(7, 1, 4, 'Piano', '2021-06-23 10:30:00', 1),
(8, 7, 10, 'Piano', '2019-10-23 12:30:00', 1),
(9, 1, 2, 'Cello', '2021-01-04 15:00:00', 0),
(10, 7, 3, 'Violin', '2020-04-08 15:00:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `paycheck`
--

DROP TABLE IF EXISTS `paycheck`;
CREATE TABLE IF NOT EXISTS `paycheck` (
  `check_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `hours` float NOT NULL,
  `pay_rate` float NOT NULL,
  PRIMARY KEY (`check_id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paycheck`
--

INSERT INTO `paycheck` (`check_id`, `emp_id`, `start_date`, `end_date`, `hours`, `pay_rate`) VALUES
(1, 1, '2019-11-11', '2019-11-25', 80, 20.5),
(2, 1, '2019-11-25', '2019-12-09', 80, 20.5),
(3, 1, '2019-12-09', '2019-12-23', 75, 20.5),
(4, 2, '2020-10-12', '2020-10-26', 60, 15),
(5, 2, '2020-10-26', '2020-11-09', 50, 15),
(6, 3, '2020-11-11', '2020-11-25', 45, 12),
(7, 4, '2021-01-18', '2021-02-01', 65, 16),
(8, 5, '2020-11-23', '2020-12-07', 30, 10),
(9, 6, '2020-12-28', '2021-01-11', 80, 15),
(10, 7, '2020-12-28', '2021-01-11', 51, 14),
(11, 7, '2021-01-11', '2021-01-25', 33, 14),
(12, 8, '2020-07-12', '2020-07-26', 34, 12),
(13, 9, '2021-02-14', '2021-02-28', 59, 15),
(14, 10, '2021-03-08', '2021-03-22', 45, 10);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_group`
--

DROP TABLE IF EXISTS `purchase_group`;
CREATE TABLE IF NOT EXISTS `purchase_group` (
  `group_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `cust_id` int DEFAULT NULL,
  `purchase_time` datetime NOT NULL,
  PRIMARY KEY (`group_id`),
  KEY `emp_id` (`emp_id`),
  KEY `cust_id` (`cust_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchase_group`
--

INSERT INTO `purchase_group` (`group_id`, `emp_id`, `cust_id`, `purchase_time`) VALUES
(1, 1, 2, '2021-01-20 14:55:27'),
(2, 1, 3, '2020-09-29 09:22:46'),
(3, 1, 7, '2021-03-03 10:15:36'),
(4, 6, 8, '2020-09-01 07:37:09'),
(5, 5, 3, '2020-05-28 10:52:57'),
(6, 8, 6, '2021-02-17 08:00:31'),
(7, 8, 6, '2021-02-09 09:42:17'),
(8, 9, 8, '2020-06-03 08:49:36'),
(9, 2, 10, '2021-03-10 11:51:20'),
(10, 9, 5, '2019-12-20 09:36:48'),
(25, 9, 3, '2021-04-24 18:05:29'),
(23, 1, 4, '2021-04-20 01:46:32'),
(24, 1, 5, '2021-04-20 02:11:36');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

DROP TABLE IF EXISTS `purchase_items`;
CREATE TABLE IF NOT EXISTS `purchase_items` (
  `purchase_item_id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `inv_id` int NOT NULL,
  PRIMARY KEY (`purchase_item_id`),
  KEY `group_id` (`group_id`),
  KEY `inv_id` (`inv_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`purchase_item_id`, `group_id`, `inv_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 1, 31),
(4, 2, 2),
(5, 3, 4),
(6, 3, 29),
(7, 4, 5),
(8, 5, 6),
(9, 6, 11),
(10, 6, 12),
(11, 7, 7),
(12, 7, 16),
(13, 8, 15),
(14, 9, 33),
(15, 10, 22),
(30, 24, 18),
(31, 24, 26),
(32, 25, 19),
(29, 24, 9),
(28, 23, 34),
(27, 23, 32),
(26, 23, 8),
(33, 25, 54),
(34, 25, 25);

-- --------------------------------------------------------

--
-- Table structure for table `shipment`
--

DROP TABLE IF EXISTS `shipment`;
CREATE TABLE IF NOT EXISTS `shipment` (
  `shipment_id` int NOT NULL AUTO_INCREMENT,
  `shipping_company_name` varchar(50) NOT NULL,
  `arrival_date` date NOT NULL,
  `item_count` int NOT NULL,
  PRIMARY KEY (`shipment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shipment`
--

INSERT INTO `shipment` (`shipment_id`, `shipping_company_name`, `arrival_date`, `item_count`) VALUES
(1, 'Express', '2010-08-07', 12),
(2, 'SuperExpress', '2005-01-15', 4),
(3, 'FastDelivery', '2020-07-07', 4),
(4, 'SlowDeliveryJustKidding', '2018-05-12', 20),
(5, 'FastDelivery', '2020-11-25', 8),
(6, 'FastDelivery', '2015-04-08', 7),
(7, 'Express', '2020-05-20', 3),
(8, 'Express', '2019-09-21', 4),
(9, 'Express', '2002-02-16', 5),
(10, 'FastDelivery', '2018-06-28', 18),
(15, 'Express', '2017-02-09', 30);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
