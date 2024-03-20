FROM php:8.1-cli

RUN apt-get update && \
    apt-get install -y \
    postgresql-client \
    git \
    unzip \
    libpq-dev \
    libc-client-dev \
    libkrb5-dev

RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl && \
    docker-php-ext-install imap

COPY init.sql /docker-entrypoint-initdb.d/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . .

RUN composer install --no-scripts --no-autoloader

RUN composer dump-autoload

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
