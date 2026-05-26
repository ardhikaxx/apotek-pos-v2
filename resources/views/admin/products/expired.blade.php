@extends('layouts.app')
@section('title', 'Obat Kadaluarsa')
@section('page-title', 'Obat Kadaluarsa')

@section('content')
<div class="alert alert-warning border-0 shadow-sm mb-4">
    <i class="fa fa-exclamation-triangle me-2"></i>
    Daftar obat di bawah ini telah melewati tanggal kadaluarsa.
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-danger"><i class="fa fa-skull-crossbones me-2"></i>Produk Kadaluarsa (Admin View)</span>
        <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm">Kembali</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Nama</th><th>Kategori</th><th>Stok Tersisa</th><th>Tanggal Kadaluarsa</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }} <br><small class="text-muted">{{ $product->unit }}</small></td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->stock }}</td>
                    <td class="text-danger fw-bold">{{ \Carbon\Carbon::parse($product->expiry_date)->format('d/m/Y') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk kadaluarsa ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash me-1"></i>Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-3">Tidak ada produk kadaluarsa</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
