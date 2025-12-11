<!doctype html>
<html lang="id" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buku Saya - E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        /* CSS VARIABLE (SAMA) */
        :root {
            --bg-body: #f0f2f5; --bg-pattern: radial-gradient(#e5e7eb 1px, transparent 1px);
            --text-main: #212529; --text-secondary: #6c757d;
            --card-bg: #ffffff; --card-border: #e9ecef;
            --navbar-bg: rgba(255, 255, 255, 0.85); --navbar-border: rgba(0, 0, 0, 0.05);
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        [data-bs-theme="dark"] {
            --bg-body: #121212; --bg-pattern: radial-gradient(#2a2a2a 1px, transparent 1px);
            --text-main: #e0e0e0; --text-secondary: #b0b0b0;
            --card-bg: #1e1e1e; --card-border: #333333;
            --navbar-bg: rgba(18, 18, 18, 0.85); --navbar-border: rgba(255, 255, 255, 0.05);
            --shadow-soft: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }

        body { background-color: var(--bg-body); background-image: var(--bg-pattern); background-size: 20px 20px; color: var(--text-main); font-family: 'Segoe UI', sans-serif; transition: 0.3s; }
        .navbar { background: var(--navbar-bg); backdrop-filter: blur(12px); border-bottom: 1px solid var(--navbar-border); padding: 15px 0; transition: 0.3s; }
        .nav-link { color: var(--text-secondary); font-weight: 600; text-transform: uppercase; margin: 0 10px; font-size: 0.85rem; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: var(--text-main); transform: translateY(-1px); }
        .theme-toggle-btn { background: transparent; border: 1px solid var(--text-secondary); color: var(--text-main); padding: 5px 10px; border-radius: 20px; cursor: pointer; transition: 0.3s; }
        .theme-toggle-btn:hover { background: var(--text-secondary); color: var(--bg-body); }

        /* Custom Table & Card */
        .history-card { background-color: var(--card-bg); border: 1px solid var(--card-border); border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-soft); }
        .table-custom th { background-color: var(--bg-body); color: var(--text-secondary); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; border-bottom: 2px solid var(--card-border); }
        .table-custom td { background-color: var(--card-bg); color: var(--text-main); border-bottom: 1px solid var(--card-border); vertical-align: middle; }
    </style>
  </head>
  <body>

    {{-- NAVBAR SERAGAM --}}
    <nav class="navbar navbar-expand-lg sticky-top">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <i class="fa-solid fa-book-open-reader text-primary me-3 fs-3"></i>
            <div style="line-height: 1.2;">
                <span class="d-block fw-bold text-uppercase" style="letter-spacing: 1.5px; font-size: 1.2rem; color: var(--text-main);">E-Library</span>
                <span class="d-block" style="font-size: 0.75rem; letter-spacing: 1px; color: var(--text-secondary);">KNOWLEDGE BASE</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav align-items-center">
              <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Kontak</a></li>
              
              @auth
                  @if(Auth::user()->role === 'admin')
                     <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                  @else
                     {{-- Halaman ini aktif --}}
                     <li class="nav-item"><a class="nav-link active fw-bold text-primary" href="{{ route('my.borrowings') }}">Buku Saya</a></li>
                  @endif
                  <li class="nav-item mx-2 border-start border-secondary opacity-50" style="height: 20px;"></li>
                  <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link bg-transparent border-0 text-danger" title="Keluar"><i class="fa-solid fa-power-off"></i></button>
                    </form>
                  </li>
              @endauth

              <li class="nav-item ms-3"><button class="theme-toggle-btn" id="themeToggle"><i class="fa-solid fa-moon" id="themeIcon"></i></button></li>
            </ul>
        </div>
      </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Riwayat Peminjaman</h3>
                <p class="text-secondary small">Daftar buku yang sedang dan pernah Anda pinjam.</p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-pill btn-sm px-3"><i class="fa-solid fa-plus me-2"></i>Pinjam Buku Baru</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="history-card">
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th class="p-4">Buku</th>
                            <th class="p-4">Tanggal Pinjam</th>
                            <th class="p-4">Tenggat Kembali</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrowings as $borrow)
                        <tr>
                            <td class="p-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary bg-opacity-10 p-2 rounded me-3">
                                        <i class="fa-solid fa-book text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $borrow->book->title ?? 'Judul Tidak Ditemukan' }}</h6>
                                        <small class="text-secondary">{{ $borrow->book->author ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y') }}</td>
                            <td class="p-4">{{ \Carbon\Carbon::parse($borrow->return_date)->format('d M Y') }}</td>
                            <td class="p-4">
                                @if($borrow->status == 'approved')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Disetujui</span>
                                @elseif($borrow->status == 'pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">Menunggu</span>
                                @elseif($borrow->status == 'returned')
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">Dikembalikan</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center p-5">
                                <i class="fa-regular fa-folder-open fa-3x text-secondary mb-3"></i>
                                <p class="text-secondary">Belum ada riwayat peminjaman.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- SCRIPT SAMA --}}
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
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.getElementById('navbarNav');
        if(navbarToggler && navbarCollapse){
             navbarToggler.addEventListener('click', () => { navbarCollapse.classList.toggle('show'); });
        }
    </script>
  </body>
</html>