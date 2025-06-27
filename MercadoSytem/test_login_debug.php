<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Simular request de login
$request = Illuminate\Http\Request::create('/login', 'POST', [
    'email' => 'admin@admin.com',
    'password' => 'admin123',
    '_token' => 'test-token'
]);

// Mock da session
$session = new Illuminate\Session\Store('test', new Illuminate\Session\ArraySessionHandler(60));
$request->setLaravelSession($session);

echo "=== TESTE DE LOGIN ADMIN ===" . PHP_EOL;
echo "Email: admin@admin.com" . PHP_EOL;
echo "Password: admin123" . PHP_EOL . PHP_EOL;

try {
    // Limpar autenticação anterior
    Illuminate\Support\Facades\Auth::guard('dashboard_manager')->logout();
    
    // Testar credenciais diretamente
    $credentials = ['email' => 'admin@admin.com', 'password' => 'admin123'];
    
    echo "1. Testando autenticação dashboard_manager..." . PHP_EOL;
    if (Illuminate\Support\Facades\Auth::guard('dashboard_manager')->attempt($credentials)) {
        echo "   ✅ SUCCESS: Admin autenticado no guard dashboard_manager!" . PHP_EOL;
        echo "   User ID: " . Illuminate\Support\Facades\Auth::guard('dashboard_manager')->id() . PHP_EOL;
        echo "   User Name: " . Illuminate\Support\Facades\Auth::guard('dashboard_manager')->user()->name . PHP_EOL;
        
        // Simular o que o controller faria
        echo PHP_EOL . "2. Testando redirecionamento..." . PHP_EOL;
        $redirectUrl = '/admin/dashboard';
        echo "   Redirecionando para: " . $redirectUrl . PHP_EOL;
        
        // Verificar se a rota existe
        echo PHP_EOL . "3. Verificando se rota admin.dashboard existe..." . PHP_EOL;
        try {
            $route = Illuminate\Support\Facades\Route::getRoutes()->getByName('admin.dashboard');
            if ($route) {
                echo "   ✅ Rota admin.dashboard encontrada: " . $route->uri() . PHP_EOL;
            } else {
                echo "   ❌ Rota admin.dashboard NÃO encontrada!" . PHP_EOL;
            }
        } catch (Exception $e) {
            echo "   ❌ Erro ao verificar rota: " . $e->getMessage() . PHP_EOL;
        }
        
    } else {
        echo "   ❌ FAILED: Admin NÃO conseguiu autenticar!" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "ERRO: " . $e->getMessage() . PHP_EOL;
    echo "Trace: " . $e->getTraceAsString() . PHP_EOL;
}

echo PHP_EOL . "=== FIM DO TESTE ===" . PHP_EOL;
