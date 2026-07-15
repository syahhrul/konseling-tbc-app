<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Monitoring Pasien - TBC Care</title>
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

        .patient-card {
            border: 2px solid transparent;
            border-radius: 1.25rem;
            transition: all 0.3s ease;
            background-color: white;
        }

        .patient-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .patient-card.border-critical {
            border-color: #fecdd3;
            background: linear-gradient(to bottom, #ffffff 80%, #fff5f5 100%);
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
                        <a class="nav-link active fw-medium" href="{{ route('datapasien') }}">Kelola Pasien</a>
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
                    <span class="badge rounded-pill text-bg-light px-3 py-2 mb-3" style="color:#0d9488;">TBC Care - Manajemen Data Pasien</span>
                    <h1 class="display-6 fw-bold mb-2">Portal Kelola & Data Registrasi Pasien</h1>
                    <p class="lead mb-0 text-white-75">Kelola rekam profil pasien, lakukan registrasi pasien baru, dan ekspor database.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-light btn-lg text-teal fw-bold shadow" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                        <i class="fa-solid fa-user-plus me-2"></i>Tambah Pasien Baru
                    </button>
                    <a href="{{ route('admin.pasien.export.csv') }}" class="btn btn-outline-light btn-lg">
                        <i class="fa-solid fa-file-csv me-2"></i>Export CSV
                    </a>
                    <a href="{{ route('admin.pasien.export.pdf') }}" class="btn btn-outline-light btn-lg">
                        <i class="fa-solid fa-file-pdf me-2"></i>Export PDF Rekap
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-0 text-center py-3 mb-0">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        </div>
    @endif

    <main class="container py-4 py-lg-5">

        <!-- FILTERS PANEL -->
        <div class="card border-0 shadow-sm p-4 mb-4">
            <h2 class="h6 fw-bold text-secondary mb-3"><i class="fa-solid fa-filter me-2 text-teal"></i>Filter Laporan & Pasien</h2>
            <form method="GET" action="{{ route('datapasien') }}" class="row g-3">
                <div class="col-12 col-md-3">
                    <label class="form-label small fw-semibold text-secondary">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $filters['tanggal_mulai'] ?? '' }}">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label small fw-semibold text-secondary">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ $filters['tanggal_selesai'] ?? '' }}">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label small fw-semibold text-secondary">Gejala Khusus</label>
                    <select name="gejala" class="form-select">
                        <option value="" selected>Semua Kondisi</option>
                        <option value="demam" {{ ($filters['gejala'] ?? '') === 'demam' ? 'selected' : '' }}>Demam (>38°C)</option>
                        <option value="batuk_parah" {{ ($filters['gejala'] ?? '') === 'batuk_parah' ? 'selected' : '' }}>Batuk Parah</option>
                        <option value="ews" {{ ($filters['gejala'] ?? '') === 'ews' ? 'selected' : '' }}>Alert / Warning EWS</option>
                    </select>
                </div>
                <div class="col-12 col-md-3 d-flex align-items-end gap-2">
                    <button class="btn btn-teal w-100" type="submit"><i class="fa-solid fa-magnifying-glass me-2"></i>Cari</button>
                    <a href="{{ route('datapasien') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrows-rotate"></i></a>
                </div>
            </form>
        </div>

        <!-- Patient Card List -->
        <h2 class="h4 fw-bold mb-3"><i class="fa-solid fa-users text-teal me-2"></i>Daftar Laporan Pasien</h2>

        @if(isset($message) && count($monitoringRows) === 0)
            <div class="alert alert-info">{{ $message }}</div>
        @else
            <div class="d-grid gap-3">
                @foreach($monitoringRows as $user)
                    @php
                        $isEws = $user['ews_overdue_48h'] || $user['ews_weight_downtrend_3'];
                    @endphp
                    <div class="card patient-card border-0 shadow-sm p-4 {{ $isEws ? 'border-critical shadow-sm' : '' }}">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 border-bottom pb-3 mb-3">
                            <div class="d-flex gap-3 align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 {{ $isEws ? 'bg-danger bg-opacity-10 text-danger' : 'bg-success bg-opacity-10 text-success' }}" style="width: 52px; height: 52px;">
                                    <i class="fa-solid {{ $isEws ? 'fa-triangle-exclamation' : 'fa-check-double' }} fs-4"></i>
                                </div>
                                <div>
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <h3 class="h5 fw-bold text-dark mb-0">{{ $user['name'] ?: $user['username'] }}</h3>
                                        <span class="badge {{ $isEws ? 'bg-danger' : 'bg-success' }}">{{ $user['status_label'] }}</span>
                                    </div>
                                    <div class="text-secondary small mt-1">Last Log: {{ $user['last_follow_up'] ? \Carbon\Carbon::parse($user['last_follow_up'])->format('d M Y H:i') : 'Belum Pernah' }}</div>
                                </div>
                            </div>

                            <div class="d-flex gap-4">
                                <div>
                                    <div class="text-secondary small">Berat Terakhir</div>
                                    <div class="fw-bold text-dark">{{ $user['last_weight'] !== null ? number_format($user['last_weight'], 1) . ' kg' : '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-secondary small">Suhu Terakhir</div>
                                    <div class="fw-bold text-dark">{{ $user['last_temperature'] !== null ? number_format($user['last_temperature'], 1) . ' °C' : '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <div class="text-secondary small">WhatsApp Pasien</div>
                                    <div class="fw-bold text-dark mt-1">{{ $user['nomor_wa_pasien'] ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <div class="text-secondary small">WhatsApp PMO</div>
                                    <div class="fw-bold text-dark mt-1">{{ $user['nomor_wa_pmo'] ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <div class="text-secondary small">EWS Overdue 48h</div>
                                    <div class="fw-bold text-dark mt-1">{{ $user['ews_overdue_48h'] ? 'Ya' : 'Tidak' }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <div class="text-secondary small">Downtrend Berat</div>
                                    <div class="fw-bold text-dark mt-1">{{ $user['ews_weight_downtrend_3'] ? 'Ya' : 'Tidak' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div>
                                <!-- Redirection to separate detailed monitoring page -->
                                <a href="{{ route('datapasien.detail', ['id' => $user['id']]) }}" class="btn btn-outline-teal btn-sm me-2">
                                    <i class="fa-solid fa-chart-line me-1"></i>Lihat Detail Rekam Medis
                                </a>
                                <a href="{{ route('datapasien.download', ['user' => $user['id']]) }}" class="btn btn-outline-secondary btn-sm me-2">
                                    <i class="fa-solid fa-file-pdf me-1"></i>PDF Pasien
                                </a>
                                <button onclick="sendPushNotification({{ $user['id'] }})" class="btn btn-outline-warning btn-sm me-2 text-dark border-warning fw-semibold">
                                    <i class="fa-solid fa-bell me-1 text-warning"></i>Kirim Pengingat (Demo Browser)
                                </button>
                                @if($isEws)
                                    <a href="{{ route('admin.pasien.reminder', ['id' => $user['id']]) }}" target="_blank" class="btn btn-outline-success btn-sm me-2 text-success fw-bold border-success">
                                        <i class="fa-brands fa-whatsapp me-1 text-success fw-bold"></i>Hubungi PMO (EWS)
                                    </a>
                                @endif
                            </div>
                            <div>
                                <button class="btn btn-teal btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editPatientModal-{{ $user['id'] }}">
                                    <i class="fa-solid fa-user-edit me-1"></i>Edit
                                </button>
                                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePatientModal-{{ $user['id'] }}">
                                    <i class="fa-solid fa-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- EDIT PATIENT MODAL FOR THIS USER -->
                    <div class="modal fade" id="editPatientModal-{{ $user['id'] }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg">
                                <div class="modal-header bg-teal text-white">
                                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-pen me-2"></i>Edit Data Pasien</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('datapasien.update', ['id' => $user['id']]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Lengkap</label>
                                            <input type="text" name="name" class="form-control" value="{{ $user['name'] }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Username</label>
                                            <input type="text" name="username" class="form-control" value="{{ $user['username'] }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ $user['email'] ?? '' }}" required>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-6">
                                                <label class="form-label fw-semibold">Usia (Tahun)</label>
                                                <input type="number" name="usia" class="form-control" value="{{ $user['usia'] }}" required>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold">Jenis Kelamin</label>
                                                <select name="gender" class="form-select" required>
                                                    <option value="Laki-laki" {{ ($user['gender'] ?? '') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                    <option value="Perempuan" {{ ($user['gender'] ?? '') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                    <option value="Lainnya" {{ ($user['gender'] ?? '') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-6">
                                                <label class="form-label fw-semibold">No WA Pasien</label>
                                                <input type="text" name="nomor_wa_pasien" class="form-control" value="{{ $user['nomor_wa_pasien'] }}" required>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold">No WA PMO</label>
                                                <input type="text" name="nomor_wa_pmo" class="form-control" value="{{ $user['nomor_wa_pmo'] }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Alamat</label>
                                            <input type="text" name="address" class="form-control" value="{{ $user['address'] ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Riwayat Penyakit</label>
                                            <textarea name="riwayat_penyakit" class="form-control" rows="2">{{ $user['riwayat_penyakit'] ?? '' }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Password Baru (Kosongkan jika tidak diganti)</label>
                                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 p-3 bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-teal">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- DELETE PATIENT CONFIRMATION MODAL -->
                    <div class="modal fade" id="deletePatientModal-{{ $user['id'] }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content border-0 shadow-lg">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-slash me-2"></i>Hapus Pasien</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4 text-center">
                                    <i class="fa-solid fa-triangle-exclamation text-danger fs-1 mb-3"></i>
                                    <p class="mb-0">Apakah Anda yakin ingin menghapus data pasien <strong>{{ $user['name'] ?: $user['username'] }}</strong> secara permanen?</p>
                                    <p class="text-danger small mt-2 mb-0">Tindakan ini juga menghapus log harian dan riwayat kontak erat keluarga.</p>
                                </div>
                                <div class="modal-footer border-0 p-3 bg-light justify-content-center">
                                    <form action="{{ route('datapasien.destroy', ['id' => $user['id']]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </main>

    <!-- ADD NEW PATIENT MODAL -->
    <div class="modal fade" id="addPatientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-teal text-white">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-plus me-2"></i>Registrasi Pasien Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('datapasien.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap Pasien</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username Login</label>
                            <input type="text" name="username" class="form-control" placeholder="Contoh: budi123" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Aktif</label>
                            <input type="email" name="email" class="form-control" placeholder="Contoh: budi@gmail.com" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Usia (Tahun)</label>
                                <input type="number" name="usia" class="form-control" placeholder="Contoh: 28" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Jenis Kelamin</label>
                                <select name="gender" class="form-select" required>
                                    <option value="" selected>-- Pilih --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">No WhatsApp Pasien</label>
                                <input type="text" name="nomor_wa_pasien" class="form-control" placeholder="Contoh: 081234567890" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">No WhatsApp PMO</label>
                                <input type="text" name="nomor_wa_pmo" class="form-control" placeholder="Contoh: 089876543210" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat</label>
                            <input type="text" name="address" class="form-control" placeholder="Jl. Raya Kebangsaan No. 4">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Riwayat Penyakit (Bila ada)</label>
                            <textarea name="riwayat_penyakit" class="form-control" rows="2" placeholder="Contoh: Diabetes, Asma, dsb."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Akun (Kosongkan untuk menyamakan dengan username)</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-3 bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-teal">Daftarkan Pasien</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

    <!-- Web Push AJAX Notification Trigger Script -->
    <script>
        function sendPushNotification(userId) {
            if (!confirm("Apakah Anda yakin ingin mengirim Notifikasi Browser (Web Push) pengingat minum obat secara langsung ke pasien ini secara real-time?")) {
                return;
            }

            // Show loading state/cursor
            document.body.style.cursor = 'wait';

            fetch(`/admin/trigger-push-demo/${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.body.style.cursor = 'default';
                if (data.success) {
                    alert("Sukses! " + data.message);
                } else {
                    alert("Gagal: " + data.message);
                }
            })
            .catch(error => {
                document.body.style.cursor = 'default';
                console.error("Error sending push notification:", error);
                alert("Terjadi kesalahan teknis saat menghubungi server push.");
            });
        }
    </script>
</body>

</html>