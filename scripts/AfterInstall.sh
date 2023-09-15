#!/bin/bash

cp /var/www/html/.env /var/www/html/egg-recipe/.env

cd /var/www/html/egg-recipe

docker-compose exec -it egg-recipe /usr/local/bin/php /var/www/html/artisan optimize:clear
docker-compose exec -it egg-recipe /usr/local/bin/php /var/www/html/artisan optimize
