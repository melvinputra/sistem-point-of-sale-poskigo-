@extends('layouts.kasir')

@section('title', 'Detail Pesanan - POSKigo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-file-invoice me-2"></i> Detail Pesanan Online</h2>
    <div>
        <a href="{{ route('kasir.sales.show', $order->id) }}" class="btn btn-secondary" target="_blank">
            <i class="fas fa-print me-2"></i> Cetak Struk
        </a>
        <a href="{{ route('kasir.online-orders') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- Kode Pickup & Status -->
    <div class="col-md-4 mb-4">
        <div class="card border-primary shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-qrcode me-2"></i> Kode Pickup</h5>
            </div>
            <div class="card-body text-center">
                <div class="p-4 bg-light rounded mb-3">
                    <h1 class="mb-0" style="font-family: 'Courier New', monospace; letter-spacing: 2px;">
                        {{ $order->pickup_code }}
                    </h1>
                </div>
                
                @if($order->order_status == 'pending')
                    <span class="badge bg-warning text-dark fs-5 p-3">
                        <i class="fas fa-clock me-2"></i> Menunggu Persiapan
                    </span>
                @elseif($order->order_status == 'ready')
                    <span class="badge bg-success fs-5 p-3">
                        <i class="fas fa-check-circle me-2"></i> Siap Diambil
                    </span>
                @elseif($order->order_status == 'completed')
                    <span class="badge bg-info fs-5 p-3">
                        <i class="fas fa-flag-checkered me-2"></i> Selesai
                    </span>
                @elseif($order->order_status == 'cancelled')
                    <span class="badge bg-danger fs-5 p-3">
                        <i class="fas fa-times-circle me-2"></i> Dibatalkan
                    </span>
                @endif

                <hr>

                <div class="text-start">
                    <small class="text-muted d-block mb-1">
                        <i class="fas fa-calendar me-1"></i> Dipesan: {{ $order->created_at->format('d/m/Y H:i') }}
                    </small>
                    @if($order->prepared_at)
                    <small class="text-muted d-block mb-1">
                        <i class="fas fa-box-open me-1"></i> Disiapkan: {{ $order->prepared_at->format('d/m/Y H:i') }}
                    </small>
                    @endif
                    @if($order->completed_at)
                    <small class="text-muted d-block">
                        <i class="fas fa-check me-1"></i> Diselesaikan: {{ $order->completed_at->format('d/m/Y H:i') }}
                    </small>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card mt-3 shadow-sm">
            <div class="card-body">
                @if($order->order_status == 'pending')
                    <form action="{{ route('kasir.online-orders.prepare', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mb-2" onclick="return confirm('Tandai pesanan ini sudah disiapkan?')">
                            <i class="fas fa-box-open me-2"></i> Siapkan Barang
                        </button>
                    </form>
                @elseif($order->order_status == 'ready')
                    <form action="{{ route('kasir.online-orders.complete', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 mb-2" onclick="return confirm('Konfirmasi barang sudah diserahkan ke pelanggan?')">
                            <i class="fas fa-hand-holding me-2"></i> Serahkan Barang
                        </button>
                    </form>
                @endif

                @if(in_array($order->order_status, ['pending', 'ready']))
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#cancelModal">
                        <i class="fas fa-times-circle me-2"></i> Batalkan Pesanan
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Detail Pesanan -->
    <div class="col-md-8">
        <!-- Informasi Pelanggan -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i> Informasi Pelanggan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Nama:</strong> {{ $order->customer->name }}</p>
                        <p class="mb-2"><strong>No. HP:</strong> {{ $order->customer->phone }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Email/Akun:</strong> {{ $order->user->email }}</p>
                        <p class="mb-2"><strong>Transaksi ID:</strong> #{{ $order->id }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Barang -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i> Detail Barang</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->saleItems as $item)
                            <tr>
                                <td>{{ $item->item->name }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $item->item->category->name }}</span>
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ringkasan Pembayaran -->
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Ringkasan Pembayaran</h5>
            </div>
            <div class="card-body">
                <table class="table mb-0">
                    <tr>
                        <td class="border-0"><strong>Subtotal:</strong></td>
                        <td class="border-0 text-end">Rp {{ number_format($order->subtotal ?? $order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    @if($order->discount_amount > 0)
                    <tr>
                        <td class="border-0 text-success">
                            <strong>Diskon:</strong>
                            @if($order->promotion)
                                <small class="text-muted">({{ $order->promotion->code }})</small>
                            @endif
                        </td>
                        <td class="border-0 text-end text-success">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($order->tax_amount > 0)
                    <tr>
                        <td class="border-0"><strong>Pajak (10%):</strong></td>
                        <td class="border-0 text-end">Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr class="table-light">
                        <td class="border-0"><h5 class="mb-0">TOTAL:</h5></td>
                        <td class="border-0 text-end"><h5 class="mb-0 text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h5></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('kasir.online-orders.cancel', $order->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i> Batalkan Pesanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Stok barang akan dikembalikan.
                    </div>
                    <div class="mb-3">
                        <label for="cancel_reason" class="form-label">Alasan Pembatalan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="cancel_reason" name="cancel_reason" rows="3" required placeholder="Contoh: Pelanggan tidak datang, barang habis, dll"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Batalkan Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
