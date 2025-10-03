@extends('layouts.app')

@section('title', $materia->nombre . ' - LAS Academy')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center gap-2 text-gray-500 dark:text-slate-400">
            <li><a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Inicio</a></li>
            <li>/</li>
            <li class="text-gray-900 dark:text-slate-100 font-medium">{{ $materia->nombre }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="card mb-8" style="border-left: 4px solid {{ $materia->color }};">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 rounded-lg flex items-center justify-center text-white font-bold text-2xl" style="background-color: {{ $materia->color }};">
                {{ substr($materia->nombre, 0, 1) }}
            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-2">{{ $materia->nombre }}</h1>
                @if($materia->descripcion)
                <p class="text-lg text-gray-600 dark:text-slate-300">{{ $materia->descripcion }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recursos por Tipo -->
    @if($recursosPorTipo->count() > 0)
    <div class="space-y-8">
        @foreach($recursosPorTipo as $tipo => $recursos)
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-4 flex items-center gap-2">
                @switch($tipo)
                    @case('transcripcion')
                        📝 Transcripciones
                        @break
                    @case('rubrica')
                        📋 Rúbricas
                        @break
                    @case('resumen')
                        📄 Resúmenes
                        @break
                    @case('material_apoyo')
                        📚 Material de Apoyo
                        @break
                    @case('video')
                        🎥 Videos
                        @break
                    @default
                        📎 {{ ucfirst($tipo) }}
                @endswitch
            </h2>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($recursos as $recurso)
                <a href="{{ route('recursos.show', $recurso) }}" class="card hover:shadow-lg transition-shadow group">
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors mb-2">
                        {{ $recurso->titulo }}
                    </h3>

                    @if($recurso->descripcion)
                    <p class="text-sm text-gray-600 dark:text-slate-300 mb-3">{{ Str::limit($recurso->descripcion, 100) }}</p>
                    @endif

                    <div class="flex items-center justify-between text-sm">
                        @if($recurso->encuentro)
                            <span class="text-gray-500 dark:text-slate-400">Encuentro {{ $recurso->encuentro->numero }}</span>
                        @else
                            <span class="text-gray-500 dark:text-slate-400">Material complementario</span>
                        @endif
                        @if($recurso->duracion_minutos)
                        <span class="text-primary-600 dark:text-primary-400">⏱️ {{ $recurso->duracion_minutos }} min</span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="card text-center py-12">
        <p class="text-gray-500 dark:text-slate-400">No hay recursos disponibles para esta materia aún.</p>
    </div>
    @endif

    <!-- Tareas -->
    @if($materia->tareas->count() > 0)
    <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-4">📝 Tareas</h2>

        <div class="space-y-4">
            @foreach($materia->tareas as $tarea)
            <div class="card">
                <!-- Header de tarea -->
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">{{ $tarea->titulo }}</h3>
                        @if($tarea->encuentro)
                        <span class="text-sm text-gray-500 dark:text-slate-400">Encuentro {{ $tarea->encuentro->numero }}</span>
                        @else
                        <span class="text-sm text-gray-500 dark:text-slate-400">Tarea general</span>
                        @endif
                    </div>
                    @if($tarea->fecha_entrega)
                    <span class="text-sm font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 px-3 py-1 rounded-full">
                        📅 {{ $tarea->fecha_entrega->format('d/m/Y') }}
                    </span>
                    @endif
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <p class="text-gray-700 dark:text-slate-300">{{ $tarea->descripcion }}</p>
                </div>

                <!-- Instrucciones (colapsable) -->
                @if($tarea->instrucciones)
                <details class="mb-4 group">
                    <summary class="cursor-pointer font-medium text-gray-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors list-none flex items-center gap-2">
                        <svg class="w-4 h-4 transition-transform group-open:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        📋 Instrucciones detalladas
                    </summary>
                    <div class="mt-3 pl-6 border-l-2 border-primary-200 dark:border-primary-800">
                        <p class="text-gray-600 dark:text-slate-300 whitespace-pre-line">{{ $tarea->instrucciones }}</p>
                    </div>
                </details>
                @endif

                <!-- Rúbrica (expandible) -->
                @if($tarea->rubrica && isset($tarea->rubrica['criterios']))
                <details class="bg-gray-50 dark:bg-slate-900 rounded-lg p-4 group">
                    <summary class="cursor-pointer font-medium text-gray-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors list-none flex items-center gap-2">
                        <svg class="w-4 h-4 transition-transform group-open:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        ⭐ Rúbrica de evaluación ({{ $tarea->puntos_totales }} puntos totales)
                    </summary>
                    <div class="mt-4">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-gray-300 dark:border-slate-700">
                                    <th class="text-left py-2 px-2 font-semibold text-gray-700 dark:text-slate-300">Criterio</th>
                                    <th class="text-right py-2 px-2 font-semibold text-gray-700 dark:text-slate-300">Puntos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tarea->rubrica['criterios'] as $criterio)
                                <tr class="border-b border-gray-200 dark:border-slate-700 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                                    <td class="py-3 px-2 text-gray-700 dark:text-slate-300">{{ $criterio['nombre'] }}</td>
                                    <td class="text-right py-3 px-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-800 dark:text-primary-300">
                                            {{ $criterio['puntos'] }} pts
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-gray-300 dark:border-slate-700 font-bold">
                                    <td class="py-3 px-2 text-gray-900 dark:text-slate-100">Total</td>
                                    <td class="text-right py-3 px-2 text-primary-600 dark:text-primary-400">{{ $tarea->puntos_totales }} pts</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </details>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
