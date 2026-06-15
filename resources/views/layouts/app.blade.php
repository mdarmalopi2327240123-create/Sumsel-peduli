<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sumsel Peduli') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #198754;
            --primary-dark: #157347;
            --secondary: #0d6efd;
            --warning: #ffc107;
            --danger: #dc3545;
            --dark: #212529;
            --light: #f8f9fa;
            --background: #f5f7fb;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: var(--background);
            color: #333;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
            padding: 15px 0;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,.04);
        }

        .stat-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 6px 15px rgba(0,0,0,.03);
            transition: .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        /* Make stat text and icon more compact */
        .stat-card .card-body {
            padding: 15px !important;
        }
        .stat-card h3 {
            font-size: 1.25rem !important;
            font-weight: 700 !important;
        }
        .stat-card small {
            font-size: 0.8rem !important;
        }
        .stat-card .fs-3 {
            font-size: 1.35rem !important;
        }
        .stat-card .bg-success-subtle,
        .stat-card .bg-primary-subtle,
        .stat-card .bg-warning-subtle,
        .stat-card .bg-danger-subtle {
            padding: 10px !important;
            border-radius: 10px !important;
            margin-right: 12px !important;
        }

        .btn-success {
            background: var(--primary);
            border: none;
            border-radius: 12px;
            padding: 10px 25px;
            font-weight: 600;
        }

        .btn-success:hover {
            background: var(--primary-dark);
        }

        .campaign-card {
            border: none;
            border-radius: 25px;
            overflow: hidden;
            transition: .3s;
            box-shadow: 0 10px 25px rgba(0,0,0,.06);
            background: white;
        }

        .campaign-card:hover {
            transform: translateY(-6px);
        }

        .campaign-card img {
            height: 220px;
            object-fit: cover;
        }

        .progress {
            height: 8px;
            border-radius: 30px;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
            height: 100vh;
            background: var(--primary);
            padding: 18px;
            z-index: 1000;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            transition: .2s;
        }

        .sidebar-menu a:hover {
            background: rgba(255,255,255,.15);
        }

        .sidebar-menu a.active {
            background: white;
            color: var(--primary);
            font-weight: 600;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
        }

        .logo h4 {
            font-size: 1.15rem !important;
        }

        @media(max-width: 992px) {
            .sidebar {
                left: -220px;
                transition: left 0.3s ease;
            }
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            .sidebar.active {
                left: 0;
            }
        }
    </style>
</head>
<body class="antialiased">
    @auth
        <!-- SIDEBAR -->
        <div class="sidebar">
            <div class="logo text-white mb-5">
                <h4 class="fw-bold">💚 Sumsel Peduli</h4>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i> Dashboard
                    </a>
                </li>
                @if (Auth::user()->role === 'admin')
                    <li>
                        <a href="{{ route('admin.verifikasi.campaigns') }}" class="{{ request()->routeIs('admin.verifikasi.campaigns') ? 'active' : '' }}">
                            <i class="bi bi-patch-check"></i> Verifikasi Campaign
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.verifikasi.donations') }}" class="{{ request()->routeIs('admin.verifikasi.donations') ? 'active' : '' }}">
                            <i class="bi bi-cash-stack"></i> Verifikasi Donasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Kelola User
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('campaign.index') }}" class="{{ request()->routeIs('campaign.index') || request()->routeIs('campaign.show') || request()->routeIs('campaign.edit') ? 'active' : '' }}">
                            <i class="bi bi-megaphone"></i> Semua Campaign
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('donation.index') }}" class="{{ request()->routeIs('donation.index') || request()->routeIs('donation.show') || request()->routeIs('donation.edit') ? 'active' : '' }}">
                            <i class="bi bi-cash-stack"></i> Semua Donasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text"></i> Laporan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.statistics') }}" class="{{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
                            <i class="bi bi-bar-chart"></i> Statistik
                        </a>
                    </li>

                @elseif (Auth::user()->role === 'fundraiser')
                    <li>
                        <a href="{{ route('campaign.create') }}" class="{{ request()->routeIs('campaign.create') ? 'active' : '' }}">
                            <i class="bi bi-plus-circle"></i> Buat Campaign
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('campaign.index') }}" class="{{ request()->routeIs('campaign.index') || request()->routeIs('campaign.show') || request()->routeIs('campaign.edit') ? 'active' : '' }}">
                            <i class="bi bi-megaphone"></i> Campaign Saya
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('donation.index') }}" class="{{ request()->routeIs('donation.index') || request()->routeIs('donation.show') || request()->routeIs('donation.edit') ? 'active' : '' }}">
                            <i class="bi bi-cash-stack"></i> Donasi Masuk
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('campaign.index') }}" class="{{ request()->routeIs('campaign.index') || request()->routeIs('campaign.show') ? 'active' : '' }}">
                            <i class="bi bi-megaphone"></i> Cari Campaign
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('donation.index') }}" class="{{ request()->routeIs('donation.index') || request()->routeIs('donation.show') ? 'active' : '' }}">
                            <i class="bi bi-cash-stack"></i> Donasi Saya
                        </a>
                    </li>
                @endif
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </form>
                </li>
            </ul>
        </div>

        <div class="main-content">
            <!-- TOPBAR -->
            <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-2 px-3 rounded-3 shadow-sm">
                <div class="d-flex align-items-center gap-2">
                    @if(!request()->routeIs('dashboard'))
                        <button onclick="window.history.back()" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center border-0 bg-light" style="width: 32px; height: 32px;" title="Kembali">
                            <i class="bi bi-arrow-left fs-6 text-dark"></i>
                        </button>
                    @endif
                    <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.15rem;">@yield('header', 'Dashboard')</h5>
                </div>
                <a href="{{ route('profile.edit') }}" class="d-flex align-items-center gap-2 text-decoration-none text-dark hover-opacity">
                    <div class="text-end me-1">
                        <h6 class="mb-0 fw-bold" style="font-size: 0.9rem;">{{ Auth::user()->name }}</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">{{ ucfirst(Auth::user()->role) }}</small>
                    </div>
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="rounded-circle shadow-sm" width="36" height="36" style="object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=198754&color=fff" class="rounded-circle" width="36">
                    @endif
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    @else
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand fw-bold text-success" href="/">
                    💚 Sumsel Peduli
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto gap-2">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('campaign.index') }}">Campaign</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-success px-4" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-success px-4" href="{{ route('register') }}">Daftar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
