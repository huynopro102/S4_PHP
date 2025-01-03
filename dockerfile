# Sử dụng base image PHP-FPM
FROM php:8.1-fpm

# Cài đặt các package cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Cài đặt các PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Đặt thư mục làm việc
WORKDIR /app

# Copy toàn bộ mã nguồn vào container
COPY . /app

# Phân quyền truy cập
RUN chown -R www-data:www-data /app \
    && find /app -type f -exec chmod 644 {} \; \
    && find /app -type d -exec chmod 755 {} \; \
    && chmod 755 /app/index.php
    
# Expose cổng 9000
EXPOSE 9000

# Khởi động PHP-FPM
CMD ["php-fpm"]
