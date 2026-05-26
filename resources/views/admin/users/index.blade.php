@extends('layouts.app')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                <i class="fa fa-user-shield text-primary"></i>
            </div>
            <h5 class="mb-0 fw-bold">Daftar Pengguna</h5>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2 border-0" style="background-color: #10b981;">
            <i class="fa fa-user-plus"></i> Tambah Pengguna
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-soft-emerald d-flex align-items-center justify-content-center fw-bold text-emerald" style="width: 40px; height: 40px; background-color: #ecfdf5; color: #10b981;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    <small class="text-muted">Bergabung: {{ $user->created_at->format('M Y') }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            @php
                                $roleClass = match($user->role->name) {
                                    'admin' => 'bg-danger text-danger',
                                    'apoteker' => 'bg-primary text-primary',
                                    default => 'bg-info text-info',
                                };
                            @endphp
                            <span class="badge bg-opacity-10 {{ $roleClass }} text-uppercase" style="font-size: 0.7rem;">{{ $user->role->name }}</span>
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge badge-emerald">Aktif</span>
                            @else
                                <span class="badge bg-light text-muted">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-white btn-sm border" title="Edit">
                                    <i class="fa fa-edit text-warning"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-white btn-sm border" title="Hapus">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fa fa-users fa-3x mb-3 opacity-25"></i>
                            <p class="text-muted mb-0">Belum ada pengguna yang terdaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
