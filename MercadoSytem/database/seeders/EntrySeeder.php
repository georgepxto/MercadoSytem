<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Entry;
use Carbon\Carbon;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entries = [
            [
                'vendor_id' => 1,
                'box_id' => 1,
                'entry_time' => Carbon::today()->setTime(8, 15),
                'exit_time' => Carbon::today()->setTime(16, 0),
                'entry_date' => Carbon::today()->format('Y-m-d'),
                'notes' => 'Chegada pontual, box organizado',
            ],
            [
                'vendor_id' => 2,
                'box_id' => 2,
                'entry_time' => Carbon::today()->setTime(10, 30),
                'exit_time' => null, // Ainda não saiu
                'entry_date' => Carbon::today()->format('Y-m-d'),
                'notes' => 'Trouxe novos produtos para degustação',
            ],
            [
                'vendor_id' => 3,
                'box_id' => 3,
                'entry_time' => Carbon::yesterday()->setTime(16, 0),
                'exit_time' => Carbon::yesterday()->setTime(22, 15),
                'entry_date' => Carbon::yesterday()->format('Y-m-d'),
                'notes' => 'Movimento intenso no final de semana',
            ],
            [
                'vendor_id' => 1,
                'box_id' => 1,
                'entry_time' => Carbon::yesterday()->setTime(8, 0),
                'exit_time' => Carbon::yesterday()->setTime(15, 45),
                'entry_date' => Carbon::yesterday()->format('Y-m-d'),
                'notes' => 'Dia tranquilo, boa vendagem',
            ],
            [
                'vendor_id' => 4,
                'box_id' => 4,
                'entry_time' => Carbon::today()->setTime(14, 10),
                'exit_time' => null, // Ainda não saiu
                'entry_date' => Carbon::today()->format('Y-m-d'),
                'notes' => 'Preparando novos doces para o final de semana',
            ]
        ];

        foreach ($entries as $entry) {
            Entry::create($entry);
        }
    }
}
