<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowController extends Controller
{
    // 1. PROSES PINJAM
    public function store(Request $request)
    {
        $request->validate(['post_id' => 'required']);

        // Cek double order
        $exists = Borrowing::where('user_id', Auth::id())
                            ->where('post_id', $request->post_id)
                            ->whereIn('status', ['pending', 'approved'])
                            ->exists();

        if($exists) {
            return back()->with('error', 'Kamu sedang meminjam buku ini!');
        }

        Borrowing::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
            'borrow_date' => Carbon::now(),
            'status' => 'pending',
        ]);

        return redirect()->route('my.borrowings')->with('success', 'Permintaan terkirim! Menunggu ACC Admin.');
    }

    // 2. HALAMAN BUKU SAYA
    public function index()
    {
        $borrowings = Borrowing::where('user_id', Auth::id())
                                ->with('book')
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('borrowings.index', ['borrowings' => $borrowings]);
    }
}