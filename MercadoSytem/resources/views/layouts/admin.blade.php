<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Administração</title>    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet"><style>
        /* Variáveis CSS para Sistema de Temas */
        :root {
            --bg-primary: #1a1d23;
            --bg-secondary: #2d3748;
            --bg-tertiary: #4a5568;
            --text-primary: #f7fafc;
            --text-secondary: #e2e8f0;
            --text-muted: #a0aec0;
            --border-color: #4a5568;
            --card-bg: #2d3748;
            --sidebar-bg: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            --btn-primary: #4299e1;
            --btn-primary-hover: #3182ce;
            --accent-color: #81e6d9;
            --toast-bg: #2d3748;
            --toast-text: #e2e8f0;
        }
        
        /* Tema Claro */
        [data-theme="light"] {
            --bg-primary: #f8f9fa;
            --bg-secondary: #ffffff;
            --bg-tertiary: #e9ecef;
            --text-primary: #212529;
            --text-secondary: #495057;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
            --card-bg: #ffffff;
            --sidebar-bg: linear-gradient(135deg, #000000 0%, #2d3748 100%);
            --btn-primary: #0d6efd;
            --btn-primary-hover: #0b5ed7;
            --accent-color: #20c997;
            --toast-bg: #ffffff;
            --toast-text: #212529;
        }
          /* Estilos base com variáveis */
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
            font-family: 'Nunito', sans-serif;
        }
        
        /* Aplicar cor de texto padrão para todos os elementos */
        body,
        body * {
            color: var(--text-primary);
        }
        
        /* Exceções para elementos que devem manter cores específicas */
        .btn,
        .badge,
        .alert,
        .text-success,
        .text-danger,
        .text-warning,
        .text-info,
        .text-white {
            color: inherit;
        }
        
        .card {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
          .table {
            --bs-table-bg: var(--card-bg);
            --bs-table-color: var(--text-primary);
            --bs-table-border-color: var(--border-color);
        }        /* Correções de legibilidade para modo escuro */
        .form-control,
        .form-select {
            background-color: var(--card-bg) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }
        
        .form-control:focus,
        .form-select:focus {
            background-color: var(--card-bg) !important;
            border-color: var(--accent-color) !important;
            color: var(--text-primary) !important;
            box-shadow: 0 0 0 0.25rem rgba(129, 230, 217, 0.25) !important;
        }
        
        .form-control::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.7;
        }
        
        /* Garantir que opções do select também tenham cor correta */
        .form-select option {
            background-color: var(--card-bg) !important;
            color: var(--text-primary) !important;
        }
        
        /* Bootstrap Override - força cores no modo escuro */
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select,
        [data-theme="dark"] input,
        [data-theme="dark"] textarea,
        [data-theme="dark"] select {
            background-color: var(--card-bg) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }
        
        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus,
        [data-theme="dark"] input:focus,
        [data-theme="dark"] textarea:focus,
        [data-theme="dark"] select:focus {
            background-color: var(--card-bg) !important;
            border-color: var(--accent-color) !important;
            color: var(--text-primary) !important;
            box-shadow: 0 0 0 0.25rem rgba(129, 230, 217, 0.25) !important;
        }
        
        .form-label,
        .card-title,
        .card-text,
        h1, h2, h3, h4, h5, h6,
        p, span, div,
        .text-muted {
            color: var(--text-primary) !important;
        }
        
        .text-muted {
            color: var(--text-muted) !important;
        }
        
        .btn {
            color: white;
        }
        
        .btn-outline-secondary {
            color: var(--text-primary);
            border-color: var(--border-color);
        }
        
        .btn-outline-secondary:hover {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        /* Modal no modo escuro */
        .modal-content {
            background-color: var(--card-bg);
            color: var(--text-primary);
        }
        
        .modal-header {
            border-bottom-color: var(--border-color);
        }
        
        .modal-footer {
            border-top-color: var(--border-color);
        }
        
        /* Dropdown no modo escuro */
        .dropdown-menu {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }
        
        .dropdown-item {
            color: var(--text-primary);
        }
          .dropdown-item:hover {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
        }
        
        /* Correções adicionais para textos escuros */
        small,
        .small,
        .badge,
        .alert,
        .list-group-item,
        .nav-link,
        .breadcrumb-item,
        .pagination .page-link,
        .card-header,
        .card-footer,
        .table td,
        .table th,
        .form-text,
        .invalid-feedback,
        .valid-feedback {
            color: var(--text-primary) !important;
        }
        
        /* Inputs específicos */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="tel"],
        input[type="url"],
        input[type="search"],
        input[type="date"],
        input[type="time"],
        input[type="datetime-local"],
        textarea,
        select {
            background-color: var(--card-bg) !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }
        
        /* Correção para elementos com texto preto forçado */
        * {
            color: inherit;
        }
        
        .text-dark {
            color: var(--text-primary) !important;
        }
        
        .text-black {
            color: var(--text-primary) !important;
        }
          .fw-bold,
        .fw-semibold,
        strong,
        b {
            color: var(--text-primary) !important;
        }        /* Correções específicas para MODO ESCURO */
        [data-theme="dark"] {
            /* Força cores básicas apenas no modo escuro */
        }
        
        [data-theme="dark"] .main-content,
        [data-theme="dark"] .main-content *:not(.btn):not(.badge):not(.alert):not(.text-success):not(.text-danger):not(.text-warning):not(.text-info):not(.text-white) {
            color: var(--text-primary) !important;
        }
        
        /* Correções específicas para tabelas no modo escuro */
        [data-theme="dark"] .table,
        [data-theme="dark"] .table td,
        [data-theme="dark"] .table th,
        [data-theme="dark"] .table tbody tr,
        [data-theme="dark"] .table-hover tbody tr:hover {
            color: var(--text-primary) !important;
            background-color: transparent !important;
        }
        
        [data-theme="dark"] .table-hover tbody tr:hover {
            background-color: var(--bg-tertiary) !important;
        }
        
        /* Correções específicas para cabeçalhos de tabela no modo escuro */
        [data-theme="dark"] .table thead th,
        [data-theme="dark"] .table-light thead th,
        [data-theme="dark"] thead.table-light th,
        [data-theme="dark"] .table thead,
        [data-theme="dark"] .table-light thead {
            background-color: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }
          /* Força texto em elementos específicos da tabela */
        [data-theme="dark"] .table .fw-bold,
        [data-theme="dark"] .table .text-muted,
        [data-theme="dark"] .table small,
        [data-theme="dark"] .table .small,
        [data-theme="dark"] .table div:not(.badge):not(.btn) {
            color: var(--text-primary) !important;
        }
        
        [data-theme="dark"] .table .text-muted,
        [data-theme="dark"] .table small.text-muted {
            color: var(--text-muted) !important;
        }
        
        /* Força cor em elementos inseridos dinamicamente via JavaScript */
        [data-theme="dark"] #entriesTableBody,
        [data-theme="dark"] #entriesTableBody *:not(.btn):not(.badge) {
            color: var(--text-primary) !important;
        }
        
        [data-theme="dark"] #entriesTableBody .text-muted,
        [data-theme="dark"] #entriesTableBody small {
            color: var(--text-muted) !important;
        }
        
        [data-theme="dark"] #mobileEntriesContainer,
        [data-theme="dark"] #mobileEntriesContainer *:not(.btn):not(.badge) {
            color: var(--text-primary) !important;
        }
        
        [data-theme="dark"] #mobileEntriesContainer .text-muted {
            color: var(--text-muted) !important;
        }
        
        /* Cards mobile no modo escuro */
        [data-theme="dark"] .card-body,
        [data-theme="dark"] .card-body *:not(.btn):not(.badge) {
            color: var(--text-primary) !important;
        }
        
        [data-theme="dark"] .card-body .text-muted {
            color: var(--text-muted) !important;
        }
        
        /* Sidebar sempre mantém suas cores originais */
        .sidebar,
        .sidebar *,
        .sidebar .nav-link,
        .sidebar .text-white,
        .sidebar .text-white-50,
        .mobile-header,
        .mobile-header *,
        .mobile-brand,
        .theme-toggle,
        .theme-toggle * {
            color: inherit !important;
        }
        
        /* Exceções importantes para elementos que precisam manter suas cores */
        [data-theme="dark"] .btn,
        [data-theme="dark"] .btn *,
        [data-theme="dark"] .badge,
        [data-theme="dark"] .badge *,
        [data-theme="dark"] .alert,
        [data-theme="dark"] .alert *,
        [data-theme="dark"] .text-success,
        [data-theme="dark"] .text-danger,
        [data-theme="dark"] .text-warning,
        [data-theme="dark"] .text-info,
        [data-theme="dark"] .text-white,
        [data-theme="dark"] .text-primary,
        [data-theme="dark"] .text-secondary {
            color: inherit !important;
        }
        
        /* Correções específicas para MODO CLARO */
        [data-theme="light"] .sidebar .nav-link {
            color: rgba(255,255,255,0.8) !important;
        }
        
        [data-theme="light"] .sidebar .nav-link:hover,
        [data-theme="light"] .sidebar .nav-link.active {
            color: white !important;
        }
        
        [data-theme="light"] .sidebar .text-white {
            color: white !important;
        }
        
        [data-theme="light"] .sidebar .text-white-50 {
            color: rgba(255,255,255,0.5) !important;
        }
        
        [data-theme="light"] .mobile-brand {
            color: white !important;
        }        [data-theme="light"] .theme-toggle-text {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Correções específicas para o texto e ícone do botão de tema no modo claro */
        [data-theme="light"] .theme-toggle i {
            color: white !important;
        }
        
        [data-theme="light"] .theme-toggle-text {
            color: white !important;
        }
          /* Toggle do Tema */
        .theme-toggle {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 1rem;
            margin-top: auto;
        }
        
        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }
        
        .theme-toggle i {
            font-size: 16px;
            color: #81e6d9;
            transition: transform 0.3s ease;
        }
        
        .theme-toggle:hover i {
            transform: rotate(15deg);
        }
        
        .theme-toggle-text {
            font-size: 11px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
          .sidebar {
            min-height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
        }
        
        .sidebar .position-sticky {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar .nav {
            flex: 1;
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
            background: var(--toast-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
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
            color: var(--toast-text);
            margin: 0;
            font-size: 16px;
            flex: 1;
        }
        
        .toast-body-modern {
            padding: 0 20px 16px;
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.5;
        }
        
        .toast-close {
            background: none;
            border: none;
            color: var(--text-muted);
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
            background: var(--bg-tertiary);
            color: var(--text-primary);
            transform: scale(1.1);
        }
        
        .toast-close:active {
            transform: scale(0.95);
        }
          @media (max-width: 480px) {
            .toast-container {
                left: 50%;
                right: auto;
                top: 20px;
                max-width: 90vw;
                width: 90vw;
                transform: translateX(-50%);
                z-index: 1055;
            }
            
            .modern-toast {
                margin: 0 auto 10px auto;
                width: 100%;
                transform: translateY(-20px);
                opacity: 0;
            }
            
            .modern-toast.show {
                transform: translateY(0);
                opacity: 1;
            }
            
            .modern-toast.hide {
                transform: translateY(-20px);
                opacity: 0;
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
                    
                    <!-- Toggle do Tema -->
                    <div class="theme-toggle" id="themeToggle">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                        <span class="theme-toggle-text" id="themeText">Escuro</span>
                    </div>
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
    </div>    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sistema de Tema Escuro/Claro
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const themeText = document.getElementById('themeText');
            const body = document.body;
            
            // Verificar tema salvo ou usar escuro como padrão
            const savedTheme = localStorage.getItem('theme') || 'dark';
            setTheme(savedTheme);
            
            // Toggle do tema
            themeToggle.addEventListener('click', () => {
                const currentTheme = body.getAttribute('data-theme') || 'dark';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                setTheme(newTheme);
                localStorage.setItem('theme', newTheme);
            });
            
            function setTheme(theme) {
                body.setAttribute('data-theme', theme);
                
                if (theme === 'light') {
                    themeIcon.className = 'bi bi-sun-fill';
                    themeText.textContent = 'Claro';
                } else {
                    themeIcon.className = 'bi bi-moon-fill';
                    themeText.textContent = 'Escuro';
                }
            }
        });
        
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
