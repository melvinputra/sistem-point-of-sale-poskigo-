@extends('layouts.kasir')

@section('title', 'Pesanan Online - POSKigo')

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

    .nav-tabs-modern {
        border: none;
        background: #ffffff;
        border-radius: 15px;
        padding: 0.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        display: flex;
        gap: 0.5rem;
    }

    .nav-tabs-modern .nav-item {
        flex: 1;
    }

    .nav-tabs-modern .nav-link {
        border: none;
        border-radius: 10px;
        padding: 0.8rem 1.5rem;
        color: #6a6a6a;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .nav-tabs-modern .nav-link:hover {
        background: rgba(196, 255, 87, 0.1);
        color: #5a8e2a;
    }

    .nav-tabs-modern .nav-link.active {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        color: #1a1a1a;
        box-shadow: 0 5px 15px rgba(196, 255, 87, 0.3);
    }

    .badge-tab {
        padding: 0.25rem 0.6rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .card-modern {
        background: #ffffff;
        border: 2px solid #f0f0f0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
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

    .btn-modern-info {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 0.5rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-modern-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        color: white;
    }

    .btn-modern-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.5rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-modern-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .pickup-code {
        font-size: 1.2rem;
        font-weight: 800;
        color: #5a8e2a;
        font-family: 'Courier New', monospace;
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.2) 0%, rgba(159, 232, 105, 0.1) 100%);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        display: inline-block;
    }

    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
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
</style>

<div class="page-header-modern">
    <div>
        <h1>
            <i class="fas fa-shopping-bag"></i>
            Pesanan Online
        </h1>
    </div>
    <a href="{{ route('kasir.online-orders.verify') }}" class="btn btn-modern-primary">
        <i class="fas fa-qrcode"></i> Verifikasi Kode Pickup
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 15px; border: none; box-shadow: 0 5px 15px rgba(16, 185, 129, 0.2);">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 15px; border: none; box-shadow: 0 5px 15px rgba(239, 68, 68, 0.2);">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filter Tabs -->
<ul class="nav nav-tabs-modern">
    <li class="nav-item">
        <a class="nav-link {{ $status == 'all' ? 'active' : '' }}" href="{{ route('kasir.online-orders') }}?status=all">
            <i class="fas fa-list"></i>
            <span>Semua</span>
            <span class="badge-tab bg-dark">{{ $counts['pending'] + $counts['ready'] + $counts['completed'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $status == 'pending' ? 'active' : '' }}" href="{{ route('kasir.online-orders') }}?status=pending">
            <i class="fas fa-clock"></i>
            <span>Menunggu</span>
            <span class="badge-tab bg-warning">{{ $counts['pending'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $status == 'ready' ? 'active' : '' }}" href="{{ route('kasir.online-orders') }}?status=ready">
            <i class="fas fa-check-circle"></i>
            <span>Siap Diambil</span>
            <span class="badge-tab bg-success">{{ $counts['ready'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $status == 'completed' ? 'active' : '' }}" href="{{ route('kasir.online-orders') }}?status=completed">
            <i class="fas fa-flag-checkered"></i>
            <span>Selesai</span>
            <span class="badge-tab bg-info">{{ $counts['completed'] }}</span>
        </a>
    </li>
</ul>

<!-- Orders List -->
<div class="card-modern">
    <div class="p-3">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Kode Pickup</th>
                            <th>Pelanggan</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Waktu Pesan</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <span class="pickup-code">{{ $order->pickup_code }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, rgba(196, 255, 87, 0.2) 0%, rgba(159, 232, 105, 0.15) 100%); display: flex; align-items: center; justify-content: center; margin-right: 0.8rem; color: #5a8e2a;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $order->customer->name }}</strong><br>
                                        <small class="text-muted">{{ $order->customer->phone }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary" style="padding: 0.5rem 1rem; border-radius: 10px;">
                                    <i class="fas fa-box me-1"></i> {{ $order->saleItems->count() }} items
                                </span>
                            </td>
                            <td>
                                <strong style="color: #5a8e2a; font-size: 1.1rem;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                @if($order->order_status == 'pending')
                                    <span class="badge-status bg-warning text-dark">
                                        <i class="fas fa-clock"></i> Menunggu
                                    </span>
                                @elseif($order->order_status == 'ready')
                                    <span class="badge-status bg-success text-white">
                                        <i class="fas fa-check-circle"></i> Siap Diambil
                                    </span>
                                @elseif($order->order_status == 'completed')
                                    <span class="badge-status bg-info text-white">
                                        <i class="fas fa-flag-checkered"></i> Selesai
                                    </span>
                                @elseif($order->order_status == 'cancelled')
                                    <span class="badge-status bg-danger text-white">
                                        <i class="fas fa-times-circle"></i> Dibatalkan
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <strong style="font-size: 0.9rem;">{{ $order->created_at->format('d/m/Y') }}</strong>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>{{ $order->created_at->format('H:i') }} WIB
                                    </small>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('kasir.online-orders.show', $order->id) }}" class="btn btn-modern-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($order->order_status == 'pending')
                                        <form action="{{ route('kasir.online-orders.prepare', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-modern-success btn-sm" title="Siapkan Barang" onclick="return confirm('Tandai pesanan ini sudah disiapkan?')">
                                                <i class="fas fa-box-open"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($order->order_status == 'ready')
                                        <form action="{{ route('kasir.online-orders.complete', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-modern-primary btn-sm" title="Serahkan Barang" onclick="return confirm('Konfirmasi barang sudah diserahkan ke pelanggan?')">
                                                <i class="fas fa-hand-holding"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3 px-3">
                {{ $orders->appends(['status' => $status])->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h5 style="color: #1a1a1a; font-weight: 700;">
                    @if($status == 'pending')
                        Tidak ada pesanan yang menunggu
                    @elseif($status == 'ready')
                        Tidak ada pesanan yang siap diambil
                    @elseif($status == 'completed')
                        Belum ada pesanan yang selesai
                    @else
                        Belum ada pesanan online
                    @endif
                </h5>
                <p class="text-muted mb-0">
                    @if($status == 'pending')
                        Pesanan yang menunggu persiapan akan muncul di sini
                    @elseif($status == 'ready')
                        Pesanan yang siap diambil akan muncul di sini
                    @elseif($status == 'completed')
                        Pesanan yang sudah selesai akan muncul di sini
                    @else
                        Pesanan online dari pelanggan akan muncul di sini
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
