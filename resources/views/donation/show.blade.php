@extends('layouts.app')

@section('header')
    @if(Auth::check() && Auth::user()->role === 'admin' && $donation->status === 'pending')
        Verifikasi Donasi
    @else
        Detail Donasi
    @endif
@endsection

@section('content')
@if(Auth::check() && Auth::user()->role === 'admin' && $donation->status === 'pending')
    <!-- ==================== BESPOKE ADMIN VERIFICATION LAYOUT ==================== -->
    <div class="container-fluid mt-2">
        <div class="row g-4">
            <!-- Left Column: Info & Transfer Proof -->
            <div class="col-lg-8">
                <div class="card card-custom border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <div class="card-body">
                        <h2 class="fw-bold mb-1 text-success"><i class="bi bi-wallet2"></i> Verifikasi Donasi</h2>
                        <p class="text-muted">Periksa bukti transfer dan data donasi sebelum disetujui.</p>
                        <hr class="my-4">
                        
                        <h4 class="mb-4 fw-bold text-dark">Data Donasi</h4>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <span class="text-muted d-block small">ID Transaksi / Donasi</span>
                                <span class="fw-bold text-dark">{{ $donation->transaction_id }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-muted d-block small">Tanggal Pengajuan</span>
                                <span class="fw-semibold text-dark">{{ $donation->created_at->format('d F Y H:i') }} WIB</span>
                            </div>
                            <div class="col-md-6 mt-3">
                                <span class="text-muted d-block small">Nama Donatur</span>
                                <span class="fw-bold text-dark">{{ $donation->donor_name }}</span>
                            </div>
                            <div class="col-md-6 mt-3">
                                <span class="text-muted d-block small">Email Donatur</span>
                                <span class="fw-semibold text-dark">{{ $donation->donor_email }}</span>
                            </div>
                            <div class="col-md-12 mt-3">
                                <span class="text-muted d-block small">Campaign Penerima</span>
                                <span class="fw-bold text-success">{{ $donation->campaign->judul }}</span>
                            </div>
                            <div class="col-md-6 mt-3">
                                <span class="text-muted d-block small">Nominal Donasi</span>
                                <span class="fw-bold text-success fs-5">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="col-md-6 mt-3">
                                <span class="text-muted d-block small">Metode Pembayaran</span>
                                <span class="badge bg-secondary-subtle text-secondary fs-6 rounded-pill px-3 py-2 mt-1">{{ $donation->payment_method }}</span>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <h4 class="fw-bold text-dark mb-3">Bukti Transfer</h4>
                        @if($donation->bukti_transfer)
                            <div class="text-center bg-light p-3 rounded-4 shadow-sm border mb-4">
                                <img src="{{ asset('storage/' . $donation->bukti_transfer) }}" class="img-fluid rounded-3" style="max-height: 450px; object-fit: contain;">
                            </div>
                        @else
                            <div class="alert alert-danger rounded-4 border-0 p-4 text-center mb-4">
                                <i class="bi bi-exclamation-triangle display-5 mb-2 d-block"></i>
                                <span class="fw-bold">Belum Ada Bukti Transfer</span>
                                <p class="text-muted small mb-0 mt-1">Donatur belum mengunggah bukti pembayaran untuk donasi ini.</p>
                            </div>
                        @endif
                        
                        <hr class="my-4">
                        
                        <!-- ACTION FORM -->
                        <form action="{{ route('donation.verify', $donation) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark"><i class="bi bi-chat-right-text text-success"></i> Catatan Admin</label>
                                <textarea class="form-control rounded-4 p-3 border-0 bg-light" name="catatan" rows="4" placeholder="Masukkan catatan atau memo verifikasi donasi..."></textarea>
                            </div>
                            
                            <div class="d-flex gap-3">
                                <button type="submit" name="status" value="completed" class="btn btn-success btn-lg px-4 py-3 rounded-4 fw-bold flex-grow-1 shadow-sm text-white" {{ !$donation->bukti_transfer ? 'disabled' : '' }}>
                                    <i class="bi bi-check-circle"></i> Verifikasi Donasi
                                </button>
                                <button type="submit" name="status" value="failed" class="btn btn-danger btn-lg px-4 py-3 rounded-4 fw-bold flex-grow-1 shadow-sm text-white">
                                    <i class="bi bi-x-circle"></i> Tolak Donasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Status, Checklist, Bank Info -->
            <div class="col-lg-4">
                <!-- Status Box -->
                <div class="card card-custom border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3 text-dark">Status</h4>
                        <hr class="mb-4">
                        <div class="bg-warning text-dark text-center p-3 rounded-4 fw-bold fs-5 shadow-sm">
                            <i class="bi bi-hourglass-split"></i> Menunggu Verifikasi
                        </div>
                    </div>
                </div>
                
                <!-- Checklist Box -->
                <div class="card card-custom border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3 text-dark">Checklist Verifikasi</h4>
                        <hr class="mb-3">
                        <ul class="list-unstyled d-flex flex-column gap-3 fs-6 mb-0">
                            <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success fs-5"></i> <span>Nama Donatur Sesuai</span></li>
                            <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success fs-5"></i> <span>Nominal Sesuai</span></li>
                            <li class="d-flex align-items-center gap-2">
                                @if($donation->bukti_transfer)
                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                @else
                                    <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                @endif
                                <span>Bukti Transfer Ada</span>
                            </li>
                            <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success fs-5"></i> <span>Tanggal Transfer Sesuai</span></li>
                            <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success fs-5"></i> <span>Campaign Valid</span></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Bank Info Box -->
                <div class="card card-custom border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3 text-dark">Informasi Rekening Tujuan</h4>
                        <hr class="mb-3">
                        <div class="bg-light p-3 rounded-4">
                            <p class="mb-1 text-muted small">Nama Bank</p>
                            <p class="fw-bold text-dark mb-3">Bank BCA</p>
                            
                            <p class="mb-1 text-muted small">Nomor Rekening</p>
                            <p class="fw-bold text-success fs-5 mb-3">1234567890</p>
                            
                            <p class="mb-1 text-muted small">Atas Nama</p>
                            <p class="fw-bold text-dark mb-0">a.n Sumsel Peduli</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.verifikasi.donations') }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold shadow-sm"><i class="bi bi-arrow-left"></i> Kembali ke Antrean</a>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- ==================== STANDARD USER DISPLAY LAYOUT ==================== -->
    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card card-custom p-4 mb-4 bg-white border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <div>
                            <span class="badge bg-{{ $donation->status === 'completed' ? 'success' : ($donation->status === 'pending' ? 'warning' : 'danger') }} rounded-pill px-3 py-2 text-white">
                                Status: {{ $donation->status === 'completed' ? 'Telah Diverifikasi' : ($donation->status === 'pending' ? 'Menunggu Verifikasi' : 'Gagal') }}
                            </span>
                        </div>
                        <h5 class="text-muted mb-0">ID: {{ $donation->transaction_id }}</h5>
                    </div>

                    <div class="mb-5 text-center bg-light p-4 rounded-4">
                        <span class="text-muted d-block small mb-1">Jumlah Donasi</span>
                        <h1 class="text-success fw-bold display-5 mb-0">Rp {{ number_format($donation->amount, 0, ',', '.') }}</h1>
                    </div>

                    <h5 class="fw-bold mb-3"><i class="bi bi-person text-success"></i> Informasi Donatur</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Nama Lengkap</small>
                            <span class="fw-bold">{{ $donation->donor_name }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Alamat Email</small>
                            <span class="fw-bold">{{ $donation->donor_email }}</span>
                        </div>
                        @if($donation->donor_phone)
                        <div class="col-md-6">
                            <small class="text-muted d-block">Nomor Telepon</small>
                            <span class="fw-bold">{{ $donation->donor_phone }}</span>
                        </div>
                        @endif
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold mb-3"><i class="bi bi-wallet2 text-success"></i> Informasi Pembayaran</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Metode Pembayaran</small>
                            <span class="fw-bold">{{ $donation->payment_method }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Waktu Transaksi</small>
                            <span class="fw-bold">{{ $donation->created_at->format('d M Y H:i') }} WIB</span>
                        </div>
                    </div>

                    @if($donation->notes)
                    <hr class="my-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-chat-left-text text-success"></i> Pesan Donatur</h5>
                    <div class="bg-light p-3 rounded-4 italic text-muted">
                        "{{ $donation->notes }}"
                    </div>
                    @endif

                    @if($donation->bukti_transfer)
                    <hr class="my-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-image text-success"></i> Bukti Transfer Pembayaran</h5>
                    <div class="text-center bg-light p-3 rounded-4">
                        <img src="{{ asset('storage/' . $donation->bukti_transfer) }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 400px; object-fit: contain;">
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Right -->
        <div class="col-lg-4">
            <!-- Campaign Card -->
            <div class="card card-custom p-4 mb-4 bg-white border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-muted">Kampanye Tujuan</h5>
                    <a href="{{ route('campaign.show', $donation->campaign) }}" class="text-decoration-none text-dark">
                        @if($donation->campaign->gambar)
                            <img src="{{ asset('storage/' . $donation->campaign->gambar) }}" class="img-fluid rounded-3 mb-3 w-100 shadow-sm" style="height: 150px; object-fit: cover;">
                        @else
                            <svg class="img-fluid rounded-3 mb-3 w-100 shadow-sm" viewBox="0 0 400 200" width="100%" style="height: 150px; background: linear-gradient(135deg, #198754 0%, #115e3b 100%);">
                                <defs>
                                    <linearGradient id="cardGrad{{ $donation->campaign->id }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:#198754;stop-opacity:0.8" />
                                        <stop offset="100%" style="stop-color:#0f5132;stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                                <rect width="400" height="200" fill="url(#cardGrad{{ $donation->campaign->id }})" />
                                <path d="M 0,100 Q 100,33 200,100 T 400,100 L 400,200 L 0,200 Z" fill="#ffffff" opacity="0.08" />
                                <path d="M 0,133 Q 120,80 240,146 T 400,133 L 400,200 L 0,200 Z" fill="#ffffff" opacity="0.04" />
                                <g transform="translate(188, 60) scale(1.5)" fill="#ffffff" opacity="0.25">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </g>
                                <text x="200" y="160" fill="#ffffff" opacity="0.6" font-family="'Poppins', sans-serif" font-size="14" font-weight="700" text-anchor="middle" letter-spacing="1">{{ strtoupper($donation->campaign->kategori ?? 'Kebaikan') }}</text>
                            </svg>
                        @endif
                        <h6 class="fw-bold hover:text-success mb-1">{{ Str::limit($donation->campaign->judul, 40) }}</h6>
                    </a>
                    <small class="text-muted d-block mb-3">{{ $donation->campaign->kategori }}</small>
                    <a href="{{ route('campaign.show', $donation->campaign) }}" class="btn btn-outline-success btn-sm w-100 rounded-pill">Lihat Kampanye</a>
                </div>
            </div>

            <!-- Action Panel -->
            <div class="card card-custom p-4 mb-4 bg-white border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-muted">Tindakan</h5>

                    @if (Auth::user()->role === 'admin' && $donation->status === 'pending')
                        @if ($donation->bukti_transfer)
                            <div class="alert alert-info small rounded-4 mb-3 border-0">
                                <i class="bi bi-info-circle"></i> Donatur sudah mengunggah bukti transfer. Silakan tinjau dan lakukan verifikasi.
                            </div>
                            <form action="{{ route('donation.verify', $donation) }}" method="POST" class="d-grid gap-2">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="status" value="completed" class="btn btn-success py-2 rounded-pill fw-bold text-white">
                                    <i class="bi bi-patch-check"></i> Setujui Pembayaran
                                </button>
                                <button type="submit" name="status" value="failed" class="btn btn-danger py-2 rounded-pill fw-bold text-white">
                                    <i class="bi bi-x-circle"></i> Tolak Pembayaran
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning small rounded-4 mb-0 border-0">
                                <i class="bi bi-exclamation-triangle"></i> Menunggu donatur mengunggah bukti transfer pembayaran.
                            </div>
                        @endif
                    @elseif (Auth::user()->role === 'donatur' && $donation->status === 'pending')
                        @if ($donation->bukti_transfer)
                            <div class="alert alert-info small rounded-4 mb-3 border-0">
                                <i class="bi bi-clock-history"></i> Bukti transfer sudah diunggah. Menunggu Admin memverifikasi transaksi Anda.
                            </div>
                            <a href="{{ route('donation.upload-proof', $donation) }}" class="btn btn-outline-warning w-100 rounded-pill btn-sm">Unggah Ulang Bukti</a>
                        @else
                            <div class="alert alert-danger small rounded-4 mb-3 border-0">
                                <i class="bi bi-exclamation-circle"></i> Anda belum mengunggah bukti transfer pembayaran.
                            </div>
                            <a href="{{ route('donation.upload-proof', $donation) }}" class="btn btn-warning text-white w-100 rounded-pill py-2 fw-bold">
                                <i class="bi bi-upload"></i> Unggah Bukti Sekarang
                            </a>
                        @endif
                    @elseif ($donation->status === 'completed')
                        <div class="alert alert-success small rounded-4 mb-3 border-0">
                            <i class="bi bi-check-circle"></i> Pembayaran donasi ini telah sah dan diverifikasi oleh Admin.
                        </div>
                        @if (Auth::user()->role === 'donatur' || Auth::user()->role === 'admin')
                            <a href="{{ route('donation.certificate', $donation) }}" class="btn btn-success w-100 rounded-pill py-2 fw-bold text-white">
                                <i class="bi bi-award"></i> Lihat Sertifikat Donasi
                            </a>
                        @endif
                    @elseif ($donation->status === 'failed')
                        <div class="alert alert-danger small rounded-4 mb-0 border-0">
                            <i class="bi bi-x-circle"></i> Donasi ini ditolak/gagal dalam verifikasi transfer admin.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4 shadow-sm"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
    </div>
@endif
@endsection

