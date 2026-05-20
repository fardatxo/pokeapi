FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpq-dev libzip-dev libpng-dev libjpeg-dev \
    libfreetype6-dev libicu-dev libxml2-dev libonig-dev \
    && docker-php-ext-install \
        pdo pdo_pgsql pdo_mysql \
        zip bcmath intl mbstring xml \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-scripts \
    && composer dump-autoload --optimize \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD php artisan config:clear && \
    php artisan package:discover --ansi && \
    php artisan migrate --force && \
    php -S 0.0.0.0:${PORT:-8000} -t public
