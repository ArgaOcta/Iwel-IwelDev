#!/bin/sh
set -e

# 1. Pastikan folder storage dapat ditulis oleh web-server
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 2. Cek apakah vendor ada (jika mount volume menghapus vendor)
if [ ! -d "/var/www/html/vendor" ]; then
  echo "Vendor directory not found. Installing dependencies..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# 3. Generate Key jika belum ada
if [ -z "$APP_KEY" ]; then
  echo "Generating Laravel APP_KEY..."
  php artisan key:generate --force
fi

# 4. Migrasi Database
echo "Running migrations..."
php artisan migrate --force

# 5. Cache Konfigurasi
php artisan config:cache

exec "$@"