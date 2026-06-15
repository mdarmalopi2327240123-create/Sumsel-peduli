@extends('layouts.app')

@section('header', 'Verifikasi Campaign')

@section('content')
<div class="card card-custom">
    <div class="card-body p-4">
        <h4 class="fw-bold mb-3">Daftar Pengajuan Campaign Baru</h4>
        <p class="text-muted mb-4">Tinjau dan verifikasi campaign yang diajukan oleh fundraiser agar dapat tampil di publik.</p>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light text-secondary">
                    <tr>
                        <th style="width: 30%">Campaign</th>
                        <th>Pengaju (Fundraiser)</th>
                        <th>Target Dana</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $c)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($c->gambar)
                                    <img src="{{ asset('storage/' . $c->gambar) }}" class="rounded-3 me-3" style="width: 60px; height: 45px; object-fit: cover;">
                                @else
                                    <div class="bg-success-subtle text-success rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 45px;">
                                        <i class="bi bi-megaphone fs-5"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark text-truncate" style="max-width: 250px;">{{ $c->judul }}</div>
                                    <span class="badge bg-success-subtle text-success small rounded-pill px-2">{{ $c->kategori }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $c->user->name }}</div>
                            <small class="text-muted">{{ $c->user->email }}</small>
                        </td>
                        <td class="fw-bold text-success">
                            Rp {{ number_format($c->target, 0, ',', '.') }}
                        </td>
                        <td>
                            <div class="small">Mulai: {{ $c->tanggal_mulai ? $c->tanggal_mulai->format('d M Y') : '-' }}</div>
                            <div class="small text-muted">Selesai: {{ $c->tanggal_selesai ? $c->tanggal_selesai->format('d M Y') : '-' }}</div>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill small">
                                <i class="bi bi-clock me-1"></i> Pending
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('campaign.show', $c) }}" class="btn btn-sm btn-light rounded-pill px-3 fw-semibold">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <form action="{{ route('campaign.verify', $c) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="aktif">
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold">
                                        <i class="bi bi-check-lg"></i> Setujui
                                    </button>
                                </form>
                                <form action="{{ route('campaign.verify', $c) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 fw-semibold">
                                        <i class="bi bi-x-lg"></i> Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <div class="my-3">
                                <i class="bi bi-patch-check text-muted display-4"></i>
                            </div>
                            <h5>Tidak Ada Pengajuan Campaign Pending</h5>
                            <p class="small text-muted">Semua pengajuan campaign telah selesai ditinjau.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $campaigns->links() }}
        </div>
    </div>
</div>
@endsection
