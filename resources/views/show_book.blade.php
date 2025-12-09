<!doctype html>
<html lang="id" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $book->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #0f0f0f; color: #eee; font-family: 'Segoe UI', sans-serif; }
        .navbar { background-color: #111; padding: 15px 0; border-bottom: 1px solid #222; }
        
        .book-cover-detail { 
            width: 100%; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.6); border: 1px solid #333;
        }
        .info-box { background: #1a1a1a; padding: 30px; border-radius: 15px; border: 1px solid #333; }
        
        .btn-back { text-decoration: none; color: #aaa; font-weight: 600; margin-bottom: 20px; display: inline-block; }
        .btn-back:hover { color: #fff; }
        
        .status-badge { background: #198754; color: #fff; padding: 5px 15px; border-radius: 20px; font-size: 0.9rem; }
    </style>
  </head>
  <body>

    <div class="container mt-5 mb-5">
        <a href="{{ route('home') }}" class="btn-back"><i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Katalog</a>

        <div class="row">
            {{-- KOLOM KIRI: COVER BUKU --}}
            <div class="col-md-4 mb-4">
                <img src="{{ $book->image }}" class="book-cover-detail">
            </div>

            {{-- KOLOM KANAN: INFO DETAIL --}}
            <div class="col-md-8">
                <div class="info-box">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-warning text-dark">{{ $book->category }}</span>
                        <span class="status-badge"><i class="fa-solid fa-check-circle me-1"></i> Tersedia</span>
                    </div>

                    <h1 class="fw-bold display-5 mb-2">{{ $book->title }}</h1>
                    <h5 class="text-secondary mb-4">Oleh: <span class="text-white">{{ $book->author }}</span></h5>

                    <hr class="border-secondary">

                    <h5 class="fw-bold mt-4 mb-3">Sinopsis Buku</h5>
                    <p class="text-secondary" style="line-height: 1.8;">
                        {{ $book->body }} <!-- Isi 'body' di database dianggap sinopsis -->
                    </p>

                   <div class="mt-5">
                       @auth
                           <form action="{{ route('borrow.store') }}" method="POST">
                               @csrf
                              <input type="hidden" name="post_id" value="{{ $book->id }}">
                              <button class="btn btn-primary btn-lg w-100">PINJAM BUKU INI</button>
                           </form>
                       @else
                           <a href="{{ route('login') }}" class="btn btn-warning btn-lg w-100">LOGIN UNTUK PINJAM</a>
                       @endauth
                    </div>

                {{-- KOMENTAR / ULASAN --}}
                <div class="mt-5">
                    <h4 class="fw-bold mb-4">Ulasan Pembaca ({{ count($comments) }})</h4>
                    
                    {{-- Form Komentar --}}
                    <form action="{{ route('comments.store') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $book->id }}">
                        <div class="row g-2">
                            <div class="col-md-4"><input type="text" name="name" class="form-control bg-dark text-white border-secondary" placeholder="Nama Kamu" required></div>
                            <div class="col-md-6"><input type="text" name="body" class="form-control bg-dark text-white border-secondary" placeholder="Tulis ulasan singkat..." required></div>
                            <div class="col-md-2"><button class="btn btn-primary w-100">Kirim</button></div>
                        </div>
                    </form>

                    {{-- List Komentar --}}
                    @foreach($comments as $comment)
                    <div class="d-flex gap-3 mb-3 border-bottom border-secondary pb-3">
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 40px; height: 40px; flex-shrink: 0;">
                            {{ substr($comment->name, 0, 1) }}
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-white">{{ $comment->name }}</h6>
                            <p class="text-secondary mb-0 small">{{ $comment->body }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

  </body>
</html>