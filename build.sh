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
WORKDIR /app
RUN ./build.sh
# Kiểm tra quyền của các file
RUN ls -l /app

# In ra các thông tin môi trường để debug
RUN echo "Running build script..."
RUN ls -l /app/build.sh
RUN chmod +x /app/build.sh
RUN ./build.sh

# Kiểm tra PHP và Composer
RUN php -v
RUN composer -v

# Cài đặt thư viện composer
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


docker build --no-cache -t your-image-name .
