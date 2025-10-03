<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecursoController extends Controller
{
    public function show(Recurso $recurso)
    {
        $recurso->load(['encuentro', 'materia']);

        // Obtener recursos relacionados de la misma materia
        $recursosRelacionados = Recurso::where('materia_id', $recurso->materia_id)
            ->where('id', '!=', $recurso->id)
            ->visibles()
            ->limit(5)
            ->get();

        return view('recursos.show', compact('recurso', 'recursosRelacionados'));
    }

    public function download(Recurso $recurso)
    {
        if (empty($recurso->archivo_ruta) || !Storage::exists($recurso->archivo_ruta)) {
            abort(404, 'Archivo no encontrado');
        }

        return Storage::download($recurso->archivo_ruta, $recurso->titulo);
    }
}
