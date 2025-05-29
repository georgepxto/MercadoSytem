<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample Order 1
        $order1 = Order::create([
            'customer_name' => 'Ana Silva',
            'customer_email' => 'ana.silva@email.com',
            'customer_phone' => '(11) 98888-1111',
            'vendor_id' => 1,
            'total_amount' => 28.40,
            'status' => 'confirmed'
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => 1, // Coxinha
            'quantity' => 2,
            'price' => 5.50
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => 3, // Hambúrguer
            'quantity' => 1,
            'price' => 18.90
        ]);

        // Sample Order 2
        $order2 = Order::create([
            'customer_name' => 'Roberto Santos',
            'customer_email' => 'roberto@email.com',
            'customer_phone' => '(11) 97777-2222',
            'vendor_id' => 2,
            'total_amount' => 48.40,
            'status' => 'preparing'
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => 5, // Combo Sushi
            'quantity' => 1,
            'price' => 35.90
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => 4, // Temaki
            'quantity' => 1,
            'price' => 12.50
        ]);

        // Sample Order 3
        $order3 = Order::create([
            'customer_name' => 'Fernanda Lima',
            'customer_email' => 'fernanda@email.com',
            'customer_phone' => '(11) 96666-3333',
            'vendor_id' => 3,
            'total_amount' => 32.90,
            'status' => 'ready'
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => 7, // Pizza Calabresa
            'quantity' => 1,
            'price' => 32.90
        ]);
    }
}
