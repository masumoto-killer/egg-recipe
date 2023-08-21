#!/bin/bash

cd /var/www/html

composer install

php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan optimize:clear
php artisan optimize
php artisan config:clear
php artisan cache:clear
composer dump-autoload
php artisan view:clear
php artisan route:clear

service nginx start

php-fpm -F
