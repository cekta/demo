FROM php:7.2-fpm as developer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN apt-get update \
    && pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug \
    && curl -s https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer --quiet
WORKDIR /app
ENTRYPOINT ["./entrypoint.sh"]
