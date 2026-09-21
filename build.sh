#!/usr/bin/env bash
set -e

echo "===> 1. Compilando frontend..."
npm install
npm run build

echo "===> 2. Descargando instalador de PHP portable..."
mkdir -p bin
curl -fsSL -o bin/spc https://dl.static-php.dev/v3/spc-bin/nightly/spc-linux-x86_64
chmod +x bin/spc

echo "===> 3. Instalando binario PHP 8.3 con extensiones..."
./bin/spc download --with-php=8.3 --for-extensions="pdo,pdo_mysql,openssl,mbstring,tokenizer,xml,ctype,json,curl,zip"
./bin/spc build "pdo,pdo_mysql,openssl,mbstring,tokenizer,xml,ctype,json,curl,zip" --build-cli

cp buildroot/bin/php bin/php
chmod +x bin/php

echo "===> 4. Descargando Composer..."
curl -sS https://getcomposer.org/installer | ./bin/php -- --install-dir=bin --filename=composer

echo "===> 5. Instalando dependencias de Laravel..."
./bin/php bin/composer install --no-dev --optimize-autoloader

echo "===> 6. Optimizando configuraciones..."
./bin/php artisan config:clear