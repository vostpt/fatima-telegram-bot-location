# Docker File
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y git zip unzip \
    && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php \
    && docker-php-ext-install opcache \
    && pecl install mongodb apcu && docker-php-ext-enable mongodb apcu opcache

# Install Node.js

#RUN composer install
