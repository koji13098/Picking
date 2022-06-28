FROM php:8-apache

RUN apt-get update \
  && apt-get install -y libonig-dev \
  && docker-php-ext-install pdo_mysql mysqli

WORKDIR /var/www/html

COPY ./src /var/www/html
COPY ./docker/app/php.ini /usr/local/etc/php/php.ini
