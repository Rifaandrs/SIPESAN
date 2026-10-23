@extends('layouts.app')

@section('title', 'Daftar Saran Masuk - Wakasek Humas')

@section('content')
<!-- Header Banner -->
<div class="page-header">
  <div>
    <h1 class="page-title">Saran Masuk</h1>
    <p class="page-subtitle">Daftar aspirasi, saran, dan kritik dari pihak eksternal SMPN 2 Purwakarta.</p>
  </div>
  <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
    <i class="bi bi-file-earmark-bar-graph me-1"></i> Rekap Laporan
  </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
  <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Filter Bar -->
<div class="card border-0 shadow-sm p-4 mb-4 bg-white">
  <form action="{{ route('admin.saran.index') }}" method="GET">
    <div class="row g-3 align-items-end">
      
      <!-- Search Input -->
      <div class="col-md-4">
        <label class="form-label small fw-semibold">Pencarian</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
          <input type="text" name="search" class="form-control border-start-0" 
                 placeholder="Kode, nama, atau judul..." value="{{ request('search') }}">
        </div>
      </div>

      <!-- Filter Status -->
      <div class="col-md-3">
        <label class="form-label small fw-semibold">Status</label>
        <select name="status" class="form-select">
          <option value="">Semua Status</option>
          <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
          <option value="Baru" {{ request('status') == 'Baru' ? 'selected' : '' }}>Baru</option>
          <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
          <option value="Sedang Diverifikasi" {{ request('status') == 'Sedang Diverifikasi' ? 'selected' : '' }}>Sedang Diverifikasi</option>
          <option value="Dalam Proses Tindak Lanjut" {{ request('status') == 'Dalam Proses Tindak Lanjut' ? 'selected' : '' }}>Dalam Proses Tindak Lanjut</option>
          <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
          <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
      </div>

      <!-- Filter Kategori -->
      <div class="col-md-3">
        <label class="form-label small fw-semibold">Kategori</label>
        <select name="category_id" class="form-select">
          <option value="">Semua Kategori</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
              {{ $cat->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Action Buttons -->
      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100">
          Filter
        </button>
        <a href="{{ route('admin.saran.index') }}" class="btn btn-light border" title="Reset">
          <i class="bi bi-arrow-repeat"></i>
        </a>
      </div>

    </div>
  </form>
</div>

<!-- Table Saran -->
<div class="card border-0 shadow-sm p-4 bg-white">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold font-display mb-0">Daftar Semua Saran ({{ $sarans->total() }})</h5>
  </div>

  <div class="table-responsive">
    <table class="table admin-data-table align-middle table-hover">
      <thead class="table-light">
        <tr>
          <th>Kode</th>
          <th>Pengirim</th>
          <th>Kategori</th>
          <th>Judul Saran</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sarans as $s)
        <tr>
          <td><strong class="text-primary">{{ $s->kode_saran }}</strong></td>
          <td>
            <div class="fw-semibold">{{ $s->nama_tampilan }}</div>
            <small class="badge bg-light text-dark border">{{ $s->status_pengirim }}</small>
          </td>
          <td>{{ $s->category->nama ?? '-' }}</td>
          <td>{{ Str::limit($s->judul, 35) }}</td>
          <td class="text-muted">{{ $s->created_at->format('d/m/Y') }}</td>
          <td>
            <span class="badge rounded-pill px-3 py-1 {{ $s->status_badge_class }}">
              {{ $s->status }}
            </span>
          </td>
          <td>
            <a href="{{ route('admin.saran.show', $s->id) }}" class="btn btn-sm btn-primary rounded-pill btn-saran-detail">
              Detail &amp; Tindak Lanjut
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center py-4 text-muted">Tidak ditemukan data saran dengan filter tersebut.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($sarans->hasPages())
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 pt-3 border-top small text-muted">
      <div>Menampilkan {{ $sarans->firstItem() }} sampai {{ $sarans->lastItem() }} dari total {{ $sarans->total() }} saran</div>
      <div>{{ $sarans->links() }}</div>
    </div>
  @endif
</div>
@endsection
