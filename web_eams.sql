-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2022 at 06:52 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_eams`
--

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
  `asgroup_code` varchar(8) NOT NULL,
  `asgroup_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_group`
--

INSERT INTO `asset_group` (`ID`, `asgroup_code`, `asgroup_desc`, `created_at`, `updated_at`) VALUES
(1, 'B', 'Building edit', '2021-03-01', '2021-03-01'),
(2, 'M', 'Transportation', '2021-03-01', '2021-03-01'),
(3, 'D', 'Machine', '2021-03-01', '2021-03-01'),
(5, 'A', 'Kitchen 1', '2021-03-01', '2021-03-01'),
(6, 'K', 'Kitchen', '2021-03-01', '2021-03-01'),
(7, 'Z', 'Others mesin', '2021-03-01', '2021-03-01');

-- --------------------------------------------------------

--
-- Table structure for table `asset_mstr`
--

CREATE TABLE `asset_mstr` (
  `ID` int(11) NOT NULL,
  `asset_code` varchar(20) NOT NULL,
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
  `asset_supp` varchar(0) DEFAULT NULL,
  `asset_meter` int(11) DEFAULT NULL,
  `asset_cal` int(11) DEFAULT NULL,
  `asset_tolerance` int(11) DEFAULT 0,
  `asset_start_mea` date DEFAULT NULL,
  `asset_last_usage` decimal(10,2) DEFAULT 0.00,
  `asset_last_usage_mtc` decimal(10,2) DEFAULT 0.00,
  `asset_last_mtc` date DEFAULT NULL,
  `asset_note` varchar(200) DEFAULT NULL,
  `asset_active` varchar(5) DEFAULT NULL,
  `asset_repair_type` varchar(50) DEFAULT NULL,
  `asset_repair` varchar(50) DEFAULT NULL,
  `asset_image` varchar(255) DEFAULT NULL,
  `asset_image_path` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) DEFAULT NULL,
  `asset_upload` varchar(255) DEFAULT NULL,
  `asset_on_use` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_mstr`
--

INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(21, '17.01', 'Transit Finish Goods Warehouse', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(22, '17.02', 'Loading FG Warehouse Area', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(23, '17.03', 'Retour Warehouse', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(24, '17.04', 'Unloading FG Warehouse Area', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(25, '17.05', 'Finish Goods Warehouse 1', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(26, '17.06', 'Janitor', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(27, '17.07', 'Air Handling Unit Room', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(28, '17.08', 'Finish Goods Warehouse 2', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(29, '17.09', 'FG Warehouse Office', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(30, '21.201', 'Instrument Room 1', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(31, '21.202', 'Instrument Room 2', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(32, '21.203', 'Ruang penyimpanan alat', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(33, '21.204', 'Ruang Supervisor', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(34, '21.205', 'Ruang Oven', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(35, '21.206', 'Flammable Fume Hood', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(36, '21.207', 'Non Flammable Fume Hood', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(37, '21.208', 'Reagent & Raw Material Storage', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(38, '21.209', 'Ruang Dokumentasi', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(39, '21.21', 'Ruang Pemeriksaan bahan kemas', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(40, '21.211', 'Washing Room', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, NULL, NULL, 0, 0, 1, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', '', NULL, NULL, '2022-04-05', '2022-04-10', 'admin', NULL, NULL),
(41, '21.212', 'Analysis Room', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(42, '21.213', 'Waste Storage Analysis', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(43, '21.214', 'Locker', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(44, '21.215', 'Pantry', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(45, '21.216', 'Toilet', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(46, '21.217', 'Hall', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(47, '21.218', 'Mushola', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(48, '21.301', 'Locker', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(49, '21.302', 'Ruang GC Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(50, '21.303', 'Reagent Flammable Storage', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(51, '21.304', 'Reagent Non Flammable Storage', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(52, '21.305', 'Fume Hood 1 (exproof)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(53, '21.306', 'Fume Hood 2', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(54, '21.307', 'Fume Hood 3(exproof)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(55, '21.308', 'Instrument Room QC 1', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(56, '21.309', 'Supervisor Room QC 1', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(57, '21.31', 'Supervisor Room QC 2', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(58, '21.311', 'Disolution Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(59, '21.312', 'Washing Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(60, '21.313', 'Instrument Room QC 3', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(61, '21.314', 'Oven Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(62, '21.315', 'Refrigerator Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(63, '21.316', 'Weighing Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(64, '21.317', 'Instrument Room QC 2 (HPLC)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(65, '21.318', 'Corridor', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(66, '21.319', 'Analysis Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(67, '21.32', 'Waste Storage Analysis', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(68, '21.321', 'Sample Storage', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(69, '21.322', 'UPS', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(70, '21.323', 'Locker', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(71, '21.324', 'Waste Storage Analysis (Temporary)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(72, '21.325', 'Administration Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(73, '21.326', 'Manager QC Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(74, '21.327', 'Pantry', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(75, '21.328', 'Toilet', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(76, '21.329', 'Junction Corridor ', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(77, '21.33', 'Hall', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(78, '21.331', 'Document Room (Lab)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(79, '27.01', '1ST Floor Capsule Warehouse', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(80, '27.02', '2ND Floor Capsule Warehouse', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(81, '27.03', 'Reject Warehouse', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(82, '27.04', 'Marketing1 Warehouse', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(83, '27.05', 'Marketing2 Warehouse', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(84, '01-AT-002', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3197'),
(85, '01-AT-003', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3198'),
(86, '01-AT-004', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3199'),
(87, '01-AT-005', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3200'),
(88, '01-AT-006', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3201'),
(89, '01-AT-007', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3202'),
(90, '01-AT-008', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3203'),
(91, '01-AT-009', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3204'),
(92, '01-AT-010', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3205'),
(93, '01-AT-011', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3206'),
(94, '01-AT-012', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3207'),
(95, '01-AT-013', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3208'),
(96, '01-AT-014', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3209'),
(97, '01-AT-015', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3210'),
(98, '01-AT-016', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3211'),
(99, '01-AT-017', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3212'),
(100, '01-AT-018', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3213'),
(101, '01-AT-019', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3214'),
(102, '01-AT-020', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3215'),
(103, '01-AT-021', 'Anak timbangan kelas M1 MPF ', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3216'),
(104, '01-AT-022', 'Anak timbangan kelas M1 MPF ', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3217'),
(105, '01-AT-023', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3218'),
(106, '01-AT-024', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3219'),
(107, '01-AT-025', 'Anak timbangan kelas M1 MPF', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3220'),
(108, '01-AT-036', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3221'),
(109, '01-AT-037', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3222'),
(110, '01-AT-038', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3223'),
(111, '01-AT-039', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3224'),
(112, '01-AT-040', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3225'),
(113, '01-AT-041', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3226'),
(114, '01-AT-042', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3227'),
(115, '01-AT-043', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3228'),
(116, '01-AT-044', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3229'),
(117, '01-AT-045', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3230'),
(118, '01-AT-046', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3231'),
(119, '01-AT-047', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3232'),
(120, '01-AT-048', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3233'),
(121, '01-AT-049', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3234'),
(122, '01-AT-050', 'Kalibrasi Anak Timbangan A (F2 )', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3235'),
(123, '01-AT-051', 'Anak Timbangan F1', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3236'),
(124, '01-AT-052', 'Anak Timbangan F1', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3237'),
(125, '01-AT-053', 'Anak Timbangan F1', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3238'),
(126, '01-AT-054', 'Anak Timbangan F1', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3239'),
(127, '01-AT-056', 'Anak Timbangan F1', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(128, '01-AT-057', 'Anak Timbangan F1', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(129, '01-AT-058', 'Anak Timbangan F1', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(130, '01-AT-059', 'Anak Timbangan F1', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(131, '01-AT-060', 'Anak timbangan M1', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(132, '01-AT-061', 'Anak timbangan M1', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(133, '01-AT-062', 'Anak timbangan M1', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(134, '01-CP-006', 'Caliper Digimatic  (Mitutoyo)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-05-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(135, '01-CP-007', 'Caliper Digimatic  (Mitutoyo)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-04-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(136, '01-CP-008', 'Caliper Digimatic  (Mitutoyo)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-04-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(137, '01-GB-001', 'Gauge Block 5mm', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(138, '01-GB-002', 'Gauge Block 10mm', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(139, '01-HT-004', 'HARDNESS TESTER ERWEKA', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3240'),
(140, '01-MS-001', 'Mettler Toledo / 2138', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3241'),
(141, '01-MS-003', 'Mettler (PG 603-s)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3242'),
(142, '01-MS-005', 'Mettler Toledo / KC150 (1944411)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3243'),
(143, '01-MS-008', 'Sartorius / TE 153S DS (19308725)', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(144, '01-MS-010', 'Sartorius / TE 153S DS (19508529)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(145, '01-MS-018', 'Shinko / CG-16K (01110002)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(146, '01-MS-020', 'Mettler Toledo / PR 503 (1119370224)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3244'),
(147, '01-MS-022', 'Sartorius / AG BSA 223 S-CW', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(148, '01-MS-023', 'Sartorius / AG BSA 223 S-CW', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(149, '01-MS-024', 'Sartorius / AG BSA 223 S-CW', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(150, '01-MS-025', 'Sartorius / AG BSA 223 S-CW', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(151, '01-MS-026', 'Sartorius / AG BSA 223 S-CW ', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(152, '01-MS-027', 'Sartorius /BSA 323 S', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(153, '01-MS-028', 'Sartorius /BSA 323 S', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(154, '01-MS-030', 'Vibra MJR-35KE', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(155, '01-MS-032', 'Vibra HJ-K', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(156, '01-MS-033', 'JADEVER (JDI-800)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(157, '01-MS-034', 'METTLER TOLEDO ML 303 T', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3245'),
(158, '01-MS-035', 'METTLER TOLEDO ML 303 T', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3246'),
(159, '01-MS-036', 'METTLER TOLEDO ML 303 T', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3247'),
(160, '01-MS-037', 'METTLER TOLEDO ML 303 T', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3248'),
(161, '01-MS-038', 'JADEVER (JDI-800)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3249'),
(162, '01-MS-039', 'JADEVER (JDI-800)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(163, '01–MS-041', 'Mettler Toledo (PBK989-A6)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3250'),
(164, '01-MS-042', 'Mettler Toledo (XPE205)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3251'),
(165, '01-MS-043', 'Mettler Toledo (KCC150s)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3252'),
(166, '01-MS-044', 'Avery Weigh-Tronik ZM201-SD2', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3253'),
(167, '01-MS-045', 'Mettler Toledo XPE204', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3254'),
(168, '01-MS-046', 'Jadever ', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(169, '01-MS-047', 'Jadever ', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(170, '01-MS-048', 'Jadever ', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(171, '01-MS-049', 'Mettler Toledo', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3255'),
(172, '01-MS-050', 'Mettler Toledo', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3256'),
(173, '01-MS-051', 'Mettler Toledo', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3257'),
(174, '01-MS-052', 'Mettler Toledo', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3258'),
(175, '01-MS-053', 'Mettler Toledo', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3259'),
(176, '01-MS-054', 'Mettler Toledo', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3260'),
(177, '01-OX-001', 'DO meter Hanna Instruments', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3261'),
(178, '01-PD-001', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3262'),
(179, '01-PD-002', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3263'),
(180, '01-PD-003', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(181, '01-PD-004', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(182, '01-PD-005', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3264'),
(183, '01-PD-006', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3265'),
(184, '01-PD-008', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3266'),
(185, '01-PD-010', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3267'),
(186, '01-PD-011', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3268'),
(187, '01-PD-012', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3269'),
(188, '01-PD-013', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3270'),
(189, '01-PD-014', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3271'),
(190, '01-PD-015', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3272'),
(191, '01-PD-016', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3273'),
(192, '01-PD-017', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(193, '01-PD-019', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3274'),
(194, '01-PD-020', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(195, '01-PD-021', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3275'),
(196, '01-PD-022', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3276'),
(197, '01-PD-023', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3277'),
(198, '01-PD-024', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3278'),
(199, '01-PD-025', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3279'),
(200, '01-PD-026', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3280'),
(201, '01-PD-029', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(202, '01-PD-030', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(203, '01-PD-031', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(204, '01-PD-032', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL);
INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(205, '01-PD-033', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(206, '01-PD-034', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(207, '01-PD-035', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(208, '01-PD-036', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(209, '01-PD-037', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3281'),
(210, '01-PD-039', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(211, '01-PD-040', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(212, '01-PD-041', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(213, '01-PD-042', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(214, '01-PD-043', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(215, '01-PD-044', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(216, '01-PD-045', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(217, '01-PD-046', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(218, '01-PD-047', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(219, '01-PD-048', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(220, '01-PD-051', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(221, '01-PD-052', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(222, '01-PD-060', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3282'),
(223, '01-PD-062', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3283'),
(224, '01-PD-064', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3284'),
(225, '01-PD-066', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3285'),
(226, '01-PD-072', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(227, '01-PD-073', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3286'),
(228, '01-PD-074', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3287'),
(229, '01-PD-075', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3288'),
(230, '01-PD-080', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3289'),
(231, '01-PD-082', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3290'),
(232, '01-PD-084', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3291'),
(233, '01-PD-085', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3292'),
(234, '01-PD-086', 'Diff. Pressure gauge LAF Disp.', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3293'),
(235, '01-PD-087', 'Diff. Pressure gauge LAF Disp.', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3294'),
(236, '01-PD-089', 'Differential Pressure Gauge Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3295'),
(237, '01-PD-090', 'Differential Pressure Gauge Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3296'),
(238, '01-PD-093', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3297'),
(239, '01-PD-094', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3298'),
(240, '01-PD-095', 'Diff. Pressure gauge Post cool 11', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3299'),
(241, '01-PD-098', 'Differential Pressure Gauge PC 12A', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3300'),
(242, '01-PD-100', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3301'),
(243, '01-PD-102', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3302'),
(244, '01-PD-103', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3303'),
(245, '01-PD-104', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3304'),
(246, '01-PD-105', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3305'),
(247, '01-PD-106', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(248, '01-PD-107', 'Differential Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3306'),
(249, '01-PD-108', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3307'),
(250, '01-PD-109', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3308'),
(251, '01-PD-111', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3309'),
(252, '01-PD-112', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3310'),
(253, '01-PD-113', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3311'),
(254, '01-PD-114', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3312'),
(255, '01-PD-115', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3313'),
(256, '01-PD-116', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3314'),
(257, '01-PD-117', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3315'),
(258, '01-PD-118', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3316'),
(259, '01-PD-119', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3317'),
(260, '01-PD-120', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3318'),
(261, '01-PD-121', 'Differential Pressure Gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3319'),
(262, '01-PD-122', 'Gauge Photohelic Control Alaram', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3320'),
(263, '01-PD-123', 'Gauge Photohelic Control Alrm AHU 8', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(264, '01-PD-124', 'Gauge Photohelic Control Alrm AHU 6', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(265, '01-PD-125', 'Gauge Photohelic Control Alrm AHUD1', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(266, '01-PH-002', 'PH meter Ion Bench Meter', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(267, '01-PH-003', 'pH Meter Mettler Toledo', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(268, '01-PI-001', 'Pressure Gauge Tabung Nitrogen', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3321'),
(269, '01-PI-002', 'Pressure gauge housing filter', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3322'),
(270, '01-PI-003', 'Pressure Gauge Tabung Nitrogen', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(271, '01-TH-009', 'Data Logger (Testo)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(272, '01-TH-012', 'Data Logger (thermohygrometer)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3323'),
(273, '01-TH-014', 'Thermohygrometer Testo 625', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3324'),
(274, '01-TH-018', 'Thermohygrometer Testo 625', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3325'),
(275, '01-TH-022', 'Data logger Thermohygrometer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3326'),
(276, '01-TH-023', 'Data logger Thermohygrometer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3327'),
(277, '01-TH-024', 'Thermohygrometer Testo 625', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3328'),
(278, '01-TH-025', 'Thermohygrometer Testo 625', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3329'),
(279, '01-TH-026', 'Thermohygrometer Testo 625', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3330'),
(280, '01-TH-027', 'thermohygrometer OMRON ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3331'),
(281, '01-TH-028', 'thermohygrometer OMRON ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3332'),
(282, '01-TH-029', 'thermohygrometer OMRON ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3333'),
(283, '01-TH-030', 'thermohygrometer OMRON ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3334'),
(284, '01-TH-031', 'Thermohygrometer Testo 625', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(285, '01-TH-032', 'Thermohygrometer Testo 625', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(286, '01-TI-001', 'Termometer APPA 51 ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3335'),
(287, '01-TI-002', 'Termocouple tipe K', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3336'),
(288, '01-TI-003', 'Termocouple tipe K', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3337'),
(289, '01-TM-085', 'Digital timer mesin washing', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(290, '01-TM-086', 'Digital timer mesin washing', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(291, '01-TM-112', 'Stopwatch Alba', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3338'),
(292, '01-TM-114', 'Stopwatch', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(293, '01-TM-115', 'Stopwatch', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(294, '01-VI-001', 'VACUUM TEST', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3339'),
(295, '02.01', 'Male Locker (Out)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(296, '02.01-02.82', 'BLF (QC BLF & WH BLF) Civil', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3340'),
(297, '02.02', 'Male Locker (In)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(298, '02.03', 'Corridor', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(299, '02.04', 'House keeping', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(300, '02.05', 'Canteen', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(301, '02.06', 'Printing Room', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(302, '02.07', 'Washing & Equipment Room', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(303, '02.08', 'Female Toilet ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(304, '02.09', '(Male)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(305, '02.10', '(Female)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(306, '02.11', 'Female Locker (In)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(307, '02.12', 'Female Locker (Out)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(308, '02.14', 'Canteen Hand Wash', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(309, '02.15', 'Clean Container & Equipment ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(310, '02.16', 'Dirty Container & Equipment ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(311, '02.17', 'Hall', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(312, '02.18', 'Airlock Sampling ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(313, '02.19', 'Locker Sampling', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(314, '02.20', 'Sampling Washing Room ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(315, '02.21', 'Sampling Room', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(316, '02.22', 'Material airlock', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(317, '02.23', 'Warehouse for RM & FG', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(318, '02.24', 'Male Toilet', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(319, '02.25', 'Janitor', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(320, '02.26', 'Hall & Stairs', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(321, '02.27', 'Musholla', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(322, '02.28', 'Flammable Reagent', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(323, '02.29', 'Non Flammable Reagent', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(324, '02.30', 'Incubator Room', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(325, '02.31', 'LAF Room', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(326, '02.32', 'Gowning Room', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(327, '02.34', 'Ruang timbang dan titrasi', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(328, '02.35', 'Dissolution Area', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(329, '02.37', 'Equipment QC-BLF1', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(330, '02.38', 'Equipment QC-BLF3', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(331, '02.39', 'Weighing', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(332, '02.40', 'Preparation QC lab', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(333, '02.41', 'Equipment QC - HPLC', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(334, '02.42', 'LAF Airlock ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(335, '02.43', 'Material Warehouse Airlock ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(336, '02.44', 'Sample Storage QC', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(337, '02.45', 'Bottle Staging ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(338, '02.46', 'Airlock Dry Syrup', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(339, '02.47', 'Bottle Purging', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(340, '02.50', '2nd Floor Hall', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(341, '02.51', 'Airlock 1A', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(342, '02.52', 'Airlock 1B', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(343, '02.53', 'Airlock 1C', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(344, '02.54', 'Material Airlock 2A', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(345, '02.55', 'Airlock 2B', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(346, '02.56', 'Staging Raw Material', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(347, '02.57', 'Dispensing/Weighing', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(348, '02.58', 'Granulation', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(349, '02.59', 'Drying', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(350, '02.60', 'Tableting', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(351, '02.61', 'Coating', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(352, '02.62', 'Capsule Filling', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(353, '02.63', 'Slugging', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(354, '02.64', 'Mixing/Blending Dry Syrup', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(355, '02.65', 'WIP', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(356, '02.66', 'IPC', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(357, '02.67', 'Supervisor & Administration Room', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(358, '02.68', 'Clean Container Room', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(359, '02.69', 'Primary Packaging 1 Bottle Filling', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(360, '02.70', 'Primary Packaging 2 Stripping', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(361, '02.71', 'Primary Packaging 3 Blistering', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(362, '02.72', 'Primary Packaging 4 Stripping 2', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(363, '02.73', 'Washing Room', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(364, '02.74', 'Corridor', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(365, '02.75', 'Filling Dry Syrup', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(366, '02.76-1', 'Secondary Packaging Area', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(367, '02.76-2', 'Secondary Packaging 1', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(368, '02.76-3', 'Secondary Packaging 2', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(369, '02.76-4', 'Secondary Packaging 3', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(370, '02.76-5', 'Secondary Packaging 4', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(371, '02.77', 'Administration', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(372, '02.78', 'Lift for Material', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(373, '02.79', 'Toilet 1', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(374, '02.80', 'Toliet 2', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(375, '02.81', 'Airlock 4', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(376, '02.82', 'Airlock 3', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(377, '02.83', 'Airlock Bottle Purging', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(378, '02-AT-002', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3341'),
(379, '02-AT-003', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3342'),
(380, '02-AT-004', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3343'),
(381, '02-AT-005', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3344'),
(382, '02-AT-006', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3345'),
(383, '02-AT-008', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3346'),
(384, '02-AT-011', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3347'),
(385, '02-AT-012', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3348'),
(386, '02-AT-013', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3349'),
(387, '02-AT-014', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3350'),
(388, '02-AT-015', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3351'),
(389, '02-AT-016', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3352');
INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(390, '02-AT-017', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3353'),
(391, '02-AT-018', 'Anak timbangan kelas M1 PP', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3354'),
(392, '02-AT-019', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3355'),
(393, '02-AT-020', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3356'),
(394, '02-AT-021', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3357'),
(395, '02-AT-022', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3358'),
(396, '02-AT-023', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3359'),
(397, '02-AT-024', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3360'),
(398, '02-AT-025', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3361'),
(399, '02-AT-026', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3362'),
(400, '02-AT-027', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3363'),
(401, '02-AT-028', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3364'),
(402, '02-AT-029', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3365'),
(403, '02-AT-030', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3366'),
(404, '02-AT-031', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3367'),
(405, '02-AT-032', 'Kalibrasi Anak Timbangan B (F2 )', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3368'),
(406, '02-CP-001', 'Caliper/ Sigmat digital', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(407, '02-GB-001', 'Gauge Block', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(408, '02-HT-001', 'Hardness Tester Erweka TBH 300', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3369'),
(409, '02-MA-001-01', 'Moisture Analysis Mettler Thermometer', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(410, '02-MA-001-02', 'Moisture Analysis Mettler  Timbangan', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(411, '02-MS-004', 'Vibra 3000', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(412, '02-MS-006', 'Mettler PM 480', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3370'),
(413, '02-MS-008', 'Shinkodenshi CG 60K ', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(414, '02-MS-009', 'Avery Berkel G220', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(415, '02-MS-010', 'Vibra CG 50153 ', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(416, '02-MS-014', 'Sartorius / AG BSA 223 S-CW', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(417, '02-MS-020', 'Vibra/ HJ-K', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(418, '02-MS-021', 'Mettler Toledo 150S', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(419, '02-MS-022', 'Vibra SJ 1200E', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(420, '02-PD-001', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3371'),
(421, '02-PD-002', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3372'),
(422, '02-PD-003', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3373'),
(423, '02-PD-004', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3374'),
(424, '02-PD-005', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3375'),
(425, '02-PD-006', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3376'),
(426, '02-PD-007', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3377'),
(427, '02-PD-008', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3378'),
(428, '02-PD-009', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3379'),
(429, '02-PD-010', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3380'),
(430, '02-PD-012', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3381'),
(431, '02-PD-013', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3382'),
(432, '02-PD-014', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3383'),
(433, '02-PD-015', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3384'),
(434, '02-PD-016', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3385'),
(435, '02-PD-017', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3386'),
(436, '02-PD-018', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3387'),
(437, '02-PD-020', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3388'),
(438, '02-PD-021', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3389'),
(439, '02-PD-022', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3390'),
(440, '02-PD-023', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3391'),
(441, '02-PD-024', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3392'),
(442, '02-PD-025', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3393'),
(443, '02-PD-026', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3394'),
(444, '02-PD-027', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3395'),
(445, '02-PD-028', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3396'),
(446, '02-PD-032', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3397'),
(447, '02-PD-035', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3398'),
(448, '02-PD-036', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3399'),
(449, '02-PD-038', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3400'),
(450, '02-PD-039', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3401'),
(451, '02-PD-044', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3402'),
(452, '02-PD-047', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3403'),
(453, '02-PD-050', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3404'),
(454, '02-PD-052', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3405'),
(455, '02-PD-053', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3406'),
(456, '02-PD-054', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3407'),
(457, '02-PD-060', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3408'),
(458, '02-PD-061', 'Differential Pressure Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3409'),
(459, '02-TH-011', 'Data Logger (thermohygrometer)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(460, '02-TH-013', 'Thermohygrometer Testo 625', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3410'),
(461, '02-TM-001', 'Stop Watch', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3411'),
(462, '02-TM-007', 'Stopwatch ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(463, '02-TM-008', 'Stopwatch', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(464, '02-VI-001', 'Vaccum Test', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3412'),
(465, '03.01', 'Load-Unload RMPM Warehouse Area', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(466, '03.01-17.08', 'WH FG & RM building civil', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3413'),
(467, '03.02', 'Material Airlock RMPM', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(468, '03.03', 'Warehouse Office', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(469, '03.04', 'Hall & Stairs', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(470, '03.05', 'Janitor', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(471, '03.06', 'Ex-Gas Room', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(472, '03.07', 'Sampling Airlock ', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(473, '03.08', 'Sampling Locker ', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(474, '03.09', 'Sampling Ruang ', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(475, '03.10', 'Material Airlock', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(476, '03.11', 'General RM Warehouse', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(477, '03.12', 'AC RM Warehouse', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(478, '03-AT-001', 'Anak timbangan kelas M1 TPF', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3414'),
(479, '03-AT-002', 'Anak timbangan kelas M1 TPF', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3415'),
(480, '03-AT-003', 'Anak timbangan kelas M1 TPF', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3416'),
(481, '03-AT-004', 'Anak timbangan kelas M1 TPF', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3417'),
(482, '03-AT-005', 'Anak timbangan sekunder II TPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3418'),
(483, '03-AT-006', 'Anak timbangan sekunder II TPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3419'),
(484, '03-AT-007', 'Anak timbangan sekunder II TPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3420'),
(485, '03-AT-008', 'Anak timbangan sekunder II TPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3421'),
(486, '03-AT-009', 'Anak timbangan sekunder II TPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3422'),
(487, '03-AT-010', 'Anak timbangan sekunder II TPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3423'),
(488, '03-AT-011', 'Anak timbangan sekunder II TPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3424'),
(489, '03-AT-012', 'Anak timbangan sekunder II TPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3425'),
(490, '03-CP-001', 'Caliper Digimatic  (Mitutoyo)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-11-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(491, '03-MS-003', 'Avery HL120', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(492, '03-MS-004', 'Shinko Denshi 60kg', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(493, '03-MS-005', 'Vibra CG 300G', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(494, '03-MS-007', 'Jadever JDI-800', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(495, '03-MS-008', 'JADEVER (JDI-800)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(496, '03-MS-009', 'JADEVER (JDI-800)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(497, '03-MS-010', 'Jadever JDI-800', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(498, '03-MS-011', 'Jadever JDI-800', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(499, '03-MS-012', 'Jadever JDI-800', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(500, '03-PD-001', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3426'),
(501, '03-PD-004', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3427'),
(502, '03-PD-005', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3428'),
(503, '03-PD-006', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3429'),
(504, '03-PD-008', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3430'),
(505, '03-PD-009', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3431'),
(506, '03-PD-010', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3432'),
(507, '03-PD-011', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3433'),
(508, '03-PD-014', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3434'),
(509, '03-PD-015', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3435'),
(510, '03-PD-016', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3436'),
(511, '03-PD-017', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3437'),
(512, '03-PD-018', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3438'),
(513, '03-PD-020', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3439'),
(514, '03-PD-022', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3440'),
(515, '03-PD-023', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3441'),
(516, '03-PD-024', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3442'),
(517, '03-PD-025', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3443'),
(518, '03-PD-026', 'Differential Press Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3444'),
(519, '03-PD-027', 'Differential Press Gauge', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3445'),
(520, '03-pd-028', 'Gauge Photohelic Control Alrm', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3446'),
(521, '03-PH-002', 'pH Meter Mettler Toledo', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3447'),
(522, '03-PI-004', 'Pressure gauge (compressed air)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3448'),
(523, '03-PI-005', 'Pressure Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3449'),
(524, '03-TH-002', 'Thermohygrometer Testo 174 H', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3450'),
(525, '03-TH-003', 'Thermohygrometer Testo 174 H', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3451'),
(526, '03-TH-004', 'Thermohygrometer Testo 174 H', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3452'),
(527, '03-TI-001', 'Termometer APPA 51 ', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3453'),
(528, '03-TI-002', 'Termocouple tipe K', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3454'),
(529, '03-TI-003', 'Thermometer digital', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3455'),
(530, '03-TM-002', 'Stopwatch (Alba SW 01-x008)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3456'),
(531, '03-TM-008', 'Timer Digital ', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3457'),
(532, '03-TM-009', 'Timer Digital ', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3458'),
(533, '04-AT-004', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3459'),
(534, '04-AT-005', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(535, '04-AT-006', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3460'),
(536, '04-AT-008', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(537, '04-AT-009', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(538, '04-AT-010', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(539, '04-AT-012', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(540, '04-AT-013', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(541, '04-AT-014', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(542, '04-AT-016', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(543, '04-AT-017', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(544, '04-AT-018', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(545, '04-AT-020', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(546, '04-AT-021', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(547, '04-AT-022', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(548, '04-AT-024', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(549, '04-AT-025', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3461'),
(550, '04-AT-026', 'Anak timbangan kelas E2 Mikrobiologi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3462'),
(551, '04-CP-001', 'Digital Caliper', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(552, '04-FL-001', 'Anemometer TSI 9545', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(553, '04-GB-001-01', 'Gauge Block mitutoyo', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(554, '04-GB-001-02', 'Gauge Block mitutoyo', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(555, '04-GB-001-03', 'Gauge Block mitutoyo', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(556, '04-GB-001-04', 'Gauge Block mitutoyo', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(557, '04-GB-001-05', 'Gauge Block mitutoyo', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(558, '04-GB-001-06', 'Gauge Block mitutoyo', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(559, '04-GB-001-07', 'Gauge Block mitutoyo', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(560, '04-GB-001-08', 'Gauge Block mitutoyo', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(561, '04-GB-001-09', 'Gauge Block mitutoyo', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(562, '04-GB-001-10', 'Gauge Block mitutoyo', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(563, '04-MS-003', 'Sartorius BSA 62025', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3463'),
(564, '04-MS-004', 'Neraca Sartorius CPA26P', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3464'),
(565, '04-MS-005', 'Neraca Sartorious BSA822', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3465'),
(566, '04-MS-006', 'Neraca Sartorious BSA822', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3466'),
(567, '04-PC-003', 'MAS 100 (s.n. 65311)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3467'),
(568, '04-PC-004', 'MAS 100 (s.n. 79582)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3468'),
(569, '04-PC-005', 'Particle Counter TSI (93100926002)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3469');
INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(570, '04-PC-006', 'MAS 100 (s.n 103099)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3470'),
(571, '04-PC-007', 'Particle counter TSI (93101713001)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3471'),
(572, '04-PD-002', 'Diff. Pressure Gauge LAF Mikro', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3472'),
(573, '04-PD-003', 'Diff. Pressure Gauge LAF Mikro', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3473'),
(574, '04-PD-004', 'Differential Pressure Gauge Mikrobiologi', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3474'),
(575, '04-PD-005', 'Differential Pressure Gauge Mikrobiologi', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3475'),
(576, '04-PD-006', 'Differential Pressure Gauge Mikrobiologi', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3476'),
(577, '04-PD-007', 'Differential Pressure Gauge Mikrobiologi', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3477'),
(578, '04-PD-008', 'Differential Pressure Gauge Mikrobiologi', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3478'),
(579, '04-PD-009', 'Differential Pressure Gauge Mikrobiologi', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3479'),
(580, '04-PD-011', 'Differential Pressure Gauge Mikrobiologi', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3480'),
(581, '04-PD-012', 'Differential Pressure Gauge Mikrobiologi', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3481'),
(582, '04-PD-013', 'Differential Pressure Gauge Mikrobiologi', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3482'),
(583, '04-PD-014', 'Differential Pressure Gauge Mikrobiologi', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3483'),
(584, '04-PD-015', 'Differential Pressure Gauge Mikrobiologi', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3484'),
(585, '04-PD-016', 'Differential Pressure Gauge Mikrobiologi', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3485'),
(586, '04-PI-001', 'Pressure Gauge pada Drager', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(587, '04-TH-006', 'Data Logger (Inkubator EQ-0185)', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3486'),
(588, '04-TH-007', 'Data Logger (incubator EQ-0346)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3487'),
(589, '04-TH-008', 'Data Logger (Incubator EQ-0371)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3488'),
(590, '04-TH-009', 'Data Logger (Incubator Micro EQ-0183)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3489'),
(591, '04-TH-010', 'Data Logger (Gowning Micro Lab)', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3490'),
(592, '04-TH-012', 'Data Logger(Raw media Storage Lab Micro)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3491'),
(593, '04-TH-013', 'Data Logger (R. Incubator Micro)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3492'),
(594, '04-TH-014', 'Data Logger (Non Penicillin Test lab Micro)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3493'),
(595, '04-TH-015', 'Data Logger (cooling zone lab micro)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3494'),
(596, '04-TH-016', 'Data Logger (Media Storage)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3495'),
(597, '04-TH-017', 'Thermohygrometer Data Logger Testo 174 H', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3496'),
(598, '04-TH-018', 'Data Logger (r. Analyst Lab Micro)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3497'),
(599, '04-TH-019', 'Thermohygrometer Data Logger Testo 174 H', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3498'),
(600, '04-TH-021', 'Thermohygrometer Data Logger Testo 174 H', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3499'),
(601, '04-TH-022', 'Thermohygrometer Data Logger Testo 174 H', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3500'),
(602, '04-TI-002', 'Temperatur Recorder Yokogawa DR 130', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(603, '04-TI-011', 'Thermometer Memmert B15 (0793)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3501'),
(604, '04-TI-012', 'Thermometer Memmert B15 (0794)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3502'),
(605, '04-TI-014', 'Thermadatalogger (Refrigerator Goldstar)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(606, '04-TI-045', 'Thermadatalogger ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3503'),
(607, '04-TI-048', 'Data Logger Temperatur EQ-0181', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3504'),
(608, '04-TI-049', 'Data Logger Temperatur EQ-0182', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3505'),
(609, '04-TI-051', 'Termometer digital infrared', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3506'),
(610, '05.01', 'Granulat 1 ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(611, '05.01-05.92', 'MPF building civil', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3507'),
(612, '05.02', 'Tools Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(613, '05.03', 'Granulat 4 ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(614, '05.04', 'Granulat 5', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(615, '05.05', 'Engineering Area', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(616, '05.06', 'NA', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(617, '05.07', 'Coating 2', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(618, '05.08', 'Coating 2', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(619, '05.09', 'Dispensing 1', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(620, '05.10', 'Airlock 1 raw material', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(621, '05.11', 'Airlock 2 raw material', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(622, '05.12', 'Dispensing 2', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(623, '05.13', 'Blow and Suck', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(624, '05.14', 'Ruang Administrasi', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(625, '05.15', 'Supervisor room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(626, '05.16', 'Tools Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(627, '05.17', 'Staging primary packaging', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(628, '05.18-A', 'Granulat Sub-Corridor ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(629, '05.18-B', 'Capsule Sub-Corridor ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(630, '05.18-C', 'Airlock Primery Packaging', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(631, '05.18-D', 'Primery Packaging Corridor', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(632, '05.18-E', 'Liquid Corridor', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(633, '05.19', 'IPC', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(634, '05.20', 'Supv.& Administration Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(635, '05.21', 'Tabletting 3', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(636, '05.22', 'Tabletting 2', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(637, '05.23', 'Tabletting Sub.Corridor ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(638, '05.24', 'Tools Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(639, '05.25', 'Granulat 6', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(640, '05.26', 'Tabletting 1', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(641, '05.27', 'Tabletting 4', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(642, '05.28', 'Tabletting 5', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(643, '05.29', 'Tools Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(644, '05.30', 'Capsule Filling 1', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(645, '05.31', 'Capsule Filling 2', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(646, '05.32', 'Coating 1', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(647, '05.33', 'C/P Coating', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(648, '05.34', 'AHU coating', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(649, '05.35', 'Clean Container Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(650, '05.36', 'Dirty Container Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(651, '05.37', 'Washing Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(652, '05.38', 'Blistering Sub.Corridor ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(653, '05.39', 'Blistering 3', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(654, '05.40', 'Blistering 2', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(655, '05.41', 'Blistering 1', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(656, '05.42', 'Quarantine Secondary Packaging Area', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(657, '05.42 A', 'Secondary Packaging 1', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(658, '05.42 B', 'Secondary Packaging 2', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(659, '05.42 C', 'Secondary Packaging 3', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(660, '05.43', 'Supv.& Administration Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(661, '05.44-1', 'Printing1 Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(662, '05.44-2', 'Printing1 Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(663, '05.44-3', 'Printing1 Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(664, '05.45-1', 'Buffer Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(665, '05.45-2', 'Buffer Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(666, '05.45-3', 'Buffer Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(667, '05.46-1', 'Printing2 Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(668, '05.46-2', 'Printing2 Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(669, '05.46-3', 'Printing2 Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(670, '05.47-1', 'Buffer Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(671, '05.47-2', 'Buffer Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(672, '05.47-3', 'Buffer Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(673, '05.48-1', 'Primary Packaging 4', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(674, '05.48-2', 'Primary Packaging 4', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(675, '05.49', 'Primary Packaging 5', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(676, '05.50', 'Primary Packaging 6', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(677, '05.51', 'Primary Packaging 7', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(678, '05.52', 'Primary Packaging 8', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(679, '05.53 A', 'Secondary Packaging 4', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(680, '05.53 B', 'Secondary Packaging 5', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(681, '05.53 C', 'Secondary Packaging 6', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(682, '05.53 D', 'Secondary Packaging 7', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(683, '05.53 E', 'Secondary Packaging 8', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(684, '05.54', 'Hand Wash (Gray)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(685, '05.55', 'Locker Primer & Liquid', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(686, '05.56', 'Locker Solid & Dispensing', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(687, '05.57', 'Production Area', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(688, '05.58', 'Janitor', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(689, '05.59', 'Hand Wash (Black)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(690, '05.60', 'Filling Liquid (Jars)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(691, '05.63', 'Process Liquid ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(692, '05.64', 'Secondary Packaging Area Line 10', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(693, '05.65', 'Liquid Filling (Bottle) Line 10 ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(694, '05.66', 'Bottle Purging & Blowing', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(695, '05.67', 'Bottle Preparation Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(696, '05.68', 'Personal Airlock', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(697, '05.69', 'Locker', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(698, '05.70', 'Material Airlock ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(699, '05.72', 'Ex-Pantry', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(700, '05.73', 'MPF Meeting Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(701, '05.74', 'Production Staff', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(702, '05.75', 'Musholla', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(703, '05.82-1', 'Entrance', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(704, '05.82-2', 'Multi Production Facility', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(705, '05.82-3', 'MPF(Female)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(706, '05.83-1', 'Entrance', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(707, '05.83-2', 'Multi Production Facility MPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(708, '05.83-3', '(Male)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(709, '05.84', 'Drinking Room', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(710, '05.86', 'Production Manager & Staff', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(711, '05.88', 'Granulat 3/Oven', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(712, '05.89', 'WIP Psychotropic dan staging', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(713, '05.90', 'WIP Sub.Corridor ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(714, '05.91', 'WIP', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(715, '05.92', 'Pass Through', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(716, '05-AT-014', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(717, '05-AT-016', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(718, '05-AT-017', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(719, '05-AT-018', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(720, '05-AT-019', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(721, '05-AT-020', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(722, '05-AT-021', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(723, '05-AT-022', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(724, '05-AT-023', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(725, '05-AT-024', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(726, '05-AT-025', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(727, '05-AT-026', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(728, '05-AT-027', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(729, '05-AT-028', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(730, '05-AT-029', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(731, '05-AT-030', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(732, '05-AT-031', 'Anak timbangan kelas E2 lab kimia BLF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(733, '05-AT-039', 'Anak timbangan kelas E2 lab kimia MPF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3508'),
(734, '05-AT-040', 'Anak timbangan kelas E2 lab kimia MPF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3509'),
(735, '05-AT-041', 'Anak timbangan kelas E2 lab kimia MPF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3510'),
(736, '05-AT-043', 'Anak timbangan kelas E2 lab kimia MPF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3511'),
(737, '05-AT-044', 'Anak timbangan kelas E2 lab kimia MPF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3512'),
(738, '05-AT-045', 'Anak timbangan kelas E2 lab kimia MPF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3513'),
(739, '05-AT-047', 'Anak timbangan kelas E2 lab kimia MPF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3514'),
(740, '05-AT-048', 'Anak timbangan kelas E2 lab kimia MPF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3515'),
(741, '05-AT-049', 'Anak timbangan kelas E2 lab kimia MPF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3516'),
(742, '05-AT-051', 'Anak timbangan kelas E2 lab kimia MPF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3517'),
(743, '05-AT-052', 'Anak timbangan kelas E2 lab kimia MPF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3518'),
(744, '05-AT-053', 'Anak timbangan kelas E2 lab kimia MPF', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3519'),
(745, '05-AT-086', 'Anak timbangan kelas E2 ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3520'),
(746, '05-AT-087', 'Anak timbangan kelas E2 ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3521'),
(747, '05-AT-088', 'Anak timbangan kelas E2 ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3522'),
(748, '05-CP-001', 'Caliper Digimatic  (Mitutoyo) ', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-04-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(749, '05-FC-001', 'Furnace Thermoline', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(750, '05-FC-002', 'Furnace Thermoline', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2020-08-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(751, '05-GC-002', 'Gas Detector', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(752, '05-GC-003', 'Gas Detector', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(753, '05-GC-004', 'Gas Detector', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(754, '05-MM-001', 'Micrometer', 'ACT', 'QC2 ', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-06-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL);
INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(755, '05-MP-001-01', 'Melting Point Buchi B-540 - kenaikan suhu/menit', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(756, '05-MP-001-02', 'Melting Point Buchi B-540 - Temperatur', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(757, '05-MP-001-03', 'Melting Point Buchi B-540 - Titik lebur standar', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(758, '05-MP-002', 'Micropipet', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3523'),
(759, '05-MP-002-01', 'Melting Point Buchi B-560 - kenaikan suhu/menit', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3524'),
(760, '05-MP-002-02', 'Melting Point Buchi B-560 - Temperatur', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3525'),
(761, '05-MP-002-03', 'Melting Point Buchi B-560 - Titik lebur standar', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3526'),
(762, '05-MP-003', 'Micropipet', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3527'),
(763, '05-MP-004', 'Micropipet', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3528'),
(764, '05-MP-005', 'Micropipet', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3529'),
(765, '05-MP-006', 'Micropipet', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3530'),
(766, '05-MP-007', 'Micropipet', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3531'),
(767, '05-MS-002', 'Neraca Analitik Mettler Toledo AT - 261 ', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3532'),
(768, '05-MS-003', 'Neraca Analitik Mikro Mettler Toledo UMX2', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3533'),
(769, '05-MS-005', 'Neraca Analitik Semi Mikro Mettler Toledo', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3534'),
(770, '05-MS-007', 'Neraca Analitik  Mettler Toledo XS205DU', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3535'),
(771, '05-MS-008', 'Neraca Analitik Mettler Toledo XP 205', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3536'),
(772, '05-MS-010', 'Neraca Analitik Mettler Toledo XS 205 DU', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3537'),
(773, '05-MS-011', 'Neraca Mettler Toledo XP26DR', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3538'),
(774, '05-MS-012', 'Neraca Mettler Toledo XP26DR', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3539'),
(775, '05-MS-013', 'Neraca Analitik  Mettler Toledo XS2002S', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3540'),
(776, '05-MS-014', 'Sartorius BSA 822', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3541'),
(777, '05-MS-015', 'Sartorius BSA 822', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3542'),
(778, '05-PD-001', 'Differential Press Gauge (W05TAE2))', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3543'),
(779, '05-PD-002', 'Differential Press Gauge (W05TAL1)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3544'),
(780, '05-PD-003', 'Differential Press Gauge (W05TAE1)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3545'),
(781, '05-PD-004', 'Differential Press Gauge (W05TAL2))', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3546'),
(782, '05-PD-005', 'Differential Pressure gauge R.Sampling', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3547'),
(783, '05-PD-006', 'Differential Pressure gauge R.Sampling', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3548'),
(784, '05-PD-007', 'Diff.Pessure Gauge sampling QC BLF', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3549'),
(785, '05-PD-008', 'Differential Pressure gauge R.Sampling', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3550'),
(786, '05-PD-009', 'Differential Pressure gauge R.Sampling PP', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3551'),
(787, '05-PD-011', 'Differential Pressure Gauge Gauge', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3552'),
(788, '05-PD-012', 'Differential Pressure Gauge Gauge', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3553'),
(789, '05-PD-013', 'Differential Pressure Gauge Gauge', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(790, '05-PD-014', 'Differential Pressure Gauge Gauge', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3554'),
(791, '05-PH-002', 'pH meter Seven Easy S20K', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3555'),
(792, '05-PH-003', 'pH meter Seven Easy', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(793, '05-PL-002-01', 'Polarimeter AP-300 ', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3556'),
(794, '05-PL-002-02', 'Polarimeter AP-300 ', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3557'),
(795, '05-PM-001', 'Porositymeter', 'ACT', 'QC2 ', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3558'),
(796, '05-RE-001', 'Refractometer', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(797, '05-TC-001', 'TOC (by PT.Vision Teknik)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3559'),
(798, '05-TH-026', 'T Data Logger (chamber Autonics 1)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3560'),
(799, '05-TH-029', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3561'),
(800, '05-TH-038', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(801, '05-TH-039', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3562'),
(802, '05-TH-040', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3563'),
(803, '05-TH-041', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3564'),
(804, '05-TH-042', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3565'),
(805, '05-TH-044', 'Data Logger (Lab micro testing)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(806, '05-TH-045', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(807, '05-TH-046', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(808, '05-TH-047', 'Data Logger (Referigerator Plasma)', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3566'),
(809, '05-TH-048', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(810, '05-TH-049', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(811, '05-TH-050', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3567'),
(812, '05-TH-051', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3568'),
(813, '05-TH-052', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3569'),
(814, '05-TH-053', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3570'),
(815, '05-TH-054', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3571'),
(816, '05-TH-055', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3572'),
(817, '05-TH-056', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3573'),
(818, '05-TH-057', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3574'),
(819, '05-TH-058', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3575'),
(820, '05-TH-060', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3576'),
(821, '05-TH-061', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3577'),
(822, '05-TH-062', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3578'),
(823, '05-TH-063', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3579'),
(824, '05-TH-064', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(825, '05-TH-065', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3580'),
(826, '05-TH-066', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3581'),
(827, '05-TH-067', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3582'),
(828, '05-TH-069', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3583'),
(829, '05-TH-070', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3584'),
(830, '05-TH-071', 'Data Logger (Freezer)', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3585'),
(831, '05-TH-072', 'Data Logger (R. Flammable)', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(832, '05-TH-074', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3586'),
(833, '05-TH-075', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3587'),
(834, '05-TH-076', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3588'),
(835, '05-TH-077', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3589'),
(836, '05-TH-078', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3590'),
(837, '05-TH-079', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3591'),
(838, '05-TH-080', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3592'),
(839, '05-TH-081', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3593'),
(840, '05-TH-086', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(841, '05-TH-087', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(842, '05-TH-088', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3594'),
(843, '05-TH-089', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3595'),
(844, '05-TH-090', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3596'),
(845, '05-TH-091', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3597'),
(846, '05-TH-092', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3598'),
(847, '05-TI-005', 'Data Logger (thermohygrometer)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3599'),
(848, '05-TI-006', 'Termometer glass standard ASTM 12C', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3600'),
(849, '05-TI-010', 'T Data Logger (di  Refri Sharp QC)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3601'),
(850, '05-TI-013', 'Termometer U-40', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3602'),
(851, '05-TI-015', 'Termometer Brand Range I', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3603'),
(852, '05-TI-019', 'T Data Logger (di  Refri Sharp Plamacluster QC)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3604'),
(853, '05-TI-020', 'Data Logger (thermometer)', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3605'),
(854, '05-TI-023', 'Data Logger (thermometer)', 'ACT', 'QC2 ', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3606'),
(855, '05-TI-024', 'Data Logger (thermometer)', 'ACT', 'QC2 ', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3607'),
(856, '05-TI-025', 'Data Logger (thermometer)', 'ACT', 'QC2 ', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3608'),
(857, '05-TI-026', 'Data Logger (thermometer)', 'ACT', 'QC2 ', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3609'),
(858, '05-TM-007', 'Stopwatch', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3610'),
(859, '05-TM-008', 'Stopwatch', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3611'),
(860, '05-TM-010', 'Stopwatch Casio HS-1000', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3612'),
(861, '05-TM-011', 'Stopwatch Casio', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(862, '05-TM-012', 'Stopwatch Casio', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(863, '05-TR-003', 'KF Titrator ex Metrohm', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3613'),
(864, '05-TR-004', 'Titrator Metrohm 916 Ti-Touch', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3614'),
(865, '05-TR-005', 'KF Titrator Methrom', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3615'),
(866, '05-UV-001', 'Spektrofotometer UV 1700 Pharmaspec', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3616'),
(867, '05-UV-001-01', 'Spektrofotometer UV 1700 Repeatability', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3617'),
(868, '05-UV-001-02', 'Spektrofotometer UV 1700 - Stray Light', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3618'),
(869, '05-UV-001-03', 'Spektrofotometer UV 1700 - Wavelength Accuracy', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3619'),
(870, '05-UV-001-04', 'Spektrofotometer UV 1700 Repeatability', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3620'),
(871, '05-UV-001-05', 'Spektrofotometer UV 1700 - Resolusi', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3621'),
(872, '05-UV-001-06', 'Spektrofotometer UV 1700 - Baseline Stability', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3622'),
(873, '05-UV-001-07', 'Spektrofotometer UV 1700 - Baseline Flatness', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3623'),
(874, '05-UV-001-08', 'Spektrofotometer UV 1700 - Noise Level', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3624'),
(875, '05-UV-001-09', 'Spektrofotometer UV 1700 - Pemakaian Lampu', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3625'),
(876, '05-UV-001-10', 'Spektro UV 1700 Control Absorbance', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3626'),
(877, '05-UV-001-11', 'Spektrofotometer UV 1700 (Holmium oxide)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3627'),
(878, '05-UV-001-12', 'Spektrofotometer UV 1700 Stray Light', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3628'),
(879, '05-UV-001-13', 'Spektrofotometer UV 1700 Resolution', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3629'),
(880, '05-UV-001-14', 'Spektrofotometer UV 1700 - PQ by PT Ditek Jaya', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3630'),
(881, '05-UV-002', 'Spectrophotometry UV-Vis Agilent 8453 ', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3631'),
(882, '05-UV-002-01', 'Spektrofotometer Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3632'),
(883, '05-UV-002-02', 'Spektrofotometer Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3633'),
(884, '05-UV-002-03', 'Spektrofotometer Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3634'),
(885, '05-UV-002-04', 'Spektrofotometer Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3635'),
(886, '05-UV-002-05', 'Spektrofotometer Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3636'),
(887, '05-UV-002-06', 'Spektrofotometer Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3637'),
(888, '05-UV-002-07', 'Spektrofotometer Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3638'),
(889, '05-UV-002-08', 'Spektrofotometer Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3639'),
(890, '05-UV-002-09', 'Spektrofotometer Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3640'),
(891, '05-UV-002-10', 'Spektrofotometer Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3641'),
(892, '05-UV-002-11', 'Spektrofotometer Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3642'),
(893, '05-UV-002-12', 'Spektrofotometer Agilent', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3643'),
(894, '05-UV-004-01', 'Spektrofotometer FTIR Shimadzu-IR Spirit', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3644'),
(895, '05-UV-004-02', 'Spektrofotometer FTIR Shimadzu-IR Spirit', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3645'),
(896, '05-UV-004-03', 'Spektrofotometer FTIR Shimadzu-IR Spirit', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3646'),
(897, '05-UV-004-04', 'Spektrofotometer FTIR Shimadzu-IR Spirit', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3647'),
(898, '05-UV-004-05', 'Spektrofotometer FTIR Shimadzu-IR Spirit', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3648'),
(899, '05-VC-002-01', 'Viskometer Brookfield DV2TLV', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3649'),
(900, '05-VC-002-02', 'Viskometer Brookfield DV2TLV', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3650'),
(901, '06-AT-001', 'Anak Timbang 20 mg E2', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3651'),
(902, '06-AT-002', 'Anak Timbang 50 mg E2', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3652'),
(903, '06-AT-003', 'Anak Timbang 1 g E2', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3653'),
(904, '06-MS-005', 'Timbangan Mettler Toledo XP205', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3654'),
(905, '06-MS-006', 'Timbangan Sartorius ME 36 S', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3655'),
(906, '06-PH-001', 'pH meter seven easy', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3656'),
(907, '06-TH-002', 'THERMOHYGROMETER EXTECH IT server', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(908, '06-TH-006', 'Data Logger Chamber (EQ-0262)', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(909, '06-TH-013', 'Data logger testo 175-H1', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3657'),
(910, '06-TH-014', 'Data logger testo 175-H1', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3658'),
(911, '06-TH-015', 'Data logger testo 175-H1', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(912, '06-TH-016', 'Data logger testo 175-H1', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(913, '06-TH-017', 'Data logger testo 175-H', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3659'),
(914, '06-TH-018', 'Data logger testo 175-H', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3660'),
(915, '06-TH-064', 'Data Logger Testo 174H', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(916, '06-TI-003', 'Thermocouple', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3661'),
(917, '06-TI-004', 'Calibrator Bimetal-Thermometer 07267', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-05-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(918, '06-TI-005', 'Calibrator Bimetal-Thermometer 07353', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-05-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(919, '06-TI-006', 'Calibrator Bimetal-Thermometer 07431', 'ACT', 'QC', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-05-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(920, '06-TM-004-1', 'STOPWATCH CASIO HS-3 (FORMULASI)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3662'),
(921, '06-TM-004-2', 'STOPWATCH CASIO HS-3 (FORMULASI)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3663'),
(922, '06-TM-005-1', 'STOPWATCH CASIO HS-3 (FORMULASI)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3664'),
(923, '06-TM-005-2', 'STOPWATCH CASIO HS-3 (FORMULASI)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3665'),
(924, '06-UV-001-1', 'Atomic Absorption Spectrofotometer AA240FS', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3666'),
(925, '06-UV-001-2', 'Atomic Absorption Spectrofotometer AA240FS', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3667'),
(926, '06-UV-001-3', 'Atomic Absorption Spectrophotometry', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3668'),
(927, '06-UV-002', 'Spectrofotometer UV-Vis 1800 Shimadzu', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3669'),
(928, '06-UV-002-01', 'UV-VIS Spectro UV-1800 Photometric', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3670');
INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(929, '06-UV-002-02', 'UV-VIS Spectrofotometer UV-1800 Stray light', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3671'),
(930, '06-UV-002-03', 'UV-VIS Spectro UV-1800 Wavelength Accuracy', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3672'),
(931, '06-UV-002-04', 'UV-VIS Spectro UV-1800 Repeatability', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3673'),
(932, '06-UV-002-05', 'UV-VIS Spectrofotometer UV-1800 Resolusi', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3674'),
(933, '06-UV-002-06', 'UV-VIS Spectrofotometer UV-1800 Stability', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3675'),
(934, '06-UV-002-07', 'UV-VIS Spectrofotometer UV-1800 Flatness', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3676'),
(935, '06-UV-002-08', 'UV-VIS Spectrofotometer UV-1800 Noise Level', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3677'),
(936, '06-UV-002-09', 'UV-VIS Spectrofotometer UV-1800 Lampu', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3678'),
(937, '06-UV-002-10', 'UV-VIS Spectro UV-1800 Control Absorbance', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3679'),
(938, '06-UV-002-11', 'UV-VIS Spectror UV-1800 wavelength Holmium', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3680'),
(939, '06-UV-002-12', 'UV-VIS Spectro UV-1800 Stray Light', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3681'),
(940, '06-UV-002-13', ' Spectro UV-1800', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3682'),
(941, '07.01', 'Lobby', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(942, '07.01-07.23', 'Laboratorium Mikrobiology civil', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3683'),
(943, '07.02', 'Toilet', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(944, '07.03', 'Main Airlock', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(945, '07.04', 'Material Airlock', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(946, '07.05', 'Raw Media Storage', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(947, '07.06', 'Media Preparation', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(948, '07.07', 'Autoclave Loading', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(949, '07.08', 'Cooling Zone', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(950, '07.09', 'Corridor', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(951, '07.10', 'Media Storage', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(952, '07.11', 'Non Penicilin Testing', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(953, '07.12', 'Ex-PPIC Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(954, '07.13', 'Office', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(955, '07.14', 'Airlock 1 (In)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(956, '07.15', 'Airlock 2 (Out)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(957, '07.16', 'Hand Wash1 (In)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(958, '07.17', 'Hand Wash2 (Out)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(959, '07.18', 'Gray Corridor', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(960, '07.19', 'Incubation Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(961, '07.20', 'Administration Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(962, '07.21', 'XRD Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(963, '07.22', 'Washing Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(964, '07.23', 'Administration Room', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(965, '07-AT-001', 'Anak Timbang 1 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3684'),
(966, '07-AT-002', 'Anak Timbang 2 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3685'),
(967, '07-AT-003', 'Anak Timbang 2 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3686'),
(968, '07-AT-004', 'Anak Timbang 5 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3687'),
(969, '07-AT-005', 'Anak Timbang 10 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3688'),
(970, '07-AT-006', 'Anak Timbang 20 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3689'),
(971, '07-AT-007', 'Anak Timbang 20 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3690'),
(972, '07-AT-008', 'Anak Timbang 50 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3691'),
(973, '07-AT-009', 'Anak Timbang 100 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3692'),
(974, '07-AT-010', 'Anak Timbang 200 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3693'),
(975, '07-AT-011', 'Anak Timbang 200 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3694'),
(976, '07-AT-012', 'Anak Timbang 500 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3695'),
(977, '07-AT-013', 'Anak Timbang 1 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3696'),
(978, '07-AT-014', 'Anak Timbang 2 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3697'),
(979, '07-AT-015', 'Anak Timbang 2 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3698'),
(980, '07-AT-016', 'Anak Timbang 5 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3699'),
(981, '07-AT-017', 'Anak Timbang 10 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3700'),
(982, '07-AT-018', 'Anak Timbang 20 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3701'),
(983, '07-AT-019', 'Anak Timbang 20 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3702'),
(984, '07-AT-020', 'Anak Timbang 50 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3703'),
(985, '07-AT-021', 'Anak Timbang 100 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3704'),
(986, '07-AT-022', 'Anak Timbang 200 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3705'),
(987, '07-AT-023', 'Anak Timbang 200 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3706'),
(988, '07-AT-024', 'Anak Timbang 1 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3707'),
(989, '07-AT-025', 'Anak Timbang 2 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3708'),
(990, '07-AT-026', 'Anak Timbang 2 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3709'),
(991, '07-AT-027', 'Anak Timbang 5 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3710'),
(992, '07-AT-028', 'Anak Timbang 10 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3711'),
(993, '07-AT-029', 'Anak Timbang 20 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3712'),
(994, '07-AT-030', 'Anak Timbang 20 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3713'),
(995, '07-AT-031', 'Anak Timbang 50 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3714'),
(996, '07-AT-032', 'Anak Timbang 100 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3715'),
(997, '07-AT-033', 'Anak Timbang 200 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3716'),
(998, '07-AT-034', 'Anak Timbang 200 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3717'),
(999, '07-AT-035', 'Anak Timbang 500 mg F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3718'),
(1000, '07-AT-036', 'Anak Timbang 1 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3719'),
(1001, '07-AT-037', 'Anak Timbang 2 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3720'),
(1002, '07-AT-038', 'Anak Timbang 2 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3721'),
(1003, '07-AT-039', 'Anak Timbang 5 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3722'),
(1004, '07-AT-040', 'Anak Timbang 10 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3723'),
(1005, '07-AT-041', 'Anak Timbang 20 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3724'),
(1006, '07-AT-042', 'Anak Timbang 20 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3725'),
(1007, '07-AT-043', 'Anak Timbang 50 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3726'),
(1008, '07-AT-044', 'Anak Timbang 100 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3727'),
(1009, '07-AT-045', 'Anak Timbang 200 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3728'),
(1010, '07-AT-046', 'Anak Timbang 200 g F1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3729'),
(1011, '07-AT-047', 'Anak Timbang 10 kg M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3730'),
(1012, '07-AT-048', 'Anak Timbang 5 Kg M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3731'),
(1013, '07-AT-049', 'Anak Timbang 1 Kg M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3732'),
(1014, '07-CO-002', 'AUTENTO', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 60, 0, NULL, '0.00', '0.00', '2020-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1015, '07-MS-001', 'Timbangan', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3733'),
(1016, '07-MS-002', 'Timbangan Mekanik Avery', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3734'),
(1017, '07-MS-003', 'Timbangan Mekanik Avery', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3735'),
(1018, '07-MS-004', 'Timbangan Mekanik Molenschot', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3736'),
(1019, '07-MS-005', 'Timbangan Mekanik Molenschot', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3737'),
(1020, '07-TH-012', 'Data Logger (thermohygrometer)', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3738'),
(1021, '07-TH-016', 'Data Logger (thermohygrometer)', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3739'),
(1022, '07-TH-017', 'Data Logger (Inkubator)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3740'),
(1023, '07-TH-018', 'Data Logger (thermohygrometer)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3741'),
(1024, '07-TH-019', 'Data Logger (thermohygrometer)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3742'),
(1025, '07-TH-020', 'Data Logger (Gudang RM Psikotropika)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3743'),
(1026, '07-TH-021', 'Data Logger (Referigerator FG EQ-0473)', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3744'),
(1027, '07-TH-022', 'Data Logger (Referigerator RM EQ-0243)', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3745'),
(1028, '07-TH-023', 'Data Logger (Referigerator FG EQ-0244)', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3746'),
(1029, '07-TH-024', 'Data Logger (Gudang RMPM)', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3747'),
(1030, '07-TH-025', 'Data Logger (Gudang RMPM)', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3748'),
(1031, '07-TH-026', 'Thermohygrometer Data Logger Testo 174 H', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3749'),
(1032, '07-TH-027', 'Thermohygrometer Data Logger Testo 174 H', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3750'),
(1033, '07-TH-028', 'Data Logger (Testo)', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1034, '07-TH-029', 'Data Logger (Testo)', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1035, '07-TH-030', 'Data Logger (Testo)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1036, '07-TH-031', 'Data Logger (Testo)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1037, '07-TH-032', 'Data Logger (Testo)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1038, '08-CC-001', 'Compact Calibrator Yokogawa ', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1039, '08-CP-003', 'Caliper Digimatic (Mitutoyo) digital CD-8\"CS', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1040, '08-CP-005', 'Digimatic Caliper', 'ACT', 'QC2 ', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-09-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1041, '08-ET-001', 'Digital Earth tester', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2020-06-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1042, '08-FL-002', 'Balometer Alnor APM 150', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2021-09-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1043, '08-FL-003', 'Flow meter for Tangkiki Solar I', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 60, 0, NULL, '0.00', '0.00', '2020-06-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1044, '08-GB-001', 'Gauge Block 3mm', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3751'),
(1045, '08-GB-002', 'Gauge Block 5mm', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3752'),
(1046, '08-GB-003', 'Gauge Block 10mm', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3753'),
(1047, '08-GC-001', 'Gas Detector (Polytron 5700) AHU 10', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3754'),
(1048, '08-GC-002', 'Gas Detector (Polytron 5700) AHU 13', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3755'),
(1049, '08-GC-003', 'Gas Detector (Polytron 5700) AHU 04', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3756'),
(1050, '08-GC-004', 'Gas Detector (Polytron 5700) AHU 06', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3757'),
(1051, '08-IT-001', 'Integrity Tester (20867)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1052, '08-PD-005', 'Differential Pressure Gauge Digital', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3758'),
(1053, '08-PD-007', 'Differential Pressure Gauge Digital', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3759'),
(1054, '08-PH-001', 'PH meter portable Hanna Instrument', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3760'),
(1055, '08-PI-001', 'Pressure gauge Budenbergh ', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1056, '08-PI-002', 'Pressure transmitter WIKA ', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3761'),
(1057, '08-PI-023', 'Pressure Gauge PW system', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3762'),
(1058, '08-PI-024', 'Pressure Gauge PW system', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3763'),
(1059, '08-PI-025', 'Digital Pressure Gauge', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1060, '08-RT-003', 'Tachometer Constant', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3764'),
(1061, '08-TH-002', 'Thermohygrometer Hygropalm', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3765'),
(1062, '08-TH-003', 'Thermohygrometer Humiport 20 E+E', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1063, '08-TH-004', 'Thermohygrometer Calibrator Edgtech', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3766'),
(1064, '08-TH-005', 'Thermohygrometer Data Logger Testo', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3767'),
(1065, '08-TH-006', 'Thermohygrometer Calibrator Edgtech', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3768'),
(1066, '08-TI-001', 'Termometer APPA 51 ', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3769'),
(1067, '08-TI-002', 'Temperature Dry Well WIKA', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3770'),
(1068, '08-TI-004', 'Temperature Dry Well Kaye LTR-140', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3771'),
(1069, '08-TI-005', 'Thermocouple probe sensor tipe K ', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1070, '08-TI-007', 'Thermocouple probe sensor tipe K ', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3772'),
(1071, '08-TI-008', 'Thermocouple surface sensor tipe K ', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1072, '08-TI-010', 'Termocouple only', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3773'),
(1073, '08-TI-011', 'Termocouple only', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3774'),
(1074, '08-TI-012', 'Termocouple only', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3775'),
(1075, '08-TI-019', 'Termometer tipe K', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3776'),
(1076, '08-TI-021', 'Termometer Infrared', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3777'),
(1077, '08-TI-022', 'Thermal Imager Fluke', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3778'),
(1078, '08-TM-001', 'Stopwatch Casio HS-1000', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3779'),
(1079, '08-VI-001', 'Vaccuum transmitter WIKA ', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3780'),
(1080, '09.01', 'Tools Room', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1081, '09.01-09.36', 'TPF building civil', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3781'),
(1082, '09.02', 'WIP + WIP Psikotropic', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1083, '09.03', 'Mixing Room', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1084, '09.04', 'Container storage room', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1085, '09.05', 'Primary Packaging Storage', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1086, '09.06', 'Corridor', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1087, '09.07', 'Washing Room', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1088, '09.08', 'Clean Container & Equipment ', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1089, '09.09', 'Material Airlock 2', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1090, '09.10', 'Janitor', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1091, '09.11', 'Material Airlock 1', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1092, '09.12', 'Hall', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1093, '09.13', 'Filling Room 1', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1094, '09.14', 'Filling Room 2', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1095, '09.15', 'Secondary packaging area', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1096, '09.16', 'Airlock Material ', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1097, '09.17', 'Staging', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1098, '09.18', 'Serialization Carton', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1099, '09.19', 'Production Airlock', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1100, '09.20', 'Gowning Gray', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1101, '09.21', 'Hand Wash (Gray)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1102, '09.22', '(Male)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1103, '09.23', 'Male Gowning', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1104, '09.24', 'Male Corridor', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1105, '09.25', 'Janitor', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1106, '09.26', 'Urinoir', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1107, '09.27', 'Male Toilet', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1108, '09.28', 'Supv.& Manager Room', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1109, '09.29', 'Staff Room', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1110, '09.30', 'Hall & Stairs', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL);
INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(1111, '09.31', 'Female Corridor', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1112, '09.32', 'Female Toilet 1', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1113, '09.33', 'Female Toilet 2', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1114, '09.34', 'Female Gowning', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1115, '09.35', '(Female)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'UTY', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1116, '09-GC-001', 'Gas Detector', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3782'),
(1117, '09-GC-002', 'Gas Detector', 'ACT', 'EHS', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3783'),
(1118, '09-LUX-003-01', 'Lux Meter (LM-8000A)', 'ACT', 'EHS', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1119, '09-LUX-003-02', 'Lux Meter (LM-8000A)', 'ACT', 'EHS', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1120, '09-PH-001', 'PH Meter', 'ACT', 'EHS', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1121, '09-PI-001', 'Pressure Gauge Diesel Hydrant 1', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3784'),
(1122, '09-PI-003', 'Pressure Gauge electrical hydrant 1', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3785'),
(1123, '09-PI-006', 'Pressure Gauge (Workshop ENG)', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3786'),
(1124, '09-PI-017', 'Pressure Gauge Hydrant elektrik 3', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3787'),
(1125, '09-SL-003', 'Sound Level meter (SL-4010)', 'ACT', 'EHS', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1126, '10-AT-001', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3788'),
(1127, '10-AT-002', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3789'),
(1128, '10-AT-003', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3790'),
(1129, '10-AT-004', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3791'),
(1130, '10-AT-005', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3792'),
(1131, '10-AT-006', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3793'),
(1132, '10-AT-007', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3794'),
(1133, '10-AT-008', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3795'),
(1134, '10-AT-009', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3796'),
(1135, '10-AT-010', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3797'),
(1136, '10-AT-011', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3798'),
(1137, '10-AT-012', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3799'),
(1138, '10-AT-013', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3800'),
(1139, '10-AT-014', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3801'),
(1140, '10-AT-015', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3802'),
(1141, '10-AT-016', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3803'),
(1142, '10-AT-017', 'Anak timbangan kelas M1', 'ACT', 'WH', NULL, NULL, 'Eksternal', NULL, NULL, 'DISP', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3804'),
(1143, '10-IT-001', 'Integrity Tester (21596)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1144, '10-TH-036', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3805'),
(1145, '10-TH-037', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3806'),
(1146, '10-TH-038', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3807'),
(1147, '10-TH-039', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3808'),
(1148, '10-TH-040', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3809'),
(1149, '10-TH-041', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3810'),
(1150, '10-TH-042', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3811'),
(1151, '10-TH-043', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3812'),
(1152, '10-TH-044', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3813'),
(1153, '10-TH-045', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3814'),
(1154, '10-TH-046', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3815'),
(1155, '10-TH-047', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3816'),
(1156, '10-TH-048', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3817'),
(1157, '10-TH-049', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3818'),
(1158, '10-TH-050', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3819'),
(1159, '10-TH-051', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1160, '10-TH-052', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3820'),
(1161, '10-TH-053', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3821'),
(1162, '10-TH-054', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3822'),
(1163, '10-TH-055', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3823'),
(1164, '10-TH-057', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1165, '10-TH-058', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3824'),
(1166, '10-TH-060', 'Data Logger (thermohygrometer)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3825'),
(1167, '21.201-21.220', 'QC Lantai III building civil', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3826'),
(1168, '21.301-21.331', 'QC Lantai II civil', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3827'),
(1169, 'EQ-0001', 'Fitzmill I Putaran', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3828'),
(1170, 'EQ-0001-RT-001', 'Fitzmill I Putaran', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3829'),
(1171, 'EQ-0002', 'FITMILL II ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3830'),
(1172, 'EQ-0002-RT-001', 'FITMILL II ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1173, 'EQ-0003', 'Bear Mixer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3831'),
(1174, 'EQ-0003-RT-001', 'BEAR MIXER Putaran', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3832'),
(1175, 'EQ-0003-TM-001', 'BEAR MIXER Timer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3833'),
(1176, 'EQ-0004', 'Pharma matrix granulator TK Fielder', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3834'),
(1177, 'EQ-0004-PI-001', 'TK FIELDER Impeller Seal', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3835'),
(1178, 'EQ-0004-PI-002', 'TK FIELDER Granulator Seal', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3836'),
(1179, 'EQ-0004-PI-003', 'TK FIELDER Liquid pot. Sprayer ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3837'),
(1180, 'EQ-0004-PI-004', 'TK FIELDER Granulator drive seal', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3838'),
(1181, 'EQ-0004-PI-005', 'TK FIELDER Impeller drive Seal', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3839'),
(1182, 'EQ-0004-RT-001', 'TK FIELDER Putaran', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3840'),
(1183, 'EQ-0004-RT-002', 'TK FIELDER Putaran', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3841'),
(1184, 'EQ-0004-TM-001', 'TK FIELDER Timer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3842'),
(1185, 'EQ-0005', 'Frewitt dry milling ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3843'),
(1186, 'EQ-0005-RT-001', 'FREWITT Putaran', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3844'),
(1187, 'EQ-0006-01', 'FBD Huttlin', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3845'),
(1188, 'EQ-0006-02', 'Mesin FBD Huttlin', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3846'),
(1189, 'EQ-0006-FL-001', 'FBD Huttlin  Air volumeter (Hontz)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1190, 'EQ-0006-FL-002', 'FBD Huttlin Spray rate (Endress Hautser)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1191, 'EQ-0006-GC-001', 'FBD Huttlin  Gas concentration', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3847'),
(1192, 'EQ-0006-PD-003', 'FBD Huttlin  Diff Pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1193, 'EQ-0006-PD-004', 'FBD Huttlin  Diff Pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1194, 'EQ-0006-PD-005', 'FBD Huttlin  Diff Pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1195, 'EQ-0006-PD-006', 'FBD Huttlin  Diff Pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1196, 'EQ-0006-PD-007', 'FBD Huttlin  Diff Pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1197, 'EQ-0006-PD-008', 'FBD Huttlin  Diff Pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1198, 'EQ-0006-PD-009', 'FBD Huttlin  Diff Pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1199, 'EQ-0006-PD-010', 'FBD Huttlin  Diff Pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1200, 'EQ-0006-PI-003', 'FBD Huttlin Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1201, 'EQ-0006-PI-004', 'FBD Huttlin Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1202, 'EQ-0006-PI-005', 'FBD Huttlin Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1203, 'EQ-0006-PI-006', 'FBD Huttlin Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1204, 'EQ-0006-PI-007', 'FBD Huttlin Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1205, 'EQ-0006-PI-008', 'FBD Huttlin Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1206, 'EQ-0006-PI-009', 'FBD Huttlin Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1207, 'EQ-0006-PI-010', 'FBD Huttlin Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1208, 'EQ-0006-TH-001', 'FBD Huttlin  Outlet air humidity', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1209, 'EQ-0006-TI-001', 'FBD Huttlin  Inlet air temp', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1210, 'EQ-0006-TI-002', 'FBD Huttlin  Inlet air temperature', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1211, 'EQ-0006-TI-003', 'FBD Huttlin Product temperature', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1212, 'EQ-0006-TI-004', 'FBD Huttlin  Outlet air temperature', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1213, 'EQ-0007-01', 'Oven Lytzen', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'OVEN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3848'),
(1214, 'EQ-0007-02', 'Mesin Oven Lytzen', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'OVEN', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3849'),
(1215, 'EQ-0007-TI-001', 'OVEN LYTZEN Thermometer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3850'),
(1216, 'EQ-0007-TM-001', 'OVEN LYTZEN Timer pre-Drying', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3851'),
(1217, 'EQ-0007-TM-002', 'OVEN LYTZEN Timer heat-treatment', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3852'),
(1218, 'EQ-0009', 'Jenn Chiang', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'TAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3853'),
(1219, 'EQ-0009-01', 'Jenn Chiang Fill depth', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1220, 'EQ-0009-02', 'Jenn Chiang Pre-pressure', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1221, 'EQ-0009-03', 'Jenn Chiang Main Pressure', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1222, 'EQ-0009-04', 'Jenn Chiang Fill Depth displacement', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1223, 'EQ-0009-05', 'Jenn Chiang Pre-pressure station wall', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1224, 'EQ-0009-06', 'Jenn Chiang Main-pressure station wall', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1225, 'EQ-0009-RT-001', 'Jenn Chiang', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1226, 'EQ-0009-VM-001', 'Vacuum machine for Jenn Chiang JC-DSH-39B', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3854'),
(1227, 'EQ-0010', 'Capsule Filling Machine Sejong SF100N', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'CAP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3855'),
(1228, 'EQ-0010-PI-001', 'Caps Sejong SF100N Press gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3856'),
(1229, 'EQ-0010-PI-002', 'Caps Sejong SF100N Press gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3857'),
(1230, 'EQ-0010-PI-003', 'Caps Sejong SF100N Pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3858'),
(1231, 'EQ-0010-PI-004', 'Caps Sejong SF100N Pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3859'),
(1232, 'EQ-0010-PI-005', 'Caps Sejong SF100N Pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3860'),
(1233, 'EQ-0010-PI-006', 'Caps Sejong SF100N Pressure Powder', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3861'),
(1234, 'EQ-0010-PI-007', 'Caps Sejong SF100N Pressure Powder', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3862'),
(1235, 'EQ-0010-VI-001', 'Sejong Pressure gauge vacum pump', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3863'),
(1236, 'EQ-0010-VM-001', 'Vacuum machine for Sejong SF100', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3864'),
(1237, 'EQ-0011', 'Digital Metal Detector-3 (for Kilian RTS-20)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3865'),
(1238, 'EQ-0012', 'IBC Blender Servolift', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3866'),
(1239, 'EQ-0012-RT-001', 'Servolift RPM meter', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1240, 'EQ-0012-TM-001', 'Servolift Timer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1241, 'EQ-0013', 'Digital Metal Detector-1 (Sejong SF100N-New)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3867'),
(1242, 'EQ-0014', 'Digital Metal Detector-2 (for Manesty BB-4)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3868'),
(1243, 'EQ-0016', 'Macofar MT 40 ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'CAP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3869'),
(1244, 'EQ-0016-VI-001', 'Macofar MT 40 Vacuum gauge ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3870'),
(1245, 'EQ-0016-VI-003', 'Macofar MT 40 Vacuum gauge ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3871'),
(1246, 'EQ-0017', 'KILLIAN RTS-20', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'TAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3872'),
(1247, 'EQ-0017-RT-001', 'KILLIAN RTS-20', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3873'),
(1248, 'EQ-0017-VM-001', 'Vacuum machine for Killian RTS 20', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3874'),
(1249, 'EQ-0018-01', 'Mesin Coating Nicomac', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'COAT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3875'),
(1250, 'EQ-0018-02', 'Mesin Coating NICOMAC', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'COAT', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3876'),
(1251, 'EQ-0018-FL-001', 'Nicomac Air flow rate calibration check ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3877'),
(1252, 'EQ-0018-PD-001', 'Nicomac Magnehelic AHU Inlet (HEPA filter)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1253, 'EQ-0018-PD-002', 'Nicomac Magnehelic AHU Inlet (HEPA filter)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1254, 'EQ-0018-PI-001', 'Nicomac Atomization pressure calibration', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3878'),
(1255, 'EQ-0018-PI-002', 'Nicomac flat jet pressure transmitter', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3879'),
(1256, 'EQ-0018-PI-003', 'Nicomac Drum negative pressure calibration', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3880'),
(1257, 'EQ-0018-RT-001', 'Nicomac Preistalic pump speed calibration', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3881'),
(1258, 'EQ-0018-RT-002', 'Nicomac Drum speed calibration check ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3882'),
(1259, 'EQ-0018-TI-001', 'Nicomac Product temp probe calibration', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3883'),
(1260, 'EQ-0018-TI-002', 'Nicomac Inlet air temp probe calibration', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3884'),
(1261, 'EQ-0018-TI-003', 'Nicomac Inlet visual air temp probe calibration', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3885'),
(1262, 'EQ-0018-TI-004', 'Nicomac Outlet air temp probe calibration', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3886'),
(1263, 'EQ-0018-VM-001', 'Vacuum machine for Nicomac Elite CL100', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3887'),
(1264, 'EQ-0019', 'IKA mixer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3888'),
(1265, 'EQ-0019-RT-001', 'IKA mixer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1266, 'EQ-0020', 'Mixer silverson BX', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3889'),
(1267, 'EQ-0020-RT-001', 'Silverson BX', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3890'),
(1268, 'EQ-0021', 'Ekato mixer ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3891'),
(1269, 'EQ-0021-RT-001', 'Ekato mixer Rpm Meter', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3892'),
(1270, 'EQ-0022', 'Frewitt dry milling ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3893'),
(1271, 'EQ-0022-RT-001', 'Frewitt dry milling Putaran', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1272, 'EQ-0024', 'Blistering Hoong A ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'BLISTER', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3894'),
(1273, 'EQ-0024-PI-001', 'HOONG A PRESSURE GAUGE', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1274, 'EQ-0024-TI-001', 'HOONG A SEALING JAW', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1275, 'EQ-0024-TI-002', 'HOONG A PREHEATER', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1276, 'EQ-0025', 'Blistering Uhlmann B1240', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'BLISTER', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3895'),
(1277, 'EQ-0025-PI-005', 'Uhlmann B 1240 Pressure gauge forming air', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1278, 'EQ-0025-TI-001', 'Uhlmann B 1240 Preheating sensor', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3896'),
(1279, 'EQ-0025-TI-002', 'Uhlmann B 1240 Sealing Station', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3897'),
(1280, 'EQ-0030', 'Cartoning Uhlmann C130', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'CARTON', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3898'),
(1281, 'EQ-0030-PI-001', 'Uhlmann C 130 Pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1282, 'EQ-0031', 'Ink-jet Printer-6 IMAJE S8 Master 1.1G', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3899'),
(1283, 'EQ-0032', 'MARCHESINI STRIPPING', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'STRIP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3900'),
(1284, 'EQ-0032-TI-001', 'MARCHESINI STRIPPINGTHERMOREGULATOR', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1285, 'EQ-0032-TI-002', 'MARCHESINI STRIPPINGTHERMOREGULATOR', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1286, 'EQ-0033', 'Mesin Strip sealing siebler 90', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'STRIP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3901');
INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(1287, 'EQ-0033-TI-001', 'SIEBLER 90 SEALING JAW KIRI', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1288, 'EQ-0033-TI-002', 'SIEBLER 90 SEALING JAW KANAN', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1289, 'EQ-0034', 'Strip sealing Uhlmann HS 40', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'STRIP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3902'),
(1290, 'EQ-0034-TI-001', 'Stripping Uhlmann HS 40 (sealing roll kiri)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1291, 'EQ-0034-TI-002', 'Stripping Uhlmann HS 40 (sealing roll kanan)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1292, 'EQ-0037', 'Shrink Tunnel Tamaru', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'SEAL', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3903'),
(1293, 'EQ-0037-TI-001 ', 'Shrink Tunnel Tamaru', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3904'),
(1294, 'EQ-0039', 'KK & KK Labeller Singgle side labelling', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LABEL', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3905'),
(1295, 'EQ-0039-CO-001', 'KK & KK Labeller Counter digital', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3906'),
(1296, 'EQ-0039-PI-001', 'KK & KK Labeller Singgle side labelling', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3907'),
(1297, 'EQ-0039-TI-001', 'KK & KK Labeller Singgle side labelling', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3908'),
(1298, 'EQ-0041', 'Tamaru Cartoning  ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'CARTON', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3909'),
(1299, 'EQ-0041-PI-001', 'Tamaru Cartoning Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3910'),
(1300, 'EQ-0041-VI-001', 'Tamaru Cartoning  Vacuum Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3911'),
(1301, 'EQ-0041-VI-002', 'Tamaru Cartoning  Vacuum Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3912'),
(1302, 'EQ-0042', 'Tamaru labelling machine', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LABEL', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3913'),
(1303, 'EQ-0042-PI-001', 'Tamaru labelling machine', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3914'),
(1304, 'EQ-0043', 'Air Purging Bottle', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'PURGE', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3915'),
(1305, 'EQ-0043-PI-001', 'Air Purging Bottle Pressure gauge 1', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3916'),
(1306, 'EQ-0043-PI-002', 'Air Purging Bottle Pressure gauge 2', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3917'),
(1307, 'EQ-0044', 'Filling + Capping Tamaru', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'CAP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3918'),
(1308, 'EQ-0044-PI-001', 'Filling + Capping Tamaru', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3919'),
(1309, 'EQ-0045', 'Mixing Tank AWECO SHF 73211-4 (600 liter)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3920'),
(1310, 'EQ-0045-MS-001', 'Mixing Tangki 600 L Volume dan load cell', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3921'),
(1311, 'EQ-0045-PI-001', 'Mixing Tangki 600 L Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3922'),
(1312, 'EQ-0045-RT-001', 'Mixing Tangki 600 L Rpm', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3923'),
(1313, 'EQ-0045-TI-001', 'Mixing Tangki 600 L Thermometer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3924'),
(1314, 'EQ-0045-VI-001', 'Mixing Tangki 600 L Vacuum gauge (critical)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3925'),
(1315, 'EQ-0046', 'Ekatomixer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3926'),
(1316, 'EQ-0046-RT-001', 'Ekatomixer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1317, 'EQ-0051', 'Vacuum Mixing Tank INDO-LAVAL 1600L', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3927'),
(1318, 'EQ-0051-MS-001', 'Mixing Tangki 2000 L Volume dan load cell', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3928'),
(1319, 'EQ-0051-PI-001', 'Mixing Tangki 2000 L Vacuum gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3929'),
(1320, 'EQ-0051-RT-001', 'Mixing Tangki 2000 L Rpm', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3930'),
(1321, 'EQ-0051-TI-001', 'Mixing Tangki 2000 L Thermometer RTD', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3931'),
(1322, 'EQ-0051-VI-001', 'Mixing Tangki 2000 L Vacuum gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3932'),
(1323, 'EQ-0056', 'EB mixer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3933'),
(1324, 'EQ-0056-RT-001', 'EB mixer Rpm Meter', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1325, 'EQ-0057', 'Mixer Silverson BXFP', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3934'),
(1326, 'EQ-0057-RT-001', 'Silverson BXFP', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3935'),
(1327, 'EQ-0058', 'Silverson Ex', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3936'),
(1328, 'EQ-0058-RT-001', 'Silverson Ex', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3937'),
(1329, 'EQ-0059', 'Ink Jet Printer IMAJE S8', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3938'),
(1330, 'EQ-0060', 'Granulator TK Fielder', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3939'),
(1331, 'EQ-0060-PI-001', 'Tk Fielder Pressure gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3940'),
(1332, 'EQ-0060-PI-002', 'Tk Fielder Pressure gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3941'),
(1333, 'EQ-0060-PI-003', 'Tk Fielder Pressure gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3942'),
(1334, 'EQ-0060-PI-004', 'Tk Fielder Pressure gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3943'),
(1335, 'EQ-0060-RT-001', 'Tk Fielder Rpm Impeler', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3944'),
(1336, 'EQ-0060-RT-002', 'Tk Fielder Rpm Granulator', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3945'),
(1337, 'EQ-0060-TM-001', 'Tk Fielder Timer', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3946'),
(1338, 'EQ-0061', 'Maren Mixer', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3947'),
(1339, 'EQ-0061-RT-001', 'Maren Mixer RPM', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3948'),
(1340, 'EQ-0061-TM-001', 'Maren Mixer Timer', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3949'),
(1341, 'EQ-0063', 'Fitzmill', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3950'),
(1342, 'EQ-0063-RT-001', 'Fitzmill', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1343, 'EQ-0064', 'Mesin tablet Killian Eifel', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'TAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3951'),
(1344, 'EQ-0064-RT-001', 'Killian Eifel RPM', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3952'),
(1345, 'EQ-0064-VM-001', 'Vacuum machine for Kilian RUI 47047', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3953'),
(1346, 'EQ-0065', 'Digital LOCK MET 30+ (for Jenn Chiang)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3954'),
(1347, 'EQ-0066-1', 'Mesin tablet Jenn Chiang ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'TAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3955'),
(1348, 'EQ-0066-2', 'Mesin tablet Jenn Chiang RPM', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1349, 'EQ-0066-01', 'Jenn Chiang RPM', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-05-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1350, 'EQ-0066-02', 'Jenn Chiang Fill depth', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-05-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1351, 'EQ-0066-03', 'Jenn Chiang Pre-pressure', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-05-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1352, 'EQ-0066-04', 'Jenn Chiang Main Pressure', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-05-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1353, 'EQ-0066-VM-001', 'Vacuum machine for Jenn Chiang JC-RT-16H', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3956'),
(1354, 'EQ-0068-1', 'IKA mixer', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3957'),
(1355, 'EQ-0068-2', 'EURO STAR ika mixer', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1356, 'EQ-0071', 'Stripping Machine HORN & NOACK TN-220 ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'STRIP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3958'),
(1357, 'EQ-0071-PI-001', 'Stripping HORN&NOACK TN-220 Pressure', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1358, 'EQ-0071-PI-002', 'Stripping HORN&NOACK TN-220 Pressure', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1359, 'EQ-0071-PI-003', 'Stripping HORN&NOACK TN-220 Pressure', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1360, 'EQ-0071-TI-001', 'Stripping Machine HORN & NOACK TN-220', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1361, 'EQ-0071-TI-002', 'Stripping Machine HORN & NOACK TN-220', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1362, 'EQ-0071-VM-001', 'Vacuum machine for Horn & Noack TN-220', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3959'),
(1363, 'EQ-0078-CO-001', 'King Counter', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 36, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3960'),
(1364, 'EQ-0081', 'Mesin Tropical Blistering Uhlmann B1240', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'BLISTER', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3961'),
(1365, 'EQ-0081-TI-001', 'Uhlmann B 1240 Sealing Station', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1366, 'EQ-0081-TI-002', 'Uhlmann B 1240 Preheating sensor', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1367, 'EQ-0081-VM-001', 'Vacuum machine for Uhlmann B1240-59/1620', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3962'),
(1368, 'EQ-0082', 'Tropical Blister (CP2) ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'BLISTER', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3963'),
(1369, 'EQ-0082-PI-001', 'Tropical Blister (CP2) Pressure gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3964'),
(1370, 'EQ-0082-TI-001', 'Tropical Blister (CP2) Termometer control', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3965'),
(1371, 'EQ-0085', 'Shrink Tunnel TAYI YEH', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'SEAL', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3966'),
(1372, 'EQ-0085-TI-001', 'Shrink Tunnel Infrared Ray', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3967'),
(1373, 'EQ-0087', 'Vacuum Mixing Plant LEXAMIX VMP-300', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3968'),
(1374, 'EQ-0087-PI-003', 'Lexamix Pressure gauge (compressed air)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3969'),
(1375, 'EQ-0087-PI-008', 'Lexamix Vacuum gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3970'),
(1376, 'EQ-0087-RT-001', 'Lexamix Homogenizer', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3971'),
(1377, 'EQ-0087-RT-002', 'Lexamix Scrapper', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3972'),
(1378, 'EQ-0087-RT-003', 'Lexamix Impeller', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3973'),
(1379, 'EQ-0087-RT-004', 'Lexamix Agitator', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3974'),
(1380, 'EQ-0087-TI-001', 'Lexamix Thermocontrol Wax Tank + RTD PT-100', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3975'),
(1381, 'EQ-0087-TI-003', 'Lexamix Thermocontrol VMP 300 + RTD PT-100', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3976'),
(1382, 'EQ-0087-VI-001', 'Lexamix  Vacuum Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1383, 'EQ-0089', 'Mixer IKA Ultra Turax', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3977'),
(1384, 'EQ-0089-RT-001', 'Mixer IKA Ultra Turax', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3978'),
(1385, 'EQ-0090', 'Mixing Machine IKA-WERKE RW47D', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3979'),
(1386, 'EQ-0090-RT-001', 'Mixing Machine IKA-WERKE RW47D', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3980'),
(1387, 'EQ-0092', 'CO.MA.DI.S C960 Cream Pressure Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'FILLING', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3981'),
(1388, 'EQ-0092-PI-005', 'CO.MA.DI.S C960 Cream Pressure Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3982'),
(1389, 'EQ-0094', 'Ink-jet Printer-5 IMAJE S8 Master 1.1G', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3983'),
(1390, 'EQ-0096', 'CKL multimixer ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'COAT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3984'),
(1391, 'EQ-0096-RT-001', 'CKL multimixer Rpm Meter', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1392, 'EQ-0096-RT-002', 'CKL multimixer Rpm Meter', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3985'),
(1393, 'EQ-0097-01', 'Coating Acelacota', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'COAT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3986'),
(1394, 'EQ-0097-02', 'Mesin Coating Accelacota', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'COAT', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3987'),
(1395, 'EQ-0097-PD-001', 'Diff Pressure Gauge AHU Acelacota', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1396, 'EQ-0097-PD-002', 'Diff Pressure Gauge AHU Acelacota', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1397, 'EQ-0097-PD-003', 'Diff Pressure Gauge AHU Acelacota', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1398, 'EQ-0097-PD-004', 'Differential Pressure Gauge AHU Acelacota', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1399, 'EQ-0097-PI-002', 'ACCELACOTA Air Regulator II', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3988'),
(1400, 'EQ-0097-PI-003', 'ACCELACOTA Presurre gauge Steam II', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3989'),
(1401, 'EQ-0097-PI-004', 'ACCELACOTA Presurre gauge ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3990'),
(1402, 'EQ-0097-PI-005', 'ACCELACOTA Presurre gauge ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3991'),
(1403, 'EQ-0097-RT-001', 'ACCELACOTA Pump rotation', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3992'),
(1404, 'EQ-0097-RT-002', 'ACCELACOTA Rotasi Pan', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3993'),
(1405, 'EQ-0097-TI-001', 'ACCELACOTA Thermometer Inlet', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3994'),
(1406, 'EQ-0097-TI-002', 'ACCELACOTA Thermometer Outlet', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3995'),
(1407, 'EQ-0097-VM-001', 'Vacuum Nilfisk', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1408, 'EQ-0098', 'Ink-jet Printer IMAJE S8 Master 1.1G', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3996'),
(1409, 'EQ-0099', 'Mixing Machine CKL-MULTIMIX 2103SV', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3997'),
(1410, 'EQ-0099-RT-001', 'Mixing Machine CKL-MULTIMIX 2103SV', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3998'),
(1411, 'EQ-0116', 'Mixing machine Silverson L2R', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-3999'),
(1412, 'EQ-0117', 'Imaje 9020', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4000'),
(1413, 'EQ-0118', 'Ink-jet Printer-4 IMAJE S-9020', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4001'),
(1414, 'EQ-0119', 'Digital Metal Detector-4 (for Sejong SF100N)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4002'),
(1415, 'EQ-0120', 'Digital Metal Detector-5 (for Jenn Chiang)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4003'),
(1416, 'EQ-0121', 'Digital Metal Detector-6 (for Jenn Chiang)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4004'),
(1417, 'EQ-0122', 'Mixer Hobart', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4005'),
(1418, 'EQ-0122-RT-001', 'HOBART Putaran', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1419, 'EQ-0122-TM-001', 'HOBART Timer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1420, 'EQ-0135', 'Electric Drilling Machine FIRST', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4006'),
(1421, 'EQ-0137', 'Grinding Machine MAKITA', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4007'),
(1422, 'EQ-0138', 'Cutting Machine', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4008'),
(1423, 'EQ-0139', 'Welding Machine DYNAWELD', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4009'),
(1424, 'EQ-0141', 'Vacuum Pump LOWENER', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4010'),
(1425, 'EQ-0142', 'Hakai Chiller', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4011'),
(1426, 'EQ-0142-TI-001', 'Termometer Hakai Chiller', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4012'),
(1427, 'EQ-0143', 'Shrink Tunnel HANN RONG HR-4020 ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'SEAL', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4013'),
(1428, 'EQ-0143-TI-001', 'Termometer shrink tunnel HANN RONG', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4014'),
(1429, 'EQ-0147-01', 'FRIABILITY Putaran', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1430, 'EQ-0147-02', 'FRIABILITY Timer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1431, 'EQ-0158-01', 'Sotax DT 2 DT - Mekanik', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1432, 'EQ-0158-02', 'Sotax DT 2 Jarak Stroke', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1433, 'EQ-0158-03', 'Sotax DT 2 Thermo Air Raksa', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1434, 'EQ-0159-01', 'Sotax F 2 Timer', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1435, 'EQ-0159-02', 'Sotax F 2 RPM', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1436, 'EQ-0177', 'Autoclave Hirayama', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4015'),
(1437, 'EQ-0177-PI-001', 'Autoclave Hirayama', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4016'),
(1438, 'EQ-0177-TI-001', 'Autoclave Hirayama', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1439, 'EQ-0178', 'Autoclave SYSTEC', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4017'),
(1440, 'EQ-0178-TI-001', 'Autoclave SYSTEC', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4018'),
(1441, 'EQ-0178-TI-002', 'Autoclave SYSTEC', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4019'),
(1442, 'EQ-0180-1', 'Incubator MEMMERT TV15B', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4020'),
(1443, 'EQ-0180-2', 'Incubator MEMMERT TV15B', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4021'),
(1444, 'EQ-018-01', 'Laminar Air Flow ASTROCEL', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4022'),
(1445, 'EQ-0181', 'Incubator MEMMERT B15', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4023'),
(1446, 'EQ-0181-TI-001', 'Sensor temperatur Memmert B40', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4024'),
(1447, 'EQ-0182-1', 'Incubator MEMMERT B40', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4025'),
(1448, 'EQ-0182-2', 'Incubator MEMMERT B40', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4026'),
(1449, 'EQ-0182-TI-001', 'Sensor temperatur Memmert B40', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4027'),
(1450, 'EQ-0183', 'Incubator Memmert BM800', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4028'),
(1451, 'EQ-0183-TI-001', 'Sensor temperatur Memmert B800 (2103)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1452, 'EQ-0184-TI-002', 'Sensor temperatur Heraeus KB600', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4029'),
(1453, 'EQ-0185', 'Incubator Haraeus KB 5060', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4030'),
(1454, 'EQ-0185-TI-001', 'Sensor temperatur Haraeus KB 5060', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1455, 'EQ-0186-01', 'Laminar Air Flow CLEMCO DF44R', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4031'),
(1456, 'EQ-0186-02', 'LAF Clemco', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4032'),
(1457, 'EQ-0187-02', 'LAF Astrocell', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4033'),
(1458, 'EQ-0190-01', 'Laminar Air Flow SCANLAF MARS', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4034'),
(1459, 'EQ-0190-02', 'LAF Biohazard Cabinet', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4035'),
(1460, 'EQ-0192', 'Oven Heraeus SUT 6120', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'OVEN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4036'),
(1461, 'EQ-0192-TI-001', 'Sensor temperatur Oven Heraeus SUT 6120', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4037'),
(1462, 'EQ-0192-TI-002', 'Termokopel ', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4038');
INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(1463, 'EQ-0193', 'Referigerator', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'REFRI', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4039'),
(1464, 'EQ-0193-TI-001', 'Cool storage Sensino', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1465, 'EQ-0200-TM-001', 'J. Engeisman (Timer), Tapp Density', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4040'),
(1466, 'EQ-0201', 'Disintregration Tester', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1467, 'EQ-0202-01', 'Fume Hood - Kecepatan Alir Udara', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4041'),
(1468, 'EQ-0202-02', 'Fume Hood - Pola Aliran Udara', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4042'),
(1469, 'EQ-0203-01', 'Fume Hood - Kecepatan Alir Udara', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4043'),
(1470, 'EQ-0203-02', 'Fume Hood - Pola Aliran Udara', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4044'),
(1471, 'EQ-0204-01', 'Fume Hood - Kecepatan Alir Udara', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4045'),
(1472, 'EQ-0204-02', 'Fume Hood - Pola Aliran Udara', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4046'),
(1473, 'EQ-0205-1', 'Fume Hood', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1474, 'EQ-0205-2', 'Fume Hood', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4047'),
(1475, 'EQ-0206', 'HPLC-Prominence 20AT ', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4048'),
(1476, 'EQ-0206-01', 'HPLC - Prominence 20AT - Flow Accuracy Test', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4049'),
(1477, 'EQ-0206-02', 'HPLC - Prominence 20AT - Komposisi Gradient', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4050'),
(1478, 'EQ-0206-03', 'HPLC - Prominence 20AT - Linieritas Autoinjektor', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4051'),
(1479, 'EQ-0206-04', 'HPLC - Prominence 20AT - Carry over', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4052'),
(1480, 'EQ-0206-05', 'HPLC - Prominence 20AT - Linieritas Autoinjektor', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4053'),
(1481, 'EQ-0206-06', 'HPLC - Prominence 20AT - panjang gelombang (int)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4054'),
(1482, 'EQ-0206-07', 'HPLC - Prominence 20AT - ? Gelombang (kafein)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4055'),
(1483, 'EQ-0206-08', 'HPLC - Prominence 20AT - Noise Level', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4056'),
(1484, 'EQ-0207-01', 'HPLC - Prominence 20AT - Flow Accuracy Test', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4057'),
(1485, 'EQ-0207-02', 'HPLC - Prominence 20AT - Komposisi Gradient', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4058'),
(1486, 'EQ-0207-03', 'HPLC - Prominence 20AT - Linieritas Autoinjektor', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4059'),
(1487, 'EQ-0207-04', 'HPLC - Prominence 20AT - Carry over', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4060'),
(1488, 'EQ-0207-05', 'HPLC - Prominence 20AT - Linieritas Autoinjektor', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4061'),
(1489, 'EQ-0207-06', 'HPLC - Prominence 20AT - ? Gelombang (internal)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4062'),
(1490, 'EQ-0207-07', 'HPLC - Prominence 20AT - ? Gelombang (kafein)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4063'),
(1491, 'EQ-0207-08', 'HPLC - Prominence 20AT - Noise Level', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4064'),
(1492, 'EQ-0208', 'HPLC-Prominence 20AT ', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4065'),
(1493, 'EQ-0208-01', 'HPLC - Prominence 20AT - Flow Accuracy Test', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4066'),
(1494, 'EQ-0208-02', 'HPLC - Prominence 20AT - Komposisi Gradient', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4067'),
(1495, 'EQ-0208-03', 'HPLC - Prominence 20AT - Linieritas Autoinjektor', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4068'),
(1496, 'EQ-0208-04', 'HPLC - Prominence 20AT - Carry over', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4069'),
(1497, 'EQ-0208-05', 'HPLC - Prominence 20AT - Linieritas Autoinjektor', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4070'),
(1498, 'EQ-0208-06', 'HPLC - Prominence 20AT -? Gelombang (internal)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4071'),
(1499, 'EQ-0208-07', 'HPLC - Prominence 20AT -? Gelombang (kafein)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4072'),
(1500, 'EQ-0208-08', 'HPLC - Prominence 20AT - Noise Level', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4073'),
(1501, 'EQ-0209', 'HPLC-Prominence 20AT ', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4074'),
(1502, 'EQ-0209-01', 'HPLC - Prominence 20AT ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4075'),
(1503, 'EQ-0209-02', 'HPLC - Prominence 20AT ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4076'),
(1504, 'EQ-0209-03', 'HPLC - Prominence 20AT ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4077'),
(1505, 'EQ-0209-04', 'HPLC - Prominence 20AT ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4078'),
(1506, 'EQ-0209-05', 'HPLC - Prominence 20AT ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4079'),
(1507, 'EQ-0209-06', 'HPLC - Prominence 20AT ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4080'),
(1508, 'EQ-0209-07', 'HPLC - Prominence 20AT ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4081'),
(1509, 'EQ-0209-08', 'HPLC - Prominence 20AT ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4082'),
(1510, 'EQ-0217', 'Column Oven (QC HPLC-7)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4083'),
(1511, 'EQ-0218', 'Memert U 40', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4084'),
(1512, 'EQ-0219-TI-001', 'Oven WTB Binder VD23', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4085'),
(1513, 'EQ-0220-TI-001', 'Oven  Memmert   UFE 500', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4086'),
(1514, 'EQ-0221-TI-001', 'Oven WTB FD 115 Binder', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4087'),
(1515, 'EQ-0222', 'Coloumn Oven', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4088'),
(1516, 'EQ-0224', 'Referigerator QC BLF', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'REFRI', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4089'),
(1517, 'EQ-0227-01', 'HR73 MOISTURE ANALIZER Balance', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4090'),
(1518, 'EQ-0227-02', 'HR73 MOISTURE ANALIZER Thermometer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4091'),
(1519, 'EQ-0229-01', 'Fume Hood (1) flammable Kecepatan Alir Udara', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4092'),
(1520, 'EQ-0229-02', 'Fume Hood (1) flammable Pola Aliran Udara', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4093'),
(1521, 'EQ-0230-01', 'Fume Hood (2) non flammable Kecepatan Alir Udara', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4094'),
(1522, 'EQ-0230-02', 'Fume Hood (2) non flammable Pola Aliran Udara', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4095'),
(1523, 'EQ-0232', 'Climatic chamber Binder KBF 240 ', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4096'),
(1524, 'EQ-0232-TH-001', 'Climatic chamber Binder KBF 240 ', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1525, 'EQ-0232-TI-001', 'Climatic chamber Binder KBF 240 ', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1526, 'EQ-0233', 'Climatic chamber Binder KBF720', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4097'),
(1527, 'EQ-0233-TH-001', 'Climatic chamber Binder KBF 720 seri 01-28137', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4098'),
(1528, 'EQ-0233-TI-001', 'Climatic chamber Binder KBF 720 seri 01-28137', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4099'),
(1529, 'EQ-0237-01', 'Centrifuge Rotina 38', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1530, 'EQ-0237-02', 'Centrifuge Rotina 38', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1531, 'EQ-0243', 'Referigerator (RMPM)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'REFRI', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4100'),
(1532, 'EQ-0243-TI-001', 'Referigerator (RMPM)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4101'),
(1533, 'EQ-0244', 'Referigerator (FG)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'REFRI', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4102'),
(1534, 'EQ-0244-TI-001', 'Referigerator (FG)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4103'),
(1535, 'EQ-0245-02', 'LAF Sampling QC BLF', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4104'),
(1536, 'EQ-0246', 'Shieving test Retsch', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4105'),
(1537, 'EQ-0250', 'Mono Pump VIGGO PETERSON SH30R8 (2 unit)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4106'),
(1538, 'EQ-0251-RT-001', 'FRIABILITY TESTER ERWEKA TYPE TA3R', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1539, 'EQ-0251-TM-001', 'FRIABILITY TESTER ERWEKA TYPE TA3R', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1540, 'EQ-0252-TI-001', 'Oven Memmert B30 ', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4107'),
(1541, 'EQ-0253-TI-001', 'Oven Memmert B40 ', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4108'),
(1542, 'EQ-0255', 'HPLC-Prominence 20AT ', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4109'),
(1543, 'EQ-0255-01', 'Flow Accuracy Test', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4110'),
(1544, 'EQ-0255-02', 'HPLC LC-20 AT Prominence Komposisi Gradient', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4111'),
(1545, 'EQ-0255-03', 'HPLC LC-20 AT Prominence Linieritas Autoinjektor', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4112'),
(1546, 'EQ-0255-04', 'HPLC LC-20 AT Prominence Carry over', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4113'),
(1547, 'EQ-0255-05', 'HPLC LC-20 AT Prominence Detektor', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4114'),
(1548, 'EQ-0255-06', 'HPLC LC-20 AT Prominence? Gelombang (internal)', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4115'),
(1549, 'EQ-0256', 'HPLC Agilent 1100 series', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4116'),
(1550, 'EQ-0256-01', 'HPLC Agilent 1100 series - Temperatur', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1551, 'EQ-0256-02', 'HPLC Agilent 1100 series - Wavelength Accuracy', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1552, 'EQ-0256-03', 'HPLC Agilent 1100 series - Holmium', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1553, 'EQ-0256-04', 'HPLC Agilent 1100- Injector Precision & Carry Over', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1554, 'EQ-0256-05', 'HPLC Agilent 1100 series - Response linearity', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1555, 'EQ-0256-06', 'HPLC Agilent 1100 series - Noise Wander & Drift', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1556, 'EQ-0256-07', 'HPLC Agilent 1100 series - Gradient Composition', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1557, 'EQ-0257', 'HPLC LC-10 AT High Press gradient', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4117'),
(1558, 'EQ-0257-01', 'HPLC LC-10 AT(system-4) Flow Accuracy Test', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4118'),
(1559, 'EQ-0257-02', 'HPLC LC-10 AT(system-4) Komposisi Gradient', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4119'),
(1560, 'EQ-0257-03', 'HPLC LC-10 AT(system-4) Linieritas Autoinjektor', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4120'),
(1561, 'EQ-0257-04', 'HPLC LC-10 AT(system-4) Gradient Carry over', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4121'),
(1562, 'EQ-0257-05', 'HPLC LC-10 AT(system-4) LinierityDetektor', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4122'),
(1563, 'EQ-0257-06', 'HPLC LC-10 AT(system-4) Gradient ? (internal)', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4123'),
(1564, 'EQ-0257-07', 'HPLC LC-10 AT(system-4) Gradient ? (kafein)', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4124'),
(1565, 'EQ-0257-08', 'HPLC LC-10 AT(system-4) High Press Noise Level', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4125'),
(1566, 'EQ-0267-01', 'Tapped Volumeter Erweka Type SVM 102', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4126'),
(1567, 'EQ-0267-02', 'Tapped Volumeter Erweka Type SVM 103', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4127'),
(1568, 'EQ-0267-03', 'Tapped Volumeter Erweka Type SVM 104', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4128'),
(1569, 'EQ-0270', 'Centrifuge Hettich', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4129'),
(1570, 'EQ-0270-01', 'Centrifuge Hettich', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1571, 'EQ-0270-02', 'Centrifuge Hettich', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1572, 'EQ-0271', 'Dissolution SOTAX AT 7 smart (automatic)', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4130'),
(1573, 'EQ-0271-01', 'Dissolusion SOTAX AT 7 smart (automatic)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4131'),
(1574, 'EQ-0271-02', 'Dissolusion SOTAX AT 7 smart (automatic)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4132'),
(1575, 'EQ-0271-03', 'Dissolusion SOTAX AT 7 smart (automatic)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4133'),
(1576, 'EQ-0271-04', 'Dissolusion SOTAX AT 7 smart (automatic)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4134'),
(1577, 'EQ-0271-05', 'Dissolusion SOTAX AT 7 smart (automatic)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4135'),
(1578, 'EQ-0272-01', 'LAF sampling MPF', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4136'),
(1579, 'EQ-0272-02', 'LAF sampling MPF', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4137'),
(1580, 'EQ-0273', 'Dissolusi AT7-Smart Sotax', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4138'),
(1581, 'EQ-0273-01', 'Dissolusi AT7-Smart Sotax Levelling', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4139'),
(1582, 'EQ-0273-02', 'Dissolusi AT7-Smart Sotax Speed', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4140'),
(1583, 'EQ-0273-03', 'Dissolusi AT7-Smart Sotax Suhu water bath&flask', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4141'),
(1584, 'EQ-0273-04', 'Dissolusi AT7-Smart Sotax Shaft verticallity', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4142'),
(1585, 'EQ-0273-05', 'Dissolusi AT7-Smart Sotax Vessel verticallity', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4143'),
(1586, 'EQ-0273-06', 'Dissolusi AT7-Smart Sotax Centering', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4144'),
(1587, 'EQ-0273-07', 'Dissolusi AT7-Smart Sotax Paddle/Basket Wooble', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4145'),
(1588, 'EQ-0297', 'Elmasonic S180H', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4146'),
(1589, 'EQ-0299', 'HPLC-Class 10 AT VP', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4147'),
(1590, 'EQ-0299-01', 'HPLC-Class 10 AT VP - Flow Accuracy Test', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4148'),
(1591, 'EQ-0299-02', 'HPLC-Class 10 AT VP - Komposisi Gradient', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4149'),
(1592, 'EQ-0299-03', 'HPLC-Class 10 AT VP - Linieritas Autoinjektor', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4150'),
(1593, 'EQ-0299-04', 'HPLC-Class 10 AT VP - Carry over', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4151'),
(1594, 'EQ-0299-05', 'HPLC-Class 10 AT VP - Linieritas respons Detektor', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4152'),
(1595, 'EQ-0299-06', 'HPLC-Class 10 AT VP - ? Gelombang (internal)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4153'),
(1596, 'EQ-0299-07', 'HPLC-Class 10 AT VP - ? Gelombang (kafein)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4154'),
(1597, 'EQ-0299-08', 'HPLC-Class 10 AT VP - Noise Level', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4155'),
(1598, 'EQ-0302', 'Colomn Oven CTO 10A-vp (QC HPLC-1)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4156'),
(1599, 'EQ-0303', 'Coloumn Oven CTO Asvp (1) (QC HPLC-2)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4157'),
(1600, 'EQ-0304', 'Dissolution Sotax AT-7 Smart (Automatic)', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4158'),
(1601, 'EQ-0304-01', 'Dissolusion Sotax AT-7 (Levelling, Speed & Suhu )', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4159'),
(1602, 'EQ-0304-02', 'Dissolusion Sotax AT-7 Smart Performance', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4160'),
(1603, 'EQ-0305', 'Dissolution Sotax AT-7 Smart Automatic', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4161'),
(1604, 'EQ-0305-01', 'Dissolusion Sotax AT-7 Smart (Level, Speed & Suhu)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4162'),
(1605, 'EQ-0305-02', 'Dissolusion Sotax AT-7 Smart Performance ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4163'),
(1606, 'EQ-0310', 'Shaker IKA KS260 Basic', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4164'),
(1607, 'EQ-0311-MS-001', 'Bonding strength', 'ACT', 'QC2 ', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4165'),
(1608, 'EQ-0311-PI-001', 'Bonding strength', 'ACT', 'QC2 ', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4166'),
(1609, 'EQ-0312', 'Coloumn Oven', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4167'),
(1610, 'EQ-0314-1', 'Coloumn Oven', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4168'),
(1611, 'EQ-0314-2', 'Coloumn Oven', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4169'),
(1612, 'EQ-0325', 'Conveyor Ridar (2 unit) EQ-0325 EQ-0326', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'CONVEYOR', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4170'),
(1613, 'EQ-0329', 'LAF Dispensing ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4171'),
(1614, 'EQ-0332-1', 'Check Weigher FINE', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4172'),
(1615, 'EQ-0332-2', 'Check Weigher FAC 5500 (98278)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4173'),
(1616, 'EQ-0333-1', 'Check Weigher FINE', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4174'),
(1617, 'EQ-0333-2', 'Check Weigher (98279)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1618, 'EQ-0334-1', 'Check Weigher (98280)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4175'),
(1619, 'EQ-0334-2', 'Check Weigher (98280)', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1620, 'EQ-0335-1', 'Check Weigher FINE', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4176'),
(1621, 'EQ-0335-2', 'Check Weigher (98281)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1622, 'EQ-0336-1', 'Check Weigher FINE', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4177'),
(1623, 'EQ-0336-2', 'Check Weigher (98282)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1624, 'EQ-0337-1', 'Check Weigher (98283)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4178'),
(1625, 'EQ-0337-2', 'Check Weigher (98283)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1626, 'EQ-0338', 'Coloumn Oven CTO Asvp (1)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4179'),
(1627, 'EQ-0339', 'Mesin Cuci QC', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'WASH', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1628, 'EQ-0340-PI-002', 'Pressure Gauge Boiling Vessel TPF', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4180'),
(1629, 'EQ-0343-1', 'Check Weigher', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4181'),
(1630, 'EQ-0343-2', 'Check Weigher (98276)', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1631, 'EQ-0344-1', 'Check Weigher', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4182'),
(1632, 'EQ-0344-2', 'Check Weigher (98277)', 'ACT', 'BLF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1633, 'EQ-0346', 'Incubator Binder BD 400 ', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4183'),
(1634, 'EQ-0346-TI-001', 'Sensor temperatur Binder BD 400 ', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1635, 'EQ-0349', 'Mesin Cuci QC', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'WASH', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1636, 'EQ-0358', 'HSM Yong Sheuan', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4184');
INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(1637, 'EQ-0358-RT-001', 'HSM Yong Sheuan RPM digital Copper', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4185'),
(1638, 'EQ-0358-RT-002', 'HSM Yong Sheuan RPM digital Impeller', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4186'),
(1639, 'EQ-0358-TM-001', 'HSM Yong Sheuan Timer digital', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4187'),
(1640, 'EQ-0359-02', 'FBG Yong Sheuan ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4188'),
(1641, 'EQ-0359-03', 'Mesin FBD Yong Sheuan', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1642, 'EQ-0359-PD-001', 'FBG Yong Sheuan Magnehelic Panel Bawah', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4189'),
(1643, 'EQ-0359-PD-002', 'FBG Yong Sheuan Magnehelic Panel Bawah', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4190'),
(1644, 'EQ-0359-PI-001', 'FBG Yong Sheuan Pressure Gauge Festo', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4191'),
(1645, 'EQ-0359-PI-002', 'FBG Yong Sheuan Pressure Gauge Festo', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4192'),
(1646, 'EQ-0359-PI-007', 'FBG Yong Sheuan Pressure Gauge Festo Digital', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4193'),
(1647, 'EQ-0359-PI-008', 'FBG Yong Sheuan Pressure Gauge Festo Digital', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4194'),
(1648, 'EQ-0359-RT-001', 'FBG Yong Sheuan RPM meter Pompa Static', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4195'),
(1649, 'EQ-0359-TH-001', 'FBG Yong Sheuan Thermohygrometer sensor', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4196'),
(1650, 'EQ-0359-TI-001', 'FBG Yong Sheuan Sensor Pt 100 (outlet temp)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4197'),
(1651, 'EQ-0359-TI-002', 'FBG Yong Sheuan Sensor Pt 100 (inlet temp)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4198'),
(1652, 'EQ-0359-TI-003', 'FBG Yong Sheuan Sensor Temperatur Pt 100', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4199'),
(1653, 'EQ-0359-TI-004', 'FBG Yong Sheuan SensorPt 100', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4200'),
(1654, 'EQ-0359-TM-001', 'FBG Yong Sheuan Timer digital', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4201'),
(1655, 'EQ-0359-VI-001', 'FBG Yong Sheuan Vaccuum gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4202'),
(1656, 'EQ-0361-01', 'Coating BAMTRI', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'COAT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4203'),
(1657, 'EQ-0361-02', 'Mesin Coating BAMTRI', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'COAT', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1658, 'EQ-0361-PD-001', 'Coating BAMTRI pressure gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4204'),
(1659, 'EQ-0361-PD-002', 'Differential Pressure ', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1660, 'EQ-0361-PI-001', 'Coating BAMTRI Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4205'),
(1661, 'EQ-0361-PI-003', 'Coating BAMTRI Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4206'),
(1662, 'EQ-0361-PI-004', 'Coating BAMTRI Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4207'),
(1663, 'EQ-0361-PI-005', 'Coating BAMTRI Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4208'),
(1664, 'EQ-0361-PI-006', 'Coating BAMTRI Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4209'),
(1665, 'EQ-0361-PI-007', 'Coating BAMTRI Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4210'),
(1666, 'EQ-0361-PI-008', 'Coating BAMTRI Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4211'),
(1667, 'EQ-0361-RT-001', 'Coating BAMTRI RPM digital (drum speed)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4212'),
(1668, 'EQ-0361-RT-002', 'Coating BAMTRI RPM digital (drum speed)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4213'),
(1669, 'EQ-0361-TI-001', 'Coating BAMTRI Sensor Pt 100 (prod temp)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4214'),
(1670, 'EQ-0361-TI-002', 'Coating BAMTRI Sensor Pt 100 (supply temp)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4215'),
(1671, 'EQ-0361-TI-003', 'Coating BAMTRI Sensor Pt 100 (exhaust temp)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4216'),
(1672, 'EQ-0362', 'Bin Blender NAN TONG HTD-100', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4217'),
(1673, 'EQ-0362-RT-001', 'Bin Blender NAN TONG HTD-100 RPM digital', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1674, 'EQ-0362-TM-001', 'Bin Blender NAN TONG HTD-100 Timer digital', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1675, 'EQ-0363', 'Cone Mill mixer NAN TONG', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4218'),
(1676, 'EQ-0363-RT-001', 'Cone Mill mixer NAN TONG', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4219'),
(1677, 'EQ-0364', 'Auto capsule filling machine SEJONG SF-100N', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'CAP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4220'),
(1678, 'EQ-0364-PI-001', 'Cap filling (Sejong) Press Gauge 1 (Cap Discharge)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4221'),
(1679, 'EQ-0364-VI-001', 'Capsule Polishing Sejong Vaccum gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4222'),
(1680, 'EQ-0364-VM-001', 'Vacuum machine for Sejong SF100N', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4223'),
(1681, 'EQ-0365', 'Cap Polish dan Cap loader EQ-0365, EQ-0366', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'CAP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4224'),
(1682, 'EQ-0366-VI-001', 'Capsule Polishing Sejong Vaccum gauge ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4225'),
(1683, 'EQ-0369-1', 'Tablet Press Sejong', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'TAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4226'),
(1684, 'EQ-0369-2', 'Sejong Kalibrasi eksternal', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-04-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1685, 'EQ-0369-PI-001', 'Sejong Pressure Gauge 1', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1686, 'EQ-0369-PI-002', 'Sejong Pressure Gauge 2', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1687, 'EQ-0369-PI-003', 'Sejong Pressure Gauge 3', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1688, 'EQ-0369-RT-001', 'Sejong RPM digital Disk Speed', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1689, 'EQ-0369-RT-002', 'Sejong RPM digital Feeder Speed', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1690, 'EQ-0369-VI-001', 'Sejong Vacuum Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1691, 'EQ-0369-VM-001', 'Vacuum machine for Sejong MRC-31SAWC', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4227'),
(1692, 'EQ-0370', 'Incubator  temperatur Binder KB 400 ', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4228'),
(1693, 'EQ-0370-TI-001', 'Incubator temperatur Binder KB 400 ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1694, 'EQ-0371', 'Incubator Binder BD 115', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4229'),
(1695, 'EQ-0371-TI-001', 'Sensor temperatur Binder BD 115', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1696, 'EQ-0372-PI-001', 'Flattening Blister Pressure Gauge Regulator', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1697, 'EQ-0374', 'Pillow pack machine ', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'PILLOW', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4230'),
(1698, 'EQ-0374-TI-001', 'Pillow Pack Machine Hopak Fin Seal Temperatur', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1699, 'EQ-0374-TI-003', 'Pillow Pack Hopak End Seal Temp (down side)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1700, 'EQ-0375', 'Climatic chamber Thermolab (TPF)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4231'),
(1701, 'EQ-0375-TH-001', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4232'),
(1702, 'EQ-0375-TH-002', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4233'),
(1703, 'EQ-0375-TH-003', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4234'),
(1704, 'EQ-0375-TH-004', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4235'),
(1705, 'EQ-0375-TH-005', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4236'),
(1706, 'EQ-0375-TH-006', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4237'),
(1707, 'EQ-0375-TH-007', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4238'),
(1708, 'EQ-0375-TH-008', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4239'),
(1709, 'EQ-0375-TH-009', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4240'),
(1710, 'EQ-0375-TH-010', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4241'),
(1711, 'EQ-0375-TI-001', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4242'),
(1712, 'EQ-0375-TI-002', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4243'),
(1713, 'EQ-0375-TI-003', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4244'),
(1714, 'EQ-0375-TI-004', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4245'),
(1715, 'EQ-0375-TI-005', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4246'),
(1716, 'EQ-0375-TI-006', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4247'),
(1717, 'EQ-0375-TI-007', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4248'),
(1718, 'EQ-0375-TI-008', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4249'),
(1719, 'EQ-0375-TI-009', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4250'),
(1720, 'EQ-0375-TI-010', 'Climatic chamber Thermolab', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4251'),
(1721, 'EQ-0376', 'Gas Chromatography Agilent 7890A', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4252'),
(1722, 'EQ-0376-01', 'GC Agilent 7890A - Oven temp stability test ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4253'),
(1723, 'EQ-0376-02', 'GC Agilent 7890A - Channel Configuration Test', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4254'),
(1724, 'EQ-0376-03', 'GC Agilent 7890A - Inlet Pressure test,set:25 psi ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4255'),
(1725, 'EQ-0376-04', 'GC Agilent 7890A - Syringe inspection', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4256'),
(1726, 'EQ-0376-05', 'GC Agilent 7890A - Chemical Performance Test', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4257'),
(1727, 'EQ-0376-06', 'GC Agilent 7890A - Noise, wander and drift test ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4258'),
(1728, 'EQ-0379-01', 'PARTICLE SIZE ANALYZER MALVERN - Hydro S', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4259'),
(1729, 'EQ-0379-02', 'PARTICLE SIZE ANALYZER MALVERN - Sciroco', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4260'),
(1730, 'EQ-0382', 'Tap density meter', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1731, 'EQ-0384', 'Coloumn Oven (QC HPLC-6)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4261'),
(1732, 'EQ-0388', 'IMAJE COUNTER ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4262'),
(1733, 'EQ-0389-01', 'FBD Yong Sheuan', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4263'),
(1734, 'EQ-0389-02', 'Mesin FBD Yong Sheuan', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4264'),
(1735, 'EQ-0389-PD-004', 'FBD Yong Sheuan Differential Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4265'),
(1736, 'EQ-0389-PD-005', 'FBD Yong Sheuan Differential Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4266'),
(1737, 'EQ-0389-PI-006', 'FBD Yong Sheuan Differential Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4267'),
(1738, 'EQ-0389-PI-007', 'FBD Yong Sheuan Differential Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4268'),
(1739, 'EQ-0389-TH-001', 'FBD Yong Sheuan Sensor Hygrometer', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4269'),
(1740, 'EQ-0389-TI-001', 'FBD Yong Sheuan Pt 100 (inlet temp)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4270'),
(1741, 'EQ-0389-TI-002', 'FBD Yong Sheuan Pt 100 (produk temp)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4271'),
(1742, 'EQ-0389-TI-003', 'FBD Yong Sheuan Pt 100 (inlet temp)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4272'),
(1743, 'EQ-0389-TI-004', 'FBD Yong Sheuan Pt 100 (produk temp)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4273'),
(1744, 'EQ-0389-VI-001', 'FBD Yong Sheuan Vacuum Gauge', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4274'),
(1745, 'EQ-0393', 'Dissulution Sotax AT-7 Smart Manual ', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4275'),
(1746, 'EQ-0393-01', 'Dissolusi Sotax AT-7 Calib (Levelling, Speed&Suhu)', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4276'),
(1747, 'EQ-0393-02', 'Dissolusion Sotax AT-7 Performance Verification', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4277'),
(1748, 'EQ-0395', 'Disintregration Tester', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4278'),
(1749, 'EQ-0396', 'Hardness Tester Vanguard', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4279'),
(1750, 'EQ-0397-VM-001', 'Vacuum machine for Gaoger DPP-250Z', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4280'),
(1751, 'EQ-0399-01', 'Multi-parameter instrument Dissolve Oksigen', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4281'),
(1752, 'EQ-0399-02', 'Multi-parameter instrument pH meter', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4282'),
(1753, 'EQ-0399-03', 'Multi-parameter instrument Conductivity ', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-15', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4283'),
(1754, 'EQ-0407', 'Digital Metal Detector-7 (Sejong MRC-31S)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4284'),
(1755, 'EQ-0409-01', 'Centrifuge Hettich EBA 20', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4285'),
(1756, 'EQ-0409-02', 'Centrifuge Hettich EBA 21', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4286'),
(1757, 'EQ-0410', 'HARDNESS TESTER VANGUARD LH-2', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1758, 'EQ-0411', 'Tablet counting machine AUTOPACKER', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'FILLING', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4287'),
(1759, 'EQ-0411-PI-001', 'Tablet counting machine Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1760, 'EQ-0411-VM-001', 'Vacuum Nilfisk AUTOPACKER ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1761, 'EQ-0417', 'Cartoning JIANGNAN', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'CARTON', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4288'),
(1762, 'EQ-0417-PI-001', 'Cartoning KAOGER Pressure Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4289'),
(1763, 'EQ-0419-1', 'Check Weigher', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4290'),
(1764, 'EQ-0419-2', 'Check Weigher (98280)', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1765, 'EQ-0423', 'HPLC-Waters E2693', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4291'),
(1766, 'EQ-0423-01', 'HPLC-Waters E2693 - Flow Accuracy Test', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4292'),
(1767, 'EQ-0423-02', 'HPLC-Waters E2693 - Komposisi Gradient', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4293'),
(1768, 'EQ-0423-03', 'HPLC-Waters E2693 - Linieritas Autoinjektor', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4294'),
(1769, 'EQ-0423-04', 'HPLC-Waters E2693 - Carry over', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4295'),
(1770, 'EQ-0423-05', 'HPLC-Waters E2693 - Linieritas respons Detekto', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4296'),
(1771, 'EQ-0423-06', 'HPLC-Waters E2693 - ? gelombang (kafein)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4297'),
(1772, 'EQ-0423-07', 'HPLC-Waters E2693 - Kolom Oven', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4298'),
(1773, 'EQ-0424', 'HPLC-Waters E2695', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4299'),
(1774, 'EQ-0424-01', 'HPLC-Waters E2695 (QC HPLC-13)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4300'),
(1775, 'EQ-0424-02', 'HPLC-Waters E2695 (QC HPLC-13)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4301'),
(1776, 'EQ-0424-03', 'HPLC-Waters E2695 (QC HPLC-13)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4302'),
(1777, 'EQ-0424-04', 'HPLC-Waters E2695 (QC HPLC-13)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4303'),
(1778, 'EQ-0424-05', 'HPLC-Waters E2695 (QC HPLC-13)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4304'),
(1779, 'EQ-0424-06', 'HPLC-Waters E2695 (QC HPLC-13)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4305'),
(1780, 'EQ-0424-07', 'HPLC-Waters E2695 (QC HPLC-13)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4306'),
(1781, 'EQ-0425', 'HPLC-Waters E2695', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4307'),
(1782, 'EQ-0425-01', 'HPLC-Waters E2695 - Flow Accuracy Test', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4308'),
(1783, 'EQ-0425-02', 'HPLC-Waters E2695 - Komposisi Gradient', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4309'),
(1784, 'EQ-0425-03', 'HPLC-Waters E2695 - Linieritas Autoinjektor', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4310'),
(1785, 'EQ-0425-04', 'HPLC-Waters E2695 - Carry over', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4311'),
(1786, 'EQ-0425-05', 'HPLC-Waters E2695 - Linieritas respons Detekto', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4312'),
(1787, 'EQ-0425-06', 'HPLC-Waters E2695 - ? gelombang (kafein)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4313'),
(1788, 'EQ-0425-07', 'HPLC-Waters E2695 - Kolom Oven', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4314'),
(1789, 'EQ-0426', 'HPLC-Waters e2693 Alliance', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4315'),
(1790, 'EQ-0426-01', 'HPLC-Waters e2693 Alliance Flow Accuracy Test', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4316'),
(1791, 'EQ-0426-02', 'HPLC-Waters e2693 Alliance Komposisi Gradient', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4317'),
(1792, 'EQ-0426-03', 'HPLC-Waters e2693 Alliance Linieritas', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4318'),
(1793, 'EQ-0426-04', 'HPLC-Waters e2693 Alliance Carry over', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4319'),
(1794, 'EQ-0426-05', 'HPLC-Waters e2693 Linieritas respons Detekto', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4320'),
(1795, 'EQ-0426-06', 'HPLC-Waters e2693 ? gelombang (kafein)', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4321'),
(1796, 'EQ-0426-07', 'HPLC-Waters e2693 Alliance Kolom Oven', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4322'),
(1797, 'EQ-0427-02', 'LAF Dispensing ', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4323'),
(1798, 'EQ-0430-01', 'Centrifuge SL8 Thermo Scientific - waktu', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4324'),
(1799, 'EQ-0430-02', 'Centrifuge SL8 Thermo Scientific - RPM', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4325'),
(1800, 'EQ-0431', 'Check Weigher FINE', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4326'),
(1801, 'EQ-0431-MS-001', 'Check Weigher (Timbangan)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1802, 'EQ-0431-PI-001', 'Check Weigher (Pressure Gauge)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1803, 'EQ-0432', 'Check Weigher FINE', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4327'),
(1804, 'EQ-0432-MS-001', 'Check Weigher (Timbangan)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1805, 'EQ-0432-PI-001', 'Check Weigher (Pressure Gauge)', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1806, 'EQ-0433', 'SIEVE SHAKER RETSCH', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4328'),
(1807, 'EQ-0434', 'CO.MA.DI.S C960 Rectal Tube ', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'FILLING', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4329');
INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(1808, 'EQ-0434-PI-004', 'CO.MA.DI.S C960 Rectal Tube Pressure Gauge', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1809, 'EQ-0434-TI-001', 'CO.MA.DI.S C960 Rectal Tube Termocontrol', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1810, 'EQ-0437', 'Mesin Cuci QC', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'WASH', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1811, 'EQ-0438', 'Tabletting Fette', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'TAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4330'),
(1812, 'EQ-0438-MS-001', 'Tabletting \"Fette\" Load Cell Main Pressure ', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-10-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1813, 'EQ-0438-PI-001', 'Tabletting \"Fette\" Load Cell Pre Pressure', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-10-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1814, 'EQ-0438-RT-001', 'Tabletting \"Fette\" Load Cell Main Press', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-10-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1815, 'EQ-0438-RT-003', 'Tabletting \"Fette\" Fill o-matic', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-10-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1816, 'EQ-0438-VM-001', 'Fette 1200i', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4331'),
(1817, 'EQ-0440', 'Dissolusi Pharma Test PTWS310', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4332'),
(1818, 'EQ-0440-01', 'Dissolusi Pharma Test PTWS310 Levelling', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4333'),
(1819, 'EQ-0440-02', 'Dissolusi Pharma Test PTWS310 Speed', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4334'),
(1820, 'EQ-0440-03', 'Dissolusi Pharma Test Suhu waterbath&flask', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4335'),
(1821, 'EQ-0440-04', 'Dissolusi PTWS310 Shaft Verticality', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4336'),
(1822, 'EQ-0440-05', 'Dissolusi  PTWS310 Vessel Verticality', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4337'),
(1823, 'EQ-0440-06', 'Dissolusi PTWS310 Centering', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4338'),
(1824, 'EQ-0440-07', 'Dissolusi PTWS310 Basket shaft wobble', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4339'),
(1825, 'EQ-0442', 'Mesin Cuci QC', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'WASH', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1826, 'EQ-0444', 'Vacuum Sealer Maksipack ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'SEAL', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4340'),
(1827, 'EQ-0450', 'Referigerator', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'REFRI', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4341'),
(1828, 'EQ-0453', 'Vibrating Sifter', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4342'),
(1829, 'EQ-0455', 'Dissolusi Pharma Test PTWS300', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4343'),
(1830, 'EQ-0455-01', 'Dissolusi PTWS300 Suhu water bath&flask', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4344'),
(1831, 'EQ-0455-02', 'Dissolusi Pharma Test PTWS300 Speed', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4345'),
(1832, 'EQ-0455-03', 'Dissolusi PTWS300 Shaft Verticality (Pharma Test)', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4346'),
(1833, 'EQ-0455-04', 'Dissolusi PTWS300 Vessel Verticality (Pharma Test)', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4347'),
(1834, 'EQ-0455-05', 'Dissolusi PTWS300 Centering(by Pharma Test)', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4348'),
(1835, 'EQ-0455-06', 'Dissolusi PTWS300 Paddle Woobe (by Pharma Test)', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4349'),
(1836, 'EQ-0456', 'Dissolusi Pharma Test PTWS310', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4350'),
(1837, 'EQ-0456-01', 'Dissolusi Pharma Test PTWS310 Levelling', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4351'),
(1838, 'EQ-0456-02', 'Dissolusi Pharma Test PTWS310 Speed', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4352'),
(1839, 'EQ-0456-03', 'Dissolusi PTWS310 tem water bath&flask', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4353'),
(1840, 'EQ-0456-04', 'Dissolusi PTWS310 Shaft Verticality', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4354'),
(1841, 'EQ-0456-05', 'Dissolusi PTWS310 Vessel Verticality', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4355'),
(1842, 'EQ-0456-06', 'Dissolusi PTWS310 Centering (Pharma Test)', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4356'),
(1843, 'EQ-0456-07', 'Dissolusi PTWS310 Paddle Woobe (Pharma Test)', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4357'),
(1844, 'EQ-0458', 'Imaje 9030', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4358'),
(1845, 'EQ-0459', 'HPLC-Waters e2693 Alliance', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4359'),
(1846, 'EQ-0459-01', 'HPLC-Waters e2693 Alliance Flow Accuracy Test', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4360'),
(1847, 'EQ-0459-02', 'HPLC-Waters e2693 Alliance Komposisi Gradient', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4361'),
(1848, 'EQ-0459-03', 'HPLC-Waters e2693 Alliance Linieritas', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4362'),
(1849, 'EQ-0459-04', 'HPLC-Waters e2693 Alliance Carry over', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4363'),
(1850, 'EQ-0459-05', 'HPLC-Waters e2693 Alliance Linieritas Detekto', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4364'),
(1851, 'EQ-0459-06', 'HPLC-Waters e2693 Alliance Akurasi ? gelombang', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4365'),
(1852, 'EQ-0459-07', 'HPLC-Waters e2693 Alliance Kolom Oven', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4366'),
(1853, 'EQ-0460', 'HPLC-Waters e2693 Alliance', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4367'),
(1854, 'EQ-0460-01', 'HPLC-Waters e2693 Alliance Flow Accuracy Test', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4368'),
(1855, 'EQ-0460-02', 'HPLC-Waters e2693 Alliance Komposisi Gradient', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4369'),
(1856, 'EQ-0460-03', 'HPLC-Waters e2693 Alliance Linieritas', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4370'),
(1857, 'EQ-0460-04', 'HPLC-Waters e2693 Alliance Carry over', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4371'),
(1858, 'EQ-0460-05', 'HPLC-Waters e2693 Alliance ', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4372'),
(1859, 'EQ-0460-06', 'HPLC-Waters e2693 Alliance ? gelombang(kafein)', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4373'),
(1860, 'EQ-0460-07', 'HPLC-Waters e2693 Alliance Kolom Oven', 'ACT', 'QC2', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4374'),
(1861, 'EQ-0463', 'Chamber Votsch ', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4375'),
(1862, 'EQ-0463-01', 'Votsch VP1300', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4376'),
(1863, 'EQ-0463-02', 'Votsch VP1300', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4377'),
(1864, 'EQ-0466', 'Vacuum nilfisk', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4378'),
(1865, 'EQ-0468-01', 'Medium prepare stasiun - Vol Disp Larutan', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4379'),
(1866, 'EQ-0468-02', 'Medium prepare stasiun - Temp pemanasan Dissolusi', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4380'),
(1867, 'EQ-0468-03', 'Medium preparation stasiun - Pressure/Tekanan', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4381'),
(1868, 'EQ-0473', 'Referigerator (FG)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'REFRI', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4382'),
(1869, 'EQ-0473-TI-001', 'Referigerator (RMPM)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4383'),
(1870, 'EQ-0474-VI-001', 'Vacuum Test', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4384'),
(1871, 'EQ-0475', 'HPLC-Waters E2695', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4385'),
(1872, 'EQ-0475-01', 'HPLC-Waters E2695 - Flow Accuracy Test', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4386'),
(1873, 'EQ-0475-02', 'HPLC-Waters E2695 - Komposisi Gradient', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4387'),
(1874, 'EQ-0475-03', 'HPLC-Waters E2695 - Linieritas Autoinjektor', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4388'),
(1875, 'EQ-0475-04', 'HPLC-Waters E2695 - Carry over', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4389'),
(1876, 'EQ-0475-05', 'HPLC-Waters E2695 - Linieritas respons Detekto', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4390'),
(1877, 'EQ-0475-06', 'HPLC-Waters E2695 - ? gelombang (kafein)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4391'),
(1878, 'EQ-0475-07', 'HPLC-Waters E2695 - Kolom Oven', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4392'),
(1879, 'EQ-0476', 'HPLC-Waters E2695', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4393'),
(1880, 'EQ-0476-01', 'HPLC-Waters E2695 (QC HPLC-16)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4394'),
(1881, 'EQ-0476-02', 'HPLC-Waters E2695 (QC HPLC-16)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4395'),
(1882, 'EQ-0476-03', 'HPLC-Waters E2695 (QC HPLC-16)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4396'),
(1883, 'EQ-0476-04', 'HPLC-Waters E2695 (QC HPLC-16)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4397'),
(1884, 'EQ-0476-05', 'HPLC-Waters E2695 (QC HPLC-16)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4398'),
(1885, 'EQ-0476-06', 'HPLC-Waters E2695 (QC HPLC-16)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4399'),
(1886, 'EQ-0476-07', 'HPLC-Waters E2695 (QC HPLC-16)', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4400'),
(1887, 'EQ-0477-MS-001', 'MOISTURE ANALYZER HR-83 Halogen', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4401'),
(1888, 'EQ-0477-TI-001', 'MOISTURE ANALYZER HR-83 Halogen', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4402'),
(1889, 'EQ-0478', 'Penumatic Sealer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'SEAL', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4403'),
(1890, 'EQ-0478-TI-001', 'Pneumatic Sealer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4404'),
(1891, 'EQ-0480', 'Homogenizer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4405'),
(1892, 'EQ-0480-RT-001', 'Homogenizer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4406'),
(1893, 'EQ-0483', 'Blistering Noack 760 DPNL', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'BLISTER', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4407'),
(1894, 'EQ-0483-TI-001', 'Blistering Noack (cooling forming)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4408'),
(1895, 'EQ-0483-TI-002', 'Blistering Noack (cooling sealing)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4409'),
(1896, 'EQ-0483-TI-003', 'Blistering Noack (heating forming)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4410'),
(1897, 'EQ-0483-TI-004', 'Blistering Noack (heating forming bawah)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4411'),
(1898, 'EQ-0483-TI-005', 'Blistering Noack (heating sealing)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4412'),
(1899, 'EQ-0488', 'Mugen Mixer', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4413'),
(1900, 'EQ-0488-RT-001', 'Mugen Mixer', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4414'),
(1901, 'EQ-0493', 'Hapa Printer H-216-I', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4415'),
(1902, 'EQ-0498', 'Climatic chamber Thermolab (MPF)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4416'),
(1903, 'EQ-0498-TH-001', 'Climatic chamber Thermolab (1604111172)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4417'),
(1904, 'EQ-0498-TH-002', 'Climatic chamber Thermolab (1604111173)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4418'),
(1905, 'EQ-0498-TH-003', 'Climatic chamber Thermolab (1604111174)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4419'),
(1906, 'EQ-0498-TH-004', 'Climatic chamber Thermolab (1604111175)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4420'),
(1907, 'EQ-0498-TH-005', 'Climatic chamber Thermolab (1604111176)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4421'),
(1908, 'EQ-0498-TH-006', 'Climatic chamber Thermolab (1604111179)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4422'),
(1909, 'EQ-0498-TH-007', 'Climatic chamber Thermolab (1604111180)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4423'),
(1910, 'EQ-0498-TH-008', 'Climatic chamber Thermolab (1604111181)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4424'),
(1911, 'EQ-0499', 'KILLIAN S370 Prime', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'TAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4425'),
(1912, 'EQ-0499-GB-001', 'KILLIAN S370 Prime', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1913, 'EQ-0499-PI-001', 'KILLIAN S370 Prime', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1914, 'EQ-0499-PI-002', 'KILLIAN S370 Prime', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1915, 'EQ-0499-RT-001', 'KILLIAN S370 Prime', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1916, 'EQ-0499-RT-002', 'KILLIAN S370 Prime', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1917, 'EQ-0499-VM-001', 'Vacuum machine Delfin', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4426'),
(1918, 'EQ-0500', 'Lifter machine Servolift', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4427'),
(1919, 'EQ-0501', 'Mesin FBD Freund Vector', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1920, 'EQ-0502', 'Mesin HSM Diosna', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4428'),
(1921, 'EQ-0502-RT-001', 'RPM motor mixing mesin HSM Diosna', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1922, 'EQ-0502-RT-002', 'RPM motor chopper mesin HSM Diosna', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1923, 'EQ-0502-TM-001', 'Timer mesin HSM Diosna', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1924, 'EQ-0507', 'Mesin Label P+P', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'LABEL', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4429'),
(1925, 'EQ-0507-TI-001', 'Mesin Label P+P', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4430'),
(1926, 'EQ-0508', 'Filling liquid spalfil', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'FILLING', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4431'),
(1927, 'EQ-0508-PI-001', 'Liquid Filling', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1928, 'EQ-0509', 'Mesin Sachet Sanko', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'SEAL', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4432'),
(1929, 'EQ-0509-TI-001', 'Mesin Sachet', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1930, 'EQ-0509-TI-002', 'Mesin Sachet', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1931, 'EQ-0510', 'Oven Memert', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'OVEN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4433'),
(1932, 'EQ-0511', 'Video Jet', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4434'),
(1933, 'EQ-0512 -06', 'Gas Chromatography Agilent 7890B', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1934, 'EQ-0512 -07', 'GC Agilent 7890B - Oven temp stability test ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1935, 'EQ-0512-01', 'GC Agilent 7890B-Channel Configuration Parameter ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1936, 'EQ-0512-02', 'GC Agilent 7890B - Inlet Pressure test ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1937, 'EQ-0512-03', 'GC Agilent 7890B - Syringe inspection', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1938, 'EQ-0512-04', 'GC Agilent 7890B - Chemical Performance Test', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1939, 'EQ-0512-05', 'GC Agilent 7890B - Noise, wander and drift test ', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1940, 'EQ-0513', 'Blistering Uhlmann DHA ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'BLISTER', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4435'),
(1941, 'EQ-0513-TI-001', 'Blistering Uhlmann DHA (heating plate kiri atas)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1942, 'EQ-0513-TI-002', 'Blistering Uhlmann DHA (heating plate kanan atas)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1943, 'EQ-0513-TI-003', 'Blistering Uhlmann DHA (heating plate kiri bawah)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1944, 'EQ-0513-TI-004', 'Blistering Uhlmann DHA heating plate kanan bawah', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1945, 'EQ-0513-TI-005', 'Blistering Uhlmann DHA (heating plate)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1946, 'EQ-0514', 'HAPA Easy Flex printer', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4436'),
(1947, 'EQ-0515', 'Strecth Banding Machine', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'SEAL', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4437'),
(1948, 'EQ-0515-PI-001', 'Mesin Banding (pressure gauge)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4438'),
(1949, 'EQ-0515-PI-002', 'Mesin Banding (pressure gauge)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4439'),
(1950, 'EQ-0515-TI-001', 'Mesin Banding (pressure gauge)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4440'),
(1951, 'EQ-0517-VI-001', 'Vacuum Test', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4441'),
(1952, 'EQ-0519', 'Mesin labelling Marcotech', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LABEL', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4442'),
(1953, 'EQ-0519-PI-001', 'Mesin labelling Marcotech', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4443'),
(1954, 'EQ-0525-06', 'HPLC-Waters E2695', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4444'),
(1955, 'EQ-0525-07', 'HPLC-Waters E2695 - Flow Accuracy Test', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4451'),
(1956, 'EQ-0525-01', 'HPLC-Waters E2695 - Komposisi Gradient', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4446'),
(1957, 'EQ-0525-02', 'HPLC-Waters E2695 - Linieritas Autoinjektor', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4447'),
(1958, 'EQ-0525-03', 'HPLC-Waters E2695 - Carry over', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4448'),
(1959, 'EQ-0525-04', 'HPLC-Waters E2695 - Linieritas respons', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4449'),
(1960, 'EQ-0525-05', 'HPLC-Waters E2695 - Akurasi ?  Gelombang', 'ACT', 'QC3', NULL, NULL, 'Internal/Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4450'),
(1961, 'EQ-0525-07', 'HPLC-Waters E2695 - Kolom Oven', 'ACT', 'QC3', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'CAL', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4451'),
(1962, 'EQ-0528', 'Ink-jet Printer Imaje', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4452'),
(1963, 'EQ-0531', 'LAF Micro BLF', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4453'),
(1964, 'EQ-0532', 'R. Gowning Micro BLF', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4454'),
(1965, 'EQ-0533', 'R. Airlock Micro BLF', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4455'),
(1966, 'EQ-0534', 'Feather mill', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4456'),
(1967, 'EQ-0534-RT-001', 'Feather mill', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4457'),
(1968, 'EQ-0536-01', 'Sotax DT 2 DT - Mekanik', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4458'),
(1969, 'EQ-0536-02', 'Sotax DT 2 Jarak Stroke', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4459'),
(1970, 'EQ-0536-03', 'Sotax DT 2 Thermo Air Raksa', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4460'),
(1971, 'EQ-0537-VI-001', 'Vacuum Test', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4461'),
(1972, 'EQ-0539', 'Imaje 9020', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'PRINT', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4462'),
(1973, 'EQ-0541', 'Wet Scrubber ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4463'),
(1974, 'EQ-0542', 'Wet Scrubber ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4464'),
(1975, 'EQ-0543', 'Wet Scrubber ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4465'),
(1976, 'EQ-0556-VM-001', 'Vacuum machine BLF', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4466'),
(1977, 'EQ-0557', 'Blow and Sack', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'PURGE', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4467'),
(1978, 'EQ-0557-PI-001', 'Blow and suck machine', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4468'),
(1979, 'EQ-0557-VM-001', 'Vacuum machine Blow & Suck MPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4469'),
(1980, 'EQ-0558', 'Referigerator (RMPM)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'REFRI', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4470');
INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(1981, 'EQ-0558-TI-001', 'Referigerator  (RMPM)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4471'),
(1982, 'EQ-0564', 'Thermometer chiller comadis', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4472'),
(1983, 'EQ-0566', 'Refrigerator QC Mikrobiology', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'REFRI', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4473'),
(1984, 'EQ-0567', 'Carton OPTEL,Barcode EQ-0567, EQ-0570', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'CARTON', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4474'),
(1985, 'EQ-0568', 'Optel label & Barcode  EQ-0568, EQ-0571', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LABEL', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4475'),
(1986, 'EQ-0572', 'DO meter Hanna Instruments', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1987, 'EQ-0573', 'Vacuum Nilfisk', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1988, 'EQ-0574', 'Referigerator', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'REFRI', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4476'),
(1989, 'EQ-0575', 'Refrigerator QC lt.3', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'REFRI', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4477'),
(1990, 'EQ-0577', 'Flour Vibrator Shifter XZS-800', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'GRN', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4478'),
(1991, 'EQ-0579-01', 'LEV dispensing MPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4479'),
(1992, 'EQ-0579-02', 'LEV dispensing MPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'DISP', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4480'),
(1993, 'EQ-0579-PD-001', 'Pressure Gauge Gauge LEV Dispensing 2', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1994, 'EQ-0579-PD-002', 'Pressure Gauge Gauge LEV Dispensing 2', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1995, 'EQ-0580', 'Vacuum Nilfisk AUTOPACKER ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(1996, 'EQ-0589', 'Refrigerator QC Mikrobiology', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'REFRI', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4481'),
(1997, 'EQ-0592-01', 'Check Weigher Anritsu', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4482'),
(1998, 'EQ-0592-02', 'Check Weigher Anritsu', 'ACT', 'TPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4483'),
(1999, 'EQ-0593-01', 'Check Weigher Anritsu', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSP', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4484'),
(2000, 'EQ-0593-02', 'Check Weigher Anritsu', 'ACT', 'MPF', NULL, NULL, 'Eksternal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4485'),
(2001, 'EQ-0594-TH-001', 'Alarm system CAPSULE WH AC', 'ACT', 'CAPWH', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4486'),
(2002, 'EQ-0594-TH-002', 'Alarm system CAPSULE WH AC', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4487'),
(2003, 'EQ-0594-TH-003', 'Alarm system CONTAINER STORAGE TPF', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4488'),
(2004, 'EQ-0594-TH-004', 'Alarm system CONTAINER STORAGE TPF', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4489'),
(2005, 'EQ-0594-TH-005', 'Alarm system CHAMBER VOTSCH VP1300 ', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4490'),
(2006, 'EQ-0594-TH-006', 'Alarm system CHAMBER VOTSCH VP1300 ', 'ACT', 'QC', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4491'),
(2007, 'EQ-0594-TH-007', 'Alarm system WIP MPF ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4492'),
(2008, 'EQ-0594-TH-008', 'Alarm system WIP MPF ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4493'),
(2009, 'EQ-0594-TH-009', 'Alarm system WIP MPF PSIKOTROPIK', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4494'),
(2010, 'EQ-0594-TH-010', 'Alarm system WIP MPF PSIKOTROPIK', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4495'),
(2011, 'EQ-0594-TH-011', 'Alarm system WIP TPF', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4496'),
(2012, 'EQ-0594-TH-012', 'Alarm system WIP TPF', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4497'),
(2013, 'EQ-0594-TH-013', 'Alarm system WIP BLF', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4498'),
(2014, 'EQ-0594-TH-014', 'Alarm system WIP BLF', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4499'),
(2015, 'EQ-0594-TH-015', 'Alarm system RMPM WH AC', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4500'),
(2016, 'EQ-0594-TH-016', 'Alarm system RMPM WH AC', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4501'),
(2017, 'EQ-0594-TH-017', 'Alarm system RMPM WH NON AC', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4502'),
(2018, 'EQ-0594-TH-018', 'Alarm system RMPM WH NON AC', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4503'),
(2019, 'EQ-0594-TH-019', 'Alarm system FG WH AC', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4504'),
(2020, 'EQ-0594-TH-020', 'Alarm system FG WH AC', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4505'),
(2021, 'EQ-0594-TH-021', 'Alarm system FG WH NON AC', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4506'),
(2022, 'EQ-0594-TH-022', 'Alarm system FG WH NON AC', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4507'),
(2023, 'EQ-0594-TI-005', 'Alarm system RMPM WH BLF', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4508'),
(2024, 'EQ-0594-TI-006', 'Alarm system RMPM WH BLF', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4509'),
(2025, 'EQ-0594-TI-007', 'Alarm system REFRIGRATOR FG', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4510'),
(2026, 'EQ-0594-TI-008', 'Alarm system REFRIGRATOR FG', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4511'),
(2027, 'EQ-0594-TI-009', 'Alarm system REFRIGRATOR KULKASINDO', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4512'),
(2028, 'EQ-0594-TI-010', 'Alarm system REFRIGRATOR KULKASINDO', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4513'),
(2029, 'EQ-0594-TI-011', 'Alarm system REFRIGRATOR KULKASINDO', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4514'),
(2030, 'EQ-0594-TI-012', 'Alarm system REFRIGRATOR KULKASINDO', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4515'),
(2031, 'EQ-0594-TI-013', 'Alarm system REFRIGRATOR SANSIO', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4516'),
(2032, 'EQ-0594-TI-014', 'Alarm system REFRIGRATOR SANSIO', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4517'),
(2033, 'EQ-0594-TI-015', 'Alarm system INCUBATOR HERAEUS B5060', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4518'),
(2034, 'EQ-0594-TI-016', 'Alarm system INCUBATOR HERAEUS B5060', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4519'),
(2035, 'EQ-0594-TI-017', 'Alarm system INCUBATOR MEMMERT B800', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4520'),
(2036, 'EQ-0594-TI-018', 'Alarm system INCUBATOR MEMMERT B800', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4521'),
(2037, 'EQ-0594-TI-019', 'Alarm system INCUBATOR BINDER KB400', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4522'),
(2038, 'EQ-0594-TI-020', 'Alarm system INCUBATOR BINDER KB400', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4523'),
(2039, 'EQ-0594-TI-021', 'Alarm system INCUBATOR BINDER BD400', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4524'),
(2040, 'EQ-0594-TI-022', 'Alarm system INCUBATOR BINDER BD400', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4525'),
(2041, 'EQ-0594-TI-023', 'Alarm system INCUBATOR BINDER BD115', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4526'),
(2042, 'EQ-0594-TI-024', 'Alarm system INCUBATOR BINDER BD115', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4527'),
(2043, 'EQ-0594-TI-025', 'Alarm system INCUBATOR HERAEUS KB600', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4528'),
(2044, 'EQ-0594-TI-026', 'Alarm system INCUBATOR HERAEUS KB600', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4529'),
(2045, 'EQ-0594-TI-027', 'Alarm system INCUBATOR MEMMERT B40', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4530'),
(2046, 'EQ-0594-TI-028', 'Alarm system INCUBATOR MEMMERT B40', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4531'),
(2047, 'EQ-0594-TI-029', 'Alarm system INCUBATOR MEMMERT B15', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4532'),
(2048, 'EQ-0594-TI-030', 'Alarm system INCUBATOR MEMMERT B15', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4533'),
(2049, 'EQ-0594-TI-031', 'Alarm system INCUBATOR MEMMERT B15', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'SYSTEM', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4534'),
(2050, 'EQ-0594-TI-032', 'Alarm system INCUBATOR MEMMERT B15', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4535'),
(2051, 'EQ-0599', 'Vacuum cleaner ATEX', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2052, 'EQ-0599-VM-001', 'Vacuum Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2053, 'EQ-0600', 'Vacuum cleaner ATEX', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'VACUUM', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2054, 'EQ-0600-VM-001', 'Vacuum Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2055, 'EQ-207', 'HPLC-Prominence 20AT ', 'ACT', 'QC2', NULL, NULL, 'Eksternal', NULL, NULL, 'LAB', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4536'),
(2056, 'NA - 01', 'Softener ', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4537'),
(2057, 'NA - 02', 'Solution Preparation', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'LIQUID', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4538'),
(2058, 'NA - 03', 'FM200', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4539'),
(2059, 'NA - 04', 'Daikin 2pk (R.ex kantin MPF)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4540'),
(2060, 'NA - 05', 'Standing Floor 5pk (Kantin Umum)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4541'),
(2061, 'NA - 06', 'Ruang Pos 1  1 pk', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4542'),
(2062, 'UT-0004-01', 'Screw compressed air Atlas Copco ZT-22', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4543'),
(2063, 'UT-0004-02', 'Screw compressed air Atlas Copco ZT-22', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4544'),
(2064, 'UT-0005-01', 'compressor ATLAS COPCO AQ55', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4545'),
(2065, 'UT-0005-02', 'compressor ATLAS COPCO AQ55', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4546'),
(2066, 'UT-0006-PI-002', 'Pressure Gauge steam', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4547'),
(2067, 'UT-0008', 'Water Treatment Plant 1 (PPW) UT-0008 - 0009', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4548'),
(2068, 'UT-0008-CD-001', 'Conductivity Sensor E+H for RO product', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4549'),
(2069, 'UT-0008-CD-002', 'Conductivity Sensor E+H for EDI product', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4550'),
(2070, 'UT-0008-FL-002', 'Flow meter E+H (Looping PW NP) Promass 80', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4551'),
(2071, 'UT-0008-FL-003', 'Flow meter E+H (Looping PW PP) Promass 80', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4552'),
(2072, 'UT-0008-PH-001', 'PH Electrode', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4553'),
(2073, 'UT-0008-PI-011', 'Press. Gauge PW system', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4554'),
(2074, 'UT-0008-PI-012', 'Press. Gauge PW system', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4555'),
(2075, 'UT-0008-PI-019', 'Press. Gauge PW system (EDI Located)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4556'),
(2076, 'UT-0008-PI-020', 'Press. Gauge PW system (EDI Located)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4557'),
(2077, 'UT-0008-PI-021', 'Press. Gauge PW system (EDI Located)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4558'),
(2078, 'UT-0008-PI-022', 'Press. Gauge PW system (EDI Located)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4559'),
(2079, 'UT-0008-PI-023', 'Press. Gauge PW system', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4560'),
(2080, 'UT-0008-PI-024', 'Press. Gauge PW system', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4561'),
(2081, 'UT-0008-PI-026', 'Pressure Gauge Transmitter (PISL 50-7)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4562'),
(2082, 'UT-0008-PI-027', 'Press. Gauge PW system', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4563'),
(2083, 'UT-0008-PI-028', 'Press. Gauge PW system', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4564'),
(2084, 'UT-0008-PI-030', 'Pressure Gauge AHU Accelacota', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4565'),
(2085, 'UT-0008-PI-034', 'Pressure Gauge (PW BLF, drain RO)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4566'),
(2086, 'UT-0008-PI-035', 'Pressure Gauge Transmitter tank 5000L PW MPF', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4567'),
(2087, 'UT-0008-PI-036', 'Pressure Gauge Transmitter tank 1000L PW BLF', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4568'),
(2088, 'UT-0008-PI-037', 'Pressure Gauge  PW BLF', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4569'),
(2089, 'UT-0008-RT-001', 'Flow meter for Osmosed Water (PW)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-06-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2090, 'UT-0008-RT-002', 'Flow meter for Osmosed Concentrat Outlet (PW)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4570'),
(2091, 'UT-0008-RT-003', 'Flow meter for Osmosed Concentrat inlet to EDI ', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-06-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2092, 'UT-0008-TC-001', 'TOC measurement', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-05-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2093, 'UT-0008-TC-002', 'TOC measurement', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 24, 0, NULL, '0.00', '0.00', '2021-10-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2094, 'UT-0008-TI-001', 'Termocouple tipe K', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2095, 'UT-0008-TI-002', 'Termometer Resistance  E+H (Pt 100)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2096, 'UT-0008-TI-004', 'Temperatur Control Transmitter E+H (PW NP)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2097, 'UT-0008-TI-005', 'Temperatur Control Transmitter E+H (PW PP)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2098, 'UT-0009-TI-001', 'Termometer for EDI', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4571'),
(2099, 'UT-0011-01', 'AHU 3 TRANE, UT-0011, UT-0216, UT-0215', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4572'),
(2100, 'UT-0011-02', 'AHU 03', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4573'),
(2101, 'UT-0012-01', 'AHU 4 TRANE, Pharma Mezzanine', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4574'),
(2102, 'UT-0012-02', 'AHU 04 (Liquid Proses 1)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2103, 'UT-0012-03', 'AHU 04 (Liquid Proses 2)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2104, 'UT-0012-04', 'AHU 04 (Liquid Proses 3)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2105, 'UT-0012-05', 'AHU 04 (Liquid Proses 4)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2106, 'UT-0012-06', 'AHU 04 (Liquid Proses 5)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2107, 'UT-0012-07', 'AHU 04 (R. Tube Filling)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2108, 'UT-0012-08', 'AHU 04 (R. Bottle Purging)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-03-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2109, 'UT-0013-01', 'AHU 05', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4575'),
(2110, 'UT-0013-02', 'AHU 5 TRANE, Pharma Dispensing', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4576'),
(2111, 'UT-0014-01', 'AHU 6 TRANE, Dispensing UT-0014, UT-0016, UT-0160', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4577'),
(2112, 'UT-0014-02', 'AHU 06', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4578'),
(2113, 'UT-0015-01', 'AHU 8 YORK, Pharma ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4579'),
(2114, 'UT-0015-02', 'AHU 08', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2115, 'UT-0016', 'AHU 6 TRANE, Dispensing UT-0014, UT-0016, UT-0160', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4580'),
(2116, 'UT-0017-02', 'AHU 10', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4581'),
(2117, 'UT-0018-01', 'AHU 11 YORK, Pharma UT-0018, UT-0217, UT-0218', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4582'),
(2118, 'UT-0019-01', 'AHU 12 UT-0019, UT-0220, UT-0219', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4583'),
(2119, 'UT-0019-02', 'AHU 12', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4584'),
(2120, 'UT-0020-01', 'AHU 13 CARRIER MPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4585'),
(2121, 'UT-0020-02', 'AHU 13', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4586'),
(2122, 'UT-0025', 'AHU 1 TRANE (Sampling Room BLF 1ST FLOOR)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4587'),
(2123, 'UT-0026', 'AHU 2 (BLF 1ST FLOOR)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4588'),
(2124, 'UT-0027', 'AHU 3 TRANE (QC Lab. Room)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4589'),
(2125, 'UT-0028', 'AHU 4 CARRIER (Warehouse Room)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4590'),
(2126, 'UT-0029-01', 'AHU 1 ; UT-0029, UT-0213, UT-0034, UT-0035', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4591'),
(2127, 'UT-0029-02', 'AHU 1 (LT. 2)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4592'),
(2128, 'UT-0030-01', 'AHU 2A TMA1-0715 ((BL-F2ND FLOOR))', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4593'),
(2129, 'UT-0030-02', 'AHU 2A (LT.2)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4594'),
(2130, 'UT-0031-01', 'AHU 2B TMA1-0407 (BLF 2ND FLOOR)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4595'),
(2131, 'UT-0031-02', 'AHU 2B (LT.2)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4596'),
(2132, 'UT-0032-01', 'AHU 3 (BL-F2ND FLOOR)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4597'),
(2133, 'UT-0032-02', 'AHU 3 (LT.2)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4598'),
(2134, 'UT-0033', 'AHU 4 (BL-F2ND FLOOR)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4599'),
(2135, 'UT-0034', 'AHU 1 TMA1-1010 (BL-F2ND FLOOR)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2136, 'UT-0035', 'AHU 1 TMA1-1010 (BL-F2ND FLOOR)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2137, 'UT-0037-01', 'AHU-D.1.1 (Grey area)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4600'),
(2138, 'UT-0037-02', 'AHU D1-1', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4601'),
(2139, 'UT-0038', 'AHU-E.1.1 (TPF Black area)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4602'),
(2140, 'UT-0042', 'FCU DX 10 PK AICOOL', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4603'),
(2141, 'UT-0044', 'DAIKIN FCU DX (RM WH)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4604'),
(2142, 'UT-0045', 'DAIKIN FCU DX (RM WH)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4605'),
(2143, 'UT-0045-PI-002', 'Mixing Tangki 600 L Pressure Gauge', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'INSTR', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4606'),
(2144, 'UT-0046', 'DAIKIN FCU DX (RM WH)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4607'),
(2145, 'UT-0047', 'DAIKIN FCU DX (RM WH)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4608'),
(2146, 'UT-0048', 'FCU DX (RM WH)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4609'),
(2147, 'UT-0049', 'CARRIER FCU DX (FG WH)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4610'),
(2148, 'UT-0050', 'CARRIER FCU DX (FG WH)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4611'),
(2149, 'UT-0064', 'PANASONIC AC Split (EHS Manager)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4612'),
(2150, 'UT-0065', 'PANASONIC AC Split (QC Manager)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4613'),
(2151, 'UT-0066', 'PANASONIC AC Split (Supervisor QC 2)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4614'),
(2152, 'UT-0069', 'DAIKIN AC Split 2 pk (Microginon)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4615'),
(2153, 'UT-0070', 'DAIKIN AC Split 3', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4616'),
(2154, 'UT-0072', 'DAIKIN AC Split 5 (Microginon)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4617'),
(2155, 'UT-0075-1', 'Panasonic', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4618'),
(2156, 'UT-0075-2', 'Panasonic AC Split 2pk (HPLC)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4619');
INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_daya`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_tolerance`, `asset_start_mea`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `asset_active`, `asset_repair_type`, `asset_repair`, `asset_image`, `asset_image_path`, `created_at`, `updated_at`, `edited_by`, `asset_upload`, `asset_on_use`) VALUES
(2157, 'UT-0076', 'TOSHIBA AC Split (Office)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4620'),
(2158, 'UT-0079', 'DAIKIN AC Split (Site GM, TGO Site Management)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4621'),
(2159, 'UT-0080', 'DAIKIN AC Split 1pk (Dir. Site Quality) 01.01', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4622'),
(2160, 'UT-0081', 'DAIKIN AC Split (Associate Dir.Supply Chain)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4623'),
(2161, 'UT-0082', 'DAIKIN AC Split (Procurement) 01.06 ', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4624'),
(2162, 'UT-0083', 'DAIKIN AC Split (Associate Dir.Legal)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4625'),
(2163, 'UT-0084', 'DAIKIN AC Split (Server 1-1)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4626'),
(2164, 'UT-0085', 'DAIKIN AC Split (PPIC Staff) 01.18', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4627'),
(2165, 'UT-0086', 'MITSUBISHI AC Split (Export & Import Staff)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4628'),
(2166, 'UT-0087', 'Daikin 1pk (Management Secretary) 01.09', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4629'),
(2167, 'UT-0088', 'DAIKIN AC Split 1pk(Director Regional HRM)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4630'),
(2168, 'UT-0090', 'DAIKIN AC Split 1 pk (QA Staff 3)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4631'),
(2169, 'UT-0095', 'DAIKIN AC Split 2 pk (QA Staff 5)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4632'),
(2170, 'UT-0096', 'PANASONIC AC Split (HR Manager) 01.17', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4633'),
(2171, 'UT-0098', 'DAIKIN AC Split (Accounting Manager)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4634'),
(2172, 'UT-0099', 'MITSUBISHI AC Split (Financial Planning Mgr)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4635'),
(2173, 'UT-0100', 'DAIKIN AC Split (Finance & Treasury Manager)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4636'),
(2174, 'UT-0101', 'DAIKIN AC Split (Finance Director)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4637'),
(2175, 'UT-0103', 'DAIKIN Standing Floor 4pk', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4638'),
(2176, 'UT-0105', 'DAIKIN AC Split (Office Corridor 1st Floor)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4639'),
(2177, 'UT-0107', 'DAIKIN AC Split 1pk (Document SCA)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4640'),
(2178, 'UT-0108', 'DAIKIN AC Split 2pk (SCA Staff)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4641'),
(2179, 'UT-0109', 'DAIKIN AC Split (Manager SCA)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4642'),
(2180, 'UT-0110', 'DAIKIN AC Cassette (Yudistira Meeting Room)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4643'),
(2181, 'UT-0112', 'DAIKIN AC Split (Corridor Office 2nd Floor)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4644'),
(2182, 'UT-0114', 'DAIKIN AC Split (IT Regional Manager)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4645'),
(2183, 'UT-0115', 'DAIKIN AC Split 1pk (President Director) 01.10', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4646'),
(2184, 'UT-0116', 'Daikin 1pk (QA File 3rd floor)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4647'),
(2185, 'UT-0117', 'Panasonic AC Split 1pk (MST)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4648'),
(2186, 'UT-0118', 'DAIKIN AC Cassette 5pk (Product Development Staff)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4649'),
(2187, 'UT-0119', 'DAIKIN Standing Floor 3pk (Bima Meeting Room)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4650'),
(2188, 'UT-0121', 'DAIKIN AC Split 2pk (Ruangan Nakula)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4651'),
(2189, 'UT-0124', 'Daikin 1pk (R. Engineering Staff)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4652'),
(2190, 'UT-0129', 'Carrier 2pk (Retain sample Lt.2)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4653'),
(2191, 'UT-0130', 'Daikin 1,5 pk (Retain sample Lt.2)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4654'),
(2192, 'UT-0131', 'MITSUBISHI AC Split 2pk (Clinic)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4655'),
(2193, 'UT-0134', 'Lathe machine WEILER', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4656'),
(2194, 'UT-0140', 'Shredding Machine EBA', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4657'),
(2195, 'UT-0144', 'Dust collector ((BL-F2ND FLOOR)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4658'),
(2196, 'UT-0147', 'Electric Panels', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4659'),
(2197, 'UT-0148', 'Electric Panels', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4660'),
(2198, 'UT-0152-01', 'Distribution Panel', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4661'),
(2199, 'UT-0154', 'Cooling Tower-2 Liang Chi LBC 60 (Alcohol Plant)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4662'),
(2200, 'UT-0155', 'Resevoir Tank (underground)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4663'),
(2201, 'UT-0160', 'AHU 6 TRANE, Disp UT-0014, UT-0016, UT-0160', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2202, 'UT-0161-1', 'AHU 12 CARRIER, Pharma', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2203, 'UT-0161-2', 'Dehumidifier AHU 12B MPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4664'),
(2204, 'UT-0167', 'DAIKIN AC Split (Server 1-2)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4665'),
(2205, 'UT-0168', 'DAIKIN AC Split 1pk (QA Files 1st floor) 01.07', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4666'),
(2206, 'UT-0175-01', 'Diesel Genset PERKINS 4012-46TAG2A (+ uji riksa)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4667'),
(2207, 'UT-0176', 'PANASONIC AC Split (CB Supervisor)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4668'),
(2208, 'UT-0177', 'PANASONIC AC Split (Finance Meeting Room)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4669'),
(2209, 'UT-0182', 'Daikin AC Split 1pk (Climatic Chamber TPF)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4670'),
(2210, 'UT-0186', 'AHU-F.1.1 (Black area)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4671'),
(2211, 'UT-0187', 'PANASONIC AC Split (Finance Staff 3)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4672'),
(2212, 'UT-0188', 'PANASONIC AC Split (Finance Staff 4)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4673'),
(2213, 'UT-0189', 'Fresh air fan (BL-F2ND FLOOR))', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4674'),
(2214, 'UT-0194', 'Exhaust Fan (Washing room MPF)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4675'),
(2215, 'UT-0199-02', 'EAF Packing (LT. 2)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4676'),
(2216, 'UT-0203', 'Pompa Reservoir Tank (2 unit) UT-0203 UT-0204', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4677'),
(2217, 'UT-0204', 'Pompa Reservoir Tank (2 unit) ', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2218, 'UT-0213', 'AHU 1 TMA1-1010 (BL-F2ND FLOOR)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2219, 'UT-0213-02', 'EAF Air Lock', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4678'),
(2220, 'UT-0214-02', 'EAF Dust Collector', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4679'),
(2221, 'UT-0215', 'AHU 3 TRANE, Pharma Mezzanine', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2222, 'UT-0216', 'AHU 3 TRANE, Pharma Mezzanine', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2223, 'UT-0216-01', 'AHU Post Cooling 3A', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4680'),
(2224, 'UT-0217', 'AHU 11 YORK, Pharma', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2225, 'UT-0218', 'AHU 11 YORK, Pharma', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2226, 'UT-0218-02', 'AHU Post Cooling 11A', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4681'),
(2227, 'UT-0219', 'AHU 12 CARRIER, Pharma', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2228, 'UT-0220', 'AHU 12 CARRIER, Pharma', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2229, 'UT-0220-02', 'AHU Post Cooling 12A', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4682'),
(2230, 'UT-0221', 'AHU 12 CARRIER, Pharma', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, '', NULL, NULL, 0, 0, NULL, '0.00', '0.00', '1900-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2231, 'UT-0221-02', 'AHU Post Cooling 12B', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4683'),
(2232, 'UT-0222', 'Dehumidifier Munters MX-5000', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4684'),
(2233, 'UT-0223-01', 'Post Cooling-10A', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4685'),
(2234, 'UT-0223-02', 'AHU Post Cooling 10A', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4686'),
(2235, 'UT-0226', 'DAIKIN AC Split 1', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4687'),
(2236, 'UT-0230', 'PANASONIC AC Split (Reagent Non-Flameable)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4688'),
(2237, 'UT-0231', 'PANASONIC AC Split (Retain Sample Room) Lt.3', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4689'),
(2238, 'UT-0234-01', 'Chiller Unit MPF Area CARRIER 30HXC190AH', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4690'),
(2239, 'UT-0234-02', 'Chiller Unit MPF Area CARRIER 30HXC190AH', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4691'),
(2240, 'UT-0234-PI-009', 'Pressure Gauge Utiliy Chiller MPF', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2241, 'UT-0234-PI-010', 'Pressure Gauge Utiliy Chiller MPF', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2242, 'UT-0234-PI-011', 'Pressure Gauge Utiliy Chiller MPF', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2243, 'UT-0234-PI-012', 'Pressure Gauge Utiliy Chiller MPF', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2244, 'UT-0235', 'Cooling Tower for Chiller MPF KUKEN SKB-250', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4692'),
(2245, 'UT-0244', 'FCU DX 1  AICOOL (FG WH)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4693'),
(2246, 'UT-0245', 'FCU DX 2  AICOOL (FG WH)', 'ACT', 'WH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4694'),
(2247, 'UT-0246', 'DAIKIN AC Split (New Capsule Warehouse)', 'ACT', 'CAPWH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4695'),
(2248, 'UT-0247', 'DAIKIN AC Split (New Capsule Warehouse)', 'ACT', 'CAPWH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4696'),
(2249, 'UT-0248-1', 'EAF', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4697'),
(2250, 'UT-0248-2', 'DAIKIN AC Split (New Capsule Warehouse)', 'ACT', 'CAPWH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4698'),
(2251, 'UT-0249-01', 'AHU D1', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4699'),
(2252, 'UT-0249-02', 'AHU D1', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4700'),
(2253, 'UT-0250-1', 'CARRIER AHU F2 (QC MIKROBIOLOGY)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4701'),
(2254, 'UT-0250-2', 'DAIKIN AC Split (New Capsule Warehouse)', 'ACT', 'CAPWH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4702'),
(2255, 'UT-0251', 'CARRIER AHU F3', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4703'),
(2256, 'UT-0252', 'DAIKIN (R. Inspector Pack Material)  ', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4704'),
(2257, 'UT-0253', 'AHU D.1 Solvent Dispensing', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4705'),
(2258, 'UT-0254-01', 'AHU D.1 Granulation MPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4706'),
(2259, 'UT-0254-02', 'AHU D1.B', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2260, 'UT-0254-03', 'DAIKIN AC Split 1pk (HPLC)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4707'),
(2261, 'UT-0255', 'Mitsubishi 1pk (R.IR/Instrumen 2) 21.202', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4708'),
(2262, 'UT-0256-01', 'Steam Boiler-2 MIURA (+ uji riksa)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 4, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4709'),
(2263, 'UT-0256-02', 'Steam Boiler-2 MIURA (+ uji riksa)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4710'),
(2264, 'UT-0256-03', 'Panasonic 1pk (REAGENT STORAGE) 21.210', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4711'),
(2265, 'UT-0257-01', 'AHU D.2 Granulation MPF', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4712'),
(2266, 'UT-0257-02', 'AHU D2', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-01-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2267, 'UT-0258', 'PANASONIC AC Split 1pk (R.Dokumen) 21.208', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4713'),
(2268, 'UT-0260', 'SHARP AC Split (Climatic Chamber/Container)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4714'),
(2269, 'UT-0261', 'SHARP AC Split (Climatic Chamber/Container)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4715'),
(2270, 'UT-0262', 'SHARP AC Split (Retained Sample/Container )', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4716'),
(2271, 'UT-0263', 'SHARP AC Split (Climatic Chamber/Container)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4717'),
(2272, 'UT-0269', 'Panasonic 1pk (R.Simpan sample) 21.321', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4718'),
(2273, 'UT-0271', 'DAIKIN AC Split (Server 1-3)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4719'),
(2274, 'UT-0284-01', 'Dessicatn Dryer 250+', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4720'),
(2275, 'UT-0284-02', 'Rotary Screw Compressor Atlas Copco ZT75VSD', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4721'),
(2276, 'UT-0284-03', 'Rotary Screw Compressor Atlas Copco ZT75VSD', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4722'),
(2277, 'UT-0284-PI-001', 'Pressure Gauge unit Compressed Air', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4723'),
(2278, 'UT-0284-PI-002', 'Pressure Gauge unit Compressed Air', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4724'),
(2279, 'UT-0285-01', 'Chiller Unit CARRIER 30XW-V235', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 1, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4725'),
(2280, 'UT-0285-02', 'Chiller Unit CARRIER 30XW-V235', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4726'),
(2281, 'UT-0285-PI-001', 'Pressure Gauge Utiliy Chiller MPF', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2282, 'UT-0285-PI-002', 'Pressure Gauge Utiliy Chiller MPF', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2283, 'UT-0285-PI-003', 'Pressure Gauge Utiliy Chiller MPF', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2284, 'UT-0285-PI-004', 'Pressure Gauge Utiliy Chiller MPF', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-02-01', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, NULL),
(2285, 'UT-0287', 'SHARP (TPF/Container)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4727'),
(2286, 'UT-0288', 'SHARP (TPF/Container)', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4728'),
(2287, 'UT-0290', 'Daikin 1pk (R.Adm Packing)', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4729'),
(2288, 'UT-0293', 'LG AC Split 1pk (Instrument & Calibration)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4730'),
(2289, 'UT-0294', 'Daikin 1pk (R. Engineering Staff)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4731'),
(2290, 'UT-0296-1', 'Daikin 1/2pk(R. QC BLF)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4732'),
(2291, 'UT-0296-2', 'Panasonic 1pk (R.Adm QC BLF)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4733'),
(2292, 'UT-0297', 'FCU DX1 (Packing Skunder MPF)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4734'),
(2293, 'UT-0298', 'FCU DX2 (Packing Skunder MPF)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4735'),
(2294, 'UT-0299', 'PANASONIC AC Split (Climatic Chamber Canteen)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4736'),
(2295, 'UT-0300', 'PANASONIC AC Split (Climatic Chamber Canteen)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4737'),
(2296, 'UT-0301', 'LG 1pk (21.309) R. Supervisor 1', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4738'),
(2297, 'UT-0311-CD-001', 'Conductivity 1 demin Novaqua', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4739'),
(2298, 'UT-0311-CD-002', 'Conductivity 2 demin Novaqua ', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'CAL', NULL, 'C', NULL, NULL, 12, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4740'),
(2299, 'UT-0317', 'Daikin 1.5pk (R.meeting Arjuna)', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4741'),
(2300, 'UT-0318', 'Panasonic 1pk', 'ACT', 'OFFICE', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4742'),
(2301, 'UT-0322', 'Standing Floor Panasonic 5pk (Packing Hall) ', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4743'),
(2302, 'UT-0323-01', 'Steam Boiler-1 MIURA (+ uji riksa)', 'ACT', 'ENG', NULL, NULL, 'Eksternal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 4, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4744'),
(2303, 'UT-0323-02', 'Steam Boiler-1 MIURA (+ uji riksa)', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4745'),
(2304, 'UT-0324', 'Electric Hydrant Pump', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4746'),
(2305, 'UT-0325', 'Diesel Hydrant', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4747'),
(2306, 'UT-0326-02', 'Ruang Gas Storage', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4748'),
(2307, 'UT-0327', 'Lift barang', 'ACT', 'BLF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4749'),
(2308, 'UT-0328', 'Lift barang MPF', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4750'),
(2309, 'UT-0329', 'Kolam limbah 1', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4751'),
(2310, 'UT-0330', 'Kolam limbah 2', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4752'),
(2311, 'UT-0331', 'Kolam limbah 3', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4753'),
(2312, 'UT-0332', 'Kolam limbah 4', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4754'),
(2313, 'UT-0333', 'Master Control Fire Alarm (MCFA)', 'ACT', 'EHS', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4755'),
(2314, 'UT-0335', 'Ruang Serialisasi 2pk', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4756'),
(2315, 'UT-0336', 'Ruang Serialisasi 2pk', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4757'),
(2316, 'UT-0341', 'Carrier 2pk (RUANGAN ANALIS/Preparasi)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4758'),
(2317, 'UT-0342', 'Ruangan Panel Pos 2  1.5 pk', 'ACT', 'ENG', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4759'),
(2318, 'UT-0343', 'Panasonic 2pk (R. Incubator) ', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4760'),
(2319, 'UT-0344', 'Daikin 1pk (R. Media Storage)', 'ACT', 'QC3', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4761'),
(2320, 'UT-0352', 'Daikin 1pk (RUANGAN ANALIS/Preparasi)', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4762'),
(2321, 'UT-0354', 'Mitsubishi 1pk (R. Simpan Sample &Instrumen 3) ', 'ACT', 'QC2', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4763'),
(2322, 'UT-0355', 'DAIKIN AC Split (New Capsule Warehouse)', 'ACT', 'CAPWH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4764'),
(2323, 'UT-0356', 'DAIKIN AC Split (New Capsule Warehouse)', 'ACT', 'CAPWH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4765'),
(2324, 'UT-0359', 'DAIKIN AC Split (New Capsule Warehouse)', 'ACT', 'CAPWH', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4766'),
(2325, 'UT-0363', 'Daikin 1pk (R.Staff Produksi)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4767'),
(2326, 'UT-0364', 'Daikin 1pk (R.Staff Produksi)', 'ACT', 'MPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 6, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4768'),
(2327, 'UT-0367', 'DAIKIN 2 PK Container TPF', 'ACT', 'TPF', NULL, NULL, 'Internal', NULL, NULL, 'UTY', 'PM', NULL, 'C', NULL, NULL, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', 'code', 'other', NULL, NULL, '2022-04-05', '2022-04-05', 'admin', NULL, 'PM-21-4769'),
(2328, 'atest', 'test item a', 'ACT', 'HO', 'pc', NULL, NULL, NULL, NULL, 'UTY', 'UTY', NULL, 'C', NULL, 0, 1, 2, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', NULL, '', '', '', '2022-04-10', '2022-04-10', 'admin', NULL, 'PM-21-4770'),
(2329, 'btest', 'test lagi', 'ACT', 'HO', 'pc', NULL, NULL, NULL, NULL, 'UTY', 'UTY', NULL, 'C', NULL, 0, 3, 0, NULL, '0.00', '0.00', '2022-04-10', NULL, 'Yes', NULL, '', '', '', '2022-04-10', '2022-04-10', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_par`
--

CREATE TABLE `asset_par` (
  `ID` int(11) NOT NULL,
  `aspar_par` varchar(10) NOT NULL,
  `aspar_child` varchar(10) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_par`
--

INSERT INTO `asset_par` (`ID`, `aspar_par`, `aspar_child`, `created_at`, `updated_at`) VALUES
(1, 'FS1231', 'A102', '2021-03-04', '2021-03-04'),
(2, 'K1289', 'A102', '2021-03-04', '2021-03-04'),
(3, 'K1289', 'A102', '2021-03-04', '2021-03-04'),
(4, 'K1289', 'A102', '2021-03-04', '2021-03-04'),
(12, 'A10', 'WVVDFE', '2021-03-04', '2021-03-04'),
(13, 'A10', 'B1238', '2021-03-04', '2021-03-04');

-- --------------------------------------------------------

--
-- Table structure for table `asset_type`
--

CREATE TABLE `asset_type` (
  `ID` int(11) NOT NULL,
  `astype_code` varchar(8) NOT NULL,
  `astype_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_type`
--

INSERT INTO `asset_type` (`ID`, `astype_code`, `astype_desc`, `created_at`, `updated_at`) VALUES
(2, 'MAC2', 'Mesin Ulir', '2021-02-26', '2021-02-26'),
(3, 'MAC3', 'Mesin Potong Besi', '2021-02-26', '2021-02-26'),
(4, 'MOT1', 'Damkar Merah Kuning', '2021-02-26', '2021-02-26'),
(5, 'MOT2', 'AMbulance i', '2021-02-26', '2021-02-26'),
(6, 'MOT3', 'Bus', '2021-02-26', '2021-02-26'),
(7, 'MOT4', 'Bis Tingkat', '2021-02-26', '2021-02-26'),
(8, 'MAC1', 'Mesin Potong Rumput', '2021-02-26', '2021-02-26'),
(10, 'ASSET1', 'Aset Besi EDIT', '2021-03-12', '2021-03-12');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `book_id` bigint(20) NOT NULL,
  `bank_code` varchar(10) NOT NULL,
  `book_asset` varchar(10) NOT NULL,
  `book_start` datetime NOT NULL,
  `book_end` datetime NOT NULL,
  `book_status` varchar(10) NOT NULL,
  `book_note` varchar(200) DEFAULT NULL,
  `book_allday` varchar(10) DEFAULT NULL,
  `book_dobel` varchar(10) DEFAULT NULL,
  `book_created_at` datetime NOT NULL,
  `book_updated_at` datetime NOT NULL,
  `book_edited_by` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dept_mstr`
--

CREATE TABLE `dept_mstr` (
  `ID` int(11) NOT NULL,
  `dept_code` varchar(10) NOT NULL,
  `dept_desc` varchar(50) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dept_mstr`
--

INSERT INTO `dept_mstr` (`ID`, `dept_code`, `dept_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'MPF', 'Multi Product Facility', '2021-10-04', '2021-10-04', 'admin01'),
(2, 'BLF', 'Betalactam Facility', '2021-10-04', '2021-10-04', 'admin01'),
(3, 'TPF', 'Topical Facility', '2021-10-04', '2021-10-04', 'admin01'),
(4, 'ENG', 'Engineering', '2021-10-04', '2021-10-04', 'admin01'),
(5, 'QC2', 'Quality Control lt 2', '2021-10-04', '2021-10-04', 'admin01'),
(6, 'QC3', 'Quality Control lt 3', '2021-10-04', '2021-10-04', 'admin01'),
(7, 'Micro', 'Microbiology lab', '2021-10-04', '2021-10-04', 'admin01'),
(8, 'HO1', 'Head Office lt. 1', '2021-10-04', '2021-10-04', 'admin01'),
(9, 'HO2', 'Head Office lt. 2', '2021-10-04', '2021-10-04', 'admin01'),
(10, 'HO3', 'Head Office lt. 3', '2021-10-04', '2021-10-04', 'admin01'),
(11, 'TLV', 'Talavera', '2021-10-04', '2021-10-04', 'admin01'),
(12, 'RMWH', 'Raw Material Warehouse', '2021-10-04', '2021-10-04', 'admin01'),
(13, 'FGWH', 'Finish Good Warehouse', '2021-10-04', '2021-10-04', 'admin01'),
(14, 'CWH', 'Capsule Warehouse', '2021-10-04', '2021-10-04', 'admin01'),
(15, 'EHS', 'Environment Health & Safety', '2021-10-04', '2021-10-04', 'admin01'),
(16, 'IT', 'Information Technology', '2021-10-04', '2021-10-04', 'admin01'),
(17, 'UTY', 'Utility', '2021-10-04', '2021-10-04', 'admin01');

-- --------------------------------------------------------

--
-- Table structure for table `eng_mstr`
--

CREATE TABLE `eng_mstr` (
  `ID` int(11) NOT NULL,
  `eng_code` varchar(10) NOT NULL,
  `eng_desc` varchar(50) NOT NULL,
  `eng_dept` varchar(8) NOT NULL,
  `approver` int(11) NOT NULL,
  `eng_birth_date` date DEFAULT NULL,
  `eng_active` varchar(5) NOT NULL,
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
(1, 'spv01', 'Supervisor 1', 'ENG', 1, NULL, 'Yes', NULL, NULL, '', 'spv01@gmail.com', 'eng02', 'SPVSR', '2022-05-13', '2022-05-13', 'admin'),
(2, 'eng01', 'Engineer 01', 'BLF', 0, NULL, 'Yes', NULL, NULL, '', 'eng01@gmail.com', 'eng01', 'TECH', '2022-05-13', '2022-07-21', 'admin'),
(3, 'admin', 'Andrew Conan', 'ENG', 1, '2022-07-07', 'Yes', '2022-07-07', '121.00', '', 'tyas@ptimi.co.id', 'admin', 'ADMIN', '2022-07-07', '2022-07-07', 'rio'),
(5, 'admin01', 'admin HO', 'ENG', 1, '2022-07-07', 'Yes', '2022-07-07', '0.00', '', 'sinta.lestari@actavis', 'NULL', 'ADMIN', '2022-07-07', '2022-07-07', 'admin01'),
(8, 'eng02', 'Rahman', 'ENG', 0, '2022-07-07', 'Yes', '2022-07-07', '0.00', '', 'Sukarya.Sukarya@actavis', 'eng02', 'TECH', '2022-07-07', '2022-07-21', 'admin'),
(9, 'eng03', 'Ranto', 'ENG', 0, '2022-07-07', 'Yes', '2022-07-07', '0.00', '', 'Ijan.Ipriana@actavis', 'eng03', 'TECH', '2022-07-07', '2022-07-21', 'admin'),
(10, 'imi01', 'Admin IMI', 'ENG', 1, '2022-07-07', 'Yes', '2022-07-07', '0.00', '', 'rio@ptimi.co.id', '', 'ADMIN', '2022-07-07', '2022-07-07', 'admin'),
(11, 'azis', 'Azis', 'ENG', 0, '2022-07-07', 'Yes', '2022-07-07', '0.00', '', 'AzisAli.Murti@actavis', '', 'TECH', '2022-07-07', '2022-07-07', 'admin'),
(12, 'sukarya', 'Sukarya', 'ENG', 0, '2022-07-07', 'Yes', '2022-07-07', '0.00', '', 'Sukarya.Sukarya@actavis', '', 'TECH', '2022-07-07', '2022-07-07', 'admin'),
(13, 'spv02', 'Supervisor', 'IT', 0, NULL, 'Yes', NULL, NULL, '', 'tyas@ptimi', 'spv02', 'SPVSR', '2022-07-19', '2022-07-19', 'admin');

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
  `fn_code` varchar(8) NOT NULL,
  `fn_num` int(3) NOT NULL,
  `fn_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fn_mstr`
--

INSERT INTO `fn_mstr` (`ID`, `fn_code`, `fn_num`, `fn_desc`, `created_at`, `updated_at`) VALUES
(1, '1', 123, '123456789012345678901234567890', '2021-03-07', '2021-03-12'),
(4, '4', 421, '21424', '2021-03-07', '2021-03-07'),
(5, '1221', 0, 'asdfghjkl', '2021-03-07', '2021-03-12'),
(6, '123', 123, '123123', '2021-03-07', '2021-03-07'),
(7, '123124', 111, 'qwerty', '2021-03-07', '2021-03-07'),
(8, '5435', 345, '5345435', '2021-03-07', '2021-03-07'),
(9, 'FAIL1', 1, 'Salah Pasang', '2021-03-12', '2021-03-12'),
(10, 'FAIL2', 1, 'Salah Potong', '2021-03-12', '2021-03-12');

-- --------------------------------------------------------

--
-- Table structure for table `imp_mstr`
--

CREATE TABLE `imp_mstr` (
  `imp_code` varchar(10) NOT NULL,
  `imp_desc` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `imp_mstr`
--

INSERT INTO `imp_mstr` (`imp_code`, `imp_desc`) VALUES
('EHS', 'EHS'),
('QLTY', 'Quality'),
('RLT', 'Reliability');

-- --------------------------------------------------------

--
-- Table structure for table `ins_mstr`
--

CREATE TABLE `ins_mstr` (
  `ins_id` int(11) NOT NULL,
  `ins_code` varchar(10) NOT NULL,
  `ins_desc` varchar(200) NOT NULL,
  `ins_part` varchar(200) DEFAULT NULL,
  `ins_ref` varchar(50) DEFAULT NULL,
  `ins_tool` varchar(200) DEFAULT NULL,
  `ins_hour` decimal(11,2) DEFAULT NULL,
  `ins_check` varchar(200) DEFAULT NULL,
  `ins_check_desc` varchar(200) DEFAULT NULL,
  `ins_check_mea` varchar(200) DEFAULT NULL,
  `ins_created_at` date DEFAULT NULL,
  `ins_updated_at` date DEFAULT NULL,
  `ins_edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ins_mstr`
--

INSERT INTO `ins_mstr` (`ins_id`, `ins_code`, `ins_desc`, `ins_part`, `ins_ref`, `ins_tool`, `ins_hour`, `ins_check`, `ins_check_desc`, `ins_check_mea`, `ins_created_at`, `ins_updated_at`, `ins_edited_by`) VALUES
(1, 'CTF-I001', 'Pemeriksaan kelancaran putaran motor, pengukuran ampere main motor (empty run)', '2,3', NULL, '', NULL, 'Ampere Actual', NULL, NULL, '2022-05-13', '2022-08-30', 'admin'),
(2, 'CTF-I002', 'Penggantian oli gearbox, pemeriksaan kekencangan baut-baut, pemeriksaan visual gearbox dari kebocoran', '7,8', NULL, '', NULL, 'Kondisi gear baik, kekencangan baut terjaga, terlumasi dengan baik', NULL, NULL, '2022-05-13', '2022-08-30', 'admin'),
(3, 'CTF-I003', 'Pemeriksaan kondisi fisik cam drive dari tanda-tanda keausan/worn out, pemeriksaan kekencangan baut pengunci, pelumasan cam drive dengan foodgrade grease', 'CTF-P003', NULL, '', NULL, 'Kondisi gear baik, kekencangan baut terjaga, terlumasi dengan baik', NULL, NULL, '2022-05-13', '2022-05-13', 'admin'),
(4, 'CTF-I004', 'Pemeriksaan keseluruhan meliputi: kondisi fisik & ketajaman pisau,  kondisi shaft & penggantian bearing shaft, kondisi fisik block mounting', 'CTF-P004', NULL, '', NULL, 'Kondisi baik, ganti jika aus/worn out', NULL, NULL, '2022-05-13', '2022-05-13', 'admin'),
(5, 'CTF-I005', 'Pemeriksaan kondisi & fungsi pressure sensor', 'CTF-P005', NULL, '', NULL, 'Kondisi baik, berfungsi baik', NULL, NULL, '2022-05-13', '2022-05-13', 'admin'),
(6, 'CTF-I006', 'Pemeriksaan tegangan Voltase output DC power supply, catat hasil pengukuran', 'CTF-P006', NULL, '', NULL, 'Kondisi baik, voltage sesuai', NULL, NULL, '2022-05-13', '2022-05-13', 'admin'),
(7, 'CTF-I007', 'Pemeriksaan meliputi: Tekanan compressed air supply (standard 6 bar), bak penampung regulator CA (buang jika ada air), kondisi hose penumatic', 'CTF-P007', NULL, '', NULL, 'Kondisi baik,  (standard 6 bar)', NULL, NULL, '2022-05-13', '2022-05-13', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `inv_mstr`
--

CREATE TABLE `inv_mstr` (
  `ID` int(11) NOT NULL,
  `inv_site` varchar(8) NOT NULL,
  `inv_loc` varchar(8) NOT NULL,
  `inv_sp` varchar(8) NOT NULL,
  `inv_qty` int(3) NOT NULL,
  `inv_lot` varchar(25) NOT NULL,
  `inv_supp` varchar(8) NOT NULL,
  `inv_date` date NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inv_mstr`
--

INSERT INTO `inv_mstr` (`ID`, `inv_site`, `inv_loc`, `inv_sp`, `inv_qty`, `inv_lot`, `inv_supp`, `inv_date`, `created_at`, `updated_at`) VALUES
(1, '10-200', 'RAK2', '7', 1, '', 'S1209', '2021-03-21', '2021-03-08', '2021-03-08'),
(2, '10-302', 'RAK2', '7', 1, '12', 'S1001', '2021-03-08', '2021-03-08', '2021-03-08'),
(3, '12-100', 'SATU', '5', 1, '12', 'S1001', '2021-03-08', '2021-03-08', '2021-03-08'),
(4, '10-300', 'SATU', '7', 1, '12', 'S0002', '2021-03-08', '2021-03-08', '2021-03-08'),
(5, '21-100', 'RAK1', '4', 1, '12', 'S1001', '2021-03-08', '2021-03-08', '2021-03-08'),
(6, '12-100', 'SATU', '5', 1, '12', 'S1209', '2021-03-21', '2021-03-08', '2021-03-08'),
(7, '10-301', 'SATU', '6', 1, '123', 'S0012', '2021-03-20', '2021-03-08', '2021-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `loc_mstr`
--

CREATE TABLE `loc_mstr` (
  `ID` int(11) NOT NULL,
  `loc_site` varchar(24) NOT NULL,
  `loc_code` varchar(8) NOT NULL,
  `loc_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loc_mstr`
--

INSERT INTO `loc_mstr` (`ID`, `loc_site`, `loc_code`, `loc_desc`, `created_at`, `updated_at`) VALUES
(2, '10-202', 'SATU', 'Test Satu', '2021-02-25', '2021-03-01'),
(3, '12-100', 'SATU', 'Test Satu', '2021-02-25', '2021-02-25'),
(4, '30-100', 'SATU', 'Test Satu', '2021-02-25', '2021-02-25'),
(6, 'R0012', 'DUA', 'Test Dua', '2021-02-25', '2021-02-25'),
(7, '10-100', 'RAK1', 'Susunan Rak1 Edit', '2021-02-26', '2021-03-12'),
(8, '10-100', 'RAK2', 'Susunan Rak 2', '2021-02-26', '2021-02-26'),
(9, '10-202', 'DUA', 'Susunan Rak 1', '2021-03-01', '2021-03-01'),
(10, 'site2', 'LOC1', 'Taman Menteng Edit', '2021-03-12', '2021-03-12'),
(11, '10-303', '123456', '123456789012345678901234', '2021-03-12', '2021-03-12');

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
('0556e2de-cc00-42a9-b115-76d70e463c91', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000084\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-13 07:39:36', '2020-12-22 03:10:11'),
('0c92f477-1398-40f4-8c17-b708775e14ef', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000095\",\"note\":\"Please check\"}', NULL, '2021-01-11 06:02:01', '2021-01-11 06:02:01'),
('0d6e9ff6-4d9b-4675-92d3-056190aacc6b', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Please check\"}', NULL, '2020-11-12 06:44:20', '2020-11-12 06:44:20'),
('0dd1d511-8158-4a89-b59a-91929bceb3eb', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000067\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 04:05:21', '2020-11-11 04:47:18', '2020-12-22 04:05:21'),
('0de7b130-3cda-4069-a4b8-9e4e5e03614b', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:42:04', '2020-11-12 05:10:04', '2020-12-22 03:42:04'),
('0fedcd79-276d-4195-9467-22a65155ad1e', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000076\",\"note\":\"Please check\"}', NULL, '2020-11-12 03:00:01', '2020-11-12 03:00:01'),
('1128316f-f7d5-48c1-b4e1-e301beaf16ab', 'App\\Notifications\\eventNotification', 'App\\User', 45, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000064\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:54:30', '2020-11-11 04:39:17', '2020-12-22 03:54:30'),
('11d5d00d-9627-4ce0-87c6-25c77e42a43f', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000076\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:42:04', '2020-11-12 03:55:01', '2020-12-22 03:42:04'),
('1241ac6e-ecf8-4de2-808d-6c9a0c4660a9', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000097\",\"note\":\"Please check\"}', NULL, '2021-01-11 09:21:10', '2021-01-11 09:21:10'),
('13268f7d-6b87-4f6c-915a-bd7c74968684', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:42:04', '2020-11-12 03:55:50', '2020-12-22 03:42:04'),
('14e3bca7-82d0-446a-bb1c-14b4c0fbcf9b', 'App\\Notifications\\eventNotification', 'App\\User', 52, '{\"data\":\"Following Request for Purchasing has been rejected\",\"url\":\"inputrfp\",\"nbr\":\"RP000063\",\"note\":\"Please check\"}', '2020-12-22 04:06:38', '2020-11-11 03:58:03', '2020-12-22 04:06:38'),
('16efc18b-ce6b-4126-9c6e-58860bd947d9', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000074\",\"note\":\"Please check\"}', NULL, '2020-11-11 08:16:48', '2020-11-11 08:16:48'),
('180dc799-bcc7-4e77-bff3-aaabea8b6214', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000096\",\"note\":\"Please check\"}', NULL, '2021-01-11 05:57:35', '2021-01-11 05:57:35'),
('191b4da9-43df-46ae-b730-0735dc5fbc82', 'App\\Notifications\\eventNotification', 'App\\User', 60, '{\"data\":\"Following Request for Purchasing has been rejected\",\"url\":\"inputrfp\",\"nbr\":\"RP000078\",\"note\":\"Please check\"}', '2020-12-22 03:16:07', '2020-11-12 07:06:53', '2020-12-22 03:16:07'),
('1b84ef51-e890-4aab-9117-7dcbd2808b46', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000098\",\"note\":\"Please check\"}', NULL, '2021-01-20 07:51:36', '2021-01-20 07:51:36'),
('1bc21255-0bf7-49e1-b82d-005eee95f492', 'App\\Notifications\\eventNotification', 'App\\User', 65, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000056\",\"note\":\"Please check\"}', '2020-12-22 04:08:49', '2020-11-09 08:12:38', '2020-12-22 04:08:49'),
('1c7ad190-7e60-44a6-a0ed-dcaa09dbe765', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000079\",\"note\":\"Please check\"}', NULL, '2020-12-21 03:15:43', '2020-12-21 03:15:43'),
('1e7ea4d7-cbd3-455a-8809-51453e8ffff9', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000082\",\"note\":\"Please check\"}', '2020-12-22 04:05:21', '2020-11-13 05:04:22', '2020-12-22 04:05:21'),
('201d4de1-7222-4015-bcbe-a6aee57b5683', 'App\\Notifications\\eventNotification', 'App\\User', 5, '{\"data\":\"Supplier : Heron Surgical Supply has made an offer for following RFQ\",\"url\":\"rfq\",\"nbr\":\"RF000062\",\"note\":\"Please check\"}', NULL, '2021-01-11 09:31:21', '2021-01-11 09:31:21'),
('205a8d90-a8be-4aa3-bbd0-7149fa6d0d76', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000078\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:42:04', '2020-11-12 07:34:59', '2020-12-22 03:42:04'),
('23ffc786-9bff-4a90-aafd-5c6ab208d9a4', 'App\\Notifications\\eventNotification', 'App\\User', 60, '{\"data\":\"Following Request for Purchasing has been rejected\",\"url\":\"inputrfp\",\"nbr\":\"RP000079\",\"note\":\"Please check\"}', '2020-12-22 03:16:07', '2020-11-12 07:54:32', '2020-12-22 03:16:07'),
('2540e5fa-e6f5-45a5-8e58-a86557728986', 'App\\Notifications\\eventNotification', 'App\\User', 61, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000057\",\"note\":\"Please check\"}', NULL, '2020-11-09 08:17:24', '2020-11-09 08:17:24'),
('26c4c8b7-7ab4-4c02-ad57-0cf8227a8bd7', 'App\\Notifications\\eventNotification', 'App\\User', 5, '{\"data\":\"Supplier : Heron Surgical Supply has made an offer for following RFQ\",\"url\":\"rfq\",\"nbr\":\"RF000074\",\"note\":\"Please check\"}', NULL, '2021-01-11 06:15:57', '2021-01-11 06:15:57'),
('2878c8d1-1582-4393-9f47-4e5771fb1e49', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000091\",\"note\":\"Please check\"}', NULL, '2021-01-20 07:40:03', '2021-01-20 07:40:03'),
('29113ccc-1270-48a1-962d-6a829f715e8f', 'App\\Notifications\\eventNotification', 'App\\User', 52, '{\"data\":\"Following Request for Purchasing has been rejected\",\"url\":\"inputrfp\",\"nbr\":\"RP000047\",\"note\":\"Please check\"}', '2020-12-22 04:06:38', '2020-11-09 07:39:42', '2020-12-22 04:06:38'),
('2d7f8ae7-9df3-4e1c-abbe-89e2db35511e', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000088\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-12-21 08:34:42', '2020-12-22 03:10:11'),
('2e0d30db-96a3-4323-969f-692533a6a4e3', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000065\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-11 04:41:48', '2020-12-22 03:10:11'),
('31df2d97-595a-41bd-a14d-6dde84d425ff', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000086\",\"note\":\"Please check\"}', NULL, '2020-11-13 08:00:36', '2020-11-13 08:00:36'),
('3203e8ab-372f-46a8-9069-980c36a17a63', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000097\",\"note\":\"Please check\"}', NULL, '2021-01-11 09:18:16', '2021-01-11 09:18:16'),
('33455027-ffa0-485f-a562-338445403a6e', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000076\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:57:05', '2020-11-12 03:55:01', '2020-12-22 03:57:05'),
('36bf890a-ff0c-4af5-913f-6e6ddc82c359', 'App\\Notifications\\eventNotification', 'App\\User', 45, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000063\",\"note\":\"Please check\"}', '2020-12-22 03:54:30', '2020-11-09 05:01:11', '2020-12-22 03:54:30'),
('3914b84a-2445-4be0-a973-3f8774d4bc2f', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000090\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-12-21 09:51:50', '2020-12-22 03:10:11'),
('3bf2a53e-36bb-4e77-bdea-a795cfe9c8b6', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000080\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-12 08:55:24', '2020-12-22 03:10:11'),
('3c7756c4-8691-4ef2-8c8a-b41e7fb2e4c5', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000095\",\"note\":\"Please check\"}', '2021-01-11 08:00:03', '2021-01-11 06:02:01', '2021-01-11 08:00:03'),
('3d288e1f-298b-4b92-b28d-85addc76bb5d', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000080\",\"note\":\"Please check\"}', NULL, '2020-11-12 08:55:24', '2020-11-12 08:55:24'),
('3d8c029b-6729-4ebb-a652-e035c5d2815f', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000037\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-09 08:06:17', '2020-12-22 03:10:11'),
('4178a169-7d3c-4677-a5ac-64d7dc1369f1', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:57:05', '2020-11-12 03:55:50', '2020-12-22 03:57:05'),
('43ab17f6-bc57-43ee-a48b-5016de07df42', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000083\",\"note\":\"Please check\"}', '2020-12-22 04:05:21', '2020-11-13 05:09:30', '2020-12-22 04:05:21'),
('44894dbd-16e9-4936-a374-ea63a7fbd2f7', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000043\",\"note\":\"Please check\"}', NULL, '2020-11-05 07:12:49', '2020-11-05 07:12:49'),
('44e0ad2c-344c-4aa8-b073-9fa0840daf7a', 'App\\Notifications\\eventNotification', 'App\\User', 45, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000054\",\"note\":\"Please check\"}', '2020-12-22 03:54:30', '2020-11-09 07:22:24', '2020-12-22 03:54:30'),
('4632d519-efb6-49aa-8c42-7424cf78ea14', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:57:05', '2020-11-12 05:23:30', '2020-12-22 03:57:05'),
('49a2783c-8759-4926-a45c-573ca9ea8314', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000075\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-12-21 04:15:20', '2020-12-22 03:10:11'),
('4ca6c7c5-6bca-4454-9564-a34c9ab7effd', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000098\",\"note\":\"Please check\"}', NULL, '2021-01-20 07:51:36', '2021-01-20 07:51:36'),
('5150f4d4-710b-4faa-8c38-c362a5d0b25b', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000039\",\"note\":\"Please check\"}', NULL, '2020-11-09 08:08:21', '2020-11-09 08:08:21'),
('53a52506-b47f-4ac1-a79b-7e81b135c695', 'App\\Notifications\\eventNotification', 'App\\User', 43, '{\"data\":\"There is a new RFQ awaiting your response\",\"url\":\"rfqapprove\",\"nbr\":\"RF000062\",\"note\":\"Please check\"}', NULL, '2021-01-11 09:27:40', '2021-01-11 09:27:40'),
('55f57bb1-d94c-4615-b69b-b4809e86927c', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:42:04', '2020-11-12 05:04:51', '2020-12-22 03:42:04'),
('59b26c12-7b5f-4812-814c-736ece407555', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000043\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-05 07:39:02', '2020-12-22 03:10:11'),
('5cb4c43e-ca7e-43f2-97bd-0ae016fffe10', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000060\",\"note\":\"Please check\"}', NULL, '2020-11-10 03:15:09', '2020-11-10 03:15:09'),
('5d367d4f-01b3-4ceb-b3bd-8a31fa8db9b4', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000073\",\"note\":\"Please check\"}', NULL, '2020-11-11 07:10:13', '2020-11-11 07:10:13'),
('61c3111c-2ac3-4edc-b57c-49961c63ff1c', 'App\\Notifications\\eventNotification', 'App\\User', 52, '{\"data\":\"Following Request for Purchasing has been rejected\",\"url\":\"inputrfp\",\"nbr\":\"RP000057\",\"note\":\"Please check\"}', '2020-12-22 04:06:38', '2020-11-09 08:17:54', '2020-12-22 04:06:38'),
('65f463c4-f8fd-4f9f-b65c-1044452b8886', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000090\",\"note\":\"Please check\"}', NULL, '2020-12-21 09:51:50', '2020-12-21 09:51:50'),
('67998308-6319-414c-900d-b15b6033871e', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000079\",\"note\":\"Please check\"}', NULL, '2021-01-21 11:10:32', '2021-01-21 11:10:32'),
('681ab5eb-9204-4d27-916d-1d4d21660d78', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:42:04', '2020-11-12 05:20:51', '2020-12-22 03:42:04'),
('6c1742bd-b0a3-4f86-b834-fef7cff2d188', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000085\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-13 08:00:45', '2020-12-22 03:10:11'),
('6d0eece3-0b9a-462a-b3c2-df499838d841', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000061\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:57:05', '2020-11-11 04:07:10', '2020-12-22 03:57:05'),
('70910c25-2185-479e-95b0-d08ed3f9aa22', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000061\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:57:05', '2020-11-11 04:08:00', '2020-12-22 03:57:05'),
('7115c9d9-7bb9-4eac-bab8-eb4d9b5883ff', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000076\",\"note\":\"Please check\"}', NULL, '2020-12-21 04:00:47', '2020-12-21 04:00:47'),
('7ac04d35-e7e5-4f1b-aee0-33351c53cb37', 'App\\Notifications\\eventNotification', 'App\\User', 45, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000025\",\"note\":\"Please check\"}', '2020-12-22 03:54:30', '2020-11-09 08:10:15', '2020-12-22 03:54:30'),
('7b2041a8-6c2d-47c2-bdea-5fa7171b5b1f', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000075\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:57:05', '2020-11-13 03:24:02', '2020-12-22 03:57:05'),
('7bde8c11-efe1-42a9-a0b1-b85bca8d5c70', 'App\\Notifications\\eventNotification', 'App\\User', 45, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000067\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:54:30', '2020-11-11 04:47:18', '2020-12-22 03:54:30'),
('7fc2eb07-ee16-436c-bd5b-c5c6abbf0abf', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000089\",\"note\":\"Please check\"}', NULL, '2020-12-21 09:46:02', '2020-12-21 09:46:02'),
('80e1518e-c889-4374-b809-680197d1e5ce', 'App\\Notifications\\eventNotification', 'App\\User', 5, '{\"data\":\"There is a new RFQ awaiting your response\",\"url\":\"rfqapprove\",\"nbr\":\"RF000062\",\"note\":\"Please check\"}', NULL, '2021-01-11 09:27:36', '2021-01-11 09:27:36'),
('8201fe69-50b7-4015-9c95-74733dae23b0', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000075\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:42:04', '2020-11-13 03:24:02', '2020-12-22 03:42:04'),
('8a0fc5f7-3105-45ad-ba57-aa0353e91965', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000097\",\"note\":\"Please check\"}', NULL, '2021-01-11 09:18:16', '2021-01-11 09:18:16'),
('8c850669-4148-4a70-83c2-7ae5c8652856', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000094\",\"note\":\"Please check\"}', '2020-12-22 04:17:20', '2020-12-22 04:17:05', '2020-12-22 04:17:20'),
('8f348e86-f138-410c-94e4-aec562dae237', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:57:05', '2020-11-12 05:10:04', '2020-12-22 03:57:05'),
('8f786ca3-fdda-4dd1-88be-178e0167bfcd', 'App\\Notifications\\eventNotification', 'App\\User', 45, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000057\",\"note\":\"Please check\"}', '2020-12-22 03:54:30', '2020-11-09 08:15:19', '2020-12-22 03:54:30'),
('8f92bf1b-ead2-4a70-bc88-7e91632663c9', 'App\\Notifications\\eventNotification', 'App\\User', 45, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000064\",\"note\":\"Please check\"}', '2020-12-22 03:54:30', '2020-11-09 05:03:00', '2020-12-22 03:54:30'),
('9290522e-712a-4719-8728-89a8739ce62e', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"Following Request for Purchasing has been rejected\",\"url\":\"inputrfp\",\"nbr\":\"RP000091\",\"note\":\"Please check\"}', '2020-12-22 03:42:04', '2020-12-21 09:53:59', '2020-12-22 03:42:04'),
('931d3e89-63f9-4601-82ae-2b4c982d4a04', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000079\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-12-21 03:15:43', '2020-12-22 03:10:11'),
('94fd1859-6f38-4aa3-85b0-8cd49d2e6a8b', 'App\\Notifications\\eventNotification', 'App\\User', 61, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000055\",\"note\":\"Please check\"}', NULL, '2020-11-09 07:39:01', '2020-11-09 07:39:01'),
('972e90ad-89a5-427a-8383-58ea81501eb5', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000079\",\"note\":\"Please check\"}', NULL, '2021-01-21 11:10:32', '2021-01-21 11:10:32'),
('9cd86b5f-d215-4c0a-b577-318211ae313b', 'App\\Notifications\\eventNotification', 'App\\User', 45, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000053\",\"note\":\"Please check\"}', '2020-12-22 03:54:30', '2020-11-09 07:08:54', '2020-12-22 03:54:30'),
('9d3fe459-6099-45d5-986e-1e231acb6078', 'App\\Notifications\\eventNotification', 'App\\User', 45, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000056\",\"note\":\"Please check\"}', '2020-12-22 03:54:30', '2020-11-09 08:12:38', '2020-12-22 03:54:30'),
('9ea1dd66-ab40-4dc6-a467-dda9dbbb1a86', 'App\\Notifications\\eventNotification', 'App\\User', 52, '{\"data\":\"Following Request for Purchasing has been rejected\",\"url\":\"inputrfp\",\"nbr\":\"RP000046\",\"note\":\"Please check\"}', '2020-12-22 04:06:38', '2020-11-09 08:04:06', '2020-12-22 04:06:38'),
('a18054ec-f07f-4f7d-ac1d-541a27bf9ecf', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000081\",\"note\":\"Please check\"}', NULL, '2020-11-12 08:59:41', '2020-11-12 08:59:41'),
('a2d37044-d463-43af-b327-542588d1f8c8', 'App\\Notifications\\eventNotification', 'App\\User', 65, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000054\",\"note\":\"Please check\"}', '2020-12-22 04:08:49', '2020-11-09 07:22:24', '2020-12-22 04:08:49'),
('a4ddf9f5-7c0c-40dd-a1b0-4229b9e811f7', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000085\",\"note\":\"Please check\"}', NULL, '2020-11-13 08:00:45', '2020-11-13 08:00:45'),
('a59a5beb-0e17-4d20-a112-21a15b282cd9', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000087\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-12-21 04:25:12', '2020-12-22 03:10:11'),
('a5f27c27-ff65-41d7-908e-12611f20991a', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-12 06:44:20', '2020-12-22 03:10:11'),
('a7d9dbec-079f-442d-a3c9-1b07b9043dff', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000042\",\"note\":\"Please check\"}', '2020-12-22 03:57:05', '2020-11-09 08:18:27', '2020-12-22 03:57:05'),
('a92734ca-7d3c-418f-a2e7-1c1386b0f196', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000093\",\"note\":\"Please check\"}', NULL, '2020-12-22 02:51:19', '2020-12-22 02:51:19'),
('aa38f7fa-64aa-4b9f-a2b7-a105976ccbbb', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000087\",\"note\":\"Please check\"}', NULL, '2020-12-21 04:25:12', '2020-12-21 04:25:12'),
('aa3baa8f-d058-4fb9-9d09-44cce98f6875', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000042\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-09 08:18:27', '2020-12-22 03:10:11'),
('aac01bda-f63b-4f7a-b377-c28edf814773', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:42:04', '2020-11-12 04:23:20', '2020-12-22 03:42:04'),
('ab857138-fa79-448c-a37c-207d64059821', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:57:05', '2020-11-12 04:23:20', '2020-12-22 03:57:05'),
('acb0a2f0-90ae-485e-9175-da9142263d01', 'App\\Notifications\\eventNotification', 'App\\User', 65, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000057\",\"note\":\"Please check\"}', '2020-12-22 04:08:49', '2020-11-09 08:15:19', '2020-12-22 04:08:49'),
('ad4321d7-db4c-4671-9662-924ca0b759d2', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000076\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-12-21 04:00:47', '2020-12-22 03:10:11'),
('addfac0a-0b88-498a-8d48-214d420e6165', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000088\",\"note\":\"Please check\"}', NULL, '2020-12-21 08:34:42', '2020-12-21 08:34:42'),
('ae56ee43-0ebf-4578-8601-e98bf8d6fc6e', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000065\",\"note\":\"Please check\"}', NULL, '2020-11-11 04:41:48', '2020-11-11 04:41:48'),
('afb99412-c7f1-4ceb-b370-1ac48d3edfcb', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000086\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-13 08:00:36', '2020-12-22 03:10:11'),
('b029a75b-3588-4ca7-a05b-0a116cddb344', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000074\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-11 08:16:48', '2020-12-22 03:10:11'),
('b4aab2de-75e9-4ce6-99a1-1f33d2e075fb', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000043\",\"note\":\"Please check\"}', NULL, '2020-11-05 07:39:02', '2020-11-05 07:39:02'),
('b6533fba-9b4a-4ace-b8a9-6550f04da5ba', 'App\\Notifications\\eventNotification', 'App\\User', 43, '{\"data\":\"Supplier : Sungro Chemicals has made an offer for following RFQ\",\"url\":\"rfq\",\"nbr\":\"RF000074\",\"note\":\"Please check\"}', NULL, '2021-01-11 06:16:46', '2021-01-11 06:16:46'),
('b8716754-1378-4707-809f-424d482acd9b', 'App\\Notifications\\eventNotification', 'App\\User', 45, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000055\",\"note\":\"Please check\"}', '2020-12-22 03:54:30', '2020-11-09 07:29:28', '2020-12-22 03:54:30'),
('b8a4afed-5222-4586-acbc-2c5648bf7a7f', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000061\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:42:04', '2020-11-11 04:08:00', '2020-12-22 03:42:04'),
('b96011a0-36e7-4cc3-98cf-266f59884dca', 'App\\Notifications\\eventNotification', 'App\\User', 60, '{\"data\":\"Following Request for Purchasing has been rejected\",\"url\":\"inputrfp\",\"nbr\":\"RP000079\",\"note\":\"Please check\"}', '2020-12-22 03:16:07', '2020-12-21 04:08:21', '2020-12-22 03:16:07'),
('ba24709f-c0f5-4095-9391-b9809b515a30', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:42:04', '2020-11-12 05:23:30', '2020-12-22 03:42:04'),
('ba46f156-df1a-48e8-bfba-37938fbbc1c8', 'App\\Notifications\\eventNotification', 'App\\User', 60, '{\"data\":\"Following Request for Purchasing has been rejected\",\"url\":\"inputrfp\",\"nbr\":\"RP000075\",\"note\":\"Please check\"}', '2020-12-22 03:16:07', '2020-11-12 06:47:20', '2020-12-22 03:16:07'),
('ba4b6e7f-6b9e-40fa-8c7c-15dd748da896', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000043\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-05 07:12:49', '2020-12-22 03:10:11'),
('bc6afaaa-b014-41eb-b784-023afa7cf5da', 'App\\Notifications\\eventNotification', 'App\\User', 61, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000054\",\"note\":\"Please check\"}', NULL, '2020-11-11 05:50:35', '2020-11-11 05:50:35'),
('bfde98a3-066c-4400-be52-9501258d74fb', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000070\",\"note\":\"Please check\"}', NULL, '2020-11-11 05:22:49', '2020-11-11 05:22:49'),
('c23ca20a-a9a5-45b6-9956-cd17ec6e6bcb', 'App\\Notifications\\eventNotification', 'App\\User', 43, '{\"data\":\"Supplier : Sungro Chemicals has made an offer for following RFQ\",\"url\":\"rfq\",\"nbr\":\"RF000062\",\"note\":\"Please check\"}', NULL, '2021-01-11 09:30:18', '2021-01-11 09:30:18'),
('ce6b2b6e-6e1a-4e58-80ed-58229ef5e0a3', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000078\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:57:05', '2020-11-12 07:34:59', '2020-12-22 03:57:05'),
('cf0c9c99-001a-4ca0-999d-90bb94ff5d0e', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000096\",\"note\":\"Please check\"}', '2021-01-11 08:00:03', '2021-01-11 05:57:34', '2021-01-11 08:00:03'),
('d7121eae-4ab1-4b6f-b7ff-ce57482991ef', 'App\\Notifications\\eventNotification', 'App\\User', 45, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000082\",\"note\":\"Please check\"}', '2020-12-22 03:44:21', '2020-11-13 05:04:22', '2020-12-22 03:44:21'),
('d75f7953-8b42-4292-9066-4733e853b951', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000070\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-11 05:22:49', '2020-12-22 03:10:11'),
('dae2d66b-94ec-4501-920b-3bb2a2af2b27', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:57:05', '2020-11-12 05:20:51', '2020-12-22 03:57:05'),
('db12acad-6c1c-4184-be82-ac6e0e22e6b8', 'App\\Notifications\\eventNotification', 'App\\User', 65, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000053\",\"note\":\"Please check\"}', '2020-12-22 04:08:49', '2020-11-09 07:08:54', '2020-12-22 04:08:49'),
('dd13ad5b-d7be-4939-a593-1052535d442d', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000084\",\"note\":\"Please check\"}', NULL, '2020-11-13 07:39:36', '2020-11-13 07:39:36'),
('dd39d2c2-befc-4b33-9d02-a7b9383bdf4f', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000091\",\"note\":\"Please check\"}', NULL, '2021-01-20 07:40:03', '2021-01-20 07:40:03'),
('dd446c89-b1c0-4efc-b202-1da9f67b8098', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000039\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-09 08:08:21', '2020-12-22 03:10:11'),
('dd46b730-7b95-4f8f-a00a-22a89e4b280f', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000075\",\"note\":\"Please check\"}', NULL, '2020-12-21 04:15:20', '2020-12-21 04:15:20'),
('dda218d7-d198-499f-ad77-3faaf96ff3cf', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000081\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-12 08:59:41', '2020-12-22 03:10:11'),
('e00152c8-2ade-497c-b8fa-c9f9e3fe8d17', 'App\\Notifications\\eventNotification', 'App\\User', 65, '{\"data\":\"There is a new RFP awaiting your response\",\"url\":\"rfpapproval\",\"nbr\":\"RP000055\",\"note\":\"Please check\"}', '2020-12-22 04:08:49', '2020-11-09 07:29:28', '2020-12-22 04:08:49'),
('e0292aa1-92ad-4239-bda1-4cac163300a8', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000037\",\"note\":\"Please check\"}', NULL, '2020-11-09 08:06:17', '2020-11-09 08:06:17'),
('e1ade165-8b15-4150-b94a-6aac402d2aac', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000097\",\"note\":\"Please check\"}', NULL, '2021-01-11 09:21:10', '2021-01-11 09:21:10'),
('e558460c-17c5-44aa-ba4c-fd050df152cf', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000071\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-11 05:22:38', '2020-12-22 03:10:11'),
('e8828143-c1eb-4126-84cf-99ec0a053b60', 'App\\Notifications\\eventNotification', 'App\\User', 62, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000061\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:42:04', '2020-11-11 04:07:10', '2020-12-22 03:42:04'),
('e9586b62-e995-487c-ad35-48246999558e', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000073\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-11 07:10:13', '2020-12-22 03:10:11'),
('ecaff930-f5a1-4129-bfc2-63e3cda9f0f5', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000094\",\"note\":\"Please check\"}', NULL, '2020-12-22 04:17:05', '2020-12-22 04:17:05'),
('ed915c7c-3d2b-4782-9783-d695ac3b6b84', 'App\\Notifications\\eventNotification', 'App\\User', 47, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000077\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 03:57:05', '2020-11-12 05:04:51', '2020-12-22 03:57:05'),
('eecd384b-8203-4330-9263-cf166a57ebaf', 'App\\Notifications\\eventNotification', 'App\\User', 59, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000071\",\"note\":\"Please check\"}', NULL, '2020-11-11 05:22:38', '2020-11-11 05:22:38'),
('eee3bac8-ad09-4fa2-8087-25886396811b', 'App\\Notifications\\eventNotification', 'App\\User', 46, '{\"data\":\"There are updates on following RFP\",\"url\":\"rfpapproval\",\"nbr\":\"RP000064\",\"note\":\"Approval is needed, Please check\"}', '2020-12-22 04:05:21', '2020-11-11 04:39:17', '2020-12-22 04:05:21'),
('f3b44216-3bb0-45aa-8007-cd74aa68b182', 'App\\Notifications\\eventNotification', 'App\\User', 50, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000055\",\"note\":\"Please check\"}', '2020-12-22 04:00:59', '2020-11-09 07:39:01', '2020-12-22 04:00:59'),
('f42fd7a1-12a2-45d8-877f-decaa0a1ea49', 'App\\Notifications\\eventNotification', 'App\\User', 5, '{\"data\":\"New purchase order available for you\",\"url\":\"poreceipt\",\"nbr\":\"RCP8\",\"note\":\"Please check\"}', NULL, '2021-01-11 06:25:51', '2021-01-11 06:25:51'),
('f6b9a627-1b3d-49f0-931b-af30409bd91b', 'App\\Notifications\\eventNotification', 'App\\User', 43, '{\"data\":\"Supplier : Sungro Chemicals has made an offer for following RFQ\",\"url\":\"rfq\",\"nbr\":\"RF000075\",\"note\":\"Please check\"}', NULL, '2021-01-11 06:10:06', '2021-01-11 06:10:06'),
('f81e0528-2c21-41af-9cc5-36f8af05afbe', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000089\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-12-21 09:46:02', '2020-12-22 03:10:11'),
('fc4c7339-426a-4578-ba9e-e0ec113181a6', 'App\\Notifications\\eventNotification', 'App\\User', 63, '{\"data\":\"There is a RFP awaiting for approval\",\"url\":\"rfpapproval\",\"nbr\":\"RP000076\",\"note\":\"Please check\"}', '2020-12-22 03:10:11', '2020-11-12 03:00:01', '2020-12-22 03:10:11');

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
  `repdet_code` varchar(10) NOT NULL,
  `repdet_step` int(11) NOT NULL,
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
(14, 'CTF-R003', 1, 'CTF-I007', NULL, NULL, NULL, '2022-05-13', '2022-05-13', 'admin'),
(15, 'CTF-R001', 1, 'CTF-I001', NULL, NULL, NULL, '2022-08-30', '2022-08-30', 'admin'),
(16, 'CTF-R001', 2, 'CTF-I002', NULL, NULL, NULL, '2022-08-30', '2022-08-30', 'admin'),
(17, 'CTF-R002', 1, 'CTF-I006', NULL, NULL, NULL, '2022-08-30', '2022-08-30', 'admin'),
(18, 'CTF-R002', 2, 'CTF-I007', NULL, NULL, NULL, '2022-08-30', '2022-08-30', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `rep_ins`
--

CREATE TABLE `rep_ins` (
  `ID` int(11) NOT NULL,
  `repins_code` varchar(8) NOT NULL,
  `repins_step` int(2) NOT NULL,
  `repins_ins` varchar(8) NOT NULL,
  `repins_tool` varchar(8) NOT NULL,
  `repins_hour` decimal(3,1) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rep_ins`
--

INSERT INTO `rep_ins` (`ID`, `repins_code`, `repins_step`, `repins_ins`, `repins_tool`, `repins_hour`, `created_at`, `updated_at`) VALUES
(3, '2', 1, '12312', '8', '15.0', '2021-03-08', '2021-03-10'),
(4, '3', 1, '12312', '3', '50.0', '2021-03-08', '2021-03-11'),
(5, '6', 1, '2', '3', '13.0', '2021-03-08', '2021-03-10'),
(7, '234', 1, '12', '4', '1.0', '2021-03-08', '2021-03-08'),
(9, '3', 12, '2', '3', '9.9', '2021-03-10', '2021-03-10'),
(10, '3', 34, '3', '3', '12.0', '2021-03-10', '2021-03-11'),
(11, '6', 12, '2', '3', '9.9', '2021-03-10', '2021-03-10'),
(12, '234', 12, '3', '4', '9.9', '2021-03-10', '2021-03-10'),
(14, '2', 1, '1', '1', '99.9', '2021-03-10', '2021-03-10'),
(15, '6', 12, '3', '3', '9.9', '2021-03-10', '2021-03-10'),
(16, '8', 12, '112', '4', '9.9', '2021-03-10', '2021-03-10');

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
(1, 'Rtest', 'Repair test', NULL, NULL, NULL, '2021-10-06', '2021-10-06', 'admin'),
(2, 'CTF-R001', 'Mechanical Part', NULL, NULL, 'Cream Tube Filling', '2022-05-13', '2022-08-30', 'admin'),
(3, 'CTF-R002', 'Electrical Part', NULL, NULL, 'Cream Tube Filling', '2022-05-13', '2022-08-30', 'admin'),
(4, 'CTF-R003', 'Pneumatic Part', NULL, NULL, 'Cream Tube Filling', '2022-05-13', '2022-05-13', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `rep_mstr`
--

CREATE TABLE `rep_mstr` (
  `ID` int(11) NOT NULL,
  `rep_code` varchar(8) NOT NULL,
  `rep_num` int(3) NOT NULL,
  `rep_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rep_mstr`
--

INSERT INTO `rep_mstr` (`ID`, `rep_code`, `rep_num`, `rep_desc`, `created_at`, `updated_at`) VALUES
(3, '3', 134, '12346789', '2021-03-07', '2021-03-07'),
(4, '4', 234, 'asfdgfhgjhki', '2021-03-07', '2021-03-07'),
(5, '6', 213, 'sdfgfgh', '2021-03-07', '2021-03-07'),
(6, '8', 123, 'asdfhgj', '2021-03-07', '2021-03-07'),
(8, '234', 132, 'asdgfghjkllk', '2021-03-07', '2021-03-07'),
(9, '12', 1, '1212', '2021-03-13', '2021-03-13'),
(10, '12', 2, '12112', '2021-03-13', '2021-03-13'),
(11, 'repa', 1, '123456789012345678901234567890', '2021-03-13', '2021-03-13'),
(12, 'repa', 2, 'bongkar', '2021-03-13', '2021-03-13'),
(13, 'repa', 3, 'dilap', '2021-03-13', '2021-03-13'),
(14, 'repb', 1, 'bongkar', '2021-03-13', '2021-03-13'),
(15, 'repb', 2, 'dilap', '2021-03-13', '2021-03-13'),
(16, 'repb', 3, 'periksa', '2021-03-13', '2021-03-13');

-- --------------------------------------------------------

--
-- Table structure for table `rep_part`
--

CREATE TABLE `rep_part` (
  `ID` int(11) NOT NULL,
  `reppart_code` varchar(8) NOT NULL,
  `reppart_step` int(2) NOT NULL,
  `reppart_sp` varchar(8) NOT NULL,
  `reppart_qty` int(3) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rep_part`
--

INSERT INTO `rep_part` (`ID`, `reppart_code`, `reppart_step`, `reppart_sp`, `reppart_qty`, `created_at`, `updated_at`) VALUES
(1, '6', 12, '4', 123, '2021-03-07', '2021-03-07'),
(2, '6', 12, '4', 123, '2021-03-07', '2021-03-07'),
(3, '6', 12, '2', 123, '2021-03-07', '2021-03-07'),
(4, '3', 32, '2', 2, '2021-03-07', '2021-03-11'),
(5, '2', 12, '7', 123, '2021-03-07', '2021-03-11'),
(6, '2', 12, '7', 123, '2021-03-07', '2021-03-11'),
(7, '8', 21, '6', 123, '2021-03-07', '2021-03-07'),
(10, 'repa', 1, '2', 1, '2021-03-13', '2021-03-13');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_code` varchar(24) NOT NULL,
  `role_desc` varchar(50) NOT NULL,
  `role_access` varchar(8) NOT NULL,
  `menu_access` varchar(500) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_code`, `role_desc`, `role_access`, `menu_access`, `created_at`, `updated_at`, `edited_by`) VALUES
('ADMIN', 'Admin', 'Engineer', 'MT02MT03MT04MT07MT05MT06MT13MT08MT09MT10MT11MT12MT14MT15MT16MT18MT17MT20MT19MT21MT22MT26WO05WO02WO03WO01WO06SR01SR02SR03SR04US01US02MT99BO01RT01RT02RT03RT04RT05', '2020-11-02 13:45:45', '2022-08-26 13:14:09', 'admin'),
('SPVSR', 'Supervisor', 'Engineer', 'MT03MT04MT13MT08MT09MT15MT16MT18MT17MT19WO05WO02WO03WO01WO06SR01SR02SR03SR04', '2021-04-09 10:56:25', '2021-10-04 17:39:02', 'admin01'),
('TECH', 'Technician', 'Engineer', 'WO05WO02WO03WO06SR01SR03RT01RT03', '2021-04-09 10:53:39', '2021-10-22 11:01:43', 'admin'),
('USER', 'User', 'User', 'WO05SR01SR03SR04', '2021-04-09 11:01:59', '2021-10-04 17:40:26', 'admin01');

-- --------------------------------------------------------

--
-- Table structure for table `running_mstr`
--

CREATE TABLE `running_mstr` (
  `id` int(11) NOT NULL,
  `sr_prefix` varchar(20) NOT NULL,
  `wo_prefix` varchar(20) NOT NULL,
  `wd_prefix` varchar(5) NOT NULL,
  `wt_prefix` varchar(25) DEFAULT NULL,
  `bo_prefix` varchar(20) DEFAULT NULL,
  `sr_nbr` varchar(20) NOT NULL,
  `wo_nbr` varchar(20) NOT NULL,
  `wd_nbr` varchar(8) NOT NULL,
  `wt_nbr` varchar(24) DEFAULT NULL,
  `bo_nbr` varchar(20) DEFAULT NULL,
  `year` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `running_mstr`
--

INSERT INTO `running_mstr` (`id`, `sr_prefix`, `wo_prefix`, `wd_prefix`, `wt_prefix`, `bo_prefix`, `sr_nbr`, `wo_nbr`, `wd_nbr`, `wt_nbr`, `bo_nbr`, `year`) VALUES
(1, 'SR', 'WO', 'WD', 'PM', 'BO', '0046', '0061', '0009', '4770', '0001', '21');

-- --------------------------------------------------------

--
-- Table structure for table `service_req_mstr`
--

CREATE TABLE `service_req_mstr` (
  `id_sr` int(11) NOT NULL,
  `sr_number` varchar(24) DEFAULT NULL,
  `wo_number` varchar(24) DEFAULT NULL,
  `sr_assetcode` varchar(50) NOT NULL,
  `sr_wotype` varchar(100) DEFAULT NULL,
  `sr_impact` varchar(100) DEFAULT NULL,
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
  `sr_access` int(11) NOT NULL,
  `sr_failurecode1` varchar(50) DEFAULT NULL,
  `sr_failurecode2` varchar(50) DEFAULT NULL,
  `sr_failurecode3` varchar(50) DEFAULT NULL,
  `sr_accept_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_req_mstr`
--

INSERT INTO `service_req_mstr` (`id_sr`, `sr_number`, `wo_number`, `sr_assetcode`, `sr_wotype`, `sr_impact`, `sr_note`, `sr_status`, `sr_priority`, `sr_dept`, `uncompleted_note`, `rejectnote`, `req_by`, `req_username`, `sr_created_at`, `sr_updated_at`, `sr_access`, `sr_failurecode1`, `sr_failurecode2`, `sr_failurecode3`, `sr_accept_date`) VALUES
(1, 'SR-21-0044', NULL, '17.03', 'CLB', 'QLTY', 'sdadas', 0, 'low', 'ENG', NULL, NULL, 'Admin IMI', 'admin', '2022-08-26 14:18:28', '2022-08-26 14:18:28', 1, NULL, NULL, NULL, NULL),
(2, 'SR-21-0045', 'WO-21-0059', '17.02', 'COR', 'RLT', 'ytj', 3, 'low', 'ENG', NULL, NULL, 'Admin IMI', 'admin', '2022-08-26 14:30:51', '2022-08-26 14:52:56', 0, NULL, NULL, NULL, NULL),
(3, 'SR-21-0046', 'WO-21-0060', '17.01', 'CLB', 'QLTY', 'Catatan', 3, 'low', 'ENG', NULL, NULL, 'Admin IMI', 'admin', '2022-08-30 10:32:32', '2022-08-30 11:01:02', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_mstrs`
--

CREATE TABLE `site_mstrs` (
  `site_code` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_desc` varchar(24) NOT NULL,
  `site_flag` varchar(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_mstrs`
--

INSERT INTO `site_mstrs` (`site_code`, `site_desc`, `site_flag`, `created_at`, `updated_at`) VALUES
('10-100', 'Ultrasound Mfg Site Yang', NULL, '2020-12-01 04:59:12', '2021-03-12 06:04:53'),
('10-200', 'Automotive Mfg TKas', NULL, '2020-12-01 04:59:12', '2021-02-25 04:31:27'),
('10-201', 'Lean Manufacturing Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('10-202', 'Automotive Mfg Site 2', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('10-300', 'Process Mfg Site Edit', NULL, '2020-12-01 04:59:12', '2021-03-01 11:05:22'),
('10-301', 'Distribution Site 1', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('10-302', 'Distribution Site 2', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('10-303', 'Distribution Site 3', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('10-400', 'Food & Bev Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('10-500', 'Pharmaceutical Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('11-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('12-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('20-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('21-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('22-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('30-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('31-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('PHSMG', 'PHAPROS', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12'),
('R0012', 'Pusat', 'N', NULL, '2020-11-02 06:20:31'),
('R0013', 'Cabang', 'N', NULL, NULL),
('R0014', 'abebe', 'Y', NULL, NULL),
('R0015', 'a', 'Y', NULL, NULL),
('site1', 'bagian utara', NULL, '2021-03-12 06:03:47', '2021-03-12 06:03:47'),
('site2', 'bagian selatan', NULL, '2021-03-12 06:03:58', '2021-03-12 06:03:58');

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
(1, 'WELDING', 'Welding', NULL, '2022-05-13', '2022-05-13', 'admin'),
(2, 'ELECTRIC', 'Electric', NULL, '2022-05-13', '2022-05-13', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `so_dets`
--

CREATE TABLE `so_dets` (
  `id` int(11) NOT NULL,
  `sod_line` int(24) NOT NULL,
  `sod_nbr` varchar(12) NOT NULL,
  `sod_itemcode` varchar(20) NOT NULL,
  `sod_itemcode_desc` varchar(250) NOT NULL,
  `qty_order` decimal(11,2) NOT NULL,
  `qty_topick` decimal(11,2) DEFAULT NULL,
  `qty_toship` decimal(11,2) DEFAULT NULL,
  `um` varchar(2) NOT NULL,
  `sod_status` int(11) NOT NULL,
  `loc` varchar(24) DEFAULT NULL,
  `lot` varchar(24) DEFAULT NULL,
  `loc_avail` varchar(24) DEFAULT NULL,
  `lot_avail` varchar(24) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `so_dets`
--

INSERT INTO `so_dets` (`id`, `sod_line`, `sod_nbr`, `sod_itemcode`, `sod_itemcode_desc`, `qty_order`, `qty_topick`, `qty_toship`, `um`, `sod_status`, `loc`, `lot`, `loc_avail`, `lot_avail`, `created_at`, `updated_at`) VALUES
(14, 1, 'RF1', 'FG-RF', 'Finished Goods RF', '10.00', '10.00', NULL, 'EA', 1, 'FG-RF', '', NULL, NULL, '2021-02-18 14:47:00', NULL),
(15, 1, 'tes1', 'ab', '', '29.00', '29.00', NULL, 'EA', 1, '010', '', NULL, NULL, '2021-02-18 14:47:00', NULL),
(16, 2, 'tes1', 'ab', '', '10.00', '10.00', NULL, 'EA', 1, '010', '', NULL, NULL, '2021-02-18 14:47:00', NULL),
(17, 2, '10000006', '01011', 'Supplies Kit', '100.00', '100.00', NULL, 'EA', 1, '010', '', NULL, NULL, '2021-02-18 14:51:37', NULL),
(18, 5, '10S10090', '01011', 'Supplies Kit', '1.00', '1.00', NULL, 'EA', 1, '010', '', NULL, NULL, '2021-02-18 14:51:37', NULL),
(19, 1, '10S10126', '01011', 'Supplies Kit', '99.00', '99.00', NULL, 'EA', 1, '010', '', NULL, NULL, '2021-02-18 14:51:37', NULL),
(20, 2, '10000005', '01011', 'Supplies Kit', '17.00', '17.00', NULL, 'EA', 1, '010', '', NULL, NULL, '2021-02-18 15:51:23', NULL),
(21, 1, '10000011', '01011', 'Supplies Kit', '17.00', '17.00', NULL, 'EA', 1, '010', '', NULL, NULL, '2021-02-18 15:51:23', NULL),
(22, 1, '10000015', '01011', 'Supplies Kit', '17.00', '10.00', NULL, 'EA', 1, '010', '', NULL, NULL, '2021-02-18 15:51:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `so_dets_tmp`
--

CREATE TABLE `so_dets_tmp` (
  `id_det_tmp` int(24) NOT NULL,
  `sod_line_tmp` varchar(24) NOT NULL,
  `sonbr_det_tmp` varchar(50) NOT NULL,
  `item_code_tmp` varchar(50) NOT NULL,
  `item_desc_tmp` varchar(250) DEFAULT NULL,
  `item_um_tmp` varchar(12) NOT NULL,
  `qty_order_tmp` decimal(12,2) NOT NULL,
  `qty_ship_tmp` decimal(11,2) DEFAULT NULL,
  `qty_pick_tmp` decimal(12,2) DEFAULT NULL,
  `loc_tmp` varchar(50) DEFAULT NULL,
  `lot_tmp` varchar(50) DEFAULT NULL,
  `session_user_det` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `so_dets_tmp`
--

INSERT INTO `so_dets_tmp` (`id_det_tmp`, `sod_line_tmp`, `sonbr_det_tmp`, `item_code_tmp`, `item_desc_tmp`, `item_um_tmp`, `qty_order_tmp`, `qty_ship_tmp`, `qty_pick_tmp`, `loc_tmp`, `lot_tmp`, `session_user_det`, `created_at`, `updated_at`) VALUES
(228, '2', '10000006', '01011', 'Supplies Kit', 'EA', '100.00', NULL, NULL, '010', '', 'admin', '2021-02-18 16:06:28', NULL),
(229, '5', '10S10090', '01011', 'Supplies Kit', 'EA', '1.00', NULL, NULL, '010', '', 'admin', '2021-02-18 16:06:28', NULL),
(230, '1', '10S10126', '01011', 'Supplies Kit', 'EA', '99.00', NULL, NULL, '010', '', 'admin', '2021-02-18 16:06:28', NULL),
(231, '1', 'tes1', 'ab', '', 'EA', '29.00', NULL, NULL, '010', '', 'admin', '2021-02-18 16:06:28', NULL),
(232, '2', 'tes1', 'ab', '', 'EA', '10.00', NULL, NULL, '010', '', 'admin', '2021-02-18 16:06:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `so_mstrs`
--

CREATE TABLE `so_mstrs` (
  `id` int(24) NOT NULL,
  `so_nbr` varchar(50) NOT NULL,
  `so_cust` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_duedate` date NOT NULL,
  `so_shipto` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_status` int(11) NOT NULL,
  `pic_wh` varchar(24) DEFAULT NULL,
  `salesperson` varchar(50) DEFAULT NULL,
  `pic_qc` varchar(250) DEFAULT NULL,
  `pic_logistik` varchar(250) DEFAULT NULL,
  `pic_driver` varchar(250) DEFAULT NULL,
  `trolley_so` varchar(24) DEFAULT NULL,
  `reason` varchar(250) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `so_mstrs`
--

INSERT INTO `so_mstrs` (`id`, `so_nbr`, `so_cust`, `so_duedate`, `so_shipto`, `so_status`, `pic_wh`, `salesperson`, `pic_qc`, `pic_logistik`, `pic_driver`, `trolley_so`, `reason`, `created_at`, `updated_at`) VALUES
(14, 'RF1', 'CUST-RF', '2021-02-19', 'CUST-RF', 1, '', '', NULL, NULL, NULL, NULL, NULL, '2021-02-18 14:47:00', NULL),
(15, 'tes1', '10-100', '2020-11-26', '10-100', 1, NULL, '', NULL, NULL, NULL, NULL, NULL, '2021-02-18 14:47:00', NULL),
(16, '10000006', '10C1000', '2020-12-07', '10C1000', 3, 'admin', '10SP01', NULL, NULL, NULL, NULL, NULL, '2021-02-18 14:51:37', NULL),
(17, '10S10090', '10C1003', '2020-11-30', '10C1003', 3, 'admin', '10SP01', NULL, NULL, NULL, NULL, NULL, '2021-02-18 14:51:37', NULL),
(18, '10S10126', '10C1000', '2020-12-02', '10-100', 3, 'admin', '', NULL, NULL, NULL, NULL, NULL, '2021-02-18 14:51:37', NULL),
(19, '10000005', '10C1000', '2021-03-31', '10C1000', 3, 'admin', '22SP02', NULL, NULL, NULL, NULL, NULL, '2021-02-18 15:51:23', NULL),
(20, '10000011', '10C1000', '2021-03-31', '10C1000', 3, 'admin', '22SP02', NULL, NULL, NULL, NULL, NULL, '2021-02-18 15:51:23', NULL),
(21, '10000015', '10C1010', '2021-03-31', '10C1000', 3, 'admin', '22SP22', NULL, NULL, NULL, NULL, NULL, '2021-02-18 15:51:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `so_mstr_tmp`
--

CREATE TABLE `so_mstr_tmp` (
  `id_mstr_tmp` int(50) NOT NULL,
  `sonbr_mstr_tmp` varchar(250) NOT NULL,
  `socust_tmp` varchar(50) NOT NULL,
  `soshipto_tmp` varchar(50) NOT NULL,
  `duedate_tmp` date NOT NULL,
  `salespsn_tmp` varchar(50) DEFAULT NULL,
  `flag` varchar(10) DEFAULT NULL,
  `session_user` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `so_mstr_tmp`
--

INSERT INTO `so_mstr_tmp` (`id_mstr_tmp`, `sonbr_mstr_tmp`, `socust_tmp`, `soshipto_tmp`, `duedate_tmp`, `salespsn_tmp`, `flag`, `session_user`, `created_at`, `updated_at`) VALUES
(175, '10000006', '10C1000', '10C1000', '2020-12-07', '10SP01', 'Y', 'admin', '2021-02-18 16:06:28', NULL),
(176, '10S10090', '10C1003', '10C1003', '2020-11-30', '10SP01', 'Y', 'admin', '2021-02-18 16:06:28', NULL),
(177, '10S10126', '10C1000', '10-100', '2020-12-02', '', 'Y', 'admin', '2021-02-18 16:06:28', NULL),
(178, 'tes1', '10-100', '10-100', '2020-11-26', '', 'Y', 'admin', '2021-02-18 16:06:28', '2021-02-18 16:06:28');

-- --------------------------------------------------------

--
-- Table structure for table `sp_group`
--

CREATE TABLE `sp_group` (
  `ID` int(11) NOT NULL,
  `spg_code` varchar(8) NOT NULL,
  `spg_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sp_group`
--

INSERT INTO `sp_group` (`ID`, `spg_code`, `spg_desc`, `created_at`, `updated_at`) VALUES
(1, '1', '1234567890123', '2021-03-07', '2021-03-07'),
(2, '2', 'qwertyuiop', '2021-03-07', '2021-03-07'),
(3, '3', 'asdfghjkl', '2021-03-07', '2021-03-07'),
(4, '4', 'zxcvbnm', '2021-03-07', '2021-03-07'),
(7, '7', 'asdfghjkl;asdfghjkl', '2021-03-07', '2021-03-07'),
(8, '8', '123456789012345678901234567890', '2021-03-07', '2021-03-13'),
(9, 'gr1', 'untuk office', '2021-03-13', '2021-03-13'),
(10, 'gp2', 'untuk pabrik', '2021-03-13', '2021-03-13'),
(11, 'gp3', 'untuk gudang', '2021-03-13', '2021-03-13');

-- --------------------------------------------------------

--
-- Table structure for table `sp_mstr`
--

CREATE TABLE `sp_mstr` (
  `ID` int(11) NOT NULL,
  `spm_code` varchar(8) NOT NULL,
  `spm_desc` varchar(30) NOT NULL,
  `spm_type` varchar(8) NOT NULL,
  `spm_group` varchar(8) NOT NULL,
  `spm_price` decimal(11,2) NOT NULL,
  `spm_safety` int(11) NOT NULL,
  `spm_supp` varchar(8) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sp_mstr`
--

INSERT INTO `sp_mstr` (`ID`, `spm_code`, `spm_desc`, `spm_type`, `spm_group`, `spm_price`, `spm_safety`, `spm_supp`, `created_at`, `updated_at`) VALUES
(2, '2', '1234566678', '123456', '1', '2312.00', 321, 'S0002', '2021-03-07', '2021-03-07'),
(3, '3', 'qwertyuiop', 'SFSGS', '3', '1234.00', 12, 'S0012', '2021-03-07', '2021-03-07'),
(4, '4', 'zxcvbnm', 'DBDBB', '3', '23456.00', 123456, 'S0002', '2021-03-07', '2021-03-07'),
(5, '5', 'asdfghjk', 'DBDBB', '2', '234.00', 2345, 'S1001', '2021-03-07', '2021-03-07'),
(6, '6', 'ertyu', '123456', '2', '23456.00', 567, 'S0002', '2021-03-07', '2021-03-07'),
(7, '7', '123456', 'DDG', '2', '2345.00', 34, 'S0002', '2021-03-07', '2021-03-07'),
(8, '8', '12345', 'SGDBDB', '3', '345.00', 345, 'S0012', '2021-03-07', '2021-03-07');

-- --------------------------------------------------------

--
-- Table structure for table `sp_type`
--

CREATE TABLE `sp_type` (
  `ID` int(11) NOT NULL,
  `spt_code` varchar(8) NOT NULL,
  `spt_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sp_type`
--

INSERT INTO `sp_type` (`ID`, `spt_code`, `spt_desc`, `created_at`, `updated_at`) VALUES
(1, 'SFSGS', 'asdsad', '2021-03-07', '2021-03-07'),
(3, 'SGDBDB', 'sdgbfgdh', '2021-03-07', '2021-03-07'),
(4, 'VVDVBD', 'sgdfhfgh', '2021-03-07', '2021-03-07'),
(5, 'SVSVDB', 'fngfmghm', '2021-03-07', '2021-03-07'),
(7, 'DBDBB', 'sfdgfhghjk.l;', '2021-03-07', '2021-03-07'),
(8, '123456', 'part tidak terpakai', '2021-03-07', '2021-03-13'),
(9, 'typea', 'kendaraan', '2021-03-13', '2021-03-13'),
(10, 'typeb', 'mesin mobil', '2021-03-13', '2021-03-13'),
(11, '12345678', '123456789012345678901234567890', '2021-03-13', '2021-03-13');

-- --------------------------------------------------------

--
-- Table structure for table `supp_mstr`
--

CREATE TABLE `supp_mstr` (
  `ID` int(11) NOT NULL,
  `supp_code` varchar(8) NOT NULL,
  `supp_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supp_mstr`
--

INSERT INTO `supp_mstr` (`ID`, `supp_code`, `supp_desc`, `created_at`, `updated_at`) VALUES
(1, 'S0001', 'Supplier Nomor 100 Edit', '2021-03-01', '2021-03-12'),
(2, 'S0002', 'Supplier Nomor 200', '2021-03-01', '2021-03-01'),
(3, 'S1001', 'Lima Enam Lima', '2021-03-01', '2021-03-01'),
(4, 'S0012', 'Tukang Buah', '2021-03-01', '2021-03-01'),
(5, 'S1209', 'Tukang Es Krim Tujuh', '2021-03-01', '2021-03-01'),
(7, 'S12847', 'PT Mampus Jaya', '2021-03-01', '2021-03-01'),
(8, 'S1266', 'Pt Prima Prima', '2021-03-01', '2021-03-01');

-- --------------------------------------------------------

--
-- Table structure for table `tool_mstr`
--

CREATE TABLE `tool_mstr` (
  `ID` int(11) NOT NULL,
  `tool_code` varchar(8) NOT NULL,
  `tool_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tool_mstr`
--

INSERT INTO `tool_mstr` (`ID`, `tool_code`, `tool_desc`, `created_at`, `updated_at`) VALUES
(1, '1', '12345678asdfghj', '2021-03-07', '2021-03-07'),
(2, '2', '1234567890-', '2021-03-07', '2021-03-07'),
(3, '3', 'qwertyuio', '2021-03-07', '2021-03-07'),
(4, '4', 'asdfghjk', '2021-03-07', '2021-03-07'),
(8, 'ta-5', 'tool mobil', '2021-03-13', '2021-03-13'),
(9, 'ta-3', 'tool motor', '2021-03-13', '2021-03-13'),
(10, 'to-3', 'mesin mobil', '2021-03-13', '2021-03-13');

-- --------------------------------------------------------

--
-- Table structure for table `trolley_mstr`
--

CREATE TABLE `trolley_mstr` (
  `id` int(24) NOT NULL,
  `trolley_id` varchar(50) NOT NULL,
  `trolley_desc` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trolley_mstr`
--

INSERT INTO `trolley_mstr` (`id`, `trolley_id`, `trolley_desc`, `created_at`, `updated_at`) VALUES
(2, 'A1', 'Trolley 1', '2021-02-19 16:09:32', '2021-02-19 16:09:32'),
(3, 'A2', 'Trolley 2', '2021-02-19 16:09:45', '2021-02-19 16:09:45'),
(4, 'A3', 'Trolley 3', '2021-02-19 16:10:04', '2021-02-19 16:10:04');

-- --------------------------------------------------------

--
-- Table structure for table `truck_mstr`
--

CREATE TABLE `truck_mstr` (
  `id` int(24) NOT NULL,
  `truck_id` varchar(50) NOT NULL,
  `truck_desc` varchar(50) NOT NULL,
  `supir` varchar(50) NOT NULL,
  `platnomor` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `truck_mstr`
--

INSERT INTO `truck_mstr` (`id`, `truck_id`, `truck_desc`, `supir`, `platnomor`, `created_at`, `updated_at`) VALUES
(2, 'TK01', 'test', 'dev1', 'B 4555 BX', '2021-02-09 10:58:57', '2021-02-09 10:58:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(16) NOT NULL,
  `name` varchar(24) NOT NULL,
  `email_user` varchar(50) DEFAULT NULL,
  `role_user` varchar(24) DEFAULT NULL,
  `dept_user` varchar(8) NOT NULL,
  `active` varchar(8) NOT NULL,
  `access` varchar(8) DEFAULT NULL,
  `site` varchar(24) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `session_id` varchar(0) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL,
  `userdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email_user`, `role_user`, `dept_user`, `active`, `access`, `site`, `password`, `session_id`, `created_at`, `updated_at`, `edited_by`, `userdate`) VALUES
(1, 'admin', 'Admin IMI', 'tyas@ptimi.co.id', 'ADMIN', 'ENG', 'Yes', 'Engineer', 'R0012', '$2y$10$m1Xs5LivUwdkf5imeByKv.JuGyJRyiJ6uR0OXjqESclZRxmEKaZcC', '', '2020-08-13 03:39:30', '2022-08-30 09:40:34', 'rio', NULL),
(2, 'user01', 'User HR', 'user01@gmail', 'USER', 'BLF', 'Yes', 'User', NULL, '$2y$10$kvvr31oB77zg0dGKgKMV3e1b.UKjilsDzPf2ZygB9NjzE3Q2ddr62', NULL, '2022-05-13 11:33:51', '2022-07-19 11:00:02', 'admin', NULL),
(3, 'spv01', 'Supervisor 1', 'spv01@gmail.com', 'SPVSR', 'ENG', 'Yes', 'Engineer', NULL, '$2y$10$y6TqBbbOcKCLMJIWX4YlsuBymuAhCV6h5WdGlruGxS8ZIiCNrLTki', '', '2022-05-13 11:34:29', '2022-05-13 16:13:00', 'admin', NULL),
(4, 'eng01', 'Engineer 01', 'eng01@gmail.com', 'TECH', 'BLF', 'Yes', 'Engineer', NULL, '$2y$10$1rqp8imXgaPD5TG2xcDOy.a.WraksutnnxEz6xHfsnnpw7lcy.fV6', '', '2022-05-13 15:36:55', '2022-08-23 10:49:38', 'admin', NULL),
(7, 'user02', 'User IT', 'Frangky.Saputra@actavis', 'USER', 'IT', 'Yes', 'User', '', '$2y$10$d.sSp5oC.CczN/5KKuzRaOxCIzOwU4DoE5i3RDB6qj7l9cpaevWaa', '', NULL, NULL, 'admin01', NULL),
(8, 'user03', 'User MPF', 'Sukatmi.Sukatmi@actavis', 'USER', 'MPF', 'Yes', 'User', '', '$2y$10$aPY6YZmlA2/XyzhkUmlWd.cMyVwAOkN6CrXzA..7y8mmoRTf9Zuuy', '', NULL, NULL, 'admin01', NULL),
(12, 'eng02', 'Rahman', 'Sukarya.Sukarya@actavis', 'TECH', 'ENG', 'Yes', 'Engineer', '', '$2y$10$jdIovcH1JpHkFWAvUgPcc.r0vVwQbgLabo6VpGrCBlCjD5atI4BYS', '', NULL, '2022-08-15 11:12:03', 'admin', NULL),
(13, 'eng03', 'Ranto', 'Ijan.Ipriana@actavis', 'TECH', 'ENG', 'Yes', 'Engineer', '', '$2y$10$VVsu3RW6MKvckH1vQ0F5kOKCcsCfM0bYrmmnPTMm83t8DuvwPC/8u', '', NULL, '2022-07-21 15:43:39', 'admin', NULL),
(15, 'spv02', 'Supervisor', 'tyas@ptimi', 'SPVSR', 'IT', 'Yes', 'Engineer', NULL, '$2y$10$1QrhYTYXQVLY8TiWp1M4fuGGFLsf4rQJaa7MnthJAnanOIi2JxIwK', NULL, '2022-07-19 09:57:15', '2022-07-19 09:57:15', 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wotyp_mstr`
--

CREATE TABLE `wotyp_mstr` (
  `wotyp_code` char(10) NOT NULL,
  `wotyp_desc` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wotyp_mstr`
--

INSERT INTO `wotyp_mstr` (`wotyp_code`, `wotyp_desc`) VALUES
('BRE', 'Breakdown'),
('CLB', 'Calibration'),
('COR', 'Corrective Action'),
('IMP', 'Improvement'),
('PRE', 'Preventive Action');

-- --------------------------------------------------------

--
-- Table structure for table `wo_dets`
--

CREATE TABLE `wo_dets` (
  `wo_dets_id` int(11) NOT NULL,
  `wo_dets_nbr` varchar(50) NOT NULL,
  `wo_dets_rc` varchar(50) DEFAULT NULL,
  `wo_dets_sp` varchar(50) DEFAULT NULL,
  `wo_dets_sp_qty` int(11) DEFAULT NULL,
  `wo_dets_ins` varchar(255) DEFAULT NULL,
  `wo_dets_rep_hour` int(11) DEFAULT NULL,
  `wo_dets_standard` varchar(250) DEFAULT NULL,
  `wo_dets_flag` varchar(255) DEFAULT NULL,
  `wo_dets_fu` varchar(50) DEFAULT NULL,
  `wo_dets_fu_note` varchar(250) DEFAULT NULL,
  `wo_dets_type` varchar(50) DEFAULT NULL,
  `wo_dets_created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wo_dets`
--

INSERT INTO `wo_dets` (`wo_dets_id`, `wo_dets_nbr`, `wo_dets_rc`, `wo_dets_sp`, `wo_dets_sp_qty`, `wo_dets_ins`, `wo_dets_rep_hour`, `wo_dets_standard`, `wo_dets_flag`, `wo_dets_fu`, `wo_dets_fu_note`, `wo_dets_type`, `wo_dets_created_at`) VALUES
(1, 'WO-21-0005', 'Rtest', NULL, 1, 'Itest', 1, NULL, 'y0', 'n0', NULL, NULL, '2021-10-08 13:55:58'),
(2, 'WD-21-0004', 'Rtest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-15 10:42:54'),
(3, 'WD-21-0005', 'Rtest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-15 10:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `wo_mstr`
--

CREATE TABLE `wo_mstr` (
  `wo_id` int(11) NOT NULL,
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
  `wo_repair_hour` varchar(50) DEFAULT NULL,
  `wo_repair_code1` varchar(10) DEFAULT NULL,
  `wo_repair_code2` varchar(10) DEFAULT NULL,
  `wo_repair_code3` varchar(10) DEFAULT NULL,
  `wo_repair_group` varchar(50) DEFAULT NULL,
  `wo_repair_type` varchar(255) DEFAULT NULL,
  `wo_note` varchar(0) DEFAULT NULL,
  `wo_approval_note` varchar(0) DEFAULT NULL,
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
  `wo_access` int(11) DEFAULT 0,
  `wo_access_user` varchar(50) DEFAULT NULL,
  `wo_type` varchar(20) DEFAULT NULL,
  `wo_new_type` varchar(50) DEFAULT NULL,
  `wo_impact` varchar(255) DEFAULT NULL,
  `wo_impact_desc` varchar(255) DEFAULT NULL,
  `wo_action` varchar(500) DEFAULT NULL,
  `wo_sparepart` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wo_mstr`
--

INSERT INTO `wo_mstr` (`wo_id`, `wo_nbr`, `wo_sr_nbr`, `wo_dept`, `wo_priority`, `wo_engineer1`, `wo_engineer2`, `wo_engineer3`, `wo_engineer4`, `wo_engineer5`, `wo_asset`, `wo_failure_code1`, `wo_failure_code2`, `wo_failure_code3`, `wo_repair_hour`, `wo_repair_code1`, `wo_repair_code2`, `wo_repair_code3`, `wo_repair_group`, `wo_repair_type`, `wo_note`, `wo_approval_note`, `wo_status`, `wo_schedule`, `wo_duedate`, `wo_start_date`, `wo_start_time`, `wo_finish_date`, `wo_finish_time`, `wo_system_date`, `wo_system_time`, `wo_creator`, `wo_reviewer`, `wo_approver`, `wo_approver_appdate`, `wo_reviewer_appdate`, `wo_reject_reason`, `wo_created_at`, `wo_updated_at`, `wo_access`, `wo_access_user`, `wo_type`, `wo_new_type`, `wo_impact`, `wo_impact_desc`, `wo_action`, `wo_sparepart`) VALUES
(2, 'WO-21-0061', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, '01-AT-004', NULL, NULL, NULL, NULL, 'CTF-R001', 'CTF-R002', '', '', 'code', '', NULL, 'open', '2022-08-30', '2022-08-30', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-08-30 11:35:56', '2022-08-30 11:35:56', 0, NULL, 'other', 'CLB', 'QLTY;', 'Quality;', NULL, NULL);

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
(1, 'RG001', 'All Check', 1, 'CTF-R001', 'R'),
(2, 'RG001', 'All Check', 2, 'CTF-R002', 'e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area_mstr`
--
ALTER TABLE `area_mstr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_group`
--
ALTER TABLE `asset_group`
  ADD PRIMARY KEY (`ID`,`asgroup_code`);

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
  ADD PRIMARY KEY (`ID`,`astype_code`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `idx_cookcode` (`bank_code`);

--
-- Indexes for table `dept_mstr`
--
ALTER TABLE `dept_mstr`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `IX_dept_mstr` (`ID`);

--
-- Indexes for table `eng_mstr`
--
ALTER TABLE `eng_mstr`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UN_eng_mstr` (`ID`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fn_mstr`
--
ALTER TABLE `fn_mstr`
  ADD PRIMARY KEY (`ID`,`fn_code`);

--
-- Indexes for table `imp_mstr`
--
ALTER TABLE `imp_mstr`
  ADD PRIMARY KEY (`imp_code`);

--
-- Indexes for table `ins_mstr`
--
ALTER TABLE `ins_mstr`
  ADD PRIMARY KEY (`ins_id`);

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
-- Indexes for table `picklist_ctrl`
--
ALTER TABLE `picklist_ctrl`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`ID`,`rep_code`);

--
-- Indexes for table `rep_part`
--
ALTER TABLE `rep_part`
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
-- Indexes for table `skill_mstr`
--
ALTER TABLE `skill_mstr`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `IX_skill_mstr` (`ID`);

--
-- Indexes for table `so_dets`
--
ALTER TABLE `so_dets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_dets_tmp`
--
ALTER TABLE `so_dets_tmp`
  ADD PRIMARY KEY (`id_det_tmp`);

--
-- Indexes for table `so_mstrs`
--
ALTER TABLE `so_mstrs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_mstr_tmp`
--
ALTER TABLE `so_mstr_tmp`
  ADD PRIMARY KEY (`id_mstr_tmp`);

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
-- Indexes for table `trolley_mstr`
--
ALTER TABLE `trolley_mstr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `truck_mstr`
--
ALTER TABLE `truck_mstr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `wotyp_mstr`
--
ALTER TABLE `wotyp_mstr`
  ADD PRIMARY KEY (`wotyp_code`);

--
-- Indexes for table `wo_mstr`
--
ALTER TABLE `wo_mstr`
  ADD PRIMARY KEY (`wo_id`);

--
-- Indexes for table `xxrepgroup_mstr`
--
ALTER TABLE `xxrepgroup_mstr`
  ADD PRIMARY KEY (`xxrepgroup_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area_mstr`
--
ALTER TABLE `area_mstr`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `asset_group`
--
ALTER TABLE `asset_group`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `asset_par`
--
ALTER TABLE `asset_par`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `asset_type`
--
ALTER TABLE `asset_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `book_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dept_mstr`
--
ALTER TABLE `dept_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `eng_mstr`
--
ALTER TABLE `eng_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fn_mstr`
--
ALTER TABLE `fn_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ins_mstr`
--
ALTER TABLE `ins_mstr`
  MODIFY `ins_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inv_mstr`
--
ALTER TABLE `inv_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `loc_mstr`
--
ALTER TABLE `loc_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `picklist_ctrl`
--
ALTER TABLE `picklist_ctrl`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rep_det`
--
ALTER TABLE `rep_det`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `rep_ins`
--
ALTER TABLE `rep_ins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rep_master`
--
ALTER TABLE `rep_master`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rep_mstr`
--
ALTER TABLE `rep_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rep_part`
--
ALTER TABLE `rep_part`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_req_mstr`
--
ALTER TABLE `service_req_mstr`
  MODIFY `id_sr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skill_mstr`
--
ALTER TABLE `skill_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `so_dets`
--
ALTER TABLE `so_dets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `so_dets_tmp`
--
ALTER TABLE `so_dets_tmp`
  MODIFY `id_det_tmp` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `so_mstrs`
--
ALTER TABLE `so_mstrs`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `so_mstr_tmp`
--
ALTER TABLE `so_mstr_tmp`
  MODIFY `id_mstr_tmp` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `sp_group`
--
ALTER TABLE `sp_group`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sp_mstr`
--
ALTER TABLE `sp_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sp_type`
--
ALTER TABLE `sp_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `supp_mstr`
--
ALTER TABLE `supp_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tool_mstr`
--
ALTER TABLE `tool_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `trolley_mstr`
--
ALTER TABLE `trolley_mstr`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `truck_mstr`
--
ALTER TABLE `truck_mstr`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `wo_mstr`
--
ALTER TABLE `wo_mstr`
  MODIFY `wo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `xxrepgroup_mstr`
--
ALTER TABLE `xxrepgroup_mstr`
  MODIFY `xxrepgroup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
