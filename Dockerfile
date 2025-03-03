FROM --platform=$BUILDPLATFORM composer AS builder

COPY . /app

WORKDIR /app

RUN composer install --no-dev -o -n

FROM --platform=$BUILDPLATFORM node:alpine AS frontend-builder

COPY . /app

WORKDIR /app

RUN npm install && npm run build

FROM dunglas/frankenphp:alpine

ENV SUPERVISOR_PHP_COMMAND="php artisan octane:frankenphp"

RUN apk update \
    && apk add \
    tzdata \
    curl \
    nano \
    openssl \
    supervisor \
    mariadb-client \
    sqlite \
    iptables \
    iptables-legacy \
    wireguard-tools


RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS}
RUN pecl install pcov
RUN docker-php-ext-enable pcov

RUN install-php-extensions bcmath \
    intl \
    pcntl \
    zip \
    redis \
    exif \
    pdo_mysql \
    opcache \
    gd

RUN rm -rf /var/cache/apk/*

WORKDIR /app

COPY --from=builder /app /app

COPY --from=frontend-builder /app/public /app/public

COPY .docker/php.ini $PHP_INI_DIR

COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN echo '* * * * * cd /app && php artisan schedule:run >> /dev/null 2>&1' > /etc/crontabs/root

EXPOSE 8000 51820/udp

RUN chmod 755 .docker/docker-entrypoint.sh

ENTRYPOINT ["./.docker/docker-entrypoint.sh"]
