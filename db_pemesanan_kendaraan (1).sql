-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 05, 2025 at 05:59 PM
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
-- Database: `db_pemesanan_kendaraan`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'default', 'Data pemesanan telah updated', 'App\\Models\\Booking', 'updated', 5, 'App\\Models\\User', 3, '{\"old\": {\"status\": \"pending\", \"purpose\": \"Perjalanan dinas ke Malang.\", \"admin_id\": 1, \"end_date\": \"2025-07-21 17:00:00\", \"driver_id\": 5, \"start_date\": \"2025-07-20 09:00:00\", \"vehicle_id\": 4}, \"attributes\": {\"status\": \"approved\", \"purpose\": \"Perjalanan dinas ke Malang.\", \"admin_id\": 1, \"end_date\": \"2025-07-21 17:00:00\", \"driver_id\": 5, \"start_date\": \"2025-07-20 09:00:00\", \"vehicle_id\": 4}}', NULL, '2025-07-05 09:07:51', '2025-07-05 09:07:51'),
(2, 'default', 'Pemesanan disetujui sepenuhnya', 'App\\Models\\Booking', NULL, 5, 'App\\Models\\User', 3, '[]', NULL, '2025-07-05 09:07:51', '2025-07-05 09:07:51'),
(3, 'default', 'Data pemesanan telah updated', 'App\\Models\\Booking', 'updated', 2, 'App\\Models\\User', 3, '{\"old\": {\"status\": \"pending\", \"purpose\": \"Perjalanan dinas ke Jakarta.\", \"admin_id\": 1, \"end_date\": \"2025-07-17 18:00:00\", \"driver_id\": 1, \"start_date\": \"2025-07-15 07:00:00\", \"vehicle_id\": 2}, \"attributes\": {\"status\": \"approved\", \"purpose\": \"Perjalanan dinas ke Jakarta.\", \"admin_id\": 1, \"end_date\": \"2025-07-17 18:00:00\", \"driver_id\": 1, \"start_date\": \"2025-07-15 07:00:00\", \"vehicle_id\": 2}}', NULL, '2025-07-05 09:07:54', '2025-07-05 09:07:54'),
(4, 'default', 'Pemesanan disetujui sepenuhnya', 'App\\Models\\Booking', NULL, 2, 'App\\Models\\User', 3, '[]', NULL, '2025-07-05 09:07:54', '2025-07-05 09:07:54'),
(5, 'default', 'Data pemesanan telah updated', 'App\\Models\\Booking', 'updated', 7, 'App\\Models\\User', 3, '{\"old\": {\"status\": \"pending\", \"purpose\": \"Kunjungan rutin ke vendor.\", \"admin_id\": 1, \"end_date\": \"2025-07-25 15:00:00\", \"driver_id\": 2, \"start_date\": \"2025-07-25 13:00:00\", \"vehicle_id\": 2}, \"attributes\": {\"status\": \"approved\", \"purpose\": \"Kunjungan rutin ke vendor.\", \"admin_id\": 1, \"end_date\": \"2025-07-25 15:00:00\", \"driver_id\": 2, \"start_date\": \"2025-07-25 13:00:00\", \"vehicle_id\": 2}}', NULL, '2025-07-05 09:11:33', '2025-07-05 09:11:33'),
(6, 'default', 'Pemesanan disetujui sepenuhnya', 'App\\Models\\Booking', NULL, 7, 'App\\Models\\User', 3, '[]', NULL, '2025-07-05 09:11:33', '2025-07-05 09:11:33');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `driver_id` bigint UNSIGNED NOT NULL,
  `purpose` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` enum('pending','approved','rejected','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `admin_id`, `vehicle_id`, `driver_id`, `purpose`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 'Kunjungan ke klien di Surabaya.', '2025-07-10 08:00:00', '2025-07-10 17:00:00', 'approved', '2025-07-05 15:12:58', '2025-07-05 15:12:58'),
(2, 1, 2, 1, 'Perjalanan dinas ke Jakarta.', '2025-07-15 07:00:00', '2025-07-17 18:00:00', 'approved', '2025-07-05 15:12:58', '2025-07-05 09:07:54'),
(3, 1, 3, 3, 'Mengantar dokumen ke kantor cabang.', '2025-07-08 10:00:00', '2025-07-08 12:00:00', 'rejected', '2025-07-05 15:12:58', '2025-07-05 15:12:58'),
(5, 1, 4, 5, 'Perjalanan dinas ke Malang.', '2025-07-20 09:00:00', '2025-07-21 17:00:00', 'approved', '2025-07-05 15:28:19', '2025-07-05 09:07:51'),
(7, 1, 2, 2, 'Kunjungan rutin ke vendor.', '2025-07-25 13:00:00', '2025-07-25 15:00:00', 'approved', '2025-07-05 15:28:19', '2025-07-05 09:11:33');

-- --------------------------------------------------------

--
-- Table structure for table `booking_approvals`
--

CREATE TABLE `booking_approvals` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `approver_id` bigint UNSIGNED NOT NULL,
  `level` int UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_approvals`
