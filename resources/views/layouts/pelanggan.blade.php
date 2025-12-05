<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'POSKigo')</title>
    
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
        }
        
        body {
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        /* Modern Navbar */
        .navbar-modern {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand-modern {
            font-weight: 800;
            font-size: 1.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-link-modern {
            color: #2a2a2a !important;
            font-weight: 600;
            padding: 0.5rem 1rem !important;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
        }
        
        .nav-link-modern:hover,
        .nav-link-modern.active {
            background: var(--gradient-primary);
            color: #1a1a1a !important;
        }
        
        .nav-link-modern i {
            margin-right: 0.5rem;
        }
        
        .user-dropdown-modern {
            background: var(--gradient-primary);
            color: #1a1a1a !important;
            font-weight: 600;
            padding: 0.5rem 1.25rem !important;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(196, 255, 87, 0.3);
        }
        
        .user-dropdown-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(196, 255, 87, 0.4);
        }
        
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
        
        /* Card Modern */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
        
        /* Button Modern */
        .btn-modern-primary {
            background: var(--gradient-primary);
            border: none;
            color: #1a1a1a;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(196, 255, 87, 0.3);
        }
        
        .btn-modern-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(196, 255, 87, 0.4);
            color: #1a1a1a;
        }
        
        .btn-modern-secondary {
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            color: #495057;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-modern-secondary:hover {
            background: #e9ecef;
            border-color: #ced4da;
        }
        
        /* Main Content */
        main {
            padding: 2rem 0;
            min-height: calc(100vh - 180px);
        }
        
        /* Footer */
        .footer-modern {
            background: white;
            border-top: 1px solid #e9ecef;
            padding: 2rem 0;
            margin-top: 4rem;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Modern Navigation -->
    <nav class="navbar navbar-expand-lg navbar-modern">
        <div class="container">
            <a class="navbar-brand navbar-brand-modern" href="{{ route('pelanggan.dashboard') }}">
                <i class="fas fa-store me-2"></i>POSKigo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link nav-link-modern {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}" 
                           href="{{ route('pelanggan.dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-modern {{ request()->routeIs('pelanggan.wallet.*') ? 'active' : '' }}" 
                           href="{{ route('pelanggan.wallet.index') }}">
                            <i class="fas fa-wallet"></i> KiWallet
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-modern {{ request()->routeIs('pelanggan.shop') ? 'active' : '' }}" 
                           href="{{ route('pelanggan.shop') }}">
                            <i class="fas fa-shopping-cart"></i> Belanja
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-modern {{ request()->routeIs('pelanggan.transactions') ? 'active' : '' }}" 
                           href="{{ route('pelanggan.transactions') }}">
                            <i class="fas fa-receipt"></i> Riwayat
                        </a>
                    </li>
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle user-dropdown-modern" href="#" id="navbarDropdown" 
                           role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item dropdown-item-modern">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Modern Footer -->
    <footer class="footer-modern">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} POSKigo. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

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
