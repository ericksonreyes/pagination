FROM ercbluemonday/php:8.1.13

WORKDIR /var/www/html

COPY . .

RUN composer install

ENTRYPOINT [ "php"]
