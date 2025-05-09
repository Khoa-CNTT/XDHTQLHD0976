-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 09, 2025 lúc 06:24 PM
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
  `status` enum('Chờ xử lý','Hoạt động','Hoàn thành','Đã huỷ','Yêu cầu huỷ') NOT NULL DEFAULT 'Chờ xử lý',
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contracts`
--

INSERT INTO `contracts` (`id`, `service_id`, `customer_id`, `contract_number`, `start_date`, `end_date`, `status`, `total_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(26, 107, 5, 'HD-1746801786', '2025-05-09', '2028-05-09', 'Hoàn thành', 50000.00, '2025-05-09 14:43:06', '2025-05-09 14:43:47', NULL);

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
(28, 26, 50000.00, '2025-05-09', 'VNPay', '14948163', '26', 'ATM', '{\"vnp_Amount\":\"5000000\",\"vnp_BankCode\":\"NCB\",\"vnp_BankTranNo\":\"VNP14948163\",\"vnp_CardType\":\"ATM\",\"vnp_OrderInfo\":\"Thanh toan don hang\",\"vnp_PayDate\":\"20250509214410\",\"vnp_ResponseCode\":\"00\",\"vnp_TmnCode\":\"O5KTL29X\",\"vnp_TransactionNo\":\"14948163\",\"vnp_TransactionStatus\":\"00\",\"vnp_TxnRef\":\"26\",\"vnp_SecureHash\":\"40670b8968b3748b634a229519a512ab0533e502067c719bab44653daf74d9161fe3d6fe7cb1c189666952a1fbd3780e957547aff6f9a737edfd496406b5d601\"}', NULL, NULL, NULL, NULL, NULL, 'Hoàn Thành', '2025-05-09 14:43:47', '2025-05-09 14:43:47');

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
('Ok3FtOfq5EDzvhKckgdUWjisp7BuZBw7r3uRjy11', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJakpJZDBsb1JIVktWWFExU0M5dGNFVkVaazF4ZDNjOVBTSXNJblpoYkhWbElqb2lVR2RyY1dWbU9XeHVjbmd2YlUxeWNFVmpkVk5oU0VreVFXOVhibGRFTTJkR1VpOURRWE56Vm1WM1FqSTJMemt6VTNoNFlrUnZka2RKYTI1aFpHeEJRaTlEUTFnMVFXZHhXRTE1ZVVrNGFFWTBUbVoxWjJGU2RYQnZSVFZLY21oNlRVZFJVM1J6UTBjeU9FRXJaMEZWU0hGbVZGQnNMMFl2T1M4MlRYVjFhM2syU0dsc1dGRmlOMVoyWW5vd01HRjJhR2QxWTFGYU9Gb3phV041YW5GWWEycEVWRGhZV2toSE1IUkhiMFpqTVhGUE1EUldWbVIzU1UxSWNXMUdlRkZXWlRZM2MyY3ZlbXM1YUdOdmNuSkVPV2RYYW1oalRuWnVXVUk1WWxVNE1EZEpVRXA2SzB4amNuUndla1I2VkhRMlUwbFZNM0JYZGxCdGVVTTJXRE5sYldObU5FdHNaRXR3WmxSUWRUUjNhVll3TXpKd1pXaFRVM0pKZFdzMVEzbFdPRVJPYlcxeE1FOUhNRlk1WW1OWGNrdFJkak5zVlhWUFVYSnZMMDVVY3k5VmNqZEJLM3BoWkVSSVFVVndiVVp1VG5reEwyOUpSVGQ2U0dORVFuZ3ZUa3hJT1hvNE9XVlFTak52UFNJc0ltMWhZeUk2SW1SaE1UTmpObUUyTkRZek1EWTBOekJqTkRJNE1UVTNZemczTVdOak56TTVNMlUxT1dZeVpqYzVPREkzTmpnd01tVm1aRGMzT0RZNU1URTBaVEl5TjJVaUxDSjBZV2NpT2lJaWZRPT0=', 1746805044),
('pTl2sUACUW1xB1rIKwlHbXa9yxUTtCDUj90Zn20x', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'ZXlKcGRpSTZJa1oyTTBSVGF6WlZUVFk0UjB0UlRuRktWWFpwWlZFOVBTSXNJblpoYkhWbElqb2lSM2wwT0ZKQ1FpdFpRbWh5UjNKUWRVRjRUVUY0Y0VvNWNITk1TWGRCZHpKWldWWnRNbmhVWjA1c1owcEVXSFpWZUc5UkwwVlpaRzFuVlM4MFRFUmlUeXRCWkdKVWRqSTJOblp1V2t3NVVXSlNjUzl2VDA1dU9EZGxLMms1WlRBeVZVY3dUVU15WjA5S1dEVTNVMFJRVHpKMldUZDFNamhZTVd4M00yVnZOMjUzTW1kamVWaHJaMFJvUzI1UWIwMUxhRkpvVlRCNUwwaEdLM2RPTVZkT01VMVhTVTQyU0hwMGJrNVlVREEwWjB4bWNrSmFUVFptUTBJMVpVWXhUM000U1ZNeFprNUxRMFpxT0RoSFVEZzRNa3BCUjJaVU5UQlplaTltS3paU1puSk1OM05rY1hWSVQwWlFWM05yZWt4dk5FazJZblI0TUZKTk9XOHZMMDRyU0RoRlRWbEJLM2hCTVV4VFFtTk1iMDVrTUV0NGNqRmFWRVZ0V1haMVVXcDJPRlJWZUZOdVNFcFhZVUpRVDBSd1IyRlhVbEJQUVZkcFVHUmphMWRGWWtKVFdtbHZUV00xVW1WR1pVNUVjVXBFVWprMUwyNVBOMlZNZDJZdldrb3pUbVIzY1hsdmF5dDRObEJqUFNJc0ltMWhZeUk2SWpneE5USmpNMk0yWlRrd01qazVNekZsTldaak1qazFZamcyTTJZMk5tWmhaVGxoT0RZelpESmxOREkyTURWaU1tTm1PVEV6TjJFMU16aGlOekUxT0RjaUxDSjBZV2NpT2lJaWZRPT0=', 1746807609);

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
(35, 26, 'Ngà Chó Điên', 'okamibada@gmail.com', '278148', '123123123123', '3 năm', 'Đang xử lý', '2025-05-09 14:43:06', '2025-05-09 14:43:06', '2025-05-09 14:43:06', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA4QAAAFeCAYAAADddNFbAAAAAXNSR0IArs4c6QAAIABJREFUeF7t3Qn8tuWY//HPnzFKUrIkEsJYyhaKSiJZikhUSim0ELJkT5M9hiwllBQilQgh0aZCIorskrIkpEKWMeN/fc3xm/l5PMtvuZdr+Vyv1/N6Wu77us7jfd71/I77PM/j+H94KaCAAgoo8I8CqwJ3Ah4ArAPcDXjsEkhnA38BvtT8u68DlwIXTBEy490aeDqw/qxx/AD4JHAq8Nkpjs9HK6CAAgoo0EqB/9fKUTkoBRRQQIFJCawFrA48FNgcuBWw6ayHX1sJ30XAt5sk8ZRK/iY1voU8567Adk2Cug2w4RI3uKqJ9QtNrGcCnwB+vJAH+B4FFFBAAQX6ImBC2JeZNA4FFFBgbgJJ+rYE7lArafeY9bas+l3RJFGfrqTvPOCPc7tta19104r3SZXwJvld8vpmkwR/Hki85wA/a200DkwBBRRQQIERC5gQjhjU2ymggAItEbgjsCawGfAQIIlfVgNzZXvnT2rFL9sor25ec1ZLxj3uYdyltsJmC+y9gHWX8cCsiH632YL6U+A04L/ccjruqfH+CiiggALTEDAhnIa6z1RAAQVGK5BtntkmmdW/bPd8IHCjekRWu5Ls5Szd5U2CeLrbJP8BfxVgi+ac4X2B+wG3reR5eTOULadZOY1r/hz9HLBaJdZfHe3UejcFFFBAAQXGK2BCOF5f766AAgqMWiCrWhsDf6vzcTkjdzvgxs25uWx9/GJt+8wqYBKXS0Y9gIHcb4NKrm8BbARk62kSxhVdKbSTAjaPWdEL/fcKKKCAAgq0QcCEsA2z4BgUUECBpQvcubZ7pmpmKn1mFSuJya9qC+O3KgE8t37/vZBjF7gnsAZw7yrGk624NwOyFTUrtblyFjNbdb0UUEABBRRovYAJYeunyAEqoMCABPYE1quWD9n2meQvWz6z3TPtHbIdMb8uG5BJF0Jduylck6Q8LTrOqIqtXRi3Y1RAAQUUUODvZx+8FFBAAQWmK5BEItUts/KUVghJ/r4P/BD40XSH5tNXIHDzWhHMGc7zl9LmQkAFFFBAAQVaLWBC2OrpcXAKKDAAgZcCL6qKls+uFcABhN2LELNF9CtViCa/bw38uheRGYQCCiigwGAETAgHM9UGqoACLRPYBHhDJRP5/b3An1o2RoezbIFbVhuKnCXMWc5H2r/Qj4sCCiigQBcFTAi7OGuOWQEFuiywA/A84PZNIZJjgdcDV3Y5oIGOPWcF0+YjfQofDnxnoA6GrYACCijQcQETwo5PoMNXQIFOCOSM4DObFaQ9gFQCfQ/w5mar6HWdGL2DnC2wUlPx9ThgG5NBPxgKKKCAAn0QMCHswywagwIKtFUg/QIPbCpQbtk0Oz8R+EjTQP7DbR2s45qTwFuBfZtV3msqKUyvRy8FFFBAAQU6K2BC2Nmpc+AKKNBigbWAd1cPwSOBQ6tiaIuH7NDmIPB04Ih6XQrIfHoO7/ElCiiggAIKtFrAhLDV0+PgFFCggwKPawrFJAlMkZh/d1toB2dw6UNeH/hm/atX1dz2JjgDUUABBRQYroAJ4XDn3sgVUGD0AtkaegywT20PHf0TvOM0BFYFLqpCQFkh3HMag/CZCiiggAIKjEPAhHAcqt5TAQWGKJA2Esc31SZTRTRN5r36I5AiMtsD328qw96lP2EZiQIKKKCAAmBC6KdAAQUUWLzAGsCFzZbC7apR+eLv6B3aIrAT8MEazG2a1cGft2VgjkMBBRRQQIFRCJgQjkLReyigwNAFzmy2Ex5dv4Zu0af4VwYua4oC3byS/Y/2KThjUUABBRRQIAImhH4OFFBAgcUJPKXaD2R10KtfAq8FXgaktUSqiqaHpJcCCiiggAK9EjAh7NV0GowCCkxY4FZNj8FzgQe5lXDC8uN/3JrAFcAvgftVE/rxP9UnKKCAAgooMGEBE8IJg/s4BRTolUB6DWb1aOaMWa+CG3gwM6uDzwXeNnALw1dAAQUU6LGACWGPJ9fQFFBgrAKpNnls05x8Q+CvY32SN5+GwFW1RfTeQP7aSwEFFFBAgV4KmBD2cloNSgEFJiCQVgRvry2jE3icj5igQM4Lngx8ANh1gs/1UQoooIACCkxcwIRw4uQ+UAEFeiCwHnBIs130oT2IxRD+WeBwYI+m8Norm391oEAKKKCAAgr0WcCEsM+za2wKKDAugZwdTBP608b1AO87VYG0mrgtcB/gG1MdiQ9XQAEFFFBgzAImhGMG9vYKKNA7gRdUovDk3kVmQBG4HXApcCWQSqNeCiiggAIK9FrAhLDX02twCigwYoHdgB2AHYFrRnxvb9cOgczxUUDOiGaevRRQQAEFFOi1gAlhr6fX4BRQYIQCKS6SJvRpQH/1CO/rrdolcETTc/DpTQ/CvYFsDfZSQAEFFFCg1wImhL2eXoNTQIERCTweeBGwlS0IRiTa3tv8uikYdLM6Q/jT9g7TkSmggAIKKDAaARPC0Th6FwUU6K/A5rVS9DDg8v6GaWTAtsBHgU8Aj1VEAQUUUECBIQiYEA5hlo1RAQUWKrABcCKQpPAnC72J7+uMwFnAZnVONFVkvRRQQAEFFOi9gAlh76fYABVQYIECdwI+U4VFvrbAe/i27gjMrA5+ELCCbHfmzZEqoIACCixSwIRwkYC+XQEFeilwX+CrwDbAJ3sZoUEtKfAd4PbNfGfuvy2PAgoooIACQxEwIRzKTBunAgrMVWCtSgafC5ww1zf5uk4LvAp4BfBmYL9OR+LgFVBAAQUUmKeACeE8wXy5Agr0WuDWwPnAK4HDex2pwc0IpFjQ54Bv1IqwhYP8bCiggAIKDErAhHBQ022wCiiwHIFbVTL4BuBQpQYhcHfgi8Bfgfs3fSZ/PIioDVIBBRRQQIFZAiaEfhwUUECB/+k7dwpwGvASQQYhsDrwPeCWTbQH1qrwIAI3SAUUUEABBWYLmBD6eVBAgaELJDE4GzgX2HvoGAOJf9VaGVwfeCvwvIHEbZgKKKCAAgr8k4AJoR8KBRQYukDOj10J7Dx0iIHEfwvgY825wU3qnOheA4nbMBVQQAEFFFiqgAmhHwwFFBiywBeAq5qCIo8bMsLAYs9K8MbAEcCeA4vdcBVQQAEFFHCF0M+AAgooUAKfAlYBNldkEAJZGcycp3jMe4A9BhG1QSqggAIKKLACAVcI/YgooMAQBY4CNgQ2A34zRICBxbxmnRlcF3htU1V0/4HFb7gKKKCAAgosU8CE0A+HAgoMTeCdwEPq1y+GFvwA470DcE5zXjA9Jp8FvGOABoasgAIKKKCACaGfAQUUUAA4qM6NbQBcqkjvBR4AfKJpJfIn4Bm1ZbT3QRugAgoooIAC8xFwhXA+Wr5WAQW6LLBf9ZrbCPhWlwNx7HMS2LYKx1wG5K9/Mqd3+SIFFFBAAQUGJmBCOLAJN1wFBiqQ1gLvqoIiXx2owZDCTvXQdzdnRE8HtgOuHlLwxqqAAgoooMB8BEwI56PlaxVQoIsC2wNHAk8ETuliAI55zgI3BV4IvBT4d+BVc36nL1RAAQUUUGCgAiaEA514w1ZgIAJbAicC2S56+EBiHmqYt6m5Xg94XrWWGKqFcSuggAIKKDBnARPCOVP5QgUU6JhAzgp+uRnzgXV2sGPDd7jzEEiRoI8BvwWyIvz9ebzXlyqggAIKKDBoARPCQU+/wSvQW4H1m7YSZwFvAV7T2ygNLAJPA94EfL4pHLN7sxr8e1kUUEABBRRQYO4CJoRzt/KVCijQDYFbAl8HvlLVJbsxakc5X4GcFzypKRyzWZ0bTFLopYACCiiggALzFDAhnCeYL1dAgVYLJEk4G7io2Ta4U6tH6uAWI7BmnRG8J7BDbQ1ezP18rwIKKKCAAoMVMCEc7NQbuAK9FEgieIMmKdyiaUD/815GaFC7VAuRC4EnA5dIooACCiiggAILFzAhXLid71RAgXYJfKipMnmPSgavbNfQHM2IBNJO4nXAW4H9m62ifxjRfb2NAgoooIACgxUwIRzs1Bu4Ar0SSJ/BbBFNZdGsEnr1S+AOwPuBOwM7Amf2KzyjUUABBRRQYHoCJoTTs/fJCigwGoH0nHttU0RmKxOF0YC27C7Z/nsE8D1g76aS6E9aNj6Ho4ACCiigQKcFTAg7PX0OXoHBCzwBOAF4DHDy4DX6B5CWEu8Bng0c2r/wjEgBBRRQQIHpC5gQTn8OHIECCixMYBPgnDpT9vKF3cJ3tVRgDeADza87As8AzmjpOB2WAgoooIACnRcwIez8FBqAAoMU+LfaHvpR4FmDFOhv0A8Hcib0I8BBTUL4y/6GamQKKKCAAgpMX8CEcPpz4AgUUGB+AqsAF1RbiWwV/f383u6rWyywTzO2A4GXVFLY4qE6NAUUUEABBfohYELYj3k0CgWGJHAWcKeqOHndkALvcayrAa9ozoHer1Z8v9XjWA1NAQUUUECBVgmYELZqOhyMAgqsQOAQ4LHAllV1UrDuC2xe5wXfCGR+vRRQQAEFFFBgggImhBPE9lEKKLAogbSXOBh4HPDxRd3JN7dBYCXg+c2W3/2ARzZtQ77ShkE5BgUUUEABBYYmYEI4tBk3XgW6KfAg4AvArrWa1M0oHPWMwE0rub8GeK4sCiiggAIKKDA9ARPC6dn7ZAUUmJvAXYGvVpGRfef2Fl/VYoGcE3wL8FbgxBaP06EpoIACCigwCAETwkFMs0Eq0FmBVYHv1HnBLTobhQOPwOrNPD4JuBewtyQKKKCAAgoo0A4BE8J2zIOjUECBpQucWs3Jk0TYXqK7n5J7VjJ4cVMh9pjuhuHIFVBAAQUU6J+ACWH/5tSIFOiLQJqTPx5IMnF5X4IaWBxrAFsDdwOOBr4/sPgNVwEFFFBAgdYLmBC2foocoAKDFHhqnRlMe4nPD1Kg+0GnncT9gfQU/Ez3wzECBRRQQAEF+ilgQtjPeTUqBbossBmQ5vP7A6/tciADHntagyQZPB64cMAOhq6AAgoooEDrBUwIWz9FDlCBQQmsWUVkPgXsMqjI+xHsasDLm/YglwDvA/7Yj7CMQgEFFFBAgf4KmBD2d26NTIGuCaRReXoNXgdku6FX9wQ+B5wAHN69oTtiBRRQQAEFhilgQjjMeTdqBdoo8BEg20XvA/ysjQN0TMsV+I9mm+9fgZfqpIACCiiggALdETAh7M5cOVIF+izwSuAA4L7ABX0OtKex7Qc8ENiup/EZlgIKKKCAAr0VMCHs7dQamAKdEcj20DOAHZv2BMd1ZtQOdEYgTea3AbaSRAEFFFBAAQW6J2BC2L05c8QK9Engrs020dOrLcHT+hTYQGLZuekRmXl76EDiNUwFFFBAAQV6J2BC2LspNSAFOiOQIjLfAH4MPKozo3agMwKZs7QGeQTwe1kUUEABBRRQoJsCJoTdnDdHrUAfBI4G0nj+nsBv+hDQgGK4H/BuYGvgigHFbagKKKCAAgr0TsCEsHdTakAKdELg2bW6lHNnX+vEiB3kjMA6tcU3BWS+K4sCCiiggAIKdFvAhLDb8+foFeiiwEZNn8Eza3Up5we9uiNw9yoA9Phmdffc7gzbkSqggAIKKKDAsgRMCP1sKKDAJAWyunQe8DrgkEk+2GctWmD1KgC0T3Nu8EuLvps3UEABBRRQQIFWCJgQtmIaHIQCgxFIEZk0nc/ZM6/uCKxd20RfC3y4O8N2pAoooIACCiiwIgETwhUJ+e8VUGBUAicD6wMbAleO6qbeZ+wCKwMfA04C3jX2p/kABRRQQAEFFJiogAnhRLl9mAKDFcj20F2BTYBvDVahm4GfVtt8X9bN4TtqBRRQQAEFFFiegAmhnw8FFBi3wKOBY4BtqyDJuJ/n/UcnkFXBHwEvGN0tvZMCCiiggAIKtEnAhLBNs+FYFOifwAPq7NlBwBv6F16vI3pxs0303sBTgT/2OlKDU0ABBRRQYMACJoQDnnxDV2DMAqs0xWPOBy5q+tXtOOZnefvRCiQJ3AV4yGhv690UUEABBRRQoG0CJoRtmxHHo0B/BNKn7hbAxsCv+xNW7yPZBngTkNXdq3ofrQEqoIACCigwcAETwoF/AAxfgTEJHA9sUUnFD8b0DG87eoGsCKaS6JbNVtHLRn9776iAAgoooIACbRMwIWzbjDgeBbovkKbzL62Kol/sfjiDiWCD6jH4OODbg4naQBVQQAEFFBi4gAnhwD8Ahq/AiAWeAJxQCWEKyXh1Q2Ad4AvNec/HAxd0Y8iOUgEFFFBAAQVGIWBCOApF76GAAhG4W60sfRp4InCdLJ0QuBXweeCFVRG2E4N2kAoooIACCigwGgETwtE4ehcFhi6QpOIs4K/AA4Frhw7SkfhvBpxeRWQ+0JExO0wFFFBAAQUUGKGACeEIMb2VAgMWSFKRgiR3B74zYIcuhb5anRlMIu/23i7NnGNVQAEFFFBghAImhCPE9FYKDFTgvcDuwB7AewZq0LWwVwbeB1zabO19UdcG73gVUEABBRRQYHQCJoSjs/ROCgxRYK9qU/AJ4LFDBOhozGktcSNg146O32EroIACCiigwIgETAhHBOltFBigwIOBM6vpfLaK/mqABl0M+eVNEZlNgUd1cfCOWQEFFFBAAQVGK2BCOFpP76bAUATuCpwGrAIkMbxwKIF3PM5dgOc2ifzmwO86HovDV0ABBRRQQIERCJgQjgDRWygwMIGbVkXRezSrg88C3jGw+Lsa7hbAIcDDgJ93NQjHrYACCiiggAKjFTAhHK2nd1NgCAIfAbYD3g7sO4SAexDjQ4Gjmqbz27ia24PZNAQFFFBAAQVGKGBCOEJMb6XAAASeBxwMfAHYqmlm/ocBxNz1EO8FnAw8BvhG14Nx/AoooIACCigwWgETwtF6ejcF+iywMXBuFZHZEPhxn4PtSWy3AL4IPL22+fYkLMNQQAEFFFBAgVEJmBCOStL7KNBvgdWbFgWXAP8CPBH4bL/D7UV0awGnA2+r1iC9CMogFFBAAQUUUGC0AiaEo/X0bgr0VeBzVYzEc4PdmeH0hjy7qQT7H90ZsiNVQAEFFFBAgUkLmBBOWtznKdA9gf2BVzeN578OZNvon7oXwuBG/EngSuBpg4vcgBVQQAEFFFBgXgImhPPi8sUKDE7gAcCXgGuBO9l8vhPzfwBw3yaBf2wnRusgFVBAAQUUUGCqAiaEU+X34Qq0WuDmwJeBOwI7Ace2erQOLgIvAbZvCsg8BLhGEgUUUEABBRRQYEUCJoQrEvLfKzBcgSOBpwLvbyqKPmW4DJ2J/JHAm4BNTAY7M2cOVAEFFFBAgakLmBBOfQocgAKtFNiyOS94KvAzYD0TjFbO0exBbQocX70h7TXY+ulygAoooIACCrRHwISwPXPhSBRoi0C2ip4P3L75fWvg020ZmONYqsCta75yZvCrGimggAIKKKCAAvMRMCGcj5avVWAYAkcBuwHZMpqG5l7tFbhZNZzPVtGj2ztMR6aAAgoooIACbRUwIWzrzDguBaYjkGIkaWaeraJ3r+qi0xmJT52LwEVAEvi3zOXFvkYBBRRQYEECOUbxGmB9YDvglAXdxTcp0FIBE8KWTozDUmAKAqs1f9B9s1kZvG21LEhjc6/2CiQR/DOwd3uH6MgUUECBzgrcoJK/lwH3qCh+AdwH+GVno3LgCixFwITQj4UCCswIHAS8uOlhl6bm28jSaoGDqy+k89TqaXJwCijQQYEkfPsCOwArAX+prflJDD2n3cEJdcgrFjAhXLGRr1BgCAJpZJ4/6K4A7mkD+lZP+S7VbzDVX70UUEABBUYj8OZKAm9Tt7sEeCXwQeC/RvMI76JAOwVMCNs5L45KgUkKrAx8Dbgb8Gzg0Ek+3GfNS2Bz4IhqPP/Teb3TFyuggAIKLCmQs/LPB55W/+IPTaulE4ADmn92uVwKDEXAhHAoM22cCixb4CXA65tzER8HHidUawWyiptznZmjtAXxUkABBRSYv8AqlQTuA6wJ/A34dvPX7wTe5Wrg/EF9R/cFTAi7P4dGoMBiBNapPwhzRuLBVVRmMffzveMRuAVwZq3gpgqslwIKKKDA/ASS/O0BvBC4Sb31tNoWevb8buWrFeiXgAlhv+bTaBSYr8DJ1Xw+5yQOnO+bff3EBM6obUyHTeyJPkgBBRTovsCdgOcBGzUF07LLItd1wFubpDDFuX7T/RCNQIHFC5gQLt7QOyjQVYEnAR+qVcGsDv62q4H0fNwfaKq//hHYs+dxGp4CCigwCoFUBk2vwJfX2fiZe+as/HOAL47iId5DgT4JmBD2aTaNRYG5C6wFXFwltXMm7dS5v9VXTlDgBU3110dXEZkJPtZHKaCAAp0TSK/AvYDdgRvV6K8Fjq4VwR93LiIHrMCEBEwIJwTtYxRomUAOz6eh+SH1jWnLhudwgEcCbwMe2MzRVYoooIACCixVYIsmAXxjU3Rrg1n/9kLg3VUoRjYFFFiBgAmhHxEFhiew5awVwZuZbLTyA7B+c+blM0Dm6rutHKGDUkABBaYnkD+7tgde1Xyxmb/Oz7NZDcwxiHzhedH0huaTFeiegAlh9+bMESuwGIGU2z4XuFeTaOzYnK84bjE3871jEbgpkG+3s+0pFfC8FFBAAQX+RyDHHd4DbDULJC0jXlvJoE4KKLAAARPCBaD5FgU6LHBQU6DkxcCnq7poh0Pp5dBz7iUrg+8F3tfLCA1KAQUUmL/AXatH4KbA9evtFwCvA06c/+18hwIKzBYwIfTzoMBwBG4DXF5ba1KK+0fDCb0zkeYHmxQ+2K8zI3agCiigwPgEdqmkb+16xH8CH6zzgV8e32O9swLDEjAhHNZ8G+2wBU4CHgscC+w0bIpWRv+S6pW1bStH56AUUECByQjcGngHkArYs6+04ElPQXsHTmYefMqABEwIBzTZhjpogQ2B8+oP0pwf/NmgNdoXfHpmHVAVRdM02UsBBRQYmsATgbcA2c0yc10KvL/5Z0cAPx0aiPEqMCkBE8JJSfscBaYrkIpr6dH09qYB/b7THYpPX0JgI+DDwIOBy9RRQAEFBiRw80r2HgGsPCvu71TbnbSO8FJAgTELmBCOGdjbK9ACgSSAbwWy8rSO221aMCP/N4R1gc8D+Wb8a60amYNRQAEFxifwVOCFzZdhKRYz+0pl5awSfmp8j/bOAxFI8aH1bEEyt9k2IZybk69SoKsCt2jOC34fWBV4efMN7Bu6GkgPx716VRRNH61UFvVSQAEF+iyQraA5A/jsqhQ6Uy00hbSOryqi2SLqpcB8BW7XHIt5FLBFkwA+vulPeb1ZN8jff2y+Nxza600Ihzbjxjs0gcOAZwC/a3o0/RtwxdAAWhxvWkvkTEzODnopoIACfRXIDogXAPdpKob+66wgUyX04GYV54S+Bm5cIxfI0Zd8kbBxrf5lRfn+wC2BbDO+Erh3U1H9ac1n6ybNzz+/rLP5+dLBazkCJoR+PBTor8Dmzbm0Myq8VwCv6W+onYts/zrTuUPnRu6AFVBAgRULpFLoG6tS6CqzXn51nZl+G/DdFd/GVwxQIG2xbtz0S04xvFvVFwl3ALIK+HvgW1Uk7xfVfmSGaGfgP5p/thbw52rfdOgA/RYUsgnhgth8kwKtF/iXpsXE14H1gXwL+2jPDrZmztJXK9umNqs/3FozMAeigAIKLEIgRxO2AV5cqzezt+19tfoJunVvEcA9emuOs9yxOUO/aR1peUCt8mUnUz43qYr+PSBJ35n188s3lxF/7pXelFsCf6vWWq+s4zI9IhtvKCaE4/X17gpMS+BlwGuBPzVbKJ7ZfLN21LQG4nP/QSAFFD7S/AGX1dtfa6OAAgr0QCA/xB/YbNnLjofZSeAl9cN5+gfmh3uvYQlkpS6rfdnCme2bSdiy3TNJ4B+aL6rzJcFM0pfV4hxpSfI31yv3ypGL1EfIX+deezTnCM+e6w183f8JmBD6aVCgfwL51i3/c80qYdpNpJ1Btul4TVcgW6hy3uEpwFemOxSfroACCixaIEcRngWkdcTsRDCrgO9ptvx9etFP8AZdEEhv43wpcOc625dtnvetgZ9VP398o3YtXTPPpG9p8d+0zgimgvrawF+aCuo5k79fJZpdMGvdGE0IWzclDkiBRQnkv+mU6061rd8A2zdbE09f1B1986gEvlhVXj8+qht6HwUUUGDCAjmnlZYR2fKe7Xk3qOdnZeeQSgKzM8WrXwL5QvN+TW/IJGMp4pIVv02A/POc6ftZc150lEnf0vTyZXcq1Obzl+3JuT4L5Ex+Vhu9FiFgQrgIPN+qQAsFdqq99BlaEsGta9toC4c6qCF9sknOv11nawYVuMEqoEDnBW7frACmPU6+YEwSuFJF9KNqF/Fhe711eo7vVitrmecca1i5Vvr+sxL/bP29EfDDOpf38/o9f59K2eO8knC+CHhYnUvNs/IZPKUKynyi/n6cYxjEvU0IBzHNBjkQgZvVH8r5H2j24meraHoQek1XIGc516ytVX5zPt258OkKKDB3gWwHzZeMD6zWRTOrMingkS2h8znvNfen+spRCmQ7b+YtRVuyqnfDOsOXLb4zq7xp15Aru4pSuCWVPGdW3KYxxxnjrrUtdINZq9A5d5/zqPns5QtWrxEKmBCOENNbKTBlgbc0e/Wf2xyy/u/mf/qvr20UUx7S4B+f/lv7VBGZwWMIoIACrRfINsAU5shZ52wDXK1aAHyhOReWnQ75gTy93bzaIXBPID/LZ97+CmwErF4tG5JY5Z/li+FL61dGnbnMzwnTSPaWp5YvsbMlOX9uJoaZK5XS87k7Bri2Hez9G4UJYf/m1IiGKZAqXmkzkSvbOdIAOA1avaYnkPMWR1RlNSuKTm8efLICCixfIDsYdmy2BD65tuWlSEcSwWwVfEcV7LAw2XQ+RXevVb0kS0ni8vt/1YrfbZutlOfU3+f8XuboJ00ynybsFwK/nc6Q5/XUtIx4ZLXG2q6qhc7c4DO1VTkJodeYBUwIxwzs7RWYkMAFlQS6lMQNAAAgAElEQVTmD/Lst0/TX6/pCaTK2hnN9pv8AefWlunNg09WQIFlC+T/T+lRm3YRSSKyKpMjB8cBRzarTp8Tb+wCSbxToTMrfdnemeqcWdl7SD05q7FZqU3hlnyxmD9P8mXvJM7vjSv4JIGPrSI1D63qpDPPSt/BrAYeW0VqxjUG77uEgAmhHwkFui+w26w+gz8A7gH8ufthdTaC/AGfrVWvaQ7mn9rZKBy4Agr0UeAOVRwm1RrTmiirg7nOrS15xwNX9THwKcaUJDsVMrOtM18WrgesUmczM6y0Zpg5v3dZrcxmm2d2+3T9ypcM2QKas4BZ7UzCm9hnX1n5zCrgyXU+8FddD7qL4zch7OKsOWYF/k8g3yRe3mzryTduqbz1+KYJ7EkCTVUgZzlTfe/QqY7ChyuggAL/J5BjBIfVD+T52S/JYLYXHg28r1YI9Vq4wO0ay1TpzFGB9MbLMY4kfvmzeSbpm2nCnsbp2fZ5fk/75uVL6TShTyKYYjbLuvIzS748zZ+VrkYv/LM3kneaEI6E0ZsoMDWBlwKvq6enz92mlmCe2lzkwSnL/oT6faoD8eEKKDB4gaxKvRV4xKxKjRdVYvihqhw6eKR5AiTBuX61QchqXyqwpjH7TNKXLZ6p2pkqndnqOXO2f56P6dzL0xYif/ZlC/JtljH6tLH4Wtl8qVpjpSK6VwsETAhbMAkOQYEFCqRBbLaIpt1E/kebb4AvXuC9fNviBTauxswPr+0/i7+jd1BAAQXmL5Aq00+btTqVBOXgWpFKsRGv5Qukz2KqdeZsX1b4kvRl22e2PWYrZ865JdFL5c545gz/0KpfZndSqtHmrOODZn3WZsumqE2csiKaBvJfqZVRP38tFDAhbOGkOCQF5iiQ/nYvq8pj+bZ3lzm+z5eNXiDbg1ISO9tk8sOClwIKKDBJgazMHFhnyP+1io+8t0lkDnclcJnTkL58+SI1Z/uy5fMuVcUzb8iOmyR8+dI1v1J0J/9syNe6jUlqFiRRzudtybOAsUkfwxxbSYXQ8+rnkyGbdSZ2E8LOTJUDVeAfBPKtZQ6c5xxICsikQplN6KfzIVmjflDYxjmYzgT4VAUGKpBdCQc0xavye5qPpwplzgO+q6pQDpTln8JO4pfjFPniLoVNbllf3uWFKegyU8glLRxyrjIJ4NCvGzfbOx9TK4BpC5FtslklXfJKn8NU1E5V0BQm8ueQjn5yTAg7OnEOe/ACBwEvLoUUBXiqZwen8pnIDxrZCvP2+gNxKoPwoQooMBiBLer/9zmvlZXA31ebiFdXMjMYiKUEmhW+JHvZwpiVv1RQzV/PJH4515cza/m9L1U8Fzvf2R4boxTDyZcKWS3dbAU3TeuLGH6skkCrgi52FlrwfhPCFkyCQ1BgngL5Qy5bWfI/8j9WJbNsZ/GavMCb6oewQyb/aJ+ogAIDEUgz8l1rxSa7Q37XVG88pTmP9QoglSuHdmWVb/3a4pmzftmlkcIucflu9a9L37706ksRHdto/OMnJKt/u1c11PSgzHbZpV1pB5FVv6yaxjJnJVOn4JKhfeCGEK8J4RBm2Rj7JvBC4I0VVPr2ZFuH1+QFntz8MPakKq193eQf7xMVUKDHAkl6dqyz4WlnkMJhqcyYc+P5Ib3vV774XKdWrBJ/fmUl6wbATCXPJCgzBV3O7DvIIuLL2b+s/N25WSHdeykFYPJ5uqaKDiWRztbjbwBXL+KZvrVjAiaEHZswhzt4gZwZzGpg+hylj1G+FbWy6OQ/FvlG9YQq555Kal4KKKDAYgVSpGNnYH/gtlWQI6sx7wHesNibt/D92eVyhzoDnwRwwzqnlj/X8udbtiamSuVPq11B/qxze+LcJjI9AOO501LO/iXR+0D97HA84J9hczPt9atMCHs9vQbXQ4E9gXdXXElI8j/7HOr2mpxA2nykie4zgS9P7rE+SQEFeiqQ/4+nemOqFOfKClgadqfPbFZrun7dtUloV67CLjPn1LLVM1dWpFKZOVtfZ1anXO2b/4zft9nWmV0rOWOaxvCzryR8KZiTFebj3PI5f9whvMOEcAizbIx9EkhT1/RCyh+gT6nEpE/xtT2WfKOdP1BPBN7f9sE6PgUUaK1A+pXmXGBWBHPli73TgBwJSOn+rl2pQJnVvpztS4/c+1cvv5xXS6KX+JLoZXt9+tGZ9C1+hnNcJKvJWQlc8krRl1T/PL3Omy7+ad6h1wImhL2eXoPrmUDaGny8qommoMBWPYuvC+GkufNfgJd0YbCOUQEFWiWQVZx8kZdfqVCcK8lfKkanb1vbr1tVwpezfUn0ci4tZx1vXls5s701Z89S3CVfXpr0jX5GUwQmq8lpBTH7yjbQ1BT4dCWAbgMdvX2v72hC2OvpNbieCSQJfET1HXx+U177sJ7F1/ZwdqktOZkDLwUUUGAuAneq/2+kqmMSqZyNy5dKKQyWRvJtvJLk5docyHbP/Mo2xCR8l1clzz9UEZILPYM21ilMO4gHAHvUWcvZD8tK60dmbQcd60C8eb8FTAj7Pb9G1x+BbBPNN665zq5zAqk65zUZgXyzn8IOD7Hy2mTAfYoCHRa4Y1UIzWpOEqn0Ckx1zPSMTYuathQCS6I304cuWz0fWC0c0mIgf76k+mS2e6ZnX9o3eE1GIEV1Ug10uyUqgv4G+FCdXT+ptt9OZkQ+pfcCJoS9n2ID7IlAfoDIt7Z/brbm7NNUoDuyJ3F1IYz0uEoSnh/u8sORlwIKKLCkQBqiP7RWcvJ7/l99w/p/R5LAU6u0/zTkkuytVls8c94shV02ru2qWa3M1s5s9Zzp3TeNMQ79mY+qFlLbAtmaO3Ol2E6SwM8DXxw6kvGPT8CEcHy23lmBUQr8bdbN0o8pjWK9JiOQstz5YS4rhF4KKKDAjECaxG9aKzkpDpOzc/8KXAu8us4FZrVtUtc9q7BL2hKlqEtaV6SaZ5q1Z3UpVSZTbTLjPG9Sg/I5yxTISuDWVVzoLrNelbOAKVyWOfqOfgpMQsCEcBLKPkOBxQvknEb+sM85wnyT6DUZgVcBOQOUsvBeCiigQASeUDsG8sN8VtiyGpgVwuzcyBdH425Hk0T0bk1rimxlX6/OJqZlRVb5csYvzdqzspRq1BZ2addnNlt007Lo8bVim9H9saqBptXITFupdo3a0fRewISw91NsgAoosECB/IGdvo9LVnNb4O18mwIKdFQgK20pKpXtfCnykaTrijrflSQs57lSATqVHkd9JenLNs9/q+IuDwKuV60b0lrgx3Um8fymZUUKvXi1U+CxzbnMl9eZ0iSF11RBmM82SX16CnspMFUBE8Kp8vtwBRRoqUC2gaXPYH7/eUvH6LAUUGC8Av9e7X2SkH29kq+c78oKXc51HVsrcaMYRe65GZBthHneWrUrJCt9eXZ+z2rft5sVpitH8UDvMVaBfE7Snii7SzK3uS6twkLZ6eOW3bHye/P5CpgQzlfM1yugQN8FUnAhZ222rx+++h6v8SmgwP8I3Bl4dDWLz8pcVm9yXjtN11NhOGe7PtoU+Mq54sVcWXHcohK/VPpMFekUfTmrzvhl1fHXbvdcDPFU3pvzo0+vM4E5u5nrC9Ug/oim4NDPpjIqH6rAHARMCOeA5EsUUGBQAp+rLTyHDypqg1VgmALZipnKzanEmeqgn2jOduX/ATkT+LhquH5MFflIsZj5XmnaPrPtM1tO71M3yDNSNTKtHX5q8ZD5srbq9ekx+ZQm8XtwjSpfKB5XZ0rTcsRLgdYLmBC2foocoAIKTFDgDcBtqpH0BB/roxRQYIICOQeYRt/pF5hVwWz/TNP1NI3PueGs4KXAx1EL2Nq3SRULyVm/NHbPlR6y2e6ZYjP5NY6zhhPk81FVVOgRtZNklTpHmrn9sFXA/Xx0UcCEsIuz5pgVUGAcAqn8lvMeOTfopYAC/RFYuYpDJQHMak4SspzjSjuZNIzP9vBsFc2KXbaE5tdcriSOWf1LT78kgvk9xV1yn5lfWf3z6odACsM8o7YPZ3toWopk9fiD9df9iNIoBilgQjjIaTdoBRRYQiDf5r+rzvWkeqCXAgp0X+BhTTGWJzXbMtOSIZVAL6vKjqnS+ZxqBJ6S/++rbeIp+rG8K0Vfsq00XxqtCyTRTEugrAxlBdAWD93/zCwZQRL9p9a50htWYZisHudM4Df7F64RDVXAhHCoM2/cCigwI5BqcF+pBsH+Ae/nQoFuC6QAzNPqh/hv1epNtvGtUTsA9mu2gt6uzncdWr37lhVxer7my6KcJUzfv4tr5W9m62cqfnr1TyCrf+lBu3PTV3Ltpl3Ef9aqcbYQp9CQlwK9EzAh7N2UGpACCsxD4MbVEPiNtXIwj7f6UgUUaJFAqnbu3WwFfUA1h0+T+GzXTD/RrBKmmXy2gn6k2kUsbejbVPKX1g+p/Jkef+kRl22geZ9XvwVy5jMFhvJZyZUKoWk/lM/AQgoK9VvL6HolYELYq+k0GAUUmKfAe4E/17mQeb7VlyugwJQFkril2Xe2hGY18B1V1ONOVRxmr+ojmpXAtIxIC4mZK9U/7107A7ISeJdaLTyxWj9kFfBPU47Px49fINtAswq8b50j/WutHqfK9AXjf7xPUKAdAiaE7ZgHR6GAApMXSBGZFJLYavKP9okKKLBAgVQF3bX6veWH9wPrB/ic50sCmOqhOd93WJ3z+u6s5+S/9ZwBfGSz6rNe9f3L6l/OhGU1yGs4Atevz1G+UEixoRSIyWrgwcAfhsNgpAr8j4AJoZ8EBRQYokB+KMzqYFYYrhkigDEr0DGBbOVLr7f0B0yvwINq9e/hdV5wh9oqmuQu/z5XmslnG2B+zypQKn+eVhVG89dewxPImfG0Fkm10Pz1D4DX1FnTtB3xUmCQAiaEg5x2g1Zg0AL3AD7VbAfKeaFvDFrC4BVor8Bq9d9oEr2tgaOBT9d5rqwS5p+/pFnl/2r1C0xhqFvUCmCSwDQJT4Pws6r6p8VA2jvXkxpZ2oSk0myuc4C3NV8Kfqz6T05qDD5HgVYKmBC2cloclAIKjEkglQbPAF5WSeGYHuNtFVBggQK7VQKYwh5Z7Uu/wGz/TPXQJHkvaLb13aR6CGa1L9v9nlyVQ9MAPj/o2wJigfg9f9tK9SVCqsMe3/NYDU+BeQmYEM6LyxcroEDHBY5tzo1cUoUoOh6Kw1egNwLZ9pmkbpeq+ptVm6zip8pnegk+C9ioaSCfH+S/16wUbljnBC9qeoeeXa0Akgh6KaCAAgosQMCEcAFovkUBBTopkFXB+zbNhLfr5OgdtAL9EsjW7RSH2RFIgY+c6U2/wFQLnSn68uzazndVUyDmNtUH8NzaOpotol4KKKCAAiMQMCEcAaK3UECB1gvsBOxfBSaubP1oHaAC/RRIQ/isAm4PrFrb9t5XK3/ZEvrC+vd/AVZpksVUCM25wZlzgP1UMSoFFFBgygImhFOeAB+vgAJjF7hPbT/bGLh07E/zAQooMFsg7R0eBzymaQ+Roh45F3hUbf3M37+4CsGkIEwayX+mEsWvWwHYD5ICCigwGQETwsk4+xQFFJiOQIpPpAph+pOlmIyXAgqMXyArgTvXdtBUC51p9p5G3xsA2Qqa7dv/CuQcYPq/JUm0/9v458YnKKCAAv8kYELoh0IBBfoqcKNZlQj/va9BGpcCLRFIEpjzgM+pc38pCpPiMPlSJqv0+Xep8pi/z+rfoVZ6bMnMOQwFFBi8gAnh4D8CAijQW4E0G86WtDSz9lJAgdEL5L+vrASmJ+C9gXdW77+s/qUITJrBX9w0/U7fwKurfcQJzQrhb0Y/FO+ogAIKKLBQARPChcr5PgUUaLPA86s4xWZN37LftXmgjk2BDgrsU4Vh8t/XSc2qYKqA3rhpAbEF8PPmv70fNa0gHlgtXi4EDqnCMR0M1SEroIAC/RcwIez/HBuhAkMTyOrER4D7uRIxtKk33jEKPKlpCZFm8Y+vrdg3aLZ83r2+cDkfuBZYA9gUSOXQdwE/GeN4vLUCCiigwIgETAhHBOltFFCgFQJrA+cBaTORUvVeCiiwcIE0g98TeGpV6L2uOft3cyCrfh9ttoiuWdtBt6wegkkMj1n443ynAgoooMA0BEwIp6HuMxVQYBwCKwOnADmjlIIVXgooMH+BFIBJw/jdqzhMijN9o6r0ntqcA7xls0KYFi45m5uV+C83Z3WPnP9jfIcCCiigQFsETAjbMhOOQwEFFivwXiArGM9a7I18vwIDE0hT+PQD3K5W/f5cxWFSJCarfmkin6bxD2u2jX6rtox+oPlv7dcDczJcBRRQoJcCJoS9nFaDUmBwAs9rtrTt1pS5v9fgIjdgBRYmkIIw+e9mc2B14JdNe4iPV6XQrAgmSczW67SRuCHwqqZq6GlN+4jvLuxxvksBBRRQoK0CJoRtnRnHpYACcxXYEDjOIjJz5fJ1AxW4fSV4W9V/K//SbPv8cVUAfXuZ3KJpE/FEIAVk1gM+A7zaJHCgnxjDVkCBwQiYEA5mqg1UgV4KpKrhV+o807m9jNCgFFiYQPoAJvl7cFNg6SFVDOZPwC9qFfCoqgyauz+u+ed71WuTBGb7dVYD83ovBRRQQIGeC5gQ9nyCDU+Bngt8oba5vbnncRqeAnMRSCP4p1cCmKbx6QeY9hA5E/ieqgR6Wd0oLSNeVE3lL6im8Ska86u5PMjXKKCAAgr0R8CEsD9zaSQKDE0glURTAn/HoQVuvAqUwJ2qEMwjKgm8tHpvrtNs+/xe8+++WauB+T3XSsABlTReHziiegZ+R1EFFFBAgeEKmBAOd+6NXIEuC+SMU6oi3rvLQTh2BeYpkBYQ+QIkCWAqfmbLdPpt5jzgvwKrAO+ulcArZ937uXV+8P5AtoqmTYRbrOeJ78sVUECBvgqYEPZ1Zo1Lgf4KJAn8FJBiMj/rb5hGpsDfBXaus4CPAm4KfL7OAV4LbFErgocDF1W/wBm2VNw9sM4Hnl6J4CdmnRuUVwEFFFBAgb8LmBD6QVBAgS4JZMtbzjvtC3yuSwN3rArMUSCJ3CPrV1pC/Lz58uPTwBV1FjBnBL8PfBH4UP317Ftn5Twr6P8GHFzbQn8yx2f7MgUUUECBAQqYEA5w0g1ZgQ4LnFSNsffvcAwOXYHZAqkG+uhq85CqoGvVCvgZlQw+vlkV3BRIMZis9B0L/HAJwrzmsc1/G08A0jD+g83q4dkyK6CAAgooMBcBE8K5KPkaBRRog8B+zQ/Eaaa9TRsG4xgUWIRAtnqm31/O9KXa57eBU4ATgZwTfEqzBTRJXlpEJMHLFyEpEjP7ukOdC8x9rgaOAT7aNJK/ahHj8q0KKKCAAgMUMCEc4KQbsgIdFNgIeH/TGy1l9WcXy+hgKA55gAL3BTaoFg9JBtMOIi1T0uYh5/ruU1tEU/zl65UAfrxetyRXCsq8smkjsXbTYP7kOht43gBNDVkBBRRQYEQCJoQjgvQ2CigwNoHVq1jGDoA/+I6N2RuPUCCrd0kCtwdyJjDn+XIOMM3eP9usDl5chWJSKTSrgb+uFb6sBqZ1xJJXksnda1XxcuD1tRo4wiF7KwUUUECBoQqYEA515o1bge4IZCvd8cB7uzNkRzpAgSR+OcOXQjA585ek78xm9S8rfTMFkFIpdGtg1zoHmPOAWfn+5VK8Vmu+AMnrn1f9NpMs5ldWF70UUEABBRQYmYAJ4cgovZECCoxB4GVAtoumYIaXAm0SuGVtAc3q3W7V/iG9/XKOLwVhUgQmVwrGZJtoqoPmnx1d2zyzKri0667Ai+re+TIkX4SkzYqXAgoooIACYxEwIRwLqzdVQIERCGQ73RtrteW6EdzPWyiwWIF8JtMS4nHNat0dqxjMR2oF8JxZN89W0SSCKfjyteZLjc9UEpgWEku70l8wq4FpGZGVwXdUIvibxQ7Y9yuggAIKKLAiARPCFQn57xVQYBoC69YqS8rwZ+udlwLTELhLFXx5clPA5X7AmtXSIe0fsmo3e6vnw4E9atvoN4Ajq2hMegYu68rnO9tHH1NVRvMFiOdkpzHTPlMBBRQYsIAJ4YAn39AVaLFAtsodbuGMFs9Qf4f2gGptktXAtIW4cFb/v/OXCDuJYs4NZkvzd4DDqkLoT5fDkwIzewHPbwrK/Bh4XZ2Rvba/pEamgAIKKNBmARPCNs+OY1NgmAJvB/676a2WEvxeCkxCYLs6s5dVwFQI/WTTKP4EIGcCL1liAKn2mRW9baswzKFAto3+bAUDTeKYLaHrVUXRJI9ZSfRSQAEFFFBgqgImhFPl9+EKKLCEwEOBVzdnsjZRRoExCtymVgGzwrdxNYBPW4jjZlUEnf34nO/bpyqEZrvox6oH4NJaRMx+X/oL7l0N5H8AvKne52rgGCfXWyuggAIKzE/AhHB+Xr5aAQXGJ7BGU43xbODxwPfG9xjvPFCBzYAdq2ptKoNmde4kIK0flnbO78G1tTPbRv8CZOU6q4ZXzcEvz3kNcCvg4Eog03DeSwEFFFBAgdYJmBC2bkockAKDFFi1erblh+73DVLAoMchkJ5/Wd1LVdCsCqYlRJLA9AZccpUuX0jcu16b7aC/rb5/ec9cev+l9+CezWt3qTOHb65m9OOIy3sqoIACCigwMgETwpFReiMFFFiEwLurwMZBi7iHb1UgSV16/uW8XpLBnOvLqnPOBCYJXPJaBUilz7w+5wJzXjBfSJy4lLODS9NdHXhaU230GcCfq8l8EshsD/VSQAEFFFCgEwImhJ2YJgepQK8FdmqSwacAj+h1lAY3LoHbVc+/rAKmMuiXaxUw5/yW1fIhVUHza4dazUtRmCRyv5vjIJN0PrNWH5NAZtXxs3N8ry9TQAEFFFCgVQImhK2aDgejwOAEssKSH6ZzbnAuZ7MGB2TASxW4a63Mbdmcz7sXcBZwdPUG/NVS3jHT+D1fPmxUZ1Q/UCuBv56j8S2aVcCXAg8CblTFj85sisZcMcf3+zIFFFBAAQVaKWBC2MppcVAKDEbgM8CHPTc4mPleaKDZ2pkzelkBzJnAdWpFLv0qs7p3zVJunNekIExWDlNNNNtAswp4DnDZPAaSc4HbVOXbd9YXGF+Zx/t9qQIKKKCAAq0WMCFs9fQ4OAV6LfAqICs3z+51lAa3UIFb18rxw2tVLr0pk9SdDHxiGTe9WW09zrm+tHw4r5LAJI0pEjPXK70Cs6U0zeM/V19YfHEphWjmej9fp4ACCiigQGsFTAhbOzUOTIFeC6SIR1Ze8kP3H3sdqcHNRyBFYdKyIZU6HwCkz19W9VIQ5gvLuNHtqyjMhnWWMAVk8p70FJzPtXJtQ30ucHUVo3nLPFcT5/M8X6uAAgoooEArBEwIWzENDkKBQQmsWeX4U0Rmrue3BgU0sGBv0nwOnlVJYM4Gnl9nAY9ZTruHtJDIlwm7AVlJTFP5c6vf33ybvt+9WT3ct+6Xlcc0j19WMZqBTY3hKqCAAgoMQcCEcAizbIwKtEsg1R+PsEdbuyZlwqPJds49gDR/T0J2QRWFSYGhy5cxlpkkMKuHqSya86fZQppkcL7XSrUSuVfTOD4J6VurQf3v53sjX6+AAgoooEDXBUwIuz6Djl+Bbgnk3OCN62xWt0buaBcrkORvVyBnAteuZC7VQbMddFlFXu4JJGlLT8EkgUfW67MtdCHX/YCn19bSFKRJkZivLeRGvkcBBRRQQIG+CJgQ9mUmjUOB9gukOmTOZ20HuBLT/vkaxQg3qwqdScJWq3N9Od+XrZl/WsYDspU4Z0xT2TPn+rJ1NCuBpy1wQEk+nwTs3iSXv6jm8cd7dnWBmr5NAQUUUKB3AiaEvZtSA1KglQLrVrn+7Zutet9t5Qgd1KgEshL4lKoQmiTwQ3UmMNVBl3W+Ly0lZr4s+AFwQv36xgIHlf6WOWOYlcX1KwnMOObTbmKBj/ZtCiiggAIKdEvAhLBb8+VoFeiqwI+AJ9ZZsa7G4LiXLbBDs+q3AfCiKhSU7ZhHAacvB21nYFvgkfWebN88dpFJW7aYPq8pMJOG9dlW+u6mD+FCk0rnWwEFFFBAgUEImBAOYpoNUoGpCryrEsHDpzoKHz5qgTR8T4uIraox/KfqfF+KvSzr2ruay2fbcKqJJmlM8vjjRQ4u25HTfD6N69/QFIo5eJH38+0KKKCAAgoMRsCEcDBTbaAKTEXgJc2qz13q/NZUBuBDRyqQBDCJYM75/aEqfL6/ScTOWcZT0ij+0TX/2UqaCrM5P3hq04fy54scWYrMpFLpU5uVxgtrW2hWGL0UUEABBRRQYB4CJoTzwPKlCigwL4H7Aq+tIjJJHry6KZCEK9s6cx7vV7WtMyt7y+rVl/N76Q+YX3eqYjB5/edHVEwo51BTpOYeTbXS91QLE88GdvOz5agVUEABBVogYELYgklwCAr0UOCWTY+5M4CcLftWD+Prc0iZu8c0q3gb1+rbd2oraM7jXbqMwO8NbF5tJdJc/n2zCsmMwio9CPepX1dV38C3jeLG3kMBBRRQQIGhC5gQDv0TYPwKjF7gRlVR9LD6ffRP8I7jEJhZeUtBllSCfQeQPoHfXMbDshU4BVySCP61vgDIecCcJRzVtUWzNfWFtUU17SqyIri8M4qjeq73UUABBRRQYDACJoSDmWoDVWBiAocCWcU5YGJP9EELEVirVvQeUFU506D9c8DRzZbMny7jhtk6ulGtHK4EpFDQR+oM30LGsKz3JAnMiuAaQL5YyGdqWWMa5XO9lwIKKKCAAoMTMCEc3JQbsAJjFdilOVu2E5Cqj17tE1i1tvGm5UNW9i6q1gxJ6q5cynBvWkWB9q0zhCnekhW6NIsf9bm9NJBP24pn16pkKoUmOfVSQAEFFFBAgTEKmBCOEddbKzAwgZwjy9mxVJO8emCxtz3cbAdNsp5tnr+tRCtJYIrELHmlKEwqgz60fk8S+MEqCjPqVbqsMr64Vig3qbOKb22S1TPbDur4FFBAAVWKZq8AABkKSURBVAUU6IuACWFfZtI4FJiuwO2rn1xWBy+Y7lB8OpBE67mVBN69tltmtS3VPi9ZitDNK/nLqmFWd09sCstkC2naOFw3BtE871XAM5pfv6wiMelX6RcJY8D2lgoooIACCixPwITQz4cCCoxCIE3GX1795UZxP++xMIEkWVmh3azenlXA9y6jEEtaQjy8WfnbtN5zAvD1WuVd2NNX/K69mgI0+zfFYbI99LQ6H5hiMV4KKKCAAgooMCUBE8IpwftYBXok8Lpmted6QJrQe01WYE0gbR6yGvgw4MbV/D1JYFZql2z+ntfeD9i7WZXL1tAkY6kimmRwXNdN6suCFIlZpQrRHNGsSH51XA/0vgoooIACCigwdwETwrlb+UoFFPhngT2rUmVaFfxRoIkIpDpoztvtUcldKnEmqcu5uxRiWbJX4B2rkXt6QuYM4LerkExWA8d55TOR1cpsC82209fXiuA4n+m9FVBAAQUUUGCeAiaE8wTz5Qoo8L8Cd6uzZmlg7tmv8X4w1m9aO2wLpO1DvGeurOy9s3oAzvyznB/cul67QdP+47/r7OCyKomOeuTPqXOIGWue+Xbg7FE/xPspoIACCiigwGgETAhH4+hdFBiaQLYBnlerVOcMLfgJxXufauGRRDCrfDNX3FPNNa0fflf/8LZ1HjA9BZOIfba2g34f+OEExpvnv6FWBG8IZBtxGtR/bwLP9hEKKKCAAgoosAgBE8JF4PlWBQYskIIgH6uG4QNmGHnotwNeAzyuzgPOPCBFe9L/7z3A5fUP0yD+SXWGMO0kjqu+gh8a+aiWfsOcX7x/JYKpZJozgdkWmub2M4nqhIbiYxRQQAEFFFBgoQImhAuV830KDFfgAGDd5qzabsMlGGnkSeye3xR2Wa9+zdz8GuBttdL2FeAWTWXOBwEbNknh04CLgZOaFcEv16+RDmo5N8tq5e5NwZqcH82YPlBFY2YS1UmNw+cooIACCiigwAgETAhHgOgtFBiQQPoM7tusViWJ8Vq4QAqtZHUtlUGz3XLmSqP4nAtM9c+swt6sqRa6DZCCMDH/QvOebNFNEnbFwh+/oHemkunOVcjmombcRwKpFmoxoQVx+iYFFFBAAQXaIWBC2I55cBQKdEEgfeuyHTCrVKlW6TV3gZy5fGaT6N2zCq6k5cPM9dtKAj9cxWGyUpgVwJwFTOGej1dRmDOalcRr5/7IkbwyY9m1qWK6XZ1jzPy/seld+PmR3N2bKKCAAgoooMDUBUwIpz4FDkCBTgjcCMi2xRfXFsZODLoFg9yxOdf3+GZ75xOXGMtlQM76JQm8sLaBJvHaqikYc4dKurId9EtTiiFnGJ/VVAfdopLQQ4F3zTq/OKVh+VgFFFBAAQUUGLWACeGoRb2fAv0UyDbGbBN8dT/DG2lU21dRmCRVK8+6c/r/ZbtnEsGz6jXZOppG8f9SlUPTpiHbQqdxpaDN82pLcJ6fFckUsZlUkZppxOwzFVBAAQUUGLyACeHgPwICKLBCgYOA2wNZ7fJausBDK8F79hL/+hLg+KoA+rNaCXxUWSZB/GAVhMkq4TSu9CzMudAksY+oAWQ18JDmn6dlhZcCCiiggAIK9FzAhLDnE2x4CixSIIlOKl1u2qwepeql1/8J5FzdZsCWddZv5t/8oVbX0oIhq6oPrwQwieDXqmBMisZM8xzm2sD+lcSmfcSllQQe7AQroIACCiigwLAETAiHNd9Gq8B8BNJaIlsbt67EZj7v7etrV6sWES8AVlkiyG8C7wTOBPaqQixJvE4GshU0SeC0+/NllfeFwAY19ozr8CoW1Nc5My4FFFBAAQUUWI6ACaEfDwUUWJZAEpxXVQXMISslCXxCbavMat/sK9sqsyU0Pfju1awAPqZaRRxTSWCqck77SqXSpwL71UB+U+0i0jIiW1q9FFBAAQUUUGDAAiaEA558Q1dgOQLpc/fLWUnEELHSdD1nAvNrdpuIWKQVRKqurlV9An8PfLKS52wLbcO1W7WMeEgNJsVqsoKZyqZeCiiggAIKKKDA3wVMCP0gKKDAkgJ7A0+uc4ND00l7jTRff8USDePj8NU6a/fflQSeD3wWOLXZVpu/bsN152oXkfONt6kBHVbbQqdVuKYNLo5BAQUUUEABBZYhYELoR0MBBWYLpIhMVgfTQD1bC4dy3anaLewCZIvozJWtoKkOev2m/+L9gfdXW4icE/xRi3Ce1Ixzj+bM58xqYJK/JIIZ759aNE6HooACCiiggAItEzAhbNmEOBwFpihw66YR+dl1Vq4t2x7HyZGWC2m38LSqFjr7WT+p3oDXqz582W75iXEOZgH3viXwomp6v069P30Dk9BPq5fhAsLwLQoooIACCigwTQETwmnq+2wF2iVwehVIeVe7hjXy0WQV9CnAtsCqs+7+n8Cfge9VRdCjmmqhvxj50xd/w61qNTCN73Mlec2cHQ1csfjbewcFFFBAAQUUGJKACeGQZttYFVi2wBuq+fwOPUVKv8AUWdl9KfH9tprDp1BMGsWnQEzbrhs3fSCfV+O/Qw3u07Ut9FNtG6zjUUABBRRQQIHuCJgQdmeuHKkC4xJIEZUDm8qZ92lpMrTQuFMYZx/gAUu5QQrDpK3GQS2vupmxJ4bEkutXtSU01UJ/uFAY36eAAgoooIACCswImBD6WVBg2AKpSpmtopvW1sOua6QNRHoBbl2VQJeM57tNn8BD6lzg1S0O9pnA0ytJzzAz7jdW8vrHFo/boSmggAIKKKBAxwRMCDs2YQ5XgREL5Lzcy4ATR3zfSd1uZWDDJsH7t6bqZyqEPmgpD/4y8KbqE/iXSQ1sAc+5SVPN9NW1GrhGvf+jwHF1tnMBt/QtCiiggAIKKKDA8gVMCP2EKDBcgROq+fyzOkiwZdMD8IFVXGXtJcb/1+oLeDhwDJC/b/OVIjdJyreoQWYF8C3VMiIJu5cCCiiggAIKKDA2ARPCsdF6YwVaLbArsGfHms9vDjy/VgTXnKX7NyAVQr9Y1TZTHKbtvfeyArhvrQauW7Fk/IcCJwFuC231fz4OTgEFFFBAgf4ImBD2Zy6NRIG5CqTiZnrV5fe0LGjzlZXAuwM7VSI4M9YkgVn5O7eSwGyr7MJ1zyoSk2Q81x+qxcU7gPO6EIBjVEABBRRQQIF+CZgQ9ms+jUaBFQmk6EqSqKwQnrOiF0/p36c34HNrBe1mS4whfQLPrHYLbWsUvzyuHSuemYqnScRT3ObDzbbXn03J2ccqoIACCiiggAKYEPohUGBYAp9pVtrSvy7JSNuu7ZtWENsB+X32lUIwSWIz5mynzOpgF65Vmkb3L63+gTeqAScJz/nAFIvxUkABBRRQQAEFpi5gQjj1KXAACkxM4PVNNdF7AI+e2BOX/6AUg0lV0KxWPnKJl6ZP4GXAW4EUh+nSmboNmvG+eFZie0U1vE/vwB+1xN5hKKCAAgoooIACfxcwIfSDoMAwBNKXL+fU7jbl5OqmVUhlW2Bj4Iaz+K8DPlUrgdlGeUnHpibbQpMI3rvGfX5tbU1Lj991LBaHq4ACCiiggAIDETAhHMhEG+agBW5bFTgfDnxnChK3Bu5XxVQyhtlXqoGeAhwFdOlM4EwM6YO4f1OcZ3cg5zNzJY4jOxrPFD4ePlIBBRRQQAEFpilgQjhNfZ+twGQELgTeXH3tJvPE/2kU/1hgt6oSOvu5VzfbKb8NHNBsGT1tUgMa8XMeXJVPZ6qFJqa0jMgqbLaIeimggAIKKKCAAp0QMCHsxDQ5SAUWLPDeas8wk7gs+EbzeOMdm22hP1zi9Wmv8DEg5+jSb6+r1zMq0X1EBZAzga+u2K7talCOWwEFFFBAAQWGK2BCONy5N/L+C6R33wuA+0441JWAC4A0X0+LiFdOaavqqMLOucc0kX8CsF7d9ORadU18XgoooIACCiigQGcFTAg7O3UOXIHlCty1tmOm793lWi1I4P5VATWJdZLbq5pzgu+uX+kj6KWAAgoooIACCnRewISw81NoAAr8k0B63n21euB9XJ95C2Rb6BbVEzFvzmpntt6mUEyK4HgpoIACCiiggAK9ETAh7M1UGogC/ytwbFP1MitYL9FkXgJPaV59IHD7etf7qn/g5+Z1F1+sgAIKKKCAAgp0SMCEsEOT5VAVmINAzgym8fxD5vBaXwJ3AF7XbK99EHCbAnkb8JZKqjVSQAEFFFBAAQV6LWBC2OvpNbiBCWwEZHXwnsDvBxb7fMONUZrI53xgrosrCcy2UC8FFFBAAQUUUGAwAiaEg5lqA+25wM2Bc4CndrytwzinaR1gfeCZwNb1oFOAw5pKrJ8c54O9twIKKKCAAgoo0FYBE8K2zozjUmDuAiki82Hgy7X9ce7vHMYrkwjuV8nyKkB6IqZa6MHAz4ZBYJQKKKCAAgoooMDSBUwI/WQo0H2BFI+5E/D07ocy0gjSciP9A3esu14CHAocBVw90id5MwUUUEABBRRQoKMCJoQdnTiHrUAJPLzOvj0QuFaVvws8uekZ+BwgfQRznQW8FThJHwUUUEABBRRQQIF/FDAh9BOhQHcF1gXSEmGbKorS3UgWP/K1gD2BvYFb1e3SNiLVQi9c/O29gwIKKKCAAgoo0E8BE8J+zqtR9V9g1WYF7FPAG+r3/ke89AhvAuxSW0Hzip8D7wQOb4rHXDlUFONWQAEFFFBAAQXmKmBCOFcpX6dAuwSSCK5cWyPbNbLJjOZewLOBJwEpqnMB8KZquzGZEfgUBRRQQAEFFFCgBwImhD2YREMYnEB65+3TbBfdZGCR3xjYodpGbFCxH1cVQ88YmIXhKqCAAgoooIACIxEwIRwJozdRYGICGwLHAxvX9siJPXiKD8pK6PZVGGZ14LrmnOC7arus20KnODE+WgEFFFBAAQW6L2BC2P05NILhCGSFLM3ndwe+PoCwHwe8GrhjbY/9EfB6IKuCvx9A/IaogAIKKKCAAgqMXcCEcOzEPkCBkQkc07RU+GFztwNHdsd23ih9FXeu3oorVfL7MuCUdg7XUSmggAIKKKCAAt0VMCHs7tw58mEJPB+4R60O9jHytYHdgCR+2SKaKwnwa5rCMd/rY8DGpIACCiiggAIKtEHAhLANs+AYFFi+wPp1bjDN56/pGdZDq0jMdhXXb5rE98RmS+h+wO96FqvhKKCAAgoooIACrRMwIWzdlDggBf5BYObc4NOBr/bA5nrA5k2z+G2BZ82K5/NVKCbJoJcCCiiggAIKKKDAhARMCCcE7WMUWKBAKoqeXsnSAm/RiretBTyjmsjfvkb02+odeIirga2YIwehgAIKKKCAAgMUMCEc4KQbcmcEngOkzcSTOzPifx7o/YEUiUnF0KwO/gU4DXhnFYn5zw7H5tAVUEABBRRQQIHOC5gQdn4KDaCnAukzmJWzhwDXdjDGFMA5AHhCjT2JYHoHJhH8bgfjccgKKKCAAgoooEAvBUwIezmtBtVxgXWAzwBbN5U3L+1QLDcAdgBeDty1xp0KoW8CjgX+0KFYHKoCCiiggAIKKDAIARPCQUyzQXZM4Dxgf+BzHRl3VjOzvTXFYtZsVgb/u7aDHgZ8qiMxOEwFFFBAAQUUUGCQAiaEg5x2g26xwNuBi4F3t3iMM0PboiqF5nxgrpwHzJbQD/SkImoHpsAhKqCAAgoooIACixMwIVycn+9WYJQCOwFpL5HefG29Vmuqnm4G7FVbWjPOXwDvqDOPXTzv2FZrx6WAAgoooIACCoxdwIRw7MQ+QIE5CSQJfB3w8JYWkVkD2BN4bm0LTVDfAV4NnGzbiDnNsS9SQAEFFFBAAQVaJ2BC2LopcUADFJhpPr8NcFnL4r9ZFYV5EnDDahuRLaFHA+e0bKwORwEFFFBAAQUUUGCeAiaE8wTz5QqMQeCzde7umDHce6G3XBc4vqkOepcmIUzCegVweLWOyBZRLwUUUEABBRRQQIEeCJgQ9mASDaHTAs8E7tC0ZHhhS6JYv7aFPq3Gcz7wWuDTVTSmJcN0GAoooIACCiiggAKjEDAhHIWi91BgYQJpOv+Gpr3EJi1JtlLh9InNKuCtmjYSVzXnAl9QW0MXFp3vUkABBRRQQAEFFGi9gAlh66fIAfZUIGfz0m/wkcAPpxjjSrU6+XxgdeCPzVgOBN44xTH5aAUUUEABBRRQQIEJCZgQTgjaxyiwhMCpwMeqb9+0cHYBDgZuXpVN39OsVL4c+NO0BuRzFVBAAQUUUEABBSYrYEI4WW+fpkAE3twkYjcB9pgSRyqGJhHM1tBc76oVwR9PaTw+VgEFFFBAAQUUUGBKAiaEU4L3sYMV2BZ4BbDRFM4N5tmHzUoEU9U05wZTOMZLAQUUUEABBRRQYIACJoQDnHRDnprA7YCzmgRs66Z4y8UTHMWuwH7APeqZJwKH1FgmOAwfpYACCiiggAIKKNA2ARPCts2I4+mrwPWAM6pq51ETCvIZTSP5lwFr1/O+BLwOOHlCz/cxCiiggAIKKKCAAi0XMCFs+QQ5vN4IpL3E3YDHAn8bc1RPb+6fSqG3qeec0xSKeQlw7pif6+0VUEABBRRQQAEFOiZgQtixCXO4nRTYHDgWuHOzdfP3Y4rgxlUhNInfzPWDSgw/NKZnelsFFFBAAQUUUECBjguYEHZ8Ah1+6wVWBZKY7QScPobRrga8EthhVrGYbA093KbyY9D2lgoooIACCiigQM8ETAh7NqGG0zqBDwO/G0OLiTtWQ/m9ZkX8TeA1wPGtU3BACiiggAIKKKCAAq0UMCFs5bQ4qJ4IpLrnvwPrjbDZ+0OBA5oCNQ+eZXQm8DbgpJ64GYYCCiiggAIKKKDAhARMCCcE7WMGJ7BuU0Dm68120Z1HUNVzLWA3YM9mG+jtZ0lm9TFVQ7My6KWAAgoooIACCiigwLwFTAjnTeYbFFihQP67+ixwCbD3Cl+97BdsAaRi6I6zXpLtp0cCBwOXL+LevlUBBRRQQAEFFFBAAUwI/RAoMHqBrAq+GtgQ+PU8b79GrSruC+Sc4Mx1XtNG4gggq4J/mOc9fbkCCiiggAIKKKCAAksVMCH0g6HAaAXWBC6uVb3Pz+PWWwJPqWRw5m1/rHYVqRiahNBLAQUUUEABBRRQQIGRCpgQjpTTmw1c4PrAJ5uzfj+vrZ4r4rgFsG2dD3zgrBfnTOBR1Tbityu6if9eAQUUUEABBRRQQIGFCpgQLlTO9ynwzwIvBp5XVUV/sxyguwLPqNXAm8163Tm11fRUcRVQQAEFFFBAAQUUmISACeEklH3GEASy0rcJ8BngtGUEvHlTaCatKHaf9e9zxvBDwH80q4o/HQKUMSqggAIKKKCAAgq0R8CEsD1z4Ui6K5CegO8ADgHevZQwshqY1cPbzfp3FwCH1tbQ7kbuyBVQQAEFFFBAAQU6LWBC2Onpc/AtELg58EXgOOAVS4wnq4GvXKJ34CnAa4FsD/VSQAEFFFBAAQUUUGCqAiaEU+X34R0XWAk4Blgd2Ar4C7ByVQt9KbBOxXcd8HHgAOCHHY/Z4SuggAIKKKCAAgr0SMCEsEeTaSgTF3hdU1F0T2BdYFVgn/r7mUIxvwAOq/6Bv5z46HygAgoooIACCiiggAIrEDAh9COiwMIFUkn0mjo/+KZZt7myWS18GXDkwm/tOxVQQAEFFFBAAQUUGL+ACeH4jX1CPwVu3TSf/26tDM5EmL9/fdN24oSmiEyaynspoIACCiiggAIKKNBqARPCVk+Pg2uxQCqHZjtorouqbUTOE3opoIACCiiggAIKKNAZARPCzkyVA22ZwBrAQVVddFl9B1s2ZIejgAIKKKCAAgoooMA/CpgQ+olQQAEFFFBAAQUUUEABBQYqYEI40Ik3bAUUUEABBRRQQAEFFFDAhNDPgAIKKKCAAgoooIACCigwUAETwoFOvGEroIACCiiggAIKKKCAAiaEfgYUUEABBRRQQAEFFFBAgYEKmBAOdOINWwEFFFBAAQUUUEABBRQwIfQzoIACCiiggAIKKKCAAgoMVMCEcKATb9gKKKCAAgoooIACCiiggAmhnwEFFFBAAQUUUEABBRRQYKACJoQDnXjDVkABBRRQQAEFFFBAAQVMCP0MKKCAAgoooIACCiiggAIDFTAhHOjEG7YCCiiggAIKKKCAAgooYELoZ0ABBRRQQAEFFFBAAQUUGKiACeFAJ96wFVBAAQUUUEABBRRQQAETQj8DCiiggAIKKKCAAgoooMBABUwIBzrxhq2AAgoooIACCiiggAIKmBD6GVBAAQUUUEABBRRQQAEFBipgQjjQiTdsBRRQQAEFFFBAAQUUUMCE0M+AAgoooIACCiiggAIKKDBQARPCgU68YSuggAIKKKCAAgoooIACJoR+BhRQQAEFFFBAAQUUUECBgQqYEA504g1bAQUUUEABBRRQQAEFFDAh9DOggAIKKKCAAgoooIACCgxUwIRwoBNv2AoooIACCiiggAIKKKCACaGfAQUUUEABBRRQQAEFFFBgoAImhAOdeMNWQAEFFFBAAQUUUEABBUwI/QwooIACCiiggAIKKKCAAgMVMCEc6MQbtgIKKKCAAgoooIACCijw/wFin/P1pxxUaAAAAABJRU5ErkJggg==', '2025-05-09 14:43:06');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
