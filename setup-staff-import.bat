@echo off
REM ========================================
REM Staff Import Feature - XAMPP Setup Script
REM ========================================

echo.
echo [*] Starting MySQL and Apache...
echo.

REM Start XAMPP services (assumes XAMPP is installed in C:\xampp)
cd /d "C:\xampp"

REM Start MySQL
if exist mysql\bin\mysqld.exe (
    echo [*] Starting MySQL...
    start "" mysql\bin\mysqld.exe
    timeout /t 3 /nobreak
) else (
    echo [!] XAMPP MySQL not found
    exit /b 1
)

REM Start Apache
if exist apache\bin\httpd.exe (
    echo [*] Starting Apache...
    start "" apache\bin\httpd.exe
    timeout /t 2 /nobreak
) else (
    echo [!] XAMPP Apache not found
    exit /b 1
)

echo.
echo [✓] Services started
echo [*] Navigating to project...
echo.

REM Navigate to project
cd /d "E:\xampp\htdocs\catsugad"

REM Run migration
echo [*] Running migration...
php artisan migrate

echo.
echo [*] Clearing caches...
php artisan cache:clear
php artisan config:clear
php artisan route:clear

echo.
echo [✓] Setup complete!
echo [*] Visit: http://localhost:8000/admin/staff/import
echo.
pause
