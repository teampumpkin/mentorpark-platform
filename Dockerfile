# syntax=docker/dockerfile:1

FROM php:8.2-apache

# Enable Apache mod_rewrite (important for Laravel/any route handling)
RUN a2enmod rewrite

# Install PHP extensions (adjust based on your app)
RUN docker-php-ext-install pdo pdo_mysql

# Copy project files into the Apache root directory
COPY public/ /var/www/html/

# Set correct permissions (optional but recommended)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
