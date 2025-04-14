# Sử dụng image PHP chính thức
FROM php:8.2-cli

# Cài đặt các dependencies cần thiết cho PHP extensions (bao gồm cả mbstring, pdo_mysql)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libpq-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql mbstring opcache zip

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy mã nguồn vào container
COPY . /app/.

# Chuyển đến thư mục làm việc /app
WORKDIR /app

# Cấp quyền thực thi cho tất cả các file trong thư mục /app (bao gồm cả build.sh)
RUN chmod -R +x /app

# Kiểm tra quyền file và các file trong thư mục
RUN ls -l /app

# Cài đặt thư viện Composer (nếu chưa cài đặt trong build.sh)
RUN composer install --no-dev --optimize-autoloader

# Cache các cấu hình, routes, và views
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Xóa cache cũ (nếu cần)
RUN php artisan optimize:clear

# Liên kết thư mục storage
RUN php artisan storage:link

# Migrate database nếu có thay đổi schema
RUN php artisan migrate --force

# Tạo các keys cho Laravel Passport (nếu có dùng Passport)
RUN php artisan passport:keys

# Tối ưu hóa app
RUN php artisan optimize

# Khởi động lại queue và chạy các jobs trong queue
RUN php artisan queue:work --queue=default --timeout=60 --tries=3 --sleep=3 --no-interaction
RUN php artisan queue:restart
