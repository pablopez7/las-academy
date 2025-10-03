# 📚 Instrucciones de Importación - LAS Academy

## Estado Actual del Sistema

### Archivos Disponibles
- **86 transcripciones** totales (`.txt`)
  - 42 del Primer Encuentro
  - 44 del Segundo Encuentro
- **227 notas de Obsidian** (`.md`) en `/Apuntes_Obsidian`
- **84 videos** (`.MOV`)
- **2 calendarios** (`.jpg`)

### Estructura de Directorios Fuente
```
/data/seminario/
├── Primer_Encuentro/
│   ├── Antiguo_Testamento/
│   │   ├── PE_AT_C01_GP_transcripcion.txt
│   │   ├── PE_AT_C01_GP.MOV
│   │   └── ...
│   ├── Nuevo_Testamento/
│   ├── Hermeneutica/
│   ├── Historia_Cristianismo/
│   ├── Eclesiologia/
│   ├── Evangelismo/
│   └── Calendario_Primer_Encuentro.jpg
├── Segundo_Encuentro/
│   └── [misma estructura]
└── Apuntes_Obsidian/
    ├── Agustín de Hipona.md
    ├── Antiguo testamento 2 introducción.md
    └── ... (227 archivos)
```

## 🔧 Herramientas Disponibles

### 1. Script Verificador
Compara archivos fuente vs recursos en BD:

```bash
cd /Users/pablopez/Seminario\ Letra\ al\ que\ Sirve/las-academy
docker-compose exec app bash
./verificar_importaciones.sh
```

**Salida:**
- Cuenta archivos fuente
- Consulta recursos en BD
- Lista transcripciones faltantes
- Calcula porcentaje de completitud

### 2. Comando de Importación

#### Opciones disponibles:
```bash
php artisan import:contenido-seminario [opciones]
```

**Flags:**
- `--dry-run` - Simula importación sin modificar BD
- `--solo-transcripciones` - Solo importa archivos `.txt`
- `--solo-notas` - Solo importa notas de Obsidian `.md`
- `--sin-tareas` - Deshabilita detección automática de tareas
- `--limit=N` - Limita a N archivos (útil para pruebas)

## 📋 Procedimiento Recomendado

### Paso 1: Iniciar Docker
```bash
# Desde el directorio del proyecto
cd "/Users/pablopez/Seminario Letra al que Sirve/las-academy"
docker-compose up -d
```

### Paso 2: Verificar Estado Actual
```bash
docker-compose exec app bash
./verificar_importaciones.sh
```

Esto te dirá:
- ✓ Cuántas transcripciones ya están importadas
- ⚠ Cuántas faltan
- ✗ Si hay notas de Obsidian importadas (probablemente 0)

### Paso 3: Importar Transcripciones Faltantes

#### 3a. Dry-run (recomendado primero)
```bash
docker-compose exec app php artisan import:contenido-seminario \
  --solo-transcripciones \
  --dry-run
```

**Verifica:**
- Que se detecten las 86 transcripciones
- Que se parsee correctamente el nombre
- Que se vincule a encuentro/materia correctos

#### 3b. Importación Real
```bash
docker-compose exec app php artisan import:contenido-seminario \
  --solo-transcripciones
```

**Progreso:**
```
╔═══════════════════════════════════════╗
║  IMPORTACIÓN DE CONTENIDO SEMINARIO  ║
╚═══════════════════════════════════════╝

📁 Escaneando archivos...

📊 Archivos encontrados:

  ✓ 86 transcripciones
  ✓ 84 videos
  ✓ 2 calendarios
  ✓ 227 notas de Obsidian

Total a procesar: 86 archivos

¿Continuar con la importación? (yes/no) [yes]:
```

### Paso 4: Importar Notas de Obsidian

#### 4a. Dry-run con límite (probar con 10 primeras)
```bash
docker-compose exec app php artisan import:contenido-seminario \
  --solo-notas \
  --dry-run \
  --limit=10
```

**Verifica:**
- Que se lean correctamente los `.md`
- Que se detecten wikilinks `[[...]]`
- Que se vinculen a materias cuando sea posible
- Que se extraigan etiquetas sugeridas

#### 4b. Importación completa
```bash
docker-compose exec app php artisan import:contenido-seminario \
  --solo-notas
```

