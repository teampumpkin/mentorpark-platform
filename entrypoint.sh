#!/bin/bash
set -e

# Wait until DB is ready
until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
  echo "Waiting for MySQL..."
  sleep 2
done

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Create storage symlink
if [ ! -L public/storage ]; then
    php artisan storage:link
fi

# Start Apache
apache2-foreground
