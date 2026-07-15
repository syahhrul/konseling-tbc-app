<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PushSubscription;
use App\Models\User;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PushNotificationController extends Controller
{
    /**
     * Store push subscription details for a patient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|url',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        $user = Auth::user();

        // Update or create subscription
        PushSubscription::updateOrCreate(
            [
                'user_id' => $user->id,
                'endpoint' => $request->endpoint,
            ],
            [
                'p256dh' => $request->input('keys.p256dh'),
                'auth' => $request->input('keys.auth'),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Subscription push browser berhasil disimpan.',
        ]);
    }

    /**
     * Send instant Web Push Notification for demo trigger.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function triggerDemoNotification($userId)
    {
        $patient = User::findOrFail($userId);
        $subscriptions = PushSubscription::where('user_id', $patient->id)->get();

        if ($subscriptions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal: Pasien belum mengaktifkan izin notifikasi di peramban (browser) mereka.'
            ], 400);
        }

        $vapidSubject = config('webpush.vapid.subject', 'mailto:dev@tbccare.com');
        $vapidPublicKey = config('webpush.vapid.public_key');
        $vapidPrivateKey = config('webpush.vapid.private_key');

        if (!$vapidPublicKey || !$vapidPrivateKey) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal: VAPID keys belum dikonfigurasi. Jalankan command: php artisan webpush:generate'
            ], 500);
        }

        $auth = [
            'VAPID' => [
                'subject' => $vapidSubject,
                'publicKey' => $vapidPublicKey,
                'privateKey' => $vapidPrivateKey,
            ],
        ];

        try {
            $webPush = new WebPush($auth);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menginisialisasi Web Push client: ' . $e->getMessage()
            ], 500);
        }

        $payload = json_encode([
            'title' => 'Pengingat Minum Obat TBC Care',
            'body' => "Halo {$patient->name}, jangan lupa meminum obat TBC Anda hari ini dan laporkan kondisinya di aplikasi TBC Care ya! Jaga kesehatan.",
            'url' => url('/dashboard'),
            'icon' => url('/favicon.ico'),
        ]);

        foreach ($subscriptions as $sub) {
            try {
                $webPush->queueNotification(
                    Subscription::create([
                        'endpoint' => $sub->endpoint,
                        'publicKey' => $sub->p256dh,
                        'authToken' => $sub->auth,
                    ]),
                    $payload
                );
            } catch (\Exception $e) {
                Log::error("WebPush queue failed: " . $e->getMessage());
            }
        }

        $success = false;
        try {
            $results = $webPush->flush();
            foreach ($results as $report) {
                $endpoint = $report->getEndpoint();
                if ($report->isSuccess()) {
                    Log::info("[WebPush] Sent successfully to {$endpoint}");
                    $success = true;
                } else {
                    Log::error("[WebPush] Failed for {$endpoint}: {$report->getReason()}");
                    // Hapus subscription yang sudah invalid/expired
                    PushSubscription::where('endpoint', $endpoint)->delete();
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirimkan push: ' . $e->getMessage()
            ], 500);
        }

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi real-time berhasil dikirim langsung ke peramban (browser) pasien!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Koneksi ditolak oleh push service browser.'
        ], 500);
    }
}