--

INSERT INTO `booking_approvals` (`id`, `booking_id`, `approver_id`, `level`, `status`, `approved_at`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 'approved', '2025-07-05 15:12:58', 'OK, silakan.', NULL, NULL),
(2, 1, 3, 2, 'approved', '2025-07-05 15:12:58', 'Setuju.', NULL, NULL),
(3, 2, 2, 1, 'approved', '2025-07-05 15:12:58', 'Disetujui, lanjut ke Kadiv.', NULL, NULL),
(4, 2, 3, 2, 'approved', '2025-07-05 09:07:54', NULL, NULL, '2025-07-05 09:07:54'),
(5, 3, 2, 1, 'rejected', '2025-07-05 15:12:58', 'Kendaraan tidak tersedia, gunakan untuk keperluan lain yang lebih mendesak.', NULL, NULL),
(6, 3, 3, 2, 'pending', NULL, NULL, NULL, NULL),
(9, 5, 2, 1, 'approved', '2025-07-05 15:28:19', 'Driver dan kendaraan tersedia.', NULL, NULL),
(10, 5, 3, 2, 'approved', '2025-07-05 09:07:51', NULL, NULL, '2025-07-05 09:07:51'),
(13, 7, 2, 1, 'pending', NULL, NULL, NULL, NULL),
(14, 7, 3, 2, 'approved', '2025-07-05 09:11:33', NULL, NULL, '2025-07-05 09:11:33');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso', '081234567890', '2025-07-05 15:12:58', '2025-07-05 15:12:58'),
(2, 'Agus Wijaya', '081223344556', '2025-07-05 15:12:58', '2025-07-05 15:12:58'),
(3, 'Siti Aminah', '081555666777', '2025-07-05 15:12:58', '2025-07-05 15:12:58'),
(4, 'Dewi Lestari', '081333444555', '2025-07-05 15:28:18', '2025-07-05 15:28:18'),
(5, 'Eko Prasetyo', '081777888999', '2025-07-05 15:28:18', '2025-07-05 15:28:18');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_logs`
--

CREATE TABLE `fuel_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `liters` int UNSIGNED NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `odometer` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fuel_logs`
--

INSERT INTO `fuel_logs` (`id`, `vehicle_id`, `user_id`, `date`, `liters`, `cost`, `odometer`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-06-15', 35500, '450000.00', 12500, NULL, NULL),
(2, 2, 1, '2025-06-25', 40000, '510000.00', 8750, NULL, NULL),
(3, 3, 1, '2025-07-01', 32750, '420000.00', 15200, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
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
(4, '2025_07_04_090930_create_drivers_table', 1),
(5, '2025_07_04_090930_create_vehicles_table', 1),
(6, '2025_07_04_090931_create_bookings_table', 1),
(7, '2025_07_04_091218_create_booking_approvals_table', 1),
(8, '2025_07_05_052420_add_phone_number_to_drivers_table', 2),
(9, '2025_07_05_054540_create_fuel_logs_table', 3),
(10, '2025_07_05_054541_create_service_records_table', 3),
(11, '2025_07_05_144500_create_activity_log_table', 4),
(12, '2025_07_05_144501_add_event_column_to_activity_log_table', 4),
(13, '2025_07_05_144502_add_batch_uuid_column_to_activity_log_table', 4),
(14, '2025_07_05_152118_create_service_schedules_table', 5);

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
-- Table structure for table `service_records`
--

CREATE TABLE `service_records` (
  `id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `service_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `odometer` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_records`
