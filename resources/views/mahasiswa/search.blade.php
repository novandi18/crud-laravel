@extends('layouts.main')

@section('container')

<div class="py-4 d-flex justify-content-between align-items-center">
    <div class="d-flex flex-column">
        <span class="border-bottom pb-2 mb-1" style="font-size: .8em">Hasil Pencarian dari :</span>
        <h2>{{ $search }}</h2>
    </div>
    <div class="d-flex flex-column">
        <div class="w-100 pb-2 mb-1" style="font-size: .8em">Ditemukan {{ $result->count() }} data
            ({{ $log }} detik)</div>
        <a href="/" class="btn btn-primary">Lihat semua data</a>
    </div>
</div>

<form action="/mahasiswa/search" method="GET" role="search">
    {{ csrf_field() }}
    <div class="input-group mb-3 d-flex">
        <input type="search" value="{{ $search }}" class="form-control rounded-0 @error('search') is-invalid @enderror"
            name="search" placeholder="Cari nama atau NIM mahasiswa...">
        <div class="d-flex position-relative">
            <select class="form-select rounded-0" name="kelas">
                <option value="" name="kelas">Semua Kelas</option>
                @foreach ($kelas as $k)
                <option name="kelas" value="{{ $k->kelas_mhs }}" {{ ($kelas_s == $k->kelas_mhs) ? 'selected' : '' }}>
                    {{ $k->kelas_mhs }}</option>
                @endforeach
            </select>
            <select class="form-select rounded-0" name="prodi">
                <option name="prodi" value="">Semua Prodi</option>
                @foreach ($prodi as $p)
                <option name="prodi" value="{{ $p->nama_prodi }}" {{ ($prodi_s == $p->nama_prodi) ? 'selected' : '' }}>
                    {{ $p->nama_prodi }}</option>
                @endforeach
            </select>

            <button class="btn btn-dark rounded-0" type="submit">Cari</button>
        </div>
    </div>
</form>

@if ($result->count())
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
        @foreach ($result as $data)
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
<h3>Data tidak ditemukan.</h3>
@endif

<!-- Delete Confirm -->
@foreach ($result as $data)
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