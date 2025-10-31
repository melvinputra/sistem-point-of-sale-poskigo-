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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">POSKigo</h2>
                            <p class="text-muted">Login sebagai 
                                @if($role == 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($role == 'kasir')
                                    <span class="badge bg-primary">Kasir</span>
                                @else
                                    <span class="badge bg-success">Pelanggan</span>
                                @endif
                            </p>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="role" value="{{ $role }}">

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}" required autofocus>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-{{ $role == 'admin' ? 'danger' : ($role == 'kasir' ? 'primary' : 'success') }} w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>

                            @if($role == 'pelanggan')
                                <div class="text-center">
                                    <p class="mb-0">Belum punya akun? 
                                        <a href="{{ route('register', ['role' => 'pelanggan']) }}" class="text-decoration-none">Daftar Sekarang</a>
                                    </p>
                                </div>
                            @endif

                            <hr>
                            <div class="text-center">
                                <a href="{{ route('landing') }}" class="text-decoration-none">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Halaman Utama
                                </a>
                            </div>
                        </form>

                        @if(app()->environment('local'))
                        <div class="mt-3">
                            <div class="alert alert-info small mb-0">
                                <strong>Demo Akun:</strong><br>
                                @if($role == 'admin')
                                    Email: admin@poskigo.com<br>
                                @elseif($role == 'kasir')
                                    Email: kasir@poskigo.com<br>
                                @else
                                    Email: pelanggan@poskigo.com<br>
                                @endif
                                Password: password
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
