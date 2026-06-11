<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Usuário MercadoFatima
        User::create([
            'name' => 'MercadoFatima',
            'email' => 'contato@mercadofatima.com',
            'password' => Hash::make(env('DEMO_USER_PASSWORD', 'fatima123')),
            'dashboard_name' => 'MercadoFatima',
            'user_type' => 'common',
            'has_dashboard_access' => true,
        ]);

        // Usuário de teste sem acesso
        User::create([
            'name' => 'Usuário Teste',
            'email' => 'teste@example.com',
            'password' => Hash::make(env('DEMO_USER_PASSWORD', 'teste123')),
            'dashboard_name' => 'Teste Dashboard',
            'user_type' => 'common',
            'has_dashboard_access' => false,
        ]);
    }
}
