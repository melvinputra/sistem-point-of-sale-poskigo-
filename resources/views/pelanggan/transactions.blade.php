@extends('layouts.pelanggan')

@section('title', 'Riwayat Transaksi - POSKigo')

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
    
    .transaction-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .transaction-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }
    
    .transaction-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem;
        border-bottom: 2px solid #dee2e6;
    }
    
    .transaction-id {
        font-weight: 800;
        font-size: 1.1rem;
        color: #1a1a1a;
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
    
    .badge-online {
        background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
        color: white;
    }
    
    .badge-kasir {
        background: linear-gradient(135deg, #9e9e9e 0%, #757575 100%);
        color: white;
    }
    
    .badge-pending {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: #1a1a1a;
    }
    
    .badge-ready {
        background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
        color: white;
    }
    
    .badge-completed {
        background: linear-gradient(135deg, #00bcd4 0%, #0097a7 100%);
        color: white;
    }
    
    .badge-cancelled {
        background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        color: white;
    }
    
    .pickup-code {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        color: #1a1a1a;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-weight: 800;
        font-size: 1.25rem;
        display: inline-block;
        margin-top: 0.5rem;
        box-shadow: 0 4px 12px rgba(196, 255, 87, 0.3);
    }
    
    .transaction-body {
        padding: 1.5rem;
    }
    
    .section-title {
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
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
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        padding: 0.75rem;
    }
    
    .table-modern tbody tr {
        border-bottom: 1px solid #f0f0f0;
    }
    
    .table-modern tbody td {
        padding: 0.75rem;
        vertical-align: middle;
        border: none;
    }
    
    .promo-alert {
        background: linear-gradient(135deg, rgba(33, 150, 243, 0.1) 0%, rgba(25, 118, 210, 0.1) 100%);
        border: 2px solid #2196f3;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        color: #1976d2;
        font-weight: 600;
    }
    
    .summary-table {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1rem;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #dee2e6;
    }
    
    .summary-row:last-child {
        border-bottom: none;
    }
    
    .summary-total {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 0.5rem;
    }
    
    .summary-total .summary-row {
        border: none;
        font-weight: 800;
        font-size: 1.25rem;
        color: #1a1a1a;
    }
    
    .empty-state {
        background: white;
        border-radius: 20px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .empty-state-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
    }
</style>

<div class="page-header-modern">
    <h1>
        <i class="fas fa-receipt me-2"></i>
        Riwayat Transaksi
    </h1>
</div>

@if(isset($transactions) && !empty($transactions) && count($transactions) > 0)
    @foreach($transactions as $transaction)
    <div class="transaction-card">
        <div class="transaction-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="transaction-id">
                        <i class="fas fa-hashtag me-1"></i>{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}
                    </div>
                    
                    @if($transaction->order_type == 'online' && $transaction->pickup_code)
                        <span class="badge-modern badge-online mt-2">
                            <i class="fas fa-shopping-cart"></i> Pesanan Online
                        </span>
                        <div class="pickup-code mt-2">
                            <i class="fas fa-qrcode me-2"></i>{{ $transaction->pickup_code }}
                        </div>
                    @else
                        <span class="badge-modern badge-kasir mt-2">
                            <i class="fas fa-store"></i> Transaksi Kasir
                        </span>
                    @endif
                    
                    <div class="text-muted mt-2">
                        <i class="fas fa-calendar me-1"></i> 
                        <small>{{ $transaction->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
                <div class="text-end">
                    @if($transaction->order_type == 'online')
                        @if($transaction->order_status == 'pending')
                            <span class="badge-modern badge-pending">
                                <i class="fas fa-clock"></i> Menunggu Persiapan
                            </span>
                        @elseif($transaction->order_status == 'ready')
                            <span class="badge-modern badge-ready">
                                <i class="fas fa-check-circle"></i> Siap Diambil
                            </span>
                        @elseif($transaction->order_status == 'completed')
                            <span class="badge-modern badge-completed">
                                <i class="fas fa-flag-checkered"></i> Selesai
                            </span>
                        @elseif($transaction->order_status == 'cancelled')
                            <span class="badge-modern badge-cancelled">
                                <i class="fas fa-times-circle"></i> Dibatalkan
                            </span>
                        @endif
                    @else
                        <span class="badge-modern badge-completed">
                            <i class="fas fa-check-circle"></i> Selesai
                        </span>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="transaction-body">
            <h6 class="section-title">
                <i class="fas fa-shopping-bag"></i> Detail Barang
            </h6>
            
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->saleItems as $item)
                        <tr>
                            <td>
                                <div class="fw-semibold">
                                    {{ $item->item ? $item->item->name : '[Item dihapus]' }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $item->quantity }}x</span>
                            </td>
                            <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    @if($transaction->promotion)
                    <div class="promo-alert">
                        <i class="fas fa-tag me-2"></i> 
                        <strong>Promo:</strong> {{ $transaction->promotion->code }}
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="summary-table">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span class="fw-semibold">Rp {{ number_format($transaction->subtotal ?? $transaction->total_amount, 0, ',', '.') }}</span>
                        </div>
                        @if($transaction->discount_amount > 0)
                        <div class="summary-row text-success">
                            <span><i class="fas fa-percentage me-1"></i>Diskon:</span>
                            <span class="fw-semibold">- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        @if($transaction->tax_amount > 0)
                        <div class="summary-row">
                            <span><i class="fas fa-receipt me-1"></i>Pajak:</span>
                            <span class="fw-semibold">Rp {{ number_format($transaction->tax_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="summary-total">
                        <div class="summary-row">
                            <span>TOTAL:</span>
                            <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Pagination -->
    @if($transactions->hasPages())
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
    @endif
@else
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-inbox"></i>
        </div>
        <h5 class="text-muted mb-2">Belum ada transaksi</h5>
        <p class="text-muted mb-4">Mulai belanja untuk melihat riwayat transaksi Anda</p>
        <a href="{{ route('pelanggan.shop') }}" class="btn btn-modern-primary">
            <i class="fas fa-shopping-cart me-2"></i> Mulai Belanja
        </a>
    </div>
@endif
@endsection
