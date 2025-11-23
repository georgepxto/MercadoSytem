<?php

$pdo = new PDO('mysql:host=127.0.0.1;dbname=mercado_sistema;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "🌱 Iniciando população do banco de dados...\n\n";

// ==================== USUÁRIOS ====================
echo "👥 Criando usuários...\n";

$users = [
    ['name' => 'Admin', 'email' => 'admin@admin.com', 'password' => 'admin123'],
    ['name' => 'Contato Mercado', 'email' => 'contato@mercadofatima.com', 'password' => 'admin123'],
    ['name' => 'Usuário Teste', 'email' => 'teste@example.com', 'password' => 'test123'],
    ['name' => 'João Silva', 'email' => 'joao@example.com', 'password' => 'senha123'],
    ['name' => 'Maria Santos', 'email' => 'maria@example.com', 'password' => 'senha123'],
];

$userStmt = $pdo->prepare('INSERT IGNORE INTO users (name, email, password, email_verified_at, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW(), NOW())');

foreach ($users as $user) {
    $hashedPassword = password_hash($user['password'], PASSWORD_BCRYPT);
    $userStmt->execute([$user['name'], $user['email'], $hashedPassword]);
    echo "  ✓ {$user['email']}\n";
}

// ==================== VENDEDORES ====================
echo "\n🏪 Criando vendedores...\n";

$vendors = [
    ['name' => 'Frutas & Legumes', 'email' => 'frutas@example.com', 'phone' => '11999999999', 'food_type' => 'Frutas e Legumes'],
    ['name' => 'Peixes & Frutos do Mar', 'email' => 'peixes@example.com', 'phone' => '11988888888', 'food_type' => 'Peixes'],
    ['name' => 'Carnes Premium', 'email' => 'carnes@example.com', 'phone' => '11977777777', 'food_type' => 'Carnes'],
    ['name' => 'Produtos Orgânicos', 'email' => 'organicos@example.com', 'phone' => '11966666666', 'food_type' => 'Orgânicos'],
    ['name' => 'Laticínios', 'email' => 'laticinios@example.com', 'phone' => '11955555555', 'food_type' => 'Laticínios'],
    ['name' => 'Padaria & Confeitaria', 'email' => 'padaria@example.com', 'phone' => '11944444444', 'food_type' => 'Pão e Confeitaria'],
];

$vendorStmt = $pdo->prepare('INSERT INTO vendors (name, email, phone, food_type, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())');

$vendorIds = [];
foreach ($vendors as $vendor) {
    $vendorStmt->execute([$vendor['name'], $vendor['email'], $vendor['phone'], $vendor['food_type']]);
    $vendorIds[] = $pdo->lastInsertId();
    echo "  ✓ {$vendor['name']} ({$vendor['food_type']})\n";
}

// ==================== CATEGORIAS ====================
echo "\n📂 Criando categorias de produtos...\n";

$categories = [
    ['name' => 'Frutas', 'description' => 'Frutas frescas variadas'],
    ['name' => 'Legumes', 'description' => 'Legumes e verduras'],
    ['name' => 'Carnes', 'description' => 'Carnes vermelhas e aves'],
    ['name' => 'Peixes', 'description' => 'Peixes e frutos do mar'],
    ['name' => 'Laticínios', 'description' => 'Leite, queijo e derivados'],
    ['name' => 'Pão', 'description' => 'Pães e confeitaria'],
];

$categoryStmt = $pdo->prepare('INSERT INTO categories (name, description, created_at, updated_at) VALUES (?, ?, NOW(), NOW())');

$categoryIds = [];
foreach ($categories as $category) {
    $categoryStmt->execute([$category['name'], $category['description']]);
    $categoryIds[] = $pdo->lastInsertId();
    echo "  ✓ {$category['name']}\n";
}

// ==================== PRODUTOS ====================
echo "\n📦 Criando produtos...\n";

$products = [
    // Frutas
    ['vendor_id' => $vendorIds[0], 'category_id' => $categoryIds[0], 'name' => 'Maçã Vermelha', 'price' => 5.99],
    ['vendor_id' => $vendorIds[0], 'category_id' => $categoryIds[0], 'name' => 'Banana Nanica', 'price' => 3.49],
    ['vendor_id' => $vendorIds[0], 'category_id' => $categoryIds[0], 'name' => 'Laranja Pera', 'price' => 4.99],
    ['vendor_id' => $vendorIds[0], 'category_id' => $categoryIds[1], 'name' => 'Alface', 'price' => 2.99],
    ['vendor_id' => $vendorIds[0], 'category_id' => $categoryIds[1], 'name' => 'Tomate Caqui', 'price' => 6.99],
    
    // Carnes
    ['vendor_id' => $vendorIds[2], 'category_id' => $categoryIds[2], 'name' => 'Carne de Boi Mole', 'price' => 35.90],
    ['vendor_id' => $vendorIds[2], 'category_id' => $categoryIds[2], 'name' => 'Frango Inteiro', 'price' => 18.90],
    ['vendor_id' => $vendorIds[2], 'category_id' => $categoryIds[2], 'name' => 'Costela Bovina', 'price' => 42.90],
    
    // Peixes
    ['vendor_id' => $vendorIds[1], 'category_id' => $categoryIds[3], 'name' => 'Salmão', 'price' => 65.90],
    ['vendor_id' => $vendorIds[1], 'category_id' => $categoryIds[3], 'name' => 'Camarão', 'price' => 45.90],
    
    // Laticínios
    ['vendor_id' => $vendorIds[4], 'category_id' => $categoryIds[4], 'name' => 'Leite Integral', 'price' => 4.99],
    ['vendor_id' => $vendorIds[4], 'category_id' => $categoryIds[4], 'name' => 'Queijo Meia Cura', 'price' => 38.90],
    
    // Pão
    ['vendor_id' => $vendorIds[5], 'category_id' => $categoryIds[5], 'name' => 'Pão Francês', 'price' => 0.80],
    ['vendor_id' => $vendorIds[5], 'category_id' => $categoryIds[5], 'name' => 'Bolo de Chocolate', 'price' => 35.00],
];

$productStmt = $pdo->prepare('INSERT INTO products (vendor_id, category_id, name, price, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())');

foreach ($products as $product) {
    $productStmt->execute([$product['vendor_id'], $product['category_id'], $product['name'], $product['price']]);
    echo "  ✓ {$product['name']} - R$ {$product['price']}\n";
}

// ==================== BOXES ====================
echo "\n📦 Criando boxes...\n";

$boxes = [
    ['number' => 'A1', 'location' => 'Entrada', 'monthly_price' => 500.00, 'available' => true],
    ['number' => 'A2', 'location' => 'Entrada', 'monthly_price' => 500.00, 'available' => true],
    ['number' => 'B1', 'location' => 'Centro', 'monthly_price' => 600.00, 'available' => false],
    ['number' => 'B2', 'location' => 'Centro', 'monthly_price' => 600.00, 'available' => true],
    ['number' => 'C1', 'location' => 'Fundo', 'monthly_price' => 400.00, 'available' => false],
    ['number' => 'C2', 'location' => 'Fundo', 'monthly_price' => 400.00, 'available' => true],
    ['number' => 'D1', 'location' => 'Lateral', 'monthly_price' => 550.00, 'available' => true],
    ['number' => 'D2', 'location' => 'Lateral', 'monthly_price' => 550.00, 'available' => true],
];

$boxStmt = $pdo->prepare('INSERT INTO boxes (name, number, location, monthly_price, available, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())');

$boxIds = [];
foreach ($boxes as $box) {
    $boxStmt->execute([$box['number'], $box['number'], $box['location'], $box['monthly_price'], $box['available'] ? 1 : 0]);
    $boxIds[] = $pdo->lastInsertId();
    $statusDisplay = $box['available'] ? 'Disponível' : 'Ocupado';
    echo "  ✓ Box {$box['number']} - {$box['location']} - R$ {$box['monthly_price']} - {$statusDisplay}\n";
}

// ==================== HORÁRIOS ====================
echo "\n⏰ Criando horários...\n";

$schedule_vendors = [
    ['vendor_id' => $vendorIds[0], 'box_id' => $boxIds[2], 'day_of_week' => 'Segunda', 'start_time' => '06:00:00', 'end_time' => '14:00:00'],
    ['vendor_id' => $vendorIds[1], 'box_id' => $boxIds[4], 'day_of_week' => 'Terça', 'start_time' => '06:00:00', 'end_time' => '14:00:00'],
    ['vendor_id' => $vendorIds[2], 'box_id' => $boxIds[2], 'day_of_week' => 'Quarta', 'start_time' => '06:00:00', 'end_time' => '14:00:00'],
    ['vendor_id' => $vendorIds[3], 'box_id' => $boxIds[0], 'day_of_week' => 'Segunda', 'start_time' => '14:00:00', 'end_time' => '20:00:00'],
    ['vendor_id' => $vendorIds[4], 'box_id' => $boxIds[1], 'day_of_week' => 'Terça', 'start_time' => '14:00:00', 'end_time' => '20:00:00'],
];

$scheduleStmt = $pdo->prepare('INSERT INTO schedules (vendor_id, box_id, day_of_week, start_time, end_time, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())');

foreach ($schedule_vendors as $schedule) {
    $scheduleStmt->execute([$schedule['vendor_id'], $schedule['box_id'], $schedule['day_of_week'], $schedule['start_time'], $schedule['end_time']]);
    $vendorIdx = $schedule['vendor_id'] - 1;
    $boxIdx = $schedule['box_id'] - 1;
    $vendorName = isset($vendors[$vendorIdx]) ? $vendors[$vendorIdx]['name'] : 'Vendedor ' . $schedule['vendor_id'];
    $boxName = isset($boxes[$boxIdx]) ? $boxes[$boxIdx]['number'] : 'Box ' . $schedule['box_id'];
    echo "  ✓ {$vendorName} - Box {$boxName} - {$schedule['day_of_week']} ({$schedule['start_time']} - {$schedule['end_time']})\n";
}

// ==================== ENTRADAS ====================
echo "\n📝 Criando entradas (check-in)...\n";

$entries = [
    ['vendor_id' => $vendorIds[0], 'box_id' => $boxIds[2], 'entry_time' => date('Y-m-d H:i:s', strtotime('-5 hours')), 'entry_date' => date('Y-m-d'), 'exit_time' => NULL],
    ['vendor_id' => $vendorIds[1], 'box_id' => $boxIds[4], 'entry_time' => date('Y-m-d H:i:s', strtotime('-3 hours')), 'entry_date' => date('Y-m-d'), 'exit_time' => date('Y-m-d H:i:s', strtotime('-1 hours'))],
    ['vendor_id' => $vendorIds[2], 'box_id' => $boxIds[2], 'entry_time' => date('Y-m-d H:i:s', strtotime('-2 days')), 'entry_date' => date('Y-m-d', strtotime('-2 days')), 'exit_time' => date('Y-m-d H:i:s', strtotime('-2 days 8 hours'))],
];

$entryStmt = $pdo->prepare('INSERT INTO entries (vendor_id, box_id, entry_time, entry_date, exit_time, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())');

foreach ($entries as $entry) {
    $entryStmt->execute([$entry['vendor_id'], $entry['box_id'], $entry['entry_time'], $entry['entry_date'], $entry['exit_time']]);
    $vendorIdx = $entry['vendor_id'] - 1;
    $boxIdx = $entry['box_id'] - 1;
    $vendorName = isset($vendors[$vendorIdx]) ? $vendors[$vendorIdx]['name'] : 'Vendedor ' . $entry['vendor_id'];
    $boxName = isset($boxes[$boxIdx]) ? $boxes[$boxIdx]['number'] : 'Box ' . $entry['box_id'];
    $status = $entry['exit_time'] ? 'Saiu' : 'Presente';
    echo "  ✓ {$vendorName} - Box {$boxName} - {$status}\n";
}

echo "\n✅ Banco de dados populado com sucesso!\n";
echo "\n📊 Resumo:\n";
echo "  • " . count($users) . " Usuários\n";
echo "  • " . count($vendors) . " Vendedores\n";
echo "  • " . count($categories) . " Categorias\n";
echo "  • " . count($products) . " Produtos\n";
echo "  • " . count($boxes) . " Boxes\n";
echo "  • " . count($schedule_vendors) . " Horários\n";
echo "  • " . count($entries) . " Entradas\n";
