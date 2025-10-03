<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rubrica extends Model
{
    protected $fillable = [
        'materia_id',
        'encuentro_id',
        'titulo',
        'descripcion',
        'criterios',
        'puntos_totales',
        'activa',
    ];

    protected $casts = [
        'criterios' => 'array',
        'activa' => 'boolean',
    ];

    /**
     * Relación con Materia
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    /**
     * Relación con Encuentro
     */
    public function encuentro(): BelongsTo
    {
        return $this->belongsTo(Encuentro::class);
    }

    /**
     * Calcular puntos totales automáticamente desde criterios
     */
    public function calcularPuntosTotales(): int
    {
        if (!is_array($this->criterios)) {
            return 0;
        }

        return collect($this->criterios)->sum('puntos_max');
    }

    /**
     * Scope para rúbricas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    /**
     * Scope por materia
     */
    public function scopePorMateria($query, $materiaId)
    {
        return $query->where('materia_id', $materiaId);
    }

    /**
     * Scope por encuentro
     */
    public function scopePorEncuentro($query, $encuentroId)
    {
        return $query->where('encuentro_id', $encuentroId);
    }
}
