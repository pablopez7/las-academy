@extends('layouts.app')

@section('title', 'Editar Tarea - LAS Academy')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('tareas.show', $tarea) }}" class="inline-flex items-center text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver a Detalle de Tarea
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">Editar Tarea</h1>
            <p class="mt-2 text-gray-600 dark:text-slate-300">Modifica los detalles de la tarea</p>
        </div>

        <!-- Delete Button -->
        <form method="POST" action="{{ route('tareas.destroy', $tarea) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea? Esta acción no se puede deshacer.')"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white rounded-lg transition-colors text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Eliminar Tarea
            </button>
        </form>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg border border-gray-200 dark:border-slate-800">
        <form method="POST" action="{{ route('tareas.update', $tarea) }}" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Error Summary -->
            @if($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-sm font-semibold text-red-800 dark:text-red-300">Por favor corrige los siguientes errores:</h3>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p class="text-sm text-green-800 dark:text-green-300">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Titulo -->
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                    Título <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="titulo"
                       name="titulo"
                       value="{{ old('titulo', $tarea->titulo) }}"
                       required
                       class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent @error('titulo') border-red-500 @enderror"
                       placeholder="Ej: Lectura capítulo 3">
                @error('titulo')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripcion -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                    Descripción
                </label>
                <textarea id="descripcion"
                          name="descripcion"
                          rows="4"
                          class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent resize-none @error('descripcion') border-red-500 @enderror"
                          placeholder="Describe los detalles de la tarea...">{{ old('descripcion', $tarea->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Materia & Encuentro -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Materia -->
                <div>
                    <label for="materia_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Materia <span class="text-red-500">*</span>
                    </label>
                    <select id="materia_id"
                            name="materia_id"
                            required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent @error('materia_id') border-red-500 @enderror">
                        <option value="">Selecciona una materia</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->id }}" {{ old('materia_id', $tarea->materia_id) == $materia->id ? 'selected' : '' }}>
                                {{ $materia->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('materia_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Encuentro -->
                <div>
                    <label for="encuentro_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Encuentro
                    </label>
                    <select id="encuentro_id"
                            name="encuentro_id"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent @error('encuentro_id') border-red-500 @enderror">
                        <option value="">Selecciona un encuentro</option>
                        @foreach($encuentros as $encuentro)
                            <option value="{{ $encuentro->id }}" {{ old('encuentro_id', $tarea->encuentro_id) == $encuentro->id ? 'selected' : '' }}>
                                {{ $encuentro->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('encuentro_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tipo & Prioridad -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tipo -->
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Tipo de Tarea <span class="text-red-500">*</span>
                    </label>
                    <select id="tipo"
                            name="tipo"
                            required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent @error('tipo') border-red-500 @enderror">
                        <option value="">Selecciona un tipo</option>
                        <option value="tarea" {{ old('tipo', $tarea->tipo) == 'tarea' ? 'selected' : '' }}>Tarea</option>
                        <option value="trabajo" {{ old('tipo', $tarea->tipo) == 'trabajo' ? 'selected' : '' }}>Trabajo</option>
                        <option value="lectura" {{ old('tipo', $tarea->tipo) == 'lectura' ? 'selected' : '' }}>Lectura</option>
                        <option value="evaluacion" {{ old('tipo', $tarea->tipo) == 'evaluacion' ? 'selected' : '' }}>Evaluación</option>
                        <option value="otro" {{ old('tipo', $tarea->tipo) == 'otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('tipo')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prioridad -->
                <div>
                    <label for="prioridad" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Prioridad <span class="text-red-500">*</span>
                    </label>
                    <select id="prioridad"
                            name="prioridad"
                            required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent @error('prioridad') border-red-500 @enderror">
                        <option value="">Selecciona prioridad</option>
                        <option value="alta" {{ old('prioridad', $tarea->prioridad) == 'alta' ? 'selected' : '' }}>Alta</option>
                        <option value="media" {{ old('prioridad', $tarea->prioridad) == 'media' ? 'selected' : '' }}>Media</option>
                        <option value="baja" {{ old('prioridad', $tarea->prioridad) == 'baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                    @error('prioridad')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Fecha Asignacion -->
                <div>
                    <label for="fecha_asignacion" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Fecha de Asignación
                    </label>
                    <input type="date"
                           id="fecha_asignacion"
                           name="fecha_asignacion"
                           value="{{ old('fecha_asignacion', $tarea->fecha_asignacion?->format('Y-m-d')) }}"
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent @error('fecha_asignacion') border-red-500 @enderror">
                    @error('fecha_asignacion')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha Entrega -->
                <div>
                    <label for="fecha_entrega" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                        Fecha de Entrega <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           id="fecha_entrega"
                           name="fecha_entrega"
                           value="{{ old('fecha_entrega', $tarea->fecha_entrega?->format('Y-m-d')) }}"
                           required
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent @error('fecha_entrega') border-red-500 @enderror">
                    @error('fecha_entrega')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Estado -->
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                    Estado <span class="text-red-500">*</span>
                </label>
                <select id="estado"
                        name="estado"
                        required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent @error('estado') border-red-500 @enderror">
                    <option value="pendiente" {{ old('estado', $tarea->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="en_progreso" {{ old('estado', $tarea->estado) == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                    <option value="completada" {{ old('estado', $tarea->estado) == 'completada' ? 'selected' : '' }}>Completada</option>
                    <option value="cancelada" {{ old('estado', $tarea->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
                @error('estado')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rubrica -->
            <div>
                <label for="rubrica_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                    Rúbrica de Evaluación
                </label>
                <select id="rubrica_id"
                        name="rubrica_id"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent @error('rubrica_id') border-red-500 @enderror">
                    <option value="">Sin rúbrica</option>
                    @foreach($rubricas as $rubrica)
                        <option value="{{ $rubrica->id }}" {{ old('rubrica_id', $tarea->rubrica_id) == $rubrica->id ? 'selected' : '' }}>
                            {{ $rubrica->titulo }} @if($rubrica->materia) - {{ $rubrica->materia->nombre }} @endif
                        </option>
                    @endforeach
                </select>
                @error('rubrica_id')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notas Adicionales -->
            <div>
                <label for="notas_adicionales" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                    Notas Adicionales
                </label>
                <textarea id="notas_adicionales"
                          name="notas_adicionales"
                          rows="3"
                          class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-950 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent resize-none @error('notas_adicionales') border-red-500 @enderror"
                          placeholder="Añade cualquier nota o comentario personal sobre esta tarea...">{{ old('notas_adicionales', $tarea->notas_adicionales) }}</textarea>
                @error('notas_adicionales')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Validation Status (Read-only) -->
            @if($tarea->validada)
                <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-purple-800 dark:text-purple-300 font-medium">Esta tarea ha sido validada</p>
                    </div>
                </div>
            @endif

            <!-- Original Resource Info (if exists) -->
            @if($tarea->recursoOrigen)
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-blue-800 dark:text-blue-300 font-medium mb-1">Esta tarea fue extraída de un recurso</p>
                            <a href="{{ route('recursos.show', $tarea->recursoOrigen) }}"
                               class="text-sm text-blue-700 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline">
                                Ver recurso original: {{ $tarea->recursoOrigen->titulo }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-slate-800">
                <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white rounded-lg transition-colors font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Guardar Cambios
                </button>

                <a href="{{ route('tareas.show', $tarea) }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg transition-colors font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Help Text -->
    <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-1">Consejos</h4>
                <ul class="text-sm text-blue-800 dark:text-blue-300 space-y-1 list-disc list-inside">
                    <li>Los campos marcados con <span class="text-red-500">*</span> son obligatorios.</li>
                    <li>Actualiza el estado de la tarea según tu progreso.</li>
                    <li>Puedes cambiar la fecha de entrega si es necesario.</li>
                    <li>Los cambios se guardarán inmediatamente al hacer clic en "Guardar Cambios".</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
