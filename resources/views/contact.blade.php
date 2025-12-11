<!doctype html>
<html lang="id" data-bs-theme="light">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontak - E-Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --bg-body: #f0f2f5;
            --bg-pattern: radial-gradient(#d1d5db 1px, transparent 1px);
            --text-main: #212529;
            --text-secondary: #6c757d;
            --card-bg: #ffffff;
            --card-border: #e9ecef;
            --navbar-bg: rgba(255, 255, 255, 0.85);
            --navbar-border: rgba(0, 0, 0, 0.05);
            --input-bg: #f8f9fa;
            --input-border: #ced4da;
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        [data-bs-theme="dark"] {
            --bg-body: #121212;
            --bg-pattern: radial-gradient(#333333 1px, transparent 1px);
            --text-main: #e0e0e0;
            --text-secondary: #a0a0a0;
            --card-bg: #1e1e1e;
            --card-border: #333333;
            --navbar-bg: rgba(18, 18, 18, 0.85);
            --navbar-border: rgba(255, 255, 255, 0.05);
            --input-bg: #2a2a2a;
            --input-border: #444;
            --shadow-soft: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }

        body { 
            background-color: var(--bg-body); 
            background-image: var(--bg-pattern); 
            background-size: 24px 24px;
            color: var(--text-main); 
            font-family: 'Segoe UI', sans-serif; 
            transition: background-color 0.3s, color 0.3s;
        }

        /* Navbar Styles */
        .navbar { 
            background: var(--navbar-bg); 
            backdrop-filter: blur(12px); 
            border-bottom: 1px solid var(--navbar-border); 
            padding: 15px 0; 
        }
        .nav-link { 
            color: var(--text-secondary); 
            font-weight: 600; text-transform: uppercase; margin: 0 10px; font-size: 0.85rem; transition: 0.3s; 
        }
        .nav-link:hover, .nav-link.active { color: var(--text-main); }
        .theme-toggle-btn { 
            background: transparent; border: 1px solid var(--text-secondary); color: var(--text-main); 
            padding: 5px 10px; border-radius: 20px; cursor: pointer; transition: 0.3s; 
        }
        .theme-toggle-btn:hover { background: var(--text-secondary); color: var(--bg-body); }

        /* Contact Page Specific */
        .contact-card {
            background-color: var(--card-bg); 
            border: 1px solid var(--card-border);
            border-radius: 16px; 
            box-shadow: var(--shadow-soft); 
            padding: 40px;
        }
        .form-control {
            background-color: var(--input-bg); 
            border: 1px solid var(--input-border); 
            color: var(--text-main);
            padding: 12px 15px; border-radius: 8px;
        }
        .form-control:focus {
            background-color: var(--card-bg); 
            color: var(--text-main); 
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg sticky-top">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <i class="fa-solid fa-book-open-reader text-primary me-2 fs-4"></i>
            <span class="fw-bold text-uppercase" style="letter-spacing: 1px; color: var(--text-main);">E-Library</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fa-solid fa-bars" style="color: var(--text-main);"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
              <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
              <li class="nav-item"><a class="nav-link active" href="{{ route('contact') }}">Kontak</a></li>
              @auth
                  <li class="nav-item ms-2"><a class="nav-link btn btn-outline-danger px-4 text-danger border-danger" style="border-radius:20px;" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
              @else
                  <li class="nav-item ms-2"><a class="nav-link btn btn-primary px-4 text-white" href="{{ route('login') }}" style="border-radius: 20px;">Login</a></li>
              @endauth
              <li class="nav-item ms-3">
                  <button class="theme-toggle-btn" id="themeToggle"><i class="fa-solid fa-moon" id="themeIcon"></i></button>
              </li>
            </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5 pt-3 mb-5">
        <div class="row justify-content-center align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Hubungi <span class="text-primary">Kami</span></h1>
                <p class="lead mb-4" style="color: var(--text-secondary);">
                    Apakah ada buku yang ingin Anda cari? Atau mengalami kendala saat meminjam? 
                    Tim perpustakaan kami siap membantu Anda.
                </p>
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="fa-solid fa-envelope text-primary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Email Support</h6>
                        <span style="color: var(--text-secondary);">help@elibrary.com</span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="fa-solid fa-map-location-dot text-primary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Lokasi</h6>
                        <span style="color: var(--text-secondary);">Gedung F Lt. 1</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="contact-card">
                    <h4 class="mb-4 fw-bold">Kirim Pesan</h4>
                    <form>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">NAMA LENGKAP</label>
                            <input type="text" class="form-control" placeholder="Nama Anda">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">EMAIL</label>
                            <input type="email" class="form-control" placeholder="nama@email.com">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary">PESAN</label>
                            <textarea class="form-control" rows="4" placeholder="Tulis pesan..."></textarea>
                        </div>
                        <button type="button" class="btn btn-primary w-100 py-2 fw-bold rounded-3">KIRIM PESAN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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