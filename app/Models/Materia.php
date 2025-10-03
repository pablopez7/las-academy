<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Materia extends Model
{
    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'color',
        'icono',
        'activa',
        'orden',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($materia) {
            if (empty($materia->slug)) {
                $materia->slug = Str::slug($materia->nombre);
            }
        });
    }

    public function encuentros(): BelongsToMany
    {
        return $this->belongsToMany(Encuentro::class, 'encuentro_materia')
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

    public function scopeActivas($query)
    {
        return $query->where('activa', true)->orderBy('orden');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
