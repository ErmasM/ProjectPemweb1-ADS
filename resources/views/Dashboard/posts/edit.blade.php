<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{background-color:#0f0f0f;color:#eee; padding: 40px;}</style>
</head>
<body>
    <div class="container" style="max-width: 800px;">
        <h3 class="mb-4">Edit Data Pustaka</h3>
        
        {{-- Form mengarah ke route UPDATE, jangan lupa bawa ID post-nya --}}
        <form action="{{ route('dashboard.posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- WAJIB: Ubah method jadi PUT untuk update --}}

            <div class="mb-3">
                <label>Judul Buku / Artikel</label>
                {{-- value="{{ $post->title }}" fungsinya memunculkan judul lama --}}
                <input type="text" name="title" class="form-control bg-dark text-white" value="{{ $post->title }}" required>
            </div>

            <div class="mb-3">
                <label>Kategori</label>
                <select name="category" class="form-select bg-dark text-white">
                    <optgroup label="--- BUKU (Masuk Katalog) ---">
                        {{-- Logika: Jika kategori lama sama dengan value, tambahkan 'selected' --}}
                        <option value="Koleksi Baru" {{ $post->category == 'Koleksi Baru' ? 'selected' : '' }}>Koleksi Baru</option>
                        <option value="Resensi" {{ $post->category == 'Resensi' ? 'selected' : '' }}>Resensi</option>
                        <option value="Koleksi" {{ $post->category == 'Koleksi' ? 'selected' : '' }}>Koleksi Umum</option>
                    </optgroup>
                    <optgroup label="--- ARTIKEL BLOG ---">
                        <option value="Teknologi" {{ $post->category == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                        <option value="Tips Literasi" {{ $post->category == 'Tips Literasi' ? 'selected' : '' }}>Tips Literasi</option>
                        <option value="Event" {{ $post->category == 'Event' ? 'selected' : '' }}>Event</option>
                        <option value="Info Layanan" {{ $post->category == 'Info Layanan' ? 'selected' : '' }}>Info Layanan</option>
                        <option value="Info Layanan" {{ $post->category == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                            <option value="Info Layanan" {{ $post->category == 'Informasi' ? 'selected' : '' }}>Informasi</option>
                    </optgroup>
                </select>
            </div>

            <div class="mb-3">
                <label>Penulis</label>
                <input type="text" name="author" class="form-control bg-dark text-white" value="{{ $post->author }}" required>
            </div>

            <div class="mb-3">
                <label>Link Gambar (URL)</label>
                <input type="text" name="image" class="form-control bg-dark text-white" value="{{ $post->image }}" required>
                <small class="text-secondary">Preview gambar saat ini:</small><br>
                <img src="{{ $post->image }}" alt="Preview" style="height: 100px; margin-top: 5px; border-radius: 5px;">
            </div>

            <div class="mb-3">
                <label>Isi (Sinopsis / Konten)</label>
                <textarea name="body" rows="10" class="form-control bg-dark text-white" required>{{ $post->body }}</textarea>
            </div>

            <button class="btn btn-warning fw-bold">UPDATE DATA</button>
            <a href="{{ route('dashboard.posts') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>