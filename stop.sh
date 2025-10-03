#!/bin/bash

echo "======================================"
echo "  ⏸️  LAS ACADEMY - Deteniendo Sistema "
echo "======================================"
echo ""

docker-compose down

echo ""
echo "✅ Sistema detenido correctamente"
echo ""
echo "Para iniciar nuevamente:"
echo "  ./start.sh"
echo ""
