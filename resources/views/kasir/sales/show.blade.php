@extends('layouts.kasir')

@section('title', 'Detail Transaksi - POSKigo')

@section('content')
<h1 class="mt-4">Detail Transaksi #{{ $sale->id }}</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('kasir.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('kasir.sales.index') }}">Riwayat Transaksi</a></li>
    <li class="breadcrumb-item active">Detail #{{ $sale->id }}</li>
</ol>

<div class="row">
    <!-- Transaction Info -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-info-circle me-1"></i> Informasi Transaksi
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>ID Transaksi:</strong><br>
                        <span class="badge bg-primary">#{{ $sale->id }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal & Waktu:</strong><br>
                        {{ $sale->created_at->format('d F Y, H:i') }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Kasir:</strong><br>
                        {{ $sale->user->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Pelanggan:</strong><br>
                        @if($sale->customer)
                            {{ $sale->customer->name }}<br>
                            <small class="text-muted">{{ $sale->customer->phone }}</small>
                        @else
                            <span class="badge bg-secondary">Umum</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <i class="fas fa-shopping-cart me-1"></i> Detail Barang
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->saleItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $item->item->name }}</strong><br>
                                    <small class="text-muted">{{ $item->item->category->name }}</small>
                                </td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $item->quantity }}</span>
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <td colspan="4" class="text-end"><strong>TOTAL:</strong></td>
                                <td><strong class="text-primary fs-5">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <a href="{{ route('kasir.sales.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <button onclick="printReceipt()" class="btn btn-primary">
                <i class="fas fa-print me-1"></i> Cetak Struk
            </button>
        </div>
    </div>

    <!-- Summary Sidebar -->
    <div class="col-md-4">
        <div class="card mb-4 bg-light">
            <div class="card-header bg-success text-white">
                <i class="fas fa-calculator me-1"></i> Ringkasan
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Jumlah Item</small>
                    <h4>{{ $sale->saleItems->count() }} Jenis</h4>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Total Quantity</small>
                    <h4>{{ $sale->saleItems->sum('quantity') }} pcs</h4>
                </div>
                <hr>
                <div class="mb-0">
                    <small class="text-muted">Total Pembayaran</small>
                    <h3 class="text-success mb-0">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        @if($sale->customer)
        <div class="card">
            <div class="card-header bg-info text-white">
                <i class="fas fa-user me-1"></i> Info Pelanggan
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>{{ $sale->customer->name }}</strong></p>
                <p class="mb-1 text-muted">
                    <i class="fas fa-phone me-1"></i> {{ $sale->customer->phone }}
                </p>
                @if($sale->customer->address)
                <p class="mb-0 text-muted">
                    <i class="fas fa-map-marker-alt me-1"></i> {{ $sale->customer->address }}
                </p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Receipt Print Area -->
