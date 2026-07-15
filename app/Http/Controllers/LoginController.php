<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function submitLogin(Request $request)
    {
        $credentials = $request->validate([
            'userId'   => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['username' => $credentials['userId'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Arahkan berdasarkan peran (role)
            if ($user->role === 'admin' || $user->role === 'perawat') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('welcomeafterlogin'); // Arahkan pengguna biasa ke sini
        }

        return back()->withErrors([
            'userId' => 'User ID atau password salah.',
        ])->onlyInput('userId');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
