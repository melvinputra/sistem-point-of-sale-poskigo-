<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'POSKigo Kasir')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-green: #9FE869;
            --primary-light: #C4FF57;
            --dark-green: #5a8e2a;
            --text-dark: #1a1a1a;
            --text-muted: #6a6a6a;
            --bg-light: #f8f9fa;
            --sidebar-width: 280px;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            color: var(--text-dark);
        }

        /* Navbar Modern */
        .sb-topnav {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: 70px;
            background: #ffffff !important;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            z-index: 1039;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            transition: left 0.3s ease;
        }

        .navbar-brand-modern {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            padding: 0;
            margin: 0;
        }

        .sb-topnav .navbar-nav {
            margin-left: auto;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.6rem 1.2rem;
            background: rgba(196, 255, 87, 0.1);
            border-radius: 12px;
            color: var(--text-dark);
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .user-dropdown:hover {
            background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(196, 255, 87, 0.3);
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--text-dark);
        }

        /* Sidebar Modern */
        #layoutSidenav {
            display: flex;
        }

        #layoutSidenav_nav {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1a1a1a 0%, #2a2a2a 100%);
            z-index: 1040;
            transition: transform 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }

        #layoutSidenav_nav::-webkit-scrollbar {
            width: 6px;
        }

        #layoutSidenav_nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        #layoutSidenav_nav::-webkit-scrollbar-thumb {
            background: rgba(196, 255, 87, 0.3);
            border-radius: 3px;
        }

        #layoutSidenav_content {
            margin-left: var(--sidebar-width);
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            width: calc(100% - var(--sidebar-width));
            transition: margin-left 0.3s ease;
        }

        /* Sidebar Brand */
        .sidebar-brand {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .sidebar-brand-text {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
        }

        .sidebar-brand-subtitle {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 500;
            margin-top: 0.3rem;
        }

        /* Sidebar Navigation */
        .sb-sidenav-menu {
            padding: 1rem 0;
        }

        .sb-sidenav-menu-heading {
            padding: 1rem 1.5rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.4);
        }

        .sb-sidenav-menu .nav-link {
            display: flex;
            align-items: center;
            padding: 0.9rem 1.5rem;
            margin: 0.3rem 1rem;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .sb-sidenav-menu .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .sb-sidenav-menu .nav-link:hover,
        .sb-sidenav-menu .nav-link.active {
            background: rgba(196, 255, 87, 0.1);
            color: #C4FF57;
            transform: translateX(5px);
        }

        .sb-sidenav-menu .nav-link:hover::before,
        .sb-sidenav-menu .nav-link.active::before {
            transform: scaleY(1);
        }

        .sb-nav-link-icon {
            margin-right: 1rem;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .badge-notification {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
            color: white;
            padding: 0.25rem 0.6rem;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-left: auto;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Toggle Sidebar */
        .sb-sidenav-toggled #layoutSidenav_nav {
            transform: translateX(-100%);
        }

        .sb-sidenav-toggled #layoutSidenav_content {
            margin-left: 0;
            width: 100%;
        }

        .sb-sidenav-toggled .sb-topnav {
            left: 0;
        }

        #sidebarToggle {
            background: rgba(196, 255, 87, 0.1);
            border: none;
            color: var(--text-dark);
            padding: 0.6rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        #sidebarToggle:hover {
            background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            transform: rotate(90deg);
        }

        /* Main Content */
        main {
            padding: 2rem;
            min-height: calc(100vh - 140px);
        }

        .container-fluid {
            max-width: 1400px;
        }

        /* Footer Modern */
        footer {
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
            padding: 1.5rem 2rem;
            margin-top: auto;
        }

        footer .text-muted {
            color: var(--text-muted) !important;
            font-size: 0.9rem;
        }

        /* Alerts Modern */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(196, 255, 87, 0.15) 0%, rgba(159, 232, 105, 0.1) 100%);
            color: var(--dark-green);
            border-left: 4px solid #9FE869;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.15) 0%, rgba(255, 82, 82, 0.1) 100%);
            color: #c62828;
            border-left: 4px solid #ff5252;
        }

        /* Dropdown Modern */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            padding: 0.5rem;
            margin-top: 0.5rem;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.7rem 1rem;
            transition: all 0.3s ease;
            color: var(--text-dark);
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(196, 255, 87, 0.15) 0%, rgba(159, 232, 105, 0.1) 100%);
            color: var(--dark-green);
            transform: translateX(5px);
        }

        .dropdown-item i {
            margin-right: 0.7rem;
            width: 20px;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 992px) {
            :root {
                --sidebar-width: 0;
            }

            #layoutSidenav_nav {
                transform: translateX(-100%);
            }

            #layoutSidenav_content {
                margin-left: 0;
                width: 100%;
            }

            .sb-topnav {
                left: 0;
            }

            .sb-sidenav-toggled #layoutSidenav_nav {
                transform: translateX(0);
            }

            main {
                padding: 1rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav" id="sidenavAccordion">
                <!-- Sidebar Brand -->
                <div class="sidebar-brand">
                    <span class="sidebar-brand-text">POSKigo</span>
                    <div class="sidebar-brand-subtitle">Sistem Kasir Modern</div>
                </div>

                <!-- Sidebar Menu -->
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu Utama</div>
                        <a class="nav-link {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}" href="{{ route('kasir.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Transaksi</div>
                        <a class="nav-link {{ request()->routeIs('kasir.sales.create') ? 'active' : '' }}" href="{{ route('kasir.sales.create') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                            Transaksi Baru
                        </a>
                        <a class="nav-link {{ request()->routeIs('kasir.sales.index') || request()->routeIs('kasir.sales.show') ? 'active' : '' }}" href="{{ route('kasir.sales.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>
                            Riwayat Transaksi
                        </a>
                        <a class="nav-link {{ request()->routeIs('kasir.online-orders') ? 'active' : '' }}" href="{{ route('kasir.online-orders') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-bag"></i></div>
                            Pesanan Online
                            @php
                                $pendingCount = \App\Models\Sale::where('order_type', 'online')->where('order_status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge-notification">{{ $pendingCount }}</span>
                            @endif
                        </a>

                        
                    </div>
                </div>
            </nav>
        </div>

        <!-- Top Navigation -->
        <nav class="sb-topnav navbar navbar-expand">
            <button class="btn" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <button class="user-dropdown dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span>{{ auth()->user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('kasir.dashboard') }}">
                                <i class="fas fa-user"></i> Profil Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider" style="margin: 0.5rem 0; opacity: 0.1;"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <footer>
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-muted">
                            <i class="fas fa-copyright me-1"></i>
                            {{ date('Y') }} POSKigo - Sistem Kasir Modern
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                });
            }

            // Display Laravel session messages
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif
            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif
            @if(session('warning'))
                toastr.warning("{{ session('warning') }}");
            @endif
            @if(session('info'))
                toastr.info("{{ session('info') }}");
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>
