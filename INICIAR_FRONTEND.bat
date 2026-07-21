@echo off
setlocal

cd /d "%~dp0"

set "PHP_EXE="
for /f "delims=" %%P in ('where php 2^>nul') do (
    if not defined PHP_EXE set "PHP_EXE=%%P"
)

if not defined PHP_EXE (
    for /f "delims=" %%P in ('dir /b /s "%LOCALAPPDATA%\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" 2^>nul') do (
        if not defined PHP_EXE set "PHP_EXE=%%P"
    )
)

if not defined PHP_EXE (
    echo.
    echo No se encontro PHP en el PATH.
    echo.
    echo Instala PHP o XAMPP/Laragon y luego vuelve a ejecutar este archivo.
    echo Comando esperado:
    echo   php -S 127.0.0.1:8080
    echo.
    pause
    exit /b 1
)

echo Levantando SISCAT Demo en http://127.0.0.1:8080
echo Presiona Ctrl+C para detener el servidor.
"%PHP_EXE%" -S 127.0.0.1:8080 -t "%~dp0"

endlocal
