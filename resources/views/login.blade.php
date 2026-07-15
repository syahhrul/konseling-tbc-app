<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - TBC Care</title>
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

        .border-teal {
            border-color: #0d9488;
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

        .login-card {
            border-radius: 1.25rem;
            border: none;
            box-shadow: 0 10px 25px rgba(13, 148, 136, 0.1);
        }

        .form-control:focus, .form-select:focus {
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
                
                <div class="card login-card p-4 p-md-5 bg-white">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex p-3 bg-light rounded-circle text-teal mb-3">
                            <i class="fa-solid fa-user-shield fs-1"></i>
                        </div>
                        <h2 class="fw-bold text-teal">Login Pengguna</h2>
                        <p class="text-secondary small">Masukkan kredensial akun Anda untuk mengakses dashboard TBC Care</p>
                    </div>

                    <!-- Alert Success -->
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

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

                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf

                        <!-- User ID Input -->
                        <div class="mb-3">
                            <label for="userId" class="form-label fw-semibold text-secondary small">User ID</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control border-start-0 bg-light" id="userId" name="userId" placeholder="Masukkan User ID" required>
                            </div>
                        </div>

                        <!-- Kode Referal Input (Optional) -->
                        <div class="mb-3">
                            <label for="referral" class="form-label fw-semibold text-secondary small">Kode Referal (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-key"></i></span>
                                <input type="text" class="form-control border-start-0 bg-light" id="referral" name="referral" placeholder="Masukkan kode referal">
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label fw-semibold text-secondary small mb-0">Password</label>
                                <a href="{{ route('lupapassword') }}" class="text-teal text-decoration-none fw-semibold small">Lupa Password?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" class="form-control border-start-0 bg-light" id="password" name="password" placeholder="Masukkan password" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-teal w-100 py-2.5 fw-bold mb-3 shadow-sm">
                            <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Login
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <span class="text-secondary small">Belum punya akun?</span>
                        <a href="{{ route('register.step1') }}" class="text-teal text-decoration-none fw-semibold small ms-1">Daftar Sekarang</a>
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
