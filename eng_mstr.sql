-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Mar 2021 pada 10.06
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
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `eng_mstr`
--

INSERT INTO `eng_mstr` (`ID`, `eng_code`, `eng_desc`, `eng_birth_date`, `eng_active`, `eng_join_date`, `eng_rate_hour`, `eng_skill`, `eng_email`, `eng_photo`, `eng_role`, `created_at`, `updated_at`) VALUES
(2, 'A', 'Enginering Senior', '2021-03-19', 'Yes', '2021-03-25', '14.90', 'Memanah Gambar', 'ewafs@email', 'A', '', '2021-03-08', '2021-03-13'),
(3, 'B', '123456789012345678901234567890', '2021-03-09', 'No', '2021-03-09', '12345.67', '123456789012345678901234567890', 'asdfghjkl2@email', 'B', '', '2021-03-08', '2021-03-09'),
(5, 'AFFD', 'wer', '2021-03-12', 'Yes', '2021-03-10', '2134.00', '', 'asdf@er', 'xxpklist.p', '', '2021-03-08', '2021-03-08'),
(10, 'ENG1', 'Engineering Bagian Gudang', '2018-01-31', 'Yes', '2019-07-19', '2.30', '', 'eng1@email', '20210309_094907-679675_free-be', '', '2021-03-09', '2021-03-09'),
(12, 'ENG2', 'Engineering Bagian Pabrik', '2018-02-14', 'No', '2019-06-06', '34.23', 'Memanjant Pohon', 'eng2@email', '20210309_101502-679675_free-be', '', '2021-03-09', '2021-03-09'),
(13, 'ENG3', 'Engineer Gambar', '2021-03-19', 'Yes', '2021-03-19', '23.56', 'Menggambar Gedung', 'eng3@email', '20210309_104305-pWKxHB.jpg', '', '2021-03-09', '2021-03-09'),
(14, 'ENG4', 'Engineer Masin Potong', '2021-03-10', 'Yes', '2021-03-19', '23.56', 'Potong Rumput Rapi', 'eng4@email', 'ENG4-best-windows-10-screensav', '', '2021-03-09', '2021-03-09'),
(15, 'ENG5', 'Enginer Mesiin Bubut', '2021-03-11', 'Yes', '2018-02-14', '34.12', 'Mencabut Rumput', 'eng5@email', 'ENG5', '', '2021-03-09', '2021-03-09'),
(16, 'NO1', 'Engineer Ganteng', '2021-03-05', 'Yes', '2021-03-20', '23.12', 'Menyihir Hati', 'no1@email', 'NO1-1.jpg', '', '2021-03-09', '2021-03-09'),
(17, 'NO2', 'Engineer Tangguh', '2019-06-14', 'Yes', '2018-07-09', '34.12', 'Mematahkan Hati', 'no2@email', 'NO2-2.jpg', '', '2021-03-09', '2021-03-09'),
(18, 'NO3', 'Engineer Pendamping', '2020-08-20', 'Yes', '2018-06-02', '87.68', 'Hanya Bisa Mendampingi', 'no3@email', 'NO3', '', '2021-03-09', '2021-03-09'),
(19, 'eng50', 'engineer kipas', '2009-02-04', 'Yes', '2020-07-11', '1.10', 'memanjat', 'eng50@email', 'eng50', '', '2021-03-18', '2021-03-18'),
(20, 'qwq', 'qwq', '2021-03-26', 'Yes', '2021-03-11', '121.00', '121', '121@121', 'qwq', '', '2021-03-18', '2021-03-18'),
(21, 'asa', 'asa', '2021-04-01', 'Yes', '2021-03-02', '121.00', 'sas', 'asa@adsd', 'asa', '', '2021-03-18', '2021-03-18'),
(22, 'admin', 'super user', '2021-03-12', 'Yes', '2021-03-03', '121.00', '1212', '1313@12312', 'admin', '', '2021-03-18', '2021-03-18'),
(23, 'adm', 'admin aplikasi', '2021-03-13', 'Yes', '2021-02-10', '12.00', '231', '132@aeqweq', 'adm', '', '2021-03-19', '2021-03-19'),
(24, 'user', 'power user', '2016-01-01', 'Yes', '2021-03-05', '1.20', 'as', 'as@eas', 'user', '', '2021-03-19', '2021-03-19'),
(25, 'user inp', 'user untuk input data', '2009-06-11', 'Yes', '2021-03-10', '1.20', 'qw', 'qw@qw', 'user inp', '', '2021-03-19', '2021-03-19'),
(26, 'user mst', 'user input master', '2015-01-01', 'Yes', '2012-05-31', '1.20', 'as', 'as@as', 'user mst', '', '2021-03-19', '2021-03-19'),
(27, 'aqaz', 'qwq', '2016-01-19', 'Yes', '2021-03-10', '12.00', '121', '21@qw', 'aqaz', '', '2021-03-19', '2021-03-19'),
(28, '12', '12', '2021-03-17', 'No', '2021-03-05', '12.00', '12', '12212@12', '12', 'Order', '2021-03-19', '2021-03-19'),
(31, 'nouser', 'asas', '2021-03-10', 'No', '2021-03-17', '12.00', 'asa', 'asa@awda', 'nouser', NULL, '2021-03-19', '2021-03-19'),
(32, 'aktif', 'dajd', '2021-03-10', 'Yes', '2021-03-10', '121.00', '121', '12@dd', 'aktif', NULL, '2021-03-19', '2021-03-19'),
(33, 'ak', 'asa', '2021-03-10', 'Yes', '2021-03-02', '212.00', 'asa', 'sda@adsad', 'ak', NULL, '2021-03-19', '2021-03-19'),
(34, 'aa', 'aa', '2021-03-04', 'No', '2021-03-05', '22.00', 'aa', 'aa@ww', 'aa', NULL, '2021-03-19', '2021-03-19'),
(35, 'as', 'as', '2021-03-12', 'Yes', '2021-03-04', '1.00', 'as', 'as@as', 'as', 'ADM', '2021-03-19', '2021-03-19'),
(36, 'qw', 'qw', '2021-03-24', 'No', '2021-03-04', '1.00', 'qw', 'qw@qw', 'qw', 'ADM', '2021-03-19', '2021-03-19');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `eng_mstr`
--
ALTER TABLE `eng_mstr`
  ADD PRIMARY KEY (`ID`,`eng_code`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `eng_mstr`
--
ALTER TABLE `eng_mstr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
