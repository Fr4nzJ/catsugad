# ========================================
# Staff Import Feature - PowerShell Setup
# ========================================

Write-Host ""
Write-Host "[*] Staff Import Feature - Setup Script" -ForegroundColor Cyan
Write-Host ""

# Set location
Set-Location "E:\xampp\htdocs\catsugad"

Write-Host "[*] Current directory: $(Get-Location)" -ForegroundColor Gray
Write-Host ""

# Check if MySQL is running
Write-Host "[*] Checking MySQL connection..." -ForegroundColor Yellow

$mysqlRunning = Test-NetConnection -ComputerName 127.0.0.1 -Port 3306 -WarningAction SilentlyContinue -ErrorAction SilentlyContinue

if ($mysqlRunning.TcpTestSucceeded) {
    Write-Host "[✓] MySQL is running" -ForegroundColor Green
} else {
    Write-Host "[!] MySQL is NOT running!" -ForegroundColor Red
    Write-Host ""
    Write-Host "START MYSQL:" -ForegroundColor Yellow
    Write-Host "1. Open XAMPP Control Panel (C:\xampp\xampp-control.exe)"
    Write-Host "2. Click 'Start' next to MySQL"
    Write-Host "3. Wait 10 seconds"
    Write-Host "4. Run this script again"
    Write-Host ""
    Read-Host "Press Enter when MySQL is started"
}

Write-Host ""
Write-Host "[*] Running database migration..." -ForegroundColor Yellow
php artisan migrate

Write-Host ""
Write-Host "[*] Clearing caches..." -ForegroundColor Yellow
php artisan cache:clear
php artisan config:clear
php artisan route:clear

Write-Host ""
Write-Host "[✓] Setup complete!" -ForegroundColor Green
Write-Host ""
Write-Host "NEXT STEPS:" -ForegroundColor Cyan
Write-Host "1. Run: php artisan serve"
Write-Host "2. Visit: http://localhost:8000/admin/staff/import"
Write-Host "3. Upload test Excel file"
Write-Host ""

Read-Host "Press Enter to continue"
