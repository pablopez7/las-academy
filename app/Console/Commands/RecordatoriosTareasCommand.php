<?php

namespace App\Console\Commands;

use App\Models\TareaEstudiante;
use Illuminate\Console\Command;

class RecordatoriosTareasCommand extends Command
{
    protected $signature = 'tareas:recordatorios {--dias=7 : Número de días para el filtro}';
    protected $description = 'Muestra tareas próximas a vencer';

    public function handle()
    {
        $dias = $this->option('dias');

        $tareas = TareaEstudiante::proximasAVencer($dias)
            ->with(['materia', 'encuentro'])
            ->get();

        if ($tareas->isEmpty()) {
            $this->info("✓ No hay tareas próximas a vencer en los próximos {$dias} días");
            return Command::SUCCESS;
        }

        $this->info("📋 Tareas próximas a vencer (próximos {$dias} días):");
        $this->newLine();

        $data = [];
        foreach ($tareas as $tarea) {
            $diasRestantes = $tarea->diasRestantes();
            $urgencia = $diasRestantes <= 3 ? '🔴' : ($diasRestantes <= 7 ? '🟡' : '🟢');

            $data[] = [
                $urgencia,
                $tarea->titulo,
                $tarea->materia?->nombre ?? 'Sin materia',
                $tarea->fecha_entrega->format('d/m/Y'),
                $diasRestantes . ' días',
                ucfirst($tarea->prioridad),
                ucfirst($tarea->estado),
            ];
        }

        $this->table(
            ['', 'Título', 'Materia', 'Fecha Entrega', 'Días Restantes', 'Prioridad', 'Estado'],
            $data
        );

        $this->newLine();
        $this->info("Total: {$tareas->count()} tareas");

        // Estadísticas
        $urgentes = $tareas->filter(fn($t) => $t->esUrgente())->count();
        if ($urgentes > 0) {
            $this->warn("⚠️  {$urgentes} tareas URGENTES (≤3 días)");
        }

        return Command::SUCCESS;
    }
}
