#!/bin/sh
set -e

# Ensure Composer dependencies are installed first. When the host directory is mounted,
# the vendor folder may be missing inside the container. Install them if the directory
# does not exist.
if [ ! -d "vendor" ]; then
  echo "Installing Composer dependencies..."
  composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
fi

# Generate APP_KEY if not set (requires vendor files)
if [ -z "$APP_KEY" ]; then
  echo "Generating Laravel APP_KEY..."
  php artisan key:generate --force
fi

# Bersihkan cache konfigurasi
php artisan config:cache

exec "$@"