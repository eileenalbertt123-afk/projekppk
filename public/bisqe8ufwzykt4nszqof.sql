-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: bisqe8ufwzykt4nszqof-mysql.services.clever-cloud.com:3306
-- Generation Time: Oct 10, 2026 at 07:40 AM
-- Server version: 8.0.22-13
-- PHP Version: 8.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bisqe8ufwzykt4nszqof`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-anggi@gmail.com|127.0.0.1', 'i:1;', 1791289013),
('laravel-cache-anggi@gmail.com|127.0.0.1:timer', 'i:1791289011;', 1791289012),
('laravel-cache-quuen@students.undip.ac.id|127.0.0.1', 'i:1;', 1791289533),
('laravel-cache-quuen@students.undip.ac.id|127.0.0.1:timer', 'i:1791289532;', 1791289532);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('ruangan','laboratorium','area_olahraga','peralatan_presentasi','audio_multimedia','lainnya') COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `capacity` int NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `equipment` json DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('tersedia','dalam_perbaikan','nonaktif') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tersedia',
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `type`, `location`, `capacity`, `description`, `equipment`, `image`, `status`, `updated_at`) VALUES
(1, 'Ruang Kelas A101', 'ruangan', 'Gedung A Lantai 1', 40, 'Ruang kelas standar dengan proyektor', '[\"Proyektor\", \"AC\", \"Whiteboard\", \"Wi-Fi\"]', 'facilities/07_Ruang Perkuliahan A305.png', 'tersedia', NULL),
(2, 'Ruang Kelas B203', 'ruangan', 'Gedung B Lantai 2', 30, 'Ruang kelas ber-AC', '[\"TV\", \"AC\", \"Wi-Fi\"]', 'facilities/07_Ruang Perkuliahan A305.png', 'tersedia', '2026-09-27 21:12:42'),
(3, 'Aula Serbaguna', 'ruangan', 'Gedung Rektorat Lantai 1', 200, 'Aula untuk acara besar, dilengkapi sound system', NULL, 'facilities/aula-serba-guna.jpg', 'tersedia', NULL),
(4, 'Lab Komputer 1', 'laboratorium', 'Gedung C Lantai 3', 25, '25 unit PC dengan spesifikasi tinggi', NULL, 'facilities/02_Lab Komputer 1.png', 'dalam_perbaikan', NULL),
(5, 'Lab Kimia', 'laboratorium', 'Gedung Sains Lantai 2', 20, 'Dilengkapi alat praktikum kimia dasar', NULL, 'facilities/lab-kimia.jpg', 'dalam_perbaikan', NULL),
(6, 'Lapangan Basket', 'area_olahraga', 'Area Olahraga', 20, 'Lapangan outdoor, permukaan aspal', NULL, 'facilities/04_Lapangan Basket.png', 'tersedia', NULL),
(7, 'Lapangan Futsal Indoor', 'area_olahraga', 'Gedung Olahraga Lantai 1', 14, 'Lapangan indoor dengan rumput sintetis', NULL, 'facilities/08_Lapangan Futsal Indoor.png', 'tersedia', NULL),
(8, 'Ruang Test', 'ruangan', 'Gedung B', 30, 'Ruangan umtuk pengujian', NULL, 'facilities/06_Ruang Rapat Senat Lt.3.png', 'tersedia', NULL),
(9, 'Lapangan Badminton', 'area_olahraga', 'Area Olahraga', 50, 'Lapangan badminton dengan fasilitas olahraga indoor.', NULL, 'facilities/Lapangan_badmin.jpg', 'tersedia', NULL),
(10, 'Lab Komputer 2', 'laboratorium', 'Gedung E Lantai 2', 20, '20 unit PC dengan spesifikasi tinggi', NULL, 'facilities/poS5Us1PbDQfwdTjzMzf9oSfyUiZKDo8JFwDteFd.png', 'tersedia', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_02_080815_update_users_table_for_breeze', 2),
(5, '2026_09_09_131217_add_image_to_facilities_table', 3),
(6, '2026_09_18_160216_add_equipment_to_facilities_table', 4),
(7, '2026_09_18_170033_add_identifier_to_users_table', 5),
(8, '2026_09_18_233936_drop_facility_access_table', 6),
(9, '2026_09_22_030618_create_reports_table', 7),
(10, '2026_09_22_041917_add_image_path_to_reports_table', 7),
(11, '2026_09_22_042924_add_updated_at_to_reports_table', 8),
(12, '2026_09_23_183955_create_registrable_users_table', 9),
(13, '2026_09_23_122245_add_status_verifikasi_to_users_table', 10),
(14, '2026_09_23_221045_add_preferences_to_users_table', 11),
(15, '2026_10_10_002237_add_remember_token_to_users_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrable_users`
--

