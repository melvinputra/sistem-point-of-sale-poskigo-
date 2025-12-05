<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - POSKigo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px 0;
        }
        
        .register-container {
            max-width: 950px;
            margin: 0 auto;
        }
        
        .register-card {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            overflow: hidden;
            background: white;
            border: 3px solid {{ $role == 'admin' ? '#dc3545' : ($role == 'kasir' ? '#0d6efd' : '#198754') }};
            position: relative;
        }
        
        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, {{ $role == 'admin' ? '#dc3545, #c82333, #dc3545' : ($role == 'kasir' ? '#0d6efd, #0a58ca, #0d6efd' : '#198754, #157347, #198754') }});
            z-index: 10;
        }
        
        .register-left {
            background: linear-gradient(135deg, {{ $role == 'admin' ? '#dc3545, #c82333' : ($role == 'kasir' ? '#0d6efd, #0a58ca' : '#198754, #157347') }});
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 650px;
            position: relative;
            overflow: hidden;
        }
        
        .register-left::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            top: -150px;
            right: -100px;
        }
        
        .register-left::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            bottom: -80px;
            left: -50px;
        }
        
        .register-left .icon-wrapper {
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
        
        .register-left .icon-wrapper i {
            font-size: 50px;
        }
        
        .register-left h2 {
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
            font-size: 32px;
        }
        
        .register-left p {
            font-size: 16px;
            opacity: 0.95;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }
        
        .register-left .features {
            margin-top: 30px;
            text-align: left;
            position: relative;
            z-index: 1;
        }
        
        .register-left .features .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 15px;
        }
        
        .register-left .features .feature-item i {
            width: 35px;
            height: 35px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 14px;
        }
        
        .register-right {
            padding: 50px 45px;
            background: white;
            position: relative;
        }
        
        .register-right h3 {
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .register-right h3::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: {{ $role == 'admin' ? '#dc3545' : ($role == 'kasir' ? '#0d6efd' : '#198754') }};
            margin-top: 10px;
            border-radius: 2px;
        }
        
        .register-right .subtitle {
            color: #6c757d;
            margin-bottom: 30px;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            font-size: 14px;
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
        
        .btn-register {
            padding: 14px 30px;
            font-weight: 600;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
            background: {{ $role == 'admin' ? '#dc3545' : ($role == 'kasir' ? '#0d6efd' : '#198754') }};
            color: white;
        }
        
        .btn-register::before {
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
        
        .btn-register:hover::before {
            left: 100%;
        }
        
        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px {{ $role == 'admin' ? 'rgba(220, 53, 69, 0.4)' : ($role == 'kasir' ? 'rgba(13, 110, 253, 0.4)' : 'rgba(25, 135, 84, 0.4)') }};
        }
        
        .btn-register:active {
            transform: translateY(-1px);
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }
        
        .divider span {
            padding: 0 15px;
            color: #6c757d;
            font-size: 14px;
        }
        
        .role-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            background: {{ $role == 'admin' ? 'rgba(220, 53, 69, 0.15)' : ($role == 'kasir' ? 'rgba(13, 110, 253, 0.15)' : 'rgba(25, 135, 84, 0.15)') }};
            color: {{ $role == 'admin' ? '#dc3545' : ($role == 'kasir' ? '#0d6efd' : '#198754') }};
            border: 1px solid {{ $role == 'admin' ? 'rgba(220, 53, 69, 0.3)' : ($role == 'kasir' ? 'rgba(13, 110, 253, 0.3)' : 'rgba(25, 135, 84, 0.3)') }};
        }
        
        .link-custom {
            color: {{ $role == 'admin' ? '#dc3545' : ($role == 'kasir' ? '#0d6efd' : '#198754') }};
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .link-custom:hover {
            color: {{ $role == 'admin' ? '#c82333' : ($role == 'kasir' ? '#0a58ca' : '#157347') }};
            text-decoration: underline;
        }
        
        .password-hint {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
            display: block;
        }
        
        .invalid-feedback {
            font-size: 13px;
            margin-top: 5px;
        }
        
        @media (max-width: 768px) {
            .register-left {
                min-height: 300px;
                padding: 40px 30px;
            }
            
            .register-left .icon-wrapper {
                width: 80px;
                height: 80px;
            }
            
            .register-left .icon-wrapper i {
                font-size: 35px;
            }
            
            .register-left h2 {
                font-size: 24px;
            }
            
            .register-left .features {
                display: none;
            }
            
            .register-right {
                padding: 35px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card register-card border-0">
                    <div class="row g-0">
                        <!-- Left Side - Branding -->
                        <div class="col-md-5">
                            <div class="register-left">
                                <div class="icon-wrapper">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <h2>Daftar Akun Baru</h2>
                                <p>Bergabunglah dengan POSKigo sebagai <strong>{{ ucfirst($role) }}</strong> dan nikmati kemudahan dalam mengelola transaksi!</p>
                                
                                <div class="features">
                                    @if($role == 'pelanggan')
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Belanja lebih mudah dan cepat</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Kelola dompet digital pribadi</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Dapatkan promo dan diskon menarik</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Riwayat transaksi lengkap</span>
                                    </div>
                                    @elseif($role == 'kasir')
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Kelola transaksi penjualan</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Dashboard kasir profesional</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Laporan harian dan bulanan</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Sistem antrian pickup order</span>
                                    </div>
                                    @else
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Kontrol penuh sistem POS</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Kelola pengguna dan produk</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Analisis laporan mendalam</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check"></i>
                                        <span>Manajemen promosi dan topup</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Side - Form -->
                        <div class="col-md-7">
                            <div class="register-right">
                                <h3>Buat Akun {{ ucfirst($role) }}</h3>
                                <p class="subtitle">
                                    Silakan isi formulir di bawah untuk mendaftar
                                    <span class="role-badge">{{ strtoupper($role) }}</span>
                                </p>

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <strong>Oops!</strong> Ada beberapa masalah:
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <input type="hidden" name="role" value="{{ $role }}">

                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-user me-1"></i> Nama Lengkap
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" 
                                                   name="name" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   placeholder="Masukkan nama lengkap Anda"
                                                   value="{{ old('name') }}" 
                                                   required 
                                                   autofocus>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-envelope me-1"></i> Alamat Email
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" 
                                                   name="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   placeholder="contoh@email.com"
                                                   value="{{ old('email') }}" 
                                                   required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-lock me-1"></i> Password
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" 
                                                   name="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   placeholder="Buat password yang kuat"
                                                   required>
                                        </div>
                                        <small class="password-hint">
                                            <i class="fas fa-info-circle me-1"></i>Minimal 6 karakter untuk keamanan akun Anda
                                        </small>
                                        @error('password')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">
                                            <i class="fas fa-shield-alt me-1"></i> Konfirmasi Password
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-shield-alt"></i>
                                            </span>
                                            <input type="password" 
                                                   name="password_confirmation" 
                                                   class="form-control" 
                                                   placeholder="Ketik ulang password Anda"
                                                   required>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-register w-100 mb-3">
                                        <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                                    </button>

                                    <div class="divider">
                                        <span>atau</span>
                                    </div>

                                    <div class="text-center mb-3">
                                        <p class="mb-0" style="color: #6c757d;">
                                            Sudah punya akun {{ ucfirst($role) }}? 
                                            <a href="{{ route('login', ['role' => $role]) }}" class="link-custom">
                                                Login di sini <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </p>
                                    </div>

                                    <div class="text-center pt-3" style="border-top: 1px solid #dee2e6;">
                                        <a href="{{ route('landing') }}" class="link-custom" style="font-size: 14px;">
                                            <i class="fas fa-home me-1"></i> Kembali ke Halaman Utama
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
