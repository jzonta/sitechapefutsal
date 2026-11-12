# syntax=docker/dockerfile:1

# ---------- base: PHP-FPM + extensões ----------
FROM php:8.4-fpm-alpine AS base
COPY --from=ghcr.io/mlocati/php-extension-installer:latest /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql gd intl zip bcmath opcache exif pcntl \
    && apk add --no-cache git unzip
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-app.ini
WORKDIR /var/www/html

# ---------- dev: código montado por volume, usuário = UID/GID do host ----------
FROM base AS dev
ARG UID=1000
ARG GID=1000
RUN apk add --no-cache shadow \
    && (getent group $GID >/dev/null || addgroup -g $GID app) \
    && adduser -D -u $UID -G $(getent group $GID | cut -d: -f1) app \
    && sed -i 's/^user = .*/user = app/; s/^group = .*/group = '"$(getent group $GID | cut -d: -f1)"'/' /usr/local/etc/php-fpm.d/www.conf
USER app

# ---------- assets: build do Vite/Tailwind ----------
FROM node:22-alpine AS assets
WORKDIR /app
COPY app/package*.json ./
RUN npm ci
COPY app/ ./
RUN npm run build

# ---------- vendor: dependências de produção ----------
FROM base AS vendor
COPY app/composer.* ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist
COPY app/ ./
RUN composer dump-autoload --no-dev --optimize

# ---------- prod ----------
FROM base AS prod
ENV APP_ENV=production APP_DEBUG=false
COPY --from=vendor /var/www/html /var/www/html
COPY --from=assets /app/public/build /var/www/html/public/build
RUN chown -R www-data:www-data storage bootstrap/cache
