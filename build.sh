#!/bin/bash
# Sử dụng image PHP
FROM php:8.2-cli

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cài đặt các extensions của PHP nếu cần (ví dụ: pdo, mbstring)
RUN docker-php-ext-install pdo pdo_mysql mbstring

# Copy mã nguồn vào container
COPY . /app/.

# Cấp quyền thực thi cho build.sh
RUN chmod +x /app/build.sh

# Chạy build.sh
RUN ./build.sh
# In ra các thông tin môi trường để debug
echo "Running build script..."

# Kiểm tra PHP và Composer
php -v
composer -v

# Cài đặt thư viện composer
composer install --no-dev --optimize-autoloader

# Cache các cấu hình, routes, và views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Xóa cache cũ (nếu cần)
php artisan optimize:clear

# Liên kết thư mục storage
php artisan storage:link

# Migrate database nếu có thay đổi schema
php artisan migrate --force

# Tạo các keys cho Laravel Passport (nếu có dùng Passport)
php artisan passport:keys

# Tối ưu hóa app
php artisan optimize
