<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedules = [
            [
                'vendor_id' => 1,
                'box_id' => 1,
                'day_of_week' => 'segunda',
                'start_time' => '08:00',
                'end_time' => '16:00',
                'active' => true,
            ],
            [
                'vendor_id' => 1,
                'box_id' => 1,
                'day_of_week' => 'terça',
                'start_time' => '08:00',
                'end_time' => '16:00',
                'active' => true,
            ],
            [
                'vendor_id' => 2,
                'box_id' => 2,
                'day_of_week' => 'segunda',
                'start_time' => '10:00',
                'end_time' => '18:00',
                'active' => true,
            ],
            [
                'vendor_id' => 2,
                'box_id' => 2,
                'day_of_week' => 'quarta',
                'start_time' => '10:00',
                'end_time' => '18:00',
                'active' => true,
            ],
            [
                'vendor_id' => 3,
                'box_id' => 3,
                'day_of_week' => 'sexta',
                'start_time' => '16:00',
                'end_time' => '22:00',
                'active' => true,
            ],
            [
                'vendor_id' => 3,
                'box_id' => 3,
                'day_of_week' => 'sábado',
                'start_time' => '16:00',
                'end_time' => '22:00',
                'active' => true,
            ],
            [
                'vendor_id' => 4,
                'box_id' => 4,
                'day_of_week' => 'quinta',
                'start_time' => '14:00',
                'end_time' => '20:00',
                'active' => true,
            ],
            [
                'vendor_id' => 5,
                'box_id' => 4,
                'day_of_week' => 'domingo',
                'start_time' => '12:00',
                'end_time' => '20:00',
                'active' => true,
            ]
        ];

        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }
    }
}
