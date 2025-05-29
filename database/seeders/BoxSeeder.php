<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Box;

class BoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boxes = [
            [
                'number' => 'A',
                'location' => 'Entrada Principal',
                'description' => 'Box localizado na entrada principal do estabelecimento',
                'available' => true,
                'monthly_price' => 800.00,
            ],
            [
                'number' => 'B', 
                'location' => 'Área Central',
                'description' => 'Box na área central com boa visibilidade',
                'available' => true,
                'monthly_price' => 1200.00,
            ],
            [
                'number' => 'C',
                'location' => 'Lateral Direita',
                'description' => 'Box na lateral direita do espaço',
                'available' => true,
                'monthly_price' => 600.00,
            ],
            [
                'number' => 'D',
                'location' => 'Área dos Fundos',
                'description' => 'Box nos fundos, área mais reservada',
                'available' => true,
                'monthly_price' => 500.00,
            ],
            [
                'number' => 'E',
                'location' => 'Lateral Esquerda',
                'description' => 'Box na lateral esquerda com acesso facilitado',
                'available' => false,
                'monthly_price' => 700.00,
            ]
        ];

        foreach ($boxes as $box) {
            Box::create($box);
        }
    }
}
