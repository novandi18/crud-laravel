@extends('layouts.main')

@section('container')

<div class="py-4 d-flex align-items-center">
    <a href="/" class="text-primary px-2 py-0 fs-2"><i class="bi bi-arrow-left-short"></i></a>
    <h2>Tambah Data Mahasiswa</h2>
</div>

@if ($noprodi == true)
<div class="container px-5">
    <div class="alert alert-danger">
        <div class="d-flex  align-items-center justify-content-center">
            <i class="bi bi-exclamation-circle" style="font-size: 2em; margin-right: 10px"></i>
            <span>Tidak dapat menambahkan data mahasiswa dikarenakan tidak ada data prodi yang ditemukan, silahkan untuk
                menambahkan data prodi terlebih dahulu.</span>
        </div>
    </div>
</div>
@endif

<form class="px-5" action="tambah/process" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="nim" class="form-label">NIM</label>
        <input type="number" name="nim" value="{{ old('nim') }}" class="form-control @error('nim') is-invalid @enderror"
            id="nim">
        <div class="invalid-feedback">
            @error('nim')
            {{ $message }}
            @enderror
        </div>
    </div>
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" name="nama_mhs" value="{{ old('nama_mhs') }}"
            class="form-control @error('nama_mhs') is-invalid @enderror" id="nama">
        <div class="invalid-feedback">
            @error('nama_mhs')
            {{ $message }}
            @enderror
        </div>
    </div>
    <div class="mb-3">
        <label for="kelas" class="form-label">Kelas</label>
        <input type="text" name="kelas_mhs" value="{{ old('kelas_mhs') }}"
            class="form-control @error('kelas_mhs') is-invalid @enderror" id="kelas">
        <div class="invalid-feedback">
            @error('kelas_mhs')
            {{ $message }}
            @enderror
        </div>
    </div>
    <div class="mb-5">
        <label for="prodi" class="form-label">Prodi</label>
        <select class="form-select" name="prodi_mhs">
            @foreach ($prodi as $data_prodi)
            <option value="{{ $data_prodi->nama_prodi }}" name="prodi_mhs">{{ $data_prodi->nama_prodi }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary mb-5" {{ ($noprodi == true) ? 'disabled' : '' }}>Submit</button>
</form>

@endsection