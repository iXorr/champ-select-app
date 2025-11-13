<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Цветы',
                'slug' => 'flowers',
                'icon' => 'F',
                'description' => 'Свежие живые цветы от проверенных поставщиков.',
                'display_order' => 1,
            ],
            [
                'name' => 'Букеты',
                'slug' => 'bouquets',
                'icon' => 'B',
                'description' => 'Авторские композиции для любого повода.',
                'display_order' => 2,
            ],
            [
                'name' => 'Упаковка',
                'slug' => 'wrapping',
                'icon' => 'P',
                'description' => 'Декоративные материалы и отдельные элементы оформления.',
                'display_order' => 3,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
