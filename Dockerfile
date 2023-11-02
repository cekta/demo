FROM php:8.2-cli-alpine as developer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
COPY docker/app/developer /usr/local/etc/php/
RUN chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions pdo_mysql opcache xdebug @composer
WORKDIR /app
ENTRYPOINT ["./docker/app/entrypoint.sh"]
EXPOSE 9000

FROM developer as builder
COPY ./ /app
RUN rm -rf /app/vendor \
    && composer install

FROM php:8.2-fpm as production
COPY --from=builder /app /app
COPY docker/app/production /usr/local/etc/
COPY docker/app/production /usr/local/etc/php/
RUN docker-php-ext-install pdo_mysql opcache \
    && ln -s /app/cli.php /usr/local/bin/app
