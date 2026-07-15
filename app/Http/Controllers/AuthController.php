<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('userId', 'password');

        // Jika kolom login bukan "email", ubah sesuai database (misalnya "username")
        if (Auth::attempt(['username' => $credentials['userId'], 'password' => $credentials['password']])) {
            return redirect()->route('welcomeafterlogin');
        }

        return back()->withErrors([
            'userId' => 'User ID atau password salah.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function registerSubmit(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email|unique:users,email',
        'username' => 'required|string|max:255|unique:users,username',
        'telepon' => 'required|string|max:15',
        'password' => 'required|string|confirmed|min:6',
    ]);

    // Simpan user ke database
    User::create([
        'email' => $validated['email'],
        'username' => $validated['username'],
        'phone' => $validated['telepon'],
        'password' => bcrypt($validated['password']),
    ]);

    // Redirect ke login + flash message
    return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan login.');
    }
}
