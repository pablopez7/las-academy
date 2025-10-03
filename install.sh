#!/bin/bash

echo "======================================"
echo "  LAS ACADEMY - Instalación Inicial  "
echo "======================================"
echo ""

# Verificar que Docker esté corriendo
if ! docker info > /dev/null 2>&1; then
    echo "❌ Error: Docker no está corriendo."
    echo ""
    echo "Por favor:"
    echo "1. Instala Docker Desktop desde: https://www.docker.com/products/docker-desktop"
    echo "2. Abre Docker Desktop"
    echo "3. Espera a que el ícono de Docker aparezca en tu barra de menú"
    echo "4. Vuelve a ejecutar este script"
    echo ""
    exit 1
fi

echo "✅ Docker está corriendo"
echo ""

# Construir contenedores
echo "📦 Construyendo contenedores Docker..."
docker-compose build

echo ""
echo "📥 Instalando dependencias de PHP..."
docker-compose run --rm app composer install

echo ""
echo "📥 Instalando dependencias de Node.js..."
docker-compose run --rm app npm install

echo ""
echo "⚙️  Configurando ambiente..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ Archivo .env creado"
fi

echo ""
echo "🔑 Generando clave de aplicación..."
docker-compose run --rm app php artisan key:generate

echo ""
echo "🗄️  Iniciando base de datos..."
docker-compose up -d mysql redis

echo "⏳ Esperando que MySQL esté listo..."
sleep 15

echo ""
echo "📊 Ejecutando migraciones..."
docker-compose run --rm app php artisan migrate --force

echo ""
echo "🌱 Poblando base de datos con datos iniciales..."
docker-compose run --rm app php artisan db:seed --force

echo ""
echo "======================================"
echo "  ✅ Instalación Completada           "
echo "======================================"
echo ""
echo "Para iniciar el sistema ejecuta:"
echo "  ./start.sh"
echo ""
