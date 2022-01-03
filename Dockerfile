#

# PHP Dependencies

#

FROM composer as build1
COPY . .

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

#####################################################################

#

# Frontend

#

FROM node as build2

ARG APP_ENV

RUN mkdir -p /app
WORKDIR /app

COPY --from=build1 /app .

RUN npm install && \
    if [ -n "$APP_ENV" ] && [ "$APP_ENV" != 'production' ]; then \
    npm run dev; else npm run prod; fi

#####################################################################

FROM php:7.4-fpm

ARG APP_ENV

RUN apt-get update && apt-get install -y netcat \
    && apt-get install -y libzip-dev zip \
	&& docker-php-ext-install zip mysqli pdo pdo_mysql \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --from=build2 --chown=www-data /app .

RUN if [ -n "$APP_ENV" ] && [ "$APP_ENV" != 'production' ]; then \
    mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && mv docker/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && mv docker/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini; fi

RUN mv docker/entrypoint.sh / && \
    rm -r docker

EXPOSE 9000
USER "www-data:www-data"
ENTRYPOINT ["/bin/sh", "/entrypoint.sh"]