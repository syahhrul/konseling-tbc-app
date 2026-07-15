<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckHarian;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display patient dashboard or redirect to admin.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin' || $user->role === 'perawat') {
            return redirect()->route('admin.dashboard');
        }

        // Cek apakah pasien sudah melapor hari ini
        $today = Carbon::today()->toDateString();
        $hasFilledToday = CheckHarian::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->exists();

        $belumIsiHarian = !$hasFilledToday;

        return view('dashboard', [
            'belumIsiHarian' => $belumIsiHarian,
            'todayDateFormatted' => Carbon::today()->translatedFormat('d F Y'),
        ]);
    }
}
