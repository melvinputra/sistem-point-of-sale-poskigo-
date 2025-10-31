@extends('layouts.admin')

@section('title', 'Activity Logs - POSKigo')

@section('content')
<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <div>
        <h1 class="mb-0">Activity Logs</h1>
        <p class="text-muted">Riwayat aktivitas semua perubahan data sistem</p>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4 shadow">
    <div class="card-header">
        <i class="fas fa-filter me-1"></i> Filter Logs
    </div>
    <div class="card-body">
        <form action="{{ route('admin.logs.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Model</label>
                    <select name="model" class="form-select">
                        <option value="">Semua Model</option>
                        <option value="Item" {{ request('model') == 'Item' ? 'selected' : '' }}>Item</option>
                        <option value="User" {{ request('model') == 'User' ? 'selected' : '' }}>User</option>
                        <option value="Sale" {{ request('model') == 'Sale' ? 'selected' : '' }}>Sale</option>
                        <option value="Promotion" {{ request('model') == 'Promotion' ? 'selected' : '' }}>Promotion</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Aksi</label>
                    <select name="action" class="form-select">
                        <option value="">Semua Aksi</option>
                        <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Logs Table -->
<div class="card shadow">
    <div class="card-header">
        <i class="fas fa-history me-1"></i> Activity Logs ({{ $logs->total() }} records)
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 15%;">Waktu</th>
                        <th style="width: 15%;">User</th>
                        <th style="width: 10%;">Aksi</th>
                        <th style="width: 10%;">Model</th>
                        <th style="width: 35%;">Deskripsi</th>
                        <th style="width: 10%;">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>#{{ $log->id }}</td>
                        <td>
                            <small>{{ $log->created_at->format('d/m/Y H:i:s') }}</small><br>
                            <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            @if($log->user)
                                <strong>{{ $log->user->name }}</strong><br>
                                <small class="text-muted">{{ $log->user->email }}</small>
                            @else
                                <span class="text-muted">System</span>
                            @endif
                        </td>
                        <td>
                            @if($log->action == 'created')
                                <span class="badge bg-success">Created</span>
                            @elseif($log->action == 'updated')
                                <span class="badge bg-warning">Updated</span>
                            @elseif($log->action == 'deleted')
                                <span class="badge bg-danger">Deleted</span>
                            @else
                                <span class="badge bg-info">{{ ucfirst($log->action) }}</span>
                            @endif
                        </td>
                        <td><code>{{ $log->model }}</code> #{{ $log->model_id }}</td>
                        <td>{{ $log->description }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#logModal{{ $log->id }}">
                                <i class="fas fa-eye"></i> Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Detail Modal -->
                    <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Log Detail #{{ $log->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <h6>Informasi Umum</h6>
                                    <ul>
                                        <li><strong>Waktu:</strong> {{ $log->created_at->format('d F Y, H:i:s') }}</li>
                                        <li><strong>User:</strong> {{ $log->user ? $log->user->name : 'System' }}</li>
                                        <li><strong>IP Address:</strong> {{ $log->ip_address }}</li>
                                        <li><strong>User Agent:</strong> {{ $log->user_agent }}</li>
                                    </ul>

                                    @if($log->old_data)
                                    <h6 class="mt-3">Data Lama</h6>
                                    <pre class="bg-light p-3 rounded">{{ json_encode(json_decode($log->old_data), JSON_PRETTY_PRINT) }}</pre>
                                    @endif

                                    @if($log->new_data)
                                    <h6 class="mt-3">Data Baru</h6>
                                    <pre class="bg-light p-3 rounded">{{ json_encode(json_decode($log->new_data), JSON_PRETTY_PRINT) }}</pre>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p>Tidak ada activity logs ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $logs->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
