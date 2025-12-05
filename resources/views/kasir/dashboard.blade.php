@extends('layouts.kasir')

@section('title', 'Dashboard Kasir - POSKigo')

@section('content')
<style>
    /* Dashboard Header */
    .dashboard-header {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 10px 30px rgba(196, 255, 87, 0.2);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-20px, -20px); }
    }

    .dashboard-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .dashboard-header .subtitle {
        font-size: 1.1rem;
        color: #2a4a0a;
        font-weight: 500;
        position: relative;
        z-index: 1;
    }

    .dashboard-header .greeting-time {
        display: inline-block;
        background: rgba(255, 255, 255, 0.3);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-top: 0.5rem;
    }

    .stat-card-modern {
        background: #ffffff;
        border: 2px solid #f0f0f0;
        border-radius: 20px;
        padding: 2rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.03) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .stat-card-modern:hover {
        transform: translateY(-10px);
        border-color: #C4FF57;
        box-shadow: 0 20px 60px rgba(196, 255, 87, 0.2);
    }

    .stat-card-modern:hover::before {
        opacity: 1;
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
        transition: transform 0.4s ease;
    }

    .stat-card-modern:hover .stat-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .stat-label {
        font-size: 0.9rem;
        color: #6a6a6a;
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 0;
    }

    .action-card {
        background: #ffffff;
        border: 2px solid #f0f0f0;
        border-radius: 20px;
        padding: 2rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        text-decoration: none;
        display: block;
        position: relative;
        overflow: hidden;
    }

    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.05) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .action-card:hover {
        transform: translateY(-10px);
        border-color: #C4FF57;
        box-shadow: 0 20px 60px rgba(196, 255, 87, 0.2);
        text-decoration: none;
    }

    .action-card:hover::before {
        opacity: 1;
    }

    .action-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.2) 0%, rgba(159, 232, 105, 0.1) 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #5a8e2a;
        margin-bottom: 1rem;
        transition: all 0.4s ease;
    }

    .action-card:hover .action-icon {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        color: #1a1a1a;
        transform: scale(1.1) rotate(-5deg);
    }

    .action-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .action-description {
        font-size: 0.9rem;
        color: #6a6a6a;
        margin-bottom: 0;
    }

    .section-title-modern {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .section-title-modern::before {
        content: '';
        width: 5px;
        height: 35px;
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 10px;
    }

    .table-modern {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        border: 2px solid #f0f0f0;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .table-modern thead {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.15) 0%, rgba(159, 232, 105, 0.1) 100%);
    }

    .table-modern thead th {
        font-weight: 700;
        color: #1a1a1a;
        border: none;
        padding: 1.2rem 1rem;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table-modern tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f5f5f5;
    }

    .table-modern tbody tr:hover {
        background: rgba(196, 255, 87, 0.05);
        transform: scale(1.01);
    }

    .table-modern tbody td {
        padding: 1.2rem 1rem;
        vertical-align: middle;
        border: none;
    }

    .btn-modern {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        color: #1a1a1a;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(196, 255, 87, 0.4);
        color: #1a1a1a;
    }

    .badge-modern {
        padding: 0.4rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6a6a6a;
    }

    .empty-state i {
        font-size: 4rem;
        color: #d0d0d0;
        margin-bottom: 1rem;
    }

    /* Quick Stats */
    .quick-stat {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: #2a4a0a;
        font-weight: 600;
    }

    .quick-stat i {
        font-size: 1rem;
    }

    /* Animations */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card-modern,
    .action-card,
    .table-modern {
        animation: slideInUp 0.6s ease-out;
    }

    .stat-card-modern:nth-child(2) {
        animation-delay: 0.1s;
    }

    .action-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    .action-card:nth-child(3) {
        animation-delay: 0.2s;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem;
        }

        .dashboard-header h1 {
            font-size: 1.8rem;
        }
        
        .dashboard-header .subtitle {
            font-size: 0.95rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .section-title-modern {
            font-size: 1.4rem;
        }

        .action-title {
            font-size: 1rem;
        }

        .table-modern {
            font-size: 0.85rem;
        }
    }

    /* Top Items Card */
    .icon-wrapper-modern {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #ffffff;
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    }

    .top-item-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        height: 100%;
    }

    .top-item-card:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .top-item-rank {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.2rem;
        color: #1a1a1a;
        flex-shrink: 0;
    }

    .top-item-content {
        flex: 1;
    }

    .top-item-content h6 {
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.25rem;
    }
</style>

