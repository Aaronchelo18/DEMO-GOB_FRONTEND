@echo off
setlocal

cd /d "%~dp0"

echo Levantando DEMO-GOB frontend y backend con Docker...
docker compose up -d --build

echo.
echo Frontend: http://localhost:8080
echo Backend:  http://localhost:8081/api/health
echo.
pause

endlocal
