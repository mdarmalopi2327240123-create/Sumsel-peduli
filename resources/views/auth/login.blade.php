<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sumsel Peduli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f5f7fb; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .login-container { width: 100%; max-width: 950px; background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,.05); }
        .left-side { background: #198754; color: white; padding: 40px; height: 100%; min-height: 520px; }
        .left-side h1 { font-size: 28px; font-weight: 700; margin-bottom: 15px; }
        .left-side p { font-size: 14px; opacity: .9; line-height: 1.6; }
        .auth-svg { max-height: 200px; width: 100%; margin-top: 25px; }
        .right-side { padding: 40px; }
        .logo { font-size: 24px; font-weight: 700; margin-bottom: 10px; }
        .form-control { height: 46px; border-radius: 12px; border: 1px solid #ddd; font-size: 14px; }
        .form-control:focus { box-shadow: none; border-color: #198754; }
        .form-label { font-size: 14px; margin-bottom: 6px; font-weight: 500; }
        .btn-login { height: 46px; border-radius: 12px; font-weight: 600; font-size: 15px; }
        .social-btn { height: 44px; border-radius: 10px; font-size: 14px; }
        .divider { display: flex; align-items: center; margin: 15px 0; font-size: 13px; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #eee; }
        .divider span { padding: 0 12px; color: #888; }
        .text-muted { font-size: 14px; }
        .form-check-label, .text-success { font-size: 14px; }
        @media(max-width: 991px) { .left-side { display: none; } .right-side { padding: 30px 20px; } .login-container { max-width: 500px; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="row g-0">
                <div class="col-lg-5">
                    <div class="left-side d-flex flex-column justify-content-center">
                        <h1>💚 Sumsel Peduli</h1>
                        <p>Platform donasi terpercaya untuk membantu masyarakat Sumatera Selatan melalui campaign sosial yang transparan dan mudah diakses.</p>
                        <img src="{{ asset('images/auth_charity.png') }}" alt="Sumsel Peduli" class="img-fluid rounded-4 shadow-sm w-100" style="object-fit: cover; max-height: 320px;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="right-side">
                        <div class="logo">Masuk Akun</div>
                        <p class="text-muted mb-4">Silakan masuk untuk melanjutkan ke dashboard.</p>
                        
                        <div class="alert alert-warning mb-4" role="alert">
                            <strong>[Bantuan Database Vercel]</strong> Jika akun "tidak ditemukan" atau database kosong: 
                            <a href="/api/db-test.php?migrate=true&seed=true" class="text-success fw-bold text-decoration-underline" target="_blank">
                                Klik di sini untuk mengisi database secara otomatis
                            </a>.
                        </div>
                        
                        @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success mb-4" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan email" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                    <label class="form-check-label" for="remember_me">Ingat Saya</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-success text-decoration-none">Lupa Password?</a>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success btn-login w-100">Masuk</button>
                        </form>
                        
                        <div class="divider"><span>ATAU</span></div>
                        <a href="{{ route('login.google') }}" class="btn btn-outline-secondary social-btn w-100 mb-2 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-google"></i> Masuk Dengan Google
                        </a>
                        <div class="text-center mt-4">
                            Belum punya akun? <a href="{{ route('register') }}" class="text-success text-decoration-none fw-bold">Daftar Sekarang</a>
                        </div>
                        <div class="text-center mt-4">
                            <a href="{{ route('home') }}" class="btn btn-outline-success"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
