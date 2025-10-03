<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('encuentro_materia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('encuentro_id')->constrained()->onDelete('cascade');
            $table->foreignId('materia_id')->constrained()->onDelete('cascade');
            $table->integer('orden')->default(0);
            $table->timestamps();

            $table->unique(['encuentro_id', 'materia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('encuentro_materia');
    }
};
