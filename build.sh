#!/usr/bin/env bash
set -e

echo "===> 1. Compilando frontend..."
npm install
npm run build

echo "===> 2. Descargando motor PHP oficial (FrankenPHP)..."
mkdir -p bin
# Enlace permanente directo de GitHub que NUNCA da 404 y no requiere descomprimir
curl -fSL "https://github.com/dunglas/frankenphp/releases/latest/download/frankenphp-linux-x86_64" -o bin/frankenphp
chmod +x bin/frankenphp

echo "===> 3. Configurando entorno PHP..."
# Creamos un puente para que Laravel lo reconozca automáticamente como "php"
cat << 'EOF' > bin/php
#!/usr/bin/env bash
"$(dirname "$0")/frankenphp" php-cli "$@"
EOF
chmod +x bin/php

./bin/php -v

echo "===> 4. Descargando Composer..."
curl -sS https://getcomposer.org/installer | ./bin/php -- --install-dir=bin --filename=composer

echo "===> 5. Instalando dependencias de Laravel..."
./bin/php bin/composer install --no-dev --optimize-autoloader

echo "===> 6. Optimizando configuraciones..."
./bin/php artisan config:clear