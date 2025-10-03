

<?php $__env->startSection('title', 'Encuentros - LAS Academy'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">Encuentros del Seminario</h1>
        <p class="mt-2 text-gray-600 dark:text-slate-300">Explora el contenido de cada encuentro del seminario</p>
    </div>

    <div class="space-y-6">
        <?php $__currentLoopData = $encuentros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $encuentro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-4 mb-2">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-slate-100"><?php echo e($encuentro->nombre); ?></h2>
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 font-bold text-sm">
                            <?php echo e($encuentro->numero); ?>

                        </span>
                    </div>

                    <?php if($encuentro->descripcion): ?>
                    <p class="text-gray-600 dark:text-slate-300 mb-3"><?php echo e($encuentro->descripcion); ?></p>
                    <?php endif; ?>

                    <?php if($encuentro->fecha_inicio && $encuentro->fecha_fin): ?>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-4">
                        📅 <?php echo e($encuentro->fecha_inicio->format('d/m/Y')); ?> - <?php echo e($encuentro->fecha_fin->format('d/m/Y')); ?>

                    </p>
                    <?php endif; ?>
                </div>

                <a href="<?php echo e(route('encuentros.show', $encuentro)); ?>" class="btn btn-primary">
                    Ver detalles
                </a>
            </div>

            <!-- Stats -->
            <div class="flex items-center gap-6 text-sm text-gray-600 dark:text-slate-300 mb-4">
                <span>📚 <?php echo e($encuentro->recursos_count); ?> recursos</span>
                <span>📝 <?php echo e($encuentro->tareas_count); ?> tareas</span>
                <span>🎓 <?php echo e($encuentro->materias->count()); ?> materias</span>
            </div>

            <!-- Materias Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                <?php $__currentLoopData = $encuentro->materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('materias.show', $materia)); ?>" class="flex items-center gap-2 p-3 rounded-lg border border-gray-200 dark:border-slate-700 hover:border-primary-300 dark:hover:border-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/30 transition-colors">
                    <div class="w-3 h-3 rounded-full" style="background-color: <?php echo e($materia->color); ?>;"></div>
                    <span class="text-sm font-medium text-gray-700 dark:text-slate-300"><?php echo e($materia->nombre); ?></span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/encuentros/index.blade.php ENDPATH**/ ?>