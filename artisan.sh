#!/bin/bash

# Script para ejecutar comandos de Artisan fácilmente
# Uso: ./artisan.sh migrate
#      ./artisan.sh make:model Estudiante

docker-compose exec app php artisan "$@"
