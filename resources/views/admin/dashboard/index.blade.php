@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-info bg-opacity-10 rounded p-3"><i class="fa fa-pills fa-lg text-info"></i></div>
                <div>
                    <div class="text-muted small">Total Produk</div>
                    <div class="fw-bold fs-4">{{ $totalProducts }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 rounded p-3"><i class="fa fa-users fa-lg text-success"></i></div>
                <div>
                    <div class="text-muted small">Total User</div>
                    <div class="fw-bold fs-4">{{ $totalUsers }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 rounded p-3"><i class="fa fa-cash-register fa-lg text-primary"></i></div>
                <div>
                    <div class="text-muted small">Penjualan Hari Ini</div>
                    <div class="fw-bold fs-5">Rp {{ number_format($todayTotal, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 rounded p-3"><i class="fa fa-exclamation-triangle fa-lg text-warning"></i></div>
                <div>
                    <div class="text-muted small">Stok Habis</div>
                    <div class="fw-bold fs-4">{{ $lowStock }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">Transaksi Terbaru</div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th>Invoice</th><th>Kasir</th><th>Total</th><th>Tanggal</th><th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTx as $tx)
                <tr>
                    <td>{{ $tx->invoice_number }}</td>
                    <td>{{ $tx->user->name }}</td>
                    <td>Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                    <td>{{ $tx->transaction_date->format('d/m/Y H:i') }}</td>
                    <td><a href="{{ route('admin.transactions.show', $tx) }}" class="btn btn-sm btn-outline-info"><i class="fa fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Belum ada transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
