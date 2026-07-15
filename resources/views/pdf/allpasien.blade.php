<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Seluruh Pasien - TBC Care</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
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
            font-size: 18px;
        }
        .header p {
            margin: 0;
            font-size: 10px;
            color: #666;
        }
        .summary-box {
            background-color: #f0fdfa;
            border: 1px solid #99f6e4;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .summary-box table {
            width: 100%;
            margin-bottom: 0;
        }
        .summary-box td {
            font-size: 11px;
            padding: 4px;
        }
        .section-title {
            background-color: #f3f4f6;
            padding: 6px 10px;
            font-weight: bold;
            font-size: 12px;
            color: #0d9488;
            border-left: 4px solid #0d9488;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #e5e7eb;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        table.data-table th {
            background-color: #0d9488;
            color: white;
            font-size: 10px;
        }
        .badge {
            display: inline-block;
            padding: 2px 4px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 4px;
        }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .footer {
            margin-top: 30px;
            font-size: 9px;
            text-align: center;
            color: #999;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>TBC Care - Rekapitulasi Data Pemantauan Pasien</h1>
        <p>Sistem Monitoring & Konseling Digital Kesehatan Masyarakat</p>
        <p>Tanggal Ekspor: {{ $export_date }}</p>
    </div>

    <div class="summary-box">
        <strong>Ringkasan Status Sistem:</strong>
        <table cellspacing="0">
            <tr>
                <td width="25%"><strong>Total Pasien Aktif:</strong></td>
                <td width="25%">{{ $summary['total_pasien_aktif'] }}</td>
                <td width="25%"><strong>Pasien Terlambat Input (EWS):</strong></td>
                <td width="25%">{{ $summary['pasien_ews_terlambat'] }}</td>
            </tr>
            <tr>
                <td><strong>Downtrend Berat Badan:</strong></td>
                <td>{{ $summary['pasien_ews_tren_memburuk'] }}</td>
                <td><strong>Batuk Parah Hari Ini:</strong></td>
                <td>{{ $summary['pasien_batuk_parah_hari_ini'] }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Daftar Pasien & Status Kepatuhan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="20%">Nama Pasien</th>
                <th width="15%">No WA Pasien</th>
                <th width="15%">No WA PMO</th>
                <th width="15%">Log Terakhir</th>
                <th width="15%">Status Pemantauan</th>
                <th width="15%">Indikator Risiko</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user['id'] }}</td>
                    <td>
                        <strong>{{ $user['name'] }}</strong><br>
                        Usia: {{ $user['usia'] ?? '-' }} th | {{ $user['gender'] ?? '-' }}
                    </td>
                    <td>{{ $user['nomor_wa_pasien'] ?? '-' }}</td>
                    <td>{{ $user['nomor_wa_pmo'] ?? '-' }}</td>
                    <td>{{ $user['last_follow_up'] ? \Carbon\Carbon::parse($user['last_follow_up'])->format('d M Y H:i') : 'Belum Input' }}</td>
                    <td>
                        @if($user['ews_overdue_48h'] || $user['ews_weight_downtrend_3'])
                            <span class="badge badge-danger">EWS ALERT</span>
                        @else
                            <span class="badge badge-success">Stabil</span>
                        @endif
                    </td>
                    <td>
                        @if(empty($user['risk_flags']))
                            -
                        @else
                            {{ implode(', ', $user['risk_flags']) }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data pasien pengguna.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Rekapitulasi ini dihasilkan secara otomatis oleh sistem TBC Care.<br>
        &copy; 2026 TBC Care. Hak cipta dilindungi.
    </div>

</body>
</html>
