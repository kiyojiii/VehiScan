-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2024 at 11:29 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vehiscan`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `appointment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_initial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_department_agency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_or_photo_of_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'None / Approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `vehicle_id`, `status_id`, `user_id`, `appointment_id`, `serial_number`, `id_number`, `last_name`, `first_name`, `middle_initial`, `present_address`, `email_address`, `contact_number`, `office_department_agency`, `position_designation`, `scan_or_photo_of_id`, `approval_status`, `reason`, `created_at`, `updated_at`) VALUES
(0, 38, 12, 1, 19, '521', '213', 'Omongos', 'Christian Rex', 'B', 'Abigail, Iligan City', 'christianrexomongos@gmail.com', '55555555555', 'CCS', 'Student', '1710001778.png', 'Approved', 'None / Approved', '2024-03-09 16:29:38', '2024-03-09 16:29:38'),
(110, 39, 13, 1, 26, '1234', '213123', 'Chu', 'Alexis Jan', 'M', 'Steeltown', 'alexisjanchu@gmail.com', '23132312312', 'CCS', 'Student', '1710151936.png', 'Approved', 'None / Approved', '2024-03-11 10:12:18', '2024-03-11 15:49:55'),
(111, 43, 12, 1, 17, '321333', '213', 'Velasquez', 'Clint Joshua', 'O', 'Purok 1 Luinab, Iligan City', 'clintjoshua.velasquez@g.msuiit.edu.ph', '31232131232', 'CCV', 'Student', '1710228576.png', 'Approved', 'None / Approved', '2024-03-12 07:29:38', '2024-03-12 08:30:58'),
(112, 44, 12, 1, 20, '33213123', '2123123', 'Jinayon', 'Samuel Paul', 'M', 'Luinab, Bahayan', 'samuelpauljinayon@gmail.com', '32312452312', 'CCS', 'Student', '1710234261.jpg', 'Approved', 'None / Approved', '2024-03-12 09:04:22', '2024-03-12 09:08:52'),
(114, NULL, 12, 25, 17, 'N321312', '43439-8522', 'test', 'test51231', 'o', 'test', 'test@yahoo.com', '88888888888', 'test', 'test', '1711525571.png', 'Pending', 'Owner Update Request', '2024-03-18 05:47:38', '2024-03-27 08:01:34'),
(117, 55, 13, 26, 20, '65533', '23233', 'd', 'Joshua', 'a', 'dwad', 'c13456@yahoo.com', '55555555555', 'CCS', 'Student', '1710774658.png', 'Pending', 'For Verification', '2024-03-18 15:10:58', '2024-03-27 06:25:39');

-- --------------------------------------------------------

--
-- Table structure for table `applicants_record`
--

