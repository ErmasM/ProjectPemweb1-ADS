<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #0f0f0f; color: #eee; }
        .sidebar { height: 100vh; background: #1a1a1a; border-right: 1px solid #333; position: fixed; width: 250px; padding: 20px; }
        .main-content { margin-left: 250px; padding: 40px; }
        .nav-link { color: #aaa; padding: 10px 15px; border-radius: 8px; margin-bottom: 5px; text-decoration: none; display: block; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: #fff; }
        
        /* KARTU STATISTIK */
        .stat-card { 
            background: #1a1a1a; border-radius: 15px; padding: 25px; 
            border: 1px solid #333; transition: transform 0.3s;
        }
        .stat-card:hover { transform: translateY(-5px); border-color: #0d6efd; }
    </style>
</head>
<body>

    {{-- SIDEBAR KIRI --}}
    <div class="sidebar d-flex flex-column">
        <h4 class="fw-bold text-white mb-5"><i class="fa-solid fa-rocket me-2"></i>Admin Panel</h4>
        
        <a href="{{ route('dashboard') }}" class="nav-link active">
            <i class="fa-solid fa-gauge me-2"></i> Dashboard
        </a>
        <a href="{{ route('dashboard.posts') }}" class="nav-link">
            <i class="fa-solid fa-book me-2"></i> Kelola Pustaka
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

    {{-- KONTEN KANAN --}}
    <div class="main-content">
        <h2 class="fw-bold mb-4">Selamat Datang, Pustakawan Kelompok 13! 👋</h2>
        
        <div class="row g-4">
            {{-- KARTU 1: TOTAL ARTIKEL --}}
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-secondary mb-0">Total Koleksi</h6>
                        <i class="fa-solid fa-book text-primary fa-2x"></i>
                    </div>
                    {{-- PANGGIL VARIABEL $total_posts --}}
                    <h1 class="fw-bold text-white mb-0">{{ $total_posts }}</h1>
                </div>
            </div>

            {{-- KARTU 2: TOTAL KOMENTAR (YANG TADI 0) --}}
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-secondary mb-0">Total Komentar</h6>
                        <i class="fa-solid fa-comments text-success fa-2x"></i>
                    </div>
                    {{-- PANGGIL VARIABEL $total_comments --}}
                    <h1 class="fw-bold text-white mb-0">{{ $total_comments }}</h1>
                </div>
            </div>

            {{-- KARTU 3: STATUS --}}
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-secondary mb-0">Status Server</h6>
                        <i class="fa-solid fa-server text-warning fa-2x"></i>
                    </div>
                    <h1 class="fw-bold text-warning mb-0">Online</h1>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-5 border-0 bg-dark text-light border-start border-4 border-info">
            <div class="d-flex">
                <i class="fa-solid fa-circle-info fa-lg mt-1 me-3 text-info"></i>
                <div>
                    <strong>Halo Admin!</strong><br>
                    Di sini kamu bisa melihat ringkasan data. Untuk mengelola data, silakan pilih menu di sebelah kiri.
                </div>
            </div>
        </div>
    </div>

</body>
</html>