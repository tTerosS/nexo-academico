#!/usr/bin/env bash
set -e

echo "===> 1. Compilando frontend..."
npm install
npm run build

echo "===> 2. Buscando dinámicamente la última versión de PHP 8.3..."
mkdir -p bin

# Extraemos el enlace exacto directamente desde la página de releases de GitHub
HTML=$(curl -sL https://github.com/static-php/static-php-cli/releases/latest)
REL_URL=$(echo "$HTML" | grep -o 'href="[^"]*php-8\.3[^"]*cli-linux-x86_64\.tar\.gz"' | head -n 1 | cut -d '"' -f 2)
DOWNLOAD_URL="https://github.com${REL_URL}"

echo "URL encontrada: $DOWNLOAD_URL"
curl -fSL "$DOWNLOAD_URL" -o php.tar.gz

tar -xzf php.tar.gz -C bin/
rm -f php.tar.gz
chmod +x bin/php

echo "===> 3. Verificando versión instalada..."
./bin/php -v

echo "===> 4. Descargando Composer..."
curl -sS https://getcomposer.org/installer | ./bin/php -- --install-dir=bin --filename=composer

echo "===> 5. Instalando dependencias de Laravel..."
./bin/php bin/composer install --no-dev --optimize-autoloader

echo "===> 6. Optimizando configuraciones..."
./bin/php artisan config:clear