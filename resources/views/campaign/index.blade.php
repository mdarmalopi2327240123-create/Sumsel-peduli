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
            <img src="{{ $campaign->image_url }}" class="card-img-top" alt="{{ $campaign->judul }}" style="height: 200px; object-fit: cover;">
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
