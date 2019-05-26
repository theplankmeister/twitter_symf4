FROM php:7.2.12-fpm-alpine3.8

ARG COMPOSER_HASH

RUN apk update && apk upgrade

RUN apk update \
    && apk add --no-cache util-linux make php7-dev mariadb-client php7-pdo_mysql \
    && rm -rf /tmp/*

RUN cp /usr/lib/php7/modules/*.so /usr/local/lib/php/extensions/no-debug-non-zts-20170718 \
    && cp /etc/php7/conf.d/02_pdo_mysql.ini /usr/local/etc/php/conf.d/

COPY ./t /usr/bin/
RUN ["chmod", "+x", "/usr/bin/t"]

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '${COMPOSER_HASH:-93b54496392c062774670ac18b134c3b3a95e5a5e5c8f1a9f115f203b75bf9a129d5daa8ba6a13e2cc8a1da0806388a8}') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
