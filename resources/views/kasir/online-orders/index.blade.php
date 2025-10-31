@extends('layouts.kasir')

@section('title', 'Pesanan Online - POSKigo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-box me-2"></i> Pesanan Online</h2>
    <a href="{{ route('kasir.online-orders.verify') }}" class="btn btn-primary">
        <i class="fas fa-qrcode me-2"></i> Verifikasi Kode Pickup
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filter Tabs -->
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link {{ $status == 'all' ? 'active' : '' }}" href="{{ route('kasir.online-orders') }}?status=all">
            <i class="fas fa-list me-1"></i> Semua 
            <span class="badge bg-secondary ms-1">{{ $counts['pending'] + $counts['ready'] + $counts['completed'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $status == 'pending' ? 'active' : '' }}" href="{{ route('kasir.online-orders') }}?status=pending">
            <i class="fas fa-clock me-1"></i> Menunggu 
            <span class="badge bg-warning ms-1">{{ $counts['pending'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $status == 'ready' ? 'active' : '' }}" href="{{ route('kasir.online-orders') }}?status=ready">
            <i class="fas fa-check-circle me-1"></i> Siap Diambil 
            <span class="badge bg-success ms-1">{{ $counts['ready'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $status == 'completed' ? 'active' : '' }}" href="{{ route('kasir.online-orders') }}?status=completed">
            <i class="fas fa-flag-checkered me-1"></i> Selesai 
            <span class="badge bg-info ms-1">{{ $counts['completed'] }}</span>
        </a>
    </li>
</ul>

<!-- Orders List -->
<div class="card">
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Pickup</th>
                            <th>Pelanggan</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Waktu Pesan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <strong class="text-primary">{{ $order->pickup_code }}</strong>
                            </td>
                            <td>
                                <div>{{ $order->customer->name }}</div>
                                <small class="text-muted">{{ $order->customer->phone }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $order->saleItems->count() }} items</span>
                            </td>
                            <td>
                                <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                @if($order->order_status == 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i> Menunggu
                                    </span>
                                @elseif($order->order_status == 'ready')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Siap Diambil
                                    </span>
                                @elseif($order->order_status == 'completed')
                                    <span class="badge bg-info">
                                        <i class="fas fa-flag-checkered me-1"></i> Selesai
                                    </span>
                                @elseif($order->order_status == 'cancelled')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i> Dibatalkan
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('kasir.online-orders.show', $order->id) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($order->order_status == 'pending')
                                        <form action="{{ route('kasir.online-orders.prepare', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Siapkan Barang" onclick="return confirm('Tandai pesanan ini sudah disiapkan?')">
                                                <i class="fas fa-box-open"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($order->order_status == 'ready')
                                        <form action="{{ route('kasir.online-orders.complete', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary" title="Serahkan Barang" onclick="return confirm('Konfirmasi barang sudah diserahkan ke pelanggan?')">
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
            <div class="mt-3">
                {{ $orders->appends(['status' => $status])->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada pesanan online</h5>
                <p class="text-muted">
                    @if($status == 'pending')
                        Tidak ada pesanan yang menunggu persiapan
                    @elseif($status == 'ready')
                        Tidak ada pesanan yang siap diambil
                    @elseif($status == 'completed')
                        Belum ada pesanan yang selesai
                    @else
                        Belum ada pesanan online masuk
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
