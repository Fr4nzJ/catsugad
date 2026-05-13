#!/bin/bash

# Railway.com Deployment Script for CatSU GAD System
# This script helps deploy the application to Railway.com

set -e

echo "🚀 CatSU GAD System - Railway.com Deployment Setup"
echo "=================================================="
echo ""

# Check if Railway CLI is installed
if ! command -v railway &> /dev/null; then
    echo "❌ Railway CLI is not installed."
    echo "📦 Install it with: npm i -g @railway/cli"
    exit 1
fi

echo "✅ Railway CLI found"
echo ""

# Login to Railway
echo "🔐 Logging into Railway..."
railway login

echo ""
echo "📋 Initializing Railway project..."
railway init

echo ""
echo "🗄️  Adding MySQL database..."
railway add

echo ""
echo "🔑 Setting up environment variables..."
echo "⚠️  You need to add the following environment variables in Railway dashboard:"
echo ""
echo "APP_NAME=CatSU_GAD_System"
echo "APP_ENV=production"
echo "APP_DEBUG=false"
echo "APP_KEY=base64:$(php artisan key:generate --show 2>/dev/null || echo 'generate-this-value')"
echo "ANTHROPIC_API_KEY=your_api_key_here"
echo ""
echo "Database variables (auto-configured by Railway):"
echo "DB_CONNECTION=mysql"
echo "DB_HOST=\${{ Mysql.PRIVATE_URL }}"
echo "DB_PORT=3306"
echo "DB_DATABASE=\${{ Mysql.DATABASE }}"
echo "DB_USERNAME=\${{ Mysql.USERNAME }}"
echo "DB_PASSWORD=\${{ Mysql.PASSWORD }}"
echo ""

read -p "Press Enter once you've added environment variables in Railway dashboard..."

echo ""
echo "🚀 Deploying application..."
railway up

echo ""
echo "✅ Deployment started!"
echo ""
echo "📊 View logs: railway logs -f"
echo "🐚 SSH access: railway shell"
echo "📱 Visit: \$(railway env | grep RAILWAY_STATIC_URL | cut -d= -f2)"
echo ""
echo "For more information, see RAILWAY_DEPLOYMENT.md"
