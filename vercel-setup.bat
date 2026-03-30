@echo off
REM Vercel Deployment Setup Script for Laravel (Windows)

echo.
echo ============================================
echo  Setting up Laravel for Vercel Deployment
echo ============================================
echo.

REM Check if PHP is installed
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] PHP is not installed. Please install PHP 8.1 or higher.
    exit /b 1
)

echo [OK] PHP is installed
php -v | findstr /R "^[0-9]"

REM Check if Node.js is installed
where node >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] Node.js is not installed. Please install Node.js 18 or higher.
    exit /b 1
)

echo [OK] Node.js is installed
node -v

REM Check if Composer is installed
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] Composer is not installed. Please install Composer.
    exit /b 1
)

echo [OK] Composer is installed

echo.
echo [1/6] Installing Composer dependencies...
composer install --optimize-autoloader --no-dev

echo.
echo [2/6] Installing NPM dependencies...
call npm install

REM Generate app key if not exists
if not exist .env (
    echo.
    echo [3/6] Creating .env file from .env.example...
    copy .env.example .env
) else (
    echo.
    echo [3/6] .env file exists
)

REM Generate app key if empty
findstr /C:"APP_KEY=" .env | findstr "$" >nul
if %errorlevel% equ 0 (
    echo.
    echo [4/6] Generating application key...
    php artisan key:generate
) else (
    echo.
    echo [4/6] Application key exists
)

echo.
echo [5/6] Building frontend assets...
call npm run build

echo.
echo [6/6] Creating storage directories...
if not exist storage\framework\cache mkdir storage\framework\cache
if not exist storage\framework\sessions mkdir storage\framework\sessions
if not exist storage\framework\views mkdir storage\framework\views
if not exist storage\logs mkdir storage\logs
if not exist storage\app\public mkdir storage\app\public

echo.
echo ============================================
echo  Setup Complete!
echo ============================================
echo.
echo To deploy to Vercel, run:
echo   npx vercel
echo.
echo For production deployment:
echo   npx vercel --prod
echo.
echo Don't forget to set environment variables in Vercel dashboard!
echo See VERCEL_DEPLOYMENT.md for details.
echo.
pause
