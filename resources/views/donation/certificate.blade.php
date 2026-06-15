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
            background: #fffdf9; /* Cream paper look */
            border: 14px double #14532d; /* Double green forest border */
            padding: 50px 70px;
            max-width: 920px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
            position: relative;
            text-align: center;
            overflow: hidden;
            background-image: radial-gradient(circle, rgba(212, 175, 55, 0.03) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        
        /* Gold Corner Ornaments */
        .corner-ornament {
            position: absolute;
            width: 35px;
            height: 35px;
            border: 3px solid #d4af37;
            z-index: 10;
        }
        .top-left { top: 10px; left: 10px; border-right: none; border-bottom: none; }
        .top-right { top: 10px; right: 10px; border-left: none; border-bottom: none; }
        .bottom-left { bottom: 10px; left: 10px; border-right: none; border-top: none; }
        .bottom-right { bottom: 10px; right: 10px; border-left: none; border-top: none; }

        /* Heart Watermark Logo */
        .watermark-emblem {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            height: 300px;
            opacity: 0.03;
            pointer-events: none;
            z-index: 1;
        }

        .cert-header h1 {
            font-family: 'Cinzel', serif;
            font-weight: 800;
            color: #14532d;
            font-size: 36px;
            margin-bottom: 2px;
            letter-spacing: 3px;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.05);
        }
        .cert-header h4 {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            color: #c5a03d; /* Gold tone */
            font-weight: 700;
            font-size: 19px;
            margin-bottom: 30px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .cert-title {
            font-size: 13px;
            font-weight: 500;
            color: #555;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .cert-recipient {
            font-size: 38px;
            font-weight: 700;
            color: #111;
            margin-bottom: 25px;
            display: inline-block;
            padding: 0 40px;
            font-family: 'Playfair Display', serif;
            position: relative;
        }
        .cert-recipient::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(to right, transparent, #c5a03d, transparent);
        }
        .cert-body {
            font-size: 15px;
            color: #444;
            line-height: 1.8;
            margin-bottom: 35px;
            max-width: 680px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            z-index: 2;
        }
        .cert-amount {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            color: #14532d;
            font-size: 26px;
            margin: 12px 0;
            letter-spacing: 1px;
        }
        .cert-campaign {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-style: italic;
            color: #14532d;
            font-size: 18px;
        }
        .cert-footer {
            margin-top: 40px;
            position: relative;
            z-index: 2;
        }
        
        /* Gold Seal & Ribbon */
        .gold-seal-container {
            position: relative;
            display: inline-block;
            width: 90px;
            height: 90px;
            vertical-align: middle;
        }
        .gold-seal {
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, #f9e8a2 10%, #d4af37 60%, #aa7c11 100%);
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15), inset 0 2px 4px rgba(255,255,255,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #b8860b;
        }
        .gold-seal-inner {
            width: 74px;
            height: 74px;
            border: 1px dashed rgba(255, 255, 255, 0.45);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-family: 'Cinzel', serif;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.4);
            line-height: 1.2;
        }
        .ribbon-1, .ribbon-2 {
            position: absolute;
            width: 22px;
            height: 55px;
            background: #991b1b; /* Red Ribbon */
            bottom: -35px;
            z-index: -1;
            clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 82%, 0 100%);
        }
        .ribbon-1 { left: 18px; transform: rotate(-12deg); }
        .ribbon-2 { right: 18px; transform: rotate(12deg); }

        /* Signature Section */
        .sig-container {
            position: relative;
            display: inline-block;
            text-align: center;
            width: 180px;
        }
        .handwritten-signature {
            font-family: 'Great Vibes', cursive;
            font-size: 44px;
            color: #0b2265; /* Realistic blue ink */
            margin-bottom: -15px;
            transform: rotate(-4deg);
            user-select: none;
            line-height: 1;
        }
        .sig-line {
            border-top: 1px solid #aaa;
            padding-top: 5px;
            margin-top: 15px;
        }
        
        /* Distressed Red Seal Stamp */
        .red-stamp {
            position: absolute;
            width: 80px;
            height: 80px;
            border: 3px double rgba(185, 28, 28, 0.7);
            border-radius: 50%;
            color: rgba(185, 28, 28, 0.7);
            top: -25px;
            right: -25px;
            transform: rotate(18deg);
            z-index: 5;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cinzel', serif;
            font-size: 7px;
            font-weight: bold;
            box-shadow: inset 0 0 3px rgba(185, 28, 28, 0.1);
        }
        .red-stamp-inner {
            border: 1px solid rgba(185, 28, 28, 0.7);
            border-radius: 50%;
            width: 68px;
            height: 68px;
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
                border: 14px double #14532d !important;
                background-color: #fffdf9 !important;
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
            <!-- Decorative Corners -->
            <div class="corner-ornament top-left"></div>
            <div class="corner-ornament top-right"></div>
            <div class="corner-ornament bottom-left"></div>
            <div class="corner-ornament bottom-right"></div>
            
            <!-- Watermark Background Emblem (SVG Heart) -->
            <svg class="watermark-emblem" viewBox="0 0 24 24" fill="#14532d">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            
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
                Atas kontribusi tulus dan donasi kemanusiaan sebesar:
                <div class="cert-amount">Rp {{ number_format($donation->amount, 0, ',', '.') }}</div>
                yang disalurkan melalui kampanye penggalangan dana:<br>
                <span class="cert-campaign">"{{ $donation->campaign->judul }}"</span>
                <br><br>
                Semoga kontribusi mulia Anda membawa harapan baru, manfaat yang luas, serta berkah bagi masyarakat yang membutuhkan di wilayah Sumatera Selatan.
            </div>
            
            <div class="row align-items-center cert-footer text-start">
                <div class="col-4">
                    <small class="text-muted d-block" style="font-size: 11px;">Nomor Sertifikat:</small>
                    <code class="text-dark fw-bold" style="font-size: 13px;">{{ $certificate->nomor_sertifikat }}</code>
                    
                    <small class="text-muted d-block mt-3" style="font-size: 11px;">Tanggal Terbit:</small>
                    <span class="fw-semibold text-dark" style="font-size: 14px;">{{ date('d M Y', strtotime($certificate->tanggal_terbit)) }}</span>
                </div>
                
                <div class="col-4 text-center">
                    <div class="gold-seal-container">
                        <div class="gold-seal">
                            <div class="gold-seal-inner">
                                SUMSEL PEDULI<br>
                                OFFICIAL<br>
                                SEAL
                            </div>
                        </div>
                        <div class="ribbon-1"></div>
                        <div class="ribbon-2"></div>
                    </div>
                </div>
                
                <div class="col-4 text-end d-flex justify-content-end">
                    <div class="sig-container">
                        <div class="position-relative d-inline-block">
                            <!-- Blue ink signature representation -->
                            <div class="handwritten-signature">Admin Peduli</div>
                            
                            <!-- Red distress stamp overlay -->
                            <div class="red-stamp">
                                <div class="red-stamp-inner">
                                    <span>YAYASAN</span>
                                    <span style="font-size: 6px; margin: 2px 0;">SUMSEL</span>
                                    <span>PEDULI</span>
                                </div>
                            </div>
                        </div>
                        <div class="sig-line">
                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 14px;">Admin Peduli</h6>
                            <small class="text-muted" style="font-size: 11px;">Ketua Yayasan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
