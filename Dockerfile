##########################################
# Dockerfile to build PHP AVS images     #
# Based on Alpine                        #
##########################################

# Build a small image
FROM php:7.2-fpm-alpine3.7

# Create User with id 1000, must be same between Host and Container
RUN addgroup -g 1000 -S app
RUN adduser -u 1000 -S -D -G app app

RUN set -xe \
  && apk add --update --no-cache \
  postgresql-dev \
  freetype-dev \
  libjpeg-turbo-dev \
  libpng-dev \
  libwebp-dev

RUN docker-php-ext-install pdo pdo_pgsql exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd pgsql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer