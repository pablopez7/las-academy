@extends('layouts.app')

@section('title', $rubrica->titulo)

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="bg-slate-800 rounded-lg p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">{{ $rubrica->titulo }}</h1>
                @if($rubrica->materia)
                    <p class="text-indigo-400 text-lg">{{ $rubrica->materia->nombre }}</p>
                @endif
                @if($rubrica->encuentro)
                    <p class="text-slate-400 text-sm mt-1">{{ $rubrica->encuentro->nombre }}</p>
                @endif
            </div>
            <div class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-center">
                <div class="text-2xl font-bold">{{ $rubrica->puntos_totales }}</div>
                <div class="text-xs">puntos</div>
            </div>
        </div>

        @if($rubrica->descripcion)
            <p class="text-slate-300 mt-4">{{ $rubrica->descripcion }}</p>
        @endif
    </div>

    {{-- Criterios de evaluación --}}
    <div class="bg-slate-800 rounded-lg overflow-hidden">
        <div class="bg-indigo-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white">Criterios de Evaluación</h2>
        </div>

        <div class="divide-y divide-slate-700">
            @foreach($rubrica->criterios as $index => $criterio)
                <div class="p-6 hover:bg-slate-750 transition-colors">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm">
                                    {{ $index + 1 }}
                                </span>
                                <h3 class="text-lg font-semibold text-white">{{ $criterio['nombre'] }}</h3>
                            </div>
                            <p class="text-slate-300 ml-11">{{ $criterio['descripcion'] }}</p>
                        </div>
                        <div class="ml-4 bg-slate-700 px-4 py-2 rounded-lg text-center flex-shrink-0">
                            <div class="text-xl font-bold text-indigo-400">{{ $criterio['puntos_max'] }}</div>
                            <div class="text-xs text-slate-400">pts</div>
                        </div>
                    </div>

                    {{-- Barra de progreso visual --}}
                    <div class="ml-11 mt-3">
                        <div class="w-full bg-slate-700 rounded-full h-2">
                            <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ ($criterio['puntos_max'] / $rubrica->puntos_totales) * 100 }}%"></div>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            {{ round(($criterio['puntos_max'] / $rubrica->puntos_totales) * 100, 1) }}% del total
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Acciones --}}
    <div class="mt-6 flex gap-4">
        <a href="{{ route('rubricas.index') }}"
           class="bg-slate-700 hover:bg-slate-600 text-white px-6 py-3 rounded-lg transition-colors">
            ← Volver a rúbricas
        </a>

        @if($rubrica->materia)
            <a href="{{ route('materias.show', $rubrica->materia) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition-colors">
                Ver materia →
            </a>
        @endif
    </div>
</div>
@endsection
