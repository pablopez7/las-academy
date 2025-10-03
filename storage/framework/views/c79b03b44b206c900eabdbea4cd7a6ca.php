<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'LAS Academy - Seminario Letra al que Sirve'); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="min-h-screen bg-gray-50 dark:bg-slate-950 text-gray-900 dark:text-slate-100">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-slate-900 shadow-lg border-b border-gray-200 dark:border-slate-800" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center group">
                        <span class="text-2xl font-bold text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors">LAS</span>
                        <span class="ml-2 text-gray-700 dark:text-slate-300 group-hover:text-gray-900 dark:group-hover:text-slate-100 transition-colors">Academy</span>
                    </a>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="<?php echo e(route('home')); ?>"
                           class="inline-flex items-center px-1 pt-1 border-b-2 <?php echo e(request()->routeIs('home') ? 'border-primary-500 text-gray-900 dark:text-slate-100' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200'); ?> text-sm font-medium transition-colors">
                            Inicio
                        </a>
                        <a href="<?php echo e(route('encuentros.index')); ?>"
                           class="inline-flex items-center px-1 pt-1 border-b-2 <?php echo e(request()->routeIs('encuentros.*') ? 'border-primary-500 text-gray-900 dark:text-slate-100' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200'); ?> text-sm font-medium transition-colors">
                            Encuentros
                        </a>
                        <a href="<?php echo e(route('materias.index')); ?>"
                           class="inline-flex items-center px-1 pt-1 border-b-2 <?php echo e(request()->routeIs('materias.*') ? 'border-primary-500 text-gray-900 dark:text-slate-100' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200'); ?> text-sm font-medium transition-colors">
                            Materias
                        </a>
                        <a href="<?php echo e(route('rubricas.index')); ?>"
                           class="inline-flex items-center px-1 pt-1 border-b-2 <?php echo e(request()->routeIs('rubricas.*') ? 'border-primary-500 text-gray-900 dark:text-slate-100' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200'); ?> text-sm font-medium transition-colors">
                            Rúbricas
                        </a>
                        <a href="<?php echo e(route('tareas.index')); ?>"
                           class="inline-flex items-center px-1 pt-1 border-b-2 <?php echo e(request()->routeIs('tareas.*') ? 'border-primary-500 text-gray-900 dark:text-slate-100' : 'border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200'); ?> text-sm font-medium transition-colors">
                            📝 Tareas
                        </a>
                    </div>
                </div>

                <!-- Search & Mobile Menu Button -->
                <div class="flex items-center gap-4">
                    <!-- Search (Desktop) -->
                    <form action="<?php echo e(route('search')); ?>" method="GET" class="relative hidden sm:block">
                        <input type="text" name="q" placeholder="Buscar..." value="<?php echo e(request('q')); ?>"
                               class="w-48 lg:w-64 px-4 py-2 pr-10 text-sm bg-gray-100 dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-colors">
                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>

                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="md:hidden p-2 rounded-lg text-gray-500 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="md:hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <a href="<?php echo e(route('home')); ?>"
                       class="px-4 py-3 rounded-lg <?php echo e(request()->routeIs('home') ? 'bg-primary-100 dark:bg-primary-900/30 text-primary-900 dark:text-primary-300' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800'); ?> text-sm font-medium transition-colors">
                        Inicio
                    </a>
                    <a href="<?php echo e(route('encuentros.index')); ?>"
                       class="px-4 py-3 rounded-lg <?php echo e(request()->routeIs('encuentros.*') ? 'bg-primary-100 dark:bg-primary-900/30 text-primary-900 dark:text-primary-300' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800'); ?> text-sm font-medium transition-colors">
                        Encuentros
                    </a>
                    <a href="<?php echo e(route('materias.index')); ?>"
                       class="px-4 py-3 rounded-lg <?php echo e(request()->routeIs('materias.*') ? 'bg-primary-100 dark:bg-primary-900/30 text-primary-900 dark:text-primary-300' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800'); ?> text-sm font-medium transition-colors">
                        Materias
                    </a>
                    <a href="<?php echo e(route('rubricas.index')); ?>"
                       class="px-4 py-3 rounded-lg <?php echo e(request()->routeIs('rubricas.*') ? 'bg-primary-100 dark:bg-primary-900/30 text-primary-900 dark:text-primary-300' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800'); ?> text-sm font-medium transition-colors">
                        Rúbricas
                    </a>
                    <a href="<?php echo e(route('tareas.index')); ?>"
                       class="px-4 py-3 rounded-lg <?php echo e(request()->routeIs('tareas.*') ? 'bg-primary-100 dark:bg-primary-900/30 text-primary-900 dark:text-primary-300' : 'text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800'); ?> text-sm font-medium transition-colors">
                        📝 Tareas
                    </a>

                    <!-- Mobile Search -->
                    <form action="<?php echo e(route('search')); ?>" method="GET" class="px-4 pt-2">
                        <div class="relative">
                            <input type="text" name="q" placeholder="Buscar..." value="<?php echo e(request('q')); ?>"
                                   class="w-full px-4 py-2 pr-10 text-sm bg-gray-100 dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="py-8 min-h-[calc(100vh-8rem)]">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-900 border-t border-gray-200 dark:border-slate-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-500 dark:text-slate-400 text-sm">
                &copy; <?php echo e(date('Y')); ?> Seminario Letra al que Sirve. Todos los derechos reservados.
            </p>
        </div>
    </footer>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH /var/www/resources/views/layouts/app.blade.php ENDPATH**/ ?>