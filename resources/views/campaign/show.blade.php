@extends('layouts.app')

@section('header')
    @if(Auth::check() && Auth::user()->role === 'admin' && $campaign->status === 'pending')
        Verifikasi Campaign
    @else
        Detail Campaign
    @endif
@endsection

@section('content')
@if(Auth::check() && Auth::user()->role === 'admin' && $campaign->status === 'pending')
    <!-- ==================== BESPOKE ADMIN VERIFICATION LAYOUT ==================== -->
    <div class="container-fluid mt-2">
        <div class="row g-4">
            <!-- Left Column: Info & Form -->
            <div class="col-lg-8">
                <div class="card card-custom border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h2 class="fw-bold mb-0 text-success"><i class="bi bi-patch-check-fill"></i> Verifikasi Campaign</h2>
                            @can('delete', $campaign)
                                <form action="{{ route('campaign.destroy', $campaign) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus campaign ini? Semua data terkait termasuk donasi dan update akan dihapus secara permanen.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-2 fw-semibold">
                                        <i class="bi bi-trash3-fill me-1"></i> Hapus Campaign
                                    </button>
                                </form>
                            @endcan
                        </div>
                        <p class="text-muted">Periksa kelengkapan campaign sebelum dipublikasikan ke platform.</p>
                        <hr class="my-4">
                        
                        <h4 class="mb-4 fw-bold text-dark">Informasi Campaign</h4>
                        <img src="{{ $campaign->image_url }}" class="img-fluid rounded-4 mb-4 w-100 shadow-sm" style="max-height: 400px; object-fit: cover;">
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <span class="text-muted d-block small">Judul Campaign</span>
                                <span class="fw-bold fs-5 text-dark">{{ $campaign->judul }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-muted d-block small">Kategori</span>
                                <span class="badge bg-success-subtle text-success fs-6 rounded-pill px-3 py-2 mt-1">{{ $campaign->kategori }}</span>
                            </div>
                            <div class="col-md-6 mt-3">
                                <span class="text-muted d-block small">Fundraiser</span>
                                <span class="fw-bold text-dark"><i class="bi bi-person-circle text-success"></i> {{ $campaign->user->name }}</span>
                            </div>
                            <div class="col-md-6 mt-3">
                                <span class="text-muted d-block small">Target Dana</span>
                                <span class="fw-bold text-success fs-5">Rp {{ number_format($campaign->target, 0, ',', '.') }}</span>
                            </div>
                            <div class="col-md-6 mt-3">
                                <span class="text-muted d-block small">Tanggal Mulai</span>
                                <span class="fw-semibold text-dark">{{ $campaign->tanggal_mulai ? $campaign->tanggal_mulai->format('d F Y') : '-' }}</span>
                            </div>
                            <div class="col-md-6 mt-3">
                                <span class="text-muted d-block small">Batas Campaign (Selesai)</span>
                                <span class="fw-semibold text-dark">{{ $campaign->tanggal_selesai ? $campaign->tanggal_selesai->format('d F Y') : '-' }}</span>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <h4 class="fw-bold text-dark mb-3">Deskripsi Campaign</h4>
                        <div class="text-muted bg-light p-3 rounded-4" style="white-space: pre-line;">
                            {{ $campaign->deskripsi }}
                        </div>
                        
                        <hr class="my-4">
                        <h4 class="fw-bold text-dark mb-3">Dokumen Pendukung</h4>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <tbody>
                                    <tr>
                                        <td><i class="bi bi-card-image text-success fs-4 me-2"></i> KTP Fundraiser</td>
                                        <td class="text-end">
                                            <button class="btn btn-outline-success btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#ktpModal">Lihat</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="bi bi-file-earmark-pdf text-success fs-4 me-2"></i> Proposal Kegiatan</td>
                                        <td class="text-end">
                                            <button class="btn btn-outline-success btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#proposalModal">Lihat</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="bi bi-file-earmark-check text-success fs-4 me-2"></i> Surat Keterangan / Legalitas</td>
                                        <td class="text-end">
                                            <button class="btn btn-outline-success btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#suratModal">Lihat</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Modals for Documents -->
                        <div class="modal fade" id="ktpModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="fw-bold">Dokumen KTP Fundraiser</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center p-4">
                                        <img src="https://dummyimage.com/600x400/cccccc/000000.png&text=MOCK+KTP+FUNDRAISER" class="img-fluid rounded-3" alt="KTP Mock">
                                        <p class="mt-3 text-muted small">Verifikasi kecocokan nama fundraiser ({{ $campaign->user->name }}) dengan data KTP.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="proposalModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="fw-bold">Proposal Kegiatan Crowdfunding</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4 bg-light rounded-4 m-3 mt-1">
                                        <h6 class="fw-bold text-success">PROPOSAL PENGGALANGAN DANA</h6>
                                        <p><strong>Judul:</strong> {{ $campaign->judul }}</p>
                                        <p><strong>Deskripsi Singkat:</strong> {{ Str::limit($campaign->deskripsi, 100) }}</p>
                                        <p><strong>Target Penggunaan Dana:</strong> Rp {{ number_format($campaign->target, 0, ',', '.') }}</p>
                                        <hr>
                                        <p class="text-muted small">Proposal ini telah diajukan secara elektronik oleh fundraiser. Verifikasi keabsahan program dan kelengkapan estimasi anggaran biaya dalam dokumen.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="suratModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="fw-bold">Surat Keterangan Pendukung</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center p-4">
                                        <img src="https://dummyimage.com/600x800/e9ecef/000000.png&text=SURAT+KETERANGAN+MEDIS+/+DOKUMEN+LEGALITAS" class="img-fluid rounded-3" style="max-height: 400px;" alt="Surat Keterangan Mock">
                                        <p class="mt-3 text-muted small">Surat Keterangan Resmi dari instansi medis atau lembaga pemerintah terkait keaslian kasus/kegiatan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <!-- ACTION FORM -->
                        <form action="{{ route('campaign.verify', $campaign) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark"><i class="bi bi-chat-right-text text-success"></i> Catatan Verifikasi Admin</label>
                                <textarea class="form-control rounded-4 p-3 border-0 bg-light" name="catatan" rows="4" placeholder="Masukkan catatan persetujuan atau alasan penolakan..."></textarea>
                            </div>
                            
                            <div class="d-flex gap-3">
                                <button type="submit" name="status" value="aktif" class="btn btn-success btn-lg px-4 py-3 rounded-4 fw-bold flex-grow-1 shadow-sm text-white">
                                    <i class="bi bi-check-circle"></i> Setujui Campaign
                                </button>
                                <button type="submit" name="status" value="ditolak" class="btn btn-danger btn-lg px-4 py-3 rounded-4 fw-bold flex-grow-1 shadow-sm text-white">
                                    <i class="bi bi-x-circle"></i> Tolak Campaign
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Status & Checklist -->
            <div class="col-lg-4">
                <!-- Status Box -->
                <div class="card card-custom border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3 text-dark">Status</h4>
                        <hr class="mb-4">
                        <div class="bg-warning text-dark text-center p-3 rounded-4 fw-bold fs-5 shadow-sm">
                            <i class="bi bi-hourglass-split"></i> Pending Review
                        </div>
                    </div>
                </div>
                
                <!-- Checklist Box -->
                <div class="card card-custom border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <div class="card-body">
                        <h4 class="fw-bold mb-3 text-dark">Checklist Peninjauan</h4>
                        <hr class="mb-3">
                        <ul class="list-unstyled d-flex flex-column gap-3 fs-6 mb-0">
                            <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success fs-5"></i> <span>Judul Lengkap & Jelas</span></li>
                            <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success fs-5"></i> <span>Thumbnail Ada & Relevan</span></li>
                            <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success fs-5"></i> <span>Target Dana Logis</span></li>
                            <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success fs-5"></i> <span>Dokumen Upload Lengkap</span></li>
                            <li class="d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill text-success fs-5"></i> <span>Deskripsi Kasus Detil</span></li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.verifikasi.campaigns') }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold shadow-sm"><i class="bi bi-arrow-left"></i> Kembali ke Antrean</a>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- ==================== STANDARD USER DISPLAY LAYOUT ==================== -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-custom overflow-hidden bg-white">
                <img src="{{ $campaign->image_url }}" class="img-fluid w-100" style="height: 450px; object-fit: cover;">
                <div class="card-body p-4">
                    <div class="d-flex gap-2 mb-3">
                        <span class="badge bg-success-subtle text-success rounded-pill px-3">{{ $campaign->kategori }}</span>
                        <span class="badge bg-{{ $campaign->status === 'aktif' ? 'success' : ($campaign->status === 'pending' ? 'warning' : 'danger') }}-subtle text-{{ $campaign->status === 'aktif' ? 'success' : ($campaign->status === 'pending' ? 'warning' : 'danger') }} rounded-pill px-3">
                            {{ ucfirst($campaign->status) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                        <h1 class="fw-bold mb-0">{{ $campaign->judul }}</h1>
                        @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::id() === $campaign->user_id))
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-pill px-3 py-2 border shadow-sm" type="button" id="campaignActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i> Aksi
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4" aria-labelledby="campaignActionsDropdown">
                                    @can('update', $campaign)
                                        <li>
                                            <a class="dropdown-item py-2 px-3 fw-medium" href="{{ route('campaign.edit', $campaign) }}">
                                                <i class="bi bi-pencil-square text-success me-2"></i> Edit Campaign
                                            </a>
                                        </li>
                                    @endcan
                                    @can('delete', $campaign)
                                        <li>
                                            <form action="{{ route('campaign.destroy', $campaign) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus campaign ini? Semua data terkait termasuk donasi dan update akan dihapus permanen.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger py-2 px-3 fw-medium">
                                                    <i class="bi bi-trash3-fill text-danger me-2"></i> Hapus Campaign
                                                </button>
                                            </form>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($campaign->user->name) }}&background=198754&color=fff" class="rounded-circle me-3" width="40">
                        <div>
                            <div class="fw-bold">{{ $campaign->user->name }}</div>
                            <small class="text-muted">Penggalang Dana</small>
                        </div>
                    </div>
                    
                    <h5 class="fw-bold mb-3">Deskripsi Campaign</h5>
                    <div class="text-muted" style="white-space: pre-line;">
                        {{ $campaign->deskripsi }}
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Donatur Terbaru ({{ $campaign->donations->count() }})</h5>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Donatur</th>
                                    <th>Jumlah</th>
                                    <th>Metode</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($campaign->donations->sortByDesc('created_at')->take(10) as $donation)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $donation->donor_name }}</div>
                                    </td>
                                    <td class="text-success fw-bold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                                    <td>{{ $donation->payment_method }}</td>
                                    <td>{{ $donation->created_at->format('d M Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            @if (Auth::check() && Auth::user()->role === 'admin' && $campaign->status === 'pending')
                <div class="card card-custom bg-warning-subtle border border-warning rounded-4 mb-4 sticky-top" style="top: 20px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-warning-emphasis"><i class="bi bi-patch-exclamation-fill"></i> Verifikasi Kampanye</h5>
                        <p class="small text-muted mb-4">Sebagai Administrator, Anda perlu meninjau dan menyetujui atau menolak kampanye ini agar dapat dipublikasikan.</p>
                        <form action="{{ route('campaign.verify', $campaign) }}" method="POST" class="d-flex gap-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="status" value="aktif" class="btn btn-success flex-grow-1 py-2 text-white">
                                <i class="bi bi-check-lg"></i> Setujui
                            </button>
                            <button type="submit" name="status" value="ditolak" class="btn btn-danger flex-grow-1 py-2 text-white">
                                <i class="bi bi-x-lg"></i> Tolak
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="card card-custom sticky-top" style="top: {{ Auth::check() && Auth::user()->role === 'admin' && $campaign->status === 'pending' ? '280px' : '20px' }};">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Progress Donasi</h4>
                    
                    <h2 class="text-success fw-bold mb-2">Rp {{ number_format($campaign->terkumpul, 0, ',', '.') }}</h2>
                    <p class="text-muted small">Terkumpul dari target Rp {{ number_format($campaign->target, 0, ',', '.') }}</p>
                    
                    <div class="progress mb-3" style="height: 15px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ min($campaign->getProgressPercentage(), 100) }}%">
                            {{ round($campaign->getProgressPercentage()) }}%
                        </div>
                    </div>
                    
                    <div class="row text-center mb-4">
                        <div class="col-6">
                            <div class="fw-bold fs-5">{{ $campaign->donations->count() }}</div>
                            <small class="text-muted">Donatur</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold fs-5">{{ $campaign->tanggal_selesai ? now()->diffInDays($campaign->tanggal_selesai) : '-' }}</div>
                            <small class="text-muted">Hari Lagi</small>
                        </div>
                    </div>
                    
                    @auth
                        <a href="{{ route('donation.create', ['campaign_id' => $campaign->id]) }}" class="btn btn-success w-100 py-3 fs-5 mb-3 text-white">
                            💚 Donasi Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success w-100 py-3 fs-5 mb-3 text-white">
                            Login untuk Berdonasi
                        </a>
                    @endauth
                    
                    <div class="text-center">
                        <small class="text-muted mb-2 d-block">Bagikan Kampanye</small>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 40px; height: 40px; padding: 7px;"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="btn btn-outline-info rounded-circle" style="width: 40px; height: 40px; padding: 7px;"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="btn btn-outline-success rounded-circle" style="width: 40px; height: 40px; padding: 7px;"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
