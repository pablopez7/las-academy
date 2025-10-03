#!/bin/bash

echo "======================================"
echo "  📋 LAS ACADEMY - Logs en Tiempo Real"
echo "======================================"
echo ""
echo "Presiona Ctrl+C para salir"
echo ""

docker-compose logs -f app
