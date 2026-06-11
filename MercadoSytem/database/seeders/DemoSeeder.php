<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedMain();
        $this->seedTenant();
    }

    private function seedMain(): void
    {
        DB::connection('main')->statement('SET FOREIGN_KEY_CHECKS=0');

        // ── Vendors ────────────────────────────────────────────────────────────
        $vendors = [
            ['name' => 'D. Maria das Graças',  'email' => 'mariagracas@email.com',  'phone' => '(85) 98801-1234', 'food_type' => 'Tapioca e Cuscuz',          'description' => 'Especialidade em tapiocas recheadas e cuscuz temperado, receita da família há 30 anos.', 'active' => true, 'has_cnpj' => false, 'cnpj' => null],
            ['name' => 'Sr. Antônio Freitas',   'email' => 'antoniofreitas@email.com','phone' => '(85) 99934-5678', 'food_type' => 'Carnes e Assados',           'description' => 'Carne de sol, espetinhos e frango assado. Tempero mineiro com toque nordestino.', 'active' => true, 'has_cnpj' => true,  'cnpj' => '12.345.678/0001-90'],
            ['name' => 'Barraca da Conceição',  'email' => 'conceicao@email.com',    'phone' => '(85) 98712-9012', 'food_type' => 'Sucos e Vitaminas',          'description' => 'Sucos naturais de frutas da estação, vitaminas e água de coco.', 'active' => true, 'has_cnpj' => false, 'cnpj' => null],
            ['name' => 'Peixaria do Seu Raimundo','email' => 'raimundo@email.com',   'phone' => '(85) 98623-3456', 'food_type' => 'Peixes e Frutos do Mar',     'description' => 'Peixe fresco do dia, camarão, lagosta e mariscos. Entrega nas primeiras horas da manhã.', 'active' => true, 'has_cnpj' => true, 'cnpj' => '98.765.432/0001-10'],
            ['name' => 'Quitanda da Vera',      'email' => 'vera@email.com',         'phone' => '(85) 98534-7890', 'food_type' => 'Frutas e Verduras',          'description' => 'Hortifrutigranjeiros selecionados, orgânicos e da roça.', 'active' => true, 'has_cnpj' => false, 'cnpj' => null],
            ['name' => 'Salgados da Tia Sandra', 'email' => 'sandra@email.com',      'phone' => '(85) 98445-1234', 'food_type' => 'Salgados e Lanches',         'description' => 'Salgados assados e fritos, pastéis, coxinhas e esfihas. Feitos na hora.', 'active' => true, 'has_cnpj' => false, 'cnpj' => null],
            ['name' => 'Açaí do Paraíso',       'email' => 'acaipаraiso@email.com',  'phone' => '(85) 98356-5678', 'food_type' => 'Açaí e Sorvetes',           'description' => 'Açaí natural do Pará, sorvetes artesanais e picolés.', 'active' => true, 'has_cnpj' => true,  'cnpj' => '11.222.333/0001-44'],
            ['name' => 'Padaria Bom Pão',       'email' => 'bompao@email.com',       'phone' => '(85) 98267-9012', 'food_type' => 'Pão e Confeitaria',         'description' => 'Pão francês quentinho, bolos decorados, biscoitos e doces finos.', 'active' => false,'has_cnpj' => true,  'cnpj' => '55.666.777/0001-88'],
        ];

        DB::connection('main')->table('vendors')->truncate();
        foreach ($vendors as $v) {
            DB::connection('main')->table('vendors')->insert(array_merge($v, [
                'created_at' => now()->subDays(rand(30, 180)),
                'updated_at' => now(),
            ]));
        }

        // ── Boxes ──────────────────────────────────────────────────────────────
        $boxes = [
            ['name' => 'Box Central A',   'number' => '01', 'location' => 'Ala Central',   'description' => 'Próximo à entrada principal, alto fluxo de clientes.',  'available' => true,  'monthly_price' => 350.00],
            ['name' => 'Box Central B',   'number' => '02', 'location' => 'Ala Central',   'description' => 'Próximo à entrada principal, alto fluxo de clientes.',  'available' => true,  'monthly_price' => 350.00],
            ['name' => 'Box Norte 01',    'number' => '03', 'location' => 'Ala Norte',     'description' => 'Setor de frios e laticínios.',                          'available' => true,  'monthly_price' => 280.00],
            ['name' => 'Box Norte 02',    'number' => '04', 'location' => 'Ala Norte',     'description' => 'Setor de frios e laticínios.',                          'available' => true,  'monthly_price' => 280.00],
            ['name' => 'Box Sul 01',      'number' => '05', 'location' => 'Ala Sul',       'description' => 'Próximo ao estacionamento, boa acessibilidade.',        'available' => true,  'monthly_price' => 260.00],
            ['name' => 'Box Sul 02',      'number' => '06', 'location' => 'Ala Sul',       'description' => 'Próximo ao estacionamento, boa acessibilidade.',        'available' => true,  'monthly_price' => 260.00],
            ['name' => 'Box Leste 01',    'number' => '07', 'location' => 'Ala Leste',     'description' => 'Setor de mercearia e produtos secos.',                  'available' => true,  'monthly_price' => 240.00],
            ['name' => 'Box Leste 02',    'number' => '08', 'location' => 'Ala Leste',     'description' => 'Setor de mercearia e produtos secos.',                  'available' => false, 'monthly_price' => 240.00],
            ['name' => 'Box Gourmet 01',  'number' => '09', 'location' => 'Praça Gourmet', 'description' => 'Área de alimentação e restaurantes, espaço premium.',   'available' => true,  'monthly_price' => 450.00],
            ['name' => 'Box Gourmet 02',  'number' => '10', 'location' => 'Praça Gourmet', 'description' => 'Área de alimentação e restaurantes, espaço premium.',   'available' => true,  'monthly_price' => 450.00],
        ];

        DB::connection('main')->table('boxes')->truncate();
        foreach ($boxes as $b) {
            DB::connection('main')->table('boxes')->insert(array_merge($b, [
                'qr_token'   => \Illuminate\Support\Str::uuid(),
                'created_at' => now()->subDays(rand(30, 180)),
                'updated_at' => now(),
            ]));
        }

        $vendorIds = DB::connection('main')->table('vendors')->orderBy('id')->pluck('id')->toArray();
        $boxIds    = DB::connection('main')->table('boxes')->orderBy('id')->pluck('id')->toArray();

        // ── Schedules ──────────────────────────────────────────────────────────
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        $scheduleMap = [
            // vendor_id => [[box_id, days[], start, end]]
            0 => [[$boxIds[0], ['monday','wednesday','friday','saturday'], '06:00', '14:00']],
            1 => [[$boxIds[1], ['tuesday','thursday','saturday','sunday'], '07:00', '15:00'],
                  [$boxIds[8], ['monday','friday'], '11:00', '20:00']],
            2 => [[$boxIds[2], $days, '06:30', '18:00']],
            3 => [[$boxIds[3], ['monday','tuesday','wednesday','thursday','friday'], '04:00', '12:00']],
            4 => [[$boxIds[4], $days, '05:00', '13:00']],
            5 => [[$boxIds[5], ['thursday','friday','saturday','sunday'], '08:00', '17:00']],
            6 => [[$boxIds[9], ['friday','saturday','sunday'], '12:00', '22:00']],
        ];

        DB::connection('main')->table('schedules')->truncate();
        foreach ($scheduleMap as $vi => $groups) {
            foreach ($groups as [$bid, $scheduleDays, $start, $end]) {
                foreach ($scheduleDays as $day) {
                    DB::connection('main')->table('schedules')->insert([
                        'vendor_id'   => $vendorIds[$vi],
                        'box_id'      => $bid,
                        'day_of_week' => $day,
                        'start_time'  => $start,
                        'end_time'    => $end,
                        'active'      => true,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }
            }
        }

        // ── Entries (histórico dos últimos 30 dias + entradas de hoje) ─────────
        DB::connection('main')->table('entries')->truncate();

        // Histórico passado (30 dias)
        $pairs = [
            [$vendorIds[0], $boxIds[0]],
            [$vendorIds[1], $boxIds[1]],
            [$vendorIds[2], $boxIds[2]],
            [$vendorIds[3], $boxIds[3]],
            [$vendorIds[4], $boxIds[4]],
            [$vendorIds[5], $boxIds[5]],
            [$vendorIds[6], $boxIds[9]],
        ];

        for ($d = 30; $d >= 1; $d--) {
            $date = Carbon::today()->subDays($d);
            $dayOfWeek = strtolower($date->format('l'));
            $count = rand(2, 5);
            $usedPairs = array_rand($pairs, min($count, count($pairs)));
            if (!is_array($usedPairs)) $usedPairs = [$usedPairs];

            foreach ($usedPairs as $pi) {
                [$vid, $bid] = $pairs[$pi];
                $entryHour = rand(5, 9);
                $exitHour  = $entryHour + rand(5, 10);
                $entryTime = $date->copy()->setHour($entryHour)->setMinute(rand(0,59));
                $exitTime  = $date->copy()->setHour(min($exitHour, 22))->setMinute(rand(0,59));

                DB::connection('main')->table('entries')->insert([
                    'vendor_id'  => $vid,
                    'box_id'     => $bid,
                    'entry_date' => $date->toDateString(),
                    'entry_time' => $entryTime,
                    'exit_time'  => $exitTime,
                    'notes'      => null,
                    'created_at' => $entryTime,
                    'updated_at' => $exitTime,
                ]);
            }
        }

        DB::connection('main')->statement('SET FOREIGN_KEY_CHECKS=1');

        // Entradas de hoje (algumas ainda sem check-out)
        $todayEntries = [
            [$vendorIds[0], $boxIds[0], '06:15', null],
            [$vendorIds[2], $boxIds[2], '06:40', null],
            [$vendorIds[4], $boxIds[4], '05:50', '11:30'],
            [$vendorIds[3], $boxIds[3], '04:30', '10:00'],
            [$vendorIds[1], $boxIds[1], '07:10', null],
        ];

        foreach ($todayEntries as [$vid, $bid, $entry, $exit]) {
            $today = Carbon::today();
            DB::connection('main')->table('entries')->insert([
                'vendor_id'  => $vid,
                'box_id'     => $bid,
                'entry_date' => $today->toDateString(),
                'entry_time' => $today->copy()->setTimeFromTimeString($entry),
                'exit_time'  => $exit ? $today->copy()->setTimeFromTimeString($exit) : null,
                'notes'      => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function seedTenant(): void
    {
        // Configura conexão tenant para o usuário 1
        \Illuminate\Support\Facades\Config::set('database.connections.tenant', [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', '127.0.0.1'),
            'port'      => env('DB_PORT', '3306'),
            'database'  => 'mercado_user_1',
            'username'  => env('DB_USERNAME', 'root'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => true,
            'engine'    => null,
        ]);

        DB::connection('tenant')->statement('SET FOREIGN_KEY_CHECKS=0');

        // Espelha os vendors do main → tenant para satisfazer FKs locais
        DB::connection('tenant')->table('vendors')->truncate();
        $mainVendors = DB::connection('main')->table('vendors')->get();
        foreach ($mainVendors as $v) {
            DB::connection('tenant')->table('vendors')->insert((array) $v);
        }

        // ── Categories ─────────────────────────────────────────────────────────
        $categories = [
            ['name' => 'Laticínios',    'description' => 'Queijos, iogurtes, manteiga e derivados do leite.', 'active' => true],
            ['name' => 'Carnes',        'description' => 'Carnes bovinas, suínas, aves e embutidos.',          'active' => true],
            ['name' => 'Hortifruti',    'description' => 'Frutas, legumes, verduras e cogumelos.',             'active' => true],
            ['name' => 'Mercearia',     'description' => 'Grãos, cereais, massas, farinhas e temperos.',       'active' => true],
            ['name' => 'Bebidas',       'description' => 'Sucos, refrigerantes, águas e bebidas alcoólicas.',  'active' => true],
            ['name' => 'Padaria',       'description' => 'Pães, bolos, tortas e confeitaria.',                 'active' => true],
            ['name' => 'Frutos do Mar', 'description' => 'Peixes, camarões, lagostas e mariscos.',            'active' => true],
        ];

        DB::connection('tenant')->statement('SET FOREIGN_KEY_CHECKS=0');
        DB::connection('tenant')->table('categories')->truncate();
        foreach ($categories as $c) {
            DB::connection('tenant')->table('categories')->insert(array_merge($c, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $catIds = DB::connection('tenant')->table('categories')->orderBy('id')->pluck('id')->toArray();
        $vendorIds = DB::connection('main')->table('vendors')->orderBy('id')->pluck('id')->toArray();

        // ── Products ───────────────────────────────────────────────────────────
        $products = [
            // Laticínios
            ['name' => 'Queijo Coalho (kg)',    'description' => 'Queijo coalho artesanal do Ceará.',        'price' => 28.90, 'vendor_id' => $vendorIds[0], 'category_id' => $catIds[0], 'available' => true],
            ['name' => 'Manteiga de Garrafa',   'description' => 'Manteiga de garrafa 500ml pura.',          'price' => 18.50, 'vendor_id' => $vendorIds[0], 'category_id' => $catIds[0], 'available' => true],
            // Carnes
            ['name' => 'Carne de Sol (kg)',     'description' => 'Carne de sol maturada, tempero especial.', 'price' => 45.00, 'vendor_id' => $vendorIds[1], 'category_id' => $catIds[1], 'available' => true],
            ['name' => 'Frango Assado (un)',    'description' => 'Frango inteiro assado na brasa.',           'price' => 32.00, 'vendor_id' => $vendorIds[1], 'category_id' => $catIds[1], 'available' => true],
            ['name' => 'Espetinho Bovino',      'description' => 'Espetinho de alcatra, 6 unidades.',        'price' => 22.00, 'vendor_id' => $vendorIds[1], 'category_id' => $catIds[1], 'available' => true],
            // Bebidas
            ['name' => 'Suco de Cajá (500ml)',  'description' => 'Suco natural de cajá sem conservantes.',   'price' =>  8.00, 'vendor_id' => $vendorIds[2], 'category_id' => $catIds[4], 'available' => true],
            ['name' => 'Vitamina de Manga',     'description' => 'Vitamina cremosa de manga com leite.',      'price' =>  9.50, 'vendor_id' => $vendorIds[2], 'category_id' => $catIds[4], 'available' => true],
            ['name' => 'Água de Coco (un)',     'description' => 'Coco verde gelado na hora.',                'price' =>  6.00, 'vendor_id' => $vendorIds[2], 'category_id' => $catIds[4], 'available' => true],
            // Frutos do Mar
            ['name' => 'Filé de Tilápia (kg)',  'description' => 'Tilápia fresca, limpa e fileteada.',       'price' => 22.00, 'vendor_id' => $vendorIds[3], 'category_id' => $catIds[6], 'available' => true],
            ['name' => 'Camarão Médio (kg)',    'description' => 'Camarão médio fresco, descascado.',         'price' => 65.00, 'vendor_id' => $vendorIds[3], 'category_id' => $catIds[6], 'available' => true],
            ['name' => 'Lagosta Inteira (un)',  'description' => 'Lagosta fresca inteira, aprox. 500g.',      'price' => 90.00, 'vendor_id' => $vendorIds[3], 'category_id' => $catIds[6], 'available' => false],
            // Hortifruti
            ['name' => 'Bandeja Tomate (1kg)',  'description' => 'Tomate italiano maduro, 1kg.',              'price' =>  6.50, 'vendor_id' => $vendorIds[4], 'category_id' => $catIds[2], 'available' => true],
            ['name' => 'Manga Tommy (un)',      'description' => 'Manga tommy madura e docinha.',              'price' =>  3.00, 'vendor_id' => $vendorIds[4], 'category_id' => $catIds[2], 'available' => true],
            ['name' => 'Alface Crespa (un)',    'description' => 'Alface crespa hidropônica.',                'price' =>  3.50, 'vendor_id' => $vendorIds[4], 'category_id' => $catIds[2], 'available' => true],
            // Salgados
            ['name' => 'Coxinha (un)',          'description' => 'Coxinha de frango cremosa, 100g.',          'price' =>  5.00, 'vendor_id' => $vendorIds[5], 'category_id' => $catIds[5], 'available' => true],
            ['name' => 'Esfiha de Carne (un)',  'description' => 'Esfiha aberta de carne moída.',             'price' =>  4.50, 'vendor_id' => $vendorIds[5], 'category_id' => $catIds[5], 'available' => true],
            // Açaí
            ['name' => 'Açaí 300ml',           'description' => 'Açaí puro com granola e frutas.',           'price' => 15.00, 'vendor_id' => $vendorIds[6], 'category_id' => $catIds[4], 'available' => true],
            ['name' => 'Açaí 500ml',           'description' => 'Açaí puro com granola e frutas.',           'price' => 22.00, 'vendor_id' => $vendorIds[6], 'category_id' => $catIds[4], 'available' => true],
        ];

        DB::connection('tenant')->table('products')->truncate();

        DB::connection('tenant')->statement('SET FOREIGN_KEY_CHECKS=1');
        foreach ($products as $p) {
            DB::connection('tenant')->table('products')->insert(array_merge($p, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
