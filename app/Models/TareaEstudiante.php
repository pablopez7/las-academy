<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TareaEstudiante extends Model
{
    protected $table = 'tareas_estudiante';

    protected $fillable = [
        'titulo',
        'descripcion',
        'materia_id',
        'encuentro_id',
        'tipo',
        'fecha_asignacion',
        'fecha_entrega',
        'prioridad',
        'estado',
        'recurso_origen_id',
        'contexto_original',
        'notas_adicionales',
        'rubrica_id',
        'validada',
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
        'fecha_entrega' => 'date',
        'validada' => 'boolean',
    ];

    // Relaciones
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function encuentro(): BelongsTo
    {
        return $this->belongsTo(Encuentro::class);
    }

    public function recursoOrigen(): BelongsTo
    {
        return $this->belongsTo(Recurso::class, 'recurso_origen_id');
    }

    public function rubrica(): BelongsTo
    {
        return $this->belongsTo(Rubrica::class);
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEnProgreso($query)
    {
        return $query->where('estado', 'en_progreso');
    }

    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    public function scopeValidadas($query)
    {
        return $query->where('validada', true);
    }

    public function scopeNoValidadas($query)
    {
        return $query->where('validada', false);
    }

    public function scopeProximasAVencer($query, $dias = 7)
    {
        return $query->where('estado', '!=', 'completada')
            ->where('fecha_entrega', '>=', now())
            ->where('fecha_entrega', '<=', now()->addDays($dias))
            ->orderBy('fecha_entrega');
    }

    public function scopePorPrioridad($query)
    {
        return $query->orderByRaw("FIELD(prioridad, 'alta', 'media', 'baja')");
    }

    // Helpers
    public function estaVencida(): bool
    {
        return $this->fecha_entrega &&
               $this->fecha_entrega->isPast() &&
               $this->estado !== 'completada';
    }

    public function diasRestantes(): ?int
    {
        if (!$this->fecha_entrega || $this->estado === 'completada') {
            return null;
        }

        return now()->diffInDays($this->fecha_entrega, false);
    }

    public function esUrgente(): bool
    {
        $dias = $this->diasRestantes();
        return $dias !== null && $dias >= 0 && $dias <= 3;
    }

    public function getBadgeColorEstado(): string
    {
        return match($this->estado) {
            'pendiente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
            'en_progreso' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
            'completada' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            'cancelada' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
        };
    }

    public function getBadgeColorPrioridad(): string
    {
        return match($this->prioridad) {
            'alta' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
            'media' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
            'baja' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
        };
    }

    public function getBadgeColorTipo(): string
    {
        return match($this->tipo) {
            'tarea' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400',
            'trabajo' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
            'lectura' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-400',
            'evaluacion' => 'bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-400',
            'otro' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
        };
    }
}
