<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendors = [
            [
                'name' => 'João Silva',
                'email' => 'joao@email.com',
                'phone' => '(11) 99999-1111',
                'food_type' => 'Lanches e Salgados',
                'description' => 'Especialista em coxinhas e pastéis',
                'active' => true
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria@email.com',
                'phone' => '(11) 99999-2222',
                'food_type' => 'Comida Japonesa',
                'description' => 'Sushi e temakis frescos',
                'active' => true
            ],
            [
                'name' => 'Carlos Pizza',
                'email' => 'carlos@email.com',
                'phone' => '(11) 99999-3333',
                'food_type' => 'Pizzaria',
                'description' => 'Pizzas artesanais no forno a lenha',
                'active' => true
            ],
            [
                'name' => 'Ana Doces',
                'email' => 'ana@email.com',
                'phone' => '(11) 99999-4444',
                'food_type' => 'Confeitaria',
                'description' => 'Doces e sobremesas artesanais',
                'active' => true
            ],
            [
                'name' => 'Pedro Grill',
                'email' => 'pedro@email.com',
                'phone' => '(11) 99999-5555',
                'food_type' => 'Churrasco',
                'description' => 'Carnes na brasa e acompanhamentos',
                'active' => true
            ]
        ];

        foreach ($vendors as $vendor) {
            Vendor::create($vendor);
        }
    }
}
