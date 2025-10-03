<?php

namespace App\Services;

class DetectorTareas
{
    /**
     * Patrones para detectar menciones de tareas
     */
    private array $patrones = [
        // Frases directas
        '/para\s+(?:la\s+)?pr[oó]xima\s+(?:clase|sesi[oó]n|encuentro)/iu',
        '/tarea\s+para\s+(?:el|la)\s+(?:siguiente|pr[oó]ximo)/iu',
        '/deben\s+entregar/iu',
        '/tienen\s+que\s+(?:hacer|elaborar|preparar|investigar)/iu',
        '/trabajo\s+(?:final|pr[aá]ctico|de\s+investigaci[oó]n)/iu',
        '/investigaci[oó]n\s+sobre/iu',
        '/elaborar\s+un[ao]?\s+/iu',
        '/realizar\s+un[ao]?\s+/iu',
        '/preparar\s+un[ao]?\s+/iu',
        '/escribir\s+(?:un[ao]?|sobre)/iu',

        // Patrones de asignación
        '/les\s+(?:voy\s+a\s+)?(?:pedir|solicitar|asignar)/iu',
        '/van\s+a\s+(?:hacer|realizar|elaborar)/iu',
        '/necesito\s+que\s+(?:hagan|investiguen|preparen)/iu',

        // Entregas y fechas
        '/fecha\s+de\s+entrega/iu',
        '/entregar\s+(?:el|para|antes\s+del?)/iu',
        '/para\s+(?:el|la)\s+(?:lunes|martes|mi[eé]rcoles|jueves|viernes|s[aá]bado|domingo)/iu',

        // Requisitos
        '/requisitos?\s+(?:de\s+)?(?:la\s+)?tarea/iu',
        '/criterios?\s+de\s+evaluaci[oó]n/iu',
        '/debe\s+(?:incluir|contener|tener)/iu',
        '/m[ií]nimo\s+\d+\s+(?:p[aá]ginas?|palabras?|cuartillas?)/iu',
    ];

    /**
     * Palabras clave que indican tipo de trabajo
     */
    private array $tiposTrabajos = [
        'ensayo' => 'Ensayo',
        'investigación' => 'Investigación',
        'análisis' => 'Análisis',
        'resumen' => 'Resumen',
        'reporte' => 'Reporte',
        'reflexión' => 'Reflexión',
        'cuadro comparativo' => 'Cuadro Comparativo',
        'mapa conceptual' => 'Mapa Conceptual',
        'presentación' => 'Presentación',
        'exposición' => 'Exposición',
        'lectura' => 'Lectura',
        'estudio' => 'Estudio',
    ];

    /**
     * Detecta tareas mencionadas en una transcripción
     */
    public function detectarTareas(string $contenido): array
    {
        $tareas = [];
        $lineas = explode("\n", $contenido);

        // Buscar secciones que contengan menciones de tareas
        $seccionesTarea = $this->encontrarSeccionesTarea($lineas);

        foreach ($seccionesTarea as $seccion) {
            $tarea = $this->extraerInformacionTarea($seccion);
            if ($tarea) {
                $tareas[] = $tarea;
            }
        }

        return $tareas;
    }

    /**
     * Encuentra secciones del texto que mencionan tareas
     */
    private function encontrarSeccionesTarea(array $lineas): array
    {
        $secciones = [];
        $i = 0;

        while ($i < count($lineas)) {
            $lineaActual = $lineas[$i];

            // Verificar si esta línea menciona una tarea
            if ($this->contieneMencionTarea($lineaActual)) {
                // Capturar contexto (línea actual + 10 siguientes)
                $contexto = array_slice($lineas, $i, 15);
                $seccion = implode("\n", $contexto);

                // Evitar duplicados
                if (!$this->seccionYaCapturada($seccion, $secciones)) {
                    $secciones[] = $seccion;
                }

                $i += 10; // Saltar para evitar capturas duplicadas
            } else {
                $i++;
            }
        }

        return $secciones;
    }

