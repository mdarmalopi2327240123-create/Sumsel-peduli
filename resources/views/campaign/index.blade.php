@extends('layouts.app')

@section('header', 'Daftar Campaign')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="fw-bold">Kampanye Penggalangan Dana</h2>
        <p class="text-muted">Bantu sesama melalui donasi yang transparan</p>
    </div>
    @auth
    <div class="col-auto">
        <a href="{{ route('campaign.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-2"></i> Buat Campaign
        </a>
    </div>
    @endauth
</div>

<div class="row g-4">
    @forelse($campaigns as $campaign)
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
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-success-subtle text-success rounded-pill px-3">{{ $campaign->kategori ?? 'Umum' }}</span>
                    <span class="badge {{ $campaign->status == 'aktif' ? 'bg-primary' : ($campaign->status == 'selesai' ? 'bg-secondary' : 'bg-warning') }} rounded-pill px-3">
                        {{ ucfirst($campaign->status) }}
                    </span>
                </div>
                <h5 class="card-title fw-bold mb-3">{{ $campaign->judul }}</h5>
                <p class="card-text text-muted small mb-4">{{ Str::limit($campaign->deskripsi, 100) }}</p>
                
                <div class="mb-3 mt-auto">
                    <div class="d-flex justify-content-between mb-1 small">
                        <span class="fw-bold text-success">Rp {{ number_format($campaign->terkumpul, 0, ',', '.') }}</span>
                        <span class="text-muted">{{ round($campaign->getProgressPercentage()) }}%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ min($campaign->getProgressPercentage(), 100) }}%"></div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <div class="small">
                        <div class="text-muted">Target:</div>
                        <div class="fw-bold">Rp {{ number_format($campaign->target, 0, ',', '.') }}</div>
                    </div>
                    <a href="{{ route('campaign.show', $campaign) }}" class="btn btn-success btn-sm px-4">Detail</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="card card-custom py-5">
            <i class="bi bi-megaphone text-muted display-1 mb-3"></i>
            <h3>Belum ada campaign</h3>
            <p class="text-muted">Jadilah yang pertama membuat campaign kebaikan!</p>
            @auth
            <div class="mt-3">
                <a href="{{ route('campaign.create') }}" class="btn btn-success">Buat Campaign Sekarang</a>
            </div>
            @endauth
        </div>
    </div>
    @endforelse
</div>

<div class="mt-5 d-flex justify-content-center">
    {{ $campaigns->links() }}
</div>
@endsection
