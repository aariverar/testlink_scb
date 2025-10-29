# Usar imagen base con PHP y Apache
FROM php:8.1-apache

# Instalar extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    mariadb-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mysqli mbstring zip xml

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar archivos de TestLink
COPY testlink_1_9_20_fixed/ /var/www/html/

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configurar Apache para TestLink
COPY docker/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Copiar script de inicio
COPY start-railway.sh /usr/local/bin/start-railway.sh
RUN chmod +x /usr/local/bin/start-railway.sh

# Configurar ServerName para evitar warnings
RUN echo "ServerName testlink-scb" >> /etc/apache2/apache2.conf

# Variables de entorno para Railway
ENV APACHE_DOCUMENT_ROOT=/var/www/html
ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data
ENV APACHE_LOG_DIR=/var/log/apache2

# Exponer puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["/usr/local/bin/start-railway.sh"]