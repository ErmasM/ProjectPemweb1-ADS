<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Tambah Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{background-color:#0f0f0f;color:#eee; padding: 40px;}</style>
</head>
<body>
    <div class="container" style="max-width: 800px;">
        <h3 class="mb-4">Tambah Data Baru</h3>
        
        <form action="{{ route('dashboard.posts.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Judul Buku / Artikel</label>
                <input type="text" name="title" class="form-control bg-dark text-white" required>
            </div>

            <div class="mb-3">
                <label>Kategori (Ini yang menentukan dia Buku atau Artikel)</label>
                <select name="category" class="form-select bg-dark text-white">
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
                    </optgroup>
                </select>
            </div>

            <div class="mb-3">
                <label>Penulis</label>
                <input type="text" name="author" class="form-control bg-dark text-white" required>
            </div>

            <div class="mb-3">
                <label>Link Gambar (URL)</label>
                <input type="text" name="image" class="form-control bg-dark text-white" placeholder="https://..." required>
                <small class="text-secondary">Gunakan link gambar dari internet (contoh: Unsplash/Google Images)</small>
            </div>

            <div class="mb-3">
                <label>Isi (Sinopsis / Konten)</label>
                <textarea name="body" rows="10" class="form-control bg-dark text-white" required></textarea>
            </div>

            <button class="btn btn-primary">SIMPAN DATA</button>
            <a href="{{ route('dashboard.posts') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>