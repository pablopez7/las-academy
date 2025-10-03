<?php

namespace App\Http\Controllers;

use App\Models\Encuentro;
use Illuminate\Http\Request;

class EncuentroController extends Controller
{
    public function index()
    {
        $encuentros = Encuentro::activos()
            ->withCount(['recursos', 'tareas'])
            ->with(['materias' => function ($query) {
                $query->activas();
            }])
            ->get();

        return view('encuentros.index', compact('encuentros'));
    }

    public function show(Encuentro $encuentro)
    {
        $encuentro->load([
            'materias' => function ($query) {
                $query->activas()->withCount(['recursos', 'tareas']);
            }
        ]);

        return view('encuentros.show', compact('encuentro'));
    }
}
