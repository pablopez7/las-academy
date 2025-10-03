<?php

namespace Database\Seeders;

use App\Models\Encuentro;
use App\Models\Materia;
use App\Models\Recurso;
use Illuminate\Database\Seeder;

class RecursoSeeder extends Seeder
{
    public function run(): void
    {
        $encuentro1 = Encuentro::where('numero', 1)->first();
        $encuentro2 = Encuentro::where('numero', 2)->first();

        $at = Materia::where('slug', 'antiguo-testamento')->first();
        $nt = Materia::where('slug', 'nuevo-testamento')->first();
        $herm = Materia::where('slug', 'hermeneutica')->first();
        $hist = Materia::where('slug', 'historia-cristianismo')->first();

        // Recursos del Encuentro 1
        Recurso::create([
            'encuentro_id' => $encuentro1->id,
            'materia_id' => $at->id,
            'tipo' => 'transcripcion',
            'titulo' => 'Introducción al Antiguo Testamento',
            'slug' => 'intro-antiguo-testamento',
            'descripcion' => 'Clase introductoria sobre la estructura y contexto del Antiguo Testamento',
            'contenido' => "En esta clase exploramos los fundamentos del Antiguo Testamento, su estructura y división en la Ley, los Profetas y los Escritos. Analizamos el contexto histórico y cultural en el que fueron escritos estos libros sagrados.\n\nPuntos principales:\n- La Torá o Pentateuco\n- Los libros históricos\n- Literatura sapiencial\n- Profetas mayores y menores",
            'duracion_minutos' => 45,
            'visible' => true,
            'orden' => 1,
        ]);

        Recurso::create([
            'encuentro_id' => $encuentro1->id,
            'materia_id' => $at->id,
            'tipo' => 'resumen',
            'titulo' => 'Resumen: Pentateuco',
            'slug' => 'resumen-pentateuco',
            'descripcion' => 'Resumen ejecutivo de los cinco primeros libros de la Biblia',
            'contenido' => "El Pentateuco contiene:\n1. Génesis - Creación y patriarcas\n2. Éxodo - Liberación de Egipto\n3. Levítico - Leyes sacerdotales\n4. Números - Travesía en el desierto\n5. Deuteronomio - Segunda ley",
            'visible' => true,
            'orden' => 2,
        ]);

        Recurso::create([
            'encuentro_id' => $encuentro1->id,
            'materia_id' => $nt->id,
            'tipo' => 'transcripcion',
            'titulo' => 'Los Evangelios Sinópticos',
            'slug' => 'evangelios-sinopticos',
            'descripcion' => 'Análisis comparativo de Mateo, Marcos y Lucas',
            'contenido' => "Los evangelios sinópticos (Mateo, Marcos y Lucas) presentan una perspectiva similar de la vida y ministerio de Jesús. Aunque tienen mucho en común, cada uno tiene su énfasis único:\n\n- Mateo: Jesús como el Mesías prometido\n- Marcos: Jesús como el Siervo sufriente\n- Lucas: Jesús como el Salvador universal",
            'duracion_minutos' => 60,
            'visible' => true,
            'orden' => 1,
        ]);

        Recurso::create([
            'encuentro_id' => $encuentro1->id,
            'materia_id' => $herm->id,
            'tipo' => 'material_apoyo',
            'titulo' => 'Principios de Interpretación Bíblica',
            'slug' => 'principios-interpretacion',
            'descripcion' => 'Guía práctica para la correcta interpretación de las Escrituras',
            'contenido' => "Principios fundamentales:\n1. Contexto histórico-cultural\n2. Contexto literario\n3. Análisis gramatical\n4. Uso del idioma original\n5. Analogía de la fe\n6. Aplicación práctica",
            'visible' => true,
            'orden' => 1,
        ]);

        Recurso::create([
            'encuentro_id' => $encuentro1->id,
            'materia_id' => $hist->id,
            'tipo' => 'transcripcion',
            'titulo' => 'La Iglesia Primitiva',
            'slug' => 'iglesia-primitiva',
            'descripcion' => 'Historia de los primeros siglos del cristianismo',
            'contenido' => "La iglesia primitiva nació en Pentecostés y se expandió rápidamente por el Imperio Romano a pesar de la persecución. Características principales:\n\n- Comunión y unidad de los creyentes\n- Predicación centrada en Cristo\n- Milagros y señales\n- Organización eclesiástica incipiente\n- Persecución y martirio",
            'duracion_minutos' => 50,
            'visible' => true,
            'orden' => 1,
        ]);

        // Recursos del Encuentro 2
        Recurso::create([
            'encuentro_id' => $encuentro2->id,
            'materia_id' => $nt->id,
            'tipo' => 'transcripcion',
            'titulo' => 'Epístolas Paulinas - Romanos',
            'slug' => 'romanos-pablo',
            'descripcion' => 'Estudio de la carta a los Romanos',
            'contenido' => "La carta a los Romanos es la exposición más sistemática de la teología paulina. Temas principales:\n\n1. La justificación por la fe (caps. 1-4)\n2. Vida en el Espíritu (cap. 5-8)\n3. El plan de Dios para Israel (caps. 9-11)\n4. Aplicación práctica (caps. 12-16)",
            'duracion_minutos' => 75,
            'visible' => true,
            'orden' => 1,
        ]);

        Recurso::create([
            'encuentro_id' => $encuentro2->id,
            'materia_id' => $at->id,
            'tipo' => 'resumen',
            'titulo' => 'Los Profetas Mayores',
            'slug' => 'profetas-mayores',
            'descripcion' => 'Resumen de Isaías, Jeremías y Ezequiel',
            'contenido' => "Profetas Mayores:\n\nIsaías - El profeta mesiánico\nJeremías - El profeta llorón\nEzequiel - El profeta de la gloria\nDaniel - El profeta apocalíptico",
            'visible' => true,
            'orden' => 1,
        ]);
    }
}
