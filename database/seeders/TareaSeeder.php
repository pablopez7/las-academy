<?php

namespace Database\Seeders;

use App\Models\Encuentro;
use App\Models\Materia;
use App\Models\Tarea;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TareaSeeder extends Seeder
{
    public function run(): void
    {
        $encuentro1 = Encuentro::where('numero', 1)->first();
        $encuentro2 = Encuentro::where('numero', 2)->first();

        $at = Materia::where('slug', 'antiguo-testamento')->first();
        $nt = Materia::where('slug', 'nuevo-testamento')->first();
        $herm = Materia::where('slug', 'hermeneutica')->first();

        // Tareas del Encuentro 1
        Tarea::create([
            'encuentro_id' => $encuentro1->id,
            'materia_id' => $at->id,
            'titulo' => 'Análisis del Pentateuco',
            'descripcion' => 'Realizar un análisis comparativo de los cinco libros del Pentateuco',
            'instrucciones' => 'Elaborar un cuadro comparativo que incluya: autor, fecha aproximada, tema principal y versículos clave de cada libro.',
            'fecha_entrega' => Carbon::parse('2024-01-28'),
            'puntos_totales' => 100,
            'rubrica' => [
                'criterios' => [
                    ['nombre' => 'Investigación', 'puntos' => 30],
                    ['nombre' => 'Análisis', 'puntos' => 40],
                    ['nombre' => 'Presentación', 'puntos' => 20],
                    ['nombre' => 'Referencias bíblicas', 'puntos' => 10],
                ]
            ],
            'visible' => true,
        ]);

        Tarea::create([
            'encuentro_id' => $encuentro1->id,
            'materia_id' => $nt->id,
            'titulo' => 'Estudio de los Evangelios Sinópticos',
            'descripcion' => 'Comparar las perspectivas de Mateo, Marcos y Lucas',
            'instrucciones' => 'Seleccionar una perícopa (pasaje) que aparezca en los tres evangelios y analizar las diferencias y similitudes.',
            'fecha_entrega' => Carbon::parse('2024-02-04'),
            'puntos_totales' => 100,
            'rubrica' => [
                'criterios' => [
                    ['nombre' => 'Selección del pasaje', 'puntos' => 20],
                    ['nombre' => 'Análisis exegético', 'puntos' => 50],
                    ['nombre' => 'Conclusiones', 'puntos' => 30],
                ]
            ],
            'visible' => true,
        ]);

        Tarea::create([
            'encuentro_id' => $encuentro1->id,
            'materia_id' => $herm->id,
            'titulo' => 'Práctica de Interpretación',
            'descripcion' => 'Aplicar los principios hermenéuticos a un texto bíblico',
            'instrucciones' => 'Elegir un pasaje del Antiguo o Nuevo Testamento y aplicar los 6 principios de interpretación estudiados en clase.',
            'fecha_entrega' => Carbon::parse('2024-02-11'),
            'puntos_totales' => 100,
            'rubrica' => [
                'criterios' => [
                    ['nombre' => 'Contexto histórico-cultural', 'puntos' => 20],
                    ['nombre' => 'Análisis gramatical', 'puntos' => 20],
                    ['nombre' => 'Contexto literario', 'puntos' => 20],
                    ['nombre' => 'Aplicación práctica', 'puntos' => 30],
                    ['nombre' => 'Bibliografía', 'puntos' => 10],
                ]
            ],
            'visible' => true,
        ]);

        // Tareas del Encuentro 2
        Tarea::create([
            'encuentro_id' => $encuentro2->id,
            'materia_id' => $nt->id,
            'titulo' => 'Exégesis de Romanos',
            'descripcion' => 'Realizar una exégesis detallada de un capítulo de Romanos',
            'instrucciones' => 'Elegir un capítulo de Romanos (1-8) y realizar un análisis exegético completo incluyendo: contexto, estructura, análisis versículo por versículo y aplicación contemporánea.',
            'fecha_entrega' => Carbon::parse('2024-02-25'),
            'puntos_totales' => 150,
            'rubrica' => [
                'criterios' => [
                    ['nombre' => 'Introducción y contexto', 'puntos' => 30],
                    ['nombre' => 'Estructura del capítulo', 'puntos' => 20],
                    ['nombre' => 'Exégesis versículo por versículo', 'puntos' => 60],
                    ['nombre' => 'Aplicación práctica', 'puntos' => 30],
                    ['nombre' => 'Referencias y bibliografía', 'puntos' => 10],
                ]
            ],
            'visible' => true,
        ]);
    }
}
