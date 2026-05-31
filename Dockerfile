FROM composer:2.7 AS composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --ignore-platform-reqs \
    --prefer-dist

COPY . .

RUN composer dump-autoload --optimize --no-dev --ignore-platform-reqs

FROM php:8.4-fpm-alpine

# ── System dependencies ───────────────────────────────────────────────────────
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    bash \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    autoconf \
    g++ \
    make \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache \
    # phpredis via PECL installieren
    # Warum PECL? phpredis ist keine offizielle PHP Extension
    # sondern eine Community Extension → muss separat installiert werden
    && pecl install redis \
    && docker-php-ext-enable redis \
    # Build Tools wieder entfernen → Image kleiner machen
    && apk del autoconf g++ make

# ── App files ─────────────────────────────────────────────────────────────────
WORKDIR /var/www/html

COPY --from=composer /app /var/www/html

# ── Permissions ───────────────────────────────────────────────────────────────
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# ── Supervisor config ─────────────────────────────────────────────────────────
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

# ── Entrypoint ────────────────────────────────────────────────────────────────
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
