# 📊 Cómo Importar tus Datos Existentes

Este documento explica cómo importar las transcripciones y materiales que ya tienes en el proyecto al sistema LAS Academy.

## 📁 Datos Disponibles

Tienes los siguientes datos en tu proyecto:

### Primer Encuentro
```
/Users/pablopez/Seminario Letra al que Sirve/Primer_Encuentro/
├── Antiguo_Testamento/
├── Nuevo_Testamento/
├── Hermeneutica/
├── Historia_Cristianismo/
├── Eclesiologia/
├── Evangelismo/
└── Calendario_Primer_Encuentro.jpg
```

### Segundo Encuentro
```
/Users/pablopez/Seminario Letra al que Sirve/Segundo_Encuentro/
├── Antiguo_Testamento/
├── Nuevo_Testamento/
├── Hermeneutica/
├── Historia_Cristianismo/
├── Eclesiologia/
├── Evangelismo/
├── Teologia_Sistematica/
└── Calendario_Segundo_Encuentro.jpg
```

---

## 🔄 Opción 1: Script Automático de Importación

Voy a crear un comando de Laravel para importar automáticamente todos tus archivos:

```bash
# Ejecutar el importador
./artisan.sh import:recursos
```

Este comando:
1. Lee todos los archivos de texto en las carpetas de encuentros
2. Los asocia a la materia correcta según el nombre de la carpeta
3. Crea recursos en la base de datos con el contenido
4. Importa las imágenes de calendarios

---

## 🔄 Opción 2: Importación Manual

Si prefieres hacerlo manualmente, puedes usar PhpMyAdmin:

1. Abre http://localhost:8080
2. Usuario: `las_user`, Contraseña: `las_password`
3. Selecciona la base de datos `las_academy`
4. Ve a la tabla `recursos`
5. Inserta nuevos registros

---

## 📝 Formato de los Recursos

Cada recurso debe tener:

- **encuentro_id**: 1 o 2 (según el encuentro)
- **materia_id**: ID de la materia (ver tabla `materias`)
- **tipo**: 'transcripcion', 'rubrica', 'resumen', 'material_apoyo'
- **titulo**: Nombre del archivo o título descriptivo
- **contenido**: El texto del archivo
- **visible**: true

---

## 🎯 Script de Importación (Próximamente)

Puedo crear un script personalizado que:

1. Lee todos tus archivos `.txt` y `.md`
2. Los categoriza por materia según el nombre de carpeta
3. Los importa automáticamente a la base de datos
4. Copia las imágenes al directorio público

**¿Quieres que cree este script automático de importación?**

---

## 📋 Mapeo de Carpetas a Materias

```
Antiguo_Testamento      → materia_id: 1
Nuevo_Testamento        → materia_id: 2
Hermeneutica           → materia_id: 3
Historia_Cristianismo  → materia_id: 4
Eclesiologia          → materia_id: 5
Evangelismo           → materia_id: 6
Teologia_Sistematica  → materia_id: 7
```

---

## 🔍 Ver los IDs de las Materias

Para ver los IDs de las materias en la base de datos:

```bash
./db.sh
```

Luego en MySQL:
```sql
SELECT id, nombre FROM materias;
```

---

## 💾 Backup de Datos

Antes de importar, puedes hacer backup de la BD:

```bash
docker-compose exec mysql mysqldump -u las_user -plas_password las_academy > backup.sql
```

Para restaurar:
```bash
docker-compose exec -T mysql mysql -u las_user -plas_password las_academy < backup.sql
```

---

## ✅ Próximos Pasos

1. Revisa la estructura de tus archivos existentes
2. Decide si quieres importación automática o manual
3. Si quieres automático, puedo crear el comando `import:recursos`
4. Ejecuta la importación
5. Verifica los datos en http://localhost

¿Necesitas que cree el script de importación automático? Solo dime y lo programo para ti.
