@extends('layouts.main')

@section('container')

<div class="pb-2 pt-4 d-lg-flex justify-content-between align-items-center">
    <h2 class="mb-3">Data Mahasiswa</h2>
    <div class="d-lg-flex">
        @if ($data == false)
        <button class="btn btn-danger mb-2" style="margin-right: .5em" data-bs-toggle="modal"
            data-bs-target="#deleteAll"><i class="bi bi-trash"></i> Hapus semua</button>
        <a href="{{ route('export_mahasiswa') }}" class="btn btn-light border-dark mb-2" style="margin-right: .5em"><i
                class="bi bi-download"></i> Export Excel</a>
        <a href="mahasiswa/print" target="_blank" class="btn btn-warning mb-2" style="margin-right: .5em"><i
                class="bi bi-printer"></i>
            Cetak Data</a>
        @else
        <a href="{{ route('import_mahasiswa') }}" class="btn btn-light border-dark mb-2" style="margin-right: .5em"><i
                class="bi bi-upload"></i> Import Excel</a>
        @endif
        <a href="mahasiswa/tambah" class="btn btn-primary mb-2"><i class="bi bi-plus-circle"></i> Tambah Data</a>
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
                <option value="" name="kelas" selected>Semua Kelas</option>
                @foreach ($kelas as $k)
                <option name="kelas" value="{{ $k->kelas_mhs }}"
                    {{ (old('kelas') == $k->kelas_mhs) ? 'selected' : '' }}>{{ $k->kelas_mhs }}</option>
                @endforeach
            </select>
            <select class="form-select rounded-0" name="prodi">
                <option name="prodi" value="" selected>Semua Prodi</option>
                @foreach ($prodi as $p)
                <option name="prodi" value="{{ $p->nama_prodi }}"
                    {{ (old('prodi') == $p->nama_prodi) ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                @endforeach
            </select>

            <button class="btn btn-dark rounded-0" type="submit" style="z-index: 0">Cari</button>
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
        @foreach ($mahasiswa as $data => $d)
        <tr>
            <th>{{ $mahasiswa->firstItem() + $data }}</th>
            <td>{{ $d->nim }}</td>
            <td>{{ $d->nama_mhs }}</td>
            <td>{{ $d->kelas_mhs }}</td>
            <td>{{ $d->prodi_mhs }}</td>
            <td>
                <a href="/mahasiswa/update/{{ Crypt::encrypt($d->id_mhs) }}" class="btn btn-success"><i
                        class="bi bi-pencil-fill"></i></a>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $d->nim }}"><i
                        class="bi bi-trash-fill"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $mahasiswa->links() }}
@else
<div class="w-100 d-flex justify-content-center">
    <img src="{{ asset('img/nodata.svg') }}" width="700px" style="margin-top: -3em">
</div>
@endif

<!-- Delete All Data Confirm -->
<div class="modal fade" id="deleteAll" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yakin ingin menghapus semua data mahasiswa?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('delete_mahasiswa') }}" method="GET">
                <div class="modal-body">
                    <span>Data yang telah dihapus tidak dapat dikembalikan.</span>
                    <div class="d-flex bg-light rounded p-3 mt-2 align-items-center border border-secondary">
                        @csrf
                        <input class="form-check-input mt-0" style="width: 2em; height: 2em; margin-right: 0.7em"
                            type="checkbox" value="yes" name="deleteProdi">
                        <span>Hapus juga data prodi</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus semua</button>
                </div>
            </form>
        </div>
    </div>
</div>

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