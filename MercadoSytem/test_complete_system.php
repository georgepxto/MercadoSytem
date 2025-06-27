<?php

require_once 'vendor/autoload.php';

// Bootstrap da aplicação Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\DashboardManager;

echo "=== TESTE COMPLETO DO SISTEMA ===\n\n";

// Testar usuários
echo "1. USUÁRIOS REGULARES:\n";
$users = User::all();
foreach ($users as $user) {
    echo "   - ID: {$user->id} | Nome: {$user->name} | Email: {$user->email} | Dashboard: {$user->getDashboardName()} | Acesso: " . ($user->has_dashboard_access ? 'Sim' : 'Não') . "\n";
}

echo "\n2. ADMINISTRADORES:\n";
$admins = DashboardManager::all();
foreach ($admins as $admin) {
    echo "   - ID: {$admin->id} | Nome: {$admin->name} | Email: {$admin->email}\n";
}

echo "\n3. TESTE DE CRIAÇÃO DE USUÁRIO:\n";
try {
    $testUser = User::create([
        'name' => 'Usuário Teste',
        'email' => 'teste@example.com',
        'password' => bcrypt('password123'),
        'dashboard_name' => 'Dashboard Teste',
        'user_type' => 'common',
        'has_dashboard_access' => true,
    ]);
    echo "   ✓ Usuário criado com sucesso! ID: {$testUser->id}\n";
    
    echo "\n4. TESTE DE EDIÇÃO DE USUÁRIO:\n";
    $testUser->update([
        'name' => 'Usuário Teste Editado',
        'dashboard_name' => 'Dashboard Editada'
    ]);
    echo "   ✓ Usuário editado com sucesso!\n";
    
    echo "\n5. TESTE DE EXCLUSÃO DE USUÁRIO:\n";
    $testUser->delete();
    echo "   ✓ Usuário deletado com sucesso!\n";
    
} catch (Exception $e) {
    echo "   ✗ Erro: " . $e->getMessage() . "\n";
}

echo "\n=== TESTE CONCLUÍDO ===\n";
