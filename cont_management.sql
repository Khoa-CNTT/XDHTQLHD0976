-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
<<<<<<<< HEAD:cont_management (2).sql
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 10, 2025 lúc 06:47 PM
========
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th4 10, 2025 lúc 03:22 PM
>>>>>>>> 5f0d5dba433193553e430f96a7044e23da93adab:cont_management.sql
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

<<<<<<<< HEAD:cont_management (2).sql
========
--
-- Đang đổ dữ liệu cho bảng `contracts`
--

INSERT INTO `contracts` (`id`, `service_id`, `contract_number`, `start_date`, `end_date`, `status`, `total_price`, `signed_document`, `created_at`, `updated_at`) VALUES
(1, 3, '001', '2025-04-08', '2025-04-19', 'Hoạt động', 100000.00, NULL, '2025-04-06 10:45:20', '2025-04-08 01:19:08'),
(2, 3, '002', '2025-04-11', '2025-04-12', 'Chờ xử lý', 34243.00, NULL, '2025-04-07 08:22:31', '2025-04-07 08:38:39');

>>>>>>>> 5f0d5dba433193553e430f96a7044e23da93adab:cont_management.sql
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
(2, 9, 'ngaphammm', 'TAX002', '2025-04-04 23:55:07', '2025-04-04 23:55:07'),
(3, 12, 'congty aa', '0509', '2025-04-08 00:05:53', '2025-04-08 00:05:53');

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
(8, '2025_04_07_161710_add_customer_name_and_email_to_signatures_table', 4);

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
  `content` text NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_hot` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

<<<<<<<< HEAD:cont_management (2).sql
INSERT INTO `services` (`id`, `service_name`, `description`, `content`, `service_type`, `price`, `created_by`, `created_at`, `updated_at`) VALUES
(19, 'HOME 3_NgT (Mesh)', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', 'Nhà mạng', 310000.00, NULL, '2025-04-10 06:14:48', '2025-04-10 06:14:48'),
(20, 'Home 2', 'Đường truyền Internet tốc độ 500Mbps\r\n\r\nTrang bị thêm Wifi Mesh 5/6 chỉ với 30.000đ/tháng', 'Đường truyền Internet tốc độ 500Mbps\r\n\r\nTrang bị thêm Wifi Mesh 5/6 chỉ với 30.000đ/tháng', 'Nhà mạng', 240000.00, NULL, '2025-04-10 08:30:46', '2025-04-10 08:32:08'),
(21, 'HOME 4_NgT (Mesh)', 'Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\nTrang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\nÁp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố', '1. Ưu đãi gói cước\r\n- Đường truyền Internet tốc độ từ 500 Mbps lên tới 1000 Mbps tuỳ thuộc khoảng cách tới thiết bị phát Wifi, chủng loại thiết bị và hạ tầng tại từng khu vực\r\n- Trang bị 01 Wifi Mesh 5 hoặc 01 Wifi Mesh 6\r\n+  Wifi Mesh 5: \r\n     * Wifi Mesh 5 iGate EW12ST là sự kết hợp giữa chuẩn Wifi 5 và công nghệ Mesh Wifi, phù hợp với hộ gia đình với mọi cấu trúc nhà ở. \r\n     * Tốc độ lên đến 1200Mbps trên cả 2 băng tần 2,4-5GHz\r\n     * Kết nối liền mạch, chỉ tạo tên 1 Wifi duy nhất\r\n     * Hỗ trợ đồng thời 40 thiết bị\r\n     * Cài đặt dễ dàng, triển khai linh hoạt.\r\n+ Wifi Mesh 6:\r\n     *Wifi Mesh 6 iGate EW30SX là sự kết hợp giữa chuẩn Wifi 6 và công nghệ Mesh, phù hợp với các doanh nghiệp, tổ chức vừa và nhỏ, các gia đình có nhu cầu sử dụng internet cao. \r\n     * Tốc độ lên đến 3Gbps, trên cả hai băng tần 2,4 – 5GHz\r\n     * Kết nối liền mạch, phù hợp mọi ngóc ngách\r\n     * Hỗ trợ đồng thời 100 thiết bị\r\n     * Độ trễ giảm 50%. \r\n- Lắp đặt nhanh chóng, chăm sóc và hỗ trợ khách hàng 24/7\r\n\r\n2. Cước đấu nối hòa mạng\r\n - Cước đấu nối hòa mạng áp dụng cho thuê bao đăng ký mới dịch vụ cho Khách hàng cá nhân, Hộ gia đình: 300.000 VNĐ/thuê bao (đã bao gồm VAT)\r\n\r\n3. Khu vực áp dụng\r\n - Áp dụng tại ngoại thành Hà Nội, TP.HCM & 61 Tỉnh/thành phố\r\n\r\n4. Tổng đài hỗ trợ \r\n - Để được hỗ trợ về dịch vụ internet và truyền hình, Quý khách vui lòng liên hệ 1800 1166 (miễn phí)', 'Phần mềm', 1000000.00, NULL, '2025-04-10 08:34:14', '2025-04-10 09:46:50'),
(26, 'câcc', 'câc', 'âcc', 'Phần mềm', 500000.00, NULL, '2025-04-10 09:14:56', '2025-04-10 09:14:56'),
(29, 'ngapham', '230130', '0230130', 'Phần mềm', 1000000.00, 3, '2025-04-10 09:36:14', '2025-04-10 09:36:14');
========
INSERT INTO `services` (`id`, `service_name`, `description`, `content`, `service_type`, `price`, `created_by`, `created_at`, `updated_at`, `is_hot`) VALUES
(3, 'Hợp đồng Cung Cấp Dịch Vụ Quản Trị Mạng và Hệ Thống Máy Chủ', 'Hợp đồng này quy định các dịch vụ quản trị mạng và hệ thống máy chủ.', '', 'Phần mềm', 5000000.00, 2, '2025-04-05 08:04:29', '2025-04-08 05:01:28', 0),
(5, 'Hợp đồng cung cấp dịch vụ công nghệ thông tin và giải pháp điện tử', 'Hợp đồng cung cấp dịch vụ công nghệ thông tin và giải pháp điện tử', '', 'Phần mềm', 500000.00, 2, '2025-04-07 07:28:29', '2025-04-07 07:28:29', 0),
(17, 'Dịch vụ bảo mật dữ liệu', '...', '123', 'Nhà mạng', 1000000.00, 2, '2025-04-08 05:02:13', '2025-04-09 20:39:47', 0),
(19, 'Dịch vụ 1', 'đây la dịch vụ 1', 'đây là dịch vụ 1 nha nha', 'Nhà mạng', 1111111.00, 2, '2025-04-09 20:40:35', '2025-04-09 20:53:07', 1),
(20, 'Dịch vụ 2', '123', '123', 'Phần mềm', 123.00, 2, '2025-04-09 21:47:39', '2025-04-09 22:03:05', 1),
(21, 'Dịch vụ Phát triển Website', 'Phát triển website theo yêu cầu của khách hàng', 'Thiết kế giao diện, xây dựng hệ thống backend', 'Phần mềm', 2000000.00, 2, '2025-04-10 05:00:00', '2025-04-10 05:00:00', 1),
(22, 'Dịch vụ Bảo mật Ứng dụng', 'Tư vấn và triển khai các giải pháp bảo mật ứng dụng', '...', 'Phần mềm', 2500000.00, 2, '2025-04-10 05:10:00', '2025-04-10 05:10:00', 0),
(23, 'Dịch vụ Phát triển Mobile App', 'Phát triển ứng dụng trên iOS và Android', '...', 'Phần mềm', 3000000.00, 2, '2025-04-10 05:20:00', '2025-04-10 05:20:00', 1),
(24, 'Dịch vụ Quản lý Dữ liệu', 'Quản lý và tối ưu hóa cơ sở dữ liệu', '...', 'Phần mềm', 1500000.00, 2, '2025-04-10 05:30:00', '2025-04-10 05:30:00', 0),
(25, 'Dịch vụ Tư vấn CNTT', 'Tư vấn giải pháp công nghệ thông tin cho doanh nghiệp', '...', 'Phần mềm', 3500000.00, 2, '2025-04-10 05:40:00', '2025-04-10 05:40:00', 1),
(26, 'Dịch vụ Sửa chữa Laptop', 'Sửa chữa các lỗi phần cứng và phần mềm laptop', 'Kiểm tra và sửa chữa linh kiện', 'Phần cứng', 500000.00, 2, '2025-04-10 05:00:00', '2025-04-10 05:00:00', 1),
(27, 'Dịch vụ Bảo trì Máy chủ', 'Bảo trì và nâng cấp hệ thống máy chủ', '...', 'Phần cứng', 2000000.00, 2, '2025-04-10 05:10:00', '2025-04-10 05:10:00', 0),
(28, 'Dịch vụ Lắp đặt Thiết bị Mạng', 'Lắp đặt router, switch và thiết bị mạng', '...', 'Phần cứng', 1500000.00, 2, '2025-04-10 05:20:00', '2025-04-10 05:20:00', 1),
(29, 'Dịch vụ Lắp ráp Máy tính', 'Lắp ráp máy tính theo yêu cầu của khách hàng', '...', 'Phần cứng', 1000000.00, 2, '2025-04-10 05:30:00', '2025-04-10 05:30:00', 0),
(30, 'Dịch vụ Sửa chữa Thiết bị Ngoại vi', 'Sửa chữa các thiết bị như máy in, máy scan', '...', 'Phần cứng', 700000.00, 2, '2025-04-10 05:40:00', '2025-04-10 05:40:00', 0),
(31, 'Dịch vụ Cài đặt Mạng Doanh nghiệp', 'Thiết lập và triển khai hệ thống mạng cho doanh nghiệp', '...', 'Nhà mạng', 5000000.00, 2, '2025-04-10 05:00:00', '2025-04-10 05:00:00', 1),
(32, 'Dịch vụ Bảo trì Mạng', 'Bảo trì định kỳ hệ thống mạng', '...', 'Nhà mạng', 3000000.00, 2, '2025-04-10 05:10:00', '2025-04-10 05:10:00', 0),
(33, 'Dịch vụ Tối ưu Hóa Băng thông', 'Tối ưu hóa băng thông mạng để tăng hiệu suất', '...', 'Nhà mạng', 2000000.00, 2, '2025-04-10 05:20:00', '2025-04-10 05:20:00', 1),
(34, 'Dịch vụ Triển khai VPN', 'Thiết lập mạng riêng ảo (VPN) cho doanh nghiệp', '...', 'Nhà mạng', 4000000.00, 2, '2025-04-10 05:30:00', '2025-04-10 05:30:00', 1),
(35, 'Dịch vụ Tư vấn An ninh Mạng', 'Tư vấn giải pháp an ninh mạng toàn diện', '...', 'Nhà mạng', 3500000.00, 2, '2025-04-10 05:40:00', '2025-04-10 05:40:00', 0);
>>>>>>>> 5f0d5dba433193553e430f96a7044e23da93adab:cont_management.sql

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
<<<<<<<< HEAD:cont_management (2).sql
('d8GgW0jywCrsGYDQoQWLyrigHPXCBHvAEpDTLuCc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'ZXlKcGRpSTZJbXR6WkNzMlV6azBTbVl2YkdKU1YzUk1SamNyV0ZFOVBTSXNJblpoYkhWbElqb2ljU3N6YTJOb2VFOXRjV0pVWjJSWU9TdHhRekJHVGxsUmFXcFBibU5LUlRCcE16Tm1VRVZ5WjFZeVJtRlNabG8wUjJacldTdElkbXRFY0c0MVVGYzNUbTVETW1WNU5WQmhkbkpVVjBKWFUydGlWblV6T1dsNVZuZHBUVXhDZFdFM1pUSkZOMlF4VjBSRGNtdENSRmxGT0N0SU5WVnlhakpaVmpCMlRGTklkRVpDVm0xRFNIQk1aMWR1VEZKSWNrMHJUakJ4Y2xKRGFUVkNlSFJTY0hRdmJ6RTNaelpNWWk4M056Tk9ibk13TURkVFNERjBUSE0wU2paNFUyVm5kV2hET1RCdmNHaHdPVWxTY1haSGRIVkhhMjFNWnk5dFZDdFdWVFE0U1dGNlZWSjFaekJEYUcxVGNFTTFXVGxuUjB4V2J6TTNXRU42TUM5YWIwTXJSR0V2WkhSUGFFdzRaWFZ6V1RCVEwzUkdNSE5GZFZJNGNrRTlQU0lzSW0xaFl5STZJakF5T1RFMFpqZzVNekl4TVdFMFpUZGxOemxsWW1WbVpUTXlZVE5qWlRGaVpqTmpZVGhrWW1FNE5qQm1NMkkyWm1Nek5qRTJNRFF3TkRBeU9HRmlZamtpTENKMFlXY2lPaUlpZlE9PQ==', 1744303616),
('rbiLNbDEkOdPtgT72lFDQzTTdi35IV4aKTbSOJ7W', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'ZXlKcGRpSTZJbWMzTUdSWWVHTTBZVTUzWjJOd1FXWnBTVlJwUkVFOVBTSXNJblpoYkhWbElqb2liMkp4Y1ZodmRXUjRlVXhEVEdoSlFsazRhRmhIWlRscGQzZGxNalpYVHpodE9VbFRXbmhrYjJ0UlMyOUJjU3RpWjFBM2RERmFkMlJZU0hoNmN6WmpkalEzTmxoTFZDOUNablI1TkdSTFdYb3hVRVUzTWxJNU1HODNSSFJzVkVGTVVuZE9OM2R1Y0RaTk0zUXdlbFpYVldkVlNFNUtXUzl2TDBOTmJ6UklaRWRFVm1Wak1tOVFXRWx0Y0ROcVV6QmpUVXBZYm5ZM1MyOTZjM1UwTVV0T09GVXpaVmw2WTNGTE5FeFJPV3BFVGxWSGMyZFpSa2R4VFdsNlVsQk9lR3hXZWxSbU9EZFlVbW8wYW5kSmVqWkVVa1pxVDNaSmMyOVFZWFZsZWxwMFdHZGxZVXd5V0V0bWFVRTRkbHByTVZSdVNHUjJWR3MzTlhjMFREWXJSa1JvVVZVeGJUUkhUR1ExUlVkWFRGUjVXRXROWTJ0SFRsRTlQU0lzSW0xaFl5STZJak5pTldZd05UQXhaR1poTXpGa01UYzNZakV5T1RCalltTTVPVFZpTW1NNE1ESTNaV1EyTldRek5HRm1OV1UwTm1FMVpqaGpPV0kzWldFNU1HTmtaREFpTENKMFlXY2lPaUlpZlE9PQ==', 1744300387);
========
('eUyrHI9vEvlOZLYEgEgslLUEFHDRVhb5R8coaE2d', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieXA1M2I1SElEVlpSYkdyUHhLeW5kcDM0SVQ1SGl2T3g1WTVTRjZQciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jdXN0b21lci9zZXJ2aWNlcy9maWx0ZXIvVCVFMSVCQSVBNXQlMjBDJUUxJUJBJUEzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTI7fQ==', 1744291337);
>>>>>>>> 5f0d5dba433193553e430f96a7044e23da93adab:cont_management.sql

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
<<<<<<<< HEAD:cont_management (2).sql
(9, 'ngapham', 'okamibada@gmail.com', '$2y$12$ERICZ.v4gMUIv.aTW0EqsOmen.4dnD0YUnChdDpGgtw3Q/IefSOw6', 'customer', '0987653214', '12312313123', '2025-04-04 23:55:07', '2025-04-10 08:53:07', NULL);
========
(9, 'ngapham', 'okamibada@gmail.com', '$2y$12$33n3YkWig1mmCvaWj4/wQekpPq7ulLPw5dd.Gw2p9j1c8jkumDaoy', 'customer', '0987653214', '12312313123', '2025-04-04 23:55:07', '2025-04-04 23:55:07', NULL),
(10, 'Nguyễn Văn A', 'nguyenvana@example.com', '$2y$12$omKYbFq8TuGPG5D/mi/9pO9nrSptwCS9nQWv9V45Di88ZdWq1amSy', 'employee', NULL, NULL, '2025-04-05 08:00:35', '2025-04-05 08:00:35', NULL),
(11, 'Trần Thị B', 'tranthib@example.com', '$2y$12$WbfoT3J2SZMWA6KFbg5VWu/nW3r0u.yG5iGphUA41XzBQS/JhzeAG', 'employee', NULL, NULL, '2025-04-05 08:00:35', '2025-04-05 08:00:35', NULL),
(12, 'NGUYEN HUU TRUONG', 'nguyenhuutruong05092003@gmail.com', '$2y$12$r3tyJYAuP5jZTUpgwOUdE.mKV5vRucsAvGZ6XczLuFr4z2wivhiqK', 'customer', '0328394538', 'K45A/38 Dũng Sĩ Thanh Khê, Thanh Khê Tây, Thanh Khê, Đà Nẵng', '2025-04-08 00:05:53', '2025-04-08 00:05:53', NULL);
>>>>>>>> 5f0d5dba433193553e430f96a7044e23da93adab:cont_management.sql

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
<<<<<<<< HEAD:cont_management (2).sql
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
========
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
>>>>>>>> 5f0d5dba433193553e430f96a7044e23da93adab:cont_management.sql

--
-- AUTO_INCREMENT cho bảng `signatures`
--
ALTER TABLE `signatures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
