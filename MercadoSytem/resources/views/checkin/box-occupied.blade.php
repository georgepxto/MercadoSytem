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
            background: #1a1d23;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 1rem;
        }
        
        .occupied-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(26, 29, 35, 0.3);
            padding: 2rem;
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        
        /* ===== MELHORIAS MOBILE ===== */
        @media (max-width: 576px) {
            body {
                padding: 0.5rem;
                align-items: flex-start;
                padding-top: 2rem;
            }
            
            .occupied-card {
                padding: 1.5rem;
                border-radius: 16px;
                margin: 0;
                min-height: auto;
                max-width: 100%;
            }
            
            .occupied-icon {
                width: 80px;
                height: 80px;
                font-size: 2.5rem;
                margin-bottom: 1.5rem;
            }
            
            h2 {
                font-size: 1.3rem !important;
                margin-bottom: 0.75rem !important;
                line-height: 1.3;
            }
            
            .status-badge {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
                margin-bottom: 0.75rem;
            }
            
            .info-card {
                padding: 1rem;
                margin: 1.5rem 0;
                border-radius: 8px;
            }
            
            .info-row {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 0.75rem;
                gap: 0.25rem;
            }
            
            .info-label {
                font-size: 0.85rem;
                font-weight: 600;
            }
            
            .info-value {
                font-size: 0.9rem;
                font-weight: 600;
            }
            
            .alert-danger {
                padding: 0.75rem;
                font-size: 0.9rem;
                margin: 1rem 0;
                border-radius: 8px;
            }
            
            .btn-primary {
                width: 100%;
                padding: 0.75rem;
                font-size: 0.9rem;
                border-radius: 12px;
                margin-top: 1rem;
            }
            
            .text-muted.small {
                font-size: 0.8rem;
            }
        }
        
        /* Ajustes para telas muito pequenas */
        @media (max-width: 375px) {
            .occupied-card {
                padding: 1rem;
                border-radius: 12px;
            }
            
            .occupied-icon {
                width: 70px;
                height: 70px;
                font-size: 2rem;
            }
            
            h2 {
                font-size: 1.2rem;
            }
            
            .info-card {
                padding: 0.75rem;
            }
        }
        
        .occupied-icon {
            background: #dc3545;
            color: white;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 3rem;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }
        
        .info-card {
            background: rgba(248, 249, 250, 0.9);
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
            color: #6c757d;
        }
        
        .info-value {
            color: #2c3e50;
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
            color: #dc3545 !important;
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
        
        /* Garantir cores corretas em todos os dispositivos */
        .occupied-card {
            color: #2c3e50 !important;
        }
        
        .occupied-card .text-muted {
            color: #6c757d !important;
        }
        
        .occupied-card .alert-danger {
            color: #721c24 !important;
            background: #f8d7da !important;
        }
        
        .occupied-card .info-card {
            background: rgba(248, 249, 250, 0.9) !important;
            color: #2c3e50 !important;
        }
        
        .occupied-card .info-card .info-label {
            color: #6c757d !important;
        }
        
        .occupied-card .info-card .info-value {
            color: #2c3e50 !important;
        }
        
        /* Regras adicionais para garantir as cores */
        div.occupied-card div.info-card span.info-label {
            color: #6c757d !important;
            font-weight: 600 !important;
        }
        
        div.occupied-card div.info-card span.info-value {
            color: #2c3e50 !important;
            font-weight: 600 !important;
        }
        
        /* Sobrescrever qualquer estilo Bootstrap */
        .info-card span {
            color: inherit !important;
        }
        
        .info-card .info-label {
            color: #6c757d !important;
        }
        
        .info-card .info-value {
            color: #2c3e50 !important;
        }
        
        /* Reset completo para info-card */
        .info-card * {
            color: inherit !important;
        }
        
        .info-card {
            color: #2c3e50 !important;
        }
        
        /* Forçar cores específicas com máxima especificidade */
        body .occupied-card .info-card .info-label,
        body .occupied-card .info-card span.info-label {
            color: #6c757d !important;
        }
        
        body .occupied-card .info-card .info-value,
        body .occupied-card .info-card span.info-value {
            color: #2c3e50 !important;
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