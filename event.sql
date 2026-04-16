-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2025 at 11:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event`
--

-- --------------------------------------------------------

--
-- Table structure for table `detects`
--

CREATE TABLE `detects` (
  `id_detect` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `operating_system` enum('android','ios','other','windows') NOT NULL,
  `device_type` enum('phone','tablet','computer') NOT NULL,
  `http_user_agent` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detects`
--

INSERT INTO `detects` (`id_detect`, `user_id`, `ip_address`, `operating_system`, `device_type`, `http_user_agent`, `date_time`) VALUES
(32, 2, '0', '', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 04:40:49'),
(33, 2, '0', '', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 04:42:55'),
(34, 2, '0', 'other', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 04:43:30'),
(35, 2, '0', '', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 04:44:35'),
(36, 2, '0', '', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 04:47:50'),
(37, 2, '0', '', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 04:48:29'),
(38, 2, '0', '', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 04:48:52'),
(39, 2, '0', 'other', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 04:49:50'),
(40, 2, '0', '', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 04:50:13'),
(41, 2, '0', '', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 04:52:03'),
(42, 2, '0', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 04:53:18'),
(43, 3, '0', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 05:49:05'),
(44, 2, '0', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 05:54:05'),
(45, 2, '0', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 05:55:10'),
(46, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 06:53:45'),
(47, 3, '77.46.253.130', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 06:54:10'),
(48, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-03-31 06:55:02'),
(49, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-02 07:58:03'),
(50, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-03 09:46:53'),
(51, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-03 10:00:58'),
(52, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-04 16:05:17'),
(53, 2, '127.0.0.1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 08:21:25'),
(54, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 14:12:47'),
(55, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 14:21:26'),
(56, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 14:22:37'),
(57, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 14:24:00'),
(58, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 14:30:59'),
(59, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-05 14:56:01'),
(60, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-06 09:27:30'),
(61, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-06 12:42:54'),
(62, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-07 15:42:38'),
(63, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-04-07 22:06:41'),
(64, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-08 09:54:18'),
(65, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-09 11:37:38'),
(66, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-09 12:34:44'),
(67, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-09 14:33:23'),
(68, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-10 13:54:14'),
(69, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-10 14:16:22'),
(70, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-10 20:11:06'),
(71, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-11 18:27:19'),
(72, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-11 20:06:51'),
(73, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-13 04:11:29'),
(74, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-14 15:28:58'),
(75, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-15 01:22:41'),
(76, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-15 13:19:33'),
(77, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-15 15:25:05'),
(78, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-15 15:45:49'),
(79, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-15 18:05:25'),
(80, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-15 19:06:48'),
(81, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-15 22:37:40'),
(82, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-16 14:36:50'),
(83, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-16 23:11:31'),
(84, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-17 17:55:24'),
(85, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-18 18:31:55'),
(86, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-18 22:08:47'),
(87, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 04:07:19'),
(88, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 04:09:02'),
(89, 5, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 04:10:57'),
(90, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-19 04:17:01'),
(91, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-21 01:01:35'),
(92, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-21 02:04:30'),
(93, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-21 17:26:09'),
(94, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-21 21:34:16'),
(95, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-21 21:40:39'),
(96, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-22 13:49:32'),
(97, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-22 17:47:27'),
(98, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-22 23:01:10'),
(99, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 00:14:40'),
(100, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 00:31:53'),
(101, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 02:01:45'),
(102, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 02:07:53'),
(103, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 13:52:38'),
(104, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 16:37:15'),
(105, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 18:05:34'),
(106, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 18:05:58'),
(107, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-23 22:12:19'),
(108, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 02:15:38'),
(109, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 02:16:44'),
(110, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 03:04:32'),
(111, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 13:40:48'),
(112, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 15:36:06'),
(113, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 15:54:27'),
(114, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 15:55:48'),
(115, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 15:58:32'),
(116, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 16:49:52'),
(117, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 17:32:36'),
(118, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 17:32:56'),
(119, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 18:37:41'),
(120, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 18:43:26'),
(121, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 18:47:10'),
(122, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 18:50:52'),
(123, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 18:51:07'),
(124, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-24 22:40:37'),
(125, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 00:13:46'),
(127, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 00:41:53'),
(128, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 00:46:28'),
(129, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 03:11:19'),
(130, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 14:00:20'),
(131, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 16:14:17'),
(132, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 16:17:21'),
(133, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 16:28:12'),
(134, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 16:31:59'),
(135, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 16:32:05'),
(136, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 16:32:25'),
(137, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 16:32:48'),
(138, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 16:33:16'),
(139, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 21:17:17'),
(140, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-25 21:17:31'),
(141, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 01:19:23'),
(142, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 01:23:47'),
(143, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 01:27:10'),
(144, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 01:44:25'),
(145, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 01:51:50'),
(146, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 02:30:03'),
(147, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 02:31:05'),
(148, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 02:32:34'),
(149, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 02:35:44'),
(150, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 02:39:42'),
(151, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 02:40:46'),
(152, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 03:19:57'),
(153, 5, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 03:22:19'),
(154, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 03:22:25'),
(155, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 15:47:17'),
(156, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 16:02:44'),
(157, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-26 21:18:42'),
(158, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-27 17:46:50'),
(159, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-27 17:50:08'),
(160, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-28 17:26:15'),
(161, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-29 04:53:45'),
(162, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-29 17:01:16'),
(163, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-29 17:43:32'),
(164, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-29 17:43:38'),
(165, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-29 17:43:57'),
(166, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-30 01:13:10'),
(167, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-30 03:01:16'),
(168, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-30 04:01:43'),
(169, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-30 04:22:22'),
(170, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-30 04:34:32'),
(171, 5, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-30 05:32:08'),
(172, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-30 05:55:03'),
(173, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-04-30 05:55:37'),
(174, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-01 00:47:24'),
(175, 5, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-01 00:48:29'),
(176, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-01 03:09:25'),
(177, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-01 03:09:32'),
(178, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-01 03:35:19'),
(179, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-01 03:35:45'),
(180, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-02 19:12:29'),
(181, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-04 23:10:55'),
(182, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-04 23:11:31'),
(183, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-05 14:16:44'),
(184, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 12:42:11'),
(185, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 12:43:44'),
(186, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 12:44:44'),
(187, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 12:46:17'),
(188, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 12:46:44'),
(189, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 13:24:11'),
(190, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-05-06 15:19:35'),
(191, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-14 17:35:54'),
(192, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-17 11:24:30'),
(193, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-17 11:26:40'),
(194, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-18 17:39:49'),
(195, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 04:08:27'),
(196, 2, '127.0.0.1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-22 16:53:59'),
(197, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-22 22:08:07'),
(198, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-06-11 23:39:30'),
(199, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-07-01 17:24:21'),
(200, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-07-01 17:28:01'),
(201, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-07-01 17:29:12'),
(202, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-07-01 17:29:46'),
(203, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-07-01 17:30:06'),
(204, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-07-01 17:30:19'),
(205, 2, '127.0.0.1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-11 00:32:31'),
(206, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-12 18:03:11'),
(207, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-12 18:48:39'),
(208, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-12 19:57:45'),
(209, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-13 02:10:13'),
(210, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-14 15:37:46'),
(211, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-15 15:34:02'),
(212, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-15 15:34:32'),
(213, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-15 15:35:47'),
(214, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-15 15:36:31'),
(215, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-15 15:37:13'),
(216, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-15 15:37:21'),
(217, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-15 15:38:00'),
(218, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-15 15:39:38'),
(219, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-15 18:58:15'),
(220, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-16 03:32:26'),
(221, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-18 06:17:49'),
(222, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-19 21:48:29'),
(223, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-23 02:10:09'),
(224, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-23 03:45:33'),
(225, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-23 04:10:30'),
(226, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-23 04:18:56'),
(227, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-23 04:19:26'),
(228, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-23 14:19:28'),
(229, 7, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-24 02:41:56'),
(230, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-24 16:09:43'),
(231, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-24 21:40:58'),
(232, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-24 21:41:26'),
(233, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-24 21:42:43'),
(234, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-24 21:57:54'),
(235, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-27 10:25:09'),
(236, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-29 16:14:53'),
(237, 7, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-29 16:22:04'),
(238, 3, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-29 21:07:07'),
(239, 2, '192.168.1.3', 'other', 'computer', 'okhttp/4.12.0', '2025-08-29 21:24:37'),
(240, 2, '192.168.1.3', 'other', 'computer', 'okhttp/4.12.0', '2025-08-29 22:28:31'),
(241, 2, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-29 22:30:15'),
(242, 2, '192.168.1.3', 'other', 'computer', 'okhttp/4.12.0', '2025-08-29 22:38:55'),
(243, 2, '192.168.1.3', 'other', 'computer', 'okhttp/4.12.0', '2025-08-29 22:48:10'),
(244, 2, '192.168.1.3', 'other', 'computer', 'okhttp/4.12.0', '2025-08-31 21:21:38'),
(245, 7, '::1', 'windows', 'computer', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-31 22:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('active','blocked','archived') NOT NULL DEFAULT 'active',
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `title`, `description`, `event_date`, `user_id`, `status`, `location`) VALUES
(3, '1', 'ff', '2024-12-18 22:40:00', 2, 'archived', NULL),
(4, 'event1213', 'rodjendanska proslava 99. rodjendana bla bla bla 12312312312 obucite se pristojno, bez poklona!!', '2025-11-01 08:09:00', 2, 'active', 'Subotica'),
(6, '33', '333333fdfsafdsafsad3333', '2025-10-14 10:03:00', 2, 'active', 'ffffff'),
(7, '4', 'gfdgd', '2025-09-20 10:03:00', 2, 'active', 'gfg'),
(8, '5', 'fdfs342422324234', '2025-04-12 11:43:00', 2, 'archived', 'f'),
(19, '6', '', '2025-09-15 18:14:00', 2, 'blocked', ''),
(20, '111111111111111111111111111111', 'fdsaf', '2025-05-02 19:38:00', 2, 'archived', ''),
(29, 'blokiraj', 'faffdsafsfasfsa', '2025-05-31 01:19:00', 2, 'archived', 'faffafa'),
(33, '6666', 'gfdsg', '2025-05-07 19:15:00', 2, 'archived', 'gdsfg'),
(34, 'MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM', 'MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM', '2025-08-09 19:16:00', 2, 'archived', 'MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM'),
(35, 'ispit', 'opis', '2025-10-04 20:28:00', 7, 'archived', 'Marka Oreškovića 16 Subotica'),
(36, 'dogadjaj', 'opis', '2025-09-05 19:28:00', 7, 'archived', 'Marka Oreškovića 16 Subotica'),
(37, 'naziv', 'opis', '2025-09-04 19:29:00', 7, 'archived', 'Marka Oreškovića 16 Subotica'),
(38, 'naziv', 'opis', '2025-09-06 19:37:00', 7, 'archived', 'Marka Oreškovića 16 Subotica'),
(39, 'naziv', 'opis', '2025-09-04 19:39:00', 7, 'archived', 'Marka Oreškovića 16 Subotica'),
(40, 'naziv', 'opis', '2025-09-05 19:40:00', 7, 'archived', 'Marka Oreškovića 16 Subotica'),
(41, 'gdgfdgd', 'fdgdf', '2025-09-06 22:31:00', 7, 'active', 'gdfgd');

-- --------------------------------------------------------

--
-- Table structure for table `gifts`
--

CREATE TABLE `gifts` (
  `gift_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `reserved` enum('reserved','available') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gifts`
--

INSERT INTO `gifts` (`gift_id`, `name`, `link`, `event_id`, `reserved`) VALUES
(1, 'carape', 'www.gggg.com', 4, 'reserved'),
(6, 'poklon2', 'www.poklon2.com', 4, 'reserved'),
(7, 'poklon3', 'www.gggg.com', 4, 'reserved'),
(8, 'poklon3', 'www.poklon3.com', 4, 'available'),
(9, 'aaaaaaaaaaaaaaaab', 'www.gggg.com', 4, 'available'),
(10, 'a', 'www.ggg.comm', 4, 'available'),
(11, 'aaaaaaaaaaaaaaaaaaa', 'www.gggg.com', 4, 'reserved'),
(12, 'aaaaaaaaaaaaaaaaaaa', 'www.gggg.com', 4, 'reserved'),
(13, 'aaaaaaaaaaaaaaaaaaa', 'www.gggg.com', 4, 'reserved'),
(14, 'aaaaaaaaaaaaaaaaaaa', 'www.ggg.comm', 4, 'reserved'),
(15, 'aaaaaaaaaaaaaaaaaaa', 'www.zokne.com', 4, 'available'),
(16, 'bbbbb', 'www.gggb.comm', 4, 'reserved'),
(20, 'poklon1', 'www.ggg.com', 8, 'available'),
(21, 'poklon2', 'www.zokne.com', 8, 'available'),
(22, 'zokne', 'www.zokne.com', 8, 'available'),
(23, 'a', 'www.gggg.com', 8, 'available'),
(26, 'fdfsfa', 'www.ggg.comm', 29, 'available'),
(27, 'poklon6', 'www.zfffe.com', 4, 'reserved'),
(28, 'poklon1', 'www.ggg.com', 37, 'available'),
(29, 'poklon', 'www.poklon1.com', 40, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `invitees`
--

CREATE TABLE `invitees` (
  `invitee_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(254) NOT NULL,
  `attendance` enum('dolazi','ne dolazi','možda dolazi') NOT NULL DEFAULT 'ne dolazi',
  `event_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `gift_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invitees`
--

INSERT INTO `invitees` (`invitee_id`, `name`, `email`, `attendance`, `event_id`, `token`, `gift_id`, `created_at`) VALUES
(2, '222', '22222@gmail.com', 'dolazi', 4, 'aa7f3659d1dff920a6d951ae882df1418dc86c1251c506b74f7c44470d9931f5', 1, '2025-04-03 10:32:14'),
(3, 'fdsf', 'afaafafa@gmail.com', 'možda dolazi', 4, '4e65fe00a240e2c52d93646cf72c8ed6487704902cb1e92ee6e3639be6f9a56c', NULL, '2025-04-03 10:35:21'),
(8, 'fafa', 'fsfs@gmail.com', 'ne dolazi', 4, '0fe6f45518b310238deea663d8227057bb7e3a5579db8c46291a791c3003697e', 14, '2025-04-05 09:02:49'),
(10, 'rwrw', 'gg@gmail.com', 'ne dolazi', 4, 'b19232263e4de6b7540b606a986430056a0311ad7ee1a2d7d5224a7af8597af8', NULL, '2025-04-05 09:03:15'),
(14, 'ff', 'ggg2@gmail.com', 'ne dolazi', 4, '7efc0d9226e2b17eeb1e8b7eb4ae47e279d7dd6fbec2ccb06e6913e6a1cea7a6', NULL, '2025-04-05 09:07:38'),
(16, '11', '111@gmail.com', 'ne dolazi', 4, '510422257e548f56962b34911ef0fee0407ee8bdb51719dce63232f8311f175d', NULL, '2025-04-05 09:10:58'),
(38, 'ffffffffffffffffffffffffffffffffffffffffffffffffff', 'ffa2@gmail.com', 'ne dolazi', 4, 'e6eb3cd057b9c920af67486371a310117e6809a5b3f8c790e9b99d1e402bdd5b', NULL, '2025-04-06 12:05:36'),
(39, 'gfdgdsfgsdggdfgdfsgdf', '32323@gmail.com', 'ne dolazi', 4, '1334cee5945c37bb3e3df739c267c0a00ee83199acce9e4246a6d618b4d25042', NULL, '2025-04-06 12:05:44'),
(40, 'ffffffffffffffffffffffffffffffffffffffffffffffffff', 'fgsgdgsgs@gmail.com', 'ne dolazi', 4, '07a39c7f28d9dd61371fdd01b77205d1edbac3127dd93ae3b302c1e1945bd496', NULL, '2025-04-06 12:05:51'),
(41, 'ffffffffffffffffffffffffffffffffffffffffffffffffff', 'gfdsgfdd@gmail.com', 'ne dolazi', 4, '0094aa368332fde1e34afcdd0ba0bc7f34977c62fd06a30e73ab9254aaff1c2e', NULL, '2025-04-06 12:06:02'),
(42, 'ffffffffffffffffffffffffffffffffffffffffffffffffff', 'gffdsgfdd@gmail.com', 'ne dolazi', 4, 'dad1ee76ac1eb83e75c615841f5b6cacdfc1c8f88235777100d13e115d994d6a', NULL, '2025-04-06 12:06:08'),
(43, 'ffffffffffffffffffffffffffffffffffffffffffffffffff', 'gfdffdsfsgfdd@gmail.com', 'ne dolazi', 4, '286da88b539ff783eaaa649f6143e8735ef72c5af5b1ce3dc2c0702c377aa4ef', NULL, '2025-04-06 12:06:12'),
(44, 'ffffffffffffffffffffffffffffffffffffffffffffffffff', 'gfdsgfdffd@gmail.com', 'ne dolazi', 4, '18f608d0b189188ee37d7a29aaa0601166d679b20d3ec092cf9c32220c9be6d9', NULL, '2025-04-06 12:06:19'),
(45, 'ffffffffffffffffffffffffffffffffffffffffffffffffff', 'gfdaasgfdd@gmail.com', 'ne dolazi', 4, '3ce4fe8a494f6a8711d6fe555e7d1e7aacd25ccb9c1e8bb70a06caed18d77a7a', NULL, '2025-04-06 12:06:23'),
(48, 'afa', 'afaa@gmail.com', 'ne dolazi', 3, '9d60f3cff01e14ac2f822857b9ae3177ff7993c40e8631348e73b2a244de3dbd', NULL, '2025-04-15 17:07:12'),
(49, 'dfafdf', 'gsg@gmail.com', 'ne dolazi', 8, '3b60298a179a1c33371fead7d70750597b8e77275981e265861619083919c011', NULL, '2025-04-17 18:50:15'),
(50, 'gfdgdsfgsdgdfgsdg', 'fsfs@gmail.com', 'ne dolazi', 8, 'f9cc9b4103a5d947f15446da2d84f0efcf0e6b4062261ff8bdf4b36dabb7cd38', NULL, '2025-04-17 18:50:20'),
(51, 'fadsfasfsda', 'afaa@gmail.com', 'ne dolazi', 8, '4879cb1bb0818ca6e4175aefdd5426f1e6bd570720b5c09a60626656d776e56b', NULL, '2025-04-17 18:50:23'),
(52, 'ffffffffffffffffffffffffffffffffffffffffffffffffff', 'fafaf@gmail.com', 'ne dolazi', 8, 'ac00498262dcd597d62274496bd36bc43f2d59d32119a933c1507e0e3bf2c252', NULL, '2025-04-17 18:53:31'),
(54, 'zvanicaa', 'zvanicaa@gmail.com', 'ne dolazi', 6, '501c885cd7bc55d6180e8bb5c68103d5ad541f645eabdc3f4df203d0466793e7', NULL, '2025-04-21 19:42:03'),
(56, 'fdsafs', 'fsfs@gmail.com', 'ne dolazi', 29, '2e75b83e8a931ab9ec02fb0b0a3181c3dd1c831eb19eb664f4ef57574c573f4f', NULL, '2025-04-25 23:20:28'),
(57, 'dfasfs', 'afa@gmail.com', 'ne dolazi', 29, 'ada94fd58a1231a8f5b7766798001fdcf484ab975d80b368c3e5aff52ad1ebe6', NULL, '2025-04-25 23:20:31'),
(58, 'gsdfgsd', 'afaa@gmail.com', 'ne dolazi', 29, '53267ce38810462332653ff62ce96be490141ac615cbca5868f84865d34d0a36', NULL, '2025-04-25 23:20:35'),
(59, 'gfds', 'b@gmail.com', 'ne dolazi', 29, '2615335ef6be2884e3ae75769dbed1bf0ae981b650c6b33f81ec47ba11e2bdd3', NULL, '2025-04-25 23:20:46'),
(64, 'Zvanicaa', 'zvanicaa@gmail.com', 'ne dolazi', 4, 'e760a38dec850709c6ea265ab88678cd4fafea9d57942f9309f5889f47cd15cc', 16, '2025-04-28 15:26:56'),
(66, 'zvnc', 'zvnc@gmail.com', 'ne dolazi', 4, '50c3c592013753ac1dbdb26eaafcfadf7d9c9fc5a067c27f276f7cac890e74ac', 6, '2025-04-30 02:06:51'),
(67, 'Leon', 'leon@gmail.com', 'možda dolazi', 19, '325d7c4c452961238904581d1b729f7af8b62501e0f488b7aaf802ae469551c9', NULL, '2025-04-30 02:37:53'),
(69, 'gsdgf', 'e22@gmail.com', 'ne dolazi', 4, '17b221a4bbfca5a27b08164a2acd5ddb2148caa9b7c573618f15e65d587121df', NULL, '2025-04-30 03:33:47'),
(79, 'e2', 'e2@gmail.com', 'ne dolazi', 4, 'fea06edb920f1086b9ab4a53c2f3c9a13de8864c3b5ed8e993ea88039866d782', NULL, '2025-04-30 03:59:31'),
(83, 'gfdgdgdg', 'gfdgf@gmail.com', 'dolazi', 4, 'e9fad1914252154d32756a795e560bca8f7234d79f27bf37acf8890ef4d8499b', NULL, '2025-05-22 20:08:34'),
(84, 'zvnc', 'blabla123@gmail.com', 'ne dolazi', 4, '51cc3a8048ecb6d4f3c921b7625c40132d679d199d3882018929df9581176375', NULL, '2025-08-15 13:44:17'),
(86, 'zvanica', 'zvanicaa@gmail.com', 'ne dolazi', 39, '216c1fa6070a3909b234e9c6f31c576cf261ecde7e36bfce5e5e20d9dfae5bbe', NULL, '2025-08-29 17:39:56'),
(87, 'zvanica', 'zvanica@gmail.com', 'ne dolazi', 40, 'e8961315eb5c821f9dd320f29a78e4f47aef30df471e67547ad006257e716ef4', NULL, '2025-08-29 17:41:02'),
(88, 'fsdfsad', 'fdfffssfs@gmail.com', 'dolazi', 4, '3497d419e8d22cdad5d36734c2f7f9bc24869a741c9e7efdd4310d76cc8e8410', 27, '2025-08-29 18:50:03'),
(89, 'fafafafd', 'ff@gmail.com', 'možda dolazi', 7, '7d1802f5a63ddd3f75f3999d8966fe500e284db5f99ce91dd2fc368ee5596910', NULL, '2025-08-29 18:50:57'),
(90, 'e1@gmail.com', 'e1@gmail.com', 'ne dolazi', 41, '0f92d923327eea91726b6607a69997a3023b633ffb36602da4c3b49eea63a51b', NULL, '2025-08-31 20:31:57');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `title`, `text`, `user_id`) VALUES
(9, 'Obrisan je događaj \"petar petrovic 12. rodjendan\"', 'Prekrsili ste pravila', 2),
(18, 'Obrisan je događaj \"MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM\"', 'Razlog: bbbbbbbbbbbbbbbbb', 2),
(21, 'Pozvani se na događaј \"event1213\"', 'Zdravo e2! ime1 prez1 vas poziva na događaj event1213 koji se održava: 2025-06-20 08:09:00 Proverite vaš mejl.', 5),
(23, 'Pozvani se na događaј \"gdgfdgd\"', 'Zdravo e1@gmail.com! ime11 prez11 vas poziva na događaj gdgfdgd koji se održava: 2025-09-06 22:31:00. Proverite vaš mejl.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `token_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`token_id`, `user_id`, `token`, `password`, `expires_at`) VALUES
(1, 2, 'b3e5510f13a8db1faea4d3e41324122b3e72df50b9ff38a04bd22edd1f25af12', '$2y$10$hT6v1eI.VyCxVMDn5wsEO./YNU429LpPieSWFt3RlAdJ4M02i5dqW', '2025-05-06 11:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(64) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `activated` tinyint(1) DEFAULT 0,
  `registration_date` timestamp NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `lname`, `email`, `password`, `role`, `activated`, `registration_date`, `phone`, `blocked`) VALUES
(2, 'ime1', 'prez1', 'e1@gmail.com', '$2y$10$dniA8yUkomdg3ZGujrKRDuMTARXmw47DmYqV5vv/be2bDPMBDjjiW', 'user', 1, '2024-12-16 21:40:03', '0618888888', 0),
(3, 'aaa', 'bbb', 'a1@gmail.com', '$2y$10$Ws.nYjIXcii07gJos5durui9286NUuS/jwcIYnNtkDlRzC9hxEThC', 'admin', 1, '2025-03-31 03:48:06', '0692025066', 0),
(5, 'fdsfdaf', 'adsfsaf', 'e2@gmail.com', '$2y$10$yxjpbEtqkSr7YC3lfHW2YOXunh4lya8Zovcr2C6a0FgEml5gWao2W', 'user', 1, '2025-04-19 02:09:55', '0628885454', 1),
(7, 'ime11', 'prez11', 'e3@gmail.com', '$2y$10$6z.ffvySLsCXdG5UEZKu3uX2E5ZJzCmfoAEyRV5JINDg9G/Kdt1lS', 'user', 1, '2025-08-24 00:41:44', '+381601234567', 0),
(8, 'Ine', 'Prez', 'Mob@gmail.com', '$2y$10$szZ6/9qz.fqxU9qnS7RCsu85uFbeAlBWBm0wm5EW7bO3LOEsIPqjS', 'user', 1, '2025-08-24 04:44:57', '0625984111', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detects`
--
ALTER TABLE `detects`
  ADD PRIMARY KEY (`id_detect`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `gifts`
--
ALTER TABLE `gifts`
  ADD PRIMARY KEY (`gift_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `invitees`
--
ALTER TABLE `invitees`
  ADD PRIMARY KEY (`invitee_id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD UNIQUE KEY `token_2` (`token`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `gift_id` (`gift_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`token_id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detects`
--
ALTER TABLE `detects`
  MODIFY `id_detect` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `gifts`
--
ALTER TABLE `gifts`
  MODIFY `gift_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `invitees`
--
ALTER TABLE `invitees`
  MODIFY `invitee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detects`
--
ALTER TABLE `detects`
  ADD CONSTRAINT `detects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `gifts`
--
ALTER TABLE `gifts`
  ADD CONSTRAINT `gifts_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Constraints for table `invitees`
--
ALTER TABLE `invitees`
  ADD CONSTRAINT `invitees_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `invitees_ibfk_2` FOREIGN KEY (`gift_id`) REFERENCES `gifts` (`gift_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
