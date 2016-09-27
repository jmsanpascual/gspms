-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2016 at 09:23 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gspms`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE IF NOT EXISTS `activities` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`, `start_date`, `end_date`, `status_id`, `created_at`, `updated_at`, `remarks`, `description`) VALUES
(1, 'rej', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, '2016-03-10 17:53:09', '2016-03-10 10:00:58', NULL, NULL),
(2, 'Tanim bala', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '2016-03-10 19:06:08', NULL, NULL, NULL),
(3, 'tanim bala', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '2016-03-10 19:13:40', NULL, NULL, NULL),
(4, 'helllooo', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '2016-03-10 19:13:53', NULL, NULL, NULL),
(8, 'Test', '2016-03-14 00:00:00', '2016-03-14 00:00:00', 0, '2016-03-14 13:37:16', NULL, NULL, NULL),
(9, 'wwewe', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '2016-03-14 13:43:35', NULL, NULL, NULL),
(10, 'weqrerqw', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '2016-03-17 20:34:06', NULL, NULL, NULL),
(11, 'aevevwa', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '2016-03-17 22:15:23', '2016-03-17 14:15:32', NULL, NULL),
(12, 'lknoln', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '2016-03-17 22:17:25', NULL, NULL, NULL),
(13, 'Tree Planting', '2016-09-11 00:00:00', '2016-09-12 00:00:00', 2, '2016-03-21 12:56:39', '2016-03-21 05:05:21', NULL, 'Plant trees'),
(14, 'Energy Saving Campaign', '2016-02-12 00:00:00', '2016-02-19 00:00:00', 1, '2016-03-21 14:13:18', NULL, NULL, 'A campaign to promote energy saving'),
(15, 'Tree Planting', '2015-02-12 00:00:00', '2016-02-12 00:00:00', 1, '2016-03-22 17:28:03', NULL, NULL, 'Test'),
(16, 'sgsdg', '1970-01-01 00:00:00', '1970-01-01 00:00:00', 1, '2016-03-25 08:56:44', NULL, NULL, 'dsf'),
(17, 'jkhkj', '1970-01-01 00:00:00', '1970-01-01 00:00:00', 1, '2016-03-25 09:00:07', NULL, NULL, 'hjkhkj'),
(20, 'lkjlk', '1970-01-01 00:00:00', '1970-01-01 00:00:00', 1, '2016-03-25 09:02:40', NULL, NULL, 'jkljl'),
(21, 'l;k;lk', '1970-01-01 00:00:00', '1970-01-01 00:00:00', 1, '2016-03-25 09:03:46', NULL, NULL, 'k;lk'),
(22, 'bumaf', '1970-01-01 00:00:00', '1970-01-01 00:00:00', 1, '2016-03-25 09:05:29', NULL, NULL, 'kj');

-- --------------------------------------------------------

--
-- Table structure for table `activity_status`
--

CREATE TABLE IF NOT EXISTS `activity_status` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_status`
--

INSERT INTO `activity_status` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'For Approval', '2016-03-10 18:00:33', NULL),
(2, 'Approved', '2016-03-10 18:00:33', NULL),
(3, 'Disapproved', '2016-03-10 18:00:33', NULL),
(4, 'Completed', '2016-03-10 18:00:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `budget_request_status`
--

CREATE TABLE IF NOT EXISTS `budget_request_status` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `budget_request_status`
--

INSERT INTO `budget_request_status` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'For Approval', '2016-03-10 18:00:33', NULL),
(2, 'Approved', '2016-03-10 18:00:33', NULL),
(3, 'Disapproved', '2016-03-10 18:00:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `description`) VALUES
(1, 'Health', '2016-03-10 18:12:23', NULL, NULL),
(2, 'Supplies', '2016-03-21 14:15:15', NULL, 'Test'),
(3, 'Nature', '2016-03-22 17:28:44', NULL, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

CREATE TABLE IF NOT EXISTS `funds` (
`id` int(10) unsigned NOT NULL,
  `amount` varchar(25) NOT NULL COMMENT 'total fund amount',
  `year` int(5) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `funds`
--

INSERT INTO `funds` (`id`, `amount`, `year`, `created_at`, `updated_at`) VALUES
(1, '2000', 2016, '2016-03-20 23:41:50', NULL),
(2, '10000', 2016, '2016-03-21 12:47:17', NULL),
(3, '3000000', 2016, '2016-03-21 12:57:48', NULL),
(4, '20000', 2016, '2016-03-21 13:42:56', NULL),
(5, '50000', 2016, '2016-03-22 16:52:44', NULL),
(6, '10000', 2016, '2016-03-22 17:36:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `funds_allocation`
--

CREATE TABLE IF NOT EXISTS `funds_allocation` (
`id` int(10) unsigned NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `funds_allocation`
--

INSERT INTO `funds_allocation` (`id`, `project_id`, `amount`, `created_at`, `updated_at`) VALUES
(12, 8, 10000, NULL, '2016-03-27 18:32:29');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 2),
('2016_03_03_131349_create_table_resource_person', 2),
('2016_03_25_060233_create_funds_allocation', 3);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE IF NOT EXISTS `partners` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_info`
--

