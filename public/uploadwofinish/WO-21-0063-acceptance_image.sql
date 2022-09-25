-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2022 at 02:29 PM
-- Server version: 10.3.36-MariaDB-cll-lve
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ptimicoi_web_mms`
--

-- --------------------------------------------------------

--
-- Table structure for table `acceptance_image`
--

CREATE TABLE `acceptance_image` (
  `accept_img_id` int(11) NOT NULL,
  `file_srnumber` varchar(30) DEFAULT NULL,
  `file_wonumber` varchar(30) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acceptance_image`
--

INSERT INTO `acceptance_image` (`accept_img_id`, `file_srnumber`, `file_wonumber`, `file_name`, `file_url`, `uploaded_at`) VALUES
(1, NULL, 'WD-22-0012', 'WD-22-0012-tender_slsacct.sql', 'C:\\xampp\\htdocs\\web_actavis\\public\\uploadwofinish/WD-22-0012-tender_slsacct.sql', '2022-02-11 15:40:07'),
(2, 'SR-22-0021', 'WO-22-0060', 'WO-22-0060-0001.jpg', 'C:\\xampp\\htdocs\\web_actavis\\public\\uploadwofinish/WO-22-0060-0001.jpg', '2022-02-11 15:43:13'),
(3, NULL, 'WD-22-0013', 'WD-22-0013-images (9).jfif', '/home/ptimicoi/public_html/MMS/public/uploadwofinish/WD-22-0013-images (9).jfif', '2022-07-19 14:57:17'),
(4, NULL, 'WO-22-0066', 'WO-22-0066-images (9).jfif', '/home/ptimicoi/public_html/MMS/public/uploadwofinish/WO-22-0066-images (9).jfif', '2022-07-19 15:30:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acceptance_image`
--
ALTER TABLE `acceptance_image`
  ADD PRIMARY KEY (`accept_img_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acceptance_image`
--
ALTER TABLE `acceptance_image`
  MODIFY `accept_img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
