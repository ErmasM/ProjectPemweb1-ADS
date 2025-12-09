<!doctype html>
<html lang="id" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Library Kelompok 13</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* --- WARNA DASAR --- */
        body { background-color: #111; color: #eee; font-family: 'Segoe UI', sans-serif; }
        
        /* --- NAVBAR BARU (WARNA GRADASI) --- */
        .navbar { 
            /* Gradasi Biru Gelap ke Hitam Abu - Cocok untuk E-Library */
            background: linear-gradient(90deg, #0f2027, #203a43, #2c5364);
            padding: 15px 0; 
            border-bottom: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        }
        .nav-link { 
            color: #ccc; font-weight: 700; font-size: 0.85rem; 
            text-transform: uppercase; margin: 0 15px; letter-spacing: 1px; 
            transition: 0.3s;
        }
        .nav-link:hover, .nav-link.active { color: #fff; text-shadow: 0 0 10px rgba(255,255,255,0.5); }

        /* --- HERO SLIDER --- */
        .hero-card {
            background-color: #1a1a1a;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #333;
            height: 480px !important; 
        }
        .hero-img-col { padding: 0; height: 100%; }
        .hero-img { width: 100%; height: 100% !important; object-fit: cover; object-position: center; }
        .hero-content-col { padding: 50px; display: flex; flex-direction: column; justify-content: center; height: 100%; }

        /* --- PILLS TAB --- */
        .nav-pills .nav-link {
            background-color: #1a1a1a; color: #aaa; border: 1px solid #333; 
            margin: 0 10px; border-radius: 30px; padding: 10px 25px; font-weight: bold; transition: 0.3s;
        }
        .nav-pills .nav-link.active {
            background-color: #0d6efd; color: #fff; border-color: #0d6efd;
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
        }

        /* --- CARDS --- */
        .blog-card { background-color: #1a1a1a; border-radius: 12px; overflow: hidden; transition: 0.3s; height: 100%; border: 1px solid #333; }
        .blog-card:hover { transform: translateY(-5px); border-color: #666; }
        .blog-img { height: 220px; object-fit: cover; width: 100%; }

        .book-card { background: transparent; border: none; transition: transform 0.3s; }
        .book-card:hover { transform: translateY(-5px); }
        .book-cover-wrapper { overflow: hidden; border-radius: 8px; aspect-ratio: 2/3; margin-bottom: 15px; position: relative; box-shadow: 0 10px 20px rgba(0,0,0,0.5); }
        .book-cover { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
        .book-card:hover .book-cover { transform: scale(1.05); }

        .badge-cat { font-size: 0.7rem; padding: 6px 10px; border-radius: 4px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; }
        .bg-Teknologi { background-color: #0d6efd; } .bg-Kesehatan { background-color: #198754; } .bg-Bisnis { background-color: #ffc107; color: #000; }
        .bg-Travel { background-color: #0dcaf0; color: #000; } .bg-Gaya { background-color: #d63384; } .bg-Resensi { background-color: #6610f2; }
        .bg-Info { background-color: #17a2b8; } .bg-Event { background-color: #fd7e14; }

        .carousel-indicators { bottom: 20px; }
        .carousel-indicators button { width: 8px !important; height: 8px !important; border-radius: 50%; background-color: #888; margin: 0 5px; opacity: 0.5; border: none; }
        .carousel-indicators .active { background-color: #fff; opacity: 1; }
    </style>
  </head>
  <body>

    {{-- NAVBAR SERAGAM (HEADER) --}}
    <nav class="navbar navbar-expand-lg sticky-top">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div style="line-height: 1.2;">
                <span class="d-block fw-bold text-white text-uppercase" style="letter-spacing: 2px; font-size: 1.1rem;">E-Library</span>
            </div>
        </a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item"><a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">BERANDA</a></li>
              <li class="nav-item"><a class="nav-link {{ Route::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">KONTAK</a></li>
              <li class="nav-item"><a class="nav-link {{ Route::is('login') ? 'active' : '' }}" href="{{ route('login') }}">LOGIN</a></li>
            </ul>
        </div>
        <div class="d-none d-lg-block" style="width: 200px;"></div> 
      </div>
    </nav>

    <div class="container mt-4">
        {{-- SLIDER UTAMA --}}
        <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($sliderPosts as $key => $post)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <div class="hero-card row g-0">
                        <div class="col-lg-7 hero-img-col">
                            <a href="{{ route('posts.show', $post->id) }}"><img src="{{ $post->image }}" class="hero-img"></a>
                        </div>
                        <div class="col-lg-5 hero-content-col">
                            <div>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge-cat bg-{{ explode(' ', $post->category)[0] }}">{{ $post->category }}</span>
                                    <span class="text-secondary ms-3 small"><i class="fa-regular fa-clock me-1"></i> 2 menit baca</span>
                                </div>
                                <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-white">
                                    <h2 class="fw-bold mb-3 lh-sm">{{ Str::limit($post->title, 60) }}</h2>
                                </a>
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;"><i class="fa-solid fa-user text-white"></i></div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-white fw-bold">{{ $post->author }}</h6>
                                        <small class="text-secondary">{{ \Carbon\Carbon::parse($post->created_at)->format('d F, Y') }}</small>
                                    </div>
                                </div>
                                <p class="text-secondary small">{{ Str::limit($post->excerpt, 130) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="carousel-indicators">
                @foreach($sliderPosts as $key => $post)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>
        </div>

        {{-- NAVIGASI TAB --}}
        <ul class="nav nav-pills mb-5 justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item"><button class="nav-link active" id="pills-blog-tab" data-bs-toggle="pill" data-bs-target="#pills-blog"><i class="fa-solid fa-newspaper me-2"></i> ARTIKEL & BERITA</button></li>
            <li class="nav-item"><button class="nav-link" id="pills-book-tab" data-bs-toggle="pill" data-bs-target="#pills-book"><i class="fa-solid fa-book me-2"></i> KATALOG BUKU</button></li>
        </ul>

        {{-- KONTEN TAB --}}
        <div class="tab-content mb-5" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-blog">
                <div class="row">
                    @foreach($gridBlogPosts as $post)
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none">
                            <div class="blog-card">
                                <div style="position: relative;">
                                    <img src="{{ $post->image }}" class="blog-img">
                                    <div style="position: absolute; bottom: 10px; left: 10px;"><span class="badge-cat bg-{{ explode(' ', $post->category)[0] }}">{{ $post->category }}</span></div>
                                </div>
                                <div class="p-4">
                                    <h5 class="fw-bold text-white mb-2">{{ Str::limit($post->title, 50) }}</h5>
                                    <div class="d-flex align-items-center mt-3"><i class="fa-solid fa-user-circle text-secondary me-2"></i><small class="text-secondary">{{ $post->author }}</small></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="pills-book">
                <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-4">
                    @foreach($bookCollections as $book)
                    <div class="col">
                        <a href="{{ route('posts.show', $book->id) }}" class="text-decoration-none">
                            <div class="book-card text-center">
                                <div class="book-cover-wrapper">
                                    <img src="{{ $book->image }}" class="book-cover">
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2 shadow-sm" style="font-size: 0.6rem;">Tersedia</span>
                                </div>
                                <h6 class="text-white fw-bold mb-1 text-truncate" title="{{ $book->title }}">{{ $book->title }}</h6>
                                <small class="text-secondary d-block mb-3">{{ $book->author }}</small>
                                <button class="btn btn-outline-primary btn-sm w-100 rounded-pill"><i class="fa-solid fa-eye me-1"></i> Lihat Detail</button>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>