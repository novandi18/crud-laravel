@extends('layouts.main')

@section('container')

<div class="py-4 d-flex align-items-center">
    <a href="/admin/profil" class="text-primary px-2 py-0 fs-2"><i class="bi bi-arrow-left-short"></i></a>
    <h2>{{ $title }}</h2>
</div>

<div class="alert alert-warning mx-5 alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-lg"></i>
    Yakin ingin hapus akun admin pada session ini? tindakan ini tidak dapat dikembalikan
</div>

@if (session('pesan'))
<div class="alert alert-danger mx-5 alert-dismissible fade show" role="alert">
    <i class="bi bi-x-lg"></i>
    {{ session('pesan') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<a href="{{ route('delete_admin_process', ['token' => $token]) }}" class="btn btn-danger mx-5">Ya,
    Hapus Sekarang!</a>

@endsection