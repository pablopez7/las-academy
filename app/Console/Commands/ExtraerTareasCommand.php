<?php

namespace App\Console\Commands;

use App\Models\Recurso;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExtraerTareasCommand extends Command
{
    protected $signature = 'tareas:extraer';
    protected $description = 'Extrae menciones de tareas de todos los recursos (transcripciones y notas)';

    // Patrones de búsqueda con niveles de confianza
    private array $patronesAlta = [
        '/^[\s]*Tarea[s]?[\s]*:/im',
        '/^[\s]*Trabajo[\s]+(final|práctico|para casa)[\s]*:/im',
        '/Lectura[\s]+obligatoria[\s]*:/im',
        '/Entregar[\s]+(un|una|el|la)[\s]+\w+/i',
    ];

    private array $patronesMedia = [
        '/Para[\s]+la[\s]+próxima[\s]+clase/i',
        '/Para[\s]+el[\s]+próximo[\s]+encuentro/i',
        '/Deben[\s]+leer/i',
        '/Tienen[\s]+que[\s]+leer/i',
        '/Investigar[\s]+sobre/i',
        '/Preparar[\s]+(un|una)/i',
    ];

    private array $patronesBaja = [
        '/Estudiar[\s]+\w+/i',
        '/Revisar[\s]+el[\s]+material/i',
        '/Leer[\s]+en[\s]+casa/i',
    ];

    public function handle()
    {
        $this->info('🔍 Iniciando extracción de tareas...');
        $this->newLine();

        // Obtener todos los recursos con contenido
        $recursos = Recurso::whereNotNull('contenido')
            ->where('contenido', '!=', '')
            ->with(['materia', 'encuentro'])
            ->get();

        $this->info("📚 Analizando {$recursos->count()} recursos...");
        $this->newLine();

        $menciones = [];
        $stats = [
            'alta' => 0,
            'media' => 0,
            'baja' => 0,
        ];

        $progressBar = $this->output->createProgressBar($recursos->count());
        $progressBar->start();

        foreach ($recursos as $recurso) {
            $mencionesRecurso = $this->analizarRecurso($recurso);

            foreach ($mencionesRecurso as $mencion) {
                $menciones[] = $mencion;
                $stats[$mencion['confianza']]++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Generar reporte
        $reporte = [
            'fecha_extraccion' => now()->format('Y-m-d H:i:s'),
            'total_recursos_analizados' => $recursos->count(),
            'total_menciones' => count($menciones),
            'por_confianza' => $stats,
            'menciones' => $menciones,
        ];

        // Guardar JSON
        $rutaExport = 'exports/tareas_extraidas.json';
        Storage::put($rutaExport, json_encode($reporte, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Mostrar resumen
        $this->newLine();
        $this->info('✅ Extracción completada!');
        $this->newLine();
        $this->table(
            ['Confianza', 'Cantidad'],
            [
                ['Alta 🔴', $stats['alta']],
                ['Media 🟡', $stats['media']],
                ['Baja 🟢', $stats['baja']],
                ['TOTAL', count($menciones)],
            ]
        );

        $this->newLine();
        $this->info("📄 Reporte guardado en: storage/app/{$rutaExport}");
        $this->info("🌐 Ahora puedes validar las menciones en: /tareas/validar");

        return Command::SUCCESS;
    }

    private function analizarRecurso(Recurso $recurso): array
    {
        $menciones = [];
        $contenido = $recurso->contenido;
        $lineas = explode("\n", $contenido);

        // Buscar patrones de alta confianza
        foreach ($this->patronesAlta as $patron) {
            $matches = $this->buscarPatron($patron, $contenido, $lineas);
            foreach ($matches as $match) {
                $menciones[] = $this->crearMencion($recurso, $match, 'alta', $patron);
            }
        }

        // Buscar patrones de media confianza
        foreach ($this->patronesMedia as $patron) {
            $matches = $this->buscarPatron($patron, $contenido, $lineas);
            foreach ($matches as $match) {
                $menciones[] = $this->crearMencion($recurso, $match, 'media', $patron);
            }
        }

        // Buscar patrones de baja confianza
        foreach ($this->patronesBaja as $patron) {
            $matches = $this->buscarPatron($patron, $contenido, $lineas);
            foreach ($matches as $match) {
                $menciones[] = $this->crearMencion($recurso, $match, 'baja', $patron);
            }
        }

        return $menciones;
    }

    private function buscarPatron(string $patron, string $contenido, array $lineas): array
    {
        $resultados = [];

        // Buscar en todo el contenido
        if (preg_match_all($patron, $contenido, $matches, PREG_OFFSET_CAPTURE)) {
            foreach ($matches[0] as $match) {
                $textoEncontrado = $match[0];
                $posicion = $match[1];

                // Extraer contexto (3 líneas antes y después)
                $contexto = $this->extraerContexto($contenido, $posicion, 3);

                $resultados[] = [
                    'texto_encontrado' => trim($textoEncontrado),
                    'posicion' => $posicion,
                    'contexto' => $contexto,
                ];
            }
        }

        return $resultados;
    }

    private function extraerContexto(string $contenido, int $posicion, int $lineasContexto = 3): string
    {
        $lineas = explode("\n", $contenido);
        $caracteresAcumulados = 0;
        $lineaActual = 0;

        // Encontrar número de línea
        foreach ($lineas as $i => $linea) {
            $caracteresAcumulados += strlen($linea) + 1; // +1 por el \n
            if ($caracteresAcumulados > $posicion) {
                $lineaActual = $i;
                break;
            }
        }

        // Extraer contexto
        $inicio = max(0, $lineaActual - $lineasContexto);
        $fin = min(count($lineas) - 1, $lineaActual + $lineasContexto);

        $contextoLineas = array_slice($lineas, $inicio, $fin - $inicio + 1);

        return implode("\n", $contextoLineas);
    }

    private function crearMencion(Recurso $recurso, array $match, string $confianza, string $patron): array
    {
        return [
            'recurso' => [
                'id' => $recurso->id,
                'titulo' => $recurso->titulo,
                'materia' => $recurso->materia?->nombre,
                'encuentro' => $recurso->encuentro?->numero,
            ],
            'patron_encontrado' => $match['texto_encontrado'],
            'contexto_completo' => $match['contexto'],
            'confianza' => $confianza,
            'posicion_en_texto' => $match['posicion'],
            'patron_regex' => $patron,
        ];
    }
}
