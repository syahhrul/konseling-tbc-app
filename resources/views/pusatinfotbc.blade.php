<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pusat Informasi TBC - TBC Care</title>
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
        }

        .hero-section {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
            color: white;
            padding: 4rem 0;
        }

        .sticky-subnav {
            position: sticky;
            top: 56px;
            z-index: 1020;
            background-color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .info-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            background-color: white;
            margin-bottom: 2.5rem;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 120px;
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
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-6 fw-bold mb-3">Pusat Informasi Edukasi TBC</h1>
            <p class="lead mb-0 text-white-75" style="max-width: 700px; margin: auto;">Panduan edukasi resmi dan terpercaya mengenai Tuberkulosis yang diselaraskan dengan standar WHO dan Kementerian Kesehatan RI.</p>
        </div>
    </section>

    <!-- Sticky Sub Navigation -->
    <div class="sticky-subnav py-2 border-bottom">
        <div class="container overflow-x-auto">
            <div class="d-flex gap-2 justify-content-start justify-content-md-center">
                <a href="#deskripsi" class="btn btn-sm btn-outline-teal rounded-pill px-3">Deskripsi</a>
                <a href="#penularan" class="btn btn-sm btn-outline-teal rounded-pill px-3">Cara Penularan</a>
                <a href="#gejala" class="btn btn-sm btn-outline-teal rounded-pill px-3">Gejala Klinis</a>
                <a href="#pengobatan" class="btn btn-sm btn-outline-teal rounded-pill px-3">Pengobatan (6 Bulan)</a>
                <a href="#pmo" class="btn btn-sm btn-outline-teal rounded-pill px-3">Peran Vital PMO</a>
                <a href="#pencegahan" class="btn btn-sm btn-outline-teal rounded-pill px-3">Pencegahan</a>
            </div>
        </div>
    </div>

    <!-- Educational Content -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">

                <!-- 1. Deskripsi -->
                <div class="card info-card p-4 p-md-5" id="deskripsi">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 bg-teal text-white p-3 d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-lungs fs-3"></i>
                        </div>
                        <h2 class="h3 fw-bold text-teal mb-0">Apa Itu Tuberkulosis (TBC)?</h2>
                    </div>
                    <p class="lead text-secondary fs-6 mb-3">Tuberkulosis (TBC) adalah penyakit menular yang disebabkan oleh infeksi bakteri <strong>Mycobacterium tuberculosis</strong>. Meskipun bakteri ini paling sering menyerang organ paru-paru (TBC Paru), TBC juga dapat menyebar ke organ tubuh lainnya seperti kelenjar getah bening, tulang, ginjal, selaput otak, maupun kulit (TBC Ekstra Paru).</p>
                    <p class="text-secondary small mb-0">TBC bukanlah penyakit turunan atau kutukan. Penyakit ini sepenuhnya dapat dicegah, diobati, dan disembuhkan secara total asalkan pasien menjalani diagnosis yang tepat dan mematuhi rangkaian pengobatan tanpa putus.</p>
                </div>

                <!-- 2. Cara Penularan -->
                <div class="card info-card p-4 p-md-5" id="penularan">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 bg-teal text-white p-3 d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-wind fs-3"></i>
                        </div>
                        <h2 class="h3 fw-bold text-teal mb-0">Cara Penularan TBC (Udara)</h2>
                    </div>
                    <p class="text-secondary mb-3">Berdasarkan data WHO dan Kementerian Kesehatan RI, TBC menular melalui <strong>udara (airborne transmission)</strong>. Penularan terjadi ketika:</p>
                    <ul class="list-group list-group-flush mb-4 small text-secondary">
                        <li class="list-group-item bg-transparent px-0"><i class="fa-solid fa-circle-chevron-right text-teal me-2"></i>Penderita TBC aktif batuk, bersin, berbicara, atau meludah, yang melepaskan percikan dahak kecil (droplet nuclei) ke udara.</li>
                        <li class="list-group-item bg-transparent px-0"><i class="fa-solid fa-circle-chevron-right text-teal me-2"></i>Orang di sekitar menghirup udara yang terkontaminasi oleh bakteri Mycobacterium tuberculosis tersebut.</li>
                        <li class="list-group-item bg-transparent px-0"><i class="fa-solid fa-circle-chevron-right text-teal me-2"></i>Bakteri masuk melalui saluran pernapasan menuju paru-paru dan dapat menyebar ke bagian tubuh lainnya.</li>
                    </ul>
                    <div class="alert alert-warning border-0 rounded-3 mb-0 small">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>TBC <strong>tidak menular</strong> melalui jabat tangan, berbagi makanan/minuman, menyentuh seprai/dudukan toilet, atau menggunakan peralatan makan yang sama dengan pasien. Penularan utama adalah melalui sirkulasi udara yang buruk di ruangan tertutup.
                    </div>
                </div>

                <!-- 3. Gejala Klinis -->
                <div class="card info-card p-4 p-md-5" id="gejala">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 bg-teal text-white p-3 d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-notes-medical fs-3"></i>
                        </div>
                        <h2 class="h3 fw-bold text-teal mb-0">Gejala Klinis TBC</h2>
                    </div>
                    <p class="text-secondary mb-3">Gejala utama TBC paru yang wajib diwaspadai meliputi:</p>
                    <div class="row g-3 text-secondary small">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 h-100 border-start border-3 border-teal">
                                <h6 class="fw-bold mb-1 text-dark">Batuk Terus-Menerus</h6>
                                <p class="mb-0">Batuk berdahak (kadang disertai bercak darah) yang berlangsung selama 2 minggu atau lebih.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 h-100 border-start border-3 border-teal">
                                <h6 class="fw-bold mb-1 text-dark">Demam & Meriang</h6>
                                <p class="mb-0">Demam berkepanjangan dengan suhu yang tidak terlalu tinggi, terutama dirasakan sore/malam hari.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 h-100 border-start border-3 border-teal">
                                <h6 class="fw-bold mb-1 text-dark">Keringat Malam Tanpa Aktivitas</h6>
                                <p class="mb-0">Berkeringat di malam hari meskipun cuaca tidak panas dan tidak melakukan aktivitas fisik.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 h-100 border-start border-3 border-teal">
                                <h6 class="fw-bold mb-1 text-dark">Penurunan Berat Badan Drastis</h6>
                                <p class="mb-0">Hilangnya nafsu makan secara signifikan yang memicu penurunan berat badan secara cepat.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Pengobatan Minimal 6 Bulan -->
                <div class="card info-card p-4 p-md-5" id="pengobatan">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 bg-teal text-white p-3 d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-calendar-check fs-3"></i>
                        </div>
                        <h2 class="h3 fw-bold text-teal mb-0">Disiplin Pengobatan Minimal 6 Bulan</h2>
                    </div>
                    <p class="text-secondary mb-3">Pengobatan TBC menggunakan kombinasi Obat Anti Tuberkulosis (OAT) yang disediakan secara gratis oleh pemerintah. Pengobatan dibagi menjadi dua tahap:</p>
                    <div class="row g-3 mb-4 small text-secondary">
                        <div class="col-md-6">
                            <div class="p-4 rounded-4 bg-teal h-100 text-white shadow-sm">
                                <h6 class="fw-bold text-white mb-2">1. Tahap Intensif (2 Bulan Pertama)</h6>
                                <p class="mb-0 text-white-75">Pasien wajib minum obat setiap hari untuk membunuh bakteri aktif dengan cepat dan mengurangi risiko penularan.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-4 bg-teal h-100 text-white shadow-sm">
                                <h6 class="fw-bold text-white mb-2">2. Tahap Lanjutan (4 Bulan Berikutnya)</h6>
                                <p class="mb-0 text-white-75">Pasien meminum obat secara berkala (sesuai anjuran dokter) untuk membersihkan sisa bakteri tidur dan mencegah kekambuhan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-danger border-0 rounded-3 mb-0 small">
                        <h6 class="fw-bold text-danger mb-1"><i class="fa-solid fa-triangle-exclamation me-2"></i>Peringatan Penting: Bahaya Putus Obat!</h6>
                        Jika pengobatan dihentikan sebelum 6 bulan (meskipun tubuh sudah terasa sehat), bakteri TBC yang tersisa akan bermutasi menjadi kebal terhadap obat standar. Kondisi ini disebut <strong>TBC Resistan Obat (MDR-TB)</strong>, yang membutuhkan waktu pengobatan jauh lebih lama (9 - 24 bulan) dengan efek samping obat yang lebih berat.
                    </div>
                </div>

                <!-- 5. Peran Vital PMO -->
                <div class="card info-card p-4 p-md-5" id="pmo">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 bg-teal text-white p-3 d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-users-viewfinder fs-3"></i>
                        </div>
                        <h2 class="h3 fw-bold text-teal mb-0">Peran Vital PMO (Pengawas Menelan Obat)</h2>
                    </div>
                    <p class="text-secondary mb-3"><strong>PMO (Pengawas Menelan Obat)</strong> adalah seseorang yang dipercaya (bisa keluarga terdekat, kader kesehatan, atau tetangga) yang bertugas mendampingi pasien TBC. Peran utama PMO meliputi:</p>
                    <div class="row g-3 text-secondary small">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <div class="fw-bold text-teal mb-1"><i class="fa-solid fa-check-double me-1"></i>Mengawasi</div>
                                <p class="mb-0">Memastikan pasien meminum dosis obat dengan benar setiap harinya secara langsung.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <div class="fw-bold text-teal mb-1"><i class="fa-solid fa-bell me-1"></i>Mengingatkan</div>
                                <p class="mb-0">Mengingatkan jadwal kontrol ke puskesmas/klinik dan jadwal pengambilan obat ulang.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <div class="fw-bold text-teal mb-1"><i class="fa-solid fa-heart me-1"></i>Memotivasi</div>
                                <p class="mb-0">Memberikan dukungan psikologis agar pasien tetap semangat dan tidak putus asa selama 6 bulan pengobatan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. Pencegahan -->
                <div class="card info-card p-4 p-md-5" id="pencegahan">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 bg-teal text-white p-3 d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-shield-virus fs-3"></i>
                        </div>
                        <h2 class="h3 fw-bold text-teal mb-0">Langkah Pencegahan Penularan</h2>
                    </div>
                    <p class="text-secondary mb-3">Untuk meminimalkan penyebaran kuman TBC di lingkungan keluarga dan masyarakat, lakukan tindakan berikut:</p>
                    <ul class="list-group list-group-flush small text-secondary">
                        <li class="list-group-item bg-transparent px-0"><i class="fa-solid fa-mask text-teal me-2"></i>Penderita TBC disarankan memakai masker, terutama saat berinteraksi di ruang tertutup.</li>
                        <li class="list-group-item bg-transparent px-0"><i class="fa-solid fa-sun text-teal me-2"></i>Buka jendela rumah di pagi hari agar sinar matahari masuk dan sirkulasi udara (ventilasi) berjalan baik. Kuman TBC mati jika terkena paparan sinar matahari langsung.</li>
                        <li class="list-group-item bg-transparent px-0"><i class="fa-solid fa-hand-holding-hand text-teal me-2"></i>Terapkan etika batuk dan bersin: tutup mulut dengan tisu atau siku bagian dalam, dan segera buang tisu bekas ke tempat sampah lalu cuci tangan.</li>
                        <li class="list-group-item bg-transparent px-0"><i class="fa-solid fa-baby text-teal me-2"></i>Berikan imunisasi BCG pada bayi yang baru lahir untuk perlindungan dari infeksi TBC yang berat.</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

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
