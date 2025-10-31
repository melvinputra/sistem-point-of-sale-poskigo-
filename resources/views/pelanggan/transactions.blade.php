@extends('layouts.pelanggan')

@section('title', 'Riwayat Transaksi - POSKigo')

@section('content')
<h2 class="mb-4">Riwayat Transaksi</h2>

<div class="card">
    <div class="card-body">
        @if(isset($transactions) && !empty($transactions) && count($transactions) > 0)
            @foreach($transactions as $transaction)
            <div class="card mb-3 border">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Transaksi #{{ $transaction->id }}</strong>
                        
                        @if($transaction->order_type == 'online' && $transaction->pickup_code)
                            <span class="badge bg-info ms-2">
                                <i class="fas fa-shopping-cart me-1"></i> Online
                            </span>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-qrcode me-1"></i> Kode Pickup: 
                                <strong class="text-primary">{{ $transaction->pickup_code }}</strong>
                            </small>
                        @else
                            <span class="badge bg-secondary ms-2">
                                <i class="fas fa-store me-1"></i> Kasir
                            </span>
                        @endif
                        
                        <br>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i> {{ $transaction->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    <div class="text-end">
                        @if($transaction->order_type == 'online')
                            @if($transaction->order_status == 'pending')
                                <span class="badge bg-warning text-dark mb-1">
                                    <i class="fas fa-clock me-1"></i> Menunggu Persiapan
                                </span>
                            @elseif($transaction->order_status == 'ready')
                                <span class="badge bg-success mb-1">
                                    <i class="fas fa-check-circle me-1"></i> Siap Diambil
                                </span>
                            @elseif($transaction->order_status == 'completed')
                                <span class="badge bg-info mb-1">
                                    <i class="fas fa-flag-checkered me-1"></i> Selesai
                                </span>
                            @elseif($transaction->order_status == 'cancelled')
                                <span class="badge bg-danger mb-1">
                                    <i class="fas fa-times-circle me-1"></i> Dibatalkan
                                </span>
                            @endif
                        @else
                            <span class="badge bg-success mb-1">Selesai</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-3"><i class="fas fa-shopping-bag me-1"></i> Detail Barang:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
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
                                    <td>{{ $item->item->name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            @if($transaction->promotion)
                            <div class="alert alert-info py-2 mb-2">
                                <small><i class="fas fa-tag me-1"></i> Promo: {{ $transaction->promotion->code }}</small>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm mb-0">
                                <tr>
                                    <td class="text-end border-0"><strong>Subtotal:</strong></td>
                                    <td class="text-end border-0">Rp {{ number_format($transaction->subtotal ?? $transaction->total_amount, 0, ',', '.') }}</td>
                                </tr>
                                @if($transaction->discount_amount > 0)
                                <tr>
                                    <td class="text-end border-0 text-success"><strong>Diskon:</strong></td>
                                    <td class="text-end border-0 text-success">- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                @if($transaction->tax_amount > 0)
                                <tr>
                                    <td class="text-end border-0"><strong>Pajak:</strong></td>
                                    <td class="text-end border-0">Rp {{ number_format($transaction->tax_amount, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-end border-0"><strong>TOTAL:</strong></td>
                                    <td class="text-end border-0"><strong class="text-primary fs-5">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-3">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada transaksi</h5>
                <p class="text-muted">Mulai belanja untuk melihat riwayat transaksi Anda</p>
                <a href="{{ route('pelanggan.shop') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-cart me-2"></i> Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
