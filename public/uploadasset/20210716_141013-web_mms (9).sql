-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2021 at 10:01 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_mms`
--

-- --------------------------------------------------------

--
-- Table structure for table `acceptance_image`
--

CREATE TABLE `acceptance_image` (
  `id` int(24) NOT NULL,
  `file_srnumber` varchar(30) DEFAULT NULL,
  `file_wonumber` varchar(30) DEFAULT NULL,
  `file_name` varchar(50) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acceptance_image`
--

INSERT INTO `acceptance_image` (`id`, `file_srnumber`, `file_wonumber`, `file_name`, `file_url`, `uploaded_at`) VALUES
(13, 'SR-21-0109', 'WO-21-0045', 'WhatsApp Image 2021-02-26 at 18.16.10.jpeg', '../public/upload/WhatsAppImage2021-02-26at18161014042021154208.jpeg', '2021-04-14 15:42:08'),
(14, 'SR-21-0109', 'WO-21-0045', 'WhatsApp Image 2021-03-03 at 13.51.24.jpeg', '../public/upload/WhatsAppImage2021-03-03at13512414042021154208.jpeg', '2021-04-14 15:42:08'),
(15, 'SR-21-0112', 'WO-21-0052', 'Screenshot.abc..png', '../public/upload/Screenshotabc14042021161000.png', '2021-04-14 16:10:00'),
(16, 'SR-21-0112', 'WO-21-0052', 'anydesk00005.png', '../public/upload/anydesk0000514042021161000.png', '2021-04-14 16:10:00'),
(17, 'SR-21-0126', 'WO-21-0060', 'density or purity.png', '../public/upload/densityorpurity16042021134841.png', '2021-04-16 13:48:41'),
(18, 'SR-21-0125', 'WO-21-0061', 'thiago-gomes-K0YuYMAwCTQ-unsplash.jpg', '../public/upload/thiago-gomes-K0YuYMAwCTQ-unsplash16042021135701.jpg', '2021-04-16 13:57:01'),
(19, 'SR-21-0125', 'WO-21-0061', 'diana-parkhouse-5RY9GtjPXZM-unsplash.jpg', '../public/upload/diana-parkhouse-5RY9GtjPXZM-unsplash16042021135701.jpg', '2021-04-16 13:57:01'),
(20, 'SR-21-0125', 'WO-21-0061', 'pexels-bess-hamiti-36487.jpg', '../public/upload/pexels-bess-hamiti-3648716042021135701.jpg', '2021-04-16 13:57:01'),
(21, 'SR-21-0113', 'WO-21-0053', 'density or purity.png', '../public/upload/densityorpurity16042021142213.png', '2021-04-16 14:22:13'),
(22, 'SR-21-0124', 'WO-21-0062', 'aolano v7 (2 bed).png', '../public/upload/aolanov7(2bed)16042021142222.png', '2021-04-16 14:22:22'),
(23, 'SR-21-0128', 'WO-21-0063', 'QAD.png', '../public/upload/QAD16042021142244.png', '2021-04-16 14:22:44'),
(24, 'SR-21-0129', 'WO-21-0064', 'thiago-gomes-K0YuYMAwCTQ-unsplash.jpg', '../public/upload/thiago-gomes-K0YuYMAwCTQ-unsplash16042021164745.jpg', '2021-04-16 16:47:45'),
(25, 'SR-21-0131', 'WO-21-0066', 'Copy of aolano v3-Sun', '../public/upload/16042021170242Copy of aolano v3-Sun', '2021-04-16 17:02:42'),
(26, 'SR-21-0130', 'WO-21-0065', 'diana-parkhouse-5RY9GtjPXZM-unsplash.jpg', '../public/upload/diana-parkhouse-5RY9GtjPXZM-unsplash19042021110038.jpg', '2021-04-19 11:00:38'),
(27, 'SR-21-0132', 'WO-21-0067', 'anna-wangler-_GqwoiT7QY8-unsplash.jpg', '../public/upload/anna-wangler-_GqwoiT7QY8-unsplash19042021110045.jpg', '2021-04-19 11:00:45'),
(28, 'SR-21-0134', 'WO-21-0068', 'patrick-fore-850jTF12RSQ-unsplash.jpg', '../public/upload/patrick-fore-850jTF12RSQ-unsplash19042021110054.jpg', '2021-04-19 11:00:54'),
(29, 'SR-21-0135', 'WO-21-0071', 'MAA_Edit.png', '../public/upload/MAA_Edit30042021111916.png', '2021-04-30 11:19:16'),
(30, 'SR-21-0135', 'WO-21-0071', 'carbon.png', '../public/upload/carbon30042021111916.png', '2021-04-30 11:19:16'),
(31, NULL, 'WO-21-0080', 'VB-WISUDA76 (1).JPG', '../public/upload/VB-WISUDA76(1)03052021093224.JPG', '2021-05-03 09:32:24'),
(32, NULL, 'WO-21-0080', 'database-table-icon-153219-free-icons-library-data', '../public/upload/database-table-icon-153219-free-icons-library-database-table-icon-png-626_62603052021093224.jpg', '2021-05-03 09:32:24'),
(33, NULL, 'WO-21-0080', 'Actavis-logo.png', '../public/upload/Actavis-logo03052021093224.png', '2021-05-03 09:32:24');

-- --------------------------------------------------------

--
-- Table structure for table `area_mstr`
--

