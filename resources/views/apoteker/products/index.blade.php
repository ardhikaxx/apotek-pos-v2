@extends('layouts.app')
@section('title', 'Obat / Produk')
@section('page-title', 'Obat / Produk')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <form action="{{ route('apoteker.products.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari nama obat..." value="{{ request('search') }}">
            <button class="btn btn-info text-white"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('apoteker.products.expired') }}" class="btn btn-warning me-2">
            <i class="fa fa-exclamation-triangle me-1"></i> Obat Kadaluarsa
        </a>
        <a href="{{ route('apoteker.products.create') }}" class="btn btn-info text-white">
            <i class="fa fa-plus me-1"></i> Tambah Obat
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">
        <i class="fa fa-pills me-2 text-info"></i>Daftar Produk
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Nama</th><th>Kategori</th><th>Harga Jual</th><th>Stok</th><th>Kadaluarsa</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }} <br><small class="text-muted">{{ $product->unit }}</small></td>
                    <td>{{ $product->category->name }}</td>
                    <td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                    <td>
                        {{ $product->stock }}
                        @if($product->stock == 0)
                            <span class="badge bg-danger badge-stock ms-1">Habis</span>
                        @endif
                    </td>
                    <td>
                        @if($product->expiry_date)
                            <span class="{{ \Carbon\Carbon::parse($product->expiry_date)->isPast() ? 'text-danger fw-bold' : '' }}">
                                {{ \Carbon\Carbon::parse($product->expiry_date)->format('d/m/Y') }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#stockModal{{ $product->id }}" title="Tambah Stok">
                                <i class="fa fa-plus-circle"></i>
                            </button>
                            <a href="{{ route('apoteker.products.edit', $product) }}" class="btn btn-sm btn-outline-warning" title="Edit"><i class="fa fa-edit"></i></a>
                            <form method="POST" action="{{ route('apoteker.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>

                <div class="modal fade" id="stockModal{{ $product->id }}" tabindex="-1">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Tambah Stok — {{ $product->name }}</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('apoteker.products.stock', $product) }}">
                                @csrf
                                <div class="modal-body">
                                    <label class="form-label">Jumlah Tambah</label>
                                    <input type="number" name="qty" class="form-control" min="1" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success btn-sm">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-3">Belum ada produk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="card-footer bg-white">{{ $products->links() }}</div>
    @endif
</div>
@endsection
