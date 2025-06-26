<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Controle - Mercado')</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            transition: transform 0.3s ease-in-out;
        }@media (max-width: 767.98px) {            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1000;
                width: 300px;
                transform: translateX(-100%);
                min-height: 100vh;
                box-shadow: 8px 0 32px rgba(0,0,0,0.2);
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
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
            }              .mobile-header {
                display: flex !important;
                background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
                padding: 1rem 1.25rem;
                margin: -15px -15px 20px -15px;
                border-radius: 0 0 1rem 1rem;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                position: sticky;
                top: 0;
                z-index: 100;
            }
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
        }
        
        @media (min-width: 768px) {
            .mobile-header {
                display: none !important;
            }
            
            .sidebar-overlay {
                display: none !important;
            }
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
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
            }
        }
    </style>
</head>
<body class="bg-light">    <div class="sidebar-overlay" id="sidebar-overlay"></div>
    
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 sidebar" id="sidebar">                <div class="position-sticky pt-3">
                    <div class="d-md-none text-end mb-3">
                        <button class="btn btn-outline-light btn-sm" id="closeSidebar">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    
                    <div class="text-center mb-4">
                        <h5 class="text-white">
                            <i class="bi bi-shop"></i>
                            {{ auth()->user()->getDashboardName() }}
                        </h5>
                        <small class="text-white-50">
                            Bem-vindo, {{ auth()->user()->name }}
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
                </div>            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">                <div class="mobile-header d-none">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <button class="hamburger-btn" id="toggleSidebar">
                            <i class="bi bi-list"></i>
                        </button>
                        <div class="mobile-brand">
                            <i class="bi bi-shop"></i>
                            Mercado N. S. Fátima
                        </div>
                        <div style="width: 40px;"></div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom page-header">
                    <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @yield('page-actions')
                    </div>
                </div>

                @yield('content')
            </main>
        </div>    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('toggleSidebar');
            const closeBtn = document.getElementById('closeSidebar');
            
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
            
            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }
            
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);            }
            
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
    
    @yield('scripts')
</body>
</html>
