@extends('layouts.app')

@section('header', 'Unggah Bukti Transfer')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card card-custom p-4">
            <div class="card-body">
                <h3 class="fw-bold mb-2">Unggah Bukti Pembayaran</h3>
                <p class="text-muted small mb-4">Silakan unggah bukti transfer ATM / M-Banking untuk menyelesaikan transaksi donasi Anda.</p>
                
                <div class="bg-light p-3 rounded-4 mb-4">
                    <div class="row g-2 small">
                        <div class="col-6 text-muted">ID Transaksi:</div>
                        <div class="col-6 fw-bold text-end">{{ $donation->transaction_id }}</div>
                        
                        <div class="col-6 text-muted">Kampanye:</div>
                        <div class="col-6 fw-bold text-end text-truncate" style="max-width: 160px;">{{ $donation->campaign->judul }}</div>
                        
                        <div class="col-6 text-muted">Nominal Transfer:</div>
                        <div class="col-6 fw-bold text-end text-success fs-6">Rp {{ number_format($donation->amount, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="border border-success border-2 border-dashed rounded-4 p-4 text-center bg-success-subtle mb-4">
                    <h6 class="fw-bold mb-1">🏦 Rekening Tujuan Transfer:</h6>
                    <p class="mb-0 fs-5 fw-bold text-success">Bank BCA - 123456789</p>
                    <small class="text-muted">a/n Yayasan Sumsel Peduli</small>
                </div>

                <form action="{{ route('donation.upload-proof.submit', $donation) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="bukti_transfer" class="form-label fw-bold">Pilih Berkas Gambar (JPEG, PNG, JPG)</label>
                        <input type="file" name="bukti_transfer" id="bukti_transfer" class="form-control rounded-3 @error('bukti_transfer') is-invalid @enderror" accept="image/*" required>
                        @error('bukti_transfer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text small">Maksimal ukuran file: 2MB</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success py-2 rounded-pill fw-bold">Kirim Bukti Pembayaran</button>
                        <a href="{{ route('donation.show', $donation) }}" class="btn btn-light py-2 rounded-pill">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
