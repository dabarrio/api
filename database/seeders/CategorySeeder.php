<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tecnología',
                'description' => 'Artículos sobre tecnología, gadgets, software y hardware',
                'is_active' => true,
            ],
            [
                'name' => 'Diseño',
                'description' => 'Todo sobre diseño gráfico, web y UX/UI',
                'is_active' => true,
            ],
            [
                'name' => 'Programación',
                'description' => 'Tutoriales y artículos sobre desarrollo de software',
                'is_active' => true,
            ],
            [
                'name' => 'Marketing',
                'description' => 'Estrategias de marketing digital y tradicional',
                'is_active' => true,
            ],
            [
                'name' => 'Negocios',
                'description' => 'Emprendimiento, startups y gestión empresarial',
                'is_active' => true,
            ],
            [
                'name' => 'Lifestyle',
                'description' => 'Estilo de vida, productividad y desarrollo personal',
                'is_active' => true,
            ],
            [
                'name' => 'Música',
                'description' => 'Noticias y reseñas musicales',
                'is_active' => false, // Categoría inactiva de ejemplo
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
