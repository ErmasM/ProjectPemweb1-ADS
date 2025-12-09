<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <title>Admin Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>body{background:#0f0f0f;color:#eee} .sidebar{height:100vh;background:#1a1a1a;position:fixed;width:250px;padding:20px} .main-content{margin-left:250px;padding:40px}</style>
</head>
<body>
    {{-- Sidebar sederhana --}}
    <div class="sidebar">
        <h4>Admin Panel</h4>
        <a href="{{ route('dashboard') }}" class="d-block text-white mb-2">Dashboard</a>
        <a href="{{ route('dashboard.posts') }}" class="d-block text-white mb-2">Pustaka</a>
        <a href="{{ route('dashboard.borrowings') }}" class="d-block text-info mb-2">Peminjaman</a>
        <a href="{{ route('dashboard.comments') }}" class="d-block text-white">Komentar</a>
    </div>

    <div class="main-content">
        <h3>Data Peminjaman</h3>
        <table class="table table-dark mt-3">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowings as $item)
                <tr>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->book->title }}</td>
                    <td><span class="badge bg-secondary">{{ $item->status }}</span></td>
                    <td>
                        @if($item->status == 'pending')
                        <form action="{{ route('dashboard.borrowings.update', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button class="btn btn-sm btn-success">ACC</button>
                        </form>
                        <form action="{{ route('dashboard.borrowings.update', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button class="btn btn-sm btn-danger">Tolak</button>
                        </form>
                        @else
                        Selesai
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>