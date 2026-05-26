<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Apotek Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root { --primary-color: #0dcaf0; }
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { fw-bold; color: var(--primary-color) !important; }
        .hero-section { background: linear-gradient(135deg, #0dcaf0 0%, #0aa2bd 100%); color: white; padding: 60px 0; margin-bottom: 40px; }
        .footer { background: #343a40; color: white; padding: 40px 0; margin-top: 60px; }
        .btn-primary-custom { background-color: var(--primary-color); border: none; color: white; }
        .btn-primary-custom:hover { background-color: #0baccc; color: white; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('pelanggan.products.index') }}">
                <i class="fa fa-plus-square me-2"></i>APOTEK
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pelanggan.products.index') }}">Katalog Obat</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    @auth
                        <span class="text-muted small">Halo, <strong>{{ auth()->user()->name }}</strong></span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-info btn-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-info btn-sm text-white">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if(request()->routeIs('pelanggan.products.index'))
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Solusi Kesehatan Terpercaya</h1>
            <p class="lead">Cari dan temukan obat yang Anda butuhkan dengan mudah dan cepat.</p>
        </div>
    </div>
    @endif

    <div class="container min-vh-100">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container text-white">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold"><i class="fa fa-plus-square me-2 text-info"></i>APOTEK</h5>
                    <p class="small text-white-50">Melayani kebutuhan obat-obatan dan alat kesehatan Anda dengan sepenuh hati.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6>Kontak Kami</h6>
                    <ul class="list-unstyled small text-white-50">
                        <li><i class="fa fa-phone me-2 text-info"></i> 021-0000000</li>
                        <li><i class="fa fa-map-marker-alt me-2 text-info"></i> Jl. Kesehatan No. 1</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center small text-white-50">
                &copy; {{ date('Y') }} Apotek. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
