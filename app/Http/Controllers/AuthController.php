<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLoginForm()
    {
        return view('login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah email & password cocok?
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
           // Cek Role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard'); // Admin ke Dashboard
            } 
            
            // User Biasa ke Home
            return redirect()->route('home'); 
        }

        // Kalau gagal, balikin ke login + pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ]);
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}