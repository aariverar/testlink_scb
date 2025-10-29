#!/bin/bash

# Script de inicio para Railway
# Asegurar que Apache se inicie correctamente

echo "🚀 Iniciando TestLink en Railway..."

# Verificar configuración de Apache
echo "📋 Verificando configuración..."
apache2ctl configtest

# Mostrar información del sistema
echo "🔍 Información del sistema:"
echo "PHP Version: $(php -v | head -n 1)"
echo "Apache Version: $(apache2 -v | head -n 1)"
echo "Puerto configurado: ${PORT:-80}"

# Iniciar Apache en primer plano
echo "🌐 Iniciando Apache..."
exec apache2-foreground