<!doctype html>
<html lang="id" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #0f0f0f; color: #e0e0e0; font-family: 'Segoe UI', sans-serif; }
        .article-img { width: 100%; height: 450px; object-fit: cover; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .content { font-size: 1.15rem; line-height: 1.9; color: #ccc; }
        
        .btn-back { 
            border: 1px solid #333; color: #aaa; border-radius: 20px; text-decoration: none; padding: 8px 20px; transition: 0.3s;
            display: inline-flex; align-items: center; background: #1a1a1a;
        }
        .btn-back:hover { background: #333; color: #fff; transform: translateX(-5px); }

        /* --- KOMENTAR SECTION --- */
        .comment-box {
            background-color: #161616;
            border-radius: 15px;
            padding: 30px;
            margin-top: 50px;
            border: 1px solid #333;
        }

        .comment-item {
            border-bottom: 1px solid #333;
            padding: 20px 0;
            display: flex;
            gap: 15px;
        }
        .comment-item:last-child { border-bottom: none; }
        
        .avatar-comment {
            width: 45px; height: 45px;
            background: linear-gradient(135deg, #666, #333);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 1.2rem; color: #fff;
            flex-shrink: 0;
        }

        .form-control { background-color: #222; border: 1px solid #444; color: #fff; }
        .form-control:focus { background-color: #2a2a2a; border-color: #0d6efd; color: #fff; box-shadow: none; }
        
        .btn-delete {
            background: none; border: none; color: #dc3545; font-size: 0.85rem;
            padding: 0; margin-left: 10px; cursor: pointer; text-decoration: underline;
        }
        .btn-delete:hover { color: #ff6b6b; }
    </style>
  </head>
  <body>
    
    <div class="container mt-5 mb-5">
        <a href="{{ route('home') }}" class="btn-back mb-4"><i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Beranda</a>
        
        <div class="row justify-content-center">
            <div class="col-lg-9">
                {{-- JUDUL & INFO --}}
                <span class="badge bg-primary mb-2">{{ $post->category }}</span>
                <h1 class="fw-bold display-5 mb-3 lh-sm">{{ $post->title }}</h1>
                <div class="text-secondary mb-4 pb-3 border-bottom border-secondary">
                    <i class="fa-solid fa-user-circle me-1"></i> {{ $post->author }} &nbsp;|&nbsp; 
                    <i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($post->created_at)->format('d F Y') }}
                </div>
                
                {{-- GAMBAR UTAMA --}}
                <img src="{{ $post->image }}" class="article-img">
                
                {{-- ISI ARTIKEL --}}
                <div class="content mb-5">
                    {!! nl2br(e($post->body)) !!}
                </div>


                {{-- === BAGIAN KOMENTAR === --}}
                <div class="comment-box">
                    <h4 class="fw-bold mb-4"><i class="fa-regular fa-comments me-2"></i>Komentar ({{ count($comments) }})</h4>
                    
                    {{-- 1. FORM ISI KOMENTAR --}}
                    <form action="{{ route('comments.store') }}" method="POST" class="mb-5">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        
                        <div class="row g-2 mb-2">
                            <div class="col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="Nama Kamu" required autocomplete="off">
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="body" class="form-control" placeholder="Tulis komentar di sini..." required autocomplete="off">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold">Kirim Komentar <i class="fa-solid fa-paper-plane ms-1"></i></button>
                        </div>
                    </form>

                    {{-- 2. DAFTAR KOMENTAR --}}
                    @if(count($comments) > 0)
                        @foreach($comments as $comment)
                        <div class="comment-item">
                            {{-- Avatar Inisial --}}
                            <div class="avatar-comment">
                                {{ substr($comment->name, 0, 1) }}
                            </div>
                            
                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold text-white">{{ $comment->name }}</h6>
                                    <small class="text-secondary" style="font-size: 0.75rem">
                                        {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                    </small>
                                </div>
                                
                                <p class="text-secondary mb-1 mt-1 small">{{ $comment->body }}</p>
                                
                                {{-- Tombol Delete --}}
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus komen ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-center text-secondary py-3">Belum ada komentar. Jadilah yang pertama!</p>
                    @endif

                </div>
                {{-- END KOMENTAR --}}

            </div>
        </div>
    </div>

  </body>
</html>