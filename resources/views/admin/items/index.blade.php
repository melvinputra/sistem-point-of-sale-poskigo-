@extends('layouts.admin')

@section('title', 'Data Barang - POSKigo')

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

    .item-image {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .badge-category {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        color: #1a1a1a;
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
    }

    .badge-stock {
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
    }

    .btn-action {
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-edit {
        background: linear-gradient(135deg, #FFD93D 0%, #FFC107 100%);
        color: #1a1a1a;
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
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-2" style="color: #1a1a1a; font-weight: 700;">Data Barang</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Barang</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.items.create') }}" class="btn-add">
            <i class="fas fa-plus me-2"></i>Tambah Barang
        </a>
    </div>
</div>

<!-- Items Table -->
<div class="card card-modern">
    <div class="card-header-modern">
        <h5 class="mb-0" style="color: #1a1a1a; font-weight: 600;">
            <i class="fas fa-box me-2"></i>Daftar Barang
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">ID</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Gambar</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Nama Barang</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Kategori</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Harga</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Stok</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td style="padding: 1rem 1.5rem;">
                            <span class="badge" style="background: #6c757d; color: white; border-radius: 8px; padding: 0.4rem 0.8rem;">
                                #{{ $item->id }}
                            </span>
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="item-image">
                            @else
                                <div class="item-image d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a;">{{ $item->name }}</td>
                        <td style="padding: 1rem 1.5rem;">
                            <span class="badge-category">{{ $item->category->name }}</span>
                        </td>
                        <td style="padding: 1rem 1.5rem; font-weight: 600; color: #5a8e2a;">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            @if($item->stock > 10)
                                <span class="badge-stock" style="background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%); color: white;">
                                    {{ $item->stock }} Unit
                                </span>
                            @elseif($item->stock > 0)
                                <span class="badge-stock" style="background: linear-gradient(135deg, #FFD93D 0%, #FFC107 100%); color: #1a1a1a;">
                                    {{ $item->stock }} Unit
                                </span>
                            @else
                                <span class="badge-stock" style="background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%); color: white;">
                                    Habis
                                </span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-sm btn-action btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-action btn-delete" onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                            <p class="mb-0">Belum ada data barang</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
        <div class="p-3" style="background: #f8f9fa; border-top: 1px solid #dee2e6;">
            {{ $items->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
