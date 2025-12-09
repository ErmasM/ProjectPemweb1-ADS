<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Buku Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{background:#111;color:#eee} .navbar{background:linear-gradient(90deg, #0f2027, #203a43, #2c5364);}</style>
</head>
<body>
    {{-- Copy Navbar dari Home --}}
    
    <div class="container mt-5">
        <h3>📚 Riwayat Peminjaman Saya</h3>
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        
        <table class="table table-dark table-hover mt-3">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowings as $item)
                <tr>
                    <td>{{ $item->book->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->borrow_date)->format('d M Y') }}</td>
                    <td>
                        @if($item->status == 'pending') <span class="badge bg-warning text-dark">Menunggu</span>
                        @elseif($item->status == 'approved') <span class="badge bg-success">Disetujui</span>
                        @else <span class="badge bg-danger">Ditolak</span> @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>