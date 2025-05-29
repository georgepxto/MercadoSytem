<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Lanches',
                'description' => 'Hambúrgueres, sanduíches e lanches em geral',
                'active' => true
            ],
            [
                'name' => 'Comida Japonesa',
                'description' => 'Sushi, sashimi, temaki e pratos japoneses',
                'active' => true
            ],
            [
                'name' => 'Pizzas',
                'description' => 'Pizzas doces e salgadas',
                'active' => true
            ],
            [
                'name' => 'Bebidas',
                'description' => 'Refrigerantes, sucos e bebidas diversas',
                'active' => true
            ],
            [
                'name' => 'Sobremesas',
                'description' => 'Doces, sorvetes e sobremesas',
                'active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
