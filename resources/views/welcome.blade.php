@extends('layouts.app')

@section('content')
<section class="hero rounded-5 mb-5 overflow-hidden shadow-lg text-white" style="background: linear-gradient(135deg, #198754 0%, #115e3b 100%);">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 px-4">
                <h1 class="display-4 fw-bold mb-4 text-white">Mari Bantu Sesama Melalui Donasi Yang Transparan</h1>
                <p class="lead mb-5 text-white opacity-75">Platform penggalangan dana terpercaya untuk membantu masyarakat Sumatera Selatan. Bersama kita bisa membuat perubahan.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('campaign.index') }}" class="btn btn-light text-success btn-lg px-4 py-3 fw-bold rounded-4 shadow">
                        Donasi Sekarang
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 py-3 fw-bold rounded-4">
                        Gabung
                    </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <svg viewBox="0 0 800 600" width="100%" class="img-fluid rounded-5 shadow-lg" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15);">
                    <defs>
                        <linearGradient id="heroGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#ffffff;stop-opacity:0.25" />
                            <stop offset="100%" style="stop-color:#ffffff;stop-opacity:0.02" />
                        </linearGradient>
                        <linearGradient id="accentGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#20c997;stop-opacity:0.4" />
                            <stop offset="100%" style="stop-color:#198754;stop-opacity:0.1" />
                        </linearGradient>
                    </defs>

                    <!-- Background decorations -->
                    <rect width="800" height="600" fill="url(#accentGrad)" rx="30" />
                    <circle cx="650" cy="150" r="250" fill="url(#heroGrad)" />
                    <circle cx="150" cy="450" r="180" fill="url(#heroGrad)" />

                    <!-- Hands / Helping Abstract Icon in center -->
                    <g transform="translate(352, 210) scale(4)" fill="#ffffff" opacity="0.85">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </g>

                    <!-- Premium Typography watermark -->
                    <text x="400" y="450" fill="#ffffff" opacity="0.75" font-family="'Poppins', sans-serif" font-size="32" font-weight="700" text-anchor="middle" letter-spacing="4">SUMSEL PEDULI</text>
                    <text x="400" y="490" fill="#ffffff" opacity="0.5" font-family="'Poppins', sans-serif" font-size="18" text-anchor="middle">Mari Berbagi, Tumbuhkan Harapan</text>
                </svg>
            </div>
        </div>
    </div>
</section>

<section class="mb-5">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card stat-card text-center p-4">
                <h2 class="fw-bold text-success mb-1">5000+</h2>
                <p class="text-muted mb-0">Donatur</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center p-4">
                <h2 class="fw-bold text-success mb-1">250+</h2>
                <p class="text-muted mb-0">Campaign</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center p-4">
                <h2 class="fw-bold text-success mb-1">Rp 1.2M</h2>
                <p class="text-muted mb-0">Dana Terkumpul</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center p-4">
                <h2 class="fw-bold text-success mb-1">180+</h2>
                <p class="text-muted mb-0">Campaign Selesai</p>
            </div>
        </div>
    </div>
</section>

<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Campaign Populer</h2>
        <a href="{{ route('campaign.index') }}" class="text-success fw-bold text-decoration-none">Lihat Semua →</a>
    </div>
    <div class="row g-4">
        @foreach($campaigns->take(3) as $campaign)
        <div class="col-lg-4 col-md-6">
            <div class="card campaign-card h-100">
                @if($campaign->gambar)
                    <img src="{{ $campaign->gambar }}" class="card-img-top" alt="{{ $campaign->judul }}" style="height: 200px; object-fit: cover;">
                @else
                    <svg class="card-img-top" viewBox="0 0 500 300" width="100%" style="height: 200px; background: linear-gradient(135deg, #198754 0%, #115e3b 100%);">
                        <defs>
                            <linearGradient id="cardGrad{{ $campaign->id }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#198754;stop-opacity:0.8" />
                                <stop offset="100%" style="stop-color:#0f5132;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <rect width="500" height="300" fill="url(#cardGrad{{ $campaign->id }})" />
                        <path d="M 0,150 Q 125,50 250,150 T 500,150 L 500,300 L 0,300 Z" fill="#ffffff" opacity="0.08" />
                        <path d="M 0,200 Q 150,120 300,220 T 500,200 L 500,300 L 0,300 Z" fill="#ffffff" opacity="0.04" />
                        <g transform="translate(238, 90) scale(2)" fill="#ffffff" opacity="0.25">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </g>
                        <text x="250" y="240" fill="#ffffff" opacity="0.6" font-family="'Poppins', sans-serif" font-size="18" font-weight="700" text-anchor="middle" letter-spacing="1">{{ strtoupper($campaign->kategori ?? 'Kebaikan') }}</text>
                    </svg>
                @endif
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 mb-2 align-self-start">{{ $campaign->kategori }}</span>
                    <h5 class="card-title fw-bold mb-3">{{ $campaign->judul }}</h5>
                    
                    <div class="mb-3 mt-auto">
                        <div class="d-flex justify-content-between mb-1 small">
                            <span class="fw-bold text-success">Rp {{ number_format($campaign->terkumpul, 0, ',', '.') }}</span>
                            <span class="text-muted">{{ round($campaign->getProgressPercentage()) }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ min($campaign->getProgressPercentage(), 100) }}%"></div>
                        </div>
                    </div>
                    
                    <a href="{{ route('campaign.show', $campaign) }}" class="btn btn-success w-100 rounded-4 py-2 mt-2">Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<footer class="bg-success text-white rounded-5 p-5 mt-5 text-center">
    <h3 class="fw-bold mb-3">💚 Sumsel Peduli</h3>
    <p class="opacity-75 mb-4">Platform Donasi dan Crowdfunding Masyarakat Sumatera Selatan</p>
    <hr class="opacity-25 mb-4">
    <p class="small mb-0">© 2026 Sumsel Peduli. All rights reserved.</p>
</footer>
@endsection
