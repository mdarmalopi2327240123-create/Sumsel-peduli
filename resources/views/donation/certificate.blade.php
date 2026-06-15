@php
function terbilang($angka) {
    $angka = abs((float)$angka);
    $baca = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($angka < 12) {
        $temp = " " . $baca[$angka];
    } else if ($angka < 20) {
        $temp = terbilang($angka - 10) . " belas";
    } else if ($angka < 100) {
        $temp = terbilang($angka / 10) . " puluh" . terbilang($angka % 10);
    } else if ($angka < 200) {
        $temp = " seratus" . terbilang($angka - 100);
    } else if ($angka < 1000) {
        $temp = terbilang($angka / 100) . " ratus" . terbilang($angka % 100);
    } else if ($angka < 2000) {
        $temp = " seribu" . terbilang($angka - 1000);
    } else if ($angka < 1000000) {
        $temp = terbilang($angka / 1000) . " ribu" . terbilang($angka % 1000);
    } else if ($angka < 1000000000) {
        $temp = terbilang($angka / 1000000) . " juta" . terbilang($angka % 1000000);
    } else if ($angka < 1000000000000) {
        $temp = terbilang($angka / 1000000000) . " milyar" . terbilang(fmod($angka, 1000000000));
    } else if ($angka < 1000000000000000) {
        $temp = terbilang($angka / 1000000000000) . " trilyun" . terbilang(fmod($angka, 1000000000000));
    }
    return $temp;
}

