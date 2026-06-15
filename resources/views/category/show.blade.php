@extends('layouts.app')

@section('header', $category->nama)

@section('content')
<div class="mb-4">
    <div class="d-flex align-items-center gap-3 mb-4">
        <span style="font-size: 3rem;">{{ $category->icon }}</span>
        <div>
            <h2 class="fw-bold mb-1">{{ $category->nama }}</h2>
            <p class="text-muted mb-0">{{ $category->deskripsi }}</p>
        </div>
    </div>
</div>

<h4 class="fw-bold mb-3">Campaign di Kategori Ini ({{ $campaigns->total() }})</h4>

<div class="row g-4">
    @forelse($campaigns as $campaign)
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            @if($campaign->gambar)
                <img src="{{ asset('storage/' . $campaign->gambar) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
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
                    <text x="250" y="240" fill="#ffffff" opacity="0.6" font-family="'Poppins', sans-serif" font-size="18" font-weight="700" text-anchor="middle" letter-spacing="1">{{ strtoupper($category->nama ?? 'Kebaikan') }}</text>
                </svg>
            @endif
            <div class="card-body">
                <h5 class="fw-bold mb-2">{{ Str::limit($campaign->judul, 50) }}</h5>
                <p class="text-muted small mb-3">{{ Str::limit($campaign->deskripsi, 80) }}</p>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <small class="fw-bold">Rp {{ number_format($campaign->terkumpul, 0, ',', '.') }}</small>
                        <small class="text-muted">{{ round($campaign->getProgressPercentage()) }}%</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ min($campaign->getProgressPercentage(), 100) }}%"></div>
                    </div>
                </div>
                <a href="{{ route('campaign.show', $campaign) }}" class="btn btn-success btn-sm w-100">Lihat Detail</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">Tidak ada campaign di kategori ini</div>
    </div>
    @endforelse
</div>

{{ $campaigns->links() }}
@endsection
