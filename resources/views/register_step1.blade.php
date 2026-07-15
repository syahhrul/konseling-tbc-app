<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - TBC Care</title>
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
            background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
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

        .register-card {
            border-radius: 1.25rem;
            border: none;
            box-shadow: 0 10px 25px rgba(13, 148, 136, 0.1);
        }

        .form-control:focus, .form-select:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 0.25rem rgba(13, 148, 136, 0.25);
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 2rem;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #dee2e6;
            transform: translateY(-50%);
            z-index: 1;
        }

        .step-bubble {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #fff;
            border: 2px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            position: relative;
            z-index: 2;
            color: #6c757d;
        }

        .step-bubble.active {
            border-color: #0d9488;
            background-color: #0d9488;
            color: #fff;
        }

        .step-bubble.completed {
            border-color: #0d9488;
            background-color: #0d9488;
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-teal d-flex align-items-center gap-2" href="{{ url('/') }}">
                <i class="fa-solid fa-lungs-virus fs-3"></i>
                <span>TBC Care</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/tentang') }}">Tentang</a>
                    </li>

                    <li class="nav-item">
                        @if (Auth::check())
                            <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                        @else
                            <a class="nav-link" href="{{ route('login') }}">Dashboard</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">

                <div class="card register-card p-4 p-md-5 bg-white">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-teal">Daftar Akun Baru</h2>
                        <p class="text-secondary small">Silakan lengkapi formulir pendaftaran berikut</p>
                    </div>

                    <!-- Step Progress Indicator -->
                    <div class="step-indicator px-4">
                        <div class="step-bubble active" data-bs-toggle="tooltip" title="Informasi Pribadi">1</div>
                        <div class="step-bubble" data-bs-toggle="tooltip" title="Kredensial Akun">2</div>
                    </div>

                    <!-- Alert Error -->
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('register.step1.post') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <!-- Nama Depan -->
                            <div class="col-md-6 mb-2">
                                <label for="nama_depan" class="form-label fw-semibold text-secondary small">Nama Depan</label>
                                <input type="text" class="form-control bg-light" id="nama_depan" name="nama_depan" placeholder="Masukkan nama depan" value="{{ old('nama_depan', session('register_step1.nama_depan')) }}" required>
                            </div>

                            <!-- Nama Belakang -->
                            <div class="col-md-6 mb-2">
                                <label for="nama_belakang" class="form-label fw-semibold text-secondary small">Nama Belakang (Opsional)</label>
                                <input type="text" class="form-control bg-light" id="nama_belakang" name="nama_belakang" placeholder="Masukkan nama belakang" value="{{ old('nama_belakang', session('register_step1.nama_belakang')) }}">
                            </div>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label fw-semibold text-secondary small">Tanggal Lahir</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-calendar-days"></i></span>
                                <input type="date" class="form-control border-start-0 bg-light" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', session('register_step1.tanggal_lahir')) }}" required>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label fw-semibold text-secondary small">Jenis Kelamin</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-venus-mars"></i></span>
                                <select class="form-select border-start-0 bg-light" id="jenis_kelamin" name="jenis_kelamin" required>
                                    @php
                                        $selectedGender = old('jenis_kelamin', session('register_step1.jenis_kelamin'));
                                    @endphp
                                    <option value="" disabled {{ is_null($selectedGender) ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ $selectedGender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ $selectedGender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    <option value="Lainnya" {{ $selectedGender == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-4">
                            <label for="alamat" class="form-label fw-semibold text-secondary small">Alamat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-location-dot"></i></span>
                                <input type="text" class="form-control border-start-0 bg-light" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" value="{{ old('alamat', session('register_step1.alamat')) }}" required>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-teal w-100 py-2.5 fw-bold shadow-sm mb-3">
                            Lanjut <i class="fa-solid fa-arrow-right ms-2"></i>
                        </button>
                    </form>

                    <div class="text-center mt-2">
                        <span class="text-secondary small">Sudah punya akun?</span>
                        <a href="{{ route('login') }}" class="text-teal text-decoration-none fw-semibold small ms-1">Login Sekarang</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-teal text-white mt-auto py-4">
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