<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EncuentroController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\RubricaController;
use App\Http\Controllers\TareaEstudianteController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('encuentros')->name('encuentros.')->group(function () {
    Route::get('/', [EncuentroController::class, 'index'])->name('index');
    Route::get('/{encuentro}', [EncuentroController::class, 'show'])->name('show');
});

Route::prefix('materias')->name('materias.')->group(function () {
    Route::get('/', [MateriaController::class, 'index'])->name('index');
    Route::get('/{materia}', [MateriaController::class, 'show'])->name('show');
});

Route::prefix('recursos')->name('recursos.')->group(function () {
    Route::get('/{recurso}', [RecursoController::class, 'show'])->name('show');
    Route::get('/{recurso}/download', [RecursoController::class, 'download'])->name('download');
});

Route::prefix('rubricas')->name('rubricas.')->group(function () {
    Route::get('/', [RubricaController::class, 'index'])->name('index');
    Route::get('/{rubrica}', [RubricaController::class, 'show'])->name('show');
    Route::get('/materia/{materia}', [RubricaController::class, 'porMateria'])->name('por-materia');
});

Route::get('/buscar', [HomeController::class, 'search'])->name('search');

Route::prefix('tareas')->name('tareas.')->group(function () {
    Route::get('/', [TareaEstudianteController::class, 'index'])->name('index');
    Route::get('/pendientes', [TareaEstudianteController::class, 'pendientes'])->name('pendientes');
    Route::get('/validar', [TareaEstudianteController::class, 'validar'])->name('validar');
    Route::get('/create', [TareaEstudianteController::class, 'create'])->name('create');
    Route::post('/', [TareaEstudianteController::class, 'store'])->name('store');
    Route::get('/{tarea}', [TareaEstudianteController::class, 'show'])->name('show');
    Route::get('/{tarea}/edit', [TareaEstudianteController::class, 'edit'])->name('edit');
    Route::put('/{tarea}', [TareaEstudianteController::class, 'update'])->name('update');
    Route::delete('/{tarea}', [TareaEstudianteController::class, 'destroy'])->name('destroy');
    Route::post('/{tarea}/completar', [TareaEstudianteController::class, 'completar'])->name('completar');
    Route::post('/crear-desde-mencion', [TareaEstudianteController::class, 'crearDesdeMencion'])->name('crear-desde-mencion');
});
