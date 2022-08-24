-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Jan 2022 pada 10.17
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_gms`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tender_slsacct`
--

CREATE TABLE `tender_slsacct` (
  `tender_slsacct_id` bigint(20) NOT NULL,
  `tender_slsacct_code` varchar(8) NOT NULL,
  `tender_slsacct_desc` varchar(50) NOT NULL,
  `tender_slsacct_active` tinyint(1) NOT NULL DEFAULT 0,
  `tender_slsacct_datecreate` date NOT NULL,
  `tender_slsacct_dateupdated` date NOT NULL,
  `tender_slsacct_updatedby` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tender_slsacct`
--

INSERT INTO `tender_slsacct` (`tender_slsacct_id`, `tender_slsacct_code`, `tender_slsacct_desc`, `tender_slsacct_active`, `tender_slsacct_datecreate`, `tender_slsacct_dateupdated`, `tender_slsacct_updatedby`) VALUES
(1, '659812', 'Administrasi Bank', 1, '2022-01-12', '2022-01-12', 'admin'),
(2, '659813', 'Administrasi Bank2', 1, '2022-01-12', '2022-01-12', 'admin'),
(5, '4204', 'Diskon Penjualan', 1, '2022-01-19', '2022-01-19', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tender_slsacct`
--
ALTER TABLE `tender_slsacct`
  ADD PRIMARY KEY (`tender_slsacct_id`),
  ADD UNIQUE KEY `unique_date` (`tender_slsacct_code`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tender_slsacct`
--
ALTER TABLE `tender_slsacct`
  MODIFY `tender_slsacct_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
