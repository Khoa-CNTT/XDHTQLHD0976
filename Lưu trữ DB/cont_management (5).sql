-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th4 29, 2025 lúc 06:23 AM
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

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_otp_', 'i:105737;', 1745516373);

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
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contract_number` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Chờ xử lý','Hoạt động','Hoàn thành','Đã huỷ') NOT NULL DEFAULT 'Chờ xử lý',
  `total_price` decimal(10,2) NOT NULL,
  `signed_document` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contracts`
--

INSERT INTO `contracts` (`id`, `service_id`, `customer_id`, `contract_number`, `start_date`, `end_date`, `status`, `total_price`, `signed_document`, `created_at`, `updated_at`) VALUES
(10, 61, 4, 'HD-1745678941', '2025-04-26', '2025-10-26', 'Hoạt động', 7000000.00, NULL, '2025-04-26 07:49:01', '2025-04-27 00:14:33'),
(11, 65, 4, 'HD-1745729556', '2025-04-27', '2025-10-27', 'Hoàn thành', 4000000.00, NULL, '2025-04-26 21:52:36', '2025-04-27 00:05:54'),
(12, 63, 4, 'HD-1745729615', '2025-04-27', '2025-10-27', 'Đã huỷ', 10000000.00, NULL, '2025-04-26 21:53:35', '2025-04-27 00:05:59'),
(18, 66, 4, 'HD-1745739574', '2025-04-27', '2025-10-27', 'Chờ xử lý', 4500000.00, NULL, '2025-04-27 00:39:34', '2025-04-27 00:39:34');

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
(4, 13, 'cty abc', '0509', '2025-04-10 21:12:22', '2025-04-10 21:12:22'),
(5, 14, 'Ngapham23', '0987654321100', '2025-04-13 01:07:45', '2025-04-13 01:07:45'),
(6, 15, 'Hà Nội', '1234567890', '2025-04-27 01:28:18', '2025-04-27 01:28:18');

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
(14, '2025_04_25_085025_add_customer_id_to_contracts_table', 10);

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
  `status` enum('Hoàn Thành','Đã Huỷ','Đang Đợi','') NOT NULL,
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
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `service_type` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_hot` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `service_name`, `description`, `content`, `image`, `service_type`, `price`, `created_by`, `created_at`, `updated_at`, `is_hot`) VALUES
(19, 'HOME 3_NgT (Mesh)', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', 'services/smnfozFDBMshwhyz9ukG2kKg88LJbQc04zxVbALX.jpg', 'Nhà mạng', 310000.00, NULL, '2025-04-14 06:14:48', '2025-04-28 21:21:08', 0),
(20, 'Home 2_NGT MESH', 'Đường truyền Internet tốc độ 500Mbps\r\n\r\nTrang bị thêm Wifi Mesh 5/6 chỉ với 30.000đ/tháng', 'Đường truyền Internet tốc độ 500Mbps\r\n\r\nTrang bị thêm Wifi Mesh 5/6 chỉ với 30.000đ/tháng', 'services/VOFkOkay5fS9emPVR1r6V9ZnnbndBa2wGMU6HJiO.jpg', 'Nhà mạng', 240000.00, NULL, '2025-04-10 08:30:46', '2025-04-28 21:22:38', 1),
(21, 'HOME 4_NgT (Mesh)', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', '1. Ưu đãi gói cước\r\n- Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\n- Trang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\n+  Wifi Mesh 5: \r\n     * Wifi Mesh 5 iGate EW12ST là sự kết hợp giữa chuẩn Wifi 5 và công nghệ Mesh Wifi, phù hợp với hộ gia đình với mọi cấu trúc nhà ở. \r\n     * Tốc độ lên đến 1200Mbps trên cả 2 băng tần 2,4-5GHz\r\n     * Kết nối liền mạch, chỉ tạo tên 1 Wifi duy nhất\r\n     * Hỗ trợ đồng thời 40 thiết bị\r\n     * Cài đặt dễ dàng, triển khai linh hoạt.\r\n+ Wifi Mesh 6:\r\n     *Wifi Mesh 6 iGate EW30SX là sự kết hợp giữa chuẩn Wifi 6 và công nghệ Mesh, phù hợp với các doanh nghiệp, tổ chức vừa và nhỏ, các gia đình có nhu cầu sử dụng internet cao. \r\n     * Tốc độ lên đến 3Gbps, trên cả hai băng tần 2,4 – 5GHz\r\n     * Kết nối liền mạch, phù hợp mọi ngóc ngách\r\n     * Hỗ trợ đồng thời 100 thiết bị\r\n     * Độ trễ giảm 50%. \r\n- Lắp đặt nhanh chóng, chăm sóc và hỗ trợ khách hàng 24/7\r\n\r\n2. Cước đấu nối hòa mạng\r\n - Cước đấu nối hòa mạng áp dụng cho thuê bao đăng ký mới dịch vụ cho Khách hàng cá nhân, Hộ gia đình: 300.000 VNĐ/thuê bao (đã bao gồm VAT)\r\n\r\n3. Khu vực áp dụng\r\n - Áp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố\r\n\r\n4. Tổng đài hỗ trợ \r\n - Để được hỗ trợ về dịch vụ internet và truyền hình, Quý khách vui lòng liên hệ 1800 1166 (miễn phí)', 'services/ywuluDQmFMnmGOIzvNBl9B2czT8VhFveTfiYBYPt.jpg', 'Phần mềm', 1000000.00, NULL, '2025-04-10 08:34:14', '2025-04-28 21:21:31', 1),
(60, 'Phát triển Website Bán Hàng', 'Website thương mại điện tử hiện đại', 'Tích hợp giỏ hàng, thanh toán online, responsive.', 'services/cNNkKoPxq6CrK0deT4oQKWa91xHHNfpGDGGsY74p.jpg', 'Phần mềm', 5000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 01:39:57', 1),
(61, 'Ứng dụng di động Android/iOS', 'Lập trình app mobile đa nền tảng', 'Sử dụng Flutter, React Native, tích hợp API.', 'services/bGnzqrBeWEDo2XNa2cqm49xMoL98x0ky1vR2Wn5V.jpg', 'Phần mềm', 7000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 01:43:03', 1),
(62, 'Tư vấn triển khai ERP', 'Tư vấn ERP toàn diện cho doanh nghiệp', 'Kế toán, nhân sự, bán hàng, kho, CRM.', 'services/7wUFUxn0ccfLDSHD1PFPhylhj4B0jVGo3sW5OCVt.png', 'Phần mềm', 8000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 01:46:00', 0),
(63, 'Xây dựng hệ thống LMS', 'Nền tảng học trực tuyến chuyên nghiệp', 'Video, quiz, chấm điểm, chứng chỉ.', 'services/RKoFDQMzxRPoVM52drzp4yERsRJeAyFVJKxB1iRw.jpg', 'Phần mềm', 10000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 01:49:15', 0),
(64, 'Tối ưu Cơ sở Dữ liệu', 'Tối ưu tốc độ và dung lượng dữ liệu', 'Query, index, backup, mô hình hóa.', 'services/z2z8pU8Sg3oDdMAhb17VrkO0UdX1ruC8m7rmCdLF.png', 'Phần mềm', 3000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 02:30:16', 0),
(65, 'Giải pháp CRM khách hàng', 'Quản lý khách hàng và bán hàng hiệu quả', 'Quản lý pipeline, email marketing, báo cáo.', 'services/uO1aVoHBgpsu44e4Zd7ymY8SVhuDBdn64rA14xmM.png', 'Phần mềm', 4000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 02:33:49', 0),
(66, 'Dịch vụ DevOps', 'Tự động hóa CI/CD và hạ tầng', 'Docker, Jenkins, GitLab CI, cloud deploy.', 'services/g6DP7nK0xbnZjqPuBHMmhFh9hp8wjdxdgu0OsnMA.jpg', 'Phần mềm', 4500000.00, 3, '2025-04-11 04:27:26', '2025-04-28 02:37:13', 0),
(67, 'Bảo mật ứng dụng Web', 'Phân tích và bảo vệ hệ thống', 'Kiểm thử lỗ hổng OWASP, tường lửa ứng dụng.', 'services/HSGTG3vEXHi8HUb6uUwyJg7AaCC9FzhPtTRk4pmu.jpg', 'Phần mềm', 5000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 02:39:46', 1),
(68, 'Dịch vụ API Gateway', 'Tích hợp API trung gian', 'Quản lý version, bảo mật, định tuyến thông minh.', 'services/FDI7gOXaq4W4XUaOlGEWHlKA5GKXMCLufeUV1EJS.jpg', 'Phần mềm', 3500000.00, 3, '2025-04-11 04:27:26', '2025-04-28 02:42:05', 0),
(69, 'Triển khai hệ thống Chatbot', 'Chatbot cho website, Facebook', 'Tích hợp AI, hỗ trợ khách hàng 24/7.', 'services/NnOj2eV4w7W4MzA8glqppG7zxyHtasmFCf7l6OE5.png', 'Phần mềm', 4500000.00, 3, '2025-04-11 04:27:26', '2025-04-28 02:44:34', 1),
(70, 'Lắp đặt Camera IP', 'Triển khai giám sát văn phòng', 'Xem từ xa, ghi hình đám mây.', 'services/Gr2eDRHRBCdwkJiPaLsqOMiRMRrikds72Vzm5pB1.jpg', 'Phần cứng', 4000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 02:50:39', 1),
(71, 'Bảo trì máy chủ định kỳ', 'Vá lỗi, tối ưu hiệu suất server', 'Check phần cứng, OS, RAID.', 'services/JLsDP4ipnEKhCWOEa14woyToblKfl5W2WiQq5DsO.jpg', 'Phần cứng', 2500000.00, 3, '2025-04-11 04:27:26', '2025-04-28 03:02:12', 0),
(72, 'Nâng cấp máy tính doanh nghiệp', 'RAM, SSD, vệ sinh thiết bị', 'Tăng hiệu suất máy văn phòng.', 'services/Qev8hg1ZaGoQckeB2aSyArXJ3Cpmz26tz6AjDHHI.jpg', 'Phần cứng', 1500000.00, 3, '2025-04-11 04:27:26', '2025-04-28 03:04:55', 0),
(73, 'Lắp đặt mạng nội bộ LAN', 'Switch, router, phân vùng mạng', 'Setup hạ tầng nội bộ.', 'services/xq08IOR9KYBnQnRsRcypYsDHhWXTPkLe7gIs5vEc.jpg', 'Phần cứng', 3000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 03:07:20', 1),
(74, 'Cung cấp máy tính văn phòng', 'Máy bộ, màn hình, phụ kiện', 'Bảo hành 12 tháng.', 'services/JliBov7ti5OPbUDhekPAZYRaTpWMvKx1pL8NklLT.jpg', 'Phần cứng', 7000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 03:09:23', 1),
(77, 'Thi công tủ rack và cáp mạng', 'Tổ chức tủ mạng chuyên nghiệp', 'Patch panel, chuẩn hóa dây cáp.', 'services/uTm00LDHIjp7sMWXXj0fpA5e0CNgm1xGr9oxL0dW.jpg', 'Phần cứng', 3500000.00, 3, '2025-04-11 04:27:26', '2025-04-28 03:20:10', 0),
(78, 'Cài đặt phần cứng máy chủ', 'Lắp CPU, RAM, RAID, NIC', 'Cấu hình BIOS, test ổn định.', 'services/5q7XToV5v6l13A0VSGDu8Zp8qEsYeFXyU4CgmaS2.jpg', 'Phần cứng', 5000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 03:22:00', 1),
(79, 'Bảo trì thiết bị mạng', 'Switch, router, firewall', 'Firmware update, kiểm tra lỗi.', 'services/LQDgpX2sueZ4Tcl7VL361rJgvlWfjz15Ii4CF7Ls.jpg', 'Phần cứng', 1800000.00, 3, '2025-04-11 04:27:26', '2025-04-28 21:17:22', 0),
(80, 'Đăng ký Internet doanh nghiệp', 'Tốc độ cao, có IP tĩnh', 'Hỗ trợ 24/7, hợp đồng linh hoạt.', 'services/QRHPOlNMzB8iX7oFCjI25Y8rYQT1bMqQ92Ewd5tY.png', 'Nhà mạng', 2000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 06:23:16', 1),
(81, 'Triển khai tổng đài nội bộ (PBX)', 'Liên lạc nội bộ và gọi ngoài', 'VoIP, ghi âm, phân luồng.', 'services/CbVLA6Ej6moQ8J0ErwkQT4UHuSiaLaGWdTDbuqwE.jpg', 'Nhà mạng', 3500000.00, 3, '2025-04-11 04:27:26', '2025-04-28 06:25:17', 1),
(83, 'Triển khai mạng VPN', 'Bảo mật dữ liệu từ xa', 'OpenVPN, IPsec cho doanh nghiệp.', 'services/3fh0Jzh2PtlM63a6w6PXtPTIChAwUOSaOrNAcrKm.jpg', 'Nhà mạng', 3000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 06:33:10', 0),
(84, 'Tư vấn an ninh mạng', 'Firewall, IDS/IPS', 'Đảm bảo an toàn hệ thống.', 'services/YSfFaXlimKW2PY81NFScsHVV4oPr9pywpND12WT1.png', 'Nhà mạng', 3500000.00, 3, '2025-04-11 04:27:26', '2025-04-28 06:35:26', 0),
(86, 'Giám sát hệ thống mạng từ xa', 'Theo dõi uptime, cảnh báo', 'Zabbix, PRTG, email alert.', 'services/ydDJAscJ5A4ZS24bypaq21A5BZtZRJpSLDC2jBtQ.jpg', 'Nhà mạng', 3200000.00, 3, '2025-04-11 04:27:26', '2025-04-28 06:39:42', 0),
(87, 'Cung cấp thiết bị mạng chuyên dụng', 'Router, firewall, WiFi mesh', 'Cisco, Mikrotik, Aruba.', 'services/1EnpaJl9x1y19r4SPaq7mniHRp6n5Hnki8Sfml5p.jpg', 'Nhà mạng', 8000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 06:38:27', 1),
(89, 'Bảo trì định kỳ hệ thống mạng', 'Kiểm tra thiết bị và backup cấu hình', 'Khắc phục sự cố định kỳ.', 'services/6ASabo4THqMEeQKUEzuR0prWKPA5OHEd3JnbEoXR.jpg', 'Nhà mạng', 2000000.00, 3, '2025-04-11 04:27:26', '2025-04-28 06:42:04', 0),
(102, 'Dịch vụ bảo mật dữ liệu cao cấp', '123', '123', NULL, 'Phần mềm', 123123.00, 3, '2025-04-28 21:12:09', '2025-04-28 21:12:09', 1),
(103, 'Dịch vụ bảo mật dữ liệu', '321', '321', NULL, 'Phần mềm', 321321.00, 3, '2025-04-28 21:13:31', '2025-04-28 21:13:31', 0);

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
('5IqPWmgJXpZe9o6HdYZWcG4AARH5IGZzbxAZisVO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieEFUYXhUakFMSlh6SmQ3eFZMQlVDd2VzdlFXeldVa3RtSTNlUVF1SiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jdXN0b21lci9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1745900562);

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
(17, 10, 'NGUYEN HUU TRUONG', 'nguyenhuutruong05092003@gmail.com', '582555', '049203001101', '1 năm', 'Đang xử lý', '2025-04-26 07:49:01', '2025-04-26 07:49:01', '2025-04-26 07:49:01'),
(18, 11, 'NGUYEN HUU TRUONG', 'nguyenhuutruong05092003@gmail.com', '353569', '049203001101', '6 tháng', 'Đang xử lý', '2025-04-26 21:52:36', '2025-04-26 21:52:36', '2025-04-26 21:52:36'),
(19, 12, 'NGUYEN HUU TRUONG', 'nguyenhuutruong05092003@gmail.com', '662022', '049203001101', '3 năm', 'Đang xử lý', '2025-04-26 21:53:35', '2025-04-26 21:53:35', '2025-04-26 21:53:35'),
(25, 18, 'NGUYEN HUU TRUONG', 'nguyenhuutruong05092003@gmail.com', '164552', '049203001101', '6_thang', 'Đang xử lý', '2025-04-27 00:39:34', '2025-04-27 00:39:34', '2025-04-27 00:39:34');

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
  ADD KEY `contracts_customer_id_foreign` (`customer_id`);

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
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT cho bảng `signatures`
--
ALTER TABLE `signatures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
