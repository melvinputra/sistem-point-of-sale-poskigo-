@extends('layouts.admin')

@section('title', 'Kelola Promo - POSKigo Admin')

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
    }

    .card-header-modern {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        padding: 1.25rem 1.5rem;
        border: none;
    }

    .btn-add {
        background: #1a1a1a;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        background: #2a2a2a;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .promo-code {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        font-size: 1rem;
        color: #5a8e2a;
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        display: inline-block;
    }

    .badge-discount {
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
    }

    .badge-status {
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
    }

    .btn-action {
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        border: none;
        transition: all 0.2s ease;
        margin: 0 0.15rem;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-edit {
        background: linear-gradient(135deg, #FFD93D 0%, #FFC107 100%);
        color: #1a1a1a;
    }

    .btn-toggle {
        background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%);
        color: white;
    }

    .table-modern tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s ease;
    }

    .table-modern tbody tr:hover {
        background: #f8f9fa;
    }

    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 4rem;
        opacity: 0.3;
        margin-bottom: 1.5rem;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-2" style="color: #1a1a1a; font-weight: 700;">Kelola Promo & Voucher</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Promo</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.promotions.create') }}" class="btn-add">
            <i class="fas fa-plus me-2"></i>Tambah Promo
        </a>
    </div>
</div>

<!-- Promotions Table -->
<div class="card card-modern">
    <div class="card-header-modern">
        <h5 class="mb-0" style="color: #1a1a1a; font-weight: 600;">
            <i class="fas fa-tags me-2"></i>Daftar Promo
        </h5>
    </div>
    <div class="card-body p-0">
        @if($promotions->count() > 0)
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Kode</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Judul</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Diskon</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Min. Pembelian</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Penggunaan</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Masa Berlaku</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Status</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promotions as $promo)
                        <tr>
                            <td style="padding: 1rem 1.5rem;">
                                <div class="promo-code">{{ $promo->code }}</div>
                            </td>
                            <td style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a;">{{ $promo->title }}</td>
                            <td style="padding: 1rem 1.5rem;">
                                @if($promo->type == 'percentage')
                                    <span class="badge-discount" style="background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%); color: white;">
                                        <i class="fas fa-percentage me-1"></i>{{ $promo->discount_value }}%
                                    </span>
                                @else
                                    <span class="badge-discount" style="background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%); color: white;">
                                        <i class="fas fa-money-bill me-1"></i>Rp {{ number_format($promo->discount_value, 0, ',', '.') }}
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem; color: #666;">
                                Rp {{ number_format($promo->min_purchase, 0, ',', '.') }}
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <span class="badge" style="background: #6c757d; color: white; border-radius: 8px; padding: 0.4rem 0.8rem;">
                                    {{ $promo->usage_count }} / {{ $promo->max_usage ?? '∞' }}
                                </span>
                            </td>
                            <td style="padding: 1rem 1.5rem; color: #666;">
                                <small>
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $promo->valid_from->format('d/m/Y') }}<br>
                                    <i class="fas fa-arrow-right me-1"></i>
                                    {{ $promo->valid_until->format('d/m/Y') }}
                                </small>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                @if($promo->isValid())
                                    <span class="badge-status" style="background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%); color: white;">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge-status" style="background: #6c757d; color: white;">
                                        <i class="fas fa-times-circle me-1"></i>Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <a href="{{ route('admin.promotions.edit', $promo->id) }}" class="btn btn-sm btn-action btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.promotions.toggle', $promo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-action btn-toggle">
                                        <i class="fas fa-{{ $promo->is_active ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus promo ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-action btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($promotions->hasPages())
            <div class="p-3" style="background: #f8f9fa; border-top: 1px solid #dee2e6;">
                {{ $promotions->links() }}
            </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-tags d-block text-muted"></i>
                <h5 class="mb-3 text-muted">Belum ada promo</h5>
                <a href="{{ route('admin.promotions.create') }}" class="btn-add">
                    <i class="fas fa-plus me-2"></i>Tambah Promo Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
