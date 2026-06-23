@extends('layouts.app')

@section('header', 'Riwayat Donasi')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="fw-bold">Riwayat Donasi</h2>
        <p class="text-muted">Daftar kontribusi kebaikan yang telah Anda berikan</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('campaign.index') }}" class="btn btn-success">
            <i class="bi bi-heart me-2"></i> Donasi Sekarang
        </a>
    </div>
</div>

<div class="card card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3">Kampanye</th>
                        <th class="py-3">Jumlah</th>
                        <th class="py-3">Metode</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Tanggal</th>
                        <th class="pe-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold">{{ $donation->campaign->judul }}</div>
                            <small class="text-muted">ID: #{{ $donation->transaction_id ?? $donation->id }}</small>
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                        <td>{{ $donation->payment_method }}</td>
                        <td>
                            <span class="badge {{ $donation->status == 'completed' ? 'bg-success' : ($donation->status == 'failed' ? 'bg-danger' : 'bg-warning') }} rounded-pill px-3">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </td>
                        <td>{{ $donation->created_at->format('d M Y H:i') }}</td>
                        <td class="pe-4 text-center">
                            <a href="{{ route('donation.show', $donation) }}" class="btn btn-light btn-sm rounded-pill px-3">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-cash-stack text-muted display-1 mb-3"></i>
                            <h3>Belum ada donasi</h3>
                            <p class="text-muted">Anda belum memiliki riwayat donasi.</p>
                        </td>
                    </tr>
                    @endforelse//tujuan menampilkan perulangan
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $donations->links() }}
</div>
@endsection
