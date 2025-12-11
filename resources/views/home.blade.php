<!doctype html>
<html lang="id" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Library Kelompok 13</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        /* --- VARIABLES --- */
        :root {
            --bg-body: #f0f2f5; --bg-pattern: radial-gradient(#e5e7eb 1px, transparent 1px);
            --text-main: #212529; --text-secondary: #6c757d;
            --card-bg: #ffffff; --card-border: #e9ecef;
            --navbar-bg: rgba(255, 255, 255, 0.85); --navbar-border: rgba(0, 0, 0, 0.05);
            --input-bg: #f8f9fa; --input-border: #ced4da;
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        [data-bs-theme="dark"] {
            --bg-body: #121212; --bg-pattern: radial-gradient(#2a2a2a 1px, transparent 1px);
            --text-main: #e0e0e0; --text-secondary: #b0b0b0;
            --card-bg: #1e1e1e; --card-border: #333333;
            --navbar-bg: rgba(18, 18, 18, 0.85); --navbar-border: rgba(255, 255, 255, 0.05);
            --input-bg: #2a2a2a; --input-border: #444;
            --shadow-soft: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }

        body { background-color: var(--bg-body); background-image: var(--bg-pattern); background-size: 20px 20px; color: var(--text-main); font-family: 'Segoe UI', sans-serif; transition: 0.3s; }
        .navbar { background: var(--navbar-bg); backdrop-filter: blur(12px); border-bottom: 1px solid var(--navbar-border); padding: 15px 0; transition: 0.3s; }
        .nav-link { color: var(--text-secondary); font-weight: 600; text-transform: uppercase; margin: 0 10px; font-size: 0.85rem; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: var(--text-main); transform: translateY(-1px); }

        /* --- STYLING TOMBOL FLOATING (MENGAMBANG) --- */
        .floating-theme-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--card-bg);
            color: var(--text-main);
            border: 1px solid var(--card-border);
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 1050; /* Di atas elemen lain */
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .floating-theme-btn:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }
        
        /* Elemen Lain (Search, Cards, Tabs) sama seperti sebelumnya */
        .search-input { background-color: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-main); padding: 15px 25px; border-radius: 50px 0 0 50px; box-shadow: var(--shadow-soft); }
        .search-input:focus { background-color: var(--card-bg); color: var(--text-main); border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); }
        .search-btn { border-radius: 0 50px 50px 0; padding: 0 30px; font-weight: bold; box-shadow: var(--shadow-soft); z-index: 5; }
        .hero-card { background-color: var(--card-bg); border-radius: 16px; border: 1px solid var(--card-border); height: 450px; box-shadow: var(--shadow-soft); overflow: hidden; }
        .hero-img { width: 100%; height: 100%; object-fit: cover; mask-image: linear-gradient(to right, black 60%, transparent 100%); -webkit-mask-image: linear-gradient(to right, black 60%, transparent 100%); }
        .hero-content-col { background: var(--card-bg); display: flex; flex-direction: column; justify-content: center; height: 100%; padding: 40px; }
        .blog-card { background-color: var(--card-bg); border-radius: 12px; height: 100%; border: 1px solid var(--card-border); box-shadow: var(--shadow-soft); transition: 0.3s; overflow: hidden; }
        .blog-card:hover { transform: translateY(-5px); border-color: #0d6efd; }
        .book-card { background: transparent; border: none; transition: transform 0.3s; cursor: pointer; }
        .book-card:hover { transform: translateY(-5px); }
        .book-cover-wrapper { overflow: hidden; border-radius: 8px; aspect-ratio: 2/3; margin-bottom: 12px; position: relative; box-shadow: 0 8px 16px rgba(0,0,0,0.2); }
        .book-cover { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; }
        .book-card:hover .book-cover { transform: scale(1.08); }
        .nav-pills .nav-link { background-color: var(--card-bg); color: var(--text-secondary); border: 1px solid var(--card-border); margin: 0 5px; border-radius: 30px; padding: 10px 30px; font-weight: 600; }
        .nav-pills .nav-link.active { background-color: #0d6efd; color: #fff; border-color: #0d6efd; }
        .badge-cat { font-size: 0.7rem; padding: 6px 12px; border-radius: 4px; text-transform: uppercase; font-weight: 800; }
        .section-title { font-weight: 800; margin-bottom: 20px; border-left: 5px solid #0d6efd; padding-left: 15px; color: var(--text-main); }
    </style>
  </head>
  <body>

    {{-- NAVBAR (Tanpa Tombol Toggle) --}}
    <nav class="navbar navbar-expand-lg sticky-top">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <i class="fa-solid fa-book-open-reader text-primary me-3 fs-3"></i>
            <div style="line-height: 1.2;">
                <span class="d-block fw-bold text-uppercase" style="font-size: 1.2rem; color: var(--text-main);">E-Library</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav align-items-center">
              <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">Beranda</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Kontak</a></li>
              
              @auth
                  @if(Auth::user()->role === 'admin')
                     <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                  @else
                     <li class="nav-item"><a class="nav-link" href="{{ route('my.borrowings') }}">Buku Saya</a></li>
                  @endif
                  <li class="nav-item mx-2 border-start border-secondary opacity-50" style="height: 20px;"></li>
                  <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link bg-transparent border-0 text-danger" title="Keluar"><i class="fa-solid fa-power-off"></i></button>
                    </form>
                  </li>
              @else
                  <li class="nav-item"><a class="nav-link btn btn-outline-primary px-4 ms-3 text-primary" href="{{ route('login') }}" style="border-radius: 20px; border: 1px solid #0d6efd;">LOGIN</a></li>
              @endauth
            </ul>
        </div>
      </div>
    </nav>

    {{-- TOMBOL MENGAMBANG (FLOATING BUTTON) --}}
    <button class="floating-theme-btn" id="themeToggle" title="Ganti Tampilan">
        <i class="fa-solid fa-moon" id="themeIcon"></i>
    </button>

    <div class="container mt-5">
        {{-- SEARCH BAR --}}
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h3 class="fw-light mb-3" style="color: var(--text-main);">Temukan <span class="fw-bold text-primary">Jendela Dunia</span> di sini</h3>
                <form action="#" method="GET">
                    <div class="input-group input-group-lg">
                        <input type="text" name="q" class="form-control search-input" placeholder="Cari judul buku, penulis, atau topik..." aria-label="Search">
                        <button class="btn btn-primary search-btn" type="submit"><i class="fa-solid fa-search me-2"></i> CARI</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- HERO SLIDER --}}
        <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($sliderPosts as $key => $post)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <div class="hero-card row g-0">
                        <div class="col-lg-7 h-100 p-0">
                            <a href="{{ route('posts.show', $post->id) }}" class="h-100 d-block">
                                <img src="{{ $post->image }}" class="hero-img">
                            </a>
                        </div>
                        <div class="col-lg-5 hero-content-col">
                            <div>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge-cat bg-primary text-white">{{ $post->category }}</span>
                                    <span class="ms-3 small" style="color: var(--text-secondary);">{{ $post->created_at->format('d M Y') }}</span>
                                </div>
                                <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none">
                                    <h2 class="fw-bold mb-3 lh-sm display-6" style="color: var(--text-main);">{{ Str::limit($post->title, 55) }}</h2>
                                </a>
                                <p class="mb-4" style="color: var(--text-secondary); line-height: 1.6;">{{ Str::limit($post->excerpt ?? strip_tags($post->body), 100) }}</p>
                                <div class="d-flex align-items-center mt-auto">
                                    <div class="bg-secondary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fa-solid fa-user-pen text-primary"></i></div>
                                    <div class="ms-3"><h6 class="mb-0 fw-bold" style="color: var(--text-main);">{{ $post->author }}</h6></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" style="width: 5%;"><span class="carousel-control-prev-icon"></span></button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" style="width: 5%;"><span class="carousel-control-next-icon"></span></button>
        </div>

        {{-- KONTEN TABS --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="section-title mb-0">Jelajahi Koleksi</h4>
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item"><button class="nav-link active" id="pills-blog-tab" data-bs-toggle="pill" data-bs-target="#pills-blog">Artikel</button></li>
                <li class="nav-item"><button class="nav-link" id="pills-book-tab" data-bs-toggle="pill" data-bs-target="#pills-book">Buku</button></li>
            </ul>
        </div>

        <div class="tab-content mb-5" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-blog">
                <div class="row">
                    @foreach($gridBlogPosts as $post)
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none">
                            <div class="blog-card">
                                <div style="position: relative;">
                                    <img src="{{ $post->image }}" style="height: 200px; object-fit: cover; width: 100%;">
                                    <span class="badge bg-dark bg-opacity-75 shadow-sm position-absolute top-0 end-0 m-2">{{ $post->category }}</span>
                                </div>
                                <div class="p-4 d-flex flex-column h-100">
                                    <h5 class="fw-bold mb-2" style="color: var(--text-main);">{{ Str::limit($post->title, 50) }}</h5>
                                    <p class="small mb-3 flex-grow-1" style="color: var(--text-secondary);">{{ Str::limit(strip_tags($post->body), 80) }}</p>
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
                            <div class="book-card text-center h-100">
                                <div class="book-cover-wrapper"><img src="{{ $book->image }}" class="book-cover"></div>
                                <h6 class="fw-bold mb-1 text-truncate" style="color: var(--text-main);">{{ $book->title }}</h6>
                                <small style="color: var(--text-secondary);">{{ $book->author }}</small>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="text-center py-4 border-top mt-5" style="background-color: var(--card-bg); border-color: var(--navbar-border) !important;">
        <small style="color: var(--text-secondary);">&copy; {{ date('Y') }} E-Library Kelompok 13. All rights reserved.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // SCRIPT GANTI TEMA
        const storedTheme = localStorage.getItem('theme');
        const getPreferredTheme = () => storedTheme ? storedTheme : (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

        const setTheme = function (theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            const toggleBtn = document.getElementById('themeIcon');
            // Ganti icon
            if (theme === 'dark') {
                toggleBtn.classList.remove('fa-moon');
                toggleBtn.classList.add('fa-sun'); 
            } else {
                toggleBtn.classList.remove('fa-sun');
                toggleBtn.classList.add('fa-moon');
            }
        };

        setTheme(getPreferredTheme());

        // Event listener hanya ada di Home
        document.getElementById('themeToggle').addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
            localStorage.setItem('theme', newTheme);
        });
    </script>
  </body>
</html>