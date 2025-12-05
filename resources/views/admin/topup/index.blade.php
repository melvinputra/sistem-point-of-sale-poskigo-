@extends('layouts.admin')

@section('title', 'Kelola Top-Up Request - POSKigo Admin')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .breadcrumb-modern {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin-bottom: 0;
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: #5a8e2a;
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-modern .breadcrumb-item.active {
        color: #1a1a1a;
        font-weight: 600;
    }

    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header-pending {
        background: linear-gradient(135deg, #FFD93D 0%, #FFC107 100%);
        padding: 1.25rem 1.5rem;
        border: none;
    }

    .card-header-history {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        padding: 1.25rem 1.5rem;
        border: none;
    }

    .badge-method {
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
    }

    .badge-status {
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
    }

    .btn-view-proof {
        background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        transition: all 0.2s ease;
    }

    .btn-view-proof:hover {
        transform: translateY(-2px);
        color: white;
    }

    .btn-approve {
        background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-approve:hover {
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }

    .btn-reject {
        background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-reject:hover {
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 4px 12px rgba(238, 90, 111, 0.3);
    }

    .table-modern tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s ease;
    }

    .table-modern tbody tr:hover {
        background: #f8f9fa;
    }

    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 3.5rem;
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    .request-amount {
        font-size: 1.1rem;
        font-weight: 700;
        color: #5a8e2a;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="mb-2" style="color: #1a1a1a; font-weight: 700;">Kelola Top-Up Request</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-modern">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Top-Up Request</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Pending Requests -->
<div class="card card-modern">
    <div class="card-header-pending">
        <h5 class="mb-0" style="color: #1a1a1a; font-weight: 600;">
            <i class="fas fa-clock me-2"></i>Pending Requests ({{ $pendingRequests->total() }})
        </h5>
    </div>
    <div class="card-body p-0">
        @if($pendingRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">ID</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Tanggal</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Pelanggan</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Jumlah</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Metode</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Bukti</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingRequests as $request)
                        <tr>
                            <td style="padding: 1rem 1.5rem;">
                                <span class="badge" style="background: #6c757d; color: white; border-radius: 8px; padding: 0.4rem 0.8rem;">
                                    #{{ $request->id }}
                                </span>
                            </td>
                            <td style="padding: 1rem 1.5rem; color: #666;">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $request->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <div style="font-weight: 600; color: #1a1a1a;">
                                    <i class="fas fa-user me-1"></i>{{ $request->user->name }}
                                </div>
                                <small class="text-muted">{{ $request->user->email }}</small>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <div class="request-amount">Rp {{ number_format($request->amount, 0, ',', '.') }}</div>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                @if($request->payment_method == 'transfer')
                                    <span class="badge-method" style="background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%); color: white;">
                                        <i class="fas fa-exchange-alt me-1"></i>Transfer
                                    </span>
                                @elseif($request->payment_method == 'cash')
                                    <span class="badge-method" style="background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%); color: white;">
                                        <i class="fas fa-money-bill me-1"></i>Tunai
                                    </span>
                                @else
                                    <span class="badge-method" style="background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%); color: #1a1a1a;">
                                        <i class="fas fa-wallet me-1"></i>E-Wallet
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                @if($request->payment_proof)
                                    <a href="{{ asset('storage/' . $request->payment_proof) }}" target="_blank" class="btn btn-sm btn-view-proof">
                                        <i class="fas fa-image me-1"></i>Lihat
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <button type="button" class="btn btn-sm btn-approve me-1" data-bs-toggle="modal" data-bs-target="#approveModal{{ $request->id }}">
                                    <i class="fas fa-check me-1"></i>Setujui
                                </button>
                                <button type="button" class="btn btn-sm btn-reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                    <i class="fas fa-times me-1"></i>Tolak
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($pendingRequests->hasPages())
            <div class="p-3" style="background: #f8f9fa; border-top: 1px solid #dee2e6;">
                {{ $pendingRequests->links() }}
            </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-check-circle d-block text-success"></i>
                <h5 class="mb-0 text-muted">Tidak ada pending request</h5>
            </div>
        @endif
    </div>
</div>


<!-- Modals Section (Outside Table) -->
@foreach($pendingRequests as $request)
    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal{{ $request->id }}" tabindex="-1" aria-labelledby="approveModalLabel{{ $request->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 20px; overflow: hidden;">
                <form action="{{ route('admin.topup.approve', $request->id) }}" method="POST">
                    @csrf
                    <div class="modal-header" style="background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%); border: none; padding: 1.5rem;">
                        <h5 class="modal-title" id="approveModalLabel{{ $request->id }}" style="color: white; font-weight: 600;">
                            <i class="fas fa-check-circle me-2"></i>Setujui Top-Up Request
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding: 2rem;">
                        <p style="font-size: 1.05rem; color: #1a1a1a;">Anda yakin ingin menyetujui request top-up ini?</p>
                        <div class="alert" style="background: linear-gradient(135deg, #E3F9E8 0%, #D4F4DD 100%); border: none; border-radius: 12px; padding: 1.25rem;">
                            <h6 style="color: #1a1a1a; font-weight: 600; margin-bottom: 0.75rem;">
                                <i class="fas fa-info-circle me-1"></i>Detail Request
                            </h6>
                            <div style="color: #1a1a1a;">
                                <strong>Pelanggan:</strong> {{ $request->user->name }}<br>
                                <strong>Jumlah:</strong> <span style="color: #5a8e2a; font-weight: 700;">Rp {{ number_format($request->amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #1a1a1a;">Catatan (Opsional)</label>
                            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Catatan untuk pelanggan..." style="border-radius: 10px; border: 1px solid #dee2e6;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border: none; padding: 1rem 2rem 2rem;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 0.6rem 1.5rem;">Batal</button>
                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%); color: white; border: none; border-radius: 10px; padding: 0.6rem 1.5rem; font-weight: 500;">
                            <i class="fas fa-check me-1"></i>Ya, Setujui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $request->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 20px; overflow: hidden;">
                <form action="{{ route('admin.topup.reject', $request->id) }}" method="POST">
                    @csrf
                    <div class="modal-header" style="background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%); border: none; padding: 1.5rem;">
                        <h5 class="modal-title" id="rejectModalLabel{{ $request->id }}" style="color: white; font-weight: 600;">
                            <i class="fas fa-times-circle me-2"></i>Tolak Top-Up Request
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding: 2rem;">
                        <p style="font-size: 1.05rem; color: #1a1a1a;">Anda yakin ingin menolak request top-up ini?</p>
                        <div class="alert" style="background: linear-gradient(135deg, #FFE8E8 0%, #FFD6D6 100%); border: none; border-radius: 12px; padding: 1.25rem;">
                            <h6 style="color: #1a1a1a; font-weight: 600; margin-bottom: 0.75rem;">
                                <i class="fas fa-exclamation-triangle me-1"></i>Detail Request
                            </h6>
                            <div style="color: #1a1a1a;">
                                <strong>Pelanggan:</strong> {{ $request->user->name }}<br>
                                <strong>Jumlah:</strong> <span style="color: #c82333; font-weight: 700;">Rp {{ number_format($request->amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #1a1a1a;">
                                Alasan Penolakan <span class="text-danger">*</span>
                            </label>
                            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Jelaskan alasan penolakan..." required style="border-radius: 10px; border: 1px solid #dee2e6;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border: none; padding: 1rem 2rem 2rem;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 0.6rem 1.5rem;">Batal</button>
                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%); color: white; border: none; border-radius: 10px; padding: 0.6rem 1.5rem; font-weight: 500;">
                            <i class="fas fa-times me-1"></i>Ya, Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- All Requests History -->
<div class="card card-modern">
    <div class="card-header-history">
        <h5 class="mb-0" style="color: #1a1a1a; font-weight: 600;">
            <i class="fas fa-history me-2"></i>Semua Riwayat Top-Up Request
        </h5>
    </div>
    <div class="card-body p-0">
        @if($allRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">ID</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Tanggal</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Pelanggan</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Jumlah</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Status</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Diproses Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allRequests as $request)
                        <tr>
                            <td style="padding: 1rem 1.5rem;">
                                <span class="badge" style="background: #6c757d; color: white; border-radius: 8px; padding: 0.4rem 0.8rem;">
                                    #{{ $request->id }}
                                </span>
                            </td>
                            <td style="padding: 1rem 1.5rem; color: #666;">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $request->created_at->format('d/m/Y') }}
                            </td>
                            <td style="padding: 1rem 1.5rem; font-weight: 500; color: #1a1a1a;">{{ $request->user->name }}</td>
                            <td style="padding: 1rem 1.5rem; font-weight: 600; color: #5a8e2a;">
                                Rp {{ number_format($request->amount, 0, ',', '.') }}
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                @if($request->status == 'pending')
                                    <span class="badge-status" style="background: linear-gradient(135deg, #FFD93D 0%, #FFC107 100%); color: #1a1a1a;">
                                        <i class="fas fa-clock me-1"></i>Pending
                                    </span>
                                @elseif($request->status == 'approved')
                                    <span class="badge-status" style="background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%); color: white;">
                                        <i class="fas fa-check-circle me-1"></i>Disetujui
                                    </span>
                                @else
                                    <span class="badge-status" style="background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%); color: white;">
                                        <i class="fas fa-times-circle me-1"></i>Ditolak
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                @if($request->approver)
                                    <div style="font-weight: 500; color: #1a1a1a;">{{ $request->approver->name }}</div>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $request->approved_at ? $request->approved_at->format('d/m/Y H:i') : '' }}
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($allRequests->hasPages())
            <div class="p-3" style="background: #f8f9fa; border-top: 1px solid #dee2e6;">
                {{ $allRequests->links() }}
            </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-history d-block text-muted"></i>
                <p class="mb-0 text-muted">Belum ada riwayat request</p>
            </div>
        @endif
    </div>
</div>
@endsection
