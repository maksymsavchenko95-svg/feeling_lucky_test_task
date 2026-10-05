FROM composer:latest AS composer

FROM php:8.4-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
        libpq-dev \
        libonig-dev \
        libzip-dev \
        zip \
        unzip \
    && docker-php-ext-install \
        pdo_pgsql \
        pgsql \
        bcmath \
        zip \
    && pecl install xdebug  \
    && docker-php-ext-enable xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy Composer from the official Composer image
COPY --from=composer /usr/bin/composer /usr/local/bin/composer
COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY --chmod=755 docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]