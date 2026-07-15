<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TBC Care - Riwayat Pasien</title>
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

        .history-card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            background-color: white;
            overflow: hidden;
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
                        <a class="nav-link active fw-medium" href="{{ url('/output_pasien') }}">Riwayat Harian</a>
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

    <!-- Header Banner -->
    <header class="py-5 text-white" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">
        <div class="container">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
                <div>
                    <span class="badge rounded-pill text-bg-light px-3 py-2 mb-3" style="color:#0d9488;">TBC Care - Riwayat Progres Medis</span>
                    <h1 class="display-6 fw-bold mb-2">Riwayat Monitoring Harian Pasien</h1>
                    <p class="lead mb-0 text-white-75">Pantau tingkat kepatuhan minum obat dan catatan perkembangan klinis harian Anda.</p>
                </div>
                <div>
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-4 bg-white rounded-3">
                            <div class="small text-secondary fw-semibold">Status Monitoring</div>
                            <div class="h3 fw-bold mb-0 text-success">{{ $checkHarian->count() > 0 ? 'Aktif Terpantau' : 'Belum Memulai' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container py-4 py-lg-5">
        
        <!-- Stats summary cards -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 history-card">
                    <div class="card-body p-4">
                        <div class="text-secondary small fw-medium">Nama Lengkap Pasien</div>
                        <div class="fw-bold text-dark mt-1">{{ $user->name ?? trim($user->first_name . ' ' . $user->last_name) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 history-card">
                    <div class="card-body p-4">
                        <div class="text-secondary small fw-medium">Nomor Rekam Medis</div>
                        <div class="fw-bold text-dark mt-1">{{ $rekamMedis }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 history-card">
                    <div class="card-body p-4">
                        <div class="text-secondary small fw-medium">Streak Kepatuhan Aktif</div>
                        <div class="fw-bold text-success mt-1"><i class="fa-solid fa-fire-flame-curved me-1 text-danger"></i>{{ $user->current_streak ?? 0 }} Hari</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 history-card">
                    <div class="card-body p-4">
                        <div class="text-secondary small fw-medium">Persentase Kepatuhan</div>
                        <div class="fw-bold text-teal mt-1">{{ number_format($compliancePercentage, 0) }}%</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card history-card mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 border-bottom pb-3">
                    <h2 class="h5 mb-0 text-dark fw-bold"><i class="fa-solid fa-table text-teal me-2"></i>Log Cek Harian</h2>
                    <!-- PDF Download integrated link -->
                    <a href="{{ route('datapasien.download', ['user' => Auth::user()->id]) }}" class="btn btn-teal btn-sm px-3 fw-bold rounded-pill">
                        <i class="fa-solid fa-file-pdf me-1"></i>Ekspor Laporan PDF
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Suhu (°C)</th>
                                <th>Berat Badan</th>
                                <th>Nafsu Makan</th>
                                <th>Minum Obat</th>
                                <th>Skala Batuk & Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($checkHarian as $check)
                                <tr>
                                    <td class="fw-semibold">{{ \Carbon\Carbon::parse($check->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $check->suhu_tubuh ?? $check->suhu ?? '-' }} °C</td>
                                    <td>{{ $check->berat_badan ?? $check->berat ?? '-' }} kg</td>
                                    <td><span class="badge bg-secondary">{{ $check->nafsu_makan }}</span></td>
                                    <td>
                                        @if(($check->status_minum_obat ?? $check->minum_obat) === 'Ya' || ($check->status_minum_obat ?? $check->minum_obat) == 1)
                                            <span class="badge bg-success bg-opacity-10 text-success"><i class="fa-solid fa-circle-check me-1"></i>Ya</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger"><i class="fa-solid fa-circle-xmark me-1"></i>Tidak</span>
                                            @if($check->alasan_tidak_minum)
                                                <div class="small text-secondary mt-1">Alasan: {{ $check->alasan_tidak_minum }}</div>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <div>Batuk: <strong class="text-teal">{{ $check->frekuensi_batuk ?? '0' }}/10</strong></div>
                                        @if($check->catatan_bebas)
                                            <small class="text-secondary d-block mt-1">{{ $check->catatan_bebas }}</small>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-secondary">Belum ada data check harian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100 history-card">
                    <div class="card-body p-4 text-center text-md-start">
                        <h3 class="h6 text-secondary fw-semibold">Durasi Program Pengobatan (WHO)</h3>
                        <div class="display-6 fw-bold text-dark mt-2">{{ $totalTreatmentDuration }} Hari</div>
                        <div class="text-secondary small mt-1">Total durasi 6 bulan (Fase Intensif 2 bulan + Fase Lanjutan 4 bulan).</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100 history-card">
                    <div class="card-body p-4 text-center text-md-start">
                        <h3 class="h6 text-secondary fw-semibold">Konsistensi Minum Obat</h3>
                        <div class="display-6 fw-bold text-teal mt-2">{{ $compliantDays }} / {{ $totalUniqueDays }} Laporan</div>
                        <div class="text-secondary small mt-1">Rasio kesuksesan konsumsi obat dari total input laporan aktif.</div>
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