CREATE TABLE `registrable_users` (
  `id` bigint UNSIGNED NOT NULL,
  `identifier` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type_id` int NOT NULL,
  `is_registered` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrable_users`
--

INSERT INTO `registrable_users` (`id`, `identifier`, `name`, `user_type_id`, `is_registered`, `created_at`, `updated_at`) VALUES
(1, '24060112345678', 'Dummy Mahasiswa', 1, 1, '2026-09-23 18:52:12', '2026-09-23 19:14:25'),
(2, '19850123456789', 'Dummy Dosen', 2, 1, '2026-09-23 18:52:12', '2026-09-23 20:39:24'),
(3, '19900123456789', 'Dummy Tendik', 3, 1, '2026-09-23 18:52:12', '2026-09-23 22:07:45'),
(4, '24060112345679', 'Mahasiswa Baru', 1, 1, '2026-10-09 23:05:00', '2026-10-09 23:31:34'),
(5, '19850123456790', 'Dosen Baru', 2, 1, '2026-10-09 23:05:32', '2026-10-10 14:25:56');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int NOT NULL,
  `report_code` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  `facility_id` int NOT NULL,
  `category` enum('elektronik_av','struktur_bangunan','mekanikal_utilitas','furnitur','jaringan_it','kebersihan','lainnya') COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('baru','diproses','selesai','ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'baru',
  `resolution_note` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `report_code`, `user_id`, `facility_id`, `category`, `description`, `image_path`, `status`, `resolution_note`, `created_at`, `updated_at`, `resolved_at`) VALUES
(1, 'LP-001', 13, 2, 'elektronik_av', 'ac panas', NULL, 'diproses', NULL, '2026-09-04 21:13:54', '2026-10-09 20:25:09', NULL),
(2, 'LP-002', 13, 8, 'kebersihan', 'Kotorr banget gila, minimal marahin or kasih peringatan buat buang sampah di tempat kalo nggk mau bersihin', NULL, 'selesai', NULL, '2026-09-23 23:45:15', '2026-10-09 20:02:04', NULL),
(3, 'LP-003', 13, 8, 'kebersihan', 'testing', NULL, 'baru', NULL, '2026-09-18 13:48:57', '2026-10-10 13:49:07', NULL),
(4, 'LP-004', 13, 4, 'jaringan_it', 'WIFI LEMOT', NULL, 'diproses', NULL, '2026-09-24 00:40:27', '2026-09-27 15:29:19', NULL),
(5, 'LP-005', 13, 3, 'furnitur', 'utduyjt', NULL, 'ditolak', NULL, '2026-09-24 00:53:30', '2026-09-26 14:35:40', NULL),
(6, 'LP-006', 13, 2, 'kebersihan', 'kurang bersih', NULL, 'selesai', NULL, '2026-09-24 15:54:43', '2026-09-30 09:16:20', NULL),
(7, 'LP-007', 13, 2, 'kebersihan', 'Kabel rusak', 'reports/8afqTQiyIB2UZooZOsm03KXooICCU2RBZrD54ORE.png', 'selesai', NULL, '2026-09-26 12:52:25', '2026-09-26 14:30:48', NULL),
(8, 'LP-008', 13, 7, 'lainnya', 'Gawangnya patah sorry', 'reports/mUYM5EHZd6Etr23ZBO9aaaNen7vmoqRMNV25TpzP.png', 'ditolak', NULL, '2026-10-01 18:46:05', '2026-10-09 19:54:37', NULL),
(9, 'LP-009', 13, 2, 'kebersihan', 'ada kecoak', NULL, 'selesai', NULL, '2026-10-02 00:55:03', '2026-10-02 17:09:53', NULL),
(10, 'LP-010', 13, 2, 'elektronik_av', 'TEST WARNING RESERVASI', NULL, 'selesai', NULL, '2026-10-02 21:32:39', '2026-10-10 13:25:35', NULL),
(11, 'LP-011', 13, 8, 'mekanikal_utilitas', 'LAMPU MATI', 'reports/kYn6zx9GfGO6EV6KcP3uM1egRyAA4h8ZV5yskeJI.png', 'selesai', NULL, '2026-10-02 22:00:36', '2026-10-09 17:13:57', NULL),
(12, 'LP-012', 13, 4, 'jaringan_it', 'Kabel putus, tolong perbaiki', 'reports/i6mSjlmYFXnmc1WH4weXzcFRygjPO83oAZekWTRu.png', 'ditolak', NULL, '2026-10-02 22:05:25', '2026-10-09 17:18:07', NULL),
(13, 'LP-013', 13, 6, 'mekanikal_utilitas', 'Lampunya mati, jadi kalo malem nggk bisa main', NULL, 'selesai', NULL, '2026-10-09 17:06:08', '2026-10-09 21:14:16', NULL),
(14, 'LP-014', 13, 4, 'furnitur', 'dimakan rayap', NULL, 'diproses', NULL, '2026-10-10 13:30:26', '2026-10-10 13:32:06', NULL),
(15, 'LP-015', 13, 7, 'kebersihan', 'hii kotor', NULL, 'ditolak', NULL, '2026-10-10 13:30:58', '2026-10-10 13:37:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `report_status_histories`
--

CREATE TABLE `report_status_histories` (
  `id` int NOT NULL,
  `report_id` int NOT NULL,
  `status` varchar(50) NOT NULL,
  `reason_category` varchar(100) DEFAULT NULL,
  `reason` text,
  `changed_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `report_status_histories`
--

INSERT INTO `report_status_histories` (`id`, `report_id`, `status`, `reason_category`, `reason`, `changed_by`, `created_at`) VALUES
(1, 7, 'diproses', NULL, NULL, 16, '2026-09-26 12:22:00'),
(2, 6, 'diproses', NULL, NULL, 16, '2026-09-26 13:15:11'),
(3, 7, 'selesai', NULL, 'gggg', 16, '2026-09-26 14:30:50'),
(4, 5, 'ditolak', 'duplikat_laporan', 'hhh', 16, '2026-09-26 14:35:40'),
(5, 4, 'diproses', NULL, NULL, 16, '2026-09-27 15:29:19'),
(6, 6, 'diproses', NULL, NULL, 16, '2026-09-27 21:12:42'),
(7, 6, 'selesai', NULL, 'sudah bener yeiy', 16, '2026-09-30 09:16:21'),
(8, 9, 'diproses', NULL, NULL, 16, '2026-10-02 17:09:08'),
(9, 9, 'selesai', NULL, 'sudah bersih tanpa ada kecoak', 16, '2026-10-02 17:09:55'),
(10, 10, 'diproses', NULL, NULL, 21, '2026-10-02 21:56:06'),
(11, 11, 'diproses', NULL, NULL, 16, '2026-10-09 17:09:10'),
(12, 11, 'selesai', NULL, 'oke', 16, '2026-10-09 17:13:59'),
(13, 12, 'ditolak', 'laporan_tidak_valid', 'yyy', 16, '2026-10-09 17:18:07'),
(14, 13, 'diproses', NULL, NULL, 16, '2026-10-09 17:31:19'),
(15, 8, 'ditolak', 'laporan_tidak_valid', 'Laporan tidak sesuai kenyataan', 16, '2026-10-09 19:54:37'),
(16, 2, 'diproses', NULL, NULL, 16, '2026-10-09 19:58:28'),
(17, 2, 'selesai', NULL, 'ya', 16, '2026-10-09 20:02:05'),
(18, 1, 'diproses', NULL, NULL, 16, '2026-10-09 20:25:10'),
(19, 13, 'selesai', NULL, 'ya', 16, '2026-10-09 21:14:17'),
(20, 10, 'selesai', NULL, 'yaa', 16, '2026-10-10 13:25:36'),
(21, 14, 'diproses', NULL, NULL, 16, '2026-10-10 13:32:08'),
(22, 15, 'ditolak', 'duplikat_laporan', 'y', 16, '2026-10-10 13:37:51');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `reservation_code` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `activity_description` text COLLATE utf8mb4_general_ci,
  `participant_count` int DEFAULT NULL,
  `document` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('menunggu','disetujui','ditolak','dibatalkan','selesai') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `reservation_code`, `user_id`, `purpose`, `activity_description`, `participant_count`, `document`, `status`, `created_at`, `updated_at`, `start_time`, `end_time`) VALUES
(1, 'RV-001', 9, 'Rapat koordinasi organisasi mahasiswa', NULL, 20, NULL, 'dibatalkan', '2026-09-18 08:15:00', '2026-09-24 06:10:04', '2026-09-22 08:00:00', '2026-09-22 10:00:00'),
(2, 'RV-002', 10, 'Praktikum pemrograman kelompok', NULL, 20, NULL, 'selesai', '2026-09-18 10:30:00', '2026-09-24 05:56:05', '2026-09-23 10:00:00', '2026-09-23 12:00:00'),
(3, 'RV-003', 11, 'Diskusi dan presentasi tugas kelompok', NULL, 15, NULL, 'ditolak', '2026-09-19 09:00:00', '2026-09-21 21:27:07', '2026-09-24 13:00:00', '2026-09-24 15:00:00'),
(4, 'RV-004', 13, 'Latihan basket mahasiswa', NULL, 16, NULL, 'ditolak', '2026-09-19 14:20:00', '2026-09-21 20:43:43', '2026-09-25 16:00:00', '2026-09-25 18:00:00'),
(5, 'RV-005', 9, 'Kegiatan Diskusi Kelompok', 'Kegiatan diskusi kelompok mahasiswa di Ruang Kelas B203.', 20, NULL, 'selesai', '2026-09-21 20:58:54', '2026-09-24 16:42:05', '2026-09-24 14:30:00', '2026-09-24 16:30:00'),
(9, 'RV-009', 13, 'Mau makan malam bersama anak anak', NULL, 20, NULL, 'dibatalkan', '2026-09-22 05:33:44', '2026-09-24 06:10:07', '2026-09-22 10:00:00', '2026-09-22 12:00:00'),
(10, 'RV-010', 13, 'Seminar', NULL, 100, NULL, 'dibatalkan', '2026-09-22 05:43:52', '2026-09-24 06:10:08', '2026-09-22 12:00:00', '2026-09-22 14:00:00'),
(11, 'RV-011', 13, 'Rapat', NULL, 20, NULL, 'dibatalkan', '2026-09-22 13:25:16', '2026-09-24 06:10:09', '2026-09-22 16:00:00', '2026-09-22 17:00:00'),
(12, 'RV-012', 13, 'Lomba', NULL, 18, NULL, 'dibatalkan', '2026-09-22 13:26:21', '2026-09-22 14:19:38', '2026-09-24 08:00:00', '2026-09-24 09:00:00'),
(13, 'RV-013', 13, 'Lomba basket antar fakultas', NULL, 25, NULL, 'selesai', '2026-09-22 15:58:51', '2026-10-09 12:27:26', '2026-10-08 07:00:00', '2026-10-08 10:00:00'),
(14, 'RV-014', 13, 'MAU KELAS COY', NULL, 25, NULL, 'selesai', '2026-09-23 17:43:05', '2026-09-24 05:56:07', '2026-09-23 19:00:00', '2026-09-23 20:00:00'),
(15, 'RV-015', 13, 'ngodshgdl nndg', 'vdkndxk', 1, NULL, 'selesai', '2026-09-24 16:51:59', '2026-09-24 20:00:02', '2026-09-24 17:00:00', '2026-09-24 20:00:00'),
(16, 'RV-016', 13, 'ANFORCOM', 'Lomba bidang DDSC', 20, 'documents/e1WQ6Al7xuBFvMHQSOcgDyjHx3OiLgoTiQCHfFpR.pdf', 'selesai', '2026-09-26 21:47:46', '2026-09-30 16:00:05', '2026-09-30 07:00:00', '2026-09-30 16:00:00'),
(17, 'RV-017', 13, 'ANFORCOM 2026', NULL, 26, NULL, 'dibatalkan', '2026-09-30 10:04:50', '2026-10-01 07:13:07', '2026-10-01 07:00:00', '2026-10-01 12:00:00'),
(18, 'RV-018', 13, 'Apple Seminar', 'yeiy', 1, NULL, 'dibatalkan', '2026-09-30 10:27:16', '2026-09-30 11:56:29', '2026-10-01 10:30:00', '2026-10-01 13:00:00'),
(19, 'RV-019', 9, 'Kontes Menyanyi', 'Nyanyi', 30, NULL, 'selesai', '2026-09-30 10:57:31', '2026-10-02 17:04:04', '2026-10-01 10:30:00', '2026-10-01 13:00:00'),
(20, 'RV-020', 9, 'Kontes Menyanyi', 'Nyanyi', 30, 'documents/2nHOfSNwccEEvoM0pxteH6jrJjohe5h5rv7FLrr6.jpg', 'ditolak', '2026-09-30 10:57:40', '2026-09-30 12:04:57', '2026-10-01 10:30:00', '2026-10-01 13:00:00'),
(21, 'RV-021', 13, 'Kontes Menyanyi', 'aaaa', 10, NULL, 'ditolak', '2026-09-30 11:59:04', '2026-09-30 12:04:58', '2026-10-01 10:30:00', '2026-10-01 13:00:00'),
(22, 'RV-022', 13, 'Positif', NULL, 35, NULL, 'dibatalkan', '2026-10-01 18:34:56', '2026-10-02 17:04:06', '2026-10-02 07:30:00', '2026-10-02 08:30:00'),
(23, 'RV-023', 13, 'Positif', NULL, 35, NULL, 'dibatalkan', '2026-10-01 18:35:08', '2026-10-02 17:04:07', '2026-10-02 07:30:00', '2026-10-02 08:30:00'),
(24, 'RV-024', 13, 'Positif', NULL, 35, NULL, 'dibatalkan', '2026-10-01 18:43:59', '2026-10-02 17:04:08', '2026-10-02 07:30:00', '2026-10-02 08:30:00'),
(25, 'RV-025', 13, 'Lomba', NULL, 10, 'documents/eZ47EgYK17FfPQ5ZK2XUY8t9brj23RRKdpgeOE71.png', 'dibatalkan', '2026-10-01 22:45:58', '2026-10-06 15:31:05', '2026-10-03 07:00:00', '2026-10-03 09:00:00'),
(26, 'RV-026', 13, 'Praktikum Kimia', 'Ujian praktikum kimia organik untuk mahasiswa semester 5', 40, 'documents/a0P9cIL3Bg7TyUkSmTOZWfy7EFrnhaAVbAEsn80h.pdf', 'dibatalkan', '2026-10-02 17:20:15', '2026-10-06 15:31:06', '2026-10-03 08:00:00', '2026-10-03 10:00:00'),
(27, 'RV-027', 13, 'Ujian Tengah Semester', 'UTS cuy', 1, 'documents/4R2KdL4I4irpGJ1YqrhIFjyzwWWXarMirkhQm1lk.pdf', 'selesai', '2026-10-02 21:24:14', '2026-10-06 15:31:04', '2026-10-03 07:00:00', '2026-10-03 09:00:00'),
(28, 'RV-028', 13, 'Seminar DICODING', 'Pengenalan program magang intensif dari dicoding.', 30, NULL, 'selesai', '2026-10-06 19:12:31', '2026-10-09 12:27:27', '2026-10-08 08:30:00', '2026-10-08 12:00:00'),
(29, 'RV-029', 9, 'Presentasi Karya Ilmiah', 'Lomba KTI dan Business Logic Nasional', 30, NULL, 'ditolak', '2026-10-06 19:34:13', '2026-10-06 19:38:41', '2026-10-08 10:00:00', '2026-10-08 12:00:00'),
(30, 'RV-030', 9, 'Praktikum ASA', 'Melakukan praktikum mata kuliah ASA', 20, NULL, 'dibatalkan', '2026-10-09 13:05:04', '2026-10-09 13:07:16', '2026-10-10 16:30:00', '2026-10-10 19:00:00'),
(31, 'RV-031', 9, 'Lomba POSITIF Basket', 'Lomba pertandingan basket Infor dengan Teknik', 18, NULL, 'ditolak', '2026-10-09 13:52:48', '2026-10-09 14:03:50', '2026-10-10 17:30:00', '2026-10-10 20:00:00'),
(32, 'RV-032', 13, 'Lomba Futsal', 'Ada lomba futsal', 11, NULL, 'disetujui', '2026-10-09 14:16:47', '2026-10-09 14:22:09', '2026-10-10 16:00:00', '2026-10-10 18:00:00'),
(33, 'RV-033', 9, 'Lomba Senam', 'Penilaian senam', 12, NULL, 'ditolak', '2026-10-09 14:17:57', '2026-10-09 14:22:09', '2026-10-10 16:00:00', '2026-10-10 18:00:00'),
(34, 'RV-034', 13, 'jksahfsa', NULL, 21, NULL, 'disetujui', '2026-10-09 15:05:54', '2026-10-09 15:10:46', '2026-10-13 07:00:00', '2026-10-13 10:00:00'),
(35, 'RV-035', 13, 'Lomba', NULL, 15, NULL, 'disetujui', '2026-10-09 15:13:30', '2026-10-09 15:52:35', '2026-10-14 07:00:00', '2026-10-14 08:00:00'),
(36, 'RV-036', 9, 'Praktikum MBD', 'belajar mbd', 16, NULL, 'dibatalkan', '2026-10-09 15:32:58', '2026-10-10 13:04:36', '2026-10-10 16:30:00', '2026-10-10 19:00:00'),
(37, 'RV-037', 9, 'Presentasi Susulan Sistem Informasi', 'Presentasi tugas besar kelompok', 10, NULL, 'disetujui', '2026-10-09 15:34:24', '2026-10-09 15:37:24', '2026-10-11 08:30:00', '2026-10-11 12:00:00'),
(38, 'RV-038', 9, 'Ujian Menyanyi', 'Tugas Besar Seni Budaya)', 20, NULL, 'disetujui', '2026-10-09 15:35:59', '2026-10-09 15:38:47', '2026-10-13 08:00:00', '2026-10-13 10:00:00'),
(39, 'RV-039', 13, 'Positif', NULL, 50, NULL, 'ditolak', '2026-10-09 15:36:18', '2026-10-09 15:52:35', '2026-10-14 07:00:00', '2026-10-14 08:00:00'),
(40, 'RV-040', 13, 'bjkwfhwaf', NULL, 1, NULL, 'menunggu', '2026-10-09 15:53:42', '2026-10-09 15:53:42', '2026-10-16 07:00:00', '2026-10-16 07:30:00'),
(41, 'RV-041', 13, 'abdajd', NULL, 1, NULL, 'ditolak', '2026-10-09 16:24:22', '2026-10-10 13:11:43', '2026-10-14 08:00:00', '2026-10-14 08:30:00'),
(42, 'RV-042', 13, 'Seminar', NULL, 9, NULL, 'dibatalkan', '2026-10-09 17:16:08', '2026-10-10 13:10:11', '2026-10-13 07:00:00', '2026-10-13 08:30:00'),
(43, 'RV-043', 13, 'jjj', NULL, 1, 'documents/hcIhyQ4RGjEkArESw7k7WCXaeUmnGbJMKf3wuX0o.pdf', 'menunggu', '2026-10-09 19:03:34', '2026-10-09 19:03:34', '2026-10-12 07:00:00', '2026-10-12 07:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_detail`
--

CREATE TABLE `reservation_detail` (
  `id` int NOT NULL,
  `reservation_id` int NOT NULL,
  `facility_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation_detail`
--

INSERT INTO `reservation_detail` (`id`, `reservation_id`, `facility_id`) VALUES
(1, 1, 1),
(2, 2, 4),
(3, 3, 2),
(4, 4, 6),
(5, 5, 2),
(6, 9, 1),
(7, 10, 3),
(8, 11, 1),
(9, 12, 4),
(10, 13, 6),
(11, 14, 1),
(12, 15, 1),
(13, 16, 2),
(14, 17, 1),
(15, 18, 3),
(16, 19, 3),
(17, 20, 3),
(18, 21, 3),
(19, 22, 6),
(20, 23, 6),
(21, 24, 6),
(22, 25, 9),
(23, 26, 1),
(24, 27, 2),
(25, 28, 3),
(26, 29, 3),
(27, 30, 4),
(28, 31, 6),
(29, 32, 7),
(30, 33, 7),
(31, 34, 6),
(32, 35, 6),
(33, 36, 4),
(34, 37, 1),
(35, 38, 3),
(36, 39, 6),
(37, 40, 6),
(38, 41, 6),
(39, 42, 1),
(40, 43, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservation_status_histories`
--

CREATE TABLE `reservation_status_histories` (
  `id` int NOT NULL,
  `reservation_id` int NOT NULL,
  `status` enum('menunggu','disetujui','ditolak','dibatalkan','selesai') NOT NULL,
  `reason_category` varchar(100) DEFAULT NULL,
  `reason` text,
  `changed_by` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation_status_histories`
--

INSERT INTO `reservation_status_histories` (`id`, `reservation_id`, `status`, `reason_category`, `reason`, `changed_by`, `created_at`) VALUES
(1, 1, 'menunggu', NULL, NULL, NULL, '2026-09-18 08:15:00'),
(2, 2, 'menunggu', NULL, NULL, NULL, '2026-09-18 10:30:00'),
(3, 3, 'menunggu', NULL, NULL, NULL, '2026-09-19 09:00:00'),
(4, 4, 'menunggu', NULL, NULL, NULL, '2026-09-19 14:20:00'),
(5, 4, 'ditolak', 'Jadwal Tidak Memungkinkan', 'Fasilitas akan dipakai oleh departemen.', 16, '2026-09-21 20:43:43'),
(6, 5, 'disetujui', NULL, 'Data dummy untuk simulasi bentrok jadwal', NULL, '2026-09-21 20:58:59'),
(7, 3, 'ditolak', 'Jadwal Tidak Memungkinkan', 'Dipakai orang lain', 16, '2026-09-21 21:27:08'),
(8, 2, 'disetujui', NULL, NULL, 16, '2026-09-21 21:29:24'),
(9, 13, 'disetujui', NULL, NULL, 16, '2026-09-23 10:41:35'),
(10, 14, 'disetujui', NULL, NULL, 16, '2026-09-24 05:42:41'),
(11, 2, 'selesai', NULL, 'Status otomatis karena waktu peminjaman telah selesai', NULL, '2026-09-24 05:56:06'),
(12, 14, 'selesai', NULL, 'Status otomatis karena waktu peminjaman telah selesai', NULL, '2026-09-24 05:56:07'),
(13, 1, 'dibatalkan', 'otomatis_sistem', 'Status otomatis karena tanggal peminjaman telah lewat', NULL, '2026-09-24 06:10:05'),
(17, 9, 'dibatalkan', 'otomatis_sistem', 'Status otomatis karena tanggal peminjaman telah lewat', NULL, '2026-09-24 06:10:08'),
(18, 10, 'dibatalkan', 'otomatis_sistem', 'Status otomatis karena tanggal peminjaman telah lewat', NULL, '2026-09-24 06:10:08'),
(19, 11, 'dibatalkan', 'otomatis_sistem', 'Status otomatis karena tanggal peminjaman telah lewat', NULL, '2026-09-24 06:10:09'),
(20, 5, 'selesai', NULL, 'Status otomatis karena waktu peminjaman telah selesai', NULL, '2026-09-24 09:42:08'),
(21, 15, 'disetujui', NULL, NULL, 16, '2026-09-24 09:56:49'),
(22, 15, 'selesai', NULL, 'Status otomatis karena waktu peminjaman telah selesai', NULL, '2026-09-24 13:00:02'),
(23, 16, 'disetujui', NULL, NULL, 16, '2026-09-26 14:50:15'),
(24, 18, 'disetujui', NULL, NULL, 16, '2026-09-30 03:59:54'),
(25, 18, 'dibatalkan', 'Lainnya', 'yh', 16, '2026-09-30 04:56:29'),
(26, 20, 'ditolak', 'Jadwal Tidak Memungkinkan', 'Reservasi otomatis ditolak karena jadwal fasilitas sudah disetujui untuk reservasi lain.', 16, '2026-09-30 05:04:57'),
(27, 21, 'ditolak', 'Jadwal Tidak Memungkinkan', 'Reservasi otomatis ditolak karena jadwal fasilitas sudah disetujui untuk reservasi lain.', 16, '2026-09-30 05:04:59'),
(28, 19, 'disetujui', NULL, NULL, 16, '2026-09-30 05:05:00'),
(29, 16, 'selesai', NULL, 'Status otomatis karena waktu peminjaman telah selesai', NULL, '2026-09-30 09:00:06'),
(30, 17, 'dibatalkan', 'otomatis_sistem', 'Status otomatis karena tanggal peminjaman telah lewat', NULL, '2026-10-01 00:13:08'),
(31, 19, 'selesai', NULL, 'Status otomatis karena waktu peminjaman telah selesai', NULL, '2026-10-02 10:04:05'),
(32, 22, 'dibatalkan', 'otomatis_sistem', 'Status otomatis karena tanggal peminjaman telah lewat', NULL, '2026-10-02 10:04:06'),
(33, 23, 'dibatalkan', 'otomatis_sistem', 'Status otomatis karena tanggal peminjaman telah lewat', NULL, '2026-10-02 10:04:07'),
(34, 24, 'dibatalkan', 'otomatis_sistem', 'Status otomatis karena tanggal peminjaman telah lewat', NULL, '2026-10-02 10:04:08'),
(35, 27, 'selesai', NULL, 'Status otomatis karena waktu peminjaman telah selesai', NULL, '2026-10-06 08:31:04'),
(36, 25, 'dibatalkan', 'otomatis_sistem', 'Status otomatis karena tanggal peminjaman telah lewat', NULL, '2026-10-06 08:31:05'),
(37, 26, 'dibatalkan', 'otomatis_sistem', 'Status otomatis karena tanggal peminjaman telah lewat', NULL, '2026-10-06 08:31:06'),
(38, 29, 'ditolak', 'Jadwal Tidak Memungkinkan', 'Reservasi otomatis ditolak karena jadwal fasilitas sudah disetujui untuk reservasi lain.', NULL, '2026-10-06 12:38:40'),
(39, 28, 'disetujui', NULL, NULL, 16, '2026-10-06 12:38:41'),
(40, 13, 'selesai', NULL, 'Status otomatis karena waktu peminjaman telah selesai', NULL, '2026-10-09 05:27:26'),
(41, 28, 'selesai', NULL, 'Status otomatis karena waktu peminjaman telah selesai', NULL, '2026-10-09 05:27:27'),
(42, 30, 'disetujui', NULL, NULL, 16, '2026-10-09 06:06:16'),
(43, 30, 'dibatalkan', 'Kepentingan Prioritas Kampus', 'Dipinjam oleh fakultas untuk acara dari luar kampus', 16, '2026-10-09 06:07:16'),
(44, 31, 'ditolak', 'Dokumen Tidak Lengkap', 'Dokumen tidak valid', 16, '2026-10-09 07:03:50'),
(45, 33, 'ditolak', 'Jadwal Tidak Memungkinkan', 'Reservasi otomatis ditolak karena jadwal fasilitas sudah disetujui untuk reservasi lain.', NULL, '2026-10-09 07:22:09'),
(46, 32, 'disetujui', NULL, NULL, 16, '2026-10-09 07:22:10'),
(47, 34, 'disetujui', NULL, NULL, 16, '2026-10-09 08:10:46'),
(48, 37, 'disetujui', NULL, NULL, 16, '2026-10-09 08:37:24'),
(49, 38, 'disetujui', NULL, NULL, 16, '2026-10-09 08:38:47'),
(50, 39, 'ditolak', 'Jadwal Tidak Memungkinkan', 'Reservasi otomatis ditolak karena jadwal fasilitas sudah disetujui untuk reservasi lain.', NULL, '2026-10-09 08:52:35'),
(51, 35, 'disetujui', NULL, NULL, 16, '2026-10-09 08:52:35'),
(52, 36, 'disetujui', NULL, NULL, 16, '2026-10-10 06:03:19'),
(53, 36, 'dibatalkan', 'Kepentingan Prioritas Kampus', 'yy', 16, '2026-10-10 06:04:36'),
(54, 42, 'disetujui', NULL, NULL, 16, '2026-10-10 06:09:36'),
(55, 42, 'dibatalkan', 'Kepentingan Prioritas Kampus', 'yy', 16, '2026-10-10 06:10:11'),
(56, 41, 'ditolak', 'Jadwal Tidak Memungkinkan', 'y', 16, '2026-10-10 06:11:44');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0tNDWpqWdzz6G7M0CoWKPSVk5izOy45MJA65tbhy', 24, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJEbnBhS2xOaUtXQnFUQmpCV1pyYXNEM0w5cFdlMkkydzIyaHVyMDlPIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2Zhc2lsaXRhcyIsInJvdXRlIjoiZmFjaWxpdGllcy5pbmRleCJ9LCJwYXNzd29yZF9oYXNoX3dlYiI6IjEzM2UwMTc4NjYwMWJiYWNhZDkzYTU4ZmU5ZTE4ZTA1YjA1MGFmZjQzZGQwYTRjMWQ0ZDM4ZDE5NWQ5MjkzYTIiLCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MjR9', 1791617245),
('T2oDbNvY5Zrd3Yqn9peiTd0ym4AD5G069Qb1jx9Z', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 Edg/155.0.0.0', 'eyJfdG9rZW4iOiJscUtCRnZ6QzZsamxuQVZKNkptNjFpTDdKNVIxUDlDaVFvZks5RDg2IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9wZW5nZ3VuYSIsInJvdXRlIjoiYWRtaW4ucGVuZ2d1bmEuaW5kZXgifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjcsInBhc3N3b3JkX2hhc2hfd2ViIjoiMDVlZGRmOGM0Nzg2NDFlY2U4M2I4MWQxMzBjYWYwZTIwNmMyZWE2MWU3ZDI1Y2E4YWQyNTM2MWVlOTJjY2M5OSJ9', 1791617216);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `user_type_id` int DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `preferences` json DEFAULT NULL,
  `identifier` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','petugas','pengguna') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pengguna',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_akun` enum('aktif','nonaktif','menunggu') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aktif',
  `status_verifikasi` enum('menunggu','diverifikasi','ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu',
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type_id`, `name`, `email`, `preferences`, `identifier`, `password`, `role`, `created_at`, `updated_at`, `status_akun`, `status_verifikasi`, `remember_token`) VALUES
(7, NULL, 'Admin', 'admin@undip.ac.id', NULL, NULL, '$2y$12$UQPm7kGq7wTHo4gZA1FBsuDCful1Pw34yHX3gPaF106.RzacT5c9y', 'admin', '2026-09-09 04:46:32', '2026-09-10 09:01:51', 'aktif', 'diverifikasi', NULL),
(8, NULL, 'elen', 'eileen@worker.undip.ac.id', NULL, NULL, '$2y$12$.3grjyWrVnu.g65NNxrr9.lApKKT0xF2nvrS6r4SI3GPOfQhEv0vm', 'petugas', '2026-09-09 04:54:52', '2026-09-09 04:54:52', 'aktif', 'diverifikasi', NULL),
(9, 1, 'anggi', 'anggi@students.undip.ac.id', NULL, NULL, '$2y$12$qclVsuek3EnRD4QXFMb6bOC80FlGgzrmZhzyJX1LyI2Fv/sO8X6US', 'pengguna', '2026-09-09 04:58:08', '2026-09-09 04:58:08', 'aktif', 'diverifikasi', NULL),
(10, 1, 'Queenay', 'quuen@students.undip.ac.id', NULL, NULL, '$2y$12$XlfF2947H4rqmWN7qV.VtOC.9EZmpAqD7DNgrpY3YWIPBZNcs/7iG', 'pengguna', '2026-09-10 09:05:19', '2026-09-10 09:05:19', 'aktif', 'diverifikasi', NULL),
(11, 1, 'Nashwa Al', 'nashwa@students.undip.ac.id', NULL, NULL, '$2y$12$Moc4ILI0VXaV/qnpbuZh..0idYosN7TbsLjt/w2h3AQ7Tg6TLz7na', 'pengguna', '2026-09-11 00:22:54', '2026-09-11 00:22:54', 'aktif', 'diverifikasi', NULL),
(12, NULL, 'Supriyadi', 'supri@worker.undip.ac.id', NULL, NULL, '$2y$12$9vt00vdLlC0Jx1tA4Ti0kOBhSikBkaUZLEso0JqIVzFsztzTWZaae', 'petugas', '2026-09-15 07:31:04', '2026-09-15 07:31:04', 'aktif', 'diverifikasi', NULL),
(13, 1, 'Nabil', 'bila@students.undip.ac.id', '{\"theme\": \"light\", \"email_notifications\": true}', NULL, '$2y$12$fOFuqrbk2A9KITVSCiTDVOePgfuZh3LP38Qbvx8kMcXlbQ2GKRr6q', 'pengguna', '2026-09-15 08:10:53', '2026-09-24 13:54:27', 'aktif', 'diverifikasi', NULL),
(14, 1, 'tes', 'tes@students.undip.ac.id', NULL, NULL, '$2y$12$UorJrk0yes1Pi6kiOHn0oO1GyKEKtSNCqNp/Oi1IjyXWlNQp4t09C', 'pengguna', '2026-09-18 13:23:25', '2026-09-23 12:49:15', 'aktif', 'diverifikasi', NULL),
(15, NULL, 'tess', 'tess@worker.undip.ac.id', NULL, NULL, '$2y$12$HLzOdP0DehmuuDW77znARO59/nUrWDIKrc2aX6a03KpbWu/ALgkpi', 'petugas', '2026-09-18 13:41:39', '2026-09-18 13:41:39', 'aktif', 'diverifikasi', NULL),
(16, NULL, 'patrick', 'patrick@worker.undip.ac.id', NULL, NULL, '$2y$12$Wp8bejhES5dcRHRm8GqaGO4cEhTxPMegqm9AcB3dB3FMvdNtJUomO', 'petugas', '2026-09-18 13:51:41', '2026-09-18 13:51:41', 'aktif', 'diverifikasi', NULL),
(17, 1, 'eileen', 'eileenalbertt123@gmail.com', NULL, '24060112345678', '$2y$12$JhwSi9gVqozTvi/0WAusa.0HwkkgIgKKN2AzWjFcudXWQQ/pOY1la', 'pengguna', '2026-09-23 19:14:25', '2026-09-23 19:14:25', 'aktif', 'diverifikasi', NULL),
(18, 1, 'Marta', 'marta@students.undip.ac.id', NULL, NULL, '$2y$12$ZTCTEn6aVN.iKoEd6lq3A.tgZloVlNIPPyjph/JRc2xBcnKw0cCsm', 'pengguna', '2026-09-23 12:40:52', '2026-09-23 13:34:59', 'aktif', 'diverifikasi', NULL),
(19, 2, 'lisbon', 'lisbon@gmail.com', NULL, '19850123456789', '$2y$12$exSzM2zcKoZ/D4NSYzz41.MbPGfWG.j6rwEC6RlHVYnI1pY.zFIIi', 'pengguna', '2026-09-23 20:39:24', '2026-09-23 13:42:06', 'nonaktif', 'ditolak', NULL),
(20, 3, 'bosco', 'bosco@gmail.com', NULL, '19900123456789', '$2y$12$jdbxSX7zfCFbJyzixK1dbe7/OYDA1i9F/zwX6GD.mYZ4GSpFqwPMS', 'pengguna', '2026-09-23 22:07:45', '2026-10-10 14:20:43', 'aktif', 'diverifikasi', NULL),
(21, NULL, 'Tara', 'tara@gmail.com', NULL, NULL, '$2y$12$kQmT1y18ULKrHVCpgA6VBOkQBJetOZp4yNuyAyY9rJkTwof0C0Fd2', 'petugas', '2026-10-02 14:01:29', '2026-10-02 14:01:29', 'aktif', 'diverifikasi', NULL),
(22, NULL, 'Owen', 'owen@gmail.com', NULL, NULL, '$2y$12$fuITiXMY/pdVeONGDSDYh.DG32ZpxS.zG1/nRSbTCrXdeXuM530b.', 'petugas', '2026-10-09 18:56:40', '2026-10-09 18:56:40', 'aktif', 'diverifikasi', NULL),
(23, 1, 'andi', 'alberttandrio0@gmail.com', NULL, '24060112345679', '$2y$12$BUiv6Qg3fo4nTzzHwXWJ.uAGJzFvr52MX.UMOUcNSREYdk6lynBF6', 'pengguna', '2026-10-09 23:31:34', '2026-10-10 00:25:26', 'menunggu', 'menunggu', 'cSbtO7nDdhB1eMv10MtZAq1FpCZp4d04ex4rd9hctZaSMV1coOUHQVeOdzon'),
(24, 2, 'Jane', 'jane@gmail.com', NULL, '19850123456790', '$2y$12$2RV9WS6ofYaJRzOjecy4xu7dShUiXEXoJxFjI8IyF2rGph8s7rWEe', 'pengguna', '2026-10-10 14:25:56', '2026-10-10 14:26:52', 'aktif', 'diverifikasi', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `name`) VALUES
(1, 'mahasiswa'),
(2, 'dosen'),
(3, 'staf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `registrable_users`
--
ALTER TABLE `registrable_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registrable_users_identifier_unique` (`identifier`),
  ADD KEY `registrable_users_user_type_id_foreign` (`user_type_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `report_code` (`report_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `facility_id` (`facility_id`);

--
-- Indexes for table `report_status_histories`
--
ALTER TABLE `report_status_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_report_status_history_report` (`report_id`),
  ADD KEY `fk_report_status_history_user` (`changed_by`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservation_code_unique` (`reservation_code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reservation_detail`
--
ALTER TABLE `reservation_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `facility_id` (`facility_id`);

--
-- Indexes for table `reservation_status_histories`
--
ALTER TABLE `reservation_status_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_history_reservation` (`reservation_id`),
  ADD KEY `fk_history_changed_by` (`changed_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_type_id` (`user_type_id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `registrable_users`
--
ALTER TABLE `registrable_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `report_status_histories`
--
ALTER TABLE `report_status_histories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `reservation_detail`
--
ALTER TABLE `reservation_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reservation_status_histories`
--
ALTER TABLE `reservation_status_histories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `registrable_users`
--
ALTER TABLE `registrable_users`
  ADD CONSTRAINT `registrable_users_user_type_id_foreign` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`);

--
-- Constraints for table `report_status_histories`
--
ALTER TABLE `report_status_histories`
  ADD CONSTRAINT `fk_report_status_history_report` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_report_status_history_user` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reservation_detail`
--
ALTER TABLE `reservation_detail`
  ADD CONSTRAINT `reservation_detail_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_detail_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`);

--
-- Constraints for table `reservation_status_histories`
--
ALTER TABLE `reservation_status_histories`
  ADD CONSTRAINT `fk_history_changed_by` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_history_reservation` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
