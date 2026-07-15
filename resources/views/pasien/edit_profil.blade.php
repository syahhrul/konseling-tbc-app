<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Profil - TBC Care</title>
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
                        <a class="nav-link fw-medium" href="{{ route('skrining.kontak.create') }}">Skrining Keluarga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-medium" href="{{ route('profile.edit') }}">Edit Profil</a>
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

    <main class="container py-4 py-lg-5" style="max-width: 600px;">
        
        <div class="card form-card">
            <div class="form-card-header d-flex align-items-center gap-3">
                <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fa-solid fa-user-gear fs-4"></i>
                </div>
                <div>
                    <h1 class="h4 fw-bold mb-0">Pengaturan Profil & Akun</h1>
                    <p class="mb-0 small text-white-75">Perbarui nomor kontak dan kata sandi Anda.</p>
                </div>
            </div>
            <div class="card-body p-4">
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label form-label-custom"><i class="fa-solid fa-user text-teal me-2"></i>Nama Lengkap</label>
                        <input type="text" class="form-control form-control-lg border-2 bg-light text-secondary" value="{{ auth()->user()->name ?: (auth()->user()->first_name . ' ' . auth()->user()->last_name) }}" readonly disabled>
                        <div class="form-text small">Nama lengkap hanya dapat diubah oleh petugas kesehatan/admin.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label form-label-custom"><i class="fa-solid fa-envelope text-teal me-2"></i>Email</label>
                        <input type="text" class="form-control form-control-lg border-2 bg-light text-secondary" value="{{ auth()->user()->email }}" readonly disabled>
                    </div>

                    <!-- 1. Nomor WA Pasien -->
                    <div class="mb-4">
                        <label class="form-label form-label-custom"><i class="fa-brands fa-whatsapp text-teal me-2"></i>Nomor WA Pasien</label>
                        <input type="text" name="nomor_wa_pasien" class="form-control form-control-lg border-2" value="{{ old('nomor_wa_pasien', auth()->user()->nomor_wa_pasien) }}" required placeholder="Contoh: 08123456789">
                        <div class="form-text small">Gunakan format nomor lokal yang aktif (misal: 08xx).</div>
                    </div>

                    <!-- 2. Nomor WA PMO -->
                    <div class="mb-4">
                        <label class="form-label form-label-custom"><i class="fa-solid fa-user-shield text-teal me-2"></i>Nomor WA PMO (Pengawas Obat)</label>
                        <input type="text" name="nomor_wa_pmo" class="form-control form-control-lg border-2" value="{{ old('nomor_wa_pmo', auth()->user()->nomor_wa_pmo) }}" required placeholder="Contoh: 08987654321">
                        <div class="form-text small">Nomor pengawas minum obat terdekat (keluarga/kerabat).</div>
                    </div>

                    <!-- 3. Password Baru -->
                    <div class="mb-4">
                        <label class="form-label form-label-custom"><i class="fa-solid fa-lock text-teal me-2"></i>Kata Sandi Baru</label>
                        <input type="password" name="password" class="form-control form-control-lg border-2" placeholder="Kosongkan jika tidak ingin diubah">
                        <div class="form-text small">Minimal 6 karakter.</div>
                    </div>

                    <!-- 4. Konfirmasi Password -->
                    <div class="mb-4">
                        <label class="form-label form-label-custom"><i class="fa-solid fa-circle-check text-teal me-2"></i>Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-lg border-2" placeholder="Ulangi kata sandi baru">
                    </div>

                    <div class="d-grid mt-4">
                        <button class="btn btn-teal btn-lg py-3 fw-bold rounded-3 shadow" type="submit">
                            <i class="fa-solid fa-save me-2"></i>Simpan Perubahan Profil
                        </button>
                    </div>

                </form>
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
