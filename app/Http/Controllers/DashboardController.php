<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Borrowing; // Model Peminjaman
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    // ==========================================
    // 1. DASHBOARD UTAMA
    // ==========================================
    public function index()
    {
        return view('dashboard.index', [
            'total_posts' => Post::count(),
            'total_comments' => Comment::count(),
            // Hitung peminjaman yang masih pending (menunggu persetujuan)
            'pending_borrowings' => Borrowing::where('status', 'pending')->count(), 
        ]);
    }

    // ==========================================
    // 2. KELOLA PUSTAKA (BUKU & ARTIKEL)
    // ==========================================
    public function posts()
    {
        // Ambil data terbaru
        $posts = Post::orderBy('id', 'desc')->get();
        return view('dashboard.posts.index', ['posts' => $posts]);
    }

    public function createPost()
    {
        return view('dashboard.posts.create');
    }

    public function storePost(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'author' => 'required',
            'body' => 'required',
            'image' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'category' => $request->category,
            'author' => $request->author,
            'body' => $request->body,
            'image' => $request->image,
            'excerpt' => Str::limit($request->body, 100), 
        ]);

        return redirect()->route('dashboard.posts')->with('success', 'Data berhasil ditambahkan!');
    }

    public function editPost($id)
    {
        $post = Post::findOrFail($id);
        return view('dashboard.posts.edit', ['post' => $post]);
    }

    public function updatePost(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'author' => 'required',
            'body' => 'required',
            'image' => 'required',
        ]);

        $post = Post::findOrFail($id);
        
        $post->update([
            'title' => $request->title,
            'category' => $request->category,
            'author' => $request->author,
            'body' => $request->body,
            'image' => $request->image,
            'excerpt' => Str::limit($request->body, 100),
        ]);

        return redirect()->route('dashboard.posts')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroyPost($id)
    {
        Post::destroy($id);
        return back()->with('success', 'Data berhasil dihapus!');
    }

    // ==========================================
    // 3. KELOLA KOMENTAR
    // ==========================================
    public function comments()
    {
        $comments = Comment::orderBy('id', 'desc')->get();
        return view('dashboard.comments.index', ['comments' => $comments]);
    }

    public function destroyComment($id)
    {
        Comment::destroy($id);
        return back()->with('success', 'Komentar berhasil dihapus!');
    }

    // ==========================================
    // 4. KELOLA PEMINJAMAN
    // ==========================================
    public function borrowings()
    {
        // Ambil data peminjaman beserta info user dan bukunya
        $borrowings = Borrowing::with(['user', 'book'])->orderBy('id', 'desc')->get();
        return view('dashboard.borrowings.index', ['borrowings' => $borrowings]);
    }

    public function updateBorrowingStatus(Request $request, $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        
        $data = ['status' => $request->status];
        
        // Kalau di-ACC (approved), set tanggal kembali otomatis 7 hari lagi
        if($request->status == 'approved') {
            $data['return_date'] = now()->addDays(7);
        }

        $borrowing->update($data);

        return back()->with('success', 'Status peminjaman berhasil diperbarui!');
    }
}