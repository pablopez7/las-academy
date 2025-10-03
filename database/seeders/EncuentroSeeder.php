<?php

namespace Database\Seeders;

use App\Models\Encuentro;
use App\Models\Materia;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EncuentroSeeder extends Seeder
{
    public function run(): void
    {
        // Encuentro 1
        $encuentro1 = Encuentro::create([
            'nombre' => 'Primer Encuentro',
            'numero' => 1,
            'descripcion' => 'Introducción al seminario y fundamentos bíblicos',
            'fecha_inicio' => Carbon::parse('2024-01-15'),
            'fecha_fin' => Carbon::parse('2024-01-21'),
            'activo' => true,
            'orden' => 1,
        ]);

        $encuentro1->materias()->attach([
            Materia::where('slug', 'antiguo-testamento')->first()->id => ['orden' => 1],
            Materia::where('slug', 'nuevo-testamento')->first()->id => ['orden' => 2],
            Materia::where('slug', 'hermeneutica')->first()->id => ['orden' => 3],
            Materia::where('slug', 'historia-cristianismo')->first()->id => ['orden' => 4],
            Materia::where('slug', 'eclesiologia')->first()->id => ['orden' => 5],
            Materia::where('slug', 'evangelismo')->first()->id => ['orden' => 6],
        ]);

        // Encuentro 2
        $encuentro2 = Encuentro::create([
            'nombre' => 'Segundo Encuentro',
            'numero' => 2,
            'descripcion' => 'Profundización en estudios bíblicos y teología',
            'fecha_inicio' => Carbon::parse('2024-02-12'),
            'fecha_fin' => Carbon::parse('2024-02-18'),
            'activo' => true,
            'orden' => 2,
        ]);

        $encuentro2->materias()->attach([
            Materia::where('slug', 'antiguo-testamento')->first()->id => ['orden' => 1],
            Materia::where('slug', 'nuevo-testamento')->first()->id => ['orden' => 2],
            Materia::where('slug', 'hermeneutica')->first()->id => ['orden' => 3],
            Materia::where('slug', 'historia-cristianismo')->first()->id => ['orden' => 4],
            Materia::where('slug', 'eclesiologia')->first()->id => ['orden' => 5],
            Materia::where('slug', 'evangelismo')->first()->id => ['orden' => 6],
            Materia::where('slug', 'teologia-sistematica')->first()->id => ['orden' => 7],
        ]);

        // Encuentros 3-6 (pendientes)
        for ($i = 3; $i <= 6; $i++) {
            $fecha = Carbon::parse('2024-01-15')->addMonths($i - 1);
            Encuentro::create([
                'nombre' => "Encuentro $i",
                'numero' => $i,
                'descripcion' => "Contenido del encuentro $i (próximamente)",
                'fecha_inicio' => $fecha,
                'fecha_fin' => $fecha->copy()->addDays(6),
                'activo' => false,
                'orden' => $i,
            ]);
        }
    }
}
