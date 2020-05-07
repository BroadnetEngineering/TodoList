FROM php:7.4-fpm

RUN apt-get update -q -y \
    && apt-get install -q -y --no-install-recommends \
        ca-certificates \
        curl \
        acl \
        sudo \
# git & unzip needed for composer, unless we document to use dev image for composer install
# unzip needed due to https://github.com/composer/composer/issues/4471
        unzip \
        git \
    && rm -rf /var/lib/apt/lists/*

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer