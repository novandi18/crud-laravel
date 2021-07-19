@extends('layouts.main')

@section('container')

<div class="py-4 d-flex align-items-center">
    <a href="{{ route('profil') }}" class="btn btn-light rounded" style="margin-right: .7em"><i
            class="bi bi-arrow-left"></i></a>
    <h2>Verifikasi Admin</h2>
</div>

@if (session('pesan'))
<div class="alert alert-danger d-flex align-items-center" role="alert">
    <i class="bi bi-x-lg" style="margin-right: .5em"></i>
    <div>
        {{ session('pesan') }}
    </div>
</div>
@elseif (session('success'))
<div class="alert alert-success d-flex align-items-center" role="alert">
    <i class="bi bi-check-lg" style="margin-right: .5em"></i>
    <div>
        {{ session('success') }}
    </div>
</div>
@else
<div class="alert alert-primary d-flex align-items-center" role="alert">
    <i class="bi bi-info-lg" style="margin-right: .5em"></i>
    <div>
        Sebelum
        {{ ($form == 'edit_profil') ? 'merubah profil' : (($form == 'edit_photo') ? 'merubah foto profil' : (($form == 'edit_password') ? 'merubah password' : (($form == 'delete_admin') ? 'menghapus akun ' : ''))) }}
        admin pada
        session ini, harap verifikasi {{ ($form == 'delete_admin') ? 'email' : 'password' }} pada profil akun session
        ini terlebih dahulu.
    </div>
</div>
@endif

@if ($form == 'delete_admin')

<form action="{{ route('verify_delete') }}" method="post" class="mt-3">
    @csrf
    <div class="input-group mb-4">
        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
            placeholder="Masukkan email" value="{{ old('email') }}">
        @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Verifikasi Sekarang</button>
</form>

@else

<form action="{{ route('verify_password', ['form' => $form]) }}" method="post" class="mt-3">
    @csrf
    <div class="input-group mb-4">
        <input type="text" name="form" class="form-control" value="{{ $form }}" hidden disabled>
        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
            placeholder="Masukkan password">
        @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Verifikasi Sekarang</button>
</form>

@endif

@endsection