@extends('layouts.admin')

@section('title', 'Kelola Promo - POSKigo Admin')

@section('content')
<h1 class="mt-4">Kelola Promo & Voucher</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Promo</li>
</ol>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-tags me-1"></i> Daftar Promo
            </div>
            <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Promo
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($promotions->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Judul</th>
                            <th>Diskon</th>
                            <th>Min. Pembelian</th>
                            <th>Penggunaan</th>
                            <th>Masa Berlaku</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promotions as $promo)
                        <tr>
                            <td><strong class="text-primary">{{ $promo->code }}</strong></td>
                            <td>{{ $promo->title }}</td>
                            <td>
                                @if($promo->type == 'percentage')
                                    <span class="badge bg-success">{{ $promo->discount_value }}%</span>
                                @else
                                    <span class="badge bg-info">Rp {{ number_format($promo->discount_value, 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($promo->min_purchase, 0, ',', '.') }}</td>
                            <td>
                                {{ $promo->usage_count }} / {{ $promo->max_usage ?? '∞' }}
                            </td>
                            <td>
                                <small>{{ $promo->valid_from->format('d/m/Y') }} - {{ $promo->valid_until->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                @if($promo->isValid())
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.promotions.edit', $promo->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.promotions.toggle', $promo->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-{{ $promo->is_active ? 'secondary' : 'success' }}">
                                            <i class="fas fa-{{ $promo->is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus promo ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $promotions->links() }}
        @else
            <div class="text-center py-4">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada promo</p>
                <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Promo Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
