@extends('layouts.app')

@section('header', 'Kelola User')

@section('content')
<!-- STAT CARDS -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card stat-card h-100 bg-white border-0 shadow-sm rounded-4">
            <div class="card-body text-center p-4">
                <h2 class="text-primary fw-bold display-6 mb-1">{{ number_format($totalUsers, 0, ',', '.') }}</h2>
                <p class="text-muted mb-0 fw-semibold">Total User</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100 bg-white border-0 shadow-sm rounded-4">
            <div class="card-body text-center p-4">
                <h2 class="text-success fw-bold display-6 mb-1">{{ number_format($totalDonatur, 0, ',', '.') }}</h2>
                <p class="text-muted mb-0 fw-semibold">Donatur</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100 bg-white border-0 shadow-sm rounded-4">
            <div class="card-body text-center p-4">
                <h2 class="text-warning fw-bold display-6 mb-1">{{ number_format($totalFundraiser, 0, ',', '.') }}</h2>
                <p class="text-muted mb-0 fw-semibold">Fundraiser</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100 bg-white border-0 shadow-sm rounded-4">
            <div class="card-body text-center p-4">
                <h2 class="text-danger fw-bold display-6 mb-1">{{ number_format($totalAdmin, 0, ',', '.') }}</h2>
                <p class="text-muted mb-0 fw-semibold">Admin</p>
            </div>
        </div>
    </div>
</div>

<!-- FILTER & TABLE CARD -->
<div class="card card-custom border-0 shadow-sm rounded-4 p-4">
    <div class="card-body">
        <h4 class="fw-bold mb-4"><i class="bi bi-people text-success"></i> Manajemen Akun Pengguna</h4>
        
        <!-- SEARCH & FILTER FORM -->
        <form action="{{ route('admin.users') }}" method="GET" class="row g-3 mb-4">
            <div class="col-lg-6">
                <input type="text" name="search" class="form-control rounded-4 p-3 shadow-sm border-0 bg-light" placeholder="Cari user..." value="{{ $search }}">
            </div>
            <div class="col-lg-3">
                <select name="role" class="form-select rounded-4 p-3 shadow-sm border-0 bg-light">
                    <option value="Semua Role" {{ $role == 'Semua Role' || !$role ? 'selected' : '' }}>Semua Role</option>
                    <option value="Admin" {{ $role == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Fundraiser" {{ $role == 'Fundraiser' ? 'selected' : '' }}>Fundraiser</option>
                    <option value="Donatur" {{ $role == 'Donatur' ? 'selected' : '' }}>Donatur</option>
                </select>
            </div>
            <div class="col-lg-3">
                <button type="submit" class="btn btn-success w-100 p-3 rounded-4 shadow-sm fw-bold">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}" class="rounded-circle me-3" width="45" height="45" style="object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=198754&color=fff" class="rounded-circle me-3" width="45" height="45">
                                @endif
                                <span class="fw-bold text-dark">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-{{ $user->role === 'admin' ? 'dark' : ($user->role === 'fundraiser' ? 'success' : 'info') }} rounded-pill px-3 py-2">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $user->status === 'aktif' ? 'primary' : 'danger' }} rounded-pill px-3 py-2">
                                {{ $user->status === 'aktif' ? 'Aktif' : 'Suspended' }}
                            </span>
                        </td>
                        <td>
                            @if($user->id !== Auth::id())
                            <form action="{{ route('admin.user.toggle', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-{{ $user->status === 'aktif' ? 'danger' : 'success' }} btn-sm rounded-4 px-3 py-2 fw-semibold">
                                    {{ $user->status === 'aktif' ? 'Suspend' : 'Aktifkan' }}
                                </button>
                            </form>
                            @else
                            <span class="text-muted small italic"><i class="bi bi-person-fill-lock"></i> Akun Anda</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Tidak ada user ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- RECENT USER ACTIVITIES -->
<div class="card card-custom border-0 shadow-sm rounded-4 p-4 mt-4">
    <div class="card-body">
        <h4 class="fw-bold mb-3"><i class="bi bi-clock-history text-success"></i> Aktivitas User Terbaru</h4>
        <hr class="mb-4">
        <ul class="list-group list-group-flush">
            @forelse($recentActivities as $activity)
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0 border-bottom">
                    <span class="text-dark fw-medium">{{ $activity['text'] }}</span>
                    <span class="badge bg-light text-muted small rounded-pill px-3 py-2">{{ $activity['time'] }}</span>
                </li>
            @empty
                <li class="list-group-item text-center text-muted py-3">Belum ada aktivitas baru dari user.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection

