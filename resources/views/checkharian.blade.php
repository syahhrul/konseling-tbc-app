<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lapor Cek Harian - TBC Care</title>
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

        /* Custom styling for interactive Yes/No Buttons */
        .med-check-label {
            border: 2px solid #cbd5e1;
            border-radius: 0.75rem;
            padding: 1rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-check:checked + .btn-outline-success {
            background-color: #10b981 !important;
            border-color: #10b981 !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-check:checked + .btn-outline-danger {
            background-color: #ef4444 !important;
            border-color: #ef4444 !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* Range Slider Styling */
        .range-value-badge {
            font-size: 1rem;
            padding: 0.4rem 0.8rem;
            border-radius: 0.5rem;
            font-weight: 700;
        }

        .range-light {
            background-color: #d1fae5;
            color: #065f46;
        }

        .range-medium {
            background-color: #fef3c7;
            color: #92400e;
        }

        .range-severe {
            background-color: #fee2e2;
            color: #991b1b;
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

    <main class="container py-4 py-lg-5" style="max-width: 800px;">
        <!-- Card 1: Check Harian Pasien -->
        <div class="card form-card mb-4">
            <div class="form-card-header d-flex align-items-center gap-3">
                <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fa-solid fa-notes-medical fs-4"></i>
                </div>
                <div>
                    <h1 class="h4 fw-bold mb-0">Formulir Check Harian</h1>
                    <p class="mb-0 small text-white-75">Laporkan kondisi dan kepatuhan obat Anda hari ini.</p>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('checkharian.store') }}" method="POST">
                    @csrf
                    
                    <!-- 1. Tanggal -->
                    <div class="mb-4">
                        <label class="form-label form-label-custom"><i class="fa-solid fa-calendar text-teal me-2"></i>Tanggal Laporan</label>
                        <input type="date" name="tanggal" class="form-control form-control-lg border-2" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- 2. Minum Obat Status (Interaktif) -->
                    <div class="mb-4">
                        <label class="form-label form-label-custom d-block"><i class="fa-solid fa-pills text-teal me-2"></i>Apakah Anda sudah meminum obat hari ini?</label>
                        <div class="row g-3">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="minum_obat" id="minumYa" value="Ya" autocomplete="off" required>
                                <label class="btn btn-outline-success d-block med-check-label text-center py-3" for="minumYa">
                                    <i class="fa-solid fa-circle-check fs-4 d-block mb-1"></i> Ya, Sudah
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="minum_obat" id="minumTidak" value="Tidak" autocomplete="off" required>
                                <label class="btn btn-outline-danger d-block med-check-label text-center py-3" for="minumTidak">
                                    <i class="fa-solid fa-circle-xmark fs-4 d-block mb-1"></i> Belum / Tidak
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Suhu Tubuh & Berat Badan -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label form-label-custom"><i class="fa-solid fa-temperature-high text-teal me-2"></i>Suhu Tubuh (°C)</label>
                            <div class="input-group input-group-lg border-2 rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-thermometer text-secondary"></i></span>
                                <input type="number" step="0.1" min="30" max="45" name="suhu_tubuh" class="form-control border-0 bg-light" placeholder="Contoh: 36.5" required>
                                <span class="input-group-text bg-light border-0">°C</span>
                            </div>
                            <div class="form-text small">Segera laporkan apabila suhu tubuh Anda melebihi 38.0°C.</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label form-label-custom"><i class="fa-solid fa-weight-scale text-teal me-2"></i>Berat Badan (kg)</label>
                            <div class="input-group input-group-lg border-2 rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-scale-balanced text-secondary"></i></span>
                                <input type="number" step="0.1" min="1" max="200" name="berat_badan" class="form-control border-0 bg-light" placeholder="Contoh: 55.2" required>
                                <span class="input-group-text bg-light border-0">kg</span>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Skala Batuk (Interaktif Slider) -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label form-label-custom mb-0"><i class="fa-solid fa-head-side-cough text-teal me-2"></i>Tingkat Kerapuhan / Skala Batuk</label>
                            <span id="batukBadge" class="range-value-badge range-light">Skala: 0 (Tidak Batuk)</span>
                        </div>
                        <input type="range" min="0" max="10" step="1" value="0" id="batukRange" name="frekuensi_batuk" class="form-range py-2">
                        <div class="d-flex justify-content-between small text-secondary px-1">
                            <span>0 (Bebas Batuk)</span>
                            <span>5 (Sedang)</span>
                            <span>10 (Batuk Parah)</span>
                        </div>
                    </div>

                    <!-- 5. Nafsu Makan -->
                    <div class="mb-4">
                        <label class="form-label form-label-custom"><i class="fa-solid fa-utensils text-teal me-2"></i>Kondisi Nafsu Makan</label>
                        <select class="form-select form-select-lg border-2" name="nafsu_makan" required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="Baik">Baik</option>
                            <option value="Normal">Normal</option>
                            <option value="Menurun">Menurun (Perlu Waspada)</option>
                        </select>
                    </div>

                    <!-- 6. Catatan Tambahan (Alasan/Efek Samping) -->
                    <div class="mb-4">
                        <label class="form-label form-label-custom"><i class="fa-solid fa-comment-medical text-teal me-2"></i>Alasan Tidak Minum / Efek Samping Obat</label>
                        <textarea class="form-control border-2" name="alasan_tidak_minum" rows="3" placeholder="Isi bila Anda tidak meminum obat hari ini, atau bila merasakan gejala efek samping obat (mual, pusing, dll)."></textarea>
                    </div>

                    <!-- 7. Catatan Keluhan Lain -->
                    <div class="mb-4">
                        <label class="form-label form-label-custom"><i class="fa-solid fa-pen text-teal me-2"></i>Catatan Tambahan / Keluhan Lain</label>
                        <textarea class="form-control border-2" name="catatan_bebas" rows="2" placeholder="Catatan opsional mengenai kondisi fisik Anda hari ini."></textarea>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-teal btn-lg py-3 fw-bold rounded-3 shadow"><i class="fa-solid fa-paper-plane me-2"></i>Kirim Laporan Harian</button>
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

    <!-- Interactive script for range value and badges -->
    <script>
        const batukRange = document.getElementById('batukRange');
        const batukBadge = document.getElementById('batukBadge');
        
        if (batukRange && batukBadge) {
            batukRange.addEventListener('input', function() {
                const val = parseInt(this.value);
                let label = '';
                
                // Reset classes
                batukBadge.className = 'range-value-badge';
                
                if (val <= 3) {
                    batukBadge.classList.add('range-light');
                    label = `Skala: ${val} (Batuk Ringan / Jarang)`;
                } else if (val <= 7) {
                    batukBadge.classList.add('range-medium');
                    label = `Skala: ${val} (Batuk Sedang / Sering)`;
                } else {
                    batukBadge.classList.add('range-severe');
                    label = `Skala: ${val} (Batuk Parah / Sangat Sering)`;
                }
                
                batukBadge.textContent = label;
            });
        }
    </script>
</body>

</html>