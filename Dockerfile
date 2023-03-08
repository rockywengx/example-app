FROM php:8.2-cli
COPY . /usr/src/example
WORKDIR /usr/src/example

# 安裝必要套件和擴展
RUN apt-get update && apt-get install -y \
    git \
    zip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libmcrypt-dev \
    libicu-dev \
    zlib1g-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    && docker-php-ext-install pdo_mysql mysqli mbstring exif pcntl bcmath gd soap zip intl

RUN apt-get install php-dev autoconf automake

# 安裝 xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# 安裝 Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]
