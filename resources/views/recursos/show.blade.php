@extends('layouts.app')

@section('title', $recurso->titulo . ' - LAS Academy')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center gap-2 text-gray-500 dark:text-slate-400">
            <li><a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Inicio</a></li>
            <li>/</li>
            @if($recurso->materia)
            <li><a href="{{ route('materias.show', $recurso->materia) }}" class="hover:text-primary-600 dark:hover:text-primary-400">{{ $recurso->materia->nombre }}</a></li>
            <li>/</li>
            @endif
            <li class="text-gray-900 dark:text-slate-100 font-medium">{{ $recurso->titulo }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="card mb-8">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-3">{{ $recurso->titulo }}</h1>

                <div class="flex flex-wrap items-center gap-3">
                    @if($recurso->materia)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" style="background-color: {{ $recurso->materia->color }}20; color: {{ $recurso->materia->color }};">
                        {{ $recurso->materia->nombre }}
                    </span>
                    @endif
                    @if($recurso->encuentro)
                    <span class="text-gray-500 dark:text-slate-400 text-sm">Encuentro {{ $recurso->encuentro->numero }}</span>
                    @else
                    <span class="text-gray-500 dark:text-slate-400 text-sm">Material complementario</span>
                    @endif
                    @if($recurso->duracion_minutos)
                    <span class="text-gray-500 dark:text-slate-400 text-sm">⏱️ {{ $recurso->duracion_minutos }} minutos</span>
                    @endif
                </div>
            </div>

            @if($recurso->archivo_ruta)
            <a href="{{ route('recursos.download', $recurso) }}" class="btn btn-primary">
                ⬇️ Descargar
            </a>
            @endif
        </div>

        @if($recurso->descripcion)
        <p class="text-lg text-gray-600 dark:text-slate-300 mb-4">{{ $recurso->descripcion }}</p>
        @endif
    </div>

    <!-- Contenido -->
    @if($recurso->contenido)
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-4">Contenido</h2>
        <div class="prose max-w-none">
            {!! nl2br(e($recurso->contenido)) !!}
        </div>
    </div>
    @endif

    <!-- Video o URL Externa -->
    @if($recurso->url_externa)
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-4">Enlace Externo</h2>
        <a href="{{ $recurso->url_externa }}" target="_blank" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium">
            {{ $recurso->url_externa }} ↗
        </a>
    </div>
    @endif

    <!-- Recursos Relacionados -->
    @if($recursosRelacionados->count() > 0)
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-4">Recursos Relacionados</h2>
        <div class="grid gap-4 md:grid-cols-2">
            @foreach($recursosRelacionados as $relacionado)
            <a href="{{ route('recursos.show', $relacionado) }}" class="card hover:shadow-lg transition-shadow group">
                <h3 class="font-semibold text-gray-900 dark:text-slate-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors mb-2">
                    {{ $relacionado->titulo }}
                </h3>
                @if($relacionado->descripcion)
                <p class="text-sm text-gray-600 dark:text-slate-300">{{ Str::limit($relacionado->descripcion, 80) }}</p>
                @endif
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
