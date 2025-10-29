#!/bin/bash

# Script de inicio para Railway
# Asegurar que Apache se inicie correctamente

echo "🚀 Iniciando TestLink en Railway..."
echo "📅 Timestamp: $(date)"

# Verificar que los archivos estén en su lugar
echo "📁 Verificando archivos..."
if [ -f "/var/www/html/index.php" ]; then
    echo "✅ TestLink files found"
else
    echo "❌ TestLink files missing"
    ls -la /var/www/html/ | head -10
fi

if [ -f "/var/www/html/health.php" ]; then
    echo "✅ Health check file found"
else
    echo "❌ Health check file missing"
fi

# Verificar configuración de Apache
echo "📋 Verificando configuración Apache..."
apache2ctl configtest
if [ $? -eq 0 ]; then
    echo "✅ Apache configuration OK"
else
    echo "❌ Apache configuration has issues"
fi

# Mostrar información del sistema
echo "🔍 Información del sistema:"
echo "PHP Version: $(php -v | head -n 1)"
echo "Apache Version: $(apache2 -v | head -n 1)"
echo "Puerto configurado: ${PORT:-80}"
echo "Document Root: ${APACHE_DOCUMENT_ROOT:-/var/www/html}"

# Verificar extensiones PHP
echo "🔧 Extensiones PHP:"
php -m | grep -E "(gd|mysql|mbstring|zip)" | head -5

# Configurar permisos antes de iniciar
echo "🔒 Configurando permisos..."
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html

# Iniciar Apache en segundo plano para test
echo "🧪 Iniciando Apache en modo test..."
apache2ctl start

# Esperar un momento
sleep 3

# Verificar que Apache esté ejecutándose
if pgrep apache2 > /dev/null; then
    echo "✅ Apache started successfully"
    
    # Test del healthcheck
    echo "🩺 Testing healthcheck..."
    curl -s http://localhost/health.php | head -3 || echo "Healthcheck test failed"
    
    # Detener Apache para reiniciar en foreground
    apache2ctl stop
    sleep 2
else
    echo "❌ Apache failed to start"
fi

# Iniciar Apache en primer plano (para Railway)
echo "🌐 Iniciando Apache en primer plano..."
exec apache2-foreground