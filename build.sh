#!/usr/bin/env bash
set -e

echo "===> 1. Compilando frontend..."
npm install
npm run build

echo "===> 2. Descargando PHP portable..."
mkdir -p bin
curl -fSL "https://github.com/crazywhalecc/static-php-cli/releases/download/2.3.1/php-8.3.6-cli-linux-x86_64.tar.gz" -o php.tar.gz
tar -xzf php.tar.gz -C bin/
rm -f php.tar.gz
chmod +x bin/php

echo "===> 3. Descargando Composer..."
curl -sS https://getcomposer.org/installer | ./bin/php -- --install-dir=bin --filename=composer

echo "===> 4. Instalando dependencias de Laravel..."
./bin/php bin/composer install --no-dev --optimize-autoloader

echo "===> 5. Optimizando configuraciones..."
./bin/php artisan config:clear