@extends('layouts.app')

@section('header', 'Verifikasi Donasi')

@section('content')
<div class="card card-custom">
    <div class="card-body p-4">
        <h4 class="fw-bold mb-3">Daftar Verifikasi Pembayaran Donasi</h4>
        <p class="text-muted mb-4">Periksa bukti transfer donatur dan lakukan verifikasi pembayaran agar dana terhitung masuk ke campaign terkait.</p>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light text-secondary">
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Donatur</th>
                        <th>Campaign</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Bukti Transfer</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $d)
                    <tr>
                        <td class="fw-bold text-dark">{{ $d->transaction_id }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $d->donor_name }}</div>
                            <small class="text-muted">{{ $d->donor_email }}</small>
                            @if($d->donor_phone)
                                <div class="small text-muted"><i class="bi bi-telephone"></i> {{ $d->donor_phone }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="text-truncate fw-medium" style="max-width: 200px;">{{ $d->campaign->judul }}</div>
                            <small class="text-muted">Kategori: {{ $d->campaign->kategori }}</small>
                        </td>
                        <td class="fw-bold text-success">
                            Rp {{ number_format($d->amount, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-pill small">{{ $d->payment_method }}</span>
                        </td>
                        <td>
                            @if($d->bukti_transfer)
                                <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#proofModal{{ $d->id }}">
                                    <i class="bi bi-image"></i> Lihat Bukti
                                </button>

                                <!-- Modal Bukti Transfer -->
                                <div class="modal fade" id="proofModal{{ $d->id }}" tabindex="-1" aria-labelledby="proofModalLabel{{ $d->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold" id="proofModalLabel{{ $d->id }}">Bukti Transfer - {{ $d->donor_name }}</h5>
                                                <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#proofModal{{ $d->id }}" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center p-4">
                                                <img src="{{ asset('storage/' . $d->bukti_transfer) }}" class="img-fluid rounded-3 shadow-sm" style="max-height: 450px;">
                                                <div class="mt-3 text-muted small">
                                                    Jumlah Ditransfer: <span class="fw-bold text-success">Rp {{ number_format($d->amount, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light border-0 justify-content-center">
                                                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-danger small fw-semibold"><i class="bi bi-exclamation-triangle"></i> Belum Upload Bukti</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('donation.show', $d) }}" class="btn btn-sm btn-light rounded-pill px-3 fw-semibold">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                @if($d->bukti_transfer)
                                    <form action="{{ route('donation.verify', $d) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold">
                                            <i class="bi bi-check-lg"></i> Terima
                                        </button>
                                    </form>
                                    <form action="{{ route('donation.verify', $d) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="failed">
                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 fw-semibold">
                                            <i class="bi bi-x-lg"></i> Tolak
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <div class="my-3">
                                <i class="bi bi-cash-stack text-muted display-4"></i>
                            </div>
                            <h5>Tidak Ada Antrean Verifikasi Donasi</h5>
                            <p class="small text-muted">Semua pembayaran donasi telah selesai diverifikasi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $donations->links() }}
        </div>
    </div>
</div>
@endsection
