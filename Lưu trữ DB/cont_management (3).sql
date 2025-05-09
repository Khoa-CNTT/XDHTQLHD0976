-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 09, 2025 lúc 04:00 PM
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
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `contract_number` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Chờ xử lý','Hoạt động','Hoàn thành','Đã huỷ') NOT NULL DEFAULT 'Chờ xử lý',
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contracts`
--

INSERT INTO `contracts` (`id`, `service_id`, `customer_id`, `contract_number`, `start_date`, `end_date`, `status`, `total_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(19, 102, 5, 'HD-1746078645', '2025-05-01', '2025-11-01', 'Chờ xử lý', 1000.00, '2025-04-30 22:50:45', '2025-05-04 06:09:32', NULL),
(20, 107, 5, 'HD-1746628381', '2025-05-07', '2025-11-07', 'Chờ xử lý', 50000.00, '2025-05-07 07:33:01', '2025-05-07 07:33:01', NULL),
(21, 19, 5, 'HD-1746639392', '2025-05-08', '2025-11-08', 'Chờ xử lý', 310000.00, '2025-05-07 17:36:32', '2025-05-07 17:36:32', NULL),
(22, 20, 5, 'HD-1746639836', '2025-05-08', '2025-11-08', 'Chờ xử lý', 240000.00, '2025-05-07 17:43:56', '2025-05-07 17:43:56', NULL),
(23, 61, 5, 'HD-1746640192', '2025-05-08', '2025-11-08', 'Chờ xử lý', 7000000.00, '2025-05-07 17:49:52', '2025-05-07 17:49:52', NULL);

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
(6, 15, 'Hà Nội', '1234567890', '2025-04-27 01:28:18', '2025-04-27 01:28:18', NULL);

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
(1, 1, 'Nhân Viên', 'Kinh Doanh', 200000.00, '2025-04-16', '2025-04-24 16:23:43', '2025-04-25 16:23:43'),
(2, 13, 'Nhân viên kỹ thuật', 'Kỹ thuật', 200000.00, '2025-04-11', '2025-04-11 04:25:40', '2025-04-11 04:25:40'),
(3, 2, 'cc', 'cc', 100000.00, '2025-04-11', '2025-04-18 16:35:26', '2025-04-19 16:35:26');

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
(18, '2025_05_08_011240_add_end_date_to_contracts_table', 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `status` enum('Hoàn Thành','Đã Huỷ','Đang Đợi','Đang Xử Lý','Thất Bại') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `contract_id`, `amount`, `date`, `method`, `transaction_id`, `order_id`, `payment_type`, `payment_response`, `request_id`, `partner_code`, `signature`, `ipn_response`, `error_message`, `status`, `created_at`, `updated_at`) VALUES
(1, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '6813112fea1db', 'captureWallet', NULL, NULL, NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-04-30 23:14:07', '2025-04-30 23:14:07'),
(5, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '68135b0804bd1', 'captureWallet', NULL, NULL, NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 04:29:12', '2025-05-01 04:29:12'),
(6, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '68135b0ec4d20', 'captureWallet', NULL, NULL, NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 04:29:18', '2025-05-01 04:29:18'),
(7, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '68135b9f81537', 'captureWallet', NULL, NULL, NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 04:31:43', '2025-05-01 04:31:43'),
(8, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '17461073346398', 'payWithATM', '{\"responseTime\":1746107336757,\"message\":\"Bad format request.\",\"resultCode\":20}', '1746107334', NULL, NULL, NULL, NULL, 'Thất Bại', '2025-05-01 06:48:54', '2025-05-01 06:48:56'),
(9, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '17461073389601', 'payWithATM', '{\"responseTime\":1746107339131,\"message\":\"Bad format request.\",\"resultCode\":20}', '1746107338', NULL, NULL, NULL, NULL, 'Thất Bại', '2025-05-01 06:48:58', '2025-05-01 06:48:58'),
(10, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '17461080008605', 'payWithATM', '{\"responseTime\":1746108001920,\"message\":\"Bad format request.\",\"resultCode\":20}', '1746108000', NULL, NULL, NULL, NULL, 'Thất Bại', '2025-05-01 07:00:00', '2025-05-01 07:00:01'),
(11, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '17461080029059', 'payWithATM', '{\"responseTime\":1746108004176,\"message\":\"Bad format request.\",\"resultCode\":20}', '1746108002', NULL, NULL, NULL, NULL, 'Thất Bại', '2025-05-01 07:00:02', '2025-05-01 07:00:03'),
(12, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '17461088342712', 'payWithATM', NULL, '1746108834', NULL, NULL, NULL, NULL, 'Thất Bại', '2025-05-01 07:13:54', '2025-05-01 07:13:55'),
(13, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '17461090783095', 'captureWallet', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"17461090783095\",\"requestId\":\"1746109078\",\"amount\":1000,\"responseTime\":1746109082574,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTA5MDc4MzA5NQ&s=fbe2a40f27705370f36fd06b200ec0d97dd42d024982bbd1179f437f94ede185\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTA5MDc4MzA5NQ&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM25121O000000420208QRIBFTTA5303704540410005802VN62450515MMT5VjsnYzj97QR0822Thanh toan hop dong 196304EE49\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTA5MDc4MzA5NQ&v=3.0&deeplinkCallback=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess&callBackUrl=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTA5MDc4MzA5NQ&v=3.0\",\"signature\":\"e597351a835859379b1f87345d969786a4c5060e0452ac0626c433ddded3e799\"}', '1746109078', NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 07:17:58', '2025-05-01 07:18:01'),
(14, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '17461093998199', 'captureWallet', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"17461093998199\",\"requestId\":\"1746109399\",\"amount\":1000,\"responseTime\":1746109401239,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTA5Mzk5ODE5OQ&s=bb0c1b99af01da7d882655202ea51e62f1963ddce24e32a47671b3ff36d8fff1\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTA5Mzk5ODE5OQ&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM25121O000000430208QRIBFTTA5303704540410005802VN62450515MMT3YYvwyUo7GQR0822Thanh toan hop dong 196304FBCF\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTA5Mzk5ODE5OQ&v=3.0&deeplinkCallback=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess&callBackUrl=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTA5Mzk5ODE5OQ&v=3.0\",\"signature\":\"a117d360fe95038ee7910efebbea60d23be53bd64a055e411253382e2b955ccf\"}', '1746109399', NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 07:23:19', '2025-05-01 07:23:20'),
(15, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '17461101481463', 'captureWallet', NULL, '1746110148', NULL, NULL, NULL, NULL, 'Thất Bại', '2025-05-01 07:35:48', '2025-05-01 07:35:51'),
(16, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '17461104172239', 'captureWallet', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"17461104172239\",\"requestId\":\"1746110417\",\"amount\":1000,\"responseTime\":1746110418837,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTEwNDE3MjIzOQ&s=0fa39ec7b835fe81a4b595b9288a300513b175ca379156ba225dee77545252cb\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTEwNDE3MjIzOQ&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM25121O000000460208QRIBFTTA5303704540410005802VN62450515MMTQBpYL6t17bQR0822Thanh toan hop dong 196304E7CF\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTEwNDE3MjIzOQ&v=3.0&deeplinkCallback=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess&callBackUrl=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTEwNDE3MjIzOQ&v=3.0\",\"signature\":\"5bb08e7aa955c6232ead68e62c0b4742d8c7b4b374688fa018cd74c91289ea61\"}', '1746110417', NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 07:40:17', '2025-05-01 07:40:18'),
(17, 19, 1000.00, '2025-05-01', 'MoMo', NULL, '17461104778000', 'captureWallet', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"17461104778000\",\"requestId\":\"1746110477\",\"amount\":1000,\"responseTime\":1746110478943,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTEwNDc3ODAwMA&s=d2a8faf51bb5fdcff61d4166b63e2309e93508f58b8f077640f872cb518eb738\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTEwNDc3ODAwMA&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM25121O000000470208QRIBFTTA5303704540410005802VN62450515MMTcT47rRyaadQR0822Thanh toan hop dong 196304351F\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTEwNDc3ODAwMA&v=3.0&deeplinkCallback=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess&callBackUrl=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXwxNzQ2MTEwNDc3ODAwMA&v=3.0\",\"signature\":\"37714fe5aa22d5d4f1af64934ab0ce1dd15621a46d972106507174d6e5576186\"}', '1746110477', NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 07:41:17', '2025-05-01 07:41:18'),
(18, 19, 1000.00, '2025-05-01', 'MoMo', NULL, 'order_681388ce9d58d5.48322313', 'captureWallet', NULL, '1746110670', NULL, NULL, NULL, NULL, 'Thất Bại', '2025-05-01 07:44:30', '2025-05-01 07:44:34'),
(19, 19, 1000.00, '2025-05-01', 'MoMo', NULL, 'order_68138b0a48aee8.48501747', 'captureWallet', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"order_68138b0a48aee8.48501747\",\"requestId\":\"1746111242\",\"amount\":1000,\"responseTime\":1746111244216,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGIwYTQ4YWVlOC40ODUwMTc0Nw&s=57876496b901bc5cf061893b1c2862cfa8e33984efd6dbbbf2635f0ed6d4b083\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGIwYTQ4YWVlOC40ODUwMTc0Nw&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM25121O000000500208QRIBFTTA5303704540410005802VN62450515MMT1uTkmmPpSWQR0822Thanh toan hop dong 19630401BE\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGIwYTQ4YWVlOC40ODUwMTc0Nw&v=3.0&deeplinkCallback=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess&callBackUrl=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGIwYTQ4YWVlOC40ODUwMTc0Nw&v=3.0\",\"signature\":\"6fcdc3da33d02ffada614d834d6541a9ec1069f4c70cd8e845e683c5e0bab7eb\"}', '1746111242', NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 07:54:02', '2025-05-01 07:54:03'),
(20, 19, 1000.00, '2025-05-01', 'MoMo', NULL, 'order_68138cc28ea6b5.28999679', 'captureWallet', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"order_68138cc28ea6b5.28999679\",\"requestId\":\"1746111682\",\"amount\":1000,\"responseTime\":1746111684146,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGNjMjhlYTZiNS4yODk5OTY3OQ&s=2bbc7296fc07e81ef9e33b1e1f4176eb0e0f46ce2803833c2557b74e0046011c\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGNjMjhlYTZiNS4yODk5OTY3OQ&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM25121O000000510208QRIBFTTA5303704540410005802VN62450515MMTCCnCKQU0qUQR0822Thanh toan hop dong 1963046B22\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGNjMjhlYTZiNS4yODk5OTY3OQ&v=3.0&deeplinkCallback=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess&callBackUrl=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGNjMjhlYTZiNS4yODk5OTY3OQ&v=3.0\",\"signature\":\"9e9379ed8ef0bb7c1e106fef134398056336bdc088becd33fb9650c210973800\"}', '1746111682', NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 08:01:22', '2025-05-01 08:01:23'),
(21, 19, 1000.00, '2025-05-01', 'MoMo', NULL, 'order_68138e474ea528.70166873', 'captureWallet', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"order_68138e474ea528.70166873\",\"requestId\":\"1746112071\",\"amount\":1000,\"responseTime\":1746112073419,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGU0NzRlYTUyOC43MDE2Njg3Mw&s=930321154cbb976e3425291a230fd26129640e498d04d1f96a038cd568371c10\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGU0NzRlYTUyOC43MDE2Njg3Mw&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM25121O000000520208QRIBFTTA5303704540410005802VN62450515MMTDBDjI6TRDkQR0822Thanh toan hop dong 196304A955\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGU0NzRlYTUyOC43MDE2Njg3Mw&v=3.0&deeplinkCallback=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess&callBackUrl=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGU0NzRlYTUyOC43MDE2Njg3Mw&v=3.0\",\"signature\":\"8fdea2dae2472a08b7e9d5d53f5ad7d2c37b4698d720f58d6c6898e072b4a651\"}', '1746112071', NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 08:07:51', '2025-05-01 08:07:52'),
(22, 19, 1000.00, '2025-05-01', 'MoMo', NULL, 'order_68138fc928d731.70212606', 'captureWallet', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"order_68138fc928d731.70212606\",\"requestId\":\"1746112457\",\"amount\":1000,\"responseTime\":1746112458771,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGZjOTI4ZDczMS43MDIxMjYwNg&s=6b201aa76314118481034788d7896f02c361eb5828c6cf0b316ed586ab59f394\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGZjOTI4ZDczMS43MDIxMjYwNg&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM25121O000000530208QRIBFTTA5303704540410005802VN62450515MMTFXWp5eBoxNQR0822Thanh toan hop dong 1963041194\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGZjOTI4ZDczMS43MDIxMjYwNg&v=3.0&deeplinkCallback=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess&callBackUrl=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOGZjOTI4ZDczMS43MDIxMjYwNg&v=3.0\",\"signature\":\"f0cf24d002cbd110c09d373628b0b44f37c97da8ed99f9572f7e8d930bc928c3\"}', '1746112457', NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 08:14:17', '2025-05-01 08:14:18'),
(23, 19, 1000.00, '2025-05-01', 'MoMo', NULL, 'order_6813916379e401.17447548', 'captureWallet', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"order_6813916379e401.17447548\",\"requestId\":\"1746112867\",\"amount\":1000,\"responseTime\":1746112869064,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOTE2Mzc5ZTQwMS4xNzQ0NzU0OA&s=2a37cc56d723fa69d397c3d7ea42feb209bf3bda8ca076baf8a7448504b6f5cf\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOTE2Mzc5ZTQwMS4xNzQ0NzU0OA&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM25121O000000540208QRIBFTTA5303704540410005802VN62450515MMTXoMCN9BkkLQR0822Thanh toan hop dong 196304C442\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOTE2Mzc5ZTQwMS4xNzQ0NzU0OA&v=3.0&deeplinkCallback=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess&callBackUrl=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOTE2Mzc5ZTQwMS4xNzQ0NzU0OA&v=3.0\",\"signature\":\"f87f664413d31cd27d04dde57b6f13105b8f0070967f4b5e88a395c0194ceb46\"}', '1746112867', NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 08:21:07', '2025-05-01 08:21:08'),
(24, 19, 1000.00, '2025-05-01', 'MoMo', NULL, 'order_681391bd6ef3c3.97821282', 'captureWallet', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"order_681391bd6ef3c3.97821282\",\"requestId\":\"1746112957\",\"amount\":1000,\"responseTime\":1746112958903,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOTFiZDZlZjNjMy45NzgyMTI4Mg&s=6eb74ce3e433082280a251f340a1a8bf1bc037894d9d2f2531f2551b7a2991f1\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOTFiZDZlZjNjMy45NzgyMTI4Mg&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM25121O000000550208QRIBFTTA5303704540410005802VN62450515MMTkdMGcURM1vQR0822Thanh toan hop dong 1963045154\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOTFiZDZlZjNjMy45NzgyMTI4Mg&v=3.0&deeplinkCallback=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess&callBackUrl=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOTFiZDZlZjNjMy45NzgyMTI4Mg&v=3.0\",\"signature\":\"ca656f4390b18596ce83c043fbef91cc52f9c757b7fa768ffe3b1c296e69e658\"}', '1746112957', NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 08:22:37', '2025-05-01 08:22:38'),
(25, 19, 1000.00, '2025-05-07', 'MoMo', NULL, 'order_681b1dd366e135.64560906', 'captureWallet', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"order_681b1dd366e135.64560906\",\"requestId\":\"1746607571\",\"amount\":1000,\"responseTime\":1746607576292,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODFiMWRkMzY2ZTEzNS42NDU2MDkwNg&s=ff45d7f10230657b5df7491515a3f9f850611c846f7f5dfdeffa9cbc11d17460\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODFiMWRkMzY2ZTEzNS42NDU2MDkwNg&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM25127O000001680208QRIBFTTA5303704540410005802VN62450515MMT3wvIchzNnAQR0822Thanh toan hop dong 19630492F4\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODFiMWRkMzY2ZTEzNS42NDU2MDkwNg&v=3.0&deeplinkCallback=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess&callBackUrl=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODFiMWRkMzY2ZTEzNS42NDU2MDkwNg&v=3.0\",\"signature\":\"c43f008e9e848f1fea48ca24cc8d9576c8a38abe8492545aef03c1c8a1f0bb9a\"}', '1746607571', NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-07 01:46:11', '2025-05-07 01:46:15'),
(26, 19, 1000.00, '2025-05-07', 'MoMo', NULL, 'order_681b1f9b9ccfd6.19356276', 'captureWallet', NULL, '1746608027', NULL, NULL, NULL, NULL, 'Thất Bại', '2025-05-07 01:53:47', '2025-05-07 01:53:48'),
(27, 19, 1000.00, '2025-05-07', 'MoMo', NULL, 'order_681b20ba3c5371.39437857', 'captureWallet', NULL, '1746608314', NULL, NULL, NULL, NULL, 'Thất Bại', '2025-05-07 01:58:34', '2025-05-07 01:58:35');

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
  `price` decimal(15,2) NOT NULL,
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

INSERT INTO `services` (`id`, `service_name`, `description`, `content`, `image`, `price`, `created_by`, `created_at`, `updated_at`, `is_hot`, `category_id`, `deleted_at`) VALUES
(19, 'HOME 3_NgT (Mesh)', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', 'services/1JovvZvowJ9UO7yDvNyW7ECwSWHs7ozKf7GIbVZb.jpg', 310000.00, NULL, '2025-04-13 23:14:48', '2025-05-03 06:49:15', 1, 3, NULL),
(20, 'Home 2_NGT MESH', 'Đường truyền Internet tốc độ 500Mbps\r\n\r\nTrang bị thêm Wifi Mesh 5/6 chỉ với 30.000đ/tháng', 'Đường truyền Internet tốc độ 500Mbps\r\n\r\nTrang bị thêm Wifi Mesh 5/6 chỉ với 30.000đ/tháng', 'services/Xr3saG0IKWg33biYULRBBYUdmCgK0RfsI2Y3w4QK.jpg', 240000.00, NULL, '2025-04-10 01:30:46', '2025-05-03 07:14:10', 1, 3, NULL),
(21, 'HOME 4_NgT (Mesh)', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', '1. Ưu đãi gói cước\r\n- Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\n- Trang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\n+  Wifi Mesh 5: \r\n     * Wifi Mesh 5 iGate EW12ST là sự kết hợp giữa chuẩn Wifi 5 và công nghệ Mesh Wifi, phù hợp với hộ gia đình với mọi cấu trúc nhà ở. \r\n     * Tốc độ lên đến 1200Mbps trên cả 2 băng tần 2,4-5GHz\r\n     * Kết nối liền mạch, chỉ tạo tên 1 Wifi duy nhất\r\n     * Hỗ trợ đồng thời 40 thiết bị\r\n     * Cài đặt dễ dàng, triển khai linh hoạt.\r\n+ Wifi Mesh 6:\r\n     *Wifi Mesh 6 iGate EW30SX là sự kết hợp giữa chuẩn Wifi 6 và công nghệ Mesh, phù hợp với các doanh nghiệp, tổ chức vừa và nhỏ, các gia đình có nhu cầu sử dụng internet cao. \r\n     * Tốc độ lên đến 3Gbps, trên cả hai băng tần 2,4 – 5GHz\r\n     * Kết nối liền mạch, phù hợp mọi ngóc ngách\r\n     * Hỗ trợ đồng thời 100 thiết bị\r\n     * Độ trễ giảm 50%. \r\n- Lắp đặt nhanh chóng, chăm sóc và hỗ trợ khách hàng 24/7\r\n\r\n2. Cước đấu nối hòa mạng\r\n - Cước đấu nối hòa mạng áp dụng cho thuê bao đăng ký mới dịch vụ cho Khách hàng cá nhân, Hộ gia đình: 300.000 VNĐ/thuê bao (đã bao gồm VAT)\r\n\r\n3. Khu vực áp dụng\r\n - Áp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố\r\n\r\n4. Tổng đài hỗ trợ \r\n - Để được hỗ trợ về dịch vụ internet và truyền hình, Quý khách vui lòng liên hệ 1800 1166 (miễn phí)', 'services/dhsRznFd88xlLjRqbmxbjntocSGLDuB77E0EQicB.jpg', 1000000.00, NULL, '2025-04-10 01:34:14', '2025-05-03 08:32:40', 0, 3, NULL),
(60, 'Phát triển Website Bán Hàng', 'Website thương mại điện tử hiện đại', 'Tích hợp giỏ hàng, thanh toán online, responsive.', 'services/TjYf6sBR4VkfuRtr9EzPL1pznKI48XfxTs8BjHak.jpg', 5000000.00, 3, '2025-04-10 21:27:26', '2025-05-03 07:14:21', 0, 1, NULL),
(61, 'Ứng dụng di động Android/iOS', 'Lập trình app mobile đa nền tảng', 'Sử dụng Flutter, React Native, tích hợp API.', 'services/khDB2z0sjR4ttHlKFWsEiAqy7HiwMRnfnZphfV2C.jpg', 7000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:26:20', 0, NULL, NULL),
(62, 'Tư vấn triển khai ERP', 'Tư vấn ERP toàn diện cho doanh nghiệp', 'Kế toán, nhân sự, bán hàng, kho, CRM.', 'services/2Y4b65MHox9WCxOvKMZR5LLH3rMgCCIDZ8LO5w8D.png', 8000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:26:41', 0, NULL, NULL),
(63, 'Xây dựng hệ thống LMS', 'Nền tảng học trực tuyến chuyên nghiệp', 'Video, quiz, chấm điểm, chứng chỉ.', 'services/UH1gGPYAkyeSuUB7hPTSiPrqiOliQoy3cGhCaVOy.jpg', 10000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:27:00', 0, NULL, NULL),
(64, 'Tối ưu Cơ sở Dữ liệu', 'Tối ưu tốc độ và dung lượng dữ liệu', 'Query, index, backup, mô hình hóa.', 'services/ujEM9p21S3379g6zw03vMg4EPgCPpV59AKw6Vspl.jpg', 3000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:28:34', 0, NULL, NULL),
(65, 'Giải pháp CRM khách hàng', 'Quản lý khách hàng và bán hàng hiệu quả', 'Quản lý pipeline, email marketing, báo cáo.', 'services/dtOOyPjSWNgKGFqCNCS0zQOzP1gUGffrU7OC5cPr.png', 4000000.00, 3, '2025-04-10 21:27:26', '2025-05-03 07:14:33', 0, 2, NULL),
(66, 'Dịch vụ DevOps', 'Tự động hóa CI/CD và hạ tầng', 'Docker, Jenkins, GitLab CI, cloud deploy.', 'services/a0It4W6kxOqUz6TUERtlYswPsw4kwBwgCUhUhc9o.jpg', 4500000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:30:07', 0, NULL, NULL),
(67, 'Bảo mật ứng dụng Web', 'Phân tích và bảo vệ hệ thống', 'Kiểm thử lỗ hổng OWASP, tường lửa ứng dụng.', 'services/XzM84aFmFHps8HVRSSWjjxJ3Q3P5PzIWjcxlN8mP.jpg', 5000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:30:56', 0, NULL, NULL),
(68, 'Dịch vụ API Gateway', 'Tích hợp API trung gian', 'Quản lý version, bảo mật, định tuyến thông minh.', 'services/8qwNnayx5Bj1mlcGHnzSWJhj3UdOkcvam12XKMZr.jpg', 3500000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:30:37', 0, NULL, NULL),
(69, 'Triển khai hệ thống Chatbot', 'Chatbot cho website, Facebook', 'Tích hợp AI, hỗ trợ khách hàng 24/7.', 'services/HfnKc7VVSZjgGry25COri0qCuScrWeeoEqi8qyuO.png', 4500000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:31:26', 0, NULL, NULL),
(70, 'Lắp đặt Camera IP', 'Triển khai giám sát văn phòng', 'Xem từ xa, ghi hình đám mây.', 'services/5o0wdDrxO52xIH0t9rIuO2GPs1Rs0bgAOEq2xtY8.jpg', 4000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:32:00', 0, NULL, NULL),
(71, 'Bảo trì máy chủ định kỳ', 'Vá lỗi, tối ưu hiệu suất server', 'Check phần cứng, OS, RAID.', 'services/R3hwPKYAq0NyncGO4dq5iRtS4QBhgpKiybk8krFG.jpg', 2500000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:32:24', 0, NULL, NULL),
(72, 'Nâng cấp máy tính doanh nghiệp', 'RAM, SSD, vệ sinh thiết bị', 'Tăng hiệu suất máy văn phòng.', 'services/KB50qsTT30zQnNyPJX8ktlH7Hqua9524MPz730E2.jpg', 1500000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:32:48', 0, NULL, NULL),
(73, 'Lắp đặt mạng nội bộ LAN', 'Switch, router, phân vùng mạng', 'Setup hạ tầng nội bộ.', 'services/TTvjEsVYCNWJ4M8XekJOcZFbsvkto5Cc09StjmYC.jpg', 3000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:33:09', 0, NULL, NULL),
(74, 'Cung cấp máy tính văn phòng', 'Máy bộ, màn hình, phụ kiện', 'Bảo hành 12 tháng.', 'services/RvyDUOiQOmZDL0VczKivzrIv2MHs0qKZHCSAFfcb.jpg', 7000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:43:26', 0, NULL, NULL),
(77, 'Thi công tủ rack và cáp mạng', 'Tổ chức tủ mạng chuyên nghiệp', 'Patch panel, chuẩn hóa dây cáp.', 'services/xGMhcCJuIPFFmLwTACsF9brt3xDp4Vp49LBzT6Yg.jpg', 3500000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:34:13', 0, NULL, NULL),
(78, 'Cài đặt phần cứng máy chủ', 'Lắp CPU, RAM, RAID, NIC', 'Cấu hình BIOS, test ổn định.', 'services/roXAdH5gY3MNMLkG7bzLhRpje2gkEULP4atrKw4Q.jpg', 5000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:34:47', 0, NULL, NULL),
(79, 'Bảo trì thiết bị mạng', 'Switch, router, firewall', 'Firmware update, kiểm tra lỗi.', 'services/k4L11F5PcjtrvU3Tz11hloddbnMjvGGY5x6Ei4BT.jpg', 1800000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:43:49', 0, NULL, NULL),
(80, 'Đăng ký Internet doanh nghiệp', 'Tốc độ cao, có IP tĩnh', 'Hỗ trợ 24/7, hợp đồng linh hoạt.', 'services/PxPzLNOneDCPgr2SPI3NpeH6auZuG4nmI1OjCJSO.png', 2000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:37:50', 0, NULL, NULL),
(81, 'Triển khai tổng đài nội bộ (PBX)', 'Liên lạc nội bộ và gọi ngoài', 'VoIP, ghi âm, phân luồng.', 'services/SwOXBzWKh8biErzRVzUDVg0kMm4ja1EhCohzG76y.jpg', 3500000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:39:22', 0, NULL, NULL),
(83, 'Triển khai mạng VPN', 'Bảo mật dữ liệu từ xa', 'OpenVPN, IPsec cho doanh nghiệp.', 'services/4sp7PAba8SMksCZ8JjJW04j1guTkNXboFZNYnfiF.jpg', 3000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:39:38', 0, NULL, NULL),
(84, 'Tư vấn an ninh mạng', 'Firewall, IDS/IPS', 'Đảm bảo an toàn hệ thống.', 'services/MpRu3kcPi8e07M9V28sZsuJgbQWZyKGHwlblSfJo.png', 3500000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:39:59', 0, NULL, NULL),
(86, 'Giám sát hệ thống mạng từ xa', 'Theo dõi uptime, cảnh báo', 'Zabbix, PRTG, email alert.', 'services/WMJw5RoHAklzZl9KVC1UlPLZxmPYWxwG7mCbfgyk.jpg', 3200000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:40:17', 0, NULL, NULL),
(87, 'Cung cấp thiết bị mạng chuyên dụng', 'Router, firewall, WiFi mesh', 'Cisco, Mikrotik, Aruba.', 'services/9IHOTBgOE9tzjYq1WQPWxHHMtOnlU3urdtJYZ0QZ.jpg', 8000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:41:00', 0, NULL, NULL),
(89, 'Bảo trì định kỳ hệ thống mạng', 'Kiểm tra thiết bị và backup cấu hình', 'Khắc phục sự cố định kỳ.', 'services/xsNIYTPBm9FktUmavCB7WUPLQ1IdIvJaVrHI9mnH.jpg', 2000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:41:22', 0, NULL, NULL),
(102, 'Dịch vụ bảo mật dữ liệu cao cấp', '123', '123', 'services/h75W6Ak1PCiodTECxwqSmyTxiUZSmoJ1sQm8yrex.jpg', 1000.00, 3, '2025-04-28 14:12:09', '2025-04-30 22:15:32', 1, NULL, NULL),
(107, 'nágag', 'agaga', 'gagag', 'services/AaOYYVr9vWpySog2DpRNWRNrg337Z4x9BMC9lNWu.jpg', 50000.00, 3, '2025-05-03 06:43:17', '2025-05-03 06:48:58', 1, 3, NULL);

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
(3, 'Nhà mạng', 'Các dịch vụ liên quan đến nhà mạng', '2025-05-03 13:06:11', '2025-05-03 13:06:11'),
(6, 'đâsda', NULL, '2025-05-03 08:57:56', '2025-05-03 08:57:56');

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
('gJOiDJhIg4n8yiRAjmeuI0qlckyffHubNz9OYFYp', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJbG93VmxGS01tMDFhRnBHUTFOaVduWktWMHBTWkZFOVBTSXNJblpoYkhWbElqb2lWM05oWlZwc2JFaFVTREZrU0RkVWRrcEZlR0UxVW5odlEzZHJXVlV6VmtjNU0ycHVaSGhCVmpGd05GQk5aVVZtUkhORFlYWldVVk5RZUVONk5FbG5iMDB4V1RKd1ZETkJOVWRaVHpkb09IVlpkemREYzFOQ1psb3lhVEY0ZHpOTWRWWkZMMmxoT1RGaVZVTnNkalpFT1ZCdWVXbFRRMjFsV214blNGWmhTbTkzY0ZOU09HY3hkV0kyUXpaellUWXpObTkxVW14V1ZrNXFTbEJDT0N0RU4zWkJVa3RzYkd0bk4yWkNObXhRTmpCWFUwOUZNakZNWkd4emVuRmFSbk5qYTA1WE5pdDNPVkJYT0VORlVHdDJOa1JLVms5QlVXeEpSV3huWlRkbVRFVldjVWhoUWpJMVdsVXJkRVk0YTBkVlozbEtUVWRCVG5wQk1HbDVPWG80Vm5oV01FaDZXamhXV0dOMFdrOU9hMUZpV2xKalYzRXpPRUp6Y0ZCSFpIZFhlVE5xYVhNNVptWmpjMWs0TkdSRmJpOUdSRlJXTnpkcFluVmhNMHRzVjNKMk5ESXZObUpTYjJsVkszWTViaTluU1dKQ01rbHRkVmcwY2xCSFJWVndiVEJKTlRCRVQzUXdOMlk1V1M5eVJVUkxVVGRpVVRCemRFOUhjRkZGYUdoQ1pGTkZOMHhYY200clUxSmFWSGgzUjNOQmJGVkNWM3AwVEhnNVdtbDZabkF5YkRFMWNtVndaVWs0U1RaMFltTTBUbU15SzFseWFWQkZUMnRDV1c1T05IWkdTRTloWTI4eE5GUnBjaXRWWVdORFlXZ3hiVkU5UFNJc0ltMWhZeUk2SW1GaE1qWmlNRFk1WlRreVlUTTNZek5sWlRrMU1ESTBNek01T1RJelltVmlOR1UwWmprNVpqZGhOekpoWWpFNVpHWXlPR0ZsT1RZeVpUQmhNemRsWm1VaUxDSjBZV2NpT2lJaWZRPT0=', 1746635748),
('Ok3FtOfq5EDzvhKckgdUWjisp7BuZBw7r3uRjy11', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJbU51U0VkMFp6SXJiazVOYlZaelZtdzFlRVpXYW1jOVBTSXNJblpoYkhWbElqb2lWMjlIV1ZaNGFrWjNVUzkxZW1oaVVWWTVPRWhZWWxscmFXTjFibXR4V1ZWcVRGWllOemd3YUVoTlFXSkVlV05EYzFGS1RXaExNbHB6SzBKdUsyeFhaREp4ZDB4RlVsbHZlVFZRVUZod2FVSklNQzk2YkhseVZpOXdWVTE2Ym1SNFVHRXlMMDFpTVRWUmMwMUpRV2gwZGt0UGFVNXJLMnQ1ZDFKWmEwNXNSMDlpY1ZOdk55OXJXRTV4V0V4clpEZFpWRUZUUXpFdk5GRlpTbVJqYVRKVU1FdzBlRGcxUkRkalNFOVVVVTV6VVdGbmVYTjNabXA2VDFZNVlXTkNRVFJoWW5OaWVuTTRlRGxsU21oWGNVOVlUbU5DUm01QmFpODNibUUyUWt4MWRsSXJWREZ2UlRjd1dsbzBlR3BVWmxjNFNtaFpTMFJUWjBrdk4zSm5RWEJ3UW1wSVpGWkdSMnBPVm5ST1JuTTNTMHhxYTBOWFUySTBSazVRU2xFMFpGVjZkbU4zVFRCdE9XZzVZa3RIYWxkalVEQXZjek13TkVRMWFUYzVaWHBUVEdwbE0xUmthVzk1VXpabFZtMTNha0ZxYkhoamRqUkhNM3B6ZEdNck5VbE9XRzh3YVRKTWNEY3hZbGh6UFNJc0ltMWhZeUk2SW1ZMU9HTm1NR0ptT1RJd1ptTmhPR1F4T1RkaE5tRmhZVFppWmpRM01HRmlNRFJoWmpGbE1UTmpaV05pWkdOak5XSXpaVFkyWm1JNE1EZzNPREF4TURnaUxDSjBZV2NpT2lJaWZRPT0=', 1746799218),
('qB7W0PGlYM53EQzQVVbcYDsa17NVSkQnIAEm8y0V', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJalpvV1RWRmFUZHhNbHA0TTJsYVlWZzRhamxuU0hjOVBTSXNJblpoYkhWbElqb2lTbkUyWTA1dlZHWkRkMVZOY0hZMlIxSjFhVWxWTURBMlEwRTVNR2haYmpoTWQwOVpVMncyVkdGNGFWcFNiVTQzUW5kUVYzQm9SWFF2Vkc5dGFUbHFRemxrZVdoSGIza3liM1JNV0RoNFJHVjZNbWw1TXpsb1puZGFWMUU1YmtzclkwbExjazB3Y1VwVFRXOW9NMWMyVjNoeVRFRkJZV0p5U1Rkd2RqWk9ORTByTlhFMUwyc3hkMGx4UWxKbVJtaHpSMjVZV1hSMmNrNUdNM2RwT1hsS1FYTmpkMDVTVlhZemRIZHhSRkZ6TTBoNVRFeFNWRTVFSzNsc1duVnNNamxTT0dSMVJtbHNiWEZaYWpRclltZDRLMDkwVXpOQlkyTTVUR2w1UzNselFVcFVSRGRPWm1ScFRrd3JZVGhyZEVkdGFuZ3lXbEJqWTFac1UweHJlalEyZFRGVVdXVXZhWFU1U21FeWEwcDNWR1I1ZGtnMU5DczVkMUp1UTJaT1J6aGhUSE5YYlVKRFQwc3ZSRFF4VG5Jdk1VOUhMM0oyWTFWM2FIZDVjbkl4VW14RksxaDFjeXREVkRFeFlXUmFTbEpPVjFVM2RHMHlRaTgxWVZVclUyMDJXRmhpYkZaT00weHZNelZ4YlhseU1uQTBWWE42WlU0dmRuUnRPRVIyYWxsSlUyVk5OMXBWV21ORlYxWnRkazFVVjFWS2F6Vk9Sek5hZDFVclNIZ3ZXWGhQTVhGdlVFMVNjbVZGZURjeVlWZDZaVFU1U21kNGFtTkpRbVJWZVVFemNFOXZVbUpHVm05MUszTXJiMkUzUkZkdFVrWjRjM0pCY2xGUWVXUjNOMEpoWmpOUmQycGhNelptYXpadFduTlBjRlZhUnpaME5FdFBZazlOVjFKTFdFOTRRak53Ym1wcFYzWTBNRzh6U2tZNFZFNXZWbWRhZVRCVGIyOHpNV2RhYlhWTmJHRm1aMGxCYkRWU0syWnlTRlk0TW10VFFrRk1WekZJYjB4bWEwcFBhRFJZZUVSblJHWmhWMWhSUnpZMlZFZFlhRWRMYXpoWFFVVTVNbmQxT0hBMVkyMW9MMmxPYmxGV2FtcEJUbWt2WVZGVFUxcEhTREpNSzBodE1HVmFhM016VHpGclRUUmtSRzltUWpKMmN6SndTR2xyY1ZRdmJrUjJjbXBMT1hWVk5WZGtWVEV6VVVsWlpVTnlNamM0Y3pRMWQyZERWa0pKU2pac1NsZzVSemRoUzBkNkszTkhTREZEUjA1WmQzcHFXVlV3YWxkUmFsVTROVlY0V0UxbFFYRkpORTQzZDJkVFIyOU5RbWRZUTJKV2QydEZXRXBUTlUweGJXNDJkbmt3ZVZoSE4wSm5RVVoxZURKMFpHUkRjbEZsU2pOelVXMU9WVWN5VTNNMmJsUXhiMFpEZG1kVmNuUmtkR05hTXpVeE1qWTFhMWxITkN0ck9UWk1kekJzVmxjcmMydG1UVk00YkV4SVVUTkVZekoyVG1WblJUVmlPRWR2YVRZNGQydFBWR2w0ZVVkU1NVeHFiRUpvVUM5a01VWXhibm9yWm1oV1FtRXdOMjV0WkVGd1pEaG5XVGxNYlM5aE5IQlJaWFJsWW1vM2QxbEdLelZPTmxOUVEwaFJOVkUwUjIxT1pqZHNUemRhUlU5aE5YRTBZWGRVTlhCcU5HSjRSekJEYmxCYWRqTklaWEkwVlhGWk1VcDVjSEExZEVWTU9DOW1hVklyY1RWd0wxVlNZV013VkZsRFFVaFdOWFJDZUhaRFpDdFFjMVV2Ym1Gb2FVUkJValIyZDJSWVNqZFdVSFlyZG1OYU4wMXViVFprZDJoU1VYVkhjWGw2Y1c5TmJrWlhPQzlvTWk5NFZtdFJaMWRKT0M5TlRGVXhOSFJ2Vmt4T1NXVm9VMEp0ZWtGcGJYcGFXREZNWkZGU2MzUlpTRkZXUWtkTlExZDBNVVJTTWl0WlpIbG9hVWhqY0VsWVIxUktVVzUxY2tSVFZGSXhNblJ2VDA4eU9HTjVUQ3MzZW1WQ0x5dHNhRUpNZWxSNFdUbDZkazVtVDBOVVkwdEdUemhyZW5scFVETnhNWEZqZFROcVNXdEhjbmxUUlhCcWIzQXhVbGhpYVdjeVMwUjNUWHA2YUhaTlozcGpLMDl3UkhkNWEzZ3ZhMU5VUVdRNU4ySmhkREphT1ZOTk5sSjJSRkU0WmtWclExWmtUMGRuTTFWbE1DOVhUalpuYld0QmVucENXRmRXTUhWb1NHZ3hia1p4VWxsdmVtcHBlazFyTjJadFdHeEpjRVJuTUhWbWNXRkJSbkF3UzFKek5sbENSamxRZUhoYU5HbDNRMUJRTlZKV09FNXpSV3g2WXpocVN6SlpRbmhqVEN0aGNUZ3hhVWhyYURaa2FIaHdXazFFVjBoMFpVRldka0Z6VVZCUE1qaE5kM1l4U1VkelZGWnRhR3g0WVVsdFlVVm5ibGRXVUhJMVlqZGtZV00zVlhKb2JuRXhiMEpFWVU5UmJFRktURUZaZVVSVFUxcFZlSHBTV200eWNqUTFWVWh3Ykc4eU1UZEVUVUpEUkROcVJEUm9LMmR3TVRBd1JGQjNNbWRwT0cxVE4zY3JObU52V1hobVJVODVWVTR5YUhWdFN6QnJVblYyVkZKblZHOXdhWEpyUkN0bGJYRlZUVU52ZUN0WldtTjJMMHBsVFVodFpYVkxPV0ZoTnpkMGVGbG9NM050U25Oa04xUjRNRFZOUVdkWmJFaFJOQzlXVFRRNWNrSXpNMmh3UmxGQlNIRmxNV1ptSzNoSWRXRmxTVTgwTkVVcldqWjVlRmxrTmtrclRVMHhkaTh6VEhkaFQxY3djVWRLUW1aUmNHSTJUM016Uld0WFVta3plazU2TkVoU04wRjNaVzQ1V1ZsMU1sTk1VVlI2UmpOalpWUmpiekp0UWxGaWJFUnpaVXAzWlVvMmJVVnNkbkpyWWpsbVowTXJWMU4xZGpKcGVtTTVOREZqVlUxeE1YRnRSMFpPVFVWdFozUmFlSFpIVkVwM05rNTZZVEF6T0c5V05VbDFlVXhJY1dReFFXdExWbFkyY2sxdlQwZzJSM3BWTUZoS01VdFBiekZZTXpod1NsWjBWRXgwT0RrdmRsVnVXbGwxUVRCaFdHeHNPRkF6U1dOdVdtSm5ZMlJLV1c1dWNTODVNamROTDJkSFJHWXZSRzV4ZUcxa09HUlNjMk0zZUM5bU1qY3haalZKZW5sYVNEZ3dPREJQYzJkcWMwaEthMmx3TUZsUEwwMXVNSFpVUkVScFkyRkZhMUJPY1hKclN6SXlhVEl2VlVWRFFWbGFWaXRaUjJsUEsycHVaaTlsYkhCS1FtcDFTVUZrVTBWelYyUm9hRzk0WVZGSFRqbDRXRTFNUzI1cGEwaDRNalJRYUV4QmVGZHlTR1ZEVldORlVYTndSbGhZYzNsUVdqRkVUVkJMUW1KQldpdG9hRVJOZDBGUVYyRkpZbmd3UTAweFZuZHJkMk5rVjNab1lrMXViRXQxVW1sVE5HMUhRVFpDTDBsaldFcGpaazlRTWtJNFFtRkpiMVJtU0U5UWRUSkZWV3BSTjFKUkwyaHliWFkxV21FMWVYUjBVMGMzWlRsTVJHSTNSbmRJZG05M2IwWm9iMlE0TlhCS1FtbG9aVGxZYjNsalpHazRjWFozT1ZJd2IxbE9ZbE5FYjI5cU4wOVpSbVk0UlRsU2NXaFFRVEl2TDBWRE5FZGFSamsxZFUxR01GQmtjMHBwWlRSQ2RWUldaR05pWWs1SFowbDFNVWxSYTBGemVtcHVOMkZ5ZUhGRVZETTRXbTFoZFhCTlRsSkNXWGt6Y0U1WmVVbFZjVWxMUlZkWWJFRlhUVmRTVUZoRFNVOUpaVFZsSzNOaVIybGFSM3BsYzNWVFpIcERaV1ZxYTAxR1duVm9XVkIyTUc5NVl6VldhRFF2U1c5dVIyTkdRM0JWWlc5U2ExUlBVSFUzUWt4NVMwVm5SR1p1UlU1Wk5sSmxObko2ZUN0TGExa3pZa1U0YURoclpEVkRWWEZoT0ZwTGQydHdPVGhTVGpCSldtbElSMlJ1VEZrd2FYQnNhRlJtTVRSWmQyb3ZSV2xZWkRKTllqWjVObGM0VFZwcWNTdFdXVFIwVTAxdVowOWplVWxsWlZORFNrOVVOVGhuVDFob2RVaElaMnR6YWpCUUsxY3ZPRFZCWmxwb1l6bFZWbE5ZUzBkbmFtZFdZbGxEY0ZSbGRtcFZZbXM0VFdncmRWRjJaM2xYZWxScE1qVXpVa3RJWWtkSWVtOUthbTFtZFhwWFIwd3JNRzlVTUZsUVNXZFlaMmxDTW5WR1NtZG9XRnBpWWxacGEyeFBaVEoyWkdSTlJXVTJaakJvWVdoV1VHY3hlalJCV0U0NE4zcDBPV0owZDJoWlpXUmtlWHAwZVV4TFZHSldiRFpuUVhKT1VrSndNRTFrYUdKWFlqUmxWMjF6UzJobGJqTm9jQzlwVVZSdVJGcGlialU0TkcwNE1IUk1UbWxJYUVWTWVWRXpkRzVKUjFsNk1XRXdNWFZqUVdoalVWWm9kMVpQYTI4eWVYVndZbWczT0RRd1JXWXhWSE5xWjFVd1NFMHJOaXRXY0RVNE5uaHRTek5xVW1KcloybDFlVUo1WW1Ob1YwcG5Va3RyVGtadlpYTlVZM1EwVEd4MmEyWjROR2xOVEhGT2FIWkVValJsVkhjM1VqVlNkSFUxTVdoVEt6UnJWak5MYTNaVVRIUlhjemRWWlROeWJsVTVNbVY1VVVJMlZIQTVaV0ZZZEdrNE1HNVVWbEJMZFUxYWVtRlBlVUZOYlV4Uk5UVkRVRTVDWlZsb2JuTlRObGhyYkhJeU1VRm1lWFJyY1hsRk5FeHhObXA2UmtNNU9HUlpRMVY2YjBKMk9IbEhVRVp0WjBkbWFqUkNaVGRhVlRSU2RHTkRXSHBHYjNGdGFEZHVWRXBDZDFkTVNqWndZVVJsUm5GeVJWVktPWHBuUmtNdlIxSkxZVXN2WTJOSFJtNDVPRk5aU0RoUmNqQmhNM2hpUWpsMWFWZE1jM2hQVFRsaGJsRlNiVEU0Wm5KeFkySm9Xamh5VFZwc1dscG9UV3BKZVcxd1dVSndObGd3Y3psRGVHaFhUM1ZXZGpZM1p6Um5ibkpPU2twV1FVNXlMM2RxT1d3dmNtaHlaakYwY1RjeGFYWjVjME15SzB0MVoyZDNNazltVUcwclFVOUxWR3B1TmxSa2NFZ3liV3h0Y1cxMGRGVkxLMWh0WTJsMlRtUTBOU3RTVlVrMlN6QnlhMVpQZDJOVmJGRnBkRlIwUlU1V2JuSTVXRnBFWVd4VU9VOHlkR1ZFWjFGbGNtVjZibkUzTmtSeVRESXhTemRhTHpJelFVZFFVbGhSYWpkQk1rWlBlazFKVkd4ek5uZEtkVzlEUTBOS2QzRnRSM2cyVG10U1pqWnlkWGw1VFcxMlNYVnhVR2cwYkZSMWVXZHlXREJoUWpoTU5XcDNMMU5NVVdZMFprRkNSRk12VUZkVmVsRmxPRlF6UW1oU1RTdHhia2s1ZDNWWFMwSTJZa1J0WjFnNFNqWkZjM0ZDUTNWNGQxTTJPWFI2U2tGeVRXNVFaa0ZNTDJwRmVrMUdaVFZMUTFwbFlUWkZaVzVJT0c4ek9YbDRRMWxOTm1KcFZtOTBaRVpUYWtGclZHaDBXSEI2VVRWcmFTOHpkbEZqY3pKaVdEbEhhV2xHUm1RNU4waG9RVVJvZVZweGFHRlRRM1ozYzA1aWVuUm5TMmQxVG5sYWMwTlJPRXh6YkRVNFNYa3ZPVXB0YVZSblYzZzNabkE0V2pNelFsZFBjeXRZYTI1Qk1ITnljVUZSUW1GVldpOUJWbkZUUkRsU2JESTJVazl1Y1hScU5GbENSRU53U21NeVEzcHpSbWRCYWtodVNTOTFZVWxFY0RBNGEzcDZPRWh0T1RWeFoyaDVORGR0Tm10TU5sZ3lSVmhZV0d3NVlsTnBXRGwyU1ZkTlNsbFNVbEpFWkhWT1QzRnpZbWgxYUdOVE0xRTFaak40YjNFeGVVcGlaRVl5V25wREwwZFdPRXRGY2tSemExVkJNRXRUY1d0YVRFMHpXRGRVV2xsVU5FWlNjRXh3VldoeGRWQm1SV3h2VURrNGRrZG5XVlZzYVVWbFVUQm9Ra2xLUTBGRlZGaElhRGRLTW1zMmNHYzBNMjlCWjFkelQxRkxSVWR6VW1JMVlsTlFXRlZPYmt4SVlqQnVUR0ZSUTIxNGRDOWxhbU5pVVVoSmRrOTJTVUk1UTJsUVZXOXZaVVF6YWpaMFRrSlRUbnAxUm1kc1NEaExhM2hRVDFCU2VtNXVMMHhGSzFKbVRpdFFjM2xKV0d4d1RtNVNVMVVyV2k5aVIzSmFORTVYU2pCalYzQlJWVUpsZGs5SmNHY3dhRWhRY0VVNWJrSkdWamx0ZUZKWlVVWjBORkZOWWxsVlVuWlBNbGRWZUV4VWQxTjNhVXRXVFhSRGIydFhZV3NyTUhCWE9FWlhaMUJOUzA5V2RVVXpiRFk1UWxwNWFuQkRkMHBXUWtoaVNXeFZZa0ZCTjFCcU1sSjFTR0pTVlVOS2FFbGlTVlpzUzJSM2VXcHhNRzluU0RoS01GSTFOV0kxYTBsdE9YTnlka3MyVkZKVVVtVnpSRTByVUZObmRtbzNUMlp1TmtKUWR6VlBTMWs0Y2k5Wk1HcGtZMUkyZGxobFNtdDFWbE5CVGtjdk9VZGpaelpLVEZZeVpWcERNM0pDUlVrNFJrRXJWRkpSUW5GM1EyTklVMEpYWTFabFpXeHdOMDlKUjA5MGNETmxLM1JPWkRSb05Wb3pMMjB6U1hoalVXSlBiREozUkc1WVRWTkZMMVppU0c5UGFGZ3dlREV4WW5GalFuYzFVazV6WVVGS1JEbFRWa2hRTlRkM2VtaGFiekZyVUhGMWJWWktURUZIUTBvek5rbE9WQzltYUhoVE4xWmFPVnB5TVV4SVdrNHJRa3gyUVhocU9HVlhjVFZxVGxKWmFVRXZTVlphV2xBMlpqTkxUSEpvYTFwa1VFcDVVVVJyTDBGMVkydENjVWhZTVRSTFZtdzROR0pRY2xSclYwUlRNREJqVmxKblNFeHphMHBFVFV4bVkzbExXRWR4TDFVMVl6WmxOVXN2WVVKWlVIRXdkR2xuYWpVMlNHVk5PWEpLY0VacFdUSnZZMHhUT0Roc1EwNHlMekZhUTI1RmJXNUhhVGd5VnpOYVV6aExTbWtyV0RKUlRsRlVWVTFoTURkNlUwSldWblppTlVGQ09IQjVNRk55ZGtkTlVrdHRjMk4xUmsxNVpHcHJlWEF2VTBOck1WQXhlSFYxYzFoMlFYRkljVUZuUjFGdFVXWmxXV0ZsYUd0M1kyOVljbmhKWVhSVk5Ya3dOa3RwTTJwWGEwRXpSekIyU0dsM1lpOXVRekZsTkZneFJ6STRhR2MzSzBKRGFqWk5LM0EwYURNMU1HNVZXR0pVVVUxaVFXUllTMHhhTmpJd1NGWm1VVU5PUkVOdFJXdHdiWEV6VUhaM1ExZ3lUbU42U1U1NlJXNU5URVY2TTFoeU5GRjFhSFJQYWpab2QyTm1OR3AzVldwTk4wRXllRkpCUkhkMmNteHFjVFJ3ZFRoUE5GWmpMeTl0V21ZNFNXd3dMM1ZKZDJRMlIxTmFjMWhKUkdWMVNVUm1Oekl3YVdoMVozUnlWWFl6TVRsVlRtazRTRVV6ZDNBeVNrWnNLekV2Um0xblV6UmhTMDV2TUZoUVdsQllTREJDUm5SUVNtRnVValZ3U3pKMFVIZFBTR1pDYldWRkszTnRkbWREY0dzNVZ6aHdaamxYYTB3MVQyeGtlRWt4TkVkWU1EaDNZVWRzUldOUGFYbzRTRkpuUVZCaVRrODFXVEJZVGtnNGQwTkJhMHhsY2t4b09UZExaRloyWW1GWWNYTldTa1p3VUhsS1oybFpNR3h6YzFsQ1ZVTXplRGc1T1M5alNrOXZhMVF6UmtOV2FscHdiV05FTldwTWVtazVWMjE2TW1OVFlYSmtaVTFHYjJaUmNVaERNRzVhTVhwT2NVOUpNM2t2Y2poQ1RFaENabUZyYWpOaWFVaG1SemxyWTJFME1pOVpOa3cxY21WdGJ6TkJWRlJPWWtwaVpWaDVZemxvUWsxVWRpOTBRV2cwYWtKbmVWWXJWMXBJWld4T1VHTkxhVzlETjI4Mk5ETk5NRmwyVFU4NVNVWjViR2R2VFVsNU1GRndVWFUxTjNkeVEyNXRNeTlzUjNORVRFRllOSEJtWjBSSmJVeFVZVXRyYzJ0NGRERm5SMkZoWTJsM00wSkVORlJFVTNKdFJtdGlMMGxuU1RSek9UUTNLeTlRY0VWeE0yOUpOMFJYV2pRNFNESkNjbTl6V21oRmNHUllhMlJ2V0dkRVpIY3pXVTkzWmxSVFRHMVBNM2RETDFCWE1tOUJNVU5vV1Vnd1NrSkhVVlZSY2pORFFqZzFSbkowTkhONU5rRlBSMDlwYjBwbGRrUkVieXQyZDA5dVRHSkZVR2xLUjJWSlpXWjRLelZqZFhCSFZtdHlWWFpzVEZnd2VFdzVjbkoxV0VsRlQxUnhkRVJNT0hvd01VNHZUMVJhVGtwRmNrUjRjRmxFY0ZSaFpUZDVZWGd3Y21Wa1lrOVFUV3N6YldOM1VXOUZTRVpDT0hRMllrUnFka0V5VEdkMU4wcExaMEZTZFZkb1dXZzJSbGxXYkdWdVozZFRjVzlLY0RSMVRFTldiVFZyTUZZeWNHZDNTaXN2VG10Rkx6UTBXVGswVmxCT2EyOXlSWEJPZGsxV1dFbEtSbFZ3TWpSWFZWZGplVTlFWlV4ck1VeGtUR2QyY1ZsTFRqTXdTV2x6YVRSc2NHUXpLekZKWmpOeGVIcEVXbWgyY21FeFpIZHFaelV6ZFhvMGRFUlBZbFZpY0RkUVRYQjFUamxyTDIxbldXNTVaRVJpYUhWNmRFWkJWRWhQYVU5d1UzWTNiM2xpT0RNMlJIQmFVR2NyVDNZNVUwTnlWazVoVGtwSVZ6aEdhMGdyVHk4emVrNTVSMmxwTW01WFowOXVlRXB0WkZSM01FdHlWRmM1UjNkWE56bDROV0Z2VlUxMmMxVlJWRE5QU0hack9YYzVWQ3M0VlVaUU1rWTNSM0EwV0hWQmRFTldOMmM0ZFVkblIyNHlhRTB6Y25VMlptbzVUVzA0V1VkaVRXaHFRVWxxTWxGUFFpdHJRMFlyVWtWcUt6WkJhR1kxTVRBeGNWZ3dSRGdyYjJ4RlJVeENNRGd2Y1RaaVJFMTZVVnBhTjFjelFWWkpaMGhFTVZKWFYxWjFSbTV4V1hWWmVGZDBWM1ZoV1U4d1pVaHZORzVWY1VaWVRXMDBWRmM0Y0RSd1owd3hSMXBRTkhKVGJVUTFRVGhqTWxnek9FOU1VRGgwYUV4WU5FOWhaR05pTjJzdlExRkhPVU5SVHpnek9YVTNNVWRvVG1aWWJERnFabXBZV25KNEwzVklTbWxvTlhSbFluY3dhRWhPYlVRMGVETjJXWEZ3TVdNM1IxaFlWM1JsWW1wbFFqQnlVVmxSU2tWaldtRnliazVOTWpCNE0yMVNOa2RRVFd3NGFUWlhka00xVlZkTFVreGlXamx4ZWxvME5IRm1kWElyVFhkVWRtTk1Xa3hzZFdnd1FVeDVkV2t4WkZsSWIzVTBjWE52WTNFNE1IRnhPVFJhUWxwWWVVdFdRME5HTkV0S1NFdzRlV2wyVmpWSVZrdDRVbTEyTmxGUWVIRnNOSFkxVUVaV1IyeHViazR4T0hGU1MxZHJTWGhtVWxKSmJrbzJVRWsyUVdOUFlsQktUVU5WVDNWR1ZHVjZZVlpzVkhsSmNpOXhNVk53V1N0alZVUk9aMWh2SzJ0dGRHMUdVaXRaYjBSamJFRlVaMVp5VDNsVVYxVlFaSFYwYlVSRVppOXpkR3d4UzNsVE9DdDFUamh3WTJsU1ZVZDFlWFpwY0cxNVltRXdXblJ5YXpFdk1IRllRVVIxTWxZeGRVRlVaVlJOVkVORVVIQnlZWFl5ZG01a2FYcFVVbFZrVmpVclZuZ3plbFp2YUdKek1XVnVWRGt4TUhkdGVtdFNiemRTTlU4eU5UTTFiMEZ4WTFOU1ZXWXpabVJuYjFZeldpc3JjbmxTY2xWNU0xSjFkbE5NUjB0TVF6SlZTakZqUWpBM2VFNTJjVU5VVkc1dWJFVkhSV05sWlcxMk0waDBTeXRIZGsxMGJrUktVM3AyVlRaVFdsQjBVMUpXSzBkdlVHNW1iazFVWjFCSVpFVlZSR1ZDWVVScVFVWnROazlOYkRNd01HSlpNelphTDFwSlFWTk9OakZzYlVOTFVVTTBjR3haVTBZcmNVc3JZVVpZTmxvMGIyOXZhV1ZHTDFSQ1IxZ3pXbVY2VlZSUWVVMHJhRGt4TkhGdVp6bGtiVUpwV2pOMVIzbFJRbFY1TWxOaVdVeElhRlZDZVc1bmVrWnJaRVIyUVZkd2JDczNOREJwY1c5V01EZERVMWQ1V0VwRlMyUlRRak5pWTA5MVVUQm5NU3RFVDJkRVlqWTRVRXhwVFVwbVlreE1aV3BKVG1kS05VTkxkSGhSWTA1bE1HOXhjMGxtTDFGcUsxbHZWVTF3Y0dkRFoyeEpNRXhxTTBsTlVFOXBObFJXYlN0cVVtTXpORk5DYTJSWlltOWxjWGcwU25KS2FraHVTMUF5ZVUxSE5tSkhSMVo0T1NzM2JrSTBkVE5oUkZCSVIycFVhVGxTUTJWVU9ITk1PR3hKZUZweFprdFhRbXQ1T1hveldrTnZOWEpYZG05Qk9TczRVVU5aVmtwTlpTdEVhamxDWlhKSU5WZHhXR3BVUVZobVMwUnliVlpuVTBGUVpEUnZSRTl6WVhwbldreFFjQzgzVlZOSWVFWk5WREl2TDFWS1pVMVVUakpFVlhoSFduQkljVTUzVFhFeVNrdFRPRTgxVjNodVJWZEpVR0ZyTW5NeFN5OVNXSFJ6Y2s1cFlrWm1aRUV2YnpGdmJEUTJSMGRsV1haMk1qTk5TVU4zY2tWU1NFVjBlRmhPZW5sR1EwbzBOMmxHY0hscFYxTXlWSGhSTlVKMFNteEhUMmhXZUdoc2FUbHpWbmRSS3pWeVdVSk9RMmh6YlZsM2IweFBTRzlLVWs1TFlubGphRVUzTnpBcksxQjVhMnh3UVRWM1ptTXpOR05NVjA0M05VVnFXazVqVG1wSGFtUTNMek13VFdGRVYxTjVZV0ZQUnpJMFEzWnhlWEZMYjFGb1dWUkZkR3B1UzBVM1NYZzVlV1ZpVGxsR1ZHcGtZMEkzVkV0YU5sRnhTM05hWkROek9USTFOR053UzB4Vk1rbHBSa2hHVlV4Q2NtTjJUa1kxYjFkaGNrbFdWRlowWXpCTWNsWmlTV3h5Ym1nMEwwSXpiMDF3TnpaWGFHOTRNbmxwYVhKQk5qWmxaV3hVVURoUlRIZHJXRXRTY2pabU5DdDBjWGs0VlZOblVrOVBjbWgwVmpKd00wUjNZMDFhVDFjNVVqZHhiR2hwZUM5dmJHOHlhVWt3VFZVclEyTkplVFJETlhFeVIwWmFialV4UTJRNVlsUkxheTl1WWxaNlExazVORXh0Y0dOdWNFaHpVelJoVnpSYVdrZDNTbUpWTTBaVFZXUkhURm8yZGxSd01uTlZZV2xKWVdSdVVrWmpNUzlzV0RsR09GTnFURVU5SWl3aWJXRmpJam9pWmpVd09EQTVOamN6TWpJMFlUbGhZV05rWVdJMk5tVm1aVE0zTXpKa1ptUmpNVFUyTVRreU9EYzVNMll5TXpGbFpUVXpOMkprTmpFMU5tTTBaV0UxWWlJc0luUmhaeUk2SWlKOQ==', 1746642353);

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
  `identity_card` varchar(12) NOT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `status` enum('Đang xử lý','Đã ký') NOT NULL DEFAULT 'Đang xử lý',
  `signed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `signature_image` text DEFAULT NULL COMMENT 'Ảnh chữ ký dạng Base64',
  `otp_verified_at` timestamp NULL DEFAULT NULL COMMENT 'Thời gian OTP được xác nhận'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `signatures`
--

INSERT INTO `signatures` (`id`, `contract_id`, `customer_name`, `customer_email`, `signature_data`, `identity_card`, `duration`, `status`, `signed_at`, `created_at`, `updated_at`, `signature_image`, `otp_verified_at`) VALUES
(27, 20, 'Ngà Chó Điên', 'okamibada@gmail.com', '949674', '044000300394', '1_nam', 'Đang xử lý', '2025-05-07 07:41:05', '2025-05-07 07:41:05', '2025-05-07 07:41:05', NULL, NULL),
(30, 21, 'Ngà Chó Điên', 'okamibada@gmail.com', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA4QAAAFeCAYAAADddNFbAAAAAXNSR0IArs4c6QAAIABJREFUeF7t3QfUdVV5J/B/CgZUAmJBLFgAUUREBVERERAlFkQmUTS4FEuMURM1OitLnDGZGGcyK5axJBY0lthgrBNMNBgUkGLDHhVBgyA6NhCxoTDnmew3ucJX3nLv+95z9++s9a0vH9x7zn5+e0e+/3t2+ZW4CBAgQIAAAQIECBAgQKBLgV/psmpFEyBAgAABAgQIECBAgEAEQoOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQI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+ioBAgQIECBAYF0EBMJ1YfYQAgstUEGwAmHtLPpn7fexFPyANrWzpm/WdM/a3OW2SXbZSgEV/mpXz1NbAKz1fi4CBAgQIECAwOgEBMLRdZkGE5grgfsmeXnbIfPhw+8nzVXrkn2GYxgq9NU5fbWurwJfvenbWuBbKqOObjg/Se2WWlNAa/qns/zmrJM1hwABAgQIEFi9gEC4ejvfJEDg36aJLr0drAPSN+KqNXx13MVBSW49rNfbq4W+Wte3nKsObf/6MNX1M8POqN9pwe+yNv1zOd/3GQIECBAgQIDAaAUEwtF2nYYTmAuBxyc5obXkbe3tWe0y+okk/zrFFtZRDbWRSx3bUFM6f2uYnlr/+1W7mS7nOq1teHN2a1e1celYh+V832cIECBAgAABAgspIBAuZLcqisC6CRw5nKf3ni08rc7Qu7wdpF5TL7+b5NIk109yq3b4+iXt7L3rDMdW1IH2F7eNXOoNXx3OXuf3be2qIxtqWmft5Fm/6p5fGtl6xq3V6N8TIECAAAECBKYuIBBOndQNCXQlcNMWvmZd9M9baKxjHOrcvjq/r972VRD88Kwf7v4ECBAgQIAAgUUVEAgXtWfVRWD9BB447LR5aJL92iNv2aZ1rqUF30ry6bae77wkb03y07Xc0HcJECBAgAABAgSuLSAQGhUECMxCYJsk+7bdPGud385J7rCZB321reurHTxrqudZSX42i0a5JwECBAgQIECAwC8LCIRGBAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgAABgdAYIECAAAECBAgQIECAQKcCAmGnHa9sAgQIECBAgAABAgQICITGAAECBAgQIECAAAECBDoVEAg77XhlEyBAgAABAgQIECBAQCA0BggQIECAAAECBAgQINCpgEDYaccrmwABAgQIECBAgAABAgKhMUCAAAECBAgQIECAAIFOBQTCTjte2QQIECBAgAABAgQIEBAIjQECBAgQIECAAAECBAh0KiAQdtrxyiZAgAABAgQIECBAgIBAaAwQIECAAAECBAgQIECgUwGBsNOOVzYBAgQIECBAgAABAgQEQmOAAAECBAgQIECAAAECnQoIhJ12vLIJECBAgAABAgQIECAgEBoDBAgQIECAAAECBAgQ6FRAIOy045VNgAABAgQIECBAgACB/wcyZ6CMj8G/owAAAABJRU5ErkJggg==', '213123123123', '1 năm', 'Đang xử lý', '2025-05-07 17:36:32', '2025-05-07 17:36:32', '2025-05-07 17:36:32', NULL, NULL),
(31, 22, 'Ngà Chó Điên', 'okamibada@gmail.com', 'data:image/png;base64,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EEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAk27r9UAAAbpSURBVDkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQICAsYBIZAgIIIIAAAggggAACCCCQI0BAmKNGGwQQQAABBBBAAAEEEECgAAECwgImkSEggAACCCCAAAIIIIAAAjkCBIQ5arRBAAEEEEAAAQQQQAABBAoQ+P/y223I3P32nwAAAABJRU5ErkJggg==', '123123123123', '1 năm', 'Đang xử lý', '2025-05-07 17:43:56', '2025-05-07 17:43:56', '2025-05-07 17:43:56', NULL, '2025-05-07 17:43:56');
INSERT INTO `signatures` (`id`, `contract_id`, `customer_name`, `customer_email`, `signature_data`, `identity_card`, `duration`, `status`, `signed_at`, `created_at`, `updated_at`, `signature_image`, `otp_verified_at`) VALUES
(32, 23, 'Ngà Chó Điên', 'okamibada@gmail.com', '336741', '231233123123', '1 năm', 'Đang xử lý', '2025-05-07 17:49:52', '2025-05-07 17:49:52', '2025-05-07 17:49:52', 'data:image/png;base64,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', '2025-05-07 17:49:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `identity_card` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee','customer') NOT NULL,
  `status` enum('active','banned') NOT NULL DEFAULT 'active',
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `identity_card`, `password`, `role`, `status`, `phone`, `address`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'User', 'user@gmail.com', NULL, '$2y$12$RMop/HL4MYed8hA1U4yC/OsPad1S.7f1JRtrk/wsONxoJfWxUQByi', 'employee', 'active', '0123456789', 'Đà Nẵng', '2025-04-02 00:23:52', '2025-04-02 00:23:52', NULL),
(2, 'Admin', 'admin@gmail.com', NULL, '$2y$12$87zbSUJenTUoyqsdLU029uj5pV1YlSEtMFKv.0bGFAWphKaXpLEfi', 'admin', 'active', '0123456789', 'Hà Nội', '2025-04-02 00:22:39', '2025-04-02 00:22:39', NULL),
(13, 'NGUYEN HUU TRUONG', 'nguyenhuutruong05092003@gmail.com', NULL, '$2y$12$sjhQiATK1MhM2N8/cmvCSO8ObCJp5/jCMyrqdBORTR64xJ8owwshq', 'customer', 'active', '0328394538', 'K45A/38 Dũng Sĩ Thanh Khê, Thanh Khê Tây, Thanh Khê, Đà Nẵng', '2025-04-10 21:12:22', '2025-04-27 01:32:16', NULL),
(14, 'Ngà Chó Điên', 'okamibada@gmail.com', NULL, '$2y$12$A58VsUyw9f1UiQH0OcLvlunfFLkGgwuQSBQXINnRJcDmMe9qwCxsm', 'customer', 'active', '0987653214', '23-Le Thanh Dong-Hai Thanh-Dong Hoi-Quang Binh', '2025-04-13 01:07:45', '2025-04-24 10:33:20', NULL),
(15, 'NGUYEN HUU TRUONG', 'nguyentruong05092003@gmail.com', NULL, '$2y$12$/Q0sbN.Vtskt/iqkW9Cdo.Hp4sAWO9lpMHyyzsCkkmIC11lvtgO6a', 'customer', 'active', '0328394538', 'K45A/38 Dũng Sĩ Thanh Khê, Thanh Khê Tây, Thanh Khê, Đà Nẵng', '2025-04-27 01:28:18', '2025-04-27 01:28:18', NULL);

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
  ADD KEY `idx_payments_method` (`method`);

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
  ADD KEY `signatures_contract_id_foreign` (`contract_id`);

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
-- AUTO_INCREMENT cho bảng `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contracts_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `contract_amendments`
--
ALTER TABLE `contract_amendments`
  ADD CONSTRAINT `contract_amendments_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `contract_documents`
--
ALTER TABLE `contract_documents`
  ADD CONSTRAINT `contract_documents_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contract_documents_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Các ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `services_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `service_reviews`
--
ALTER TABLE `service_reviews`
  ADD CONSTRAINT `service_reviews_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_reviews_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `signatures`
--
ALTER TABLE `signatures`
  ADD CONSTRAINT `signatures_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
