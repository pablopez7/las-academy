@extends('layouts.app')

@section('title', 'Rúbricas de Evaluación')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-slate-800 rounded-lg p-6 mb-6">
        <h1 class="text-3xl font-bold text-white mb-2">Rúbricas de Evaluación</h1>
        <p class="text-slate-300">Criterios de evaluación para trabajos de cada materia</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        @forelse($rubricas as $rubrica)
            <div class="bg-slate-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-indigo-500 transition-all">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white mb-2">
                                @if($rubrica->materia)
                                    {{ $rubrica->materia->nombre }}
                                @else
                                    {{ $rubrica->titulo }}
                                @endif
                            </h3>
                            @if($rubrica->encuentro)
                                <span class="inline-block bg-indigo-600 text-white text-xs px-2 py-1 rounded">
                                    {{ $rubrica->encuentro->nombre }}
                                </span>
                            @endif
                        </div>
                        <div class="bg-indigo-600 text-white px-3 py-2 rounded-lg text-center">
                            <div class="text-xl font-bold">{{ $rubrica->puntos_totales }}</div>
                            <div class="text-xs">pts</div>
                        </div>
                    </div>

                    @if($rubrica->descripcion)
                        <p class="text-slate-300 text-sm mb-4">{{ Str::limit($rubrica->descripcion, 100) }}</p>
                    @endif

                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span class="text-slate-400 text-sm">{{ count($rubrica->criterios) }} criterios de evaluación</span>
                    </div>

                    <a href="{{ route('rubricas.show', $rubrica) }}"
                       class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center px-4 py-2 rounded-lg transition-colors">
                        Ver rúbrica completa
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-2 bg-slate-800 rounded-lg p-12 text-center">
                <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-slate-400 text-lg">No hay rúbricas disponibles</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
