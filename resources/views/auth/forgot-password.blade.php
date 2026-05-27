@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="form-card">
    <div class="mb-5">
        <h2 class="fw-bold text-dark">Lupa Password?</h2>
        <p class="text-muted">Masukkan email terdaftar Anda untuk memverifikasi akun.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 py-2 small mb-4" style="background-color: #fef2f2; color: #991b1b; border-radius: 10px;">
            <i class="fa fa-exclamation-circle me-1"></i>{{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.request') }}">
        @csrf
        <div class="mb-4">
            <label class="form-label">Email Address</label>
            <div class="input-icon-wrapper">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary shadow-sm mb-4">
            Verifikasi Email
        </button>
        
        <div class="text-center">
            <p class="small text-muted mb-0">Ingat password Anda? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #10b981;">Login di sini</a></p>
        </div>
    </form>
    
    <div class="mt-5 text-center text-muted small d-lg-none">
        &copy; {{ date('Y') }} Apotek POS. All rights reserved.
    </div>
</div>
@endsection
