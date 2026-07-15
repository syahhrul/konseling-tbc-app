<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Skrining Kontak Keluarga - TBC Care</title>
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

        .form-card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            background-color: white;
            overflow: hidden;
        }

        .form-card-header {
            background-color: #0d9488;
            color: white;
            padding: 1.5rem;
            border-bottom: none;
        }

        .form-label-custom {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .family-member-card {
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
        }

        .family-member-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
    </style>
</head>

<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-teal shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/dashboard') }}">
                <i class="fa-solid fa-lungs-virus fs-3"></i>
                <span>TBC Care</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ url('/dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ url('/output_pasien') }}">Riwayat Harian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-medium" href="{{ route('skrining.kontak.create') }}">Skrining Keluarga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('profile.edit') }}">Edit Profil</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-danger btn-sm px-3 rounded-pill shadow-sm" href="{{ route('logout') }}">
                            <i class="fa-solid fa-right-from-bracket me-1"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Top Alert Session -->
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-0 text-center py-3 mb-0">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        </div>
    @endif

    <main class="container py-4 py-lg-5">
        <div class="row g-4">
            
            <!-- Left Side: Form Skrining -->
            <div class="col-12 col-lg-7">
                <div class="card form-card">
                    <div class="form-card-header d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-shield-virus fs-4"></i>
                        </div>
                        <div>
                            <h1 class="h4 fw-bold mb-0">Skrining Kontak Erat Keluarga</h1>
                            <p class="mb-0 small text-white-75">Laporkan potensi penularan TBC pada keluarga serumah.</p>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="p-3 bg-light rounded-3 mb-4 small text-secondary border">
                            <i class="fa-solid fa-circle-info text-primary me-2"></i>
                            Kontak erat (terutama keluarga serumah) dengan penderita TBC berisiko tinggi tertular. Isi form di bawah ini jika ada anggota keluarga yang mulai menunjukkan gejala (batuk lebih dari 2 minggu, demam, keringat malam).
                        </div>

                        <form method="POST" action="{{ route('skrining.kontak.store') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="form-label form-label-custom">Nama Anggota Keluarga</label>
                                <input type="text" name="nama_anggota_keluarga" class="form-control form-control-lg border-2" placeholder="Contoh: Ibu Rinawati" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label form-label-custom">Status Gejala Kontak</label>
                                <select name="status_gejala" class="form-select form-select-lg border-2" required>
                                    <option value="1">Ya, menunjukkan gejala (Batuk / Demam)</option>
                                    <option value="0" selected>Tidak ada gejala</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label form-label-custom">Rekomendasi Tindakan</label>
                                <input type="text" name="rekomendasi_tindakan" class="form-control form-control-lg border-2" value="Jadwalkan pemeriksaan dahak / mantoux" required>
                            </div>

                            <div class="d-grid mt-4">
                                <button class="btn btn-teal btn-lg py-3 fw-bold rounded-3 shadow" type="submit">
                                    <i class="fa-solid fa-flask me-2"></i>Simpan & Laporkan Skrining
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side: Riwayat Terlapor -->
            <div class="col-12 col-lg-5">
                <div class="card form-card">
                    <div class="form-card-header bg-dark d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-list-check fs-4"></i>
                        </div>
                        <div>
                            <h2 class="h5 fw-bold mb-0">Riwayat Skrining Terlapor</h2>
                            <p class="mb-0 small text-white-50">Daftar keluarga yang telah diskrining.</p>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-3">
                            @forelse($riwayat as $item)
                                <div class="p-3 family-member-card">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <strong class="text-dark">{{ $item->nama_anggota_keluarga }}</strong>
                                        <span class="badge {{ $item->status_gejala ? 'bg-danger' : 'bg-success' }}">
                                            {{ $item->status_gejala ? 'Bergejala' : 'Bebas Gejala' }}
                                        </span>
                                    </div>
                                    <div class="small text-secondary mb-1">
                                        <strong>Rekomendasi:</strong> {{ $item->rekomendasi_tindakan ?? '-' }}
                                    </div>
                                    <div class="small text-secondary-50" style="font-size: 0.75rem;">
                                        Dilaporkan pada: {{ optional($item->created_at)->format('d M Y H:i') }}
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-secondary py-3 mb-0 small text-center">
                                    <i class="fa-solid fa-face-smile me-2"></i>Belum ada data skrining keluarga yang dilaporkan.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-teal text-white py-5 mt-5">
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