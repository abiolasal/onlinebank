-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Host: student-db.cse.unt.edu
-- Generation Time: Apr 22, 2020 at 05:51 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `user_id`, `balance`, `account_status`, `loans`) VALUES
(1, 1, 9733.67, 1, 0),
(23, 23, 1181076.37, 1, 0),
(24, 24, 2345.67, 1, 2),
(25, 25, 61508.00, 1, 8),
(27, 27, 11436.79, 1, 0),
(30, 30, 100.19, 1, 0),
(32, 32, 0.00, 1, 0),
(34, 34, 0.19, 1, 0);

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
(23, '062a3dc79587b1b154881e3130e0eda4d41d60b908706eb218edf0b7f44b7850', '1308129514'),
(24, '9d37e88f149438d7a4be803d013c4e23f68eef10ef87252c7022d4b3a20119be', '1371312359'),
(25, '58ccf2a490dba81d45357e8fabdc856c53184b6915f74363bff28e1268530247', '1013243134'),
(27, '6146f4719d47fb82b5ccf147d93e3c370c5a568fd8796b3a30c7e9c56eb7d011', '1326115803'),
(28, 'fd77e04e79dd4d37217b1768ab91bf6b3c285ac3cc982225e7f8434aa3fdd6fe', '1132682911'),
(29, '000d57260f8587db61cd532dbdf6eebdf214928582e1d1cc64d45286d77ff95a', '1372311616'),
(30, '47bb16c6af6d9b76c9b8e12f90f81c9ddf5fcf701a6bb3c8153cf0ea90759a8a', '1181703882'),
(32, 'd15f53d8557459e373fa86371536ab841b2344d220bc9f6c085042909c199c89', '1306229291'),
(34, '8cb2c1b487c4bf748b9e3f6437dd87889859bc3d36865da51035af686888cc73', '1030862380');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100003 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `first_name`, `last_name`, `email`, `phone_number`, `hire_date`, `street_address`, `city`, `state`, `zip`, `type`, `department`, `lastlogin`, `pass`, `salt`, `status`) VALUES
(100001, 'Michael', 'Laundrup', 'michael@staff.com', 9408687840, '2017-11-07', '111, University Dr', 'Denton', 'TX', 76210, 0, 'Teller', '2020-04-21 13:34:38', 'b8bf678947d23bd28791456ec80bfc3be91da45f2e49ecdbfbd5032b7a9bf04c', '1308129514', 0),
(100002, 'admin', 'admin', 'admin', 9400123456, '2017-06-13', '14, Texas street', 'Denton', 'TX', 72010, 1, 'Admin', '2020-04-20 23:03:13', '671d1ef89824a320c3e6073fa824984ca8cdcd453ad7be6d6cf45a1153ceb711', '1142074515', 0);

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
('158692005200010004', 1, 100.02, '2020-04-14 22:07:32', 'test', 'credit'),
('158692009400010004', 1, 0.01, '2020-04-14 22:08:14', 'yrdy', 'credit'),
('158692012600010004', 1, -23.00, '2020-04-14 22:08:46', 'test withdraw', 'debit'),
('158692012784010004', 25, 525.00, '2020-04-15 21:16:06', 'TO Self', 'credit'),
('158709167200010001', 1, 100.00, '2020-04-16 21:47:52', 'birthday', 'credit'),
('158709229300010001', 1, 50.00, '2020-04-16 21:58:13', 'best buy', 'credit'),
('158709758200010001', 1, -50.00, '2020-04-16 23:26:22', 'party supplies', 'debit'),
('158709914600010026', 1, -345.00, '2020-04-16 23:52:26', 'test transfer', 'debit'),
('158710047300010025', 1, -97.86, '2020-04-17 00:14:33', 'test float', 'debit'),
('158710073000010024', 1, -12.34, '2020-04-17 00:18:50', 'float test', 'debit'),
('158710211900010027', 1, -87.65, '2020-04-17 00:41:59', '27 test', 'transfer'),
('158710658600010027', 1, -56.78, '2020-04-17 01:56:26', 'get test', 'transfer'),
('158710761800010024', 1, -1.23, '2020-04-17 02:13:38', 'post test', 'transfer'),
('158713201500010001', 1, -200.00, '2020-04-17 09:00:15', 'test withdraw', 'debit'),
('158713204400010001', 1, -200.00, '2020-04-17 09:00:44', 'test withdraw', 'debit'),
('158713207900010001', 1, -200.00, '2020-04-17 09:01:19', 'test withdraw', 'debit'),
('158713218900010001', 1, -200.00, '2020-04-17 09:03:09', 'test withdraw', 'debit'),
('158713373200010001', 1, -200.00, '2020-04-17 09:28:52', 'test withdraw', 'debit'),
('158713382100010001', 1, -200.00, '2020-04-17 09:30:21', 'test withdraw', 'debit'),
('158713385600010001', 1, -200.00, '2020-04-17 09:30:56', 'test withdraw', 'debit'),
('158713388400010001', 1, -200.00, '2020-04-17 09:31:24', 'test withdraw', 'debit'),
('158713390100010001', 1, -200.00, '2020-04-17 09:31:41', 'test withdraw', 'debit'),
('158713393300010001', 1, -200.00, '2020-04-17 09:32:13', 'test withdraw', 'debit'),
('158713396500010001', 1, -200.00, '2020-04-17 09:32:45', 'test withdraw', 'debit'),
('158713405800010001', 1, 200.00, '2020-04-17 09:34:18', 'test withdraw', 'credit'),
('158713405900010001', 1, 200.00, '2020-04-17 09:34:19', 'test withdraw', 'credit'),
('158713406000010001', 1, 200.00, '2020-04-17 09:34:20', 'test withdraw', 'credit'),
('158713406800010001', 1, 200.00, '2020-04-17 09:34:28', 'test withdraw', 'credit'),
('158713407200010001', 1, 200.00, '2020-04-17 09:34:32', 'test withdraw', 'credit'),
('158713407300010001', 1, 200.00, '2020-04-17 09:34:33', 'test withdraw', 'credit'),
('158713407500010001', 1, 200.00, '2020-04-17 09:34:35', 'test withdraw', 'credit'),
('158713407600010001', 1, 200.00, '2020-04-17 09:34:36', 'test withdraw', 'credit'),
('158713407800010001', 1, 200.00, '2020-04-17 09:34:38', 'test withdraw', 'credit'),
('158713407900010001', 1, 200.00, '2020-04-17 09:34:39', 'test withdraw', 'credit'),
('158713409100010001', 1, -200.00, '2020-04-17 09:34:51', 'test withdraw', 'debit'),
('158713493500010001', 1, -200.00, '2020-04-17 09:48:55', 'test withdraw', 'debit'),
('158734465000230024', 23, -1111.11, '2020-04-19 20:04:10', 'testing', 'transfer'),
('158734481100230025', 23, -123.45, '2020-04-19 20:06:51', 'test both trans', 'transfer'),
('158735456800230025', 23, -111.11, '2020-04-19 22:49:28', 'testing', 'transfer'),
('158735471500230025', 23, -222.22, '2020-04-19 22:51:55', 'multi test', 'transfer'),
('158735555100230026', 23, -333.33, '2020-04-19 23:05:51', 'testing', 'transfer'),
('158735575200230025', 23, -444.44, '2020-04-19 23:09:12', 'multi test', 'transfer'),
('158735585700230025', 23, -555.55, '2020-04-19 23:10:57', 'multi test 25', 'transfer'),
('158735598200230026', 23, -777.77, '2020-04-19 23:13:02', 'multi test 26', 'transfer'),
('158735611000230027', 23, -777.77, '2020-04-19 23:15:10', 'multi test 27', 'transfer'),
('158735611000270023', 27, 777.77, '2020-04-19 23:15:10', 'multi test 27', 'transfer'),
('158735853400230027', 23, -1234.56, '2020-04-19 23:55:34', 'multi test 27', 'transfer'),
('158735853400270023', 27, 1234.56, '2020-04-19 23:55:34', 'multi test 27', 'transfer'),
('158735889300230025', 23, -123.45, '2020-04-20 00:01:33', 'account verification 25', 'transfer'),
('158735889300250023', 25, 123.45, '2020-04-20 00:01:33', 'account verification 25', 'transfer'),
('158735904300230024', 23, -444.44, '2020-04-20 00:04:03', 'account verification 24', 'transfer'),
('158735904300240023', 24, 444.44, '2020-04-20 00:04:03', 'account verification 24', 'transfer'),
('158735922700230024', 23, -8.88, '2020-04-20 00:07:07', 'account verification 24', 'transfer'),
('158735922700240023', 24, 8.88, '2020-04-20 00:07:07', 'account verification 24', 'transfer'),
('158735937600230025', 23, -199.00, '2020-04-20 00:09:36', 'account verification 25', 'transfer'),
('158735937600250023', 25, 199.00, '2020-04-20 00:09:36', 'account verification 25', 'transfer'),
('158735972600230025', 23, -999.99, '2020-04-20 00:15:26', 'account verification 25', 'transfer'),
('158735972600250023', 25, 999.99, '2020-04-20 00:15:26', 'account verification 25', 'transfer'),
('158735976800230025', 23, -1000.00, '2020-04-20 00:16:08', 'empty account 23', 'transfer'),
('158735976800250023', 25, 1000.00, '2020-04-20 00:16:08', 'empty account 23', 'transfer'),
('158736019000230025', 23, -850.00, '2020-04-20 00:23:10', 'deduction 850 from 23', 'transfer'),
('158736019000250023', 25, 850.00, '2020-04-20 00:23:10', 'deduction 850 from 23', 'transfer'),
('158736044400230025', 23, -850.00, '2020-04-20 00:27:24', 'deduct 850 from 23', 'transfer'),
('158736044400250023', 25, 850.00, '2020-04-20 00:27:24', 'deduct 850 from 23', 'transfer'),
('158736060200230024', 23, -145.00, '2020-04-20 00:30:02', 'final transfer', 'transfer'),
('158736060200240023', 24, 145.00, '2020-04-20 00:30:02', 'final transfer', 'transfer'),
('158736119400230027', 23, -9876.54, '2020-04-20 00:39:54', 'final transfer test', 'transfer'),
('158736119400270023', 27, 9876.54, '2020-04-20 00:39:54', 'final transfer test', 'transfer'),
('158736139600230024', 23, -123.40, '2020-04-20 00:43:16', 'digit test', 'transfer'),
('158736139600240023', 24, 123.40, '2020-04-20 00:43:16', 'digit test', 'transfer'),
('158736167000010023', 1, 8765.43, '2020-04-20 00:47:50', 'transfer commented test', 'transfer'),
('158736167000230001', 23, -8765.43, '2020-04-20 00:47:50', 'transfer commented test', 'transfer'),
('158736220900230025', 23, -50.00, '2020-04-20 00:56:49', 'happy birthday', 'transfer'),
('158736220900250023', 25, 50.00, '2020-04-20 00:56:49', 'happy birthday', 'transfer'),
('158739023600010023', 1, 108.24, '2020-04-20 08:43:56', 'test trans', 'transfer'),
('158739023600230001', 23, -108.24, '2020-04-20 08:43:56', 'test trans', 'transfer'),
('158740042100010024', 1, 200.00, '2020-04-20 11:33:41', 'testing', 'transfer'),
('158740042100240001', 24, -200.00, '2020-04-20 11:33:41', 'testing', 'transfer'),
('158740154500010024', 1, 60.00, '2020-04-20 11:52:25', 'style test', 'transfer'),
('158740154500240001', 24, -60.00, '2020-04-20 11:52:25', 'style test', 'transfer'),
('158740388300010025', 1, 400.00, '2020-04-20 12:31:23', 'testing', 'transfer'),
('158740388300250001', 25, -400.00, '2020-04-20 12:31:23', 'testing', 'transfer'),
('158740914400000025', 25, 100000.00, '2020-04-20 13:59:04', 'Home Loan', 'loan'),
('158740926600000025', 25, 100000.00, '2020-04-20 14:01:06', 'Home Loan 2', 'loan'),
('158740945100000025', 25, 150000.00, '2020-04-20 14:04:11', 'Home Loan 3', 'loan'),
('158741389200000025', 25, 100.00, '2020-04-20 15:18:12', 'dont ask', 'loan'),
('158741424300000025', 25, 500.00, '2020-04-20 15:24:03', 'NYSE', 'loan'),
('158741432800000025', 25, 300.00, '2020-04-20 15:25:28', 'NEW PLAYSTATION', 'loan'),
('158741476800000025', 25, 150.00, '2020-04-20 15:32:48', 'testing ver_acct', 'loan'),
('158741490100000025', 25, 50.00, '2020-04-20 15:35:01', 'new game', 'loan'),
('158741527100000025', 25, 250000.00, '2020-04-20 15:41:11', 'Home Loan', 'loan'),
('158741530200230025', 23, 200000.00, '2020-04-20 15:41:42', 'pay off home', 'transfer'),
('158741530200250023', 25, -200000.00, '2020-04-20 15:41:42', 'pay off home', 'transfer'),
('158741541000010025', 1, 100.00, '2020-04-20 15:43:30', '"; SELECT * ;"', 'transfer'),
('158741541000250001', 25, -100.00, '2020-04-20 15:43:30', '"; SELECT * ;"', 'transfer'),
('158742835500000025', 25, 500.00, '2020-04-20 19:19:15', 'new playstation', 'loan'),
('158742854300000025', 25, 400.00, '2020-04-20 19:22:23', 'get to 60k', 'loan'),
('158742864400000025', 25, 100.00, '2020-04-20 19:24:04', 'testing', 'loan'),
('158742879700000025', 25, 400.00, '2020-04-20 19:26:37', 'test', 'loan'),
('158743232100240025', 24, -8.00, '2020-04-20 20:25:21', 'test', 'transfer'),
('158743232100250024', 25, 8.00, '2020-04-20 20:25:21', 'test', 'transfer'),
('158743234000000024', 24, 9999999.99, '2020-04-20 20:25:40', 'need money', 'loan'),
('158743243100000024', 24, 100.00, '2020-04-20 20:27:11', 'moneys', 'loan'),
('158743272800240025', 24, -10000.00, '2020-04-20 20:32:08', 'transfer', 'transfer'),
('158743272800250024', 25, 10000.00, '2020-04-20 20:32:08', 'transfer', 'transfer'),
('158751485200300030', 30, 0.03, '2020-04-21 19:20:52', '<script>alert(''xss'')</script>', 'credit'),
('158751498900300030', 30, 0.05, '2020-04-21 19:23:09', '<script>alert(''xss'')</script>', 'credit'),
('158751505800300030', 30, 0.11, '2020-04-21 19:24:18', '<script>alert(''xss2'')</script>', 'credit'),
('158759535200340034', 34, 0.22, '2020-04-22 17:42:33', 'test', 'credit'),
('158759543200340034', 34, -0.03, '2020-04-22 17:43:52', 'take awau', 'debit');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `phone_number`, `street_address`, `city`, `state`, `zip`, `user_status`, `lastlogin`) VALUES
(1, 'test', 'user', 'test@test.com', 123456789, 'test road', 'denton', 'TX', 12345, 1, '2020-04-15 11:13:32'),
(23, 'Alice', 'Bob', 'alice.bob@test.com', 7894561230, '123, test drive', 'Denton', 'TX', 76209, 1, '2020-04-20 16:39:50'),
(24, 'Eve', 'Dave', 'dave@test.com', 9405856421, '11, Hickory street', 'Atlanta', 'GA', 38062, 1, '2020-04-20 20:32:26'),
(25, 'Comfort', 'Lucky', 'lucky@test.com', 9854785621, 'loop 288', 'denton', 'TX', 76209, 1, '2020-04-20 19:50:22'),
(27, 'Smith', 'Jonathan', 'jsmith@test.com', 9405759978, '11, Hickory street', 'Denton', 'TX', 76201, 1, '2020-04-17 00:15:41'),
(28, 'Barry', 'Allen', 'ballen@test.com', 1234567890, '123 Easy St', 'Central City', 'TX', 12345, 1, '2020-04-21 01:07:52'),
(29, 'Bruce', 'Wayne', 'bwayne@test.com', 987654321, '123 Easy St', 'Gotham', 'TX', 12345, 1, '0000-00-00 00:00:00'),
(30, 'real', 'test', 'testing@bank.com', 1234567890, '2182 Fake St.', 'Denton', 'TX', 76203, 1, '2020-04-22 17:41:37'),
(32, 'Harry', 'Benjamin', 'harry@test.com', 9405856321, '145, West Drive', 'Denton', 'TX', 76210, 1, '0000-00-00 00:00:00'),
(34, 'real', 'test', 'real@test.com', 1234567890, 'nope ST.', 'Dallas', 'TX', 75229, 1, '0000-00-00 00:00:00');

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
