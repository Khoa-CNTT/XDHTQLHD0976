<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing 


📌 # ConT Management - Hệ Thống Quản Lý Hợp Đồng

Hệ thống quản lý hợp đồng và hỗ trợ khách hàng được xây dựng trên nền tảng Laravel, hỗ trợ doanh nghiệp theo dõi, quản lý hợp đồng và tương tác với khách hàng.

![Laravel](https://img.shields.io/badge/Laravel-v9.0+-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

## Tính Năng Chính

- Quản lý hợp đồng và dịch vụ
- Xử lý yêu cầu hỗ trợ từ khách hàng
- Hệ thống thông báo
- Quản lý khách hàng và nhân viên
- Báo cáo và thống kê

## Yêu Cầu Hệ Thống

Trước khi bắt đầu, đảm bảo bạn đã cài đặt các phần mềm sau:

- [PHP 8.1 hoặc cao hơn](https://www.php.net/downloads.php)
- [XAMPP](https://www.apachefriends.org/download.html) (bao gồm Apache, MySQL, PHP)
- [Composer](https://getcomposer.org/) (Công cụ quản lý phụ thuộc cho PHP)
- [Node.js & npm](https://nodejs.org/) (Để quản lý các phụ thuộc JavaScript)

## Hướng Dẫn Cài Đặt

### Bước 1: Cài Đặt Môi Trường

1. Khởi động XAMPP Control Panel và bật các dịch vụ:
   - Apache
   - MySQL

### Bước 2: Sao Chép (Clone) Dự Án

1. Mở Terminal hoặc Git Bash
2. Clone dự án về máy tính của bạn:
   ```
   git clone https://github.com/ConTmanagement23444/ConTraCT
   ```
3. Di chuyển vào thư mục dự án:
   ```
   cd ConTraCT
   ```

### Bước 3: Cài Đặt Các Phụ Thuộc

1. Cài đặt các phụ thuộc PHP qua Composer:
   ```
   composer install
   ```

2. Cài đặt các phụ thuộc JavaScript:
   ```
   npm install
   ```

### Bước 4: Thiết Lập File Môi Trường

1. Sao chép file `.env.example` thành `.env`:
   ```
   cp .env.example .env
   ```
   **Lưu ý**: File `.env` không được đưa lên Git vì lý do bảo mật. File `.env.example` là bản mẫu để người dùng tạo file `.env` riêng.

2. Mở file `.env` và cấu hình các thông số cơ sở dữ liệu:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=cont_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. Tạo khóa ứng dụng:
   ```
   php artisan key:generate
   ```

### Bước 5: Thiết Lập Cơ Sở Dữ Liệu

1. Mở trình duyệt và truy cập phpMyAdmin: http://localhost/phpmyadmin
2. Tạo cơ sở dữ liệu mới đặt tên là `cont_management`
3. Nhập dữ liệu từ file SQL:
   - Chọn cơ sở dữ liệu `cont_management` vừa tạo
   - Chọn tab "Nhập" (Import)
   - Chọn file SQL (nằm trong thư mục `Cont_management_sql` của dự án)
   - Nhấn "Thực hiện" (Go)

   **Hoặc** nếu bạn muốn tạo mới cấu trúc cơ sở dữ liệu và dữ liệu mẫu:
   ```
   php artisan migrate --seed
   ```

### Bước 6: Khởi Chạy Ứng Dụng

1. Biên dịch tài nguyên frontend (nếu cần):
   ```
   npm run dev
   ```

2. Chạy máy chủ phát triển Laravel:
   ```
   php artisan serve
   ```

3. Mở trình duyệt và truy cập: `http://127.0.0.1:8000`

## Thông Tin Đăng Nhập Mặc Định

- **Tài khoản Admin**: admin@gmail.com
- **Mật khẩu**: 123

## Lưu Ý Về File .env

File `.env` chứa các thông tin nhạy cảm như:
- Thông tin kết nối database
- Khóa bảo mật của ứng dụng
- Thông tin API, email, tài khoản dịch vụ...

Vì lý do bảo mật, file này không được đưa lên Git. Thay vào đó:
- Dự án cung cấp file `.env.example` như một mẫu
- Mỗi người dùng sao chép file này và tùy chỉnh cấu hình cho môi trường của họ
- Việc này đảm bảo mỗi người dùng có thể có cấu hình riêng mà không ảnh hưởng đến người khác

## Khắc Phục Sự Cố

- **Lỗi quyền truy cập**: Đảm bảo thư mục `storage` và `bootstrap/cache` có quyền ghi
  ```
  chmod -R 775 storage bootstrap/cache
  ```

- **Lỗi thiếu extension PHP**: Kiểm tra và bật các extension cần thiết trong PHP (file php.ini):
  - pdo_mysql
  - mbstring
  - fileinfo
  - openssl
  - tokenizer
  - xml

- **Lỗi "No application encryption key has been specified"**: Chạy lệnh
  ```
  php artisan key:generate
  ```

## Đóng Góp

Nếu bạn muốn đóng góp vào dự án, vui lòng:
1. Fork dự án
2. Tạo nhánh tính năng (`git checkout -b feature/amazing-feature`)
3. Commit thay đổi (`git commit -m 'Add some amazing feature'`)
4. Push lên nhánh (`git push origin feature/amazing-feature`)
5. Mở Pull Request

## Giấy Phép

Dự án được phân phối dưới giấy phép MIT. Xem [LICENSE](LICENSE) để biết thêm thông tin.

## Liên Hệ

Nếu bạn có câu hỏi hoặc đề xuất, vui lòng liên hệ qua:
- Email: okamibada@gmail.com
- GitHub Issues: https://github.com/ngapham23