    /**
     * Verifica si una línea contiene mención de tarea
     */
    private function contieneMencionTarea(string $linea): bool
    {
        foreach ($this->patrones as $patron) {
            if (preg_match($patron, $linea)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verifica si una sección ya fue capturada
     */
    private function seccionYaCapturada(string $seccion, array $secciones): bool
    {
        foreach ($secciones as $existente) {
            $similitud = similar_text($seccion, $existente, $porcentaje);
            if ($porcentaje > 70) { // 70% similar
                return true;
            }
        }
        return false;
    }

    /**
     * Extrae información estructurada de una sección que menciona tarea
     */
    private function extraerInformacionTarea(string $seccion): ?array
    {
        // Determinar tipo de trabajo
        $tipo = $this->detectarTipoTrabajo($seccion);

        // Generar título
        $titulo = $this->generarTitulo($seccion, $tipo);

        if (!$titulo) {
            return null; // No se pudo determinar tarea clara
        }

        // Extraer descripción e instrucciones
        $descripcion = $this->extraerDescripcion($seccion);
        $instrucciones = $this->extraerInstrucciones($seccion);

        // Extraer criterios de evaluación mencionados
        $rubrica = $this->extraerCriteriosEvaluacion($seccion);

        return [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'instrucciones' => $instrucciones,
            'rubrica' => $rubrica,
            'seccion_original' => $seccion,
        ];
    }

    /**
     * Detecta el tipo de trabajo mencionado
     */
    private function detectarTipoTrabajo(string $texto): ?string
    {
        $textoLower = mb_strtolower($texto);

        foreach ($this->tiposTrabajos as $palabra => $tipo) {
            if (stripos($textoLower, $palabra) !== false) {
                return $tipo;
            }
        }

        return 'Trabajo';
    }

    /**
     * Genera un título para la tarea
     */
    private function generarTitulo(string $seccion, string $tipo): ?string
    {
        // Buscar el tema principal después de la mención de tarea
        $patrones = [
            '/(?:sobre|acerca\s+de|relacionado\s+con)\s+([^.]{10,80})/iu',
            '/(?:de|del)\s+([A-ZÁÉÍÓÚ][^.]{10,60})/u',
            '/' . preg_quote($tipo, '/') . '\s+(?:sobre|de|del)\s+([^.]{10,60})/iu',
        ];

        foreach ($patrones as $patron) {
            if (preg_match($patron, $seccion, $matches)) {
                $tema = trim($matches[1]);
                // Limpiar el tema
                $tema = preg_replace('/\s+/', ' ', $tema);
                $tema = ucfirst(mb_strtolower($tema));

                return "$tipo: $tema";
            }
        }

        return "$tipo asignado";
    }

    /**
     * Extrae descripción general de la tarea
     */
    private function extraerDescripcion(string $seccion): string
    {
        // Tomar las primeras 2-3 oraciones relevantes
        $oraciones = preg_split('/[.!?]+/', $seccion);
        $descripcion = [];

        foreach ($oraciones as $oracion) {
            $oracion = trim($oracion);
            if (strlen($oracion) > 20 && count($descripcion) < 3) {
                $descripcion[] = $oracion;
            }
        }

        return implode('. ', $descripcion) . '.';
    }

    /**
     * Extrae instrucciones específicas mencionadas
     */
    private function extraerInstrucciones(string $seccion): string
    {
        $instrucciones = [];

        // Buscar requisitos específicos
        $patrones = [
            '/(?:debe|tienen\s+que|necesitan)\s+([^.]{20,100})/iu',
            '/(?:incluir|contener|tener)\s+([^.]{15,80})/iu',
            '/(?:m[ií]nimo|al\s+menos)\s+([^.]{10,50})/iu',
        ];

        foreach ($patrones as $patron) {
            if (preg_match_all($patron, $seccion, $matches)) {
                foreach ($matches[1] as $match) {
                    $match = trim($match);
                    if (strlen($match) > 15) {
                        $instrucciones[] = '- ' . ucfirst($match);
                    }
                }
            }
        }

        return $instrucciones ? implode("\n", array_unique($instrucciones)) : 'Seguir las indicaciones dadas en clase.';
    }

    /**
     * Extrae criterios de evaluación mencionados
     */
    private function extraerCriteriosEvaluacion(string $seccion): array
    {
        $criterios = [];

        // Patrones comunes de criterios
        $patronesCriterios = [
            '/(?:vale|equivale\s+a|puntos?\s+por)\s+(\d+)\s*%?\s+(?:de\s+)?([^.]{10,50})/iu',
            '/(\d+)\s+puntos?\s+(?:por|para)\s+([^.]{10,50})/iu',
        ];

        foreach ($patronesCriterios as $patron) {
            if (preg_match_all($patron, $seccion, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $puntos = (int) $match[1];
                    $criterio = trim($match[2]);

                    $criterios[] = [
                        'nombre' => ucfirst($criterio),
                        'puntos' => $puntos,
                    ];
                }
            }
        }

        // Si no se encontraron criterios explícitos, crear rúbrica genérica
        if (empty($criterios)) {
            $criterios = [
                ['nombre' => 'Contenido y profundidad', 'puntos' => 40],
                ['nombre' => 'Claridad y organización', 'puntos' => 30],
                ['nombre' => 'Ortografía y redacción', 'puntos' => 20],
                ['nombre' => 'Referencias bibliográficas', 'puntos' => 10],
            ];
        }

        return ['criterios' => $criterios];
    }

    /**
     * Estadísticas de detección
     */
    public function obtenerEstadisticas(string $contenido): array
    {
        $lineas = explode("\n", $contenido);
        $mencionesTotales = 0;

        foreach ($lineas as $linea) {
            if ($this->contieneMencionTarea($linea)) {
                $mencionesTotales++;
            }
        }

        return [
            'menciones_encontradas' => $mencionesTotales,
            'tareas_detectadas' => count($this->detectarTareas($contenido)),
        ];
    }
}
