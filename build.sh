#!/usr/bin/env bash
set -e

echo "===> 1. Compilando frontend..."
npm install
npm run build

echo "===> 2. Descargando motor PHP oficial (FrankenPHP)..."
mkdir -p bin
curl -fSL "https://github.com/dunglas/frankenphp/releases/latest/download/frankenphp-linux-x86_64" -o bin/frankenphp
chmod +x bin/frankenphp

echo "===> 3. Descargando Composer..."
curl -fSL "https://getcomposer.org/download/latest-stable/composer.phar" -o bin/composer
chmod +x bin/composer

echo "===> 4. Instalando dependencias de Laravel..."
# El parámetro --no-scripts evita que Composer busque el PHP global y se estrelle
./bin/frankenphp php-cli bin/composer install --no-dev --optimize-autoloader --no-scripts

echo "===> 5. Ejecutando descubrimiento de paquetes..."
# Ejecutamos manualmente el paso que bloqueamos arriba
./bin/frankenphp php-cli artisan package:discover --ansi

echo "===> 6. Optimizando configuraciones..."
./bin/frankenphp php-cli artisan config:clear