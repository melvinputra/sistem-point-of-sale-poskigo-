@extends('layouts.admin')

@section('title', 'Activity Logs - POSKigo')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header-modern {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        padding: 1.25rem 1.5rem;
        border: none;
    }

    .badge-action {
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
    }

    .btn-detail {
        background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        transition: all 0.2s ease;
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        color: white;
    }

    .table-modern tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s ease;
    }

    .table-modern tbody tr:hover {
        background: #f8f9fa;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .modal-modern .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }

    .modal-modern .modal-header {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border: none;
        padding: 1.5rem;
    }

    .modal-modern .modal-header .modal-title {
        color: #1a1a1a;
        font-weight: 600;
    }

    .code-block {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        border-left: 4px solid #5a8e2a;
        max-height: 300px;
        overflow-y: auto;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="mb-2" style="color: #1a1a1a; font-weight: 700;">Activity Logs</h1>
        <p class="mb-0" style="color: #5a8e2a; font-weight: 500;">
            <i class="fas fa-history me-2"></i>Riwayat aktivitas semua perubahan data sistem
        </p>
    </div>
</div>

<!-- Filter -->
<div class="card card-modern">
    <div class="card-header-modern">
        <h5 class="mb-0" style="color: #1a1a1a; font-weight: 600;">
            <i class="fas fa-filter me-2"></i>Filter Logs
        </h5>
    </div>
    <div class="card-body" style="padding: 2rem;">
        <form action="{{ route('admin.logs.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 600; color: #1a1a1a;">Model</label>
                    <select name="model" class="form-select" style="border-radius: 10px; border: 1px solid #dee2e6; padding: 0.75rem;">
                        <option value="">Semua Model</option>
                        <option value="Item" {{ request('model') == 'Item' ? 'selected' : '' }}>Item</option>
                        <option value="User" {{ request('model') == 'User' ? 'selected' : '' }}>User</option>
                        <option value="Sale" {{ request('model') == 'Sale' ? 'selected' : '' }}>Sale</option>
                        <option value="Promotion" {{ request('model') == 'Promotion' ? 'selected' : '' }}>Promotion</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 600; color: #1a1a1a;">Aksi</label>
                    <select name="action" class="form-select" style="border-radius: 10px; border: 1px solid #dee2e6; padding: 0.75rem;">
                        <option value="">Semua Aksi</option>
                        <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: #1a1a1a;">Tanggal</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}" style="border-radius: 10px; border: 1px solid #dee2e6; padding: 0.75rem;">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn w-100" style="background: #1a1a1a; color: white; border-radius: 10px; padding: 0.75rem; font-weight: 500;">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Logs Table -->
<div class="card card-modern">
    <div class="card-header-modern">
        <h5 class="mb-0" style="color: #1a1a1a; font-weight: 600;">
            <i class="fas fa-list me-2"></i>Activity Logs ({{ $logs->total() }} records)
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">ID</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Waktu</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">User</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Aksi</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Model</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Deskripsi</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td style="padding: 1rem 1.5rem;">
                            <span class="badge" style="background: #6c757d; color: white; border-radius: 8px; padding: 0.4rem 0.8rem;">
                                #{{ $log->id }}
                            </span>
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            <div style="color: #1a1a1a; font-weight: 500;">{{ $log->created_at->format('d/m/Y H:i:s') }}</div>
                            <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            @if($log->user)
                                <div style="font-weight: 600; color: #1a1a1a;">{{ $log->user->name }}</div>
                                <small class="text-muted">{{ $log->user->email }}</small>
                            @else
                                <span class="badge" style="background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%); color: #1a1a1a; font-weight: 600;">
                                    <i class="fas fa-user-plus me-1"></i>Registrasi Baru
                                </span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            @if($log->action == 'created')
                                <span class="badge-action" style="background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%); color: white;">
                                    <i class="fas fa-plus me-1"></i>Created
                                </span>
                            @elseif($log->action == 'updated')
                                <span class="badge-action" style="background: linear-gradient(135deg, #FFD93D 0%, #FFC107 100%); color: #1a1a1a;">
                                    <i class="fas fa-edit me-1"></i>Updated
                                </span>
                            @elseif($log->action == 'deleted')
                                <span class="badge-action" style="background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%); color: white;">
                                    <i class="fas fa-trash me-1"></i>Deleted
                                </span>
                            @else
                                <span class="badge-action" style="background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%); color: white;">
                                    {{ ucfirst($log->action) }}
                                </span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            <code style="background: #f8f9fa; padding: 0.3rem 0.6rem; border-radius: 6px; font-weight: 600;">
                                {{ $log->model }}
                            </code>
                            <small class="text-muted d-block mt-1">#{{ $log->model_id }}</small>
                        </td>
                        <td style="padding: 1rem 1.5rem; color: #666;">{{ $log->description }}</td>
                        <td style="padding: 1rem 1.5rem;">
                            <button class="btn btn-sm btn-detail" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#logModal{{ $log->id }}">
                                <i class="fas fa-eye me-1"></i>Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Detail Modal -->
                    <div class="modal fade modal-modern" id="logModal{{ $log->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <i class="fas fa-info-circle me-2"></i>Log Detail #{{ $log->id }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body" style="padding: 2rem;">
                                    <h6 style="color: #1a1a1a; font-weight: 600; margin-bottom: 1rem;">
                                        <i class="fas fa-info me-2"></i>Informasi Umum
                                    </h6>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="p-3" style="background: #f8f9fa; border-radius: 10px; margin-bottom: 0.75rem;">
                                                <small class="text-muted d-block mb-1">Waktu</small>
                                                <strong style="color: #1a1a1a;">{{ $log->created_at->format('d F Y, H:i:s') }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3" style="background: #f8f9fa; border-radius: 10px; margin-bottom: 0.75rem;">
                                                <small class="text-muted d-block mb-1">User</small>
                                                @if($log->user)
                                                    <strong style="color: #1a1a1a;">{{ $log->user->name }}</strong>
                                                    <br><small class="text-muted">{{ $log->user->email }}</small>
                                                @else
                                                    <span class="badge" style="background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%); color: #1a1a1a; font-weight: 600;">
                                                        <i class="fas fa-user-plus me-1"></i>Registrasi Baru
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3" style="background: #f8f9fa; border-radius: 10px;">
                                                <small class="text-muted d-block mb-1">IP Address</small>
                                                <strong style="color: #1a1a1a;">{{ $log->ip_address }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3" style="background: #f8f9fa; border-radius: 10px;">
                                                <small class="text-muted d-block mb-1">User Agent</small>
                                                <strong style="color: #1a1a1a; font-size: 0.875rem;">{{ Str::limit($log->user_agent, 30) }}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    @if($log->old_data)
                                    <h6 style="color: #1a1a1a; font-weight: 600; margin-bottom: 1rem; margin-top: 2rem;">
                                        <i class="fas fa-history me-2"></i>Data Lama
                                    </h6>
                                    <div class="code-block">
                                        <pre style="margin: 0; font-size: 0.875rem; color: #1a1a1a;">{{ json_encode($log->old_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                    @endif

                                    @if($log->new_data)
                                    <h6 style="color: #1a1a1a; font-weight: 600; margin-bottom: 1rem; margin-top: 2rem;">
                                        <i class="fas fa-database me-2"></i>Data Baru
                                    </h6>
                                    <div class="code-block">
                                        <pre style="margin: 0; font-size: 0.875rem; color: #1a1a1a;">{{ json_encode($log->new_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                    @endif
                                </div>
                                <div class="modal-footer" style="border: none; padding: 1rem 2rem 2rem;">
                                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; border-radius: 10px; padding: 0.6rem 1.5rem;">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                            <p class="mb-0">Tidak ada activity logs ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="p-3" style="background: #f8f9fa; border-top: 1px solid #dee2e6;">
            {{ $logs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
