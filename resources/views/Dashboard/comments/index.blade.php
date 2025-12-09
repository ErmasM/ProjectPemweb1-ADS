<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Kelola Komentar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #0f0f0f; color: #eee; }
        
        /* SIDEBAR (Sama kayak halaman dashboard lain) */
        .sidebar { height: 100vh; background: #1a1a1a; border-right: 1px solid #333; position: fixed; width: 250px; padding: 20px; }
        .main-content { margin-left: 250px; padding: 40px; }
        .nav-link { color: #aaa; padding: 10px 15px; border-radius: 8px; margin-bottom: 5px; text-decoration: none; display: block; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: #fff; }
        
        /* TABLE STYLE */
        .table-dark { --bs-table-bg: #1a1a1a; border-color: #333; }
        .comment-text { font-size: 0.9rem; color: #ccc; font-style: italic; }
    </style>
</head>
<body>

    {{-- SIDEBAR KIRI --}}
    <div class="sidebar d-flex flex-column">
        <h4 class="fw-bold text-white mb-5"><i class="fa-solid fa-rocket me-2"></i>Admin Panel</h4>
        
        <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="fa-solid fa-gauge me-2"></i> Dashboard
        </a>
        <a href="{{ route('dashboard.posts') }}" class="nav-link">
            <i class="fa-solid fa-book me-2"></i> Kelola Pustaka
        </a>
        <a href="{{ route('dashboard.comments') }}" class="nav-link active">
            <i class="fa-solid fa-comments me-2"></i> Komentar
        </a>
        
        <div class="mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger w-100"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
            </form>
        </div>
    </div>

    {{-- KONTEN KANAN --}}
    <div class="main-content">
        <div class="d-flex justify-content-between mb-4">
            <h3>💬 Kelola Komentar Masuk</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card bg-dark border-secondary">
            <div class="card-body p-0">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Pengirim</th>
                            <th>Isi Komentar</th>
                            <th width="15%">Di Buku/Artikel</th>
                            <th width="15%">Tanggal</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $index => $comment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $comment->name }}</td>
                            <td><span class="comment-text">"{{ Str::limit($comment->body, 50) }}"</span></td>
                            <td>
                                {{-- Menampilkan judul post terkait (jika ada) --}}
                                @if($comment->post)
                                    <a href="{{ route('posts.show', $comment->post_id) }}" class="text-decoration-none text-info small" target="_blank">
                                        {{ Str::limit($comment->post->title, 20) }} <i class="fa-solid fa-up-right-from-square ms-1"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">Terhapus</span>
                                @endif
                            </td>
                            <td class="small text-secondary">{{ $comment->created_at->format('d M Y') }}</td>
                            <td>
                                <form action="{{ route('dashboard.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Yakin hapus komentar ini?');">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-secondary">
                                <i class="fa-regular fa-comment-dots fa-3x mb-3"></i><br>
                                Belum ada komentar yang masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>