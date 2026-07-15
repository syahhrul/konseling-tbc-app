<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Minishlink\WebPush\Vapid;
use Illuminate\Support\Facades\File;

class WebPushGenerateKeysCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webpush:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate VAPID keys for Web Push Notifications';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generating VAPID keys...');

        // Pastikan kelas Vapid tersedia
        if (!class_exists('Minishlink\WebPush\Vapid')) {
            $this->error('Package minishlink/web-push tidak ditemukan. Silakan jalankan composer install terlebih dahulu.');
            return 1;
        }

        try {
            $keys = Vapid::createVapidKeys();
            $publicKey = $keys['publicKey'];
            $privateKey = $keys['privateKey'];
        } catch (\Exception $e) {
            $this->warn('Artisan tidak dapat menggunakan OpenSSL lokal untuk membuat VAPID key secara dinamis.');
            $this->warn('Menggunakan pasangan VAPID key demo (default fallback) agar demo tetap berjalan lancar...');
            $publicKey = 'BLEvwbQgAjaHjmXcJgpAmOpFCuR-m_BKJWhskZmbFYAQABA4ZrpLQ1UnNJVH_Zbmzjugmmts2I5kLt8wMKQlIME';
            $privateKey = 'cSTj1YJCOQGP-J6QLCr3gSkU2OPs39Dx3FtiBc6ZOYI';
        }

        $this->info('Public Key: ' . $publicKey);
        $this->info('Private Key: ' . $privateKey);

        // Tulis ke file .env
        $envPath = base_path('.env');
        if (File::exists($envPath)) {
            $envContent = File::get($envPath);

            // Replace atau append VAPID_PUBLIC_KEY
            if (str_contains($envContent, 'VAPID_PUBLIC_KEY=')) {
                $envContent = preg_replace('/VAPID_PUBLIC_KEY=.*/', 'VAPID_PUBLIC_KEY=' . $publicKey, $envContent);
            } else {
                $envContent .= "\nVAPID_PUBLIC_KEY=" . $publicKey;
            }

            // Replace atau append VAPID_PRIVATE_KEY
            if (str_contains($envContent, 'VAPID_PRIVATE_KEY=')) {
                $envContent = preg_replace('/VAPID_PRIVATE_KEY=.*/', 'VAPID_PRIVATE_KEY=' . $privateKey, $envContent);
            } else {
                $envContent .= "\nVAPID_PRIVATE_KEY=" . $privateKey;
            }

            File::put($envPath, $envContent);
            $this->info('VAPID keys berhasil disimpan ke dalam file .env!');
        } else {
            $this->warn('File .env tidak ditemukan. Silakan salin key di atas secara manual.');
        }

        return 0;
    }
}
