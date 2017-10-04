FROM php:7.1-fpm

LABEL maintainer "Daniel Ribeiro <drgomesp@gmail.com>"

RUN apt-get update \
	&& apt-get install -y \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql

RUN usermod -u 1000 www-data

CMD php-fpm -F

WORKDIR /app
