-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 13, 2025 lúc 12:42 PM
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
(27, 19, 7, 'HD-1747062496', '2025-05-12', '2026-05-12', 'Chờ xử lý', 500000.00, '2025-05-12 15:08:16', '2025-05-12 15:08:16', NULL),
(28, 108, 7, 'HD-1747065980', '2025-05-12', '2028-05-12', 'Hoàn thành', 1000000.00, '2025-05-12 16:06:20', '2025-05-13 05:59:03', NULL);

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
(4, 108, 4, 5000000.00, '2025-05-12 13:59:22', '2025-05-12 13:59:22'),
(5, 108, 2, 500000.00, '2025-05-12 13:59:22', '2025-05-12 13:59:22'),
(6, 108, 3, 1000000.00, '2025-05-12 13:59:22', '2025-05-12 13:59:22');

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
(7, 17, 'ngaphammm', '0987654321023', '2025-05-12 14:35:33', '2025-05-12 14:35:33', NULL);

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
(1, 1, 'Nhân Viên', 'Kinh Doanh', 200000.00, '2025-04-16', '2025-04-24 16:23:43', '2025-04-25 16:23:43'),
(2, 13, 'Nhân viên kỹ thuật', 'Kỹ thuật', 200000.00, '2025-04-11', '2025-04-11 04:25:40', '2025-04-11 04:25:40'),
(4, 16, 'Quản Lý Page', 'DTU', 500.00, '2025-05-11', '2025-05-11 09:39:17', '2025-05-11 09:39:17'),
(5, 18, 'sadadsa', 'sadsad', 5000000.00, '2025-05-16', '2025-05-12 17:18:21', '2025-05-12 17:18:21');

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
(22, 'create_admin_signature_fields', 18);

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
(100, 17, 'admin', NULL, 'sada', 'sadasd', 1, '2025-05-12 16:38:12', '2025-05-12 17:03:51');

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
  `status` enum('Hoàn Thành','Đã Huỷ','Đang Đợi','Đang Xử Lý','Thất Bại') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `contract_id`, `contract_duration_id`, `amount`, `date`, `method`, `transaction_id`, `order_id`, `payment_type`, `payment_response`, `request_id`, `partner_code`, `signature`, `ipn_response`, `error_message`, `status`, `created_at`, `updated_at`) VALUES
