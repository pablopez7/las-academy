@extends('layouts.app')

@section('title', $encuentro->nombre . ' - LAS Academy')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center gap-2 text-gray-500 dark:text-slate-400">
            <li><a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Inicio</a></li>
            <li>/</li>
            <li><a href="{{ route('encuentros.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Encuentros</a></li>
            <li>/</li>
            <li class="text-gray-900 dark:text-slate-100 font-medium">{{ $encuentro->nombre }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="card mb-8">
        <div class="flex items-start justify-between">
            <div>
                <div class="flex items-center gap-4 mb-3">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">{{ $encuentro->nombre }}</h1>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 font-bold">
                        {{ $encuentro->numero }}
                    </span>
                </div>

                @if($encuentro->descripcion)
                <p class="text-lg text-gray-600 dark:text-slate-300 mb-4">{{ $encuentro->descripcion }}</p>
                @endif

                @if($encuentro->fecha_inicio && $encuentro->fecha_fin)
                <p class="text-gray-500 dark:text-slate-400">
                    📅 {{ $encuentro->fecha_inicio->format('d/m/Y') }} - {{ $encuentro->fecha_fin->format('d/m/Y') }}
                </p>
                @endif
            </div>

            @if($encuentro->imagen_calendario)
            <div class="ml-6">
                <img src="{{ asset('storage/' . $encuentro->imagen_calendario) }}" alt="Calendario {{ $encuentro->nombre }}" class="rounded-lg shadow-md max-w-xs">
            </div>
            @endif
        </div>
    </div>

    <!-- Materias -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-slate-100 mb-6">Materias del Encuentro</h2>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($encuentro->materias as $materia)
            <a href="{{ route('materias.show', $materia) }}" class="card hover:shadow-lg transition-all group">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white font-bold" style="background-color: {{ $materia->color }};">
                        {{ substr($materia->nombre, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 dark:text-slate-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors mb-1">
                            {{ $materia->nombre }}
                        </h3>
                        @if($materia->descripcion)
                        <p class="text-sm text-gray-600 dark:text-slate-300">{{ Str::limit($materia->descripcion, 80) }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-slate-400">
                    <span>📚 {{ $materia->recursos_count }} recursos</span>
                    <span>📝 {{ $materia->tareas_count }} tareas</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
