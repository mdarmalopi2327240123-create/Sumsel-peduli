@extends('layouts.app')

@section('header', 'Edit Profil')

@section('content')
<div class="container-fluid mt-2">
    <div class="row g-4">
        <!-- Edit Profile Info -->
        <div class="col-lg-6">
            <div class="card card-custom border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-person-fill text-success"></i> Informasi Profil</h4>
                    <p class="text-muted small">Perbarui informasi profil akun dan alamat email Anda.</p>
                    <hr class="my-4">

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="mb-4 text-center">
                            @if($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" class="rounded-circle mb-3 shadow-sm" width="120" height="120" style="object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=198754&color=fff" class="rounded-circle mb-3 shadow-sm" width="120" height="120">
                            @endif
                            <div class="mt-2" style="max-width: 250px; margin: 0 auto;">
                                <label class="form-label fw-bold text-muted small d-block">Foto Profil</label>
                                <input type="file" name="foto" class="form-control form-control-sm rounded-3 mt-1" accept="image/*">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control rounded-4 p-3 border-0 bg-light @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Alamat Email</label>
                            <input type="email" name="email" class="form-control rounded-4 p-3 border-0 bg-light @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-3 rounded-4 fw-bold text-white shadow-sm">
                            <i class="bi bi-save"></i> Simpan Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-lg-6">
            <div class="card card-custom border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-shield-lock-fill text-success"></i> Perbarui Kata Sandi</h4>
                    <p class="text-muted small">Pastikan akun Anda menggunakan kata sandi yang aman untuk perlindungan maksimal.</p>
                    <hr class="my-4">

                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" class="form-control rounded-4 p-3 border-0 bg-light @error('current_password', 'updatePassword') is-invalid @enderror" placeholder="Masukkan kata sandi saat ini" required>
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Kata Sandi Baru</label>
                            <input type="password" name="password" class="form-control rounded-4 p-3 border-0 bg-light @error('password', 'updatePassword') is-invalid @enderror" placeholder="Masukkan kata sandi baru" required>
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" class="form-control rounded-4 p-3 border-0 bg-light @error('password_confirmation', 'updatePassword') is-invalid @enderror" placeholder="Ulangi kata sandi baru" required>
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-3 rounded-4 fw-bold text-white shadow-sm">
                            <i class="bi bi-key"></i> Ubah Kata Sandi
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Delete Account -->
        <div class="col-lg-12">
            <div class="card card-custom border-0 shadow-sm rounded-4 p-4 mb-4 bg-white border border-danger-subtle">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Hapus Akun</h4>
                    <p class="text-muted small">Setelah akun Anda dihapus, semua data akan dihapus secara permanen.</p>
                    <hr class="my-4">

                    <button class="btn btn-danger py-3 px-4 rounded-4 fw-bold text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="bi bi-trash"></i> Hapus Akun Saya
                    </button>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0">
                                <form method="post" action="{{ route('profile.destroy') }}">
                                    @csrf
                                    @method('delete')
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="fw-bold text-danger">Apakah Anda yakin?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <p class="text-muted small">Masukkan kata sandi Anda untuk konfirmasi.</p>
                                        <div class="mb-3">
                                            <input type="password" name="password" class="form-control rounded-4 p-3 border-0 bg-light" placeholder="Password Anda" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light border-0 justify-content-end gap-2 p-3">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger rounded-pill px-4 text-white">Hapus Akun</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
