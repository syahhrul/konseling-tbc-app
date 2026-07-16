<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CheckHarian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        CheckHarian::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Akun Perawat / Admin
        User::create([
            'name' => 'Perawat TBC Care',
            'first_name' => 'Perawat',
            'last_name' => 'TBC Care',
            'username' => 'admin',
            'email' => 'admin@tbccare.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'gender' => 'Perempuan',
            'jenis_kelamin' => 'Perempuan',
            'usia' => 30,
            'birth_date' => '1996-01-01',
            'phone' => '08998995841',
            'nomor_wa_pasien' => '08998995841',
            'nomor_wa_pmo' => '08998995841',
            'riwayat_penyakit' => 'Tidak ada',
            'address' => 'Puskesmas',
            'current_streak' => 0,
            'highest_streak' => 0,
        ]);

        // 2. Akun Pasien A (Patuh, 5 hari streak)
        $pasienA = User::create([
            'name' => 'Pasien Patuh A',
            'first_name' => 'Pasien',
            'last_name' => 'Patuh A',
            'username' => 'pasiena',
            'email' => 'pasiena@gmail.com',
            'role' => 'pengguna',
            'password' => Hash::make('pasien123'),
            'gender' => 'Laki-laki',
            'jenis_kelamin' => 'Laki-laki',
            'usia' => 25,
            'birth_date' => '2001-05-15',
            'phone' => '08998995841',
            'nomor_wa_pasien' => '08998995841',
            'nomor_wa_pmo' => '08998995841',
            'riwayat_penyakit' => 'Asma',
            'address' => 'Yogyakarta',
            'current_streak' => 5,
            'highest_streak' => 5,
        ]);

        // Buat 5 hari lapor berturut-turut untuk Pasien A
        for ($i = 4; $i >= 0; $i--) {
            CheckHarian::create([
                'user_id' => $pasienA->id,
                'tanggal' => Carbon::now()->subDays($i)->toDateString(),
                'suhu' => 36.5,
                'suhu_tubuh' => 36.5,
                'berat' => 60.0,
                'berat_badan' => 60.0,
                'nafsu_makan' => 'Baik',
                'minum_obat' => 'Ya',
                'status_minum_obat' => true,
                'alasan_tidak_minum' => null,
                'frekuensi_batuk' => 2,
                'berkeringat_malam' => false,
                'catatan_pete' => 'Meminum obat teratur',
                'catatan_bebas' => 'Meminum obat teratur',
            ]);
        }

        // 3. Akun Pasien B (Kritis, belum lapor > 48 jam)
        $pasienB = User::create([
            'name' => 'Pasien Kritis B',
            'first_name' => 'Pasien',
            'last_name' => 'Kritis B',
            'username' => 'pasienb',
            'email' => 'pasienb@gmail.com',
            'role' => 'pengguna',
            'password' => Hash::make('pasien123'),
            'gender' => 'Perempuan',
            'jenis_kelamin' => 'Perempuan',
            'usia' => 34,
            'birth_date' => '1992-10-20',
            'phone' => '08998995841',
            'nomor_wa_pasien' => '08998995841',
            'nomor_wa_pmo' => '08998995841',
            'riwayat_penyakit' => 'Diabetes',
            'address' => 'Bantul',
            'current_streak' => 0,
            'highest_streak' => 2,
        ]);

        // Buat lapor terakhir 3 hari yang lalu (lebih dari 48 jam yang lalu)
        CheckHarian::create([
            'user_id' => $pasienB->id,
            'tanggal' => Carbon::now()->subDays(5)->toDateString(),
            'suhu' => 37.2,
            'suhu_tubuh' => 37.2,
            'berat' => 56.5,
            'berat_badan' => 56.5,
            'nafsu_makan' => 'Normal',
            'minum_obat' => 'Ya',
            'status_minum_obat' => true,
            'alasan_tidak_minum' => null,
            'frekuensi_batuk' => 5,
            'berkeringat_malam' => true,
            'catatan_pete' => 'Batuk agak parah',
            'catatan_bebas' => 'Batuk agak parah',
        ]);

        CheckHarian::create([
            'user_id' => $pasienB->id,
            'tanggal' => Carbon::now()->subDays(3)->toDateString(),
            'suhu' => 37.5,
            'suhu_tubuh' => 37.5,
            'berat' => 55.0, // Mengalami penurunan berat badan
            'berat_badan' => 55.0,
            'nafsu_makan' => 'Menurun',
            'minum_obat' => 'Ya',
            'status_minum_obat' => true,
            'alasan_tidak_minum' => null,
            'frekuensi_batuk' => 7,
            'berkeringat_malam' => true,
            'catatan_pete' => 'Batuk makin berat, belum lapor lagi',
            'catatan_bebas' => 'Batuk makin berat, belum lapor lagi',
        ]);

        // 4. Akun Pasien C (Demo lapor harian kosong)
        User::create([
            'name' => 'Pasien Baru C',
            'first_name' => 'Pasien',
            'last_name' => 'Baru C',
            'username' => 'pasienc',
            'email' => 'pasienc@gmail.com',
            'role' => 'pengguna',
            'password' => Hash::make('pasien123'),
            'gender' => 'Laki-laki',
            'jenis_kelamin' => 'Laki-laki',
            'usia' => 22,
            'birth_date' => '2004-02-10',
            'phone' => '08998995841',
            'nomor_wa_pasien' => '08998995841',
            'nomor_wa_pmo' => '08998995841',
            'riwayat_penyakit' => 'Tidak ada',
            'address' => 'Sleman',
            'current_streak' => 0,
            'highest_streak' => 0,
        ]);

        // 5. Akun Pasien D (Demo lapor harian kosong)
        User::create([
            'name' => 'Pasien Baru D',
            'first_name' => 'Pasien',
            'last_name' => 'Baru D',
            'username' => 'pasiend',
            'email' => 'pasiend@gmail.com',
            'role' => 'pengguna',
            'password' => Hash::make('pasien123'),
            'gender' => 'Perempuan',
            'jenis_kelamin' => 'Perempuan',
            'usia' => 23,
            'birth_date' => '2003-08-12',
            'phone' => '08998995841',
            'nomor_wa_pasien' => '08998995841',
            'nomor_wa_pmo' => '08998995841',
            'riwayat_penyakit' => 'Tidak ada',
            'address' => 'Bantul',
            'current_streak' => 0,
            'highest_streak' => 0,
        ]);

        // 6. Akun Pasien E (Demo lapor harian kosong)
        User::create([
            'name' => 'Pasien Baru E',
            'first_name' => 'Pasien',
            'last_name' => 'Baru E',
            'username' => 'pasiene',
            'email' => 'pasiene@gmail.com',
            'role' => 'pengguna',
            'password' => Hash::make('pasien123'),
            'gender' => 'Laki-laki',
            'jenis_kelamin' => 'Laki-laki',
            'usia' => 24,
            'birth_date' => '2002-12-05',
            'phone' => '08998995841',
            'nomor_wa_pasien' => '08998995841',
            'nomor_wa_pmo' => '08998995841',
            'riwayat_penyakit' => 'Tidak ada',
            'address' => 'Yogyakarta',
            'current_streak' => 0,
            'highest_streak' => 0,
        ]);

        // 7. Akun Perawat Cadangan
        User::create([
            'name' => 'Perawat Cadangan',
            'first_name' => 'Perawat',
            'last_name' => 'Cadangan',
            'username' => 'admin2',
            'email' => 'admin2@tbccare.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'gender' => 'Laki-laki',
            'jenis_kelamin' => 'Laki-laki',
            'usia' => 28,
            'birth_date' => '1998-05-20',
            'phone' => '08998995841',
            'nomor_wa_pasien' => '08998995841',
            'nomor_wa_pmo' => '08998995841',
            'riwayat_penyakit' => 'Tidak ada',
            'address' => 'Puskesmas',
            'current_streak' => 0,
            'highest_streak' => 0,
        ]);
    }
}