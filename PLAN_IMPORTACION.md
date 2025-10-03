# 📋 Plan de Importación de Datos - LAS Academy

## 📊 Inventario Actual de Contenido

### Encuentros
- **Primer Encuentro**: 41 transcripciones + 41 videos + 1 calendario
- **Segundo Encuentro**: 44 transcripciones + 42 videos + 1 calendario

### Contenido Adicional
- **Apuntes Obsidian**: 227 archivos Markdown

### Total General
- 📝 **86 Transcripciones**
- 🎥 **84 Videos**
- 📅 **2 Calendarios**
- 📓 **227 Apuntes en Markdown**

---

## 🎯 Propuesta de Organización en el Sistema

### 1. Estructura de Base de Datos

#### **Encuentros** (Ya creados)
- Primer Encuentro
- Segundo Encuentro
- Encuentro 3-6 (placeholders para futuro)

#### **Materias** (Ya creadas)
1. Antiguo Testamento
2. Nuevo Testamento
3. Hermenéutica
4. Historia del Cristianismo
5. Eclesiología
6. Evangelismo
7. Teología Sistemática

#### **Tipos de Recursos**

```
📝 Transcripciones (86)
   └─ Extraídas de archivos *_transcripcion.txt
   └─ Vinculadas a encuentro + materia
   └─ Contenido completo indexado para búsqueda

🎥 Videos (84)
   └─ Archivos .MOV almacenados
   └─ Referencia a transcripción correspondiente
   └─ Metadata: duración, profesor, fecha

📅 Calendarios (2)
   └─ Imágenes JPG
   └─ Asociados a cada encuentro

📓 Apuntes Obsidian (227)
   └─ Material de apoyo complementario
   └─ Organizados por tema
   └─ Enlaces internos preservados
```

---

## 🔄 Proceso de Importación Propuesto

### Fase 1: Transcripciones y Videos
**¿Qué se hará?**
- ✅ **COPIAR** (no mover) archivos a carpeta del sistema
- ✅ Leer cada transcripción y extraer metadata del nombre:
  ```
  PE_AT_C01_GP_transcripcion.txt
  └─ PE = Primer Encuentro
  └─ AT = Antiguo Testamento
  └─ C01 = Clase 01
  └─ GP = Profesor (iniciales)
  ```
- ✅ Crear recursos en BD vinculados a encuentro + materia
- ✅ Vincular videos con sus transcripciones
- ✅ Preservar archivos originales intactos

**Ubicación en sistema:**
```
las-academy/
└── storage/
    └── app/
        └── recursos/
            ├── primer-encuentro/
            │   ├── antiguo-testamento/
            │   │   ├── PE_AT_C01_GP_transcripcion.txt
            │   │   └── PE_AT_C01_GP.MOV
            │   └── ...
            └── segundo-encuentro/
                └── ...
```

### Fase 2: Calendarios
- ✅ COPIAR imágenes a `storage/app/public/calendarios/`
- ✅ Asociar a cada encuentro en BD
- ✅ Mostrar en página de encuentro

### Fase 3: Apuntes Obsidian
**Opciones:**

**Opción A: Importar todo (Recomendada)**
- Material de apoyo complementario
- Categorizar por temas detectados
- Preservar enlaces de Obsidian

**Opción B: Importar selectivamente**
- Solo apuntes relacionados con materias del seminario
- Dejar fuera notas personales

---

## 🎨 Detección de Metadata

### De los nombres de archivo podemos extraer:

```python
Ejemplo: PE_AT_C01_GP_transcripcion.txt

Encuentro: PE (Primer) / SE (Segundo)
Materia: AT, NT, HM, HC, EC, EV, TS
Clase: C01, C02, etc.
Profesor: GP, XX (iniciales)
```

### Mapeo de Códigos a Materias:

| Código | Materia |
|--------|---------|
| AT | Antiguo Testamento |
| NT | Nuevo Testamento |
| HM | Hermenéutica |
| HC | Historia del Cristianismo |
| EC | Eclesiología |
| EV | Evangelismo |
| TS | Teología Sistemática |

---

## ✅ Seguridad y Respaldo

### Garantías:
1. ✅ **Solo COPIAS** - Archivos originales permanecen intactos
2. ✅ **Log detallado** - Reporte de cada archivo procesado
3. ✅ **Validación previa** - Mostrar plan antes de ejecutar
4. ✅ **Reversible** - Poder limpiar BD y reimportar si es necesario

---

## 🚀 Siguiente Paso

**¿Te parece bien esta organización?**

Puntos a confirmar:

1. ✅ ¿Importar los 227 apuntes de Obsidian como material de apoyo?
2. ✅ ¿Los videos deben estar disponibles para descarga o solo referenciados?
3. ✅ ¿Hay alguna información adicional que quieras capturar? (profesores, fechas específicas, etc.)

Una vez confirmes, crearé el script que:
1. Muestra un resumen de lo que va a importar
2. Pide confirmación
3. Ejecuta la importación
4. Genera reporte de resultados

---

## 📝 Notas Importantes

- **Espacio en disco**: Los videos ocupan ~35GB por encuentro
  - **Opción 1**: Copiar videos al sistema (requiere espacio)
  - **Opción 2**: Solo referenciar ubicación original
  - **Opción 3**: Subir a cloud y guardar links

- **Apuntes Obsidian**: Pueden tener enlaces internos [[nota]]
  - Preservaremos el formato Markdown
  - Los enlaces se pueden convertir a links internos del sistema

---

**¿Procedemos con esta estructura?**
