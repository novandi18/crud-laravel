@extends('layouts.main')

@section('container')

<div class="py-4 d-flex justify-content-between align-items-center">
    <h2>Hasil Pencarian dari : {{ $search }}</h2>
    <a href="/prodi" class="btn btn-primary">Lihat semua data</a>
</div>

<form action="/prodi/search" method="GET" role="search">
    {{ csrf_field() }}
    <div class="input-group mb-3 d-flex">
        <input type="search" value="{{ $search }}" class="form-control rounded-0 @error('search') is-invalid @enderror"
            name="search" placeholder="Cari prodi berdasarkan nama atau jumlah mahasiswa...">
        <button class="btn btn-dark rounded-0" type="submit">Cari</button>
    </div>
</form>

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
        @php $no = 1; @endphp
        @foreach ($result as $data)
        <tr>
            <th>{{ $no++ }}</th>
            <th>{{ $data->nama_prodi }}</th>
            <th>{{ $data->jml_mhs }}</th>
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
@foreach ($result as $data)
<div class="modal fade" id="delete{{ $data->id_prodi }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yakin ingin menghapus data ini?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column">
                    <span>Nama Prodi : {{ $data->nama_prodi }}</span>
                    <span>Jumlah Mahasiswa : {{ $data->jml_mhs }}</span>
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

@endsection