CREATE TABLE `applicants_record` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `appointment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_initial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_department_agency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_or_photo_of_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'None / Approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `appointment`, `created_at`, `updated_at`) VALUES
(17, 'Permanent', '2024-02-10 05:09:11', '2024-02-10 05:09:11'),
(19, 'Casual', '2024-02-10 05:09:20', '2024-02-10 05:09:20'),
(20, 'Contractual(Job Order)', '2024-02-10 05:09:32', '2024-02-10 05:09:32'),
(21, 'Lecturer', '2024-02-10 05:09:38', '2024-02-10 05:09:38'),
(25, 'Others', '2024-02-10 05:52:29', '2024-02-15 11:48:25'),
(26, 'Partner/Supplier', '2024-02-19 15:16:18', '2024-02-19 15:16:18');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_license_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_driver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorized_driver_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorized_driver_license_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Approved',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'None / Approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `user_id`, `driver_name`, `driver_license_image`, `authorized_driver_name`, `authorized_driver_address`, `authorized_driver_license_image`, `approval_status`, `reason`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Clint Joshua O. Velasquez', '1707750461.jpg', 'Clint Joshua O. Velasquez 2', 'Clint Joshua O. Velasquez', '1707750461.png', 'Approved', 'None / Approved', '2024-02-12 15:07:41', '2024-02-12 15:07:41'),
(2, NULL, 'Clint Joshua O. Velasquez', '1707750472.jpg', 'Clint Joshua O. Velasquez 2', 'Clint Joshua O. Velasquez', '1707750472.png', 'Approved', 'None / Approved', '2024-02-12 15:07:52', '2024-02-12 15:07:52'),
(3, NULL, 'Clint Joshua O. Velasquez', '1707750475.jpg', 'Clint Joshua O. Velasquez 2', 'Clint Joshua O. Velasquez', '1707750475.png', 'Approved', 'None / Approved', '2024-02-12 15:07:55', '2024-02-12 15:07:55'),
(4, NULL, 'Clint Joshua O. Velasquez', '1707750504.jpg', 'Clint Joshua O. Velasquez 2', 'Clint Joshua O. Velasquez', '1707750504.png', 'Approved', 'None / Approved', '2024-02-12 15:08:24', '2024-02-12 15:08:24'),
(5, NULL, 'Clint Joshua O. Velasquez', '1707750508.jpg', 'Clint Joshua O. Velasquez 2', 'Clint Joshua O. Velasquez', '1707750508.png', 'Approved', 'None / Approved', '2024-02-12 15:08:28', '2024-02-12 15:08:28'),
(6, NULL, 'Clint Joshua O. Velasquez', '1707750509.jpg', 'Clint Joshua O. Velasquez 2', 'Clint Joshua O. Velasquez', '1707750509.png', 'Approved', 'None / Approved', '2024-02-12 15:08:29', '2024-02-12 15:08:29'),
(7, NULL, 'Clint Joshua O. Velasquez', '1707750510.jpg', 'Clint Joshua O. Velasquez 2', 'Clint Joshua O. Velasquez', '1707750510.png', 'Approved', 'None / Approved', '2024-02-12 15:08:30', '2024-02-12 15:08:30'),
(8, NULL, 'Clint Joshua O. Velasquez', '1707750511.jpg', 'Clint Joshua O. Velasquez 2', 'Clint Joshua O. Velasquez', '1707750511.png', 'Approved', 'None / Approved', '2024-02-12 15:08:31', '2024-02-12 15:08:31'),
(9, NULL, 'Clint Joshua O. Velasquez', '1707750513.jpg', 'Clint Joshua O. Velasquez 2', 'Clint Joshua O. Velasquez', '1707750513.png', 'Approved', 'None / Approved', '2024-02-12 15:08:33', '2024-02-12 15:08:33'),
(11, NULL, 'Clint Joshua O. Velasquez', '1707752992.jpg', 'Clint Joshua O. Velasquez 2', 'Clint Joshua O. Velasquez', '1707752992.jpg', 'Approved', 'None / Approved', '2024-02-12 15:49:52', '2024-02-12 15:49:52'),
(12, NULL, 'Clint Joshua O. Velasquez', '1707754122.jpg', 'Clint Joshua O. Velasquez', 'Clint Joshua O. Velasquez', '1707754122.jpg', 'Approved', 'None / Approved', '2024-02-12 16:08:42', '2024-02-12 16:08:42'),
(13, 1, 'Clint Joshua O. Velasquez - updated', '1707834217.png', 'Clint Joshua O. Velasquez - updated', 'Clint Joshua O. Velasquez - updated', '1707834217.jpg', 'Approved', 'None / Approved', '2024-02-12 16:14:40', '2024-02-13 14:46:24'),
(16, 1, 'd', '1708008321.jpg', 'd', 'd', '1708008294.jpg', 'Approved', 'None / Approved', '2024-02-15 14:44:54', '2024-02-15 14:45:21'),
(18, 1, 'd2d21', 'be12921b-b3fa-4228-9319-54fb156d6f20.jpg', '21d', 'd2d1', '40b668f2-08d7-4f05-a780-f9de0086e498.jpg', 'Approved', 'None / Approved', '2024-02-15 14:48:59', '2024-02-15 15:02:57'),
(19, 1, 'new', '566631de-a072-4791-9aaf-e93ef59a62b7.jpg', 'neww', 'new', '395a777d-a247-419d-8e03-d28196300ed5.jpg', 'Approved', 'None / Approved', '2024-02-19 12:08:08', '2024-02-19 12:08:08'),
(20, 1, '1', '3da22887-1d68-452c-8b53-b333b1455557.png', '1', '1', '4b970744-3804-4b38-961f-e64b6823d110.png', 'Approved', 'None / Approved', '2024-02-23 15:42:13', '2024-02-23 15:42:13'),
(21, 1, '2', '6c9e07ce-cd35-4068-bc41-149523c38190.jpg', '2', '2', '68af263e-cacb-456e-bca3-0a09fac59729.jpg', 'Approved', 'None / Approved', '2024-02-27 05:07:52', '2024-02-27 05:07:52'),
(22, 1, '3', 'a22e6c92-40f8-4b4c-9168-23dd0e867493.jpg', '3', '3', '7fc621ff-1324-47fe-aee0-17bf073b8816.jpg', 'Approved', 'None / Approved', '2024-02-27 05:24:30', '2024-02-27 05:24:30'),
(23, 1, '4', '3daf5ee2-0c82-4c9e-bf37-5d6d60a51b8f.jpg', '4', '4', 'c8e79697-307b-4f24-b8a0-9800e968f832.jpg', 'Approved', 'None / Approved', '2024-02-27 05:27:16', '2024-02-27 05:27:16'),
(25, 1, '6', '6a9b776c-9201-4ad6-bf84-d4368c865846.jpg', '6', '6', 'aaf557ef-42e2-4e31-bab9-a37ffc407f38.jpg', 'Approved', 'None / Approved', '2024-02-27 06:42:56', '2024-02-27 06:42:56'),
(28, 1, 'Olivia Rodrigo Duterte', 'a53ccd80-aaa7-4a4a-8a2c-04e5e845f815.jpg', 'Taylor Swift', 'U.S.A Canada, Buru-Un', '37190f58-09c5-41dc-90bf-58dfc9e6ef72.jpg', 'Approved', 'None / Approved', '2024-02-27 07:01:53', '2024-03-03 05:30:30'),
(105, 1, 'Clint Joshua O. Velasquez 22', 'd2e059c2-460a-4a00-8d67-9f9a718d9885.jpg', 'Clint Joshua O. Velasquez 22', 'Clint Joshua O. Velasquez22', 'ef0243e5-c718-470d-8d16-2dd6a9078fd9.jpg', 'Approved', 'None / Approved', '2024-03-09 13:25:31', '2024-03-09 13:25:31'),
(106, 1, 'nn', 'f3c17248-2f77-42ef-8822-247f18ea6d9a.png', 'nn', 'mn', '83983524-6c4f-48aa-8da6-cc6e9af4abbe.png', 'Approved', 'None / Approved', '2024-03-09 15:13:32', '2024-03-09 15:13:32'),
(107, 1, 'Taylor Lautner', '9ff730f9-7e10-45a3-9f21-133c9750b778.png', 'dkkkk', 'kkkkjhgf', 'cad03e3b-0d6a-49f1-9c4a-ea04cec90336.png', 'Approved', 'None / Approved', '2024-03-09 15:55:07', '2024-03-09 15:55:07'),
(110, 1, 'Alexis Jan M. Chu2', '35a9980a-85d6-4ad2-b567-d73615906851.png', 'Christian Rex B. Omongos35', 'Abigail', 'a6fe335c-f068-4fb6-bd4d-d583a6b85d93.png', 'Approved', 'None / Approved', '2024-03-11 10:12:18', '2024-03-14 13:45:38'),
(111, 1, 'Sir Elmer', '710890d2-df4a-4c50-a84e-90458789a95c.jpg', 'Taylor Fast', 'U.S.A Canada, Buru-Un', '81baad24-d3cc-43df-8135-ecf5af78eebb.jpg', 'Approved', 'None / Approved', '2024-03-11 16:16:55', '2024-03-11 16:16:55'),
(112, 1, 'Olivia Rodrigo Swift', '63f22a73-9ab8-46b4-ba9d-39152648f8c5.png', 'Clint Joshua O. Velasquez - 2', 'Clint Joshua O. Velasquez - 2', '6b8c3d93-a45a-4f1a-86d3-5159ece9e9f1.png', 'Approved', 'None / Approved', '2024-03-12 07:29:38', '2024-03-12 07:29:38'),
(113, 1, 'Samuel Paul M. Jinayon5', 'bb14bff2-eaf3-4a4b-aac1-d23853afe26a.jpg', 'Samuel Paulo M. Avelino3', 'U.S.A Canada, Buru-Un', '89a01594-382b-429c-a2bc-344acb70b2d2.jpg', 'Approved', 'None / Approved', '2024-03-12 09:04:22', '2024-03-14 13:38:35'),
(115, 25, 'Hello', '57677746-ba7b-46df-a065-a0753043a6de.jpg', 'test2', 'test2', '26870acb-7918-47f9-ad10-62bfbfb8529a.jpg', 'Pending', 'Driver Update Request', '2024-03-18 05:47:38', '2024-03-27 08:33:43'),
(118, 26, 'Clint Joshua O. Velasquez - updatedddddddddd', 'd310fa6d-a68c-4c01-848b-7c05fd860bbb.jpg', 'Clint Joshua O. Velasquez - updatedddddddddddd', 'Clint Joshua O. Velasquez - updated', '489a3598-391f-43e0-8104-f0b6e552d3eb.jpg', 'Pending', 'For Verification', '2024-03-18 15:10:58', '2024-03-18 15:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `drivers_record`
--

CREATE TABLE `drivers_record` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_license_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_driver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorized_driver_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorized_driver_license_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Approved',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'None / Approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_01_30_131107_create_permission_tables', 1),
(7, '2024_01_30_131242_create_products_table', 1),
(8, '2024_02_06_022820_create_appointments_table', 1),
(9, '2024_02_06_022851_create_statuses_table', 1),
(10, '2024_02_06_023156_create_drivers_table', 1),
(11, '2024_02_06_023531_create_vehicles_table', 1),
(12, '2024_02_06_023608_create_times_table', 1),
(13, '2024_02_06_023630_create_violations_table', 1),
(14, '2024_02_06_023702_create_applicants_table', 1),
(15, '2024_03_06_155923_create_vehicle_record_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 16),
(2, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(4, 'App\\Models\\User', 25),
(4, 'App\\Models\\User', 26),
(4, 'App\\Models\\User', 27);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'create-role', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53'),
(2, 'edit-role', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53'),
(3, 'delete-role', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53'),
(4, 'create-user', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53'),
(5, 'edit-user', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53'),
(6, 'delete-user', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53'),
(7, 'create-product', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53'),
(8, 'edit-product', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53'),
(9, 'delete-product', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53'),
(10, 'delete-products', 'web', '2024-03-17 07:16:38', '2024-03-17 07:16:38'),
(11, 'delete-productss', 'web', '2024-03-17 07:17:19', '2024-03-17 07:17:19'),
(13, 'dasdasdaaaaaaa', 'web', '2024-03-17 07:17:54', '2024-03-17 08:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53'),
(2, 'Admin', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53'),
(3, 'Product Manager', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53'),
(4, 'Applicant', 'web', '2024-03-17 05:58:32', '2024-03-17 05:58:32');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(4, 2),
(4, 4),
(5, 2),
(5, 4),
(6, 2),
(6, 4),
(7, 2),
(7, 3),
(8, 2),
(8, 3),
(9, 2),
(9, 3);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `applicant_role_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `applicant_role_status`, `created_at`, `updated_at`) VALUES
(12, 'Academic Staff (Faculty)', '2024-03-09 06:29:11', '2024-03-09 06:29:11'),
(13, 'Non-Academic Staff (Faculty)', '2024-03-09 06:29:16', '2024-03-09 06:29:16'),
(14, 'Partner', '2024-03-09 06:29:27', '2024-03-09 06:29:27'),
(15, 'Official', '2024-03-09 06:29:33', '2024-03-09 06:29:33'),
(16, 'awdawddawdaw]', '2024-03-09 06:34:30', '2024-03-09 06:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `times`
--

CREATE TABLE `times` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `times`
--

INSERT INTO `times` (`id`, `vehicle_id`, `time_in`, `time_out`, `created_at`, `updated_at`) VALUES
(73, 31, '2024-02-15 09:50:01', '2024-03-05 10:51:17', '2024-03-05 01:50:01', '2024-02-12 16:00:00'),
(74, 30, '2024-03-05 09:50:08', '2024-03-05 21:06:32', '2024-03-05 01:50:08', '2024-03-05 13:06:32'),
(75, 29, '2024-03-05 09:50:13', '2024-03-05 11:21:43', '2024-03-05 01:50:13', '2024-03-05 03:21:43'),
(78, 26, '2024-03-05 09:50:41', '2024-03-05 09:51:14', '2024-03-05 01:50:41', '2024-03-05 01:51:14'),
(79, 24, '2024-03-05 09:50:44', '2024-03-05 10:56:45', '2024-03-05 01:50:44', '2024-03-05 02:56:45'),
(81, 23, '2024-03-05 09:50:52', '2024-03-05 11:15:34', '2024-03-05 01:50:52', '2024-03-05 03:15:34'),
(82, 21, '2024-03-05 09:50:56', NULL, '2024-03-05 01:50:56', '2024-03-05 01:50:56'),
(83, 22, '2024-03-05 09:50:59', '2024-03-05 11:13:37', '2024-03-05 01:50:59', '2024-03-05 03:13:37'),
(84, 26, '2024-03-05 09:51:24', '2024-03-05 11:16:26', '2024-03-05 01:51:24', '2024-03-05 03:16:26'),
(85, 31, '2024-03-05 10:51:25', '2024-03-05 21:06:26', '2024-03-05 02:51:25', '2024-03-05 13:06:26'),
(86, 24, '2024-03-05 10:57:09', '2024-03-05 11:14:54', '2024-03-05 02:57:09', '2024-03-05 03:14:54'),
(88, 22, '2024-03-05 11:13:50', '2024-03-05 11:13:56', '2024-03-05 03:13:50', '2024-03-05 03:13:56'),
(89, 24, '2024-03-05 11:15:03', '2024-03-05 16:09:10', '2024-03-05 03:15:03', '2024-03-05 08:09:10'),
(90, 22, '2024-03-05 11:21:32', '2024-03-05 11:22:15', '2024-03-05 03:21:32', '2024-03-05 03:22:15'),
(91, 22, '2024-03-05 11:22:27', NULL, '2024-03-05 03:22:27', '2024-03-05 03:22:27'),
(92, 23, '2024-03-05 11:25:08', '2024-03-05 11:25:12', '2024-03-05 03:25:08', '2024-03-05 03:25:12'),
(93, 23, '2024-03-05 11:25:15', '2024-03-05 21:23:21', '2024-03-05 03:25:15', '2024-03-05 13:23:21'),
(94, 24, '2024-03-05 16:09:15', '2024-03-05 16:55:29', '2024-03-05 08:09:15', '2024-03-05 08:55:29'),
(97, 24, '2024-03-05 16:56:05', '2024-03-05 16:56:17', '2024-03-05 08:56:05', '2024-03-05 08:56:17'),
(98, 24, '2024-03-05 16:56:20', '2024-03-05 16:56:46', '2024-02-05 08:56:20', '2024-03-05 08:56:46'),
(99, 24, '2024-03-05 16:57:06', '2024-03-05 16:57:30', '2024-03-05 08:57:06', '2024-03-05 08:57:30'),
(100, 24, '2024-03-05 16:59:07', '2024-03-05 16:59:09', '2024-03-05 08:59:07', '2024-03-05 08:59:09'),
(101, 24, '2024-03-05 16:59:11', '2024-03-05 16:59:12', '2024-03-05 08:59:11', '2024-03-05 08:59:12'),
(102, 24, '2024-03-05 16:59:14', '2024-03-05 16:59:15', '2024-03-05 08:59:14', '2024-03-05 08:59:15'),
(103, 24, '2024-03-05 16:59:35', '2024-03-05 16:59:37', '2024-03-05 08:59:35', '2024-03-05 08:59:37'),
(104, 24, '2024-03-05 16:59:38', '2024-03-05 16:59:41', '2024-03-05 08:59:38', '2024-03-05 08:59:41'),
(105, 24, '2024-03-05 16:59:43', '2024-03-05 16:59:46', '2024-03-05 08:59:43', '2024-03-05 08:59:46'),
(106, 24, '2024-03-05 16:59:47', '2024-03-05 16:59:49', '2024-03-05 08:59:47', '2024-03-05 08:59:49'),
(107, 24, '2024-03-05 17:03:23', NULL, '2024-03-05 09:03:23', '2024-03-05 09:03:23'),
(108, 31, '2024-03-05 21:06:29', '2024-03-05 21:06:35', '2024-03-05 13:06:29', '2024-03-05 13:06:35'),
(109, 31, '2024-03-05 21:07:31', '2024-03-05 21:33:37', '2024-03-05 13:07:31', '2024-03-05 13:33:37'),
(110, 30, '2024-03-05 21:33:47', '2024-03-05 21:33:53', '2024-03-05 13:33:47', '2024-03-05 13:33:53'),
(111, 31, '2024-03-05 21:33:50', '2024-03-05 21:37:18', '2024-03-05 13:33:50', '2024-03-05 13:37:18'),
(112, 31, '2024-03-05 21:43:06', '2024-03-05 21:43:58', '2024-03-05 13:43:06', '2024-03-05 13:43:58'),
(113, 30, '2024-03-05 21:43:25', '2024-03-05 21:44:04', '2024-03-05 13:43:25', '2024-03-05 13:44:04'),
(114, 29, '2024-03-05 21:44:18', '2024-03-05 21:44:22', '2024-03-05 13:44:18', '2024-03-05 13:44:22'),
(115, 31, '2024-03-05 21:44:29', '2024-03-05 21:44:37', '2024-03-05 13:44:29', '2024-03-05 13:44:37'),
(116, 29, '2024-03-05 21:44:33', '2024-03-05 21:44:41', '2024-03-05 13:44:33', '2024-03-05 13:44:41'),
(118, 31, '2024-03-05 21:44:53', '2024-03-05 21:46:43', '2024-03-05 13:44:53', '2024-03-05 13:46:43'),
(119, 30, '2024-03-05 21:44:57', '2024-03-05 21:48:42', '2024-03-05 13:44:57', '2024-03-05 13:48:42'),
(120, 29, '2024-03-05 21:49:03', '2024-03-06 17:32:40', '2024-03-05 13:49:03', '2024-03-06 09:32:40'),
(121, 29, '2024-03-06 17:33:27', '2024-03-06 17:33:34', '2024-03-06 09:33:27', '2024-03-06 09:33:34'),
(122, 29, '2024-03-06 17:35:00', '2024-03-06 17:35:05', '2024-03-06 09:35:00', '2024-03-06 09:35:05'),
(123, 29, '2024-03-06 17:48:30', '2024-03-06 17:48:32', '2024-03-06 09:48:30', '2024-03-06 09:48:32'),
(124, 29, '2024-03-06 17:48:33', '2024-03-06 22:49:50', '2024-03-06 09:48:33', '2024-03-06 14:49:50'),
(125, 29, '2024-03-06 22:49:53', '2024-03-06 22:50:46', '2024-03-06 14:49:53', '2024-03-06 14:50:46'),
(126, 29, '2024-03-06 22:50:47', '2024-03-06 22:52:14', '2024-03-06 14:50:47', '2024-03-06 14:52:14'),
(127, 29, '2024-03-06 22:52:19', '2024-03-06 22:55:28', '2024-03-06 14:52:19', '2024-03-06 14:55:28'),
(128, 29, '2024-03-06 22:55:33', '2024-03-06 22:55:47', '2024-03-06 14:55:33', '2024-03-06 14:55:47'),
(129, 29, '2024-03-06 22:55:52', '2024-03-06 23:00:07', '2024-03-06 14:55:52', '2024-03-06 15:00:07'),
(130, 29, '2024-03-06 23:00:12', '2024-03-06 23:02:14', '2024-03-06 15:00:12', '2024-03-06 15:02:14'),
(131, 29, '2024-03-06 23:02:18', '2024-03-06 23:03:15', '2024-03-06 15:02:18', '2024-03-06 15:03:15'),
(132, 29, '2024-03-06 23:03:19', '2024-03-06 23:05:24', '2024-03-06 15:03:19', '2024-03-06 15:05:24'),
(133, 29, '2024-03-06 23:05:32', '2024-03-06 23:07:24', '2024-03-06 15:05:32', '2024-03-06 15:07:24'),
(134, 29, '2024-03-06 23:07:42', '2024-03-06 23:08:33', '2024-03-06 15:07:42', '2024-03-06 15:08:33'),
(135, 29, '2024-03-06 23:08:39', '2024-03-06 23:09:59', '2024-03-06 15:08:39', '2024-03-06 15:09:59'),
(136, 29, '2024-03-06 23:10:03', '2024-03-06 23:18:03', '2024-03-06 15:10:03', '2024-03-06 15:18:03'),
(137, 11, '2024-03-06 23:14:16', '2024-03-06 23:15:06', '2024-03-06 15:14:16', '2024-03-06 15:15:06'),
(138, 20, '2024-03-06 23:14:30', '2024-03-06 23:14:40', '2024-03-06 15:14:30', '2024-03-06 15:14:40'),
(139, 11, '2024-03-06 23:15:48', '2024-03-06 23:17:24', '2024-03-06 15:15:48', '2024-03-06 15:17:24'),
(140, 11, '2024-03-06 23:17:37', '2024-03-06 23:19:46', '2024-03-06 15:17:37', '2024-03-06 15:19:46'),
(141, 29, '2024-03-06 23:18:07', '2024-03-06 23:18:15', '2024-03-06 15:18:07', '2024-03-06 15:18:15'),
(142, 29, '2024-03-06 23:18:21', '2024-03-06 23:19:36', '2024-03-06 15:18:21', '2024-03-06 15:19:36'),
(143, 29, '2024-03-06 23:19:41', '2024-03-06 23:21:39', '2024-03-06 15:19:41', '2024-03-06 15:21:39'),
(144, 11, '2024-03-06 23:19:58', '2024-03-06 23:20:05', '2024-03-06 15:19:58', '2024-03-06 15:20:05'),
(145, 11, '2024-03-06 23:20:07', '2024-03-06 23:24:21', '2024-03-06 15:20:07', '2024-03-06 15:24:21'),
(146, 29, '2024-03-06 23:21:45', '2024-03-07 22:53:06', '2024-03-06 15:21:45', '2024-03-07 14:53:06'),
(147, 11, '2024-03-06 23:24:25', '2024-03-06 23:36:31', '2024-03-06 15:24:25', '2024-03-06 15:36:31'),
(148, 11, '2024-03-06 23:41:10', '2024-03-06 23:43:03', '2024-03-06 15:41:10', '2024-03-06 15:43:03'),
(149, 11, '2024-03-06 23:49:57', '2024-03-06 23:53:16', '2024-03-06 15:49:57', '2024-03-06 15:53:16'),
(150, 11, '2024-03-06 23:59:26', '2024-03-06 23:59:39', '2024-03-06 15:59:26', '2024-03-06 15:59:39'),
(151, 11, '2024-03-07 00:04:09', '2024-03-07 00:04:14', '2024-03-06 16:04:09', '2024-03-06 16:04:14'),
(152, 11, '2024-03-07 00:08:00', '2024-03-07 00:08:08', '2024-03-06 16:08:00', '2024-03-06 16:08:08'),
(153, 11, '2024-03-07 00:08:34', '2024-03-07 00:08:35', '2024-03-06 16:08:34', '2024-03-06 16:08:35'),
(154, 11, '2024-03-07 00:08:36', '2024-03-07 00:17:39', '2024-03-06 16:08:36', '2024-03-06 16:17:39'),
(155, 11, '2024-03-07 00:17:41', '2024-03-07 00:17:45', '2024-03-06 16:17:41', '2024-03-06 16:17:45'),
(156, 11, '2024-03-07 00:17:47', '2024-03-07 00:18:07', '2024-03-06 16:17:47', '2024-03-06 16:18:07'),
(157, 11, '2024-03-07 00:18:09', '2024-03-07 00:18:37', '2024-03-06 16:18:09', '2024-03-06 16:18:37'),
(158, 13, '2024-03-07 00:18:33', '2024-03-07 00:18:45', '2024-03-06 16:18:33', '2024-03-06 16:18:45'),
(159, 11, '2024-03-07 00:18:41', '2024-03-07 00:18:50', '2024-03-06 16:18:41', '2024-03-06 16:18:50'),
(160, 11, '2024-03-07 00:19:00', '2024-03-07 00:21:03', '2024-03-06 16:19:00', '2024-03-06 16:21:03'),
(161, 11, '2024-03-07 00:21:13', '2024-03-07 00:21:25', '2024-03-06 16:21:13', '2024-03-06 16:21:25'),
(162, 11, '2024-03-07 00:21:36', '2024-03-07 00:25:01', '2024-03-06 16:21:36', '2024-03-06 16:25:01'),
(163, 11, '2024-03-07 00:25:05', '2024-03-07 00:25:16', '2024-03-06 16:25:05', '2024-03-06 16:25:16'),
(164, 30, '2024-03-07 00:32:18', '2024-03-07 00:32:23', '2024-03-06 16:32:18', '2024-03-06 16:32:23'),
(165, 30, '2024-03-07 00:32:26', '2024-03-07 00:33:07', '2024-03-06 16:32:26', '2024-03-06 16:33:07'),
(166, 30, '2024-03-07 00:33:34', '2024-03-07 00:33:42', '2024-03-06 16:33:34', '2024-03-06 16:33:42'),
(167, 30, '2024-03-07 00:33:46', '2024-03-07 00:33:48', '2024-03-06 16:33:46', '2024-03-06 16:33:48'),
(168, 30, '2024-03-07 00:33:51', '2024-03-07 00:33:55', '2024-03-06 16:33:51', '2024-03-06 16:33:55'),
(169, 11, '2024-03-07 13:17:52', '2024-03-07 13:17:55', '2024-03-07 05:17:52', '2024-03-07 05:17:55'),
(170, 31, '2024-03-07 13:18:36', '2024-03-07 13:18:49', '2024-03-07 05:18:36', '2024-03-07 05:18:49'),
(171, 31, '2024-03-07 15:52:02', '2024-03-07 15:52:10', '2024-03-07 07:52:02', '2024-03-07 07:52:10'),
(172, 11, '2024-03-07 15:52:16', '2024-03-07 15:59:42', '2024-03-07 07:52:16', '2024-03-07 07:59:42'),
(173, 11, '2024-03-07 15:59:45', '2024-03-07 16:00:00', '2024-03-07 07:59:45', '2024-03-07 08:00:00'),
(174, 31, '2024-03-07 22:39:49', '2024-03-09 15:20:42', '2024-03-07 14:39:49', '2024-03-09 07:20:42'),
(175, 13, '2024-03-07 22:39:54', '2024-03-07 22:39:57', '2024-03-07 14:39:54', '2024-03-07 14:39:57'),
(176, 30, '2024-03-07 22:52:58', '2024-03-07 22:53:01', '2024-03-07 14:52:58', '2024-03-07 14:53:01'),
(177, 26, '2024-03-07 22:53:12', '2024-03-07 22:53:15', '2024-03-07 14:53:12', '2024-03-07 14:53:15'),
(178, 26, '2024-03-07 22:53:18', '2024-03-09 15:20:57', '2024-03-07 14:53:18', '2024-03-09 07:20:57'),
(179, 31, '2024-03-09 15:21:20', NULL, '2024-03-09 07:21:20', '2024-03-09 07:21:20'),
(183, 43, '2024-03-12 15:58:37', '2024-03-12 16:39:00', '2024-03-12 07:58:37', '2024-03-12 08:39:00'),
(184, 43, '2024-03-12 16:39:15', '2024-03-12 21:26:29', '2024-03-12 08:39:15', '2024-03-12 13:26:29'),
(185, 45, '2024-03-12 20:58:39', '2024-03-12 20:58:41', '2024-03-12 12:58:39', '2024-03-12 12:58:41'),
(186, 41, '2024-03-12 21:33:16', '2024-03-12 21:33:23', '2024-03-12 13:33:16', '2024-03-12 13:33:23'),
(187, 47, '2024-03-12 21:34:58', '2024-03-12 21:37:36', '2024-03-12 13:34:58', '2024-03-12 13:37:36'),
(188, 41, '2024-03-12 21:35:15', '2024-03-12 21:42:15', '2024-03-12 13:35:15', '2024-03-12 13:42:15'),
(189, 47, '2024-03-12 21:37:39', '2024-03-12 21:48:52', '2024-03-12 13:37:39', '2024-03-12 13:48:52'),
(190, 41, '2024-03-12 21:42:19', '2024-03-12 21:48:34', '2024-03-12 13:42:19', '2024-03-12 13:48:34'),
(191, 41, '2024-03-12 21:48:42', '2024-03-12 21:48:47', '2024-03-12 13:48:42', '2024-03-12 13:48:47'),
(192, 47, '2024-03-12 21:48:56', '2024-03-12 21:49:09', '2024-03-12 13:48:56', '2024-03-12 13:49:09'),
(193, 41, '2024-03-12 21:49:04', NULL, '2024-03-12 13:49:04', '2024-03-12 13:49:04'),
(194, 47, '2024-03-12 22:11:23', NULL, '2024-03-12 14:11:23', '2024-03-12 14:11:23'),
(195, 52, '2024-03-19 22:55:23', '2024-03-19 22:55:27', '2024-03-19 14:55:23', '2024-03-19 14:55:27'),
(196, 52, '2024-03-19 22:55:37', '2024-03-20 23:11:05', '2024-03-19 14:55:37', '2024-03-20 15:11:05'),
(197, 52, '2024-03-20 23:16:44', '2024-03-20 23:17:05', '2024-03-20 15:16:44', '2024-03-20 15:17:05'),
(198, 52, '2024-03-20 23:17:20', '2024-03-20 23:34:35', '2024-03-20 15:17:20', '2024-03-20 15:34:35'),
(199, 52, '2024-03-20 23:34:47', '2024-03-20 23:35:37', '2024-03-20 15:34:47', '2024-03-20 15:35:37'),
(200, 52, '2024-03-20 23:35:48', '2024-03-20 23:35:57', '2024-03-20 15:35:48', '2024-03-20 15:35:57'),
(201, 52, '2024-03-20 23:36:07', '2024-03-20 23:36:08', '2024-03-20 15:36:07', '2024-03-20 15:36:08'),
(202, 52, '2024-03-20 23:38:35', NULL, '2024-03-20 15:38:35', '2024-03-20 15:38:35'),
(203, 59, '2024-03-21 02:53:16', '2024-03-21 02:56:29', '2024-03-20 18:53:16', '2024-03-20 18:56:29'),
(204, 59, '2024-03-21 02:56:30', '2024-03-21 02:56:32', '2024-03-20 18:56:30', '2024-03-20 18:56:32'),
(205, 59, '2024-03-21 02:56:34', '2024-03-22 14:23:53', '2024-03-20 18:56:34', '2024-03-22 06:23:53'),
(206, 59, '2024-03-22 14:24:11', '2024-03-22 14:24:27', '2024-03-22 06:24:11', '2024-03-22 06:24:27'),
(207, 59, '2024-03-24 18:58:27', '2024-03-24 18:58:35', '2024-03-24 10:58:27', '2024-03-24 10:58:35'),
(208, 59, '2024-03-24 18:58:41', '2024-03-24 18:58:47', '2024-03-24 10:58:41', '2024-03-24 10:58:47'),
(209, 59, '2024-03-25 13:44:45', '2024-03-25 13:46:34', '2024-03-25 05:44:45', '2024-03-25 05:46:34'),
(210, 59, '2024-03-25 13:46:35', '2024-03-25 13:46:37', '2024-03-25 05:46:35', '2024-03-25 05:46:37'),
(211, 59, '2024-03-26 00:50:13', '2024-03-26 00:50:14', '2024-03-25 16:50:13', '2024-03-25 16:50:14'),
(212, 59, '2024-03-26 00:50:16', '2024-03-27 14:10:05', '2024-03-25 16:50:16', '2024-03-27 06:10:05'),
(213, 59, '2024-03-27 14:10:10', NULL, '2024-03-27 06:10:10', '2024-03-27 06:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `photo`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Gaymart Paraiso', 'javed@allphptricks.com', NULL, '$2y$12$hLm6F4arX4CkO.qlvtZXAO89Pdq5ZcfWrstmd4HS82KH0vRlQ6QFO', NULL, '2024-02-05 19:57:54', '2024-02-05 19:57:54'),
(2, NULL, 'Syed Ahsan Kamal', 'ahsan@allphptricks.com', NULL, '$2y$12$1HnNtjaZ9KxpR8Uw8uHd7.kwksy.BSABMdofCeKiUBhJpsNHGDLEO', NULL, '2024-02-05 19:57:54', '2024-02-05 19:57:54'),
(3, NULL, 'Abdul Muqeet', 'muqeet@allphptricks.com', NULL, '$2y$12$T1qI6cCVpH.uLbmcR81/tu4FthVCDR7yLQ.pWud9wFN0Qroh4wW5e', NULL, '2024-02-05 19:57:55', '2024-02-05 19:57:55'),
(4, NULL, 'sdasdsa', 'jave22d@allphptricks.com', NULL, '$2y$12$ESTYc9ncCtMeMM8yPmT23.zO8CHVJ6dc34ELgmGlEAuA33nmqENvu', NULL, '2024-03-15 03:15:12', '2024-03-15 03:15:12'),
(5, NULL, 'dawdwad', 'wdawdwad@yahoo.com', NULL, '$2y$12$tpnRM9e/CH0aCrkdcgxGBevhmRHU.pu4zaaGEwK4lT1Ky6u1xNNRK', NULL, '2024-03-15 03:16:56', '2024-03-15 03:16:56'),
(6, NULL, 'dawdawd', 'awdwd@yahoo.com', NULL, '$2y$12$9p9Xob/6dGvmXErQJSuWEu2BueTyZP4tf7w01E7/1zTPI/qrfwmu.', NULL, '2024-03-15 07:44:05', '2024-03-15 07:44:05'),
(7, NULL, 'dasdsa', 'dwadwa@yahoo.com', NULL, '$2y$12$DjorhL9agh2YzmaXkSzdmu09EtWbeJ15IiHUBI8l95Lrfwy8MxD7G', NULL, '2024-03-15 08:08:26', '2024-03-15 08:08:26'),
(8, NULL, '{{ __(\'Register\') }', 'dadwd@yahoo.com', NULL, '$2y$12$7HG4ukHYaXLz1TWbfKRZt.TWzz00MCG7suxTuhxNdHnaDrd1pac3G', NULL, '2024-03-15 11:15:55', '2024-03-15 11:15:55'),
(9, NULL, 'dsad', 'asdasd22@yahoo.com', NULL, '$2y$12$Fca5ZGHI9lDPycWoJP7WE.UmqdgzScp2lF1kg8ebR1de010uelBcG', NULL, '2024-03-15 11:27:07', '2024-03-15 11:27:07'),
(10, NULL, 'asdasd', 'asdasd@yahoo.com', NULL, '$2y$12$zK3aS3DvSHNjPiSQe6gWvumL5Brt9bO4Zu0GdM2xgSiyEM76p8Gly', NULL, '2024-03-15 12:19:03', '2024-03-15 12:19:03'),
(11, 'profile_photos/SkX3RwIiDNhj389Tgx9Dm11Fi0czl8ppfr1hH5iS.png', 'dsadasdsa', 'javed2@allphptricks.com', NULL, '$2y$12$J37xP7kMGFmWVSmKD9gIduXMRgPA73n6RouhWrnwFHnhaAb44z7Qe', NULL, '2024-03-15 12:20:28', '2024-03-15 12:20:28'),
(12, 'OvC0sbfJqfCadDOcZsRkIeMwjPpStk9NRCtrWk5a.png', 'dawddawdawddawdawddaw', 'javed12@allphptricks.com', NULL, '$2y$12$itIfML6nRtIrJxHWSAd4meqNRazlXzkfFn.kkAQursGwbNY5A19rq', NULL, '2024-03-15 12:35:11', '2024-03-15 12:35:11'),
(13, 'photo_1710507180.png', 'Nissi Cup Noodles', 'javed21@allphptricks.com', NULL, '$2y$12$IVZDD6rH.ZNaya8LJdV/DOlZnyAHdvrAwdPtotPdUJk.FEjtSO.1u', NULL, '2024-03-15 12:53:00', '2024-03-15 12:53:00'),
(14, 'photo_1710507526.png', 'Nissi Cup Noodles', 'javed1@allphptricks.com', NULL, '$2y$12$OGB1fVCiConY5y0yICDid.XhrssD1oN9ZNczt3AKYRKTrLU7yf7sK', NULL, '2024-03-15 12:58:46', '2024-03-15 12:58:46'),
(15, 'photo_1710507904.png', 'Snowbear', 'muqeet2@allphptricks.com', NULL, '$2y$12$vm.EopuNlD4Ntd0KDXbnb.FWV9mdwogSIARyh2gWVgnO.AVwwivue', NULL, '2024-03-15 13:05:04', '2024-03-15 13:05:04'),
(16, 'photo_1710509122.png', 'Snowbear', 'javed22@allphptricks.com', NULL, '$2y$12$lG0u1VnRbr1UJzpa95TV8uQBPqOSS74I2wgT1BIgUfs/0uw.WiQA2', NULL, '2024-03-15 13:25:22', '2024-03-15 13:25:22'),
(17, 'photo_1710509253.jpg', 'Nissi Cup Noodles', 'javed321@allphptricks.com', NULL, '$2y$12$tMNSQ50c8NLtV.beYNB2YuTVKW0TULmeCGKLmLBeCqWg.n2v3gYHi', NULL, '2024-03-15 13:27:05', '2024-03-15 13:27:05'),
(18, NULL, 'dsadasdasd', 'sdad@yahoo.com', NULL, '$2y$12$ShO/m3sGoOUXA2uM5B5p/esWzHaB2Lysmk9Tm1mdPxjS0F7W/WDlG', NULL, '2024-03-15 13:36:51', '2024-03-15 13:36:51'),
(19, NULL, 'Nissi Cup Noodleswqqdw', 'dqwdqw@yahoo.com', NULL, '$2y$12$PTbJdkObZdVth6RdyjGJeurZ/SWKTyPklKuGI0XrRQJ5.lQSixeMW', NULL, '2024-03-15 13:37:40', '2024-03-15 13:37:40'),
(20, 'profile_photos/A26SWHBuXKjqgdm7SqGvp2VJhfVepJof7aEnqr7A.png', 'wdadwd', 'javed222@allphptricks.com', NULL, '$2y$12$cSZOKzPnCtX6fE3cKCYRS.IomCkdtHYt5BoTIsmFMnFUOMJ/td1/i', NULL, '2024-03-15 13:50:43', '2024-03-15 13:50:43'),
(21, NULL, 'Nissi Cup Noodles', 'ahsan22@allphptricks.com', NULL, '$2y$12$NC8SgwrKHVU6AlPMM2S.M.GczyLwkIoVwdhAzQ3uXNjZUPhKgHEKS', NULL, '2024-03-15 13:51:46', '2024-03-15 13:51:46'),
(22, NULL, 'Snowbear', 'javed33@allphptricks.com', NULL, '$2y$12$4rLWcjXA1KAJmaBZ7kGqg.O1ql4XOWxSlputo6mNs9wr/WfNkVukW', NULL, '2024-03-15 14:00:14', '2024-03-15 14:00:14'),
(23, 'photo_1710511589.png', 'dwad', 'javed23332@allphptricks.com', NULL, '$2y$12$TfB5TSYChUZoNv5QwuEICelbrO6aYpwenoNw7iHF175BS1BjaGbdG', NULL, '2024-03-15 14:06:29', '2024-03-15 14:06:29'),
(24, 'photo_1710511724.png', 'dwadawd', 'javed222222@allphptricks.com', NULL, '$2y$12$Ttr8WvqJTVj1Ih0JYwOA.OL44m/Xkf46ChyFM2CNhP9T7LMkRuP.C', NULL, '2024-03-15 14:08:45', '2024-03-15 14:08:45'),
(25, 'photo_1710681027.jpg', 'Applicant Person3872232131', 'applicant@gmail.com', NULL, '$2y$12$pEois5RgHqf30fnqVPSKsOPe5Vixjvtr.wblrg3mJowueyjZSq3EG', NULL, '2024-03-17 13:10:28', '2024-03-24 10:39:15'),
(26, 'photo_1710773809.jpg', 'applicant person2', 'applicant2@gmail.com', NULL, '$2y$12$THA.lvI1l7BuYM6SUQvE.ueZ39D/tAhE3mDWsf2f70j62NTXj1/Fe', NULL, '2024-03-18 14:56:50', '2024-03-18 14:56:50'),
(27, 'photo_1710832188.png', '12312312', 'javed333@allphptricks.com', NULL, '$2y$12$zUiWlV3ElyEBwAWORGumAuf4rNjv1Pq88JjbcjYrq6f61I7ajuiji', NULL, '2024-03-19 07:09:49', '2024-03-24 10:44:57');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `official_receipt_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificate_of_registration_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deed_of_sale_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorization_letter_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plate_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_make` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `front_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `side_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year_model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'None / Approved',
  `registration_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `vehicle_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `user_id`, `owner_id`, `driver_id`, `official_receipt_image`, `certificate_of_registration_image`, `deed_of_sale_image`, `authorization_letter_image`, `owner_address`, `plate_number`, `vehicle_make`, `front_photo`, `side_photo`, `year_model`, `color`, `body_type`, `approval_status`, `reason`, `registration_status`, `vehicle_code`, `qr_image`, `created_at`, `updated_at`) VALUES
