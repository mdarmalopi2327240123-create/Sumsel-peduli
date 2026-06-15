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
            <img src="{{ $campaign->image_url }}" class="card-img-top" style="height: 200px; object-fit: cover;">
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
