#!/bin/bash

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
