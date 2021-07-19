@extends('layouts.main')

@section('container')

<div class="py-4 d-flex align-items-center">
    <a href="/prodi" class="text-success px-2 py-0 fs-2"><i class="bi bi-arrow-left-short"></i></a>
    <h2>Edit Data Prodi</h2>
</div>

@foreach ($prodi as $p)
<div class="alert alert-warning mx-5">
    <div class="d-flex align-items-center justify-content-center">
        <i class="bi bi-exclamation-circle" style="font-size: 2em; margin-right: .5em"></i>
        <span>Mengubah data prodi <b>{{ $p->nama_prodi }}</b> akan mengubah juga data mahasiswa dengan prodi
            <b>{{ $p->nama_prodi }}</b>.</span>
    </div>
</div>

<form class="px-5" action="/prodi/update/process/{{ Crypt::encrypt($p->id_prodi) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Prodi</label>
        <input type="text" name="nama_prodi" value="{{ $p->nama_prodi }}"
            class="form-control @error('nama_prodi') is-invalid @enderror" id="nama">
        <div class="invalid-feedback">
            @error('nama_prodi')
            {{ $message }}
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-success mb-5">Submit</button>
</form>
@endforeach

@endsection