<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment; // Panggil Model Komentar

class CommentController extends Controller
{
    // LOGIKA SIMPAN KOMENTAR
    public function store(Request $request)
    {
        // Validasi dulu biar gak kosong
        $request->validate([
            'name' => 'required',
            'body' => 'required',
        ]);

        // Simpan ke database
        Comment::create([
            'post_id' => $request->post_id,
            'name'    => $request->name,
            'body'    => $request->body,
        ]);

        return back(); // Kembali ke halaman sebelumnya
    }

    // LOGIKA HAPUS KOMENTAR
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return back();
    }
}