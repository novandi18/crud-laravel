@extends('layouts.main')

@section('container')

<div class="py-4 d-flex justify-content-between align-items-center">
    <h2>Data Mahasiswa</h2>
    <div class="d-flex">
        @if ($data == false)
        <a href="{{ route('export_mahasiswa') }}" class="btn btn-light border-dark" style="margin-right: .5em"><i
                class="bi bi-download"></i> Export Excel</a>
        <a href="mahasiswa/print" target="_blank" class="btn btn-warning" style="margin-right: .5em"><i
                class="bi bi-printer"></i>
            Cetak Data</a>
        @else
        <a href="{{ route('import_mahasiswa') }}" class="btn btn-light border-dark" style="margin-right: .5em"><i
                class="bi bi-upload"></i> Import Excel</a>
        @endif
        <a href="mahasiswa/tambah" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Data</a>
    </div>
</div>

@if ($data == false)
<form action="/mahasiswa/search" method="GET" role="search">
    {{ csrf_field() }}
    <div class="input-group mb-3 d-flex">
        <input type="search" value="{{ old('search') }}"
            class="form-control rounded-0 @error('search') is-invalid @enderror" name="search"
            placeholder="Cari nama atau NIM mahasiswa...">
        <div class="d-flex position-relative">
            <select class="form-select rounded-0" name="kelas">
                <option value="" name="kelas" selected>Pilih Kelas</option>
                @foreach ($kelas as $k)
                <option name="kelas" value="{{ $k->kelas_mhs }}"
                    {{ (old('kelas') == $k->kelas_mhs) ? 'selected' : '' }}>{{ $k->kelas_mhs }}</option>
                @endforeach
            </select>
            <select class="form-select rounded-0" name="prodi">
                <option name="prodi" value="" selected>Pilih Prodi</option>
                @foreach ($prodi as $p)
                <option name="prodi" value="{{ $p->nama_prodi }}"
                    {{ (old('prodi') == $p->nama_prodi) ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                @endforeach
            </select>

            <button class="btn btn-dark rounded-0" type="submit">Cari</button>
        </div>
    </div>
</form>

@if (session('pesan'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-lg"></i>
    {{ session('pesan') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<table class="table table-hover table-bordered shadow-sm">
    <thead class="text-center flex-column">
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Prodi</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @php $no = 1; @endphp
        @foreach ($mahasiswa as $data)
        <tr>
            <th>{{ $no++ }}</th>
            <td>{{ $data->nim }}</td>
            <td>{{ $data->nama_mhs }}</td>
            <td>{{ $data->kelas_mhs }}</td>
            <td>{{ $data->prodi_mhs }}</td>
            <td>
                <a href="/mahasiswa/update/{{ Crypt::encrypt($data->id_mhs) }}" class="btn btn-success"><i
                        class="bi bi-pencil-fill"></i></a>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $data->nim }}"><i
                        class="bi bi-trash-fill"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="w-100 d-flex justify-content-center">
    <img src="{{ asset('img/nodata.svg') }}" width="700px" style="margin-top: -3em">
</div>
@endif

<!-- Delete Confirm -->
@foreach ($mahasiswa as $data)
<div class="modal fade" id="delete{{ $data->nim }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yakin ingin menghapus data ini?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column">
                    <span>NIM : {{ $data->nim }}</span>
                    <span>Nama : {{ $data->nama_mhs }}</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="/mahasiswa/hapus/{{ Crypt::encrypt($data->id_mhs) }}" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection