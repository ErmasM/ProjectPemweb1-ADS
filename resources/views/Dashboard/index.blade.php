<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #0f0f0f; color: #eee; }
        
        /* SIDEBAR STYLE */
        .sidebar { height: 100vh; background: #1a1a1a; border-right: 1px solid #333; position: fixed; width: 250px; padding: 20px; }
        .main-content { margin-left: 250px; padding: 40px; }
        .nav-link { color: #aaa; padding: 10px 15px; border-radius: 8px; margin-bottom: 5px; text-decoration: none; display: block; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: #fff; }
        
        /* Card Style */
        .card-stat { background: #1a1a1a; border: 1px solid #333; border-radius: 10px; transition: transform 0.2s; }
        .card-stat:hover { transform: translateY(-5px); border-color: #555; }
    </style>
</head>
<body>

    {{-- SIDEBAR ADMIN --}}
    <div class="sidebar d-flex flex-column">
        <h4 class="fw-bold text-white mb-5"><i class="fa-solid fa-rocket me-2"></i>Admin Panel</h4>
        
        {{-- Menu Dashboard Aktif --}}
        <a href="{{ route('dashboard') }}" class="nav-link active">
            <i class="fa-solid fa-gauge me-2"></i> Dashboard
        </a>
        
        {{-- MENU BARU: BUKU (Ganti dashboard.posts jadi dashboard.books) --}}
        <a href="{{ route('dashboard.books') }}" class="nav-link">
            <i class="fa-solid fa-book me-2"></i> Kelola Buku
        </a>

        {{-- MENU BARU: ARTIKEL (Ganti dashboard.posts jadi dashboard.articles) --}}
        <a href="{{ route('dashboard.articles') }}" class="nav-link">
            <i class="fa-solid fa-newspaper me-2"></i> Kelola Artikel
        </a>

        <a href="{{ route('dashboard.loans') }}" class="nav-link">
            <i class="fa-solid fa-clipboard-list me-2"></i> Peminjaman
        </a>
        <a href="{{ route('dashboard.comments') }}" class="nav-link">
            <i class="fa-solid fa-comments me-2"></i> Komentar
        </a>
        
        <div class="mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger w-100"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
            </form>
        </div>
    </div>

    {{-- KONTEN UTAMA --}}
    <div class="main-content">
        <h3 class="mb-4">👋 Selamat Datang, Admin!</h3>

        {{-- WIDGETS STATISTIK --}}
        <div class="row mb-5">
            
            {{-- Widget 1: Total Pustaka --}}
            <div class="col-md-4">
                <div class="card card-stat p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-25 p-3 rounded me-3 text-primary">
                            <i class="fa-solid fa-book fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-secondary mb-1">Total Koleksi</h6>
                            <h3 class="fw-bold mb-0">{{ $posts_count ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Widget 2: Peminjaman --}}
            <div class="col-md-4">
                <div class="card card-stat p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-25 p-3 rounded me-3 text-warning">
                            <i class="fa-solid fa-hand-holding-hand fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-secondary mb-1">Peminjaman Aktif</h6>
                            <h3 class="fw-bold mb-0">{{ $loans_count ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Widget 3: Komentar --}}
            <div class="col-md-4">
                <div class="card card-stat p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-25 p-3 rounded me-3 text-success">
                            <i class="fa-solid fa-comments fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-secondary mb-1">Komentar Masuk</h6>
                            <h3 class="fw-bold mb-0">{{ $comments_count ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- AREA INFO TAMBAHAN --}}
        <div class="card bg-dark border-secondary">
            <div class="card-header border-secondary bg-transparent">
                <h5 class="mb-0"><i class="fa-solid fa-circle-info me-2 text-info"></i> Informasi Sistem</h5>
            </div>
            <div class="card-body">
                <p class="text-secondary mb-0">
                    Halo Admin, Anda sedang berada di panel pengelolaan. Gunakan sidebar di sebelah kiri untuk mengelola data buku, memantau peminjaman yang masuk, atau memoderasi komentar pengguna.
                </p>
            </div>
        </div>

    </div>

</body>
</html>