#!/bin/bash
set -e

# Clear Laravel caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Create storage symlink if not exists
if [ ! -L public/storage ]; then
    php artisan storage:link
fi

# Start Apache
apache2-foreground
