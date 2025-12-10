<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// IMPORT MODEL YANG BENAR SESUAI GAMBAR KAMU
use App\Models\Post;       
use App\Models\Comment;    
use App\Models\Borrowing;  // Perhatikan: Pakai 'Borrowing', bukan 'Borrow'

class DashboardController extends Controller
{
    // 1. Halaman Dashboard Utama
    public function index()
    {
        return view('dashboard.index', [
            // Menghitung Total Buku + Artikel (Post)
            'posts_count' => Post::count(),
            
            // Menghitung Komentar
            'comments_count' => Comment::count(),
            
            // Menghitung Peminjaman Aktif (status 'approved')
            // Menggunakan model Borrowing
            'loans_count' => Borrowing::where('status', 'approved')->count(), 
        ]);
    }

    // 2. Halaman Kelola Buku (Filter Kategori Buku)
    public function books()
    {
        $books = Post::whereIn('category', ['Koleksi Baru', 'Resensi', 'Koleksi', 'Koleksi Umum'])
                     ->latest()
                     ->get();
        
        return view('dashboard.posts.index', [
            'posts' => $books,
            'page_title' => '📚 Kelola Katalog Buku'
        ]);
    }

    // 3. Halaman Kelola Artikel (Filter Kategori Artikel)
    public function articles()
    {
        $articles = Post::whereIn('category', ['Teknologi', 'Tips Literasi', 'Event', 'Info Layanan', 'Olahraga', 'Informasi'])
                        ->latest()
                        ->get();
        
        return view('dashboard.posts.index', [
            'posts' => $articles,
            'page_title' => '📰 Kelola Artikel Blog'
        ]);
    }

    // 4. Halaman Kelola Peminjaman
    public function borrowings()
    {
        // Menggunakan Model Borrowing
        $borrowings = Borrowing::with(['user', 'book'])->latest()->get();

        return view('dashboard.borrowings.index', [
            'borrowings' => $borrowings
        ]);
    }

    // 5. Update Status Peminjaman
    public function updateBorrowingStatus(Request $request, $id)
    {
        // Menggunakan Model Borrowing
        $borrowing = Borrowing::findOrFail($id);
        
        $borrowing->status = $request->status;

        if ($request->status == 'returned') {
            $borrowing->return_date = now();
        }

        $borrowing->save();

        return back()->with('success', 'Status peminjaman berhasil diperbarui!');
    }

    // 6. Halaman Kelola Komentar
    public function comments()
    {
        $comments = Comment::with('post')->latest()->get();
        return view('dashboard.comments.index', compact('comments'));
    }

    public function destroyComment($id)
    {
        Comment::findOrFail($id)->delete();
        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    // --- FUNGSI CRUD POST (Create, Store, Edit, Update, Delete) ---

    // Fallback route jika ada yang akses /posts
    public function posts() {
        return $this->books(); 
    }

    public function createPost()
    {
        return view('dashboard.posts.create');
    }

    public function storePost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'author' => 'required',
            'body' => 'required',
            'image' => 'required|url'
        ]);

        Post::create([
            'title' => $request->title,
            'category' => $request->category,
            'author' => $request->author,
            'body' => $request->body,
            'image' => $request->image,
            'user_id' => auth()->id() // Admin ID
        ]);

        if(in_array($request->category, ['Koleksi Baru', 'Resensi', 'Koleksi', 'Koleksi Umum'])) {
            return redirect()->route('dashboard.books')->with('success', 'Buku berhasil ditambahkan!');
        }
        return redirect()->route('dashboard.articles')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function editPost($id)
    {
        $post = Post::findOrFail($id);
        return view('dashboard.posts.edit', compact('post'));
    }

    public function updatePost(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());

        if(in_array($post->category, ['Koleksi Baru', 'Resensi', 'Koleksi', 'Koleksi Umum'])) {
            return redirect()->route('dashboard.books')->with('success', 'Data Buku berhasil diupdate!');
        }
        return redirect()->route('dashboard.articles')->with('success', 'Data Artikel berhasil diupdate!');
    }

    public function destroyPost($id)
    {
        Post::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}