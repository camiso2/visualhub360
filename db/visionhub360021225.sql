-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2025 a las 02:54:48
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `visionhub360`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounts_receivables`
--

CREATE TABLE `accounts_receivables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `payment_provider_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `paid_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','billed','paid','canceled') NOT NULL DEFAULT 'pending',
  `due_date` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `accounts_receivables`
--

INSERT INTO `accounts_receivables` (`id`, `company_id`, `branch_id`, `sale_id`, `payment_provider_id`, `client_id`, `amount`, `paid_amount`, `status`, `due_date`, `deleted_at`, `created_at`, `updated_at`) VALUES
(17, 27, 16, 100, 30, 22, 565250.00, 0.00, 'pending', NULL, NULL, '2025-11-20 02:37:35', '2025-11-20 02:37:35'),
(18, 27, 16, 100, 30, 22, 565250.00, 0.00, 'pending', NULL, NULL, '2025-11-20 02:37:35', '2025-11-20 02:37:35'),
(19, 27, 16, 102, 44, 22, 565250.00, 0.00, 'pending', NULL, NULL, '2025-11-20 02:38:43', '2025-11-20 02:38:43'),
(20, 27, 16, 102, 44, 22, 565250.00, 0.00, 'pending', NULL, NULL, '2025-11-20 02:38:43', '2025-11-20 02:38:43'),
(21, 27, 16, 104, 34, 22, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-20 20:06:48', '2025-11-20 20:06:48'),
(22, 27, 16, 106, 34, 22, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-20 20:12:11', '2025-11-20 20:12:11'),
(23, 27, 16, 106, 34, 22, 249375.00, 0.00, 'pending', NULL, NULL, '2025-11-20 20:12:11', '2025-11-20 20:12:11'),
(24, 27, 16, 108, 34, 22, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-20 20:12:59', '2025-11-20 20:12:59'),
(25, 27, 16, 109, 34, 22, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-20 20:15:12', '2025-11-20 20:15:12'),
(26, 27, 16, 110, 34, 22, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-20 20:16:06', '2025-11-20 20:16:06'),
(27, 27, 16, 111, 30, 22, 565250.00, 0.00, 'pending', NULL, NULL, '2025-11-21 06:20:40', '2025-11-21 06:20:40'),
(28, 27, 16, 147, 30, 19, 127680.00, 0.00, 'pending', NULL, NULL, '2025-11-21 08:00:01', '2025-11-21 08:00:01'),
(29, 27, 16, 147, 30, 19, 127680.00, 0.00, 'pending', NULL, NULL, '2025-11-21 08:00:01', '2025-11-21 08:00:01'),
(30, 27, 16, 148, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 08:00:58', '2025-11-21 08:00:58'),
(31, 27, 16, 148, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 08:00:58', '2025-11-21 08:00:58'),
(32, 27, 16, 149, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 08:26:33', '2025-11-21 08:26:33'),
(33, 27, 16, 149, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 08:26:33', '2025-11-21 08:26:33'),
(34, 27, 16, 150, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 08:32:14', '2025-11-21 08:32:14'),
(35, 27, 16, 150, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 08:32:14', '2025-11-21 08:32:14'),
(36, 27, 16, 152, 30, 19, 361760.00, 0.00, 'pending', NULL, NULL, '2025-11-21 08:51:12', '2025-11-21 08:51:12'),
(37, 27, 16, 152, 30, 19, 361760.00, 0.00, 'pending', NULL, NULL, '2025-11-21 08:51:12', '2025-11-21 08:51:12'),
(38, 27, 16, 155, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:23:58', '2025-11-21 09:23:58'),
(39, 27, 16, 155, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:23:58', '2025-11-21 09:23:58'),
(40, 27, 16, 156, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:24:26', '2025-11-21 09:24:26'),
(41, 27, 16, 156, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:24:26', '2025-11-21 09:24:26'),
(42, 27, 16, 157, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:24:54', '2025-11-21 09:24:54'),
(43, 27, 16, 157, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:24:54', '2025-11-21 09:24:54'),
(44, 27, 16, 158, 30, 19, 297500.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:25:15', '2025-11-21 09:25:15'),
(45, 27, 16, 158, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:25:15', '2025-11-21 09:25:15'),
(46, 27, 16, 159, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:28:37', '2025-11-21 09:28:37'),
(47, 27, 16, 159, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:28:37', '2025-11-21 09:28:37'),
(48, 27, 16, 160, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:29:38', '2025-11-21 09:29:38'),
(49, 27, 16, 160, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:29:38', '2025-11-21 09:29:38'),
(50, 27, 16, 161, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:32:04', '2025-11-21 09:32:04'),
(51, 27, 16, 161, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:32:04', '2025-11-21 09:32:04'),
(52, 27, 16, 162, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:32:37', '2025-11-21 09:32:37'),
(53, 27, 16, 162, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:32:37', '2025-11-21 09:32:37'),
(54, 27, 16, 163, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:33:48', '2025-11-21 09:33:48'),
(55, 27, 16, 163, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:33:48', '2025-11-21 09:33:48'),
(56, 27, 16, 164, 30, 33, 297500.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:37:16', '2025-11-21 09:37:16'),
(57, 27, 16, 164, 30, 33, 247000.00, 0.00, 'pending', NULL, NULL, '2025-11-21 09:37:16', '2025-11-21 09:37:16'),
(58, 27, 16, 165, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 13:15:11', '2025-11-21 13:15:11'),
(59, 27, 16, 165, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 13:15:11', '2025-11-21 13:15:11'),
(60, 27, 16, 166, 30, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-21 13:16:21', '2025-11-21 13:16:21'),
(61, 27, 16, 166, 30, 19, 234650.00, 0.00, 'pending', NULL, NULL, '2025-11-21 13:16:21', '2025-11-21 13:16:21'),
(62, 27, 16, 171, 28, 19, 297500.00, 0.00, 'pending', NULL, NULL, '2025-11-24 23:27:20', '2025-11-24 23:27:20'),
(63, 27, 16, 172, 28, 19, 297500.00, 0.00, 'pending', NULL, NULL, '2025-11-24 23:28:09', '2025-11-24 23:28:09'),
(64, 27, 16, 183, 42, 19, 297500.00, 0.00, 'pending', NULL, NULL, '2025-11-25 00:49:57', '2025-11-25 00:49:57'),
(65, 27, 16, 184, 35, 19, 297500.00, 0.00, 'pending', NULL, NULL, '2025-11-25 00:55:18', '2025-11-25 00:55:18'),
(66, 27, 16, 186, 39, 19, 297500.00, 0.00, 'pending', NULL, NULL, '2025-11-25 01:00:41', '2025-11-25 01:00:41'),
(67, 27, 16, 188, 43, 19, 297500.00, 0.00, 'pending', NULL, NULL, '2025-11-25 01:11:11', '2025-11-25 01:11:11'),
(68, 27, 16, 189, 43, 19, 297500.00, 0.00, 'pending', NULL, NULL, '2025-11-25 01:13:18', '2025-11-25 01:13:18'),
(69, 27, 16, 190, 36, 19, 297500.00, 0.00, 'pending', NULL, NULL, '2025-11-25 01:25:45', '2025-11-25 01:25:45'),
(70, 27, 16, 190, 33, 19, 297500.00, 0.00, 'pending', NULL, NULL, '2025-11-25 01:25:45', '2025-11-25 01:25:45'),
(71, 27, 16, 191, 41, 19, 166600.00, 0.00, 'pending', NULL, NULL, '2025-11-25 01:30:10', '2025-11-25 01:30:10'),
(72, 27, 16, 191, 37, 19, 291550.00, 0.00, 'pending', NULL, NULL, '2025-11-25 01:30:10', '2025-11-25 01:30:10'),
(73, 27, 16, 195, 26, 19, 282625.00, 0.00, 'pending', NULL, NULL, '2025-11-25 03:55:29', '2025-11-25 03:55:29'),
(74, 27, 16, 195, 37, 19, 149940.00, 0.00, 'pending', NULL, NULL, '2025-11-25 03:55:29', '2025-11-25 03:55:29'),
(75, 27, 16, 197, 37, 19, 141610.00, 0.00, 'pending', NULL, NULL, '2025-11-25 05:57:52', '2025-11-25 05:57:52'),
(76, 27, 16, 198, 37, 19, 141610.00, 0.00, 'pending', NULL, NULL, '2025-11-25 05:59:23', '2025-11-25 05:59:23'),
(77, 27, 16, 199, 37, 19, 134529.50, 0.00, 'pending', NULL, NULL, '2025-11-25 06:01:21', '2025-11-25 06:01:21'),
(78, 27, 16, 204, 26, 19, 292740.00, 0.00, 'pending', NULL, NULL, '2025-11-25 07:18:28', '2025-11-25 07:18:28'),
(79, 27, 16, 204, 44, 19, 119000.00, 0.00, 'pending', NULL, NULL, '2025-11-25 07:18:28', '2025-11-25 07:18:28'),
(80, 27, 16, 205, 26, 19, 283957.80, 0.00, 'pending', NULL, NULL, '2025-11-25 07:20:01', '2025-11-25 07:20:01'),
(81, 27, 16, 205, 44, 19, 113050.00, 0.00, 'pending', NULL, NULL, '2025-11-25 07:20:01', '2025-11-25 07:20:01'),
(82, 27, 16, 208, 44, 19, 113050.00, 0.00, 'pending', NULL, NULL, '2025-11-25 07:37:29', '2025-11-25 07:37:29'),
(83, 27, 16, 208, 44, 19, 283957.80, 0.00, 'pending', NULL, NULL, '2025-11-25 07:37:29', '2025-11-25 07:37:29'),
(84, 27, 16, 209, 44, 19, 113050.00, 0.00, 'pending', NULL, NULL, '2025-11-25 07:40:53', '2025-11-25 07:40:53'),
(85, 27, 16, 209, 44, 19, 283957.80, 0.00, 'pending', NULL, NULL, '2025-11-25 07:40:53', '2025-11-25 07:40:53'),
(86, 27, 16, 210, 28, 19, 113050.00, 0.00, 'pending', NULL, NULL, '2025-11-25 07:46:58', '2025-11-25 07:46:58'),
(87, 27, 16, 211, 28, 19, 113050.00, 0.00, 'pending', NULL, NULL, '2025-11-25 07:58:31', '2025-11-25 07:58:31'),
(88, 27, 16, 212, 28, 19, 113050.00, 0.00, 'pending', NULL, NULL, '2025-11-25 07:59:52', '2025-11-25 07:59:52'),
(89, 27, 16, 212, 44, 19, 283957.80, 0.00, 'pending', NULL, NULL, '2025-11-25 07:59:52', '2025-11-25 07:59:52'),
(90, 27, 16, 213, 43, 19, 139051.50, 0.00, 'pending', NULL, NULL, '2025-11-25 08:31:01', '2025-11-25 08:31:01'),
(91, 27, 16, 213, 44, 19, 107100.00, 0.00, 'pending', NULL, NULL, '2025-11-25 08:31:01', '2025-11-25 08:31:01'),
(92, 27, 16, 216, 27, 19, 141978.90, 0.00, 'pending', NULL, NULL, '2025-11-25 21:04:55', '2025-11-25 21:04:55'),
(93, 27, 16, 216, 43, 19, 113050.00, 0.00, 'pending', NULL, NULL, '2025-11-25 21:04:55', '2025-11-25 21:04:55'),
(94, 27, 16, 217, 26, 35, 346290.00, 0.00, 'pending', NULL, NULL, '2025-11-26 01:03:00', '2025-11-26 01:03:00'),
(95, 28, 19, 220, 124, 14, 117599.99, 0.00, 'pending', NULL, NULL, '2025-11-26 21:10:48', '2025-11-26 21:10:48'),
(96, 28, 22, 223, 130, 5, 63000.00, 0.00, 'pending', NULL, NULL, '2025-11-26 23:21:50', '2025-11-26 23:21:50'),
(97, 28, 19, 224, 119, 5, 734999.99, 0.00, 'pending', NULL, NULL, '2025-11-27 01:39:58', '2025-11-27 01:39:58'),
(98, 28, 19, 226, 129, 42, 345000.00, 0.00, 'pending', NULL, NULL, '2025-11-27 04:01:46', '2025-11-27 04:01:46'),
(99, 28, 19, 230, 128, 58, 1749300.00, 10.00, 'paid', NULL, NULL, '2025-11-29 04:06:41', '2025-11-29 04:06:41'),
(100, 28, 54, 232, 125, 56, 6751691.10, 1000.00, 'paid', NULL, NULL, '2025-11-29 04:21:45', '2025-11-29 04:21:45'),
(101, 28, 19, 235, 136, 56, 5912515.00, 5812515.00, 'paid', NULL, NULL, '2025-11-29 19:38:14', '2025-11-29 19:38:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `branches`
--

INSERT INTO `branches` (`id`, `company_id`, `name`, `code`, `phone`, `email`, `image`, `address`, `city`, `department`, `active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(16, 27, 'nueva sucursal de Armenia', '2GQIYF', '3174885954', 'camiso2@gmail.com', '/branches/branch_b104dbd4-bd70-4986-ac43-0e0104882373.jpeg', 'Urb villa liliana', 'Armenia', 'Quindío', 1, NULL, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(17, 27, 'Sucursal Centro vfd', 'DLAQ91', '3001234567', 'sucursalvfd@empresa.com', '/branches/d62655eb-9881-49ac-9a17-85149e54ecfb.jpg', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 1, NULL, '2025-11-15 11:52:42', '2025-11-15 11:52:42'),
(18, 27, 'Sucursal Centro pio', 'FVP9UD', '3001234567', 'sucursalpio@empresa.com', '/branches/2d5c2744-df2d-4f6e-9c0f-97203dd23291.jpg', 'Calle 123 #45-69', 'Armenia', 'Quindío', 1, NULL, '2025-11-15 11:56:48', '2025-11-15 11:56:48'),
(19, 28, 'nueva sucursal de mavebo', 'PZEYWV', '3174885954', 'camiso2@gmail.com', '/branches/branch_e3d09a62-5700-467b-821b-ce544aac7300.jpg', 'Urb villa liliana', 'Armenia', 'Quindío', 1, NULL, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(20, 27, 'Sucursal Centro mar', 'MXOPGR', '3001234567', 'sucursamar@empresa.com', '/branches/6878fc46-b14a-49f0-af5d-cb7e2fae49d5.jpg', 'Calle 123 #45-69', 'Armenia', 'Quindío', 1, NULL, '2025-11-15 12:05:58', '2025-11-15 12:05:58'),
(21, 28, 'Sucursal Centro mar2', 'MEFKFN', '3001234567', 'sucursamar2@empresa.com', '/branches/c4ad123b-c66b-4d33-a22c-beea1d78faf0.jpg', 'Calle 123 #45-69', 'Armenia', 'Quindío', 1, NULL, '2025-11-15 22:09:26', '2025-11-15 22:09:26'),
(22, 28, 'Sucursal Centro mar3', 'BZVBPU', '3001234567', 'sucursamar3@empresa.com', '/branches/4ba5c3b6-0cae-4615-9226-c24fb292782e.jpg', 'Calle 123 #45-69', 'Armenia', 'Quindío', 1, NULL, '2025-11-15 22:14:28', '2025-11-15 22:14:28'),
(47, 28, 'nueva sucursal de Medellín', 'XXG7VP', '3124569878', 'maveboArmenia@gmail.com', '/branches/d4c3241c-be97-4263-8b35-ddc8c32f1c8d.jpeg', 'Centro calle 13', 'Armenia', 'Quindío', 1, NULL, '2025-11-15 23:35:21', '2025-11-15 23:35:21'),
(48, 28, 'nueva sucursal de Medellín', 'HWCPM4', '3174885954', 'camiso2ooo@gmail.com', '/branches/c33eef8e-eb7a-4d4f-a625-919ab22d32c1.jpg', 'Urb villa liliana', 'Armenia', 'Quindío', 1, NULL, '2025-11-15 23:37:09', '2025-11-15 23:37:09'),
(49, 28, 'nueva sucursal de Medellín', '4MB10E', '3174885954', 'df@gmail.com', '/branches/104e831b-e43e-4999-abfa-4ec8cd507621.jpg', 'Urb villa liliana', 'Armenia', 'Quindío', 1, NULL, '2025-11-16 00:04:42', '2025-11-16 00:04:42'),
(50, 28, 'nueva sucursal de Medellín', 'CJGJ4A', '3174885954', 'ewewe@gmail.com', '/branches/6959445f-f2d0-4fb1-b0b3-34c1316c25b1.jpg', 'Urb villa liliana', 'Armenia', 'Quindío', 1, NULL, '2025-11-16 00:04:48', '2025-11-16 00:04:48'),
(51, 28, 'nueva sucursal de Medellín', 'V0XM43', '3174885954', 'rererewe@gmail.com', '/branches/57fb3af8-9843-4a14-8670-610560c856fd.jpg', 'Urb villa liliana', 'Armenia', 'Quindío', 1, NULL, '2025-11-16 00:04:57', '2025-11-16 00:04:57'),
(52, 28, 'nueva sucursal de Medellín 52 id', '6SYKA1', '3174885954', 'rerereeeeewe@gmail.com', '/branches/1345b292-27c2-4992-b0f4-6dfe86a8cfea.jpg', 'Urb villa liliana', 'Armenia', 'Quindío', 1, NULL, '2025-11-16 00:05:18', '2025-11-16 00:05:18'),
(53, 28, 'nueva sucursal de Armenia jjjj', 'R1KJXF', '3174885954', 'camiso2hhhh@gmail.com', '/branches/93d4d3f4-7706-445d-82d7-377178672dcb.jpg', 'Urb villa liliana', 'Armenia', 'Quindío', 1, NULL, '2025-11-18 00:26:17', '2025-11-18 00:26:17'),
(54, 28, 'nueva sucursal de mavebo nnnn', 'AVUNRF', '3174885954', 'camisyyyyyo2@gmail.com', '/branches/928ca688-de6c-4861-bd53-4ba007f31823.jpeg', 'Urb villa liliana', 'Armenia', 'Quindío', 1, NULL, '2025-11-19 01:00:37', '2025-11-19 01:00:37'),
(55, 28, 'nueva sucursal de Medellín tggtgggf', 'Y4DGNZ', '3174885954', 'camisoeeeeeee@gmail.com', NULL, 'Urb villa liliana', 'Armenia', 'Quindío', 1, NULL, '2025-11-19 01:01:27', '2025-11-19 01:01:27'),
(56, 28, 'nueva sucursal de Medellín', 'XRVPQZ', '3174885954', 'camisogfgffg2@gmail.com', NULL, 'Urb villa liliana', 'Armenia', NULL, 1, NULL, '2025-11-19 01:01:57', '2025-11-19 01:01:57'),
(57, 27, 'xxxxxxxxxxxx', 'YZYWPW', '3174885954', 'xxxxxxxxxxxxxxxx@gmail.com', NULL, 'Urb villa liliana', 'Armenia', 'xxxxxxxxxxxxx', 1, NULL, '2025-11-25 21:13:46', '2025-11-25 21:13:46'),
(58, 27, 'vvvvvvvvvvvv', 'C35SLT', '3174885954', 'vvvvvvvvvvvvvv@gmail.com', NULL, 'Urb villa liliana', 'Armenia', 'vvvvvvvvvv', 1, NULL, '2025-11-25 21:15:57', '2025-11-25 21:15:57'),
(59, 27, 'qqqqqqqqqq', 'L5SEQP', '3174885954', 'qqqqqqqqqqqqqqq@gmail.com', '/branches/09f8d207-4a95-4432-a48f-9e4b9adf56f5.jpg', 'Urb villa liliana', 'Armenia', 'qqqqqqqqqqqq', 1, NULL, '2025-11-25 21:16:37', '2025-11-25 21:16:37'),
(60, 27, 'ooooooooo', 'TWSMKY', '3174885954', 'ooooooooooooooo@gmail.com', '/branches/9dbaac2e-e1cc-473a-878f-c147d566fe81.jpg', 'Urb villa liliana', 'Armenia', 'oooooooooooooo', 1, NULL, '2025-11-25 21:17:26', '2025-11-25 21:17:26'),
(61, 28, 'nueva sucursal de Medellín 3333', 'SLNO0L', '3124587896', 'nuevamed2@gmail.com', NULL, 'centro', 'Armenia', 'Quindío', 1, NULL, '2025-11-27 06:51:22', '2025-11-27 06:51:22'),
(62, 28, 'nueva sucursal de Medellín 444', 'XR7YKG', '3124587896', 'nuevamed4@gmail.com', '/branches/51f66926-8568-49c5-b2af-9e9dcd5ee7b0.jpg', 'centro', 'Armenia', 'Quindío', 1, NULL, '2025-11-27 06:51:57', '2025-11-27 06:51:57'),
(63, 28, 'cambia nombre', 'J12HMW', '3171322112', 'testsucursal@gmail.com', NULL, 'Urb villa liliana', 'Leticia', 'Amazonas', 1, NULL, '2025-12-02 08:52:49', '2025-12-02 08:59:43'),
(64, 28, 'Alfred  hitchcok', 'JNZYE8', '3174881245', 'fred@gmail.com', '/branches/a1b549ba-383d-44c6-a6da-de16018f5149.jpg', 'Urb villa liliana', 'Armenia', 'Antioquia', 1, NULL, '2025-12-02 09:02:16', '2025-12-02 09:23:28'),
(65, 28, 'wertre', '7UPFHG', '3174885954', 'wrte@gmail.com', '/branches/d86bf36f-4f2e-40ea-b3e5-c8fc74387e7c.jpeg', 'Urb villa liliana', 'Abejorral', 'Antioquia', 1, NULL, '2025-12-02 09:23:52', '2025-12-02 22:23:26'),
(66, 28, 'wwwwww', 'TREKNT', '3174885954', 'wwwww@gmail.com', '/branches/117330eb-0331-4be9-a25e-17349bf02f8f.jpg', 'Urb villa liliana', 'Leticia', 'Amazonas', 1, NULL, '2025-12-02 09:25:01', '2025-12-02 09:25:01'),
(67, 28, 'jaiver sucursal en armenia quindio, la mejor de la ciudad de Armneia', 'BANDNL', '3174885954', 'sucursaljaiver@gmail.com', '/branches/e4ca61bf-ce92-4c00-8848-6f8fc9eacf28.jpeg', 'Urb villa liliana', 'Medellín', 'Antioquia', 1, NULL, '2025-12-02 09:25:09', '2025-12-02 22:23:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `document_type` varchar(255) DEFAULT NULL,
  `document_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id`, `company_id`, `branch_id`, `branch_code`, `name`, `email`, `phone`, `document_type`, `document_number`, `address`, `city`, `department`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 27, 16, NULL, 'test de cliente bubscar', 'john@example.com', '3001234567', 'CC', '123456789', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 1, '2025-11-15 01:30:09', '2025-11-15 01:30:09', NULL),
(4, 27, 16, NULL, 'camilo ocampo', 'camilo@example.com', '3001234567', 'CC', '1094569870', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 1, '2025-11-15 02:48:28', '2025-11-15 02:48:28', NULL),
(5, 28, 52, NULL, 'camilo ocampo', 'camilo@example.com', '3001234567', 'CC', '109456987', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 1, '2025-11-16 00:24:32', '2025-11-16 00:24:32', NULL),
(6, 28, 52, NULL, 'camilo ocampo hghtytt675767', 'camiloghhhghh@example.com', '3001234567', 'CC', '10945698766', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 1, '2025-11-16 00:25:18', '2025-11-16 00:25:18', NULL),
(7, 28, 19, NULL, 'test de cliente succompany 28', 'test28@example.com', '3001234567', 'CC', '461533987', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 1, '2025-11-17 22:14:42', '2025-11-17 22:14:42', NULL),
(8, 28, 22, NULL, 'test de cliente succompany 28 suc 22', 'test28-22@example.com', '3001234567', 'CC', '123654', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 1, '2025-11-17 22:24:02', '2025-11-17 22:24:02', NULL),
(9, 28, 52, NULL, 'test de cliente succompany 28 suc 52', 'test28-52@example.com', '3001234567', 'CC', '3214566', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 1, '2025-11-17 22:35:09', '2025-11-17 22:35:09', NULL),
(10, 28, 19, NULL, 'gggggggggggggg', 'ggggg@example.com', '3001234567', 'CC', '1234567789', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 1, '2025-11-18 22:48:37', '2025-11-18 22:48:37', NULL),
(11, 28, 19, NULL, 'hhhhhhhhhhhh', 'hhhhhhhhh@example.com', '3001234567', 'CC', '12394567789', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 1, '2025-11-18 22:48:50', '2025-11-18 22:48:50', NULL),
(12, 28, 19, NULL, 'pppppppppppp', 'ppppp@example.com', '3001234567', 'CC', '1239456567789', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 1, '2025-11-18 22:49:15', '2025-11-18 22:49:15', NULL),
(13, 28, 19, NULL, 'ppppppllllllpppppp', 'ppplpp@example.com', '3001234567', 'CC', '156567789', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 1, '2025-11-18 22:49:34', '2025-11-18 22:49:34', NULL),
(14, 28, 19, NULL, 'ggfgfg', 'camiso2@gmail.com', '3174885954', 'CC', '212121313', 'Urb villa liliana', 'Armenia', 'gfffggg', 1, '2025-11-19 01:08:06', '2025-11-19 01:08:06', NULL),
(15, 28, 19, NULL, 'ggfgfg', 'camisoee2@gmail.com', '3174885954', 'CC', '9', 'Urb villa liliana', 'Armenia', 'gfffggg', 1, '2025-11-19 01:08:47', '2025-11-19 01:08:47', NULL),
(16, 28, 19, NULL, 'uuuuuuuuuu', 'camiso2uuu@gmail.com', '3174885954', 'CC', '545455', 'Urb villa liliana', 'Armenia', 'uuuuuu', 1, '2025-11-19 01:09:39', '2025-11-19 01:09:39', NULL),
(17, 28, 19, NULL, 'uuuuuuuuuu', 'camiso2uuukkkk@gmail.com', '3174885954', 'CC', '545455kkkk', 'Urb villa liliana', 'Armenia', 'uuuuuu', 1, '2025-11-19 01:10:00', '2025-11-19 01:10:00', NULL),
(18, 28, 19, NULL, 'uuuuuuuuuu', 'camiso2uuukksskk@gmail.com', '3174885954', 'CC', '545455kkkksss', 'Urb villa liliana', 'Armenia', 'uuuuuu', 1, '2025-11-19 01:10:12', '2025-11-19 01:10:12', NULL),
(19, 27, 16, NULL, 'sofia  vejarano B.|', 'sofia@gmail.com', '317458796', 'CC', '4615339', 'mz m cs 2, urb villa liliana', 'Armenia', 'Quindío', 1, '2025-11-19 01:21:41', '2025-11-19 01:21:41', NULL),
(20, 27, 16, NULL, 'sssssss', 'camisosss2@gmail.com', '3174885954', 'CC', '2222222222', 'Urb villa liliana', 'Armenia', 'sssss', 1, '2025-11-19 02:55:37', '2025-11-19 02:55:37', NULL),
(21, 27, 16, NULL, 'xxxxxxxxxx', 'xxxxxxxxxxxxxx@gmail.com', '3174885954', 'CC', '11111111111111', 'Urb villa liliana', 'Armenia', 'xxxxxxxxxxx', 1, '2025-11-19 03:26:17', '2025-11-19 03:26:17', NULL),
(22, 27, 16, NULL, '222222222', 'bbbbbbbbbbbbb@gmail.com', '3174885954', 'CC', '112365478', 'Urb villa liliana', 'Armenia', '222222222222222222', 1, '2025-11-19 06:39:00', '2025-11-19 06:39:00', NULL),
(23, 27, 16, NULL, 'wwwwwwww', 'wwwwwwwwwwwwwww@gmail.com', '3174885954', 'CC', '102365489', 'Urb villa liliana', 'Armenia', 'quuindio', 1, '2025-11-20 21:59:37', '2025-11-20 21:59:37', NULL),
(24, 27, 16, NULL, 'ddddddd', 'ddddddddddddddso2@gmail.com', '3174885954', 'CC', '21123213213', 'Urb villa liliana', 'Armenia', 'Quindío', 1, '2025-11-20 22:00:59', '2025-11-20 22:00:59', NULL),
(25, 27, 16, NULL, 'qwwwwwwww', 'fggfgfgfgf@gmail.com', '3174885954', 'CC', '564546546', 'Urb villa liliana', 'Armenia', 'quindio', 1, '2025-11-20 22:08:22', '2025-11-20 22:08:22', NULL),
(26, 27, 16, NULL, 'qwwwwwwww', 'fggfgfg4fgf@gmail.com', '3174885954', 'CC', '44444', 'Urb villa liliana', 'Armenia', 'quindio', 1, '2025-11-20 22:08:49', '2025-11-20 22:08:49', NULL),
(27, 27, 16, NULL, 'rrrrrewrwerwer', 'werrwrwrw@gmail.com', '3174885954', 'CC', '145256456', 'Urb villa liliana', 'Armenia', 'werewrw', 1, '2025-11-20 22:10:18', '2025-11-20 22:10:18', NULL),
(28, 27, 16, NULL, 'iuiiu', 'c@f.co', '3174885954', 'CC', '8787678678', 'Urb villa liliana', 'Armenia', 'iuiiuiu', 1, '2025-11-20 23:01:51', '2025-11-20 23:01:51', NULL),
(29, 27, 16, NULL, 'iuoiuoui', 'camisiuouioo2@gmail.com', '3174885954', 'CC', '687687687', 'Urb villa liliana', 'Armenia', 'iuooiu', 1, '2025-11-20 23:04:40', '2025-11-20 23:04:40', NULL),
(30, 27, 16, NULL, 'ewewewe', 'eweewew@gmail.com', '3174885954', 'CC', '123131231', 'Urb villa liliana', 'Armenia', 'ewe', 1, '2025-11-20 23:06:25', '2025-11-20 23:06:25', NULL),
(31, 27, 16, NULL, 'lllll', 'camisoooooo2@gmail.com', '3174885954', 'CC', '1111', 'Urb villa liliana', 'Armenia', 'oooo', 1, '2025-11-20 23:06:54', '2025-11-20 23:06:54', NULL),
(32, 27, 16, NULL, 'fffffff', 'ffffffffffff@gmail.com', '3174885954', 'CC', '333333333333333', 'Urb villa liliana', 'Armenia', 'ffffffff', 1, '2025-11-20 23:18:49', '2025-11-20 23:18:49', NULL),
(33, 27, 16, NULL, '555555555', '5555555555@gmail.com', '3174885954', 'CC', '55555555555', 'Urb villa liliana', 'Armenia', '555555555', 1, '2025-11-20 23:20:24', '2025-11-20 23:20:24', NULL),
(34, 27, 16, NULL, 'kkkkkkk', 'kkkkkkkkkkkk@gmail.com', '3174885954', 'CC', '45545454', 'Urb villa liliana', 'Armenia', 'kkkkkkkkkkkk', 1, '2025-11-20 23:25:58', '2025-11-20 23:25:58', NULL),
(35, 27, 16, NULL, 'hhhhhhhhhhhhhh', 'hhhhhhhhhhh@gmail.com', '3174885954', 'CC', '12365897', 'Urb villa liliana', 'Armenia', 'hhhhhhhhhh', 1, '2025-11-25 21:19:33', '2025-11-25 21:19:33', NULL),
(42, 28, 19, NULL, 'pppppppppppppppp', 'p@gmail.com', '3174885954', 'CC', '1094569870', 'Urb villa liliana', 'Armenia', 'ppp', 1, '2025-11-26 23:51:40', '2025-11-26 23:51:40', NULL),
(43, 28, 19, NULL, 'test de componente registrando', 'testcomponente@gmail.com', '3174885954', 'CC', '1094000', 'Urb villa liliana', 'Armenia', 'test', 1, '2025-11-28 23:15:03', '2025-11-28 23:15:03', NULL),
(44, 28, 19, NULL, 'test', 'testcomp@gmail.com', '3174885954', 'CC', '419440000', 'Urb villa liliana', 'Armenia', 'test', 1, '2025-11-28 23:16:29', '2025-11-28 23:16:29', NULL),
(45, 28, 19, NULL, 'tes', 'sss@gmail.com', '3174885954', 'CC', '2222222222', 'Urb villa liliana', 'Armenia', 'ssss', 1, '2025-11-28 23:23:03', '2025-11-28 23:23:03', NULL),
(46, 28, 19, NULL, 'rrrrrrr', '555@gmail.com', '3174885954', 'CC', '45646456', 'Urb villa liliana', 'Armenia', '454546', 1, '2025-11-28 23:26:00', '2025-11-28 23:26:00', NULL),
(47, 28, 19, NULL, 'rrrrrrr', 'rrrrrr@gmail.com', '3174885954', 'CC', '2112212121', 'Urb villa liliana', 'Armenia', 'rr', 1, '2025-11-28 23:28:30', '2025-11-28 23:28:30', NULL),
(48, 28, 19, NULL, 'rrrr', 'wqwqw@gmail.com', '3174885954', 'CC', '5454554', 'Urb villa liliana', 'Armenia', 'wwww', 1, '2025-11-28 23:31:24', '2025-11-28 23:31:24', NULL),
(49, 28, 19, NULL, 'ewewew', 'camisowee2@gmail.com', '3174885954', 'CC', '564645465', 'Urb villa liliana', 'Armenia', 'ewewe', 1, '2025-11-28 23:35:33', '2025-11-28 23:35:33', NULL),
(50, 28, 19, NULL, 'fffffffffffffff', 'ffffffffffff@gmail.com', '3174885954', 'CC', '21332312123', 'Urb villa liliana', 'Armenia', 'fffff', 1, '2025-11-28 23:36:32', '2025-11-28 23:36:32', NULL),
(51, 28, 19, NULL, 'trtrtr', 'trrtr2@gmail.com', '3174885954', 'CC', '4554355443', 'Urb villa liliana', 'Armenia', 'trtrtr', 1, '2025-11-28 23:43:01', '2025-11-28 23:43:01', NULL),
(52, 28, 19, NULL, 'jllllllllllllllllll', 'jllllllll@gmail.com', '3174885954', 'CC', '212121212112', 'Urb villa liliana', 'Armenia', 'jlllllll', 1, '2025-11-28 23:43:34', '2025-11-28 23:43:34', NULL),
(53, 28, 19, NULL, 'yyyyyyyyyyyyyy', 'yyyyyyyyy@gmail.com', '3174885954', 'CC', '4615339', 'Urb villa liliana', 'Armenia', 'yyyyyyyyy', 1, '2025-11-28 23:45:06', '2025-11-28 23:45:06', NULL),
(54, 28, 19, NULL, '545', '54545@gmail.com', '3174885954', 'CC', '455545454', 'Urb villa liliana', 'Armenia', '54545', 1, '2025-11-28 23:46:20', '2025-11-28 23:46:20', NULL),
(55, 28, 19, NULL, '44444', '4444@gmail.com', '3174885954', 'CC', '444444444', 'Urb villa liliana', 'Armenia', '444', 1, '2025-11-28 23:47:25', '2025-11-28 23:47:25', NULL),
(56, 28, 19, NULL, 'qqqqqqqqq', 'qqqqqqqqqqqqq@gmail.com', '3174885954', 'CC', '5454545454', 'Urb villa liliana', 'Armenia', 'qqqqq', 1, '2025-11-28 23:52:59', '2025-11-28 23:52:59', NULL),
(57, 28, 19, NULL, 'Fabio Vera', 'fvera@gmail.com', '3125698685', 'CC', '34434343', 'Urb villa liliana', 'Armenia', 'Quindío', 1, '2025-11-28 23:56:39', '2025-12-02 01:45:25', NULL),
(58, 28, 19, NULL, 'Gonzalo Perez', 'gonzaloperez@gmail.com', '3125697845', 'PEP', '566565656', 'Urb villa liliana', 'Armenia', 'Antióquia', 1, '2025-11-28 23:57:56', '2025-12-02 01:44:14', NULL),
(59, 28, 19, NULL, 'cristian ramirez', 'ramirez@gmail.com', '3175574896', 'PS', '8879878', 'Urb villa liliana', 'Armenia', 'Quindío', 1, '2025-11-28 23:59:44', '2025-12-01 21:59:32', NULL),
(60, 28, 19, NULL, 'Andrés camilo  Ocampo', 'andocampo@gmail.com', '3174885951', 'CC', '1094569876', 'Urb villa liliana', 'Armenia', 'Quindio', 1, '2025-12-01 17:38:04', '2025-12-02 02:11:32', NULL),
(61, 28, 19, NULL, 'carlos calle', 'carloscalle@gmail.com', '3174885954', 'TI', '54545445', 'Urb villa liliana', 'Armenia', 'Quindío', 1, '2025-12-01 20:12:13', '2025-12-02 01:44:49', NULL),
(62, 28, 19, NULL, 'jaiver  A. Ocampo', '444444@gmail.com', 'uindio', 'CC', '4615338', 'Urb villa liliana', 'Armenia', 'Quindío', 1, '2025-12-02 01:59:08', '2025-12-02 02:11:24', NULL),
(63, 28, 19, NULL, 'Nado velez', 'mnando2025@gmail.com', '3174885954', 'CE', '46153310', 'Urb villa liliana mz m cs2', 'Armeniaa', 'Quindio', 1, '2025-12-02 02:01:10', '2025-12-02 02:11:15', NULL),
(64, 28, 19, NULL, 'monica sazpa', 'monica@gmail.com', '3174883265', 'CC', '4165987485', 'Urb villa liliana', 'Armenia', 'Quindío', 1, '2025-12-02 04:29:36', '2025-12-02 04:29:36', NULL),
(65, 28, 19, NULL, 'sebastian parra', 'parra@gmail.com', '3174885954', 'CC', '4615339026', 'Urb villa liliana', 'Armenia', 'Quindío', 1, '2025-12-02 04:35:43', '2025-12-02 04:35:43', NULL),
(66, 28, 19, NULL, 'TRELLO VALENCIA', 'TRELLO@gmail.com', '3174885954', 'CC', '461533989', 'Urb villa liliana', 'Armenia', 'Quindío', 0, '2025-12-02 04:38:55', '2025-12-02 04:39:20', NULL),
(67, 28, 19, NULL, 'OSCAR MEDILA', 'oscar@gmail.com', '3174885954', 'CC', '4512658978', 'Urb villa liliana', 'Armenia', 'Quindío', 1, '2025-12-02 04:40:21', '2025-12-02 04:40:21', NULL),
(68, 28, 19, NULL, 'juan Gomez', 'GOMEZ@gmail.com', '3174885954', 'CC', '46153398745', 'Urb villa liliana', 'Armenia', 'Quindío', 1, '2025-12-02 04:54:03', '2025-12-02 04:54:03', NULL),
(69, 28, 19, NULL, 'fercho avilla', 'avila@gmail.com', '3174885954', 'CC', '133122365', 'Urb villa liliana', 'Popayán', 'Cauca', 1, '2025-12-02 04:59:21', '2025-12-02 04:59:21', NULL),
(70, 28, 19, NULL, 'fernanda  cepeda', 'cepeda@gmail.com', '3174885954', 'CC', '132123324', 'Urb villa liliana', 'Colón', 'Putumayo', 1, '2025-12-02 05:00:08', '2025-12-02 05:00:08', NULL),
(71, 28, 19, NULL, 'ema guayabal', 'guayabal@gmail.com', '3174885954', 'CC', '123132558', 'Urb villa liliana', 'Leticia', 'Amazonas', 0, '2025-12-02 05:04:27', '2025-12-02 05:24:51', NULL),
(72, 28, 19, NULL, 'marixa velez', 'velez@gmail.com', '3174885954', 'CC', '0125454741', 'Urb villa liliana', 'Albania', 'La Guajira', 0, '2025-12-02 05:19:10', '2025-12-02 05:24:44', NULL),
(73, 28, 19, NULL, 'kaka barrios', 'barrios@gmail.com', '3174885954', 'CC', '10326458987', 'Urb villa liliana', 'Uribia', 'La Guajira', 0, '2025-12-02 05:20:34', '2025-12-02 07:31:36', NULL),
(74, 28, 19, NULL, 'Carlito varsales', 'varsal@gmail.com', '3174885954', 'CC', '121547556', 'Urb villa liliana', 'Abejorral', 'Antioquia', 1, '2025-12-02 05:21:26', '2025-12-02 08:25:33', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vh_code` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `legal_name` varchar(255) DEFAULT NULL,
  `document_type` varchar(10) NOT NULL DEFAULT 'NIT',
  `document_number` varchar(30) NOT NULL,
  `dv` varchar(5) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `neighborhood` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'Colombia',
  `tax_regime` varchar(255) DEFAULT NULL,
  `economic_activity_code` varchar(10) DEFAULT NULL,
  `billing_resolution` varchar(255) DEFAULT NULL,
  `billing_resolution_date` date DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `logo_path` varchar(255) DEFAULT NULL,
  `color_theme` varchar(255) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`id`, `vh_code`, `name`, `legal_name`, `document_type`, `document_number`, `dv`, `email`, `phone`, `website`, `address`, `neighborhood`, `city`, `department`, `country`, `tax_regime`, `economic_activity_code`, `billing_resolution`, `billing_resolution_date`, `is_verified`, `active`, `logo_path`, `color_theme`, `verified_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(27, 'VH-1D2A0359', 'visual code', 'Ocampo Oviedo', 'NIT', '46169857', '9', 'jaiver@gmail.com', '3174885954', NULL, 'Urb villa liliana', NULL, NULL, NULL, 'Colombia', 'simple', '01254', '1548795', '2025-11-07', 0, 1, '/logos/logo_41498fe4-1250-4c09-a1f2-34f8bf66b67d.jpeg', '#4f46e5', NULL, NULL, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(28, 'VH-5E1BD743', 'mavebothis  optic', 'mevebo click', 'NIT', '41944605', '8', 'mvebo89@gmail.com', '3174885954', NULL, 'Urb villa liliana', NULL, NULL, NULL, 'Colombia', 'simple', '01254', '1548795', NULL, 0, 1, '/logos/logo_e1fdc4b7-6d99-4b45-9437-8c2d8feb17da.jpg', '#4f46e5', NULL, NULL, '2025-11-15 12:04:01', '2025-11-15 12:04:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents_clients`
--

CREATE TABLE `documents_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name_company` varchar(255) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `image_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`image_id`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `documents_clients`
--

INSERT INTO `documents_clients` (`id`, `company_id`, `branch_id`, `user_id`, `client_id`, `name_company`, `description`, `image_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(38, 27, 16, 25, 22, 'test a ver si es este  valor ::::lll', 'super test description', '\"[]\"', '2025-11-19 19:54:00', '2025-11-19 19:54:00', NULL),
(39, 27, 16, 25, 21, 'start vusal group', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '\"[]\"', '2025-11-19 19:57:23', '2025-11-19 19:57:23', NULL),
(40, 27, 16, 25, 22, 'ccccccccc', 'ss', '\"[]\"', '2025-11-19 19:58:10', '2025-11-19 19:58:10', NULL),
(41, 27, 16, 25, 22, 'ccccccccc', 'ssss', '\"[]\"', '2025-11-19 19:59:15', '2025-11-19 19:59:15', NULL),
(42, 27, 16, 25, 22, 'ccccccccc', 'www', '\"[]\"', '2025-11-19 20:02:27', '2025-11-19 20:02:27', NULL),
(43, 27, 16, 25, 22, 'ssss', 's', '\"[]\"', '2025-11-19 20:04:48', '2025-11-19 20:04:48', NULL),
(44, 27, 16, 25, 22, 'ccccccccc', 'www', '\"[]\"', '2025-11-19 20:05:12', '2025-11-19 20:05:12', NULL),
(45, 27, 16, 25, 22, 'ccccccccc', 'aaa', '\"[]\"', '2025-11-19 20:07:42', '2025-11-19 20:07:42', NULL),
(46, 27, 16, 25, 19, 'ccccccccc', 'aaa', '\"[]\"', '2025-11-19 20:08:30', '2025-11-19 20:08:30', NULL),
(47, 27, 16, 25, 22, 'ssss', 'sss', '\"[72,73]\"', '2025-11-19 20:13:23', '2025-11-19 20:13:23', NULL),
(48, 27, 16, 25, 22, 'Joyas del Sur S.A.', 'Documentos de garantía del cliente', '\"[74]\"', '2025-11-19 20:14:57', '2025-11-19 20:14:57', NULL),
(49, 27, 16, 25, 22, 'test de funcionamiento', 'test funcionalidad terminada', '\"[75,76]\"', '2025-11-19 20:16:57', '2025-11-19 20:16:57', NULL),
(50, 27, 16, 25, 21, 'optoca del norte', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '\"[77,78]\"', '2025-11-19 20:31:14', '2025-11-19 20:31:14', NULL),
(51, 27, 16, 25, 22, 'ccccccccc', 'fggg', '\"[79]\"', '2025-11-19 21:08:19', '2025-11-19 21:08:19', NULL),
(52, 27, 16, 25, 22, 'test de subida documentos full', '¡Claro! Para darle un toque más profesional y estandarizado a tu botón de \"Volver\" en Vue con Tailwind CSS, podemos usar un diseño común para botones de navegación que incluya un ícono de flecha y un texto claro, utilizando clases semánticas para la accesibilidad.', '\"[80,81,82]\"', '2025-11-20 00:19:29', '2025-11-20 00:19:29', NULL),
(53, 27, 16, 25, 35, 'zzzzzzzzzzzzzzzzzzzzzzzzz', 'zzzzzzzzzzzzzzzzzzzzz   zzzzzzzzzzzzzzzz zzzzzzzzzzz zzzzzzzzzzzzzzz', '\"[83,84,85]\"', '2025-11-25 21:38:35', '2025-11-25 21:38:35', NULL),
(54, 27, 16, 25, 3, 'jjjjjjjjjjj', 'jtest de cliente buscar que deja documentois para buscar', '\"[86,87,88]\"', '2025-11-25 21:39:21', '2025-11-25 21:39:21', NULL),
(55, 27, 16, 25, 32, 'fffffffffffff', 'test de dcoumentos para el usuario f, es buen ff', '\"[89,90]\"', '2025-11-25 21:40:21', '2025-11-25 21:40:21', NULL),
(56, 27, 16, 25, 34, 'qqqqqqqqqqqq', 'qqqqqqqqqqqqqqqqqqqqqq  qa qqseqweqweqeqeqw', '\"[91]\"', '2025-11-26 01:24:05', '2025-11-26 01:24:05', NULL),
(57, 28, 19, 30, 18, '555', '5555', '\"[92,93]\"', '2025-11-26 22:43:19', '2025-11-26 22:43:19', NULL),
(58, 28, 19, 30, 5, 'ffff', 'fffff', '\"[94,95]\"', '2025-11-26 22:54:08', '2025-11-26 22:54:08', NULL),
(59, 28, 19, 30, 18, 'ggg', 'gggg', '\"[96,97,98]\"', '2025-11-26 22:54:52', '2025-11-26 22:54:52', NULL),
(60, 28, 19, 30, 18, 'eee', 'dddd', '\"[99]\"', '2025-11-26 22:56:55', '2025-11-26 22:56:55', NULL),
(61, 28, 19, 30, 6, 'ddd', 'ddd', '\"[100,101]\"', '2025-11-26 23:00:26', '2025-11-26 23:00:26', NULL),
(62, 28, 22, 30, 8, 'pppppppppp', 'ppppppp ewtwtwtw tw wtwrtw', '\"[102,103]\"', '2025-11-26 23:54:34', '2025-11-26 23:54:34', NULL),
(63, 28, 19, 30, 42, 'ccccccccc', 'sasassd ad aed', '\"[104,105]\"', '2025-11-27 05:39:48', '2025-11-27 05:39:48', NULL),
(64, 28, 54, 30, 59, 'iuyiyi', 'yuiyuiy', '\"[106]\"', '2025-11-29 05:53:00', '2025-11-29 05:53:00', NULL),
(65, 28, 19, 30, 60, 'test', 'buen  test', '\"[107,108,109]\"', '2025-12-01 18:11:12', '2025-12-01 18:11:12', NULL),
(66, 28, 19, 30, 60, 'sdd', 'ddddd', '\"[110,111]\"', '2025-12-01 18:16:08', '2025-12-01 18:16:08', NULL),
(67, 28, 19, 30, 60, 'test', 'test de funcinamienrto', '\"[112,113]\"', '2025-12-01 18:20:54', '2025-12-01 18:20:54', NULL),
(68, 28, 19, 30, 60, 'hjhj', 'jhjh', '\"[114,115]\"', '2025-12-01 18:46:30', '2025-12-01 18:46:30', NULL),
(69, 28, 19, 30, 60, 'dffdf', 'dfdfd', '\"[116,117]\"', '2025-12-01 18:57:21', '2025-12-01 18:57:21', NULL),
(70, 28, 19, 30, 58, 'dddd', 'ddd', '\"[118,119,120]\"', '2025-12-01 19:05:32', '2025-12-01 19:05:32', NULL),
(71, 28, 19, 30, 60, 'aaaAA', 'aAa', '\"[121,122,123]\"', '2025-12-01 19:06:24', '2025-12-01 19:06:24', NULL),
(72, 28, 19, 30, 60, 'ccccccccc', 'wwww', '\"[124,125,126]\"', '2025-12-01 19:07:53', '2025-12-01 19:07:53', NULL),
(73, 28, 19, 30, 60, 'xcczcz', 'xzczxc', '\"[127,128]\"', '2025-12-01 19:58:20', '2025-12-01 19:58:20', NULL),
(74, 28, 19, 30, 60, 'xcczcz', 'xzczxc', '\"[129,130,131,132]\"', '2025-12-01 19:59:06', '2025-12-01 19:59:06', NULL),
(75, 28, 19, 30, 60, 'sss', 'sssss', '\"[133,134]\"', '2025-12-01 20:02:06', '2025-12-01 20:02:06', NULL),
(76, 28, 19, 30, 60, 'kjkjk', 'jkj', '\"[135,136]\"', '2025-12-01 20:04:09', '2025-12-01 20:04:09', NULL),
(77, 28, 19, 30, 60, 'ghg', 'hghg', '\"[137,138]\"', '2025-12-01 20:06:10', '2025-12-01 20:06:10', NULL),
(78, 28, 19, 30, 61, 'ygfyrty', 'rtyrtyr', '\"[139,140]\"', '2025-12-01 20:52:47', '2025-12-01 20:52:47', NULL),
(79, 28, 19, 30, 61, 'uuuuuuuuuuuuuuu', 'uuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuu', '\"[141]\"', '2025-12-01 20:58:49', '2025-12-01 20:58:49', NULL),
(80, 28, 19, 30, 63, 'test de la empresa que lo emite', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '\"[142,143]\"', '2025-12-02 02:02:43', '2025-12-02 02:02:43', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `image_documents_clients`
--

CREATE TABLE `image_documents_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `image_documents_clients`
--

INSERT INTO `image_documents_clients` (`id`, `company_id`, `client_id`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(69, 27, 21, 'documents_clients/691dd3add6afe_1763562413.jpeg', '2025-11-19 19:26:53', '2025-11-19 19:26:53', NULL),
(70, 27, 21, 'documents_clients/691dd43e1737a_1763562558.jpg', '2025-11-19 19:29:18', '2025-11-19 19:29:18', NULL),
(71, 27, 21, 'documents_clients/691dd75eef8dd_1763563358.jpg', '2025-11-19 19:42:38', '2025-11-19 19:42:38', NULL),
(72, 27, 22, 'documents_clients/691dde930affd_1763565203.jpg', '2025-11-19 20:13:23', '2025-11-19 20:13:23', NULL),
(73, 27, 22, 'documents_clients/691dde930c45b_1763565203.jpeg', '2025-11-19 20:13:23', '2025-11-19 20:13:23', NULL),
(74, 27, 22, 'documents_clients/691ddef10fb50_1763565297.jpg', '2025-11-19 20:14:57', '2025-11-19 20:14:57', NULL),
(75, 27, 22, 'documents_clients/691ddf695f98f_1763565417.jpg', '2025-11-19 20:16:57', '2025-11-19 20:16:57', NULL),
(76, 27, 22, 'documents_clients/691ddf6960c5a_1763565417.jpeg', '2025-11-19 20:16:57', '2025-11-19 20:16:57', NULL),
(77, 27, 21, 'documents_clients/691de2c24869e_1763566274.jpg', '2025-11-19 20:31:14', '2025-11-19 20:31:14', NULL),
(78, 27, 21, 'documents_clients/691de2c249fff_1763566274.jpeg', '2025-11-19 20:31:14', '2025-11-19 20:31:14', NULL),
(79, 27, 22, 'documents_clients/691deb73075eb_1763568499.jpeg', '2025-11-19 21:08:19', '2025-11-19 21:08:19', NULL),
(80, 27, 22, 'documents_clients/691e18412fcf6_1763579969.jpg', '2025-11-20 00:19:29', '2025-11-20 00:19:29', NULL),
(81, 27, 22, 'documents_clients/691e184130fb0_1763579969.jpeg', '2025-11-20 00:19:29', '2025-11-20 00:19:29', NULL),
(82, 27, 22, 'documents_clients/691e184131b8f_1763579969.jpg', '2025-11-20 00:19:29', '2025-11-20 00:19:29', NULL),
(83, 27, 35, 'documents_clients/6925db8b70f8e_1764088715.jpeg', '2025-11-25 21:38:35', '2025-11-25 21:38:35', NULL),
(84, 27, 35, 'documents_clients/6925db8b71e50_1764088715.jpg', '2025-11-25 21:38:35', '2025-11-25 21:38:35', NULL),
(85, 27, 35, 'documents_clients/6925db8b72c27_1764088715.jpeg', '2025-11-25 21:38:35', '2025-11-25 21:38:35', NULL),
(86, 27, 3, 'documents_clients/6925dbb960081_1764088761.jpg', '2025-11-25 21:39:21', '2025-11-25 21:39:21', NULL),
(87, 27, 3, 'documents_clients/6925dbb961023_1764088761.jpeg', '2025-11-25 21:39:21', '2025-11-25 21:39:21', NULL),
(88, 27, 3, 'documents_clients/6925dbb961abc_1764088761.jpg', '2025-11-25 21:39:21', '2025-11-25 21:39:21', NULL),
(89, 27, 32, 'documents_clients/6925dbf51aba6_1764088821.jpeg', '2025-11-25 21:40:21', '2025-11-25 21:40:21', NULL),
(90, 27, 32, 'documents_clients/6925dbf51c1da_1764088821.jpg', '2025-11-25 21:40:21', '2025-11-25 21:40:21', NULL),
(91, 27, 34, 'documents_clients/6926106506eb9_1764102245.jpg', '2025-11-26 01:24:05', '2025-11-26 01:24:05', NULL),
(92, 28, 18, 'documents_clients/69273c3704050_1764178999.jpg', '2025-11-26 22:43:19', '2025-11-26 22:43:19', NULL),
(93, 28, 18, 'documents_clients/69273c3705369_1764178999.jpeg', '2025-11-26 22:43:19', '2025-11-26 22:43:19', NULL),
(94, 28, 5, 'documents_clients/69273ec0d92ed_1764179648.jpg', '2025-11-26 22:54:08', '2025-11-26 22:54:08', NULL),
(95, 28, 5, 'documents_clients/69273ec0da395_1764179648.jpeg', '2025-11-26 22:54:08', '2025-11-26 22:54:08', NULL),
(96, 28, 18, 'documents_clients/69273eec5659e_1764179692.jpg', '2025-11-26 22:54:52', '2025-11-26 22:54:52', NULL),
(97, 28, 18, 'documents_clients/69273eec575fb_1764179692.jpeg', '2025-11-26 22:54:52', '2025-11-26 22:54:52', NULL),
(98, 28, 18, 'documents_clients/69273eec58037_1764179692.jpg', '2025-11-26 22:54:52', '2025-11-26 22:54:52', NULL),
(99, 28, 18, 'documents_clients/69273f67557a8_1764179815.jpeg', '2025-11-26 22:56:55', '2025-11-26 22:56:55', NULL),
(100, 28, 6, 'documents_clients/6927403aa31a3_1764180026.jpg', '2025-11-26 23:00:26', '2025-11-26 23:00:26', NULL),
(101, 28, 6, 'documents_clients/6927403aa3d6f_1764180026.jpeg', '2025-11-26 23:00:26', '2025-11-26 23:00:26', NULL),
(102, 28, 8, 'documents_clients/69274ceac958b_1764183274.jpg', '2025-11-26 23:54:34', '2025-11-26 23:54:34', NULL),
(103, 28, 8, 'documents_clients/69274ceaca4a3_1764183274.jpeg', '2025-11-26 23:54:34', '2025-11-26 23:54:34', NULL),
(104, 28, 42, 'documents_clients/69279dd4d2a07_1764203988.jpeg', '2025-11-27 05:39:48', '2025-11-27 05:39:48', NULL),
(105, 28, 42, 'documents_clients/69279dd4d3b35_1764203988.jpg', '2025-11-27 05:39:48', '2025-11-27 05:39:48', NULL),
(106, 28, 59, 'documents_clients/692a8a3cd84e5_1764395580.jpg', '2025-11-29 05:53:00', '2025-11-29 05:53:00', NULL),
(107, 28, 60, 'documents_clients/692dda40aabf4_1764612672.jpg', '2025-12-01 18:11:12', '2025-12-01 18:11:12', NULL),
(108, 28, 60, 'documents_clients/692dda40abe99_1764612672.jpeg', '2025-12-01 18:11:12', '2025-12-01 18:11:12', NULL),
(109, 28, 60, 'documents_clients/692dda40ac938_1764612672.jpg', '2025-12-01 18:11:12', '2025-12-01 18:11:12', NULL),
(110, 28, 60, 'documents_clients/692ddb683899d_1764612968.jpg', '2025-12-01 18:16:08', '2025-12-01 18:16:08', NULL),
(111, 28, 60, 'documents_clients/692ddb6839e88_1764612968.jpeg', '2025-12-01 18:16:08', '2025-12-01 18:16:08', NULL),
(112, 28, 60, 'documents_clients/692ddc86808a0_1764613254.jpeg', '2025-12-01 18:20:54', '2025-12-01 18:20:54', NULL),
(113, 28, 60, 'documents_clients/692ddc8681fcb_1764613254.jpg', '2025-12-01 18:20:54', '2025-12-01 18:20:54', NULL),
(114, 28, 60, 'documents_clients/692de28685575_1764614790.jpeg', '2025-12-01 18:46:30', '2025-12-01 18:46:30', NULL),
(115, 28, 60, 'documents_clients/692de28686b94_1764614790.jpg', '2025-12-01 18:46:30', '2025-12-01 18:46:30', NULL),
(116, 28, 60, 'documents_clients/692de511c6fe3_1764615441.jpg', '2025-12-01 18:57:21', '2025-12-01 18:57:21', NULL),
(117, 28, 60, 'documents_clients/692de511c7f1f_1764615441.jpeg', '2025-12-01 18:57:21', '2025-12-01 18:57:21', NULL),
(118, 28, 58, 'documents_clients/692de6fc4a51f_1764615932.jpg', '2025-12-01 19:05:32', '2025-12-01 19:05:32', NULL),
(119, 28, 58, 'documents_clients/692de6fc4bb7c_1764615932.jpeg', '2025-12-01 19:05:32', '2025-12-01 19:05:32', NULL),
(120, 28, 58, 'documents_clients/692de6fc4c5ce_1764615932.jpg', '2025-12-01 19:05:32', '2025-12-01 19:05:32', NULL),
(121, 28, 60, 'documents_clients/692de73045142_1764615984.jpg', '2025-12-01 19:06:24', '2025-12-01 19:06:24', NULL),
(122, 28, 60, 'documents_clients/692de730465ef_1764615984.jpeg', '2025-12-01 19:06:24', '2025-12-01 19:06:24', NULL),
(123, 28, 60, 'documents_clients/692de730471cd_1764615984.jpg', '2025-12-01 19:06:24', '2025-12-01 19:06:24', NULL),
(124, 28, 60, 'documents_clients/692de78986531_1764616073.jpg', '2025-12-01 19:07:53', '2025-12-01 19:07:53', NULL),
(125, 28, 60, 'documents_clients/692de789872a7_1764616073.jpeg', '2025-12-01 19:07:53', '2025-12-01 19:07:53', NULL),
(126, 28, 60, 'documents_clients/692de78987da5_1764616073.jpg', '2025-12-01 19:07:53', '2025-12-01 19:07:53', NULL),
(127, 28, 60, 'documents_clients/692df35c748b8_1764619100.jpeg', '2025-12-01 19:58:20', '2025-12-01 19:58:20', NULL),
(128, 28, 60, 'documents_clients/692df35c756ce_1764619100.jpg', '2025-12-01 19:58:20', '2025-12-01 19:58:20', NULL),
(129, 28, 60, 'documents_clients/692df38a3e827_1764619146.jpeg', '2025-12-01 19:59:06', '2025-12-01 19:59:06', NULL),
(130, 28, 60, 'documents_clients/692df38a3f4d6_1764619146.jpg', '2025-12-01 19:59:06', '2025-12-01 19:59:06', NULL),
(131, 28, 60, 'documents_clients/692df38a4002d_1764619146.jpeg', '2025-12-01 19:59:06', '2025-12-01 19:59:06', NULL),
(132, 28, 60, 'documents_clients/692df38a40a04_1764619146.jpg', '2025-12-01 19:59:06', '2025-12-01 19:59:06', NULL),
(133, 28, 60, 'documents_clients/692df43ed4af0_1764619326.jpg', '2025-12-01 20:02:06', '2025-12-01 20:02:06', NULL),
(134, 28, 60, 'documents_clients/692df43ed6114_1764619326.jpeg', '2025-12-01 20:02:06', '2025-12-01 20:02:06', NULL),
(135, 28, 60, 'documents_clients/692df4b9c514e_1764619449.jpeg', '2025-12-01 20:04:09', '2025-12-01 20:04:09', NULL),
(136, 28, 60, 'documents_clients/692df4b9c640f_1764619449.jpg', '2025-12-01 20:04:09', '2025-12-01 20:04:09', NULL),
(137, 28, 60, 'documents_clients/692df5328f22b_1764619570.jpeg', '2025-12-01 20:06:10', '2025-12-01 20:06:10', NULL),
(138, 28, 60, 'documents_clients/692df5328ff17_1764619570.jpg', '2025-12-01 20:06:10', '2025-12-01 20:06:10', NULL),
(139, 28, 61, 'documents_clients/692e001f674fc_1764622367.jpg', '2025-12-01 20:52:47', '2025-12-01 20:52:47', NULL),
(140, 28, 61, 'documents_clients/692e001f689e7_1764622367.jpeg', '2025-12-01 20:52:47', '2025-12-01 20:52:47', NULL),
(141, 28, 61, 'documents_clients/692e0189e6e2a_1764622729.jpg', '2025-12-01 20:58:49', '2025-12-01 20:58:49', NULL),
(142, 28, 63, 'documents_clients/692e48c34b570_1764640963.jpg', '2025-12-02 02:02:43', '2025-12-02 02:02:43', NULL),
(143, 28, 63, 'documents_clients/692e48c34cef2_1764640963.jpeg', '2025-12-02 02:02:43', '2025-12-02 02:02:43', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `number_invoice` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `min_stock` int(11) NOT NULL DEFAULT 0,
  `purchase_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax_purchase` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `net_price` decimal(10,2) DEFAULT NULL,
  `output_unit` varchar(50) DEFAULT NULL,
  `tax_sale` decimal(10,2) DEFAULT NULL,
  `max_disscount` double(8,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `image_invoice` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inventories`
--

INSERT INTO `inventories` (`id`, `company_id`, `branch_id`, `sku`, `name`, `category`, `number_invoice`, `description`, `quantity`, `min_stock`, `purchase_price`, `tax_purchase`, `sale_price`, `net_price`, `output_unit`, `tax_sale`, `max_disscount`, `image`, `image_invoice`, `active`, `user_id`, `created_at`, `updated_at`, `deleted_at`, `supplier_id`) VALUES
(10, 28, 19, '00028019000001', 'Gafas de sol', 'Anteojos', 'FAC-2025-00023', 'Gafas de sol polarizadas para uso diario', 25, 5, 120000.00, 19.00, 250000.00, NULL, '0', 19.00, 10.00, '/inventories/7f77fce7-e577-4f6f-b565-840646bc3d7e.jpg', '/invoices/5da76800-f150-4b47-882a-cb920a597db5.jpg', 1, 30, '2025-11-18 02:30:50', '2025-11-18 02:30:50', NULL, 2),
(11, 28, 19, '00028019000002', 'Gafas de sol', 'Anteojos', 'FAC-2025-00023', 'Gafas de sol polarizadas para uso diario', 31, 5, 200000.00, 19.00, 250000.00, NULL, '0', 19.00, 10.00, '/inventories/9fb7cbb9-d52f-46a0-8205-b15187e97e26.jpeg', '/invoices/1c97ea51-8a10-4996-814f-12e603b00b38.jpeg', 1, 30, '2025-11-18 05:09:17', '2025-11-18 05:09:17', NULL, 2),
(12, 28, 19, '00028019000003', 'Gafas de sol', 'Anteojos', 'FAC-2025-00023', 'Gafas de sol polarizadas para uso diario', 25, 5, 120000.00, 19.00, 250000.00, 210084.03, '10', 19.00, 10.00, '/inventories/10f67fb0-575f-4c61-80b5-dc3ee4a2ad05.jpeg', '/invoices/b8fcab90-e3ba-4cdd-8b85-c35034cea0ba.jpg', 1, 30, '2025-11-18 05:12:51', '2025-12-01 17:38:23', NULL, NULL),
(13, 27, 20, '00027019000001', 'Gafas de sol', 'Anteojos', 'FAC-2025-00023', 'Gafas de sol polarizadas para uso diario', 100000, 5, 120000.00, 19.00, 250000.00, 210084.03, '1', 19.00, 10.00, '/inventories/c9919250-e587-4844-842c-73235d1c6259.jpeg', '/invoices/cbfba459-a4f3-4265-8eb4-46733edd288f.jpg', 1, 25, '2025-11-18 05:16:11', '2025-11-25 09:22:18', NULL, NULL),
(15, 27, 16, '00027016000001', 'Gafas de sol', 'Anteojos', 'FAC-2025-000235', 'Gafas de sol polarizadas para uso diario', 4110000, 5, 120000.00, 19.00, 250000.00, NULL, '59', 19.00, 10.00, '/inventories/bcb95d48-125e-4e68-8e04-bbd02f0d234f.jpeg', '/invoices/17476f40-f58b-4f5e-b6a6-a77dd3de7162.jpg', 1, 25, '2025-11-18 05:18:39', '2025-11-24 23:23:03', NULL, NULL),
(16, 27, 16, '00027016000002', 'Gafas de sol', 'Anteojos', 'FAC-2025-000235', 'Gafas de sol polarizadas para uso diario', 50, 5, 120000.00, 19.00, 250000.00, NULL, '0', 19.00, 10.00, '/inventories/244bb861-8069-495d-9320-4ce92aea1feb.jpeg', '/invoices/108c68c4-18bd-4efd-a84b-acecb83193de.jpg', 1, 25, '2025-11-18 05:18:46', '2025-11-18 05:18:46', NULL, NULL),
(17, 27, 16, '00027016000003', 'Gafas de sol', 'Anteojos', 'FAC-2025-00023  testst', 'Gafas de sol polarizadas para uso diario', 28, 5, 120000.00, 19.00, 250000.00, NULL, '28', 19.00, 10.00, '/inventories/8e6f606c-f41d-4b98-a4cd-cbd76d1fc974.jpg', NULL, 1, 25, '2025-11-18 05:31:58', '2025-11-24 23:46:48', NULL, 6),
(18, 27, 16, '00027016000004', 'Gafas de sol', 'Anteojos', 'FAC-2025-00023', 'Gafas de sol polarizadas para uso diario', 25, 5, 120000.00, 19.00, 250000.00, NULL, '23', 19.00, 10.00, '/inventories/5bc132d5-860f-4177-b152-8a3004d5756d.jpg', NULL, 1, 25, '2025-11-18 08:01:02', '2025-11-25 04:10:37', NULL, 7),
(19, 27, 16, '00027016000005', 'algo mas para vender', 'Anteojos', 'FAC-2025-00023', 'Gafas de sol polarizadas para uso diario', 250, 5, 120000.00, 19.00, 140000.00, NULL, '30', 19.00, 10.00, '/inventories/b7f0d163-6f48-490f-bd73-fa900564c59d.jpg', NULL, 1, 25, '2025-11-18 08:01:16', '2025-11-25 03:55:29', NULL, 8),
(20, 27, 16, '00027016000006', 'Gafas de sol xxxxxx', 'Anteojos', 'FAC-2025-00023', 'Gafas de sol polarizadas para uso diario', 25, 5, 120000.00, 19.00, 250000.00, NULL, '10', 19.00, 10.00, '/inventories/13e4b7b5-393a-4ca2-8fc4-559f7fc6d4a6.jpg', '/invoices/0715cf45-5674-4e41-91fb-d966638ea036.jpg', 1, 25, '2025-11-18 08:09:46', '2025-11-20 02:20:29', NULL, 10),
(21, 27, 17, '00027017000001', 'Gafas de sol yyyyyyy', 'Anteojos', 'FAC-2025-00023', 'Gafas de sol polarizadas para uso diario', 25, 5, 120000.00, 19.00, 250000.00, NULL, '9', 19.00, 10.00, '/inventories/634cd056-672a-41e7-b4f6-11615b4f9329.jpg', '/invoices/3ebe6188-fb9a-4eb1-bebf-6bcd835dab13.jpg', 1, 25, '2025-11-18 08:12:59', '2025-11-21 08:00:58', NULL, 10),
(22, 27, 16, '00027016000007', 'Gafas de sol yyyyyyy', 'Anteojos', 'FAC-2025-00023', 'Gafas de sol polarizadas para uso diario', 25, 5, 120000.00, 19.00, 250000.00, NULL, '6', 5.00, 10.00, '/inventories/459e8510-b1bc-42fc-aa66-2564eea2d808.jpg', '/invoices/d14d93f3-2af2-48f0-a13a-c049543597c3.jpg', 1, 25, '2025-11-18 08:25:32', '2025-11-21 06:47:48', NULL, 10),
(23, 27, 16, '00027016000008', 'ppppppp', 'Anteojos', 'FAC-2025-00023', 'Gafas de sol polarizadas para uso diario', 2000000, 1, 120000.00, 19.00, 190000.00, NULL, '43', 30.00, 10.00, '/inventories/78b62810-afc0-476e-bedc-21885bb0fbbe.jpg', '/invoices/ba3a7a79-0b29-4aec-815d-6ebae38b4dad.jpeg', 1, 25, '2025-11-18 08:33:31', '2025-11-24 23:23:03', NULL, 2),
(24, 28, 49, '00028049000001', 'yyyyyyyyy', 'lentes', '12545555', 'test de prueba', 1000, 1, 150000.00, 19.00, 200000.00, NULL, '0', 10.00, 15.00, '/inventories/56f3fe45-b6b0-485b-86fd-e2d921742169.jpg', '/invoices/384e73ba-a25e-4d86-b047-f5069058d338.jpg', 1, 30, '2025-11-19 01:47:41', '2025-11-19 01:47:41', NULL, 8),
(25, 28, 49, '00028049000002', 'ttttttt', 'lentes', '546456', 'hhhhhhhhhhhhhhhh', 10000, 2, 50000.00, 12.00, 120000.00, NULL, '16', 12.00, 12.00, '/inventories/71ddc767-a67a-4e9a-a7a1-34cc348467a2.jpg', '/invoices/5f5a45db-7667-4520-bce6-856868ece832.jpg', 1, 30, '2025-11-19 01:49:12', '2025-11-21 08:00:01', NULL, 7),
(26, 28, 49, '00028049000003', 'qqqqqqqqq', 'lentes', '2524534345', 'testerere', 47, 1, 100000.00, 19.00, 200000.00, NULL, '0', 12.00, 5.00, '/inventories/a2f28a0c-9318-475f-81d1-48a5a5532fd8.jpg', '/invoices/65db18fb-1e90-40e0-9146-e64845776e63.jpg', 1, 30, '2025-11-19 01:52:02', '2025-11-19 01:52:02', NULL, 6),
(27, 28, 49, '00028049000004', 'wwwww', 'Titanio', '86456456', '4444444', 14, 1, 12000.00, 0.00, 580000.00, NULL, '0', 12.00, 30.00, '/inventories/6b3eb1c1-c0f8-4095-b97a-8400f98a0627.jpg', '/invoices/4ea68700-54a2-4632-b164-7c555e1e7962.jpeg', 1, 30, '2025-11-19 02:03:31', '2025-11-19 02:03:31', NULL, 9),
(28, 28, 49, '00028049000005', 'wwwww', 'Titanio', '86456456', '4444444', 14, 1, 12000.00, 0.00, 580000.00, NULL, '0', 12.00, 30.00, '/inventories/81694928-d9e5-4701-9a08-c26fba0ef457.jpg', '/invoices/68ff7ec6-8b12-4f5c-9d8d-06cf5b52c0ac.jpeg', 1, 30, '2025-11-19 02:04:36', '2025-11-19 02:04:36', NULL, 9),
(29, 28, 49, '00028049000006', 'wwwww', 'Titanio', '86456456', '4444444', 14, 1, 12000.00, 0.00, 580000.00, NULL, '0', 12.00, 30.00, '/inventories/1244d1b0-260f-4c83-ac80-307f21b9fa4e.jpg', '/invoices/af25b63d-31f9-4bb4-9486-48eef1a2504a.jpeg', 1, 30, '2025-11-19 02:04:40', '2025-11-19 02:04:40', NULL, 9),
(30, 27, 16, '00027016000009', 'lentes de contacto', 'Bifocales', '1245455', 'lentes de contacto utiles para jugar con ellos', 120, 1, 150000.00, 0.00, 320000.00, NULL, '2', 19.00, 10.00, '/inventories/7e7c7b33-b0ce-4048-a343-c29556b9b636.jpg', NULL, 1, 25, '2025-11-21 08:50:22', '2025-11-21 08:51:12', NULL, NULL),
(31, 27, 16, '00027016000010', 'aaaaaaaaaaaaa', 'Metal', '5453345', 'tererewerwerw', 500000, 1, 2500000.00, 19.00, 300000.00, NULL, '0', 12.00, 15.00, '/inventories/33bd9540-691f-4e3d-8cbd-ac686ef6bdfd.jpg', NULL, 1, 25, '2025-11-21 15:09:06', '2025-11-21 15:09:06', NULL, 7),
(32, 27, 16, '00027016000011', 'aaaaaaaaaaaaa', 'Metal', '5453345', 'tererewerwerw', 500000, 1, 2500000.00, 19.00, 300000.00, NULL, '0', 12.00, 15.00, '/inventories/ef2d6a48-7398-4323-8ea5-de5db80beda2.jpg', NULL, 1, 25, '2025-11-21 15:09:28', '2025-11-21 15:09:28', NULL, 7),
(33, 27, 16, '00027016000012', 'Marce  job', 'Metal', '6546545', 'test de funcionamiento marcela', 1000, 2, 105000.00, 19.00, 240000.00, NULL, '0', 19.00, 5.00, '/inventories/1f707576-82d4-42ab-b187-e1e528c22c69.jpg', '/invoices/12e92c60-61ff-4900-950f-801f3dfce57c.jpg', 1, 25, '2025-11-25 05:25:21', '2025-11-25 05:25:21', NULL, 9),
(34, 27, 16, '00027016000013', 'test jaiver final', 'Acetato/Plástico', '1111111111', 'test para determinar el funcionamiento de que todo este  bien', 1000, 2, 52000.00, 19.00, 297500.00, NULL, '0', 19.00, 12.00, '/inventories/142eadec-db91-4f1b-9d61-e18742feaf24.jpg', '/invoices/371200b0-78b5-4b0e-8d3c-c6218c0ce4da.jpg', 1, 25, '2025-11-25 05:34:54', '2025-11-25 05:34:54', NULL, 8),
(35, 27, 16, '00027016000014', 'producto muestra de camilo ocamp o', 'Titanio', '564456456', 'test de funciuonamiento para el producto de  camilo ocampo', 1000, 2, 1000.00, 19.00, 117810.00, NULL, '0', 19.00, 15.00, '/inventories/0332b498-705e-4d91-a4e6-54420b3b91d2.jpeg', '/invoices/2e01401f-6ed7-4149-9e3e-580b86c6e5e4.jpg', 1, 25, '2025-11-25 05:44:26', '2025-11-25 05:44:26', NULL, 8),
(36, 27, 16, '00027016000015', 'test de prueba de funcion', 'Lentes Oftálmicos (Cristales)', '65445665', 'test de funcilnamiento final apara determinar si quedó bien', 150, 1, 16500.00, 19.00, 119000.00, 100000.00, '22', 19.00, 12.00, '/inventories/710e2179-1fbd-4b76-bc99-e7f2cf8c3f28.jpeg', '/invoices/c36c8c2b-0dc8-42b3-b921-f201c50ab6dd.jpg', 1, 25, '2025-11-25 05:55:14', '2025-11-26 02:18:05', NULL, 8),
(37, 27, 16, '00027016000016', 'plesk de plek', 'Monofocales (Visión Sencilla)', '5345464565', 'test de plesk ti plesk', 100, 1, 15000.00, 19.00, 146370.00, 123000.00, '24', 19.00, 5.00, '/inventories/3a970b32-1f98-4f55-8b42-130de4ca8c42.jpg', NULL, 1, 25, '2025-11-25 06:34:19', '2025-11-25 21:04:55', NULL, 8),
(38, 27, 16, '00027016000017', 'dddddddddddddd', 'Monturas Oftálmicas', '000000000000056', 'test de funciopnamiento nueva api', 150, 2, 150000.00, 19.00, 416500.00, 350000.00, '0', 19.00, 5.00, '/inventories/5900af4c-a3cd-4965-b6bc-1432c0c50fa0.jpeg', NULL, 1, 25, '2025-11-25 21:22:40', '2025-11-25 21:22:40', NULL, NULL),
(39, 28, 22, '00028022000001', 'test de la sucurlal 22', 'Monturas Oftálmicas', '000003', 'test de funcionalidad sucursal 22', 12000, 0, 50000.00, 19.00, 63000.00, 63000.00, '2', 0.00, 12.00, '/inventories/a4eff84a-da30-4b37-8934-33173b73012f.jpeg', NULL, 1, 30, '2025-11-26 23:15:15', '2025-11-26 23:21:50', NULL, 8),
(40, 28, 19, '00028019000004', 'zzzzzzz', 'Acetato/Plástico', '00001', 'frewe rw wrwerwerw', 150, 1, 150000.00, 19.00, 300000.00, 300000.00, '0', 0.00, 15.00, '/inventories/69158ea5-887f-4ce3-8d29-5d471f216926.jpeg', NULL, 1, 30, '2025-11-27 02:59:46', '2025-11-27 02:59:46', NULL, NULL),
(41, 28, 19, '00028019000005', 'cambiemos el producto a algo mejor', 'Metal', '01111', 'El texto se remonta a una sección del tratado de Cicerón De finibus bonorum et malorum (Sobre los límites del bien y del mal), escrito en el año', 222, 2, 220000.00, 19.00, 595000.00, 500000.00, '0', 19.00, 15.00, '/inventories/063281ac-2100-473e-8cb2-c5382d301736.jpeg', NULL, 0, 30, '2025-11-27 03:53:13', '2025-12-03 00:55:12', NULL, NULL),
(42, 28, 19, '00028019000006', 'tttttttttt2222', 'Metal', '01111', 'tttttttttt fdgfdgfdfggfd22222', 222, 2, 220000.00, 19.00, 500000.00, 500000.00, '0', 0.00, 15.00, '/inventories/c4e0d822-fa9f-4699-ab60-77d60b92eeea.jpeg', NULL, 1, 30, '2025-11-27 03:53:55', '2025-11-27 03:53:55', NULL, NULL),
(43, 28, 19, '00028019000007', 'xxxxxxxxxxxx', 'Metal', '0005', 'ytr  tyrey r ytr r tty tr', 150, 1, 250000.00, 19.00, 345000.00, 300000.00, '1', 15.00, 15.00, '/inventories/1fe571f7-6d7d-47a8-9e00-83f11d382375.jpg', '/invoices/958c440f-c25d-4eb7-8d60-0e89dfa7a2b6.jpg', 1, 30, '2025-11-27 04:41:58', '2025-12-03 01:07:12', NULL, 23),
(44, 28, 19, '00028019000008', 'mi producto estrellla', 'Acetato/Plástico', '00003', '111111111111', 7, 1, 26000.00, 19.00, 357000.00, 300000.00, '7', 19.00, 5.00, '/inventories/39df71af-8196-44c4-9f4e-1fc4c664456c.jpg', '/invoices/18e0652c-e398-4522-9be6-7e6ad23c90d9.jpeg', 1, 30, '2025-11-27 04:56:04', '2025-12-03 01:23:21', NULL, 23),
(45, 28, 19, '00028019000009', 'producto para probar funiconamiento', 'Monturas Oftálmicas', '00001', '11111111111111', 1000, 1, 111111111.00, 12.00, 22400000.00, 20000000.00, '5', 12.00, 12.00, '/inventories/61ecc44c-e42f-4199-8738-41e4b229e156.jpg', '/invoices/a45636bf-b249-4847-9a7e-33fc65692453.jpg', 0, 30, '2025-11-27 04:58:33', '2025-12-03 00:27:06', NULL, 23),
(46, 28, 19, '00028019000010', 'lente para antejos de full vision', 'Monturas Oftálmicas', '000012544', 'test', 1000, 1, 150000.00, 15.00, 622370.00, 523000.00, '23', 19.00, 15.00, '/inventories/d2806193-4a80-4435-a87e-7e6f553bb4c5.jpg', '/invoices/b3348519-0e61-4705-9ab7-be161dfe9d49.jpeg', 0, 30, '2025-11-28 22:59:05', '2025-12-03 00:03:02', NULL, 17),
(47, 28, 19, '00028019000011', 'marxcel  v', 'Metal', '1000113345', 'tes para saber si funciona', 150, 1, 15000.00, 19.00, 146370.00, 123000.00, '15', 19.00, 15.00, '/inventories/964ecea2-ff74-4149-930e-ab4ac4a0cfdc.jpg', '/invoices/290cf6be-82a4-475d-9d24-d8df6adb35c6.jpg', 0, 30, '2025-11-28 23:02:03', '2025-12-03 00:12:32', NULL, 20),
(48, 28, 56, '00028056000001', 'xxxxxxxxxxxxx', 'Progresivos / Multifocales', NULL, 'yttyyttytytyy', 15, 1, 150000.00, 19.00, 428400.00, 360000.00, '10', 19.00, 15.00, '/inventories/cd36e138-716e-48f2-bc5c-b5f5415ff0c0.jpg', NULL, 1, 30, '2025-11-29 00:50:26', '2025-11-29 00:51:21', NULL, NULL),
(49, 28, 54, '00028054000001', 'mevebo nnn', 'Monturas Oftálmicas', NULL, 'mabevo nnnnnn', 1000, 1, 120000.00, 19.00, 619990.00, 521000.00, '121', 19.00, 5.00, '/inventories/a0c9bacb-103e-4d17-85d5-30f5bb3a9213.jpg', NULL, 1, 30, '2025-11-29 04:20:47', '2025-11-29 04:38:59', NULL, NULL),
(50, 28, 19, '00028019000012', 'test  para ver si funciona', 'Monturas Oftálmicas', '00012365', 'test  para ver si funciona', 1500, 1, 250000.00, 19.00, 747500.00, 650000.00, '2', 15.00, 12.00, '/inventories/da3cbd5b-582e-493a-b010-2d7cfd152c1d.jpg', '/invoices/b71aa390-ca83-4847-8402-ef190f60ba55.jpg', 1, 30, '2025-12-01 18:28:18', '2025-12-03 01:23:30', NULL, 21),
(51, 28, 19, '00028019000013', 'ddddddddd', 'Metal', '0000236', '11111111111111', 1000, 1, 100000.00, 19.00, 238000.00, 200000.00, '0', 19.00, 12.00, '/inventories/1700eeb3-7bf1-45bb-9a5e-2ce1670ab860.jpg', '/invoices/3f81111a-c5d6-48ce-915f-7b07df42a26e.jpg', 1, 30, '2025-12-02 21:36:03', '2025-12-03 01:20:13', NULL, 23),
(52, 28, 19, '00028019000014', 'rrrrrrrrrrrrrrr', 'Metal', NULL, '00000', 1000, 11, 10000.00, 19.00, 61880.00, 52000.00, '0', 19.00, 15.00, '/inventories/adf003a9-5d15-4833-8215-36ac835cdb36.jpg', NULL, 1, 30, '2025-12-02 21:39:07', '2025-12-03 01:17:53', NULL, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_10_27_173901_create_companies_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 2),
(3, '2019_08_19_000000_create_failed_jobs_table', 3),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 4),
(5, '2025_10_27_174033_create_branches_table', 5),
(6, '2025_10_27_174116_create_roles_table', 6),
(7, '2025_10_27_174204_create_categories_table', 7),
(8, '2025_10_27_174228_create_products_table', 8),
(9, '2025_10_27_174303_create_inventories_table', 9),
(10, '2025_10_27_174338_create_sales_table', 10),
(11, '2025_10_27_174427_create_sale_details_table', 11),
(12, '2025_10_27_174451_create_sync_logs_table', 12),
(13, '2025_10_28_142813_add_company_id_to_roles_table', 13),
(14, '2025_10_28_151520_create_role_has_permissions_table', 14),
(15, '2025_10_28_151521_create_model_has_permissions_table', 15),
(16, '2025_10_28_151521_create_model_has_roles_table', 16),
(17, '2025_10_28_155716_add_guard_name_to_roles_table', 17),
(18, '2025_10_29_143744_create_clients_table', 18),
(19, '2025_10_29_153501_update_clients_unique_indexes', 19),
(20, '2025_11_03_162252_add_image_to_branches_table', 20),
(21, '2025_11_03_225609_add_branch_to_clients_table', 21),
(22, '2025_11_04_152152_create_inventories_table', 22),
(23, '2025_11_04_181218_create_suppliers_table', 23),
(24, '2025_11_05_185808_add_output_unit_to_inventories_table', 24),
(25, '2025_11_05_200227_create_documents_clients_table', 25),
(26, '2025_11_05_204317_add_company_id_to_permissions_table', 26),
(27, '2025_11_05_204535_add_avatar_to_users_table', 27),
(28, '2025_11_05_204711_add_profile_fields_to_users_table', 28),
(29, '2025_11_05_205446_remove_local_sync_key_from_branches_table', 29),
(30, '2025_11_05_215619_add_user_id_to_inventories_table', 30),
(31, '2025_11_05_215841_add_user_id_to_inventories_table', 31),
(32, '2025_11_06_173659_create_image_documents_clients_table', 32),
(33, '2025_11_06_174120_add_client_id_to_image_documents_clients_table', 33),
(34, '2025_11_06_175912_rename_image_to_image_id_in_documents_clients_table', 34),
(35, '2025_11_06_185107_update_image_id_column_in_documents_clients_table', 35),
(36, '2025_11_06_191036_add_deleted_at_to_image_documents_clients_table', 36),
(38, '2025_11_07_165726_correct_max_discount_in_inventories_table', 37),
(39, '2025_11_07_190320_create_sales_table', 38),
(40, '2025_11_07_190624_create_sale_items_table', 39),
(42, '2025_11_10_152707_add_transaction_and_document_to_sales_table', 40),
(44, '2025_11_10_162226_create_payment_providers_table', 41),
(45, '2025_11_10_180218_add_accounts_receivable_to_payment_providers_table', 42),
(46, '2025_11_10_180324_create_accounts_receivables_table', 43),
(47, '2025_11_17_214214_add_deleted_at_to_suppliers_table', 44),
(48, '2025_11_19_212902_add_column_payment_method', 45),
(49, '2025_11_25_013110_add_net_price_to_inventory_table', 46);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(668, 'App\\Models\\User', 87),
(668, 'App\\Models\\User', 88),
(668, 'App\\Models\\User', 89),
(668, 'App\\Models\\User', 90),
(668, 'App\\Models\\User', 91),
(668, 'App\\Models\\User', 93),
(669, 'App\\Models\\User', 29),
(669, 'App\\Models\\User', 84),
(669, 'App\\Models\\User', 91),
(670, 'App\\Models\\User', 91),
(671, 'App\\Models\\User', 91),
(672, 'App\\Models\\User', 91),
(673, 'App\\Models\\User', 91),
(674, 'App\\Models\\User', 91),
(675, 'App\\Models\\User', 91),
(676, 'App\\Models\\User', 26),
(676, 'App\\Models\\User', 27),
(676, 'App\\Models\\User', 28),
(676, 'App\\Models\\User', 29),
(676, 'App\\Models\\User', 31),
(676, 'App\\Models\\User', 32),
(676, 'App\\Models\\User', 33),
(676, 'App\\Models\\User', 34),
(676, 'App\\Models\\User', 35),
(676, 'App\\Models\\User', 36),
(676, 'App\\Models\\User', 37),
(676, 'App\\Models\\User', 38),
(676, 'App\\Models\\User', 39),
(676, 'App\\Models\\User', 40),
(676, 'App\\Models\\User', 41),
(676, 'App\\Models\\User', 44),
(676, 'App\\Models\\User', 45),
(676, 'App\\Models\\User', 46),
(676, 'App\\Models\\User', 47),
(676, 'App\\Models\\User', 48),
(676, 'App\\Models\\User', 49),
(676, 'App\\Models\\User', 50),
(676, 'App\\Models\\User', 51),
(676, 'App\\Models\\User', 52),
(676, 'App\\Models\\User', 53),
(676, 'App\\Models\\User', 54),
(676, 'App\\Models\\User', 55),
(676, 'App\\Models\\User', 56),
(676, 'App\\Models\\User', 57),
(676, 'App\\Models\\User', 58),
(676, 'App\\Models\\User', 59),
(676, 'App\\Models\\User', 60),
(676, 'App\\Models\\User', 61),
(676, 'App\\Models\\User', 62),
(676, 'App\\Models\\User', 63),
(676, 'App\\Models\\User', 64),
(676, 'App\\Models\\User', 65),
(676, 'App\\Models\\User', 66),
(676, 'App\\Models\\User', 67),
(676, 'App\\Models\\User', 68),
(676, 'App\\Models\\User', 69),
(676, 'App\\Models\\User', 70),
(676, 'App\\Models\\User', 71),
(676, 'App\\Models\\User', 72),
(676, 'App\\Models\\User', 73),
(676, 'App\\Models\\User', 74),
(676, 'App\\Models\\User', 75),
(676, 'App\\Models\\User', 76),
(676, 'App\\Models\\User', 77),
(676, 'App\\Models\\User', 78),
(676, 'App\\Models\\User', 79),
(676, 'App\\Models\\User', 80),
(676, 'App\\Models\\User', 81),
(676, 'App\\Models\\User', 82),
(676, 'App\\Models\\User', 83),
(676, 'App\\Models\\User', 84),
(676, 'App\\Models\\User', 85),
(676, 'App\\Models\\User', 86),
(676, 'App\\Models\\User', 87),
(676, 'App\\Models\\User', 88),
(676, 'App\\Models\\User', 89),
(676, 'App\\Models\\User', 90),
(676, 'App\\Models\\User', 91),
(676, 'App\\Models\\User', 92),
(676, 'App\\Models\\User', 93),
(676, 'App\\Models\\User', 94),
(676, 'App\\Models\\User', 95),
(676, 'App\\Models\\User', 96),
(676, 'App\\Models\\User', 97),
(676, 'App\\Models\\User', 98),
(676, 'App\\Models\\User', 99),
(676, 'App\\Models\\User', 100),
(676, 'App\\Models\\User', 101),
(676, 'App\\Models\\User', 102),
(676, 'App\\Models\\User', 103),
(677, 'App\\Models\\User', 26),
(677, 'App\\Models\\User', 27),
(677, 'App\\Models\\User', 28),
(677, 'App\\Models\\User', 29),
(677, 'App\\Models\\User', 31),
(677, 'App\\Models\\User', 32),
(677, 'App\\Models\\User', 33),
(677, 'App\\Models\\User', 34),
(677, 'App\\Models\\User', 35),
(677, 'App\\Models\\User', 36),
(677, 'App\\Models\\User', 37),
(677, 'App\\Models\\User', 38),
(677, 'App\\Models\\User', 39),
(677, 'App\\Models\\User', 40),
(677, 'App\\Models\\User', 41),
(677, 'App\\Models\\User', 44),
(677, 'App\\Models\\User', 45),
(677, 'App\\Models\\User', 46),
(677, 'App\\Models\\User', 47),
(677, 'App\\Models\\User', 48),
(677, 'App\\Models\\User', 49),
(677, 'App\\Models\\User', 50),
(677, 'App\\Models\\User', 51),
(677, 'App\\Models\\User', 52),
(677, 'App\\Models\\User', 53),
(677, 'App\\Models\\User', 54),
(677, 'App\\Models\\User', 55),
(677, 'App\\Models\\User', 56),
(677, 'App\\Models\\User', 57),
(677, 'App\\Models\\User', 58),
(677, 'App\\Models\\User', 59),
(677, 'App\\Models\\User', 60),
(677, 'App\\Models\\User', 61),
(677, 'App\\Models\\User', 62),
(677, 'App\\Models\\User', 63),
(677, 'App\\Models\\User', 64),
(677, 'App\\Models\\User', 65),
(677, 'App\\Models\\User', 66),
(677, 'App\\Models\\User', 67),
(677, 'App\\Models\\User', 68),
(677, 'App\\Models\\User', 69),
(677, 'App\\Models\\User', 70),
(677, 'App\\Models\\User', 71),
(677, 'App\\Models\\User', 72),
(677, 'App\\Models\\User', 73),
(677, 'App\\Models\\User', 74),
(677, 'App\\Models\\User', 75),
(677, 'App\\Models\\User', 76),
(677, 'App\\Models\\User', 77),
(677, 'App\\Models\\User', 78),
(677, 'App\\Models\\User', 79),
(677, 'App\\Models\\User', 80),
(677, 'App\\Models\\User', 81),
(677, 'App\\Models\\User', 82),
(677, 'App\\Models\\User', 83),
(677, 'App\\Models\\User', 84),
(677, 'App\\Models\\User', 85),
(677, 'App\\Models\\User', 86),
(677, 'App\\Models\\User', 87),
(677, 'App\\Models\\User', 88),
(677, 'App\\Models\\User', 89),
(677, 'App\\Models\\User', 90),
(677, 'App\\Models\\User', 91),
(677, 'App\\Models\\User', 92),
(677, 'App\\Models\\User', 93),
(677, 'App\\Models\\User', 94),
(677, 'App\\Models\\User', 95),
(677, 'App\\Models\\User', 96),
(677, 'App\\Models\\User', 99),
(677, 'App\\Models\\User', 100),
(677, 'App\\Models\\User', 101),
(677, 'App\\Models\\User', 102),
(677, 'App\\Models\\User', 103),
(678, 'App\\Models\\User', 86),
(678, 'App\\Models\\User', 91),
(678, 'App\\Models\\User', 94),
(678, 'App\\Models\\User', 95),
(678, 'App\\Models\\User', 96),
(678, 'App\\Models\\User', 99),
(678, 'App\\Models\\User', 100),
(679, 'App\\Models\\User', 86),
(679, 'App\\Models\\User', 91),
(679, 'App\\Models\\User', 94),
(679, 'App\\Models\\User', 95),
(679, 'App\\Models\\User', 96),
(679, 'App\\Models\\User', 99),
(679, 'App\\Models\\User', 100),
(680, 'App\\Models\\User', 25),
(680, 'App\\Models\\User', 26),
(680, 'App\\Models\\User', 27),
(680, 'App\\Models\\User', 28),
(680, 'App\\Models\\User', 29),
(680, 'App\\Models\\User', 31),
(680, 'App\\Models\\User', 32),
(680, 'App\\Models\\User', 33),
(680, 'App\\Models\\User', 34),
(680, 'App\\Models\\User', 35),
(680, 'App\\Models\\User', 36),
(680, 'App\\Models\\User', 37),
(680, 'App\\Models\\User', 38),
(680, 'App\\Models\\User', 39),
(680, 'App\\Models\\User', 40),
(680, 'App\\Models\\User', 41),
(680, 'App\\Models\\User', 44),
(680, 'App\\Models\\User', 45),
(680, 'App\\Models\\User', 46),
(680, 'App\\Models\\User', 47),
(680, 'App\\Models\\User', 48),
(680, 'App\\Models\\User', 49),
(680, 'App\\Models\\User', 50),
(680, 'App\\Models\\User', 51),
(680, 'App\\Models\\User', 52),
(680, 'App\\Models\\User', 53),
(680, 'App\\Models\\User', 54),
(680, 'App\\Models\\User', 55),
(680, 'App\\Models\\User', 56),
(680, 'App\\Models\\User', 57),
(680, 'App\\Models\\User', 58),
(680, 'App\\Models\\User', 59),
(680, 'App\\Models\\User', 60),
(680, 'App\\Models\\User', 61),
(680, 'App\\Models\\User', 62),
(680, 'App\\Models\\User', 63),
(680, 'App\\Models\\User', 64),
(680, 'App\\Models\\User', 65),
(680, 'App\\Models\\User', 66),
(680, 'App\\Models\\User', 67),
(680, 'App\\Models\\User', 68),
(680, 'App\\Models\\User', 69),
(680, 'App\\Models\\User', 70),
(680, 'App\\Models\\User', 71),
(680, 'App\\Models\\User', 72),
(680, 'App\\Models\\User', 73),
(680, 'App\\Models\\User', 74),
(680, 'App\\Models\\User', 75),
(680, 'App\\Models\\User', 76),
(680, 'App\\Models\\User', 77),
(680, 'App\\Models\\User', 78),
(680, 'App\\Models\\User', 79),
(680, 'App\\Models\\User', 80),
(680, 'App\\Models\\User', 81),
(680, 'App\\Models\\User', 82),
(680, 'App\\Models\\User', 83),
(680, 'App\\Models\\User', 84),
(680, 'App\\Models\\User', 85),
(680, 'App\\Models\\User', 86),
(680, 'App\\Models\\User', 87),
(680, 'App\\Models\\User', 88),
(680, 'App\\Models\\User', 89),
(680, 'App\\Models\\User', 90),
(680, 'App\\Models\\User', 91),
(680, 'App\\Models\\User', 92),
(680, 'App\\Models\\User', 93),
(680, 'App\\Models\\User', 94),
(680, 'App\\Models\\User', 95),
(680, 'App\\Models\\User', 96),
(680, 'App\\Models\\User', 97),
(680, 'App\\Models\\User', 98),
(680, 'App\\Models\\User', 99),
(680, 'App\\Models\\User', 100),
(680, 'App\\Models\\User', 101),
(680, 'App\\Models\\User', 102),
(680, 'App\\Models\\User', 103),
(681, 'App\\Models\\User', 26),
(681, 'App\\Models\\User', 27),
(681, 'App\\Models\\User', 28),
(681, 'App\\Models\\User', 29),
(681, 'App\\Models\\User', 31),
(681, 'App\\Models\\User', 32),
(681, 'App\\Models\\User', 33),
(681, 'App\\Models\\User', 34),
(681, 'App\\Models\\User', 35),
(681, 'App\\Models\\User', 36),
(681, 'App\\Models\\User', 37),
(681, 'App\\Models\\User', 38),
(681, 'App\\Models\\User', 39),
(681, 'App\\Models\\User', 40),
(681, 'App\\Models\\User', 41),
(681, 'App\\Models\\User', 44),
(681, 'App\\Models\\User', 45),
(681, 'App\\Models\\User', 46),
(681, 'App\\Models\\User', 47),
(681, 'App\\Models\\User', 48),
(681, 'App\\Models\\User', 49),
(681, 'App\\Models\\User', 50),
(681, 'App\\Models\\User', 51),
(681, 'App\\Models\\User', 52),
(681, 'App\\Models\\User', 53),
(681, 'App\\Models\\User', 54),
(681, 'App\\Models\\User', 55),
(681, 'App\\Models\\User', 56),
(681, 'App\\Models\\User', 57),
(681, 'App\\Models\\User', 58),
(681, 'App\\Models\\User', 59),
(681, 'App\\Models\\User', 60),
(681, 'App\\Models\\User', 61),
(681, 'App\\Models\\User', 62),
(681, 'App\\Models\\User', 63),
(681, 'App\\Models\\User', 64),
(681, 'App\\Models\\User', 65),
(681, 'App\\Models\\User', 66),
(681, 'App\\Models\\User', 67),
(681, 'App\\Models\\User', 68),
(681, 'App\\Models\\User', 69),
(681, 'App\\Models\\User', 70),
(681, 'App\\Models\\User', 71),
(681, 'App\\Models\\User', 72),
(681, 'App\\Models\\User', 73),
(681, 'App\\Models\\User', 74),
(681, 'App\\Models\\User', 75),
(681, 'App\\Models\\User', 76),
(681, 'App\\Models\\User', 77),
(681, 'App\\Models\\User', 78),
(681, 'App\\Models\\User', 79),
(681, 'App\\Models\\User', 80),
(681, 'App\\Models\\User', 81),
(681, 'App\\Models\\User', 82),
(681, 'App\\Models\\User', 83),
(681, 'App\\Models\\User', 84),
(681, 'App\\Models\\User', 85),
(681, 'App\\Models\\User', 86),
(681, 'App\\Models\\User', 87),
(681, 'App\\Models\\User', 88),
(681, 'App\\Models\\User', 89),
(681, 'App\\Models\\User', 90),
(681, 'App\\Models\\User', 91),
(681, 'App\\Models\\User', 92),
(681, 'App\\Models\\User', 93),
(681, 'App\\Models\\User', 94),
(681, 'App\\Models\\User', 95),
(681, 'App\\Models\\User', 96),
(681, 'App\\Models\\User', 99),
(681, 'App\\Models\\User', 100),
(681, 'App\\Models\\User', 101),
(681, 'App\\Models\\User', 102),
(681, 'App\\Models\\User', 103),
(682, 'App\\Models\\User', 26),
(682, 'App\\Models\\User', 27),
(682, 'App\\Models\\User', 28),
(682, 'App\\Models\\User', 29),
(682, 'App\\Models\\User', 31),
(682, 'App\\Models\\User', 32),
(682, 'App\\Models\\User', 33),
(682, 'App\\Models\\User', 34),
(682, 'App\\Models\\User', 35),
(682, 'App\\Models\\User', 36),
(682, 'App\\Models\\User', 37),
(682, 'App\\Models\\User', 38),
(682, 'App\\Models\\User', 39),
(682, 'App\\Models\\User', 40),
(682, 'App\\Models\\User', 41),
(682, 'App\\Models\\User', 44),
(682, 'App\\Models\\User', 45),
(682, 'App\\Models\\User', 46),
(682, 'App\\Models\\User', 47),
(682, 'App\\Models\\User', 48),
(682, 'App\\Models\\User', 49),
(682, 'App\\Models\\User', 50),
(682, 'App\\Models\\User', 51),
(682, 'App\\Models\\User', 52),
(682, 'App\\Models\\User', 53),
(682, 'App\\Models\\User', 54),
(682, 'App\\Models\\User', 55),
(682, 'App\\Models\\User', 56),
(682, 'App\\Models\\User', 57),
(682, 'App\\Models\\User', 58),
(682, 'App\\Models\\User', 59),
(682, 'App\\Models\\User', 60),
(682, 'App\\Models\\User', 61),
(682, 'App\\Models\\User', 62),
(682, 'App\\Models\\User', 63),
(682, 'App\\Models\\User', 64),
(682, 'App\\Models\\User', 65),
(682, 'App\\Models\\User', 66),
(682, 'App\\Models\\User', 67),
(682, 'App\\Models\\User', 68),
(682, 'App\\Models\\User', 69),
(682, 'App\\Models\\User', 70),
(682, 'App\\Models\\User', 71),
(682, 'App\\Models\\User', 72),
(682, 'App\\Models\\User', 73),
(682, 'App\\Models\\User', 74),
(682, 'App\\Models\\User', 75),
(682, 'App\\Models\\User', 76),
(682, 'App\\Models\\User', 77),
(682, 'App\\Models\\User', 78),
(682, 'App\\Models\\User', 79),
(682, 'App\\Models\\User', 80),
(682, 'App\\Models\\User', 81),
(682, 'App\\Models\\User', 82),
(682, 'App\\Models\\User', 83),
(682, 'App\\Models\\User', 84),
(682, 'App\\Models\\User', 85),
(682, 'App\\Models\\User', 86),
(682, 'App\\Models\\User', 87),
(682, 'App\\Models\\User', 88),
(682, 'App\\Models\\User', 89),
(682, 'App\\Models\\User', 90),
(682, 'App\\Models\\User', 91),
(682, 'App\\Models\\User', 92),
(682, 'App\\Models\\User', 93),
(682, 'App\\Models\\User', 94),
(682, 'App\\Models\\User', 95),
(682, 'App\\Models\\User', 96),
(682, 'App\\Models\\User', 99),
(682, 'App\\Models\\User', 100),
(682, 'App\\Models\\User', 101),
(682, 'App\\Models\\User', 102),
(682, 'App\\Models\\User', 103),
(683, 'App\\Models\\User', 26),
(683, 'App\\Models\\User', 27),
(683, 'App\\Models\\User', 28),
(683, 'App\\Models\\User', 29),
(683, 'App\\Models\\User', 31),
(683, 'App\\Models\\User', 32),
(683, 'App\\Models\\User', 33),
(683, 'App\\Models\\User', 34),
(683, 'App\\Models\\User', 35),
(683, 'App\\Models\\User', 36),
(683, 'App\\Models\\User', 37),
(683, 'App\\Models\\User', 38),
(683, 'App\\Models\\User', 39),
(683, 'App\\Models\\User', 40),
(683, 'App\\Models\\User', 41),
(683, 'App\\Models\\User', 44),
(683, 'App\\Models\\User', 45),
(683, 'App\\Models\\User', 46),
(683, 'App\\Models\\User', 47),
(683, 'App\\Models\\User', 48),
(683, 'App\\Models\\User', 49),
(683, 'App\\Models\\User', 50),
(683, 'App\\Models\\User', 51),
(683, 'App\\Models\\User', 52),
(683, 'App\\Models\\User', 53),
(683, 'App\\Models\\User', 54),
(683, 'App\\Models\\User', 55),
(683, 'App\\Models\\User', 56),
(683, 'App\\Models\\User', 57),
(683, 'App\\Models\\User', 58),
(683, 'App\\Models\\User', 59),
(683, 'App\\Models\\User', 60),
(683, 'App\\Models\\User', 61),
(683, 'App\\Models\\User', 62),
(683, 'App\\Models\\User', 63),
(683, 'App\\Models\\User', 64),
(683, 'App\\Models\\User', 65),
(683, 'App\\Models\\User', 66),
(683, 'App\\Models\\User', 67),
(683, 'App\\Models\\User', 68),
(683, 'App\\Models\\User', 69),
(683, 'App\\Models\\User', 70),
(683, 'App\\Models\\User', 71),
(683, 'App\\Models\\User', 72),
(683, 'App\\Models\\User', 73),
(683, 'App\\Models\\User', 74),
(683, 'App\\Models\\User', 75),
(683, 'App\\Models\\User', 76),
(683, 'App\\Models\\User', 77),
(683, 'App\\Models\\User', 78),
(683, 'App\\Models\\User', 79),
(683, 'App\\Models\\User', 80),
(683, 'App\\Models\\User', 81),
(683, 'App\\Models\\User', 82),
(683, 'App\\Models\\User', 83),
(683, 'App\\Models\\User', 84),
(683, 'App\\Models\\User', 85),
(683, 'App\\Models\\User', 86),
(683, 'App\\Models\\User', 87),
(683, 'App\\Models\\User', 88),
(683, 'App\\Models\\User', 89),
(683, 'App\\Models\\User', 90),
(683, 'App\\Models\\User', 91),
(683, 'App\\Models\\User', 92),
(683, 'App\\Models\\User', 93),
(683, 'App\\Models\\User', 94),
(683, 'App\\Models\\User', 95),
(683, 'App\\Models\\User', 96),
(683, 'App\\Models\\User', 97),
(683, 'App\\Models\\User', 98),
(683, 'App\\Models\\User', 99),
(683, 'App\\Models\\User', 100),
(683, 'App\\Models\\User', 101),
(683, 'App\\Models\\User', 102),
(683, 'App\\Models\\User', 103),
(684, 'App\\Models\\User', 26),
(684, 'App\\Models\\User', 27),
(684, 'App\\Models\\User', 28),
(684, 'App\\Models\\User', 29),
(684, 'App\\Models\\User', 31),
(684, 'App\\Models\\User', 32),
(684, 'App\\Models\\User', 33),
(684, 'App\\Models\\User', 34),
(684, 'App\\Models\\User', 35),
(684, 'App\\Models\\User', 36),
(684, 'App\\Models\\User', 37),
(684, 'App\\Models\\User', 38),
(684, 'App\\Models\\User', 39),
(684, 'App\\Models\\User', 40),
(684, 'App\\Models\\User', 41),
(684, 'App\\Models\\User', 44),
(684, 'App\\Models\\User', 45),
(684, 'App\\Models\\User', 46),
(684, 'App\\Models\\User', 47),
(684, 'App\\Models\\User', 48),
(684, 'App\\Models\\User', 49),
(684, 'App\\Models\\User', 50),
(684, 'App\\Models\\User', 51),
(684, 'App\\Models\\User', 52),
(684, 'App\\Models\\User', 53),
(684, 'App\\Models\\User', 54),
(684, 'App\\Models\\User', 55),
(684, 'App\\Models\\User', 56),
(684, 'App\\Models\\User', 57),
(684, 'App\\Models\\User', 58),
(684, 'App\\Models\\User', 59),
(684, 'App\\Models\\User', 60),
(684, 'App\\Models\\User', 61),
(684, 'App\\Models\\User', 62),
(684, 'App\\Models\\User', 63),
(684, 'App\\Models\\User', 64),
(684, 'App\\Models\\User', 65),
(684, 'App\\Models\\User', 66),
(684, 'App\\Models\\User', 67),
(684, 'App\\Models\\User', 68),
(684, 'App\\Models\\User', 69),
(684, 'App\\Models\\User', 70),
(684, 'App\\Models\\User', 71),
(684, 'App\\Models\\User', 72),
(684, 'App\\Models\\User', 73),
(684, 'App\\Models\\User', 74),
(684, 'App\\Models\\User', 75),
(684, 'App\\Models\\User', 76),
(684, 'App\\Models\\User', 77),
(684, 'App\\Models\\User', 78),
(684, 'App\\Models\\User', 79),
(684, 'App\\Models\\User', 80),
(684, 'App\\Models\\User', 81),
(684, 'App\\Models\\User', 82),
(684, 'App\\Models\\User', 83),
(684, 'App\\Models\\User', 84),
(684, 'App\\Models\\User', 85),
(684, 'App\\Models\\User', 86),
(684, 'App\\Models\\User', 87),
(684, 'App\\Models\\User', 88),
(684, 'App\\Models\\User', 89),
(684, 'App\\Models\\User', 90),
(684, 'App\\Models\\User', 91),
(684, 'App\\Models\\User', 92),
(684, 'App\\Models\\User', 93),
(684, 'App\\Models\\User', 94),
(684, 'App\\Models\\User', 95),
(684, 'App\\Models\\User', 96),
(684, 'App\\Models\\User', 99),
(684, 'App\\Models\\User', 100),
(684, 'App\\Models\\User', 101),
(684, 'App\\Models\\User', 102),
(684, 'App\\Models\\User', 103),
(685, 'App\\Models\\User', 86),
(685, 'App\\Models\\User', 91),
(685, 'App\\Models\\User', 94),
(685, 'App\\Models\\User', 95),
(685, 'App\\Models\\User', 96),
(685, 'App\\Models\\User', 99),
(685, 'App\\Models\\User', 100),
(686, 'App\\Models\\User', 86),
(686, 'App\\Models\\User', 91),
(686, 'App\\Models\\User', 94),
(686, 'App\\Models\\User', 95),
(686, 'App\\Models\\User', 96),
(686, 'App\\Models\\User', 99),
(686, 'App\\Models\\User', 100),
(687, 'App\\Models\\User', 26),
(687, 'App\\Models\\User', 27),
(687, 'App\\Models\\User', 28),
(687, 'App\\Models\\User', 29),
(687, 'App\\Models\\User', 31),
(687, 'App\\Models\\User', 32),
(687, 'App\\Models\\User', 33),
(687, 'App\\Models\\User', 34),
(687, 'App\\Models\\User', 35),
(687, 'App\\Models\\User', 36),
(687, 'App\\Models\\User', 37),
(687, 'App\\Models\\User', 38),
(687, 'App\\Models\\User', 39),
(687, 'App\\Models\\User', 40),
(687, 'App\\Models\\User', 41),
(687, 'App\\Models\\User', 44),
(687, 'App\\Models\\User', 45),
(687, 'App\\Models\\User', 46),
(687, 'App\\Models\\User', 47),
(687, 'App\\Models\\User', 48),
(687, 'App\\Models\\User', 49),
(687, 'App\\Models\\User', 50),
(687, 'App\\Models\\User', 51),
(687, 'App\\Models\\User', 52),
(687, 'App\\Models\\User', 53),
(687, 'App\\Models\\User', 54),
(687, 'App\\Models\\User', 55),
(687, 'App\\Models\\User', 56),
(687, 'App\\Models\\User', 57),
(687, 'App\\Models\\User', 58),
(687, 'App\\Models\\User', 59),
(687, 'App\\Models\\User', 60),
(687, 'App\\Models\\User', 61),
(687, 'App\\Models\\User', 62),
(687, 'App\\Models\\User', 63),
(687, 'App\\Models\\User', 64),
(687, 'App\\Models\\User', 65),
(687, 'App\\Models\\User', 66),
(687, 'App\\Models\\User', 67),
(687, 'App\\Models\\User', 68),
(687, 'App\\Models\\User', 69),
(687, 'App\\Models\\User', 70),
(687, 'App\\Models\\User', 71),
(687, 'App\\Models\\User', 72),
(687, 'App\\Models\\User', 73),
(687, 'App\\Models\\User', 74),
(687, 'App\\Models\\User', 75),
(687, 'App\\Models\\User', 76),
(687, 'App\\Models\\User', 77),
(687, 'App\\Models\\User', 78),
(687, 'App\\Models\\User', 79),
(687, 'App\\Models\\User', 80),
(687, 'App\\Models\\User', 81),
(687, 'App\\Models\\User', 82),
(687, 'App\\Models\\User', 83),
(687, 'App\\Models\\User', 84),
(687, 'App\\Models\\User', 85),
(687, 'App\\Models\\User', 86),
(687, 'App\\Models\\User', 87),
(687, 'App\\Models\\User', 88),
(687, 'App\\Models\\User', 89),
(687, 'App\\Models\\User', 90),
(687, 'App\\Models\\User', 91),
(687, 'App\\Models\\User', 92),
(687, 'App\\Models\\User', 93),
(687, 'App\\Models\\User', 94),
(687, 'App\\Models\\User', 95),
(687, 'App\\Models\\User', 96),
(687, 'App\\Models\\User', 97),
(687, 'App\\Models\\User', 98),
(687, 'App\\Models\\User', 99),
(687, 'App\\Models\\User', 100),
(687, 'App\\Models\\User', 101),
(687, 'App\\Models\\User', 102),
(687, 'App\\Models\\User', 103),
(688, 'App\\Models\\User', 26),
(688, 'App\\Models\\User', 27),
(688, 'App\\Models\\User', 28),
(688, 'App\\Models\\User', 29),
(688, 'App\\Models\\User', 31),
(688, 'App\\Models\\User', 32),
(688, 'App\\Models\\User', 33),
(688, 'App\\Models\\User', 34),
(688, 'App\\Models\\User', 35),
(688, 'App\\Models\\User', 36),
(688, 'App\\Models\\User', 37),
(688, 'App\\Models\\User', 38),
(688, 'App\\Models\\User', 39),
(688, 'App\\Models\\User', 40),
(688, 'App\\Models\\User', 41),
(688, 'App\\Models\\User', 44),
(688, 'App\\Models\\User', 45),
(688, 'App\\Models\\User', 46),
(688, 'App\\Models\\User', 47),
(688, 'App\\Models\\User', 48),
(688, 'App\\Models\\User', 49),
(688, 'App\\Models\\User', 50),
(688, 'App\\Models\\User', 51),
(688, 'App\\Models\\User', 52),
(688, 'App\\Models\\User', 53),
(688, 'App\\Models\\User', 54),
(688, 'App\\Models\\User', 55),
(688, 'App\\Models\\User', 56),
(688, 'App\\Models\\User', 57),
(688, 'App\\Models\\User', 58),
(688, 'App\\Models\\User', 59),
(688, 'App\\Models\\User', 60),
(688, 'App\\Models\\User', 61),
(688, 'App\\Models\\User', 62),
(688, 'App\\Models\\User', 63),
(688, 'App\\Models\\User', 64),
(688, 'App\\Models\\User', 65),
(688, 'App\\Models\\User', 66),
(688, 'App\\Models\\User', 67),
(688, 'App\\Models\\User', 68),
(688, 'App\\Models\\User', 69),
(688, 'App\\Models\\User', 70),
(688, 'App\\Models\\User', 71),
(688, 'App\\Models\\User', 72),
(688, 'App\\Models\\User', 73),
(688, 'App\\Models\\User', 74),
(688, 'App\\Models\\User', 75),
(688, 'App\\Models\\User', 76),
(688, 'App\\Models\\User', 77),
(688, 'App\\Models\\User', 78),
(688, 'App\\Models\\User', 79),
(688, 'App\\Models\\User', 80),
(688, 'App\\Models\\User', 81),
(688, 'App\\Models\\User', 82),
(688, 'App\\Models\\User', 83),
(688, 'App\\Models\\User', 84),
(688, 'App\\Models\\User', 85),
(688, 'App\\Models\\User', 86),
(688, 'App\\Models\\User', 87),
(688, 'App\\Models\\User', 88),
(688, 'App\\Models\\User', 89),
(688, 'App\\Models\\User', 90),
(688, 'App\\Models\\User', 91),
(688, 'App\\Models\\User', 92),
(688, 'App\\Models\\User', 93),
(688, 'App\\Models\\User', 94),
(688, 'App\\Models\\User', 95),
(688, 'App\\Models\\User', 96),
(688, 'App\\Models\\User', 97),
(688, 'App\\Models\\User', 98),
(688, 'App\\Models\\User', 99),
(688, 'App\\Models\\User', 100),
(688, 'App\\Models\\User', 101),
(688, 'App\\Models\\User', 102),
(688, 'App\\Models\\User', 103),
(689, 'App\\Models\\User', 26),
(689, 'App\\Models\\User', 27),
(689, 'App\\Models\\User', 28),
(689, 'App\\Models\\User', 29),
(689, 'App\\Models\\User', 31),
(689, 'App\\Models\\User', 32),
(689, 'App\\Models\\User', 33),
(689, 'App\\Models\\User', 34),
(689, 'App\\Models\\User', 35),
(689, 'App\\Models\\User', 36),
(689, 'App\\Models\\User', 37),
(689, 'App\\Models\\User', 38),
(689, 'App\\Models\\User', 39),
(689, 'App\\Models\\User', 40),
(689, 'App\\Models\\User', 41),
(689, 'App\\Models\\User', 44),
(689, 'App\\Models\\User', 45),
(689, 'App\\Models\\User', 46),
(689, 'App\\Models\\User', 47),
(689, 'App\\Models\\User', 48),
(689, 'App\\Models\\User', 49),
(689, 'App\\Models\\User', 50),
(689, 'App\\Models\\User', 51),
(689, 'App\\Models\\User', 52),
(689, 'App\\Models\\User', 53),
(689, 'App\\Models\\User', 54),
(689, 'App\\Models\\User', 55),
(689, 'App\\Models\\User', 56),
(689, 'App\\Models\\User', 57),
(689, 'App\\Models\\User', 58),
(689, 'App\\Models\\User', 59),
(689, 'App\\Models\\User', 60),
(689, 'App\\Models\\User', 61),
(689, 'App\\Models\\User', 62),
(689, 'App\\Models\\User', 63),
(689, 'App\\Models\\User', 64),
(689, 'App\\Models\\User', 65),
(689, 'App\\Models\\User', 66),
(689, 'App\\Models\\User', 67),
(689, 'App\\Models\\User', 68),
(689, 'App\\Models\\User', 69),
(689, 'App\\Models\\User', 70),
(689, 'App\\Models\\User', 71),
(689, 'App\\Models\\User', 72),
(689, 'App\\Models\\User', 73),
(689, 'App\\Models\\User', 74),
(689, 'App\\Models\\User', 75),
(689, 'App\\Models\\User', 76),
(689, 'App\\Models\\User', 77),
(689, 'App\\Models\\User', 78),
(689, 'App\\Models\\User', 79),
(689, 'App\\Models\\User', 80),
(689, 'App\\Models\\User', 81),
(689, 'App\\Models\\User', 82),
(689, 'App\\Models\\User', 83),
(689, 'App\\Models\\User', 84),
(689, 'App\\Models\\User', 85),
(689, 'App\\Models\\User', 86),
(689, 'App\\Models\\User', 87),
(689, 'App\\Models\\User', 88),
(689, 'App\\Models\\User', 89),
(689, 'App\\Models\\User', 90),
(689, 'App\\Models\\User', 91),
(689, 'App\\Models\\User', 92),
(689, 'App\\Models\\User', 93),
(689, 'App\\Models\\User', 94),
(689, 'App\\Models\\User', 95),
(689, 'App\\Models\\User', 96),
(689, 'App\\Models\\User', 99),
(689, 'App\\Models\\User', 100),
(689, 'App\\Models\\User', 101),
(689, 'App\\Models\\User', 102),
(689, 'App\\Models\\User', 103),
(690, 'App\\Models\\User', 26),
(690, 'App\\Models\\User', 27),
(690, 'App\\Models\\User', 28),
(690, 'App\\Models\\User', 29),
(690, 'App\\Models\\User', 31),
(690, 'App\\Models\\User', 32),
(690, 'App\\Models\\User', 33),
(690, 'App\\Models\\User', 34),
(690, 'App\\Models\\User', 35),
(690, 'App\\Models\\User', 36),
(690, 'App\\Models\\User', 37),
(690, 'App\\Models\\User', 38),
(690, 'App\\Models\\User', 39),
(690, 'App\\Models\\User', 40),
(690, 'App\\Models\\User', 41),
(690, 'App\\Models\\User', 44),
(690, 'App\\Models\\User', 45),
(690, 'App\\Models\\User', 46),
(690, 'App\\Models\\User', 47),
(690, 'App\\Models\\User', 48),
(690, 'App\\Models\\User', 49),
(690, 'App\\Models\\User', 50),
(690, 'App\\Models\\User', 51),
(690, 'App\\Models\\User', 52),
(690, 'App\\Models\\User', 53),
(690, 'App\\Models\\User', 54),
(690, 'App\\Models\\User', 55),
(690, 'App\\Models\\User', 56),
(690, 'App\\Models\\User', 57),
(690, 'App\\Models\\User', 58),
(690, 'App\\Models\\User', 59),
(690, 'App\\Models\\User', 60),
(690, 'App\\Models\\User', 61),
(690, 'App\\Models\\User', 62),
(690, 'App\\Models\\User', 63),
(690, 'App\\Models\\User', 64),
(690, 'App\\Models\\User', 65),
(690, 'App\\Models\\User', 66),
(690, 'App\\Models\\User', 67),
(690, 'App\\Models\\User', 68),
(690, 'App\\Models\\User', 69),
(690, 'App\\Models\\User', 70),
(690, 'App\\Models\\User', 71),
(690, 'App\\Models\\User', 72),
(690, 'App\\Models\\User', 73),
(690, 'App\\Models\\User', 74),
(690, 'App\\Models\\User', 75),
(690, 'App\\Models\\User', 76),
(690, 'App\\Models\\User', 77),
(690, 'App\\Models\\User', 78),
(690, 'App\\Models\\User', 79),
(690, 'App\\Models\\User', 80),
(690, 'App\\Models\\User', 81),
(690, 'App\\Models\\User', 82),
(690, 'App\\Models\\User', 83),
(690, 'App\\Models\\User', 84),
(690, 'App\\Models\\User', 85),
(690, 'App\\Models\\User', 86),
(690, 'App\\Models\\User', 87),
(690, 'App\\Models\\User', 88),
(690, 'App\\Models\\User', 89),
(690, 'App\\Models\\User', 90),
(690, 'App\\Models\\User', 91),
(690, 'App\\Models\\User', 92),
(690, 'App\\Models\\User', 93),
(690, 'App\\Models\\User', 94),
(690, 'App\\Models\\User', 95),
(690, 'App\\Models\\User', 96),
(690, 'App\\Models\\User', 99),
(690, 'App\\Models\\User', 100),
(690, 'App\\Models\\User', 101),
(690, 'App\\Models\\User', 102),
(690, 'App\\Models\\User', 103),
(691, 'App\\Models\\User', 86),
(691, 'App\\Models\\User', 91),
(691, 'App\\Models\\User', 94),
(691, 'App\\Models\\User', 95),
(691, 'App\\Models\\User', 96),
(691, 'App\\Models\\User', 99),
(691, 'App\\Models\\User', 100),
(692, 'App\\Models\\User', 26),
(692, 'App\\Models\\User', 27),
(692, 'App\\Models\\User', 28),
(692, 'App\\Models\\User', 29),
(692, 'App\\Models\\User', 31),
(692, 'App\\Models\\User', 32),
(692, 'App\\Models\\User', 33),
(692, 'App\\Models\\User', 34),
(692, 'App\\Models\\User', 35),
(692, 'App\\Models\\User', 36),
(692, 'App\\Models\\User', 37),
(692, 'App\\Models\\User', 38),
(692, 'App\\Models\\User', 39),
(692, 'App\\Models\\User', 40),
(692, 'App\\Models\\User', 41),
(692, 'App\\Models\\User', 44),
(692, 'App\\Models\\User', 45),
(692, 'App\\Models\\User', 46),
(692, 'App\\Models\\User', 47),
(692, 'App\\Models\\User', 48),
(692, 'App\\Models\\User', 49),
(692, 'App\\Models\\User', 50),
(692, 'App\\Models\\User', 51),
(692, 'App\\Models\\User', 52),
(692, 'App\\Models\\User', 53),
(692, 'App\\Models\\User', 54),
(692, 'App\\Models\\User', 55),
(692, 'App\\Models\\User', 56),
(692, 'App\\Models\\User', 57),
(692, 'App\\Models\\User', 58),
(692, 'App\\Models\\User', 59),
(692, 'App\\Models\\User', 60),
(692, 'App\\Models\\User', 61),
(692, 'App\\Models\\User', 62),
(692, 'App\\Models\\User', 63),
(692, 'App\\Models\\User', 64),
(692, 'App\\Models\\User', 65),
(692, 'App\\Models\\User', 66),
(692, 'App\\Models\\User', 67),
(692, 'App\\Models\\User', 68),
(692, 'App\\Models\\User', 69),
(692, 'App\\Models\\User', 70),
(692, 'App\\Models\\User', 71),
(692, 'App\\Models\\User', 72),
(692, 'App\\Models\\User', 73),
(692, 'App\\Models\\User', 74),
(692, 'App\\Models\\User', 75),
(692, 'App\\Models\\User', 76),
(692, 'App\\Models\\User', 77),
(692, 'App\\Models\\User', 78),
(692, 'App\\Models\\User', 79),
(692, 'App\\Models\\User', 80),
(692, 'App\\Models\\User', 81),
(692, 'App\\Models\\User', 82),
(692, 'App\\Models\\User', 83),
(692, 'App\\Models\\User', 84),
(692, 'App\\Models\\User', 85),
(692, 'App\\Models\\User', 86),
(692, 'App\\Models\\User', 87),
(692, 'App\\Models\\User', 88),
(692, 'App\\Models\\User', 89),
(692, 'App\\Models\\User', 90),
(692, 'App\\Models\\User', 91),
(692, 'App\\Models\\User', 92),
(692, 'App\\Models\\User', 93),
(692, 'App\\Models\\User', 94),
(692, 'App\\Models\\User', 95),
(692, 'App\\Models\\User', 96),
(692, 'App\\Models\\User', 97),
(692, 'App\\Models\\User', 98),
(692, 'App\\Models\\User', 99),
(692, 'App\\Models\\User', 100),
(692, 'App\\Models\\User', 101),
(692, 'App\\Models\\User', 102),
(692, 'App\\Models\\User', 103),
(693, 'App\\Models\\User', 26),
(693, 'App\\Models\\User', 27),
(693, 'App\\Models\\User', 28),
(693, 'App\\Models\\User', 29),
(693, 'App\\Models\\User', 31),
(693, 'App\\Models\\User', 32),
(693, 'App\\Models\\User', 33),
(693, 'App\\Models\\User', 34),
(693, 'App\\Models\\User', 35),
(693, 'App\\Models\\User', 36),
(693, 'App\\Models\\User', 37),
(693, 'App\\Models\\User', 38),
(693, 'App\\Models\\User', 39),
(693, 'App\\Models\\User', 40),
(693, 'App\\Models\\User', 41),
(693, 'App\\Models\\User', 44),
(693, 'App\\Models\\User', 45),
(693, 'App\\Models\\User', 46),
(693, 'App\\Models\\User', 47),
(693, 'App\\Models\\User', 48),
(693, 'App\\Models\\User', 49),
(693, 'App\\Models\\User', 50),
(693, 'App\\Models\\User', 51),
(693, 'App\\Models\\User', 52),
(693, 'App\\Models\\User', 53),
(693, 'App\\Models\\User', 54),
(693, 'App\\Models\\User', 55),
(693, 'App\\Models\\User', 56),
(693, 'App\\Models\\User', 57),
(693, 'App\\Models\\User', 58),
(693, 'App\\Models\\User', 59),
(693, 'App\\Models\\User', 60),
(693, 'App\\Models\\User', 61),
(693, 'App\\Models\\User', 62),
(693, 'App\\Models\\User', 63),
(693, 'App\\Models\\User', 64),
(693, 'App\\Models\\User', 65),
(693, 'App\\Models\\User', 66),
(693, 'App\\Models\\User', 67),
(693, 'App\\Models\\User', 68),
(693, 'App\\Models\\User', 69),
(693, 'App\\Models\\User', 70),
(693, 'App\\Models\\User', 71),
(693, 'App\\Models\\User', 72),
(693, 'App\\Models\\User', 73),
(693, 'App\\Models\\User', 74),
(693, 'App\\Models\\User', 75),
(693, 'App\\Models\\User', 76),
(693, 'App\\Models\\User', 77),
(693, 'App\\Models\\User', 78),
(693, 'App\\Models\\User', 79),
(693, 'App\\Models\\User', 80),
(693, 'App\\Models\\User', 81),
(693, 'App\\Models\\User', 82),
(693, 'App\\Models\\User', 83),
(693, 'App\\Models\\User', 84),
(693, 'App\\Models\\User', 85),
(693, 'App\\Models\\User', 86),
(693, 'App\\Models\\User', 87),
(693, 'App\\Models\\User', 88),
(693, 'App\\Models\\User', 89),
(693, 'App\\Models\\User', 90),
(693, 'App\\Models\\User', 91),
(693, 'App\\Models\\User', 92),
(693, 'App\\Models\\User', 93),
(693, 'App\\Models\\User', 94),
(693, 'App\\Models\\User', 95),
(693, 'App\\Models\\User', 96),
(693, 'App\\Models\\User', 99),
(693, 'App\\Models\\User', 100),
(693, 'App\\Models\\User', 101),
(693, 'App\\Models\\User', 102),
(693, 'App\\Models\\User', 103),
(694, 'App\\Models\\User', 26),
(694, 'App\\Models\\User', 27),
(694, 'App\\Models\\User', 28),
(694, 'App\\Models\\User', 29),
(694, 'App\\Models\\User', 31),
(694, 'App\\Models\\User', 32),
(694, 'App\\Models\\User', 33),
(694, 'App\\Models\\User', 34),
(694, 'App\\Models\\User', 35),
(694, 'App\\Models\\User', 36),
(694, 'App\\Models\\User', 37),
(694, 'App\\Models\\User', 38),
(694, 'App\\Models\\User', 39),
(694, 'App\\Models\\User', 40),
(694, 'App\\Models\\User', 41),
(694, 'App\\Models\\User', 44),
(694, 'App\\Models\\User', 45),
(694, 'App\\Models\\User', 46),
(694, 'App\\Models\\User', 47),
(694, 'App\\Models\\User', 48),
(694, 'App\\Models\\User', 49),
(694, 'App\\Models\\User', 50),
(694, 'App\\Models\\User', 51),
(694, 'App\\Models\\User', 52),
(694, 'App\\Models\\User', 53),
(694, 'App\\Models\\User', 54),
(694, 'App\\Models\\User', 55),
(694, 'App\\Models\\User', 56),
(694, 'App\\Models\\User', 57),
(694, 'App\\Models\\User', 58),
(694, 'App\\Models\\User', 59),
(694, 'App\\Models\\User', 60),
(694, 'App\\Models\\User', 61),
(694, 'App\\Models\\User', 62),
(694, 'App\\Models\\User', 63),
(694, 'App\\Models\\User', 64),
(694, 'App\\Models\\User', 65),
(694, 'App\\Models\\User', 66),
(694, 'App\\Models\\User', 67),
(694, 'App\\Models\\User', 68),
(694, 'App\\Models\\User', 69),
(694, 'App\\Models\\User', 70),
(694, 'App\\Models\\User', 71),
(694, 'App\\Models\\User', 72),
(694, 'App\\Models\\User', 73),
(694, 'App\\Models\\User', 74),
(694, 'App\\Models\\User', 75),
(694, 'App\\Models\\User', 76),
(694, 'App\\Models\\User', 77),
(694, 'App\\Models\\User', 78),
(694, 'App\\Models\\User', 79),
(694, 'App\\Models\\User', 80),
(694, 'App\\Models\\User', 81),
(694, 'App\\Models\\User', 82),
(694, 'App\\Models\\User', 83),
(694, 'App\\Models\\User', 84),
(694, 'App\\Models\\User', 85),
(694, 'App\\Models\\User', 86),
(694, 'App\\Models\\User', 87),
(694, 'App\\Models\\User', 88),
(694, 'App\\Models\\User', 89),
(694, 'App\\Models\\User', 90),
(694, 'App\\Models\\User', 91),
(694, 'App\\Models\\User', 92),
(694, 'App\\Models\\User', 93),
(694, 'App\\Models\\User', 94),
(694, 'App\\Models\\User', 95),
(694, 'App\\Models\\User', 96),
(694, 'App\\Models\\User', 99),
(694, 'App\\Models\\User', 100),
(694, 'App\\Models\\User', 101),
(694, 'App\\Models\\User', 102),
(694, 'App\\Models\\User', 103),
(695, 'App\\Models\\User', 86),
(695, 'App\\Models\\User', 91),
(695, 'App\\Models\\User', 94),
(695, 'App\\Models\\User', 95),
(695, 'App\\Models\\User', 96),
(695, 'App\\Models\\User', 99),
(695, 'App\\Models\\User', 100),
(696, 'App\\Models\\User', 26),
(696, 'App\\Models\\User', 27),
(696, 'App\\Models\\User', 28),
(696, 'App\\Models\\User', 29),
(696, 'App\\Models\\User', 30),
(696, 'App\\Models\\User', 31),
(696, 'App\\Models\\User', 32),
(696, 'App\\Models\\User', 33),
(696, 'App\\Models\\User', 34),
(696, 'App\\Models\\User', 35),
(696, 'App\\Models\\User', 36),
(696, 'App\\Models\\User', 37),
(696, 'App\\Models\\User', 38),
(696, 'App\\Models\\User', 39),
(696, 'App\\Models\\User', 40),
(696, 'App\\Models\\User', 41),
(696, 'App\\Models\\User', 44),
(696, 'App\\Models\\User', 45),
(696, 'App\\Models\\User', 46),
(696, 'App\\Models\\User', 47),
(696, 'App\\Models\\User', 48),
(696, 'App\\Models\\User', 49),
(696, 'App\\Models\\User', 50),
(696, 'App\\Models\\User', 51),
(696, 'App\\Models\\User', 52),
(696, 'App\\Models\\User', 53),
(696, 'App\\Models\\User', 54),
(696, 'App\\Models\\User', 55),
(696, 'App\\Models\\User', 56),
(696, 'App\\Models\\User', 57),
(696, 'App\\Models\\User', 58),
(696, 'App\\Models\\User', 59),
(696, 'App\\Models\\User', 60),
(696, 'App\\Models\\User', 61),
(696, 'App\\Models\\User', 62),
(696, 'App\\Models\\User', 63),
(696, 'App\\Models\\User', 64),
(696, 'App\\Models\\User', 65),
(696, 'App\\Models\\User', 66),
(696, 'App\\Models\\User', 67),
(696, 'App\\Models\\User', 68),
(696, 'App\\Models\\User', 69),
(696, 'App\\Models\\User', 70),
(696, 'App\\Models\\User', 71),
(696, 'App\\Models\\User', 72),
(696, 'App\\Models\\User', 73),
(696, 'App\\Models\\User', 74),
(696, 'App\\Models\\User', 75),
(696, 'App\\Models\\User', 76),
(696, 'App\\Models\\User', 77),
(696, 'App\\Models\\User', 78),
(696, 'App\\Models\\User', 79),
(696, 'App\\Models\\User', 80),
(696, 'App\\Models\\User', 81),
(696, 'App\\Models\\User', 82),
(696, 'App\\Models\\User', 83),
(696, 'App\\Models\\User', 84),
(696, 'App\\Models\\User', 85),
(696, 'App\\Models\\User', 86),
(696, 'App\\Models\\User', 87),
(696, 'App\\Models\\User', 88),
(696, 'App\\Models\\User', 89),
(696, 'App\\Models\\User', 90),
(696, 'App\\Models\\User', 91),
(696, 'App\\Models\\User', 92),
(696, 'App\\Models\\User', 93),
(696, 'App\\Models\\User', 94),
(696, 'App\\Models\\User', 95),
(696, 'App\\Models\\User', 96),
(696, 'App\\Models\\User', 97),
(696, 'App\\Models\\User', 98),
(696, 'App\\Models\\User', 99),
(696, 'App\\Models\\User', 100),
(696, 'App\\Models\\User', 101),
(696, 'App\\Models\\User', 102),
(696, 'App\\Models\\User', 103),
(697, 'App\\Models\\User', 26),
(697, 'App\\Models\\User', 27),
(697, 'App\\Models\\User', 28),
(697, 'App\\Models\\User', 29),
(697, 'App\\Models\\User', 31),
(697, 'App\\Models\\User', 32),
(697, 'App\\Models\\User', 33),
(697, 'App\\Models\\User', 34),
(697, 'App\\Models\\User', 35),
(697, 'App\\Models\\User', 36),
(697, 'App\\Models\\User', 37),
(697, 'App\\Models\\User', 38),
(697, 'App\\Models\\User', 39),
(697, 'App\\Models\\User', 40),
(697, 'App\\Models\\User', 41),
(697, 'App\\Models\\User', 44),
(697, 'App\\Models\\User', 45),
(697, 'App\\Models\\User', 46),
(697, 'App\\Models\\User', 47),
(697, 'App\\Models\\User', 48),
(697, 'App\\Models\\User', 49),
(697, 'App\\Models\\User', 50),
(697, 'App\\Models\\User', 51),
(697, 'App\\Models\\User', 52),
(697, 'App\\Models\\User', 53),
(697, 'App\\Models\\User', 54),
(697, 'App\\Models\\User', 55),
(697, 'App\\Models\\User', 56),
(697, 'App\\Models\\User', 57),
(697, 'App\\Models\\User', 58),
(697, 'App\\Models\\User', 59),
(697, 'App\\Models\\User', 60),
(697, 'App\\Models\\User', 61),
(697, 'App\\Models\\User', 62),
(697, 'App\\Models\\User', 63),
(697, 'App\\Models\\User', 64),
(697, 'App\\Models\\User', 65),
(697, 'App\\Models\\User', 66),
(697, 'App\\Models\\User', 67),
(697, 'App\\Models\\User', 68),
(697, 'App\\Models\\User', 69),
(697, 'App\\Models\\User', 70),
(697, 'App\\Models\\User', 71),
(697, 'App\\Models\\User', 72),
(697, 'App\\Models\\User', 73),
(697, 'App\\Models\\User', 74),
(697, 'App\\Models\\User', 75),
(697, 'App\\Models\\User', 76),
(697, 'App\\Models\\User', 77),
(697, 'App\\Models\\User', 78),
(697, 'App\\Models\\User', 79),
(697, 'App\\Models\\User', 80),
(697, 'App\\Models\\User', 81),
(697, 'App\\Models\\User', 82),
(697, 'App\\Models\\User', 83),
(697, 'App\\Models\\User', 84),
(697, 'App\\Models\\User', 85),
(697, 'App\\Models\\User', 86),
(697, 'App\\Models\\User', 87),
(697, 'App\\Models\\User', 88),
(697, 'App\\Models\\User', 89),
(697, 'App\\Models\\User', 90),
(697, 'App\\Models\\User', 91),
(697, 'App\\Models\\User', 92),
(697, 'App\\Models\\User', 93),
(697, 'App\\Models\\User', 94),
(697, 'App\\Models\\User', 95),
(697, 'App\\Models\\User', 96),
(697, 'App\\Models\\User', 99),
(697, 'App\\Models\\User', 100),
(697, 'App\\Models\\User', 101),
(697, 'App\\Models\\User', 102),
(697, 'App\\Models\\User', 103),
(698, 'App\\Models\\User', 26),
(698, 'App\\Models\\User', 27),
(698, 'App\\Models\\User', 28),
(698, 'App\\Models\\User', 29),
(698, 'App\\Models\\User', 31),
(698, 'App\\Models\\User', 32),
(698, 'App\\Models\\User', 33),
(698, 'App\\Models\\User', 34),
(698, 'App\\Models\\User', 35),
(698, 'App\\Models\\User', 36),
(698, 'App\\Models\\User', 37),
(698, 'App\\Models\\User', 38),
(698, 'App\\Models\\User', 39),
(698, 'App\\Models\\User', 40),
(698, 'App\\Models\\User', 41),
(698, 'App\\Models\\User', 44),
(698, 'App\\Models\\User', 45),
(698, 'App\\Models\\User', 46),
(698, 'App\\Models\\User', 47),
(698, 'App\\Models\\User', 48),
(698, 'App\\Models\\User', 49),
(698, 'App\\Models\\User', 50),
(698, 'App\\Models\\User', 51),
(698, 'App\\Models\\User', 52),
(698, 'App\\Models\\User', 53),
(698, 'App\\Models\\User', 54),
(698, 'App\\Models\\User', 55),
(698, 'App\\Models\\User', 56),
(698, 'App\\Models\\User', 57),
(698, 'App\\Models\\User', 58),
(698, 'App\\Models\\User', 59),
(698, 'App\\Models\\User', 60),
(698, 'App\\Models\\User', 61),
(698, 'App\\Models\\User', 62),
(698, 'App\\Models\\User', 63),
(698, 'App\\Models\\User', 64),
(698, 'App\\Models\\User', 65),
(698, 'App\\Models\\User', 66),
(698, 'App\\Models\\User', 67),
(698, 'App\\Models\\User', 68),
(698, 'App\\Models\\User', 69),
(698, 'App\\Models\\User', 70),
(698, 'App\\Models\\User', 71),
(698, 'App\\Models\\User', 72),
(698, 'App\\Models\\User', 73),
(698, 'App\\Models\\User', 74),
(698, 'App\\Models\\User', 75),
(698, 'App\\Models\\User', 76),
(698, 'App\\Models\\User', 77),
(698, 'App\\Models\\User', 78),
(698, 'App\\Models\\User', 79),
(698, 'App\\Models\\User', 80),
(698, 'App\\Models\\User', 81),
(698, 'App\\Models\\User', 82),
(698, 'App\\Models\\User', 83),
(698, 'App\\Models\\User', 84),
(698, 'App\\Models\\User', 85),
(698, 'App\\Models\\User', 86),
(698, 'App\\Models\\User', 87),
(698, 'App\\Models\\User', 88),
(698, 'App\\Models\\User', 89),
(698, 'App\\Models\\User', 90),
(698, 'App\\Models\\User', 91),
(698, 'App\\Models\\User', 92),
(698, 'App\\Models\\User', 93),
(698, 'App\\Models\\User', 94),
(698, 'App\\Models\\User', 95),
(698, 'App\\Models\\User', 96),
(698, 'App\\Models\\User', 99),
(698, 'App\\Models\\User', 100),
(698, 'App\\Models\\User', 101),
(698, 'App\\Models\\User', 102),
(698, 'App\\Models\\User', 103),
(699, 'App\\Models\\User', 86),
(699, 'App\\Models\\User', 91),
(699, 'App\\Models\\User', 94),
(699, 'App\\Models\\User', 95),
(699, 'App\\Models\\User', 96),
(699, 'App\\Models\\User', 99),
(699, 'App\\Models\\User', 100),
(700, 'App\\Models\\User', 26),
(700, 'App\\Models\\User', 27),
(700, 'App\\Models\\User', 28),
(700, 'App\\Models\\User', 29),
(700, 'App\\Models\\User', 31),
(700, 'App\\Models\\User', 32),
(700, 'App\\Models\\User', 33),
(700, 'App\\Models\\User', 34),
(700, 'App\\Models\\User', 35),
(700, 'App\\Models\\User', 36),
(700, 'App\\Models\\User', 37),
(700, 'App\\Models\\User', 38),
(700, 'App\\Models\\User', 39),
(700, 'App\\Models\\User', 40),
(700, 'App\\Models\\User', 41),
(700, 'App\\Models\\User', 44),
(700, 'App\\Models\\User', 45),
(700, 'App\\Models\\User', 46),
(700, 'App\\Models\\User', 47),
(700, 'App\\Models\\User', 48),
(700, 'App\\Models\\User', 49),
(700, 'App\\Models\\User', 50),
(700, 'App\\Models\\User', 51),
(700, 'App\\Models\\User', 52),
(700, 'App\\Models\\User', 53),
(700, 'App\\Models\\User', 54),
(700, 'App\\Models\\User', 55),
(700, 'App\\Models\\User', 56),
(700, 'App\\Models\\User', 57),
(700, 'App\\Models\\User', 58),
(700, 'App\\Models\\User', 59),
(700, 'App\\Models\\User', 60),
(700, 'App\\Models\\User', 61),
(700, 'App\\Models\\User', 62),
(700, 'App\\Models\\User', 63),
(700, 'App\\Models\\User', 64),
(700, 'App\\Models\\User', 65),
(700, 'App\\Models\\User', 66),
(700, 'App\\Models\\User', 67),
(700, 'App\\Models\\User', 68),
(700, 'App\\Models\\User', 69),
(700, 'App\\Models\\User', 70),
(700, 'App\\Models\\User', 71),
(700, 'App\\Models\\User', 72),
(700, 'App\\Models\\User', 73),
(700, 'App\\Models\\User', 74),
(700, 'App\\Models\\User', 75),
(700, 'App\\Models\\User', 76),
(700, 'App\\Models\\User', 77),
(700, 'App\\Models\\User', 78),
(700, 'App\\Models\\User', 79),
(700, 'App\\Models\\User', 80),
(700, 'App\\Models\\User', 81),
(700, 'App\\Models\\User', 82),
(700, 'App\\Models\\User', 83),
(700, 'App\\Models\\User', 84),
(700, 'App\\Models\\User', 85),
(700, 'App\\Models\\User', 86),
(700, 'App\\Models\\User', 87),
(700, 'App\\Models\\User', 88),
(700, 'App\\Models\\User', 89),
(700, 'App\\Models\\User', 90),
(700, 'App\\Models\\User', 91),
(700, 'App\\Models\\User', 92),
(700, 'App\\Models\\User', 93),
(700, 'App\\Models\\User', 94),
(700, 'App\\Models\\User', 95),
(700, 'App\\Models\\User', 96),
(700, 'App\\Models\\User', 97),
(700, 'App\\Models\\User', 98),
(700, 'App\\Models\\User', 99),
(700, 'App\\Models\\User', 100),
(700, 'App\\Models\\User', 101),
(700, 'App\\Models\\User', 102),
(700, 'App\\Models\\User', 103),
(701, 'App\\Models\\User', 91),
(702, 'App\\Models\\User', 91),
(703, 'App\\Models\\User', 91),
(704, 'App\\Models\\User', 91),
(740, 'App\\Models\\User', 87),
(740, 'App\\Models\\User', 88),
(740, 'App\\Models\\User', 89),
(740, 'App\\Models\\User', 90),
(740, 'App\\Models\\User', 93),
(741, 'App\\Models\\User', 25),
(741, 'App\\Models\\User', 30),
(742, 'App\\Models\\User', 30),
(743, 'App\\Models\\User', 25),
(743, 'App\\Models\\User', 30),
(744, 'App\\Models\\User', 25),
(744, 'App\\Models\\User', 30),
(748, 'App\\Models\\User', 30),
(749, 'App\\Models\\User', 30),
(750, 'App\\Models\\User', 25),
(750, 'App\\Models\\User', 30),
(751, 'App\\Models\\User', 25),
(751, 'App\\Models\\User', 30),
(752, 'App\\Models\\User', 25),
(753, 'App\\Models\\User', 25),
(754, 'App\\Models\\User', 25),
(754, 'App\\Models\\User', 30),
(754, 'App\\Models\\User', 31),
(755, 'App\\Models\\User', 25),
(756, 'App\\Models\\User', 25),
(756, 'App\\Models\\User', 30),
(756, 'App\\Models\\User', 31),
(761, 'App\\Models\\User', 30),
(762, 'App\\Models\\User', 30),
(763, 'App\\Models\\User', 30),
(764, 'App\\Models\\User', 30),
(765, 'App\\Models\\User', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(136, 'App\\Models\\User', 25),
(136, 'App\\Models\\User', 30),
(136, 'App\\Models\\User', 91),
(137, 'App\\Models\\User', 86),
(137, 'App\\Models\\User', 94),
(137, 'App\\Models\\User', 95),
(137, 'App\\Models\\User', 96),
(137, 'App\\Models\\User', 99),
(137, 'App\\Models\\User', 100),
(138, 'App\\Models\\User', 97),
(138, 'App\\Models\\User', 98),
(139, 'App\\Models\\User', 26),
(139, 'App\\Models\\User', 27),
(139, 'App\\Models\\User', 28),
(139, 'App\\Models\\User', 29),
(139, 'App\\Models\\User', 31),
(139, 'App\\Models\\User', 32),
(139, 'App\\Models\\User', 33),
(139, 'App\\Models\\User', 34),
(139, 'App\\Models\\User', 35),
(139, 'App\\Models\\User', 36),
(139, 'App\\Models\\User', 37),
(139, 'App\\Models\\User', 38),
(139, 'App\\Models\\User', 39),
(139, 'App\\Models\\User', 40),
(139, 'App\\Models\\User', 41),
(139, 'App\\Models\\User', 44),
(139, 'App\\Models\\User', 45),
(139, 'App\\Models\\User', 46),
(139, 'App\\Models\\User', 47),
(139, 'App\\Models\\User', 48),
(139, 'App\\Models\\User', 49),
(139, 'App\\Models\\User', 50),
(139, 'App\\Models\\User', 51),
(139, 'App\\Models\\User', 52),
(139, 'App\\Models\\User', 53),
(139, 'App\\Models\\User', 54),
(139, 'App\\Models\\User', 55),
(139, 'App\\Models\\User', 56),
(139, 'App\\Models\\User', 57),
(139, 'App\\Models\\User', 58),
(139, 'App\\Models\\User', 59),
(139, 'App\\Models\\User', 60),
(139, 'App\\Models\\User', 61),
(139, 'App\\Models\\User', 62),
(139, 'App\\Models\\User', 63),
(139, 'App\\Models\\User', 64),
(139, 'App\\Models\\User', 65),
(139, 'App\\Models\\User', 66),
(139, 'App\\Models\\User', 67),
(139, 'App\\Models\\User', 68),
(139, 'App\\Models\\User', 69),
(139, 'App\\Models\\User', 70),
(139, 'App\\Models\\User', 71),
(139, 'App\\Models\\User', 72),
(139, 'App\\Models\\User', 73),
(139, 'App\\Models\\User', 74),
(139, 'App\\Models\\User', 75),
(139, 'App\\Models\\User', 76),
(139, 'App\\Models\\User', 77),
(139, 'App\\Models\\User', 79),
(139, 'App\\Models\\User', 80),
(139, 'App\\Models\\User', 81),
(139, 'App\\Models\\User', 82),
(139, 'App\\Models\\User', 83),
(139, 'App\\Models\\User', 84),
(139, 'App\\Models\\User', 85),
(139, 'App\\Models\\User', 87),
(139, 'App\\Models\\User', 88),
(139, 'App\\Models\\User', 89),
(139, 'App\\Models\\User', 90),
(139, 'App\\Models\\User', 92),
(139, 'App\\Models\\User', 93),
(139, 'App\\Models\\User', 101),
(139, 'App\\Models\\User', 102),
(139, 'App\\Models\\User', 103);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_providers`
--

CREATE TABLE `payment_providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `accounts_receivable` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `payment_providers`
--

INSERT INTO `payment_providers` (`id`, `company_id`, `branch_id`, `name`, `code`, `is_active`, `accounts_receivable`, `created_at`, `updated_at`, `deleted_at`) VALUES
(26, 27, 16, 'Bancolombia', 'BNC', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(27, 27, 16, 'Banco de Bogotá', 'BDB', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(28, 27, 16, 'Davivienda', 'DVB', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(29, 27, 16, 'BBVA Colombia', 'BBV', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(30, 27, 16, 'Banco Popular', 'BPP', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(31, 27, 16, 'Banco Caja Social', 'BCS', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(32, 27, 16, 'Banco Pichincha', 'BPC', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(33, 27, 16, 'Itaú Colombia', 'ITA', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(34, 27, 16, 'Banco Agrario', 'BAG', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(35, 27, 16, 'Banco Av Villas', 'BAV', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(36, 27, 16, 'PSE', 'PSE', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(37, 27, 16, 'Nequi', 'NEQ', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(38, 27, 16, 'Daviplata', 'DVP', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(39, 27, 16, 'Tarjeta de Crédito (Visa/Mastercard)', 'TDC', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(40, 27, 16, 'PayPal', 'PPL', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(41, 27, 16, 'PayU', 'PAYU', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(42, 27, 16, 'Mercado Pago', 'MPGO', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(43, 27, 16, 'Wompi', 'WMP', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(44, 27, 16, 'Addi', 'ADDI', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(45, 27, 16, 'Sistecrédito', 'SISC', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(46, 27, 16, 'Efecty (Recaudo)', 'EFT', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(47, 27, 16, 'Baloto (Recaudo)', 'BLT', 1, 1, '2025-11-20 01:04:31', '2025-11-20 01:04:31', NULL),
(48, 27, 16, 'Efectivo', 'EFECTIVO', 1, 0, '2025-11-19 20:07:40', '2025-11-19 20:07:45', NULL),
(117, 28, 19, 'Efectivo', 'EFECTIVO', 1, 0, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(118, 28, 19, 'Bancolombia', 'BNC', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(119, 28, 19, 'Banco de Bogotá', 'BDB', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(120, 28, 19, 'Davivienda', 'DVB', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(121, 28, 19, 'BBVA Colombia', 'BBV', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(122, 28, 19, 'Banco Popular', 'BPP', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(123, 28, 19, 'Banco Caja Social', 'BCS', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(124, 28, 19, 'Banco Pichincha', 'BPC', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(125, 28, 19, 'Itaú Colombia', 'ITA', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(126, 28, 19, 'Banco Agrario', 'BAG', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(127, 28, 19, 'Banco Av Villas', 'BAV', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(128, 28, 19, 'PSE', 'PSE', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(129, 28, 19, 'Nequi', 'NEQ', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(130, 28, 19, 'Daviplata', 'DVP', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(131, 28, 19, 'Tarjeta de Crédito (Visa/Mastercard)', 'TDC', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(132, 28, 19, 'PayPal', 'PPL', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(133, 28, 19, 'PayU', 'PAYU', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(134, 28, 19, 'Mercado Pago', 'MPGO', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(135, 28, 19, 'Wompi', 'WMP', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(136, 28, 19, 'Addi', 'ADDI', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(137, 28, 19, 'Sistecrédito', 'SISC', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(138, 28, 19, 'Efecty (Recaudo)', 'EFT', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL),
(139, 28, 19, 'Baloto (Recaudo)', 'BLT', 1, 1, '2025-11-26 20:37:44', '2025-11-26 20:37:44', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `company_id`, `created_at`, `updated_at`) VALUES
(668, 'ver usuarios', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(669, 'crear usuarios', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(670, 'editar usuarios', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(671, 'eliminar usuarios', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(672, 'ver roles', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(673, 'crear roles', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(674, 'editar roles', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(675, 'eliminar roles', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(676, 'ver productos', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(677, 'crear productos', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(678, 'editar productos', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(679, 'eliminar productos', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(680, 'ver inventarios', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(681, 'editar inventarios', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(682, 'movimientos inventario', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(683, 'ver ventas', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(684, 'crear ventas', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(685, 'editar ventas', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(686, 'anular ventas', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(687, 'ver transacciones', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(688, 'ver planes', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(689, 'crear planes', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(690, 'editar planes', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(691, 'eliminar planes', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(692, 'ver pagos', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(693, 'registrar pagos', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(694, 'editar pagos', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(695, 'eliminar pagos', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(696, 'ver clientes', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(697, 'crear clientes', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(698, 'editar clientes', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(699, 'eliminar clientes', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(700, 'ver reportes', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(701, 'configurar empresa', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(702, 'configurar sucursales', 'api', 27, '2025-11-14 01:38:42', '2025-11-14 01:38:42'),
(703, 'crear sucursal', 'api', 27, '2025-11-15 11:50:35', '2025-11-15 11:50:35'),
(704, 'crear sucursales', 'api', 27, '2025-11-15 11:51:16', '2025-11-15 11:51:16'),
(705, 'ver usuarios', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(706, 'crear usuarios', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(707, 'editar usuarios', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(708, 'eliminar usuarios', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(709, 'ver roles', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(710, 'crear roles', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(711, 'editar roles', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(712, 'eliminar roles', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(713, 'ver productos', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(714, 'crear productos', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(715, 'editar productos', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(716, 'eliminar productos', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(717, 'ver inventarios', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(718, 'editar inventarios', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(719, 'movimientos inventario', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(720, 'ver ventas', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(721, 'crear ventas', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(722, 'editar ventas', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(723, 'anular ventas', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(724, 'ver transacciones', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(725, 'ver planes', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(726, 'crear planes', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(727, 'editar planes', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(728, 'eliminar planes', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(729, 'ver pagos', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(730, 'registrar pagos', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(731, 'editar pagos', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(732, 'eliminar pagos', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(733, 'ver clientes', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(734, 'crear clientes', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(735, 'editar clientes', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(736, 'eliminar clientes', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(737, 'ver reportes', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(738, 'configurar empresa', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(739, 'configurar sucursales', 'api', 28, '2025-11-15 12:04:01', '2025-11-15 12:04:01'),
(740, 'ver usuarioss', 'api', 28, '2025-11-16 00:50:48', '2025-11-16 00:50:48'),
(741, 'crear inventarios', 'api', 28, '2025-11-18 02:27:23', '2025-11-18 02:27:23'),
(742, 'crear inventario', 'api', 28, '2025-11-18 02:29:26', '2025-11-18 02:29:26'),
(743, 'ver proveedores', 'api', 28, '2025-11-18 03:01:36', '2025-11-18 03:01:36'),
(744, 'crear proveedores', 'api', 27, '2025-11-18 03:33:51', '2025-11-18 03:33:51'),
(745, 'ver proveedores', 'api', 27, '2025-11-18 03:33:51', '2025-11-18 03:33:51'),
(746, 'crear inventarios', 'api', 27, '2025-11-18 04:51:49', '2025-11-18 04:51:49'),
(747, 'crear proveedores', 'api', 28, '2025-11-18 22:55:25', '2025-11-18 22:55:25'),
(748, 'crear proveedor', 'api', 28, '2025-11-18 22:57:05', '2025-11-18 22:57:05'),
(749, 'ver proveedor', 'api', 28, '2025-11-18 22:57:05', '2025-11-18 22:57:05'),
(750, 'crear documentos', 'api', 27, '2025-11-19 19:18:52', '2025-11-19 19:18:52'),
(751, 'ver documentos', 'api', 27, '2025-11-19 19:18:52', '2025-11-19 19:18:52'),
(752, 'editar documentos', 'api', 27, '2025-11-19 19:18:52', '2025-11-19 19:18:52'),
(753, 'eliminar documentos', 'api', 27, '2025-11-19 19:18:52', '2025-11-19 19:18:52'),
(754, 'ver sucursales', 'api', 27, '2025-11-21 11:45:57', '2025-11-21 11:45:57'),
(755, 'datos generaless', 'api', 27, '2025-11-21 12:24:14', '2025-11-21 12:24:14'),
(756, 'datos generales', 'api', 27, '2025-11-21 12:27:00', '2025-11-21 12:27:00'),
(757, 'ver documentos', 'api', 28, '2025-11-26 20:44:37', '2025-11-26 20:44:37'),
(758, 'crear documentos', 'api', 28, '2025-11-26 22:13:22', '2025-11-26 22:13:22'),
(759, 'ver sucursales', 'api', 28, '2025-11-26 23:12:37', '2025-11-26 23:12:37'),
(760, 'datos generales', 'api', 28, '2025-11-26 23:59:42', '2025-11-26 23:59:42'),
(761, 'ver cxp', 'api', 28, '2025-11-27 01:29:27', '2025-11-27 01:29:27'),
(762, 'ver cxc', 'api', 28, '2025-11-27 01:29:43', '2025-11-27 01:29:43'),
(763, 'editar proveedores', 'api', 28, '2025-12-02 10:56:42', '2025-12-02 10:56:42'),
(764, 'editar sucursales', 'api', 28, '2025-12-02 22:23:20', '2025-12-02 22:23:20'),
(765, 'editar invantario', 'api', 28, '2025-12-03 00:00:33', '2025-12-03 00:00:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `purchase_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL DEFAULT 'api',
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `company_id`, `name`, `guard_name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(136, 27, 'Administrador General', 'api', 'Administra toda la empresa y sucursales', '2025-11-14 01:38:42', '2025-11-14 01:38:42', NULL),
(137, 27, 'Administrador Sucursal', 'api', 'Administra una sucursal específica', '2025-11-14 01:38:42', '2025-11-14 01:38:42', NULL),
(138, 27, 'Supervisor', 'api', 'Supervisa operaciones y personal', '2025-11-14 01:38:42', '2025-11-14 01:38:42', NULL),
(139, 27, 'Asesor Interno', 'api', 'Gestiona ventas y atención al cliente desde la empresa', '2025-11-14 01:38:42', '2025-11-14 01:38:42', NULL),
(140, 27, 'Asesor Externo', 'api', 'Gestiona ventas de campo o externas', '2025-11-14 01:38:42', '2025-11-14 01:38:42', NULL),
(141, 27, 'Auditor', 'api', 'Revisa procesos y operaciones', '2025-11-14 01:38:42', '2025-11-14 01:38:42', NULL),
(142, 27, 'Cliente', 'api', 'Accede a sus transacciones, reservas y pagos', '2025-11-14 01:38:42', '2025-11-14 01:38:42', NULL),
(143, 28, 'Administrador General', 'api', 'Administra toda la empresa y sucursales', '2025-11-15 12:04:01', '2025-11-15 12:04:01', NULL),
(144, 28, 'Administrador Sucursal', 'api', 'Administra una sucursal específica', '2025-11-15 12:04:01', '2025-11-15 12:04:01', NULL),
(145, 28, 'Supervisor', 'api', 'Supervisa operaciones y personal', '2025-11-15 12:04:01', '2025-11-15 12:04:01', NULL),
(146, 28, 'Asesor Interno', 'api', 'Gestiona ventas y atención al cliente desde la empresa', '2025-11-15 12:04:01', '2025-11-15 12:04:01', NULL),
(147, 28, 'Asesor Externo', 'api', 'Gestiona ventas de campo o externas', '2025-11-15 12:04:01', '2025-11-15 12:04:01', NULL),
(148, 28, 'Auditor', 'api', 'Revisa procesos y operaciones', '2025-11-15 12:04:01', '2025-11-15 12:04:01', NULL),
(149, 28, 'Cliente', 'api', 'Accede a sus transacciones, reservas y pagos', '2025-11-15 12:04:01', '2025-11-15 12:04:01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(668, 136),
(668, 139),
(669, 136),
(670, 136),
(671, 136),
(672, 136),
(673, 136),
(674, 136),
(675, 136),
(676, 136),
(676, 137),
(676, 138),
(676, 139),
(676, 140),
(676, 141),
(676, 142),
(677, 136),
(677, 137),
(677, 139),
(677, 140),
(678, 136),
(678, 137),
(679, 136),
(679, 137),
(680, 136),
(680, 137),
(680, 138),
(680, 139),
(680, 140),
(680, 141),
(681, 136),
(681, 137),
(681, 139),
(681, 140),
(682, 136),
(682, 137),
(682, 139),
(682, 140),
(683, 136),
(683, 137),
(683, 138),
(683, 139),
(683, 140),
(683, 141),
(684, 136),
(684, 137),
(684, 139),
(684, 140),
(685, 136),
(685, 137),
(686, 136),
(686, 137),
(687, 136),
(687, 137),
(687, 138),
(687, 139),
(687, 140),
(687, 141),
(687, 142),
(688, 136),
(688, 137),
(688, 138),
(688, 139),
(688, 140),
(688, 141),
(688, 142),
(689, 136),
(689, 137),
(689, 139),
(689, 140),
(690, 136),
(690, 137),
(690, 139),
(690, 140),
(691, 136),
(691, 137),
(692, 136),
(692, 137),
(692, 138),
(692, 139),
(692, 140),
(692, 141),
(692, 142),
(693, 136),
(693, 137),
(693, 139),
(693, 140),
(694, 136),
(694, 137),
(694, 139),
(694, 140),
(695, 136),
(695, 137),
(696, 136),
(696, 137),
(696, 138),
(696, 139),
(696, 140),
(696, 141),
(697, 136),
(697, 137),
(697, 139),
(697, 140),
(698, 136),
(698, 137),
(698, 139),
(698, 140),
(699, 136),
(699, 137),
(700, 136),
(700, 137),
(700, 138),
(700, 139),
(700, 140),
(700, 141),
(700, 142),
(701, 136),
(702, 136),
(703, 136),
(704, 136),
(705, 143),
(706, 143),
(707, 143),
(708, 143),
(709, 143),
(710, 143),
(711, 143),
(712, 143),
(713, 143),
(713, 144),
(713, 145),
(713, 146),
(713, 147),
(713, 148),
(713, 149),
(714, 143),
(714, 144),
(714, 146),
(714, 147),
(715, 143),
(715, 144),
(716, 143),
(716, 144),
(717, 143),
(717, 144),
(717, 145),
(717, 146),
(717, 147),
(717, 148),
(718, 143),
(718, 144),
(718, 146),
(718, 147),
(719, 143),
(719, 144),
(719, 146),
(719, 147),
(720, 143),
(720, 144),
(720, 145),
(720, 146),
(720, 147),
(720, 148),
(721, 143),
(721, 144),
(721, 146),
(721, 147),
(722, 143),
(722, 144),
(723, 143),
(723, 144),
(724, 143),
(724, 144),
(724, 145),
(724, 146),
(724, 147),
(724, 148),
(724, 149),
(725, 143),
(725, 144),
(725, 145),
(725, 146),
(725, 147),
(725, 148),
(725, 149),
(726, 143),
(726, 144),
(726, 146),
(726, 147),
(727, 143),
(727, 144),
(727, 146),
(727, 147),
(728, 143),
(728, 144),
(729, 143),
(729, 144),
(729, 145),
(729, 146),
(729, 147),
(729, 148),
(729, 149),
(730, 143),
(730, 144),
(730, 146),
(730, 147),
(731, 143),
(731, 144),
(731, 146),
(731, 147),
(732, 143),
(732, 144),
(733, 143),
(733, 144),
(733, 145),
(733, 146),
(733, 147),
(733, 148),
(734, 143),
(734, 144),
(734, 146),
(734, 147),
(735, 143),
(735, 144),
(735, 146),
(735, 147),
(736, 143),
(736, 144),
(737, 143),
(737, 144),
(737, 145),
(737, 146),
(737, 147),
(737, 148),
(737, 149),
(738, 143),
(739, 143),
(740, 139);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED DEFAULT NULL,
  `number_transactions` varchar(255) DEFAULT NULL,
  `payment_provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `sale_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Subtotal antes de impuestos y descuentos',
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Total final',
  `status` varchar(255) NOT NULL DEFAULT 'completed',
  `payment_method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sales`
--

INSERT INTO `sales` (`id`, `company_id`, `branch_id`, `user_id`, `client_id`, `document_id`, `number_transactions`, `payment_provider_id`, `invoice_number`, `sale_date`, `total_amount`, `tax_amount`, `discount_amount`, `grand_total`, `status`, `payment_method`, `created_at`, `updated_at`, `deleted_at`) VALUES
(100, 27, 16, 25, 22, 38, '027-00016-213735130561-1FE03', NULL, 'INV-2025-0111888282', '2025-11-19', 1000000.00, 180500.00, 50000.00, 1130500.00, 'completed', 'Addi', '2025-11-20 02:37:35', '2025-11-20 02:37:35', NULL),
(102, 27, 16, 25, 22, 38, '027-00016-213843857769-D16AB', NULL, 'INV-2025-01101888282', '2025-11-19', 1000000.00, 180500.00, 50000.00, 1130500.00, 'completed', 'Addi', '2025-11-20 02:38:43', '2025-11-20 02:38:43', NULL),
(103, 27, 16, 25, 22, 38, '027-00016-214109732870-B2EC8', NULL, 'INV-2025-0114501888282', '2025-11-19', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-20 02:41:09', '2025-11-20 02:41:09', NULL),
(104, 27, 16, 25, 22, 38, '027-00016-150648207825-32BD3', NULL, 'INV-2025-001237', '2025-11-20', 250000.00, 45125.00, 12500.00, 282625.00, 'completed', 'Credito', '2025-11-20 20:06:48', '2025-11-20 20:06:48', NULL),
(106, 27, 16, 25, 22, 38, '027-00016-151211253184-3DD03', NULL, 'INV-2025-0012437', '2025-11-20', 500000.00, 57000.00, 25000.00, 532000.00, 'completed', 'Credito, Efectivo', '2025-11-20 20:12:11', '2025-11-20 20:12:11', NULL),
(108, 27, 16, 25, 22, 38, '027-00016-151259934108-E40DF', NULL, 'INV-2025-00124737', '2025-11-20', 500000.00, 57000.00, 25000.00, 532000.00, 'completed', 'Credito, Efectivo', '2025-11-20 20:12:59', '2025-11-20 20:12:59', NULL),
(109, 27, 16, 25, 22, 38, '027-00016-151512606780-9423E', NULL, 'INV-2025-001424737', '2025-11-20', 500000.00, 57000.00, 25000.00, 532000.00, 'completed', 'Credito, Efectivo', '2025-11-20 20:15:12', '2025-11-20 20:15:12', NULL),
(110, 27, 16, 25, 22, 38, '027-00016-151606525248-803C3', NULL, 'INV-2025-0011424737', '2025-11-20', 500000.00, 57000.00, 25000.00, 532000.00, 'completed', 'Credito, Efectivo', '2025-11-20 20:16:06', '2025-11-20 20:16:06', NULL),
(111, 27, 16, 25, 22, 46, '027-00016-012040137111-2179A', NULL, 'INV-2025-001234', '2025-11-21', 500000.00, 90250.00, 25000.00, 565250.00, 'completed', 'Addi', '2025-11-21 06:20:40', '2025-11-21 06:20:40', NULL),
(112, 27, 16, 25, 22, 38, '027-00016-014410266746-411FC', NULL, '2222', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 06:44:10', '2025-11-21 06:44:10', NULL),
(113, 27, 16, 25, 22, 38, '027-00016-014434487297-76F84', NULL, '3333', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 06:44:34', '2025-11-21 06:44:34', NULL),
(115, 27, 16, 25, 22, 38, '027-00016-014522458527-6FF21', NULL, '22225', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 06:45:22', '2025-11-21 06:45:22', NULL),
(116, 27, 16, 25, 22, 38, '027-00016-014637158511-26B32', NULL, '4554545', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 06:46:37', '2025-11-21 06:46:37', NULL),
(118, 27, 16, 25, 22, 38, '027-00016-014705739745-B49A4', NULL, '45545', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 06:47:05', '2025-11-21 06:47:05', NULL),
(119, 27, 16, 25, 22, 38, '027-00016-014748466792-71F6B', NULL, '4554596', '2025-11-21', 500000.00, 23750.00, 25000.00, 498750.00, 'completed', 'Efectivo', '2025-11-21 06:47:48', '2025-11-21 06:47:48', NULL),
(120, 27, 16, 25, 22, 38, '027-00016-014957854208-D08C2', NULL, '4615339', '2025-11-21', 500000.00, 90250.00, 25000.00, 565250.00, 'completed', 'Efectivo', '2025-11-21 06:49:57', '2025-11-21 06:49:57', NULL),
(122, 27, 16, 25, 22, 38, '027-00016-015141049926-0C308', NULL, '46153397', '2025-11-21', 500000.00, 90250.00, 25000.00, 565250.00, 'completed', 'Nequi, Efectivo', '2025-11-21 06:51:41', '2025-11-21 06:51:41', NULL),
(123, 27, 16, 25, 22, 38, '027-00016-015208067807-108E1', NULL, '461533978', '2025-11-21', 250000.00, 45125.00, 12500.00, 282625.00, 'completed', 'Nequi', '2025-11-21 06:52:08', '2025-11-21 06:52:08', NULL),
(124, 27, 16, 25, 22, 38, '027-00016-015238444768-6C963', NULL, '4615339788', '2025-11-21', 250000.00, 45125.00, 12500.00, 282625.00, 'completed', 'Nequi', '2025-11-21 06:52:38', '2025-11-21 06:52:38', NULL),
(126, 27, 16, 25, 22, 38, '027-00016-015311492606-78441', NULL, '46153397888', '2025-11-21', 250000.00, 45125.00, 12500.00, 282625.00, 'completed', 'Nequi', '2025-11-21 06:53:11', '2025-11-21 06:53:11', NULL),
(127, 27, 16, 25, 22, 38, '027-00016-015944202199-315D9', NULL, '1111111', '2025-11-21', 380000.00, 108300.00, 19000.00, 469300.00, 'completed', 'Efectivo', '2025-11-21 06:59:44', '2025-11-21 06:59:44', NULL),
(128, 27, 16, 25, 22, 38, '027-00016-020219194753-2F8C4', NULL, '222222222', '2025-11-21', 190000.00, 54150.00, 9500.00, 234650.00, 'completed', 'Efectivo', '2025-11-21 07:02:19', '2025-11-21 07:02:19', NULL),
(129, 27, 16, 25, 22, 38, '027-00016-020842537123-83225', NULL, '9999666', '2025-11-21', 380000.00, 108300.00, 19000.00, 469300.00, 'completed', 'Efectivo', '2025-11-21 07:08:42', '2025-11-21 07:08:42', NULL),
(130, 27, 16, 25, 22, 38, '027-00016-020932236018-399F5', NULL, '333333336', '2025-11-21', 380000.00, 108300.00, 19000.00, 469300.00, 'completed', 'Efectivo', '2025-11-21 07:09:32', '2025-11-21 07:09:32', NULL),
(131, 27, 16, 25, 22, 38, '027-00016-021140772087-BC7FC', NULL, '787878', '2025-11-21', 380000.00, 108300.00, 19000.00, 469300.00, 'completed', 'Efectivo', '2025-11-21 07:11:40', '2025-11-21 07:11:40', NULL),
(132, 27, 16, 25, 22, 38, '027-00016-021348190153-2E6CB', NULL, '22222343434', '2025-11-21', 380000.00, 108300.00, 19000.00, 469300.00, 'completed', 'Efectivo', '2025-11-21 07:13:48', '2025-11-21 07:13:48', NULL),
(134, 27, 16, 25, 22, 38, '027-00016-021933572326-8BBA8', NULL, '55555', '2025-11-21', 380000.00, 108300.00, 19000.00, 469300.00, 'completed', 'Efectivo', '2025-11-21 07:19:33', '2025-11-21 07:19:33', NULL),
(135, 27, 16, 25, 22, 38, '027-00016-022200057515-0E0AE', NULL, '46465', '2025-11-21', 380000.00, 108300.00, 19000.00, 469300.00, 'completed', 'Efectivo', '2025-11-21 07:22:00', '2025-11-21 07:22:00', NULL),
(136, 27, 16, 25, 22, 38, '027-00016-022314030055-0756C', NULL, '3233232', '2025-11-21', 380000.00, 108300.00, 19000.00, 469300.00, 'completed', 'Efectivo', '2025-11-21 07:23:14', '2025-11-21 07:23:14', NULL),
(138, 27, 16, 25, 22, 38, '027-00016-022403740319-B4BE1', NULL, '3233232555', '2025-11-21', 380000.00, 108300.00, 19000.00, 469300.00, 'completed', 'Efectivo', '2025-11-21 07:24:03', '2025-11-21 07:24:03', NULL),
(139, 27, 16, 25, 22, 38, '027-00016-023315273123-42AE5', NULL, 'ew3444', '2025-11-21', 240000.00, 27360.00, 12000.00, 255360.00, 'completed', 'Efectivo', '2025-11-21 07:33:15', '2025-11-21 07:33:15', NULL),
(140, 27, 16, 25, 22, 38, '027-00016-023519705123-AC265', NULL, '333332', '2025-11-21', 240000.00, 27360.00, 12000.00, 255360.00, 'completed', 'Efectivo', '2025-11-21 07:35:19', '2025-11-21 07:35:19', NULL),
(141, 27, 16, 25, 22, 38, '027-00016-024050334317-519F0', NULL, '333332dd', '2025-11-21', 240000.00, 27360.00, 12000.00, 255360.00, 'completed', 'Efectivo', '2025-11-21 07:40:50', '2025-11-21 07:40:50', NULL),
(142, 27, 16, 25, 22, 38, '027-00016-024256109630-1AC41', NULL, '333332dds', '2025-11-21', 240000.00, 27360.00, 12000.00, 255360.00, 'completed', 'Efectivo', '2025-11-21 07:42:56', '2025-11-21 07:42:56', NULL),
(143, 27, 16, 25, 22, 38, '027-00016-024330711407-ADAF2', NULL, '333332ddss', '2025-11-21', 240000.00, 27360.00, 12000.00, 255360.00, 'completed', 'Efectivo', '2025-11-21 07:43:30', '2025-11-21 07:43:30', NULL),
(144, 27, 16, 25, 22, 38, '027-00016-024505636826-9B79D', NULL, '333332ddsss', '2025-11-21', 240000.00, 27360.00, 12000.00, 255360.00, 'completed', 'Efectivo', '2025-11-21 07:45:05', '2025-11-21 07:45:05', NULL),
(145, 27, 16, 25, 22, 38, '027-00016-024607786510-C0050', NULL, '333332ddsssw', '2025-11-21', 500000.00, 90250.00, 25000.00, 565250.00, 'completed', 'Efectivo', '2025-11-21 07:46:07', '2025-11-21 07:46:07', NULL),
(146, 27, 16, 25, 22, 38, '027-00016-025725392254-5FC41', NULL, '4344', '2025-11-21', 240000.00, 27360.00, 12000.00, 255360.00, 'completed', 'Efectivo', '2025-11-21 07:57:25', '2025-11-21 07:57:25', NULL),
(147, 27, 16, 25, 19, NULL, '027-00016-030001168415-291E1', NULL, '45353454354', '2025-11-21', 240000.00, 27360.00, 12000.00, 255360.00, 'completed', 'Efectivo', '2025-11-21 08:00:01', '2025-11-21 08:00:01', NULL),
(148, 27, 16, 25, 19, NULL, '027-00016-030058490372-77B87', NULL, '453534543545', '2025-11-21', 500000.00, 90250.00, 25000.00, 565250.00, 'completed', 'Efectivo', '2025-11-21 08:00:58', '2025-11-21 08:00:58', NULL),
(149, 27, 16, 25, 19, NULL, '027-00016-032633111947-1B54E', NULL, '453534543545oydd', '2025-11-21', 380000.00, 108300.00, 19000.00, 469300.00, 'completed', 'Efectivo', '2025-11-21 08:26:33', '2025-11-21 08:26:33', NULL),
(150, 27, 16, 25, 19, 46, '027-00016-033214086246-150E9', NULL, '45455454eee', '2025-11-21', 500000.00, 90250.00, 25000.00, 565250.00, 'completed', 'Transferencia, Efectivo', '2025-11-21 08:32:14', '2025-11-21 08:32:14', NULL),
(152, 27, 16, 25, 19, NULL, '027-00016-035112240776-3AC8B', NULL, '2222www', '2025-11-21', 640000.00, 115520.00, 32000.00, 723520.00, 'completed', 'Efectivo', '2025-11-21 08:51:12', '2025-11-21 08:51:12', NULL),
(155, 27, 16, 25, 19, NULL, '027-00016-042357966329-EBEBD', NULL, '2222www9', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 09:23:58', '2025-11-21 09:23:58', NULL),
(156, 27, 16, 25, 19, NULL, '027-00016-042426642667-9CE6E', NULL, '2222www9cc', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 09:24:26', '2025-11-21 09:24:26', NULL),
(157, 27, 16, 25, 19, NULL, '027-00016-042454493269-786D8', NULL, '457896', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Daviplata, PSE', '2025-11-21 09:24:54', '2025-11-21 09:24:54', NULL),
(158, 27, 16, 25, 19, NULL, '027-00016-042515317831-4D989', NULL, '4578967', '2025-11-21', 440000.00, 101650.00, 9500.00, 532150.00, 'completed', 'Daviplata, PSE', '2025-11-21 09:25:15', '2025-11-21 09:25:15', NULL),
(159, 27, 16, 25, 19, NULL, '027-00016-042837240935-3AD29', NULL, '2222wwwq', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 09:28:37', '2025-11-21 09:28:37', NULL),
(160, 27, 16, 25, 19, NULL, '027-00016-042938864265-D300C', NULL, '2222wwwqq', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 09:29:38', '2025-11-21 09:29:38', NULL),
(161, 27, 16, 25, 19, NULL, '027-00016-043204612644-95926', NULL, '4578967w', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 09:32:04', '2025-11-21 09:32:04', NULL),
(162, 27, 16, 25, 19, NULL, '027-00016-043237787031-C025A', NULL, '4578967q', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 09:32:37', '2025-11-21 09:32:37', NULL),
(163, 27, 16, 25, 19, NULL, '027-00016-043348212701-33EDF', NULL, '4578967s', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 09:33:48', '2025-11-21 09:33:48', NULL),
(164, 27, 16, 25, 33, NULL, '027-00016-043716356202-56F6D', NULL, '4578967sW', '2025-11-21', 440000.00, 104500.00, 0.00, 544500.00, 'completed', 'Efectivo', '2025-11-21 09:37:16', '2025-11-21 09:37:16', NULL),
(165, 27, 16, 25, 19, NULL, '027-00016-081511810583-C5E5A', NULL, '5757', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 13:15:11', '2025-11-21 13:15:11', NULL),
(166, 27, 16, 25, 19, NULL, '027-00016-081621115758-1C431', NULL, '65564', '2025-11-21', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-21 13:16:21', '2025-11-21 13:16:21', NULL),
(167, 27, 16, 25, 19, NULL, '027-00016-180630193339-2F33E', NULL, '555555', '2025-11-24', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-24 23:06:30', '2025-11-24 23:06:30', NULL),
(168, 27, 16, 25, 19, NULL, '027-00016-181447858626-D1A04', NULL, '444444', '2025-11-24', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-24 23:14:47', '2025-11-24 23:14:47', NULL),
(169, 27, 16, 25, 19, NULL, '027-00016-181957848998-CF469', NULL, '111111111111', '2025-11-24', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-24 23:19:57', '2025-11-24 23:19:57', NULL),
(170, 27, 16, 25, 19, NULL, '027-00016-182303359917-57DF2', NULL, '77777777', '2025-11-24', 440000.00, 99275.00, 22000.00, 517275.00, 'completed', 'Efectivo', '2025-11-24 23:23:03', '2025-11-24 23:23:03', NULL),
(171, 27, 16, 25, 19, NULL, '027-00016-182720478180-74BE6', NULL, '6666666677897', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-24 23:27:20', '2025-11-24 23:27:20', NULL),
(172, 27, 16, 25, 19, NULL, '027-00016-182809487827-77195', NULL, '666666633', '2025-11-24', 500000.00, 90250.00, 25000.00, 565250.00, 'completed', 'Efectivo', '2025-11-24 23:28:09', '2025-11-24 23:28:09', NULL),
(173, 27, 16, 25, 19, NULL, '027-00016-184648119244-1D1CF', NULL, '461533', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-24 23:46:48', '2025-11-24 23:46:48', NULL),
(174, 27, 16, 25, 19, NULL, '027-00016-190333956697-E992C', NULL, '1111111111111', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 00:03:33', '2025-11-25 00:03:33', NULL),
(175, 27, 16, 25, 19, NULL, '027-00016-190815899757-DBAAF', NULL, '44444444444', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 00:08:15', '2025-11-25 00:08:15', NULL),
(176, 27, 16, 25, 19, NULL, '027-00016-190913694812-A9A1F', NULL, '5555555555555', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 00:09:13', '2025-11-25 00:09:13', NULL),
(177, 27, 16, 25, 19, NULL, '027-00016-191206107048-1A22A', NULL, '666666666666', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 00:12:06', '2025-11-25 00:12:06', NULL),
(178, 27, 16, 25, 19, NULL, '027-00016-194159776139-BD7CE', NULL, '999999', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 00:41:59', '2025-11-25 00:41:59', NULL),
(179, 27, 16, 25, 19, NULL, '027-00016-194407525839-80612', NULL, '666666', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 00:44:07', '2025-11-25 00:44:07', NULL),
(180, 27, 16, 25, 19, NULL, '027-00016-194438339156-52CD7', NULL, '66666', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 00:44:38', '2025-11-25 00:44:38', NULL),
(181, 27, 16, 25, 19, NULL, '027-00016-194513603916-9370E', NULL, '65665655656', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 00:45:13', '2025-11-25 00:45:13', NULL),
(182, 27, 16, 25, 19, NULL, '027-00016-194928232020-38A57', NULL, '656545611', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 00:49:28', '2025-11-25 00:49:28', NULL),
(183, 27, 16, 25, 19, NULL, '027-00016-194957555047-8782A', NULL, '656545678', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 00:49:57', '2025-11-25 00:49:57', NULL),
(184, 27, 16, 25, 19, NULL, '027-00016-195518003587-00E06', NULL, '656545689', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 00:55:18', '2025-11-25 00:55:18', NULL),
(185, 27, 16, 25, 19, NULL, '027-00016-195940560052-88BB6', NULL, '6565456', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 00:59:40', '2025-11-25 00:59:40', NULL),
(186, 27, 16, 25, 19, NULL, '027-00016-200041429461-68D98', NULL, '656545696', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 01:00:41', '2025-11-25 01:00:41', NULL),
(187, 27, 16, 25, 19, NULL, '027-00016-201052154604-25BEE', NULL, '123456789', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 01:10:52', '2025-11-25 01:10:52', NULL),
(188, 27, 16, 25, 19, NULL, '027-00016-201111506799-7BBB2', NULL, '12345678910', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Wompi', '2025-11-25 01:11:11', '2025-11-25 01:11:11', NULL),
(189, 27, 16, 25, 19, 46, '027-00016-201318295974-48429', NULL, '12345678911', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Wompi', '2025-11-25 01:13:18', '2025-11-25 01:13:18', NULL),
(190, 27, 16, 25, 19, NULL, '027-00016-202545419300-665E6', NULL, '65666566', '2025-11-24', 500000.00, 95000.00, 0.00, 595000.00, 'completed', 'PSE, Itaú Colombia', '2025-11-25 01:25:45', '2025-11-25 01:25:45', NULL),
(191, 27, 16, 25, 19, NULL, '027-00016-203010943784-E66AC', NULL, '6566656699', '2025-11-24', 390000.00, 73150.00, 5000.00, 458150.00, 'completed', 'PayU, Nequi', '2025-11-25 01:30:10', '2025-11-25 01:30:10', NULL),
(192, 27, 16, 25, 19, NULL, '027-00016-205201580141-8DA2F', NULL, '888888', '2025-11-24', 140000.00, 23940.00, 14000.00, 149940.00, 'completed', 'Efectivo', '2025-11-25 01:52:01', '2025-11-25 01:52:01', NULL),
(193, 27, 16, 25, 19, NULL, '027-00016-210432047346-0B8F5', NULL, '8888888', '2025-11-24', 140000.00, 23940.00, 14000.00, 149940.00, 'completed', 'Efectivo', '2025-11-25 02:04:32', '2025-11-25 02:04:32', NULL),
(194, 27, 16, 25, 19, NULL, '027-00016-223453990153-F1BCC', NULL, '22222222222', '2025-11-24', 640000.00, 109440.00, 64000.00, 685440.00, 'completed', 'Efectivo', '2025-11-25 03:34:54', '2025-11-25 03:34:54', NULL),
(195, 27, 16, 25, 19, 46, '027-00016-225529108210-1A6B5', NULL, '566545564', '2025-11-24', 390000.00, 69065.00, 26500.00, 432565.00, 'completed', 'Bancolombia, Nequi', '2025-11-25 03:55:29', '2025-11-25 03:55:29', NULL),
(196, 27, 16, 25, 19, NULL, '027-00016-231037033593-0833C', NULL, '33232323', '2025-11-24', 250000.00, 47500.00, 0.00, 297500.00, 'completed', 'Efectivo', '2025-11-25 04:10:37', '2025-11-25 04:10:37', NULL),
(197, 27, 16, 25, 19, 46, '027-00016-005752617184-96AE3', NULL, '65465465', '2025-11-25', 119000.00, 22610.00, 0.00, 141610.00, 'completed', 'Nequi', '2025-11-25 05:57:52', '2025-11-25 05:57:52', NULL),
(198, 27, 16, 25, 19, 46, '027-00016-005923872973-D5210', NULL, '654654655', '2025-11-25', 119000.00, 22610.00, 0.00, 141610.00, 'completed', 'Nequi', '2025-11-25 05:59:23', '2025-11-25 05:59:23', NULL),
(199, 27, 16, 25, 19, 46, '027-00016-010121611479-95499', NULL, '6546546557', '2025-11-25', 119000.00, 21479.50, 5950.00, 134529.50, 'completed', 'Nequi', '2025-11-25 06:01:21', '2025-11-25 06:01:21', NULL),
(200, 27, 16, 25, 19, 46, '027-00016-011935098072-17F1A', NULL, 'fdfdfd787887', '2025-11-25', 119000.00, 21479.50, 5950.00, 134529.50, 'completed', 'Efectivo', '2025-11-25 06:19:35', '2025-11-25 06:19:35', NULL),
(201, 27, 16, 25, 19, NULL, '027-00016-020339781992-BEEAE', NULL, 'fact-4656465', '2025-11-25', 265370.00, 50420.30, 0.00, 315790.30, 'completed', 'Efectivo', '2025-11-25 07:03:39', '2025-11-25 07:03:39', NULL),
(202, 27, 16, 25, 19, NULL, '027-00016-021239241135-3ADF1', NULL, 'fact-46564655', '2025-11-25', 223000.00, 42370.00, 0.00, 265370.00, 'completed', 'Efectivo', '2025-11-25 07:12:39', '2025-11-25 07:12:39', NULL),
(203, 27, 16, 25, 19, NULL, '027-00016-021412003937-00F64', NULL, 'fact-465646556', '2025-11-25', 346000.00, 65740.00, 0.00, 411740.00, 'completed', 'Efectivo', '2025-11-25 07:14:12', '2025-11-25 07:14:12', NULL),
(204, 27, 16, 25, 19, NULL, '027-00016-021828383352-5D97B', NULL, 'fact-4656465567', '2025-11-25', 346000.00, 65740.00, 0.00, 411740.00, 'completed', 'Bancolombia, Addi', '2025-11-25 07:18:28', '2025-11-25 07:18:28', NULL),
(205, 27, 16, 25, 19, NULL, '027-00016-022001201675-313CE', NULL, 'fact-46564655679', '2025-11-25', 333620.00, 63387.80, 12380.00, 384627.80, 'completed', 'Bancolombia, Addi', '2025-11-25 07:20:01', '2025-11-25 07:20:01', NULL),
(206, 27, 16, 25, 19, NULL, '027-00016-022826953739-E8D8D', NULL, '99999999', '2025-11-25', 333620.00, 63387.80, 12380.00, 384627.80, 'completed', 'Efectivo', '2025-11-25 07:28:26', '2025-11-25 07:28:26', NULL),
(207, 27, 16, 25, 19, NULL, '027-00016-023231476025-7437C', NULL, '999999990', '2025-11-25', 333620.00, 63387.80, 12380.00, 397007.80, 'completed', 'Efectivo', '2025-11-25 07:32:31', '2025-11-25 07:32:31', NULL),
(208, 27, 16, 25, 19, NULL, '027-00016-023729318314-4DB6D', NULL, '9999999901', '2025-11-25', 333620.00, 63387.80, 12380.00, 397007.80, 'completed', 'Addi', '2025-11-25 07:37:29', '2025-11-25 07:37:29', NULL),
(209, 27, 16, 25, 19, NULL, '027-00016-024053615062-96299', NULL, '99999999016', '2025-11-25', 333620.00, 63387.80, 12380.00, 397007.80, 'completed', 'Addi', '2025-11-25 07:40:53', '2025-11-25 07:40:53', NULL),
(210, 27, 16, 25, 19, NULL, '027-00016-024658368936-5A12A', NULL, '544566556', '2025-11-25', 333620.00, 63387.80, 12380.00, 397007.80, 'completed', 'Davivienda, Efectivo', '2025-11-25 07:46:58', '2025-11-25 07:46:58', NULL),
(211, 27, 16, 25, 19, NULL, '027-00016-025831795714-C2445', NULL, '54456655699', '2025-11-25', 333620.00, 63387.80, 12380.00, 397007.80, 'completed', 'Davivienda, Efectivo', '2025-11-25 07:58:31', '2025-11-25 07:58:31', NULL),
(212, 27, 16, 25, 19, NULL, '027-00016-025952817228-C784F', NULL, '5445665569945', '2025-11-25', 333620.00, 63387.80, 12380.00, 397007.80, 'completed', 'Davivienda, Addi', '2025-11-25 07:59:52', '2025-11-25 07:59:52', NULL),
(213, 27, 16, 25, 19, NULL, '027-00016-033101451295-6E2E2', NULL, '8789988789', '2025-11-25', 206850.00, 39301.50, 16150.00, 246151.50, 'completed', 'Wompi, Addi', '2025-11-25 08:31:01', '2025-11-25 08:31:01', NULL),
(214, 27, 20, 25, 19, 46, '027-00020-042218382971-5D7FF', NULL, '546546556', '2025-11-25', 210084.03, 39915.97, 0.00, 250000.00, 'completed', 'Efectivo', '2025-11-25 09:22:18', '2025-11-25 09:22:18', NULL),
(216, 27, 16, 26, 16, 46, '027-00016-160455792717-C188F', NULL, '564565465', '2025-11-25', 214310.00, 40718.90, 8690.00, 255028.90, 'completed', 'Banco de Bogotá, Wompi', '2025-11-25 21:04:55', '2025-11-25 21:04:55', NULL),
(217, 27, 16, 25, 35, NULL, '027-00016-200300500780-7A42F', NULL, '434345345', '2025-11-25', 291000.00, 55290.00, 9000.00, 346290.00, 'completed', 'Bancolombia', '2025-11-26 01:03:00', '2025-11-26 01:03:00', NULL),
(218, 27, 16, 25, 19, NULL, '027-00016-211805582212-8E247', NULL, '12541254987', '2025-11-25', 100000.00, 19000.00, 0.00, 119000.00, 'completed', 'Efectivo', '2025-11-26 02:18:05', '2025-11-26 02:18:05', NULL),
(219, 28, 19, 30, 6, NULL, '028-00019-154817653920-9FA63', NULL, '5456564564', '2025-11-26', 95798.31, 18201.68, 5042.02, 113999.99, 'completed', 'Efectivo', '2025-11-26 20:48:17', '2025-11-26 20:48:17', NULL),
(220, 28, 19, 30, 14, NULL, '028-00019-161048113734-1BC48', NULL, '5645646554', '2025-11-26', 98823.52, 18776.47, 2016.81, 117599.99, 'completed', 'Banco Pichincha', '2025-11-26 21:10:48', '2025-11-26 21:10:48', NULL),
(221, 28, 19, 30, 6, 61, '028-00019-180112062143-0F2C1', NULL, '465654564', '2025-11-26', 98823.52, 18776.47, 2016.81, 117599.99, 'completed', 'Efectivo', '2025-11-26 23:01:12', '2025-11-26 23:01:12', NULL),
(222, 28, 22, 30, 5, 58, '028-00022-181939572151-8BAF9', NULL, '000025', '2025-11-26', 63000.00, 0.00, 0.00, 63000.00, 'completed', 'Efectivo', '2025-11-26 23:19:39', '2025-11-26 23:19:39', NULL),
(223, 28, 22, 30, 5, 58, '028-00022-182150423237-67548', NULL, '0000256', '2025-11-24', 63000.00, 0.00, 0.00, 63000.00, 'completed', 'Daviplata', '2025-11-26 23:21:50', '2025-11-26 23:21:50', NULL),
(224, 28, 19, 30, 5, NULL, '028-00019-203958788437-C07D8', NULL, '0000123', '2025-11-24', 617647.05, 117352.94, 12605.04, 734999.99, 'completed', 'Banco de Bogotá', '2025-11-27 01:39:58', '2025-11-27 01:39:58', NULL),
(225, 28, 19, 30, 42, 63, '028-00019-224901175536-2ADB3', NULL, '000002654', '2025-11-24', 285000.00, 54150.00, 15000.00, 339150.00, 'completed', 'Efectivo', '2025-11-25 03:49:01', '2025-11-27 03:49:01', NULL),
(226, 28, 19, 30, 42, NULL, '028-00019-230146899136-DB843', NULL, '00002541', '2025-11-26', 300000.00, 45000.00, 0.00, 345000.00, 'completed', 'Nequi', '2025-11-27 04:01:46', '2025-11-27 04:01:46', NULL),
(227, 28, 19, 30, 42, 63, '028-00019-130734550830-867B1', NULL, '00001236', '2025-11-27', 18000000.00, 2160000.00, 2000000.00, 20160000.00, 'completed', 'Efectivo', '2025-11-27 18:07:34', '2025-11-27 18:07:34', NULL),
(228, 28, 19, 30, 59, NULL, '028-00019-190838635108-9B0E6', NULL, '000023695', '2025-11-25', 300000.00, 57000.00, 0.00, 357000.00, 'completed', 'Efectivo', '2025-11-26 00:08:38', '2025-11-29 00:08:38', NULL),
(229, 28, 56, 30, 59, NULL, '028-00056-195121170604-29A6E', NULL, '00001236548', '2025-11-28', 3600000.00, 684000.00, 0.00, 4284000.00, 'completed', 'Efectivo', '2025-11-29 00:51:21', '2025-11-29 00:51:21', NULL),
(230, 28, 19, 30, 58, NULL, '028-00019-230641543229-84A00', NULL, '00000234455', '2025-11-28', 1470000.00, 279300.00, 30000.00, 1749300.00, 'completed', 'PSE', '2025-11-29 04:06:41', '2025-11-29 04:06:41', NULL),
(231, 28, 19, 30, 56, NULL, '028-00019-231030384224-5DCE3', NULL, '00000032', '2025-11-28', 1217700.00, 231363.00, 12300.00, 1449063.00, 'completed', 'Efectivo', '2025-11-29 04:10:30', '2025-11-29 04:10:30', NULL),
(232, 28, 54, 30, 56, NULL, '028-00054-232145765325-BAD91', NULL, '000012554', '2025-11-28', 5673690.00, 1078001.10, 57310.00, 6751691.10, 'completed', 'Itaú Colombia', '2025-11-29 04:21:45', '2025-11-29 04:21:45', NULL),
(233, 28, 54, 30, 52, NULL, '028-00054-232840554251-8750E', NULL, '0002145', '2025-11-28', 52100000.00, 9899000.00, 0.00, 61999000.00, 'completed', 'Efectivo', '2025-11-29 04:28:40', '2025-11-29 04:28:40', NULL),
(234, 28, 54, 30, 59, NULL, '028-00054-233859930609-E3334', NULL, '00123456', '2025-11-28', 5210000.00, 989900.00, 0.00, 6199900.00, 'completed', 'Efectivo', '2025-11-29 04:38:59', '2025-11-29 04:38:59', NULL),
(235, 28, 19, 30, 56, NULL, '028-00019-143814536746-830AD', NULL, '000002541', '2025-11-29', 4968500.00, 944015.00, 261500.00, 5912515.00, 'completed', 'Addi', '2025-11-29 19:38:14', '2025-11-29 19:38:14', NULL),
(236, 28, 19, 30, 58, NULL, '028-00019-122828786849-C01A4', NULL, '00003254', '2025-12-01', 39200000.00, 4704000.00, 800000.00, 43904000.00, 'completed', 'Efectivo', '2025-12-01 17:28:28', '2025-12-01 17:28:28', NULL),
(237, 28, 19, 30, 59, NULL, '028-00019-123431331301-50E28', NULL, '00023654', '2025-12-01', 5177700.00, 983763.00, 52300.00, 6161463.00, 'completed', 'Efectivo', '2025-12-01 17:34:31', '2025-12-01 17:34:31', NULL),
(238, 28, 19, 30, 54, NULL, '028-00019-123705096683-179AE', NULL, '00012548', '2025-12-01', 210084.03, 39915.97, 0.00, 250000.00, 'completed', 'Efectivo', '2025-12-01 17:37:05', '2025-12-01 17:37:05', NULL),
(239, 28, 19, 30, 60, NULL, '028-00019-123823327274-4FE6E', NULL, '000125489', '2025-12-01', 210084.03, 39915.97, 0.00, 250000.00, 'completed', 'Efectivo', '2025-12-01 17:38:23', '2025-12-01 17:38:23', NULL),
(240, 28, 19, 30, 64, NULL, '028-00019-232957440518-6B8C8', NULL, '000023698', '2025-12-01', 123000.00, 23370.00, 0.00, 146370.00, 'completed', 'Efectivo', '2025-12-02 04:29:57', '2025-12-02 04:29:57', NULL),
(241, 28, 19, 30, 65, NULL, '028-00019-233552525130-8034C', NULL, '12121221', '2025-12-01', 123000.00, 23370.00, 0.00, 146370.00, 'completed', 'Efectivo', '2025-12-02 04:35:52', '2025-12-02 04:35:52', NULL),
(242, 28, 19, 30, 65, NULL, '028-00019-233601495706-7905D', NULL, '12121221w', '2025-12-01', 123000.00, 23370.00, 0.00, 146370.00, 'completed', 'Efectivo', '2025-12-02 04:36:01', '2025-12-02 04:36:01', NULL),
(243, 28, 19, 30, 65, NULL, '028-00019-233614356529-570B4', NULL, '12121221wq', '2025-12-01', 123000.00, 23370.00, 0.00, 146370.00, 'completed', 'Efectivo', '2025-12-02 04:36:14', '2025-12-02 04:36:14', NULL),
(244, 28, 19, 30, 53, NULL, '028-00019-233726135325-2109F', NULL, '45545445', '2025-12-01', 523000.00, 99370.00, 0.00, 622370.00, 'completed', 'Efectivo', '2025-12-02 04:37:26', '2025-12-02 04:37:26', NULL),
(245, 28, 19, 30, 53, NULL, '028-00019-233738038336-095C4', NULL, '45545445S', '2025-12-01', 523000.00, 99370.00, 0.00, 622370.00, 'completed', 'Efectivo', '2025-12-02 04:37:38', '2025-12-02 04:37:38', NULL),
(246, 28, 19, 30, 53, NULL, '028-00019-233754368674-5A024', NULL, '45545445SEE', '2025-12-01', 523000.00, 99370.00, 0.00, 622370.00, 'completed', 'Efectivo', '2025-12-02 04:37:54', '2025-12-02 04:37:54', NULL),
(247, 28, 19, 30, 53, NULL, '028-00019-234747214633-3466C', NULL, '00002145', '2025-12-01', 650000.00, 97500.00, 0.00, 747500.00, 'completed', 'Efectivo', '2025-12-02 04:47:47', '2025-12-02 04:47:47', NULL),
(248, 28, 19, 30, 53, NULL, '028-00019-234753136495-21532', NULL, '00002145s', '2025-12-01', 650000.00, 97500.00, 0.00, 747500.00, 'completed', 'Efectivo', '2025-12-02 04:47:53', '2025-12-02 04:47:53', NULL),
(249, 28, 19, 30, 53, NULL, '028-00019-234912563285-89858', NULL, '554545', '2025-12-01', 123000.00, 23370.00, 0.00, 146370.00, 'completed', 'Efectivo', '2025-12-02 04:49:12', '2025-12-02 04:49:12', NULL),
(250, 28, 19, 30, 53, NULL, '028-00019-001635599808-92702', NULL, '0002541', '2025-12-02', 19600000.00, 2352000.00, 400000.00, 21952000.00, 'completed', 'Efectivo', '2025-12-02 05:16:35', '2025-12-02 05:16:35', NULL),
(251, 28, 19, 30, 53, NULL, '028-00019-060104460139-7056E', NULL, '00012454', '2025-12-02', 18000000.00, 2160000.00, 2000000.00, 20160000.00, 'completed', 'Efectivo', '2025-12-02 11:01:04', '2025-12-02 11:01:04', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'Unidades vendidas de este producto',
  `unit_price` decimal(10,2) NOT NULL,
  `tax_rate` decimal(5,2) NOT NULL COMMENT 'Tasa de impuesto aplicada',
  `discount_applied` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Descuento total en esta línea',
  `line_total` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_provider_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `inventory_id`, `sku`, `quantity`, `unit_price`, `tax_rate`, `discount_applied`, `line_total`, `payment_method`, `created_at`, `updated_at`, `payment_provider_id`) VALUES
(73, 100, 15, '00027016000001', 2, 250000.00, 19.00, 25000.00, 565250.00, 'Addi', '2025-11-20 02:37:35', '2025-11-20 02:37:35', 30),
(74, 100, 15, '00027016000001', 2, 250000.00, 19.00, 25000.00, 565250.00, 'Addi', '2025-11-20 02:37:35', '2025-11-20 02:37:35', 30),
(75, 102, 15, '00027016000001', 2, 250000.00, 19.00, 25000.00, 565250.00, 'Addi', '2025-11-20 02:38:43', '2025-11-20 02:38:43', 44),
(76, 102, 15, '00027016000001', 2, 250000.00, 19.00, 25000.00, 565250.00, 'Addi', '2025-11-20 02:38:43', '2025-11-20 02:38:43', 44),
(77, 103, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-20 02:41:09', '2025-11-20 02:41:09', 48),
(78, 103, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-20 02:41:09', '2025-11-20 02:41:09', 48),
(79, 104, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Credito', '2025-11-20 20:06:48', '2025-11-20 20:06:48', 34),
(80, 106, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Credito', '2025-11-20 20:12:11', '2025-11-20 20:12:11', 34),
(81, 106, 22, '00027016000007', 1, 250000.00, 5.00, 12500.00, 249375.00, 'Efectivo', '2025-11-20 20:12:11', '2025-11-20 20:12:11', 34),
(82, 108, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Credito', '2025-11-20 20:12:59', '2025-11-20 20:12:59', 34),
(83, 108, 22, '00027016000007', 1, 250000.00, 5.00, 12500.00, 249375.00, 'Efectivo', '2025-11-20 20:12:59', '2025-11-20 20:12:59', 48),
(84, 109, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Credito', '2025-11-20 20:15:12', '2025-11-20 20:15:12', 34),
(85, 109, 22, '00027016000007', 1, 250000.00, 5.00, 12500.00, 249375.00, 'Efectivo', '2025-11-20 20:15:12', '2025-11-20 20:15:12', 48),
(86, 110, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Credito', '2025-11-20 20:16:06', '2025-11-20 20:16:06', 34),
(87, 110, 22, '00027016000007', 1, 250000.00, 5.00, 12500.00, 249375.00, 'Efectivo', '2025-11-20 20:16:06', '2025-11-20 20:16:06', 48),
(88, 111, 15, '00027016000001', 2, 250000.00, 19.00, 25000.00, 565250.00, 'Addi', '2025-11-21 06:20:40', '2025-11-21 06:20:40', 30),
(89, 112, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 06:44:10', '2025-11-21 06:44:10', 48),
(90, 112, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 06:44:10', '2025-11-21 06:44:10', 48),
(91, 113, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 06:44:34', '2025-11-21 06:44:34', 48),
(92, 113, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 06:44:34', '2025-11-21 06:44:34', 48),
(93, 115, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 06:45:22', '2025-11-21 06:45:22', 48),
(94, 115, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 06:45:22', '2025-11-21 06:45:22', 48),
(95, 116, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 06:46:37', '2025-11-21 06:46:37', 48),
(96, 116, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 06:46:37', '2025-11-21 06:46:37', 48),
(97, 118, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 06:47:05', '2025-11-21 06:47:05', 48),
(98, 118, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 06:47:05', '2025-11-21 06:47:05', 48),
(99, 119, 22, '00027016000007', 1, 250000.00, 5.00, 12500.00, 249375.00, 'Efectivo', '2025-11-21 06:47:48', '2025-11-21 06:47:48', 48),
(100, 119, 22, '00027016000007', 1, 250000.00, 5.00, 12500.00, 249375.00, 'Efectivo', '2025-11-21 06:47:48', '2025-11-21 06:47:48', 48),
(101, 120, 21, '00027017000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 06:49:57', '2025-11-21 06:49:57', 48),
(102, 120, 21, '00027017000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 06:49:57', '2025-11-21 06:49:57', 48),
(103, 122, 21, '00027017000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Nequi', '2025-11-21 06:51:41', '2025-11-21 06:51:41', 48),
(104, 122, 21, '00027017000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 06:51:41', '2025-11-21 06:51:41', 48),
(105, 123, 21, '00027017000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Nequi', '2025-11-21 06:52:08', '2025-11-21 06:52:08', 48),
(106, 124, 21, '00027017000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Nequi', '2025-11-21 06:52:38', '2025-11-21 06:52:38', 48),
(107, 126, 21, '00027017000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Nequi', '2025-11-21 06:53:11', '2025-11-21 06:53:11', 48),
(108, 127, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 06:59:44', '2025-11-21 06:59:44', 48),
(109, 127, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 06:59:44', '2025-11-21 06:59:44', 48),
(110, 128, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:02:19', '2025-11-21 07:02:19', 48),
(111, 129, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:08:42', '2025-11-21 07:08:42', 48),
(112, 129, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:08:42', '2025-11-21 07:08:42', 48),
(113, 130, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:09:32', '2025-11-21 07:09:32', 48),
(114, 130, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:09:32', '2025-11-21 07:09:32', 48),
(115, 131, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:11:40', '2025-11-21 07:11:40', 48),
(116, 131, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:11:40', '2025-11-21 07:11:40', 48),
(117, 132, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:13:48', '2025-11-21 07:13:48', 48),
(118, 132, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:13:48', '2025-11-21 07:13:48', 48),
(119, 134, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:19:33', '2025-11-21 07:19:33', 48),
(120, 134, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:19:33', '2025-11-21 07:19:33', 48),
(121, 135, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:22:00', '2025-11-21 07:22:00', 48),
(122, 135, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:22:00', '2025-11-21 07:22:00', 48),
(123, 136, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:23:14', '2025-11-21 07:23:14', 48),
(124, 136, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:23:14', '2025-11-21 07:23:14', 48),
(125, 138, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:24:03', '2025-11-21 07:24:03', 48),
(126, 138, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 07:24:03', '2025-11-21 07:24:03', 48),
(127, 139, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:33:15', '2025-11-21 07:33:15', 48),
(128, 139, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:33:15', '2025-11-21 07:33:15', 48),
(129, 140, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:35:19', '2025-11-21 07:35:19', 48),
(130, 140, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:35:19', '2025-11-21 07:35:19', 48),
(131, 141, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:40:50', '2025-11-21 07:40:50', 48),
(132, 141, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:40:50', '2025-11-21 07:40:50', 48),
(133, 142, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:42:56', '2025-11-21 07:42:56', 48),
(134, 142, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:42:56', '2025-11-21 07:42:56', 48),
(135, 143, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:43:30', '2025-11-21 07:43:30', 48),
(136, 143, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:43:30', '2025-11-21 07:43:30', 48),
(137, 144, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:45:05', '2025-11-21 07:45:05', 48),
(138, 144, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:45:05', '2025-11-21 07:45:05', 48),
(139, 145, 12, '00028019000003', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 07:46:07', '2025-11-21 07:46:07', 48),
(140, 145, 12, '00028019000003', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 07:46:07', '2025-11-21 07:46:07', 48),
(141, 146, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:57:25', '2025-11-21 07:57:25', 48),
(142, 146, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 07:57:25', '2025-11-21 07:57:25', 48),
(143, 147, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 08:00:01', '2025-11-21 08:00:01', 30),
(144, 147, 25, '00028049000002', 1, 120000.00, 12.00, 6000.00, 127680.00, 'Efectivo', '2025-11-21 08:00:01', '2025-11-21 08:00:01', 30),
(145, 148, 21, '00027017000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 08:00:58', '2025-11-21 08:00:58', 30),
(146, 148, 21, '00027017000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 08:00:58', '2025-11-21 08:00:58', 30),
(147, 149, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 08:26:33', '2025-11-21 08:26:33', 30),
(148, 149, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 08:26:33', '2025-11-21 08:26:33', 30),
(149, 150, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Transferencia', '2025-11-21 08:32:14', '2025-11-21 08:32:14', 30),
(150, 150, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 08:32:14', '2025-11-21 08:32:14', 30),
(151, 152, 30, '00027016000009', 1, 320000.00, 19.00, 16000.00, 361760.00, 'Efectivo', '2025-11-21 08:51:12', '2025-11-21 08:51:12', 30),
(152, 152, 30, '00027016000009', 1, 320000.00, 19.00, 16000.00, 361760.00, 'Efectivo', '2025-11-21 08:51:12', '2025-11-21 08:51:12', 30),
(153, 155, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 09:23:58', '2025-11-21 09:23:58', 30),
(154, 155, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 09:23:58', '2025-11-21 09:23:58', 30),
(155, 156, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 09:24:26', '2025-11-21 09:24:26', 30),
(156, 156, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 09:24:26', '2025-11-21 09:24:26', 30),
(157, 157, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Daviplata', '2025-11-21 09:24:54', '2025-11-21 09:24:54', 30),
(158, 157, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'PSE', '2025-11-21 09:24:54', '2025-11-21 09:24:54', 30),
(159, 158, 15, '00027016000001', 1, 250000.00, 19.00, 0.00, 297500.00, 'Daviplata', '2025-11-21 09:25:15', '2025-11-21 09:25:15', 30),
(160, 158, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'PSE', '2025-11-21 09:25:15', '2025-11-21 09:25:15', 30),
(161, 159, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 09:28:37', '2025-11-21 09:28:37', 30),
(162, 159, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 09:28:37', '2025-11-21 09:28:37', 30),
(163, 160, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 09:29:38', '2025-11-21 09:29:38', 30),
(164, 160, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 09:29:38', '2025-11-21 09:29:38', 30),
(165, 161, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 09:32:04', '2025-11-21 09:32:04', 30),
(166, 161, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 09:32:04', '2025-11-21 09:32:04', 30),
(167, 162, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 09:32:37', '2025-11-21 09:32:37', 30),
(168, 162, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 09:32:37', '2025-11-21 09:32:37', 30),
(169, 163, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 09:33:48', '2025-11-21 09:33:48', 30),
(170, 163, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 09:33:48', '2025-11-21 09:33:48', 30),
(171, 164, 15, '00027016000001', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-21 09:37:16', '2025-11-21 09:37:16', 30),
(172, 164, 23, '00027016000008', 1, 190000.00, 30.00, 0.00, 247000.00, 'Efectivo', '2025-11-21 09:37:16', '2025-11-21 09:37:16', 30),
(173, 165, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 13:15:11', '2025-11-21 13:15:11', 30),
(174, 165, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 13:15:11', '2025-11-21 13:15:11', 30),
(175, 166, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-21 13:16:21', '2025-11-21 13:16:21', 30),
(176, 166, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-21 13:16:21', '2025-11-21 13:16:21', 30),
(177, 167, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-24 23:06:30', '2025-11-24 23:06:30', 48),
(178, 167, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-24 23:06:30', '2025-11-24 23:06:30', 48),
(179, 168, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-24 23:14:47', '2025-11-24 23:14:47', 48),
(180, 168, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-24 23:14:47', '2025-11-24 23:14:47', 48),
(181, 169, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-24 23:19:57', '2025-11-24 23:19:57', 48),
(182, 169, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-24 23:19:57', '2025-11-24 23:19:57', 48),
(183, 170, 15, '00027016000001', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Efectivo', '2025-11-24 23:23:03', '2025-11-24 23:23:03', 48),
(184, 170, 23, '00027016000008', 1, 190000.00, 30.00, 9500.00, 234650.00, 'Efectivo', '2025-11-24 23:23:03', '2025-11-24 23:23:03', 48),
(185, 171, 17, '00027016000003', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-24 23:27:20', '2025-11-24 23:27:20', 28),
(186, 172, 17, '00027016000003', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-24 23:28:09', '2025-11-24 23:28:09', 28),
(187, 172, 18, '00027016000004', 1, 250000.00, 19.00, 25000.00, 267750.00, 'Efectivo', '2025-11-24 23:28:09', '2025-11-24 23:28:09', 48),
(188, 173, 17, '00027016000003', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-24 23:46:48', '2025-11-24 23:46:48', 48),
(189, 174, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 00:03:33', '2025-11-25 00:03:33', 48),
(190, 175, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 00:08:15', '2025-11-25 00:08:15', 48),
(191, 176, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 00:09:13', '2025-11-25 00:09:13', 48),
(192, 177, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 00:12:06', '2025-11-25 00:12:06', 48),
(193, 178, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 00:41:59', '2025-11-25 00:41:59', 48),
(194, 179, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 00:44:07', '2025-11-25 00:44:07', 48),
(195, 180, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 00:44:38', '2025-11-25 00:44:38', 48),
(196, 181, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 00:45:13', '2025-11-25 00:45:13', 48),
(197, 182, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 00:49:28', '2025-11-25 00:49:28', 48),
(198, 183, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 00:49:57', '2025-11-25 00:49:57', 42),
(199, 184, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 00:55:18', '2025-11-25 00:55:18', 35),
(200, 185, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 00:59:40', '2025-11-25 00:59:40', 48),
(201, 186, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 01:00:41', '2025-11-25 01:00:41', 39),
(202, 187, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 01:10:52', '2025-11-25 01:10:52', 48),
(203, 188, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Wompi', '2025-11-25 01:11:11', '2025-11-25 01:11:11', 43),
(204, 189, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Wompi', '2025-11-25 01:13:18', '2025-11-25 01:13:18', 43),
(205, 190, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'PSE', '2025-11-25 01:25:45', '2025-11-25 01:25:45', 36),
(206, 190, 19, '00027016000005', 1, 250000.00, 19.00, 0.00, 297500.00, 'Itaú Colombia', '2025-11-25 01:25:45', '2025-11-25 01:25:45', 33),
(207, 191, 19, '00027016000005', 1, 140000.00, 19.00, 0.00, 166600.00, 'PayU', '2025-11-25 01:30:10', '2025-11-25 01:30:10', 41),
(208, 191, 18, '00027016000004', 1, 250000.00, 19.00, 5000.00, 291550.00, 'Nequi', '2025-11-25 01:30:10', '2025-11-25 01:30:10', 37),
(209, 192, 19, '00027016000005', 1, 140000.00, 19.00, 14000.00, 149940.00, 'Efectivo', '2025-11-25 01:52:01', '2025-11-25 01:52:01', 48),
(210, 193, 19, '00027016000005', 1, 140000.00, 19.00, 14000.00, 149940.00, 'Efectivo', '2025-11-25 02:04:32', '2025-11-25 02:04:32', 48),
(211, 194, 18, '00027016000004', 2, 250000.00, 19.00, 50000.00, 535500.00, 'Efectivo', '2025-11-25 03:34:54', '2025-11-25 03:34:54', 48),
(212, 194, 19, '00027016000005', 1, 140000.00, 19.00, 14000.00, 149940.00, 'Efectivo', '2025-11-25 03:34:54', '2025-11-25 03:34:54', 48),
(213, 195, 18, '00027016000004', 1, 250000.00, 19.00, 12500.00, 282625.00, 'Bancolombia', '2025-11-25 03:55:29', '2025-11-25 03:55:29', 26),
(214, 195, 19, '00027016000005', 1, 140000.00, 19.00, 14000.00, 149940.00, 'Nequi', '2025-11-25 03:55:29', '2025-11-25 03:55:29', 37),
(215, 196, 18, '00027016000004', 1, 250000.00, 19.00, 0.00, 297500.00, 'Efectivo', '2025-11-25 04:10:37', '2025-11-25 04:10:37', 48),
(216, 197, 36, '00027016000015', 1, 119000.00, 19.00, 0.00, 141610.00, 'Nequi', '2025-11-25 05:57:52', '2025-11-25 05:57:52', 37),
(217, 198, 36, '00027016000015', 1, 119000.00, 19.00, 0.00, 141610.00, 'Nequi', '2025-11-25 05:59:23', '2025-11-25 05:59:23', 37),
(218, 199, 36, '00027016000015', 1, 119000.00, 19.00, 5950.00, 134529.50, 'Nequi', '2025-11-25 06:01:21', '2025-11-25 06:01:21', 37),
(219, 200, 36, '00027016000015', 1, 119000.00, 19.00, 5950.00, 134529.50, 'Efectivo', '2025-11-25 06:19:35', '2025-11-25 06:19:35', 48),
(220, 201, 37, '00027016000016', 1, 146370.00, 19.00, 0.00, 174180.30, 'Efectivo', '2025-11-25 07:03:39', '2025-11-25 07:03:39', 48),
(221, 201, 36, '00027016000015', 1, 119000.00, 19.00, 0.00, 141610.00, 'Efectivo', '2025-11-25 07:03:39', '2025-11-25 07:03:39', 48),
(222, 202, 37, '00027016000016', 1, 123000.00, 19.00, 0.00, 146370.00, 'Efectivo', '2025-11-25 07:12:39', '2025-11-25 07:12:39', 48),
(223, 202, 36, '00027016000015', 1, 100000.00, 19.00, 0.00, 119000.00, 'Efectivo', '2025-11-25 07:12:39', '2025-11-25 07:12:39', 48),
(224, 203, 37, '00027016000016', 2, 123000.00, 19.00, 0.00, 292740.00, 'Efectivo', '2025-11-25 07:14:12', '2025-11-25 07:14:12', 48),
(225, 203, 36, '00027016000015', 1, 100000.00, 19.00, 0.00, 119000.00, 'Efectivo', '2025-11-25 07:14:12', '2025-11-25 07:14:12', 48),
(226, 204, 37, '00027016000016', 2, 123000.00, 19.00, 0.00, 292740.00, 'Bancolombia', '2025-11-25 07:18:28', '2025-11-25 07:18:28', 26),
(227, 204, 36, '00027016000015', 1, 100000.00, 19.00, 0.00, 119000.00, 'Addi', '2025-11-25 07:18:28', '2025-11-25 07:18:28', 44),
(228, 205, 37, '00027016000016', 2, 123000.00, 19.00, 7380.00, 283957.80, 'Bancolombia', '2025-11-25 07:20:01', '2025-11-25 07:20:01', 26),
(229, 205, 36, '00027016000015', 1, 100000.00, 19.00, 5000.00, 113050.00, 'Addi', '2025-11-25 07:20:01', '2025-11-25 07:20:01', 44),
(230, 206, 36, '00027016000015', 1, 100000.00, 19.00, 5000.00, 113050.00, 'Efectivo', '2025-11-25 07:28:26', '2025-11-25 07:28:26', 48),
(231, 206, 37, '00027016000016', 2, 123000.00, 19.00, 7380.00, 283957.80, 'Efectivo', '2025-11-25 07:28:26', '2025-11-25 07:28:26', 48),
(232, 207, 36, '00027016000015', 1, 100000.00, 19.00, 5000.00, 113050.00, 'Efectivo', '2025-11-25 07:32:31', '2025-11-25 07:32:31', 48),
(233, 207, 37, '00027016000016', 2, 123000.00, 19.00, 7380.00, 283957.80, 'Efectivo', '2025-11-25 07:32:31', '2025-11-25 07:32:31', 48),
(234, 208, 36, '00027016000015', 1, 100000.00, 19.00, 5000.00, 113050.00, 'Addi', '2025-11-25 07:37:29', '2025-11-25 07:37:29', 44),
(235, 208, 37, '00027016000016', 2, 123000.00, 19.00, 7380.00, 283957.80, 'Addi', '2025-11-25 07:37:29', '2025-11-25 07:37:29', 44),
(236, 209, 36, '00027016000015', 1, 100000.00, 19.00, 5000.00, 113050.00, 'Addi', '2025-11-25 07:40:53', '2025-11-25 07:40:53', 44),
(237, 209, 37, '00027016000016', 2, 123000.00, 19.00, 7380.00, 283957.80, 'Addi', '2025-11-25 07:40:53', '2025-11-25 07:40:53', 44),
(238, 210, 36, '00027016000015', 1, 100000.00, 19.00, 5000.00, 113050.00, 'Davivienda', '2025-11-25 07:46:58', '2025-11-25 07:46:58', 28),
(239, 210, 37, '00027016000016', 2, 123000.00, 19.00, 7380.00, 283957.80, 'Efectivo', '2025-11-25 07:46:58', '2025-11-25 07:46:58', 48),
(240, 211, 36, '00027016000015', 1, 100000.00, 19.00, 5000.00, 113050.00, 'Davivienda', '2025-11-25 07:58:31', '2025-11-25 07:58:31', 28),
(241, 211, 37, '00027016000016', 2, 123000.00, 19.00, 7380.00, 283957.80, 'Efectivo', '2025-11-25 07:58:31', '2025-11-25 07:58:31', 48),
(242, 212, 36, '00027016000015', 1, 100000.00, 19.00, 5000.00, 113050.00, 'Davivienda', '2025-11-25 07:59:52', '2025-11-25 07:59:52', 28),
(243, 212, 37, '00027016000016', 2, 123000.00, 19.00, 7380.00, 283957.80, 'Addi', '2025-11-25 07:59:52', '2025-11-25 07:59:52', 44),
(244, 213, 37, '00027016000016', 1, 123000.00, 19.00, 6150.00, 139051.50, 'Wompi', '2025-11-25 08:31:01', '2025-11-25 08:31:01', 43),
(245, 213, 36, '00027016000015', 1, 100000.00, 19.00, 10000.00, 107100.00, 'Addi', '2025-11-25 08:31:01', '2025-11-25 08:31:01', 44),
(246, 214, 13, '00027019000001', 1, 210084.03, 19.00, 0.00, 250000.00, 'Efectivo', '2025-11-25 09:22:18', '2025-11-25 09:22:18', 48),
(249, 216, 37, '00027016000016', 1, 123000.00, 19.00, 3690.00, 141978.90, 'Banco de Bogotá', '2025-11-25 21:04:55', '2025-11-25 21:04:55', 27),
(250, 216, 36, '00027016000015', 1, 100000.00, 19.00, 5000.00, 113050.00, 'Wompi', '2025-11-25 21:04:55', '2025-11-25 21:04:55', 43),
(251, 217, 36, '00027016000015', 3, 100000.00, 19.00, 9000.00, 346290.00, 'Bancolombia', '2025-11-26 01:03:00', '2025-11-26 01:03:00', 26),
(252, 218, 36, '00027016000015', 1, 100000.00, 19.00, 0.00, 119000.00, 'Efectivo', '2025-11-26 02:18:05', '2025-11-26 02:18:05', 48),
(253, 219, 12, '00028019000003', 1, 100840.33, 19.00, 5042.02, 113999.99, 'Efectivo', '2025-11-26 20:48:17', '2025-11-26 20:48:17', 117),
(254, 220, 12, '00028019000003', 1, 100840.33, 19.00, 2016.81, 117599.99, 'Banco Pichincha', '2025-11-26 21:10:48', '2025-11-26 21:10:48', 124),
(255, 221, 12, '00028019000003', 1, 100840.33, 19.00, 2016.81, 117599.99, 'Efectivo', '2025-11-26 23:01:12', '2025-11-26 23:01:12', 117),
(256, 222, 39, '00028022000001', 1, 63000.00, 0.00, 0.00, 63000.00, 'Efectivo', '2025-11-26 23:19:39', '2025-11-26 23:19:39', 117),
(257, 223, 39, '00028022000001', 1, 63000.00, 0.00, 0.00, 63000.00, 'Daviplata', '2025-11-26 23:21:50', '2025-11-26 23:21:50', 130),
(258, 224, 12, '00028019000003', 3, 210084.03, 19.00, 12605.04, 734999.99, 'Banco de Bogotá', '2025-11-27 01:39:58', '2025-11-27 01:39:58', 119),
(259, 225, 44, '00028019000008', 1, 300000.00, 19.00, 15000.00, 339150.00, 'Efectivo', '2025-11-27 03:49:01', '2025-11-27 03:49:01', 117),
(260, 226, 43, '00028019000007', 1, 300000.00, 15.00, 0.00, 345000.00, 'Nequi', '2025-11-27 04:01:46', '2025-11-27 04:01:46', 129),
(261, 227, 45, '00028019000009', 1, 20000000.00, 12.00, 2000000.00, 20160000.00, 'Efectivo', '2025-11-27 18:07:34', '2025-11-27 18:07:34', 117),
(262, 228, 44, '00028019000008', 1, 300000.00, 19.00, 0.00, 357000.00, 'Efectivo', '2025-11-29 00:08:38', '2025-11-29 00:08:38', 117),
(263, 229, 48, '00028056000001', 10, 360000.00, 19.00, 0.00, 4284000.00, 'Efectivo', '2025-11-29 00:51:21', '2025-11-29 00:51:21', 117),
(264, 230, 44, '00028019000008', 5, 300000.00, 19.00, 30000.00, 1749300.00, 'PSE', '2025-11-29 04:06:41', '2025-11-29 04:06:41', 128),
(265, 231, 47, '00028019000011', 10, 123000.00, 19.00, 12300.00, 1449063.00, 'Efectivo', '2025-11-29 04:10:30', '2025-11-29 04:10:30', 117),
(266, 232, 49, '00028054000001', 11, 521000.00, 19.00, 57310.00, 6751691.10, 'Itaú Colombia', '2025-11-29 04:21:45', '2025-11-29 04:21:45', 125),
(267, 233, 49, '00028054000001', 100, 521000.00, 19.00, 0.00, 61999000.00, 'Efectivo', '2025-11-29 04:28:40', '2025-11-29 04:28:40', 117),
(268, 234, 49, '00028054000001', 10, 521000.00, 19.00, 0.00, 6199900.00, 'Efectivo', '2025-11-29 04:38:59', '2025-11-29 04:38:59', 117),
(269, 235, 46, '00028019000010', 10, 523000.00, 19.00, 261500.00, 5912515.00, 'Addi', '2025-11-29 19:38:14', '2025-11-29 19:38:14', 136),
(270, 236, 45, '00028019000009', 2, 20000000.00, 12.00, 800000.00, 43904000.00, 'Efectivo', '2025-12-01 17:28:28', '2025-12-01 17:28:28', 117),
(271, 237, 46, '00028019000010', 10, 523000.00, 19.00, 52300.00, 6161463.00, 'Efectivo', '2025-12-01 17:34:31', '2025-12-01 17:34:31', 117),
(272, 238, 12, '00028019000003', 1, 210084.03, 19.00, 0.00, 250000.00, 'Efectivo', '2025-12-01 17:37:05', '2025-12-01 17:37:05', 117),
(273, 239, 12, '00028019000003', 1, 210084.03, 19.00, 0.00, 250000.00, 'Efectivo', '2025-12-01 17:38:23', '2025-12-01 17:38:23', 117),
(274, 240, 47, '00028019000011', 1, 123000.00, 19.00, 0.00, 146370.00, 'Efectivo', '2025-12-02 04:29:57', '2025-12-02 04:29:57', 117),
(275, 241, 47, '00028019000011', 1, 123000.00, 19.00, 0.00, 146370.00, 'Efectivo', '2025-12-02 04:35:52', '2025-12-02 04:35:52', 117),
(276, 242, 47, '00028019000011', 1, 123000.00, 19.00, 0.00, 146370.00, 'Efectivo', '2025-12-02 04:36:01', '2025-12-02 04:36:01', 117),
(277, 243, 47, '00028019000011', 1, 123000.00, 19.00, 0.00, 146370.00, 'Efectivo', '2025-12-02 04:36:14', '2025-12-02 04:36:14', 117),
(278, 244, 46, '00028019000010', 1, 523000.00, 19.00, 0.00, 622370.00, 'Efectivo', '2025-12-02 04:37:26', '2025-12-02 04:37:26', 117),
(279, 245, 46, '00028019000010', 1, 523000.00, 19.00, 0.00, 622370.00, 'Efectivo', '2025-12-02 04:37:38', '2025-12-02 04:37:38', 117),
(280, 246, 46, '00028019000010', 1, 523000.00, 19.00, 0.00, 622370.00, 'Efectivo', '2025-12-02 04:37:54', '2025-12-02 04:37:54', 117),
(281, 247, 50, '00028019000012', 1, 650000.00, 15.00, 0.00, 747500.00, 'Efectivo', '2025-12-02 04:47:47', '2025-12-02 04:47:47', 117),
(282, 248, 50, '00028019000012', 1, 650000.00, 15.00, 0.00, 747500.00, 'Efectivo', '2025-12-02 04:47:53', '2025-12-02 04:47:53', 117),
(283, 249, 47, '00028019000011', 1, 123000.00, 19.00, 0.00, 146370.00, 'Efectivo', '2025-12-02 04:49:12', '2025-12-02 04:49:12', 117),
(284, 250, 45, '00028019000009', 1, 20000000.00, 12.00, 400000.00, 21952000.00, 'Efectivo', '2025-12-02 05:16:35', '2025-12-02 05:16:35', 117),
(285, 251, 45, '00028019000009', 1, 20000000.00, 12.00, 2000000.00, 20160000.00, 'Efectivo', '2025-12-02 11:01:04', '2025-12-02 11:01:04', 117);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `suppliers`
--

INSERT INTO `suppliers` (`id`, `company_id`, `name`, `document`, `email`, `phone`, `address`, `city`, `country`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 27, 'Joyas del Sur', '12345678-9', 'contacto@gafasygafas.com', '98787 5656', 'Av. Central 456', 'Colombia', 'Bogotá', 1, '2025-11-18 03:29:47', '2025-11-18 03:29:47', NULL),
(7, 27, 'Joyas del Sur', '12345676-9', 'contacto@gafasygafas.com', '98787 5656', 'Av. Central 456', 'Colombia', 'Bogotá', 1, '2025-11-18 03:47:18', '2025-11-18 03:47:18', NULL),
(8, 27, 'wwwwwwww', 'www', 'h@gmail.com', '3174885954', 'Urb villa liliana', 'Armenia', 'Colombia', 1, '2025-11-18 04:01:58', '2025-11-18 04:01:58', NULL),
(9, 27, 'qsa', 'eee', 'ewe@gmail.com', '3174885954', 'Urb villa liliana', 'Armenia', 'Colombia', 1, '2025-11-18 04:10:54', '2025-11-18 04:10:54', NULL),
(10, 27, 'qsa', '55555', 'ewe@gmail.com', '3174885954', 'Urb villa liliana', 'Armenia', 'Colombia', 1, '2025-11-18 04:12:23', '2025-11-18 04:12:23', NULL),
(11, 27, 'ooooooooooo', 'oooooo', 'oooooooooo@gmail.com', '3174885954', 'Urb villa liliana', 'Armenia', 'Colombia', 1, '2025-11-18 04:13:43', '2025-11-18 04:13:43', NULL),
(12, 27, 'xxxxxxxxxxx', 'xxxxxxxxxx', 'xxxxxxxx@gmail.com', '3174885954', 'Urb villa liliana', 'Armenia', 'Colombia', 1, '2025-11-18 04:14:12', '2025-11-18 04:14:12', NULL),
(13, 27, 'wwwww', '46646546', 'wwwww@gmail.com', '3174885954', 'Urb villa liliana', 'Armenia', 'Colombia', 1, '2025-11-18 04:16:56', '2025-11-18 04:16:56', NULL),
(14, 27, 'wwwww', '46646546tttt', 'wwwww@gmail.com', '3174885954', 'Urb villa liliana', 'Armenia', 'Colombia', 1, '2025-11-18 04:17:26', '2025-11-18 04:17:26', NULL),
(15, 27, 'hghh', 'mmmm', 'mmmmmmmmm@gmail.com', '3174885954', 'Urb villa liliana', 'Armenia', 'Colombia', 1, '2025-11-18 04:20:54', '2025-11-18 04:20:54', NULL),
(16, 27, 'kkkkkkkk', 'kkkkkkkkkkkkkk', 'kkkk@gmail.com', '3174885954', 'Urb villa liliana', 'Armenia', 'Colombia', 1, '2025-11-18 04:22:33', '2025-11-18 04:22:33', NULL),
(17, 28, 'MARCEL S.A', 'tttttttttttttttttt', 'ichia@gmail.com', '31754565656', 'Urb villa liliana', 'Piojó', 'Colombia', 1, '2025-11-19 01:30:49', '2025-12-02 23:51:08', NULL),
(18, 27, 'tttttttttttttt', '5564654645', 'ttttttttttttttt@gmail.com', '3174885954', 'Urb villa liliana', 'Armenia', 'Colombia', 1, '2025-11-25 21:24:58', '2025-11-25 21:24:58', NULL),
(19, 27, 'kkkkkkkkkkkkkk', 'kkkkkkkkkkkkkkkkkk', 'kkkkkkkkkkkk@gmail.com', '3174885954', 'Urb villa liliana', 'Armenia', 'Colombia', 1, '2025-11-25 21:25:57', '2025-11-25 21:25:57', NULL),
(20, 28, 'jaiver  A, Ocampo', '4615339-8', 'camiso2@gmail.com', '3174885954', 'Urb villa liliana', 'Armenia', 'Colombia', 1, '2025-11-28 22:59:34', '2025-11-28 22:59:34', NULL),
(21, 28, 'Marcela  V', '461236-9', 'marcelav@gmail.com', '3174885954', 'Urb villa liliana', 'Marmato', 'Colombia', 0, '2025-11-28 23:03:28', '2025-12-02 10:42:08', NULL),
(22, 28, 'carlos restrepo', '4512259-8', 'restrepo@gmail.com', '3174455454', 'Urb villa liliana', 'Armenia', 'Colombia', 0, '2025-12-02 10:39:28', '2025-12-02 10:42:01', NULL),
(23, 28, 'fernando díaz', '54544554-6', 'diaz@gmail.com', '317445455', 'Urb villa liliana', 'la cuspide', 'Argentina', 1, '2025-12-02 10:40:52', '2025-12-02 10:56:50', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sync_logs`
--

CREATE TABLE `sync_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vh_code` varchar(20) NOT NULL,
  `sync_type` varchar(255) NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `synced_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `document_type` varchar(5) DEFAULT NULL,
  `document_number` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `company_id`, `branch_id`, `role_id`, `name`, `email`, `avatar`, `password`, `phone`, `address`, `city`, `department`, `document_type`, `document_number`, `active`, `email_verified_at`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(25, 27, 16, 136, 'jaiver ocampo', 'jaiver3@gmail.com', '/avatars/avatar_0bda6ad0-2b1f-4e92-902f-519a0a64ce70.jpg', '$2y$12$CLU8HpjHh15SpReW.npLwudrYWhJ7a9cutvM6zoko2T8sAL.CDtCG', '3174885954', 'Urb villa liliana', 'Armenia', 'Quindio', 'CC', '461533947415', 1, NULL, NULL, NULL, '2025-11-14 01:38:43', '2025-11-25 21:02:02'),
(26, 27, 16, 139, 'Juan Perez', 'juan@example.com', '/avatars/efd8d9a4-7292-4736-b0e0-27ce865be589.jpg', '$2y$12$L5/hrrmHbXmk90zI30JQ.O3Flmn5/DX7J2PGOmzrRXMqZ.IcIPhoG', '300 1234567', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 'CC', '12345678', 1, NULL, NULL, NULL, '2025-11-14 01:51:51', '2025-11-14 01:51:51'),
(29, 27, 16, 139, 'kkkkkkk', 'fgfgg@example.com', '/avatars/632c098e-e631-40c4-acd6-47d5d288d875.jpeg', '$2y$12$1Z/84Gs9c/29ZA3PHqYf0ex30Z4kTGpoIL/nRIA3IBjNEMJlnPox.', '300 1234567', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 'CC', '12345678', 1, NULL, NULL, NULL, '2025-11-14 03:30:37', '2025-11-15 12:01:37'),
(30, 28, 19, 143, 'marcela Vejarano', 'marcela@example.com', '/avatars/avatar_14096e28-1b48-43bd-8cdc-4db29f084534.jpg', '$2y$12$sk./OLIlD2sOLYJaWEOYe.vMyhvBmRAn8QiPmRKNMsIb51C2gFjI6', '3174885954', 'Urb villa liliana', 'Armenia', 'Quindio', 'CC', '41944605', 1, NULL, NULL, NULL, '2025-11-15 12:04:02', '2025-12-02 08:10:58'),
(31, 28, 19, 146, 'marcelka vejarano user', 'vejarano@example.com', NULL, '$2y$12$5PvsZ1Er0rvMh7iVo0mFLOqCbAOFv4bGBH.MuGVZD9yUmFIsaZE2a', '300 1234567', 'Calle 123 #45-67', 'Bogotá', 'Cundinamarca', 'CC', '12345678', 1, NULL, NULL, NULL, '2025-11-16 00:23:34', '2025-11-29 20:12:55'),
(84, 28, 19, 146, 'xxxxxxxxxxxx', 'xxxxxxx@example.com', NULL, '$2y$12$Q5OB86m9ncLacTV/Pnkd0uTmp3rkfYE91a9Go15cGaAI2YJyxf5dq', '3174885954', 'Urb villa liliana', 'Armenia', 'xxxxxxxxxxxxx', 'xx', '33333333333', 1, NULL, NULL, NULL, '2025-11-18 01:29:22', '2025-11-18 01:29:22'),
(90, 27, 18, 139, 'ttttttttttttttttttt', 'ttttttttttttt@gmail.com', NULL, '$2y$12$rIHPIf5fMszjf51uciSBteAc0OtOlVuK3yHi/zwZaPqJbVSjoSNVq', '3174885954', 'Urb villa liliana', 'Armenia', 'ttrrrrrrrrrrrr', 'CC', '45654645', 1, NULL, NULL, NULL, '2025-11-18 01:39:43', '2025-11-18 01:39:43'),
(91, 27, 18, 136, 'eeeeee', 'pppppppppp@gmail.com', NULL, '$2y$12$ab0Qei6/l7xhNUpn.CaHd.CVDXmzs2Xv6A9m1jixz5MW7wPNz0cyi', '3174885954', 'Urb villa liliana', 'Armenia', 'pppppppppppp', 'CC', '555555555555', 1, NULL, NULL, NULL, '2025-11-18 01:54:08', '2025-11-18 01:54:08'),
(92, 28, 22, 146, 'hhhhh', 'marcelauu@example.com', NULL, '$2y$12$.b/OegMjA8v9qUZRARHOee9Xak1/N4OSmINXlLyyQXvOKCR0XpI32', '3174885954', 'Urb villa liliana', 'Armenia', 'lllll', 'CC', '5654554545', 1, NULL, NULL, NULL, '2025-11-18 03:36:50', '2025-11-18 03:36:50'),
(93, 27, 16, 139, 'tttttttttjaiver3@gmail.com', 'fffffff@gmail.com', NULL, '$2y$12$D1jkJc4I0HhINqHBC5Levuj256OQ03edjcQvb3BHBgUhXgvrdFTdS', '3174885954', 'Urb villa liliana', 'Armenia', 'ffffffff', 'CC', '45698998', 1, NULL, NULL, NULL, '2025-11-18 04:15:20', '2025-11-18 04:15:20'),
(94, 28, 19, 144, 'Sofia Vejarano', 'lllllllllllll@example.com', '/avatars/3e40bb36-5c21-4b45-9c2f-27dd94101e2f.jpg', '$2y$12$RynAog9.De78kuKjEzYD0ObheCJIBahNQ/cx.biVrXTSyWmc.mQse', '3124587987', 'Urb villa liliana', 'Amagá', 'Antioquia', 'CC', '766566565', 1, NULL, NULL, NULL, '2025-11-18 23:25:08', '2025-12-02 08:11:30'),
(95, 27, 16, 137, 'wwwwwwww', 'wwwww@gmail.com', NULL, '$2y$12$F.97FQVSWiC77A5PtWz5IuGTTxxuSd1EdxJTgtunFGlYr/zD13/hy', '3174885954', 'Urb villa liliana', 'Armenia', 'wwwww', 'CC', '454645454', 1, NULL, NULL, NULL, '2025-11-19 01:23:33', '2025-11-19 01:23:33'),
(96, 27, 16, 137, 'gfgfgfg', 'fgfgfgfg@gmail.com', NULL, '$2y$12$b7XySkD3Mk6.H6Qdw/.VB.rMkjeMMnyf8Gira5YV1EeFNhm8PbbaS', '3174885954', 'Urb villa liliana', 'Armenia', 'gfgfgfg', 'CC', '56665545', 1, NULL, NULL, NULL, '2025-11-19 02:44:08', '2025-11-19 02:44:08'),
(97, 27, 16, 138, 'kkkkkkkkkkkkkkk', 'kkkkkkkkkkkkk@gmail.com', '/avatars/579c3388-2418-4661-88a9-4a7c1822184f.jpg', '$2y$12$8b04WGKKtYoimtiqmGiXUeniaOvAxoEJKVaMsuYxSGwFm0FBPWTKC', '3174885954', 'Urb villa liliana', 'Armenia', 'kkkkkkkkkkkkkkk', 'CC', '2222222222', 1, NULL, NULL, NULL, '2025-11-25 21:32:39', '2025-11-25 21:32:39'),
(98, 28, 19, 145, 'alba rumeral', 'tytyt@example.com', '/avatars/bbe1bfca-2432-4a3a-8331-a0a0d0603e84.jpeg', '$2y$12$YYXrWgH1sSxpBqDvtlk9MexKD2ECrkwEVPC7LSp0c7OgINFix3UnC', '3174885954', 'Urb villa liliana', 'Leticia', 'Amazonas', 'CC', '4554678978', 0, NULL, NULL, NULL, '2025-12-02 06:18:42', '2025-12-02 08:08:59'),
(99, 28, 19, 144, 'Jaiver  Andres  ocampo', 'jaiveroca@example.com', '/avatars/db7acd9e-3c06-4ead-a63e-6cb4c47ba021.jpg', '$2y$12$JbHAju3XyZ4a0UxZLdpQsuMjFjVWW5Xwms8gSDO5LIQeKVE/M6gs.', '31459875980', 'Urb villa liliana', 'Leticia', 'Amazonas', 'CC', '4554545454', 0, NULL, NULL, NULL, '2025-12-02 06:20:00', '2025-12-02 08:08:39'),
(100, 28, 19, 144, 'carlos vejarano', 'vejarano@gmail.com', '/avatars/a6ed6311-91ad-4efc-92c7-df6990b0a088.jpeg', '$2y$12$Ykrh4S0tm3Ek1VnUua6hHuFM02kzJG4kL6bmdk8JjWzOkcCugcEQW', '325615254', 'Carrera 18 #1054', 'Puerto Nariño', 'Amazonas', 'CC', '125478965', 1, NULL, NULL, NULL, '2025-12-02 08:13:22', '2025-12-02 08:13:38'),
(101, 28, 19, 146, 'teodoro valencia', 'valencia@gmail.com', '/avatars/f58bbb8a-d1c5-44ea-a86e-c910929d04d5.jpg', '$2y$12$Bowhss0j2xUGhQrhhz.XHOsoDTkpHtqVurQ/6GjDEFfje8srBHE6W', '3124587458', 'Urb villa liliana', 'Alejandría', 'Antioquia', 'CC', '12365478', 1, NULL, NULL, NULL, '2025-12-02 08:15:42', '2025-12-02 08:15:42'),
(102, 28, 19, 146, 'juan valderrama', 'valderrama@gmail.com', '/avatars/b59b2874-eccb-4439-b0e8-cda190a4361e.jpg', '$2y$12$AchjA4h2UbrkrZxEyI0R5u7xHIjZM1g5IU8SDBpoxYx.GYo.UelQ.', '3171254879', 'Urb villa liliana', 'Arauca', 'Arauca', 'CC', '109465879', 0, NULL, NULL, NULL, '2025-12-02 08:19:22', '2025-12-02 08:19:22'),
(103, 28, 19, 146, 'edwin ramos', 'ramos@gmail.com', '/avatars/0c49c577-7d37-4341-9b5a-bd76be84677a.jpg', '$2y$12$r.OjG5wOYFeXzfqM6Fmnwuq7PSTAdgIjEVNBfk7Y/aJhJAMu73xFq', '3174445784', 'Urb villa liliana', 'Leticia', 'Amazonas', 'CC', '109465987', 0, NULL, NULL, NULL, '2025-12-02 08:22:00', '2025-12-02 08:22:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accounts_receivables`
--
ALTER TABLE `accounts_receivables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accounts_receivables_branch_id_foreign` (`branch_id`),
  ADD KEY `accounts_receivables_sale_id_foreign` (`sale_id`),
  ADD KEY `accounts_receivables_payment_provider_id_foreign` (`payment_provider_id`),
  ADD KEY `accounts_receivables_client_id_foreign` (`client_id`),
  ADD KEY `accounts_receivables_company_id_branch_id_status_index` (`company_id`,`branch_id`,`status`);

--
-- Indices de la tabla `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_code_unique` (`code`),
  ADD KEY `branches_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_company_id_foreign` (`company_id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_company_email_unique` (`company_id`,`email`),
  ADD UNIQUE KEY `clients_company_document_unique` (`company_id`,`document_number`),
  ADD KEY `clients_branch_id_foreign` (`branch_id`);

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_vh_code_unique` (`vh_code`),
  ADD UNIQUE KEY `companies_document_number_unique` (`document_number`);

--
-- Indices de la tabla `documents_clients`
--
ALTER TABLE `documents_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_clients_company_id_foreign` (`company_id`),
  ADD KEY `documents_clients_branch_id_foreign` (`branch_id`),
  ADD KEY `documents_clients_user_id_foreign` (`user_id`),
  ADD KEY `documents_clients_client_id_foreign` (`client_id`),
  ADD KEY `documents_clients_image_id_foreign` (`image_id`(768));

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `image_documents_clients`
--
ALTER TABLE `image_documents_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image_documents_clients_company_id_foreign` (`company_id`),
  ADD KEY `image_documents_clients_client_id_foreign` (`client_id`);

--
-- Indices de la tabla `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventories_sku_unique` (`sku`),
  ADD KEY `inventories_company_id_foreign` (`company_id`),
  ADD KEY `inventories_branch_id_foreign` (`branch_id`),
  ADD KEY `inventories_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `payment_providers`
--
ALTER TABLE `payment_providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_providers_branch_id_name_unique` (`branch_id`,`name`),
  ADD UNIQUE KEY `payment_providers_branch_id_code_unique` (`branch_id`,`code`),
  ADD KEY `payment_providers_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_unique` (`code`),
  ADD KEY `products_company_id_foreign` (`company_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_invoice_number_unique` (`invoice_number`),
  ADD KEY `sales_company_id_foreign` (`company_id`),
  ADD KEY `sales_branch_id_foreign` (`branch_id`),
  ADD KEY `sales_user_id_foreign` (`user_id`),
  ADD KEY `sales_client_id_foreign` (`client_id`),
  ADD KEY `sales_document_id_foreign` (`document_id`);

--
-- Indices de la tabla `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_items_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_items_inventory_id_foreign` (`inventory_id`),
  ADD KEY `sale_items_payment_provider_id_foreign` (`payment_provider_id`);

--
-- Indices de la tabla `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_company_id_foreign` (`company_id`);

--
-- Indices de la tabla `sync_logs`
--
ALTER TABLE `sync_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sync_logs_company_id_foreign` (`company_id`),
  ADD KEY `sync_logs_branch_id_foreign` (`branch_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accounts_receivables`
--
ALTER TABLE `accounts_receivables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `documents_clients`
--
ALTER TABLE `documents_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `image_documents_clients`
--
ALTER TABLE `image_documents_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT de la tabla `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `payment_providers`
--
ALTER TABLE `payment_providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=766;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT de la tabla `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT de la tabla `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `sync_logs`
--
ALTER TABLE `sync_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accounts_receivables`
--
ALTER TABLE `accounts_receivables`
  ADD CONSTRAINT `accounts_receivables_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accounts_receivables_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `accounts_receivables_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `accounts_receivables_payment_provider_id_foreign` FOREIGN KEY (`payment_provider_id`) REFERENCES `payment_providers` (`id`),
  ADD CONSTRAINT `accounts_receivables_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `clients_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `documents_clients`
--
ALTER TABLE `documents_clients`
  ADD CONSTRAINT `documents_clients_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_clients_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_clients_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `image_documents_clients`
--
ALTER TABLE `image_documents_clients`
  ADD CONSTRAINT `image_documents_clients_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `image_documents_clients_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `payment_providers`
--
ALTER TABLE `payment_providers`
  ADD CONSTRAINT `payment_providers_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_providers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents_clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_payment_provider_id_foreign` FOREIGN KEY (`payment_provider_id`) REFERENCES `payment_providers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sync_logs`
--
ALTER TABLE `sync_logs`
  ADD CONSTRAINT `sync_logs_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sync_logs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
