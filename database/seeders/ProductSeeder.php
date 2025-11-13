<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Роза Кения Premium',
                'category_slug' => 'flowers',
                'supplier_country' => 'Кения',
                'product_type' => 'Роза',
                'color' => 'Красный',
                'description' => 'Классические крупные бутоны, стойкий аромат и насыщенный цвет.',
                'image_url' => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?auto=format&fit=crop&w=600&q=80',
                'stock' => 30,
                'price' => 450,
            ],
            [
                'name' => 'Монобукет пионов',
                'category_slug' => 'bouquets',
                'supplier_country' => 'Нидерланды',
                'product_type' => 'Букет',
                'color' => 'Нежно-розовый',
                'description' => 'Легкий воздушный букет из сезонных пионов в крафтовой упаковке.',
                'image_url' => 'https://images.unsplash.com/photo-1509043759401-136742328bb3?auto=format&fit=crop&w=600&q=80',
                'stock' => 15,
                'price' => 5200,
            ],
            [
                'name' => 'Эвкалипт серебристый',
                'category_slug' => 'flowers',
                'supplier_country' => 'Италия',
                'product_type' => 'Зелень',
                'color' => 'Серебристо-зеленый',
                'description' => 'Добавляет сочности и объема в любой букет, долго сохраняет свежесть.',
                'image_url' => 'https://images.unsplash.com/photo-1425421543490-6a133856ff32?auto=format&fit=crop&w=600&q=80',
                'stock' => 40,
                'price' => 250,
            ],
            [
                'name' => 'Букет «Северное сияние»',
                'category_slug' => 'bouquets',
                'supplier_country' => 'Россия',
                'product_type' => 'Букет',
                'color' => 'Микс',
                'description' => 'Композиция из роз, дельфиниума и хлопка в шляпной коробке.',
                'image_url' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=600&q=80',
                'stock' => 9,
                'price' => 6800,
            ],
            [
                'name' => 'Коробка «Нежность»',
                'category_slug' => 'wrapping',
                'supplier_country' => 'Россия',
                'product_type' => 'Упаковка',
                'color' => 'Пудровый',
                'description' => 'Плотный картон с бархатным покрытием, подходит для подарков и цветов.',
                'image_url' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=600&q=80',
                'stock' => 25,
                'price' => 850,
            ],
            [
                'name' => 'Лилия восточная белая',
                'category_slug' => 'flowers',
                'supplier_country' => 'Эквадор',
                'product_type' => 'Лилия',
                'color' => 'Белый',
                'description' => 'Выразительные крупные цветы с тонким ароматом.',
                'image_url' => 'https://images.unsplash.com/photo-1447753072467-2f56032d1d48?auto=format&fit=crop&w=600&q=80',
                'stock' => 18,
                'price' => 620,
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category_slug'])->first();

            if (! $category) {
                continue;
            }

            $slug = Str::slug($productData['name'] . '-' . $category->id);

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'slug' => $slug,
                    'supplier_country' => $productData['supplier_country'],
                    'product_type' => $productData['product_type'],
                    'color' => $productData['color'],
                    'description' => $productData['description'],
                    'image_url' => $productData['image_url'],
                    'stock' => $productData['stock'],
                    'price' => $productData['price'],
                    'is_active' => true,
                ]
            );
        }
    }
}
