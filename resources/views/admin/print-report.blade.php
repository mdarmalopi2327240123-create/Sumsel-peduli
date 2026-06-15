<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Crowdfunding - Sumsel Peduli</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: white;
            color: #333;
            padding: 40px;
        }
        .report-header {
            border-bottom: 3px double #198754;
            padding-bottom: 20px;
            margin-bottom: 40px;
        }
        .logo {
            font-size: 28px;
            font-weight: 700;
            color: #198754;
        }
        .summary-box {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }
        .summary-val {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Action Buttons for Manual Printing if needed -->
        <div class="d-flex justify-content-end mb-4 no-print">
            <button onclick="window.print();" class="btn btn-success rounded-pill px-4 me-2">
                Cetak Halaman Ini
            </button>
            <button onclick="window.close();" class="btn btn-secondary rounded-pill px-4">
                Tutup Halaman
            </button>
        </div>

        <!-- Header Laporan -->
        <div class="report-header d-flex justify-content-between align-items-center">
            <div>
                <div class="logo">💚 Sumsel Peduli</div>
                <div class="text-muted small">Platform Crowdfunding & Donasi Sumatera Selatan</div>
            </div>
            <div class="text-end">
                <h4 class="fw-bold mb-1">LAPORAN SISTEM</h4>
                <div class="text-muted">Tanggal Cetak: {{ date('d F Y') }}</div>
            </div>
        </div>

        <!-- Summary -->
        <h5 class="fw-bold mb-3">Ringkasan Aktivitas Sistem</h5>
        <div class="row g-4 mb-5">
            <div class="col-3">
                <div class="summary-box">
                    <div class="summary-val text-success">Rp {{ number_format($totalDonationAmount, 0, ',', '.') }}</div>
                    <small class="text-muted">Total Donasi</small>
                </div>
            </div>
            <div class="col-3">
                <div class="summary-box">
                    <div class="summary-val text-primary">{{ $totalCampaigns }}</div>
                    <small class="text-muted">Total Campaign</small>
                </div>
            </div>
            <div class="col-3">
                <div class="summary-box">
                    <div class="summary-val text-warning">{{ $totalUsers }}</div>
                    <small class="text-muted">Total Pengguna</small>
                </div>
            </div>
            <div class="col-3">
                <div class="summary-box">
                    <div class="summary-val text-danger">{{ $pendingVerifications }}</div>
                    <small class="text-muted">Pending Verifikasi</small>
                </div>
            </div>
        </div>

        <!-- Monthly Table -->
        <h5 class="fw-bold mb-3">Aktivitas Laporan Bulanan (6 Bulan Terakhir)</h5>
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Bulan</th>
                    <th>Total Donasi</th>
                    <th>Total Campaign Baru</th>
                    <th>Total User Baru</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyReports as $report)
                <tr>
                    <td class="fw-semibold">{{ $report['month_name'] }}</td>
                    <td class="text-success fw-bold">Rp {{ number_format($report['donations_sum'], 0, ',', '.') }}</td>
                    <td>{{ $report['campaigns_count'] }} Campaign</td>
                    <td>{{ $report['users_count'] }} Pengguna Baru</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Sign Area -->
        <div class="row mt-5 pt-4">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p class="mb-5">Menyetujui,<br><strong>Super Admin Sumsel Peduli</strong></p>
                <div style="border-bottom: 1px solid #333; width: 180px; margin: 0 auto;"></div>
                <small class="text-muted mt-2 d-block">Administrator Sistem</small>
            </div>
        </div>
    </div>

    <!-- Trigger Print Dialog Automatically -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
