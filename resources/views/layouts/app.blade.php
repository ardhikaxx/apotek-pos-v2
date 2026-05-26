<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Apotek POS')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #1e293b; width: 240px; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar .brand { padding: 1.2rem 1.5rem; border-bottom: 1px solid #334155; }
        .sidebar .nav-link { color: #94a3b8; padding: .6rem 1.5rem; border-radius: 6px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #334155; color: #fff; }
        .sidebar .nav-link i { width: 20px; }
        .main-content { margin-left: 240px; padding: 1.5rem; }
        .topbar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: .75rem 1.5rem; margin: -1.5rem -1.5rem 1.5rem; }
        .badge-stock { font-size: .7rem; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar d-flex flex-column">
        <div class="brand text-white fw-bold fs-5">
            <i class="fa fa-clinic-medical me-2 text-info"></i>Apotek POS
        </div>
        <nav class="nav flex-column mt-2 grow">
            @if(auth()->user()->role->name === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa fa-user-shield me-2"></i> Manajemen User
                </a>
                <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i class="fa fa-users me-2"></i> Pelanggan
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fa fa-tags me-2"></i> Kategori
                </a>
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fa fa-pills me-2"></i> Obat / Produk
                </a>
                <a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
                    <i class="fa fa-truck me-2"></i> Supplier
                </a>
                <a href="{{ route('admin.purchases.index') }}" class="nav-link {{ request()->routeIs('admin.purchases.*') ? 'active' : '' }}">
                    <i class="fa fa-shopping-cart me-2"></i> Pembelian Stok
                </a>
                <a href="{{ route('admin.transactions.create') }}" class="nav-link {{ request()->routeIs('admin.transactions.create') ? 'active' : '' }}">
                    <i class="fa fa-cash-register me-2"></i> POS / Kasir
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="nav-link {{ request()->routeIs('admin.transactions.index') ? 'active' : '' }}">
                    <i class="fa fa-list me-2"></i> Transaksi
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                    <i class="fa fa-chart-bar me-2"></i> Laporan
                </a>
            @elseif(auth()->user()->role->name === 'apoteker')
                <a href="{{ route('apoteker.dashboard') }}" class="nav-link {{ request()->routeIs('apoteker.dashboard') ? 'active' : '' }}">
                    <i class="fa fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a href="{{ route('apoteker.pos') }}" class="nav-link {{ request()->routeIs('apoteker.pos') ? 'active' : '' }}">
                    <i class="fa fa-cash-register me-2"></i> POS / Kasir
                </a>
                <a href="{{ route('apoteker.products.index') }}" class="nav-link {{ request()->routeIs('apoteker.products.*') ? 'active' : '' }}">
                    <i class="fa fa-pills me-2"></i> Obat / Produk
                </a>
                <a href="{{ route('apoteker.reports') }}" class="nav-link {{ request()->routeIs('apoteker.reports*') ? 'active' : '' }}">
                    <i class="fa fa-chart-bar me-2"></i> Laporan Hari Ini
                </a>
            @elseif(auth()->user()->role->name === 'pelanggan')
                <a href="{{ route('pelanggan.products.index') }}" class="nav-link {{ request()->routeIs('pelanggan.products.*') ? 'active' : '' }}">
                    <i class="fa fa-pills me-2"></i> Katalog Obat
                </a>
            @endif
        </nav>
        <div class="p-3 border-top border-secondary">
            <small class="text-muted d-block mb-1">{{ auth()->user()->name }}</small>
            <small class="badge bg-info text-uppercase">{{ auth()->user()->role->name }}</small>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button class="btn btn-sm btn-outline-danger w-100">
                    <i class="fa fa-sign-out-alt me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h6>
            <small class="text-muted">{{ now()->isoFormat('dddd, D MMMM Y') }}</small>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
