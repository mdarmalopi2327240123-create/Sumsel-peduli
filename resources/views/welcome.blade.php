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
            <div class="col-lg-6 d-none d-lg-block text-center">
                <img src="{{ asset('images/hero_charity.png') }}" alt="Sumsel Peduli" class="img-fluid rounded-5 shadow-lg w-100" style="object-fit: cover; max-height: 450px;">
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
                <img src="{{ $campaign->image_url }}" class="card-img-top" alt="{{ $campaign->judul }}" style="height: 200px; object-fit: cover;">
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
