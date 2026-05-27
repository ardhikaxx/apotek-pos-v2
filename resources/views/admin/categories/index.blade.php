@extends('layouts.app')
@section('title', 'Kategori Produk')
@section('page-title', 'Kategori Obat')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 flex-wrap gap-2">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                <i class="fa fa-tags text-primary"></i>
            </div>
            <h5 class="mb-0 fw-bold">Daftar Kategori</h5>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2 border-0" style="background-color: #10b981;">
            <i class="fa fa-plus"></i> Tambah Kategori
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Produk</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $cat->name }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark fw-medium border px-3">{{ $cat->products_count }} Produk</span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-white btn-sm border" title="Edit">
                                    <i class="fa fa-edit text-warning"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Hapus kategori ini?')" class="d-inline">
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
                        <td colspan="4" class="text-center py-5">
                            <i class="fa fa-tags fa-3x mb-3 opacity-25"></i>
                            <p class="text-muted mb-0">Belum ada kategori yang terdaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categories->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
