<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tentang Kami - TBC Care</title>
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

        .btn-teal {
            background-color: #0d9488;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-teal:hover {
            background-color: #0f766e;
            color: #fff;
        }

        .hero-section {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
            color: white;
            padding: 5rem 0;
        }

        .info-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            background-color: white;
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
                        <a class="nav-link active fw-medium" href="{{ url('/tentangafterlogin') }}">Tentang</a>
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

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-6 fw-bold mb-3">Tentang TBC Care</h1>
            <p class="lead mb-0 text-white-75" style="max-width: 700px; margin: auto;">Mengenal platform kesehatan masyarakat digital untuk optimalisasi kepatuhan pengobatan Tuberkulosis di Indonesia.</p>
        </div>
    </section>

    <!-- Main Profile Section -->
    <section class="py-5">
        <div class="container py-3">
            <div class="row align-items-center g-5">
                <div class="col-lg-12">
                    <h2 class="fw-bold text-teal mb-3 text-center">Profil Aplikasi</h2>
                    <p class="text-secondary leading-relaxed mb-3 text-center" style="max-width: 850px; margin: 0 auto 1rem auto; font-size: 1.1rem;"><strong>TBC Care</strong> adalah sebuah platform kesehatan digital mandiri yang dirancang khusus untuk mempermudah monitoring kepatuhan minum obat bagi pasien Tuberkulosis (TBC). Melalui kolaborasi antara Pasien, PMO (Pengawas Menelan Obat), dan Perawat/Tenaga Medis, kami menyediakan solusi pencatatan harian yang akurat.</p>
                    <p class="text-secondary small mb-0 text-center" style="max-width: 850px; margin: 0 auto; font-size: 0.95rem;">Platform ini berfokus pada minimalisasi angka putus obat (default rate) dan penyediaan modul skrining dini kontak keluarga guna menekan angka penularan TBC di lingkungan masyarakat luas secara berkelanjutan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi & Misi Section -->
    <section class="py-5 bg-white border-top border-bottom border-light">
        <div class="container py-3">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-4 bg-light rounded-4 h-100 border border-light info-card">
                        <h3 class="fw-bold text-teal mb-3"><i class="fa-solid fa-eye me-2"></i>Visi Kami</h3>
                        <p class="text-secondary">Menjadi platform kesehatan masyarakat digital terdepan di Indonesia yang berkontribusi nyata dalam menekan dan mengeliminasi penyebaran penyakit Tuberkulosis secara sistematis dan berkelanjutan.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 bg-light rounded-4 h-100 border border-light info-card">
                        <h3 class="fw-bold text-teal mb-3"><i class="fa-solid fa-bullseye me-2"></i>Misi Kami</h3>
                        <ul class="list-group list-group-flush text-secondary small bg-transparent">
                            <li class="list-group-item bg-transparent px-0"><i class="fa-solid fa-check text-teal me-2"></i>Menyediakan sistem pencatatan obat harian yang mudah dan ramah pengguna (*mobile-first*).</li>
                            <li class="list-group-item bg-transparent px-0"><i class="fa-solid fa-check text-teal me-2"></i>Memfasilitasi komunikasi dan koordinasi yang efisien antara pasien, PMO, dan petugas medis.</li>
                            <li class="list-group-item bg-transparent px-0"><i class="fa-solid fa-check text-teal me-2"></i>Menyajikan edukasi kesehatan universal yang selaras dengan panduan resmi WHO dan Kemenkes RI.</li>
                            <li class="list-group-item bg-transparent px-0"><i class="fa-solid fa-check text-teal me-2"></i>Mendukung deteksi dini penularan TBC melalui skrining kontak erat keluarga secara digital.</li>
                        </ul>
                    </div>
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
