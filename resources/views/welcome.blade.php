<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TBC Care - Sistem Monitoring & Konseling Digital</title>
    <!-- Favicon Paru-paru Medis -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🫁</text></svg>">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <!-- Google Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        .text-teal {
            color: #0d9488;
        }

        .bg-teal {
            background-color: #0d9488;
        }

        .bg-teal-hover:hover {
            background-color: #0f766e;
        }

        .btn-teal {
            background-color: #0d9488;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-teal:hover {
            background-color: #0f766e;
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-outline-teal {
            border-color: #0d9488;
            color: #0d9488;
            transition: all 0.3s ease;
        }

        .btn-outline-teal:hover {
            background-color: #0d9488;
            color: #fff;
        }

        .hero-section {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
            color: white;
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .card-custom {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-teal d-flex align-items-center gap-2" href="{{ url('/') }}">
                <i class="fa-solid fa-lungs-virus fs-3"></i>
                <span>TBC Care</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ url('/tentang') }}">Tentang</a>
                    </li>

                    <li class="nav-item">
                        @if (Auth::check())
                            <a class="nav-link fw-medium" href="{{ url('/dashboard') }}">Dashboard</a>
                        @else
                            <a class="nav-link fw-medium" href="{{ route('login') }}">Dashboard</a>
                        @endif
                    </li>
                    <li class="nav-item ms-lg-2">
                        @if (Auth::check())
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm px-3 py-2 rounded-pill"><i class="fa-solid fa-right-from-bracket me-1"></i>Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-teal btn-sm px-4 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-user me-1"></i>Masuk</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 text-center text-lg-start">
                    <h1 class="display-5 fw-bold mb-3">Sistem Monitoring & Konseling Digital Tuberkulosis</h1>
                    <p class="lead mb-4 text-white-75">TBC Care mendampingi pasien dalam pemantauan kepatuhan minum obat secara teratur selama minimal 6 bulan, dilengkapi skrining keluarga terdekat demi eliminasi penularan TBC.</p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                        @if (Auth::check())
                            <a href="{{ url('/dashboard') }}" class="btn btn-light text-teal btn-lg px-4 py-2.5 fw-bold rounded-pill shadow-sm"><i class="fa-solid fa-gauge me-2"></i>Akses Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-light text-teal btn-lg px-4 py-2.5 fw-bold rounded-pill shadow-sm"><i class="fa-solid fa-right-to-bracket me-2"></i>Mulai Monitoring</a>
                            <a href="{{ route('register.step1') }}" class="btn btn-outline-light btn-lg px-4 py-2.5 fw-bold rounded-pill"><i class="fa-solid fa-user-plus me-2"></i>Daftar Sekarang</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <div class="p-4 bg-white bg-opacity-10 rounded-5 border border-white border-opacity-10 shadow-lg">
                        <i class="fa-solid fa-heart-pulse text-white mb-3" style="font-size: 5rem;"></i>
                        <h3 class="fw-bold mb-2">Bebas TBC, Mulai Hari Ini</h3>
                        <p class="text-white-75 small mb-0">Mari bersama mewujudkan Indonesia bebas TBC dengan disiplin berobat dan pengawasan ketat oleh PMO.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TBC Brief Info Section -->
    <section class="py-5">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge rounded-pill bg-teal text-white px-3 py-2 mb-3">Informasi Utama</span>
                    <h2 class="fw-bold mb-3">Apa itu Tuberkulosis (TBC)?</h2>
                    <p class="lead text-secondary fs-6">Tuberkulosis (TBC) adalah penyakit menular yang disebabkan oleh bakteri <em>Mycobacterium tuberculosis</em> yang menyerang paru-paru. Bakteri ini menular melalui udara saat penderita TBC aktif batuk atau bersin.</p>
                    <p class="text-secondary small">Meskipun berbahaya, TBC dapat disembuhkan total jika pasien menjalani terapi kombinasi obat secara teratur selama 6 bulan tanpa putus di bawah pengawasan PMO (Pengawas Menelan Obat).</p>
                    <a href="{{ url('/pusatinfotbc') }}" class="btn btn-teal px-4 py-2 rounded-pill mt-2 fw-semibold shadow-sm">
                        Pelajari Selengkapnya <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="card card-custom p-4 text-center h-100">
                                <div class="rounded-circle bg-danger-subtle text-danger mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fa-solid fa-wind fs-4"></i>
                                </div>
                                <h5 class="fw-bold">Lewat Udara</h5>
                                <p class="text-secondary small mb-0">TBC menyebar dengan mudah melalui udara saat penderita batuk atau bersin.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card card-custom p-4 text-center h-100">
                                <div class="rounded-circle bg-success-subtle text-success mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fa-solid fa-calendar-check fs-4"></i>
                                </div>
                                <h5 class="fw-bold">6 Bulan Pengobatan</h5>
                                <p class="text-secondary small mb-0">Kepatuhan minum obat minimal 6 bulan berturut-turut untuk sembuh total.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card card-custom p-4 text-center h-100">
                                <div class="rounded-circle bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fa-solid fa-user-friends fs-4"></i>
                                </div>
                                <h5 class="fw-bold">Peran Vital PMO</h5>
                                <p class="text-secondary small mb-0">Adanya Pengawas Menelan Obat memastikan kepatuhan pasien agar tidak lalai.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card card-custom p-4 text-center h-100">
                                <div class="rounded-circle bg-warning-subtle text-warning mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fa-solid fa-heart-pulse fs-4"></i>
                                </div>
                                <h5 class="fw-bold">Skrining Keluarga</h5>
                                <p class="text-secondary small mb-0">Deteksi dini terhadap anggota keluarga untuk mencegah penularan meluas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Aplikasi Section -->
    <section class="bg-light py-5">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="p-4 bg-teal rounded-4 text-white text-center shadow-lg">
                        <i class="fa-solid fa-laptop-medical mb-3" style="font-size: 4rem;"></i>
                        <h4 class="fw-bold">TBC Care Digital Monitoring</h4>
                        <p class="small text-white-50 mb-0">Sebuah platform kesehatan masyarakat digital yang melayani pendataan riwayat kepatuhan harian pasien dan pelaporan otomatis.</p>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    <span class="badge rounded-pill bg-secondary text-white px-3 py-2 mb-3">Tentang Platform</span>
                    <h2 class="fw-bold mb-3">Solusi Monitoring Digital untuk Eliminasi TBC</h2>
                    <p class="text-secondary mb-4">Aplikasi TBC Care dikembangkan sebagai platform mandiri kesehatan masyarakat digital yang membantu perawat dan pengawas dalam memantau jadwal minum obat harian pasien. Dengan pengingat WhatsApp otomatis dan pencatatan yang teratur, angka putus obat dapat ditekan secara signifikan.</p>
                    <a href="{{ url('/tentang') }}" class="btn btn-outline-teal px-4 py-2 rounded-pill fw-semibold">
                        Lihat Profil Aplikasi
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-teal text-white py-5">
        <div class="container">
            <div class="row g-4 justify-content-between">
                <div class="col-md-5">
                    <h4 class="fw-bold mb-3"><i class="fa-solid fa-lungs-virus me-2"></i>TBC Care</h4>
                    <p class="small text-white-50 text-justify">TBC Care adalah aplikasi monitoring kesehatan masyarakat digital untuk membantu penanggulangan dan eliminasi penyakit Tuberkulosis di Indonesia secara mandiri, teratur, dan berkelanjutan.</p>
                </div>
                <div class="col-md-3">
                    <h5 class="fw-bold mb-3">Tautan Cepat</h5>
                    <ul class="list-unstyled small text-white-50 space-y-2">
                        <li><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-white">Beranda</a></li>
                        <li><a href="{{ url('/tentang') }}" class="text-white-50 text-decoration-none hover-white">Tentang Kami</a></li>

                        <li><a href="{{ route('login') }}" class="text-white-50 text-decoration-none hover-white">Dashboard Monitoring</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold mb-3">Pedoman Kesehatan</h5>
                    <p class="small text-white-50">Isi materi edukasi dan protokol klinis pada platform ini diselaraskan dengan pedoman resmi dari World Health Organization (WHO) dan Kementerian Kesehatan RI.</p>
                </div>
            </div>
            <hr class="border-white border-opacity-10 my-4">
            <div class="text-center small text-white-50">
                &copy; 2026 TBC Care. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
