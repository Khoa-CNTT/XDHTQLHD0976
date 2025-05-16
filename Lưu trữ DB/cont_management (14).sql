-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 16, 2025 lúc 02:06 PM
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
-- Cấu trúc bảng cho bảng `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `created_at`) VALUES
(13, 17, 'Đổi mật khẩu', 'Bạn đã thay đổi mật khẩu thành công', '2025-05-13 12:11:51'),
(14, 17, 'Gửi yêu cầu hỗ trợ', 'Bạn đã gửi một yêu cầu hỗ trợ mới: Hỗ trợ thanh toán', '2025-05-14 15:45:06'),
(15, 17, 'Cập nhật ảnh đại diện', 'Bạn đã cập nhật ảnh đại diện', '2025-05-15 05:49:22'),
(16, 17, 'Gửi yêu cầu hỗ trợ', 'Bạn đã gửi một yêu cầu hỗ trợ mới: Hỗ trợ thanh toán', '2025-05-15 06:24:33'),
(17, 17, 'Gửi yêu cầu hỗ trợ', 'Bạn đã gửi một yêu cầu hỗ trợ mới: cấcc', '2025-05-15 06:42:44'),
(18, 17, 'Gửi yêu cầu hỗ trợ', 'Bạn đã gửi một yêu cầu hỗ trợ mới: Hỗ Trợ Thanh Toán', '2025-05-15 06:46:03'),
(19, 17, 'Cập nhật ảnh đại diện', 'Bạn đã cập nhật ảnh đại diện', '2025-05-15 06:54:30'),
(20, 17, 'Cập nhật thông tin cá nhân', 'Bạn đã cập nhật thông tin cá nhân, đã thay đổi số điện thoại từ 0987653214 thành 0987653253', '2025-05-15 07:04:06'),
(21, 17, 'Cập nhật ảnh đại diện', 'Bạn đã cập nhật ảnh đại diện', '2025-05-15 07:14:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_otp_okamibada@gmail.com', 'i:412618;', 1747397050);

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
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `contract_number` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Chờ xử lý','Hoàn thành','Đã huỷ','Yêu cầu huỷ') NOT NULL DEFAULT 'Chờ xử lý',
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contracts`
--

