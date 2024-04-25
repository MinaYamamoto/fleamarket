FROM php:8.0-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
    && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

RUN apt-get update \
    && apt-get install -y zlib1g-dev libpng-dev libjpeg62-turbo-dev libwebp-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get update && apt-get install -y libjpeg-dev libpng-dev

RUN apt-get update \
    && apt-get install -y \
    libmagickwand-dev imagemagick \
    && pecl install imagick \
    && docker-php-ext-enable imagick

RUN apt-get update \
    && apt-get install -y --fix-missing npm

WORKDIR /var/www