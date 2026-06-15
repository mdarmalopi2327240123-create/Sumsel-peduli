@extends('layouts.app')

@section('header', 'Edit Campaign')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <div class="card-body">
                <h3 class="fw-bold mb-4">Edit Informasi Campaign</h3>
                
                <form action="{{ route('campaign.update', $campaign) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul Campaign</label>
                        <input type="text" name="judul" class="form-control rounded-4 p-3 @error('judul') is-invalid @enderror" value="{{ old('judul', $campaign->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="kategori" class="form-select rounded-4 p-3 @error('kategori') is-invalid @enderror" required>
                                <option value="Kesehatan" {{ old('kategori', $campaign->kategori) == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="Pendidikan" {{ old('kategori', $campaign->kategori) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="Bencana Alam" {{ old('kategori', $campaign->kategori) == 'Bencana Alam' ? 'selected' : '' }}>Bencana Alam</option>
                                <option value="Sosial" {{ old('kategori', $campaign->kategori) == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                <option value="Lingkungan" {{ old('kategori', $campaign->kategori) == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select rounded-4 p-3 @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ old('status', $campaign->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="aktif" {{ old('status', $campaign->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="selesai" {{ old('status', $campaign->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Target Dana (Rp)</label>
                            <input type="number" name="target" class="form-control rounded-4 p-3 @error('target') is-invalid @enderror" value="{{ old('target', $campaign->target) }}" required>
                            @error('target')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Mulai</label>
                            <input type="datetime-local" name="tanggal_mulai" class="form-control rounded-4 p-3 @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $campaign->tanggal_mulai ? date('Y-m-d\TH:i', strtotime($campaign->tanggal_mulai)) : '') }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Selesai</label>
                            <input type="datetime-local" name="tanggal_selesai" class="form-control rounded-4 p-3 @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', $campaign->tanggal_selesai ? date('Y-m-d\TH:i', strtotime($campaign->tanggal_selesai)) : '') }}" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Deskripsi Lengkap</label>
                        <textarea name="deskripsi" class="form-control rounded-4 p-3 @error('deskripsi') is-invalid @enderror" rows="6" required>{{ old('deskripsi', $campaign->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-5">
                        <label class="form-label fw-bold">Foto Campaign (Biarkan kosong jika tidak ingin mengubah)</label>
                        @if($campaign->gambar)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $campaign->gambar) }}" class="img-thumbnail rounded-4" style="max-height: 200px">
                            </div>
                        @endif
                        <input type="file" name="gambar" class="form-control rounded-4 p-3" accept="image/*">
                        @error('gambar')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg py-3 rounded-4 fw-bold">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('campaign.show', $campaign) }}" class="btn btn-light btn-lg py-3 rounded-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
