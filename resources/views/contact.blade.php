<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontak Kami - Kelompok 13</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #050505; color: #eee; font-family: 'Segoe UI', sans-serif; }
        
        /* NAVBAR SERAGAM */
        .navbar { 
            background: linear-gradient(90deg, #0f2027, #203a43, #2c5364);
            padding: 15px 0; 
            border-bottom: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        }
        .nav-link { color: #ccc; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; margin: 0 15px; letter-spacing: 1px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #fff; text-shadow: 0 0 10px rgba(255,255,255,0.5); }

        /* STYLE CONTACT BOX ASLI */
        .contact-box {
            background-color: #1a1a1a; border-radius: 20px; overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.7); border: 1px solid #333; min-height: 600px;
        }
        .left-side { background: linear-gradient(180deg, #101010 0%, #0d1b2a 100%); padding: 50px; display: flex; flex-direction: column; justify-content: center; border-right: 1px solid #333; position: relative; }
        .left-side::before { content: ''; position: absolute; top: -50px; left: -50px; width: 200px; height: 200px; background: #0d6efd; filter: blur(100px); opacity: 0.2; border-radius: 50%; }
        .member-card { display: flex; align-items: center; margin-bottom: 15px; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.05); padding: 15px; border-radius: 12px; transition: all 0.3s ease; }
        .member-card:hover { transform: translateX(10px); background: rgba(255, 255, 255, 0.08); border-color: #0d6efd; }
        .member-avatar { width: 45px; height: 45px; background: linear-gradient(135deg, #0d6efd, #00d4ff); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; margin-right: 15px; }
        .right-side { padding: 50px; background-color: #151515; }
        .form-control { background-color: #222; border: 1px solid #333; color: #fff; padding: 12px; border-radius: 8px; }
        .form-control:focus { background-color: #2a2a2a; border-color: #0d6efd; color: #fff; }
        .btn-back { text-decoration: none; color: #888; font-weight: 600; display: inline-flex; align-items: center; transition: 0.3s; padding: 10px 0; }
        .btn-back:hover { color: #fff; transform: translateX(-5px); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div style="line-height: 1.2;">
                <span class="d-block fw-bold text-white text-uppercase" style="letter-spacing: 2px; font-size: 1.1rem;">E-Library</span>
            </div>
        </a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav align-items-center">
              <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">BERANDA</a></li>
              <li class="nav-item"><a class="nav-link active" href="{{ route('contact') }}">KONTAK</a></li>
              
              {{-- FITUR LOGIKA NAVBAR (Login/User) --}}
              @guest
                  <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">LOGIN</a></li>
              @endguest

              @auth
                  {{-- Jika Admin ke Dashboard, Jika User ke Buku Saya --}}
                  @if(Auth::user()->role === 'admin')
                     <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">DASHBOARD</a></li>
                  @else
                     <li class="nav-item"><a class="nav-link" href="{{ route('my.borrowings') }}">BUKU SAYA</a></li>
                  @endif

                 
                  
                  {{-- Tombol Logout --}}
                  <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link bg-transparent border-0 text-danger" title="Logout" style="cursor: pointer;">
                            <i class="fa-solid fa-power-off"></i>
                        </button>
                    </form>
                  </li>
              @endauth

            </ul>
        </div>
        <div class="d-none d-lg-block" style="width: 200px;"></div>
      </div>
    </nav>

    {{-- KONTEN CONTACT ASLI ANDA (TIDAK DIUBAH) --}}
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="row g-0 contact-box">
                    <div class="col-md-5 left-side text-white">
                        <div style="position: relative; z-index: 2;">
                            <h6 class="text-primary fw-bold text-uppercase mb-2"><i class="fa-solid fa-code me-2"></i>Tugas Web 1</h6>
                            <h2 class="fw-bold mb-4 display-6">Kelompok 13</h2>
                            <p class="text-secondary mb-4 small">Portal E-Library untuk memenuhi kebutuhan literasi mahasiswa.</p>
                            <h6 class="text-uppercase fw-bold mb-3 text-white-50 small">Core Team</h6>
                            <div class="member-card"><div class="member-avatar">N</div><div><div class="fw-bold">Nadine Ariesta</div><small class="text-secondary">NIM. H1D024028</small></div></div>
                            <div class="member-card"><div class="member-avatar">E</div><div><div class="fw-bold">Ermas Muhammad</div><small class="text-secondary">NIM. H1D024030</small></div></div>
                            <div class="member-card"><div class="member-avatar">M</div><div><div class="fw-bold">Muhammad Yazid</div><small class="text-secondary">NIM. H1D024040</small></div></div>
                            <div class="mt-5 pt-3 border-top border-secondary"><div class="d-flex align-items-center mb-2"><i class="fa-solid fa-building-columns text-primary me-3"></i><small class="text-secondary">Universitas Jenderal Soedirman</small></div><div class="d-flex align-items-center"><i class="fa-solid fa-laptop-code text-primary me-3"></i><small class="text-secondary">Informatika - Fakultas Teknik</small></div></div>
                        </div>
                    </div>
                    <div class="col-md-7 right-side">
                        <h3 class="fw-bold mb-2 text-white">Hubungi Kami</h3>
                        <p class="text-secondary mb-4">Punya pertanyaan seputar koleksi buku? Kirim pesan di sini.</p>
                        <form>
                            <div class="row"><div class="col-md-6 mb-3"><label class="text-secondary small mb-1 fw-bold">NAMA</label><input type="text" class="form-control"></div><div class="col-md-6 mb-3"><label class="text-secondary small mb-1 fw-bold">EMAIL</label><input type="email" class="form-control"></div></div>
                            <div class="mb-3"><label class="text-secondary small mb-1 fw-bold">SUBJEK</label><input type="text" class="form-control"></div>
                            <div class="mb-4"><label class="text-secondary small mb-1 fw-bold">PESAN</label><textarea class="form-control" rows="5"></textarea></div>
                            <button type="button" class="btn btn-primary w-100 fw-bold py-2">KIRIM PESAN</button>
                        </form>
                    </div>
                </div>
                <div class="mt-4"><a href="{{ route('home') }}" class="btn-back"><i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Beranda</a></div>
            </div>
        </div>
    </div>
</body>
</html>