#!/bin/bash

# Exit on error
set -e

echo "=== Clever Cloud Post-Build Hook Started ==="

# 1. Install Node.js dependencies and compile Vite assets
echo "Installing Node.js dependencies..."
npm install

echo "Compiling frontend assets with Vite..."
npm run build

# 2. Run Database Migrations
echo "Running database migrations..."
php artisan migrate --force

# 3. Optimize Laravel
echo "Clearing application caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Caching application config, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Clever Cloud Post-Build Hook Completed Successfully ==="
