FROM php:8.1-fpm-alpine as base

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN apk --update upgrade \
    && docker-php-ext-install sockets \
    && rm -rf /var/cache/apk && mkdir -p /var/cache/apk

FROM base as dev

WORKDIR /var/www/html

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]

FROM base as prod
COPY . .
RUN composer install --optimize-autoloader --no-dev

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
