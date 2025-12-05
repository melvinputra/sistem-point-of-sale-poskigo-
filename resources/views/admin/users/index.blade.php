@extends('layouts.admin')

@section('title', 'Data User - POSKigo')

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

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .badge-role {
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
            <h1 class="mb-2" style="color: #1a1a1a; font-weight: 700;">Data User</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data User</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-add">
            <i class="fas fa-plus me-2"></i>Tambah User
        </a>
    </div>
</div>

<!-- Users Table -->
<div class="card card-modern">
    <div class="card-header-modern">
        <h5 class="mb-0" style="color: #1a1a1a; font-weight: 600;">
            <i class="fas fa-users me-2"></i>Daftar User
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">ID</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">User</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Email</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Role</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Terdaftar</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td style="padding: 1rem 1.5rem;">
                            <span class="badge" style="background: #6c757d; color: white; border-radius: 8px; padding: 0.4rem 0.8rem;">
                                #{{ $user->id }}
                            </span>
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            <div class="d-flex align-items-center">
                                @php
                                    $colors = ['#C4FF57', '#9FE869', '#FFD93D', '#4FC3F7', '#FF6B6B'];
                                    $color = $colors[$user->id % count($colors)];
                                    $initials = strtoupper(substr($user->name, 0, 1));
                                @endphp
                                <div class="user-avatar" style="background: linear-gradient(135deg, {{ $color }}, {{ $color }}dd);">
                                    {{ $initials }}
                                </div>
                                <div class="ms-3">
                                    <div style="font-weight: 600; color: #1a1a1a;">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 1rem 1.5rem; color: #666;">
                            <i class="fas fa-envelope me-1"></i>{{ $user->email }}
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            @if($user->role == 'admin')
                                <span class="badge-role" style="background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%); color: white;">
                                    <i class="fas fa-user-shield me-1"></i>Admin
                                </span>
                            @elseif($user->role == 'kasir')
                                <span class="badge-role" style="background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%); color: white;">
                                    <i class="fas fa-cash-register me-1"></i>Kasir
                                </span>
                            @else
                                <span class="badge-role" style="background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%); color: white;">
                                    <i class="fas fa-user me-1"></i>Pelanggan
                                </span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.5rem; color: #666;">
                            <i class="fas fa-calendar-alt me-1"></i>{{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-action btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($user->id != auth()->id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-action btn-delete" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @else
                            <button class="btn btn-sm btn-action" disabled style="background: #dee2e6; color: #6c757d; cursor: not-allowed;">
                                <i class="fas fa-lock"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-users-slash fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                            <p class="mb-0">Belum ada data user</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-3" style="background: #f8f9fa; border-top: 1px solid #dee2e6;">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
