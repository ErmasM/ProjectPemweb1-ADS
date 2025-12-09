<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Kelompok 13</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* --- SETUP AGAR FULL SCREEN --- */
        body { 
            background-color: #0f0f0f; 
            color: #eee; 
            font-family: 'Segoe UI', sans-serif;
            /* Trik agar footer/bawahnya mentok */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        
        /* NAVBAR SERAGAM */
        .navbar { 
            background: linear-gradient(90deg, #0f2027, #203a43, #2c5364);
            padding: 15px 0; 
            border-bottom: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            flex-shrink: 0; /* Navbar gak boleh mengecil */
        }
        .nav-link { color: #ccc; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; margin: 0 15px; letter-spacing: 1px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #fff; text-shadow: 0 0 10px rgba(255,255,255,0.5); }

        /* CONTENT CENTER (BACKGROUND FIX) */
        .login-wrapper {
            flex-grow: 1; /* Mengisi sisa ruang kosong sampai bawah */
            display: flex; align-items: center; justify-content: center;
            background-image: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2000');
            background-size: cover; background-position: center;
            width: 100%;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 20px;
            padding: 40px; width: 100%; max-width: 400px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }
        .form-control { background-color: rgba(0, 0, 0, 0.5); border: 1px solid #333; color: #fff; padding: 12px; border-radius: 10px; }
        .form-control:focus { background-color: rgba(0, 0, 0, 0.7); border-color: #0d6efd; color: #fff; }
        .btn-primary { padding: 12px; border-radius: 10px; font-weight: bold; background: linear-gradient(45deg, #0d6efd, #0099ff); border: none; }
        
        .btn-back { 
            border: 1px solid #444; color: #ccc; border-radius: 10px; width: 100%; 
            display: block; padding: 10px; text-decoration: none; transition: 0.3s; 
            background: rgba(0,0,0,0.3);
        }
        .btn-back:hover { background-color: #222; color: #fff; border-color: #fff; }
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
            <ul class="navbar-nav">
              <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">BERANDA</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">KONTAK</a></li>
              <li class="nav-item"><a class="nav-link active" href="{{ route('login') }}">LOGIN</a></li>
            </ul>
        </div>
        <div class="d-none d-lg-block" style="width: 200px;"></div>
      </div>
    </nav>

    <div class="login-wrapper">
        <div class="glass-card text-center">
            <div class="mb-4"><i class="fa-solid fa-rocket fa-3x text-primary"></i></div>
            <h3 class="fw-bold mb-4 text-white">LOGIN</h3>
            
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3 text-start">
                    <label class="small text-secondary mb-1">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@gmail.com" required>
                </div>
                <div class="mb-4 text-start">
                    <label class="small text-secondary mb-1">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="password123" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">MASUK</button>
                <a href="{{ route('home') }}" class="btn-back small"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda</a>
            </form>
        </div>
    </div>

</body>
</html>