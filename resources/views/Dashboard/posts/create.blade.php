<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Tambah Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #0f0f0f; color: #eee; }
        /* SIDEBAR STYLE */
        .sidebar { height: 100vh; background: #1a1a1a; border-right: 1px solid #333; position: fixed; width: 250px; padding: 20px; }
        .main-content { margin-left: 250px; padding: 40px; }
        .nav-link { color: #aaa; padding: 10px 15px; border-radius: 8px; margin-bottom: 5px; text-decoration: none; display: block; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: #fff; }
    </style>
</head>
<body>

    {{-- SIDEBAR ADMIN (UPDATE MENU TERPISAH) --}}
    <div class="sidebar d-flex flex-column">
        <h4 class="fw-bold text-white mb-5"><i class="fa-solid fa-rocket me-2"></i>Admin Panel</h4>
        
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
        
        <a href="{{ route('dashboard.books') }}" class="nav-link">
            <i class="fa-solid fa-book me-2"></i> Kelola Buku
        </a>

        <a href="{{ route('dashboard.articles') }}" class="nav-link">
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
        <div class="container" style="max-width: 900px;">
            <h3 class="mb-4">Tambah Data Baru</h3>
            
            <form action="{{ route('dashboard.posts.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Judul Buku / Artikel</label>
                    <input type="text" name="title" class="form-control bg-dark text-white border-secondary" required>
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="category" class="form-select bg-dark text-white border-secondary">
                        <optgroup label="--- BUKU (Masuk Katalog) ---">
                            <option value="Koleksi Baru">Koleksi Baru</option>
                            <option value="Resensi">Resensi</option>
                            <option value="Koleksi">Koleksi Umum</option>
                        </optgroup>
                        <optgroup label="--- ARTIKEL BLOG ---">
                            <option value="Teknologi">Teknologi</option>
                            <option value="Tips Literasi">Tips Literasi</option>
                            <option value="Event">Event</option>
                            <option value="Info Layanan">Info Layanan</option>
                            <option value="Olahraga">Olahraga</option>
                            <option value="Informasi">Informasi</option>
                        </optgroup>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Penulis</label>
                    <input type="text" name="author" class="form-control bg-dark text-white border-secondary" required>
                </div>

                <div class="mb-3">
                    <label>Link Gambar (URL)</label>
                    <input type="text" name="image" class="form-control bg-dark text-white border-secondary" placeholder="https://..." required>
                    <small class="text-secondary">Gunakan link gambar dari internet.</small>
                </div>

                <div class="mb-3">
                    <label>Isi (Sinopsis / Konten)</label>
                    <textarea name="body" rows="10" class="form-control bg-dark text-white border-secondary" required></textarea>
                </div>

                <button class="btn btn-primary"><i class="fa-solid fa-save me-2"></i> Simpan Data</button>
                {{-- Tombol Batal kembali ke Dashboard agar aman --}}
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>