function formatTerbilang($angka) {
    if($angka == 0) return "nol rupiah";
    $hasil = trim(terbilang($angka)) . " rupiah";
    return ucwords($hasil);
}
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Donasi - {{ $donation->transaction_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;800&family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #e2e8f0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
        }
        .cert-container {
            background: #ffffff; /* Clean white canvas */
            padding: 60px 80px;
            max-width: 920px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            position: relative;
            text-align: center;
            overflow: hidden;
        }
        
        /* Wavy corner shapes */
        .wave-top-left {
            position: absolute;
            top: 0;
            left: 0;
            width: 260px;
            height: 190px;
            z-index: 1;
            pointer-events: none;
        }
        .wave-bottom-right {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 260px;
            height: 190px;
            z-index: 1;
            pointer-events: none;
        }

        /* Top-Right Logo Section */
        .cert-logo-section {
            position: absolute;
            top: 40px;
            right: 60px;
            text-align: right;
            z-index: 2;
        }
        .cert-logo-section .logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            color: #14532d;
            font-size: 19px;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }
        .cert-logo-section .logo-text span {
            color: #c5a03d;
        }
        .cert-logo-section .logo-subtext {
            font-size: 7.5px;
            font-weight: 700;
            color: #666;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        /* Title Area */
        .cert-title-section {
            margin-top: 70px;
            margin-bottom: 35px;
            z-index: 2;
            position: relative;
        }
        .title-main {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #14532d;
            font-size: 36px;
            letter-spacing: 4px;
            margin-bottom: 2px;
        }
        .title-number {
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
            color: #666;
            letter-spacing: 1.5px;
        }

        /* Recipient info */
        .recipient-section {
            margin-bottom: 30px;
            position: relative;
            z-index: 2;
        }
        .recipient-label {
            font-size: 11px;
            font-weight: 600;
            color: #666;
            letter-spacing: 2.5px;
            margin-bottom: 12px;
        }
        .recipient-name {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            font-weight: 700;
            color: #111;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }
        .recipient-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        .divider-line {
            width: 90px;
            height: 1px;
            background: linear-gradient(to right, transparent, #c5a03d 50%, transparent);
        }
        .divider-diamond {
            width: 6px;
            height: 6px;
            background: #c5a03d;
            transform: rotate(45deg);
        }

        /* Core Body */
        .cert-body-text {
            font-size: 13.5px;
            color: #444;
            line-height: 1.8;
            max-width: 720px;
            margin: 0 auto 20px auto;
            position: relative;
            z-index: 2;
        }
        .cert-amount-display {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #14532d;
            font-size: 36px;
            margin-bottom: 3px;
            letter-spacing: 1.5px;
            z-index: 2;
            position: relative;
        }
        .cert-amount-words {
            font-size: 12.5px;
            font-style: italic;
            color: #555;
            margin-bottom: 25px;
            z-index: 2;
            position: relative;
            text-transform: capitalize;
        }
        .cert-destination-text {
            font-size: 13px;
            color: #555;
            line-height: 1.8;
            max-width: 720px;
            margin: 0 auto 30px auto;
            z-index: 2;
            position: relative;
        }

        /* Footer / Signatures */
        .cert-signature-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 55px;
            padding: 0 30px;
            z-index: 2;
            position: relative;
        }
        .signature-block {
            position: relative;
            text-align: left;
            width: 250px;
        }
        .handwritten-sig {
            font-family: 'Great Vibes', cursive;
            font-size: 46px;
            color: #0b2265; /* Blue ink */
            margin-bottom: -15px;
            transform: rotate(-3deg);
            user-select: none;
            line-height: 1;
        }
        .signature-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #111;
            font-size: 13px;
            border-top: 1.5px solid #14532d;
            display: inline-block;
            padding-top: 5px;
            margin-top: 15px;
            letter-spacing: 1px;
        }
        .signature-title {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }
        .issue-date-block {
            font-size: 13px;
            font-weight: 500;
            color: #333;
            text-align: right;
            padding-bottom: 5px;
        }

        /* Red Distressed Seal Stamp */
        .red-stamp-seal {
            position: absolute;
            width: 76px;
            height: 76px;
            border: 3px double rgba(185, 28, 28, 0.65);
            border-radius: 50%;
            color: rgba(185, 28, 28, 0.65);
            top: -22px;
            left: 75px;
            transform: rotate(15deg);
            z-index: 5;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cinzel', serif;
            font-size: 6.5px;
            font-weight: bold;
        }
        .stamp-text-inner {
            border: 1px solid rgba(185, 28, 28, 0.65);
            border-radius: 50%;
            width: 64px;
            height: 64px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            line-height: 1.1;
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
                background-color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .btn-print-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="position-relative" style="max-width: 920px; width: 100%;">
        <div class="btn-print-container d-flex gap-2">
            <button onclick="window.print()" class="btn btn-success rounded-pill px-4"><i class="bi bi-printer"></i> Cetak Sertifikat</button>
            <a href="{{ route('donation.show', $donation) }}" class="btn btn-light rounded-pill px-4">Kembali</a>
        </div>
        
        <div class="cert-container">
            <!-- Top-Left Wave Design -->
            <div class="wave-top-left">
                <svg viewBox="0 0 250 180" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%;">
                    <path d="M0 0 H220 C180 60, 110 110, 0 150 Z" fill="#14532d" />
                    <path d="M0 0 H195 C160 50, 100 90, 0 125 Z" fill="#c5a03d" />
                    <path d="M0 0 H180 C145 42, 90 78, 0 110 Z" fill="#1b733e" />
                </svg>
            </div>
            
            <!-- Bottom-Right Wave Design -->
            <div class="wave-bottom-right">
                <svg viewBox="0 0 250 180" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%;">
                    <path d="M250 180 H30 C70 120, 140 70, 250 30 Z" fill="#14532d" />
                    <path d="M250 180 H55 C90 130, 150 90, 250 55 Z" fill="#c5a03d" />
                    <path d="M250 180 H70 C105 138, 160 102, 250 70 Z" fill="#1b733e" />
                </svg>
            </div>

            <!-- Logo Section (Top Right) -->
            <div class="cert-logo-section">
                <div class="logo-text">SUMSEL <span>PEDULI</span></div>
                <div class="logo-subtext">AGEN GERAKAN KEBAIKAN</div>
            </div>
            
            <!-- Certificate Title -->
            <div class="cert-title-section">
                <h2 class="title-main">SERTIFIKAT DONASI</h2>
                <div class="title-number">Nomor: {{ $certificate->nomor_sertifikat }}</div>
            </div>
            
            <!-- Recipient Name -->
            <div class="recipient-section">
                <div class="recipient-label">DIBERIKAN KEPADA :</div>
                <h3 class="recipient-name">{{ $donation->donor_name }}</h3>
                <div class="recipient-divider">
                    <div class="divider-line"></div>
                    <div class="divider-diamond"></div>
                    <div class="divider-line"></div>
                </div>
            </div>
            
            <!-- Donation Body Description -->
            <div class="cert-body-text">
                Sumsel Peduli dengan penuh rasa syukur dan apresiasi menyampaikan terima kasih atas kepercayaan serta kepedulian yang telah diberikan melalui penyaluran donasi sebesar:
            </div>
            
            <!-- Donation Amount Display -->
            <div class="cert-amount-display">
                Rp. {{ number_format($donation->amount, 0, ',', '.') }}
            </div>
            
            <!-- Indonesian Terbilang Word Conversion -->
            <div class="cert-amount-words">
                ({{ formatTerbilang($donation->amount) }})
            </div>
            
            <!-- Donation Campaign Destination Details -->
            <div class="cert-destination-text">
                Donasi ini diperuntukkan bagi program kemanusiaan: <strong class="text-success">"{{ $donation->campaign->judul }}"</strong> sebagai bentuk kepedulian sosial dan solidaritas terhadap sesama yang membutuhkan di wilayah Sumatera Selatan.
            </div>
            
            <!-- Footer with Signature & Date -->
            <div class="cert-signature-area">
                <!-- Signature Block (Bottom Left) -->
                <div class="signature-block">
                    <div class="position-relative d-inline-block">
                        <div class="handwritten-sig">Admin Peduli</div>
                        
                        <!-- Red distressed stamp overlay -->
                        <div class="red-stamp-seal">
                            <div class="stamp-text-inner">
                                <span>YAYASAN</span>
                                <span style="font-size: 5px; margin: 2.5px 0;">SUMSEL</span>
                                <span>PEDULI</span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="signature-name">ADMIN PEDULI</div>
                    <div class="signature-title">Ketua Yayasan Sumsel Peduli</div>
                </div>
                
                <!-- Date of Issue (Bottom Right) -->
                <div class="issue-date-block">
                    Palembang, {{ date('d F Y', strtotime($certificate->tanggal_terbit)) }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
