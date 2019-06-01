FROM php:5.6-apache
COPY . /var/www/html/

RUN docker-php-ext-install mysql mysqli && \
    docker-php-ext-enable mysql mysqli
