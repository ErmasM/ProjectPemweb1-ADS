<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Kelola Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #0f0f0f; color: #eee; }
        
        /* SIDEBAR STYLE */
        .sidebar { height: 100vh; background: #1a1a1a; border-right: 1px solid #333; position: fixed; width: 250px; padding: 20px; }
        .main-content { margin-left: 250px; padding: 40px; }
        .nav-link { color: #aaa; padding: 10px 15px; border-radius: 8px; margin-bottom: 5px; text-decoration: none; display: block; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: #fff; }
        
        /* TABLE STYLE */
        .table-dark { --bs-table-bg: #1a1a1a; border-color: #333; }
    </style>
</head>
<body>

    {{-- SIDEBAR ADMIN (DENGAN MENU TERPISAH) --}}
    <div class="sidebar d-flex flex-column">
        <h4 class="fw-bold text-white mb-5"><i class="fa-solid fa-rocket me-2"></i>Admin Panel</h4>
        
        <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="fa-solid fa-gauge me-2"></i> Dashboard
        </a>
        
        {{-- Menu Buku --}}
        <a href="{{ route('dashboard.books') }}" class="nav-link">
            <i class="fa-solid fa-book me-2"></i> Kelola Buku
        </a>

        {{-- Menu Artikel --}}
        <a href="{{ route('dashboard.articles') }}" class="nav-link">
            <i class="fa-solid fa-newspaper me-2"></i> Kelola Artikel
        </a>

        {{-- Menu Peminjaman (Sedang Aktif) --}}
        <a href="{{ route('dashboard.loans') }}" class="nav-link active">
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="fa-solid fa-list-check me-2"></i> Daftar Peminjaman Buku</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card bg-dark border-secondary">
            <div class="card-body p-0">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrowings as $index => $borrowing)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $borrowing->user->name }}</td>
                            <td>{{ $borrowing->book->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}</td>
                            <td>
                                @if($borrowing->return_date)
                                    {{ \Carbon\Carbon::parse($borrowing->return_date)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($borrowing->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($borrowing->status == 'approved')
                                    <span class="badge bg-success">Dipinjam</span>
                                @elseif($borrowing->status == 'returned')
                                    <span class="badge bg-info">Dikembalikan</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                {{-- Tombol Aksi Admin --}}
                                @if($borrowing->status == 'pending')
                                    <div class="d-flex gap-1">
                                        {{-- Tombol Terima --}}
                                        <form action="{{ route('dashboard.borrowings.update', $borrowing->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui peminjaman ini?')">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>

                                        {{-- Tombol Tolak --}}
                                        <form action="{{ route('dashboard.borrowings.update', $borrowing->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak peminjaman ini?')">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    </div>
                                @elseif($borrowing->status == 'approved')
                                    {{-- Tombol Kembalikan Buku --}}
                                    <form action="{{ route('dashboard.borrowings.update', $borrowing->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="returned">
                                        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Buku sudah dikembalikan?')">
                                            <i class="fa-solid fa-box-archive"></i> Selesai
                                        </button>
                                    </form>
                                @else
                                    <span class="text-secondary small"><i class="fa-solid fa-circle-check"></i> Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-5">
                                <i class="fa-solid fa-folder-open fa-3x mb-3"></i><br>
                                Belum ada data peminjaman.
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