-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Mar 2021 pada 07.03
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
-- Struktur dari tabel `sp_group`
--

CREATE TABLE `sp_group` (
  `ID` int(11) NOT NULL,
  `spg_code` varchar(8) NOT NULL,
  `spg_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sp_group`
--

INSERT INTO `sp_group` (`ID`, `spg_code`, `spg_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, '1', 'nomor satu', '2021-03-07', '2021-03-21', 'ketik'),
(2, '2', 'qwertyuiop', '2021-03-07', '2021-03-07', ''),
(3, '3', 'asdfghjkl', '2021-03-07', '2021-03-07', ''),
(4, '4', 'zxcvbnm', '2021-03-07', '2021-03-07', ''),
(8, '8', '123456789012345678901234567890', '2021-03-07', '2021-03-13', ''),
(9, 'gr1', 'untuk office', '2021-03-13', '2021-03-13', ''),
(10, 'gp2', 'untuk pabrik', '2021-03-13', '2021-03-13', ''),
(11, 'gp3', 'untuk gudang', '2021-03-13', '2021-03-13', ''),
(12, 'mesin', 'perbaikan mesin bubut', '2021-03-21', '2021-03-21', 'admin'),
(13, 'mobil', 'kendaraan', '2021-03-21', '2021-03-21', 'ketik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sp_mstr`
--

CREATE TABLE `sp_mstr` (
  `ID` int(11) NOT NULL,
  `spm_code` varchar(8) NOT NULL,
  `spm_desc` varchar(30) NOT NULL,
  `spm_type` varchar(8) NOT NULL,
  `spm_group` varchar(8) NOT NULL,
  `spm_price` decimal(13,2) NOT NULL,
  `spm_safety` int(11) NOT NULL,
  `spm_supp` varchar(8) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sp_mstr`
--

INSERT INTO `sp_mstr` (`ID`, `spm_code`, `spm_desc`, `spm_type`, `spm_group`, `spm_price`, `spm_safety`, `spm_supp`, `created_at`, `updated_at`, `edited_by`) VALUES
(2, '2', '1234566678', '123456', '1', '2312.00', 321, 'S0002', '2021-03-07', '2021-03-07', ''),
(3, '3', 'qwertyuiop', 'SFSGS', '3', '1234.00', 12, 'S0012', '2021-03-07', '2021-03-07', ''),
(4, '4', 'zxcvbnm', 'DBDBB', '3', '23456.00', 123456, 'S0002', '2021-03-07', '2021-03-07', ''),
(5, '5', 'asdfghjk', 'DBDBB', '2', '234.00', 2345, 'S1001', '2021-03-07', '2021-03-07', ''),
(6, '6', 'ertyu', '123456', '2', '23456.00', 567, 'S0002', '2021-03-07', '2021-03-07', ''),
(7, '7', '123456', 'DDG', '2', '2345.00', 34, 'S0002', '2021-03-07', '2021-03-07', ''),
(8, '8', '12345', 'SGDBDB', '3', '345.00', 345, 'S0012', '2021-03-07', '2021-03-07', ''),
(10, 'sekrup', 'sekrup ulir edit', '12345678', '1', '2000.00', 2, 'aruna', '2021-03-21', '2021-03-21', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sp_type`
--

CREATE TABLE `sp_type` (
  `ID` int(11) NOT NULL,
  `spt_code` varchar(8) NOT NULL,
  `spt_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sp_type`
--

INSERT INTO `sp_type` (`ID`, `spt_code`, `spt_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'SFSGS', 'asdsad', '2021-03-07', '2021-03-07', ''),
(3, 'SGDBDB', 'sdgbfgdh', '2021-03-07', '2021-03-07', ''),
(4, 'VVDVBD', 'sgdfhfgh', '2021-03-07', '2021-03-07', ''),
(5, 'SVSVDB', 'fngfmghm', '2021-03-07', '2021-03-07', ''),
(7, 'DBDBB', 'sfdgfhghjk.l;', '2021-03-07', '2021-03-07', ''),
(8, '123456', 'part tidak terpakai', '2021-03-07', '2021-03-21', 'ketik'),
(9, 'typea', 'kendaraan', '2021-03-13', '2021-03-13', ''),
(10, 'typeb', 'mesin mobil', '2021-03-13', '2021-03-13', ''),
(11, '12345678', '123456789012345678901234567890', '2021-03-13', '2021-03-13', ''),
(12, 'ganti', 'selalu ganti baru', '2021-03-21', '2021-03-21', 'ketik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supp_mstr`
--

CREATE TABLE `supp_mstr` (
  `ID` int(11) NOT NULL,
  `supp_code` varchar(8) NOT NULL,
  `supp_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supp_mstr`
--

INSERT INTO `supp_mstr` (`ID`, `supp_code`, `supp_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'S0001', 'Supplier Nomor 100 Edit', '2021-03-01', '2021-03-12', ''),
(2, 'S0002', 'Supplier Nomor 200', '2021-03-01', '2021-03-01', ''),
(3, 'S1001', 'Lima Enam Lima', '2021-03-01', '2021-03-01', ''),
(4, 'S0012', 'Tukang Buah', '2021-03-01', '2021-03-21', 'ketik'),
(5, 'S1209', 'Tukang Es Krim Tujuh', '2021-03-01', '2021-03-01', ''),
(7, 'S12847', 'PT Mampus Jaya', '2021-03-01', '2021-03-01', ''),
(8, 'S1266', 'Pt Prima Prima', '2021-03-01', '2021-03-01', ''),
(11, 'aruna', 'tukang buah edit', '2021-03-21', '2021-03-21', 'ketik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tool_mstr`
--

CREATE TABLE `tool_mstr` (
  `ID` int(11) NOT NULL,
  `tool_code` varchar(8) NOT NULL,
  `tool_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tool_mstr`
--

INSERT INTO `tool_mstr` (`ID`, `tool_code`, `tool_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, '1', 'qwertyuiop', '2021-03-07', '2021-03-21', 'ketik'),
(2, '2', '1234567890-', '2021-03-07', '2021-03-07', ''),
(3, '3', 'qwertyuio', '2021-03-07', '2021-03-07', ''),
(4, '4', 'asdfghjk', '2021-03-07', '2021-03-07', ''),
(8, 'ta-5', 'tool mobil', '2021-03-13', '2021-03-13', ''),
(9, 'ta-3', 'tool motor', '2021-03-13', '2021-03-13', ''),
(10, 'to-3', 'mesin mobil', '2021-03-13', '2021-03-13', ''),
(12, 'tang', 'tang potong', '2021-03-21', '2021-03-21', ''),
(13, 'gunting', 'gunting besar kabel', '2021-03-21', '2021-03-21', 'admin'),
(14, 'obeng', 'ulir', '2021-03-21', '2021-03-21', 'ketik');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `sp_group`
--
ALTER TABLE `sp_group`
  ADD PRIMARY KEY (`ID`,`spg_code`);

--
-- Indeks untuk tabel `sp_mstr`
--
ALTER TABLE `sp_mstr`
  ADD PRIMARY KEY (`ID`,`spm_code`);

--
-- Indeks untuk tabel `sp_type`
--
ALTER TABLE `sp_type`
  ADD PRIMARY KEY (`ID`,`spt_code`);

--
-- Indeks untuk tabel `supp_mstr`
--
ALTER TABLE `supp_mstr`
  ADD PRIMARY KEY (`ID`,`supp_code`);

--
-- Indeks untuk tabel `tool_mstr`
--
ALTER TABLE `tool_mstr`
  ADD PRIMARY KEY (`ID`,`tool_code`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `sp_group`
--
ALTER TABLE `sp_group`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `sp_mstr`
--
ALTER TABLE `sp_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `sp_type`
--
ALTER TABLE `sp_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `supp_mstr`
--
ALTER TABLE `supp_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tool_mstr`
--
ALTER TABLE `tool_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
