@extends('layouts.app')
@section('title', 'Pembelian Obat')
@section('page-title', 'Pembelian Obat')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="fa fa-shopping-cart me-2 text-info"></i>Daftar Pembelian Obat</span>
        <a href="{{ route('admin.purchases.create') }}" class="btn btn-info btn-sm text-white">
            <i class="fa fa-plus me-1"></i> Catat Pembelian
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Tanggal</th><th>Supplier</th><th>Total</th><th>Admin</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($purchases as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->purchase_date)->format('d/m/Y') }}</td>
                    <td>{{ $p->supplier->name }}</td>
                    <td>Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                    <td>{{ $p->user->name }}</td>
                    <td>
                        <a href="{{ route('admin.purchases.show', $p) }}" class="btn btn-sm btn-outline-info"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-3">Belum ada data pembelian</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
