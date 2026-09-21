#!/usr/bin/env bash
set -e

echo "===> 1. Compilando frontend..."
npm install
npm run build

echo "===> 2. Descargando FrankenPHP (Motor garantizado sin 404)..."
mkdir -p bin
curl -fSL "https://github.com/dunglas/frankenphp/releases/latest/download/frankenphp-linux-x86_64" -o bin/frankenphp
chmod +x bin/frankenphp

echo "===> 3. Conectando PHP nativo al sistema..."
# El symlink hace que FrankenPHP procese los comandos complejos de Composer sin errores
ln -sf "$PWD/bin/frankenphp" "$PWD/bin/php"
export PATH="$PWD/bin:$PATH"

echo "===> 4. Descargando Composer..."
curl -fSL "https://getcomposer.org/download/latest-stable/composer.phar" -o bin/composer
chmod +x bin/composer

echo "===> 5. Instalando dependencias de Laravel..."
composer install --no-dev --optimize-autoloader

echo "===> 6. Optimizando configuraciones..."
php artisan config:clear