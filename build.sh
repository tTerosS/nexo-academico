#!/usr/bin/env bash
set -e

echo "===> 1. Compilando frontend..."
npm install
npm run build

echo "===> 2. Descargando motor PHP oficial (FrankenPHP)..."
mkdir -p bin
curl -fSL "https://github.com/dunglas/frankenphp/releases/latest/download/frankenphp-linux-x86_64" -o bin/frankenphp
chmod +x bin/frankenphp

echo "===> 3. Configurando entorno PHP..."
cat << 'EOF' > bin/php
#!/usr/bin/env bash
"$(dirname "$0")/frankenphp" php-cli "$@"
EOF
chmod +x bin/php

echo "===> 4. Descargando Composer directamente..."
# Descargamos el archivo compilado final en lugar de usar el script instalador
curl -fSL "https://getcomposer.org/download/latest-stable/composer.phar" -o bin/composer
chmod +x bin/composer

echo "===> 5. Instalando dependencias de Laravel..."
./bin/php bin/composer install --no-dev --optimize-autoloader

echo "===> 6. Optimizando configuraciones..."
./bin/php artisan config:clear