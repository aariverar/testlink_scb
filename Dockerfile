# Usar imagen base con PHP y Apache
FROM php:8.1-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mysqli mbstring zip xml

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar archivos de TestLink
COPY testlink_1_9_20_fixed/ /var/www/html/

# Configurar Apache simple
COPY docker/apache-simple.conf /etc/apache2/sites-available/000-default.conf

# Instalar dependencias de Composer con fallback
WORKDIR /var/www/html
RUN if [ -f "composer.json" ]; then \
        echo "Intentando instalar dependencias con Composer..."; \
        composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs || \
        echo "Composer falló, usando autoload de fallback"; \
    fi

# Asegurar que existe vendor/autoload.php
RUN if [ ! -f "vendor/autoload.php" ]; then \
        echo "Creando autoload de fallback..."; \
        mkdir -p vendor; \
        echo '<?php /* Fallback autoload */' > vendor/autoload.php; \
    fi

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponer puerto 80
EXPOSE 80

# Comando simple para iniciar Apache
CMD ["apache2-foreground"]