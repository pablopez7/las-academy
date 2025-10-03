@extends('layouts.app')

@section('title', 'Inicio - LAS Academy')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-slate-100 mb-4">
            Bienvenido a LAS Academy
        </h1>
        <p class="text-xl text-gray-600 dark:text-slate-300">
            Plataforma educativa del Seminario Letra al que Sirve
        </p>
    </div>

    <!-- Mis Tareas Pendientes -->
    @if(isset($tareasEstudiante) && $tareasEstudiante->count() > 0)
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-slate-100">📝 Mis Tareas Pendientes</h2>
            <a href="{{ route('tareas.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium">
                Ver todas →
            </a>
        </div>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach($tareasEstudiante as $tarea)
            <a href="{{ route('tareas.show', $tarea) }}" class="card hover:shadow-lg transition-all group">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                        {{ $tarea->titulo }}
                    </h3>
                    @if($tarea->esUrgente())
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                        🔥 URGENTE
                    </span>
                    @endif
                </div>

                <p class="text-sm text-gray-600 dark:text-slate-300 mb-3">{{ Str::limit($tarea->descripcion, 80) }}</p>

                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2 py-1 rounded text-xs font-medium {{ $tarea->getBadgeColorTipo() }}">
                        {{ ucfirst($tarea->tipo) }}
                    </span>
                    <span class="px-2 py-1 rounded text-xs font-medium {{ $tarea->getBadgeColorPrioridad() }}">
                        {{ ucfirst($tarea->prioridad) }}
                    </span>
                </div>

                <div class="flex items-center justify-between text-sm">
                    @if($tarea->materia)
                    <span class="inline-flex items-center gap-1">
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $tarea->materia->color }};"></div>
                        <span class="text-gray-700 dark:text-slate-300">{{ $tarea->materia->nombre }}</span>
                    </span>
                    @endif

                    @if($tarea->fecha_entrega)
                    <span class="{{ $tarea->esUrgente() ? 'text-red-600 dark:text-red-400 font-bold' : 'text-gray-600 dark:text-slate-400' }}">
                        @if($tarea->diasRestantes() !== null)
                            @if($tarea->diasRestantes() == 0)
                                ⏰ Hoy
                            @elseif($tarea->diasRestantes() == 1)
                                ⏰ Mañana
                            @elseif($tarea->diasRestantes() > 0)
                                ⏰ {{ $tarea->diasRestantes() }} días
                            @else
                                ⚠️ Vencida
                            @endif
                        @else
                            📅 {{ $tarea->fecha_entrega->format('d/m/Y') }}
                        @endif
                    </span>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Próximas Tareas -->
    @if($proximasTareas->count() > 0)
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-slate-100 mb-6">Próximas Tareas del Seminario</h2>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach($proximasTareas as $tarea)
            <div class="card hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100">{{ $tarea->titulo }}</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-800 dark:text-primary-300">
                        {{ $tarea->materia->nombre }}
                    </span>
                </div>
                <p class="text-sm text-gray-600 dark:text-slate-300 mb-3">{{ Str::limit($tarea->descripcion, 100) }}</p>
                <div class="flex items-center justify-between text-sm">
                    @if($tarea->encuentro)
                    <span class="text-gray-500 dark:text-slate-400">Encuentro {{ $tarea->encuentro->numero }}</span>
                    @else
                    <span class="text-gray-500 dark:text-slate-400">Tarea general</span>
                    @endif
                    <span class="text-primary-600 dark:text-primary-400 font-medium">{{ $tarea->fecha_entrega->format('d/m/Y') }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Encuentros -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-slate-100 mb-6">Encuentros del Seminario</h2>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($encuentros as $encuentro)
            <a href="{{ route('encuentros.show', $encuentro) }}" class="card hover:shadow-lg transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                        {{ $encuentro->nombre }}
                    </h3>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 font-bold">
                        {{ $encuentro->numero }}
                    </span>
                </div>

                @if($encuentro->descripcion)
                <p class="text-gray-600 dark:text-slate-300 mb-4">{{ Str::limit($encuentro->descripcion, 120) }}</p>
                @endif

                @if($encuentro->fecha_inicio && $encuentro->fecha_fin)
                <p class="text-sm text-gray-500 dark:text-slate-400 mb-4">
                    {{ $encuentro->fecha_inicio->format('d/m/Y') }} - {{ $encuentro->fecha_fin->format('d/m/Y') }}
                </p>
                @endif

                <!-- Materias -->
                <div class="flex flex-wrap gap-2">
                    @foreach($encuentro->materias->take(4) as $materia)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $materia->color }}20; color: {{ $materia->color }};">
                        {{ $materia->nombre }}
                    </span>
                    @endforeach
                    @if($encuentro->materias->count() > 4)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-slate-300">
                        +{{ $encuentro->materias->count() - 4 }}
                    </span>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
