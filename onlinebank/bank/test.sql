-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: student-db.cse.unt.edu
-- Generation Time: Apr 27, 2020 at 10:24 PM
-- Server version: 5.5.54-0ubuntu0.12.04.1
-- PHP Version: 5.3.10-1ubuntu3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(10) unsigned NOT NULL,
  `balance` decimal(11,2) NOT NULL,
  `account_status` tinyint(1) NOT NULL,
  `loans` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_id` (`account_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2533 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `user_id`, `balance`, `account_status`, `loans`) VALUES
(1283, 1283, 122766.00, 1, 2),
(2529, 2529, 800.00, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pwd`
--

CREATE TABLE IF NOT EXISTS `pwd` (
  `user_id` mediumint(10) unsigned NOT NULL,
  `pass` varchar(64) NOT NULL,
  `salt` varchar(10) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `salt` (`salt`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pwd`
--

INSERT INTO `pwd` (`user_id`, `pass`, `salt`) VALUES
(1283, 'bdbb3a8329c0296ba332f5b487de8243e5ae455558f80e9e6e8ee22b7878dd36', '1135058302'),
(2529, '2298c09acde873116c740296893b0a8f8ee602c2c391245c8bb2cc0b024bfbd4', '1333730065');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(25) NOT NULL,
  `phone_number` bigint(10) unsigned NOT NULL,
  `hire_date` date NOT NULL,
  `street_address` varchar(25) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` mediumint(8) unsigned NOT NULL,
  `type` int(11) NOT NULL,
  `department` varchar(20) NOT NULL,
  `lastlogin` datetime NOT NULL,
  `pass` varchar(64) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `email` (`email`,`salt`),
  UNIQUE KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100004 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `first_name`, `last_name`, `email`, `phone_number`, `hire_date`, `street_address`, `city`, `state`, `zip`, `type`, `department`, `lastlogin`, `pass`, `salt`, `status`) VALUES
(10001, 'admin', 'admin', 'admin', 9401034578, '0000-00-00', '', '', '', 76201, 1, 'admin', '0000-00-00 00:00:00', '2298c09acde873116c740296893b0a8f8ee602c2c391245c8bb2cc0b024bfbd4', '1333730065', 1),
(10002, 'Michael', 'Moore', 'MichaelMoore7@my.unt.edu', 1234567890, '2020-04-27', '123 Fake Rd.', 'denton', 'TX', 12345, 0, 'dev!', '0000-00-00 00:00:00', '3649128444c396c1323e25b600bb582439feb89a4dd6a18598fc50859e5b4976', '1314155383', 1),
(10003, 'Bruce', 'Wayne', 'bwayne@test.com', 1111111111, '2017-04-02', '123 Easy Street', 'Gotham', 'TX', 12345, 0, 'Manager', '0000-00-00 00:00:00', 'bf25c45bf6e8b002bc9cb05518def1d969ede02063124114d0d6221c3bc7e01d', '1245057539', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `trans_id` varchar(18) NOT NULL,
  `account_id` mediumint(10) unsigned NOT NULL,
  `amount` decimal(9,2) NOT NULL,
  `trans_date` datetime DEFAULT NULL,
  `description` varchar(30) NOT NULL,
  `type` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`trans_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`trans_id`, `account_id`, `amount`, `trans_date`, `description`, `type`) VALUES
('158804199625292529', 2529, 400.00, '2020-04-27 21:46:36', 'tesrt', 'credit'),
('158804200200001283', 1283, 10000.00, '2020-04-27 21:46:42', '<script>alert("xss")', 'loan'),
('158804204112831284', 1283, -1000.00, '2020-04-27 21:47:21', '<script>alert("xss")', 'transfer'),
('158804206100001283', 1283, 12333.00, '2020-04-27 21:47:41', 'asdfsadf', 'loan'),
('158804229800001283', 1283, 100000.00, '2020-04-27 21:51:38', 'asdfasdf', 'loan'),
('158804244600001283', 1283, 199.00, '2020-04-27 21:54:06', 'stuff', 'loan'),
('158804424300001283', 1283, 1234.00, '2020-04-27 22:24:03', 'stuff', 'loan');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(25) NOT NULL,
  `phone_number` bigint(10) unsigned NOT NULL,
  `street_address` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` mediumint(8) unsigned NOT NULL,
  `user_status` tinyint(1) NOT NULL,
  `lastlogin` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`,`phone_number`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2533 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `phone_number`, `street_address`, `city`, `state`, `zip`, `user_status`, `lastlogin`) VALUES
(1283, 'Barry', 'Allen', 'ballen@test.com', 1234567890, '123 Easy St', 'Central City', 'TX', 12345, 1, '0000-00-00 00:00:00'),
(2529, 'Michael', 'Moore', 'MichaelMoore7@my.unt.edu', 1234567890, '123 Fake Rd.', 'Dallas', 'TX', 12345, 1, '2020-04-27 21:53:06');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `pwd`
--
ALTER TABLE `pwd`
  ADD CONSTRAINT `pwd_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
