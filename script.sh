#!/bin/bash

php app/console cache:clear --env=prod
php app/console cache:clear --env=dev

chown -R root:www-data app/cache
chown -R root:www-data app/logs
chown -R root:www-data app/config/parameters.yml

chmod -R 775 app/cache
chmod -R 775 app/logs
chmod -R 775 app/config/parameters.yml