FROM php:8.1-fpm-alpine

COPY . /var/www/html
WORKDIR /var/www/html

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql mysqli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENTRYPOINT ["php-fpm", "-c", "/usr/local/etc/php/php_no_errors.ini"]
EXPOSE 9000
