@extends('layouts.app')
@section('title', 'Daftar Pelanggan')
@section('page-title', 'Manajemen Pelanggan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                <i class="fa fa-users text-primary"></i>
            </div>
            <h5 class="mb-0 fw-bold">Daftar Pelanggan</h5>
        </div>
        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2 border-0" style="background-color: #10b981;">
            <i class="fa fa-user-plus"></i> Tambah Pelanggan
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Pelanggan</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-soft-emerald d-flex align-items-center justify-content-center fw-bold text-emerald" style="width: 40px; height: 40px; background-color: #ecfdf5; color: #10b981;">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $customer->name }}</div>
                                    <small class="text-muted">ID: #CST-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted small">{{ $customer->email }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa fa-phone small text-muted"></i>
                                <span class="small text-dark">{{ $customer->phone ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            @if($customer->is_active)
                                <span class="badge badge-emerald">Aktif</span>
                            @else
                                <span class="badge bg-light text-muted">Non-aktif</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-white btn-sm border" title="Edit">
                                    <i class="fa fa-edit text-warning"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" onsubmit="return confirm('Hapus pelanggan ini?')" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-white btn-sm border" title="Hapus">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fa fa-user-friends fa-3x mb-3 opacity-25"></i>
                            <p class="text-muted mb-0">Belum ada data pelanggan yang terdaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
