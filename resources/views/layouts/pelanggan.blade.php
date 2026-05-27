<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Apotek Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary-color: #10b981; }
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; color: #1e293b; }
        .navbar-brand { font-weight: 700; color: var(--primary-color) !important; }
        .hero-section { background-color: #1e293b; color: white; padding: 60px 0; margin-bottom: 40px; border-bottom: 4px solid var(--primary-color); }
        @media (max-width: 768px) {
            .hero-section { padding: 40px 0; }
            .hero-section h1 { font-size: 2.25rem; }
            .hero-section p { font-size: 1rem; }
        }
        .footer { background: #1e293b; color: white; padding: 40px 0; margin-top: 60px; }
        .btn-primary-custom { background-color: var(--primary-color); border: none; color: white; border-radius: 8px; font-weight: 500; }
        .btn-primary-custom:hover { background-color: #059669; color: white; }
        .text-teal { color: #10b981 !important; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('pelanggan.products.index') }}">
                <i class="fa fa-clinic-medical me-2"></i>APOTEK
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('pelanggan.products.index') }}">Katalog Obat</a>
                    </li>
                </ul>
                <div class="d-flex flex-wrap align-items-center gap-2 gap-md-3 mt-3 mt-lg-0">
                    @auth
                        <span class="text-muted small w-100 w-lg-auto mb-2 mb-lg-0">Halo, <strong>{{ auth()->user()->name }}</strong></span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-teal btn-sm px-3 rounded-pill" style="color: #10b981; border-color: #10b981;">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-teal btn-sm text-white px-3 rounded-pill" style="background-color: #10b981;">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if(request()->routeIs('pelanggan.products.index'))
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Solusi Kesehatan Terpercaya</h1>
            <p class="lead opacity-75">Cari dan temukan obat yang Anda butuhkan dengan mudah dan cepat.</p>
        </div>
    </div>
    @endif

    <div class="container min-vh-100">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container text-white">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h5 class="fw-bold"><i class="fa fa-clinic-medical me-2 text-teal"></i>APOTEK</h5>
                    <p class="small text-white-50">Melayani kebutuhan obat-obatan dan alat kesehatan Anda dengan sepenuh hati.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6>Kontak Kami</h6>
                    <ul class="list-unstyled small text-white-50">
                        <li><i class="fa fa-phone me-2 text-teal"></i> 021-0000000</li>
                        <li><i class="fa fa-map-marker-alt me-2 text-teal"></i> Jl. Kesehatan No. 1</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary opacity-25">
            <div class="text-center small text-white-50">
                &copy; {{ date('Y') }} Apotek. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
