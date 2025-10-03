<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cambiar de ENUM a VARCHAR para permitir más tipos
        DB::statement("ALTER TABLE recursos MODIFY COLUMN tipo VARCHAR(50) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Volver a ENUM original
        DB::statement("ALTER TABLE recursos MODIFY COLUMN tipo ENUM('transcripcion', 'video', 'documento', 'enlace') NOT NULL");
    }
};
