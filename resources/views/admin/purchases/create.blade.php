@extends('layouts.app')
@section('title', 'Catat Pembelian')
@section('page-title', 'Catat Pembelian')

@section('content')
<form action="{{ route('admin.purchases.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-info">Informasi Pembelian</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pembelian</label>
                        <input type="date" name="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" value="{{ date('Y-m-d') }}" required>
                        @error('purchase_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-info w-100 text-white fw-bold">Simpan Pembelian</button>
                    <a href="{{ route('admin.purchases.index') }}" class="btn btn-light w-100 mt-2">Batal</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-info">Detail Produk</h6>
                    <button type="button" id="add-item" class="btn btn-sm btn-outline-info"><i class="fa fa-plus me-1"></i>Tambah Produk</button>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0" id="purchase-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40%">Produk</th>
                                <th style="width: 20%">Jumlah</th>
                                <th style="width: 30%">Harga Beli Satuan</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody id="purchase-items">
                            <tr>
                                <td>
                                    <select name="items[0][product_id]" class="form-select" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->unit }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="items[0][quantity]" class="form-control" min="1" required>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="items[0][purchase_price]" class="form-control" min="0" required>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    let itemIndex = 1;
    document.getElementById('add-item').addEventListener('click', function() {
        const tbody = document.getElementById('purchase-items');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <select name="items[${itemIndex}][product_id]" class="form-select" required>
                    <option value="">Pilih Produk</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->unit }})</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control" min="1" required>
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="items[${itemIndex}][purchase_price]" class="form-control" min="0" required>
                </div>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger remove-item"><i class="fa fa-times"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
        itemIndex++;
    });

    document.getElementById('purchase-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item') || e.target.parentElement.classList.contains('remove-item')) {
            const btn = e.target.classList.contains('remove-item') ? e.target : e.target.parentElement;
            btn.closest('tr').remove();
        }
    });
</script>
@endpush
@endsection
