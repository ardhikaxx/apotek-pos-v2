@extends('layouts.auth')

@section('content')
<div class="card p-4">
    <div class="text-center mb-4">
        <i class="fa fa-clinic-medical fa-3x text-info mb-2"></i>
        <h5 class="fw-bold">Apotek POS</h5>
        <small class="text-muted">Silakan login untuk melanjutkan</small>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2">
            <i class="fa fa-exclamation-circle me-1"></i>{{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                <input type="password" name="password" class="form-control" required>
            </div>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Ingat saya</label>
        </div>
        <button type="submit" class="btn btn-info w-100 text-white fw-semibold">
            <i class="fa fa-sign-in-alt me-2"></i>Login
        </button>
        <div class="text-center mt-3">
            <small>Belum punya akun? <a href="{{ route('register') }}" class="text-info text-decoration-none fw-semibold">Daftar Pelanggan</a></small>
        </div>
    </form>
</div>
@endsection
