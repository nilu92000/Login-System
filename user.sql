-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 06, 2025 at 04:57 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `otp_verification`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `uid` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `signup_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL,
  `employee_id` int NOT NULL,
  `security_question` varchar(255) NOT NULL,
  `security_answer` varchar(255) NOT NULL,
  `otp_sent` tinyint(1) DEFAULT '0',
  `phone_number` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `user_id` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `name`, `email`, `password`, `otp`, `is_verified`, `reset_token`, `token_expiry`, `signup_time`, `status`, `employee_id`, `security_question`, `security_answer`, `otp_sent`, `phone_number`, `address`, `user_id`) VALUES
(0, 'nimisha', 'niluverma378@gmail.com', '$2y$10$bHUyBJw3RGKihc4cd6ehGOepkuH7RJshuBhsSzdcXPrXvrLziMeG6', NULL, 1, NULL, NULL, '2024-12-28 12:33:23', '', 1234, 'What is your mother\'s maiden name?', '$2y$10$MqZ.Li6SpMtseJHiScYZTufgSNRCWv/m6xMbv4bc6x6Ygu9J5Iz0i', 0, '', '', ''),
(0, 'Ellife', 'elliferevolution@gmail.com', '$2y$10$Fn92JPL745okQx.vAy5kbexg.HoeOdKul0xHlBuDHPdohrxONyhwC', NULL, 1, NULL, NULL, '2024-11-29 04:38:26', '', 0, '', '', 0, '', '', ''),
(0, 'laxmi', 'ak1801435@gmail.com', '$2y$10$hVfLWX/vgTBc1KHzhyVY1eZ7ftDPPRT0Xm8JkJfLzwrOAnydevVq2', NULL, 1, NULL, NULL, '2024-12-28 12:46:28', '', 3421, 'What is your mother\'s maiden name?', '$2y$10$eeEU5AZDaNvQfOuxuW.0yuI1FRRd9dc6hGTWBh7nCsGCvQ.OH21sm', 0, '', '', ''),
(0, 'Twinkle Kumari', 'twinklesah2001@gmail.com', '$2y$10$EBjydYH13WgVnAahbD3snOFJvbFN.9k2MC2Y.909hHsQA7LX46Fm.', '315732', 1, NULL, NULL, '2024-12-30 10:40:53', '', 10659, 'What was the name of your first pet?', '$2y$10$4a3yA9gOPuOdR3DoVwYQBeV/OvkACKPKjuJPaVeidXcaYuopF.yHS', 0, '', '', ''),
(0, 'jh', 'knh@gmail.com', '$2y$10$stlWKsJ6sRdEFukoPe/RGuUYChkGraJPCiLX9JFiuS9AV97Bqs2dS', '105079', 0, NULL, NULL, '0000-00-00 00:00:00', '', 0, 'What was the name of your first pet?', '$2y$10$h9fsJTMe.kuQJynNrkdvs.1NwRXeZB6.XRjvFnj6d6VFOpk4qLjFG', 0, '', '', ''),
(0, 'Nilu verma', 'roshanprasad434@gmail.com', '$2y$10$lKSno.3yHf0dqymChR/VtuvO2w/P8zS1sK0rRKcJnOKCX6BIIW4QO', '635011', 0, NULL, NULL, '0000-00-00 00:00:00', '', 984, 'What is your mother\'s maiden name?', '$2y$10$JphX4rWn1Udd.eHkB4O9De9ZQI.cjHrv7Mhz.KwY4I4ZGw3zR2lSu', 0, '', '', ''),
(0, 'Nilu Kumari verma', 'vermanilu92000@gmail.com', '$2y$10$GZuyUUFPjvTowSQc7Khg1ebZIFSl.oteYtwp5LZfRUZENaDMrxu4q', '245772', 1, NULL, NULL, '2025-01-31 05:09:11', '', 0, 'What is your mother\'s maiden name?', '$2y$10$F9A.Noz327mCwR57H9RGGOe4/S7OQlnHU1PyEw/oD3.9WBCIxF0hW', 0, '', '', ''),
(0, 'NILU KUMARI VERMA', 'niluv0368@gmail.com', '$2y$10$HFew476Uyj.o37p1vpUwKuZb2wyXP3KUlPzrbx0xHdgjKP2nRAOlG', '278243', 1, NULL, NULL, '2025-11-06 14:36:37', '', 10107, 'What is your mother\'s maiden name?', '$2y$10$McDS.Vkj7gEuSwi45vZdC.qKZ5AvXySVEV.cd32w/1Valr6gJcwzq', 0, '', '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
