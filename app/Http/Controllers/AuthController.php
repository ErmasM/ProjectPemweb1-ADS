<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // TAMPILKAN FORM LOGIN
    public function showLoginForm()
    {
        return view('login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek Role: Admin ke Dashboard, User Biasa ke Home
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/dashboard');
            }

            return redirect()->intended('/');
        }

        // Kalau gagal
        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ]);
    }

    // PROSES LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}