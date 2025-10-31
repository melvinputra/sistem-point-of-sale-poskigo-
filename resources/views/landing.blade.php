<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSKigo - Sistem Kasir Cerdas Modern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #1a1a1a;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar-custom.scrolled {
            box-shadow: 0 2px 30px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand-custom {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link-custom {
            color: #4a4a4a;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease;
        }

        .nav-link-custom:hover {
            color: #9FE869;
        }

        .btn-nav {
            background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            color: #1a1a1a;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-nav:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(196, 255, 87, 0.4);
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }
        
        .animated-bg::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(196, 255, 87, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            top: -300px;
            right: -300px;
            animation: float 20s ease-in-out infinite;
        }
        
        .animated-bg::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(159, 232, 105, 0.06) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -250px;
            left: -250px;
            animation: float 15s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(50px, 50px) scale(1.1); }
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
            padding-top: 80px;
        }

        /* Hero Section */
        .hero-section {
            min-height: 90vh;
            display: flex;
            align-items: center;
            background: transparent;
            position: relative;
            overflow: hidden;
            padding: 60px 0;
        }

        .hero-content {
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-badge {
            display: inline-block;
            background: rgba(196, 255, 87, 0.15);
            color: #5a8e2a;
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #5a8e2a 0%, #7db83d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            letter-spacing: -2px;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: #6a6a6a;
            font-weight: 500;
            margin-bottom: 2rem;
        }

        .hero-description {
            font-size: 1.1rem;
            color: #8a8a8a;
            max-width: 600px;
            margin: 0 auto 3rem;
            line-height: 1.8;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            color: #1a1a1a;
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(196, 255, 87, 0.4);
        }

        .btn-hero-secondary {
            background: transparent;
            color: #5a8e2a;
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid #C4FF57;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-hero-secondary:hover {
            background: #C4FF57;
            color: #1a1a1a;
            transform: translateY(-3px);
        }

        /* Stats Section */
        .stats-section {
            padding: 60px 0;
            background: rgba(248, 249, 250, 0.5);
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #5a8e2a 0%, #7db83d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            color: #6a6a6a;
            font-weight: 500;
        }

        /* Role Section */
        .roles-section {
            padding: 100px 0;
            background: transparent;
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            color: #1a1a1a;
        }

        .section-subtitle {
            text-align: center;
            color: #6a6a6a;
            font-size: 1.1rem;
            margin-bottom: 4rem;
        }

        .role-card {
            background: #ffffff;
            border: 2px solid #f0f0f0;
            border-radius: 20px;
            padding: 2.5rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: visible;
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(196, 255, 87, 0.03) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
            pointer-events: none;
        }

        .role-card:hover {
            transform: translateY(-10px);
            border-color: #C4FF57;
            box-shadow: 0 20px 60px rgba(196, 255, 87, 0.2);
        }

        .role-card:hover::before {
            opacity: 1;
        }

        .role-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
            transition: transform 0.4s ease;
            position: relative;
            z-index: 2;
        }

        .role-card:hover .role-icon {
            transform: scale(1.1) rotate(-5deg);
        }

        .role-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .role-description {
            color: #6a6a6a;
            margin-bottom: 2rem;
            line-height: 1.6;
            position: relative;
            z-index: 2;
        }

        .role-features {
            list-style: none;
            padding: 0;
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
        }

        .role-features li {
            color: #6a6a6a;
            padding: 0.6rem 0;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .role-features li i {
            color: #7db83d;
            margin-right: 12px;
            font-size: 1rem;
        }

        .btn-role {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            color: #1a1a1a;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
            cursor: pointer;
            position: relative;
            z-index: 10;
        }

        .btn-role:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(196, 255, 87, 0.4);
            color: #1a1a1a;
        }

        .btn-outline-role {
            background: transparent;
            border: 2px solid #C4FF57;
            color: #5a8e2a;
            margin-top: 10px;
        }

        .btn-outline-role:hover {
            background: #C4FF57;
            color: #1a1a1a;
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: rgba(248, 249, 250, 0.5);
        }

        .feature-card {
            text-align: center;
            padding: 2rem;
            transition: transform 0.3s ease;
            background: #ffffff;
            border-radius: 16px;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(196, 255, 87, 0.15) 0%, rgba(196, 255, 87, 0.05) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
            box-shadow: 0 10px 30px rgba(196, 255, 87, 0.3);
        }

        .feature-icon i {
            font-size: 2rem;
            color: #7db83d;
            transition: color 0.3s ease;
        }

        .feature-card:hover .feature-icon i {
            color: #1a1a1a;
        }

        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 0.8rem;
        }

        .feature-description {
            color: #6a6a6a;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            background: #1a1a1a;
            padding: 50px 0 30px;
            color: #b0b0b0;
        }

        footer .brand {
            color: #C4FF57;
            font-weight: 700;
        }

        footer .footer-links a {
            color: #b0b0b0;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer .footer-links a:hover {
            color: #C4FF57;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }

            .btn-hero-primary, .btn-hero-secondary {
                padding: 0.9rem 1.8rem;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom" href="/">
                <i class="fas fa-store me-2"></i>POSKigo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#roles">Role</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#about">Tentang</a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-nav">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        <!-- Hero Section -->
        <section class="hero-section" id="home">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="hero-content text-center">
                            <div class="hero-badge">
                                <i class="fas fa-sparkles me-2"></i>Sistem Kasir #1 di Indonesia
                            </div>
                            <h1 class="hero-title">Kelola Toko Retail dengan Mudah</h1>
                            <p class="hero-subtitle">POSKigo - Platform Kasir Modern & Cerdas</p>
                            <p class="hero-description">
                                Revolusi pengelolaan toko retail dengan teknologi terdepan. 
                                Transaksi cepat, laporan real-time, dan pengelolaan yang efisien dalam satu platform terintegrasi.
                            </p>
                            <div class="d-flex gap-3 justify-content-center flex-wrap">
                                <a href="#roles" class="btn-hero-primary">
                                    <i class="fas fa-rocket"></i> Mulai Sekarang
                                </a>
                                <a href="#features" class="btn-hero-secondary">
                                    <i class="fas fa-play-circle"></i> Lihat Demo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-number">1000+</div>
                            <div class="stat-label">Transaksi Harian</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Pengguna Aktif</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-number">99.9%</div>
                            <div class="stat-label">Uptime Server</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Role Selection Section -->
        <section class="roles-section" id="roles">
            <div class="container">
                <h2 class="section-title">Pilih Role Anda</h2>
                <p class="section-subtitle">Login sesuai dengan peran Anda di ekosistem POSKigo</p>

                <div class="row g-4">
                    <!-- Admin Card -->
                    <div class="col-lg-4 col-md-6">
                        <div class="role-card">
                            <div class="role-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h3 class="role-title">Admin</h3>
                            <p class="role-description">
                                Kontrol penuh sistem, kelola data, monitor performa, dan akses laporan mendalam
                            </p>
                            <ul class="role-features">
                                <li><i class="fas fa-check-circle"></i> Dashboard Analytics</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Data Barang</li>
                                <li><i class="fas fa-check-circle"></i> Kelola User & Role</li>
                                <li><i class="fas fa-check-circle"></i> Export Laporan Excel/PDF</li>
                                <li><i class="fas fa-check-circle"></i> Activity Logs</li>
                            </ul>
                            <a href="{{ route('login') }}?role=admin" class="btn btn-role">
                                <i class="fas fa-sign-in-alt"></i> Login Admin
                            </a>
                        </div>
                    </div>

                    <!-- Kasir Card -->
                    <div class="col-lg-4 col-md-6">
                        <div class="role-card">
                            <div class="role-icon">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <h3 class="role-title">Kasir</h3>
                            <p class="role-description">
                                Proses transaksi cepat dengan sistem voucher, pajak otomatis, dan notifikasi real-time
                            </p>
                            <ul class="role-features">
                                <li><i class="fas fa-check-circle"></i> Transaksi Lightning-Fast</li>
                                <li><i class="fas fa-check-circle"></i> Sistem Diskon & Voucher</li>
                                <li><i class="fas fa-check-circle"></i> Perhitungan Pajak Otomatis</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Pelanggan</li>
                                <li><i class="fas fa-check-circle"></i> Riwayat Transaksi</li>
                            </ul>
                            <a href="{{ route('login') }}?role=kasir" class="btn btn-role">
                                <i class="fas fa-sign-in-alt"></i> Login Kasir
                            </a>
                        </div>
                    </div>

                    <!-- Pelanggan Card -->
                    <div class="col-lg-4 col-md-12">
                        <div class="role-card">
                            <div class="role-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <h3 class="role-title">Pelanggan</h3>
                            <p class="role-description">
                                Nikmati kemudahan berbelanja dengan KiWallet digital dan tracking transaksi lengkap
                            </p>
                            <ul class="role-features">
                                <li><i class="fas fa-check-circle"></i> KiWallet Digital Balance</li>
                                <li><i class="fas fa-check-circle"></i> Top-Up Saldo Mudah</li>
                                <li><i class="fas fa-check-circle"></i> Riwayat Transaksi Detail</li>
                                <li><i class="fas fa-check-circle"></i> Notifikasi Real-time</li>
                                <li><i class="fas fa-check-circle"></i> Shopping Online (Soon)</li>
                            </ul>
                            <a href="{{ route('login') }}?role=pelanggan" class="btn btn-role">
                                <i class="fas fa-sign-in-alt"></i> Login Pelanggan
                            </a>
                            <a href="{{ route('register') }}?role=pelanggan" class="btn btn-role btn-outline-role">
                                <i class="fas fa-user-plus"></i> Daftar Gratis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section" id="features">
            <div class="container">
                <h2 class="section-title">Fitur Unggulan</h2>
                <p class="section-subtitle">Teknologi terdepan untuk bisnis retail modern Anda</p>
                
                <div class="row g-4 mt-2">
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <h5 class="feature-title">Lightning Fast</h5>
                            <p class="feature-description">Proses transaksi dalam hitungan detik dengan teknologi terkini</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5 class="feature-title">Super Secure</h5>
                            <p class="feature-description">Enkripsi data tingkat enterprise dan activity logging lengkap</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5 class="feature-title">Real-time Reports</h5>
                            <p class="feature-description">Analisis penjualan dengan Chart.js dan export Excel/PDF</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h5 class="feature-title">Mobile Ready</h5>
                            <p class="feature-description">Responsive design, akses dari smartphone hingga desktop</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-1">
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <h5 class="feature-title">Smart Notifications</h5>
                            <p class="feature-description">Alert real-time untuk transaksi, stok rendah, dan top-up</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <h5 class="feature-title">Digital Wallet</h5>
                            <p class="feature-description">KiWallet untuk transaksi cashless yang lebih mudah</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <h5 class="feature-title">Promo System</h5>
                            <p class="feature-description">Kelola voucher dan promosi dengan mudah dan efektif</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-history"></i>
                            </div>
                            <h5 class="feature-title">Activity Logs</h5>
                            <p class="feature-description">Track semua perubahan data dengan detail lengkap</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="py-5" id="about">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h2 class="section-title text-start mb-4">Kenapa Memilih POSKigo?</h2>
                        <p class="text-muted mb-4" style="line-height: 1.8;">
                            POSKigo adalah solusi Point of Sale terlengkap yang dirancang khusus untuk bisnis retail modern di Indonesia. 
                            Dengan teknologi cloud-based dan interface yang user-friendly, kami membantu ribuan bisnis mengelola 
                            operasional toko mereka dengan lebih efisien.
                        </p>
                        <div class="d-flex gap-3 mb-3">
                            <div class="text-center">
                                <i class="fas fa-check-circle fa-2x" style="color: #7db83d;"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Mudah Digunakan</h5>
                                <p class="text-muted mb-0">Interface intuitif yang mudah dipelajari</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-3">
                            <div class="text-center">
                                <i class="fas fa-check-circle fa-2x" style="color: #7db83d;"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Support 24/7</h5>
                                <p class="text-muted mb-0">Tim support siap membantu kapan saja</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="text-center">
                                <i class="fas fa-check-circle fa-2x" style="color: #7db83d;"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Update Berkala</h5>
                                <p class="text-muted mb-0">Fitur baru ditambahkan secara rutin</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <i class="fas fa-laptop fa-10x" style="color: #C4FF57; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <h5 class="brand mb-3"><i class="fas fa-store me-2"></i>POSKigo</h5>
                        <p class="mb-3">Sistem Kasir Cerdas untuk Bisnis Modern. Kelola toko retail Anda dengan mudah dan efisien.</p>
                        <div class="d-flex gap-3">
                            <a href="#" style="color: #b0b0b0; font-size: 1.5rem;"><i class="fab fa-facebook"></i></a>
                            <a href="#" style="color: #b0b0b0; font-size: 1.5rem;"><i class="fab fa-instagram"></i></a>
                            <a href="#" style="color: #b0b0b0; font-size: 1.5rem;"><i class="fab fa-twitter"></i></a>
                            <a href="#" style="color: #b0b0b0; font-size: 1.5rem;"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 mb-4 mb-lg-0">
                        <h6 class="text-white mb-3">Produk</h6>
                        <div class="footer-links d-flex flex-column gap-2">
                            <a href="#features">Fitur</a>
                            <a href="#roles">Role</a>
                            <a href="#">Harga</a>
                            <a href="#">Demo</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 mb-4 mb-lg-0">
                        <h6 class="text-white mb-3">Perusahaan</h6>
                        <div class="footer-links d-flex flex-column gap-2">
                            <a href="#about">Tentang</a>
                            <a href="#">Blog</a>
                            <a href="#">Karir</a>
                            <a href="#">Kontak</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 mb-4 mb-lg-0">
                        <h6 class="text-white mb-3">Bantuan</h6>
                        <div class="footer-links d-flex flex-column gap-2">
                            <a href="#">FAQ</a>
                            <a href="#">Dokumentasi</a>
                            <a href="#">Support</a>
                            <a href="#">Tutorial</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6">
                        <h6 class="text-white mb-3">Legal</h6>
                        <div class="footer-links d-flex flex-column gap-2">
                            <a href="#">Privacy Policy</a>
                            <a href="#">Terms of Service</a>
                            <a href="#">Cookie Policy</a>
                        </div>
                    </div>
                </div>
                <hr style="border-color: rgba(255,255,255,0.1);">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <p class="mb-0">&copy; {{ date('Y') }} <span class="brand">POSKigo</span>. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <p class="mb-0">Made with <i class="fas fa-heart" style="color: #C4FF57;"></i> in Indonesia</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
