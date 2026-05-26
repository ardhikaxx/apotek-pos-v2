@extends('layouts.app')
@section('title', 'Obat / Produk')
@section('page-title', 'Kelola Obat & Produk')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div class="d-flex align-items-center">
            <div class="bg-soft-emerald p-2 rounded-3 me-3" style="background-color: #ecfdf5;">
                <i class="fa fa-pills text-emerald" style="color: #10b981;"></i>
            </div>
            <h5 class="mb-0 fw-bold">Daftar Produk</h5>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.expired') }}" class="btn btn-light border fw-semibold btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-clock text-warning"></i> Cek Kadaluarsa
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2 border-0" style="background-color: #10b981;">
                <i class="fa fa-plus"></i> Tambah Produk
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Produk</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $product->name }}</div>
                            <small class="text-muted">ID: #{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark fw-medium border">{{ $product->category->name }}</span></td>
                        <td>{{ $product->unit }}</td>
                        <td class="fw-bold text-dark">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                        <td>
                            @if($product->stock <= 5)
                                <span class="text-danger fw-bold"><i class="fa fa-exclamation-triangle me-1"></i>{{ $product->stock }}</span>
                            @else
                                <span class="text-dark">{{ $product->stock }}</span>
                            @endif
                            @if($product->stock == 0)
                                <span class="badge bg-danger rounded-pill ms-1" style="font-size: 0.65rem;">Habis</span>
                            @endif
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge badge-emerald">Aktif</span>
                            @else
                                <span class="badge bg-light text-muted">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                <button class="btn btn-white btn-sm border" title="Tambah Stok" data-bs-toggle="modal" data-bs-target="#stockModal{{ $product->id }}">
                                    <i class="fa fa-plus-circle text-success"></i>
                                </button>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-white btn-sm border" title="Edit">
                                    <i class="fa fa-edit text-warning"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-white btn-sm border" title="Hapus">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Tambah Stok -->
                    <div class="modal fade" id="stockModal{{ $product->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <div class="modal-header border-0 pb-0">
                                    <h6 class="modal-title fw-bold">Tambah Stok</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('admin.products.stock', $product) }}">
                                    @csrf
                                    <div class="modal-body py-4">
                                        <div class="text-center mb-4">
                                            <div class="text-muted small mb-1">Produk</div>
                                            <div class="fw-bold text-dark">{{ $product->name }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-secondary">Jumlah Stok Baru</label>
                                            <input type="number" name="qty" class="form-control form-control-lg border-2" placeholder="0" min="1" required style="border-radius: 12px;">
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="submit" class="btn btn-primary w-100 py-2 border-0" style="background-color: #10b981; border-radius: 12px;">Konfirmasi Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fa fa-pills fa-3x mb-3 opacity-25"></i>
                            <p class="text-muted mb-0">Belum ada produk yang terdaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($products->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