<!-- Dashboard Header -->
<div class="dashboard-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1><i class="fas fa-chart-line me-2"></i>Dashboard Kasir</h1>
            <p class="subtitle mb-2">Selamat datang kembali, {{ auth()->user()->name }}! Kelola transaksi dan penjualan Anda dengan mudah</p>
            
            <div class="d-flex gap-3 flex-wrap">
                <span class="greeting-time">
                    <i class="fas fa-calendar me-1"></i>
                    {{ now()->format('l, d F Y') }}
                </span>
                <span class="greeting-time">
                    <i class="fas fa-clock me-1"></i>
                    {{ now()->format('H:i') }} WIB
                </span>
            </div>
        </div>
        <div class="col-md-4 text-end d-none d-md-block">
            <div class="quick-stat">
                <i class="fas fa-store"></i>
                <span>Kasir Aktif</span>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-modern">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-label">Penjualan Hari Ini</div>
            <div class="stat-value">Rp {{ number_format($todaySales ?? 0, 0, ',', '.') }}</div>
            <small class="text-muted">{{ now()->format('d F Y') }}</small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-modern">
            <div class="stat-icon">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="stat-label">Transaksi Hari Ini</div>
            <div class="stat-value">{{ $todayTransactions ?? 0 }}</div>
            <small class="text-muted">Total transaksi</small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-modern">
            <div class="stat-icon" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-label">Penjualan Bulan Ini</div>
            <div class="stat-value">Rp {{ number_format($monthlySales ?? 0, 0, ',', '.') }}</div>
            <small class="text-muted">{{ now()->format('F Y') }}</small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card-modern">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-label">Transaksi Bulan Ini</div>
            <div class="stat-value">{{ $monthlyTransactions ?? 0 }}</div>
            <small class="text-muted">Total transaksi</small>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<h2 class="section-title-modern">
    Aksi Cepat
</h2>
<div class="row mb-5">
    <div class="col-lg-6 col-md-6 mb-4">
        <a href="{{ route('kasir.sales.create') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-cash-register"></i>
            </div>
            <h3 class="action-title">Transaksi Baru</h3>
            <p class="action-description">Mulai transaksi penjualan baru</p>
        </a>
    </div>
    <div class="col-lg-6 col-md-6 mb-4">
        <a href="{{ route('kasir.sales.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-history"></i>
            </div>
            <h3 class="action-title">Riwayat Transaksi</h3>
            <p class="action-description">Lihat semua transaksi sebelumnya</p>
        </a>
    </div>
</div>

<!-- Top Items Today -->
@if(isset($topItems) && $topItems->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card" style="border: none; border-radius: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div class="card-header" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); border-bottom: 2px solid #f0f0f0; padding: 1.5rem 2rem; border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper-modern bg-gradient-warning me-3" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Barang Terlaris Hari Ini</h5>
                        <small class="text-muted">Item dengan penjualan tertinggi</small>
                    </div>
                </div>
            </div>
            <div class="card-body" style="padding: 1.5rem 2rem;">
                <div class="row">
                    @foreach($topItems as $index => $item)
                    <div class="col-md-4 mb-3">
                        <div class="top-item-card">
                            <div class="top-item-rank">{{ $index + 1 }}</div>
                            <div class="top-item-content">
                                <h6 class="mb-1">{{ $item->item->name ?? 'Item dihapus' }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-tag me-1"></i>
                                    {{ $item->item->category->name ?? '-' }}
                                </small>
                                <div class="mt-2">
                                    <span class="badge" style="background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%); color: #1a1a1a; padding: 0.4rem 0.8rem; border-radius: 8px; font-weight: 600;">
                                        <i class="fas fa-shopping-cart me-1"></i>{{ $item->total_qty }} terjual
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Recent Sales -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="section-title-modern mb-0">
        Transaksi Terbaru
    </h2>
    <a href="{{ route('kasir.sales.index') }}" class="btn-modern btn-sm">
        <i class="fas fa-history"></i> Lihat Semua
    </a>
</div>

<div class="table-modern mb-4">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width: 10%;">ID</th>
                    <th style="width: 20%;">Tanggal & Waktu</th>
                    <th style="width: 30%;">Pelanggan</th>
                    <th style="width: 20%;">Total</th>
                    <th style="width: 20%; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSales as $sale)
                <tr>
                    <td>
                        <span class="badge-modern bg-light text-dark">
                            #{{ $sale->id }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <strong style="font-size: 0.95rem;">{{ $sale->created_at->format('d/m/Y') }}</strong>
                            <small class="text-muted">
                                <i class="far fa-clock me-1"></i>{{ $sale->created_at->format('H:i') }} WIB
                            </small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar-small">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>{{ $sale->customer ? $sale->customer->name : 'Pelanggan Umum' }}</span>
                        </div>
                    </td>
                    <td>
                        <strong style="color: #5a8e2a; font-size: 1.05rem;">
                            Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                        </strong>
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('kasir.sales.show', $sale->id) }}" class="btn-modern btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p class="mb-0"><strong>Belum ada transaksi hari ini</strong></p>
                            <small class="text-muted">Transaksi baru akan muncul di sini</small>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .user-avatar-small {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.2) 0%, rgba(159, 232, 105, 0.15) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.8rem;
        color: #5a8e2a;
    }

    .table-responsive {
        border-radius: 20px;
        overflow: hidden;
    }
</style>
@endsection
