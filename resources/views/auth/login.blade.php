@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="form-card">
    <div class="mb-5">
        <h2 class="fw-bold text-dark">Selamat Datang Kembali</h2>
        <p class="text-muted">Masuk ke akun Anda untuk mulai berbelanja kebutuhan kesehatan.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 py-2 small mb-4" style="background-color: #fef2f2; color: #991b1b; border-radius: 10px;">
            <i class="fa fa-exclamation-circle me-1"></i>{{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label class="form-label">Email Address</label>
            <div class="input-icon-wrapper">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
            </div>
        </div>
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-label mb-0">Password</label>
            </div>
            <div class="input-icon-wrapper">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
        </div>
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label small text-secondary" for="remember">Ingat saya</label>
            </div>
            <a href="{{ route('password.request') }}" class="small text-decoration-none fw-bold" style="color: #10b981;">Lupa Password?</a>
        </div>
        <button type="submit" class="btn btn-primary shadow-sm mb-4">
            Masuk Sekarang
        </button>
        <div class="text-center">
            <p class="small text-muted mb-0">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #10b981;">Daftar Pelanggan Sekarang</a></p>
        </div>
    </form>
    
    <div class="mt-5 text-center text-muted small d-lg-none">
        &copy; {{ date('Y') }} Apotek POS. All rights reserved.
    </div>
</div>
@endsection
