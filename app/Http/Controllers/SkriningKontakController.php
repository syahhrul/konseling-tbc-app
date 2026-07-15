<?php

namespace App\Http\Controllers;

use App\Models\SkriningKontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkriningKontakController extends Controller
{
    public function create()
    {
        $riwayat = SkriningKontak::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('skrining_kontak', [
            'riwayat' => $riwayat,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_anggota_keluarga' => 'required|string|max:255',
            'status_gejala' => 'required|boolean',
            'rekomendasi_tindakan' => 'nullable|string|max:255',
        ]);

        SkriningKontak::create([
            'user_id' => Auth::id(),
            'nama_anggota_keluarga' => $validated['nama_anggota_keluarga'],
            'status_gejala' => (bool) $validated['status_gejala'],
            'rekomendasi_tindakan' => $validated['rekomendasi_tindakan']
                ?? ($validated['status_gejala'] ? 'Jadwalkan pemeriksaan dahak' : 'Pantau dan ulangi skrining bila ada gejala'),
        ]);

        return redirect()->route('skrining.kontak.create')->with('success', 'Data skrining kontak keluarga berhasil disimpan.');
    }
}