<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\BorrowController;

// ==========================================
// 1. JALUR UNTUK PENGUNJUNG (PUBLIK)
// ==========================================

// Halaman Depan (Beranda)
Route::get('/', [PostController::class, 'index'])->name('home');

// Halaman Baca Berita Lengkap
Route::get('/post/{id}', [PostController::class, 'show'])->name('posts.show');

// Halaman Kontak
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Fitur Komentar (Simpan & Hapus)
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');


// ... (Bagian atas/publik biarkan saja) ...

// ==========================================
// 2. JALUR KHUSUS ADMIN (DASHBOARD)
// ==========================================
// Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group Dashboard (Harus Login Dulu)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    
    // Halaman Utama Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola Postingan (Buku & Artikel)
    Route::get('/posts', [DashboardController::class, 'posts'])->name('dashboard.posts');
    Route::get('/posts/create', [DashboardController::class, 'createPost'])->name('dashboard.posts.create');
    Route::post('/posts/store', [DashboardController::class, 'storePost'])->name('dashboard.posts.store');
    Route::get('/posts/{id}/edit', [DashboardController::class, 'editPost'])->name('dashboard.posts.edit');
    Route::put('/posts/{id}', [DashboardController::class, 'updatePost'])->name('dashboard.posts.update');
    Route::delete('/posts/{id}', [DashboardController::class, 'destroyPost'])->name('dashboard.posts.destroy');

    // Kelola Komentar
    Route::get('/comments', [DashboardController::class, 'comments'])->name('dashboard.comments');
    Route::delete('/comments/{id}', [DashboardController::class, 'destroyComment'])->name('dashboard.comments.destroy');

    // JALUR USER (Login Only)
Route::middleware(['auth'])->group(function () {
    Route::post('/borrow', [BorrowController::class, 'store'])->name('borrow.store');
    Route::get('/my-books', [BorrowController::class, 'index'])->name('my.borrowings');
});

// JALUR ADMIN (Tambahan Dashboard)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    // ... (route dashboard lain) ...
    Route::get('/borrowings', [DashboardController::class, 'borrowings'])->name('dashboard.borrowings');
    Route::patch('/borrowings/{id}', [DashboardController::class, 'updateBorrowingStatus'])->name('dashboard.borrowings.update');
});
});