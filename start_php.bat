@echo off
echo ======================================
echo    INICIANDO PHP SERVER PARA TESTLINK
echo ======================================
echo.

REM Verificar si PHP ya está ejecutándose en el puerto 8080
netstat -an | find "127.0.0.1:8080" >nul
if "%ERRORLEVEL%"=="0" (
    echo PHP Server ya esta ejecutandose en puerto 8080
    echo.
    goto :show_access
)

REM Cambiar al directorio web de TestLink
cd /d "c:\testlink_complete_v2\testlink_1_9_20_fixed"

echo Iniciando servidor PHP en puerto 8080...
echo Directorio web: %CD%
echo.

REM Verificar que el directorio tiene los archivos de TestLink
if not exist "index.php" (
    echo ❌ Error: No se encontro index.php en el directorio actual
    echo Verifica que estes en el directorio correcto de TestLink
    echo.
    pause
    exit /b 1
)

echo ✅ Archivos de TestLink encontrados
echo.

REM Iniciar el servidor PHP
echo Iniciando servidor PHP Development Server...
echo.
echo IMPORTANTE: 
echo - No cierres esta ventana mientras uses TestLink
echo - Para detener el servidor, presiona Ctrl+C
echo.

"c:\testlink_complete_v2\php\php.exe" -S localhost:8080

echo.
echo ======================================
echo Servidor PHP detenido
echo ======================================
pause