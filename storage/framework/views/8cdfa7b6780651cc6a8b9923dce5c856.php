

<?php $__env->startSection('title', $materia->nombre . ' - LAS Academy'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center gap-2 text-gray-500 dark:text-slate-400">
            <li><a href="<?php echo e(route('home')); ?>" class="hover:text-primary-600 dark:hover:text-primary-400">Inicio</a></li>
            <li>/</li>
            <li class="text-gray-900 dark:text-slate-100 font-medium"><?php echo e($materia->nombre); ?></li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="card mb-8" style="border-left: 4px solid <?php echo e($materia->color); ?>;">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 rounded-lg flex items-center justify-center text-white font-bold text-2xl" style="background-color: <?php echo e($materia->color); ?>;">
                <?php echo e(substr($materia->nombre, 0, 1)); ?>

            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-2"><?php echo e($materia->nombre); ?></h1>
                <?php if($materia->descripcion): ?>
                <p class="text-lg text-gray-600 dark:text-slate-300"><?php echo e($materia->descripcion); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recursos por Tipo -->
    <?php if($recursosPorTipo->count() > 0): ?>
    <div class="space-y-8">
        <?php $__currentLoopData = $recursosPorTipo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo => $recursos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-4 flex items-center gap-2">
                <?php switch($tipo):
                    case ('transcripcion'): ?>
                        📝 Transcripciones
                        <?php break; ?>
                    <?php case ('rubrica'): ?>
                        📋 Rúbricas
                        <?php break; ?>
                    <?php case ('resumen'): ?>
                        📄 Resúmenes
                        <?php break; ?>
                    <?php case ('material_apoyo'): ?>
                        📚 Material de Apoyo
                        <?php break; ?>
                    <?php case ('video'): ?>
                        🎥 Videos
                        <?php break; ?>
                    <?php default: ?>
                        📎 <?php echo e(ucfirst($tipo)); ?>

                <?php endswitch; ?>
            </h2>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $recursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recurso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('recursos.show', $recurso)); ?>" class="card hover:shadow-lg transition-shadow group">
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors mb-2">
                        <?php echo e($recurso->titulo); ?>

                    </h3>

                    <?php if($recurso->descripcion): ?>
                    <p class="text-sm text-gray-600 dark:text-slate-300 mb-3"><?php echo e(Str::limit($recurso->descripcion, 100)); ?></p>
                    <?php endif; ?>

                    <div class="flex items-center justify-between text-sm">
                        <?php if($recurso->encuentro): ?>
                            <span class="text-gray-500 dark:text-slate-400">Encuentro <?php echo e($recurso->encuentro->numero); ?></span>
                        <?php else: ?>
                            <span class="text-gray-500 dark:text-slate-400">Material complementario</span>
                        <?php endif; ?>
                        <?php if($recurso->duracion_minutos): ?>
                        <span class="text-primary-600 dark:text-primary-400">⏱️ <?php echo e($recurso->duracion_minutos); ?> min</span>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <div class="card text-center py-12">
        <p class="text-gray-500 dark:text-slate-400">No hay recursos disponibles para esta materia aún.</p>
    </div>
    <?php endif; ?>

    <!-- Tareas -->
    <?php if($materia->tareas->count() > 0): ?>
    <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-4">📝 Tareas</h2>

        <div class="space-y-4">
            <?php $__currentLoopData = $materia->tareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
                <!-- Header de tarea -->
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100"><?php echo e($tarea->titulo); ?></h3>
                        <?php if($tarea->encuentro): ?>
                        <span class="text-sm text-gray-500 dark:text-slate-400">Encuentro <?php echo e($tarea->encuentro->numero); ?></span>
                        <?php else: ?>
                        <span class="text-sm text-gray-500 dark:text-slate-400">Tarea general</span>
                        <?php endif; ?>
                    </div>
                    <?php if($tarea->fecha_entrega): ?>
                    <span class="text-sm font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 px-3 py-1 rounded-full">
                        📅 <?php echo e($tarea->fecha_entrega->format('d/m/Y')); ?>

                    </span>
                    <?php endif; ?>
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <p class="text-gray-700 dark:text-slate-300"><?php echo e($tarea->descripcion); ?></p>
                </div>

                <!-- Instrucciones (colapsable) -->
                <?php if($tarea->instrucciones): ?>
                <details class="mb-4 group">
                    <summary class="cursor-pointer font-medium text-gray-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors list-none flex items-center gap-2">
                        <svg class="w-4 h-4 transition-transform group-open:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        📋 Instrucciones detalladas
                    </summary>
                    <div class="mt-3 pl-6 border-l-2 border-primary-200 dark:border-primary-800">
                        <p class="text-gray-600 dark:text-slate-300 whitespace-pre-line"><?php echo e($tarea->instrucciones); ?></p>
                    </div>
                </details>
                <?php endif; ?>

                <!-- Rúbrica (expandible) -->
                <?php if($tarea->rubrica && isset($tarea->rubrica['criterios'])): ?>
                <details class="bg-gray-50 dark:bg-slate-900 rounded-lg p-4 group">
                    <summary class="cursor-pointer font-medium text-gray-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors list-none flex items-center gap-2">
                        <svg class="w-4 h-4 transition-transform group-open:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        ⭐ Rúbrica de evaluación (<?php echo e($tarea->puntos_totales); ?> puntos totales)
                    </summary>
                    <div class="mt-4">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-gray-300 dark:border-slate-700">
                                    <th class="text-left py-2 px-2 font-semibold text-gray-700 dark:text-slate-300">Criterio</th>
                                    <th class="text-right py-2 px-2 font-semibold text-gray-700 dark:text-slate-300">Puntos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $tarea->rubrica['criterios']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $criterio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-gray-200 dark:border-slate-700 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                                    <td class="py-3 px-2 text-gray-700 dark:text-slate-300"><?php echo e($criterio['nombre']); ?></td>
                                    <td class="text-right py-3 px-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-800 dark:text-primary-300">
                                            <?php echo e($criterio['puntos']); ?> pts
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-gray-300 dark:border-slate-700 font-bold">
                                    <td class="py-3 px-2 text-gray-900 dark:text-slate-100">Total</td>
                                    <td class="text-right py-3 px-2 text-primary-600 dark:text-primary-400"><?php echo e($tarea->puntos_totales); ?> pts</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </details>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/materias/show.blade.php ENDPATH**/ ?>