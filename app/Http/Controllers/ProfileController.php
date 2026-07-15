<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'gender' => 'required|string|in:Laki-laki,Perempuan,Lainnya',
        ]);

        // Ambil data user yang sedang login
        $user = Auth::user();

        // Update data user
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->gender = $request->gender;

        // Simpan perubahan ke database
        $user->save();

        // Redirect atau beri feedback ke user setelah update
        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function edit()
    {
        return view('pasien.edit_profil');
    }

    public function updatePasien(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nomor_wa_pasien' => 'required|string|max:20',
            'nomor_wa_pmo' => 'required|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->nomor_wa_pasien = $request->nomor_wa_pasien;
        $user->nomor_wa_pmo = $request->nomor_wa_pmo;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
