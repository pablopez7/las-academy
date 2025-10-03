<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tareas_estudiante', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->foreignId('materia_id')->nullable()->constrained('materias')->onDelete('set null');
            $table->foreignId('encuentro_id')->nullable()->constrained('encuentros')->onDelete('set null');
            $table->enum('tipo', ['tarea', 'trabajo', 'lectura', 'evaluacion', 'otro'])->default('tarea');
            $table->date('fecha_asignacion')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->enum('prioridad', ['baja', 'media', 'alta'])->default('media');
            $table->enum('estado', ['pendiente', 'en_progreso', 'completada', 'cancelada'])->default('pendiente');
            $table->foreignId('recurso_origen_id')->nullable()->constrained('recursos')->onDelete('set null');
            $table->text('contexto_original')->nullable();
            $table->text('notas_adicionales')->nullable();
            $table->foreignId('rubrica_id')->nullable()->constrained('rubricas')->onDelete('set null');
            $table->boolean('validada')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas_estudiante');
    }
};
