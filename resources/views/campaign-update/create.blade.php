@extends('layouts.app')

@section('header', 'Tambah Update Kampanye')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-5">
                <h3 class="fw-bold mb-2">Tambah Update untuk</h3>
                <h5 class="text-success mb-4">{{ $campaign->judul }}</h5>
                
                <form action="{{ route('campaign-update.store', $campaign) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Update</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}" required>
                        @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Konten</label>
                        <textarea class="form-control @error('konten') is-invalid @enderror" name="konten" rows="6" required>{{ old('konten') }}</textarea>
                        @error('konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Gambar (Opsional)</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar" accept="image/*">
                        @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success flex-grow-1">Posting Update</button>
                        <a href="{{ route('campaign.show', $campaign) }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
