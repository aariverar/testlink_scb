@echo off
echo ==========================================
echo    DETENIENDO SERVICIOS DE TESTLINK
echo ==========================================
echo.

echo Deteniendo servidor PHP...
taskkill /IM php.exe /F >nul 2>&1
if "%ERRORLEVEL%"=="0" (
    echo ✅ Servidor PHP detenido
) else (
    echo ℹ️  Servidor PHP no estaba ejecutandose
)

echo.
echo Deteniendo MariaDB...
taskkill /IM mariadbd.exe /F >nul 2>&1
if "%ERRORLEVEL%"=="0" (
    echo ✅ MariaDB detenido
) else (
    echo ℹ️  MariaDB no estaba ejecutandose
)

echo.
echo ==========================================
echo    ✅ TODOS LOS SERVICIOS DETENIDOS
echo ==========================================
echo.

REM Verificar que no quedan procesos
echo Verificando procesos restantes...
tasklist | findstr "mariadbd\|php" >nul 2>&1
if "%ERRORLEVEL%"=="0" (
    echo.
    echo ⚠️  Algunos procesos aún están ejecutándose:
    tasklist | findstr "mariadbd\|php"
    echo.
    echo Si persisten, reinicia el sistema.
) else (
    echo ✅ No hay procesos de TestLink ejecutándose
)

echo.
pause