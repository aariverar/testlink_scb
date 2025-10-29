# Configuración de Base de Datos para TestLink

# Script SQL de inicialización para MariaDB
# Este archivo se ejecuta automáticamente cuando se crea el contenedor

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS testlink CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE testlink;

-- Crear usuario específico para TestLink (si no existe)
CREATE USER IF NOT EXISTS 'testlink_user'@'%' IDENTIFIED BY 'testlink_pass';

-- Otorgar permisos completos al usuario
GRANT ALL PRIVILEGES ON testlink.* TO 'testlink_user'@'%';

-- Aplicar permisos
FLUSH PRIVILEGES;

-- Configuraciones adicionales para TestLink
SET GLOBAL max_allowed_packet = 64*1024*1024;
SET GLOBAL innodb_file_per_table = ON;
SET GLOBAL innodb_file_format = Barracuda;

-- Mostrar información de la base de datos
SELECT 'Base de datos TestLink configurada correctamente' AS status;