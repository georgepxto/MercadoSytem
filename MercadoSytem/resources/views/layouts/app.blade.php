<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Controle - Mercado')</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">    <style>
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
            --sidebar-bg: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
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
        }
          /* Aplicar cor de texto padrão apenas para elementos principais */
        body {
            color: var(--text-primary);
        }
        
        /* Aplicar cores de tema apenas onde necessário */
        .main-content h1,
        .main-content h2,
        .main-content h3,
        .main-content h4,
        .main-content h5,
        .main-content h6,
        .main-content p,
        .main-content span:not(.badge),
        .main-content div:not(.btn):not(.badge):not(.alert),
        .card-title,
        .card-text {
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
          /* Correções específicas para formulários */
        .form-label,
        .form-text {
            color: var(--text-primary) !important;
        }
        
        /* Textos mutados mantêm sua cor específica */
        .text-muted {
            color: var(--text-muted) !important;
        }
        
        /* Elementos com cores específicas do Bootstrap */
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
        
        .page-header h1 {
            color: var(--text-primary) !important;
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
          /* Correções adicionais para elementos específicos */
        .card-header,
        .card-footer {
            color: var(--text-primary);
        }
        
        .table td,
        .table th {
            color: var(--text-primary);
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
          /* Correção para elementos específicos */
        .text-dark {
            color: var(--text-primary) !important;
        }
        
        .text-black {
            color: var(--text-primary) !important;
        }
        
        /* Elementos em negrito mantêm a cor do tema */
        .fw-bold,
        .fw-semibold,
        strong,
        b {
            color: inherit;
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
        [data-theme="dark"] #entriesTableBody *:not(.btn):not(.badge):not(.bg-primary):not(.rounded-circle) {
            color: var(--text-primary) !important;
        }
        
        [data-theme="dark"] #entriesTableBody .text-muted,
        [data-theme="dark"] #entriesTableBody small {
            color: var(--text-muted) !important;
        }
        
        /* Elementos de histórico inseridos dinamicamente */
        [data-theme="dark"] #entriesTableBody tr,
        [data-theme="dark"] #entriesTableBody td,
        [data-theme="dark"] #entriesTableBody div:not(.badge):not(.btn):not(.bg-primary) {
            color: var(--text-primary) !important;
        }
        
        [data-theme="dark"] #mobileEntriesContainer,
        [data-theme="dark"] #mobileEntriesContainer *:not(.btn):not(.badge):not(.bg-primary):not(.rounded-circle) {
            color: var(--text-primary) !important;
        }
        
        [data-theme="dark"] #mobileEntriesContainer .text-muted {
            color: var(--text-muted) !important;
        }
        
        /* Cards de histórico mobile específicos */
        [data-theme="dark"] #mobileEntriesContainer .card,
        [data-theme="dark"] #mobileEntriesContainer .card-body,
        [data-theme="dark"] #mobileEntriesContainer .card-body div:not(.badge):not(.btn):not(.bg-primary),
        [data-theme="dark"] #mobileEntriesContainer h6,
        [data-theme="dark"] #mobileEntriesContainer .fw-bold,
        [data-theme="dark"] #mobileEntriesContainer .fw-semibold {
            color: var(--text-primary) !important;
        }
          /* Elementos de paginação e contadores */
        [data-theme="dark"] .pagination,
        [data-theme="dark"] .pagination *,
        [data-theme="dark"] #totalRecords {
            color: var(--text-primary) !important;
        }
        
        /* Correção específica para badge de contador no modo escuro */
        [data-theme="dark"] .badge.bg-light {
            background-color: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }
          [data-theme="dark"] .badge.text-dark {
            color: var(--text-primary) !important;
        }
        
        /* Paginação do Laravel no modo escuro */
        [data-theme="dark"] .pagination .page-link {
            background-color: var(--card-bg) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }
        
        [data-theme="dark"] .pagination .page-link:hover {
            background-color: var(--bg-secondary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }
        
        [data-theme="dark"] .pagination .page-item.active .page-link {
            background-color: var(--btn-primary) !important;
            border-color: var(--btn-primary) !important;
            color: white !important;
        }
        
        [data-theme="dark"] .pagination .page-item.disabled .page-link {
            background-color: var(--bg-tertiary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-muted) !important;
        }
          /* Cards mobile no modo escuro */
        [data-theme="dark"] .card-body,
        [data-theme="dark"] .card-body *:not(.btn):not(.badge):not(.bg-primary):not(.rounded-circle) {
            color: var(--text-primary) !important;
        }
        
        [data-theme="dark"] .card-body .text-muted {
            color: var(--text-muted) !important;
        }
        
        /* Elementos críticos para legibilidade no histórico */
        [data-theme="dark"] .table-responsive table,
        [data-theme="dark"] .table-responsive table *:not(.btn):not(.badge):not(.bg-primary):not(.bg-secondary):not(.bg-success):not(.bg-warning):not(.bg-danger):not(.bg-info) {
            color: var(--text-primary) !important;
        }
        
        /* Força texto visível em todos os elementos do card no modo escuro */
        [data-theme="dark"] .card .fw-bold,
        [data-theme="dark"] .card .fw-semibold,
        [data-theme="dark"] .card h1, [data-theme="dark"] .card h2, [data-theme="dark"] .card h3,
        [data-theme="dark"] .card h4, [data-theme="dark"] .card h5, [data-theme="dark"] .card h6,
        [data-theme="dark"] .card p, [data-theme="dark"] .card span:not(.badge),
        [data-theme="dark"] .card div:not(.btn):not(.badge):not(.bg-primary):not(.bg-secondary):not(.bg-success):not(.bg-warning):not(.bg-danger):not(.bg-info) {
            color: var(--text-primary) !important;
        }
        
        /* Correção específica para textos mutados no modo escuro */
        [data-theme="dark"] .text-muted,
        [data-theme="dark"] small.text-muted,
        [data-theme="dark"] .small.text-muted {
            color: var(--text-muted) !important;
        }
        
        /* Garantir que avatares circulares mantenham sua cor de fundo */
        [data-theme="dark"] .bg-primary.rounded-circle {
            background-color: #0d6efd !important;
            color: white !important;
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
        }

        /* Correções específicas para elementos mobile no modo claro */
        [data-theme="light"] .hamburger-btn {
            background: rgba(255,255,255,0.2) !important;
            border: 1px solid rgba(255,255,255,0.3) !important;
            color: white !important;
        }
        
        [data-theme="light"] .hamburger-btn:hover,
        [data-theme="light"] .hamburger-btn:focus {
            background: rgba(255,255,255,0.3) !important;
            border-color: rgba(255,255,255,0.5) !important;
            color: white !important;
        }
        
        [data-theme="light"] .hamburger-btn i {
            color: white !important;
        }
        
        [data-theme="light"] .mobile-brand i {
            color: white !important;
        }        [data-theme="light"] .theme-toggle-text {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* === CORREÇÕES ESPECÍFICAS PARA MODO CLARO RESPONSIVO === */
        /* Garantir que elementos mobile sejam sempre visíveis no modo claro */
        [data-theme="light"] .mobile-header .mobile-brand,
        [data-theme="light"] .mobile-header .mobile-brand * {
            color: white !important;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;
        }
        
        [data-theme="light"] .mobile-header .hamburger-btn,
        [data-theme="light"] .mobile-header .hamburger-btn * {
            color: white !important;
            background: rgba(255,255,255,0.2) !important;
            border-color: rgba(255,255,255,0.3) !important;
        }
        
        [data-theme="light"] .mobile-header .hamburger-btn:hover,
        [data-theme="light"] .mobile-header .hamburger-btn:focus {
            background: rgba(255,255,255,0.3) !important;
            border-color: rgba(255,255,255,0.5) !important;
            color: white !important;
        }
        
        /* Correções específicas para o texto e ícone do botão de tema no modo claro */
        [data-theme="light"] .theme-toggle i {
            color: white !important;
        }
        
        [data-theme="light"] .theme-toggle-text {
            color: white !important;
        }
        
        /* Correções específicas para CARDS DE ESTATÍSTICAS no modo claro */
        [data-theme="light"] .card.bg-primary .text-white-75,
        [data-theme="light"] .card.bg-success .text-white-75,
        [data-theme="light"] .card.bg-warning .text-white-75,
        [data-theme="light"] .card.bg-info .text-white-75 {
            color: rgba(255, 255, 255, 0.75) !important;
        }
        
        [data-theme="light"] .card.bg-primary .fs-2,
        [data-theme="light"] .card.bg-success .fs-2,
        [data-theme="light"] .card.bg-warning .fs-2,
        [data-theme="light"] .card.bg-info .fs-2 {
            color: white !important;
        }
        
        /* Correções para elementos da tabela no modo claro */
        [data-theme="light"] .table .badge.bg-secondary {
            background-color: #6c757d !important;
            color: white !important;
        }
        
        [data-theme="light"] .table .badge.bg-success {
            background-color: #198754 !important;
            color: white !important;
        }
        
        [data-theme="light"] .table .text-muted,
        [data-theme="light"] .card-body .text-muted,
        [data-theme="light"] small.text-muted {
            color: #6c757d !important;
        }
          [data-theme="light"] .fw-bold,
        [data-theme="light"] .fw-semibold {
            color: #212529 !important;
        }
        
        /* Resetar regras agressivas do modo escuro para o modo claro */
        [data-theme="light"] .main-content,
        [data-theme="light"] .main-content * {
            color: inherit !important;
        }
        
        /* Aplicar cores corretas no modo claro */
        [data-theme="light"] .card-body,
        [data-theme="light"] .table,
        [data-theme="light"] .table td,
        [data-theme="light"] .table th {
            color: #212529 !important;
        }
          [data-theme="light"] .card.text-white * {
            color: white !important;
        }
        
        /* Correção específica para avatares circulares no modo claro */
        [data-theme="light"] .bg-primary.rounded-circle,
        [data-theme="light"] .bg-primary.rounded-circle * {
            background-color: #0d6efd !important;
            color: white !important;
        }
          /* Cabeçalhos de tabela no modo claro */
        [data-theme="light"] .table thead th,
        [data-theme="light"] .table-light thead th,
        [data-theme="light"] thead.table-light th {
            background-color: #f8f9fa !important;
            color: #212529 !important;
            border-color: #dee2e6 !important;
        }
        
        /* Correções específicas para página de Check-in no modo claro */
        [data-theme="light"] .card-header.bg-success h5,
        [data-theme="light"] .card-header.bg-success i,
        [data-theme="light"] .card-header.bg-primary h5,
        [data-theme="light"] .card-header.bg-primary i,
        [data-theme="light"] .card-header.bg-info h5,
        [data-theme="light"] .card-header.bg-info i {
            color: white !important;
        }
        
        /* Labels e ícones dos formulários no modo claro */
        [data-theme="light"] .form-label,
        [data-theme="light"] .form-label i,
        [data-theme="light"] .fw-semibold {
            color: #212529 !important;
        }
        
        /* Botões no modo claro */
        [data-theme="light"] .btn-success,
        [data-theme="light"] .btn-success i {
            background-color: #198754 !important;
            color: white !important;
        }
        
        /* Elementos dinâmicos inseridos via JavaScript no modo claro */
        [data-theme="light"] #activeVendors .fw-bold,
        [data-theme="light"] #recentEntries strong,
        [data-theme="light"] #recentEntries td {
            color: #212529 !important;
        }
        
        [data-theme="light"] #activeVendors .text-muted,
        [data-theme="light"] #recentEntries .text-muted,
        [data-theme="light"] #activeVendors small,
        [data-theme="light"] #recentEntries small {
            color: #6c757d !important;
        }
          /* Ícones de estado vazio no modo claro */
        [data-theme="light"] .bi.text-muted {
            color: #6c757d !important;
        }
          /* Correções específicas para badges na página de vendedores no modo claro */
        [data-theme="light"] .badge.bg-info {
            background-color: #0e7490 !important;
            color: white !important;
        }
        
        [data-theme="light"] .badge.bg-success {
            background-color: #198754 !important;
            color: white !important;
        }
        
        [data-theme="light"] .badge.bg-secondary {
            background-color: #6c757d !important;
            color: white !important;
        }
        
        /* Botões primários no modo claro */
        [data-theme="light"] .btn-primary,
        [data-theme="light"] .btn-primary i {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            color: white !important;
        }
        
        [data-theme="light"] .btn-primary:hover {
            background-color: #0b5ed7 !important;
            border-color: #0a58ca !important;
            color: white !important;
        }
        
        /* Botões secundários e outros no modo claro */
        [data-theme="light"] .btn-secondary,
        [data-theme="light"] .btn-secondary i {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            color: white !important;
        }
        
        [data-theme="light"] .btn-success,
        [data-theme="light"] .btn-success i {
            background-color: #198754 !important;
            border-color: #198754 !important;
            color: white !important;
        }
        
        /* Modal e seus elementos no modo claro */
        [data-theme="light"] .modal-content {
            background-color: #ffffff !important;
            color: #212529 !important;
        }
        
        [data-theme="light"] .modal-header,
        [data-theme="light"] .modal-body,
        [data-theme="light"] .modal-footer {
            color: #212529 !important;
        }
          [data-theme="light"] .modal-title {
            color: #212529 !important;
        }
          /* Correção para botão outline-light no modo claro */
        [data-theme="light"] .btn-outline-light {
            border-color: white !important;
            color: white !important;
            background-color: transparent !important;
        }
        
        [data-theme="light"] .btn-outline-light:hover {
            background-color: white !important;
            border-color: white !important;
            color: #007bff !important;
        }
        
        [data-theme="light"] .btn-outline-light i {
            color: inherit !important;
        }
        
        /* Texto dentro dos cards de vendedores no modo claro */
        [data-theme="light"] .card-title {
            color: #212529 !important;
        }
        
        [data-theme="light"] .text-muted {
            color: #6c757d !important;
        }
        
        /* Horários dos vendedores no modo claro */
        [data-theme="light"] .bg-light {
            background-color: #f8f9fa !important;
            color: #212529 !important;
        }
        
        [data-theme="light"] .fw-semibold {
            color: #212529 !important;
        }        /* Toggle do Tema */
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
            margin: 1rem 0.5rem; /* Ajustar margem para evitar overflow */
            margin-top: auto;
            max-width: calc(100% - 1rem); /* Limitar largura máxima */
        }
        
        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            transform: none; /* Remover transform que pode causar overflow */
        }
        
        .theme-toggle i {
            font-size: 16px;
            color: #81e6d9;
            transition: transform 0.3s ease;
            flex-shrink: 0; /* Impede que o ícone encolha */
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
            white-space: nowrap; /* Evita quebra de linha */
        }.sidebar {
            width: 280px; /* Largura fixa da sidebar - aumentada */
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--sidebar-bg);
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden; /* Evita overflow horizontal */
            z-index: 1000;
        }
        
        .sidebar .position-sticky {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden; /* Contenção de overflow */
        }
        
        .sidebar .nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden; /* Evita overflow horizontal */
        }
        
        /* Ajustar margem do conteúdo principal para compensar sidebar fixa */
        .main-content {
            margin-left: 280px; /* Mesma largura da sidebar */
            height: 100vh;
            overflow-y: auto;
            padding: 0 1.5rem; /* Adicionar padding interno */
        }@media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1000;
                width: 300px;
                height: 100vh;
                transform: translateX(-100%);
                box-shadow: 8px 0 32px rgba(0,0,0,0.2);
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                overflow-y: auto;
            }
              .sidebar.show {
                transform: translateX(0);
                box-shadow: 12px 0 48px rgba(0,0,0,0.3);
            }
              .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(45deg, rgba(0, 0, 0, 0.7), rgba(44, 62, 80, 0.3));
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
            }
            
            .sidebar-overlay.show {
                opacity: 1;
                visibility: visible;
            }
            
            .main-content {
                margin-left: 0 !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
                width: 100% !important;
                height: 100vh !important;
                overflow-y: auto !important;
            }            .mobile-header {
                display: flex !important;
                background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
                padding: 1rem 1.25rem;
                margin: -15px -15px 20px -15px;
                border-radius: 0 !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                position: sticky;
                top: 0;
                z-index: 100;
            }
        }
          @media (min-width: 768px) {
            .mobile-header {
                display: none !important;
            }
            
            .sidebar-overlay {
                display: none !important;
            }
        }
        
        /* Estilos para elementos mobile */
        .hamburger-btn {
            background: rgba(255,255,255,0.2) !important;
            border: 1px solid rgba(255,255,255,0.3) !important;
            color: white !important;
            width: 40px;
            height: 40px;
            border-radius: 8px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .hamburger-btn:hover,
        .hamburger-btn:focus {
            background: rgba(255,255,255,0.3) !important;
            border-color: rgba(255,255,255,0.5) !important;
            transform: scale(1.05);
        }
        
        .hamburger-btn i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }
        
        .mobile-brand {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
        }
        
        .mobile-brand i {
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }
        
        @media (max-width: 767.98px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 1rem;
                margin-top: -10px;
            }
            
            .page-header h1 {
                font-size: 1.75rem !important;
                font-weight: 700;
                color: #2d3748;
            }
        }        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            margin: 0.25rem 0.5rem; /* Adicionar margem lateral para espaçamento */
            border-radius: 0.5rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            text-decoration: none;
            position: relative;
            overflow: hidden; /* Evita que o hover ultrapasse os limites */
        }
        
        /* Espaçamento entre ícones e texto na sidebar */
        .sidebar .nav-link i {
            margin-right: 0.75rem; /* Espaçamento adequado entre ícone e texto */
            width: 20px; /* Largura fixa para alinhamento consistente */
            text-align: center; /* Centralizar ícones */
            flex-shrink: 0; /* Impedir que o ícone encolha */
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            transform: none; /* Remove qualquer transform que cause overflow */
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1rem;
        }
        .btn {
            border-radius: 0.5rem;
        }        .navbar-brand {
            font-weight: bold;
        }
        
        @media (max-width: 575.98px) {
            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .btn-group {
                display: flex;
                flex-direction: column;
                width: 100%;
            }
            
            .btn-group .btn {
                border-radius: 0.5rem !important;
                margin-bottom: 0.25rem;
            }
            
            .card-body {
                padding: 1rem 0.75rem;
            }
            
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .modal-dialog {
                margin: 0.5rem;
            }        }
        
        @media (max-width: 767.98px) {
            .dashboard-cards .col-xl-3 {
                margin-bottom: 1rem;
            }
            
            .vendor-card {
                margin-bottom: 1rem;
            }        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .form-row .form-group {
            flex: 1;
            min-width: 250px;
        }
        
        @media (max-width: 575.98px) {
            .form-row .form-group {
                min-width: 100%;
            }        }

        @media (max-width: 575.98px) {
            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }
            
            .page-header h1 {
                font-size: 1.5rem;
            }
            
            .card {
                border-radius: 0.75rem;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            
            .card-header {
                padding: 0.75rem 1rem;
            }
              .form-control, .form-select {
                font-size: 16px;
                min-height: 44px;
            }
            
            .btn {
                min-height: 44px;
                padding: 0.75rem 1rem;
            }
            
            .btn-sm {
                min-height: 38px;
                padding: 0.5rem 0.75rem;
            }
            
            .modal-content {
                border-radius: 1rem 1rem 0 0;
                margin-top: auto;
            }
            
            .modal-dialog {
                height: 100vh;
                margin: 0;
                display: flex;
                align-items: flex-end;
            }
              .modal-body {
                max-height: 70vh;
                overflow-y: auto;
            }
            
            .table-responsive {
                border-radius: 0.5rem;
                overflow: hidden;            }
            
            .row.g-3 .card {
                height: 100%;            }
            
            .badge {
                font-size: 0.75rem;
                padding: 0.4em 0.65em;            }
            
            .text-truncate {
                max-width: 100%;            }
            
            .sidebar .nav-link {
                padding: 1rem 1.5rem;
                font-size: 1rem;
                border-radius: 0.5rem;
                margin: 0.25rem 0.5rem;
            }
            
            .sidebar .nav-link i {
                width: 24px;
                text-align: center;
            }        }
        
        @media (prefers-reduced-motion: no-preference) {
            .sidebar {
                transition: transform 0.3s ease-in-out;
            }
            
            .sidebar-overlay {
                transition: opacity 0.3s ease-in-out;
            }
            
            .card {
                transition: box-shadow 0.2s ease-in-out;
            }
            
            .card:hover {
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }        }
        
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
        
        .text-info {
            color: #0e7490 !important;
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
        
        @media (prefers-reduced-motion: no-preference) {    </style>
</head>
<body>
    <!-- Aplicar tema antes do carregamento da página -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.body.setAttribute('data-theme', savedTheme);
        })();
    </script>
    
    <!-- Container para Notificações Modernas -->
    <div class="toast-container" id="toastContainer"></div>
      <div class="sidebar-overlay" id="sidebar-overlay"></div>
    
    <nav class="col-md-3 col-lg-2 sidebar" id="sidebar">        <div class="position-sticky pt-3">
            <div class="text-center mb-4">
                <h5 class="text-white">
                    <i class="bi bi-shop"></i>
                    {{ auth()->user()->getDashboardName() }}
                </h5>
                <small class="text-white-50">
                    Bem-vindo, {{ auth()->user()->getDashboardName() }}
                </small>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('checkin') ? 'active' : '' }}" href="{{ route('checkin') }}">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Check-in/Check-out
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vendors') ? 'active' : '' }}" href="{{ route('vendors') }}">
                        <i class="bi bi-people"></i>
                        Vendedores
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('boxes') ? 'active' : '' }}" href="{{ route('boxes') }}">
                        <i class="bi bi-grid-3x3"></i>
                        Boxes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('entries') ? 'active' : '' }}" href="{{ route('entries') }}">
                        <i class="bi bi-clock-history"></i>
                        Histórico
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-start w-100 border-0" 
                                style="color: rgba(255,255,255,.8); background: none;">
                            <i class="bi bi-box-arrow-right"></i>
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

    <main class="main-content">
        <div class="mobile-header d-none">
            <div class="d-flex justify-content-between align-items-center w-100">
                <button class="hamburger-btn" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <div class="mobile-brand">
                    <i class="bi bi-shop"></i>
                    {{ auth()->user()->getDashboardName() }}
                </div>
                <div style="width: 40px;"></div>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom page-header">
                <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    @yield('page-actions')
                </div>
            </div>

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>    <script>
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
            
            // Sistema de Sidebar
            const sidebar = document.getElementById('sidebar');            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('toggleSidebar');
            
            function openSidebar() {
                sidebar.classList.add('show');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
            
            function closeSidebar() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
              if (toggleBtn) {
                toggleBtn.addEventListener('click', openSidebar);
            }
            
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }
            
            const navLinks = sidebar.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 768) {
                        closeSidebar();
                    }
                });            });
            
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    closeSidebar();
                }
            });
        });
    </script>
    
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
                const toastTitle = title || toastConfig.defaultTitle;                // Criar HTML da notificação
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
            
            hideAll() {
                this.toasts.forEach(toast => {
                    this.hide(toast.id);
                });
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
            
            confirm(message, title = 'Confirmação', onConfirm = null, onCancel = null) {
                return new Promise((resolve, reject) => {
                    const modalId = 'confirmModal_' + Date.now();
                    const modal = document.createElement('div');
                    modal.id = modalId;
                    modal.className = 'modal fade';
                    modal.setAttribute('tabindex', '-1');
                    modal.setAttribute('aria-hidden', 'true');
                    
                    modal.innerHTML = `
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">${title}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-0">${message}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-danger" id="confirmBtn_${modalId}">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(modal);
                    
                    const bootstrapModal = new bootstrap.Modal(modal);
                    const confirmBtn = document.getElementById(`confirmBtn_${modalId}`);
                    
                    confirmBtn.addEventListener('click', () => {
                        bootstrapModal.hide();
                        if (onConfirm) onConfirm();
                        resolve(true);
                    });
                    
                    modal.addEventListener('hidden.bs.modal', () => {
                        if (!modal.dataset.confirmed) {
                            if (onCancel) onCancel();
                            resolve(false);
                        }
                        document.body.removeChild(modal);
                    });
                    
                    confirmBtn.addEventListener('click', () => {
                        modal.dataset.confirmed = 'true';
                    });
                    
                    bootstrapModal.show();
                });
            }
        }
        
        // Inicializar sistema de notificações
        window.modernToast = new ModernToast();
        
        // Função global para compatibilidade com alerts antigos
        window.showToast = function(message, type = 'info', title = null) {
            return window.modernToast.show(message, type, title);
        };
        
        // Substituir alert global (opcional - pode ser removido se causar problemas)
        window.originalAlert = window.alert;
        window.alert = function(message) {
            window.modernToast.info(message, 'Aviso');
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
    
    @yield('scripts')
</body>
</html>
