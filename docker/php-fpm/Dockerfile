FROM php:8.1-fpm

ARG user
ARG uid

RUN apt update && apt install -y \
    git \
    curl \
    libpng-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libmagickwand-dev

RUN docker-php-ext-install pdo pdo_pgsql gd zip bcmath
RUN pecl install redis imagick && docker-php-ext-enable redis imagick

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/fumo/ $user
RUN mkdir -p /home/fumo/.composer && \
    chown -R $user:$user /home/fumo

USER $user
