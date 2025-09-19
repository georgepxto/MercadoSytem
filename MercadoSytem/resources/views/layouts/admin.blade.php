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
        /* Variáveis CSS para Tema Escuro */
        :root {
            --bg-primary: #1a1d23;
            --bg-secondary: #2d3748;
            --bg-tertiary: #4a5568;
            --text-primary: #f7fafc;
            --text-secondary: #e2e8f0;
            --text-muted: #a0aec0;
            --border-color: #4a5568;
            --card-bg: #2d3748;
            --sidebar-bg: #1a1a1a;
            --btn-primary: #4299e1;
            --btn-primary-hover: #3182ce;
            --accent-color: #81e6d9;
            --toast-bg: #2d3748;
            --toast-text: #e2e8f0;
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
          /* Sidebar sempre mantém suas cores originais no modo escuro */
        [data-theme="dark"] .sidebar,
        [data-theme="dark"] .sidebar *,
        [data-theme="dark"] .sidebar .nav-link,
        [data-theme="dark"] .sidebar .text-white,
        [data-theme="dark"] .sidebar .text-white-50,
        [data-theme="dark"] .mobile-header,
        [data-theme="dark"] .mobile-header *,
        [data-theme="dark"] .mobile-brand,
        [data-theme="dark"] .theme-toggle,
        [data-theme="dark"] .theme-toggle * {
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
        
        .sidebar {
            width: 280px; /* Largura fixa da sidebar - aumentada */
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden; /* Evita overflow horizontal */
            z-index: 1000;
        }
        
        /* Estilos do cabeçalho da sidebar no desktop */
        .sidebar .text-center {
            display: block;
            text-align: center;
            padding: 1.5rem 1rem;
            margin-bottom: 1rem;
        }
        
        .sidebar .text-center i {
            display: block;
            margin-bottom: 0.75rem;
            color: white;
            font-size: 3rem;
        }
        
        .sidebar .text-center h4 {
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }
        
        .sidebar .text-center small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
            display: block;
            line-height: 1.2;
        }
          .sidebar .position-sticky {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Contenção de overflow */
            height: 100%; /* Garantir altura completa */
            min-height: 100vh; /* Altura mínima do viewport */
        }
        
        .sidebar .nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden; /* Evita overflow horizontal */
            padding-bottom: 1rem; /* Espaçamento inferior */
        }
          /* Ajustar margem do conteúdo principal para compensar sidebar fixa */
        .main-content {
            margin-left: 280px; /* Mesma largura da sidebar */
            height: 100vh;
            overflow-y: auto;
            padding: 0 1.5rem; /* Adicionar padding interno */
        }        /* Mobile Header */
        .mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: var(--sidebar-bg);
            z-index: 1000; /* Z-index menor que a sidebar */
            align-items: center;
            padding: 0 1rem;
            border-bottom: 1px solid var(--border-color);
            border-radius: 0 !important;
        }
        
        .mobile-brand {
            color: white;
            font-size: 1.2rem;
            font-weight: 600;
            text-decoration: none;
            margin-left: 0.5rem;
        }        .hamburger-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            padding: 0.5rem;
            cursor: pointer;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
          /* Remove hover effect on mobile devices */
        @media (hover: hover) and (pointer: fine) {
            .hamburger-btn:hover {
                background: rgba(255, 255, 255, 0.1);
            }
        }.hamburger-btn i {
            transition: none;
            transform-origin: center;
        }
          /* Animação do hamburger quando sidebar está aberta */
        .mobile-header .hamburger-btn.active i {
            transform: rotate(90deg);
        }        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1001; /* Entre o header e a sidebar */
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94), 
                       visibility 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }
        
        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }        /* Mobile Styles */
        @media (max-width: 768px) {
            .mobile-header {
                display: flex;
            }              .sidebar {
                transform: translateX(-100%) !important;
                transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important, 
                           box-shadow 0.4s ease !important;
                z-index: 1002 !important; /* Z-index mais alto - acima do overlay e header */
                box-shadow: -10px 0 30px rgba(0, 0, 0, 0);
                will-change: transform;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                width: 280px !important;
                height: 100vh !important;
                height: 100dvh !important; /* Altura dinâmica do viewport */
                min-height: 100vh !important;
                max-height: 100vh !important;
                backface-visibility: hidden;
                -webkit-backface-visibility: hidden;
                transform-style: preserve-3d;
                -webkit-transform-style: preserve-3d;
            }
            
            .sidebar.show {
                transform: translateX(0) !important;
                box-shadow: 10px 0 40px rgba(0, 0, 0, 0.4);
            }
            
            /* Remove Bootstrap collapse behavior on mobile */
            .sidebar.collapse {
                display: block !important;
                visibility: visible !important;
            }
            
            .sidebar.collapse.show {
                display: block !important;
            }
              /* Animação dos itens da sidebar */
            .sidebar .nav-item {
                opacity: 0;
                transform: translateX(-20px);
                transition: opacity 0.3s ease, transform 0.3s ease;
                transition-delay: 0.1s;
            }
            
            .sidebar.show .nav-item {
                opacity: 1;
                transform: translateX(0);
            }
            
            .sidebar .nav-item:nth-child(1) { transition-delay: 0.15s; }
            .sidebar .nav-item:nth-child(2) { transition-delay: 0.2s; }
            .sidebar .nav-item:nth-child(3) { transition-delay: 0.25s; }
            .sidebar .nav-item:nth-child(4) { transition-delay: 0.3s; }
            
            /* Animação do cabeçalho da sidebar no mobile */
            .sidebar .text-center {
                opacity: 0;
                transform: translateY(-20px);
                transition: opacity 0.4s ease, transform 0.4s ease;
                transition-delay: 0.05s;
            }
            
            .sidebar.show .text-center {
                opacity: 1;
                transform: translateY(0);
            }/* Mostrar cabeçalho da sidebar no mobile com estilos otimizados */
            .sidebar .text-center {
                display: block !important;
                text-align: center !important;
                padding: 1rem 1rem 1.5rem 1rem !important;
                margin-bottom: 1rem !important;
                margin-top: 0 !important;
            }
            
            .sidebar .text-center i {
                display: block !important;
                margin-bottom: 0.75rem !important;
                color: white !important;
                font-size: 2.5rem !important;
            }
            
            .sidebar .text-center h4 {
                color: white !important;
                font-size: 1.1rem !important;
                font-weight: 600 !important;
                margin-bottom: 0.5rem !important;
                line-height: 1.3 !important;
            }
            
            .sidebar .text-center small {
                color: rgba(255, 255, 255, 0.7) !important;
                font-size: 0.8rem !important;
                display: block !important;
                line-height: 1.2 !important;
            }
            
            /* Garantir altura completa da sidebar no mobile */
            .sidebar .position-sticky {
                height: 100vh !important;
                height: 100dvh !important; /* Altura dinâmica do viewport */
                min-height: 100vh !important;
                position: relative !important;
                top: auto !important;
                padding-top: 1rem !important;
                padding-bottom: 0 !important;
            }
            
            /* Ajustar distribuição do espaço na sidebar mobile */
            .sidebar .nav {
                flex: 1 !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: flex-start !important;
                padding-top: 0.5rem !important;
                padding-bottom: 0.5rem !important;
            }
            
            /* Animação do botão de tema */
            .sidebar .theme-toggle {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.4s ease, transform 0.4s ease;
                transition-delay: 0.3s;
            }
            
            .sidebar.show .theme-toggle {
                opacity: 1;
                transform: translateY(0);
            }
            
            .sidebar.show .theme-toggle {
                opacity: 1;
                transform: translateY(0);
            }
            
            .main-content {
                margin-left: 0;
                padding-top: 60px; /* Account for mobile header */
            }            .sidebar-overlay {
                display: block;
            }
            
            /* Ensure all sidebar text is visible on mobile */
            .sidebar .text-white,
            .sidebar .text-white-50 {
                display: block !important;
                visibility: visible !important;
                color: white !important;
            }
        }.sidebar .nav-item .nav-link {
            color: rgba(255,255,255,.8);
            padding: 1rem;
            border-radius: 0.35rem;
            margin: 0.25rem 0.5rem; /* Ajustar margem para evitar overflow */
            overflow: hidden; /* Evita que o hover ultrapasse os limites */
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            display: flex;
            align-items: center;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
            position: relative;
        }
        
        /* Efeito de slide nos links */
        .sidebar .nav-item .nav-link::before {
            content: '';
            position: absolute;
            left: -100%;
            top: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .sidebar .nav-item .nav-link:hover::before {
            left: 100%;
        }
          /* Espaçamento entre ícones e texto na sidebar admin */
        .sidebar .nav-item .nav-link i {
            margin-right: 0.75rem; /* Espaçamento adequado entre ícone e texto */
            width: 20px; /* Largura fixa para alinhamento consistente */
            text-align: center; /* Centralizar ícones */
            flex-shrink: 0; /* Impedir que o ícone encolha */
            transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .sidebar .nav-item .nav-link:hover i {
            transform: translateX(3px) scale(1.1);
        }
        
        .sidebar .nav-item .nav-link.active i {
            transform: scale(1.1);
        }
        
        .sidebar .nav-item .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,.1);
            transform: none; /* Remove qualquer transform que cause overflow */
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

<body data-theme="dark">
      <!-- Container para Notificações Modernas -->
    <div class="toast-container" id="toastContainer"></div>
    
    <!-- Mobile Header -->
    <div class="mobile-header">
        <button class="hamburger-btn" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <a href="{{ route('admin.dashboard') }}" class="mobile-brand">
            <i class="fas fa-user-shield me-2"></i>
            Admin Painel
        </a>
    </div>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="container-fluid">
        <div class="row">            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar" id="sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-shield fa-3x text-white mb-2"></i>
                        <h4 class="text-white">{{ auth('dashboard_manager')->user()->name }}</h4>
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
            </nav>            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title')</h1>
                </div>

                @yield('content')
            </main>
        </div>
    </div>    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
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
            
            // Método para confirmação
            confirm(message, title = 'Confirmação', onConfirm = null, onCancel = null) {
                const modalId = 'confirmModal_' + Date.now();
                
                const modalHtml = `
                    <div class="modal fade" id="${modalId}" tabindex="-1" data-bs-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">${title}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>${message}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="${modalId}_cancel">Cancelar</button>
                                    <button type="button" class="btn btn-danger" id="${modalId}_confirm">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Adicionar modal ao body
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                const modalElement = document.getElementById(modalId);
                const modal = new bootstrap.Modal(modalElement);
                
                // Event listeners
                document.getElementById(modalId + '_confirm').addEventListener('click', () => {
                    modal.hide();
                    if (onConfirm) onConfirm();
                });
                
                document.getElementById(modalId + '_cancel').addEventListener('click', () => {
                    modal.hide();
                    if (onCancel) onCancel();
                });
                
                // Remover modal do DOM quando fechado
                modalElement.addEventListener('hidden.bs.modal', () => {
                    modalElement.remove();
                });
                
                modal.show();
                return modalId;
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
            });            // Mobile Sidebar Controls
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            if (sidebarToggle && sidebar && sidebarOverlay) {
                // Toggle sidebar on button click
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const isCurrentlyOpen = sidebar.classList.contains('show');
                    
                    if (isCurrentlyOpen) {
                        // Closing sidebar
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    } else {
                        // Opening sidebar
                        // Force a reflow to ensure starting position is set
                        sidebar.offsetHeight;
                        
                        // Add classes with a tiny delay to ensure animation is visible
                        requestAnimationFrame(() => {
                            sidebar.classList.add('show');
                            sidebarOverlay.classList.add('show');
                        });
                    }
                });
                
                // Close sidebar when clicking overlay
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
                
                // Close sidebar on window resize if moving to desktop
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 768) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    }
                });
                
                // Close sidebar when clicking on navigation links on mobile
                const navLinks = sidebar.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth <= 768) {
                            sidebar.classList.remove('show');
                            sidebarOverlay.classList.remove('show');
                        }
                    });
                });
                
                // Prevent sidebar from closing when clicking inside it
                sidebar.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }});
    </script>

    @yield('scripts')
</body>
</html>
