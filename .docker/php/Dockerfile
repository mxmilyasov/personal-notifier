FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    libonig-dev \
    unzip

# Clean up to reduce image size
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
# Each one serves specific purpose:
RUN docker-php-ext-install \
    mbstring \
    pdo_mysql \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip \
    opcache

# Redis for caching/sessions
RUN pecl install redis && docker-php-ext-enable redis

# Xdebug for debugging - REMOVE IN PRODUCTION!
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Add our PHP config
COPY ./.docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Get Composer (PHP package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

# Set working directory
WORKDIR /var/www/app
