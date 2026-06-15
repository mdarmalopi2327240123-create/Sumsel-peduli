@extends('layouts.app')

@section('header', 'Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Daftar Kategori</h2>
    <a href="{{ route('category.create') }}" class="btn btn-success rounded-pill px-4">+ Tambah Kategori</a>
</div>

<div class="row g-3">
    @forelse($categories as $category)
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">{{ $category->nama }}</h5>
                        <small class="text-muted">{{ $category->campaigns_count }} Campaign</small>
                    </div>
                    <span style="font-size: 2rem;">{{ $category->icon }}</span>
                </div>
                <p class="text-muted small mb-3">{{ $category->deskripsi }}</p>
                <div class="d-flex gap-2">
                    <a href="{{ route('category.show', $category) }}" class="btn btn-sm btn-light flex-grow-1">Lihat</a>
                    <a href="{{ route('category.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('category.destroy', $category) }}" method="POST" style="display: inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">Tidak ada kategori</div>
    </div>
    @endforelse
</div>

{{ $categories->links() }}
@endsection
