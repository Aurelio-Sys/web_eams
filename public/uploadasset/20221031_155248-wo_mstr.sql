-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2022 at 09:16 AM
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
  `wo_repair_hour` varchar(50) DEFAULT NULL,
  `wo_list_failurecode` varchar(250) DEFAULT NULL,
  `wo_repair_code1` varchar(10) DEFAULT NULL,
  `wo_repair_code2` varchar(10) DEFAULT NULL,
  `wo_repair_code3` varchar(10) DEFAULT NULL,
  `wo_repair_group` varchar(50) DEFAULT NULL,
  `wo_repair_type` varchar(255) DEFAULT NULL,
  `wo_note` varchar(100) DEFAULT NULL,
  `wo_approval_note` varchar(100) DEFAULT NULL,
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

INSERT INTO `wo_mstr` (`wo_id`, `wo_nbr`, `wo_sr_nbr`, `wo_dept`, `wo_priority`, `wo_engineer1`, `wo_engineer2`, `wo_engineer3`, `wo_engineer4`, `wo_engineer5`, `wo_asset`, `wo_repair_hour`, `wo_list_failurecode`, `wo_repair_code1`, `wo_repair_code2`, `wo_repair_code3`, `wo_repair_group`, `wo_repair_type`, `wo_note`, `wo_approval_note`, `wo_status`, `wo_schedule`, `wo_duedate`, `wo_start_date`, `wo_start_time`, `wo_finish_date`, `wo_finish_time`, `wo_system_date`, `wo_system_time`, `wo_creator`, `wo_reviewer`, `wo_approver`, `wo_approver_appdate`, `wo_reviewer_appdate`, `wo_reject_reason`, `wo_created_at`, `wo_updated_at`, `wo_access`, `wo_access_user`, `wo_type`, `wo_new_type`, `wo_impact`, `wo_impact_desc`, `wo_action`, `wo_sparepart`) VALUES
(2, 'WO-21-0061', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, '01-AT-004', NULL, NULL, 'CTF-R001', 'CTF-R002', '', '', 'code', '', NULL, 'Released', '2022-08-30', '2022-08-30', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-08-30 11:35:56', '2022-09-14 14:42:48', 0, NULL, 'other', 'CLB', 'QLTY;', 'Quality;', NULL, NULL),
(3, 'WO-21-0062', 'SR-21-0047', 'IT', 'medium', 'admin1', NULL, NULL, NULL, NULL, '17.02', NULL, NULL, NULL, NULL, NULL, 'RG001', 'group', '', NULL, 'delete', '2022-09-02', '2022-09-02', NULL, NULL, NULL, NULL, NULL, NULL, 'admin1', NULL, 'admin1', NULL, NULL, NULL, '2022-09-02 11:34:14', '2022-09-22 15:41:52', 0, NULL, 'other', 'CLB', 'QLTY', 'Quality', NULL, NULL),
(4, 'WO-21-0063', NULL, 'IT', 'high', 'admin', 'admin1', NULL, NULL, NULL, 'EQ-0208-05', NULL, NULL, NULL, NULL, NULL, NULL, 'code', 'edit note', 'Selesai', 'closed', '2022-09-22', '2022-09-22', '2022-09-23', '14:19:28', '2022-09-23', '18:00:00', '2022-09-23', '14:19:48', 'admin1', 'admin1', 'admin1', '2022-09-23', '2022-09-23', NULL, '2022-09-14 15:08:17', '2022-09-23 14:19:48', 0, 'admin1', 'other', 'CLB', 'EHS;', 'EHS;', NULL, NULL),
(5, 'WO-21-0064', NULL, 'IT', 'low', 'admin1', NULL, NULL, NULL, NULL, 'EQ-0208-05', NULL, NULL, 'CTF-R001', 'CTF-R003', '', '', 'code', '', NULL, 'started', '2022-09-14', '2022-09-14', '2022-09-21', '14:41:01', NULL, NULL, NULL, NULL, 'admin1', NULL, NULL, NULL, NULL, NULL, '2022-09-14 15:10:04', '2022-09-14 15:10:04', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(6, 'WO-21-0065', NULL, 'IT', 'low', 'admin1', NULL, NULL, NULL, NULL, 'EQ-0006-02', NULL, NULL, 'MSN-C001', '', '', '', 'code', '', NULL, 'Released', '2022-09-15', '2022-09-15', NULL, NULL, NULL, NULL, NULL, NULL, 'admin1', NULL, NULL, NULL, NULL, NULL, '2022-09-15 15:36:22', '2022-09-15 15:36:51', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(7, 'WO-21-0066', NULL, 'IT', 'low', 'admin1', NULL, NULL, NULL, NULL, 'EQ-0502-TM-001', NULL, NULL, 'MSN-C001', '', '', '', 'code', '', NULL, 'whsconfirm', '2022-09-15', '2022-09-15', NULL, NULL, NULL, NULL, NULL, NULL, 'admin1', NULL, NULL, NULL, NULL, NULL, '2022-09-15 16:47:13', '2022-09-15 16:47:42', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(8, 'WO-21-0067', NULL, 'IT', 'low', 'admin1', NULL, NULL, NULL, NULL, 'EQ-0459-06', NULL, NULL, 'MSN-C001', '', '', '', 'code', '', NULL, 'engconfirm', '2022-09-19', '2022-09-19', NULL, NULL, NULL, NULL, NULL, NULL, 'admin1', NULL, NULL, NULL, NULL, NULL, '2022-09-19 10:54:13', '2022-09-19 10:55:24', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(9, 'WO-21-0068', NULL, 'IT', 'low', 'admin1', NULL, NULL, NULL, NULL, '09.24', NULL, NULL, 'CTF-R002', 'CTF-R003', 'MSN-C001', '', 'code', '', NULL, 'Released', '2022-09-22', '2022-09-22', NULL, NULL, NULL, NULL, NULL, NULL, 'admin1', NULL, NULL, NULL, NULL, NULL, '2022-09-22 13:11:05', '2022-09-22 13:11:34', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(10, 'WO-21-0069', NULL, 'IT', 'low', 'admin1', 'eng01', NULL, NULL, NULL, '05-TH-026', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'perbaikan', NULL, 'Released', '2022-09-26', '2022-09-26', NULL, NULL, NULL, NULL, NULL, NULL, 'admin1', NULL, NULL, NULL, NULL, NULL, '2022-09-26 09:33:24', '2022-09-26 09:33:39', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(11, 'WO-21-0070', NULL, 'ENG', 'low', 'admin', 'admin1', NULL, NULL, NULL, 'UT-0234-PI-011', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'perbaikan', NULL, 'Released', '2022-09-26', '2022-09-26', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-26 16:12:48', '2022-09-26 16:25:24', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(12, 'WD-21-0010', NULL, 'ENG', 'low', 'admin', 'admin1', NULL, NULL, NULL, '01-CP-008', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'closed', '2022-09-26', '2022-09-26', '2022-09-26', '16:23:35', '2022-09-26', NULL, '2022-09-26', '16:23:35', 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-26 16:23:35', '2022-09-26 16:23:35', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', 'perbaikan', NULL),
(13, 'WO-21-0071', NULL, 'ENG', 'low', 'admin1', NULL, NULL, NULL, NULL, 'EQ-0193', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'perbaikan', NULL, 'open', '2022-09-26', '2022-09-26', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-26 16:34:38', '2022-09-26 16:34:38', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(14, 'WO-21-0072', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, 'UT-0100', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'dadsa', NULL, 'Released', '2022-09-27', '2022-09-27', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-27 12:09:01', '2022-09-28 11:06:53', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(15, 'WO-21-0073', NULL, 'ENG', 'low', 'imi01', NULL, NULL, NULL, NULL, '01-AT-015', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'asdada', NULL, 'Released', '2022-09-27', '2022-09-27', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-27 12:42:56', '2022-09-27 12:43:07', 0, NULL, 'other', 'COR', 'EHS;QLTY;', 'EHS;Quality;', NULL, NULL),
(16, 'WO-21-0074', NULL, 'ENG', 'low', 'admin1', NULL, NULL, NULL, NULL, 'UT-0065', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'perbaikan', NULL, 'Released', '2022-09-27', '2022-09-27', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-27 14:07:50', '2022-09-27 14:45:08', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(17, 'WO-21-0075', NULL, 'ENG', 'medium', 'admin', NULL, NULL, NULL, NULL, 'EQ-0417', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'asdsad', NULL, 'Released', '2022-09-28', '2022-09-28', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-28 12:04:19', '2022-09-28 16:07:50', 0, NULL, 'other', 'CLB', 'RLT;', 'Reliability;', NULL, NULL),
(18, 'WO-21-0076', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, 'UT-0116', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'sfsd', NULL, 'Released', '2022-09-28', '2022-09-28', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-28 16:09:17', '2022-09-28 16:09:49', 0, NULL, 'other', 'BRE', 'QLTY;', 'Quality;', NULL, NULL),
(19, 'WO-21-0077', NULL, 'ENG', 'medium', 'admin', NULL, NULL, NULL, NULL, 'EQ-0177', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'wqeq', NULL, 'Released', '2022-09-28', '2022-09-28', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-28 16:13:38', '2022-09-28 16:16:25', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(20, 'WO-21-0078', NULL, 'ENG', 'medium', 'admin1', NULL, NULL, NULL, NULL, 'EQ-0229-01', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'dsadasd', NULL, 'open', '2022-09-28', '2022-09-28', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-28 16:17:19', '2022-09-28 16:17:19', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(21, 'WO-21-0079', NULL, 'ENG', 'medium', 'admin', NULL, NULL, NULL, NULL, 'EQ-0004-PI-003', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'adada', NULL, 'Released', '2022-09-28', '2022-09-28', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-28 16:17:59', '2022-09-28 16:18:35', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(22, 'WO-21-0080', NULL, 'ENG', 'medium', 'admin', NULL, NULL, NULL, NULL, 'EQ-0177-PI-001', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'saSaa', NULL, 'Released', '2022-09-28', '2022-09-28', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-28 16:24:44', '2022-09-28 16:46:52', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(23, 'WO-21-0081', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, 'EQ-0502-RT-001', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'awdaw', NULL, 'Released', '2022-09-28', '2022-09-28', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-28 16:47:15', '2022-09-28 16:48:02', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(24, 'WO-21-0082', NULL, 'ENG', 'medium', 'admin', NULL, NULL, NULL, NULL, 'EQ-0099-RT-001', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'adaq', NULL, 'Released', '2022-09-28', '2022-09-28', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-28 16:49:18', '2022-09-28 16:50:11', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(25, 'WO-21-0083', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, 'EQ-0459-05', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'awawe', NULL, 'Released', '2022-09-28', '2022-09-28', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-28 16:51:41', '2022-09-28 16:51:48', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(26, 'WO-21-0084', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, '01-AT-004', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'adasdsa', NULL, 'Released', '2022-09-29', '2022-09-29', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-29 07:00:09', '2022-09-29 11:05:27', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(27, 'WO-21-0085', 'SR-21-0048', 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, 'EQ-0034-TI-002', NULL, NULL, 'MSN-C001', NULL, NULL, NULL, 'code', 'adsfsdf', NULL, 'open', '2022-09-29', '2022-09-29', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, 'admin', NULL, NULL, NULL, '2022-09-29 09:24:45', '2022-09-29 09:24:45', 0, NULL, 'other', 'BRE', 'EHS', 'EHS', NULL, NULL),
(28, 'WO-21-0086', 'SR-21-0049', 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, 'EQ-0389-TI-004', NULL, NULL, 'MSN-C001', NULL, NULL, NULL, 'code', 'sadasda', NULL, 'open', '2022-09-29', '2022-09-29', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, 'admin', NULL, NULL, NULL, '2022-09-29 09:52:49', '2022-09-29 09:52:49', 0, NULL, 'other', 'BRE', 'EHS', 'EHS', NULL, NULL),
(29, 'WO-21-0087', 'SR-21-0050', 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, '10-TH-048', NULL, NULL, 'MSN-C001', NULL, NULL, NULL, 'code', 'sfsfsdf', NULL, 'delete', '2022-09-29', '2022-09-29', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, 'admin', NULL, NULL, NULL, '2022-09-29 09:56:25', '2022-10-03 22:34:41', 0, NULL, 'other', 'BRE', 'EHS', 'EHS', NULL, NULL),
(30, 'WO-21-0088', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, 'EQ-0455-01', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'sfsd', NULL, 'Released', '2022-09-29', '2022-09-29', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-29 10:01:39', '2022-09-30 12:24:31', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(31, 'WO-21-0089', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, 'EQ-0498-TH-007', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'wqewq', NULL, 'open', '2022-09-29', '2022-09-29', '2022-09-29', '13:31:17', NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-29 11:16:27', '2022-09-29 14:49:44', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(32, 'WO-22-0090', 'SR-22-0001', 'ENG', 'low', 'admin', 'admin1', NULL, NULL, NULL, 'EQ-0066-03', NULL, NULL, 'MSN-C001', NULL, NULL, NULL, 'code', 'sfsdfdf', 'cscsdsf', 'closed', '2022-09-30', '2022-09-30', '2022-09-30', '10:03:57', '2022-09-30', NULL, '2022-09-30', '10:07:24', 'admin', 'admin', 'admin', NULL, '2022-09-30', NULL, '2022-09-30 09:21:42', '2022-09-30 10:07:24', 0, 'admin', 'other', 'BRE', 'EHS', 'EHS', NULL, NULL),
(33, 'WO-22-0091', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, 'EQ-0594-TI-012', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'asasd', NULL, 'delete', '2022-09-30', '2022-09-30', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-30 10:08:54', '2022-10-03 22:31:46', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(34, 'WO-22-0092', NULL, 'ENG', 'low', 'admin', 'admin1', NULL, NULL, NULL, 'EQ-0525-05', NULL, NULL, 'MSN-C001', '', '', '', 'code', 'sdadsa', NULL, 'started', '2022-09-30', '2022-09-30', '2022-09-30', '11:15:12', NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-30 11:13:56', '2022-09-30 11:14:13', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(35, 'WO-22-0093', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, 'EQ-0594-TI-012', NULL, NULL, '', '', '', 'RG001', 'group', 'asdasd', NULL, 'open', '2022-09-30', '2022-09-30', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-09-30 11:30:08', '2022-09-30 11:44:35', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(36, 'WO-22-0094', 'SR-22-0004', 'ENG', 'low', 'admin', 'azis', NULL, NULL, NULL, '17.07', NULL, NULL, 'CTF-R001', 'CTF-R002', NULL, NULL, 'code', NULL, 'selesai', 'completed', '2022-10-02', '2022-10-02', '2022-09-30', '15:29:05', '2022-10-04', NULL, '2022-10-04', '13:31:24', 'admin', 'admin', 'admin', NULL, '2022-10-04', NULL, '2022-09-30 15:21:00', '2022-10-04 13:31:24', 0, 'admin', 'other', 'PRE', 'QLTY', 'Quality', NULL, NULL),
(37, 'PM-22-4771', NULL, 'ENG', 'high', 'azis', 'sukarya', NULL, NULL, NULL, '17.01', NULL, NULL, '', '', '', '', 'code', NULL, NULL, 'plan', '2022-10-02', '2022-10-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-10-02 08:40:34', '2022-10-02 08:40:34', 0, NULL, 'auto', NULL, NULL, NULL, NULL, NULL),
(38, 'PM-22-4772', NULL, 'ENG', 'high', 'azis', 'sukarya', NULL, NULL, NULL, 'EQ-0208-05', NULL, NULL, 'other', '', '', '', 'code', NULL, NULL, 'plan', '2022-10-02', '2022-10-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-10-02 09:51:19', '2022-10-02 09:51:19', 0, NULL, 'auto', NULL, NULL, NULL, NULL, NULL),
(39, 'PM-22-4773', NULL, 'ENG', 'high', 'admin', 'sukarya', NULL, NULL, NULL, 'EQ-0205-1', NULL, NULL, 'MSN-C001', '', '', '', 'code', NULL, NULL, 'plan', '2022-10-02', '2022-10-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-10-02 10:04:44', '2022-10-02 10:04:44', 0, NULL, 'auto', NULL, NULL, NULL, NULL, NULL),
(40, 'WO-22-0095', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, 'UT-0008-PI-036', NULL, NULL, 'CTF-R003', '', '', '', 'code', 'sdasda', NULL, 'started', '2022-10-02', '2022-10-02', '2022-10-14', '13:00:24', NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-10-02 10:07:15', '2022-10-14 13:00:12', 0, NULL, 'other', 'BRE', 'EHS;', 'EHS;', NULL, NULL),
(41, 'PM-22-4774', NULL, 'ENG', 'high', 'azis', 'sukarya', NULL, NULL, NULL, '01-AT-002', NULL, NULL, '', '', '', '', 'code', NULL, NULL, 'open', '2022-10-03', '2022-10-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-10-03 21:53:06', '2022-10-03 21:53:06', 0, NULL, 'auto', NULL, NULL, NULL, NULL, NULL),
(42, 'WO-22-0096', NULL, 'ENG', 'medium', 'admin', NULL, NULL, NULL, NULL, 'UT-0359', NULL, NULL, 'R-OTH', '', '', '', 'code', 'AC Bocor', NULL, 'Released', '2022-10-04', '2022-10-07', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-10-03 23:23:15', '2022-10-14 13:00:05', 0, NULL, 'other', 'COR', 'QLTY;', 'Quality;', NULL, NULL),
(43, 'WO-22-0097', 'SR-22-0006', 'ENG', 'high', 'eng01', NULL, NULL, NULL, NULL, 'Extruder', NULL, NULL, 'R-Ganti', NULL, NULL, NULL, 'code', 'Penggantian vanbelt ayak', NULL, 'plan', '2022-10-05', '2022-10-05', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, 'admin', NULL, NULL, NULL, '2022-10-05 09:29:12', '2022-10-05 09:29:12', 0, NULL, 'other', 'BRE', 'QLTY', 'Quality', NULL, NULL),
(44, 'WD-22-0011', NULL, 'ENG', 'medium', 'admin', 'admin1', NULL, NULL, NULL, '01-AT-058', NULL, NULL, 'R-OTH', NULL, NULL, NULL, 'code', 'perbaikan', NULL, 'open', '2022-10-07', '2022-10-07', NULL, NULL, NULL, NULL, '2022-10-07', '09:28:12', 'admin', NULL, NULL, NULL, NULL, NULL, '2022-10-07 09:28:12', '2022-10-14 12:59:52', 0, NULL, 'other', 'COR', 'EHS;', 'EHS;', NULL, NULL),
(45, 'WO-22-0098', NULL, 'ENG', 'low', 'admin', NULL, NULL, NULL, NULL, '01-AT-014', NULL, NULL, 'RBP-Part', '', '', '', 'code', NULL, NULL, 'plan', '2022-10-18', '2022-10-18', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2022-10-18 15:16:08', '2022-10-18 15:16:08', 0, NULL, 'auto', 'CLB', 'QLTY;', 'Quality;', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wo_mstr`
--
ALTER TABLE `wo_mstr`
  ADD PRIMARY KEY (`wo_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wo_mstr`
--
ALTER TABLE `wo_mstr`
  MODIFY `wo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
