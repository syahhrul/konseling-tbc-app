<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin - TBC Care</title>
    <!-- Favicon Paru-paru Medis -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🫁</text></svg>">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <!-- Google Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* EWS Coral Red Alert Panel styling */
        .ews-panel {
            background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
            border: 2px solid #fecdd3;
            border-radius: 1.25rem;
            box-shadow: 0 8px 25px rgba(225, 29, 72, 0.05);
        }

        .ews-badge {
            background-color: #e11d48;
            color: white;
            font-weight: 700;
        }

        .dashboard-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            background-color: white;
            transition: transform 0.2s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
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
                        <a class="nav-link active fw-medium" href="{{ route('admin.dashboard') }}">Dashboard</a>
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

    <!-- Header Banner -->
    <header class="py-5 text-white" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                <div>
                    <span class="badge rounded-pill text-bg-light px-3 py-2 mb-3" style="color:#0d9488;">TBC Care - Dashboard Utama Admin</span>
                    <h1 class="display-5 fw-bold mb-2">Sistem Monitoring Klinis Pasien</h1>
                    <p class="lead mb-0 text-white-75">Pantau data kesehatan harian, indikator kegagalan terapi obat, dan status peringatan dini EWS.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('datapasien') }}" class="btn btn-light btn-lg text-teal fw-bold shadow">
                        <i class="fa-solid fa-user-gear me-2"></i>Kelola Data Pasien
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Alert Session -->
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-0 text-center py-3 mb-0">
            <i class="fa-solid fa-circle-check me-2"></i>{!! session('success') !!}
        </div>
    @endif

    <main class="container py-4 py-lg-5">

        <!-- 1. STATS QUICK OVERVIEW (PUT AT THE VERY TOP) -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-teal bg-opacity-10 text-teal mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-users fs-4"></i>
                        </div>
                        <div class="text-secondary small fw-medium">Pasien Aktif</div>
                        <div class="display-6 fw-bold text-teal mt-1">{{ $summary['total_pasien_aktif'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-triangle-exclamation fs-4"></i>
                        </div>
                        <div class="text-secondary small fw-medium">Kondisi EWS Terlambat</div>
                        <div class="display-6 fw-bold text-danger mt-1">{{ $summary['pasien_ews_terlambat'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-chart-line-down fs-4"></i>
                        </div>
                        <div class="text-secondary small fw-medium">Downtrend Berat</div>
                        <div class="display-6 fw-bold text-warning mt-1">{{ $summary['pasien_ews_tren_memburuk'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-head-side-cough fs-4"></i>
                        </div>
                        <div class="text-secondary small fw-medium">Batuk Parah Hari Ini</div>
                        <div class="display-6 fw-bold text-success mt-1">{{ $summary['pasien_batuk_parah_hari_ini'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. GRAPHICS SECTION (COMPLIANCE CHART AT TOP LEVEL) -->
        <div class="row g-4 justify-content-center mb-4">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3 text-center"><i class="fa-solid fa-chart-pie text-teal me-2"></i>Persentase Kepatuhan Pasien</h2>
                        <div class="mx-auto" style="max-width: 280px;">
                            <canvas id="complianceChart" height="240"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. FULL-WIDTH EWS ALERT PANEL (Coral Red) POSITIONED BELOW THE STATS & GRAPHICS -->
        <div class="card ews-panel p-4 mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 border-bottom pb-3 border-danger-subtle">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-triangle-exclamation fs-4"></i>
                    </div>
                    <div>
                        <h2 class="h5 fw-bold text-danger mb-0">EWS Alert Panel - Tindakan Segera Diperlukan</h2>
                        <p class="mb-0 text-secondary small">Daftar pasien kritis yang terlambat lapor > 48 jam atau berat badan terus turun.</p>
                    </div>
                </div>
                <span class="badge ews-badge rounded-pill px-3 py-2">TOTAL KRITIS: {{ count($ewsAlerts) }}</span>
            </div>

            <div class="row g-3">
                @forelse($ewsAlerts as $alert)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="p-3 bg-white rounded-3 border border-danger-subtle h-100 d-flex flex-column justify-content-between shadow-sm">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h3 class="h6 fw-bold text-dark mb-0">{{ $alert['name'] ?: $alert['username'] }}</h3>
                                    <span class="badge bg-danger bg-opacity-10 text-danger">{{ $alert['status_label'] }}</span>
                                </div>
                                <div class="text-secondary small mb-3">
                                    <strong>Indikator:</strong> {{ implode(', ', $alert['risk_flags']) }}
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                @if(isset($alert['nomor_wa_pasien']))
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $alert['nomor_wa_pasien']) }}" target="_blank" class="btn btn-outline-danger btn-sm flex-grow-1">
                                        <i class="fa-brands fa-whatsapp me-1"></i>WA Pasien
                                    </a>
                                @endif
                                <a href="{{ route('datapasien.detail', ['id' => $alert['id']]) }}" class="btn btn-danger btn-sm flex-grow-1 text-white">
                                    <i class="fa-solid fa-circle-info me-1"></i>Detail Klinis
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="p-4 bg-white rounded-3 text-center border">
                            <i class="fa-solid fa-circle-check text-success fs-2 mb-2"></i>
                            <div class="fw-bold text-success">Kondisi Aman</div>
                            <div class="text-secondary small">Seluruh pasien patuh dan rutin melakukan checklist dalam 24 jam terakhir.</div>
                        </div>
                    </div>
                @endforelse
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

    <!-- Interactive script for doughnut chart -->
    <script>
        const rows = @json($monitoringRows ?? []);
        const todayCompliant = rows.filter(row => !row.ews_overdue_48h && !row.ews_weight_downtrend_3).length;
        const todayAlert = rows.filter(row => row.ews_overdue_48h || row.ews_weight_downtrend_3).length;
        const ctx = document.getElementById('complianceChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Patuh', 'EWS Alert'],
                    datasets: [{
                        data: [todayCompliant, todayAlert],
                        backgroundColor: ['#0d9488', '#e11d48'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '72%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 15,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>

</html>
