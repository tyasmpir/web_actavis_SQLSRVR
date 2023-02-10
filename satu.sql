-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Mar 2021 pada 07.00
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
-- Struktur dari tabel `area_mstr`
--

CREATE TABLE `area_mstr` (
  `id` int(24) NOT NULL,
  `area_id` varchar(50) NOT NULL,
  `area_desc` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `area_mstr`
--

INSERT INTO `area_mstr` (`id`, `area_id`, `area_desc`, `created_at`, `updated_at`) VALUES
(6, 'SATU', 'lokasi satu', '2021-02-25 13:39:56', '2021-02-25 13:39:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_group`
--

CREATE TABLE `asset_group` (
  `ID` int(11) NOT NULL,
  `asgroup_code` varchar(8) NOT NULL,
  `asgroup_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `asset_group`
--

INSERT INTO `asset_group` (`ID`, `asgroup_code`, `asgroup_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'B', 'Building edit', '2021-03-01', '2021-03-01', ''),
(3, 'D', 'Machine', '2021-03-01', '2021-03-01', ''),
(5, 'A', 'Kitchen Edit', '2021-03-01', '2021-03-21', 'ketik'),
(6, 'K', 'Kitchen', '2021-03-01', '2021-03-01', ''),
(7, 'Z', 'Others mesin', '2021-03-01', '2021-03-01', ''),
(9, 'mesin', 'mesin pencabut uban', '2021-03-21', '2021-03-21', 'admin'),
(10, 'perkakas', 'perabotan', '2021-03-21', '2021-03-21', 'ketik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_mstr`
--

CREATE TABLE `asset_mstr` (
  `ID` int(11) NOT NULL,
  `asset_code` varchar(10) NOT NULL,
  `asset_desc` varchar(30) NOT NULL,
  `asset_site` varchar(10) NOT NULL,
  `asset_loc` varchar(10) NOT NULL,
  `asset_um` varchar(8) NOT NULL,
  `asset_sn` varchar(25) NOT NULL,
  `asset_prc_date` date NOT NULL,
  `asset_prc_price` decimal(13,2) NOT NULL,
  `asset_type` varchar(10) NOT NULL,
  `asset_group` varchar(10) NOT NULL,
  `asset_failure` int(11) NOT NULL,
  `asset_measure` varchar(1) NOT NULL,
  `asset_supp` text NOT NULL,
  `asset_meter` int(6) DEFAULT NULL,
  `asset_cal` text DEFAULT NULL,
  `asset_last_usage` date DEFAULT NULL,
  `asset_last_usage_mtc` date DEFAULT NULL,
  `asset_last_mtc` date DEFAULT NULL,
  `asset_note` varchar(50) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `asset_mstr`
--

INSERT INTO `asset_mstr` (`ID`, `asset_code`, `asset_desc`, `asset_site`, `asset_loc`, `asset_um`, `asset_sn`, `asset_prc_date`, `asset_prc_price`, `asset_type`, `asset_group`, `asset_failure`, `asset_measure`, `asset_supp`, `asset_meter`, `asset_cal`, `asset_last_usage`, `asset_last_usage_mtc`, `asset_last_mtc`, `asset_note`, `created_at`, `updated_at`, `edited_by`) VALUES
(2, 'WVVDFE', 'WAE', '10-300', 'RAK2', 'DFSADF', 'DFASFSF', '2021-03-06', '21312312.00', 'MAC3', 'B', 1, 'F', 'S1001', 123123, 'SDFSDF', NULL, NULL, NULL, 'SFDSF', 2021, 2021, ''),
(3, 'FS1231', 'satu dua satu', '10-201', 'RAK2', 'SDFS', 'DFSD', '2021-03-12', '12312.21', 'MAC3', 'B', 0, 'S', 'S0002', 12312, 'SDVDS', NULL, NULL, NULL, 'SDVSD', 2021, 2021, ''),
(4, 'A10', 'desc ini panjangnya 25', '10-202', 'DUA', '12345678', '1234567890123456789012345', '2021-03-05', '999999999.99', 'MAC1', 'K', 2147483647, '1', 'S0012', 12345, '1234567890', NULL, NULL, NULL, 'ini note', 2021, 2021, ''),
(5, 'A102', 'Meja Kerja', '10-200', 'RAK1', 'pcs', '123', '2021-03-13', '122323.00', 'MAC1', 'A', 1221, 'a', 'S1209', 21312, 'scskd', NULL, NULL, NULL, 'skdmdsks', 2021, 2021, ''),
(6, 'B1238', 'Moobil pemadam', '10-201', 'RAK2', 'Pack', 'adas', '2021-03-12', '123123.00', 'MAC2', 'D', 0, 's', 'S0001', 31231, 'asdas', NULL, NULL, NULL, 'sadasd', 2021, 2021, ''),
(7, 'K1289', 'Kompor Tanem', '10-200', 'RAK2', 'dsfsdn', 'bjnclka', '2021-03-04', '12312321.00', 'MAC2', 'K', 0, 's', 'S1001', 13123, 'sdds', NULL, NULL, NULL, 'sdvsd', 2021, 2021, ''),
(9, '1234567890', '123456789012345678901234567890', '10-201', '12345678', '12345678', '1234567890123456789012345', '2021-02-18', '11111111111.99', 'MAC3', 'B', 2147483647, '1', 'S0001', 2147483647, '1234567890', NULL, NULL, NULL, '1234567890123456789012345', 2021, 2021, ''),
(10, 'tivi', 'lihat status pengiriman', 'pabrik', 'lobi', 'pc', '123', '2021-03-12', '5000000.00', '12345678', 'Z', 203, 'x', 'aruna', 30, '12', NULL, NULL, NULL, 'untuk di gudang', 2021, 2021, 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_par`
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
-- Dumping data untuk tabel `asset_par`
--

INSERT INTO `asset_par` (`ID`, `aspar_par`, `aspar_child`, `created_at`, `updated_at`, `edited_by`) VALUES
(24, 'FS1231', 'A102', '2021-03-16', '2021-03-16', ''),
(28, 'WVVDFE', 'A10', '2021-03-16', '2021-03-16', ''),
(29, 'WVVDFE', 'A102', '2021-03-16', '2021-03-16', ''),
(30, 'WVVDFE', 'A102', '2021-03-16', '2021-03-16', ''),
(31, 'K1289', '1234567890', '2021-03-21', '2021-03-21', 'admin'),
(32, 'K1289', 'A10', '2021-03-21', '2021-03-21', 'admin'),
(33, 'K1289', 'A10', '2021-03-21', '2021-03-21', 'admin'),
(34, 'K1289', 'A10', '2021-03-21', '2021-03-21', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_type`
--

CREATE TABLE `asset_type` (
  `ID` int(11) NOT NULL,
  `astype_code` varchar(8) NOT NULL,
  `astype_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `asset_type`
--

INSERT INTO `asset_type` (`ID`, `astype_code`, `astype_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(2, 'MAC2', 'Mesin Ulir', '2021-02-26', '2021-02-26', ''),
(3, 'MAC3', 'Mesin Potong Besi', '2021-02-26', '2021-02-26', ''),
(4, 'MOT1', 'Damkar Merah Kuning', '2021-02-26', '2021-02-26', ''),
(5, 'MOT2', 'AMbulance i', '2021-02-26', '2021-02-26', ''),
(6, 'MOT3', 'Bus', '2021-02-26', '2021-02-26', ''),
(7, 'MOT4', 'Bis Tingkat', '2021-02-26', '2021-02-26', ''),
(8, 'MAC1', 'Mesin Potong Rumput', '2021-02-26', '2021-02-26', ''),
(11, '12345678', '123456789012345678901234567890', '2021-03-16', '2021-03-16', ''),
(12, 'mesin', 'mesin pencacah plastik', '2021-03-21', '2021-03-21', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `eng_mstr`
--

CREATE TABLE `eng_mstr` (
  `ID` int(11) NOT NULL,
  `eng_code` varchar(8) NOT NULL,
  `eng_desc` varchar(30) NOT NULL,
  `eng_birth_date` date NOT NULL,
  `eng_active` text NOT NULL,
  `eng_join_date` date NOT NULL,
  `eng_rate_hour` decimal(7,2) NOT NULL,
  `eng_skill` varchar(30) NOT NULL,
  `eng_email` varchar(30) NOT NULL,
  `eng_photo` varchar(30) NOT NULL,
  `eng_role` varchar(8) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `eng_mstr`
--

INSERT INTO `eng_mstr` (`ID`, `eng_code`, `eng_desc`, `eng_birth_date`, `eng_active`, `eng_join_date`, `eng_rate_hour`, `eng_skill`, `eng_email`, `eng_photo`, `eng_role`, `created_at`, `updated_at`, `edited_by`) VALUES
(2, 'A', 'Enginering Senior', '2021-03-19', 'Yes', '2021-03-25', '14.90', 'Memanah Gambar', 'ewafs@email', 'A', '', '2021-03-08', '2021-03-13', ''),
(3, 'B', '123456789012345678901234567890', '2021-03-09', 'No', '2021-03-09', '12345.67', '123456789012345678901234567890', 'asdfghjkl2@email', 'B', '', '2021-03-08', '2021-03-09', ''),
(5, 'AFFD', 'wer', '2021-03-12', 'Yes', '2021-03-10', '2134.00', '', 'asdf@er', 'xxpklist.p', '', '2021-03-08', '2021-03-08', ''),
(10, 'ENG1', 'Engineering Bagian Gudang', '2018-01-31', 'Yes', '2019-07-19', '2.30', '', 'eng1@email', '20210309_094907-679675_free-be', '', '2021-03-09', '2021-03-09', ''),
(12, 'ENG2', 'Engineering Bagian Pabrik', '2018-02-14', 'No', '2019-06-06', '34.23', 'Memanjant Pohon', 'eng2@email', '20210309_101502-679675_free-be', '', '2021-03-09', '2021-03-09', ''),
(13, 'ENG3', 'Engineer Gambar', '2021-03-19', 'Yes', '2021-03-19', '23.56', 'Menggambar Gedung', 'eng3@email', '20210309_104305-pWKxHB.jpg', '', '2021-03-09', '2021-03-09', ''),
(14, 'ENG4', 'Engineer Masin Potong', '2021-03-10', 'Yes', '2021-03-19', '23.56', 'Potong Rumput Rapi', 'eng4@email', 'ENG4-best-windows-10-screensav', '', '2021-03-09', '2021-03-09', ''),
(15, 'ENG5', 'Enginer Mesiin Bubut', '2021-03-11', 'Yes', '2018-02-14', '34.12', 'Mencabut Rumput', 'eng5@email', 'ENG5', '', '2021-03-09', '2021-03-09', ''),
(16, 'NO1', 'Engineer Ganteng', '2021-03-05', 'Yes', '2021-03-20', '23.12', 'Menyihir Hati', 'no1@email', 'NO1-1.jpg', '', '2021-03-09', '2021-03-09', ''),
(17, 'NO2', 'Engineer Tangguh', '2019-06-14', 'Yes', '2018-07-09', '34.12', 'Mematahkan Hati', 'no2@email', 'NO2-2.jpg', '', '2021-03-09', '2021-03-09', ''),
(18, 'NO3', 'Engineer Pendamping', '2020-08-20', 'Yes', '2018-06-02', '87.68', 'Hanya Bisa Mendampingi', 'no3@email', 'NO3', '', '2021-03-09', '2021-03-09', ''),
(19, 'eng50', 'engineer kipas', '2009-02-04', 'Yes', '2020-07-11', '1.10', 'memanjat', 'eng50@email', 'eng50', '', '2021-03-18', '2021-03-18', ''),
(20, 'qwq', 'qwq', '2021-03-26', 'Yes', '2021-03-11', '121.00', '121', '121@121', 'qwq', '', '2021-03-18', '2021-03-18', ''),
(21, 'asa', 'asa', '2021-04-01', 'Yes', '2021-03-02', '121.00', 'sas', 'asa@adsd', 'asa', '', '2021-03-18', '2021-03-18', ''),
(22, 'admin', 'super user', '2021-03-12', 'Yes', '2021-03-03', '121.00', '1212', '1313@12312', 'admin', '', '2021-03-18', '2021-03-18', ''),
(23, 'adm', 'admin aplikasi', '2021-03-13', 'Yes', '2021-02-10', '12.00', '231', '132@aeqweq', 'adm', '', '2021-03-19', '2021-03-19', ''),
(24, 'user', 'power user', '2016-01-01', 'Yes', '2021-03-05', '1.20', 'as', 'as@eas', 'user', '', '2021-03-19', '2021-03-19', ''),
(25, 'user inp', 'user untuk input data', '2009-06-11', 'Yes', '2021-03-10', '1.20', 'qw', 'qw@qw', 'user inp', '', '2021-03-19', '2021-03-19', ''),
(26, 'user mst', 'user input master', '2015-01-01', 'Yes', '2012-05-31', '1.20', 'as', 'as@as', 'user mst', '', '2021-03-19', '2021-03-19', ''),
(27, 'aqaz', 'qwq', '2016-01-19', 'Yes', '2021-03-10', '12.00', '121', '21@qw', 'aqaz', '', '2021-03-19', '2021-03-19', ''),
(28, '12', '12', '2021-03-17', 'No', '2021-03-05', '12.00', '12', '12212@12', '12', 'Order', '2021-03-19', '2021-03-19', ''),
(31, 'nouser', 'asas', '2021-03-10', 'No', '2021-03-17', '12.00', 'asa', 'asa@awda', 'nouser', NULL, '2021-03-19', '2021-03-19', ''),
(32, 'aktif', 'dajd', '2021-03-10', 'Yes', '2021-03-10', '121.00', '121', '12@dd', 'aktif', NULL, '2021-03-19', '2021-03-19', ''),
(33, 'ak', 'asa', '2021-03-10', 'Yes', '2021-03-02', '212.00', 'asa', 'sda@adsad', 'ak', NULL, '2021-03-19', '2021-03-19', ''),
(34, 'aa', 'aa', '2021-03-04', 'No', '2021-03-05', '22.00', 'aa', 'aa@ww', 'aa', NULL, '2021-03-19', '2021-03-19', ''),
(35, 'as', 'as', '2021-03-12', 'Yes', '2021-03-04', '1.00', 'as', 'as@as', 'as', 'ADM', '2021-03-19', '2021-03-19', ''),
(36, 'qw', 'qw', '2021-03-24', 'No', '2021-03-04', '1.00', 'qw', 'qw@qw', 'qw', 'ADM', '2021-03-19', '2021-03-19', ''),
(37, 'ketik', 'admin aplikasi', '2011-01-31', 'Yes', '2021-02-01', '7.00', 'ketik 2 jari', 'ketik@ketik', 'ketik', 'ADM', '2021-03-21', '2021-03-21', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `fn_mstr`
--

CREATE TABLE `fn_mstr` (
  `ID` int(11) NOT NULL,
  `fn_code` varchar(8) NOT NULL,
  `fn_num` int(3) NOT NULL,
  `fn_desc` varchar(30) NOT NULL,
  `fn_assetgroup` varchar(8) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `fn_mstr`
--

INSERT INTO `fn_mstr` (`ID`, `fn_code`, `fn_num`, `fn_desc`, `fn_assetgroup`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, '1', 123, '123456789012345678901234567890', '', '2021-03-07', '2021-03-12', ''),
(4, '4', 421, '21424', '', '2021-03-07', '2021-03-07', ''),
(5, '1221', 0, 'asdfghjkl', '', '2021-03-07', '2021-03-12', ''),
(7, '123124', 111, 'qwerty', '', '2021-03-07', '2021-03-07', ''),
(8, '5435', 345, '5345435', '', '2021-03-07', '2021-03-07', ''),
(9, 'FAIL1', 1, 'Salah Pasang', '', '2021-03-12', '2021-03-12', ''),
(10, 'FAIL2', 1, 'Salah Potong', '', '2021-03-12', '2021-03-12', ''),
(11, 'bocor', 201, 'kebocoran ringan', 'A', '2021-03-18', '2021-03-18', ''),
(12, 'patah', 205, 'patah permanen krek', 'K', '2021-03-21', '2021-03-21', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ins_mstr`
--

CREATE TABLE `ins_mstr` (
  `ID` int(11) NOT NULL,
  `ins_code` varchar(8) NOT NULL,
  `ins_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ins_mstr`
--

INSERT INTO `ins_mstr` (`ID`, `ins_code`, `ins_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, '1', 'cek kondisi', '2021-03-07', '2021-03-21', 'ketik'),
(2, '2', '2wedfd', '2021-03-07', '2021-03-07', ''),
(3, '3', 'wfgdfgh', '2021-03-07', '2021-03-07', ''),
(7, '112', '123456789012345678901234567890', '2021-03-07', '2021-03-13', ''),
(10, 'ins2', 'indentifikasi tindakan', '2021-03-13', '2021-03-13', ''),
(11, 'ins3', 'identifikasi kerusakan', '2021-03-13', '2021-03-13', ''),
(12, 'tambal', 'tambal tempel genteng', '2021-03-21', '2021-03-21', 'admin'),
(13, 'potong', 'gunting', '2021-03-21', '2021-03-21', 'ketik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inv_mstr`
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
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `inv_mstr`
--

INSERT INTO `inv_mstr` (`ID`, `inv_site`, `inv_loc`, `inv_sp`, `inv_qty`, `inv_lot`, `inv_supp`, `inv_date`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, '10-200', 'RAK2', '7', 1, '', 'S1209', '2021-03-21', '2021-03-08', '2021-03-08', ''),
(2, '10-302', 'RAK2', '7', 1, '12', 'S1001', '2021-03-08', '2021-03-08', '2021-03-08', ''),
(3, '12-100', 'SATU', '5', 1, '12', 'S1001', '2021-03-08', '2021-03-08', '2021-03-08', ''),
(4, '10-300', 'SATU', '7', 1, '12', 'S0002', '2021-03-08', '2021-03-08', '2021-03-08', ''),
(5, '21-100', 'RAK1', '4', 1, '12', 'S1001', '2021-03-08', '2021-03-08', '2021-03-08', ''),
(6, '12-100', 'SATU', '5', 1, '12', 'S1209', '2021-03-21', '2021-03-08', '2021-03-08', ''),
(7, '10-301', 'SATU', '6', 1, '123', 'S0012', '2021-03-20', '2021-03-08', '2021-03-08', ''),
(9, 'site1', 'kanan', '2', 1, '1', 'S0002', '2020-12-11', '2021-03-18', '2021-03-18', ''),
(10, 'pabrik', 'lobi', 'sekrup', 34, '1453', 'S1209', '2021-03-21', '2021-03-21', '2021-03-21', 'ketik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `loc_mstr`
--

CREATE TABLE `loc_mstr` (
  `ID` int(11) NOT NULL,
  `loc_site` varchar(8) NOT NULL,
  `loc_code` varchar(8) NOT NULL,
  `loc_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `loc_mstr`
--

INSERT INTO `loc_mstr` (`ID`, `loc_site`, `loc_code`, `loc_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(3, '12-100', 'SATU', 'Test Satu', '2021-02-25', '2021-02-25', ''),
(4, '30-100', 'SATU', 'Test Satu', '2021-02-25', '2021-02-25', ''),
(6, 'R0012', 'DUA', 'Test Dua', '2021-02-25', '2021-02-25', ''),
(7, '10-100', 'RAK1', 'Susunan Rak1 Edit', '2021-02-26', '2021-03-12', ''),
(8, '10-100', 'RAK2', 'Susunan Rak 2 Bongkar', '2021-02-26', '2021-03-15', ''),
(9, '10-202', 'DUA', 'Susunan Rak 1', '2021-03-01', '2021-03-01', ''),
(10, 'site2', 'LOC1', 'Taman Menteng Edit', '2021-03-12', '2021-03-12', ''),
(11, '10-303', '123456', '123456789012345678901234', '2021-03-12', '2021-03-12', ''),
(13, 'site1', 'kanan', 'bagian kanan yang di edit', '2021-03-15', '2021-03-15', ''),
(14, 'site1', 'kiri', '123456789012345678901234567890', '2021-03-15', '2021-03-15', ''),
(15, '10-201', '12345678', '123456789012345678901234567890', '2021-03-16', '2021-03-16', ''),
(16, '10-200', 'a', 'a', '2021-03-19', '2021-03-19', ''),
(18, '10-200', 'b', 'a', '2021-03-19', '2021-03-19', ''),
(19, 'pabrik', 'lobi', 'penyambut tamu penting', '2021-03-21', '2021-03-21', 'admin'),
(21, '10-201', 'a', 'c', '2021-03-21', '2021-03-21', 'ketik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2014_10_12_000000_create_users_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 1),
(6, '2019_08_19_000000_create_failed_jobs_table', 1),
(7, '2020_11_03_185712_create_notifications_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
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
-- Dumping data untuk tabel `notifications`
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
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `picklist_ctrl`
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
-- Struktur dari tabel `rep_ins`
--

CREATE TABLE `rep_ins` (
  `ID` int(11) NOT NULL,
  `repins_code` varchar(8) NOT NULL,
  `repins_step` int(2) NOT NULL,
  `repins_ins` varchar(8) NOT NULL,
  `repins_tool` varchar(8) NOT NULL,
  `repins_hour` decimal(3,1) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rep_ins`
--

INSERT INTO `rep_ins` (`ID`, `repins_code`, `repins_step`, `repins_ins`, `repins_tool`, `repins_hour`, `created_at`, `updated_at`, `edited_by`) VALUES
(3, '2', 1, '12312', '8', '15.0', '2021-03-08', '2021-03-10', ''),
(4, '3', 1, '12312', '3', '50.0', '2021-03-08', '2021-03-11', ''),
(5, '6', 1, '2', '3', '12.0', '2021-03-08', '2021-03-16', ''),
(7, '234', 1, '12', '4', '1.0', '2021-03-08', '2021-03-08', ''),
(9, '3', 12, '2', '3', '9.9', '2021-03-10', '2021-03-10', ''),
(10, '3', 34, '3', '3', '12.0', '2021-03-10', '2021-03-11', ''),
(11, '6', 12, '2', '3', '9.9', '2021-03-10', '2021-03-10', ''),
(12, '234', 12, '3', '4', '9.9', '2021-03-10', '2021-03-10', ''),
(14, '2', 1, '1', '1', '99.9', '2021-03-10', '2021-03-10', ''),
(15, '6', 12, '3', '3', '9.9', '2021-03-10', '2021-03-10', ''),
(16, '8', 12, '112', '4', '9.9', '2021-03-10', '2021-03-10', ''),
(17, '8', 12, '3', '2', '12.0', '2021-03-16', '2021-03-16', ''),
(18, 'tambal', 1, '1', 'gunting', '0.2', '2021-03-21', '2021-03-21', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rep_mstr`
--

CREATE TABLE `rep_mstr` (
  `ID` int(11) NOT NULL,
  `rep_code` varchar(8) NOT NULL,
  `rep_num` int(3) NOT NULL,
  `rep_desc` varchar(30) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rep_mstr`
--

INSERT INTO `rep_mstr` (`ID`, `rep_code`, `rep_num`, `rep_desc`, `created_at`, `updated_at`, `edited_by`) VALUES
(3, '3', 134, '12346789', '2021-03-07', '2021-03-07', ''),
(4, '4', 234, 'asfdgfhgjhki', '2021-03-07', '2021-03-07', ''),
(5, '6', 213, 'sdfgfgh', '2021-03-07', '2021-03-07', ''),
(6, '8', 123, 'asdfhgj', '2021-03-07', '2021-03-07', ''),
(8, '234', 132, 'asdgfghjkllk', '2021-03-07', '2021-03-07', ''),
(10, '12', 2, '12112', '2021-03-13', '2021-03-13', ''),
(11, 'repa', 1, '123456789012345678901234567890', '2021-03-13', '2021-03-13', ''),
(12, 'repa', 2, 'bongkar', '2021-03-13', '2021-03-13', ''),
(13, 'repa', 3, 'dilap', '2021-03-13', '2021-03-13', ''),
(15, 'repb', 2, 'dilap', '2021-03-13', '2021-03-13', ''),
(16, 'repb', 3, 'periksa', '2021-03-13', '2021-03-13', ''),
(17, '12345678', 123, '123456789012345678901234567890', '2021-03-16', '2021-03-16', ''),
(18, 'tambal', 201, 'tambal bocor atap', '2021-03-21', '2021-03-21', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rep_part`
--

CREATE TABLE `rep_part` (
  `ID` int(11) NOT NULL,
  `reppart_code` varchar(8) NOT NULL,
  `reppart_step` int(2) NOT NULL,
  `reppart_sp` varchar(8) NOT NULL,
  `reppart_qty` int(3) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rep_part`
--

INSERT INTO `rep_part` (`ID`, `reppart_code`, `reppart_step`, `reppart_sp`, `reppart_qty`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, '6', 12, '4', 123, '2021-03-07', '2021-03-07', ''),
(2, '6', 12, '4', 123, '2021-03-07', '2021-03-07', ''),
(3, '6', 12, '2', 123, '2021-03-07', '2021-03-07', ''),
(4, '3', 32, '2', 2, '2021-03-07', '2021-03-11', ''),
(5, '2', 12, '7', 123, '2021-03-07', '2021-03-11', ''),
(6, '2', 12, '7', 123, '2021-03-07', '2021-03-11', ''),
(7, '8', 21, '6', 123, '2021-03-07', '2021-03-07', ''),
(10, 'repa', 1, '2', 1, '2021-03-13', '2021-03-13', ''),
(11, '8123', 11, '3', 12345, '2021-03-16', '2021-03-16', ''),
(12, 'tambal20', 1, 'sekrup', 2, '2021-03-21', '2021-03-21', 'admin'),
(13, 'tambal20', 1, 'sekrup', 1, '2021-03-21', '2021-03-21', 'admin');

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
('asdf', 'asdas', '', '2021-03-21 13:59:26', '2021-03-21 14:13:04', 'ketik'),
('Beli', 'pembelian', 'SH01MD01', '2021-02-24 03:54:04', '2021-03-21 14:13:18', 'ketik'),
('create', 'trial create user', '', '2021-03-19 07:41:41', '2021-03-19 07:41:41', 'admin'),
('Jual', 'Penjualan', '', '2021-02-24 03:54:16', '2021-02-24 03:54:16', ''),
('Order', 'Permintaan Barang', 'SH01MD01', '2021-02-24 03:54:34', '2021-02-24 06:29:36', ''),
('Pabrik', 'Pabrik Person', '', '2021-02-24 04:33:56', '2021-02-24 04:33:56', ''),
('SPR', 'Supir Truk', '', '2021-02-08 10:26:20', '2021-02-08 10:26:20', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `site_mstrs`
--

CREATE TABLE `site_mstrs` (
  `site_code` varchar(8) NOT NULL,
  `site_desc` varchar(30) NOT NULL,
  `site_flag` varchar(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `edited_by` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `site_mstrs`
--

INSERT INTO `site_mstrs` (`site_code`, `site_desc`, `site_flag`, `created_at`, `updated_at`, `edited_by`) VALUES
('10-200', 'Automotive Mfg TKas', NULL, '2020-12-01 04:59:12', '2021-03-21 14:57:22', 'ketik'),
('10-201', 'Lean Manufacturing Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('10-202', 'Automotive Mfg Site 2', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('10-203', 'test edit baru', NULL, '2021-03-21 14:52:03', '2021-03-21 14:55:37', 'ketik'),
('10-300', 'Process Mfg Site Edit', NULL, '2020-12-01 04:59:12', '2021-03-01 11:05:22', ''),
('10-302', 'Distribution Site 2', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('10-303', 'Distribution Site 3', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('10-400', 'Food & Bev Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('10-500', 'Pharmaceutical Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('11-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('12-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('12345678', '123456789012345678901234567890', NULL, '2021-03-16 03:53:44', '2021-03-16 03:53:44', ''),
('20-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('21-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('22-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('30-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('31-100', 'Ultrasound Mfg Site', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('pabrik', 'pabrik utama 1', NULL, '2021-03-21 12:41:30', '2021-03-21 12:41:41', 'admin'),
('PHSMG', 'PHAPROS', NULL, '2020-12-01 04:59:12', '2020-12-01 04:59:12', ''),
('R0012', 'Pusat', 'N', NULL, '2020-11-02 06:20:31', ''),
('R0013', 'Cabang', 'N', NULL, NULL, ''),
('R0014', 'abebe', 'Y', NULL, NULL, ''),
('R0015', 'a', 'Y', NULL, NULL, ''),
('site1', 'bagian utara', NULL, '2021-03-12 06:03:47', '2021-03-12 06:03:47', ''),
('site2', 'bagian selatan', NULL, '2021-03-12 06:03:58', '2021-03-12 06:03:58', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `so_dets`
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
-- Dumping data untuk tabel `so_dets`
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
-- Struktur dari tabel `so_dets_tmp`
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
-- Dumping data untuk tabel `so_dets_tmp`
--

INSERT INTO `so_dets_tmp` (`id_det_tmp`, `sod_line_tmp`, `sonbr_det_tmp`, `item_code_tmp`, `item_desc_tmp`, `item_um_tmp`, `qty_order_tmp`, `qty_ship_tmp`, `qty_pick_tmp`, `loc_tmp`, `lot_tmp`, `session_user_det`, `created_at`, `updated_at`) VALUES
(228, '2', '10000006', '01011', 'Supplies Kit', 'EA', '100.00', NULL, NULL, '010', '', 'admin', '2021-02-18 16:06:28', NULL),
(229, '5', '10S10090', '01011', 'Supplies Kit', 'EA', '1.00', NULL, NULL, '010', '', 'admin', '2021-02-18 16:06:28', NULL),
(230, '1', '10S10126', '01011', 'Supplies Kit', 'EA', '99.00', NULL, NULL, '010', '', 'admin', '2021-02-18 16:06:28', NULL),
(231, '1', 'tes1', 'ab', '', 'EA', '29.00', NULL, NULL, '010', '', 'admin', '2021-02-18 16:06:28', NULL),
(232, '2', 'tes1', 'ab', '', 'EA', '10.00', NULL, NULL, '010', '', 'admin', '2021-02-18 16:06:28', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `so_mstrs`
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
-- Dumping data untuk tabel `so_mstrs`
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
-- Struktur dari tabel `so_mstr_tmp`
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
-- Dumping data untuk tabel `so_mstr_tmp`
--

INSERT INTO `so_mstr_tmp` (`id_mstr_tmp`, `sonbr_mstr_tmp`, `socust_tmp`, `soshipto_tmp`, `duedate_tmp`, `salespsn_tmp`, `flag`, `session_user`, `created_at`, `updated_at`) VALUES
(175, '10000006', '10C1000', '10C1000', '2020-12-07', '10SP01', 'Y', 'admin', '2021-02-18 16:06:28', NULL),
(176, '10S10090', '10C1003', '10C1003', '2020-11-30', '10SP01', 'Y', 'admin', '2021-02-18 16:06:28', NULL),
(177, '10S10126', '10C1000', '10-100', '2020-12-02', '', 'Y', 'admin', '2021-02-18 16:06:28', NULL),
(178, 'tes1', '10-100', '10-100', '2020-11-26', '', 'Y', 'admin', '2021-02-18 16:06:28', '2021-02-18 16:06:28');

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `trolley_mstr`
--

CREATE TABLE `trolley_mstr` (
  `id` int(24) NOT NULL,
  `trolley_id` varchar(50) NOT NULL,
  `trolley_desc` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `trolley_mstr`
--

INSERT INTO `trolley_mstr` (`id`, `trolley_id`, `trolley_desc`, `created_at`, `updated_at`) VALUES
(2, 'A1', 'Trolley 1', '2021-02-19 16:09:32', '2021-02-19 16:09:32'),
(3, 'A2', 'Trolley 2', '2021-02-19 16:09:45', '2021-02-19 16:09:45'),
(4, 'A3', 'Trolley 3', '2021-02-19 16:10:04', '2021-02-19 16:10:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `truck_mstr`
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
-- Dumping data untuk tabel `truck_mstr`
--

INSERT INTO `truck_mstr` (`id`, `truck_id`, `truck_desc`, `supir`, `platnomor`, `created_at`, `updated_at`) VALUES
(2, 'TK01', 'test', 'dev1', 'B 4555 BX', '2021-02-09 10:58:57', '2021-02-09 10:58:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(8) CHARACTER SET utf8mb4 NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_user` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_user` varchar(24) CHARACTER SET utf8mb4 DEFAULT NULL,
  `active` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site` varchar(24) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `edited_by` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email_user`, `role_user`, `active`, `site`, `password`, `session_id`, `created_at`, `updated_at`, `edited_by`) VALUES
(1, 'admin', 'Andrew Conan', 'abc@admin.com', 'ADM', 'yes', 'R0012', '$2y$10$bjR2ziZdk19qyyqwaSVmVO6RLe24UozXtZNzAKDa3liKS8EuWMv5S', 'u4FJAYxviYTYF0GtN0Uis9Zei4K4Wg3zipieKs0g', '2020-08-12 20:39:30', '2021-03-21 12:25:07', ''),
(43, 'dev2', 'dev2', NULL, 'ADM', '', '', '$2y$10$xrabzdTmKAJRS6dyTlzKee5irxMwkHZOjb1o6yyXEpk8wQuSzehe.', NULL, '2021-02-05 06:37:51', '2021-02-05 06:37:51', ''),
(45, 'eng', 'engineer gudang', 'eng@email.compo', 'ADM', '', '', '$2y$10$i.T/HvxW8Vu2uB6HzdNbf.kcGdEOgIy0iV1e7S8tZnONYjquUnGae', 'rnbRojEkWK7cdqjtJwuJp3a9JEz26jigTlDdVqrq', '2021-02-23 07:34:01', '2021-02-23 07:34:12', ''),
(47, 'prc', 'purchasing', NULL, 'SPR', '', '', '$2y$10$nmYh9nNyu3YBFOHstdCDfu5zUXQraO9mnWCN5.iW12yzhBIL3ljBW', NULL, '2021-02-23 07:49:40', '2021-02-23 07:49:40', ''),
(48, 'adm', 'admin workshop 123', 'adm@email.compor', 'Beli', '', '', '$2y$10$V6qgdj7uA1UgYml/FmV50.bTVQl2m8yUCkZxlBB48DY5wp0BLV/fi', 'j2z9JHvPfkok1o3GEY4vRuWqrCgt0yE2YsdCzZwb', '2021-02-23 08:14:27', '2021-03-12 05:59:31', ''),
(49, 'qc', 'Quality', 'qc@email', 'SPR', '', '', '$2y$10$coCL.kvNuNoU3PDAHTGhFucDTCNmoD.vkCadne9gbXLRWCRBStw9W', NULL, '2021-02-23 08:50:13', '2021-02-23 08:50:13', ''),
(50, 'wks-1', 'Workshop Pabrik Edit', 'email edit', 'ADM', '', '', '$2y$10$U1N4fGm8lWnhb/WbFJlCoOl0bcchL5r7iQ.0.P60g6c1WqVs5hVu6', NULL, '2021-02-23 08:50:45', '2021-02-23 08:50:45', ''),
(51, 'wks-2', 'Worshop Gudang', 'wks2@email', 'SPR', '', '', '$2y$10$ybVZA.vx7HFpOT4Alt7C5O4Q.Gas8baQePe3F7yGQa2kr.8brUxWW', NULL, '2021-02-23 08:51:22', '2021-02-23 08:51:22', ''),
(52, 'test', 'satu', 'dua', 'babu', '', '', '$2y$10$v/5My5GZm70ETlYE66onA.1s4DU2apLgIDLrWvZnMpD0v.0.1Rn72', NULL, '2021-02-24 04:46:14', '2021-02-24 04:46:14', ''),
(53, 'ADM1', 'Admin Input', 'email', 'Jual', '', '', '$2y$10$KCnIBHcp/c0KVt7paNZCBOQq6dXIZVM0D./PRz5D4itXA8p8XshyW', NULL, '2021-03-12 05:48:54', '2021-03-12 05:48:54', ''),
(54, 'adm2', 'Admin Input Gudang', '1234', 'Jual', '', '', '$2y$10$JMleg99mykkr/EJ7AlmL2OlX7dmWVzP7WBVqicGsRI8jMlWTGdL46', NULL, '2021-03-12 05:51:14', '2021-03-12 05:51:14', ''),
(56, 'user', 'power user', 'as@eas', 'ADM', '', '', '$2y$10$U32BhWw2KOb1QwxQDEel/eCw9Sk9J9P2M97u3Egrtdn/mp382Y.YW', 'eYxolSpP4nlIFeb9HzuZ8oGX60Wwh8PH4PE9TMpW', '2021-03-19 03:25:36', '2021-03-19 04:43:59', ''),
(57, 'user inp', 'user untuk input data', 'qw@qw', 'ADM', '', '', '$2y$10$vBmovhEO.34ICAD1lOsSGedQDjEAGZ3lCqH1YnUGXNGASEVKoWXY2', NULL, '2021-03-19 03:29:11', '2021-03-19 03:29:11', ''),
(58, 'user mst', 'user input master', 'as@as', 'ADM', '', '', '$2y$10$Ns6TzX4upP0zswF2Dz0iBuMwgiQXsbh.6rrv4cnQAk7G2mXFvwR2e', 'Y2oRJyW1qwrtM8KIQEwS83H4DUtGswbRX0iY0B3I', '2021-03-19 03:33:23', '2021-03-19 03:33:47', ''),
(59, 'nouser', 'asas', 'asa@awda', NULL, 'No', '', '$2y$10$JmbSBE/oyFqcHEyAimHTburRdc1wjdQZgxAeQ1mEgDNK3ai6uPmly', NULL, '2021-03-19 04:58:49', '2021-03-19 04:58:49', ''),
(60, 'aktif', 'dajd', '12@dd', NULL, 'Yes', '', '$2y$10$2rVGKFosYDixafeexpXVM.PfPUtgwt0UaXZGLaGIFvL4/zyp.eBxq', NULL, '2021-03-19 05:00:00', '2021-03-19 05:00:00', ''),
(61, 'ak', 'asa', 'sda@adsad', NULL, 'Yes', '', '$2y$10$78NPgTFZH4Ptk4WyGxgg6.8UYJSiJIhJl51TiDCTkyaaB/P.wQqX2', NULL, '2021-03-19 05:01:30', '2021-03-19 05:01:30', ''),
(62, 'aa', 'aa', 'aa@ww', NULL, 'No', '', '$2y$10$LZtzj0RzY8jM2cqsivLtNOXmsl36yZXnYHOGQ0ND3qRqIovxJriHm', NULL, '2021-03-19 06:19:28', '2021-03-19 06:19:28', ''),
(63, 'as', 'as', 'as@as', 'ADM', 'Yes', '', '$2y$10$ApZjjdwQewpY9gfnOPK4IeTiR3WguKdRMNI9mwkpTrV2l28QsAxWa', 'lKjw4Nsh3ta0mqIC4ZqIhx780zhzUJtAoHl5oRxo', '2021-03-19 06:20:31', '2021-03-19 06:20:59', ''),
(64, 'qw', 'qw', 'qw@qw', 'ADM', 'No', '', '$2y$10$LIcfNgA9Q8Lpyrm6YFPMEu1HWqdNHZDoBf4hDmE2olQ0Sfn64IJW6', 'YJBBlbpJhPSnlhDuT28qEWrdJAAeUmA350pBRaBO', '2021-03-19 06:27:50', '2021-03-19 07:21:05', ''),
(65, 'ketik', 'admin aplikasi', 'ketik@ketik', 'ADM', 'Yes', '', '$2y$10$Jpyk6QH6on2ETPhhmOA5nOPUjDydLG9DLaUTkTuwmEVMnnIvawQfy', '1CXIkqk6Duzaj0Qdnj9XS0y3iuo5L8Yx9s6GK4X6', '2021-03-21 13:50:22', '2021-03-21 13:51:21', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `area_mstr`
--
ALTER TABLE `area_mstr`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `asset_group`
--
ALTER TABLE `asset_group`
  ADD PRIMARY KEY (`ID`,`asgroup_code`);

--
-- Indeks untuk tabel `asset_mstr`
--
ALTER TABLE `asset_mstr`
  ADD PRIMARY KEY (`ID`,`asset_code`,`asset_desc`);

--
-- Indeks untuk tabel `asset_par`
--
ALTER TABLE `asset_par`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `asset_type`
--
ALTER TABLE `asset_type`
  ADD PRIMARY KEY (`ID`,`astype_code`);

--
-- Indeks untuk tabel `eng_mstr`
--
ALTER TABLE `eng_mstr`
  ADD PRIMARY KEY (`ID`,`eng_code`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `fn_mstr`
--
ALTER TABLE `fn_mstr`
  ADD PRIMARY KEY (`ID`,`fn_code`);

--
-- Indeks untuk tabel `ins_mstr`
--
ALTER TABLE `ins_mstr`
  ADD PRIMARY KEY (`ID`,`ins_code`);

--
-- Indeks untuk tabel `inv_mstr`
--
ALTER TABLE `inv_mstr`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `loc_mstr`
--
ALTER TABLE `loc_mstr`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `picklist_ctrl`
--
ALTER TABLE `picklist_ctrl`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rep_ins`
--
ALTER TABLE `rep_ins`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `rep_mstr`
--
ALTER TABLE `rep_mstr`
  ADD PRIMARY KEY (`ID`,`rep_code`);

--
-- Indeks untuk tabel `rep_part`
--
ALTER TABLE `rep_part`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_code`);

--
-- Indeks untuk tabel `site_mstrs`
--
ALTER TABLE `site_mstrs`
  ADD PRIMARY KEY (`site_code`);

--
-- Indeks untuk tabel `so_dets`
--
ALTER TABLE `so_dets`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `so_dets_tmp`
--
ALTER TABLE `so_dets_tmp`
  ADD PRIMARY KEY (`id_det_tmp`);

--
-- Indeks untuk tabel `so_mstrs`
--
ALTER TABLE `so_mstrs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `so_mstr_tmp`
--
ALTER TABLE `so_mstr_tmp`
  ADD PRIMARY KEY (`id_mstr_tmp`);

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
-- Indeks untuk tabel `trolley_mstr`
--
ALTER TABLE `trolley_mstr`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `truck_mstr`
--
ALTER TABLE `truck_mstr`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `username_2` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `area_mstr`
--
ALTER TABLE `area_mstr`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `asset_group`
--
ALTER TABLE `asset_group`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `asset_mstr`
--
ALTER TABLE `asset_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `asset_par`
--
ALTER TABLE `asset_par`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `asset_type`
--
ALTER TABLE `asset_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `eng_mstr`
--
ALTER TABLE `eng_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `fn_mstr`
--
ALTER TABLE `fn_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `ins_mstr`
--
ALTER TABLE `ins_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `inv_mstr`
--
ALTER TABLE `inv_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `loc_mstr`
--
ALTER TABLE `loc_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `picklist_ctrl`
--
ALTER TABLE `picklist_ctrl`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rep_ins`
--
ALTER TABLE `rep_ins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `rep_mstr`
--
ALTER TABLE `rep_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `rep_part`
--
ALTER TABLE `rep_part`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `so_dets`
--
ALTER TABLE `so_dets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `so_dets_tmp`
--
ALTER TABLE `so_dets_tmp`
  MODIFY `id_det_tmp` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT untuk tabel `so_mstrs`
--
ALTER TABLE `so_mstrs`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `so_mstr_tmp`
--
ALTER TABLE `so_mstr_tmp`
  MODIFY `id_mstr_tmp` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

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

--
-- AUTO_INCREMENT untuk tabel `trolley_mstr`
--
ALTER TABLE `trolley_mstr`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `truck_mstr`
--
ALTER TABLE `truck_mstr`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
