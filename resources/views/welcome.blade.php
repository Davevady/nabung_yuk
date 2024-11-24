<!DOCTYPE html>
<html lang="id">
<head>
    @include('layout.landing.head')
</head>
<body>
    <!-- Navbar -->
    @include('layout.landing.navbar')

    <!-- Hero Section -->
    <section class="hero-section bg-gradient-primary text-white d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-4">Wujudkan Impian Melalui Menabung</h1>
                    <p class="lead mb-4">Kelola keuangan dengan lebih pintar dan raih kebebasan finansial Anda bersama NabungYuk</p>
                    <div class="stats-box p-4 mb-4 mx-3 mx-lg-0">
                        <div class="row text-center">
                            <div class="col-6">
                                <h2 class="fw-bold">10,000+</h2>
                                <p class="mb-0">Pengguna Aktif</p>
                            </div>
                            <div class="col-6">
                                <h2 class="fw-bold">Rp 1.5M+</h2>
                                <p class="mb-0">Total Tabungan</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-center justify-content-lg-start gap-3">
                        <a href="/register" class="btn btn-cta btn-light btn-lg">Mulai Sekarang</a>
                        <a href="#features" class="btn btn-cta btn-outline-light btn-lg">Pelajari</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image d-none d-lg-block">
                        <img src="assets/img/landing/hero.svg" class="img-fluid" alt="Ilustrasi Menabung">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container py-4 py-lg-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Fitur Unggulan</h2>
                <p class="lead text-muted">Nikmati berbagai kemudahan dalam mengelola tabungan Anda</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-block mb-3">
                                <i class="bi bi-piggy-bank text-primary fs-2"></i>
                            </div>
                            <h4>Target Menabung</h4>
                            <p class="text-muted">Tetapkan target dan pantau progres tabungan Anda dengan mudah</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-block mb-3">
                                <i class="bi bi-graph-up text-success fs-2"></i>
                            </div>
                            <h4>Analisis Keuangan</h4>
                            <p class="text-muted">Visualisasi dan analisis lengkap untuk pengelolaan keuangan yang lebih baik</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3 d-inline-block mb-3">
                                <i class="bi bi-shield-check text-warning fs-2"></i>
                            </div>
                            <h4>Keamanan Terjamin</h4>
                            <p class="text-muted">Sistem keamanan berlapis untuk melindungi data dan dana Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container py-4 py-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="assets/img/landing/about.svg" class="img-fluid rounded-3 shadow-lg" alt="Tentang Kami">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-5">Mengapa Memilih NabungYuk?</h2>
                    <div class="about-feature shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="about-icon">
                                <i class="bi bi-check-circle-fill text-primary fs-3"></i>
                            </div>
                            <div class="ms-4">
                                <h4 class="mb-2">Mudah Digunakan</h4>
                                <p class="text-muted mb-0">Interface yang intuitif dan ramah pengguna, dirancang untuk kenyamanan Anda</p>
                            </div>
                        </div>
                    </div>
                    <div class="about-feature shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="about-icon">
                                <i class="bi bi-check-circle-fill text-primary fs-3"></i>
                            </div>
                            <div class="ms-4">
                                <h4 class="mb-2">Transparan</h4>
                                <p class="text-muted mb-0">Tidak ada biaya tersembunyi, semua jelas dan terukur untuk kepercayaan Anda</p>
                            </div>
                        </div>
                    </div>
                    <div class="about-feature shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="about-icon">
                                <i class="bi bi-check-circle-fill text-primary fs-3"></i>
                            </div>
                            <div class="ms-4">
                                <h4 class="mb-2">Dukungan 24/7</h4>
                                <p class="text-muted mb-0">Tim support kami siap membantu Anda kapan saja, di mana saja</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contact" class="gradient-section text-white">
        <div class="container">
            <div class="cta-card text-center">
                <h2 class="fw-bold mb-4">Mulai Perjalanan Menabung Anda</h2>
                <p class="lead mb-4">Bergabung dengan ribuan pengguna yang telah merasakan manfaatnya</p>
                <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                    <a href="/register" class="btn btn-cta btn-light btn-lg px-5">Daftar Gratis</a>
                    <a href="#features" class="btn btn-cta btn-outline-light btn-lg px-5">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('layout.landing.footer')

    <!-- Bootstrap Bundle JS -->
    @include('layout.landing.script')
</body>
</html>