<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-in Não Permitido</title>
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
        
        .error-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(26, 29, 35, 0.3);
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        
        /* ===== MELHORIAS MOBILE ===== */
        @media (max-width: 576px) {
            body {
                padding: 0.5rem;
                align-items: flex-start;
                padding-top: 2rem;
            }
            
            .error-card {
                padding: 1.5rem;
                border-radius: 16px;
                margin: 0;
                max-width: 100%;
                min-height: auto;
            }
            
            .error-icon {
                width: 80px !important;
                height: 80px !important;
                font-size: 2.5rem !important;
                margin-bottom: 1.5rem !important;
            }
            
            h2 {
                font-size: 1.3rem !important;
                margin-bottom: 0.75rem !important;
                line-height: 1.3;
            }
            
            .text-muted {
                font-size: 0.9rem !important;
                margin-bottom: 1.5rem !important;
                line-height: 1.4;
            }
            
            .alert-warning {
                padding: 0.75rem !important;
                font-size: 0.9rem;
                margin: 1rem 0 !important;
                border-radius: 8px !important;
                text-align: left;
            }
            
            .info-card {
                padding: 1rem !important;
                margin: 1.5rem 0 !important;
                border-radius: 8px;
                text-align: left;
            }
            
            .info-row {
                flex-direction: column;
                align-items: flex-start !important;
                margin-bottom: 0.75rem !important;
                gap: 0.25rem;
            }
            
            .info-label {
                font-size: 0.85rem;
                font-weight: 500;
            }
            
            .info-value {
                font-size: 0.9rem;
                font-weight: 600;
            }
            
            .btn-primary {
                width: 100%;
                padding: 0.875rem 1.5rem !important;
                font-size: 0.9rem !important;
                border-radius: 12px !important;
                margin-top: 0.5rem;
                text-transform: none !important;
                letter-spacing: normal !important;
            }
            
            .mt-4 {
                margin-top: 1.5rem !important;
            }
            
            .mt-4 .text-muted.small {
                font-size: 0.8rem !important;
                margin-bottom: 1rem !important;
                line-height: 1.4;
            }
        }
        
        /* Ajustes para telas muito pequenas */
        @media (max-width: 375px) {
            .error-card {
                padding: 1.25rem;
                border-radius: 12px;
            }
            
            .error-icon {
                width: 70px !important;
                height: 70px !important;
                font-size: 2rem !important;
            }
            
            h2 {
                font-size: 1.2rem !important;
            }
            
            .info-card {
                padding: 0.875rem !important;
            }
            
            .alert-warning {
                padding: 0.625rem !important;
                font-size: 0.85rem !important;
            }
        }
        
        /* Melhorar animação para mobile */
        @media (max-width: 576px) {
            .error-icon {
                animation: shake 0.5s ease-in-out;
            }
            
            .btn-primary:active {
                transform: translateY(0) !important;
            }
        }
        
        .error-icon {
            background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
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
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .info-card {
            background: #2d3748;
            border: 1px solid #4a5568;
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
            color: #a0aec0;
        }
        
        .info-value {
            color: #e2e8f0;
        }
        
        .btn-primary {
            background: #dc3545;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        .alert-warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            border-radius: 10px;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        
        <h2 class="mb-3 text-danger">Check-in Não Permitido</h2>
        <p class="text-muted mb-4">{{ $message }}</p>
        
        <div class="alert alert-warning">
            <i class="bi bi-info-circle me-2"></i>
            <strong>Box Atual Ativo:</strong> {{ $activeBox->name }} (Box {{ $activeBox->number }})
        </div>
        
        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Fornecedor:</span>
                <span class="info-value">{{ $vendor->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $vendor->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Box Tentado:</span>
                <span class="info-value">{{ $box->name }} (Box {{ $box->number }})</span>
            </div>
            <div class="info-row">
                <span class="info-label">Box Ativo:</span>
                <span class="info-value">{{ $activeBox->name }} (Box {{ $activeBox->number }})</span>
            </div>
            <div class="info-row">
                <span class="info-label">Entrada Ativa:</span>
                <span class="info-value">{{ date('H:i', strtotime($activeEntry->entry_time)) }}</span>
            </div>
        </div>
        
        <div class="mt-4">
            <p class="text-muted small mb-3">
                Para fazer check-in neste box, você precisa primeiro realizar o check-out no box ativo.
            </p>
            
            <a href="{{ route('checkin.form', $activeBox->number) }}" class="btn btn-primary">
                <i class="bi bi-box-arrow-right me-2"></i>
                Ir para Check-out
            </a>
        </div>
    </div>
</body>
</html>