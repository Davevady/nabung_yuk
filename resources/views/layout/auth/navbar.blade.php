<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand text-primary" href="/">
                <i class="bi bi-piggy-bank"></i> NabungYuk
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(!Request::is('login'))
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-primary w-100 mb-2 mb-lg-0" href="{{ route('login') }}">Masuk</a>
                    </li>
                    @endif
                    @if(!Request::is('register'))
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-primary w-100 mb-2 mb-lg-0" href="{{ route('register') }}">Daftar</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>