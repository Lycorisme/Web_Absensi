-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 26, 2025 at 12:20 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int NOT NULL,
  `mahasiswa_id` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `mahasiswa_id`, `tanggal`, `waktu`, `created_at`) VALUES
(1, 1, '2025-01-09', '08:00:00', '2025-01-09 01:00:00'),
(2, 2, '2025-01-11', '09:15:00', '2025-01-11 02:15:00'),
(3, 3, '2025-01-13', '10:30:00', '2025-01-13 03:30:00'),
(4, 4, '2025-01-09', '08:30:00', '2025-01-08 18:30:00'),
(5, 5, '2025-01-09', '08:45:00', '2025-01-08 18:45:00'),
(6, 6, '2025-01-09', '09:00:00', '2025-01-08 19:00:00'),
(7, 7, '2025-01-10', '08:15:00', '2025-01-09 18:15:00'),
(8, 8, '2025-01-10', '08:30:00', '2025-01-09 18:30:00'),
(9, 9, '2025-01-10', '08:45:00', '2025-01-09 18:45:00'),
(10, 10, '2025-01-11', '08:00:00', '2025-01-10 18:00:00'),
(11, 11, '2025-01-11', '08:15:00', '2025-01-10 18:15:00'),
(12, 12, '2025-01-11', '08:30:00', '2025-01-10 18:30:00'),
(13, 13, '2025-01-12', '08:45:00', '2025-01-11 18:45:00'),
(14, 14, '2025-01-12', '09:00:00', '2025-01-11 19:00:00'),
(15, 15, '2025-01-12', '09:15:00', '2025-01-11 19:15:00'),
(16, 16, '2025-01-13', '08:00:00', '2025-01-12 18:00:00'),
(17, 17, '2025-01-13', '08:15:00', '2025-01-12 18:15:00'),
(18, 18, '2025-01-13', '08:30:00', '2025-01-12 18:30:00'),
(19, 19, '2025-01-14', '08:45:00', '2025-01-13 18:45:00'),
(20, 20, '2025-01-14', '09:00:00', '2025-01-13 19:00:00'),
(21, 21, '2025-01-14', '09:15:00', '2025-01-13 19:15:00'),
(22, 22, '2025-01-15', '08:00:00', '2025-01-14 18:00:00'),
(23, 23, '2025-01-15', '08:15:00', '2025-01-14 18:15:00'),
(24, 24, '2025-01-09', '08:30:00', '2025-01-08 18:30:00'),
(25, 25, '2025-01-09', '08:45:00', '2025-01-08 18:45:00'),
(26, 26, '2025-01-10', '09:00:00', '2025-01-09 19:00:00'),
(27, 27, '2025-01-10', '09:15:00', '2025-01-09 19:15:00'),
(28, 28, '2025-01-11', '08:00:00', '2025-01-10 18:00:00'),
(29, 29, '2025-01-11', '08:15:00', '2025-01-10 18:15:00'),
(30, 30, '2025-01-12', '08:30:00', '2025-01-11 18:30:00'),
(31, 31, '2025-01-12', '08:45:00', '2025-01-11 18:45:00'),
(32, 32, '2025-01-13', '09:00:00', '2025-01-12 19:00:00'),
(33, 33, '2025-01-13', '09:15:00', '2025-01-12 19:15:00'),
(34, 34, '2025-01-14', '08:00:00', '2025-01-13 18:00:00'),
(35, 35, '2025-01-14', '08:15:00', '2025-01-13 18:15:00'),
(36, 36, '2025-01-15', '08:30:00', '2025-01-14 18:30:00'),
(37, 37, '2025-01-15', '08:45:00', '2025-01-14 18:45:00'),
(38, 38, '2025-01-09', '09:00:00', '2025-01-08 19:00:00'),
(39, 39, '2025-01-09', '09:15:00', '2025-01-08 19:15:00'),
(40, 40, '2025-01-10', '08:00:00', '2025-01-09 18:00:00'),
(41, 41, '2025-01-10', '08:15:00', '2025-01-09 18:15:00'),
(42, 42, '2025-01-11', '08:30:00', '2025-01-10 18:30:00'),
(43, 43, '2025-01-11', '08:45:00', '2025-01-10 18:45:00'),
(44, 44, '2025-01-12', '09:00:00', '2025-01-11 19:00:00'),
(45, 45, '2025-01-12', '09:15:00', '2025-01-11 19:15:00'),
(46, 46, '2025-01-13', '08:00:00', '2025-01-12 18:00:00'),
(47, 47, '2025-01-13', '08:15:00', '2025-01-12 18:15:00'),
(48, 48, '2025-01-14', '08:30:00', '2025-01-13 18:30:00'),
(49, 49, '2025-01-14', '08:45:00', '2025-01-13 18:45:00'),
(50, 50, '2025-01-15', '09:00:00', '2025-01-14 19:00:00'),
(51, 51, '2025-01-15', '09:15:00', '2025-01-14 19:15:00'),
(52, 52, '2025-01-09', '08:00:00', '2025-01-08 18:00:00'),
(53, 53, '2025-01-09', '08:15:00', '2025-01-08 18:15:00'),
(57, 1, '2025-01-14', '00:24:14', '2025-01-13 17:24:14'),
(58, 1, '2025-01-14', '08:05:18', '2025-01-14 01:05:18');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `password`, `created_at`) VALUES
(1, 'Lycoris', '123', '2025-01-13 06:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int NOT NULL,
  `npm` varchar(12) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `npm`, `nama`, `jurusan`, `created_at`) VALUES
