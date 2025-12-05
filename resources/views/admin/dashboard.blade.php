                                                                                                                                                                                                                                                                                                        @extends('layouts.admin')

@section('title', 'Admin Dashboard - POSKigo')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .stat-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        background: white;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-card .card-body {
        padding: 1.75rem;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0.5rem 0;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #666;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-footer {
        padding: 0.75rem 1.75rem;
        background: rgba(0, 0, 0, 0.02);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .stat-footer a {
        color: inherit;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .stat-footer a:hover {
        color: #5a8e2a;
    }

    .bg-primary-gradient {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
    }

    .bg-warning-gradient {
        background: linear-gradient(135deg, #FFD93D 0%, #FFC107 100%);
    }

    .bg-success-gradient {
        background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%);
    }

    .bg-info-gradient {
        background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%);
    }

    .alert-modern {
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .alert-modern .alert-heading {
        font-weight: 600;
        margin-bottom: 1rem;
    }
</style>

<!-- Page Header -->
<div class="dashboard-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-2" style="color: #1a1a1a; font-weight: 700;">Dashboard Admin</h1>
            <p class="mb-0" style="color: #5a8e2a; font-weight: 500;">
                <i class="fas fa-user-shield me-2"></i>Selamat datang, {{ auth()->user()->name }}!
            </p>
        </div>
        @if($unreadCount > 0)
            <a href="#notificationSection" class="btn btn-dark" style="border-radius: 12px; padding: 0.75rem 1.5rem;">
                <i class="fas fa-bell me-2"></i>{{ $unreadCount }} Notifikasi Baru
            </a>
        @endif
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <!-- Total Barang -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="stat-label">Total Barang</div>
                        <div class="stat-value">{{ number_format($totalItems) }}</div>
                    </div>
                    <div class="stat-icon bg-primary-gradient text-white">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
            <div class="stat-footer">
                <a href="{{ route('admin.items.index') }}">
                    Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Total User -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="stat-label">Total User</div>
                        <div class="stat-value">{{ number_format($totalUsers) }}</div>
                    </div>
                    <div class="stat-icon bg-warning-gradient text-white">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="stat-footer">
                <a href="{{ route('admin.users.index') }}">
                    Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Total Penjualan -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="stat-label">Total Penjualan</div>
                        <div class="stat-value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
                    </div>
                    <div class="stat-icon bg-success-gradient text-white">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="stat-footer">
                <a href="{{ route('admin.reports.index') }}">
                    Lihat Laporan <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Penjualan Hari Ini -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="stat-label">Penjualan Hari Ini</div>
                        <div class="stat-value">Rp {{ number_format($todaySales, 0, ',', '.') }}</div>
                    </div>
                    <div class="stat-icon bg-info-gradient text-white">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
            </div>
            <div class="stat-footer">
                <a href="{{ route('admin.reports.index') }}">
                    Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>


<!-- Alerts Row -->
<div class="row mb-4">
    @if($lowStockItems->count() > 0)
    <div class="col-xl-6 mb-3">
        <div class="alert alert-modern" style="background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%); color: white;">
            <h5 class="alert-heading">
                <i class="fas fa-exclamation-triangle me-2"></i>Peringatan Stok Rendah!
            </h5>
            <p class="mb-2">Ada <strong>{{ $lowStockItems->count() }} barang</strong> dengan stok di bawah 5:</p>
            <ul class="mb-3">
                @foreach($lowStockItems->take(5) as $item)
                    <li class="mb-1">
                        <strong>{{ $item->name }}</strong> - Sisa stok: 
                        <span class="badge" style="background: rgba(255,255,255,0.3); color: white;">
                            {{ $item->stock }}
                        </span>
                    </li>
                @endforeach
                @if($lowStockItems->count() > 5)
                    <li class="mb-1" style="opacity: 0.8;">... dan {{ $lowStockItems->count() - 5 }} lainnya</li>
                @endif
            </ul>
            <a href="{{ route('admin.items.index') }}" class="btn btn-light" style="border-radius: 10px;">
                <i class="fas fa-box me-1"></i> Kelola Stok Barang
            </a>
        </div>
    </div>
    @endif

    @if($pendingTopups > 0)
    <div class="col-xl-6 mb-3">
        <div class="alert alert-modern" style="background: linear-gradient(135deg, #FFD93D 0%, #FFC107 100%); color: #1a1a1a;">
            <h5 class="alert-heading">
                <i class="fas fa-clock me-2"></i>Pending Top-Up Request
            </h5>
            <p class="mb-3">Ada <strong>{{ $pendingTopups }} request top-up</strong> yang menunggu approval</p>
            <a href="{{ route('admin.topup.index') }}" class="btn btn-dark" style="border-radius: 10px;">
                <i class="fas fa-wallet me-1"></i> Review Sekarang
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Notifications & Recent Sales Row -->
<div class="row mb-4">
    <!-- Notifications Panel -->
    <div class="col-xl-4 mb-3" id="notificationSection">
        <div class="card" style="border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
            <div class="card-header" style="background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%); border-radius: 20px 20px 0 0; padding: 1.25rem 1.5rem; border: none;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="color: #1a1a1a; font-weight: 600;">
                        <i class="fas fa-bell me-2"></i>Notifikasi
                    </h5>
                    @if($unreadCount > 0)
                        <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-dark" style="border-radius: 8px;">
                                <i class="fas fa-check-double me-1"></i> Tandai Semua
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                @if($notifications->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($notifications as $notif)
                        <div class="list-group-item border-0 {{ $notif->is_read ? '' : 'bg-light' }}" style="padding: 1rem 1.5rem;">
                            <div class="d-flex w-100 justify-content-between mb-2">
                                <h6 class="mb-0" style="font-weight: 600;">
                                    @if($notif->type == 'transaction')
                                        <span class="badge bg-success-gradient" style="border-radius: 8px; padding: 0.35rem 0.75rem;">
                                            <i class="fas fa-receipt me-1"></i>Transaksi
                                        </span>
                                    @elseif($notif->type == 'stock_alert')
                                        <span class="badge" style="background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%); border-radius: 8px; padding: 0.35rem 0.75rem;">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Stok
                                        </span>
                                    @elseif($notif->type == 'topup_request')
                                        <span class="badge bg-warning-gradient" style="border-radius: 8px; padding: 0.35rem 0.75rem;">
                                            <i class="fas fa-wallet me-1"></i>Top-Up
                                        </span>
                                    @endif
                                </h6>
                                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                            </div>
                            <h6 class="mb-1">{{ $notif->title }}</h6>
                            <p class="mb-2 small text-muted">{{ $notif->message }}</p>
                            @if(!$notif->is_read)
                                <button class="btn btn-sm btn-outline-success mark-read" data-id="{{ $notif->id }}" style="border-radius: 8px;">
                                    <i class="fas fa-check me-1"></i> Tandai Dibaca
                                </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-bell-slash fa-3x mb-3" style="opacity: 0.3;"></i>
                        <p class="mb-0">Tidak ada notifikasi baru</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Sales Table -->
    <div class="col-xl-8 mb-3">
        <div class="card" style="border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
            <div class="card-header" style="background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%); border-radius: 20px 20px 0 0; padding: 1.25rem 1.5rem; border: none;">
                <h5 class="mb-0" style="color: #1a1a1a; font-weight: 600;">
                    <i class="fas fa-table me-2"></i>Transaksi Terbaru
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">No</th>
                                <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">ID Transaksi</th>
                                <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Tanggal</th>
                                <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Kasir</th>
                                <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Pelanggan</th>
                                <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6; text-align: right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $index => $sale)
                            <tr style="border-bottom: 1px solid #f0f0f0; transition: all 0.2s ease;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='white'">
                                <td style="padding: 1rem 1.5rem;">
                                    <span class="badge" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border-radius: 8px;">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td style="padding: 1rem 1.5rem;">
                                    <span class="badge bg-primary-gradient" style="border-radius: 8px; padding: 0.4rem 0.8rem;">
                                        #{{ $sale->id }}
                                    </span>
                                </td>
                                <td style="padding: 1rem 1.5rem; color: #666;">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $sale->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td style="padding: 1rem 1.5rem; font-weight: 500;">{{ $sale->user->name }}</td>
                                <td style="padding: 1rem 1.5rem;">
                                    @if($sale->customer)
                                        <i class="fas fa-user me-1" style="color: #5a8e2a;"></i>{{ $sale->customer->name }}
                                    @else
                                        <span class="text-muted"><i class="fas fa-user-slash me-1"></i>Umum</span>
                                    @endif
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: right; font-weight: 700; color: #5a8e2a;">
                                    Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                                    <p class="mb-0">Belum ada transaksi</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
                this.closest('.list-group-item').classList.remove('bg-light');
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