<div id="receiptPrint" style="display: none;">
    <div style="width: 80mm; font-family: 'Courier New', monospace; font-size: 11px; margin: 0 auto; padding: 5mm;">
        <!-- Header -->
        <div style="text-align: center; border-bottom: 2px dashed #000; padding-bottom: 8px; margin-bottom: 8px;">
            <h3 style="margin: 0; font-size: 16px; font-weight: bold;">POSKIGO</h3>
            <p style="margin: 2px 0; font-size: 10px;">Point of Sales System</p>
            <p style="margin: 2px 0; font-size: 10px;">Jl. Contoh No. 123, Kota</p>
        </div>

        <!-- Info Transaksi -->
        <div style="margin-bottom: 8px;">
            <p style="margin: 2px 0; font-weight: bold; font-size: 11px;">INFORMASI TRANSAKSI</p>
            <table style="width: 100%; font-size: 10px;">
                <tr>
                    <td style="width: 45%;">No. Transaksi:</td>
                    <td>TRX-{{ str_pad($sale->id, 8, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td>Kasir:</td>
                    <td>{{ $sale->user->name }}</td>
                </tr>
                <tr>
                    <td>Pelanggan:</td>
                    <td>{{ $sale->customer ? $sale->customer->name : 'Umum' }}</td>
                </tr>
                @if($sale->customer && $sale->customer->phone)
                <tr>
                    <td>Telepon:</td>
                    <td>{{ $sale->customer->phone }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Detail Barang -->
        <div style="border-top: 2px dashed #000; padding-top: 8px; margin-bottom: 8px;">
            <p style="margin: 2px 0 6px 0; font-weight: bold; font-size: 11px;">DETAIL BARANG</p>
            
            @foreach($sale->saleItems as $item)
            <div style="margin-bottom: 6px;">
                <p style="margin: 0; font-weight: bold; font-size: 10px;">{{ $item->item->name }}</p>
                <p style="margin: 1px 0; font-size: 9px; color: #666;">Kategori: {{ $item->item->category->name }}</p>
                <table style="width: 100%; font-size: 10px;">
                    <tr>
                        <td>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
            @endforeach
        </div>

        <!-- Total -->
        <div style="border-top: 2px dashed #000; padding-top: 8px; margin-bottom: 8px;">
            <table style="width: 100%; font-size: 10px;">
                <tr>
                    <td>Subtotal:</td>
                    <td style="text-align: right;">Rp {{ number_format($sale->subtotal ?? $sale->total_amount, 0, ',', '.') }}</td>
                </tr>
                @if($sale->discount_amount > 0)
                <tr style="color: #28a745;">
                    <td>Diskon:</td>
                    <td style="text-align: right;">- Rp {{ number_format($sale->discount_amount, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($sale->tax_amount > 0)
                <tr>
                    <td>Pajak:</td>
                    <td style="text-align: right;">Rp {{ number_format($sale->tax_amount, 0, ',', '.') }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div style="border-top: 2px solid #000; padding-top: 5px; margin-bottom: 8px;">
            <table style="width: 100%; font-size: 12px; font-weight: bold;">
                <tr>
                    <td>TOTAL:</td>
                    <td style="text-align: right;">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <!-- Pembayaran -->
        <div style="margin-bottom: 8px;">
            <p style="margin: 2px 0; font-weight: bold; font-size: 11px;">PEMBAYARAN</p>
            <table style="width: 100%; font-size: 10px;">
                <tr>
                    <td style="width: 45%;">Metode:</td>
                    <td style="text-align: right;">TUNAI</td>
                </tr>
                @if($sale->cash_paid > 0)
                <tr>
                    <td>Dibayar:</td>
                    <td style="text-align: right;">Rp {{ number_format($sale->cash_paid, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Kembalian:</td>
                    <td style="text-align: right;">Rp {{ number_format($sale->change_amount ?? 0, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr>
                    <td>Status:</td>
                    <td style="text-align: right; font-weight: bold;">LUNAS</td>
                </tr>
            </table>
        </div>

        <!-- Verifikasi -->
        <div style="border-top: 2px dashed #000; padding-top: 8px; margin-bottom: 8px;">
            <p style="margin: 2px 0; font-weight: bold; font-size: 11px;">VERIFIKASI</p>
            <p style="margin: 2px 0; font-size: 10px;">Dilayani oleh: {{ $sale->user->name }} (Kasir)</p>
            <p style="margin: 2px 0; font-size: 10px;">Waktu: {{ $sale->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Footer -->
        <div style="border-top: 2px dashed #000; padding-top: 8px; text-align: center;">
            <p style="margin: 4px 0; font-weight: bold; font-size: 11px;">Terima Kasih!</p>
            <p style="margin: 2px 0; font-size: 9px;">Barang yang sudah dibeli tidak dapat</p>
            <p style="margin: 2px 0; font-size: 9px;">dikembalikan kecuali ada perjanjian</p>
            <p style="margin: 8px 0 0 0; font-size: 9px;">{{ now()->format('d M Y H:i:s') }}</p>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        @page {
            size: 80mm auto;
            margin: 0;
        }
        
        body {
            margin: 0;
            padding: 0;
        }
        
        body * {
            visibility: hidden;
        }
        
        #receiptPrint, #receiptPrint * {
            visibility: visible;
        }
        
        #receiptPrint {
            position: absolute;
            left: 0;
            top: 0;
            width: 80mm;
            display: block !important;
            margin: 0;
            padding: 0;
        }
        
        #receiptPrint > div {
            width: 80mm !important;
            padding: 5mm !important;
            margin: 0 !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
function printReceipt() {
    window.print();
}
</script>
@endpush
@endsection
