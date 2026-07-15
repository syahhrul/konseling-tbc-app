<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DataPasienController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->where('role', 'pengguna')
            ->with(['checkHarians' => function ($query) {
                $query->orderByDesc('tanggal')->orderByDesc('id');
            }, 'skriningKontaks' => function ($query) {
                $query->latest();
            }])
            ->get()
            ->map(function (User $user) {
                return $this->buildMonitoringRow($user);
            });

        if ($users->isEmpty()) {
            return view('datapasien')->with([
                'message' => 'Tidak ada data pasien yang tersedia.',
                'summary' => $this->emptySummary(),
                'monitoringRows' => collect(),
                'ewsAlerts' => collect(),
                'severeCoughTodayCount' => 0,
            ]);
        }

        $monitoringRows = $this->applyOptionalFilters($users, $request);

        return view('datapasien', [
            'users' => $monitoringRows,
            'monitoringRows' => $monitoringRows,
            'summary' => $this->buildSummary($monitoringRows),
            'ewsAlerts' => $monitoringRows->filter(fn (array $row) => $row['ews_overdue_48h'] || $row['ews_weight_downtrend_3'] || $row['status_label'] !== 'Stabil')->values(),
            'severeCoughTodayCount' => $this->countSevereCoughToday($monitoringRows),
            'filters' => [
                'tanggal_mulai' => $request->input('tanggal_mulai'),
                'tanggal_selesai' => $request->input('tanggal_selesai'),
                'gejala' => $request->input('gejala'),
            ],
        ]);
    }

    public function dataPengguna()
    {
        $users = User::all();
        return view('data_pengguna', compact('users'));
    }

    public function showDataPasien(Request $request)
    {
        return $this->index($request);
    }

    public function adminDashboard(Request $request)
    {
        $users = User::query()
            ->where('role', 'pengguna')
            ->with(['checkHarians' => function ($query) {
                $query->orderByDesc('tanggal')->orderByDesc('id');
            }, 'skriningKontaks' => function ($query) {
                $query->latest();
            }])
            ->get()
            ->map(function (User $user) {
                return $this->buildMonitoringRow($user);
            });

        $summary = $this->buildSummary($users);
        $ewsAlerts = $users->filter(fn (array $row) => $row['ews_overdue_48h'] || $row['ews_weight_downtrend_3'] || $row['status_label'] === 'Kritis / Masuk EWS')->values();
        $severeCoughTodayCount = $this->countSevereCoughToday($users);

        return view('dashboard_admin', [
            'users' => $users,
            'monitoringRows' => $users,
            'summary' => $summary,
            'ewsAlerts' => $ewsAlerts,
            'severeCoughTodayCount' => $severeCoughTodayCount,
        ]);
    }

    public function showDetailPasien($id)
    {
        $user = User::with(['checkHarians' => function ($query) {
            $query->orderByDesc('tanggal')->orderByDesc('id');
        }, 'skriningKontaks' => function ($query) {
            $query->latest();
        }])->findOrFail($id);

        $patientData = $this->buildMonitoringRow($user);

        return view('detail_pasien', [
            'user' => $patientData,
        ]);
    }

    public function downloadPdf($userId)
    {
        $user = User::with(['checkHarians' => function ($query) {
            $query->orderByDesc('tanggal')->orderByDesc('id');
        }])->findOrFail($userId);

        $pdf = Pdf::loadView('pdf.datapasien', [
            'user' => $this->buildMonitoringRow($user),
        ]);

        return $pdf->download('data_pasien_' . $user->username . '.pdf');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username',
            'usia' => 'required|integer|min:0',
            'gender' => 'required|in:Laki-laki,Perempuan,Lainnya',
            'nomor_wa_pasien' => 'required|string|max:20',
            'nomor_wa_pmo' => 'required|string|max:20',
            'riwayat_penyakit' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $password = $validated['password'] ?? $validated['username'];

        User::create([
            'name' => $validated['name'],
            'first_name' => $validated['name'],
            'last_name' => '',
            'email' => $validated['email'],
            'username' => $validated['username'],
            'usia' => $validated['usia'],
            'gender' => $validated['gender'],
            'jenis_kelamin' => $validated['gender'],
            'nomor_wa_pasien' => $validated['nomor_wa_pasien'],
            'nomor_wa_pmo' => $validated['nomor_wa_pmo'],
            'riwayat_penyakit' => $validated['riwayat_penyakit'] ?? '',
            'address' => $validated['address'] ?? '',
            'role' => 'pengguna',
            'password' => \Illuminate\Support\Facades\Hash::make($password),
        ]);

        return redirect()->route('datapasien')->with('success', 'Data pasien baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'usia' => 'required|integer|min:0',
            'gender' => 'required|in:Laki-laki,Perempuan,Lainnya',
            'nomor_wa_pasien' => 'required|string|max:20',
            'nomor_wa_pmo' => 'required|string|max:20',
            'riwayat_penyakit' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $validated['name'],
            'first_name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'usia' => $validated['usia'],
            'gender' => $validated['gender'],
            'jenis_kelamin' => $validated['gender'],
            'nomor_wa_pasien' => $validated['nomor_wa_pasien'],
            'nomor_wa_pmo' => $validated['nomor_wa_pmo'],
            'riwayat_penyakit' => $validated['riwayat_penyakit'] ?? '',
            'address' => $validated['address'] ?? '',
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('datapasien')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        $user->checkHarians()->delete();
        $user->skriningKontaks()->delete();
        $user->delete();

        return redirect()->route('datapasien')->with('success', 'Data pasien berhasil dihapus.');
    }

    public function exportCsv()
    {
        $users = User::where('role', 'pengguna')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="data_pasien_' . date('Ymd_His') . '.csv"',
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'ID', 'Nama', 'Username', 'Email', 'Gender', 'Usia', 
                'WA Pasien', 'WA PMO', 'Riwayat Penyakit', 'Alamat', 
                'Streak Kepatuhan', 'Rekor Kepatuhan'
            ]);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name ?? trim($user->first_name . ' ' . $user->last_name),
                    $user->username,
                    $user->email,
                    $user->gender ?? $user->jenis_kelamin,
                    $user->usia,
                    $user->nomor_wa_pasien,
                    $user->nomor_wa_pmo,
                    $user->riwayat_penyakit,
                    $user->address,
                    $user->current_streak ?? 0,
                    $user->highest_streak ?? 0,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportAllPdf()
    {
        $users = User::where('role', 'pengguna')
            ->with(['checkHarians' => function ($query) {
                $query->orderByDesc('tanggal')->orderByDesc('id');
            }])
            ->get()
            ->map(function (User $user) {
                return $this->buildMonitoringRow($user);
            });

        $pdf = Pdf::loadView('pdf.allpasien', [
            'users' => $users,
            'summary' => $this->buildSummary($users),
            'export_date' => Carbon::now('Asia/Jakarta')->format('d F Y H:i'),
        ]);

        return $pdf->download('data_seluruh_pasien_' . date('Ymd_His') . '.pdf');
    }



    public function kirimPengingat($id)
    {
        $patient = User::findOrFail($id);
        $phone = $patient->nomor_wa_pmo ?? '08998995841';

        // Format phone: remove non-digits, replace leading 0 with 62
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (strpos($cleanPhone, '0') === 0) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $message = "Halo PMO dari {$patient->name}, mohon ingatkan pasien untuk meminum obat hari ini dan mengisi checklist harian di TBC Care karena hingga pukul 21:00 belum mengisi laporan harian.";
        $url = "https://wa.me/{$cleanPhone}?text=" . urlencode($message);

        return redirect()->away($url);
    }

    private function buildMonitoringRow(User $user): array
    {
        $checkHarians = $user->checkHarians->sortByDesc(function ($checkHarian) {
            return Carbon::parse($checkHarian->tanggal)->timestamp;
        })->values();

        $latestCheck = $checkHarians->first();
        $latestCheckDate = $latestCheck ? Carbon::parse($latestCheck->tanggal) : null;
        $hoursSinceLastInput = $latestCheckDate ? $latestCheckDate->diffInHours(now()) : null;
        $ewsOverdue48h = $hoursSinceLastInput !== null && $hoursSinceLastInput > 48;
        $ewsWeightDowntrend3 = $this->hasDowntrendWeight($checkHarians);
        $severeCoughToday = $this->hasSevereCoughToday($checkHarians);

        return [
            'id' => $user->id,
            'username' => $user->username,
            'name' => $user->name ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')),
            'gender' => $user->gender ?? $user->jenis_kelamin,
            'usia' => $user->usia,
            'nomor_wa_pasien' => $user->nomor_wa_pasien,
            'nomor_wa_pmo' => $user->nomor_wa_pmo,
            'riwayat_penyakit' => $user->riwayat_penyakit ?? '-',
            'address' => $user->address ?? '-',
            'current_streak' => $user->current_streak ?? 0,
            'highest_streak' => $user->highest_streak ?? 0,
            'check_harians' => $checkHarians,
            'latest_check' => $latestCheck,
            'latest_check_date' => $latestCheckDate,
            'hours_since_last_input' => $hoursSinceLastInput,
            'ews_overdue_48h' => $ewsOverdue48h,
            'ews_weight_downtrend_3' => $ewsWeightDowntrend3,
            'severe_cough_today' => $severeCoughToday,
            'status_label' => $this->resolveStatusLabel($latestCheck, $ewsOverdue48h, $ewsWeightDowntrend3, $hoursSinceLastInput),
            'risk_flags' => $this->resolveRiskFlags($latestCheck, $ewsOverdue48h, $ewsWeightDowntrend3, $severeCoughToday),
            'last_weight' => $this->extractWeight($latestCheck),
            'last_temperature' => $this->extractTemperature($latestCheck),
            'last_follow_up' => $latestCheckDate ? $latestCheckDate->format('Y-m-d H:i:s') : null,
            'skrining_kontaks' => $user->skriningKontaks
                ->map(function ($kontak) {
                    return [
                        'nama_anggota_keluarga' => $kontak->nama_anggota_keluarga,
                        'status_gejala' => (bool) $kontak->status_gejala,
                        'rekomendasi_tindakan' => $kontak->rekomendasi_tindakan,
                        'created_at' => optional($kontak->created_at)->format('d M Y H:i'),
                    ];
                })
                ->values(),
        ];
    }

    private function applyOptionalFilters($rows, Request $request)
    {
        $filtered = $rows;

        if ($request->filled('tanggal_mulai')) {
            $tanggalMulai = Carbon::parse($request->input('tanggal_mulai'))->startOfDay();
            $filtered = $filtered->filter(function (array $row) use ($tanggalMulai) {
                return $row['latest_check_date'] && $row['latest_check_date']->greaterThanOrEqualTo($tanggalMulai);
            });
        }

        if ($request->filled('tanggal_selesai')) {
            $tanggalSelesai = Carbon::parse($request->input('tanggal_selesai'))->endOfDay();
            $filtered = $filtered->filter(function (array $row) use ($tanggalSelesai) {
                return $row['latest_check_date'] && $row['latest_check_date']->lessThanOrEqualTo($tanggalSelesai);
            });
        }

        if ($request->filled('gejala')) {
            $gejala = strtolower(trim($request->input('gejala')));
            $filtered = $filtered->filter(function (array $row) use ($gejala) {
                switch ($gejala) {
                    case 'demam':
                        return ($row['latest_temperature'] !== null) && $row['latest_temperature'] > 38;
                    case 'batuk_parah':
                        return $row['severe_cough_today'];
                    case 'ews':
                        return $row['ews_overdue_48h'] || $row['ews_weight_downtrend_3'];
                    default:
                        return true;
                }
            });
        }

        return $filtered->values();
    }

    private function buildSummary($rows): array
    {
        return [
            'total_pasien_aktif' => $rows->count(),
            'pasien_ews_terlambat' => $rows->where('ews_overdue_48h', true)->count(),
            'pasien_ews_tren_memburuk' => $rows->where('ews_weight_downtrend_3', true)->count(),
            'pasien_batuk_parah_hari_ini' => $this->countSevereCoughToday($rows),
            'pasien_status_stabil' => $rows->where('status_label', 'Patuh')->count(),
        ];
    }

    private function emptySummary(): array
    {
        return [
            'total_pasien_aktif' => 0,
            'pasien_ews_terlambat' => 0,
            'pasien_ews_tren_memburuk' => 0,
            'pasien_batuk_parah_hari_ini' => 0,
            'pasien_status_stabil' => 0,
        ];
    }

    private function countSevereCoughToday($rows): int
    {
        return $rows->filter(function (array $row) {
            return $row['severe_cough_today'];
        })->count();
    }

    private function hasSevereCoughToday($checkHarians): bool
    {
        $today = now()->toDateString();

        return $checkHarians->contains(function ($checkHarian) use ($today) {
            if (Carbon::parse($checkHarian->tanggal)->toDateString() !== $today) {
                return false;
            }

            return (int) ($checkHarian->frekuensi_batuk ?? 0) >= 7;
        });
    }

    private function hasDowntrendWeight($checkHarians): bool
    {
        $latestThree = $checkHarians->take(3)->values();

        if ($latestThree->count() < 3) {
            return false;
        }

        $weights = $latestThree->map(function ($checkHarian) {
            return $this->extractWeight($checkHarian);
        })->filter(fn ($value) => $value !== null)->values();

        if ($weights->count() < 3) {
            return false;
        }

        return $weights[0] > $weights[1] && $weights[1] > $weights[2];
    }

    private function extractWeight($checkHarian): ?float
    {
        if (! $checkHarian) {
            return null;
        }

        $value = $checkHarian->berat_badan ?? $checkHarian->berat ?? null;

        return is_numeric($value) ? (float) $value : null;
    }

    private function extractTemperature($checkHarian): ?float
    {
        if (! $checkHarian) {
            return null;
        }

        $value = $checkHarian->suhu_tubuh ?? $checkHarian->suhu ?? null;

        return is_numeric($value) ? (float) $value : null;
    }

    private function resolveStatusLabel($latestCheck, bool $ewsOverdue48h, bool $ewsWeightDowntrend3, $hoursSinceLastInput): string
    {
        if (! $latestCheck || ($hoursSinceLastInput !== null && $hoursSinceLastInput > 336)) {
            return 'Drop Out';
        }

        if ($ewsOverdue48h || $ewsWeightDowntrend3) {
            return 'Kritis / Masuk EWS';
        }

        $temperature = $this->extractTemperature($latestCheck);
        if ($temperature !== null && $temperature > 38) {
            return 'Kritis / Masuk EWS';
        }

        return 'Patuh';
    }

    private function resolveRiskFlags($latestCheck, bool $ewsOverdue48h, bool $ewsWeightDowntrend3, bool $severeCoughToday): array
    {
        $flags = [];

        if ($ewsOverdue48h) {
            $flags[] = 'Tidak input > 48 jam';
        }

        if ($ewsWeightDowntrend3) {
            $flags[] = 'Berat badan menurun 3 input terakhir';
        }

        if ($severeCoughToday) {
            $flags[] = 'Batuk parah hari ini';
        }

        $temperature = $this->extractTemperature($latestCheck);
        if ($temperature !== null && $temperature > 38) {
            $flags[] = 'Demam';
        }

        return $flags;
    }
}
