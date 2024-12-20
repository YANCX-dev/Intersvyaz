FROM phpdockerio/php:8.2-fpm
WORKDIR "/application"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        php8.2-pdo-sqlite\
        php8.2-sqlite3 \
        php8.2-gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY . /application

RUN mkdir -p /application/storage && chmod -R 775 /application/storage && chown -R www-data:www-data /application/storage

