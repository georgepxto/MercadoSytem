<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $action == 'checkin' ? 'Check-in Realizado' : 'Check-out Realizado' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: {{ $action == 'checkin' ? 'linear-gradient(135deg, #28a745 0%, #20c997 100%)' : 'linear-gradient(135deg, #fd7e14 0%, #e83e8c 100%)' }};
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .success-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        
        .success-icon {
            background: {{ $action == 'checkin' ? 'linear-gradient(135deg, #28a745 0%, #20c997 100%)' : 'linear-gradient(135deg, #fd7e14 0%, #e83e8c 100%)' }};
            color: white;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 3rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .info-card {
            background: rgba(248, 249, 250, 0.8);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem 0;
            border-left: 4px solid {{ $action == 'checkin' ? '#28a745' : '#fd7e14' }};
        }
        
        .btn-return {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-return:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(108, 117, 125, 0.3);
            color: white;
            text-decoration: none;
        }
        
        h1 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .status-badge {
            background: {{ $action == 'checkin' ? '#28a745' : '#fd7e14' }};
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-card">
            <div class="success-icon">
                @if($action == 'checkin')
                    <i class="bi bi-box-arrow-in-right"></i>
                @else
                    <i class="bi bi-box-arrow-right"></i>
                @endif
            </div>
            
            <div class="status-badge mb-3">
                {{ $action == 'checkin' ? 'Check-in Realizado' : 'Check-out Realizado' }}
            </div>
            
            <h1>Sucesso!</h1>
            
            <div class="info-card">
                <div class="row mb-2">
                    <div class="col-4 text-muted"><strong>Vendedor:</strong></div>
                    <div class="col-8">{{ $vendor->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 text-muted"><strong>Box:</strong></div>
                    <div class="col-8">{{ $box->name }} ({{ $box->number }})</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 text-muted"><strong>Data:</strong></div>
                    <div class="col-8">{{ \Carbon\Carbon::parse($entry->entry_date)->format('d/m/Y') }}</div>
                </div>
                @if($action == 'checkin')
                    <div class="row mb-2">
                        <div class="col-4 text-muted"><strong>Entrada:</strong></div>
                        <div class="col-8">{{ \Carbon\Carbon::parse($entry->entry_time)->format('H:i') }}</div>
                    </div>
                @else
                    <div class="row mb-2">
                        <div class="col-4 text-muted"><strong>Entrada:</strong></div>
                        <div class="col-8">{{ \Carbon\Carbon::parse($entry->entry_time)->format('H:i') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-muted"><strong>Saída:</strong></div>
                        <div class="col-8">{{ \Carbon\Carbon::parse($entry->exit_time)->format('H:i') }}</div>
                    </div>
                @endif
            </div>
            
            <a href="{{ route('checkin.form', $box->number) }}" class="btn-return">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar ao Check-in
            </a>
            
            <div class="mt-4">
                <small class="text-muted">
                    <i class="bi bi-clock me-1"></i>
                    Registrado em {{ now()->format('d/m/Y H:i:s') }}
                </small>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>