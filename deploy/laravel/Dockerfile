# Gunakan image PHP versi 8.2 dengan Apache terintegrasi
FROM php:8.2-apache

# 1. Instal dependensi sistem yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# 2. Bersihkan cache instalasi untuk memperkecil ukuran image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Instal ekstensi PHP yang diwajibkan Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 4. Aktifkan modul mod_rewrite Apache (WAJIB untuk routing Laravel)
RUN a2enmod rewrite

# 5. Konfigurasi Apache agar menggunakan APACHE_DOCUMENT_ROOT dari docker-compose
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6. Dapatkan Composer terbaru secara resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Set direktori kerja default ke folder aplikasi
WORKDIR /var/www/html