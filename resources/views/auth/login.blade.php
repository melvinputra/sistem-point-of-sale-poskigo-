<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POSKigo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            max-width: 950px;
            margin: 0 auto;
        }
        
        .login-card {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            overflow: hidden;
            background: white;
            border: 3px solid {{ $role == 'admin' ? '#dc3545' : ($role == 'kasir' ? '#0d6efd' : '#198754') }};
            position: relative;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, {{ $role == 'admin' ? '#dc3545, #c82333, #dc3545' : ($role == 'kasir' ? '#0d6efd, #0a58ca, #0d6efd' : '#198754, #157347, #198754') }});
            z-index: 10;
        }
        
        .login-left {
            background: linear-gradient(135deg, {{ $role == 'admin' ? '#dc3545, #c82333' : ($role == 'kasir' ? '#0d6efd, #0a58ca' : '#198754, #157347') }});
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 550px;
            position: relative;
            overflow: hidden;
        }
        
        .login-left::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            top: -150px;
            right: -100px;
        }
        
        .login-left::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            bottom: -80px;
            left: -50px;
        }
        
        .login-left .icon-wrapper {
            width: 120px;
            height: 120px;
            background: rgba(255,255,255,0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
            border: 4px solid rgba(255,255,255,0.4);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            position: relative;
            z-index: 1;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .login-left .icon-wrapper i {
            font-size: 50px;
        }
        
        .login-left h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .login-left .role-badge {
            font-size: 1.2rem;
            padding: 10px 30px;
            border-radius: 50px;
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
            margin-bottom: 20px;
            font-weight: 600;
            border: 2px solid rgba(255,255,255,0.3);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
        }
        
        .login-left p {
            font-size: 1rem;
            line-height: 1.6;
            opacity: 0.95;
        }
        
        .login-right {
            padding: 60px 50px;
            background: white;
            position: relative;
        }
        
        .login-right::before {
            content: '';
            position: absolute;
            top: 20px;
            right: 20px;
            width: 80px;
            height: 80px;
            background: {{ $role == 'admin' ? 'rgba(220, 53, 69, 0.05)' : ($role == 'kasir' ? 'rgba(13, 110, 253, 0.05)' : 'rgba(25, 135, 84, 0.05)') }};
            border-radius: 50%;
            z-index: 0;
        }
        
        .login-right h3 {
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .login-right h3::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: {{ $role == 'admin' ? '#dc3545' : ($role == 'kasir' ? '#0d6efd' : '#198754') }};
            margin-top: 10px;
            border-radius: 2px;
        }
        
        .login-right .subtitle {
            color: #6c757d;
            margin-bottom: 35px;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .input-group {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .input-group:focus-within {
            box-shadow: 0 4px 12px {{ $role == 'admin' ? 'rgba(220, 53, 69, 0.15)' : ($role == 'kasir' ? 'rgba(13, 110, 253, 0.15)' : 'rgba(25, 135, 84, 0.15)') }};
            transform: translateY(-2px);
        }
        
        .input-group-text {
            background: {{ $role == 'admin' ? 'rgba(220, 53, 69, 0.08)' : ($role == 'kasir' ? 'rgba(13, 110, 253, 0.08)' : 'rgba(25, 135, 84, 0.08)') }};
            border: 2px solid {{ $role == 'admin' ? 'rgba(220, 53, 69, 0.2)' : ($role == 'kasir' ? 'rgba(13, 110, 253, 0.2)' : 'rgba(25, 135, 84, 0.2)') }};
            border-right: none;
            color: {{ $role == 'admin' ? '#dc3545' : ($role == 'kasir' ? '#0d6efd' : '#198754') }};
        }
        
        .form-control {
            border-left: none;
            padding: 12px 15px;
            font-size: 15px;
            border: 2px solid {{ $role == 'admin' ? 'rgba(220, 53, 69, 0.2)' : ($role == 'kasir' ? 'rgba(13, 110, 253, 0.2)' : 'rgba(25, 135, 84, 0.2)') }};
        }
        
        .form-control:focus {
            box-shadow: none;
            border-color: {{ $role == 'admin' ? 'rgba(220, 53, 69, 0.3)' : ($role == 'kasir' ? 'rgba(13, 110, 253, 0.3)' : 'rgba(25, 135, 84, 0.3)') }};
        }
        
        .btn-login {
            padding: 14px 30px;
            font-weight: 600;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            transition: left 0.5s ease;
            z-index: -1;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px {{ $role == 'admin' ? 'rgba(220, 53, 69, 0.4)' : ($role == 'kasir' ? 'rgba(13, 110, 253, 0.4)' : 'rgba(25, 135, 84, 0.4)') }};
        }
        
        .btn-login:active {
            transform: translateY(-1px);
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
            color: #6c757d;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }
        
        .divider span {
            padding: 0 15px;
            font-size: 14px;
        }
        
        .back-link {
            color: #6c757d;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: #495057;
        }
        
        @media (max-width: 768px) {
            .login-left {
                padding: 40px 30px;
                min-height: auto;
            }
            
            .login-left h2 {
                font-size: 2rem;
            }
            
            .login-left .icon-wrapper {
                width: 90px;
                height: 90px;
            }
            
            .login-left .icon-wrapper i {
                font-size: 40px;
            }
            
            .login-right {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="card login-card border-0">
                <div class="row g-0">
                    <!-- Left Side - Role Information -->
                    <div class="col-lg-5">
                        <div class="login-left">
                            <div class="icon-wrapper">
                                @if($role == 'admin')
                                    <i class="fas fa-user-shield"></i>
                                @elseif($role == 'kasir')
                                    <i class="fas fa-cash-register"></i>
                                @else
                                    <i class="fas fa-user-circle"></i>
                                @endif
                            </div>
                            
                            <h2>POSKigo</h2>
                            
                            <div class="role-badge">
                                @if($role == 'admin')
                                    Administrator
                                @elseif($role == 'kasir')
                                    Kasir
                                @else
                                    Pelanggan
                                @endif
                            </div>
                            
                            <p>
                                @if($role == 'admin')
                                    Kelola sistem, data, dan laporan dengan akses penuh ke semua fitur administrasi.
                                @elseif($role == 'kasir')
                                    Proses transaksi penjualan dengan cepat dan kelola operasional kasir harian.
                                @else
                                    Nikmati kemudahan berbelanja dan kelola akun serta riwayat transaksi Anda.
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <!-- Right Side - Login Form -->
                    <div class="col-lg-7">
                        <div class="login-right">
                            <h3>Selamat Datang!</h3>
                            <p class="subtitle">Silakan login untuk melanjutkan</p>
                            
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <input type="hidden" name="role" value="{{ $role }}">

                                <div class="mb-4">
                                    <label class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                               value="{{ old('email') }}" placeholder="Masukkan email Anda" required autofocus>
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                               placeholder="Masukkan password Anda" required>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-{{ $role == 'admin' ? 'danger' : ($role == 'kasir' ? 'primary' : 'success') }} btn-login w-100 mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i> Masuk
                                </button>

                                @if($role == 'pelanggan')
                                    <div class="text-center mb-3">
                                        <p class="mb-0">Belum punya akun? 
                                            <a href="{{ route('register', ['role' => 'pelanggan']) }}" class="text-{{ $role == 'admin' ? 'danger' : ($role == 'kasir' ? 'primary' : 'success') }} text-decoration-none fw-semibold">Daftar Sekarang</a>
                                        </p>
                                    </div>
                                @endif

                                <div class="divider">
                                    <span>atau</span>
                                </div>
                                
                                <div class="text-center">
                                    <a href="{{ route('landing') }}" class="back-link">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Halaman Utama
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
