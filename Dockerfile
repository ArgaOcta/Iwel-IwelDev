FROM php:8.2-fpm

ENV DEBIAN_FRONTEND=noninteractive

WORKDIR /var/www/html

# Install dependencies dengan apt-get clean untuk mengecilkan ukuran image
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Gunakan multi-stage build untuk hasil lebih ringan
FROM node:20 AS build-frontend
WORKDIR /var/www/html
COPY . .
RUN npm install && npm run build

FROM php:8.2-fpm
# (Sisa perintah instalasi PHP sama seperti sebelumnya...)
WORKDIR /var/www/html
COPY . .

# Copy hasil build dari stage pertama
COPY --from=build-frontend /var/www/html/public/build /var/www/html/public/build

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy aplikasi
COPY . .

# Install PHP dependencies (Tanpa scripts untuk menghindari koneksi DB saat build)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-scripts

# Set permissions awal
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 9000
CMD ["php-fpm"]