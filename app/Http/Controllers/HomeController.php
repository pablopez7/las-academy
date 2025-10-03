<?php

namespace App\Http\Controllers;

use App\Models\Encuentro;
use App\Models\Recurso;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $encuentros = Encuentro::activos()
            ->with(['materias' => function ($query) {
                $query->activas();
            }])
            ->get();

        $proximasTareas = \App\Models\Tarea::visibles()
            ->proximas()
            ->with(['encuentro', 'materia'])
            ->limit(5)
            ->get();

        // Tareas de estudiante próximas a vencer
        $tareasEstudiante = \App\Models\TareaEstudiante::proximasAVencer(7)
            ->with(['materia', 'encuentro'])
            ->limit(5)
            ->get();

        return view('home', compact('encuentros', 'proximasTareas', 'tareasEstudiante'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        if (empty($query)) {
            return redirect()->route('home');
        }

        // Búsqueda en base de datos con LIKE
        $recursos = Recurso::where('visible', true)
            ->where(function($q) use ($query) {
                $q->where('titulo', 'like', "%{$query}%")
                  ->orWhere('descripcion', 'like', "%{$query}%")
                  ->orWhere('contenido', 'like', "%{$query}%");
            })
            ->with(['encuentro', 'materia'])
            ->paginate(20);

        return view('search', compact('recursos', 'query'));
    }
}
