# TestLink - Aseguramiento de Calidad SCB

Este proyecto es una implementación personalizada de TestLink 1.9.20 con branding de Banco Santander y compatibilidad con PHP 8.1.

[![TestLink](https://img.shields.io/badge/TestLink-1.9.20-blue)](http://testlink.org/)
[![PHP](https://img.shields.io/badge/PHP-8.1.33-purple)](https://php.net/)
[![MariaDB](https://img.shields.io/badge/MariaDB-Latest-orange)](https://mariadb.org/)
[![License](https://img.shields.io/badge/License-GPL-green)](LICENSE)

## 🚀 Características

- ✅ TestLink 1.9.20 [fixed] con branding personalizado "Aseguramiento de Calidad - SCB"
- ✅ Compatible con PHP 8.1.33
- ✅ Integración con MariaDB 10.x
- ✅ Logo de Banco Santander integrado
- ✅ Configuración de autenticación mejorada
- ✅ Dockerizado para fácil despliegue

## 📋 Contenido del Paquete

```
testlink_complete_v2/
├── 📁 mariadb/                   # Base de datos MariaDB portable
├── 📁 php/                       # Servidor PHP 8.1.33 portable  
├── 📁 testlink_1_9_20_fixed/     # Aplicación TestLink personalizada
├── 📁 docker/                    # Configuración Docker
├── 📁 .github/workflows/         # CI/CD GitHub Actions
├── 🐳 Dockerfile                 # Imagen de aplicación
├── 🐳 docker-compose.yml         # Orquestación completa
├── 🚀 start_testlink.bat         # Script principal (USAR ESTE)
├── 🛑 stop_testlink.bat          # Detener todos los servicios
├── ⚙️ start_mariadb.bat          # Solo MariaDB (opcional)
├── ⚙️ start_php.bat              # Solo PHP (opcional)
└── 📖 README.md                  # Este archivo
```

## 🏃‍♂️ Ejecución Rápida

### Opción 1: Windows Local (Método Tradicional)

#### 1️⃣ **Ejecutar TestLink**

```batch
# Doble clic en:
start_testlink.bat
```

**¡Eso es todo!** El script automáticamente:
- ✅ Verificará si MariaDB está ejecutándose
- ✅ Iniciará MariaDB si es necesario
- ✅ Verificará si PHP está ejecutándose  
- ✅ Iniciará el servidor PHP si es necesario
- ✅ Te mostrará la URL de acceso

#### 2️⃣ **Acceder a TestLink**

Cuando el script termine, abre tu navegador en:
```
🌐 http://localhost:8080
```

#### 3️⃣ **Detener TestLink**

```batch
# Doble clic en:
stop_testlink.bat
```

## 🔧 Configuración por Defecto

| Componente | Configuración |
|------------|---------------|
| **TestLink URL** | http://localhost:8080 |
| **Base de Datos** | MariaDB en puerto 3306 |
| **Usuario DB** | root |
| **Password DB** | *(vacío)* |
| **Base de Datos** | testlink |

## 📖 Primera Configuración

### Al ejecutar TestLink por primera vez:

1. **Instalar Base de Datos:**
   - Ve a: `http://localhost:8080/install/`
   - Sigue el wizard de instalación
   - Usa las credenciales de DB mencionadas arriba

2. **Crear Usuario Administrador:**
   - El wizard te pedirá crear un usuario admin
   - Guarda estas credenciales en un lugar seguro

3. **¡Listo para usar!** 🎉

## 🛠️ Scripts Incluidos

### `start_testlink.bat` ⭐ **Principal**
- Script inteligente que maneja todo automáticamente
- Verifica servicios existentes antes de iniciar
- Muestra información útil y comandos

### `start_mariadb.bat`
- Solo inicia MariaDB
- Útil para troubleshooting de base de datos
- Muestra estado de conexión

### `start_php.bat` 
- Solo inicia el servidor PHP
- Modo interactivo (mantener ventana abierta)
- Para desarrollo/debugging

### `stop_testlink.bat`
- Detiene TODOS los servicios de TestLink
- Limpieza completa de procesos
- Verificación de servicios restantes

## 🔍 Troubleshooting

### ❌ "Error al conectar con la base de datos"
```batch
# 1. Verificar que MariaDB esté ejecutándose:
tasklist | findstr mariadbd

# 2. Si no aparece, ejecutar:
start_mariadb.bat

# 3. Verificar conexión manual:
cd mariadb\bin
mariadb.exe -u root -e "SHOW DATABASES;"
```

### ❌ "No se puede acceder a localhost:8080"
```batch
# 1. Verificar que PHP esté ejecutándose:
netstat -an | find "8080"

# 2. Si no aparece, ejecutar:
start_php.bat

# 3. Verificar puerto no esté ocupado:
netstat -ano | find "8080"
```

### ❌ "Procesos siguen ejecutándose"
```batch
# Forzar cierre de todos los procesos:
taskkill /IM mariadbd.exe /F
taskkill /IM php.exe /F

# Verificar limpieza:
tasklist | findstr "mariadbd\|php"
```

## 📁 Archivos de Configuración Importantes

### `mariadb\my.ini`
- Configuración de MariaDB
- Puerto, charset, límites de memoria

### `php\php.ini`
- Configuración de PHP 8.1.33
- Extensiones habilitadas, límites de archivos
- OPcache habilitado para mejor rendimiento

### `testlink_1_9_20_fixed\custom_config.inc.php`
- Configuración de TestLink
- Conexión DB, rutas, seguridad

## 🔐 Consideraciones de Seguridad

⚠️ **IMPORTANTE:** Esta es una instalación de **desarrollo/testing local**

- **Apta para producción** con PHP 8.1 (versión moderna y segura)
- MariaDB sin password para `root` (solo desarrollo)
- PHP en modo development
- Accesible solo desde localhost (127.0.0.1)

### Para uso en producción:
1. Configurar password para MariaDB
2. Configurar SSL/HTTPS
3. Revisar configuraciones de seguridad
4. ✅ PHP 8.1 es apto para producción

## 🆘 Comandos Útiles

```batch
# Ver procesos de TestLink activos:
tasklist | findstr "mariadbd\|php"

# Ver puertos en uso:
netstat -ano | findstr "3306\|8080"

# Reiniciar todo:
stop_testlink.bat && start_testlink.bat

# Acceso directo a MariaDB:
cd mariadb\bin && mariadb.exe -u root

# Ver logs de PHP (si hay errores):
dir testlink_1_9_20_fixed\logs\
```

## 📞 Soporte y Ayuda

### Documentación Oficial:
- 📖 [TestLink Documentation](http://testlink.org/api/documentation.html)
- 🐛 [TestLink Forums](http://forum.testlink.org/)

### Logs para Debugging:
- **MariaDB:** Se ejecuta con `--console` (ver ventana)
- **PHP:** Logs en `testlink_1_9_20_fixed\logs\`
- **TestLink:** Configurado en `custom_config.inc.php`

## 🔄 Versiones

- **TestLink:** 1.9.20 [fixed]
- **PHP:** 8.1.33 (Modern & Secure)
- **MariaDB:** 10.x
- **SO Compatible:** Windows 7/8/10/11

---

## ✨ Mejoras con PHP 8.1

### 🚀 **Rendimiento Mejorado:**
- **OPcache habilitado** - Hasta 3x más rápido
- **JIT compilation** disponible
- **Mejor gestión de memoria**

### 🔒 **Seguridad Actualizada:**
- **Vulnerabilidades resueltas** de versiones anteriores
- **Algoritmos de hash modernos**
- **Soporte SSL/TLS actualizado**

### 🆕 **Características PHP 8.1:**
- **Mejor manejo de errores**
- **Sintaxis mejorada**
- **Compatibilidad con aplicaciones modernas**

---

## 🎯 ¿Cómo usar TestLink?

TestLink es una herramienta de **gestión de casos de prueba** que te permite:

1. **Crear Proyectos** de testing
2. **Diseñar Casos de Prueba** organizados
3. **Planificar Ejecuciones** de testing  
4. **Ejecutar Pruebas** y registrar resultados
5. **Generar Reportes** de cobertura y resultados

### Flujo típico:
```
Proyecto → Casos de Prueba → Plan de Pruebas → Ejecución → Reportes
```

---

**¡Feliz Testing!** 🧪✨