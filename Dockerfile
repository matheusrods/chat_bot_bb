FROM php:8.2-fpm
WORKDIR /var/www/html
COPY . /var/www/html
EXPOSE 9000
CMD ["php-fpm"]
