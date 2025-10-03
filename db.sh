#!/bin/bash

echo "======================================"
echo "  🗄️  LAS ACADEMY - Acceso a MySQL    "
echo "======================================"
echo ""
echo "Conectando a la base de datos..."
echo "Para salir escribe: exit"
echo ""

docker-compose exec mysql mysql -u las_user -plas_password las_academy
