#!/bin/bash

# Script para verificar estado de importaciones
# Compara archivos fuente vs registros en BD

echo "╔═══════════════════════════════════════════╗"
echo "║  VERIFICADOR DE IMPORTACIONES SEMINARIO   ║"
echo "╚═══════════════════════════════════════════╝"
echo ""

# Colores
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

BASE_DIR="/data/seminario"

# 1. Contar archivos fuente
echo -e "${CYAN}📁 Escaneando archivos fuente...${NC}"
echo ""

TRANSCRIPCIONES_PE=$(find "$BASE_DIR/Primer_Encuentro" -name "*_transcripcion.txt" 2>/dev/null | wc -l)
TRANSCRIPCIONES_SE=$(find "$BASE_DIR/Segundo_Encuentro" -name "*_transcripcion.txt" 2>/dev/null | wc -l)
TOTAL_TRANSCRIPCIONES=$((TRANSCRIPCIONES_PE + TRANSCRIPCIONES_SE))

NOTAS_OBSIDIAN=$(find "$BASE_DIR/Apuntes_Obsidian" -name "*.md" 2>/dev/null | wc -l)

echo -e "  ${GREEN}✓${NC} Transcripciones Primer Encuentro:  $TRANSCRIPCIONES_PE"
echo -e "  ${GREEN}✓${NC} Transcripciones Segundo Encuentro: $TRANSCRIPCIONES_SE"
echo -e "  ${GREEN}✓${NC} Total transcripciones:             $TOTAL_TRANSCRIPCIONES"
echo -e "  ${GREEN}✓${NC} Notas Obsidian disponibles:        $NOTAS_OBSIDIAN"
echo ""

# 2. Consultar recursos importados
echo -e "${CYAN}💾 Consultando base de datos...${NC}"
echo ""

RECURSOS_IMPORTADOS=$(docker-compose exec -T app php artisan tinker --execute="echo App\Models\Recurso::count();" 2>/dev/null | tail -1)
TRANSCRIPCIONES_IMPORTADAS=$(docker-compose exec -T app php artisan tinker --execute="echo App\Models\Recurso::where('tipo', 'transcripcion')->count();" 2>/dev/null | tail -1)
MATERIALES_IMPORTADOS=$(docker-compose exec -T app php artisan tinker --execute="echo App\Models\Recurso::where('tipo', 'material_estudio')->count();" 2>/dev/null | tail -1)

echo -e "  ${GREEN}✓${NC} Total recursos en BD:              $RECURSOS_IMPORTADOS"
echo -e "  ${GREEN}✓${NC} Transcripciones importadas:        $TRANSCRIPCIONES_IMPORTADAS"
echo -e "  ${GREEN}✓${NC} Material de estudio importado:     $MATERIALES_IMPORTADOS"
echo ""

# 3. Comparación
echo -e "${CYAN}📊 Análisis de completitud:${NC}"
echo ""

TRANS_FALTANTES=$((TOTAL_TRANSCRIPCIONES - TRANSCRIPCIONES_IMPORTADAS))
NOTAS_FALTANTES=$((NOTAS_OBSIDIAN - MATERIALES_IMPORTADOS))

if [ $TRANS_FALTANTES -eq 0 ]; then
    echo -e "  ${GREEN}✓ Todas las transcripciones están importadas${NC}"
else
    echo -e "  ${YELLOW}⚠ Faltan $TRANS_FALTANTES transcripciones por importar${NC}"
fi

if [ $MATERIALES_IMPORTADOS -eq 0 ]; then
    echo -e "  ${RED}✗ No hay notas de Obsidian importadas aún${NC}"
else
    echo -e "  ${GREEN}✓ $MATERIALES_IMPORTADOS notas importadas de $NOTAS_OBSIDIAN disponibles${NC}"
fi

echo ""

# 4. Listar archivos específicos faltantes
if [ $TRANS_FALTANTES -gt 0 ]; then
    echo -e "${CYAN}📝 Listando transcripciones faltantes...${NC}"
    echo ""

    # Crear lista temporal de archivos fuente
    find "$BASE_DIR/Primer_Encuentro" "$BASE_DIR/Segundo_Encuentro" -name "*_transcripcion.txt" > /tmp/archivos_fuente.txt

    # Obtener lista de archivos importados
    docker-compose exec -T app php artisan tinker --execute="
        \$recursos = App\Models\Recurso::where('tipo', 'transcripcion')->get();
        foreach (\$recursos as \$r) {
            if (isset(\$r->metadata['archivo_original'])) {
                echo \$r->metadata['archivo_original'] . PHP_EOL;
            }
        }
    " 2>/dev/null | grep -v "^>" > /tmp/archivos_importados.txt

    echo -e "  ${YELLOW}Transcripciones disponibles pero no importadas:${NC}"

    while IFS= read -r archivo_path; do
        nombre_archivo=$(basename "$archivo_path")
        if ! grep -q "$nombre_archivo" /tmp/archivos_importados.txt 2>/dev/null; then
            echo "    - $nombre_archivo"
        fi
    done < /tmp/archivos_fuente.txt

    rm -f /tmp/archivos_fuente.txt /tmp/archivos_importados.txt
    echo ""
fi

# 5. Resumen final
echo "╔═══════════════════════════════════════════╗"
echo "║              RESUMEN FINAL                ║"
echo "╚═══════════════════════════════════════════╝"
echo ""
echo -e "  Transcripciones: ${TRANSCRIPCIONES_IMPORTADAS}/${TOTAL_TRANSCRIPCIONES} ($(( TRANSCRIPCIONES_IMPORTADAS * 100 / TOTAL_TRANSCRIPCIONES ))%)"
echo -e "  Material estudio: ${MATERIALES_IMPORTADOS}/${NOTAS_OBSIDIAN} ($(( MATERIALES_IMPORTADOS * 100 / NOTAS_OBSIDIAN ))%)"
echo ""

if [ $TRANS_FALTANTES -gt 0 ]; then
    echo -e "${YELLOW}💡 Sugerencia: Ejecuta 'php artisan import:contenido-seminario' para importar faltantes${NC}"
    echo ""
fi
