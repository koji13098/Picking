# Heroku デプロイ用

FROM php:8-apache

RUN apt-get update \
  && apt-get install -y libonig-dev unzip \
  && docker-php-ext-install pdo_mysql mysqli

COPY --from=composer/composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ./src /var/www/html
COPY ./docker/app/php.ini /usr/local/etc/php/php.ini

COPY ./docker/app/run-apache2.sh /usr/local/bin/
CMD [ "run-apache2.sh" ]
