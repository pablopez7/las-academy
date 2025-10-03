@extends('layouts.app')

@section('title', $tarea->titulo . ' - LAS Academy')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ showNotesForm: false }">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('tareas.index') }}" class="inline-flex items-center text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver a Mis Tareas
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg border border-gray-200 dark:border-slate-800 overflow-hidden">
        <!-- Header -->
        <div class="p-8 border-b border-gray-200 dark:border-slate-800">
            <!-- Badges -->
            <div class="flex items-center gap-2 mb-4 flex-wrap">
                <span class="px-3 py-1.5 rounded-full text-sm font-medium {{ $tarea->getBadgeColorTipo() }}">
                    {{ ucfirst($tarea->tipo) }}
                </span>
                <span class="px-3 py-1.5 rounded-full text-sm font-medium {{ $tarea->getBadgeColorEstado() }}">
                    {{ ucfirst(str_replace('_', ' ', $tarea->estado)) }}
                </span>
                <span class="px-3 py-1.5 rounded-full text-sm font-medium {{ $tarea->getBadgeColorPrioridad() }}">
                    Prioridad {{ ucfirst($tarea->prioridad) }}
                </span>
                @if($tarea->validada)
                    <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                        Validada
                    </span>
                @endif
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-4">{{ $tarea->titulo }}</h1>

            <!-- Meta Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($tarea->materia)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-sm"
                             style="background-color: {{ $tarea->materia->color }};">
                            {{ substr($tarea->materia->nombre, 0, 2) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-slate-500">Materia</p>
                            <p class="font-medium text-gray-900 dark:text-slate-100">{{ $tarea->materia->nombre }}</p>
                        </div>
                    </div>
                @endif

                @if($tarea->encuentro)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-slate-500">Encuentro</p>
                            <p class="font-medium text-gray-900 dark:text-slate-100">{{ $tarea->encuentro->nombre }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Content -->
        <div class="p-8 space-y-8">
            <!-- Description -->
            @if($tarea->descripcion)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                        Descripción
                    </h2>
                    <div class="prose prose-sm max-w-none dark:prose-invert text-gray-700 dark:text-slate-300">
                        {!! nl2br(e($tarea->descripcion)) !!}
                    </div>
                </div>
            @endif

            <!-- Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($tarea->fecha_asignacion)
                    <div class="bg-gray-50 dark:bg-slate-950 rounded-lg p-4 border border-gray-200 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-slate-500">Fecha de Asignación</p>
                                <p class="font-semibold text-gray-900 dark:text-slate-100">
                                    {{ $tarea->fecha_asignacion->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($tarea->fecha_entrega)
                    <div class="bg-gray-50 dark:bg-slate-950 rounded-lg p-4 border border-gray-200 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 {{ $tarea->esUrgente() ? 'text-red-500' : 'text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 dark:text-slate-500">Fecha de Entrega</p>
                                <p class="font-semibold text-gray-900 dark:text-slate-100">
                                    {{ $tarea->fecha_entrega->format('d/m/Y') }}
                                </p>
                                @php
                                    $dias = $tarea->diasRestantes();
                                @endphp
                                @if($dias !== null && $tarea->estado !== 'completada')
                                    <p class="text-sm font-medium {{ $dias < 0 ? 'text-red-600 dark:text-red-400' : ($dias <= 3 ? 'text-orange-600 dark:text-orange-400' : 'text-green-600 dark:text-green-400') }}">
                                        @if($dias < 0)
                                            Vencida hace {{ abs($dias) }} días
                                        @elseif($dias == 0)
                                            Vence hoy
                                        @elseif($dias == 1)
                                            Vence mañana
                                        @else
                                            Faltan {{ $dias }} días
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Original Resource Link -->
            @if($tarea->recursoOrigen)
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        Recurso Original
                    </h3>
                    <a href="{{ route('recursos.show', $tarea->recursoOrigen) }}"
                       class="text-blue-700 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline">
                        {{ $tarea->recursoOrigen->titulo }}
                    </a>
                </div>
            @endif

            <!-- Context from Extraction -->
            @if($tarea->contexto_original)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Contexto Original
                    </h2>
                    <div class="bg-gray-50 dark:bg-slate-950 rounded-lg p-4 border border-gray-200 dark:border-slate-800">
                        <p class="text-sm text-gray-700 dark:text-slate-300 whitespace-pre-wrap">{{ $tarea->contexto_original }}</p>
                    </div>
                </div>
            @endif

            <!-- Rubrica -->
            @if($tarea->rubrica)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-slate-100 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Rúbrica de Evaluación
                    </h2>
                    <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-medium text-purple-900 dark:text-purple-300">{{ $tarea->rubrica->titulo }}</h3>
                            <a href="{{ route('rubricas.show', $tarea->rubrica) }}"
                               class="text-sm text-purple-700 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 hover:underline">
                                Ver rúbrica completa →
                            </a>
                        </div>
                        @if($tarea->rubrica->descripcion)
                            <p class="text-sm text-purple-800 dark:text-purple-300">{{ $tarea->rubrica->descripcion }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Student Notes -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-slate-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Mis Notas
                    </h2>
                    <button @click="showNotesForm = !showNotesForm"
                            class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium">
                        <span x-text="showNotesForm ? 'Cancelar' : 'Editar'"></span>
                    </button>
                </div>

                <!-- Notes Display -->
                <div x-show="!showNotesForm" class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    @if($tarea->notas_adicionales)
                        <p class="text-sm text-gray-700 dark:text-slate-300 whitespace-pre-wrap">{{ $tarea->notas_adicionales }}</p>
                    @else
                        <p class="text-sm text-gray-500 dark:text-slate-500 italic">No hay notas adicionales.</p>
                    @endif
                </div>

                <!-- Notes Form -->
                <div x-show="showNotesForm"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     style="display: none;">
                    <form method="POST" action="{{ route('tareas.update-notes', $tarea) }}">
                        @csrf
                        @method('PATCH')
                        <textarea name="notas_adicionales"
                                  rows="4"
                                  class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent resize-none"
                                  placeholder="Añade tus notas personales sobre esta tarea...">{{ $tarea->notas_adicionales }}</textarea>
                        <div class="flex gap-3 mt-3">
                            <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white rounded-lg transition-colors text-sm font-medium">
                                Guardar Notas
                            </button>
                            <button type="button" @click="showNotesForm = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg transition-colors text-sm font-medium">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="px-8 py-6 bg-gray-50 dark:bg-slate-950 border-t border-gray-200 dark:border-slate-800 flex flex-col sm:flex-row gap-4 justify-between">
            <div class="flex gap-3">
                <a href="{{ route('tareas.edit', $tarea) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg transition-colors text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
                </a>

                @if($tarea->estado !== 'completada')
                    <form method="POST" action="{{ route('tareas.marcar-completada', $tarea) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                onclick="return confirm('¿Marcar esta tarea como completada?')"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-white rounded-lg transition-colors text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Marcar Completada
                        </button>
                    </form>
                @endif
            </div>

            <form method="POST" action="{{ route('tareas.destroy', $tarea) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white rounded-lg transition-colors text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Eliminar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
