FROM php:8.2-fpm-alpine as dev

WORKDIR /var/www/html

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]

FROM php:8.2-fpm-alpine as prod
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .
RUN composer install --optimize-autoloader --no-dev

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
