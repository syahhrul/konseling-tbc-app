<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Tahap 2 - TBC Care</title>
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

        .btn-outline-teal {
            border-color: #0d9488;
            color: #0d9488;
            transition: all 0.3s ease;
        }

        .btn-outline-teal:hover {
            background-color: #0d9488;
            color: #fff;
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
            <div class="col-12 col-sm-10 col-md-9 col-lg-7 col-xl-6">

                <div class="card register-card p-4 p-md-5 bg-white">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-teal">Akun & Kontak</h2>
                        <p class="text-secondary small">Langkah terakhir untuk menyelesaikan pendaftaran Anda</p>
                    </div>

                    <!-- Step Progress Indicator -->
                    <div class="step-indicator px-4">
                        <div class="step-bubble completed" data-bs-toggle="tooltip" title="Informasi Pribadi"><i class="fa-solid fa-check"></i></div>
                        <div class="step-bubble active" data-bs-toggle="tooltip" title="Kredensial Akun">2</div>
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

                    <form action="{{ route('register.submit') }}" method="POST" id="registerForm">
                        @csrf

                        <div class="row g-3">
                            <!-- Email -->
                            <div class="col-md-6 mb-2">
                                <label for="email" class="form-label fw-semibold text-secondary small">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" class="form-control border-start-0 bg-light" id="email" name="email" placeholder="Masukkan email aktif" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <!-- Nomor Telepon Biasa -->
                            <div class="col-md-6 mb-2">
                                <label for="telepon" class="form-label fw-semibold text-secondary small">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" class="form-control border-start-0 bg-light" id="telepon" name="telepon" placeholder="Masukkan nomor telepon" value="{{ old('telepon') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- WhatsApp Section (Lega / Spacious) -->
                        <div class="card bg-light border-0 p-3 mb-3 rounded-3">
                            <h5 class="fw-semibold text-teal mb-3 fs-6"><i class="fa-brands fa-whatsapp me-2"></i>Kontak WhatsApp (Penting untuk Monitoring & Pengingat)</h5>
                            
                            <div class="mb-3">
                                <label for="nomor_wa_pasien" class="form-label fw-semibold text-secondary small">Nomor WA Pasien</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-secondary border-end-0"><i class="fa-brands fa-whatsapp text-success"></i></span>
                                    <input type="text" class="form-control border-start-0 bg-white" id="nomor_wa_pasien" name="nomor_wa_pasien" placeholder="Masukkan nomor WhatsApp Pasien (contoh: 08123456789)" value="{{ old('nomor_wa_pasien') }}" required>
                                </div>
                                <div class="form-text text-secondary small">Nomor WhatsApp pasien aktif yang akan digunakan untuk mengirimkan pengingat minum obat harian.</div>
                            </div>

                            <div class="mb-0">
                                <label for="nomor_wa_pmo" class="form-label fw-semibold text-secondary small">Nomor WA PMO (Pengawas Menelan Obat / Keluarga)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-secondary border-end-0"><i class="fa-brands fa-whatsapp text-success"></i></span>
                                    <input type="text" class="form-control border-start-0 bg-white" id="nomor_wa_pmo" name="nomor_wa_pmo" placeholder="Masukkan nomor WhatsApp PMO (contoh: 08129876543)" value="{{ old('nomor_wa_pmo') }}" required>
                                </div>
                                <div class="form-text text-secondary small">Nomor WhatsApp keluarga atau orang terdekat yang bersedia mengawasi kepatuhan minum obat Anda.</div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Username -->
                            <div class="col-12 mb-2">
                                <label for="username" class="form-label fw-semibold text-secondary small">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-user-tag"></i></span>
                                    <input type="text" class="form-control border-start-0 bg-light" id="username" name="username" placeholder="Buat username unik" value="{{ old('username') }}" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 mb-2">
                                <label for="password" class="form-label fw-semibold text-secondary small">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" class="form-control border-start-0 bg-light" id="password" name="password" placeholder="Buat password" required>
                                </div>
                            </div>

                            <!-- Password Confirmation -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold text-secondary small">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" class="form-control border-start-0 bg-light" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons Navigation (Clear & Legible) -->
                        <div class="row g-3 mt-2">
                            <div class="col-sm-6 order-2 order-sm-1">
                                <a href="{{ route('register.step1') }}" class="btn btn-outline-teal w-100 py-2.5 fw-semibold shadow-sm">
                                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                            <div class="col-sm-6 order-1 order-sm-2">
                                <button type="submit" class="btn btn-teal w-100 py-2.5 fw-bold shadow-sm">
                                    Daftar Sekarang<i class="fa-solid fa-circle-check ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-4">
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

    <!-- Password matching script -->
    <script>
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;

            if (password !== confirm) {
                e.preventDefault();
                alert("Password dan konfirmasi password tidak sama!");
            }
        });
    </script>
</body>

</html>
