<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\Box;
use App\Models\Schedule;

class MarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criar boxes
        $boxes = [
            ['number' => 'A01', 'location' => 'Setor A - Entrada Principal', 'monthly_price' => 800.00],
            ['number' => 'A02', 'location' => 'Setor A - Entrada Principal', 'monthly_price' => 800.00],
            ['number' => 'B01', 'location' => 'Setor B - Centro', 'monthly_price' => 1000.00],
            ['number' => 'B02', 'location' => 'Setor B - Centro', 'monthly_price' => 1000.00],
            ['number' => 'C01', 'location' => 'Setor C - Fundos', 'monthly_price' => 600.00],
            ['number' => 'C02', 'location' => 'Setor C - Fundos', 'monthly_price' => 600.00],
        ];

        foreach ($boxes as $boxData) {
            Box::create($boxData);
        }

        // Criar vendedores
        $vendors = [
            [
                'name' => 'João Silva',
                'email' => 'joao@email.com',
                'phone' => '(11) 99999-1111',
                'food_type' => 'Lanches e Salgados',
                'description' => 'Especialista em coxinhas e pastéis'
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria@email.com',
                'phone' => '(11) 99999-2222',
                'food_type' => 'Comida Japonesa',
                'description' => 'Sushi e temakis frescos'
            ],
            [
                'name' => 'Carlos Oliveira',
                'email' => 'carlos@email.com',
                'phone' => '(11) 99999-3333',
                'food_type' => 'Açaí e Sucos',
                'description' => 'Açaí na tigela e sucos naturais'
            ],
            [
                'name' => 'Ana Costa',
                'email' => 'ana@email.com',
                'phone' => '(11) 99999-4444',
                'food_type' => 'Comida Árabe',
                'description' => 'Esfihas e kebabs tradicionais'
            ]
        ];

        foreach ($vendors as $vendorData) {
            Vendor::create($vendorData);
        }

        // Criar horários (schedules)
        $schedules = [
            // João - Box A01
            ['vendor_id' => 1, 'box_id' => 1, 'day_of_week' => 'segunda', 'start_time' => '08:00', 'end_time' => '18:00'],
            ['vendor_id' => 1, 'box_id' => 1, 'day_of_week' => 'terça', 'start_time' => '08:00', 'end_time' => '18:00'],
            ['vendor_id' => 1, 'box_id' => 1, 'day_of_week' => 'quarta', 'start_time' => '08:00', 'end_time' => '18:00'],
            
            // Maria - Box B01
            ['vendor_id' => 2, 'box_id' => 3, 'day_of_week' => 'terça', 'start_time' => '10:00', 'end_time' => '20:00'],
            ['vendor_id' => 2, 'box_id' => 3, 'day_of_week' => 'quinta', 'start_time' => '10:00', 'end_time' => '20:00'],
            ['vendor_id' => 2, 'box_id' => 3, 'day_of_week' => 'sexta', 'start_time' => '10:00', 'end_time' => '20:00'],
            
            // Carlos - Box C01
            ['vendor_id' => 3, 'box_id' => 5, 'day_of_week' => 'segunda', 'start_time' => '06:00', 'end_time' => '16:00'],
            ['vendor_id' => 3, 'box_id' => 5, 'day_of_week' => 'quarta', 'start_time' => '06:00', 'end_time' => '16:00'],
            ['vendor_id' => 3, 'box_id' => 5, 'day_of_week' => 'sábado', 'start_time' => '06:00', 'end_time' => '16:00'],
            
            // Ana - Box A02
            ['vendor_id' => 4, 'box_id' => 2, 'day_of_week' => 'quinta', 'start_time' => '11:00', 'end_time' => '21:00'],
            ['vendor_id' => 4, 'box_id' => 2, 'day_of_week' => 'sexta', 'start_time' => '11:00', 'end_time' => '21:00'],
            ['vendor_id' => 4, 'box_id' => 2, 'day_of_week' => 'sábado', 'start_time' => '11:00', 'end_time' => '21:00'],
        ];

        foreach ($schedules as $scheduleData) {
            Schedule::create($scheduleData);
        }
    }
}
