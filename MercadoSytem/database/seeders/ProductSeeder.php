<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            // Vendor 1 - João Silva (Lanches)
            [
                'name' => 'Coxinha de Frango',
                'description' => 'Coxinha tradicional recheada com frango desfiado',
                'price' => 5.50,
                'vendor_id' => 1,
                'category_id' => 1,
                'available' => true
            ],
            [
                'name' => 'Pastel de Queijo',
                'description' => 'Pastel crocante recheado com queijo',
                'price' => 4.00,
                'vendor_id' => 1,
                'category_id' => 1,
                'available' => true
            ],
            [
                'name' => 'Hambúrguer Artesanal',
                'description' => 'Hambúrguer 150g com queijo, alface e tomate',
                'price' => 18.90,
                'vendor_id' => 1,
                'category_id' => 1,
                'available' => true
            ],

            // Vendor 2 - Maria Santos (Comida Japonesa)
            [
                'name' => 'Temaki de Salmão',
                'description' => 'Temaki com salmão fresco, pepino e cream cheese',
                'price' => 12.50,
                'vendor_id' => 2,
                'category_id' => 2,
                'available' => true
            ],
            [
                'name' => 'Combo Sushi 15 peças',
                'description' => 'Mix de sushi com salmão, atum e camarão',
                'price' => 35.90,
                'vendor_id' => 2,
                'category_id' => 2,
                'available' => true
            ],

            // Vendor 3 - Carlos Pizza (Pizzas)
            [
                'name' => 'Pizza Margherita',
                'description' => 'Pizza com molho de tomate, mozzarella e manjericão',
                'price' => 28.90,
                'vendor_id' => 3,
                'category_id' => 3,
                'available' => true
            ],
            [
                'name' => 'Pizza Calabresa',
                'description' => 'Pizza com calabresa, cebola e azeitonas',
                'price' => 32.90,
                'vendor_id' => 3,
                'category_id' => 3,
                'available' => true
            ],

            // Bebidas para vários vendors
            [
                'name' => 'Refrigerante Lata',
                'description' => 'Refrigerante gelado 350ml',
                'price' => 4.50,
                'vendor_id' => 1,
                'category_id' => 4,
                'available' => true
            ],
            [
                'name' => 'Suco Natural de Laranja',
                'description' => 'Suco de laranja natural 500ml',
                'price' => 8.00,
                'vendor_id' => 2,
                'category_id' => 4,
                'available' => true
            ],

            // Sobremesas
            [
                'name' => 'Brigadeiro Gourmet',
                'description' => 'Brigadeiro artesanal com granulado belga',
                'price' => 3.50,
                'vendor_id' => 4,
                'category_id' => 5,
                'available' => true
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
