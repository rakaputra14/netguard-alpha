#!/bin/bash

# Change ownership permission from root/administrator to phpfpm
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Run Optimization and migrations
php artisan storage:link --force
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM
exec "$@"