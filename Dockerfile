# syntax=docker/dockerfile:1

FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html/public

# Enable Apache mod_rewrite (important for Laravel/any route handling)
RUN a2enmod rewrite

# Install system dependencies for Composer and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the full project into the container
COPY . /var/www/html

# Install PHP dependencies via Composer
RUN composer install --no-dev --optimize-autoloader

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 for Apache
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
