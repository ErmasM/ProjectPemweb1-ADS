<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    public function index()
    {
        // 1. Ambil data Blog (Artikel/Berita)
        $blogPosts = Post::whereIn('category', ['Teknologi', 'Tips Literasi', 'Event', 'Info Layanan', 'Edukasi'])
                         ->orderBy('id', 'desc')
                         ->get();

        // 2. Ambil data Buku (Koleksi)
        $bookCollections = Post::whereIn('category', ['Resensi', 'Koleksi Baru', 'Koleksi'])
                               ->orderBy('id', 'desc')
                               ->get();

        $sliderPosts = $blogPosts->take(3);
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
        
        // Cek apakah ini Buku?
        $isBook = in_array($post->category, ['Resensi', 'Koleksi Baru', 'Koleksi', 'Koleksi Umum']);

        $comments = Comment::where('post_id', $id)->orderBy('id', 'desc')->get();

        // JIKA BUKU -> Tampilkan view khusus show_book
        // Kita kirim datanya sebagai variabel '$book'
        if($isBook && view()->exists('show_book')) {
            return view('show_book', ['book' => $post, 'comments' => $comments]);
        }

        // JIKA ARTIKEL -> Tampilkan view standar show
        return view('show', ['post' => $post, 'comments' => $comments]);
    }

    public function toggleFavorite($id)
    {
        $post = Post::findOrFail($id);
        auth()->user()->favorites()->toggle($post->id);
        return back(); 
    }
}