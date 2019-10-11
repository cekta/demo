FROM php:7.2-fpm as developer

ARG DOCKER_HOST_IP=172.17.0.1
ARG IDE_KEY=app
ARG SERVER_NAME=app
ARG UID=1000
ARG GID=1000

ENV XDEBUG_CONFIG="idekey=${IDE_KEY} remote_enable=1 remote_host=${DOCKER_HOST_IP}"
ENV PHP_IDE_CONFIG="serverName=${SERVER_NAME}"
RUN apt-get update \
    && apt-get install -y git unzip \
    && pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug \
    && curl -s https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer --quiet \
    && groupadd -fr -g ${GID} app \
    && useradd -rm -g ${GID} -u ${UID} app
COPY developer/php-fpm.conf /usr/local/etc/
COPY developer/php.ini /usr/local/etc/php/

USER app
WORKDIR /app
CMD ["./entrypoint.sh"]
EXPOSE 9000

FROM developer as builder
COPY --chown=app ./ /app
RUN rm -rf /app/vendor \
    && composer install

FROM php:7.2-fpm as production
COPY --from=builder /app /app
COPY production/php-fpm.conf /usr/local/etc/
COPY production/php.ini /usr/local/etc/php/
WORKDIR /app/public