### Paso 5: Verificar Resultados
```bash
./verificar_importaciones.sh

# O consultar directamente
docker-compose exec app php artisan tinker
>>> App\Models\Recurso::count()
>>> App\Models\Recurso::where('tipo', 'transcripcion')->count()
>>> App\Models\Recurso::where('tipo', 'material_estudio')->count()
```

## 🎯 Tipos de Recursos

| Tipo | Descripción | Archivos Fuente |
|------|-------------|-----------------|
| `transcripcion` | Transcripciones automáticas de clases | `*_transcripcion.txt` |
| `video` | Referencias a videos (sin copiar archivo) | `*.MOV` |
| `material_estudio` | Notas personales de Obsidian | `*.md` |

## 📝 Metadata Preservada

### Transcripciones
```json
{
  "archivo_original": "PE_AT_C01_GP_transcripcion.txt",
  "numero_clase": 1,
  "ruta_original": "/data/seminario/...",
  "video_original": "PE_AT_C01_GP.MOV"
}
```

### Notas Obsidian
```json
{
  "archivo_original": "Agustín de Hipona.md",
  "ruta_original": "/data/seminario/Apuntes_Obsidian/...",
  "fuente": "obsidian",
  "tiene_wikilinks": true,
  "etiquetas_sugeridas": ["resumen", "guía"]
}
```

## 🔍 Vinculación Inteligente

### Transcripciones
- **Automática** vía nomenclatura: `PE_AT_C01_GP`
  - `PE` → Primer Encuentro
  - `AT` → Antiguo Testamento
  - `C01` → Clase 1
  - `GP` → Profesor

### Notas Obsidian
- **Heurística** basada en contenido y título:
  - Busca keywords: "antiguo testamento", "nuevo testamento", etc.
  - Detecta menciones: "Primer Encuentro", "PE", "Segundo"
  - Si no encuentra: `encuentro_id` y `materia_id` = `null`

## ⚠️ Consideraciones Importantes

### Duplicados
- El sistema verifica `metadata->archivo_original` antes de importar
- Si ya existe, lo omite automáticamente
- Puedes re-ejecutar el comando sin miedo a duplicados

### Transacciones
- Cada importación usa transacciones DB implícitas
- Si falla un archivo, continúa con el siguiente
- Se registra en logs: `storage/logs/importacion_*.log`

### Backup
- El comando crea backup automático antes de importar (si no es dry-run)
- Ubicación: `storage/backups/db_backup_*.sql`

### Wikilinks de Obsidian
- Se preservan tal cual: `[[Confesiones de Agustin de Hipona]]`
- No se convierten a enlaces de la app (por ahora)
- Metadata indica si tiene wikilinks para futura implementación

## 🚀 Comando Rápido (Todo de una vez)

```bash
# Importar TODO (transcripciones + videos + calendarios + notas)
docker-compose exec app php artisan import:contenido-seminario
```

## 📊 Logs y Reportes

### Log de importación
```bash
tail -f storage/logs/importacion_*.log
```

### Estadísticas finales
Al finalizar, el comando muestra:
```
╔═══════════════════════════════════════╗
║          IMPORTACIÓN COMPLETA         ║
╚═══════════════════════════════════════╝

📊 Resultados:

  ✓ Procesados: 313
  ✓ Exitosos: 311
  ⚠️  Omitidos: 2
  ❌ Errores: 0
  📝 Tareas detectadas: 0

📝 Log detallado: /var/www/html/storage/logs/importacion_2025-10-02_163000.log
```

## 🐛 Troubleshooting

### Error: "Encuentro PE no encontrado en BD"
**Solución:** Ejecutar seeders primero:
```bash
docker-compose exec app php artisan db:seed
```

### Error: "Cannot connect to Docker daemon"
**Solución:** Inicia Docker Desktop primero

### Notas no se vinculan a ninguna materia
**Normal:** Si el contenido/título no menciona palabras clave, quedará sin vincular
**Solución manual:** Editar desde la interfaz web después

### Transcripciones muy largas causan timeout
**Solución:** Aumentar límite PHP en `php.ini`:
```ini
max_execution_time = 300
memory_limit = 512M
```

## 📞 Soporte

Si encuentras problemas:
1. Revisa logs: `storage/logs/laravel.log`
2. Ejecuta con `--dry-run` primero
3. Usa `--limit=5` para probar con pocos archivos
4. Verifica permisos de archivos fuente

---

**Última actualización:** 2025-10-02
**Versión del importador:** 2.0 (con soporte Obsidian)
