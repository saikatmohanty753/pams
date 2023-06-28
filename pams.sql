-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2023 at 09:34 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pams`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign_observer_users_details`
--

CREATE TABLE `assign_observer_users_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `task_detail_id` int(11) DEFAULT NULL,
  `observer_user_id` int(11) DEFAULT NULL,
  `add_by_user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_removed` tinyint(4) DEFAULT 0,
  `removed_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assign_users_details`
--

CREATE TABLE `assign_users_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `task_detail_id` int(11) DEFAULT NULL,
  `assign_user_id` int(11) DEFAULT NULL,
  `assigned_by_user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1=>open,2=>Re-open,3=>under review, 4=>close',
  `is_active` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_responsible` tinyint(4) DEFAULT 0,
  `is_removed` tinyint(4) DEFAULT 0,
  `removed_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_details`
--

CREATE TABLE `comment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `task_detail_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Sales', 1, '2023-06-03 09:35:18', '2023-06-03 09:35:18'),
(2, 'Pre Sales', 1, '2023-06-03 09:35:18', '2023-06-03 09:35:18'),
(3, 'Production', 1, '2023-06-03 09:35:18', '2023-06-03 09:35:18'),
(4, 'Finance', 1, '2023-06-03 09:35:18', '2023-06-03 09:35:18'),
(5, 'HR', 1, '2023-06-03 09:35:18', '2023-06-03 09:35:18'),
(7, 'Admin', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departs_project_details`
--

CREATE TABLE `departs_project_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `dept_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 1, '2023-06-28 10:19:01', '2023-06-29 10:19:09'),
(2, 'Admin', 1, '2023-06-27 10:19:15', '2023-06-29 10:19:19'),
(3, 'Manager', 1, '2023-06-21 11:03:20', '2023-06-29 11:03:27'),
(4, 'Team Lead', 1, '2023-06-22 11:03:31', '2023-06-29 11:03:35'),
(5, 'Sr. Developer', 1, '2023-06-30 11:03:38', '2023-06-30 11:03:41'),
(6, 'Jr. Developer', 1, '2023-06-22 11:03:45', '2023-06-22 11:03:48'),
(7, 'MD', 1, '2023-06-15 11:03:55', '2023-06-22 11:04:00'),
(8, 'DIRECTOR', 1, '2023-06-22 11:04:04', '2023-06-22 11:04:07');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_06_03_085916_create_permission_tables', 1),
(6, '2023_06_01_052123_add_is_active_to_users_table', 2),
(7, '2023_06_01_062741_create_users_details_table', 2),
(8, '2023_06_01_064404_update_users_table', 3),
(9, '2023_06_01_064854_add_last_name_to_users_table', 3),
(10, '2023_06_01_070858_add_dob_to_users_table', 3),
(11, '2023_06_01_092900_add_profile_pic_to_users_table', 3),
(12, '2023_06_01_113838_create_user_type_table', 3),
(13, '2023_06_03_051024_create_project_masters_table', 3),
(14, '2023_06_03_063937_add_dates_to_project_masters_table', 3),
(15, '2023_06_03_070423_create_task_details_table', 3),
(16, '2023_06_03_071704_create_assign_users_details_table', 3),
(17, '2023_06_03_071816_create_assign_observer_users_details_table', 3),
(18, '2023_06_03_073313_create_comment_details_table', 3),
(19, '2023_06_03_074543_create_project_assign_details_table', 3),
(20, '2023_06_03_093126_create_departments_table', 4),
(21, '2023_06_03_093331_create_designations_table', 5),
(23, '2023_06_03_102037_add_role_id_to_users_table', 6),
(24, '2023_06_03_103332_add_is_deleted_to_users_table', 7),
(25, '2023_06_04_064332_add_is_active_to_project_assign_details', 8),
(26, '2023_06_05_042452_create_reporting_desig_details_table', 9),
(27, '2023_06_05_043632_add_department_id_to_reporting_desig_details_table', 10),
(28, '2023_06_05_054033_add_is_deleted_to_reporting_desig_details_table', 11),
(29, '2023_06_05_062621_add_dept_id_to_roles_table', 12),
(30, '2023_06_05_063030_rename_department_id_in_users_table', 13),
(31, '2023_06_05_064337_rename_department_id_in_reporting_desig_details_table', 14),
(32, '2023_06_06_041658_add_description_to_project_masters_table', 15),
(33, '2023_06_07_052624_add_tier_user_to_users_table', 16),
(34, '2023_06_07_071129_add_dept_id_to_task_details_table', 17),
(35, '2023_06_07_080955_add_responsible_person_to_task_details_table', 18),
(36, '2023_06_07_081807_add_is_responsible_to_assign_users_details_table', 19),
(37, '2023_06_07_092405_add_start_date_to_task_details_table', 20),
(38, '2023_06_07_102041_add_is_delete_to_task_details_table', 21),
(39, '2023_06_07_121721_create_sub_departments_table', 22),
(40, '2023_06_07_122344_add_deleted_date_to_sub_departments_table', 23),
(41, '2023_06_08_051615_add_is_removed_to_assign_users_details_table', 24),
(42, '2023_06_08_054040_add_is_removed_to_assign_observer_users_details_table', 25),
(43, '2023_06_08_153747_create_departs_project_details_table', 26),
(44, '2023_06_08_154105_create_subdeparts_project_details_table', 27),
(45, '2023_06_08_170538_add_sub_dept_id_to_sub_departments', 28),
(46, '2023_06_08_171242_add_sub_dept_id_to_users_table', 29);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user-module', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(2, 'user-list', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(3, 'user-create', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(4, 'user-edit', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(5, 'user-delete', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(6, 'role-module', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(7, 'role-list', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(8, 'role-create', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(9, 'role-edit', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(10, 'role-delete', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(11, 'master-module', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(12, 'master-list', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(13, 'master-create', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(14, 'master-edit', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(15, 'master-delete', 'web', '2023-06-06 00:09:39', '2023-06-06 00:09:39'),
(16, 'project-module', 'web', '2023-06-06 03:44:23', '2023-06-06 03:44:23'),
(17, 'project-list', 'web', '2023-06-06 03:44:23', '2023-06-06 03:44:23'),
(18, 'project-create', 'web', '2023-06-06 03:44:23', '2023-06-06 03:44:23'),
(19, 'project-edit', 'web', '2023-06-06 03:44:23', '2023-06-06 03:44:23'),
(20, 'project-delete', 'web', '2023-06-06 03:44:23', '2023-06-06 03:44:23'),
(21, 'task-module', 'web', '2023-06-06 03:44:23', '2023-06-06 03:44:23'),
(22, 'task-list', 'web', '2023-06-06 03:44:23', '2023-06-06 03:44:23'),
(23, 'task-create', 'web', '2023-06-06 03:44:24', '2023-06-06 03:44:24'),
(24, 'task-edit', 'web', '2023-06-06 03:44:24', '2023-06-06 03:44:24'),
(25, 'task-delete', 'web', '2023-06-06 03:44:24', '2023-06-06 03:44:24');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_assign_details`
--

CREATE TABLE `project_assign_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `assign_to_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_assign_details`
--

INSERT INTO `project_assign_details` (`id`, `project_id`, `dept_id`, `assign_to_user_id`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 1, 3, 3, '2023-06-04 01:40:57', '2023-06-04 01:40:57', 1),
(2, 1, 1, 5, '2023-06-04 01:40:57', '2023-06-04 01:40:57', 1),
(3, 1, 3, 10, '2023-06-06 22:37:33', '2023-06-06 22:37:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_masters`
--

CREATE TABLE `project_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `estimate_start_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `estimate_end_date` date DEFAULT NULL,
  `actual_start_date` date DEFAULT NULL,
  `actual_end_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `is_deleted` tinyint(4) DEFAULT 0,
  `deleted_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reporting_desig_details`
--

CREATE TABLE `reporting_desig_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `desig_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `reporting_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `is_delete` tinyint(4) DEFAULT 0,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `guard_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `dept_id`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 7, 'web', '2023-06-03 05:51:07', '2023-06-06 00:51:41'),
(2, 'Admin', 7, 'web', '2023-06-03 05:57:39', '2023-06-06 00:52:24'),
(3, 'Manager', 3, 'web', '2023-06-03 06:26:17', '2023-06-05 05:48:52'),
(4, 'Director', 7, 'web', '2023-06-04 00:13:29', '2023-06-06 00:53:14'),
(5, 'Team Lead', 3, 'web', '2023-06-04 00:14:41', '2023-06-05 05:49:18'),
(6, 'Sr. Developer', 3, 'web', '2023-06-04 00:14:57', '2023-06-05 05:49:28'),
(7, 'Jr. Developer', 3, 'web', '2023-06-04 00:15:10', '2023-06-06 06:14:02'),
(12, 'Manager', 2, 'web', '2023-06-05 23:16:23', '2023-06-05 23:17:32'),
(13, 'Manager', 1, 'web', '2023-06-07 00:37:59', '2023-06-07 00:37:59');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_departments`
--

CREATE TABLE `sub_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 0,
  `is_delete` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_departments`
--

INSERT INTO `sub_departments` (`id`, `dept_id`, `name`, `is_active`, `is_delete`, `created_at`, `updated_at`, `deleted_date`) VALUES
(1, 3, 'SAP', 1, 0, '2023-06-07 07:17:04', '2023-06-07 07:17:04', NULL),
(2, 3, 'Dot Net', 1, 0, '2023-06-07 07:20:12', '2023-06-07 07:20:12', NULL),
(3, 3, 'PHP', 1, 0, '2023-06-07 07:20:23', '2023-06-07 07:20:23', NULL),
(4, 3, 'Mobile', 1, 0, '2023-06-07 07:20:47', '2023-06-07 07:20:47', NULL),
(5, 3, 'Frontend development', 1, 0, '2023-06-07 07:20:47', '2023-06-07 07:20:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_depts_project_details`
--

CREATE TABLE `sub_depts_project_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `dept_id` int(10) UNSIGNED DEFAULT NULL,
  `sub_dept_id` int(11) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_details`
--

CREATE TABLE `task_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED DEFAULT 12,
  `created_by` int(10) UNSIGNED DEFAULT 12,
  `task_subject` varchar(255) DEFAULT NULL,
  `task_description` text DEFAULT NULL,
  `task_remark` text DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 0,
  `is_complete` tinyint(4) DEFAULT 0 COMMENT '1=>Open,2=>Re-open, 3=> under review, 4=>close',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `responsible_person` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT 0,
  `deleted_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_code` varchar(255) DEFAULT NULL,
  `user_type_id` int(11) DEFAULT NULL,
  `reporting_id` int(11) DEFAULT NULL,
  `desig_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `sub_dept_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `alt_mobile_no` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `tier_user` tinyint(4) DEFAULT 0 COMMENT '''1'' => ''Tier - 1'', ''2''=>''Tier - 2'',''3''=>''Tier - 3'',''0''=>''Not available''',
  `is_deleted` tinyint(4) DEFAULT 0,
  `delete_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `emp_code`, `user_type_id`, `reporting_id`, `desig_id`, `dept_id`, `sub_dept_id`, `first_name`, `last_name`, `email`, `dob`, `mobile_no`, `alt_mobile_no`, `email_verified_at`, `password`, `remember_token`, `is_active`, `created_at`, `updated_at`, `profile_pic`, `role_id`, `tier_user`, `is_deleted`, `delete_date`) VALUES
(1, 'OASYS-TSPL', NULL, 7, 7, 7, NULL, 'Managing', 'Director', 'admin@gmail.com', '2023-06-01', '8888888888', NULL, NULL, '$2y$10$8KXzZL333p2Wnilpt1OgNeL/YaxZVolQVlf07qdu/wOBcABeMvoZe', NULL, 1, '2023-06-09 07:25:17', '2023-06-09 07:25:17', NULL, 2, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_details`
--

CREATE TABLE `users_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `reporting_designation_id` int(11) NOT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign_observer_users_details`
--
ALTER TABLE `assign_observer_users_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_users_details`
--
ALTER TABLE `assign_users_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment_details`
--
ALTER TABLE `comment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departs_project_details`
--
ALTER TABLE `departs_project_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `project_assign_details`
--
ALTER TABLE `project_assign_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_masters`
--
ALTER TABLE `project_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reporting_desig_details`
--
ALTER TABLE `reporting_desig_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sub_departments`
--
ALTER TABLE `sub_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_depts_project_details`
--
ALTER TABLE `sub_depts_project_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_details`
--
ALTER TABLE `task_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_details`
--
ALTER TABLE `users_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign_observer_users_details`
--
ALTER TABLE `assign_observer_users_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_users_details`
--
ALTER TABLE `assign_users_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment_details`
--
ALTER TABLE `comment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `departs_project_details`
--
ALTER TABLE `departs_project_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_assign_details`
--
ALTER TABLE `project_assign_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project_masters`
--
ALTER TABLE `project_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reporting_desig_details`
--
ALTER TABLE `reporting_desig_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sub_departments`
--
ALTER TABLE `sub_departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sub_depts_project_details`
--
ALTER TABLE `sub_depts_project_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_details`
--
ALTER TABLE `task_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users_details`
--
ALTER TABLE `users_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
