#!/bin/bash

sudo rm -rf /opt/codedeploy-agent/deployment-root/deployment-instructions/*
cd /var/www/html/egg-recipe
docker-compose down