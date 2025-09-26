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
        }
        
        .checkin-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            width: 100%;
            max-width: 400px;
            text-align: center;
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