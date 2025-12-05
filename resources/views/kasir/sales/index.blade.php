@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi - POSKigo')

@section('content')
<style>
    .page-header-modern {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-header-modern h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .breadcrumb-modern {
        background: transparent;
        padding: 0;
        margin: 0.5rem 0 0 0;
        font-size: 0.9rem;
    }

    .breadcrumb-modern a {
        color: #6a6a6a;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-modern a:hover {
        color: #9FE869;
    }

    .card-modern {
        background: #ffffff;
        border: 2px solid #f0f0f0;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .card-header-modern {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.15) 0%, rgba(159, 232, 105, 0.1) 100%);
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #f0f0f0;
    }

    .card-header-modern h5 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1a1a;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .table-modern {
        width: 100%;
    }

    .table-modern thead {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.1) 0%, rgba(159, 232, 105, 0.05) 100%);
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

    .btn-modern-primary {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        color: #1a1a1a;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-modern-primary:hover {
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

    .stat-card-mini {
        background: #ffffff;
        border: 2px solid #f0f0f0;
        border-radius: 20px;
        padding: 1.5rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
    }

    .stat-card-mini:hover {
        transform: translateY(-5px);
        border-color: #C4FF57;
        box-shadow: 0 15px 40px rgba(196, 255, 87, 0.2);
    }

    .stat-card-mini h6 {
        font-size: 0.85rem;
        font-weight: 600;
        color: #6a6a6a;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card-mini h3 {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1a1a1a;
        margin: 0;
    }

    .stat-card-mini.primary {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.15) 0%, rgba(159, 232, 105, 0.1) 100%);
        border-color: #C4FF57;
    }

    .stat-card-mini.success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.1) 100%);
        border-color: #10b981;
    }

    .stat-card-mini.info {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.1) 100%);
        border-color: #3b82f6;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 5rem;
        color: #d0d0d0;
        margin-bottom: 1.5rem;
    }

    .empty-state p {
        color: #6a6a6a;
        font-size: 1.1rem;
    }
</style>

<div class="page-header-modern">
    <div>
        <h1>
            <i class="fas fa-receipt"></i>
            Riwayat Transaksi
        </h1>
        <nav class="breadcrumb-modern">
            <a href="{{ route('kasir.dashboard') }}">Dashboard</a>
            <span class="mx-2">/</span>
            <span>Riwayat Transaksi</span>
        </nav>
    </div>
    <a href="{{ route('kasir.sales.create') }}" class="btn btn-modern-primary">
        <i class="fas fa-plus"></i> Transaksi Baru
    </a>
</div>

<div class="card-modern">
    <div class="card-header-modern">
        <h5>
            <i class="fas fa-table"></i>
            Daftar Transaksi Penjualan
        </h5>
    </div>
    <div class="p-3">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal & Waktu</th>
                        <th>Pelanggan</th>
                        <th>Total Belanja</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
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
                            @if($sale->customer)
                                <div class="d-flex align-items-center">
                                    <div style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, rgba(196, 255, 87, 0.2) 0%, rgba(159, 232, 105, 0.15) 100%); display: flex; align-items: center; justify-content: center; margin-right: 0.8rem; color: #5a8e2a;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $sale->customer->name }}</strong><br>
                                        <small class="text-muted">{{ $sale->customer->phone }}</small>
                                    </div>
                                </div>
                            @else
                                <span class="badge-modern bg-secondary text-white">
                                    <i class="fas fa-users me-1"></i> Pelanggan Umum
                                </span>
                            @endif
                        </td>
                        <td>
                            <strong style="color: #5a8e2a; font-size: 1.1rem;">
                                Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                            </strong>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('kasir.sales.show', $sale->id) }}" class="btn btn-modern-primary btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p class="mb-0"><strong>Belum ada transaksi</strong></p>
                                <small class="text-muted">Transaksi akan muncul di sini setelah Anda memproses penjualan</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sales->count() > 0)
        <div class="mt-3 px-3">
            {{ $sales->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Summary Cards -->
@if($sales->count() > 0)
<div class="row">
    <div class="col-md-4 mb-3">
        <div class="stat-card-mini primary">
            <h6><i class="fas fa-list me-1"></i> Total Transaksi</h6>
            <h3>{{ $sales->total() }}</h3>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card-mini success">
            <h6><i class="fas fa-money-bill-wave me-1"></i> Total Penjualan</h6>
            <h3>Rp {{ number_format($sales->sum('total_amount'), 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card-mini info">
            <h6><i class="fas fa-chart-line me-1"></i> Rata-rata per Transaksi</h6>
            <h3>Rp {{ number_format($sales->avg('total_amount'), 0, ',', '.') }}</h3>
        </div>
    </div>
</div>
@endif
@endsection
