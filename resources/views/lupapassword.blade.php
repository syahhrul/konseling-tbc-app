<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reset Password - TBC Care</title>
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

        .reset-card {
            border-radius: 1.25rem;
            border: none;
            box-shadow: 0 10px 25px rgba(13, 148, 136, 0.1);
        }

        .form-control:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 0.25rem rgba(13, 148, 136, 0.25);
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
            <div class="col-12 col-sm-10 col-md-8 col-lg-5">
                
                <div class="card reset-card p-4 p-md-5 bg-white">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex p-3 bg-light rounded-circle text-teal mb-3">
                            <i class="fa-solid fa-key fs-1"></i>
                        </div>
                        <h2 class="fw-bold text-teal">Reset Password</h2>
                        <p class="text-secondary small">Masukkan username dan email Anda untuk membuat password baru</p>
                    </div>

                    <!-- Alert Error -->
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf

                        <!-- Username Input -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold text-secondary small">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-user-tag"></i></span>
                                <input type="text" class="form-control border-start-0 bg-light" id="username" name="username" placeholder="Masukkan username Anda" required />
                            </div>
                        </div>

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-secondary small">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" class="form-control border-start-0 bg-light" id="email" name="email" placeholder="Masukkan email terdaftar" required />
                            </div>
                        </div>

                        <!-- Password Baru Input -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-secondary small">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" class="form-control border-start-0 bg-light" id="password" name="password" placeholder="Masukkan password baru" required />
                            </div>
                        </div>

                        <!-- Konfirmasi Password Input -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold text-secondary small">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" class="form-control border-start-0 bg-light" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" required />
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-teal w-100 py-2.5 fw-bold mb-3 shadow-sm">
                            Ubah Password
                        </button>
                    </form>

                    <div class="text-center mt-2">
                        <span class="text-secondary small">Kembali ke</span>
                        <a href="{{ route('login') }}" class="text-teal text-decoration-none fw-semibold small ms-1">Login</a>
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
