-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2021 at 08:03 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_supp`
--

-- --------------------------------------------------------

--
-- Table structure for table `com_mstr`
--

CREATE TABLE `com_mstr` (
  `com_code` varchar(10) NOT NULL,
  `com_name` varchar(100) NOT NULL,
  `com_desc` varchar(255) NOT NULL,
  `com_img` varchar(255) NOT NULL,
  `com_last_sync` datetime DEFAULT NULL,
  `com_email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `com_mstr`
--

INSERT INTO `com_mstr` (`com_code`, `com_name`, `com_desc`, `com_img`, `com_last_sync`, `com_email`) VALUES
('PTMMII', 'PT. Multi Makmur Indah Industri', '', '', '2021-06-16 12:45:53', 'andrew@ptimi.co.id');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_konversi`
--

CREATE TABLE `item_konversi` (
  `id` int(11) NOT NULL,
  `item_code` varchar(24) NOT NULL,
  `um_1` varchar(5) NOT NULL,
  `um_2` varchar(5) NOT NULL,
  `qty_item` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_konversi`
--

INSERT INTO `item_konversi` (`id`, `item_code`, `um_1`, `um_2`, `qty_item`, `created_at`, `updated_at`) VALUES
(1513, '141020021', 'BT', 'CB', '50.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1514, '141020251', 'CB', 'DS', '12.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1515, '', 'CI', 'CF', '1728.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1516, '123', 'CI', 'CF', '1.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1517, '141020981', 'DS', 'BX', '80.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1518, '', 'EA', 'BX', '10.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1519, '', 'EA', 'PL', '100.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1520, '', 'EA', 'RL', '25000.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1521, '90040', 'EA', 'RL', '25000.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1522, '', 'G', 'KG', '1000.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1523, '', 'G', 'LB', '453.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1524, '', 'G', 'OZ', '28.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1525, '', 'GA', 'FO', '0.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1526, '', 'GA', 'L', '0.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1527, '', 'GA', 'ML', '0.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1528, '', 'GA', 'PT', '0.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1529, '', 'GA', 'QT', '0.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1530, '', 'HL', 'L', '0.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1531, '', 'KG', 'T', '1000.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1532, '', 'L', 'FO', '0.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1533, '', 'L', 'GA', '3.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1534, '', 'L', 'HL', '100.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1535, '', 'L', 'ML', '0.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1536, '', 'L', 'PT', '0.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1537, '', 'L', 'QT', '0.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1538, '', 'LB', 'KG', '2.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1539, '', 'LB', 'OZ', '0.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1540, '', 'ML', 'FO', '29.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1541, '', 'ML', 'GA', '3785.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1542, '', 'ML', 'L', '1000.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1543, '', 'ML', 'PT', '473.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1544, '', 'ML', 'QT', '946.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1545, '', 'OZ', 'KG', '35.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1546, '141020181', 'PC', 'CB', '480.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1547, '141040991', 'SC', 'CB', '960.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03'),
(1548, '', 'T', 'KG', '0.00', '2021-01-21 16:53:03', '2021-01-21 16:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `item_um`
--

CREATE TABLE `item_um` (
  `id` int(11) NOT NULL,
  `um` varchar(5) NOT NULL,
  `um_desc` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_um`
--

INSERT INTO `item_um` (`id`, `um`, `um_desc`, `created_at`, `updated_at`) VALUES
(23, 'BX', 'Box', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(24, 'CM', 'Cubic Meter', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(25, 'CS', 'Case of 24', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(26, 'EA', 'Each', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(27, 'FO', 'Fluid Ounce', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(28, 'G', 'Gram', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(29, 'GA', 'Gallon', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(30, 'H', 'Hectoliter', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(31, 'HL', 'Hectoliter', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(32, 'KG', 'Kilogram', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(33, 'L', 'Liter', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(34, 'LB', 'Pound', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(35, 'M', 'Meter', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(36, 'ML', 'Mililiter', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(37, 'OZ', 'Ounce', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(38, 'PL', 'Pallet', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(39, 'PT', 'Pint', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(40, 'QT', 'Quart', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(41, 'RL', 'Reel', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(42, 'SH', 'Shipper Box', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(43, 'SP', 'Spool', '2021-01-21 14:04:17', '2021-01-21 14:04:17'),
(44, 'T', 'Ton', '2021-01-21 14:04:17', '2021-01-21 14:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2021_01_12_094235_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('061a8efa-7d46-43e4-9a03-b61911f60f71', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RCP8\",\"note\":\"Please check\"}', NULL, '2021-01-22 06:40:59', '2021-01-22 06:40:59'),
('061a8efa-7d46-43e4-9a03-b61911f60f73', 'App\\Notifications\\eventNotification', 'App\\User', 12, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfqapprove\",\"nbr\":\"RP000063\",\"note\":\"Please check\"}', NULL, '2021-01-22 06:40:59', '2021-01-22 06:40:59'),
('061a8efa-7d46-43e4-9a03-b61911f60f74', 'App\\Notifications\\eventNotification', 'App\\User', 12, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfqapprove\",\"nbr\":\"RP000073\",\"note\":\"Please check\"}', NULL, '2021-01-22 06:40:59', '2021-01-22 06:40:59'),
('6486d538-5f5f-4460-b32c-7902113eb40f', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is a PO awaiting your approval\",\"url\":\"poappbrowse\",\"nbr\":\"testpo\",\"note\":\"Please check\"}', NULL, '2021-06-16 05:45:57', '2021-06-16 05:45:57'),
('722245c4-00a9-47e7-9e0a-d63439866d11', 'App\\Notifications\\eventNotification', 'App\\User', 45, '{\"data\":\"There is a PO awaiting your approval\",\"url\":\"poappbrowse\",\"nbr\":\"testpo\",\"note\":\"Please check\"}', NULL, '2021-06-16 05:45:57', '2021-06-16 05:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0bd3e4d4acf4ec58402193e82c2e182685d018d05918eec3372e9ea0c3f0c8a3db1a6b45c39d5cc0', 4, 1, 'nApp', '[]', 0, '2021-04-20 03:23:05', '2021-04-20 03:23:05', '2022-04-20 10:23:05'),
('1fa9df59cd52d3f3020e17a590fda6ba25790bc703587f1a75cf5adb9dba0112ecea18b715bab683', 4, 1, 'nApp', '[]', 0, '2021-04-16 03:44:14', '2021-04-16 03:44:14', '2022-04-16 10:44:14'),
('21e5291ca4761662fbc5b66725f5c4b6fc1323653fb87f3f32bd83a03c8e1ed6fa5437eb9f2eb82a', 4, 1, 'nApp', '[]', 0, '2021-04-21 08:50:38', '2021-04-21 08:50:38', '2022-04-21 15:50:38'),
('2a7c232bb5d86f1728ed863f370f7e9901094afae5bfdc838b078d579127f15610d2ae9f173e703a', 4, 1, 'nApp', '[]', 0, '2021-04-15 07:44:48', '2021-04-15 07:44:48', '2022-04-15 14:44:48'),
('3797ce9fdae3bff6761f81665c17ab28ca8dd16cac1c7f15a7ff535915a3f0ad83250cae9d2784fc', 4, 1, NULL, '[]', 0, '2021-04-15 07:39:25', '2021-04-15 07:39:25', '2022-04-15 14:39:25'),
('3b8ad268805ff7d0f3816712b2f340af510c9ce7387f5e4bae208cf776601510c365af8fefaea962', 4, 1, 'nApp', '[]', 0, '2021-04-16 03:40:27', '2021-04-16 03:40:27', '2022-04-16 10:40:27'),
('3ffd7dd21f80faf0c4b7de2d0d0fc46dcd59cab260a16f08d59d04666dc8ba11261d717a65d0e383', 4, 1, 'nApp', '[]', 0, '2021-04-15 07:47:33', '2021-04-15 07:47:33', '2022-04-15 14:47:33'),
('571b0494a15c3fba0816ccc32cd9a216184dc16281b82dcf711cb3def4f066ff8343b7466503a9a6', 4, 1, 'nApp', '[]', 0, '2021-04-15 07:46:25', '2021-04-15 07:46:25', '2022-04-15 14:46:25'),
('67d0efa17c40b87c4c87630b2f6e5522d92a9ac447cd257ef72bfe712a2dad6e63cff3dad36b18a5', 4, 1, 'nApp', '[]', 0, '2021-04-15 07:48:28', '2021-04-15 07:48:28', '2022-04-15 14:48:28'),
('7c2e77ad376ebabf148ee4954c8a20df9e6618a09eee9561701c3d3cc8a03d7745545f3cf63ef435', 4, 1, 'nApp', '[]', 0, '2021-04-15 07:47:09', '2021-04-15 07:47:09', '2022-04-15 14:47:09'),
('97e168c77beddac1651598cd5d1d806397797de0c996aa180d3f2ac6b7e8b93a1924807dcb943728', 4, 1, 'nApp', '[]', 0, '2021-04-21 08:47:23', '2021-04-21 08:47:23', '2022-04-21 15:47:23'),
('9f9b9d41c0b93d9b221259683da0dd27a8a8981cf41ae92275424656a27ad2e47b1fa5953d02543f', 4, 1, 'nApp', '[]', 0, '2021-04-15 07:48:30', '2021-04-15 07:48:30', '2022-04-15 14:48:30'),
('f628905fb6b90562924f5a30b18a4aa73610af9fd723ceaa7319828e88076867c948d5890fe3192a', 4, 1, 'nApp', '[]', 0, '2021-04-16 03:44:38', '2021-04-16 03:44:38', '2022-04-16 10:44:38');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'CJkKSCWelP4sTErDkcgSGE3yMMK02G0tQmHm7vz1', 'http://localhost', 1, 0, 0, '2021-04-15 07:19:27', '2021-04-15 07:19:27'),
(2, NULL, 'Laravel Password Grant Client', 'PN8PqnmTiHtPkotJiTS9Kzk14jmO2x2ycsPAif1F', 'http://localhost', 0, 1, 0, '2021-04-15 07:19:27', '2021-04-15 07:19:27');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-04-15 07:19:27', '2021-04-15 07:19:27');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supp_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `supp_id`, `supp_name`, `email`, `domain`, `role`, `role_type`, `department`, `flag`, `active`, `email_verified_at`, `password`, `session_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'Andrew Conan', 'admin', NULL, NULL, 'andi@ptimi.co.id', 'IMI', 'Admin', 'Admin', 'PT', NULL, 'yes', NULL, '$2y$10$rK5rJAMLHz/C9yCdGSjWNunayvQoEu5bw6HsUDrAKijYqAkSKrFha', 's6XavqBnIta1LhQxTZIvpLGRRK7StvN5cDIuDlaY', NULL, '2020-03-16 16:39:35', '2021-06-16 05:08:01'),
(5, 'Stanley Shu', 'supplier1', '10S1003', 'Heron Surgical Supply', 'stanleyshu01@yahoo.com', 'IMI', 'Supplier', 'SPV Supplier', '', NULL, 'yes', NULL, '$2y$10$C.pc7bcC1d71wuDNY3T/fOx7fyUgm8ZYszNWGIq7qR9cLAoVqT4He', 'ctfKe9yJvvJ3GUS41UY1cj1Bg4Qwvd8nQhQjN7aV', NULL, NULL, '2020-07-14 16:42:12'),
(38, 'Elly', 'Elly', '10S1003', 'Heron Surgical Supply', 'stanleyshu02@yahoo.com', '10USA', 'Supplier', 'SPV Supplier', '', NULL, 'yes', NULL, '$2y$10$e909wQrkyTrMf53HNRmovu6qjH5zQJi1McuVl1zlitP5H1xT2pl/K', 'ojRaVt3yF9wf3RwERsniELoechexJMsf62tAMIN4', NULL, NULL, '2021-04-29 07:18:47'),
(43, 'Rio', 'rio', '10S1004', 'Sungro Chemicals', 'stanleyshu03@yahoo.com', '10USA', 'Supplier', 'SPV Supplier', '', NULL, 'yes', NULL, '$2y$10$fKGRL6ZASIN.7O.N2dOzAOU.u7/lhok9NXik49qIr6Y8brVdOqjxS', 'qKmIKNHi2gSr9vVD9tngukqBBXT9wjbSKd8f0kjq', NULL, NULL, '2021-01-25 01:00:41'),
(44, 'Andrew', 'andrew', '10S1005', 'Absolute Electronics Company', 'stanleyshu04@yahoo.com', '10USA', 'Supplier', 'SPV Supplier', '', NULL, 'yes', NULL, '$2y$10$4dt6IjU/QXfwPfsRdSWZKewL5ifDYpXV1HKOO8iOAuF43Ip2NHgXa', '2vxaD2YXi4TZqcGronikHiOIYF0FKyjaDLpHYIN6', NULL, NULL, '2020-08-25 00:46:51'),
(45, 'Bintang', 'Bintang', NULL, NULL, 'stanleyshu05@yahoo.com', '10USA', 'Purchasing', 'Purchasing', 'R&D', NULL, 'yes', NULL, '$2y$10$epmrKpt8CX5aAbz6Zi5noOmEg586pT4NzsssncXjfFu3AdtikDRp.', 'xVOshAqolBFoMxGNDDQ4YSg1YZ5A7pXT3ABZjnVC', NULL, NULL, '2021-01-21 04:24:50'),
(46, 'Ray', 'Ray', NULL, NULL, 'stanleyshu06@gmail.com', '10USA', 'Purchasing', 'Admin Purchasing', 'R&D', NULL, 'yes', NULL, '$2y$10$Ld5jiuT5XCofZGU9hwz/Auz8L89dzK8Nwio//Y/0NQ6bL7AjJbjeS', 'yrBv8BffGhTgVNAtlH6apf84AVjDykIpt7swzmc2', NULL, NULL, '2021-01-21 04:27:21'),
(47, 'Rifky', 'Rifky', NULL, NULL, 'rifky@ptimi.co.id', '10USA', 'Purchasing', 'Mgr IT', 'IT', NULL, 'yes', NULL, '$2y$10$XkN9KhzLjWzMPW85q4rps.IAsOycGxtaSvQZVj17VGFt8xH652ljy', '7oHB0Q5hflUrCiGATfAuIoiukdioFgigKdvzqQ6L', NULL, NULL, '2021-01-15 01:27:38'),
(48, 'ST', 'Admin1', NULL, NULL, 'stanley@ptimi.co.id', '10USA', 'Admin', 'Admin', 'PT', NULL, 'yes', NULL, '$2y$10$4YfPtyGkjd8zSigxs5Cm8.kd4m/8DHsi0O3xjLakDs17BTUihfyPe', 'zDg1Lv0vcUE0rUtx43YYWxsavgUQYQXMrj3ZzmKY', NULL, NULL, '2020-07-29 13:43:29'),
(49, 'Alung card', 'Alung', '10-200', 'QMI -USA Division', 'rio@ptimi.co.id', '10USA', 'Supplier', 'SPV Supplier', '', NULL, 'yes', NULL, '$2y$10$yHi22KjF5isNygBoeb8n6.aAhxhbYCteGMsIVeFCk73slk1XZliQm', 'CTmvkAsoCHPDuRwtJvzVrGIHAP102LJyL89RBCYT', NULL, NULL, '2020-07-29 16:36:08'),
(50, 'Dani', 'Dani', NULL, NULL, 'dany@ptimi.co.id', '10USA', 'Purchasing', 'Mgr IT', 'IT', NULL, 'yes', NULL, '$2y$10$C91nPXCtG9Li33RbGUN0wexLvzRG2BKx7Cnf0DbcV2Q4V85ARoWsa', 'dmht2RifVJPFM117BeMgW6ozI6tmw1h3BdZhsmJt', NULL, NULL, '2020-11-10 22:51:11'),
(51, 'mfg', 'mfg', NULL, NULL, 'dray@gmail.com', '10USA', 'Admin', 'Admin', '', NULL, 'yes', NULL, '$2y$10$mhskWZ41gBBhHvCaF7zM1.hXK2cDe8XjLwrshcGul4.2oCsZXPebW', 'Bx4OX5mgJUlW02klRt3zDELfZyH7YmGxejLC2XmS', NULL, NULL, '2021-04-21 08:42:11'),
(52, 'Indah Sari', 'admin2', NULL, NULL, 'aziz@ptimi.co.id', '10USA', 'Admin', 'Admin', 'IT', NULL, 'yes', NULL, '$2y$10$rroqzITZaaGpLe1Em67Nwe2/V3Uir8eiJDR4ljkw4BLBj53wr3ASm', 'lsNl6XFkYSKyJBC211DLjdyXNFXZ05pSAq39XBpX', NULL, NULL, '2021-01-25 20:38:24'),
(53, 'Tasia', 'AY', NULL, NULL, 'tasia@ptimi.co.id', '10USA', 'Admin', 'Admin', '', NULL, 'yes', NULL, '$2y$10$Njn/sfBm.S6f1XdfJ2nT1u/iuNeg8b.Varo6yXMsOA84mHbgMQ4Ja', 'Uzxd4QBNqeIQUyvrU5csNSdSiqbPETT4e2cvcovp', NULL, NULL, '2021-01-19 22:04:07'),
(54, 'Andrew', 'admin3', NULL, NULL, 'andrew_conan1987@yahoo.com', '10USA', 'Admin', 'Admin', '', NULL, 'yes', NULL, '$2y$10$D8IGOqnllBaFxaMZCTLf3.eCNWBCrp0AD16mFkxwVo1fHtXFsEnoG', 'cCBhwN0SVeMuScxMN0a9NBY31eggSTJSABuPvzQI', NULL, NULL, '2020-08-02 14:06:25'),
(55, 'Faisal', 'sal', NULL, NULL, 'faisal@ptimi.co.id', '10USA', 'Admin', 'Admin', '', NULL, 'yes', NULL, '$2y$10$WaG133IKeLOqJ8L9CiZoFeFbyAHEVj9nDWNOTFCpGgj58E5Dk2y0y', 'JIbQ9sELYbNDNcPKuD2o6yZO9xD4G3Z7QFrF7ok2', NULL, NULL, '2020-08-02 12:14:36'),
(56, 'Shultan lei', 'shu', '10-300', 'QMI -USA Division', 'shultan@ptimi.co.id', '10USA', 'Supplier', 'SPV Supplier', 'PT', NULL, 'yes', NULL, '$2y$10$tLhnQ4wdznvb8zdjwUfxNuNL15nn6nRDVzzSus7W4YRWRwr.NhUhC', NULL, NULL, NULL, NULL),
(57, 'alex', 'alex', NULL, NULL, 'axel@ptimi.co.id', '10USA', 'Admin', 'Admin', '', NULL, 'yes', NULL, '$2y$10$4LeWJNwUOrvWxhxpU2bAz.Gj/SQwvwsFxMXN8WF/DJ/1r6wUHu8ce', NULL, NULL, NULL, NULL),
(58, 'Vieren Yulies', 'Vieren', NULL, NULL, 'vieren@yahoo.com', '10USA', 'Purchasing', 'Purchasing', '', NULL, 'yes', NULL, '$2y$10$piChGwdOjHsU0WuQJC5goufUsZooqco8KHxbukABpLqcW0ghCMK9W', NULL, NULL, NULL, NULL),
(59, 'Tommy', 'admin100', NULL, NULL, 'tommy@ptimi.co.id', '10USA', 'Purchasing', 'Admin Purchasing', '', NULL, 'no', NULL, '$2y$10$S132zuwJKx2tdDujf3wiquU0TRRip6EevvSu/rYmAPpDQ7EksnN8K', 'cCzQlKuGSKmTTzl7Us2oWhscZxWyLS48blwOc4pV', NULL, NULL, '2020-10-05 00:50:35'),
(60, 'Tommy Wicaksono', 'adm1', NULL, NULL, 'tommy1@ptimi.co.id', '10USA', 'Admin', 'Admin02', 'R&D', NULL, 'yes', NULL, '$2y$10$3RqowJdBl.1De1zQ1635n.HVAvEnxWollcRiiBjmJcHgDrgwjF/re', 'BZpH3jrGyWrWjPwgbYe3Uf4LRic3u0wV4wOy1RP8', NULL, NULL, '2021-01-21 18:45:40'),
(61, 'devtest1', 'user1', NULL, NULL, 'devtest1@gmail.com', '10USA', 'Purchasing', 'Admin Purchasing', 'R&D', NULL, 'yes', NULL, '$2y$10$MjiTFtohDhZQHvmgrY3qnuqWAOqDsKetvOsZ1Oj2MTwfkASTdkdiG', NULL, NULL, NULL, NULL),
(62, 'test1', 'test1', NULL, NULL, 'test123@yhoo.com', '10USA', 'Purchasing', 'Purchasing', 'R&D', NULL, 'yes', NULL, '$2y$10$rVgEYKQQbKbnK.RLSqndC.odQHE.piiIn/fl8GcIhC1Dd8k5Kqgla', 'GVVwh8hqUh9xkanohIgeLVFqJsaA0wt7RBKOvd4R', NULL, NULL, '2021-01-20 23:58:01'),
(63, 'test2', 'test2', NULL, NULL, 'test321@yahoo.com', '10USA', 'Purchasing', 'Admin Purchasing', 'R&D', NULL, 'yes', NULL, '$2y$10$Jk8VFJZxu8SMZ1MWTagxquvfxUQsOICORa2Vvz82JhXy/E3ftHwFm', 's92atfPcc6H9ip3WE3YuIsNOCQaHeOIrwd4pnDi2', NULL, NULL, '2021-01-20 23:56:58'),
(64, 'reee2', 'test3', NULL, NULL, 'aduadu@ddd.com', '10USA', 'Purchasing', 'Mgr IT', 'IT', NULL, 'yes', NULL, '$2y$10$0VjwjOGkyWbu/Dhj5mGY/uYQAUhq/z4oiih10DNRaK0nO4.aPdnly', 'x91KHeh9U31Rt69ECmBRMCcc7Xu8bAZbgtk51TrM', NULL, NULL, '2020-10-21 21:54:04'),
(65, 'reeee5', 'test4', NULL, NULL, '13131hhe@dadwla.com', '10USA', 'Purchasing', 'Purchasing', 'KEU', NULL, 'yes', NULL, '$2y$10$RQ8gIm1e9DbcxnR3wOL8DOXP1noyLtykR9Ldyg04zWDHbvI3C5FEm', NULL, NULL, NULL, NULL),
(66, 'ray', 'testes', '10S1001', 'Taylor & Fulton Fruit Co.', 'ray@ptimi.co.id', '10USA', 'Supplier', 'SPV Supplier', NULL, NULL, 'yes', NULL, '$2y$10$xtkxz3.lWCMvZJ/F1KEaH.PmHAHnkFKwa0Cj0ggeElkJyRFxUsz.a', NULL, NULL, NULL, NULL),
(67, 'ivander luckson', 'ivander', NULL, NULL, 'ivan@ptimi.com', '10USA', 'Purchasing', 'Spv Purchasing', 'PT', NULL, 'yes', NULL, '$2y$10$66p2yGmBhZmDJKBC4qisL.aJZ/1WlqwYZ.cIjMxjEmRKZHJz/jIsG', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wsas`
--

CREATE TABLE `wsas` (
  `id` int(11) NOT NULL,
  `wsas_url` varchar(255) NOT NULL,
  `wsas_domain` varchar(255) NOT NULL,
  `wsas_path` varchar(255) NOT NULL,
  `qx_enable` int(11) NOT NULL,
  `qx_url` varchar(255) DEFAULT NULL,
  `qx_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wsas`
--

INSERT INTO `wsas` (`id`, `wsas_url`, `wsas_domain`, `wsas_path`, `qx_enable`, `qx_url`, `qx_path`) VALUES
(1, 'http://qad2017vm.ware:22079/wsa/wsatest', '10USA', 'urn:iris.co.id:wsatest', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xalertitem_mstrs`
--

CREATE TABLE `xalertitem_mstrs` (
  `xalertitem_id` int(11) NOT NULL,
  `xalertitem_code` varchar(100) DEFAULT NULL,
  `xalertitem_type` varchar(100) NOT NULL,
  `xalertitem_group` varchar(100) NOT NULL,
  `xalertitem_supp` varchar(100) NOT NULL,
  `xalertitem_day1` varchar(100) DEFAULT NULL,
  `xalertitem_day2` varchar(100) DEFAULT NULL,
  `xalertitem_day3` varchar(100) DEFAULT NULL,
  `xalertitem_email1` varchar(100) DEFAULT NULL,
  `xalertitem_email2` varchar(100) DEFAULT NULL,
  `xalertitem_email3` varchar(100) DEFAULT NULL,
  `xalertitem_sfty_stock` varchar(100) DEFAULT NULL,
  `xalertitem_active` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xalertitem_mstrs`
--

INSERT INTO `xalertitem_mstrs` (`xalertitem_id`, `xalertitem_code`, `xalertitem_type`, `xalertitem_group`, `xalertitem_supp`, `xalertitem_day1`, `xalertitem_day2`, `xalertitem_day3`, `xalertitem_email1`, `xalertitem_email2`, `xalertitem_email3`, `xalertitem_sfty_stock`, `xalertitem_active`) VALUES
(1, 'C0032', 'Type 13', 'Group 25', 'Andrew', '15', '23', '44', 'andrew@ptimi.co.id', 'ray@ptimi.co.id', 'dani@ptimi.co.id', '12', '10'),
(2, NULL, 'ASSY', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '10', '10');

-- --------------------------------------------------------

--
-- Table structure for table `xalert_mstrs`
--

CREATE TABLE `xalert_mstrs` (
  `xalert_id` bigint(20) NOT NULL,
  `xalert_active` varchar(5) NOT NULL,
  `xalert_supp` varchar(50) NOT NULL,
  `xalert_nama` varchar(50) DEFAULT NULL,
  `xalert_alamat` varchar(255) DEFAULT NULL,
  `xalert_po_app` varchar(5) NOT NULL DEFAULT 'No',
  `xalert_day1` varchar(100) DEFAULT NULL,
  `xalert_day2` varchar(100) DEFAULT NULL,
  `xalert_day3` varchar(100) DEFAULT NULL,
  `xalert_day4` varchar(100) DEFAULT NULL,
  `xalert_day5` varchar(100) DEFAULT NULL,
  `xalert_email1` varchar(100) DEFAULT NULL,
  `xalert_email2` varchar(100) DEFAULT NULL,
  `xalert_email3` varchar(100) DEFAULT NULL,
  `xalert_email4` varchar(100) DEFAULT NULL,
  `xalert_email5` varchar(100) DEFAULT NULL,
  `xalert_idle_days` varchar(100) DEFAULT NULL,
  `xalert_idle_emails` varchar(100) DEFAULT NULL,
  `xalert_not_pur` varchar(100) DEFAULT NULL,
  `xalert_phone` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xalert_mstrs`
--

INSERT INTO `xalert_mstrs` (`xalert_id`, `xalert_active`, `xalert_supp`, `xalert_nama`, `xalert_alamat`, `xalert_po_app`, `xalert_day1`, `xalert_day2`, `xalert_day3`, `xalert_day4`, `xalert_day5`, `xalert_email1`, `xalert_email2`, `xalert_email3`, `xalert_email4`, `xalert_email5`, `xalert_idle_days`, `xalert_idle_emails`, `xalert_not_pur`, `xalert_phone`) VALUES
(1, 'Yes', '', 'Bridgeville Industries', '3390 Linco Road ', 'Yes', '10', '30', NULL, '50', NULL, '10', '30', NULL, '50', NULL, '20', 'ray123@ptimi.co.id,andrew@ptimi.co.id', 'dani123@ptimi.co.id', NULL),
(2, 'Yes', '10S1003', 'Heron Surgical Supply', '30 89th Avenue ', 'Yes', '5', '4', '3', '2', '1', 'stanleyshu01@yahoo.com', 'stanleyshu02@yahoo.com', 'stanleyshu03@yahoo.com', 'stanleyshu04@yahoo.com', 'andi@ptimi.co.id', '10', 'stanleyshu01@yahoo.com', 'stanleyshu03@yahoo.com', '+6281289369262'),
(4, 'Yes', '10-200', 'QMI -USA Division', '30 Ridgedale Avenue ', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'stanleyshu06@gmail.com', NULL),
(5, 'Yes', '10-300', 'QMI -USA Division', '30 Ridgedale Avenue ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'stanleyshu01@yahoo.com', NULL),
(6, '', '10L1000', 'Kuehne & Nagel, Inc.', '10 Exchange Place ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '', '10L1001', 'UTi Integrated Logistics', '1640 W. 190th Street ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '', '10L1002', 'Cargo Insurance Co.', '44 Omaha Street ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '', '10PLATSP', 'Plating Subcontractor - USA', '35 Gracie Way ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Yes', '10S1001', 'Taylor & Fulton Fruit Co.', '932 Fifth Avenue ', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'stanleyshu01@yahoo.com,stanleyshu02@yahoo.com,stanleyshu03@yahoo.com,stanleyshu04@yahoo.com,stanleys', NULL),
(11, 'Yes', '10S1004', 'Sungro Chemicals', '810 E. 18th Street ', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'stanleyshu01@yahoo.com', NULL),
(12, '', '10S1005', 'Absolute Electronics Company', '31 Billingsley Drive ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '', '10S1006', 'Hampton Electronics', '17031 Commercial Blvd. ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '', '10S1010', 'Eldon Motor Company', '11 Melanie Lane ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '', '10S1011', 'HTZ Switch Company', '232 W. Clinton Street ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '', '10S1012', 'J&P Metalware Industries', '430 Westfield Avenue W. ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '', '10S2000', 'J. Williams & Company', '123 Washington Avenue ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '', '10S2001', 'Ischinger & Markem', '101 Madison Avenue ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '', '10S2002', 'Lee Sheldon, ESQ', '159 Millburn Avenue ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '', '10S3002', 'Bridgeville Industries', '3390 Linco Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '', '10S3004', 'Sungro Chemicals', '810 E. 18th Street ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '', '10SC1005', 'Rockland Industrial Company', '566 Rockland Boulevard ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '', '10SUBCT', 'Subcontract Supplier - USA', '25 VallyWood Street ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '', '11-300', 'QMI- Canada Division', '500 Singleton Blvd. ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '', '11PLATSP', 'Plating Subcontractor - CAN', '55 Patinaude ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '', '11S1000', 'Chiro Foods Limited', '5041 Gateway Blvd. NW ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '', '11S1001', 'Plastics of Oshawa', '1900 Colonel Sam Drive ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, '', '11S1111', 'Chiro Foods Limited', '5041 Gateway Blvd. NW ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, '', '11SUBCT', 'Subcontract Supplier - CAN', '89 Alain Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, '', '12-100', 'QMI-Mexico Division', 'Poinente 150 No.. 532 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '', '12-300', 'QMI-Mexico Division', 'Poinente 150 No.. 532 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, '', '12PLATSP', 'Plating Subcontractor - MX', '5564 Poinente ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, '', '12S1001', 'Packaging Components Ltd.', 'Jose Ma. Rico No. 418 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, '', '12S1002', 'Mexico City Chemicals', 'Poinente 150 No. 956 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, '', '12S1003', 'Puerto Vallarta Surgical Supplies', 'Avenida Francisco Medina Avenue ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, '', '12SUBCT', 'Subcontract Supplier - MX', '4564 Poinente ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, '', '20-300', 'QMI-France Division', '2 Rue Villaret De Joyeuse ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, '', '20PLATSP', 'Plating Subcontractor - FRA', 'Rue Nicolas Appert ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, '', '20S1001', 'Paris Fruit Products', '2 Rue Vilaret De Joyeuse ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, '', '20S1002', 'Pharmaceutical Chemical Supply', 'Rue Nicolas Appert ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, '', '20S1003', 'Containers Ltd', '20 Rue Gauthey ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, '', '20SUBCT', 'Subcontract Supplier - FR', '362 Rue Nicolas Appert ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, '', '21-300', 'QMI-Netherlands Division', 'De Bolder 30 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, '', '21PLATSP', 'Plating Subcontractor - NL', '99 De Bolder ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, '', '21S1001', 'Power Cord International', 'De Bolder 30 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, '', '21S1002', 'Van es Surgical Supply', 'ljsselkade 20 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, '', '21S1003', 'Babberich Electronics', 'Transito 1 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, '', '21S1004', 'Servizi di Contabilitia Milano SRL', 'Via Carducci, 125/A ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, '', '21S2001', 'Ospedale S. Raffaele', 'Viale Monza ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, '', '21S2002', 'Studi Legali Riuniti', 'Via Pagano ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, '', '21S2003', 'Rafmil-FRA Division', 'Rue 11 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, '', '21S2004', 'Rafmil-ZA Division', '800 Lee Street ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, '', '21SEPASU', '21-SEPA-SU', 'Luchthavenweg ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, '', '21SUBCT', 'Subcontract Supplier - NL', '26 De Bolder ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, '', '22-300', 'QMI-UK Division', '90 Main Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, '', '22PLATSP', 'Plating Subcontractor - UK', '4234 Castle Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, '', '22S1000', 'Auto-Plas International', '90 Main Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, '', '22S1001', 'Cheshire Packaging Products', '120 Mentor Hse ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, '', '22S1002', 'Organic Food Supply', 'Castle Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, '', '22SUBCT', 'Subcontract Supplier - UK', '88 Castle Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, '', '23-300', 'QMI German Division', 'Walther-Cronberg Platz 12 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, '', '23PLATSP', 'Plating Subcontractor - GER', 'Bergstrasse 89 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, '', '23S1000', 'Leiferant A', 'Amselweg 1 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, '', '23S1001', 'BGS Innovation AG', 'Bergstrasse 65 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, '', '23S1002', 'Huber Metalwaren', 'Im Hof 11 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, '', '23SUBCT', 'Subcontract Supplier - GER', 'Calwerstrasse 103 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, '', '30-100', 'QMI-China Division', '953 Hongqiao Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, '', '30-300', 'QMI-China Division', '953 Hongqiao Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, '', '30PLATSP', 'Plating Subcontractor -CN', 'Dong Feng ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, '', '30S1001', 'Xia Electronics', '13 Dong Feng Dong Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, '', '30S1002', 'Tabu Power Cord Co.', '78 Danxia Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, '', '30S1003', 'Tanaka Surgical Ltd', '24 Naycn ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, '', '30S1004', 'Shanghai Chemical Manufacturers', '953 Hongqiao Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, '', '30SUBCT', 'Subcontract Supplier - CN', '8823 Dong Feng ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, '', '31-300', 'QMI-Australia Division', '56 Pitt Street ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, '', '31PLATSP', 'Plating Subcontractor - AU', '45 Pitt Street ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, '', '31S1001', 'Australian Fruit Products', '312 St. Kilda Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, '', '31S1002', 'Sydney Copper Company', 'Market Street 55 ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, '', '31S1003', 'Henderson Industrial', 'Pitt Street ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, '', '31SUBCT', 'Subcontract Supplier - AU', '554 Pitt Street ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, '', '32S1000', 'Benson Motors', '2-1-1 Minami Aoyama, Minato-ku ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, '', '32S1001', 'CAN Enterprises', 'Ota-ku ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, '', '40-300', 'QMI - Brazil Division', 'Rua Domingos de Moraes 2564Brocklin', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, '', '40L1000', 'Transportadora Maua SA', 'Av. Matarazzo 367', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, '', '40PLATSP', 'Plating Subcontractor - BR', 'Rua dos Remedios 999Bairro do Socorro', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, '', '40S1000', 'Lojas Americanas', 'Ave Independencia 3467Santo Amaro', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, '', '40S1001', 'ABC Compomentes Electronicos SA', 'Rua do Sono 456Brooklin', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, '', '40S1002', 'Tintas Coloridas SA', 'Av. Cupece, 1168 1168Jd Prudencia', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(89, '', '40SUBCT', 'Subcontract Supplier - BR', 'Rua Prof. Maria do Carmos 65Federal', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, '', '10S1002', 'Bridgeville Industries', '3390 Linco Road ', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, '', 'ST001', 'LTZ Retail', '702 S.W. 8th Street Waterfront', 'No', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xbid_det`
--

CREATE TABLE `xbid_det` (
  `xbid_det_id` int(11) NOT NULL,
  `xbid_id` varchar(100) NOT NULL,
  `xbid_qty` decimal(10,2) NOT NULL,
  `xbid_date` date NOT NULL,
  `xbid_supp` varchar(50) NOT NULL,
  `xbid_apprv` varchar(50) NOT NULL,
  `xbid_flag` varchar(5) NOT NULL DEFAULT '0',
  `xbid_pro_qty` decimal(10,0) DEFAULT NULL,
  `xbid_pro_date` date DEFAULT NULL,
  `xbid_pro_price` varchar(100) DEFAULT NULL,
  `xbid_pro_remarks` varchar(255) DEFAULT NULL,
  `xbid_pro_attch` varchar(255) DEFAULT NULL,
  `xbid_pur_qty` decimal(10,0) DEFAULT NULL,
  `xbid_pur_date` date DEFAULT NULL,
  `xbid_user` int(11) NOT NULL DEFAULT 0,
  `xbid_no_po` varchar(30) DEFAULT NULL,
  `xbid_send_email` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xbid_det`
--

INSERT INTO `xbid_det` (`xbid_det_id`, `xbid_id`, `xbid_qty`, `xbid_date`, `xbid_supp`, `xbid_apprv`, `xbid_flag`, `xbid_pro_qty`, `xbid_pro_date`, `xbid_pro_price`, `xbid_pro_remarks`, `xbid_pro_attch`, `xbid_pur_qty`, `xbid_pur_date`, `xbid_user`, `xbid_no_po`, `xbid_send_email`) VALUES
(1, 'RF000063', '10.00', '2021-03-09', '10S1004', 'Yes', '1', '10', '2021-03-10', '10000', NULL, '', NULL, NULL, 4, NULL, 0),
(399, 'RF000072', '50.00', '2020-07-31', '10S1004', 'Yes', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(400, 'RF000073', '500.00', '2020-07-31', '10S1004', 'Yes', '2', '450', '2020-07-31', '800000', NULL, 'C:\\xampp\\htdocs\\web_supp\\public\\/upload_supplier/20200730_045136-ITEM 1.PNG', '470', '2020-07-31', 43, 'WP000034', 1),
(401, 'RF000073', '500.00', '2020-07-31', '10S1003', 'Yes', '1', '500', '2020-07-31', '8000000', 'test1', '', NULL, NULL, 38, NULL, 0),
(402, 'RF000074', '1500.00', '2020-08-04', '10S1004', 'Yes', '1', '135000', '2021-01-28', '80000', 'Cheapest price in the town', '', NULL, NULL, 43, NULL, 1),
(403, 'RF000074', '1500.00', '2020-08-04', '10S1003', 'Yes', '1', '100', '2021-04-06', '120000', NULL, '', NULL, NULL, 3, NULL, 1),
(404, 'RF000075', '12.00', '2020-10-12', '10S1004', 'Yes', '2', '10', '2021-01-20', '5000', NULL, '', '10', '2021-01-21', 43, 'WP000135', 1),
(406, 'RF000001', '200.00', '2020-10-16', '10S1005', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(407, 'RF000002', '4000.00', '2020-10-24', '10S1005', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(408, 'RF000003', '10.00', '2020-10-31', '10S1004', 'Yes', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(409, 'RF000003', '10.00', '2020-10-31', '10S1005', 'Yes', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(410, 'RF000004', '313.00', '2020-10-19', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(411, 'RF000005', '12.00', '2020-10-17', '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(412, 'RF000006', '10.00', '2020-10-17', '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(413, 'RF000007', '9.00', '2020-10-23', '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(414, 'RF000007', '9.00', '2020-10-23', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(415, 'RF000008', '8.00', '2020-10-29', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(416, 'RF000009', '819.00', '2020-10-29', '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(417, 'RF000009', '819.00', '2020-10-29', '10S1005', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(418, 'RF000010', '15.00', '2020-10-25', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(419, 'RF000011', '113.00', '2020-10-25', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(420, 'RF000012', '88.00', '2020-10-25', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(421, 'RF000013', '11.00', '2020-10-25', '10S1005', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(422, 'RF000014', '88.00', '2020-10-25', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(423, 'RF000015', '9.00', '2020-10-31', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(424, 'RF000016', '13.00', '2020-10-31', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(425, 'RF000016', '1.00', '2020-10-31', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(426, 'RF000018', '15.00', '2020-10-25', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(427, 'RF000019', '15.00', '2020-10-25', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(428, 'RF000020', '19.00', '2020-10-31', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(429, 'RF000021', '20.00', '2020-10-31', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(430, 'RF000022', '17.00', '2020-11-08', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(431, 'RF000023', '1.00', '2020-11-08', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(432, 'RF000024', '2.00', '2020-11-08', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(433, 'RF000025', '6.00', '2020-10-25', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(434, 'RF000026', '10.00', '2020-10-31', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(435, 'RF000027', '10.00', '2020-11-08', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(436, 'RF000028', '11.00', '2020-10-31', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(437, 'RF000029', '12.00', '2021-01-03', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(438, 'RF000011', '113.00', '2020-10-25', '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(440, 'RF000001', '200.00', '2020-10-16', '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(441, 'RF000030', '15.00', '2020-11-19', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(442, 'RF000031', '13.00', '2021-01-07', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(443, 'RF000032', '97.00', '2020-11-07', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(444, 'RF000033', '45.50', '2020-11-07', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(445, 'RF000034', '90.11', '2020-11-07', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(446, 'RF000035', '99.11', '2021-01-28', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(447, 'RF000036', '15.00', '2020-11-07', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(448, 'RF000037', '297.00', '2020-11-08', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(449, 'RF000038', '3.00', '2027-11-26', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(450, 'RF000039', '61.00', '2022-02-10', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(451, 'RF000040', '95.55', '2020-11-28', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(452, 'RF000041', '15.00', '2020-11-13', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(453, 'RF000042', '25.00', '2020-11-16', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(454, 'RF000043', '11.00', '2020-12-04', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(455, 'RF000044', '6.80', '2021-04-14', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(456, 'RF000045', '79.00', '2020-11-30', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(457, 'RF000046', '70.00', '2020-11-28', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(458, 'RF000047', '11.00', '2020-12-04', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(459, 'RF000048', '1.00', '2020-12-05', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(460, 'RF000049', '2.00', '2021-01-05', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(461, 'RF000050', '1.00', '2020-12-05', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(462, 'RF000051', '2.00', '2021-01-05', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(463, 'RF000052', '25.00', '2020-11-19', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(464, 'RF000053', '30.00', '2020-11-20', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(465, 'RF000054', '1500.00', '2020-11-27', '10S1005', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(466, 'RF000055', '15.00', '2020-11-19', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(467, 'RF000056', '25.00', '2020-11-19', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(468, 'RF000057', '5.00', '2021-01-31', '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(469, 'RF000058', '10.00', '2021-01-14', '10S1003', 'Yes', '1', '10', '2021-01-15', '1000', NULL, '', NULL, NULL, 38, NULL, 1),
(470, 'RF000059', '30.00', '2021-01-21', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(471, 'RF000060', '50.00', '2021-01-20', '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(472, 'RF000060', '50.00', '2021-01-20', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(473, 'RF000061', '100.00', '2021-01-25', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(474, 'RF000062', '300.00', '2021-01-26', '10-300', 'Yes', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(485, 'RF000064', '500.00', '2021-04-22', '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(486, 'RF000064', '500.00', '2021-04-22', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(487, 'RF000065', '2300.00', '2021-04-22', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(488, 'RF000065', '2300.00', '2021-04-22', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(489, 'RF000066', '2300.00', '2021-04-22', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(490, 'RF000066', '2300.00', '2021-04-22', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `xbid_hist`
--

CREATE TABLE `xbid_hist` (
  `id` int(11) NOT NULL,
  `xbid_id` int(11) NOT NULL,
  `xbid_nbr` varchar(50) NOT NULL,
  `xbid_site` varchar(10) DEFAULT NULL,
  `xbid_part` varchar(100) NOT NULL,
  `xbid_due_date` date NOT NULL,
  `xbid_start_date` date DEFAULT NULL,
  `xbid_qty_req` decimal(10,0) NOT NULL,
  `xbid_attch` varchar(200) DEFAULT NULL,
  `xbid_price_min` decimal(10,0) DEFAULT NULL,
  `xbid_price_max` decimal(10,0) DEFAULT NULL,
  `xbid_remarks` varchar(200) DEFAULT NULL,
  `xbid_supp` varchar(50) DEFAULT NULL,
  `xbid_apprv` varchar(50) DEFAULT NULL,
  `xbid_flag` varchar(5) DEFAULT '0',
  `xbid_pro_qty` decimal(10,0) DEFAULT NULL,
  `xbid_pro_price` decimal(10,0) DEFAULT NULL,
  `xbid_pro_date` date DEFAULT NULL,
  `xbid_pro_remarks` varchar(255) DEFAULT NULL,
  `xbid_pro_attch` varchar(255) DEFAULT NULL,
  `xbid_pur_qty` decimal(10,2) DEFAULT NULL,
  `xbid_pur_date` date DEFAULT NULL,
  `xbid_hist_remarks` varchar(255) DEFAULT NULL,
  `xbid_no_po` varchar(30) DEFAULT NULL,
  `xbid_um` varchar(5) DEFAULT NULL,
  `xbid_desc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xbid_hist`
--

INSERT INTO `xbid_hist` (`id`, `xbid_id`, `xbid_nbr`, `xbid_site`, `xbid_part`, `xbid_due_date`, `xbid_start_date`, `xbid_qty_req`, `xbid_attch`, `xbid_price_min`, `xbid_price_max`, `xbid_remarks`, `xbid_supp`, `xbid_apprv`, `xbid_flag`, `xbid_pro_qty`, `xbid_pro_price`, `xbid_pro_date`, `xbid_pro_remarks`, `xbid_pro_attch`, `xbid_pur_qty`, `xbid_pur_date`, `xbid_hist_remarks`, `xbid_no_po`, `xbid_um`, `xbid_desc`) VALUES
(1, 750, 'RF000072', '10-100', 'ALCHOHOL', '2020-07-31', '2020-07-30', '50', '', NULL, '50000', NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(2, 751, 'RF000072', '10-100', 'ALCHOHOL', '2020-07-31', '2020-07-30', '50', NULL, NULL, '50000', NULL, '10S1004', NULL, '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'RFQ Closed by Purchasing', NULL, NULL, NULL),
(3, 752, 'RF000073', '10-100', 'ALCHOHOL', '2020-07-31', '2020-07-30', '500', '', NULL, '750000', NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(4, 753, 'RF000073', '10-100', 'ALCHOHOL', '2020-07-31', '2020-07-30', '500', NULL, '0', '750', NULL, '10S1004', NULL, '1', '450', '800000', '2020-07-31', NULL, 'C:\\xampp\\htdocs\\web_supp\\public\\/upload_supplier/20200730_045136-ITEM 1.PNG', NULL, NULL, 'Supplier Input BID', NULL, NULL, NULL),
(5, 754, 'RF000073', '10-100', 'ALCHOHOL', '2020-07-31', '2020-07-30', '500', NULL, '0', '750', NULL, '10S1004', NULL, '2', '450', '800', '2020-07-31', NULL, NULL, '470.00', '2020-07-31', 'Purchasing Approve Propose', 'WP000034', NULL, NULL),
(6, 755, 'RF000073', '10-100', 'ALCHOHOL', '2020-07-31', '2020-07-30', '500', NULL, NULL, '750000', NULL, '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Purchasing Update RFQ', NULL, NULL, NULL),
(7, 756, 'RF000073', '10-100', 'ALCHOHOL', '2020-07-31', '2020-07-30', '500', NULL, '0', '750', NULL, '10S1003', NULL, '1', '500', '8000000', '2020-07-31', NULL, '', NULL, NULL, 'Supplier Input BID', NULL, NULL, NULL),
(8, 757, 'RF000073', '10-100', 'ALCHOHOL', '2020-07-31', '2020-07-30', '500', NULL, '0', '750', NULL, '10S1003', NULL, '1', '500', '8000000', '2020-07-31', 'test', '', NULL, NULL, 'Supplier Input BID', NULL, NULL, NULL),
(9, 758, 'RF000073', '10-100', 'ALCHOHOL', '2020-07-31', '2020-07-30', '500', NULL, '0', '750', NULL, '10S1003', NULL, '1', '500', '8000000', '2020-07-31', 'test1', '', NULL, NULL, 'Supplier Input BID', NULL, NULL, NULL),
(10, 759, 'RF000074', '10-100', 'ALCHOHOL', '2020-08-04', '2020-08-03', '1500', '', '110000', '150000', NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(11, 760, 'RF000074', '10-100', 'ALCHOHOL', '2020-08-04', '2020-08-03', '1500', '', '110000', '150000', NULL, '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(12, 761, 'RF000075', '10-200', 'ALCHOHOL', '2020-10-12', '2020-10-12', '12', '', '1000', '15000', NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(13, 762, 'RF000075', '10-200', 'ALCHOHOL', '2020-10-12', '2020-10-12', '12', NULL, '1000', '15000', NULL, '10S1004', NULL, '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'RFQ Closed by Purchasing', NULL, NULL, NULL),
(14, 763, 'RF000001', '10-200', 'ALCHOHOL', '2020-10-16', '2020-10-14', '200', '', '200', '40000', NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(15, 764, 'RF000001', '10-200', 'ALCHOHOL', '2020-10-16', '2020-10-14', '200', '', '200', '40000', NULL, '10S1005', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(16, 765, 'RF000002', '10-300', 'METANOL', '2020-10-24', '2020-10-14', '4000', '', '124', '29123', NULL, '10S1005', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(17, 766, 'RF000003', '10-100', 'ALCHOHOL', '2020-10-31', '2020-10-14', '10', '', '222', '22222', NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(18, 767, 'RF000003', '10-100', 'ALCHOHOL', '2020-10-31', '2020-10-14', '10', '', '222', '22222', NULL, '10S1005', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(19, 768, 'RF000004', '10-300', 'ALCHOHOL', '2020-10-19', '2020-10-14', '313', '', '123', '3212', NULL, '10-300', 'Yes', '0', '15', '3000', NULL, NULL, NULL, '12.00', '2020-12-03', 'Supplier Create RFQ', '1', NULL, NULL),
(20, 769, 'RF000005', '10-200', 'ALCHOHOL', '2020-10-17', '2020-10-15', '12', '', '2', '10', NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(21, 770, 'RF000006', '10-300', 'ALCHOHOL', '2020-10-17', '2020-10-15', '10', '', '10', '25', NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(22, 771, 'RF000003', '10-100', 'ALCHOHOL', '2020-10-31', '2020-10-14', '10', NULL, '222', '22222', NULL, '10S1004', NULL, '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'RFQ Closed by Purchasing', NULL, NULL, NULL),
(23, 772, 'RF000003', '10-100', 'ALCHOHOL', '2020-10-31', '2020-10-14', '10', NULL, '222', '22222', NULL, '10S1005', NULL, '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'RFQ Closed by Purchasing', NULL, NULL, NULL),
(24, 773, 'RF000007', '10-200', 'ALCHOHOL', '2020-10-23', '2020-10-16', '9', '', '9', '200', NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(25, 774, 'RF000007', '10-200', 'ALCHOHOL', '2020-10-23', '2020-10-16', '9', '', '9', '200', NULL, '10S1003', 'Yes', '0', '12', '3500', NULL, NULL, NULL, '15.00', '2020-12-31', 'Supplier Create RFQ', '1', NULL, NULL),
(26, 775, 'RF000008', '10-300', 'panadol', '2020-10-29', '2020-10-16', '8', '', '76', '90', NULL, '10-200', 'Yes', '0', '12', '3000', NULL, NULL, NULL, '12.00', '2020-12-01', 'Supplier Create RFQ', '2', NULL, NULL),
(27, 776, 'RF000009', '10-200', 'METANOL', '2020-10-29', '2020-10-16', '819', '', '11', '22', NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(28, 777, 'RF000009', '10-200', 'METANOL', '2020-10-29', '2020-10-16', '819', '', '11', '22', NULL, '10S1005', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, NULL),
(29, 778, 'RF000011', '10-200', 'METANOL', '2020-10-25', '1970-01-01', '113', NULL, NULL, NULL, NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Purchasing Update RFQ', NULL, NULL, NULL),
(30, 779, 'RF000001', '10-200', 'ALCHOHOL', '2020-10-16', '2020-10-14', '200', NULL, '200', '40000', NULL, '10S1005', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Purchasing Update RFQ, Delete Supplier', NULL, NULL, NULL),
(31, 780, 'RF000001', '10-200', 'ALCHOHOL', '2020-10-16', '2020-10-14', '200', NULL, '20', '40000', NULL, '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Purchasing Update RFQ', NULL, NULL, NULL),
(32, 781, 'RF000001', '10-200', 'ALCHOHOL', '2020-10-16', '2020-10-14', '200', NULL, '20', '40000', NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Purchasing Update RFQ', NULL, NULL, NULL),
(33, 782, 'RF000001', '10-200', 'ALCHOHOL', '2020-10-16', '2020-10-14', '200', NULL, '20', '40000', NULL, '10S1005', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Purchasing Update RFQ, Delete Supplier', NULL, NULL, NULL),
(34, 783, 'RF000057', '10-100', 'ALCHOHOL', '2021-01-31', '2021-01-13', '5', '', NULL, NULL, 'Testing Remarks', '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, 'EA', NULL),
(35, 784, 'RF000058', '10-100', 'Test', '2021-01-14', '2021-01-14', '10', '', NULL, NULL, NULL, '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, 'EA', 'Memo'),
(36, 785, 'RF000058', '10-100', 'Test', '2021-01-14', '2021-01-14', '10', NULL, '0', '0', NULL, '10S1003', NULL, '1', '10', '1000', '2021-01-15', NULL, '', NULL, NULL, 'Supplier Input BID', NULL, NULL, NULL),
(37, 786, 'RF000058', '10-100', 'Test', '2021-01-14', '2021-01-14', '10', NULL, '0', '0', NULL, '10S1003', NULL, '1', '10', '1000', '2021-01-15', NULL, '', NULL, NULL, 'Supplier Input BID', NULL, NULL, NULL),
(38, 787, 'RF000058', '10-100', 'Test', '2021-01-14', '2021-01-14', '10', NULL, '0', '0', NULL, '10S1003', NULL, '1', '10', '1000', '2021-01-15', NULL, '', NULL, NULL, 'Supplier Input BID', NULL, NULL, NULL),
(39, 788, 'RF000074', '10-100', 'ALCHOHOL', '2020-08-04', '2020-08-03', '1500', NULL, '110000', '150000', NULL, '10S1004', NULL, '1', '135000', '80000', '2021-01-28', 'Cheapest price in the town', '', NULL, NULL, 'Supplier Input BID', NULL, NULL, NULL),
(40, 789, 'RF000060', '10-300', 'ALCHOHOL', '2021-01-20', '2021-01-18', '50', '', NULL, NULL, NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, 'BX', ''),
(41, 790, 'RF000060', '10-300', 'ALCHOHOL', '2021-01-20', '2021-01-18', '50', '', NULL, NULL, NULL, '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, 'BX', ''),
(42, 791, 'RF000075', '10-200', 'ALCHOHOL', '2020-10-12', '2020-10-12', '12', NULL, '1000', '15000', NULL, '10S1004', NULL, '1', '10', '5000', '2021-01-20', NULL, '', NULL, NULL, 'Supplier Input BID', NULL, NULL, NULL),
(43, 792, 'RF000075', '10-200', 'ALCHOHOL', '2020-10-12', '2020-10-12', '12', NULL, '1000', '15000', NULL, '10S1004', NULL, '2', '10', '5000', '2021-01-20', NULL, NULL, '10.00', '2021-01-21', 'Purchasing Approve Propose', 'WP000134', NULL, ''),
(44, 793, 'RF000062', '10-100', 'METANOL', '2021-01-26', NULL, '300', NULL, '200', '400', NULL, '10-300', NULL, '4', '10', '3000', NULL, NULL, NULL, '12.00', '2020-11-02', 'RFQ Closed by Purchasing', '2', NULL, NULL),
(45, 0, 'RF000063', '10-100', 'ALCHOHOL', '2021-03-09', '2021-03-08', '10', '', NULL, NULL, NULL, '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, 'EA', ''),
(46, 0, 'RF000063', '10-100', 'ALCHOHOL', '2021-03-09', '2021-03-08', '10', NULL, '0', '0', NULL, '10S1004', NULL, '1', '10', '10000', '2021-03-10', NULL, '', NULL, NULL, 'Supplier Input BID', NULL, NULL, NULL),
(47, 0, 'RF000074', '10-100', 'ALCHOHOL', '2020-08-04', '2020-08-03', '1500', NULL, '110000', '150000', NULL, '10S1003', NULL, '1', '100', '120000', '2021-04-06', NULL, '', NULL, NULL, 'Supplier Input BID', NULL, NULL, NULL),
(58, 0, 'RF000064', '10-100', 'Alchohol', '2021-04-22', '2021-04-15', '500', '', NULL, NULL, 'Testing Remarks Web Lain', '10S1004', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, ''),
(59, 0, 'RF000064', '10-100', 'Alchohol', '2021-04-22', '2021-04-15', '500', '', NULL, NULL, 'Testing Remarks Web Lain', '10-200', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, ''),
(60, 0, 'RF000065', '10-100', 'Alchohol', '2021-04-22', '2021-04-15', '2300', '', NULL, NULL, 'Testing Remarks Web Lain', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, ''),
(61, 0, 'RF000065', '10-100', 'Alchohol', '2021-04-22', '2021-04-15', '2300', '', NULL, NULL, 'Testing Remarks Web Lain', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, ''),
(62, 0, 'RF000066', '10-100', 'Alchohol', '2021-04-22', '2021-04-15', '2300', '', NULL, NULL, 'Testing Remarks Web Lain', '10S1003', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, ''),
(63, 0, 'RF000066', '10-100', 'Alchohol', '2021-04-22', '2021-04-15', '2300', '', NULL, NULL, 'Testing Remarks Web Lain', '10-300', 'Yes', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Supplier Create RFQ', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `xbid_mstr`
--

CREATE TABLE `xbid_mstr` (
  `id` int(11) NOT NULL,
  `xbid_id` varchar(50) NOT NULL,
  `xbid_site` varchar(10) NOT NULL,
  `xbid_part` varchar(100) NOT NULL,
  `xbid_desc` varchar(100) DEFAULT NULL,
  `xbid_qty_req` decimal(10,2) NOT NULL,
  `xbid_start_date` date DEFAULT NULL,
  `xbid_due_date` date NOT NULL,
  `xbid_attch` varchar(200) DEFAULT NULL,
  `xbid_remarks` varchar(200) DEFAULT NULL,
  `xbid_price_min` decimal(10,0) DEFAULT NULL,
  `xbid_price_max` decimal(10,0) DEFAULT NULL,
  `xbid_flag` varchar(5) DEFAULT '0',
  `xbid_um` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xbid_mstr`
--

INSERT INTO `xbid_mstr` (`id`, `xbid_id`, `xbid_site`, `xbid_part`, `xbid_desc`, `xbid_qty_req`, `xbid_start_date`, `xbid_due_date`, `xbid_attch`, `xbid_remarks`, `xbid_price_min`, `xbid_price_max`, `xbid_flag`, `xbid_um`) VALUES
(1, 'RF000001', '10-200', 'ALCHOHOL', NULL, '200.00', '2020-10-14', '2020-10-16', '', NULL, '20', '40000', '0', ''),
(2, 'RF000002', '10-300', 'METANOL', NULL, '4000.00', '2020-10-14', '2020-10-24', '', NULL, '124', '29123', '0', ''),
(3, 'RF000003', '10-100', 'ALCHOHOL', NULL, '10.00', '2020-10-14', '2020-10-31', '', NULL, '222', '22222', '2', ''),
(4, 'RF000004', '10-300', 'ALCHOHOL', NULL, '313.00', '2020-10-14', '2020-10-19', '', NULL, '123', '3212', '0', ''),
(5, 'RF000005', '10-200', 'ALCHOHOL', NULL, '12.00', '2020-10-15', '2020-10-17', '', NULL, '2', '10', '0', ''),
(6, 'RF000006', '10-300', 'ALCHOHOL', NULL, '10.00', '2020-10-15', '2020-10-17', '', NULL, '10', '25', '0', ''),
(7, 'RF000007', '10-200', 'ALCHOHOL', NULL, '9.00', '2020-10-16', '2020-10-23', '', NULL, '9', '200', '0', ''),
(8, 'RF000008', '10-300', 'panadol', NULL, '8.00', '2020-10-16', '2020-10-29', '', NULL, '76', '90', '0', ''),
(9, 'RF000009', '10-200', 'METANOL', NULL, '819.00', '2020-10-16', '2020-10-29', '', NULL, '11', '22', '0', ''),
(10, 'RF000010', '10-200', 'ALCHOHOL', NULL, '15.00', NULL, '2020-10-31', NULL, NULL, NULL, NULL, '0', ''),
(11, 'RF000011', '10-200', 'METANOL', NULL, '113.00', NULL, '2020-10-25', NULL, NULL, NULL, NULL, '0', ''),
(12, 'RF000012', '10-200', 'panadol', NULL, '88.00', NULL, '2020-10-25', NULL, NULL, NULL, NULL, '0', ''),
(13, 'RF000013', '10-200', 'METANOL', NULL, '11.00', NULL, '2020-10-25', NULL, NULL, NULL, NULL, '0', ''),
(14, 'RF000014', '10-200', 'panadol', NULL, '88.00', NULL, '2020-10-31', NULL, NULL, NULL, NULL, '0', ''),
(15, 'RF000015', '10-200', 'ALCHOHOL', NULL, '9.00', NULL, '2020-11-08', NULL, NULL, NULL, NULL, '0', ''),
(16, 'RF000016', '10-300', 'METANOL', NULL, '1.00', NULL, '2020-10-31', NULL, NULL, NULL, NULL, '0', ''),
(17, 'RF000018', '10-100', 'panadol', NULL, '15.00', NULL, '2020-10-31', NULL, NULL, NULL, NULL, '0', ''),
(18, 'RF000019', '10-100', 'panadol', NULL, '15.00', NULL, '2020-10-31', NULL, NULL, NULL, NULL, '0', ''),
(19, 'RF000020', '10-100', 'METANOL', NULL, '19.00', NULL, '2020-10-31', NULL, NULL, NULL, NULL, '0', ''),
(20, 'RF000021', '10-100', 'METANOL', NULL, '20.00', NULL, '2020-11-08', NULL, NULL, NULL, NULL, '0', ''),
(21, 'RF000022', '10-100', 'panadol', NULL, '17.00', NULL, '2020-11-08', NULL, NULL, NULL, NULL, '0', ''),
(22, 'RF000023', '10-100', 'METANOL', NULL, '1.00', NULL, '2020-11-08', NULL, NULL, NULL, NULL, '0', ''),
(23, 'RF000024', '10-100', 'panadol', NULL, '2.00', NULL, '2020-11-08', NULL, NULL, NULL, NULL, '0', ''),
(24, 'RF000025', '10-100', 'ALCHOHOL', NULL, '6.00', NULL, '2020-11-08', NULL, NULL, NULL, NULL, '0', ''),
(25, 'RF000026', '10-200', 'METANOL', NULL, '10.00', NULL, '2020-11-08', NULL, NULL, NULL, NULL, '0', ''),
(26, 'RF000027', '10-200', 'panadol', NULL, '10.00', NULL, '2020-11-08', NULL, NULL, NULL, NULL, '0', ''),
(27, 'RF000028', '10-300', 'panadol', NULL, '11.00', NULL, '2021-01-03', NULL, NULL, NULL, NULL, '0', ''),
(28, 'RF000029', '10-300', 'ALCHOHOL', NULL, '12.00', NULL, '2021-01-03', NULL, NULL, NULL, NULL, '0', ''),
(29, 'RF000030', '10-100', 'METANOL', NULL, '15.00', NULL, '2020-11-19', NULL, NULL, NULL, NULL, '0', ''),
(30, 'RF000031', '10-200', 'ALCHOHOL', NULL, '13.00', NULL, '2021-01-07', NULL, NULL, NULL, NULL, '0', ''),
(31, 'RF000032', '10-200', 'METANOL', NULL, '97.00', NULL, '2021-01-07', NULL, NULL, NULL, NULL, '0', ''),
(32, 'RF000033', '10-200', 'panadol', NULL, '45.50', NULL, '2021-01-07', NULL, NULL, NULL, NULL, '0', ''),
(33, 'RF000034', '10-300', 'ALCHOHOL', NULL, '90.11', NULL, '2021-01-28', NULL, NULL, NULL, NULL, '0', ''),
(34, 'RF000035', '10-300', 'METANOL', NULL, '99.11', NULL, '2021-01-28', NULL, NULL, NULL, NULL, '0', ''),
(35, 'RF000036', '10-300', 'panadol', NULL, '15.00', NULL, '2021-01-28', NULL, NULL, NULL, NULL, '0', ''),
(36, 'RF000037', '10-100', 'panadol', NULL, '297.00', NULL, '2027-11-26', NULL, NULL, NULL, NULL, '0', ''),
(37, 'RF000038', '10-100', 'METANOL', NULL, '3.00', NULL, '2027-11-26', NULL, NULL, NULL, NULL, '0', ''),
(38, 'RF000039', '10-100', 'ALCHOHOL', NULL, '61.00', NULL, '2027-11-26', NULL, NULL, NULL, NULL, '0', ''),
(39, 'RF000040', '10-200', 'ALCHOHOL', NULL, '95.55', NULL, '2020-11-28', NULL, NULL, NULL, NULL, '0', ''),
(40, 'RF000041', '10-300', 'ALCHOHOL', NULL, '15.00', NULL, '2020-11-16', NULL, NULL, NULL, NULL, '0', ''),
(41, 'RF000042', '10-300', 'METANOL', NULL, '25.00', NULL, '2020-11-16', NULL, NULL, NULL, NULL, '0', ''),
(42, 'RF000043', '10-200', 'ALCHOHOL', NULL, '11.00', NULL, '2020-12-04', NULL, NULL, NULL, NULL, '0', ''),
(43, 'RF000044', '10-300', 'ALCHOHOL', NULL, '6.80', NULL, '2021-04-14', NULL, NULL, NULL, NULL, '0', ''),
(44, 'RF000045', '10-300', 'METANOL', NULL, '79.00', NULL, '2021-04-14', NULL, NULL, NULL, NULL, '0', ''),
(45, 'RF000046', '10-100', 'METANOL', NULL, '70.00', NULL, '2020-12-04', NULL, NULL, NULL, NULL, '0', ''),
(46, 'RF000047', '10-100', 'panadol', NULL, '11.00', NULL, '2020-12-04', NULL, NULL, NULL, NULL, '0', ''),
(47, 'RF000048', '10-100', 'METANOL', NULL, '1.00', NULL, '2021-01-05', NULL, NULL, NULL, NULL, '0', ''),
(48, 'RF000049', '10-100', 'panadol', NULL, '2.00', NULL, '2021-01-05', NULL, NULL, NULL, NULL, '0', ''),
(49, 'RF000050', '10-100', 'METANOL', NULL, '1.00', NULL, '2021-01-05', NULL, NULL, NULL, NULL, '0', ''),
(50, 'RF000051', '10-100', 'panadol', NULL, '2.00', NULL, '2021-01-05', NULL, NULL, NULL, NULL, '0', ''),
(51, 'RF000052', '10-100', 'ALCHOHOL', NULL, '25.00', NULL, '2020-11-20', NULL, NULL, NULL, NULL, '0', ''),
(52, 'RF000053', '10-100', 'METANOL', NULL, '30.00', NULL, '2020-11-20', NULL, NULL, NULL, NULL, '0', ''),
(53, 'RF000054', '10-100', 'PARACETAMOL', NULL, '1500.00', NULL, '2020-11-27', NULL, NULL, NULL, NULL, '0', ''),
(54, 'RF000055', '10-300', 'ALCHOHOL', NULL, '15.00', NULL, '2020-11-19', NULL, NULL, NULL, NULL, '0', ''),
(55, 'RF000056', '10-300', 'METANOL', NULL, '25.00', NULL, '2020-11-19', NULL, NULL, NULL, NULL, '0', ''),
(56, 'RF000057', '10-100', 'ALCHOHOL', NULL, '5.00', '2021-01-13', '2021-01-31', '', 'Testing Remarks', NULL, NULL, '0', 'GA'),
(57, 'RF000058', '10-100', 'Test', 'Memo', '10.00', '2021-01-14', '2021-01-14', '', NULL, NULL, NULL, '1', 'EA'),
(58, 'RF000059', '10-100', 'PARACETAMOL', NULL, '30.00', NULL, '2021-01-21', NULL, NULL, NULL, NULL, '0', NULL),
(59, 'RF000060', '10-300', 'ALCHOHOL', '', '50.00', '2021-01-18', '2021-01-20', '', NULL, NULL, NULL, '0', 'BX'),
(60, 'RF000061', '10-100', 'ALCHOHOL', NULL, '100.00', NULL, '2021-01-26', NULL, NULL, NULL, NULL, '0', NULL),
(61, 'RF000062', '10-100', 'METANOL', NULL, '300.00', NULL, '2021-01-26', NULL, NULL, '200', '400', '2', 'BX'),
(62, 'RF000072', '10-100', 'ALCHOHOL', NULL, '50.00', '2020-07-30', '2020-07-31', '', NULL, NULL, '50000', '2', ''),
(63, 'RF000073', '10-100', 'ALCHOHOL', NULL, '500.00', '2020-07-30', '2020-07-31', '', NULL, NULL, '750000', '1', ''),
(64, 'RF000074', '10-100', 'ALCHOHOL', NULL, '1500.00', '2020-08-03', '2020-08-04', '', NULL, '110000', '150000', '1', 'BX'),
(65, 'RF000075', '10-200', 'ALCHOHOL', NULL, '12.00', '2020-10-12', '2020-10-12', '', NULL, '1000', '15000', '2', ''),
(66, 'RF000063', '10-100', 'ALCHOHOL', '', '10.00', '2021-03-08', '2021-03-09', '', NULL, NULL, NULL, '1', 'EA'),
(87, 'RF000064', '10-100', 'Alchohol', '', '500.00', '2021-04-15', '2021-04-22', '', 'Testing Remarks Web Lain', NULL, NULL, '0', NULL),
(88, 'RF000065', '10-100', 'Alchohol', '', '2300.00', '2021-04-15', '2021-04-22', '', 'Testing Remarks Web Lain', NULL, NULL, '0', NULL),
(89, 'RF000066', '10-100', 'Alchohol', '', '2300.00', '2021-04-15', '2021-04-22', '', 'Testing Remarks Web Lain', NULL, NULL, '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xcust_mstr`
--

CREATE TABLE `xcust_mstr` (
  `xcust_id` int(20) NOT NULL,
  `xcust_code` varchar(35) NOT NULL,
  `xitem_code` varchar(20) NOT NULL,
  `xcust_type` varchar(35) NOT NULL,
  `xcust_start_date` date NOT NULL,
  `xcust_min_ord` int(35) NOT NULL,
  `xcust_list_price` int(35) NOT NULL,
  `xcust_discount` int(25) NOT NULL,
  `xcust_end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `xdepartment`
--

CREATE TABLE `xdepartment` (
  `id` int(12) NOT NULL,
  `xdept` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `xdept_desc` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xdepartment`
--

INSERT INTO `xdepartment` (`id`, `xdept`, `xdept_desc`) VALUES
(1, 'PT', 'Perseroan'),
(4, 'R&D', 'Research and Development'),
(5, 'KEU', 'Keuangan'),
(6, 'IT', 'IT Department'),
(7, 'Conslt.', 'Konsultan'),
(8, 'Admin', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `xdomain_mstr`
--

CREATE TABLE `xdomain_mstr` (
  `xdomain_code` varchar(10) NOT NULL,
  `xdomain_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xdomain_mstr`
--

INSERT INTO `xdomain_mstr` (`xdomain_code`, `xdomain_desc`) VALUES
('10USA', 'USACO');

-- --------------------------------------------------------

--
-- Table structure for table `xexp_det`
--

CREATE TABLE `xexp_det` (
  `xexp_part` varchar(50) NOT NULL,
  `xexp_loc` varchar(10) NOT NULL,
  `xexp_lot` varchar(50) NOT NULL,
  `xexp_ref` varchar(50) NOT NULL,
  `xexp_exp_date` date NOT NULL,
  `xexp_qty_oh` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `xinvd_det`
--

CREATE TABLE `xinvd_det` (
  `id` int(11) NOT NULL,
  `xinvd_domain` varchar(8) NOT NULL,
  `xinvd_site` varchar(8) NOT NULL,
  `xinvd_part` varchar(50) NOT NULL,
  `xinvd_loc` varchar(8) NOT NULL,
  `xinvd_lot` varchar(20) NOT NULL,
  `xinvd_ref` varchar(25) NOT NULL,
  `xinvd_qty_oh` decimal(10,0) NOT NULL,
  `xinvd_qty_all` decimal(10,0) NOT NULL,
  `xinvd_expire` date NOT NULL,
  `xinvd_ed` varchar(8) NOT NULL,
  `xinvd_days` int(11) NOT NULL,
  `xinvd_amt` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xinvd_det`
--

INSERT INTO `xinvd_det` (`id`, `xinvd_domain`, `xinvd_site`, `xinvd_part`, `xinvd_loc`, `xinvd_lot`, `xinvd_ref`, `xinvd_qty_oh`, `xinvd_qty_all`, `xinvd_expire`, `xinvd_ed`, `xinvd_days`, `xinvd_amt`) VALUES
(1, '10USA', '10-100', 'MT001', 'loc1', 'lot1', 'ref1', '100', '50', '2021-04-05', '0', 30, '100000'),
(2, '10USA', '10-100', 'MT001', 'loc2', 'lot2', 'ref2', '300', '0', '2021-04-05', '30', 30, '300000'),
(3, '10USA', '10-100', 'MT001', 'loc2', 'lot3', 'ref3', '250', '0', '2021-04-05', '30', 30, '250000'),
(4, '10USA', '10-100', 'MT002', 'loc1', 'lot1', 'ref1', '150', '0', '2021-04-05', '90', 30, '150000'),
(5, '10USA', '10-100', 'MT002', 'loc1', 'lot2', 'ref1', '50', '0', '2021-04-05', '90', 30, '550000'),
(6, '10USA', '10-100', 'MT003', 'loc1', 'lot3', 'ref1', '120', '0', '2021-04-05', '90', 30, '120000'),
(7, '10USA', '10-100', 'MT004', 'loc1', 'lot1', 'ref1', '320', '10', '2021-04-05', '90', 20, '3200000'),
(8, '10USA', '10-100', 'MT004', 'loc2', 'lot2', 'ref2', '120', '10', '2021-04-05', '90', 20, '1200000'),
(9, '10USA', '10-100', 'MT005', 'loc1', 'lot1', 'ref1', '320', '10', '2021-04-05', '180', 20, '3200000');

-- --------------------------------------------------------

--
-- Table structure for table `xinv_mstr`
--

CREATE TABLE `xinv_mstr` (
  `xinv_id` int(11) NOT NULL,
  `xinv_domain` varchar(8) NOT NULL,
  `xinv_part` varchar(50) NOT NULL,
  `xinv_sft_stock` decimal(10,0) NOT NULL COMMENT 'safety stock',
  `xinv_site` varchar(8) NOT NULL,
  `xinv_qty_oh` decimal(10,0) NOT NULL,
  `xinv_qty_ord` decimal(10,0) NOT NULL,
  `xinv_qty_req` decimal(10,0) NOT NULL,
  `xinv_ss` varchar(3) NOT NULL,
  `xinv_ss_pct` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xinv_mstr`
--

INSERT INTO `xinv_mstr` (`xinv_id`, `xinv_domain`, `xinv_part`, `xinv_sft_stock`, `xinv_site`, `xinv_qty_oh`, `xinv_qty_ord`, `xinv_qty_req`, `xinv_ss`, `xinv_ss_pct`) VALUES
(326, '10USA', 'ab', '0', '10-100', '97378', '2685', '11320', 'N', 'N'),
(327, '10USA', 'ac', '0', '10-100', '0', '67', '15', 'N', 'N'),
(328, '10USA', 'alchohol', '0', '10-100', '98', '1500', '0', 'N', 'N'),
(329, '10USA', 'ALCHOHOL', '0', '10-200', '0', '0', '0', 'N', 'N'),
(330, '10USA', 'ALCHOHOL', '0', '10-300', '0', '15', '0', 'N', 'N'),
(331, '10USA', 'FG-RF', '0', '10-100', '0', '0', '0', 'N', 'N'),
(332, '10USA', 'panadol', '0', '10-100', '3', '19', '0', 'N', 'N'),
(333, '10USA', 'panadol', '0', '10-200', '34', '0', '0', 'N', 'N'),
(334, '10USA', 'panadol', '0', '10-300', '0', '120', '0', 'N', 'N'),
(335, '10USA', 't', '0', '10-100', '0', '0', '0', 'N', 'N'),
(336, '10USA', 'TEST', '0', '10-100', '600', '0', '0', 'N', 'N'),
(337, '10USA', 'tpart', '200', '10-100', '200', '0', '0', 'y', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `xitemreq_mstr`
--

CREATE TABLE `xitemreq_mstr` (
  `xitemreq_domain` varchar(8) NOT NULL,
  `xitemreq_part` varchar(20) NOT NULL,
  `xitemreq_desc` varchar(50) NOT NULL,
  `xitemreq_um` varchar(3) NOT NULL,
  `xitemreq_prod_line` varchar(8) NOT NULL,
  `xitemreq_group` varchar(8) NOT NULL,
  `xitemreq_type` varchar(8) NOT NULL,
  `xitemreq_pm` varchar(2) NOT NULL,
  `xitemreq_sfty_stk` int(11) NOT NULL,
  `xitemreq_promo` varchar(10) NOT NULL,
  `xitemreq_dsgn` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xitemreq_mstr`
--

INSERT INTO `xitemreq_mstr` (`xitemreq_domain`, `xitemreq_part`, `xitemreq_desc`, `xitemreq_um`, `xitemreq_prod_line`, `xitemreq_group`, `xitemreq_type`, `xitemreq_pm`, `xitemreq_sfty_stk`, `xitemreq_promo`, `xitemreq_dsgn`) VALUES
('10USA', 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', 'ST', '', '', '', 0, '', ''),
('10USA', 'METANOL', 'NEW ITEM TEST ', 'BX', 'ST', '', '', '', 0, '', ''),
('10USA', 'panadol', 'PANADOL TEST ITEM ', 'EA', 'ST', '', '', '', 0, '', ''),
('10USA', 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '10', '', '', '', 0, '', ''),
('10USA', 'ew', ' ', 'EA', '', '', '', '', 0, '', ''),
('10USA', 'RM-RF', 'Raw Material FG ', 'EA', '60', '', '', 'P', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `xitem_mstr`
--

CREATE TABLE `xitem_mstr` (
  `id` int(11) NOT NULL,
  `xitem_domain` varchar(8) NOT NULL,
  `xitem_part` varchar(20) NOT NULL,
  `xitem_desc` varchar(50) NOT NULL,
  `xitem_um` varchar(3) NOT NULL,
  `xitem_prod_line` varchar(8) NOT NULL,
  `xitem_group` varchar(8) NOT NULL,
  `xitem_type` varchar(8) NOT NULL,
  `xitem_pm` varchar(2) NOT NULL,
  `xitem_sfty_stk` int(11) NOT NULL,
  `xitem_promo` varchar(10) NOT NULL,
  `xitem_dsgn` varchar(10) NOT NULL,
  `xitem_sfty` int(11) NOT NULL,
  `xitem_sfty_email` varchar(200) NOT NULL DEFAULT ' ',
  `xitem_day1` int(11) NOT NULL,
  `xitem_day_email1` varchar(200) NOT NULL DEFAULT ' ',
  `xitem_day2` int(11) NOT NULL,
  `xitem_day_email2` varchar(200) NOT NULL DEFAULT ' ',
  `xitem_day3` int(11) NOT NULL,
  `xitem_day_email3` varchar(200) NOT NULL DEFAULT ' '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xitem_mstr`
--

INSERT INTO `xitem_mstr` (`id`, `xitem_domain`, `xitem_part`, `xitem_desc`, `xitem_um`, `xitem_prod_line`, `xitem_group`, `xitem_type`, `xitem_pm`, `xitem_sfty_stk`, `xitem_promo`, `xitem_dsgn`, `xitem_sfty`, `xitem_sfty_email`, `xitem_day1`, `xitem_day_email1`, `xitem_day2`, `xitem_day_email2`, `xitem_day3`, `xitem_day_email3`) VALUES
(2, '10USA', 'ab', ' ', 'EA', '10', '', '', '', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(3, '10USA', 'ac', ' ', 'EA', '10', '', '', '', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(4, '10USA', 'alchohol', 'Alchohol ', 'EA', '10', '', '', 'M', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(5, '10USA', 'FG-RF', 'Finished Goods RF ', 'EA', '10', '', '', 'M', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(6, '10USA', 'MT001', 'Metanol', 'EA', '10', '', '', '', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(7, '10USA', 'MT002', 'Panadol', 'EA', '10', '', '', '', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(8, '10USA', 'MT003', 'Paracetamol', 'EA', '10', '', '', '', 50, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(9, '10USA', 'MT004', 'Iodium', 'EA', '10', '', '', '', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(10, '10USA', 'JH503012ID21', 'kiwi paste shoe polish ', 'CM', '10', '', '', '', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(11, '10USA', 'JH527011AU10', 'kiwi kids scuff black ', 'BX', '10', '', '', 'M', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(12, '10USA', 'JH527021AU10', 'kiwi kids scuff brown ', 'CM', '10', '', '', '', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(13, '10USA', 'JH560010JP20', 'kiwi elite 75ml black ', 'CM', '10', '', '', '', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(14, '10USA', 'panadol', '', 'EA', '10', '', '', '', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(15, '10USA', 'MT005', 'Meta Polish', 'EA', '10', '', '', 'M', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(16, '10USA', 't', ' ', 'EA', '10', '', '', '', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(17, '10USA', 'tpart', 'tess tes1', 'EA', '10', '', '', '', 200, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(18, '10USA', 'PZ05111001MF', 'cb milk bath 7 mlx576 ', 'CM', '30', '', '', '', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(19, '10USA', 'SFG-RF', 'Semi Finished Goods RF ', 'EA', '30', '', '', 'M', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' '),
(20, '10USA', 'TEST', 'Test Item ', 'EA', '30', '', '', 'M', 0, '', '', 0, ' ', 0, ' ', 0, ' ', 0, ' ');

-- --------------------------------------------------------

--
-- Table structure for table `xitmreq_ctrl`
--

CREATE TABLE `xitmreq_ctrl` (
  `xitmreq_id` int(11) NOT NULL,
  `xitmreq_part` varchar(18) DEFAULT NULL,
  `xitmreq_prod_line` varchar(10) DEFAULT ' ',
  `xitmreq_design` varchar(10) DEFAULT ' ',
  `xitmreq_promo` varchar(10) DEFAULT ' ',
  `xitmreq_type` varchar(10) DEFAULT ' ',
  `xitmreq_group` varchar(10) DEFAULT ' '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xitmreq_ctrl`
--

INSERT INTO `xitmreq_ctrl` (`xitmreq_id`, `xitmreq_part`, `xitmreq_prod_line`, `xitmreq_design`, `xitmreq_promo`, `xitmreq_type`, `xitmreq_group`) VALUES
(37, '', '10', '', '', '', 'test'),
(38, '', '60', '', '', '', ''),
(36, '', 'ST', '', '', '', ''),
(39, 'fg', '', '', '', '', ''),
(34, 'Toilet', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `xitm_ctrl`
--

CREATE TABLE `xitm_ctrl` (
  `xitm_id` int(11) NOT NULL,
  `xitm_part` varchar(18) DEFAULT ' ',
  `xitm_prod_line` varchar(10) DEFAULT ' ',
  `xitm_design` varchar(10) DEFAULT ' ',
  `xitm_promo` varchar(10) DEFAULT ' ',
  `xitm_type` varchar(10) DEFAULT ' ',
  `xitm_group` varchar(10) DEFAULT ' ',
  `xitm_sfty` int(11) NOT NULL,
  `xitm_days1` int(11) DEFAULT NULL,
  `xitm_days2` int(11) DEFAULT NULL,
  `xitm_days3` int(11) DEFAULT NULL,
  `xitm_email1` varchar(100) NOT NULL DEFAULT ' ',
  `xitm_email2` varchar(100) NOT NULL DEFAULT ' ',
  `xitm_email3` varchar(100) NOT NULL DEFAULT '  '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `xloc_mstr`
--

CREATE TABLE `xloc_mstr` (
  `xloc_domain` varchar(8) NOT NULL,
  `xloc_loc` varchar(8) NOT NULL,
  `xloc_desc` varchar(20) NOT NULL,
  `xloc_site` varchar(8) NOT NULL,
  `xloc_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `xpod_dets`
--

CREATE TABLE `xpod_dets` (
  `id` int(11) NOT NULL,
  `xpod_domain` varchar(10) NOT NULL,
  `xpod_nbr` varchar(15) NOT NULL,
  `xpod_line` int(11) NOT NULL,
  `xpod_part` varchar(50) NOT NULL,
  `xpod_desc` varchar(100) DEFAULT NULL,
  `xpod_um` varchar(5) DEFAULT NULL,
  `xpod_qty_ord` decimal(10,2) DEFAULT NULL,
  `xpod_qty_rcvd` decimal(10,2) DEFAULT NULL,
  `xpod_qty_open` decimal(10,0) DEFAULT NULL,
  `xpod_qty_ship` decimal(12,2) NOT NULL,
  `xpod_qty_tole` decimal(12,2) NOT NULL,
  `xpod_qty_prom` decimal(10,0) NOT NULL,
  `xpod_price` varchar(20) DEFAULT NULL,
  `xpod_loc` varchar(15) DEFAULT NULL,
  `xpod_lot` varchar(25) DEFAULT NULL,
  `xpod_date` date DEFAULT NULL,
  `xpod_ship_date` date DEFAULT NULL,
  `xpod_due_date` date DEFAULT NULL,
  `xpod_eff_date` date DEFAULT NULL,
  `xpod_prom_date` date NOT NULL,
  `xpod_status` varchar(100) DEFAULT 'UnConfirm',
  `xpod_status1` varchar(40) NOT NULL,
  `xpod_cancel` varchar(5) DEFAULT NULL,
  `xpod_site` varchar(10) DEFAULT NULL,
  `xpod_ref` varchar(255) DEFAULT NULL,
  `xpod_last_conf` date DEFAULT NULL,
  `xpod_tot_conf` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `xpod_qty_shipx` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xpod_dets`
--

INSERT INTO `xpod_dets` (`id`, `xpod_domain`, `xpod_nbr`, `xpod_line`, `xpod_part`, `xpod_desc`, `xpod_um`, `xpod_qty_ord`, `xpod_qty_rcvd`, `xpod_qty_open`, `xpod_qty_ship`, `xpod_qty_tole`, `xpod_qty_prom`, `xpod_price`, `xpod_loc`, `xpod_lot`, `xpod_date`, `xpod_ship_date`, `xpod_due_date`, `xpod_eff_date`, `xpod_prom_date`, `xpod_status`, `xpod_status1`, `xpod_cancel`, `xpod_site`, `xpod_ref`, `xpod_last_conf`, `xpod_tot_conf`, `created_at`, `updated_at`, `xpod_qty_shipx`) VALUES
(4460, '10USA', 'RCP6', 1, 'METANOL', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '20', '130.00', '0.00', '150', '500', '030', '', '2020-07-29', NULL, '2020-07-29', NULL, '0000-00-00', 'Confirm', '', NULL, NULL, NULL, NULL, NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26', 0),
(4461, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470', '470.00', '0.00', '470', '800000', '030', '', '2020-07-31', NULL, '2020-07-31', NULL, '0000-00-00', 'Confirm', '', NULL, NULL, NULL, NULL, NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26', 470),
(4462, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '85', '65.00', '0.00', '150', '700', '030', '', '2020-07-29', NULL, '2020-07-29', NULL, '0000-00-00', 'Confirmed', '', NULL, NULL, NULL, NULL, NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26', 0),
(4463, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500', '0.00', '0.00', '1500', '50000', '030', '', '2020-07-29', NULL, '2020-07-29', NULL, '0000-00-00', 'UnConfirm', '', NULL, NULL, NULL, NULL, NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26', 0),
(4464, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150', '0.00', '0.00', '150', '100', '030', '', '2020-07-29', NULL, '2020-07-29', NULL, '0000-00-00', 'UnConfirm', '', NULL, NULL, NULL, NULL, NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26', 0),
(4465, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '0', '1.00', '0.00', '1', '10000', '030', '', '2020-07-29', NULL, '2020-07-29', NULL, '0000-00-00', 'Confirmed', '', NULL, NULL, NULL, NULL, NULL, '2020-07-30 02:49:25', '2020-07-30 02:49:25', 0),
(4466, '10USA', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '45', '105.00', '0.00', '150', '20', '030', '', '2020-07-29', NULL, '2021-04-09', NULL, '0000-00-00', 'Confirm', '', NULL, NULL, NULL, NULL, NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26', 5),
(4467, '10USA', 'RCP11', 2, 'PANADOL', 'PANADOL TEST ITEM ', 'EA', '100.00', '0.00', '20', '80.00', '0.00', '100', '20', '030', '', '2020-07-29', NULL, '2021-04-09', NULL, '0000-00-00', 'Confirm', '', NULL, NULL, NULL, NULL, NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26', 0),
(4468, '10USA', 'RCP11', 3, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '100.00', '0.00', '100', '0.00', '0.00', '100', '50', '030', '', '2020-07-29', NULL, '2021-04-09', NULL, '0000-00-00', 'Confirm', '', NULL, NULL, NULL, NULL, NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26', 0),
(4471, '10USA', 'testact', 1, '01010', 'tes9999 text123', 'EA', '1.00', '0.00', '1', '0.00', '0.00', '1', '0', '010', '', '2021-06-07', NULL, '2021-06-07', NULL, '0000-00-00', 'UnConfirm', '', NULL, NULL, NULL, NULL, NULL, '2021-06-07 04:13:59', '2021-06-07 04:13:59', 0),
(4472, '10USA', 'testact', 2, '01020', 'wwewqeqweqwe ', 'EA', '1.00', '0.00', '1', '0.00', '0.00', '1', '0', '010', '', '2021-06-07', NULL, '2021-06-07', NULL, '0000-00-00', 'UnConfirm', '', NULL, NULL, NULL, NULL, NULL, '2021-06-07 04:13:59', '2021-06-07 04:13:59', 0),
(4473, '10USA', 'testact', 3, 'METANOL', ' ', 'EA', '50.00', '0.00', '50', '0.00', '0.00', '50', '0', '', '', '2021-06-07', NULL, '2021-06-07', NULL, '0000-00-00', 'UnConfirm', '', NULL, NULL, NULL, NULL, NULL, '2021-06-07 04:13:59', '2021-06-07 04:13:59', 0),
(4474, '10USA', 'testact', 4, 'panadol', ' ', 'EA', '50.00', '0.00', '50', '0.00', '0.00', '50', '0', '', '', '2021-06-07', NULL, '2021-06-07', NULL, '0000-00-00', 'UnConfirm', '', NULL, NULL, NULL, NULL, NULL, '2021-06-07 04:13:59', '2021-06-07 04:13:59', 0),
(4475, '10USA', 'testpo', 1, '010106', ' ', 'EA', '5.00', '0.00', '5', '0.00', '0.00', '5', '0', '', '', '2021-06-16', NULL, '2021-06-16', NULL, '0000-00-00', 'UnConfirm', '', NULL, NULL, NULL, NULL, NULL, '2021-06-16 05:45:57', '2021-06-16 05:45:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `xpo_app_hist`
--

CREATE TABLE `xpo_app_hist` (
  `id` int(11) NOT NULL,
  `xpo_app_nbr` varchar(15) NOT NULL,
  `xpo_app_approver` varchar(50) NOT NULL,
  `xpo_app_alt_approver` varchar(10) NOT NULL,
  `xpo_app_user` varchar(10) DEFAULT NULL,
  `xpo_app_order` varchar(5) DEFAULT NULL,
  `xpo_app_reason` varchar(255) DEFAULT NULL,
  `xpo_app_date` datetime DEFAULT NULL,
  `xpo_app_status` int(11) NOT NULL,
  `xpo_app_flag` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xpo_app_hist`
--

INSERT INTO `xpo_app_hist` (`id`, `xpo_app_nbr`, `xpo_app_approver`, `xpo_app_alt_approver`, `xpo_app_user`, `xpo_app_order`, `xpo_app_reason`, `xpo_app_date`, `xpo_app_status`, `xpo_app_flag`) VALUES
(227, 'RCP8', '1', '3', 'Ray', '1', NULL, '2020-07-30 00:00:00', 1, NULL),
(228, 'RCP8', '2', '3', 'Bintang', '2', 'Price too high', '2020-07-30 00:00:00', 2, NULL),
(229, 'RCP6', '3', '5', 'Bintang', '3', 'Price too high', '2020-07-30 00:00:00', 1, NULL),
(230, 'RCP7', '46', '45', 'Ray', '1', 'Reject aja', '2020-07-30 00:00:00', 2, NULL),
(233, 'RCP7', '46', '45', 'Ray', '1', NULL, '2020-07-30 00:00:00', 2, NULL),
(234, 'RCP7', '47', '45', NULL, '2', NULL, NULL, 0, NULL),
(235, 'RCP7', '45', '47', NULL, '3', NULL, NULL, 0, NULL),
(236, 'RCP7', '46', '45', 'Ray', '1', 'Price still reasonable', '2020-07-30 00:00:00', 1, NULL),
(237, 'RCP7', '47', '45', 'Bintang', '2', NULL, '2020-07-30 00:00:00', 1, NULL),
(238, 'RCP7', '45', '47', 'Bintang', '3', NULL, '2020-07-30 00:00:00', 1, NULL),
(239, 'RCP9', '1', '3', 'Ray', '1', 'Price reasonable', '2020-07-30 00:00:00', 1, NULL),
(240, 'RCP9', '47', '45', 'Rifky', '2', 'Price to high', '2020-07-30 00:00:00', 2, NULL),
(241, 'RCP9', '45', '47', NULL, '3', NULL, NULL, 0, NULL),
(242, 'RCP11', '46', '45', 'Bintang', '1', NULL, '2020-07-30 00:00:00', 1, NULL),
(243, 'RCP11', '47', '45', 'Bintang', '2', NULL, '2020-07-30 00:00:00', 1, NULL),
(244, 'RCP11', '45', '47', 'Bintang', '3', NULL, '2020-07-30 00:00:00', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xpo_app_trans`
--

CREATE TABLE `xpo_app_trans` (
  `id` int(11) NOT NULL,
  `xpo_app_nbr` varchar(15) NOT NULL,
  `xpo_app_approver` varchar(50) NOT NULL,
  `xpo_app_alt_approver` varchar(10) NOT NULL,
  `xpo_app_user` varchar(10) DEFAULT NULL,
  `xpo_app_order` varchar(5) DEFAULT NULL,
  `xpo_app_reason` varchar(255) DEFAULT NULL,
  `xpo_app_date` datetime DEFAULT NULL,
  `xpo_app_status` int(11) NOT NULL,
  `xpo_app_flag` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xpo_app_trans`
--

INSERT INTO `xpo_app_trans` (`id`, `xpo_app_nbr`, `xpo_app_approver`, `xpo_app_alt_approver`, `xpo_app_user`, `xpo_app_order`, `xpo_app_reason`, `xpo_app_date`, `xpo_app_status`, `xpo_app_flag`) VALUES
(84, 'RCP8', '1', '45', NULL, '1', NULL, NULL, 0, NULL),
(85, 'RCP9', '1', '45', NULL, '1', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xpo_control`
--

CREATE TABLE `xpo_control` (
  `id` int(11) NOT NULL,
  `xpo_approver` int(11) NOT NULL,
  `supp_code` varchar(50) NOT NULL,
  `xpo_alt_app` int(11) DEFAULT NULL,
  `intv_rem` int(11) DEFAULT NULL,
  `reapprove` varchar(5) NOT NULL DEFAULT 'Yes',
  `min_amt` decimal(10,2) NOT NULL,
  `max_amt` decimal(10,2) NOT NULL,
  `xpo_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xpo_control`
--

INSERT INTO `xpo_control` (`id`, `xpo_approver`, `supp_code`, `xpo_alt_app`, `intv_rem`, `reapprove`, `min_amt`, `max_amt`, `xpo_status`) VALUES
(9, 46, '10S1001', 45, 10, 'Yes', '500.00', '700.00', 'UnConfirm'),
(10, 47, '10S1001', 45, 10, 'Yes', '800.00', '900.00', 'UnConfirm'),
(95, 46, '10S1003', 45, NULL, 'Yes', '0.00', '99999999.99', 'UnConfirm'),
(96, 47, '10S1003', 45, NULL, 'Yes', '2000.00', '99999999.99', 'UnConfirm'),
(97, 45, '10S1003', 47, NULL, 'Yes', '5000.00', '99999999.99', 'UnConfirm'),
(98, 59, '10S1003', 58, NULL, 'Yes', '1000.00', '20000.00', 'UnConfirm'),
(99, 46, '10-300', 50, NULL, 'No', '200.00', '1000.00', 'UnConfirm'),
(100, 45, '10-300', 47, NULL, 'No', '4000.00', '5000.00', 'UnConfirm'),
(104, 47, '10-200', 45, NULL, 'No', '2000.00', '5000.00', 'UnConfirm'),
(105, 46, '10-200', 45, NULL, 'No', '5000.00', '99999999.00', 'UnConfirm'),
(0, 6, 'General', 11, NULL, 'Yes', '100.00', '1000.00', 'UnConfirm');

-- --------------------------------------------------------

--
-- Table structure for table `xpo_hist`
--

CREATE TABLE `xpo_hist` (
  `id` int(11) NOT NULL,
  `xpo_domain` varchar(10) NOT NULL,
  `xpo_nbr` varchar(15) NOT NULL,
  `xpo_line` int(11) NOT NULL,
  `xpo_part` varchar(50) NOT NULL,
  `xpo_desc` varchar(100) NOT NULL,
  `xpo_um` varchar(5) NOT NULL,
  `xpo_qty_ord` decimal(10,2) NOT NULL,
  `xpo_qty_rcvd` decimal(10,2) DEFAULT NULL,
  `xpo_qty_open` decimal(10,2) DEFAULT NULL,
  `xpo_qty_ship` decimal(10,2) DEFAULT NULL,
  `xpo_qty_tole` decimal(10,2) DEFAULT NULL,
  `xpo_qty_prom` decimal(10,2) DEFAULT NULL,
  `xpo_price` varchar(20) NOT NULL,
  `xpo_loc` varchar(15) DEFAULT NULL,
  `xpo_lot` varchar(20) DEFAULT NULL,
  `xpo_ship_date` date DEFAULT NULL,
  `xpo_due_date` date NOT NULL,
  `xpo_eff_date` date DEFAULT NULL,
  `xpo_prom_date` date DEFAULT NULL,
  `xpo_status` varchar(50) NOT NULL DEFAULT 'UnConfirm',
  `xpo_site` varchar(10) DEFAULT NULL,
  `xpo_vend` varchar(10) NOT NULL,
  `xpo_total` decimal(10,2) NOT NULL,
  `xpo_crt_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xpo_hist`
--

INSERT INTO `xpo_hist` (`id`, `xpo_domain`, `xpo_nbr`, `xpo_line`, `xpo_part`, `xpo_desc`, `xpo_um`, `xpo_qty_ord`, `xpo_qty_rcvd`, `xpo_qty_open`, `xpo_qty_ship`, `xpo_qty_tole`, `xpo_qty_prom`, `xpo_price`, `xpo_loc`, `xpo_lot`, `xpo_ship_date`, `xpo_due_date`, `xpo_eff_date`, `xpo_prom_date`, `xpo_status`, `xpo_site`, `xpo_vend`, `xpo_total`, `xpo_crt_date`, `created_at`, `updated_at`) VALUES
(7749, '10USA', 'RCP6', 1, 'METANOL', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '500', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-29 21:18:46', '2020-07-29 21:18:46'),
(7750, '10USA', 'RCP6', 1, 'METANOL', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '500', '030', '', NULL, '2020-07-29', NULL, NULL, 'Confirm', NULL, '10S1003', '0.00', NULL, '2020-07-29 21:27:21', '2020-07-29 21:27:21'),
(7751, '10USA', 'RCP6', 1, 'METANOL', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '500', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10S1003', '0.00', NULL, '2020-07-29 21:40:14', '2020-07-29 21:40:14'),
(7754, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Closed', NULL, '10S1004', '0.00', NULL, '2020-07-29 22:06:24', '2020-07-29 22:06:24'),
(7756, '10USA', 'WP000033', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '200.00', '0.00', '200.00', NULL, NULL, '200.00', '900000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Closed', NULL, '10S1004', '0.00', NULL, '2020-07-30 00:14:36', '2020-07-30 00:14:36'),
(7758, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 00:15:23', '2020-07-30 00:15:23'),
(7759, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 00:15:30', '2020-07-30 00:15:30'),
(7761, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 00:15:53', '2020-07-30 00:15:53'),
(7762, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 00:16:02', '2020-07-30 00:16:02'),
(7764, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 01:10:58', '2020-07-30 01:10:58'),
(7765, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 01:10:58', '2020-07-30 01:10:58'),
(7767, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 01:10:58', '2020-07-30 01:10:58'),
(7768, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 01:10:58', '2020-07-30 01:10:58'),
(7770, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 01:11:01', '2020-07-30 01:11:01'),
(7771, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 01:11:01', '2020-07-30 01:11:01'),
(7772, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 01:11:01', '2020-07-30 01:11:01'),
(7774, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 01:11:04', '2020-07-30 01:11:04'),
(7775, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 01:11:04', '2020-07-30 01:11:04'),
(7776, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 01:11:05', '2020-07-30 01:11:05'),
(7777, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Confirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:02:56', '2020-07-30 02:02:56'),
(7779, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:07:06', '2020-07-30 02:07:06'),
(7780, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:07:16', '2020-07-30 02:07:16'),
(7781, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:07:24', '2020-07-30 02:07:24'),
(7783, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:07:45', '2020-07-30 02:07:45'),
(7784, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:07:53', '2020-07-30 02:07:53'),
(7785, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:08:06', '2020-07-30 02:08:06'),
(7787, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:08:25', '2020-07-30 02:08:25'),
(7788, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:08:42', '2020-07-30 02:08:42'),
(7789, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:08:52', '2020-07-30 02:08:52'),
(7791, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:09:25', '2020-07-30 02:09:25'),
(7792, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:09:32', '2020-07-30 02:09:32'),
(7793, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:09:41', '2020-07-30 02:09:41'),
(7794, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:09:57', '2020-07-30 02:09:57'),
(7796, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:10:11', '2020-07-30 02:10:11'),
(7797, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:10:12', '2020-07-30 02:10:12'),
(7798, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:10:12', '2020-07-30 02:10:12'),
(7799, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:10:12', '2020-07-30 02:10:12'),
(7800, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:44', '2020-07-30 02:12:44'),
(7802, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:44', '2020-07-30 02:12:44'),
(7803, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:12:44', '2020-07-30 02:12:44'),
(7804, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:44', '2020-07-30 02:12:44'),
(7805, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:12:44', '2020-07-30 02:12:44'),
(7806, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:44', '2020-07-30 02:12:44'),
(7808, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:44', '2020-07-30 02:12:44'),
(7809, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:12:44', '2020-07-30 02:12:44'),
(7810, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:44', '2020-07-30 02:12:44'),
(7811, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:12:44', '2020-07-30 02:12:44'),
(7812, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:44', '2020-07-30 02:12:44'),
(7814, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:44', '2020-07-30 02:12:44'),
(7815, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7816, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7817, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7818, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7820, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7821, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7822, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7823, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7824, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7826, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7827, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7828, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7829, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:12:45', '2020-07-30 02:12:45'),
(7830, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:48', '2020-07-30 02:12:48'),
(7832, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:49', '2020-07-30 02:12:49'),
(7833, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:12:49', '2020-07-30 02:12:49'),
(7834, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:12:49', '2020-07-30 02:12:49'),
(7835, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:12:49', '2020-07-30 02:12:49'),
(7836, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7838, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7839, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7840, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7841, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7842, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7844, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7845, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7846, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7847, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7848, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7850, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7851, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7852, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7853, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:15:09', '2020-07-30 02:15:09'),
(7854, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:10', '2020-07-30 02:15:10'),
(7856, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:10', '2020-07-30 02:15:10'),
(7857, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:15:10', '2020-07-30 02:15:10'),
(7858, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:10', '2020-07-30 02:15:10'),
(7859, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:15:10', '2020-07-30 02:15:10'),
(7860, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:10', '2020-07-30 02:15:10'),
(7862, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:10', '2020-07-30 02:15:10'),
(7863, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:15:10', '2020-07-30 02:15:10'),
(7864, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:10', '2020-07-30 02:15:10'),
(7865, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:15:10', '2020-07-30 02:15:10'),
(7866, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:13', '2020-07-30 02:15:13'),
(7868, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:14', '2020-07-30 02:15:14'),
(7869, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:15:14', '2020-07-30 02:15:14'),
(7870, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:15:14', '2020-07-30 02:15:14'),
(7871, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:15:14', '2020-07-30 02:15:14'),
(7872, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:15', '2020-07-30 02:49:15'),
(7874, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:15', '2020-07-30 02:49:15'),
(7875, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:15', '2020-07-30 02:49:15'),
(7876, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'Rejected', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:15', '2020-07-30 02:49:15'),
(7877, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:49:15', '2020-07-30 02:49:15'),
(7878, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:18', '2020-07-30 02:49:18'),
(7879, '10USA', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:18', '2020-07-30 02:49:18'),
(7880, '10USA', 'RCP11', 2, 'PANADOL', 'PANADOL TEST ITEM ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:19', '2020-07-30 02:49:19'),
(7881, '10USA', 'RCP11', 3, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '50', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:19', '2020-07-30 02:49:19'),
(7883, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:19', '2020-07-30 02:49:19'),
(7884, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:19', '2020-07-30 02:49:19'),
(7885, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'Rejected', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:19', '2020-07-30 02:49:19'),
(7886, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7887, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7888, '10USA', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7889, '10USA', 'RCP11', 2, 'PANADOL', 'PANADOL TEST ITEM ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7890, '10USA', 'RCP11', 3, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '50', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7892, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7893, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7894, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'Rejected', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7895, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7896, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7897, '10USA', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7898, '10USA', 'RCP11', 2, 'PANADOL', 'PANADOL TEST ITEM ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7899, '10USA', 'RCP11', 3, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '50', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7901, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:20', '2020-07-30 02:49:20'),
(7902, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:21', '2020-07-30 02:49:21'),
(7903, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'Rejected', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:21', '2020-07-30 02:49:21'),
(7904, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:49:21', '2020-07-30 02:49:21'),
(7905, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:21', '2020-07-30 02:49:21'),
(7906, '10USA', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:21', '2020-07-30 02:49:21'),
(7907, '10USA', 'RCP11', 2, 'PANADOL', 'PANADOL TEST ITEM ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:21', '2020-07-30 02:49:21'),
(7908, '10USA', 'RCP11', 3, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '50', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:21', '2020-07-30 02:49:21'),
(7910, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:21', '2020-07-30 02:49:21'),
(7911, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:21', '2020-07-30 02:49:21'),
(7912, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'Rejected', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:21', '2020-07-30 02:49:21'),
(7913, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:49:21', '2020-07-30 02:49:21'),
(7914, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:22', '2020-07-30 02:49:22'),
(7915, '10USA', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:22', '2020-07-30 02:49:22'),
(7916, '10USA', 'RCP11', 2, 'PANADOL', 'PANADOL TEST ITEM ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:22', '2020-07-30 02:49:22'),
(7917, '10USA', 'RCP11', 3, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '50', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:22', '2020-07-30 02:49:22'),
(7919, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:22', '2020-07-30 02:49:22'),
(7920, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:22', '2020-07-30 02:49:22'),
(7921, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'Rejected', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:22', '2020-07-30 02:49:22'),
(7922, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:49:22', '2020-07-30 02:49:22'),
(7923, '10USA', 'RCP10', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '999999999', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26'),
(7924, '10USA', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26'),
(7925, '10USA', 'RCP11', 2, 'PANADOL', 'PANADOL TEST ITEM ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26'),
(7926, '10USA', 'RCP11', 3, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '50', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26'),
(7928, '10USA', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '700', '030', '', NULL, '2020-07-29', NULL, NULL, 'Approved', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26'),
(7929, '10USA', 'RCP8', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '1500.00', '0.00', '1500.00', NULL, NULL, '1500.00', '50000', '030', '', NULL, '2020-07-29', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26'),
(7930, '10USA', 'RCP9', 1, 'paracetamol', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '100', '030', '', NULL, '2020-07-29', NULL, NULL, 'Rejected', NULL, '10s1003', '0.00', NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26'),
(7931, '10USA', 'WP000034', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '470.00', '0.00', '470.00', NULL, NULL, '470.00', '800000', '030', '', NULL, '2020-07-31', NULL, NULL, 'Confirm', NULL, '10S1004', '0.00', NULL, '2020-07-30 02:49:26', '2020-07-30 02:49:26'),
(7932, '10USA', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '150.00', '0.00', '150.00', NULL, NULL, '150.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'Confirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:50:05', '2020-07-30 02:50:05'),
(7933, '10USA', 'RCP11', 2, 'PANADOL', 'PANADOL TEST ITEM ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '20', '030', '', NULL, '2020-07-29', NULL, NULL, 'Confirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:50:05', '2020-07-30 02:50:05'),
(7934, '10USA', 'RCP11', 3, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '100.00', '0.00', '100.00', NULL, NULL, '100.00', '50', '030', '', NULL, '2020-07-29', NULL, NULL, 'Confirm', NULL, '10S1003', '0.00', NULL, '2020-07-30 02:50:05', '2020-07-30 02:50:05'),
(7935, '10USA', 'testact', 1, '01010', 'tes9999 text123', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '0', '010', '', NULL, '2021-06-07', NULL, NULL, 'Approved', NULL, '10-200', '0.00', NULL, '2021-06-07 04:06:00', '2021-06-07 04:06:00'),
(7936, '10USA', 'testact', 2, '01020', 'wwewqeqweqwe ', 'EA', '1.00', '0.00', '1.00', NULL, NULL, '1.00', '0', '010', '', NULL, '2021-06-07', NULL, NULL, 'Approved', NULL, '10-200', '0.00', NULL, '2021-06-07 04:06:00', '2021-06-07 04:06:00'),
(7937, '10USA', 'testact', 3, 'METANOL', ' ', 'EA', '50.00', '0.00', '50.00', NULL, NULL, '50.00', '0', '', '', NULL, '2021-06-07', NULL, NULL, 'Approved', NULL, '10-200', '0.00', NULL, '2021-06-07 04:06:00', '2021-06-07 04:06:00'),
(7938, '10USA', 'testact', 4, 'panadol', ' ', 'EA', '50.00', '0.00', '50.00', NULL, NULL, '50.00', '0', '', '', NULL, '2021-06-07', NULL, NULL, 'Approved', NULL, '10-200', '0.00', NULL, '2021-06-07 04:06:00', '2021-06-07 04:06:00'),
(7939, '10USA', 'testpo', 1, '010106', ' ', 'EA', '5.00', '0.00', '5.00', NULL, NULL, '5.00', '0', '', '', NULL, '2021-06-16', NULL, NULL, 'UnConfirm', NULL, '10S1003', '0.00', NULL, '2021-06-16 05:45:57', '2021-06-16 05:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `xpo_mstrs`
--

CREATE TABLE `xpo_mstrs` (
  `id` int(11) NOT NULL,
  `xpo_domain` varchar(10) NOT NULL,
  `xpo_nbr` varchar(15) NOT NULL,
  `xpo_ord_date` date DEFAULT NULL,
  `xpo_vend` varchar(10) DEFAULT NULL,
  `xpo_ship` varchar(10) DEFAULT NULL,
  `xpo_due_date` date DEFAULT NULL,
  `xpo_curr` varchar(5) DEFAULT NULL,
  `xpo_rev` varchar(100) DEFAULT NULL,
  `xpo_status` varchar(50) DEFAULT NULL,
  `xpo_crt_date` date DEFAULT NULL,
  `xpo_crt_usr` varchar(20) DEFAULT NULL,
  `xpo_last_conf` date DEFAULT NULL,
  `xpo_total_conf` int(11) DEFAULT 0,
  `xpo_app_flg` varchar(5) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `xpo_total` decimal(10,2) NOT NULL,
  `xpo_ppn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xpo_mstrs`
--

INSERT INTO `xpo_mstrs` (`id`, `xpo_domain`, `xpo_nbr`, `xpo_ord_date`, `xpo_vend`, `xpo_ship`, `xpo_due_date`, `xpo_curr`, `xpo_rev`, `xpo_status`, `xpo_crt_date`, `xpo_crt_usr`, `xpo_last_conf`, `xpo_total_conf`, `xpo_app_flg`, `created_at`, `updated_at`, `xpo_total`, `xpo_ppn`) VALUES
(1, '10USA', 'RCP10', '2021-03-31', '10s1003', '10-100', '2021-04-01', 'USD', NULL, 'Confirmed', '2021-03-28', NULL, NULL, 0, '1', '2020-07-30 02:12:01', '2020-07-30 02:49:14', '99999999.99', 75000000),
(2, '10USA', 'RCP11', '2021-04-02', '10S1003', '10-100', '2021-04-03', 'USD', NULL, 'Confirmed', '2021-04-01', NULL, NULL, 0, '2', '2020-07-30 02:49:15', '2020-07-30 02:49:15', '10600.00', 600),
(3, '10USA', 'RCP6', '2021-03-19', '10S1003', '10-100', '2021-03-22', 'USD', NULL, 'Confirmed', '2021-02-28', NULL, NULL, 0, '2', '2020-07-29 21:18:40', '2020-07-30 02:49:20', '75000.00', 0),
(4, '10USA', 'RCP7', '2021-03-18', '10s1003', '10-100', '2021-03-22', 'USD', NULL, 'Confirmed', '2021-02-28', NULL, NULL, 0, '2', '2020-07-30 00:14:40', '2020-07-30 02:49:20', '105000.00', 0),
(5, '10USA', 'RCP8', '2021-02-28', '10S1003', '10-100', '2021-03-01', 'USD', NULL, 'UnConfirm', '2021-02-20', NULL, NULL, 0, '1', '2020-07-30 01:10:58', '2020-07-30 02:49:21', '80625000.00', 5625000),
(6, '10USA', 'RCP9', '2021-02-28', '10s1003', '10-100', '2021-03-01', 'USD', NULL, 'UnConfirm', '2021-02-18', NULL, NULL, 0, '1', '2020-07-30 02:08:55', '2020-07-30 02:49:22', '16125.00', 1125),
(7, '10USA', 'WP000034', '2021-02-28', '10S1004', '10S1004', '2021-03-01', 'USD', NULL, 'Confirmed', '2021-02-15', NULL, NULL, 0, '1', '2020-07-29 22:06:24', '2020-07-30 02:49:25', '99999999.99', 0),
(10, '10USA', 'testact', '2021-06-07', '10-200', '10-100', '2021-06-07', 'USD', NULL, 'Approved', '2021-06-07', NULL, NULL, 0, '1', '2021-06-07 04:06:00', '2021-06-07 04:13:59', '0.00', 0),
(38, '10USA', 'testpo', '2021-06-16', '10S1003', '10-100', '2021-06-16', 'USD', NULL, 'UnConfirm', '2021-06-16', NULL, NULL, 0, '1', '2021-06-16 05:45:53', '2021-06-16 05:45:53', '0.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `xpo_receipt`
--

CREATE TABLE `xpo_receipt` (
  `xpo_rcp_id` int(11) NOT NULL,
  `xpo_domain` varchar(10) NOT NULL,
  `xpo_sj_id` varchar(50) NOT NULL,
  `xpo_nbr` varchar(20) NOT NULL,
  `xpo_line` int(11) NOT NULL,
  `xpo_part` varchar(50) NOT NULL,
  `xpo_desc` varchar(100) NOT NULL,
  `xpo_um` varchar(5) NOT NULL,
  `xpo_qty_ord` decimal(10,2) NOT NULL,
  `xpo_qty_rcvd` decimal(10,2) NOT NULL DEFAULT 0.00,
  `xpo_qty_open` decimal(10,2) NOT NULL,
  `xpo_qty_ship` decimal(10,2) NOT NULL,
  `xpo_ship_date` date DEFAULT NULL,
  `xpo_eff_date` date DEFAULT NULL,
  `xpo_due_date` date DEFAULT NULL,
  `xpo_lot` varchar(25) DEFAULT NULL,
  `xpo_loc` varchar(15) DEFAULT NULL,
  `xpo_ref` varchar(225) DEFAULT NULL,
  `xpo_site` varchar(10) DEFAULT NULL,
  `xpo_status` varchar(10) NOT NULL DEFAULT 'Created',
  `xpo_user` varchar(10) NOT NULL,
  `xpo_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xpo_receipt`
--

INSERT INTO `xpo_receipt` (`xpo_rcp_id`, `xpo_domain`, `xpo_sj_id`, `xpo_nbr`, `xpo_line`, `xpo_part`, `xpo_desc`, `xpo_um`, `xpo_qty_ord`, `xpo_qty_rcvd`, `xpo_qty_open`, `xpo_qty_ship`, `xpo_ship_date`, `xpo_eff_date`, `xpo_due_date`, `xpo_lot`, `xpo_loc`, `xpo_ref`, `xpo_site`, `xpo_status`, `xpo_user`, `xpo_created`) VALUES
(335, '10USA', 'SJ002', 'RCP6', 1, 'METANOL', 'NEW ITEM TEST ', 'EA', '150.00', '20.00', '0.00', '20.00', NULL, NULL, '2020-07-29', '', '030', NULL, NULL, 'Created', '52', '2020-07-30 09:59:45'),
(336, '10USA', 'SJ002', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '150.00', '50.00', '50.00', '100.00', '2020-07-31', '2020-07-31', '2020-07-29', '010', '030', NULL, NULL, 'Created', '52', '2020-07-30 09:59:46'),
(337, '10USA', 'SJ002', 'RCP11', 2, 'PANADOL', 'PANADOL TEST ITEM ', 'EA', '100.00', '80.00', '20.00', '80.00', NULL, NULL, '2020-07-29', '', '030', NULL, NULL, 'Created', '52', '2020-07-30 09:59:49'),
(338, '10USA', 'SJ002', 'RCP11', 3, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '100.00', '70.00', '30.00', '70.00', NULL, NULL, '2020-07-29', '', '030', NULL, NULL, 'Created', '52', '2020-07-30 09:59:53'),
(340, '10USA', 'SJ002', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST', 'EA', '150.00', '10.00', '50.00', '100.00', '2020-07-31', '2020-07-31', NULL, '050', '030', NULL, NULL, 'newrow', '52', '2020-07-30 10:18:38'),
(341, '10USA', 'SJ002', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST', 'EA', '150.00', '0.00', '50.00', '100.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'newrow', '52', '2020-07-30 10:18:41'),
(342, '10USA', 'SJ002', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST', 'EA', '150.00', '0.00', '50.00', '100.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'newrow', '52', '2020-07-30 10:18:44'),
(343, '10USA', 'SJ002', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST', 'EA', '150.00', '0.00', '50.00', '100.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'newrow', '52', '2020-07-30 10:18:51'),
(344, '10USA', 'SJ002', 'RCP6', 1, 'METANOL', 'NEW ITEM TEST ', 'EA', '150.00', '20.00', '0.00', '20.00', NULL, NULL, '2020-07-29', '', '030', NULL, NULL, 'Created', '47', '2020-07-30 10:30:04'),
(345, '10USA', 'SJ002', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '150.00', '100.00', '50.00', '100.00', NULL, NULL, '2020-07-29', '', '030', NULL, NULL, 'Created', '47', '2020-07-30 10:30:04'),
(346, '10USA', 'SJ002', 'RCP11', 2, 'PANADOL', 'PANADOL TEST ITEM ', 'EA', '100.00', '80.00', '20.00', '80.00', NULL, NULL, '2020-07-29', '', '030', NULL, NULL, 'Created', '47', '2020-07-30 10:30:04'),
(347, '10USA', 'SJ002', 'RCP11', 3, 'ALCHOHOL', 'PURCHASING ITEM TEST ', 'EA', '100.00', '70.00', '0.00', '70.00', NULL, NULL, '2020-07-29', '', '030', NULL, NULL, 'Created', '47', '2020-07-30 10:30:04'),
(352, '10USA', 'a1', 'RCP11', 1, 'PARACETAMOL', 'NEW ITEM TEST ', 'EA', '150.00', '5.00', '45.00', '5.00', NULL, NULL, '2020-07-29', '', '030', NULL, NULL, 'Created', '4', '2021-01-14 15:07:08'),
(353, '10USA', 'a1', 'RCP7', 1, 'alchohol', 'PURCHASING ITEM TEST ', 'EA', '150.00', '5.00', '85.00', '5.00', NULL, NULL, '2020-07-29', '', '030', NULL, NULL, 'Created', '4', '2021-01-14 15:07:08');

-- --------------------------------------------------------

--
-- Table structure for table `xpurplan_dets`
--

CREATE TABLE `xpurplan_dets` (
  `id` int(11) NOT NULL,
  `rf_number` varchar(50) NOT NULL,
  `supp_code` varchar(50) NOT NULL,
  `line` int(11) NOT NULL,
  `item_code` varchar(100) NOT NULL,
  `item_desc` varchar(255) DEFAULT NULL,
  `qty_req` decimal(10,2) DEFAULT NULL,
  `qty_pro` decimal(10,2) DEFAULT NULL,
  `qty_pur` decimal(10,2) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `due_date` date NOT NULL,
  `propose_date` date DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'New',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xpurplan_dets`
--

INSERT INTO `xpurplan_dets` (`id`, `rf_number`, `supp_code`, `line`, `item_code`, `item_desc`, `qty_req`, `qty_pro`, `qty_pur`, `price`, `due_date`, `propose_date`, `purchase_date`, `status`, `created_at`, `updated_at`) VALUES
(16, 'RP000031', '10S1003', 1, 'ALCHOHOL', NULL, '1.00', NULL, NULL, NULL, '2020-10-30', NULL, NULL, 'Close', '2020-10-26 13:30:50', '2020-10-26 13:30:50'),
(17, 'RP000031', '10S1003', 2, 'METANOL', NULL, '22.00', NULL, NULL, NULL, '2020-11-08', NULL, NULL, 'Close', '2020-10-26 13:30:50', '2020-10-26 13:30:50'),
(18, 'RP000032', '10-200', 1, 'METANOL', NULL, '19.00', NULL, NULL, NULL, '2020-10-31', NULL, NULL, 'Close', '2020-10-27 15:50:19', '2020-10-27 15:50:19'),
(19, 'RP000032', '10-200', 2, 'ALCHOHOL', NULL, '1.00', NULL, NULL, NULL, '2020-11-08', NULL, NULL, 'Close', '2020-10-27 15:50:19', '2020-10-27 15:50:19'),
(20, 'RP000033', '10S1003', 1, 'ALCHOHOL', NULL, '19.00', NULL, NULL, NULL, '2020-11-07', NULL, NULL, 'Close', '2020-10-28 13:23:06', '2020-10-28 13:23:06'),
(21, 'RP000034', '10S1003', 1, 'ALCHOHOL', NULL, '19.00', NULL, NULL, NULL, '2020-10-31', NULL, NULL, 'Close', '2020-10-28 13:31:00', '2020-10-28 13:31:00'),
(22, 'RP000034', '10S1003', 2, 'METANOL', NULL, '20.00', NULL, NULL, NULL, '2020-11-07', NULL, NULL, 'Close', '2020-10-28 13:31:00', '2020-10-28 13:31:00'),
(23, 'RP000035', '10-300', 1, 'ALCHOHOL', NULL, '11.00', NULL, NULL, NULL, '2020-11-08', NULL, NULL, 'Close', '2020-10-28 13:37:47', '2020-10-28 13:37:47'),
(24, 'RP000035', '10-300', 2, 'METANOL', NULL, '19.00', NULL, NULL, NULL, '2021-01-29', NULL, NULL, 'Close', '2020-10-28 13:37:47', '2020-10-28 13:37:47'),
(25, 'RP000036', '10S1003', 1, 'ALCHOHOL', NULL, '9.00', NULL, NULL, NULL, '2020-11-07', NULL, NULL, 'Close', '2020-10-28 14:40:51', '2020-10-28 14:40:51'),
(26, 'RP000036', '10S1003', 2, 'METANOL', NULL, '90.00', NULL, NULL, NULL, '2020-11-07', NULL, NULL, 'Close', '2020-10-28 14:40:51', '2020-10-28 14:40:51'),
(27, 'RP000045', '10-300', 1, 'ALCHOHOL', NULL, '11.00', NULL, NULL, NULL, '2020-11-20', NULL, NULL, 'Close', '2020-11-09 15:04:26', '2020-11-09 15:04:26'),
(28, 'RP000060', '10-300', 1, 'ALCHOHOL', NULL, '15.00', NULL, NULL, NULL, '2020-11-30', NULL, NULL, 'Close', '2020-11-10 10:15:38', '2020-11-10 10:15:38'),
(29, 'RP000065', '10S1005', 1, 'METANOL', NULL, '15.00', NULL, NULL, NULL, '2020-11-12', NULL, NULL, 'Close', '2020-11-11 11:42:07', '2020-11-11 11:42:07'),
(30, 'RP000065', '10S1005', 2, 'panadol', NULL, '25.00', NULL, NULL, NULL, '2020-11-16', NULL, NULL, 'Close', '2020-11-11 11:42:07', '2020-11-11 11:42:07'),
(31, 'RP000066', '10S1003', 1, 'METANOL', NULL, '15.00', NULL, NULL, NULL, '2020-11-13', NULL, NULL, 'Close', '2020-11-11 11:47:36', '2020-11-11 11:47:36'),
(32, 'RP000067', '10S1003', 1, 'panadol', NULL, '15.00', NULL, NULL, NULL, '2020-11-17', NULL, NULL, 'Close', '2020-11-11 11:47:42', '2020-11-11 11:47:42'),
(33, 'RP000067', '10S1003', 2, 'ALCHOHOL', NULL, '20.00', NULL, NULL, NULL, '2020-11-19', NULL, NULL, 'Close', '2020-11-11 11:47:42', '2020-11-11 11:47:42'),
(34, 'RP000068', '10S1003', 1, 'ALCHOHOL', NULL, '15.00', NULL, NULL, NULL, '2020-11-13', NULL, NULL, 'Close', '2020-11-11 11:55:08', '2020-11-11 11:55:08'),
(35, 'RP000068', '10S1003', 2, 'METANOL', NULL, '20.00', NULL, NULL, NULL, '2020-11-16', NULL, NULL, 'Close', '2020-11-11 11:55:08', '2020-11-11 11:55:08'),
(36, 'RP000068', '10S1003', 3, 'panadol', NULL, '25.00', NULL, NULL, NULL, '2020-11-17', NULL, NULL, 'Close', '2020-11-11 11:55:08', '2020-11-11 11:55:08'),
(37, 'RP000069', '10S1003', 1, 'ALCHOHOL', NULL, '20.00', NULL, NULL, NULL, '2020-11-25', NULL, NULL, 'Close', '2020-11-11 11:55:13', '2020-11-11 11:55:13'),
(38, 'RP000069', '10S1003', 2, 'METANOL', NULL, '25.00', NULL, NULL, NULL, '2020-11-26', NULL, NULL, 'Close', '2020-11-11 11:55:13', '2020-11-11 11:55:13'),
(39, 'RP000069', '10S1003', 3, 'panadol', NULL, '20.00', NULL, NULL, NULL, '2020-12-02', NULL, NULL, 'Close', '2020-11-11 11:55:13', '2020-11-11 11:55:13'),
(40, 'RP000071', '10S1003', 1, 'panadol', NULL, '15.00', NULL, NULL, NULL, '2020-11-16', NULL, NULL, 'Close', '2020-11-11 12:23:24', '2020-11-11 12:23:24'),
(41, 'RP000071', '10S1003', 2, 'ALCHOHOL', NULL, '20.00', NULL, NULL, NULL, '2020-11-18', NULL, NULL, 'Close', '2020-11-11 12:23:24', '2020-11-11 12:23:24'),
(42, 'RP000070', '10S1003', 1, 'ALCHOHOL', NULL, '15.00', NULL, NULL, NULL, '2020-11-13', NULL, NULL, 'Close', '2020-11-11 12:23:31', '2020-11-11 12:23:31'),
(43, 'RP000070', '10S1003', 2, 'METANOL', NULL, '25.00', NULL, NULL, NULL, '2020-11-14', NULL, NULL, 'Close', '2020-11-11 12:23:31', '2020-11-11 12:23:31'),
(44, 'RP000054', '10S1003', 1, 'ALCHOHOL', NULL, '15.00', NULL, NULL, NULL, '2020-11-11', NULL, NULL, 'Close', '2020-11-11 12:51:21', '2020-11-11 12:51:21'),
(45, 'RP000085', '10-300', 1, 'panadol', NULL, '19.00', NULL, NULL, NULL, '2020-11-26', NULL, NULL, 'Close', '2020-11-13 15:01:19', '2020-11-13 15:01:19'),
(46, 'RP000087', '10S1003', 1, 'METANOL', NULL, '95.00', NULL, NULL, NULL, '2020-12-05', NULL, NULL, 'Close', '2020-11-25 17:39:28', '2020-11-25 17:39:28'),
(47, 'RP000088', '10-300', 1, 'METANOL', NULL, '80.00', NULL, NULL, NULL, '2020-11-30', NULL, NULL, 'Close', '2020-11-25 17:49:29', '2020-11-25 17:49:29'),
(48, 'RP000088', '10-300', 1, 'METANOL', NULL, '80.00', NULL, NULL, NULL, '2020-11-30', NULL, NULL, 'Close', '2020-11-25 17:53:31', '2020-11-25 17:53:31'),
(49, 'RP000089', '10-200', 1, 'METANOL', NULL, '55.00', NULL, NULL, NULL, '2020-12-05', NULL, NULL, 'Close', '2020-11-25 17:55:48', '2020-11-25 17:55:48'),
(50, 'RP000090', '10-300', 1, 'panadol', NULL, '65.00', NULL, NULL, NULL, '2020-11-28', NULL, NULL, 'Close', '2020-11-25 18:06:31', '2020-11-25 18:06:31'),
(51, 'RP000091', '10-200', 1, 'ALCHOHOL', NULL, '90.00', NULL, NULL, NULL, '2020-11-28', NULL, NULL, 'Close', '2020-11-25 18:19:09', '2020-11-25 18:19:09'),
(52, 'RP000091', '10-200', 2, 'panadol', NULL, '100.00', NULL, NULL, NULL, '2020-12-25', NULL, NULL, 'Close', '2020-11-25 18:19:09', '2020-11-25 18:19:09'),
(53, 'RP000092', '10-200', 1, 'panadol', NULL, '900.00', NULL, NULL, NULL, '2020-11-28', NULL, NULL, 'Close', '2020-11-25 18:39:02', '2020-11-25 18:39:02'),
(54, 'RP000092', '10-200', 2, 'ALCHOHOL', NULL, '8.00', NULL, NULL, NULL, '2020-12-11', NULL, NULL, 'Close', '2020-11-25 18:39:02', '2020-11-25 18:39:02'),
(55, 'RP000093', '10S1003', 1, 'ALCHOHOL', NULL, '77.00', NULL, NULL, NULL, '2020-12-05', NULL, NULL, 'Close', '2020-11-26 09:06:25', '2020-11-26 09:06:25'),
(56, 'RP000093', '10S1003', 2, 'PARACETAMOL', NULL, '10.00', NULL, NULL, NULL, '2020-11-28', NULL, NULL, 'Close', '2020-11-26 09:06:25', '2020-11-26 09:06:25'),
(57, 'RP000093', '10S1003', 3, 'panadol', NULL, '55.00', NULL, NULL, NULL, '2020-12-12', NULL, NULL, 'Close', '2020-11-26 09:06:25', '2020-11-26 09:06:25'),
(58, 'RP000093', '10S1003', 4, 'METANOL', NULL, '222.00', NULL, NULL, NULL, '2021-01-21', NULL, NULL, 'Close', '2020-11-26 09:06:25', '2020-11-26 09:06:25'),
(59, 'RP000094', '10-200', 1, 'panadol', NULL, '90.00', NULL, NULL, NULL, '2020-11-27', NULL, NULL, 'Close', '2020-11-26 16:06:49', '2020-11-26 16:06:49'),
(60, 'RP000094', '10-200', 2, 'ALCHOHOL', NULL, '11.00', NULL, NULL, NULL, '2020-11-28', NULL, NULL, 'Close', '2020-11-26 16:06:49', '2020-11-26 16:06:49'),
(61, 'RP000094', '10-200', 3, 'METANOL', NULL, '66.00', NULL, NULL, NULL, '2020-11-28', NULL, NULL, 'Close', '2020-11-26 16:06:49', '2020-11-26 16:06:49'),
(62, 'RP000094', '10-200', 4, 'PARACETAMOL', NULL, '22.00', NULL, NULL, NULL, '2020-12-09', NULL, NULL, 'Close', '2020-11-26 16:06:49', '2020-11-26 16:06:49'),
(63, 'RP000098', '10-300', 1, 'ALCHOHOL', NULL, '200.00', NULL, NULL, NULL, '2021-01-02', NULL, NULL, 'Close', '2020-12-30 17:13:04', '2020-12-30 17:13:04'),
(64, 'RP000098', '10-300', 2, 'METANOL', NULL, '10.00', NULL, NULL, NULL, '2021-01-09', NULL, NULL, 'Close', '2020-12-30 17:13:04', '2020-12-30 17:13:04'),
(65, 'RP000108', '10S1004', 1, 'ALCHOHOL', NULL, '700.00', NULL, NULL, NULL, '2021-01-27', NULL, NULL, 'New', '2021-01-18 10:54:36', '2021-01-18 10:54:36'),
(66, 'RP000108', '10S1004', 2, 'METANOL', NULL, '500.00', NULL, NULL, NULL, '2021-01-29', NULL, NULL, 'New', '2021-01-18 10:54:36', '2021-01-18 10:54:36'),
(67, 'RP000106', '10S1003', 1, 'METANOL', NULL, '5000.00', NULL, NULL, NULL, '2021-01-21', NULL, NULL, 'Close', '2021-01-18 10:54:48', '2021-01-18 10:54:48'),
(68, 'RP000106', '10S1003', 2, 'PARACETAMOL', NULL, '5500.00', NULL, NULL, NULL, '2021-01-26', NULL, NULL, 'Close', '2021-01-18 10:54:48', '2021-01-18 10:54:48'),
(69, 'RF000075', '10S1004', 1, 'ALCHOHOL', '', '12.00', '10.00', '10.00', NULL, '2020-10-12', '2021-01-20', '2021-01-21', 'Close', '2021-01-18 12:33:02', '2021-01-18 12:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `xpurplan_mstrs`
--

CREATE TABLE `xpurplan_mstrs` (
  `id` int(11) NOT NULL,
  `rf_number` varchar(50) NOT NULL,
  `supp_code` varchar(50) NOT NULL,
  `site` varchar(24) NOT NULL,
  `due_date` date NOT NULL,
  `propose_date` date DEFAULT NULL,
  `rf_from` int(11) NOT NULL,
  `status` varchar(10) DEFAULT 'New',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xpurplan_mstrs`
--

INSERT INTO `xpurplan_mstrs` (`id`, `rf_number`, `supp_code`, `site`, `due_date`, `propose_date`, `rf_from`, `status`, `created_at`, `updated_at`) VALUES
(9, 'RP000031', '10S1003', '', '2020-11-08', NULL, 2, 'Close', '2020-10-26 13:30:50', '2020-10-26 13:30:50'),
(10, 'RP000032', '10-200', '', '2020-11-08', NULL, 2, 'Close', '2020-10-27 15:50:19', '2020-10-27 15:50:19'),
(11, 'RP000033', '10S1003', '10-100', '2020-11-07', NULL, 2, 'Close', '2020-10-28 13:23:06', '2020-10-28 13:23:06'),
(12, 'RP000034', '10S1003', '10-200', '2020-11-07', NULL, 2, 'Close', '2020-10-28 13:31:00', '2020-10-28 13:31:00'),
(13, 'RP000035', '10-300', '10-200', '2021-01-29', NULL, 2, 'Close', '2020-10-28 13:37:47', '2020-10-28 13:37:47'),
(14, 'RP000036', '10S1003', '10-300', '2020-11-07', NULL, 2, 'Close', '2020-10-28 14:40:51', '2020-10-28 14:40:51'),
(15, 'RP000045', '10-300', '10-100', '2020-11-20', NULL, 2, 'Close', '2020-11-09 15:04:26', '2020-11-09 15:04:26'),
(16, 'RP000060', '10-300', '10-200', '2020-11-30', NULL, 2, 'Close', '2020-11-10 10:15:38', '2020-11-10 10:15:38'),
(17, 'RP000065', '10S1005', '10-300', '2020-11-16', NULL, 2, 'Close', '2020-11-11 11:42:07', '2020-11-11 11:42:07'),
(18, 'RP000066', '10S1003', '10-300', '2020-11-13', NULL, 2, 'Close', '2020-11-11 11:47:36', '2020-11-11 11:47:36'),
(19, 'RP000067', '10S1003', '10-300', '2020-11-19', NULL, 2, 'Close', '2020-11-11 11:47:42', '2020-11-11 11:47:42'),
(20, 'RP000068', '10S1003', '10-300', '2020-11-17', NULL, 2, 'Close', '2020-11-11 11:55:08', '2020-11-11 11:55:08'),
(21, 'RP000069', '10S1003', '10-300', '2020-12-02', NULL, 2, 'Close', '2020-11-11 11:55:13', '2020-11-11 11:55:13'),
(22, 'RP000071', '10S1003', '10-200', '2020-11-18', NULL, 2, 'Close', '2020-11-11 12:23:24', '2020-11-11 12:23:24'),
(23, 'RP000070', '10S1003', '10-300', '2020-11-14', NULL, 2, 'Close', '2020-11-11 12:23:31', '2020-11-11 12:23:31'),
(24, 'RP000054', '10S1003', '10-300', '2020-11-11', NULL, 2, 'Close', '2020-11-11 12:51:21', '2020-11-11 12:51:21'),
(25, 'RP000085', '10-300', '10-100', '2020-11-26', NULL, 2, 'Close', '2020-11-13 15:01:19', '2020-11-13 15:01:19'),
(26, 'RP000087', '10S1003', '10-100', '2020-12-05', NULL, 2, 'Close', '2020-11-25 17:39:28', '2020-11-25 17:39:28'),
(27, 'RP000088', '10-300', '10-300', '2020-11-30', NULL, 2, 'Close', '2020-11-25 17:49:29', '2020-11-25 17:49:29'),
(28, 'RP000088', '10-300', '10-300', '2020-11-30', NULL, 2, 'Close', '2020-11-25 17:53:31', '2020-11-25 17:53:31'),
(29, 'RP000089', '10-200', '10-200', '2020-12-05', NULL, 2, 'Close', '2020-11-25 17:55:48', '2020-11-25 17:55:48'),
(30, 'RP000090', '10-300', '10-200', '2020-11-28', NULL, 2, 'Close', '2020-11-25 18:06:31', '2020-11-25 18:06:31'),
(31, 'RP000091', '10-200', '10-300', '2020-12-25', NULL, 2, 'New', '2020-11-25 18:19:09', '2020-11-25 18:19:09'),
(32, 'RP000092', '10-200', '10-200', '2020-12-11', NULL, 2, 'New', '2020-11-25 18:39:02', '2020-11-25 18:39:02'),
(34, 'RP000094', '10-200', '10-200', '2020-12-09', NULL, 2, 'Close', '2020-11-26 16:06:49', '2020-11-26 16:06:49'),
(35, 'RP000098', '10-300', '10-200', '2021-01-09', NULL, 2, 'Close', '2020-12-30 17:13:04', '2020-12-30 17:13:04'),
(36, 'RP000108', '10S1004', '10-200', '2021-01-29', NULL, 2, 'New', '2021-01-18 10:54:36', '2021-01-18 10:54:36'),
(37, 'RP000106', '10S1003', '10-200', '2021-01-26', NULL, 2, 'Close', '2021-01-18 10:54:48', '2021-01-18 10:54:48'),
(38, 'RF000075', '10S1004', '10-200', '2020-10-12', '2021-01-20', 1, 'Close', '2021-01-18 12:33:02', '2021-01-18 12:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `xpurplan_temp`
--

CREATE TABLE `xpurplan_temp` (
  `id` int(11) NOT NULL,
  `rf_number` varchar(50) NOT NULL,
  `supp_code` varchar(50) NOT NULL,
  `site` varchar(24) NOT NULL,
  `line` int(11) NOT NULL,
  `item_code` varchar(50) NOT NULL,
  `qty_req` decimal(10,2) DEFAULT NULL,
  `qty_pro` decimal(10,2) DEFAULT NULL,
  `qty_pur` decimal(10,2) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `propose_date` date DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xpurplan_temp`
--

INSERT INTO `xpurplan_temp` (`id`, `rf_number`, `supp_code`, `site`, `line`, `item_code`, `qty_req`, `qty_pro`, `qty_pur`, `price`, `due_date`, `propose_date`, `purchase_date`, `username`) VALUES
(1246, 'RP000098', '10-300', '10-200', 1, 'ALCHOHOL', '200.00', NULL, NULL, NULL, '2021-01-02', NULL, NULL, 'test2'),
(1247, 'RP000098', '10-300', '10-200', 2, 'METANOL', '10.00', NULL, NULL, NULL, '2021-01-09', NULL, NULL, 'test2'),
(1272, 'RP000098', '10-300', '10-200', 1, 'ALCHOHOL', '200.00', NULL, NULL, NULL, '2021-01-02', NULL, NULL, 'rio'),
(1273, 'RP000098', '10-300', '10-200', 2, 'METANOL', '10.00', NULL, NULL, NULL, '2021-01-09', NULL, NULL, 'rio'),
(1279, 'RF000075', '10S1004', '10-200', 1, 'ALCHOHOL', '12.00', '10.00', '10.00', NULL, '2020-10-12', '2021-01-20', '2021-01-21', 'adm1'),
(0, 'RF000075', '10S1004', '10-200', 1, 'ALCHOHOL', '12.00', '10.00', '10.00', 50000, '2020-10-12', '2021-01-20', '2021-01-21', 'mfg');

-- --------------------------------------------------------

--
-- Table structure for table `xrfp_app_hist`
--

CREATE TABLE `xrfp_app_hist` (
  `id` int(11) NOT NULL,
  `xrfp_app_nbr` varchar(24) NOT NULL,
  `xrfp_app_approver` varchar(50) NOT NULL,
  `xrfp_app_alt_approver` varchar(50) NOT NULL,
  `xrfp_app_order` int(11) DEFAULT NULL,
  `xrfp_app_reason` varchar(255) DEFAULT NULL,
  `xrfp_app_user` varchar(50) DEFAULT NULL,
  `xrfp_app_status` int(11) NOT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xrfp_app_hist`
--

INSERT INTO `xrfp_app_hist` (`id`, `xrfp_app_nbr`, `xrfp_app_approver`, `xrfp_app_alt_approver`, `xrfp_app_order`, `xrfp_app_reason`, `xrfp_app_user`, `xrfp_app_status`, `create_at`) VALUES
(124, 'RP000075', '62', '47', 1, NULL, 'test1', 2, '2020-11-12 13:47:17'),
(125, 'RP000078', '62', '47', 1, 'rejekkk', 'test1', 2, '2020-11-12 14:06:49'),
(126, 'RP000079', '62', '47', 1, 'okdeh', 'test1', 2, '2020-11-12 14:52:22'),
(127, 'RP000077', '62', '47', 1, NULL, 'test1', 1, '2020-11-12 13:44:16'),
(128, 'RP000077', '63', '59', 2, 'the end', 'test2', 1, '2020-11-12 15:47:25'),
(129, 'RP000080', '62', '47', 1, 'Hei', 'test1', 1, '2020-11-12 15:55:18'),
(130, 'RP000080', '63', '59', 2, 'eok', 'test2', 1, '2020-11-12 15:55:50'),
(131, 'RP000081', '62', '47', 1, NULL, 'test1', 1, '2020-11-12 15:59:38'),
(132, 'RP000081', '63', '59', 2, 'gegegege', 'test2', 1, '2020-11-12 16:00:16'),
(133, 'RP000082', '45', '46', 1, 'RFP is ok', 'Bintang', 1, '2020-11-13 13:03:17'),
(134, 'RP000086', '62', '47', 1, NULL, 'test1', 1, '2020-11-13 15:00:33'),
(135, 'RP000086', '63', '59', 2, NULL, 'test2', 1, '2020-11-13 15:01:07'),
(136, 'RP000084', '62', '47', 1, NULL, 'test1', 1, '2020-11-13 14:39:30'),
(137, 'RP000084', '63', '59', 2, NULL, 'test2', 1, '2020-11-13 15:01:13'),
(138, 'RP000085', '62', '47', 1, NULL, 'test1', 1, '2020-11-13 15:00:41'),
(139, 'RP000085', '63', '59', 2, NULL, 'test2', 1, '2020-11-13 15:01:19'),
(140, 'RP000087', '62', '47', 1, 'berhasil', 'test1', 1, '2020-11-25 17:38:51'),
(141, 'RP000087', '63', '59', 2, NULL, 'test2', 1, '2020-11-25 17:39:28'),
(142, 'RP000088', '62', '47', 1, NULL, 'test1', 1, '2020-11-25 17:48:58'),
(143, 'RP000088', '63', '59', 2, NULL, 'test2', 1, '2020-11-25 17:49:29'),
(144, 'RP000089', '62', '47', 1, NULL, 'test1', 1, '2020-11-25 17:55:25'),
(145, 'RP000089', '63', '59', 2, NULL, 'test2', 1, '2020-11-25 17:55:48'),
(146, 'RP000090', '62', '47', 1, NULL, 'test1', 1, '2020-11-25 18:06:06'),
(147, 'RP000090', '63', '59', 2, NULL, 'test2', 1, '2020-11-25 18:06:31'),
(148, 'RP000091', '62', '47', 1, NULL, 'test1', 1, '2020-11-25 18:18:44'),
(149, 'RP000091', '63', '59', 2, NULL, 'test2', 1, '2020-11-25 18:19:09'),
(150, 'RP000092', '62', '47', 1, NULL, 'test1', 1, '2020-11-25 18:37:49'),
(151, 'RP000092', '63', '59', 2, NULL, 'test2', 1, '2020-11-25 18:39:02'),
(152, 'RP000093', '62', '47', 1, NULL, 'test1', 1, '2020-11-26 09:04:59'),
(153, 'RP000093', '63', '59', 2, NULL, 'test2', 1, '2020-11-26 09:06:25'),
(154, 'RP000094', '62', '47', 1, NULL, 'test1', 1, '2020-11-26 16:06:20'),
(155, 'RP000094', '63', '59', 2, NULL, 'test2', 1, '2020-11-26 16:06:49'),
(156, 'RP000079', '62', '47', 1, NULL, 'test1', 2, '2020-11-26 18:24:45'),
(157, 'RP000076', '62', '47', 1, NULL, 'test1', 2, '2020-11-26 18:40:50'),
(158, 'RP000075', '62', '47', 1, NULL, 'test1', 2, '2020-11-27 09:55:16'),
(159, 'RP000075', '62', '47', 1, NULL, 'test1', 1, '2020-12-14 11:25:43'),
(160, 'RP000075', '63', '59', 2, NULL, 'test2', 1, '2020-12-14 11:26:25'),
(161, 'RP000095', '62', '61', 1, NULL, 'test1', 1, '2020-12-14 11:32:46'),
(162, 'RP000095', '63', '59', 2, 'a', 'test2', 1, '2020-12-14 11:39:48'),
(163, 'RP000097', '62', '61', 1, NULL, 'test1', 1, '2020-12-22 09:20:59'),
(164, 'RP000097', '63', '59', 2, NULL, 'test2', 1, '2020-12-22 09:24:04'),
(165, 'RP000098', '62', '61', 1, NULL, 'test1', 1, '2020-12-30 17:11:11'),
(166, 'RP000098', '63', '59', 2, NULL, 'test2', 1, '2020-12-30 17:13:04'),
(167, 'RP000099', '45', '46', 1, NULL, 'Bintang', 1, '2021-01-04 14:28:32'),
(168, 'RP000100', '45', '46', 1, NULL, 'Bintang', 1, '2021-01-04 14:55:19'),
(169, 'RP000096', '62', '61', 1, NULL, 'test1', 1, '2021-01-04 15:06:41'),
(170, 'RP000096', '63', '59', 2, NULL, 'test2', 1, '2021-01-04 15:07:29'),
(171, 'RP000083', '45', '46', 1, NULL, 'Bintang', 1, '2021-01-04 15:35:14'),
(172, 'RP000101', '62', '61', 1, NULL, 'test1', 1, '2021-01-04 15:59:57'),
(173, 'RP000101', '63', '59', 2, NULL, 'test2', 1, '2021-01-04 16:00:27'),
(174, 'RP000102', '62', '61', 1, NULL, 'test1', 1, '2021-01-04 16:15:23'),
(175, 'RP000102', '63', '59', 2, NULL, 'test2', 1, '2021-01-04 16:15:56'),
(176, 'RP000103', '62', '61', 1, NULL, 'test1', 1, '2021-01-04 16:20:45'),
(177, 'RP000104', '62', '61', 1, NULL, 'test1', 1, '2021-01-04 16:24:15'),
(178, 'RP000105', '62', '61', 1, NULL, 'test1', 1, '2021-01-04 16:45:21'),
(179, 'RP000109', '62', '47', 1, 'Price is reasonable', 'test1', 1, '2021-01-18 10:25:24'),
(180, 'RP000109', '63', '47', 2, NULL, 'test2', 1, '2021-01-18 10:54:29'),
(181, 'RP000108', '62', '47', 1, 'Item is needed and proceed', 'Rifky', 1, '2021-01-15 15:29:58'),
(182, 'RP000108', '63', '47', 2, NULL, 'test2', 1, '2021-01-18 10:54:36'),
(183, 'RP000106', '62', '47', 1, NULL, 'test1', 1, '2021-01-18 09:12:01'),
(184, 'RP000106', '63', '47', 2, NULL, 'test2', 1, '2021-01-18 10:54:48'),
(185, 'RP000079', '45', '46', 1, NULL, 'Bintang', 1, '2021-01-18 12:02:39'),
(186, 'RP000115', '45', '46', 1, 'Approved please process!', 'Bintang', 1, '2021-01-20 12:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `xrfp_app_trans`
--

CREATE TABLE `xrfp_app_trans` (
  `id` int(11) NOT NULL,
  `xrfp_app_nbr` varchar(24) NOT NULL,
  `xrfp_app_approver` varchar(24) NOT NULL,
  `xrfp_app_alt_approver` varchar(24) NOT NULL,
  `xrfp_app_order` int(11) DEFAULT NULL,
  `xrfp_app_reason` varchar(256) DEFAULT NULL,
  `xrfp_app_user` varchar(24) DEFAULT NULL,
  `xrfp_app_status` int(11) NOT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xrfp_app_trans`
--

INSERT INTO `xrfp_app_trans` (`id`, `xrfp_app_nbr`, `xrfp_app_approver`, `xrfp_app_alt_approver`, `xrfp_app_order`, `xrfp_app_reason`, `xrfp_app_user`, `xrfp_app_status`, `create_at`) VALUES
(323, 'RP000076', '45', '46', 1, NULL, NULL, 0, '2020-11-26 18:41:33'),
(349, 'RP000110', '62', '47', 1, NULL, 'test1', 1, '2021-01-21 13:58:07'),
(350, 'RP000110', '63', '47', 2, NULL, NULL, 0, '2021-01-20 11:40:44'),
(352, 'RP000116', '62', '61', 1, NULL, NULL, 0, '2021-01-22 08:46:11');

-- --------------------------------------------------------

--
-- Table structure for table `xrfp_control`
--

CREATE TABLE `xrfp_control` (
  `id` int(11) NOT NULL,
  `xrfp_approver` int(12) NOT NULL,
  `rfp_department` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `xrfp_alt_app` int(12) NOT NULL,
  `xorder` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xrfp_control`
--

INSERT INTO `xrfp_control` (`id`, `xrfp_approver`, `rfp_department`, `xrfp_alt_app`, `xorder`) VALUES
(69, 62, 'PT', 47, '1'),
(70, 63, 'PT', 47, '2'),
(107, 45, 'IT', 46, '1'),
(110, 62, 'R&D', 61, '1');

-- --------------------------------------------------------

--
-- Table structure for table `xrfp_dets`
--

CREATE TABLE `xrfp_dets` (
  `id` int(11) NOT NULL,
  `rfp_nbr` varchar(50) NOT NULL,
  `itemcode` varchar(12) NOT NULL,
  `need_date` date NOT NULL,
  `due_date` date NOT NULL,
  `qty_order` decimal(10,2) NOT NULL,
  `um` varchar(10) DEFAULT NULL,
  `created_by` varchar(24) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  `dets_flag` varchar(24) DEFAULT NULL,
  `xrfp_no_po` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xrfp_dets`
--

INSERT INTO `xrfp_dets` (`id`, `rfp_nbr`, `itemcode`, `need_date`, `due_date`, `qty_order`, `um`, `created_by`, `created_at`, `update_at`, `dets_flag`, `xrfp_no_po`) VALUES
(417, 'RP000076', 'ALCHOHOL', '2020-11-12', '2020-12-12', '90.00', 'EA', 'adm1', '2020-11-12 03:54:57', '2020-11-12 03:54:57', 'Open', NULL),
(418, 'RP000076', 'METANOL', '2020-11-12', '2020-12-30', '100.00', 'EA', 'adm1', '2020-11-12 03:54:57', '2020-11-12 03:54:57', 'Open', NULL),
(429, 'RP000077', 'ALCHOHOL', '2020-11-19', '2021-04-14', '6.80', 'EA', 'adm1', '2020-11-12 05:23:26', '2020-11-12 05:23:26', 'Close', NULL),
(430, 'RP000077', 'METANOL', '2020-11-12', '2020-11-30', '79.00', 'EA', 'adm1', '2020-11-12 05:23:26', '2020-11-12 05:23:26', 'Close', NULL),
(432, 'RP000078', 'panadol', '2020-11-12', '2020-12-04', '1.00', 'EA', 'adm1', '2020-11-12 07:34:56', '2020-11-12 07:34:56', 'Open', NULL),
(433, 'RP000078', 'METANOL', '2020-11-12', '2021-02-25', '17.00', 'EA', 'adm1', '2020-11-12 07:34:56', '2020-11-12 07:34:56', 'Open', NULL),
(434, 'RP000079', 'ALCHOHOL', '2020-11-12', '2020-11-28', '900.00', 'EA', 'adm1', '2020-11-12 07:51:35', '2020-11-12 07:51:35', 'Open', 'WR000022'),
(435, 'RP000080', 'METANOL', '2020-11-12', '2020-11-28', '70.00', 'EA', 'adm1', '2020-11-12 08:54:36', '2020-11-12 08:54:36', 'Close', NULL),
(436, 'RP000080', 'panadol', '2020-11-12', '2020-12-04', '11.00', 'EA', 'adm1', '2020-11-12 08:54:36', '2020-11-12 08:54:36', 'Close', NULL),
(437, 'RP000081', 'METANOL', '2020-11-12', '2020-12-05', '1.00', 'EA', 'adm1', '2020-11-12 08:59:12', '2020-11-12 08:59:12', 'Close', NULL),
(438, 'RP000081', 'panadol', '2020-11-12', '2021-01-05', '2.00', 'EA', 'adm1', '2020-11-12 08:59:12', '2020-11-12 08:59:12', 'Close', NULL),
(441, 'RP000082', 'ALCHOHOL', '2020-11-16', '2020-11-19', '25.00', 'EA', 'admin2', '2020-11-13 05:04:18', '2020-11-13 05:04:18', 'Close', NULL),
(442, 'RP000082', 'METANOL', '2020-11-17', '2020-11-20', '30.00', 'EA', 'admin2', '2020-11-13 05:04:18', '2020-11-13 05:04:18', 'Close', NULL),
(443, 'RP000083', 'panadol', '2020-11-25', '2020-11-26', '25.00', 'EA', 'admin2', '2020-11-13 05:09:27', '2020-11-13 05:09:27', 'Open', 'WR000016'),
(444, 'RP000083', 'PARACETAMOL', '2020-11-24', '2020-11-26', '30.00', 'EA', 'admin2', '2020-11-13 05:09:27', '2020-11-13 05:09:27', 'Open', 'WR000016'),
(445, 'RP000084', 'ALCHOHOL', '2020-11-16', '2020-11-19', '15.00', 'EA', 'Bintang', '2020-11-13 07:35:44', '2020-11-13 07:35:44', 'Close', 'RF000055'),
(446, 'RP000084', 'METANOL', '2020-11-17', '2020-11-19', '25.00', 'EA', 'Bintang', '2020-11-13 07:35:44', '2020-11-13 07:35:44', 'Close', 'RF000056'),
(447, 'RP000085', 'panadol', '2020-11-24', '2020-11-26', '19.00', 'EA', 'Bintang', '2020-11-13 07:36:35', '2020-11-13 07:36:35', 'Close', 'WP000059'),
(448, 'RP000086', 'PARACETAMOL', '2020-11-23', '2020-11-27', '1500.00', 'EA', 'Bintang', '2020-11-13 07:38:43', '2020-11-13 07:38:43', 'Close', 'RF000054'),
(449, 'RP000087', 'METANOL', '2020-11-25', '2020-12-05', '95.00', 'EA', 'adm1', '2020-11-25 10:38:22', '2020-11-25 10:38:22', 'Close', 'WP000069'),
(450, 'RP000088', 'METANOL', '2020-11-25', '2020-11-30', '80.00', 'EA', 'adm1', '2020-11-25 10:48:16', '2020-11-25 10:48:16', 'Close', 'WP000134'),
(451, 'RP000089', 'METANOL', '2020-11-25', '2020-12-05', '55.00', 'EA', 'adm1', '2020-11-25 10:54:40', '2020-11-25 10:54:40', 'Close', 'WP000070'),
(452, 'RP000090', 'panadol', '2020-11-25', '2020-11-28', '65.00', 'EA', 'test2', '2020-11-25 11:05:34', '2020-11-25 11:05:34', 'Close', 'WP000071'),
(453, 'RP000091', 'ALCHOHOL', '2020-11-25', '2020-11-28', '90.00', 'EA', 'test1', '2020-11-25 11:18:30', '2020-11-25 11:18:30', 'Close', 'WP000075'),
(454, 'RP000091', 'panadol', '2020-11-25', '2020-12-25', '100.00', 'EA', 'test1', '2020-11-25 11:18:30', '2020-11-25 11:18:30', 'Close', 'WP000075'),
(455, 'RP000092', 'panadol', '2020-11-25', '2020-11-28', '900.00', 'EA', 'test2', '2020-11-25 11:37:21', '2020-11-25 11:37:21', 'Close', 'WP000085'),
(456, 'RP000092', 'ALCHOHOL', '2020-11-25', '2020-12-11', '8.00', 'EA', 'test2', '2020-11-25 11:37:21', '2020-11-25 11:37:21', 'Close', 'WP000085'),
(457, 'RP000093', 'ALCHOHOL', '2020-11-26', '2020-12-05', '77.00', 'EA', 'test1', '2020-11-26 02:04:48', '2020-11-26 02:04:48', 'Open', NULL),
(458, 'RP000093', 'PARACETAMOL', '2020-11-27', '2020-11-28', '10.00', 'EA', 'test1', '2020-11-26 02:04:48', '2020-11-26 02:04:48', 'Open', NULL),
(459, 'RP000093', 'panadol', '2020-11-26', '2020-12-12', '55.00', 'EA', 'test1', '2020-11-26 02:04:48', '2020-11-26 02:04:48', 'Open', NULL),
(460, 'RP000093', 'METANOL', '2020-11-26', '2021-01-21', '222.00', 'EA', 'test1', '2020-11-26 02:04:48', '2020-11-26 02:04:48', 'Open', NULL),
(461, 'RP000094', 'panadol', '2020-11-26', '2020-11-27', '90.00', 'EA', 'test2', '2020-11-26 09:06:01', '2020-11-26 09:06:01', 'Close', 'WP000132'),
(462, 'RP000094', 'ALCHOHOL', '2020-11-26', '2020-11-28', '11.00', 'EA', 'test2', '2020-11-26 09:06:01', '2020-11-26 09:06:01', 'Close', 'WP000132'),
(463, 'RP000094', 'METANOL', '2020-11-26', '2020-11-28', '66.00', 'EA', 'test2', '2020-11-26 09:06:01', '2020-11-26 09:06:01', 'Close', 'WP000133'),
(464, 'RP000094', 'PARACETAMOL', '2020-11-26', '2020-12-09', '22.00', 'EA', 'test2', '2020-11-26 09:06:01', '2020-11-26 09:06:01', 'Close', 'WP000133'),
(465, 'RP000095', 'ALCHOHOL', '2020-12-16', '2020-12-31', '20.00', 'EA', 'adm1', '2020-12-14 04:31:59', '2020-12-14 04:31:59', 'Open', NULL),
(466, 'RP000095', 'PARACETAMOL', '2020-12-25', '2020-12-27', '11.00', 'EA', 'adm1', '2020-12-14 04:31:59', '2020-12-14 04:31:59', 'Open', NULL),
(467, 'RP000096', 'ALCHOHOL', '2020-12-20', '2020-12-31', '75.00', 'EA', 'adm1', '2020-12-14 05:10:14', '2020-12-14 05:10:14', 'Open', NULL),
(468, 'RP000096', 'METANOL', '2020-12-14', '2021-01-10', '25.00', 'EA', 'adm1', '2020-12-14 05:10:14', '2020-12-14 05:10:14', 'Open', NULL),
(469, 'RP000097', 'panadol', '2020-12-14', '2020-12-25', '210.00', 'EA', 'adm1', '2020-12-14 05:11:07', '2020-12-14 05:11:07', 'Open', 'WR000013'),
(470, 'RP000097', 'PARACETAMOL', '2020-12-30', '2021-01-10', '10.00', 'EA', 'adm1', '2020-12-14 05:11:07', '2020-12-14 05:11:07', 'Open', 'WR000013'),
(471, 'RP000098', 'ALCHOHOL', '2020-12-30', '2021-01-02', '200.00', 'EA', 'adm1', '2020-12-30 10:10:38', '2020-12-30 10:10:38', 'Close', 'WP000135'),
(472, 'RP000098', 'METANOL', '2020-12-30', '2021-01-09', '10.00', 'EA', 'adm1', '2020-12-30 10:10:38', '2020-12-30 10:10:38', 'Close', 'WP000135'),
(473, 'RP000099', 'ALCHOHOL', '2021-01-08', '2021-01-11', '5000.00', 'EA', 'admin2', '2021-01-04 07:25:39', '2021-01-04 07:25:39', 'Open', 'WR000014'),
(474, 'RP000100', 'panadol', '2021-01-06', '2021-01-14', '50.00', 'EA', 'admin2', '2021-01-04 07:53:39', '2021-01-04 07:53:39', 'Open', 'WR000015'),
(475, 'RP000100', 'PARACETAMOL', '2021-01-06', '2021-01-15', '70.00', 'EA', 'admin2', '2021-01-04 07:53:39', '2021-01-04 07:53:39', 'Open', 'WR000015'),
(476, 'RP000101', 'ALCHOHOL', '2021-01-04', '2021-01-17', '15.00', 'EA', 'test1', '2021-01-04 08:59:24', '2021-01-04 08:59:24', 'Open', 'WR000017'),
(477, 'RP000101', 'METANOL', '2021-01-06', '2021-01-10', '90.00', 'EA', 'test1', '2021-01-04 08:59:24', '2021-01-04 08:59:24', 'Open', 'WR000017'),
(478, 'RP000102', 'ALCHOHOL', '2021-01-06', '2021-01-10', '50.00', 'EA', 'test1', '2021-01-04 09:15:06', '2021-01-04 09:15:06', 'Open', 'WR000018'),
(479, 'RP000102', 'METANOL', '2021-01-10', '2021-01-23', '8.00', 'EA', 'test1', '2021-01-04 09:15:06', '2021-01-04 09:15:06', 'Open', 'WR000018'),
(480, 'RP000103', 'ALCHOHOL', '2021-01-05', '2021-01-06', '1.00', 'EA', 'test1', '2021-01-04 09:20:29', '2021-01-04 09:20:29', 'Open', 'WR000019'),
(481, 'RP000103', 'METANOL', '2021-01-05', '2021-01-07', '22.00', 'EA', 'test1', '2021-01-04 09:20:29', '2021-01-04 09:20:29', 'Open', 'WR000019'),
(482, 'RP000104', 'ALCHOHOL', '2021-01-04', '2021-01-08', '1.00', 'EA', 'test1', '2021-01-04 09:23:58', '2021-01-04 09:23:58', 'Open', 'WR000020'),
(483, 'RP000104', 'PARACETAMOL', '2021-01-09', '2021-01-17', '1.00', 'EA', 'test1', '2021-01-04 09:23:58', '2021-01-04 09:23:58', 'Open', 'WR000020'),
(484, 'RP000105', 'ALCHOHOL', '2021-01-05', '2021-01-10', '1.00', 'EA', 'test1', '2021-01-04 09:45:12', '2021-01-04 09:45:12', 'Open', 'WR000021'),
(485, 'RP000106', 'METANOL', '2021-01-19', '2021-01-21', '5000.00', 'EA', 'admin', '2021-01-15 04:57:09', '2021-01-15 04:57:09', 'Close', 'WP000134'),
(486, 'RP000106', 'PARACETAMOL', '2021-01-19', '2021-01-26', '5500.00', 'EA', 'admin', '2021-01-15 04:57:09', '2021-01-15 04:57:09', 'Close', 'WP000134'),
(487, 'RP000108', 'ALCHOHOL', '2021-01-19', '2021-01-27', '700.00', 'EA', 'admin', '2021-01-15 08:23:13', '2021-01-15 08:23:13', 'Open', NULL),
(488, 'RP000108', 'METANOL', '2021-01-26', '2021-01-29', '500.00', 'EA', 'admin', '2021-01-15 08:23:13', '2021-01-15 08:23:13', 'Open', NULL),
(489, 'RP000109', 'PARACETAMOL', '2021-01-18', '2021-01-21', '30.00', 'EA', 'admin', '2021-01-15 08:24:39', '2021-01-15 08:24:39', 'Close', 'RF000059'),
(490, 'RP000110', 'ALCHOHOL', '2021-02-10', '2021-02-10', '100.00', 'EA', 'admin', '2021-01-20 04:40:44', '2021-01-20 04:40:44', 'Open', NULL),
(491, 'RP000110', 'METANOL', '2021-02-16', '2021-02-16', '100.00', 'BX', 'admin', '2021-01-20 04:40:44', '2021-01-20 04:40:44', 'Open', NULL),
(498, 'RP000111', 'ALCHOHOL', '2021-01-26', '2021-01-26', '100.00', 'EA', 'ay', '2021-01-20 04:57:54', '2021-01-20 04:57:54', 'Open', NULL),
(499, 'RP000111', 'METANOL', '2021-01-28', '2021-01-28', '200.00', 'BX', 'ay', '2021-01-20 04:57:54', '2021-01-20 04:57:54', 'Open', NULL),
(500, 'RP000113', 'METANOL', '2021-01-25', '2021-01-25', '100.00', 'BX', 'ay', '2021-01-20 04:58:43', '2021-01-20 04:58:43', 'Open', NULL),
(501, 'RP000113', 'ALCHOHOL', '2021-01-29', '2021-01-29', '300.00', 'EA', 'ay', '2021-01-20 04:58:43', '2021-01-20 04:58:43', 'Open', NULL),
(502, 'RP000115', 'ALCHOHOL', '2021-01-25', '2021-01-25', '100.00', 'EA', 'ay', '2021-01-20 05:02:15', '2021-01-20 05:02:15', 'Close', 'RF000061'),
(503, 'RP000115', 'METANOL', '2021-01-26', '2021-01-26', '300.00', 'BX', 'ay', '2021-01-20 05:02:15', '2021-01-20 05:02:15', 'Close', 'RF000062'),
(504, 'RP000116', 'ALCHOHOL', '2021-01-22', '2021-01-24', '90.00', 'EA', 'adm1', '2021-01-22 01:46:11', '2021-01-22 01:46:11', 'Open', NULL),
(0, 'RP000117', 'panadol', '2021-02-04', '2021-02-19', '5.00', 'EA', 'admin', '2021-01-27 04:05:01', '2021-01-27 04:05:01', 'Open', NULL),
(0, 'RP000075', 'ALCHOHOL', '2021-02-23', '2021-02-24', '111.00', 'EA', 'mfg', '2021-02-23 07:45:33', '2021-02-23 07:45:33', 'Open', NULL),
(0, 'RP000075', 'METANOL', '2021-02-23', '2021-02-24', '1.00', 'BX', 'mfg', '2021-02-23 07:45:33', '2021-02-23 07:45:33', 'Open', NULL),
(0, 'RP000117', 'ALCHOHOL', '2021-04-05', '2021-04-05', '10.00', 'EA', 'admin', '2021-04-05 16:23:25', '2021-04-05 16:23:25', 'Open', NULL),
(0, 'RP000117', 'ALCHOHOL', '2021-04-09', '2021-04-12', '10.00', 'EA', 'admin1', '2021-04-07 02:16:30', '2021-04-07 02:16:30', 'Open', NULL),
(0, 'RP000117', 'METANOL', '2021-04-13', '2021-04-16', '15.00', 'BX', 'admin1', '2021-04-07 02:16:30', '2021-04-07 02:16:30', 'Open', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xrfp_hist`
--

CREATE TABLE `xrfp_hist` (
  `id` int(11) NOT NULL,
  `rfp_hist_nbr` varchar(24) NOT NULL,
  `rfp_hist_supp` varchar(24) DEFAULT NULL,
  `rfp_hist_enduser` varchar(25) DEFAULT NULL,
  `rfp_hist_site` varchar(25) DEFAULT NULL,
  `rfp_hist_shipto` varchar(25) DEFAULT NULL,
  `rfp_dept` varchar(24) DEFAULT NULL,
  `rfp_duedate_mstr` date DEFAULT NULL,
  `rfp_create_by` varchar(24) NOT NULL,
  `rfp_create_at` timestamp NULL DEFAULT NULL,
  `rfp_status` varchar(24) DEFAULT NULL,
  `line` int(11) DEFAULT NULL,
  `itemcode_hist` varchar(24) NOT NULL,
  `need_date_dets` date NOT NULL,
  `due_date_dets` date NOT NULL,
  `qty_order_hist` decimal(10,2) NOT NULL,
  `nbr_convert` varchar(24) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xrfp_hist`
--

INSERT INTO `xrfp_hist` (`id`, `rfp_hist_nbr`, `rfp_hist_supp`, `rfp_hist_enduser`, `rfp_hist_site`, `rfp_hist_shipto`, `rfp_dept`, `rfp_duedate_mstr`, `rfp_create_by`, `rfp_create_at`, `rfp_status`, `line`, `itemcode_hist`, `need_date_dets`, `due_date_dets`, `qty_order_hist`, `nbr_convert`) VALUES
(175, 'RP000076', '10S1005', 'lleeelele', '10-200', '10S1005', 'R&D', '2020-12-30', 'adm1', '2020-11-12 02:57:17', 'New Request', 1, 'ALCHOHOL', '2020-11-12', '2020-12-12', '90.00', ''),
(176, 'RP000076', '10S1005', 'lleeelele', '10-200', '10S1005', 'R&D', '2020-12-30', 'adm1', '2020-11-12 02:57:17', 'New Request', 2, 'METANOL', '2020-11-12', '2020-12-30', '100.00', ''),
(178, 'RP000077', '10-200', 'rrererer', '10-300', '10-200', 'R&D', '2020-12-12', 'adm1', '2020-11-12 02:57:42', 'Close', 1, 'ALCHOHOL', '2020-11-19', '2020-11-28', '25.00', ''),
(179, 'RP000077', '10-200', 'rrererer', '10-300', '10-200', 'R&D', '2020-12-12', 'adm1', '2020-11-12 03:55:48', 'Close', 1, 'METANOL', '2020-11-12', '2020-11-30', '79.00', ''),
(180, 'RP000077', '10-200', 'rrererer', '10-300', '10-200', 'R&D', '2020-12-12', 'adm1', '2020-11-12 04:23:16', 'Close', 1, 'ALCHOHOL', '2020-11-19', '2020-11-28', '7.00', ''),
(181, 'RP000077', '10-200', 'rrererer', '10-300', '10-200', 'R&D', '2020-12-12', 'adm1', '2020-11-12 05:04:46', 'Close', 1, 'ALCHOHOL', '2020-11-19', '2020-11-28', '6.80', ''),
(182, 'RP000077', '10-200', 'rrererer', '10-300', '10-200', 'R&D', '2020-12-12', 'adm1', '2020-11-12 05:10:01', 'Close', 1, 'ALCHOHOL', '2020-11-19', '2020-12-12', '6.80', ''),
(183, 'RP000077', '10-200', 'rrererer', '10-300', '10-200', 'R&D', '2021-03-18', 'adm1', '2020-11-12 05:20:48', 'Close', 2, 'ALCHOHOL', '2020-11-19', '2021-03-18', '6.80', ''),
(184, 'RP000077', '10-200', 'rrererer', '10-300', '10-200', 'R&D', '2021-04-14', 'adm1', '2020-11-12 05:23:26', 'Close', 2, 'ALCHOHOL', '2020-11-19', '2021-04-14', '6.80', ''),
(185, 'RP000078', '10-300', 'test kesekian', '10-200', '10-300', 'R&D', '2020-12-04', 'adm1', '2020-11-12 07:05:28', 'New Request', 1, 'panadol', '2020-11-12', '2020-12-04', '1.00', ''),
(186, 'RP000078', '10-300', 'test kesekian', '10-200', '10-300', 'R&D', '2021-02-25', 'adm1', '2020-11-12 07:34:56', 'New Request', 2, 'METANOL', '2020-11-12', '2021-02-25', '17.00', ''),
(187, 'RP000079', '10-200', 'sekian terima uang', '10-200', '10-200', 'R&D', '2020-11-28', 'adm1', '2020-11-12 07:51:35', 'New Request', 1, 'ALCHOHOL', '2020-11-12', '2020-11-28', '900.00', ''),
(188, 'RP000079', '10-200', 'sekian terima uang', '10-200', '10-200', 'R&D', '2020-11-28', 'test1', '2020-11-12 07:54:28', 'Rejected', 1, 'ALCHOHOL', '2020-11-12', '2020-11-28', '900.00', ''),
(189, 'RP000080', '10S1003', 'dadwd', '10-100', '10S1003', 'R&D', '2020-12-04', 'adm1', '2020-11-12 08:54:36', 'Close', 1, 'METANOL', '2020-11-12', '2020-11-28', '70.00', ''),
(190, 'RP000080', '10S1003', 'dadwd', '10-100', '10S1003', 'R&D', '2020-12-04', 'adm1', '2020-11-12 08:54:36', 'Close', 2, 'panadol', '2020-11-12', '2020-12-04', '11.00', ''),
(191, 'RP000081', '10-200', 'daddddddddddddddd', '10-100', '10-200', 'R&D', '2021-01-05', 'adm1', '2020-11-12 08:59:12', 'New Request', 1, 'METANOL', '2020-11-12', '2020-12-05', '1.00', ''),
(192, 'RP000081', '10-200', 'daddddddddddddddd', '10-100', '10-200', 'R&D', '2021-01-05', 'adm1', '2020-11-12 08:59:12', 'New Request', 2, 'panadol', '2020-11-12', '2021-01-05', '2.00', ''),
(193, 'RP000081', '10-200', 'daddddddddddddddd', '10-100', '10-200', 'R&D', '2021-01-05', 'test2', '2020-11-12 09:00:34', 'Close', 1, 'METANOL', '2020-11-12', '2020-12-05', '1.00', ''),
(194, 'RP000081', '10-200', 'daddddddddddddddd', '10-100', '10-200', 'R&D', '2021-01-05', 'test2', '2020-11-12 09:00:34', 'Close', 2, 'panadol', '2020-11-12', '2021-01-05', '2.00', ''),
(195, 'RP000075', '10S1003', 'test1', '10-100', '10S1003', 'R&D', '2020-11-21', 'adm1', '2020-11-13 03:23:57', 'New Request', 2, 'ALCHOHOL', '2020-11-13', '2020-11-21', '111.00', ''),
(196, 'RP000082', '10S1003', 'stanley', '10-100', '10S1003', 'IT', '2020-11-20', 'admin2', '2020-11-13 05:04:18', 'New Request', 1, 'ALCHOHOL', '2020-11-16', '2020-11-19', '25.00', ''),
(197, 'RP000082', '10S1003', 'stanley', '10-100', '10S1003', 'IT', '2020-11-20', 'admin2', '2020-11-13 05:04:18', 'New Request', 2, 'METANOL', '2020-11-17', '2020-11-20', '30.00', ''),
(198, 'RP000083', '10-300', 'Bintang', '10-200', '10-300', 'IT', '2020-11-26', 'admin2', '2020-11-13 05:09:27', 'New Request', 1, 'panadol', '2020-11-25', '2020-11-26', '25.00', ''),
(200, 'RP000082', '10S1003', 'stanley', '10-100', '10S1003', 'IT', '2020-11-20', 'Bintang', '2020-11-13 06:03:17', 'Close', 1, 'ALCHOHOL', '2020-11-16', '2020-11-19', '25.00', ''),
(201, 'RP000082', '10S1003', 'stanley', '10-100', '10S1003', 'IT', '2020-11-20', 'Bintang', '2020-11-13 06:03:17', 'Close', 2, 'METANOL', '2020-11-17', '2020-11-20', '30.00', ''),
(202, 'RP000084', '10-200', 'sty', '10-300', '10-200', 'R&D', '2020-11-19', 'Bintang', '2020-11-13 07:35:44', 'New Request', 1, 'ALCHOHOL', '2020-11-16', '2020-11-19', '15.00', ''),
(203, 'RP000084', '10-200', 'sty', '10-300', '10-200', 'R&D', '2020-11-19', 'Bintang', '2020-11-13 07:35:44', 'New Request', 2, 'METANOL', '2020-11-17', '2020-11-19', '25.00', ''),
(204, 'RP000085', '10-300', 'bintang', '10-100', '10-300', 'R&D', '2020-11-26', 'Bintang', '2020-11-13 07:36:35', 'New Request', 1, 'panadol', '2020-11-24', '2020-11-26', '19.00', ''),
(205, 'RP000086', '10S1005', 'andi', '10-100', '10S1005', 'R&D', '2020-11-27', 'Bintang', '2020-11-13 07:38:43', 'New Request', 1, 'PARACETAMOL', '2020-11-23', '2020-11-27', '1500.00', ''),
(206, 'RP000086', '10S1005', 'andi', '10-100', '10S1005', 'R&D', '2020-11-27', 'test2', '2020-11-13 08:01:07', 'Close', 1, 'PARACETAMOL', '2020-11-23', '2020-11-27', '1500.00', ''),
(207, 'RP000084', '10-200', 'sty', '10-300', '10-200', 'R&D', '2020-11-19', 'test2', '2020-11-13 08:01:13', 'Close', 1, 'ALCHOHOL', '2020-11-16', '2020-11-19', '15.00', ''),
(208, 'RP000084', '10-200', 'sty', '10-300', '10-200', 'R&D', '2020-11-19', 'test2', '2020-11-13 08:01:13', 'Close', 2, 'METANOL', '2020-11-17', '2020-11-19', '25.00', ''),
(209, 'RP000085', '10-300', 'bintang', '10-100', '10-300', 'R&D', '2020-11-26', 'test2', '2020-11-13 08:01:19', 'Close', 1, 'panadol', '2020-11-24', '2020-11-26', '19.00', ''),
(210, 'RP000087', '10S1003', 'yesno', '10-100', '10S1003', 'R&D', '2020-12-05', 'adm1', '2020-11-25 10:38:22', 'New Request', 1, 'METANOL', '2020-11-25', '2020-12-05', '95.00', ''),
(211, 'RP000087', '10S1003', 'yesno', '10-100', '10S1003', 'R&D', '2020-12-05', 'test2', '2020-11-25 10:40:09', 'New Request', 1, 'METANOL', '2020-11-25', '2020-12-05', '95.00', 'WP000069'),
(212, 'RP000088', '10-300', 'rerere', '10-300', '10-300', 'R&D', '2020-11-30', 'adm1', '2020-11-25 10:48:16', 'New Request', 1, 'METANOL', '2020-11-25', '2020-11-30', '80.00', ''),
(213, 'RP000088', '10-300', 'rerere', '10-300', '10-300', 'R&D', '2020-11-30', 'test2', '2020-11-25 10:53:31', 'Close', 1, 'METANOL', '2020-11-25', '2020-11-30', '80.00', NULL),
(214, 'RP000089', '10-200', 'tonystuck', '10-200', '10-200', 'R&D', '2020-12-05', 'adm1', '2020-11-25 10:54:40', 'New Request', 1, 'METANOL', '2020-11-25', '2020-12-05', '55.00', NULL),
(215, 'RP000089', '10-200', 'tonystuck', '10-200', '10-200', 'R&D', '2020-12-05', 'test2', '2020-11-25 10:55:48', 'Close', 1, 'METANOL', '2020-11-25', '2020-12-05', '55.00', NULL),
(216, 'RP000089', '10-200', 'tonystuck', '10-200', '10-200', 'R&D', '2020-12-05', 'test2', '2020-11-25 10:56:19', 'Close', 1, 'METANOL', '2020-11-25', '2020-12-05', '55.00', 'WP000070'),
(217, 'RP000090', '10-300', 'google', '10-200', '10-300', 'R&D', '2020-11-28', 'test2', '2020-11-25 11:05:34', 'New Request', 1, 'panadol', '2020-11-25', '2020-11-28', '65.00', NULL),
(218, 'RP000090', '10-300', 'google', '10-200', '10-300', 'R&D', '2020-11-28', 'test2', '2020-11-25 11:07:27', 'Approved', 1, 'panadol', '2020-11-25', '2020-11-28', '65.00', 'WP000071'),
(219, 'RP000091', '10-200', 'Hujan', '10-300', '10-200', 'R&D', '2020-12-25', 'test1', '2020-11-25 11:18:30', 'New Request', 1, 'ALCHOHOL', '2020-11-25', '2020-11-28', '90.00', NULL),
(220, 'RP000091', '10-200', 'Hujan', '10-300', '10-200', 'R&D', '2020-12-25', 'test1', '2020-11-25 11:18:30', 'New Request', 2, 'panadol', '2020-11-25', '2020-12-25', '100.00', NULL),
(221, 'RP000091', '10-200', 'Hujan', '10-300', '10-200', 'R&D', '2020-12-25', 'test2', '2020-11-25 11:25:11', 'Close', 1, 'ALCHOHOL', '2020-11-25', '2020-11-28', '90.00', 'WP000073'),
(222, 'RP000091', '10-200', 'Hujan', '10-300', '10-200', 'R&D', '2020-12-25', 'test2', '2020-11-25 11:25:11', 'Close', 2, 'panadol', '2020-11-25', '2020-12-25', '100.00', 'WP000073'),
(223, 'RP000092', '10-200', 'testttt', '10-200', '10-200', 'R&D', '2020-12-11', 'test2', '2020-11-25 11:37:21', 'New Request', 1, 'panadol', '2020-11-25', '2020-11-28', '900.00', NULL),
(224, 'RP000092', '10-200', 'testttt', '10-200', '10-200', 'R&D', '2020-12-11', 'test2', '2020-11-25 11:37:21', 'New Request', 2, 'ALCHOHOL', '2020-11-25', '2020-12-11', '8.00', NULL),
(225, 'RP000091', '10-200', 'Hujan', '10-300', '10-200', 'R&D', '2020-12-25', 'test1', '2020-11-26 02:01:39', 'Close', 1, 'ALCHOHOL', '2020-11-25', '2020-11-28', '90.00', 'WP000075'),
(226, 'RP000091', '10-200', 'Hujan', '10-300', '10-200', 'R&D', '2020-12-25', 'test1', '2020-11-26 02:01:39', 'Close', 2, 'panadol', '2020-11-25', '2020-12-25', '100.00', 'WP000075'),
(227, 'RP000092', '10-200', 'testttt', '10-200', '10-200', 'R&D', '2020-12-11', 'test1', '2020-11-26 02:01:39', 'Close', 1, 'panadol', '2020-11-25', '2020-11-28', '900.00', 'WP000075'),
(228, 'RP000092', '10-200', 'testttt', '10-200', '10-200', 'R&D', '2020-12-11', 'test1', '2020-11-26 02:01:39', 'Close', 2, 'ALCHOHOL', '2020-11-25', '2020-12-11', '8.00', 'WP000075'),
(233, 'RP000092', '10-200', 'testttt', '10-200', '10-200', 'R&D', '2020-12-11', 'test2', '2020-11-26 02:09:34', 'Close', 1, 'panadol', '2020-11-25', '2020-11-28', '900.00', 'WP000076'),
(234, 'RP000092', '10-200', 'testttt', '10-200', '10-200', 'R&D', '2020-12-11', 'test2', '2020-11-26 02:09:34', 'Close', 2, 'ALCHOHOL', '2020-11-25', '2020-12-11', '8.00', 'WP000076'),
(275, 'RP000094', '10-200', 'hore', '10-200', '10-200', 'R&D', '2020-12-09', 'test2', '2020-11-26 09:06:01', 'New Request', 1, 'panadol', '2020-11-26', '2020-11-27', '90.00', NULL),
(276, 'RP000094', '10-200', 'hore', '10-200', '10-200', 'R&D', '2020-12-09', 'test2', '2020-11-26 09:06:01', 'New Request', 2, 'ALCHOHOL', '2020-11-26', '2020-11-28', '11.00', NULL),
(277, 'RP000094', '10-200', 'hore', '10-200', '10-200', 'R&D', '2020-12-09', 'test2', '2020-11-26 09:06:01', 'New Request', 3, 'METANOL', '2020-11-26', '2020-11-28', '66.00', NULL),
(278, 'RP000094', '10-200', 'hore', '10-200', '10-200', 'R&D', '2020-12-09', 'test2', '2020-11-26 09:06:01', 'New Request', 4, 'PARACETAMOL', '2020-11-26', '2020-12-09', '22.00', NULL),
(279, 'RP000094', '10-200', 'hore', '10-200', '10-200', 'R&D', '2020-12-09', 'test2', '2020-11-26 09:07:46', 'Close', 1, 'panadol', '2020-11-26', '2020-11-27', '90.00', 'WP000132'),
(280, 'RP000094', '10-200', 'hore', '10-200', '10-200', 'R&D', '2020-12-09', 'test2', '2020-11-26 09:07:46', 'Close', 2, 'ALCHOHOL', '2020-11-26', '2020-11-28', '11.00', 'WP000132'),
(281, 'RP000094', '10-200', 'hore', '10-200', '10-200', 'R&D', '2020-12-09', 'test2', '2020-11-26 09:08:33', 'Close', 1, 'METANOL', '2020-11-26', '2020-11-28', '66.00', 'WP000133'),
(282, 'RP000094', '10-200', 'hore', '10-200', '10-200', 'R&D', '2020-12-09', 'test2', '2020-11-26 09:08:33', 'Close', 2, 'PARACETAMOL', '2020-11-26', '2020-12-09', '22.00', 'WP000133'),
(283, 'RP000079', '10-200', 'sekian terima uang', '10-200', '10-200', 'R&D', '2020-11-28', 'test1', '2020-11-26 11:24:45', 'Rejected', 1, 'ALCHOHOL', '2020-11-12', '2020-11-28', '900.00', NULL),
(284, 'RP000076', '10S1005', 'lleeelele', '10-200', '10S1005', 'R&D', '2020-12-30', 'test1', '2020-11-26 11:40:50', 'Rejected', 1, 'ALCHOHOL', '2020-11-12', '2020-12-12', '90.00', NULL),
(285, 'RP000076', '10S1005', 'lleeelele', '10-200', '10S1005', 'R&D', '2020-12-30', 'test1', '2020-11-26 11:40:50', 'Rejected', 2, 'METANOL', '2020-11-12', '2020-12-30', '100.00', NULL),
(286, 'RP000075', '10S1003', 'test1', '10-100', '10S1003', 'R&D', '2020-12-09', 'test1', '2020-11-27 02:55:16', 'Rejected', 1, 'ALCHOHOL', '2020-11-13', '2020-11-21', '111.00', NULL),
(287, 'RP000075', '10S1003', 'test1', '10-100', '10S1003', 'R&D', '2020-12-09', 'test1', '2020-11-27 02:55:16', 'Rejected', 2, 'METANOL', '2020-11-14', '2020-12-09', '1.00', NULL),
(288, 'RP000095', '10-200', 'test', '10-100', '10-200', 'R&D', '2020-12-31', 'adm1', '2020-12-14 04:31:59', 'New Request', 1, 'ALCHOHOL', '2020-12-16', '2020-12-31', '20.00', NULL),
(289, 'RP000095', '10-200', 'test', '10-100', '10-200', 'R&D', '2020-12-31', 'adm1', '2020-12-14 04:31:59', 'New Request', 2, 'PARACETAMOL', '2020-12-25', '2020-12-27', '11.00', NULL),
(290, 'RP000096', '10S1003', 'hello2', '10-300', '10S1003', 'R&D', '2021-01-10', 'adm1', '2020-12-14 05:10:14', 'New Request', 1, 'ALCHOHOL', '2020-12-20', '2020-12-31', '75.00', NULL),
(291, 'RP000096', '10S1003', 'hello2', '10-300', '10S1003', 'R&D', '2021-01-10', 'adm1', '2020-12-14 05:10:14', 'New Request', 2, 'METANOL', '2020-12-14', '2021-01-10', '25.00', NULL),
(292, 'RP000097', '10S1005', 'Black', '10-200', '10S1005', 'R&D', '2021-01-10', 'adm1', '2020-12-14 05:11:07', 'New Request', 1, 'panadol', '2020-12-14', '2020-12-25', '210.00', NULL),
(293, 'RP000097', '10S1005', 'Black', '10-200', '10S1005', 'R&D', '2021-01-10', 'adm1', '2020-12-14 05:11:07', 'New Request', 2, 'PARACETAMOL', '2020-12-30', '2021-01-10', '10.00', NULL),
(294, 'RP000097', '10S1005', 'Black', '10-200', '10S1005', 'R&D', '2021-01-10', 'test2', '2020-12-22 02:24:04', 'Close', 1, 'panadol', '2020-12-14', '2020-12-25', '210.00', 'WR000013'),
(295, 'RP000097', '10S1005', 'Black', '10-200', '10S1005', 'R&D', '2021-01-10', 'test2', '2020-12-22 02:24:04', 'Close', 2, 'PARACETAMOL', '2020-12-30', '2021-01-10', '10.00', 'WR000013'),
(296, 'RP000098', '10-300', 'Test30', '10-200', '10-300', 'R&D', '2021-01-09', 'adm1', '2020-12-30 10:10:38', 'New Request', 1, 'ALCHOHOL', '2020-12-30', '2021-01-02', '200.00', NULL),
(297, 'RP000098', '10-300', 'Test30', '10-200', '10-300', 'R&D', '2021-01-09', 'adm1', '2020-12-30 10:10:38', 'New Request', 2, 'METANOL', '2020-12-30', '2021-01-09', '10.00', NULL),
(298, 'RP000099', '10S1004', 'mfg', '10-300', '10S1004', 'IT', '2021-01-11', 'admin2', '2021-01-04 07:25:39', 'New Request', 1, 'ALCHOHOL', '2021-01-08', '2021-01-11', '5000.00', NULL),
(299, 'RP000099', '10S1004', 'mfg', '10-300', '10S1004', 'IT', '2021-01-11', 'admin2', '2021-01-04 07:29:18', 'Close', 1, 'ALCHOHOL', '2021-01-08', '2021-01-11', '5000.00', 'WR000014'),
(300, 'RP000100', '10S1003', 'mfg', '10-300', '10S1003', 'IT', '2021-01-15', 'admin2', '2021-01-04 07:53:39', 'New Request', 1, 'panadol', '2021-01-06', '2021-01-14', '50.00', NULL),
(301, 'RP000100', '10S1003', 'mfg', '10-300', '10S1003', 'IT', '2021-01-15', 'admin2', '2021-01-04 07:53:39', 'New Request', 2, 'PARACETAMOL', '2021-01-06', '2021-01-15', '70.00', NULL),
(302, 'RP000100', '10S1003', 'mfg', '10-300', '10S1003', 'IT', '2021-01-15', 'admin2', '2021-01-04 07:55:27', 'Close', 1, 'panadol', '2021-01-06', '2021-01-14', '50.00', 'WR000015'),
(303, 'RP000100', '10S1003', 'mfg', '10-300', '10S1003', 'IT', '2021-01-15', 'admin2', '2021-01-04 07:55:27', 'Close', 2, 'PARACETAMOL', '2021-01-06', '2021-01-15', '70.00', 'WR000015'),
(304, 'RP000083', '10-300', 'Bintang', '10-200', '10-300', 'IT', '2020-11-26', 'admin2', '2021-01-04 08:35:22', 'Close', 1, 'panadol', '2020-11-25', '2020-11-26', '25.00', 'WR000016'),
(305, 'RP000083', '10-300', 'Bintang', '10-200', '10-300', 'IT', '2020-11-26', 'admin2', '2021-01-04 08:35:22', 'Close', 2, 'PARACETAMOL', '2020-11-24', '2020-11-26', '30.00', 'WR000016'),
(306, 'RP000101', '10S1003', 'testpr1', '10-100', '10S1003', 'R&D', '2021-01-17', 'test1', '2021-01-04 08:59:24', 'New Request', 1, 'ALCHOHOL', '2021-01-04', '2021-01-17', '15.00', NULL),
(307, 'RP000101', '10S1003', 'testpr1', '10-100', '10S1003', 'R&D', '2021-01-17', 'test1', '2021-01-04 08:59:24', 'New Request', 2, 'METANOL', '2021-01-06', '2021-01-10', '90.00', NULL),
(308, 'RP000101', '10S1003', 'testpr1', '10-100', '10S1003', 'R&D', '2021-01-17', 'test1', '2021-01-04 09:00:59', 'Close', 1, 'ALCHOHOL', '2021-01-04', '2021-01-17', '15.00', 'WR000017'),
(309, 'RP000101', '10S1003', 'testpr1', '10-100', '10S1003', 'R&D', '2021-01-17', 'test1', '2021-01-04 09:00:59', 'Close', 2, 'METANOL', '2021-01-06', '2021-01-10', '90.00', 'WR000017'),
(310, 'RP000102', '10S1003', 'tomy', '10-100', '10S1003', 'R&D', '2021-01-23', 'test1', '2021-01-04 09:15:06', 'New Request', 1, 'ALCHOHOL', '2021-01-06', '2021-01-10', '50.00', NULL),
(311, 'RP000102', '10S1003', 'tomy', '10-100', '10S1003', 'R&D', '2021-01-23', 'test1', '2021-01-04 09:15:06', 'New Request', 2, 'METANOL', '2021-01-10', '2021-01-23', '8.00', NULL),
(312, 'RP000102', '10S1003', 'tomy', '10-100', '10S1003', 'R&D', '2021-01-23', 'test1', '2021-01-04 09:16:04', 'Close', 1, 'ALCHOHOL', '2021-01-06', '2021-01-10', '50.00', 'WR000018'),
(313, 'RP000102', '10S1003', 'tomy', '10-100', '10S1003', 'R&D', '2021-01-23', 'test1', '2021-01-04 09:16:04', 'Close', 2, 'METANOL', '2021-01-10', '2021-01-23', '8.00', 'WR000018'),
(314, 'RP000103', '10-300', 'pr2', '10-100', '10-300', 'R&D', '2021-01-07', 'test1', '2021-01-04 09:20:29', 'New Request', 1, 'ALCHOHOL', '2021-01-05', '2021-01-06', '1.00', NULL),
(315, 'RP000103', '10-300', 'pr2', '10-100', '10-300', 'R&D', '2021-01-07', 'test1', '2021-01-04 09:20:29', 'New Request', 2, 'METANOL', '2021-01-05', '2021-01-07', '22.00', NULL),
(316, 'RP000103', '10-300', 'pr2', '10-100', '10-300', 'R&D', '2021-01-07', 'test1', '2021-01-04 09:20:53', 'Close', 1, 'ALCHOHOL', '2021-01-05', '2021-01-06', '1.00', 'WR000019'),
(317, 'RP000103', '10-300', 'pr2', '10-100', '10-300', 'R&D', '2021-01-07', 'test1', '2021-01-04 09:20:53', 'Close', 2, 'METANOL', '2021-01-05', '2021-01-07', '22.00', 'WR000019'),
(318, 'RP000104', '10-200', 'pr4', '10-100', '10-200', 'R&D', '2021-01-17', 'test1', '2021-01-04 09:23:58', 'New Request', 1, 'ALCHOHOL', '2021-01-04', '2021-01-08', '1.00', NULL),
(319, 'RP000104', '10-200', 'pr4', '10-100', '10-200', 'R&D', '2021-01-17', 'test1', '2021-01-04 09:23:58', 'New Request', 2, 'PARACETAMOL', '2021-01-09', '2021-01-17', '1.00', NULL),
(320, 'RP000104', '10-200', 'pr4', '10-100', '10-200', 'R&D', '2021-01-17', 'test1', '2021-01-04 09:24:23', 'Close', 1, 'ALCHOHOL', '2021-01-04', '2021-01-08', '1.00', 'WR000020'),
(321, 'RP000104', '10-200', 'pr4', '10-100', '10-200', 'R&D', '2021-01-17', 'test1', '2021-01-04 09:24:23', 'Close', 2, 'PARACETAMOL', '2021-01-09', '2021-01-17', '1.00', 'WR000020'),
(322, 'RP000105', '10S1003', 'pr5', '10-200', '10S1003', 'R&D', '2021-01-10', 'test1', '2021-01-04 09:45:12', 'New Request', 1, 'ALCHOHOL', '2021-01-05', '2021-01-10', '1.00', NULL),
(323, 'RP000105', '10S1003', 'pr5', '10-200', '10S1003', 'R&D', '2021-01-10', 'test1', '2021-01-04 09:45:29', 'Close', 1, 'ALCHOHOL', '2021-01-05', '2021-01-10', '1.00', 'WR000021'),
(324, 'RP000106', '10S1003', 'STANLEY', '10-200', '10S1003', 'PT', '2021-01-26', 'admin', '2021-01-15 04:57:09', 'New Request', 1, 'METANOL', '2021-01-19', '2021-01-21', '5000.00', NULL),
(325, 'RP000106', '10S1003', 'STANLEY', '10-200', '10S1003', 'PT', '2021-01-26', 'admin', '2021-01-15 04:57:09', 'New Request', 2, 'PARACETAMOL', '2021-01-19', '2021-01-26', '5500.00', NULL),
(326, 'RP000108', '10S1004', 'stanley', '10-200', '10S1004', 'PT', '2021-01-29', 'admin', '2021-01-15 08:23:13', 'New Request', 1, 'ALCHOHOL', '2021-01-19', '2021-01-27', '700.00', NULL),
(327, 'RP000108', '10S1004', 'stanley', '10-200', '10S1004', 'PT', '2021-01-29', 'admin', '2021-01-15 08:23:13', 'New Request', 2, 'METANOL', '2021-01-26', '2021-01-29', '500.00', NULL),
(328, 'RP000109', '10S1003', 'Andi', '10-100', '10S1003', 'PT', '2021-01-21', 'admin', '2021-01-15 08:24:39', 'New Request', 1, 'PARACETAMOL', '2021-01-18', '2021-01-21', '30.00', NULL),
(329, 'RP000109', '10S1003', 'Andi', '10-100', '10S1003', 'PT', '2021-01-21', 'admin', '2021-01-18 03:54:29', 'Close', 1, 'PARACETAMOL', '2021-01-18', '2021-01-21', '30.00', 'RF000059'),
(330, 'RP000079', '10-200', 'sekian terima uang', '10-200', '10-200', 'R&D', '2020-11-28', 'adm1', '2021-01-18 05:02:47', 'Close', 1, 'ALCHOHOL', '2020-11-12', '2020-11-28', '900.00', 'WR000022'),
(331, 'RP000106', '10S1003', 'STANLEY', '10-200', '10S1003', 'PT', '2021-01-26', 'ADMIN', '2021-01-18 05:39:30', 'Close', 1, 'METANOL', '2021-01-19', '2021-01-21', '5000.00', 'WP000134'),
(332, 'RP000106', '10S1003', 'STANLEY', '10-200', '10S1003', 'PT', '2021-01-26', 'ADMIN', '2021-01-18 05:39:30', 'Close', 2, 'PARACETAMOL', '2021-01-19', '2021-01-26', '5500.00', 'WP000134'),
(333, 'RP000110', '10-300', 'AY', '10-100', '10-100', 'PT', '2021-02-16', 'admin', '2021-01-20 04:40:44', 'New Request', 1, 'ALCHOHOL', '2021-02-10', '2021-02-10', '100.00', NULL),
(334, 'RP000110', '10-300', 'AY', '10-100', '10-100', 'PT', '2021-02-16', 'admin', '2021-01-20 04:40:44', 'New Request', 2, 'METANOL', '2021-02-16', '2021-02-16', '100.00', NULL),
(335, 'RP000111', '10-300', 'admin', '10-100', '10-100', NULL, '2021-01-29', 'ay', '2021-01-20 04:48:01', 'New Request', 1, 'ALCHOHOL', '2021-01-26', '2021-01-26', '100.00', NULL),
(336, 'RP000111', '10-300', 'admin', '10-100', '10-100', NULL, '2021-01-29', 'ay', '2021-01-20 04:48:01', 'New Request', 2, 'PARACETAMOL', '2021-01-29', '2021-01-29', '200.00', NULL),
(337, 'RP000111', '10-300', 'admin', '10-100', '10-100', NULL, '2021-01-28', 'ay', '2021-01-20 04:57:54', 'New Request', 2, 'METANOL', '2021-01-28', '2021-01-28', '200.00', NULL),
(338, 'RP000113', '10-300', 'admin', '10-100', '10-100', NULL, '2021-01-29', 'ay', '2021-01-20 04:58:43', 'New Request', 1, 'METANOL', '2021-01-25', '2021-01-25', '100.00', NULL),
(339, 'RP000113', '10-300', 'admin', '10-100', '10-100', NULL, '2021-01-29', 'ay', '2021-01-20 04:58:43', 'New Request', 2, 'ALCHOHOL', '2021-01-29', '2021-01-29', '300.00', NULL),
(340, 'RP000115', '10-300', 'admin', '10-100', '10-100', 'IT', '2021-01-26', 'ay', '2021-01-20 05:02:15', 'New Request', 1, 'ALCHOHOL', '2021-01-25', '2021-01-25', '100.00', NULL),
(341, 'RP000115', '10-300', 'admin', '10-100', '10-100', 'IT', '2021-01-26', 'ay', '2021-01-20 05:02:15', 'New Request', 2, 'METANOL', '2021-01-26', '2021-01-26', '300.00', NULL),
(342, 'RP000115', '10-300', 'admin', '10-100', '10-100', 'IT', '2021-01-26', 'ay', '2021-01-20 05:03:46', 'Close', 1, 'ALCHOHOL', '2021-01-25', '2021-01-25', '100.00', 'RF000061'),
(343, 'RP000115', '10-300', 'admin', '10-100', '10-100', 'IT', '2021-01-26', 'ay', '2021-01-20 05:03:46', 'Close', 2, 'METANOL', '2021-01-26', '2021-01-26', '300.00', 'RF000062'),
(344, 'RP000116', '10S1005', 'test', '10-100', '10-100', 'R&D', '2021-01-24', 'adm1', '2021-01-22 01:46:11', 'New Request', 1, 'ALCHOHOL', '2021-01-22', '2021-01-24', '90.00', NULL),
(0, 'RP000117', '10S1003', NULL, '10-100', '10-100', 'FIN', '2021-02-19', 'admin', '2021-01-27 04:05:01', 'New Request', 1, 'panadol', '2021-02-04', '2021-02-19', '5.00', NULL),
(0, 'RP000075', '10S1003', 'test1', '10-100', '10S1003', 'R&D', '2021-02-24', 'mfg', '2021-02-23 07:45:33', 'New Request', 2, 'ALCHOHOL', '2021-02-23', '2021-02-24', '111.00', NULL),
(0, 'RP000075', '10S1003', 'test1', '10-100', '10S1003', 'R&D', '2021-02-24', 'mfg', '2021-02-23 07:45:33', 'New Request', 3, 'METANOL', '2021-02-23', '2021-02-24', '1.00', NULL),
(0, 'RP000117', '10S1003', NULL, '10-100', '10-100', 'FIN', '2021-04-05', 'admin', '2021-04-05 16:23:25', 'New Request', 1, 'panadol', '2021-02-04', '2021-02-19', '5.00', NULL),
(0, 'RP000117', '10-200', 'dynamo', '10-100', '10-100', 'FIN', '2021-04-05', 'admin', '2021-04-05 16:23:25', 'New Request', 2, 'panadol', '2021-02-04', '2021-02-19', '5.00', NULL),
(0, 'RP000117', '10S1003', NULL, '10-100', '10-100', 'FIN', '2021-04-05', 'admin', '2021-04-05 16:23:25', 'New Request', 3, 'ALCHOHOL', '2021-04-05', '2021-04-05', '10.00', NULL),
(0, 'RP000117', '10-200', 'dynamo', '10-100', '10-100', 'FIN', '2021-04-05', 'admin', '2021-04-05 16:23:25', 'New Request', 4, 'ALCHOHOL', '2021-04-05', '2021-04-05', '10.00', NULL),
(0, 'RP000117', '10S1003', NULL, '10-100', '10-100', 'FIN', '2021-04-16', 'admin1', '2021-04-07 02:16:30', 'New Request', 1, 'panadol', '2021-02-04', '2021-02-19', '5.00', NULL),
(0, 'RP000117', '10-200', 'dynamo', '10-100', '10-100', 'FIN', '2021-04-16', 'admin1', '2021-04-07 02:16:30', 'New Request', 2, 'panadol', '2021-02-04', '2021-02-19', '5.00', NULL),
(0, 'RP000117', '10S1003', 'mfg', '10-100', '10-100', NULL, '2021-04-16', 'admin1', '2021-04-07 02:16:30', 'New Request', 3, 'panadol', '2021-02-04', '2021-02-19', '5.00', NULL),
(0, 'RP000117', '10S1003', NULL, '10-100', '10-100', 'FIN', '2021-04-16', 'admin1', '2021-04-07 02:16:30', 'New Request', 4, 'ALCHOHOL', '2021-04-05', '2021-04-05', '10.00', NULL),
(0, 'RP000117', '10-200', 'dynamo', '10-100', '10-100', 'FIN', '2021-04-16', 'admin1', '2021-04-07 02:16:30', 'New Request', 5, 'ALCHOHOL', '2021-04-05', '2021-04-05', '10.00', NULL),
(0, 'RP000117', '10S1003', 'mfg', '10-100', '10-100', NULL, '2021-04-16', 'admin1', '2021-04-07 02:16:30', 'New Request', 6, 'ALCHOHOL', '2021-04-05', '2021-04-05', '10.00', NULL),
(0, 'RP000117', '10S1003', NULL, '10-100', '10-100', 'FIN', '2021-04-16', 'admin1', '2021-04-07 02:16:30', 'New Request', 7, 'ALCHOHOL', '2021-04-09', '2021-04-12', '10.00', NULL),
(0, 'RP000117', '10-200', 'dynamo', '10-100', '10-100', 'FIN', '2021-04-16', 'admin1', '2021-04-07 02:16:30', 'New Request', 8, 'ALCHOHOL', '2021-04-09', '2021-04-12', '10.00', NULL),
(0, 'RP000117', '10S1003', 'mfg', '10-100', '10-100', NULL, '2021-04-16', 'admin1', '2021-04-07 02:16:30', 'New Request', 9, 'ALCHOHOL', '2021-04-09', '2021-04-12', '10.00', NULL),
(0, 'RP000117', '10S1003', NULL, '10-100', '10-100', 'FIN', '2021-04-16', 'admin1', '2021-04-07 02:16:30', 'New Request', 10, 'METANOL', '2021-04-13', '2021-04-16', '15.00', NULL),
(0, 'RP000117', '10-200', 'dynamo', '10-100', '10-100', 'FIN', '2021-04-16', 'admin1', '2021-04-07 02:16:30', 'New Request', 11, 'METANOL', '2021-04-13', '2021-04-16', '15.00', NULL),
(0, 'RP000117', '10S1003', 'mfg', '10-100', '10-100', NULL, '2021-04-16', 'admin1', '2021-04-07 02:16:30', 'New Request', 12, 'METANOL', '2021-04-13', '2021-04-16', '15.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xrfp_mstrs`
--

CREATE TABLE `xrfp_mstrs` (
  `id` int(11) NOT NULL,
  `xrfp_nbr` varchar(20) NOT NULL,
  `xrfp_enduser` varchar(24) DEFAULT NULL,
  `xrfp_supp` varchar(24) DEFAULT NULL,
  `xrfp_shipto` varchar(24) DEFAULT NULL,
  `xrfp_site` varchar(24) DEFAULT NULL,
  `xrfp_dept` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xrfp_duedate` date DEFAULT NULL,
  `created_by` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  `status` varchar(24) DEFAULT NULL,
  `xrfp_sendmail` varchar(12) DEFAULT NULL,
  `remarks` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xrfp_mstrs`
--

INSERT INTO `xrfp_mstrs` (`id`, `xrfp_nbr`, `xrfp_enduser`, `xrfp_supp`, `xrfp_shipto`, `xrfp_site`, `xrfp_dept`, `xrfp_duedate`, `created_by`, `created_at`, `update_at`, `status`, `xrfp_sendmail`, `remarks`) VALUES
(1, 'RP000075', 'test1', '10S1003', '10S1003', '10-100', 'R&D', '2021-02-24', 'adm1', '2020-11-12 02:56:19', '2020-11-12 02:56:19', 'New Request', 'N', NULL),
(2, 'RP000076', 'lleeelele', '10S1005', '10S1005', '10-200', 'R&D', '2020-12-30', 'adm1', '2020-11-12 02:57:17', '2020-11-12 02:57:17', 'New Request', 'N', NULL),
(3, 'RP000077', 'rrererer', '10-200', '10-200', '10-300', 'R&D', '2021-04-14', 'adm1', '2020-11-12 02:57:42', '2020-11-12 02:57:42', 'Close', 'N', NULL),
(4, 'RP000078', 'test kesekian', '10-300', '10-300', '10-200', 'R&D', '2021-02-25', 'adm1', '2020-11-12 07:05:28', '2020-11-12 07:05:28', 'New Request', 'N', NULL),
(5, 'RP000079', 'sekian terima uang', '10-200', '10-200', '10-200', 'R&D', '2020-11-28', 'adm1', '2020-11-12 07:51:35', '2020-11-12 07:51:35', 'Close', 'N', NULL),
(6, 'RP000080', 'dadwd', '10S1003', '10S1003', '10-100', 'R&D', '2020-12-04', 'adm1', '2020-11-12 08:54:36', '2020-11-12 08:54:36', 'Close', 'N', NULL),
(7, 'RP000081', 'daddddddddddddddd', '10-200', '10-200', '10-100', 'R&D', '2021-01-05', 'adm1', '2020-11-12 08:59:12', '2020-11-12 08:59:12', 'Close', 'N', NULL),
(8, 'RP000082', 'stanley', '10S1003', '10S1003', '10-100', 'IT', '2020-11-20', 'admin2', '2020-11-13 05:04:18', '2020-11-13 05:04:18', 'Rejected', 'Y', NULL),
(9, 'RP000083', 'Bintang', '10-300', '10-300', '10-200', 'IT', '2020-11-26', 'admin2', '2020-11-13 05:09:27', '2020-11-13 05:09:27', 'Rejected', 'Y', NULL),
(10, 'RP000084', 'sty', '10-200', '10-200', '10-300', 'R&D', '2020-11-19', 'Bintang', '2020-11-13 07:35:44', '2020-11-13 07:35:44', 'Close', 'N', NULL),
(11, 'RP000085', 'bintang', '10-300', '10-300', '10-100', 'R&D', '2020-11-26', 'Bintang', '2020-11-13 07:36:35', '2020-11-13 07:36:35', 'Close', 'N', NULL),
(12, 'RP000086', 'andi', '10S1005', '10S1005', '10-100', 'R&D', '2020-11-27', 'Bintang', '2020-11-13 07:38:43', '2020-11-13 07:38:43', 'Close', 'N', NULL),
(13, 'RP000087', 'yesno', '10S1003', '10S1003', '10-100', 'R&D', '2020-12-05', 'adm1', '2020-11-25 10:38:22', '2020-11-25 10:38:22', 'New Request', 'N', NULL),
(14, 'RP000088', 'rerere', '10-300', '10-300', '10-300', 'R&D', '2020-11-30', 'adm1', '2020-11-25 10:48:16', '2020-11-25 10:48:16', 'Close', 'N', NULL),
(15, 'RP000089', 'tonystuck', '10-200', '10-200', '10-200', 'R&D', '2020-12-05', 'adm1', '2020-11-25 10:54:40', '2020-11-25 10:54:40', 'Close', 'N', NULL),
(16, 'RP000090', 'google', '10-300', '10-300', '10-200', 'R&D', '2020-11-28', 'test2', '2020-11-25 11:05:34', '2020-11-25 11:05:34', 'Approved', 'N', NULL),
(17, 'RP000091', 'Hujan', '10-200', '10-200', '10-300', 'R&D', '2020-12-25', 'test1', '2020-11-25 11:18:30', '2020-11-25 11:18:30', 'Close', 'N', NULL),
(18, 'RP000092', 'testttt', '10-200', '10-200', '10-200', 'R&D', '2020-12-11', 'test2', '2020-11-25 11:37:21', '2020-11-25 11:37:21', 'Close', 'N', NULL),
(19, 'RP000093', 'red', '10S1003', '10S1003', '10-200', 'R&D', '2021-01-21', 'test1', '2020-11-26 02:04:48', '2020-11-26 02:04:48', 'Approved', 'N', NULL),
(20, 'RP000094', 'hore', '10-200', '10-200', '10-200', 'R&D', '2020-12-09', 'test2', '2020-11-26 09:06:01', '2020-11-26 09:06:01', 'Close', 'N', NULL),
(21, 'RP000095', 'test', '10-200', '10-200', '10-100', 'R&D', '2020-12-31', 'adm1', '2020-12-14 04:31:59', '2020-12-14 04:31:59', 'New Request', 'N', NULL),
(22, 'RP000096', 'hello2', '10S1003', '10S1003', '10-300', 'R&D', '2021-01-10', 'adm1', '2020-12-14 05:10:14', '2020-12-14 05:10:14', 'New Request', 'N', NULL),
(23, 'RP000097', 'Black', '10S1005', '10S1005', '10-200', 'R&D', '2021-01-10', 'adm1', '2020-12-14 05:11:07', '2020-12-14 05:11:07', 'Close', 'N', NULL),
(24, 'RP000098', 'Test30', '10-300', '10-300', '10-200', 'R&D', '2021-01-09', 'adm1', '2020-12-30 10:10:38', '2020-12-30 10:10:38', 'Close', 'N', NULL),
(25, 'RP000099', 'mfg', '10S1004', '10S1004', '10-300', 'IT', '2021-01-11', 'admin2', '2021-01-04 07:25:39', '2021-01-04 07:25:39', 'Close', 'N', NULL),
(26, 'RP000100', 'mfg', '10S1003', '10S1003', '10-300', 'IT', '2021-01-15', 'admin2', '2021-01-04 07:53:39', '2021-01-04 07:53:39', 'Close', 'N', NULL),
(27, 'RP000101', 'testpr1', '10S1003', '10S1003', '10-100', 'R&D', '2021-01-17', 'test1', '2021-01-04 08:59:24', '2021-01-04 08:59:24', 'Close', 'N', NULL),
(28, 'RP000102', 'tomy', '10S1003', '10S1003', '10-100', 'R&D', '2021-01-23', 'test1', '2021-01-04 09:15:06', '2021-01-04 09:15:06', 'Close', 'N', NULL),
(29, 'RP000103', 'pr2', '10-300', '10-300', '10-100', 'R&D', '2021-01-07', 'test1', '2021-01-04 09:20:29', '2021-01-04 09:20:29', 'Close', 'N', NULL),
(30, 'RP000104', 'pr4', '10-200', '10-200', '10-100', 'R&D', '2021-01-17', 'test1', '2021-01-04 09:23:58', '2021-01-04 09:23:58', 'Close', 'N', NULL),
(31, 'RP000105', 'pr5', '10S1003', '10S1003', '10-200', 'R&D', '2021-01-10', 'test1', '2021-01-04 09:45:12', '2021-01-04 09:45:12', 'Close', 'N', NULL),
(32, 'RP000106', 'STANLEY', '10S1003', '10S1003', '10-200', 'PT', '2021-01-26', 'admin', '2021-01-15 04:57:09', '2021-01-15 04:57:09', 'Close', 'Y', NULL),
(33, 'RP000108', 'stanley', '10S1004', '10S1004', '10-200', 'PT', '2021-01-29', 'admin', '2021-01-15 08:23:13', '2021-01-15 08:23:13', 'Approved', 'N', NULL),
(34, 'RP000109', 'Andi', '10S1003', '10S1003', '10-100', 'PT', '2021-01-21', 'admin', '2021-01-15 08:24:39', '2021-01-15 08:24:39', 'Close', 'N', NULL),
(35, 'RP000110', 'AY', '10-300', '10-100', '10-100', 'PT', '2021-02-16', 'admin', '2021-01-20 04:40:44', '2021-01-20 04:40:44', 'New Request', 'Y', NULL),
(36, 'RP000111', 'admin', '10-300', '10-100', '10-100', NULL, '2021-01-28', 'ay', '2021-01-20 04:48:01', '2021-01-20 04:48:01', 'New Request', 'Y', NULL),
(37, 'RP000113', 'admin', '10-300', '10-100', '10-100', NULL, '2021-01-29', 'ay', '2021-01-20 04:58:43', '2021-01-20 04:58:43', 'New Request', 'Y', NULL),
(38, 'RP000115', 'admin', '10-300', '10-100', '10-100', 'IT', '2021-01-26', 'ay', '2021-01-20 05:02:15', '2021-01-20 05:02:15', 'Close', 'Y', NULL),
(39, 'RP000116', 'test', '10S1005', '10-100', '10-100', 'R&D', '2021-01-24', 'adm1', '2021-01-22 01:46:11', '2021-01-22 01:46:11', 'New Request', 'N', NULL),
(40, 'RP000117', NULL, '10S1003', '10-100', '10-100', 'FIN', '2021-04-16', 'admin', '2021-01-27 04:05:01', '2021-01-27 04:05:01', 'New Request', 'Y', NULL),
(41, 'RP000117', 'dynamo', '10-200', '10-100', '10-100', 'FIN', '2021-04-16', 'admin', '2021-04-05 16:23:25', '2021-04-05 16:23:25', 'New Request', 'Y', NULL),
(42, 'RP000117', 'mfg', '10S1003', '10-100', '10-100', NULL, '2021-04-16', 'admin1', '2021-04-07 02:16:30', '2021-04-07 02:16:30', 'New Request', 'N', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xrfq_mstrs`
--

CREATE TABLE `xrfq_mstrs` (
  `xrfq_id` int(11) NOT NULL,
  `xrfq_prefix` varchar(10) NOT NULL,
  `xrfq_nbr` varchar(20) NOT NULL,
  `xrfq_pr` varchar(10) NOT NULL,
  `xrfq_po` varchar(10) NOT NULL,
  `xrfq_po_prefix` varchar(20) DEFAULT NULL,
  `xrfq_po_nbr` varchar(10) DEFAULT NULL,
  `xrfq_pr_prefix` varchar(20) DEFAULT NULL,
  `xrfq_pr_nbr` varchar(10) DEFAULT NULL,
  `xrfq_rfp_prefix` varchar(10) NOT NULL,
  `xrfq_rfp_nbr` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xrfq_mstrs`
--

INSERT INTO `xrfq_mstrs` (`xrfq_id`, `xrfq_prefix`, `xrfq_nbr`, `xrfq_pr`, `xrfq_po`, `xrfq_po_prefix`, `xrfq_po_nbr`, `xrfq_pr_prefix`, `xrfq_pr_nbr`, `xrfq_rfp_prefix`, `xrfq_rfp_nbr`) VALUES
(11, 'RF', '000067', 'Yes', 'Yes', 'WP', '000136', 'WR', '000023', 'RP', '000118');

-- --------------------------------------------------------

--
-- Table structure for table `xsite_mstr`
--

CREATE TABLE `xsite_mstr` (
  `xsite_domain` varchar(8) NOT NULL,
  `xsite_site` varchar(8) NOT NULL,
  `xsite_desc` varchar(100) NOT NULL,
  `xsite_act` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xsite_mstr`
--

INSERT INTO `xsite_mstr` (`xsite_domain`, `xsite_site`, `xsite_desc`, `xsite_act`) VALUES
('10USA', '10-100', 'Main Site', 'true'),
('10USA', '10-200', 'Secondary Site', 'true'),
('10USA', '10-300', 'Secondary Site', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `xsj_ctrl`
--

CREATE TABLE `xsj_ctrl` (
  `xsj_id` int(11) NOT NULL,
  `xsj_pref` varchar(2) NOT NULL,
  `xsj_year` int(11) NOT NULL,
  `xsj_per` varchar(2) NOT NULL,
  `xsj_run` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xsj_ctrl`
--

INSERT INTO `xsj_ctrl` (`xsj_id`, `xsj_pref`, `xsj_year`, `xsj_per`, `xsj_run`) VALUES
(1, 'sj', 2021, '01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xsj_mstr`
--

CREATE TABLE `xsj_mstr` (
  `xsj_sj` varchar(15) NOT NULL,
  `id` int(11) NOT NULL,
  `xsj_id` varchar(50) DEFAULT NULL COMMENT ' Surat Jalan',
  `xsj_po_nbr` varchar(50) NOT NULL COMMENT 'Po Number',
  `xsj_supp` varchar(50) NOT NULL COMMENT 'Supplier',
  `xsj_line` int(11) NOT NULL COMMENT 'Line',
  `xsj_part` varchar(50) NOT NULL COMMENT 'Item Number',
  `xsj_desc` varchar(100) NOT NULL,
  `xsj_qty_ord` decimal(10,0) NOT NULL,
  `xsj_qty_open` decimal(10,0) NOT NULL,
  `xsj_qty_ship` decimal(10,0) NOT NULL,
  `xsj_status` varchar(10) DEFAULT NULL,
  `xsj_crt_date` date DEFAULT NULL,
  `xsj_loc` varchar(10) DEFAULT NULL,
  `xsj_lot` varchar(50) DEFAULT NULL,
  `xsj_ref` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xsj_mstr`
--

INSERT INTO `xsj_mstr` (`xsj_sj`, `id`, `xsj_id`, `xsj_po_nbr`, `xsj_supp`, `xsj_line`, `xsj_part`, `xsj_desc`, `xsj_qty_ord`, `xsj_qty_open`, `xsj_qty_ship`, `xsj_status`, `xsj_crt_date`, `xsj_loc`, `xsj_lot`, `xsj_ref`) VALUES
('', 140, 'SJ000001', 'WP000034', '10S1004', 1, 'ALCHOHOL', 'PURCHASING ITEM TEST', '470', '0', '470', 'Created', NULL, NULL, NULL, NULL),
('', 141, 'SJ001', 'RCP6', '10S1003', 1, 'METANOL', 'NEW ITEM TEST', '150', '50', '100', 'Created', NULL, NULL, '010', NULL),
('', 142, 'SJ001', 'RCP6', '10S1003', 1, 'METANOL', 'NEW ITEM TEST', '150', '20', '30', 'Created', NULL, NULL, '20', NULL),
('', 143, 'SJ002', 'RCP11', '10S1003', 1, 'PARACETAMOL', 'NEW ITEM TEST', '150', '50', '100', 'Created', NULL, NULL, '010', NULL),
('', 144, 'SJ002', 'RCP11', '10S1003', 2, 'PANADOL', 'PANADOL TEST ITEM', '100', '20', '80', 'Created', NULL, NULL, '123', NULL),
('', 145, 'SJ002', 'RCP11', '10S1003', 3, 'ALCHOHOL', 'PURCHASING ITEM TEST', '100', '30', '70', 'Created', NULL, NULL, '010', NULL),
('', 146, 'SJ002', 'RCP6', '10S1003', 1, 'METANOL', 'NEW ITEM TEST', '150', '0', '20', 'Created', NULL, NULL, NULL, NULL),
('', 149, 'a1', 'RCP11', '10S1003', 1, 'PARACETAMOL', 'NEW ITEM TEST', '150', '35', '5', 'Created', NULL, NULL, NULL, NULL),
('sj2101005', 151, NULL, 'RCP7', '10s1003', 1, 'alchohol', 'PURCHASING ITEM TEST', '150', '120', '10', 'Created', NULL, NULL, NULL, NULL),
('sj2101006', 152, NULL, 'RCP7', '10s1003', 1, 'alchohol', 'PURCHASING ITEM TEST', '150', '110', '10', 'Created', NULL, NULL, NULL, NULL),
('sj2101008', 154, 'aq1', 'RCP7', '10s1003', 1, 'alchohol', 'PURCHASING ITEM TEST', '150', '105', '5', 'Created', NULL, NULL, NULL, NULL),
('sj2101009', 155, 's129', 'RCP7', '10s1003', 1, 'alchohol', 'PURCHASING ITEM TEST', '150', '80', '10', 'Created', NULL, NULL, NULL, NULL),
('sj2101010', 156, 'a1', 'RCP7', '10s1003', 1, 'alchohol', 'PURCHASING ITEM TEST', '150', '85', '5', 'Created', NULL, NULL, NULL, NULL),
('sj2101012', 158, 'SJ001', 'RCP10', '10s1003', 1, 'paracetamol', 'NEW ITEM TEST', '1', '0', '1', 'Created', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xsuppinv_mstr`
--

CREATE TABLE `xsuppinv_mstr` (
  `id` int(15) NOT NULL,
  `xitem_nbr` varchar(50) CHARACTER SET latin1 NOT NULL,
  `xitem_desc` varchar(50) CHARACTER SET latin1 NOT NULL,
  `xsupp` varchar(20) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xsuppinv_mstr`
--

INSERT INTO `xsuppinv_mstr` (`id`, `xitem_nbr`, `xitem_desc`, `xsupp`) VALUES
(1, '60007', '', '10-200'),
(2, '60002', '', '10S1003'),
(4, '60080', '', '10-200'),
(5, '60007', '', '10L1001');

-- --------------------------------------------------------

--
-- Table structure for table `xsurel_mstrs`
--

CREATE TABLE `xsurel_mstrs` (
  `xsurel_id` int(11) NOT NULL,
  `xsurel_part` varchar(50) NOT NULL COMMENT 'Item Number',
  `xsurel_supp` varchar(50) NOT NULL COMMENT 'supplier'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xsurel_mstrs`
--

INSERT INTO `xsurel_mstrs` (`xsurel_id`, `xsurel_part`, `xsurel_supp`) VALUES
(10, 'JS001', '10S1002'),
(11, 'JS002', '10S1002'),
(15, '60002', '10S1003'),
(16, '60002', '10-200'),
(20, 'JS001', '10-300'),
(21, 'ALCHOHOL', '10S1004'),
(0, 'METANOL', '10S1004');

-- --------------------------------------------------------

--
-- Table structure for table `xtransaction`
--

CREATE TABLE `xtransaction` (
  `xtr_id` int(11) NOT NULL,
  `xtr_type` varchar(50) NOT NULL,
  `xtr_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xtransaction`
--

INSERT INTO `xtransaction` (`xtr_id`, `xtr_type`, `xtr_code`) VALUES
(1, 'Purchase Order Maintenance', 'ADD-PO'),
(2, 'Purchase Order Booking', 'ORD-PO'),
(4, 'Sales Order Return', 'RCT-SOR'),
(6, 'Unplanned Receipt', 'RCT-UNP'),
(7, 'Sales Order Booking (Order)', 'ORD-SO'),
(10, 'Sales Order Shipments', 'ISS-SO');

-- --------------------------------------------------------

--
-- Table structure for table `xtrhist`
--

CREATE TABLE `xtrhist` (
  `id` int(11) NOT NULL,
  `xtrhist_domain` varchar(8) NOT NULL,
  `xtrhist_part` varchar(18) NOT NULL,
  `xtrhist_desc` varchar(50) NOT NULL,
  `xtrhist_um` varchar(3) NOT NULL,
  `xtrhist_pm` varchar(10) NOT NULL,
  `xtrhist_qty_oh` decimal(10,0) NOT NULL,
  `xtrhist_last_date` date NOT NULL,
  `xtrhist_days` int(11) NOT NULL,
  `xtrhist_amt` decimal(10,0) NOT NULL,
  `xtrhist_ket1` varchar(8) NOT NULL,
  `xtrhist_ket2` varchar(8) NOT NULL,
  `xtrhist_ket3` varchar(8) NOT NULL,
  `xtrhist_ket4` varchar(8) NOT NULL,
  `xtrhist_type` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xtrhist`
--

INSERT INTO `xtrhist` (`id`, `xtrhist_domain`, `xtrhist_part`, `xtrhist_desc`, `xtrhist_um`, `xtrhist_pm`, `xtrhist_qty_oh`, `xtrhist_last_date`, `xtrhist_days`, `xtrhist_amt`, `xtrhist_ket1`, `xtrhist_ket2`, `xtrhist_ket3`, `xtrhist_ket4`, `xtrhist_type`) VALUES
(1, '10USA', '01010', 'tes125t text123', 'EA', 'M', '12', '2020-06-23', 10, '30000', '30', '', '', '', 'ORD-PO'),
(2, '10USA', '01011', 'Supplies Kit ', 'EA', 'C', '155', '2020-06-23', 0, '0', '', '', '', '', 'RCT-UNP'),
(3, '10USA', '01012', 'Sterile Probe Covers, 20 One time use', 'BX', 'P', '675', '2017-06-13', 1106, '14850', '30', '90', '', '', 'ISS-FAS'),
(5, '10USA', '01020', 'wwewqeqweqwe ', 'EA', 'M', '10', '2020-05-21', 33, '65700', '30', '', '', '', 'RCT-UNP'),
(6, '10USA', '01021', 'Surgical Kit ', 'EA', 'C', '150', '2019-07-16', 343, '0', '30', '90', '180', '', 'ORD-PO'),
(22, '10USA', '01040P', 'Industrial Ultrasound Planning Item', 'EA', '', '0', '2015-12-16', 1651, '0', '30', '90', '180', '365', 'CST-ADJ'),
(23, '10USA', '01041', 'Portable 10mhz Ultrasnd ', 'EA', 'M', '500', '2015-12-16', 1651, '1375000', '30', '90', '180', '365', 'CST-ADJ'),
(29, '10USA', '02001', 'Automotive Connector ', 'EA', 'L', '61389', '2020-03-04', 111, '107431', '30', '90', '', '', 'RCT-CHL'),
(30, '10USA', '02002', 'Electrical Connector  ', 'EA', 'P', '63944', '2017-06-13', 1106, '319720', '30', '90', '180', '', 'ISS-SO'),
(31, '10USA', '02003', 'Standard Connector  ', 'EA', 'M', '61351', '2017-06-13', 1106, '143561', '30', '90', '180', '', 'ISS-SO'),
(32, '10USA', '02004', 'Laptop Connector ', 'EA', 'M', '64271', '2017-06-13', 1106, '144610', '30', '90', '', '', 'ISS-SO'),
(33, '10USA', '02005', 'Valve Connector ', 'EA', 'L', '54264', '2017-06-13', 1106, '91164', '30', '90', '180', '365', 'ISS-SO'),
(36, '10USA', '02200', 'Motor Asm 8 Way Seat Adj  24V amp 2 hp', 'EA', 'L', '530694', '2017-06-13', 1106, '26534700', '30', '90', '180', '365', 'ISS-SO'),
(37, '10USA', '02210', 'Motor Asm 6-Way Seat Adj 24V 3 amp 1.hp', 'EA', 'L', '160', '2015-12-17', 1650, '8000', '30', '90', '180', '365', 'RCT-UNP'),
(39, '10USA', '02303', 'Compact Valve Assembly  OEM HighV Customer C', 'EA', 'L', '12', '2017-05-25', 1125, '354', '30', '90', '180', '365', 'ORD-SO'),
(41, '10USA', '02305', 'Compact Valve Assembly DRP Demand', 'EA', 'L', '30', '2017-05-25', 1125, '1035', '30', '90', '180', '365', 'ORD-SO'),
(42, '10USA', '02306', 'Compact Valve Assembly Build To Forecast', 'EA', 'L', '610', '2017-05-25', 1125, '17995', '30', '90', '180', '365', 'ORD-SO'),
(43, '10USA', '02307', 'Compact Valve Assembly MTO A - Discrete', 'EA', 'M', '13', '2017-05-25', 1125, '384', '30', '90', '180', '365', 'ORD-SO'),
(44, '10USA', '02308', 'Compact Valve Assembly MTO B - Discrete', 'EA', 'M', '6', '2017-05-25', 1125, '177', '30', '90', '180', '365', 'ORD-SO'),
(45, '10USA', '03011', 'Pump/Refill, Medical Assortment', 'EA', 'M', '6', '2017-06-13', 1106, '72', '30', '90', '180', '365', 'ISS-SO'),
(46, '10USA', '03012', '2-.5l Bottles, Medical Multi-Pack', 'EA', 'M', '3', '2017-06-13', 1106, '33', '30', '90', '180', '', 'ISS-SO'),
(48, '10USA', '03021', 'Pump/Refill, Unscented Assortment', 'EA', 'M', '1044', '2017-06-13', 1106, '9386', '30', '90', '', '', 'ISS-SO'),
(49, '10USA', '03022', '2-.5l Bottles, Unscented Multi-Pack', 'EA', 'M', '586', '2017-06-13', 1106, '5268', '30', '90', '180', '365', 'ISS-SO'),
(50, '10USA', '03023', '4-.5l Bottles, Unscented Multi-Pack', 'EA', 'M', '1044', '2017-06-13', 1106, '16704', '30', '90', '180', '', 'ISS-SO'),
(51, '10USA', '03031', 'Pump/Refill, Scented Assortment', 'EA', 'M', '13200', '2017-06-12', 1107, '118668', '30', '90', '180', '365', 'CONS-WO'),
(52, '10USA', '03032', '2-.5l Bottles, Scented Multi-Pack', 'EA', 'M', '13200', '2017-06-12', 1107, '118668', '30', '90', '', '', 'CONS-WO'),
(53, '10USA', '03033', '4-.5l Bottles, Scented Multi-Pack', 'EA', 'M', '1044', '2017-06-13', 1106, '16704', '30', '90', '180', '365', 'ISS-SO'),
(54, '10USA', '03040', 'Lubricant 4l tub ', 'EA', 'M', '150', '2017-06-13', 1106, '7950', '30', '90', '180', '365', 'ISS-FAS'),
(55, '10USA', '03041', '50-5 ml tube Gel Anesthetic', 'BX', 'M', '225', '2017-06-13', 1106, '900', '30', '90', '180', '365', 'ISS-SO'),
(56, '10USA', '03042', '25-15ml tube Gel Anesthetic', 'BX', 'M', '225', '2017-06-13', 1106, '1125', '30', '90', '180', '', 'ISS-SO'),
(57, '10USA', '03043', '20-25ml tube Gel Anesthetic', 'BX', 'M', '225', '2017-06-13', 1106, '1350', '30', '90', '180', '', 'ISS-SO'),
(58, '10USA', '03090', '25 gallon Disinfectant Bulk', 'EA', 'M', '764', '2017-06-13', 1106, '229200', '30', '90', '180', '365', 'ISS-SO'),
(59, '10USA', '03110', 'Pump, Medical Disinfectant', 'EA', 'M', '30', '2017-06-12', 1107, '179', '30', '90', '', '', 'ISS-WO'),
(60, '10USA', '03111', '.5l Bottle, Medical Disinfectant', 'EA', 'M', '14', '2017-06-12', 1107, '111', '30', '90', '180', '365', 'ISS-WO'),
(61, '10USA', '03112', '1l Refill, Medical Disinfectant', 'EA', 'M', '30', '2017-06-12', 1107, '420', '30', '90', '180', '365', 'ISS-WO'),
(62, '10USA', '03120', 'Pump, Scented Disinfectant', 'EA', 'M', '420', '2017-06-12', 1107, '1365', '30', '90', '180', '365', 'ISS-WO'),
(63, '10USA', '03121', '.5l, Bottle Scented Disinfectant', 'EA', 'M', '300', '2017-06-12', 1107, '1245', '30', '90', '180', '365', 'ISS-WO'),
(64, '10USA', '03122', '1l Bottle, Scented Disinfectant', 'EA', 'M', '420', '2017-06-12', 1107, '2936', '30', '90', '180', '365', 'ISS-WO'),
(65, '10USA', '03130', 'Pump, Unscented Disinfectant', 'EA', 'M', '420', '2017-06-12', 1107, '1365', '30', '90', '180', '365', 'ISS-WO'),
(66, '10USA', '03131', '.5l Bottle, Unscented Disinfectant', 'EA', 'M', '540', '2017-06-12', 1107, '2241', '30', '90', '180', '365', 'ISS-WO'),
(67, '10USA', '03132', '1l Bottle, Unscented Disinfectant', 'EA', 'M', '340', '2017-06-12', 1107, '2377', '30', '90', '180', '365', 'ISS-WO'),
(68, '10USA', '04001', 'Fruit Juice  750 ml Bottle', 'EA', 'L', '202', '2017-06-13', 1106, '261', '30', '90', '180', '365', 'ISS-SO'),
(76, '10USA', '50001', 'Probe Unit - 10 Mhz ', 'EA', 'M', '1', '2017-06-12', 1107, '1320', '30', '90', '180', '365', 'ISS-WO'),
(77, '10USA', '50002', 'Probe Unit - 500 kHz ', 'EA', 'M', '60', '2015-12-16', 1651, '56700', '30', '90', '180', '365', 'CST-ADJ'),
(92, '10USA', '60002', 'Display / Readout tess', 'EA', 'P', '872', '2017-06-12', 1107, '106384', '30', '90', '180', '', 'ISS-WO'),
(93, '10USA', '60003', 'Keyboard ', 'EA', 'P', '806', '2017-06-12', 1107, '44330', '30', '90', '180', '', 'ISS-WO'),
(95, '10USA', '60005', 'Battery ', 'EA', 'P', '7050', '2020-06-02', 21, '17978', '', '', '', '', 'ORD-PO'),
(96, '10USA', '60006', 'Monitor Cable ', 'EA', 'P', '315', '2017-06-12', 1107, '6300', '30', '90', '180', '', 'ISS-WO'),
(97, '10USA', '60007', 'Movable Cart ', 'EA', 'P', '4482', '2017-06-12', 1107, '1281852', '30', '90', '180', '365', 'ISS-WO'),
(98, '10USA', '60008', 'Printer ', 'EA', 'P', '402', '2017-06-12', 1107, '124620', '30', '90', '', '', 'ISS-WO'),
(105, '10USA', '60014', 'Software CD ', 'EA', 'P', '1290', '2017-06-05', 1114, '161250', '30', '90', '180', '365', 'RCT-PO'),
(106, '10USA', '60030', 'Ultrasound Cart Assembled To Order', 'EA', 'C', '0', '2015-12-16', 1651, '0', '30', '90', '180', '365', 'CST-ADJ'),
(107, '10USA', '60050', 'Base Unit / CPU  ', 'EA', 'P', '373', '2017-06-12', 1107, '544580', '30', '90', '180', '365', 'ISS-WO'),
(108, '10USA', '60051', 'Microprocessor IM Rev. A ', 'EA', 'P', '201', '2017-06-12', 1107, '57285', '30', '90', '180', '365', 'ISS-WO'),
(115, '10USA', '60080', 'Power Cord - UK ', 'EA', 'P', '1634', '2020-06-23', 0, '24510', '', '', '', '', 'ORD-PO'),
(116, '10USA', '60081', 'Power Cord - US ', 'EA', 'P', '1634', '2020-06-23', 0, '24510', '', '', '', '', 'ORD-PO'),
(117, '10USA', '60082', 'Power Cord - Australia ', 'EA', 'P', '1634', '2020-06-23', 0, '24510', '', '', '', '', 'ORD-PO'),
(118, '10USA', '60083', 'Power Cord - Universal ', 'EA', 'P', '1634', '2020-06-23', 0, '24510', '', '', '', '', 'ORD-PO'),
(119, '10USA', '60088', 'Power Converter-Standard ', 'EA', 'P', '1634', '2020-06-23', 0, '98040', '', '', '', '', 'ORD-PO'),
(120, '10USA', '60089', 'Power Converter - Smart ', 'EA', 'P', '1634', '2020-06-23', 0, '122550', '', '', '', '', 'ORD-PO'),
(126, '10USA', '62003', 'Seal Discrete PO', 'EA', 'P', '10000', '2020-03-16', 1000, '250000', '30', '90', '', '', 'ORD-PO'),
(136, '10USA', '62291', 'Tool Forming Die  Life ', 'EA', '', '20087', '2017-06-07', 1112, '0', '30', '90', '180', '365', 'ISS-WO'),
(172, '10USA', '80044', 'Xanthan Gum Powder', 'G', 'P', '0', '2019-07-16', 1000, '150000', '30', '90', '180', '', 'ORD-PO'),
(222, '10USA', 'CT20800120', 'front back label playboy ', 'EA', '', '0', '2019-12-30', 176, '0', '30', '90', '', '', 'CST-ADJ'),
(223, '10USA', 'item a', ' ', 'EA', '', '3', '2020-06-02', 21, '0', '', '', '', '', 'RCT-CHL'),
(224, '10USA', 'item d', ' ', 'EA', '', '500', '2020-06-01', 22, '0', '', '', '', '', 'RCT-UNP'),
(230, '10USA', 'tpart', 'tess tes1', 'EA', '', '200', '2020-03-10', 105, '60000', '30', '90', '', '', 'RCT-UNP');

-- --------------------------------------------------------

--
-- Table structure for table `xxrole_mstrs`
--

CREATE TABLE `xxrole_mstrs` (
  `id` int(11) NOT NULL,
  `xxrole_domain` varchar(10) NOT NULL,
  `xxrole_type` varchar(15) NOT NULL,
  `xxrole_role` varchar(50) NOT NULL,
  `xxrole_desc` varchar(100) DEFAULT NULL,
  `xxrole_flag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xxrole_mstrs`
--

INSERT INTO `xxrole_mstrs` (`id`, `xxrole_domain`, `xxrole_type`, `xxrole_role`, `xxrole_desc`, `xxrole_flag`) VALUES
(0, '10USA', 'Supplier', 'Bea Cukai', 'ini astari', 'RF03'),
(2, 'IMI', 'Admin', 'Admin', 'Admin IMI', 'PO01PO02PO03PO04PO05PO06PO07RF01RF02RF03RF04RF05RF06RFP01RFP02RFP03RFP04RFP05RFP06SH01SH02SH03SH04IV01IV02IV03ST01ST02ST03ST04ST05ST06ST07ST08ST09ST10ST11ST12ST13ST14ST15ST16PP01PP02HO01'),
(10, '10USA', 'Purchasing', 'Admin Purchasing', 'Admin Purchasing', 'PO01PO02PO03PO07PO06RF01RF02RF03RF04RF06RFP01RFP02RFP04RFP05ST15ST16PP01PP02'),
(11, '10USA', 'Purchasing', 'Purchasing', 'Spv Purchasing', 'PO01PO02RF02RF03RF04RFP01RFP02RFP04RFP05'),
(15, '10USA', 'Supplier', 'SPV Supplier', 'SPV Supplier', 'PO01SH01SH02SH03SH04IV01'),
(16, '10USA', 'Purchasing', 'Spv Purchasing', 'SPV Purchasing', 'PO01PO02PO03PO04RF01RF02RF03RF04IV02'),
(22, 'IMI', 'AdminIMI', 'AdminIMI', 'AdminIMI', 'PO01PO02PO03PO04PO07PO06RF01RF02RF03RF04PO05RF06RFP01RFP02RFP04RFP05RFP06SH01SH02SH03SH04IV01IV02IV03ST01ST02ST03ST04ST05ST06ST07ST08ST09ST10ST11ST12ST13ST14'),
(23, '10USA', 'Admin', 'Admin02', 'Wakil Admin', 'PO01PO02PO03PO04PO07PO06RF01RF02RF03RF04PO05RF06RFP01RFP02RFP04RFP05RFP06SH01SH02SH03SH04IV01IV02IV03ST01ST02ST03ST04ST05ST06ST07ST08ST09ST10ST11ST12ST13ST14ST15ST16'),
(24, '10USA', 'Purchasing', 'Mgr IT', 'Manager IT', 'RFP01RFP02ST13ST14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `com_mstr`
--
ALTER TABLE `com_mstr`
  ADD PRIMARY KEY (`com_name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_konversi`
--
ALTER TABLE `item_konversi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_um`
--
ALTER TABLE `item_um`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xalertitem_mstrs`
--
ALTER TABLE `xalertitem_mstrs`
  ADD PRIMARY KEY (`xalertitem_id`);

--
-- Indexes for table `xalert_mstrs`
--
ALTER TABLE `xalert_mstrs`
  ADD PRIMARY KEY (`xalert_id`);

--
-- Indexes for table `xbid_det`
--
ALTER TABLE `xbid_det`
  ADD PRIMARY KEY (`xbid_det_id`);

--
-- Indexes for table `xbid_hist`
--
ALTER TABLE `xbid_hist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xbid_mstr`
--
ALTER TABLE `xbid_mstr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xinvd_det`
--
ALTER TABLE `xinvd_det`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xinv_mstr`
--
ALTER TABLE `xinv_mstr`
  ADD PRIMARY KEY (`xinv_id`);

--
-- Indexes for table `xitem_mstr`
--
ALTER TABLE `xitem_mstr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xpod_dets`
--
ALTER TABLE `xpod_dets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xpo_app_hist`
--
ALTER TABLE `xpo_app_hist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xpo_app_trans`
--
ALTER TABLE `xpo_app_trans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xpo_hist`
--
ALTER TABLE `xpo_hist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xpo_mstrs`
--
ALTER TABLE `xpo_mstrs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xrfp_mstrs`
--
ALTER TABLE `xrfp_mstrs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xtrhist`
--
ALTER TABLE `xtrhist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `xxrole_mstrs`
--
ALTER TABLE `xxrole_mstrs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xbid_det`
--
ALTER TABLE `xbid_det`
  MODIFY `xbid_det_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=491;

--
-- AUTO_INCREMENT for table `xbid_hist`
--
ALTER TABLE `xbid_hist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `xbid_mstr`
--
ALTER TABLE `xbid_mstr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `xinvd_det`
--
ALTER TABLE `xinvd_det`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `xinv_mstr`
--
ALTER TABLE `xinv_mstr`
  MODIFY `xinv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=338;

--
-- AUTO_INCREMENT for table `xitem_mstr`
--
ALTER TABLE `xitem_mstr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `xpod_dets`
--
ALTER TABLE `xpod_dets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4476;

--
-- AUTO_INCREMENT for table `xpo_hist`
--
ALTER TABLE `xpo_hist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7940;

--
-- AUTO_INCREMENT for table `xpo_mstrs`
--
ALTER TABLE `xpo_mstrs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `xrfp_mstrs`
--
ALTER TABLE `xrfp_mstrs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `xtrhist`
--
ALTER TABLE `xtrhist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
