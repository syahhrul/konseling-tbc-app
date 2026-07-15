<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    // Tampilkan halaman Step 1
    public function step1()
    {
        return view('register_step1');
    }

    // Proses data Step 1 dan simpan ke session
    public function postStep1(Request $request)
    {
        $request->validate([
            'nama_depan'     => 'required|string|max:50',
            'nama_belakang'  => 'nullable|string|max:50',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan,Lainnya',
            'alamat'         => 'required|string|max:255',
        ]);

        // Simpan data step 1 ke session
        $request->session()->put('register_step1', $request->only([
            'nama_depan', 'nama_belakang', 'tanggal_lahir', 'jenis_kelamin', 'alamat'
        ]));

        return redirect()->route('register.step2');
    }
    

    // Tampilkan halaman Step 2
    public function step2()
    {
        // Pastikan user tidak bisa langsung akses step 2 tanpa isi step 1
        if (!session()->has('register_step1')) {
            return redirect()->route('register.step1')->withErrors('Silakan isi data tahap pertama terlebih dahulu.');
        }

        return view('register_step2');
    }

    // Proses submit data final (step 2)
    public function submit(Request $request)
    {
        // Ambil data dari session
        $step1 = session('register_step1');

        if (!$step1) {
            return redirect()->route('register.step1')->withErrors('Data tahap 1 tidak ditemukan.');
        }

        // Validasi input dari step 2
        $request->validate([
            'email'           => 'required|email|unique:users,email',
            'telepon'         => 'required|string|max:20',
            'nomor_wa_pasien' => 'required|string|max:20',
            'nomor_wa_pmo'    => 'required|string|max:20',
            'username'        => 'required|string|max:50|unique:users,username',
            // 'role'      => 'required|in:perawat,pasien',
            'password'        => 'required|string|confirmed|min:6',
        ]);

        Log::info('RegisterController submit data', [
            'step1' => $step1,
            'request' => $request->all()
        ]);

        // Simpan ke database
        try {
            User::create([
                'first_name'      => $step1['nama_depan'],
                'last_name'       => $step1['nama_belakang'],
                'birth_date'      => $step1['tanggal_lahir'],
                'gender'          => $step1['jenis_kelamin'],
                'address'         => $step1['alamat'],
                'email'           => $request->email,
                'phone'           => $request->telepon,
                'nomor_wa_pasien' => $request->nomor_wa_pasien,
                'nomor_wa_pmo'    => $request->nomor_wa_pmo,
                'username'        => $request->username,
                'role'            => 'pengguna',
                'password'        => Hash::make($request->password),
            ]);

            // Hapus session step 1
            $request->session()->forget('register_step1');

            // Log info (opsional untuk debugging)
            Log::info('User berhasil diregistrasi: ' . $request->username);

            // Redirect ke halaman login
            return redirect()->route('login')->with('success', 'Redirect berhasil ke login.');
        } catch (\Exception $e) {
            Log::error('Gagal registrasi: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
    
    }
}
