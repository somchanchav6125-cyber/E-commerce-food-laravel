#!/bin/bash

# Vercel Deployment Setup Script for Laravel

echo "🚀 Setting up Laravel for Vercel Deployment..."

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 8.1 or higher."
    exit 1
fi

echo "✅ PHP version: $(php -v | head -n 1)"

# Check if Node.js is installed
if ! command -v node &> /dev/null; then
    echo "❌ Node.js is not installed. Please install Node.js 18 or higher."
    exit 1
fi

echo "✅ Node.js version: $(node -v)"

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Install NPM dependencies
echo "📦 Installing NPM dependencies..."
npm install

# Generate app key if not exists
if [ ! -f .env ]; then
    echo "📝 Creating .env file from .env.example..."
    cp .env.example .env
fi

# Generate app key if empty
if grep -q "APP_KEY=$" .env || ! grep -q "APP_KEY=" .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate
fi

# Build frontend assets
echo "🔨 Building frontend assets..."
npm run build

# Create storage directories
echo "📁 Creating storage directories..."
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p storage/app/public

# Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo "✅ Setup complete!"
echo ""
echo "📤 To deploy to Vercel, run:"
echo "   npx vercel"
echo ""
echo "📤 For production deployment:"
echo "   npx vercel --prod"
echo ""
echo "⚙️  Don't forget to set environment variables in Vercel dashboard!"
echo "   See VERCEL_DEPLOYMENT.md for details."
