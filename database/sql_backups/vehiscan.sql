-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2024 at 05:40 PM
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
(109, NULL, 12, 1, 19, '521', '213', 'Omongos', 'Christian Rex', 'B', 'Abigail, Iligan City', 'christianrexomongos@gmail.com', '55555555555', 'CCS', 'Student', '1710001778.png', 'Approved', 'None / Approved', '2024-03-09 16:29:38', '2024-03-09 16:29:38'),
(110, 39, 13, 1, 19, '1234', '213123', 'Chu', 'Alexis Jan', 'M', 'Steeltown', 'alexisjanchu@gmail.com', '23132312312', 'CCS', 'Student', '1710151936.png', 'Approved', 'None / Approved', '2024-03-11 10:12:18', '2024-03-11 15:49:55');

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
(26, 'Partner/Supplier', '2024-02-19 15:16:18', '2024-02-19 15:16:18'),
(27, 'dd', '2024-03-09 06:37:10', '2024-03-09 06:37:10'),
(28, 'dsadas', '2024-03-09 06:51:28', '2024-03-09 06:51:28'),
(29, 'Contractual(Job Order)ooaaaa', '2024-03-09 06:53:36', '2024-03-09 07:03:46'),
(30, 'dddddaw', '2024-03-09 07:03:52', '2024-03-09 07:03:57'),
(31, 'dawd', '2024-03-09 07:04:03', '2024-03-09 07:04:03'),
(32, 'Contractual(Job Order)sd', '2024-03-09 13:17:22', '2024-03-09 13:17:22');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_license_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorized_driver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorized_driver_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorized_driver_license_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(110, 1, 'Alexis Jan M. Chu', '35a9980a-85d6-4ad2-b567-d73615906851.png', 'Christian Rex B. Omongos', 'Abigail', 'a6fe335c-f068-4fb6-bd4d-d583a6b85d93.png', 'Approved', 'None / Approved', '2024-03-11 10:12:18', '2024-03-11 10:12:18'),
(111, 1, 'Sir Elmer', '710890d2-df4a-4c50-a84e-90458789a95c.jpg', 'Taylor Fast', 'U.S.A Canada, Buru-Un', '81baad24-d3cc-43df-8135-ecf5af78eebb.jpg', 'Approved', 'None / Approved', '2024-03-11 16:16:55', '2024-03-11 16:16:55');

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
(3, 'App\\Models\\User', 3);

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
(9, 'delete-product', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53');

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
(3, 'Product Manager', 'web', '2024-02-05 19:57:53', '2024-02-05 19:57:53');

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
(5, 2),
(6, 2),
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
(73, 31, '2024-03-05 09:50:01', '2024-03-05 10:51:17', '2024-03-05 01:50:01', '2024-03-05 02:51:17'),
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
(98, 24, '2024-03-05 16:56:20', '2024-03-05 16:56:46', '2024-03-05 08:56:20', '2024-03-05 08:56:46'),
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
(179, 31, '2024-03-09 15:21:20', NULL, '2024-03-09 07:21:20', '2024-03-09 07:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Javed Ur Rehman', 'javed@allphptricks.com', NULL, '$2y$12$hLm6F4arX4CkO.qlvtZXAO89Pdq5ZcfWrstmd4HS82KH0vRlQ6QFO', NULL, '2024-02-05 19:57:54', '2024-02-05 19:57:54'),
(2, 'Syed Ahsan Kamal', 'ahsan@allphptricks.com', NULL, '$2y$12$1HnNtjaZ9KxpR8Uw8uHd7.kwksy.BSABMdofCeKiUBhJpsNHGDLEO', NULL, '2024-02-05 19:57:54', '2024-02-05 19:57:54'),
(3, 'Abdul Muqeet', 'muqeet@allphptricks.com', NULL, '$2y$12$T1qI6cCVpH.uLbmcR81/tu4FthVCDR7yLQ.pWud9wFN0Qroh4wW5e', NULL, '2024-02-05 19:57:55', '2024-02-05 19:57:55');

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
(26, 1, 0, 25, 'ae77ceaa-089c-4eb6-ae51-d7ec866a2300.jpg', '17254302-ee9b-4e95-a14c-5c2a65648eda.jpg', '3ababe38-8986-4dc8-8801-ed392d02067f.jpg', '6d3f964f-dbe6-481d-b46c-12bd96925803.jpg', '6', '6', '6', 'ff68528b-6fcf-4d3a-8c83-95f4ccc0d346.jpg', '349a8400-4a50-4243-9154-e29e670aa709.jpg', '6', '6', '6', 'Approved', 'None / Approved', 'Inactive', '2037140551', NULL, '2024-02-27 06:42:56', '2024-02-27 06:42:56'),
(29, 1, 0, 28, '694ada94-1a55-4980-8e01-34d107acb18f.jpg', '51c0b9f4-7c8c-4154-bbcc-ec9f50f20f3e.jpg', '70e45f3c-ced2-4d44-9c43-01ff0da2045a.jpg', '8c4ca88e-df14-47b0-bc4e-09ea9f792c00.jpg', 'California', 'KAP 1990', 'Toyota Hilux Conquest', '1709223690_front_photo.jpg', '43f85a86-b6f6-4fc5-b4d0-11595c683975.jpg', '2024', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Inactive', '2037140557', NULL, '2024-02-27 07:01:53', '2024-03-06 09:45:13'),
(30, 1, 0, 19, 'd239751d-07f5-45c3-978d-e1a20a3434f6.jpg', 'c31acd86-3137-4ec6-9235-a84902a55a0e.jpg', 'f092de44-025a-4222-af48-29a47745e20b.jpg', '7eab447e-fa38-4db8-944c-ac5690c2b34d.jpg', '1', '1', '1', '8faf9ddf-39cb-42ed-b3f7-f172145bfa1b.jpg', 'a2eb1ceb-c921-48f4-bedc-cb9be532a7ca.jpg', '1', '1', '1', 'Approved', 'None / Approved', 'Active', '2037140556', 'public/images/qrcodes/1_2037140556.png', '2024-03-04 05:58:22', '2024-03-07 16:33:26'),
(31, 1, 0, 28, 'd127dad1-288e-4c4e-9e87-ae67601d5ae5.jpg', '13407fdd-e614-456c-8fb0-2e324fc6d1ce.jpg', '85c7488c-9156-4cde-b579-309b8def5a7e.jpg', 'e0ab6a62-ceb0-4ae6-81d0-9aaaeaa1c4cb.jpg', 'Driver\'s License', 'ORD - 700', 'c', 'd4991893-45ab-46ff-afb1-e9d5ec44e2fc.jpg', '614b287f-ccac-4613-beff-fc71af929718.jpg', 'c', 'c', 'c', 'Approved', 'None / Approved', 'Active', '2037140555', 'public/images/qrcodes/ORD - 699_2037140555.png', '2024-03-04 06:01:16', '2024-03-08 13:34:08'),
(38, 1, 0, 107, '789d99c1-f28c-4271-bd80-21d63e2a6174.png', '18fa5700-8bb2-41a6-a3b0-43957540a9f8.png', '2ec0c630-f933-4868-a121-642fa506c49f.png', '0e36416c-0b41-48e5-a556-1eb0dbdcaf5f.png', 'Abigail, Iligan City', 'CRO 696', 'Toyota Wigo', '6ea5fdb6-35e5-4407-969e-766b79925193.png', '02807a8d-afad-4e47-a155-7a4bf9fde6b7.png', '2022', 'Black', 'Hatchback', 'Approved', 'None / Approved', 'Inactive', '4780247106', NULL, '2024-03-09 16:50:26', '2024-03-09 16:50:26'),
(39, 1, 0, 110, 'c0d950cb-5776-4e79-a580-6c42cfc6a2ac.png', 'defcef27-76f6-4254-be77-fe0d64fd4a31.png', 'b6486932-0777-40e5-84f5-b44e173675e8.png', '38b405d9-e265-4e7e-b2c1-af6b900fdf48.png', 'Steeltown', 'DEF 631', 'Toyota Hilux Conquest', '21423989-ce8f-4919-850d-680599357864.png', 'a7a39639-7ff4-48c8-9a0a-1b651fa5d7e3.png', '2023', 'Gray', 'Pick Up', 'Approved', 'None / Approved', 'Active', '5327037207', NULL, '2024-03-11 10:12:18', '2024-03-11 10:12:18'),
(40, 1, 0, 110, '3e4b6cbb-3786-4bec-ab61-428ac0c5c2f1.png', '25ac8c23-9197-4fe6-b971-473270e89fb0.png', '247403a0-b823-494c-8800-81d2b0784f22.png', 'd4c29053-1b9a-41f1-bb41-30024964b4b1.png', 'Abigail, Iligan City', 'BAC 312', 'Toyota Hilux Conquest', 'be4f8b08-c162-4ebe-886a-539f9042df93.png', 'a95306ac-1717-4d3b-8f80-452998c40796.png', '2023', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Inactive', '4426899660', NULL, '2024-03-11 13:28:57', '2024-03-11 13:28:57'),
(41, 1, 0, 111, '696f25e0-c625-4d40-8586-d40d4eccae51.png', '5656fed0-2679-47d9-bdab-e6ddad8d746a.png', 'adacc50c-7743-4cda-b378-39e8c96cf76e.png', '597e87d4-b5cf-428b-a4db-8d3aa7d98b0a.png', 'Purok 1, Luinab, Iligan City', 'CAB 314', 'Toyota Hilux Conquest', '03085b08-800c-4b83-89c3-20eb181fb0d0.jfif', '9693c68d-87d6-4bd8-b06f-9ebd1a04f774.jpg', '2022', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Active', '8141694317', NULL, '2024-03-11 16:18:38', '2024-03-11 16:18:38'),
(42, 1, 0, 111, '9bc188b8-ac11-4108-8536-810155d0ce6d.png', '8dc23e52-95e6-4079-9b17-05e2b3e382c4.png', '5d85fd70-f990-4421-9da8-25d73d2394f4.png', 'd78c69fa-442d-42e7-8cc4-41facf23c811.png', 'Purok 1, Luinab, Iligan City', 'BAC 412', 'Toyota Hilux Conquest', '6ff5fbd0-a64f-4be6-a8f1-2a7a6f9e7a3e.jfif', 'afd7156e-b6e9-4552-95d6-5486e2e10802.jpg', '2022', 'Black', 'Pick Up', 'Approved', 'None / Approved', 'Active', '9131206782', NULL, '2024-03-11 16:22:16', '2024-03-11 16:22:16');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_record`
--

CREATE TABLE `vehicle_record` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
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

INSERT INTO `vehicle_record` (`id`, `vehicle_id`, `status_id`, `user_id`, `appointment_id`, `driver_id`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 29, NULL, 1, NULL, NULL, 'Vehicle 29 Timed in at 2024-03-06 23:00:14', '2024-03-06 15:00:14', '2024-03-06 15:00:14'),
(2, 29, NULL, 1, NULL, NULL, 'Vehicle KAP 1990 Timed in at 2024-03-06 23:02:19', '2024-03-06 15:02:19', '2024-03-06 15:02:19'),
(3, 29, NULL, 1, NULL, NULL, 'KAP 1990 Timed in at 2024-03-06 23:03:21', '2024-03-06 15:03:21', '2024-03-06 15:03:21'),
(4, 29, NULL, 1, NULL, NULL, 'KAP 1990 Timed out at 2024-03-06 23:07:24', '2024-03-06 15:07:24', '2024-03-06 15:07:24'),
(5, 29, NULL, 1, NULL, NULL, 'KAP 1990 Timed in at 2024-03-06 23:07:42', '2024-03-06 15:07:42', '2024-03-06 15:07:42'),
(6, 29, NULL, 1, NULL, NULL, 'KAP 1990 Timed out at 2024-03-06 23:08:33', '2024-03-06 15:08:33', '2024-03-06 15:08:33'),
(7, 29, NULL, 1, NULL, NULL, 'KAP 1990 Timed in at 2024-03-06 23:08:39', '2024-03-06 15:08:39', '2024-03-06 15:08:39'),
(8, 29, NULL, 1, NULL, NULL, 'KAP 1990 Timed out at 2024-03-06 23:09:59', '2024-03-06 15:09:59', '2024-03-06 15:09:59'),
(9, 29, NULL, 1, NULL, NULL, 'KAP 1990 Timed in at 2024-03-06 23:10:03', '2024-03-06 15:10:03', '2024-03-06 15:10:03'),
(10, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:17:24', '2024-03-06 15:17:24', '2024-03-06 15:17:24'),
(11, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:17:37', '2024-03-06 15:17:37', '2024-03-06 15:17:37'),
(12, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:19:46', '2024-03-06 15:19:46', '2024-03-06 15:19:46'),
(13, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:19:58', '2024-03-06 15:19:58', '2024-03-06 15:19:58'),
(14, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:20:05', '2024-03-06 15:20:05', '2024-03-06 15:20:05'),
(15, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:20:07', '2024-03-06 15:20:07', '2024-03-06 15:20:07'),
(16, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:24:21', '2024-03-06 15:24:21', '2024-03-06 15:24:21'),
(17, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:24:25', '2024-03-06 15:24:25', '2024-03-06 15:24:25'),
(18, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:36:31', '2024-03-06 15:36:31', '2024-03-06 15:36:31'),
(19, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:41:10', '2024-03-06 15:41:10', '2024-03-06 15:41:10'),
(20, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:43:03', '2024-03-06 15:43:03', '2024-03-06 15:43:03'),
(21, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:49:57', '2024-03-06 15:49:57', '2024-03-06 15:49:57'),
(22, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:53:16', '2024-03-06 15:53:16', '2024-03-06 15:53:16'),
(23, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-06 23:59:26', '2024-03-06 15:59:26', '2024-03-06 15:59:26'),
(24, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-06 23:59:39', '2024-03-06 15:59:39', '2024-03-06 15:59:39'),
(25, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed in at 2024-03-07 00:04:09', '2024-03-06 16:04:09', '2024-03-06 16:04:09'),
(26, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed out at 2024-03-07 00:04:14', '2024-03-06 16:04:14', '2024-03-06 16:04:14'),
(27, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed in at March 7, 2024 at 12:08 AM', '2024-03-06 16:08:00', '2024-03-06 16:08:00'),
(28, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed out at March 7, 2024 at 12:08 AM', '2024-03-06 16:08:08', '2024-03-06 16:08:08'),
(29, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed in at March 7, 2024 at 12:08 AM', '2024-03-06 16:08:34', '2024-03-06 16:08:34'),
(30, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed out at March 7, 2024 at 12:08 AM', '2024-03-06 16:08:35', '2024-03-06 16:08:35'),
(31, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed in at March 7, 2024 at 12:08 AM', '2024-03-06 16:08:36', '2024-03-06 16:08:36'),
(32, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:17 AM', '2024-03-06 16:17:39', '2024-03-06 16:17:39'),
(33, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:17 AM', '2024-03-06 16:17:41', '2024-03-06 16:17:41'),
(34, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:17 AM', '2024-03-06 16:17:45', '2024-03-06 16:17:45'),
(35, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:17 AM', '2024-03-06 16:17:47', '2024-03-06 16:17:47'),
(36, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:07', '2024-03-06 16:18:07'),
(37, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:09', '2024-03-06 16:18:09'),
(38, 13, NULL, 1, NULL, NULL, 'd Timed In at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:33', '2024-03-06 16:18:33'),
(39, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:37', '2024-03-06 16:18:37'),
(40, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:41', '2024-03-06 16:18:41'),
(41, 13, NULL, 1, NULL, NULL, 'd Timed Out at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:45', '2024-03-06 16:18:45'),
(42, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:18 AM', '2024-03-06 16:18:50', '2024-03-06 16:18:50'),
(43, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:19 AM', '2024-03-06 16:19:00', '2024-03-06 16:19:00'),
(44, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:21 AM', '2024-03-06 16:21:03', '2024-03-06 16:21:03'),
(45, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:21 AM', '2024-03-06 16:21:13', '2024-03-06 16:21:13'),
(46, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:21 AM', '2024-03-06 16:21:25', '2024-03-06 16:21:25'),
(47, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:21 AM', '2024-03-06 16:21:36', '2024-03-06 16:21:36'),
(48, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:25 AM', '2024-03-06 16:25:01', '2024-03-06 16:25:01'),
(49, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 12:25 AM', '2024-03-06 16:25:05', '2024-03-06 16:25:05'),
(50, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 12:25 AM', '2024-03-06 16:25:16', '2024-03-06 16:25:16'),
(51, 30, NULL, 1, NULL, NULL, '1 Timed In at March 7, 2024 at 12:32 AM', '2024-03-06 16:32:18', '2024-03-06 16:32:18'),
(52, 30, NULL, 1, NULL, NULL, '1 Timed Out at March 7, 2024 at 12:32 AM', '2024-03-06 16:32:23', '2024-03-06 16:32:23'),
(53, 30, NULL, 1, NULL, NULL, '1 Timed In at March 7, 2024 at 12:32 AM', '2024-03-06 16:32:26', '2024-03-06 16:32:26'),
(54, 30, NULL, 1, NULL, NULL, '1 Timed Out at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:07', '2024-03-06 16:33:07'),
(55, 30, NULL, 1, NULL, NULL, '1 Timed In at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:34', '2024-03-06 16:33:34'),
(56, 30, NULL, 1, NULL, NULL, '1 Timed Out at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:42', '2024-03-06 16:33:42'),
(57, 30, NULL, 1, NULL, NULL, '1 Timed In at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:46', '2024-03-06 16:33:46'),
(58, 30, NULL, 1, NULL, NULL, '1 Timed Out at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:48', '2024-03-06 16:33:48'),
(59, 30, NULL, 1, NULL, NULL, '1 Timed In at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:51', '2024-03-06 16:33:51'),
(60, 30, NULL, 1, NULL, NULL, '1 Timed Out at March 7, 2024 at 12:33 AM', '2024-03-06 16:33:55', '2024-03-06 16:33:55'),
(61, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 01:17 PM', '2024-03-07 05:17:52', '2024-03-07 05:17:52'),
(62, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 01:17 PM', '2024-03-07 05:17:55', '2024-03-07 05:17:55'),
(63, 31, NULL, 1, NULL, NULL, 'ORD - 696 Timed In at March 7, 2024 at 01:18 PM', '2024-03-07 05:18:36', '2024-03-07 05:18:36'),
(64, 31, NULL, 1, NULL, NULL, 'ORD - 696 Timed Out at March 7, 2024 at 01:18 PM', '2024-03-07 05:18:49', '2024-03-07 05:18:49'),
(65, 31, NULL, 1, NULL, NULL, 'ORD - 696 Timed In at March 7, 2024 at 03:52 PM', '2024-03-07 07:52:02', '2024-03-07 07:52:02'),
(66, 31, NULL, 1, NULL, NULL, 'ORD - 696 Timed Out at March 7, 2024 at 03:52 PM', '2024-03-07 07:52:10', '2024-03-07 07:52:10'),
(67, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 03:52 PM', '2024-03-07 07:52:16', '2024-03-07 07:52:16'),
(68, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 03:59 PM', '2024-03-07 07:59:42', '2024-03-07 07:59:42'),
(69, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed In at March 7, 2024 at 03:59 PM', '2024-03-07 07:59:45', '2024-03-07 07:59:45'),
(70, 11, NULL, 1, NULL, NULL, 'S7 K386 Timed Out at March 7, 2024 at 04:00 PM', '2024-03-07 08:00:00', '2024-03-07 08:00:00'),
(71, 31, NULL, 1, NULL, NULL, 'ORD - 696 Timed In at March 7, 2024 at 10:39 PM', '2024-03-07 14:39:49', '2024-03-07 14:39:49'),
(72, 13, NULL, 1, NULL, NULL, 'd Timed In at March 7, 2024 at 10:39 PM', '2024-03-07 14:39:54', '2024-03-07 14:39:54'),
(73, 13, NULL, 1, NULL, NULL, 'd Timed Out at March 7, 2024 at 10:39 PM', '2024-03-07 14:39:57', '2024-03-07 14:39:57'),
(74, 30, NULL, 1, NULL, NULL, '1 Timed In at March 7, 2024 at 10:52 PM', '2024-03-07 14:52:58', '2024-03-07 14:52:58'),
(75, 30, NULL, 1, NULL, NULL, '1 Timed Out at March 7, 2024 at 10:53 PM', '2024-03-07 14:53:01', '2024-03-07 14:53:01'),
(76, 29, NULL, 1, NULL, NULL, 'KAP 1990 Timed Out at March 7, 2024 at 10:53 PM', '2024-03-07 14:53:06', '2024-03-07 14:53:06'),
(77, 26, NULL, 1, NULL, NULL, '6 Timed In at March 7, 2024 at 10:53 PM', '2024-03-07 14:53:12', '2024-03-07 14:53:12'),
(78, 26, NULL, 1, NULL, NULL, '6 Timed Out at March 7, 2024 at 10:53 PM', '2024-03-07 14:53:15', '2024-03-07 14:53:15'),
(79, 26, NULL, 1, NULL, NULL, '6 Timed In at March 7, 2024 at 10:53 PM', '2024-03-07 14:53:18', '2024-03-07 14:53:18'),
(80, 31, NULL, 1, NULL, NULL, 'ORD - 700 Timed Out at March 9, 2024 at 03:20 PM', '2024-03-09 07:20:42', '2024-03-09 07:20:42'),
(81, 26, NULL, 1, NULL, NULL, '6 Timed Out at March 9, 2024 at 03:20 PM', '2024-03-09 07:20:57', '2024-03-09 07:20:57'),
(82, 31, NULL, 1, NULL, NULL, 'ORD - 700 Timed In at March 9, 2024 at 03:21 PM', '2024-03-09 07:21:20', '2024-03-09 07:21:20');

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
(78, 14, 'Illegal Parking', '2024-03-09 05:17:12', '2024-03-09 06:36:49');

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
-- Indexes for table `vehicle_record`
--
ALTER TABLE `vehicle_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_record_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `vehicle_record_status_id_foreign` (`status_id`),
  ADD KEY `vehicle_record_user_id_foreign` (`user_id`),
  ADD KEY `vehicle_record_appointment_id_foreign` (`appointment_id`),
  ADD KEY `vehicle_record_driver_id_foreign` (`driver_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `times`
--
ALTER TABLE `times`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `vehicle_record`
--
ALTER TABLE `vehicle_record`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `applicants_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `applicants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_record`
--
ALTER TABLE `vehicle_record`
  ADD CONSTRAINT `vehicle_record_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_record_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_record_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE,
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
