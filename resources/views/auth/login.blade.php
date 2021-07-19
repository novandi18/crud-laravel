@extends('auth.layouts.main')

@section('box')

<div class="d-flex justify-content-center row align-items-center">
    <h2 class="text-center text-white pb-4 pt-5">Masuk Sebagai Admin</h2>

    <div class="card py-2" style="width: 25em">
        <div class="card-body">
            @if ($nodata == true)
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-circle" style="font-size: 2em; margin-right: .5em"></i>
                <div>Tidak ditemukan akun admin di database, mohon untuk mendaftar terlebih dahulu</div>
            </div>
            @else
            <span class="text-secondary d-flex justify-content-center mb-2">Silahkan masukkan username dan
                password</span>
            @endif

            @if (session('status'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check" style="font-size: 2em; margin-right: .5em"></i>
                <div>{{ session('status') }}</div>
            </div>
            @endif

            @if ($message == true)
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check" style="font-size: 2em; margin-right: .5em"></i>
                <div>{{ $success }}</div>
            </div>
            @endif

            @if (session('fail'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-x" style="font-size: 2em; margin-right: .5em"></i>
                <div>{{ session('fail') }}</div>
            </div>
            @endif

            <form action="{{ route('login') }}" class="d-flex justify-content-center row mt-3" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="bi bi-person-circle"></i></span>
                    <input type="text" name="username" value="{{ old('username') }}"
                        class="form-control @error('username') is-invalid @enderror" placeholder="Username">
                </div>
                <span class="mt-1 mb-3 text-danger" style="font-size: .8em">
                    @error('username')
                    {{ $message }}
                    @enderror
                </span>

                <div class="input-group">
                    <span class="input-group-text" id="addon-wrapping">
                        <div class="bi bi-key-fill"></div>
                    </span>
                    <input type="password" name="password" value="{{ old('password') }}"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                </div>
                <span class="mt-1 mb-5 text-danger" style="font-size: .8em">
                    @error('password')
                    {{ $message }}
                    @enderror
                </span>

                <button class="btn btn-primary mb-3" style="width: 15em" type="submit"
                    {{ ($nodata == true) ? 'disabled' : '' }}>Masuk</button>
            </form>
            <hr>
            <div class="d-flex row">
                <a href="{{ route('forgot') }}" class="text-dark text-decoration-underline">Lupa Password?</a>
                <a href="{{ route('register') }}" class="text-dark text-decoration-underline">Belum punya akun admin?
                    daftar
                    disini</a>
            </div>
        </div>
    </div>
</div>

@endsection