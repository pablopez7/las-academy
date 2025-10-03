

<?php $__env->startSection('title', $recurso->titulo . ' - LAS Academy'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center gap-2 text-gray-500 dark:text-slate-400">
            <li><a href="<?php echo e(route('home')); ?>" class="hover:text-primary-600 dark:hover:text-primary-400">Inicio</a></li>
            <li>/</li>
            <?php if($recurso->materia): ?>
            <li><a href="<?php echo e(route('materias.show', $recurso->materia)); ?>" class="hover:text-primary-600 dark:hover:text-primary-400"><?php echo e($recurso->materia->nombre); ?></a></li>
            <li>/</li>
            <?php endif; ?>
            <li class="text-gray-900 dark:text-slate-100 font-medium"><?php echo e($recurso->titulo); ?></li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="card mb-8">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-3"><?php echo e($recurso->titulo); ?></h1>

                <div class="flex flex-wrap items-center gap-3">
                    <?php if($recurso->materia): ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" style="background-color: <?php echo e($recurso->materia->color); ?>20; color: <?php echo e($recurso->materia->color); ?>;">
                        <?php echo e($recurso->materia->nombre); ?>

                    </span>
                    <?php endif; ?>
                    <?php if($recurso->encuentro): ?>
                    <span class="text-gray-500 dark:text-slate-400 text-sm">Encuentro <?php echo e($recurso->encuentro->numero); ?></span>
                    <?php else: ?>
                    <span class="text-gray-500 dark:text-slate-400 text-sm">Material complementario</span>
                    <?php endif; ?>
                    <?php if($recurso->duracion_minutos): ?>
                    <span class="text-gray-500 dark:text-slate-400 text-sm">⏱️ <?php echo e($recurso->duracion_minutos); ?> minutos</span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($recurso->archivo_ruta): ?>
            <a href="<?php echo e(route('recursos.download', $recurso)); ?>" class="btn btn-primary">
                ⬇️ Descargar
            </a>
            <?php endif; ?>
        </div>

        <?php if($recurso->descripcion): ?>
        <p class="text-lg text-gray-600 dark:text-slate-300 mb-4"><?php echo e($recurso->descripcion); ?></p>
        <?php endif; ?>
    </div>

    <!-- Contenido -->
    <?php if($recurso->contenido): ?>
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-4">Contenido</h2>
        <div class="prose max-w-none">
            <?php echo nl2br(e($recurso->contenido)); ?>

        </div>
    </div>
    <?php endif; ?>

    <!-- Video o URL Externa -->
    <?php if($recurso->url_externa): ?>
    <div class="card mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-4">Enlace Externo</h2>
        <a href="<?php echo e($recurso->url_externa); ?>" target="_blank" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium">
            <?php echo e($recurso->url_externa); ?> ↗
        </a>
    </div>
    <?php endif; ?>

    <!-- Recursos Relacionados -->
    <?php if($recursosRelacionados->count() > 0): ?>
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-4">Recursos Relacionados</h2>
        <div class="grid gap-4 md:grid-cols-2">
            <?php $__currentLoopData = $recursosRelacionados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relacionado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('recursos.show', $relacionado)); ?>" class="card hover:shadow-lg transition-shadow group">
                <h3 class="font-semibold text-gray-900 dark:text-slate-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors mb-2">
                    <?php echo e($relacionado->titulo); ?>

                </h3>
                <?php if($relacionado->descripcion): ?>
                <p class="text-sm text-gray-600 dark:text-slate-300"><?php echo e(Str::limit($relacionado->descripcion, 80)); ?></p>
                <?php endif; ?>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/recursos/show.blade.php ENDPATH**/ ?>