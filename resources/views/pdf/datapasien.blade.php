<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pasien - TBC Care</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0d9488;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #0d9488;
            margin: 0 0 5px 0;
            font-size: 20px;
        }
        .header p {
            margin: 0;
            font-size: 10px;
            color: #666;
        }
        .section-title {
            background-color: #f3f4f6;
            padding: 6px 10px;
            font-weight: bold;
            font-size: 13px;
            color: #0d9488;
            border-left: 4px solid #0d9488;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.info-table td {
            padding: 5px;
            vertical-align: top;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }
        table.data-table th {
            background-color: #0d9488;
            color: white;
            font-size: 11px;
        }
        .badge {
            display: inline-block;
            padding: 3px 6px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 4px;
        }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #999;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>TBC Care - Laporan Riwayat Pasien</h1>
        <p>Sistem Monitoring & Konseling Digital Kesehatan Masyarakat</p>
        <p>Referensi Ekspor Resmi WHO & Kemenkes RI</p>
    </div>

    <div class="section-title">Profil Pasien</div>
    <table class="info-table">
        <tr>
            <td width="30%"><strong>Nama Lengkap:</strong></td>
            <td width="70%">{{ $user['name'] }}</td>
        </tr>
        <tr>
            <td><strong>Username:</strong></td>
            <td>{{ $user['username'] }}</td>
        </tr>
        <tr>
            <td><strong>Usia / Gender:</strong></td>
            <td>{{ $user['usia'] ?? '-' }} tahun / {{ $user['gender'] ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Nomor WA Pasien:</strong></td>
            <td>{{ $user['nomor_wa_pasien'] ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Nomor WA PMO:</strong></td>
            <td>{{ $user['nomor_wa_pmo'] ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Riwayat Penyakit:</strong></td>
            <td>{{ $user['riwayat_penyakit'] ?: 'Tidak ada riwayat penyakit terdokumentasi.' }}</td>
        </tr>
        <tr>
            <td><strong>Streak Kepatuhan Obat:</strong></td>
            <td>{{ $user['current_streak'] ?? '0' }} Hari (Rekor Terpanjang: {{ $user['highest_streak'] ?? '0' }} Hari)</td>
        </tr>
        <tr>
            <td><strong>Status Klinis Saat Ini:</strong></td>
            <td>
                @if($user['ews_overdue_48h'] || $user['ews_weight_downtrend_3'])
                    <span class="badge badge-danger">KONDISI ALERT (EWS)</span>
                @else
                    <span class="badge badge-success">STABIL / NORMAL</span>
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">Log Input Cek Harian</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="20%">Tanggal</th>
                <th width="15%">Suhu (°C)</th>
                <th width="15%">Berat (kg)</th>
                <th width="15%">Nafsu Makan</th>
                <th width="15%">Minum Obat</th>
                <th width="20%">Batuk / Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($user['check_harians'] as $check)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($check->tanggal)->format('d M Y') }}</td>
                    <td>{{ $check->suhu_tubuh ?? $check->suhu ?? '-' }}</td>
                    <td>{{ $check->berat_badan ?? $check->berat ?? '-' }}</td>
                    <td>{{ $check->nafsu_makan ?? '-' }}</td>
                    <td>
                        @if(($check->status_minum_obat ?? $check->minum_obat) === 'Ya' || ($check->status_minum_obat ?? $check->minum_obat) == 1)
                            Ya
                        @else
                            Tidak
                        @endif
                    </td>
                    <td>
                        Batuk: {{ $check->frekuensi_batuk ?? '0' }}/10<br>
                        <small>{{ $check->catatan_bebas ?? $check->catatan_pete }}</small>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Belum ada riwayat lapor check harian.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Riwayat Skrining Keluarga</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="30%">Nama Anggota Keluarga</th>
                <th width="20%">Status Gejala</th>
                <th width="30%">Rekomendasi Tindakan</th>
                <th width="20%">Tanggal Input</th>
            </tr>
        </thead>
        <tbody>
            @forelse($user['skrining_kontaks'] as $kontak)
                <tr>
                    <td>{{ $kontak['nama_anggota_keluarga'] }}</td>
                    <td>
                        @if($kontak['status_gejala'])
                            <span class="badge badge-danger">Bergejala</span>
                        @else
                            <span class="badge badge-success">Tidak Bergejala</span>
                        @endif
                    </td>
                    <td>{{ $kontak['rekomendasi_tindakan'] ?? '-' }}</td>
                    <td>{{ $kontak['created_at'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada riwayat skrining keluarga.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan ini dihasilkan secara otomatis oleh sistem TBC Care pada tanggal {{ date('d F Y H:i WIB') }}.<br>
        &copy; 2026 TBC Care. Hak cipta dilindungi.
    </div>

</body>
</html>
