<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Donasi - {{ $donation->transaction_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #e9ecef;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .cert-container {
            background: #fff;
            border: 20px solid #198754;
            outline: 5px solid #ffc107;
            outline-offset: -15px;
            padding: 60px;
            max-width: 900px;
            width: 100%;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            position: relative;
            text-align: center;
            background-image: radial-gradient(circle, rgba(25, 135, 84, 0.02) 20%, transparent 20%),
                              radial-gradient(circle, rgba(25, 135, 84, 0.02) 20%, transparent 20%);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }
        .cert-header h1 {
            font-family: 'Cinzel', serif;
            font-weight: 800;
            color: #198754;
            letter-spacing: 2px;
            font-size: 40px;
            margin-bottom: 5px;
        }
        .cert-header h4 {
            font-family: 'Cinzel', serif;
            color: #ffc107;
            letter-spacing: 4px;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 40px;
        }
        .cert-title {
            font-size: 18px;
            color: #555;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .cert-recipient {
            font-size: 32px;
            font-weight: 700;
            color: #212529;
            border-bottom: 2px solid #ffc107;
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 30px;
            font-family: 'Cinzel', serif;
        }
        .cert-body {
            font-size: 16px;
            color: #555;
            line-height: 1.8;
            margin-bottom: 40px;
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
        }
        .cert-campaign {
            font-weight: 600;
            color: #198754;
        }
        .cert-footer {
            margin-top: 50px;
        }
        .cert-signature {
            border-top: 1px solid #ccc;
            display: inline-block;
            padding-top: 10px;
            width: 200px;
            margin-top: 40px;
        }
        .btn-print-container {
            position: absolute;
            top: -60px;
            right: 0;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .cert-container {
                box-shadow: none;
                border: 20px solid #198754 !important;
                outline: 5px solid #ffc107 !important;
                position: static;
            }
            .btn-print-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="position-relative" style="max-width: 900px; width: 100%;">
        <div class="btn-print-container d-flex gap-2">
            <button onclick="window.print()" class="btn btn-success rounded-pill px-4"><i class="bi bi-printer"></i> Cetak Sertifikat</button>
            <a href="{{ route('donation.show', $donation) }}" class="btn btn-light rounded-pill px-4">Kembali</a>
        </div>
        
        <div class="cert-container">
            <div class="cert-header">
                <h1>💚 SUMSEL PEDULI</h1>
                <h4>Piagam Penghargaan</h4>
            </div>
            
            <div class="cert-title">
                Diberikan Penghargaan Setinggi-tingginya Kepada:
            </div>
            
            <div class="cert-recipient">
                {{ $donation->donor_name }}
            </div>
            
            <div class="cert-body">
                Atas kontribusi tulus dan donasi kemanusiaan sebesar 
                <span class="fw-bold text-dark fs-5 d-block my-2">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                yang disalurkan melalui kampanye penggalangan dana:<br>
                <span class="cert-campaign">"{{ $donation->campaign->judul }}"</span>
                <br><br>
                Semoga kontribusi Anda membawa keberkahan dan kebahagiaan bagi mereka yang membutuhkan di wilayah Sumatera Selatan.
            </div>
            
            <div class="row cert-footer">
                <div class="col-6 text-start">
                    <small class="text-muted d-block">Nomor Sertifikat:</small>
                    <code class="text-dark">{{ $certificate->nomor_sertifikat }}</code>
                    
                    <small class="text-muted d-block mt-3">Tanggal Terbit:</small>
                    <span class="fw-semibold">{{ date('d M Y', strtotime($certificate->tanggal_terbit)) }}</span>
                </div>
                <div class="col-6 text-end">
                    <div class="cert-signature">
                        <h6 class="mb-0 fw-bold">Admin Peduli</h6>
                        <small class="text-muted">Yayasan Sumsel Peduli</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
