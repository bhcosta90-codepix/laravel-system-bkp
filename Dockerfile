FROM php:8.2-fpm-alpine as dev

WORKDIR /var/www/html

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
