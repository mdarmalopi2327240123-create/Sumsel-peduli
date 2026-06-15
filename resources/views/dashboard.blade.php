@extends('layouts.app')

@section('header')
    Dashboard {{ ucfirst($role) }}
@endsection

@section('content')
@if ($role === 'admin')
    <!-- ==================== ADMIN DASHBOARD ==================== -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-subtle p-3 rounded-4 me-3">
                            <i class="bi bi-megaphone text-success fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $totalCampaigns }}</h3>
                            <small class="text-muted">Total Campaign</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-subtle p-3 rounded-4 me-3">
                            <i class="bi bi-heart-fill text-primary fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $activeCampaigns }}</h3>
                            <small class="text-muted">Campaign Aktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-subtle p-3 rounded-4 me-3">
                            <i class="bi bi-cash-coin text-warning fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">Rp {{ number_format($totalDonated / 1000000, 1) }}Jt</h3>
                            <small class="text-muted">Total Donasi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger-subtle p-3 rounded-4 me-3">
                            <i class="bi bi-people-fill text-danger fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $totalUsers }}</h3>
                            <small class="text-muted">Total Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Antrean Verifikasi Section -->
    <div class="row g-4 mb-5">
        <!-- Verifikasi Campaign -->
        <div class="col-lg-6">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4 text-success"><i class="bi bi-patch-check-fill"></i> Menunggu Verifikasi Campaign</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Campaign</th>
                                    <th>Pengaju</th>
                                    <th>Target</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingCampaigns as $c)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-truncate" style="max-width: 150px;">{{ $c->judul }}</div>
                                        <small class="text-muted">{{ $c->kategori }}</small>
                                    </td>
                                    <td>{{ $c->user->name }}</td>
                                    <td>Rp {{ number_format($c->target, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('campaign.show', $c) }}" class="btn btn-sm btn-success rounded-pill px-3">Tinjau</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Tidak ada campaign yang butuh verifikasi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verifikasi Donasi -->
        <div class="col-lg-6">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4 text-success"><i class="bi bi-cash-stack"></i> Menunggu Verifikasi Pembayaran</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Donatur</th>
                                    <th>Nominal</th>
                                    <th>Metode</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingDonations as $d)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $d->donor_name }}</div>
                                        <small class="text-muted">{{ $d->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>Rp {{ number_format($d->amount, 0, ',', '.') }}</td>
                                    <td>{{ $d->payment_method }}</td>
                                    <td>
                                        <a href="{{ route('donation.show', $d) }}" class="btn btn-sm btn-success rounded-pill px-3">Tinjau</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Tidak ada donasi yang butuh verifikasi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Section -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Tren Donasi Global (6 Bulan Terakhir)</h5>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="donationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Status Seluruh Campaign</h5>
                    <div style="position: relative; height: 300px; width: 100%; display: flex; align-items: center; justify-content: center;">
                        <canvas id="statusChart" style="max-height: 280px; max-width: 280px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Campaign Per Kategori</h5>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Top 5 Campaign Terbesar</h5>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="topCampaignChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

@elseif ($role === 'fundraiser')
    <!-- ==================== FUNDRAISER DASHBOARD ==================== -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-subtle p-3 rounded-4 me-3">
                            <i class="bi bi-megaphone text-success fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $totalCampaigns }}</h3>
                            <small class="text-muted">Campaign Saya</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-subtle p-3 rounded-4 me-3">
                            <i class="bi bi-heart-fill text-primary fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $activeCampaigns }}</h3>
                            <small class="text-muted">Campaign Aktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-subtle p-3 rounded-4 me-3">
                            <i class="bi bi-cash-coin text-warning fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">Rp {{ number_format($totalCollected, 0, ',', '.') }}</h3>
                            <small class="text-muted">Dana Terkumpul</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger-subtle p-3 rounded-4 me-3">
                            <i class="bi bi-people-fill text-danger fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $totalDonations }}</h3>
                            <small class="text-muted">Penyalur Donasi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Section -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Tren Donasi Masuk (6 Bulan Terakhir)</h5>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="donationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Status Campaign Saya</h5>
                    <div style="position: relative; height: 300px; width: 100%; display: flex; align-items: center; justify-content: center;">
                        <canvas id="statusChart" style="max-height: 280px; max-width: 280px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Daftar Campaign Saya -->
        <div class="col-lg-8">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Kampanye Saya</h5>
                        <a href="{{ route('campaign.index') }}" class="text-success text-decoration-none small fw-bold">Lihat Semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Kampanye</th>
                                    <th>Target</th>
                                    <th>Dana</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCampaigns as $c)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($c->judul, 25) }}</div>
                                        <small class="text-muted">{{ $c->kategori }}</small>
                                    </td>
                                    <td>Rp {{ number_format($c->target, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($c->terkumpul, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $c->status === 'aktif' ? 'success' : ($c->status === 'pending' ? 'warning' : 'danger') }} rounded-pill">
                                            {{ ucfirst($c->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('campaign.show', $c) }}" class="btn btn-light btn-sm rounded-pill">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada campaign dibuat. <a href="{{ route('campaign.create') }}">Buat baru</a></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donasi Baru Masuk -->
        <div class="col-lg-4">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Donasi Terbaru Masuk</h5>
                    <div class="list-group list-group-flush">
                        @forelse($recentDonations as $d)
                        <div class="list-group-item px-0 py-3 border-0 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="bg-light p-2 rounded-circle me-3">
                                    <i class="bi bi-person text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 fw-bold">{{ $d->donor_name }}</h6>
                                        <span class="text-success fw-bold">Rp {{ number_format($d->amount, 0, ',', '.') }}</span>
                                    </div>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 200px;">{{ $d->campaign->judul }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">Belum ada donasi masuk.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

@else
    <!-- ==================== DONATUR DASHBOARD ==================== -->
    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-subtle p-3 rounded-4 me-3">
                            <i class="bi bi-wallet2 text-success fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">Rp {{ number_format($totalDonated, 0, ',', '.') }}</h3>
                            <small class="text-muted">Total Donasi Saya</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-subtle p-3 rounded-4 me-3">
                            <i class="bi bi-heart-fill text-primary fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $supportedCampaignsCount }}</h3>
                            <small class="text-muted">Campaign Didukung</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-subtle p-3 rounded-4 me-3">
                            <i class="bi bi-award text-warning fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">{{ $certificates->count() }}</h3>
                            <small class="text-muted">Sertifikat Terbit</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Tren & Riwayat Donasi -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Tren Kontribusi Donasi Bulanan</h5>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="donationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-custom h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Sertifikat Penghargaan</h5>
                    <div class="list-group list-group-flush">
                        @forelse($certificates as $cert)
                        <div class="list-group-item px-0 py-3 border-0 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-0 text-truncate" style="max-width: 180px;">{{ $cert->donation->campaign->judul }}</h6>
                                    <small class="text-muted">{{ date('d M Y', strtotime($cert->tanggal_terbit)) }}</small>
                                </div>
                                <a href="{{ route('donation.certificate', $cert->donation_id) }}" class="btn btn-outline-success btn-sm rounded-pill"><i class="bi bi-download"></i> Cetak</a>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">Sertifikat akan terbit otomatis setelah donasi disetujui admin.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Donasi -->
    <div class="card card-custom mb-5">
        <div class="card-body">
            <h5 class="fw-bold mb-4">Riwayat Donasi Saya</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Campaign</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donations as $d)
                        <tr>
                            <td class="fw-bold">{{ $d->transaction_id }}</td>
                            <td>{{ $d->campaign->judul }}</td>
                            <td>Rp {{ number_format($d->amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $d->status === 'completed' ? 'success' : ($d->status === 'pending' ? 'warning' : 'danger') }} rounded-pill">
                                    {{ $d->status === 'completed' ? 'Telah Diverifikasi' : ($d->status === 'pending' ? 'Menunggu Verifikasi' : 'Gagal') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('donation.show', $d) }}" class="btn btn-light btn-sm rounded-pill px-3">Detail</a>
                                @if ($d->status === 'pending' && !$d->bukti_transfer)
                                    <a href="{{ route('donation.upload-proof', $d) }}" class="btn btn-warning btn-sm rounded-pill px-3 text-white">Upload Bukti</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat donasi. <a href="{{ route('campaign.index') }}">Mulai Donasi</a></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

<!-- Scripts Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if ($role === 'admin')
            // Donasi Per Bulan
            const donationCtx = document.getElementById('donationChart').getContext('2d');
            new Chart(donationCtx, {
                type: 'line',
                data: {
                    labels: @json($monthLabels),
                    datasets: [{
                        label: 'Donasi Global (Rp)',
                        data: @json($donationsByMonth),
                        borderColor: '#198754',
                        backgroundColor: 'rgba(25, 135, 84, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Status Campaign
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($statusLabels),
                    datasets: [{
                        data: @json($statusData),
                        backgroundColor: ['#198754', '#ffc107', '#dc3545', '#6c757d']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Category Chart
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'bar',
                data: {
                    labels: @json($categoryLabels),
                    datasets: [{
                        label: 'Jumlah Campaign',
                        data: @json($categoryData),
                        backgroundColor: '#198754'
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Top Campaigns
            const topCampaignCtx = document.getElementById('topCampaignChart').getContext('2d');
            new Chart(topCampaignCtx, {
                type: 'bar',
                data: {
                    labels: @json($topCampaignLabels),
                    datasets: [{
                        label: 'Dana Terkumpul (Rp)',
                        data: @json($topCampaignData),
                        backgroundColor: '#0d6efd'
                    }]
                },
                options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false }
            });
        @endif

        @if ($role === 'fundraiser')
            // Donasi Per Bulan (Fundraiser Campaigns)
            const donationCtx = document.getElementById('donationChart').getContext('2d');
            new Chart(donationCtx, {
                type: 'line',
                data: {
                    labels: @json($monthLabels),
                    datasets: [{
                        label: 'Donasi Masuk (Rp)',
                        data: @json($donationsByMonth),
                        borderColor: '#198754',
                        backgroundColor: 'rgba(25, 135, 84, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Status Campaign (Fundraiser Campaigns)
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($statusLabels),
                    datasets: [{
                        data: @json($statusData),
                        backgroundColor: ['#ffc107', '#198754', '#0d6efd', '#dc3545']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        @endif

        @if ($role === 'donatur')
            // Donasi Per Bulan (Pribadi)
            const donationCtx = document.getElementById('donationChart').getContext('2d');
            new Chart(donationCtx, {
                type: 'line',
                data: {
                    labels: @json($monthLabels),
                    datasets: [{
                        label: 'Kontribusi Donasi (Rp)',
                        data: @json($donationsByMonth),
                        borderColor: '#198754',
                        backgroundColor: 'rgba(25, 135, 84, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        @endif
    });
</script>
@endsection
