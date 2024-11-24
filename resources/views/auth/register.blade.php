<!DOCTYPE html>
<html lang="id">
<head>
    @include('layout.auth.head')
</head>
<body>
    <!-- Navbar -->
    @include('layout.auth.navbar')

    <!-- Register Section -->
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
                                <p class="text-muted">Daftar Akun Baru</p>
                            </div>
                            <form method="POST" action="{{ route('auth.register') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-3">Daftar</button>
                                <div class="text-center">
                                    <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary text-decoration-none">Masuk</a></p>
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