@extends('layouts.app')

@section('header', 'Laporan Sistem')

@section('content')
<div class="row g-4 mb-4">
    <!-- Total Donasi -->
    <div class="col-md-3">
        <div class="card card-custom h-100 bg-white">
            <div class="card-body text-center p-4">
                <div class="bg-success-subtle rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                    <i class="bi bi-cash-coin text-success fs-4"></i>
                </div>
                <h3 class="fw-bold text-success mb-1">Rp {{ number_format($totalDonationAmount, 0, ',', '.') }}</h3>
                <p class="text-muted mb-0">Total Donasi Terkumpul</p>
            </div>
        </div>
    </div>
    
    <!-- Total Campaign -->
    <div class="col-md-3">
        <div class="card card-custom h-100 bg-white">
            <div class="card-body text-center p-4">
                <div class="bg-primary-subtle rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                    <i class="bi bi-megaphone-fill text-primary fs-4"></i>
                </div>
                <h3 class="fw-bold text-primary mb-1">{{ $totalCampaigns }}</h3>
                <p class="text-muted mb-0">Total Campaign</p>
            </div>
        </div>
    </div>

    <!-- Total User -->
    <div class="col-md-3">
        <div class="card card-custom h-100 bg-white">
            <div class="card-body text-center p-4">
                <div class="bg-warning-subtle rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                    <i class="bi bi-people-fill text-warning fs-4"></i>
                </div>
                <h3 class="fw-bold text-warning mb-1">{{ $totalUsers }}</h3>
                <p class="text-muted mb-0">Total Pengguna</p>
            </div>
        </div>
    </div>

    <!-- Pending Verifikasi -->
    <div class="col-md-3">
        <div class="card card-custom h-100 bg-white">
            <div class="card-body text-center p-4">
                <div class="bg-danger-subtle rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                    <i class="bi bi-clock-history text-danger fs-4"></i>
                </div>
                <h3 class="fw-bold text-danger mb-1">{{ $pendingVerifications }}</h3>
                <p class="text-muted mb-0">Pending Verifikasi</p>
            </div>
        </div>
    </div>
</div>

<div class="card card-custom">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Laporan Aktivitas Bulanan (6 Bulan Terakhir)</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.reports.print') }}" target="_blank" class="btn btn-outline-success rounded-pill px-3">
                    <i class="bi bi-printer me-2"></i> Cetak Laporan
                </a>
                <a href="{{ route('admin.reports.csv') }}" class="btn btn-success rounded-pill px-3">
                    <i class="bi bi-file-earmark-excel me-2"></i> Ekspor Excel (CSV)
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="py-3">Bulan</th>
                        <th class="py-3">Total Donasi Baru</th>
                        <th class="py-3">Total Campaign Baru</th>
                        <th class="py-3">Total Pendaftaran User Baru</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyReports as $report)
                    <tr>
                        <td class="fw-semibold text-dark py-3">{{ $report['month_name'] }}</td>
                        <td class="text-success fw-bold">Rp {{ number_format($report['donations_sum'], 0, ',', '.') }}</td>
                        <td class="fw-semibold text-dark">{{ $report['campaigns_count'] }} Campaign</td>
                        <td class="fw-semibold text-dark">{{ $report['users_count'] }} Pengguna Baru</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
