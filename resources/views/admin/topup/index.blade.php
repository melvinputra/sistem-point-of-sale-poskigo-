@extends('layouts.admin')

@section('title', 'Kelola Top-Up Request - POSKigo Admin')

@section('content')
<h1 class="mt-4">Kelola Top-Up Request</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Top-Up Request</li>
</ol>

<!-- Pending Requests -->
<div class="card mb-4">
    <div class="card-header bg-warning text-dark">
        <i class="fas fa-clock me-1"></i> <strong>Pending Requests ({{ $pendingRequests->total() }})</strong>
    </div>
    <div class="card-body">
        @if($pendingRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingRequests as $request)
                        <tr>
                            <td><strong>#{{ $request->id }}</strong></td>
                            <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <i class="fas fa-user me-1"></i> {{ $request->user->name }}<br>
                                <small class="text-muted">{{ $request->user->email }}</small>
                            </td>
                            <td><strong class="text-primary">Rp {{ number_format($request->amount, 0, ',', '.') }}</strong></td>
                            <td>
                                @if($request->payment_method == 'transfer')
                                    <span class="badge bg-info">Transfer</span>
                                @elseif($request->payment_method == 'cash')
                                    <span class="badge bg-success">Tunai</span>
                                @else
                                    <span class="badge bg-primary">E-Wallet</span>
                                @endif
                            </td>
                            <td>
                                @if($request->payment_proof)
                                    <a href="{{ asset('storage/' . $request->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-image me-1"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $request->id }}">
                                        <i class="fas fa-check me-1"></i> Setujui
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                        <i class="fas fa-times me-1"></i> Tolak
                                    </button>
                                </div>

                                <!-- Approve Modal -->
                                <div class="modal fade" id="approveModal{{ $request->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.topup.approve', $request->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title">Setujui Top-Up Request</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menyetujui request top-up ini?</p>
                                                    <div class="alert alert-info">
                                                        <strong>Detail:</strong><br>
                                                        Pelanggan: {{ $request->user->name }}<br>
                                                        Jumlah: Rp {{ number_format($request->amount, 0, ',', '.') }}
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Catatan (Opsional)</label>
                                                        <textarea name="admin_notes" class="form-control" rows="2" placeholder="Catatan untuk pelanggan..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Ya, Setujui</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.topup.reject', $request->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Tolak Top-Up Request</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menolak request top-up ini?</p>
                                                    <div class="alert alert-warning">
                                                        <strong>Detail:</strong><br>
                                                        Pelanggan: {{ $request->user->name }}<br>
                                                        Jumlah: Rp {{ number_format($request->amount, 0, ',', '.') }}
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Jelaskan alasan penolakan..." required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $pendingRequests->links() }}
        @else
            <div class="text-center py-4">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <p class="text-muted">Tidak ada pending request</p>
            </div>
        @endif
    </div>
</div>

<!-- All Requests History -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-history me-1"></i> Semua Riwayat Top-Up Request
    </div>
    <div class="card-body">
        @if($allRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Diproses Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allRequests as $request)
                        <tr>
                            <td>#{{ $request->id }}</td>
                            <td>{{ $request->created_at->format('d/m/Y') }}</td>
                            <td>{{ $request->user->name }}</td>
                            <td>Rp {{ number_format($request->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($request->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($request->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if($request->approver)
                                    {{ $request->approver->name }}<br>
                                    <small class="text-muted">{{ $request->approved_at ? $request->approved_at->format('d/m/Y H:i') : '' }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $allRequests->links() }}
        @else
            <p class="text-muted text-center py-3">Belum ada riwayat request</p>
        @endif
    </div>
</div>
@endsection
