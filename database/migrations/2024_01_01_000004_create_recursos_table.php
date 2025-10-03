<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('encuentro_id')->constrained()->onDelete('cascade');
            $table->foreignId('materia_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', [
                'transcripcion',
                'rubrica',
                'resumen',
                'material_apoyo',
                'video',
                'documento',
                'enlace'
            ]);
            $table->string('titulo');
            $table->string('slug');
            $table->text('descripcion')->nullable();
            $table->text('contenido')->nullable(); // Para transcripciones y resúmenes
            $table->string('archivo_ruta')->nullable(); // Para PDFs, videos, etc
            $table->string('url_externa')->nullable(); // Para enlaces externos
            $table->integer('duracion_minutos')->nullable(); // Para videos
            $table->json('metadata')->nullable(); // Datos adicionales flexibles
            $table->boolean('visible')->default(true);
            $table->integer('orden')->default(0);
            $table->timestamps();

            $table->index(['encuentro_id', 'materia_id', 'tipo']);
            $table->fullText(['titulo', 'descripcion', 'contenido']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recursos');
    }
};
