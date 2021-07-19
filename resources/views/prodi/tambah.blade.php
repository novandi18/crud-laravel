@extends('layouts.main')

@section('container')

<div class="py-4 d-flex align-items-center">
    <a href="/prodi" class="text-primary px-2 py-0 fs-2"><i class="bi bi-arrow-left-short"></i></a>
    <h2>Tambah Data Prodi</h2>
</div>

<form class="px-5" action="tambah/process" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="nama_prodi" class="form-label">Nama Prodi</label>
        <input type="text" name="nama_prodi" value="{{ old('nama_prodi') }}"
            class="form-control @error('nama_prodi') is-invalid @enderror" id="nama_prodi">
        <div class="invalid-feedback">
            @error('nama_prodi')
            {{ $message }}
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary mb-5">Submit</button>
</form>

@endsection