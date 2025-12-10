<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rak Buku Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #0f0f0f; color: #e0e0e0; font-family: 'Segoe UI', sans-serif; }
        
        /* Navbar Style */
        .navbar { background: rgba(20, 20, 20, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid #333; }
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }

        /* Card Style */
        .borrow-card {
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s, border-color 0.3s;
        }
        .borrow-card:hover {
            transform: translateY(-5px);
            border-color: #555;
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }

        .book-cover-mini {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        /* Status Badges */
        .badge-pending { background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid #ffc107; }
        .badge-approved { background: rgba(25, 135, 84, 0.2); color: #198754; border: 1px solid #198754; }
        .badge-rejected { background: rgba(220, 53, 69, 0.2); color: #dc3545; border: 1px solid #dc3545; }
        .badge-returned { background: rgba(13, 110, 253, 0.2); color: #0d6efd; border: 1px solid #0d6efd; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand text-primary" href="{{ route('home') }}">
                <i class="fa-solid fa-book-open me-2"></i>E-LIBRARY
            </a>
            <div class="ms-auto">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4">
                    <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px; margin-bottom: 80px;">
        
        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-5 border-bottom border-secondary pb-3">
            <div>
                <h2 class="fw-bold mb-1"><i class="fa-solid fa-layer-group me-2 text-primary"></i> Rak Buku Saya</h2>
                <p class="text-secondary mb-0">Riwayat pengajuan dan peminjaman buku Anda.</p>
            </div>
            <div class="text-end">
                <span class="badge bg-dark border border-secondary p-2">Total: {{ count($borrowings) }} Transaksi</span>
            </div>
        </div>

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- GRID CARD (Pengganti Tabel) --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4">
            @forelse($borrowings as $item)
            <div class="col">
                <div class="card borrow-card h-100">
                    <div class="row g-0 h-100">
                        {{-- GAMBAR BUKU (Kiri) --}}
                        <div class="col-4">
                            {{-- Mengambil gambar dari relasi book --}}
                            <img src="{{ $item->book->image }}" class="book-cover-mini" alt="Cover Buku">
                        </div>
                        
                        {{-- INFO (Kanan) --}}
                        <div class="col-8">
                            <div class="card-body d-flex flex-column h-100 justify-content-center">
                                
                                {{-- Judul --}}
                                <h5 class="card-title fw-bold text-white mb-1 text-truncate">{{ $item->book->title }}</h5>
                                <small class="text-secondary mb-3"><i class="fa-solid fa-pen-nib me-1"></i> {{ $item->book->author }}</small>
                                
                                {{-- Status Badge --}}
                                <div class="mb-3">
                                    @if($item->status == 'pending')
                                        <span class="badge badge-pending rounded-pill"><i class="fa-regular fa-clock me-1"></i> Menunggu Persetujuan</span>
                                    @elseif($item->status == 'approved')
                                        <span class="badge badge-approved rounded-pill"><i class="fa-solid fa-book-open me-1"></i> Sedang Dipinjam</span>
                                    @elseif($item->status == 'returned')
                                        <span class="badge badge-returned rounded-pill"><i class="fa-solid fa-check-double me-1"></i> Sudah Dikembalikan</span>
                                    @else
                                        <span class="badge badge-rejected rounded-pill"><i class="fa-solid fa-circle-xmark me-1"></i> Ditolak</span>
                                    @endif
                                </div>

                                {{-- Tanggal --}}
                                <div class="mt-auto border-top border-secondary pt-2">
                                    <div class="d-flex justify-content-between text-secondary small">
                                        <span><i class="fa-solid fa-calendar-plus me-1"></i> Pinjam:</span>
                                        <span class="text-white">{{ \Carbon\Carbon::parse($item->borrow_date)->format('d M Y') }}</span>
                                    </div>
                                    @if($item->return_date)
                                    <div class="d-flex justify-content-between text-secondary small mt-1">
                                        <span><i class="fa-solid fa-calendar-check me-1"></i> Kembali:</span>
                                        <span class="text-info">{{ \Carbon\Carbon::parse($item->return_date)->format('d M Y') }}</span>
                                    </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5 border border-secondary rounded-4" style="border-style: dashed !important;">
                    <i class="fa-solid fa-box-open fa-3x text-secondary mb-3"></i>
                    <h5 class="text-secondary">Belum ada riwayat peminjaman.</h5>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-2 rounded-pill">Mulai Pinjam Buku</a>
                </div>
            </div>
            @endforelse
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>