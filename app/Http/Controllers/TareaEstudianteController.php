<?php

namespace App\Http\Controllers;

use App\Models\TareaEstudiante;
use App\Models\Materia;
use App\Models\Encuentro;
use App\Models\Rubrica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TareaEstudianteController extends Controller
{
    public function index(Request $request)
    {
        $query = TareaEstudiante::with(['materia', 'encuentro', 'recursoOrigen', 'rubrica']);

        // Filtros
        if ($request->filled('materia_id')) {
            $query->where('materia_id', $request->materia_id);
        }

        if ($request->filled('encuentro_id')) {
            $query->where('encuentro_id', $request->encuentro_id);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        // Ordenamiento
        $ordenar = $request->get('ordenar', 'fecha_entrega');
        $direccion = $request->get('direccion', 'asc');

        if ($ordenar === 'prioridad') {
            $query->porPrioridad();
        } else {
            $query->orderBy($ordenar, $direccion);
        }

        $tareas = $query->paginate(15);

        // Datos para filtros
        $materias = Materia::activas()->orderBy('nombre')->get();
        $encuentros = Encuentro::activos()->orderBy('numero')->get();

        return view('tareas.index', compact('tareas', 'materias', 'encuentros'));
    }

    public function pendientes()
    {
        $tareas = TareaEstudiante::pendientes()
            ->with(['materia', 'encuentro', 'rubrica'])
            ->orderBy('fecha_entrega')
            ->paginate(20);

        return view('tareas.pendientes', compact('tareas'));
    }

    public function validar()
    {
        // Leer JSON de menciones extraídas
        $rutaJson = 'exports/tareas_extraidas.json';

        if (!Storage::exists($rutaJson)) {
            return redirect()->route('tareas.index')
                ->with('error', 'No hay menciones extraídas. Ejecuta primero: php artisan tareas:extraer');
        }

        $jsonContent = Storage::get($rutaJson);
        $data = json_decode($jsonContent, true);

        $menciones = $data['menciones'] ?? [];
        $stats = $data['por_confianza'] ?? [];

        // Obtener IDs ya validados
        $idsValidados = TareaEstudiante::pluck('recurso_origen_id', 'contexto_original')
            ->filter()
            ->keys()
            ->toArray();

        return view('tareas.validar', compact('menciones', 'stats', 'idsValidados', 'data'));
    }

    public function show(TareaEstudiante $tarea)
    {
        $tarea->load(['materia', 'encuentro', 'recursoOrigen', 'rubrica']);

        return view('tareas.show', compact('tarea'));
    }

    public function create()
    {
        $materias = Materia::activas()->orderBy('nombre')->get();
        $encuentros = Encuentro::activos()->orderBy('numero')->get();
        $rubricas = Rubrica::activas()->with('materia')->get();

        return view('tareas.create', compact('materias', 'encuentros', 'rubricas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'materia_id' => 'nullable|exists:materias,id',
            'encuentro_id' => 'nullable|exists:encuentros,id',
            'tipo' => 'required|in:tarea,trabajo,lectura,evaluacion,otro',
            'fecha_asignacion' => 'nullable|date',
            'fecha_entrega' => 'nullable|date',
            'prioridad' => 'required|in:baja,media,alta',
            'estado' => 'required|in:pendiente,en_progreso,completada,cancelada',
            'recurso_origen_id' => 'nullable|exists:recursos,id',
            'contexto_original' => 'nullable|string',
            'notas_adicionales' => 'nullable|string',
            'rubrica_id' => 'nullable|exists:rubricas,id',
            'validada' => 'boolean',
        ]);

        $tarea = TareaEstudiante::create($validated);

        return redirect()->route('tareas.show', $tarea)
            ->with('success', 'Tarea creada exitosamente');
    }

    public function edit(TareaEstudiante $tarea)
    {
        $materias = Materia::activas()->orderBy('nombre')->get();
        $encuentros = Encuentro::activos()->orderBy('numero')->get();
        $rubricas = Rubrica::activas()->with('materia')->get();

        return view('tareas.edit', compact('tarea', 'materias', 'encuentros', 'rubricas'));
    }

    public function update(Request $request, TareaEstudiante $tarea)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'materia_id' => 'nullable|exists:materias,id',
            'encuentro_id' => 'nullable|exists:encuentros,id',
            'tipo' => 'required|in:tarea,trabajo,lectura,evaluacion,otro',
            'fecha_asignacion' => 'nullable|date',
            'fecha_entrega' => 'nullable|date',
            'prioridad' => 'required|in:baja,media,alta',
            'estado' => 'required|in:pendiente,en_progreso,completada,cancelada',
            'notas_adicionales' => 'nullable|string',
            'rubrica_id' => 'nullable|exists:rubricas,id',
        ]);

        $tarea->update($validated);

        return redirect()->route('tareas.show', $tarea)
            ->with('success', 'Tarea actualizada exitosamente');
    }

    public function destroy(TareaEstudiante $tarea)
    {
        $tarea->delete();

        return redirect()->route('tareas.index')
            ->with('success', 'Tarea eliminada exitosamente');
    }

    public function completar(TareaEstudiante $tarea)
    {
        $tarea->update(['estado' => 'completada']);

        return back()->with('success', 'Tarea marcada como completada');
    }

    public function crearDesdeMencion(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'recurso_origen_id' => 'required|exists:recursos,id',
            'contexto_original' => 'required|string',
            'materia_id' => 'nullable|exists:materias,id',
            'encuentro_id' => 'nullable|exists:encuentros,id',
            'tipo' => 'required|in:tarea,trabajo,lectura,evaluacion,otro',
            'prioridad' => 'required|in:baja,media,alta',
        ]);

        $validated['validada'] = true;
        $validated['estado'] = 'pendiente';

        $tarea = TareaEstudiante::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tarea creada exitosamente',
            'tarea_id' => $tarea->id,
        ]);
    }
}
