#!/usr/bin/env bash
set -e

echo "===> 1. Compilando frontend..."
npm install
npm run build

echo "===> 2. Instalando PHP 8.3 precompilado..."
mkdir -p bin
curl -fSL "https://dl.static-php.dev/static-php-cli/common/php-8.3.16-cli-linux-x86_64.tar.gz" -o php.tar.gz
tar -xzf php.tar.gz -C bin/
rm -f php.tar.gz
chmod +x bin/php

echo "===> 3. Verificando versión de PHP..."
./bin/php -v

echo "===> 4. Descargando Composer..."
curl -sS https://getcomposer.org/installer | ./bin/php -- --install-dir=bin --filename=composer

echo "===> 5. Instalando dependencias de Laravel..."
./bin/php bin/composer install --no-dev --optimize-autoloader

echo "===> 6. Optimizando configuraciones..."
./bin/php artisan config:clear