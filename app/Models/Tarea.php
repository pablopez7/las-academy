<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarea extends Model
{
    protected $fillable = [
        'encuentro_id',
        'materia_id',
        'rubrica_id',
        'titulo',
        'descripcion',
        'instrucciones',
        'fecha_entrega',
        'puntos_totales',
        'rubrica',
        'visible',
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
        'rubrica' => 'array',
        'visible' => 'boolean',
    ];

    public function encuentro(): BelongsTo
    {
        return $this->belongsTo(Encuentro::class);
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function rubricaRelacion(): BelongsTo
    {
        return $this->belongsTo(Rubrica::class, 'rubrica_id');
    }

    public function scopeVisibles($query)
    {
        return $query->where('visible', true);
    }

    public function scopeProximas($query)
    {
        return $query->where('fecha_entrega', '>=', now())
            ->orderBy('fecha_entrega');
    }
}
