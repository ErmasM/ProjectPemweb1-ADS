<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowController extends Controller
{
    // Fungsi untuk meminjam buku (Saat tombol Pinjam diklik)
    public function store(Request $request, $post_id)
    {
        // Cek apakah user sudah meminjam buku ini dan belum dikembalikan (status pending/approved)
        $existing = Borrowing::where('user_id', Auth::id())
                    ->where('post_id', $post_id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->exists();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sedang meminjam buku ini. Cek riwayatmu.');
        }

        Borrowing::create([
            'user_id' => Auth::id(),
            'post_id' => $post_id,
            'borrow_date' => now(),
            'return_date' => Carbon::now()->addDays(7), // Otomatis 7 hari
            'status' => 'pending',
        ]);

        // Redirect ke halaman Riwayat Peminjaman (Bukan back/stuck)
        return redirect()->route('my.borrowings')->with('success', 'Permintaan peminjaman berhasil dikirim! Tunggu konfirmasi admin.');
    }

    // Fungsi untuk melihat Riwayat Peminjaman User
    public function history()
    {
        // Ambil peminjaman HANYA milik user yang sedang login
        $borrowings = Borrowing::where('user_id', Auth::id())
                        ->with('book') // Load data buku
                        ->latest()
                        ->get();

        return view('borrowings.index', compact('borrowings'));
    }
}