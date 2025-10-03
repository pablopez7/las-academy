<?php

namespace App\Services;

use App\Models\Encuentro;
use App\Models\Materia;
use App\Models\Recurso;
use App\Models\Tarea;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImportadorTranscripciones
{
    private DetectorTareas $detectorTareas;
    private array $stats = [
        'procesados' => 0,
        'exitosos' => 0,
        'omitidos' => 0,
        'errores' => 0,
        'tareas_detectadas' => 0,
    ];

    private array $mapeoMaterias = [
        'AT' => 'antiguo-testamento',
        'NT' => 'nuevo-testamento',
        'HM' => 'hermeneutica',
        'HC' => 'historia-cristianismo',
        'EC' => 'eclesiologia',
        'EV' => 'evangelismo',
        'TS' => 'teologia-sistematica',
    ];

    private array $mapeoEncuentros = [
        'PE' => 1,
        'SE' => 2,
    ];

    public function __construct(DetectorTareas $detectorTareas)
    {
        $this->detectorTareas = $detectorTareas;
    }

    /**
     * Escanea y retorna lista de archivos a importar
     */
    public function escanearArchivos(string $baseDir): array
    {
        $archivos = [
            'transcripciones' => [],
            'videos' => [],
            'calendarios' => [],
            'notas_obsidian' => [],
        ];

        // Escanear Primer y Segundo Encuentro
        foreach (['Primer_Encuentro', 'Segundo_Encuentro'] as $encuentro) {
            $encuentroPath = "$baseDir/$encuentro";

            if (!File::isDirectory($encuentroPath)) {
                continue;
            }

            // Buscar transcripciones
            $transcripciones = File::glob("$encuentroPath/**/*_transcripcion.txt");
            $archivos['transcripciones'] = array_merge($archivos['transcripciones'], $transcripciones);

            // Buscar videos
            $videos = File::glob("$encuentroPath/**/*.MOV");
            $archivos['videos'] = array_merge($archivos['videos'], $videos);

            // Buscar calendarios
            $calendarios = File::glob("$encuentroPath/*.jpg");
            $archivos['calendarios'] = array_merge($archivos['calendarios'], $calendarios);
        }

        // Escanear notas de Obsidian
        $obsidianPath = "$baseDir/Apuntes_Obsidian";
        if (File::isDirectory($obsidianPath)) {
            $notasObsidian = File::glob("$obsidianPath/*.md");
            $archivos['notas_obsidian'] = $notasObsidian;
        }

        return $archivos;
    }

    /**
     * Parsea el nombre de archivo y extrae metadata
     */
    public function parsearNombreArchivo(string $nombreArchivo): ?array
    {
        // Formato: PE_AT_C01_GP_transcripcion.txt
        // O: SE_NT_C03_XX_transcripcion.txt

        $patron = '/^(PE|SE)_(AT|NT|HM|HC|EC|EV|TS)_C(\d+)_([A-Z]{2})/i';

        if (preg_match($patron, $nombreArchivo, $matches)) {
            return [
                'encuentro_codigo' => strtoupper($matches[1]),
                'materia_codigo' => strtoupper($matches[2]),
                'numero_clase' => (int) $matches[3],
                'profesor' => strtoupper($matches[4]),
            ];
        }

        return null;
    }

    /**
     * Importa una transcripción
     */
    public function importarTranscripcion(
        string $archivoPath,
        bool $detectarTareas = true,
        bool $dryRun = false
    ): array {
        $this->stats['procesados']++;

        $nombreArchivo = basename($archivoPath);
        $metadata = $this->parsearNombreArchivo($nombreArchivo);

        if (!$metadata) {
            $this->stats['omitidos']++;
            return [
                'exito' => false,
                'razon' => 'No se pudo parsear el nombre del archivo',
                'archivo' => $nombreArchivo,
            ];
        }

        // Buscar encuentro
        $encuentroNumero = $this->mapeoEncuentros[$metadata['encuentro_codigo']] ?? null;
        $encuentro = Encuentro::where('numero', $encuentroNumero)->first();

        if (!$encuentro) {
            $this->stats['omitidos']++;
            return [
                'exito' => false,
                'razon' => "Encuentro {$metadata['encuentro_codigo']} no encontrado en BD",
                'archivo' => $nombreArchivo,
            ];
        }

        // Buscar materia
        $materiaSlug = $this->mapeoMaterias[$metadata['materia_codigo']] ?? null;
        $materia = Materia::where('slug', $materiaSlug)->first();

        if (!$materia) {
            $this->stats['omitidos']++;
            return [
                'exito' => false,
                'razon' => "Materia {$metadata['materia_codigo']} no encontrada en BD",
                'archivo' => $nombreArchivo,
            ];
        }

        // Verificar si ya existe
        $existe = Recurso::where('encuentro_id', $encuentro->id)
            ->where('materia_id', $materia->id)
            ->where('metadata->archivo_original', $nombreArchivo)
            ->exists();

        if ($existe) {
            $this->stats['omitidos']++;
            return [
                'exito' => false,
                'razon' => 'Ya existe en la base de datos',
                'archivo' => $nombreArchivo,
            ];
        }

        // Leer contenido
        $contenido = File::get($archivoPath);

        if (empty($contenido)) {
            $this->stats['omitidos']++;
            return [
                'exito' => false,
                'razon' => 'Archivo vacío',
                'archivo' => $nombreArchivo,
            ];
        }

        // Generar título
        $titulo = $this->generarTitulo($metadata, $materia->nombre);

        $resultado = [
            'exito' => true,
            'archivo' => $nombreArchivo,
            'encuentro' => $encuentro->nombre,
            'materia' => $materia->nombre,
            'profesor' => $metadata['profesor'],
            'titulo' => $titulo,
            'tareas_detectadas' => 0,
        ];

        if ($dryRun) {
            return $resultado;
        }

        try {
            // Crear recurso
            $recurso = Recurso::create([
                'encuentro_id' => $encuentro->id,
                'materia_id' => $materia->id,
                'tipo' => 'transcripcion',
                'titulo' => $titulo,
                'descripcion' => $this->generarDescripcion($metadata, $encuentro->nombre, $materia->nombre),
                'contenido' => $contenido,
                'profesor' => $metadata['profesor'],
                'metadata' => [
                    'archivo_original' => $nombreArchivo,
                    'numero_clase' => $metadata['numero_clase'],
                    'ruta_original' => $archivoPath,
                ],
                'visible' => true,
                'orden' => $metadata['numero_clase'],
            ]);

            $this->stats['exitosos']++;

            // Detectar tareas si está habilitado
            if ($detectarTareas) {
                $tareasDetectadas = $this->detectorTareas->detectarTareas($contenido);

                foreach ($tareasDetectadas as $tareaData) {
                    $this->crearTarea($tareaData, $encuentro, $materia, $recurso);
                    $this->stats['tareas_detectadas']++;
                    $resultado['tareas_detectadas']++;
                }
            }

            $resultado['recurso_id'] = $recurso->id;

            Log::info("Transcripción importada: $nombreArchivo", $resultado);

            return $resultado;
        } catch (\Exception $e) {
            $this->stats['errores']++;

            Log::error("Error importando $nombreArchivo", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'exito' => false,
                'razon' => 'Error al guardar: ' . $e->getMessage(),
                'archivo' => $nombreArchivo,
            ];
        }
    }

    /**
     * Importa referencia a un video (sin copiar el archivo)
     */
    public function referenciarVideo(string $videoPath): array
    {
        $nombreArchivo = basename($videoPath);
        $nombreSinExt = str_replace('.MOV', '', $nombreArchivo);

        // Buscar la transcripción correspondiente
        $recurso = Recurso::where('metadata->archivo_original', 'like', "%$nombreSinExt%")
            ->first();

        if (!$recurso) {
            return [
                'exito' => false,
                'razon' => 'No se encontró transcripción correspondiente',
                'archivo' => $nombreArchivo,
            ];
        }

        // Actualizar recurso con ruta de video
        $recurso->archivo_ruta = $videoPath;
        $metadata = $recurso->metadata;
        $metadata['video_original'] = $nombreArchivo;
        $recurso->metadata = $metadata;
        $recurso->save();

        return [
            'exito' => true,
            'archivo' => $nombreArchivo,
            'vinculado_con' => $recurso->titulo,
        ];
    }

    /**
     * Importa calendario
     */
    public function importarCalendario(string $calendarioPath, string $storageDir): array
    {
        $nombreArchivo = basename($calendarioPath);

        // Determinar encuentro
        $encuentroNumero = str_contains($nombreArchivo, 'Primer') ? 1 : 2;
        $encuentro = Encuentro::where('numero', $encuentroNumero)->first();

        if (!$encuentro) {
            return [
                'exito' => false,
                'razon' => 'Encuentro no encontrado',
                'archivo' => $nombreArchivo,
            ];
        }

        // Copiar archivo a storage
        $destino = "$storageDir/calendarios/$nombreArchivo";
        $directorioDestino = dirname($destino);

        if (!File::isDirectory($directorioDestino)) {
            File::makeDirectory($directorioDestino, 0755, true);
        }

        File::copy($calendarioPath, $destino);

        // Actualizar encuentro
        $encuentro->imagen_calendario = "calendarios/$nombreArchivo";
        $encuentro->save();

        return [
            'exito' => true,
            'archivo' => $nombreArchivo,
            'encuentro' => $encuentro->nombre,
            'ruta' => $destino,
        ];
    }

    /**
     * Crea una tarea detectada
     */
    private function crearTarea(array $tareaData, Encuentro $encuentro, Materia $materia, Recurso $recurso): void
    {
        Tarea::create([
            'encuentro_id' => $encuentro->id,
            'materia_id' => $materia->id,
            'titulo' => $tareaData['titulo'],
            'descripcion' => $tareaData['descripcion'],
            'instrucciones' => $tareaData['instrucciones'],
            'puntos_totales' => 100,
            'rubrica' => $tareaData['rubrica'],
            'visible' => true,
        ]);

        Log::info("Tarea detectada y creada", [
            'tarea' => $tareaData['titulo'],
            'desde_recurso' => $recurso->titulo,
        ]);
    }

    /**
     * Genera título descriptivo
     */
    private function generarTitulo(array $metadata, string $materia): string
    {
        $clase = str_pad($metadata['numero_clase'], 2, '0', STR_PAD_LEFT);
        return "$materia - Clase $clase";
    }

    /**
     * Genera descripción
     */
    private function generarDescripcion(array $metadata, string $encuentro, string $materia): string
    {
        $clase = $metadata['numero_clase'];
        $profesor = $metadata['profesor'];

        return "Transcripción de la clase $clase de $materia, impartida en el $encuentro. Profesor: $profesor.";
    }

    /**
     * Retorna estadísticas de importación
     */
    public function obtenerEstadisticas(): array
    {
        return $this->stats;
    }

    /**
     * Reinicia estadísticas
     */
    public function reiniciarEstadisticas(): void
    {
        $this->stats = [
            'procesados' => 0,
            'exitosos' => 0,
            'omitidos' => 0,
            'errores' => 0,
            'tareas_detectadas' => 0,
        ];
    }

    /**
     * Importa una nota de Obsidian como material de estudio
     */
    public function importarNotaObsidian(string $archivoPath, bool $dryRun = false): array
    {
        $this->stats['procesados']++;

        $nombreArchivo = basename($archivoPath);
        $nombreSinExtension = str_replace('.md', '', $nombreArchivo);

        // Verificar si ya existe
        $existe = Recurso::where('tipo', 'material_estudio')
            ->where('metadata->archivo_original', $nombreArchivo)
            ->exists();

        if ($existe) {
            $this->stats['omitidos']++;
            return [
                'exito' => false,
                'razon' => 'Ya existe en la base de datos',
                'archivo' => $nombreArchivo,
            ];
        }

        // Leer contenido
        $contenido = File::get($archivoPath);

        if (empty($contenido)) {
            $this->stats['omitidos']++;
            return [
                'exito' => false,
                'razon' => 'Archivo vacío',
                'archivo' => $nombreArchivo,
            ];
        }

        // Extraer primera línea como descripción
        $lineas = explode("\n", $contenido);
        $primeraLinea = trim($lineas[0] ?? '');
        $descripcion = mb_substr(strip_tags($primeraLinea), 0, 200);

        $resultado = [
            'exito' => true,
            'archivo' => $nombreArchivo,
            'titulo' => $nombreSinExtension,
        ];

        if ($dryRun) {
            return $resultado;
        }

        try {
            // Intentar vincular a materia/encuentro basado en contenido
            $vinculacion = $this->detectarVinculacionNota($contenido, $nombreSinExtension);

            // Crear recurso
            $recurso = Recurso::create([
                'encuentro_id' => $vinculacion['encuentro_id'],
                'materia_id' => $vinculacion['materia_id'],
                'tipo' => 'material_estudio',
                'titulo' => $nombreSinExtension,
                'descripcion' => $descripcion ?: 'Material de estudio complementario',
                'contenido' => $contenido,
                'profesor' => null,
                'metadata' => [
                    'archivo_original' => $nombreArchivo,
                    'ruta_original' => $archivoPath,
                    'fuente' => 'obsidian',
                    'tiene_wikilinks' => $this->detectarWikilinks($contenido),
                    'etiquetas_sugeridas' => $this->extraerEtiquetasSugeridas($contenido),
                ],
                'visible' => true,
                'orden' => 999, // Al final por defecto
            ]);

            $this->stats['exitosos']++;
            $resultado['recurso_id'] = $recurso->id;

            Log::info("Nota Obsidian importada: $nombreArchivo", $resultado);

            return $resultado;
        } catch (\Exception $e) {
            $this->stats['errores']++;

            Log::error("Error importando nota $nombreArchivo", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'exito' => false,
                'razon' => 'Error al guardar: ' . $e->getMessage(),
                'archivo' => $nombreArchivo,
            ];
        }
    }

    /**
     * Detecta vinculación de nota con materia/encuentro basado en contenido
     */
    private function detectarVinculacionNota(string $contenido, string $titulo): array
    {
        $encuentroId = null;
        $materiaId = null;

        // Buscar menciones a materias en el título o contenido
        $materiasKeywords = [
            'antiguo testamento' => 'antiguo-testamento',
            'nuevo testamento' => 'nuevo-testamento',
            'hermeneutica' => 'hermeneutica',
            'historia' => 'historia-cristianismo',
            'eclesiologia' => 'eclesiologia',
            'evangelismo' => 'evangelismo',
            'teologia' => 'teologia-sistematica',
        ];

        $tituloLower = mb_strtolower($titulo . ' ' . $contenido);

        foreach ($materiasKeywords as $keyword => $slug) {
            if (str_contains($tituloLower, $keyword)) {
                $materia = Materia::where('slug', $slug)->first();
                if ($materia) {
                    $materiaId = $materia->id;
                    break;
                }
            }
        }

        // Buscar menciones a encuentros
        if (preg_match('/(primer|1er|PE)/i', $tituloLower)) {
            $encuentro = Encuentro::where('numero', 1)->first();
            if ($encuentro) {
                $encuentroId = $encuentro->id;
            }
        } elseif (preg_match('/(segundo|2do|SE)/i', $tituloLower)) {
            $encuentro = Encuentro::where('numero', 2)->first();
            if ($encuentro) {
                $encuentroId = $encuentro->id;
            }
        }

        return [
            'encuentro_id' => $encuentroId,
            'materia_id' => $materiaId,
        ];
    }

    /**
     * Detecta si el contenido tiene wikilinks de Obsidian
     */
    private function detectarWikilinks(string $contenido): bool
    {
        return str_contains($contenido, '[[') && str_contains($contenido, ']]');
    }

    /**
     * Extrae etiquetas sugeridas del contenido
     */
    private function extraerEtiquetasSugeridas(string $contenido): array
    {
        $etiquetas = [];

        // Detectar headings importantes
        if (preg_match('/^#+ (.+)/m', $contenido)) {
            $etiquetas[] = 'resumen';
        }

        // Detectar listas
        if (preg_match('/^[\-\*]\s/m', $contenido)) {
            $etiquetas[] = 'guía';
        }

        // Detectar citas
        if (preg_match('/^>/m', $contenido)) {
            $etiquetas[] = 'citas';
        }

        // Detectar código
        if (str_contains($contenido, '```')) {
            $etiquetas[] = 'ejemplo';
        }

        return array_unique($etiquetas);
    }
}
