<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Box em Uso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .occupied-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        
        .occupied-icon {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 3rem;
            animation: shake 0.6s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }
        
        .info-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-left: 4px solid #dc3545;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: left;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .info-row:last-child {
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        
        .info-value {
            color: #212529;
        }
        
        .btn-primary {
            background: #007bff;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }
        
        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            border-radius: 10px;
            margin: 1rem 0;
        }
        
        h2 {
            color: #dc3545;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .status-badge {
            background: #dc3545;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="occupied-card">
        <div class="occupied-icon">
            <i class="bi bi-person-fill-x"></i>
        </div>
        
        <div class="status-badge">Box Ocupado</div>
        
        <h2>{{ $message }}</h2>
        
        <div class="alert alert-danger">
            <i class="bi bi-clock me-2"></i>
            <strong>Em uso desde:</strong> {{ date('H:i', strtotime($occupyingEntry->entry_time)) }}
        </div>
        
        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Box Solicitado:</span>
                <span class="info-value">{{ $box->name }} (Box {{ $box->number }})</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">Ocupado</span>
            </div>
            <div class="info-row">
                <span class="info-label">Em uso desde:</span>
                <span class="info-value">{{ date('H:i', strtotime($occupyingEntry->entry_time)) }}</span>
            </div>
        </div>
        
        <div class="mt-4">
            <p class="text-muted small mb-0">
                <i class="bi bi-hourglass-split me-1"></i>
                Aguarde o box ficar disponível.
            </p>
        </div>
    </div>
</body>
</html>