(11, NULL, 0, 1, 'cf90a106-83cb-4e42-a645-e09b81f719c8.jpg', '0fda3945-2cf2-4125-a4aa-5564b015613f.jpg', '0172418c-e9fe-4a1e-9483-c8aee1f9a64b.jpg', 'c67b3931-5508-460c-b2b6-ffd173a2c571.jpg', 'Purok 1, Luinab, Iligan City', 'S7 K386', 'Toyota Hilux Conquest', '30b11d43-a11d-4613-99e2-df64ba2d9e38.jpg', 'd7973bca-b61e-4116-9943-354ccb26fa44.jpg', '2022', 'Black', 'Pick-Up', 'Rejected', 'dwdw', 'Other', '2037140575', NULL, '2024-02-18 08:22:54', '2024-02-19 12:24:39'),
(12, 1, 0, 19, '0fe5829e-60dc-49e0-8f83-bb0312a1a87c.jpg', '911e5f10-cdc9-4330-8de4-c17c53dc6c09.jpg', '331a7520-7bc1-4dca-b767-55e251d12541.jpg', '6e085818-df97-4ecf-8ca8-86cbe7062578.jpg', 'Purok 1, Luinab, Iligan City', 'ewawdaw', 'awdawd', '0f4d361e-3222-437d-92cf-e6e3f3da1622.jpg', '3bab6e51-b7fc-47a8-aa19-709476d92c94.jpg', '2022', 'dwda', 'wadwd', 'Rejected', 'dd', 'Inactive', '2037140574', NULL, '2024-02-19 12:10:20', '2024-02-19 12:22:36'),
(13, 1, 0, 5, '1f78b55b-3f61-4946-9ecb-648e0dc09416.jpg', 'c7db26ef-8cc0-4e05-ba8b-4a6a3cfa9f8b.jpg', '198aa276-69de-4b58-9d8f-97394dcfb4a9.jpg', '1ba8f517-d6f4-439b-8cd0-35a1d8d7e705.jpg', 'd', 'd', 'd', 'fb6b3f4e-3b4a-4f28-9ced-e87b5baa69fd.jpg', 'b9e529e9-3af5-46b6-9b3d-18ceedd6cf8b.jpg', 'd', 'd', 'd', 'Approved', 'None / Approved', 'Other', '2037140573', NULL, '2024-02-23 08:04:59', '2024-02-23 08:04:59'),
(14, 1, 0, 18, '62f53443-6f5c-4b94-8f6c-972cfd327dab.png', '59934403-936b-44a7-8805-e6fbcb9dfd3b.png', '54d32d40-3929-423c-8f76-e148a4598edc.png', 'a0724767-8c8a-4628-b208-2139229716b8.png', 'dwad', 'wdawd', 'aawda', '69773e2a-89a4-433a-b7b4-7fbcd699d0d5.png', '3eee8d8f-a12f-4c49-9087-abdc87e8458e.png', 'dawdawd', 'wadawd', 'awdwadwad', 'Approved', 'None / Approved', 'Active', '2037140572', NULL, '2024-02-23 13:20:14', '2024-02-23 13:20:14'),
(15, 1, 0, 13, '224982de-98ba-4cd4-bc2b-b1bc88f0b140.png', '9a009fae-76db-42fa-ad7e-e5a1b6c1bd0c.png', 'd4bf5b3a-78ea-4167-a7da-4744c36226f4.png', 'a36f7861-d6dc-4cf3-93df-26e3c709277d.png', '1', 'awddwa', 'awdawd', '7b0a0ac8-ca04-49ee-99ca-f321ad7c18d8.png', '411fdc5b-94b4-4d58-bd46-28778eb39c8d.png', 'awdwad', 'dwadawd', 'awdawdd', 'Approved', 'None / Approved', 'Active', '2037140571', NULL, '2024-02-23 13:36:40', '2024-02-23 13:36:40'),
(16, 1, 0, 2, 'd68dca8b-3933-45a9-a7ff-bfa706ad3e83.png', '3c703036-9f0e-41e2-91ab-7ac582b6f46b.png', 'd25f6e4b-f4e4-4b67-9b0f-0a6602bf05f4.png', '78c0a3f6-a595-44aa-84b3-a256b41d1e2d.png', 'dawdawda', 'awdwadawd', 'awdawdaw', '37df43ee-389a-4350-9cf9-6e36c5818ff8.png', 'f28c2356-74b6-4f04-8e47-c7d3b37391e4.png', 'dwawdwad', 'awdawdawd', 'dawdawd', 'Approved', 'None / Approved', 'Inactive', '2037140570', NULL, '2024-02-23 15:27:54', '2024-02-23 15:27:54'),
(17, 1, 0, 19, '915d6122-b373-43fa-bb35-cca64ad59fc3.png', '225dc258-4a74-47e2-941f-641941077d06.png', 'e8caa13a-c4ca-49c4-9024-6ef458bb0278.png', '11478242-5416-415f-a4ef-64e76b98d535.png', '1', '1', '1', 'a011546a-36b8-411a-be6e-8d59cf0e736a.png', 'a338f2a5-bb04-4132-bba8-4cf885ac84a8.png', '1', '1', '1', 'Approved', NULL, 'Other', '2037140569', NULL, '2024-02-23 15:35:26', '2024-02-23 15:35:26'),
(18, 1, 0, 1, '59b72776-a73b-4fde-9d22-cb53570f88bd.png', '82769852-6034-4ea6-af62-4bd6d9d7216e.png', '2686c9b7-0bc2-44d7-9924-6f01df82e827.png', 'f82c53f0-c87e-4197-a145-085931782314.png', '1', '1', '1', '4d9cf1f9-e0cb-4d09-a60b-6883ad2c29ef.png', '86014729-00eb-4295-9902-54d3a783a72a.png', '1', '1', '1', 'Approved', 'None / Approved', 'Other', '2037140568', NULL, '2024-02-23 15:42:12', '2024-02-23 15:42:12'),
(19, 1, 0, 19, '4a27ff94-2cdc-4027-b503-77ee13be1ae9.jpg', 'b3306706-39a2-432c-b0a7-5a60814c922f.jpg', '5fd5e8e2-8a0a-4faf-a783-0383b812a3b1.jpg', 'fcb91bc8-3608-407f-8966-1b34256e973b.jpg', '2', '2', '2', '12f01422-8e2d-4b9b-b8b4-8dc291893fe5.jpg', '31c88c4c-ae69-4acf-8e50-adf1998d2cc4.jpg', '2', '2', '2', 'Approved', 'None / Approved', 'Inactive', '2037140567', NULL, '2024-02-27 05:07:52', '2024-02-27 05:07:52'),
(20, 1, 0, 22, '0743c073-81b0-4047-b03d-bc1700bf852b.jpg', '321491fe-e663-47c7-a3a3-66deb5214094.jpg', 'a84f31e0-3aee-4d89-b52a-b94f7ebe110e.jpg', '9a80821b-e19e-41c8-a9a9-242c69385fbe.jpg', '3', '3', '3', '668c4838-24de-4356-bf7e-db1f27606083.jpg', 'cb1f2be0-f774-4f9a-9075-f2802d36f0f3.jpg', '3', '3', '3', 'Approved', 'None / Approved', 'Other', '2037140566', NULL, '2024-02-27 05:24:30', '2024-02-27 05:24:30'),
(21, 1, 0, 23, '5287cdc7-80df-407e-949d-40ca7c1fe865.jpg', '42b2b13f-1749-4dc4-8a04-4ee98dc74f47.jpg', '52c8b576-6379-4e47-b1fd-21556520c719.jpg', 'b4b4c4b6-3512-487f-9662-48d340ca5a53.jpg', '4', '4', '4', '83c8406f-e61e-41d9-bd63-2794c66b816a.jpg', 'a6c9401e-6ac0-404c-8d8b-9d1568feba0f.jpg', '4', '4', '4', 'Approved', 'None / Approved', 'Other', '2037140565', NULL, '2024-02-27 05:27:16', '2024-02-27 05:27:16'),
(22, 1, 0, NULL, 'eb7b7faf-3e1b-4536-96d6-505f2fa83257.jpg', '89413427-3f89-49ec-b6b5-619c03e4553a.jpg', 'e04de917-831f-4b1b-97de-a8d1119a8d9b.jpg', 'd8e4019b-404a-4a02-a138-57d18c3e69ac.jpg', '5', '5', '5', '9fbcdf77-52ca-4fce-b7a5-b0cb38238404.jpg', '92b20063-dd86-459b-a9d6-80cab77abb4f.jpg', '5', '5', '5', 'Approved', NULL, 'Other', '2037140564', NULL, '2024-02-27 06:37:05', '2024-02-27 06:37:05'),
(23, 1, 0, NULL, '25930258-68af-4af7-9252-d50f89a255db.jpg', '63521666-d2fd-431f-a04d-0b04445f218b.jpg', 'ecab7bc3-7418-47eb-846e-581f9ddd658e.jpg', 'dc0b7f79-5cf6-45e8-b460-ad33b6bc5cf4.jpg', '5', '5', '5', '9cde2b9f-9d4e-4d24-8106-d8c4b1ab40ff.jpg', '78755405-8571-4416-b66f-4696d4fe03e7.jpg', '5', '5', '5', 'Approved', NULL, 'Other', '2037140563', NULL, '2024-02-27 06:37:35', '2024-02-27 06:37:35'),
(24, 1, 0, 1, '5ec62d5b-3da7-4b43-8d42-0c89c2e95d6c.jpg', '62bfcced-bbd1-43d0-a6d1-183fb586d743.jpg', 'b8a85e0f-1093-42ba-9f11-30184667c8fc.jpg', 'f83b43a4-4ceb-496f-8cf1-2a6b30d49fc7.jpg', '5', 'ABC 5421', '5', '3591b37d-12c1-4730-b065-2110c660b565.jpg', '5f746ae8-c287-46b2-9f03-e3f3cf1e4b3b.jpg', '5', '5', '5', 'Approved', 'None / Approved', 'Other', '2037140562', NULL, '2024-02-27 06:39:21', '2024-03-07 16:26:12'),
(26, 1, 110, 25, 'ae77ceaa-089c-4eb6-ae51-d7ec866a2300.jpg', '17254302-ee9b-4e95-a14c-5c2a65648eda.jpg', '3ababe38-8986-4dc8-8801-ed392d02067f.jpg', '6d3f964f-dbe6-481d-b46c-12bd96925803.jpg', '6', '6', '6', 'ff68528b-6fcf-4d3a-8c83-95f4ccc0d346.jpg', '349a8400-4a50-4243-9154-e29e670aa709.jpg', '6', '6', '6', 'Approved', 'None / Approved', 'Inactive', '2037140551', NULL, '2024-02-27 06:42:56', '2024-02-27 06:42:56'),
(29, 1, 0, 28, '694ada94-1a55-4980-8e01-34d107acb18f.jpg', '51c0b9f4-7c8c-4154-bbcc-ec9f50f20f3e.jpg', '70e45f3c-ced2-4d44-9c43-01ff0da2045a.jpg', '8c4ca88e-df14-47b0-bc4e-09ea9f792c00.jpg', 'California', 'KAP 1990', 'Toyota Hilux Conquest', '1709223690_front_photo.jpg', '43f85a86-b6f6-4fc5-b4d0-11595c683975.jpg', '2024', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Inactive', '2037140557', NULL, '2024-02-27 07:01:53', '2024-03-06 09:45:13'),
(30, 1, 0, 19, 'd239751d-07f5-45c3-978d-e1a20a3434f6.jpg', 'c31acd86-3137-4ec6-9235-a84902a55a0e.jpg', 'f092de44-025a-4222-af48-29a47745e20b.jpg', '7eab447e-fa38-4db8-944c-ac5690c2b34d.jpg', '1', '1', '1', '8faf9ddf-39cb-42ed-b3f7-f172145bfa1b.jpg', 'a2eb1ceb-c921-48f4-bedc-cb9be532a7ca.jpg', '1', '1', '1', 'Approved', 'None / Approved', 'Active', '2037140556', 'public/images/qrcodes/1_2037140556.png', '2024-03-04 05:58:22', '2024-03-07 16:33:26'),
(31, 1, 110, 28, 'd127dad1-288e-4c4e-9e87-ae67601d5ae5.jpg', '13407fdd-e614-456c-8fb0-2e324fc6d1ce.jpg', '85c7488c-9156-4cde-b579-309b8def5a7e.jpg', 'e0ab6a62-ceb0-4ae6-81d0-9aaaeaa1c4cb.jpg', 'Driver\'s License', 'ORD - 700', 'c', 'd4991893-45ab-46ff-afb1-e9d5ec44e2fc.jpg', '614b287f-ccac-4613-beff-fc71af929718.jpg', 'c', 'c', 'c', 'Approved', 'None / Approved', 'Active', '2037140555', 'public/images/qrcodes/ORD - 699_2037140555.png', '2024-03-04 06:01:16', '2024-03-08 13:34:08'),
(38, 1, 110, 107, '789d99c1-f28c-4271-bd80-21d63e2a6174.png', '18fa5700-8bb2-41a6-a3b0-43957540a9f8.png', '2ec0c630-f933-4868-a121-642fa506c49f.png', '0e36416c-0b41-48e5-a556-1eb0dbdcaf5f.png', 'Abigail, Iligan City', 'CRO 696', 'Toyota Wigo', '6ea5fdb6-35e5-4407-969e-766b79925193.png', '02807a8d-afad-4e47-a155-7a4bf9fde6b7.png', '2022', 'Black', 'Hatchback', 'Approved', 'None / Approved', 'Inactive', '4780247106', NULL, '2024-03-09 16:50:26', '2024-03-09 16:50:26'),
(39, 1, 110, 110, 'c0d950cb-5776-4e79-a580-6c42cfc6a2ac.png', 'defcef27-76f6-4254-be77-fe0d64fd4a31.png', 'b6486932-0777-40e5-84f5-b44e173675e8.png', '38b405d9-e265-4e7e-b2c1-af6b900fdf48.png', 'Steeltown', 'DEF 631', 'Toyota Hilux Conquest', '21423989-ce8f-4919-850d-680599357864.png', 'a7a39639-7ff4-48c8-9a0a-1b651fa5d7e3.png', '2023', 'Gray', 'Pick Up', 'Approved', 'None / Approved', 'Active', '5327037207', NULL, '2024-03-11 10:12:18', '2024-03-14 08:49:12'),
(40, 1, 0, 110, '3e4b6cbb-3786-4bec-ab61-428ac0c5c2f1.png', '25ac8c23-9197-4fe6-b971-473270e89fb0.png', '247403a0-b823-494c-8800-81d2b0784f22.png', 'd4c29053-1b9a-41f1-bb41-30024964b4b1.png', 'Abigail, Iligan City', 'BAC 312', 'Toyota Hilux Conquest', 'be4f8b08-c162-4ebe-886a-539f9042df93.png', 'a95306ac-1717-4d3b-8f80-452998c40796.png', '2023', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Inactive', '4426899660', NULL, '2024-03-11 13:28:57', '2024-03-11 13:28:57'),
(41, 1, 110, 111, '696f25e0-c625-4d40-8586-d40d4eccae51.png', '5656fed0-2679-47d9-bdab-e6ddad8d746a.png', 'adacc50c-7743-4cda-b378-39e8c96cf76e.png', '597e87d4-b5cf-428b-a4db-8d3aa7d98b0a.png', 'Purok 1, Luinab, Iligan City', 'CAB 314', 'Toyota Hilux Conquest', '03085b08-800c-4b83-89c3-20eb181fb0d0.jfif', '9693c68d-87d6-4bd8-b06f-9ebd1a04f774.jpg', '2022', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Active', '8141694317', NULL, '2024-03-11 16:18:38', '2024-03-11 16:18:38'),
(42, 1, 0, 111, '9bc188b8-ac11-4108-8536-810155d0ce6d.png', '8dc23e52-95e6-4079-9b17-05e2b3e382c4.png', '5d85fd70-f990-4421-9da8-25d73d2394f4.png', 'd78c69fa-442d-42e7-8cc4-41facf23c811.png', 'Purok 1, Luinab, Iligan City', 'BAC 412', 'Toyota Hilux Conquest', '6ff5fbd0-a64f-4be6-a8f1-2a7a6f9e7a3e.jfif', 'afd7156e-b6e9-4552-95d6-5486e2e10802.jpg', '2022', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Active', '9131206782', NULL, '2024-03-11 16:22:16', '2024-03-11 16:22:16'),
(43, 1, 111, 112, '762f13aa-e80c-4b37-b170-dcf2e3fce4e7.jpg', 'c9b4ca66-9cf6-44e9-a025-c24a29df2d6a.png', '908c6bf6-b753-423d-9f63-3578704b7880.png', '6b94392d-a4e1-42d3-bedc-4fea28e09d19.png', 'Purok 1, Luinab, Iligan City', 'KYJ 512', 'Toyota Hilux Conquest', '7941aaa4-008e-4633-890f-0759c386d8a2.jpg', '74e0d8af-f390-4ff0-9680-f60c672bce12.jfif', '2023', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Active', '2885179877', NULL, '2024-03-12 07:29:38', '2024-03-12 07:29:38'),
(44, 1, 112, 113, '1710320022_official_receipt_image.png', '2ffe370e-a315-4db8-92a9-a0aa1e21f0c4.jpg', '078d9054-129b-45f6-908a-3012429abee4.jpg', 'c69f8461-90fc-4c46-95d3-e9a88ca0bc51.jpg', 'Luinab, Bahayan', 'BIO 729', 'Toyota Hilux Conquest', '2aa04056-98c8-4628-9822-03d1301a4352.png', '11da0934-1a57-44ca-b3bf-eddb0016cb66.png', '2022', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Inactive', '4201807688', NULL, '2024-03-12 09:04:22', '2024-03-13 08:53:42'),
(45, 1, 112, 113, 'b2445bbc-7427-42a4-a262-bdf8faf8580b.png', '3c911ddb-4ccc-46a0-aa92-fa9716ad33ee.png', '12228866-953f-4f48-8f50-3ca057970b20.png', '9cdbf04f-4094-49b5-b089-9a4dd7ab59c3.png', 'Purok 1, Luinab, Iligan City', 'KAP 1969', 'Toyota Hilux Conquest', '212d44e1-866e-4b3d-98c5-74f481b1bd31.png', '3daf4fbe-2418-42c6-baff-bd02950a7601.png', '2023', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Active', '2868664024', NULL, '2024-03-12 10:35:31', '2024-03-14 15:45:08'),
(46, 1, 112, 113, '87b80bd7-938d-4341-b3d0-371f9846067d.png', '72959672-9839-4d88-b70f-76df51c073d7.png', '166750c4-6b2d-4a02-948a-dc0f3dc1a845.png', '5cb090d1-0a66-47e5-9e19-c2904a8634da.png', 'Purok 1, Luinab, Iligan City', 'KAP 1920', 'Toyota Hilux Conquest', 'd93d22df-32fa-405c-8d40-0d66b3d67619.png', '356b7ae1-715f-42cc-89cf-f64797a6a0f9.png', '2022', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Inactive', '6514301722', NULL, '2024-03-12 12:29:33', '2024-03-12 12:32:20'),
(47, 1, 112, 113, 'b9d6c286-15d7-4a75-ac50-45741e2081ae.png', 'bb141a07-d667-4137-a5eb-ec2fc7e8dffa.png', '18bd84c1-b8ec-481e-9ad8-e569e0f82aa5.png', '0172425d-9c45-4b6a-9abe-23588bac6eda.png', 'Purok 1, Luinab, Iligan City', 'KAP 6922', 'Toyota Hilux Conquest', 'fa536621-5824-47c3-9e3e-2f6a2ff627a4.png', '1710407006_side_photo.png', '2023', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Inactive', '5278813924', NULL, '2024-03-12 12:33:01', '2024-03-14 13:37:00'),
(52, 25, 114, 115, '1710779608_official_receipt_image.jpg', 'fa67b8a6-b0d3-4c79-856c-90a222e179da.png', 'a69fef21-490d-4848-b6a9-f095dda3d133.png', '26fdfa13-d838-4286-9ecc-b51e3df57db6.png', 'qwerty', 'test3', 'test3', '400a87d2-5ede-44c2-8e58-9f0e2e5dd9dd.png', '9079cc23-fdee-4b04-8c5c-ec97f17c520e.png', 'test2', 'test2', 'test2', 'Approved', 'None / Approved', 'Inactive', '4206560022', NULL, '2024-03-18 05:47:38', '2024-03-20 17:58:28'),
(55, 26, 117, 118, '292cde60-f82b-4229-89b6-f24ccc7fa7d1.png', '4485e38f-8f93-4451-882d-63c8eb66a6dc.png', 'd58f1edd-d304-4f9d-bcff-b2c9849fd4b9.png', 'bd50acd6-a854-4339-9b3b-9f623c00a3e6.jpg', 'Purok 1, Luinab, Iligan City', 'dads', 'sad', '4184cf99-4005-429a-b410-f407be04247f.jpg', '30f8bb53-686e-4dda-84ba-1841e1c39723.png', 'asd', 'ads', 'asd', 'Pending', 'For Verification', 'Active', '5039977541', NULL, '2024-03-18 15:10:58', '2024-03-18 15:10:58'),
(56, 25, 114, 115, '54406535-5682-46df-875b-162705f62b8c.jpg', 'f3f262f3-85ab-4c4c-9991-90244ccf725e.jpg', '89ef16b9-f032-44eb-b7f6-df8401c6c7c3.jpg', '17690130-0e5b-4be2-9009-e2d19a58c084.jpg', 'test', 'test', 'test', '38b9790c-6764-403a-80d6-8cf8bcf72f68.jpg', '560f925f-1e1a-45b5-a421-532f194b8bfe.jpg', 'test', 'test', 'test', 'Pending', 'For Verification', 'Inactive', '5177137057', NULL, '2024-03-20 18:14:47', '2024-03-20 18:16:23'),
(57, 25, 114, 115, 'e872d97e-30a6-46ed-9b02-00cb91ded5d4.jpg', '29d9ed1a-717e-4e5d-ae52-ca6ff897bd95.jpg', '2d8d666d-e499-4f79-84e3-db5facb7a829.jpg', 'bcb8aae7-e067-4d66-ac30-50cb8afbd649.jpg', 'test', 'test', 'test', 'e46dabd9-930e-46e8-a754-1dad392cc5ac.jpg', '5d42822d-22c6-4063-9832-1b927fdf06fd.jpg', 'test', 'test', 'test', 'Pending', 'For Verification', 'Inactive', '9248411210', NULL, '2024-03-20 18:17:31', '2024-03-20 18:26:54'),
(58, 25, 114, 115, 'a8b02f4d-9142-4c70-af3d-75d6565dd32b.jpg', '2eb876ad-c733-4acb-8b47-d6e860ece39c.jpg', 'bb58b067-cbbb-4a33-95df-30050d632c73.jpg', '1e56d23e-7ad3-4146-9522-1a432a89a717.jpg', 'test', 'test', 'test', 'b1949887-bbb3-45a7-8cfb-1266209dc453.jpg', 'a81db06a-901d-4858-bf31-be57f3d1fc5b.jpg', 'test', 'test', 'test', 'Pending', 'For Approval', 'Inactive', '5449185463', NULL, '2024-03-20 18:27:37', '2024-03-20 18:31:30'),
(59, 25, 114, 115, 'deb1ae7b-fc17-4d59-8c52-ca9baa051b8f.jpg', '8abf8667-16f5-449f-b77b-4e145187a216.jpg', '86e0fe59-53ea-4896-95e6-3897641a6ef4.jpg', '3f4500d4-4f32-4efe-af4b-4a03feed2cf0.jpg', 'Abigail, Iligan City', 'S7 K386', 'Ford Everest', '34bb7af9-59c8-4ac4-8f38-22a6f0a502fd.jpg', '16755661-3ccd-4a49-bcf9-9c51aab4a0ce.jpg', '2022', 'Black', 'SUV', 'Approved', 'None / Approved', 'Active', '7844128634', NULL, '2024-03-20 18:32:11', '2024-03-22 06:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles_record`
--

CREATE TABLE `vehicles_record` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `official_receipt_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificate_of_registration_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deed_of_sale_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorization_letter_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plate_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_make` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `front_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `side_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year_model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'None / Approved',
  `registration_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `vehicle_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_record`
--

CREATE TABLE `vehicle_record` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `appointment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_record`
--

INSERT INTO `vehicle_record` (`id`, `vehicle_id`, `owner_id`, `status_id`, `user_id`, `appointment_id`, `driver_id`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 29, NULL, NULL, 1, NULL, NULL, 'Vehicle 29 Timed in at 2024-03-06 23:00:14', '2024-03-06 15:00:14', '2024-03-06 15:00:14'),
(2, 29, NULL, NULL, 1, NULL, NULL, 'Vehicle KAP 1990 Timed in at 2024-03-06 23:02:19', '2024-03-06 15:02:19', '2024-03-06 15:02:19'),
(3, 29, NULL, NULL, 1, NULL, NULL, 'KAP 1990 Timed in at 2024-03-06 23:03:21', '2024-03-06 15:03:21', '2024-03-06 15:03:21'),
(4, 29, NULL, NULL, 1, NULL, NULL, 'KAP 1990 Timed out at 2024-03-06 23:07:24', '2024-03-06 15:07:24', '2024-03-06 15:07:24'),
(5, 29, NULL, NULL, 1, NULL, NULL, 'KAP 1990 Timed in at 2024-03-06 23:07:42', '2024-03-06 15:07:42', '2024-03-06 15:07:42'),
(6, 29, NULL, NULL, 1, NULL, NULL, 'KAP 1990 Timed out at 2024-03-06 23:08:33', '2024-03-06 15:08:33', '2024-03-06 15:08:33'),
(7, 29, NULL, NULL, 1, NULL, NULL, 'KAP 1990 Timed in at 2024-03-06 23:08:39', '2024-03-06 15:08:39', '2024-03-06 15:08:39'),
(8, 29, NULL, NULL, 1, NULL, NULL, 'KAP 1990 Timed out at 2024-03-06 23:09:59', '2024-03-06 15:09:59', '2024-03-06 15:09:59'),
(9, 29, NULL, NULL, 1, NULL, NULL, 'KAP 1990 Timed in at 2024-03-06 23:10:03', '2024-03-06 15:10:03', '2024-03-06 15:10:03'),
(10, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:17:24', '2024-03-06 15:17:24', '2024-03-06 15:17:24'),
(11, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:17:37', '2024-03-06 15:17:37', '2024-03-06 15:17:37'),
(12, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:19:46', '2024-03-06 15:19:46', '2024-03-06 15:19:46'),
(13, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:19:58', '2024-03-06 15:19:58', '2024-03-06 15:19:58'),
(14, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:20:05', '2024-03-06 15:20:05', '2024-03-06 15:20:05'),
(15, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:20:07', '2024-03-06 15:20:07', '2024-03-06 15:20:07'),
(16, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:24:21', '2024-03-06 15:24:21', '2024-03-06 15:24:21'),
(17, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:24:25', '2024-03-06 15:24:25', '2024-03-06 15:24:25'),
(18, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:36:31', '2024-03-06 15:36:31', '2024-03-06 15:36:31'),
(19, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:41:10', '2024-03-06 15:41:10', '2024-03-06 15:41:10'),
(20, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:43:03', '2024-03-06 15:43:03', '2024-03-06 15:43:03'),
(21, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:49:57', '2024-03-06 15:49:57', '2024-03-06 15:49:57'),
(22, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:53:16', '2024-03-06 15:53:16', '2024-03-06 15:53:16'),
(23, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:59:26', '2024-03-06 15:59:26', '2024-03-06 15:59:26'),
(24, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:59:39', '2024-03-06 15:59:39', '2024-03-06 15:59:39'),
(25, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-07 00:04:09', '2024-03-06 16:04:09', '2024-03-06 16:04:09'),
(26, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-07 00:04:14', '2024-03-06 16:04:14', '2024-03-06 16:04:14'),
(27, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed in at March 7, 2024 at 12:08 AM', '2024-03-06 16:08:00', '2024-03-06 16:08:00'),
(28, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed out at March 7, 2024 at 12:08 AM', '2024-03-06 16:08:08', '2024-03-06 16:08:08'),
(29, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed in at March 7, 2024 at 12:08 AM', '2024-03-06 16:08:34', '2024-03-06 16:08:34'),
(30, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed out at March 7, 2024 at 12:08 AM', '2024-03-06 16:08:35', '2024-03-06 16:08:35'),
(31, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed in at March 7, 2024 at 12:08 AM', '2024-03-06 16:08:36', '2024-03-06 16:08:36'),
(32, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:17 AM', '2024-03-06 16:17:39', '2024-03-06 16:17:39'),
(33, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:17 AM', '2024-03-06 16:17:41', '2024-03-06 16:17:41'),
(34, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:17 AM', '2024-03-06 16:17:45', '2024-03-06 16:17:45'),
(35, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:17 AM', '2024-03-06 16:17:47', '2024-03-06 16:17:47'),
(36, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:07', '2024-03-06 16:18:07'),
(37, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:09', '2024-03-06 16:18:09'),
(38, 13, NULL, NULL, 1, NULL, NULL, 'd Timed In at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:33', '2024-03-06 16:18:33'),
(39, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:37', '2024-03-06 16:18:37'),
(40, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:41', '2024-03-06 16:18:41'),
(41, 13, NULL, NULL, 1, NULL, NULL, 'd Timed Out at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:45', '2024-03-06 16:18:45'),
(42, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:50', '2024-03-06 16:18:50'),
(43, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:19 AM', '2024-03-06 16:19:00', '2024-03-06 16:19:00'),
(44, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:21 AM', '2024-03-06 16:21:03', '2024-03-06 16:21:03'),
(45, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:21 AM', '2024-03-06 16:21:13', '2024-03-06 16:21:13'),
(46, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:21 AM', '2024-03-06 16:21:25', '2024-03-06 16:21:25'),
(47, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:21 AM', '2024-03-06 16:21:36', '2024-03-06 16:21:36'),
(48, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:25 AM', '2024-03-06 16:25:01', '2024-03-06 16:25:01'),
(49, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:25 AM', '2024-03-06 16:25:05', '2024-03-06 16:25:05'),
(50, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:25 AM', '2024-03-06 16:25:16', '2024-03-06 16:25:16'),
(51, 30, NULL, NULL, 1, NULL, NULL, '1 Timed In at March 7, 2024 at 12:32 AM', '2024-03-06 16:32:18', '2024-03-06 16:32:18'),
(52, 30, NULL, NULL, 1, NULL, NULL, '1 Timed Out at March 7, 2024 at 12:32 AM', '2024-03-06 16:32:23', '2024-03-06 16:32:23'),
(53, 30, NULL, NULL, 1, NULL, NULL, '1 Timed In at March 7, 2024 at 12:32 AM', '2024-03-06 16:32:26', '2024-03-06 16:32:26'),
(54, 30, NULL, NULL, 1, NULL, NULL, '1 Timed Out at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:07', '2024-03-06 16:33:07'),
(55, 30, NULL, NULL, 1, NULL, NULL, '1 Timed In at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:34', '2024-03-06 16:33:34'),
(56, 30, NULL, NULL, 1, NULL, NULL, '1 Timed Out at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:42', '2024-03-06 16:33:42'),
(57, 30, NULL, NULL, 1, NULL, NULL, '1 Timed In at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:46', '2024-03-06 16:33:46'),
(58, 30, NULL, NULL, 1, NULL, NULL, '1 Timed Out at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:48', '2024-03-06 16:33:48'),
(59, 30, NULL, NULL, 1, NULL, NULL, '1 Timed In at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:51', '2024-03-06 16:33:51'),
(60, 30, NULL, NULL, 1, NULL, NULL, '1 Timed Out at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:55', '2024-03-06 16:33:55'),
(61, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 01:17 PM', '2024-03-07 05:17:52', '2024-03-07 05:17:52'),
(62, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 01:17 PM', '2024-03-07 05:17:55', '2024-03-07 05:17:55'),
(63, 31, NULL, NULL, 1, NULL, NULL, 'ORD - 696 Timed In at March 7, 2024 at 01:18 PM', '2024-03-07 05:18:36', '2024-03-07 05:18:36'),
(64, 31, NULL, NULL, 1, NULL, NULL, 'ORD - 696 Timed Out at March 7, 2024 at 01:18 PM', '2024-03-07 05:18:49', '2024-03-07 05:18:49'),
(65, 31, NULL, NULL, 1, NULL, NULL, 'ORD - 696 Timed In at March 7, 2024 at 03:52 PM', '2024-03-07 07:52:02', '2024-03-07 07:52:02'),
(66, 31, 110, NULL, 1, NULL, NULL, 'ORD - 696 Timed Out at March 7, 2024 at 03:52 PM', '2024-03-07 07:52:10', '2024-03-07 07:52:10'),
(67, 11, 110, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 03:52 PM', '2024-03-07 07:52:16', '2024-03-07 07:52:16'),
(68, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 03:59 PM', '2024-03-07 07:59:42', '2024-03-07 07:59:42'),
(69, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 03:59 PM', '2024-03-07 07:59:45', '2024-03-07 07:59:45'),
(70, 11, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 04:00 PM', '2024-03-07 08:00:00', '2024-03-07 08:00:00'),
(71, 31, 110, NULL, 1, NULL, NULL, 'ORD - 696 Timed In at March 7, 2024 at 10:39 PM', '2024-03-07 14:39:49', '2024-03-07 14:39:49'),
(72, 13, NULL, NULL, 1, NULL, NULL, 'd Timed In at March 7, 2024 at 10:39 PM', '2024-03-07 14:39:54', '2024-03-07 14:39:54'),
(73, 13, NULL, NULL, 1, NULL, NULL, 'd Timed Out at March 7, 2024 at 10:39 PM', '2024-03-07 14:39:57', '2024-03-07 14:39:57'),
(74, 30, NULL, NULL, 1, NULL, NULL, '1 Timed In at March 7, 2024 at 10:52 PM', '2024-03-07 14:52:58', '2024-03-07 14:52:58'),
(75, 30, NULL, NULL, 1, NULL, NULL, '1 Timed Out at March 7, 2024 at 10:53 PM', '2024-03-07 14:53:01', '2024-03-07 14:53:01'),
(76, 29, NULL, NULL, 1, NULL, NULL, 'KAP 1990 Timed Out at March 7, 2024 at 10:53 PM', '2024-03-07 14:53:06', '2024-03-07 14:53:06'),
(77, 26, NULL, NULL, 1, NULL, NULL, '6 Timed In at March 7, 2024 at 10:53 PM', '2024-03-07 14:53:12', '2024-03-07 14:53:12'),
(78, 26, NULL, NULL, 1, NULL, NULL, '6 Timed Out at March 7, 2024 at 10:53 PM', '2024-03-07 14:53:15', '2024-03-07 14:53:15'),
(79, 26, NULL, NULL, 1, NULL, NULL, '6 Timed In at March 7, 2024 at 10:53 PM', '2024-03-07 14:53:18', '2024-03-07 14:53:18'),
(80, 31, 110, NULL, 1, NULL, NULL, 'ORD - 700 Timed Out at March 9, 2024 at 03:20 PM', '2024-03-09 07:20:42', '2024-03-09 07:20:42'),
(81, 26, NULL, NULL, 1, NULL, NULL, '6 Timed Out at March 9, 2024 at 03:20 PM', '2024-03-09 07:20:57', '2024-03-09 07:20:57'),
(82, 31, 110, NULL, 1, NULL, NULL, 'ORD - 700 Timed In at March 9, 2024 at 03:21 PM', '2024-03-09 07:21:20', '2024-03-09 07:21:20'),
(88, 43, NULL, NULL, 1, NULL, NULL, 'KYJ 512 Timed In at March 12, 2024 at 03:58 PM', '2024-03-12 07:58:37', '2024-03-12 07:58:37'),
(89, 43, NULL, NULL, 1, NULL, NULL, 'KYJ 512 Timed Out at March 12, 2024 at 04:39 PM', '2024-03-12 08:39:00', '2024-03-12 08:39:00'),
(90, 43, NULL, NULL, 1, NULL, NULL, 'KYJ 512 Timed In at March 12, 2024 at 04:39 PM', '2024-03-12 08:39:15', '2024-03-12 08:39:15'),
(91, 45, NULL, NULL, 1, NULL, NULL, 'KAP 1991 Timed In at March 12, 2024 at 08:58 PM', '2024-03-12 12:58:39', '2024-03-12 12:58:39'),
(92, 45, NULL, NULL, 1, NULL, NULL, 'KAP 1991 Timed Out at March 12, 2024 at 08:58 PM', '2024-03-12 12:58:41', '2024-03-12 12:58:41'),
(93, 43, NULL, NULL, 1, NULL, NULL, 'KYJ 512 Timed Out at March 12, 2024 at 09:26 PM', '2024-03-12 13:26:29', '2024-03-12 13:26:29'),
(94, 41, NULL, NULL, 1, NULL, NULL, 'CAB 314 Timed In at March 12, 2024 at 09:33 PM', '2024-03-12 13:33:16', '2024-03-12 13:33:16'),
(95, 41, NULL, NULL, 1, NULL, NULL, 'CAB 314 Timed Out at March 12, 2024 at 09:33 PM', '2024-03-12 13:33:23', '2024-03-12 13:33:23'),
(96, 47, NULL, NULL, 1, NULL, NULL, 'KAP 690 Timed In at March 12, 2024 at 09:34 PM', '2024-03-12 13:34:58', '2024-03-12 13:34:58'),
(97, 41, NULL, NULL, 1, NULL, NULL, 'CAB 314 Timed In at March 12, 2024 at 09:35 PM', '2024-03-12 13:35:15', '2024-03-12 13:35:15'),
(98, 47, NULL, NULL, 1, NULL, NULL, 'KAP 690 Timed Out at March 12, 2024 at 09:37 PM', '2024-03-12 13:37:36', '2024-03-12 13:37:36'),
(99, 47, NULL, NULL, 1, NULL, NULL, 'KAP 690 Timed In at March 12, 2024 at 09:37 PM', '2024-03-12 13:37:39', '2024-03-12 13:37:39'),
(100, 41, NULL, NULL, 1, NULL, NULL, 'CAB 314 Timed Out at March 12, 2024 at 09:42 PM', '2024-03-12 13:42:15', '2024-03-12 13:42:15'),
(101, 41, NULL, NULL, 1, NULL, NULL, 'CAB 314 Timed In at March 12, 2024 at 09:42 PM', '2024-03-12 13:42:19', '2024-03-12 13:42:19'),
(102, 41, NULL, NULL, 1, NULL, NULL, 'CAB 314 Timed Out at March 12, 2024 at 09:48 PM', '2024-03-12 13:48:34', '2024-03-12 13:48:34'),
(103, 41, NULL, NULL, 1, NULL, NULL, 'CAB 314 Timed In at March 12, 2024 at 09:48 PM', '2024-03-12 13:48:42', '2024-03-12 13:48:42'),
(104, 41, NULL, NULL, 1, NULL, NULL, 'CAB 314 Timed Out at March 12, 2024 at 09:48 PM', '2024-03-12 13:48:47', '2024-03-12 13:48:47'),
(105, 47, NULL, NULL, 1, NULL, NULL, 'KAP 690 Timed Out at March 12, 2024 at 09:48 PM', '2024-03-12 13:48:52', '2024-03-12 13:48:52'),
(106, 47, NULL, NULL, 1, NULL, NULL, 'KAP 690 Timed In at March 12, 2024 at 09:48 PM', '2024-03-12 13:48:56', '2024-03-12 13:48:56'),
(107, 41, NULL, NULL, 1, NULL, NULL, 'CAB 314 Timed In at March 12, 2024 at 09:49 PM', '2024-03-12 13:49:04', '2024-03-12 13:49:04'),
(108, 47, NULL, NULL, 1, NULL, NULL, 'KAP 690 Timed Out at March 12, 2024 at 09:49 PM', '2024-03-12 13:49:09', '2024-03-12 13:49:09'),
(109, 47, NULL, NULL, 1, NULL, NULL, 'KAP 690 Timed In at March 12, 2024 at 10:11 PM', '2024-03-12 14:11:23', '2024-03-12 14:11:23'),
(110, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed In at March 19, 2024 at 10:55 PM', '2024-03-19 14:55:23', '2024-03-19 14:55:23'),
(111, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed Out at March 19, 2024 at 10:55 PM', '2024-03-19 14:55:27', '2024-03-19 14:55:27'),
(112, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed In at March 19, 2024 at 10:55 PM', '2024-03-19 14:55:37', '2024-03-19 14:55:37'),
(113, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed Out at March 20, 2024 at 11:11 PM', '2024-03-20 15:11:05', '2024-03-20 15:11:05'),
(114, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed In at March 20, 2024 at 11:16 PM', '2024-03-20 15:16:44', '2024-03-20 15:16:44'),
(115, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed Out at March 20, 2024 at 11:17 PM', '2024-03-20 15:17:05', '2024-03-20 15:17:05'),
(116, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed In at March 20, 2024 at 11:17 PM', '2024-03-20 15:17:20', '2024-03-20 15:17:20'),
(117, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed Out at March 20, 2024 at 11:34 PM', '2024-03-20 15:34:35', '2024-03-20 15:34:35'),
(118, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed In at March 20, 2024 at 11:34 PM', '2024-03-20 15:34:47', '2024-03-20 15:34:47'),
(119, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed Out at March 20, 2024 at 11:35 PM', '2024-03-20 15:35:37', '2024-03-20 15:35:37'),
(120, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed In at March 20, 2024 at 11:35 PM', '2024-03-20 15:35:48', '2024-03-20 15:35:48'),
(121, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed Out at March 20, 2024 at 11:35 PM', '2024-03-20 15:35:57', '2024-03-20 15:35:57'),
(122, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed In at March 20, 2024 at 11:36 PM', '2024-03-20 15:36:07', '2024-03-20 15:36:07'),
(123, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed Out at March 20, 2024 at 11:36 PM', '2024-03-20 15:36:08', '2024-03-20 15:36:08'),
(124, 52, NULL, NULL, 1, NULL, NULL, 'test2 Timed In at March 20, 2024 at 11:38 PM', '2024-03-20 15:38:35', '2024-03-20 15:38:35'),
(125, 59, NULL, NULL, 1, NULL, NULL, 'test Timed In at March 21, 2024 at 02:53 AM', '2024-03-20 18:53:16', '2024-03-20 18:53:16'),
(126, 59, NULL, NULL, 1, NULL, NULL, 'test Timed Out at March 21, 2024 at 02:56 AM', '2024-03-20 18:56:29', '2024-03-20 18:56:29'),
(127, 59, NULL, NULL, 1, NULL, NULL, 'test Timed In at March 21, 2024 at 02:56 AM', '2024-03-20 18:56:30', '2024-03-20 18:56:30'),
(128, 59, NULL, NULL, 1, NULL, NULL, 'test Timed Out at March 21, 2024 at 02:56 AM', '2024-03-20 18:56:32', '2024-03-20 18:56:32'),
(129, 59, NULL, NULL, 1, NULL, NULL, 'test Timed In at March 21, 2024 at 02:56 AM', '2024-03-20 18:56:34', '2024-03-20 18:56:34'),
(130, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 22, 2024 at 02:23 PM', '2024-03-22 06:23:53', '2024-03-22 06:23:53'),
(131, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 22, 2024 at 02:24 PM', '2024-03-22 06:24:11', '2024-03-22 06:24:11'),
(132, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 22, 2024 at 02:24 PM', '2024-03-22 06:24:27', '2024-03-22 06:24:27'),
(133, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 24, 2024 at 06:58 PM', '2024-03-24 10:58:27', '2024-03-24 10:58:27'),
(134, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 24, 2024 at 06:58 PM', '2024-03-24 10:58:35', '2024-03-24 10:58:35'),
(135, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 24, 2024 at 06:58 PM', '2024-03-24 10:58:41', '2024-03-24 10:58:41'),
(136, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 24, 2024 at 06:58 PM', '2024-03-24 10:58:48', '2024-03-24 10:58:48'),
(137, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 25, 2024 at 01:44 PM', '2024-03-25 05:44:45', '2024-03-25 05:44:45'),
(138, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 25, 2024 at 01:46 PM', '2024-03-25 05:46:34', '2024-03-25 05:46:34'),
(139, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 25, 2024 at 01:46 PM', '2024-03-25 05:46:35', '2024-03-25 05:46:35'),
(140, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 25, 2024 at 01:46 PM', '2024-03-25 05:46:37', '2024-03-25 05:46:37'),
(141, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 26, 2024 at 12:50 AM', '2024-03-25 16:50:13', '2024-03-25 16:50:13'),
(142, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 26, 2024 at 12:50 AM', '2024-03-25 16:50:14', '2024-03-25 16:50:14'),
(143, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 26, 2024 at 12:50 AM', '2024-03-25 16:50:16', '2024-03-25 16:50:16'),
(144, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 27, 2024 at 02:10 PM', '2024-03-27 06:10:05', '2024-03-27 06:10:05'),
(145, 59, NULL, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 27, 2024 at 02:10 PM', '2024-03-27 06:10:10', '2024-03-27 06:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `violation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `violations`
--

INSERT INTO `violations` (`id`, `vehicle_id`, `violation`, `created_at`, `updated_at`) VALUES
(4, NULL, 'Test2fdf', '2024-02-06 09:24:18', '2024-02-06 09:24:22'),
(5, NULL, 'dawdwdwa', '2024-03-08 12:55:02', '2024-03-08 12:55:02'),
(6, NULL, 'Test2fdf', '2024-03-08 13:05:15', '2024-03-08 13:05:20'),
(7, NULL, 'TYest', '2024-03-08 13:59:55', '2024-03-08 13:59:55'),
(8, NULL, 'dawd', '2024-03-08 14:00:12', '2024-03-08 14:00:12'),
(9, NULL, 'Test', '2024-03-08 14:16:49', '2024-03-08 14:16:49'),
(10, NULL, 'Test2', '2024-03-08 14:24:36', '2024-03-08 14:24:36'),
(11, 11, 'dwad', '2024-03-08 14:29:26', '2024-03-08 14:29:26'),
(12, 11, 'Test', '2024-03-08 14:29:39', '2024-03-08 14:29:39'),
(13, 17, 'Test', '2024-03-08 14:29:51', '2024-03-08 14:29:51'),
(14, 29, 'dwad', '2024-03-08 14:29:57', '2024-03-08 14:29:57'),
(15, 13, 'd', '2024-03-08 14:32:59', '2024-03-08 14:32:59'),
(16, 11, 'Test', '2024-03-08 14:50:45', '2024-03-08 14:50:45'),
(17, 29, 'Test2', '2024-03-08 14:54:09', '2024-03-08 14:54:09'),
(18, 12, 'Test2fdf', '2024-03-08 14:58:17', '2024-03-08 14:58:17'),
(19, 24, 'Test', '2024-03-08 14:58:54', '2024-03-08 14:58:54'),
(20, 11, 'Test', '2024-03-08 15:15:54', '2024-03-08 15:15:54'),
(21, 11, 'd', '2024-03-08 15:19:58', '2024-03-08 15:19:58'),
(22, 11, 'd', '2024-03-08 15:23:11', '2024-03-08 15:23:11'),
(23, 13, 'sdad', '2024-03-08 15:23:20', '2024-03-08 15:23:20'),
(24, 11, 'Test2', '2024-03-08 15:24:47', '2024-03-08 15:24:47'),
(25, 11, 'ds', '2024-03-08 15:30:48', '2024-03-08 15:30:48'),
(26, 11, 'Test2', '2024-03-08 15:36:42', '2024-03-08 15:36:42'),
(27, 11, 'dwad', '2024-03-08 15:38:43', '2024-03-08 15:38:43'),
(28, 11, 'dwad', '2024-03-08 15:38:56', '2024-03-08 15:38:56'),
(29, 11, 'dwad', '2024-03-08 15:39:33', '2024-03-08 15:39:33'),
(30, 11, 'fadawdawd', '2024-03-08 15:39:42', '2024-03-08 15:39:42'),
(31, 11, 'fadawdawd', '2024-03-08 15:43:19', '2024-03-08 15:43:19'),
(32, 11, 'fadawdawd', '2024-03-08 15:43:27', '2024-03-08 15:43:27'),
(33, 11, 'fadawdawd', '2024-03-08 15:43:35', '2024-03-08 15:43:35'),
(34, 11, 'fadawdawd2', '2024-03-08 15:43:48', '2024-03-08 15:43:48'),
(35, 11, 'dwadaw', '2024-03-08 15:44:03', '2024-03-08 15:44:03'),
(36, 11, 'dwadaw', '2024-03-08 15:46:34', '2024-03-08 15:46:34'),
(37, 11, 'dwadaw', '2024-03-08 15:46:38', '2024-03-08 15:46:38'),
(38, 11, 'dwadaw3', '2024-03-08 15:46:44', '2024-03-08 15:46:44'),
(39, 11, 'dwadaw4', '2024-03-08 15:46:51', '2024-03-08 15:46:51'),
(40, 11, 'dwadaw3', '2024-03-08 15:47:21', '2024-03-08 15:47:21'),
(41, 11, 'dwadaw3', '2024-03-08 15:47:50', '2024-03-08 15:47:50'),
(42, NULL, 'dad', '2024-03-08 16:00:01', '2024-03-08 16:00:12'),
(43, NULL, 'dwad', '2024-03-08 16:03:12', '2024-03-08 16:03:12'),
(44, NULL, 'Test2', '2024-03-08 16:03:26', '2024-03-08 16:03:26'),
(45, NULL, 'Test2', '2024-03-08 16:04:21', '2024-03-08 16:04:21'),
(46, NULL, '323', '2024-03-08 16:10:03', '2024-03-08 16:10:03'),
(47, NULL, 'Test', '2024-03-08 16:10:17', '2024-03-08 16:10:17'),
(48, NULL, 'd', '2024-03-08 16:11:36', '2024-03-08 16:11:36'),
(49, NULL, 'd', '2024-03-08 16:12:55', '2024-03-08 16:12:55'),
(50, NULL, 'Test', '2024-03-08 16:13:36', '2024-03-08 16:13:36'),
(51, NULL, 'Test', '2024-03-08 16:14:20', '2024-03-08 16:14:20'),
(52, NULL, 'd', '2024-03-08 16:19:30', '2024-03-08 16:19:30'),
(53, NULL, 'd', '2024-03-08 16:19:48', '2024-03-08 16:19:48'),
(54, NULL, 'd', '2024-03-08 16:21:02', '2024-03-08 16:21:02'),
(55, NULL, 'd', '2024-03-08 16:21:02', '2024-03-08 16:21:02'),
(56, NULL, 'd', '2024-03-08 16:21:07', '2024-03-08 16:21:07'),
(57, 11, 'd', '2024-03-08 16:22:20', '2024-03-08 16:22:20'),
(58, 11, 'd', '2024-03-08 16:23:02', '2024-03-08 16:23:02'),
(59, 11, 'ddd', '2024-03-08 16:25:19', '2024-03-08 16:25:19'),
(60, 11, 'ddd', '2024-03-08 16:26:20', '2024-03-08 16:26:20'),
(61, 11, 'ddd2', '2024-03-08 16:26:25', '2024-03-08 16:26:25'),
(62, NULL, 'dddd', '2024-03-08 16:27:47', '2024-03-08 16:27:47'),
(63, 11, 'dddd33', '2024-03-08 16:30:02', '2024-03-08 16:30:02'),
(64, NULL, 'Test2', '2024-03-08 16:33:40', '2024-03-08 16:33:40'),
(65, NULL, 'Test', '2024-03-08 16:33:47', '2024-03-08 16:33:47'),
(66, NULL, 'ddd', '2024-03-08 16:34:05', '2024-03-08 16:34:05'),
(72, 11, 'Test2', '2024-03-08 16:59:52', '2024-03-08 16:59:52'),
(74, 11, 'dd', '2024-03-08 17:08:35', '2024-03-08 17:08:35'),
(75, 29, 'Test2', '2024-03-08 17:26:03', '2024-03-08 17:26:03'),
(76, 11, 'Testdsa', '2024-03-09 04:18:05', '2024-03-09 04:31:03'),
(77, 11, 'Blocking The Driveway', '2024-03-09 04:31:10', '2024-03-09 05:28:07'),
(78, 14, 'Illegal Parking', '2024-03-09 05:17:12', '2024-03-09 06:36:49'),
(79, 43, 'No Signal Light', '2024-03-12 14:13:42', '2024-03-12 14:13:42'),
(80, 46, 'Illegal Parking', '2024-03-14 11:53:17', '2024-03-14 11:53:17'),
(81, 47, 'Illegal Parking', '2024-03-14 11:53:28', '2024-03-14 11:53:28'),
(82, 45, 'Illegal Parking', '2024-03-14 11:54:48', '2024-03-14 11:54:48'),
(83, 59, 'Illegal Parking', '2024-03-21 06:20:49', '2024-03-21 06:20:49'),
(84, 52, 'Illegal Parking', '2024-03-21 06:21:31', '2024-03-21 06:21:31'),
(85, 59, 'Blocking the Driveway', '2024-03-22 06:17:12', '2024-03-22 06:17:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicants_appointment_id_foreign` (`appointment_id`),
  ADD KEY `applicants_status_id_foreign` (`status_id`),
  ADD KEY `applicants_user_id_foreign` (`user_id`),
  ADD KEY `applicants_vehicle_id_foreign` (`vehicle_id`);

--
-- Indexes for table `applicants_record`
--
ALTER TABLE `applicants_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicants_appointment_id_foreign` (`appointment_id`),
  ADD KEY `applicants_status_id_foreign` (`status_id`),
  ADD KEY `applicants_user_id_foreign` (`user_id`),
  ADD KEY `applicants_vehicle_id_foreign` (`vehicle_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drivers_user_id_foreign` (`user_id`);

--
-- Indexes for table `drivers_record`
--
ALTER TABLE `drivers_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drivers_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `times`
--
ALTER TABLE `times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `times_vehicle_id_foreign` (`vehicle_id`);

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
  ADD KEY `vehicles_user_id_foreign` (`user_id`),
  ADD KEY `vehicles_driver_id_foreign` (`driver_id`),
  ADD KEY `vehicles_owner_id_foreign` (`owner_id`) USING BTREE;

--
-- Indexes for table `vehicles_record`
--
ALTER TABLE `vehicles_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicles_user_id_foreign` (`user_id`),
  ADD KEY `vehicles_driver_id_foreign` (`driver_id`),
  ADD KEY `vehicles_owner_id_foreign` (`owner_id`) USING BTREE;

--
-- Indexes for table `vehicle_record`
--
ALTER TABLE `vehicle_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_record_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `vehicle_record_user_id_foreign` (`user_id`),
  ADD KEY `vehicle_record_appointment_id_foreign` (`appointment_id`),
  ADD KEY `vehicle_record_driver_id_foreign` (`driver_id`),
  ADD KEY `vehicle_record_status_id_foreign` (`status_id`),
  ADD KEY `vehicle_record_owner_id_foreign` (`owner_id`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `violations_vehicle_id_foreign` (`vehicle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `applicants_record`
--
ALTER TABLE `applicants_record`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `drivers_record`
--
ALTER TABLE `drivers_record`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `times`
--
ALTER TABLE `times`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `vehicles_record`
--
ALTER TABLE `vehicles_record`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_record`
--
ALTER TABLE `vehicle_record`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `applicants_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `applicants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `applicants_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `times`
--
ALTER TABLE `times`
  ADD CONSTRAINT `times_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vehicles_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_record`
--
ALTER TABLE `vehicle_record`
  ADD CONSTRAINT `vehicle_record_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vehicle_record_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vehicle_record_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_record_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vehicle_record_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_record_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `violations`
--
ALTER TABLE `violations`
  ADD CONSTRAINT `violations_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
