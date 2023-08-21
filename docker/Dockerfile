FROM php:8.2-fpm

RUN apt update && apt install -y unzip nginx && docker-php-ext-install pdo_mysql

RUN curl -o /usr/local/bin/composer https://getcomposer.org/download/2.5.8/composer.phar
RUN chmod +x /usr/local/bin/composer

COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT [ "/entrypoint.sh" ]