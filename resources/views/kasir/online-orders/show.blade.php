@extends('layouts.kasir')

@section('title', 'Detail Pesanan - POSKigo')

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

    .card-modern {
        background: #ffffff;
        border: 2px solid #f0f0f0;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card-modern:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .card-header-modern {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.15) 0%, rgba(159, 232, 105, 0.1) 100%);
        padding: 1.2rem 1.5rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .card-header-modern h5 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a1a;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .pickup-code-display {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.2) 0%, rgba(159, 232, 105, 0.15) 100%);
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .pickup-code-display h1 {
        font-family: 'Courier New', monospace;
        font-size: 3rem;
        font-weight: 800;
        letter-spacing: 5px;
        color: #5a8e2a;
        margin: 0;
    }

    .status-badge-large {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
    }

    .btn-modern-primary {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        color: #1a1a1a;
        padding: 0.7rem 1.5rem;
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

    .btn-modern-secondary {
        background: #6b7280;
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-modern-secondary:hover {
        background: #4b5563;
        color: white;
        transform: translateY(-2px);
    }

    .btn-modern-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-modern-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-modern-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-modern-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(239, 68, 68, 0.4);
        color: white;
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
        padding: 1rem;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table-modern tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
    }

    .timeline-item {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
        padding: 0.8rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .timeline-item:last-child {
        border-bottom: none;
    }

    .timeline-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.2) 0%, rgba(159, 232, 105, 0.15) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #5a8e2a;
        flex-shrink: 0;
    }
</style>

