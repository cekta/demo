FROM php:7.2-cli as developer
ARG DOCKER_HOST_IP=172.17.0.1
ARG IDE_KEY=app
ARG SERVER_NAME=app
ENV XDEBUG_CONFIG="idekey=${IDE_KEY} remote_enable=1 remote_host=${DOCKER_HOST_IP}"
ENV PHP_IDE_CONFIG="serverName=${SERVER_NAME}"
RUN apt-get update \
    && apt-get install -y git unzip wait-for-it \
    && pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_mysql \
    && curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet \
    && ln -s /app/cli.php /usr/local/bin/app
WORKDIR /app
CMD ["./cmd.sh"]
EXPOSE 9000

FROM php:7.2-fpm as production
COPY . /app/
WORKDIR /app
COPY production/php-fpm.conf /usr/local/etc/
COPY production/php.ini /usr/local/etc/php/
RUN apt-get update \
    && apt-get install -y git unzip wait-for-it \
    && docker-php-ext-install pdo_mysql \
    && curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet \
    && ln -s /app/cli.php /usr/local/bin/app \
    && rm -rf /app/vendor \
    && composer install

FROM production as migration
CMD ["app", "migrations:migrate", "-n", "--allow-no-migration"]

FROM nginx
COPY /public /app/public
COPY nginx.conf /etc/nginx/nginx.conf
