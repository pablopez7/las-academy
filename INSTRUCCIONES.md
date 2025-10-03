# 🚀 Instrucciones de Instalación - LAS Academy

## ⚠️ IMPORTANTE: Primero debes instalar Docker

### Paso 1: Instalar Docker Desktop para macOS

1. **Descarga Docker Desktop**:
   - Ve a: https://www.docker.com/products/docker-desktop
   - Haz clic en "Download for Mac"
   - Selecciona la versión apropiada para tu Mac (Intel o Apple Silicon)

2. **Instala Docker Desktop**:
   - Abre el archivo `.dmg` descargado
   - Arrastra Docker a tu carpeta de Aplicaciones
   - Abre Docker Desktop desde Aplicaciones
   - Acepta los permisos que solicite

3. **Verifica que Docker esté corriendo**:
   - Deberías ver el ícono de Docker (una ballena) en tu barra de menú superior
   - El ícono debe estar sin animación (significa que está listo)

---

## Paso 2: Instalar y Ejecutar LAS Academy

Una vez que Docker Desktop esté instalado y corriendo, sigue estos pasos:

### 📥 Instalación (Solo la primera vez)

Abre tu Terminal y ejecuta:

```bash
cd "/Users/pablopez/Seminario Letra al que Sirve/las-academy"
./install.sh
```

Este script:
- ✅ Verifica que Docker esté corriendo
- 🐳 Construye los contenedores necesarios
- 📦 Instala todas las dependencias de PHP y Node.js
- 🗄️ Configura la base de datos
- 🌱 Llena la base de datos con datos de ejemplo

**Tiempo estimado**: 5-10 minutos (dependiendo de tu conexión a internet)

---

## 🎯 Ejecutar el Sistema

### Para INICIAR el sistema:

```bash
cd "/Users/pablopez/Seminario Letra al que Sirve/las-academy"
./start.sh
```

**El sistema estará disponible en**:
- 🌐 Aplicación principal: http://localhost
- 🗄️ PhpMyAdmin (gestor de BD): http://localhost:8080
- 📊 Base de datos MySQL: localhost:3306

**Credenciales de la base de datos**:
- Usuario: `las_user`
- Contraseña: `las_password`
- Base de datos: `las_academy`

### Para DETENER el sistema:

```bash
./stop.sh
```

### Para ver LOGS en tiempo real:

```bash
./logs.sh
```
(Presiona Ctrl+C para salir)

### Para acceder a la base de datos por consola:

```bash
./db.sh
```

### Para ejecutar comandos de Laravel (Artisan):

```bash
./artisan.sh [comando]

# Ejemplos:
./artisan.sh migrate
./artisan.sh make:model NuevoModelo
./artisan.sh db:seed
```

---

## 📁 Estructura del Proyecto

```
las-academy/
├── app/                    # Código de la aplicación
│   ├── Http/
│   │   └── Controllers/   # Controladores
│   ├── Models/            # Modelos Eloquent
│   └── Livewire/          # Componentes Livewire
│
├── database/
│   ├── migrations/        # Migraciones de base de datos
│   └── seeders/          # Datos de prueba
│
├── resources/
│   ├── views/            # Vistas Blade
│   ├── css/              # Estilos
│   └── js/               # JavaScript
│
├── routes/
│   ├── web.php           # Rutas web
│   └── api.php           # Rutas API
│
└── public/               # Archivos públicos
```

---

## 🔧 Desarrollo

### Hot Reload (Cambios en tiempo real)

Cuando ejecutas `./start.sh`, el sistema automáticamente:
- ✅ Detecta cambios en archivos PHP y los aplica inmediatamente
- ✅ Compila automáticamente cambios en CSS/JS (con Vite)
- ✅ Refresca el navegador cuando detecta cambios

**No necesitas reiniciar nada**, solo guarda tus archivos y recarga el navegador.

### Agregar nuevos recursos desde tus datos existentes

Para agregar las transcripciones que ya tienes en el proyecto:

1. Los archivos están en:
   - `/Users/pablopez/Seminario Letra al que Sirve/Primer_Encuentro/`
   - `/Users/pablopez/Seminario Letra al que Sirve/Segundo_Encuentro/`

2. Puedes crear un script para importarlos automáticamente o usar los seeders

---

## 🎨 Personalización

### Cambiar colores o estilos:

Edita: `resources/css/app.css` o `tailwind.config.js`

### Agregar nuevas páginas:

1. Crea una vista en `resources/views/`
2. Crea una ruta en `routes/web.php`
3. Opcionalmente crea un controlador en `app/Http/Controllers/`

### Agregar nuevos modelos:

```bash
./artisan.sh make:model NombreModelo -m
```

Esto crea el modelo y su migración automáticamente.

---

## 🐛 Solución de Problemas

### El sistema no inicia:

1. Verifica que Docker Desktop esté corriendo (ícono en barra de menú)
2. Ejecuta: `./stop.sh` y luego `./start.sh`

### Error de permisos:

```bash
chmod +x *.sh
```

### Resetear la base de datos:

```bash
./artisan.sh migrate:fresh --seed
```

⚠️ Esto borrará todos los datos y volverá a crear la BD con datos de ejemplo.

### Ver qué contenedores están corriendo:

```bash
docker ps
```

---

## 📚 Próximos Pasos

1. ✅ Instalar Docker Desktop
2. ✅ Ejecutar `./install.sh`
3. ✅ Ejecutar `./start.sh`
4. ✅ Abrir http://localhost en tu navegador
5. 🎉 ¡Empezar a usar LAS Academy!

---

## 💡 Tecnologías Utilizadas

- **Laravel 11** - Framework PHP
- **MySQL 8** - Base de datos
- **Livewire 3** - Componentes reactivos
- **Alpine.js** - JavaScript reactivo ligero
- **Tailwind CSS** - Framework de estilos
- **Vite** - Build tool moderno
- **Docker** - Contenedorización

---

## 📞 Soporte

Si tienes problemas:
1. Revisa la sección de solución de problemas arriba
2. Verifica que Docker esté corriendo
3. Lee los logs con `./logs.sh`

---

¡Disfruta de LAS Academy! 🎓
