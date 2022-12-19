FROM ercbluemonday/php-cli:8.1.13

WORKDIR /var/www/html

COPY . .

RUN composer install

ENTRYPOINT [ "php"]
