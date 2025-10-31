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
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #1e88e5;
            --primary-orange: #ff6f00;
            --dark-blue: #0d47a1;
        }
        
        #layoutSidenav {
            display: flex;
        }
        #layoutSidenav #layoutSidenav_nav {
            flex-basis: 225px;
            flex-shrink: 0;
            transition: transform 0.15s ease-in-out;
            z-index: 1038;
            transform: translateX(0);
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--primary-blue) 100%);
        }
        #layoutSidenav #layoutSidenav_content {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
            flex-grow: 1;
            min-height: calc(100vh - 56px);
        }
        .sb-nav-fixed .sb-topnav {
            z-index: 1039;
        }
        .sb-sidenav {
            display: flex;
            flex-direction: column;
            height: 100%;
            flex-wrap: nowrap;
        }
        .sb-sidenav-menu {
            flex-grow: 1;
        }
        .sb-sidenav-menu .nav {
            flex-direction: column;
            flex-wrap: nowrap;
        }
        .sb-sidenav-menu .nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s;
        }
        .sb-sidenav-menu .nav .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .sb-sidenav-menu .nav .nav-link .sb-nav-link-icon {
            margin-right: 0.5rem;
        }
        .sb-topnav {
            padding-left: 0;
            height: 56px;
            z-index: 1039;
            background: linear-gradient(90deg, var(--primary-blue) 0%, var(--primary-orange) 100%) !important;
        }
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
            border: none;
            border-radius: 0.5rem;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        .btn-warning {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
            color: white;
        }
    </style>
    @stack('styles')
</head>
<body class="sb-nav-fixed">
    <!-- Top Navigation -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand ps-3" href="{{ route('kasir.dashboard') }}">POSKigo Kasir</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> {{ auth()->user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt fa-fw"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion" id="sidenavAccordion" style="background-color: #0d6efd;">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading text-white-50">Main</div>
                        <a class="nav-link" href="{{ route('kasir.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading text-white-50">Transaksi</div>
                        <a class="nav-link" href="{{ route('kasir.sales.create') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                            Transaksi Baru
                        </a>
                        <a class="nav-link" href="{{ route('kasir.sales.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>
                            Riwayat Transaksi
                        </a>
                        <a class="nav-link" href="{{ route('kasir.online-orders') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Pesanan Online
                            @php
                                $pendingCount = \App\Models\Sale::where('order_type', 'online')->where('order_status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge bg-warning text-dark ms-2">{{ $pendingCount }}</span>
                            @endif
                        </a>

                        <div class="sb-sidenav-menu-heading text-white-50">Customer</div>
                        <a class="nav-link" href="{{ route('kasir.customers.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Data Pelanggan
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; POSKigo {{ date('Y') }}</div>
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
