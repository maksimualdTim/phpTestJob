FROM php:8.0-fpm
RUN apt-get update && apt-get install -y wget git unzip libpq-dev libicu-dev libpng-dev libzip-dev libjpeg-dev libfreetype6-dev \
        && docker-php-ext-install pdo_pgsql \
        && docker-php-ext-install pgsql \
        && docker-php-ext-install zip \
        && docker-php-ext-install gd \
        && docker-php-ext-enable pgsql
# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-interaction
COPY ./ ./
RUN chmod -R 775 /var/www/bootstrap
RUN chmod -R 775 /var/www/storage
RUN chown -R www-data:www-data /var/www