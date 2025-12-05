@extends('layouts.pelanggan')

@section('title', 'Dashboard - POSKigo')

@section('content')
<style>
    .page-header-modern {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 16px rgba(196, 255, 87, 0.15);
    }
    
    .page-header-modern h1 {
        color: #1a1a1a;
        font-weight: 800;
        font-size: 2rem;
        margin: 0;
    }
    
    .page-header-modern p {
        color: #2a2a2a;
        font-weight: 500;
        margin: 0.5rem 0 0;
    }
    
    .action-card-modern {
        height: 100%;
        border: none;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        text-decoration: none;
        display: block;
        background: white;
    }
    
    .action-card-modern:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }
    
    .action-card-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        transition: all 0.3s ease;
    }
    
    .action-card-wallet .action-card-icon {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: #1a1a1a;
        box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);
    }
    
    .action-card-shop .action-card-icon {
        background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(33, 150, 243, 0.3);
    }
    
    .action-card-history .action-card-icon {
        background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3);
    }
    
    .action-card-modern:hover .action-card-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    .action-card-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }
    
    .action-card-text {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }
    
    .action-card-button {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border: none;
        color: #1a1a1a;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(196, 255, 87, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .action-card-modern:hover .action-card-button {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(196, 255, 87, 0.4);
    }
    
    .recent-transactions-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .card-header-modern {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border: none;
        border-radius: 20px 20px 0 0 !important;
        padding: 1.5rem;
    }
    
    .card-header-modern h5 {
        color: #1a1a1a;
        font-weight: 700;
        margin: 0;
    }
    
    .table-modern {
        margin: 0;
    }
    
    .table-modern thead {
        background: #f8f9fa;
    }
    
    .table-modern thead th {
        border: none;
        color: #2a2a2a;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem;
    }
    
    .table-modern tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .table-modern tbody tr:hover {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.05) 0%, rgba(159, 232, 105, 0.05) 100%);
    }
    
    .table-modern tbody td {
        padding: 1rem;
        vertical-align: middle;
        border: none;
    }
    
    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    
    .badge-success-modern {
        background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
        color: white;
    }
    
    .transaction-id {
        color: #5a8e2a;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .transaction-id:hover {
        color: #C4FF57;
    }
    
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }
    
    .empty-state-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
    }
    
    .empty-state-text {
        color: #6c757d;
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }
</style>

<div class="page-header-modern">
    <h1>
        <i class="fas fa-hand-wave me-2"></i>
        Selamat Datang, {{ auth()->user()->name }}!
    </h1>
    <p>Kelola transaksi, wallet, dan belanja online Anda dengan mudah</p>
</div>

<!-- Quick Actions -->
<div class="row mb-4 g-4">
    <div class="col-md-4">
        <a href="{{ route('pelanggan.wallet.index') }}" class="action-card-modern action-card-wallet">
            <div class="action-card-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <h5 class="action-card-title">KiWallet</h5>
            <p class="action-card-text">Kelola saldo dompet digital Anda dengan praktis</p>
            <span class="action-card-button">
                <i class="fas fa-arrow-right"></i> Buka Wallet
            </span>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('pelanggan.shop') }}" class="action-card-modern action-card-shop">
            <div class="action-card-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h5 class="action-card-title">Belanja Online</h5>
            <p class="action-card-text">Lihat produk dan lakukan pembelian dengan mudah</p>
            <span class="action-card-button">
                <i class="fas fa-arrow-right"></i> Mulai Belanja
            </span>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('pelanggan.transactions') }}" class="action-card-modern action-card-history">
            <div class="action-card-icon">
                <i class="fas fa-history"></i>
            </div>
            <h5 class="action-card-title">Riwayat Transaksi</h5>
            <p class="action-card-text">Lihat semua transaksi pembelian Anda</p>
            <span class="action-card-button">
                <i class="fas fa-arrow-right"></i> Lihat Riwayat
            </span>
        </a>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card recent-transactions-card">
    <div class="card-header card-header-modern">
        <h5>
            <i class="fas fa-receipt me-2"></i> Transaksi Terbaru
        </h5>
    </div>
    <div class="card-body p-0">
        @if(!empty($recentTransactions) && count($recentTransactions) > 0)
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                        <tr>
                            <td>
                                <a href="{{ route('pelanggan.transactions') }}" class="transaction-id">
                                    #{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}
                                </a>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $transaction->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <small>
                                    @foreach($transaction->saleItems as $item)
                                        @if($item->item)
                                            <span class="d-inline-block">
                                                {{ $item->item->name }} <span class="badge bg-secondary">{{ $item->quantity }}x</span>
                                            </span>
                                            @if(!$loop->last)<br>@endif
                                        @else
                                            <span class="text-muted">[Item dihapus]</span>
                                            @if(!$loop->last)<br>@endif
                                        @endif
                                    @endforeach
                                </small>
                            </td>
                            <td>
                                <strong style="color: #5a8e2a;">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                <span class="badge badge-modern badge-success-modern">
                                    <i class="fas fa-check-circle me-1"></i>Selesai
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <p class="empty-state-text">Belum ada transaksi</p>
                <a href="{{ route('pelanggan.shop') }}" class="btn btn-modern-primary">
                    <i class="fas fa-shopping-cart me-2"></i> Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
