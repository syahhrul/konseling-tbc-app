<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CheckHarianController;
use App\Http\Controllers\SkriningKontakController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataPasienController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PushNotificationController;

Route::post('/update-profile', [ProfileController::class, 'update'])->name('update.profile');

// Register multi-step
Route::get('/register/step1', [RegisterController::class, 'step1'])->name('register.step1');
Route::post('/register/step1', [RegisterController::class, 'postStep1'])->name('register.step1.post');
Route::get('/register/step2', [RegisterController::class, 'step2'])->name('register.step2');
Route::post('/register/step2', [RegisterController::class, 'submit'])->name('register.submit');


// Login
Route::post('/login', [LoginController::class, 'submitLogin'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/login', function () {
    return view('login'); // atau route ke LoginController
})->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('login');

// halaman dashboard setelah login
Route::get('/welcomeafterlogin', function () {
    return view('welcomeafterlogin');
})->name('welcomeafterlogin');

// Route untuk logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Halaman utama dan lainnya
Route::get('/', fn() => view('welcome'));
Route::get('/tentang', fn() => view('tentang'));
// Dashboard route defined below in authenticated middleware block



// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Halaman lain
Route::get('/pusatinfotbc', function () {
    return view('pusatinfotbc');
});

Route::get('/tentang', function () {
    return view('tentang');
});




Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Halaman login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Proses login (submit form login)
Route::post('/login', [LoginController::class, 'submitLogin'])->name('login.submit');

Route::get('/register_step1', function () {
    return view('register_step1'); // Sesuaikan nama view jika berbeda
})->name('register.step1');

Route::get('/register_step2', function () {
    return view('register_step2'); // pastikan file register_step2.blade.php ada
})->name('register.step2');


Route::get('/tentangafterlogin', function () {
    return view('tentangafterlogin');
})->name('tentangafterlogin');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

// Duplicate dashboard route removed to let DashboardController handle it


// Profile route
Route::middleware('auth')->get('/profile', function () {
    return view('profile'); // Sesuaikan dengan nama view untuk profil
})->name('profile');

// Privacy route
Route::middleware('auth')->get('/privacy', function () {
    return view('privacy'); // Sesuaikan dengan nama view untuk privasi
})->name('privacy');

// Settings route
Route::middleware('auth')->get('/settings', function () {
    return view('settings'); // Sesuaikan dengan nama view untuk pengaturan
})->name('settings');

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

Route::get('/tentangafterlogin', function () {
    return view('tentangafterlogin');
})->name('tentangafterlogin');

Route::middleware('auth')->get('/checkharian', function () {
    return view('checkharian');
})->name('checkharian');

// Duplicate dashboard route removed

Route::get('/register', function () {
    return view('register'); // pastikan Anda sudah memiliki view register.blade.php
})->name('register');

Route::post('/checkharian', [CheckHarianController::class, 'store'])->name('checkharian.store');

// Route untuk dashboard perawat/admin baru
Route::middleware('auth')->get('/admin/dashboard', [DataPasienController::class, 'adminDashboard'])->name('admin.dashboard');
Route::middleware('auth')->get('/datapasien/detail/{id}', [DataPasienController::class, 'showDetailPasien'])->name('datapasien.detail');
Route::middleware('auth')->get('/edit-profil', [ProfileController::class, 'edit'])->name('profile.edit');
Route::middleware('auth')->post('/edit-profil', [ProfileController::class, 'updatePasien'])->name('profile.update');


Route::get('/lupapassword', function () {
    return view('lupapassword');  // Mengarah ke halaman dashboardperawat.blade.php
})->name('lupapassword');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
Route::post('/reset-password', [NewPasswordController::class, 'update'])->name('password.update');

Route::get('/pusatinfotbcafterlogin', function () {
    return view('pusatinfotbcafterlogin');
})->name('pusatinfotbcafterlogin');

Route::get('/output_pasien', function () {
    return view('output_pasien');
});
// Route untuk logout dengan metode POST
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('auth')->get('/checkharian', [CheckHarianController::class, 'create'])->name('checkharian'); // Rute untuk menampilkan form
Route::middleware('auth')->post('/checkharian', [CheckHarianController::class, 'store'])->name('checkharian.store'); // Rute untuk menyimpan data form

Route::middleware('auth')->get('/output_pasien', [CheckHarianController::class, 'index'])->name('output_pasien'); // Rute untuk menampilkan data cek harian

Route::get('/datapasien', [DataPasienController::class, 'showDataPasien'])->name('datapasien');
Route::post('/datapasien', [DataPasienController::class, 'store'])->name('datapasien.store');
Route::put('/datapasien/{id}', [DataPasienController::class, 'update'])->name('datapasien.update');
Route::delete('/datapasien/{id}', [DataPasienController::class, 'destroy'])->name('datapasien.destroy');
Route::get('/datapasien/export/csv', [DataPasienController::class, 'exportCsv'])->name('admin.pasien.export.csv');
Route::get('/datapasien/export/pdf', [DataPasienController::class, 'exportAllPdf'])->name('admin.pasien.export.pdf');
Route::get('/datapasien/download/{user}', [DataPasienController::class, 'downloadPdf'])->name('datapasien.download');
Route::middleware('auth')->get('/admin/datapasien/reminder/{id}', [DataPasienController::class, 'kirimPengingat'])->name('admin.pasien.reminder');
Route::middleware('auth')->post('/push-subscribe', [PushNotificationController::class, 'subscribe'])->name('push.subscribe');
Route::middleware('auth')->post('/admin/trigger-push-demo/{id}', [PushNotificationController::class, 'triggerDemoNotification'])->name('admin.trigger.push.demo');
Route::middleware('auth')->get('/skrining_kontak', [SkriningKontakController::class, 'create'])->name('skrining.kontak.create');
Route::middleware('auth')->post('/skrining_kontak', [SkriningKontakController::class, 'store'])->name('skrining.kontak.store');

Route::get('/migrate-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);
        return "Migrasi dan Seeding Database Berhasil Dijalankan!";
    } catch (\Exception $e) {
        return "Error saat migrasi: " . $e->getMessage();
    }
});

use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Route;

Route::get('/artisan-migrate-mpti', function () {
    try {
        // Menjalankan migrasi secara paksa ke database production Neon
        Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        return "Mantap! Semua tabel termasuk tabel push_subscriptions berhasil dibuat di Neon.";
    } catch (\Exception $e) {
        return "Gagal melakukan migrasi. Error: " . $e->getMessage();
    }
});