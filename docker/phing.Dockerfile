FROM php:8.1.7-cli-alpine

RUN apk update && apk add curl git wget ncurses

RUN apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS

RUN pecl update-channels

RUN docker-php-ext-install bcmath sockets opcache && docker-php-ext-enable opcache && pecl install apcu && docker-php-ext-enable apcu && pecl install pcov && docker-php-ext-enable pcov

RUN mkdir /var/log/php && chown -R www-data:www-data /var/log/php

WORKDIR /usr/local/etc/php/conf.d/

COPY docker/config/php/php.ini .

WORKDIR /tmp

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

RUN php composer-setup.php

RUN php -r "unlink('composer-setup.php');"

RUN mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

COPY . .

RUN mkdir -p build/logs/

RUN composer install

CMD [ "php", "vendor/bin/phing" ]