-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               8.0.34 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table bbcdb.beginner courts
CREATE TABLE IF NOT EXISTS `beginner courts` (
  `court_id` int NOT NULL AUTO_INCREMENT,
  `court_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('ongoing','available','unavailable') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'available',
  `price` decimal(10,2) NOT NULL DEFAULT '180.00',
  PRIMARY KEY (`court_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbcdb.beginner courts: ~3 rows (approximately)
INSERT INTO `beginner courts` (`court_id`, `court_number`, `status`, `price`) VALUES
	(9, 'Court 9', 'available', 180.00),
	(10, 'Court 10', 'available', 180.00),
	(11, 'Court 11', 'available', 180.00);

-- Dumping structure for table bbcdb.blocked_times
CREATE TABLE IF NOT EXISTS `blocked_times` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbcdb.blocked_times: ~0 rows (approximately)
INSERT INTO `blocked_times` (`id`, `date`, `time`) VALUES
	(1, '2023-10-16', '09:45:44');

-- Dumping structure for table bbcdb.canceled
CREATE TABLE IF NOT EXISTS `canceled` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reserved_datetime` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `court` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `sport` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `status` enum('canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'canceled',
  `date_of_cancellation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` longblob,
  `qr_code` longblob,
  `hours` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbcdb.canceled: ~98 rows (approximately)
INSERT INTO `canceled` (`id`, `reserved_datetime`, `created_at`, `court`, `sport`, `status`, `date_of_cancellation`, `user_name`, `user_email`, `image`, `qr_code`, `hours`) VALUES
	(100, '2023-09-14 10:37:59', '2023-09-13 20:38:07', 'Court 2', 'Badminton', 'canceled', '2023-09-14 10:38:22', NULL, NULL, NULL, NULL, 0),
	(101, '2023-09-14 10:38:00', '2023-09-13 20:38:10', 'Court 2', 'Badminton', 'canceled', '2023-09-14 10:38:25', NULL, NULL, NULL, NULL, 0),
	(102, '2023-09-14 10:38:00', '2023-09-13 20:38:13', 'Court 2', 'Badminton', 'canceled', '2023-09-14 10:38:43', NULL, NULL, NULL, NULL, 0),
	(103, '2023-09-14 10:38:00', '2023-09-13 20:38:16', 'Court 2', 'Badminton', 'canceled', '2023-09-14 10:40:43', NULL, NULL, NULL, NULL, 0),
	(104, '2023-09-14 10:38:00', '2023-09-13 20:38:33', 'Court 2', 'Badminton', 'canceled', '2023-09-14 10:41:27', NULL, NULL, NULL, NULL, 0),
	(105, '2023-09-14 10:38:00', '2023-09-13 20:38:36', 'Court 2', 'Badminton', 'canceled', '2023-09-14 10:41:32', NULL, NULL, NULL, NULL, 0),
	(106, '2023-09-14 10:38:00', '2023-09-13 20:38:39', 'Court 2', 'Badminton', 'canceled', '2023-09-14 13:31:35', NULL, NULL, NULL, NULL, 0),
	(107, '2023-09-14 10:37:58', '2023-09-13 23:32:18', 'Court 2', 'Badminton', 'canceled', '2023-09-14 13:36:59', NULL, NULL, NULL, NULL, 0),
	(108, '2023-09-14 10:37:58', '2023-09-13 23:32:23', 'Court 2', 'Badminton', 'canceled', '2023-09-14 13:37:06', NULL, NULL, NULL, NULL, 0),
	(109, '2023-09-14 10:37:58', '2023-09-13 23:32:27', 'Court 2', 'Badminton', 'canceled', '2023-09-14 13:42:55', NULL, NULL, NULL, NULL, 0),
	(110, '2023-09-14 10:37:58', '2023-09-13 23:32:30', 'Court 2', 'Badminton', 'canceled', '2023-09-14 13:42:58', NULL, NULL, NULL, NULL, 0),
	(111, '2023-09-14 10:37:58', '2023-09-13 23:36:26', 'Court 2', 'Badminton', 'canceled', '2023-09-14 13:43:28', NULL, NULL, NULL, NULL, 0),
	(112, '2023-09-14 10:37:59', '2023-09-13 23:36:31', 'Court 2', 'Badminton', 'canceled', '2023-09-14 13:43:32', NULL, NULL, NULL, NULL, 0),
	(113, '2023-09-14 10:37:59', '2023-09-13 23:36:34', 'Court 2', 'Badminton', 'canceled', '2023-09-14 13:43:38', NULL, NULL, NULL, NULL, 0),
	(114, '2023-09-14 10:37:59', '2023-09-13 23:36:38', 'Court 2', 'Badminton', 'canceled', '2023-09-14 13:47:56', NULL, NULL, NULL, NULL, 0),
	(115, '2023-09-14 10:37:59', '2023-09-13 23:36:42', 'Court 2', 'Badminton', 'canceled', '2023-09-14 13:49:48', NULL, NULL, NULL, NULL, 0),
	(116, '2023-09-14 10:37:59', '2023-09-13 23:36:47', 'Court 2', 'Badminton', 'canceled', '2023-09-14 13:49:52', NULL, NULL, NULL, NULL, 0),
	(117, '2023-09-14 10:37:56', '2023-09-13 23:36:52', 'Court 2', 'Badminton', 'canceled', '2023-09-14 13:53:44', NULL, NULL, NULL, NULL, 0),
	(118, '2023-09-14 10:37:56', '2023-09-13 23:53:54', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:00:22', NULL, NULL, NULL, NULL, 0),
	(119, '2023-09-14 10:37:57', '2023-09-13 23:53:59', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:00:25', NULL, NULL, NULL, NULL, 0),
	(120, '2023-09-14 10:37:57', '2023-09-13 23:54:03', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:00:30', NULL, NULL, NULL, NULL, 0),
	(121, '2023-09-14 10:37:58', '2023-09-13 23:54:05', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:00:33', NULL, NULL, NULL, NULL, 0),
	(122, '2023-09-14 10:37:57', '2023-09-13 23:54:09', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:01:58', NULL, NULL, NULL, NULL, 0),
	(123, '2023-09-14 10:37:57', '2023-09-13 23:54:12', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:12:43', NULL, NULL, NULL, NULL, 0),
	(124, '2023-09-14 10:37:57', '2023-09-13 23:54:16', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:26:53', NULL, NULL, NULL, NULL, 0),
	(125, '2023-09-14 10:37:58', '2023-09-13 23:54:20', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:26:56', NULL, NULL, NULL, NULL, 0),
	(126, '2023-09-14 10:37:57', '2023-09-13 23:54:24', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:26:58', NULL, NULL, NULL, NULL, 0),
	(127, '2023-09-14 14:29:43', '2023-09-10 14:18:43', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:29:57', NULL, NULL, NULL, NULL, 0),
	(128, '2023-09-14 10:37:55', '2023-09-14 00:28:33', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:30:36', NULL, NULL, NULL, NULL, 0),
	(129, '2023-09-14 14:29:42', '2023-09-03 22:52:42', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:30:39', NULL, NULL, NULL, NULL, 0),
	(130, '2023-09-14 14:29:43', '2023-08-20 18:24:43', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:30:43', NULL, NULL, NULL, NULL, 0),
	(131, '2023-09-14 14:29:43', '2023-08-17 21:34:43', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:30:48', NULL, NULL, NULL, NULL, 0),
	(132, '2023-09-14 14:29:43', '2023-08-27 01:04:43', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:30:53', NULL, NULL, NULL, NULL, 0),
	(133, '2023-09-14 14:29:44', '2023-09-02 13:09:44', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:30:54', NULL, NULL, NULL, NULL, 0),
	(134, '2023-09-14 14:29:44', '2023-08-27 05:03:44', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:30:55', NULL, NULL, NULL, NULL, 0),
	(135, '2023-09-14 14:29:44', '2023-09-13 13:59:44', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:30:57', NULL, NULL, NULL, NULL, 0),
	(136, '2023-09-14 14:29:44', '2023-08-31 14:35:44', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:31:01', NULL, NULL, NULL, NULL, 0),
	(137, '2023-09-14 14:29:44', '2023-08-26 22:42:44', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:32:26', NULL, NULL, NULL, NULL, 0),
	(138, '2023-09-14 14:29:45', '2023-08-15 18:56:45', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:32:30', NULL, NULL, NULL, NULL, 0),
	(139, '2023-09-14 14:29:45', '2023-09-04 09:02:45', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:33:29', NULL, NULL, NULL, NULL, 0),
	(140, '2023-09-14 14:29:45', '2023-08-26 11:21:45', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:33:48', NULL, NULL, NULL, NULL, 0),
	(141, '2023-09-14 14:29:45', '2023-09-05 07:37:45', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:36:36', NULL, NULL, NULL, NULL, 0),
	(142, '2023-09-14 14:29:45', '2023-08-27 22:41:45', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:36:39', NULL, NULL, NULL, NULL, 0),
	(143, '2023-09-14 14:29:45', '2023-09-11 06:45:45', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:41:24', NULL, NULL, NULL, NULL, 0),
	(144, '2023-09-14 14:29:46', '2023-08-23 21:58:46', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:41:26', NULL, NULL, NULL, NULL, 0),
	(145, '2023-09-14 14:29:46', '2023-08-25 12:52:46', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:41:28', NULL, NULL, NULL, NULL, 0),
	(146, '2023-09-14 14:29:46', '2023-08-17 12:20:46', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:54:39', NULL, NULL, NULL, NULL, 0),
	(147, '2023-09-14 14:29:46', '2023-08-31 13:06:46', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:54:42', NULL, NULL, NULL, NULL, 0),
	(148, '2023-09-14 14:29:46', '2023-08-23 20:26:46', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:56:59', NULL, NULL, NULL, NULL, 0),
	(149, '2023-09-14 14:29:46', '2023-08-15 12:53:46', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:57:00', NULL, NULL, NULL, NULL, 0),
	(150, '2023-09-14 14:29:46', '2023-08-18 16:07:46', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:57:01', NULL, NULL, NULL, NULL, 0),
	(151, '2023-09-14 14:29:47', '2023-09-13 03:00:47', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:57:02', NULL, NULL, NULL, NULL, 0),
	(152, '2023-09-14 14:29:47', '2023-09-12 10:25:47', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:57:42', NULL, NULL, NULL, NULL, 0),
	(153, '2023-09-14 14:29:47', '2023-08-19 07:10:47', 'Court 2', 'Badminton', 'canceled', '2023-09-14 14:57:45', NULL, NULL, NULL, NULL, 0),
	(154, '2023-09-14 14:29:47', '2023-08-23 15:38:47', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:01:44', NULL, NULL, NULL, NULL, 0),
	(155, '2023-09-14 14:29:47', '2023-08-29 07:11:47', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:01:46', NULL, NULL, NULL, NULL, 0),
	(156, '2023-09-14 14:29:47', '2023-08-25 22:54:47', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:01:47', NULL, NULL, NULL, NULL, 0),
	(157, '2023-09-14 14:29:48', '2023-09-12 19:18:48', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:11:24', NULL, NULL, NULL, NULL, 0),
	(158, '2023-09-14 14:29:48', '2023-08-29 03:22:48', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:11:26', NULL, NULL, NULL, NULL, 0),
	(159, '2023-09-14 14:29:48', '2023-09-09 20:58:48', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:11:26', NULL, NULL, NULL, NULL, 0),
	(160, '2023-09-14 14:29:48', '2023-08-30 12:08:48', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:11:26', NULL, NULL, NULL, NULL, 0),
	(161, '2023-09-14 14:29:48', '2023-08-28 14:58:48', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:11:27', NULL, NULL, NULL, NULL, 0),
	(162, '2023-09-14 14:29:48', '2023-08-24 04:15:48', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:11:57', NULL, NULL, NULL, NULL, 0),
	(163, '2023-09-14 14:29:49', '2023-08-16 03:51:49', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:11:57', NULL, NULL, NULL, NULL, 0),
	(164, '2023-09-14 14:29:49', '2023-08-19 22:30:49', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:11:59', NULL, NULL, NULL, NULL, 0),
	(165, '2023-09-14 14:29:49', '2023-09-11 19:36:49', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:12:03', NULL, NULL, NULL, NULL, 0),
	(166, '2023-09-14 14:29:49', '2023-09-10 04:29:49', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:12:44', NULL, NULL, NULL, NULL, 0),
	(167, '2023-09-14 14:29:49', '2023-08-21 09:32:49', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:13:03', NULL, NULL, NULL, NULL, 0),
	(168, '2023-09-14 10:37:55', '2023-09-14 01:13:35', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:14:09', NULL, NULL, NULL, NULL, 0),
	(169, '2023-09-14 10:37:56', '2023-09-14 01:13:39', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:17:37', NULL, NULL, NULL, NULL, 0),
	(170, '2023-09-14 10:37:56', '2023-09-14 01:13:50', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:18:56', NULL, NULL, NULL, NULL, 0),
	(171, '2023-09-14 10:37:56', '2023-09-14 01:13:43', 'Court 2', 'Badminton', 'canceled', '2023-09-14 15:19:00', NULL, NULL, NULL, NULL, 0),
	(172, '2023-09-14 10:37:55', '2023-09-14 01:13:47', 'Court 2', 'Badminton', 'canceled', '2023-09-15 08:39:51', NULL, NULL, NULL, NULL, 0),
	(173, '2023-09-14 10:37:23', '2023-09-14 07:42:44', 'Court 2', 'Badminton', 'canceled', '2023-09-15 08:39:54', NULL, NULL, NULL, NULL, 0),
	(174, '2023-09-14 10:37:56', '2023-09-14 07:42:49', 'Court 2', 'Badminton', 'canceled', '2023-09-15 09:49:17', NULL, NULL, NULL, NULL, 0),
	(175, '2023-09-14 10:37:54', '2023-09-14 07:42:54', 'Court 2', 'Badminton', 'canceled', '2023-09-15 10:32:16', NULL, NULL, NULL, NULL, 0),
	(176, '2023-09-14 10:37:54', '2023-09-14 07:42:58', 'Court 2', 'Badminton', 'canceled', '2023-09-15 10:39:09', NULL, NULL, NULL, NULL, 0),
	(177, '2023-09-26 02:51:46', '2023-09-13 20:35:14', 'Court 1', 'Badminton', 'canceled', '2023-09-15 14:01:27', NULL, NULL, NULL, NULL, 0),
	(178, '2023-10-09 01:03:48', '2023-09-13 20:35:21', 'Court 1', 'Badminton', 'canceled', '2023-09-15 14:03:22', NULL, NULL, NULL, NULL, 0),
	(179, '2023-09-18 07:38:48', '2023-09-13 20:35:24', 'Court 1', 'Badminton', 'canceled', '2023-09-15 14:03:26', NULL, NULL, NULL, NULL, 0),
	(180, '2023-09-20 13:35:48', '2023-09-13 20:35:25', 'Court 1', 'Badminton', 'canceled', '2023-09-15 14:03:27', NULL, NULL, NULL, NULL, 0),
	(181, '2023-10-07 21:21:48', '2023-09-13 20:35:27', 'Court 1', 'Badminton', 'canceled', '2023-09-15 14:06:19', NULL, NULL, NULL, NULL, 0),
	(182, '2023-10-07 12:36:49', '2023-09-13 20:35:28', 'Court 1', 'Badminton', 'canceled', '2023-09-15 14:06:55', NULL, NULL, NULL, NULL, 0),
	(183, '2023-10-12 21:01:49', '2023-09-14 01:17:34', 'Court 1', 'Badminton', 'canceled', '2023-09-15 14:11:59', NULL, NULL, NULL, NULL, 0),
	(184, '2023-09-25 06:30:49', '2023-09-14 01:17:35', 'Court 1', 'Badminton', 'canceled', '2023-09-15 14:14:30', NULL, NULL, NULL, NULL, 0),
	(185, '2023-09-14 10:37:55', '2023-09-14 19:58:20', 'Court 2', 'Badminton', 'canceled', '2023-09-15 14:48:17', NULL, NULL, NULL, NULL, 0),
	(186, '2023-10-11 22:09:49', '2023-09-14 01:17:57', 'Court 1', 'Badminton', 'canceled', '2023-09-15 15:06:55', NULL, NULL, NULL, NULL, 0),
	(187, '2023-09-29 09:00:00', '2023-09-18 19:48:41', 'Court 1', 'Badminton', 'canceled', '2023-09-19 13:22:54', NULL, NULL, NULL, NULL, 0),
	(188, '2023-09-28 23:21:00', '2023-09-18 21:22:05', 'Court 1', 'Badminton', 'canceled', '2023-09-19 13:23:12', NULL, NULL, NULL, NULL, 0),
	(189, '2023-09-27 08:47:00', '2023-09-18 21:22:13', 'Court 1', 'Badminton', 'canceled', '2023-09-19 13:23:18', NULL, NULL, NULL, NULL, 0),
	(190, '2023-09-30 16:38:00', '2023-09-18 23:10:38', 'Court 1', 'Badminton', 'canceled', '2023-09-19 13:23:21', NULL, NULL, NULL, NULL, 0),
	(191, '2023-09-29 16:38:00', '2023-09-18 23:10:41', 'Court 1', 'Badminton', 'canceled', '2023-09-19 13:26:32', NULL, NULL, NULL, NULL, 0),
	(192, '2023-09-28 08:48:00', '2023-09-18 23:23:47', 'Court 1', 'Badminton', 'canceled', '2023-09-19 13:31:10', NULL, NULL, NULL, NULL, 0),
	(193, '2023-09-25 16:38:00', '2023-09-18 21:21:50', 'Court 1', 'Badminton', 'canceled', '2023-09-19 13:34:46', NULL, NULL, NULL, NULL, 0),
	(194, '2023-09-29 20:50:00', '2023-09-18 23:23:48', 'Court 1', 'Badminton', 'canceled', '2023-09-19 13:34:55', NULL, NULL, NULL, NULL, 0),
	(195, '2023-09-23 09:43:00', '2023-09-18 23:23:45', 'Court 1', 'Badminton', 'canceled', '2023-09-19 13:35:35', NULL, NULL, NULL, NULL, 0),
	(196, '2023-09-22 10:49:00', '2023-09-18 19:49:42', 'Court 1', 'Badminton', 'canceled', '2023-09-19 14:04:38', NULL, NULL, NULL, NULL, 0),
	(197, '2023-09-20 13:46:00', '2023-09-18 23:46:51', 'Court 1', 'Badminton', 'canceled', '2023-09-19 14:04:41', NULL, NULL, NULL, NULL, 0),
	(198, '2023-09-21 14:54:00', '2023-09-20 00:02:15', 'Court 2', 'Badminton', 'canceled', '2023-09-20 15:12:27', NULL, NULL, NULL, NULL, 0),
	(199, '2023-09-26 13:47:00', '2023-09-19 23:47:24', 'Court 3', 'Badminton', 'canceled', '2023-09-20 15:12:33', NULL, NULL, NULL, NULL, 0),
	(200, '2023-09-29 11:49:00', '2023-09-18 19:50:04', 'Court 1', 'Badminton', 'canceled', '2023-09-20 16:22:21', NULL, NULL, NULL, NULL, 0),
	(201, '2023-10-20 16:11:00', '2023-09-25 00:12:23', 'Court 2', 'Table Tennis', 'canceled', '2023-09-25 14:31:30', NULL, NULL, NULL, NULL, 0),
	(202, '2023-09-18 15:01:00', '2023-09-18 20:33:18', 'Court 1', 'Badminton', 'canceled', '2023-10-10 08:33:15', NULL, NULL, NULL, NULL, 0),
	(203, '2023-10-28 00:00:00', '2023-10-27 03:29:00', 'Court 1', 'Badminton', 'canceled', '2023-11-02 02:52:19', 'pat', 'garciapatrick341@gmail.com', _binary 0x2e2f7061796d656e742f3339353539353130315f313631313933323938353838323036355f353231353538373739353030353135383733395f6e2e6a7067, NULL, 1),
	(204, '2023-10-30 00:00:00', '2023-10-27 00:43:27', 'Court 3', 'Badminton', 'canceled', '2023-11-02 02:52:26', 'pat', 'garciapatrick341@gmail.com', _binary 0x2e2f7061796d656e742f3339353539353130315f313631313933323938353838323036355f353231353538373739353030353135383733395f6e2e6a7067, NULL, 0);

-- Dumping structure for table bbcdb.courts
CREATE TABLE IF NOT EXISTS `courts` (
  `court_id` int NOT NULL AUTO_INCREMENT,
  `court_number` varchar(50) NOT NULL,
  `status` enum('ongoing','available','unavailable') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'available',
  `category` enum('special','regular','beginner') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  PRIMARY KEY (`court_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbcdb.courts: ~12 rows (approximately)
INSERT INTO `courts` (`court_id`, `court_number`, `status`, `category`, `price`) VALUES
	(1, 'Court 1', 'ongoing', 'special', 250.00),
	(2, 'Court 2', 'ongoing', 'special', 250.00),
	(3, 'Court 3', 'unavailable', 'special', 250.00),
	(4, 'Court 4', 'available', 'regular', 210.00),
	(5, 'Court 5', 'available', 'regular', 210.00),
	(6, 'Court 6', 'available', 'regular', 210.00),
	(7, 'Court 7', 'available', 'regular', 210.00),
	(8, 'Court 8', 'available', 'regular', 210.00),
	(9, 'Court 9', 'available', 'beginner', 180.00),
	(10, 'Court 10\r\n\r\n', 'available', 'beginner', 180.00),
	(11, 'Court 11', 'available', 'beginner', 180.00);

-- Dumping structure for table bbcdb.declined
CREATE TABLE IF NOT EXISTS `declined` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reserved_datetime` datetime NOT NULL,
  `created_at` timestamp NOT NULL,
  `court` text,
  `sport` text,
  `status` enum('pending','approved','declined') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbcdb.declined: ~62 rows (approximately)
INSERT INTO `declined` (`id`, `reserved_datetime`, `created_at`, `court`, `sport`, `status`) VALUES
	(31, '2023-09-06 22:01:00', '2023-09-05 07:10:13', 'Court 2', 'Badminton', 'declined'),
	(32, '2023-09-05 21:18:00', '2023-09-05 07:18:22', 'Court 1', 'Badminton', 'declined'),
	(33, '2023-09-06 08:28:00', '2023-09-06 00:28:21', 'Court 1', 'Badminton', 'declined'),
	(34, '2023-09-06 08:28:00', '2023-09-06 00:34:08', 'Court 1', 'Badminton', 'declined'),
	(35, '2023-09-10 21:18:00', '2023-09-05 07:20:08', 'Court 1', 'Badminton', 'declined'),
	(36, '2023-09-11 21:18:00', '2023-09-05 07:20:10', 'Court 1', 'Badminton', 'declined'),
	(37, '2023-09-12 21:18:00', '2023-09-05 07:20:13', 'Court 1', 'Badminton', 'declined'),
	(38, '2023-09-13 21:18:00', '2023-09-05 07:20:15', 'Court 1', 'Badminton', 'declined'),
	(39, '2023-09-14 21:18:00', '2023-09-05 07:20:17', 'Court 1', 'Badminton', 'declined'),
	(40, '2023-09-24 15:54:00', '2023-09-05 07:54:58', 'Court 1', 'Badminton', 'declined'),
	(41, '2023-09-30 15:25:00', '2023-09-05 07:25:50', 'Court 1', 'Badminton', 'declined'),
	(42, '2023-09-30 15:30:00', '2023-09-05 07:30:16', 'Court 1', 'Badminton', 'declined'),
	(43, '2023-10-02 15:25:00', '2023-09-05 07:25:59', 'Court 1', 'Badminton', 'declined'),
	(44, '2023-09-06 13:36:00', '2023-09-06 05:36:32', 'Court 1', 'Badminton', 'declined'),
	(45, '2023-09-26 10:35:00', '2023-09-07 02:35:50', 'Court 1', 'Badminton', 'declined'),
	(46, '2023-09-27 00:00:00', '2023-09-07 02:35:45', 'Court 1', 'Badminton', 'declined'),
	(47, '2023-10-01 10:35:00', '2023-09-07 02:35:53', 'Court 1', 'Badminton', 'declined'),
	(48, '2023-11-20 08:53:00', '2023-09-08 00:59:32', 'Court 2', 'Badminton', 'declined'),
	(49, '2023-09-28 08:53:00', '2023-09-08 00:54:07', 'Court 2', 'Badminton', 'declined'),
	(50, '2023-09-18 08:53:00', '2023-09-08 00:54:01', 'Court 2', 'Badminton', 'declined'),
	(51, '2023-11-03 08:53:00', '2023-09-08 00:58:43', 'Court 2', 'Badminton', 'declined'),
	(52, '2023-10-05 08:53:00', '2023-09-08 00:54:09', 'Court 2', 'Badminton', 'declined'),
	(53, '2023-09-08 08:53:00', '2023-09-08 00:53:58', 'Court 2', 'Badminton', 'declined'),
	(54, '2023-11-10 09:40:00', '2023-09-08 01:40:34', 'Court 1', 'Badminton', 'declined'),
	(55, '2023-11-04 09:40:00', '2023-09-08 01:40:36', 'Court 1', 'Badminton', 'declined'),
	(56, '2023-11-01 09:40:00', '2023-09-08 01:40:40', 'Court 1', 'Badminton', 'declined'),
	(57, '2023-11-02 09:40:00', '2023-09-08 01:40:42', 'Court 1', 'Badminton', 'declined'),
	(58, '2023-11-05 09:40:00', '2023-09-08 01:40:46', 'Court 1', 'Badminton', 'declined'),
	(59, '2023-11-08 09:40:00', '2023-09-08 01:40:53', 'Court 1', 'Badminton', 'declined'),
	(60, '2023-09-12 22:38:00', '2023-09-08 06:40:36', 'Court 3', 'Badminton', 'declined'),
	(61, '2023-11-11 09:40:00', '2023-09-08 01:41:01', 'Court 1', 'Badminton', 'declined'),
	(62, '2023-09-28 19:24:00', '2023-09-11 06:24:21', 'Court 1', 'Badminton', 'declined'),
	(63, '2023-09-26 19:24:00', '2023-09-11 06:24:25', 'Court 1', 'Badminton', 'declined'),
	(64, '2023-09-12 18:38:00', '2023-09-08 06:38:53', 'Court 3', 'Badminton', 'declined'),
	(65, '2023-09-12 08:06:00', '2023-09-12 03:06:59', 'Court 1', 'Badminton', 'declined'),
	(66, '2023-09-16 08:06:00', '2023-09-12 03:07:13', 'Court 3', 'Table Tennis', 'declined'),
	(67, '2023-09-13 13:27:00', '2023-09-12 05:27:02', 'Court 1', 'Badminton', 'declined'),
	(68, '2023-09-14 13:27:00', '2023-09-12 05:27:05', 'Court 1', 'Badminton', 'declined'),
	(69, '2023-09-18 13:27:00', '2023-09-12 05:27:11', 'Court 1', 'Badminton', 'declined'),
	(70, '2023-09-20 13:27:00', '2023-09-12 05:27:14', 'Court 1', 'Badminton', 'declined'),
	(71, '2023-09-19 13:27:00', '2023-09-12 05:27:13', 'Court 1', 'Badminton', 'declined'),
	(72, '2023-09-30 13:27:00', '2023-09-12 05:27:21', 'Court 1', 'Badminton', 'declined'),
	(73, '2023-09-13 03:53:00', '2023-09-13 01:53:18', 'Court 1', 'Badminton', 'declined'),
	(74, '2023-09-26 07:53:00', '2023-09-13 01:53:39', 'Court 1', 'Badminton', 'declined'),
	(75, '2023-09-30 07:53:00', '2023-09-13 01:53:42', 'Court 1', 'Badminton', 'declined'),
	(76, '2023-09-13 10:12:00', '2023-09-13 02:12:26', 'Court 1', 'Badminton', 'declined'),
	(77, '2023-09-13 11:12:00', '2023-09-13 02:12:30', 'Court 1', 'Badminton', 'declined'),
	(78, '2023-09-13 00:12:00', '2023-09-13 02:12:35', 'Court 1', 'Badminton', 'declined'),
	(79, '2023-09-13 01:12:00', '2023-09-13 02:12:39', 'Court 1', 'Badminton', 'declined'),
	(80, '2023-09-14 02:12:00', '2023-09-13 02:12:45', 'Court 1', 'Badminton', 'declined'),
	(81, '2023-09-15 04:12:00', '2023-09-13 02:12:56', 'Court 1', 'Badminton', 'declined'),
	(82, '2023-09-16 04:12:00', '2023-09-13 02:12:58', 'Court 1', 'Badminton', 'declined'),
	(83, '2023-09-17 04:12:00', '2023-09-13 02:13:00', 'Court 1', 'Badminton', 'declined'),
	(84, '2023-09-13 10:26:00', '2023-09-13 02:26:45', 'Court 1', 'Badminton', 'declined'),
	(85, '2023-09-13 10:26:00', '2023-09-13 02:26:58', 'Court 1', 'Badminton', 'declined'),
	(86, '2023-09-20 10:27:00', '2023-09-13 02:27:31', 'Court 1', 'Badminton', 'declined'),
	(87, '2023-09-13 10:27:00', '2023-09-13 02:27:54', 'Court 1', 'Badminton', 'declined'),
	(88, '2023-09-13 10:28:00', '2023-09-13 02:28:03', 'Court 1', 'Badminton', 'declined'),
	(89, '2023-09-13 10:28:00', '2023-09-13 02:29:28', 'Court 1', 'Badminton', 'declined'),
	(90, '2023-09-13 10:28:00', '2023-09-13 02:30:24', 'Court 1', 'Badminton', 'declined'),
	(91, '2023-09-13 10:28:00', '2023-09-13 02:30:36', 'Court 1', 'Badminton', 'declined'),
	(92, '2023-09-13 10:28:00', '2023-09-13 02:32:05', 'Court 1', 'Badminton', 'declined'),
	(93, '2023-09-13 10:28:00', '2023-09-13 02:33:14', 'Court 1', 'Badminton', 'declined'),
	(94, '2023-09-13 10:28:00', '2023-09-13 02:33:23', 'Court 1', 'Badminton', 'declined'),
	(95, '2023-09-13 00:28:00', '2023-09-13 02:43:37', 'Court 1', 'Badminton', 'declined'),
	(96, '2023-09-26 05:28:00', '2023-09-13 02:49:10', 'Court 1', 'Badminton', 'declined'),
	(97, '2023-09-13 02:28:00', '2023-09-13 03:24:30', 'Court 1', 'Badminton', 'declined'),
	(98, '2023-10-04 03:28:00', '2023-09-13 03:25:24', 'Court 1', 'Badminton', 'declined'),
	(99, '2023-10-06 03:28:00', '2023-09-13 03:25:27', 'Court 1', 'Badminton', 'declined'),
	(100, '2023-10-07 03:28:00', '2023-09-13 03:25:29', 'Court 1', 'Badminton', 'declined'),
	(101, '2023-09-14 18:27:00', '2023-09-13 06:28:42', 'Court 1', 'Badminton', 'declined'),
	(102, '2023-10-13 19:17:50', '2023-08-26 02:41:50', 'Court 1', 'Badminton', 'declined'),
	(103, '2023-09-18 00:23:06', '2023-08-18 12:42:06', 'Court 1', 'Badminton', 'declined'),
	(104, '2023-09-19 13:42:00', '2023-09-18 05:42:15', 'Court 3', 'Badminton', 'declined'),
	(105, '2023-09-26 04:32:23', '2023-09-01 15:49:23', 'Court 1', 'Badminton', 'declined'),
	(106, '2023-09-26 02:07:25', '2023-08-27 11:39:25', 'Court 1', 'Badminton', 'declined'),
	(107, '2023-10-05 19:18:37', '2023-09-07 01:02:37', 'Court 1', 'Badminton', 'declined'),
	(108, '2023-10-12 12:20:38', '2023-09-09 11:01:38', 'Court 1', 'Badminton', 'declined'),
	(109, '2023-09-25 11:13:09', '2023-09-01 17:24:09', 'Court 1', 'Badminton', 'declined'),
	(110, '2023-09-26 14:47:00', '2023-09-25 09:26:08', 'Court 5', 'Badminton', 'declined'),
	(111, '2023-10-31 11:00:00', '2023-10-18 08:12:32', 'Court 1', 'Badminton', 'declined'),
	(112, '2023-10-20 09:00:00', '2023-10-17 08:08:05', 'Court 1', 'Badminton', 'declined');

-- Dumping structure for table bbcdb.future
CREATE TABLE IF NOT EXISTS `future` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reserved_datetime` datetime NOT NULL,
  `created_at` timestamp NOT NULL,
  `court` text,
  `sport` text,
  `status` enum('approved','declined','canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'approved',
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` longblob,
  `qr_code` longblob,
  `hours` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=278 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbcdb.future: ~1 rows (approximately)
INSERT INTO `future` (`id`, `reserved_datetime`, `created_at`, `court`, `sport`, `status`, `user_name`, `user_email`, `image`, `qr_code`, `hours`) VALUES
	(275, '2023-10-28 00:00:00', '2023-11-01 11:02:40', 'Court 1', 'Badminton', 'approved', 'pat', 'garciapatrick341@gmail.com', _binary 0x2e2f7061796d656e742f3339353539353130315f313631313933323938353838323036355f353231353538373739353030353135383733395f6e2e6a7067, NULL, 0),
	(276, '2023-11-02 00:00:00', '2023-11-01 11:58:19', 'Court 5', 'Badminton', 'approved', 'pat', 'garciapatrick341@gmail.com', _binary 0x2e2f7061796d656e742f3339353539353130315f313631313933323938353838323036355f353231353538373739353030353135383733395f6e2e6a7067, NULL, 0),
	(277, '2023-11-16 00:00:00', '2023-11-01 12:04:52', 'Court 1', 'Badminton', 'approved', 'pat', 'garciapatrick341@gmail.com', _binary 0x2e2f7061796d656e742f, NULL, 6);

-- Dumping structure for event bbcdb.MoveFutureReservations
DELIMITER //
CREATE EVENT `MoveFutureReservations` ON SCHEDULE EVERY 5 SECOND STARTS '2023-09-20 08:15:34' ON COMPLETION PRESERVE ENABLE DO BEGIN
  -- Get the current date
  DECLARE currentDate DATE;
  SET currentDate = CURDATE();
  
  -- Move reservations from future to ongoing
  INSERT INTO ongoing (reserved_datetime, created_at, court, sport)
  SELECT reserved_datetime, created_at, court, sport
  FROM future
  WHERE DATE(reserved_datetime) = currentDate;
  
  -- Delete the moved reservations from the future table
  DELETE FROM future
  WHERE DATE(reserved_datetime) = currentDate;
END//
DELIMITER ;

-- Dumping structure for table bbcdb.ongoing
CREATE TABLE IF NOT EXISTS `ongoing` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reserved_datetime` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `court` text COLLATE utf8mb4_general_ci,
  `sport` text COLLATE utf8mb4_general_ci,
  `status` enum('today','finished','canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'today',
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` longblob,
  `qr_code` longblob,
  `hours` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=271 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bbcdb.ongoing: ~0 rows (approximately)

-- Dumping structure for table bbcdb.regular courts
CREATE TABLE IF NOT EXISTS `regular courts` (
  `court_id` int NOT NULL AUTO_INCREMENT,
  `court_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('ongoing','available','unavailable') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'available',
  `price` decimal(10,2) NOT NULL DEFAULT '210.00',
  PRIMARY KEY (`court_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbcdb.regular courts: ~5 rows (approximately)
INSERT INTO `regular courts` (`court_id`, `court_number`, `status`, `price`) VALUES
	(4, 'Court 4', 'available', 210.00),
	(5, 'Court 5', 'available', 210.00),
	(6, 'Court 6', 'available', 210.00),
	(7, 'Court 7', 'available', 210.00),
	(8, 'Court 8', 'available', 210.00);

-- Dumping structure for table bbcdb.reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reserved_datetime` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','approved','declined') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '',
  `court` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `sport` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `image` longblob,
  `hours` int NOT NULL,
  `qr_code` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1378 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bbcdb.reservations: ~2 rows (approximately)
INSERT INTO `reservations` (`id`, `reserved_datetime`, `created_at`, `status`, `user_name`, `user_email`, `court`, `sport`, `image`, `hours`, `qr_code`) VALUES
	(1374, '2023-11-03 00:00:00', '2023-10-27 06:36:48', 'pending', 'pat', 'garciapatrick341@gmail.com', 'Court 1', 'Badminton', _binary 0x2e2f7061796d656e742f, 5, NULL),
	(1376, '2023-11-21 00:00:00', '2023-11-01 19:04:29', 'pending', 'pat', 'garciapatrick341@gmail.com', 'Court 1', 'Badminton', _binary 0x2e2f7061796d656e742f, 6, NULL);

-- Dumping structure for table bbcdb.special courts
CREATE TABLE IF NOT EXISTS `special courts` (
  `court_id` int NOT NULL AUTO_INCREMENT,
  `court_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('ongoing','available','unavailable') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'available',
  `price` decimal(10,2) NOT NULL DEFAULT '250.00',
  PRIMARY KEY (`court_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbcdb.special courts: ~3 rows (approximately)
INSERT INTO `special courts` (`court_id`, `court_number`, `status`, `price`) VALUES
	(1, 'Court 1', 'available', 250.00),
	(2, 'Court 2', 'available', 250.00),
	(3, 'Court 3', 'available', 250.00);

-- Dumping structure for table bbcdb.sports
CREATE TABLE IF NOT EXISTS `sports` (
  `sport_id` int NOT NULL AUTO_INCREMENT,
  `sport_name` varchar(50) NOT NULL,
  PRIMARY KEY (`sport_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbcdb.sports: ~4 rows (approximately)
INSERT INTO `sports` (`sport_id`, `sport_name`) VALUES
	(1, 'Badminton'),
	(2, 'Pickleball'),
	(3, 'Table Tennis'),
	(4, 'Darts');

-- Dumping structure for table bbcdb.today
CREATE TABLE IF NOT EXISTS `today` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reserved_datetime` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','approved','declined') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `court` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `sport` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=803 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbcdb.today: ~1 rows (approximately)
INSERT INTO `today` (`id`, `reserved_datetime`, `created_at`, `status`, `court`, `sport`) VALUES
	(798, '2023-10-30 00:00:00', '2023-10-27 06:33:43', 'pending', 'Court 5', 'Badminton'),
	(799, '2023-10-28 00:00:00', '2023-10-27 09:28:20', 'pending', 'Court 1', 'Badminton'),
	(800, '2023-10-28 00:00:00', '2023-10-27 06:33:27', 'pending', 'Court 1', 'Badminton'),
	(801, '2023-11-02 00:00:00', '2023-10-27 06:33:48', 'pending', 'Court 5', 'Badminton'),
	(802, '2023-11-16 00:00:00', '2023-11-01 19:04:35', 'pending', 'Court 1', 'Badminton');

-- Dumping structure for table bbcdb.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email_verified` tinyint(1) DEFAULT '0',
  `email_verification_token` varchar(255) DEFAULT NULL,
  `qr_code_secret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_verification_token` (`email_verification_token`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbcdb.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`, `email_verified`, `email_verification_token`, `qr_code_secret`) VALUES
	(1, 'pat', 'garciapatrick341@gmail.com', '123', 'admin', '2023-10-02 07:39:11', '2023-10-23 08:44:26', 0, NULL, '9zUbhG6zgaf0pybH'),
	(35, 'pat', 'patrickjeri.garcia@sdca.edu.ph', '100000000000000', 'user', '2023-10-17 01:35:07', '2023-10-23 08:45:03', 1, '(NULL)', '4UmOVKfCQZqli9p2'),
	(56, 'pat', 'patrickjeri.garcia@gmail.com', '1234567890', 'user', '2023-10-20 05:30:31', '2023-10-23 06:08:52', 0, '8969dffa53a1cc0a9760e356080f7309', '8969dffa53a1cc0a9760e356080f7309');

-- Dumping structure for table bbcdb.users2
CREATE TABLE IF NOT EXISTS `users2` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `qr_code_data` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbcdb.users2: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
