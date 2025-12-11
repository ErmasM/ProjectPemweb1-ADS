<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Models\Post;       
use App\Models\Comment;    
use App\Models\Borrowing;  

class DashboardController extends Controller
{
    // --- DAFTAR KATEGORI AGAR KONSISTEN ---
    // Kita simpan daftar kategori di sini biar tidak perlu ketik ulang terus
    private $kategoriBuku = [
        'Koleksi Baru', 'Resensi', 'Koleksi', 'Koleksi Umum', 
        'Novel', 'Sejarah', 'Biografi', 'Komik', 'Ensiklopedia', 
        'Kamus', 'Sastra', 'Psikologi', 'Agama', 'Buku Pelajaran', 'Bisnis', 'Fiksi'
    ];

    private $kategoriArtikel = [
        'Teknologi', 'Tips Literasi', 'Event', 'Info Layanan', 
        'Olahraga', 'Informasi', 'Berita', 'Opini'
    ];

    public function index()
    {
        return view('dashboard.index', [
            'posts_count' => Post::count(),
            'comments_count' => Comment::count(),
            'loans_count' => Borrowing::where('status', 'approved')->count(), 
        ]);
    }

    // --- HALAMAN DAFTAR (READ) ---

    public function books()
    {
        // PERBAIKAN: Masukkan $this->kategoriBuku agar Novel dll ikut muncul
        $books = Post::whereIn('category', $this->kategoriBuku)->latest()->get();
        return view('dashboard.posts.index', ['posts' => $books, 'page_title' => '📚 Kelola Katalog Buku']);
    }

    public function articles()
    {
        // PERBAIKAN: Gunakan daftar kategori artikel yang lengkap
        $articles = Post::whereIn('category', $this->kategoriArtikel)->latest()->get();
        return view('dashboard.posts.index', ['posts' => $articles, 'page_title' => '📰 Kelola Artikel Blog']);
    }

    public function borrowings()
    {
        $borrowings = Borrowing::with(['user', 'book'])->latest()->get();
        return view('dashboard.borrowings.index', ['borrowings' => $borrowings]);
    }

    public function comments()
    {
        $comments = Comment::with('post')->latest()->get();
        return view('dashboard.comments.index', compact('comments'));
    }

    // --- UPDATE STATUS & DELETE ---

    public function updateBorrowingStatus(Request $request, $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = $request->status;
        if ($request->status == 'returned') { $borrowing->return_date = now(); }
        $borrowing->save();
        return back()->with('success', 'Status peminjaman berhasil diperbarui!');
    }

    public function destroyComment($id)
    {
        Comment::findOrFail($id)->delete();
        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    // --- CRUD POST (CREATE, UPDATE, DELETE) ---

    public function posts() { return $this->books(); }

    public function createPost() { return view('dashboard.posts.create'); }

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
            'excerpt' => Str::limit(strip_tags($request->body), 150),
            // 'user_id' => auth()->id() 
        ]);

        // PERBAIKAN LOGIKA REDIRECT
        // Cek apakah kategori yang dipilih termasuk dalam daftar BUKU
        if(in_array($request->category, $this->kategoriBuku)) {
            return redirect()->route('dashboard.books')->with('success', 'Buku berhasil ditambahkan!');
        }
        
        // Jika tidak ada di daftar buku, pasti masuk ke Artikel
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
        $post->update([
            'title' => $request->title,
            'category' => $request->category,
            'author' => $request->author,
            'body' => $request->body,
            'image' => $request->image,
            'excerpt' => Str::limit(strip_tags($request->body), 150),
        ]);

        // PERBAIKAN LOGIKA REDIRECT SAAT UPDATE
        if(in_array($post->category, $this->kategoriBuku)) {
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