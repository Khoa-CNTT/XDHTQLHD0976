-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 03, 2025 lúc 03:18 PM
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
(19, 102, 5, 'HD-1746078645', '2025-05-01', '2025-11-01', 'Chờ xử lý', 1000.00, '2025-04-30 22:50:45', '2025-04-30 22:50:45', NULL);

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
(17, '2025_05_03_131510_remove_service_type_from_services_table', 13);

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
(24, 19, 1000.00, '2025-05-01', 'MoMo', NULL, 'order_681391bd6ef3c3.97821282', 'captureWallet', '{\"partnerCode\":\"MOMOBKUN20180529\",\"orderId\":\"order_681391bd6ef3c3.97821282\",\"requestId\":\"1746112957\",\"amount\":1000,\"responseTime\":1746112958903,\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"resultCode\":0,\"payUrl\":\"https:\\/\\/test-payment.momo.vn\\/v2\\/gateway\\/pay?t=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOTFiZDZlZjNjMy45NzgyMTI4Mg&s=6eb74ce3e433082280a251f340a1a8bf1bc037894d9d2f2531f2551b7a2991f1\",\"deeplink\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOTFiZDZlZjNjMy45NzgyMTI4Mg&v=3.0\",\"qrCodeUrl\":\"00020101021226110007vn.momo38620010A00000072701320006970454011899MM25121O000000550208QRIBFTTA5303704540410005802VN62450515MMTkdMGcURM1vQR0822Thanh toan hop dong 1963045154\",\"applink\":\"https:\\/\\/test-applinks.momo.vn\\/payment\\/v2?action=payWithApp&isScanQR=false&serviceType=app&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOTFiZDZlZjNjMy45NzgyMTI4Mg&v=3.0&deeplinkCallback=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess&callBackUrl=https%3A%2F%2F3623-2001-ee1-f107-46f0-1cbb-6691-463a-3752.ngrok-free.app%2Fcustomer%2Fmomo%2Fsuccess\",\"deeplinkMiniApp\":\"momo:\\/\\/app?action=payWithApp&isScanQR=false&serviceType=miniapp&sid=TU9NT0JLVU4yMDE4MDUyOXxvcmRlcl82ODEzOTFiZDZlZjNjMy45NzgyMTI4Mg&v=3.0\",\"signature\":\"ca656f4390b18596ce83c043fbef91cc52f9c757b7fa768ffe3b1c296e69e658\"}', '1746112957', NULL, NULL, NULL, NULL, 'Đang Đợi', '2025-05-01 08:22:37', '2025-05-01 08:22:38');

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
(19, 'HOME 3_NgT (Mesh)', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', 'services/1JovvZvowJ9UO7yDvNyW7ECwSWHs7ozKf7GIbVZb.jpg', 310000.00, NULL, '2025-04-13 23:14:48', '2025-04-29 13:25:12', 1, NULL, NULL),
(20, 'Home 2_NGT MESH', 'Đường truyền Internet tốc độ 500Mbps\r\n\r\nTrang bị thêm Wifi Mesh 5/6 chỉ với 30.000đ/tháng', 'Đường truyền Internet tốc độ 500Mbps\r\n\r\nTrang bị thêm Wifi Mesh 5/6 chỉ với 30.000đ/tháng', 'services/Xr3saG0IKWg33biYULRBBYUdmCgK0RfsI2Y3w4QK.jpg', 240000.00, NULL, '2025-04-10 01:30:46', '2025-04-29 13:25:31', 1, NULL, NULL),
(21, 'HOME 4_NgT (Mesh)', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', '1. Ưu đãi gói cước\r\n- Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\n- Trang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\n+  Wifi Mesh 5: \r\n     * Wifi Mesh 5 iGate EW12ST là sự kết hợp giữa chuẩn Wifi 5 và công nghệ Mesh Wifi, phù hợp với hộ gia đình với mọi cấu trúc nhà ở. \r\n     * Tốc độ lên đến 1200Mbps trên cả 2 băng tần 2,4-5GHz\r\n     * Kết nối liền mạch, chỉ tạo tên 1 Wifi duy nhất\r\n     * Hỗ trợ đồng thời 40 thiết bị\r\n     * Cài đặt dễ dàng, triển khai linh hoạt.\r\n+ Wifi Mesh 6:\r\n     *Wifi Mesh 6 iGate EW30SX là sự kết hợp giữa chuẩn Wifi 6 và công nghệ Mesh, phù hợp với các doanh nghiệp, tổ chức vừa và nhỏ, các gia đình có nhu cầu sử dụng internet cao. \r\n     * Tốc độ lên đến 3Gbps, trên cả hai băng tần 2,4 – 5GHz\r\n     * Kết nối liền mạch, phù hợp mọi ngóc ngách\r\n     * Hỗ trợ đồng thời 100 thiết bị\r\n     * Độ trễ giảm 50%. \r\n- Lắp đặt nhanh chóng, chăm sóc và hỗ trợ khách hàng 24/7\r\n\r\n2. Cước đấu nối hòa mạng\r\n - Cước đấu nối hòa mạng áp dụng cho thuê bao đăng ký mới dịch vụ cho Khách hàng cá nhân, Hộ gia đình: 300.000 VNĐ/thuê bao (đã bao gồm VAT)\r\n\r\n3. Khu vực áp dụng\r\n - Áp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố\r\n\r\n4. Tổng đài hỗ trợ \r\n - Để được hỗ trợ về dịch vụ internet và truyền hình, Quý khách vui lòng liên hệ 1800 1166 (miễn phí)', 'services/dhsRznFd88xlLjRqbmxbjntocSGLDuB77E0EQicB.jpg', 1000000.00, NULL, '2025-04-10 01:34:14', '2025-04-29 13:25:46', 0, NULL, NULL),
(60, 'Phát triển Website Bán Hàng', 'Website thương mại điện tử hiện đại', 'Tích hợp giỏ hàng, thanh toán online, responsive.', 'services/TjYf6sBR4VkfuRtr9EzPL1pznKI48XfxTs8BjHak.jpg', 5000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:26:02', 0, NULL, NULL),
(61, 'Ứng dụng di động Android/iOS', 'Lập trình app mobile đa nền tảng', 'Sử dụng Flutter, React Native, tích hợp API.', 'services/khDB2z0sjR4ttHlKFWsEiAqy7HiwMRnfnZphfV2C.jpg', 7000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:26:20', 0, NULL, NULL),
(62, 'Tư vấn triển khai ERP', 'Tư vấn ERP toàn diện cho doanh nghiệp', 'Kế toán, nhân sự, bán hàng, kho, CRM.', 'services/2Y4b65MHox9WCxOvKMZR5LLH3rMgCCIDZ8LO5w8D.png', 8000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:26:41', 0, NULL, NULL),
(63, 'Xây dựng hệ thống LMS', 'Nền tảng học trực tuyến chuyên nghiệp', 'Video, quiz, chấm điểm, chứng chỉ.', 'services/UH1gGPYAkyeSuUB7hPTSiPrqiOliQoy3cGhCaVOy.jpg', 10000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:27:00', 0, NULL, NULL),
(64, 'Tối ưu Cơ sở Dữ liệu', 'Tối ưu tốc độ và dung lượng dữ liệu', 'Query, index, backup, mô hình hóa.', 'services/ujEM9p21S3379g6zw03vMg4EPgCPpV59AKw6Vspl.jpg', 3000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:28:34', 0, NULL, NULL),
(65, 'Giải pháp CRM khách hàng', 'Quản lý khách hàng và bán hàng hiệu quả', 'Quản lý pipeline, email marketing, báo cáo.', 'services/dtOOyPjSWNgKGFqCNCS0zQOzP1gUGffrU7OC5cPr.png', 4000000.00, 3, '2025-04-10 21:27:26', '2025-04-29 13:29:07', 0, NULL, NULL),
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
(102, 'Dịch vụ bảo mật dữ liệu cao cấp', '123', '123', 'services/h75W6Ak1PCiodTECxwqSmyTxiUZSmoJ1sQm8yrex.jpg', 1000.00, 3, '2025-04-28 14:12:09', '2025-04-30 22:15:32', 1, NULL, NULL);

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
('33HcqoLUFdnfgDxyCtb6KwAKixNhPUI0o8bu9XDg', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJazl3YzJsTFRWbE5SMWR1VWpSTFprNHZTWGh5ZFdjOVBTSXNJblpoYkhWbElqb2labTFIVERVMGIxTjNhVEp6TlhGV1NVNUdPRFZqTWsxWFZsSldOMnhEVGpCSFIyTm9PVk5LTlhoMFQzazJibFZhV0V4V1JsTkVVM2RTVjIxeUsxQXpia0ZxSzJocVp6ZFZLMEZMWmt4SWNYaHhkbEprVFVSMU1XWnljSEZWUzFock0yMXpaaTh2YzBObGJHMUROVTlRYzA5M1ZFWnhRM1JzV1c1TlpsVlBXUzlhTkhGUFJYRkhTVlJzTWl0d1JGTkZRVGt5VVVKYWRsQnplQzlEVG14M1RqSjRRMWxyWlVkaFdYbFZVaTh6VjNSSWVqZHdaMFpNWWxwS1prY3ZNMmhGYURRM1VVbHVUWGwwYTNaWlpuWk9XVXBhWlU0NVkzWndZazlwTXpkd2FsWmhTbEJ4U0RrNWRFTm1SbGxoZWxNMmVXOWxRMWt6YkN0dVNIaE5RM0F2SzFCRFRUVnFkbUoxVWxNclVtNHlkbVZMVDBkamRuWlhhemMxU0ZaUFZ6ZE5WMGRYYkV4aFUwb3ZhRmxhVmpKNFJGZFBabXQyUjFCU01GYzRSRWhYYTJadlMySjZjRGh5ZUc5MVZTOUtiRUp0V1ROWVR6TmtibEJOWWtWelUwSndkV1ZQVURGaVVqbDNRVFEwUFNJc0ltMWhZeUk2SWprMk9XRTVaamMxTVRjNVpHVXlNVGsxTkdZeFptWXdaVFJpWWpVNE0yRmhOemxoT1Rkak5XTmlZamc0TnpJMU9USXdNak0zTXpBNVpUTmxZekZqT0dZaUxDSjBZV2NpT2lJaWZRPT0=', 1746277258),
('BRTUIcQW5pY9cMjMTuN7dJhK3Sjy84zVGGwDIacn', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJazFGYUROdVFuSlJUbnBXZURSMFFqRTJWa04xZVhjOVBTSXNJblpoYkhWbElqb2lSRk5RV0VFNFowVmljRU5OYkZOVEwxQnlLMGcwTTBGd2JEQlRWV2xST1ZWRWRETm9hV2c1ZERoRFoxSndSWHBqYmpST2VDczBSbXBTZG1kaU5qUlJUVWxNZW1KUU5EZHNlR3RNYWpWaGFuTnNTRGt6UVdocGNWaFVjREo2VFRCQ2JVNTZaM0JZZWpkVFZVWlpTMlpNU1RKUFJHTk9NekJzVlhnMk5YUkpaMmRTTm5FeFNubE9aVmg0VjBSamIxTndaRk53TVVSbFpIQnpSME5UWkRaNmMwY3pNalJaTkVzNVpIbHFWVU5tVVhOTWEyVlJVMWxvWTNVck9HdGxWalJxUVV4eFlqVlJSRWxPTldoVlNtODVSemxHT1RnM1QzWkhjVTh4Y0RacVFrY3hLemd5UlRSTFMyRmhLemN4ZEZwb2RVaFFOMnQxYkVreVJsTkZTMWh6ZHlzdmRrTXpVMmRKVG5aT1QxTkhSa052UTNGRFNqWlNOM2hpU1RZelRsRmpNMk4xVHk5eU5VY3JOMUpQU0d4UFVWZHpiVEJCU2tkeGFtVjNVemRMTURSRVp6ZERPV1p0TmxwTmJtMU9iVVpIWkcxcVYycE1LM2N6YlhGR2MxQjFPRzlPVlUxaFRITnNhRmRqTkhjek9Ib3hPR3hWY25KMVZWRlZWamRRVjNGQklpd2liV0ZqSWpvaVl6UmxPV1JsTnpjek5UQXhPV1V5TUdabE1XTmhZVEExWVdVMFkyWmhNVFF6WVRWbFptWTNZMkZtTnpBNFkyRm1PVGc0T0RjeVptRXlOemd4WkRBMlppSXNJblJoWnlJNklpSjk=', 1746277659),
('muKhlkx7341vTucIEZ0RKTQyeYUnMOfhnk9Nl35F', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'ZXlKcGRpSTZJblZDTDBsM1kwbFVVVFp3U2tSaWMwSXdXRGRsY2tFOVBTSXNJblpoYkhWbElqb2laVzkwUVZjck4wRm9iMW81TWtaNlZHdGliMFpFV1dSWWMxZE9kRzVhYkdSd2QwUjFiazlKTm1sVFNHNTRXa0ZGYkVkWFUyUkRTV0UzVUU5UmNTczFSMmRMTWxWWFdIWlFibXBXVDNBM01XeGphREY0ZEhaV2IweGpNV2haYTFGNGNrNW1jR3hoVmtnd2VVMWpObkFyYkVOcWFUTk1VMUUzVkVoUU5UbHdabkJtWWt0WFRuYzBRV1p3WVU1cVFVcGpTMjh3VW1sd1dHZzJZVVpYUTFncmNEQXhSMnBNU0M4dlQwOXBiVFp5VW5NM1FqUnhlRW8wWkhFd2VYTnRiV0pwWm1GMFRWUmlLMlkzUVcxeVNHTnhMeTlrV1V4aWVIQndXbXczVGtsclFUTk1VR05hYnk5SFozZHBjVUpuWW5KVFZEY3pXbU5sU2s1WWNFdENWVTFtY1VRM05WQlhOakF6V1hWTVFYZEVjREoxTTBoUFNYYzlQU0lzSW0xaFl5STZJalF6WldSalkyUXdNamt3WlROaE9ERmtaall6TUdKaVpUaGxabVJtTTJOaE16RmhZVFEyWkRobU4yTTNNekl6WWpCaE9HRmhOakk1TkRaaU5USmlOVGNpTENKMFlXY2lPaUlpZlE9PQ==', 1746168015),
('SaEmRXS7s1ghNVdBio9tkpMyCa2DW9SjxDjh3wtc', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'ZXlKcGRpSTZJbkJRZGxSbE5uTmtiR2t4ZDI5eVdHdDBkMk0yYldjOVBTSXNJblpoYkhWbElqb2lXVUZVU1dOUlkzVnZTamhwWlZKRlQxWlBaRGt3VFhOblFqVktNbWg1VTJFM1lYSkxkRlJJVGtGNGNYWXJjR0kwWm5CQ2RtVlJTMVlyV21wb2JURkNTMmhVVW05TWQyRlpaM2hrWVZoRlprNHdNV2RRV205cVVEQlhTMU5NZHpkQk9FSnZWbTVJT1dsd1VYZzVla0Z2ZEdkblJtOVRTMjQxUzFoNFEzSkNMMEZ0YjBVeWJDOXNXVkF5YVd4MlR6RkhXVzVqVGpKNlYyUkJjQzltVUZaR09ESXdNVEZWZFd4cVUzTmlaMmhtTmxkVWJXOU1NV3hzT1UwME4waExXVkZEY0VwaWFFYzNWRkZTU0d0cFpsTndXaklyV1dONGFtMWhNelZaUXk5cFkwZHViR0V3Y1dOd2EwNUJTM2RvWm1oc1Z6TjVXVkpMTVhWS2EzSTVlVzFNYkhwd1NuSXJLelJyWWpOeU5pOUZNVmhtWkhsQmVVUk5ZbTlUTHpKTVRVZG1iVEJyYzAxYWNEYzNUMFZhT1U5cEwwbE9kVlp6Ynk5aGRETmpRekZDVlhkVGRrTndhMkpsUTNBdmRrY3hTRTExSzI1akwxZzBZMUI0TDBobWQyRm1kVUpVUkZOSGVFTTBZV3RuUFNJc0ltMWhZeUk2SW1FNU5tVTVZekprTnpCbVlURm1aVE5oTVRVNU1tSTJNRFptTURsa1pHSmlNamxqTm1NMk5UQXlOR1ZtWmpVd016SmpZamxtTW1RME56SXpaVFJsTXpBaUxDSjBZV2NpT2lJaWZRPT0=', 1746113879);

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `signatures`
--

INSERT INTO `signatures` (`id`, `contract_id`, `customer_name`, `customer_email`, `signature_data`, `identity_card`, `duration`, `status`, `signed_at`, `created_at`, `updated_at`) VALUES
(26, 19, 'Ngà Chó Điên', 'okamibada@gmail.com', '435181', '044230334231', '1 năm', 'Đang xử lý', '2025-05-01 14:45:47', '2025-04-30 22:50:45', '2025-04-30 22:50:45');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT cho bảng `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `service_reviews`
--
ALTER TABLE `service_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `signatures`
--
ALTER TABLE `signatures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
