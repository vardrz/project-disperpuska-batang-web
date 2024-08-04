-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2024 at 02:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arsip`
--

-- --------------------------------------------------------

--
-- Table structure for table `archives`
--

CREATE TABLE `archives` (
  `id` int(11) NOT NULL,
  `on_date` date DEFAULT NULL,
  `archives_number` varchar(120) NOT NULL,
  `institute` varchar(200) NOT NULL,
  `isi` text DEFAULT NULL,
  `status` enum('internal','public') DEFAULT NULL,
  `keterangan` enum('Tersedia','Dipinjam') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archives`
--

INSERT INTO `archives` (`id`, `on_date`, `archives_number`, `institute`, `isi`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, '1965-06-14', 'PERATURAN 1965-2004.P.1', 'Sekretariat Wilayah/Daerah', 'Dati II Batang Dengan Mengubah UU No 13 Tahun 1950 Tentang Pembentukan Daerah-Daerah Kabupaten Dalam Lingkungan Propinsi Jateng', 'public', 'Dipinjam', '2024-06-20 07:22:57', '2024-06-25 03:58:20'),
(3, '1985-09-28', 'PERATURAN 1965-2004.P.2', 'Sekretariat Wilayah/Daerah', 'Peraturan Pemerintah Republik Indonesia Nomor 40 Tahun 1985 Tentang Tunjangan Pajak Penghasilan Bagi Pejabat Negara, dan lain lain', 'public', 'Tersedia', '2024-06-20 07:27:42', '2024-06-25 04:05:38'),
(4, '1999-04-06', 'PERATURAN 1965-2004.P.3', 'Sekretariat Wilayah/Daerah', 'Peraturan Komisi Pemilihan Umum Nomor 23 Tahun 1999 Tentang Tatacara Pencalonan Anggota DPR, DPRD Tingkat 1, dan DPRD Tingkat 2 Dalam Pemilihan Umum Tahun 1999', 'public', 'Dipinjam', '2024-06-20 07:29:02', '2024-07-26 00:03:28'),
(5, '1988-04-28', 'PERATURAN 1965-2004.P.4', 'SEKRETARIAT DAERAH', 'Peraturan Daerah Propinsi Daerah Tingkat I Jawa Tengah Nomor 8 Tahun 1988 Tentang Pembentukan Organisasi Dan Tata Kerja Dinas Pekerjaan Umum Pengairan Propinsi Daerah Tingkat I Jawa Tengah', 'public', 'Tersedia', '2024-06-20 07:31:22', '2024-06-25 04:08:12'),
(6, '1988-11-16', 'PERATURAN 1965-2004.P.5', 'SEKRETARIAT DAERAH', 'Peraturan Daerah Propinsi Daerah Tingkat I Jawa Tengah Nomor 28 Tahun 1988 Tentang Pokok-Pokok  Pola Tanam Di Propinsi Daerah Tingkat I Jawa Tengah', 'public', 'Tersedia', '2024-06-20 07:32:15', '2024-07-31 11:10:53');

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE `borrow` (
  `id` int(11) NOT NULL,
  `publics_id` int(11) NOT NULL,
  `archives_id` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `needs` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow`
--

INSERT INTO `borrow` (`id`, `publics_id`, `archives_id`, `notes`, `needs`, `created_at`, `updated_at`) VALUES
(2, 2, 2, 'siapp', 'Penelitian', '2024-06-29 08:45:02', '2024-06-29 08:45:02'),
(3, 2, 4, 'p', 'p', '2024-06-29 08:47:50', '2024-06-29 08:47:50'),
(5, 2, 4, 'o', 'o', '2024-06-29 09:11:10', '2024-06-29 09:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id` int(11) NOT NULL,
  `id_publics` int(11) NOT NULL,
  `id_archives` int(11) NOT NULL,
  `staffs_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id`, `id_publics`, `id_archives`, `staffs_id`, `created_at`, `update_at`) VALUES
(1, 2, 4, 3, '2024-06-29 08:48:09', '2024-07-26 07:03:00'),
(2, 1, 6, 3, '2024-06-29 08:36:37', '2024-07-31 18:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `publics`
--

CREATE TABLE `publics` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `area` varchar(45) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publics`
--

INSERT INTO `publics` (`id`, `name`, `email`, `area`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Muhammad Amar Ma\'ruf', 'amar.motmot02@gmail.com', 'Batang', '081391820840', '2024-06-29 01:21:02', '2024-06-29 01:21:02'),
(2, 'Amar', 'op@gmail.com', 'Batang', '087878373899', '2024-06-29 01:33:55', '2024-06-29 01:33:55');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `role` enum('admin','staff') NOT NULL,
  `nip` varchar(120) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `name`, `role`, `nip`, `updated_at`, `created_at`, `password`) VALUES
(3, 'Ahmad', 'admin', '12345678', '2024-06-24 20:25:57', '2024-06-24 20:25:57', '12345678');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archives`
--
ALTER TABLE `archives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_publics` (`publics_id`),
  ADD KEY `fk_archives` (`archives_id`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrow_id` (`id_publics`),
  ADD KEY `staff_id` (`staffs_id`),
  ADD KEY `id_archives` (`id_archives`);

--
-- Indexes for table `publics`
--
ALTER TABLE `publics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archives`
--
ALTER TABLE `archives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `borrow`
--
ALTER TABLE `borrow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `publics`
--
ALTER TABLE `publics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `fk_archives` FOREIGN KEY (`archives_id`) REFERENCES `archives` (`id`),
  ADD CONSTRAINT `fk_publics` FOREIGN KEY (`publics_id`) REFERENCES `publics` (`id`);

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_publics`) REFERENCES `publics` (`id`),
  ADD CONSTRAINT `pengembalian_ibfk_2` FOREIGN KEY (`staffs_id`) REFERENCES `staffs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengembalian_ibfk_3` FOREIGN KEY (`id_archives`) REFERENCES `archives` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
