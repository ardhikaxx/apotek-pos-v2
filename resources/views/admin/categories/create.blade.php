@extends('layouts.app')
@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
<div class="card border-0 shadow-sm" style="max-width:480px">
    <div class="card-header bg-white fw-semibold"><i class="fa fa-tags me-2 text-info"></i>Form Tambah Kategori</div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-info text-white"><i class="fa fa-save me-1"></i> Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
