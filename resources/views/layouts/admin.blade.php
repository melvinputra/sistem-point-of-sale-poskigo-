<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'POSKigo Admin')</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        :root {
            --primary-green: #C4FF57;
            --secondary-green: #9FE869;
            --dark-green: #5a8e2a;
            --gradient-primary: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            --sidebar-width: 280px;
            --navbar-height: 70px;
        }
        
        body {
            background: #f8f9fa;
            overflow-x: hidden;
        }
        
        /* Modern Navbar */
        .navbar-modern {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 0;
            height: var(--navbar-height);
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .navbar-brand-modern {
            font-weight: 800;
            font-size: 1.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            height: var(--navbar-height);
        }
        
        .notification-bell {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #2a2a2a;
            transition: all 0.3s ease;
            margin-right: 1rem;
        }
        
        .notification-bell:hover {
            background: var(--gradient-primary);
            color: #1a1a1a;
            transform: scale(1.05);
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #f44336;
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(244, 67, 54, 0.4);
        }
        
        .user-dropdown-modern {
            background: var(--gradient-primary);
            color: #1a1a1a !important;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(196, 255, 87, 0.3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .user-dropdown-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(196, 255, 87, 0.4);
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
        #sidebarToggle {
            background: rgba(196, 255, 87, 0.1);
            border: none;
            color: #2a2a2a;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1.2rem;
            margin-right: 1rem;
        }

        #sidebarToggle:hover {
            background: var(--gradient-primary);
            transform: rotate(90deg);
            color: #1a1a1a;
        }

        #sidebarToggle i {
            transition: transform 0.3s ease;
        }

        .sb-sidenav-toggled #layoutSidenav_nav {
            transform: translateX(-100%);
        }

        .sb-sidenav-toggled #layoutSidenav_content {
            margin-left: 0;
            width: 100%;
        }

        .sb-sidenav-toggled .navbar-modern {
            left: 0;
        }
        
        /* Footer */
        .footer-modern {
            margin-left: var(--sidebar-width);
            background: white;
            border-top: 1px solid #e9ecef;
            padding: 1.5rem 2rem;
        }
        
        /* Dropdown Menu */
        .dropdown-menu-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            padding: 0.5rem;
        }
        
        .dropdown-item-modern {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .dropdown-item-modern:hover {
            background: var(--gradient-primary);
            color: #1a1a1a;
        }

        /* Responsive */
        @media (max-width: 991px) {
            #layoutSidenav_nav {
                transform: translateX(-100%);
            }

            .sb-sidenav-toggled #layoutSidenav_nav {
                transform: translateX(0);
            }

            #layoutSidenav_content {
                margin-left: 0;
                width: 100%;
            }

            .footer-modern {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav">
                <!-- Sidebar Brand -->
                <div class="sidebar-brand">
                    <div class="sidebar-brand-text">
                        <i class="fas fa-user-shield me-2"></i>POSKigo
                    </div>
                    <div class="sidebar-brand-subtitle">Admin Panel</div>
                </div>

                <!-- Sidebar Menu -->
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Main</div>
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Management</div>
                        <a class="nav-link {{ request()->routeIs('admin.items.*') ? 'active' : '' }}" 
                           href="{{ route('admin.items.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Data Barang
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                           href="{{ route('admin.users.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Data User
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}" 
                           href="{{ route('admin.promotions.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                            Promo & Voucher
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.topup.*') ? 'active' : '' }}" 
                           href="{{ route('admin.topup.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
                            Top-Up Request
                            @php
                                $pendingTopups = \App\Models\TopupRequest::where('status', 'pending')->count();
                            @endphp
                            @if($pendingTopups > 0)
                                <span class="badge-notification">{{ $pendingTopups }}</span>
                            @endif
                        </a>

                        <div class="sb-sidenav-menu-heading">Reports</div>
                        <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" 
                           href="{{ route('admin.reports.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                            Laporan Penjualan
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}" 
                           href="{{ route('admin.logs.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                            Activity Logs
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content Wrapper -->
        <div id="layoutSidenav_content">
            <!-- Modern Navbar -->
            <nav class="navbar navbar-expand-lg navbar-modern">
                <div class="container-fluid px-4">
                    <!-- Sidebar Toggle Button -->
                    <button class="btn" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="d-flex align-items-center ms-auto">
                        <!-- Notification Bell -->
                        <a href="{{ route('admin.dashboard') }}#notificationSection" class="notification-bell">
                            <i class="fas fa-bell"></i>
                            @php
                                $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="notification-badge">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </a>
                        
                        <!-- User Dropdown -->
                        <div class="dropdown">
                            <a class="user-dropdown-modern dropdown-toggle" href="#" id="navbarDropdown" 
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern" aria-labelledby="navbarDropdown">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item dropdown-item-modern">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main style="padding: 2rem;">
                @yield('content')
            </main>

            <!-- Modern Footer -->
            <footer class="footer-modern">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="text-muted small">
                        Copyright &copy; POSKigo {{ date('Y') }}
                    </div>
                    <div class="small">
                        <a href="#" class="text-decoration-none">Privacy Policy</a>
                        <span class="text-muted mx-2">&middot;</span>
                        <a href="#" class="text-decoration-none">Terms &amp; Conditions</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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

        // Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                });
            }
        });

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
    </script>
    @stack('scripts')
</body>
</html>
