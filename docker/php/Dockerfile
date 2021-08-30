FROM php:8.0-fpm


WORKDIR /var/www


RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    nano \
    curl \
    libonig-dev libpq-dev \
    libzip-dev \
    bash \
    openssl libssl-dev \
    supervisor


RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./supervisor.conf /etc/supervisor/conf.d/supervisor.conf
COPY ./run_queue.sh /usr/bin/run_queue.sh
RUN chmod +x /usr/bin/run_queue.sh

EXPOSE 9000
CMD ["php-fpm"]
