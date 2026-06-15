@extends('layouts.app')

@section('header', $campaignUpdate->judul)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h2 class="fw-bold mb-2">{{ $campaignUpdate->judul }}</h2>
                        <small class="text-muted">
                            <i class="bi bi-megaphone"></i> {{ $campaignUpdate->campaign->judul }}<br>
                            <i class="bi bi-person"></i> {{ $campaignUpdate->user->name }}<br>
                            <i class="bi bi-clock"></i> {{ $campaignUpdate->created_at->format('d M Y H:i') }}
                        </small>
                    </div>
                    @if(Auth::id() === $campaignUpdate->user_id)
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">⋮</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('campaign-update.edit', $campaignUpdate) }}">Edit</a></li>
                            <li><form action="{{ route('campaign-update.destroy', $campaignUpdate) }}" method="POST" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Yakin?')">Hapus</button>
                            </form></li>
                        </ul>
                    </div>
                    @endif
                </div>

                @if($campaignUpdate->gambar)
                <img src="{{ asset('storage/' . $campaignUpdate->gambar) }}" class="img-fluid rounded mb-4" style="max-height: 400px; object-fit: cover; width: 100%;">
                @endif

                <div class="content mb-4">
                    {!! nl2br(e($campaignUpdate->konten)) !!}
                </div>

                <hr>

                <a href="{{ route('campaign.show', $campaignUpdate->campaign) }}" class="btn btn-success">← Kembali ke Kampanye</a>
            </div>
        </div>
    </div>
</div>
@endsection
