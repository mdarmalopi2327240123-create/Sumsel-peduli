@extends('layouts.app')

@section('header', 'Update Kampanye')

@section('content')
<div class="row g-4">
    @forelse($updates as $update)
    <div class="col-lg-8 offset-lg-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">{{ $update->judul }}</h5>
                        <small class="text-muted">
                            <i class="bi bi-megaphone"></i> {{ $update->campaign->judul }} 
                            <br>
                            <i class="bi bi-person"></i> {{ $update->user->name }} 
                            <i class="bi bi-clock"></i> {{ $update->created_at->diffForHumans() }}
                        </small>
                    </div>
                    @if(Auth::id() === $update->user_id)
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">⋮</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('campaign-update.edit', $update) }}">Edit</a></li>
                            <li><form action="{{ route('campaign-update.destroy', $update) }}" method="POST" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Yakin?')">Hapus</button>
                            </form></li>
                        </ul>
                    </div>
                    @endif
                </div>
                <p class="mb-3">{{ $update->konten }}</p>
                @if($update->gambar)
                <img src="{{ asset('storage/' . $update->gambar) }}" class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
                @endif
                <a href="{{ route('campaign-update.show', $update) }}" class="btn btn-sm btn-success">Baca Selengkapnya</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">Tidak ada update kampanye</div>
    </div>
    @endforelse
</div>

{{ $updates->links() }}
@endsection
