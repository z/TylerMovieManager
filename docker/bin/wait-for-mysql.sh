#!/bin/bash

set -e

host="$1"
shift
cmd="$@"

until mysqladmin ping -h "$host" --silent; do
  >&2 echo "MySQL is unavailable - sleeping"
  sleep 1
done

>&2 echo "MySQL is up - executing command"

service php5-fpm start

(
    cd /var/www/tmm && \
    chmod -R o+w storage && \
    chmod -R o+w bootstrap/cache && \
    php artisan migrate && \
    php artisan db:seed && \
    php artisan cache:clear && \
    php artisan clear-compile && \
    npm install && \
    gulp
)

exec $cmd