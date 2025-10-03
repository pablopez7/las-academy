@extends('layouts.app')

@section('title', 'Mis Tareas - LAS Academy')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{
    showFilters: false,
    sortBy: '{{ request('sort', 'fecha_entrega') }}'
}">
    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">Mis Tareas</h1>
            <p class="mt-2 text-gray-600 dark:text-slate-300">Gestiona tus asignaciones y entregas</p>
        </div>
        <a href="{{ route('tareas.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white rounded-lg transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nueva Tarea
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg border border-gray-200 dark:border-slate-800 mb-6 p-4">
        <form method="GET" action="{{ route('tareas.index') }}" class="space-y-4">
            <!-- Search -->
            <div class="relative">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Buscar tareas por título o descripción..."
                       class="w-full px-4 py-3 pl-11 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors">
                <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <!-- Toggle Filters -->
            <div class="flex items-center justify-between">
                <button type="button"
                        @click="showFilters = !showFilters"
                        class="inline-flex items-center text-sm text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    <span x-text="showFilters ? 'Ocultar Filtros' : 'Mostrar Filtros'">Mostrar Filtros</span>
                </button>

                <!-- Sort Dropdown -->
                <div class="flex items-center gap-3">
                    <label class="text-sm text-gray-600 dark:text-slate-400">Ordenar por:</label>
                    <select name="sort"
                            x-model="sortBy"
                            onchange="this.form.submit()"
                            class="px-3 py-2 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-sm text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors">
                        <option value="fecha_entrega" {{ request('sort') == 'fecha_entrega' ? 'selected' : '' }}>Fecha de Entrega</option>
                        <option value="prioridad" {{ request('sort') == 'prioridad' ? 'selected' : '' }}>Prioridad</option>
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Fecha de Creación</option>
                        <option value="titulo" {{ request('sort') == 'titulo' ? 'selected' : '' }}>Título</option>
                    </select>
                </div>
            </div>

            <!-- Filters Panel -->
            <div x-show="showFilters"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 pt-4 border-t border-gray-200 dark:border-slate-700">

                <!-- Materia Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Materia</label>
                    <select name="materia_id" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-sm text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors">
                        <option value="">Todas</option>
                        @foreach($materias ?? [] as $materia)
                            <option value="{{ $materia->id }}" {{ request('materia_id') == $materia->id ? 'selected' : '' }}>
                                {{ $materia->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Encuentro Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Encuentro</label>
                    <select name="encuentro_id" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-sm text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors">
                        <option value="">Todos</option>
                        @foreach($encuentros ?? [] as $encuentro)
                            <option value="{{ $encuentro->id }}" {{ request('encuentro_id') == $encuentro->id ? 'selected' : '' }}>
                                {{ $encuentro->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tipo Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Tipo</label>
                    <select name="tipo" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-sm text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors">
                        <option value="">Todos</option>
                        <option value="tarea" {{ request('tipo') == 'tarea' ? 'selected' : '' }}>Tarea</option>
                        <option value="trabajo" {{ request('tipo') == 'trabajo' ? 'selected' : '' }}>Trabajo</option>
                        <option value="lectura" {{ request('tipo') == 'lectura' ? 'selected' : '' }}>Lectura</option>
                        <option value="evaluacion" {{ request('tipo') == 'evaluacion' ? 'selected' : '' }}>Evaluación</option>
                        <option value="otro" {{ request('tipo') == 'otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <!-- Estado Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Estado</label>
                    <select name="estado" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-sm text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors">
                        <option value="">Todos</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_progreso" {{ request('estado') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                        <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>

                <!-- Prioridad Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Prioridad</label>
                    <select name="prioridad" class="w-full px-3 py-2 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-sm text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors">
                        <option value="">Todas</option>
                        <option value="alta" {{ request('prioridad') == 'alta' ? 'selected' : '' }}>Alta</option>
                        <option value="media" {{ request('prioridad') == 'media' ? 'selected' : '' }}>Media</option>
                        <option value="baja" {{ request('prioridad') == 'baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white rounded-lg transition-colors text-sm font-medium">
                    Aplicar Filtros
                </button>
                <a href="{{ route('tareas.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg transition-colors text-sm font-medium">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Tasks Grid -->
    @if($tareas->count() > 0)
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-8">
            @foreach($tareas as $tarea)
                <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg border border-gray-200 dark:border-slate-800 hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <!-- Card Header with Status Indicator -->
                    <div class="p-6">
                        <!-- Badges Row -->
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            <!-- Tipo Badge -->
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $tarea->getBadgeColorTipo() }}">
                                {{ ucfirst($tarea->tipo) }}
                            </span>

                            <!-- Estado Badge -->
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $tarea->getBadgeColorEstado() }}">
                                {{ ucfirst(str_replace('_', ' ', $tarea->estado)) }}
                            </span>

                            <!-- Prioridad Badge -->
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $tarea->getBadgeColorPrioridad() }}">
                                {{ ucfirst($tarea->prioridad) }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-lg text-gray-900 dark:text-slate-100 mb-2 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            <a href="{{ route('tareas.show', $tarea) }}">{{ $tarea->titulo }}</a>
                        </h3>

                        <!-- Description -->
                        @if($tarea->descripcion)
                            <p class="text-sm text-gray-600 dark:text-slate-400 line-clamp-3 mb-4">
                                {{ $tarea->descripcion }}
                            </p>
                        @endif

                        <!-- Materia & Encuentro -->
                        <div class="space-y-2 mb-4">
                            @if($tarea->materia)
                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                                    <div class="w-4 h-4 rounded" style="background-color: {{ $tarea->materia->color }};"></div>
                                    <span>{{ $tarea->materia->nombre }}</span>
                                </div>
                            @endif

                            @if($tarea->encuentro)
                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ $tarea->encuentro->nombre }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Due Date with Countdown -->
                        @if($tarea->fecha_entrega)
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-slate-700">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 {{ $tarea->esUrgente() ? 'text-red-500' : 'text-gray-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm {{ $tarea->esUrgente() ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-600 dark:text-slate-400' }}">
                                        {{ $tarea->fecha_entrega->format('d/m/Y') }}
                                    </span>
                                </div>

                                @php
                                    $dias = $tarea->diasRestantes();
                                @endphp

                                @if($dias !== null && $tarea->estado !== 'completada')
                                    <div class="text-sm font-medium {{ $dias < 0 ? 'text-red-600 dark:text-red-400' : ($dias <= 3 ? 'text-orange-600 dark:text-orange-400' : 'text-green-600 dark:text-green-400') }}">
                                        @if($dias < 0)
                                            Vencida ({{ abs($dias) }}d)
                                        @elseif($dias == 0)
                                            Vence hoy
                                        @elseif($dias == 1)
                                            Vence mañana
                                        @else
                                            {{ $dias }} días
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Card Footer Actions -->
                    <div class="px-6 py-3 bg-gray-50 dark:bg-slate-950 border-t border-gray-200 dark:border-slate-800">
                        <a href="{{ route('tareas.show', $tarea) }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium transition-colors">
                            Ver detalles →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $tareas->withQueryString()->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg border border-gray-200 dark:border-slate-800 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-2">No hay tareas</h3>
            <p class="text-gray-600 dark:text-slate-400 mb-4">
                @if(request()->hasAny(['search', 'materia_id', 'encuentro_id', 'tipo', 'estado', 'prioridad']))
                    No se encontraron tareas con los filtros aplicados.
                @else
                    Aún no tienes tareas asignadas.
                @endif
            </p>
            @if(request()->hasAny(['search', 'materia_id', 'encuentro_id', 'tipo', 'estado', 'prioridad']))
                <a href="{{ route('tareas.index') }}" class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium">
                    Limpiar filtros
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
