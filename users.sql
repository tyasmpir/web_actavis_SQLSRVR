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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email_user`, `role_user`, `active`, `site`, `password`, `session_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Andrew Conan', 'abc@admin.com', 'ADM', 'yes', 'R0012', '$2y$10$bjR2ziZdk19qyyqwaSVmVO6RLe24UozXtZNzAKDa3liKS8EuWMv5S', 'I4QYourRGMX4Zw7xgP4dhvNLHEwWDobJnU76NBbY', '2020-08-12 20:39:30', '2021-03-19 07:34:49'),
(43, 'dev2', 'dev2', NULL, 'ADM', '', '', '$2y$10$xrabzdTmKAJRS6dyTlzKee5irxMwkHZOjb1o6yyXEpk8wQuSzehe.', NULL, '2021-02-05 06:37:51', '2021-02-05 06:37:51'),
(45, 'eng', 'engineer gudang', 'eng@email.compo', 'ADM', '', '', '$2y$10$i.T/HvxW8Vu2uB6HzdNbf.kcGdEOgIy0iV1e7S8tZnONYjquUnGae', 'rnbRojEkWK7cdqjtJwuJp3a9JEz26jigTlDdVqrq', '2021-02-23 07:34:01', '2021-02-23 07:34:12'),
(47, 'prc', 'purchasing', NULL, 'SPR', '', '', '$2y$10$nmYh9nNyu3YBFOHstdCDfu5zUXQraO9mnWCN5.iW12yzhBIL3ljBW', NULL, '2021-02-23 07:49:40', '2021-02-23 07:49:40'),
(48, 'adm', 'admin workshop 123', 'adm@email.compor', 'Beli', '', '', '$2y$10$V6qgdj7uA1UgYml/FmV50.bTVQl2m8yUCkZxlBB48DY5wp0BLV/fi', 'j2z9JHvPfkok1o3GEY4vRuWqrCgt0yE2YsdCzZwb', '2021-02-23 08:14:27', '2021-03-12 05:59:31'),
(49, 'qc', 'Quality', 'qc@email', 'SPR', '', '', '$2y$10$coCL.kvNuNoU3PDAHTGhFucDTCNmoD.vkCadne9gbXLRWCRBStw9W', NULL, '2021-02-23 08:50:13', '2021-02-23 08:50:13'),
(50, 'wks-1', 'Workshop Pabrik Edit', 'email edit', 'ADM', '', '', '$2y$10$U1N4fGm8lWnhb/WbFJlCoOl0bcchL5r7iQ.0.P60g6c1WqVs5hVu6', NULL, '2021-02-23 08:50:45', '2021-02-23 08:50:45'),
(51, 'wks-2', 'Worshop Gudang', 'wks2@email', 'SPR', '', '', '$2y$10$ybVZA.vx7HFpOT4Alt7C5O4Q.Gas8baQePe3F7yGQa2kr.8brUxWW', NULL, '2021-02-23 08:51:22', '2021-02-23 08:51:22'),
(52, 'test', 'satu', 'dua', 'babu', '', '', '$2y$10$v/5My5GZm70ETlYE66onA.1s4DU2apLgIDLrWvZnMpD0v.0.1Rn72', NULL, '2021-02-24 04:46:14', '2021-02-24 04:46:14'),
(53, 'ADM1', 'Admin Input', 'email', 'Jual', '', '', '$2y$10$KCnIBHcp/c0KVt7paNZCBOQq6dXIZVM0D./PRz5D4itXA8p8XshyW', NULL, '2021-03-12 05:48:54', '2021-03-12 05:48:54'),
(54, 'adm2', 'Admin Input Gudang', '1234', 'Jual', '', '', '$2y$10$JMleg99mykkr/EJ7AlmL2OlX7dmWVzP7WBVqicGsRI8jMlWTGdL46', NULL, '2021-03-12 05:51:14', '2021-03-12 05:51:14'),
(56, 'user', 'power user', 'as@eas', 'ADM', '', '', '$2y$10$U32BhWw2KOb1QwxQDEel/eCw9Sk9J9P2M97u3Egrtdn/mp382Y.YW', 'eYxolSpP4nlIFeb9HzuZ8oGX60Wwh8PH4PE9TMpW', '2021-03-19 03:25:36', '2021-03-19 04:43:59'),
(57, 'user inp', 'user untuk input data', 'qw@qw', 'ADM', '', '', '$2y$10$vBmovhEO.34ICAD1lOsSGedQDjEAGZ3lCqH1YnUGXNGASEVKoWXY2', NULL, '2021-03-19 03:29:11', '2021-03-19 03:29:11'),
(58, 'user mst', 'user input master', 'as@as', 'ADM', '', '', '$2y$10$Ns6TzX4upP0zswF2Dz0iBuMwgiQXsbh.6rrv4cnQAk7G2mXFvwR2e', 'Y2oRJyW1qwrtM8KIQEwS83H4DUtGswbRX0iY0B3I', '2021-03-19 03:33:23', '2021-03-19 03:33:47'),
(59, 'nouser', 'asas', 'asa@awda', NULL, 'No', '', '$2y$10$JmbSBE/oyFqcHEyAimHTburRdc1wjdQZgxAeQ1mEgDNK3ai6uPmly', NULL, '2021-03-19 04:58:49', '2021-03-19 04:58:49'),
(60, 'aktif', 'dajd', '12@dd', NULL, 'Yes', '', '$2y$10$2rVGKFosYDixafeexpXVM.PfPUtgwt0UaXZGLaGIFvL4/zyp.eBxq', NULL, '2021-03-19 05:00:00', '2021-03-19 05:00:00'),
(61, 'ak', 'asa', 'sda@adsad', NULL, 'Yes', '', '$2y$10$78NPgTFZH4Ptk4WyGxgg6.8UYJSiJIhJl51TiDCTkyaaB/P.wQqX2', NULL, '2021-03-19 05:01:30', '2021-03-19 05:01:30'),
(62, 'aa', 'aa', 'aa@ww', NULL, 'No', '', '$2y$10$LZtzj0RzY8jM2cqsivLtNOXmsl36yZXnYHOGQ0ND3qRqIovxJriHm', NULL, '2021-03-19 06:19:28', '2021-03-19 06:19:28'),
(63, 'as', 'as', 'as@as', 'ADM', 'Yes', '', '$2y$10$ApZjjdwQewpY9gfnOPK4IeTiR3WguKdRMNI9mwkpTrV2l28QsAxWa', 'lKjw4Nsh3ta0mqIC4ZqIhx780zhzUJtAoHl5oRxo', '2021-03-19 06:20:31', '2021-03-19 06:20:59'),
(64, 'qw', 'qw', 'qw@qw', 'ADM', 'No', '', '$2y$10$LIcfNgA9Q8Lpyrm6YFPMEu1HWqdNHZDoBf4hDmE2olQ0Sfn64IJW6', 'YJBBlbpJhPSnlhDuT28qEWrdJAAeUmA350pBRaBO', '2021-03-19 06:27:50', '2021-03-19 07:21:05');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
