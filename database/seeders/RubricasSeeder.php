<?php

namespace Database\Seeders;

use App\Models\Materia;
use App\Models\Rubrica;
use Illuminate\Database\Seeder;

class RubricasSeeder extends Seeder
{
    public function run(): void
    {
        $materias = [
            'antiguo-testamento' => [
                'titulo' => 'Rúbrica de Evaluación - Antiguo Testamento',
                'descripcion' => 'Criterios para evaluar trabajos de Antiguo Testamento',
                'criterios' => [
                    [
                        'nombre' => 'Conocimiento Bíblico',
                        'descripcion' => 'Demuestra comprensión profunda del texto bíblico y su contexto histórico',
                        'puntos_max' => 30,
                    ],
                    [
                        'nombre' => 'Análisis Exegético',
                        'descripcion' => 'Aplica métodos exegéticos correctamente para interpretar el texto',
                        'puntos_max' => 25,
                    ],
                    [
                        'nombre' => 'Aplicación Práctica',
                        'descripcion' => 'Conecta el contenido bíblico con situaciones contemporáneas',
                        'puntos_max' => 20,
                    ],
                    [
                        'nombre' => 'Calidad de Redacción',
                        'descripcion' => 'Presenta ideas de forma clara, coherente y sin errores ortográficos',
                        'puntos_max' => 15,
                    ],
                    [
                        'nombre' => 'Referencias y Citas',
                        'descripcion' => 'Utiliza fuentes adecuadas y cita correctamente',
                        'puntos_max' => 10,
                    ],
                ],
            ],
            'nuevo-testamento' => [
                'titulo' => 'Rúbrica de Evaluación - Nuevo Testamento',
                'descripcion' => 'Criterios para evaluar trabajos de Nuevo Testamento',
                'criterios' => [
                    [
                        'nombre' => 'Comprensión Teológica',
                        'descripcion' => 'Entiende y explica los conceptos teológicos del Nuevo Testamento',
                        'puntos_max' => 30,
                    ],
                    [
                        'nombre' => 'Contexto Cultural',
                        'descripcion' => 'Considera el contexto greco-romano y judío del siglo I',
                        'puntos_max' => 20,
                    ],
                    [
                        'nombre' => 'Análisis Literario',
                        'descripcion' => 'Identifica géneros literarios y técnicas narrativas',
                        'puntos_max' => 20,
                    ],
                    [
                        'nombre' => 'Aplicación Ministerial',
                        'descripcion' => 'Aplica enseñanzas del NT a situaciones ministeriales actuales',
                        'puntos_max' => 20,
                    ],
                    [
                        'nombre' => 'Presentación',
                        'descripcion' => 'Trabajo bien estructurado y presentado profesionalmente',
                        'puntos_max' => 10,
                    ],
                ],
            ],
            'hermeneutica' => [
                'titulo' => 'Rúbrica de Evaluación - Hermenéutica',
                'descripcion' => 'Criterios para evaluar trabajos de Hermenéutica Bíblica',
                'criterios' => [
                    [
                        'nombre' => 'Aplicación de Principios Hermenéuticos',
                        'descripcion' => 'Utiliza correctamente los principios de interpretación bíblica',
                        'puntos_max' => 35,
                    ],
                    [
                        'nombre' => 'Análisis Contextual',
                        'descripcion' => 'Considera contexto histórico, cultural, literario y gramatical',
                        'puntos_max' => 25,
                    ],
                    [
                        'nombre' => 'Metodología',
                        'descripcion' => 'Sigue una metodología clara y consistente de análisis',
                        'puntos_max' => 20,
                    ],
                    [
                        'nombre' => 'Precisión Interpretativa',
                        'descripcion' => 'Evita eiségesis y demuestra interpretación fiel al texto',
                        'puntos_max' => 15,
                    ],
                    [
                        'nombre' => 'Organización',
                        'descripcion' => 'Trabajo bien organizado con estructura lógica',
                        'puntos_max' => 5,
                    ],
                ],
            ],
            'historia-cristianismo' => [
                'titulo' => 'Rúbrica de Evaluación - Historia del Cristianismo',
                'descripcion' => 'Criterios para evaluar trabajos de Historia del Cristianismo',
                'criterios' => [
                    [
                        'nombre' => 'Conocimiento Histórico',
                        'descripcion' => 'Demuestra conocimiento preciso de eventos y personajes históricos',
                        'puntos_max' => 30,
                    ],
                    [
                        'nombre' => 'Análisis Crítico',
                        'descripcion' => 'Analiza críticamente fuentes históricas y perspectivas',
                        'puntos_max' => 25,
                    ],
                    [
                        'nombre' => 'Conexiones Teológicas',
                        'descripcion' => 'Conecta eventos históricos con desarrollo teológico',
                        'puntos_max' => 20,
                    ],
                    [
                        'nombre' => 'Relevancia Contemporánea',
                        'descripcion' => 'Identifica lecciones aplicables a la iglesia actual',
                        'puntos_max' => 15,
                    ],
                    [
                        'nombre' => 'Uso de Fuentes',
                        'descripcion' => 'Consulta y cita fuentes históricas primarias y secundarias',
                        'puntos_max' => 10,
                    ],
                ],
            ],
            'eclesiologia' => [
                'titulo' => 'Rúbrica de Evaluación - Eclesiología',
                'descripcion' => 'Criterios para evaluar trabajos de Eclesiología',
                'criterios' => [
                    [
                        'nombre' => 'Fundamento Bíblico',
                        'descripcion' => 'Basa la reflexión eclesiológica en la Escritura',
                        'puntos_max' => 30,
                    ],
                    [
                        'nombre' => 'Comprensión de Modelos Eclesiásticos',
                        'descripcion' => 'Entiende diferentes modelos y estructuras de iglesia',
                        'puntos_max' => 25,
                    ],
                    [
                        'nombre' => 'Aplicación Práctica',
                        'descripcion' => 'Propone aplicaciones concretas para la vida de la iglesia',
                        'puntos_max' => 20,
                    ],
                    [
                        'nombre' => 'Perspectiva Equilibrada',
                        'descripcion' => 'Considera múltiples perspectivas denominacionales',
                        'puntos_max' => 15,
                    ],
                    [
                        'nombre' => 'Calidad del Trabajo',
                        'descripcion' => 'Presentación profesional y sin errores',
                        'puntos_max' => 10,
                    ],
                ],
            ],
            'evangelismo' => [
                'titulo' => 'Rúbrica de Evaluación - Evangelismo',
                'descripcion' => 'Criterios para evaluar trabajos de Evangelismo',
                'criterios' => [
                    [
                        'nombre' => 'Fundamento Teológico',
                        'descripcion' => 'Presenta una teología clara del evangelismo',
                        'puntos_max' => 25,
                    ],
                    [
                        'nombre' => 'Estrategias Prácticas',
                        'descripcion' => 'Propone métodos concretos y viables de evangelización',
                        'puntos_max' => 25,
                    ],
                    [
                        'nombre' => 'Contextualización',
                        'descripcion' => 'Adapta el mensaje al contexto cultural contemporáneo',
                        'puntos_max' => 20,
                    ],
                    [
                        'nombre' => 'Claridad del Evangelio',
                        'descripcion' => 'Comunica el evangelio de forma clara y completa',
                        'puntos_max' => 20,
                    ],
                    [
                        'nombre' => 'Creatividad',
                        'descripcion' => 'Demuestra creatividad y originalidad en propuestas',
                        'puntos_max' => 10,
                    ],
                ],
            ],
            'teologia-sistematica' => [
                'titulo' => 'Rúbrica de Evaluación - Teología Sistemática',
                'descripcion' => 'Criterios para evaluar trabajos de Teología Sistemática',
                'criterios' => [
                    [
                        'nombre' => 'Rigor Teológico',
                        'descripcion' => 'Demuestra pensamiento teológico riguroso y sistemático',
                        'puntos_max' => 35,
                    ],
                    [
                        'nombre' => 'Soporte Bíblico',
                        'descripcion' => 'Fundamenta argumentos teológicos en la Escritura',
                        'puntos_max' => 25,
                    ],
                    [
                        'nombre' => 'Coherencia Doctrinal',
                        'descripcion' => 'Mantiene coherencia con la doctrina cristiana ortodoxa',
                        'puntos_max' => 20,
                    ],
                    [
                        'nombre' => 'Diálogo con Tradición',
                        'descripcion' => 'Dialoga con teólogos y tradiciones históricas',
                        'puntos_max' => 15,
                    ],
                    [
                        'nombre' => 'Claridad Expositiva',
                        'descripcion' => 'Expone conceptos complejos de forma clara',
                        'puntos_max' => 5,
                    ],
                ],
            ],
        ];

        foreach ($materias as $slug => $data) {
            $materia = Materia::where('slug', $slug)->first();

            if ($materia) {
                Rubrica::create([
                    'materia_id' => $materia->id,
                    'encuentro_id' => null,
                    'titulo' => $data['titulo'],
                    'descripcion' => $data['descripcion'],
                    'criterios' => $data['criterios'],
                    'puntos_totales' => collect($data['criterios'])->sum('puntos_max'),
                    'activa' => true,
                ]);

                $this->command->info("✓ Rúbrica creada para {$materia->nombre}");
            }
        }

        $this->command->info("\n✅ Se crearon " . count($materias) . " rúbricas básicas");
    }
}
