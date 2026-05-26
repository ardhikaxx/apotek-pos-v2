@extends('layouts.app')
@section('title', 'Dashboard Apoteker')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                        <i class="fa fa-cash-register fa-lg text-primary"></i>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary small">Hari Ini</span>
                </div>
                <div class="text-muted small fw-medium mb-1">Transaksi Anda</div>
                <div class="fw-bold fs-3 text-dark">{{ number_format($todayTx) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-emerald bg-opacity-10 rounded-3 p-3" style="background-color: rgba(16, 185, 129, 0.1);">
                        <i class="fa fa-chart-line fa-lg" style="color: #10b981;"></i>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success small">Pendapatan</span>
                </div>
                <div class="text-muted small fw-medium mb-1">Total Penjualan</div>
                <div class="fw-bold fs-4 text-dark">Rp {{ number_format($todayTotal, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                        <i class="fa fa-exclamation-triangle fa-lg text-danger"></i>
                    </div>
                    <span class="badge bg-danger bg-opacity-10 text-danger small">Penting</span>
                </div>
                <div class="text-muted small fw-medium mb-1">Stok Habis / Menipis</div>
                <div class="fw-bold fs-3 text-dark">{{ number_format($lowStock) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <span class="fs-5">Transaksi Anda Hari Ini</span>
                <a href="{{ route('apoteker.reports') }}" class="btn btn-sm btn-link text-emerald fw-bold text-decoration-none" style="color: #10b981;">Lihat Laporan</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Invoice</th>
                                <th>Total Transaksi</th>
                                <th>Waktu</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTx as $tx)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">{{ $tx->invoice_number }}</td>
                                <td><span class="fw-bold text-emerald" style="color: #059669;">Rp {{ number_format($tx->total, 0, ',', '.') }}</span></td>
                                <td class="text-muted small">{{ $tx->transaction_date->format('H:i') }} <span class="opacity-50">WIB</span></td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('apoteker.pos.show', $tx) }}" class="btn btn-sm btn-light border-0">
                                        <i class="fa fa-eye text-muted"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa fa-inbox fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">Belum ada transaksi yang Anda catat hari ini</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <span class="fs-5">Aksi Cepat</span>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <a href="{{ route('apoteker.pos') }}" class="btn btn-emerald text-white p-3 border-0 d-flex align-items-center justify-content-center gap-2" style="background-color: #10b981; border-radius: 12px;">
                        <i class="fa fa-cash-register"></i> Buka Kasir (POS)
                    </a>
                    <a href="{{ route('apoteker.products.index') }}" class="btn btn-light p-3 border-0 d-flex align-items-center justify-content-center gap-2 text-dark" style="border-radius: 12px;">
                        <i class="fa fa-pills text-emerald" style="color: #10b981;"></i> Cek Stok Obat
                    </a>
                </div>
                <hr class="my-4 opacity-25">
                <div class="alert bg-soft-emerald border-0 rounded-4 p-3 mb-0" style="background-color: #ecfdf5;">
                    <div class="d-flex gap-3">
                        <i class="fa fa-info-circle text-emerald mt-1" style="color: #10b981;"></i>
                        <div class="small text-dark">
                            Pastikan untuk selalu mencetak struk setelah transaksi selesai sebagai bukti pembayaran.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
