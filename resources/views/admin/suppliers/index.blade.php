@extends('layouts.app')
@section('title', 'Supplier')
@section('page-title', 'Pemasok (Supplier)')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                <i class="fa fa-truck text-primary"></i>
            </div>
            <h5 class="mb-0 fw-bold">Daftar Supplier</h5>
        </div>
        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2 border-0" style="background-color: #10b981;">
            <i class="fa fa-plus"></i> Tambah Supplier
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Supplier</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $supplier->name }}</div>
                            <small class="text-muted">ID: #SUP-{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                    <i class="fa fa-phone small text-muted"></i>
                                </div>
                                <span class="small text-dark">{{ $supplier->phone ?? 'Tidak ada telepon' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="text-muted small text-truncate" style="max-width: 250px;">
                                <i class="fa fa-map-marker-alt me-1 opacity-50"></i> {{ $supplier->address ?? '-' }}
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-white btn-sm border" title="Edit">
                                    <i class="fa fa-edit text-warning"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier) }}" onsubmit="return confirm('Hapus supplier ini?')" class="d-inline">
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
                            <i class="fa fa-truck fa-3x mb-3 opacity-25"></i>
                            <p class="text-muted mb-0">Belum ada supplier yang terdaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
