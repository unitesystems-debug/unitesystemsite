#!/usr/bin/env bash
#
# Redeploy script for Unite Systems on the production server.
# Run this ON THE SERVER from the project root, e.g.:
#   cd /var/www/unitesystems && bash deploy/deploy.sh
#
set -euo pipefail

echo "==> Pulling latest code"
git pull origin main

echo "==> Installing PHP dependencies"
composer install --no-dev --optimize-autoloader

echo "==> Installing & building front-end assets"
npm ci
npm run build

echo "==> Running database migrations"
php artisan migrate --force

echo "==> Refreshing caches"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Fixing storage permissions"
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

echo "==> Reloading PHP-FPM"
sudo systemctl reload php8.4-fpm

echo "==> Done."
