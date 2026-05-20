<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Pomada Mate Strong Hold',  'brand' => 'American Crew', 'price' => 18.50, 'image' => 'https://images.unsplash.com/photo-1585751119414-ef2636f8aede?w=400&q=80', 'category' => 'Cabello', 'stock' => 12],
            ['name' => 'Aceite de Barba Premium',  'brand' => 'Proraso',       'price' => 22.00, 'image' => 'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?w=400&q=80', 'category' => 'Barba',   'stock' => 8],
            ['name' => 'Bálsamo After Shave',      'brand' => 'Baxter of CA',  'price' => 27.00, 'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&q=80', 'category' => 'Barba',   'stock' => 5],
            ['name' => 'Champú para Hombre',       'brand' => 'Jack Black',    'price' => 19.90, 'image' => 'https://images.unsplash.com/photo-1567721913486-6585f069b3d?w=400&q=80', 'category' => 'Cabello', 'stock' => 15],
            ['name' => 'Cera Modeladora',          'brand' => 'Layrite',       'price' => 16.00, 'image' => 'https://images.unsplash.com/photo-1600298882525-21a4f7e5e2bb?w=400&q=80', 'category' => 'Cabello', 'stock' => 10],
            ['name' => 'Gel de Afeitado',          'brand' => 'Proraso',       'price' => 12.50, 'image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=400&q=80', 'category' => 'Barba',   'stock' => 20],
            ['name' => 'Mascarilla Capilar',       'brand' => 'Redken',        'price' => 24.00, 'image' => 'https://images.unsplash.com/photo-1591870622906-e2682f41f78a?w=400&q=80', 'category' => 'Cabello', 'stock' => 6],
            ['name' => 'Loción Fijadora',          'brand' => 'Reuzel',        'price' => 14.90, 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&q=80', 'category' => 'Cabello', 'stock' => 9],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
