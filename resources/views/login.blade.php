<!doctype html>
<html lang="id" data-bs-theme="light">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - E-Library</title>
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
            display: flex; flex-direction: column; min-height: 100vh;
        }

        /* Navbar Styling */
        .navbar { 
            background: var(--navbar-bg); 
            backdrop-filter: blur(12px); 
            border-bottom: 1px solid var(--navbar-border); 
            padding: 15px 0; 
        }
        .nav-link { 
            color: var(--text-secondary); 
            font-weight: 600; 
            text-transform: uppercase; 
            font-size: 0.85rem; 
            margin: 0 10px; 
            transition: 0.3s;
        }
        .nav-link:hover { color: var(--text-main); }
        
        .theme-toggle-btn { 
            background: transparent; 
            border: 1px solid var(--text-secondary); 
            color: var(--text-main); 
            padding: 5px 10px; 
            border-radius: 20px; 
            cursor: pointer; 
            transition: 0.3s; 
        }
        .theme-toggle-btn:hover { background: var(--text-secondary); color: var(--bg-body); }

        /* Login Specific Styling */
        .login-wrapper { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 20px; }
        .login-card {
            background-color: var(--card-bg); 
            border: 1px solid var(--card-border);
            border-radius: 16px; 
            box-shadow: var(--shadow-soft); 
            width: 100%; max-width: 400px; 
            padding: 40px;
        }
        .form-control {
            background-color: var(--input-bg); 
            border: 1px solid var(--input-border); 
            color: var(--text-main);
            padding: 12px 15px; 
            border-radius: 8px;
        }
        .form-control:focus {
            background-color: var(--card-bg); 
            color: var(--text-main); 
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .input-group-text {
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            border-right: none;
            color: var(--text-secondary);
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
        
        <div class="d-flex align-items-center">
             <a href="{{ route('home') }}" class="nav-link me-3 d-none d-md-block">Beranda</a>
             <button class="theme-toggle-btn" id="themeToggle"><i class="fa-solid fa-moon" id="themeIcon"></i></button>
        </div>
      </div>
    </nav>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="text-center mb-4">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-user-lock text-primary fs-3"></i>
                </div>
                <h4 class="fw-bold mb-1">Selamat Datang</h4>
                <p class="text-secondary small">Masuk untuk mengakses perpustakaan.</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger py-2 text-center small rounded-3 mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary" style="font-size: 0.75rem;">EMAIL</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control border-start-0 ps-1" placeholder="nama@email.com" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary" style="font-size: 0.75rem;">PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                        <input type="password" name="password" class="form-control border-start-0 ps-1" placeholder="******" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill mb-3">MASUK</button>
                <div class="text-center">
                    <a href="{{ route('home') }}" class="text-secondary text-decoration-none small">Kembali ke Beranda</a>
                </div>
            </form>
        </div>
    </div>

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