--

INSERT INTO `service_records` (`id`, `vehicle_id`, `service_date`, `description`, `cost`, `odometer`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-05-20', 'Ganti Oli Mesin dan Filter Oli.', '750000.00', 10100, NULL, NULL),
(2, 2, '2025-06-01', 'Pengecekan rutin dan servis rem.', '1250000.00', 7500, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_schedules`
--

CREATE TABLE `service_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `vehicle_id` bigint UNSIGNED NOT NULL,
  `scheduled_for` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('dijadwalkan','selesai','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dijadwalkan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('i19GqhRvMycLRsIu1BJ8SkX89FoI9fruOQ5j5hxA', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRFBwYnF3azE4ajVkek1NUUw0UzN6Qm1QUlVzanRIRDlYbUNHcDhuUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXBvcnRzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1751731953);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','approver') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approver',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@kantor.com', NULL, '$2y$12$AoG25rqQ.M5GozlqrMin..V5nVWJPuWZpR6X00DcEuOqanzgNyw/O', 'admin', NULL, '2025-07-05 08:12:28', '2025-07-05 08:12:28'),
(2, 'Manajer', 'manajer@kantor.com', NULL, '$2y$12$cIOoSEmXXaiyHxgogc1TV.N6ii/o5hincFn7S6y7/Zuz9RveR5Gee', 'approver', NULL, '2025-07-05 08:12:29', '2025-07-05 08:12:29'),
(3, 'Kepala Divisi', 'kadiv@kantor.com', NULL, '$2y$12$lax9ugUp2ThJYQyBP1gbVeB5X2df7detwK8WGUPjmcrkCwXTU62ny', 'approver', NULL, '2025-07-05 08:12:29', '2025-07-05 08:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_plate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `name`, `license_plate`, `created_at`, `updated_at`) VALUES
(1, 'Toyota Avanza', 'N 1234 AB', '2025-07-05 15:12:58', '2025-07-05 15:12:58'),
(2, 'Mitsubishi Xpander', 'L 5678 CD', '2025-07-05 15:12:58', '2025-07-05 15:12:58'),
(3, 'Daihatsu Terios', 'W 9012 EF', '2025-07-05 15:12:58', '2025-07-05 15:12:58'),
(4, 'Suzuki Ertiga', 'N 4321 BA', '2025-07-05 15:28:19', '2025-07-05 15:28:19'),
(5, 'Honda BR-V', 'L 8765 DC', '2025-07-05 15:28:19', '2025-07-05 15:28:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_admin_id_foreign` (`admin_id`),
  ADD KEY `bookings_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `bookings_driver_id_foreign` (`driver_id`);

--
-- Indexes for table `booking_approvals`
--
ALTER TABLE `booking_approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_approvals_booking_id_foreign` (`booking_id`),
  ADD KEY `booking_approvals_approver_id_foreign` (`approver_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fuel_logs`
--
ALTER TABLE `fuel_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fuel_logs_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `fuel_logs_user_id_foreign` (`user_id`);

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
-- Indexes for table `service_records`
--
ALTER TABLE `service_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_records_vehicle_id_foreign` (`vehicle_id`);

--
-- Indexes for table `service_schedules`
--
ALTER TABLE `service_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_schedules_vehicle_id_foreign` (`vehicle_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicles_license_plate_unique` (`license_plate`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `booking_approvals`
--
ALTER TABLE `booking_approvals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fuel_logs`
--
ALTER TABLE `fuel_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `service_records`
--
ALTER TABLE `service_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_schedules`
--
ALTER TABLE `service_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `bookings_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `booking_approvals`
--
ALTER TABLE `booking_approvals`
  ADD CONSTRAINT `booking_approvals_approver_id_foreign` FOREIGN KEY (`approver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_approvals_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fuel_logs`
--
ALTER TABLE `fuel_logs`
  ADD CONSTRAINT `fuel_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fuel_logs_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_records`
--
ALTER TABLE `service_records`
  ADD CONSTRAINT `service_records_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_schedules`
--
ALTER TABLE `service_schedules`
  ADD CONSTRAINT `service_schedules_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
