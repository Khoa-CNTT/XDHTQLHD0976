# Sử dụng image PHP chính thức (php:8.2-cli)
FROM php:8.2-cli

# Cài đặt các dependencies cần thiết (bao gồm oniguruma cho mbstring)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    libonig-dev && \
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

# Chạy build.sh
RUN ./build.sh

# In ra thông tin môi trường (debug)
RUN echo "Running build script..."

# Kiểm tra phiên bản PHP và Composer
RUN php -v
RUN composer -v

# Cài đặt thư viện Composer (nếu chưa cài đặt trong build.sh)
RUN composer install --no-dev --optimize-autoloader

# Cache các cấu
