@echo off
echo ==========================================
echo    INICIANDO TESTLINK COMPLETO
echo    (MariaDB + PHP Server)
echo ==========================================
echo.

REM Cambiar al directorio base
cd /d "c:\testlink_complete_v2"

echo [1/3] Verificando MariaDB...
echo.

REM Verificar si MariaDB ya está ejecutándose
tasklist /FI "IMAGENAME eq mariadbd.exe" 2>NUL | find /I /N "mariadbd.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo ✅ MariaDB ya esta ejecutandose
) else (
    echo Iniciando MariaDB...
    cd /d "c:\testlink_complete_v2\mariadb\bin"
    start "MariaDB Server" /MIN mariadbd.exe --console
    timeout /t 3 /nobreak >nul
    echo ✅ MariaDB iniciado
)

echo.
echo [2/3] Verificando PHP Server...
echo.

REM Verificar si PHP ya está ejecutándose
netstat -an | find "127.0.0.1:8080" >nul
if "%ERRORLEVEL%"=="0" (
    echo ✅ PHP Server ya esta ejecutandose en puerto 8080
) else (
    echo Iniciando PHP Server en segundo plano...
    cd /d "c:\testlink_complete_v2\testlink_1_9_20_fixed"
    start "TestLink PHP Server" /MIN "c:\testlink_complete_v2\php\php.exe" -S localhost:8080
    timeout /t 2 /nobreak >nul
    echo ✅ PHP Server iniciado en puerto 8080
)

echo.
echo [3/3] Verificando servicios...
echo.

REM Verificar estado final
timeout /t 2 /nobreak >nul

echo ==========================================
echo    ✅ TESTLINK LISTO PARA USAR
echo ==========================================
echo.
echo 🌐 URL de acceso: http://localhost:8080
echo 🗄️  Base de datos: MariaDB (puerto 3306)
echo 👤 Usuario DB: root (sin password)
echo.
echo ==========================================
echo    COMANDOS ÚTILES:
echo ==========================================
echo.
echo Para detener servicios:
echo   stop_testlink.bat
echo.
echo Para verificar sistema:
echo   verify_system.bat
echo.
echo Para configurar DB (primera vez):
echo   setup_database.bat
echo.
echo Para ver procesos activos:
echo   tasklist | findstr "mariadbd\|php"
echo.
echo ==========================================

REM Preguntar si quiere abrir TestLink en el navegador
set /p open_browser="¿Abrir TestLink en el navegador? (s/n): "
if /i "%open_browser%"=="s" (
    echo.
    echo Abriendo TestLink en el navegador...
    start http://localhost:8080
)

echo.
echo Presiona cualquier tecla para salir...
pause >nul