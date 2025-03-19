# Sử dụng image PHP với Apache
FROM php:8.1-apache

# Cài đặt các extension cần thiết cho PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy mã nguồn vào container
COPY . /var/www/html/

# Cấp quyền cho thư mục uploads
RUN chown -R www-data:www-data /var/www/html/uploads
RUN chmod -R 755 /var/www/html/uploads

# Bật module rewrite của Apache
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80