(1, '2210010286', 'Andi Wijaya', 'Teknik Informatika', '2025-01-09 03:00:00'),
(2, '2210010287', 'Budi Santoso', 'Sistem Informasi', '2025-01-11 04:30:00'),
(3, '2210010288', 'Citra Dewi', 'Teknik Komputer', '2025-01-13 07:45:00'),
(4, '2110010104', 'Anita Wijaya', 'Ilmu Administrasi Publik', '2025-01-12 21:48:41'),
(5, '2110010105', 'Budi Santoso', 'Sistem Informasi', '2025-01-12 21:48:41'),
(6, '2110010106', 'Clara Dewi', 'Teknik Elektro', '2025-01-12 21:48:41'),
(7, '2110010107', 'Denny Pratama', 'Teknik Industri', '2025-01-12 21:48:41'),
(8, '2110010108', 'Eka Putri', 'Teknik Mesin', '2025-01-12 21:48:41'),
(9, '2110010109', 'Fajar Rahman', 'Teknik Sipil', '2025-01-12 21:48:41'),
(10, '2110010110', 'Gita Nirmala', 'Ilmu Administrasi Publik', '2025-01-12 21:48:41'),
(11, '2110010111', 'Hendra Kusuma', 'Ilmu Komunikasi', '2025-01-12 21:48:41'),
(12, '2110010112', 'Indah Pertiwi', 'Bimbingan dan Konseling', '2025-01-12 21:48:41'),
(13, '2110010113', 'Joko Widodo', 'Pendidikan Bahasa Inggris', '2025-01-12 21:48:41'),
(14, '2110010114', 'Kartika Sari', 'Pendidikan Olahraga', '2025-01-12 21:48:41'),
(15, '2110010115', 'Lukman Hakim', 'Pendidikan Kimia', '2025-01-12 21:48:41'),
(16, '2110010116', 'Maya Angelina', 'Manajemen', '2025-01-12 21:48:41'),
(17, '2110010117', 'Nanda Pratama', 'Agribisnis', '2025-01-12 21:48:41'),
(18, '2110010118', 'Oscar Permana', 'Peternakan', '2025-01-12 21:48:41'),
(19, '2110010119', 'Putri Handayani', 'Hukum Ekonomi Syariah (Muamalah)', '2025-01-12 21:48:41'),
(20, '2110010120', 'Qori Handayani', 'Pendidikan Guru Madrasah Ibtidaiyah', '2025-01-12 21:48:41'),
(21, '2110010121', 'Rahmat Hidayat', 'Ekonomi Syariah', '2025-01-12 21:48:41'),
(22, '2110010122', 'Sarah Amelia', 'Kesehatan Masyarakat', '2025-01-12 21:48:41'),
(23, '2110010123', 'Tono Sudrajat', 'Ilmu Hukum', '2025-01-12 21:48:41'),
(24, '2110010124', 'Udin Sedunia', 'Farmasi', '2025-01-12 21:48:41'),
(25, '2110010125', 'Vera Wang', 'Magister Ilmu Administrasi Publik', '2025-01-12 21:48:41'),
(26, '2110010126', 'Wati Susilawati', 'Magister Ilmu Komunikasi', '2025-01-12 21:48:41'),
(27, '2110010127', 'Xavier Wong', 'Magister Manajemen', '2025-01-12 21:48:41'),
(28, '2110010128', 'Yani Maryani', 'Magister Manajemen Pendidikan Tinggi', '2025-01-12 21:48:41'),
(29, '2110010129', 'Zainab Putri', 'Magister Peternakan', '2025-01-12 21:48:41'),
(30, '2110010130', 'Adi Nugroho', 'Teknik Informatika', '2025-01-12 21:48:41'),
(31, '2110010131', 'Bella Safitri', 'Sistem Informasi', '2025-01-12 21:48:41'),
(32, '2110010132', 'Candra Wijaya', 'Teknik Elektro', '2025-01-12 21:48:41'),
(33, '2110010133', 'Dian Sastro', 'Teknik Industri', '2025-01-12 21:48:41'),
(34, '2110010134', 'Eko Prasetyo', 'Teknik Mesin', '2025-01-12 21:48:41'),
(35, '2110010135', 'Fina Kartika', 'Teknik Sipil', '2025-01-12 21:48:41'),
(36, '2110010136', 'Gunawan Putra', 'Ilmu Administrasi Publik', '2025-01-12 21:48:41'),
(37, '2110010137', 'Hesti Putri', 'Ilmu Komunikasi', '2025-01-12 21:48:41'),
(38, '2110010138', 'Irfan Bakti', 'Bimbingan dan Konseling', '2025-01-12 21:48:41'),
(39, '2110010139', 'Julia Perez', 'Pendidikan Bahasa Inggris', '2025-01-12 21:48:41'),
(40, '2110010140', 'Koko Prayogo', 'Pendidikan Olahraga', '2025-01-12 21:48:41'),
(41, '2110010141', 'Luna Maya', 'Pendidikan Kimia', '2025-01-12 21:48:41'),
(42, '2110010142', 'Mario Teguh', 'Manajemen', '2025-01-12 21:48:41'),
(43, '2110010143', 'Nina Zatulini', 'Agribisnis', '2025-01-12 21:48:41'),
(44, '2110010144', 'Opick Tomok', 'Peternakan', '2025-01-12 21:48:41'),
(45, '2110010145', 'Prilly Lima', 'Hukum Ekonomi Syariah (Muamalah)', '2025-01-12 21:48:41'),
(46, '2110010146', 'Qiara Putri', 'Pendidikan Guru Madrasah Ibtidaiyah', '2025-01-12 21:48:41'),
(47, '2110010147', 'Rendi Pratama', 'Ekonomi Syariah', '2025-01-12 21:48:41'),
(48, '2110010148', 'Siska Putri', 'Kesehatan Masyarakat', '2025-01-12 21:48:41'),
(49, '2110010149', 'Tegar Septian', 'Ilmu Hukum', '2025-01-12 21:48:41'),
(50, '2110010150', 'Ulfa Dwi', 'Farmasi', '2025-01-12 21:48:41'),
(51, '2110010151', 'Vino Bastian', 'Teknik Informatika', '2025-01-12 21:48:41'),
(52, '2110010152', 'Wulan Guritno', 'Sistem Informasi', '2025-01-12 21:48:41'),
(53, '2110010153', 'Xena Xenita', 'Teknik Elektro', '2025-01-12 21:48:41'),
(57, '2210010280', 'elza ilham', 'Agribisnis', '2025-01-13 12:21:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mahasiswa_id` (`mahasiswa_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `npm` (`npm`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
