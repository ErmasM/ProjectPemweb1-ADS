<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; // <-- TAMBAHAN: Untuk menangkap input pencarian
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\BorrowController;
use App\Models\Post; 

// ==========================================
// 1. HALAMAN PUBLIK (User Biasa)
// ==========================================

Route::get('/', function (Request $request) { // <-- Tambahkan Request $request di sini
    // DAFTAR KATEGORI
    $kategoriBuku = [
        'Koleksi Baru', 'Resensi', 'Koleksi', 'Koleksi Umum', 
        'Novel', 'Sejarah', 'Biografi', 'Komik', 'Ensiklopedia', 
        'Kamus', 'Sastra', 'Psikologi', 'Agama', 'Buku Pelajaran', 'Bisnis', 'Fiksi'
    ];

    $kategoriArtikel = [
        'Teknologi', 'Tips Literasi', 'Event', 'Info Layanan', 
        'Olahraga', 'Informasi', 'Berita', 'Opini'
    ];

    // --- LOGIKA PENCARIAN (SEARCH) ---
    $query = $request->input('q'); // Ambil kata kunci dari kolom pencarian

    // Query Dasar untuk Buku
    $bookQuery = Post::whereIn('category', $kategoriBuku)->latest();

    // Query Dasar untuk Artikel
    $articleQuery = Post::whereIn('category', $kategoriArtikel)->latest();

    // Jika ada pencarian, tambahkan filter WHERE LIKE
    if ($query) {
        $bookQuery->where(function($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('author', 'like', "%{$query}%")
              ->orWhere('category', 'like', "%{$query}%");
        });

        $articleQuery->where(function($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('author', 'like', "%{$query}%")
              ->orWhere('category', 'like', "%{$query}%");
        });
    }

    // Eksekusi Query
    $bookCollections = $bookQuery->take(10)->get();
    $gridBlogPosts = $articleQuery->take(6)->get();
    
    // Slider tetap ambil 3 terbaru tanpa filter pencarian (opsional)
    $sliderPosts = Post::latest()->take(3)->get();

    return view('home', compact('sliderPosts', 'gridBlogPosts', 'bookCollections'));
})->name('home');

Route::get('/post/{id}', [PostController::class, 'show'])->name('posts.show');
Route::get('/contact', function () { return view('contact'); })->name('contact');

// ==========================================
// 2. AUTHENTICATION (Login & Logout)
// ==========================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); 
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// 3. FITUR USER (Harus Login)
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::post('/borrow/{post_id}', [BorrowController::class, 'store'])->name('borrow.store');
    Route::get('/my-borrowings', [BorrowController::class, 'history'])->name('my.borrowings');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/post/{id}/favorite', [PostController::class, 'toggleFavorite'])->name('post.favorite');
});

// ==========================================
// 4. ADMIN DASHBOARD (Harus Admin)
// ==========================================
Route::middleware(['auth', 'admin'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/books', [DashboardController::class, 'books'])->name('dashboard.books');
    Route::get('/articles', [DashboardController::class, 'articles'])->name('dashboard.articles');
    Route::get('/posts/create', [DashboardController::class, 'createPost'])->name('dashboard.posts.create');
    Route::post('/posts/store', [DashboardController::class, 'storePost'])->name('dashboard.posts.store');
    Route::get('/posts/{id}/edit', [DashboardController::class, 'editPost'])->name('dashboard.posts.edit');
    Route::put('/posts/{id}', [DashboardController::class, 'updatePost'])->name('dashboard.posts.update');
    Route::delete('/posts/{id}', [DashboardController::class, 'destroyPost'])->name('dashboard.posts.destroy');
    Route::get('/borrowings', [DashboardController::class, 'borrowings'])->name('dashboard.loans');
    Route::patch('/borrowings/{id}', [DashboardController::class, 'updateBorrowingStatus'])->name('dashboard.borrowings.update');
    Route::get('/comments', [DashboardController::class, 'comments'])->name('dashboard.comments');
    Route::delete('/comments/{id}', [DashboardController::class, 'destroyComment'])->name('dashboard.comments.destroy');
});