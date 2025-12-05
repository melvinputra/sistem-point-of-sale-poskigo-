@extends('layouts.pelanggan')

@section('title', 'KiWallet - POSKigo')

@section('content')
<style>
    .page-header-modern {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 16px rgba(196, 255, 87, 0.15);
    }
    
    .page-header-modern h1 {
        color: #1a1a1a;
        font-weight: 700;
        font-size: 1.75rem;
        margin: 0;
    }
    
    .wallet-balance-card {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        border: none;
        border-radius: 20px;
        padding: 2.5rem;
        color: white;
        box-shadow: 0 12px 30px rgba(255, 193, 7, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .wallet-balance-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .wallet-balance-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 40px rgba(255, 193, 7, 0.4);
    }
    
    .wallet-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.9;
    }
    
    .balance-label {
        font-size: 1rem;
        opacity: 0.9;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .balance-amount {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .btn-topup {
        background: white;
        color: #ff9800;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
    }
    
    .btn-topup:hover {
        background: #1a1a1a;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
        color: white;
    }
    
    .info-card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        height: 100%;
    }
    
    .info-list-item {
        padding: 0.75rem 0;
        display: flex;
        align-items: start;
        gap: 0.75rem;
    }
    
    .info-list-item i {
        color: #4caf50;
        font-size: 1.25rem;
        margin-top: 0.25rem;
    }
    
    .history-card {
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
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .badge-pending {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: #1a1a1a;
    }
    
    .badge-approved {
        background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
        color: white;
    }
    
    .badge-rejected {
        background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        color: white;
    }
    
    .payment-method-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        color: #5a8e2a;
        margin-right: 0.5rem;
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
</style>

<div class="page-header-modern">
    <h1>
        <i class="fas fa-wallet me-2"></i>
        KiWallet - Dompet Digital
    </h1>
</div>

<!-- Saldo & Info Cards -->
<div class="row mb-4 g-4">
    <div class="col-md-6">
        <div class="wallet-balance-card">
            <div class="wallet-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="balance-label">Saldo Anda</div>
            <div class="balance-amount">Rp {{ number_format($wallet->balance, 0, ',', '.') }}</div>
            <a href="{{ route('pelanggan.wallet.topup') }}" class="btn btn-topup">
                <i class="fas fa-plus-circle me-2"></i> Top-Up Saldo
            </a>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="info-card-modern">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-info-circle me-2" style="color: #5a8e2a;"></i>
                    Informasi KiWallet
                </h5>
                <div class="info-list-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Saldo dapat digunakan untuk belanja di toko</span>
                </div>
                <div class="info-list-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Top-up minimal Rp 10.000</span>
                </div>
                <div class="info-list-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Proses verifikasi maksimal 1x24 jam</span>
                </div>
                <div class="info-list-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Saldo tidak memiliki masa berlaku</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- History Top-Up -->
<div class="card history-card">
    <div class="card-header card-header-modern">
        <h5>
            <i class="fas fa-history me-2"></i> Riwayat Top-Up
        </h5>
    </div>
    <div class="card-body p-0">
        @if(!empty($topupHistory) && count($topupHistory) > 0)
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Metode Pembayaran</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topupHistory as $history)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $history->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $history->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <strong style="color: #5a8e2a;">
                                    Rp {{ number_format($history->amount, 0, ',', '.') }}
                                </strong>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="payment-method-icon">
                                        @if($history->payment_method == 'transfer')
                                            <i class="fas fa-university"></i>
                                        @elseif($history->payment_method == 'cash')
                                            <i class="fas fa-money-bill"></i>
                                        @else
                                            <i class="fas fa-mobile-alt"></i>
                                        @endif
                                    </div>
                                    <div>
                                        @if($history->payment_method == 'transfer')
                                            Transfer Bank
                                        @elseif($history->payment_method == 'cash')
                                            Tunai
                                        @else
                                            E-Wallet
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($history->status == 'pending')
                                    <span class="badge badge-modern badge-pending">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                @elseif($history->status == 'approved')
                                    <span class="badge badge-modern badge-approved">
                                        <i class="fas fa-check-circle"></i> Disetujui
                                    </span>
                                @else
                                    <span class="badge badge-modern badge-rejected">
                                        <i class="fas fa-times-circle"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($history->status == 'approved')
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        {{ $history->approved_at ? $history->approved_at->format('d/m/Y H:i') : '-' }}
                                    </small>
                                @elseif($history->status == 'rejected')
                                    <small class="text-danger">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $history->admin_notes }}
                                    </small>
                                @else
                                    <small class="text-muted">
                                        <i class="fas fa-hourglass-half me-1"></i>
                                        Menunggu verifikasi admin
                                    </small>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $topupHistory->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h5 class="text-muted mb-2">Belum ada riwayat top-up</h5>
                <p class="text-muted mb-4">Mulai top-up saldo untuk mulai berbelanja</p>
                <a href="{{ route('pelanggan.wallet.topup') }}" class="btn btn-modern-primary">
                    <i class="fas fa-plus-circle me-2"></i> Top-Up Sekarang
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
