@extends('layouts.app')
@section('title', 'Dashboard Apoteker')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-info bg-opacity-10 rounded p-3"><i class="fa fa-cash-register fa-lg text-info"></i></div>
                <div>
                    <div class="text-muted small">Transaksi Hari Ini</div>
                    <div class="fw-bold fs-4">{{ $todayTx }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 rounded p-3"><i class="fa fa-chart-bar fa-lg text-success"></i></div>
                <div>
                    <div class="text-muted small">Total Penjualan Hari Ini</div>
                    <div class="fw-bold fs-5">Rp {{ number_format($todayTotal, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
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
    <div class="card-header bg-white fw-semibold">Transaksi Saya Hari Ini</div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr><th>Invoice</th><th>Total</th><th>Tanggal</th></tr>
            </thead>
            <tbody>
                @forelse($recentTx as $tx)
                <tr>
                    <td>{{ $tx->invoice_number }}</td>
                    <td>Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                    <td>{{ $tx->transaction_date->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-3">Belum ada transaksi hari ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
