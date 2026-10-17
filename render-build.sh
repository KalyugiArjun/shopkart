#!/usr/bin/env bash
# Exit on error
set -o errexit

composer install --no-dev --optimize-autoloader

# Ensure sqlite database exists
touch database/database.sqlite

# Ensure storage directories exist and have proper permissions
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R 777 storage bootstrap/cache database

# Run migrations and seed data
php artisan migrate --force --seed
php artisan config:cache
php artisan route:cache
php artisan view:cache
