<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-in - {{ $box->name }}</title>
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
        
        .checkin-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        
        /* ===== MELHORIAS MOBILE ===== */
        @media (max-width: 576px) {
            body {
                padding: 0.5rem;
                align-items: flex-start;
                padding-top: 2rem;
            }
            
            .checkin-card {
                padding: 1.5rem;
                border-radius: 16px;
                margin: 0;
                max-width: 100%;
                min-height: auto;
            }
            
            .box-icon {
                width: 70px !important;
                height: 70px !important;
                font-size: 1.8rem !important;
                margin-bottom: 1.25rem !important;
            }
            
            h1 {
                font-size: 1.4rem !important;
                margin-bottom: 0.5rem !important;
                line-height: 1.3;
            }
            
            .text-muted {
                font-size: 0.9rem !important;
                margin-bottom: 1.5rem !important;
                line-height: 1.4;
            }
            
            .form-control {
                padding: 0.875rem 1rem !important;
                font-size: 1rem !important;
                border-radius: 10px !important;
                border-width: 1px !important;
            }
            
            .form-label {
                font-size: 0.9rem;
                font-weight: 500;
                margin-bottom: 0.5rem;
                text-align: left;
                display: block;
            }
            
            .btn-checkin {
                padding: 0.875rem 1.5rem !important;
                font-size: 1rem !important;
                border-radius: 10px !important;
                margin-top: 0.5rem;
            }
            
            .alert {
                padding: 0.75rem !important;
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
                border-radius: 10px !important;
                text-align: left;
            }
            
            .mb-4 {
                margin-bottom: 1.5rem !important;
            }
            
            .mt-4 {
                margin-top: 1.5rem !important;
            }
            
            .mt-4 small {
                font-size: 0.8rem !important;
                line-height: 1.4;
            }
        }
        
        /* Ajustes para telas muito pequenas */
        @media (max-width: 375px) {
            .checkin-card {
                padding: 1.25rem;
                border-radius: 12px;
            }
            
            .box-icon {
                width: 60px !important;
                height: 60px !important;
                font-size: 1.5rem !important;
            }
            
            h1 {
                font-size: 1.3rem !important;
            }
            
            .form-control {
                font-size: 16px !important; /* Previne zoom no iOS */
            }
        }
        
        /* Melhorar foco em dispositivos touch */
        @media (max-width: 576px) {
            .form-control:focus {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(45, 55, 72, 0.15) !important;
            }
            
            .btn-checkin:active {
                transform: translateY(0) !important;
            }
        }
        
        .box-icon {
            background: #2d3748;
            color: white;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }
        
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #2d3748;
            box-shadow: 0 0 0 0.2rem rgba(45, 55, 72, 0.25);
        }
        
        .btn-checkin {
            background: #2d3748;
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-checkin:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(45, 55, 72, 0.5);
            color: white;
            background: #4a5568;
        }
        
        .alert {
            border-radius: 12px;
            border: none;
        }
        
        h1 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .text-muted {
            color: #6c757d !important;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="checkin-card">
        <div class="box-icon">
            <i class="bi bi-box-seam"></i>
        </div>
            
            <h1>{{ $box->name }}</h1>
            <p class="text-muted">Box {{ $box->number }} - {{ $box->location }}</p>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong><i class="bi bi-exclamation-triangle me-2"></i>Erro!</strong>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="{{ route('checkin.process', $box->number) }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope me-2"></i>Email do Vendedor
                    </label>
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           placeholder="seu@email.com"
                           value="{{ old('email') }}"
                           required 
                           autofocus>
                </div>
                
                <button type="submit" class="btn btn-checkin">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Realizar Check-in
                </button>
            </form>
            
            <div class="mt-4">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Se você já fez check-in hoje, este botão registrará sua saída.
                </small>
            </div>
        </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>