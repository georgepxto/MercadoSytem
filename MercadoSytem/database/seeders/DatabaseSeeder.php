<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // Sistema de autenticação
            DashboardManagerSeeder::class,
            UserSeeder::class,
            
            // Sistema principal
            BoxSeeder::class,
            VendorSeeder::class,
            ScheduleSeeder::class,
            EntrySeeder::class,
            
            // Sistema de food market
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
