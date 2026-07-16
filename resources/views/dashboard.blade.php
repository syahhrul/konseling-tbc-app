<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Pasien - TBC Care</title>
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

        .streak-card {
            border: none;
            border-radius: 1.25rem;
            background: linear-gradient(135deg, #111827 0%, #0d9488 100%);
            color: white;
            box-shadow: 0 10px 25px rgba(13, 148, 136, 0.25);
            position: relative;
            overflow: hidden;
        }

        .streak-card::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            pointer-events: none;
        }

        .streak-icon {
            font-size: 4.5rem;
            color: #10b981;
            /* emerald green */
            filter: drop-shadow(0 0 15px rgba(16, 185, 129, 0.5));
            animation: pulse 2s infinite ease-in-out;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .shortcut-card {
            border: 2px solid transparent;
            border-radius: 1.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: white;
            cursor: pointer;
        }

        .shortcut-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .shortcut-card.card-check {
            border-color: #e6f4ea;
        }

        .shortcut-card.card-check:hover {
            border-color: #0d9488;
        }

        .shortcut-card.card-history {
            border-color: #eaf2f9;
        }

        .shortcut-card.card-history:hover {
            border-color: #0284c7;
        }

        .shortcut-card.card-screening {
            border-color: #f3e8ff;
        }

        .shortcut-card.card-screening:hover {
            border-color: #8b5cf6;
        }

        .shortcut-icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
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
                        <a class="nav-link active fw-medium" href="{{ url('/dashboard') }}">Dashboard</a>
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

    @if(isset($belumIsiHarian) && $belumIsiHarian)
        <div class="alert border-0 rounded-0 m-0 py-3 text-center bg-danger-subtle text-danger d-flex align-items-center justify-content-center flex-wrap gap-2 fw-semibold shadow-sm" role="alert" style="border-bottom: 2px solid #fca5a5 !important;">
            <i class="fa-solid fa-triangle-exclamation text-danger fs-5 me-1"></i>
            <span>Halo <strong>{{ Auth::user()->name ?? Auth::user()->username }}</strong>, Anda belum mengisi laporan kesehatan harian untuk hari ini ({{ $todayDateFormatted ?? date('d F Y') }}). Mohon luangkan waktu 1 menit untuk mengisi demi memantau progres kesembuhan Anda.</span>
            <a href="{{ url('/checkharian') }}" class="btn btn-danger btn-sm fw-bold rounded-pill px-3 ms-md-2 shadow-sm">Isi Cek Harian Sekarang</a>
        </div>
    @endif

    <!-- Top Greeting Section -->
    <header class="bg-white border-bottom py-4">
        <div class="container">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-teal bg-opacity-10 text-teal d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-user-injured fs-3"></i>
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-1">Halo, {{ Auth::user()->name ?? trim(Auth::user()->first_name . ' ' . Auth::user()->last_name) }}!</h1>
                    <p class="text-secondary small mb-0">Selamat datang kembali di pusat kendali pemantauan kesehatan digital Anda.</p>
                </div>
            </div>
        </div>
    </header>

    <main class="container py-4 py-lg-5">
        <div class="row g-4">

            <!-- STREAK KEPATUHAN CARD (Left/Top side) -->
            <div class="col-12 col-lg-5">
                <div class="card streak-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <span class="badge bg-emerald bg-opacity-25 text-white border border-white border-opacity-10 px-3 py-2 mb-3">
                            <i class="fa-solid fa-medal me-1 text-warning"></i>Progres Terapi Anda
                        </span>
                        <div class="d-flex align-items-center gap-4 my-3">
                            <i class="fa-solid fa-fire-flame-curved streak-icon"></i>
                            <div>
                                <h2 class="display-3 fw-black mb-0 text-white">{{ Auth::user()->current_streak ?? 0 }}</h2>
                                <p class="lead mb-0 text-white-50 fw-medium">Hari Patuh Obat</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="progress bg-white bg-opacity-20 mb-3" style="height: 12px; border-radius: 6px;">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ min((Auth::user()->current_streak ?? 0) * 5, 100) }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-white-75 mb-3">
                            <span>Rekor Tertinggi: <strong>{{ Auth::user()->highest_streak ?? 0 }} hari</strong></span>
                            <span>Target Minimum: 180 hari</span>
                        </div>
                        <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-10 small text-white-50">
                            <i class="fa-solid fa-circle-info me-2 text-warning"></i>
                            Berdasarkan pedoman <strong>WHO / Kemenkes RI</strong>, obat TBC wajib dikonsumsi minimal 6 bulan tanpa putus untuk mencegah kebal obat (MDR-TB).
                        </div>
                    </div>
                </div>
            </div>

            <!-- SHORTCUT CARDS (Right side) -->
            <div class="col-12 col-lg-7">
                <div class="row g-3 h-100">

                    <!-- Shortcut 1: Check Harian -->
                    <div class="col-12">
                        <div class="card shortcut-card card-check p-4 h-100 d-flex flex-row align-items-center justify-content-between" onclick="window.location='{{ url('/checkharian') }}'">
                            <div class="d-flex align-items-center gap-3">
                                <div class="shortcut-icon-wrapper bg-success bg-opacity-10 text-teal mb-0">
                                    <i class="fa-solid fa-calendar-check"></i>
                                </div>
                                <div>
                                    <h3 class="h5 fw-bold mb-1">Lapor Check Harian</h3>
                                    <p class="text-secondary small mb-0">Laporkan konsumsi obat, suhu tubuh, berat badan, dan gejala Anda hari ini.</p>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-secondary fs-4 d-none d-sm-block"></i>
                        </div>
                    </div>

                    <!-- Shortcut 2: Riwayat Pengobatan -->
                    <div class="col-12">
                        <div class="card shortcut-card card-history p-4 h-100 d-flex flex-row align-items-center justify-content-between" onclick="window.location='{{ url('/output_pasien') }}'">
                            <div class="d-flex align-items-center gap-3">
                                <div class="shortcut-icon-wrapper bg-info bg-opacity-10 text-info mb-0">
                                    <i class="fa-solid fa-clipboard-list"></i>
                                </div>
                                <div>
                                    <h3 class="h5 fw-bold mb-1">Riwayat & Progres Terapi</h3>
                                    <p class="text-secondary small mb-0">Lihat data perkembangan minum obat harian Anda beserta ringkasan grafik kepatuhan.</p>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-secondary fs-4 d-none d-sm-block"></i>
                        </div>
                    </div>

                    <!-- Shortcut 3: Skrining Kontak Keluarga -->
                    <div class="col-12">
                        <div class="card shortcut-card card-screening p-4 h-100 d-flex flex-row align-items-center justify-content-between" onclick="window.location='{{ route('skrining.kontak.create') }}'">
                            <div class="d-flex align-items-center gap-3">
                                <div class="shortcut-icon-wrapper bg-purple bg-opacity-10 text-purple mb-0" style="color: #8b5cf6; background-color: rgba(139, 92, 246, 0.1);">
                                    <i class="fa-solid fa-people-group"></i>
                                </div>
                                <div>
                                    <h3 class="h5 fw-bold mb-1">Skrining Kontak Erat Keluarga</h3>
                                    <p class="text-secondary small mb-0">Deteksi dini gejala TBC bagi anggota keluarga serumah untuk pemutusan rantai penularan.</p>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-secondary fs-4 d-none d-sm-block"></i>
                        </div>
                    </div>

                </div>
            </div>

            <!-- PATIENT PROFILE & DETAILS -->
            <div class="col-12 col-md-6 mt-4">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <h3 class="h5 fw-bold mb-3"><i class="fa-solid fa-id-card me-2 text-teal"></i>Detail Rekam Medis</h3>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-secondary">Kode Rekam Medis</span>
                            <span class="fw-bold">RM{{ str_pad(Auth::user()->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-secondary">Nomor WhatsApp PMO</span>
                            <span class="fw-semibold">{{ Auth::user()->nomor_wa_pmo ?? '-' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-secondary">Status Pemantauan</span>
                            <span class="badge bg-teal bg-opacity-10 text-teal px-3 py-1">Aktif Dipantau</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- AUTOMATED REMINDERS & PMO INFO -->
            <div class="col-12 col-md-6 mt-4">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <h3 class="h5 fw-bold mb-3"><i class="fa-solid fa-bell me-2 text-warning"></i>Pengingat Otomatis</h3>
                    <p class="text-secondary small mb-3">Apabila Anda belum melaporkan status minum obat hari ini hingga pukul <strong>21:00 WIB</strong>, sistem TBC Care secara otomatis mengirimkan notifikasi peringatan ke WhatsApp Pengawas Menelan Obat (PMO) Anda.</p>
                    <div class="p-3 bg-light rounded-3 d-flex align-items-center gap-3 mb-3">
                        <i class="fa-brands fa-whatsapp text-success fs-3"></i>
                        <div>
                            <div class="fw-semibold small">Status Integrasi PMO</div>
                            <div class="text-success small"><i class="fa-solid fa-circle-check me-1"></i>Aktif & Terkoneksi</div>
                        </div>
                    </div>
                    <div id="push-status-container" class="mt-2">
                        <button id="btn-enable-push" class="btn btn-teal btn-sm w-100 rounded-pill shadow-sm py-2" style="display: none;">
                            <i class="fa-solid fa-bell me-1"></i> Aktifkan Notifikasi Pengingat Browser
                        </button>
                        <div id="push-active-badge" class="p-3 bg-success bg-opacity-10 rounded-3 d-flex align-items-center gap-3" style="display: none;">
                            <i class="fa-solid fa-bell text-success fs-3"></i>
                            <div>
                                <div class="fw-semibold small text-success">Notifikasi Browser</div>
                                <div class="text-secondary small text-success">Aktif & Siap Menerima Pengingat</div>
                            </div>
                        </div>
                        <div id="ios-pwa-tip" class="p-3 bg-warning bg-opacity-10 rounded-3 small text-dark mt-2" style="display: none;">
                            <i class="fa-solid fa-circle-info text-warning me-1"></i> 
                            <strong>Pengguna iPhone/iPad:</strong> Tambahkan web ini ke <strong>Layar Utama (Add to Home Screen)</strong> terlebih dahulu melalui tombol Share Safari agar fitur notifikasi didukung.
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

    <!-- Web Push Notification Client Integration -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";
            const btnEnablePush = document.getElementById('btn-enable-push');
            const pushActiveBadge = document.getElementById('push-active-badge');
            const iosPwaTip = document.getElementById('ios-pwa-tip');
            
            if (!vapidPublicKey) {
                console.warn("[WebPush] VAPID Public Key is not configured.");
                return;
            }

            // Detect iOS Safari behavior
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            const isStandalone = window.matchMedia('(display-mode: standalone)').matches;

            if (isIOS && !isStandalone) {
                if (iosPwaTip) iosPwaTip.style.display = 'block';
            }

            if ('serviceWorker' in navigator && 'PushManager' in window) {
                navigator.serviceWorker.register('/sw.js')
                     .then(function (registration) {
                         console.log('[ServiceWorker] Registered successfully.');
                         
                         if (Notification.permission === 'granted') {
                             if (pushActiveBadge) pushActiveBadge.style.display = 'flex';
                             subscribeUserToPush(registration, vapidPublicKey);
                         } else {
                             if (btnEnablePush) {
                                 btnEnablePush.style.display = 'block';
                                 btnEnablePush.addEventListener('click', function() {
                                     requestNotificationPermission().then(permission => {
                                         if (permission === 'granted') {
                                             btnEnablePush.style.display = 'none';
                                             if (pushActiveBadge) pushActiveBadge.style.display = 'flex';
                                             subscribeUserToPush(registration, vapidPublicKey);
                                         } else {
                                             alert('Izin notifikasi ditolak. Harap aktifkan izin notifikasi pada pengaturan browser Anda.');
                                         }
                                     });
                                 });
                             }
                         }
                     })
                     .catch(function (error) {
                         console.error('[ServiceWorker] Registration failed:', error);
                     });
            } else {
                console.warn('[WebPush] Push messaging is not supported in this browser.');
            }
        });

        function requestNotificationPermission() {
            return new Promise(function (resolve, reject) {
                const permissionResult = Notification.requestPermission(function (result) {
                    resolve(result);
                });

                if (permissionResult) {
                    permissionResult.then(resolve, reject);
                }
            });
        }

        function subscribeUserToPush(registration, publicKey) {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(publicKey)
            };

            return registration.pushManager.subscribe(subscribeOptions)
                .then(function (pushSubscription) {
                    console.log('[WebPush] Subscription retrieved:', JSON.stringify(pushSubscription));
                    sendSubscriptionToBackend(pushSubscription);
                    return pushSubscription;
                })
                .catch(function (error) {
                    console.error('[WebPush] Failed to subscribe user to push notifications:', error);
                });
        }

        function sendSubscriptionToBackend(subscription) {
            fetch("{{ route('push.subscribe') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(subscription)
            })
            .then(response => response.json())
            .then(data => {
                console.log('[WebPush] Subscription synced to backend successfully:', data);
            })
            .catch(error => {
                console.error('[WebPush] Error syncing push subscription to backend:', error);
            });
        }

        // Helper function to encode URL-safe Base64 public key to Uint8Array
        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }
    </script>
</body>

</html>