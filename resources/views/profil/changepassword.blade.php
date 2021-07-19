@extends('layouts.main')

@section('container')

<div class="py-4 d-flex align-items-center">
    <a href="/admin/profil" class="text-primary px-2 py-0 fs-2"><i class="bi bi-arrow-left-short"></i></a>
    <h2>{{ $title }}</h2>
</div>

@if (session('pesan'))
<div class="alert alert-danger mx-5 alert-dismissible fade show" role="alert">
    <i class="bi bi-x-lg"></i>
    {{ session('pesan') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form class="px-5" action="{{ route('edit_pass_process') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="password" class="form-label">Password Lama</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
            id="password">
        <div class="invalid-feedback">
            @error('password')
            {{ $message }}
            @enderror
        </div>
    </div>

    <div class="mb-4">
        <label for="password2" class="form-label">Password Baru</label>
        <input type="password" name="password2" class="form-control @error('password2') is-invalid @enderror"
            id="password2">
        <div class="invalid-feedback">
            @error('password2')
            {{ $message }}
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary mb-5">Submit</button>
</form>

@endsection