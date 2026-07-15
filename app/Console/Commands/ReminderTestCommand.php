<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReminderTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulasi pengiriman pengingat minum obat TBC Care via WhatsApp / Email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("====================================================");
        $this->info("SIMULASI SISTEM PENGINGAT TBC CARE (DEMO MPTI)");
        $this->info("Waktu Pemeriksaan: Jam 21:00 WIB (Simulasi)");
        $this->info("Kriteria EWS: Pasien aktif yang belum melapor hari ini.");
        $this->info("====================================================");

        // Ambil semua pasien aktif
        $patients = User::where('role', 'pengguna')->get();
        $today = Carbon::now()->toDateString();
        
        $sentCount = 0;
        $demoPhone = '08998995841';

        foreach ($patients as $patient) {
            // Periksa apakah pasien sudah melapor hari ini
            $hasInputToday = $patient->checkHarians()->whereDate('tanggal', $today)->exists();

            if (!$hasInputToday) {
                $this->warn("⚠️ ALERT: Pasien '{$patient->name}' belum melapor hari ini!");
                
                // Kirim simulasi pengingat WA
                $this->info("   📲 [Simulasi WA Pasien] Kirim ke: {$demoPhone} (Demo User - Pasien)");
                $this->info("      Pesan: \"Halo {$patient->name}, jangan lupa meminum obat TBC Anda hari ini dan laporkan kondisinya di aplikasi TBC Care ya! Jaga kesehatan.\"");
                
                $this->info("   📲 [Simulasi WA PMO/Orang Terdekat] Kirim ke: {$demoPhone} (Demo User - PMO)");
                $this->info("      Pesan: \"Halo Pengawas Obat dari {$patient->name}, mohon ingatkan pasien untuk meminum obat TBC hari ini dan mengisi checklist harian.\"");
                
                // Kirim Notifikasi Browser (Web Push)
                $subscriptions = \App\Models\PushSubscription::where('user_id', $patient->id)->get();
                if ($subscriptions->isNotEmpty()) {
                    $vapidSubject = config('webpush.vapid.subject', 'mailto:dev@tbccare.com');
                    $vapidPublicKey = config('webpush.vapid.public_key');
                    $vapidPrivateKey = config('webpush.vapid.private_key');

                    if ($vapidPublicKey && $vapidPrivateKey) {
                        try {
                            $webPush = new \Minishlink\WebPush\WebPush([
                                'VAPID' => [
                                    'subject' => $vapidSubject,
                                    'publicKey' => $vapidPublicKey,
                                    'privateKey' => $vapidPrivateKey,
                                ],
                            ]);

                            $payload = json_encode([
                                'title' => 'Pengingat Minum Obat TBC Care',
                                'body' => "Halo {$patient->name}, jangan lupa meminum obat TBC Anda hari ini dan laporkan kondisinya di aplikasi TBC Care ya! Jaga kesehatan.",
                                'url' => url('/dashboard'),
                                'icon' => url('/favicon.ico'),
                            ]);

                            foreach ($subscriptions as $sub) {
                                $webPush->queueNotification(
                                    \Minishlink\WebPush\Subscription::create([
                                        'endpoint' => $sub->endpoint,
                                        'publicKey' => $sub->p256dh,
                                        'authToken' => $sub->auth,
                                    ]),
                                    $payload
                                );
                            }

                            $results = $webPush->flush();
                            foreach ($results as $report) {
                                if (!$report->isSuccess()) {
                                    \App\Models\PushSubscription::where('endpoint', $report->getEndpoint())->delete();
                                }
                            }
                            $this->info("   🔔 [WebPush] Berhasil mengirimkan browser notification ke pasien '{$patient->name}'.");
                        } catch (\Exception $e) {
                            $this->error("   ❌ [WebPush] Gagal mengirim: " . $e->getMessage());
                        }
                    } else {
                        $this->warn("   ⚠️ [WebPush] VAPID keys belum di-generate. Lewati pengiriman push browser.");
                    }
                } else {
                    $this->info("   ℹ️ [WebPush] Pasien '{$patient->name}' belum mendaftarkan browser untuk notifikasi push.");
                }

                Log::info("MPTI DEMO: Reminder sent successfully to demo phone {$demoPhone} for patient {$patient->username} and PMO.");
                $sentCount++;
            } else {
                $this->info("✅ Pasien '{$patient->name}' sudah melapor hari ini. (Status: Aman)");
            }
        }

        $this->info("====================================================");
        $this->info("Simulasi selesai. Total pengingat dikirim: {$sentCount} pasien.");
        $this->info("====================================================");
        
        return 0;
    }
}
