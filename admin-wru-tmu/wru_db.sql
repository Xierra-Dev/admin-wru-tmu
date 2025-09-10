-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Agu 2025 pada 05.52
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wru_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `employee_id`, `password`, `email`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', '2025-08-28 08:25:16', '2025-08-28 08:25:16'),
(2, 'ren', '$2y$10$jU1pj44qOSSMUbguqghZxu7FUM0eQIX3Xo7YcO2WO3hD7ciabA.bm', '', '2025-08-28 01:34:33', '2025-08-28 01:34:33'),
(3, '123456', '$2y$10$DZiO0y24vXp08RFOLcFAb.Aj/UqO4x0sQCtGHjfaKwqqFrX3IY3Lu', 'ren@gmail.com', '2025-08-31 03:43:21', '2025-08-31 03:43:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `destination`
--

CREATE TABLE `destination` (
  `id` int(10) UNSIGNED NOT NULL,
  `destination_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `destination`
--

INSERT INTO `destination` (`id`, `destination_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Bandung HQ', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(2, 'Jakarta Office', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(3, 'Surabaya Branch', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(4, 'Yogyakarta Site', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(5, 'Bali Workshop', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(6, 'Semarang Hub', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(7, 'Medan Plant', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(8, 'Makassar Depot', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(9, 'Bogor Warehouse', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(10, 'Depok Labo', '2025-08-28 08:00:53', '2025-08-28 01:38:11', '2025-08-28 01:38:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_loc`
--

CREATE TABLE `m_loc` (
  `id` int(10) UNSIGNED NOT NULL,
  `people_id` int(10) UNSIGNED NOT NULL,
  `destination_id` int(10) UNSIGNED NOT NULL,
  `request_by` varchar(255) NOT NULL,
  `leave_date` datetime NOT NULL,
  `return_date` datetime NOT NULL,
  `letter` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Letter flag: 0 = No, 1 = Yes (Boolean field)',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_loc`
--

INSERT INTO `m_loc` (`id`, `people_id`, `destination_id`, `request_by`, `leave_date`, `return_date`, `letter`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 'Rina', '2025-09-01 08:00:00', '2025-09-03 18:00:00', 0, '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(2, 2, 3, 'Rina', '2025-09-05 07:30:00', '2025-09-07 20:00:00', 1, '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(3, 3, 1, 'Fajar', '2025-08-28 09:00:00', '2025-08-28 21:00:00', 0, '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(4, 4, 5, 'Fajar', '2025-09-10 06:00:00', '2025-09-14 20:00:00', 1, '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(5, 5, 4, 'Tasya', '2025-09-02 08:00:00', '2025-09-04 19:00:00', 0, '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(6, 6, 6, 'Yoga', '2025-09-06 07:00:00', '2025-09-06 22:00:00', 1, '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(7, 7, 7, 'Mira', '2025-09-12 05:30:00', '2025-09-15 21:30:00', 0, '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(8, 8, 8, 'Yoga', '2025-09-08 09:00:00', '2025-09-09 18:30:00', 1, '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(9, 9, 9, 'Mira', '2025-09-03 08:15:00', '2025-09-03 20:00:00', 0, '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(10, 10, 10, 'Rina', '2025-09-18 06:30:00', '2025-09-19 19:00:00', 1, '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(16, 1, 2, 'Rina', '2025-09-20 08:00:00', '2025-09-20 17:30:00', 0, '2025-08-28 01:40:30', '2025-08-30 23:46:39', '2025-08-30 23:46:39'),
(17, 2, 1, 'Rina', '2025-09-06 08:00:00', '2025-09-06 19:00:00', 1, '2025-08-28 01:40:30', '2025-08-28 01:40:30', NULL),
(18, 3, 4, 'Fajar', '2025-09-11 07:30:00', '2025-09-11 21:00:00', 0, '2025-08-28 01:40:30', '2025-08-28 01:40:30', NULL),
(19, 4, 3, 'Tasya', '2025-09-09 08:00:00', '2025-09-10 18:00:00', 1, '2025-08-28 01:40:30', '2025-08-28 01:40:30', NULL),
(20, 5, 5, 'Fajar', '2025-09-04 06:00:00', '2025-09-06 20:00:00', 0, '2025-08-28 01:40:30', '2025-08-28 01:40:30', NULL),
(21, 6, 6, 'Yoga', '2025-09-07 09:00:00', '2025-09-07 21:00:00', 1, '2025-08-28 01:40:30', '2025-08-28 01:40:30', NULL),
(22, 7, 7, 'Mira', '2025-09-13 06:45:00', '2025-09-14 19:15:00', 0, '2025-08-28 01:40:30', '2025-08-28 01:40:30', NULL),
(23, 8, 8, 'Yoga', '2025-09-08 10:00:00', '2025-09-09 18:00:00', 1, '2025-08-28 01:40:30', '2025-08-28 01:40:30', NULL),
(24, 9, 9, 'Mira', '2025-09-05 08:30:00', '2025-09-05 16:45:00', 0, '2025-08-28 01:40:30', '2025-08-28 01:40:30', NULL),
(25, 10, 10, 'Rina', '2025-09-21 07:00:00', '2025-09-21 20:30:00', 1, '2025-08-28 01:40:30', '2025-08-28 01:40:30', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `people`
--

CREATE TABLE `people` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `people`
--

INSERT INTO `people` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Andi Saputra', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(2, 'Budi Santoso', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(3, 'Citra Lestari', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(4, 'Dewi Anggraini', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(5, 'Eko Prasetyo', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(6, 'Farhan Akbar', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(7, 'Gita Widya', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(8, 'Hendra Kurnia', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(9, 'Intan Permata', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(10, 'Joko Susilo', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_destination`
--

CREATE TABLE `tmp_destination` (
  `id` int(10) UNSIGNED NOT NULL,
  `destination_name` varchar(255) NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tmp_destination`
--

-- Table starts empty as it's for temporary data

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_mloc`
--

CREATE TABLE `tmp_mloc` (
  `id` int(10) UNSIGNED NOT NULL,
  `people_id` int(10) UNSIGNED NOT NULL,
  `destination_id` int(10) UNSIGNED NOT NULL,
  `request_by` varchar(255) NOT NULL,
  `leave_date` datetime NOT NULL,
  `return_date` datetime NOT NULL,
  `letter` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Letter flag: 0 = No, 1 = Yes (Boolean field)',
  `admin_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_people`
--

CREATE TABLE `tmp_people` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tmp_people`
--

-- Table starts empty as it's for temporary data

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_vehicle`
--

CREATE TABLE `tmp_vehicle` (
  `id` int(10) UNSIGNED NOT NULL,
  `vehicle_name` varchar(255) NOT NULL,
  `number_plate` varchar(255) NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tmp_vehicle`
--

-- Table starts empty as it's for temporary data

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_vtrip`
--

CREATE TABLE `tmp_vtrip` (
  `id` int(10) UNSIGNED NOT NULL,
  `people_id` int(10) UNSIGNED NOT NULL,
  `vehicle_id` int(10) UNSIGNED NOT NULL,
  `destination_id` int(10) UNSIGNED NOT NULL,
  `leave_date` datetime NOT NULL,
  `return_date` datetime NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(10) UNSIGNED NOT NULL,
  `vehicle_name` varchar(255) NOT NULL,
  `number_plate` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `vehicle`
--

INSERT INTO `vehicle` (`id`, `vehicle_name`, `number_plate`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Toyota Avanza', 'D 1234 AB', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(2, 'Honda BR-V', 'B 5678 CD', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(3, 'Mitsubishi Xpander', 'L 9012 EF', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(4, 'Suzuki Ertiga', 'AB 3456 GH', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(5, 'Isuzu Elf', 'DK 7890 IJ', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(6, 'Toyota HiAce', 'H 1122 KL', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(7, 'Daihatsu Gran Max', 'F 3344 MN', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(8, 'Wuling Confero', 'E 5566 PQ', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(9, 'Hyundai Staria', 'T 7788 RS', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL),
(10, 'Kia Carnival', 'Z 9900 TU', '2025-08-28 08:00:53', '2025-08-28 08:00:53', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `v_trip`
--

CREATE TABLE `v_trip` (
  `id` int(10) UNSIGNED NOT NULL,
  `people_id` int(10) UNSIGNED NOT NULL,
  `vehicle_id` int(10) UNSIGNED NOT NULL,
  `destination_id` int(10) UNSIGNED NOT NULL,
  `leave_date` datetime NOT NULL,
  `return_date` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `v_trip`
--

INSERT INTO `v_trip` (`id`, `people_id`, `vehicle_id`, `destination_id`, `leave_date`, `return_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, '2025-09-15 06:00:00', '2025-09-16 20:00:00', '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(2, 2, 2, 2, '2025-08-30 09:00:00', '2025-08-30 21:00:00', '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(3, 3, 3, 5, '2025-09-12 07:00:00', '2025-09-15 19:00:00', '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(4, 4, 4, 3, '2025-09-08 08:30:00', '2025-09-09 18:30:00', '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(5, 5, 5, 4, '2025-09-03 05:30:00', '2025-09-05 22:00:00', '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(6, 6, 6, 6, '2025-09-06 06:30:00', '2025-09-06 23:30:00', '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(7, 7, 7, 7, '2025-09-12 10:00:00', '2025-09-14 18:00:00', '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(8, 8, 8, 8, '2025-09-08 07:45:00', '2025-09-09 20:15:00', '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(9, 9, 9, 9, '2025-09-04 09:15:00', '2025-09-04 22:45:00', '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL),
(10, 10, 10, 10, '2025-09-19 06:15:00', '2025-09-20 21:45:00', '2025-08-28 08:00:54', '2025-08-28 08:00:54', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`employee_id`),
  ADD KEY `idx_admin_username` (`employee_id`);

--
-- Indeks untuk tabel `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_destination_name` (`destination_name`),
  ADD KEY `idx_destination_deleted_at` (`deleted_at`);

--
-- Indeks untuk tabel `m_loc`
--
ALTER TABLE `m_loc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mloc_people_id` (`people_id`),
  ADD KEY `idx_mloc_destination_id` (`destination_id`),
  ADD KEY `idx_mloc_leave_date` (`leave_date`),
  ADD KEY `idx_mloc_return_date` (`return_date`);

--
-- Indeks untuk tabel `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_people_name` (`name`),
  ADD KEY `idx_people_deleted_at` (`deleted_at`);

--
-- Indeks untuk tabel `tmp_destination`
--
ALTER TABLE `tmp_destination`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tmp_destination_name` (`destination_name`),
  ADD KEY `idx_tmp_destination_admin_id` (`admin_id`);

--
-- Indeks untuk tabel `tmp_mloc`
--
ALTER TABLE `tmp_mloc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tmp_mloc_people_id` (`people_id`),
  ADD KEY `idx_tmp_mloc_destination_id` (`destination_id`),
  ADD KEY `idx_tmp_mloc_admin_id` (`admin_id`);

--
-- Indeks untuk tabel `tmp_people`
--
ALTER TABLE `tmp_people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tmp_people_name` (`name`),
  ADD KEY `idx_tmp_people_admin_id` (`admin_id`);

--
-- Indeks untuk tabel `tmp_vehicle`
--
ALTER TABLE `tmp_vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tmp_vehicle_name` (`vehicle_name`),
  ADD KEY `idx_tmp_vehicle_number_plate` (`number_plate`),
  ADD KEY `idx_tmp_vehicle_admin_id` (`admin_id`);

--
-- Indeks untuk tabel `tmp_vtrip`
--
ALTER TABLE `tmp_vtrip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tmp_vtrip_people_id` (`people_id`),
  ADD KEY `idx_tmp_vtrip_vehicle_id` (`vehicle_id`),
  ADD KEY `idx_tmp_vtrip_destination_id` (`destination_id`),
  ADD KEY `idx_tmp_vtrip_admin_id` (`admin_id`);

--
-- Indeks untuk tabel `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vehicle_name` (`vehicle_name`),
  ADD KEY `idx_vehicle_number_plate` (`number_plate`),
  ADD KEY `idx_vehicle_deleted_at` (`deleted_at`);

--
-- Indeks untuk tabel `v_trip`
--
ALTER TABLE `v_trip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vtrip_people_id` (`people_id`),
  ADD KEY `idx_vtrip_vehicle_id` (`vehicle_id`),
  ADD KEY `idx_vtrip_destination_id` (`destination_id`),
  ADD KEY `idx_vtrip_leave_date` (`leave_date`),
  ADD KEY `idx_vtrip_return_date` (`return_date`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `destination`
--
ALTER TABLE `destination`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `m_loc`
--
ALTER TABLE `m_loc`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `people`
--
ALTER TABLE `people`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tmp_destination`
--
ALTER TABLE `tmp_destination`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tmp_mloc`
--
ALTER TABLE `tmp_mloc`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tmp_people`
--
ALTER TABLE `tmp_people`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tmp_vehicle`
--
ALTER TABLE `tmp_vehicle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tmp_vtrip`
--
ALTER TABLE `tmp_vtrip`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `v_trip`
--
ALTER TABLE `v_trip`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `m_loc`
--
ALTER TABLE `m_loc`
  ADD CONSTRAINT `fk_mloc_destination` FOREIGN KEY (`destination_id`) REFERENCES `destination` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mloc_people` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tmp_mloc`
--
ALTER TABLE `tmp_mloc`
  ADD CONSTRAINT `fk_tmp_mloc_destination` FOREIGN KEY (`destination_id`) REFERENCES `destination` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tmp_mloc_people` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tmp_mloc_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tmp_people`
--
ALTER TABLE `tmp_people`
  ADD CONSTRAINT `fk_tmp_people_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tmp_destination`
--
ALTER TABLE `tmp_destination`
  ADD CONSTRAINT `fk_tmp_destination_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tmp_vehicle`
--
ALTER TABLE `tmp_vehicle`
  ADD CONSTRAINT `fk_tmp_vehicle_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tmp_vtrip`
--
ALTER TABLE `tmp_vtrip`
  ADD CONSTRAINT `fk_tmp_vtrip_destination` FOREIGN KEY (`destination_id`) REFERENCES `destination` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tmp_vtrip_people` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tmp_vtrip_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tmp_vtrip_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `v_trip`
--
ALTER TABLE `v_trip`
  ADD CONSTRAINT `fk_vtrip_destination` FOREIGN KEY (`destination_id`) REFERENCES `destination` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vtrip_people` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vtrip_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
