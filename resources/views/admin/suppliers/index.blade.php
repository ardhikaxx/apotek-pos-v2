@extends('layouts.app')
@section('title', 'Supplier')
@section('page-title', 'Supplier')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="fa fa-truck me-2 text-info"></i>Daftar Supplier</span>
        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-info btn-sm text-white">
            <i class="fa fa-plus me-1"></i> Tambah
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Nama Supplier</th><th>Telepon</th><th>Alamat</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->phone ?? '-' }}</td>
                    <td>{{ $supplier->address ?? '-' }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline-warning"><i class="fa fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier) }}" onsubmit="return confirm('Hapus supplier ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Belum ada supplier</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
