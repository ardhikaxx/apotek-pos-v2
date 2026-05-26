@extends('layouts.auth')

@section('title', 'Daftar Akun')

@section('content')
<div class="form-card">
    <div class="mb-5">
        <h2 class="fw-bold text-dark">Daftar Akun Baru</h2>
        <p class="text-muted">Bergabunglah sebagai pelanggan untuk mendapatkan kemudahan layanan.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 py-2 small mb-4" style="background-color: #fef2f2; color: #991b1b; border-radius: 10px;">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <div class="input-icon-wrapper">
                <i class="fa fa-user"></i>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <div class="input-icon-wrapper">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor Telepon</label>
            <div class="input-icon-wrapper">
                <i class="fa fa-phone"></i>
                <input type="text" name="phone" class="form-control" placeholder="0812xxxxxx" value="{{ old('phone') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Password</label>
                <div class="input-icon-wrapper">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label">Konfirmasi</label>
                <div class="input-icon-wrapper">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary shadow-sm mb-4">
            Buat Akun Pelanggan
        </button>
        <div class="text-center">
            <p class="small text-muted mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #10b981;">Login di sini</a></p>
        </div>
    </form>
    
    <div class="mt-5 text-center text-muted small d-lg-none">
        &copy; {{ date('Y') }} Apotek POS. All rights reserved.
    </div>
</div>
@endsection
