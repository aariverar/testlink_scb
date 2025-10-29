@echo off
echo ======================================
echo    INICIANDO MARIADB PARA TESTLINK
echo ======================================
echo.

REM Cambiar al directorio de MariaDB
cd /d "c:\testlink_complete_v2\mariadb\bin"

REM Verificar si MariaDB ya está ejecutándose
tasklist /FI "IMAGENAME eq mariadbd.exe" 2>NUL | find /I /N "mariadbd.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo MariaDB ya esta ejecutandose.
    echo.
    goto :show_status
)

echo Iniciando servidor MariaDB...
echo.

REM Iniciar MariaDB en segundo plano
start "MariaDB Server" /MIN mariadbd.exe --console

REM Esperar unos segundos para que el servidor inicie
timeout /t 5 /nobreak >nul

:show_status
echo.
echo Verificando el estado de MariaDB...
echo.

REM Mostrar el estado de la base de datos
mariadb.exe -u root -e "SHOW DATABASES;" 2>nul
if "%ERRORLEVEL%"=="0" (
    echo.
    echo ✅ MariaDB se inicio correctamente
    echo ✅ Base de datos 'testlink' disponible
    echo.
    echo Puerto: 3306
    echo Usuario: root
    echo Password: (vacio)
) else (
    echo.
    echo ❌ Error al conectar con MariaDB
    echo Por favor, verifica que el servidor este ejecutandose
)

echo.
echo ======================================
echo Para detener MariaDB, usa:
echo taskkill /IM mariadbd.exe /F
echo ======================================
echo.
pause