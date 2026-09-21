#!/usr/bin/env bash
set -e

echo "===> 1. Compilando frontend..."
npm install
npm run build

echo "===> 2. Descargando motor PHP oficial (FrankenPHP)..."
mkdir -p bin
curl -fSL "https://github.com/dunglas/frankenphp/releases/latest/download/frankenphp-linux-x86_64" -o bin/frankenphp
chmod +x bin/frankenphp

echo "===> 3. Configurando entorno PHP global..."
cat << 'EOF' > bin/php
#!/usr/bin/env bash
"$(dirname "$0")/frankenphp" php-cli "$@"
EOF
chmod +x bin/php

# ESTA LÍNEA ES LA MAGIA: Conecta nuestro PHP local para que Laravel lo reconozca globalmente
export PATH="$PWD/bin:$PATH"

echo "===> 4. Descargando Composer..."
curl -fSL "https://getcomposer.org/download/latest-stable/composer.phar" -o bin/composer
chmod +x bin/composer

echo "===> 5. Instalando dependencias de Laravel..."
# Como exportamos la ruta, ya podemos usar los comandos normales
composer install --no-dev --optimize-autoloader

echo "===> 6. Optimizando configuraciones..."
php artisan config:clear