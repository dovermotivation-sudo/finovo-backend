@echo off
setlocal enabledelayedexpansion

:: Change directory to the folder where the batch file is located
cd /d "%~dp0"

title Laravel Local Development Runner

echo ===================================================
echo             Laravel Development Runner
echo ===================================================
echo.

:: Check PHP installation
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] PHP is not installed or not in your PATH.
    echo Please install PHP and add it to your system PATH.
    echo.
    pause
    exit /b 1
)

:: Check Node.js installation
where node >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] Node.js is not installed or not in your PATH.
    echo Please install Node.js and add it to your system PATH.
    echo.
    pause
    exit /b 1
)

:: Check if .env file exists, copy from .env.example if missing
if not exist .env (
    if exist .env.example (
        echo [INFO] .env file not found. Copying from .env.example...
        copy .env.example .env
        echo [INFO] Generating application key...
        php artisan key:generate
    ) else (
        echo [WARNING] Neither .env nor .env.example was found.
    )
)

:: Check if vendor folder exists (composer dependencies)
if not exist vendor (
    echo [INFO] vendor directory not found. Installing PHP dependencies...
    where composer >nul 2>nul
    if %errorlevel% neq 0 (
        echo [ERROR] Composer is required but not found in your PATH.
        echo Please install Composer to resolve PHP dependencies.
        echo.
        pause
        exit /b 1
    )
    call composer install
)

:: Check if node_modules folder exists (npm dependencies)
if not exist node_modules (
    echo [INFO] node_modules directory not found. Installing NPM dependencies...
    call npm install
)

echo.
echo ===================================================
echo  Starting local development servers...
echo ===================================================
echo.
echo  * Laravel Backend will run at: http://127.0.0.1:8000
echo  * Vite Frontend development server is starting...
echo.
echo  Note: Two separate command prompt windows will open.
echo        Do not close them while using the application.
echo ===================================================
echo.

:: Launch the Artisan Serve command in a new window
start "Laravel Server (Port 8000)" cmd /k "php artisan serve"

:: Launch Vite Dev server in another window
start "Vite Dev Server" cmd /k "npm run dev"

echo Development servers have been launched in separate windows.
echo You can view the application at http://127.0.0.1:8000
echo.
echo Press any key to exit this launcher window...
pause >nul
exit /b 0
