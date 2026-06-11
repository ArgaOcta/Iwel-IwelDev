#!/bin/sh
set -e

# 1. Pastikan izin akses folder benar untuk seluruh direktori aplikasi.
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 2. Cek apakah vendor ada (Jika mount volume lokal menimpa folder kontainer)
if [ ! -d "/var/www/html/vendor" ]; then
  echo "Vendor directory not found. Installing dependencies..."
  # Gunakan --no-scripts agar tidak mencoba koneksi database saat install
  composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts
fi

# 3. Generate Key jika belum ada
if [ -z "$APP_KEY" ]; then
  echo "Generating Laravel APP_KEY..."
  php artisan key:generate --force
fi

# 4. Migrasi Database (Jalankan di bawah user www-data agar permission file aman)
echo "Running migrations..."
su -s /bin/sh -c "php artisan migrate --force" www-data

# 5. Cache Konfigurasi
echo "Caching configuration..."
su -s /bin/sh -c "php artisan config:cache" www-data
su -s /bin/sh -c "php artisan route:cache" www-data
su -s /bin/sh -c "php artisan view:cache" www-data

# Jalankan perintah utama kontainer (seperti php-fpm atau apache)
exec "$@"