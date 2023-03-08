# EXAMPLE API

# 環境
Php 8.2 
Laravel 10
Vite

# 建構(docker)
```
    //start
    docker-compose up
    //stop
    docker-compose down 
```

# 建構(linux)
```
    sudo apt-get update && apt-get install -y \
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

    //安裝 xdebug
    sudo pecl install xdebug \
        && docker-php-ext-enable xdebug

    //安裝 Composer
    sudo curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
```

# 運行
```
    //命令提示字元
    php artisan serve
```

# 測試
```
    //命令提示字元
    php artisan test
```

