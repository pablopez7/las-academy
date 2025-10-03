

<?php $__env->startSection('title', 'Inicio - LAS Academy'); ?>

<?php $__env->startSection('content'); ?>
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

    <!-- Próximas Tareas -->
    <?php if($proximasTareas->count() > 0): ?>
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-slate-100 mb-6">Próximas Tareas</h2>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $proximasTareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100"><?php echo e($tarea->titulo); ?></h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-800 dark:text-primary-300">
                        <?php echo e($tarea->materia->nombre); ?>

                    </span>
                </div>
                <p class="text-sm text-gray-600 dark:text-slate-300 mb-3"><?php echo e(Str::limit($tarea->descripcion, 100)); ?></p>
                <div class="flex items-center justify-between text-sm">
                    <?php if($tarea->encuentro): ?>
                    <span class="text-gray-500 dark:text-slate-400">Encuentro <?php echo e($tarea->encuentro->numero); ?></span>
                    <?php else: ?>
                    <span class="text-gray-500 dark:text-slate-400">Tarea general</span>
                    <?php endif; ?>
                    <span class="text-primary-600 dark:text-primary-400 font-medium"><?php echo e($tarea->fecha_entrega->format('d/m/Y')); ?></span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Encuentros -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-slate-100 mb-6">Encuentros del Seminario</h2>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $encuentros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $encuentro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('encuentros.show', $encuentro)); ?>" class="card hover:shadow-lg transition-shadow group">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                        <?php echo e($encuentro->nombre); ?>

                    </h3>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 font-bold">
                        <?php echo e($encuentro->numero); ?>

                    </span>
                </div>

                <?php if($encuentro->descripcion): ?>
                <p class="text-gray-600 dark:text-slate-300 mb-4"><?php echo e(Str::limit($encuentro->descripcion, 120)); ?></p>
                <?php endif; ?>

                <?php if($encuentro->fecha_inicio && $encuentro->fecha_fin): ?>
                <p class="text-sm text-gray-500 dark:text-slate-400 mb-4">
                    <?php echo e($encuentro->fecha_inicio->format('d/m/Y')); ?> - <?php echo e($encuentro->fecha_fin->format('d/m/Y')); ?>

                </p>
                <?php endif; ?>

                <!-- Materias -->
                <div class="flex flex-wrap gap-2">
                    <?php $__currentLoopData = $encuentro->materias->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: <?php echo e($materia->color); ?>20; color: <?php echo e($materia->color); ?>;">
                        <?php echo e($materia->nombre); ?>

                    </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($encuentro->materias->count() > 4): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-slate-300">
                        +<?php echo e($encuentro->materias->count() - 4); ?>

                    </span>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/home.blade.php ENDPATH**/ ?>