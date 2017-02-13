-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 12, 2017 at 03:10 PM
-- Server version: 5.5.52-cll-lve
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `frostman_stripe`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE IF NOT EXISTS `app_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `name`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, '', 'notification_email', 'admin@envisafeconsulting.com', '2016-12-22 05:20:35', '0000-00-00 00:00:00'),
(2, '', 'stripe_api_mode', 'live', '2016-12-22 05:20:18', '0000-00-00 00:00:00'),
(3, '', 'live_stripe_public_key', 'pk_live_PlYbBrOnmgrfW8hIegA59GUM', '2016-12-22 05:20:03', '0000-00-00 00:00:00'),
(4, '', 'live_stripe_secret_key', 'sk_live_XjDxcdJJHmPeu0yEwyyD53an', '2016-12-22 05:20:12', '0000-00-00 00:00:00'),
(5, '', 'test_stripe_public_key', 'pk_test_sVqeyfXfqoAc0qKNZaGLNrtu', '2016-12-01 04:04:58', '0000-00-00 00:00:00'),
(6, '', 'test_stripe_secret_key', 'sk_test_lPMYbarX8N4UoX7I35j9aXOI', '2016-12-01 04:04:58', '0000-00-00 00:00:00');

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
('2014_10_12_100000_create_password_resets_table', 1),
('2016_11_03_105057_add_role_to_users', 2),
('2016_11_04_111234_create_user_accounts_table', 3),
('2016_11_04_131145_add_account_holder_name_to_users_accounts', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE IF NOT EXISTS `payment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_account_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `currency` varchar(100) NOT NULL,
  `payment_txn_id` varchar(255) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`id`, `user_account_id`, `amount`, `currency`, `payment_txn_id`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 18, 4000, 'USD', 'py_19W8MlKA2EjQ7BLLP17lJ63y', 'pending', '2016-12-29 22:11:03', '2016-12-29 22:11:03'),
(2, 18, 196000, 'USD', 'py_19W8U2KA2EjQ7BLLeEIXDD9A', 'pending', '2016-12-29 22:18:34', '2016-12-29 22:18:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `role` enum('admin','customer') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'customer',
  `stripe_customer` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `password1`, `remember_token`, `created_at`, `updated_at`, `role`, `stripe_customer`) VALUES
(1, 'admin', 'admin@envisafeconsulting.com', '$2y$10$td3XP5AVkqYzsRrILNde3eJ3QsF2g9Ibnhx0zJF7UvXM4ZGeNqCai', '', 'Rj8GpURuaMabxPyp7BDfMfkurv06mUjVISwvmCuvEKzeChY9kxv3KCYwGcpH', '0000-00-00 00:00:00', '2016-12-23 02:38:43', 'admin', ''),
(14, 'dinesh', 'dinesh@contriverz.com', '$2y$10$1JJjTPjK9CMcDXGujAfBv.HvuFhrui9cR.7UHd8HkZNl7W5Nh2.d6', '@echoTango', NULL, '2016-12-22 09:28:33', '2016-12-22 09:28:33', 'customer', 'cus_9mz68SmWkpdUkR'),
(15, 'Edward  Peters', 'ewpeter@outlook.com', '$2y$10$wKHHgSZe5RZ36I4QcIUBLOqhT9rh1cu3iSgn0o4MXiBPtnS.ljWV.', 'ewp3t3r999', NULL, '2016-12-23 02:09:46', '2016-12-23 02:09:46', 'customer', 'cus_9nFFuDA5RnkZGC');

-- --------------------------------------------------------

--
-- Table structure for table `users_accounts`
--

CREATE TABLE IF NOT EXISTS `users_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `routing_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_holder_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_holder_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `token` text COLLATE utf8_unicode_ci NOT NULL,
  `stripe_customer_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_bank_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `verification_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'It is account verification status',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `users_accounts`
--

INSERT INTO `users_accounts` (`id`, `user_id`, `country`, `currency`, `routing_number`, `account_number`, `account_holder_name`, `account_holder_type`, `token`, `stripe_customer_id`, `stripe_bank_id`, `verification_status`, `created_at`, `updated_at`) VALUES
(18, 15, 'US', 'USD', '061000104', '1000179088702', 'Edward Wayne Peters', 'individual', 'btok_9nFVotVTg6huTq', 'cus_9nFFuDA5RnkZGC', 'ba_19Tf0CKA2EjQ7BLLa3S4mwVm', 'verified', '2016-12-23 02:25:40', '2016-12-29 08:43:19');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
