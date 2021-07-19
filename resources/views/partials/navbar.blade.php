<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/">CRUD Laravel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ ($title == "Mahasiswa") ? 'active' : '' }}" aria-current="page"
                        href="/">Mahasiswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($title == "Prodi") ? 'active' : '' }}" href="/prodi">Prodi</a>
                </li>
            </ul>

            <div class="dropdown">
                <a class="text-white nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset(Auth::user()->image) }}" class="rounded-circle border-0"
                        style="width: 1.5em; margin-right: .2em">
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu p-0 shadow" aria-labelledby="navbarDropdown">
                    @if (Route::currentRouteName() != 'profil')
                    <li>
                        <a class="dropdown-item py-2 rounded-top border-bottom" href="{{ route('profil') }}"><i
                                class="bi bi-person"></i>
                            Profil</a>
                    </li>
                    @endif
                    <li>
                        <button class="dropdown-item py-2 rounded-bottom" data-bs-toggle="modal"
                            data-bs-target="#logout"><i class="bi bi-door-open"></i>
                            Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Logout Confirm -->
<div class="modal fade" id="logout" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yakin ingin keluar akun?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>Sesi pada akun ini akan diakhiri.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="{{ route('logout') }}" class="btn btn-danger">Keluar</a>
            </div>
        </div>
    </div>
</div>