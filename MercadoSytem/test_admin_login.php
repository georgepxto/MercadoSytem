<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/admin/login', 'POST', [
    'email' => 'admin@admin.com',
    'password' => 'admin123',
    '_token' => 'test-token'
]);

// Simular sessão para teste
$request->setLaravelSession(new Illuminate\Session\Store('test', new Illuminate\Session\ArraySessionHandler(60)));

try {
    $response = $kernel->handle($request);
    
    echo "Status Code: " . $response->getStatusCode() . "\n";
    echo "Headers: " . print_r($response->headers->all(), true) . "\n";
    
    if ($response->getStatusCode() === 302) {
        echo "Redirect Location: " . $response->headers->get('Location') . "\n";
        echo "SUCCESS: Admin login is working!\n";
    } else {
        echo "Response Content: " . $response->getContent() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

$kernel->terminate($request, $response);
