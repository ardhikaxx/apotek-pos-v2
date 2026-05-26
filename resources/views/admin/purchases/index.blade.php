@extends('layouts.app')
@section('title', 'Pembelian Stok')
@section('page-title', 'Pembelian Obat & Stok')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                <i class="fa fa-shopping-cart text-primary"></i>
            </div>
            <h5 class="mb-0 fw-bold">Riwayat Pembelian</h5>
        </div>
        <a href="{{ route('admin.purchases.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2 border-0" style="background-color: #10b981;">
            <i class="fa fa-plus-circle"></i> Catat Pembelian Baru
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>Supplier</th>
                        <th>Total Pembelian</th>
                        <th>Admin / Pembeli</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $p)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($p->purchase_date)->format('d M Y') }}</div>
                            <small class="text-muted">Pukul: {{ \Carbon\Carbon::parse($p->purchase_date)->format('H:i') }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa fa-truck small text-muted"></i>
                                <span class="fw-medium">{{ $p->supplier->name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-dark">Rp {{ number_format($p->total, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem;">
                                    <i class="fa fa-user text-muted"></i>
                                </div>
                                <span class="small">{{ $p->user->name }}</span>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.purchases.show', $p) }}" class="btn btn-sm btn-light border-0">
                                <i class="fa fa-eye text-muted me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fa fa-shopping-basket fa-3x mb-3 opacity-25"></i>
                            <p class="text-muted mb-0">Belum ada riwayat pembelian stok</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
