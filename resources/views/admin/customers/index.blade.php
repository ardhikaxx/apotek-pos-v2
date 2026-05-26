@extends('layouts.app')
@section('title', 'Pelanggan')
@section('page-title', 'Pelanggan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="fa fa-users me-2 text-info"></i>Daftar Pelanggan</span>
        <a href="{{ route('admin.customers.create') }}" class="btn btn-info btn-sm text-white">
            <i class="fa fa-plus me-1"></i> Tambah Pelanggan
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Nama</th><th>Email</th><th>No. Telp</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $customer->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $customer->is_active ? 'Aktif' : 'Non-aktif' }}
                        </span>
                    </td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-outline-warning"><i class="fa fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" onsubmit="return confirm('Hapus pelanggan ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-3">Belum ada data pelanggan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
