

<?php $__env->startSection('title', $encuentro->nombre . ' - LAS Academy'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center gap-2 text-gray-500 dark:text-slate-400">
            <li><a href="<?php echo e(route('home')); ?>" class="hover:text-primary-600 dark:hover:text-primary-400">Inicio</a></li>
            <li>/</li>
            <li><a href="<?php echo e(route('encuentros.index')); ?>" class="hover:text-primary-600 dark:hover:text-primary-400">Encuentros</a></li>
            <li>/</li>
            <li class="text-gray-900 dark:text-slate-100 font-medium"><?php echo e($encuentro->nombre); ?></li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="card mb-8">
        <div class="flex items-start justify-between">
            <div>
                <div class="flex items-center gap-4 mb-3">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100"><?php echo e($encuentro->nombre); ?></h1>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 font-bold">
                        <?php echo e($encuentro->numero); ?>

                    </span>
                </div>

                <?php if($encuentro->descripcion): ?>
                <p class="text-lg text-gray-600 dark:text-slate-300 mb-4"><?php echo e($encuentro->descripcion); ?></p>
                <?php endif; ?>

                <?php if($encuentro->fecha_inicio && $encuentro->fecha_fin): ?>
                <p class="text-gray-500 dark:text-slate-400">
                    📅 <?php echo e($encuentro->fecha_inicio->format('d/m/Y')); ?> - <?php echo e($encuentro->fecha_fin->format('d/m/Y')); ?>

                </p>
                <?php endif; ?>
            </div>

            <?php if($encuentro->imagen_calendario): ?>
            <div class="ml-6">
                <img src="<?php echo e(asset('storage/' . $encuentro->imagen_calendario)); ?>" alt="Calendario <?php echo e($encuentro->nombre); ?>" class="rounded-lg shadow-md max-w-xs">
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Materias -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-slate-100 mb-6">Materias del Encuentro</h2>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $encuentro->materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('materias.show', $materia)); ?>" class="card hover:shadow-lg transition-all group">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center text-white font-bold" style="background-color: <?php echo e($materia->color); ?>;">
                        <?php echo e(substr($materia->nombre, 0, 1)); ?>

                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 dark:text-slate-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors mb-1">
                            <?php echo e($materia->nombre); ?>

                        </h3>
                        <?php if($materia->descripcion): ?>
                        <p class="text-sm text-gray-600 dark:text-slate-300"><?php echo e(Str::limit($materia->descripcion, 80)); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-slate-400">
                    <span>📚 <?php echo e($materia->recursos_count); ?> recursos</span>
                    <span>📝 <?php echo e($materia->tareas_count); ?> tareas</span>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/encuentros/show.blade.php ENDPATH**/ ?>