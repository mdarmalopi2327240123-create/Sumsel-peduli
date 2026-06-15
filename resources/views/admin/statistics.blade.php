@extends('layouts.app')

@section('header', 'Statistik Sistem')

@section('content')
<div class="row g-4 mb-4">
    <!-- Donasi Chart -->
    <div class="col-lg-6">
        <div class="card card-custom h-100 bg-white">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 text-success"><i class="bi bi-bar-chart-fill"></i> Tren Donasi Global (Rp)</h5>
                <div style="position: relative; height: 350px;">
                    <canvas id="donasiChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaign Chart -->
    <div class="col-lg-6">
        <div class="card card-custom h-100 bg-white">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-pie-chart-fill"></i> Distribusi Campaign Per Kategori</h5>
                <div style="position: relative; height: 350px; display: flex; align-items: center; justify-content: center;">
                    <canvas id="campaignChart" style="max-height: 300px; max-width: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Chart -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-custom bg-white">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 text-warning"><i class="bi bi-graph-up"></i> Pertumbuhan Pendaftaran Pengguna Baru (6 Bulan Terakhir)</h5>
                <div style="position: relative; height: 350px;">
                    <canvas id="userChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Donasi Chart (Bar)
        const donasiCtx = document.getElementById('donasiChart').getContext('2d');
        new Chart(donasiCtx, {
            type: 'bar',
            data: {
                labels: @json($monthLabels),
                datasets: [{
                    label: 'Donasi Terkumpul (Rp)',
                    data: @json($donationsByMonth),
                    backgroundColor: 'rgba(25, 135, 84, 0.75)',
                    borderColor: '#198754',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // 2. Campaign Chart (Pie)
        const campaignCtx = document.getElementById('campaignChart').getContext('2d');
        new Chart(campaignCtx, {
            type: 'pie',
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    data: @json($categoryData),
                    backgroundColor: [
                        '#198754', // Kesehatan
                        '#0d6efd', // Pendidikan
                        '#ffc107', // Sosial
                        '#dc3545', // Bencana Alam
                        '#6c757d', // Lingkungan
                        '#20c997', // others
                        '#fd7e14'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // 3. User Chart (Line)
        const userCtx = document.getElementById('userChart').getContext('2d');
        new Chart(userCtx, {
            type: 'line',
            data: {
                labels: @json($monthLabels),
                datasets: [{
                    label: 'Pendaftaran Pengguna Baru',
                    data: @json($usersByMonth),
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffc107',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
