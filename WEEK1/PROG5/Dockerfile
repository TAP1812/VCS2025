FROM php:7.4-apache

# Install necessary extensions
RUN apt-get clean && rm -rf /var/lib/apt/lists/* \
    && apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zip \
    unzip \
    git \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy the application code to the container
COPY . /var/www/html/

# Set permissions (optional but recommended)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]