<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Pasien - TBC Care</title>
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

        .info-card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            background-color: white;
            overflow: hidden;
        }

        .info-card-header {
            background-color: #0d9488;
            color: white;
            padding: 1.5rem;
            border-bottom: none;
        }

        .family-member-card {
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            border-radius: 0.75rem;
            transition: border-color 0.2s ease;
        }

        .family-member-card:hover {
            border-color: #cbd5e1;
        }
    </style>
</head>

<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-teal shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-lungs-virus fs-3"></i>
                <span>TBC Care</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('datapasien') }}">Kelola Pasien</a>
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
        
        <!-- Back and Print Row -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('datapasien') }}" class="btn btn-outline-teal">
                <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Daftar Pasien
            </a>
            <a href="{{ route('datapasien.download', ['user' => $user['id']]) }}" class="btn btn-teal">
                <i class="fa-solid fa-file-pdf me-2"></i>Ekspor Laporan PDF Pasien
            </a>
        </div>

        <div class="row g-4">
            
            <!-- Left Side: Profile & Family Screenings -->
            <div class="col-12 col-lg-4">
                
                <!-- Patient Profile Card -->
                <div class="card info-card mb-4">
                    <div class="info-card-header d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-user-injured fs-4"></i>
                        </div>
                        <div>
                            <h2 class="h5 fw-bold mb-0">Profil Pasien</h2>
                            <p class="mb-0 small text-white-75">Detail informasi dasar & klinis.</p>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-dark mb-3">{{ $user['name'] }}</h3>
                        
                        <div class="mb-3">
                            <span class="text-secondary small d-block">Username</span>
                            <span class="fw-semibold text-dark">{{ $user['username'] }}</span>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <span class="text-secondary small d-block">Usia</span>
                                <span class="fw-semibold text-dark">{{ $user['usia'] ?? '-' }} Tahun</span>
                            </div>
                            <div class="col-6">
                                <span class="text-secondary small d-block">Jenis Kelamin</span>
                                <span class="fw-semibold text-dark">{{ $user['gender'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <span class="text-secondary small d-block">No. WhatsApp Pasien</span>
                            <span class="fw-semibold text-dark">
                                @if($user['nomor_wa_pasien'])
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user['nomor_wa_pasien']) }}" target="_blank" class="text-teal text-decoration-none">
                                        <i class="fa-brands fa-whatsapp me-1 text-success"></i>{{ $user['nomor_wa_pasien'] }}
                                    </a>
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        <div class="mb-3">
                            <span class="text-secondary small d-block">No. WhatsApp PMO (Pengawas)</span>
                            <span class="fw-semibold text-dark">
                                @if($user['nomor_wa_pmo'])
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user['nomor_wa_pmo']) }}" target="_blank" class="text-teal text-decoration-none">
                                        <i class="fa-brands fa-whatsapp me-1 text-success"></i>{{ $user['nomor_wa_pmo'] }}
                                    </a>
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        <div class="mb-3">
                            <span class="text-secondary small d-block">Status Kepatuhan</span>
                            <span class="fw-semibold text-teal">{{ $user['status_label'] }}</span>
                        </div>
                        <div class="mb-0">
                            <span class="text-secondary small d-block">Riwayat Penyakit</span>
                            <span class="text-dark">{{ $user['riwayat_penyakit'] ?: 'Tidak ada riwayat penyakit.' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Family Screenings Card-list -->
                <div class="card info-card">
                    <div class="info-card-header bg-dark d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-people-roof fs-4"></i>
                        </div>
                        <div>
                            <h2 class="h5 fw-bold mb-0">Skrining Kontak Erat</h2>
                            <p class="mb-0 small text-white-50">Laporan penularan keluarga.</p>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-3">
                            @forelse($user['skrining_kontaks'] as $kontak)
                                <div class="p-3 family-member-card">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <strong class="text-dark">{{ $kontak['nama_anggota_keluarga'] }}</strong>
                                        <span class="badge {{ $kontak['status_gejala'] ? 'bg-danger' : 'bg-success' }}">
                                            {{ $kontak['status_gejala'] ? 'Bergejala' : 'Bebas Gejala' }}
                                        </span>
                                    </div>
                                    <div class="small text-secondary mb-1">
                                        <strong>Rekomendasi:</strong> {{ $kontak['rekomendasi_tindakan'] ?? 'Pantau kondisi' }}
                                    </div>
                                    <div class="small text-secondary-50" style="font-size: 0.75rem;">
                                        Input: {{ $kontak['created_at'] ?? '-' }}
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-secondary py-3 mb-0 small text-center">
                                    <i class="fa-solid fa-face-smile me-2"></i>Belum ada skrining keluarga yang dilaporkan.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Side: Check Harian History Table -->
            <div class="col-12 col-lg-8">
                
                <div class="card info-card">
                    <div class="info-card-header bg-teal d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-notes-medical fs-4"></i>
                        </div>
                        <div>
                            <h2 class="h5 fw-bold mb-0">Riwayat Laporan Check Harian Pasien</h2>
                            <p class="mb-0 small text-white-75">Log monitoring klinis yang diinputkan oleh pasien.</p>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Tanggal</th>
                                        <th>Minum Obat</th>
                                        <th>Suhu / Berat</th>
                                        <th>Nafsu Makan</th>
                                        <th>Batuk / Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($user['check_harians'] as $check)
                                        <tr>
                                            <td class="ps-4 fw-semibold">
                                                {{ \Carbon\Carbon::parse($check->tanggal)->format('d M Y') }}
                                            </td>
                                            <td>
                                                @if(($check->status_minum_obat ?? $check->minum_obat) === 'Ya' || ($check->status_minum_obat ?? $check->minum_obat) == 1)
                                                    <span class="badge bg-success bg-opacity-10 text-success"><i class="fa-solid fa-circle-check me-1"></i>Sudah</span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger"><i class="fa-solid fa-circle-xmark me-1"></i>Belum</span>
                                                    @if($check->alasan_tidak_minum)
                                                        <div class="small text-secondary mt-1">Alasan: {{ $check->alasan_tidak_minum }}</div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <div>Suhu: <span class="fw-semibold">{{ $check->suhu_tubuh ?? $check->suhu ?? '-' }} °C</span></div>
                                                <div class="small text-secondary">Berat: {{ $check->berat_badan ?? $check->berat ?? '-' }} kg</div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $check->nafsu_makan ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <div>Skala: <strong class="text-teal">{{ $check->frekuensi_batuk ?? '0' }}/10</strong></div>
                                                @if($check->catatan_bebas)
                                                    <div class="small text-secondary-50 text-wrap" style="max-width: 200px;">Catatan: {{ $check->catatan_bebas }}</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-secondary">Belum ada riwayat lapor check harian.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