INSERT INTO `contracts` (`id`, `service_id`, `customer_id`, `contract_number`, `start_date`, `end_date`, `status`, `total_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(33, 19, 7, 'HD-1747215055', '2025-05-14', '2028-05-14', 'Hoàn thành', 10000000.00, '2025-05-14 09:30:55', '2025-05-14 12:59:55', NULL),
(34, 19, 8, 'HD-1747222673', '2025-05-14', '2026-05-14', 'Hoàn thành', 500000.00, '2025-05-14 11:37:53', '2025-05-14 11:51:26', NULL),
(35, 63, 7, 'HD-1747396668', '2025-05-16', '2030-05-16', 'Chờ xử lý', 4000000.00, '2025-05-16 11:57:48', '2025-05-16 11:57:48', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contract_amendments`
--

CREATE TABLE `contract_amendments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `amendment_reason` text NOT NULL,
  `changes_made` text NOT NULL,
  `effective_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contract_documents`
--

CREATE TABLE `contract_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contract_durations`
--

CREATE TABLE `contract_durations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `duration_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contract_durations`
--

INSERT INTO `contract_durations` (`id`, `service_id`, `duration_id`, `price`, `created_at`, `updated_at`) VALUES
(1, 19, 4, 5000000.00, '2025-05-12 13:38:13', '2025-05-12 13:38:13'),
(2, 19, 2, 500000.00, '2025-05-12 13:38:13', '2025-05-12 13:38:13'),
(3, 19, 3, 10000000.00, '2025-05-12 13:38:13', '2025-05-12 13:38:13'),
(7, 21, 2, 1000000.00, '2025-05-14 11:54:57', '2025-05-14 11:54:57'),
(8, 21, 3, 3000000.00, '2025-05-14 11:54:57', '2025-05-14 11:54:57'),
(9, 21, 4, 4000000.00, '2025-05-14 11:54:57', '2025-05-14 11:54:57'),
(10, 20, 2, 1000000.00, '2025-05-14 11:55:10', '2025-05-14 11:55:10'),
(11, 20, 3, 3000000.00, '2025-05-14 11:55:10', '2025-05-14 11:55:10'),
(12, 20, 4, 4000000.00, '2025-05-14 11:55:10', '2025-05-14 11:55:10'),
(13, 60, 2, 1000000.00, '2025-05-14 11:55:38', '2025-05-14 11:55:38'),
(14, 60, 3, 3000000.00, '2025-05-14 11:55:38', '2025-05-14 11:55:38'),
(15, 60, 4, 4000000.00, '2025-05-14 11:55:38', '2025-05-14 11:55:38'),
(16, 61, 2, 1000000.00, '2025-05-14 11:55:50', '2025-05-14 11:55:50'),
(17, 61, 3, 3000000.00, '2025-05-14 11:55:50', '2025-05-14 11:55:50'),
(18, 61, 4, 4000000.00, '2025-05-14 11:55:50', '2025-05-14 11:55:50'),
(19, 62, 2, 1000000.00, '2025-05-14 11:58:19', '2025-05-14 11:58:19'),
(20, 62, 3, 3000000.00, '2025-05-14 11:58:19', '2025-05-14 11:58:19'),
(21, 62, 4, 4000000.00, '2025-05-14 11:58:19', '2025-05-14 11:58:19'),
(22, 63, 2, 1000000.00, '2025-05-14 11:58:33', '2025-05-14 11:58:33'),
(23, 63, 3, 3000000.00, '2025-05-14 11:58:33', '2025-05-14 11:58:33'),
(24, 63, 4, 4000000.00, '2025-05-14 11:58:33', '2025-05-14 11:58:33'),
(25, 64, 2, 1000000.00, '2025-05-14 11:58:58', '2025-05-14 11:58:58'),
(26, 64, 3, 3000000.00, '2025-05-14 11:58:58', '2025-05-14 11:58:58'),
(27, 64, 4, 4000000.00, '2025-05-14 11:58:58', '2025-05-14 11:58:58'),
(28, 65, 2, 1000000.00, '2025-05-14 11:59:11', '2025-05-14 11:59:11'),
(29, 65, 3, 3000000.00, '2025-05-14 11:59:11', '2025-05-14 11:59:11'),
(30, 65, 4, 4000000.00, '2025-05-14 11:59:11', '2025-05-14 11:59:11'),
(31, 66, 2, 1000000.00, '2025-05-14 11:59:24', '2025-05-14 11:59:24'),
(32, 66, 3, 3000000.00, '2025-05-14 11:59:24', '2025-05-14 11:59:24'),
(33, 66, 4, 4000000.00, '2025-05-14 11:59:24', '2025-05-14 11:59:24'),
(34, 67, 2, 1000000.00, '2025-05-14 11:59:37', '2025-05-14 11:59:37'),
(35, 67, 3, 3000000.00, '2025-05-14 11:59:37', '2025-05-14 11:59:37'),
(36, 67, 4, 4000000.00, '2025-05-14 11:59:37', '2025-05-14 11:59:37'),
(37, 68, 2, 1000000.00, '2025-05-14 11:59:51', '2025-05-14 11:59:51'),
(38, 68, 3, 3000000.00, '2025-05-14 11:59:51', '2025-05-14 11:59:51'),
(39, 68, 4, 4000000.00, '2025-05-14 11:59:51', '2025-05-14 11:59:51'),
(40, 69, 2, 1000000.00, '2025-05-14 12:00:08', '2025-05-14 12:00:08'),
(41, 69, 3, 3000000.00, '2025-05-14 12:00:08', '2025-05-14 12:00:08'),
(42, 69, 4, 4000000.00, '2025-05-14 12:00:08', '2025-05-14 12:00:08'),
(43, 70, 2, 1000000.00, '2025-05-14 12:00:37', '2025-05-14 12:00:37'),
(44, 70, 3, 3000000.00, '2025-05-14 12:00:37', '2025-05-14 12:00:37'),
(45, 70, 4, 4000000.00, '2025-05-14 12:00:37', '2025-05-14 12:00:37'),
(46, 71, 2, 1000000.00, '2025-05-14 12:00:51', '2025-05-14 12:00:51'),
(47, 71, 3, 3000000.00, '2025-05-14 12:00:51', '2025-05-14 12:00:51'),
(48, 71, 4, 4000000.00, '2025-05-14 12:00:51', '2025-05-14 12:00:51'),
(49, 72, 2, 1000000.00, '2025-05-14 12:01:25', '2025-05-14 12:01:25'),
(50, 72, 3, 3000000.00, '2025-05-14 12:01:25', '2025-05-14 12:01:25'),
(51, 72, 4, 4000000.00, '2025-05-14 12:01:25', '2025-05-14 12:01:25'),
(52, 73, 2, 1000000.00, '2025-05-14 12:01:41', '2025-05-14 12:01:41'),
(53, 73, 3, 3000000.00, '2025-05-14 12:01:41', '2025-05-14 12:01:41'),
(54, 73, 4, 30000000.00, '2025-05-14 12:01:41', '2025-05-14 12:01:41'),
(55, 74, 2, 1000000.00, '2025-05-14 12:01:55', '2025-05-14 12:01:55'),
(56, 74, 3, 3000000.00, '2025-05-14 12:01:55', '2025-05-14 12:01:55'),
(57, 74, 4, 4000000.00, '2025-05-14 12:01:55', '2025-05-14 12:01:55'),
(58, 77, 2, 1000000.00, '2025-05-14 12:02:08', '2025-05-14 12:02:08'),
(59, 77, 3, 3000000.00, '2025-05-14 12:02:08', '2025-05-14 12:02:08'),
(60, 77, 4, 4000000.00, '2025-05-14 12:02:08', '2025-05-14 12:02:08'),
(61, 78, 2, 1000000.00, '2025-05-14 12:02:21', '2025-05-14 12:02:21'),
(62, 78, 3, 3000000.00, '2025-05-14 12:02:21', '2025-05-14 12:02:21'),
(63, 78, 4, 4000000.00, '2025-05-14 12:02:21', '2025-05-14 12:02:21'),
(64, 79, 2, 1000000.00, '2025-05-14 12:02:43', '2025-05-14 12:02:43'),
(65, 79, 3, 3000000.00, '2025-05-14 12:02:43', '2025-05-14 12:02:43'),
(66, 79, 4, 4000000.00, '2025-05-14 12:02:43', '2025-05-14 12:02:43'),
(67, 80, 2, 1000000.00, '2025-05-14 12:03:07', '2025-05-14 12:03:07'),
(68, 80, 3, 3000000.00, '2025-05-14 12:03:07', '2025-05-14 12:03:07'),
(69, 80, 4, 4000000.00, '2025-05-14 12:03:07', '2025-05-14 12:03:07'),
(70, 81, 2, 1000000.00, '2025-05-14 12:03:20', '2025-05-14 12:03:20'),
(71, 81, 3, 3000000.00, '2025-05-14 12:03:20', '2025-05-14 12:03:20'),
(72, 81, 4, 4000000.00, '2025-05-14 12:03:20', '2025-05-14 12:03:20'),
(73, 83, 2, 1000000.00, '2025-05-14 12:03:49', '2025-05-14 12:03:49'),
(74, 83, 3, 3000000.00, '2025-05-14 12:03:49', '2025-05-14 12:03:49'),
(75, 83, 4, 4000000.00, '2025-05-14 12:03:49', '2025-05-14 12:03:49'),
(76, 84, 2, 1000000.00, '2025-05-14 12:04:06', '2025-05-14 12:04:06'),
(77, 84, 3, 3000000.00, '2025-05-14 12:04:06', '2025-05-14 12:04:06'),
(78, 84, 4, 4000000.00, '2025-05-14 12:04:06', '2025-05-14 12:04:06'),
(79, 86, 2, 1000000.00, '2025-05-14 12:04:19', '2025-05-14 12:04:19'),
(80, 86, 3, 3000000.00, '2025-05-14 12:04:19', '2025-05-14 12:04:19'),
(81, 86, 4, 4000000.00, '2025-05-14 12:04:19', '2025-05-14 12:04:19'),
(82, 87, 2, 1000000.00, '2025-05-14 12:04:42', '2025-05-14 12:04:42'),
(83, 87, 3, 3000000.00, '2025-05-14 12:04:42', '2025-05-14 12:04:42'),
(84, 87, 4, 4000000.00, '2025-05-14 12:04:42', '2025-05-14 12:04:42'),
(85, 89, 2, 1000000.00, '2025-05-14 12:04:56', '2025-05-14 12:04:56'),
(86, 89, 3, 3000000.00, '2025-05-14 12:04:56', '2025-05-14 12:04:56'),
(87, 89, 4, 4000000.00, '2025-05-14 12:04:56', '2025-05-14 12:04:56'),
(88, 102, 2, 1000000.00, '2025-05-14 12:05:14', '2025-05-14 12:05:14'),
(89, 102, 3, 3000000.00, '2025-05-14 12:05:14', '2025-05-14 12:05:14'),
(90, 102, 4, 4000000.00, '2025-05-14 12:05:14', '2025-05-14 12:05:14');

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `company_name`, `tax_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 13, 'cty abc', '0509', '2025-04-10 21:12:22', '2025-04-10 21:12:22', NULL),
(5, 14, 'Ngapham23', '0987654321100', '2025-04-13 01:07:45', '2025-04-13 01:07:45', NULL),
(6, 15, 'Hà Nội', '1234567890', '2025-04-27 01:28:18', '2025-04-27 01:28:18', NULL),
(7, 17, 'ngaphammm', '0987654321023', '2025-05-12 14:35:33', '2025-05-12 14:35:33', NULL),
(8, 19, 'Công ty TNHH MMT', '0000020000000', '2025-05-13 12:06:49', '2025-05-13 12:06:49', NULL),
(9, 20, 'đanna', '3801255679', '2025-05-14 09:06:38', '2025-05-14 09:06:38', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `durations`
--

CREATE TABLE `durations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `months` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `durations`
--

INSERT INTO `durations` (`id`, `label`, `months`, `created_at`, `updated_at`) VALUES
(2, '1 Năm', 12, '2025-05-12 08:38:49', '2025-05-12 08:38:49'),
(3, '3 Năm', 36, '2025-05-12 08:38:49', '2025-05-12 08:38:49'),
(4, '5 năm', 60, '2025-05-12 09:28:05', '2025-05-12 16:59:15');

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
(6, 21, 'Nhân Viên', 'Kinh Doanh', 50000000.00, '2025-05-16', '2025-05-14 09:17:13', '2025-05-14 09:17:32'),
(7, 22, 'Nhân Viên', 'Kinh Doanh', 1000000.00, '2025-05-24', '2025-05-15 07:01:50', '2025-05-15 07:01:50');

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
(8, '2025_04_07_161710_add_customer_name_and_email_to_signatures_table', 4),
(9, '2025_04_08_080841_add_content_to_services_table', 5),
(10, '2025_04_13_075201_add_status_to_users_table', 6),
(11, '2025_04_23_053048_add_image_to_services_table', 7),
(12, '2025_04_24_160742_add_identity_card_to_users_table', 8),
(13, '2025_04_24_164725_add_duration_and_status_to_signatures_table', 9),
(14, '2025_04_25_085025_add_customer_id_to_contracts_table', 10),
(15, '2025_05_01_055336_add_momo_fields_to_payments_table', 11),
(16, '2025_05_01_132452_add_momo_fields_to_payments_table', 12),
(17, '2025_05_03_131510_remove_service_type_from_services_table', 13),
(18, '2025_05_08_011240_add_end_date_to_contracts_table', 14),
(19, '2024_05_20_create_support_responses_table', 15),
(20, '2025_05_11_233236_add_created_by_to_notifications_table', 16),
(21, '2025_05_12_000049_add_type_to_notifications_table', 17),
(22, 'create_admin_signature_fields', 18),
(23, '2025_05_15_115001_add_staff_id_to_support_tickets_table', 19),
(24, '2025_05_15_125649_add_assigned_employee_id_to_support_tickets_table', 20);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `created_by`, `type`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(100, 17, 'admin', NULL, 'sada', 'sadasd', 1, '2025-05-12 16:38:12', '2025-05-12 17:03:51'),
(101, 17, 'admin', NULL, 'ngu vl', '213213', 1, '2025-05-14 06:47:30', '2025-05-14 06:48:45'),
(102, 17, 'admin', NULL, 'sa', 'ád', 1, '2025-05-14 06:49:29', '2025-05-14 06:54:05'),
(103, 17, 'admin', NULL, 'sdadad', '213414', 1, '2025-05-14 06:49:45', '2025-05-14 06:54:05'),
(104, 17, 'admin', NULL, 'asdads', 'scac', 1, '2025-05-14 06:56:37', '2025-05-14 06:56:44'),
(105, 13, 'admin', NULL, 'Hệ thống sẽ bảo trì lúc 22:00 ngày 20/05/2025 (2025-05-18 10:00)', '-cập nhập thanh toán', 0, '2025-05-14 15:28:51', '2025-05-14 15:28:51'),
(106, 15, 'admin', NULL, 'Hệ thống sẽ bảo trì lúc 22:00 ngày 20/05/2025 (2025-05-18 10:00)', '-cập nhập thanh toán', 0, '2025-05-14 15:28:51', '2025-05-14 15:28:51'),
(107, 17, 'admin', NULL, 'Hệ thống sẽ bảo trì lúc 22:00 ngày 20/05/2025 (2025-05-18 10:00)', '-cập nhập thanh toán', 1, '2025-05-14 15:28:51', '2025-05-14 15:29:01'),
(108, 19, 'admin', NULL, 'Hệ thống sẽ bảo trì lúc 22:00 ngày 20/05/2025 (2025-05-18 10:00)', '-cập nhập thanh toán', 0, '2025-05-14 15:28:51', '2025-05-14 15:28:51'),
(109, 20, 'admin', NULL, 'Hệ thống sẽ bảo trì lúc 22:00 ngày 20/05/2025 (2025-05-18 10:00)', '-cập nhập thanh toán', 0, '2025-05-14 15:28:51', '2025-05-14 15:28:51'),
(110, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-14 15:46:27', '2025-05-15 05:48:37'),
(111, 17, 'admin', NULL, 'heheh', 'heheh', 1, '2025-05-15 04:27:30', '2025-05-15 05:48:37'),
(112, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-15 04:37:38', '2025-05-15 05:48:37'),
(113, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-15 04:37:51', '2025-05-15 05:48:37'),
(114, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-15 04:39:27', '2025-05-15 05:48:37'),
(115, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-15 04:39:29', '2025-05-15 05:48:37'),
(116, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-15 04:39:33', '2025-05-15 05:48:37'),
(117, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-15 04:39:37', '2025-05-15 05:48:37'),
(118, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-15 04:39:42', '2025-05-15 05:48:37'),
(119, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-15 04:39:47', '2025-05-15 05:48:37'),
(120, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-15 04:40:56', '2025-05-15 05:48:37'),
(121, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-15 04:40:59', '2025-05-15 05:48:37'),
(122, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-15 04:41:02', '2025-05-15 05:48:37'),
(123, 17, NULL, NULL, 'Phản hồi yêu cầu hỗ trợ', 'Yêu cầu hỗ trợ \"Hỗ trợ thanh toán\" đã được phản hồi.', 1, '2025-05-15 04:41:51', '2025-05-15 05:48:37'),
(124, 2, NULL, NULL, 'Phản hồi mới từ khách hàng', 'Khách hàng \"ngapham\" đã phản hồi yêu cầu hỗ trợ #3', 0, '2025-05-15 05:49:10', '2025-05-15 05:49:10'),
(125, 21, NULL, NULL, 'Phản hồi mới từ khách hàng', 'Khách hàng \"ngapham\" đã phản hồi yêu cầu hỗ trợ #3', 0, '2025-05-15 05:49:10', '2025-05-15 05:49:10'),
(126, 2, NULL, NULL, 'Phản hồi mới từ khách hàng', 'Khách hàng \"ngapham\" đã phản hồi yêu cầu hỗ trợ #1', 0, '2025-05-15 08:22:05', '2025-05-15 08:22:05'),
(127, 21, NULL, NULL, 'Phản hồi mới từ khách hàng', 'Khách hàng \"ngapham\" đã phản hồi yêu cầu hỗ trợ #1', 0, '2025-05-15 08:22:05', '2025-05-15 08:22:05'),
(128, 22, NULL, NULL, 'Phản hồi mới từ khách hàng', 'Khách hàng \"ngapham\" đã phản hồi yêu cầu hỗ trợ #1', 0, '2025-05-15 08:22:05', '2025-05-15 08:22:05'),
(129, 2, NULL, NULL, 'Phản hồi mới từ khách hàng', 'Khách hàng \"ngapham\" đã phản hồi yêu cầu hỗ trợ #1', 0, '2025-05-15 08:22:20', '2025-05-15 08:22:20'),
(130, 21, NULL, NULL, 'Phản hồi mới từ khách hàng', 'Khách hàng \"ngapham\" đã phản hồi yêu cầu hỗ trợ #1', 0, '2025-05-15 08:22:20', '2025-05-15 08:22:20'),
(131, 22, NULL, NULL, 'Phản hồi mới từ khách hàng', 'Khách hàng \"ngapham\" đã phản hồi yêu cầu hỗ trợ #1', 0, '2025-05-15 08:22:20', '2025-05-15 08:22:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `contract_duration_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `method` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_response` text DEFAULT NULL,
  `request_id` varchar(255) DEFAULT NULL,
  `partner_code` varchar(255) DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `ipn_response` text DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `status` enum('Hoàn Thành','Đã Huỷ','Đang Đợi','Đang Xử Lý','Thất Bại') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `contract_id`, `contract_duration_id`, `amount`, `date`, `method`, `transaction_id`, `order_id`, `payment_type`, `payment_response`, `request_id`, `partner_code`, `signature`, `ipn_response`, `error_message`, `status`, `created_at`, `updated_at`) VALUES
(34, 33, 3, 10000000.00, '2025-05-14', 'VNPay', '14956616', '33-1747215293', 'ATM', '{\"vnp_Amount\":\"1000000000\",\"vnp_BankCode\":\"NCB\",\"vnp_BankTranNo\":\"VNP14956616\",\"vnp_CardType\":\"ATM\",\"vnp_OrderInfo\":\"Thanh toan don hang\",\"vnp_PayDate\":\"20250514163554\",\"vnp_ResponseCode\":\"00\",\"vnp_TmnCode\":\"O5KTL29X\",\"vnp_TransactionNo\":\"14956616\",\"vnp_TransactionStatus\":\"00\",\"vnp_TxnRef\":\"33-1747215293\",\"vnp_SecureHash\":\"f8e248b8d6252a5cf7f774f4f7c1f3c0c0fad65a308407decdb1ec41af42a2d63940e3cf3930b35bf02c421fa7df0aa463ad96299710eba926f2cbc9c9615217\"}', NULL, NULL, NULL, NULL, NULL, 'Hoàn Thành', '2025-05-14 09:35:32', '2025-05-14 09:35:32'),
(35, 34, 2, 500000.00, '2025-05-14', 'VNPay', '14956909', '34-1747222946', 'ATM', '{\"vnp_Amount\":\"50000000\",\"vnp_BankCode\":\"NCB\",\"vnp_BankTranNo\":\"VNP14956909\",\"vnp_CardType\":\"ATM\",\"vnp_OrderInfo\":\"Thanh toan don hang\",\"vnp_PayDate\":\"20250514185143\",\"vnp_ResponseCode\":\"00\",\"vnp_TmnCode\":\"O5KTL29X\",\"vnp_TransactionNo\":\"14956909\",\"vnp_TransactionStatus\":\"00\",\"vnp_TxnRef\":\"34-1747222946\",\"vnp_SecureHash\":\"c1197e4cca991472259467b3696a4557d9433195d60eef009e2ffab0cbfb987d11f5eb63162c4fd349e5fad029fb4bf07202f70eb3d95ae96b7c5fd006961734\"}', NULL, NULL, NULL, NULL, NULL, 'Hoàn Thành', '2025-05-14 11:51:26', '2025-05-14 11:51:26');

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
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_hot` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `service_name`, `description`, `content`, `image`, `created_by`, `created_at`, `updated_at`, `is_hot`, `category_id`, `deleted_at`) VALUES
(19, 'HOME 3_NgT (Mesh)', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', 'services/1JovvZvowJ9UO7yDvNyW7ECwSWHs7ozKf7GIbVZb.jpg', 3, '2025-04-13 23:14:48', '2025-05-03 06:49:15', 1, 3, NULL),
(20, 'Home 2_NGT MESH', 'Đường truyền Internet tốc độ 500Mbps\r\n\r\nTrang bị thêm Wifi Mesh 5/6 chỉ với 30.000đ/tháng', 'Đường truyền Internet tốc độ 500Mbps\r\n\r\nTrang bị thêm Wifi Mesh 5/6 chỉ với 30.000đ/tháng', 'services/Xr3saG0IKWg33biYULRBBYUdmCgK0RfsI2Y3w4QK.jpg', NULL, '2025-04-10 01:30:46', '2025-05-03 07:14:10', 1, 3, NULL),
(21, 'HOME 4_NgT (Mesh)', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', '1. Ưu đãi gói cước\r\n- Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\n- Trang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\n+  Wifi Mesh 5: \r\n     * Wifi Mesh 5 iGate EW12ST là sự kết hợp giữa chuẩn Wifi 5 và công nghệ Mesh Wifi, phù hợp với hộ gia đình với mọi cấu trúc nhà ở. \r\n     * Tốc độ lên đến 1200Mbps trên cả 2 băng tần 2,4-5GHz\r\n     * Kết nối liền mạch, chỉ tạo tên 1 Wifi duy nhất\r\n     * Hỗ trợ đồng thời 40 thiết bị\r\n     * Cài đặt dễ dàng, triển khai linh hoạt.\r\n+ Wifi Mesh 6:\r\n     *Wifi Mesh 6 iGate EW30SX là sự kết hợp giữa chuẩn Wifi 6 và công nghệ Mesh, phù hợp với các doanh nghiệp, tổ chức vừa và nhỏ, các gia đình có nhu cầu sử dụng internet cao. \r\n     * Tốc độ lên đến 3Gbps, trên cả hai băng tần 2,4 – 5GHz\r\n     * Kết nối liền mạch, phù hợp mọi ngóc ngách\r\n     * Hỗ trợ đồng thời 100 thiết bị\r\n     * Độ trễ giảm 50%. \r\n- Lắp đặt nhanh chóng, chăm sóc và hỗ trợ khách hàng 24/7\r\n\r\n2. Cước đấu nối hòa mạng\r\n - Cước đấu nối hòa mạng áp dụng cho thuê bao đăng ký mới dịch vụ cho Khách hàng cá nhân, Hộ gia đình: 300.000 VNĐ/thuê bao (đã bao gồm VAT)\r\n\r\n3. Khu vực áp dụng\r\n - Áp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố\r\n\r\n4. Tổng đài hỗ trợ \r\n - Để được hỗ trợ về dịch vụ internet và truyền hình, Quý khách vui lòng liên hệ 1800 1166 (miễn phí)', 'services/dhsRznFd88xlLjRqbmxbjntocSGLDuB77E0EQicB.jpg', NULL, '2025-04-10 01:34:14', '2025-05-14 11:55:57', 1, 3, NULL),
(60, 'Phát triển Website Bán Hàng', 'Website thương mại điện tử hiện đại', 'Tích hợp giỏ hàng, thanh toán online, responsive.', 'services/TjYf6sBR4VkfuRtr9EzPL1pznKI48XfxTs8BjHak.jpg', 3, '2025-04-10 21:27:26', '2025-05-14 11:56:04', 1, 1, NULL),
(61, 'Ứng dụng di động Android/iOS', 'Lập trình app mobile đa nền tảng', 'Sử dụng Flutter, React Native, tích hợp API.', 'services/khDB2z0sjR4ttHlKFWsEiAqy7HiwMRnfnZphfV2C.jpg', 3, '2025-04-10 21:27:26', '2025-05-14 11:58:03', 1, 1, NULL),
(62, 'Tư vấn triển khai ERP', 'Tư vấn ERP toàn diện cho doanh nghiệp', 'Kế toán, nhân sự, bán hàng, kho, CRM.', 'services/2Y4b65MHox9WCxOvKMZR5LLH3rMgCCIDZ8LO5w8D.png', 3, '2025-04-10 21:27:26', '2025-04-29 13:26:41', 0, 1, NULL),
(63, 'Xây dựng hệ thống LMS', 'Nền tảng học trực tuyến chuyên nghiệp', 'Video, quiz, chấm điểm, chứng chỉ.', 'services/UH1gGPYAkyeSuUB7hPTSiPrqiOliQoy3cGhCaVOy.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:27:00', 0, 1, NULL),
(64, 'Tối ưu Cơ sở Dữ liệu', 'Tối ưu tốc độ và dung lượng dữ liệu', 'Query, index, backup, mô hình hóa.', 'services/ujEM9p21S3379g6zw03vMg4EPgCPpV59AKw6Vspl.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:28:34', 0, 1, NULL),
(65, 'Giải pháp CRM khách hàng', 'Quản lý khách hàng và bán hàng hiệu quả', 'Quản lý pipeline, email marketing, báo cáo.', 'services/dtOOyPjSWNgKGFqCNCS0zQOzP1gUGffrU7OC5cPr.png', 3, '2025-04-10 21:27:26', '2025-05-03 07:14:33', 0, 1, NULL),
(66, 'Dịch vụ DevOps', 'Tự động hóa CI/CD và hạ tầng', 'Docker, Jenkins, GitLab CI, cloud deploy.', 'services/a0It4W6kxOqUz6TUERtlYswPsw4kwBwgCUhUhc9o.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:30:07', 0, 1, NULL),
(67, 'Bảo mật ứng dụng Web', 'Phân tích và bảo vệ hệ thống', 'Kiểm thử lỗ hổng OWASP, tường lửa ứng dụng.', 'services/XzM84aFmFHps8HVRSSWjjxJ3Q3P5PzIWjcxlN8mP.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:30:56', 0, 1, NULL),
(68, 'Dịch vụ API Gateway', 'Tích hợp API trung gian', '...', 'services/xSVwjhOVRWYQslzMaH4q5UO60rwqd34XjmhDGQne.jpg', 3, '2025-04-10 21:27:26', '2025-05-09 21:22:45', 0, 1, NULL),
(69, 'Triển khai hệ thống Chatbot', 'Chatbot cho website, Facebook', 'Tích hợp AI, hỗ trợ khách hàng 24/7.', 'services/HfnKc7VVSZjgGry25COri0qCuScrWeeoEqi8qyuO.png', 3, '2025-04-10 21:27:26', '2025-04-29 13:31:26', 0, 1, NULL),
(70, 'Lắp đặt Camera IP', 'Triển khai giám sát văn phòng', 'Xem từ xa, ghi hình đám mây.', 'services/5o0wdDrxO52xIH0t9rIuO2GPs1Rs0bgAOEq2xtY8.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:32:00', 0, 2, NULL),
(71, 'Bảo trì máy chủ định kỳ', 'Vá lỗi, tối ưu hiệu suất server', 'Check phần cứng, OS, RAID.', 'services/R3hwPKYAq0NyncGO4dq5iRtS4QBhgpKiybk8krFG.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:32:24', 0, 2, NULL),
(72, 'Nâng cấp máy tính doanh nghiệp', 'RAM, SSD, vệ sinh thiết bị', 'Tăng hiệu suất máy văn phòng.', 'services/KB50qsTT30zQnNyPJX8ktlH7Hqua9524MPz730E2.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:32:48', 0, 2, NULL),
(73, 'Lắp đặt mạng nội bộ LAN', 'Switch, router, phân vùng mạng', 'Setup hạ tầng nội bộ.', 'services/TTvjEsVYCNWJ4M8XekJOcZFbsvkto5Cc09StjmYC.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:33:09', 0, 2, NULL),
(74, 'Cung cấp máy tính văn phòng', 'Máy bộ, màn hình, phụ kiện', 'Bảo hành 12 tháng.', 'services/RvyDUOiQOmZDL0VczKivzrIv2MHs0qKZHCSAFfcb.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:43:26', 0, 2, NULL),
(77, 'Thi công tủ rack và cáp mạng', 'Tổ chức tủ mạng chuyên nghiệp', 'Patch panel, chuẩn hóa dây cáp.', 'services/xGMhcCJuIPFFmLwTACsF9brt3xDp4Vp49LBzT6Yg.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:34:13', 0, 2, NULL),
(78, 'Cài đặt phần cứng máy chủ', 'Lắp CPU, RAM, RAID, NIC', 'Cấu hình BIOS, test ổn định.', 'services/roXAdH5gY3MNMLkG7bzLhRpje2gkEULP4atrKw4Q.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:34:47', 0, 2, NULL),
(79, 'Bảo trì thiết bị mạng', 'Switch, router, firewall', 'Firmware update, kiểm tra lỗi.', 'services/k4L11F5PcjtrvU3Tz11hloddbnMjvGGY5x6Ei4BT.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:43:49', 0, 2, NULL),
(80, 'Đăng ký Internet doanh nghiệp', 'Tốc độ cao, có IP tĩnh', 'Hỗ trợ 24/7, hợp đồng linh hoạt.', 'services/PxPzLNOneDCPgr2SPI3NpeH6auZuG4nmI1OjCJSO.png', 3, '2025-04-10 21:27:26', '2025-04-29 13:37:50', 0, 3, NULL),
(81, 'Triển khai tổng đài nội bộ (PBX)', 'Liên lạc nội bộ và gọi ngoài', 'VoIP, ghi âm, phân luồng.', 'services/SwOXBzWKh8biErzRVzUDVg0kMm4ja1EhCohzG76y.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:39:22', 0, 3, NULL),
(83, 'Triển khai mạng VPN', 'Bảo mật dữ liệu từ xa', 'OpenVPN, IPsec cho doanh nghiệp.', 'services/4sp7PAba8SMksCZ8JjJW04j1guTkNXboFZNYnfiF.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:39:38', 0, 3, NULL),
(84, 'Tư vấn an ninh mạng', 'Firewall, IDS/IPS', 'Đảm bảo an toàn hệ thống.', 'services/MpRu3kcPi8e07M9V28sZsuJgbQWZyKGHwlblSfJo.png', 3, '2025-04-10 21:27:26', '2025-05-09 21:22:04', 0, 1, NULL),
(86, 'Giám sát hệ thống mạng từ xa', 'Theo dõi uptime, cảnh báo', 'Zabbix, PRTG, email alert.', 'services/XvfwWDhzXbrxGitKEKZyCNZcNdHkXLyp0hvT68pO.jpg', 3, '2025-04-10 21:27:26', '2025-05-09 21:24:17', 0, 3, NULL),
(87, 'Cung cấp thiết bị mạng chuyên dụng', 'Router, firewall, WiFi mesh', 'Cisco, Mikrotik, Aruba.', 'services/9IHOTBgOE9tzjYq1WQPWxHHMtOnlU3urdtJYZ0QZ.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:41:00', 0, 3, NULL),
(89, 'Bảo trì định kỳ hệ thống mạng', 'Kiểm tra thiết bị và backup cấu hình', 'Khắc phục sự cố định kỳ.', 'services/xsNIYTPBm9FktUmavCB7WUPLQ1IdIvJaVrHI9mnH.jpg', 3, '2025-04-10 21:27:26', '2025-05-09 21:21:43', 0, 2, NULL),
(102, 'Dịch vụ bảo mật dữ liệu cao cấp', '123', '123', 'services/h75W6Ak1PCiodTECxwqSmyTxiUZSmoJ1sQm8yrex.jpg', 3, '2025-04-28 14:12:09', '2025-04-30 22:15:32', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Phần mềm', 'Các dịch vụ liên quan đến phần mềm', '2025-05-03 13:06:11', '2025-05-03 13:06:11'),
(2, 'Phần cứng', 'Các dịch vụ liên quan đến phần cứng', '2025-05-03 13:06:11', '2025-05-03 13:06:11'),
(3, 'Nhà mạng', 'Các dịch vụ liên quan đến nhà mạng', '2025-05-03 13:06:11', '2025-05-03 13:06:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_reviews`
--

CREATE TABLE `service_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(1) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('G0O4iy9p2CIjeg52OrTSFrKUmMjWVlvlmba4b09u', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJazEwY3pKblNHZ3JjbTlVVHl0RlNqVlZSMDV4UzBFOVBTSXNJblpoYkhWbElqb2libUZWU2sxR1dVMU9WMVkwVEM4emRuTktWVFZoTjBaRGJIaHdTMnRxU2s1S1ltZG1ZbGs1U1hscFpFNDNkRWxzU0V4MlVraENNVWhCZGtwR1pYUm9RVEZGZEUxMllVOTRiMDV0VEV0bGFqUkxORGd3Tmt4UFNsbHdRbWRxTmpCc2FsbzRLM2hFWlRnelRqUkxLMkZZY0c1ME0yTnJPWFp1U1dkNlZVbDBTVkpHUjA1amQzZG9lVWxxVFhoNFExUlBLMHBhTWpSa2FXRlNha0YwTmxWVVpFTk9SV2N3WlV0SVVEZEpSRFZ1YUVwV0sxTTNXWEZTWjFaR1NUWjJPVXBMYldoWGMyMXVPVEJWV1hJNGVFRlhPRmxCVFZBNWJXbEVialo1UlhOWVEwWklVRWxsVFdKS1VrNW9hSGRKUzJoTk5FTjBaVzA0V21KUFFTOURSRTlrUzFWNGEzRndNMHhuU3poMFVISm1SbXM0VDJWV1ZHcDVjazVUSzBWcVNFOXNSVE16Y1VWVU5uVnhiVzlYYlVjMlZHcHFlRTlXZWpKMlpYUk5XVW96V1daR0wyRkNaSEJqZFZNMGRUQTFkRVJEVlRKNVFXRmtUR1kwV1dNdlVYcElaVFJVVjFKeVkxUjNRMUZLZEhaWFRVRk1kR3MxTlVkMmNuRTRaV3BEVEZkbU4xZFpLekZ1VEdocmVXSTRXVmRUUlZaRVYxcG9SRUZHTmtWTlRXMUdWVUptVmpBNFEyNDRNbVpJV1RSRVZsbG9VREV2UWxKNU1tTkpRbXhZWmtkU1pXOTBSV3A1TkdaSmJFcDRaekUyZG5GaVV6Rk9WRVZUY2xaR2NWcEhiMFJFU2swM1pIaHBWeTltVUhob1JVTndNV1E0YVUxVVZ6VlBUbUZLS3pWRVVuRWlMQ0p0WVdNaU9pSXhZek01WlRZeE5XUmlZek5oTkdNMU9XTm1OR05tT0RnMU1qbGpZemhpTmpaaE1XTmlaVFppTXpjeE1EVmhOV1kxT0daaFpXWXpZelV4TnpjME0yUTFJaXdpZEdGbklqb2lJbjA9', 1747315011),
('jWmRmp9LOXJst2q47FnxVYHoY6oZwDOigd639Zel', 17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJa1JuUkNzNWJVZEJObVpqWVZGcGJqTm1MM0JpWW1jOVBTSXNJblpoYkhWbElqb2ljR0ZPTTNoU1kxaFZNVlZzVHpVemJEUXpTMGsyY0c4M1FuUllkMFJHYzJRMVRuUnJVWEZXZEZsVUwwSjViV05CYmt0TU1GSnZka1EyY0hCNWJDOWlaSEZVUW1sYVMzUTNaakEwUlhGeGVtOUljelJSVVdod1REWlJXbTR6Y0VRd2FFVnhhWFp6UkVKR09XdzVjRUozZFdKSFprcEtSVVJsUjNWU01FbEpZMDk1YkcxaVpsWkNkMFowWVZvMFMwWk5aMGxPWVhkYVlVZGpUbUZIZFdkRmVteDVRMWRDZFRKQlkwMDViR2d3TVRkRlJsRklNa1ZzYlhaWll6UjNXbE52TkZCeGFUTmtNVWhCYzNkTGQwTnNXV1JOT0UwMVJreEVSMDB3VUUxQ2FEVlJWSGx6ZFc1MVozVXZZVkEzYmtzNU1sSm5hbVF2YzNseWJXRnRLM2cwTVhWUmVVWm1WbGhOZFVveWNtRjFaMDA0V25FNVdscGtja3BUVDNOdVlWaEhNRkp0WlZwdGJtaG1TMWRyVGxRdldWQkplblZ0YlZOVVZXeHBPQ3NyV21Fdk9FaGtkR0ZLZUZGMkwweHdjR05sTUhCV01sRmhTMU0zU0dkU2VWaFRLMGxWV1ZKcE5VVTRSa3RwYWtKV09XZFRVRVZ3Tml0MWRHdHNTbmwyUjFFNWVGQTFabGRoTTBObmRtTlNUbU40ZGpkc2RHMVpLMFp5UWxOaWFsZENXbk5RU0dsTVpGTkVjRzk2VkV4WlpWVTNTSFk1V1dKS2FUWllLMUJNV0dndk5IVlFPVkZNYVZadGJqSTFNRFV4UjAxeFEzcHJUMmxzTmtOb1pXSmFSM2hQTUZkVVNXcFVTV3RSTm5ORGNGZHlNQzlGUlZBeWNXRTNVMUJaV21WblpqVXdiVVZsZEdJNGIwOTVaak5QWWxKbVFUTnJMM0JUWlROR1pWQjRlRlpCYzFSTEsyNTJlWEpLTm5CMkt5c3ZRVXhIZVV0a2FtUTBWMHBMWkcxSVRIQk9VRWhhT1VOcllVdFJUa2hqTDA1MlVVMVVUMFpzVGxWV1NURnFlR05rYVUxbFRXZDBWamhMYmtoVFVUMGlMQ0p0WVdNaU9pSTJNMk14TldNM05UZzVOV1ZoT1RBeVpEUTNPV0UyWVRVMVlUY3lPVEJpT1dObFpqZ3hNR0k0TXpGaE5tRm1OalkyWW1NME5URXpZekk1WWpWaU9ERm1JaXdpZEdGbklqb2lJbjA9', 1747397148),
('PIAAC6Lcc6OiLRpRC0vk9dBG4ULFeQwP6j3FTVeM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJazQwUzNGeFRGWnZiRlJJTWxWT2FubFJRbWxGUzJjOVBTSXNJblpoYkhWbElqb2lNMlZTTmxONFpESldTRVE0VDBsa09VSlNaelZyVGpaTFF6RmtZM2MzZG5scmFVa3pTMFZ2TkZkMk9ITkNhRUUyT0ZOMkwxcGhlbEZMZDFWdFJqQmFORzF1Tm1OUE1FZzVMMmgyYTFWbFVUSlNTMEV6VTB4aWRVVnhlR1JTY0ZCWU4zbFNZVmx0U0VKbFNXbG9ZVzFIVUZWbVYxVklZVVlyT0ZGNmNEUjBaR2xzU1RnMWNscE9hbGR4UTJaNGFHeHNka1JOTDFaS2FGcFhOMDFVV1dwMFJFUnJVazFMSzNkQmNXTnFlbFZNTVRNemFYWm9WbVpKTWtWa1kwVm9hM0ZMUzA1M2FEZHhPRXRVVWs5amRHSkhLMmR3VVVKUU1VRXZUM1JCU1VsU1IzaDFhaXRtVmxCSU5FbHBWR1pNWW1vemQwVnBZbGRSTDNweVNuaHBNemRaVG10NlZWZElibEZuV2pSdFFXOXdibTVNWm1GbmEzYzlQU0lzSW0xaFl5STZJakEwT1dVd01qSmtPV1ZqTURsak4ySm1PVGt4WmpSa05tRmhPVFZoTTJVeE1qWTNOREkyWWpjNU5UTmhNVE5pWVRrelpUTXlOV0poTWpZd05UUmtabVFpTENKMFlXY2lPaUlpZlE9PQ==', 1747332681),
('PtdqSCfuVnxzniRv4pmaqfItipVszv2HEMKSfVC0', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJa0ZxUTBkVmVqVldSMncxVHpabEswMDJlbUp3VTNjOVBTSXNJblpoYkhWbElqb2liVzUzVHk4d01IcHRhbFpSV1VJeVVVRnhVek40WW1wc01WaGliR3g2VlRGM2EzTjBSRFZWTTIxYU5HOVJSVTkzVTI5cU9YSXpjREpRV25FclJGcE5SMnBsWW1wMFdWZ3hXRFl2V1RkeFIwRjVXSFpNVHpSblozTktXRnAwUXpoUVJGQjVZbTFLVmt4SWFERk9NMkl4Y0dadVIyRk9RalJYZGxSSFJqaDFWMEYxZG1GcmJWcGpPU3R0ZGs4NVowSjJVUzg1ZDBsWlQyVkJTblJaTXpKUWJYa3lWV2haYzBWUlVHNUpNVzFWYnpOcUwyWm5UVkkxYkd0Q2VsTXZaeTh2UzJNMWJGa3ZNMEk1YTAxdGRHSklaVXRoYVVGMFpWUjZUamhUVEVkVWJXeGlObU4yVmxWM2VFcDVhM2gyYlZKT2FGQlNSV0lyVG5oaVdXcHVWMUYxUXpRemVYVktSVkJJVW0wNWVYRmpZemhPT1U0eGREVklWM28wVXpGSmFWZGhaMnhXTlRWTmVXSlNiV1JMVVRkNFJ5OXhNM1JHZVdwclZUUTVhM0J0ZVdGaWNEWXpiRWxXVG5GQ2MwdzFWbFIwTW5WUFUybEJkbVpxT0ZweldIbGplRmRLUjFGVEx6UlliMk5zTUhaQllYRTViM0pvTVdOVVZETnBRVk4yUzNaUElpd2liV0ZqSWpvaVl6Y3pZamc1WXpBMlpEUmlNRFE1TXpRME5UZzJNekkwWlRJMk56TTVNemRpWkRKaVptWmhOalZrTXpBeVlXRTBaamcxTkdOak9ESXpNR05tWVRjNFl5SXNJblJoWnlJNklpSjk=', 1747331441),
('SXF0wfOcYT5InfmDGOGS6ryJFWIhSihj349aNhAN', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJbTE0U0RGWmMycG9kWEpyZVZCYVVWQnpVbTVQZUZFOVBTSXNJblpoYkhWbElqb2lRM2RzU1dvelNHOXlUVWd6WXlzeVRIUkdaRGw1VERCNlMyMU9MelUyZGtkUk5HWnRjV3NyUW1FelNXSmhlbWN2ZFhoVlMxQkNkalJFVjI5R1dFNUdhWHBtYml0WFpsSlZaamRQY1RoRVNUQlhRa2x0UkZkdmVDdFNWM05zYTBKb2Mwa3ZabkZITlZSSWMwZG1TR1ZTYkhaa2VFVkdWbGhGVXpkVU9UZzFTalV6WnpGdldrVTVSVEZ3ZGxKVlNtNHpObWRxYURjMFpIbGFaWGhIWTJoa2JVcFhUemQyYlRBMWRHc3paMHM0U1ZkcFJVNVdWVVpHWXpGR1NtdFZRbkF2VG14SVUzTXphMmR0UmsxTGVIaEllVm8yVmxCcWQwUnVaMWcwSzBscVJHVmFTbWxwTkVKclRuUkdaakpOTWs1a1RrWnNMM2R0VHpOT1ZIZE1XVnB4YWtrdlZUaEJla1JNYkRKVFNEYzNkVEpMTHpRMFJUVnFlbTlqUWpCSFRIVjNRaTluVUVWSFQwMXlMMEpMTlVwa09ITXpMMlZ6VlVGWmIxaE5SRWxqU1hkc0wzZG9UREFyVTBOV1ZXMVhMMUV3U25ZeWMwdEpRMnR5ZVRaaVZDdHJXWGhZUnpKRmJYQkJhRFJ6UFNJc0ltMWhZeUk2SWpNelptUTNPVEUxT1RBMk5UQTNOelE0TkRSaFl6VmxNRFZtTm1FNE5ERTFNRGt5WVRJelltUm1ZamMzT1RRd056WmtOalV3WldJMllqTXlZVGhpTmpraUxDSjBZV2NpT2lJaWZRPT0=', 1747310227);

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
  `contract_duration_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('Đang xử lý','Đã ký') NOT NULL DEFAULT 'Đang xử lý',
  `signed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `signature_image` text DEFAULT NULL COMMENT 'Ảnh chữ ký dạng Base64',
  `admin_signature_data` text DEFAULT NULL COMMENT 'Dữ liệu chữ ký admin dạng Base64',
  `admin_signature_image` text DEFAULT NULL COMMENT 'Ảnh chữ ký admin dạng Base64',
  `admin_signed_at` timestamp NULL DEFAULT NULL COMMENT 'Thời gian admin ký hợp đồng',
  `admin_name` varchar(255) DEFAULT NULL COMMENT 'Tên người đại diện bên A',
  `admin_position` varchar(255) DEFAULT NULL COMMENT 'Chức vụ người đại diện bên A',
  `otp_verified_at` timestamp NULL DEFAULT NULL COMMENT 'Thời gian OTP được xác nhận'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `signatures`
--

INSERT INTO `signatures` (`id`, `contract_id`, `customer_name`, `customer_email`, `signature_data`, `contract_duration_id`, `status`, `signed_at`, `created_at`, `updated_at`, `signature_image`, `admin_signature_data`, `admin_signature_image`, `admin_signed_at`, `admin_name`, `admin_position`, `otp_verified_at`) VALUES
(42, 33, 'ngapham', 'okamibada@gmail.com', 'data:image/png;base64,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IIAAAggggAACBQgQEBYwiQwBAQQQQAABBBBAAAEEEGgiQEDYRI1rEEAAAQQQQAABBBBAAIECBAgIC5hEhoAAAggggAACCCCAAAIINBEgIGyixjUIIIAAAggggAACCCCAQAECBIQFTCJDQAABBBBAAAEEEEAAAQSaCBAQNlHjGgQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAk0ECAibqHENAggggAACCCCAAAIIIFCAAAFhAZPIEBBAAAEEEEAAAQQQQACBJgIEhE3UuAYBBBBAAAEEEEAAAQQQKECAgLCASWQICCCAAAIIIIAAAggggEATAQLCJmpcgwACCCCAAAIIIIAAAggUIEBAWMAkMgQEEEAAAQQQQAABBBBAoIkAAWETNa5BAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCDQRICAsIka1yCAAAIIIIAAAggggAACBQgQEBYwiQwBAQQQQAABBBBAAAEEEGgiQEDYRI1rEEAAAQQQQAABBBBAAIECBAgIC5hEhoAAAggggAACCCCAAAIINBEgIGyixjUIIIAAAggggAACCCCAQAECBIQFTCJDQAABBBBAAAEEEEAAAQSaCBAQNlHjGgQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAk0ECAibqHENAggggAACCCCAAAIIIFCAAAFhAZPIEBBAAAEEEEAAAQQQQACBJgIEhE3UuAYBBBBAAAEEEEAAAQQQKECAgLCASWQICCCAAAIIIIAAAggggEATAQLCJmpcgwACCCCAAAIIIIAAAggUIEBAWMAkMgQEEEAAAQQQQAABBBBAoIkAAWETNa5BAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCDQRICAsIka1yCAAAIIIIAAAggggAACBQgQEBYwiQwBAQQQQAABBBBAAAEEEGgiQEDYRI1rEEAAAQQQQAABBBBAAIECBAgIC5hEhoAAAggggAACCCCAAAIINBEgIGyixjUIIIAAAggggAACCCCAQAECBIQFTCJDQAABBBBAAAEEEEAAAQSaCBAQNlHjGgQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAk0ECAibqHENAggggAACCCCAAAIIIFCAAAFhAZPIEBBAAAEEEEAAAQQQQACBJgIEhE3UuAYBBBBAAAEEEEAAAQQQKECAgLCASWQICCCAAAIIIIAAAggggEATAQLCJmpcgwACCCCAAAIIIIAAAggUIEBAWMAkMgQEEEAAAQQQQAABBBBAoIkAAWETNa5BAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCDQRICAsIka1yCAAAIIIIAAAggggAACBQgQEBYwiQwBAQQQQAABBBBAAAEEEGgiQEDYRI1rEEAAAQQQQAABBBBAAIECBAgIC5hEhoAAAggggAACCCCAAAIINBEgIGyixjUIIIAAAggggAACCCCAQAECBIQFTCJDQAABBBBAAAEEEEAAAQSaCBAQNlHjGgQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAk0ECAibqHENAggggAACCCCAAAIIIFCAAAFhAZPIEBBAAAEEEEAAAQQQQACBJgIEhE3UuAYBBBBAAAEEEEAAAQQQKECAgLCASWQICCCAAAIIIIAAAggggEATAQLCJmpcgwACCCCAAAIIIIAAAggUIEBAWMAkMgQEEEAAAQQQQAABBBBAoIkAAWETNa5BAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCDQRICAsIka1yCAAAIIIIAAAggggAACBQgQEBYwiQwBAQQQQAABBBBAAAEEEGgiQEDYRI1rEEAAAQQQQAABBBBAAIECBAgIC5hEhoAAAggggAACCCCAAAIINBEgIGyixjUIIIAAAggggAACCCCAQAECBIQFTCJDQAABBBBAAAEEEEAAAQSaCBAQNlHjGgQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAk0ECAibqHENAggggAACCCCAAAIIIFCAAAFhAZPIEBBAAAEEEEAAAQQQQACBJgIEhE3UuAYBBBBAAAEEEEAAAQQQKECAgLCASWQICCCAAAIIIIAAAggggEATAQLCJmpcgwACCCCAAAIIIIAAAggUIEBAWMAkMgQEEEAAAQQQQAABBBBAoIkAAWETNa5BAAEEEEAAAQQQQAABBAoQ+P/ZpSPXsAx+QgAAAABJRU5ErkJggg==', 3, 'Đang xử lý', '2025-05-14 09:35:32', '2025-05-14 09:34:47', '2025-05-14 09:35:32', 'data:image/png;base64,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IIAAAggggAACBQgQEBYwiQwBAQQQQAABBBBAAAEEEGgiQEDYRI1rEEAAAQQQQAABBBBAAIECBAgIC5hEhoAAAggggAACCCCAAAIINBEgIGyixjUIIIAAAggggAACCCCAQAECBIQFTCJDQAABBBBAAAEEEEAAAQSaCBAQNlHjGgQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAk0ECAibqHENAggggAACCCCAAAIIIFCAAAFhAZPIEBBAAAEEEEAAAQQQQACBJgIEhE3UuAYBBBBAAAEEEEAAAQQQKECAgLCASWQICCCAAAIIIIAAAggggEATAQLCJmpcgwACCCCAAAIIIIAAAggUIEBAWMAkMgQEEEAAAQQQQAABBBBAoIkAAWETNa5BAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCDQRICAsIka1yCAAAIIIIAAAggggAACBQgQEBYwiQwBAQQQQAABBBBAAAEEEGgiQEDYRI1rEEAAAQQQQAABBBBAAIECBAgIC5hEhoAAAggggAACCCCAAAIINBEgIGyixjUIIIAAAggggAACCCCAQAECBIQFTCJDQAABBBBAAAEEEEAAAQSaCBAQNlHjGgQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAk0ECAibqHENAggggAACCCCAAAIIIFCAAAFhAZPIEBBAAAEEEEAAAQQQQACBJgIEhE3UuAYBBBBAAAEEEEAAAQQQKECAgLCASWQICCCAAAIIIIAAAggggEATAQLCJmpcgwACCCCAAAIIIIAAAggUIEBAWMAkMgQEEEAAAQQQQAABBBBAoIkAAWETNa5BAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCDQRICAsIka1yCAAAIIIIAAAggggAACBQgQEBYwiQwBAQQQQAABBBBAAAEEEGgiQEDYRI1rEEAAAQQQQAABBBBAAIECBAgIC5hEhoAAAggggAACCCCAAAIINBEgIGyixjUIIIAAAggggAACCCCAQAECBIQFTCJDQAABBBBAAAEEEEAAAQSaCBAQNlHjGgQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAk0ECAibqHENAggggAACCCCAAAIIIFCAAAFhAZPIEBBAAAEEEEAAAQQQQACBJgIEhE3UuAYBBBBAAAEEEEAAAQQQKECAgLCASWQICCCAAAIIIIAAAggggEATAQLCJmpcgwACCCCAAAIIIIAAAggUIEBAWMAkMgQEEEAAAQQQQAABBBBAoIkAAWETNa5BAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCDQRICAsIka1yCAAAIIIIAAAggggAACBQgQEBYwiQwBAQQQQAABBBBAAAEEEGgiQEDYRI1rEEAAAQQQQAABBBBAAIECBAgIC5hEhoAAAggggAACCCCAAAIINBEgIGyixjUIIIAAAggggAACCCCAQAECBIQFTCJDQAABBBBAAAEEEEAAAQSaCBAQNlHjGgQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAk0ECAibqHENAggggAACCCCAAAIIIFCAAAFhAZPIEBBAAAEEEEAAAQQQQACBJgIEhE3UuAYBBBBAAAEEEEAAAQQQKECAgLCASWQICCCAAAIIIIAAAggggEATAQLCJmpcgwACCCCAAAIIIIAAAggUIEBAWMAkMgQEEEAAAQQQQAABBBBAoIkAAWETNa5BAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCDQRICAsIka1yCAAAIIIIAAAggggAACBQgQEBYwiQwBAQQQQAABBBBAAAEEEGgiQEDYRI1rEEAAAQQQQAABBBBAAIECBAgIC5hEhoAAAggggAACCCCAAAIINBEgIGyixjUIIIAAAggggAACCCCAQAECBIQFTCJDQAABBBBAAAEEEEAAAQSaCBAQNlHjGgQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAk0ECAibqHENAggggAACCCCAAAIIIFCAAAFhAZPIEBBAAAEEEEAAAQQQQACBJgIEhE3UuAYBBBBAAAEEEEAAAQQQKECAgLCASWQICCCAAAIIIIAAAggggEATAQLCJmpcgwACCCCAAAIIIIAAAggUIEBAWMAkMgQEEEAAAQQQQAABBBBAoIkAAWETNa5BAAEEEEAAAQQQQAABBAoQ+P/ZpSPXsAx+QgAAAABJRU5ErkJggg==', NULL, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABd4AAADICAYAAAD2v/NzAAAAAXNSR0IArs4c6QAAIABJREFUeF7t3QncdVPZ+PHfa57nSCUhRKYMGZMpUyRCyNSgDA2UvzFTFJJokCGRqYEkQhkzJEMiopSpqJAMUZQh/3V51+ndTvfz3Oc+Z+9z9j7ntz4fn+d57nuva6313fvuvd9rr3Ot/8GmgAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACpQn8T2mRDKSAAgoooIACCiiggAIKKKCAAgoooIACCiiggAKYePchUEABBRRQQAEFFFBAAQUUUEABBRRQQAEFFFCgRAET7yViGkoBBRRQQAEFFFBAAQUUUEABBRRQQAEFFFBAARPvPgMKKKCAAgoooIACCiiggAIKKKCAAgoooIACCpQoYOK9RExDKaCAAgoooIACCiiggAIKKKCAAgoooIACCihg4t1nQAEFFFBAAQUUUEABBRRQQAEFFFBAAQUUUECBEgVMvJeIaSgFFFBAAQUUUEABBRRQQAEFFFBAAQUUUEABBUy8+wwooIACCiiggAIKKKCAAgoooIACCiiggAIKKFCigIn3EjENpYACCiiggAIKKKCAAgoooIACCiiggAIKKKCAiXefAQUUUEABBRRQQAEFFFBAAQUUUEABBRRQQAEFShQw8V4ipqEUUEABBRRQQAEFFFBAAQUUUEABBRRQQAEFFDDx7jOggAIKKKCAAgoooIACCiiggAIKKKCAAgoooECJAibeS8Q0lAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACJt59BhRQQAEFFFBAAQUUUEABBRRQQAEFFFBAAQUUKFHAxHuJmIZSQAEFFFBAAQUUUEABBRRQQAEFFFBAAQUUUMDEu8+AAgoooIACCiiggAIKKKCAAgoooIACCiiggAIlCph4LxHTUAoooIACCiiggAIKKKCAAgoooIACCiiggAIKmHj3GVBAAQUUUEABBRRQQAEFFFBAAQUUUEABBRRQoEQBE+8lYhpKAQUUUEABBRRQQAEFFFBAAQUUUEABBRRQQAET7z4DCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgqUKGDivURMQymggAIKKKCAAgoooIACCiiggAIKKKCAAgooYOLdZ0ABBRRQQAEFFFBAAQUUUEABBRRQQAEFFFBAgRIFTLyX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XiKmoRRQQAEFFFBAAQUUUEABBRRQQAEFFFBAAQUUMPHuM6CAAgoooIACCiiggAIKKKCAAgoooIACCiigQIkCJt5LxDSUAgoooIACCiiggAIKKKCAAgoooIACCiiggAIm3n0GFFBAAQUUUEABBRRQQAEFFFBAAQUUUEABBRQoUcDEe4mYhlJAAQUUUEABBRRQQAEFFFBAAQUUUEABBRRQwMS7z4ACCiiggAIKKKCAAgoooIACCiiggAIKKKCAAiUKmHgvEdNQCiiggAIKKKCAAgoooIACCiiggAIKKKCAAgqYePcZUEABBRRQQAEFFFBAAQUUUEABBRRQQNivrnIAAAGRSURBVAEFFFCgRAET7yViGkoBBRRQQAEFFFBAAQUUUEABBRRQQAEFFFBAARPvPgMKKKCAAgoooIACCiiggAIKKKCAAgoooIACCpQoYOK9RExDKaCAAgoooIACCiiggAIKKKCAAgoooIACCihg4t1nQAEFFFBAAQUUUEABBRRQQAEFFFBAAQUUUECBEgVMvJeIaSgFFFBAAQUUUEABBRRQQAEFFFBAAQUUUEABBUy8+wwooIACCiiggAIKKKCAAgoooIACCiiggAIKKFCigIn3EjENpYACCiiggAIKKKCAAgoooIACCiiggAIKKKCAiXefAQUUUEABBRRQQAEFFFBAAQUUUEABBRRQQAEFShQw8V4ipqEUUEABBRRQQAEFFFBAAQUUUEABBRRQQAEFFDDx7jOggAIKKKCAAgoooIACCiiggAIKKKCAAgoooECJAibeS8Q0lAIKKKCAAgoooIACCiiggAIKKKCAAgoooIACJt59BhRQQAEFFFBAAQUUUEABBRRQQAEFFFBAAQUUKFHg/wMsC8EjczDZOQAAAABJRU5ErkJggg==', '2025-05-14 09:35:32', 'Phạm Quang Ngà', 'Giám đốc', '2025-05-14 09:34:47');
INSERT INTO `signatures` (`id`, `contract_id`, `customer_name`, `customer_email`, `signature_data`, `contract_duration_id`, `status`, `signed_at`, `created_at`, `updated_at`, `signature_image`, `admin_signature_data`, `admin_signature_image`, `admin_signed_at`, `admin_name`, `admin_position`, `otp_verified_at`) VALUES
(43, 34, 'Nguyễn Đức Thắng', 'nguyenducthangg899@gmail.com', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA4QAAAFeCAYAAADddNFbAAAAAXNSR0IArs4c6QAAIABJREFUeF7t3Qe8ddec//HvhBCdEL2LCCFCiBajhkQnRO/R/nqfMaMNRp8xGC1qGC16C9E7IVqE6ESPEj0I478/Y+2xc+Y+9557n33O2Xuvz3q9ntfTztl7rffe997z22ut3+/vYlNAAQUUUEABBRRQQAEFFKhS4O+qHLWDVkABBRRQQAEFFFBAAQUUiAGhN4ECCiiggAIKKKCAAgooUKmAAWGlF95hK6CAAgoooIACCiiggAIGhN4DCiiggAIKKKCAAgoooEClAgaElV54h62AAgoooIACCiiggAIKGBB6DyiggAIKKKCAAgoooIAClQoYEFZ64R22AgoooIACCiiggAIKKGBA6D2ggAIKKKCAAgoooIACClQqYEBY6YV32AoooIACCiiggAIKKKCAAaH3gAIKKKCAAgoooIACCihQqYABYaUX3mEroIACCiiggAIKKKCAAgaE3gMKKKCAAgoooIACCiigQKUCBoSVXniHrYACCiiggAIKKKCAAgoYEHoPKKCAAgoooIACCiiggAKVChgQVnrhHbYCCiiggAIKKKCAAgooYEDoPaCAAgoooIACCiiggAIKVCpgQFjphXfYCiiggAIKKKCAAgoooIABofeAAgoooIACCiiggAIKKFCpgAFhpRfeYSuggAIKKKCAAgoooIACBoTeAwoooIACCiiggAIKKKBApQIGhJVeeIetgAIKKKCAAgoooIACChgQeg8ooIACCiiggAIKKKCAApUKGBBWeuEdtgIKKKCAAgoooIACCihgQOg9oIACCiiggAIKKKCAAgpUKmBAWOmFd9gKKKCAAgoooIACCiiggAGh94ACCiiggAIKKKCAAgooUKmAAWGlF95hK6CAAgoooIACCiiggAIGhN4DCiiggAIKKKCAAgoooEClAgaElV54h62AAgoooIACCiiggAIKGBB6DyiggAIKKKCAAgoooIAClQoYEFZ64R22AgoooIACCiiggAIKKGBA6D2ggAIKKKCAAgoooIACClQqYEBY6YV32AoooIACCiiggAIKKKCAAaH3gAIKKKCAAgoooIACCihQqYABYaUX3mEroIACCiiggAIKKKCAAgaE3gMKKKCAAgoooIACCiigQKUCBoSVXniHrYACCiiggAIKKKCAAgoYEHoPKKCAAgoooIACCiiggAKVChgQVnrhHbYCCiiggAIKKKCAAgooYEDoPaCAAgoooIACCiiggAIKVCpgQFjphXfYCiiggAIKKKCAAgoooIABofeAAgoooIACCiiggAIKKFCpgAFhpRfeYSuggAIKKKCAAgoooIACBoTeAwoooIACCiiggAIKKKBApQIGhJVeeIetgAIKKKCAAgoooIACChgQeg8ooIACCiiggAIKKKCAApUKGBBWeuEdtgIKKKCAAgoooIACCihgQOg9oIACCiiggAIKKKCAAgpUKmBAWOmFd9gKKKCAAgoooIACCiiggAGh94ACCiiggAIKKKCAAgooUKmAAWGlF95hK6CAAgoooIACCiiggAIGhN4DCiiggAIKKKCAAgoooEClAgaElV54h62AAgoooIACCiiggAIKGBB6DyiggAIKKKCAAgoooIAClQoYEFZ64R22AgoooIACCiiggAIKKGBA6D2ggAIKKKCAAgoooIACClQqYEBY6YV32AoooIACCiiggAIKKKCAAaH3gAIKKKCAAgoooIACCihQqYABYaUX3mEroIACCiiggAIKKKCAAgaE3gMKKKCAAgoooIACCiigQKUCBoSVXniHrYACCiiggAIKKKCAAgoYEHoPKKCAAgoooIACCiiggAKVChgQVnrhHbYCCiiggAIKKKCAAgooYEDoPaCAAgoooIACCiiggAIKVCpgQFjphXfYCiiggAIKKKCAAgoooIABofeAAgoooIACCiiggAIKKFCpgAFhpRfeYSuggAIKKKCAAgoooIACBoTeAwoooIACCiiggAIKKKBApQIGhJVeeIetgAIKKKCAAgoooIACChgQeg8ooIACCiiggAIKKKCAApUKGBBWeuEdtgIKKKCAAgoooIACCihgQOg9oIACCiiggAIKKKCAAgpUKmBAWOmFd9gKKDApgfMluUuSXZKcLcnpkvw6ybFJPpvkbUn+MqkROxgFFFBAAQUU6EXAgLAXRg+igAIKbEmAwO2gJPsnuUiSvZP8MMm5tnS09d/0qyZoPC7Jh5MckeR9Sfg3mwIKKKCAAgpULGBAWPHFd+gKKLASgfMnuWcza3e5JPutpAd/O+kfkhzW9OdH5ddRSc6Y5NNJfrDivnl6BRRQQAEFFFiCgAHhEpA9hQIKVC9wpSbw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', 2, 'Đang xử lý', '2025-05-14 11:51:27', '2025-05-14 11:37:53', '2025-05-14 11:51:27', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA4QAAAFeCAYAAADddNFbAAAAAXNSR0IArs4c6QAAIABJREFUeF7t3Qe8ddec//HvhBCdEL2LCCFCiBajhkQnRO/R/nqfMaMNRp8xGC1qGC16C9E7IVqE6ESPEj0I478/Y+2xc+Y+9557n33O2Xuvz3q9ntfTztl7rffe997z22ut3+/vYlNAAQUUUEABBRRQQAEFFKhS4O+qHLWDVkABBRRQQAEFFFBAAQUUiAGhN4ECCiiggAIKKKCAAgooUKmAAWGlF95hK6CAAgoooIACCiiggAIGhN4DCiiggAIKKKCAAgoooEClAgaElV54h62AAgoooIACCiiggAIKGBB6DyiggAIKKKCAAgoooIAClQoYEFZ64R22AgoooIACCiiggAIKKGBA6D2ggAIKKKCAAgoooIACClQqYEBY6YV32AoooIACCiiggAIKKKCAAaH3gAIKKKCAAgoooIACCihQqYABYaUX3mEroIACCiiggAIKKKCAAgaE3gMKKKCAAgoooIACCiigQKUCBoSVXniHrYACCiiggAIKKKCAAgoYEHoPKKCAAgoooIACCiiggAKVChgQVnrhHbYCCiiggAIKKKCAAgooYEDoPaCAAgoooIACCiiggAIKVCpgQFjphXfYCiiggAIKKKCAAgoooIABofeAAgoooIACCiiggAIKKFCpgAFhpRfeYSuggAIKKKCAAgoooIACBoTeAwoooIACCiiggAIKKKBApQIGhJVeeIetgAIKKKCAAgoooIACChgQeg8ooIACCiiggAIKKKCAApUKGBBWeuEdtgIKKKCAAgoooIACCihgQOg9oIACCiiggAIKKKCAAgpUKmBAWOmFd9gKKKCAAgoooIACCiiggAGh94ACCiiggAIKKKCAAgooUKmAAWGlF95hK6CAAgoooIACCiiggAIGhN4DCiiggAIKKKCAAgoooEClAgaElV54h62AAgoooIACCiiggAIKGBB6DyiggAIKKKCAAgoooIAClQoYEFZ64R22AgoooIACCiiggAIKKGBA6D2ggAIKKKCAAgoooIACClQqYEBY6YV32AoooIACCiiggAIKKKCAAaH3gAIKKKCAAgoooIACCihQqYABYaUX3mEroIACCiiggAIKKKCAAgaE3gMKKKCAAgoooIACCiigQKUCBoSVXniHrYACCiiggAIKKKCAAgoYEHoPKKCAAgoooIACCiiggAKVChgQVnrhHbYCCiiggAIKKKCAAgooYEDoPaCAAgoooIACCiiggAIKVCpgQFjphXfYCiiggAIKKKCAAgoooIABofeAAgoooIACCiiggAIKKFCpgAFhpRfeYSuggAIKKKCAAgoooIACBoTeAwoooIACCiiggAIKKKBApQIGhJVeeIetgAIKKKCAAgoooIACChgQeg8ooIACCiiggAIKKKCAApUKGBBWeuEdtgIKKKCAAgoooIACCihgQOg9oIACCiiggAIKKKCAAgpUKmBAWOmFd9gKKKCAAgoooIACCiiggAGh94ACCiiggAIKKKCAAgooUKmAAWGlF95hK6CAAgoooIACCiiggAIGhN4DCiiggAIKKKCAAgoooEClAgaElV54h62AAgoooIACCiiggAIKGBB6DyiggAIKKKCAAgoooIAClQoYEFZ64R22AgoooIACCiiggAIKKGBA6D2ggAIKKKCAAgoooIACClQqYEBY6YV32AoooIACCiiggAIKKKCAAaH3gAIKKKCAAgoooIACCihQqYABYaUX3mEroIACCiiggAIKKKCAAgaE3gMKKKCAAgoooIACCiigQKUCBoSVXniHrYACCiiggAIKKKCAAgoYEHoPKKCAAgoooIACCiiggAKVChgQVnrhHbYCCiiggAIKKKCAAgooYEDoPaCAAgoooIACCiiggAIKVCpgQFjphXfYCiiggAIKKKCAAgoooIABofeAAgoooIACCiiggAIKKFCpgAFhpRfeYSuggAIKKKCAAgoooIACBoTeAwoooIACCiiggAIKKKBApQIGhJVeeIetgAIKKKCAAgoooIACChgQeg8ooIACCiiggAIKKKCAApUKGBBWeuEdtgIKKKCAAgoooIACCihgQOg9oIACCiiggAIKKKCAAgpUKmBAWOmFd9gKKDApgfMluUuSXZKcLcnpkvw6ybFJPpvkbUn+MqkROxgFFFBAAQUU6EXAgLAXRg+igAIKbEmAwO2gJPsnuUiSvZP8MMm5tnS09d/0qyZoPC7Jh5MckeR9Sfg3mwIKKKCAAgpULGBAWPHFd+gKKLASgfMnuWcza3e5JPutpAd/O+kfkhzW9OdH5ddRSc6Y5NNJfrDivnl6BRRQQAEFFFiCgAHhEpA9hQIKVC9wpSbw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', NULL, NULL, '2025-05-14 11:51:27', 'Phạm Quang Ngà', 'Giám đốc', '2025-05-14 11:37:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `support_responses`
--

CREATE TABLE `support_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `support_responses`
--

INSERT INTO `support_responses` (`id`, `support_ticket_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(57, 1, 21, 'hahahahhaha', '2025-05-15 07:00:07', '2025-05-15 07:00:07'),
(58, 1, 21, 'hahaha', '2025-05-15 08:03:36', '2025-05-15 08:03:36'),
(59, 1, 21, 'sakdaksdksadkadskasdkadasdkasdkasdsakdasdsakdasdakdsadadkadakdadakdadakdadkdasdaskdsadsadkadkakdsakdkadkadkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk]ư', '2025-05-15 08:03:58', '2025-05-15 08:03:58'),
(60, 1, 21, 'ưqkenqkwekwme', '2025-05-15 08:11:44', '2025-05-15 08:11:44'),
(61, 1, 21, 'ádasjdkjasd', '2025-05-15 08:11:49', '2025-05-15 08:11:49'),
(62, 1, 21, 'hahahajasdjsajdjsadjsajdjsajdsajdjsajdjasj', '2025-05-15 08:18:01', '2025-05-15 08:18:01'),
(63, 1, 21, 'hahahahahaha', '2025-05-15 08:18:07', '2025-05-15 08:18:07'),
(64, 1, 21, 'mẹ mày', '2025-05-15 08:18:12', '2025-05-15 08:18:12'),
(65, 1, 21, 'ăn cưats khomg', '2025-05-15 08:18:18', '2025-05-15 08:18:18'),
(66, 1, 21, 'câcsc;a', '2025-05-15 08:18:22', '2025-05-15 08:18:22'),
(67, 1, 21, 'hahahahahahdhashdhasdhashdashdhasda', '2025-05-15 08:18:59', '2025-05-15 08:18:59'),
(68, 1, 17, 'sadadsa', '2025-05-15 08:22:05', '2025-05-15 08:22:05'),
(69, 1, 17, 'shiba', '2025-05-15 08:22:20', '2025-05-15 08:22:20'),
(70, 1, 21, 'sadsadasdadadadadadadadadadadadasddddddddddddddddddddddddddđ', '2025-05-15 08:39:42', '2025-05-15 08:39:42'),
(71, 1, 21, 'adsdsadsndsdsad', '2025-05-15 08:41:50', '2025-05-15 08:41:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` enum('Đang xử lý','Đã giải quyết','Đã huỷ') DEFAULT 'Đang xử lý',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `user_id`, `assigned_employee_id`, `title`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 17, 21, 'Hỗ Trợ Thanh Toán', '-lỗi thanh toán', 'Đang xử lý', '2025-05-15 06:46:03', '2025-05-15 08:03:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `identity_card` varchar(12) NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee','customer') NOT NULL,
  `status` enum('active','banned') NOT NULL DEFAULT 'active',
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `identity_card`, `dob`, `password`, `role`, `status`, `phone`, `address`, `avatar`, `created_at`, `updated_at`, `remember_token`, `last_login_at`) VALUES
(2, 'Admin', 'admin@gmail.com', '123456789111', '0000-00-00', '$2y$12$87zbSUJenTUoyqsdLU029uj5pV1YlSEtMFKv.0bGFAWphKaXpLEfi', 'admin', 'active', '0123456789', 'Hà Nội', NULL, '2025-04-02 00:22:39', '2025-05-15 17:30:15', NULL, '2025-05-15 17:30:15'),
(13, 'NGUYEN HUU TRUONG', 'nguyenhuutruong05092003@gmail.com', '123456789111', '0000-00-00', '$2y$12$sjhQiATK1MhM2N8/cmvCSO8ObCJp5/jCMyrqdBORTR64xJ8owwshq', 'customer', 'active', '0328394538', 'K45A/38 Dũng Sĩ Thanh Khê, Thanh Khê Tây, Thanh Khê, Đà Nẵng', NULL, '2025-04-10 21:12:22', '2025-04-27 01:32:16', NULL, NULL),
(15, 'NGUYEN HUU TRUONG', 'nguyentruong05092003@gmail.com', '123456789111', '0000-00-00', '$2y$12$/Q0sbN.Vtskt/iqkW9Cdo.Hp4sAWO9lpMHyyzsCkkmIC11lvtgO6a', 'customer', 'active', '0328394538', 'K45A/38 Dũng Sĩ Thanh Khê, Thanh Khê Tây, Thanh Khê, Đà Nẵng', NULL, '2025-04-27 01:28:18', '2025-04-27 01:28:18', NULL, NULL),
(17, 'ngapham', 'okamibada@gmail.com', '044384734293', '2003-01-23', '$2y$12$fApbKHhy7GHFujNfCm0EYezU7CLsw0rGTFVDxQC7npq5KBEsbMA5e', 'customer', 'active', '0987653253', '12312313123', 'avatars/9uD1Ju90OerDF61cebsRG6l1bGSSzRQ2Om8nbkRk.png', '2025-05-12 14:35:33', '2025-05-16 11:57:12', NULL, '2025-05-16 11:57:12'),
(19, 'Nguyễn Đức Thắng', 'nguyenducthangg899@gmail.com', '', '0000-00-00', '$2y$12$vrXP4galrWEI8BiH5pc/ReKMAhKwEky73yr.B6Hg9epC4FxMpY.e.', 'customer', 'active', '0987653214', 'Viet Nam', NULL, '2025-05-13 12:06:49', '2025-05-13 12:06:49', NULL, NULL),
(20, 'Pham Quang Ngà', 'okamibada123@gmail.com', '044213123124', '2003-01-23', '$2y$12$r1/p4Gm.F2zkxmncgXW8uuPRG6EtbSb0zBR/.ykYXbO3NUr1tbp6O', 'customer', 'active', '0987653214', 'hahaha-hahaha-hahah', NULL, '2025-05-14 09:06:38', '2025-05-14 09:06:38', NULL, NULL),
(21, 'Pham Quang Ngà', 'okamibada2310@gmail.com', '098765324142', '2025-05-15', '$2y$12$gEjfbL5O0mumagJ5IvQ8quZx.uvgKqvvPnVa4eGwth8GZChLxyfma', 'employee', 'active', '0987654321', 'hâhhahaahahha-adhahdhahd-ahahah', 'avatars/H3pgpXuCuVlrOL73bq2A6Mfs6SvQGvKz1ugaitzJ.jpg', '2025-05-14 09:17:13', '2025-05-15 07:53:01', NULL, '2025-05-15 07:23:00'),
(22, 'Pham Văn Hới', 'vanhoipham2@gmail.com', '098765392100', '2003-01-23', '$2y$12$SaaNe.qZqTW3GZjh0vn8KeC.WA/ICn4csdcjKHIzO7zU.IE1Fjnba', 'employee', 'active', '0987653214', 'hai thanh-dong hoi-da nang', NULL, '2025-05-15 07:01:50', '2025-05-15 07:02:04', NULL, '2025-05-15 07:02:04');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD KEY `contracts_service_id_foreign` (`service_id`),
  ADD KEY `contracts_customer_id_foreign` (`customer_id`),
  ADD KEY `idx_contracts_number` (`contract_number`),
  ADD KEY `idx_contracts_status` (`status`);

--
-- Chỉ mục cho bảng `contract_amendments`
--
ALTER TABLE `contract_amendments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_id` (`contract_id`);

--
-- Chỉ mục cho bảng `contract_documents`
--
ALTER TABLE `contract_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_id` (`contract_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Chỉ mục cho bảng `contract_durations`
--
ALTER TABLE `contract_durations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contract_durations_service_id` (`service_id`),
  ADD KEY `fk_contract_durations_duration_id` (`duration_id`);

--
-- Chỉ mục cho bảng `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `durations`
--
ALTER TABLE `durations`
  ADD PRIMARY KEY (`id`);

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
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_contract_id_foreign` (`contract_id`),
  ADD KEY `idx_payments_method` (`method`),
  ADD KEY `contract_duration_id` (`contract_duration_id`);

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
  ADD KEY `services_created_by_foreign` (`created_by`),
  ADD KEY `services_category_id_foreign` (`category_id`),
  ADD KEY `idx_services_name` (`service_name`);

--
-- Chỉ mục cho bảng `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `service_reviews`
--
ALTER TABLE `service_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `customer_id` (`customer_id`);

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
  ADD KEY `signatures_contract_id_foreign` (`contract_id`),
  ADD KEY `signatures_contract_duration_id_foreign` (`contract_duration_id`);

--
-- Chỉ mục cho bảng `support_responses`
--
ALTER TABLE `support_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_responses_support_ticket_id_foreign` (`support_ticket_id`),
  ADD KEY `support_responses_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `support_tickets_assigned_employee_id_foreign` (`assigned_employee_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `idx_users_email` (`email`),
  ADD KEY `idx_users_phone` (`phone`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `contract_amendments`
--
ALTER TABLE `contract_amendments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `contract_documents`
--
ALTER TABLE `contract_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `contract_durations`
--
ALTER TABLE `contract_durations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `durations`
--
ALTER TABLE `durations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT cho bảng `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `service_reviews`
--
ALTER TABLE `service_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `signatures`
--
ALTER TABLE `signatures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `support_responses`
--
ALTER TABLE `support_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `contract_amendments`
--
ALTER TABLE `contract_amendments`
  ADD CONSTRAINT `contract_amendments_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `contract_durations`
--
ALTER TABLE `contract_durations`
  ADD CONSTRAINT `contract_durations_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contract_durations_ibfk_2` FOREIGN KEY (`duration_id`) REFERENCES `durations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_contract_durations_duration_id` FOREIGN KEY (`duration_id`) REFERENCES `durations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_contract_durations_service_id` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`contract_duration_id`) REFERENCES `contract_durations` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `signatures`
--
ALTER TABLE `signatures`
  ADD CONSTRAINT `signatures_contract_duration_id_foreign` FOREIGN KEY (`contract_duration_id`) REFERENCES `contract_durations` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `support_responses`
--
ALTER TABLE `support_responses`
  ADD CONSTRAINT `support_responses_support_ticket_id_foreign` FOREIGN KEY (`support_ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `support_responses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_assigned_employee_id_foreign` FOREIGN KEY (`assigned_employee_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
