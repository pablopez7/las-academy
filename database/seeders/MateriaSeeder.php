<?php

namespace Database\Seeders;

use App\Models\Materia;
use Illuminate\Database\Seeder;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        $materias = [
            ['nombre' => 'Antiguo Testamento', 'slug' => 'antiguo-testamento', 'color' => '#8B5CF6', 'orden' => 1],
            ['nombre' => 'Nuevo Testamento', 'slug' => 'nuevo-testamento', 'color' => '#3B82F6', 'orden' => 2],
            ['nombre' => 'Hermenéutica', 'slug' => 'hermeneutica', 'color' => '#10B981', 'orden' => 3],
            ['nombre' => 'Historia del Cristianismo', 'slug' => 'historia-cristianismo', 'color' => '#F59E0B', 'orden' => 4],
            ['nombre' => 'Eclesiología', 'slug' => 'eclesiologia', 'color' => '#EF4444', 'orden' => 5],
            ['nombre' => 'Evangelismo', 'slug' => 'evangelismo', 'color' => '#06B6D4', 'orden' => 6],
            ['nombre' => 'Teología Sistemática', 'slug' => 'teologia-sistematica', 'color' => '#EC4899', 'orden' => 7],
        ];

        foreach ($materias as $materia) {
            Materia::create($materia);
        }
    }
}
