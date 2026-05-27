@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="row g-4 mb-5">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-emerald bg-opacity-10 rounded-3 p-3" style="background-color: rgba(16, 185, 129, 0.1);">
                        <i class="fa fa-pills fa-lg" style="color: #10b981;"></i>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success small">+{{ rand(2, 5) }} baru</span>
                </div>
                <div class="text-muted small fw-medium mb-1">Total Produk</div>
                <div class="fw-bold fs-3 text-dark">{{ number_format($totalProducts) }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                        <i class="fa fa-users fa-lg text-primary"></i>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary small">Aktif</span>
                </div>
                <div class="text-muted small fw-medium mb-1">Total Pengguna</div>
                <div class="fw-bold fs-3 text-dark">{{ number_format($totalUsers) }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                        <i class="fa fa-wallet fa-lg text-warning"></i>
                    </div>
                    <span class="badge bg-warning bg-opacity-10 text-warning small">Hari ini</span>
                </div>
                <div class="text-muted small fw-medium mb-1">Penjualan</div>
                <div class="fw-bold fs-4 text-dark">Rp {{ number_format($todayTotal, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                        <i class="fa fa-exclamation-triangle fa-lg text-danger"></i>
                    </div>
                    <span class="badge bg-danger bg-opacity-10 text-danger small">Penting</span>
                </div>
                <div class="text-muted small fw-medium mb-1">Stok Menipis</div>
                <div class="fw-bold fs-3 text-dark">{{ number_format($lowStock) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between flex-wrap gap-2">
                <span class="fs-5">Transaksi Terbaru</span>
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-sm btn-link text-emerald fw-bold text-decoration-none" style="color: #10b981;">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Kasir</th>
                                <th>Total</th>
                                <th>Waktu</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTx as $tx)
                            <tr>
                                <td class="fw-bold text-dark">{{ $tx->invoice_number }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fa fa-user-circle text-muted"></i>
                                        </div>
                                        <span>{{ $tx->user->name }}</span>
                                    </div>
                                </td>
                                <td><span class="fw-bold text-emerald" style="color: #059669;">Rp {{ number_format($tx->total, 0, ',', '.') }}</span></td>
                                <td class="text-muted small">{{ $tx->transaction_date->format('d M, H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.transactions.show', $tx) }}" class="btn btn-sm btn-light border-0">
                                        <i class="fa fa-chevron-right small text-muted"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa fa-inbox fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">Belum ada transaksi hari ini</p>
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
                <span class="fs-5">Aktivitas Cepat</span>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.transactions.create') }}" class="btn btn-emerald text-white p-3 border-0 d-flex align-items-center justify-content-center gap-2" style="background-color: #10b981; border-radius: 12px;">
                        <i class="fa fa-cash-register"></i> Buka Kasir
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-light p-3 border-0 d-flex align-items-center justify-content-center gap-2 text-dark" style="border-radius: 12px;">
                        <i class="fa fa-plus-circle text-emerald" style="color: #10b981;"></i> Tambah Obat Baru
                    </a>
                    <a href="{{ route('admin.reports') }}" class="btn btn-light p-3 border-0 d-flex align-items-center justify-content-center gap-2 text-dark" style="border-radius: 12px;">
                        <i class="fa fa-file-chart-line text-primary"></i> Laporan Penjualan
                    </a>
                </div>
                <hr class="my-4 opacity-25">
                <div class="alert bg-soft-emerald border-0 rounded-4 p-3 mb-0" style="background-color: #ecfdf5;">
                    <div class="d-flex gap-3">
                        <i class="fa fa-lightbulb text-emerald mt-1" style="color: #10b981;"></i>
                        <div class="small text-dark">
                            <strong>Tips:</strong> Selalu cek stok obat yang akan kedaluwarsa secara berkala.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