(29, 28, 1, 1000000.00, '2025-05-12', 'VNPay', '14952912', '28-1747065992', 'ATM', '{\"vnp_Amount\":\"100000000\",\"vnp_BankCode\":\"NCB\",\"vnp_BankTranNo\":\"VNP14952912\",\"vnp_CardType\":\"ATM\",\"vnp_OrderInfo\":\"Thanh toan don hang\",\"vnp_PayDate\":\"20250512230716\",\"vnp_ResponseCode\":\"00\",\"vnp_TmnCode\":\"O5KTL29X\",\"vnp_TransactionNo\":\"14952912\",\"vnp_TransactionStatus\":\"00\",\"vnp_TxnRef\":\"28-1747065992\",\"vnp_SecureHash\":\"0460093bf78c6791b3ffa86004affc99369dc91b9e8b48d3714792f32aa4840f6b1a054ff46a73f663f8de9f7e5805f7b451b96f1ce3253689155634f4461713\"}', NULL, NULL, NULL, NULL, NULL, 'Hoàn Thành', '2025-05-12 16:07:01', '2025-05-12 16:07:01');

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
(19, 'HOME 3_NgT (Mesh)', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', 'services/1JovvZvowJ9UO7yDvNyW7ECwSWHs7ozKf7GIbVZb.jpg', NULL, '2025-04-13 23:14:48', '2025-05-03 06:49:15', 1, 3, NULL),
(20, 'Home 2_NGT MESH', 'Đường truyền Internet tốc độ 500Mbps\r\n\r\nTrang bị thêm Wifi Mesh 5/6 chỉ với 30.000đ/tháng', 'Đường truyền Internet tốc độ 500Mbps\r\n\r\nTrang bị thêm Wifi Mesh 5/6 chỉ với 30.000đ/tháng', 'services/Xr3saG0IKWg33biYULRBBYUdmCgK0RfsI2Y3w4QK.jpg', NULL, '2025-04-10 01:30:46', '2025-05-03 07:14:10', 1, 3, NULL),
(21, 'HOME 4_NgT (Mesh)', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', '1. Ưu đãi gói cước\r\n- Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\n- Trang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\n+  Wifi Mesh 5: \r\n     * Wifi Mesh 5 iGate EW12ST là sự kết hợp giữa chuẩn Wifi 5 và công nghệ Mesh Wifi, phù hợp với hộ gia đình với mọi cấu trúc nhà ở. \r\n     * Tốc độ lên đến 1200Mbps trên cả 2 băng tần 2,4-5GHz\r\n     * Kết nối liền mạch, chỉ tạo tên 1 Wifi duy nhất\r\n     * Hỗ trợ đồng thời 40 thiết bị\r\n     * Cài đặt dễ dàng, triển khai linh hoạt.\r\n+ Wifi Mesh 6:\r\n     *Wifi Mesh 6 iGate EW30SX là sự kết hợp giữa chuẩn Wifi 6 và công nghệ Mesh, phù hợp với các doanh nghiệp, tổ chức vừa và nhỏ, các gia đình có nhu cầu sử dụng internet cao. \r\n     * Tốc độ lên đến 3Gbps, trên cả hai băng tần 2,4 – 5GHz\r\n     * Kết nối liền mạch, phù hợp mọi ngóc ngách\r\n     * Hỗ trợ đồng thời 100 thiết bị\r\n     * Độ trễ giảm 50%. \r\n- Lắp đặt nhanh chóng, chăm sóc và hỗ trợ khách hàng 24/7\r\n\r\n2. Cước đấu nối hòa mạng\r\n - Cước đấu nối hòa mạng áp dụng cho thuê bao đăng ký mới dịch vụ cho Khách hàng cá nhân, Hộ gia đình: 300.000 VNĐ/thuê bao (đã bao gồm VAT)\r\n\r\n3. Khu vực áp dụng\r\n - Áp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố\r\n\r\n4. Tổng đài hỗ trợ \r\n - Để được hỗ trợ về dịch vụ internet và truyền hình, Quý khách vui lòng liên hệ 1800 1166 (miễn phí)', 'services/dhsRznFd88xlLjRqbmxbjntocSGLDuB77E0EQicB.jpg', NULL, '2025-04-10 01:34:14', '2025-05-03 08:32:40', 0, 3, NULL),
(60, 'Phát triển Website Bán Hàng', 'Website thương mại điện tử hiện đại', 'Tích hợp giỏ hàng, thanh toán online, responsive.', 'services/TjYf6sBR4VkfuRtr9EzPL1pznKI48XfxTs8BjHak.jpg', 3, '2025-04-10 21:27:26', '2025-05-03 07:14:21', 0, 1, NULL),
(61, 'Ứng dụng di động Android/iOS', 'Lập trình app mobile đa nền tảng', 'Sử dụng Flutter, React Native, tích hợp API.', 'services/khDB2z0sjR4ttHlKFWsEiAqy7HiwMRnfnZphfV2C.jpg', 3, '2025-04-10 21:27:26', '2025-04-29 13:26:20', 0, 1, NULL),
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
(102, 'Dịch vụ bảo mật dữ liệu cao cấp', '123', '123', 'services/h75W6Ak1PCiodTECxwqSmyTxiUZSmoJ1sQm8yrex.jpg', 3, '2025-04-28 14:12:09', '2025-04-30 22:15:32', 1, 1, NULL),
(108, 'nga dep trai', 'cmm', 'hehehehehehe', 'services/hXP7DvRPw2prfvYjDkjjrotv3HN3Z6MMkVz5shnx.jpg', 3, '2025-05-12 13:59:22', '2025-05-12 13:59:22', 0, 1, NULL);

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
('7vZzD5ukcgii9VD97BiQwsMbAAl397SdicUBt51y', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJbkZMWmxBNU5rRk1lV1phVERsTFJUZGlRa1JTTDNjOVBTSXNJblpoYkhWbElqb2lTbkJ3VkZFemVVNWtaMWRpVVdKV1FsWnJXSGQyYlUxeVRVaHBNbXhsV0dGbU5pOVhUVVUxYmt4VWRESkRVMnhvWVRRNU1GUjFSRE5vVmtaV1NYWm9OMDB6WnpOcVNXMHJla3M1VTFWUmFVNXBkQ3RNVWsxamMyZHBSMGRNZW1wNWMzVkVaMVJ0YTNCMVJTdG5Sa3RQZDFGSmFtaDZaVXd2UVZVNVIwbExPRFpwWW5veVFYbzFiSFJEY0RjemJETkpaVGx3VlRWeWRVVmFUMGhGUnl0NlNrUlFPRVp5YXk5cloxbGlkMU12ZUdoalUwWnBRekJZYVdKRlpYaEVNVTFaU0VOWGRUTmFSbE54ZGtoT2NYbFpaaXRTZDBKd1JtMURURTlPVkUxbWRsTTFOQ3MwWVZKVlozZHBaVEpMUm5GWFNtOXViRkZuS3pGbk1VdG5LMGxNZWxOR2FGUTJiWFJRYTJaYVVIQkpRbk5hTkRkTlIyUkxUSGN2VVdKRmJtbzFiSGxESzNkbE5sSTVVVVphU21KSU5ucFlVVFZJUkROSlpsbG9VSFo1Y0c0d1VXd3ZjMmhaVld4NlNWSnNaRTVPTkdoWGMzTlhSVVpWTkVsV01tTlJUMGNyTlV4QmNFRkVlSEZ6UFNJc0ltMWhZeUk2SWpVMFkyTXpPRGN4TlRZeU9HRXhORGN5TjJaalpqUTFZMkU1TXpVMFptTXdaV1ZoWXpGaU16bGpaVEU0WldNNU9ESXdOV1E0TTJSbFltUXpOVFU0WkRnaUxDSjBZV2NpT2lJaWZRPT0=', 1747125509),
('qeQTeoTtvQOF4WQBn5bE1FUx6zfWJXxt8xBLZx5E', 17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJa040V1dkblFrWm9XR2RhUldSSFMydEhVVXhhUkhjOVBTSXNJblpoYkhWbElqb2lkVEIxYkRFMVRFTklPSEE1VGpjdmRHVklOVEZPT1ZGbE5WbDNkRkUzUkhKVmRrcFBSalpGVDFwNmFtTktRa3N5ZUdoUVpHSnVRMUUyZVhWVVdVdFplaTh4ZGxoWk5WcHZORmxRS3k5YWNURXJaVmxGVTBKVWJsZHFhWFJ3VTJwRFVHNHZiRzl5UlM5WlMzb3JkMDV5VW1SbU5GbHFPVFV5Wm1keU4weGtObFJ0TVdOUFVYSmxPRTl6Y0RJME4yRnNOR28xVmpVNFoyeERTbFZDYUhaSWIwRnBlRmhYY0RJNGMyOHpOR0ZXV2xsTWFqZ3hZMnM1VDFsTlExSndWRlF5Tlhrdkx6RkhVelJuTVhOclFVRnBlRW94VUcxamEwWkxWRmhEV2pGSGIzZE5TU3M0U1ZSQ2N6RXdSbGRrVG1vMFMyZ3lhalZGV2taWkwySXhMMWd3VUdZMk9Fa3hTbU5rVVRGbFNTc3lOelJzY0dKTGFVUnFhRkZNZVZFeFdHeHNNRkZXUW1OeGExRkVNbXA0ZGtFMU5EUm5jWFphYkhKcWFYZFFTVlZhVGxCYUswcDZMekZ0V2pSTGFrdHlWVTFMVERWcldUSnNZalZsTlc5WmFrdGxVa1JoUmtaRFIwWk5SSE5tVnpoWFFYWnNSbEZET0V4RmNreGFNa3QzVjBWVFNsUTVNV05JVjNOb1VqRndRbXRhUkVjNFlYZFNWbTB6VUc0d09HMUtRV3hoWnpsR1dXbE9VbVZ0TlU5blNYUmhlRmRJTVdWVWRtdHpWRlZIWVU5alFqZEpXbTVXZVZsSVJ6WjRSVkU1VG5neVRqbHRSM2xxWnpsTlVtMXVOVFFyUkRSTmQzSnplbTlGYTFGeVF6ZFpVRWxSY1dWT1JXaDFUbFJxS3pCNFp6TkVNbWRtUzNoT2NtUXpWeTkwWm1sRlozVmplV280ZGxCeVRHNURORTFUTVc5U1ZsVTNXbEZyUVZkQlpscGtWM05yV1djd0swNTVlWHBaYmpSaE9YQnhWSE5vYzBObFdsSndXbUp3Y0VSNFEzTlRTSG92UlRScE0yZGxSbmQyTW1GTE5GWlVaa1IzU2l0a1JUMGlMQ0p0WVdNaU9pSXpNVGszWmpobU56ZGtNalprTkRObE5URmpNRFkyTkRreU9UYzJORGc1TkdRMFpHUmpNVGM1TURZM1pEbG1PVE0wWkdFMU56VmtOVGszTlRGaFkyUmtJaXdpZEdGbklqb2lJbjA9', 1747123245);

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

INSERT INTO `signatures` (`id`, `contract_id`, `customer_name`, `customer_email`, `signature_data`, `identity_card`, `contract_duration_id`, `status`, `signed_at`, `created_at`, `updated_at`, `signature_image`, `admin_signature_data`, `admin_signature_image`, `admin_signed_at`, `admin_name`, `admin_position`, `otp_verified_at`) VALUES
(36, 27, 'ngapham', 'okamibada@gmail.com', '958506', '098765432100', 2, 'Đang xử lý', '2025-05-12 15:52:27', '2025-05-12 15:08:16', '2025-05-12 15:08:16', 'data:image/png;base64,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', NULL, NULL, NULL, NULL, NULL, '2025-05-12 15:08:16');
INSERT INTO `signatures` (`id`, `contract_id`, `customer_name`, `customer_email`, `signature_data`, `identity_card`, `contract_duration_id`, `status`, `signed_at`, `created_at`, `updated_at`, `signature_image`, `admin_signature_data`, `admin_signature_image`, `admin_signed_at`, `admin_name`, `admin_position`, `otp_verified_at`) VALUES
(37, 28, 'ngapham', 'okamibada@gmail.com', '364259', '098765432101', 3, 'Đang xử lý', '2025-05-12 16:06:20', '2025-05-12 16:06:20', '2025-05-12 16:06:20', 'data:image/png;base64,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', NULL, NULL, NULL, NULL, NULL, '2025-05-12 16:06:20');

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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` enum('Chờ xử lý','Đang xử lý','Đã trả lời','Đã đóng') DEFAULT 'Chờ xử lý',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `identity_card`, `password`, `role`, `status`, `phone`, `address`, `avatar`, `created_at`, `updated_at`, `remember_token`) VALUES
(2, 'Admin', 'admin@gmail.com', NULL, '$2y$12$87zbSUJenTUoyqsdLU029uj5pV1YlSEtMFKv.0bGFAWphKaXpLEfi', 'admin', 'active', '0123456789', 'Hà Nội', NULL, '2025-04-02 00:22:39', '2025-04-02 00:22:39', NULL),
(13, 'NGUYEN HUU TRUONG', 'nguyenhuutruong05092003@gmail.com', NULL, '$2y$12$sjhQiATK1MhM2N8/cmvCSO8ObCJp5/jCMyrqdBORTR64xJ8owwshq', 'customer', 'active', '0328394538', 'K45A/38 Dũng Sĩ Thanh Khê, Thanh Khê Tây, Thanh Khê, Đà Nẵng', NULL, '2025-04-10 21:12:22', '2025-04-27 01:32:16', NULL),
(15, 'NGUYEN HUU TRUONG', 'nguyentruong05092003@gmail.com', NULL, '$2y$12$/Q0sbN.Vtskt/iqkW9Cdo.Hp4sAWO9lpMHyyzsCkkmIC11lvtgO6a', 'customer', 'active', '0328394538', 'K45A/38 Dũng Sĩ Thanh Khê, Thanh Khê Tây, Thanh Khê, Đà Nẵng', NULL, '2025-04-27 01:28:18', '2025-04-27 01:28:18', NULL),
(16, 'Pham Quang Ngà', 'okami@gmail.com', NULL, '$2y$12$aCBCzBDJb4eSgCX.8AG1UutLIG33nGoyHoP7NVtXHkduVz09Cib76', 'employee', 'active', '0987653214', 'hahaha-hahaha-hahah', 'avatars/KuESARkRoejgCurFrbnYrADKYWeIKVvoB4Jz5qXx.png', '2025-05-11 09:39:17', '2025-05-11 10:16:00', NULL),
(17, 'ngapham', 'okamibada@gmail.com', NULL, '$2y$12$ZHD8jMlEPM2BSp5BnWJZpOpYZU5TG2udoX1RtDbkwMf9ZW.bjwH9i', 'customer', 'active', '0987653214', '12312313123', NULL, '2025-05-12 14:35:33', '2025-05-12 14:35:33', NULL),
(18, 'sâccsacas', 'okami213bada@gmail.com', NULL, '$2y$12$B.rgn5Y8kjxmnH4oKOUeqO.ovgnV3u1AhUQE2Ss3X9b1AtmsWGPsu', 'employee', 'active', '0987654321', 'sadsada', NULL, '2025-05-12 17:18:21', '2025-05-12 17:18:21', NULL);

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
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `durations`
--
ALTER TABLE `durations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `support_responses`
--
ALTER TABLE `support_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
