@extends('auth.layouts.main')

@section('box')

<div class="d-flex justify-content-center row align-items-center">
    <h2 class="text-center text-white pb-4 pt-5">{{ $title }}</h2>

    <div class="card py-2" style="width: 25em">
        <div class="card-body d-flex justify-content-center row">
            <span class="mb-3 text-center text-secondary">Silahkan masukkan password yang baru</span>

            @if (session('email'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-x" style="font-size: 2em; margin-right: .5em"></i>
                <div>{{ session('email') }}</div>
            </div>
            @endif

            <form action="{{ route('password_reset') }}" method="post" class="d-flex justify-content-center row">
                @csrf
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" name="email"
                        placeholder="Masukkan email akun">
                </div>
                <span class="mt-1 mb-3 text-danger" style="font-size: .8em">
                    @error('email')
                    {{ $message }}
                    @enderror
                </span>

                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="bi bi-key-fill"></i></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        placeholder="Masukkan password baru">
                </div>
                <span class="mt-1 mb-3 text-danger" style="font-size: .8em">
                    @error('password')
                    {{ $message }}
                    @enderror
                </span>

                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="bi bi-key-fill"></i></span>
                    <input type="password" class="form-control @error('password2') is-invalid @enderror"
                        name="password2" placeholder="Masukkan ulang password baru">
                </div>
                <span class="mt-1 mb-4 text-danger" style="font-size: .8em">
                    @error('password2')
                    {{ $message }}
                    @enderror
                </span>
                <input type="hidden" value="{{ $token }}" name="token">

                <button class="btn btn-primary mb-3" style="width: 15em" type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection