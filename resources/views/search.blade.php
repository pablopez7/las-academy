@extends('layouts.app')

@section('title', 'Buscar: ' . $query . ' - LAS Academy')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-2">Resultados de búsqueda</h1>
        <p class="text-gray-600 dark:text-slate-300">Mostrando resultados para: <strong>{{ $query }}</strong></p>
    </div>

    @if($recursos->count() > 0)
    <div class="space-y-4">
        @foreach($recursos as $recurso)
        <a href="{{ route('recursos.show', $recurso) }}" class="card hover:shadow-lg transition-shadow block group">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h3 class="font-bold text-gray-900 dark:text-slate-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors mb-2">
                        {{ $recurso->titulo }}
                    </h3>

                    @if($recurso->descripcion)
                    <p class="text-gray-600 dark:text-slate-300 mb-3">{{ Str::limit($recurso->descripcion, 200) }}</p>
                    @endif

                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-slate-400">
                        @if($recurso->materia)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $recurso->materia->color }}20; color: {{ $recurso->materia->color }};">
                            {{ $recurso->materia->nombre }}
                        </span>
                        @endif
                        @if($recurso->encuentro)
                        <span>Encuentro {{ $recurso->encuentro->numero }}</span>
                        @else
                        <span>Material complementario</span>
                        @endif
                        <span>{{ ucfirst($recurso->tipo) }}</span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="mt-8">
        {{ $recursos->links() }}
    </div>
    @else
    <div class="card text-center py-12">
        <p class="text-gray-500 dark:text-slate-400 mb-4">No se encontraron resultados para "{{ $query }}"</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Volver al inicio</a>
    </div>
    @endif
</div>
@endsection
