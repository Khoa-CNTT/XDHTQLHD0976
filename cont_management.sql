-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 08, 2025 lúc 07:52 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `cont_management`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `contract_number` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Chờ xử lý','Hoạt động','Hoàn thành','Đã huỷ') NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `signed_document` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contracts`
--

INSERT INTO `contracts` (`id`, `service_id`, `contract_number`, `start_date`, `end_date`, `status`, `total_price`, `signed_document`, `created_at`, `updated_at`) VALUES
(1, 3, '001', '2025-04-08', '2025-04-19', 'Hoạt động', 100000.00, NULL, '2025-04-06 10:45:20', '2025-04-07 08:46:29'),
(2, 3, '002', '2025-04-11', '2025-04-12', 'Chờ xử lý', 34243.00, NULL, '2025-04-07 08:22:31', '2025-04-07 08:38:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `tax_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `company_name`, `tax_code`, `created_at`, `updated_at`) VALUES
(2, 9, 'ngaphammm', 'TAX002', '2025-04-04 23:55:07', '2025-04-04 23:55:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `hired_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `position`, `department`, `salary`, `hired_date`, `created_at`, `updated_at`) VALUES
(1, 10, 'Nhân viên IT', 'Công nghệ thông tin', 10000000.00, '2025-04-01', '2025-04-05 08:00:35', '2025-04-05 08:00:35'),
(2, 11, 'Nhân viên Kế toán', 'Kế toán', 8000000.00, '2025-03-15', '2025-04-05 08:00:35', '2025-04-05 08:00:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
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
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_06_030242_add_remember_token_to_users_table', 2),
(5, '2025_04_06_030449_create_permissions_table', 2),
(6, '2025_04_06_174343_remove_customer_id_from_contracts_table', 2),
(7, '2025_04_06_175502_update_contracts_table', 3),
(8, '2025_04_07_161710_add_customer_name_and_email_to_signatures_table', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('okamibada@gmail.com', '$2y$12$XTVZKwcngDaHn/bZ/m/45O.9jglR4Q1jPBE6uHmn0MZ8rwA2Sqxei', '2025-04-02 01:37:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `service_name`, `description`, `service_type`, `price`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 'Hợp đồng Cung Cấp Dịch Vụ Quản Trị Mạng và Hệ Thống Máy Chủ', 'Hợp đồng này quy định các dịch vụ quản trị mạng và hệ thống máy chủ, bao gồm việc quản lý, duy trì, bảo trì, và hỗ trợ các hệ thống CNTT của khách hàng nhằm đảm bảo hoạt động ổn định và hiệu quả.', 'Phần mềm', 5000000.00, 2, '2025-04-05 08:04:29', '2025-04-07 07:18:01'),
(5, 'Hợp đồng cung cấp dịch vụ công nghệ thông tin và giải pháp điện tử', 'Hợp đồng cung cấp dịch vụ công nghệ thông tin và giải pháp điện tử', 'Phần mềm', 500000.00, 2, '2025-04-07 07:28:29', '2025-04-07 07:28:29'),
(9, 'ccc', 'cc', 'Phần mềm', 4.00, 2, '2025-04-07 07:53:32', '2025-04-07 07:53:32'),
(10, 'cccc', 'cc3', 'Phần mềm', 34.00, 2, '2025-04-07 08:12:57', '2025-04-07 08:12:57'),
(11, 'vv', 'vv', 'Phần mềm', 42.00, 2, '2025-04-07 08:13:39', '2025-04-07 08:13:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('DT4mDd7zSmcyD1kOm1xCEbWbzfSnpKl1ZWEV2yNu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'ZXlKcGRpSTZJbk5PUkdaSEwza3dUbHBVVkhWcmVYZG1OR0V2TlhjOVBTSXNJblpoYkhWbElqb2lVMVphU0c0MFprVXdiMWxsWmpOUVQyWmlTR2RUWlVGMVdsbFFVSEJ1ZUVJeFkxaFZNalIwTkcxQmFuSlFUR28wT0ZaUWRqVjVORFE1UmxCMmREbHFla3BhYVRKWWEzbGhSbkJ6WkZCdE9HUjFMMnh3ZUVGcVNVRlJSMGx4YjBaSVRtczJNR1J3S3pKaFdFNVhkSHBqZEhCV1pXcFpTbFpLZDA1dVExUktSbEJsUzB0dFJXbHlRMnd5Vm5keFoySnNkRXBFTUVwS05VdzBXVE5rYTBOMlFWSmhhV2Q2U3k5SU0waEJPV1ZRTVRsT2FVbG1hVEJsV1dOMU5HWnZWMXBFZEV3MGRYSTFRV0pDTHpGM09DdGpPWEZNUjIxV2VqTm5LeTh4Y0dOalMxVnBRWE5UTVVkc01rRmhiSGhrUjBSMGNtNUtObWxpYVhGUFlYbHFTR2RHWmtZemREQkZlREJMUzIxeVNFRk9kbnB4YUVKamVHYzlQU0lzSW0xaFl5STZJbVk1WkRGbFpqRTFZVFU0WTJKaVlUaG1NamhoTjJZNU1qazRZMkU0T1RRNU0yWTBNVFU1TURZMk1qTXpOelV6WXpSbVlXWTFabUppTldGak0yUmxaVGdpTENKMFlXY2lPaUlpZlE9PQ==', 1744038904),
('h43VyXLTV6i16pheaAoFNFHtrQ477dknP7r7ecW1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'ZXlKcGRpSTZJbHA0YVhWbFFuVlFTM1pSZGtsd0wyWlJPRXBPWjJjOVBTSXNJblpoYkhWbElqb2liVWxrYlRoTVpIWmxOVTFYV2xKYWRXNURiVmxYU2tsb1NFeHVkV0ZqUlRoYVNsZDFTUzlGVms1elEwbFNiekJ3VEdodFZISlhNbEExV1V0c2NXWm5kR2s1ZVRnclJIUlpTVVIxZUdkT1NGTk1VemRzYjJ4UE1ucFRNRkkyZG1kVFVtMHdibGxxWVhSSFMzYzRkWGMyVGpGNFJVY3pOMm94Ym5jNVkybHhaU3RZVkc0d1IxWmpWMWx5Y0dzeU9IQllURFIzT1VOVmNVeHpUalpuTlROQk5TOXhRWFZYUXpKb1drc3JRVGN3YWpsbk1qZGhORnBHVTJkcFdXMUZTVWcyVURZMVdEZHJiUzlVVVhKS1RVMTRielp1UW5kd1psaEdjV2x4VEVwVGJsbEROSGdyVlV4Tk9ERXdhR0ZzU1ZSeWNFOHpXSGRzYmtndmRtTlNXRzFRVkcxVlRUZHBRVTlwVWs5SFR6VTVUa2hUTjJkNlRVRTlQU0lzSW0xaFl5STZJbUk1Tm1ObE16UmpORFprTVRobVpqTXdabVF3WVdGbE56VmpNamxqTVRkbE5UWm1NbVF3WW1ReE4yWmtNbUl3TXpCbFlXTTBORFZrWVRCbE5ESXdPV01pTENKMFlXY2lPaUlpZlE9PQ==', 1744091504),
('ThjVcl8V0m00duPCK6SZnpSsNl1icio61yAHB2VY', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'ZXlKcGRpSTZJa1JWVkcxRGFURklUSG8yY2tSbFVFVXhWek5tVUZFOVBTSXNJblpoYkhWbElqb2lTbVo2TVd4R1RtSTNLekl4Um5oSVVWVkVLMWQ2UkVSRlFuZGtRMjFFV2sxME5YbzNTbEpyVVVOV0szaFBVMHByT0VkcGNtaHhaMUI0VWpaa2NqaFpZbUUzZW14dlZDdDZha1ZoTUdKUWJGUldabEpsV2tsbVVGZHJUalpEVTB4Vk5uSnRiR1Z1Wm1zelVuTndaRlIwVUhNNVJUUjNUQ3M1Vm5acmJub3dSaXRYWWtGSk9VaFBZbFp3WWxKRVVtaEhTRzVxTnpWUk0xQktLMWh6UkRFNWVtNUJiblFyZVVSSVpqRlBaWFZGZFdWMlFsSm1UVkppTUM5clpuWlpUMjB5WjBkNVJHcHplWGhTZEU5blZHdExWa05HTDBSSVpGcEZja3RVZUN0c2RVaElWVzlUZUdONGNFRjFkakE0ZFVSdlowOWpUM2RvUjFsbUsybDJkRFJOU1hOclJubzFjWFpFU21KRFVtVlliMWxJWkZSNVYxZzNiRnBvVEhvclpFZ3djSFIyZGpSR1dFRnRLMUpJYkV0YWVWZzFhM053V1ZkUWRXbGtkSE5uZDNaQ1kyMTJPV2xQVUhONWIyVkZibkF4ZFVKTGRpOTBVamhyTVVRd1RqTkhVRmRxTm1GM1QyaEtORlFyTVVaMlVpdGFNM1lyTjBFd2QxbFJhMWhFZWt0MlptMVVWRFJrV1hRMmNtVjVkMWN2VVM5TlVHdFJkejA5SWl3aWJXRmpJam9pWVRJeE1HWmpaV0UxWkRrek1HUXhObVExT1RObU5qVTJOamd3WkRRMlkyUmpZemd4WlRWbU5qTm1OV1V5WTJFNFkyTTJORFEyTURCaU5UQXdNRGcwTXlJc0luUmhaeUk2SWlKOQ==', 1744044817);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `signatures`
--

CREATE TABLE `signatures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `signature_data` text NOT NULL,
  `signed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee','customer') NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `address`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'User', 'user@gmail.com', '$2y$12$RMop/HL4MYed8hA1U4yC/OsPad1S.7f1JRtrk/wsONxoJfWxUQByi', 'employee', '0123456789', 'Đà Nẵng', '2025-04-02 00:23:52', '2025-04-02 00:23:52', NULL),
(2, 'Admin', 'admin@gmail.com', '$2y$12$87zbSUJenTUoyqsdLU029uj5pV1YlSEtMFKv.0bGFAWphKaXpLEfi', 'admin', '0123456789', 'Hà Nội', '2025-04-02 00:22:39', '2025-04-02 00:22:39', NULL),
(9, 'ngapham', 'okamibada@gmail.com', '$2y$12$33n3YkWig1mmCvaWj4/wQekpPq7ulLPw5dd.Gw2p9j1c8jkumDaoy', 'customer', '0987653214', '12312313123', '2025-04-04 23:55:07', '2025-04-04 23:55:07', NULL),
(10, 'Nguyễn Văn A', 'nguyenvana@example.com', '$2y$12$omKYbFq8TuGPG5D/mi/9pO9nrSptwCS9nQWv9V45Di88ZdWq1amSy', 'employee', NULL, NULL, '2025-04-05 08:00:35', '2025-04-05 08:00:35', NULL),
(11, 'Trần Thị B', 'tranthib@example.com', '$2y$12$WbfoT3J2SZMWA6KFbg5VWu/nW3r0u.yG5iGphUA41XzBQS/JhzeAG', 'employee', NULL, NULL, '2025-04-05 08:00:35', '2025-04-05 08:00:35', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contracts_contract_number_unique` (`contract_number`),
  ADD KEY `contracts_service_id_foreign` (`service_id`);

--
-- Chỉ mục cho bảng `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_contract_id_foreign` (`contract_id`);

--
-- Chỉ mục cho bảng `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_created_by_foreign` (`created_by`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `signatures`
--
ALTER TABLE `signatures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `signatures_contract_id_foreign` (`contract_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `signatures`
--
ALTER TABLE `signatures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `signatures`
--
ALTER TABLE `signatures`
  ADD CONSTRAINT `signatures_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
