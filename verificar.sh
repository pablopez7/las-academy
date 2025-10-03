#!/bin/bash

echo "======================================"
echo "  🔍 LAS Academy - Verificación       "
echo "======================================"
echo ""

# Verificar Docker
echo "1. Verificando Docker..."
if docker info > /dev/null 2>&1; then
    echo "   ✅ Docker está instalado y corriendo"
else
    echo "   ❌ Docker NO está corriendo"
    echo "   📥 Instala Docker Desktop: https://www.docker.com/products/docker-desktop"
    echo ""
    exit 1
fi

# Verificar archivos del proyecto
echo ""
echo "2. Verificando estructura del proyecto..."

archivos_requeridos=(
    "docker-compose.yml"
    "Dockerfile"
    "composer.json"
    "package.json"
    ".env.example"
    "artisan"
)

todos_ok=true
for archivo in "${archivos_requeridos[@]}"; do
    if [ -f "$archivo" ]; then
        echo "   ✅ $archivo"
    else
        echo "   ❌ $archivo NO encontrado"
        todos_ok=false
    fi
done

# Verificar scripts
echo ""
echo "3. Verificando scripts de utilidad..."

scripts=(
    "install.sh"
    "start.sh"
    "stop.sh"
    "logs.sh"
    "db.sh"
    "artisan.sh"
)

for script in "${scripts[@]}"; do
    if [ -f "$script" ] && [ -x "$script" ]; then
        echo "   ✅ $script (ejecutable)"
    else
        echo "   ❌ $script (falta o no es ejecutable)"
        todos_ok=false
    fi
done

# Verificar directorios
echo ""
echo "4. Verificando directorios..."

directorios=(
    "app"
    "database"
    "resources"
    "routes"
    "public"
)

for dir in "${directorios[@]}"; do
    if [ -d "$dir" ]; then
        echo "   ✅ $dir/"
    else
        echo "   ❌ $dir/ NO encontrado"
        todos_ok=false
    fi
done

# Verificar migraciones
echo ""
echo "5. Verificando migraciones..."
num_migrations=$(find database/migrations -name "*.php" 2>/dev/null | wc -l)
echo "   ℹ️  Migraciones encontradas: $num_migrations"

# Verificar seeders
echo ""
echo "6. Verificando seeders..."
num_seeders=$(find database/seeders -name "*.php" 2>/dev/null | wc -l)
echo "   ℹ️  Seeders encontrados: $num_seeders"

# Verificar vistas
echo ""
echo "7. Verificando vistas..."
num_vistas=$(find resources/views -name "*.blade.php" 2>/dev/null | wc -l)
echo "   ℹ️  Vistas encontradas: $num_vistas"

# Verificar modelos
echo ""
echo "8. Verificando modelos..."
num_modelos=$(find app/Models -name "*.php" 2>/dev/null | wc -l)
echo "   ℹ️  Modelos encontrados: $num_modelos"

# Verificar controladores
echo ""
echo "9. Verificando controladores..."
num_controladores=$(find app/Http/Controllers -name "*.php" 2>/dev/null | wc -l)
echo "   ℹ️  Controladores encontrados: $num_controladores"

echo ""
echo "======================================"

if [ "$todos_ok" = true ]; then
    echo "  ✅ Verificación Completa - Todo OK   "
    echo "======================================"
    echo ""
    echo "📋 Resumen:"
    echo "   • $num_migrations migraciones"
    echo "   • $num_seeders seeders"
    echo "   • $num_modelos modelos"
    echo "   • $num_controladores controladores"
    echo "   • $num_vistas vistas"
    echo ""
    echo "🚀 Siguiente paso:"
    echo "   1. Ejecuta: ./install.sh"
    echo "   2. Luego: ./start.sh"
    echo "   3. Abre: http://localhost"
    echo ""
else
    echo "  ⚠️  Algunos archivos faltan         "
    echo "======================================"
    echo ""
    echo "Revisa los errores arriba."
    echo ""
fi
