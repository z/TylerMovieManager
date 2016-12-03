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
    php artisan migrate && \
    npm install && \
    gulp
)

exec $cmd