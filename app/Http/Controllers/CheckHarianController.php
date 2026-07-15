<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CheckHarian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // Pastikan Carbon di-import

class CheckHarianController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $this->triggerPmoReminderIfNeeded($user);

        $checkHarianQuery = $user->checkHarians()->orderByDesc('tanggal')->orderByDesc('id');
        $this->applyIndexFilters($checkHarianQuery, $request);

        $checkHarians = $checkHarianQuery->get();

        $totalUniqueDays = $checkHarians->pluck('tanggal')->unique()->count();
        $compliantDays = $checkHarians->filter(function ($checkHarian) {
            if (! is_null($checkHarian->status_minum_obat)) {
                return (bool) $checkHarian->status_minum_obat;
            }

            return $checkHarian->minum_obat === 'Ya';
        })->count();

        $totalTreatmentDuration = 180; // 6 Bulan (Fase Intensif 2 bulan + Fase Lanjutan 4 bulan)

        $compliancePercentage = ($totalUniqueDays > 0)
            ? ($compliantDays / $totalUniqueDays) * 100
            : 0;

        $age = Carbon::parse($user->birth_date)->age;

        $rekamMedis = 'RM' . str_pad($user->id, 3, '0', STR_PAD_LEFT);

        $jadwalKontrol = 'Belum Tersedia';
        if ($checkHarians->isNotEmpty()) {
            $tanggalPertama = $checkHarians->min('tanggal');
            $jadwalKontrol = Carbon::parse($tanggalPertama)->addDays($totalTreatmentDuration)->format('d F Y');
        }

        return view('output_pasien', [
            'user' => $user,
            'checkHarian' => $checkHarians,
            'age' => $age,
            'rekamMedis' => $rekamMedis,
            'totalUniqueDays' => $totalUniqueDays,
            'compliantDays' => $compliantDays,
            'totalTreatmentDuration' => $totalTreatmentDuration,
            'compliancePercentage' => $compliancePercentage,
            'jadwalKontrol' => $jadwalKontrol,
            'filters' => [
                'tanggal_mulai' => $request->input('tanggal_mulai'),
                'tanggal_selesai' => $request->input('tanggal_selesai'),
                'gejala' => $request->input('gejala'),
            ],
        ]);
    }

    public function create()
    {
        return view('checkharian');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'suhu_tubuh' => 'nullable|numeric|required_without:suhu',
            'suhu' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric|min:0|required_without:berat',
            'berat' => 'nullable|numeric|min:0',
            'nafsu_makan' => 'nullable|string|in:Baik,Normal,Menurun',
            'status_minum_obat' => 'nullable|boolean',
            'minum_obat' => 'nullable|string|in:Ya,Tidak',
            'alasan_tidak_minum' => 'nullable|string',
            'frekuensi_batuk' => 'nullable|integer|min:0',
            'berkeringat_malam' => 'nullable|boolean',
            'catatan_bebas' => 'nullable|string',
            'catatan_pete' => 'nullable|string',
        ]);

        $suhuTubuh = $validated['suhu_tubuh'] ?? $validated['suhu'] ?? null;
        $beratBadan = $validated['berat_badan'] ?? $validated['berat'] ?? null;
        $catatanBebas = $validated['catatan_bebas'] ?? $validated['catatan_pete'] ?? null;
        $statusMinumObat = null;
        if (array_key_exists('status_minum_obat', $validated) && $validated['status_minum_obat'] !== null) {
            $statusMinumObat = (bool) $validated['status_minum_obat'];
        } elseif (array_key_exists('minum_obat', $validated) && $validated['minum_obat'] !== null) {
            $statusMinumObat = $validated['minum_obat'] === 'Ya';
        }
        $alasanTidakMinum = $validated['alasan_tidak_minum'] ?? null;
        $frekuensiBatuk = $validated['frekuensi_batuk'] ?? null;
        $berkeringatMalam = array_key_exists('berkeringat_malam', $validated)
            ? (bool) $validated['berkeringat_malam']
            : null;

        if (($suhuTubuh !== null) && ((float) $suhuTubuh > 38)) {
            Log::info('Deteksi klinis otomatis: demam terdeteksi pada check harian pasien.', [
                'user_id' => Auth::id(),
                'tanggal' => $validated['tanggal'],
                'suhu_tubuh' => $suhuTubuh,
                'indikasi' => 'Demam',
            ]);
        }

        $checkHarian = CheckHarian::create([
            'user_id' => Auth::id(),
            'tanggal' => $validated['tanggal'],
            'suhu' => $suhuTubuh,
            'suhu_tubuh' => $suhuTubuh,
            'berat' => $beratBadan,
            'berat_badan' => $beratBadan,
            'nafsu_makan' => $validated['nafsu_makan'] ?? null,
            'minum_obat' => $validated['minum_obat'] ?? null,
            'status_minum_obat' => $statusMinumObat,
            'alasan_tidak_minum' => $alasanTidakMinum,
            'frekuensi_batuk' => $frekuensiBatuk,
            'berkeringat_malam' => $berkeringatMalam,
            'catatan_pete' => $catatanBebas ?? '',
            'catatan_bebas' => $catatanBebas,
        ]);

        if ($statusMinumObat !== null) {
            $this->syncStreakAndReminder(Auth::user(), Carbon::parse($validated['tanggal'])->startOfDay(), $statusMinumObat);
        } else {
            $this->triggerPmoReminderIfNeeded(Auth::user());
        }

        return redirect()->route('checkharian')->with('success', 'Data check harian berhasil disimpan.');
    }

    private function syncStreakAndReminder(User $user, Carbon $submittedDate, bool $statusMinumObat): void
    {
        if (! $statusMinumObat) {
            $user->current_streak = 0;
            $user->pmo_notified = false;
            $user->save();
            return;
        }

        $previousCheck = $user->checkHarians()
            ->whereDate('tanggal', '<', $submittedDate->toDateString())
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->first();

        $previousDate = $previousCheck ? Carbon::parse($previousCheck->tanggal)->startOfDay() : null;
        $previousStatus = $previousCheck ? (bool) ($previousCheck->status_minum_obat ?? ($previousCheck->minum_obat === 'Ya')) : false;

        if ($previousDate && $previousDate->equalTo($submittedDate->copy()->subDay()) && $previousStatus) {
            $user->current_streak = (int) $user->current_streak + 1;
        } else {
            $user->current_streak = 1;
        }

        $user->highest_streak = max((int) $user->highest_streak, (int) $user->current_streak);
        $user->pmo_notified = false;
        $user->save();
    }

    private function triggerPmoReminderIfNeeded(User $user): void
    {
        $nowWib = Carbon::now('Asia/Jakarta');
        $today = $nowWib->toDateString();
        $todayCheck = $user->checkHarians()
            ->whereDate('tanggal', $today)
            ->orderByDesc('id')
            ->first();

        $hasRecordedStatus = $todayCheck && (
            ! is_null($todayCheck->status_minum_obat) || ! is_null($todayCheck->minum_obat)
        );

        if ($nowWib->hour < 21 || $hasRecordedStatus || $user->pmo_notified) {
            return;
        }

        if (! $user->nomor_wa_pmo) {
            Log::warning('PMO reminder skipped because nomor_wa_pmo is empty.', [
                'user_id' => $user->id,
                'tanggal' => $today,
            ]);

            return;
        }

        $message = 'Pengingat: pasien belum mengisi status minum obat hari ini. Mohon lakukan follow-up segera.';

        Log::info('Simulasi webhook PMO WhatsApp trigger.', [
            'user_id' => $user->id,
            'nomor_wa_pmo' => $user->nomor_wa_pmo,
            'pesan' => $message,
            'tanggal' => $today,
        ]);

        $user->pmo_notified = true;
        $user->save();
    }

    private function applyIndexFilters($query, Request $request): void
    {
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', Carbon::parse($request->input('tanggal_mulai'))->toDateString());
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', Carbon::parse($request->input('tanggal_selesai'))->toDateString());
        }

        if (! $request->filled('gejala')) {
            return;
        }

        $gejala = strtolower(trim($request->input('gejala')));

        $query->where(function ($builder) use ($gejala) {
            switch ($gejala) {
                case 'demam':
                    $builder->where('suhu_tubuh', '>', 38)
                        ->orWhere('suhu', '>', 38);
                    break;
                case 'batuk':
                    $builder->where(function ($innerBuilder) {
                        $innerBuilder->whereNotNull('frekuensi_batuk')
                            ->where('frekuensi_batuk', '>', 0);
                    });
                    break;
                case 'berkeringat_malam':
                    $builder->where('berkeringat_malam', true);
                    break;
                case 'tidak_minum_obat':
                    $builder->where(function ($innerBuilder) {
                        $innerBuilder->where('status_minum_obat', false)
                            ->orWhere('minum_obat', 'Tidak');
                    });
                    break;
            }
        });
    }
}