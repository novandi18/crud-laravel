@extends('layouts.main')

@section('container')

<div class="py-4 d-flex align-items-center">
    <a href="/prodi" class="text-primary px-2 py-0 fs-2"><i class="bi bi-arrow-left-short"></i></a>
    <h2>{{ $title }}</h2>
</div>

<form class="px-5" action="{{ route('import_prodi_process') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="excel" class="form-label">File Excel (xls / xlsx)</label>
        <input type="file" name="excel" value="{{ old('excel') }}"
            class="form-control @error('excel') is-invalid @enderror"
            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
        <div class="invalid-feedback">
            @error('excel')
            {{ $message }}
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary mb-5">Submit</button>
</form>

@endsection