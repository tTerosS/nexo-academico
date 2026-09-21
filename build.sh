#!/usr/bin/env bash
set -e

echo "===> 1. Compilando estilos y frontend con Node..."
npm install
npm run build

echo "===> 2. Descargando motor PHP portable..."
curl -sSL "https://github.com/crazywhalecc/static-php-cli/releases/download/8.3.6/php-8.3.6-cli-linux-x86_64.tar.gz" -o php.tar.gz
mkdir -p bin
tar -xzf php.tar.gz -C bin/
rm -f php.tar.gz
chmod +x bin/php

echo "===> 3. Descargando Composer..."
curl -sS https://getcomposer.org/installer | ./bin/php -- --install-dir=bin --filename=composer

echo "===> 4. Instalando dependencias de Laravel..."
./bin/php bin/composer install --no-dev --optimize-autoloader

echo "===> 5. Optimizando Laravel..."
./bin/php artisan config:clear