CREATE TABLE `area_mstr` (
  `id` int(24) NOT NULL,
  `area_id` varchar(50) NOT NULL,
  `area_desc` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `area_mstr`
--

INSERT INTO `area_mstr` (`id`, `area_id`, `area_desc`, `created_at`, `updated_at`) VALUES
(6, 'SATU', 'lokasi satu', '2021-02-25 13:39:56', '2021-02-25 13:39:56');

-- --------------------------------------------------------

--
-- Table structure for table `asset_group`
--

CREATE TABLE `asset_group` (
  `ID` int(11) NOT NULL,
  `asgroup_code` varchar(10) NOT NULL,
  `asgroup_desc` varchar(50) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_group`
--

INSERT INTO `asset_group` (`ID`, `asgroup_code`, `asgroup_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(0, 'mobil', 'kendaraan roda empat', '2021-03-29', '2021-03-29', 'ketik'),
(0, 'gedung', 'pabrik', '2021-03-29', '2021-03-29', 'ketik'),
(0, 'gudang', 'gudang', '2021-03-29', '2021-03-29', 'ketik'),
(0, 'office', 'perlengkapan kantor', '2021-03-29', '2021-03-29', 'ketik');

-- --------------------------------------------------------

--
-- Table structure for table `asset_mstr`
--

CREATE TABLE `asset_mstr` (
  `ID` int(11) NOT NULL,
  `asset_code` varchar(10) NOT NULL,
  `asset_desc` varchar(50) NOT NULL,
  `asset_site` varchar(10) NOT NULL,
  `asset_loc` varchar(10) NOT NULL,
  `asset_um` varchar(8) DEFAULT NULL,
  `asset_sn` varchar(25) DEFAULT NULL,
  `asset_daya` varchar(50) DEFAULT NULL,
  `asset_prc_date` date DEFAULT NULL,
  `asset_prc_price` decimal(13,2) DEFAULT NULL,
  `asset_type` varchar(10) DEFAULT NULL,
  `asset_group` varchar(10) DEFAULT NULL,
  `asset_failure` int(11) DEFAULT NULL,
  `asset_measure` varchar(1) DEFAULT NULL,
  `asset_supp` text DEFAULT NULL,
  `asset_meter` int(6) DEFAULT NULL,
  `asset_cal` int(11) DEFAULT NULL,
  `asset_last_usage` decimal(10,2) DEFAULT 0.00,
  `asset_last_usage_mtc` decimal(10,2) DEFAULT 0.00,
  `asset_last_mtc` date DEFAULT NULL,
  `asset_note` varchar(200) DEFAULT NULL,
  `asset_active` varchar(5) DEFAULT NULL,
  `asset_repair_type` varchar(50) DEFAULT NULL,
  `asset_repair` varchar(50) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_mstr`
--

INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'AC01', 'AC Panasonic', 'ACT', 'BLDG01', 'EA', '8291837', NULL, '2021-04-05', '4999000.00', 'atk', 'office', 0, 'C', 'SP001', 0, 90, '0.00', '0.00', '2021-04-05', 'AC', 'Yes', NULL, NULL, 2021, 2021, 'admin3'),
(2, 'AC02', 'AC Daikin', 'ACT', 'BLDG02', 'EA', '818192', NULL, '2021-04-05', '6500000.00', 'atk', 'gedung', 0, 'M', 'SP001', 100, NULL, '200.00', '200.00', '2021-04-05', 'Ini AC Daikin', NULL, NULL, NULL, 2021, 2021, 'rio'),
(4, 'MCH01', 'Wrap Machine', 'ACT', 'WH-PROD', 'UNIT', '123432', NULL, '2021-04-01', '6000000000.00', 'mesin', 'gedung', NULL, 'M', 'SP001', 1000, NULL, '1000.00', '1000.00', '2021-04-08', 'Abc', NULL, NULL, NULL, 2021, 2021, 'rio'),
(6, 'MCH02', 'Mixing Machine', 'ACT', 'WH-PROD', 'UNIT', '545678765456yfghf', NULL, '2021-04-07', '476898987.00', 'mesin', 'gedung', NULL, 'M', 'SP001', 7000, NULL, '0.00', '0.00', '2021-04-09', 'vjhvjhgu', NULL, NULL, NULL, 2021, 2021, 'rio'),
(7, 'MCH03', 'Mesin penggiling', 'ACT', 'WH-PROD', 'UNIT', 'ysoudh98331', NULL, '2021-04-06', '57789933.00', 'mesin', 'gudang', NULL, 'M', 'SP001', 5000, NULL, '0.00', '0.00', '2021-04-09', NULL, NULL, NULL, NULL, 2021, 2021, 'rio'),
(10, 'VHC01', 'Mobil Avanza', 'ACT', 'BLDG01', 'UNIT', '1234566543', NULL, '2021-04-01', NULL, 'atk', 'mobil', NULL, 'M', NULL, 5000, NULL, '50001.00', '50001.00', '2021-04-23', NULL, NULL, NULL, NULL, 2021, 2021, 'admin'),
(12, 'EQ-0003', 'Vari Mixer machine BEAR', 'ACT', 'GRN', NULL, 'R-60 5791', '1.71 KW', '1986-01-31', NULL, 'mesin', 'gedung', NULL, 'C', NULL, 0, 168, '0.00', '0.00', '2021-05-07', '24 minggu. asset tahun 1986, daya 1.71 KW', NULL, NULL, NULL, 2021, 2021, 'rio');

-- --------------------------------------------------------

--
-- Table structure for table `asset_par`
--

CREATE TABLE `asset_par` (
  `ID` int(11) NOT NULL,
  `aspar_par` varchar(10) NOT NULL,
  `aspar_child` varchar(10) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_par`
--

INSERT INTO `asset_par` (`ID`, `aspar_par`, `aspar_child`, `created_at`, `updated_at`, `edited_by`) VALUES
(54, 'MCH01', 'MCH02', '2021-04-15', '2021-04-15', 'rio'),
(55, 'MCH01', 'MCH03', '2021-04-15', '2021-04-15', 'rio'),
(61, 'VHC01', 'AC01', '2021-04-23', '2021-04-23', 'rio'),
(70, 'AC01', 'EQ-0003', '2021-05-21', '2021-05-21', 'admin3');

-- --------------------------------------------------------

--
-- Table structure for table `asset_type`
--

CREATE TABLE `asset_type` (
  `ID` int(11) NOT NULL,
  `astype_code` varchar(10) NOT NULL,
  `astype_desc` varchar(50) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_type`
--

INSERT INTO `asset_type` (`ID`, `astype_code`, `astype_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'tool', 'tool perbaikan', '2021-03-29', '2021-03-29', 'ketik'),
(2, 'mesin', 'mesin pabrik', '2021-03-29', '2021-03-29', 'ketik'),
(3, 'alat', 'peralatan perbaikan', '2021-03-29', '2021-04-07', 'tata'),
(4, 'atk', 'alat perkatoran', '2021-04-07', '2021-04-07', 'tata');

-- --------------------------------------------------------

--
-- Table structure for table `dept_mstr`
--

CREATE TABLE `dept_mstr` (
  `ID` int(11) NOT NULL,
  `dept_code` varchar(10) NOT NULL,
  `dept_desc` varchar(50) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dept_mstr`
--

INSERT INTO `dept_mstr` (`ID`, `dept_code`, `dept_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(12, 'HR', 'Human Resources', '2021-04-12', '2021-04-14', '0000-00-00'),
(13, 'IT', 'IT', '2021-04-12', '2021-04-14', '0000-00-00'),
(15, 'MKT', 'Marketing', '2021-04-12', '2021-04-12', '0000-00-00'),
(16, 'WHS', 'Warehouse', '2021-04-12', '2021-04-12', '0000-00-00'),
(17, 'ENG', 'Engineering', '2021-04-14', '2021-04-30', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `eng_mstr`
--

CREATE TABLE `eng_mstr` (
  `ID` int(11) NOT NULL,
  `eng_code` varchar(10) NOT NULL,
  `eng_desc` varchar(50) NOT NULL,
  `eng_dept` varchar(8) NOT NULL,
  `approver` int(1) NOT NULL,
  `eng_birth_date` date DEFAULT NULL,
  `eng_active` text NOT NULL,
  `eng_join_date` date DEFAULT NULL,
  `eng_rate_hour` decimal(7,2) DEFAULT NULL,
  `eng_skill` varchar(30) DEFAULT NULL,
  `eng_email` varchar(30) NOT NULL,
  `eng_photo` varchar(30) DEFAULT NULL,
  `eng_role` varchar(8) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `eng_mstr`
--

INSERT INTO `eng_mstr` (`ID`, `eng_code`, `eng_desc`, `eng_dept`, `approver`, `eng_birth_date`, `eng_active`, `eng_join_date`, `eng_rate_hour`, `eng_skill`, `eng_email`, `eng_photo`, `eng_role`, `created_at`, `updated_at`, `edited_by`) VALUES
(22, 'admin', 'Andrew Conan', 'ENG', 1, '2021-03-12', 'Yes', '2021-03-03', '121.00', '', 'abc@admin.com', 'admin', 'ADM', '2021-03-18', '2021-04-15', 'rio'),
(50, 'eng01', 'Engineer 01', 'ENG', 0, '2021-03-09', 'Yes', '2021-04-01', '50000.00', ',SK02,SK04,', 'eng01@gmail.com', '', 'TECH', '2021-04-09', '2021-04-22', 'admin'),
(51, 'eng02', 'Engineer 02', 'ENG', 0, '2021-03-30', 'Yes', '2021-04-01', '45000.00', 'SK06,', 'eng02@gmail.com', '', 'TECH', '2021-04-09', '2021-04-22', 'admin'),
(52, 'eng03', 'Engineer 03', 'ENG', 0, '2021-03-31', 'No', '2021-04-02', '47500.00', 'SK04,SK05,', 'eng03@gmail.com', '', 'TECH', '2021-04-09', '2021-04-15', 'ketik'),
(53, 'spv01', 'Spv 01', 'ENG', 1, '2021-04-01', 'Yes', '2021-04-01', NULL, '', 'spv01@gmail.com', '', 'SPV', '2021-04-09', '2021-04-14', 'rio'),
(54, 'spv02', 'Spv 02', 'ENG', 1, NULL, 'Yes', NULL, NULL, '', 'spv02@gmail.com', '', 'SPV', '2021-04-09', '2021-04-14', 'rio'),
(55, 'rio', 'rio', 'ENG', 1, NULL, 'Yes', NULL, NULL, '', 'rio@ptimi.co.id', NULL, 'ADM', NULL, '2021-04-22', 'admin'),
(56, 'admin2', 'admin2', 'ENG', 1, NULL, 'Yes', NULL, NULL, '', 'admin2@gmail.com', NULL, 'ADM', NULL, '2021-04-19', 'rio'),
(57, 'admin3', 'admin3', 'ENG', 1, NULL, 'Yes', NULL, NULL, '', 'admin3@email', '', 'ADM', '2021-04-23', '2021-04-23', 'admin3'),
(58, 'admin4', 'admin4', 'ENG', 1, '2021-12-31', 'Yes', '2021-12-31', '2.00', 'SK03,', 'admin4@gmail.com', '', 'ADM', '2021-04-23', '2021-04-23', 'admin3'),
(59, 'bintang', 'Bintang', 'ENG', 0, NULL, 'Yes', NULL, NULL, '', 'bintang@ptimi.co.id', '', 'ADM', '2021-05-05', '2021-05-05', 'admin'),
(60, 'gamarai', 'Bintang', 'ENG', 0, NULL, 'Yes', NULL, NULL, '', 'bintang@ptimi.co.id', '', 'ADM', '2021-05-05', '2021-05-05', 'admin');

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
-- Table structure for table `fn_mstr`
--

CREATE TABLE `fn_mstr` (
  `ID` int(11) NOT NULL,
  `fn_code` varchar(10) NOT NULL,
  `fn_num` int(3) DEFAULT NULL,
  `fn_desc` varchar(50) NOT NULL,
  `fn_assetgroup` varchar(8) DEFAULT NULL,
  `fn_impact` varchar(50) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fn_mstr`
--

INSERT INTO `fn_mstr` (`ID`, `fn_code`, `fn_num`, `fn_desc`, `fn_assetgroup`, `fn_impact`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'FAC01', 1, 'Bocor', NULL, 'AC tidak dingin', '2021-04-05', '2021-04-07', 'tata'),
(4, 'FAC02', 1, 'Mesin berbunyi tidak normal', NULL, 'Polusi suara', '2021-04-09', '2021-05-06', 'admin'),
(5, 'FAC03', 1, 'Mesin bergetar abnormal', 'gedung', 'Baut aus', '2021-04-09', '2021-04-09', 'rio'),
(7, 'FAC04', NULL, 'Mesin berasap', NULL, 'berasap', '2021-04-23', '2021-05-20', 'rio'),
(12, 'Other', NULL, 'Other', NULL, 'Other', '2021-06-02', '2021-06-02', 'admin4');

-- --------------------------------------------------------

--
-- Table structure for table `ins_group`
--

CREATE TABLE `ins_group` (
  `ID` int(11) NOT NULL,
  `insg_code` varchar(20) NOT NULL,
  `insg_desc` varchar(50) NOT NULL,
  `insg_line` int(11) NOT NULL,
  `insg_ins` varchar(20) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ins_group`
--

INSERT INTO `ins_group` (`ID`, `insg_code`, `insg_desc`, `insg_line`, `insg_ins`, `created_at`, `updated_at`, `edited_by`) VALUES
(33, 'SRVCR01', 'servis mobil', 1, 'C01', '2021-05-06', '2021-05-06', 'admin'),
(34, 'SRVCR01', 'servis mobil', 2, 'C02', '2021-05-06', '2021-05-06', 'admin'),
(35, 'SRVCR01', 'servis mobil', 3, 'C03', '2021-05-06', '2021-05-06', 'admin'),
(36, 'EQ-0003M', 'EQ-0003Mekanik', 1, 'IC04', '2021-05-07', '2021-05-07', 'admin'),
(37, 'EQ-0003M', 'EQ-0003Mekanik', 2, 'IM02', '2021-05-07', '2021-05-07', 'admin'),
(38, 'EQ-0003M', 'EQ-0003Mekanik', 3, 'IM03', '2021-05-07', '2021-05-07', 'admin'),
(39, 'EQ-0003M', 'EQ-0003Mekanik', 4, 'IM04', '2021-05-07', '2021-05-07', 'admin'),
(40, 'SRVCR02', 'Servis mobil elektrik', 1, 'C04', '2021-05-17', '2021-05-17', 'admin'),
(41, 'SRVCR02', 'Servis mobil elektrik', 2, 'C05', '2021-05-17', '2021-05-17', 'admin'),
(42, 'EQ-0003E', 'EQ-0003Elektrik', 1, 'IC05', '2021-05-20', '2021-05-20', 'rio'),
(43, 'EQ-0003E', 'EQ-0003Elektrik', 2, 'IE02', '2021-05-20', '2021-05-20', 'rio'),
(44, 'EQ-0003E', 'EQ-0003Elektrik', 3, 'IE03', '2021-05-20', '2021-05-20', 'rio'),
(45, 'EQ-0003E', 'EQ-0003Elektrik', 4, 'IE04', '2021-05-20', '2021-05-20', 'rio');

-- --------------------------------------------------------

--
-- Table structure for table `ins_mstr`
--

CREATE TABLE `ins_mstr` (
  `ID` int(11) NOT NULL,
  `ins_code` varchar(10) NOT NULL,
  `ins_desc` varchar(200) NOT NULL,
  `ins_part` varchar(200) DEFAULT NULL,
  `ins_ref` varchar(50) DEFAULT NULL,
  `ins_tool` varchar(200) DEFAULT NULL,
  `ins_hour` decimal(11,2) DEFAULT NULL,
  `ins_check` varchar(200) DEFAULT NULL,
  `ins_check_desc` varchar(200) DEFAULT NULL,
  `ins_check_mea` varchar(200) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ins_mstr`
--

INSERT INTO `ins_mstr` (`ID`, `ins_code`, `ins_desc`, `ins_part`, `ins_ref`, `ins_tool`, `ins_hour`, `ins_check`, `ins_check_desc`, `ins_check_mea`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'IC01', 'Ganti Selang', NULL, '', NULL, NULL, NULL, NULL, NULL, '2021-04-05', '2021-04-05', 'admin2'),
(2, 'IC02', 'Tambah Freon', NULL, '', NULL, NULL, NULL, NULL, NULL, '2021-04-05', '2021-04-05', 'admin2'),
(3, 'IC03', 'Test AC', NULL, '', NULL, NULL, NULL, NULL, NULL, '2021-04-05', '2021-04-05', 'admin2'),
(4, 'IC04', 'Periksa Kondisi Motor', 'M07', NULL, '', '0.50', 'Terpasang baik & kuat', NULL, NULL, '2021-04-06', '2021-05-24', 'rio'),
(5, 'IC05', 'Periksa Koneksi Kabel motor', 'M07', NULL, 'TL01,', '0.50', 'Koneksi kencang & bersih', NULL, NULL, '2021-04-06', '2021-05-24', 'rio'),
(6, 'IM02', 'Periksa Getaran Pada Bearing, Terlumasi', 'M02', NULL, '', '0.50', 'Tidak ada getaran', NULL, NULL, '2021-04-06', '2021-05-24', 'rio'),
(7, 'IM03', 'Periksa Kondisi V-Belt', 'M05', NULL, 'TL02,TL03,', '0.50', 'Terpasang baik & kuat', NULL, NULL, '2021-04-06', '2021-05-24', 'rio'),
(8, 'IE02', 'Periksa Koneksi Kabel', 'M01', NULL, 'TL02,', '0.50', 'Koneksi kencang & bersih', NULL, NULL, '2021-04-06', '2021-05-24', 'rio'),
(9, 'IE03', 'Periksa Pengatur kecepatan mesin', 'M03', NULL, 'TL02,', '0.50', 'Berfungsi baik', NULL, NULL, '2021-04-06', '2021-05-24', 'rio'),
(10, 'IE04', 'Periksa  pengatur waktu', 'M04', NULL, 'TL01,', '0.50', 'Berfungsi baik', NULL, NULL, '2021-04-07', '2021-05-24', 'rio'),
(11, 'IM04', 'Periksa Kondisi guard Mesin', 'M06', NULL, 'TL01,', '0.50', 'Terpasang baik & kuat', NULL, NULL, '2021-04-07', '2021-05-24', 'rio'),
(14, 'C01', 'Ganti oli mesin', '', 'asset A', '', '0.50', 'Oli', NULL, NULL, '2021-05-06', '2021-05-24', 'admin3'),
(15, 'C02', 'ganti filter mesin', NULL, '', '', '0.50', 'filter mesin', 'filter', 'filter bersih', '2021-05-06', '2021-05-06', 'admin'),
(16, 'C03', 'Ganti kampas rem', NULL, '', '', '0.50', 'kampas rem', 'cek kampas', 'kampas rem tebal', '2021-05-06', '2021-05-06', 'admin'),
(20, 'C04', 'Cek aki mobil', '', '', '', '0.50', 'aki', 'akiiiiii', 'aki aki', '2021-05-11', '2021-05-11', 'admin'),
(21, 'C05', 'cek AC', '', '', '', '0.50', 'ac', 'ac ac', 'acccccc', '2021-05-11', '2021-05-11', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `inv_mstr`
--

CREATE TABLE `inv_mstr` (
  `ID` int(11) NOT NULL,
  `inv_site` varchar(8) NOT NULL,
  `inv_loc` varchar(8) NOT NULL,
  `inv_sp` varchar(8) NOT NULL,
  `inv_qty` decimal(11,2) NOT NULL,
  `inv_lot` varchar(25) DEFAULT NULL,
  `inv_supp` varchar(8) DEFAULT NULL,
  `inv_date` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inv_mstr`
--

INSERT INTO `inv_mstr` (`ID`, `inv_site`, `inv_loc`, `inv_sp`, `inv_qty`, `inv_lot`, `inv_supp`, `inv_date`, `created_at`, `updated_at`, `edited_by`) VALUES
(2, '1', '1', 'sekrup', '42.00', '121', 'aruna', '2021-04-11', '2021-03-22', '2021-03-22', 'admin'),
(5, 'ACT', 'WH-PROD', 'M01', '562.78', 'sn 1428', 'SP001', '2021-05-09', '2021-04-13', '2021-04-13', 'ketik');

-- --------------------------------------------------------

--
-- Table structure for table `loc_mstr`
--

CREATE TABLE `loc_mstr` (
  `ID` int(11) NOT NULL,
  `loc_site` varchar(10) NOT NULL,
  `loc_code` varchar(10) NOT NULL,
  `loc_desc` varchar(50) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loc_mstr`
--

INSERT INTO `loc_mstr` (`ID`, `loc_site`, `loc_code`, `loc_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'ACT', 'WH-RM', 'Gudang Raw Material', '2021-04-05', '2021-04-05', 'admin2'),
(2, 'ACT', 'BLDG01', 'Main Building', '2021-04-08', '2021-04-14', 'rio'),
(3, 'ACT', 'WH-PROD', 'Warehouse Production', '2021-04-08', '2021-04-08', 'rio'),
(6, 'ACT', 'BLDG02', 'Admin Office', '2021-04-14', '2021-04-14', 'rio'),
(7, 'ACT', 'BLDG03', 'Production Office', '2021-04-14', '2021-04-14', 'rio'),
(8, 'ACT', 'WH-FG', 'Warehouse Finish Good', '2021-04-14', '2021-04-14', 'rio'),
(9, 'ACT', 'GRN', 'Ruang Granulasi', '2021-05-07', '2021-05-07', 'admin');

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
(4, '2014_10_12_000000_create_users_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 1),
(6, '2019_08_19_000000_create_failed_jobs_table', 1),
(7, '2020_11_03_185712_create_notifications_table', 2);

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
('000b6771-ae2c-4a24-9ac8-e0657364e2ca', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0136\",\"note\":\"Please check\"}', '2021-04-30 06:14:08', '2021-04-23 03:39:29', '2021-04-30 06:14:08'),
('001c84ce-3ed2-4513-b7e8-e3516ec94b5f', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0042\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-01 10:19:37', '2021-04-05 05:41:51'),
('007018ca-b0eb-457f-bd1b-65cc5d7324de', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0084\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-04 04:58:52', '2021-05-20 06:56:25'),
('00a7a246-e463-445e-a0c2-9b29efa29079', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0136\",\"note\":\"Please check\"}', NULL, '2021-04-23 03:39:29', '2021-04-23 03:39:29'),
('01e3f179-2957-4389-a194-e4c7910ca805', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0085\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-05 06:52:44', '2021-05-20 06:56:25'),
('023e125d-5b26-44a9-b67c-8fad4a0c47f6', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0090\",\"note\":\"Please Check\"}', NULL, '2021-05-17 03:08:03', '2021-05-17 03:08:03'),
('02be0093-261a-460c-b3b7-8c6454536c58', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0146\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:09:50', '2021-05-21 08:09:50'),
('02e5a83c-5472-4e59-a583-63a9fbc0c471', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0092\",\"note\":\"Please Check\"}', '2021-05-21 07:50:56', '2021-05-20 06:51:21', '2021-05-21 07:50:56'),
('02ff9bf2-dd7c-475d-b6b2-e3e1ed6f4bd5', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0049\",\"note\":\"Please Check\"}', '2021-04-07 03:25:52', '2021-04-05 09:28:18', '2021-04-07 03:25:52'),
('03d2ba1d-cec6-4e78-93ee-c107f6490912', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0104\",\"note\":\"Please check\"}', NULL, '2021-05-27 05:11:11', '2021-05-27 05:11:11'),
('04d5bb77-b634-43c2-87be-62710d69a657', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0036\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-03-31 11:00:16', '2021-04-05 05:41:51'),
('0554b836-e340-4269-bdfe-092725b325b6', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0092\",\"note\":\"Please Check\"}', NULL, '2021-05-20 06:51:21', '2021-05-20 06:51:21'),
('0565523a-8ea9-4254-a8fb-14c53b52341b', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0017\",\"note\":\"Please check\"}', '2021-04-07 03:25:52', '2021-04-07 03:18:19', '2021-04-07 03:25:52'),
('05d8a642-a446-48a8-a206-98ddcbf28076', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0053\",\"note\":\"Please Check\"}', '2021-04-07 03:25:52', '2021-04-07 03:11:20', '2021-04-07 03:25:52'),
('05ed17a4-ca29-4357-88c4-4b3c125338cc', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0037\",\"note\":\"Please check\"}', NULL, '2021-04-01 07:49:14', '2021-04-01 07:49:14'),
('060194ec-185b-42df-9a4e-0930d6137aa8', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0147\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:20:45', '2021-05-21 08:20:45'),
('063f781f-5a7b-4444-b61b-873714b3cf99', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0101\",\"note\":\"Please Check\"}', NULL, '2021-05-24 08:16:52', '2021-05-24 08:16:52'),
('06c4def8-a164-44e4-aaf4-6623726a9c8b', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0111\",\"note\":\"Please check\"}', NULL, '2021-04-06 09:53:11', '2021-04-06 09:53:11'),
('075b9c4f-1d79-469b-865b-1e6f55577c11', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0113\",\"note\":\"Please check\"}', NULL, '2021-04-07 03:10:35', '2021-04-07 03:10:35'),
('07c289fc-91f9-4a00-997f-788bc457211a', 'App\\Notifications\\eventNotification', 'App\\User', 60, '{\"data\":\"Service Request Rejected\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0152\",\"note\":\"Please check\"}', '2021-05-24 09:34:17', '2021-05-24 09:33:41', '2021-05-24 09:34:17'),
('0849b26f-a828-4d73-984f-a0799c139ec3', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0083\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-03 07:04:01', '2021-05-20 06:56:25'),
('08507783-5253-44d7-bbd6-4aad606fcc61', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0135\",\"note\":\"Please check\"}', '2021-04-19 06:53:11', '2021-04-19 06:51:13', '2021-04-19 06:53:11'),
('089cddfe-66b7-45c5-9ef7-8c3dbc3540a6', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0138\",\"note\":\"Please Check\"}', '2021-05-18 02:29:40', '2021-04-30 08:01:17', '2021-05-18 02:29:40'),
('08b0708f-5ef4-40ce-9ff7-7be4ad5ff0b3', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0133\",\"note\":\"Please Check\"}', '2021-05-18 02:29:40', '2021-04-30 08:02:53', '2021-05-18 02:29:40'),
('08b2c792-ff57-446b-a944-e77e7d97d7e4', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0091\",\"note\":\"Please Check\"}', '2021-03-30 09:16:48', '2021-03-30 07:51:04', '2021-03-30 09:16:48'),
('08dab29a-a32f-4821-98cb-444a54da3aa6', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0078\",\"note\":\"Please Check\"}', NULL, '2021-04-30 08:02:49', '2021-04-30 08:02:49'),
('0929cae5-f5f4-49fa-9fff-eab7ff5dca9c', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0134\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-19 02:54:26', '2021-04-29 03:31:47'),
('0943309c-241e-484f-9947-afd144e21856', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0068\",\"note\":\"Please Check\"}', '2021-04-19 03:56:51', '2021-04-19 03:56:31', '2021-04-19 03:56:51'),
('0a71b958-e20e-4485-8d37-6c915d1f214d', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0006\",\"note\":\"Please check\"}', NULL, '2021-06-02 02:47:43', '2021-06-02 02:47:43'),
('0a8438ae-9ecd-4542-90ce-57c5ca855b49', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0123\",\"note\":\"Please Check\"}', NULL, '2021-04-09 07:53:45', '2021-04-09 07:53:45'),
('0b207583-d4ff-46d6-b47a-ddc2f6bba923', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0078\",\"note\":\"Please Check\"}', NULL, '2021-04-30 08:02:49', '2021-04-30 08:02:49'),
('0b23c42b-aa41-493d-a445-61377abd9a02', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0127\",\"note\":\"Please check\"}', '2021-04-16 07:28:40', '2021-04-16 02:38:05', '2021-04-16 07:28:40'),
('0bfe0ca1-0c02-46a6-a02e-1cee32e5cef2', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0004\",\"note\":\"Please check\"}', '2021-05-28 08:42:48', '2021-05-24 10:01:28', '2021-05-28 08:42:48'),
('0c8d059e-74a1-415d-b715-0b30fb1068bf', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0103\",\"note\":\"Please check\"}', NULL, '2021-05-27 05:06:38', '2021-05-27 05:06:38'),
('0c9ccbaa-d768-42e9-9f40-63e2542c5676', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0148\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:22:34', '2021-05-21 08:22:34'),
('0cc85426-f76f-4f73-950f-266409efa927', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0150\",\"note\":\"Please check\"}', NULL, '2021-05-24 07:27:11', '2021-05-24 07:27:11'),
('0cd0d16b-e935-45f9-acd7-d3c0948e8fc8', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0144\",\"note\":\"Please check\"}', '2021-05-21 09:36:58', '2021-05-21 07:43:37', '2021-05-21 09:36:58'),
('0cda5278-946b-4135-bb41-70651d002056', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0111\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-06 09:53:11', '2021-05-20 06:56:25'),
('0e2f9d51-7651-4063-85d4-5392a7e13af1', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0139\",\"note\":\"Please check\"}', NULL, '2021-04-28 06:53:17', '2021-04-28 06:53:17'),
('0e41449d-23f6-461e-b2f3-eb53f91e9b9e', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0143\",\"note\":\"Please Check\"}', NULL, '2021-05-20 07:01:27', '2021-05-20 07:01:27'),
('0e890138-def4-473e-ace0-4ed54cbee2cb', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0003\",\"note\":\"Please check\"}', NULL, '2021-05-06 02:26:39', '2021-05-06 02:26:39'),
('0e8c141a-ad0e-42c6-84e8-bd1e5f80edc8', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0083\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-03 07:04:01', '2021-05-18 02:29:40'),
('0eb11994-f7ba-4a42-92d6-cdbfaeeb13b6', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0002\",\"note\":\"Please check\"}', NULL, '2021-05-05 09:26:56', '2021-05-05 09:26:56'),
('1081ab2e-62aa-4dd4-a141-339061bde11b', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0114\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-07 03:12:43', '2021-05-20 06:56:25'),
('11a7889c-fef2-42b3-a952-bad5c9048922', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0107\",\"note\":\"Please check\"}', NULL, '2021-04-05 05:33:33', '2021-04-05 05:33:33'),
('122c4b2b-54ef-499d-996d-4661f6a04733', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0039\",\"note\":\"Please check\"}', NULL, '2021-04-01 09:52:53', '2021-04-01 09:52:53'),
('12560511-45e4-4ed2-99e0-977b1182ce79', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0119\",\"note\":\"Please check\"}', NULL, '2021-04-08 03:11:20', '2021-04-08 03:11:20'),
('13353b90-97f3-4a02-bd7c-abbf7d54910f', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0065\",\"note\":\"Please Check\"}', '2021-04-16 09:51:13', '2021-04-16 08:45:55', '2021-04-16 09:51:13'),
('135ddab1-05d9-4039-aedd-dbe52617c56e', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0139\",\"note\":\"Please check\"}', '2021-04-30 06:14:08', '2021-04-28 06:53:17', '2021-04-30 06:14:08'),
('13d7f0ac-e769-4bb7-a73b-afdaacdb80cb', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0073\",\"note\":\"Please check\"}', NULL, '2021-04-25 11:56:25', '2021-04-25 11:56:25'),
('140cac45-d67e-493c-9fc3-2b4bb8c8b95d', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0052\",\"note\":\"Please Check\"}', NULL, '2021-04-06 10:52:32', '2021-04-06 10:52:32'),
('158d72ef-c7bc-4db5-9c3c-47f4477b9a79', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0082\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-03 05:41:48', '2021-05-18 02:29:40'),
('15fb025f-154a-4246-a9b3-8258178a56a6', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0115\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-07 03:21:31', '2021-05-20 06:56:25'),
('15fef1ab-833e-41b7-872f-f1a04deda299', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0132\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-16 10:03:06', '2021-05-20 06:56:25'),
('17727a62-a2f1-45c5-874d-0cb5deb9f6b1', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0073\",\"note\":\"Please check\"}', '2021-04-30 06:14:08', '2021-04-25 11:56:25', '2021-04-30 06:14:08'),
('1817bbfa-b12f-4fa0-a086-13a2960748a8', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"WO has been abandoned by admin\",\"url\":\"womaint\",\"nbr\":\"WO-21-0058\",\"note\":\"Please check\"}', NULL, '2021-04-16 03:48:29', '2021-04-16 03:48:29'),
('184c87e2-7af7-413e-93e4-191d28498495', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0102\",\"note\":\"Please check\"}', '2021-03-31 08:16:50', '2021-03-31 08:10:05', '2021-03-31 08:16:50'),
('187af806-f64e-451d-93a2-7f8fac955fe3', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0073\",\"note\":\"Please check\"}', NULL, '2021-04-25 11:56:25', '2021-04-25 11:56:25'),
('18d6a345-f074-4df0-b25f-ec1fbdc83396', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0139\",\"note\":\"Please check\"}', NULL, '2021-04-28 06:53:17', '2021-04-28 06:53:17'),
('18f00259-0e13-4cea-9952-9b07474f3a19', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0081\",\"note\":\"Please check\"}', NULL, '2021-05-03 03:48:06', '2021-05-03 03:48:06'),
('19016bfa-3c2c-4714-b93e-7a5be78b56f7', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0041\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-01 10:16:36', '2021-05-20 06:56:25'),
('19346b90-a4f6-450c-8ee1-6096d0195f85', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0118\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-07 05:41:34', '2021-05-20 06:56:25'),
('19ee2306-f07d-49f9-b69e-d9d4cf1988b5', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0004\",\"note\":\"Please check\"}', NULL, '2021-05-24 10:01:28', '2021-05-24 10:01:28'),
('1b09a235-f1de-4ac9-a1fa-86bfb0090b4f', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0128\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-16 02:51:03', '2021-05-20 06:56:25'),
('1b69c8da-5fa5-41fa-b4ba-69935767e2b8', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0103\",\"note\":\"Please check\"}', NULL, '2021-03-31 09:15:11', '2021-03-31 09:15:11'),
('1c61596a-a7bd-4985-bb22-10b5e9d887ef', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0097\",\"note\":\"Please Check\"}', NULL, '2021-05-21 08:21:22', '2021-05-21 08:21:22'),
('1c7bcf84-3c61-43a4-becc-6bca343e191d', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0003\",\"note\":\"Please check\"}', NULL, '2021-05-06 02:26:39', '2021-05-06 02:26:39'),
('1cb56aad-7ed0-4995-85d6-cb7b0fa5a0a5', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0153\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:34:46', '2021-05-24 09:34:46'),
('1d2661a9-a56f-4887-b8bc-05fa865e8cce', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0142\",\"note\":\"Please check\"}', NULL, '2021-05-17 03:52:42', '2021-05-17 03:52:42'),
('1f355870-b0ad-49c2-9bea-b1d8f0179419', 'App\\Notifications\\eventNotification', 'App\\User', 60, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0145\",\"note\":\"Please Check\"}', NULL, '2021-05-21 08:06:36', '2021-05-21 08:06:36'),
('1f89bbfd-9c3e-4c52-af76-f25f6a67bd45', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0033\",\"note\":\"Please Check\"}', NULL, '2021-03-31 08:22:20', '2021-03-31 08:22:20'),
('20761b97-5920-43ca-ad3d-2f811c97d282', 'App\\Notifications\\eventNotification', 'App\\User', 56, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0121\",\"note\":\"Please check\"}', NULL, '2021-04-08 07:52:15', '2021-04-08 07:52:15'),
('217c7f67-6cfe-4949-a6eb-580f22b59f80', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0100\",\"note\":\"Please check\"}', NULL, '2021-03-30 09:25:43', '2021-03-30 09:25:43'),
('21f66a98-2325-496e-b7ce-5b53203dafd0', 'App\\Notifications\\eventNotification', 'App\\User', 56, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0122\",\"note\":\"Please check\"}', NULL, '2021-04-09 06:44:40', '2021-04-09 06:44:40'),
('21ffd59a-269e-4d9f-8a65-20ba25593e6c', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0154\",\"note\":\"Please check\"}', NULL, '2021-05-27 06:32:05', '2021-05-27 06:32:05'),
('22db2070-f086-4716-84f6-d2a06c3d560e', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0153\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:34:46', '2021-05-24 09:34:46'),
('2349a75f-3b0d-42d9-abae-b169020090c5', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0048\",\"note\":\"Please check\"}', '2021-04-07 03:25:52', '2021-04-05 08:36:30', '2021-04-07 03:25:52'),
('23514ce3-a4af-4e6b-ae9c-caeec7f555ce', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0051\",\"note\":\"Please check\"}', '2021-04-07 03:25:52', '2021-04-06 02:59:52', '2021-04-07 03:25:52'),
('2358a25d-7950-4ebb-9e9c-ce2c6ec3617c', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0073\",\"note\":\"Please check\"}', NULL, '2021-04-25 11:56:25', '2021-04-25 11:56:25'),
('2359591b-6e1d-4148-97c6-518fd08976a5', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0104\",\"note\":\"Please check\"}', NULL, '2021-05-27 05:11:11', '2021-05-27 05:11:11'),
('247a0095-e9e0-42c7-a0ea-bce5f6896cd9', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0104\",\"note\":\"Please check\"}', '2021-05-28 08:42:48', '2021-05-27 05:11:11', '2021-05-28 08:42:48'),
('249c2048-0e62-4874-825a-e2df48f210a3', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0108\",\"note\":\"Please check\"}', '2021-04-05 08:10:21', '2021-04-05 06:34:09', '2021-04-05 08:10:21'),
('24ab11b1-ad6a-4601-af23-f346ce98e86b', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0140\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:52:14', '2021-05-05 06:52:14'),
('24b69205-3a6a-4c98-b494-9d4ba6882d63', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0082\",\"note\":\"Please check\"}', NULL, '2021-05-03 05:41:48', '2021-05-03 05:41:48'),
('2555b1e7-4657-4f78-8fc2-cc7371f4866d', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0088\",\"note\":\"Please check\"}', NULL, '2021-05-05 08:26:43', '2021-05-05 08:26:43'),
('25bc0c0c-b835-455a-a679-52741c2a58a3', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0074\",\"note\":\"Please check\"}', '2021-04-30 06:14:08', '2021-04-28 07:11:05', '2021-04-30 06:14:08'),
('2626a500-bfee-4dfe-bebb-9714a547e7c5', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0061\",\"note\":\"Please Check\"}', '2021-04-16 07:25:48', '2021-04-15 09:10:23', '2021-04-16 07:25:48'),
('268426b1-cff8-4a89-8378-2575758cc1bd', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0113\",\"note\":\"Please Check\"}', '2021-04-15 04:56:10', '2021-04-07 03:11:24', '2021-04-15 04:56:10'),
('26a35e9a-6422-495c-a2b8-773785f95b04', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0059\",\"note\":\"Please check\"}', NULL, '2021-04-13 08:25:21', '2021-04-13 08:25:21'),
('26b27286-cee9-41df-a7cb-c12f99589483', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0070\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-19 04:33:11', '2021-04-29 03:31:47'),
('27201237-be1f-4fd8-a1f9-ace4c3c3bf55', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0019\",\"note\":\"Please check\"}', NULL, '2021-04-25 12:56:17', '2021-04-25 12:56:17'),
('27f5c552-c4f7-4dde-b408-3d1a88f9d1f3', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0019\",\"note\":\"Please check\"}', '2021-04-30 06:14:08', '2021-04-25 12:56:17', '2021-04-30 06:14:08'),
('286ab150-ac50-43e3-9719-22ed0e5dcd28', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0086\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:56:11', '2021-05-05 06:56:11'),
('28fd405f-91e8-4f4c-8a45-7988904fc158', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0085\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:52:44', '2021-05-05 06:52:44'),
('2927877f-4da7-4d3d-a10e-104c6fb12a94', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0120\",\"note\":\"Please check\"}', NULL, '2021-04-08 03:49:21', '2021-04-08 03:49:21'),
('2962ac6e-94b8-4443-a4b4-78de024f6773', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0103\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-03-31 09:15:11', '2021-05-20 06:56:25'),
('2a51cd62-c67e-4888-b293-c183c4bf77ea', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0141\",\"note\":\"Please check\"}', NULL, '2021-05-17 03:09:17', '2021-05-17 03:09:17'),
('2ad2cafa-efcb-4bdd-a451-a315a7534ffd', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0044\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-01 10:22:20', '2021-05-20 06:56:25'),
('2b659d05-4474-4b64-88a3-5b96c078edb6', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0040\",\"note\":\"Please check\"}', NULL, '2021-04-01 10:02:51', '2021-04-01 10:02:51'),
('2bf226ba-6932-4acf-939e-0362b87371f7', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0110\",\"note\":\"Please check\"}', '2021-04-07 03:25:52', '2021-04-05 09:26:59', '2021-04-07 03:25:52'),
('2cdfe290-7e98-4980-bb5e-e7e47bf3639e', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0006\",\"note\":\"Please check\"}', NULL, '2021-06-02 02:47:43', '2021-06-02 02:47:43'),
('2d5f36f4-0239-43bf-b057-5b3e4989663e', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0142\",\"note\":\"Please check\"}', NULL, '2021-05-17 03:52:42', '2021-05-17 03:52:42'),
('2dde65d2-78df-4268-83c3-18fb7187a75c', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0140\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:52:14', '2021-05-05 06:52:14'),
('2ec3a204-3ee7-4d96-8266-803e364cdf29', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0137\",\"note\":\"Please Check\"}', NULL, '2021-05-17 03:08:07', '2021-05-17 03:08:07'),
('2f5fb87e-319a-4195-a65b-43ffdc971230', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0115\",\"note\":\"Please check\"}', NULL, '2021-04-07 03:21:31', '2021-04-07 03:21:31'),
('2fe41667-bc26-48b8-a91c-3463594b1eb9', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0053\",\"note\":\"Please Check\"}', NULL, '2021-04-07 03:11:20', '2021-04-07 03:11:20'),
('2fe47238-a8b6-43a5-84ad-764a83a9fe5e', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0019\",\"note\":\"Please check\"}', NULL, '2021-04-25 12:56:17', '2021-04-25 12:56:17'),
('3075f7a7-a21f-4abe-8d3a-4a474a1fb44f', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0002\",\"note\":\"Please check\"}', NULL, '2021-05-05 09:26:56', '2021-05-05 09:26:56'),
('30ae9405-7da3-42dd-9587-d3314d5f4b4b', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0081\",\"note\":\"Please check\"}', NULL, '2021-05-03 03:48:06', '2021-05-03 03:48:06'),
('31345616-c238-4899-be82-cc28c4ba422c', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0055\",\"note\":\"Please Check\"}', NULL, '2021-04-07 03:13:06', '2021-04-07 03:13:06'),
('31df7540-6cc0-4d0d-ae20-efe52cb99a44', 'App\\Notifications\\eventNotification', 'App\\User', 60, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0136\",\"note\":\"Please Check\"}', NULL, '2021-04-23 03:40:41', '2021-04-23 03:40:41'),
('320f3540-9b91-4428-bdb5-1fe85c144845', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0141\",\"note\":\"Please Check\"}', '2021-05-20 06:58:23', '2021-05-20 06:51:25', '2021-05-20 06:58:23'),
('325b83f1-8c08-4b64-8dfd-2ebf0cd4c779', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0080\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-30 08:04:28', '2021-05-20 06:56:25'),
('32803734-667f-4b4f-8e1c-44f5aac5901e', 'App\\Notifications\\eventNotification', 'App\\User', 61, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0132\",\"note\":\"Please Check\"}', NULL, '2021-04-16 10:03:46', '2021-04-16 10:03:46'),
('329d30d3-ce6d-4bf6-b8ac-2c59d48d0174', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0120\",\"note\":\"Please check\"}', NULL, '2021-04-08 03:49:21', '2021-04-08 03:49:21'),
('32cefc4d-636b-4961-85b0-fb9a24c47d8f', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0074\",\"note\":\"Please check\"}', NULL, '2021-04-28 07:11:05', '2021-04-28 07:11:05'),
('32e7ef80-3134-4fce-ad20-5dc061bca773', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0076\",\"note\":\"Please check\"}', NULL, '2021-04-30 03:06:32', '2021-04-30 03:06:32'),
('3308fd81-1369-48bc-801a-064167f693d5', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0076\",\"note\":\"Please check\"}', NULL, '2021-04-30 03:06:32', '2021-04-30 03:06:32'),
('33758bf5-5b35-4767-818b-cd24c6dadbe5', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0114\",\"note\":\"Please Check\"}', '2021-04-07 03:25:52', '2021-04-07 03:13:10', '2021-04-07 03:25:52'),
('33ffa545-7217-4496-986e-800db43010c7', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0088\",\"note\":\"Please check\"}', NULL, '2021-05-05 08:26:43', '2021-05-05 08:26:43'),
('346f9d77-d212-4456-bd0d-e6f05115f6a3', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0149\",\"note\":\"Please check\"}', NULL, '2021-05-21 09:09:25', '2021-05-21 09:09:25'),
('34c15b48-f9ca-40f2-ab3c-7143a96a86a2', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0151\",\"note\":\"Please check\"}', NULL, '2021-05-24 08:14:52', '2021-05-24 08:14:52'),
('34ce305a-4088-4216-a1cb-0d75b3599f7f', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0137\",\"note\":\"Please check\"}', NULL, '2021-04-23 08:14:24', '2021-04-23 08:14:24'),
('35b2988f-bf86-4f42-ab9a-f5eac3b9513e', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0087\",\"note\":\"Please Check\"}', NULL, '2021-05-05 08:16:01', '2021-05-05 08:16:01'),
('362cb525-6a07-4a0e-b857-f67d08892386', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0101\",\"note\":\"Please check\"}', '2021-03-31 08:18:51', '2021-03-31 04:31:59', '2021-03-31 08:18:51'),
('36797c75-2da2-4126-9690-78f598f630c7', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0003\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-06 02:26:39', '2021-05-20 06:56:25'),
('368872ed-ed62-4243-82c9-71860cf5dd11', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0001\",\"note\":\"Please check\"}', NULL, '2021-05-05 07:19:50', '2021-05-05 07:19:50'),
('36ff03b7-8d46-46ae-b346-da5f4dd60b9e', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0103\",\"note\":\"Please check\"}', NULL, '2021-05-27 05:06:38', '2021-05-27 05:06:38'),
('3721895e-5e92-45b5-8944-cf3f2a73b53a', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0038\",\"note\":\"Please check\"}', NULL, '2021-04-01 07:51:38', '2021-04-01 07:51:38'),
('38f79f35-1440-471d-8433-e035b1276843', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0083\",\"note\":\"Please check\"}', NULL, '2021-05-03 07:04:01', '2021-05-03 07:04:01'),
('3904873c-3d89-4385-9997-c8a5a738d70d', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0085\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:52:44', '2021-05-05 06:52:44'),
('395071eb-15b6-440b-abb3-68840c058225', 'App\\Notifications\\eventNotification', 'App\\User', 61, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0131\",\"note\":\"Please Check\"}', '2021-04-16 09:52:28', '2021-04-16 09:50:23', '2021-04-16 09:52:28'),
('3b26cdb9-8672-4e78-b178-a456cc7f6639', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0143\",\"note\":\"Please check\"}', NULL, '2021-05-20 07:00:38', '2021-05-20 07:00:38'),
('3b5cffb0-6bf3-45eb-984d-0de6bc8a4082', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0019\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-25 12:56:17', '2021-04-29 03:31:47'),
('3c79e332-77f1-45ba-ba23-e22213811d35', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0123\",\"note\":\"Please check\"}', NULL, '2021-04-09 07:53:00', '2021-04-09 07:53:00'),
('3cd114c2-0035-4819-bb47-4f69ea56c2ad', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0088\",\"note\":\"Please check\"}', NULL, '2021-05-05 08:26:43', '2021-05-05 08:26:43'),
('3d5e22e0-1702-496a-990e-0a89f45344fe', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0104\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-01 04:56:48', '2021-05-20 06:56:25'),
('3e7f408e-04d1-4968-978d-1d9b708a6afd', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0042\",\"note\":\"Please check\"}', NULL, '2021-04-01 10:19:37', '2021-04-01 10:19:37'),
('3f42c7f1-ff3d-4b8a-98ec-8f214e22d338', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0072\",\"note\":\"Please Check\"}', NULL, '2021-04-23 03:40:37', '2021-04-23 03:40:37'),
('3f4b28b5-938b-4431-b797-a7b53fe3c97f', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0152\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:33:00', '2021-05-24 09:33:00'),
('3f61ac0f-bcf8-4184-98fe-ecc62b6d24ce', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0103\",\"note\":\"Please check\"}', NULL, '2021-05-27 05:06:38', '2021-05-27 05:06:38'),
('3fd5c3aa-c82d-4517-a506-8be1f71b3afe', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0081\",\"note\":\"Please check\"}', NULL, '2021-05-03 03:48:06', '2021-05-03 03:48:06'),
('40321b2b-6bbc-4278-814a-d9e52a789fa2', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0144\",\"note\":\"Please check\"}', NULL, '2021-05-21 07:43:37', '2021-05-21 07:43:37'),
('40c5e6c4-bae7-4033-b094-b4e5d2f369a6', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0062\",\"note\":\"Please Check\"}', '2021-04-29 03:31:47', '2021-04-15 09:31:39', '2021-04-29 03:31:47'),
('41615668-2089-41c4-8b97-a7e4411c533b', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0102\",\"note\":\"Please Check\"}', '2021-04-05 05:41:51', '2021-03-31 08:22:24', '2021-04-05 05:41:51'),
('42f627f7-b2fe-4808-96b1-adb3983d8f22', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0097\",\"note\":\"Approval is needed, Please check\"}', '2021-04-01 03:53:28', '2021-03-30 05:37:49', '2021-04-01 03:53:28'),
('4336fe3d-581c-4938-927c-7275f99b424e', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0134\",\"note\":\"Please Check\"}', '2021-04-19 04:00:21', '2021-04-19 03:56:35', '2021-04-19 04:00:21'),
('433de437-19da-4a4b-90b3-c7254fdd7782', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0002\",\"note\":\"Please check\"}', NULL, '2021-05-05 09:26:56', '2021-05-05 09:26:56'),
('437d12fa-3994-4497-8033-eb881913b6f1', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0089\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-11 03:41:57', '2021-05-20 06:56:25'),
('440ded1f-e464-4d68-9376-91efc55a0ef8', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0051\",\"note\":\"Please Check\"}', '2021-04-07 03:25:52', '2021-04-06 10:49:35', '2021-04-07 03:25:52'),
('440fbe60-6930-46b8-82f2-774291e3591e', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0126\",\"note\":\"Please check\"}', '2021-04-16 03:46:34', '2021-04-15 07:35:35', '2021-04-16 03:46:34'),
('445a209b-3bae-471a-8f9d-4a61d3568b42', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0102\",\"note\":\"Please check\"}', NULL, '2021-03-31 08:10:05', '2021-03-31 08:10:05'),
('446d36d2-030d-499e-9a4d-7b4186154ff7', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0152\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:33:00', '2021-05-24 09:33:00'),
('44a757dd-e17a-4aba-a6b4-be201410aaeb', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0040\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-01 10:02:51', '2021-04-05 05:41:51'),
('44b28c13-5a1a-423f-98ef-97b71587c7d1', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"WO has been abandoned by admin\",\"url\":\"womaint\",\"nbr\":\"WO-21-0058\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-16 03:44:31', '2021-04-29 03:31:47'),
('45073f66-2533-4ad8-bbbc-e02ef077ae55', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0093\",\"note\":\"Please Check\"}', NULL, '2021-05-20 07:01:22', '2021-05-20 07:01:22'),
('45116c1e-f343-4bfa-95c1-abd59f1663cd', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0137\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-23 08:14:24', '2021-04-29 03:31:47'),
('458d09a5-3eed-47ad-91c3-9ebe9379e08b', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0141\",\"note\":\"Please check\"}', NULL, '2021-05-17 03:09:17', '2021-05-17 03:09:17'),
('45a990b7-e0e4-47b5-a763-031e98615e72', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0120\",\"note\":\"Please check\"}', NULL, '2021-04-08 03:49:21', '2021-04-08 03:49:21'),
('460f0f83-408a-43c5-bc9f-8f4781a0ed54', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0149\",\"note\":\"Please check\"}', NULL, '2021-05-21 09:09:25', '2021-05-21 09:09:25'),
('46ced25a-bd7f-4a56-bbb0-ba40d73fa822', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0082\",\"note\":\"Please check\"}', NULL, '2021-05-03 05:41:48', '2021-05-03 05:41:48'),
('479fae6f-eaf7-470f-9f63-6b97001444db', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0136\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-23 03:39:29', '2021-04-29 03:31:47'),
('47a7509a-b9f6-4fb9-b148-173f970747b2', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0122\",\"note\":\"Please check\"}', NULL, '2021-04-09 06:44:40', '2021-04-09 06:44:40'),
('480fe2ff-b109-4dce-91b2-614a0c9a6836', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0020\",\"note\":\"Please check\"}', NULL, '2021-05-27 08:14:01', '2021-05-27 08:14:01'),
('48163843-c934-46d9-a4e8-721ee90b50ba', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0003\",\"note\":\"Please check\"}', NULL, '2021-05-06 02:26:39', '2021-05-06 02:26:39'),
('486f8ffb-cf1e-4691-a48e-995f904450e9', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0063\",\"note\":\"Please Check\"}', '2021-04-16 07:28:40', '2021-04-16 03:42:21', '2021-04-16 07:28:40'),
('487fe455-310f-4224-9cb7-fdb6e8d9694c', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0121\",\"note\":\"Please check\"}', NULL, '2021-04-08 07:52:15', '2021-04-08 07:52:15'),
('48b61bbf-32cc-4e1f-a2db-a07fada4e2c3', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0150\",\"note\":\"Please check\"}', NULL, '2021-05-24 07:27:11', '2021-05-24 07:27:11'),
('4934c8dd-6da1-41ee-98ef-c7192d9860a1', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0107\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-05 05:33:33', '2021-05-20 06:56:25'),
('495ef9c7-3bf1-439b-a263-a40653fcb6cb', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0004\",\"note\":\"Please check\"}', NULL, '2021-05-24 10:01:28', '2021-05-24 10:01:28'),
('4a17d993-3445-4002-99f2-21d765ca1ccb', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0142\",\"note\":\"Please Check\"}', '2021-05-20 06:56:25', '2021-05-17 03:54:54', '2021-05-20 06:56:25'),
('4a59501b-4773-4055-a64b-59d666c9c84d', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0128\",\"note\":\"Please check\"}', '2021-04-16 03:46:34', '2021-04-16 02:51:03', '2021-04-16 03:46:34'),
('4ad2d8e0-23f5-4f52-99ac-7a0b15283daf', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0136\",\"note\":\"Please check\"}', NULL, '2021-04-23 03:39:29', '2021-04-23 03:39:29'),
('4ae3d8dd-6b74-4307-a80f-3fe17a6c8fa2', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0082\",\"note\":\"Please check\"}', NULL, '2021-05-03 05:41:48', '2021-05-03 05:41:48'),
('4aeb054f-c816-42f4-b2da-e43da2e1a596', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0035\",\"note\":\"Please check\"}', NULL, '2021-03-31 08:29:21', '2021-03-31 08:29:21'),
('4b3b341a-f6ef-4b70-a2c3-3a173861cb7a', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0063\",\"note\":\"Please Check\"}', '2021-04-16 03:46:34', '2021-04-16 03:42:21', '2021-04-16 03:46:34'),
('4ba326b2-ef65-4c76-abd6-5ec5ed98b24e', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0104\",\"note\":\"Please check\"}', NULL, '2021-05-27 05:11:11', '2021-05-27 05:11:11'),
('4baa1516-90a3-4eb2-beaa-b35e96d8ae8a', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0055\",\"note\":\"Please check\"}', NULL, '2021-04-07 03:12:03', '2021-04-07 03:12:03'),
('4bb95370-6c51-4a44-8aa0-b33665a0177f', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0003\",\"note\":\"Please check\"}', NULL, '2021-05-06 02:26:39', '2021-05-06 02:26:39'),
('4bc14b9b-47f7-4677-bfaf-541c12d0fc60', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0145\",\"note\":\"Please check\"}', '2021-05-21 09:36:58', '2021-05-21 08:05:34', '2021-05-21 09:36:58'),
('4bc45f37-657a-4b83-a30c-7cc2320dcf54', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0109\",\"note\":\"Please Check\"}', '2021-04-07 02:26:24', '2021-04-05 07:51:01', '2021-04-07 02:26:24');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('4cee8790-8222-47c6-bc64-210ce845710a', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0154\",\"note\":\"Please check\"}', NULL, '2021-05-27 06:32:05', '2021-05-27 06:32:05'),
('4dd38104-a4af-41c1-a79e-a3423a628275', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0076\",\"note\":\"Please check\"}', '2021-04-30 06:14:08', '2021-04-30 03:06:32', '2021-04-30 06:14:08'),
('4e592daa-a754-4b1a-9d0f-ec55525a44c2', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0005\",\"note\":\"Please check\"}', NULL, '2021-05-27 02:48:00', '2021-05-27 02:48:00'),
('4e598eb9-20db-4849-a6d6-23769fb75212', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0150\",\"note\":\"Please check\"}', '2021-05-28 08:42:48', '2021-05-24 07:27:11', '2021-05-28 08:42:48'),
('4e9bd9ce-4c38-4182-a50f-54923f1d4043', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0131\",\"note\":\"Please check\"}', '2021-04-16 10:03:19', '2021-04-16 09:48:53', '2021-04-16 10:03:19'),
('4ed7b4a6-d49e-4ae3-a586-d332e99228f0', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0098\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-03-30 08:55:14', '2021-04-05 05:41:51'),
('4f2d3add-a9b2-4f03-ae96-90364319d1e5', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0149\",\"note\":\"Please check\"}', NULL, '2021-05-21 09:09:25', '2021-05-21 09:09:25'),
('4f62d2e4-3d19-4213-b3d0-001c319427e3', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0139\",\"note\":\"Please Check\"}', '2021-04-29 03:31:47', '2021-04-28 07:14:15', '2021-04-29 03:31:47'),
('4f830627-6c4c-4ba8-9859-faab10f16bf3', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0069\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-19 04:05:49', '2021-05-20 06:56:25'),
('4fbad793-4044-484e-8927-816bd098c51d', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0128\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-16 02:51:03', '2021-04-29 03:31:47'),
('4fbd26dd-8162-4cae-ae65-523e12fe2cb4', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0147\",\"note\":\"Please Check\"}', '2021-05-21 09:36:58', '2021-05-21 08:21:27', '2021-05-21 09:36:58'),
('501accfb-d027-46c8-84ab-a390d3a3e016', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0006\",\"note\":\"Please check\"}', NULL, '2021-06-02 02:47:43', '2021-06-02 02:47:43'),
('50b2381d-5582-4368-a4a6-58c825d8f1db', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"WO has been abandoned by admin\",\"url\":\"womaint\",\"nbr\":\"WO-21-0058\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-16 03:48:29', '2021-04-29 03:31:47'),
('50e59c84-b015-467d-b1e4-ed1d363cd488', 'App\\Notifications\\eventNotification', 'App\\User', 60, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0153\",\"note\":\"Please Check\"}', NULL, '2021-05-24 09:37:00', '2021-05-24 09:37:00'),
('512e1d78-b74e-41e8-853b-20b472ebdacb', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0019\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-25 12:56:17', '2021-05-20 06:56:25'),
('5137d9af-b774-4d20-971f-9a56c0fc7065', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0006\",\"note\":\"Please check\"}', NULL, '2021-06-02 02:47:43', '2021-06-02 02:47:43'),
('51a32c5f-8525-4f34-812d-89dcb5b673ef', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0076\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-30 03:06:32', '2021-05-20 06:56:25'),
('51e86017-6f36-46d9-8469-b11f0b973e89', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0108\",\"note\":\"Please check\"}', NULL, '2021-04-05 06:34:09', '2021-04-05 06:34:09'),
('5265bc2d-e143-46ea-af97-495664532396', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0145\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:05:34', '2021-05-21 08:05:34'),
('527f4f97-c7e4-462e-b101-df92ffd9ed2c', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"WO has been abandoned byadmin\",\"url\":\"womaint\",\"nbr\":\"WO-21-0058\",\"note\":\"Please check\"}', '2021-04-16 03:46:34', '2021-04-16 03:43:53', '2021-04-16 03:46:34'),
('52bd834b-d7fe-4bf8-b1a3-8a9ad4e53d14', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0133\",\"note\":\"Please check\"}', NULL, '2021-04-19 02:51:43', '2021-04-19 02:51:43'),
('52c10ef6-a0b0-41c8-ac80-fa625a584c61', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0127\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-16 02:38:05', '2021-05-20 06:56:25'),
('54f85fe3-2ff9-40e2-bcd7-e44dff3872db', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0020\",\"note\":\"Please check\"}', NULL, '2021-05-27 08:14:01', '2021-05-27 08:14:01'),
('553125d0-0477-41d7-a5d1-c079d42b6533', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0109\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-05 07:48:24', '2021-05-20 06:56:25'),
('564c7d2b-682d-4ac7-a0a2-e36d7d757209', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0086\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-05 06:56:11', '2021-05-18 02:29:40'),
('56a8fa18-f719-4523-a9c5-64a291f40a58', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0069\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-19 04:05:49', '2021-04-29 03:31:47'),
('56c3a4b6-2827-4891-932d-e28377599835', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0051\",\"note\":\"Please check\"}', NULL, '2021-04-06 02:59:52', '2021-04-06 02:59:52'),
('57a3608c-f59f-46e6-a419-fc287d4636f3', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0119\",\"note\":\"Please check\"}', NULL, '2021-04-08 03:11:20', '2021-04-08 03:11:20'),
('57bca621-591d-4a10-8c29-840940c634ce', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0140\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-05 06:52:14', '2021-05-20 06:56:25'),
('58e9d7ef-5df8-48fd-aec6-45ad4ddce335', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0148\",\"note\":\"Please Check\"}', '2021-05-21 09:36:58', '2021-05-21 08:37:16', '2021-05-21 09:36:58'),
('59c4868b-853d-4d48-a871-fb2030652e7c', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0105\",\"note\":\"Please check\"}', NULL, '2021-04-01 04:57:48', '2021-04-01 04:57:48'),
('59c97237-28b9-4b9e-bc42-2e3506f49df8', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0142\",\"note\":\"Please check\"}', NULL, '2021-05-17 03:52:42', '2021-05-17 03:52:42'),
('5a59a0ec-0f6a-462f-b1b0-21387aff08bc', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0101\",\"note\":\"Please Check\"}', '2021-05-24 08:17:24', '2021-05-24 08:16:52', '2021-05-24 08:17:24'),
('5abbc47d-8e97-4a5a-bab1-7974a8e63a76', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0089\",\"note\":\"Please check\"}', NULL, '2021-05-11 03:41:57', '2021-05-11 03:41:57'),
('5b3d9e75-5d42-4fa2-a8e4-18d32ff005e0', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0154\",\"note\":\"Please check\"}', NULL, '2021-05-27 06:32:05', '2021-05-27 06:32:05'),
('5b7b60f5-9231-44e0-be35-47ea9f8fa543', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"WO has been abandoned by eng02\",\"url\":\"womaint\",\"nbr\":\"WO-21-0102\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:40:20', '2021-05-24 09:40:20'),
('5b98b050-ec52-46d3-9664-290761e488ed', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0104\",\"note\":\"Please check\"}', NULL, '2021-05-27 05:11:11', '2021-05-27 05:11:11'),
('5be46fb7-9a1d-4aa5-b53b-98980f25f502', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0045\",\"note\":\"Please check\"}', NULL, '2021-04-01 10:59:57', '2021-04-01 10:59:57'),
('5c001896-ce3f-441c-b42c-f357efb520fe', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0055\",\"note\":\"Please Check\"}', '2021-04-07 03:25:52', '2021-04-07 03:13:06', '2021-04-07 03:25:52'),
('5c7de749-3082-4b1e-a9c6-b5583ce69f8a', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0135\",\"note\":\"Please check\"}', '2021-04-19 07:54:58', '2021-04-19 06:51:13', '2021-04-19 07:54:58'),
('5ceb0906-eaf5-4871-aa24-f05fbe5125c4', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0146\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:09:50', '2021-05-21 08:09:50'),
('5d1d8e58-e1fb-43df-b512-ff3ca23833fd', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0061\",\"note\":\"Please Check\"}', '2021-04-29 03:31:47', '2021-04-15 09:10:23', '2021-04-29 03:31:47'),
('5d51369f-0b04-4e18-ad98-ad421e5f9c70', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0087\",\"note\":\"Please Check\"}', NULL, '2021-05-05 08:16:01', '2021-05-05 08:16:01'),
('5da9c9a4-448e-4016-bb82-ecc1f61ab1a6', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0127\",\"note\":\"Please Check\"}', '2021-05-18 02:29:40', '2021-04-30 08:03:46', '2021-05-18 02:29:40'),
('5df26045-6d0a-4c05-bb85-bca1c3ee093b', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0038\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-01 07:51:38', '2021-04-05 05:41:51'),
('5e655291-98c4-4686-a3da-9a5aebe122f8', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0129\",\"note\":\"Please check\"}', NULL, '2021-04-16 07:28:21', '2021-04-16 07:28:21'),
('5ea17193-c782-43ae-8b79-b979ade17ec8', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0144\",\"note\":\"Please check\"}', NULL, '2021-05-21 07:43:37', '2021-05-21 07:43:37'),
('60b466cc-35d6-406b-bb52-f566f7ae4309', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0112\",\"note\":\"Please check\"}', '2021-04-07 03:25:52', '2021-04-06 10:52:08', '2021-04-07 03:25:52'),
('60e50c2e-dfcb-4770-accc-0c3685c0dec2', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0019\",\"note\":\"Please check\"}', NULL, '2021-04-25 12:56:17', '2021-04-25 12:56:17'),
('6162a2bc-335e-484a-80a8-878411b683fe', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0037\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-01 07:49:14', '2021-05-20 06:56:25'),
('61ba70f8-9aee-4992-8309-143f18fca278', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0151\",\"note\":\"Please check\"}', NULL, '2021-05-24 08:14:52', '2021-05-24 08:14:52'),
('620aab24-1caf-4916-8464-aa641be1e142', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0102\",\"note\":\"Please Check\"}', NULL, '2021-05-24 09:36:56', '2021-05-24 09:36:56'),
('6277e2da-c117-4202-881f-19af8c996edb', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0020\",\"note\":\"Please check\"}', '2021-05-28 08:42:48', '2021-05-27 08:14:01', '2021-05-28 08:42:48'),
('62a2a72f-3768-4d18-9c5e-1389492776e1', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0112\",\"note\":\"Please check\"}', NULL, '2021-04-06 10:52:08', '2021-04-06 10:52:08'),
('62cc9d25-c5cb-4c89-94a8-356cc0180a51', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0073\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-25 11:56:25', '2021-04-29 03:31:47'),
('630fb172-0f2a-43f5-9975-824ddf4a777e', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0128\",\"note\":\"Please check\"}', '2021-04-16 07:28:40', '2021-04-16 02:51:03', '2021-04-16 07:28:40'),
('637cad13-1f7c-439a-a819-04634f5fa114', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0001\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-05 07:19:50', '2021-05-20 06:56:25'),
('63aedfe3-aad0-4204-9f79-09011be45fef', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0080\",\"note\":\"Please check\"}', NULL, '2021-04-30 08:04:28', '2021-04-30 08:04:28'),
('64416422-c0b8-4d94-9096-701e154bc362', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"WO has been abandoned by eng02\",\"url\":\"womaint\",\"nbr\":\"WO-21-0102\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:40:20', '2021-05-24 09:40:20'),
('64702f53-4fba-400c-adf3-ae4dae50bf7a', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0084\",\"note\":\"Please check\"}', NULL, '2021-05-04 04:58:52', '2021-05-04 04:58:52'),
('648cd434-7e48-4e13-80c5-338f557fb7fc', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0080\",\"note\":\"Please check\"}', NULL, '2021-04-30 08:04:28', '2021-04-30 08:04:28'),
('6491a3d8-dadc-40db-a8c8-c851960cb834', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0098\",\"note\":\"Please Check\"}', NULL, '2021-05-21 08:37:11', '2021-05-21 08:37:11'),
('6509a1cf-d547-417c-b1a5-38e8383548f9', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0112\",\"note\":\"Please Check\"}', '2021-04-07 03:25:52', '2021-04-06 10:52:36', '2021-04-07 03:25:52'),
('653a80e2-2643-49f5-b332-3def3983e7e1', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0146\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:09:50', '2021-05-21 08:09:50'),
('654bc635-8578-462e-8a7e-957770277acc', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0121\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-08 07:52:15', '2021-05-20 06:56:25'),
('66508728-5b24-4efa-96d8-39bab7b0e3d3', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0117\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-07 03:22:23', '2021-05-20 06:56:25'),
('6663623a-62db-42a1-988b-0c8ba84a6db3', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0111\",\"note\":\"Please check\"}', NULL, '2021-04-06 09:53:11', '2021-04-06 09:53:11'),
('66d44a63-4494-4a3f-ac44-c1c689e1f975', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0146\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:09:50', '2021-05-21 08:09:50'),
('671263a1-8330-4eda-a6ed-e16123fd06dc', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0089\",\"note\":\"Please check\"}', NULL, '2021-05-11 03:41:57', '2021-05-11 03:41:57'),
('67606de7-898b-48ac-ba9f-b0c6f1077e37', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0001\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-05 07:19:50', '2021-05-18 02:29:40'),
('677741fd-afca-42d3-9409-64c3a4295e70', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0105\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-01 04:57:48', '2021-04-05 05:41:51'),
('67a3e20c-eeb2-47d8-935e-636fadd5ef29', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0110\",\"note\":\"Please Check\"}', '2021-05-20 06:56:25', '2021-04-05 09:28:22', '2021-05-20 06:56:25'),
('67bf2d11-b32b-48d1-9f77-f05141dd14eb', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0084\",\"note\":\"Please check\"}', NULL, '2021-05-04 04:58:52', '2021-05-04 04:58:52'),
('682dd452-6fce-4bab-b0df-2b185e22ebd3', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0137\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-23 08:14:24', '2021-05-20 06:56:25'),
('6864f605-5853-434b-b5ed-99673b815703', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0151\",\"note\":\"Please check\"}', '2021-05-24 08:16:19', '2021-05-24 08:14:52', '2021-05-24 08:16:19'),
('68c18ccb-dabc-48ed-b8fb-e3c8dd7519cc', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0146\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:09:50', '2021-05-21 08:09:50'),
('68c82502-e13f-4849-a563-5507e4b044d6', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"Service Request Rejected\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0106\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-05 03:15:02', '2021-04-05 05:41:51'),
('6a5cbc72-0914-4257-adfc-200c30196d71', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0045\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-01 10:59:57', '2021-05-20 06:56:25'),
('6a83c738-5246-4d89-a012-81182386e886', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0061\",\"note\":\"Please Check\"}', '2021-04-16 07:28:40', '2021-04-15 09:10:23', '2021-04-16 07:28:40'),
('6acf9211-c2ae-42cc-8abe-e1f531a875a2', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0103\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-03-31 09:15:11', '2021-04-05 05:41:51'),
('6ae4be6e-d8e0-43cd-8413-bbca61d7ac4c', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0114\",\"note\":\"Please check\"}', '2021-04-07 03:25:52', '2021-04-07 03:12:43', '2021-04-07 03:25:52'),
('6b1cbf48-ab69-4c0c-a947-58d06ae9960f', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0035\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-03-31 08:29:21', '2021-05-20 06:56:25'),
('6b7ef121-a44e-4203-8a6b-c71806658926', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0057\",\"note\":\"Please Check\"}', NULL, '2021-04-07 03:22:49', '2021-04-07 03:22:49'),
('6c6e18b8-5984-4d6a-9484-1d4b1fcf3f74', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0018\",\"note\":\"Please check\"}', NULL, '2021-04-23 03:31:49', '2021-04-23 03:31:49'),
('6d5aeef9-6225-43bb-949d-001ccb8fab77', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0086\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:56:11', '2021-05-05 06:56:11'),
('6dfbe7d8-a397-4017-8462-f298fb98965e', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"WO has been abandoned by eng02\",\"url\":\"womaint\",\"nbr\":\"WO-21-0102\",\"note\":\"Please check\"}', '2021-05-28 08:42:48', '2021-05-24 09:40:20', '2021-05-28 08:42:48'),
('6e2f6d7d-d6f3-4ede-a27f-e76c0b3a26c4', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0100\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-03-30 09:25:43', '2021-05-20 06:56:25'),
('6e53f094-c414-46a8-b563-3d88c35df82b', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0129\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-16 07:28:21', '2021-04-29 03:31:47'),
('6ee94ad4-7f40-465b-bce4-246a749bf8d7', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0089\",\"note\":\"Please check\"}', NULL, '2021-05-11 03:41:57', '2021-05-11 03:41:57'),
('6efb3fe1-44df-4a9d-8115-6b656615262b', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0027\",\"note\":\"Please Check\"}', '2021-04-05 05:41:51', '2021-03-30 06:12:49', '2021-04-05 05:41:51'),
('6f6fc4fa-5a77-40ab-8562-a82d1f2c3407', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0091\",\"note\":\"Please Check\"}', '2021-05-20 06:56:25', '2021-05-17 03:54:50', '2021-05-20 06:56:25'),
('6fc38322-8327-41b3-8c4c-16d409fb0281', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0134\",\"note\":\"Please check\"}', NULL, '2021-04-19 02:54:26', '2021-04-19 02:54:26'),
('6fdd7cf0-1987-45e7-beca-964df9e3fe56', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0113\",\"note\":\"Please check\"}', '2021-04-07 03:25:52', '2021-04-07 03:10:35', '2021-04-07 03:25:52'),
('70a503ba-f004-4879-9f65-f56db3c618d8', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0053\",\"note\":\"Please Check\"}', '2021-05-20 06:56:25', '2021-04-07 03:11:20', '2021-05-20 06:56:25'),
('70c713e4-343a-4c46-8843-00f095d832c8', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0082\",\"note\":\"Please check\"}', NULL, '2021-05-03 05:41:48', '2021-05-03 05:41:48'),
('716dbe6f-03fc-424f-af41-efd5939e3b3a', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0006\",\"note\":\"Please check\"}', NULL, '2021-06-02 02:47:43', '2021-06-02 02:47:43'),
('71c9f8da-5832-4164-838d-9da50b29b593', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0138\",\"note\":\"Please check\"}', NULL, '2021-04-25 13:23:16', '2021-04-25 13:23:16'),
('7258d9e5-15d9-4a4f-8abf-143d03fa8f8b', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0153\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:34:46', '2021-05-24 09:34:46'),
('72728c7b-33e7-4779-8ab8-4dca007b4b95', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0103\",\"note\":\"Please check\"}', NULL, '2021-05-27 05:06:38', '2021-05-27 05:06:38'),
('7276e818-cadb-4ff9-8f98-666fd93b7ff8', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0103\",\"note\":\"Please check\"}', NULL, '2021-05-27 05:06:38', '2021-05-27 05:06:38'),
('728dca6f-50ba-4d66-bcf7-fd735ade0136', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0145\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:05:34', '2021-05-21 08:05:34'),
('729262fd-aad4-44bf-8547-01191f6cda87', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0063\",\"note\":\"Please Check\"}', '2021-04-29 03:31:47', '2021-04-16 03:42:21', '2021-04-29 03:31:47'),
('7294f7ca-e97b-4f79-a14c-2fd885a989f3', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0145\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:05:34', '2021-05-21 08:05:34'),
('72c28533-8b7d-442f-8f7e-ce6ee450423d', 'App\\Notifications\\eventNotification', 'App\\User', 61, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0129\",\"note\":\"Please Check\"}', '2021-04-16 09:52:28', '2021-04-16 07:46:11', '2021-04-16 09:52:28'),
('7373a90d-69df-4db9-b749-e2b137b572ca', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0047\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-05 08:07:47', '2021-05-20 06:56:25'),
('73a856d0-c231-4e65-9b29-402c2c830adc', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0130\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-16 08:45:29', '2021-04-29 03:31:47'),
('73d57f8a-b351-412c-b158-ee249ffac0cc', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0121\",\"note\":\"Please check\"}', NULL, '2021-04-08 07:52:15', '2021-04-08 07:52:15'),
('73e72105-2d7d-476f-806e-1b264aeba83c', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0138\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-25 13:23:16', '2021-04-29 03:31:47'),
('73fa0536-6ea4-425f-93d0-12e9459ec6ab', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0130\",\"note\":\"Please check\"}', '2021-04-16 10:03:19', '2021-04-16 08:45:29', '2021-04-16 10:03:19'),
('746e0472-8f9e-4557-a177-0d7cbe6a8fd5', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"WO has been abandoned byadmin\",\"url\":\"womaint\",\"nbr\":\"WO-21-0058\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-16 03:43:53', '2021-04-29 03:31:47'),
('74761b16-eec0-4bc0-9f08-5c67e30e9552', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0086\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-05 06:56:11', '2021-05-20 06:56:25'),
('78920218-078d-4fd8-a562-2ea2a173ea5a', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0042\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-01 10:19:37', '2021-05-20 06:56:25'),
('795b7321-6b43-4b3e-aad0-2b5ac4463372', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0036\",\"note\":\"Please check\"}', NULL, '2021-03-31 11:00:16', '2021-03-31 11:00:16'),
('799b7272-ae70-4372-8269-17b39ffa2509', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0101\",\"note\":\"Please check\"}', NULL, '2021-03-31 04:31:59', '2021-03-31 04:31:59'),
('79a216e0-b6a0-4161-9c55-41269911df7a', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0097\",\"note\":\"Approval is needed, Please check\"}', '2021-04-05 05:41:51', '2021-03-30 05:37:49', '2021-04-05 05:41:51'),
('79ab8cae-cf0a-4506-88e9-b5e1688546c1', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"WO has been abandoned by admin\",\"url\":\"womaint\",\"nbr\":\"WO-21-0058\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-16 03:44:31', '2021-05-20 06:56:25'),
('79bd415d-059c-4327-bf47-bc4dbf110435', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0062\",\"note\":\"Please Check\"}', '2021-04-16 07:26:15', '2021-04-15 09:31:39', '2021-04-16 07:26:15'),
('7a7edd3b-31de-4172-8f6f-9ac49bf01431', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0148\",\"note\":\"Please check\"}', '2021-05-21 09:36:58', '2021-05-21 08:22:34', '2021-05-21 09:36:58'),
('7aa41c81-c6ae-4291-8a35-375b246618f6', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0074\",\"note\":\"Please check\"}', NULL, '2021-04-28 07:11:05', '2021-04-28 07:11:05'),
('7af35672-a081-419a-908d-2a4dadac1754', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0084\",\"note\":\"Please check\"}', NULL, '2021-05-04 04:58:52', '2021-05-04 04:58:52'),
('7b22a6a9-3754-4a46-925d-efcf9ff04a4b', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0104\",\"note\":\"Please check\"}', NULL, '2021-05-27 05:11:11', '2021-05-27 05:11:11'),
('7b7d5a4d-b12a-4027-a08a-510b77235781', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0154\",\"note\":\"Please check\"}', NULL, '2021-05-27 06:32:05', '2021-05-27 06:32:05'),
('7bce8597-3a59-416a-bb79-fc7040dd6be2', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0018\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-23 03:31:49', '2021-04-29 03:31:47'),
('7c947885-224e-4d15-b930-9f2d3341501c', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"WO has been abandoned by admin\",\"url\":\"womaint\",\"nbr\":\"WO-21-0058\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-16 03:48:29', '2021-05-20 06:56:25'),
('7c9e4264-750d-4308-9d8b-f1db287d6a67', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0090\",\"note\":\"Please Check\"}', '2021-04-05 05:41:51', '2021-03-30 06:12:53', '2021-04-05 05:41:51'),
('7ce499b3-419b-43f8-afc9-6bf271e91da7', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0102\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-03-31 08:10:05', '2021-05-20 06:56:25'),
('7ce5f81b-3a42-4c9e-b90e-a875e0a6cd94', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0151\",\"note\":\"Please check\"}', NULL, '2021-05-24 08:14:52', '2021-05-24 08:14:52'),
('7cebe230-1539-44bd-a57d-042025e1dd15', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0130\",\"note\":\"Please check\"}', NULL, '2021-04-16 08:45:29', '2021-04-16 08:45:29'),
('7d3d2d17-1fa1-4e5e-87a4-f29c4acc3099', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0100\",\"note\":\"Please check\"}', NULL, '2021-03-30 09:25:43', '2021-03-30 09:25:43'),
('7d6f0752-95bf-41c5-8020-2a1b60f37e8e', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0143\",\"note\":\"Please check\"}', '2021-05-21 09:36:58', '2021-05-20 07:00:38', '2021-05-21 09:36:58'),
('7d86e8ba-3e08-4e55-bd77-4300c76c56a8', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0150\",\"note\":\"Please check\"}', NULL, '2021-05-24 07:27:11', '2021-05-24 07:27:11'),
('7da1e34b-d574-402e-8285-81e66501ff9a', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0106\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-05 03:13:37', '2021-04-05 05:41:51'),
('7e14b2a0-6861-45de-b6aa-369474d78f5a', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0152\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:33:00', '2021-05-24 09:33:00'),
('7e920837-9b4c-44c7-86df-b966ccf23978', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0104\",\"note\":\"Please check\"}', NULL, '2021-04-01 04:56:48', '2021-04-01 04:56:48'),
('7f654e96-4b67-4877-8f70-92bc3fdf89ec', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0148\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:22:34', '2021-05-21 08:22:34'),
('8018e2f6-189e-488a-8062-7531ddc2702e', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0018\",\"note\":\"Please check\"}', '2021-04-30 06:14:08', '2021-04-23 03:31:49', '2021-04-30 06:14:08'),
('80d164a6-575b-4ee2-be71-4bdf059469c4', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0074\",\"note\":\"Please check\"}', NULL, '2021-04-28 07:11:05', '2021-04-28 07:11:05'),
('8128849e-2250-4dc7-b1a0-97bda400a229', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0078\",\"note\":\"Please Check\"}', NULL, '2021-04-30 08:02:49', '2021-04-30 08:02:49'),
('81cfcc42-4911-4bb2-8b95-b0f41a11842f', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Rejected\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0107\",\"note\":\"Please check\"}', '2021-04-05 06:06:56', '2021-04-05 05:41:12', '2021-04-05 06:06:56'),
('82ba06c9-3aba-4b42-aedd-89c5c24d7715', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0141\",\"note\":\"Please check\"}', NULL, '2021-05-17 03:09:17', '2021-05-17 03:09:17'),
('82d6554d-fd24-4729-98cd-6ab728381130', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0066\",\"note\":\"Please Check\"}', '2021-04-16 09:51:16', '2021-04-16 09:50:19', '2021-04-16 09:51:16'),
('83023d58-a19b-4fa4-a7cb-173206d5d37f', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0074\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-28 07:11:05', '2021-05-20 06:56:25'),
('83324e39-0505-4cbb-a7e7-e769d11928cd', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0150\",\"note\":\"Please check\"}', NULL, '2021-05-24 07:27:11', '2021-05-24 07:27:11'),
('8343a065-49ba-4e96-8f03-19a561b11736', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0136\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-23 03:39:29', '2021-05-20 06:56:25'),
('8351f2a1-1935-499c-a228-ec627cb814cd', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0057\",\"note\":\"Please Check\"}', '2021-04-07 03:25:52', '2021-04-07 03:22:49', '2021-04-07 03:25:52'),
('8366021e-319e-4247-b380-6f2ce7b00207', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0040\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-01 10:02:51', '2021-05-20 06:56:25'),
('836fe2e0-e570-462f-8ded-fc7275c00789', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0138\",\"note\":\"Please check\"}', NULL, '2021-04-25 13:23:16', '2021-04-25 13:23:16'),
('846e8733-cf3e-4f09-9122-5f75931e740e', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0110\",\"note\":\"Please check\"}', NULL, '2021-04-05 09:26:59', '2021-04-05 09:26:59'),
('84c35f27-46d3-4db8-a805-a7f9bd8a817f', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0082\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-03 05:41:48', '2021-05-20 06:56:25'),
('84d0263b-8268-43cf-9fda-c3cb3b498058', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0003\",\"note\":\"Please check\"}', NULL, '2021-05-06 02:26:39', '2021-05-06 02:26:39'),
('854607ea-0338-4fcb-bcb8-81fbd135b908', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0093\",\"note\":\"Please Check\"}', NULL, '2021-05-20 07:01:22', '2021-05-20 07:01:22'),
('85602404-7810-45ed-a5cb-0a03873093dd', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0099\",\"note\":\"Please check\"}', NULL, '2021-03-30 09:25:17', '2021-03-30 09:25:17'),
('8588102c-618d-4c3f-af5b-08c342898bb5', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"WO has been abandoned by eng02\",\"url\":\"womaint\",\"nbr\":\"WO-21-0102\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:40:20', '2021-05-24 09:40:20'),
('869a943c-47cd-420a-b64a-78b569c2be5f', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0016\",\"note\":\"Approval is needed, Please check\"}', '2021-03-30 03:58:47', '2021-03-30 03:33:33', '2021-03-30 03:58:47'),
('87986aaa-0d95-4020-adc6-e4813f9c7064', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0020\",\"note\":\"Please check\"}', NULL, '2021-05-27 08:14:01', '2021-05-27 08:14:01'),
('879f56a6-ab03-465c-8bd7-bcbba97edafb', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0143\",\"note\":\"Please check\"}', NULL, '2021-05-20 07:00:38', '2021-05-20 07:00:38'),
('87a016d1-b4c7-4b98-a547-9fb756913e4c', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0140\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:52:14', '2021-05-05 06:52:14'),
('87c39935-c82c-4fb9-b7f3-10c93a2b1f09', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0154\",\"note\":\"Please check\"}', '2021-05-28 08:42:48', '2021-05-27 06:32:05', '2021-05-28 08:42:48'),
('884cb895-7625-4590-bfe8-63241a12adcb', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0097\",\"note\":\"Approval is needed, Please check\"}', NULL, '2021-03-30 05:37:49', '2021-03-30 05:37:49'),
('88570780-1854-4208-a12b-cdba2ddef25a', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0052\",\"note\":\"Please Check\"}', '2021-04-07 03:25:52', '2021-04-06 10:52:32', '2021-04-07 03:25:52'),
('88f21658-1042-4641-b198-329058f0ab1e', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0085\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:52:44', '2021-05-05 06:52:44'),
('8907c7ff-4a88-49a7-ad6c-203a678854fe', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0055\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-07 03:12:03', '2021-05-20 06:56:25'),
('89cdebc4-4849-4ff3-8872-161987edc9a5', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0148\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:22:34', '2021-05-21 08:22:34'),
('8a9a7f79-ee97-46b9-8739-52afba3884a7', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0043\",\"note\":\"Please check\"}', NULL, '2021-04-01 10:20:45', '2021-04-01 10:20:45'),
('8ae1a8cf-8112-41f6-bd49-bf12c865a945', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0119\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-08 03:11:20', '2021-05-20 06:56:25'),
('8b3499f9-6dcc-4814-bc04-9ed6cef15e14', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0151\",\"note\":\"Please check\"}', NULL, '2021-05-24 08:14:52', '2021-05-24 08:14:52'),
('8b8bd467-1df7-4408-858d-c7db24daea48', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0131\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-16 09:48:53', '2021-05-20 06:56:25'),
('8be65b23-8c7e-44ec-bf03-77a434adaf07', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0036\",\"note\":\"Please check\"}', NULL, '2021-03-31 11:00:16', '2021-03-31 11:00:16'),
('8d336aee-148e-4429-8c50-2359c683eef4', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0039\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-01 09:52:53', '2021-05-20 06:56:25'),
('8da0fe07-ce79-4d4f-9028-2e10f7ae8d7f', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0108\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-05 06:34:09', '2021-05-20 06:56:25'),
('8dcd6935-2e29-42b3-ac31-cf0ce7922a02', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0090\",\"note\":\"Please Check\"}', NULL, '2021-05-17 03:08:03', '2021-05-17 03:08:03'),
('8f02a16b-5886-41c5-9bd8-9c0d81195e6a', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0131\",\"note\":\"Please check\"}', NULL, '2021-04-16 09:48:53', '2021-04-16 09:48:53'),
('8f19c936-7a87-458f-a257-5b0f4b3ba124', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0080\",\"note\":\"Please check\"}', NULL, '2021-04-30 08:04:28', '2021-04-30 08:04:28'),
('8f38c48b-ea86-41af-99f7-d5bc10571e11', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0128\",\"note\":\"Please Check\"}', '2021-04-19 04:00:21', '2021-04-16 03:42:25', '2021-04-19 04:00:21'),
('8fa31aba-eb03-405f-a656-492eae4ec49c', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0089\",\"note\":\"Please check\"}', NULL, '2021-05-11 03:41:57', '2021-05-11 03:41:57'),
('8fd6f37c-e00c-4565-b05a-cd5c3abbbb34', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0141\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-17 03:09:17', '2021-05-18 02:29:40'),
('8ff5a4b2-f88c-429f-8a22-f43b0203252e', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0051\",\"note\":\"Please Check\"}', NULL, '2021-04-06 10:49:35', '2021-04-06 10:49:35'),
('9170ddd3-3316-4f9e-b67d-9cb5423a8ca5', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0152\",\"note\":\"Please check\"}', '2021-05-28 08:42:48', '2021-05-24 09:33:00', '2021-05-28 08:42:48'),
('919ab6c5-f219-415e-9861-132cc0933e81', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0139\",\"note\":\"Please check\"}', NULL, '2021-04-28 06:53:17', '2021-04-28 06:53:17'),
('91c27e13-a1e4-4e12-b497-a7ed7d8d0951', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0053\",\"note\":\"Please Check\"}', NULL, '2021-04-07 03:11:20', '2021-04-07 03:11:20'),
('91e80015-3e74-4355-a972-02251007d9e5', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0149\",\"note\":\"Please check\"}', NULL, '2021-05-21 09:09:25', '2021-05-21 09:09:25');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('922c0456-1d9a-45a5-9d4d-9e0cd7596d1e', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0103\",\"note\":\"Please check\"}', NULL, '2021-03-31 09:15:11', '2021-03-31 09:15:11'),
('92c948c7-149a-40e1-bb49-0ebd6a4c01e4', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0153\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:34:46', '2021-05-24 09:34:46'),
('9324a989-00bd-49a4-a635-9ef06c513303', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0133\",\"note\":\"Please check\"}', NULL, '2021-04-19 02:51:43', '2021-04-19 02:51:43'),
('94e55a49-d803-459f-9c1e-647dd17010d7', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0151\",\"note\":\"Please check\"}', NULL, '2021-05-24 08:14:52', '2021-05-24 08:14:52'),
('94ecbfd5-e9a1-4d18-9830-025a01932ae2', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0142\",\"note\":\"Please check\"}', NULL, '2021-05-17 03:52:42', '2021-05-17 03:52:42'),
('95001c1c-512b-41a9-881a-fa8bba58bc0c', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0144\",\"note\":\"Please check\"}', NULL, '2021-05-21 07:43:37', '2021-05-21 07:43:37'),
('9647c46e-1e8f-406b-a84a-33b8bb1ee921', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0118\",\"note\":\"Please check\"}', NULL, '2021-04-07 05:41:34', '2021-04-07 05:41:34'),
('968c9c46-515e-4dc1-8213-196df169200c', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0099\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-03-30 09:25:17', '2021-05-20 06:56:25'),
('972f6b33-52b3-43d4-9333-ec6e8017be51', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0084\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-04 04:58:52', '2021-05-18 02:29:40'),
('97bda7d5-d5d5-4db0-886d-e455eaaa6451', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0065\",\"note\":\"Please Check\"}', NULL, '2021-04-16 08:45:55', '2021-04-16 08:45:55'),
('97ca5dda-3ef5-4bb5-94ea-c0fae519ee75', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0102\",\"note\":\"Please check\"}', NULL, '2021-03-31 08:10:05', '2021-03-31 08:10:05'),
('97d97225-a00f-4a5a-9991-940cb1a58881', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0080\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-04-30 08:04:28', '2021-05-18 02:29:40'),
('983a0c0c-3e8f-4443-a20b-2ebdaf1e2035', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0003\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-06 02:26:39', '2021-05-18 02:29:40'),
('98adcd75-95e2-45b9-8991-6ad526440761', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0152\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:33:00', '2021-05-24 09:33:00'),
('992d82f9-fdd8-479d-ae7c-186f2b9f89ed', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0070\",\"note\":\"Please check\"}', NULL, '2021-04-19 04:33:11', '2021-04-19 04:33:11'),
('99af88c4-ed4a-49ee-becd-92311702bf74', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0117\",\"note\":\"Please check\"}', '2021-04-07 03:25:52', '2021-04-07 03:22:23', '2021-04-07 03:25:52'),
('9a6b15ee-0829-4158-9c29-103af8f33b6a', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0068\",\"note\":\"Please Check\"}', '2021-04-19 03:58:12', '2021-04-19 03:56:31', '2021-04-19 03:58:12'),
('9aa67e79-b7d9-4850-b378-74800a456a67', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0041\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-01 10:16:36', '2021-04-05 05:41:51'),
('9b2f689a-53de-475e-8668-7968be6a3aba', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0142\",\"note\":\"Please check\"}', NULL, '2021-05-17 03:52:42', '2021-05-17 03:52:42'),
('9b4e123f-d64c-47c2-b477-a4e57e1aef14', 'App\\Notifications\\eventNotification', 'App\\User', 56, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0120\",\"note\":\"Please check\"}', NULL, '2021-04-08 03:49:21', '2021-04-08 03:49:21'),
('9b735e54-3ff2-4cd4-a65d-499ad33eeaf0', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0002\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-05 09:26:56', '2021-05-20 06:56:25'),
('9b827eba-4eb9-4692-84fe-df6e4986f8d3', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0137\",\"note\":\"Please check\"}', NULL, '2021-04-23 08:14:24', '2021-04-23 08:14:24'),
('9b9fcdd1-ff74-48c3-9159-22f6685cfa46', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0153\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:34:46', '2021-05-24 09:34:46'),
('9c6517e5-e647-4fc0-8d90-e581ddb01bf7', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0069\",\"note\":\"Please check\"}', NULL, '2021-04-19 04:05:49', '2021-04-19 04:05:49'),
('9cabedf7-55ab-43dd-9d40-c61ec15bb06d', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0017\",\"note\":\"Please check\"}', NULL, '2021-04-07 03:18:19', '2021-04-07 03:18:19'),
('9d0e1c6a-5023-4b97-8de4-260e7bca3a00', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0143\",\"note\":\"Please check\"}', NULL, '2021-05-20 07:00:38', '2021-05-20 07:00:38'),
('9d33d86b-8b3b-4fe8-a68a-252abd3f363f', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0017\",\"note\":\"Please check\"}', NULL, '2021-04-07 03:18:19', '2021-04-07 03:18:19'),
('9eecb29f-9918-4d0e-9fb0-fdbdd3a7e094', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0150\",\"note\":\"Please check\"}', NULL, '2021-05-24 07:27:11', '2021-05-24 07:27:11'),
('9f153605-019c-4e30-a738-ab59c36a17ec', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0080\",\"note\":\"Please check\"}', NULL, '2021-04-30 08:04:28', '2021-04-30 08:04:28'),
('9f853e93-b70f-4abb-bb89-60b37f8a0658', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0131\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-16 09:48:53', '2021-04-29 03:31:47'),
('9fae8429-bbe8-4176-8c70-5c28516628a7', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0086\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:56:11', '2021-05-05 06:56:11'),
('9fd62401-d410-40b5-90f6-aa35ace4460d', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0153\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:34:46', '2021-05-24 09:34:46'),
('a0273569-22a5-4804-932c-68384ef70389', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0147\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:20:45', '2021-05-21 08:20:45'),
('a071799e-ef00-441e-a2dd-706520e1c0e8', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0126\",\"note\":\"Please check\"}', NULL, '2021-04-15 07:35:35', '2021-04-15 07:35:35'),
('a074fd15-d82d-4da4-abfd-07b2b8733040', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0127\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-16 02:38:05', '2021-04-29 03:31:47'),
('a0c9622f-7164-4edf-9e19-a3cfd8c1ea70', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0153\",\"note\":\"Please check\"}', '2021-05-28 08:42:48', '2021-05-24 09:34:46', '2021-05-28 08:42:48'),
('a0f343e6-194e-4a2a-bb66-c0b3394e79b7', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0138\",\"note\":\"Please check\"}', NULL, '2021-04-25 13:23:16', '2021-04-25 13:23:16'),
('a18cb944-6428-43bf-8745-61003d310bdd', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0083\",\"note\":\"Please check\"}', NULL, '2021-05-03 07:04:01', '2021-05-03 07:04:01'),
('a1eddd13-8ea9-4b61-926f-49ddca657c57', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0120\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-08 03:49:21', '2021-05-20 06:56:25'),
('a2674ca8-8028-42ea-8906-a0ff89dc2db6', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0067\",\"note\":\"Please Check\"}', '2021-04-16 10:03:55', '2021-04-16 10:03:42', '2021-04-16 10:03:55'),
('a2a67148-0080-42e7-ae66-94da536467d6', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0074\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-28 07:11:05', '2021-04-29 03:31:47'),
('a2d8a65a-82f5-494d-9a38-8cc11171a83c', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0020\",\"note\":\"Please check\"}', NULL, '2021-05-27 08:14:01', '2021-05-27 08:14:01'),
('a3799b7e-144f-43a5-81b0-7d52d507fe7b', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0140\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-05 06:52:14', '2021-05-18 02:29:40'),
('a3aa59c7-2a72-4cc3-b05d-83b4d5b585d1', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0064\",\"note\":\"Please Check\"}', '2021-04-16 07:46:31', '2021-04-16 07:46:07', '2021-04-16 07:46:31'),
('a403bb96-c435-4f8d-850f-757bbf3dd1fd', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0111\",\"note\":\"Please check\"}', '2021-04-07 03:25:52', '2021-04-06 09:53:11', '2021-04-07 03:25:52'),
('a435ab36-2f72-483e-92bc-a8545330928b', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0127\",\"note\":\"Please check\"}', '2021-04-16 03:46:34', '2021-04-16 02:38:05', '2021-04-16 03:46:34'),
('a475c8ee-4e06-4d5e-99c6-7d88c42da7e3', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0076\",\"note\":\"Please check\"}', NULL, '2021-04-30 03:06:32', '2021-04-30 03:06:32'),
('a48db497-f41f-4666-ba6c-eed9bc9aaa88', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0145\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:05:34', '2021-05-21 08:05:34'),
('a4a15a9c-e98f-4ae4-b15e-1c274d937c93', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0018\",\"note\":\"Please check\"}', NULL, '2021-04-23 03:31:49', '2021-04-23 03:31:49'),
('a5ab02d9-ac6a-4b3b-a2da-3271d6b70929', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0081\",\"note\":\"Please check\"}', NULL, '2021-05-03 03:48:06', '2021-05-03 03:48:06'),
('a5c3585a-159f-48a7-9fd1-920683431266', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0083\",\"note\":\"Please check\"}', NULL, '2021-05-03 07:04:01', '2021-05-03 07:04:01'),
('a5ecc353-dcd6-43ab-b6bb-565b19bd3279', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0141\",\"note\":\"Please check\"}', NULL, '2021-05-17 03:09:17', '2021-05-17 03:09:17'),
('a5f68e11-1c05-4e17-818a-4297b04e08ce', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0138\",\"note\":\"Please check\"}', NULL, '2021-04-25 13:23:16', '2021-04-25 13:23:16'),
('a65d0604-63de-4057-991e-eb92a8b6daf4', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0144\",\"note\":\"Please check\"}', NULL, '2021-05-21 07:43:37', '2021-05-21 07:43:37'),
('a6c6bf01-135e-41a6-96ed-bf9b5a27a85b', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0048\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-05 08:36:30', '2021-05-20 06:56:25'),
('a6da4ca6-2929-4309-93cd-fdb50bc75bbc', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0142\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-17 03:52:42', '2021-05-20 06:56:25'),
('a749d3e5-82cb-4ba6-abf8-5168bbc89899', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0133\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-19 02:51:43', '2021-04-29 03:31:47'),
('a7be24c6-c992-46ce-8325-dd300f9fb5c9', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0096\",\"note\":\"Please Check\"}', NULL, '2021-05-21 08:18:35', '2021-05-21 08:18:35'),
('a80c5a19-5466-4938-8db4-a127af4fb750', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0081\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-03 03:48:06', '2021-05-20 06:56:25'),
('a8cb704b-5993-4c79-a3b0-dfd47677db18', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0037\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-01 07:49:14', '2021-04-05 05:41:51'),
('a90e32bf-068b-4109-ad79-b08625e20a7c', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0141\",\"note\":\"Please check\"}', NULL, '2021-05-17 03:09:17', '2021-05-17 03:09:17'),
('a93425fa-0092-45a2-86ec-ee27fd0c0909', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0137\",\"note\":\"Please check\"}', NULL, '2021-04-23 08:14:24', '2021-04-23 08:14:24'),
('a9565067-2fc2-433b-8115-c1beec5acf0f', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0088\",\"note\":\"Please check\"}', NULL, '2021-05-05 08:26:43', '2021-05-05 08:26:43'),
('a9c4ad59-448a-450b-8f1a-9dc0a177dde5', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0126\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-15 07:35:35', '2021-05-20 06:56:25'),
('a9dd3c82-5ab9-41af-8b3b-f1591f643564', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0074\",\"note\":\"Please check\"}', NULL, '2021-04-28 07:11:05', '2021-04-28 07:11:05'),
('a9ddecfd-e075-4182-8a5c-50fd0c0a2a87', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0117\",\"note\":\"Please check\"}', NULL, '2021-04-07 03:22:23', '2021-04-07 03:22:23'),
('aa1db2e7-6f95-4273-9567-7146c4aee50e', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0072\",\"note\":\"Please Check\"}', NULL, '2021-04-23 03:40:37', '2021-04-23 03:40:37'),
('ab209014-e909-4c91-a74b-e5ac89b5ece5', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0134\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-19 02:54:26', '2021-05-20 06:56:25'),
('ab36390e-5832-4dd9-90a3-42e6af9374a4', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0020\",\"note\":\"Please check\"}', NULL, '2021-05-27 08:14:01', '2021-05-27 08:14:01'),
('abb4b573-b291-4605-857d-f3592d22c352', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0047\",\"note\":\"Please check\"}', NULL, '2021-04-05 08:07:47', '2021-04-05 08:07:47'),
('abd17585-13d3-49c5-ba06-77b3247112a5', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0058\",\"note\":\"Please Check\"}', NULL, '2021-04-09 07:53:41', '2021-04-09 07:53:41'),
('ac4ea4bd-8baa-470b-9d48-ceaebdee4a93', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0083\",\"note\":\"Please check\"}', NULL, '2021-05-03 07:04:01', '2021-05-03 07:04:01'),
('ac7276f4-9530-4feb-b622-ed129fc07cde', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"WO has been abandoned by admin\",\"url\":\"womaint\",\"nbr\":\"WO-21-0058\",\"note\":\"Please check\"}', '2021-04-16 07:28:40', '2021-04-16 03:48:29', '2021-04-16 07:28:40'),
('ac94c6bd-274f-4c33-ac30-173509a2ad4b', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0020\",\"note\":\"Please check\"}', NULL, '2021-05-27 08:14:01', '2021-05-27 08:14:01'),
('acbfe9bf-59ac-4d42-a0b3-e431792c24e5', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0004\",\"note\":\"Please check\"}', NULL, '2021-05-24 10:01:28', '2021-05-24 10:01:28'),
('acd7543b-1435-4881-9574-b0220087ea74', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0149\",\"note\":\"Please check\"}', NULL, '2021-05-21 09:09:25', '2021-05-21 09:09:25'),
('ad6b58c2-251b-4bb8-ad4f-5960ce25052c', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0147\",\"note\":\"Please check\"}', '2021-05-21 09:36:58', '2021-05-21 08:20:45', '2021-05-21 09:36:58'),
('ad8c8e85-7b0d-43d4-9635-e435297efa7c', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0005\",\"note\":\"Please check\"}', '2021-05-28 08:42:48', '2021-05-27 02:48:00', '2021-05-28 08:42:48'),
('ad9d2921-2730-461b-a4fe-aaa6a6c8def7', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0143\",\"note\":\"Please check\"}', NULL, '2021-05-20 07:00:38', '2021-05-20 07:00:38'),
('ae2b586c-39df-4da7-9c4c-bb90e2b10578', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0062\",\"note\":\"Please Check\"}', '2021-04-16 07:25:46', '2021-04-15 09:31:39', '2021-04-16 07:25:46'),
('ae5823fc-73c2-44da-9d86-4a8afeb952eb', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"WO has been abandoned by eng02\",\"url\":\"womaint\",\"nbr\":\"WO-21-0102\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:40:20', '2021-05-24 09:40:20'),
('ae5d80eb-f5ef-4a61-9fe8-f5c02a3afe7f', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0089\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-11 03:41:57', '2021-05-18 02:29:40'),
('ae67c357-c12f-42af-bdcb-f849498be8ee', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0004\",\"note\":\"Please check\"}', NULL, '2021-05-24 10:01:28', '2021-05-24 10:01:28'),
('af078e6b-a05b-4717-ab4f-265fce26a34b', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0101\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-03-31 04:31:59', '2021-05-20 06:56:25'),
('b0ac17c0-99e4-4127-9c63-e5d962296467', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0130\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-16 08:45:29', '2021-05-20 06:56:25'),
('b28fa83a-0671-4fde-b74a-72da8bd7011d', 'App\\Notifications\\eventNotification', 'App\\User', 60, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0144\",\"note\":\"Please Check\"}', NULL, '2021-05-21 07:49:03', '2021-05-21 07:49:03'),
('b463b0e2-b8a6-401f-87a5-81c1ec976c6c', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0006\",\"note\":\"Please check\"}', NULL, '2021-06-02 02:47:43', '2021-06-02 02:47:43'),
('b48f8763-24c1-4733-9ac7-960c113ea9b8', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0114\",\"note\":\"Please check\"}', NULL, '2021-04-07 03:12:43', '2021-04-07 03:12:43'),
('b51c0366-b33a-48fe-aac3-f390120acf31', 'App\\Notifications\\eventNotification', 'App\\User', 60, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0149\",\"note\":\"Please Check\"}', NULL, '2021-05-21 09:11:29', '2021-05-21 09:11:29'),
('b51fab7e-4dae-4394-b1b1-0fc6907d23c3', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0135\",\"note\":\"Please Check\"}', '2021-04-19 07:54:58', '2021-04-19 06:53:49', '2021-04-19 07:54:58'),
('b59143be-8294-4618-b7f5-0a364abf2c6d', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0138\",\"note\":\"Please check\"}', '2021-04-30 06:14:08', '2021-04-25 13:23:16', '2021-04-30 06:14:08'),
('b5b4a57a-acfe-4a3e-85ad-8b1f69330a08', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0051\",\"note\":\"Please Check\"}', NULL, '2021-04-06 10:49:35', '2021-04-06 10:49:35'),
('b62d1c8c-afc9-42e3-a6b0-ed42da22cd30', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0090\",\"note\":\"Please Check\"}', NULL, '2021-05-17 03:08:03', '2021-05-17 03:08:03'),
('b66a170f-e148-4bed-9b47-5235ca128e13', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0100\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-03-30 09:25:43', '2021-04-05 05:41:51'),
('b6786a99-f0cf-4672-b1af-2e9df0d6792a', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0027\",\"note\":\"Please Check\"}', '2021-05-20 06:56:25', '2021-03-30 06:12:49', '2021-05-20 06:56:25'),
('b7b22da8-eb1a-4673-8923-fd8247b4a67c', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0063\",\"note\":\"Please Check\"}', '2021-04-16 07:26:12', '2021-04-16 03:42:21', '2021-04-16 07:26:12'),
('b8b2a8ff-f04f-4a3a-b4b6-a7f7aa0a80dc', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0017\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-07 03:18:19', '2021-05-20 06:56:25'),
('b93f40f4-cb85-4b14-9b23-b144131473b5', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0001\",\"note\":\"Please check\"}', NULL, '2021-05-05 07:19:50', '2021-05-05 07:19:50'),
('b979d5c1-400e-4a66-adbf-b1f0260b3c44', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0106\",\"note\":\"Please check\"}', NULL, '2021-04-05 03:13:37', '2021-04-05 03:13:37'),
('b9feeb40-3751-490a-b2a5-4386b3213669', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0052\",\"note\":\"Please Check\"}', NULL, '2021-04-06 10:52:32', '2021-04-06 10:52:32'),
('ba3b13a1-1601-43f2-9af6-40f3016a3046', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0051\",\"note\":\"Please Check\"}', '2021-05-20 06:56:25', '2021-04-06 10:49:35', '2021-05-20 06:56:25'),
('ba91b5ba-632f-4dcd-a7e9-f898556bab22', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0044\",\"note\":\"Please check\"}', NULL, '2021-04-01 10:22:20', '2021-04-01 10:22:20'),
('bb67011f-5240-4405-80c4-1856017f6cba', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0097\",\"note\":\"Please Check\"}', NULL, '2021-05-21 08:21:22', '2021-05-21 08:21:22'),
('bb868f1b-1baf-4035-a8cc-add469a39609', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0098\",\"note\":\"Please check\"}', NULL, '2021-03-30 08:55:14', '2021-03-30 08:55:14'),
('bbff5148-9608-4ca2-8573-757932964c0d', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0097\",\"note\":\"Please Check\"}', NULL, '2021-05-21 08:21:22', '2021-05-21 08:21:22'),
('bc4e5b0f-367d-43c0-9a0f-4cca017d63d3', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0099\",\"note\":\"Please Check\"}', NULL, '2021-05-21 09:11:24', '2021-05-21 09:11:24'),
('bccb99c5-510d-4c6b-8d46-592d101fe961', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0103\",\"note\":\"Please check\"}', NULL, '2021-05-27 05:06:38', '2021-05-27 05:06:38'),
('bd0e0ee3-c296-4fdd-8425-13ffd9dc786c', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0043\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-01 10:20:45', '2021-04-05 05:41:51'),
('bd51e786-2f14-44a1-a464-d70cef5ed056', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0071\",\"note\":\"Please Check\"}', NULL, '2021-04-19 06:53:45', '2021-04-19 06:53:45'),
('bd95c93b-addb-4395-86b4-fc15f61b2904', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"WO has been abandoned by eng02\",\"url\":\"womaint\",\"nbr\":\"WO-21-0102\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:40:20', '2021-05-24 09:40:20'),
('bdc744f0-5428-4b6e-bffe-0e33b37f739c', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0005\",\"note\":\"Please check\"}', NULL, '2021-05-27 02:48:00', '2021-05-27 02:48:00'),
('be972113-7fb0-4828-83ac-a0b13866abd6', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0099\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-03-30 09:25:17', '2021-04-05 05:41:51'),
('c0408ccc-275c-4a6d-bc9f-e62e528b9582', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0132\",\"note\":\"Please check\"}', NULL, '2021-04-16 10:03:06', '2021-04-16 10:03:06'),
('c0c01c84-7be2-4bda-98d7-81a6bdfadbd8', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0047\",\"note\":\"Please check\"}', '2021-04-05 08:10:21', '2021-04-05 08:07:47', '2021-04-05 08:10:21'),
('c18fb0f5-f487-4413-be7d-8e4e6e462888', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0110\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-05 09:26:59', '2021-05-20 06:56:25'),
('c20f538d-5fbd-47b2-aa7a-48023ea1c2f9', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0086\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:56:11', '2021-05-05 06:56:11'),
('c2481132-8922-4632-8622-c5ff874ec59b', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0096\",\"note\":\"Please Check\"}', NULL, '2021-05-21 08:18:35', '2021-05-21 08:18:35'),
('c27a97d1-2041-4ff8-adaf-4e21a1ebfe97', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0041\",\"note\":\"Please check\"}', NULL, '2021-04-01 10:16:36', '2021-04-01 10:16:36'),
('c27b438e-7365-4a4b-9a0d-c2e4ecd42e42', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0104\",\"note\":\"Please check\"}', NULL, '2021-05-27 05:11:11', '2021-05-27 05:11:11'),
('c2e8c761-a809-4a52-947c-3f81b99f2195', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0096\",\"note\":\"Please Check\"}', NULL, '2021-05-21 08:18:35', '2021-05-21 08:18:35'),
('c321315a-a89d-4006-9f56-821ce47b9905', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0005\",\"note\":\"Please check\"}', NULL, '2021-05-27 02:48:00', '2021-05-27 02:48:00'),
('c336340e-4a3b-41a4-9144-05acd7c7830d', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0148\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:22:34', '2021-05-21 08:22:34'),
('c33da1f2-577f-4114-b54f-d696c81cc97d', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0113\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-07 03:10:35', '2021-05-20 06:56:25'),
('c371a70c-b5e8-421c-9bde-0a2ac1a01903', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0140\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:52:14', '2021-05-05 06:52:14'),
('c3a14df9-4f31-4323-b483-ecb70b828e2e', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0123\",\"note\":\"Please check\"}', '2021-04-15 08:14:45', '2021-04-09 07:53:00', '2021-04-15 08:14:45'),
('c3b4c071-f61c-475b-a108-0aa79fdbb34c', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0126\",\"note\":\"Please check\"}', '2021-04-15 08:14:21', '2021-04-15 07:35:35', '2021-04-15 08:14:21'),
('c409d43b-4ef7-433d-98bf-2f16e7a113ea', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0061\",\"note\":\"Please Check\"}', '2021-04-16 03:46:34', '2021-04-15 09:10:23', '2021-04-16 03:46:34'),
('c419a185-ea72-4db8-9a31-813a2947e8da', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0140\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:52:14', '2021-05-05 06:52:14'),
('c43015f0-41e3-45d0-afb1-1c144df43d8a', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0121\",\"note\":\"Please check\"}', NULL, '2021-04-08 07:52:15', '2021-04-08 07:52:15'),
('c44a914c-85fb-4148-a7eb-a6623ba1d831', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0002\",\"note\":\"Please check\"}', NULL, '2021-05-05 09:26:56', '2021-05-05 09:26:56'),
('c458d71d-5338-41f6-a3b8-24714b8a39b5', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0154\",\"note\":\"Please check\"}', NULL, '2021-05-27 06:32:05', '2021-05-27 06:32:05'),
('c4bc0217-4aef-4ede-aa54-a8c0c1220522', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0126\",\"note\":\"Please check\"}', '2021-04-15 08:14:49', '2021-04-15 07:35:35', '2021-04-15 08:14:49'),
('c550cf7f-076a-4d52-9f42-2a073744130f', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0134\",\"note\":\"Please check\"}', NULL, '2021-04-19 02:54:26', '2021-04-19 02:54:26'),
('c5871639-f2ae-402d-a95f-81fe457f7dae', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0080\",\"note\":\"Please check\"}', NULL, '2021-04-30 08:04:28', '2021-04-30 08:04:28'),
('c5c62ac8-2e7c-4b38-a2c3-eb46b8e34808', 'App\\Notifications\\eventNotification', 'App\\User', 64, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0098\",\"note\":\"Please Check\"}', NULL, '2021-05-21 08:37:11', '2021-05-21 08:37:11'),
('c62a3823-5b35-4148-89f9-a6843f9b625e', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0055\",\"note\":\"Please check\"}', '2021-04-07 03:25:52', '2021-04-07 03:12:03', '2021-04-07 03:25:52'),
('c6875e97-bc8a-4f5a-9e2d-96e8b8acaee6', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0051\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-06 02:59:52', '2021-05-20 06:56:25'),
('c6bddfe5-deed-49db-a62c-4d8927915cc9', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0135\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-19 06:51:13', '2021-04-29 03:31:47'),
('c756dd3c-13fb-4395-9745-af3d7adc4f74', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0027\",\"note\":\"Please Check\"}', '2021-03-30 09:16:48', '2021-03-30 06:12:49', '2021-03-30 09:16:48'),
('c75bd1e7-f4b7-4b1a-a53a-1d765ec8f2c1', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0036\",\"note\":\"Please check\"}', '2021-04-01 03:43:21', '2021-03-31 11:00:16', '2021-04-01 03:43:21'),
('c8509fd8-598a-4428-8bf0-74b34edefd7e', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0043\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-01 10:20:45', '2021-05-20 06:56:25'),
('c94b14e3-9ae2-47c7-b2d7-d05fa8301d93', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0129\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-16 07:28:21', '2021-05-20 06:56:25'),
('ca2f5589-67cb-4856-b492-f1b2135fce78', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0070\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-19 04:33:11', '2021-05-20 06:56:25'),
('cb5ebf2d-368f-46f3-979e-175699920143', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0141\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-17 03:09:17', '2021-05-20 06:56:25'),
('cb83cb11-b1f4-4a13-9207-ea51992fc1ae', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0085\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-05 06:52:44', '2021-05-18 02:29:40'),
('cba0cf64-904c-4234-8c98-4373a55901c1', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0005\",\"note\":\"Please check\"}', NULL, '2021-05-27 02:48:00', '2021-05-27 02:48:00'),
('cbe549f9-d333-482a-8649-6b4c4a443b69', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0030\",\"note\":\"Please Check\"}', '2021-03-30 09:16:48', '2021-03-30 07:51:00', '2021-03-30 09:16:48'),
('cbfac53d-5bad-4b68-a365-8a23dd49749a', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0122\",\"note\":\"Please check\"}', NULL, '2021-04-09 06:44:40', '2021-04-09 06:44:40'),
('cc0af6b1-31da-4aa2-bd62-d57c7062bae0', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0035\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-03-31 08:29:21', '2021-04-05 05:41:51'),
('cc6acaf7-dea7-41cb-949a-03020b7e308c', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0005\",\"note\":\"Please check\"}', NULL, '2021-05-27 02:48:00', '2021-05-27 02:48:00'),
('cc8093fb-0d61-4438-bdb1-46e1cd19d804', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0147\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:20:45', '2021-05-21 08:20:45'),
('cca57125-3070-4494-8037-79d41e6a3662', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0002\",\"note\":\"Please check\"}', NULL, '2021-05-05 09:26:56', '2021-05-05 09:26:56'),
('cdee2036-942e-45d7-9695-ff9ec2f027e7', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0086\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:56:11', '2021-05-05 06:56:11'),
('ce0d722c-1261-49b5-abce-fffa322d32fe', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0113\",\"note\":\"Please check\"}', NULL, '2021-04-07 03:10:35', '2021-04-07 03:10:35'),
('d017b7a4-3cce-4ec5-9ec8-24d0edae5f4a', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0112\",\"note\":\"Please check\"}', NULL, '2021-04-06 10:52:08', '2021-04-06 10:52:08'),
('d0349bc7-ebe7-4b51-8a52-3070a379583c', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0133\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-19 02:51:43', '2021-05-20 06:56:25'),
('d060c22f-5fa8-42c3-aca8-25110c897938', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0147\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:20:45', '2021-05-21 08:20:45'),
('d0fb1b7c-f907-46d9-8c44-f86299e8843a', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0139\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-28 06:53:17', '2021-05-20 06:56:25'),
('d13a3f8f-93d0-467a-adf9-9a56f1af517e', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"WO has been abandoned by eng02\",\"url\":\"womaint\",\"nbr\":\"WO-21-0102\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:40:20', '2021-05-24 09:40:20'),
('d15e3439-d331-4496-8dc2-fe5bcc638392', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0099\",\"note\":\"Please check\"}', NULL, '2021-03-30 09:25:17', '2021-03-30 09:25:17'),
('d1682c67-7a9f-4cd6-9f52-37864719b1c4', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"WO has been abandoned by admin\",\"url\":\"womaint\",\"nbr\":\"WO-21-0058\",\"note\":\"Please check\"}', '2021-04-16 07:28:40', '2021-04-16 03:44:31', '2021-04-16 07:28:40'),
('d196f809-07c6-47c1-9cb2-223ce4e859d9', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0135\",\"note\":\"Please check\"}', NULL, '2021-04-19 06:51:13', '2021-04-19 06:51:13'),
('d1986682-b2d2-4fb3-b882-59143767177c', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0088\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-05 08:26:43', '2021-05-18 02:29:40'),
('d1ce96e5-3aac-4cb7-95c2-a044d3a0015c', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0019\",\"note\":\"Please check\"}', NULL, '2021-04-25 12:56:17', '2021-04-25 12:56:17'),
('d1ea8f81-5c68-4c43-b4de-2885b9258961', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0149\",\"note\":\"Please check\"}', NULL, '2021-05-21 09:09:25', '2021-05-21 09:09:25'),
('d20b4adc-6e45-493f-9d1f-bdb22572f93b', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0045\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-01 10:59:57', '2021-04-05 05:41:51'),
('d259e023-2776-4140-95f0-ee06a2caddc7', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0088\",\"note\":\"Please check\"}', NULL, '2021-05-05 08:26:43', '2021-05-05 08:26:43'),
('d3010113-0507-4825-a690-d49b0a9e8556', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0052\",\"note\":\"Please Check\"}', '2021-05-20 06:56:25', '2021-04-06 10:52:32', '2021-05-20 06:56:25'),
('d39dfe9c-ba09-472e-bc62-747b4a04d2fc', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0098\",\"note\":\"Please Check\"}', NULL, '2021-05-21 08:37:11', '2021-05-21 08:37:11'),
('d3bceb93-f9d7-4748-8799-4138f895e0bb', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0076\",\"note\":\"Please check\"}', NULL, '2021-04-30 03:06:32', '2021-04-30 03:06:32'),
('d3c4a5aa-8cd6-4b62-b346-7cb5f81ae935', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0151\",\"note\":\"Please check\"}', '2021-05-28 08:42:48', '2021-05-24 08:14:52', '2021-05-28 08:42:48'),
('d50f2db1-6ad0-45a4-9e66-f1735c46a4f8', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0111\",\"note\":\"Please Check\"}', '2021-04-07 03:25:52', '2021-04-06 10:49:39', '2021-04-07 03:25:52'),
('d5168fb6-841f-4b19-97b1-3f0091c991c5', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0098\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-03-30 08:55:14', '2021-05-20 06:56:25'),
('d57014fa-d449-4bc7-8612-57bfe9deee86', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0144\",\"note\":\"Please check\"}', NULL, '2021-05-21 07:43:37', '2021-05-21 07:43:37'),
('d5b0c9b8-8bde-44b7-bbb6-69aea7f67248', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0145\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:05:34', '2021-05-21 08:05:34'),
('d6206797-d879-48d3-ba63-243309a54847', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0122\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-09 06:44:40', '2021-05-20 06:56:25'),
('d621d997-92a4-4670-bff9-35aa2d361083', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0055\",\"note\":\"Please check\"}', NULL, '2021-04-07 03:12:03', '2021-04-07 03:12:03'),
('d6b88c3b-c7f6-4575-9eaa-0740b0b6a62e', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0109\",\"note\":\"Please check\"}', '2021-04-05 08:10:21', '2021-04-05 07:48:24', '2021-04-05 08:10:21'),
('d707778b-f55d-4aa9-a89a-537af31dc313', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0140\",\"note\":\"Please Check\"}', '2021-05-20 06:56:25', '2021-05-05 08:16:05', '2021-05-20 06:56:25'),
('d7b7364d-7dc0-425a-8e32-fd889d32a8c7', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0144\",\"note\":\"Please check\"}', NULL, '2021-05-21 07:43:37', '2021-05-21 07:43:37'),
('d7d48c94-d56f-4d7b-a129-9daa874f720b', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0135\",\"note\":\"Please check\"}', NULL, '2021-04-19 06:51:13', '2021-04-19 06:51:13'),
('d82b84aa-4db2-4060-a7c7-7802e8d8f9e6', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0148\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:22:34', '2021-05-21 08:22:34');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('d872dce0-1882-4e11-8f8e-d1c966ba18ce', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0147\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:20:45', '2021-05-21 08:20:45'),
('d8db1a2a-66fc-41d1-a7df-8e276dbd05ba', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0150\",\"note\":\"Please Check\"}', NULL, '2021-05-24 07:30:13', '2021-05-24 07:30:13'),
('d92fd395-1bae-48dd-941c-a67de8bcc17e', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0105\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-01 04:57:48', '2021-05-20 06:56:25'),
('d981e01b-0a25-4ddd-bbb6-9c12c4becbe2', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0045\",\"note\":\"Please Check\"}', '2021-04-05 08:10:21', '2021-04-05 07:50:57', '2021-04-05 08:10:21'),
('d9eb920a-3d9f-49bd-a3bb-5fa204f0d155', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0088\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-05-05 08:26:43', '2021-05-20 06:56:25'),
('da10bfbc-4bf0-4fa3-97bd-65bcca9735a3', 'App\\Notifications\\eventNotification', 'App\\User', 56, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0123\",\"note\":\"Please check\"}', NULL, '2021-04-09 07:53:00', '2021-04-09 07:53:00'),
('db61c594-6385-4995-898a-124367391b50', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0083\",\"note\":\"Please check\"}', NULL, '2021-05-03 07:04:01', '2021-05-03 07:04:01'),
('dbf3a82e-44bb-4c4c-85d0-e61707e05bbe', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0137\",\"note\":\"Please check\"}', '2021-04-30 06:14:08', '2021-04-23 08:14:24', '2021-04-30 06:14:08'),
('dc05fb66-0180-4d7f-a659-572e3bb27343', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0039\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-01 09:52:53', '2021-04-05 05:41:51'),
('dc8b4843-4166-4403-9fe1-97d6a389b840', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0062\",\"note\":\"Please Check\"}', '2021-04-16 03:46:34', '2021-04-15 09:31:39', '2021-04-16 03:46:34'),
('dc912d88-cd82-4143-b892-d3185704edba', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0154\",\"note\":\"Please check\"}', NULL, '2021-05-27 06:32:05', '2021-05-27 06:32:05'),
('de0607e5-c1dd-4853-b1aa-c8ef8e702013', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0063\",\"note\":\"Please Check\"}', '2021-04-16 07:25:44', '2021-04-16 03:42:21', '2021-04-16 07:25:44'),
('defc521a-37cd-4f13-a961-4759bc196be3', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0070\",\"note\":\"Please check\"}', NULL, '2021-04-19 04:33:11', '2021-04-19 04:33:11'),
('e0ac5fd7-5c59-46a3-bc33-305d3b446d57', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0059\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-13 08:25:21', '2021-05-20 06:56:25'),
('e1028f3e-3f6b-40b4-85bf-6a1e53777840', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0004\",\"note\":\"Please check\"}', NULL, '2021-05-24 10:01:28', '2021-05-24 10:01:28'),
('e18eaef9-84f7-4fe3-8b98-7ba66f62f079', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0137\",\"note\":\"Please check\"}', NULL, '2021-04-23 08:14:24', '2021-04-23 08:14:24'),
('e1cee237-5b19-4d01-bce7-6f3f4cbb4f3a', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0146\",\"note\":\"Please Check\"}', '2021-05-21 09:36:58', '2021-05-21 08:18:39', '2021-05-21 09:36:58'),
('e1d11a6c-d943-4194-ade6-319c7414d293', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0075\",\"note\":\"Please Check\"}', '2021-04-29 03:31:47', '2021-04-28 07:14:11', '2021-04-29 03:31:47'),
('e1e96f40-124b-4e8d-8041-971273598527', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0107\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-05 05:33:33', '2021-04-05 05:41:51'),
('e1ec6e67-09fc-4987-b713-98c3a6ee37b3', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0035\",\"note\":\"Please check\"}', NULL, '2021-03-31 08:29:21', '2021-03-31 08:29:21'),
('e2094839-517a-4eed-96cd-e7cd3dc5a27c', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0143\",\"note\":\"Please check\"}', NULL, '2021-05-20 07:00:38', '2021-05-20 07:00:38'),
('e21cec72-c19c-458d-bbf6-ec5a06c5235b', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0006\",\"note\":\"Please check\"}', NULL, '2021-06-02 02:47:43', '2021-06-02 02:47:43'),
('e21eda25-bf71-4484-a86b-34f242061df2', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0092\",\"note\":\"Please Check\"}', '2021-03-30 09:16:48', '2021-03-30 07:49:26', '2021-03-30 09:16:48'),
('e35dddad-d076-4316-93f8-6d4dbbb878da', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0118\",\"note\":\"Please check\"}', '2021-04-08 03:46:04', '2021-04-07 05:41:34', '2021-04-08 03:46:04'),
('e3ceeedf-98da-453e-bb5c-863de53330a5', 'App\\Notifications\\eventNotification', 'App\\User', 60, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0125\",\"note\":\"Please Check\"}', NULL, '2021-04-15 09:10:27', '2021-04-15 09:10:27'),
('e4551c4d-5a95-4f86-a7b2-dbd6934a1fa4', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0073\",\"note\":\"Please check\"}', NULL, '2021-04-25 11:56:25', '2021-04-25 11:56:25'),
('e53b6e48-08c2-4b1c-be9f-ef03e176f3ac', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0044\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-01 10:22:20', '2021-04-05 05:41:51'),
('e5b68ae7-13c8-4c71-96fa-85b536f518c2', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0139\",\"note\":\"Please check\"}', NULL, '2021-04-28 06:53:17', '2021-04-28 06:53:17'),
('e5cb2a44-5a2c-4d08-af58-f3e09f246438', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0117\",\"note\":\"Please Check\"}', '2021-04-07 03:25:52', '2021-04-07 03:22:53', '2021-04-07 03:25:52'),
('e605f363-12c7-4679-9c30-2d694eec75c8', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0004\",\"note\":\"Please check\"}', NULL, '2021-05-24 10:01:28', '2021-05-24 10:01:28'),
('e6214070-1944-4d10-8244-5ed80b26fa9b', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0104\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-01 04:56:48', '2021-04-05 05:41:51'),
('e6d0a8a5-1562-4035-ab01-80a42fab7e98', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0112\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-06 10:52:08', '2021-05-20 06:56:25'),
('e75cc4bc-383d-4c10-8983-4dab431f8908', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0146\",\"note\":\"Please check\"}', '2021-05-21 09:36:58', '2021-05-21 08:09:50', '2021-05-21 09:36:58'),
('e82da861-95df-422f-846c-38f9dbc11044', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0001\",\"note\":\"Please check\"}', NULL, '2021-05-05 07:19:50', '2021-05-05 07:19:50'),
('e8732431-1944-4781-bf86-23e2142ea839', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0089\",\"note\":\"Please check\"}', NULL, '2021-05-11 03:41:57', '2021-05-11 03:41:57'),
('e879502b-6b01-460f-bec1-c2c82b26fafe', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0143\",\"note\":\"Please check\"}', NULL, '2021-05-20 07:00:38', '2021-05-20 07:00:38'),
('e89361a0-0964-4af7-8370-fe009e974a7d', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0084\",\"note\":\"Please check\"}', NULL, '2021-05-04 04:58:52', '2021-05-04 04:58:52'),
('e928fd17-4e5d-415a-a67f-b0257d8a3207', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"WO has been abandoned byadmin\",\"url\":\"womaint\",\"nbr\":\"WO-21-0058\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-16 03:43:53', '2021-05-20 06:56:25'),
('e930a202-ae47-4751-bc59-4879325395d4', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0115\",\"note\":\"Please check\"}', NULL, '2021-04-07 03:21:31', '2021-04-07 03:21:31'),
('e937a340-d242-4790-b884-696ab9ab1ebc', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0001\",\"note\":\"Please check\"}', NULL, '2021-05-05 07:19:50', '2021-05-05 07:19:50'),
('e94fc36a-49f9-40d4-90ed-ad43763c4abe', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0130\",\"note\":\"Please Check\"}', '2021-04-19 04:00:21', '2021-04-16 08:45:59', '2021-04-19 04:00:21'),
('e996ccc4-d600-4bc8-b645-ab6e87c72e5a', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0149\",\"note\":\"Please check\"}', '2021-05-21 09:36:58', '2021-05-21 09:09:25', '2021-05-21 09:36:58'),
('e9f67695-0021-4c3b-b87a-2664de3bb0df', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0002\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-05 09:26:56', '2021-05-18 02:29:40'),
('ea4993b0-17db-49ee-ad1d-a2c5ed9b111e', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0124\",\"note\":\"Please Check\"}', '2021-04-19 04:00:21', '2021-04-15 09:32:04', '2021-04-19 04:00:21'),
('ea5c7b79-bf7c-41b7-8512-f1867dcdc116', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0129\",\"note\":\"Please check\"}', '2021-04-16 07:28:34', '2021-04-16 07:28:21', '2021-04-16 07:28:34'),
('eac1132d-49a8-41db-a4a2-d86fca0da33b', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"WO has been abandoned by admin\",\"url\":\"womaint\",\"nbr\":\"WO-21-0058\",\"note\":\"Please check\"}', '2021-04-16 03:46:34', '2021-04-16 03:44:31', '2021-04-16 03:46:34'),
('ebae445e-6aec-412e-b870-c55bada26479', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0096\",\"note\":\"Please Check\"}', NULL, '2021-05-21 08:18:35', '2021-05-21 08:18:35'),
('ebbe5c3d-7328-4ad5-b86b-42cd5a7558b0', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is New WO for you\",\"url\":\"wojoblist\",\"nbr\":\"WO-21-0100\",\"note\":\"Please Check\"}', NULL, '2021-05-24 07:30:08', '2021-05-24 07:30:08'),
('ec04e39c-2e6c-4b68-8087-f28a84af1c5b', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0139\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-28 06:53:17', '2021-04-29 03:31:47'),
('ec4dad41-eb69-4853-b34a-240da760c094', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0001\",\"note\":\"Please check\"}', NULL, '2021-05-05 07:19:50', '2021-05-05 07:19:50'),
('ec9ac1df-ded7-4e7b-8903-5f8f39868168', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0059\",\"note\":\"Please check\"}', '2021-04-16 03:46:34', '2021-04-13 08:25:21', '2021-04-16 03:46:34'),
('eca31665-4397-41c1-8188-3fee974998af', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0150\",\"note\":\"Please check\"}', NULL, '2021-05-24 07:27:11', '2021-05-24 07:27:11'),
('ece55066-b3fd-4dc6-bd7a-995337b1f542', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0073\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-25 11:56:25', '2021-05-20 06:56:25'),
('edcc8c65-b70f-4c8b-a6fb-ee05cfb0fbee', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0085\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:52:44', '2021-05-05 06:52:44'),
('eed153eb-f48b-4b11-b340-debe605fa38c', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0114\",\"note\":\"Please check\"}', NULL, '2021-04-07 03:12:43', '2021-04-07 03:12:43'),
('ef42014b-c920-494c-b1db-8805d0750cab', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0148\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:22:34', '2021-05-21 08:22:34'),
('f07caebe-eb9c-4d9f-8ab5-3a4e15d00048', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0132\",\"note\":\"Please check\"}', '2021-04-16 10:03:17', '2021-04-16 10:03:06', '2021-04-16 10:03:17'),
('f149e5ef-d91a-433c-970f-0807e8a84dab', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0152\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:33:00', '2021-05-24 09:33:00'),
('f1544d8b-e1fd-4759-86d8-45e85f58a6be', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0038\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-01 07:51:38', '2021-05-20 06:56:25'),
('f15aade4-d94d-458f-ab7b-a8adc72657ee', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"WO has been abandoned byadmin\",\"url\":\"womaint\",\"nbr\":\"WO-21-0058\",\"note\":\"Please check\"}', '2021-04-16 07:28:40', '2021-04-16 03:43:53', '2021-04-16 07:28:40'),
('f17f783d-d271-4af8-bb82-702dbdcc5234', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0103\",\"note\":\"Please check\"}', '2021-05-28 08:42:48', '2021-05-27 05:06:38', '2021-05-28 08:42:48'),
('f1968a12-f560-417c-9fad-b33fc7f08fa7', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"Service Request Rejected\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0104\",\"note\":\"Please check\"}', '2021-04-05 05:41:51', '2021-04-05 03:41:32', '2021-04-05 05:41:51'),
('f201890c-30c4-49d7-9a11-f77e999a108c', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that created directly\",\"url\":\"wobrowse\",\"nbr\":\"WD-21-0005\",\"note\":\"Please check\"}', NULL, '2021-05-27 02:48:00', '2021-05-27 02:48:00'),
('f25890a3-4250-4247-a04e-a0e8428cd365', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0081\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-03 03:48:06', '2021-05-18 02:29:40'),
('f345f2d3-ec87-4597-a33a-40e4484cb3ae', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0118\",\"note\":\"Please check\"}', NULL, '2021-04-07 05:41:34', '2021-04-07 05:41:34'),
('f4b395b3-e886-4d86-b123-da5917d9f2bb', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0152\",\"note\":\"Please check\"}', NULL, '2021-05-24 09:33:00', '2021-05-24 09:33:00'),
('f4c1bad4-df89-4fbc-98f7-6b7ce4419222', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0101\",\"note\":\"Please check\"}', NULL, '2021-03-31 04:31:59', '2021-03-31 04:31:59'),
('f4e6b2f1-c085-4412-905d-9f2caf4fafc0', 'App\\Notifications\\eventNotification', 'App\\User', 61, '{\"data\":\"Service Request Assigned\",\"url\":\"srbrowse\",\"nbr\":\"SR-21-0151\",\"note\":\"Please Check\"}', NULL, '2021-05-24 08:16:56', '2021-05-24 08:16:56'),
('f648d21e-a179-4d38-8d7f-247eb5a71b57', 'App\\Notifications\\eventNotification', 'App\\User', 72, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0082\",\"note\":\"Please check\"}', NULL, '2021-05-03 05:41:48', '2021-05-03 05:41:48'),
('f6b19f65-0372-4472-9c28-c62d3393a107', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0138\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-25 13:23:16', '2021-05-20 06:56:25'),
('f6d8e08f-999a-4c3d-aa3e-0a5f670ee19a', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0119\",\"note\":\"Please check\"}', '2021-04-08 03:46:04', '2021-04-08 03:11:20', '2021-04-08 03:46:04'),
('f6ec5a9a-31da-40f4-b1a0-7424f043af3d', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0109\",\"note\":\"Please check\"}', NULL, '2021-04-05 07:48:24', '2021-04-05 07:48:24'),
('f735c80c-ea6e-4939-9561-67562d87bc45', 'App\\Notifications\\eventNotification', 'App\\User', 54, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0117\",\"note\":\"Please check\"}', NULL, '2021-04-07 03:22:23', '2021-04-07 03:22:23'),
('fa7a04ed-42b6-4954-b898-b4697644d1ff', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0146\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:09:50', '2021-05-21 08:09:50'),
('fa9e188d-c063-4e71-9c6f-04119d32e677', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0048\",\"note\":\"Please check\"}', NULL, '2021-04-05 08:36:30', '2021-04-05 08:36:30'),
('faa07c30-9455-4ae1-b179-087cece5cef6', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0142\",\"note\":\"Please check\"}', '2021-05-18 02:29:40', '2021-05-17 03:52:42', '2021-05-18 02:29:40'),
('fafa7035-0b5b-4286-be99-49bd6227603b', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0081\",\"note\":\"Please check\"}', NULL, '2021-05-03 03:48:06', '2021-05-03 03:48:06'),
('fb5a18a5-970f-4282-bd7a-35aa78ab28ae', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0145\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:05:34', '2021-05-21 08:05:34'),
('fbb1358c-6ed3-484d-9604-f40318890353', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0084\",\"note\":\"Please check\"}', NULL, '2021-05-04 04:58:52', '2021-05-04 04:58:52'),
('fc7c17c3-d6a6-4d8e-b912-b6b6e90fe5b7', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0106\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-05 03:13:37', '2021-05-20 06:56:25'),
('fcaa3921-8c70-46fa-9a6a-1da8fe7680ba', 'App\\Notifications\\eventNotification', 'App\\User', 73, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0076\",\"note\":\"Please check\"}', NULL, '2021-04-30 03:06:32', '2021-04-30 03:06:32'),
('fce4d9dc-531f-41f2-8332-74f41947d106', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0147\",\"note\":\"Please check\"}', NULL, '2021-05-21 08:20:45', '2021-05-21 08:20:45'),
('fd43ed20-7577-4c82-8bd7-811fdc84e016', 'App\\Notifications\\eventNotification', 'App\\User', 44, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0115\",\"note\":\"Please check\"}', '2021-04-07 03:25:52', '2021-04-07 03:21:31', '2021-04-07 03:25:52'),
('fd5e56ed-513d-4281-8299-077afe4c102c', 'App\\Notifications\\eventNotification', 'App\\User', 1, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WT-21-0018\",\"note\":\"Please check\"}', '2021-05-20 06:56:25', '2021-04-23 03:31:49', '2021-05-20 06:56:25'),
('fd60c650-99c5-4bfb-97d3-9fd59e9e523e', 'App\\Notifications\\eventNotification', 'App\\User', 53, '{\"data\":\"New Service Request\",\"url\":\"srapproval\",\"nbr\":\"SR-21-0132\",\"note\":\"Please check\"}', '2021-04-29 03:31:47', '2021-04-16 10:03:06', '2021-04-29 03:31:47'),
('fe1a7bc5-e255-488f-b801-d2f501f4f318', 'App\\Notifications\\eventNotification', 'App\\User', 67, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0069\",\"note\":\"Please check\"}', NULL, '2021-04-19 04:05:49', '2021-04-19 04:05:49'),
('ff6ec105-d28d-44c5-bb86-d5ccbe6c170e', 'App\\Notifications\\eventNotification', 'App\\User', 66, '{\"data\":\"There is new WO that you need to approve\",\"url\":\"wobrowse\",\"nbr\":\"WO-21-0085\",\"note\":\"Please check\"}', NULL, '2021-05-05 06:52:44', '2021-05-05 06:52:44');

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
-- Table structure for table `picklist_ctrl`
--

CREATE TABLE `picklist_ctrl` (
  `id` int(50) NOT NULL,
  `picklist_prefix` varchar(50) NOT NULL,
  `picklist_nbr` varchar(24) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rep_det`
--

CREATE TABLE `rep_det` (
  `ID` int(11) NOT NULL,
  `repdet_code` varchar(8) NOT NULL,
  `repdet_step` int(3) NOT NULL,
  `repdet_ins` varchar(30) DEFAULT NULL,
  `repdet_part` varchar(30) DEFAULT NULL,
  `repdet_qty` decimal(11,2) DEFAULT NULL,
  `repdet_std` varchar(30) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rep_det`
--

INSERT INTO `rep_det` (`ID`, `repdet_code`, `repdet_step`, `repdet_ins`, `repdet_part`, `repdet_qty`, `repdet_std`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'RC03', 1, 'IC04', 'M01', NULL, 'Terpasang Baik & Kuat', '2021-04-06', '2021-04-06', 'tata'),
(2, 'RC03', 2, 'IM02', 'MK02', NULL, 'Tidak ada Getaran', '2021-04-06', '2021-04-06', 'tata'),
(3, 'RC03', 3, 'IM03', 'MK03', NULL, 'Terpasang Baik & Kuat', '2021-04-06', '2021-04-06', 'tata'),
(4, 'RC03', 4, 'IC05', 'M02', NULL, 'koneksi Kencang & Bersih', '2021-04-06', '2021-04-06', 'tata'),
(5, 'RC03', 5, 'IE02', 'ME002', NULL, 'koneksi Kencang & Bersih', '2021-04-06', '2021-04-06', 'tata'),
(6, 'RC03', 6, 'IE03', 'ME03', '12345.00', 'Berfungsi Baik', '2021-04-06', '2021-04-12', 'ketik'),
(7, '02-04-02', 1, 'IC01', 'SLNG-PN', NULL, 'Terpasang Baik & Kuat rekat', '2021-04-07', '2021-04-07', 'tata'),
(8, '02-04-02', 2, 'IM04', 'ME05', NULL, 'Terpasang Baik & Kuat', '2021-04-07', '2021-04-07', 'tata'),
(12, 'RC03', 7, 'IC01', 'ME002', '1.00', 'tidak karatan', '2021-04-19', '2021-04-19', 'admin2');

-- --------------------------------------------------------

--
-- Table structure for table `rep_ins`
--

CREATE TABLE `rep_ins` (
  `ID` int(11) NOT NULL,
  `repins_code` varchar(8) NOT NULL,
  `repins_step` int(2) NOT NULL,
  `repins_ins` varchar(8) NOT NULL,
  `repins_tool` varchar(8) DEFAULT NULL,
  `repins_hour` decimal(4,2) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rep_ins`
--

INSERT INTO `rep_ins` (`ID`, `repins_code`, `repins_step`, `repins_ins`, `repins_tool`, `repins_hour`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'RC01', 1, 'IC01', 'TL02', '0.01', '2021-04-05', '2021-04-05', 'admin2'),
(2, 'RC01', 2, 'IC02', 'TL03', '0.10', '2021-04-05', '2021-04-05', 'admin2'),
(3, 'RC01', 3, 'IC03', 'TL04', '0.10', '2021-04-05', '2021-04-05', 'admin2'),
(4, 'VHC-001', 1, 'IC01', NULL, NULL, '2021-04-25', '2021-04-25', 'admin3'),
(5, 'RC03', 1, 'IC04', NULL, NULL, '2021-04-25', '2021-04-25', 'admin2'),
(6, 'RC03', 2, 'IM02', NULL, NULL, '2021-04-25', '2021-04-25', 'admin2'),
(9, 'Q01', 1, 'IC04', NULL, NULL, '2021-04-25', '2021-04-25', 'admin2'),
(10, 'Q01', 2, 'IM02', NULL, NULL, '2021-04-25', '2021-04-25', 'admin2'),
(11, 'Q01', 3, 'IM03', NULL, NULL, '2021-04-25', '2021-04-25', 'admin2'),
(12, 'Q01', 4, 'IM04', NULL, NULL, '2021-04-25', '2021-04-25', 'admin2'),
(13, 'Q02', 1, 'IC05', NULL, NULL, '2021-04-25', '2021-04-25', 'admin2'),
(14, 'Q02', 2, 'IE02', NULL, NULL, '2021-04-25', '2021-04-25', 'admin2'),
(15, 'Q02', 3, 'IE03', NULL, NULL, '2021-04-25', '2021-04-25', 'admin2'),
(16, 'Q02', 4, 'IE04', NULL, NULL, '2021-04-25', '2021-04-25', 'admin2');

-- --------------------------------------------------------

--
-- Table structure for table `rep_master`
--

CREATE TABLE `rep_master` (
  `ID` int(11) NOT NULL,
  `repm_code` varchar(20) NOT NULL,
  `repm_desc` varchar(50) DEFAULT NULL,
  `repm_ins` varchar(20) DEFAULT NULL,
  `repm_part` varchar(20) DEFAULT NULL,
  `repm_ref` varchar(50) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rep_master`
--

INSERT INTO `rep_master` (`ID`, `repm_code`, `repm_desc`, `repm_ins`, `repm_part`, `repm_ref`, `created_at`, `updated_at`, `edited_by`) VALUES
(6, 'Q01', 'Mekanik', 'test', 'teste', NULL, NULL, NULL, NULL),
(7, 'Q02', 'Elektrik', 'test2', 'teste2', NULL, NULL, NULL, NULL),
(14, 'CAR01', 'Mekanik', 'SRVCR01', NULL, 'Service mobil', '2021-05-06', '2021-05-20', 'rio'),
(15, 'EQ-003M', 'Mekanik', 'EQ-0003M', NULL, 'Mixer machine', '2021-05-07', '2021-05-21', 'rio'),
(17, 'EQ-003E', 'Elektrik', 'EQ-0003E', NULL, 'Mixer machine', '2021-05-07', '2021-05-21', 'rio'),
(18, 'CAR02', 'Elektrik', 'SRVCR02', NULL, 'Service mobil', '2021-05-11', '2021-05-20', 'rio');

-- --------------------------------------------------------

--
-- Table structure for table `rep_mstr`
--

CREATE TABLE `rep_mstr` (
  `ID` int(11) NOT NULL,
  `rep_code` varchar(8) NOT NULL,
  `rep_num` int(3) DEFAULT NULL,
  `rep_desc` varchar(50) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rep_mstr`
--

INSERT INTO `rep_mstr` (`ID`, `rep_code`, `rep_num`, `rep_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'RC01', 10, 'Memperbaiki AC Bocor', '2021-04-05', '2021-04-12', 'ketik'),
(4, 'RC03', 5, 'PM 1666 / EQ-0003', '2021-04-06', '2021-04-12', 'ketik'),
(5, '02-04-02', NULL, 'AAS Varian 240FSSF', '2021-04-07', '2021-04-07', 'tata'),
(6, 'VHC-001', 1, 'Ganti Oli', '2021-04-23', '2021-04-23', 'rio'),
(10, 'Q01', NULL, 'Mekanik', '2021-04-25', '2021-04-25', 'admin2'),
(11, 'Q02', NULL, 'Elektrik', '2021-04-25', '2021-04-25', 'admin2');

-- --------------------------------------------------------

--
-- Table structure for table `rep_part`
--

CREATE TABLE `rep_part` (
  `ID` int(11) NOT NULL,
  `reppart_code` varchar(10) NOT NULL,
  `reppart_desc` varchar(50) DEFAULT NULL,
  `reppart_step` int(2) DEFAULT NULL,
  `reppart_sp` varchar(8) DEFAULT NULL,
  `reppart_qty` int(3) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rep_part`
--

INSERT INTO `rep_part` (`ID`, `reppart_code`, `reppart_desc`, `reppart_step`, `reppart_sp`, `reppart_qty`, `created_at`, `updated_at`, `edited_by`) VALUES
(9, 'M01', 'Kabel', NULL, NULL, NULL, '2021-05-18', '2021-05-20', 'rio'),
(10, 'M02', 'Bearing', NULL, NULL, NULL, '2021-05-18', '2021-05-20', 'rio'),
(12, 'M03', 'Speed Controller', NULL, NULL, NULL, '2021-05-20', '2021-05-20', 'rio'),
(13, 'M04', 'Timer', NULL, NULL, NULL, '2021-05-20', '2021-05-20', 'rio'),
(14, 'M05', 'V-Belt', NULL, NULL, NULL, '2021-05-20', '2021-05-20', 'rio'),
(15, 'M06', 'Guard Mesin', NULL, NULL, NULL, '2021-05-20', '2021-05-20', 'rio'),
(16, 'M07', 'Motor', NULL, NULL, NULL, '2021-05-20', '2021-05-20', 'rio');

-- --------------------------------------------------------

--
-- Table structure for table `rep_partgroup`
--

CREATE TABLE `rep_partgroup` (
  `ID` int(11) NOT NULL,
  `reppg_code` varchar(20) NOT NULL,
  `reppg_desc` varchar(50) NOT NULL,
  `reppg_part` varchar(20) NOT NULL,
  `reppg_qty` decimal(11,2) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rep_partgroup`
--

INSERT INTO `rep_partgroup` (`ID`, `reppg_code`, `reppg_desc`, `reppg_part`, `reppg_qty`, `created_at`, `updated_at`, `edited_by`) VALUES
(17, 'teste', 'M02', 'M01', '20.00', '2021-05-03', '2021-05-03', 'admin3'),
(18, 'teste', 'M02', 'MK02', '20.00', '2021-05-03', '2021-05-03', 'admin3'),
(19, 'teste', 'M02', 'MK03', '21.00', '2021-05-03', '2021-05-03', 'admin3'),
(21, 'teste', 'M02', 'M02', '20.00', '2021-05-03', '2021-05-03', 'admin3'),
(22, 'teste', 'M02', 'ME002', '20.00', '2021-05-03', '2021-05-03', 'admin3'),
(23, 'teste', 'M02', 'ME03', '21.00', '2021-05-03', '2021-05-03', 'admin3'),
(29, 'BAUT', 'BAUT01', 'M01', '10.00', '2021-05-05', '2021-05-05', 'admin2'),
(30, 'BAUT', 'BAUT01', 'M02', '15.00', '2021-05-05', '2021-05-05', 'admin2'),
(31, 'BAUT', 'BAUT01', 'ME05', '20.00', '2021-05-05', '2021-05-05', 'admin2');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_code` varchar(24) NOT NULL,
  `role_desc` varchar(50) NOT NULL,
  `role_access` varchar(8) NOT NULL,
  `menu_access` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_code`, `role_desc`, `role_access`, `menu_access`, `created_at`, `updated_at`, `edited_by`) VALUES
('ADM', 'admin', 'Engineer', 'MT01MT02MT03MT04MT05MT06MT07MT08MT09MT10MT11MT12MT13MT14MT15MT16MT17MT18MT19MT20MT21MT22MT23MT24MT25MT26MT99P01P02P03P04P05SH01SR01SR02SR03SR04WO01WO02WO03WO04WO05WO06US01RT01RT02RT03RT04', '2020-11-02 06:45:45', '2020-11-03 07:40:49', ''),
('SPV', 'Spv. Engineer', 'Engineer', 'MT05MT06MT13MT08MT09MT10MT11MT12MT14MT15MT16MT19MT22WO05WO03WO01WO06SR02SR03US01', '2021-04-09 03:56:25', '2021-05-05 09:19:59', 'admin4'),
('TECH', 'Technician', 'Engineer', 'WO05WO02WO03WO04WO06', '2021-04-09 03:53:39', '2021-05-24 10:00:36', 'rio'),
('USER', 'Normal User', 'User', 'WO05SR01SR03SR04', '2021-04-09 04:01:59', '2021-04-09 04:01:59', 'rio');

-- --------------------------------------------------------

--
-- Table structure for table `running_mstr`
--

CREATE TABLE `running_mstr` (
  `id` int(250) NOT NULL,
  `sr_prefix` varchar(20) NOT NULL,
  `wo_prefix` varchar(20) NOT NULL,
  `wd_prefix` varchar(5) NOT NULL,
  `wt_prefix` varchar(25) DEFAULT NULL,
  `sr_nbr` varchar(20) NOT NULL,
  `wo_nbr` varchar(20) NOT NULL,
  `wd_nbr` varchar(8) NOT NULL,
  `wt_nbr` varchar(24) DEFAULT NULL,
  `year` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `running_mstr`
--

INSERT INTO `running_mstr` (`id`, `sr_prefix`, `wo_prefix`, `wd_prefix`, `wt_prefix`, `sr_nbr`, `wo_nbr`, `wd_nbr`, `wt_nbr`, `year`) VALUES
(1, 'SR', 'WO', 'WD', 'WT', '0154', '0104', '0006', '0020', '21');

-- --------------------------------------------------------

--
-- Table structure for table `service_req_mstr`
--

CREATE TABLE `service_req_mstr` (
  `id_sr` int(50) NOT NULL,
  `sr_number` varchar(24) DEFAULT NULL,
  `wo_number` varchar(24) DEFAULT NULL,
  `sr_assetcode` varchar(50) NOT NULL,
  `sr_failurecode1` varchar(50) DEFAULT NULL,
  `sr_failurecode2` varchar(50) DEFAULT NULL,
  `sr_failurecode3` varchar(50) DEFAULT NULL,
  `sr_note` varchar(255) DEFAULT NULL,
  `sr_status` int(11) NOT NULL,
  `sr_priority` varchar(24) DEFAULT NULL,
  `sr_dept` varchar(50) NOT NULL,
  `uncompleted_note` varchar(255) DEFAULT NULL,
  `rejectnote` varchar(255) DEFAULT NULL,
  `req_by` varchar(75) NOT NULL,
  `req_username` varchar(50) NOT NULL,
  `sr_created_at` datetime DEFAULT NULL,
  `sr_updated_at` datetime DEFAULT NULL,
  `sr_access` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_req_mstr`
--

INSERT INTO `service_req_mstr` (`id_sr`, `sr_number`, `wo_number`, `sr_assetcode`, `sr_failurecode1`, `sr_failurecode2`, `sr_failurecode3`, `sr_note`, `sr_status`, `sr_priority`, `sr_dept`, `uncompleted_note`, `rejectnote`, `req_by`, `req_username`, `sr_created_at`, `sr_updated_at`, `sr_access`) VALUES
(1, 'SR-21-0109', 'WO-21-0045', 'AC01', 'FAC01', NULL, NULL, 'Bocor', 5, 'medium', 'IT', NULL, NULL, 'admin2', 'admin2', '2021-04-05 14:48:19', '2021-04-05 14:54:39', 0),
(2, 'SR-21-0110', 'WO-21-0049', 'AC01', 'FAC01', NULL, NULL, NULL, 3, 'high', 'eng', NULL, NULL, 'Andrew Conan', '', '2021-04-05 16:26:55', '2021-04-05 16:30:53', 0),
(3, 'SR-21-0111', 'WO-21-0051', 'AC01', 'FAC01', NULL, NULL, NULL, 4, 'low', 'satu', NULL, NULL, 'admin baru', '', '2021-04-06 16:53:07', '2021-04-19 11:03:30', 0),
(4, 'SR-21-0112', 'WO-21-0052', 'AC02', 'FAC01', NULL, NULL, NULL, 5, 'high', 'IT', NULL, NULL, 'admin2', 'admin2', '2021-04-06 17:52:05', '2021-04-12 16:01:18', 0),
(5, 'SR-21-0113', 'WO-21-0053', 'AC01', 'FAC01', NULL, NULL, NULL, 5, 'medium', 'IT', NULL, NULL, 'admin2', 'admin2', '2021-04-07 10:10:29', '2021-04-12 09:16:27', 0),
(6, 'SR-21-0114', 'WO-21-0055', 'AC01', 'FAC01', NULL, NULL, NULL, 4, 'high', 'empat', NULL, NULL, 'admin baru', '', '2021-04-07 10:12:39', '2021-04-19 11:03:26', 0),
(7, 'SR-21-0115', NULL, 'AC01', 'FAC01', NULL, NULL, NULL, 1, 'high', 'wks', NULL, NULL, 'admin baru', '', '2021-04-07 10:21:26', '2021-04-07 10:21:26', 0),
(8, 'SR-21-0117', 'WO-21-0057', 'AC01', 'FAC01', NULL, NULL, NULL, 3, 'medium', 'wks', NULL, NULL, 'admin baru', 'ketik', '2021-04-07 10:22:19', '2021-04-08 17:25:54', 0),
(9, 'SR-21-0118', NULL, 'AC01', NULL, 'FAC01', NULL, NULL, 1, 'medium', 'satu', NULL, NULL, 'admin baru', '', '2021-04-07 12:41:30', '2021-04-07 12:41:30', 0),
(10, 'SR-21-0119', NULL, 'AC01', NULL, NULL, 'FAC01', NULL, 1, 'high', 'wks', NULL, NULL, 'admin2', '', '2021-04-08 10:11:14', '2021-04-08 10:11:14', 0),
(11, 'SR-21-0120', NULL, 'MCH01', 'FAC01', NULL, NULL, 'tes', 1, 'high', 'satu', NULL, NULL, 'rio', '', '2021-04-08 10:49:17', '2021-04-08 10:49:17', 0),
(12, 'SR-21-0121', NULL, 'MCH01', 'BD01', 'FAC01', NULL, NULL, 1, 'medium', 'wks', NULL, NULL, 'admin2', '', '2021-04-08 14:52:11', '2021-04-08 14:52:11', 0),
(13, 'SR-21-0122', NULL, 'MCH01', 'BD01', 'FAC01', NULL, NULL, 1, 'medium', 'empat', NULL, NULL, 'admin2', 'admin2', '2021-04-09 13:44:34', '2021-04-09 13:44:34', 0),
(14, 'SR-21-0123', 'WO-21-0058', 'AC01', 'FAC01', NULL, NULL, NULL, 3, 'high', 'eng', NULL, NULL, 'admin baru', 'ketik', '2021-04-09 14:52:55', '2021-04-16 10:58:09', 0),
(15, 'SR-21-0124', 'WO-21-0062', 'MCH02', 'FAC02', NULL, NULL, 'Ada suara berisik pada saat mesin dioperasikan', 5, 'high', 'ENG', NULL, NULL, 'admin2', 'admin2', '2021-04-15 09:37:09', '0000-00-00 00:00:00', 0),
(16, 'SR-21-0125', 'WO-21-0061', 'MCH01', 'FAC03', NULL, NULL, 'proses produksi menjadi terhambat', 5, 'high', 'HR', NULL, NULL, 'User 01', 'user01', '2021-04-15 14:34:36', '0000-00-00 00:00:00', 0),
(17, 'SR-21-0126', 'WO-21-0060', 'MCH02', 'FAC02', NULL, NULL, 'mengganggu produksi', 5, 'high', 'HR', NULL, NULL, 'User 01', 'user01', '2021-04-15 14:35:30', '0000-00-00 00:00:00', 0),
(18, 'SR-21-0127', 'WO-21-0079', 'AC02', 'FAC01', NULL, NULL, NULL, 2, 'medium', 'ENG', NULL, NULL, 'admin2', 'admin2', '2021-04-16 09:38:01', '2021-04-16 09:38:01', 0),
(19, 'SR-21-0128', 'WO-21-0063', 'AC01', 'FAC01', NULL, NULL, NULL, 5, 'high', 'ENG', NULL, NULL, 'admin2', 'admin2', '2021-04-16 09:50:59', '0000-00-00 00:00:00', 0),
(20, 'SR-21-0129', 'WO-21-0064', 'MCH01', 'FAC02', NULL, NULL, 'segera diperbaiki', 5, 'medium', 'MKT', NULL, NULL, 'User 02', 'user02', '2021-04-16 14:28:16', '0000-00-00 00:00:00', 0),
(21, 'SR-21-0130', 'WO-21-0065', 'MCH02', 'FAC03', NULL, NULL, 'Getaran menghasilkan bunyi yang menganggu.', 5, 'high', 'ENG', NULL, NULL, 'admin2', 'admin2', '2021-04-16 15:45:25', '0000-00-00 00:00:00', 0),
(22, 'SR-21-0131', 'WO-21-0066', 'MCH01', 'FAC02', NULL, NULL, 'tolong diperbaiki', 5, 'medium', 'MKT', NULL, NULL, 'User 02', 'user02', '2021-04-16 16:48:48', '0000-00-00 00:00:00', 0),
(23, 'SR-21-0132', 'WO-21-0067', 'MCH03', 'FAC02', NULL, NULL, 'tes', 5, 'high', 'MKT', NULL, NULL, 'User 02', 'user02', '2021-04-16 17:03:02', '0000-00-00 00:00:00', 0),
(24, 'SR-21-0133', 'WO-21-0078', 'MCH03', 'FAC01', NULL, NULL, 'ada tumpahan oli yang keluar', 2, 'medium', 'ENG', NULL, NULL, 'admin2', 'admin2', '2021-04-19 09:51:37', '2021-04-19 09:51:37', 0),
(25, 'SR-21-0134', 'WO-21-0068', 'AC02', 'FAC01', NULL, NULL, NULL, 5, 'medium', 'ENG', NULL, NULL, 'admin2', 'admin2', '2021-04-19 09:54:22', '0000-00-00 00:00:00', 0),
(26, 'SR-21-0135', 'WO-21-0071', 'AC01', 'FAC01', NULL, NULL, NULL, 5, 'high', 'ENG', NULL, NULL, 'admin2', 'admin2', '2021-04-19 13:51:08', '0000-00-00 00:00:00', 0),
(27, 'SR-21-0136', 'WO-21-0072', 'MCH01', 'FAC03', NULL, NULL, 'abc', 3, 'high', 'HR', NULL, NULL, 'User 01', 'user01', '2021-04-23 10:39:24', '2021-04-23 17:15:34', 0),
(28, 'SR-21-0137', 'WO-21-0090', 'AC01', 'FAC04', NULL, NULL, NULL, 2, 'low', 'ENG', NULL, NULL, 'rio', 'rio', '2021-04-23 15:14:20', '2021-04-23 15:14:20', 0),
(29, 'SR-21-0138', 'WO-21-0077', 'AC01', 'FAC01', NULL, NULL, NULL, 2, 'high', 'ENG', NULL, NULL, 'admin2', 'admin2', '2021-04-25 20:23:12', '2021-04-25 20:23:12', 0),
(30, 'SR-21-0139', 'WO-21-0075', 'AC01', NULL, 'FAC01', NULL, NULL, 5, 'low', 'ENG', NULL, NULL, 'rio', 'rio', '2021-04-28 13:53:11', '0000-00-00 00:00:00', 0),
(31, 'SR-21-0140', 'WO-21-0087', 'AC01', 'FAC01', NULL, NULL, NULL, 2, 'low', 'ENG', NULL, NULL, 'Andrew Conan', 'admin', '2021-05-05 13:52:08', '2021-05-05 13:52:08', 0),
(32, 'SR-21-0141', 'WO-21-0092', 'EQ-0003', 'FAC03', 'FAC04', NULL, NULL, 2, 'medium', 'ENG', NULL, NULL, 'admin2', 'admin2', '2021-05-17 10:09:12', '2021-05-17 10:09:12', 1),
(33, 'SR-21-0142', 'WO-21-0091', 'VHC01', 'FEQ-0003', NULL, NULL, 'tes SR', 3, 'high', 'ENG', NULL, NULL, 'Andrew Conan', 'admin', '2021-05-17 10:52:38', '2021-05-17 10:55:40', 0),
(34, 'SR-21-0143', 'WO-21-0093', 'day', 'FAC04', NULL, NULL, NULL, 2, 'medium', 'ENG', NULL, NULL, 'Andrew Conan', 'admin', '2021-05-20 14:00:34', '2021-05-20 14:00:34', 0),
(35, 'SR-21-0144', 'WO-21-0094', 'EQ-0003', 'FAC01', 'FAC03', NULL, 'tolong segera diperbaiki', 2, 'high', 'HR', NULL, NULL, 'User 01', 'user01', '2021-05-21 14:43:31', '2021-05-21 14:43:31', 0),
(36, 'SR-21-0145', 'WO-21-0095', 'EQ-0003', 'FAC01', 'FAC03', NULL, 'segera diperbaiki', 2, 'high', 'HR', NULL, NULL, 'User 01', 'user01', '2021-05-21 15:05:30', '2021-05-21 15:05:30', 0),
(37, 'SR-21-0146', 'WO-21-0096', 'AC01', 'FAC02', NULL, NULL, NULL, 2, 'high', 'ENG', NULL, NULL, 'admin2', 'admin2', '2021-05-21 15:09:46', '2021-05-21 15:09:46', 0),
(38, 'SR-21-0147', 'WO-21-0097', 'VHC01', 'FAC02', NULL, NULL, NULL, 2, 'medium', 'ENG', NULL, NULL, 'admin2', 'admin2', '2021-05-21 15:20:41', '2021-05-21 15:20:41', 0),
(39, 'SR-21-0148', 'WO-21-0098', 'EQ-0003', 'FAC02', NULL, NULL, NULL, 2, 'high', 'ENG', NULL, NULL, 'admin2', 'admin2', '2021-05-21 15:22:30', '2021-05-21 15:22:30', 0),
(40, 'SR-21-0149', 'WO-21-0099', 'EQ-0003', 'FAC01', 'FAC03', NULL, 'tolong segera diperbaiki', 3, 'high', 'HR', NULL, NULL, 'User 01', 'user01', '2021-05-21 16:09:21', '2021-05-21 16:56:13', 0),
(41, 'SR-21-0150', 'WO-21-0100', 'EQ-0003', 'FAC01', 'FAC03', NULL, 'segera diperbaiki', 3, 'high', 'ENG', NULL, NULL, 'rio', 'rio', '2021-05-24 14:27:05', '2021-05-24 14:33:45', 0),
(42, 'SR-21-0151', 'WO-21-0101', 'EQ-0003', 'FAC02', 'FAC03', 'FAC04', 'butuh perbaikan', 4, 'high', 'MKT', NULL, NULL, 'User 02', 'user02', '2021-05-24 15:14:47', '0000-00-00 00:00:00', 0),
(43, 'SR-21-0152', NULL, 'EQ-0003', 'FAC01', 'FAC02', NULL, 'tes reject', 4, 'high', 'HR', NULL, 'keterangan tidak jelas', 'User 01', 'user01', '2021-05-24 16:32:55', '2021-05-24 16:32:55', 0),
(44, 'SR-21-0153', 'WO-21-0102', 'EQ-0003', 'FAC02', NULL, NULL, 'test abandon', 2, 'medium', 'HR', NULL, NULL, 'User 01', 'user01', '2021-05-24 16:34:42', '2021-05-24 16:40:20', 0),
(45, 'SR-21-0154', NULL, 'AC01', 'FAC01', NULL, NULL, '12', 1, 'medium', 'ENG', NULL, NULL, 'admin4', 'admin4', '2021-05-27 13:32:00', '2021-05-27 13:32:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `site_mstrs`
--

CREATE TABLE `site_mstrs` (
  `site_code` varchar(10) NOT NULL,
  `site_desc` varchar(50) NOT NULL,
  `site_flag` varchar(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL,
  `salesman` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_mstrs`
--

INSERT INTO `site_mstrs` (`site_code`, `site_desc`, `site_flag`, `created_at`, `updated_at`, `edited_by`, `salesman`) VALUES
('ACT', 'Actavis Indonesia', NULL, '2021-04-05 07:12:11', '2021-04-05 07:12:11', 'admin2', '');

-- --------------------------------------------------------

--
-- Table structure for table `skill_mstr`
--

CREATE TABLE `skill_mstr` (
  `ID` int(11) NOT NULL,
  `skill_code` varchar(10) NOT NULL,
  `skill_desc` varchar(50) NOT NULL,
  `skill_certification` varchar(50) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `skill_mstr`
--

INSERT INTO `skill_mstr` (`ID`, `skill_code`, `skill_desc`, `skill_certification`, `created_at`, `updated_at`, `edited_by`) VALUES
(0, 'SK02', 'Welding', NULL, '2021-04-09', '2021-04-09', 'rio'),
(0, 'SK03', 'Electrical', NULL, '2021-04-09', '2021-04-09', 'rio'),
(0, 'SK04', 'Plumbing', NULL, '2021-04-09', '2021-04-09', 'rio'),
(0, 'SK05', 'Automotive', NULL, '2021-04-09', '2021-04-09', 'rio'),
(0, 'SK06', 'Production Machine', NULL, '2021-04-09', '2021-04-09', 'rio');

-- --------------------------------------------------------

--
-- Table structure for table `sp_group`
--

CREATE TABLE `sp_group` (
  `ID` int(11) NOT NULL,
  `spg_code` varchar(8) NOT NULL,
  `spg_desc` varchar(50) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sp_group`
--

INSERT INTO `sp_group` (`ID`, `spg_code`, `spg_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'SPG01', 'Spare Part Pergantian', '2021-04-05', '2021-04-05', 'admin2'),
(2, 'SPG02', 'Spare Part Perpanjangan', '2021-04-05', '2021-04-05', 'admin2'),
(3, 'SPG03', '1666 / EQ-0003', '2021-04-06', '2021-04-06', 'admin'),
(4, 'SPG04', 'AAS Varian 240FS', '2021-04-07', '2021-04-07', 'tata');

-- --------------------------------------------------------

--
-- Table structure for table `sp_mstr`
--

CREATE TABLE `sp_mstr` (
  `ID` int(11) NOT NULL,
  `spm_code` varchar(8) NOT NULL,
  `spm_desc` varchar(50) NOT NULL,
  `spm_type` varchar(8) DEFAULT NULL,
  `spm_group` varchar(8) DEFAULT NULL,
  `spm_price` decimal(13,2) DEFAULT NULL,
  `spm_safety` int(11) DEFAULT NULL,
  `spm_supp` varchar(8) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sp_mstr`
--

INSERT INTO `sp_mstr` (`ID`, `spm_code`, `spm_desc`, `spm_type`, `spm_group`, `spm_price`, `spm_safety`, `spm_supp`, `created_at`, `updated_at`, `edited_by`) VALUES
(3, 'M01', 'Ring packing', 'SPT01', 'SPG01', '20000.00', 1, 'SP001', '2021-04-06', '2021-05-20', 'rio'),
(5, 'MK02', 'Valve', 'SPT04', 'SPG03', '12312432.00', 1, 'SP001', '2021-04-06', '2021-05-20', 'rio'),
(6, 'MK03', 'Magnetiv actuator', 'SPT04', 'SPG03', '232423.00', 1, 'SP001', '2021-04-06', '2021-05-20', 'rio'),
(8, 'ME03', 'Rotating assembly', 'SPT05', 'SPG03', '1313.00', 1, 'SP001', '2021-04-06', '2021-05-20', 'rio'),
(10, 'ME05', 'Switch', 'SPT04', 'SPG04', '123.00', 4, 'SP001', '2021-04-07', '2021-05-20', 'rio');

-- --------------------------------------------------------

--
-- Table structure for table `sp_type`
--

CREATE TABLE `sp_type` (
  `ID` int(11) NOT NULL,
  `spt_code` varchar(8) NOT NULL,
  `spt_desc` varchar(50) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sp_type`
--

INSERT INTO `sp_type` (`ID`, `spt_code`, `spt_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'SPT01', 'Mesin', '2021-04-05', '2021-04-05', 'admin2'),
(2, 'SPT02', 'Kendaraan', '2021-04-05', '2021-04-05', 'admin2'),
(3, 'SPT03', 'Office', '2021-04-05', '2021-04-05', 'admin2'),
(5, 'SPT04', 'Mekanik', '2021-04-06', '2021-04-06', 'admin'),
(6, 'SPT05', 'Elektrik', '2021-04-06', '2021-04-06', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `supp_mstr`
--

CREATE TABLE `supp_mstr` (
  `ID` int(11) NOT NULL,
  `supp_code` varchar(10) NOT NULL,
  `supp_desc` varchar(50) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supp_mstr`
--

INSERT INTO `supp_mstr` (`ID`, `supp_code`, `supp_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'SP001', 'PT IMI', '2021-04-05', '2021-05-21', 'admin3');

-- --------------------------------------------------------

--
-- Table structure for table `tool_mstr`
--

CREATE TABLE `tool_mstr` (
  `ID` int(11) NOT NULL,
  `tool_code` varchar(8) NOT NULL,
  `tool_desc` varchar(50) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tool_mstr`
--

INSERT INTO `tool_mstr` (`ID`, `tool_code`, `tool_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'TL01', 'Tang', '2021-04-05', '2021-04-05', 'admin2'),
(2, 'TL02', 'Obeng', '2021-04-05', '2021-04-05', 'admin2'),
(3, 'TL03', 'Kunci Inggris', '2021-04-05', '2021-04-05', 'admin2'),
(4, 'TL04', 'Termometer Ruangan', '2021-04-05', '2021-04-05', 'admin2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `name` varchar(24) CHARACTER SET utf8mb4 NOT NULL,
  `email_user` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `role_user` varchar(24) CHARACTER SET utf8mb4 DEFAULT NULL,
  `dept_user` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(8) CHARACTER SET utf8mb4 NOT NULL,
  `access` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site` varchar(24) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `session_id` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `edited_by` varchar(8) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email_user`, `role_user`, `dept_user`, `active`, `access`, `site`, `password`, `session_id`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'admin', 'Andrew Conan', 'abc@admin.com', 'ADM', 'ENG', 'Yes', NULL, 'R0012', '$2y$10$m1Xs5LivUwdkf5imeByKv.JuGyJRyiJ6uR0OXjqESclZRxmEKaZcC', 'mZ8MExLH9vH1nqMTJvidfCPJiMxsBOOu48Riu13l', '2020-08-12 20:39:30', '2021-06-25 07:44:12', 'rio'),
(50, 'admin2', 'admin2', 'admin2@gmail.com', 'ADM', 'ENG', 'Yes', 'Engineer', '', '$2y$10$ZB4J0s3LtA36f6m2LbgUN.bzaBpX6riSkTdAWulLyM9IWYHThUmKu', '20sz1dGjcEs02Xin6itsXVpamc5cq8RNxDvE4ThE', '2021-04-05 04:33:21', '2021-06-14 06:15:56', 'rio'),
(53, 'rio', 'rio', 'rio@ptimi.co.id', 'ADM', 'ENG', 'Yes', 'Engineer', '', '$2y$10$6QUwoA8/lDI4Q.9lnrVIdeJVkycfNuardbyWWx0Z12Lgzxk/4UCQe', 'tvPYqBSd6iUpjSro1aRH3RO1zMlE2WjgLjbQ2Rwh', '2021-04-06 03:41:23', '2021-06-15 03:06:38', 'admin'),
(60, 'user01', 'User 01', 'user01@gmail.com', 'USER', 'HR', 'Yes', 'User', '', '$2y$10$N5CET.VsQo1xoaTidn6ZouCWAY9QucImerQB7B9mXUpWaA6qrqTmq', '7V1bYtYAQUt1Qaf35xyodz006ymQXstS1EaKXQb0', '2021-04-09 04:17:59', '2021-05-24 09:34:06', 'ketik'),
(61, 'user02', 'User 02', 'user02@gmail.com', 'USER', 'MKT', 'Yes', NULL, '', '$2y$10$d.sSp5oC.CczN/5KKuzRaOxCIzOwU4DoE5i3RDB6qj7l9cpaevWaa', 'l8f0fHTerrxUQZSRNnlVvkaHJjYjXJAZmgk1RX7k', '2021-04-09 04:19:35', '2021-05-24 08:13:44', 'rio'),
(62, 'user03', 'User 03', 'user03@gmail.com', 'USER', 'WHS', 'Yes', NULL, '', '$2y$10$S8bJGDwznD63vbT0KlWjBu4A20uNjGzAVtE7k.6H4W9cQHasKtnaK', 'iStrSf1ia76vMDBBlGdQKryOIp5LHYJWe3H4LSkc', '2021-04-09 04:21:25', '2021-04-19 03:55:32', 'rio'),
(63, 'eng01', 'Engineer 01', 'eng01@gmail.com', 'TECH', 'ENG', 'Yes', 'Engineer', '', '$2y$10$mY4TZJGWG0tUebotxoBEueAz8T9gS7HSOGxKCTKoLXITH.HvPUlea', '4dIqe18wMgdy97tVozBMdHTE4Jtych5udpGReTrY', '2021-04-09 07:20:32', '2021-05-27 04:51:39', 'admin'),
(64, 'eng02', 'Engineer 02', 'eng02@gmail.com', 'TECH', 'ENG', 'Yes', 'Engineer', '', '$2y$10$jdIovcH1JpHkFWAvUgPcc.r0vVwQbgLabo6VpGrCBlCjD5atI4BYS', '1piUBvUGmZxJKQYujFiJxShUM9flqDeaeOejjfd7', '2021-04-09 07:21:13', '2021-05-24 09:37:13', 'admin'),
(65, 'eng03', 'Engineer 03', 'eng03@gmail.com', 'TECH', 'ENG', 'No', NULL, '', '$2y$10$Fi8LCVUQL.4TsS/FXssfa.a3aJhnctwHwPepEX4z2lXX4iV.Biu1G', NULL, '2021-04-09 07:21:56', '2021-04-15 07:23:02', 'ketik'),
(66, 'spv01', 'Spv 01', 'spv01@gmail.com', 'SPV', 'ENG', 'Yes', NULL, '', '$2y$10$P0zD.V7M63T7HQhCWcDuU.EzTynHW8uMGgZVFRAfzqCBMbvLxWVQq', 'mSDsyoLLkv6okEDaXH1UpaJtZzaXUHn3Lz63h98y', '2021-04-09 07:24:20', '2021-05-24 09:35:02', 'rio'),
(67, 'spv02', 'Spv 02', 'spv02@gmail.com', 'SPV', 'ENG', 'Yes', NULL, '', '$2y$10$jAAX7xYHPLTQomqIxg6pY.oQNXIAE/9P./srFJDkHDoohTo7roRZC', 'ebauqiwl1DnTMjHiyidkmwEbmt8p8EN2jJz27DxJ', '2021-04-09 07:55:07', '2021-05-24 08:16:13', 'rio'),
(71, 'act', 'andrew', 'andrew@ptimi.co.id', 'USER', 'WHS', 'No', 'User', '', '$2y$10$UpYmyBSAGsk6uHor2pPDVu6yF5DImFWNKcd29XPhBgvBWuV7MwcXu', 'L6VI2rKxLXmGCP59n84pOBFt0BKrZ31UUBnOdTYB', '2021-04-14 09:35:05', '2021-05-31 09:29:38', 'admin3'),
(72, 'admin3', 'admin3', 'admin3@email', 'ADM', 'ENG', 'Yes', 'Engineer', '', '$2y$10$yrYu/A/ORCBVGU8lxBBrrOqveODKySr0YG8CIPtU7eXm3AMh1UfTS', 'FJKv2j2TQDJFtEsrOfU7FtnBCIQCK2tfUlghmxUG', '2021-04-23 07:37:18', '2021-06-02 03:16:44', 'admin3'),
(73, 'admin4', 'admin4', 'admin4@gmail.com', 'ADM', 'ENG', 'Yes', 'Engineer', '', '$2y$10$P4jjNd40wl.uA/2wcednFebsn..cnk4LgRrA2E9lsWOE7STo.v5KK', '5xctdPBTyTITF8uZ2MU2cBVW7gS2ayDfQ0VVe7JR', '2021-04-23 07:54:43', '2021-06-02 04:20:19', 'admin3'),
(75, 'gamara', 'Bintang', 'bintang@ptimi.co.id', 'ADM', 'ENG', 'Yes', 'Engineer', '', '$2y$10$MfCvsno65TeaBtootK9vveJtSDpXJ5rSqNG2O8BsKt6m4PwaFUNdm', 'whKGG1PZd3hVy1vPOTDZ7Z6MbebEP5BjjN93BS1z', '2021-05-05 06:49:26', '2021-05-05 08:43:40', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `wo_detail`
--

CREATE TABLE `wo_detail` (
  `id` int(11) NOT NULL,
  `detail_wo_nbr` varchar(50) NOT NULL,
  `detail_spare_part` varchar(50) DEFAULT NULL,
  `detail_repair_code` varchar(50) NOT NULL,
  `detail_qty` int(11) DEFAULT NULL,
  `detail_serial_lot` varchar(50) DEFAULT NULL,
  `detail_location` varchar(100) DEFAULT NULL,
  `detail_created_at` timestamp NULL DEFAULT NULL,
  `detail_updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wo_detail`
--

INSERT INTO `wo_detail` (`id`, `detail_wo_nbr`, `detail_spare_part`, `detail_repair_code`, `detail_qty`, `detail_serial_lot`, `detail_location`, `detail_created_at`, `detail_updated_at`) VALUES
(1, 'WO-21-0045', 'SLNG-PN', 'RC01', 1, NULL, NULL, '2021-04-05 08:03:19', '2021-04-05 08:03:19'),
(2, 'WO-21-0047', 'SLNG-PN', 'RC01', 5, NULL, NULL, '2021-04-05 08:09:26', '2021-04-05 08:09:26'),
(3, 'WO-21-0057', 'MK03', 'RC03', 1, NULL, NULL, '2021-04-08 10:28:52', '2021-04-08 10:28:52'),
(4, 'WO-21-0057', NULL, 'RC03', 2, NULL, NULL, '2021-04-08 10:28:52', '2021-04-08 10:28:52');

-- --------------------------------------------------------

--
-- Table structure for table `wo_manual_detail`
--

CREATE TABLE `wo_manual_detail` (
  `id` int(11) NOT NULL,
  `wo_manual_wo_nbr` varchar(50) NOT NULL,
  `wo_manual_number` int(11) NOT NULL,
  `wo_manual_part` varchar(100) NOT NULL,
  `wo_manual_desc` varchar(255) NOT NULL,
  `wo_manual_flag` varchar(5) NOT NULL,
  `wo_manual_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wo_manual_detail`
--

INSERT INTO `wo_manual_detail` (`id`, `wo_manual_wo_nbr`, `wo_manual_number`, `wo_manual_part`, `wo_manual_desc`, `wo_manual_flag`, `wo_manual_created_at`) VALUES
(1, 'WD-21-0005', 1, 'test1', 'rr', 'y0', '2021-05-28 10:51:57'),
(2, 'WD-21-0005', 2, 'test2', 'rr', 'n1', '2021-05-28 10:51:57'),
(3, 'WD-21-0005', 3, 'test3', 'ww', 'y2', '2021-05-28 10:51:57'),
(4, 'WD-21-0005', 4, 'test4', 'ee', 'n3', '2021-05-28 10:51:57'),
(5, 'WD-21-0005', 1, 'test1', 'rr', 'y0', '2021-05-28 10:51:57'),
(6, 'WD-21-0005', 2, 'test2', 'rr', 'n1', '2021-05-28 10:51:57'),
(7, 'WD-21-0005', 3, 'test3', 'ww', 'y2', '2021-05-28 10:51:57'),
(8, 'WD-21-0005', 4, 'test4', 'ee', 'n3', '2021-05-28 10:51:57');

-- --------------------------------------------------------

--
-- Table structure for table `wo_mstr`
--

CREATE TABLE `wo_mstr` (
  `id` int(11) NOT NULL,
  `wo_nbr` varchar(50) NOT NULL,
  `wo_sr_nbr` varchar(50) DEFAULT NULL,
  `wo_dept` varchar(20) NOT NULL,
  `wo_priority` varchar(20) DEFAULT NULL,
  `wo_engineer1` varchar(100) DEFAULT NULL,
  `wo_engineer2` varchar(100) DEFAULT NULL,
  `wo_engineer3` varchar(100) DEFAULT NULL,
  `wo_engineer4` varchar(100) DEFAULT NULL,
  `wo_engineer5` varchar(100) DEFAULT NULL,
  `wo_asset` varchar(100) NOT NULL,
  `wo_failure_code1` varchar(100) DEFAULT NULL,
  `wo_failure_code2` varchar(100) DEFAULT NULL,
  `wo_failure_code3` varchar(100) DEFAULT NULL,
  `wo_repair_hour` varchar(50) NOT NULL,
  `wo_repair_code1` varchar(10) DEFAULT NULL,
  `wo_repair_code2` varchar(10) DEFAULT NULL,
  `wo_repair_code3` varchar(10) DEFAULT NULL,
  `wo_repair_group` varchar(50) DEFAULT NULL,
  `wo_repair_type` varchar(255) DEFAULT NULL,
  `wo_note` text DEFAULT NULL,
  `wo_approval_note` text DEFAULT NULL,
  `wo_status` varchar(20) NOT NULL,
  `wo_schedule` date NOT NULL,
  `wo_duedate` date NOT NULL,
  `wo_start_date` date DEFAULT NULL,
  `wo_start_time` time DEFAULT NULL,
  `wo_finish_date` date DEFAULT NULL,
  `wo_finish_time` time DEFAULT NULL,
  `wo_system_date` date DEFAULT NULL,
  `wo_system_time` time DEFAULT NULL,
  `wo_creator` varchar(150) DEFAULT NULL,
  `wo_reviewer` varchar(100) DEFAULT NULL,
  `wo_approver` varchar(100) DEFAULT NULL,
  `wo_approver_appdate` date DEFAULT NULL,
  `wo_reviewer_appdate` date DEFAULT NULL,
  `wo_reject_reason` varchar(50) DEFAULT NULL,
  `wo_created_at` datetime NOT NULL,
  `wo_updated_at` datetime NOT NULL,
  `wo_access` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wo_mstr`
--

INSERT INTO `wo_mstr` (`id`, `wo_nbr`, `wo_sr_nbr`, `wo_dept`, `wo_priority`, `wo_engineer1`, `wo_engineer2`, `wo_engineer3`, `wo_engineer4`, `wo_engineer5`, `wo_asset`, `wo_failure_code1`, `wo_failure_code2`, `wo_failure_code3`, `wo_repair_hour`, `wo_repair_code1`, `wo_repair_code2`, `wo_repair_code3`, `wo_repair_group`, `wo_repair_type`, `wo_note`, `wo_approval_note`, `wo_status`, `wo_schedule`, `wo_duedate`, `wo_start_date`, `wo_start_time`, `wo_finish_date`, `wo_finish_time`, `wo_system_date`, `wo_system_time`, `wo_creator`, `wo_reviewer`, `wo_approver`, `wo_approver_appdate`, `wo_reviewer_appdate`, `wo_reject_reason`, `wo_created_at`, `wo_updated_at`, `wo_access`) VALUES
(1, 'WO-21-0045', 'SR-21-0109', 'dept', 'medium', 'ketik', NULL, NULL, NULL, NULL, 'AC01', 'FAC01', NULL, NULL, '1', 'RC01', NULL, NULL, NULL, '', NULL, '', 'closed', '2021-04-05', '2021-04-05', '2021-04-05', '14:54:39', '2021-04-05', '10:30:00', '2021-04-05', '15:03:19', NULL, NULL, NULL, NULL, NULL, 'test', '2021-04-05 14:50:53', '2021-04-05 15:03:19', 0),
(2, 'WO-21-0047', NULL, 'dept', 'medium', 'ketik', NULL, NULL, NULL, NULL, 'AC01', 'FAC01', '', NULL, '1', 'RC01', NULL, NULL, NULL, '', NULL, '', 'finish', '2021-04-05', '2021-04-05', '2021-04-05', '15:08:50', '2021-04-05', '14:00:00', '2021-04-05', '15:09:26', 'ketik', NULL, NULL, NULL, NULL, NULL, '2021-04-05 15:07:43', '2021-04-05 15:09:26', 0),
(3, 'WO-21-0048', NULL, 'dept', 'medium', 'ketik', NULL, NULL, NULL, NULL, 'AC02', 'FAC01', '', NULL, '', NULL, NULL, NULL, NULL, '', NULL, '', 'plan', '2021-04-05', '2021-04-05', '2021-04-05', '15:37:31', NULL, NULL, NULL, NULL, 'ketik', NULL, NULL, NULL, NULL, NULL, '2021-04-05 15:36:26', '2021-04-05 15:36:26', 0),
(4, 'WO-21-0048', 'SR-21-0110', 'eng', 'high', 'ENG3', 'ENG4', NULL, NULL, NULL, 'AC01', 'FAC01', NULL, NULL, '', NULL, NULL, NULL, NULL, '', NULL, '', 'plan', '2021-04-05', '2021-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-05 16:27:40', '2021-04-05 16:27:40', 0),
(5, 'WO-21-0049', 'SR-21-0110', 'eng', 'high', 'ketik', NULL, NULL, NULL, NULL, 'AC01', 'FAC01', NULL, NULL, '', NULL, NULL, NULL, NULL, '', NULL, '', 'plan', '2021-04-05', '2021-04-30', '2021-04-05', '16:30:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-05 16:28:14', '2021-04-05 16:28:14', 0),
(15, 'WO-21-0051', 'SR-21-0111', 'satu', 'low', 'admin', 'appr', 'ketik', 'tata', NULL, 'AC01', 'FAC01', NULL, NULL, '', 'RC01', 'RC03', NULL, NULL, '', NULL, '', 'closed', '2021-04-06', '2021-04-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-06 17:49:30', '2021-04-19 11:03:30', 0),
(16, 'WO-21-0052', 'SR-21-0112', 'empat', 'high', 'admin', 'appr', 'ketik', 'tata', NULL, 'AC02', 'FAC01', NULL, NULL, '1', 'RC01', 'RC03', NULL, NULL, '', NULL, '', 'closed', '2021-04-06', '2021-05-08', '2021-04-12', '16:01:18', '2021-12-31', '01:01:00', '2021-04-12', '18:25:53', NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-06 17:52:28', '2021-04-12 18:25:53', 0),
(17, 'WO-21-0053', 'SR-21-0113', 'satu', 'medium', 'admin', 'appr', 'ketik', 'tata', NULL, 'AC01', 'FAC01', NULL, NULL, '2', 'RC01', 'RC03', NULL, NULL, '', NULL, '', 'closed', '2021-04-07', '2021-04-07', '2021-04-12', '09:16:27', '2021-02-01', '00:01:00', '2021-04-12', '15:08:23', NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-07 10:11:16', '2021-04-12 15:08:23', 0),
(19, 'WO-21-0055', 'SR-21-0114', 'empat', 'high', 'appr', 'ketik', NULL, NULL, NULL, 'AC01', 'FAC01', NULL, NULL, '', 'RC01', NULL, NULL, NULL, '', NULL, '', 'closed', '2021-04-07', '2021-04-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-07 10:13:02', '2021-04-19 11:03:26', 0),
(20, 'WT-21-0017', NULL, '', 'high', NULL, NULL, NULL, NULL, NULL, 'AC02', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', NULL, '', 'plan', '2021-04-07', '2021-04-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-07 10:18:15', '2021-04-07 10:18:15', 0),
(21, 'WO-21-0057', 'SR-21-0117', 'wks', 'medium', 'appr', 'ketik', NULL, NULL, NULL, 'AC01', 'FAC01', NULL, NULL, '3', 'RC03', NULL, NULL, NULL, '', NULL, '', 'finish', '2021-04-07', '2021-04-07', '2021-04-08', '17:25:54', '2021-04-08', '16:00:00', '2021-04-08', '17:28:52', NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-07 10:22:45', '2021-04-08 17:28:52', 0),
(22, 'WO-21-0058', 'SR-21-0123', 'HR', 'high', 'ketik', NULL, NULL, 'admin', NULL, 'AC01', 'FAC01', NULL, NULL, '', 'RC03', NULL, NULL, NULL, '', NULL, '', 'started', '2021-04-30', '2021-05-09', '2021-04-16', '10:58:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-09 14:53:37', '2021-04-09 14:53:37', 0),
(23, 'WO-21-0059', NULL, 'IT', 'low', 'ketik', NULL, NULL, NULL, NULL, 'MCH01', 'FAC02', '', NULL, '', NULL, NULL, NULL, NULL, '', NULL, '', 'plan', '2021-05-09', '2021-05-09', NULL, NULL, NULL, NULL, NULL, NULL, 'ketik', NULL, NULL, NULL, NULL, NULL, '2021-04-13 15:25:17', '2021-04-13 15:25:17', 0),
(24, 'WO-21-0060', 'SR-21-0126', 'Human Resources', 'high', 'eng01', NULL, NULL, NULL, NULL, 'MCH02', 'FAC02 -- Mesin berbunyi cit cit', '-', '-', '5', '02-04-02', NULL, NULL, NULL, '', 'ok', '', 'closed', '2021-04-20', '2021-04-30', '2021-04-16', '09:46:39', '2021-04-17', '13:00:00', '2021-04-16', '13:46:29', NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-15 15:38:20', '2021-04-16 13:46:29', 0),
(25, 'WO-21-0061', 'SR-21-0125', 'HR', 'high', 'eng01', 'spv01', 'spv02', 'rio', NULL, 'MCH01', '-', NULL, NULL, '5', 'RC01', 'RC03', NULL, NULL, '', 'sip', '', 'closed', '2021-04-15', '2021-04-15', '2021-04-16', '11:07:08', '2021-04-17', '22:00:00', '2021-04-16', '13:55:32', NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-15 16:10:18', '2021-04-16 13:55:32', 0),
(26, 'WO-21-0062', 'SR-21-0124', 'ENG', 'high', 'eng01', 'eng02', 'spv02', 'rio', NULL, 'MCH02', 'FAC02', '-', '-', '9', 'RC03', NULL, NULL, NULL, '', 'i', '', 'closed', '2021-04-15', '2021-04-15', '2021-04-16', '13:57:41', '2021-04-24', '17:00:00', '2021-04-16', '13:58:41', NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-15 16:31:14', '2021-04-16 13:58:41', 0),
(27, 'WO-21-0063', 'SR-21-0128', 'ENG', 'high', 'eng01', 'eng02', 'spv01', 'spv02', 'rio', 'AC01', 'FAC01', NULL, NULL, '5', 'RC01', 'RC03', NULL, NULL, '', 'okkk', '', 'closed', '2021-04-16', '2021-04-16', '2021-04-16', '13:58:01', '2021-04-22', '10:00:00', '2021-04-16', '13:59:04', NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-16 10:42:16', '2021-04-16 13:59:04', 0),
(28, 'WO-21-0064', 'SR-21-0129', 'MKT', 'medium', 'eng02', NULL, NULL, NULL, NULL, 'MCH01', 'FAC02', NULL, NULL, '5', 'RC03', NULL, NULL, NULL, '', NULL, 'perbaikan selesai', 'closed', '2021-04-25', '2021-04-30', '2021-04-16', '16:46:06', '2021-04-17', '16:00:00', '2021-04-16', '16:46:53', 'user02', NULL, NULL, NULL, NULL, NULL, '2021-04-16 14:46:03', '2021-04-16 16:46:53', 0),
(29, 'WO-21-0065', 'SR-21-0130', 'ENG', 'high', 'eng01', 'eng02', NULL, NULL, NULL, 'MCH02', 'FAC03', NULL, NULL, '2', 'RC01', 'RC03', NULL, NULL, '', 'Getaran menghasilkan bunyi yang menganggu.', 'testreportingnote', 'closed', '2021-04-16', '2021-04-30', '2021-04-16', '16:37:52', '2021-01-01', '01:01:00', '2021-04-16', '16:38:24', 'admin2', NULL, NULL, NULL, NULL, NULL, '2021-04-16 15:45:51', '2021-04-16 16:38:24', 0),
(30, 'WO-21-0066', 'SR-21-0131', 'MKT', 'medium', 'eng02', NULL, NULL, NULL, NULL, 'MCH01', 'FAC02', NULL, NULL, '3', 'RC03', NULL, NULL, NULL, '', 'tolong diperbaiki', 'sudah dikerjakan', 'closed', '2021-04-24', '2021-04-30', '2021-04-16', '16:53:05', '2021-04-22', '15:00:00', '2021-04-16', '16:54:45', 'user02', NULL, NULL, NULL, NULL, NULL, '2021-04-16 16:50:15', '2021-04-16 16:54:45', 0),
(31, 'WO-21-0067', 'SR-21-0132', 'MKT', 'high', 'eng02', NULL, NULL, NULL, NULL, 'MCH03', 'FAC02', NULL, NULL, '6', 'RC03', NULL, NULL, NULL, '', 'tes', 'oke', 'closed', '2021-04-22', '2021-04-24', '2021-04-16', '17:04:06', '2021-04-23', '15:00:00', '2021-04-16', '17:04:41', 'user02', NULL, NULL, NULL, NULL, NULL, '2021-04-16 17:03:38', '2021-04-16 17:04:41', 0),
(32, 'WO-21-0068', 'SR-21-0134', 'ENG', 'medium', 'eng01', 'eng02', NULL, NULL, NULL, 'AC02', 'FAC01', NULL, NULL, '3', 'RC03', NULL, NULL, NULL, '', NULL, 'sip', 'closed', '2021-04-23', '2021-04-26', '2021-04-19', '10:57:41', '2021-04-23', '12:00:00', '2021-04-19', '10:59:08', 'admin2', NULL, NULL, NULL, NULL, NULL, '2021-04-19 10:56:26', '2021-04-19 10:59:08', 0),
(33, 'WO-21-0069', NULL, 'ENG', 'high', 'eng01', NULL, NULL, NULL, NULL, 'AC02', 'FAC02', '', NULL, '3', '', NULL, NULL, NULL, '', 'ac menjadi tidak dingin', 'ok', 'plan', '2021-04-19', '2021-04-23', '2021-04-19', '11:19:50', '2021-04-21', '17:00:00', '2021-04-19', '11:21:16', 'eng01', NULL, NULL, NULL, NULL, NULL, '2021-04-19 11:05:45', '2021-04-19 11:21:16', 0),
(34, 'WO-21-0070', NULL, 'ENG', 'high', 'eng01', NULL, NULL, NULL, NULL, 'AC02', 'FAC02', '', NULL, '5', 'Q01', NULL, NULL, NULL, 'code', 'bunyi', NULL, 'finish', '2021-04-21', '2021-04-21', '2021-05-21', '14:58:15', '2021-05-21', '00:00:00', '2021-05-21', '14:59:40', 'eng01', NULL, NULL, NULL, NULL, NULL, '2021-04-19 11:33:07', '2021-05-21 14:59:40', 0),
(35, 'WO-21-0071', 'SR-21-0135', 'ENG', 'high', 'eng01', NULL, NULL, NULL, NULL, 'AC01', 'FAC01', NULL, NULL, '8', 'RC03', NULL, NULL, NULL, '', NULL, NULL, 'closed', '2021-04-20', '2021-05-01', '2021-04-19', '13:54:56', '2021-04-24', '00:00:00', '2021-04-19', '13:56:20', 'admin2', NULL, NULL, NULL, NULL, NULL, '2021-04-19 13:53:41', '2021-04-19 13:56:20', 0),
(36, 'WT-21-0018', NULL, '', 'high', 'admin', NULL, NULL, NULL, NULL, 'VHC01', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', NULL, NULL, 'plan', '2021-04-23', '2021-04-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-23 10:31:43', '2021-04-23 12:04:26', 0),
(37, 'WO-21-0072', 'SR-21-0136', 'HR', 'high', 'eng01', 'eng02', NULL, NULL, NULL, 'MCH01', 'FAC03', NULL, NULL, '', 'RC01', NULL, NULL, NULL, '', 'abc', NULL, 'started', '2021-04-23', '2021-04-30', '2021-04-23', '17:15:34', NULL, NULL, NULL, NULL, 'user01', NULL, NULL, NULL, NULL, NULL, '2021-04-23 10:40:32', '2021-04-23 10:40:32', 1),
(38, 'WO-21-0073', NULL, 'ENG', 'high', 'eng01', NULL, NULL, NULL, NULL, 'MCH02', 'FAC02', '', NULL, '', NULL, NULL, NULL, NULL, '', NULL, NULL, 'plan', '2021-04-18', '2021-04-25', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2021-04-25 18:56:19', '2021-04-25 19:48:14', 0),
(39, 'WT-21-0019', NULL, '', 'high', 'eng01', NULL, NULL, NULL, NULL, 'MCH01', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', NULL, NULL, 'plan', '2021-04-25', '2021-04-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-25 19:56:13', '2021-04-25 19:59:44', 0),
(40, 'WO-21-0074', NULL, 'ENG', 'low', 'rio', NULL, NULL, NULL, NULL, 'AC01', 'FAC01', '', NULL, '', NULL, NULL, NULL, NULL, '', NULL, NULL, 'plan', '2021-04-28', '2021-04-30', NULL, NULL, NULL, NULL, NULL, NULL, 'rio', NULL, NULL, NULL, NULL, NULL, '2021-04-28 14:11:01', '2021-04-28 14:11:01', 0),
(41, 'WO-21-0075', 'SR-21-0139', 'ENG', 'low', 'rio', NULL, NULL, NULL, NULL, 'AC01', NULL, 'FAC01', NULL, '4', 'RC01', NULL, NULL, NULL, '', NULL, NULL, 'closed', '2021-04-29', '2021-04-30', '2021-04-28', '14:42:55', '2021-04-29', '00:00:00', '2021-04-28', '14:58:26', 'rio', NULL, NULL, NULL, NULL, 'Saat ini masih bocor', '2021-04-28 14:14:07', '2021-04-28 14:58:26', 0),
(42, 'WO-21-0076', NULL, 'ENG', 'high', 'rio', NULL, NULL, NULL, NULL, 'AC01', 'FAC01', '', NULL, '', NULL, NULL, NULL, 'teste', 'group', NULL, NULL, 'open', '2021-05-01', '2021-05-07', NULL, NULL, NULL, NULL, NULL, NULL, 'rio', NULL, NULL, NULL, NULL, NULL, '2021-04-30 10:06:26', '2021-04-30 14:42:15', 0),
(43, 'WO-21-0077', 'SR-21-0138', 'ENG', 'high', NULL, NULL, NULL, NULL, NULL, 'AC01', 'FAC01', NULL, NULL, '', NULL, NULL, NULL, 'teste', 'group', NULL, NULL, 'open', '2021-04-30', '2021-04-30', NULL, NULL, NULL, NULL, NULL, NULL, 'admin2', NULL, NULL, NULL, NULL, NULL, '2021-04-30 15:01:08', '2021-04-30 15:01:08', 0),
(44, 'WO-21-0078', 'SR-21-0133', 'ENG', 'medium', 'eng01', 'spv02', 'rio', NULL, NULL, 'MCH03', 'FAC01', NULL, NULL, '', 'RC01', 'Q01', 'Q02', NULL, 'code', 'ada tumpahan oli yang keluar', NULL, 'open', '2021-04-30', '2021-04-30', NULL, NULL, NULL, NULL, NULL, NULL, 'admin2', NULL, NULL, NULL, NULL, NULL, '2021-04-30 15:02:44', '2021-04-30 15:02:44', 0),
(45, 'WO-21-0079', 'SR-21-0127', 'ENG', 'medium', NULL, NULL, NULL, NULL, NULL, 'AC02', 'FAC01', NULL, NULL, '', NULL, NULL, NULL, 'RP01', 'group', NULL, NULL, 'open', '2021-04-30', '2021-04-30', NULL, NULL, NULL, NULL, NULL, NULL, 'admin2', NULL, NULL, NULL, NULL, NULL, '2021-04-30 15:03:39', '2021-04-30 15:03:39', 0),
(46, 'WO-21-0080', NULL, 'ENG', 'low', 'admin4', NULL, NULL, NULL, NULL, 'AC01', 'FAC01', 'FAC02', NULL, '1', '02-04-02', 'VHC-001', NULL, NULL, 'code', NULL, NULL, 'finish', '2021-04-15', '2021-04-17', '2021-04-30', '15:13:23', '2021-01-01', '00:01:00', '2021-05-03', '09:32:24', 'admin4', NULL, NULL, NULL, NULL, NULL, '2021-04-30 15:04:23', '2021-05-03 09:32:24', 0),
(47, 'WO-21-0081', NULL, 'ENG', 'low', 'admin4', NULL, NULL, NULL, NULL, 'AC02', 'FAC02', '', NULL, '1', NULL, NULL, NULL, 'RP01', 'group', NULL, NULL, 'finish', '2021-01-01', '2021-01-01', '2021-05-03', '10:48:40', '2021-01-01', '01:00:00', '2021-05-03', '11:02:10', 'admin4', NULL, NULL, NULL, NULL, NULL, '2021-05-03 10:48:02', '2021-05-03 11:02:10', 0),
(48, 'WO-21-0082', NULL, 'ENG', 'low', 'admin4', NULL, NULL, NULL, NULL, 'AC01', 'FAC02', '', NULL, '1', NULL, 'RC03', NULL, NULL, 'code', NULL, NULL, 'closed', '2021-01-31', '2021-01-01', '2021-05-03', '12:42:19', '2021-01-01', '01:00:00', '2021-05-03', '12:42:54', 'admin4', NULL, NULL, NULL, NULL, NULL, '2021-05-03 12:41:42', '2021-05-03 12:42:54', 0),
(49, 'WO-21-0083', NULL, 'ENG', 'low', 'admin4', NULL, NULL, NULL, NULL, 'AC02', 'FAC01', 'FAC03', NULL, '1', NULL, NULL, NULL, 'EQ-003G', 'group', NULL, NULL, 'finish', '2021-01-01', '2021-01-01', '2021-05-03', '14:04:43', '2021-01-01', '00:00:00', '2021-05-24', '16:43:09', 'admin4', NULL, NULL, NULL, NULL, NULL, '2021-05-03 14:03:56', '2021-05-24 16:43:09', 0),
(50, 'WO-21-0084', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, 'AC01', 'FAC02', '', NULL, '', NULL, NULL, NULL, 'RP02', 'group', NULL, NULL, 'started', '2021-01-01', '2021-02-01', '2021-05-04', '12:18:52', NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2021-05-04 11:58:46', '2021-05-04 12:18:36', 0),
(51, 'WO-21-0085', NULL, 'ENG', 'low', 'admin4', NULL, NULL, NULL, NULL, 'AC01', 'FAC01', 'FAC02', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'plan', '2021-01-31', '2021-01-01', NULL, NULL, NULL, NULL, NULL, NULL, 'admin4', NULL, NULL, NULL, NULL, NULL, '2021-05-05 13:52:40', '2021-05-05 13:52:40', 0),
(52, 'WO-21-0086', NULL, 'ENG', 'low', 'admin4', NULL, NULL, NULL, NULL, 'AC01', 'FAC03', 'FAC02', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'direct', '2021-02-02', '2021-01-01', NULL, NULL, NULL, NULL, NULL, NULL, 'admin4', NULL, NULL, NULL, NULL, NULL, '2021-05-05 13:56:06', '2021-05-05 14:19:19', 0),
(53, 'WD-21-0001', NULL, 'ENG', 'low', 'admin4', NULL, NULL, NULL, NULL, 'AC01', 'FAC01', 'FAC02', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'open', '2021-01-02', '2021-01-01', NULL, NULL, NULL, NULL, NULL, NULL, 'admin4', NULL, NULL, NULL, NULL, NULL, '2021-05-05 14:19:46', '2021-05-05 14:19:46', 0),
(54, 'WO-21-0087', 'SR-21-0140', 'ENG', 'low', 'eng01', 'eng02', NULL, NULL, NULL, 'AC01', 'FAC01', NULL, NULL, '', 'RC01', 'RC03', '02-04-02', NULL, 'code', NULL, NULL, 'open', '2021-05-05', '2021-05-05', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2021-05-05 15:15:56', '2021-05-05 15:15:56', 0),
(55, 'WO-21-0088', NULL, 'ENG', 'low', 'admin', 'eng01', NULL, NULL, NULL, 'AC01', 'FAC01', '', NULL, '', NULL, NULL, NULL, 'RG001', 'group', NULL, NULL, 'open', '2021-01-01', '2021-02-01', NULL, NULL, NULL, NULL, NULL, NULL, 'admin4', NULL, NULL, NULL, NULL, NULL, '2021-05-05 15:26:38', '2021-05-05 15:26:38', 0),
(56, 'WD-21-0002', NULL, 'ENG', 'low', 'admin2', NULL, NULL, NULL, NULL, 'AC01', 'FAC02', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'closed', '2021-05-05', '2021-06-05', NULL, NULL, NULL, NULL, NULL, NULL, 'admin2', NULL, NULL, NULL, NULL, NULL, '2021-05-05 16:26:52', '2021-05-05 16:27:28', 0),
(57, 'WD-21-0003', NULL, 'ENG', 'high', 'admin2', NULL, NULL, NULL, NULL, 'AC01', 'FAC01', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'open', '2021-05-06', '2021-05-06', NULL, NULL, NULL, NULL, NULL, NULL, 'admin2', NULL, NULL, NULL, NULL, NULL, '2021-05-06 09:26:34', '2021-05-06 09:26:34', 0),
(58, 'WO-21-0089', NULL, 'ENG', 'high', 'admin', NULL, NULL, NULL, NULL, 'VHC01', 'FEQ-0003', '', NULL, '', '', NULL, NULL, 'Servis Mob', 'group', 'servis rutin', NULL, 'started', '2021-05-11', '2021-05-14', '2021-05-11', '10:45:17', NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2021-05-11 10:41:51', '2021-05-11 10:41:51', 0),
(59, 'WO-21-0090', 'SR-21-0137', 'ENG', 'low', 'eng01', 'eng02', 'rio', NULL, NULL, 'AC01', 'FAC04', NULL, NULL, '', 'Q02', 'CAR01', NULL, NULL, 'code', NULL, NULL, 'open', '2021-05-17', '2021-05-28', NULL, NULL, NULL, NULL, NULL, NULL, 'rio', NULL, NULL, NULL, NULL, NULL, '2021-05-17 10:07:57', '2021-05-17 10:07:57', 0),
(60, 'WO-21-0091', 'SR-21-0142', 'ENG', 'high', 'admin', NULL, NULL, NULL, NULL, 'VHC01', 'FEQ-0003', NULL, NULL, '', 'CAR01', 'CAR02', NULL, NULL, 'code', 'tes SR', NULL, 'started', '2021-05-17', '2021-05-21', '2021-05-17', '10:55:40', NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2021-05-17 10:54:45', '2021-05-17 10:54:45', 0),
(61, 'WO-21-0092', 'SR-21-0141', 'ENG', 'medium', 'eng01', 'eng02', NULL, NULL, NULL, 'EQ-0003', 'FAC03', 'FAC04', NULL, '', 'RC03', '02-04-02', 'Q01', NULL, 'code', NULL, NULL, 'open', '2021-05-20', '2021-06-04', NULL, NULL, NULL, NULL, NULL, NULL, 'admin2', NULL, 'admin2', NULL, NULL, NULL, '2021-05-20 13:51:15', '2021-05-20 13:51:15', 0),
(62, 'WO-21-0093', 'SR-21-0143', 'ENG', 'medium', 'eng02', 'spv01', NULL, NULL, NULL, 'day', 'FAC04', NULL, NULL, '', 'Q02', NULL, NULL, NULL, 'code', NULL, NULL, 'open', '2021-05-28', '2021-05-29', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, 'admin', NULL, NULL, NULL, '2021-05-20 14:01:18', '2021-05-20 14:01:18', 0),
(63, 'WO-21-0094', 'SR-21-0144', 'HR', 'high', NULL, NULL, NULL, NULL, NULL, 'EQ-0003', 'FAC01', 'FAC03', NULL, '', NULL, NULL, NULL, 'EQ-003G', 'group', 'tolong segera diperbaiki', NULL, 'open', '2021-05-21', '2021-05-23', NULL, NULL, NULL, NULL, NULL, NULL, 'user01', NULL, 'user01', NULL, NULL, NULL, '2021-05-21 14:48:56', '2021-05-21 14:48:56', 0),
(64, 'WO-21-0095', 'SR-21-0145', 'HR', 'high', NULL, NULL, NULL, NULL, NULL, 'EQ-0003', 'FAC01', 'FAC03', NULL, '', NULL, NULL, NULL, 'EQ-003G', 'group', 'segera diperbaiki', NULL, 'open', '2021-05-21', '2021-05-23', NULL, NULL, NULL, NULL, NULL, NULL, 'user01', NULL, 'user01', NULL, NULL, NULL, '2021-05-21 15:06:29', '2021-05-21 15:06:29', 0),
(65, 'WO-21-0096', 'SR-21-0146', 'ENG', 'high', NULL, NULL, NULL, NULL, NULL, 'AC01', 'FAC02', NULL, NULL, '', NULL, NULL, NULL, 'RP02', 'group', NULL, NULL, 'open', '2021-06-05', '2021-06-05', NULL, NULL, NULL, NULL, NULL, NULL, 'admin2', NULL, 'admin2', NULL, NULL, NULL, '2021-05-21 15:18:30', '2021-05-21 15:18:30', 0),
(66, 'WO-21-0097', 'SR-21-0147', 'ENG', 'medium', NULL, NULL, NULL, NULL, NULL, 'VHC01', 'FAC02', NULL, NULL, '', NULL, NULL, NULL, 'CARSERV', 'group', NULL, NULL, 'open', '2021-05-21', '2021-05-29', NULL, NULL, NULL, NULL, NULL, NULL, 'admin2', NULL, 'admin2', NULL, NULL, NULL, '2021-05-21 15:21:18', '2021-05-21 15:21:18', 0),
(67, 'WO-21-0098', 'SR-21-0148', 'ENG', 'high', 'admin', 'eng01', 'eng02', NULL, NULL, 'EQ-0003', 'FAC02', NULL, NULL, '', NULL, NULL, NULL, 'CARSERV', 'group', NULL, NULL, 'open', '2021-05-21', '2021-05-21', NULL, NULL, NULL, NULL, NULL, NULL, 'admin2', NULL, 'admin2', NULL, NULL, NULL, '2021-05-21 15:37:07', '2021-05-21 15:37:07', 0),
(68, 'WO-21-0099', 'SR-21-0149', 'HR', 'high', 'eng01', NULL, NULL, NULL, NULL, 'EQ-0003', 'FAC01', 'FAC03', NULL, '', NULL, NULL, NULL, 'EQ-003G', 'group', 'tolong segera diperbaiki', NULL, 'started', '2021-05-21', '2021-05-23', '2021-05-21', '16:56:13', NULL, NULL, NULL, NULL, 'user01', NULL, 'user01', NULL, NULL, NULL, '2021-05-21 16:11:20', '2021-05-21 16:11:20', 0),
(69, 'WO-21-0100', 'SR-21-0150', 'ENG', 'high', 'eng01', NULL, NULL, NULL, NULL, 'EQ-0003', 'FAC01', 'FAC03', NULL, '', NULL, NULL, NULL, 'EQ-003G', 'group', 'segera diperbaiki', NULL, 'started', '2021-05-24', '2021-05-27', '2021-05-24', '14:33:45', NULL, NULL, NULL, NULL, 'rio', NULL, 'rio', NULL, NULL, NULL, '2021-05-24 14:29:55', '2021-05-24 14:29:55', 1),
(70, 'WO-21-0101', 'SR-21-0151', 'MKT', 'high', 'eng01', 'eng02', NULL, NULL, NULL, 'EQ-0003', 'FAC02', 'FAC03', 'FAC04', '4', NULL, NULL, NULL, 'EQ-003G', 'group', 'butuh perbaikan', 'oke', 'started', '2021-05-24', '2021-05-26', '2021-05-24', '15:35:22', '2021-05-25', '11:00:00', '2021-05-24', '15:36:41', 'user02', NULL, 'user02', NULL, NULL, NULL, '2021-05-24 15:16:47', '2021-05-24 15:36:41', 0),
(71, 'WO-21-0102', 'SR-21-0153', 'HR', 'medium', 'eng02', NULL, NULL, NULL, NULL, 'EQ-0003', 'FAC02', NULL, NULL, '', 'EQ-003M', NULL, NULL, NULL, 'code', 'test abandon', NULL, 'open', '2021-05-24', '2021-05-25', NULL, NULL, NULL, NULL, NULL, NULL, 'user01', NULL, 'user01', NULL, NULL, NULL, '2021-05-24 16:36:51', '2021-05-24 16:36:51', 0),
(72, 'WD-21-0004', NULL, 'ENG', 'high', 'eng01', NULL, NULL, NULL, NULL, 'EQ-0003', 'FAC02', '', NULL, '', NULL, NULL, NULL, NULL, NULL, 'ada kerusakan', NULL, 'open', '2021-05-24', '2021-05-25', NULL, NULL, NULL, NULL, NULL, NULL, 'eng01', NULL, NULL, NULL, NULL, NULL, '2021-05-24 17:01:23', '2021-05-24 17:01:23', 0),
(73, 'WD-21-0005', NULL, 'ENG', 'low', 'admin4', NULL, NULL, NULL, NULL, 'AC01', 'FAC01', 'FAC02', NULL, '1', NULL, NULL, NULL, NULL, 'manual', NULL, NULL, 'finish', '2021-05-26', '2021-05-27', '2021-05-27', '09:48:44', '2021-01-01', '01:00:00', '2021-05-28', '10:51:57', 'admin4', NULL, NULL, NULL, NULL, NULL, '2021-05-27 09:47:54', '2021-05-28 10:51:57', 0),
(74, 'WO-21-0103', NULL, 'ENG', 'high', 'rio', NULL, NULL, NULL, NULL, 'EQ-0003', 'FAC01', '', NULL, '', '', NULL, NULL, 'EQ-003G', 'group', NULL, NULL, 'delete', '2021-05-27', '2021-05-27', NULL, NULL, NULL, NULL, NULL, NULL, 'rio', NULL, 'rio', NULL, NULL, NULL, '2021-05-27 12:06:33', '2021-05-27 12:07:59', 0),
(75, 'WO-21-0104', NULL, 'ENG', 'high', 'rio', NULL, NULL, NULL, NULL, 'EQ-0003', 'FAC01', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'plan', '2021-05-29', '2021-05-31', NULL, NULL, NULL, NULL, NULL, NULL, 'rio', NULL, NULL, NULL, NULL, NULL, '2021-05-27 12:11:07', '2021-05-27 12:11:07', 0),
(76, 'WT-21-0020', NULL, '', 'high', NULL, NULL, NULL, NULL, NULL, 'AC02', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'plan', '2021-05-27', '2021-05-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-27 15:13:55', '2021-05-27 15:13:55', 0),
(77, 'WD-21-0006', NULL, 'ENG', 'medium', 'admin4', NULL, NULL, NULL, NULL, 'AC01', 'Other', '', NULL, '', NULL, NULL, NULL, NULL, NULL, 'Mesin berbunyi gluduk-gluduk', NULL, 'open', '2021-06-03', '2021-06-15', NULL, NULL, NULL, NULL, NULL, NULL, 'admin4', NULL, NULL, NULL, NULL, NULL, '2021-06-02 09:47:37', '2021-06-02 09:47:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wo_rc_detail`
--

CREATE TABLE `wo_rc_detail` (
  `wrd_id` int(11) NOT NULL,
  `wrd_wo_nbr` varchar(30) NOT NULL,
  `wrd_repair_code` varchar(30) NOT NULL,
  `wrd_flag` varchar(255) NOT NULL,
  `wrd_created_at` datetime NOT NULL,
  `wrd_updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wo_rc_detail`
--

INSERT INTO `wo_rc_detail` (`wrd_id`, `wrd_wo_nbr`, `wrd_repair_code`, `wrd_flag`, `wrd_created_at`, `wrd_updated_at`) VALUES
(4, 'WO-21-0052', 'RC03', 'y0n1y2n3n4y6', '2021-04-12 18:25:53', '2021-04-12 18:25:53'),
(5, 'WO-21-0060', '02-04-02', 'y0y1', '2021-04-16 13:46:29', '2021-04-16 13:46:29'),
(6, 'WO-21-0061', 'RC01', '', '2021-04-16 13:55:32', '2021-04-16 13:55:32'),
(7, 'WO-21-0061', 'RC03', 'y0y1y2n3y4y5', '2021-04-16 13:55:32', '2021-04-16 13:55:32'),
(8, 'WO-21-0062', 'RC03', 'y0y1y2y3y4y5', '2021-04-16 13:58:41', '2021-04-16 13:58:41'),
(9, 'WO-21-0063', 'RC01', '', '2021-04-16 13:59:04', '2021-04-16 13:59:04'),
(10, 'WO-21-0063', 'RC03', 'y0y1y2y3y4y5', '2021-04-16 13:59:04', '2021-04-16 13:59:04'),
(11, 'WO-21-0065', 'RC01', '', '2021-04-16 16:38:24', '2021-04-16 16:38:24'),
(12, 'WO-21-0065', 'RC03', 'y0y1y2n3y4y5', '2021-04-16 16:38:24', '2021-04-16 16:38:24'),
(13, 'WO-21-0064', 'RC03', 'y0y1y2y3y4y5', '2021-04-16 16:46:53', '2021-04-16 16:46:53'),
(14, 'WO-21-0066', 'RC03', 'y0y1y2n3n4n5', '2021-04-16 16:54:45', '2021-04-16 16:54:45'),
(15, 'WO-21-0067', 'RC03', 'y0y1y2n3n4n5', '2021-04-16 17:04:41', '2021-04-16 17:04:41'),
(16, 'WO-21-0068', 'RC03', 'y0y1y2n3n4n5', '2021-04-19 10:59:08', '2021-04-19 10:59:08'),
(17, 'WO-21-0069', '02-04-02', 'y0n1', '2021-04-19 11:21:16', '2021-04-19 11:21:16'),
(18, 'WO-21-0071', 'RC03', 'y0y1y2y3y4y5', '2021-04-19 13:56:20', '2021-04-19 13:56:20'),
(19, 'WO-21-0075', 'RC03', 'y0y1y2y3y4y5y6', '2021-04-28 14:58:26', '2021-04-28 14:58:26'),
(34, 'WO-21-0080', '02-04-02', 'y0n1', '2021-05-03 09:32:24', '2021-05-03 09:32:24'),
(35, 'WO-21-0080', 'RC03', 'y3y5', '2021-05-03 09:32:24', '2021-05-03 09:32:24'),
(40, 'WO-21-0081', '02-04-02', 'y0', '2021-05-03 11:02:10', '2021-05-03 11:02:10'),
(41, 'WO-21-0081', 'RC03', 'y3n5', '2021-05-03 11:02:10', '2021-05-03 11:02:10'),
(42, 'WO-21-0082', 'RC01', '', '2021-05-03 12:42:54', '2021-05-03 12:42:54'),
(43, 'WO-21-0082', 'RC03', 'y0n1y3y4n6', '2021-05-03 12:42:54', '2021-05-03 12:42:54'),
(44, 'WO-21-0070', 'Q01', '', '2021-05-21 14:59:40', '2021-05-21 14:59:40'),
(45, 'WO-21-0101', 'EQ-003E', 'y0n1y2n3', '2021-05-24 15:36:41', '2021-05-24 15:36:41'),
(46, 'WO-21-0101', 'EQ-003M', 'y0n1n2y3', '2021-05-24 15:36:41', '2021-05-24 15:36:41'),
(47, 'WO-21-0083', 'EQ-003E', 'y0n1n2y3', '2021-05-24 16:43:09', '2021-05-24 16:43:09'),
(48, 'WO-21-0083', 'EQ-003M', 'y4y5n6n7', '2021-05-24 16:43:09', '2021-05-24 16:43:09');

-- --------------------------------------------------------

--
-- Table structure for table `xxrepgroup_mstr`
--

CREATE TABLE `xxrepgroup_mstr` (
  `xxrepgroup_id` int(11) NOT NULL,
  `xxrepgroup_nbr` varchar(10) NOT NULL,
  `xxrepgroup_desc` varchar(50) NOT NULL,
  `xxrepgroup_line` int(11) NOT NULL,
  `xxrepgroup_rep_code` varchar(50) NOT NULL,
  `xxrepgroup_rep_desc` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `xxrepgroup_mstr`
--

INSERT INTO `xxrepgroup_mstr` (`xxrepgroup_id`, `xxrepgroup_nbr`, `xxrepgroup_desc`, `xxrepgroup_line`, `xxrepgroup_rep_code`, `xxrepgroup_rep_desc`) VALUES
(5, 'RP02', 'EQ-0003', 1, 'Q01', ''),
(6, 'RP02', 'EQ-0003', 2, 'Q02', ''),
(27, 'EQ-003G', 'Repair Group EQ-0003', 1, 'EQ-003M', 'Mekanik'),
(28, 'EQ-003G', 'Repair Group EQ-0003', 2, 'EQ-003E', 'Elektrik'),
(77, 'CARSERV', 'Service Mobil', 1, 'CAR01', ''),
(78, 'CARSERV', 'Service Mobil', 2, 'CAR02', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acceptance_image`
--
ALTER TABLE `acceptance_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area_mstr`
--
ALTER TABLE `area_mstr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_mstr`
--
ALTER TABLE `asset_mstr`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `asset_par`
--
ALTER TABLE `asset_par`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `asset_type`
--
ALTER TABLE `asset_type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `dept_mstr`
--
ALTER TABLE `dept_mstr`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `eng_mstr`
--
ALTER TABLE `eng_mstr`
  ADD PRIMARY KEY (`ID`,`eng_code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fn_mstr`
--
ALTER TABLE `fn_mstr`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ins_group`
--
ALTER TABLE `ins_group`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ins_mstr`
--
ALTER TABLE `ins_mstr`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `inv_mstr`
--
ALTER TABLE `inv_mstr`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `loc_mstr`
--
ALTER TABLE `loc_mstr`
  ADD PRIMARY KEY (`ID`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `rep_det`
--
ALTER TABLE `rep_det`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `rep_ins`
--
ALTER TABLE `rep_ins`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `rep_master`
--
ALTER TABLE `rep_master`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `rep_mstr`
--
ALTER TABLE `rep_mstr`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `rep_part`
--
ALTER TABLE `rep_part`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `rep_partgroup`
--
ALTER TABLE `rep_partgroup`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_code`);

--
-- Indexes for table `running_mstr`
--
ALTER TABLE `running_mstr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_req_mstr`
--
ALTER TABLE `service_req_mstr`
  ADD PRIMARY KEY (`id_sr`);

--
-- Indexes for table `site_mstrs`
--
ALTER TABLE `site_mstrs`
  ADD PRIMARY KEY (`site_code`);

--
-- Indexes for table `sp_group`
--
ALTER TABLE `sp_group`
  ADD PRIMARY KEY (`ID`,`spg_code`);

--
-- Indexes for table `sp_mstr`
--
ALTER TABLE `sp_mstr`
  ADD PRIMARY KEY (`ID`,`spm_code`);

--
-- Indexes for table `sp_type`
--
ALTER TABLE `sp_type`
  ADD PRIMARY KEY (`ID`,`spt_code`);

--
-- Indexes for table `supp_mstr`
--
ALTER TABLE `supp_mstr`
  ADD PRIMARY KEY (`ID`,`supp_code`);

--
-- Indexes for table `tool_mstr`
--
ALTER TABLE `tool_mstr`
  ADD PRIMARY KEY (`ID`,`tool_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `username_2` (`username`);

--
-- Indexes for table `wo_detail`
--
ALTER TABLE `wo_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wo_manual_detail`
--
ALTER TABLE `wo_manual_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wo_mstr`
--
ALTER TABLE `wo_mstr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wo_rc_detail`
--
ALTER TABLE `wo_rc_detail`
  ADD PRIMARY KEY (`wrd_id`);

--
-- Indexes for table `xxrepgroup_mstr`
--
ALTER TABLE `xxrepgroup_mstr`
  ADD PRIMARY KEY (`xxrepgroup_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acceptance_image`
--
ALTER TABLE `acceptance_image`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `asset_mstr`
--
ALTER TABLE `asset_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `asset_par`
--
ALTER TABLE `asset_par`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `asset_type`
--
ALTER TABLE `asset_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dept_mstr`
--
ALTER TABLE `dept_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `eng_mstr`
--
ALTER TABLE `eng_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fn_mstr`
--
ALTER TABLE `fn_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ins_group`
--
ALTER TABLE `ins_group`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ins_mstr`
--
ALTER TABLE `ins_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `inv_mstr`
--
ALTER TABLE `inv_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `loc_mstr`
--
ALTER TABLE `loc_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rep_det`
--
ALTER TABLE `rep_det`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rep_ins`
--
ALTER TABLE `rep_ins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rep_master`
--
ALTER TABLE `rep_master`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rep_mstr`
--
ALTER TABLE `rep_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rep_part`
--
ALTER TABLE `rep_part`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rep_partgroup`
--
ALTER TABLE `rep_partgroup`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `running_mstr`
--
ALTER TABLE `running_mstr`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_req_mstr`
--
ALTER TABLE `service_req_mstr`
  MODIFY `id_sr` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `sp_group`
--
ALTER TABLE `sp_group`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sp_mstr`
--
ALTER TABLE `sp_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sp_type`
--
ALTER TABLE `sp_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `supp_mstr`
--
ALTER TABLE `supp_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tool_mstr`
--
ALTER TABLE `tool_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `wo_detail`
--
ALTER TABLE `wo_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wo_manual_detail`
--
ALTER TABLE `wo_manual_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wo_mstr`
--
ALTER TABLE `wo_mstr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `wo_rc_detail`
--
ALTER TABLE `wo_rc_detail`
  MODIFY `wrd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `xxrepgroup_mstr`
--
ALTER TABLE `xxrepgroup_mstr`
  MODIFY `xxrepgroup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
