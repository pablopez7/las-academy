#!/bin/bash

echo "======================================"
echo "  🚀 LAS ACADEMY - Iniciando Sistema  "
echo "======================================"
echo ""

# Verificar que Docker esté corriendo
if ! docker info > /dev/null 2>&1; then
    echo "❌ Error: Docker no está corriendo."
    echo ""
    echo "Por favor:"
    echo "1. Abre Docker Desktop"
    echo "2. Espera a que esté listo"
    echo "3. Vuelve a ejecutar este script"
    echo ""
    exit 1
fi

echo "✅ Docker está corriendo"
echo ""

# Iniciar todos los servicios
echo "🐳 Iniciando contenedores..."
docker-compose up -d

echo ""
echo "⏳ Esperando que los servicios estén listos..."
sleep 5

echo ""
echo "🎨 Compilando assets (Vite en modo desarrollo)..."
docker-compose exec -d app npm run dev

echo ""
echo "======================================"
echo "  ✅ Sistema Iniciado Correctamente    "
echo "======================================"
echo ""
echo "🌐 Aplicación:      http://localhost"
echo "🗄️  PhpMyAdmin:      http://localhost:8080"
echo "📊 Base de datos:   localhost:3306"
echo ""
echo "Credenciales de BD:"
echo "  Usuario: las_user"
echo "  Contraseña: las_password"
echo "  Base de datos: las_academy"
echo ""
echo "Para ver logs en tiempo real:"
echo "  ./logs.sh"
echo ""
echo "Para detener el sistema:"
echo "  ./stop.sh"
echo ""
echo "💡 Los cambios en el código se reflejarán automáticamente"
echo ""
