# Stage 1: Build Frontend
FROM node:20 AS build-frontend
WORKDIR /var/www/html
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Final Image (PHP-FPM)
FROM php:8.2-fpm

# Set environment
ENV DEBIAN_FRONTEND=noninteractive

# Use /var/app as internal source; /var/www/html is the shared volume mountpoint
WORKDIR /var/app

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy source code
COPY . .

# Copy built frontend assets from Stage 1
COPY --from=build-frontend /var/www/html/public/build /var/app/public/build

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-scripts

# Create the shared volume mountpoint directory with correct ownership
RUN mkdir -p /var/www/html && chown -R www-data:www-data /var/www/html

# Set permissions on the app source
RUN chown -R www-data:www-data /var/app/storage /var/app/bootstrap/cache /var/app/public

# Copy and prepare entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["php-fpm"]