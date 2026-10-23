FROM php:8.2-apache

# Install ekstensi MySQLi 
RUN docker-php-ext-install mysqli

# Aktifkan modul rewrite Apache
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Berikan izin
RUN chown -R www-data:www-data /var/www/html
