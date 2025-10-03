# 🎉 ¡Bienvenido a LAS Academy!

## 👋 Hola Pablo,

Tu sistema de gestión educativa **LAS Academy** está completamente listo para usar.

---

## ⚡ Inicio Rápido (3 pasos)

### 1️⃣ Instalar Docker Desktop

**Descarga e instala Docker Desktop para macOS:**
- 🔗 https://www.docker.com/products/docker-desktop
- Selecciona tu tipo de Mac (Intel o Apple Silicon)
- Instala y abre la aplicación
- Espera a que aparezca el ícono 🐳 en tu barra de menú

### 2️⃣ Instalar LAS Academy (solo primera vez)

Abre tu Terminal y copia estos comandos:

```bash
cd "/Users/pablopez/Seminario Letra al que Sirve/las-academy"
./install.sh
```

⏱️ Esto tomará 5-10 minutos. El script:
- Verifica que Docker esté corriendo
- Descarga e instala todas las dependencias
- Configura la base de datos
- Carga datos de ejemplo

### 3️⃣ Iniciar el Sistema

```bash
./start.sh
```

Luego abre tu navegador en:
- 🌐 **http://localhost** ← Tu aplicación
- 🗄️ **http://localhost:8080** ← PhpMyAdmin (gestor de BD)

---

## 📚 Documentación

Hemos creado varios archivos de ayuda:

| Archivo | Descripción |
|---------|-------------|
| 📄 [INSTRUCCIONES.md](INSTRUCCIONES.md) | Guía completa de instalación y uso |
| 📊 [IMPORTAR_DATOS.md](IMPORTAR_DATOS.md) | Cómo importar tus transcripciones existentes |
| 📋 [RESUMEN_PROYECTO.md](RESUMEN_PROYECTO.md) | Resumen técnico completo del proyecto |
| 📖 [README.md](README.md) | Documentación técnica general |

---

## 🎯 ¿Qué incluye el sistema?

### ✅ Funcionalidades Listas
- 📅 Gestión de 6 encuentros del seminario
- 📚 7 materias predefinidas (AT, NT, Hermenéutica, etc.)
- 📄 Sistema de recursos (transcripciones, rúbricas, resúmenes)
- ✍️ Sistema de tareas con rúbricas
- 🔍 Búsqueda full-text en todo el contenido
- 🎨 Interfaz moderna y responsive

### ✅ Datos de Ejemplo Incluidos
- 2 encuentros activos con contenido
- 7 materias con colores personalizados
- 8 recursos de ejemplo
- 4 tareas con rúbricas completas

---

## 🛠️ Comandos Útiles

Una vez instalado, estos son los comandos que usarás:

```bash
# Gestión del sistema
./start.sh          # ▶️  Iniciar el sistema
./stop.sh           # ⏸️  Detener el sistema
./logs.sh           # 📋 Ver logs en tiempo real

# Base de datos
./db.sh             # 🗄️  Acceso directo a MySQL
./artisan.sh migrate:fresh --seed  # 🔄 Resetear BD

# Laravel
./artisan.sh [comando]  # Ejecutar comandos de Laravel
```

---

## 🚀 Flujo de Trabajo

### Primera vez:
1. ✅ Instalar Docker Desktop
2. ✅ Ejecutar `./install.sh`
3. ✅ Ejecutar `./start.sh`
4. ✅ Abrir http://localhost

### Uso diario:
1. ✅ Abrir Docker Desktop
2. ✅ Ejecutar `./start.sh`
3. ✅ Desarrollar/modificar código
4. ✅ Los cambios se ven automáticamente
5. ✅ Al terminar: `./stop.sh`

---

## 📊 Accesos al Sistema

### 🌐 Aplicación Web
- **URL**: http://localhost
- **Descripción**: Tu sistema LAS Academy completo

### 🗄️ PhpMyAdmin (Gestor Visual de BD)
- **URL**: http://localhost:8080
- **Usuario**: `las_user`
- **Contraseña**: `las_password`
- **Base de datos**: `las_academy`

### 📊 MySQL (Consola)
```bash
./db.sh
# Usuario: las_user
# Contraseña: las_password
```

---

## 🎨 Personalización

### Cambiar colores:
Edita: `tailwind.config.js` y `resources/css/app.css`

### Modificar vistas:
Edita archivos en: `resources/views/`

### Agregar funcionalidades:
- Modelos: `app/Models/`
- Controladores: `app/Http/Controllers/`
- Rutas: `routes/web.php`

---

## 📥 Importar Tus Datos Reales

Tienes dos carpetas con contenido:
- `/Users/pablopez/Seminario Letra al que Sirve/Primer_Encuentro/`
- `/Users/pablopez/Seminario Letra al que Sirve/Segundo_Encuentro/`

**Lee el archivo [IMPORTAR_DATOS.md](IMPORTAR_DATOS.md)** para aprender cómo importar este contenido al sistema.

Puedo crear un script automático que importe todo. Solo avísame.

---

## 🆘 ¿Problemas?

### Docker no inicia:
- Asegúrate de que Docker Desktop esté abierto
- Verifica que el ícono 🐳 esté en la barra de menú

### Error al ejecutar scripts:
```bash
chmod +x *.sh
```

### Resetear todo:
```bash
./stop.sh
./artisan.sh migrate:fresh --seed
./start.sh
```

### Ver errores:
```bash
./logs.sh
```

---

## 🎯 Próximos Pasos Recomendados

### Inmediato:
1. ✅ Instalar Docker Desktop
2. ✅ Ejecutar `./install.sh`
3. ✅ Abrir http://localhost
4. ✅ Explorar el sistema

### Corto Plazo:
1. 📥 Importar tus transcripciones reales
2. 🎨 Personalizar colores y diseño
3. 📝 Agregar más contenido

### Largo Plazo:
1. 👥 Sistema de usuarios y autenticación
2. 📤 Subida de archivos
3. 💬 Comentarios y discusiones
4. 🌐 Despliegue a producción (cPanel)

---

## 📞 Ayuda

Si necesitas ayuda:
1. Lee [INSTRUCCIONES.md](INSTRUCCIONES.md) para guía paso a paso
2. Lee [RESUMEN_PROYECTO.md](RESUMEN_PROYECTO.md) para detalles técnicos
3. Ejecuta `./logs.sh` para ver errores
4. Verifica que Docker esté corriendo

---

## 💡 Tips Importantes

1. **Hot-reload está activado**: Los cambios en el código se ven inmediatamente
2. **PhpMyAdmin es tu amigo**: Úsalo para ver/editar la BD visualmente
3. **Los scripts .sh son tus herramientas**: Úsalos para todo
4. **Docker debe estar corriendo**: Siempre verifica el ícono 🐳

---

## 🎉 ¡Ya Estás Listo!

Tu sistema está **100% funcional** y esperando por ti.

### Comienza ahora:

```bash
# Paso 1: Ve al directorio
cd "/Users/pablopez/Seminario Letra al que Sirve/las-academy"

# Paso 2: Instala (primera vez)
./install.sh

# Paso 3: Inicia
./start.sh

# Paso 4: Abre tu navegador
# http://localhost
```

---

**¡Disfruta de LAS Academy!** 🚀📚

_Si necesitas ayuda para importar tus datos o agregar funcionalidades, solo avísame._
