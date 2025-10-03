

<?php $__env->startSection('title', 'Materias - LAS Academy'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">Materias del Seminario</h1>
        <p class="mt-2 text-gray-600 dark:text-slate-300">Explora el contenido organizado por materia</p>
    </div>

    <?php if($materias->count() > 0): ?>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php $__currentLoopData = $materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('materias.show', $materia)); ?>" class="card hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-start gap-4 mb-4">
                <!-- Icono de color -->
                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white font-bold text-xl flex-shrink-0 shadow-lg"
                     style="background-color: <?php echo e($materia->color); ?>;">
                    <?php echo e(substr($materia->nombre, 0, 2)); ?>

                </div>

                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-slate-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors mb-1">
                        <?php echo e($materia->nombre); ?>

                    </h3>

                    <?php if($materia->descripcion): ?>
                    <p class="text-sm text-gray-600 dark:text-slate-400 line-clamp-2">
                        <?php echo e($materia->descripcion); ?>

                    </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stats -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span><?php echo e($materia->recursos_count); ?> recursos</span>
                </div>

                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span><?php echo e($materia->tareas_count); ?> tareas</span>
                </div>
            </div>

            <!-- Indicador de materias en encuentros -->
            <div class="mt-3 flex items-center gap-2 text-xs text-gray-500 dark:text-slate-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span><?php echo e($materia->encuentros_count); ?> encuentros</span>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <div class="card text-center py-12">
        <p class="text-gray-500 dark:text-slate-400">No hay materias disponibles.</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/materias/index.blade.php ENDPATH**/ ?>