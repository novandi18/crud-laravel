@extends('layouts.main')

@section('container')

<div class="py-4 d-flex justify-content-between align-items-center">
    <h2>Profil Admin</h2>
</div>

@if (session('pesan'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-lg"></i>
    {{ session('pesan') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card mb-3 border-0" style="max-width: 100%;">
    <div class="row g-0">
        <div class="col-md-5">
            <img src="{{ asset(Auth::user()->image) }}" class="img-fluid rounded" alt="profile">
        </div>
        <div class="col">
            <div class="card-body">
                <h2 class="card-title">{{ Auth::user()->name }}</h2>
                <p class="card-text row mb-4">
                    <span><i class="bi bi-person-fill"></i> {{ Auth::user()->username }}</span>
                    <span><i class="bi bi-envelope-fill"></i> {{ Auth::user()->email }}</span>
                </p>
                <hr>
                <h5><i class="bi bi-gear-fill"></i> Settings</h5>
                <hr>
                <a href="{{ route('edit_profil') }}" class="btn btn-success mb-2"><i class="bi bi-pencil-square"></i>
                    Edit this profile</a>
                <a href="{{ route('edit_password') }}" class="btn btn-warning mb-2"><i class="bi bi-key-fill"></i>
                    Change
                    password</a>
                <a href="{{ route('edit_photo') }}" class="btn btn-primary mb-2"><i class="bi bi-camera-fill"></i>
                    Change profile picture</a>
                <hr class="mt-4">
                <h5><i class="bi bi-gear-fill"></i> More Settings</h5>
                <hr>
                <a href="{{ route('delete_admin') }}" class="btn btn-danger"><i class="bi bi-trash-fill"></i> Delete
                    this account</a>
            </div>
        </div>
        <div class="card-footer mt-2 mb-3 border-0 d-flex justify-content-between" style="bottom: 0">
            <small class="text-muted">Last updated
                <strong>{{ Auth::user()->updated_at->diffForHumans() }}</strong></small>
            <small class="text-muted">Created at
                <strong>{{ Auth::user()->created_at->format('l, j F Y h:i:s A') }}</strong></small>
        </div>
    </div>
</div>

@endsection