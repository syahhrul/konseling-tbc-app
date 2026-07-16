# 🫁 TBC Care — Sistem Konseling & Monitoring Tuberkulosis

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg?logo=laravel)](https://laravel.com)
[![Runtime](https://img.shields.io/badge/Vercel-Serverless-black?logo=vercel)](https://vercel.com)
[![Database](https://img.shields.io/badge/Supabase-PostgreSQL-blue?logo=supabase)](https://supabase.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

**TBC Care** adalah platform kesehatan digital (*Digital Health Monitoring*) yang dirancang khusus untuk mempermudah pemantauan kepatuhan minum obat bagi pasien Tuberkulosis (TBC). Platform ini dibangun untuk mendukung program eliminasi TBC di Indonesia dengan menghubungkan pasien secara real-time ke Pengawas Menelan Obat (PMO) dan petugas kesehatan.

Aplikasi ini dideploy secara *serverless* di **Vercel** dengan database cloud **PostgreSQL dari Supabase** untuk keperluan demo di **Gelar Karya MPTI**.

---

## 🌟 Fitur Utama

- **Laporan Harian Pasien (Cek Harian)**: Pencatatan cepat (1 menit) mengenai suhu tubuh, berat badan, gejala klinis, serta status konsumsi obat harian.
- **Grafik & Rekor Kepatuhan (Streak)**: Sistem gamifikasi kepatuhan (*Hari Patuh*) untuk menyemangati pasien agar menyelesaikan masa terapi minimal 6 bulan tanpa putus.
- **Skrining Kontak Erat Keluarga**: Deteksi dini risiko penularan bagi anggota keluarga serumah guna memutus rantai penularan TBC.
- **Notifikasi Pengingat Real-Time (Web Push)**: Pengiriman notifikasi pengingat minum obat langsung ke peramban (browser) Windows & Android pasien.
- **Integrasi Peringatan PMO**: Sistem pengingat otomatis jika pasien belum lapor minum obat hingga batas waktu yang ditentukan.

---

## 🛠️ Tech Stack & Arsitektur

*   **Framework**: [Laravel](https://laravel.com/)
*   **Database**: [Supabase PostgreSQL](https://supabase.com/) dengan Connection Pooler (Supavisor)
*   **Hosting & Serverless**: [Vercel](https://vercel.com/) via `vercel-php` runtime
*   **Styling**: Bootstrap 5, FontAwesome 6, dan Google Fonts
*   **Push Notification**: Web Push API (VAPID)

---

## ⚙️ Langkah Instalasi Lokal

Jika Anda ingin menjalankan proyek ini di lingkungan lokal Anda:

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/syahhrul/konseling-tbc-app.git
   cd konseling-tbc-app
   ```

2. **Instal Dependensi**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**:
   Salin file `.env.example` menjadi `.env` dan sesuaikan kredensial database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi & Seed Database**:
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi**:
   ```bash
   php artisan serve
   # Di terminal terpisah jalankan Vite asset compiler
   npm run dev
   ```

---

## 🚀 Panduan Uji Coba Demo (Dashboard Vercel)

Silakan kunjungi tautan demo langsung berikut:
👉 **[TBC Care Demo Live](https://tbc-care.vercel.app)**

### Akun Uji Coba (Seeded Accounts)

| Peran (Role) | Username | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Perawat (Admin)** | `admin` | `admin123` | Mengakses dashboard pemantauan semua pasien & mengirim demo notifikasi. |
| **Pasien Baru** | `pasienc` | `pasien123` | Pasien yang belum mengisi laporan hari ini. |
| **Pasien Patuh** | `pasiena` | `pasien123` | Pasien dengan streak patuh minum obat 5 hari. |
| **Pasien Kritis** | `pasienb` | `pasien123` | Pasien yang terlambat melapor lebih dari 48 jam. |

---

## 📄 Lisensi

Proyek ini bersifat open-source di bawah lisensi [MIT License](https://opensource.org/licenses/MIT).
