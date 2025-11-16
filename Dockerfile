FROM php:8.2-apache

WORKDIR /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set Apache DocumentRoot to public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project files
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Ensure storage and bootstrap/cache are writable
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy entrypoint script
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose port
EXPOSE 80

# Start container via entrypoint
ENTRYPOINT ["/entrypoint.sh"]
