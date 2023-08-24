#!/bin/bash

cd /var/www/html/egg-recipe
docker-compose down
sudo fuser -n tcp -k 80