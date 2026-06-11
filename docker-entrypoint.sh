#!/bin/sh
set -e

# ─────────────────────────────────────────────────────────────
# 1. Sync application files from /var/app (baked into image)
#    to /var/www/html (shared named volume with nginx container)
# ─────────────────────────────────────────────────────────────
echo "Syncing application files to shared volume..."
cp -a /var/app/. /var/www/html/

# ─────────────────────────────────────────────────────────────
# 2. Set correct ownership and permissions
# ─────────────────────────────────────────────────────────────
echo "Setting permissions..."
chown -R www-data:www-data \
  /var/www/html/storage \
  /var/www/html/bootstrap/cache \
  /var/www/html/public

chmod -R 775 \
  /var/www/html/storage \
  /var/www/html/bootstrap/cache
chmod -R 755 /var/www/html/public

# ─────────────────────────────────────────────────────────────
# 3. Install vendor if missing (safety check)
# ─────────────────────────────────────────────────────────────
if [ ! -d "/var/www/html/vendor" ]; then
  echo "Vendor directory not found. Installing dependencies..."
  cd /var/www/html
  composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts
fi

# Change working directory for Laravel commands
cd /var/www/html

# ─────────────────────────────────────────────────────────────
# 4. Generate APP_KEY if missing
# ─────────────────────────────────────────────────────────────
if [ -z "$APP_KEY" ]; then
  echo "Generating Laravel APP_KEY..."
  php artisan key:generate --force
fi

# ─────────────────────────────────────────────────────────────
# 5. Run database migrations
# ─────────────────────────────────────────────────────────────
echo "Running migrations..."
su -s /bin/sh -c "cd /var/www/html && php artisan migrate --force" www-data

# ─────────────────────────────────────────────────────────────
# 6. Cache configuration, routes and views
# ─────────────────────────────────────────────────────────────
echo "Caching configuration..."
su -s /bin/sh -c "cd /var/www/html && php artisan config:cache" www-data
su -s /bin/sh -c "cd /var/www/html && php artisan route:cache" www-data
su -s /bin/sh -c "cd /var/www/html && php artisan view:cache" www-data

echo "Startup complete. Starting PHP-FPM..."

# ─────────────────────────────────────────────────────────────
# Run the main container command (php-fpm)
# ─────────────────────────────────────────────────────────────
exec "$@"