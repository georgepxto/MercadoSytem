<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Administração</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }        .sidebar {
            min-height: 100vh;
            background: #000000;
        }
        .sidebar .nav-item .nav-link {
            color: rgba(255,255,255,.8);
            padding: 1rem;
            border-radius: 0.35rem;
            margin: 0.25rem 1rem;
        }
        .sidebar .nav-item .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,.1);
        }
        .sidebar .nav-item .nav-link.active {
            color: #fff;
            background-color: rgba(255,255,255,.2);
        }
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
        .text-primary {
            color: #4e73df !important;
        }
        .text-success {
            color: #1cc88a !important;
        }
        .text-warning {
            color: #f6c23e !important;
        }        .text-info {
            color: #0e7490 !important; /* Cyan mais escuro */
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        
        /* Customização da cor info para melhor legibilidade */
        .bg-info {
            background-color: #0e7490 !important; /* Cyan mais escuro */
        }
        
        .badge.bg-info {
            background-color: #0e7490 !important;
        }
        
        .btn-info {
            background-color: #0e7490 !important;
            border-color: #0e7490 !important;
        }
        
        .btn-info:hover {
            background-color: #0c647c !important;
            border-color: #0c647c !important;
        }
        
        /* Sistema de Notificações Modernas */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
            width: 100%;
        }
        
        .modern-toast {
            background: white;
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            margin-bottom: 16px;
            overflow: hidden;
            border-left: 4px solid;
            backdrop-filter: blur(10px);
            transform: translateX(400px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            opacity: 0;
        }
        
        .modern-toast.show {
            transform: translateX(0);
            opacity: 1;
        }
        
        .modern-toast.hide {
            transform: translateX(400px);
            opacity: 0;
        }
        
        .modern-toast.success {
            border-left-color: #22c55e;
        }
        
        .modern-toast.error {
            border-left-color: #ef4444;
        }
        
        .modern-toast.warning {
            border-left-color: #f59e0b;
        }
          .modern-toast.info {
            border-left-color: #0e7490;
        }
          .toast-header-modern {
            background: transparent;
            border: none;
            padding: 16px 20px 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }
        
        .toast-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: white;
            font-weight: bold;
        }
        
        .toast-icon.success {
            background: #22c55e;
        }
        
        .toast-icon.error {
            background: #ef4444;
        }
        
        .toast-icon.warning {
            background: #f59e0b;
        }
          .toast-icon.info {
            background: #0e7490;
        }
        
        .toast-title {
            font-weight: 600;
            color: #1f2937;
            margin: 0;
            font-size: 16px;
            flex: 1;
        }
        
        .toast-body-modern {
            padding: 0 20px 16px;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .toast-close {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            transition: all 0.2s;
            font-size: 18px;
            line-height: 1;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
        }
        
        .toast-close:hover {
            background: #f3f4f6;
            color: #374151;
            transform: scale(1.1);
        }
        
        .toast-close:active {
            transform: scale(0.95);
        }
        
        @media (max-width: 480px) {
            .toast-container {
                left: 20px;
                right: 20px;
                top: 20px;
                max-width: none;
            }
            
            .modern-toast {
                transform: translateY(-100px);
            }
            
            .modern-toast.show {
                transform: translateY(0);
            }
            
            .modern-toast.hide {
                transform: translateY(-100px);
            }
        }
    </style>
</head>

<body>
    <!-- Container para Notificações Modernas -->
    <div class="toast-container" id="toastContainer"></div>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-shield fa-3x text-white mb-2"></i>
                        <h4 class="text-white">Admin Panel</h4>
                        <small class="text-white-50">{{ auth('dashboard_manager')->user()->name }}</small>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
                               href="{{ route('admin.users') }}">
                                <i class="fas fa-users me-2"></i>
                                Gerenciar Usuários
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-start w-100" 
                                        style="color: rgba(255,255,255,.8); text-decoration: none;">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title')</h1>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sistema de Notificações Modernas
        class ModernToast {
            constructor() {
                this.container = document.getElementById('toastContainer');
                this.toasts = [];
            }
            
            show(message, type = 'info', title = null, duration = 3000) {
                const toastId = 'toast_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                
                // Definir ícones e títulos padrão
                const config = {
                    success: {
                        icon: '✓',
                        defaultTitle: 'Sucesso!'
                    },
                    error: {
                        icon: '✕',
                        defaultTitle: 'Erro!'
                    },
                    warning: {
                        icon: '⚠',
                        defaultTitle: 'Atenção!'
                    },
                    info: {
                        icon: 'ⓘ',
                        defaultTitle: 'Informação'
                    }
                };
                
                const toastConfig = config[type] || config.info;
                const toastTitle = title || toastConfig.defaultTitle;
                  // Criar HTML da notificação
                const toastHtml = `
                    <div class="modern-toast ${type}" id="${toastId}">
                        <div class="toast-header-modern">
                            <div class="toast-icon ${type}">${toastConfig.icon}</div>
                            <h6 class="toast-title">${toastTitle}</h6>
                            <button class="toast-close" data-toast-id="${toastId}" aria-label="Fechar notificação">
                                <i class="bi bi-x" style="font-size: 20px;"></i>
                                <span style="display: none;">×</span>
                            </button>
                        </div>
                        <div class="toast-body-modern">${message}</div>
                    </div>
                `;
                
                // Adicionar ao container
                this.container.insertAdjacentHTML('beforeend', toastHtml);
                const toastElement = document.getElementById(toastId);
                
                // Verificar se o ícone Bootstrap carregou, senão usar texto
                const closeButton = toastElement.querySelector('.toast-close');
                const icon = closeButton.querySelector('i');
                const fallbackText = closeButton.querySelector('span');
                
                // Fallback se Bootstrap Icons não carregou
                setTimeout(() => {
                    if (window.getComputedStyle(icon).fontFamily.indexOf('bootstrap-icons') === -1) {
                        icon.style.display = 'none';
                        fallbackText.style.display = 'inline';
                        fallbackText.style.fontSize = '20px';
                        fallbackText.style.fontWeight = 'bold';
                    }
                }, 100);
                
                // Adicionar evento de clique para o botão de fechar
                closeButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    this.hide(toastId);
                });
                
                // Adicionar à lista de toasts ativos
                this.toasts.push({
                    id: toastId,
                    element: toastElement,
                    timeout: null
                });
                
                // Animar entrada
                setTimeout(() => {
                    toastElement.classList.add('show');
                }, 100);
                
                // Auto-remover se duration > 0
                if (duration > 0) {
                    const toastData = this.toasts.find(t => t.id === toastId);
                    toastData.timeout = setTimeout(() => {
                        this.hide(toastId);
                    }, duration);
                }
                
                return toastId;
            }
            
            hide(toastId) {
                const toastIndex = this.toasts.findIndex(t => t.id === toastId);
                if (toastIndex === -1) return;
                
                const toastData = this.toasts[toastIndex];
                const toastElement = toastData.element;
                
                // Limpar timeout se existir
                if (toastData.timeout) {
                    clearTimeout(toastData.timeout);
                }
                
                // Animar saída
                toastElement.classList.add('hide');
                toastElement.classList.remove('show');
                
                // Remover do DOM após animação
                setTimeout(() => {
                    if (toastElement && toastElement.parentNode) {
                        toastElement.parentNode.removeChild(toastElement);
                    }
                }, 400);
                
                // Remover da lista
                this.toasts.splice(toastIndex, 1);
            }
              // Métodos de conveniência
            success(message, title = null, duration = 3000) {
                return this.show(message, 'success', title, duration);
            }
            
            error(message, title = null, duration = 3000) {
                return this.show(message, 'error', title, duration);
            }
            
            warning(message, title = null, duration = 3000) {
                return this.show(message, 'warning', title, duration);
            }
            
            info(message, title = null, duration = 3000) {
                return this.show(message, 'info', title, duration);
            }
        }
        
        // Inicializar sistema de notificações
        window.modernToast = new ModernToast();
        
        // Função global para compatibilidade
        window.showToast = function(message, type = 'info', title = null) {
            return window.modernToast.show(message, type, title);
        };
        
        // Processar mensagens flash do Laravel
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                window.modernToast.success('{{ session('success') }}');
            @endif
            
            @if(session('error'))
                window.modernToast.error('{{ session('error') }}');
            @endif
            
            @if(session('warning'))
                window.modernToast.warning('{{ session('warning') }}');
            @endif
            
            @if(session('info'))
                window.modernToast.info('{{ session('info') }}');
            @endif
            
            // Converter alerts Bootstrap existentes
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const message = alert.textContent.trim();
                if (message && !alert.dataset.converted) {
                    alert.dataset.converted = 'true';
                    alert.style.display = 'none';
                    
                    let type = 'info';
                    if (alert.classList.contains('alert-success')) type = 'success';
                    else if (alert.classList.contains('alert-danger')) type = 'error';
                    else if (alert.classList.contains('alert-warning')) type = 'warning';
                    
                    setTimeout(() => {
                        window.modernToast.show(message, type);
                    }, 100);
                }
            });
        });
    </script>
</body>
</html>
