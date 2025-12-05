@extends('layouts.kasir')

@section('title', 'Data Pelanggan - POSKigo')

@section('content')
<style>
    .page-header-modern {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-header-modern h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .breadcrumb-modern {
        background: transparent;
        padding: 0;
        margin: 0.5rem 0 0 0;
        font-size: 0.9rem;
    }

    .breadcrumb-modern a {
        color: #6a6a6a;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-modern a:hover {
        color: #9FE869;
    }

    .card-modern {
        background: #ffffff;
        border: 2px solid #f0f0f0;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .card-header-modern {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.15) 0%, rgba(159, 232, 105, 0.1) 100%);
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #f0f0f0;
    }

    .card-header-modern h5 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1a1a;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .table-modern {
        width: 100%;
    }

    .table-modern thead {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.1) 0%, rgba(159, 232, 105, 0.05) 100%);
    }

    .table-modern thead th {
        font-weight: 700;
        color: #1a1a1a;
        border: none;
        padding: 1.2rem 1rem;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table-modern tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f5f5f5;
    }

    .table-modern tbody tr:hover {
        background: rgba(196, 255, 87, 0.05);
        transform: scale(1.01);
    }

    .table-modern tbody td {
        padding: 1.2rem 1rem;
        vertical-align: middle;
        border: none;
    }

    .btn-modern-primary {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        color: #1a1a1a;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(196, 255, 87, 0.4);
        color: #1a1a1a;
    }

    .btn-modern-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 0.5rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-modern-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
        color: white;
    }

    .btn-modern-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 0.5rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-modern-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
        color: white;
    }

    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.2) 0%, rgba(159, 232, 105, 0.15) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.8rem;
        color: #5a8e2a;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 5rem;
        color: #d0d0d0;
        margin-bottom: 1.5rem;
    }

    .empty-state p {
        color: #6a6a6a;
        font-size: 1.1rem;
    }
</style>

<div class="page-header-modern">
    <div>
        <h1>
            <i class="fas fa-users"></i>
            Data Pelanggan
        </h1>
        <nav class="breadcrumb-modern">
            <a href="{{ route('kasir.dashboard') }}">Dashboard</a>
            <span class="mx-2">/</span>
            <span>Data Pelanggan</span>
        </nav>
    </div>
    <a href="{{ route('kasir.customers.create') }}" class="btn btn-modern-primary">
        <i class="fas fa-user-plus"></i> Tambah Pelanggan
    </a>
</div>

<div class="card-modern">
    <div class="card-header-modern">
        <h5>
            <i class="fas fa-address-book"></i>
            Daftar Pelanggan
        </h5>
    </div>
    <div class="p-3">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pelanggan</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th>Terdaftar</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>
                            <span class="badge bg-light text-dark" style="padding: 0.4rem 0.8rem; border-radius: 8px; font-weight: 600;">
                                #{{ $customer->id }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="customer-avatar">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong>{{ $customer->name }}</strong>
                                </div>
                            </div>
                        </td>
                        <td>
                            <i class="fas fa-phone me-2 text-muted"></i>
                            {{ $customer->phone ?? '-' }}
                        </td>
                        <td>
                            <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                            {{ Str::limit($customer->address ?? '-', 40) }}
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <strong style="font-size: 0.9rem;">{{ $customer->created_at->format('d/m/Y') }}</strong>
                                <small class="text-muted">
                                    <i class="far fa-calendar me-1"></i>{{ $customer->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('kasir.customers.edit', $customer->id) }}" class="btn btn-modern-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kasir.customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-modern-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-user-friends"></i>
                                <p class="mb-0"><strong>Belum ada data pelanggan</strong></p>
                                <small class="text-muted">Tambahkan pelanggan baru untuk memulai</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->count() > 0)
        <div class="mt-3 px-3">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
