FROM php:8.2-fpm-alpine as dev

WORKDIR /var/www/html

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]

FROM php:8.2-fpm-alpine as build
WORKDIR /var/www/html
COPY . .
RUN curl -sS https://getcomposer.org/installer | php -- \
  --install-dir=/usr/bin --filename=composer

RUN composer install --no-dev

FROM php:8.2-fpm-alpine as prod
COPY --chown=node:node --from=build /var/www/html/vendor /var/www/html/vendor
COPY . .

CMD ["tail", "-f", "/dev/null"]
