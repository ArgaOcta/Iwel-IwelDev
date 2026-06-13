#!/bin/sh
set -e

# ─────────────────────────────────────────────────────────────────────────────
# 1. Sync application files from /var/app (baked into image)
#    to /var/www/html (shared named volume with nginx container)
#    IMPORTANT: We preserve the .env file if it already exists in the target.
# ─────────────────────────────────────────────────────────────────────────────
echo "[entrypoint] Syncing application files to shared volume..."

# Copy all files EXCEPT .env (to avoid overwriting the mounted/existing .env)
rsync -a --exclude='.env' /var/app/. /var/www/html/ 2>/dev/null \
  || (cp -a /var/app/. /var/www/html/ && echo "[entrypoint] rsync not available, used cp")

# If .env does not exist yet in target, copy from /var/app/.env (mounted from host)
if [ ! -f "/var/www/html/.env" ]; then
  if [ -f "/var/app/.env" ]; then
    echo "[entrypoint] Copying .env to shared volume..."
    cp /var/app/.env /var/www/html/.env
  else
    echo "[entrypoint] WARNING: No .env file found! Please create one from .env.example"
  fi
else
  echo "[entrypoint] .env already exists in shared volume, keeping it."
fi

# ─────────────────────────────────────────────────────────────────────────────
# 2. Set correct ownership and permissions
# ─────────────────────────────────────────────────────────────────────────────
echo "[entrypoint] Setting permissions..."
chown -R www-data:www-data \
  /var/www/html/storage \
  /var/www/html/bootstrap/cache \
  /var/www/html/public

chmod -R 775 \
  /var/www/html/storage \
  /var/www/html/bootstrap/cache
chmod -R 755 /var/www/html/public

# ─────────────────────────────────────────────────────────────────────────────
# 3. Install vendor if missing (safety check)
# ─────────────────────────────────────────────────────────────────────────────
if [ ! -d "/var/www/html/vendor" ]; then
  echo "[entrypoint] Vendor directory not found. Installing dependencies..."
  cd /var/www/html
  composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts
fi

# All artisan commands run from the correct working directory
cd /var/www/html

# ─────────────────────────────────────────────────────────────────────────────
# 4. Generate APP_KEY if missing or empty IN THE .env FILE
#    (Checking the file, not just the container env var)
# ─────────────────────────────────────────────────────────────────────────────
ENV_FILE="/var/www/html/.env"
if [ -f "$ENV_FILE" ]; then
  CURRENT_KEY=$(grep -E "^APP_KEY=" "$ENV_FILE" | cut -d '=' -f2 | tr -d '[:space:]')
  if [ -z "$CURRENT_KEY" ] || [ "$CURRENT_KEY" = "null" ]; then
    echo "[entrypoint] APP_KEY is empty. Generating new key..."
    # Allow writing temporarily if needed
    chmod u+w "$ENV_FILE" 2>/dev/null || true
    php artisan key:generate --force
    echo "[entrypoint] APP_KEY generated successfully."
  else
    echo "[entrypoint] APP_KEY already set, skipping generation."
  fi
else
  echo "[entrypoint] ERROR: .env file not found at $ENV_FILE. Cannot proceed safely."
  exit 1
fi

# ─────────────────────────────────────────────────────────────────────────────
# 5. Run database migrations
# ─────────────────────────────────────────────────────────────────────────────
echo "[entrypoint] Running migrations..."
su -s /bin/sh -c "cd /var/www/html && php artisan migrate --force" www-data

# ─────────────────────────────────────────────────────────────────────────────
# 6. Cache configuration, routes and views for performance
# ─────────────────────────────────────────────────────────────────────────────
echo "[entrypoint] Caching configuration..."
su -s /bin/sh -c "cd /var/www/html && php artisan config:cache" www-data
su -s /bin/sh -c "cd /var/www/html && php artisan route:cache" www-data
su -s /bin/sh -c "cd /var/www/html && php artisan view:cache" www-data

echo "[entrypoint] Startup complete. Starting PHP-FPM..."

# ─────────────────────────────────────────────────────────────────────────────
# Run the main container command (php-fpm)
# ─────────────────────────────────────────────────────────────────────────────
exec "$@"