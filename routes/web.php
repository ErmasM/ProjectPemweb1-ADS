<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\BorrowController;

// ==========================================
// 1. HALAMAN PUBLIK (User Biasa)
// ==========================================
Route::get('/', [PostController::class, 'index'])->name('home');
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
    // Fitur Pinjam Buku
    Route::post('/borrow/{post_id}', [BorrowController::class, 'store'])->name('borrow.store');
    Route::get('/my-borrowings', [BorrowController::class, 'history'])->name('my.borrowings');
    
    // Fitur Komentar
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // Route untuk Like/Unlike
    Route::post('/post/{id}/favorite', [PostController::class, 'toggleFavorite'])->name('post.favorite');
});

// ==========================================
// 4. ADMIN DASHBOARD (Harus Admin)
// ==========================================
Route::middleware(['auth', 'admin'])->prefix('dashboard')->group(function () {
    // Dashboard Utama
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola Posts (Buku/Artikel)
    // 1. Route untuk Daftar BUKU
    Route::get('/books', [DashboardController::class, 'books'])->name('dashboard.books');
    
    // 2. Route untuk Daftar ARTIKEL
    Route::get('/articles', [DashboardController::class, 'articles'])->name('dashboard.articles');

    // 3. CRUD (Create, Edit, Delete) - Tetap sama, dipakai bersama
    Route::get('/posts/create', [DashboardController::class, 'createPost'])->name('dashboard.posts.create');
    Route::post('/posts/store', [DashboardController::class, 'storePost'])->name('dashboard.posts.store');
    Route::get('/posts/{id}/edit', [DashboardController::class, 'editPost'])->name('dashboard.posts.edit');
    Route::put('/posts/{id}', [DashboardController::class, 'updatePost'])->name('dashboard.posts.update');
    Route::delete('/posts/{id}', [DashboardController::class, 'destroyPost'])->name('dashboard.posts.destroy');
    
    // --- PERBAIKAN DI SINI ---
    // Nama route diganti jadi 'dashboard.loans' agar sesuai dengan Sidebar
    Route::get('/borrowings', [DashboardController::class, 'borrowings'])->name('dashboard.loans');
    
    // Route untuk update status (Terima/Tolak/Kembali)
    Route::patch('/borrowings/{id}', [DashboardController::class, 'updateBorrowingStatus'])->name('dashboard.borrowings.update');
    
    // Kelola Komentar
    Route::get('/comments', [DashboardController::class, 'comments'])->name('dashboard.comments');
    Route::delete('/comments/{id}', [DashboardController::class, 'destroyComment'])->name('dashboard.comments.destroy');
});