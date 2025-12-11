<!doctype html>
<html lang="id" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        /* --- CSS VARIABLES (SAMA DENGAN HOME) --- */
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
        
        .article-img { width: 100%; height: 450px; object-fit: cover; border-radius: 15px; margin-bottom: 30px; box-shadow: var(--shadow-soft); }
        .content { font-size: 1.15rem; line-height: 1.9; color: var(--text-main); }
        
        .btn-back { 
            border: 1px solid var(--card-border); color: var(--text-secondary); border-radius: 20px; text-decoration: none; padding: 8px 20px; transition: 0.3s;
            display: inline-flex; align-items: center; background: var(--card-bg);
        }
        .btn-back:hover { background: var(--card-border); color: var(--text-main); transform: translateX(-5px); }

        /* KOMENTAR */
        .comment-box { background-color: var(--card-bg); border-radius: 15px; padding: 30px; margin-top: 50px; border: 1px solid var(--card-border); box-shadow: var(--shadow-soft); }
        .comment-item { border-bottom: 1px solid var(--card-border); padding: 20px 0; display: flex; gap: 15px; }
        .comment-item:last-child { border-bottom: none; }
        
        .avatar-comment {
            width: 45px; height: 45px; background: linear-gradient(135deg, #666, #333);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 1.2rem; color: #fff; flex-shrink: 0;
        }

        .form-control { background-color: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-main); }
        .form-control:focus { background-color: var(--card-bg); border-color: #0d6efd; color: var(--text-main); box-shadow: none; }
        
        .btn-delete { background: none; border: none; color: #dc3545; font-size: 0.85rem; padding: 0; margin-left: 10px; cursor: pointer; text-decoration: underline; }
        
        /* FOOTER TOGGLE */
        .footer-toggle-btn { background: transparent; border: 1px solid var(--text-secondary); color: var(--text-secondary); padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; cursor: pointer; transition: 0.3s; margin-left: 15px; }
        .footer-toggle-btn:hover { background: var(--text-secondary); color: var(--bg-body); }
    </style>
  </head>
  <body>
    
    <div class="container mt-5 mb-5">
        <a href="{{ route('home') }}" class="btn-back mb-4"><i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Beranda</a>
        
        <div class="row justify-content-center">
            <div class="col-lg-9">
                {{-- HEADER ARTIKEL --}}
                <span class="badge bg-primary mb-2">{{ $post->category }}</span>
                <h1 class="fw-bold display-5 mb-3 lh-sm" style="color: var(--text-main);">{{ $post->title }}</h1>
                <div class="mb-4 pb-3 border-bottom" style="color: var(--text-secondary); border-color: var(--card-border) !important;">
                    <i class="fa-solid fa-user-circle me-1"></i> {{ $post->author }} &nbsp;|&nbsp; 
                    <i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($post->created_at)->format('d F Y') }}
                </div>
                
                <img src="{{ $post->image }}" class="article-img">
                
                {{-- CARD ACTION (PINJAM/LIKE) --}}
                @auth
                    @if(Auth::user()->role !== 'admin')
                    <div class="mb-5 text-center p-4" style="background: var(--card-bg); border-radius: 12px; border: 1px dashed var(--card-border);">
                        @php $isBook = in_array($post->category, ['Koleksi Baru', 'Resensi', 'Koleksi', 'Koleksi Umum']); @endphp

                        <h4 class="fw-bold mb-3" style="color: var(--text-main);">
                            {{ $isBook ? 'Tertarik membaca buku ini?' : 'Suka dengan artikel ini?' }}
                        </h4>
                        
                        <div class="d-flex justify-content-center gap-2">
                            @if($isBook)
                                <form action="{{ route('borrow.store', $post->id) }}" method="POST" class="flex-grow-1" style="max-width: 400px;">
                                    @csrf <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill fw-bold shadow"><i class="fa-solid fa-book-bookmark me-2"></i> AJUKAN PEMINJAMAN</button>
                                </form>
                            @endif

                            <form action="{{ route('post.favorite', $post->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-lg rounded-pill px-4" style="background-color: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-main);" title="Favoritkan">
                                    @if(Auth::user()->favorites->contains($post->id)) <i class="fa-solid fa-heart text-danger fs-4"></i> @else <i class="fa-regular fa-heart fs-4"></i> @endif
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                @endauth

                {{-- KONTEN --}}
                <div class="content mb-5">
                    {!! nl2br(e($post->body)) !!}
                </div>

                {{-- KOMENTAR --}}
                <div class="comment-box">
                    <h4 class="fw-bold mb-4" style="color: var(--text-main);"><i class="fa-regular fa-comments me-2"></i>Komentar ({{ count($comments) }})</h4>
                    
                    <form action="{{ route('comments.store') }}" method="POST" class="mb-5">
                        @csrf <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="row g-2 mb-2">
                            <div class="col-md-4">
                                @auth
                                    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" readonly style="cursor: not-allowed; opacity: 0.7;">
                                @else
                                    <input type="text" name="name" class="form-control" placeholder="Nama Kamu" required>
                                @endauth
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="body" class="form-control" placeholder="Tulis komentar..." required>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">Kirim <i class="fa-solid fa-paper-plane ms-1"></i></button>
                        </div>
                    </form>

                    @forelse($comments as $comment)
                        <div class="comment-item">
                            <div class="avatar-comment">{{ substr($comment->name, 0, 1) }}</div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold" style="color: var(--text-main);">{{ $comment->name }}</h6>
                                    <small style="color: var(--text-secondary); font-size: 0.75rem">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 mt-1 small" style="color: var(--text-secondary);">{{ $comment->body }}</p>
                                @auth @if(Auth::user()->role === 'admin')
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE') <button class="btn-delete">Hapus</button>
                                    </form>
                                @endif @endauth
                            </div>
                        </div>
                    @empty
                        <p class="text-center py-3" style="color: var(--text-secondary);">Belum ada komentar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- FOOTER DENGAN TOGGLE DI BAWAH --}}
    <footer class="text-center py-4 border-top mt-5" style="background-color: var(--card-bg); border-color: var(--card-border) !important;">
        <div class="container d-flex justify-content-center align-items-center">
            <small style="color: var(--text-secondary);">&copy; {{ date('Y') }} E-Library Kelompok 13.</small>
            
            {{-- TOMBOL GANTI TEMA DI FOOTER --}}
            <button class="footer-toggle-btn" id="themeToggle" title="Ganti Mode Tampilan">
                <i class="fa-solid fa-moon me-1" id="themeIcon"></i> Mode Tampilan
            </button>
        </div>
    </footer>

    {{-- SCRIPT LOGIKA TEMA --}}
    <script>
        const storedTheme = localStorage.getItem('theme');
        const getPreferredTheme = () => storedTheme ? storedTheme : (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        const setTheme = function (theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            const toggleBtn = document.getElementById('themeIcon');
            // Logic icon
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