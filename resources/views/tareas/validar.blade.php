@extends('layouts.app')

@section('title', 'Validar Tareas Extraídas')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">Validar Tareas Extraídas</h1>
        <p class="mt-2 text-gray-600 dark:text-slate-300">Revisa las menciones encontradas y conviértelas en tareas</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="card">
            <div class="text-sm text-gray-500 dark:text-slate-400">Total Menciones</div>
            <div class="text-3xl font-bold text-gray-900 dark:text-slate-100">{{ count($menciones) }}</div>
        </div>
        <div class="card">
            <div class="text-sm text-gray-500 dark:text-slate-400">Alta Confianza 🔴</div>
            <div class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $stats['alta'] ?? 0 }}</div>
        </div>
        <div class="card">
            <div class="text-sm text-gray-500 dark:text-slate-400">Media Confianza 🟡</div>
            <div class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['media'] ?? 0 }}</div>
        </div>
        <div class="card">
            <div class="text-sm text-gray-500 dark:text-slate-400">Baja Confianza 🟢</div>
            <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['baja'] ?? 0 }}</div>
        </div>
    </div>

    {{-- Filtros de confianza --}}
    <div class="flex gap-2 mb-6" x-data="{ filtro: 'todos' }">
        <button @click="filtro = 'todos'"
                :class="filtro === 'todos' ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-slate-300'"
                class="px-4 py-2 rounded-lg transition-colors">
            Todos
        </button>
        <button @click="filtro = 'alta'"
                :class="filtro === 'alta' ? 'bg-red-600 text-white' : 'bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-slate-300'"
                class="px-4 py-2 rounded-lg transition-colors">
            Alta 🔴
        </button>
        <button @click="filtro = 'media'"
                :class="filtro === 'media' ? 'bg-orange-600 text-white' : 'bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-slate-300'"
                class="px-4 py-2 rounded-lg transition-colors">
            Media 🟡
        </button>
        <button @click="filtro = 'baja'"
                :class="filtro === 'baja' ? 'bg-green-600 text-white' : 'bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-slate-300'"
                class="px-4 py-2 rounded-lg transition-colors">
            Baja 🟢
        </button>

        {{-- Menciones procesadas --}}
        <template x-if="filtro !== 'todos'">
            <div class="ml-auto flex items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-slate-400" x-text="`${$refs.container.querySelectorAll('[data-confianza='+ filtro +']').length} menciones`"></span>
            </div>
        </template>
    </div>

    {{-- Lista de menciones --}}
    <div class="space-y-4" x-ref="container" x-data="{ filtro: 'todos' }">
        @foreach($menciones as $index => $mencion)
        <div class="card hover:shadow-lg transition-all"
             data-confianza="{{ $mencion['confianza'] }}"
             x-show="filtro === 'todos' || filtro === '{{ $mencion['confianza'] }}'"
             x-data="mencionCard({{ $index }}, @js($mencion))">

            {{-- Header --}}
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{
                            $mencion['confianza'] === 'alta' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' :
                            ($mencion['confianza'] === 'media' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' :
                            'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400')
                        }}">
                            {{ ucfirst($mencion['confianza']) }}
                        </span>

                        @if($mencion['recurso']['materia'])
                        <span class="text-sm text-gray-600 dark:text-slate-300">
                            {{ $mencion['recurso']['materia'] }}
                        </span>
                        @endif

                        @if($mencion['recurso']['encuentro'])
                        <span class="text-sm text-gray-500 dark:text-slate-400">
                            Encuentro {{ $mencion['recurso']['encuentro'] }}
                        </span>
                        @endif
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">
                        {{ $mencion['recurso']['titulo'] }}
                    </h3>
                </div>

                <div class="flex gap-2">
                    <button @click="crearTarea()"
                            x-show="!procesada"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                        ✓ Es una tarea
                    </button>
                    <button @click="descartarMencion()"
                            x-show="!procesada"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                        ✗ No es tarea
                    </button>
                    <span x-show="procesada" class="px-4 py-2 bg-gray-300 dark:bg-slate-700 text-gray-600 dark:text-slate-400 rounded-lg">
                        Procesada
                    </span>
                </div>
            </div>

            {{-- Contexto --}}
            <div class="bg-gray-50 dark:bg-slate-900 rounded-lg p-4 mb-4">
                <div class="text-sm text-gray-600 dark:text-slate-300 whitespace-pre-wrap font-mono">{{ $mencion['contexto_completo'] }}</div>
            </div>

            {{-- Formulario inline --}}
            <div x-show="!procesada" x-collapse>
                <form @submit.prevent="enviarTarea" class="space-y-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Título</label>
                            <input type="text" x-model="formulario.titulo" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-slate-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tipo</label>
                            <select x-model="formulario.tipo" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-slate-100">
                                <option value="tarea">Tarea</option>
                                <option value="trabajo">Trabajo</option>
                                <option value="lectura">Lectura</option>
                                <option value="evaluacion">Evaluación</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Descripción</label>
                        <textarea x-model="formulario.descripcion" rows="3" required
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-slate-100"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Prioridad</label>
                        <select x-model="formulario.prioridad" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-slate-100">
                            <option value="baja">Baja</option>
                            <option value="media">Media</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>

                    <button type="submit"
                            class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                        Crear Tarea
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
function mencionCard(index, mencion) {
    return {
        procesada: false,
        formulario: {
            titulo: mencion.patron_encontrado,
            descripcion: mencion.contexto_completo.substring(0, 200),
            recurso_origen_id: mencion.recurso.id,
            contexto_original: mencion.contexto_completo,
            materia_id: null,
            encuentro_id: null,
            tipo: 'tarea',
            prioridad: mencion.confianza === 'alta' ? 'alta' : (mencion.confianza === 'media' ? 'media' : 'baja')
        },

        crearTarea() {
            // Mostrar formulario
        },

        descartarMencion() {
            this.procesada = true;
        },

        async enviarTarea() {
            try {
                const response = await fetch('{{ route('tareas.crear-desde-mencion') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.formulario)
                });

                const data = await response.json();

                if (data.success) {
                    this.procesada = true;
                    alert('✓ Tarea creada exitosamente');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al crear la tarea');
            }
        }
    }
}
</script>
@endpush
@endsection
