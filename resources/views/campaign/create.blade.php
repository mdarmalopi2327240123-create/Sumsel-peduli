@extends('layouts.app')

@section('header', 'Buat Campaign Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <div class="card-body">
                <h3 class="fw-bold mb-4">Informasi Campaign</h3>
                
                <form action="{{ route('campaign.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul Campaign</label>
                        <input type="text" name="judul" class="form-control rounded-4 p-3 @error('judul') is-invalid @enderror" placeholder="Contoh: Bantu Pengobatan Anak Penderita Jantung" value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="kategori" class="form-select rounded-4 p-3 @error('kategori') is-invalid @enderror" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="Kesehatan" {{ old('kategori') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="Pendidikan" {{ old('kategori') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="Bencana Alam" {{ old('kategori') == 'Bencana Alam' ? 'selected' : '' }}>Bencana Alam</option>
                                <option value="Sosial" {{ old('kategori') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                <option value="Lingkungan" {{ old('kategori') == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Target Dana (Rp)</label>
                            <input type="number" name="target" class="form-control rounded-4 p-3 @error('target') is-invalid @enderror" placeholder="Contoh: 20000000" value="{{ old('target') }}" required>
                            @error('target')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Mulai</label>
                            <input type="datetime-local" name="tanggal_mulai" class="form-control rounded-4 p-3 @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai') }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Selesai</label>
                            <input type="datetime-local" name="tanggal_selesai" class="form-control rounded-4 p-3 @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai') }}" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Deskripsi Lengkap</label>
                        <textarea name="deskripsi" class="form-control rounded-4 p-3 @error('deskripsi') is-invalid @enderror" rows="6" placeholder="Ceritakan latar belakang dan tujuan penggalangan dana ini..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-5">
                        <label class="form-label fw-bold">Foto Utama Campaign</label>
                        <div class="p-4 text-center border rounded-4 bg-light">
                            <i class="bi bi-cloud-arrow-up display-4 text-success mb-2"></i>
                            <p class="mb-2">Klik untuk upload gambar</p>
                            <input type="file" name="gambar" class="form-control mt-3" accept="image/*">
                        </div>
                        @error('gambar')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg py-3 rounded-4 fw-bold">
                            Ajukan Campaign
                        </button>
                        <a href="{{ route('campaign.index') }}" class="btn btn-light btn-lg py-3 rounded-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
