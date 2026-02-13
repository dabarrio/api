<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        $articles = [
            [
                'title' => 'Introducción a Laravel 11',
                'content' => 'Laravel 11 trae nuevas características increíbles que facilitan el desarrollo web. En este artículo exploraremos las mejores prácticas y patrones de diseño más utilizados en el ecosistema Laravel.',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'category_ids' => [3], // Programación
            ],
            [
                'title' => 'Diseño de APIs RESTful',
                'content' => 'Aprende a diseñar APIs RESTful siguiendo las mejores prácticas de la industria. Cubriremos convenciones HTTP, códigos de estado y estructura de respuestas.',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'category_ids' => [1, 3], // Tecnología, Programación
            ],
            [
                'title' => 'Patrones de Diseño en PHP',
                'content' => 'El Repository Pattern, DTO Pattern y Dependency Injection son fundamentales para crear aplicaciones escalables y mantenibles. Descubre cómo implementarlos correctamente.',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'category_ids' => [3], // Programación
            ],
            [
                'title' => 'Guía de UX/UI para Desarrolladores',
                'content' => 'Como desarrollador, entender los principios básicos de UX/UI puede marcar la diferencia en tus proyectos. Esta guía te ayudará a crear interfaces más intuitivas.',
                'status' => 'published',
                'published_at' => now()->subDay(),
                'category_ids' => [2], // Diseño
            ],
            [
                'title' => 'Marketing Digital para Startups',
                'content' => 'Las estrategias de marketing digital son esenciales para el crecimiento de cualquier startup. Aprende a crear campañas efectivas con presupuestos limitados.',
                'status' => 'published',
                'published_at' => now(),
                'category_ids' => [4, 5], // Marketing, Negocios
            ],
            [
                'title' => 'Productividad para Desarrolladores',
                'content' => 'Técnicas y herramientas para maximizar tu productividad como desarrollador. Desde gestión del tiempo hasta automatización de tareas repetitivas.',
                'status' => 'draft',
                'published_at' => null,
                'category_ids' => [6], // Lifestyle
            ],
            [
                'title' => 'El Futuro de la Inteligencia Artificial',
                'content' => 'La IA está transformando todas las industrias. Exploramos las tendencias actuales y el impacto que tendrá en los próximos años.',
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'category_ids' => [1], // Tecnología
            ],
            [
                'title' => 'Cómo Escalar tu Negocio Digital',
                'content' => 'Estrategias probadas para escalar tu negocio digital de manera sostenible. Desde infraestructura técnica hasta gestión de equipos.',
                'status' => 'draft',
                'published_at' => null,
                'category_ids' => [5], // Negocios
            ],
        ];

        foreach ($articles as $index => $articleData) {
            // Asignar autor de forma rotativa
            $author = $users[$index % $users->count()];
            
            $categoryIds = $articleData['category_ids'];
            unset($articleData['category_ids']);

            // Generar slug único
            $slug = Str::slug($articleData['title']);
            $originalSlug = $slug;
            $count = 1;
            
            while (Article::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $article = Article::create([
                'title' => $articleData['title'],
                'content' => $articleData['content'],
                'slug' => $slug,
                'status' => $articleData['status'],
                'published_at' => $articleData['published_at'],
                'author_id' => $author->id,
            ]);

            // Asociar categorías
            $article->categories()->sync($categoryIds);
        }
    }
}
