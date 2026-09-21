#!/usr/bin/env bash
set -e

echo "===> 1. Compilando frontend..."
npm install
npm run build

echo "===> 2. Descargando PHP nativo mediante la API de GitHub..."
mkdir -p bin

# Consultamos la API oficial de GitHub para extraer el enlace exacto y evitar cualquier error 404
DOWNLOAD_URL=$(curl -sS https://api.github.com/repos/static-php/static-php-cli/releases/latest | grep "browser_download_url" | grep "php-8.3" | grep "cli-linux-x86_64.tar.gz" | cut -d '"' -f 4 | head -n 1)

echo "Descargando desde: $DOWNLOAD_URL"
curl -fSL "$DOWNLOAD_URL" -o php.tar.gz

tar -xzf php.tar.gz -C bin/
rm -f php.tar.gz
chmod +x bin/php

echo "===> 3. Configurando entorno global..."
# Conectamos PHP nativo al sistema
export PATH="$PWD/bin:$PATH"

echo "===> 4. Descargando Composer..."
curl -fSL "https://getcomposer.org/download/latest-stable/composer.phar" -o bin/composer
chmod +x bin/composer

echo "===> 5. Instalando dependencias de Laravel..."
composer install --no-dev --optimize-autoloader

echo "===> 6. Optimizando configuraciones..."
php artisan config:clear