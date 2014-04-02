-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2014 at 06:06 AM
-- Server version: 5.6.15-log
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ixpdhl`
--

-- --------------------------------------------------------

--
-- Table structure for table `counts`
--

CREATE TABLE IF NOT EXISTS `counts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `count` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `counts`
--

INSERT INTO `counts` (`id`, `store_id`, `date`, `count`, `created_at`, `updated_at`) VALUES
(1, 1, '2014-03-04', 4, '2014-03-30 03:32:56', '2014-03-30 11:32:56'),
(2, 1, '2014-03-06', 6, '2014-03-30 01:17:27', '2014-03-30 09:17:27'),
(3, 1, '2014-03-05', 21, '2014-03-30 01:28:42', '2014-03-30 09:28:42'),
(26, 2, '2014-03-01', 3, '2014-03-30 12:05:37', '2014-03-30 12:05:37'),
(12, 1, '2014-03-15', 24, '2014-03-30 01:54:25', '2014-03-30 09:54:25'),
(11, 1, '2014-03-21', 23, '2014-03-30 01:48:51', '2014-03-30 09:48:51'),
(10, 1, '2014-03-25', 22, '2014-03-30 09:12:54', '2014-03-30 09:12:54'),
(9, 1, '2014-03-27', 22, '2014-03-30 09:07:11', '2014-03-30 09:07:11'),
(13, 1, '2014-03-10', 2, '2014-03-30 09:27:52', '2014-03-30 09:27:52'),
(14, 1, '2014-03-17', 3, '2014-03-30 09:27:54', '2014-03-30 09:27:54'),
(15, 1, '2014-03-19', 3, '2014-03-30 09:28:37', '2014-03-30 09:28:37'),
(16, 1, '2014-03-29', 3, '2014-03-30 09:29:50', '2014-03-30 09:29:50'),
(17, 1, '2014-03-28', 7, '2014-03-30 09:30:42', '2014-03-30 09:30:42'),
(18, 1, '2014-03-22', 3, '2014-03-30 09:46:11', '2014-03-30 09:46:11'),
(19, 1, '2014-03-20', 21, '2014-03-30 01:50:19', '2014-03-30 09:50:19'),
(20, 1, '2014-03-18', 2, '2014-03-30 09:51:06', '2014-03-30 09:51:06'),
(21, 1, '2014-03-07', 32, '2014-03-30 02:02:04', '2014-03-30 10:02:04'),
(22, 1, '2014-03-14', 3, '2014-03-30 09:52:06', '2014-03-30 09:52:06'),
(23, 1, '2014-03-01', 12, '2014-03-30 04:07:07', '2014-03-30 12:07:07'),
(24, 1, '2014-03-08', 2, '2014-03-30 09:54:22', '2014-03-30 09:54:22'),
(25, 1, '2014-01-10', 3, '2014-03-30 11:08:19', '2014-03-30 11:08:19'),
(27, 1, '2014-03-26', 3, '2014-03-31 16:09:46', '2014-03-31 16:09:46'),
(28, 3, '2014-03-19', 3, '2014-03-31 22:29:36', '2014-03-31 22:29:36'),
(29, 3, '2014-03-29', 3, '2014-03-31 22:29:38', '2014-03-31 22:29:38'),
(30, 3, '2014-03-04', 3, '2014-03-31 22:29:39', '2014-03-31 22:29:39'),
(31, 3, '2014-03-08', 3, '2014-03-31 22:29:41', '2014-03-31 22:29:41'),
(32, 3, '2014-03-25', 34, '2014-03-31 22:29:44', '2014-03-31 22:29:44'),
(33, 3, '2014-03-31', 22, '2014-03-31 22:29:48', '2014-03-31 22:29:48');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `subject` varchar(64) NOT NULL,
  `body` varchar(400) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE IF NOT EXISTS `stores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `address` varchar(60) NOT NULL,
  `address2` varchar(60) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `address`, `address2`, `city`, `state`, `zip`, `created_at`, `updated_at`) VALUES
(1, 'TestStore', '123 Test St', '', 'Testville', 'TN', '53214', NULL, NULL),
(2, 'TestStore2', '456 Test Ave', '', 'Huptiland', 'MN', '78945', NULL, NULL),
(3, 'TestStore3', '213123 Main St', '', 'Wimbledon', 'OK', '33333', '2014-03-31 14:28:22', '2014-04-01 07:57:36'),
(4, 'asdf', 'asdf', '', 'sadf', 'AL', '23423', '2014-04-01 08:14:30', '2014-04-01 08:14:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `password_expired` tinyint(4) NOT NULL DEFAULT '1',
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `store_id`, `password_expired`, `admin`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'Test', 'test', 'test', 1, 1, 0, NULL, '2014-03-27 16:56:25', '2014-03-27 16:56:25'),
(2, 'admin', NULL, 'admin', 'admin', NULL, 0, 1, NULL, '2014-03-28 00:05:21', '2014-03-28 00:05:21'),
(3, 'test', 'test', 'testt', 'testt', 2, 1, 0, NULL, '2014-03-30 03:38:55', '2014-03-30 03:38:55'),
(4, 'test3', 'test3', 'testttt', 'testttt', 3, 1, 0, 'asdf@asdf.com', '2014-03-31 14:29:07', '2014-04-01 07:52:46'),
(5, 'asdfasdf', 'asdfasd', 'asdfasd', '', NULL, 1, 0, 'fasdf@adsf.net', '2014-04-01 07:40:27', '2014-04-01 07:40:27');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
