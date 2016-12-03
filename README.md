# TylerMovieManager

A movie management application using a REST API built with Laravel.

## Dependencies

* [docker](https://docs.docker.com/engine/installation/)
* [docker-compose](https://docs.docker.com/compose/install/)

## Installation

For development, nginx expects the domain `tmm.8ed.local`, add that to `/etc/hosts/`:

```
sudo echo "127.0.0.1 tmm.8ed.local" >> /etc/hosts
```

An `.env` file is also required to set up environment variables.
 
```
cp src/.env.local src/.env
```

Generate oauth keys:

```
php artisan passport:install
```

## Usage

The stack runs in docker, which can be started with:

```
docker-compose up
```

This setups a database, and an nginx + php5-fpm container to serve the Laravel project located in `src`. 

Visit [http://tmm.8ed.local](http://tmm.8ed.local) in your web browser and create a new user.

## Developer Notes

```bash
# dockerized composer
alias composer='docker run -it --rm --net=host -v $HOME:$HOME -e COMPOSER_HOME="$HOME/.composer" -u $UID -w `pwd` composer/composer:master-php5-alpine'
```

The `src` base was generated with composer:

```bash
cd src
composer create-project --prefer-dist laravel/laravel .
```

Permissions on directories:

```
chown -R $USER:$USER .
chmod -R o+w bootstrap/cache
chmod -R o+w storage
```

## License

Copyright (c) 2016 Tyler Mulligan (z@xnz.me) and contributors.

Distributed under the MIT license. See the LICENSE file for more details.
