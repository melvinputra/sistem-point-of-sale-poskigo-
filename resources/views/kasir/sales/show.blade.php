@extends('layouts.kasir')

@section('title', 'Detail Transaksi - POSKigo')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="page-header-modern">
        <div>
            <h1 class="page-title-modern">
                <i class="fas fa-receipt me-2"></i>
                Detail Transaksi #{{ $sale->id }}
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb-modern">
                    <li class="breadcrumb-item"><a href="{{ route('kasir.dashboard') }}"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kasir.sales.index') }}">Riwayat Transaksi</a></li>
                    <li class="breadcrumb-item active">Detail #{{ $sale->id }}</li>
                </ol>
            </nav>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('kasir.sales.index') }}" class="btn btn-outline-secondary btn-modern">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali
            </a>
            <button onclick="printReceipt()" class="btn btn-gradient-primary btn-modern">
                <i class="fas fa-print me-2"></i>
                Cetak Struk
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Transaction Info -->
        <div class="col-lg-8">
            <!-- Info Card -->
            <div class="card card-modern mb-4">
                <div class="card-header-modern">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper-modern bg-gradient-primary me-3">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Informasi Transaksi</h5>
                            <small class="text-muted">Detail lengkap transaksi penjualan</small>
                        </div>
                    </div>
                </div>
                <div class="card-body card-body-modern">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-item-modern">
                                <label class="info-label-modern">ID Transaksi</label>
                                <div class="info-value-modern">
                                    <span class="badge-modern badge-primary-modern">
                                        <i class="fas fa-hashtag me-1"></i>
                                        TRX-{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item-modern">
                                <label class="info-label-modern">Tanggal & Waktu</label>
                                <div class="info-value-modern">
                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                    {{ $sale->created_at->format('d F Y, H:i') }} WIB
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item-modern">
                                <label class="info-label-modern">Kasir</label>
                                <div class="info-value-modern">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle-modern bg-gradient-primary me-2">
                                            {{ strtoupper(substr($sale->user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-semibold">{{ $sale->user->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item-modern">
                                <label class="info-label-modern">Pelanggan</label>
                                <div class="info-value-modern">
                                    @if($sale->customer)
                                        <div>
                                            <div class="fw-semibold">{{ $sale->customer->name }}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-phone me-1"></i>{{ $sale->customer->phone }}
                                            </small>
                                        </div>
                                    @else
                                        <span class="badge-modern badge-secondary-modern">
                                            <i class="fas fa-user me-1"></i>Umum
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="card card-modern mb-4">
                <div class="card-header-modern">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper-modern bg-gradient-info me-3">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Detail Barang</h5>
                            <small class="text-muted">{{ $sale->saleItems->count() }} jenis barang ({{ $sale->saleItems->sum('quantity') }} pcs)</small>
                        </div>
                    </div>
                </div>
                <div class="card-body card-body-modern p-0">
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Barang</th>
                                    <th width="150" class="text-end">Harga</th>
                                    <th width="100" class="text-center">Qty</th>
                                    <th width="180" class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->saleItems as $index => $item)
                                <tr>
                                    <td>
                                        <div class="number-badge-modern">{{ $index + 1 }}</div>
                                    </td>
                                    <td>
                                        <div class="item-name-modern">{{ $item->item ? $item->item->name : '[Item dihapus]' }}</div>
                                        <div class="item-category-modern">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ $item->item && $item->item->category ? $item->item->category->name : '-' }}
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <span class="price-text-modern">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="qty-badge-modern">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="subtotal-text-modern">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer-modern">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">TOTAL PEMBAYARAN:</h5>
                        <h3 class="mb-0 total-amount-footer">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Sidebar -->
        <div class="col-lg-4">
            <!-- Summary Card -->
            <div class="card card-modern mb-4 summary-card-modern">
                <div class="card-header-modern bg-gradient-success">
                    <div class="d-flex align-items-center text-white">
                        <div class="icon-wrapper-white me-3">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">Ringkasan</h5>
                            <small class="text-white-50">Total pembayaran</small>
                        </div>
                    </div>
                </div>
                <div class="card-body card-body-modern">
                    <div class="summary-item-modern">
                        <div class="summary-icon-modern bg-info">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="summary-content-modern">
                            <label>Jumlah Jenis Item</label>
                            <div class="summary-value-modern">{{ $sale->saleItems->count() }} Jenis</div>
                        </div>
                    </div>
                    
                    <div class="summary-item-modern">
                        <div class="summary-icon-modern bg-warning">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <div class="summary-content-modern">
                            <label>Total Quantity</label>
                            <div class="summary-value-modern">{{ $sale->saleItems->sum('quantity') }} Pcs</div>
                        </div>
                    </div>
                    
                    <div class="summary-divider-modern"></div>
                    
                    <div class="summary-total-modern">
                        <label>Total Pembayaran</label>
                        <div class="total-value-modern">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            @if($sale->customer)
            <!-- Customer Info Card -->
            <div class="card card-modern">
                <div class="card-header-modern">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper-modern bg-gradient-info me-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Info Pelanggan</h5>
                            <small class="text-muted">Data pelanggan</small>
                        </div>
                    </div>
                </div>
                <div class="card-body card-body-modern">
                    <div class="customer-info-modern">
                        <div class="customer-avatar-modern">
                            {{ strtoupper(substr($sale->customer->name, 0, 2)) }}
                        </div>
                        <div class="customer-details-modern">
                            <h6 class="mb-2 fw-bold">{{ $sale->customer->name }}</h6>
                            <div class="customer-contact-modern">
                                <i class="fas fa-phone me-2"></i>
                                <span>{{ $sale->customer->phone }}</span>
                            </div>
                            @if($sale->customer->address)
                            <div class="customer-contact-modern">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <span>{{ $sale->customer->address }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
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
    .page-header-modern {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .page-title-modern {
        font-size: 1.75rem;
        font-weight: 800;
        color: #2a2a2a;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .page-title-modern i {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .breadcrumb-modern {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .breadcrumb-modern .breadcrumb-item {
        color: #6c757d;
    }

    .breadcrumb-modern .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        padding-right: 0.5rem;
        color: #adb5bd;
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-modern .breadcrumb-item a:hover {
        color: var(--dark-green);
    }

    .breadcrumb-modern .breadcrumb-item.active {
        color: var(--dark-green);
        font-weight: 600;
    }

    .page-header-actions {
        display: flex;
        gap: 0.75rem;
    }

    .card-modern {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .card-header-modern {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-bottom: 2px solid #f0f0f0;
        padding: 1.5rem 2rem;
    }

    .card-header-modern.bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        border-bottom: none;
    }

    .icon-wrapper-modern {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #2a2a2a;
    }

    .icon-wrapper-white {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: rgba(255,255,255,0.2);
    }

    .bg-gradient-primary {
        background: var(--gradient-primary);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
    }

    .card-body-modern {
        padding: 2rem;
    }

    .card-footer-modern {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-top: 2px solid #dee2e6;
        padding: 1.5rem 2rem;
    }

    .total-amount-footer {
        font-weight: 800;
        color: #2a2a2a;
        font-size: 2rem;
    }

    .info-item-modern {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 12px;
        height: 100%;
    }

    .info-label-modern {
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    .info-value-modern {
        font-size: 0.95rem;
        color: #2a2a2a;
        font-weight: 500;
    }

    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
    }

    .badge-primary-modern {
        background: var(--gradient-primary);
        color: #2a2a2a;
    }

    .badge-secondary-modern {
        background: #e9ecef;
        color: #6c757d;
    }

    .avatar-circle-modern {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        color: #2a2a2a;
    }

    .table-modern {
        margin-bottom: 0;
    }

    .table-modern thead {
        background: #f8f9fa;
    }

    .table-modern thead th {
        padding: 1rem;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .table-modern tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .number-badge-modern {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: var(--gradient-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        color: #2a2a2a;
    }

    .item-name-modern {
        font-weight: 600;
        color: #2a2a2a;
        margin-bottom: 0.25rem;
    }

    .item-category-modern {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .price-text-modern {
        font-weight: 500;
        color: #495057;
    }

    .qty-badge-modern {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 45px;
        padding: 0.35rem 0.75rem;
        background: #e3f2fd;
        color: #1976d2;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .subtotal-text-modern {
        font-weight: 700;
        color: #2a2a2a;
        font-size: 1rem;
    }

    .total-row-modern {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .total-row-modern td {
        padding: 1.5rem 1rem !important;
        border-top: 2px solid #dee2e6 !important;
        border-bottom: none !important;
        font-size: 1rem;
    }

    .total-amount-modern {
        font-size: 1.5rem;
        font-weight: 800;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .summary-card-modern {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    }

    .summary-item-modern {
        display: flex;
        align-items: center;
        padding: 1.25rem;
        background: #f8f9fa;
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    .summary-icon-modern {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .summary-content-modern {
        flex: 1;
    }

    .summary-content-modern label {
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.25rem;
        display: block;
    }

    .summary-value-modern {
        font-size: 1.25rem;
        font-weight: 800;
        color: #2a2a2a;
    }

    .summary-divider-modern {
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, #dee2e6 50%, transparent 100%);
        margin: 1.5rem 0;
    }

    .summary-total-modern {
        text-align: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(196,255,87,0.1) 0%, rgba(159,232,105,0.1) 100%);
        border-radius: 12px;
    }

    .summary-total-modern label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    .total-value-modern {
        font-size: 2rem;
        font-weight: 800;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .customer-info-modern {
        display: flex;
        gap: 1.25rem;
    }

    .customer-avatar-modern {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.5rem;
        color: #2a2a2a;
        flex-shrink: 0;
    }

    .customer-details-modern {
        flex: 1;
    }

    .customer-contact-modern {
        color: #6c757d;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .btn-modern {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid;
    }

    .btn-gradient-primary {
        background: var(--gradient-primary);
        border-color: transparent;
        color: #2a2a2a;
    }

    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(196, 255, 87, 0.3);
        color: #1a1a1a;
    }

    .btn-outline-secondary {
        border-color: #dee2e6;
        color: #6c757d;
        background: white;
    }

    .btn-outline-secondary:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
        color: #495057;
    }

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
