<!doctype html>
<html lang="id" data-bs-theme="light">
<head>
    <title>Kelola Komentar</title>
    {{-- Copy Style Block sama persis --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* PASTE CSS DARI ATAS */
        :root { --bg-body: #f0f2f5; --bg-pattern: radial-gradient(#d1d5db 1px, transparent 1px); --text-main: #212529; --text-secondary: #6c757d; --card-bg: #ffffff; --card-border: #e9ecef; --sidebar-bg: #ffffff; --sidebar-border: #e9ecef; --input-bg: #f8f9fa; --input-border: #ced4da; --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1); --active-item-bg: #e7f1ff; --active-item-text: #0d6efd; }
        [data-bs-theme="dark"] { --bg-body: #121212; --bg-pattern: radial-gradient(#333333 1px, transparent 1px); --text-main: #e0e0e0; --text-secondary: #a0a0a0; --card-bg: #1e1e1e; --card-border: #333333; --sidebar-bg: #1e1e1e; --sidebar-border: #333333; --input-bg: #2a2a2a; --input-border: #444; --shadow-soft: 0 10px 15px -3px rgba(0, 0, 0, 0.5); --active-item-bg: rgba(13, 110, 253, 0.15); --active-item-text: #6ea8fe; }
        body { background-color: var(--bg-body); background-image: var(--bg-pattern); background-size: 24px 24px; color: var(--text-main); font-family: 'Segoe UI', sans-serif; transition: 0.3s; }
        .dashboard-container { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background-color: var(--sidebar-bg); border-right: 1px solid var(--sidebar-border); display: flex; flex-direction: column; position: fixed; top: 0; bottom: 0; left: 0; padding: 20px; z-index: 1000; transition: 0.3s; }
        .sidebar-brand { font-size: 1.25rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--text-main); margin-bottom: 2rem; display: flex; align-items: center; }
        .nav-group-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); margin-top: 1.5rem; margin-bottom: 0.5rem; }
        .nav-item-link { display: flex; align-items: center; padding: 10px 15px; color: var(--text-secondary); text-decoration: none; border-radius: 8px; font-weight: 600; margin-bottom: 5px; transition: 0.2s; }
        .nav-item-link:hover { background-color: var(--bg-body); color: var(--text-main); }
        .nav-item-link.active { background-color: var(--active-item-bg); color: var(--active-item-text); }
        .nav-item-link i { width: 25px; text-align: center; margin-right: 10px; }
        .main-content { flex: 1; margin-left: 260px; padding: 30px; transition: 0.3s; }
        
        .content-card { background-color: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 25px; box-shadow: var(--shadow-soft); }
        .table { --bs-table-bg: transparent; --bs-table-color: var(--text-main); border-color: var(--sidebar-border); }
        .table th { border-bottom: 2px solid var(--sidebar-border); color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase; }
        .table td { vertical-align: middle; border-bottom: 1px solid var(--sidebar-border); }
        .theme-toggle-btn { background: var(--card-bg); border: 1px solid var(--sidebar-border); color: var(--text-main); padding: 8px 12px; border-radius: 50px; cursor: pointer; box-shadow: var(--shadow-soft); position: absolute; top: 20px; right: 30px;}
        .btn-logout { margin-top: auto; border: 1px solid #dc3545; color: #dc3545; background: transparent; text-align: center; border-radius: 8px; padding: 8px; font-weight: 600; transition: 0.3s; }
        .btn-logout:hover { background: #dc3545; color: white; }
    </style>
</head>
<body>

<div class="dashboard-container">
    {{-- SIDEBAR --}}
    <nav class="sidebar">
        <div class="sidebar-brand"><i class="fa-solid fa-book-open-reader text-primary me-2"></i> Admin Panel</div>
        
        <div class="nav-group-label">Katalog</div>
        <a href="{{ route('dashboard') }}" class="nav-item-link"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
        <a href="{{ route('dashboard.books') }}" class="nav-item-link"><i class="fa-solid fa-book"></i> Kelola Buku</a>
        <a href="{{ route('dashboard.articles') }}" class="nav-item-link"><i class="fa-regular fa-newspaper"></i> Kelola Artikel</a>

        <div class="nav-group-label">Aktivitas</div>
        <a href="{{ route('dashboard.loans') }}" class="nav-item-link"><i class="fa-solid fa-hand-holding-hand"></i> Peminjaman</a>
        <a href="{{ route('dashboard.comments') }}" class="nav-item-link active"><i class="fa-regular fa-comments"></i> Komentar</a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto w-100">
            @csrf <button type="submit" class="btn-logout w-100"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> KELUAR</button>
        </form>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="main-content position-relative">
        <button class="theme-toggle-btn" id="themeToggle"><i class="fa-solid fa-moon" id="themeIcon"></i></button>

        <div class="d-flex align-items-center mb-4 mt-2">
            <h3 class="fw-bold mb-0">Daftar Komentar</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success rounded-3 mb-4 border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="content-card p-0 overflow-hidden">
            <div class="table-responsive p-3">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama</th>
                            <th width="45%">Isi Komentar</th>
                            <th width="20%">Pada Postingan</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $index => $comment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="fw-bold">{{ $comment->user->name ?? 'Guest' }}</span></td>
                            <td class="text-secondary small">{{ Str::limit($comment->body, 100) }}</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">{{ Str::limit($comment->post->title, 30) }}</span></td>
                            <td>
                                <form action="{{ route('dashboard.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-circle"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">
                                <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3"><i class="fa-regular fa-comments fa-2x"></i></div>
                                <p class="mb-0">Belum ada komentar.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

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