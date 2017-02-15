-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 15, 2017 at 07:04 PM
-- Server version: 5.7.11
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `envisafe_stripe`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE IF NOT EXISTS `app_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `name`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, '', 'notification_email', 'admin@envisafeconsulting.com', '2016-12-22 05:20:35', '0000-00-00 00:00:00'),
(2, '', 'stripe_api_mode', 'test', '2017-02-14 16:04:35', '0000-00-00 00:00:00'),
(3, '', 'live_stripe_public_key', 'pk_live_PlYbBrOnmgrfW8hIegA59GUM', '2017-02-14 15:41:45', '0000-00-00 00:00:00'),
(4, '', 'live_stripe_secret_key', 'sk_live_XjDxcdJJHmPeu0yEwyyD53an', '2017-02-14 15:41:45', '0000-00-00 00:00:00'),
(5, '', 'test_stripe_public_key', 'pk_test_KNSZcZYqOyKCsgGjWqcr0nh2', '2017-02-15 08:33:41', '0000-00-00 00:00:00'),
(6, '', 'test_stripe_secret_key', 'sk_test_25boKbA8WtSX95MvcfSazKqF', '2017-02-15 08:33:41', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(10) unsigned NOT NULL,
  `cardNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expiry` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `cardNumber`, `expiry`, `brand`, `country`, `created_at`, `updated_at`, `token`, `user_id`) VALUES
(20, '4242', '2019/12', 'Visa', 'US', '2017-02-14 13:18:03', '2017-02-14 13:18:03', 'cus_A7MnPXH6Y1MVRo', 18),
(22, '4242', '2019/12', 'Visa', 'US', '2017-02-15 07:32:02', '2017-02-15 07:32:02', 'cus_A7eR3EKPUMImB1', 15),
(23, '8210', '2019/12', 'MasterCard', 'JP', '2017-02-15 12:06:05', '2017-02-15 12:06:05', 'cus_A7irLdAqUyZ5cL', 18);

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
('2016_11_04_131145_add_account_holder_name_to_users_accounts', 4),
('2017_02_13_132002_create_cards_table', 5),
('2017_02_14_111707_add_token_to_cards', 5),
('2017_02_14_121436_add_user_id_to_cards', 6),
('2017_02_14_152813_add_type_to_payment_history', 7),
('2017_02_15_130418_add_user_id_to_history_payment', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE IF NOT EXISTS `payment_history` (
  `id` int(11) NOT NULL,
  `user_account_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `currency` varchar(100) NOT NULL,
  `payment_txn_id` varchar(255) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`id`, `user_account_id`, `amount`, `currency`, `payment_txn_id`, `payment_status`, `created_at`, `updated_at`, `type`, `user_id`) VALUES
(1, 18, 4000, 'USD', 'py_19W8MlKA2EjQ7BLLP17lJ63y', 'pending', '2017-02-15 13:11:49', '2016-12-29 22:11:03', '', 15),
(2, 18, 196000, 'USD', 'py_19W8U2KA2EjQ7BLLeEIXDD9A', 'pending', '2017-02-15 13:12:03', '2016-12-29 22:18:34', 'account', 15),
(4, 20, 958959, 'USD', 'ch_19n8G5KKqhBnH69BzPE2DWtI', 'succeeded', '2017-02-15 13:58:52', '2017-02-14 13:30:26', 'card', 18),
(5, 21, 212, 'USD', 'ch_19n8UMKA2EjQ7BLLLIHIgcji', 'succeeded', '2017-02-15 13:11:29', '2017-02-14 13:45:11', 'card', 18),
(6, 22, 122, 'USD', 'ch_19nRwAKKqhBnH69B1I4JonrX', 'succeeded', '2017-02-15 13:11:13', '2017-02-15 10:31:11', 'card', 15),
(7, 20, 231, 'USD', 'ch_19nSXiKKqhBnH69BcvLKe5Uu', 'succeeded', '2017-02-15 11:10:00', '2017-02-15 11:10:00', 'card', 18),
(8, 20, 1213130, 'USD', 'ch_19nTDJKKqhBnH69BwEDxGKKj', 'succeeded', '2017-02-15 11:52:59', '2017-02-15 11:52:59', 'card', 18),
(9, 23, 3232, 'USD', 'ch_19nTQCKKqhBnH69Bnlkq289E', 'succeeded', '2017-02-15 12:06:17', '2017-02-15 12:06:17', 'card', 18);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `role` enum('admin','customer') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'customer',
  `stripe_customer` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `password1`, `remember_token`, `created_at`, `updated_at`, `role`, `stripe_customer`) VALUES
