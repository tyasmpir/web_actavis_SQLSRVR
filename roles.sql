-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Mar 2021 pada 10.05
-- Versi server: 10.4.13-MariaDB
-- Versi PHP: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_actavis`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `role_code` varchar(24) NOT NULL,
  `role_desc` varchar(100) NOT NULL,
  `menu_access` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`role_code`, `role_desc`, `menu_access`, `created_at`, `updated_at`, `edited_by`) VALUES
('ADM', 'admin', 'MT01MT02MT03MT04MT05MT06MT07MT08MT09MT10MT11MT12MT13MT14MT15MT16MT17MT18MT19MT20P01P02P03P04P05SH01M', '2020-11-02 06:45:45', '2020-11-03 07:40:49', ''),
('Beli', 'Pembelian', 'SH01MD01', '2021-02-24 03:54:04', '2021-02-24 03:54:04', ''),
('create', 'trial create user', '', '2021-03-19 07:41:41', '2021-03-19 07:41:41', 'admin'),
('Jual', 'Penjualan', '', '2021-02-24 03:54:16', '2021-02-24 03:54:16', ''),
('Order', 'Permintaan Barang', 'SH01MD01', '2021-02-24 03:54:34', '2021-02-24 06:29:36', ''),
('Pabrik', 'Pabrik Person', '', '2021-02-24 04:33:56', '2021-02-24 04:33:56', ''),
('SPR', 'Supir Truk', '', '2021-02-08 10:26:20', '2021-02-08 10:26:20', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
