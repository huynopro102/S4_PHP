# Base image
FROM php:8.1-fpm

# Cài đặt các extension PHP cần thiết
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy source code vào container
COPY ../app /var/www/html

# Phân quyền
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expose port
EXPOSE 9000

CMD ["php-fpm"]
