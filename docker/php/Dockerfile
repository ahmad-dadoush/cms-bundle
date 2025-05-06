# docker/php/Dockerfile
FROM php:8.2-fpm

# Install system deps and PHP extensions
RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        zip \
        curl \
    && docker-php-ext-install \
        intl \
        pdo_mysql \
        zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js & Yarn (for Webpack Encore)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install --global yarn

WORKDIR /srv/app

# Copy entrypoint script (optional) then clear cache
COPY --chown=www-data:www-data . /srv/app

# Ensure files/folders are writable
RUN mkdir -p var/cache var/log \
    && chown -R www-data:www-data var

# Use the default command
CMD ["php-fpm"]