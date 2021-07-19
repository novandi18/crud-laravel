@extends('layouts.main')

@section('container')

<div class="py-4 d-flex align-items-center">
    <a href="/admin/profil" class="text-primary px-2 py-0 fs-2"><i class="bi bi-arrow-left-short"></i></a>
    <h2>{{ $title }}</h2>
</div>

<form class="px-5" action="{{ route('edit_process') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nama Admin</label>
        <input type="text" name="name" value="{{ Auth::user()->name }}"
            class="form-control @error('name') is-invalid @enderror" id="name">
        <div class="invalid-feedback">
            @error('name')
            {{ $message }}
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Username Admin</label>
        <input type="text" name="username" value="{{ Auth::user()->username }}"
            class="form-control @error('username') is-invalid @enderror" id="username">
        <div class="invalid-feedback">
            @error('username')
            {{ $message }}
            @enderror
        </div>
    </div>

    <div class="mb-5">
        <label for="name" class="form-label">Email Admin</label>
        <input type="text" name="email" value="{{ Auth::user()->email }}"
            class="form-control @error('email') is-invalid @enderror" id="email">
        <div class="invalid-feedback">
            @error('email')
            {{ $message }}
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary mb-5">Submit</button>
</form>

@endsection