<div class="page-header-modern">
    <div>
        <h1>
            <i class="fas fa-file-invoice"></i>
            Detail Pesanan Online
        </h1>
    </div>
    <div class="d-flex gap-2">
        <button onclick="printReceipt()" class="btn btn-modern-primary">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
        <a href="{{ route('kasir.online-orders') }}" class="btn btn-modern-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Kode Pickup & Status -->
    <div class="col-md-4">
        <div class="card-modern">
            <div class="card-header-modern">
                <h5>
                    <i class="fas fa-qrcode"></i> Kode Pickup
                </h5>
            </div>
            <div class="p-4">
                <div class="pickup-code-display">
                    <h1>{{ $order->pickup_code }}</h1>
                </div>
                
                <div class="text-center mb-3">
                    @if($order->order_status == 'pending')
                        <span class="status-badge-large bg-warning text-dark">
                            <i class="fas fa-clock"></i> Menunggu Persiapan
                        </span>
                    @elseif($order->order_status == 'ready')
                        <span class="status-badge-large bg-success text-white">
                            <i class="fas fa-check-circle"></i> Siap Diambil
                        </span>
                    @elseif($order->order_status == 'completed')
                        <span class="status-badge-large bg-info text-white">
                            <i class="fas fa-flag-checkered"></i> Selesai
                        </span>
                    @elseif($order->order_status == 'cancelled')
                        <span class="status-badge-large bg-danger text-white">
                            <i class="fas fa-times-circle"></i> Dibatalkan
                        </span>
                    @endif
                </div>

                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div>
                        <strong>Dipesan</strong><br>
                        <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
                @if($order->prepared_at)
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div>
                        <strong>Disiapkan</strong><br>
                        <small class="text-muted">{{ $order->prepared_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
                @endif
                @if($order->completed_at)
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <strong>Diselesaikan</strong><br>
                        <small class="text-muted">{{ $order->completed_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="card-modern">
            <div class="card-header-modern">
                <h5>
                    <i class="fas fa-cog"></i> Aksi
                </h5>
            </div>
            <div class="p-3">
                @if($order->order_status == 'pending')
                    <form action="{{ route('kasir.online-orders.prepare', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-modern-success w-100 mb-2" onclick="return confirm('Tandai pesanan ini sudah disiapkan?')">
                            <i class="fas fa-box-open"></i> Siapkan Barang
                        </button>
                    </form>
                @elseif($order->order_status == 'ready')
                    <form action="{{ route('kasir.online-orders.complete', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-modern-primary w-100 mb-2" onclick="return confirm('Konfirmasi barang sudah diserahkan ke pelanggan?')">
                            <i class="fas fa-hand-holding"></i> Serahkan Barang
                        </button>
                    </form>
                @endif

                @if(in_array($order->order_status, ['pending', 'ready']))
                    <button type="button" class="btn btn-modern-danger w-100" data-bs-toggle="modal" data-bs-target="#cancelModal">
                        <i class="fas fa-times-circle"></i> Batalkan Pesanan
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Detail Pesanan -->
    <div class="col-md-8">
        <!-- Informasi Pelanggan -->
        <div class="card-modern">
            <div class="card-header-modern">
                <h5>
                    <i class="fas fa-user"></i> Informasi Pelanggan
                </h5>
            </div>
            <div class="p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Nama Pelanggan</label>
                        <div class="d-flex align-items-center">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, rgba(196, 255, 87, 0.2) 0%, rgba(159, 232, 105, 0.15) 100%); display: flex; align-items: center; justify-content: center; margin-right: 0.8rem; color: #5a8e2a; font-weight: 700;">
                                {{ strtoupper(substr($order->customer->name, 0, 1)) }}
                            </div>
                            <strong style="font-size: 1.1rem;">{{ $order->customer->name }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">No. HP</label>
                        <div><strong><i class="fas fa-phone me-2 text-muted"></i>{{ $order->customer->phone }}</strong></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Email/Akun</label>
                        <div><strong><i class="fas fa-envelope me-2 text-muted"></i>{{ $order->user->email }}</strong></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Transaksi ID</label>
                        <div><strong><i class="fas fa-hashtag me-2 text-muted"></i>{{ $order->id }}</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Barang -->
        <div class="card-modern">
            <div class="card-header-modern">
                <h5>
                    <i class="fas fa-shopping-bag"></i> Detail Barang
                </h5>
            </div>
            <div class="p-3">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th style="text-align: center;">Qty</th>
                                <th style="text-align: right;">Harga</th>
                                <th style="text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->saleItems as $item)
                            <tr>
                                <td><strong>{{ $item->item ? $item->item->name : '[Item dihapus]' }}</strong></td>
                                <td>
                                    @if($item->item && $item->item->category)
                                        <span class="badge bg-secondary" style="padding: 0.4rem 0.8rem; border-radius: 8px;">{{ $item->item->category->name }}</span>
                                    @else
                                        <span class="badge bg-secondary" style="padding: 0.4rem 0.8rem; border-radius: 8px;">-</span>
                                    @endif
                                </td>
                                <td style="text-align: center;"><strong>{{ $item->quantity }}</strong></td>
                                <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td style="text-align: right;"><strong style="color: #5a8e2a;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ringkasan Pembayaran -->
        <div class="card-modern">
            <div class="card-header-modern">
                <h5>
                    <i class="fas fa-receipt"></i> Ringkasan Pembayaran
                </h5>
            </div>
            <div class="p-4">
                <table class="table mb-0">
                    <tr>
                        <td class="border-0" style="padding: 0.8rem 0;"><strong>Subtotal:</strong></td>
                        <td class="border-0 text-end" style="padding: 0.8rem 0;"><strong>Rp {{ number_format($order->subtotal ?? $order->total_amount, 0, ',', '.') }}</strong></td>
                    </tr>
                    @if($order->discount_amount > 0)
                    <tr>
                        <td class="border-0 text-success" style="padding: 0.8rem 0;">
                            <strong>Diskon:</strong>
                            @if($order->promotion)
                                <small class="text-muted">({{ $order->promotion->code }})</small>
                            @endif
                        </td>
                        <td class="border-0 text-end text-success" style="padding: 0.8rem 0;"><strong>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</strong></td>
                    </tr>
                    @endif
                    @if($order->tax_amount > 0)
                    <tr>
                        <td class="border-0" style="padding: 0.8rem 0;"><strong>Pajak (10%):</strong></td>
                        <td class="border-0 text-end" style="padding: 0.8rem 0;"><strong>Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</strong></td>
                    </tr>
                    @endif
                    <tr style="background: linear-gradient(135deg, rgba(196, 255, 87, 0.15) 0%, rgba(159, 232, 105, 0.1) 100%); border-top: 2px solid #e5e7eb;">
                        <td class="border-0" style="padding: 1.2rem 0;"><h5 class="mb-0"><strong>TOTAL:</strong></h5></td>
                        <td class="border-0 text-end" style="padding: 1.2rem 0;"><h4 class="mb-0" style="color: #5a8e2a; font-weight: 800;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h4></td>
                    </tr>
                </table>
            </div>
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
            <p style="margin: 2px 0; font-weight: bold; font-size: 11px;">PESANAN ONLINE</p>
            <table style="width: 100%; font-size: 10px;">
                <tr>
                    <td style="width: 45%;">No. Pesanan:</td>
                    <td>ORD-{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td>Kode Pickup:</td>
                    <td style="font-weight: bold; font-size: 12px;">{{ $order->pickup_code }}</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td>Pelanggan:</td>
                    <td>{{ $order->customer ? $order->customer->name : 'Umum' }}</td>
                </tr>
                @if($order->customer && $order->customer->phone)
                <tr>
                    <td>Telepon:</td>
                    <td>{{ $order->customer->phone }}</td>
                </tr>
                @endif
                <tr>
                    <td>Status:</td>
                    <td style="font-weight: bold;">
                        @if($order->status == 'pending')
                            MENUNGGU
                        @elseif($order->status == 'confirmed')
                            DIKONFIRMASI
                        @elseif($order->status == 'ready')
                            SIAP DIAMBIL
                        @elseif($order->status == 'completed')
                            SELESAI
                        @else
                            DIBATALKAN
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <!-- Detail Barang -->
        <div style="border-top: 2px dashed #000; padding-top: 8px; margin-bottom: 8px;">
            <p style="margin: 2px 0 6px 0; font-weight: bold; font-size: 11px;">DETAIL BARANG</p>
            
            @foreach($order->saleItems as $item)
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
                    <td style="text-align: right;">Rp {{ number_format($order->subtotal ?? $order->total_amount, 0, ',', '.') }}</td>
                </tr>
                @if($order->discount_amount > 0)
                <tr style="color: #28a745;">
                    <td>Diskon @if($order->promotion)({{ $order->promotion->code }})@endif:</td>
                    <td style="text-align: right;">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($order->tax_amount > 0)
                <tr>
                    <td>Pajak:</td>
                    <td style="text-align: right;">Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div style="border-top: 2px solid #000; padding-top: 5px; margin-bottom: 8px;">
            <table style="width: 100%; font-size: 12px; font-weight: bold;">
                <tr>
                    <td>TOTAL:</td>
                    <td style="text-align: right;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <!-- Pembayaran -->
        <div style="margin-bottom: 8px;">
            <p style="margin: 2px 0; font-weight: bold; font-size: 11px;">PEMBAYARAN</p>
            <table style="width: 100%; font-size: 10px;">
                <tr>
                    <td style="width: 45%;">Metode:</td>
                    <td style="text-align: right;">{{ strtoupper($order->payment_method) }}</td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td style="text-align: right; font-weight: bold;">{{ $order->payment_status == 'paid' ? 'LUNAS' : 'BELUM LUNAS' }}</td>
                </tr>
            </table>
        </div>

        <!-- Kode Pickup -->
        @if($order->status != 'completed' && $order->status != 'cancelled')
        <div style="border-top: 2px dashed #000; padding-top: 8px; margin-bottom: 8px; text-align: center;">
            <p style="margin: 2px 0; font-weight: bold; font-size: 11px;">KODE PICKUP</p>
            <p style="margin: 4px 0; font-size: 20px; font-weight: bold; letter-spacing: 3px;">{{ $order->pickup_code }}</p>
            <p style="margin: 2px 0; font-size: 9px;">Tunjukkan kode ini saat pengambilan</p>
        </div>
        @endif

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

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <form action="{{ route('kasir.online-orders.cancel', $order->id) }}" method="POST">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i> Batalkan Pesanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div class="alert alert-warning" style="border-radius: 12px; border: none;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Stok barang akan dikembalikan.
                    </div>
                    <div class="mb-3">
                        <label for="cancel_reason" class="form-label" style="font-weight: 600;">Alasan Pembatalan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="cancel_reason" name="cancel_reason" rows="3" required placeholder="Contoh: Pelanggan tidak datang, barang habis, dll" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 0.8rem;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border: none; padding: 1rem 2rem 2rem;">
                    <button type="button" class="btn btn-modern-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-modern-danger">Ya, Batalkan Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
