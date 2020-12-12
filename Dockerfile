FROM php:7.4-fpm
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libzip-dev \
        libpq-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql pdo_mysql zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN mkdir /app
COPY . /app
RUN chmod -R 775 /app/var/cache
RUN php /app/bin/console cache:clear
