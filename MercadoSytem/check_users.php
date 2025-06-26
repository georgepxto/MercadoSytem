<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::all();

echo "Usuários no sistema:\n";
echo "===================\n";

foreach($users as $user) {
    echo "ID: {$user->id}\n";
    echo "Nome: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Dashboard Name: {$user->getDashboardName()}\n";
    echo "---\n";
}

echo "\nAdmin:\n";
echo "======\n";
$admin = App\Models\DashboardManager::first();
if($admin) {
    echo "Nome: {$admin->name}\n";
    echo "Email: {$admin->email}\n";
}
