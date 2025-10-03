<?php

namespace App\Console\Commands;

use App\Services\DetectorTareas;
use App\Services\ImportadorTranscripciones;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportarContenidoSeminario extends Command
{
    protected $signature = 'import:contenido-seminario
                            {--dry-run : Mostrar qué se va a importar sin ejecutar}
                            {--solo-transcripciones : Importar solo transcripciones}
                            {--solo-notas : Importar solo notas de Obsidian}
                            {--solo-tareas : Solo extraer y crear tareas}
                            {--sin-tareas : No detectar tareas automáticamente}
                            {--limit=0 : Limitar número de archivos a procesar (0 = todos)}';

    protected $description = 'Importa contenido del seminario (transcripciones, videos, calendarios)';

    private ImportadorTranscripciones $importador;
    private string $baseDir = '/data/seminario';
    private string $logFile;

    public function handle(): int
    {
        $this->logFile = storage_path('logs/importacion_' . date('Y-m-d_His') . '.log');

        $this->mostrarBanner();

        // Inicializar servicios
        $detectorTareas = new DetectorTareas();
        $this->importador = new ImportadorTranscripciones($detectorTareas);

        // Opciones
        $dryRun = $this->option('dry-run');
        $soloTranscripciones = $this->option('solo-transcripciones');
        $soloNotas = $this->option('solo-notas');
        $soloTareas = $this->option('solo-tareas');
        $sinTareas = $this->option('sin-tareas');
        $limit = (int) $this->option('limit');

        // Escanear archivos
        $this->info("\n📁 Escaneando archivos...\n");
        $archivos = $this->importador->escanearArchivos($this->baseDir);

        // Aplicar límite si se especificó
        if ($limit > 0) {
            $archivos['transcripciones'] = array_slice($archivos['transcripciones'], 0, $limit);
            $archivos['videos'] = array_slice($archivos['videos'], 0, $limit);
        }

        // Mostrar resumen
        $this->mostrarResumen($archivos);

        if ($dryRun) {
            $this->warn("\n🔍 Modo DRY-RUN activado - No se modificará la base de datos\n");
        }

        // Confirmar
        if (!$dryRun && !$this->confirm("\n¿Continuar con la importación?", true)) {
            $this->error("\n❌ Importación cancelada por el usuario\n");
            return self::FAILURE;
        }

        // Crear backup de BD si no es dry-run
        if (!$dryRun) {
            $this->crearBackupBD();
        }

        $this->newLine();
        // DESHABILITAR detección automática hasta refinamiento
        $detectarTareas = false; // !$sinTareas && !$soloTareas;

        // Procesar transcripciones
        if (!$soloTareas) {
            $this->procesarTranscripciones($archivos['transcripciones'], $detectarTareas, $dryRun);
        }

        // Procesar videos
        if (!$soloTranscripciones && !$soloTareas) {
            $this->procesarVideos($archivos['videos'], $dryRun);
        }

        // Procesar calendarios
        if (!$soloTranscripciones && !$soloTareas && !$soloNotas) {
            $this->procesarCalendarios($archivos['calendarios'], $dryRun);
        }

        // Procesar notas de Obsidian
        if (!$soloTranscripciones && !$soloTareas || $soloNotas) {
            $this->procesarNotasObsidian($archivos['notas_obsidian'], $dryRun);
        }

        // Mostrar resultados finales
        $this->mostrarResultadosFinales();

        return self::SUCCESS;
    }

    private function mostrarBanner(): void
    {
        $this->line("╔═══════════════════════════════════════╗");
        $this->line("║  IMPORTACIÓN DE CONTENIDO SEMINARIO  ║");
        $this->line("╚═══════════════════════════════════════╝");
    }

    private function mostrarResumen(array $archivos): void
    {
        $this->info("📊 Archivos encontrados:\n");
        $this->line("  ✓ {$this->colorCount(count($archivos['transcripciones']))} transcripciones");
        $this->line("  ✓ {$this->colorCount(count($archivos['videos']))} videos");
        $this->line("  ✓ {$this->colorCount(count($archivos['calendarios']))} calendarios");
        $this->line("  ✓ {$this->colorCount(count($archivos['notas_obsidian']))} notas de Obsidian");

        $total = count($archivos['transcripciones']) + count($archivos['videos']) + count($archivos['calendarios']) + count($archivos['notas_obsidian']);
        $this->newLine();
        $this->info("Total a procesar: {$this->colorCount($total)} archivos");

        if ($this->option('limit') > 0) {
            $this->warn("⚠️  Límite aplicado: {$this->option('limit')} archivos");
        }
    }

    private function procesarTranscripciones(array $transcripciones, bool $detectarTareas, bool $dryRun): void
    {
        if (empty($transcripciones)) {
            return;
        }

        $this->newLine();
        $this->info("📝 Procesando transcripciones...\n");

        $bar = $this->output->createProgressBar(count($transcripciones));
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% - %message%');

        foreach ($transcripciones as $archivo) {
            $nombreArchivo = basename($archivo);
            $bar->setMessage("Procesando $nombreArchivo");

            $resultado = $this->importador->importarTranscripcion($archivo, $detectarTareas, $dryRun);

            if ($resultado['exito']) {
                $mensaje = "✓ {$resultado['archivo']}";
                if (isset($resultado['tareas_detectadas']) && $resultado['tareas_detectadas'] > 0) {
                    $mensaje .= " ({$resultado['tareas_detectadas']} tareas)";
                }
                $this->logToFile($mensaje);
            } else {
                $this->logToFile("✗ {$resultado['archivo']}: {$resultado['razon']}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
    }

    private function procesarVideos(array $videos, bool $dryRun): void
    {
        if (empty($videos) || $dryRun) {
            return;
        }

        $this->info("🎥 Referenciando videos...\n");

        $bar = $this->output->createProgressBar(count($videos));
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% - %message%');

        foreach ($videos as $video) {
            $nombreArchivo = basename($video);
            $bar->setMessage("Procesando $nombreArchivo");

            $resultado = $this->importador->referenciarVideo($video);

            if ($resultado['exito']) {
                $this->logToFile("✓ Video: {$resultado['archivo']} → {$resultado['vinculado_con']}");
            } else {
                $this->logToFile("✗ Video: {$resultado['archivo']}: {$resultado['razon']}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
    }

    private function procesarCalendarios(array $calendarios, bool $dryRun): void
    {
        if (empty($calendarios) || $dryRun) {
            return;
        }

        $this->info("📅 Importando calendarios...\n");

        $storageDir = storage_path('app/public');

        foreach ($calendarios as $calendario) {
            $resultado = $this->importador->importarCalendario($calendario, $storageDir);

            if ($resultado['exito']) {
                $this->line("  ✓ {$resultado['archivo']} → {$resultado['encuentro']}");
                $this->logToFile("✓ Calendario: {$resultado['archivo']} para {$resultado['encuentro']}");
            } else {
                $this->error("  ✗ {$resultado['archivo']}: {$resultado['razon']}");
                $this->logToFile("✗ Calendario: {$resultado['archivo']}: {$resultado['razon']}");
            }
        }

        $this->newLine();
    }

    private function procesarNotasObsidian(array $notas, bool $dryRun): void
    {
        if (empty($notas)) {
            return;
        }

        $this->newLine();
        $this->info("📚 Procesando notas de Obsidian...\n");

        $bar = $this->output->createProgressBar(count($notas));
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% - %message%');

        foreach ($notas as $nota) {
            $nombreArchivo = basename($nota);
            $bar->setMessage("Procesando $nombreArchivo");

            $resultado = $this->importador->importarNotaObsidian($nota, $dryRun);

            if ($resultado['exito']) {
                $mensaje = "✓ {$resultado['archivo']} → {$resultado['titulo']}";
                $this->logToFile($mensaje);
            } else {
                $this->logToFile("✗ {$resultado['archivo']}: {$resultado['razon']}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
    }

    private function mostrarResultadosFinales(): void
    {
        $stats = $this->importador->obtenerEstadisticas();

        $this->newLine();
        $this->line("╔═══════════════════════════════════════╗");
        $this->line("║          IMPORTACIÓN COMPLETA         ║");
        $this->line("╚═══════════════════════════════════════╝");
        $this->newLine();

        $this->info("📊 Resultados:\n");
        $this->line("  ✓ Procesados: {$this->colorCount($stats['procesados'])}");
        $this->line("  ✓ Exitosos: <fg=green>{$stats['exitosos']}</>");
        $this->line("  ⚠️  Omitidos: <fg=yellow>{$stats['omitidos']}</>");
        $this->line("  ❌ Errores: <fg=red>{$stats['errores']}</>");
        $this->line("  📝 Tareas detectadas: <fg=cyan>{$stats['tareas_detectadas']}</>");

        $this->newLine();
        $this->info("📝 Log detallado: {$this->logFile}");
        $this->newLine();
    }

    private function crearBackupBD(): void
    {
        $this->info("\n💾 Creando backup de base de datos...");

        try {
            $backupFile = storage_path('backups/db_backup_' . date('Y-m-d_His') . '.sql');
            $backupDir = dirname($backupFile);

            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');

            // Usar docker-compose exec para hacer el dump
            $command = "docker-compose exec -T mysql mysqldump -h $host -u $username -p$password $database > $backupFile 2>&1";

            exec($command, $output, $returnCode);

            if ($returnCode === 0 && file_exists($backupFile) && filesize($backupFile) > 0) {
                $this->info("  ✓ Backup creado: $backupFile");
                $this->logToFile("Backup BD creado: $backupFile");
            } else {
                $this->warn("  ⚠️  No se pudo crear backup automático. Continuando...");
            }
        } catch (\Exception $e) {
            $this->warn("  ⚠️  Error creando backup: {$e->getMessage()}");
            $this->warn("  Continuando sin backup...");
        }

        $this->newLine();
    }

    private function logToFile(string $message): void
    {
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($this->logFile, "[$timestamp] $message\n", FILE_APPEND);
    }

    private function colorCount(int $count): string
    {
        if ($count === 0) {
            return "<fg=red>$count</>";
        }
        return "<fg=cyan>$count</>";
    }
}
