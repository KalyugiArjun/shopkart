#!/usr/bin/env bash
# Exit on error
set -o errexit

# If .env does not exist, copy from .env.example
if [ ! -f .env ]; then
    cp .env.example .env
fi

composer install --no-dev --optimize-autoloader

# Ensure sqlite database exists
mkdir -p database
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

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
