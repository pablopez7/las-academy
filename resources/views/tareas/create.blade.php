@extends('layouts.app')

@section('title', 'Nueva Tarea - LAS Academy')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('tareas.index') }}" class="inline-flex items-center text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver a Mis Tareas
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">Nueva Tarea</h1>
        <p class="mt-2 text-gray-600 dark:text-slate-300">Crea una nueva tarea o asignación</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg border border-gray-200 dark:border-slate-800">
        <form method="POST" action="{{ route('tareas.store') }}" class="p-8 space-y-6">
            @csrf

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

            <!-- Titulo -->
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                    Título <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="titulo"
                       name="titulo"
                       value="{{ old('titulo') }}"
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
                          placeholder="Describe los detalles de la tarea...">{{ old('descripcion') }}</textarea>
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
                            <option value="{{ $materia->id }}" {{ old('materia_id') == $materia->id ? 'selected' : '' }}>
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
                            <option value="{{ $encuentro->id }}" {{ old('encuentro_id') == $encuentro->id ? 'selected' : '' }}>
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
                        <option value="tarea" {{ old('tipo') == 'tarea' ? 'selected' : '' }}>Tarea</option>
                        <option value="trabajo" {{ old('tipo') == 'trabajo' ? 'selected' : '' }}>Trabajo</option>
                        <option value="lectura" {{ old('tipo') == 'lectura' ? 'selected' : '' }}>Lectura</option>
                        <option value="evaluacion" {{ old('tipo') == 'evaluacion' ? 'selected' : '' }}>Evaluación</option>
                        <option value="otro" {{ old('tipo') == 'otro' ? 'selected' : '' }}>Otro</option>
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
                        <option value="alta" {{ old('prioridad') == 'alta' ? 'selected' : '' }}>Alta</option>
                        <option value="media" {{ old('prioridad', 'media') == 'media' ? 'selected' : '' }}>Media</option>
                        <option value="baja" {{ old('prioridad') == 'baja' ? 'selected' : '' }}>Baja</option>
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
                           value="{{ old('fecha_asignacion', date('Y-m-d')) }}"
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
                           value="{{ old('fecha_entrega') }}"
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
                    <option value="pendiente" {{ old('estado', 'pendiente') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="en_progreso" {{ old('estado') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                    <option value="completada" {{ old('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                    <option value="cancelada" {{ old('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
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
                        <option value="{{ $rubrica->id }}" {{ old('rubrica_id') == $rubrica->id ? 'selected' : '' }}>
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
                          placeholder="Añade cualquier nota o comentario personal sobre esta tarea...">{{ old('notas_adicionales') }}</textarea>
                @error('notas_adicionales')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-slate-800">
                <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 text-white rounded-lg transition-colors font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Crear Tarea
                </button>

                <a href="{{ route('tareas.index') }}"
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
                    <li>Asigna una prioridad para organizar mejor tus tareas.</li>
                    <li>Puedes vincular una rúbrica para tener claridad sobre los criterios de evaluación.</li>
                    <li>Usa las notas adicionales para guardar información relevante personal.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
