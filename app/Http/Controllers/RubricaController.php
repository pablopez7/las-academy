<?php

namespace App\Http\Controllers;

use App\Models\Rubrica;
use App\Models\Materia;
use App\Models\Encuentro;
use Illuminate\Http\Request;

class RubricaController extends Controller
{
    /**
     * Mostrar lista de rúbricas
     */
    public function index()
    {
        $rubricas = Rubrica::with(['materia', 'encuentro'])
            ->orderBy('materia_id')
            ->get();

        return view('rubricas.index', compact('rubricas'));
    }

    /**
     * Mostrar detalle de una rúbrica
     */
    public function show(Rubrica $rubrica)
    {
        $rubrica->load(['materia', 'encuentro']);

        return view('rubricas.show', compact('rubrica'));
    }

    /**
     * Mostrar rúbricas por materia
     */
    public function porMateria(Materia $materia)
    {
        $rubricas = Rubrica::porMateria($materia->id)
            ->activas()
            ->with('encuentro')
            ->get();

        return view('rubricas.por-materia', compact('rubricas', 'materia'));
    }
}
