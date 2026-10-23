FROM php:8.2-apache

# Install ekstensi MySQLi untuk koneksi database (cara dasar)
RUN docker-php-ext-install mysqli

# Aktifkan modul rewrite Apache (opsional, berguna untuk routing jika dibutuhkan)
RUN a2enmod rewrite

# Atur working directory di root dokumen Apache
WORKDIR /var/www/html

# Berikan izin yang tepat untuk direktori web
RUN chown -R www-data:www-data /var/www/html
