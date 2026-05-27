@extends('layouts.auth')

@section('title', 'Atur Ulang Password')

@section('content')
<div class="form-card">
    <div class="mb-5">
        <h2 class="fw-bold text-dark">Password Baru</h2>
        <p class="text-muted">Silakan masukkan password baru untuk akun <strong>{{ $email }}</strong></p>
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

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        
        <div class="mb-4">
            <label class="form-label">Password Baru</label>
            <div class="input-icon-wrapper">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required autofocus>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="form-label">Konfirmasi Password</label>
            <div class="input-icon-wrapper">
                <i class="fa fa-lock"></i>
                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary shadow-sm mb-4">
            Simpan Password Baru
        </button>
    </form>
    
    <div class="mt-5 text-center text-muted small d-lg-none">
        &copy; {{ date('Y') }} Apotek POS. All rights reserved.
    </div>
</div>
@endsection
