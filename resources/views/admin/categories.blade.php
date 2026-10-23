@extends('layouts.app')

@section('title', 'Kategori Saran - Wakasek Humas')

@section('content')
<div class="page-header">
  <div>
    <h1 class="page-title">Kategori Saran</h1>
    <p class="page-subtitle">Kelola bidang dan kategori klasifikasi saran eksternal sekolah.</p>
  </div>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
    <i class="bi bi-arrow-left me-1"></i> Dashboard
  </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
  <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
  <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row g-4">
  
  <!-- Form Tambah Kategori -->
  <div class="col-lg-4">
    <div class="card border-0 shadow-sm p-4 bg-white">
      <h5 class="fw-bold font-display mb-3">Tambah Kategori Baru</h5>

      <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label class="form-label small fw-semibold" for="nama">Nama Kategori <span class="text-danger">*</span></label>
          <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh: Keamanan" required>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-semibold" for="deskripsi">Deskripsi</label>
          <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Penjelasan bidang saran..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-plus-lg me-1"></i> Simpan Kategori
        </button>
      </form>
    </div>
  </div>

  <!-- Tabel Daftar Kategori -->
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm p-4 bg-white">
      <h5 class="fw-bold font-display mb-3">Daftar Kategori Tersedia</h5>

      <div class="table-responsive">
        <table class="table admin-data-table align-middle">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Nama Kategori</th>
              <th>Deskripsi</th>
              <th>Jumlah Saran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $idx => $c)
            <tr>
              <td>{{ $categories->firstItem() + $idx }}</td>
              <td><strong class="text-primary">{{ $c->nama }}</strong></td>
              <td class="small text-muted">{{ $c->deskripsi ?? '-' }}</td>
              <td>
                <span class="badge bg-light text-dark border">{{ $c->sarans_count }} Saran</span>
              </td>
              <td>
                <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" {{ $c->sarans_count > 0 ? 'disabled' : '' }} title="Hapus">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-4 text-muted">Belum ada kategori.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($categories->hasPages())
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 pt-3 border-top small text-muted">
          <div>Menampilkan {{ $categories->firstItem() }} sampai {{ $categories->lastItem() }} dari total {{ $categories->total() }} kategori</div>
          <div>{{ $categories->links() }}</div>
        </div>
      @endif
    </div>
  </div>

</div>
@endsection
