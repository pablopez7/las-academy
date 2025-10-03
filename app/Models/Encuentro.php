<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Encuentro extends Model
{
    protected $fillable = [
        'nombre',
        'numero',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'imagen_calendario',
        'activo',
        'orden',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];

    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class, 'encuentro_materia')
            ->withPivot('orden')
            ->orderBy('encuentro_materia.orden');
    }

    public function recursos(): HasMany
    {
        return $this->hasMany(Recurso::class);
    }

    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->orderBy('orden');
    }

    public function getRouteKeyName()
    {
        return 'numero';
    }
}
