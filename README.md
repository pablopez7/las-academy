# LAS Academy

Sistema de gestión de aprendizaje para el Seminario Letra al que Sirve.

## Stack Tecnológico
- Laravel 11
- MySQL 8.0
- Tailwind CSS (tema oscuro)
- Alpine.js
- Livewire 3
- Docker

## Setup Local

1. Clonar repositorio
   ```bash
   git clone https://github.com/tu-usuario/las-academy.git
   cd las-academy
   ```

2. Copiar archivo de configuración
   ```bash
   cp .env.example .env
   ```

3. Instalar dependencias con Docker
   ```bash
   docker-compose up -d
   docker-compose exec app composer install
   docker-compose exec app npm install
   ```

4. Generar clave de aplicación
   ```bash
   docker-compose exec app php artisan key:generate
   ```

5. Ejecutar migraciones
   ```bash
   docker-compose exec app php artisan migrate
   ```

6. Cargar datos iniciales
   ```bash
   docker-compose exec app php artisan db:seed
   ```

## Acceso
- Web: http://localhost
- PhpMyAdmin: http://localhost:8080

## Comandos Útiles

```bash
# Importar contenido del seminario
php artisan import:contenido-seminario

# Compilar assets
npm run build

# Ver logs
docker-compose logs -f

# Acceder al contenedor
docker-compose exec app bash

# Detener servicios
docker-compose down
```

## Estructura del Proyecto

```
las-academy/
├── app/
│   ├── Models/          # Modelos (Encuentro, Materia, Contenido)
│   ├── Http/            # Controladores y middleware
│   └── Livewire/        # Componentes reactivos
├── database/
│   ├── migrations/      # Estructura de BD
│   └── seeders/         # Datos iniciales
├── resources/
│   ├── views/           # Vistas Blade
│   └── css/             # Estilos Tailwind
└── routes/              # Definición de rutas
```

## Tecnologías

- **Laravel 11** - Framework PHP moderno
- **MySQL 8** - Base de datos relacional
- **Livewire 3** - Componentes reactivos sin JavaScript
- **Alpine.js** - JavaScript ligero para interactividad
- **Tailwind CSS** - Framework CSS con tema oscuro
- **Docker** - Contenedorización para desarrollo

## Soporte

Para problemas o preguntas, consulta la documentación de Laravel: https://laravel.com/docs
