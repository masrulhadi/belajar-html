FROM php:8.2-apache

# Install ekstensi PDO MySQL untuk koneksi database
RUN docker-php-ext-install pdo pdo_mysql

# Aktifkan modul rewrite Apache (opsional, berguna untuk routing jika dibutuhkan)
RUN a2enmod rewrite

# Atur working directory di root dokumen Apache
WORKDIR /var/www/html

# Berikan izin yang tepat untuk direktori web
RUN chown -R www-data:www-data /var/www/html
