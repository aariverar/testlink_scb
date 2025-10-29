#!/bin/bash

# Script de setup para TestLink en Railway
echo "🔧 Configurando TestLink para Railway..."

# Crear directorios necesarios
echo "📁 Creando directorios..."
mkdir -p /var/www/html/gui/templates_c
mkdir -p /var/www/html/logs  
mkdir -p /var/www/html/upload_area
mkdir -p /var/testlink/logs
mkdir -p /var/testlink/upload_area

# Configurar permisos
echo "🔒 Configurando permisos..."
chmod -R 777 /var/www/html/gui/templates_c
chmod -R 777 /var/www/html/logs
chmod -R 777 /var/www/html/upload_area
chmod -R 777 /var/testlink/logs 2>/dev/null || true
chmod -R 777 /var/testlink/upload_area 2>/dev/null || true

# Cambiar propietario
chown -R www-data:www-data /var/www/html
chown -R www-data:www-data /var/testlink 2>/dev/null || true

# Verificar que los directorios existen
echo "✅ Verificando directorios:"
ls -la /var/www/html/gui/templates_c/ && echo "templates_c: OK" || echo "templates_c: FAIL"
ls -la /var/www/html/logs/ && echo "logs: OK" || echo "logs: FAIL"  
ls -la /var/www/html/upload_area/ && echo "upload_area: OK" || echo "upload_area: FAIL"

echo "🚀 Setup completado. Iniciando Apache..."

# Iniciar Apache
exec apache2-foreground