#!/bin/sh
set -e

# If APP_KEY is not set, generate a new Laravel application key
if [ -z "$APP_KEY" ]; then
  echo "Generating Laravel APP_KEY..."
  php artisan key:generate --force
fi

# Execute the main container command (php-fpm)
exec "$@"
