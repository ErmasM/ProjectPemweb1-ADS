<!doctype html>
<html lang="id" data-bs-theme="light">
<head>
    <title>Dashboard Overview</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap & FontAwesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    {{-- STYLE: CSS VARIABLE SAMA PERSIS DENGAN HALAMAN LAIN --}}
    <style>
        :root {
            --bg-body: #f0f2f5; --bg-pattern: radial-gradient(#d1d5db 1px, transparent 1px);
            --text-main: #212529; --text-secondary: #6c757d;
            --card-bg: #ffffff; --card-border: #e9ecef;
            --sidebar-bg: #ffffff; --sidebar-border: #e9ecef;
            --input-bg: #f8f9fa; --input-border: #ced4da;
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --active-item-bg: #e7f1ff; --active-item-text: #0d6efd;
        }
        [data-bs-theme="dark"] {
            --bg-body: #121212; --bg-pattern: radial-gradient(#333333 1px, transparent 1px);
            --text-main: #e0e0e0; --text-secondary: #a0a0a0;
            --card-bg: #1e1e1e; --card-border: #333333;
            --sidebar-bg: #1e1e1e; --sidebar-border: #333333;
            --input-bg: #2a2a2a; --input-border: #444;
            --shadow-soft: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
            --active-item-bg: rgba(13, 110, 253, 0.15); --active-item-text: #6ea8fe;
        }

        body { 
            background-color: var(--bg-body); background-image: var(--bg-pattern); 
            background-size: 24px 24px; color: var(--text-main); 
            font-family: 'Segoe UI', sans-serif; transition: 0.3s; 
        }

        /* LAYOUT */
        .dashboard-container { display: flex; min-height: 100vh; }
        
        /* SIDEBAR */
        .sidebar { 
            width: 260px; background-color: var(--sidebar-bg); border-right: 1px solid var(--sidebar-border); 
            display: flex; flex-direction: column; position: fixed; top: 0; bottom: 0; left: 0; 
            padding: 20px; z-index: 1000; transition: 0.3s; 
        }
        .sidebar-brand { font-size: 1.25rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--text-main); margin-bottom: 2rem; display: flex; align-items: center; }
        .nav-group-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); margin-top: 1.5rem; margin-bottom: 0.5rem; }
        .nav-item-link { display: flex; align-items: center; padding: 10px 15px; color: var(--text-secondary); text-decoration: none; border-radius: 8px; font-weight: 600; margin-bottom: 5px; transition: 0.2s; }
        .nav-item-link:hover { background-color: var(--bg-body); color: var(--text-main); }
        .nav-item-link.active { background-color: var(--active-item-bg); color: var(--active-item-text); }
        .nav-item-link i { width: 25px; text-align: center; margin-right: 10px; }

        /* CONTENT */
        .main-content { flex: 1; margin-left: 260px; padding: 30px; transition: 0.3s; }
        
        /* CARDS */
        .content-card { background-color: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 25px; box-shadow: var(--shadow-soft); height: 100%; transition: transform 0.2s; }
        .content-card:hover { transform: translateY(-3px); }
        
        .stat-icon-wrapper { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 15px; }

        /* BUTTONS & UTILS */
        .theme-toggle-btn { background: var(--card-bg); border: 1px solid var(--sidebar-border); color: var(--text-main); padding: 8px 12px; border-radius: 50px; cursor: pointer; box-shadow: var(--shadow-soft); position: absolute; top: 20px; right: 30px;}
        .btn-logout { margin-top: auto; border: 1px solid #dc3545; color: #dc3545; background: transparent; text-align: center; border-radius: 8px; padding: 8px; font-weight: 600; transition: 0.3s; }
        .btn-logout:hover { background: #dc3545; color: white; }
    </style>
</head>
<body>

<div class="dashboard-container">
    {{-- SIDEBAR --}}
    <nav class="sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-book-open-reader text-primary me-2"></i> Admin Panel
        </div>
        
        <div class="nav-group-label">Katalog</div>
        {{-- MENU DASHBOARD AKTIF --}}
        <a href="{{ route('dashboard') }}" class="nav-item-link active">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>
        <a href="{{ route('dashboard.books') }}" class="nav-item-link">
            <i class="fa-solid fa-book"></i> Kelola Buku
        </a>
        <a href="{{ route('dashboard.articles') }}" class="nav-item-link">
            <i class="fa-regular fa-newspaper"></i> Kelola Artikel
        </a>

        <div class="nav-group-label">Aktivitas</div>
        <a href="{{ route('dashboard.loans') }}" class="nav-item-link">
            <i class="fa-solid fa-hand-holding-hand"></i> Peminjaman
        </a>
        <a href="{{ route('dashboard.comments') }}" class="nav-item-link">
            <i class="fa-regular fa-comments"></i> Komentar
        </a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto w-100">
            @csrf
            <button type="submit" class="btn-logout w-100">
                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> KELUAR
            </button>
        </form>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="main-content position-relative">
        {{-- Theme Toggle Button --}}
        <button class="theme-toggle-btn" id="themeToggle"><i class="fa-solid fa-moon" id="themeIcon"></i></button>

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <div>
                <h3 class="fw-bold mb-0">Dashboard Overview</h3>
                <p class="text-secondary small mb-0">{{ now()->format('l, d F Y') }}</p>
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="row g-4 mb-4">
            {{-- Card 1: Total Koleksi --}}
            <div class="col-md-4">
                <div class="content-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-secondary small fw-bold text-uppercase">Total Koleksi</span>
                            <h2 class="fw-bold mt-2 mb-0 display-6">{{ $posts_count ?? 0 }}</h2>
                        </div>
                        <div class="stat-icon-wrapper bg-primary bg-opacity-10 text-primary">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Peminjaman Aktif --}}
            <div class="col-md-4">
                <div class="content-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-secondary small fw-bold text-uppercase">Peminjaman Aktif</span>
                            <h2 class="fw-bold mt-2 mb-0 display-6">{{ $loans_count ?? 0 }}</h2>
                        </div>
                        <div class="stat-icon-wrapper bg-warning bg-opacity-10 text-warning">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 3: Komentar --}}
            <div class="col-md-4">
                <div class="content-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-secondary small fw-bold text-uppercase">Komentar Masuk</span>
                            <h2 class="fw-bold mt-2 mb-0 display-6">{{ $comments_count ?? 0 }}</h2>
                        </div>
                        <div class="stat-icon-wrapper bg-success bg-opacity-10 text-success">
                            <i class="fa-regular fa-comments"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Welcome / Info Banner --}}
        <div class="content-card border-start border-4 border-info">
            <div class="d-flex">
                <div class="me-3 mt-1">
                    <i class="fa-solid fa-circle-info text-info fs-4"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Selamat Datang, Admin!</h5>
                    <p class="text-secondary mb-0">
                        Sistem berjalan dengan baik. Anda dapat mengelola data buku, artikel, dan memantau peminjaman melalui menu sidebar di sebelah kiri.
                        Pastikan memeriksa status peminjaman secara berkala.
                    </p>
                </div>
            </div>
        </div>

    </main>
</div>

{{-- SCRIPT THEME TOGGLE (SAMA) --}}
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