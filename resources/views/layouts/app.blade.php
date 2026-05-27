<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Apotek POS')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-emerald: #10b981;
            --deep-emerald: #065f46;
            --soft-emerald: #ecfdf5;
        }
        body { 
            background: #f8fafc; 
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
        }
        .sidebar { 
            height: 100vh; 
            background: #0f172a; 
            width: 260px; 
            position: fixed; 
            top: 0; 
            left: 0; 
            z-index: 100; 
            transition: all 0.3s; 
            display: flex; 
            flex-direction: column; 
        }
        .sidebar .brand { 
            padding: 1.5rem; 
            border-bottom: 1px solid rgba(255,255,255,0.05); 
            flex-shrink: 0; 
        }
        .sidebar-nav-container { 
            flex: 1; 
            overflow-y: auto; 
            overflow-x: hidden; 
        }
        .sidebar-nav-container::-webkit-scrollbar { width: 4px; }
        .sidebar-nav-container::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        
        .sidebar .nav-link { 
            color: #94a3b8; 
            padding: 0.75rem 1.25rem; 
            border-radius: 12px; 
            margin: 4px 12px; 
            font-weight: 500; 
            transition: all 0.2s; 
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .sidebar .nav-link.active { background: var(--primary-emerald); color: #fff; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25); }
        .sidebar .nav-link i { width: 24px; font-size: 1.1rem; flex-shrink: 0; }
        
        .sidebar-footer { 
            flex-shrink: 0; 
            padding: 1.5rem; 
            border-top: 1px solid rgba(255,255,255,0.05); 
            background: #0f172a;
        }
        
        .main-content { margin-left: 260px; padding: 2rem; transition: all 0.3s; }
        .topbar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 1rem 2rem; margin: -2rem -2rem 2rem; }
        
        .card { border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03); }
        .card-header { background-color: transparent; border-bottom: 1px solid #f1f5f9; padding: 1.25rem 1.5rem; font-weight: 700; color: #334155; }
        
        .btn-primary { background-color: var(--primary-emerald); border-color: var(--primary-emerald); border-radius: 10px; padding: 0.5rem 1.25rem; font-weight: 600; }
        .btn-primary:hover { background-color: var(--deep-emerald); border-color: var(--deep-emerald); }
        
        .form-label { font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem; }
        .form-control, .form-select { border-radius: 10px; padding: 0.625rem 1rem; border: 1px solid #e2e8f0; font-size: 0.95rem; }
        .form-control:focus, .form-select:focus { border-color: var(--primary-emerald); box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
        .input-group-text { background-color: #f8fafc; border-color: #e2e8f0; color: #64748b; border-radius: 10px; }
        
        .table thead th { background-color: #f8fafc; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; color: #64748b; border-top: none; padding: 1rem 1.5rem; }
        .table tbody td { padding: 1rem 1.5rem; vertical-align: middle; color: #475569; border-bottom-color: #f1f5f9; }
        
        .badge { padding: 0.5em 0.8em; border-radius: 6px; font-weight: 600; }
        .badge-emerald { background-color: var(--soft-emerald); color: var(--deep-emerald); }

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 1rem; }
            .topbar { margin: -1rem -1rem 1rem; padding: 1rem; }
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 90;
        }
        .sidebar-backdrop.show { display: block; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="brand text-white fw-bold fs-5">
            <i class="fa fa-clinic-medical me-2" style="color: #10b981;"></i>Apotek POS
        </div>
        
        <div class="sidebar-nav-container">
            <nav class="nav flex-column mt-2">
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
        </div>

        <div class="sidebar-footer">
            <small class="text-muted d-block mb-1">{{ auth()->user()->name }}</small>
            <small class="badge text-uppercase mb-2 d-inline-block" style="background-color: #10b981;">{{ auth()->user()->role->name }}</small>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-sm btn-outline-danger w-100">
                    <i class="fa fa-sign-out-alt me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <div class="main-content">
        <div class="topbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark d-md-none me-3 p-0" id="sidebarToggle">
                    <i class="fa fa-bars fs-4"></i>
                </button>
                <h6 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h6>
            </div>
            <small class="text-muted d-none d-sm-block">{{ now()->isoFormat('dddd, D MMMM Y') }}</small>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.add('show');
                    sidebarBackdrop.classList.add('show');
                });
            }

            if (sidebarBackdrop) {
                sidebarBackdrop.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarBackdrop.classList.remove('show');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>