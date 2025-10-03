<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::activas()
            ->withCount(['recursos', 'tareas', 'encuentros'])
            ->get();

        return view('materias.index', compact('materias'));
    }

    public function show(Materia $materia)
    {
        $materia->load([
            'encuentros' => function ($query) {
                $query->activos();
            },
            'recursos' => function ($query) {
                $query->visibles()->with('encuentro');
            },
            'tareas' => function ($query) {
                $query->visibles()->with('encuentro');
            }
        ]);

        // Agrupar recursos por tipo
        $recursosPorTipo = $materia->recursos->groupBy('tipo');

        return view('materias.show', compact('materia', 'recursosPorTipo'));
    }
}
