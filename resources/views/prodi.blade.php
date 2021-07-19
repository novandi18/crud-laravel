@extends('layouts.main')

@section('container')

<div class="py-4 d-flex justify-content-between align-items-center">
    <h2>Data Prodi</h2>
    <div class="d-flex">
        @if ($nodata == false)
        <a href="{{ route('export_prodi') }}" class="btn btn-light border-dark" style="margin-right: .5em"><i
                class="bi bi-download"></i> Export Excel</a>
        @else
        <a href="{{ route('import_prodi') }}" class="btn btn-light border-dark" style="margin-right: .5em"><i
                class="bi bi-upload"></i> Import Excel</a>
        @endif
        <a href="prodi/tambah" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Data</a>
    </div>
</div>

@if ($nodata == false)
<form action="/prodi/search" method="GET" role="search">
    {{ csrf_field() }}
    <div class="input-group mb-3 d-flex">
        <input type="search" value="{{ old('search') }}"
            class="form-control rounded-0 @error('search') is-invalid @enderror" name="search"
            placeholder="Cari prodi berdasarkan nama atau jumlah mahasiswa...">
        <button class="btn btn-dark rounded-0" type="submit">Cari</button>
    </div>
</form>

@if (session('pesan'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-lg"></i>
    {!! session('pesan') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<table class="table table-hover table-bordered shadow-sm">
    <thead class="text-center flex-column">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jumlah Mahasiswa</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @php
        $no = 1;
        @endphp
        @foreach ($prodi as $data)
        <tr>
            <th>{{ $no++ }}</th>
            <td>{{ $data->nama_prodi }}</td>
            <td>{{ $data->jml_mhs }} Orang</td>
            <td>
                <a href="/prodi/update/{{ Crypt::encrypt($data->id_prodi) }}" class="btn btn-success"><i
                        class="bi bi-pencil-fill"></i></a>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $data->id_prodi }}"><i
                        class="bi bi-trash-fill"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Delete Confirm -->
@foreach ($prodi as $data)
<div class="modal fade" id="delete{{ $data->id_prodi }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yakin ingin menghapus data ini?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column">
                    <div class="alert alert-warning">
                        <div class="d-flex">
                            <i class="bi bi-exclamation-circle" style="font-size: 2em; margin-right: 10px"></i>
                            <span>Menghapus prodi ini akan menghapus data mahasiswa dengan prodi yang akan
                                dihapus.</span>
                        </div>
                    </div>
                    <span>Nama Prodi : {{ $data->nama_prodi }}</span>
                    <span>Jumlah Mahasiswa : {{ $data->jml_mhs }} Orang</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="/prodi/delete/{{ Crypt::encrypt($data->id_prodi) }}" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
@endforeach
@else
<div class="w-100 d-flex justify-content-center">
    <img src="{{ asset('img/nodata.svg') }}" width="700px" style="margin-top: -3em">
</div>
@endif

@endsection