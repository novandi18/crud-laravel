@extends('auth.layouts.main')

@section('box')

<div class="d-flex justify-content-center row align-items-center">
    <h2 class="text-center text-white pb-4 pt-5">Lupa Password</h2>

    <div class="card py-2" style="width: 25em">
        <div class="card-body d-flex justify-content-center row">
            <span class="mb-3 text-center text-secondary">Silahkan masukkan email yang sudah terdaftar sebagai
                admin</span>

            @if (session('status'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check" style="font-size: 2em; margin-right: .5em"></i>
                <div>{{ session('status') }}</div>
            </div>
            @endif

            @if (session('email'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-x" style="font-size: 2em; margin-right: .5em"></i>
                <div>{{ session('email') }}</div>
            </div>
            @endif

            <form action="{{ route('send_verify') }}" method="post" class="d-flex justify-content-center row">
                @csrf
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        placeholder="Email">
                </div>
                <span class="mt-1 mb-3 text-danger" style="font-size: .8em">
                    @error('email')
                    {{ $message }}
                    @enderror
                </span>

                <button class="btn btn-primary mb-3" style="width: 15em" type="submit">Kirim</button>
            </form>
            <hr>
            <a href="/admin/login" class="text-dark text-decoration-underline">Kembali ke halaman login</a>
        </div>
    </div>
</div>

@endsection