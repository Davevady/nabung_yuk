<!DOCTYPE html>
<html lang="id">
<head>
    @include('layout.auth.head')
</head>
<body>
    <!-- Navbar -->
    @include('layout.auth.navbar')

    <!-- Login Section -->
    <section class="min-vh-100 d-flex align-items-center bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-body p-4 p-sm-5">
                            <div class="text-center mb-4">
                                <h1 class="h3 text-primary mb-2">
                                    <i class="bi bi-piggy-bank"></i> NabungYuk
                                </h1>
                                <p class="text-muted">Masuk ke akun Anda</p>
                            </div>
                            <form method="POST" action="{{ route('auth.login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">Ingat Saya</label>
                                    </div>
                                    {{-- <a href="{{ route('password.request') }}" class="text-primary text-decoration-none">Lupa Password?</a> --}}
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-3">Masuk</button>
                                <div class="text-center">
                                    <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none">Daftar</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('layout.auth.footer')

    <!-- Bootstrap Bundle JS -->
    @include('layout.auth.script')
</body>
</html>