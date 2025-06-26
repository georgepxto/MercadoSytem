<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Mercado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">    <style>
        body {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }        .login-header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .login-body {
            padding: 2rem;
        }        .btn-primary {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
        }
        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
            border: 2px solid #e9ecef;
        }        .form-control:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
        }.user-type-tabs {
            display: none;
        }
        .user-type-tab {
            flex: 1;
            text-align: center;
            padding: 12px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            background: transparent;
        }        .user-type-tab.active {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-store fa-3x mb-3"></i>
            <h2>Sistema de Mercado</h2>
            <p class="mb-0">Faça login para acessar o sistema</p>
        </div>
        
        <div class="login-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0" style="border-radius: 25px 0 0 25px; border-color: #e9ecef;">
                            <i class="fas fa-envelope text-muted"></i>
                        </span>
                        <input type="email" class="form-control border-start-0" name="email" 
                               value="{{ old('email') }}" required autocomplete="email" autofocus
                               placeholder="Seu e-mail" style="border-radius: 0 25px 25px 0;">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0" style="border-radius: 25px 0 0 25px; border-color: #e9ecef;">
                            <i class="fas fa-lock text-muted"></i>
                        </span>
                        <input type="password" class="form-control border-start-0" name="password" 
                               required autocomplete="current-password"
                               placeholder="Sua senha" style="border-radius: 0 25px 25px 0;">
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Lembrar de mim
                    </label>
                </div>                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Converter alerts Bootstrap em notificações modernas
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-danger');
            alerts.forEach(alert => {
                const message = alert.textContent.trim();
                if (message) {
                    // Remover alert Bootstrap
                    alert.style.display = 'none';
                    
                    // Criar notificação moderna
                    setTimeout(() => {
                        showModernToast(message, 'error', 'Erro de Login');
                    }, 100);
                }
            });
        });
        
        // Sistema de notificação simples para páginas de login
        function showModernToast(message, type = 'info', title = 'Aviso') {
            const container = document.getElementById('toastContainer') || createToastContainer();
            
            const toastId = 'toast_' + Date.now();
            const icons = {
                success: '✓',
                error: '✕',
                warning: '⚠',
                info: 'ⓘ'
            };
            
            const colors = {
                success: '#22c55e',
                error: '#ef4444',
                warning: '#f59e0b',
                info: '#3b82f6'
            };
            
            const toastHtml = `
                <div class="modern-toast ${type}" id="${toastId}" style="
                    background: white;
                    border: none;
                    border-radius: 12px;
                    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
                    margin-bottom: 16px;
                    overflow: hidden;
                    border-left: 4px solid ${colors[type]};
                    transform: translateX(400px);
                    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                    opacity: 0;
                    position: relative;
                ">
                    <div style="padding: 16px 20px 8px; display: flex; align-items: center; gap: 12px;">
                        <div style="
                            width: 24px; height: 24px; border-radius: 50%; 
                            display: flex; align-items: center; justify-content: center; 
                            font-size: 14px; color: white; font-weight: bold;
                            background: ${colors[type]};
                        ">${icons[type]}</div>
                        <h6 style="font-weight: 600; color: #1f2937; margin: 0; font-size: 16px;">${title}</h6>
                        <button onclick="hideToast('${toastId}')" style="
                            position: absolute; top: 12px; right: 12px; background: none; 
                            border: none; color: #9ca3af; cursor: pointer; padding: 4px; 
                            border-radius: 4px; transition: all 0.2s;
                        ">✕</button>
                    </div>
                    <div style="padding: 0 20px 16px; color: #6b7280; font-size: 14px; line-height: 1.5;">
                        ${message}
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', toastHtml);
            const toastElement = document.getElementById(toastId);
            
            // Animar entrada
            setTimeout(() => {
                toastElement.style.transform = 'translateX(0)';
                toastElement.style.opacity = '1';
            }, 100);
            
            // Auto-remover após 6 segundos
            setTimeout(() => {
                hideToast(toastId);
            }, 6000);
        }
        
        function hideToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.style.transform = 'translateX(400px)';
                toast.style.opacity = '0';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 400);
            }
        }
        
        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                max-width: 400px;
                width: 100%;
            `;
            document.body.appendChild(container);
            return container;
        }
    </script>
</body>
</html>
