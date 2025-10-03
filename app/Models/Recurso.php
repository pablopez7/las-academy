<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
// use Laravel\Scout\Searchable; // Deshabilitado temporalmente - usar búsqueda de BD

class Recurso extends Model
{
    // use Searchable; // Deshabilitado temporalmente

    protected $fillable = [
        'encuentro_id',
        'materia_id',
        'tipo',
        'titulo',
        'slug',
        'descripcion',
        'contenido',
        'archivo_ruta',
        'url_externa',
        'duracion_minutos',
        'metadata',
        'profesor',
        'visible',
        'orden',
    ];

    protected $casts = [
        'metadata' => 'array',
        'visible' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($recurso) {
            if (empty($recurso->slug)) {
                $recurso->slug = Str::slug($recurso->titulo);
            }
        });
    }

    public function encuentro(): BelongsTo
    {
        return $this->belongsTo(Encuentro::class);
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function scopeVisibles($query)
    {
        return $query->where('visible', true)->orderBy('orden');
    }

    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function toSearchableArray()
    {
        return [
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'contenido' => $this->contenido,
            'tipo' => $this->tipo,
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
