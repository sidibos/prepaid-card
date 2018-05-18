# Dockerfile
FROM php:7.1-apache

#RUN docker-php-ext-install pdo_mysql
#RUN a2enmod rewrite

RUN docker-php-ext-install mysqli pdo_mysql \
    && chown -R www-data:www-data /var/www \
    && a2enmod rewrite

WORKDIR /var/www
COPY . /var/www
COPY ./public /var/www/html
COPY ./public/.htaccess /var/www/html/

