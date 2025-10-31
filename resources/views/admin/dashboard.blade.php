@extends('layouts.admin')

@section('title', 'Admin Dashboard - POSKigo')

@section('content')
<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <div>
        <h1 class="mb-0">Dashboard Admin</h1>
        <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>
    @if($unreadCount > 0)
        <a href="#notificationSection" class="btn btn-warning">
            <i class="fas fa-bell me-2"></i> {{ $unreadCount }} Notifikasi Baru
        </a>
    @endif
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4 hover-shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small">Total Barang</div>
                        <div class="h2 mb-0">{{ $totalItems }}</div>
                    </div>
                    <i class="fas fa-box fa-2x"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('admin.items.index') }}">Lihat Detail</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4 hover-shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small">Total User</div>
                        <div class="h2 mb-0">{{ $totalUsers }}</div>
                    </div>
                    <i class="fas fa-users fa-2x"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('admin.users.index') }}">Lihat Detail</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4 hover-shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small">Total Penjualan</div>
                        <div class="h2 mb-0">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-dollar-sign fa-2x"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('admin.reports.index') }}">Lihat Laporan</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-info text-white mb-4 hover-shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small">Penjualan Hari Ini</div>
                        <div class="h2 mb-0">Rp {{ number_format($todaySales, 0, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-calendar-day fa-2x"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{ route('admin.reports.index') }}">Lihat Detail</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Alerts Row -->
<div class="row mb-4">
    @if($lowStockItems->count() > 0)
    <div class="col-xl-6 mb-3">
        <div class="alert alert-danger shadow">
            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i> Peringatan Stok Rendah!</h5>
            <p class="mb-2">Ada <strong>{{ $lowStockItems->count() }} barang</strong> dengan stok di bawah 5:</p>
            <ul class="mb-0">
                @foreach($lowStockItems->take(5) as $item)
                    <li><strong>{{ $item->name }}</strong> - Sisa stok: <span class="badge bg-danger">{{ $item->stock }}</span></li>
                @endforeach
                @if($lowStockItems->count() > 5)
                    <li class="text-muted">... dan {{ $lowStockItems->count() - 5 }} lainnya</li>
                @endif
            </ul>
            <a href="{{ route('admin.items.index') }}" class="btn btn-sm btn-danger mt-2">
                <i class="fas fa-box me-1"></i> Kelola Stok Barang
            </a>
        </div>
    </div>
    @endif

    @if($pendingTopups > 0)
    <div class="col-xl-6 mb-3">
        <div class="alert alert-warning shadow">
            <h5 class="alert-heading"><i class="fas fa-clock me-2"></i> Pending Top-Up Request</h5>
            <p class="mb-2">Ada <strong>{{ $pendingTopups }} request top-up</strong> yang menunggu approval:</p>
            <a href="{{ route('admin.topup.index') }}" class="btn btn-sm btn-warning">
                <i class="fas fa-wallet me-1"></i> Review Sekarang
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Chart & Notifications Row -->
<div class="row mb-4">
    <!-- Sales Chart -->
    <div class="col-xl-8 mb-3">
        <div class="card shadow">
            <div class="card-header">
                <i class="fas fa-chart-area me-1"></i> Grafik Penjualan (7 Hari Terakhir)
            </div>
            <div class="card-body">
                <canvas id="salesChart" width="100%" height="40"></canvas>
            </div>
        </div>
    </div>

    <!-- Notifications Panel -->
    <div class="col-xl-4 mb-3" id="notificationSection">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-bell me-1"></i> Notifikasi</span>
                @if($unreadCount > 0)
                    <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-link text-decoration-none">
                            Tandai Semua Dibaca
                        </button>
                    </form>
                @endif
            </div>
            <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                @if($notifications->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($notifications as $notif)
                        <div class="list-group-item {{ $notif->is_read ? 'bg-light' : '' }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">
                                    @if($notif->type == 'transaction')
                                        <i class="fas fa-receipt text-success me-1"></i>
                                    @elseif($notif->type == 'stock_alert')
                                        <i class="fas fa-exclamation-triangle text-danger me-1"></i>
                                    @elseif($notif->type == 'topup_request')
                                        <i class="fas fa-wallet text-warning me-1"></i>
                                    @endif
                                    {{ $notif->title }}
                                </h6>
                                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1 small">{{ $notif->message }}</p>
                            @if(!$notif->is_read)
                                <button class="btn btn-sm btn-outline-primary mark-read" data-id="{{ $notif->id }}">
                                    <i class="fas fa-check"></i> Tandai Dibaca
                                </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-bell-slash fa-2x mb-2"></i>
                        <p>Tidak ada notifikasi baru</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Sales Table -->
<div class="card mb-4 shadow">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Transaksi Terbaru
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Kasir</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSales as $sale)
                <tr>
                    <td>#{{ $sale->id }}</td>
                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $sale->user->name }}</td>
                    <td>{{ $sale->customer ? $sale->customer->name : '-' }}</td>
                    <td>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Sales Chart with Chart.js
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Penjualan (Rp)',
            data: @json($chartData),
            backgroundColor: 'rgba(30, 136, 229, 0.1)',
            borderColor: '#1e88e5',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#1e88e5',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#ff6f00',
            pointHoverBorderColor: '#fff',
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});

// Mark notification as read
document.querySelectorAll('.mark-read').forEach(button => {
    button.addEventListener('click', function() {
        const notifId = this.getAttribute('data-id');
        
        fetch(`/admin/notifications/${notifId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                this.closest('.list-group-item').classList.add('bg-light');
                this.remove();
                toastr.success('Notifikasi ditandai dibaca');
                
                // Reload after 1 second to update badge count
                setTimeout(() => location.reload(), 1000);
            }
        });
    });
});
</script>
@endpush
