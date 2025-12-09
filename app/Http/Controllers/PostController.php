<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    public function index()
    {
        // Ambil data Blog (Kategori Umum)
        $blogPosts = Post::whereIn('category', ['Teknologi', 'Tips Literasi', 'Event', 'Info Layanan', 'Edukasi'])
                         ->orderBy('id', 'desc')
                         ->get();

        // Ambil data Buku (Kategori Spesifik Buku)
        $bookCollections = Post::whereIn('category', ['Resensi', 'Koleksi Baru', 'Koleksi'])
                               ->orderBy('id', 'desc')
                               ->get();

        // Slider Utama (Ambil 3 terbaru dari Blog)
        $sliderPosts = $blogPosts->take(3);
        
        // Grid Blog (Ambil sisanya)
        $gridBlogPosts = $blogPosts->skip(3);

        return view('home', [
            'sliderPosts' => $sliderPosts,
            'gridBlogPosts' => $gridBlogPosts,
            'bookCollections' => $bookCollections,
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        
        // Cek apakah ini Buku atau Blog (untuk membedakan tampilan)
        $isBook = in_array($post->category, ['Resensi', 'Koleksi Baru', 'Koleksi']);

        $comments = Comment::where('post_id', $id)->orderBy('id', 'desc')->get();

        // Kalau buku, tampilkan view khusus buku
        if($isBook) {
            return view('show_book', ['book' => $post, 'comments' => $comments]);
        }

        // Kalau blog biasa, tampilkan view standar
        return view('show', ['post' => $post, 'comments' => $comments]);
    }
}