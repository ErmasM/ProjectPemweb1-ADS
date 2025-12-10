<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    {{-- Mengambil judul dari Controller, jika tidak ada pakai default --}}
    <title>{{ $page_title ?? 'Kelola Pustaka' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #0f0f0f; color: #eee; }
        .sidebar { height: 100vh; background: #1a1a1a; border-right: 1px solid #333; position: fixed; width: 250px; padding: 20px; }
        .main-content { margin-left: 250px; padding: 40px; }
        .nav-link { color: #aaa; padding: 10px 15px; border-radius: 8px; margin-bottom: 5px; text-decoration: none; display: block; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: #fff; }
        .table-dark { --bs-table-bg: #1a1a1a; border-color: #333; }
    </style>
</head>
<body>

    {{-- SIDEBAR BARU (SUDAH DIPISAH) --}}
    <div class="sidebar d-flex flex-column">
        <h4 class="fw-bold text-white mb-5"><i class="fa-solid fa-rocket me-2"></i>Admin Panel</h4>
        
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
        
        {{-- Menu Buku --}}
        <a href="{{ route('dashboard.books') }}" class="nav-link {{ request()->routeIs('dashboard.books') ? 'active' : '' }}">
            <i class="fa-solid fa-book me-2"></i> Kelola Buku
        </a>

        {{-- Menu Artikel --}}
        <a href="{{ route('dashboard.articles') }}" class="nav-link {{ request()->routeIs('dashboard.articles') ? 'active' : '' }}">
            <i class="fa-solid fa-newspaper me-2"></i> Kelola Artikel
        </a>

        <a href="{{ route('dashboard.loans') }}" class="nav-link"><i class="fa-solid fa-clipboard-list me-2"></i> Peminjaman</a>
        <a href="{{ route('dashboard.comments') }}" class="nav-link"><i class="fa-solid fa-comments me-2"></i> Komentar</a>
        
        <div class="mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger w-100"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
            </form>
        </div>
    </div>

    {{-- KONTEN UTAMA --}}
    <div class="main-content">
        <div class="d-flex justify-content-between mb-4">
            {{-- Judul Halaman Dinamis (Buku/Artikel) --}}
            <h3>{{ $page_title ?? '📚 Kelola Data' }}</h3>
            <a href="{{ route('dashboard.posts.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Baru</a>
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
                            <th width="35%">Judul</th>
                            <th width="15%">Kategori</th>
                            <th width="20%">Penulis</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $index => $post)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-bold">{{ $post->title }}</span>
                                <div class="small text-secondary text-truncate" style="max-width: 250px;">{{ $post->excerpt }}</div>
                            </td>
                            <td><span class="badge bg-secondary">{{ $post->category }}</span></td>
                            <td>{{ $post->author }}</td>
                            <td>
                                <a href="{{ route('dashboard.posts.edit', $post->id) }}" class="btn btn-sm btn-warning me-1"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('dashboard.posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">
                                <i class="fa-solid fa-folder-open fa-3x mb-3"></i><br>
                                Data tidak ditemukan untuk kategori ini.
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