CREATE TABLE IF NOT EXISTS `personal_info` (
`id` int(10) unsigned NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(25) NOT NULL,
  `contact_num` varchar(15) NOT NULL,
  `email` varchar(25) NOT NULL,
  `address` varchar(100) NOT NULL,
  `birth_date` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personal_info`
--

INSERT INTO `personal_info` (`id`, `first_name`, `middle_name`, `last_name`, `contact_num`, `email`, `address`, `birth_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test', 'teste', 'test', 'test', 'test', 'testset', '0000-00-00 00:00:00', '2016-02-11 22:22:32', '2016-03-20 15:34:24', '2016-03-20 15:34:24'),
(2, 'qwe', 'qwe', 'qwe', 'qwe', 'qwe', 'qwe', '0000-00-00 00:00:00', '2016-02-11 22:22:58', '2016-03-20 15:34:22', '2016-03-20 15:34:22'),
(3, 'Life', 'Life', 'Director', '098123412123', 'life@dlsu.com.ph', 'Taft', '0000-00-00 00:00:00', '2016-02-21 10:24:33', '2016-03-20 15:35:21', NULL),
(4, 'wevwev', 'wevwev', 'wevwev', 'wevwev', 'wevwev', 'wevwev', '0000-00-00 00:00:00', '2016-02-24 16:19:46', '2016-03-10 10:54:50', '2016-03-10 10:54:50'),
(5, 'qwert', 'qwer', 'wert', '12345', 'wer@nekuvbae.com', 'fwaevwea', '0000-00-00 00:00:00', '2016-02-24 16:51:24', '2016-03-20 15:34:14', '2016-03-20 15:34:14'),
(7, 'Joyce', NULL, 'Test', '', 'lkjl@masd.com', '', '0000-00-00 00:00:00', '2016-03-07 21:39:10', NULL, NULL),
(8, 'Jhom', NULL, 'Emoji', '0912384', 'teee@mad.com', 'El Paso St.', '0000-00-00 00:00:00', '2016-03-07 21:41:05', NULL, NULL),
(9, 'Jhom', NULL, 'Emoji', '0912384', 'teee@mad.com', 'El Paso St.', '0000-00-00 00:00:00', '2016-03-07 21:46:29', NULL, NULL),
(10, 'Test', NULL, 'Awts', '', 'yeah@smile.com', '', '0000-00-00 00:00:00', '2016-03-07 21:50:23', NULL, NULL),
(11, 'Hello', 'World', 'Me', '98247932742', 'jomrgo@gmail.com', '3o42ytvoujesrotewrb', '0000-00-00 00:00:00', '2016-03-10 18:51:38', '2016-03-20 15:34:18', '2016-03-20 15:34:18'),
(12, 'Hello', 'World', 'Me', '98247932742', 'jomrgo@gmail.com', '3o42ytvoujesrotewrb', '0000-00-00 00:00:00', '2016-03-10 18:51:38', '2016-03-20 15:34:20', '2016-03-20 15:34:20'),
(13, 'Mhoj', NULL, 'Jomimo', '9812937419', 'womju@gmail.com', 'El Paso St.', '0000-00-00 00:00:00', '2016-03-10 23:12:45', NULL, NULL),
(14, 'Jhom', NULL, 'Mhoji', '9872372', 'hello@gmail.com', 'El Paso St.', '0000-00-00 00:00:00', '2016-03-10 23:17:47', NULL, NULL),
(15, 'Test', NULL, 'test', '234342', 'test', 'test', '0000-00-00 00:00:00', '2016-03-11 00:00:24', NULL, NULL),
(16, 'Test', NULL, 'test', '1232123', 'test', 'test', '0000-00-00 00:00:00', '2016-03-11 00:04:17', NULL, NULL),
(17, 'test', NULL, 'test', '23123', 'test', 'test', '0000-00-00 00:00:00', '2016-03-11 00:04:35', NULL, NULL),
(18, 'ee', NULL, 'ere', '22434', 'erer', 'werwr', '0000-00-00 00:00:00', '2016-03-11 00:09:59', NULL, NULL),
(19, 'werwr', NULL, 'werwr', '234324', 'werwr', 'werewr', '0000-00-00 00:00:00', '2016-03-11 00:12:30', NULL, NULL),
(20, 'sadf', NULL, 'asdfdsaf', '124', 'sadfsda', 'safa', '0000-00-00 00:00:00', '2016-03-11 00:13:37', NULL, NULL),
(21, 'asdfas', NULL, 'fsadfasf', '34234', 'sadf', 'asfdadfa', '0000-00-00 00:00:00', '2016-03-11 00:16:23', NULL, NULL),
(22, 'sdfas', NULL, 'fsadf', '23424', 'asfsaf', 'sdf', '0000-00-00 00:00:00', '2016-03-11 00:18:13', NULL, NULL),
(23, 'werq', NULL, 'erwqerq', '', 'rwqer', '241', '0000-00-00 00:00:00', '2016-03-11 00:18:56', NULL, NULL),
(24, 'asdfaf', NULL, 'asdfsa', '23424', 'fasdfaf', 'safdasd', '0000-00-00 00:00:00', '2016-03-11 00:37:28', NULL, NULL),
(25, 'asdfsaf', NULL, 'sadfsadf', '214234', 'asdfasf', 'sdfsafd', '0000-00-00 00:00:00', '2016-03-11 00:38:27', NULL, NULL),
(26, 'sdfa', NULL, 'sadf', '23424', 'asdf', '234234', '0000-00-00 00:00:00', '2016-03-11 00:41:06', NULL, NULL),
(27, 'wwww', NULL, 'wwwww', '2323', 'www', 'ww', '0000-00-00 00:00:00', '2016-03-11 00:43:20', NULL, NULL),
(28, 'www', NULL, 'www', '23423', 'wwww', 'www', '0000-00-00 00:00:00', '2016-03-11 00:45:20', NULL, NULL),
(29, 'www', NULL, 'ww', '234', 'ww', 'ww', '0000-00-00 00:00:00', '2016-03-11 00:46:56', NULL, NULL),
(30, 'asdfsaf', NULL, 'sadfsaf', '12321', 'sadf', 'sadfa', '0000-00-00 00:00:00', '2016-03-11 00:49:16', NULL, NULL),
(31, 'sadf', NULL, 'sadf', '', 'sadf', '', '0000-00-00 00:00:00', '2016-03-11 00:50:44', NULL, NULL),
(32, 'asdfa', NULL, 'safd', '', 'asdf', '', '0000-00-00 00:00:00', '2016-03-11 00:52:32', NULL, NULL),
(33, 'www', NULL, 'www', '', 'www', '', '0000-00-00 00:00:00', '2016-03-11 00:53:32', NULL, NULL),
(34, 'ww', NULL, 'ww', '', 'wwww', '', '0000-00-00 00:00:00', '2016-03-11 00:54:07', NULL, NULL),
(35, 'ww', NULL, 'ww', '', 'ww', '', '0000-00-00 00:00:00', '2016-03-11 00:55:23', NULL, NULL),
(36, 'ww', NULL, 'ww', '', 'ww', '', '0000-00-00 00:00:00', '2016-03-11 00:55:55', NULL, NULL),
(37, 'Eliza', 'G', 'Dagoy', '123456789', 'ejdagoy@gmail.com', 'Makati', '0000-00-00 00:00:00', '2016-03-14 13:02:47', '2016-03-20 15:34:16', '2016-03-20 15:34:16'),
(38, 'Chester', NULL, 'Angeles', '54198716', 'joieffejoi', 'wevwev', '0000-00-00 00:00:00', '2016-03-14 13:10:39', NULL, NULL),
(39, 'Rexa', 'ga', 'anglesa', '15619857', 'uonow@gmail.com', 'advaevwcwc', '0000-00-00 00:00:00', '2016-03-14 13:32:00', '2016-03-14 05:32:43', '2016-03-14 05:32:43'),
(40, 'Eliza', NULL, 'Dagoy', '84981', 'ej@gmail.com', 'sevwev', '0000-00-00 00:00:00', '2016-03-14 13:38:35', NULL, NULL),
(41, 'Katas', NULL, 'TMJ', '09823409', 'lkjs@lksjadf.com', 'streeat lord', '0000-00-00 00:00:00', '2016-03-17 20:31:24', NULL, NULL),
(42, 'Eyayts', NULL, 'Awts', '98729342', 'Email?', 'Address', '0000-00-00 00:00:00', '2016-03-17 20:37:22', '2016-03-17 14:10:39', NULL),
(43, 'iouoiu', NULL, 'oiuoi', 'uoi', 'uio', 'uoiu', '0000-00-00 00:00:00', '2016-03-17 20:39:16', NULL, NULL),
(44, 'lk;lk;k;k', NULL, ';lk;lk;lkp', 'poipo', 'oipoi', 'ipoi', '0000-00-00 00:00:00', '2016-03-17 20:40:51', NULL, NULL),
(45, 'asdfaf', NULL, 'fdsf', 'sdfasf', 'sadfad', 'sadfs', '0000-00-00 00:00:00', '2016-03-17 21:40:17', NULL, NULL),
(46, 'DLSP', 'DLSP', 'Head', '902834123', 'dlsp@dlsu.com', 'Taft', '0000-00-00 00:00:00', '2016-03-20 23:39:51', NULL, NULL),
(47, 'Champion', 'Champ', 'User', '9384254325', 'champion@dlsu.com', 'Tafts', '0000-00-00 00:00:00', '2016-03-20 23:40:24', '2016-03-25 00:26:43', NULL),
(48, 'Executive', 'Exec', 'Commitee', '3128975213', 'executive@gmail.com', 'Taft', '0000-00-00 00:00:00', '2016-03-20 23:41:04', NULL, NULL),
(49, 'Financer', 'Fin', 'Employee', '21342134', 'finance@dlsu.com', 'Taft', '0000-00-00 00:00:00', '2016-03-20 23:41:39', '2016-03-21 04:48:50', NULL),
(50, 'Resource', NULL, 'Person', '9812123412', 'resource@gmail.com', 'Taft', '0000-00-00 00:00:00', '2016-03-20 23:43:08', NULL, NULL),
(51, 'Rainie', NULL, 'Pogi', '911111', 'rainiel@yahoo.com', 'Taft', '0000-00-00 00:00:00', '2016-03-21 12:54:45', NULL, NULL),
(52, 'Rainiel', NULL, 'Pogi', '86236', 'rainiel@yahoo.com', 'Taft', '0000-00-00 00:00:00', '2016-03-21 12:55:29', NULL, NULL),
(53, 'dlsp2', 'dlsp2', '', '123456789', 'dlsp2@gmail.com', 'dlsp', '0000-00-00 00:00:00', '2016-03-21 13:15:02', '2016-03-21 05:17:57', '2016-03-21 05:17:57'),
(54, 'champion2', 'champion2', 'champion2', '987654321', 'champion2@gmail.com', 'test', '0000-00-00 00:00:00', '2016-03-21 13:20:36', '2016-03-25 00:27:27', NULL),
(55, 'champion2ss', 'champion2ss', 'champion2ss', '98765432134', 'champion2@gmail.com', 'testss', '0000-00-00 00:00:00', '2016-03-21 13:20:36', '2016-03-25 00:27:09', NULL),
(56, 'champion3', 'champion3', 'champion3', '123456789', 'champion3@gmail.com', 'test\n=', '0000-00-00 00:00:00', '2016-03-21 13:21:39', '2016-03-27 16:13:24', NULL),
(57, 'cha', 'mp', 'ion', '09123456789', 'champion4@gmail.com', 'test', '0000-00-00 00:00:00', '2016-03-21 13:48:50', NULL, NULL),
(58, 'TestTest', NULL, 'TestTest', 'TestTest', 'TestTest', 'TestTest', '0000-00-00 00:00:00', '2016-03-22 13:51:42', '2016-03-22 05:52:27', NULL),
(59, 'Patricia Louise', NULL, 'Esteban', '9231523123', 'ple@gmail.com', 'Sta Rosa', '0000-00-00 00:00:00', '2016-03-22 16:50:58', NULL, NULL),
(60, 'c', 'c', 'c', '123456789', 'champion5@gmail.com', 'Makati', '0000-00-00 00:00:00', '2016-03-22 17:24:01', NULL, NULL),
(61, 'Gio', NULL, 'Gonzales', '123456789', 'gio@gmail.com', 'Pasay', '0000-00-00 00:00:00', '2016-03-22 17:33:44', NULL, NULL),
(62, 'Rex', NULL, 'Angeles', '987654321', 'rex@gmail.com', 'Laguna', '0000-00-00 00:00:00', '2016-03-22 17:34:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE IF NOT EXISTS `programs` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Regulatory Compliance', '2016-02-08 13:49:44', NULL),
(2, 'Green Building', '2016-02-08 13:49:44', NULL),
(3, 'Carbon Neutrality', '2016-02-08 13:49:44', NULL),
(4, 'Occupational Safety and Health', '2016-02-08 13:49:44', NULL),
(5, 'Disaster Risk Reduction Management-Emergency Prepa', '2016-02-08 13:49:44', NULL),
(6, 'Biodiversity', '2016-02-08 13:49:44', NULL),
(7, 'Water Resources Management', '2016-02-08 13:49:44', NULL),
(8, 'Green Procurement', '2016-02-08 13:49:44', NULL),
(9, 'Data Management', '2016-02-08 13:49:44', NULL),
(10, 'Environmental Education', '2016-02-08 13:49:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `objective` text NOT NULL,
  `total_budget` int(10) NOT NULL,
  `champion_id` int(10) unsigned NOT NULL,
  `program_id` int(10) unsigned NOT NULL,
  `proj_status_id` int(10) unsigned NOT NULL,
  `resource_person_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `partner_organization` varchar(50) DEFAULT NULL,
  `partner_community` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `start_date`, `end_date`, `objective`, `total_budget`, `champion_id`, `program_id`, `proj_status_id`, `resource_person_id`, `created_at`, `updated_at`, `partner_organization`, `partner_community`, `deleted_at`, `remarks`) VALUES
(2, 'Sample Project', '1970-01-01 00:00:00', '1970-01-01 00:00:00', 'Hello(#$;)Loooo', 1000000, 12, 3, 3, 30, '2016-03-20 23:48:37', '2016-03-21 05:35:43', 'sfasdfasf', 'sdfsadfa', NULL, NULL),
(4, 'Testing', '2015-02-12 00:00:00', '2016-02-21 00:00:00', 'T(#$;)E(#$;)S(#$;)T', 5000, 21, 1, 4, 30, '2016-03-21 14:02:41', '2016-03-21 06:03:12', 'Test', 'Test', NULL, NULL),
(5, 'Energy Saving', '2016-02-12 00:00:00', '2017-02-12 00:00:00', 'T(#$;)E(#$;)S(#$;)T', 100000, 21, 2, 2, 30, '2016-03-21 14:11:44', '2016-03-21 06:16:53', 'Test', 'Test', NULL, NULL),
(6, 'Test', '2015-02-12 00:00:00', '2016-02-12 00:00:00', 'T(#$;)E(#$;)S(#$;)T', 10000, 22, 2, 3, 31, '2016-03-22 17:26:41', '2016-03-22 09:30:06', 'Test', 'Test', NULL, NULL),
(7, 'Project Sample', '1970-01-01 00:00:00', '1970-01-01 00:00:00', 'aaaa', 501, 12, 1, 1, 32, '2016-03-25 07:35:30', '2016-03-26 00:05:17', 'Haloooww', 'Aguyy', NULL, NULL),
(8, 'Ongoing Project', '1970-01-01 00:00:00', '1970-01-01 00:00:00', 'Hi(#$;)Hello(#$;)Kunichiwa', 60560, 12, 2, 1, 28, '2016-03-26 06:49:24', '2016-03-27 16:12:09', 'lkjlkjlkjlkj', 'lkjljlkjlkj', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proj_activities`
--

CREATE TABLE IF NOT EXISTS `proj_activities` (
  `proj_id` int(10) unsigned NOT NULL,
  `activity_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proj_activities`
--

INSERT INTO `proj_activities` (`proj_id`, `activity_id`) VALUES
(7, 1),
(11, 2),
(12, 3),
(12, 4),
(24, 8),
(32, 9),
(24, 10),
(24, 11),
(35, 12),
(2, 13),
(5, 14),
(6, 15),
(7, 16),
(7, 17),
(7, 20),
(7, 21),
(7, 22);

-- --------------------------------------------------------

--
-- Table structure for table `proj_budget_request`
--

CREATE TABLE IF NOT EXISTS `proj_budget_request` (
  `proj_id` int(10) unsigned NOT NULL,
  `amount` int(10) NOT NULL,
  `reason` text NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
`id` int(10) unsigned NOT NULL,
  `remarks` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proj_budget_request`
--

INSERT INTO `proj_budget_request` (`proj_id`, `amount`, `reason`, `status_id`, `created_at`, `updated_at`, `id`, `remarks`) VALUES
(7, 1231312, 'asdasda', 2, '2016-03-10 18:10:55', '2016-03-10 10:11:24', 11, '23423'),
(14, 100, 'wala', 1, '2016-03-10 19:23:48', NULL, 12, NULL),
(0, 21351, 'TEst', 1, '2016-03-14 13:12:26', NULL, 13, NULL),
(24, 0, 'gdfgffd', 1, '2016-03-17 20:34:39', NULL, 14, NULL),
(5, 1000, 'Exceeded Project Budget', 1, '2016-03-21 14:19:50', NULL, 15, NULL),
(8, 5000, 'reradsd', 1, '2016-03-28 14:51:44', NULL, 16, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proj_item_categories`
--

CREATE TABLE IF NOT EXISTS `proj_item_categories` (
  `proj_id` int(10) unsigned NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `quantity` tinyint(5) unsigned NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
`id` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proj_item_categories`
--

INSERT INTO `proj_item_categories` (`proj_id`, `item_name`, `description`, `category_id`, `quantity`, `price`, `created_at`, `updated_at`, `id`) VALUES
(2, 'sadfaf', 'asdfsa', 1, 0, 0, '2016-03-20 19:42:55', NULL, 2),
(5, 'Pencil', 'Test', 2, 5, 20, '2016-03-21 14:15:34', NULL, 3),
(5, 'Cartolina', 'Test', 2, 5, 10, '2016-03-21 14:16:08', NULL, 4),
(5, 'Marker', 'Test', 2, 1, 20, '2016-03-21 14:16:42', NULL, 5),
(6, 'Seeds', 'Test', 3, 100, 3, '2016-03-22 17:29:01', NULL, 6),
(6, 'Shovel', 'Test', 3, 5, 10, '2016-03-22 17:29:20', NULL, 7),
(6, 'Rake', 'Test', 3, 5, 20, '2016-03-22 17:29:35', NULL, 8),
(7, 'werwr', 'j;;lkj', 1, 255, 2423, '2016-03-25 08:53:49', NULL, 9);

-- --------------------------------------------------------

--
-- Table structure for table `proj_status`
--

CREATE TABLE IF NOT EXISTS `proj_status` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proj_status`
--

INSERT INTO `proj_status` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'On-Going', '2016-02-08 13:50:01', NULL),
(2, 'For Approval', '2016-02-08 13:50:01', NULL),
(3, 'Completed', '2016-02-08 13:50:01', NULL),
(4, 'Disapproved', '2016-03-20 19:13:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resource_persons`
--

CREATE TABLE IF NOT EXISTS `resource_persons` (
`id` int(10) unsigned NOT NULL,
  `personal_info_id` int(10) unsigned NOT NULL,
  `school_id` int(10) unsigned NOT NULL,
  `profession` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `resource_persons`
--

INSERT INTO `resource_persons` (`id`, `personal_info_id`, `school_id`, `profession`, `created_at`, `updated_at`) VALUES
(28, 50, 14, 'Resourceful', NULL, NULL),
(30, 52, 13, 'Thesiser', NULL, NULL),
(31, 59, 9, 'Professor', NULL, NULL),
(32, 61, 4, 'Science', NULL, NULL),
(33, 62, 10, 'Math', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resource_person_tags`
--

CREATE TABLE IF NOT EXISTS `resource_person_tags` (
  `tag_id` int(10) unsigned NOT NULL,
  `personal_info_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(25) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'D.L.S.P Head', '2016-02-10 20:19:34', NULL),
(2, 'L.I.F.E. Director', '2016-02-10 20:19:34', NULL),
(3, 'Executive Commitee', '2016-02-10 20:19:34', NULL),
(4, 'Champion', '2016-02-10 20:19:34', NULL),
(5, 'Finance Employee', '2016-02-10 20:19:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE IF NOT EXISTS `schools` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'De La Salle Andres Soriano Memorial College', '2016-02-08 13:50:08', NULL),
(2, 'De La Salle Araneta University', '2016-02-08 13:50:08', NULL),
(3, 'De La Salle – College of Saint Benilde', '2016-02-08 13:50:08', NULL),
(4, 'De La Salle Health Sciences Institute', '2016-02-08 13:50:08', NULL),
(5, 'De La Salle John Bosco College', '2016-02-08 13:50:08', NULL),
(6, 'De La Salle Lipa', '2016-02-08 13:50:08', NULL),
(7, 'De La Salle Santiago Zobel School', '2016-02-08 13:50:08', NULL),
(8, 'De La Salle University – Dasmariñas', '2016-02-08 13:50:08', NULL),
(9, 'De La Salle University', '2016-02-08 13:50:08', NULL),
(10, 'Jaime Hilario Integrated School – La Salle', '2016-02-08 13:50:08', NULL),
(11, 'La Salle Academy', '2016-02-08 13:50:08', NULL),
(12, 'La Salle College Antipolo', '2016-02-08 13:50:08', NULL),
(13, 'La Salle Green Hills', '2016-02-08 13:50:08', NULL),
(14, 'La Salle University', '2016-02-08 13:50:08', NULL),
(15, 'St. Joseph School - La Salle', '2016-02-08 13:50:08', NULL),
(16, 'University of St. La Salle', '2016-02-08 13:50:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `school_funds`
--

CREATE TABLE IF NOT EXISTS `school_funds` (
`id` int(10) unsigned NOT NULL,
  `school_id` int(10) unsigned NOT NULL,
  `fund_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `reset_token` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `reset_token`, `created_at`, `updated_at`, `deleted_at`, `remember_token`) VALUES
(1, 'life', '$2y$10$/7VvO3K4gPoUf.hqgWsld.A3am5OEIB/rjPSFjacONGxL0qx2.aue', '', '2016-02-09 20:11:41', '2016-03-28 06:46:17', NULL, 'AwJY1YoGEBrLXgnxju6Os85sfhbdlhvdZCwmQfurpsoj4ApRaLgodV3yOTKU'),
(2, 'sample', '$2y$10$i/9DAbbFO1eq48JicGinNuuvt92HYzVQES1VBTkUjFmpzTbCNbRBC', '', '2016-02-11 22:22:32', '2016-03-20 15:34:24', '2016-03-20 15:34:24', NULL),
(3, 'qwe', '$2y$10$lqeLnuRkGq14RGRvHcuwtOQG/zU23Q0ZklaaZzZyw.SU4G0GaswTa', '', '2016-02-11 22:22:58', '2016-03-20 15:34:22', '2016-03-20 15:34:22', NULL),
(4, 'wqfev', '$2y$10$s3iWU1PixOGqUz89DapNj.hWcVZH2DnODETEFJKnhimT1lnMtv.M6', '', '2016-02-24 16:19:46', '2016-03-10 10:54:50', '2016-03-10 10:54:50', NULL),
(5, 'asdfghjkl', '$2y$10$hfs/beEsv1s97AbC3tOdRe2qEU9aYPHQlANSAZBo4SHC68KofcSBi', '', '2016-02-24 16:51:24', '2016-03-20 15:34:14', '2016-03-20 15:34:14', NULL),
(6, 'nats', '$2y$10$yCVQ2A3a0Isgyjiruw.cUezAdad7dDsJZ3RwSTaYEdYhKc9caoKPO', '', '2016-03-10 18:51:38', '2016-03-20 15:34:18', '2016-03-20 15:34:18', NULL),
(7, 'nats', '$2y$10$8GrPYlEM8IJfNMWOBzxnNep1iSCQ4pkTEdZHSbH/XInKL9F7uajma', '', '2016-03-10 18:51:38', '2016-03-20 15:34:20', '2016-03-20 15:34:20', NULL),
(8, 'ej16dags', '$2y$10$h5IwEsLNA4i13OhJ9mEpueU5ttbFV1y0c./ORSPZ7yFmpzD9dhnVO', '', '2016-03-14 13:02:47', '2016-03-20 15:34:16', '2016-03-20 15:34:16', NULL),
(9, 'qcqwvq', '$2y$10$UD33uRmBwJmP/Tx3ctKxTuci4Nt4VRSC0.ez5/kdL6g5CrCzvWjLu', '', '2016-03-14 13:32:00', '2016-03-14 05:32:43', '2016-03-14 05:32:43', NULL),
(11, 'dlsp', '$2y$10$SM9eblfAxEfQ0wTubmfXwuspJ/D/eKNLAHHqyQsCKVY8gSB1Fec02', '', '2016-03-20 23:39:51', '2016-03-28 04:55:13', NULL, 'dAQ1CcduzQAvgiYUEZabzbJYE6FAPpte32zC2eCrbD6kdapn1cIoo4QKA3Na'),
(12, 'champion', '$2y$10$7kwMqKLsGiIbSRoTAdD09eepXTn22S5tEjQI0zAlBWBJAGduvCkia', '', '2016-03-20 23:40:24', '2016-03-28 06:53:03', NULL, 'pGr2ZMMTMLfxdXWa4SZMsbAkGbgrghpD4lxwe9od7Q5zR26plw3CBBemigmH'),
(13, 'executive', '$2y$10$LCCGyyJGM7/iOXHj9s/6nOacIYulmMCPvSRDlTieSXBXmdw/38hIa', '', '2016-03-20 23:41:04', '2016-03-28 06:38:22', NULL, '0L7jK2CQ3S4ZG7d9szANcjlICJ9KNLFiC1AYwQtacjGoqpJehhVPfR8o34Ex'),
(14, 'finance', '$2y$10$5f8MCpNEhdfmsJhu.zKgOeU5Py.HmNIG03EBayIIn/UZxtYjBTf/a', '', '2016-03-20 23:41:39', '2016-03-28 04:50:32', NULL, 'HlUjOa7H1IvUQ0inhCDpCdXwkA79PIViNRhsjJ3xfqcAYKtBigfEXlyYHGK2'),
(17, 'dlsp2', '$2y$10$fPM//nOHTpC03FSRy5EN.uiqM6nVq/Lk41tqxJWdfLfPOrO8QqU3S', '', '2016-03-21 13:15:02', '2016-03-21 05:17:57', '2016-03-21 05:17:57', NULL),
(18, 'champion23', '$2y$10$Rvrm850DgofAkGtRHEd53Oc2BJzBTzT8Likyt.al1kO1YCDFcLan.', '', '2016-03-21 13:20:36', '2016-03-25 00:27:27', NULL, '3gtETV5TlHpMndx2X6hx6hs8LAtHKxrUCrX7gEygnjJwvo187MFyg2kDs4K3'),
(19, 'champion2', '$2y$10$nWjYAcq8rTsMZMejn9bcrOD20QQVuR8slb3PZqkdcQAHzU9XteUS2', '', '2016-03-21 13:20:36', '2016-03-25 00:27:09', NULL, NULL),
(20, 'champion3', '$2y$10$Ra8fe4mX7TeOdZev/2Ip5.wWXg6LebEXgVS72yiT3BtygPw3L4WNy', '', '2016-03-21 13:21:39', '2016-03-27 16:13:24', NULL, NULL),
(21, 'champion4', '$2y$10$hUWRncy2Nwv6uBrns3HQ3eK2XP0j50yMvJ6Uf9x4E4DilKO2JEtZO', '', '2016-03-21 13:48:50', '2016-03-28 06:36:27', NULL, 't607FDyeb5bwKD9oHQwlHU968sF6btJNxiAKHRaf1s4rqKzxlR22T47048an'),
(22, 'champion5', '$2y$10$iTGQO84xTgydDBNvXEdDZOZryHdW6xdxqLDu//jWct9lDM87xN9ay', '', '2016-03-22 17:24:01', '2016-03-22 09:35:45', NULL, 'yBoycBUsnYpD11DbPF8qjJWel9JKnI0dphq9ClQU6Scq7deZPpDTZsSD8CrA');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `user_id` int(10) unsigned NOT NULL,
  `personal_info_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `personal_info_id`) VALUES
(1, 3),
(2, 1),
(3, 2),
(4, 4),
(5, 5),
(6, 11),
(7, 12),
(8, 37),
(9, 39),
(11, 46),
(12, 47),
(13, 48),
(14, 49),
(17, 53),
(18, 54),
(19, 55),
(20, 56),
(21, 57),
(22, 60);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 2),
(2, 4),
(3, 5),
(4, 4),
(5, 4),
(6, 3),
(7, 3),
(8, 4),
(9, 4),
(11, 1),
(12, 4),
(13, 3),
(14, 5),
(17, 1),
(18, 4),
(19, 4),
(20, 4),
(21, 4),
(22, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_status`
--
ALTER TABLE `activity_status`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_request_status`
--
ALTER TABLE `budget_request_status`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funds_allocation`
--
ALTER TABLE `funds_allocation`
 ADD PRIMARY KEY (`id`), ADD KEY `funds_allocation_project_id_foreign` (`project_id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
 ADD KEY `password_resets_email_index` (`email`), ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `personal_info`
--
ALTER TABLE `personal_info`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
 ADD PRIMARY KEY (`id`), ADD KEY `projects_champion_id_foreign` (`champion_id`), ADD KEY `projects_program_id_foreign` (`program_id`), ADD KEY `projects_proj_status_id_foreign` (`proj_status_id`), ADD KEY `projects_resource_person_id_foreign` (`resource_person_id`);

--
-- Indexes for table `proj_budget_request`
--
ALTER TABLE `proj_budget_request`
 ADD PRIMARY KEY (`id`), ADD KEY `proj_budget_request_status_id_foreign` (`status_id`);

--
-- Indexes for table `proj_item_categories`
--
ALTER TABLE `proj_item_categories`
 ADD PRIMARY KEY (`id`), ADD KEY `proj_item_categories_category_id_foreign` (`category_id`), ADD KEY `proj_item_categories_proj_id_foreign` (`proj_id`);

--
-- Indexes for table `proj_status`
--
ALTER TABLE `proj_status`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resource_persons`
--
ALTER TABLE `resource_persons`
 ADD PRIMARY KEY (`id`), ADD KEY `resource_persons_personal_info_id_foreign` (`personal_info_id`), ADD KEY `resource_persons_school_id_foreign` (`school_id`);

--
-- Indexes for table `resource_person_tags`
--
ALTER TABLE `resource_person_tags`
 ADD PRIMARY KEY (`tag_id`,`personal_info_id`), ADD KEY `resource_person_tags_personal_info_id_foreign` (`personal_info_id`), ADD KEY `resource_person_tags_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_funds`
--
ALTER TABLE `school_funds`
 ADD PRIMARY KEY (`id`), ADD KEY `school_funds_school_id_foreign` (`school_id`), ADD KEY `school_funds_fund_id_foreign` (`fund_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
 ADD PRIMARY KEY (`user_id`,`personal_info_id`), ADD KEY `user_info_user_id_foreign` (`user_id`), ADD KEY `user_info_personal_info_id_foreign` (`personal_info_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
 ADD PRIMARY KEY (`user_id`,`role_id`), ADD KEY `user_roles_user_id_foreign` (`user_id`), ADD KEY `user_roles_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `activity_status`
--
ALTER TABLE `activity_status`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `budget_request_status`
--
ALTER TABLE `budget_request_status`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `funds_allocation`
--
ALTER TABLE `funds_allocation`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `personal_info`
--
ALTER TABLE `personal_info`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `proj_budget_request`
--
ALTER TABLE `proj_budget_request`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `proj_item_categories`
--
ALTER TABLE `proj_item_categories`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `proj_status`
--
ALTER TABLE `proj_status`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `resource_persons`
--
ALTER TABLE `resource_persons`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `school_funds`
--
ALTER TABLE `school_funds`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `funds_allocation`
--
ALTER TABLE `funds_allocation`
ADD CONSTRAINT `funds_allocation_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
ADD CONSTRAINT `projects_champion_id_foreign` FOREIGN KEY (`champion_id`) REFERENCES `users` (`id`),
ADD CONSTRAINT `projects_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`),
ADD CONSTRAINT `projects_proj_status_id_foreign` FOREIGN KEY (`proj_status_id`) REFERENCES `proj_status` (`id`);

--
-- Constraints for table `proj_budget_request`
--
ALTER TABLE `proj_budget_request`
ADD CONSTRAINT `proj_budget_request_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `proj_status` (`id`);

--
-- Constraints for table `proj_item_categories`
--
ALTER TABLE `proj_item_categories`
ADD CONSTRAINT `proj_item_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
ADD CONSTRAINT `proj_item_categories_proj_id_foreign` FOREIGN KEY (`proj_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `resource_persons`
--
ALTER TABLE `resource_persons`
ADD CONSTRAINT `resource_persons_personal_info_id_foreign` FOREIGN KEY (`personal_info_id`) REFERENCES `personal_info` (`id`),
ADD CONSTRAINT `resource_persons_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `resource_person_tags`
--
ALTER TABLE `resource_person_tags`
ADD CONSTRAINT `resource_person_tags_personal_info_id_foreign` FOREIGN KEY (`personal_info_id`) REFERENCES `personal_info` (`id`),
ADD CONSTRAINT `resource_person_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

--
-- Constraints for table `school_funds`
--
ALTER TABLE `school_funds`
ADD CONSTRAINT `school_funds_fund_id_foreign` FOREIGN KEY (`fund_id`) REFERENCES `funds` (`id`),
ADD CONSTRAINT `school_funds_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `user_info`
--
ALTER TABLE `user_info`
ADD CONSTRAINT `user_info_personal_info_id_foreign` FOREIGN KEY (`personal_info_id`) REFERENCES `personal_info` (`id`),
ADD CONSTRAINT `user_info_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
