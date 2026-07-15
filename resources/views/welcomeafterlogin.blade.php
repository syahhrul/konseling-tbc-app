<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TBC Care - Selamat Datang</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        .hero-section {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
            color: white;
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
            border-radius: 0 0 2rem 2rem;
        }

        .card-custom {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(13, 148, 136, 0.1);
        }
    </style>
</head>

<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-teal d-flex align-items-center gap-2" href="{{ url('/welcomeafterlogin') }}">
                <i class="fa-solid fa-lungs-virus fs-3"></i>
                <span>TBC Care</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ url('/welcomeafterlogin') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ url('/tentangafterlogin') }}">Tentang</a>
                    </li>

                    <li class="nav-item">
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'perawat')
                            <a class="nav-link fw-medium" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        @else
                            <a class="nav-link fw-medium" href="{{ route('dashboard') }}">Dashboard</a>
                        @endif
                    </li>
                    <li class="nav-item ms-lg-2">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm px-3 py-2 rounded-pill"><i class="fa-solid fa-right-from-bracket me-1"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Welcome Hero Section -->
    <section class="hero-section text-center text-md-start">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-8">
                    <h1 class="display-6 fw-bold mb-2">Selamat Datang di TBC Care</h1>
                    <p class="lead mb-0 text-white-75">Halo, <strong>{{ Auth::user()->first_name ?? Auth::user()->username }}</strong>. Senang melihat Anda kembali. Mari pantau kepatuhan minum obat secara teratur demi kesehatan Anda.</p>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <div class="rounded-circle border border-3 border-white shadow d-inline-flex align-items-center justify-content-center bg-white text-teal" style="width: 90px; height: 90px;">
                        <i class="fa-solid {{ Auth::user()->role === 'admin' || Auth::user()->role === 'perawat' ? 'fa-user-doctor' : 'fa-user-injured' }} fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <!-- Quick Access Dashboard Card -->
                <div class="card card-custom p-4 p-md-5 text-center mb-5 bg-white border-0">
                    <div class="d-inline-flex p-3 bg-teal bg-opacity-10 text-teal rounded-circle mb-3 mx-auto">
                        <i class="fa-solid fa-gauge-high fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-teal">Dashboard Pemantauan Anda</h3>
                    <p class="text-secondary mb-4 mx-auto" style="max-width: 550px;">Akses cepat untuk mengisi laporan checklist harian pasien, memantau grafik kepatuhan minum obat, dan melakukan skrining anggota keluarga terdekat.</p>
                    
                    <div>
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'perawat')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-teal btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm">
                                <i class="fa-solid fa-user-doctor me-2"></i>Buka Dashboard Perawat
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-teal btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm">
                                <i class="fa-solid fa-house-medical me-2"></i>Buka Dashboard Pasien
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Info Cards -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card card-custom p-4 bg-white h-100 border-0">
                            <h5 class="fw-bold text-teal mb-3"><i class="fa-solid fa-circle-info me-2"></i>Pusat Info TBC</h5>
                            <p class="text-secondary small mb-3">Dapatkan artikel terpercaya bersumber dari WHO dan Kemenkes RI mengenai cara penularan TBC, pentingnya peran PMO, dan pengobatan minimal 6 bulan.</p>
                            <a href="{{ url('/pusatinfotbcafterlogin') }}" class="text-teal fw-semibold text-decoration-none small mt-auto">Buka Pusat Info TBC <i class="fa-solid fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-custom p-4 bg-white h-100 border-0">
                            <h5 class="fw-bold text-teal mb-3"><i class="fa-solid fa-address-card me-2"></i>Tentang Kami</h5>
                            <p class="text-secondary small mb-3">Ketahui lebih lanjut mengenai profil aplikasi TBC Care sebagai sistem kesehatan masyarakat digital yang membantu pemantauan penderita TBC secara efisien.</p>
                            <a href="{{ url('/tentangafterlogin') }}" class="text-teal fw-semibold text-decoration-none small mt-auto">Buka Halaman Tentang Kami <i class="fa-solid fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-teal text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-1 fw-semibold">TBC Care - Sistem Monitoring & Konseling Digital</p>
            <p class="mb-0 small text-white-50">Didukung oleh data dan panduan resmi WHO & Kementerian Kesehatan RI</p>
            <p class="mt-2 mb-0 small text-white-50">&copy; 2026 TBC Care. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
