@extends('layouts.main')

@section('container')

<div class="py-4 d-flex align-items-center">
    <a href="/" class="text-success px-2 py-0 fs-2"><i class="bi bi-arrow-left-short"></i></a>
    <h2>Edit Data Mahasiswa</h2>
</div>

@foreach ($mahasiswa as $mhs)
<form class="px-5" action="/mahasiswa/update/process/{{ Crypt::encrypt($mhs->id_mhs) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" name="nama_mhs" value="{{ $mhs->nama_mhs }}"
            class="form-control @error('nama_mhs') is-invalid @enderror" id="nama">
        <div class="invalid-feedback">
            @error('nama_mhs')
            {{ $message }}
            @enderror
        </div>
    </div>
    <div class="mb-3">
        <label for="kelas" class="form-label">Kelas</label>
        <input type="text" name="kelas_mhs" value="{{ $mhs->kelas_mhs }}"
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
            <option value="{{ $data_prodi->nama_prodi }}" name="prodi_mhs"
                {{ ($data_prodi->nama_prodi == $mhs->prodi_mhs) ? 'selected' : '' }}>
                {{ $data_prodi->nama_prodi }}
            </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-success mb-5">Submit</button>
</form>
@endforeach

@endsection