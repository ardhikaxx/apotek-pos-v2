@extends('layouts.app')
@section('title', 'Detail Pembelian')
@section('page-title', 'Detail Pembelian')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-info">Informasi Pembelian</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr><td class="text-muted">No. Referensi</td><td class="fw-bold">#PUR-{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</td></tr>
                    <tr><td class="text-muted">Tanggal</td><td class="fw-bold">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</td></tr>
                    <tr><td class="text-muted">Supplier</td><td class="fw-bold">{{ $purchase->supplier->name }}</td></tr>
                    <tr><td class="text-muted">Admin</td><td class="fw-bold">{{ $purchase->user->name }}</td></tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr><td class="text-muted fs-5">Total</td><td class="fw-bold text-info fs-5">Rp {{ number_format($purchase->total, 0, ',', '.') }}</td></tr>
                </table>
                <hr>
                <a href="{{ route('admin.purchases.index') }}" class="btn btn-light w-100">Kembali</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-info">Daftar Item</h6>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga Beli</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchase->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name }} ({{ $item->product->unit }})</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">Rp {{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
