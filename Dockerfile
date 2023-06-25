FROM php:8.2-cli-alpine as developer
ARG DOCKER_HOST_IP=172.17.0.1
ARG IDE_KEY=app
ARG SERVER_NAME=app
ENV XDEBUG_CONFIG="idekey=${IDE_KEY} remote_enable=1 remote_host=${DOCKER_HOST_IP}"
ENV PHP_IDE_CONFIG="serverName=${SERVER_NAME}"
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
ADD https://github.com/eficode/wait-for/releases/latest/download/wait-for /usr/local/bin/
COPY docker/app/developer /usr/local/etc/php/
RUN chmod +x /usr/local/bin/install-php-extensions \
    && chmod +rx /usr/local/bin/wait-for \
    && install-php-extensions pdo_mysql opcache xdebug @composer
WORKDIR /app
CMD ["./docker/app/cmd.sh"]
EXPOSE 9000

FROM developer as builder
COPY ./ /app
RUN rm -rf /app/vendor \
    && composer install

FROM php:8.2-fpm as production
COPY --from=builder /app /app
COPY docker/app/production /usr/local/etc/
COPY docker/app/production /usr/local/etc/php/
RUN docker-php-ext-install pdo_mysql \
    && ln -s /app/cli.php /usr/local/bin/app

FROM production as migration
CMD ["app", "migrations:migrate", "-n", "--allow-no-migration"]

FROM nginx
COPY /public /app/public
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
