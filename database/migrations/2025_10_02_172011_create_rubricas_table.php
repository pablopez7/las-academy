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
        Schema::create('rubricas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->nullable()->constrained('materias')->onDelete('cascade');
            $table->foreignId('encuentro_id')->nullable()->constrained('encuentros')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->json('criterios'); // [{nombre, descripcion, puntos_max}]
            $table->integer('puntos_totales')->default(100);
            $table->boolean('activa')->default(true);
            $table->timestamps();

            // Índices
            $table->index('materia_id');
            $table->index('encuentro_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rubricas');
    }
};