(1, 'admin', 'admin@envisafeconsulting.com', '$2y$10$wKHHgSZe5RZ36I4QcIUBLOqhT9rh1cu3iSgn0o4MXiBPtnS.ljWV.', '', 'NNsvPlCpJKIhORQh8R3hiVpXW7zDNrJk8fEesWH4unbCAqy9F1GVhxdrvFHm', '0000-00-00 00:00:00', '2017-02-14 10:03:33', 'admin', ''),
(14, 'dinesh', 'dinesh@contriverz.com', '$2y$10$1JJjTPjK9CMcDXGujAfBv.HvuFhrui9cR.7UHd8HkZNl7W5Nh2.d6', '@echoTango', NULL, '2016-12-22 09:28:33', '2016-12-22 09:28:33', 'customer', 'cus_9mz68SmWkpdUkR'),
(15, 'Edward  Peters', 'ewpeter@outlook.com', '$2y$10$wKHHgSZe5RZ36I4QcIUBLOqhT9rh1cu3iSgn0o4MXiBPtnS.ljWV.', 'ewp3t3r999', 'ai7o7LQmj4jvXO0Fnty1Hs1vWixrTkMz2QWpujHDB7J4gIaQnNLw7mkEF4Ce', '2016-12-23 02:09:46', '2017-02-15 09:38:11', 'customer', 'cus_9nFFuDA5RnkZGC'),
(18, 'test3', 'ag12q@vmani.com', '$2y$10$QEWZ6YkgB6/txypRiPSLdud0Y.3hhNzAlJVP/zM7wrs8pNlMAJRGq', '123456', 'mpJ8V4hq5jgJIqc0m3QruVfmCDThtqxPvshT4kzoHUCzjZfAdnimZFHzwTiE', '2017-02-14 13:17:34', '2017-02-14 13:54:18', 'customer', 'cus_A7Mn0gHeoJE0Nw');

-- --------------------------------------------------------

--
-- Table structure for table `users_accounts`
--

CREATE TABLE IF NOT EXISTS `users_accounts` (
  `id` int(10) unsigned NOT NULL,
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
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_accounts`
--

INSERT INTO `users_accounts` (`id`, `user_id`, `country`, `currency`, `routing_number`, `account_number`, `account_holder_name`, `account_holder_type`, `token`, `stripe_customer_id`, `stripe_bank_id`, `verification_status`, `created_at`, `updated_at`) VALUES
(18, 15, 'US', 'USD', '061000104', '1000179088702', 'Edward Wayne Peters', 'individual', 'btok_9nFVotVTg6huTq', 'cus_9nFFuDA5RnkZGC', 'ba_19Tf0CKA2EjQ7BLLa3S4mwVm', 'verified', '2016-12-23 02:25:40', '2016-12-29 08:43:19'),
(19, 18, 'US', 'USD', '110000000', '000123456789', 'fdsafsda', 'individual', 'btok_A7gVyxFRszceH2', 'cus_A7Mn0gHeoJE0Nw', 'ba_19nR8DKKqhBnH69B3YuDCSbz', 'pending', '2017-02-15 09:39:37', '2017-02-15 09:39:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_accounts`
--
ALTER TABLE `users_accounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `users_accounts`
--
ALTER TABLE `users_accounts`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
