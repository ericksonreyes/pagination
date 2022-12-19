FROM ercbluemonday/php:8.1.13

WORKDIR /var/www/html

COPY . .

RUN mkdir -p build/logs/

RUN composer install

CMD [ "php", "vendor/bin/phing" ]