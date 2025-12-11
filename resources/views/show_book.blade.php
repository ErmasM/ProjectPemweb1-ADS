<!doctype html>
<html lang="id" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $book->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* VARIABLES */
        :root {
            --bg-body: #f0f2f5; --bg-pattern: radial-gradient(#e5e7eb 1px, transparent 1px);
            --text-main: #212529; --text-secondary: #6c757d;
            --card-bg: #ffffff; --card-border: #e9ecef;
            --input-bg: #f8f9fa; --input-border: #ced4da;
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        [data-bs-theme="dark"] {
            --bg-body: #121212; --bg-pattern: radial-gradient(#2a2a2a 1px, transparent 1px);
            --text-main: #e0e0e0; --text-secondary: #b0b0b0;
            --card-bg: #1e1e1e; --card-border: #333333;
            --input-bg: #2a2a2a; --input-border: #444;
            --shadow-soft: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }

        body { background-color: var(--bg-body); background-image: var(--bg-pattern); background-size: 20px 20px; color: var(--text-main); font-family: 'Segoe UI', sans-serif; transition: 0.3s; }
        
        .book-cover-detail { width: 100%; border-radius: 15px; box-shadow: var(--shadow-soft); border: 1px solid var(--card-border); }
        .info-box { background: var(--card-bg); padding: 30px; border-radius: 15px; border: 1px solid var(--card-border); box-shadow: var(--shadow-soft); }
        
        .btn-back { text-decoration: none; color: var(--text-secondary); font-weight: 600; margin-bottom: 20px; display: inline-block; }
        .btn-back:hover { color: var(--text-main); }
        
        .status-badge { background: #198754; color: #fff; padding: 5px 15px; border-radius: 20px; font-size: 0.9rem; }
        .avatar-comment { width: 40px; height: 40px; background: linear-gradient(135deg, #666, #333); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #fff; flex-shrink: 0; }
        .btn-delete { background:none; border:none; color:#dc3545; font-size:0.8rem; padding:0; margin-left:10px; text-decoration:underline; }

        .footer-toggle-btn { background: transparent; border: 1px solid var(--text-secondary); color: var(--text-secondary); padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; cursor: pointer; transition: 0.3s; margin-left: 15px; }
        .footer-toggle-btn:hover { background: var(--text-secondary); color: var(--bg-body); }
        
        .form-control { background-color: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-main); }
        .form-control:focus { background-color: var(--card-bg); border-color: #0d6efd; color: var(--text-main); box-shadow: none; }

    </style>
  </head>
  <body>

    <div class="container mt-5 mb-5">
        <a href="{{ route('home') }}" class="btn-back"><i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Katalog</a>

        <div class="row">
            {{-- COVER BUKU --}}
            <div class="col-md-4 mb-4">
                <img src="{{ $book->image }}" class="book-cover-detail">
            </div>

            {{-- INFO DETAIL --}}
            <div class="col-md-8">
                <div class="info-box">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-warning text-dark">{{ $book->category }}</span>
                        <span class="status-badge"><i class="fa-solid fa-check-circle me-1"></i> Tersedia</span>
                    </div>

                    <h1 class="fw-bold display-5 mb-2" style="color: var(--text-main);">{{ $book->title }}</h1>
                    <h5 style="color: var(--text-secondary);">Oleh: <span style="color: var(--text-main);">{{ $book->author }}</span></h5>
                    <hr style="border-color: var(--card-border);">

                    <h5 class="fw-bold mt-4 mb-3" style="color: var(--text-main);">Sinopsis Buku</h5>
                    <p style="color: var(--text-secondary); line-height: 1.8;">{!! nl2br(e($book->body)) !!}</p>

                   <div class="mt-5">
                       @auth
                           <div class="d-flex gap-2">
                               <form action="{{ route('borrow.store', $book->id) }}" method="POST" class="flex-grow-1">
                                   @csrf <input type="hidden" name="post_id" value="{{ $book->id }}">
                                   <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">PINJAM BUKU INI</button>
                               </form>
                               <form action="{{ route('post.favorite', $book->id) }}" method="POST">
                                   @csrf
                                   <button class="btn btn-lg px-4" style="background-color: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-main);" title="Favoritkan">
                                       @if(Auth::user()->favorites->contains($book->id)) <i class="fa-solid fa-heart text-danger fs-4"></i> @else <i class="fa-regular fa-heart fs-4"></i> @endif
                                   </button>
                               </form>
                           </div>
                       @else
                           <a href="{{ route('login') }}" class="btn btn-warning btn-lg w-100 fw-bold">LOGIN UNTUK PINJAM</a>
                       @endauth
                    </div>

                {{-- ULASAN --}}
                <div class="mt-5">
                    <h4 class="fw-bold mb-4" style="color: var(--text-main);">Ulasan Pembaca ({{ count($comments) }})</h4>
                    
                    @auth
                    <form action="{{ route('comments.store') }}" method="POST" class="mb-4">
                        @csrf <input type="hidden" name="post_id" value="{{ $book->id }}">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" readonly style="opacity:0.7">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="body" class="form-control" placeholder="Tulis ulasan..." required>
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary w-100">Kirim</button></div>
                        </div>
                    </form>
                    @endauth

                    @foreach($comments as $comment)
                    <div class="d-flex gap-3 mb-3 border-bottom pb-3" style="border-color: var(--card-border) !important;">
                        <div class="avatar-comment">{{ substr($comment->name ?? 'A', 0, 1) }}</div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold mb-0" style="color: var(--text-main);">{{ $comment->name }}</h6>
                                <small style="color: var(--text-secondary);">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0 small" style="color: var(--text-secondary);">{{ $comment->body }}</p>
                            @auth @if(Auth::user()->role === 'admin')
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE') <button class="btn-delete">Hapus</button>
                                </form>
                            @endif @endauth
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    {{-- FOOTER SIMPLE DENGAN TOGGLE --}}
    <footer class="text-center py-4 border-top mt-5" style="background-color: var(--card-bg); border-color: var(--card-border) !important;">
        <div class="container d-flex justify-content-center align-items-center">
            <small style="color: var(--text-secondary);">&copy; {{ date('Y') }} E-Library.</small>
            <button class="footer-toggle-btn" id="themeToggle"><i class="fa-solid fa-moon me-1" id="themeIcon"></i> Mode</button>
        </div>
    </footer>

    <script>
        const storedTheme = localStorage.getItem('theme');
        const getPreferredTheme = () => storedTheme ? storedTheme : (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        const setTheme = function (theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            const toggleBtn = document.getElementById('themeIcon');
            if (theme === 'dark') { toggleBtn.classList.remove('fa-moon'); toggleBtn.classList.add('fa-sun'); } 
            else { toggleBtn.classList.remove('fa-sun'); toggleBtn.classList.add('fa-moon'); }
        };
        setTheme(getPreferredTheme());
        document.getElementById('themeToggle').addEventListener('click', () => {
            const newTheme = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            setTheme(newTheme); localStorage.setItem('theme', newTheme);
        });
    </script>
  </body>
</html>