FROM php:8.2-apache

LABEL version="1.0"

RUN apt-get update \
    && apt-get install -y libonig-dev libzip-dev redis-tools \
    && pecl install xdebug redis \
    && docker-php-ext-install pdo_mysql mysqli mbstring zip \
    && docker-php-ext-enable xdebug redis \
    && a2enmod rewrite

COPY ../../../example-app-2/src /var/www/html/
