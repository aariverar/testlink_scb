#!/bin/bash

echo "=== TestLink Setup Script para Railway ==="
echo "Configurando directorios y permisos..."

# Crear directorios necesarios
echo "Creando directorios..."
mkdir -p /var/testlink/logs
mkdir -p /var/testlink/upload_area
mkdir -p /var/www/html/gui/templates_c
mkdir -p /var/www/html/logs
mkdir -p /var/www/html/upload_area

# Configurar permisos
echo "Configurando permisos..."
chmod 777 /var/testlink/logs
chmod 777 /var/testlink/upload_area
chmod 777 /var/www/html/gui/templates_c
chmod 777 /var/www/html/logs
chmod 777 /var/www/html/upload_area

# Cambiar propietario
echo "Configurando propietario..."
chown -R www-data:www-data /var/testlink/
chown -R www-data:www-data /var/www/html/gui/templates_c
chown -R www-data:www-data /var/www/html/logs
chown -R www-data:www-data /var/www/html/upload_area

# Verificar directorios
echo "=== Verificación de Directorios ==="
for dir in "/var/testlink/logs" "/var/testlink/upload_area" "/var/www/html/gui/templates_c" "/var/www/html/logs" "/var/www/html/upload_area"; do
    if [ -d "$dir" ]; then
        echo "✓ $dir - Creado correctamente"
        ls -la "$dir" 2>/dev/null || echo "  (directorio vacío)"
    else
        echo "✗ $dir - FALLO al crear"
    fi
done

# Mostrar información de base de datos (sin contraseñas)
echo "=== Configuración de Base de Datos ==="
echo "DATABASE_URL configurado: $([ -n "$DATABASE_URL" ] && echo "SÍ" || echo "NO")"
echo "DB_HOST: ${DB_HOST:-"No configurado"}"
echo "DB_USER: ${DB_USER:-"No configurado"}"
echo "DB_NAME: ${DB_NAME:-"No configurado"}"
echo "DB_PORT: ${DB_PORT:-"No configurado"}"

# Información del entorno
echo "=== Información del Entorno ==="
echo "PHP Version: $(php --version | head -n 1)"
echo "Usuario actual: $(whoami)"
echo "Directorio actual: $(pwd)"

# Verificar módulos de PHP
echo "=== Módulos PHP Disponibles ==="
php -m | grep -E "(mysql|mysqli|pdo)" || echo "⚠️  Módulos de base de datos no encontrados"

echo "=== Iniciando Apache ==="
# Iniciar Apache
apache2-foreground