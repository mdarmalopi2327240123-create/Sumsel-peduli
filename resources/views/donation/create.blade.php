@extends('layouts.app')

@section('header', 'Beri Donasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <div class="card-body">
                <h3 class="fw-bold mb-4">Formulir Donasi</h3>
                
                <form action="{{ route('donation.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Pilih Campaign</label>
                        <select name="campaign_id" class="form-select rounded-4 p-3 @error('campaign_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Campaign yang ingin dibantu</option>
                            @foreach($campaigns as $campaign)
                                <option value="{{ $campaign->id }}" {{ (request('campaign_id') == $campaign->id || old('campaign_id') == $campaign->id) ? 'selected' : '' }}>
                                    {{ $campaign->judul }} (Target: Rp {{ number_format($campaign->target, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                        @error('campaign_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Donatur</label>
                        <input type="text" name="donor_name" class="form-control rounded-4 p-3 @error('donor_name') is-invalid @enderror" value="{{ old('donor_name', Auth::user()->name) }}" required>
                        @error('donor_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Email Donatur</label>
                        <input type="email" name="donor_email" class="form-control rounded-4 p-3 @error('donor_email') is-invalid @enderror" value="{{ old('donor_email', Auth::user()->email) }}" required>
                        @error('donor_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Jumlah Donasi (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-4 bg-light border-end-0">Rp</span>
                            <input type="number" name="amount" class="form-control rounded-end-4 p-3 border-start-0 @error('amount') is-invalid @enderror" placeholder="Contoh: 100000" value="{{ old('amount') }}" required>
                        </div>
                        @error('amount')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Metode Pembayaran</label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="payment_method" id="bank_transfer" value="Transfer Bank" {{ old('payment_method') == 'Transfer Bank' ? 'checked' : '' }} required>
                                <label class="btn btn-outline-success w-100 p-3 rounded-4 text-start" for="bank_transfer">
                                    <i class="bi bi-bank me-2"></i> Transfer Bank
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="payment_method" id="e_wallet" value="E-Wallet" {{ old('payment_method') == 'E-Wallet' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success w-100 p-3 rounded-4 text-start" for="e_wallet">
                                    <i class="bi bi-wallet2 me-2"></i> E-Wallet
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="payment_method" id="credit_card" value="Kartu Kredit" {{ old('payment_method') == 'Kartu Kredit' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success w-100 p-3 rounded-4 text-start" for="credit_card">
                                    <i class="bi bi-credit-card me-2"></i> Kartu Kredit
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="payment_method" id="installment" value="Cicilan" {{ old('payment_method') == 'Cicilan' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success w-100 p-3 rounded-4 text-start" for="installment">
                                    <i class="bi bi-calendar-check me-2"></i> Cicilan
                                </label>
                            </div>
                        </div>
                        @error('payment_method')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Pesan Kebaikan (Opsional)</label>
                        <textarea name="notes" class="form-control rounded-4 p-3" rows="3" placeholder="Tuliskan doa atau pesan penyemangat...">{{ old('notes') }}</textarea>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg py-3 rounded-4 fw-bold">
                            Konfirmasi Donasi
                        </button>
                        <a href="{{ route('campaign.index') }}" class="btn btn-light btn-lg py-3 rounded-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
