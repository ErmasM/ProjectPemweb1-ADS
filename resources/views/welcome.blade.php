<!doctype html>
<html lang="id" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog Informasi - Kelompok 13</title>
    
    {{-- Bootstrap CSS & Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* CSS Tambahan biar makin mirip referensi */
        body { background-color: #121212; color: #e0e0e0; }
        .navbar { background-color: #1a1a1a; border-bottom: 1px solid #333; padding: 15px 0; }
        .nav-link { color: #aaa; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin: 0 10px; }
        .nav-link:hover, .nav-link.active { color: #fff; }
        
        /* Gaya Kartu Artikel */
        .card { background-color: #1e1e1e; border: none; border-radius: 12px; transition: transform 0.2s; }
        .card:hover { transform: translateY(-5px); }
        .badge-category { position: absolute; top: 15px; left: 15px; font-size: 0.8rem; padding: 5px 10px; border-radius: 5px; }
        
        /* Warna-warni Kategori */
        .bg-Teknologi { background-color: #0d6efd; }
        .bg-Kesehatan { background-color: #198754; }
        .bg-Bisnis { background-color: #ffc107; color: #000; }
        .bg-Travel { background-color: #0dcaf0; color: #000; }
        .bg-Gaya { background-color: #d63384; }

        /* Hero Section */
        .hero-section { background-color: #1e1e1e; padding: 30px; border-radius: 15px; margin-bottom: 40px; }
        .hero-title { font-size: 2.5rem; font-weight: 700; color: #fff; margin-bottom: 15px; }
        .img-cover { object-fit: cover; width: 100%; height: 200px; border-top-left-radius: 12px; border-top-right-radius: 12px; }
        .hero-img { width: 100%; height: 350px; object-fit: cover; border-radius: 10px; }
    </style>
  </head>
  <body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg">
      <div class="container justify-content-center">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link active" href="#">BERANDA</a></li>
          <li class="nav-item"><a class="nav-link" href="#">KONTAK</a></li>
          <li class="nav-item"><a class="nav-link" href="#">LOGIN</a></li>
        </ul>
      </div>
    </nav>

    <div class="container mt-5">
        
        {{-- BAGIAN 1: ARTIKEL UTAMA (HERO) --}}
        @if($heroPost)
        <div class="hero-section">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <img src="{{ $heroPost->image }}" class="hero-img mb-3 mb-md-0 shadow" alt="Hero Image">
                </div>
                <div class="col-md-5">
                    <span class="badge bg-{{ explode(' ', $heroPost->category)[0] }} mb-2">{{ $heroPost->category }}</span>
                    <h1 class="hero-title">{{ $heroPost->title }}</h1>
                    <div class="text-secondary mb-3">
                        <i class="fa-solid fa-user-circle"></i> {{ $heroPost->author }} &nbsp;|&nbsp; 
                        <i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($heroPost->created_at)->diffForHumans() }}
                    </div>
                    <p class="text-secondary">{{ $heroPost->excerpt }}</p>
                    <a href="#" class="btn btn-outline-light mt-2 rounded-pill px-4">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
        @endif

        {{-- BAGIAN 2: DAFTAR ARTIKEL LAINNYA --}}
        <div class="row">
            @foreach($gridPosts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div style="position: relative;">
                        <img src="{{ $post->image }}" class="img-cover" alt="Post Image">
                        <span class="badge badge-category bg-{{ explode(' ', $post->category)[0] }}">{{ $post->category }}</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between text-secondary small mb-2">
                             <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($post->created_at)->format('d M Y') }}</span>
                        </div>
                        <h5 class="card-title fw-bold text-white">{{ Str::limit($post->title, 40) }}</h5>
                        <p class="card-text text-secondary small">{{ Str::limit($post->excerpt, 80) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <small class="text-secondary"><i class="fa-solid fa-pen-nib"></i> {{ $post->author }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>