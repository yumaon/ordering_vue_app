FROM php:8.2-fpm

# システムパッケージの更新と必要なパッケージのインストール
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev

# PHP 拡張モジュールのインストール
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer のインストール
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

# プロジェクトのファイルをコンテナにコピー
COPY . /var/www/ordering_vue_app

# 作業ディレクトリの設定
WORKDIR /var/www/ordering_vue_app

# Composer install (プロジェクトの依存関係をインストール)
#RUN composer install

# ファイルの権限設定（必要に応じて）
RUN chown -R www-data:www-data /var/www

USER www-data