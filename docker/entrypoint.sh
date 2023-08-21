#!/bin/bash

cd /var/www/html

composer install

php artisan key:generate
php artisan migrate
php artisan db:seed

php artisan optimize:clear
php artisan optimize

service nginx start

php-fpm -F
