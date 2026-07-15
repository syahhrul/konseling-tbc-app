FROM php:8.2-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    nginx \
    curl \
    nodejs \
    npm \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    oniguruma-dev \
    sqlite-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy files
COPY . .

# Install PHP & NPM dependencies, then compile assets
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build

# Nginx config
RUN mkdir -p /run/nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Create SQLite database file if it doesn't exist
RUN mkdir -p database \
    && touch database/database.sqlite

# Permissions
RUN chmod -R 777 storage bootstrap/cache database

# Expose port
EXPOSE 80

# Start command
CMD php artisan migrate --force && php artisan db:seed --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php-fpm -D && nginx -g "daemon off;"
