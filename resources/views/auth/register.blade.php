@extends('auth.layouts.main')

@section('box')

<div class="d-flex justify-content-center row align-items-center">
    <h2 class="text-center text-white py-4">Daftar Admin</h2>

    <div class="card py-2 mb-5" style="width: 25em;">
        <div class="card-body">
            @if ($message == true)
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-x" style="font-size: 2em; margin-right: .5em"></i>
                <div>{{ $failed }}</div>
            </div>
            @endif

            <span class="mb-3 d-flex justify-content-center text-secondary">Silahkan masukkan data dibawah ini</span>
            <form action="{{ route('register') }}" method="post" class="d-flex justify-content-center row"
                enctype="multipart/form-data">
                @csrf

                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="bi bi-person-fill"></i></span>
                    <input type="text" value="{{ old('name') }}" name="name"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap">
                </div>
                <span class="mt-1 mb-3 text-danger" style="font-size: .8em">
                    @error('name')
                    {{ $message }}
                    @enderror
                </span>

                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="bi bi-person-circle"></i></span>
                    <input type="text" value="{{ old('username') }}" name="username"
                        class="form-control @error('username') is-invalid @enderror" placeholder="Username">
                </div>
                <span class="mt-1 mb-3 text-danger" style="font-size: .8em">
                    @error('username')
                    {{ $message }}
                    @enderror
                </span>

                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping">
                        <div class="bi bi-envelope-fill"></div>
                    </span>
                    <input type="email" value="{{ old('email') }}" name="email"
                        class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                </div>
                <span class="mt-1 mb-3 text-danger" style="font-size: .8em">
                    @error('email')
                    {{ $message }}
                    @enderror
                </span>

                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping">
                        <div class="bi bi-key-fill"></div>
                    </span>
                    <input type="password" value="{{ old('password') }}" name="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                </div>
                <span class="mt-1 mb-4 text-danger" style="font-size: .8em">
                    @error('password')
                    {{ $message }}
                    @enderror
                </span>

                <button class="btn btn-primary" style="width: 15em" type="submit">Daftar</button>
            </form>
            <hr>
            <a href="/admin/login" class="text-dark text-decoration-underline">Sudah punya akun admin? masuk disini</a>
        </div>
    </div>
</div>

@endsection