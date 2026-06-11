#!/bin/sh
set -e

# Generate APP_KEY jika belum ada
if [ -z "$APP_KEY" ]; then
  echo "Generating Laravel APP_KEY..."
  php artisan key:generate --force
fi

# Bersihkan cache konfigurasi
php artisan config:cache

exec "$@"