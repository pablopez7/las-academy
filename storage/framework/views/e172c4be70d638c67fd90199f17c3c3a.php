<?php $__env->startSection('title', $rubrica->titulo); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    
    <div class="bg-slate-800 rounded-lg p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2"><?php echo e($rubrica->titulo); ?></h1>
                <?php if($rubrica->materia): ?>
                    <p class="text-indigo-400 text-lg"><?php echo e($rubrica->materia->nombre); ?></p>
                <?php endif; ?>
                <?php if($rubrica->encuentro): ?>
                    <p class="text-slate-400 text-sm mt-1"><?php echo e($rubrica->encuentro->nombre); ?></p>
                <?php endif; ?>
            </div>
            <div class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-center">
                <div class="text-2xl font-bold"><?php echo e($rubrica->puntos_totales); ?></div>
                <div class="text-xs">puntos</div>
            </div>
        </div>

        <?php if($rubrica->descripcion): ?>
            <p class="text-slate-300 mt-4"><?php echo e($rubrica->descripcion); ?></p>
        <?php endif; ?>
    </div>

    
    <div class="bg-slate-800 rounded-lg overflow-hidden">
        <div class="bg-indigo-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white">Criterios de Evaluación</h2>
        </div>

        <div class="divide-y divide-slate-700">
            <?php $__currentLoopData = $rubrica->criterios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $criterio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="p-6 hover:bg-slate-750 transition-colors">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm">
                                    <?php echo e($index + 1); ?>

                                </span>
                                <h3 class="text-lg font-semibold text-white"><?php echo e($criterio['nombre']); ?></h3>
                            </div>
                            <p class="text-slate-300 ml-11"><?php echo e($criterio['descripcion']); ?></p>
                        </div>
                        <div class="ml-4 bg-slate-700 px-4 py-2 rounded-lg text-center flex-shrink-0">
                            <div class="text-xl font-bold text-indigo-400"><?php echo e($criterio['puntos_max']); ?></div>
                            <div class="text-xs text-slate-400">pts</div>
                        </div>
                    </div>

                    
                    <div class="ml-11 mt-3">
                        <div class="w-full bg-slate-700 rounded-full h-2">
                            <div class="bg-indigo-500 h-2 rounded-full" style="width: <?php echo e(($criterio['puntos_max'] / $rubrica->puntos_totales) * 100); ?>%"></div>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            <?php echo e(round(($criterio['puntos_max'] / $rubrica->puntos_totales) * 100, 1)); ?>% del total
                        </p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="mt-6 flex gap-4">
        <a href="<?php echo e(route('rubricas.index')); ?>"
           class="bg-slate-700 hover:bg-slate-600 text-white px-6 py-3 rounded-lg transition-colors">
            ← Volver a rúbricas
        </a>

        <?php if($rubrica->materia): ?>
            <a href="<?php echo e(route('materias.show', $rubrica->materia)); ?>"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition-colors">
                Ver materia →
            </a>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/rubricas/show.blade.php ENDPATH**/ ?>