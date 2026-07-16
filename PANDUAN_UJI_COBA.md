# Panduan Uji Coba Aplikasi "TBC Care" (Gelar Karya MPTI)

Dokumen ini berisi panduan singkat untuk seluruh tim guna menguji coba aplikasi **TBC Care** yang telah aktif di Vercel dengan database Supabase PostgreSQL.

---

## 1. URL Aplikasi Utama
*   **Alamat Web**: [https://tbc-care.vercel.app](https://tbc-care.vercel.app)
*   **Rute Inisialisasi Database (Hanya dijalankan sekali di awal / jika ingin mereset)**:  
    `https://tbc-care.vercel.app/artisan-migrate-mpti`  
    *(Mengosongkan DB, membuat tabel baru, dan mengisi data akun uji coba secara otomatis).*

---

## 2. Akun Uji Coba (Seeded Accounts)

Gunakan daftar akun berikut untuk masuk ke aplikasi:

### A. Akun Perawat / Admin (Pusat Monitoring)
*   **Username**: `admin`
*   **Password**: `admin123`

### B. Akun Pasien (Untuk Pengguna/Android/Windows)
*   **Pasien Baru (Belum Mengisi Hari Ini)**:
    *   **Username**: `pasienc`
    *   **Password**: `pasien123`
*   **Pasien Patuh (Sudah Streak 5 Hari)**:
    *   **Username**: `pasiena`
    *   **Password**: `pasien123`
*   **Pasien Kritis (Belum Lapor > 48 Jam)**:
    *   **Username**: `pasienb`
    *   **Password**: `pasien123`

---

## 3. Cara Menguji Fitur Push Notification

Ikuti langkah-langkah di bawah ini di browser **Google Chrome, Microsoft Edge, atau Firefox (PC & Android)**:

### Langkah A: Daftarkan Notifikasi di Browser Pasien
1. Masuk (*Login*) menggunakan salah satu akun pasien (contoh: **`pasienc` / `pasien123`**).
2. Di halaman Dashboard, temukan kartu **"Pengingat Otomatis"** di bagian kanan bawah.
3. Klik tombol **"Aktifkan Notifikasi Pengingat Browser"**.
4. Browser akan memunculkan pop-up permintaan izin. Klik **Allow (Izinkan)**.
5. Jika berhasil, tombol akan berubah menjadi badge hijau bertuliskan **"Notifikasi Browser: Aktif & Siap Menerima Pengingat"**.

### Langkah B: Kirim Notifikasi dari Dashboard Perawat (Admin)
1. Buka tab baru di browser Anda, lalu login menggunakan akun perawat (**`admin` / `admin123`**).
2. Anda akan berada di Dashboard Admin yang menampilkan tabel pasien.
3. Cari nama pasien yang baru saja Anda daftarkan di Langkah A (contoh: **Pasien Baru C**).
4. Klik tombol **"Kirim Pengingat Demo"** (ikon lonceng) di ujung baris data pasien tersebut.
5. **Hasil yang diharapkan**: Notifikasi pop-up pengingat minum obat akan langsung muncul di pojok kanan bawah PC Anda atau di laci notifikasi HP Android Anda!

---

## 4. Tips Pemecahan Masalah (Troubleshooting)

*   **Pesan "Koneksi ditolak oleh push service browser"**:
    Biasanya terjadi jika browser Anda masih menyimpan token dari kunci enkripsi lama. Silakan klik ikon gembok di sebelah kiri alamat URL web di browser Anda, klik **Reset Permission**, muat ulang halaman (refresh), dan klik kembali tombol **"Aktifkan Notifikasi..."** untuk membuat token baru yang sinkron.
*   **Pengguna Android**: Pastikan mode "Do Not Disturb" (Jangan Ganggu) mati, dan izin notifikasi untuk browser Chrome/Edge di pengaturan Android Anda aktif.
