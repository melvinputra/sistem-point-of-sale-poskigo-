@extends('layouts.pelanggan')

@section('title', 'Konfirmasi Pesanan - POSKigo')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Success Message -->
        <div class="alert alert-success shadow-sm text-center" role="alert">
            <i class="fas fa-check-circle fa-3x mb-3"></i>
            <h3 class="mb-2">Pesanan Berhasil!</h3>
            <p class="mb-0">Terima kasih telah berbelanja di POSKigo</p>
        </div>

        <!-- Pickup Code Card -->
        <div class="card border-primary shadow-lg mb-4">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0"><i class="fas fa-qrcode me-2"></i> Kode Pickup Anda</h4>
            </div>
            <div class="card-body text-center p-5">
                <div class="bg-light p-4 rounded mb-3 border border-primary border-3">
                    <h1 class="display-3 mb-0 fw-bold text-primary" style="font-family: 'Courier New', monospace; letter-spacing: 3px;">
                        {{ $sale->pickup_code }}
                    </h1>
                </div>
                
                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Penting!</strong> Simpan atau screenshot kode ini untuk mengambil barang
                </div>

                <!-- Status Badge -->
                @if($sale->order_status == 'pending')
                    <span class="badge bg-warning text-dark fs-5 p-3">
                        <i class="fas fa-clock me-2"></i> Menunggu Persiapan
                    </span>
                @elseif($sale->order_status == 'ready')
                    <span class="badge bg-success fs-5 p-3">
                        <i class="fas fa-check-circle me-2"></i> Siap Diambil
                    </span>
                @endif
            </div>
        </div>

        <!-- Order Summary -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i> Ringkasan Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <small class="text-muted">Transaksi ID</small>
                        <p class="mb-0"><strong>#{{ $sale->id }}</strong></p>
                    </div>
                    <div class="col-6 text-end">
                        <small class="text-muted">Tanggal</small>
                        <p class="mb-0"><strong>{{ $sale->created_at->format('d/m/Y H:i') }}</strong></p>
                    </div>
                </div>

                <hr>

                <h6 class="mb-3"><i class="fas fa-shopping-bag me-2"></i> Detail Barang:</h6>
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
                            @foreach($sale->saleItems as $item)
                            <tr>
                                <td>{{ $item->item ? $item->item->name : '[Item dihapus]' }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr>

                <table class="table mb-0">
                    <tr>
                        <td class="border-0"><strong>Subtotal:</strong></td>
                        <td class="border-0 text-end">Rp {{ number_format($sale->subtotal ?? $sale->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    @if($sale->discount_amount > 0)
                    <tr>
                        <td class="border-0 text-success"><strong>Diskon:</strong></td>
                        <td class="border-0 text-end text-success">- Rp {{ number_format($sale->discount_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($sale->tax_amount > 0)
                    <tr>
                        <td class="border-0"><strong>Pajak:</strong></td>
                        <td class="border-0 text-end">Rp {{ number_format($sale->tax_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr class="table-light">
                        <td class="border-0"><h5 class="mb-0">TOTAL:</h5></td>
                        <td class="border-0 text-end"><h5 class="mb-0 text-primary">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</h5></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Instructions -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i> Cara Mengambil Barang</h5>
            </div>
            <div class="card-body">
                <ol class="mb-0">
                    <li class="mb-2">
                        <strong>Datang ke Toko POSKigo</strong>
                        <p class="text-muted mb-0">Kunjungi toko kami di alamat yang tertera</p>
                    </li>
                    <li class="mb-2">
                        <strong>Tunjukkan Kode Pickup</strong>
                        <p class="text-muted mb-0">Tunjukkan kode <strong class="text-primary">{{ $sale->pickup_code }}</strong> ke kasir</p>
                    </li>
                    <li class="mb-2">
                        <strong>Tunggu Konfirmasi</strong>
                        <p class="text-muted mb-0">Kasir akan memverifikasi identitas Anda</p>
                    </li>
                    <li class="mb-0">
                        <strong>Ambil Barang</strong>
                        <p class="text-muted mb-0">Terima barang Anda dan pastikan sesuai pesanan</p>
                    </li>
                </ol>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-grid gap-2 mb-4">
            <a href="{{ route('pelanggan.transactions') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-history me-2"></i> Lihat Riwayat Transaksi
            </a>
            <a href="{{ route('pelanggan.shop') }}" class="btn btn-outline-primary">
                <i class="fas fa-shopping-cart me-2"></i> Belanja Lagi
            </a>
        </div>

        <!-- Contact Info -->
        <div class="alert alert-light text-center">
            <p class="mb-1"><i class="fas fa-phone me-2"></i> Butuh bantuan? Hubungi kami:</p>
            <p class="mb-0"><strong>WhatsApp: 0812-3456-7890</strong></p>
        </div>
    </div>
</div>
@endsection
